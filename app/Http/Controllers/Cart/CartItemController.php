<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Services\Cart\CartItemServices;
use Illuminate\Http\Request;

class CartItemController extends Controller
{
    public function __construct(protected CartItemServices $cartItemServices)
    {
        $this->cartItemServices = $cartItemServices;
    }

    public function index()
    {
        try{
            $cart = $this->cartItemServices->getAll();

            return response()->json([
                'messaage' => 'Cart item retrived successfully',
                'data' => $cart
            ]);

        }catch(\Exception $e){
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
                'cart_id'            => 'required|exists:carts,id',
                'product_variant_id' => 'required|exists:product_variants,id',
                'quantity'           => 'required',
                'price'              => 'required|decimal'
            ]);

            $cart = $this->cartItemServices->create($request->all());

            return response()->json([
                'message' => 'Cart create successfully',
                'data' => $cart
            ]);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function show($id)
    {
        try{
            $cart = $this->cartItemServices->getWhereId($id);

            return response()->json([
                'message' => 'Cart retrive successfully',
                'data' => $cart
            ]);
        }catch(\Exception $e){
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
                'cart_id'            => 'required|exists:carts,id',
                'product_variant_id' => 'required|exists:product_variants,id',
                'quantity'           => 'required',
                'price'              => 'required|decimal'
            ]);

            $cart = $this->cartItemServices->update($request->all(), $id);

            return response()->json([
                'message' => 'Cart update successfully',
                'data' => $cart
            ]);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function delete($id)
    {
        try{
            $cart = $this->cartItemServices->delete($id);

            return response()->json([
                'message' => 'Cart delete successfully',
                'data' => $cart
            ]);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ]);
        }
    }
}
