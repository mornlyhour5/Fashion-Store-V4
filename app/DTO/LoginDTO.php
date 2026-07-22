<?php

namespace App\DTO;

use App\Traits\ArrayableTrait;
use Illuminate\Contracts\Support\Arrayable;

class LoginDTO implements Arrayable
{
    use ArrayableTrait;

    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $email,
        public readonly string $role,
        public readonly ?string $avatar = null,
    ) {}

    public function toArray(): array
    {
        return [
            'id'     => $this->id,
            'name'   => $this->name,
            'email'  => $this->email,
            'role'   => $this->role,
            'avatar' => $this->avatar,
        ];
    }
}
