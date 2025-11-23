<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Cart::with(['user', 'cartItems.product'])
            ->latest();

        // Search filter
        if ($request->has('filter.search') && $request->input('filter.search')) {
            $search = $request->input('filter.search');
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->has('filter.status') && $request->input('filter.status')) {
            $query->where('status', $request->input('filter.status'));
        }

        $perPage = $request->input('per_page', 10);
        $carts = $query->paginate($perPage);

        // Calculate subtotal and total for each cart
        $carts->getCollection()->transform(function ($cart) {
            $subtotal = $cart->cartItems->sum(function ($item) {
                return $item->price * $item->quantity;
            });
            $cart->subtotal = $subtotal;
            $cart->total = $subtotal;
            $cart->items_count = $cart->cartItems->count();
            return $cart;
        });

        return inertia('Dashboard/Carts/Index', [
            'carts' => $carts,
            'filters' => [
                'search' => $request->input('filter.search'),
                'status' => $request->input('filter.status'),
                'per_page' => $perPage
            ]
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        $cart->load(['user', 'cartItems.product']);

        // Calculate subtotal and total
        $subtotal = $cart->cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        return inertia('Dashboard/Carts/Show', [
            'cart' => $cart,
            'subtotal' => $subtotal,
            'total' => $subtotal
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        $cart->cartItems()->delete();
        $cart->delete();

        return redirect()->route('dashboard.carts.index')
            ->with('success', 'Cart deleted successfully!');
    }
}