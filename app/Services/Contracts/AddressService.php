<?php

namespace App\Services\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

interface AddressService
//
{
    //for customer
    public function getAddressByUserId();

    // public function getAddressById(array $data, int $id): mixed;

    public function create(Request $request): Model;

    public function update(Request $request, int $id): mixed;

    public function delete(int $id): void;


    // this for admin
    public function getAddressAdmin(Request $request);
}
