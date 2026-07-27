<?php

namespace App\Repository\Product;

use App\Models\Product_Images;
use App\Repository\BaseRepositoryImpl;
use App\Repository\Contracts\ProductImageRepository;

class ProductImageRepositoryImpl extends BaseRepositoryImpl implements ProductImageRepository
{
    public function __construct(Product_Images $productImages)
    {
        parent::__construct($productImages);
    }
}
