<?php

namespace App\Http\Controllers\Wishlist;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Services\Contracts\WishlistItemService;
use Illuminate\Http\Request;

class WishlistItemController extends Controller
{
    public function __construct(protected WishlistItemService $wishlistItemServices){}


    public function index(Request $request)
    {
        // try{
        //     $wish = $this->wishlistItemServices->getAll();

        //     return response()->json([
        //         'message' => 'Data retrived successfully',
        //         'data' => $wish
        //     ]);
        // }catch (\Exception $e){
        //     return response()->json([
        //         'message' => 'Something went wrong',
        //         'error' => $e->getMessage()
        //     ]);
        // }

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

    // public function show($id)
    // {
    //     try{
    //         $wish = $this->wishlistItemServices->getWhereId($id);

    //         return response()->json([
    //             'message' => 'Data retrived successfully',
    //             'data' => $wish
    //         ]);
    //     }catch (\Exception $e){
    //         return response()->json([
    //             'message' => 'Something went wrong',
    //             'error' => $e->getMessage()
    //         ]);
    //     }
    // }

    // public function store(Request $request)
    // {
    //     try{
    //         $request->validate([
    //             'wishlist_id' => 'required|exists:wishlists,id',
    //             'product_id'  => 'required|exists:products,id',
    //         ]);

    //         $wish = $this->wishlistItemServices->create($request->all());

    //         return response()->json([
    //             'message' => 'Data retrived successfully',
    //             'data' => $wish
    //         ]);
    //     }catch (\Exception $e){
    //         return response()->json([
    //             'message' => 'Something went wrong',
    //             'error' => $e->getMessage()
    //         ]);
    //     }
    // }

    // public function update(Request $request, $id)
    // {
    //     try{
    //         $request->validate([
    //             'wishlist_id' => 'required|exists:wishlists,id',
    //             'product_id'  => 'required|exists:products,id',
    //         ]);

    //         $wish = $this->wishlistItemServices->update($request->all(), $id);

    //         return response()->json([
    //             'message' => 'Data update successfully',
    //             'data' => $wish
    //         ]);
    //     }catch (\Exception $e){
    //         return response()->json([
    //             'message' => 'Something went wrong',
    //             'error' => $e->getMessage()
    //         ]);
    //     }
    // }

    // public function delete($id)
    // {
    //     try{
    //         $wish = $this->wishlistItemServices->delete($id);

    //         return response()->json([
    //             'message' => 'Data delete successfully',
    //             'data' => $wish
    //         ]);
    //     }catch (\Exception $e){
    //         return response()->json([
    //             'message' => 'Something went wrong',
    //             'error' => $e->getMessage()
    //         ]);
    //     }
    // }
}
