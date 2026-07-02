<?php

namespace App\Repository\Product;

use App\Models\Brand;
use App\Repository\BaseRepositoryImpl;
use App\Repository\Contracts\BrandRepository;

class BrandRepositoryImpl extends BaseRepositoryImpl implements BrandRepository
{
    public function __construct(private Brand $brand)
    {
        $this->model = $brand;
    }
}
