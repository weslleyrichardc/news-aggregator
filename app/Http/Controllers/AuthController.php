<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    public function register(UserRegisterRequest $request): JsonResponse
    {
        $user = User::query()->create($request->validated());

        if (!$user) {
            return response()->json([
                "message" => "User not created",
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            "user" => [
                "name" => $user->getAttribute("name"),
                "email" => $user->getAttribute('email'),
            ],
            "token_type" => "Bearer",
            "token" => $user->createToken("auth_token")->plainTextToken,
        ], Response::HTTP_CREATED);
    }

    public function login(UserLoginRequest $request): JsonResponse
    {
        if (!auth()->attempt($request->validated())) {
            return response()->json([
                "error" => "Bad Credentials",
            ], Response::HTTP_UNAUTHORIZED);
        }

        /** @var User $user */
        $user = auth('sanctum')->user();
        return response()->json([
            "user" => [
                "name" => $user->getAttribute("name"),
                "email" => $user->getAttribute('email'),
            ],
            "token_type" => "Bearer",
            "token" => $user->createToken('auth_token')->plainTextToken,
        ], Response::HTTP_OK);
    }

    public function logout(Request $request): JsonResponse
    {
        if (!auth('sanctum')->check()) {
            return response()->json([
                'error' => 'Bad Credentials'
            ], Response::HTTP_UNAUTHORIZED);
        }

        auth('sanctum')->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Logged Out'
        ], Response::HTTP_OK);
    }
}
