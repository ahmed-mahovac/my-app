<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    protected $authService;

    public function __construct(AuthService $authService){
        $this->authService = $authService;
    }

    public function register(RegisterUserRequest $request)
    {

        $token = $this->authService->registerUser($request);

        if(!$token){
            return response()->json(['error'=>'Provide proper details']);
        }

        return response()->json([
            'message' => 'User successfully created!',
            'access_token'=> $token,
            ],201);
    }

    public function login(LoginUserRequest $request)
{
    
    $token = $this->authService->loginUser($request);

    if(!$token)
    {
    return response()->json([
        'message' => 'Invalid credentials'
    ],401);
    }

    return response()->json([
    'access_token' =>$token,
    ]);
}

public function logout(Request $request)
{
    $this->authService->logoutUser();
    return response()->json([
        'message' => 'Successfully logged out'
    ]);
}
}
