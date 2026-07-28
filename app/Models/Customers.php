<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\Gender;
use App\Enums\Language;
use App\Models\User;

class Customers extends Model
{
    protected $table = 'customer_profile';

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'phone',
        'gender',
        'date_of_birth',
        'preferred_language',
        'note'
    ];

    protected $casts = [
        'gender'        => Gender::class,
        'preferred_language' => Language::class,
        'date_of_birth' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
