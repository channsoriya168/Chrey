<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Address;
use App\Services\BakongService;
use App\Services\CurrencyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * OrderController
 *
 * Handles the complete order lifecycle:
 * 1. Checkout Flow - Address collection & KHQR generation
 * 2. Payment Processing - Payment verification & order creation
 * 3. Order Management - Viewing orders and details
 */
class OrderController extends Controller
{
    protected $bakongService;

    public function __construct(BakongService $bakongService)
    {
        $this->bakongService = $bakongService;
    }

    // ============================================================================
    // ORDER MANAGEMENT - View orders and details
    // ============================================================================

    /**
     * Display list of user orders
     */
    public function index()
    {
        $orders = Order::with(['orderItems.product', 'shippingAddress'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        $orders->getCollection()->transform(function ($order) {
            $order->calculated_total = $order->orderItems->sum(fn($item) => $item->total);
            return $order;
        });

        return inertia('Orders/Index', ['orders' => $orders]);
    }

    /**
     * Display order details
     */
    public function show(Order $order)
    {
        $this->authorizeOrderAccess($order);

        $order->load(['user', 'orderItems.product', 'shippingAddress']);

        return inertia('Orders/Show', [
            'order' => $order,
            'itemsSubtotal' => $order->orderItems->sum(fn($item) => $item->subtotal),
            'itemsTotal' => $order->orderItems->sum(fn($item) => $item->total),
        ]);
    }

    // ============================================================================
    // CHECKOUT FLOW - Address collection & payment preparation
    // ============================================================================

    /**
     * Show checkout address page
     */
    public function showAddressPage()
    {
        $this->transferGuestCartToUser();

        $cart = $this->getUserActiveCart();

        if (!$cart || $cart->cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        $totalDollar = $this->calculateCartTotal($cart);

        return inertia('Frontend/Checkout/Address', [
            'cartItems' => $cart->cartItems,
            'total' => [
                'dollar' => $totalDollar,
                'riel' => CurrencyService::usdToKhr($totalDollar),
            ],
        ]);
    }

    /**
     * Process checkout - Create address & generate KHQR code
     * Note: Order is NOT created yet, only after payment confirmation
     */
    public function checkout(Request $request)
    {
        $cart = $this->getUserActiveCart();

        if (!$cart || $cart->cartItems->isEmpty()) {
            return $this->jsonOrRedirect($request, false, 'Your cart is empty', 400);
        }

        $stockValidation = $this->validateCartStock($cart);
        if ($stockValidation !== true) {
            return $this->jsonOrRedirect($request, false, $stockValidation, 400);
        }

        try {
            DB::beginTransaction();

            $totalAmount = $this->calculateCartTotal(cart: $cart);
            $khqrData = $this->generatePaymentQR($totalAmount);

            DB::commit();

            // Ensure QR data is a string
            $qrDataString = (string) $khqrData['qr'];
            $md5 = $khqrData['md5'] ?? null;

            return response()->json([
                'success' => true,
                'cart' => [
                    'id' => $cart->id,
                    'total_amount' => $totalAmount,
                ],
                'md5' => $md5,
                'qrData' => $qrDataString,
                'message' => 'Ready for payment'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return $this->jsonOrRedirect($request, false, 'Failed to prepare payment. Please try again.', 500);
        }
    }

    // ============================================================================
    // PAYMENT PROCESSING - Verify payment & create order
    // ============================================================================

    /**
     * Check payment status and create order if paid
     */
    public function checkPaymentStatus(Cart $cart, Request $request)
    {
        $this->authorizeCartAccess($cart);

        $md5 = $request->query('md5');

        if (!$md5) {
            return response()->json([
                'status' => 'error',
                'message' => 'MD5 is required'
            ], 400);
        }

        $payment = $this->bakongService->checkPaymentStatus($md5);

        // ✅ SUCCESS
        if ($payment['status'] === 'success') {
            try {
                DB::beginTransaction();

                // Create order
                $order = Order::create([
                    'user_id' => auth()->id(),
                    'order_number' => 'ORD-' . strtoupper(uniqid()),
                    'status' => 'pending',
                    'bakong_transaction_id' => $md5,
                ]);

                // Create order items and update stock
                foreach ($cart->cartItems as $cartItem) {
                    // Create order item
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $cartItem->product_id,
                        'quantity' => $cartItem->quantity,
                        'price' => $cartItem->price,
                        'total' => $cartItem->price * $cartItem->quantity,
                    ]);

                    // Update product stock
                    $cartItem->product->decrement('stock', $cartItem->quantity);
                }

                // Clear cart
                $cart->cartItems()->delete();
                $cart->update(['status' => 'completed']);

                DB::commit();

                return response()->json([
                    'status' => 'success',
                    'message' => 'Payment successful',
                    'order_id' => $order->id,
                    'redirect' => route('orders.show', $order)
                ]);
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Order creation failed: ' . $e->getMessage());

                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to create order. Please contact support.'
                ], 500);
            }
        }

        // ⏳ PENDING
        if ($payment['status'] === 'pending') {
            return response()->json([
                'status' => 'pending',
                'message' => 'Waiting for payment'
            ]);
        }

        // ❌ FAILED
        return response()->json([
            'status' => 'failed',
            'message' => 'Payment failed'
        ]);
    }



    // ============================================================================
    // HELPER METHODS - Private utilities
    // ============================================================================

    /**
     * Transfer guest cart to authenticated user
     */
    private function transferGuestCartToUser()
    {
        if (!auth()->check()) {
            return;
        }

        $guestCart = Cart::with('cartItems')
            ->where('session_id', session()->getId())
            ->where('status', 'active')
            ->first();

        if (!$guestCart || $guestCart->cartItems->isEmpty()) {
            return;
        }

        $userCart = Cart::firstOrCreate([
            'user_id' => auth()->id(),
            'status' => 'active'
        ]);

        foreach ($guestCart->cartItems as $guestItem) {
            $existingItem = $userCart->cartItems()
                ->where('product_id', $guestItem->product_id)
                ->first();

            if ($existingItem) {
                $existingItem->update([
                    'quantity' => $existingItem->quantity + $guestItem->quantity,
                    'price' => $guestItem->price
                ]);
            } else {
                $guestItem->update(['cart_id' => $userCart->id]);
            }
        }

        $guestCart->cartItems()->delete();
        $guestCart->delete();
    }

    /**
     * Get current user's active cart
     */
    private function getUserActiveCart()
    {
        return Cart::with('cartItems.product')
            ->where('user_id', auth()->id())
            ->where('status', 'active')
            ->first();
    }

    /**
     * Calculate cart total amount
     */
    private function calculateCartTotal(Cart $cart)
    {
        return $cart->cartItems->sum(fn($item) => $item->price * $item->quantity);
    }


    /**
     * Validate cart stock availability
     */
    private function validateCartStock(Cart $cart)
    {
        foreach ($cart->cartItems as $item) {
            if ($item->product->stock < $item->quantity) {
                return "Insufficient stock for {$item->product->name}. Available: {$item->product->stock}, Required: {$item->quantity}";
            }
        }
        return true;
    }



    /**
     * Generate KHQR payment code
     */
    private function generatePaymentQR(float $amount)
    {
        $khqrData = $this->bakongService->generateKHQR([
            'amount' => $amount,
        ]);

        if (!$khqrData || !isset($khqrData['qr'])) {
            throw new \Exception('Failed to generate KHQR code');
        }

        return $khqrData;
    }

    /**
     * Authorize order access
     */
    private function authorizeOrderAccess(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }
    }

    /**
     * Authorize cart access
     */
    private function authorizeCartAccess(Cart $cart)
    {
        if ($cart->user_id !== auth()->id()) {
            abort(403);
        }
    }

    /**
     * Return JSON or redirect response based on request type
     */
    private function jsonOrRedirect(Request $request, bool $success, string $message, int $statusCode = 200)
    {
        $wantsJson = $request->wantsJson() || $request->expectsJson() || $request->ajax();

        if ($wantsJson) {
            return response()->json([
                'success' => $success,
                'message' => $message
            ], $statusCode);
        }

        return $success
            ? back()->with('success', $message)
            : back()->with('error', $message);
    }
}
