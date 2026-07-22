<?php

namespace App\Repository\Wishlist;

use App\Models\Wishlist;
use App\Repository\BaseRepositoryImpl;
use App\Repository\Contracts\WishlistRepository;

class WishlistRepositoryImpl extends BaseRepositoryImpl implements WishlistRepository
{

    public function __construct(Wishlist $wishlist)
    {
        $this->model = $wishlist;
    }
}
