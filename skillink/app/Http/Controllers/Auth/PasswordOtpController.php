<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\PasswordResetOtpMail;
use App\Models\PasswordResetOtp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class PasswordOtpController extends Controller
{
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ]);

        $email = strtolower(trim($request->email));
        $otp = random_int(100000, 999999);

        PasswordResetOtp::where('email', $email)->delete();

        PasswordResetOtp::create([
            'email' => $email,
            'otp_hash' => Hash::make((string) $otp),
            'expires_at' => now()->addMinutes(5),
        ]);

        Mail::to($email)->send(new PasswordResetOtpMail((string) $otp));

        return redirect()->route('password.otp.show', ['email' => $email])
            ->with('status', 'A 6-digit OTP has been sent to your email address.');
    }

    public function showOtpForm(Request $request, string $email): View
    {
        return view('auth.otp-verification', [
            'email' => strtolower(trim($email)),
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
            'otp' => ['required', 'numeric', 'digits:6'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $email = strtolower(trim($request->email));
        $otpRecord = PasswordResetOtp::where('email', $email)->latest()->first();

        if (! $otpRecord || ! Hash::check((string) $request->otp, $otpRecord->otp_hash)) {
            return back()->withInput()->withErrors(['otp' => 'Invalid OTP. Please try again.']);
        }

        if (now()->greaterThan($otpRecord->expires_at)) {
            $otpRecord->delete();

            return back()->withInput()->withErrors(['otp' => 'This OTP has expired. Please request a new one.']);
        }

        $user = User::where('email', $email)->firstOrFail();
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        $otpRecord->delete();

        return redirect()->route('login')->with('status', 'Your password has been reset successfully.');
    }
}
