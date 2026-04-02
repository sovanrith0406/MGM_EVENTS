<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;

class ForgotPasswordController extends Controller
{
    // GET /forgot-password
    public function showEmailForm()
    {
        return view('backend.auth.forgot-password');
    }

    // POST /forgot-password  &  POST /resend-otp
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ], [
            'email.exists' => 'No account found with that email address.',
        ]);

        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        Cache::put('password_reset_otp_' . $request->email, $otp, now()->addMinutes(10));
        Mail::to($request->email)->send(new OtpMail($otp));

        session(['otp_email' => $request->email]);
        session()->save();

        return redirect()->route('password.otp.form')
            ->with('success', 'A 6-digit OTP has been sent to your email.');
    }

    // GET /verify-otp
    public function showOtpForm()
    {
        if (!session('otp_email')) {
            return redirect()->route('password.request');
        }

        return view('backend.auth.otp-verify');
    }

    // POST /verify-otp
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => ['required', 'digits:6'],
        ]);

        $email  = session('otp_email');
        $cached = Cache::get('password_reset_otp_' . $email);

        if (!$cached || $cached !== $request->otp) {
            return back()->withErrors(['otp' => 'Invalid or expired OTP. Please try again.']);
        }

        Cache::forget('password_reset_otp_' . $email);

        session(['otp_verified' => true]);
        session()->save();

        return redirect()->route('password.reset.form');
    }

    // GET /reset-password
    public function showResetForm()
    {
        if (!session('otp_email') || !session('otp_verified')) {
            return redirect()->route('password.request');
        }

        return view('backend.auth.reset-password');
    }

    // POST /reset-password
    public function resetPassword(Request $request)
    {
        // Guard: ensure the user went through OTP verification
        if (!session('otp_email') || !session('otp_verified')) {
            return redirect()->route('password.request')
                ->withErrors(['session' => 'Your session has expired. Please start again.']);
        }

        $request->validate([
            'password'              => ['required', 'min:8', 'confirmed'],
            'password_confirmation' => ['required'],
        ], [
            'password.required'              => 'Password is required.',
            'password.min'                   => 'Password must be at least 8 characters.',
            'password.confirmed'             => 'Password confirmation does not match.',
            'password_confirmation.required' => 'Please confirm your new password.',
        ]);

        $user = User::where('email', session('otp_email'))->firstOrFail();
        $user->password_hash = Hash::make($request->password);
        $user->save();

        session()->forget(['otp_email', 'otp_verified']);

        return redirect()->route('login')
            ->with('success', 'Password reset successfully. Please log in.');
    }
}