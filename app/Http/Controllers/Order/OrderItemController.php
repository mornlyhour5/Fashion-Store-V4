<?php

namespace App\Http\Controllers\Order;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Services\Contracts\OrderItemService;


class OrderItemController extends Controller
{
    public function __construct(protected OrderItemService $orderItemServices){}

    public function getItemsByOrder(int $id)
    {
        return ApiResponse::success($this->orderItemServices->getItemsByOrder($id));
    }

}
