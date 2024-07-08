<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthenticationController extends Controller
{
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'username' => "required|string|max:25|unique:users",
            'email' => "required|string|email|unique:users",
            'password' => "required|string|min:8",
        ]);

        // Return validator error
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        // Save data to Database
        $register = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'success' => true,
            'message' => "OK",
            'data' => $register
        ], 200);
    }

    public function login(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => "required|email",
            'password' => "required",
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => "Validation errors",
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return response()->json([
            'token' => $user->createToken('refreshToken')->plainTextToken
        ], 200);
    }

    public function me() {
        $user = Auth::user();

        return response()->json([
            'data' => $user
        ], 200);
    }

    public function logout(Request $request) {
        $revoke = $request->user()->currentAccessToken()->delete();

        if ($revoke) {
            return response()->json([
                'message' => 'OK'
            ], 200);
        }
    }
}
