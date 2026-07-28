<?php

namespace App\Http\Controllers\Order;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Services\Contracts\OrderService;
use Illuminate\Http\Request;

class OrderStatusHistoryController extends Controller
{
    public function __construct(protected OrderService $orderStatusHistory){}

    public function index(Request $request)
    {
        $history = $this->orderStatusHistory->getHistory($request);

        return ApiResponse::success($history, 'Order status history retrieved successfully');
    }
}
