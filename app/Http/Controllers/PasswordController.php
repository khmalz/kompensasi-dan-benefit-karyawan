<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function update()
    {
        request()->validate([
            'old_password' => 'required',
            'password' => 'required|min:5|confirmed',
        ]);

        $password_asli = auth()->user()->password;
        $password_lama = request('old_password');

        if (Hash::check($password_lama, $password_asli)) {
            auth()->user()->update([
                'password' => bcrypt(request('password'))
            ]);
            return back()->with('berhasil', 'Ganti Password Berhasil');
        }

        return back()->with('gagal', 'Ganti Password Gagal');
    }
}
