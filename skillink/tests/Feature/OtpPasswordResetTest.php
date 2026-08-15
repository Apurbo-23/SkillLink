<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class OtpPasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_request_a_password_reset_otp(): void
    {
        Mail::fake();

        $user = User::factory()->create([
            'email' => 'user@example.com',
        ]);

        $response = $this->post('/forgot-password', [
            'email' => $user->email,
        ]);

        $response->assertRedirect(route('password.otp.show', ['email' => $user->email]));

        $this->assertDatabaseHas('password_reset_otps', [
            'email' => $user->email,
        ]);

        Mail::assertSent(\App\Mail\PasswordResetOtpMail::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });
    }

    public function test_user_can_reset_password_with_a_valid_otp(): void
    {
        $user = User::factory()->create([
            'email' => 'user@example.com',
        ]);

        $otp = '123456';

        \App\Models\PasswordResetOtp::create([
            'email' => $user->email,
            'otp_hash' => \Illuminate\Support\Facades\Hash::make($otp),
            'expires_at' => now()->addMinutes(5),
        ]);

        $response = $this->post('/verify-otp', [
            'email' => $user->email,
            'otp' => $otp,
            'password' => 'NewPassword123!',
            'password_confirmation' => 'NewPassword123!',
        ]);

        $response->assertRedirect(route('login'));

        $this->assertTrue(\Illuminate\Support\Facades\Hash::check('NewPassword123!', $user->fresh()->password));
        $this->assertDatabaseMissing('password_reset_otps', [
            'email' => $user->email,
        ]);
    }
}
