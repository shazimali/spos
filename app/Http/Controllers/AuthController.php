<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\User;
use Auth;
class AuthController extends Controller
{
    public function login(){

        return view('auth.login');
    }

    public function postLogin(LoginRequest $request){

        $credentials = [

            'email'=> $request->email,
            'password' => $request->password
        ];

        if(!Auth::attempt($credentials))

        return back()->with('message','Invalid user name or passwoed.');

        return redirect('/dashboard');
    }

    public function logout(){

        Auth::logout();

        return redirect('/');
    }
}
