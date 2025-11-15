<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FrontEndController
{
    public function index()
    {
        $categories = Category::all();
        $products = Product::with('category')->paginate(10);

        return Inertia::render('Frontend/Index', [
            'categories' => $categories,
            'products' => $products
        ]);
    }

    public function productDetail($slug)
    {
        $product = Product::with('category')->where('slug', $slug)->firstOrFail();

        // Get related products from the same category
        $relatedProducts = Product::with('category')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->limit(5)
            ->get();

        return Inertia::render('Frontend/ProductDetail', [
            'product' => $product,
            'relatedProducts' => $relatedProducts
        ]);
    }
}
