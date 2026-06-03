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
        'product_name',
        'sku',
        'color',
        'size',
        'quantity',
        'price',
        'subtotal'
    ];

    public function orders()
    {
        return $this->hasMany(Orders::class);
    }

    public function productVariant()
    {
        return $this->belongsTo(Product_Variants::class);
    }

}
