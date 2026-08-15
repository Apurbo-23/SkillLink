<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Password reset OTP</title>
</head>
<body style="font-family: Arial, sans-serif; background: #0B0A09; color: #e8dfc8; padding: 24px;">
    <div style="max-width: 520px; margin: 0 auto; background: #121110; border: 1px solid rgba(212, 175, 55, 0.25); border-radius: 12px; padding: 24px;">
        <h2 style="color: #D4AF37; margin-top: 0;">SkillLink Password Reset</h2>
        <p>Your one-time password (OTP) is:</p>
        <div style="font-size: 32px; font-weight: 700; letter-spacing: 6px; color: #D4AF37; margin: 20px 0; text-align: center;">
            {{ $otp }}
        </div>
        <p>This code is valid for 5 minutes only.</p>
        <p>If you did not request this, you can ignore this email.</p>
    </div>
</body>
</html>
