<?php

namespace App\Enums;

enum Language: string
{
    case EN = 'EN';
    case KH = 'KH';

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
            fn(self $case) => [
                'value' => $case->value,
                'label' => $case->label(),
            ],
            self::cases()
        );
    }
}
