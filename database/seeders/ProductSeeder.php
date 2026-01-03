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
                'name' => 'កញ្ជើឬស្សី',
                'slug' => 'kanhjer-roussey',
                'code' => 'PRD-001',
                'description' => 'កញ្ជើឬស្សីស្អាត គុណភាពល្អ ត្បាយពីរឬស្សីសុទ្ធនិងរឹតកណ្តាប់ពោះត្នោត!!!',
                'price' => 3,
                'discount_price_percent' => 10,
                'stock' => 10,
                'size' => 'ធំ',
                'image_url' => [
                    '/storage/products/01.png'
                ],
            ],
            [
                'name' => 'កញ្រ្ជែងឬស្សី',
                'slug' => 'kanhrey-roussey',
                'code' => 'PRD-002',
                'description' => 'កញ្រ្ជែងឬស្សីស្អាត គុណភាពល្អ ពណ៌ស្រស់ស្អាត',
                'price' => 2.00,
                'discount_price_percent' => null,
                'stock' => 7,
                'size' => 'មធ្យម',
                'image_url' => [
                    '/storage/products/fn-2020-02-07-15-09-27-5.jpg'
                ],
            ],
            [
                'name' => 'កញ្ជើឬស្សី',
                'slug' => 'kanhjer-roussey2',
                'code' => 'PRD-003',
                'description' => 'កញ្ជើឬស្សីស្អាត គុណភាពល្អ ត្បាយពីរឬស្សីសុទ្ធនិងរឹតកណ្តាប់ពោះត្នោត!!!',
                'price' => 3,
                'discount_price_percent' => 10,
                'stock' => 10,
                'size' => 'ធំ',
                'image_url' => [
                    '/storage/products/02.png'
                ],
            ],
            [
                'name' => 'កញ្ជើឬស្សី',
                'slug' => 'kanhjer-roussey3',
                'code' => 'PRD-004',
                'description' => 'កញ្ជើឬស្សីស្អាត គុណភាពល្អ ត្បាយពីរឬស្សីសុទ្ធនិងរឹតកណ្តាប់ពោះត្នោត!!!',
                'price' => 3,
                'discount_price_percent' => null,
                'stock' => 10,
                'size' => 'ធំ',
                'image_url' => [
                    '/storage/products/01.png',
                    '/storage/products/02.png'
                ],
            ],
            [
                'name' => 'កញ្រ្ជែងឬស្សី',
                'slug' => 'kanhrey-roussey2',
                'code' => 'PRD-005',
                'description' => 'កញ្រ្ជែងឬស្សីគុណភាពល្អ ពណ៌ស្រស់ស្អាត សម្រាប់ប្រើប្រាស់ប្រចាំថ្ងៃ',
                'price' => 2.00,
                'discount_price_percent' => null,
                'stock' => 7,
                'size' => 'មធ្យម',
                'image_url' => [
                    '/storage/products/fn-2020-02-07-15-09-27-5.jpg',
                    '/storage/products/02.png',
                    '/storage/products/01.png'
                ],
            ],
            [
                'name' => 'កញ្រ្ជែងឬស្សី',
                'slug' => 'kanhrey-roussey3',
                'code' => 'PRD-006',
                'description' => 'កញ្រ្ជែងឬស្សីតម្លៃសមរម្យ ស្អាត និងធន់',
                'price' => 2.00,
                'discount_price_percent' => null,
                'stock' => 7,
                'size' => 'មធ្យម',
                'image_url' => [
                    '/storage/products/fn-2020-02-07-15-09-27-5.jpg',
                    '/storage/products/02.png',
                    '/storage/products/01.png'
                ],
            ],
            [
                'name' => 'កញ្រ្ជែងឬស្សី',
                'slug' => 'av-yeut-srey',
                'code' => 'PRD-007',
                'description' => 'កញ្រ្ជែងឬស្សីគុណភាពល្អ ពណ៌ស្រស់ស្អាត សម្រាប់ប្រើប្រាស់ប្រចាំថ្ងៃ',
                'price' => 5.00,
                'discount_price_percent' => 15,
                'stock' => 15,
                'size' => 'មធ្យម',
                'image_url' => [
                    '/storage/products/01.png'
                ],
            ],
            [
                'name' => 'កញ្រ្ជែងឬស្សី',
                'slug' => 'av-thom-srey',
                'code' => 'PRD-008',
                'description' => 'កញ្រ្ជែងឬស្សីគុណភាពល្អ ពណ៌ស្រស់ស្អាត សម្រាប់ប្រើប្រាស់ប្រចាំថ្ងៃ',
                'price' => 4.50,
                'discount_price_percent' => null,
                'stock' => 12,
                'size' => 'ធំ',
                'image_url' => [
                    '/storage/products/02.png'
                ],
            ],
            [
                'name' => 'កញ្រ្ជែងឬស្សី',
                'slug' => 'khao-khley-srey',
                'code' => 'PRD-009',
                'description' => 'កញ្រ្ជែងឬស្សីគុណភាពល្អ ពណ៌ស្រស់ស្អាត សម្រាប់ប្រើប្រាស់ប្រចាំថ្ងៃ',
                'price' => 3.50,
                'discount_price_percent' => 5,
                'stock' => 20,
                'size' => 'តូច',
                'image_url' => [
                    '/storage/products/fn-2020-02-07-15-09-27-5.jpg'
                ],
            ],
            [
                'name' => 'កញ្រ្ជែងឬស្សី',
                'slug' => 'khao-veng-srey',
                'code' => 'PRD-010',
                'description' => 'កញ្រ្ជែងឬស្សីគុណភាពល្អ ពណ៌ស្រស់ស្អាត សម្រាប់ប្រើប្រាស់ប្រចាំថ្ងៃ',
                'price' => 6.00,
                'discount_price_percent' => null,
                'stock' => 18,
                'size' => 'មធ្យម',
                'image_url' => [
                    '/storage/products/01.png',
                    '/storage/products/02.png'
                ],
            ],
            [
                'name' => 'កញ្រ្ជែងឬស្សី',
                'slug' => 'somliek-bompeak-koun',
                'code' => 'PRD-011',
                'description' => 'កញ្រ្ជែងឬស្សីគុណភាពល្អ ពណ៌ស្រស់ស្អាត សម្រាប់ប្រើប្រាស់ប្រចាំថ្ងៃ',
                'price' => 4.00,
                'discount_price_percent' => 10,
                'stock' => 25,
                'size' => 'ធំ',
                'image_url' => [
                    '/storage/products/02.png'
                ],
            ],
            [
                'name' => 'កញ្រ្ជែងឬស្សី',
                'slug' => 'av-peak-knong',
                'code' => 'PRD-012',
                'description' => 'កញ្រ្ជែងឬស្សីគុណភាពល្អ ពណ៌ស្រស់ស្អាត សម្រាប់ប្រើប្រាស់ប្រចាំថ្ងៃ',
                'price' => 2.50,
                'discount_price_percent' => null,
                'stock' => 30,
                'size' => 'មធ្យម',
                'image_url' => [
                    '/storage/products/fn-2020-02-07-15-09-27-5.jpg'
                ],
            ],
            [
                'name' => 'កញ្រ្ជែងឬស្សី',
                'slug' => 'sraom-cherng',
                'code' => 'PRD-013',
                'description' => 'កញ្រ្ជែងឬស្សីគុណភាពល្អ ពណ៌ស្រស់ស្អាត សម្រាប់ប្រើប្រាស់ប្រចាំថ្ងៃ',
                'price' => 1.00,
                'discount_price_percent' => null,
                'stock' => 50,
                'size' => 'តូច',
                'image_url' => [
                    '/storage/products/01.png'
                ],
            ],
            [
                'name' => 'កញ្រ្ជែងឬស្សី',
                'slug' => 'khao-cherng-khley',
                'code' => 'PRD-014',
                'description' => 'កញ្រ្ជែងឬស្សីគុណភាពល្អ ពណ៌ស្រស់ស្អាត សម្រាប់ប្រើប្រាស់ប្រចាំថ្ងៃ',
                'price' => 3.00,
                'discount_price_percent' => 5,
                'stock' => 22,
                'size' => 'មធ្យម',
                'image_url' => [
                    '/storage/products/02.png'
                ],
            ],
            [
                'name' => 'កញ្រ្ជែងឬស្សី',
                'slug' => 'av-krov',
                'code' => 'PRD-015',
                'description' => 'កញ្រ្ជែងឬស្សីគុណភាពល្អ ពណ៌ស្រស់ស្អាត សម្រាប់ប្រើប្រាស់ប្រចាំថ្ងៃ',
                'price' => 7.00,
                'discount_price_percent' => 20,
                'stock' => 8,
                'size' => 'ធំ',
                'image_url' => [
                    '/storage/products/fn-2020-02-07-15-09-27-5.jpg'
                ],
            ],
            [
                'name' => 'កញ្រ្ជែងឬស្សី',
                'slug' => 'somliek-bompeak-keyla',
                'code' => 'PRD-016',
                'description' => 'កញ្រ្ជែងឬស្សីគុណភាពល្អ ពណ៌ស្រស់ស្អាត សម្រាប់ប្រើប្រាស់ប្រចាំថ្ងៃ',
                'price' => 8.00,
                'discount_price_percent' => null,
                'stock' => 14,
                'size' => 'មធ្យម',
                'image_url' => [
                    '/storage/products/01.png',
                    '/storage/products/02.png'
                ],
            ],
            [
                'name' => 'កញ្រ្ជែងឬស្សី',
                'slug' => 'khao-yeun',
                'code' => 'PRD-017',
                'description' => 'កញ្រ្ជែងឬស្សីគុណភាពល្អ ពណ៌ស្រស់ស្អាត សម្រាប់ប្រើប្រាស់ប្រចាំថ្ងៃ',
                'price' => 9.00,
                'discount_price_percent' => 10,
                'stock' => 10,
                'size' => 'មធ្យម',
                'image_url' => [
                    '/storage/products/fn-2020-02-07-15-09-27-5.jpg'
                ],
            ],
            [
                'name' => 'កញ្រ្ជែងឬស្សី',
                'slug' => 'av-srey-saat',
                'code' => 'PRD-018',
                'description' => 'កញ្រ្ជែងឬស្សីគុណភាពល្អ ពណ៌ស្រស់ស្អាត សម្រាប់ប្រើប្រាស់ប្រចាំថ្ងៃ',
                'price' => 5.50,
                'discount_price_percent' => null,
                'stock' => 16,
                'size' => 'តូច',
                'image_url' => [
                    '/storage/products/02.png'
                ],
            ],
            [
                'name' => 'កញ្រ្ជែងឬស្សី',
                'slug' => 'sraom-day',
                'code' => 'PRD-019',
                'description' => 'កញ្រ្ជែងឬស្សីគុណភាពល្អ ពណ៌ស្រស់ស្អាត សម្រាប់ប្រើប្រាស់ប្រចាំថ្ងៃ',
                'price' => 1.50,
                'discount_price_percent' => null,
                'stock' => 40,
                'size' => 'តូច',
                'image_url' => [
                    '/storage/products/01.png'
                ],
            ],
            [
                'name' => 'កញ្រ្ជែងឬស្សី',
                'slug' => 'khao-peak-knong',
                'code' => 'PRD-020',
                'description' => 'កញ្រ្ជែងឬស្សីគុណភាពល្អ ពណ៌ស្រស់ស្អាត សម្រាប់ប្រើប្រាស់ប្រចាំថ្ងៃ',
                'price' => 2.50,
                'discount_price_percent' => 5,
                'stock' => 35,
                'size' => 'មធ្យម',
                'image_url' => [
                    '/storage/products/fn-2020-02-07-15-09-27-5.jpg'
                ],
            ],
            [
                'name' => 'កញ្រ្ជែងឬស្សី',
                'slug' => 'chhout-keng',
                'code' => 'PRD-021',
                'description' => 'កញ្រ្ជែងឬស្សីគុណភាពល្អ ពណ៌ស្រស់ស្អាត សម្រាប់ប្រើប្រាស់ប្រចាំថ្ងៃ',
                'price' => 10.00,
                'discount_price_percent' => 15,
                'stock' => 12,
                'size' => 'មធ្យម',
                'image_url' => [
                    '/storage/products/02.png'
                ],
            ],
            [
                'name' => 'កញ្រ្ជែងឬស្សី',
                'slug' => 'av-yeut-khley',
                'code' => 'PRD-022',
                'description' => 'កញ្រ្ជែងឬស្សីគុណភាពល្អ ពណ៌ស្រស់ស្អាត សម្រាប់ប្រើប្រាស់ប្រចាំថ្ងៃ',
                'price' => 4.00,
                'discount_price_percent' => null,
                'stock' => 18,
                'size' => 'តូច',
                'image_url' => [
                    '/storage/products/01.png'
                ],
            ],
            [
                'name' => 'កញ្រ្ជែងឬស្សី',
                'slug' => 'khao-slak',
                'code' => 'PRD-023',
                'description' => 'កញ្រ្ជែងឬស្សីគុណភាពល្អ ពណ៌ស្រស់ស្អាត សម្រាប់ប្រើប្រាស់ប្រចាំថ្ងៃ',
                'price' => 7.50,
                'discount_price_percent' => 10,
                'stock' => 9,
                'size' => 'មធ្យម',
                'image_url' => [
                    '/storage/products/fn-2020-02-07-15-09-27-5.jpg'
                ],
            ],
            [
                'name' => 'កញ្រ្ជែងឬស្សី',
                'slug' => 'chhout-thver-kar',
                'code' => 'PRD-024',
                'description' => 'កញ្រ្ជែងឬស្សីគុណភាពល្អ ពណ៌ស្រស់ស្អាត សម្រាប់ប្រើប្រាស់ប្រចាំថ្ងៃ',
                'price' => 12.00,
                'discount_price_percent' => null,
                'stock' => 6,
                'size' => 'ធំ',
                'image_url' => [
                    '/storage/products/02.png'
                ],
            ],
            [
                'name' => 'កញ្រ្ជែងឬស្សី',
                'slug' => 'av-kraoy',
                'code' => 'PRD-025',
                'description' => 'កញ្រ្ជែងឬស្សីគុណភាពល្អ ពណ៌ស្រស់ស្អាត សម្រាប់ប្រើប្រាស់ប្រចាំថ្ងៃ',
                'price' => 6.50,
                'discount_price_percent' => 5,
                'stock' => 11,
                'size' => 'មធ្យម',
                'image_url' => [
                    '/storage/products/01.png',
                    '/storage/products/02.png'
                ],
            ],
            [
                'name' => 'កញ្រ្ជែងឬស្សី',
                'slug' => 'khao-keyla',
                'code' => 'PRD-026',
                'description' => 'កញ្រ្ជែងឬស្សីគុណភាពល្អ ពណ៌ស្រស់ស្អាត សម្រាប់ប្រើប្រាស់ប្រចាំថ្ងៃ',
                'price' => 5.00,
                'discount_price_percent' => null,
                'stock' => 20,
                'size' => 'តូច',
                'image_url' => [
                    '/storage/products/fn-2020-02-07-15-09-27-5.jpg'
                ],
            ],
            [
                'name' => 'កញ្រ្ជែងឬស្សី',
                'slug' => 'somliek-bompeak-chob-lieng',
                'code' => 'PRD-027',
                'description' => 'កញ្រ្ជែងឬស្សីគុណភាពល្អ ពណ៌ស្រស់ស្អាត សម្រាប់ប្រើប្រាស់ប្រចាំថ្ងៃ',
                'price' => 15.00,
                'discount_price_percent' => 20,
                'stock' => 5,
                'size' => 'មធ្យម',
                'image_url' => [
                    '/storage/products/02.png'
                ],
            ],
            [
                'name' => 'កញ្រ្ជែងឬស្សី',
                'slug' => 'av-thom-classic',
                'code' => 'PRD-028',
                'description' => 'កញ្រ្ជែងឬស្សីគុណភាពល្អ ពណ៌ស្រស់ស្អាត សម្រាប់ប្រើប្រាស់ប្រចាំថ្ងៃ',
                'price' => 4.00,
                'discount_price_percent' => null,
                'stock' => 13,
                'size' => 'ធំ',
                'image_url' => [
                    '/storage/products/01.png'
                ],
            ],
            [
                'name' => 'កញ្រ្ជែងឬស្សី',
                'slug' => 'khao-cherng-veng',
                'code' => 'PRD-029',
                'description' => 'កញ្រ្ជែងឬស្សីគុណភាពល្អ ពណ៌ស្រស់ស្អាត សម្រាប់ប្រើប្រាស់ប្រចាំថ្ងៃ',
                'price' => 6.00,
                'discount_price_percent' => 10,
                'stock' => 17,
                'size' => 'មធ្យម',
                'image_url' => [
                    '/storage/products/fn-2020-02-07-15-09-27-5.jpg'
                ],
            ],
            [
                'name' => 'កញ្រ្ជែងឬស្សី',
                'slug' => 'somliek-bompeak-piseh',
                'code' => 'PRD-030',
                'description' => 'កញ្រ្ជែងឬស្សីគុណភាពល្អ ពណ៌ស្រស់ស្អាត សម្រាប់ប្រើប្រាស់ប្រចាំថ្ងៃ',
                'price' => 20.00,
                'discount_price_percent' => 25,
                'stock' => 4,
                'size' => 'ធំ',
                'image_url' => [
                    '/storage/products/01.png',
                    '/storage/products/02.png'
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
