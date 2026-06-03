<?php

namespace App\Repository\Auth;
use App\Models\User;

class LoginRepo
{
    public function findByEmail(string $email)
    {
        return User::where('email', $email)->first();
    }

    public function updatePassword(User $user, string $newPassword)
    {
        $user->password = bcrypt($newPassword);
        $user->save();

        return $user;
    }
}
