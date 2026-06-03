<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    protected $table = 'customer_profile';

    protected $fillable = [
        'user_id',
        'full_name',
        'phone',
        'gender',
        'date_of_birth',
        'preferred_language',
        'note'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
