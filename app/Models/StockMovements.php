<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockMovements extends Model
{
    protected $table = 'stock_movements';

    protected $fillable = [
        'created_at',
        'updated_at',
        'create_uid',
        'update_uid',
        'id_deleted',
        'deleted_at',
        'deleted_reason',
        'product_id',
        'product_variant_id',
        'action',
        'quantity',
        'stock_before',
        'stock_after',
        'reference_id',
        'location_id',
        'action_uid',
        'action_at',
        'note',
        'meta'
    ];
}
