<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 30px; }
        .card { background: #fff; max-width: 480px; margin: auto; border-radius: 8px;
                padding: 40px; box-shadow: 0 2px 8px rgba(0,0,0,.1); }
        .otp  { font-size: 36px; font-weight: bold; letter-spacing: 10px;
                color: #3490dc; text-align: center; margin: 24px 0; }
        .note { font-size: 13px; color: #888; text-align: center; margin-top: 16px; }
    </style>
</head>
<body>
    <div class="card">
        <h2 style="text-align:center; color:#333;">Password Reset OTP</h2>
        <p>You requested a password reset. Use the OTP below to verify your identity:</p>
        <div class="otp">{{ $otp }}</div>
        <p>This OTP is valid for <strong>10 minutes</strong>. Do not share it with anyone.</p>
        <p class="note">If you did not request this, please ignore this email.</p>
    </div>
</body>
</html>