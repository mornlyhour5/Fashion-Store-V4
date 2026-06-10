<?php

namespace App\Http\Controllers\Customer;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Services\Customer\AddressService;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function __construct(protected AddressService $addressService)
    {
        $this->addressService = $addressService;
    }
    
    public function index(Request $request)
    {
        $userId    = $request->user()->id;
        return ApiResponse::success($this->addressService->getByUserId($userId));
    }

    public function show(Request $request, $id)
    {
        return ApiResponse::success($this->addressService->getWhereId($id));
    }

    public function store(Request $request)
    {
        return ApiResponse::success($this->addressService->create($request->all()));
    }

    public function update(Request $request, $id)
    {
        return ApiResponse::success($this->addressService->update($request->all(), $id));
    }

    public function delete($id)
    {
        return ApiResponse::success($this->addressService->delete($id));
    }
}
