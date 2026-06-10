<?php

namespace App\Http\Controllers\Cart;

use App\Helpers\ApiResponse;
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
        return ApiResponse::success($this->cartItemServices->getAll());
    }

    public function store(Request $request)
    {
        return ApiResponse::success($this->cartItemServices->create($request->all()));
    }

    public function show($id)
    {
        return ApiResponse::success($this->cartItemServices->getWhereId($id));
    }

    public function update(Request $request, $id)
    {
        return ApiResponse::success($this->cartItemServices->update($request->all(), $id));
    }

    public function delete($id)
    {
        return ApiResponse::success($this->cartItemServices->delete($id));
    }
}
