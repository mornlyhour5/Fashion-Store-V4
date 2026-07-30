<?php

namespace App\Models;

use App\Enums\GenderProduct;
use Illuminate\Database\Eloquent\Model;
use App\Enums\ProductStatus;

class Products extends Model
{
    protected $table = 'products';
    protected $appends = ['image_url'];

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'brand_id',
        'base_price',
        'thumbnail',
        'views_count',
        'status',
        'gender',
        'short_description',
        'material',
        'country_of_origin',
        'weight',
        'is_featured'
    ];

    public function variants()
    {
        return $this->hasMany(Product_Variants::class, 'product_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function images()
    {
        return $this->hasMany(Product_Images::class, 'product_id');
    }

    public function order_item()
    {
        return $this->hasMany(Order_Items::class, 'product_id');
    }

    protected $casts = [
        'status' => ProductStatus::class,
        'gender' => GenderProduct::class, // 👈 added
    ];

    public function getImageUrlAttribute(): ?string
    {
        if (empty($this->thumbnail)) {   // 👈 renamed from "image"
            return null;
        }

        return asset('uploads/images/' . \App\Enums\ImageBuket::COMPANY->value . '/' . \App\Enums\ImageDirectory::PRODUCT->value . '/' . $this->thumbnail);
    }
}
