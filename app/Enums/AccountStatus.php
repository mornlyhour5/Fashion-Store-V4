<?php

namespace App\Enums;

enum AccountStatus: int
{
    case REGISTERED = 1;   // user has signed up but not yet verified
    case PENDING = 2;      // verification/email not confirmed
    case ACTIVE = 3;       // fully active account
    case SUSPENDED = 4;    // temporarily disabled
    case DEACTIVATED = 5;  // user voluntarily deactivated
    case BANNED = 6;       // permanently banned
    case LOCKED = 7;       // lock account
}
