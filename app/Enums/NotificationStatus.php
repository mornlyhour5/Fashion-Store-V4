<?php

namespace App\Enums;

enum NotificationStatus: int
{
    case UNREAD = 1;
    case READ = 2;

    public function label(): string
    {
        return match ($this) {
            self::UNREAD => 'Unread',
            self::READ => 'Read',
        };
    }
}
