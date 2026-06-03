<?php

namespace App\Repository\Cart;

use App\Models\Cart_Items;

class CartItemRepo
{
    public function getAll()
    {
        return Cart_Items::all();
    }

    public function findId($id)
    {
        return Cart_Items::findOrFail($id);
    }

    public function create(array $data)
    {
        return Cart_Items::create($data);
    }

    public function update(array $data, Cart_Items $cart)
    {
        $cart->update($data);

        return $cart->fresh();
    }

    public function delete(Cart_Items $cart)
    {
        return $cart->delete();
    }
}
