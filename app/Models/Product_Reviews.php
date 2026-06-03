<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product_Reviews extends Model
{
    protected $table = 'product_reviews';

    protected $fillable = [
        'product_id',
        'user_id',
        'order_id',
        'rating',
        'title',
        'body',
        'status'
    ];
}
