<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Services\Order\OrderServices;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(protected OrderServices $orderServices)
    {
        $this->orderServices = $orderServices;
    }

    public function index()
    {
        try{
            $order = $this->orderServices->getAll();

            return response()->json([
                'message' => 'Order . successfully',
                'data' => $order
            ]);
        } catch (\Exception $e){
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function show($id)
    {
        try{
            $order = $this->orderServices->getWhereId($id);

            return response()->json([
                'message' => 'Order . successfully',
                'data' => $order
            ]);
        } catch (\Exception $e){
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
                'user_id'            => 'required|exists:users,id',
                'address_id'         => 'nullable|exists:addresses,id',
                'subtotal'           => 'required|numeric|min:0',
                'shipping_fee'       => 'nullable|numeric|min:0',
                'discount'           => 'nullable|numeric|min:0',
                'total_amount'       => 'required|numeric|min:0',

                'payment_method'     => 'required',
                'payment_status'     => 'nullable',
                'order_status'       => 'nullable',

                'shipping_address'   => 'required|string',
                'note'               => 'nullable|string',
            ]);

            $order = $this->orderServices->create($request->all());

            return response()->json([
                'message' => 'Order create successfully',
                'data' => $order
            ]);
        } catch (\Exception $e){
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
                'user_id'            => 'required|exists:users,id',
                'address_id'         => 'nullable|exists:addresses,id',
                // 'order_number'       => 'required|string|unique:orders,order_number',

                'subtotal'           => 'required|numeric|min:0',
                'shipping_fee'       => 'nullable|numeric|min:0',
                'discount'           => 'nullable|numeric|min:0',
                'total_amount'       => 'required|numeric|min:0',

                'payment_method'     => 'required',
                'payment_status'     => 'nullable',
                'order_status'       => 'nullable',

                'shipping_address'   => 'required|string',
                'note'               => 'nullable|string',

                // 'paid_at'            => 'nullable|date',
                // 'shipped_at'         => 'nullable|date',
                // 'delivered_at'       => 'nullable|date',
                // 'cancelled_at'       => 'nullable|date',
            ]);

            $order = $this->orderServices->update($request->all(), $id);

            return response()->json([
                'message' => 'Order update successfully',
                'data' => $order
            ]);
        } catch (\Exception $e){
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function delete($id)
    {
        try{
            $order = $this->orderServices->delete($id);

            return response()->json([
                'message' => 'Order delete successfully',
                'data' => $order
            ]);
        } catch (\Exception $e){
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ]);
        }
    }
}
