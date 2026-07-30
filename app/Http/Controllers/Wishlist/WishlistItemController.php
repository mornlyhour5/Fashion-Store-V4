<?php

namespace App\Http\Controllers\Wishlist;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Repository\Contracts\CustomerRepository;
use App\Repository\Contracts\ProductImageRepository;
use App\Repository\Contracts\ProductRepository;
use App\Services\Contracts\WishlistItemService;
use Illuminate\Http\Request;

class WishlistItemController extends Controller
{
    public function __construct(
        protected WishlistItemService $wishlistItemServices,
        protected CustomerRepository $customer,
        protected ProductRepository $product,
        protected ProductImageRepository $image,
    ){}


    public function index(Request $request)
    {
        $wishitems = $this->wishlistItemServices->getallitems($request);

        return ApiResponse::success($wishitems, 'Items Wishlist retrived successfully');
    }

    public function getitemadmin(Request $request)
    {
        $wishitems = $this->wishlistItemServices->getallitemAdmin($request);
    }

    public function store(Request $request)
    {
        $item = $this->wishlistItemServices->create($request);

        return ApiResponse::success($item, 'Item added to wishlist successfully');
    }

    public function delete(int $id)
    {
        $wishlist = $this->wishlistItemServices->delete($id);

        return ApiResponse::success($wishlist, 'Remove from wish successfully');
    }


    //for admin
    public function show(Request $request, int $id)
    {
        return ApiResponse::success($this->wishlistItemServices->getWishlishItemAdmin($request, $id));
    }

    public function getWishlishItemAdmin(Request $request, int $id)
    {
        return ApiResponse::success($this->wishlistItemServices->getWishlishItemAdmin($request, $id));
    }


}
