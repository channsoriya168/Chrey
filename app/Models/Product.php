<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'slug', 'code', 'image_url', 'description', 'price', 'discount_price_percent', 'stock', 'size'];

    protected $casts = [
        'image_url' => 'array',
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'discount_price_percent' => 'decimal:2',
    ];

}
