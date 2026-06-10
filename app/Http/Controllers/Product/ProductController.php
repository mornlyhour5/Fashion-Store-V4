<?php

namespace App\Http\Controllers\Product;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Services\Product\ProductServices;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(protected ProductServices $productServices)
    {
        $this->productServices = $productServices;
    }

    public function index()
    {
        return ApiResponse::success($this->productServices->getAll());
    }

    public function show($id)
    {
        return ApiResponse::success($this->productServices->getWhereId($id));
    }

    public function store(Request $request)
    {
        return ApiResponse::success($this->productServices->create($request->all()));
    }

    public function update(Request $request, $id)
    {
        return ApiResponse::success($this->productServices->update($request->all(), $id));
    }

    public function delete($id)
    {
        return ApiResponse::success($this->productServices->delete($id));
    }
}
