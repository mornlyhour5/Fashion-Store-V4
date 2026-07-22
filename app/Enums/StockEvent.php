<?php

namespace App\Enums;

enum StockEvent: string
{
    // Add stock events
    case RECEIVE_PO_ITEM = 'receive_po_item';
    case TRANSFER_IN = 'transfer_in';
    case ADJUSTMENT_IN = 'adjustment_in';
    case INITIAL_QTY = 'initial_qty';

    // Deduct stock events
    case POS_ORDER = 'pos_order';
    case MOBILE_ORDER = 'mobile_order';
    case TRANSFER_OUT = 'transfer_out';
    case ADJUSTMENT_OUT = 'adjustment_out';

    // Map event to action
    public function action(): StockActionType
    {
        return match($this) {
            self::RECEIVE_PO_ITEM,
            self::TRANSFER_IN,
            self::ADJUSTMENT_IN,
            self::INITIAL_QTY => StockActionType::ADD,

            self::POS_ORDER,
            self::MOBILE_ORDER,
            self::TRANSFER_OUT,
            self::ADJUSTMENT_OUT => StockActionType::DEDUCT,
        };
    }
}
