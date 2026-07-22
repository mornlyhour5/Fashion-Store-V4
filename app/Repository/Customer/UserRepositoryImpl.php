<?php

namespace App\Repository\Customer;

use App\Models\User;
use App\Repository\BaseRepositoryImpl;
use App\Repository\Contracts\UserRepository;

class UserRepositoryImpl extends BaseRepositoryImpl implements UserRepository
{
    public function __construct(User $user)
    {
        $this->model = $user;
    }
}
