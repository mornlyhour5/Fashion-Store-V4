<?php
namespace App\Enums;
enum PaymentMethod:string{
    case BANK = 'bank';
    case CASH = 'cash';
    case CHEQUE = 'cheque';
    case KHQR = 'khqr';

    public function label(): string{
        return match($this){
            self::BANK => 'Bank',
            self::CASH => 'Cash',
            self::CHEQUE => 'Cheque',
            self::KHQR => 'KHQR',
        };
    }
    public static function options():array{
        return array_map(
            fn($case) => [
                'value' => $case->value,
                'label' => $case->label(),
            ],
            self::cases()
        );
    }
}
