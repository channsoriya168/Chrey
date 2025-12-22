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
            'products' => $productsData
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
}
