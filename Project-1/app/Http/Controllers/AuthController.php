<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //VIEW USER LOGIN PAGE
    public function LoginPage(Request $request){
        $title = 'Login Pages | Authentication ';
        return view('LoginPage', compact('title'));
    }

    //AUTHENTICATION A USER
    public function Authenticate(Request $request): RedirectResponse
    {
        //CHECK VALIDATION
        $credentials = $request->validate([
            'email' => ['required'],
            'password' => ['required'],
        ]);

        //CHECK USER AUTHENTICATION
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('home');
        }

        //IF AUTHENTICATION FAILED REDIRECT TO PREVIOUS URL
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    //VIEW USER REGISTER PAGE
    public function SignupPage(Request $request){
        $title = 'Login Pages | Authentication ';
        return view('SignupPage', compact('title'));
    }

    //REGISTER A NEW USER
    function Signup(Request $request){
        //CHECK VALIDATION
        $credentials = $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        //GET NUMBER OF USER
        $hasUser =  User::where('email', $credentials['email'])->count();

        //CHECK EXIST USER
        if(!$hasUser){
            //GENERATE SECURE PASSWORD
            $credentials['password'] = Hash::make($credentials['password']);

           if(User::insert($credentials)){
                //INSERT A USER AND REDIRECT TO LOGIN PAGE WITH A MESSAGE
                return redirect()->route('login')->with('success', "Account created successfully");
           }
           else{
               //IF SOMEHOW USER CREATED FAILED THEN REDIRECT TO PREVIOUS URL WITH A ERROR MESSAGE
               return back()->withErrors([
                   'error' => 'Ops! something went wrong please try again.',
               ])->withInput();
           }
        }
        else{
            //IF USER EMAIL ALREADY EXIST REDIRECT TO PREVIOUS URL WITH A ERROR MESSAGE
            return back()->withErrors([
                'email' => 'This email already exist!',
            ])->withInput();
        }
    }

    //LOGOUT USER
    function Logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }


}
