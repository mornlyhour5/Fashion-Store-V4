<?php

namespace App\Repository\Order;

use App\Models\Order_Status_Histories;

class OrderStatusHistoryRepo
{
    public function getAll()
    {
        return Order_Status_Histories::all();
    }

    public function findId($id)
    {
        return Order_Status_Histories::findOrFail($id);
    }

    public function create(array $data)
    {
        return Order_Status_Histories::create($data);
    }

    public function update(array $data ,Order_Status_Histories $orderStatusHistories)
    {
        $orderStatusHistories->update($data);

        return $orderStatusHistories->fresh();
    }

    public function delete(Order_Status_Histories $orderStatusHistories)
    {
        return $orderStatusHistories->delete();
    }
}
