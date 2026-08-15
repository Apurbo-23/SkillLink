<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\PasswordResetOtpMail;
use App\Models\PasswordResetOtp;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
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
}
