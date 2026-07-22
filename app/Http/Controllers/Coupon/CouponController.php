<?php

namespace App\Http\Controllers\Coupon;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Services\Contracts\CouponService;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function __construct(protected CouponService $coupon) {}

    public function index()
    {
        return ApiResponse::success($this->coupon->getAll());
    }

    public function show(Request $request, int $id)
    {
        return ApiResponse::success($this->coupon->getCouponWhereById($request->all(),$id));
    }

    public function create(Request $request)
    {
        $coupons = $this->coupon->create($request);

        return ApiResponse::success($coupons);
    }

    public function update(Request $request, int $id)
    {
        return ApiResponse::success($this->coupon->update($request, $id));
    }

    public function delete(int $id)
    {
        return ApiResponse::success($this->coupon->delete($id));
    }
}
