<?php

namespace App\Http\Controllers\Product;

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
        try{
            $productVariant = $this->productVariantServices->getAll();

            return response()->json([
                'message' => 'Product Variant retrived successfully',
                'data' => $productVariant
            ]);
        }catch (\Exception $e){
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function show($id)
    {
        try{
            $productVariant = $this->productVariantServices->getWhereId($id);

            return response()->json([
                'message' => 'Product Variant retrived successfully',
                'data' => $productVariant
            ]);
        }catch (\Exception $e){
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function store(Request $request)
    {
        try{
            $request->validate([
                'product_id' => 'required|exists:products,id',
                'sku'        => 'required|string|max:255|unique:product_variants,sku',
                'color'      => 'nullable|string|max:50',
                'size'       => 'nullable|string|max:50',
                'price'      => 'required|numeric|min:0',
                'stock'      => 'nullable|integer|min:0',
                'low_stock_threshold' => 'nullable|integer|min:0',
                'image'      => 'nullable|string|max:255'
            ]);

            $productVariant = $this->productVariantServices->create($request->all());

            return response()->json([
                'message' => 'Product Variant create successfully',
                'data' => $productVariant
            ]);
        }catch (\Exception $e){
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        try{
            $request->validate([
                'product_id' => 'required|exists:products,id',
                'sku'        => 'required|string|max:255',
                'color'      => 'nullable|string|max:50',
                'size'       => 'nullable|string|max:50',
                'price'      => 'required|numeric|min:0',
                'stock'      => 'nullable|integer|min:0',
                'low_stock_threshold' => 'nullable|integer|min:0',
                'image'      => 'nullable|string|max:255'
            ]);

            $productVariant = $this->productVariantServices->update($request->all(), $id);

            return response()->json([
                'message' => 'Product Variant update successfully',
                'data' => $productVariant
            ]);
        }catch (\Exception $e){
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function delete($id)
    {
        try{
            $productVariant = $this->productVariantServices->delete($id);

            return response()->json([
                'message' => 'Product Variant delete successfully',
                'data' => $productVariant
            ]);
        }catch (\Exception $e){
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ]);
        }
    }
}
