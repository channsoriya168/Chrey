<?php

namespace Database\Seeders;

use App\Models\Product;
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
                'name' => 'Espresso',
                'slug' => 'espresso',
                'code' => 'PRD-001',
                'description' => 'កាហ្វេ Espresso ខ្លាំង មានរសជាតិក្រអូប',
                'price' => 3.50,
                'discount_price_percent' => 10,
                'stock' => 100,
                'size' => 'តូច',
                'image_url' => [
                    '/products/Espresso.png'
                ],
            ],
            [
                'name' => 'Latte',
                'slug' => 'latte',
                'code' => 'PRD-002',
                'description' => 'កាហ្វេ Latte ទន់ល្មើយ ជាមួយទឹកដោះគោ',
                'price' => 4.00,
                'discount_price_percent' => 5,
                'stock' => 80,
                'size' => 'មធ្យម',
                'image_url' => [
                    '/products/Latte.png'
                ],
            ],
            [
                'name' => 'Hot Coffee',
                'slug' => 'hot-coffee',
                'code' => 'PRD-003',
                'description' => 'កាហ្វេក្តៅ ធម្មតា',
                'price' => 2.50,
                'discount_price_percent' => null,
                'stock' => 120,
                'size' => 'មធ្យម',
                'image_url' => [
                    '/products/hot.png'
                ],
            ],
            [
                'name' => 'Hot Latte',
                'slug' => 'hot-latte',
                'code' => 'PRD-004',
                'description' => 'Latte ក្តៅ ជាមួយទឹកដោះគោ',
                'price' => 4.50,
                'discount_price_percent' => 15,
                'stock' => 90,
                'size' => 'មធ្យម',
                'image_url' => [
                    '/products/hot lata.png'
                ],
            ],
            [
                'name' => 'Coffee Special 01',
                'slug' => 'coffee-special-01',
                'code' => 'PRD-005',
                'description' => 'កាហ្វេពិសេស ស្រស់ស្រាយ',
                'price' => 5.00,
                'discount_price_percent' => 20,
                'stock' => 60,
                'size' => 'ធំ',
                'image_url' => [
                    '/products/01.png'
                ],
            ],
            [
                'name' => 'Coffee Special 02',
                'slug' => 'coffee-special-02',
                'code' => 'PRD-006',
                'description' => 'កាហ្វេពិសេស រសជាតិប្លែក',
                'price' => 5.50,
                'discount_price_percent' => null,
                'stock' => 70,
                'size' => 'ធំ',
                'image_url' => [
                    '/products/02.png'
                ],
            ],
        ];

        foreach ($products as $product) {

            // Use updateOrCreate to avoid duplicates (based on unique code)
            Product::updateOrCreate(
                ['code' => $product['code']],
                $product
            );
        }
    }
}
