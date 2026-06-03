<?php

namespace App\Services\Cart;

use App\Repository\Cart\CartItemRepo;

class CartItemServices
{
    public function __construct(protected CartItemRepo $cartItemRepo)
    {
        $this->cartItemRepo = $cartItemRepo;
    }

    public function getAll()
    {
        return $this->cartItemRepo->getAll();
    }

    public function getWhereId($id)
    {
        return $this->cartItemRepo->findId($id);
    }

    public function create(array $data)
    {
        $data = [
            'cart_id' => $data['cart_id'],
            'product_variant_id' => $data['product_variant_id'],
            'quantity' => $data['quantity'] ?? 1,
            'price' => $data['price']
        ];

        return $this->cartItemRepo->create($data);
    }

    public function update(array $data, $id)
    {
        $cart = $this->cartItemRepo->findId($id);
        $data = [
            'cart_id' => $data['cart_id'],
            'product_variant_id' => $data['product_variant_id'],
            'quantity' => $data['quantity'] ?? 1,
            'price' => $data['price']
        ];

        return $this->cartItemRepo->update($data, $cart);
    }

    public function delete($id)
    {
        $cart = $this->cartItemRepo->findId($id);

        return $this->cartItemRepo->delete($cart);
    }
}
