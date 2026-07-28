<?php

namespace App\Services\Contracts;

// use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface OrderService
{
    public function getAllOrders();


    public function getOrderForuser(Request $request);

    public function getOrderById(int $id);

    public function createOrder(array $data): mixed;

    public function updateStatus(array $data, int $id);



    //this route for order status history

    public function getHistory(Request $request);


}
