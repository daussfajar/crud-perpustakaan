<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

class LoginController extends Controller
{
    function __construct()
    {

    }

    public function auth(Request $request){
        $email = trim(htmlspecialchars($request->input('email')));
        $password = trim(htmlspecialchars($request->input('password')));

        if(!isset($email) || !isset($password)){
            return response()->json([
                'status' => 'error',
                'message' => 'Email and password required',
            ], 400);
        }

        $user = User::where('email', $email)->first();

        if(!$user){
            return response()->json([
                'status' => 'error',
                'message' => 'User not found',
            ], 404);
        }

        $passwordCheck = password_verify($password, $user->password);

        if($passwordCheck){
            return response()->json([
                'status' => 'success',
                'message' => 'Login success, welcome ' . $user->name,
                'data' => $user,
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Login failed, wrong password',
            ], 401);
        }
    }
}
