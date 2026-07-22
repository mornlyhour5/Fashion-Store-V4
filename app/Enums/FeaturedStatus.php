<?php

namespace App\Enums;

enum FeaturedStatus: int
{
    case NOT_FEATURED = 0;
    case FEATURED = 1;

    public function label(): string
    {
        return match ($this) {
            self::NOT_FEATURED => 'Not Featured',
            self::FEATURED => 'Featured',
        };
    }

    public static function options(): array
    {
        return array_map(
            fn ($case) => [
                'value' => $case->value,
                'label' => $case->label(),
            ],
            self::cases()
        );
    }
}
