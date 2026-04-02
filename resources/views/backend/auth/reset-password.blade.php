<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Reset Password | MGM Event</title>

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

    .auth-card {
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
    .brand-name { font-size: 16px; font-weight: 600; color: #1a1a2e; letter-spacing: -0.2px; }
    .brand-name span { color: #185FA5; }

    /* ── Icon circle ─────────────────────────────────────── */
    .icon-circle {
      width: 56px; height: 56px;
      background: #eff6ff;
      border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      margin-bottom: 1.25rem;
    }
    .icon-circle i { color: #185FA5; font-size: 22px; }

    .page-heading { font-size: 22px; font-weight: 600; color: #1a1a2e; margin-bottom: 6px; }
    .page-sub { font-size: 14px; color: #6b7280; margin-bottom: 1.75rem; line-height: 1.5; }

    /* ── Alerts ──────────────────────────────────────────── */
    .alert {
      border-radius: 10px;
      padding: 11px 14px;
      font-size: 13px;
      font-weight: 500;
      display: flex;
      align-items: flex-start;
      gap: 9px;
      margin-bottom: 1.25rem;
    }
    .alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; }
    .alert-danger  { background: #fff1f2; border: 1px solid #fecdd3; color: #9f1239; }
    .alert ul { margin: 0; padding-left: 16px; }
    .alert ul li { margin-top: 3px; }

    /* ── Fields ──────────────────────────────────────────── */
    .field-group { margin-bottom: 1rem; }
    .field-label {
      display: block;
      font-size: 13px;
      font-weight: 500;
      color: #374151;
      margin-bottom: 6px;
    }
    .field-wrap { position: relative; }
    .field-wrap .field-icon {
      position: absolute;
      left: 12px; top: 50%;
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
      font-family: 'Inter', sans-serif;
    }
    .field-wrap input::placeholder { color: #9ca3af; }
    .field-wrap input:focus {
      border-color: #185FA5;
      background: #ffffff;
      box-shadow: 0 0 0 3px rgba(24,95,165,0.1);
    }
    .field-wrap input.is-invalid { border-color: #f87171; background: #fff1f2; }
    .invalid-feedback { font-size: 12px; color: #dc2626; margin-top: 5px; display: block; }

    /* Password strength bar */
    .strength-bar-wrap {
      margin-top: 8px;
      display: flex;
      gap: 4px;
    }
    .strength-seg {
      flex: 1;
      height: 4px;
      border-radius: 2px;
      background: #e5e7eb;
      transition: background 0.3s ease;
    }
    .strength-label {
      font-size: 11px;
      margin-top: 5px;
      color: #9ca3af;
    }

    /* Toggle eye */
    .toggle-pw {
      position: absolute;
      right: 12px; top: 50%;
      transform: translateY(-50%);
      background: none; border: none;
      cursor: pointer;
      color: #9ca3af;
      font-size: 14px;
      padding: 0; line-height: 1;
    }
    .toggle-pw:hover { color: #185FA5; }

    /* ── Submit button ───────────────────────────────────── */
    .btn-submit {
      width: 100%;
      height: 44px;
      background: #185FA5;
      color: #e6f1fb;
      border: none;
      border-radius: 10px;
      font-size: 15px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.2s ease;
      margin-top: 0.5rem;
      font-family: 'Inter', sans-serif;
    }
    .btn-submit:hover {
      background: #0C447C;
      box-shadow: 0 4px 14px rgba(24,95,165,0.3);
      transform: translateY(-1px);
    }
    .btn-submit:active { transform: scale(0.99); }

    /* ── Back link ───────────────────────────────────────── */
    .back-row {
      text-align: center;
      font-size: 13px;
      color: #6b7280;
      padding-top: 1.25rem;
      margin-top: 1.25rem;
      border-top: 1px solid #f3f4f6;
    }
    .back-row a { color: #185FA5; font-weight: 600; text-decoration: none; }
    .back-row a:hover { text-decoration: underline; }
  </style>
</head>

<body>
<div class="auth-card">

  <div class="brand">
    <div class="brand-icon"><i class="fas fa-calendar-alt"></i></div>
    <div class="brand-name">MGM <span>Event</span></div>
  </div>

  <div class="icon-circle">
    <i class="fas fa-key"></i>
  </div>

  <h1 class="page-heading">Set new password</h1>
  <p class="page-sub">Your new password must be at least 8 characters.</p>

  @if(session('success'))
    <div class="alert alert-success">
      <i class="fas fa-check-circle" style="margin-top:1px; flex-shrink:0;"></i>
      <span>{{ session('success') }}</span>
    </div>
  @endif

  @if($errors->any())
    <div class="alert alert-danger">
      <i class="fas fa-exclamation-circle" style="margin-top:1px; flex-shrink:0;"></i>
      <ul>
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('password.reset.submit') }}" method="POST" autocomplete="off">
    @csrf

    {{-- New Password --}}
    <div class="field-group">
      <label class="field-label" for="password">New password</label>
      <div class="field-wrap">
        <i class="fas fa-lock field-icon"></i>
        <input type="password" name="password" id="password"
               placeholder="Minimum 8 characters"
               class="{{ $errors->has('password') ? 'is-invalid' : '' }}"
               required autocomplete="new-password"
               oninput="checkStrength(this.value)">
        <button type="button" class="toggle-pw" onclick="togglePw('password', 'icon1')">
          <i class="fas fa-eye" id="icon1"></i>
        </button>
      </div>
      <div class="strength-bar-wrap">
        <div class="strength-seg" id="seg1"></div>
        <div class="strength-seg" id="seg2"></div>
        <div class="strength-seg" id="seg3"></div>
        <div class="strength-seg" id="seg4"></div>
      </div>
      <div class="strength-label" id="strengthLabel"></div>
      @error('password')
        <span class="invalid-feedback">{{ $message }}</span>
      @enderror
    </div>

    {{-- Confirm Password --}}
    <div class="field-group">
      <label class="field-label" for="password_confirmation">Confirm new password</label>
      <div class="field-wrap">
        <i class="fas fa-lock field-icon"></i>
        <input type="password" name="password_confirmation" id="password_confirmation"
               placeholder="Re-enter your password"
               class="{{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}"
               required autocomplete="new-password">
        <button type="button" class="toggle-pw" onclick="togglePw('password_confirmation', 'icon2')">
          <i class="fas fa-eye" id="icon2"></i>
        </button>
      </div>
      @error('password_confirmation')
        <span class="invalid-feedback">{{ $message }}</span>
      @enderror
    </div>

    <button type="submit" class="btn-submit">Reset password</button>
  </form>

  <div class="back-row">
    <a href="{{ route('login') }}"><i class="fas fa-arrow-left" style="font-size:11px; margin-right:4px;"></i> Back to sign in</a>
  </div>

</div>

<script>
  function togglePw(fieldId, iconId) {
    const f = document.getElementById(fieldId);
    const i = document.getElementById(iconId);
    if (f.type === 'password') {
      f.type = 'text';
      i.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
      f.type = 'password';
      i.classList.replace('fa-eye-slash', 'fa-eye');
    }
  }

  function checkStrength(val) {
    const segs   = [document.getElementById('seg1'), document.getElementById('seg2'),
                    document.getElementById('seg3'), document.getElementById('seg4')];
    const label  = document.getElementById('strengthLabel');
    const colors = ['#f87171', '#fb923c', '#facc15', '#22c55e'];
    const labels = ['Weak', 'Fair', 'Good', 'Strong'];
    let score = 0;
    if (val.length >= 8)              score++;
    if (/[A-Z]/.test(val))            score++;
    if (/[0-9]/.test(val))            score++;
    if (/[^A-Za-z0-9]/.test(val))     score++;
    segs.forEach((s, i) => {
      s.style.background = i < score ? colors[score - 1] : '#e5e7eb';
    });
    label.textContent   = val.length ? labels[score - 1] ?? '' : '';
    label.style.color   = val.length ? colors[score - 1] : '#9ca3af';
  }
</script>
</body>
</html>