<?php

namespace App\Traits;

trait ArrayableTrait
{
    /**
     *  Convert DTO to array
     */

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
