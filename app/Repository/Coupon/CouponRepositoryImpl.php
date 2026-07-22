<?php

namespace App\Repository\Coupon;

use App\Models\Coupons;
use App\Repository\BaseRepositoryImpl;
use App\Repository\Contracts\CouponRepository;

//get function from baseRepositoryImpl it's base logic
class CouponRepositoryImpl extends BaseRepositoryImpl implements CouponRepository
{
    public function __construct(Coupons $coupon)
    {
        $this->model = $coupon;
    }
}
