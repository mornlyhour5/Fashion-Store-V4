<?php

namespace App\Http\Controllers\Product;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Services\Product\ProductImageServices;
use Illuminate\Http\Request;

class ProductImageController extends Controller
{
    public function __construct(protected ProductImageServices $productImageServices)
    {
        $this->productImageServices = $productImageServices;
    }

    public function index()
    {
        return ApiResponse::success($this->productImageServices->getAll());
    }

    public function show($id)
    {
        return ApiResponse::success($this->productImageServices->getWhereId($id));
    }

    public function store(Request $request)
    {
        return ApiResponse::success($this->productImageServices->create($request->all()));
    }

    public function update(Request $request ,$id)
    {
        return ApiResponse::success($this->productImageServices->update($request->all(), $id));
    }

    public function delete($id)
    {
        return ApiResponse::success($this->productImageServices->delete($id));
    }
}
