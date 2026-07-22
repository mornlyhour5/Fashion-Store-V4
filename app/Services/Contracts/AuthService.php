<?php

namespace App\Services\Contracts;

// use App\DTO\LoginDTO;
use Illuminate\Http\Request;

interface AuthService
{
    public function register(Request $request): array;

    public function login(array $credentials): array;

    public function logout(Request $request): void;
}
