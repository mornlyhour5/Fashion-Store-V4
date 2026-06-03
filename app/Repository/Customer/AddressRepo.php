<?php

namespace App\Repository\Customer;

use App\Models\Addresses;

class AddressRepo
{
    public function getAll()
    {
        return Addresses::all();
    }

    public function findId($id)
    {
        return Addresses::findOrFail($id);
    }

    public function create(array $data)
    {
        return Addresses::create($data);
    }

    public function update(Addresses $addresses, array $data)
    {
        $addresses->update($data);

        return $addresses->fresh();
    }

    public function delete(Addresses $addresses)
    {
        return $addresses->delete();
    }
}
