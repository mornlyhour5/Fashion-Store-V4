<?php

namespace App\Repository\Auth;

use App\Models\User;
use App\Repository\BaseRepositoryImpl;
use App\Repository\Contracts\AuthRepository;

class AuthRepositoryImpl extends BaseRepositoryImpl implements AuthRepository
{
    public function __construct(User $user)
    {
        parent::__construct($user);
    }
}
