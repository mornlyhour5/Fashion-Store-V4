<?php

namespace App\Http\Controllers\Customer;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Services\Customer\CustomerService;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function __construct(protected CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    public function me(Request $request)
    {
        $customer = \App\Models\Customers::where('user_id', $request->user()->id)->first();
    // $customer = \App\Models\Customers::all();
        if (!$customer) {
            return response()->json([
                'message' => 'Customer profile not found'
            ], 404);
        }

        return response()->json($customer);
    }

    public function index()
    {
        return ApiResponse::success($this->customerService->getAll());
    }

    public function show($id)
    {
        return ApiResponse::success($this->customerService->getWhereId($id));
    }

    public function store(Request $request)
    {
        return ApiResponse::success($this->customerService->register($request->all()));
    }

    // public function update(Request $request, $id)
    // {
    //     try{
    //         $request->validate([
    //             'user_id'             => 'required|exists:users,id',
    //             'full_name'           => 'required|string|max:255',
    //             'phone'               => 'nullable|string|max:20',
    //             'gender'              => 'nullable',
    //             'date_of_birth'       => 'nullable|date',
    //             'preferred_language'  => 'nullable|string|max:10',
    //             'note'                => 'nullable|string',
    //         ]);

    //         $customers = $this->customerService->update($request->all(), $id);

    //         return response()->json([
    //             'message' => 'Customer update successfully',
    //             'data' => $customers
    //         ]);
    //     }catch (\Exception $e){
    //         return response()->json([
    //             'message' => 'Something went wrong',
    //             'error' => $e->getMessage()
    //         ]);
    //     }
    // }

    public function update(Request $request, $id)
{
    try {
        $customer = \App\Models\Customers::findOrFail($id);

        // ✅ Only allow user to update their own profile
        if ($customer->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'first_name'    => 'nullable|string|max:255',
            'last_name'     => 'nullable|string|max:255',
            'phone'         => 'nullable|string|max:20',
            'gender'        => 'nullable|in:1,2,3',
            'date_of_birth' => 'nullable|date',
            'note'          => 'nullable|string',
        ]);

        $customer->update($validated);

        return response()->json([
            'message'  => 'Profile updated successfully',
            'customer' => $customer
        ]);

    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'message' => 'Validation failed',
            'errors'  => $e->errors()
        ], 422);

    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Something went wrong',
            'error'   => $e->getMessage()
        ], 500);
    }
}

    public function delete($id)
    {
        return ApiResponse::success($this->customerService->delete($id));
    }
}
