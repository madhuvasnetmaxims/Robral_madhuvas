<?php

namespace App\Http\Controllers;

use App\Http\Repository\UserRepo;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }
    public function verify(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
    
        $user = User::where('email', $request->email)->first();
        

        if (!$user || !Hash::check($request->password, $user->password)) {

            return redirect()->route('login')->withErrors(['error' => 'Invalid email or password.']);
        }
    
        Session::put('login_true', $user['id']);
        Session::put('username', $user['name']);

        
    
        return redirect()->route('index')->with('success', 'Welcome back, ' . $user->name . '!');
    }

    public function register()
    {
        return view('register');
    }

   public function regSave(Request $request)
{
    $rules = [
        'name'     => 'required|string',
        'email'    => 'required|email|unique:users,email',
        'phone'    => 'required|digits_between:9,10',
        'password' => 'required|confirmed|min:6|max:8'
    ];
    
    $messages = [
        'name.required'     => 'The name field is required.',
        'email.required'    => 'The email field is required.',
        'email.email'       => 'The email must be a valid email address.',
        'email.unique'      => 'The email has already been taken.',
        'phone.required'    => 'The phone field is required.',
        'phone.digits_between' => 'The phone number must be between 9 and 10 digits.',
        'password.required' => 'The password field is required.',
        'password.confirmed' => 'The password confirmation does not match.',
        'password.min'      => 'The password must be at least 6 characters.',
        'password.max'      => 'The password must not exceed 8 characters.',
    ];
    
    $validInputs = $request->validate($rules, $messages);

    $existingEmail = User::where("email", $request->email)->first();
    if ($existingEmail) {
        return redirect()->back()->withErrors(['email' => 'Email already exists'])->withInput();
    }

    $user = UserRepo::userCreate($request);

    $user = User::where('email', $request->email)->first();

    Session::put('login_true', $user['id']);
    $name = Session::put('username', $user['name']);

    if ($user) {
        return redirect()->route("index")->with("success");
    } else {
        return redirect()->back();
    }
}




    public function logout(Request $request)
    {
        Session::forget('login_true');
        Session::forget('username');
        Session::forget('cart'); 

        return redirect()->route('index')->with('success', 'You have been logged out.');
    }
    
}
