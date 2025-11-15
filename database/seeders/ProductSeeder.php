<?php

namespace Database\Seeders;

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
            // Electronics Products
            [
                'name' => 'iPhone 15 Pro Max',
                'description' => 'Latest flagship smartphone from Apple with titanium design and A17 Pro chip',
                'price' => 1199.99,
                'discount_price_percent' => 8.33,
                'stock' => 50,
                'size' => 'តូច',
                'images' => [
                    'https://images.unsplash.com/photo-1592286927505-4464a0b51eeb?w=400',
                    'https://images.unsplash.com/photo-1510557880182-3d4d3cba35a5?w=400',
                ],
            ],
            [
                'name' => 'Samsung Galaxy S24 Ultra',
                'description' => 'Premium Android smartphone with S Pen and advanced camera system',
                'price' => 1299.99,
                'discount_price_percent' => 7.69,
                'stock' => 35,
                'size' => 'តូច',
                'images' => [
                    'https://images.unsplash.com/photo-1610945415295-d9bbf067e59c?w=400',
                ],
            ],
            [
                'name' => 'MacBook Pro 16"',
                'description' => 'Powerful laptop with M3 Max chip for professionals',
                'price' => 2499.99,
                'discount_price_percent' => null,
                'stock' => 20,
                'size' => 'ធំ',
                'images' => [
                    'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=400',
                    'https://images.unsplash.com/photo-1611186871348-b1ce696e52c9?w=400',
                ],
            ],
            [
                'name' => 'Sony WH-1000XM5',
                'description' => 'Premium noise-cancelling wireless headphones',
                'price' => 399.99,
                'discount_price_percent' => 12.50,
                'stock' => 100,
                'size' => 'មធ្យម',
                'images' => [
                    'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=400',
                ],
            ],
            [
                'name' => 'iPad Pro 12.9"',
                'description' => 'Professional tablet with M2 chip and Liquid Retina XDR display',
                'price' => 1099.99,
                'discount_price_percent' => 9.09,
                'stock' => 45,
                'size' => 'មធ្យម',
                'images' => [
                    'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?w=400',
                ],
            ],
            [
                'name' => 'PlayStation 5',
                'description' => 'Next-gen gaming console with 4K gaming support',
                'price' => 499.99,
                'discount_price_percent' => null,
                'stock' => 60,
                'size' => 'មធ្យម',
                'images' => [
                    'https://images.unsplash.com/photo-1606813907291-d86efa9b94db?w=400',
                ],
            ],
            [
                'name' => 'Canon EOS R6 Mark II',
                'description' => 'Professional mirrorless camera for photography enthusiasts',
                'price' => 2499.99,
                'discount_price_percent' => null,
                'stock' => 15,
                'size' => 'មធ្យម',
                'images' => [
                    'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=400',
                    'https://images.unsplash.com/photo-1502920917128-1aa500764cbd?w=400',
                ],
            ],

            // Fashion Products
            [
                'name' => 'Classic Leather Jacket',
                'description' => 'Premium genuine leather jacket with modern fit',
                'price' => 299.99,
                'discount_price_percent' => 16.67,
                'stock' => 45,
                'size' => 'មធ្យម',
                'images' => [
                    'https://images.unsplash.com/photo-1551028719-00167b16eac5?w=400',
                ],
            ],
            [
                'name' => 'Designer Sunglasses',
                'description' => 'UV protection sunglasses with polarized lenses',
                'price' => 179.99,
                'discount_price_percent' => 16.67,
                'stock' => 80,
                'size' => 'តូច',
                'images' => [
                    'https://images.unsplash.com/photo-1572635196237-14b3f281503f?w=400',
                ],
            ],
            [
                'name' => 'Cotton T-Shirt Pack',
                'description' => 'Set of 3 premium cotton t-shirts in various colors',
                'price' => 49.99,
                'discount_price_percent' => 20.00,
                'stock' => 150,
                'size' => 'មធ្យម',
                'images' => [
                    'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=400',
                ],
            ],
            [
                'name' => 'Running Sneakers',
                'description' => 'Lightweight running shoes with advanced cushioning',
                'price' => 129.99,
                'discount_price_percent' => null,
                'stock' => 70,
                'size' => 'មធ្យម',
                'images' => [
                    'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=400',
                ],
            ],
            [
                'name' => 'Denim Jeans',
                'description' => 'Classic fit denim jeans with stretch comfort',
                'price' => 89.99,
                'discount_price_percent' => 22.22,
                'stock' => 100,
                'size' => 'មធ្យម',
                'images' => [
                    'https://images.unsplash.com/photo-1542272604-787c3835535d?w=400',
                ],
            ],

            // Home & Living Products
            [
                'name' => 'Modern Coffee Table',
                'description' => 'Elegant wooden coffee table with minimalist design',
                'price' => 349.99,
                'discount_price_percent' => 14.29,
                'stock' => 30,
                'size' => 'ធំ',
                'images' => [
                    'https://images.unsplash.com/photo-1532372320572-cda25653a26d?w=400',
                ],
            ],
            [
                'name' => 'Luxury Bed Sheets Set',
                'description' => 'Egyptian cotton bed sheets set with 800 thread count',
                'price' => 129.99,
                'discount_price_percent' => 23.08,
                'stock' => 85,
                'size' => 'ធំ',
                'images' => [
                    'https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?w=400',
                ],
            ],
            [
                'name' => 'Decorative Wall Art',
                'description' => 'Contemporary canvas wall art for living room',
                'price' => 79.99,
                'discount_price_percent' => null,
                'stock' => 60,
                'size' => 'មធ្យម',
                'images' => [
                    'https://images.unsplash.com/photo-1513519245088-0e12902e5a38?w=400',
                ],
            ],
            [
                'name' => 'Aromatherapy Diffuser',
                'description' => 'Essential oil diffuser with LED mood lighting',
                'price' => 49.99,
                'discount_price_percent' => 20.00,
                'stock' => 120,
                'size' => 'តូច',
                'images' => [
                    'https://images.unsplash.com/photo-1608571423902-eed4a5ad8108?w=400',
                ],
            ],
            [
                'name' => 'Throw Pillow Set',
                'description' => 'Set of 4 decorative throw pillows with covers',
                'price' => 59.99,
                'discount_price_percent' => 16.67,
                'stock' => 95,
                'size' => 'មធ្យម',
                'images' => [
                    'https://images.unsplash.com/photo-1584100936595-c0654b55a2e2?w=400',
                ],
            ],
        ];

        foreach ($products as $index => $productData) {
            Product::create([
                'name' => $productData['name'],
                'slug' => Str::slug($productData['name']),
                'code' => 'PRD-' . str_pad($index + 1, 5, '0', STR_PAD_LEFT),
                'image_url' => $productData['images'],
                'description' => $productData['description'],
                'price' => $productData['price'],
                'discount_price_percent' => $productData['discount_price_percent'],
                'stock' => $productData['stock'],
                'size' => $productData['size'],
            ]);
        }
    }
}
