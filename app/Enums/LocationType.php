<?php

namespace App\Enums;

enum LocationType: int
{
    case ORDER = 1;
    case PURCHASE = 2;
    case RETURN = 3;
}
