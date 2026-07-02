<?php

namespace App\Repository\Product;

use App\Models\Products;
use App\Repository\BaseRepositoryImpl;
use App\Repository\Contracts\ProductRepository;

class ProductRepositoryImpl extends BaseRepositoryImpl implements ProductRepository
{
    public function __construct(private Products $products)
    {
        $this->model = $products;
    }
}
