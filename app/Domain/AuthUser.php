<?php

namespace App\Domain;

use App\Models\User;

class AuthUser extends BaseAuthUser
{

    public function __construct(int $id, string $name, string $email)
    {
        return parent::__construct($id, $name, $email);
    }

    public static function fromModel(User $user): self
    {
        return new self(
            id: $user->id,
            name: $user->name,
            email: $user->email,
        );
    }
}
