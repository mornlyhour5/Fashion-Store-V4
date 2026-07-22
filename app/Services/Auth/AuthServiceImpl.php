<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Repository\Contracts\AuthRepository;
use Illuminate\Http\Request;
use App\Services\Contracts\AuthService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthServiceImpl implements AuthService
//  implements AuthService
{
    public function __construct(
        protected AuthRepository $authRepository
    ) {}

    public function register(Request $request): array
    {
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => \App\Enums\Role::CUSTOMER,
        ]);

        $token = JWTAuth::fromUser($user);

        return ['user' => $user, 'token' => $token];
    }

    public function login(array $credentials): array
    {
        $attemptCredentials = [
            'email' => $credentials['email'],
            'password' => $credentials['password'],
        ];

        if (!$token = Auth::guard('api')->attempt($attemptCredentials)) {
            throw ValidationException::withMessages([
                'email' => ['Invalid credentials'],
            ]);
        }

        return [
            'user' => Auth::guard('api')->user(),
            'token' => $token,
        ];
    }

    public function logout(Request $request): void
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }

}
