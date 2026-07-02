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

    protected $casts = [
        'status' => ProductStatus::class,
        'gender' => GenderProduct::class, // 👈 added
    ];

    public function getImageUrlAttribute(): ?string
    {
        if (empty($this->image)) {
            return null;
        }

        // Build the public URL to match where HelperMedia saves the file:
        // public/uploads/images/{bucket}/{dirName}/{filename}
        return asset('uploads/images/' . \App\Enums\ImageBuket::COMPANY->value . '/' . \App\Enums\ImageDirectory::PRODUCT->value . '/' . $this->image);
    }
}
