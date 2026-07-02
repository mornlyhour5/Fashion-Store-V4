<?php

namespace App\Services\Contracts;

use App\DTO\LoginDTO;

interface LoginService
{
    public function login(array $credentials): LoginDTO;
}
