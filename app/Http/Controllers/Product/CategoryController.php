<?php

namespace App\Http\Controllers\Product;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Services\Contracts\CategoryServices;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(protected CategoryServices $categoryservices){}

    public function index()
    {
        return ApiResponse::success($this->categoryservices->getAllCategory());
    }

    public function show($id)
    {
        return ApiResponse::success($this->categoryservices->getCategoryById($id));
    }

    public function store(Request $request)
    {
        // $validated = $request->validate([
        //     'name'       => 'required|string|max:255',
        //     'slug'       => 'nullable|string|max:255',
        //     'parent_id'  => 'nullable|exists:categories,id',
        //     'status'     => 'nullable|boolean',
        //     'sort_order' => 'nullable|integer',
        //     // 'image'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        //     'image'      => 'nullable|string',
        // ]);

        // $category = $this->categoryservices->create($validated, $request->file('image'));

        // return response()->json([
        //     'message' => 'Category created successfully',
        //     'data'    => $category,
        // ], 201);
        $category = $this->categoryservices->create($request);

        return ApiResponse::success($category);
    }

    public function update(Request $request,int $id)
    {
    //     $validated = $request->validate([
    //         'name'       => 'required|string|max:255|unique:categories,name,' . $id,
    //         'slug'       => 'nullable|string|max:255|unique:categories,slug,' . $id,
    //         'parent_id'  => 'nullable|integer|exists:categories,id|different:id', // can't be its own parent
    //         'status'     => 'nullable|boolean',
    //         'sort_order' => 'nullable|integer',
    //         // 'image'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    //         'image'      => 'nullable|string',
    //     ]);

    //     $category = $this->categoryservices->update($id, $validated, $request->file('image'));

    //     return response()->json([
    //         'message' => 'Category updated successfully',
    //         'data'    => $category,
    //     ]);
        return ApiResponse::success($this->categoryservices->updateCategoryById($request, $id));
    }

    public function delete(int $id)
    {
        return ApiResponse::success($this->categoryservices->delete($id));
    }
}
