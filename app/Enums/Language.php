<?php

namespace App\Enums;

enum Language: int
{
    case EN = 1;
    case KH = 2;

    public function label(): string
    {
        return match ($this) {
            self::EN => 'English',
            self::KH => 'Khmer',
        };
    }

    public static function options(): array
    {
        return array_map(
            fn (self $case) => [
                'value' => $case->value,
                'label' => $case->label(),
            ],
            self::cases()
        );
    }
}
