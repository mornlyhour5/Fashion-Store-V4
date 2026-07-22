<?php

namespace App\Repository\Wishlist;

use App\Models\Wishlist_Items;
use App\Repository\BaseRepositoryImpl;
use App\Repository\Contracts\WishlistItemRepository;

class WishlistItemRepositoryImpl extends BaseRepositoryImpl implements WishlistItemRepository
{
    public function __construct(Wishlist_Items $wishlistItems)
    {
        $this->model = $wishlistItems;
    }
}
