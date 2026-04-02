<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Reset Password | MGM Event</title>
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
    .input-group { border: 1px solid #dce1e7; border-radius: 8px; overflow: hidden; transition: all 0.3s ease; background-color: #f8f9fa; }
    .input-group:focus-within { border-color: #007bff; background-color: #ffffff; box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.15); }
    .input-group.is-invalid { border-color: #dc3545; }
    .input-group .form-control { border: none; background: transparent; padding: 12px 15px; box-shadow: none !important; }
    .input-group-text { border: none; background: transparent; color: #adb5bd; }
    .btn-success { border: none; border-radius: 8px; padding: 10px; font-weight: 600; font-size: 1.05rem; transition: all 0.2s ease; }
    .btn-success:hover { transform: translateY(-1.5px); box-shadow: 0 4px 15px rgba(40,167,69,0.3); }
    .invalid-feedback { display: block; font-size: 0.85rem; margin-top: 4px; color: #dc3545; }
    .alert ul { margin: 0; padding-left: 18px; }
  </style>
</head>
<body class="hold-transition login-page">
<div class="login-box">

  <div class="login-logo">
    <a href="#"><b>Management</b> EVENT</a>
  </div>

  <div class="card">
    <div class="card-body">
      <p class="login-box-msg">Set a new password for your account.</p>

      {{-- Session-level errors (e.g. expired session) --}}
      @if (session('success'))
        <div class="alert alert-success" style="border-radius:8px;">
          {{ session('success') }}
        </div>
      @endif

      {{-- All validation errors --}}
      @if ($errors->any())
        <div class="alert alert-danger" style="border-radius:8px;">
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form action="{{ route('password.reset.submit') }}" method="POST">
        @csrf

        {{-- New Password --}}
        <div class="mb-3">
          <div class="input-group {{ $errors->has('password') ? 'is-invalid' : '' }}">
            <input
              type="password"
              name="password"
              id="password"
              class="form-control"
              placeholder="New password"
              required
              autocomplete="new-password"
            >
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock" id="togglePasswordIcon" style="cursor:pointer;" onclick="toggleVisibility('password','togglePasswordIcon')"></span>
              </div>
            </div>
          </div>
          @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        {{-- Confirm Password --}}
        <div class="mb-4">
          <div class="input-group {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}">
            <input
              type="password"
              name="password_confirmation"
              id="password_confirmation"
              class="form-control"
              placeholder="Confirm new password"
              required
              autocomplete="new-password"
            >
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock" id="toggleConfirmIcon" style="cursor:pointer;" onclick="toggleVisibility('password_confirmation','toggleConfirmIcon')"></span>
              </div>
            </div>
          </div>
          @error('password_confirmation')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <button type="submit" class="btn btn-success btn-block">Reset Password</button>

      </form>
    </div>
  </div>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
<script>
  function toggleVisibility(fieldId, iconId) {
    const field = document.getElementById(fieldId);
    const icon  = document.getElementById(iconId);
    if (field.type === 'password') {
      field.type = 'text';
      icon.classList.replace('fa-lock', 'fa-unlock');
    } else {
      field.type = 'password';
      icon.classList.replace('fa-unlock', 'fa-lock');
    }
  }
</script>
</body>
</html>