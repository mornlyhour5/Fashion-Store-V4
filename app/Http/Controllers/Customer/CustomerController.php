<?php

namespace App\Http\Controllers\Customer;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Services\Contracts\CustomerService;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function __construct(protected CustomerService $customerService){}

    public function me(Request $request)
    {
        $customer = \App\Models\Customers::where('user_id', $request->user()->id)->first();

        return response()->json([
            'user' => $request->user(),
            'customer_profile' => $customer, // null if not yet created — not an error
        ]);
    }

    public function index()
    {
        return ApiResponse::success($this->customerService->getAllcustomer());
    }

    public function getuser(Request $request) // request data get role customer only
    {
        return ApiResponse::success(
            $this->customerService->getAllUser([
                'search' => $request->search,
                'per_page' => $request->per_page ?? 15,
            ])
        );
    }

    public function getstaff(Request $request)
    {
        return ApiResponse::success(
            $this->customerService->getAllStaff([
                'search' => $request->search,
                'per_page' => $request->per_page ?? 15,
            ])
        );
    }

    // public function show($id)
    // {
    //     return ApiResponse::success($this->customerService->getWhereId($id));
    // }

    // public function store(Request $request)
    // {
    //     return ApiResponse::success($this->customerService->register($request->all()));
    // }

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

//     public function update(Request $request, $id)
// {
//     try {
//         $customer = \App\Models\Customers::findOrFail($id);

//         // ✅ Only allow user to update their own profile
//         if ($customer->user_id !== $request->user()->id) {
//             return response()->json(['message' => 'Unauthorized'], 403);
//         }

//         $validated = $request->validate([
//             'first_name'    => 'nullable|string|max:255',
//             'last_name'     => 'nullable|string|max:255',
//             'phone'         => 'nullable|string|max:20',
//             'gender'        => 'nullable|in:1,2,3',
//             'date_of_birth' => 'nullable|date',
//             'note'          => 'nullable|string',
//         ]);

//         $customer->update($validated);

//         return response()->json([
//             'message'  => 'Profile updated successfully',
//             'customer' => $customer
//         ]);

//     } catch (\Illuminate\Validation\ValidationException $e) {
//         return response()->json([
//             'message' => 'Validation failed',
//             'errors'  => $e->errors()
//         ], 422);

//     } catch (\Exception $e) {
//         return response()->json([
//             'message' => 'Something went wrong',
//             'error'   => $e->getMessage()
//         ], 500);
//     }
// }

//     public function delete($id)
//     {
//         return ApiResponse::success($this->customerService->delete($id));
//     }
}
