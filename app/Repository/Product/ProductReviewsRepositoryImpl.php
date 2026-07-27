<?php

namespace App\Repository\Product;

use App\Models\Product_Reviews;
use App\Repository\BaseRepositoryImpl;
use App\Repository\Contracts\ProductReviewsRepository;

class ProductReviewsRepositoryImpl extends BaseRepositoryImpl implements ProductReviewsRepository
{
    public function __construct(Product_Reviews $reviews)
    {
        $this->model = $reviews;
    }
}
