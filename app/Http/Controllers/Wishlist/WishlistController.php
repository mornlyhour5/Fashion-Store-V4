<?php

namespace App\Http\Controllers\Wishlist;

use App\Http\Controllers\Controller;
use App\Services\Wishlist\WishlistServices;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function __construct(protected WishlistServices $wishlistServices)
    {
        $this->wishlistServices = $wishlistServices;
    }

    public function index()
    {
        try{
            $wishlist = $this->wishlistServices->getAll();

            return response()->json([
                'message' => 'Wishlist data retrived successfully',
                'data' => $wishlist
            ]);
        }catch (\Exception $e){
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function show($id)
    {
        try{
            $wishlist = $this->wishlistServices->getWhereId($id);

            return response()->json([
                'message' => 'Wishlist data retrived successfully',
                'data' => $wishlist
            ]);
        }catch (\Exception $e){
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function store(Request $request)
    {
        try{
            $request->validate([
                'user_id' => 'required|exists:users,id'
            ]);

            $wishlist = $this->wishlistServices->create($request->all());

            return response()->json([
                'message' => 'Wishlist create successfully',
                'data' => $wishlist
            ]);
        }catch (\Exception $e){
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        try{
            $request->validate([
                'user_id' => 'required|unique:users,id'
            ]);

            $wishlist = $this->wishlistServices->update($request->all(), $id);

            return response()->json([
                'message' => 'Wishlist update successfully',
                'data' => $wishlist
            ]);
        }catch (\Exception $e){
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function delete($id)
    {
        try{
            $wishlist = $this->wishlistServices->delete($id);

            return response()->json([
                'message' => 'Wishlist data delete successfully',
                'data' => $wishlist
            ]);
        }catch (\Exception $e){
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ]);
        }
    }
}
