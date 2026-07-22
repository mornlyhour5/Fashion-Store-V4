<?php

namespace App\Services\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

interface CouponService
{
    public function getALL();

    public function getCouponWhereById(array $data, int $id): mixed;

    public function create(Request $request): Model;

    public function update(Request $request, int $id): mixed;

    public function delete(int $id): void;
}
