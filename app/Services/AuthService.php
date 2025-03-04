<?php

namespace App\Services;

use App\Repository\AuthRepository;
use Illuminate\Support\Facades\Validator;

use App\Helper\REST_Response;

class AuthService {

    protected $repo;
    function __construct(AuthRepository $repo) {
        $this->repo = $repo;
    }

    public function login(array $data){
        $validator = Validator::make($data, [
            'email' => 'required|email|max:64|min:6',
            'password' => 'required|max:64|min:3'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Login error.',
                'errors' => $validator->errors()->all()
            ], REST_Response::BAD_REQUEST);
        }

        return $this->repo->login($data);
    }
}
?>
