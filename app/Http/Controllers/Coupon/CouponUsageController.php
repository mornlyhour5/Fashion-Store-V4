<?php

namespace App\Http\Controllers\Coupon;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Services\Contracts\CouponUsageService;
use Illuminate\Http\Request;

class CouponUsageController extends Controller
{
    public function __construct(protected CouponUsageService $coupon_usage_service){}

    public function index()
    {
        return ApiResponse::success($this->coupon_usage_service->getAllCoupon());
    }

    public function show(Request $request, int $id)
    {
        return ApiResponse::success($this->coupon_usage_service->getById($request->all(), $id));
    }

    public function create(Request $request)
    {
        $coupon = $this->coupon_usage_service->create($request);

        return ApiResponse::success($coupon);
    }

    public function update(Request $request, int $id)
    {
        return ApiResponse::success($this->coupon_usage_service->update($request, $id));
    }

    public function delete(int $id)
    {
        return ApiResponse::success($this->coupon_usage_service->delete($id));
    }
}
