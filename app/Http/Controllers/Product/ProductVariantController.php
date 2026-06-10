<?php

namespace App\Http\Controllers\Product;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Services\Product\ProductVariantServices;
use Illuminate\Http\Request;

class ProductVariantController extends Controller
{
    public function __construct(protected ProductVariantServices $productVariantServices)
    {
        $this->productVariantServices = $productVariantServices;
    }
    public function index()
    {
        return ApiResponse::success($this->productVariantServices->getAll());
    }

    public function show($id)
    {
        return ApiResponse::success($this->productVariantServices->getWhereId($id));
    }

    public function store(Request $request)
    {
        return ApiResponse::success($this->productVariantServices->create($request->all()));
    }

    public function update(Request $request, $id)
    {
        return ApiResponse::success($this->productVariantServices->update($request->all(), $id));
    }

    public function delete($id)
    {
        return ApiResponse::success($this->productVariantServices->delete($id));
    }
}
