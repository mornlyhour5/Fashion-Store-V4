<?php

namespace App\Services\Wishlist;

use App\Exceptions\NotFoundExcept;
use App\Exceptions\UnauthExcept;
use App\Models\Wishlist;
use App\Repository\Contracts\WishlistItemRepository;
use App\Services\Contracts\WishlistItemService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistItemServiceImpl implements WishlistItemService
{
    public function __construct(protected WishlistItemRepository $wishlistItem){}

    public function getallitems(Request $request)
    {
        return $this->wishlistItem->getAll();
    }

    public function getallitemAdmin(Request $request)
    {
        return $this->wishlistItem->getAll();
    }

    public function create(Request $request)
    {
        $userId = Auth::guard('api')->id();

        if (!$userId) {
            throw new UnauthExcept();
        }

        $request->validate([
            'wishlist_id' => 'required|integer',
            'product_id'  => 'required|integer|exists:products,id',
        ]);

        $wishlist = Wishlist::where('id', $request->wishlist_id)
            ->where('user_id', $userId)
            ->first();

        if (!$wishlist) {
            throw new NotFoundExcept('Wishlist not found');
        }

        return $this->wishlistItem->create([
            'wishlist_id' => $wishlist->id,
            'product_id'  => $request->product_id,
        ]);
    }

    public function delete(int $id)
    {
        return $this->wishlistItem->deleteById($id);
    }
}
