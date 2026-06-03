<?php

namespace App\Repository\Auth;

use App\Models\User;

class RegisterRepo
{
    public function createUSer(array $data)
    {
        return User::create($data);
    }
}
