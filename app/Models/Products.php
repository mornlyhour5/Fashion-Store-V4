<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'brand',
        'base_price',
        'gender',
        'status',
        'image',
        'views_count'
    ];

    public function variants()
    {
        return $this->hasMany(Product_Variants::class, 'product_id');
    }

    public function images()
    {
        return $this->hasMany(Product_Images::class, 'product_id');
    }
}
