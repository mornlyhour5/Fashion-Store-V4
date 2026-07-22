<?php

namespace App\Services\Contracts;

interface CustomerService
{
    public function getAllcustomer();

    public function getAllUser(array $filters = []); // get user role customer only

    public function getAllStaff(array $filters = []); // get data from user table where role staff
}
