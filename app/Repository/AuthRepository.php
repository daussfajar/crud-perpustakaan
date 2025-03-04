<?php

namespace App\Repository;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use App\Helper\REST_Response;

class AuthRepository
{
    public function login($credentials): JsonResponse
    {
        $user = User::select('id', 'name', 'email', 'password')
            ->where('email', $credentials['email'])
            ->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Login error, invalid credentials.'
            ], REST_Response::UNAUTHORIZED);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Login success. Welcome, ' . $user->name,
            'data' => $user
        ], REST_Response::SUCCESS);
    }

    public function findUserById($id): JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found'
            ], REST_Response::NOT_FOUND);
        }

        return response()->json([
            'status' => 'success',
            'data' => $user
        ], REST_Response::SUCCESS);
    }
}
