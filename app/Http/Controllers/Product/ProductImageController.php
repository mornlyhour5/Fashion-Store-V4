<?php

namespace App\Http\Controllers\Product;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Services\Contracts\ProductImageServices;
use App\Services\Contracts\ProductVariantServices;
use Illuminate\Http\Request;

class ProductImageController extends Controller
{
    public function __construct(
        protected ProductImageServices $productImageServices,
        protected ProductVariantServices $productVariantServices
        ) {}

    // public function index(Request $request)
    // {
    //     if ($request->has('product_id')) {
    //         // Filter by product_id so frontend gets only this product's variants
    //         $variants = $this->productVariantServices->getAllVariant()
    //             ->where('product_id', $request->product_id)
    //             ->values();
    //     }
    //     if ($request->has('product_id')) {
    //         $images = $this->productImageServices->getAllProductImage()
    //             ->where('product_variant_id', $request->$variants)
    //             ->values();
    //         return ApiResponse::success($images);
    //     }
    //     // return ApiResponse::success($this->productImageServices->getAllProductImage());
    // }

    public function index(Request $request)
    {

        // If product_id exists, filter variants first
        // if ($request->has('product_id')) {

        //     // 1. Get variants by product_id
        //     $variants = $this->productVariantServices
        //         ->getAllVariant()
        //         ->where('product_id', $request->product_id)
        //         ->values();

        //     // 2. Extract variant IDs
        //     $variantIds = $variants->pluck('id');

        //     // 3. Get images by variant IDs
        //     $images = $this->productImageServices
        //         ->getAllProductImage()
        //         ->whereIn('product_variant_id', $variantIds)
        //         ->values();

        //     return ApiResponse::success($images);
        // }

        // // Default: return all images
        return ApiResponse::success(
            $this->productImageServices->getAllProductImage($request)
        );
    }

    public function show(Request $request,int $id)
    {
        $image = $this->productImageServices->getProductImageWhereId($request, $id);

        return ApiResponse::success($image);
    }

    public function store(Request $request)
    {
        $image = $this->productImageServices->create($request);

        return ApiResponse::success($image);
    }

    public function update(Request $request,int $id)
    {
                // 'product_id'         => 'required|exists:products,id',
                // 'image_url'          => 'required|string|max:1000',
                // 'is_main'            => 'nullable',
                // 'sort_order'         => 'required|integer|min:0',
                // 'product_variant_id' => 'nullable|exists:product_variants,id'
        $image = $this->productImageServices->update($request, $id);

        return ApiResponse::success($image);
    }

    public function delete(int $id)
    {
        return ApiResponse::success($this->productImageServices->delete($id));
    }
}
