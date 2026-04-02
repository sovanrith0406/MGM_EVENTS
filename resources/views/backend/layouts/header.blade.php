<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  {{-- <title>AdminLTE 3 | Dashboard</title> --}}
    <title>@yield('title', 'Event')</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset(path: 'assets/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{asset('assets/https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css')}}">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{asset('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{asset('assets/plugins/jqvmap/jqvmap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('assets/dist/css/adminlte.min.css')}}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{asset('assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{asset('assets/plugins/daterangepicker/daterangepicker.css')}}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{asset('assets/plugins/summernote/summernote-bs4.min.css')}}">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button">
          <i class="fas fa-bars"></i>
        </a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ url('/dashboard') }}" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('mailbox.index') }}" class="nav-link">Contact</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

      @php
        $navUnread = \App\Models\MailboxMessage::where('recipient_email', auth()->user()->email)
                      ->where('is_read', false)
                      ->latest('created_at')
                      ->take(5)
                      ->get();
        $navUnreadCount = \App\Models\MailboxMessage::where('recipient_email', auth()->user()->email)
                      ->where('is_read', false)
                      ->count();
      @endphp

      <!-- Messages Dropdown -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#" role="button">
          <i class="far fa-envelope"></i>
          @if($navUnreadCount > 0)
            <span class="badge badge-danger navbar-badge">{{ $navUnreadCount }}</span>
          @endif
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">
            {{ $navUnreadCount }} Unread Message{{ $navUnreadCount !== 1 ? 's' : '' }}
          </span>
          <div class="dropdown-divider"></div>

          @forelse($navUnread as $nm)
          <a href="{{ route('mailbox.show', $nm->message_id) }}" class="dropdown-item">
            <div class="media">
              <div class="d-flex align-items-center justify-content-center mr-3 text-white font-weight-bold"
                   style="width:40px;height:40px;border-radius:50%;background:#007bff;font-size:15px;flex-shrink:0;">
                {{ strtoupper(substr($nm->sender_name ?? 'U', 0, 1)) }}
              </div>
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  {{ $nm->sender_name }}
                  <span class="float-right text-sm text-primary">
                    <i class="fas fa-circle" style="font-size:8px"></i>
                  </span>
                </h3>
                <p class="text-sm">{{ Str::limit($nm->subject, 30) }}</p>
                <p class="text-sm text-muted">
                  <i class="far fa-clock mr-1"></i>
                  {{ $nm->created_at->diffForHumans() }}
                </p>
              </div>
            </div>
          </a>
          <div class="dropdown-divider"></div>
          @empty
          <a href="#" class="dropdown-item text-center text-muted">
            <i class="fas fa-inbox mr-1"></i> No new messages
          </a>
          <div class="dropdown-divider"></div>
          @endforelse

          <a href="{{ route('mailbox.index') }}" class="dropdown-item dropdown-footer">
            See All Messages
          </a>
        </div>
      </li>

      <!-- Fullscreen -->
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>

    </ul>
  </nav>
  <!-- /.navbar -->
  <!-- /.navbar -->
