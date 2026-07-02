<?php

namespace App\Enums;

enum ProductStatus: int
{
    case ACTIVE      = 1;
    case INACTIVE    = 0;
    case OUT_OF_STOCK = 2;

    /**
     * Convert string label from frontend → int value for DTO.
     */
    public static function fromString(?string $value): int
    {
        return match($value) {
            'active'        => self::ACTIVE->value,
            'inactive'      => self::INACTIVE->value,
            'out_of_stock'  => self::OUT_OF_STOCK->value,
            default         => self::ACTIVE->value,
        };
    }

    /**
     * Convert int back to string label for frontend.
     */
    public function toLabel(): string
    {
        return match($this) {
            self::ACTIVE        => 'active',
            self::INACTIVE      => 'inactive',
            self::OUT_OF_STOCK  => 'out_of_stock',
        };
    }
}
