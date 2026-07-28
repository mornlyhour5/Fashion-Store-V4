<?php

namespace App\Services\Order;

use App\Repository\Contracts\OrderItemRepository;
use App\Services\Contracts\OrderItemService;

class OrderItemServicesImpl implements OrderItemService
{
    public function __construct(protected OrderItemRepository $orderItem){}

    public function getAllItem()
    {
        return $this->orderItem->getAll();
    }

    public function getItemsByOrder(int $id)
    {
        return $this->orderItem->findById($id);
    }

    
}
