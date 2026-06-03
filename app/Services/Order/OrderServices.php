<?php

namespace App\Services\Order;


use App\Repository\Cart\CartItemRepo;
use App\Repository\Order\OrderRepo;
use App\Repository\Product\ProductRepo;
use App\Repository\Product\ProductVariantRepo;

class OrderServices
{
    public function __construct(
        protected OrderRepo $orderRepo,
        protected ProductRepo $productsRepo,
        protected ProductVariantRepo $productVariantRepo,
        protected CartItemRepo $cartItemRepo
    )
    {
        $this->orderRepo = $orderRepo;
        $this->productsRepo = $productsRepo;
        $this->productVariantRepo = $productVariantRepo;
        $this->cartItemRepo = $cartItemRepo;
    }

    public function getAll()
    {
        return $this->orderRepo->getAll();
    }

    public function getWhereId($id)
    {
        return $this->orderRepo->findId($id);
    }

    public function create(array $data)
    {


        //---------------------------------------------------------------------//
        //                        create order number                         //
        //---------------------------------------------------------------------//
        $lastOrder = $this->orderRepo->lastId();

        if($lastOrder) {
            $lastNumber = (int) str_replace('CPS-', '', $lastOrder->order_number);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        $orderNumber = 'CPS-' . str_pad($newNumber, 5, '0', STR_PAD_LEFT);

        //---------------------------------------------------------------------//
        //                        create data subtotal                         //
        //---------------------------------------------------------------------//

















        $data = [
            'user_id'          => $data['user_id'],
            'address_id'       => $data['address_id'],
            'order_number'     => $orderNumber,
            'subtotal'         => $data['subtotal'],
            'shipping_fee'     => $data['shipping_fee'] ?? 0,
            'discount'         => $data['discount'] ?? 0,
            'total_amount'     => $data['total_amount'],
            'payment_method'   => $data['payment_method'],
            'payment_status'   => $data['payment_status'] ?? 'pending',
            'order_status'     => $data['order_status']  ?? 'pending',
            'shipping_address' => $data['shipping_address'],
            'note'             => $data['note'] ?? null,
            'paid_at'          => $data['paid_at'] ?? null,
            'shipped_at'       => $data['shipped_at'] ?? null,
            'delivered_at'     => $data['delivered_at'] ?? null,
            'cancelled_at'     => $data['cancelled_at'] ?? null,
        ];

        return $this->orderRepo->create($data);
    }

    public function update(array $data, $id)
    {
        $order = $this->orderRepo->findId($id);

        $data = [
            'user_id'          => $data['user_id'],
            'address_id'       => $data['address_id'],
            'order_number'     => $order->order_number,
            'subtotal'         => $data['subtotal'],
            'shipping_fee'     => $data['shipping_fee'] ?? 0,
            'discount'         => $data['discount'] ?? 0,
            'total_amount'     => $data['total_amount'],
            'payment_method'   => $data['payment_method'],
            'payment_status'   => $data['payment_status'] ?? 'pending',
            'order_status'     => $data['order_status']  ?? 'pending',
            'shipping_address' => $data['shipping_address'],
            'note'             => $data['note'] ?? null,
            'paid_at'          => $data['paid_at'] ?? null,
            'shipped_at'       => $data['shipped_at'] ?? null,
            'delivered_at'     => $data['delivered_at'] ?? null,
            'cancelled_at'     => $data['cancelled_at'] ?? null,
        ];

        return $this->orderRepo->update($data, $order);
    }

    public function delete($id)
    {
        $order = $this->orderRepo->findId($id);

        return $this->orderRepo->delete($order);
    }
}
