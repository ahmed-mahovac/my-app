<?php

namespace App\Services;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthService{
    public function registerUser(RegisterUserRequest $request){
        $user = new User([
            'name'  => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        if($user->save()){

            return $this->createToken($user);

        }
        else{
            return null;
        }
    }

    public function loginUser(LoginUserRequest $request){
        $credentials = request(['email','password']);
        if(!Auth::attempt($credentials))
        {
        return null;
        }
    
        $user = auth()->user();
        $token = $this->createToken($user);
    
        return $token;
    }

    public function logoutUser(){
        // check why Auth::user() is not working
        request()->user()->tokens()->delete();
    }

    private function createToken(User $user){
        return $user->createToken('Personal Access Token')->plainTextToken;
    }

}