<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product_Images extends Model
{
    protected $table = 'product_images';

    protected $fillable = [
        'product_id',
        'image_url',
        'is_main',
        'sort_order',
        'product_variant_id'
    ];

    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }

    public function productVariant()
    {
        return $this->belongsTo(Product_Variants::class, 'product_variant_id');
    }
}
