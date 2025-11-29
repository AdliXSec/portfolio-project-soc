<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // 1. Tampilkan Form Login
    public function showLoginForm()
    {
        // Jika user sudah login, lempar ke dashboard/home
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('auth.login');
    }

    // 2. Proses Login
    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Cek apakah "Remember Me" dicentang
        $remember = $request->has('remember');

        // Coba login menggunakan data user dari tabel 'users'
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate(); // Security: Regenerate session ID

            // Sukses login -> Arahkan ke halaman yang dituju atau home
            return redirect()->intended(route('admin.dashboard'))->with('success', 'Welcome back!');
        }

        // Gagal login -> Kembali ke form dengan error
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    // 3. Proses Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'You have been logged out.');
    }
}
