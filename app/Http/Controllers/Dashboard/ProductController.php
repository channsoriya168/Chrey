<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
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
                        $query->where(function ($q) use ($value) {
                            $q->where('name', 'like', "%{$value}%")
                              ->orWhere('code', 'like', "%{$value}%")
                              ->orWhere('description', 'like', "%{$value}%");
                        });
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
        return inertia('Dashboard/Product/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:products,code',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'discount_price_percent' => 'nullable|numeric|min:0|max:100',
            'stock' => 'required|integer|min:0',
            'size' => 'required|in:តូច,មធ្យម,ធំ',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->slug = Str::uuid();
        $product->code = $request->code;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->discount_price_percent = $request->discount_price_percent;
        $product->stock = $request->stock;
        $product->size = $request->size;

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
        //
    }

    /**
     * Show the form for editing the specified resource.
     * 
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:products,code,' . $product->id,
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'discount_price_percent' => 'nullable|numeric|min:0|max:100',
            'stock' => 'required|integer|min:0',
            'size' => 'required|in:តូច,មធ្យម,ធំ',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'existing_images' => 'nullable|array',
        ]);

        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->code = $request->code;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->discount_price_percent = $request->discount_price_percent;
        $product->stock = $request->stock;
        $product->size = $request->size;

        // Handle images - merge existing and new images
        $existingImages = $request->input('existing_images', []);
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
