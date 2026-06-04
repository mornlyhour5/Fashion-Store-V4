<?php

namespace App\Services\Auth;

use App\Repository\Auth\RegisterRepo;
// use Illuminate\Support\Facades\Hash;
// use App\Domain\AuthUser;
use App\DTO\CreateUserDto;

class RegisterServices
{
    public function __construct(protected RegisterRepo $registerRepo)
    {
        $this->registerRepo = $registerRepo;
    }

    public function register(CreateUserDto $dto)
    {
        // $user = $this->registerRepo->createUser([
        //     'name' => $data['name'],
        //     'email' => $data['email'],
        //     'password' => Hash::make($data['password'])
        // ]);

        // $token = $user->createToken('auth_token')->plainTextToken;

        // return [
        //     'user' => $user,
        //     'token' => $token
        // ];


        return $this->registerRepo->create($dto);
    }
}
