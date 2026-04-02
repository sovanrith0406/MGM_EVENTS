<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Supplier Registration | MGM Event</title>

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
      padding: 2rem 1rem;
      color: #1a1a2e;
    }

    .auth-card {
      background: #ffffff;
      border-radius: 20px;
      box-shadow: 0 2px 24px rgba(0,0,0,0.07), 0 1px 4px rgba(0,0,0,0.04);
      padding: 2.5rem 2.25rem;
      width: 100%;
      max-width: 460px;
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

    /* ── Heading ─────────────────────────────────────────── */
    .page-heading { font-size: 22px; font-weight: 600; color: #1a1a2e; margin-bottom: 6px; }
    .page-sub { font-size: 14px; color: #6b7280; margin-bottom: 1.75rem; line-height: 1.5; }

    /* ── Role badge ──────────────────────────────────────── */
    .role-badge {
      display: inline-flex;
      align-items: center;
      gap: 7px;
      background: #eff6ff;
      border: 1px solid #bfdbfe;
      color: #1d4ed8;
      border-radius: 20px;
      padding: 5px 14px;
      font-size: 13px;
      font-weight: 500;
      margin-bottom: 1.75rem;
    }
    .role-badge i { font-size: 12px; }

    /* ── Alert ───────────────────────────────────────────── */
    .alert-danger {
      border-radius: 10px;
      padding: 11px 14px;
      font-size: 13px;
      font-weight: 500;
      display: flex;
      align-items: flex-start;
      gap: 9px;
      margin-bottom: 1.25rem;
      background: #fff1f2;
      border: 1px solid #fecdd3;
      color: #9f1239;
    }
    .alert-danger ul { margin: 0; padding-left: 16px; }
    .alert-danger ul li { margin-top: 3px; }

    /* ── Avatar upload ───────────────────────────────────── */
    .avatar-upload-wrap {
      display: flex;
      align-items: center;
      gap: 16px;
      margin-bottom: 1.5rem;
    }
    .avatar-preview {
      width: 64px; height: 64px;
      border-radius: 50%;
      background: #f1f5f9;
      border: 2px dashed #cbd5e1;
      display: flex; align-items: center; justify-content: center;
      overflow: hidden;
      flex-shrink: 0;
      cursor: pointer;
      transition: border-color 0.2s ease;
    }
    .avatar-preview:hover { border-color: #185FA5; }
    .avatar-preview img { width: 100%; height: 100%; object-fit: cover; }
    .avatar-preview i { font-size: 22px; color: #94a3b8; }
    .avatar-upload-info { flex: 1; }
    .avatar-upload-info .upload-label {
      font-size: 13px; font-weight: 500; color: #374151;
      display: block; margin-bottom: 3px;
    }
    .avatar-upload-info .upload-hint {
      font-size: 12px; color: #9ca3af;
    }
    .btn-upload {
      font-size: 12px; font-weight: 500;
      color: #185FA5; background: #eff6ff;
      border: 1px solid #bfdbfe;
      border-radius: 8px; padding: 5px 12px;
      cursor: pointer; margin-top: 6px;
      display: inline-block;
      transition: background 0.2s ease;
    }
    .btn-upload:hover { background: #dbeafe; }
    #avatarInput { display: none; }

    /* ── Section divider ─────────────────────────────────── */
    .section-divider {
      font-size: 11px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.8px;
      color: #9ca3af;
      margin: 1.25rem 0 1rem;
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .section-divider::after {
      content: '';
      flex: 1;
      height: 1px;
      background: #f3f4f6;
    }

    /* ── Fields ──────────────────────────────────────────── */
    .field-group { margin-bottom: 1rem; }
    .field-row { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 1rem; }
    .field-label {
      display: block;
      font-size: 13px; font-weight: 500;
      color: #374151;
      margin-bottom: 6px;
    }
    .field-wrap { position: relative; }
    .field-wrap .field-icon {
      position: absolute;
      left: 12px; top: 50%;
      transform: translateY(-50%);
      color: #9ca3af; font-size: 14px;
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

    /* Password strength */
    .strength-bar-wrap { display: flex; gap: 4px; margin-top: 8px; }
    .strength-seg {
      flex: 1; height: 4px; border-radius: 2px;
      background: #e5e7eb; transition: background 0.3s ease;
    }
    .strength-label { font-size: 11px; margin-top: 4px; color: #9ca3af; }

    /* Toggle eye */
    .toggle-pw {
      position: absolute; right: 12px; top: 50%;
      transform: translateY(-50%);
      background: none; border: none; cursor: pointer;
      color: #9ca3af; font-size: 14px; padding: 0; line-height: 1;
    }
    .toggle-pw:hover { color: #185FA5; }

    /* ── Terms row ───────────────────────────────────────── */
    .terms-row {
      display: flex;
      align-items: flex-start;
      gap: 10px;
      margin-bottom: 1.5rem;
      margin-top: 0.25rem;
    }
    .terms-row input[type=checkbox] {
      width: 16px; height: 16px;
      accent-color: #185FA5;
      margin-top: 2px; flex-shrink: 0; cursor: pointer;
    }
    .terms-row label {
      font-size: 13px; color: #6b7280; cursor: pointer; line-height: 1.5;
    }
    .terms-row label a { color: #185FA5; text-decoration: none; font-weight: 500; }
    .terms-row label a:hover { text-decoration: underline; }

    /* ── Submit button ───────────────────────────────────── */
    .btn-submit {
      width: 100%;
      height: 44px;
      background: #185FA5;
      color: #e6f1fb;
      border: none;
      border-radius: 10px;
      font-size: 15px; font-weight: 600;
      cursor: pointer;
      transition: all 0.2s ease;
      font-family: 'Inter', sans-serif;
      margin-bottom: 1.25rem;
    }
    .btn-submit:hover {
      background: #0C447C;
      box-shadow: 0 4px 14px rgba(24,95,165,0.3);
      transform: translateY(-1px);
    }
    .btn-submit:active { transform: scale(0.99); }

    /* ── Login link ──────────────────────────────────────── */
    .login-row {
      text-align: center;
      font-size: 13px;
      color: #6b7280;
      padding-top: 1.25rem;
      border-top: 1px solid #f3f4f6;
    }
    .login-row a { color: #185FA5; font-weight: 600; text-decoration: none; }
    .login-row a:hover { text-decoration: underline; }
  </style>
</head>

<body>
<div class="auth-card">

  {{-- Brand --}}
  <div class="brand">
    <div class="brand-icon"><i class="fas fa-calendar-alt"></i></div>
    <div class="brand-name">MGM <span>Event</span></div>
  </div>

  <h1 class="page-heading">Create your account</h1>
  <p class="page-sub">Join MGM Event as a supplier to manage and grow your services.</p>

  {{-- Role badge --}}
  <div class="role-badge">
    <i class="fas fa-briefcase"></i> Event Supplier Account
  </div>

  {{-- Validation errors --}}
  @if($errors->any())
    <div class="alert-danger">
      <i class="fas fa-exclamation-circle" style="margin-top:1px; flex-shrink:0;"></i>
      <ul>
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
    @csrf

    {{-- Avatar upload --}}
    <div class="avatar-upload-wrap">
      <div class="avatar-preview" id="avatarPreview" onclick="document.getElementById('avatarInput').click()">
        <i class="fas fa-user" id="avatarPlaceholder"></i>
        <img id="avatarImg" src="#" alt="Avatar" style="display:none;">
      </div>
      <div class="avatar-upload-info">
        <span class="upload-label">Profile photo <span style="color:#9ca3af; font-weight:400;">(optional)</span></span>
        <span class="upload-hint">JPG, PNG or WEBP · Max 2MB</span>
        <label class="btn-upload" for="avatarInput">Choose photo</label>
        <input type="file" name="avatar" id="avatarInput" accept="image/*" onchange="previewAvatar(this)">
      </div>
    </div>

    {{-- Personal info --}}
    <div class="section-divider">Account details</div>

    <div class="field-group">
      <label class="field-label" for="full_name">Full name</label>
      <div class="field-wrap">
        <i class="fas fa-user field-icon"></i>
        <input type="text" name="full_name" id="full_name"
               value="{{ old('full_name') }}"
               placeholder="Your full name"
               class="{{ $errors->has('full_name') ? 'is-invalid' : '' }}"
               required autofocus autocomplete="name">
        @error('full_name')<span class="invalid-feedback">{{ $message }}</span>@enderror
      </div>
    </div>

    <div class="field-group">
      <label class="field-label" for="email">Email address</label>
      <div class="field-wrap">
        <i class="fas fa-envelope field-icon"></i>
        <input type="email" name="email" id="email"
               value="{{ old('email') }}"
               placeholder="you@example.com"
               class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
               required autocomplete="email">
        @error('email')<span class="invalid-feedback">{{ $message }}</span>@enderror
      </div>
    </div>

    {{-- Password --}}
    <div class="section-divider">Security</div>

    <div class="field-group">
      <label class="field-label" for="password">Password</label>
      <div class="field-wrap">
        <i class="fas fa-lock field-icon"></i>
        <input type="password" name="password" id="password"
               placeholder="Minimum 8 characters"
               class="{{ $errors->has('password') ? 'is-invalid' : '' }}"
               required autocomplete="new-password"
               oninput="checkStrength(this.value)">
        <button type="button" class="toggle-pw" onclick="togglePw('password','pwIcon')">
          <i class="fas fa-eye" id="pwIcon"></i>
        </button>
      </div>
      <div class="strength-bar-wrap">
        <div class="strength-seg" id="seg1"></div>
        <div class="strength-seg" id="seg2"></div>
        <div class="strength-seg" id="seg3"></div>
        <div class="strength-seg" id="seg4"></div>
      </div>
      <div class="strength-label" id="strengthLabel"></div>
      @error('password')<span class="invalid-feedback">{{ $message }}</span>@enderror
    </div>

    <div class="field-group">
      <label class="field-label" for="password_confirmation">Confirm password</label>
      <div class="field-wrap">
        <i class="fas fa-lock field-icon"></i>
        <input type="password" name="password_confirmation" id="password_confirmation"
               placeholder="Re-enter your password"
               required autocomplete="new-password">
        <button type="button" class="toggle-pw" onclick="togglePw('password_confirmation','cpwIcon')">
          <i class="fas fa-eye" id="cpwIcon"></i>
        </button>
      </div>
    </div>

    {{-- Terms --}}
    <div class="terms-row">
      <input type="checkbox" id="agreeTerms" name="terms" required>
      <label for="agreeTerms">
        I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>
      </label>
    </div>

    <button type="submit" class="btn-submit">Create account</button>

  </form>

  <div class="login-row">
    Already have an account? <a href="{{ route('login') }}">Sign in</a>
  </div>

</div>

<script>
  // ── Avatar preview ──────────────────────────────────────
  function previewAvatar(input) {
    if (input.files && input.files[0]) {
      const reader = new FileReader();
      reader.onload = e => {
        document.getElementById('avatarImg').src = e.target.result;
        document.getElementById('avatarImg').style.display = 'block';
        document.getElementById('avatarPlaceholder').style.display = 'none';
      };
      reader.readAsDataURL(input.files[0]);
    }
  }

  // ── Password toggle ─────────────────────────────────────
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

  // ── Password strength ───────────────────────────────────
  function checkStrength(val) {
    const segs   = ['seg1','seg2','seg3','seg4'].map(id => document.getElementById(id));
    const label  = document.getElementById('strengthLabel');
    const colors = ['#f87171','#fb923c','#facc15','#22c55e'];
    const labels = ['Weak','Fair','Good','Strong'];
    let score = 0;
    if (val.length >= 8)           score++;
    if (/[A-Z]/.test(val))         score++;
    if (/[0-9]/.test(val))         score++;
    if (/[^A-Za-z0-9]/.test(val))  score++;
    segs.forEach((s, i) => s.style.background = i < score ? colors[score - 1] : '#e5e7eb');
    label.textContent = val.length ? labels[score - 1] ?? '' : '';
    label.style.color = val.length ? colors[score - 1] : '#9ca3af';
  }
</script>
</body>
</html>