<?php

namespace App\Http\Controllers\Product;

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
        try{
            $product = $this->productServices->getAll();

            return response()->json([
                'message' => 'Product retrived successfully',
                'data' => $product
            ]);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Something went wrong',
                'data' => $e->getMessage()
            ]);
        }
    }

    public function show($id)
    {
        try{
            $product = $this->productServices->getWhereId($id);

            return response()->json([
                'message' => 'Product retrived successfully',
                'data' => $product
            ]);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Something went wrong',
                'data' => $e->getMessage()
            ]);
        }
    }

    public function store(Request $request)
    {
        try{
            $request->validate([
                'category_id'   => 'required',
                'name'          => 'required|string|max:500',
                'description'   => 'nullable',
                'brand'         => 'nullable',
                'base_price'    => 'required',
                'gender'        => 'nullable',
                'status'        => 'nullable',
                'image'         => 'nullable'
            ]);

            $product = $this->productServices->create($request->all());

            return response()->json([
                'message' => 'Product insert successfully',
                'data' => $product
            ]);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Something went wrong',
                'data' => $e->getMessage()
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        try{
            $request->validate([
                'category_id'   => 'required',
                'name'          => 'required|string|max:500',
                'description'   => 'nullable',
                'brand'         => 'nullable',
                'base_price'    => 'required',
                'gender'        => 'nullable',
                'status'        => 'nullable',
                'image'         => 'nullable'
            ]);

            $product = $this->productServices->update($request->all(), $id);

            return response()->json([
                'message' => 'Product update successfully',
                'data' => $product
            ]);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Something went wrong',
                'data' => $e->getMessage()
            ]);
        }
    }

    public function delete($id)
    {
        try{
            $product = $this->productServices->delete($id);

            return response()->json([
                'message' => 'Product delete successfully',
                'data' => $product
            ]);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Something went wrong',
                'data' => $e->getMessage()
            ]);
        }
    }
}
