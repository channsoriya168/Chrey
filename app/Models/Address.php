<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'user_id',
        'phone',
        'province',
        'district',
        'commune',
        'village',
        'note',
    ];

    protected $appends = [
        'formatted_address',
        'full_address'
    ];

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shippingOrders()
    {
        return $this->hasMany(Order::class, 'shipping_address_id');
    }

    /**
     * Scopes
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Accessors
     */
    public function getFormattedAddressAttribute()
    {
        $parts = array_filter([
            $this->village,
            $this->commune,
            $this->district,
            $this->province,
        ]);

        return implode(', ', $parts);
    }

    public function getFullAddressAttribute()
    {
        return $this->formatted_address;
    }
}
