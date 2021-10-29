<?php

namespace App\Http\Controllers\api\v1;
use App\Http\Controllers\api\v1\BaseController as BaseController;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegistrationRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends BaseController
{
    public function login(UserLoginRequest $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')->plainTextToken;
            $success['name'] =  $user->name;
            $success['role'] =  $user->getRoleNames()[0];
            return $this->sendResponse($success, 'User login successfully.');
        }
        else{
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        }
    }
    public function register(UserRegistrationRequest $request)
    {

        $user = User::create($request->only('name', 'email', 'password'));
        $success['token'] =  $user->createToken('MyApp')->plainTextToken;
        $success['name'] =  $user->name;
        $success['role'] =  $user->getRoleNames()[0];
        if($user){
            return $this->sendResponse($success, 'User register successfully.');
        }else{
         return $this->sendError('register.', ['error'=>'User Registration Failed']);
        }
    }

    public function logout()
    {
       $result=auth()->user()->currentAccessToken()->delete();
       if($result){
           return $this->sendResponse('logout', 'User logout successfully.');
       }else{
        return $this->sendError('logout.', ['error'=>'Logout Failed']);
       }
    }
}
