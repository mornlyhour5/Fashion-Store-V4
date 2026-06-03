<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order_Status_Histories extends Model
{
    protected $table = 'order_status_histories';

    protected $fillable = [
        'order_id',
        'changed_by',
        'from_status',
        'to_status',
        'note',
        'changed_at'
    ];
}
