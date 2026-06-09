<?php

namespace App\Enums;

enum GenderProduct: string
{
    case MEN    = 'men';
    case WOMEN  = 'women';
    case UNISEX = 'unisex';
    case KIDS   = 'kids';

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
