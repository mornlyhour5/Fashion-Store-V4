<?php

namespace App\Services\Order;

use App\Repository\Order\OrderItemRepo;
use App\Repository\Order\OrderRepo;
use App\Repository\Product\ProductRepo;
use App\Repository\Product\ProductVariantRepo;
use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Auth;

class MainOrderServices
{
    public function __construct(
        protected OrderRepo $orderRepo,
        protected OrderItemRepo $orderItemRepo,
        protected ProductVariantRepo $productVariantRepo,
        protected ProductRepo $productRepo
    )
    {
        $this->orderRepo = $orderRepo;
        $this->orderItemRepo = $orderItemRepo;
        $this->productVariantRepo = $productVariantRepo;
        $this->productRepo = $productRepo;
    }

    public function create(array $data)
    {
        DB::beginTransaction();
        try{
            //====================>> Create order number <<====================
            $lastOrder = $this->orderRepo->lastId();

            if($lastOrder) {
                $lastNumber = (int) str_replace('CPS-', '', $lastOrder->order_number);
                $newNumber = $lastNumber + 1;
            } else {
                $newNumber = 1;
            }
            $orderNumber = 'CPS-' . str_pad($newNumber, 5, '0', STR_PAD_LEFT);
            //======================>> caculate order <<=========================
            $subTotal = 0;
            $dis = $data['discount'] ?? 10;

            foreach($data ['items'] as $item) {

                $variants = $this->productVariantRepo->find($item['product_variant_id']);

                if (!$variants) {
                    throw new \Exception("Product variant ID {$item['product_variant_id']} not found.");
                }

                if($item['quantity'] <= 0) {
                    throw new \Exception("Quantity for product variant ID {$item['product_variant_id']} must be greater than zero.");
                }

                if($variants->stock < $item['quantity']) {
                    throw new \Exception("Product variant ID {$item['product_variant_id']} is out of stock.");
                }

                $subTotal  += $variants->price * $item['quantity'];
            }

            if($subTotal <= 0) {
                throw new \Exception("Subtotal must be greater than zero.");
            }

            if(($data['shipping_fee'] ?? 0) < 0) {
                throw new \Exception("Shipping fee must be greater than or equal to zero.");
            }

            if($dis < 0) {
                throw new \Exception("Discount must be greater than or equal to zero.");
            }

            $tottaldis = ($dis / 100) * $subTotal;

            $totalAmount = $subTotal + ($data['shipping_fee']) - $tottaldis;

            $dataOrder = [
                'user_id' => '1',
                'address_id' => $data['address_id'],
                'order_number' => $orderNumber,
                'subtotal' => $subTotal,
                'shipping_fee' => $data['shipping_fee'],
                'discount' =>  $dis,
                'total_amount' => $totalAmount,
                'payment_method' => $data['payment_method'],
                'payment_status' => $data['payment_status'] ?? 'pending',
                'order_status' => 'pending',
                'shipping_address' => $data['shipping_address'],
                'note' => $data['note']
            ];

            $order =  $this->orderRepo->create($dataOrder);

            //===================>> caculate order items <<======================
            foreach ($data['items'] as $item) {

                $variants = $this->productVariantRepo->find($item['product_variant_id']);

                $itemSubtotal = $variants->price * $item['quantity'];

                $dataOrderItem = [
                    'order_id' => $order->id,
                    'product_variant_id' => $item['product_variant_id'],
                    'product_id' => $item['product_id'],
                    'product_name' => $variants->product->name,
                    'sku' => $variants->sku,
                    'color' => $variants->color,
                    'size' => $variants->size,
                    'quantity' => $item['quantity'],
                    'price' => $variants->price,
                    'subtotal' => $itemSubtotal,
                ];
                    $this->productVariantRepo->decreaseStock($item['product_variant_id'], $item['quantity']);

                    $this->orderItemRepo->create($dataOrderItem);
                }
        DB::commit();

        return $order;

        }catch (\Exception $e){
            DB::rollBack();
            throw $e;
        }
    }

    public function update($id, array $data)
    {
        // Implement order update logic here
    }
}
