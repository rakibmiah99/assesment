<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;

class AuthController extends Controller
{
    public function LoginPage(Request $request){
        return view('LoginPage');
    }

    public function Authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required'],
            'password' => ['required'],
        ]);

        //check authentication
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('home');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function SignupPage(Request $request){
        return view('SignupPage');
    }

    function Signup(Request $request){

        $credentials = $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $hasUser =  User::where('email', $credentials['email'])->count();

        if(!$hasUser){
            $credentials['password'] = Hash::make($credentials['password']);

           if(User::insert($credentials)){
                return redirect()->route('login')->with('success', "Account created successfully");
           }
           else{
               return back()->withErrors([
                   'error' => 'Ops! something went wrong please try again.',
               ])->withInput();
           }
        }
        else{
            return back()->withErrors([
                'email' => 'This email already exist!',
            ])->withInput();
        }


    }


}
