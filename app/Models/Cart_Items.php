<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart_Items extends Model
{
    protected $table = 'cart_items';

    protected $fillable = [
        'cart_id',
        'product_variant_id',
        'quantity',
        'price'
    ];

    public function Product_Variants()
    {
        return $this->belongsTo(Product_Variants::class);
    }
}
