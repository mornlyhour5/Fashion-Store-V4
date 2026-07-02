<?php

namespace App\DTO;

class LoginDTO extends AbstractUserLoginDTO
{
    public function __construct(
        int $id,
        string $email,
        string $password,
        public readonly array $modules = [],
        public readonly array $permissions = [],
    ) {
        parent::__construct($id, $email, $password);
    }

    public function toArray(): array
    {
        return array_merge(
            parent::toArray(),
            [
                'modules'     => $this->modules,
                'permissions' => $this->permissions,
            ]
        );
    }
}
