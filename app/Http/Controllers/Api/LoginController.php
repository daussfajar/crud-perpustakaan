<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\AuthService;

class LoginController extends Controller
{
    public $service;

    function __construct(AuthService $service){
        $this->service = $service;
    }

    public function auth(Request $request){
        return $this->service->login([
            'email' => $request->input('email') ?? '',
            'password' => $request->input('password') ?? ''
        ]);
    }
}
