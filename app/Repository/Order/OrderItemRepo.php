<?php

namespace App\Repository\Order;

use App\Models\Order_Items;

class OrderItemRepo
{
    public function getAll()
    {
        return Order_Items::all();
    }

    public function findId($id)
    {
        return Order_Items::findOrFail($id);
    }

    public function create(array $data)
    {
        return Order_Items::create($data);
    }

    public function update(array $data, Order_Items $orderItems)
    {
        $orderItems->update($data);

        return $orderItems->fresh();
    }

    public function delete(Order_Items $orderItems)
    {
        return $orderItems->delete();
    }
}
