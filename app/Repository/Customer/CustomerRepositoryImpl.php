<?php

namespace App\Repository\Customer;

use App\Models\Customers;
// use App\Models\User;
use App\Repository\BaseRepositoryImpl;
use App\Repository\Contracts\CustomerRepository;

class CustomerRepositoryImpl extends BaseRepositoryImpl implements CustomerRepository
{
    public function __construct(Customers $model)
    {
        $this->model = $model;
    }
}
