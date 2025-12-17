<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use App\Mail\OtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    // 1. Tampilkan Form Login
    public function showLoginForm()
    {
        // Jika user sudah login dan terverifikasi OTP, lempar ke dashboard
        if (Auth::check() && session('otp_verified')) {
            return redirect()->route('admin.dashboard');
        }
        return view('auth.login');
    }

    // 2. Proses Pengecekan Kredensial & Kirim OTP (TANPA LOGIN)
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        // Cek apakah user ada dan password cocok
        if ($user && Hash::check($credentials['password'], $user->password)) {

            // Jangan login dulu, tapi siapkan OTP
            $otp = rand(100000, 999999);
            $user->update([
                'otp_code' => $otp,
                'otp_expires_at' => Carbon::now()->addMinutes(5),
            ]);

            Mail::to($user->email)->send(new OtpMail($otp));

            // Simpan ID user di session untuk proses verifikasi nanti
            $request->session()->put('user_id_for_otp', $user->id);
            $request->session()->put('email_for_otp', $user->email);
            $request->session()->put('remember_me', $request->has('remember'));

            // Redirect ke halaman verifikasi OTP dengan pesan sukses
            return redirect()->route('otp.verification')->with('success', 'An OTP has been sent to your email.');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    // 3. Tampilkan form OTP
    public function showOtpForm()
    {
        // Jika user sudah login dan terverifikasi, redirect ke dashboard
        if (Auth::check() && session('otp_verified')) {
            return redirect()->route('admin.dashboard');
        }

        // Jika tidak ada user yang sedang dalam proses verifikasi, redirect ke login
        if (!session()->has('user_id_for_otp')) {
            return redirect()->route('login');
        }

        $email = session('email_for_otp');
        return view('auth.otp', ['email' => $email]);
    }

    // 4. Proses verifikasi OTP & LOGIN
    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required|numeric|digits:6']);

        $userId = session('user_id_for_otp');
        if (!$userId) {
            return redirect()->route('login')->with('error', 'Session expired. Please try again.');
        }

        $user = User::find($userId);

        if ($user && $user->otp_code === $request->otp && $user->otp_expires_at > Carbon::now()) {
            // OTP valid, SEKARANG LOGIN-kan pengguna
            Auth::login($user, session('remember_me', false));
            $request->session()->regenerate();

            // Bersihkan OTP dan set sesi terverifikasi
            $user->update(['otp_code' => null, 'otp_expires_at' => null]);
            $request->session()->put('otp_verified', true);

            // Hapus data sesi yang tidak diperlukan lagi
            $request->session()->forget(['user_id_for_otp', 'email_for_otp', 'remember_me']);

            return redirect()->intended(route('admin.dashboard'))->with('success', 'Welcome back!');
        }

        // OTP tidak valid atau kedaluwarsa
        return back()->with('error', 'Invalid or expired OTP.');
    }

    // 5. Kirim ulang OTP
    public function resendOtp(Request $request)
    {
        $userId = session('user_id_for_otp');
        if (!$userId) {
            return redirect()->route('login')->with('error', 'Session expired. Please try again.');
        }

        $user = User::find($userId);
        $otp = rand(100000, 999999);

        $user->update([
            'otp_code' => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(5),
        ]);

        Mail::to($user->email)->send(new OtpMail($otp));

        return back()->with('success', 'A new OTP has been sent to your email.');
    }

    // 6. Proses Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'You have been logged out.');
    }
    
    // 7. Kembali ke Halaman Login dari Halaman OTP
    public function backLogin(Request $request)
    {
        // Cukup hapus session OTP, karena user belum login
        $request->session()->forget(['user_id_for_otp', 'email_for_otp', 'remember_me']);

        return redirect()->route('login');
    }
}
