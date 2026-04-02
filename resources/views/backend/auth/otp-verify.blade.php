<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Verify OTP | MGM Event</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,600,700&display=fallback">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <style>
    body.login-page {
      background: #f4f7f6;
      background-image: linear-gradient(120deg, #fdfbfb 0%, #ebedee 100%);
      height: 100vh;
      font-family: 'Source Sans Pro', sans-serif;
    }
    .login-box { width: 420px; }
    .card { border: none; border-radius: 16px; box-shadow: 0 10px 40px rgba(0,0,0,0.08); background-color: #ffffff; }
    .card-body { padding: 40px 35px; }
    .login-logo { margin-bottom: 25px; }
    .login-logo a { font-weight: 700; color: #2c3e50; font-size: 1.8rem; letter-spacing: -0.5px; }
    .login-logo a b { color: #007bff; }
    .login-box-msg { padding: 0 0 20px 0; font-size: 1.05rem; color: #6c757d; }
    .otp-input { font-size: 2rem; letter-spacing: 12px; text-align: center; border: 1px solid #dce1e7; border-radius: 8px; padding: 14px; width: 100%; background: #f8f9fa; transition: all 0.3s; }
    .otp-input:focus { border-color: #007bff; background: #fff; box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.15); outline: none; }
    .btn-primary { background-color: #007bff; border: none; border-radius: 8px; padding: 10px; font-weight: 600; font-size: 1.05rem; transition: all 0.2s ease; }
    .btn-primary:hover { background-color: #0056b3; transform: translateY(-1.5px); box-shadow: 0 4px 15px rgba(0,123,255,0.3); }
    .btn-link-muted { background: none; border: none; color: #007bff; font-size: 0.9rem; padding: 0; cursor: pointer; }
    .btn-link-muted:hover { color: #0056b3; text-decoration: underline; }
  </style>
</head>
<body class="hold-transition login-page">
<div class="login-box">

  <div class="login-logo">
    <a href="#"><b>Management</b> EVENT</a>
  </div>

  <div class="card">
    <div class="card-body">
      <p class="login-box-msg">
        Enter the 6-digit OTP sent to<br>
        <strong>{{ session('otp_email') }}</strong>
      </p>

      @if (session('success'))
        <div class="alert alert-success" style="border-radius:8px;">{{ session('success') }}</div>
      @endif

      @if ($errors->any())
        <div class="alert alert-danger" style="border-radius:8px;">{{ $errors->first() }}</div>
      @endif

      <form action="{{ route('password.otp.verify') }}" method="POST">
        @csrf
        <div class="mb-4">
          <input type="text" name="otp" maxlength="6" inputmode="numeric"
                 pattern="\d{6}" class="otp-input" placeholder="_ _ _ _ _ _"
                 autofocus required>
        </div>
        <button type="submit" class="btn btn-primary btn-block mb-3">Verify OTP</button>
      </form>

      <div class="text-center" style="font-size:0.9rem; color:#6c757d;">
        Didn't receive it?
        <form action="{{ route('password.otp.resend') }}" method="POST" class="d-inline">
          @csrf
          <input type="hidden" name="email" value="{{ session('otp_email') }}">
          <button type="submit" class="btn-link-muted">Resend OTP</button>
        </form>
      </div>

      <div class="text-center mt-3 pt-3" style="border-top:1px solid #eee;">
        <a href="{{ route('password.request') }}" style="font-size:0.9rem; color:#6c757d;">Use a different email</a>
      </div>
    </div>
  </div>

</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>