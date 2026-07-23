<?php

namespace App\Http\Controllers\Customer;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
// use App\Http\Requests\UpdateCustomerStatusRequest;
use App\Http\Resources\UserResource;
use App\Services\Contracts\CustomerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function customerProfile(int $id)
    {
        $customer = $this->customerService->customerProfile($id);

        return ApiResponse::success($customer);
    }

    public function getuserbyId(int $id)
    {
        $customer = $this->customerService->getUserById($id);

        return ApiResponse::success($customer);
    }

    public function getstaff(Request $request) // request data staff
    {
        return ApiResponse::success(
            $this->customerService->getAllStaff([
                'search' => $request->search,
                'per_page' => $request->per_page ?? 15,
            ])
        );
    }

    public function updateStatusUser(Request $request, int $id)
    {
        $customer = $this->customerService->updatecustomerStatus(
            $request->only(['status', 'reason']),
            $id
        );

        return response()->json([
            'message' => 'Account status updated.',
            'data' => new UserResource($customer),
        ]);
    }

    public function updateProfile(Request $request)
    {
        $userId = Auth::guard('api')->id();

        $profile = $this->customerService->updateProfile(
            $userId,
            $request->only(['first_name', 'last_name', 'phone', 'gender', 'date_of_birth', 'preferred_language'])
        );

        return ApiResponse::success($profile, 'Profile updated.');
    }

    public function updateAvatar(Request $request)
    {
        $request->validate(['avatar' => 'required']);

        $userId = Auth::guard('api')->id();

        $profile = $this->customerService->updateAvatar($userId, $request->file('avatar'));

        return ApiResponse::success($profile, 'Avatar updated.');
    }


}
