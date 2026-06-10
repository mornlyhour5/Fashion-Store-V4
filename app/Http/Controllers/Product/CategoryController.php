<?php

namespace App\Http\Controllers\Product;

use App\Helpers\ApiResponse;
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
        return ApiResponse::success($this->categoryservices->getData());
    }

    public function show($id)
    {
        return ApiResponse::success($this->categoryservices->getWhereId($id));
    }

    public function store(Request $request)
    {
        return ApiResponse::success($this->categoryservices->create($request->all()));
    }

    public function update(Request $request, $id)
    {
        return ApiResponse::success($this->categoryservices->update($request->all(), $id));
    }

    public function delete($id)
    {
        return ApiResponse::success($this->categoryservices->delete($id));
    }
}
