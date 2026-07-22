<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    use HasFactory;

    protected $table = 'brand';
    protected $appends = ['logo_url'];

    protected $fillable = [
        'name',
        'slug',
        'description',
        'logo',
        'status',
        'sort_order',
        'link'
    ];

    protected $casts = [
        'status' => Status::class,
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Products::class);
    }

    public function getLogoUrlAttribute(): ?string
    {
        if (empty($this->logo)) {
            return null;
        }

        return asset('uploads/images/' . \App\Enums\ImageBuket::COMPANY->value . '/' . \App\Enums\ImageDirectory::BRAND->value . '/' . $this->logo);
    }
}
