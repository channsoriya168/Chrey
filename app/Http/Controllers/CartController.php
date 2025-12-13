<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Get cart items for API
     */
    public function getCartItems()
    {
        $cart = Cart::with(['cartItems.product'])
            ->where('user_id', auth()->id())
            ->where('status', 'pending')
            ->first();

        $cartItems = $cart ? $cart->cartItems : [];

        $subtotal = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        return response()->json([
            'cartItems' => $cartItems,
            'subtotal' => $subtotal,
            'total' => $subtotal,
            'count' => $cartItems->count()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        // Get the product and check stock
        $product = Product::findOrFail($validated['product_id']);

        if ($product->stock < $validated['quantity']) {
            return back()->with('error', 'Insufficient stock available');
        }

        // Find or create a pending cart for the user
        $cart = Cart::firstOrCreate(
            [
                'user_id' => auth()->id(),
                'status' => 'pending'
            ]
        );

        // Check if product already exists in cart
        $cartItem = $cart->cartItems()->where('product_id', $product->id)->first();

        if ($cartItem) {
            // Update quantity if product already exists
            $newQuantity = $cartItem->quantity + $validated['quantity'];

            if ($product->stock < $newQuantity) {
                return back()->with('error', 'Cannot add more items. Stock limit reached.');
            }

            $cartItem->update([
                'quantity' => $newQuantity,
                'price' => $product->discount_price ?? $product->price
            ]);
        } else {
            // Create new cart item
            $cart->cartItems()->create([
                'product_id' => $product->id,
                'quantity' => $validated['quantity'],
                'price' => $product->discount_price ?? $product->price
            ]);
        }

        return back()->with('success', 'Product added to cart successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cartItem = CartItem::findOrFail($id);

        // Verify the cart item belongs to the user's cart
        if ($cartItem->cart->user_id !== auth()->id()) {
            abort(403);
        }

        // Check stock availability
        if ($cartItem->product->stock < $validated['quantity']) {
            return back()->with('error', 'Insufficient stock available');
        }

        $cartItem->update([
            'quantity' => $validated['quantity']
        ]);

        return back()->with('success', 'Cart updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $cartItem = CartItem::findOrFail($id);

        // Verify the cart item belongs to the user's cart
        if ($cartItem->cart->user_id !== auth()->id()) {
            abort(403);
        }

        $cartItem->delete();

        return back()->with('success', 'Item removed from cart successfully!');
    }
}
