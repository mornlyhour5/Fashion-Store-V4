<?php

namespace App\Repository\Cart;

use App\Models\Carts;

class CartRepo
{
    public function getAll()
    {
        return Carts::all();
    }

    public function findId($id)
    {
        return Carts::findOrFail($id);
    }

    public function create(array $data)
    {
        return Carts::create($data);
    }

    public function update(array $data, Carts $carts)
    {
        $carts->update($data);

        return $carts->refresh();
    }

    public function delete(Carts $carts)
    {
        return $carts->delete();
    }
}
