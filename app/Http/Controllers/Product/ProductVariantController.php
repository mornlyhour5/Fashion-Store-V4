<?php

namespace App\Http\Controllers\Product;

use App\DTO\ProductVariantDTO;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductVariantResource;
use App\Services\Product\ProductVariantServices;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ProductVariantController extends Controller
{
    public function __construct(protected ProductVariantServices $productVariantServices)
    {
        $this->productVariantServices = $productVariantServices;
    }
    public function index()
    {
        // return ApiResponse::success($this->productVariantServices->getAll());

        try {
            $product = $this->productVariantServices->getAll();

            return ApiResponse::success(
                data: ProductVariantResource::collection($product),
                message: 'Products varient retrieved successfully.',
                code: 200
            );
        } catch (\Exception $e){
            return ApiResponse::exception($e);
        }
    }

    public function show($id)
    {
        // return ApiResponse::success($this->productVariantServices->getWhereId($id));
        try {
            $product = $this->productVariantServices->getWhereId($id);

            return ApiResponse::success(
                data: new ProductVariantResource($product),
                message: 'Products varient retrieved successfully.',
                code: 200
            );
        } catch (\Exception $e){
            return ApiResponse::error(
                code: 404,
                status: 'Not Found',
                message: 'Product Variant not found'
            );
        } catch (\Exception $e){
            return ApiResponse::exception($e);
        }
    }

    public function store(Request $request)
    {
        // return ApiResponse::success($this->productVariantServices->create($request->all()));

        try{
            $dto = ProductVariantDTO::fromRequest($request);

            $product = $this->productVariantServices->create($dto);

            return ApiResponse::success(
                data: new ProductVariantResource($product),
                message: 'Product varaint created successfully.',
                code: 201
            );
        } catch (\Exception $e){
            return ApiResponse::error(
                code: 400,
                status: 'Bad Request',
                message: 'Create product variant fail'
            );
        } catch (\Exception $e){
            return ApiResponse::exception($e);
        }
    }

    public function update(Request $request,int $id)
    {
        // return ApiResponse::success($this->productVariantServices->update($request->all(), $id));
        try {
            $validate = $request->validate([
                'product_id'            => 'required|exists:products,id',
                'sku'                   => 'required|string|max:150',
                'color'                 => 'required|string|max:50',
                'size'                  => 'required|string|max:20',
                'price'                 => 'required|numeric|min:0',
                'stock'                 => 'required|integer|min:0',
                'low_stock_threshold'   => 'required|integer|min:0',
                'image'                 => 'nullable|string|max:1000',
            ]);

            $product = $this->productVariantServices->update($validate, $id);

            return ApiResponse::success(
                data: new ProductVariantResource($product),
                message: 'Product varaint update successfully.'
            );
        } catch(ModelNotFoundException $e) {
            return ApiResponse::error(
                code: 404,
                status: 'Not found',
                message: 'Product variant not found'
            );
        } catch (\Exception $e){
            return ApiResponse::exception($e);
        }
    }

    public function delete($id)
    {
        // return ApiResponse::success($this->productVariantServices->delete($id));
        try {
            $this->productVariantServices->delete($id);

            return ApiResponse::success(
                message: 'Product variant deleted successfully.'
            );
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error(
                code: 404,
                status: 'Not Found',
                message: 'Product variant not found'
            );
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }
}
