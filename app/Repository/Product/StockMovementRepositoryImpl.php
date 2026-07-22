<?php

namespace App\Repository\Product;

use App\Models\StockMovements;
use App\Repository\BaseRepositoryImpl;
use App\Repository\Contracts\StockMovementRepository;


class StockMovementRepositoryImpl extends BaseRepositoryImpl implements StockMovementRepository
{
    public function __construct(StockMovements $stockMovements)
    {
        $this->model = $stockMovements;
    }
}
