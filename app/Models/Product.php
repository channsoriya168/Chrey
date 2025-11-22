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

    

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
