<?php

namespace App\Http\Controllers\Order;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Services\Contracts\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
class OrderController extends Controller
{
    public function __construct(protected OrderService $orderServices){}

    public function index(): JsonResponse
    {
        $orders = $this->orderServices->getAllOrders();

        return ApiResponse::success($orders, 'Orders retrieved successfully');
    }

    public function getOrderUserforAdmin(int $id)
    {
        $order = $this->orderServices->getOrderByUserId($id);

        return ApiResponse::success($order, 'Orders retrieved successfully');
    }

    public function show(int $id): JsonResponse
    {
        $order = $this->orderServices->getOrderById($id);
        return ApiResponse::success($order, 'Order retrieved successfully');
    }

    public function getforuser(Request $request)
    {
        $orders = $this->orderServices->getOrderForuser($request);

        return ApiResponse::success($orders, 'Orders retrieved successfully');
    }

    public function update(Request $request, int $id)
    {
        $order = $this->orderServices->updateStatus($request->all(), $id);

        return ApiResponse::success($order, 'Update status successfully');
    }
}
