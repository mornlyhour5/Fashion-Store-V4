<?php

namespace App\Http\Controllers\Product;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Services\Contracts\BrandService;
use Illuminate\Http\Request;

class BrandController extends Controller
{

    public function __construct(protected BrandService $Brandservices) {}

    // public function index(Request $request)
    // {
    //     return ApiResponse::success($this->Brandservices->getAll($request->all()));
    // }

    public function index()
    {
        return ApiResponse::success($this->Brandservices->getAllBrand());
    }

    // public function getBrandPagination(Request $request)
    // {
    //     return ApiResponse::paginate($this->Brandservices->getBrandPaginaftion($request->all()));
    // }

    public function show(Request $request, $id)
    {
        return ApiResponse::success($this->Brandservices->getBrandById($request->all(), $id));
    }
    public function store(Request $request) {
        $brand = $this->Brandservices->create($request);
        return ApiResponse::success($brand);
    }

    // public function store(Request $request)
    // {
    //     // $validated = $request->validate([
    //     //     'name' => 'required|string|max:255',
    //     //     'slug' => 'nullable|string|max:255',
    //     //     'description' => 'nullable|string|max:255',
    //     //     'logo' => 'required|image|max:2048',
    //     //     'status' => 'nullable|boolean',
    //     //     'sort_order' => 'nullable|integer',
    //     //     'link' => 'nullable|string|max:255',
    //     // ]);

    //     $brand = $this->Brandservices->create($request);
    //     return ApiResponse::success($brand);
    // }

    public function update(Request $request, int $id) {
        return ApiResponse::success($this->Brandservices->updateBrandById($request, $id));
    }

    // public function update(Request $request, int $id)
    // {
    // //     $validated = $request->validate([
    // //         'name' => 'required|string|max:255|unique:brand,name,' . $id,
    // //         'slug' => 'nullable|string|max:255|unique:brand,slug,' . $id,
    // //         'description' => 'nullable|string|max:255',
    // //         'logo'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    // //         'status' => 'nullable|boolean',
    // //         'sort_order' => 'nullable|integer',
    // //         'link' => 'nullable|string|max:255',
    // //     ]);

    // //     return ApiResponse::success($this->Brandservices->update($request->all(), $request));
    //     return ApiResponse::success($this->Brandservices->updateBrandById($request->all(), $id));

    // }

    public function delete(int $id)
    {
        return ApiResponse::success($this->Brandservices->delete($id));
    }
}
