<?php

namespace App\Enums;

enum OrderStatus: int
{
    case PENDING   = 1;
    case PAID      = 2;
    case SHIPPED   = 3;
    case DELIVERED = 4;
    case CANCELLED = 5;

    public function label(): string
    {
        return match ($this) {
            self::PENDING   => 'pending',
            self::PAID      => 'paid',
            self::SHIPPED   => 'shipped',
            self::DELIVERED => 'delivered',
            self::CANCELLED => 'cancelled',
        };
    }

    // optional: for UI dropdown (all statuses)
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

    // optional: filter allowed statuses (example: admin control)
    public static function allowedForAdmin(): array
    {
        // return array_map(
        //     fn(self $case) => [
        //         'value' => $case->value,
        //         'label' => $case->label(),
        //     ],
        //     [
        //         self::PENDING,
        //         self::PAID,
        //         self::SHIPPED,
        //         self::DELIVERED,
        //         self::CANCELLED,
        //     ]
        // );
        return [self::PENDING, self::PAID, self::SHIPPED, self::DELIVERED, self::CANCELLED,];
    }

    // example: only cancellable statuses
    public static function cancellable(): array
    {
        return array_map(
            fn(self $case) => [
                'value' => $case->value,
                'label' => $case->label(),
            ],
            [
                self::PENDING,
                self::PAID,
            ]
        );
    }
}
