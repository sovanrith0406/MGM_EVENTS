<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sign In | MGM Event</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600&display=fallback">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: 'Inter', sans-serif;
      background: #f0f2f5;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 1.5rem;
      color: #1a1a2e;
    }

    /* ── Card ────────────────────────────────────────────── */
    .login-card {
      background: #ffffff;
      border-radius: 20px;
      box-shadow: 0 2px 24px rgba(0,0,0,0.07), 0 1px 4px rgba(0,0,0,0.04);
      padding: 2.5rem 2.25rem;
      width: 100%;
      max-width: 420px;
    }

    /* ── Brand ───────────────────────────────────────────── */
    .brand {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 2rem;
    }
    .brand-icon {
      width: 36px; height: 36px;
      background: #185FA5;
      border-radius: 10px;
      display: flex; align-items: center; justify-content: center;
      flex-shrink: 0;
    }
    .brand-icon i { color: #e6f1fb; font-size: 16px; }
    .brand-name {
      font-size: 16px;
      font-weight: 600;
      color: #1a1a2e;
      letter-spacing: -0.2px;
    }
    .brand-name span { color: #185FA5; }

    /* ── Heading ─────────────────────────────────────────── */
    .login-heading {
      font-size: 22px;
      font-weight: 600;
      color: #1a1a2e;
      margin-bottom: 6px;
    }
    .login-sub {
      font-size: 14px;
      color: #6b7280;
      margin-bottom: 1.75rem;
    }

    /* ── Alerts ──────────────────────────────────────────── */
    .alert {
      border-radius: 10px;
      padding: 11px 14px;
      font-size: 13px;
      font-weight: 500;
      display: flex;
      align-items: center;
      gap: 9px;
      margin-bottom: 1.25rem;
    }
    .alert-success {
      background: #f0fdf4;
      border: 1px solid #bbf7d0;
      color: #166534;
    }
    .alert-danger {
      background: #fff1f2;
      border: 1px solid #fecdd3;
      color: #9f1239;
    }

    /* ── Form fields ─────────────────────────────────────── */
    .field-group { margin-bottom: 1rem; }
    .field-label {
      display: block;
      font-size: 13px;
      font-weight: 500;
      color: #374151;
      margin-bottom: 6px;
    }
    .field-wrap {
      position: relative;
    }
    .field-wrap .field-icon {
      position: absolute;
      left: 12px;
      top: 50%;
      transform: translateY(-50%);
      color: #9ca3af;
      font-size: 14px;
      pointer-events: none;
    }
    .field-wrap input {
      width: 100%;
      height: 42px;
      padding: 0 42px;
      border: 1px solid #e5e7eb;
      border-radius: 10px;
      font-size: 14px;
      color: #1a1a2e;
      background: #f9fafb;
      transition: all 0.2s ease;
      outline: none;
    }
    .field-wrap input::placeholder { color: #9ca3af; }
    .field-wrap input:focus {
      border-color: #185FA5;
      background: #ffffff;
      box-shadow: 0 0 0 3px rgba(24,95,165,0.1);
    }
    .field-wrap input.is-invalid {
      border-color: #f87171;
      background: #fff1f2;
    }
    .invalid-feedback {
      font-size: 12px;
      color: #dc2626;
      margin-top: 5px;
      display: block;
    }
    /* Show / hide password toggle */
    .toggle-pw {
      position: absolute;
      right: 12px;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      cursor: pointer;
      color: #9ca3af;
      font-size: 14px;
      padding: 0;
      line-height: 1;
    }
    .toggle-pw:hover { color: #185FA5; }

    /* ── Row between ─────────────────────────────────────── */
    .row-between {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 1.5rem;
    }
    .remember-label {
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: 13px;
      color: #6b7280;
      cursor: pointer;
    }
    .remember-label input[type=checkbox] {
      width: 15px; height: 15px;
      accent-color: #185FA5;
      cursor: pointer;
    }
    .forgot-link {
      font-size: 13px;
      color: #185FA5;
      text-decoration: none;
      font-weight: 500;
    }
    .forgot-link:hover { text-decoration: underline; }

    /* ── Buttons ─────────────────────────────────────────── */
    .btn-signin {
      width: 100%;
      height: 44px;
      background: #185FA5;
      color: #e6f1fb;
      border: none;
      border-radius: 10px;
      font-size: 15px;
      font-weight: 600;
      cursor: pointer;
      letter-spacing: 0.1px;
      transition: all 0.2s ease;
      margin-bottom: 1.25rem;
    }
    .btn-signin:hover {
      background: #0C447C;
      box-shadow: 0 4px 14px rgba(24,95,165,0.3);
      transform: translateY(-1px);
    }
    .btn-signin:active { transform: scale(0.99); }

    /* ── Divider ─────────────────────────────────────────── */
    .divider {
      display: flex;
      align-items: center;
      gap: 12px;
      margin-bottom: 1.25rem;
    }
    .divider-line { flex: 1; height: 1px; background: #f0f0f0; }
    .divider-text { font-size: 12px; color: #9ca3af; }

    /* ── Google button ───────────────────────────────────── */
    .btn-google {
      width: 100%;
      height: 42px;
      background: #ffffff;
      border: 1px solid #e5e7eb;
      border-radius: 10px;
      font-size: 14px;
      font-weight: 500;
      color: #374151;
      cursor: pointer;
      display: flex; align-items: center; justify-content: center; gap: 9px;
      margin-bottom: 1.5rem;
      transition: all 0.2s ease;
    }
    .btn-google:hover { background: #f9fafb; border-color: #d1d5db; }

    /* ── Register row ────────────────────────────────────── */
    .register-row {
      text-align: center;
      font-size: 13px;
      color: #6b7280;
      padding-top: 1.25rem;
      border-top: 1px solid #f3f4f6;
    }
    .register-row a {
      color: #185FA5;
      font-weight: 600;
      text-decoration: none;
    }
    .register-row a:hover { text-decoration: underline; }
  </style>
</head>

<body>
<div class="login-card">

  {{-- Brand --}}
  <div class="brand">
    <div class="brand-icon"><i class="fas fa-calendar-alt"></i></div>
    <div class="brand-name">MGM <span>Event</span></div>
  </div>

  <h1 class="login-heading">Welcome back</h1>
  <p class="login-sub">Sign in to your account to continue</p>

  {{-- Success alert (e.g. after password reset) --}}
  @if(session('success'))
    <div class="alert alert-success" id="successAlert">
      <i class="fas fa-check-circle"></i>
      {{ session('success') }}
    </div>
  @endif

  {{-- Validation errors --}}
  @if($errors->any())
    <div class="alert alert-danger">
      <i class="fas fa-exclamation-circle"></i>
      {{ $errors->first() }}
    </div>
  @endif

  <form action="{{ route('login') }}" method="POST" autocomplete="on">
    @csrf

    {{-- Email --}}
    <div class="field-group">
      <label class="field-label" for="username">Email address</label>
      <div class="field-wrap">
        <i class="fas fa-envelope field-icon"></i>
        <input type="email"
               name="username"
               id="username"
               value="{{ old('username') }}"
               placeholder="you@example.com"
               class="@error('username') is-invalid @enderror"
               required autofocus autocomplete="email">
        @error('username')
          <span class="invalid-feedback">{{ $message }}</span>
        @enderror
      </div>
    </div>

    {{-- Password --}}
    <div class="field-group">
      <label class="field-label" for="password">Password</label>
      <div class="field-wrap">
        <i class="fas fa-lock field-icon"></i>
        <input type="password"
               name="password"
               id="password"
               placeholder="Enter your password"
               class="@error('password') is-invalid @enderror"
               required autocomplete="current-password">
        <button type="button" class="toggle-pw" id="togglePw" onclick="togglePassword()">
          <i class="fas fa-eye" id="toggleIcon"></i>
        </button>
        @error('password')
          <span class="invalid-feedback">{{ $message }}</span>
        @enderror
      </div>
    </div>

    {{-- Remember me + Forgot password --}}
    <div class="row-between">
      <label class="remember-label">
        <input type="checkbox" name="remember" id="remember">
        Remember me
      </label>
      <a href="{{ route('password.request') }}" class="forgot-link">Forgot password?</a>
    </div>

    {{-- Submit --}}
    <button type="submit" class="btn-signin">Sign in</button>

  </form>

  {{-- Divider --}}
  <div class="divider">
    <div class="divider-line"></div>
    <span class="divider-text">or</span>
    <div class="divider-line"></div>
  </div>

  

  {{-- Register link --}}
  <div class="register-row">
    Don't have an account? <a href="{{ route('register') }}">Create one</a>
  </div>

</div>

<script>
  function togglePassword() {
    const pw   = document.getElementById('password');
    const icon = document.getElementById('toggleIcon');
    if (pw.type === 'password') {
      pw.type = 'text';
      icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
      pw.type = 'password';
      icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
  }

  // Auto-dismiss success alert after 5 s
  const successAlert = document.getElementById('successAlert');
  if (successAlert) {
    setTimeout(() => {
      successAlert.style.transition = 'opacity 0.5s ease';
      successAlert.style.opacity = '0';
      setTimeout(() => successAlert.remove(), 500);
    }, 5000);
  }
</script>
</body>
</html>