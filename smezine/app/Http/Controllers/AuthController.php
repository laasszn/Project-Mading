<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //menampilkan halaman login
    public function showLogin() {
        return view('login');
    }

    //proses cek email dan password
    public function authenticate(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            // Kalo sukses, lempar ke halaman admin
            return redirect()->intended('/admin/berita');
        }

        return back()->withErrors(['email' => 'Email atau password salah bro!']);
    }

    //logout
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}