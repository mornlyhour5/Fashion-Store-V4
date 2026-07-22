<?php

namespace App\Services\Contracts;

interface CustomerService
{
    public function getAllcustomer();

    public function getAllUser(array $filters = []);

    public function getAllStaff(array $filters = []);
}
