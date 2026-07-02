<?php

namespace App\Repository\Product;

use App\Models\Categories;
use App\Repository\BaseRepositoryImpl;
use App\Repository\Contracts\CategoryRepository;

class CategoryRepositoryImpl extends BaseRepositoryImpl implements CategoryRepository
{
    public function __construct(private Categories $categories)
    {
        $this->model = $categories;
    }
}
