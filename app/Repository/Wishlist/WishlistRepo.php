<?php

namespace App\Repository\Wishlist;

use App\Models\Wishlist;

class WishlistRepo
{
    public function getAll()
    {
        return Wishlist::all();
    }

    public function findId($id)
    {
        return Wishlist::findOrFail($id);
    }

    public function create(array $data)
    {
        return Wishlist::create($data);
    }

    public function update(array $data, Wishlist $wishlist)
    {
        $wishlist->update($data);

        return $wishlist->fresh();
    }

    public function delete(Wishlist $wishlist)
    {
        return $wishlist->delete();
    }
}
