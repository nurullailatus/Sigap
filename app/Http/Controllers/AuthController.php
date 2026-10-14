<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // 1. Menampilkan halaman form login
    public function showLogin()
    {
        return view('auth.login');
    }

    // 2. Memproses data yang dikirim dari form login
    public function login(Request $request)
    {
        $kredensial = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($kredensial + ['status' => 'aktif'])) {
            $request->session()->regenerate();
            return match(Auth::user()->role) {
            'admin'   => redirect()->route('admin.dashboard'),
            'teknisi' => redirect()->route('teknisi.dashboard'),
            default   => redirect()->route('pelapor.dashboard'),
            };
        }

        return back()
            ->withErrors(['email' => 'Email atau password salah, atau akun nonaktif.'])
            ->onlyInput('email');
    }

    // 3. Keluar dari akun
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}