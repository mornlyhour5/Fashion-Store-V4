<?php

namespace App\Services\Wishlist;

use App\Repository\Wishlist\WishlistItemRepo;

class WishlistItemServices
{
    public function __construct(protected WishlistItemRepo $wishlistItemRepo)
    {
        $this->wishlistItemRepo = $wishlistItemRepo;
    }

    public function getAll()
    {
        return $this->wishlistItemRepo->getAll();
    }

    public function getWhereId($id)
    {
        return $this->wishlistItemRepo->findId($id);
    }

    public function create(array $data)
    {
        $data = [
            'wishlist_id' => $data['wishlist_id'],
            'product_id' => $data['product_id']
        ];

        return $this->wishlistItemRepo->create($data);
    }

    public function update(array $data, $id)
    {
        $wish = $this->wishlistItemRepo->findId($id);
        $data = [
            'wishlist_id' => $data['wishlist_id'],
            'product_id' => $data['product_id']
        ];

        return $this->wishlistItemRepo->update($data, $wish);
    }

    public function delete($id){
        $wish = $this->wishlistItemRepo->findId($id);

        return $this->wishlistItemRepo->delete($wish);
    }
}
