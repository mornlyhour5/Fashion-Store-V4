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

    public function create(array $data)
    {
        return Customers::create($data);
    }

    public function update(Customers $customers, array $data)
    {
        $customers->update($data);

        return $customers->fresh();
    }

    public function delete(Customers $customers)
    {
        return $customers->delete();
    }
}
