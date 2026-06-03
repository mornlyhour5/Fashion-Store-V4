<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Services\Product\CategoryServices;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(protected CategoryServices $categoryservices)
    {
        $this->categoryservices = $categoryservices;
    }

    public function index()
    {
        $category = $this->categoryservices->getData();

        return response()->json([
            'message' => 'Categories retrived successfully',
            'data' => $category
        ]);
    }

    public function show($id)
    {
        try{
            $category = $this->categoryservices->getWhereId($id);

            return response()->json([
                'message' => 'Categories retrived successfully',
                'data' => $category
            ]);
        } catch (\Exception $e){
            return response()->json([
                'message' => 'Somthing went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try{
            $request->validate([
                'name' => 'required|string|unique:categories,name',
                'image' => 'nullable'
            ]);

            $categories = $this->categoryservices->create($request->all());

            return response()->json([
                'message' => 'Categories create successfully',
                'data' =>  $categories
            ]);
        } catch (\Exception $e){
            return response()->json([
                'message' => 'Somthing went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function update(Request $request, $id)
    {
        try{
            $request->validate([
                'name' => 'required|string|unique:categories,name',
                'image' => 'nullable'
            ]);

            $categories = $this->categoryservices->update($request->all(), $id);

            return response()->json([
                'message' => 'Category update successfully',
                'data' =>  $categories
            ]);
        } catch(\Exception $e){
            return response()->json([
                'message' => 'Somthing went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function delete($id)
    {
        try{
            $categories = $this->categoryservices->delete($id);

            return response()->json([
                'message' => 'Categories delete successfully',
                'data' => $categories
            ]);
        } catch(\Exception $e){
            return response()->json([
                'message' => 'Somthing went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
