<?php

// namespace App\Http\Controllers\Auth;

// use App\Enums\LoginAccountType;
// use App\Helpers\ApiResponse;
// use App\Http\Controllers\Controller;
// use App\Services\Contracts\LoginService;
// // use App\Models\User;
// // use App\Services\Auth\LoginServices;
// use Illuminate\Http\Request;
// // use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Auth;

// class LoginController extends Controller
// {

//     public function __construct(protected LoginService $loginservices) {}

    // public function login(Request $request)
    // {
    //     try {
    //         $validated = $request->validate([
    //             'email'    => 'required|email',
    //             'password' => 'required',
    //         ]);

    //         $result = $this->loginservices->login($validated);

    //         return response()->json([
    //             'message'    => 'Login successful',
    //             'user'       => $result['user'],
    //             'session_id' => $result['session_id']
    //         ]);

    //     } catch (\Illuminate\Validation\ValidationException $e) {
    //         return response()->json([
    //             'message' => 'Validation failed',
    //             'errors'  => $e->errors()
    //         ], 422);

    //     } catch (\Illuminate\Auth\AuthenticationException $e) {
    //         return response()->json([
    //             'message' => $e->getMessage()
    //         ], 401);

    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'message' => 'Something went wrong',
    //             'error'   => $e->getMessage()
    //         ], 500);
    //     }
    // }

//     public function login(Request $request)
//     {
//         $credentials = $request->only([
//             'email',
//             'password'
//         ]);

//         $auth = $this->loginservices->login($credentials);
//         return ApiResponse::success($auth, __('messages.login_success'));
//     }

//     public function logout(Request $request)
//     {
//         Auth::guard('web')->logout();
//         $request->session()->invalidate();
//         $request->session()->regenerateToken();

//         return response()->json([
//             'message' => 'Logged out successfully'
//         ]);
//     }
// }



namespace App\Http\Controllers\Auth;

use App\Helpers\ApiResponse as ApiResponse;
use App\Http\Controllers\Controller;
use App\Services\Contracts\LoginService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct(protected LoginService $loginservices) {}

    public function login(Request $request)
    {
        $credentials = $request->only([
            'email',
            'password'
        ]);

        $auth = $this->loginservices->login($credentials);
        return ApiResponse::success($auth, __('messages.login_success'));
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }
}
