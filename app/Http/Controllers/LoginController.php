<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function authenticate(Request $request)
    {
        $username = $request->username;
        $password = $request->password;

        if($username == "admin" && $password == "12345"){
            return redirect('/home');
        }

        return back()->with('error','Username atau password salah');
    }
}