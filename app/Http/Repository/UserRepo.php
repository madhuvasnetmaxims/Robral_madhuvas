<?php

namespace App\Http\Repository;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Http\FormRequest;

class UserRepo extends FormRequest
{

   

    /* Create user */
    public static function userCreate($data)
    {
       $existingEmail = User::where("email",$data->email)->first();
       if($existingEmail !=null){
           return false;
       }
        // Create the user 
        $user = User::create([
            'name' => $data->name,
            'email' => $data->email,
            'phone' => $data->phone,
            'password' => isset($data->password) ? Hash::make($data->password) : null,
        ]);

        if ($user) {
            $token = $user->createToken('auth_token')->accessToken;
            $user['token'] = $token;
            return $user;
        }
        return false;
    }

   
}
