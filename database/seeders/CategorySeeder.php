<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Electronics',
                'slug' => Str::uuid(),
                'image_url' => 'https://images.unsplash.com/photo-1498049794561-7780e7231661?w=200&h=200&fit=crop',
            ],
            [
                'name' => 'Fashion',
                'slug' => Str::uuid(),
                'image_url' => 'https://images.unsplash.com/photo-1445205170230-053b83016050?w=200&h=200&fit=crop',
            ],
            [
                'name' => 'Home & Living',
                'slug' => Str::uuid(),
                'image_url' => 'https://images.unsplash.com/photo-1484101403633-562f891dc89a?w=200&h=200&fit=crop',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
