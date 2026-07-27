<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product_Images extends Model
{
    protected $table = 'product_images';
    protected $appends = ['image_url'];

    protected $fillable = [
        'is_main',
        'sort_order',
        'product_variant_id',
        'image',
    ];

    public function productVariant()
    {
        return $this->belongsTo(Product_Variants::class, 'product_variant_id');
    }

    public function getImageUrlAttribute(): ?string
    {
        if (empty($this->image)) {
            return null;
        }
        return asset('uploads/images/' . \App\Enums\ImageBuket::COMPANY->value . '/' . \App\Enums\ImageDirectory::VARIANT->value . '/' . $this->image);
    }
}
