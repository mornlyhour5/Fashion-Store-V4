<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon_Usages extends Model
{
    protected $table = 'coupon_usages';

    public $timestamps = false;

    protected $fillable = [
        'used_at',
        'coupon_id',
        'user_id',
        'order_id',
    ];
}
