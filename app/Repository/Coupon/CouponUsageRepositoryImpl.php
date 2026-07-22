<?php

namespace App\Repository\Coupon;

use App\Models\Coupon_Usages;
use App\Repository\BaseRepositoryImpl;
use App\Repository\Contracts\CouponUsageRepository;

class CouponUsageRepositoryImpl extends BaseRepositoryImpl implements CouponUsageRepository
{
    public function __construct(Coupon_Usages $couponUsages)
    {
        $this->model = $couponUsages;
    }
}
