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
            $order->total = $order->orderItems->sum(function ($item) {
                return $item->price * $item->quantity;
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

        // Calculate subtotal and total
        $subtotal = $order->orderItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        return inertia('Orders/Show', [
            'order' => $order,
            'subtotal' => $subtotal,
            'total' => $subtotal
        ]);
    }

    /**
     * Create order from cart (checkout)
     */
    public function checkout()
    {
        $cart = Cart::with(['cartItems.product'])
            ->where('user_id', auth()->id())
            ->where('status', 'pending')
            ->first();

        if (!$cart || $cart->cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty');
        }

        // Verify stock availability for all items
        foreach ($cart->cartItems as $item) {
            if ($item->product->stock < $item->quantity) {
                return redirect()->route('cart.index')
                    ->with('error', "Insufficient stock for {$item->product->name}");
            }
        }

        try {
            DB::beginTransaction();

            // Create order
            $order = Order::create([
                'user_id' => auth()->id(),
                'status' => 'pending',
                'payment_status' => 'pending',
                'payment_method' => 'cash', // Default for now
            ]);

            // Create order items and update product stock
            foreach ($cart->cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->price
                ]);

                // Update product stock
                $cartItem->product->decrement('stock', $cartItem->quantity);
            }

            // Mark cart as completed
            $cart->update(['status' => 'completed']);

            DB::commit();

            return redirect()->route('orders.show', $order->id)
                ->with('success', 'Order placed successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('cart.index')
                ->with('error', 'Failed to place order. Please try again.');
        }
    }
}