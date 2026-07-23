<?php

namespace App\Enums;

enum AccountStatus: int
{
    case REGISTERED = 1;
    case PENDING = 2;
    case ACTIVE = 3;
    case SUSPENDED = 4;
    case DEACTIVATED = 5;
    case BANNED = 6;
    case LOCKED = 7;

    public function label(): string
    {
        return match ($this) {
            self::REGISTERED => 'Registered',
            self::PENDING => 'Pending Verification',
            self::ACTIVE => 'Active',
            self::SUSPENDED => 'Suspended',
            self::DEACTIVATED => 'Deactivated',
            self::BANNED => 'Banned',
            self::LOCKED => 'Locked',
        };
    }

    /** Statuses an admin is allowed to set manually */
    public static function adminAssignable(): array
    {
        return [self::ACTIVE, self::SUSPENDED, self::BANNED, self::LOCKED];
    }
}
