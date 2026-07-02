<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    //SoftDeletes
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

        // Build the public URL to match where HelperMedia saves the file:
        // public/uploads/images/{bucket}/{dirName}/{filename}
        return asset('uploads/images/' . \App\Enums\ImageBuket::COMPANY->value . '/' . \App\Enums\ImageDirectory::BRAND->value . '/' . $this->logo);
    }
}
