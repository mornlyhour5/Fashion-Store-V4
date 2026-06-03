<?php

namespace App\Services\Order;

use App\Repository\Order\OrderStatusHistoryRepo;

class OrderStatusHistoryServices
{
    public function __construct(protected OrderStatusHistoryRepo $orderStatusHistoryRepo)
    {
        $this->orderStatusHistoryRepo = $orderStatusHistoryRepo;
    }

    public function getAll()
    {
        return $this->orderStatusHistoryRepo->getAll();
    }

    public function getWhereId($id)
    {
        return $this->orderStatusHistoryRepo->findId($id);
    }

    public function create(array $data)
    {
        $data = [
            'order_id'     => $data['order_id'],
            // 'changed_by'   => auth()->id(),
            'changed_by'   => $data['changed_by'],
            'from_status'  => $data['from_status'],
            'to_status'    => $data['to_status'],
            'note'         => $data['note'],
            'changed_at'   => now(),
        ];

        return $this->orderStatusHistoryRepo->create($data);
    }

    public function update(array $data, $id)
    {
        $order = $this->orderStatusHistoryRepo->findId($id);

        $data = [
            'order_id'     => $data['order_id'],
            // 'changed_by'   => auth()->id(),
            'changed_by'   => $data['changed_by'],
            'from_status'  => $data['from_status'],
            'to_status'    => $data['to_status'],
            'note'         => $data['note'],
            'changed_at'   => now(),
        ];

        return $this->orderStatusHistoryRepo->update($data, $order);
    }

    public function delete($id)
    {
        $order = $this->orderStatusHistoryRepo->findId($id);

        return $this->orderStatusHistoryRepo->delete($order);
    }
}
