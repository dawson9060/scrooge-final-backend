<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    // Register API (name, email, passsword, confirm_password);
    public function register(Request $request)
    {
        $data = $request->validate([
            "firstName" => "required|string|max:100",
            "lastName" => "required|string|max:100",
            "city" => "required|string|max:100",
            "state" => "required|string|max:2|alpha",
            "phone" => "string|nullable|size:10",
            "zip" => "required|integer|digits:5",
            "email" => "required|email|unique:users,email",
            "password" => "required|confirmed|string|min:8",
        ]);

        User::create($data);

        return response()->json([
            "status" => 200,
            "message" => "User registered successfully.",
        ]);
    }

    // Login API (email, password)
    public function login(Request $request)
    {
        $request->validate([
            "email" => "required|email",
            "password" => "required",
        ]);

        if (!Auth::attempt($request->only("email", "password"))) {
            return response()->json([
                "status" => 400,
                "message" => "Invalid Credentials",
            ]);
        }

        $user = Auth::user();

        return response()->json([
            "status" => 200,
            "message" => "Login successful",
        ]);
    }

    // User API
    public function user()
    {
        $user = Auth::user();
        Log::info("INSIDE User FETCH, RETURNING USER:", $user->toArray());

        return response()->json([
            "status" => 200,
            "user" => $user,
        ]);
    }

    // Logout API
    public function logout(Request $request)
    {
        Auth::logout();

        // Invalidate the user's session
        $request->session()->invalidate();

        // Regenerate the session token to prevent session fixation attacks
        $request->session()->regenerateToken();

        return response()->json(['message' => 'Logged out successfully'], 200);
    }
}