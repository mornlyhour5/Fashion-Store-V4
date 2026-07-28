<?php

namespace App\Services\Contracts;

interface OrderItemService
{
    public function getAllItem();

    public function getItemsByOrder(int $id);

}
