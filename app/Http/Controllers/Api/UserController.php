<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|max:64',
            'role' => 'nullable|in:admin,user',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        // Check if the user is the first user
        $isFirstUser = User::count() === 0;
        // If it's the first user, assign the 'admin' role
        $role = $isFirstUser ? 'admin' : 'user';
        // If the user is not the first user, assign the role from the request
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $role,
        ]);

        return response()->json([
            'message' => 'Account created successfully',
            'user' => $user,
        ], 201);
    }


    public function login(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8|max:64',
        ]);

        // check for validation errors
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        // authenticate the user
        $user = User::where('email', $request->email)->first();

        // checks if the user exists and if the password is correct
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials',
            ], 401);
        }

        // Generate an authentication token
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'user' => $user,
            'role' => $user->role,
        ], 200);
    }


    public function logout(Request $request){
        $request->user()->where('id', $request->user()->id)->first()->tokens()->delete();
        return response()->json([
            'message' => 'Logout successful',
        ], 200);
    }


}
