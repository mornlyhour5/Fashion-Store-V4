<?php

namespace App\Http\Controllers\Customer;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Services\Contracts\AddressService;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function __construct(protected AddressService $addressService) {}

    public function store(Request $request)
    {
        return ApiResponse::success($this->addressService->create($request));
    }

    public function getAddressByUserId()
    {
        return ApiResponse::success($this->addressService->getAddressByUserId());
    }

    public function update(Request $request,int $id)
    {
        return ApiResponse::success($this->addressService->update($request, $id));
    }

    public function delete(int $id)
    {
        return ApiResponse::success($this->addressService->delete($id));
    }

    //this for admin only
    public function getAddressAdmin(Request $request)
    {
        return ApiResponse::success($this->addressService->getAddressAdmin($request));
    }

    public function getAddressUserforAdmin() //this get for admin manages customer information
    {
        $address = $this->addressService->getAddressByUserId();

        return ApiResponse::success($address, 'address retrived successfully');
    }
}
