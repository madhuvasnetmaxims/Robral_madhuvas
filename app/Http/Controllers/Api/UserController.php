<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Repository\UserRepo;
use App\Http\Repository\UserRepository as RepositoryUserRepository;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\Http\Requests\ErrorCommonRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Bridge\UserRepository;

class UserController extends Controller
{
  
// user registration
   public function register(Request $request)
   {
       $validInputs = UserRequest::userCreate($request);

       $existingEmail = User::where("email",$request->email)->first();
       if($existingEmail !=null){
        return response()->json(['data'=>[],'message'=>'email already existed','status'=>false],422);
       }
       
       if($validInputs===true){
         $user = UserRepo::userCreate($request);

         if($user){
            return response()->json(['data'=>$user,'message'=>'user created successfully','status'=>true],201);
         }else{
           return response()->json(['data'=>[],'message'=>'email already existed or something went wrong','status'=>false],455);
         }
       }else{
        return response()->json(['data'=>[],'message'=>$validInputs,'status'=>false],422);
       }
      
   }

//    user login

   public function login(Request $request){
    
       $validInputs = UserRequest::userLogin($request);

       $existingEmail = User::where("email",$request->email)->first();
       if($existingEmail ==null){
        return response()->json(['data'=>[],'message'=>'email not found','status'=>false],404);
       }


    if($validInputs===true){
       $auth =  Auth::attempt(['email' => $request->email, 'password' => $request->password]);


       $userExisted = User::where("email",$request->email)->first();

       if($auth === true){
            $user = User::find($userExisted['id']);
            $user['token']= $user->createToken('auth_token')->accessToken;
            $user = $user->toArray();

            return response()->json(['data'=>$user,'message'=>'user logged in successfully','status'=>true],200);
       }

    }else{

        return response()->json(['data'=>[],'message'=>$validInputs,'status'=>false],422);

    }



   }

//    user logout

   public function logout(Request $request)
{
    try {
        if (Auth::check()) {
            $request->user()->token()->revoke();

            return response()->json([
                'data' => [],
                'message' => 'User logged out successfully',
                'status' => true
            ], 200);
        } else {
            return response()->json([
                'data' => [],
                'message' => 'User is not logged in',
                'status' => false
            ], 401);
        }
    } catch (\Exception $e) {
        return response()->json([
            'data' => [],
            'message' => 'An error occurred while logging out',
            'status' => false,
            'error' => $e->getMessage()
        ], 500);
    }
}

   
}
