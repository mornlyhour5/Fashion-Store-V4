<?php

namespace App\Repository\Customer;

use App\Models\Customers;

class CustomerRepo
{
    public function getAll()
    {
        return Customers::all();
    }

    public function findId($id)
    {
        return Customers::findOrFail($id);
    }

    public function create(array $data): Customers
    {
        return Customers::create($data);
    }

    public function update(Customers $customer, array $data): Customers
    {
        $customer->update($data);
        return $customer->fresh();
    }

    public function delete(Customers $customer): bool
    {
        return $customer->delete();
    }
}
