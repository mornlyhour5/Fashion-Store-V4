<?php

namespace App\Repository\Order;

use App\Models\Orders;
use App\Repository\BaseRepositoryImpl;
use App\Repository\Contracts\OrderRepository;

class OrderRepositoryImpl extends BaseRepositoryImpl implements OrderRepository
{
    public function __construct(Orders $orders)
    {
        $this->model = $orders;
    }
}
