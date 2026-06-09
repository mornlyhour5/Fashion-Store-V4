<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Auth\RegisterServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use App\Domain\AuthUser;
use App\Dto\CreateUserDto;
use App\Enums\Gender;
use App\Enums\Language;
use Illuminate\Validation\Rules\Enum;

class RegisterController extends Controller
{

    public function __construct(protected RegisterServices $registerservices)
    {
        $this->registerservices = $registerservices;
    }
//-----------------------------------------------------------------
//                   lod version without doamin                  //
//-----------------------------------------------------------------
//     public function register(Request $request)
// {
//     try {
//         $validated = $request->validate([
//             'name'                  => 'required|string|max:255',
//             'email'                 => 'required|email|unique:users,email',
//             'password'              => 'required|min:8|confirmed', // ✅ checks password_confirmation
//         ]);

//         $result = $this->registerservices->register($validated);

//         return response()->json([
//             'message' => 'Register Success',
//             'user'    => $result['user']
//             // ✅ No token needed for SPA cookie auth
//         ], 201);

//     } catch (\Illuminate\Validation\ValidationException $e) {
//         // ✅ Catch validation errors specifically
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


//-----------------------------------------------------------------
//                     new version with doamin                   //
//-----------------------------------------------------------------
    // public function register(Request $request)
    // {
    //     $dto = CreateUserDto::fromRequest($request);
    //     $this->registerservices->register($dto);
    //     return response()->json([
    //         'message' => 'Register Success',
    //     ], 201);
    // }

public function register(Request $request)
    {
        try {
            $request->validate([
                'name'               => 'required|string|max:255',
                'email'              => 'required|email|unique:users,email',
                'password'           => 'required|string|min:8',
                'phone'              => 'nullable|string|max:20',
                'gender'             => ['nullable', new Enum(Gender::class)],
                'date_of_birth'      => 'nullable|date',
                'preferred_language' => ['nullable', new Enum(Language::class)],
                'note'               => 'nullable|string',
            ]);

            $dto = CreateUserDto::fromRequest($request);

            // RegisterServices now returns ['user' => ..., 'customer' => ...]
            ['user' => $user, 'customer' => $customer] = $this->registerservices->register($dto);

            return response()->json([
                'message' => 'Register successful',
                'data'    => [
                    'user'     => $user,
                    'customer' => $customer,
                ],
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors'  => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong',
                'error'   => $e->getMessage(),
            ], 500);
        }
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
