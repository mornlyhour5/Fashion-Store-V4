<?php

namespace App\Http\Controllers\Product;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Services\Contracts\ProductReviewsService;
// use Illuminate\Http\Request;

class ProductReviewController extends Controller
{
    public function __construct(protected ProductReviewsService $reviews){}

    public function index()
    {
        return ApiResponse::success($this->reviews->getAll());
    }

    public function delete(int $id)
    {
        return ApiResponse::success($this->reviews->delete($id));
    }
}
