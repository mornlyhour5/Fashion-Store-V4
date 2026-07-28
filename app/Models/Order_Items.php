<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order_Items extends Model
{
    protected $table = 'order_items';

    protected $fillable = [
        'order_id',
        'product_variant_id',
        'product_id',
        'sku',
        'color',
        'size',
        'quantity',
        'price',
        'discount',
        'net_amount',
        'tax_rate',
        'tax_amount'
    ];

    public function order()
    {
        return $this->belongsTo(Orders::class, 'order_id');
    }

    public function Variant()
    {
        return $this->belongsTo(Product_Variants::class);
    }

    public function Product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }

}
