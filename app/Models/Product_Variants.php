<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product_Variants extends Model
{
    protected $table = 'product_variants';

    protected $fillable = [
        'product_id',
        'sku',
        'color',
        'size',
        'unit_price',
        'quantity',
        'low_stock_threshold',
        'barcode',
        'cost_price',
        'status',
        'weight'
    ];

    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }

    public function Images()
    {
        return $this->hasMany(Product_Images::class, 'product_variant_id')->orderBy('sort_order');
    }

    public function variant()
    {
        return $this->hasMany(Wishlist_Items::class, 'variant');
    }
}
