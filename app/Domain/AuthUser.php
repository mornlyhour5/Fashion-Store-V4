<?php

namespace App\Domain;

use App\Models\User;

class AuthUser extends BaseAuthUser
{
    public static function fromModel(User $user): self
    {
        return new self(
            id: $user->id,
            name: $user->name,
            email: $user->email
        );
    }

    public function displayName(): string
    {
        return "{$this->name} ({$this->email})";
    }
}
