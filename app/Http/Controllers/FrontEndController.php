<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FrontEndController
{
    public function index()
    {
        $products = Product::paginate(10);

        return Inertia::render('Frontend/Index', [
            'products' => $products
        ]);
    }

    public function productDetail($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        // Get related products (random selection)
        $relatedProducts = Product::where('id', '!=', $product->id)
            ->inRandomOrder()
            ->limit(5)
            ->get();

        return Inertia::render('Frontend/ProductDetail', [
            'product' => $product,
            'relatedProducts' => $relatedProducts
        ]);
    }
}
