<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Services\CurrencyService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Get or create cart for current user or guest session
     */
    private function getCart()
    {
        if (auth()->check()) {
            return Cart::with(['cartItems.product'])
                ->where('user_id', auth()->id())
                ->where('status', 'active')
                ->first();
        } else {
            $sessionId = session()->getId();
            return Cart::with(['cartItems.product'])
                ->where('session_id', $sessionId)
                ->where('status', 'active')
                ->first();
        }
    }

    /**
     * Format cart items with product resources
     */
    private function formatCartItems($cartItems)
    {
        return $cartItems->map(function ($item) {
            $itemArray = $item->toArray();
            $itemArray['product'] = (new ProductResource($item->product))->resolve();
            return $itemArray;
        });
    }

    /**
     * Display the cart page
     */
    public function index()
    {
        $cart = $this->getCart();

        $cartItems = $cart ? $cart->cartItems : collect();
        $formattedCartItems = $this->formatCartItems($cartItems);

        $totalDollar = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        $totalRiel = CurrencyService::usdToKhr($totalDollar);

        return inertia('Frontend/Cart/Index', [
            'cartItems' => $formattedCartItems,
            'total' => [
                'dollar' => $totalDollar,
                'riel' => $totalRiel
            ],
            'discount' => 0,
            'count' => $cartItems->count()
        ]);
    }

    /**
     * Get cart items for API
     */
    public function getCartItems()
    {
        $cart = $this->getCart();

        $cartItems = $cart ? $cart->cartItems : collect([]);

        $totalDollar = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        $totalRiel = CurrencyService::usdToKhr($totalDollar);

        return response()->json([
            'cartItems' => $cartItems,
            'total' => [
                'dollar' => $totalDollar,
                'riel' => $totalRiel
            ],
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
            return back()->with('error', 'messages.cart.insufficient_stock');
        }

        // Find or create an active cart for authenticated user or guest
        if (auth()->check()) {
            $cart = Cart::firstOrCreate(
                [
                    'user_id' => auth()->id(),
                    'status' => 'active'
                ]
            );
        } else {
            $sessionId = session()->getId();
            $cart = Cart::firstOrCreate(
                [
                    'session_id' => $sessionId,
                    'status' => 'active'
                ]
            );
        }

        // Check if product already exists in cart
        $cartItem = $cart->cartItems()->where('product_id', $product->id)->first();

        if ($cartItem) {
            // Update quantity if product already exists
            $newQuantity = $cartItem->quantity + $validated['quantity'];

            if ($product->stock < $newQuantity) {
                return back()->with('error', 'messages.cart.stock_limit_reached');
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

        return back()->with('success', 'messages.cart.added');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $cartItem = CartItem::findOrFail($id);

        // Get the product to check stock
        $product = $cartItem->product;

        $validated = $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $product->stock
        ]);

        // Verify the cart item belongs to the user's or guest's cart
        if (auth()->check()) {
            if ($cartItem->cart->user_id !== auth()->id()) {
                abort(403);
            }
        } else {
            $sessionId = session()->getId();
            if ($cartItem->cart->session_id !== $sessionId) {
                abort(403);
            }
        }

        // Update quantity and refresh price from product
        $cartItem->update([
            'quantity' => $validated['quantity'],
            'price' => $product->discount_price ?? $product->price
        ]);

        // Redirect back - Inertia will automatically reload props from index()
        return redirect()->route('cart.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $cartItem = CartItem::findOrFail($id);

        // Verify the cart item belongs to the user's or guest's cart
        if (auth()->check()) {
            if ($cartItem->cart->user_id !== auth()->id()) {
                abort(403);
            }
        } else {
            $sessionId = session()->getId();
            if ($cartItem->cart->session_id !== $sessionId) {
                abort(403);
            }
        }

        $cartItem->delete();

        // Redirect back - Inertia will automatically reload props from index()
        return redirect()->route('cart.index');
    }
}
