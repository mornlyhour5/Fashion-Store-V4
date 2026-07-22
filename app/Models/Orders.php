<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Orders extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'address_id',
        'order_number',
        'subtotal',
        'shipping_fee',
        'discount',
        'total_amount',
        'payment_method',
        'payment_status',
        'order_status',
        'shipping_address',
        'note',
        'paid_at',
        'shipped_at',
        'delivered_at',
        'cancelled_at'
    ];

    public function items()
    {
        return $this->hasMany(Order_Items::class, 'order_id');
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(Order_Items::class, 'order_id', 'id');
    }

    public function address()
    {
        return $this->belongsTo(Addresses::class, 'address_id');
    }
}
