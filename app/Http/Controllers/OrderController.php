<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\BakongService;
use App\Services\CurrencyService;
use App\Services\TelegramService;
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
     * Buy Now - Store product in session and redirect to checkout
     */
    public function buyNow(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        // Get the product and check stock
        $product = \App\Models\Product::findOrFail($validated['product_id']);

        if ($product->stock < $validated['quantity']) {
            return back()->with('error', 'Insufficient stock available');
        }

        // Store buy now data in session
        session()->put('buy_now', [
            'product_id' => $product->id,
            'quantity' => $validated['quantity'],
            'price' => $product->discount_price ?? $product->price,
        ]);

        // Redirect to login if not authenticated, otherwise go to checkout
        if (!auth()->check()) {
            return redirect()->route('login')->with('info', 'Please login to complete your purchase');
        }

        return redirect()->route('checkout.address');
    }

    /**
     * Show checkout address page
     */
    public function showAddressPage()
    {
        $this->transferGuestCartToUser();

        // Check if this is a buy now checkout
        $buyNowData = session()->get('buy_now');

        if ($buyNowData) {
            // Buy Now checkout - use session data
            $product = \App\Models\Product::findOrFail($buyNowData['product_id']);

            // Create a temporary cart item structure for the frontend
            $cartItems = collect([
                (object)[
                    'id' => null, // No cart item ID for buy now
                    'product_id' => $product->id,
                    'quantity' => $buyNowData['quantity'],
                    'price' => $buyNowData['price'],
                    'product' => $product,
                ]
            ]);

            $totalDollar = $buyNowData['price'] * $buyNowData['quantity'];
        } else {
            // Normal cart checkout
            $cart = $this->getUserActiveCart();

            if (!$cart || $cart->cartItems->isEmpty()) {
                return redirect()->route('cart.index')->with('error', 'Your cart is empty');
            }

            $cartItems = $cart->cartItems;
            $totalDollar = $this->calculateCartTotal($cart);
        }

        return inertia('Frontend/Checkout/Address', [
            'cartItems' => $cartItems,
            'total' => [
                'dollar' => $totalDollar,
                'riel' => CurrencyService::usdToKhr($totalDollar),
            ],
            'isBuyNow' => $buyNowData ? true : false,
        ]);
    }

    /**
     * Process checkout - Create address & generate KHQR code
     * Note: Order is NOT created yet, only after payment confirmation
     */
    public function checkout(Request $request)
    {
        // Validate address data
        $validated = $request->validate([
            'phone' => 'required|string|max:20',
            'province' => 'required|string|max:100',
            'district' => 'nullable|string|max:100',
            'commune' => 'nullable|string|max:100',
            'village' => 'nullable|string|max:100',
            'note' => 'nullable|string|max:500',
        ]);

        // Check if this is a buy now checkout
        $buyNowData = session()->get('buy_now');

        try {
            DB::beginTransaction();

            // Create address
            $address = Address::create([
                'user_id' => auth()->id(),
                'phone' => $validated['phone'],
                'province' => $validated['province'],
                'district' => $validated['district'] ?? null,
                'commune' => $validated['commune'] ?? null,
                'village' => $validated['village'] ?? null,
                'note' => $validated['note'] ?? null,
            ]);

            if ($buyNowData) {
                // Buy Now checkout - create temporary cart
                $cart = Cart::create([
                    'user_id' => auth()->id(),
                    'status' => 'active',
                ]);

                // Add the buy now item to the cart
                $cart->cartItems()->create([
                    'product_id' => $buyNowData['product_id'],
                    'quantity' => $buyNowData['quantity'],
                    'price' => $buyNowData['price'],
                ]);

                $totalAmount = $buyNowData['price'] * $buyNowData['quantity'];

                // Clear buy now session data
                session()->forget('buy_now');
            } else {
                // Normal cart checkout
                $cart = $this->getUserActiveCart();

                if (!$cart || $cart->cartItems->isEmpty()) {
                    return $this->jsonOrRedirect($request, false, 'Your cart is empty', 400);
                }

                $totalAmount = $this->calculateCartTotal($cart);
            }

            $khqrData = $this->generatePaymentQR($totalAmount);

            // Ensure QR data is a string
            $qrDataString = (string) $khqrData['qr'];
            $md5 = $khqrData['md5'] ?? null;

            // Update cart with address and md5
            $cart->update([
                'pending_address_id' => $address->id,
                'md5' => $md5,
            ]);

            DB::commit();

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

        // Verify md5 matches the cart's md5
        if ($cart->md5 !== $md5) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid payment reference'
            ], 400);
        }

        // Check if cart is already checked out (order completed)
        if ($cart->status === 'checked_out') {
            // Cart already processed, check if order exists
            $existingOrder = Order::where('bakong_transaction_id', $md5)->first();

            if ($existingOrder) {
                return response()->json([
                    'status' => 'paid',
                    'message' => 'Payment already processed',
                    'order_id' => $existingOrder->id,
                ]);
            }
        }

        $payment = $this->bakongService->checkPaymentStatus($md5);

        // ✅ SUCCESS
        if ($payment['status'] === 'success') {
            try {
                DB::beginTransaction();

                // Check if order already exists for this transaction (idempotency)
                $existingOrder = Order::where('bakong_transaction_id', $md5)->first();

                if ($existingOrder) {
                    DB::commit();
                    return response()->json([
                        'status' => 'paid',
                        'message' => 'Payment already processed',
                        'order_id' => $existingOrder->id,
                    ]);
                }

                // Get address from cart relationship
                $cart->load('pendingAddress');

                if (!$cart->pendingAddress) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Address data not found. Please start checkout again.'
                    ], 400);
                }

                $address = $cart->pendingAddress;
                $totalAmount = $this->calculateCartTotal($cart);

                // Create order
                $order = Order::create([
                    'user_id' => auth()->id(),
                    'order_number' => 'ORD-' . strtoupper(uniqid()),
                    'status' => 'paid',
                    'shipping_address_id' => $address->id,
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
                $cart->update(['status' => 'checked_out']);
                // Send Telegram notification
                app(TelegramService::class)->sendMessage(
                    "✅ <b>KHQR Payment Success</b>\n"
                        . "Order: #{$order->id}\n"
                        . "Amount: {$totalAmount} USD\n"
                        . "Phone: {$address->phone}\n"
                        . "Address: {$address->province}, {$address->district}, {$address->commune}, {$address->village}\n"
                        . ($address->note ? "Note: {$address->note}\n" : "")
                );

                DB::commit();

                return response()->json([
                    'status' => 'paid',
                    'message' => 'Payment successful',
                    'order_id' => $order->id,
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
