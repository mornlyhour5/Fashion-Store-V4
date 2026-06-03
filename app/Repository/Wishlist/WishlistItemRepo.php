<?php

namespace App\Repository\Wishlist;

use App\Models\Wishlist_Items;

class WishlistItemRepo
{
    public function getAll()
    {
        return Wishlist_Items::all();
    }

    public function findId($id)
    {
        return Wishlist_Items::findOrFail($id);
    }

    public function create(array $data)
    {
        return Wishlist_Items::create($data);
    }

    public function update(array $data, Wishlist_Items $wishlistItems)
    {
        $wishlistItems->update($data);

        return $wishlistItems->fresh();
    }

    public function delete(Wishlist_Items $wishlistItems)
    {
        return $wishlistItems->delete();
    }
}
