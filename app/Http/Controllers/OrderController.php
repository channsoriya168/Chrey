<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of user orders.
     */
    public function index()
    {
        $orders = Order::with(['orderItems.product'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        // Calculate total for each order
        $orders->getCollection()->transform(function ($order) {
            $order->calculated_total = $order->orderItems->sum(function ($item) {
                return $item->total;
            });
            return $order;
        });

        return inertia('Orders/Index', [
            'orders' => $orders
        ]);
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        // Verify the order belongs to the user
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load(['user', 'orderItems.product']);

        // Calculate totals
        $itemsSubtotal = $order->orderItems->sum(function ($item) {
            return $item->subtotal;
        });

        $itemsTotal = $order->orderItems->sum(function ($item) {
            return $item->total;
        });

        return inertia('Orders/Show', [
            'order' => $order,
            'itemsSubtotal' => $itemsSubtotal,
            'itemsTotal' => $itemsTotal
        ]);
    }

    /**
     * Create order from cart (checkout)
     */
    public function checkout(Request $request)
    {
        // Only KHQR payment method is supported
        $request->validate([
            'payment_method' => 'required|in:khqr'
        ]);

        $cart = Cart::with(['cartItems.product'])
            ->where('user_id', auth()->id())
            ->where('status', 'pending')
            ->first();

        if (!$cart || $cart->cartItems->isEmpty()) {
            return back()->with('error', 'Your cart is empty');
        }

        // Verify stock availability for all items
        foreach ($cart->cartItems as $item) {
            if ($item->product->stock < $item->quantity) {
                return back()->with('error', "Insufficient stock for {$item->product->name}");
            }
        }

        try {
            DB::beginTransaction();

            // Calculate order totals
            $subtotal = $cart->cartItems->sum(function ($item) {
                return $item->price * $item->quantity;
            });

            // Create order with KHQR payment method
            $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => 'ORD-' . strtoupper(uniqid()),
                'status' => 'pending',
                'payment_status' => 'pending',
                'payment_method' => 'khqr',
                'subtotal' => $subtotal,
                'total_amount' => $subtotal,
            ]);

            // Create order items and update product stock
            foreach ($cart->cartItems as $cartItem) {
                $itemSubtotal = $cartItem->price * $cartItem->quantity;
                $itemDiscount = 0; // No discount for now
                $itemTotal = $itemSubtotal - $itemDiscount;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'product_name' => $cartItem->product->name,
                    'product_code' => $cartItem->product->code ?? 'N/A',
                    'quantity' => $cartItem->quantity,
                    'unit_price' => $cartItem->price,
                    'subtotal' => $itemSubtotal,
                    'discount' => $itemDiscount,
                    'total' => $itemTotal,
                ]);

                // Update product stock
                $cartItem->product->decrement('stock', $cartItem->quantity);
            }

            // Mark cart as completed
            $cart->update(['status' => 'completed']);

            DB::commit();

            // Redirect to KHQR payment page
            return redirect()->route('payment.khqr', $order->id);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Checkout failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Failed to place order: ' . $e->getMessage());
        }
    }
}