<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Auth\RegisterServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{

    public function __construct(protected RegisterServices $registerservices)
    {
        $this->registerservices = $registerservices;
    }

    public function register(Request $request)
{
    try {
        $validated = $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|min:8|confirmed', // ✅ checks password_confirmation
        ]);

        $result = $this->registerservices->register($validated);

        return response()->json([
            'message' => 'Register Success',
            'user'    => $result['user']
            // ✅ No token needed for SPA cookie auth
        ], 201);

    } catch (\Illuminate\Validation\ValidationException $e) {
        // ✅ Catch validation errors specifically
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
