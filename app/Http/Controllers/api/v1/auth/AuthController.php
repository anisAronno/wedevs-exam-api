<?php

namespace App\Http\Controllers\api\v1\auth;
use App\Http\Controllers\api\v1\BaseController as BaseController;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegistrationRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends BaseController
{
    public function login(UserLoginRequest $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            $data['token'] =  $user->createToken('MyApp')->plainTextToken;
            $data['name'] =  $user->name;
            $data['role'] =  $user->getRoleNames()[0];
            $data['permission'] =  $user->getAllPermissions();
            $data['notification'][] = Auth::user()->notifications;
            Log::debug( $data['token']);
            return $this->sendResponse($data, 'User login successfully.');
        }
        else{
            return $this->sendError('Unauthorised.', ['error'=>'Email or Password Doesn\'t Match']);
        }
    }
    public function register(UserRegistrationRequest $request)
    {

        Log::debug($request);
        $user = User::create($request->only('name', 'email', 'password'));
        $success['token'] =  $user->createToken('MyApp')->plainTextToken;
        $success['name'] =  $user->name;
        $success['role'] =  $user->getRoleNames()[0];
        if($user){
            Log::debug($success);
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
    public function readNotification()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return $this->sendResponse('Notification', 'Mark Read At Notification successfully.');
    }


}
