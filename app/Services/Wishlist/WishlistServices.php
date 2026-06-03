<?php

namespace App\Services\Wishlist;

use App\Repository\Wishlist\WishlistRepo;

class WishlistServices
{
    public function __construct(protected WishlistRepo $wishlistRepo)
    {
        $this->wishlistRepo = $wishlistRepo;
    }

    public function getAll()
    {
        return $this->wishlistRepo->getAll();
    }

    public function getWhereId($id)
    {
        return $this->wishlistRepo->findId($id);
    }

    public function create(array $data)
    {
        $data = [
            'user_id' => $data['user_id']
        ];

        return $this->wishlistRepo->create($data);
    }

    public function update(array $data, $id)
    {
        $wish = $this->wishlistRepo->findId($id);
        $data = [
            'user_id' => $data['user_id']
        ];

        return $this->wishlistRepo->update($data, $wish);
    }

    public function delete($id)
    {
        $wish = $this->wishlistRepo->findId($id);

        return $this->wishlistRepo->delete($wish);
    }
}
