<?php

namespace App\Services\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

interface CouponUsageService
{
    public function getAllCoupon();

    public function getById(array $data, int $id): mixed;

    public function create(Request $request): Model;

    public function update(Request $request, int $id): mixed;

    public function delete(int $id): void;
}
