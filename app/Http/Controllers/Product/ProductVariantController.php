<?php

namespace App\Http\Controllers\Product;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Services\Contracts\ProductVariantServices;
use Illuminate\Http\Request;

class ProductVariantController extends Controller
{
    public function __construct(protected ProductVariantServices $productVariantServices){}

    public function index()
    {

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
        $variant = $this->productVariantServices->update($request, $id);

        return ApiResponse::success($variant);
    }

    public function delete(int $id)
    {
        $variant = $this->productVariantServices->delete($id);

        return ApiResponse::success($variant);
    }

    public function deleteImage(int $variantId, int $imageId)
    {
        $this->productVariantServices->deleteImage($variantId, $imageId);

        return ApiResponse::success(null, 'Image removed.');
    }

    public function setMainImage(int $variantId, int $imageId)
    {
        $this->productVariantServices->setMainImage($variantId, $imageId);

        return ApiResponse::success(null, 'Main image updated.');
    }
}




// product variant erorr insert update and in product image doesn't work

