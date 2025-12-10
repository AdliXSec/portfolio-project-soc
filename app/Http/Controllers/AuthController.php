<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use Carbon\Carbon;

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

    // 2. Proses Login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();
            $otp = rand(100000, 999999);

            $user->update([
                'otp_code' => $otp,
                'otp_expires_at' => Carbon::now()->addMinutes(5),
            ]);

            Mail::to($user->email)->send(new OtpMail($otp));
            
            // Simpan email di session untuk ditampilkan di halaman OTP
            $request->session()->put('email_for_otp', $user->email);

            return redirect()->route('otp.verification')->with('success', 'An OTP has been sent to your email.');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
    
    // 3. Tampilkan form OTP
    public function showOtpForm()
    {
        // Pastikan user sudah login tapi belum verifikasi OTP
        if (!Auth::check() || session('otp_verified')) {
            return redirect()->route('login');
        }

        $email = session('email_for_otp', Auth::user()->email);

        return view('auth.otp', ['email' => $email]);
    }

    // 4. Proses verifikasi OTP
    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required|numeric|digits:6']);

        $user = Auth::user();
        
        if ($user->otp_code === $request->otp && $user->otp_expires_at > Carbon::now()) {
            // OTP valid
            $user->update(['otp_code' => null, 'otp_expires_at' => null]);
            $request->session()->put('otp_verified', true);
            $request->session()->forget('email_for_otp'); // Hapus email dari session

            return redirect()->intended(route('admin.dashboard'))->with('success', 'Welcome back!');
        }

        // OTP tidak valid atau kedaluwarsa
        return back()->with('error', 'Invalid or expired OTP.');
    }

    // 5. Kirim ulang OTP
    public function resendOtp(Request $request)
    {
        $user = Auth::user();
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
}
