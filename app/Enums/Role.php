<?php

namespace App\Enums;

enum Role:int
{
    case ADMIN = 1;
    case STAFF = 2;
    case CUSTOMER = 3;

    public function label(): string
    {
        return match ($this) {
            Role::ADMIN  => 'admin',
            Role::STAFF  => 'staff',
            Role::CUSTOMER  => 'customer'
        };
    }

    public static function toArray(): array
    {
        return [
            self::ADMIN->value => self::ADMIN->label(),
            self::STAFF->value => self::STAFF->label(),
            self::CUSTOMER->value => self::CUSTOMER->label(),
        ];
    }

    public static function options(): array
    {
        return [
            ['value' => self::ADMIN->value, 'label' => self::ADMIN->label()],
            ['value' => self::STAFF->value, 'label' => self::STAFF->label()]
        ];
    }
}
