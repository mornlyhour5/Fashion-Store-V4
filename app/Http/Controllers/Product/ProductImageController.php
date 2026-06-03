<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Services\Product\ProductImageServices;
use Illuminate\Http\Request;

class ProductImageController extends Controller
{
    public function __construct(protected ProductImageServices $productImageServices)
    {
        $this->productImageServices = $productImageServices;
    }

    public function index()
    {
        try{
            $image = $this->productImageServices->getAll();

            return response()->json([
                'message' => 'Product image retrived successfully',
                'data' => $image
            ]);
        } catch(\Exception $e){
            return response()->json([
                'message' => 'Something went wrong',
                'error' =>  $e->getMessage()
            ]);
        }
    }

    public function show($id)
    {
        try{
            $image = $this->productImageServices->getWhereId($id);
            return response()->json([
                'message' => 'Product image retrived successfully',
                'data' => $image
            ]);
        } catch(\Exception $e){
            return response()->json([
                'message' => 'Something went wrong',
                'error' =>  $e->getMessage()
            ]);
        }
    }

    public function store(Request $request)
    {
        try{
            $request->validate([
                'product_id' => 'required',
                'image_url' => 'required|string|max:1000',
            ]);
            $image = $this->productImageServices->create($request->all());
            return response()->json([
                'message' => 'Product image insert successfully',
                'data' => $image
            ]);
        } catch(\Exception $e){
            return response()->json([
                'message' => 'Something went wrong',
                'error' =>  $e->getMessage()
            ]);
        }
    }

    public function update(Request $request ,$id)
    {
        try{
            $request->validate([
                'product_id' => 'required',
                'image_url' => 'required|string|max:1000',
            ]);
            $image = $this->productImageServices->update($request->all(), $id);
            return response()->json([
                'message' => 'Product image update successfully',
                'data' => $image
            ]);
        } catch(\Exception $e){
            return response()->json([
                'message' => 'Something went wrong',
                'error' =>  $e->getMessage()
            ]);
        }
    }

    public function delete($id)
    {
        try{
            $image = $this->productImageServices->delete($id);
            return response()->json([
                'message' => 'Product image delete successfully',
                'data' => $image
            ]);
        } catch(\Exception $e){
            return response()->json([
                'message' => 'Something went wrong',
                'error' =>  $e->getMessage()
            ]);
        }
    }
}
