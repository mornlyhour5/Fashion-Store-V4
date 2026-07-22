<?php

namespace App\DTO;

use App\Traits\ArrayableTrait;
use Illuminate\Contracts\Support\Arrayable;

abstract class AbstractUserLoginDTO implements Arrayable
{
    use ArrayableTrait;

    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly ?string $profile,
        public readonly string $token,
    ) {}
}
