<?php

namespace App\Http\Controllers\Wishlist;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Services\Contracts\WishlistService;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function __construct(protected WishlistService $wishlistServices){}

    public function index(Request $request)
    {
        $wishlist = $this->wishlistServices->getWistList($request);

        return ApiResponse::success($wishlist, 'Retrived successfully');
    }

    public function store(Request $request)
    {
        $wishlist = $this->wishlistServices->create($request);

        return ApiResponse::success($wishlist, 'Wishlist created successfully');
    }
}
