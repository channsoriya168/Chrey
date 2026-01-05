<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FrontEndController
{
    public function index(Request $request)
    {
        $products = Product::with('ratings')->paginate(10);

        // Structure the product data with pagination metadata
        $productsData = [
            'data' => ProductResource::collection($products->items())->resolve(),
            'current_page' => $products->currentPage(),
            'last_page' => $products->lastPage(),
            'per_page' => $products->perPage(),
            'total' => $products->total(),
            'next_page_url' => $products->nextPageUrl(),
            'prev_page_url' => $products->previousPageUrl(),
        ];

        // Fetch products with discounts separately (only 4 for homepage)
        $discountProducts = Product::with('ratings')
            ->where(function ($query) {
                $query->whereNotNull('discount_price')
                    ->whereColumn('discount_price', '<', 'price');
            })
            ->orderBy('discount_price_percent', 'desc')
            ->limit(4)
            ->get();

        // If it's an AJAX request (for infinite scroll), return JSON
        // But exclude Inertia requests - they need Inertia responses
        if (($request->wantsJson() || $request->ajax()) && !$request->header('X-Inertia')) {
            return response()->json([
                'props' => [
                    'products' => $productsData
                ]
            ]);
        }

        // Regular request, return Inertia view
        return Inertia::render('Frontend/Index', [
            'products' => $productsData,
            'discountProducts' => ProductResource::collection($discountProducts)->resolve()
        ]);
    }


    public function productDetail($slug)
    {
        $product = Product::with('ratings')->where('slug', $slug)->firstOrFail();

        $relatedProducts = Product::with('ratings')
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->limit(5)
            ->get();
        $product = new ProductResource($product);

        return Inertia::render('Frontend/ProductDetail', [
            'product' => $product,
            'relatedProducts' => ProductResource::collection($relatedProducts)->resolve()
        ]);
    }

    public function discountProducts(Request $request)
    {
        // Fetch all products with discounts
        $discountProducts = Product::with('ratings')
            ->where(function ($query) {
                $query->whereNotNull('discount_price')
                    ->whereColumn('discount_price', '<', 'price');
            })
            ->orderBy('discount_price_percent', 'desc')
            ->paginate(10);

        // Structure the product data with pagination metadata
        $productsData = [
            'data' => ProductResource::collection($discountProducts->items())->resolve(),
            'current_page' => $discountProducts->currentPage(),
            'last_page' => $discountProducts->lastPage(),
            'per_page' => $discountProducts->perPage(),
            'total' => $discountProducts->total(),
            'next_page_url' => $discountProducts->nextPageUrl(),
            'prev_page_url' => $discountProducts->previousPageUrl(),
        ];

        // If it's an AJAX request (for infinite scroll), return JSON
        // But exclude Inertia requests - they need Inertia responses
        if (($request->wantsJson() || $request->ajax()) && !$request->header('X-Inertia')) {
            return response()->json([
                'props' => [
                    'products' => $productsData
                ]
            ]);
        }

        return Inertia::render('Frontend/DiscountProducts', [
            'products' => $productsData
        ]);
    }
}
