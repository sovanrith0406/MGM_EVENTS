<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>User Login | MGM Event</title>
  
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,600,700&display=fallback">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/icheck-bootstrap/3.0.1/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

  <style>
    body.login-page {
      background: #f4f7f6;
      background-image: linear-gradient(120deg, #fdfbfb 0%, #ebedee 100%);
      height: 100vh;
      font-family: 'Source Sans Pro', sans-serif;
    }
    .login-box { width: 420px; }
    .card {
      border: none;
      border-radius: 16px;
      box-shadow: 0 10px 40px rgba(0,0,0,0.08);
      background-color: #ffffff;
    }
    .card-body { padding: 40px 35px; }
    .login-logo { margin-bottom: 25px; }
    .login-logo a {
      font-weight: 700;
      color: #2c3e50;
      font-size: 1.8rem;
      letter-spacing: -0.5px;
    }
    .login-logo a b { color: #007bff; }
    .login-box-msg {
      padding: 0 0 25px 0;
      font-size: 1.05rem;
      color: #6c757d;
      font-weight: 400;
    }
    .input-group {
      border: 1px solid #dce1e7;
      border-radius: 8px;
      overflow: hidden;
      transition: all 0.3s ease;
      background-color: #f8f9fa;
    }
    .input-group:focus-within {
      border-color: #007bff;
      background-color: #ffffff;
      box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.15);
    }
    .input-group .form-control {
      border: none;
      background: transparent;
      padding: 22px 15px;
      box-shadow: none !important;
    }
    .input-group-text {
      border: none;
      background: transparent;
      color: #adb5bd;
    }
    .btn-primary {
      background-color: #007bff;
      border: none;
      border-radius: 8px;
      padding: 10px;
      font-weight: 600;
      font-size: 1.05rem;
      letter-spacing: 0.3px;
      transition: all 0.2s ease;
    }
    .btn-primary:hover {
      background-color: #0056b3;
      transform: translateY(-1.5px);
      box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
    }
    .text-center {
      color: #007bff;
      font-weight: 600;
      text-decoration: none;
      transition: color 0.2s ease;
    }
    .text-center:hover { color: #0056b3; }

    /* ── Forgot password link ── */
    .forgot-link {
      font-size: 0.85rem;
      color: #6c757d;
      text-decoration: none;
      transition: color 0.2s ease;
    }
    .forgot-link:hover { color: #007bff; }

    /* ── Success alert animation ── */
    .alert-success-custom {
      border-radius: 10px;
      border: none;
      background-color: #d4edda;
      color: #155724;
      padding: 14px 16px;
      margin-bottom: 20px;
      display: flex;
      align-items: center;
      gap: 10px;
      animation: slideDown 0.4s ease;
    }
    .alert-success-custom i {
      font-size: 1.2rem;
      color: #28a745;
      flex-shrink: 0;
    }
    .alert-success-custom span {
      font-size: 0.95rem;
      font-weight: 500;
    }
    @keyframes slideDown {
      from { opacity: 0; transform: translateY(-10px); }
      to   { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body class="hold-transition login-page">
<div class="login-box">

  <div class="login-logo">
    <a href="#"><b>Management</b> EVENT</a>
  </div>

  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      {{-- ✅ Password reset success alert --}}
      @if (session('success'))
        <div class="alert-success-custom" id="successAlert">
          <i class="fas fa-check-circle"></i>
          <span>{{ session('success') }}</span>
        </div>
      @endif

      {{-- Show validation errors --}}
      @if ($errors->any())
        <div class="alert alert-danger" style="border-radius: 8px;">
          {{ $errors->first() }}
        </div>
      @endif

      <form action="{{ route('login') }}" method="POST">
        @csrf

        {{-- Email --}}
        <div class="input-group mb-4">
          <input
            type="email"
            name="username"
            value="{{ old('username') }}"
            required
            autofocus
            class="form-control @error('username') is-invalid @enderror"
            placeholder="Email Address"
          >
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>

        {{-- Password --}}
        <div class="input-group mb-2">
          <input
            type="password"
            name="password"
            required
            class="form-control @error('password') is-invalid @enderror"
            placeholder="Password"
          >
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>

        {{-- Forgot Password link --}}
        <div class="text-right mb-4">
          <a href="{{ route('password.request') }}" class="forgot-link">
            Forgot your password?
          </a>
        </div>

        {{-- Remember Me + Submit --}}
        <div class="row align-items-center mb-4 mt-2">
          <div class="col-7">
            <div class="icheck-primary">
              <input type="checkbox" id="remember" name="remember">
              <label for="remember" style="font-weight: 400; color: #495057;">Remember Me</label>
            </div>
          </div>
          <div class="col-5">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
        </div>

      </form>

      <div class="text-center mt-3 pt-3" style="border-top: 1px solid #eee;">
        <a href="{{ route('register') }}" class="text-center">Register a new membership</a>
      </div>

    </div>
  </div>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

<script>
  // Auto-dismiss success alert after 5 seconds
  const alert = document.getElementById('successAlert');
  if (alert) {
    setTimeout(() => {
      alert.style.transition = 'opacity 0.5s ease';
      alert.style.opacity    = '0';
      setTimeout(() => alert.remove(), 500);
    }, 5000);
  }
</script>
</body>
</html>