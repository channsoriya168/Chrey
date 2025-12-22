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
        // Delete all existing products
        Product::query()->delete();

        $products = [
            // ភេសជ្ជៈ និងកាហ្វេ (Beverages & Coffee)
            [
                'name' => 'កាហ្វេត្រជាក់',
                'slug' => 'iced-coffee',
                'description' => 'កាហ្វេត្រជាក់ពិសេស ជាមួយទឹកដោះគោ និងទឹកកក។ រសជាតិកំពុក មានជាតិ caffeine ខ្ពស់ ជួយឱ្យភ្ញាក់។',
                'price' => 0.01,
                'discount_price_percent' => null,
                'stock' => 200,
                'size' => 'មធ្យម',
                'images' => [
                    '/images/products/coffee-1.jpg',
                    '/images/products/coffee-2.jpg',
                ],
            ],
            [
                'name' => 'កាហ្វេ Latte',
                'slug' => 'cafe-latte',
                'description' => 'កាហ្វេ Latte ក្រៀមល្អិត ធ្វើពីកាហ្វេ espresso និងទឹកដោះគោក្រៀម។ រសជាតិទន់ ផ្អែមល្មម។',
                'price' => 4.00,
                'discount_price_percent' => 10.00,
                'stock' => 180,
                'size' => 'មធ្យម',
                'images' => [
                    '/images/products/coffee-3.jpg',
                    '/images/products/coffee-4.jpg',
                ],
            ],
            [
                'name' => 'កាហ្វេ Cappuccino',
                'slug' => 'cappuccino',
                'description' => 'កាហ្វេ Cappuccino ប្រពៃណីអ៊ីតាលី មានពពុះទឹកដោះគោខ្ទុះ។ រសជាតិក្រៀមល្អិត និងក្លិនក្រអូប។',
                'price' => 4.25,
                'discount_price_percent' => null,
                'stock' => 160,
                'size' => 'មធ្យម',
                'images' => [
                    '/images/products/coffee-5.jpg',
                    '/images/products/coffee-6.jpg',
                ],
            ],
            [
                'name' => 'កាហ្វេ Espresso',
                'slug' => 'espresso',
                'description' => 'កាហ្វេ Espresso ខ្លាំង រសជាតិកំពុកដុះ។ សមស្របសម្រាប់អ្នកចូលចិត្តកាហ្វេពិត។',
                'price' => 3.00,
                'discount_price_percent' => null,
                'stock' => 250,
                'size' => 'តូច',
                'images' => [
                    '/images/products/coffee-7.jpg',
                    '/images/products/coffee-8.jpg',
                ],
            ],
            [
                'name' => 'ទឹកក្រូចចាប់',
                'slug' => 'fresh-orange-juice',
                'description' => 'ទឹកក្រូចចាប់ស្រស់ 100% ពីផ្លែឈើពិត។ មានវីតាមីន C ច្រើន ល្អសម្រាប់សុខភាព។',
                'price' => 3.75,
                'discount_price_percent' => 13.33,
                'stock' => 150,
                'size' => 'មធ្យម',
                'images' => [
                    '/images/products/coffee-9.jpg',
                    '/images/products/coffee-10.jpg',
                ],
            ],
            [
                'name' => 'ទឹកក្រូច Smoothie',
                'slug' => 'mixed-smoothie',
                'description' => 'ទឹកក្រូច Smoothie ល្បាយផ្លែឈើច្រើនប្រភេទ។ ត្រជាក់ ផ្អែម និងមានសារធាតុចិញ្ចឹមច្រើន។',
                'price' => 4.50,
                'discount_price_percent' => 11.11,
                'stock' => 140,
                'size' => 'មធ្យម',
                'images' => [
                    '/images/products/coffee-11.jpg',
                    '/images/products/coffee-12.jpg',
                ],
            ],
            [
                'name' => 'ទឹកតែបៃតង',
                'slug' => 'green-tea',
                'description' => 'ទឹកតែបៃតងភ្នំ គុណភាពខ្ពស់។ មានសារធាតុ antioxidant ច្រើន ល្អសម្រាប់សុខភាព។',
                'price' => 3.25,
                'discount_price_percent' => null,
                'stock' => 220,
                'size' => 'មធ្យម',
                'images' => [
                    '/images/products/coffee-13.jpg',
                    '/images/products/coffee-14.jpg',
                ],
            ],
            [
                'name' => 'តែទឹកដោះគោ',
                'slug' => 'milk-tea',
                'description' => 'តែទឹកដោះគោប្រពៃណីកម្ពុជា មានរសជាតិផ្អែមល្មម។ លាយជាមួយគ្រាប់ស្រូវខ្ទិះ។',
                'price' => 3.75,
                'discount_price_percent' => 13.33,
                'stock' => 190,
                'size' => 'មធ្យម',
                'images' => [
                    '/images/products/coffee-15.jpg',
                    '/images/products/coffee-16.jpg',
                ],
            ],
            [
                'name' => 'កាហ្វេកាកាវ',
                'slug' => 'mocha-coffee',
                'description' => 'កាហ្វេកាកាវ Mocha ល្បាយជាមួយសូកូឡា។ រសជាតិផ្អែម និងក្រៀមល្អិត។',
                'price' => 4.50,
                'discount_price_percent' => null,
                'stock' => 170,
                'size' => 'មធ្យម',
                'images' => [
                    '/images/products/coffee-17.jpg',
                    '/images/products/coffee-18.jpg',
                ],
            ],
            [
                'name' => 'ទឹកក្រូចខ្ចី',
                'slug' => 'strawberry-juice',
                'description' => 'ទឹកក្រូចខ្ចីស្រស់ៗ មានរសជាតិផ្អែមឆ្ងាញ់។ ត្រជាក់ស្រស់ សមស្របសម្រាប់ថ្ងៃក្តៅ។',
                'price' => 4.25,
                'discount_price_percent' => 17.65,
                'stock' => 130,
                'size' => 'មធ្យម',
                'images' => [
                    '/images/products/coffee-19.jpg',
                    '/images/products/coffee-20.jpg',
                ],
            ],
            [
                'name' => 'កាហ្វេអាម៉េរីកាណូ',
                'slug' => 'americano',
                'description' => 'កាហ្វេអាម៉េរីកាណូ សាមញ្ញ រសជាតិកាហ្វេច្បាស់លាស់។ អាចញ៉ាំក្តៅ ឬត្រជាក់។',
                'price' => 3.50,
                'discount_price_percent' => null,
                'stock' => 210,
                'size' => 'មធ្យម',
                'images' => [
                    '/images/products/coffee-21.jpg',
                    '/images/products/coffee-22.jpg',
                ],
            ],
            [
                'name' => 'តែក្រៀម',
                'slug' => 'thai-tea',
                'description' => 'តែក្រៀមស្រស់ រសជាតិផ្អែម និងក្រៀមល្អិត។ ភេសជ្ជៈពេញនិយមបំផុត។',
                'price' => 3.75,
                'discount_price_percent' => 13.33,
                'stock' => 200,
                'size' => 'មធ្យម',
                'images' => [
                    '/images/products/coffee-23.jpg',
                    '/images/products/coffee-24.jpg',
                ],
            ],
            [
                'name' => 'កាហ្វេ Caramel Macchiato',
                'slug' => 'caramel-macchiato',
                'description' => 'កាហ្វេ Caramel Macchiato ផ្អែមល្ហែម លាយក្រៀមទឹកដោះគោ និងប្រេង caramel ។ រសជាតិពិសេស។',
                'price' => 4.75,
                'discount_price_percent' => 10.53,
                'stock' => 155,
                'size' => 'ធំ',
                'images' => [
                    '/images/products/coffee-25.jpg',
                    '/images/products/coffee-26.jpg',
                ],
            ],
            [
                'name' => 'ទឹកក្រូចម្នាស់',
                'slug' => 'pineapple-juice',
                'description' => 'ទឹកក្រូចម្នាស់ចាប់ទឹកស្រស់ មានរសជាតិផ្អែមឆ្ងាញ់ជូរតិចៗ។ ជួយរំលាយអាហារ។',
                'price' => 3.50,
                'discount_price_percent' => null,
                'stock' => 145,
                'size' => 'មធ្យម',
                'images' => [
                    '/images/products/coffee-27.jpg',
                    '/images/products/coffee-28.jpg',
                ],
            ],
            [
                'name' => 'កាហ្វេ Vanilla Latte',
                'slug' => 'vanilla-latte',
                'description' => 'កាហ្វេ Latte ក្រៀមល្អិត លាយជាមួយប្រេង vanilla ក្រអូប។ រសជាតិផ្អែមខ្លាំងល្មម។',
                'price' => 4.25,
                'discount_price_percent' => 11.76,
                'stock' => 165,
                'size' => 'មធ្យម',
                'images' => [
                    '/images/products/coffee-29.jpg',
                    '/images/products/coffee-30.jpg',
                ],
            ],
            [
                'name' => 'ទឹកស្វាយ Smoothie',
                'slug' => 'mango-smoothie',
                'description' => 'ទឹកស្វាយ Smoothie ក្រៀមល្អិត ផ្អែមឆ្ងាញ់។ ធ្វើពីស្វាយស្រស់ 100% ជាមួយទឹកកក និងទឹកដោះគោ។',
                'price' => 4.50,
                'discount_price_percent' => 11.11,
                'stock' => 135,
                'size' => 'មធ្យម',
                'images' => [
                    '/images/products/coffee-31.jpg',
                    '/images/products/coffee-32.jpg',
                ],
            ],
            [
                'name' => 'កាហ្វេកម្ពុជា',
                'slug' => 'cambodian-coffee',
                'description' => 'កាហ្វេកម្ពុជាសុទ្ធ រសជាតិកំពុកខ្លាំង។ ប្រៀបតាមបែបប្រពៃណី ជាមួយទឹកដោះគោផ្អែមខ្លាំង។',
                'price' => 3.25,
                'discount_price_percent' => null,
                'stock' => 225,
                'size' => 'មធ្យម',
                'images' => [
                    '/images/products/coffee-33.jpg',
                    '/images/products/coffee-34.jpg',
                ],
            ],
            [
                'name' => 'ទឹកឃ្មុំ Smoothie',
                'slug' => 'avocado-smoothie',
                'description' => 'ទឹកឃ្មុំ Smoothie ក្រៀមទន់ មានសារធាតុចិញ្ចឹមច្រើន។ ល្អសម្រាប់សុខភាព និងស្បែក។',
                'price' => 4.75,
                'discount_price_percent' => 15.79,
                'stock' => 125,
                'size' => 'មធ្យម',
                'images' => [
                    '/images/products/coffee-35.jpg',
                    '/images/products/coffee-36.jpg',
                ],
            ],
            [
                'name' => 'កាហ្វេ Flat White',
                'slug' => 'flat-white',
                'description' => 'កាហ្វេ Flat White ពីអូស្ត្រាលី មានពពុះទឹកដោះគោស្តើង។ រសជាតិកាហ្វេខ្លាំងជាង Latte តិចតួច។',
                'price' => 4.00,
                'discount_price_percent' => null,
                'stock' => 175,
                'size' => 'មធ្យម',
                'images' => [
                    '/images/products/coffee-37.jpg',
                    '/images/products/coffee-38.jpg',
                ],
            ],
            [
                'name' => 'ទឹកខ្ចរសុទ្ធ',
                'slug' => 'coconut-juice',
                'description' => 'ទឹកខ្ចរសុទ្ធស្រស់ ត្រជាក់។ មានសារធាតុ electrolyte ច្រើន ល្អសម្រាប់បំពេញទឹកក្នុងខ្លួន។',
                'price' => 2.50,
                'discount_price_percent' => null,
                'stock' => 250,
                'size' => 'ធំ',
                'images' => [
                    '/images/products/coffee-39.jpg',
                    '/images/products/coffee-40.jpg',
                ],
            ],
        ];

        foreach ($products as $index => $productData) {
            Product::create([
                'name' => $productData['name'],
                'slug' => $productData['slug'],
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
