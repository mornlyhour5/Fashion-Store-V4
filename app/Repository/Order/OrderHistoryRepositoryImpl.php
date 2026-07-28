<?php

namespace App\Repository\Order;

use App\Models\Order_Status_Histories;
use App\Repository\BaseRepositoryImpl;
use App\Repository\Contracts\OrderHistoryRepository;

class OrderHistoryRepositoryImpl extends BaseRepositoryImpl implements OrderHistoryRepository
{
    public function __construct(Order_Status_Histories $history)
    {
        $this->model = $history;
    }
}
