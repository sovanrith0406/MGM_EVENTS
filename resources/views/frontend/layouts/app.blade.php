<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MGM Event')</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --secondary: #f59e0b;
        }
        body { font-family: 'Segoe UI', sans-serif; }

        /* Navbar */
        .navbar-brand .brand-accent { color: var(--secondary); }
        .nav-link { font-weight: 500; font-size: 14px; }
        .nav-link.active, .nav-link:hover { color: var(--primary) !important; }
        .btn-nav-login {
            background: var(--primary); color: #fff !important;
            border-radius: 8px; padding: 6px 18px !important;
        }
        .btn-nav-login:hover { background: var(--primary-dark); }

        /* Hero */
        .hero-section {
            background: linear-gradient(135deg, #eff6ff 0%, #f0fdf4 100%);
            padding: 90px 0;
        }
        .hero-badge {
            display: inline-block;
            background: #dbeafe; color: var(--primary);
            font-size: 11px; font-weight: 700;
            padding: 4px 14px; border-radius: 20px;
            letter-spacing: 1px; text-transform: uppercase;
        }
        .hero-section h1 { font-size: clamp(32px, 5vw, 56px); font-weight: 800; line-height: 1.15; }
        .hero-section h1 span { color: var(--primary); }

        /* Section label */
        .section-label {
            display: inline-block;
            background: #dbeafe; color: var(--primary);
            font-size: 11px; font-weight: 700;
            padding: 4px 14px; border-radius: 20px;
            letter-spacing: 1px; text-transform: uppercase;
        }

        /* Cards */
        .event-card { border-radius: 16px; border: 1px solid #e2e8f0; transition: all .25s; }
        .event-card:hover { box-shadow: 0 8px 30px rgba(0,0,0,.1); transform: translateY(-3px); }
        .card-img-placeholder {
            height: 180px;
            background: linear-gradient(135deg, #dbeafe, #ede9fe);
            display: flex; align-items: center; justify-content: center;
            font-size: 48px; color: var(--primary);
            border-radius: 16px 16px 0 0;
        }
        .badge-published { background: #dcfce7; color: #16a34a; }
        .badge-draft     { background: #fef9c3; color: #ca8a04; }
        .card-price { font-size: 18px; font-weight: 700; color: var(--primary); }

        /* Stats */
        .stat-box { border-radius: 16px; border: 1px solid #e2e8f0; padding: 32px 20px; text-align: center; }
        .stat-num  { font-size: 42px; font-weight: 800; color: var(--primary); }
        .stat-label { font-size: 14px; color: #64748b; }

        /* Speaker card */
        .speaker-card { border-radius: 16px; border: 1px solid #e2e8f0; transition: all .25s; }
        .speaker-card:hover { box-shadow: 0 8px 30px rgba(0,0,0,.1); transform: translateY(-3px); }
        .speaker-avatar {
            width: 90px; height: 90px; border-radius: 50%;
            object-fit: cover; border: 3px solid var(--primary);
        }
        .speaker-avatar-placeholder {
            width: 90px; height: 90px; border-radius: 50%;
            background: linear-gradient(135deg, #dbeafe, #ede9fe);
            display: flex; align-items: center; justify-content: center;
            font-size: 32px; color: var(--primary);
            border: 3px solid var(--primary);
            margin: 0 auto;
        }

        /* Sponsor */
        .sponsor-card { border-radius: 12px; border: 1px solid #e2e8f0; transition: all .2s; }
        .sponsor-card:hover { border-color: var(--primary); box-shadow: 0 4px 15px rgba(37,99,235,.08); }
        .sponsor-logo { width: 100px; height: 60px; object-fit: contain; }

        /* Page header */
        .page-header {
            background: linear-gradient(135deg, #eff6ff, #f0fdf4);
            padding: 52px 24px; text-align: center;
            border-bottom: 1px solid #e2e8f0;
        }

        /* CTA */
        .cta-section { background: linear-gradient(135deg, #2563eb, #1d4ed8); }

        /* Footer */
        footer { background: #1e293b; color: #94a3b8; }
        footer .footer-brand { font-size: 22px; font-weight: 700; color: #fff; }
        footer .footer-brand span { color: var(--secondary); }
        footer h5 { color: #fff; font-size: 14px; font-weight: 600; }
        footer a { color: #94a3b8; text-decoration: none; font-size: 14px; }
        footer a:hover { color: #fff; }
        footer .footer-bottom { border-top: 1px solid #334155; font-size: 13px; }

        /* Schedule */
        .schedule-time {
            min-width: 90px; background: #eff6ff;
            border-radius: 10px; font-size: 13px;
            font-weight: 600; color: var(--primary);
        }
        .tag { font-size: 11px; padding: 3px 10px; border-radius: 20px; font-weight: 600; text-transform: uppercase; }
        .tag-talk     { background: #dbeafe; color: var(--primary); }
        .tag-workshop { background: #fef9c3; color: #b45309; }
        .tag-keynote  { background: #fce7f3; color: #be185d; }
        .tag-panel    { background: #dcfce7; color: #15803d; }
        .tag-break    { background: #f1f5f9; color: #64748b; }

        /* Sponsor tiers */
        .tier-platinum { background: #e0e7ff; color: #3730a3; }
        .tier-gold     { background: #fef9c3; color: #92400e; }
        .tier-silver   { background: #f1f5f9; color: #64748b; }
        .tier-bronze   { background: #fef3c7; color: #92400e; }
        .tier-partner  { background: #f0fdf4; color: #166534; }
    </style>
    @stack('styles')
</head>
<body class="bg-white">

{{-- Navbar --}}
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary fs-5 d-flex align-items-center gap-2" href="{{ route('frontend.home') }}">
            <i class="fas fa-calendar-star"></i> MGM <span class="brand-accent">EVENT</span>
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-1">
                <li class="nav-item"><a class="nav-link @yield('nav_home')"     href="{{ route('frontend.home') }}">Home</a></li>
                <li class="nav-item"><a class="nav-link @yield('nav_events')"   href="{{ route('frontend.events') }}">Events</a></li>
                <li class="nav-item"><a class="nav-link @yield('nav_speakers')" href="{{ route('frontend.speakers') }}">Speakers</a></li>
                <li class="nav-item"><a class="nav-link @yield('nav_schedule')" href="{{ route('frontend.schedule') }}">Schedule</a></li>
                <li class="nav-item"><a class="nav-link @yield('nav_sponsors')" href="{{ route('frontend.sponsors') }}">Sponsors</a></li>
                <li class="nav-item"><a class="nav-link @yield('nav_contact')"  href="{{ route('frontend.contact') }}">Contact</a></li>
                <li class="nav-item ms-lg-2">
                    <a class="nav-link btn-nav-login" href="{{ route('login') }}">
                        <i class="fas fa-sign-in-alt me-1"></i> Login
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

@yield('content')

{{-- Footer --}}
<footer class="pt-5 pb-3">
    <div class="container">
        <div class="row g-4 mb-4">
            <div class="col-lg-4">
                <div class="footer-brand mb-2">
                    <i class="fas fa-calendar-star"></i> MGM <span>EVENT</span>
                </div>
                <p style="font-size:14px; line-height:1.7;">
                    Cambodia's premier event management platform. Connecting speakers, sponsors, and attendees across the kingdom.
                </p>
            </div>
            <div class="col-6 col-lg-2">
                <h5 class="mb-3">Quick Links</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="{{ route('frontend.home') }}">Home</a></li>
                    <li class="mb-2"><a href="{{ route('frontend.events') }}">Events</a></li>
                    <li class="mb-2"><a href="{{ route('frontend.speakers') }}">Speakers</a></li>
                    <li class="mb-2"><a href="{{ route('frontend.schedule') }}">Schedule</a></li>
                </ul>
            </div>
            <div class="col-6 col-lg-2">
                <h5 class="mb-3">More</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="{{ route('frontend.sponsors') }}">Sponsors</a></li>
                    <li class="mb-2"><a href="{{ route('frontend.contact') }}">Contact</a></li>
                    <li class="mb-2"><a href="{{ route('login') }}">Login</a></li>
                </ul>
            </div>
            <div class="col-lg-4">
                <h5 class="mb-3">Contact</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><i class="fas fa-map-marker-alt me-2 text-primary"></i> Phnom Penh, Cambodia</li>
                    <li class="mb-2"><i class="fas fa-envelope me-2 text-primary"></i> <a href="mailto:info@mgmevent.com">info@mgmevent.com</a></li>
                    <li class="mb-2"><i class="fas fa-phone me-2 text-primary"></i> <a href="tel:+85510336620">(+855) 10 33 66 20</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom d-flex justify-content-between flex-wrap gap-2 pt-3">
            <span>© {{ date('Y') }} MGM Event. All rights reserved.</span>
            <span>Built with ❤️ in Cambodia</span>
        </div>
    </div>
</footer>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>