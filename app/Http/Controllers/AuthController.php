<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Redis;

class AuthController extends Controller
{
    
    public function index()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'login' => 'required',
            'password' => 'required'
        ]);

        $credentials = $request->only('login', 'password');

        if(Auth::attempt($credentials)){
            //L'authetification s'est bien déroulée...
            return redirect()->intended('home');
        }
        return Redirect::to('login')->withSuccess('Erreur, verifiez vos identifiants, si le problème persiste, veuillez contacter un administrateur.');
    }
    public function logout() {
        Session::flush();
        Auth::logout();
        return Redirect('login');
    }

}
