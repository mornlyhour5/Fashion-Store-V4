<?php

namespace App\Services\Coupon;

use App\Exceptions\NotFoundExcept;
use App\Helpers\CustomValidator;
use App\Repository\Contracts\CouponRepository;
use App\Services\Contracts\CouponService;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class CouponServiceImpl implements CouponService
{

    public function __construct(
        protected CouponRepository $coupon,
        protected CustomValidator $validator
    ) {}

    // version 1 build for admin only
    private function Coupon(array $data)
    {
        $rules = [
            'code' => 'required',
            'type' => 'nullable',
            'value' => 'nullable',
            'minimum_order' => 'nullable',
            'maximum_discount' => 'nullable',
            'usage_limit' => 'nullable',
            'usage_count' => 'nullable',
            'is_active' => 'nullable',
            'starts_at' => 'nullable',
            'expires_at' => 'nullable'
        ];
        return $this->validator->validate($data ,$rules);
    }

    public function getALL()
    {
        return $this->coupon->getAll();
    }

    public function getCouponWhereById(array $data, int $id): mixed
    {
        $coupon = $this->coupon->findById($id, select: [
            'id', 'type', 'value', 'is_active', 'starts_at', 'expires_at'
        ]);

        if (!$coupon) {
            throw new NotFoundExcept(__('messages.not_found', [
                'info' => __('general.coupon')
            ]));
        }
        return $coupon;
    }

    public function create(Request $request): Model
    {
        $validated = $this->Coupon($request->all());

        return $this->coupon->create($validated);
    }

    public function update(Request $request, int $id): mixed
    {
        $validated = $this->Coupon($request->all());

        return $this->coupon->updateById($id, $validated);
    }

    public function delete(int $id): void
    {
        $coupon = $this->coupon->findById($id);

        if (!$coupon) {
            throw new NotFoundExcept(__('message.not_found', [
                'info' => 'general.coupon'
            ]));
        }
        $this->coupon->deleteById($id);
    }

}
