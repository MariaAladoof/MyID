<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request): JsonResponse
    {
        $validated = $request->validated();


        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'تم تسجيل المستخدم بنجاح ',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'created_at' => $user->created_at,
            ],
            'token' => $token,
            'token_type' => 'Bearer',
        ], 201);
    }

    public function login(LoginRequest $Request): JsonResponse
    {
        $validated = $Request->validated();

        $user = User::where('email', $validated['email'])->first();


        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials',
            ], 401);
        }

        $token = $user->createToken('login_token')->plainTextToken;

        return response()->json([
            'message' => 'نجاح تسجيل الدخول',
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
        ], 200);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'تم تسجيل الخروج بنجاح',
        ], 200);
    }


    public function me(Request $request): JsonResponse
    {
        return response()->json([
            'user' => $request->user(),
        ]);
    }
}
