<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    // Cart Status Constants
    const STATUS_ACTIVE = 'active';           // ✅ User is shopping
    const STATUS_CHECKED_OUT = 'checked_out'; // ✅ Order placed & paid

    protected $fillable = [
        'user_id',
        'session_id',
        'status',
        'pending_address_id',
        'md5',
    ];

    /**
     * Get user who owns this cart
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all items in this cart
     */
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Get the pending address for checkout
     */
    public function pendingAddress()
    {
        return $this->belongsTo(Address::class, 'pending_address_id');
    }


    /**
     * Check if cart is active (user is shopping)
     */
    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    /**
     * Check if cart has been checked out
     */
    public function isCheckedOut(): bool
    {
        return $this->status === self::STATUS_CHECKED_OUT;
    }

    /**
     * Scope: Get only active carts
     */
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }
}
