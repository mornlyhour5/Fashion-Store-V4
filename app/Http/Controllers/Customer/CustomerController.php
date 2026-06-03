<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Services\Customer\CustomerService;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function __construct(protected CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    public function index()
    {
        try{
            $customers = $this->customerService->getAll();

            return response()->json([
                'message' => 'Data customer retrived successfully',
                'data' => $customers
            ]);
        }catch (\Exception $e){
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ]);
        }
    }

    // publuc function getProfile

    public function show($id)
    {
        try{
            $customers = $this->customerService->getWhereId($id);

            return response()->json([
                'message' => 'Data customer retrived successfully',
                'data' => $customers
            ]);
        }catch (\Exception $e){
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function store(Request $request)
    {
        try{
            $request->validate([
                'user_id'             => 'required|exists:users,id',
                'full_name'           => 'required|string|max:255',
                'phone'               => 'nullable|string|max:20',
                'gender'              => 'nullable',
                'date_of_birth'       => 'nullable|date',
                'preferred_language'  => 'nullable|string|max:10',
                'note'                => 'nullable|string',
            ]);

            $customers = $this->customerService->create($request->all());

            return response()->json([
                'message' => 'Customer create successfully',
                'data' => $customers
            ]);
        }catch (\Exception $e){
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        try{
            $request->validate([
                'user_id'             => 'required|exists:users,id',
                'full_name'           => 'required|string|max:255',
                'phone'               => 'nullable|string|max:20',
                'gender'              => 'nullable',
                'date_of_birth'       => 'nullable|date',
                'preferred_language'  => 'nullable|string|max:10',
                'note'                => 'nullable|string',
            ]);

            $customers = $this->customerService->update($request->all(), $id);

            return response()->json([
                'message' => 'Customer update successfully',
                'data' => $customers
            ]);
        }catch (\Exception $e){
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function delete($id)
    {
        try{
            $customers = $this->customerService->delete($id);

            return response()->json([
                'message' => 'Data customer delete successfully',
                'data' => $customers
            ]);
        }catch (\Exception $e){
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ]);
        }
    }
}
