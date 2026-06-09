<?php

namespace App\Repository\Auth;

use App\Models\User;
use App\DTO\CreateUserDto;
class RegisterRepo
{
    public function create(CreateUserDto $dto)
    {
        // return User::create($data);
        return User::create([
        'name'     => $dto->name,
        'email'    => $dto->email,
        'password' => bcrypt($dto->password),
    ]);
        
    }
}
