<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Services\Cart\CartServices;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(protected CartServices $cartServices)
    {
        $this->cartServices = $cartServices;
    }

    public function index()
    {
        try{
            $cart = $this->cartServices->getAll();

            return response()->json([
                'message' => 'Cart retrived successfully',
                'data' => $cart
            ]);
        }catch (\Exception $e){
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $request->validate([
                'user_id' => 'required|exists:users,id',
                'session_id' => 'nullable'
            ]);

            $cart = $this->cartServices->create($request->all());

            return response()->json([
                'message' => 'Cart retrived successfully',
                'data' => $cart
            ]);
        }catch (\Exception $e){
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try{
            $cart = $this->cartServices->getWhereId($id);

            return response()->json([
                'message' => 'Cart retrived successfully',
                'data' => $cart
            ]);
        }catch (\Exception $e){
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try{
            $request->validate([
                'user_id' => 'required|exists:users,id',
                'session_id' => 'nullable'
            ]);

            $cart = $this->cartServices->update($request->all(), $id);

            return response()->json([
                'message' => 'Cart update successfully',
                'data' => $cart
            ]);
        }catch (\Exception $e){
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try{
            $cart = $this->cartServices->delete($id);

            return response()->json([
                'message' => 'Cart delete successfully',
                'data' => $cart
            ]);
        }catch (\Exception $e){
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ]);
        }
    }
}
