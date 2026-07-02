<?php

namespace App\Http\Controllers\Product;

// use App\DTO\ProductDTO;

// use App\DTO\ProductDTO;
// use App\Exceptions\BadRequestExcept;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Services\Contracts\ProductServices;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(protected ProductServices $productservices) {}

    public function index()
    {
        return ApiResponse::success($this->productservices->getAllProduct());
    }

    public function show(Request $request,int $id)
    {
        return ApiResponse::success($this->productservices->getProductById($request->all(), $id));
    }

    public function store(Request $request)
    {
        $product = $this->productservices->create($request);

        return ApiResponse::success($product);
    }

    public function update(Request $request, int $id)
    {
       return ApiResponse::success($this->productservices->update($request, $id));
    }

    public function delete(int $id)
    {
        return ApiResponse::success($this->productservices->delete($id));
    }
}
