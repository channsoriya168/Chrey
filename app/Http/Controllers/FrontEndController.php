<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FrontEndController
{
    public function index()
    {
        $products = Product::with('ratings')->paginate(10);
        $products = ProductResource::collection($products);

        return Inertia::render('Frontend/Index', [
            'products' => $products
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
