<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Services\Order\OrderItemServices;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    public function __construct(protected OrderItemServices $orderItemServices)
    {
        $this->orderItemServices = $orderItemServices;
    }

    public function index()
    {
        try{
            $order = $this->orderItemServices->getAll();

            return response()->json([
                'message' => 'Order item retrived successfully',
                'data' => $order
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
            $order = $this->orderItemServices->getWhereId($id);

            return response()->json([
                'message' => 'Order item retrived successfully',
                'data' => $order
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
                'order_id'           => 'required|exists:orders,id',
                'product_variant_id' => 'required|exists:product_variants,id',
                'product_id'         => 'nullable|integer',
                'product_name'       => 'required|string|max:255',
                'sku'                => 'nullable|string|max:255',
                'color'              => 'nullable|string|max:100',
                'size'               => 'nullable|string|max:100',
                'quantity'           => 'required|integer|min:1',
                'price'              => 'required|numeric|min:0',
                'subtotal'           => 'required|numeric|min:0',
            ]);

            $order =  $this->orderItemServices->create($request->all());

            return response()->json([
                'message' => 'Order item create successfully',
                'data' => $order
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
                'order_id'           => 'required|exists:orders,id',
                'product_variant_id' => 'required|exists:product_variants,id',
                'product_id'         => 'nullable|integer',
                'product_name'       => 'required|string|max:255',
                'sku'                => 'nullable|string|max:255',
                'color'              => 'nullable|string|max:100',
                'size'               => 'nullable|string|max:100',
                'quantity'           => 'required|integer|min:1',
                'price'              => 'required|numeric|min:0',
                'subtotal'           => 'required|numeric|min:0',
            ]);

            $order =  $this->orderItemServices->update($request->all(), $id);

            return response()->json([
                'message' => 'Order item update successfully',
                'data' => $order
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
        $order =  $this->orderItemServices->delete($id);

        return response()->json([
                'message' => 'Order item deleted successfully',
                'data' => $order
        ]);
    }
}
