<?php
namespace App\Enums;
enum PaymentStatus:int{
    case UNPAID = 1;
    case PARTIAL = 2;
    case PAID = 3;

    public function label(): string
    {
        return match ($this) {
            self::UNPAID => 'Unpaid',
            self::PARTIAL => 'Partial',
            self::PAID => 'Paid',

        };
    }
    public static function options(): array
    {
        return array_map(
            fn($case) => [
                'value' => $case->value,
                'label' => $case->label(),
            ],
            self::cases()
        );
    }
}
