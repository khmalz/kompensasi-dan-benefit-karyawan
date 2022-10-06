<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $validData = $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required',
        ]);

        if (Auth::attempt($validData)) {
            $request->session()->regenerate();

            if (auth()->user()->email == 'admin@gmail.com') {
                return redirect()->intended('/dashboardAdmin');
            }

            return redirect()->intended('/dashboardKaryawan');
        }

        return back()->with('fail', 'Kamu Gagal Login');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
