<?php

namespace App\Services\Auth;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;
use App\Repository\Auth\LoginRepo;

// use App\Repository\Auth\RegisterRepo;

class LoginServices
{

    public function __construct(protected LoginRepo $loginRepo)
    {
        $this->loginRepo = $loginRepo;
    }

    public function login(array $credentials)
    {
        $user = $this->loginRepo->findByEmail($credentials['email']);

        if (!$user || !Auth::attempt($credentials)) {
            throw new AuthenticationException('Invalid credentials');
        }

        // ✅ Regenerate session after login (security best practice)
        request()->session()->regenerate();

        return [
            'user'       => $user,
            'session_id' => request()->session()->getId()  // ✅ Get session ID
        ];
    }

    public function changePassword($user,$currentPassword,$newPassword)
    {
        if (!Auth::check() || !Auth::attempt(['email' => $user->email, 'password' => $currentPassword])) {
            throw new AuthenticationException('Current password is incorrect');
        }

        return $this->loginRepo->updatePassword($user, $newPassword);
    }
}
