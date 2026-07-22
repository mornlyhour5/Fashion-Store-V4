<?php

namespace App\Http\Controllers\Product;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Services\Contracts\ProductVariantServices;
use Illuminate\Http\Request;

class ProductVariantController extends Controller
{
    public function __construct(protected ProductVariantServices $productVariantServices){}

    public function index(Request $request)
    {
        // if ($request->has('product_id')) {
        //     // Filter by product_id so frontend gets only this product's variants
        //     $variants = $this->productVariantServices->getAllVariant()
        //         ->where('product_id', $request->product_id)
        //         ->values();
        //     return ApiResponse::success($variants);
        // }
        return ApiResponse::success($this->productVariantServices->getAllVariant());
    }

    public function show(Request $request, int $id)
    {
        $variant = $this->productVariantServices->getVariantById($request, $id);

        return ApiResponse::success($variant);
    }

    public function store(Request $request)
    {
        $variant = $this->productVariantServices->create($request);

        return ApiResponse::success($variant);
    }

    public function update(Request $request,int $id)
    {
            // $validate = $request->validate([
            //     'product_id'            => 'required|exists:products,id',
            //     'sku'                   => 'required|string|max:150',
            //     'color'                 => 'required|string|max:50',
            //     'size'                  => 'required|string|max:20',
            //     'price'                 => 'required|numeric|min:0',
            //     'stock'                 => 'required|integer|min:0',
            //     'low_stock_threshold'   => 'required|integer|min:0',
            //     'image'                 => 'nullable|string|max:1000',
            // ]);
        $variant = $this->productVariantServices->update($request, $id);

        return ApiResponse::success($variant);
    }

    public function delete(int $id)
    {
        $variant = $this->productVariantServices->delete($id);

        return ApiResponse::success($variant);
    }
}
