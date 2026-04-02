<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Supplier Registration | MGM Event</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,600,700&display=fallback">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/icheck-bootstrap/3.0.1/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

  <style>
    body.register-page {
      background: #f4f7f6;
      background-image: linear-gradient(120deg, #fdfbfb 0%, #ebedee 100%);
      min-height: 100vh;
      font-family: 'Source Sans Pro', sans-serif;
      padding: 2rem 0;
    }
    
    .register-box {
      width: 450px;
    }
    
    .card {
      border: none;
      border-radius: 16px;
      box-shadow: 0 10px 40px rgba(0,0,0,0.08);
      background-color: #ffffff;
    }
    
    .card-body {
      padding: 40px 35px;
    }

    .register-logo {
      margin-bottom: 25px;
    }
    .register-logo a {
      font-weight: 700;
      color: #2c3e50;
      font-size: 1.8rem;
      letter-spacing: -0.5px;
    }
    .register-logo a b {
      color: #007bff;
    }

    .login-box-msg {
      padding: 0 0 25px 0;
      font-size: 1.05rem;
      color: #6c757d;
      font-weight: 400;
    }

    .input-group, .custom-file {
      border: 1px solid #dce1e7;
      border-radius: 8px;
      overflow: hidden;
      transition: all 0.3s ease;
      background-color: #f8f9fa;
      margin-bottom: 1.25rem !important;
    }
    
    .input-group:focus-within, .custom-file:focus-within {
      border-color: #007bff;
      background-color: #ffffff;
      box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.15);
    }
    
    /* 1. Styling for standard text inputs */
    .input-group .form-control {
      border: none;
      background: transparent;
      padding: 18px 15px;
      height: auto;
      box-shadow: none !important;
      color: #495057;
    }

    /* 2. Specific fix for the File Upload layout */
    .custom-file {
      height: 60px;
    }
    
    .custom-file-label {
      border: none;
      background: transparent;
      height: 60px;
      padding: 18px 15px;
      line-height: 24px;
      color: #495057;
      box-shadow: none !important;
    }
    
    .custom-file-label::after {
      height: 60px;
      padding: 18px 15px;
      line-height: 24px;
      background: #f8f9fa;
      border-left: 1px solid #dce1e7;
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
    .text-center:hover {
      color: #0056b3;
    }
    
    label {
      font-weight: 400;
      color: #495057;
    }

    /* Styling for the read-only role indicator */
    .role-indicator {
      background-color: #f1f3f5 !important;
      color: #6c757d !important;
      cursor: not-allowed;
      font-weight: 600;
    }
  </style>
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <a href="#"><b>Management</b> EVENT</a>
  </div>

  <div class="card">
    <div class="card-body register-card-body">
      <p class="login-box-msg">Register a new membership</p>

      {{-- Show validation errors --}}
      @if ($errors->any())
        <div class="alert alert-danger" style="border-radius: 8px;">
          <ul class="mb-0 pl-3">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form action="{{ route('register') }}" method="post" enctype="multipart/form-data">
        @csrf
        
        {{-- Full Name --}}
        <div class="input-group">
          <input type="text" class="form-control" name="full_name" value="{{ old('full_name') }}" placeholder="Full name" required autofocus>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>

        {{-- Email --}}
        <div class="input-group">
          <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>

        {{-- Visual Role Confirmation (Read-Only) --}}
        <div class="input-group" title="This form is for Supplier registration only">
          <input type="text" class="form-control role-indicator" value="Account Type: Event Supplier" readonly tabindex="-1">
          <div class="input-group-append">
            <div class="input-group-text role-indicator">
              <span class="fas fa-briefcase"></span>
            </div>
          </div>
        </div>

        {{-- Password --}}
        <div class="input-group">
          <input type="password" class="form-control" name="password" placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>

        {{-- Confirm Password --}}
        <div class="input-group">
          <input type="password" class="form-control" name="password_confirmation" placeholder="Retype password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>

        {{-- Avatar Upload --}}
        <div class="form-group mb-4">
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="avatar" name="avatar" accept="image/*">
                <label class="custom-file-label" for="avatar">Choose Avatar Image (Optional)</label>
            </div>
        </div>

        {{-- Terms & Submit (FIXED CHECKBOX) --}}
        <div class="row align-items-center mb-4">
          <div class="col-7">
            <div class="icheck-primary">
              <input type="checkbox" id="agreeTerms" name="terms" required>
              <label for="agreeTerms">
               I agree to the <a href="#">terms</a>
              </label>
            </div>
          </div>
          <div class="col-5">
            <button type="submit" class="btn btn-primary btn-block">Register</button>
          </div>
        </div>
      </form>

      <div class="text-center mt-3 pt-3" style="border-top: 1px solid #eee;">
        <a href="{{ route('login') }}" class="text-center">I already have a membership</a>
      </div>
    </div>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

<script>
$(function () {
  // Initialize the custom file input to show the selected filename
  bsCustomFileInput.init();
});
</script>
</body>
</html>