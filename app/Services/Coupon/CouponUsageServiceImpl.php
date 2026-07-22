<?php

namespace App\Services\Coupon;

use App\Exceptions\NotFoundExcept;
use App\Helpers\ApiResponse;
use App\Helpers\CustomValidator;
use App\Repository\Contracts\CouponUsageRepository;
use App\Services\Contracts\CouponUsageService;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class CouponUsageServiceImpl implements CouponUsageService
{
    public function __construct(
        protected CouponUsageRepository $coupon_usage,
        protected CustomValidator $validator
    ) {}

    private function CouponUsage(array $data)
    {
        $rules = [
            'used_at'   => 'required|date',
            'coupon_id' => 'required|integer|exists:coupons,id',
            'user_id'   => 'required|integer|exists:users,id',
            'order_id'  => 'required|integer|exists:orders,id',
        ];
        return $this->validator->validate($data, $rules);
    }

    public function getAllCoupon()
    {
        return ApiResponse::success($this->coupon_usage->getAll());
    }

    public function getById(array $data, int $id): mixed
    {
        $usage = $this->coupon_usage->findById($id);

        if (!$usage) {
            throw new NotFoundExcept(__('messages.not_found', [
                'info' => 'general.coupon_usage'
            ]));
        }
        return $usage;
    }

    public function create(Request $request): Model
    {
        $validated = $this->CouponUsage($request->all());

        return $this->coupon_usage->create($validated);
    }

    public function update(Request $request, int $id): mixed
    {
        $coupon = $this->coupon_usage->findById($id);

        if (!$coupon) {
            throw new NotFoundExcept(__('messages.not_found', [
                'info' => 'general.boupon_usages'
            ]));
        }

        $validated = $this->CouponUsage($request->all());
        return $this->coupon_usage->updateById($id, $validated);
    }

    public function delete(int $id): void
    {
        $coupon = $this->coupon_usage->findById($id);

        if (!$coupon) {
            throw new NotFoundExcept(__('messages.not_found', [
                'info' => 'general.boupon_usages'
            ]));
        }
        $this->coupon_usage->deleteById($id);
    }


}
