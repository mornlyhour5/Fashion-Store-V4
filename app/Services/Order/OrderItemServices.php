<?php

namespace App\Services\Order;

use App\Repository\Order\OrderItemRepo;

class OrderItemServices
{
    public function __construct(protected OrderItemRepo $orderItemRepo)
    {
        $this->orderItemRepo = $orderItemRepo;
    }

    public function getAll()
    {
        return $this->orderItemRepo->getAll();
    }

    public function getWhereId($id)
    {
        return $this->orderItemRepo->findId($id);
    }

    public function create(array $data)
    {
        $data = [
            'order_id'           => $data['order_id'],
            'product_variant_id' => $data['product_variant_id'],
            'product_id'         => $data['product_id'],
            'product_name'       => $data['product_name'],
            'sku'                => $data['sku'] ?? null,
            'color'              => $data['color'] ?? null,
            'size'               => $data['size'] ?? null,
            'quantity'           => $data['quantity'],
            'price'              => $data['price'],
            'subtotal'           => $data['subtotal'],
        ];

        return $this->orderItemRepo->create($data);
    }

    public function update(array $data, $id)
    {
        $order = $this->orderItemRepo->findId($id);
        $data = [
            'order_id'           => $data['order_id'],
            'product_variant_id' => $data['product_variant_id'],
            'product_id'         => $data['product_id'],
            'product_name'       => $data['product_name'],
            'sku'                => $data['sku'] ?? null,
            'color'              => $data['color'] ?? null,
            'size'               => $data['size'] ?? null,
            'quantity'           => $data['quantity'],
            'price'              => $data['price'],
            'subtotal'           => $data['subtotal'],
        ];

        return $this->orderItemRepo->update($data, $order);
    }

    public function delete($id)
    {
        $order = $this->orderItemRepo->findId($id);

        return $this->orderItemRepo->delete($order);
    }
}
