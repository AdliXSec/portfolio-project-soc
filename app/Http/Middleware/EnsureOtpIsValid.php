<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureOtpIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && !session('otp_verified')) {
            // Allow access to the OTP verification pages
            if ($request->routeIs('otp.verification') || $request->routeIs('otp.verify') || $request->routeIs('otp.resend') || $request->routeIs('logout')) {
                return $next($request);
            }
            return redirect()->route('otp.verification')->with('warning', 'Please verify your OTP to continue.');
        }

        return $next($request);
    }
}
