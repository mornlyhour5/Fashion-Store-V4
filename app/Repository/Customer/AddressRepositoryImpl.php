<?php

namespace App\Repository\Customer;

use App\Models\Addresses;
use App\Repository\BaseRepositoryImpl;
use App\Repository\Contracts\AddressRepository;

class AddressRepositoryImpl extends BaseRepositoryImpl implements AddressRepository
{
    public function __construct(private Addresses $addresses)
    {
        $this->model = $addresses;
    }
}
