<?php

namespace App\Http\Controllers\Customer;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Services\Contracts\AddressService;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function __construct(protected AddressService $addressService) {}

    public function index(Request $request)
    {
        // $userId    = $request->user()->id;
        // return ApiResponse::success($this->addressService->getByUserId($userId));
        return ApiResponse::success($this->addressService->getAddress($request));
    }

    public function getAddressAdmin(Request $request)
    {
        return ApiResponse::success($this->addressService->getAddressAdmin($request));
    }

    public function show(Request $request, int $id)
    {
        return ApiResponse::success($this->addressService->getAddressById($request->all(), $id));
    }

    public function store(Request $request)
    {
        return ApiResponse::success($this->addressService->create($request));
    }

    public function update(Request $request,int $id)
    {
        return ApiResponse::success($this->addressService->update($request, $id));
    }

    public function delete(int $id)
    {
        return ApiResponse::success($this->addressService->delete($id));
    }
}
