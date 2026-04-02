<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <style>
    body { font-family: 'Segoe UI', sans-serif; background: #f4f7f6; margin: 0; padding: 30px; }
    .container { max-width: 480px; margin: auto; background: #fff; border-radius: 12px; padding: 40px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
    .logo { font-size: 1.4rem; font-weight: 700; color: #2c3e50; margin-bottom: 24px; }
    .logo b { color: #007bff; }
    h2 { color: #2c3e50; margin: 0 0 10px; }
    p { color: #6c757d; line-height: 1.6; }
    .otp-box { text-align: center; margin: 30px 0; }
    .otp-code { display: inline-block; font-size: 2.5rem; font-weight: 700; letter-spacing: 10px; color: #007bff; background: #f0f6ff; border: 2px dashed #007bff; border-radius: 10px; padding: 16px 32px; }
    .note { font-size: 0.85rem; color: #adb5bd; text-align: center; margin-top: 20px; }
    .footer { text-align: center; margin-top: 30px; font-size: 0.8rem; color: #ced4da; }
  </style>
</head>
<body>
  <div class="container">
    <div class="logo"><b>Management</b> EVENT</div>
    <h2>Password Reset OTP</h2>
    <p>You requested to reset your password. Use the OTP below to verify your identity:</p>

    <div class="otp-box">
      <div class="otp-code">{{ $otp }}</div>
    </div>

    <p class="note">⏱ This OTP is valid for <strong>10 minutes</strong>. Do not share it with anyone.</p>
    <p class="note">If you did not request this, you can safely ignore this email.</p>

    <div class="footer">© {{ date('Y') }} MGM Event. All rights reserved.</div>
  </div>
</body>
</html>