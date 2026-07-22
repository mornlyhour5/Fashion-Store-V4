<?php

namespace App\Services\Customer;

use App\Repository\Contracts\CustomerRepository;
use App\Repository\Contracts\UserRepository;
use App\Services\Contracts\CustomerService;

class CustomerServiceImpl implements CustomerService
{
    public function __construct(
        protected CustomerRepository $customerRepository,
        protected UserRepository $userRepository
    ) {}

    public function getAllcustomer() //get customer from table user where role customer
    {
        return $this->customerRepository->getAll();
    }

    public function getAllUser(array $filters = []) // get data from repisitory customer where role
    {
        return $this->userRepository->getUser($filters);
    }

    public function getAllStaff(array $filters = []) // get data from repisitory staff where role
    {
         return $this->customerRepository->getStaff();
    }
}
