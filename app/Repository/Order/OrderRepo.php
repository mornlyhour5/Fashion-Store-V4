<?php

namespace App\Repository\Order;

use App\Models\Orders;

class OrderRepo
{
    public function getAll()
    {
        return Orders::all();
    }

    public function findId($id)
    {
        return Orders::findOrFail($id);
    }

    public function lastId()
    {
        return Orders::lockForUpdate()->latest('order_number')->first();
    }

    public function create(array $data)
    {
        return Orders::create($data);
    }

    public function update(array $data, Orders $orders)
    {
        $orders->update($data);

        return $orders->fresh();
    }

    public function delete(Orders $orders)
    {
        return $orders->delete();
    }
}
