<?php

namespace App\Http\Controllers\Product;

use App\DTO\ProductImageDTO;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductImageResource;
use App\Services\Product\ProductImageServices;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ProductImageController extends Controller
{
    public function __construct(protected ProductImageServices $productImageServices)
    {
        $this->productImageServices = $productImageServices;
    }

    public function index()
    {
        // return ApiResponse::success($this->productImageServices->getAll());

        try{
            $image = $this->productImageServices->getAll();

            return ApiResponse::success(
                data: ProductImageResource::collection($image),
                message: 'Product Image retrieved successfully.',
                code: 200
            );
        } catch (\Exception $e){
            return ApiResponse::exception($e);
        }
    }

    public function show($id)
    {
        // return ApiResponse::success($this->);
        try {
            $image = $this->productImageServices->getWhereId($id);

            return ApiResponse::success(
                data: new ProductImageResource($image),
                message: 'Product image retrived successfully.',
                code: 200
            );
        } catch (\Exception $e) {
            return ApiResponse::error(
                code: 404,
                status: 'Not Found',
                message: 'Product Image not found'
            );
        } catch (\Exception $e){
            return ApiResponse::exception($e);
        }
    }

    public function store(Request $request)
    {
        // return ApiResponse::success($this->productImageServices->create($request->all()));
        try {
            $dto = ProductImageDTO::fromRequest($request);

            $image = $this->productImageServices->create($dto);

            return ApiResponse::success(
                data: new ProductImageResource($image),
                message: 'Product image insert successfully',
                code: 201
            );
        } catch(ModelNotFoundException $e){
            return ApiResponse::error(
                code: 400,
                status: 'Bad request',
                message: 'Insert product image fail'
            );
        } catch (\Exception $e){
            return ApiResponse::exception($e);
        }
    }

    public function update(Request $request ,$id)
    {
        // return ApiResponse::success($this->productImageServices->update($request->all(), $id));
        try {
            $validate = $request->validate([
                'product_id'         => 'required|exists:products,id',
                'image_url'          => 'required|string|max:1000',
                'is_main'            => 'nullable',
                'sort_order'         => 'required|integer|min:0',
                'product_variant_id' => 'nullable|exists:product_variants,id'
            ]);

            $image = $this->productImageServices->update($validate, $id);

            return ApiResponse::success(
                data: new ProductImageResource($image),
                message: 'Product image update successfully'
            );

        } catch (ModelNotFoundException $e){
            return ApiResponse::error(
                code: 404,
                status: 'Not found',
                message: 'Product image not found'
            );
        } catch (\Exception $e){
            return ApiResponse::exception($e);
        }
    }

    public function delete($id)
    {
        // return ApiResponse::success($this->productImageServices->delete($id));
        try{
            $this->productImageServices->delete($id);

            return ApiResponse::success(
                message: 'Product Image delete successfully'
            );

        } catch (ModelNotFoundException $e) {
            return ApiResponse::error(
                code: 404,
                status: 'Not found',
                message: 'Product image not found'
            );
        } catch(\Exception $e) {
            return ApiResponse::exception($e);
        }
    }
}
