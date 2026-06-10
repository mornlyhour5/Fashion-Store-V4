<?php

namespace App\Http\Controllers\Cart;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Services\Cart\CartServices;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(protected CartServices $cartServices)
    {
        $this->cartServices = $cartServices;
    }

    public function index()
    {
        return ApiResponse::success($this->cartServices->getAll());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return ApiResponse::success($this->cartServices->create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return ApiResponse::success($this->cartServices->getWhereId($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        return ApiResponse::success($this->cartServices->update($request->all(), $id));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        return ApiResponse::success($this->cartServices->delete($id));
    }
}
