<?php

namespace App\Domain;

use App\Models\User;

class AuthUser
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $email,
        public readonly string $role,
        public readonly bool $isActive,
        public readonly ?string $avatar = null,
        public readonly ?int $customerId = null,
        public readonly ?string $phone = null,
    ) {}

    public static function fromModel(User $user): self
    {
        $profile = $user->customerProfile;

        return new self(
            id: $user->id,
            name: $user->name,
            email: $user->email,
            role: $user->role?->value ?? (string) $user->role,
            isActive: (bool) $user->is_active,
            avatar: $user->avata,
            customerId: $profile?->id,
            phone: $profile?->phone,
        );
    }
}
