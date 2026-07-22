<?php

namespace App\Services\Contracts;

use Illuminate\Http\Request;

interface OrderService
{
    public function getAllOrders();

    public function getOrderForuser(Request $request);

    public function createOrder(array $data): mixed;
}
