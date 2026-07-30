<?php

namespace App\Enums;

enum NotificationType: string
{
    case ORDER_CREATED      = 'order_created';
    case ORDER_CONFIRMED    = 'order_confirmed';
    case ORDER_CANCELLED    = 'order_cancelled';
    case ORDER_COMPLETED    = 'order_completed';

    case USER_REGISTERED    = 'user_registered';
    case USER_UPDATED       = 'user_updated';

    case LOW_STOCK          = 'low_stock';
    case OUT_OF_STOCK       = 'out_of_stock';

    case COUPON_CREATED     = 'coupon_created';
    case COUPON_EXPIRED     = 'coupon_expired';

    public function title(): string
    {
        return match ($this) {
            self::ORDER_CREATED => 'New Order',
            self::ORDER_CONFIRMED => 'Order Confirmed',
            self::ORDER_CANCELLED => 'Order Cancelled',
            self::ORDER_COMPLETED => 'Order Completed',

            self::USER_REGISTERED => 'New Customer',
            self::USER_UPDATED => 'Customer Updated',

            self::LOW_STOCK => 'Low Stock',
            self::OUT_OF_STOCK => 'Out of Stock',

            self::COUPON_CREATED => 'Coupon Created',
            self::COUPON_EXPIRED => 'Coupon Expired',
        };
    }
}
