<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Verify OTP | MGM Event</title>

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
    .page-sub { font-size: 14px; color: #6b7280; margin-bottom: 1.75rem; line-height: 1.6; }
    .page-sub strong { color: #1a1a2e; font-weight: 600; }

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
    .alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; }
    .alert-danger  { background: #fff1f2; border: 1px solid #fecdd3; color: #9f1239; }

    /* ── OTP boxes ───────────────────────────────────────── */
    .otp-row {
      display: flex;
      gap: 10px;
      justify-content: center;
      margin-bottom: 1.5rem;
    }
    .otp-box {
      width: 52px;
      height: 56px;
      border: 1px solid #e5e7eb;
      border-radius: 12px;
      background: #f9fafb;
      font-size: 22px;
      font-weight: 600;
      text-align: center;
      color: #1a1a2e;
      outline: none;
      transition: all 0.2s ease;
      font-family: 'Inter', sans-serif;
      caret-color: #185FA5;
    }
    .otp-box:focus {
      border-color: #185FA5;
      background: #ffffff;
      box-shadow: 0 0 0 3px rgba(24,95,165,0.1);
    }
    .otp-box.filled {
      border-color: #185FA5;
      background: #eff6ff;
      color: #185FA5;
    }
    .otp-box.is-invalid { border-color: #f87171; background: #fff1f2; }
    .invalid-feedback { font-size: 12px; color: #dc2626; text-align: center; display: block; margin-bottom: 1rem; }

    /* ── Timer ───────────────────────────────────────────── */
    .timer-row {
      text-align: center;
      font-size: 13px;
      color: #6b7280;
      margin-bottom: 1.5rem;
    }
    .timer-count {
      font-weight: 600;
      color: #185FA5;
    }

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
      font-family: 'Inter', sans-serif;
      margin-bottom: 1rem;
    }
    .btn-submit:hover {
      background: #0C447C;
      box-shadow: 0 4px 14px rgba(24,95,165,0.3);
      transform: translateY(-1px);
    }
    .btn-submit:active { transform: scale(0.99); }
    .btn-submit:disabled {
      background: #93c5fd;
      cursor: not-allowed;
      transform: none;
      box-shadow: none;
    }

    /* ── Resend / back ───────────────────────────────────── */
    .resend-row {
      text-align: center;
      font-size: 13px;
      color: #6b7280;
      margin-bottom: 1.25rem;
    }
    .btn-resend {
      background: none; border: none;
      color: #185FA5; font-size: 13px; font-weight: 600;
      cursor: pointer; padding: 0;
      font-family: 'Inter', sans-serif;
    }
    .btn-resend:hover { text-decoration: underline; }
    .btn-resend:disabled { color: #9ca3af; cursor: not-allowed; text-decoration: none; }

    .back-row {
      text-align: center;
      font-size: 13px;
      color: #6b7280;
      padding-top: 1.25rem;
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
    <i class="fas fa-shield-alt"></i>
  </div>

  <h1 class="page-heading">Check your email</h1>
  <p class="page-sub">
    We sent a 6-digit code to<br>
    <strong>{{ session('otp_email') }}</strong>
  </p>

  @if(session('success'))
    <div class="alert alert-success">
      <i class="fas fa-check-circle"></i>
      <span>{{ session('success') }}</span>
    </div>
  @endif

  @if($errors->any())
    <div class="alert alert-danger">
      <i class="fas fa-exclamation-circle"></i>
      <span>{{ $errors->first() }}</span>
    </div>
  @endif

  <form action="{{ route('password.otp.verify') }}" method="POST" id="otpForm">
    @csrf

    {{-- 6 individual OTP boxes (assembled into hidden input on submit) --}}
    <div class="otp-row">
      <input class="otp-box" type="text" maxlength="1" inputmode="numeric" pattern="\d" id="d0">
      <input class="otp-box" type="text" maxlength="1" inputmode="numeric" pattern="\d" id="d1">
      <input class="otp-box" type="text" maxlength="1" inputmode="numeric" pattern="\d" id="d2">
      <input class="otp-box" type="text" maxlength="1" inputmode="numeric" pattern="\d" id="d3">
      <input class="otp-box" type="text" maxlength="1" inputmode="numeric" pattern="\d" id="d4">
      <input class="otp-box" type="text" maxlength="1" inputmode="numeric" pattern="\d" id="d5">
    </div>
    <input type="hidden" name="otp" id="otpHidden">

    @error('otp')
      <span class="invalid-feedback">{{ $message }}</span>
    @enderror

    {{-- Countdown timer --}}
    <div class="timer-row">
      Code expires in <span class="timer-count" id="timerCount">10:00</span>
    </div>

    <button type="submit" class="btn-submit" id="submitBtn">Verify code</button>
  </form>

  <div class="resend-row">
    Didn't receive it?
    <form action="{{ route('password.otp.resend') }}" method="POST" class="d-inline" id="resendForm">
      @csrf
      <input type="hidden" name="email" value="{{ session('otp_email') }}">
      <button type="submit" class="btn-resend" id="resendBtn" disabled>Resend code</button>
    </form>
  </div>

  <div class="back-row">
    <a href="{{ route('password.request') }}">
      <i class="fas fa-arrow-left" style="font-size:11px; margin-right:4px;"></i> Use a different email
    </a>
  </div>

</div>

<script>
  // ── OTP box navigation ──────────────────────────────────
  const boxes = Array.from({ length: 6 }, (_, i) => document.getElementById('d' + i));

  boxes.forEach((box, idx) => {
    box.addEventListener('input', e => {
      const v = e.target.value.replace(/\D/g, '');
      e.target.value = v;
      e.target.classList.toggle('filled', v !== '');
      if (v && idx < 5) boxes[idx + 1].focus();
    });

    box.addEventListener('keydown', e => {
      if (e.key === 'Backspace' && !box.value && idx > 0) {
        boxes[idx - 1].value = '';
        boxes[idx - 1].classList.remove('filled');
        boxes[idx - 1].focus();
      }
    });

    // Handle paste on any box
    box.addEventListener('paste', e => {
      e.preventDefault();
      const text = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g, '').slice(0, 6);
      text.split('').forEach((ch, i) => {
        if (boxes[i]) {
          boxes[i].value = ch;
          boxes[i].classList.add('filled');
        }
      });
      const nextEmpty = boxes.find(b => !b.value);
      if (nextEmpty) nextEmpty.focus(); else boxes[5].focus();
    });
  });

  // Assemble hidden input on submit
  document.getElementById('otpForm').addEventListener('submit', e => {
    const code = boxes.map(b => b.value).join('');
    if (code.length < 6) {
      e.preventDefault();
      boxes.forEach(b => b.classList.add('is-invalid'));
      return;
    }
    document.getElementById('otpHidden').value = code;
  });

  boxes[0].focus();

  // ── Countdown timer (10 minutes) ───────────────────────
  let seconds = 600;
  const timerEl   = document.getElementById('timerCount');
  const resendBtn = document.getElementById('resendBtn');

  const tick = setInterval(() => {
    seconds--;
    const m = String(Math.floor(seconds / 60)).padStart(2, '0');
    const s = String(seconds % 60).padStart(2, '0');
    timerEl.textContent = m + ':' + s;
    if (seconds <= 0) {
      clearInterval(tick);
      timerEl.textContent = 'Expired';
      timerEl.style.color = '#dc2626';
      document.getElementById('submitBtn').disabled = true;
      resendBtn.disabled = false;
    }
  }, 1000);
</script>
</body>
</html>