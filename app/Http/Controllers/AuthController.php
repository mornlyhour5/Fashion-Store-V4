<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Validate the incoming request data
        // $validatedData = $request->validate([
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|string|email|max:255|unique:users',
        //     'password' => 'required|string|min:8|confirmed',
        // ]);

        // // Create a new user
        // $user = User::create([
        //     'name' => $validatedData['name'],
        //     'email' => $validatedData['email'],
        //     'password' => Hash::make($validatedData['password']),
        // ]);

        // // Generate an authentication token for the user
        // $token = $user->createToken('auth_token')->plainTextToken;

        // // Return the user and token in the response
        // return response()->json([
        //     'access_token' => $token,
        //     'token_type' => 'Bearer',
        //     'user' => $user,
        // ], 201);
    }


public function login(Request $request)
{
    // Validate request
    $validatedData = $request->validate([
        'email' => 'required|string|email',
        'password' => 'required|string',
    ]);

    // Find user
    $user = User::where('email', $validatedData['email'])->first();

    // Check credentials
    if (!$user || !Hash::check($validatedData['password'], $user->password)) {
        return response()->json([
            'message' => 'Invalid credentials'
        ], 401);
    }

    // Create token
    $token = $user->createToken('auth_token')->plainTextToken;

    // Store data in session
    session([
        'user_id' => $user->id,
        'user_name' => $user->name,
        'user_email' => $user->email,
        'access_token' => $token
    ]);

    // Redirect
    return redirect('/products');
}

    public function logout(Request $request)
    {
        // Revoke the user's current token
        $request->user()->currentAccessToken()->delete();

        // Return a success message
        return response()->json(['message' => 'Successfully logged out'], 200);
    }
}
