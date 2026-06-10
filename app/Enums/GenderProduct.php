<?php

namespace App\Enums;

enum GenderProduct: int
{
    case MEN    = 1;
    case WOMEN  = 2;
    case UNISEX = 3;
    case KIDS   = 4;

    public function label(): string
    {
        return match ($this) {
            self::MEN    => 'Men',
            self::WOMEN  => 'Women',
            self::UNISEX => 'Unisex',
            self::KIDS   => 'Kids',
        };
    }

    public static function options(): array
    {
        return array_map(
            fn(self $case) => [
                'value' => $case->value,
                'label' => $case->label(),
            ],
            self::cases()
        );
    }
}
