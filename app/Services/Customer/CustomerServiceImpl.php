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

    public function getAllcustomer()
    {
        return $this->customerRepository->getAll();
    }

    public function getAllUser(array $filters = [])
    {
        return $this->userRepository->getUser($filters);
    }

    public function getAllStaff(array $filters = [])
    {
         return $this->customerRepository->getStaff();
    }
}
