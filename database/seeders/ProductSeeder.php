<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'iPhone 15 Pro Max',
                'description' => 'Latest flagship smartphone from Apple with titanium design and A17 Pro chip',
                'price' => 1199.99,
                'discount_price' => 1099.99,
                'quantity' => 50,
                'images' => [
                    'https://images.unsplash.com/photo-1592286927505-4464a0b51eeb?w=400',
                    'https://images.unsplash.com/photo-1510557880182-3d4d3cba35a5?w=400',
                ],
                'category_id' => Category::where('name', 'Electronics')->first()->id
            ],
            [
                'name' => 'Samsung Galaxy S24 Ultra',
                'description' => 'Premium Android smartphone with S Pen and advanced camera system',
                'price' => 1299.99,
                'discount_price' => 1199.99,
                'quantity' => 35,
                'images' => [
                    'https://images.unsplash.com/photo-1610945415295-d9bbf067e59c?w=400',
                ],

                'category_id' => Category::where('name', 'Electronics')->first()->id
            ],
            [
                'name' => 'MacBook Pro 16"',
                'description' => 'Powerful laptop with M3 Max chip for professionals',
                'price' => 2499.99,
                'discount_price' => null,
                'quantity' => 20,
                'images' => [
                    'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=400',
                    'https://images.unsplash.com/photo-1611186871348-b1ce696e52c9?w=400',
                ],
            ],
            [
                'name' => 'Sony WH-1000XM5',
                'description' => 'Premium noise-cancelling wireless headphones',
                'price' => 399.99,
                'discount_price' => 349.99,
                'quantity' => 100,
                'images' => [
                    'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=400',
                ],
            ],
            [
                'name' => 'iPad Pro 12.9"',
                'description' => 'Professional tablet with M2 chip and Liquid Retina XDR display',
                'price' => 1099.99,
                'discount_price' => 999.99,
                'quantity' => 45,
                'images' => [
                    'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?w=400',
                ],
            ],
            [
                'name' => 'Dell XPS 15',
                'description' => 'High-performance laptop for creators and developers',
                'price' => 1799.99,
                'discount_price' => null,
                'quantity' => 30,
                'images' => [
                    'https://images.unsplash.com/photo-1593642632823-8f785ba67e45?w=400',
                ],
            ],
            [
                'name' => 'Apple Watch Series 9',
                'description' => 'Advanced smartwatch with health monitoring features',
                'price' => 429.99,
                'discount_price' => 399.99,
                'quantity' => 75,
                'images' => [
                    'https://images.unsplash.com/photo-1579586337278-3befd40fd17a?w=400',
                    'https://images.unsplash.com/photo-1434494878577-86c23bcb06b9?w=400',
                ],
            ],
            [
                'name' => 'AirPods Pro 2',
                'description' => 'Premium wireless earbuds with active noise cancellation',
                'price' => 249.99,
                'discount_price' => 229.99,
                'quantity' => 150,
                'images' => [
                    'https://images.unsplash.com/photo-1572569511254-d8f925fe2cbb?w=400',
                ],
            ],
            [
                'name' => 'LG C3 OLED 55"',
                'description' => '4K OLED smart TV with stunning picture quality',
                'price' => 1499.99,
                'discount_price' => 1299.99,
                'quantity' => 25,
                'images' => [
                    'https://images.unsplash.com/photo-1593784991095-a205069470b6?w=400',
                ],
            ],
            [
                'name' => 'PlayStation 5',
                'description' => 'Next-gen gaming console with 4K gaming support',
                'price' => 499.99,
                'discount_price' => null,
                'quantity' => 60,
                'images' => [
                    'https://images.unsplash.com/photo-1606813907291-d86efa9b94db?w=400',
                ],
            ],
            [
                'name' => 'Nintendo Switch OLED',
                'description' => 'Portable gaming console with vibrant OLED screen',
                'price' => 349.99,
                'discount_price' => 329.99,
                'quantity' => 80,
                'images' => [
                    'https://images.unsplash.com/photo-1578303512597-81e6cc155b3e?w=400',
                ],
            ],
            [
                'name' => 'Canon EOS R6 Mark II',
                'description' => 'Professional mirrorless camera for photography enthusiasts',
                'price' => 2499.99,
                'discount_price' => null,
                'quantity' => 15,
                'images' => [
                    'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=400',
                    'https://images.unsplash.com/photo-1502920917128-1aa500764cbd?w=400',
                ],
            ],
            [
                'name' => 'Dyson V15 Detect',
                'description' => 'Cordless vacuum cleaner with laser dust detection',
                'price' => 749.99,
                'discount_price' => 699.99,
                'quantity' => 40,
                'images' => [
                    'https://images.unsplash.com/photo-1558317374-067fb5f30001?w=400',
                ],
            ],
            [
                'name' => 'Kindle Paperwhite',
                'description' => 'Waterproof e-reader with adjustable warm light',
                'price' => 139.99,
                'discount_price' => 119.99,
                'quantity' => 120,
                'images' => [
                    'https://images.unsplash.com/photo-1592496431122-2349e0fbc666?w=400',
                ],
            ],
            [
                'name' => 'Fitbit Charge 6',
                'description' => 'Advanced fitness tracker with heart rate monitoring',
                'price' => 159.99,
                'discount_price' => 139.99,
                'quantity' => 90,
                'images' => [
                    'https://images.unsplash.com/photo-1575311373937-040b8e1fd5b6?w=400',
                ],
            ],
        ];

        foreach ($products as $index => $productData) {
            Product::create([
                'name' => $productData['name'],
                'slug' => Str::slug($productData['name']),
                'code' => 'PRD-' . str_pad($index + 1, 5, '0', STR_PAD_LEFT),
                // store images as JSON string to match DB column (or model cast)
                'image_url' => json_encode($productData['images']),
                'description' => $productData['description'],
                'price' => $productData['price'],
                'discount_price' => $productData['discount_price'],
                'quantity' => $productData['quantity'],
                // ensure category_id is provided; fall back to 'Electronics' if not set
                'category_id' => $productData['category_id'] ?? Category::where('name', 'Electronics')->first()->id,
            ]);
        }
    }
}
