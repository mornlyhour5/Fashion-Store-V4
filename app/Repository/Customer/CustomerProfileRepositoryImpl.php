<?php

namespace App\Repository\Customer;

use App\Models\Customers;
use App\Repository\BaseRepositoryImpl;
use App\Repository\Contracts\CustomerProfileRepository;

class CustomerProfileRepositoryImpl extends BaseRepositoryImpl implements CustomerProfileRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct(Customers $customers)
    {
        $this->model = $customers;
    }
}
