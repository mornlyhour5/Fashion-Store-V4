<?php

namespace App\Enums;

enum StockActionType: string
{
    case ADD = 'add';
    case DEDUCT = 'deduct';
}
