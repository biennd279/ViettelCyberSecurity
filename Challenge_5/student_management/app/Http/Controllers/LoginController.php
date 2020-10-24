<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function getLogin()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('user_name', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('/');
        } else
        {
            return redirect()->route('login');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
