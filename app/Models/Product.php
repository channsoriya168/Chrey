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

    protected $appends = ['first_image'];

    public function getFirstImageAttribute()
    {
        if (is_array($this->image_url) && count($this->image_url) > 0) {
            return $this->image_url[0];
        }
        return null;
    }

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
