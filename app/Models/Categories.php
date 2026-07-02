<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $table = 'categories';
    protected $appends = ['image_url'];

    protected $fillable = [
        'name',
        'slug',
        'parent_id',
        'status',
        'sort_order',
        'image'
    ];

    public function getImageUrlAttribute(): ?string
    {
        if (empty($this->image)) {
            return null;
        }

        return asset('uploads/images/' . \App\Enums\ImageBuket::COMPANY->value . '/' . \App\Enums\ImageDirectory::CATEGORIES->value . '/' . $this->image);
    }
}
