<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupons extends Model
{
    protected $table = 'coupons';

    protected $fillable = [
        'code',
        'type',
        'value',
        'minimum_order',
        'maximum_discount',
        'usage_limit',
        'usage_count',
        'is_active',
        'starts_at',
        'expires_at',
        'description'
    ];
}
