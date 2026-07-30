<?php

namespace App\Enums;

enum NotificationReceiver: int
{
    case ADMIN = 1;
    case STAFF = 2;
    case CUSTOMER = 3;

    public function label(): string
    {
        return match ($this) {
            self::ADMIN => 'Admin',
            self::STAFF => 'Staff',
            self::CUSTOMER => 'Customer',
        };
    }
}
