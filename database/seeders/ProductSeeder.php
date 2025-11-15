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
        // Get category IDs
        $electronicsId = Category::where('slug', 'electronics')->first()->id;
        $fashionId = Category::where('slug', 'fashion')->first()->id;
        $homeLivingId = Category::where('slug', 'home-living')->first()->id;

        $products = [
            // Electronics Products
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
                'category_id' => $electronicsId
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
                'category_id' => $electronicsId
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
                'category_id' => $electronicsId
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
                'category_id' => $electronicsId
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
                'category_id' => $electronicsId
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
                'category_id' => $electronicsId
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
                'category_id' => $electronicsId
            ],

            // Fashion Products
            [
                'name' => 'Classic Leather Jacket',
                'description' => 'Premium genuine leather jacket with modern fit',
                'price' => 299.99,
                'discount_price' => 249.99,
                'quantity' => 45,
                'images' => [
                    'https://images.unsplash.com/photo-1551028719-00167b16eac5?w=400',
                ],
                'category_id' => $fashionId
            ],
            [
                'name' => 'Designer Sunglasses',
                'description' => 'UV protection sunglasses with polarized lenses',
                'price' => 179.99,
                'discount_price' => 149.99,
                'quantity' => 80,
                'images' => [
                    'https://images.unsplash.com/photo-1572635196237-14b3f281503f?w=400',
                ],
                'category_id' => $fashionId
            ],
            [
                'name' => 'Cotton T-Shirt Pack',
                'description' => 'Set of 3 premium cotton t-shirts in various colors',
                'price' => 49.99,
                'discount_price' => 39.99,
                'quantity' => 150,
                'images' => [
                    'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=400',
                ],
                'category_id' => $fashionId
            ],
            [
                'name' => 'Running Sneakers',
                'description' => 'Lightweight running shoes with advanced cushioning',
                'price' => 129.99,
                'discount_price' => null,
                'quantity' => 70,
                'images' => [
                    'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=400',
                ],
                'category_id' => $fashionId
            ],
            [
                'name' => 'Denim Jeans',
                'description' => 'Classic fit denim jeans with stretch comfort',
                'price' => 89.99,
                'discount_price' => 69.99,
                'quantity' => 100,
                'images' => [
                    'https://images.unsplash.com/photo-1542272604-787c3835535d?w=400',
                ],
                'category_id' => $fashionId
            ],

            // Home & Living Products
            [
                'name' => 'Modern Coffee Table',
                'description' => 'Elegant wooden coffee table with minimalist design',
                'price' => 349.99,
                'discount_price' => 299.99,
                'quantity' => 30,
                'images' => [
                    'https://images.unsplash.com/photo-1532372320572-cda25653a26d?w=400',
                ],
                'category_id' => $homeLivingId
            ],
            [
                'name' => 'Luxury Bed Sheets Set',
                'description' => 'Egyptian cotton bed sheets set with 800 thread count',
                'price' => 129.99,
                'discount_price' => 99.99,
                'quantity' => 85,
                'images' => [
                    'https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?w=400',
                ],
                'category_id' => $homeLivingId
            ],
            [
                'name' => 'Decorative Wall Art',
                'description' => 'Contemporary canvas wall art for living room',
                'price' => 79.99,
                'discount_price' => null,
                'quantity' => 60,
                'images' => [
                    'https://images.unsplash.com/photo-1513519245088-0e12902e5a38?w=400',
                ],
                'category_id' => $homeLivingId
            ],
            [
                'name' => 'Aromatherapy Diffuser',
                'description' => 'Essential oil diffuser with LED mood lighting',
                'price' => 49.99,
                'discount_price' => 39.99,
                'quantity' => 120,
                'images' => [
                    'https://images.unsplash.com/photo-1608571423902-eed4a5ad8108?w=400',
                ],
                'category_id' => $homeLivingId
            ],
            [
                'name' => 'Throw Pillow Set',
                'description' => 'Set of 4 decorative throw pillows with covers',
                'price' => 59.99,
                'discount_price' => 49.99,
                'quantity' => 95,
                'images' => [
                    'https://images.unsplash.com/photo-1584100936595-c0654b55a2e2?w=400',
                ],
                'category_id' => $homeLivingId
            ],
        ];

        foreach ($products as $index => $productData) {
            Product::create([
                'name' => $productData['name'],
                'slug' => Str::slug($productData['name']),
                'code' => 'PRD-' . str_pad($index + 1, 5, '0', STR_PAD_LEFT),
                'image_url' => json_encode($productData['images']),
                'description' => $productData['description'],
                'price' => $productData['price'],
                'discount_price' => $productData['discount_price'],
                'quantity' => $productData['quantity'],
                'category_id' => $productData['category_id'],
            ]);
        }
    }
}
