<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Services\Order\OrderStatusHistoryServices;
use Illuminate\Http\Request;

class OrderStatusHistoryController extends Controller
{
    public function __construct(protected OrderStatusHistoryServices $orderStatusHistoryServices)
    {
        $this->orderStatusHistoryServices = $orderStatusHistoryServices;
    }

    public function index()
    {
        try{
            $order = $this->orderStatusHistoryServices->getAll();

            return response()->json([
                'message' => 'success',
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
            $order = $this->orderStatusHistoryServices->getWhereId($id);

            return response()->json([
                'message' => 'success',
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
                'order_id'     => 'required|exists:orders,id',
                'changed_by'   => 'nullable|exists:users,id',
                'from_status'  => 'nullable|string',
                'to_status'    => 'required|string',
                'note'         => 'nullable|string',
                'changed_at'   => 'required|date',
            ]);

            $order = $this->orderStatusHistoryServices->create($request->all());

            return response()->json([
                'message' => 'success',
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
                'order_id'     => 'required|exists:orders,id',
                'changed_by'   => 'nullable|exists:users,id',
                'from_status'  => 'nullable|string',
                'to_status'    => 'required|string',
                'note'         => 'nullable|string',
                'changed_at'   => 'required|date',
            ]);

            $order = $this->orderStatusHistoryServices->update($request->all(), $id);

            return response()->json([
                'message' => 'success',
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
        $order = $this->orderStatusHistoryServices->delete($id);

        return response()->json([
            'message' => 'success',
            'data' => $order
        ]);
    }
}
