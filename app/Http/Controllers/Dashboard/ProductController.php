<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);

        return inertia('Dashboard/Products/Index', [
            // Lazy evaluation - only loaded when requested
            'products' => fn () => QueryBuilder::for(Product::class)
                ->allowedFilters([
                    AllowedFilter::callback('search', function ($query, $value) {
                        $query->where('name', 'like', "%{$value}%");
                    }),
                ])
                ->latest()
                ->paginate($perPage)
                ->withQueryString(),

            // Filters are always included
            'filters' => [
                'search' => $request->input('filter.search', ''),
                'per_page' => $perPage,
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Dashboard/Products/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();

        $product = new Product();
        $product->name = $validated['name']; 
        $product->slug = Str::uuid();
        $product->code = $validated['code'];
        $product->description = $validated['description'] ?? null;
        $product->price = $validated['price'];
        $product->discount_price_percent = $validated['discount_price_percent'] ?? null;
        $product->stock = $validated['stock'];
        $product->size = $validated['size'];

        // Handle multiple images
        if ($request->hasFile('images')) {
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('products', 'public');
            }
            $product->image_url = $imagePaths;
        }

        $product->save();

        return redirect()->route('dashboard.products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return inertia('Dashboard/Products/Show', [
            'product' => $product
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * 
     */
    public function edit(Product $product)
    {
        return inertia('Dashboard/Products/Edit', [
            'product' => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $validated = $request->validated();

        $product->name = $validated['name'];
        $product->code = $validated['code'];
        $product->description = $validated['description'] ?? null;
        $product->price = $validated['price'];
        $product->discount_price_percent = $validated['discount_price_percent'] ?? null;
        $product->stock = $validated['stock'];
        $product->size = $validated['size'];

        // Handle images - merge existing and new images
        $existingImages = $validated['existing_images'] ?? [];
        $imagePaths = $existingImages; // Start with existing images that weren't deleted

        // Delete images that were removed (old images not in existing_images)
        if ($product->image_url && is_array($product->image_url)) {
            foreach ($product->image_url as $oldImage) {
                if (!in_array($oldImage, $existingImages)) {
                    // This image was deleted, remove it from storage
                    if (Storage::disk('public')->exists($oldImage)) {
                        Storage::disk('public')->delete($oldImage);
                    }
                }
            }
        }

        // Add new uploaded images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('products', 'public');
            }
        }

        $product->image_url = $imagePaths;
        $product->save();

        return redirect()->route('dashboard.products.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Delete associated images if exists
        if ($product->image_url && is_array($product->image_url)) {
            foreach ($product->image_url as $image) {
                if (Storage::disk('public')->exists($image)) {
                    Storage::disk('public')->delete($image);
                }
            }
        }

        $product->delete();

        return redirect()->route('dashboard.products.index')->with('success', 'Product deleted successfully.');
    }
}
