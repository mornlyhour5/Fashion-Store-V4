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
        // try{
        //     $wishlist = $this->wishlistServices->getAll();

        //     return response()->json([
        //         'message' => 'Wishlist data retrived successfully',
        //         'data' => $wishlist
        //     ]);
        // }catch (\Exception $e){
        //     return response()->json([
        //         'message' => 'Something went wrong',
        //         'error' => $e->getMessage()
        //     ]);
        // }
        $wishlist = $this->wishlistServices->getWistList($request);

        return ApiResponse::success($wishlist, 'Retrived successfully');
    }

    public function store(Request $request)
    {
        $wishlist = $this->wishlistServices->create($request);

        return ApiResponse::success($wishlist, 'Wishlist created successfully');
    }

    // public function show($id)
    // {
    //     try{
    //         $wishlist = $this->wishlistServices->getWhereId($id);

    //         return response()->json([
    //             'message' => 'Wishlist data retrived successfully',
    //             'data' => $wishlist
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
    //             'user_id' => 'required|exists:users,id'
    //         ]);

    //         $wishlist = $this->wishlistServices->create($request->all());

    //         return response()->json([
    //             'message' => 'Wishlist create successfully',
    //             'data' => $wishlist
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
    //             'user_id' => 'required|unique:users,id'
    //         ]);

    //         $wishlist = $this->wishlistServices->update($request->all(), $id);

    //         return response()->json([
    //             'message' => 'Wishlist update successfully',
    //             'data' => $wishlist
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
    //         $wishlist = $this->wishlistServices->delete($id);

    //         return response()->json([
    //             'message' => 'Wishlist data delete successfully',
    //             'data' => $wishlist
    //         ]);
    //     }catch (\Exception $e){
    //         return response()->json([
    //             'message' => 'Something went wrong',
    //             'error' => $e->getMessage()
    //         ]);
    //     }
    // }
}
