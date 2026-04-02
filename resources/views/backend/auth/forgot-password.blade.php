<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Forgot Password | MGM Event</title>
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
    .login-box-msg { padding: 0 0 25px 0; font-size: 1.05rem; color: #6c757d; font-weight: 400; }
    .input-group { border: 1px solid #dce1e7; border-radius: 8px; overflow: hidden; transition: all 0.3s ease; background-color: #f8f9fa; }
    .input-group:focus-within { border-color: #007bff; background-color: #ffffff; box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.15); }
    .input-group .form-control { border: none; background: transparent; padding: 22px 15px; box-shadow: none !important; }
    .input-group-text { border: none; background: transparent; color: #adb5bd; }
    .btn-primary { background-color: #007bff; border: none; border-radius: 8px; padding: 10px; font-weight: 600; font-size: 1.05rem; transition: all 0.2s ease; }
    .btn-primary:hover { background-color: #0056b3; transform: translateY(-1.5px); box-shadow: 0 4px 15px rgba(0,123,255,0.3); }
  </style>
</head>
<body class="hold-transition login-page">
<div class="login-box">

  <div class="login-logo">
    <a href="#"><b>Management</b> EVENT</a>
  </div>

  <div class="card">
    <div class="card-body">
      <p class="login-box-msg">Enter your email to receive a reset OTP.</p>

      @if (session('success'))
        <div class="alert alert-success" style="border-radius:8px;">{{ session('success') }}</div>
      @endif

      @if ($errors->any())
        <div class="alert alert-danger" style="border-radius:8px;">{{ $errors->first() }}</div>
      @endif

      <form action="{{ route('password.email') }}" method="POST">
        @csrf
        <div class="input-group mb-4">
          <input type="email" name="email" value="{{ old('email') }}"
                 class="form-control" placeholder="Email Address" required autofocus>
          <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-envelope"></span></div>
          </div>
        </div>

        <button type="submit" class="btn btn-primary btn-block">Send OTP</button>
      </form>

      <div class="text-center mt-3 pt-3" style="border-top:1px solid #eee;">
        <a href="{{ route('login') }}" style="font-size:0.9rem; color:#6c757d;">Back to Login</a>
      </div>
    </div>
  </div>

</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>