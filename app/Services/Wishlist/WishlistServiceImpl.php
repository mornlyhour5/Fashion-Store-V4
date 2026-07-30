<?php

namespace App\Services\Wishlist;

use App\Exceptions\UnauthExcept;
use App\Repository\Contracts\WishlistRepository;
use App\Services\Contracts\WishlistService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistServiceImpl implements WishlistService
{
    public function __construct(protected WishlistRepository $wishlistRepository){}

    public function getWistList(Request $request)
    {
        $userId = Auth::guard('api')->id();
        if (!$userId) {
            throw new UnauthExcept();
        }

        return $this->wishlistRepository->pagination(
            fileters: $request->except('user_id'),
            conditions: ['user_id' => $userId, 'deleted_at' => null],
            limit: (int) $request->input('per_page', 20),
            rawSort: $request->input('sort', '-created_at'),
            with: ['user', 'items', 'items.product'],
        );
    }

    public function create(Request $request)
    {
        $userId = Auth::guard('api')->id();

        if (!$userId) {
            throw new UnauthExcept();
        }

        $existing = $this->wishlistRepository->query()
            ->where('user_id', $userId)
            ->first();

        if ($existing) {
            return $existing;
        }

        return $this->wishlistRepository->create(['user_id' => $userId]);
    }






    // for admin
    public function getWishlishAdmin()
    {
        return $this->wishlistRepository->getAll();
    }
}
