<?php

namespace App\Http\Controllers\Product;

// use App\DTO\ProductDTO;

use App\DTO\ProductDTO;
use App\Exceptions\BadRequestExcept;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Services\Product\ProductServices;
use Illuminate\Http\Request;
use App\Enums\GenderProduct;
use App\Enums\ProductStatus;

class ProductController extends Controller
{
    public function __construct(protected ProductServices $productServices)
    {
        $this->productServices = $productServices;
    }

    public function index()
    {
        try {
            $product = $this->productServices->getAll();

            return ApiResponse::success(
                data: ProductResource::collection($product),
                message: 'Products retrieved successfully.',
                code: 200
            );
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }

    public function show($id)
    {
        // return ApiResponse::success($this->productServices->getWhereId($id));
        try {
            $product = $this->productServices->getWhereId($id);

            return ApiResponse::success(
                data: new ProductResource($product),
                message: 'Products retrieved successfully.',
                code: 200
            );
        } catch(\Exception $e){
            return ApiResponse::error(
                code: 404,
                status: 'Not Found',
                message: 'Product not found'
            );
        }catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }

    public function store(Request $request)
    {
        try {
            $dto = ProductDTO::formRequest($request);

            $product = $this->productServices->create($dto);

            return ApiResponse::success(
                data: new ProductResource($product),
                message: 'Product created successfully.',
                code: 201
            );
        } catch(BadRequestExcept $e){
            return ApiResponse::error(
                code: 400,
                status: 'Bad Request',
                message: 'Create product fail',
            );
        }catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }

    public function update(Request $request, int $id)
    {
        try {
            $validated = $request->validate([
                'category_id'    => 'nullable|exists:categories,id',
                'name'        => 'sometimes|string|max:255',
                'base_price'       => 'sometimes|numeric|min:0.01',
                // 'stock'       => 'sometimes|integer|min:0',
                'description' => 'nullable|string',
                'brand'       => 'nullable|string|max:100',
                // 'size'        => 'nullable|string|max:50',
                'gender'       => 'nullable' ?? GenderProduct::UNISEX->value,
                'image'   => 'nullable',
                'status'   => 'nullable' ?? ProductStatus::ACTIVE->value,
            ]);

            $product = $this->productServices->update($validated, $id);

            return ApiResponse::success(
                data: new ProductResource($product),
                message: 'Product updated successfully.'
            );
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return ApiResponse::error(
                code: 404,
                status: 'Not Found',
                message: 'Product not found'
            );
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }

    public function delete(int $id)
    {
        try {
            $this->productServices->delete($id);

            return ApiResponse::success(
                message: 'Product deleted successfully.'
            );
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return ApiResponse::error(
                code: 404,
                status: 'Not Found',
                message: 'Product not found'
            );
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }
}
