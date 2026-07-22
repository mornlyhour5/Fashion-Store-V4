<?php

namespace App\Repository\Order;

use App\Models\Order_Items;
use App\Repository\BaseRepositoryImpl;
use App\Repository\Contracts\OrderItemRepository;

class OrderItemRepositoryImpl extends BaseRepositoryImpl implements OrderItemRepository
{
    public function __construct(Order_Items $orderItem)
    {
        $this->model = $orderItem;
    }
}
