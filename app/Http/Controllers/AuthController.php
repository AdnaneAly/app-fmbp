<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AuthController extends Controller
{
    public function login() {

        if (!empty(Auth::check())){
            return redirect('/');
        }
        return Inertia::render('Login');
    }


    public function dologin(LoginRequest $request){
        $credentials = $request->validated();
        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            //session(['annee' => $request->annee]);
            $defaultRoute =  redirect('home');
            //$imtended_route = redirect()->intended($defaultRoute);

            return Inertia::location($defaultRoute);
        }
        return back()->withErrors([
            'email' => 'Identifiants incorrect'
        ])->onlyInput('email');
    }



    public function logout()
    {
        Auth::logout();
        return Inertia::location('/login');
    }
}
