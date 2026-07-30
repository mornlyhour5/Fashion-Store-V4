<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wishlist_Items extends Model
{
    protected $table = 'wishlist_items';

    protected $fillable = [
        'wishlist_id',
        'product_id',
        'variantId'
    ];

    public function wishlist()
    {
        return $this->belongsTo(Wishlist::class);
    }

    public function product()
    {
        return $this->belongsTo(Products::class);
    }

    public function variant()
    {
        return $this->belongsTo(Product_Variants::class);
    }
}
