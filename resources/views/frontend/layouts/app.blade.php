<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MGM Event')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --bg-dark: #0a0710;
            --bg-card: #151221;
            --primary-neon: #ff007f; /* Neon Pink */
            --primary-hover: #e60073;
            --text-main: #ffffff;
            --text-muted: #a0aec0;
        }

        body { 
            font-family: 'Outfit', sans-serif; 
            background-color: var(--bg-dark);
            color: var(--text-main);
        }

        /* Typography */
        h1, h2, h3, h4, h5, h6 { font-weight: 800; text-transform: uppercase; letter-spacing: 1px; }
        .text-neon { color: var(--primary-neon) !important; text-shadow: 0 0 15px rgba(255, 0, 127, 0.4); }
        .text-muted-custom { color: var(--text-muted); }

        /* Buttons */
        .btn-neon {
            background-color: var(--primary-neon);
            color: #fff;
            border-radius: 30px;
            padding: 10px 24px;
            font-weight: 600;
            border: none;
            box-shadow: 0 4px 15px rgba(255, 0, 127, 0.3);
            transition: all 0.3s ease;
        }
        .btn-neon:hover {
            background-color: var(--primary-hover);
            color: #fff;
            box-shadow: 0 6px 20px rgba(255, 0, 127, 0.5);
            transform: translateY(-2px);
        }
        .btn-outline-neon {
            background-color: transparent;
            color: var(--text-main);
            border: 2px solid var(--primary-neon);
            border-radius: 30px;
            padding: 8px 24px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-outline-neon:hover {
            background-color: var(--primary-neon);
            color: #fff;
            box-shadow: 0 4px 15px rgba(255, 0, 127, 0.3);
        }

        /* Navbar */
        .navbar {
            background-color: rgba(10, 7, 16, 0.9) !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255,255,255,0.05) !important;
        }
        .navbar-brand { color: #fff !important; font-weight: 800; letter-spacing: 1px; }
        .navbar-brand span { color: var(--primary-neon); }
        .nav-link { color: var(--text-main) !important; font-weight: 500; font-size: 15px; text-transform: uppercase; margin: 0 10px; transition: color 0.3s; }
        .nav-link:hover, .nav-link.active { color: var(--primary-neon) !important; }
        .navbar-toggler { background-color: rgba(255,255,255,0.1); border: none; }
        .navbar-toggler-icon { filter: invert(1); }

        /* Footer */
        footer { 
            background: #050308; 
            border-top: 1px solid rgba(255,255,255,0.05); 
            color: var(--text-muted); 
        }
        footer .footer-brand { font-size: 24px; font-weight: 800; color: #fff; text-transform: uppercase; }
        footer .footer-brand span { color: var(--primary-neon); }
        footer h5 { color: #fff; font-size: 16px; font-weight: 800; margin-bottom: 20px; }
        footer a { color: var(--text-muted); text-decoration: none; font-size: 15px; transition: all 0.3s; }
        footer a:hover { color: var(--primary-neon); padding-left: 5px; }
        footer .footer-bottom { border-top: 1px solid rgba(255,255,255,0.05); font-size: 14px; padding-top: 20px; margin-top: 40px; }
    </style>
    @stack('styles')
</head>
<body>

{{-- Navbar --}}
<nav class="navbar navbar-expand-lg fixed-top py-3">
    <div class="container">
        <a class="navbar-brand fs-4 d-flex align-items-center gap-2" href="{{ route('frontend.home') }}">
            <i class="fas text-neon"></i> MGM <span>EVENT</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item"><a class="nav-link @yield('nav_home')" href="{{ route('frontend.home') }}">Home</a></li>
                <li class="nav-item"><a class="nav-link @yield('nav_events')" href="{{ route('frontend.events') }}">Events</a></li>
                <li class="nav-item"><a class="nav-link @yield('nav_speakers')" href="{{ route('frontend.speakers') }}">Speakers</a></li>
                <li class="nav-item"><a class="nav-link @yield('nav_sponsors')" href="{{ route('frontend.sponsors') }}">Sponsors</a></li>
                <li class="nav-item"><a class="nav-link @yield('nav_contact')" href="{{ route('frontend.contact') }}">Contact</a></li>
                <li class="nav-item ms-lg-4 mt-3 mt-lg-0">
                    <a class="btn-neon text-decoration-none d-inline-block" href="{{ route('login') }}">
                        <i class="fas fa-ticket-alt me-2"></i> Get Tickets
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main style="padding-top: 80px;">
    @yield('content')
</main>

{{-- Footer --}}
<footer class="pt-5 pb-4 mt-5">
    <div class="container">
        <div class="row g-5 mb-4">
            <div class="col-lg-4">
                <div class="footer-brand mb-3">
                    <i class="fas fa-bullseye text-neon"></i> MGM <span>EVENT</span>
                </div>
                <p class="text-muted-custom pe-lg-4" style="line-height: 1.8;">
                    Elevating experiences. Cambodia's premier event management platform connecting industry leaders, innovators, and professionals.
                </p>
                <div class="d-flex gap-3 mt-4">
                    <a href="#" class="text-white fs-5"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="text-white fs-5"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-white fs-5"><i class="fab fa-linkedin"></i></a>
                    <a href="#" class="text-white fs-5"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
            <div class="col-6 col-lg-2 offset-lg-1">
                <h5>Explore</h5>
                <ul class="list-unstyled">
                    <li class="mb-3"><a href="{{ route('frontend.home') }}">Home</a></li>
                    <li class="mb-3"><a href="{{ route('frontend.events') }}">All Events</a></li>
                    <li class="mb-3"><a href="{{ route('frontend.speakers') }}">Speakers</a></li>
                    <li class="mb-3"><a href="{{ route('frontend.sponsors') }}">Sponsors</a></li>
                </ul>
            </div>
            <div class="col-6 col-lg-2">
                <h5>Support</h5>
                <ul class="list-unstyled">
                    <li class="mb-3"><a href="#">FAQ</a></li>
                    <li class="mb-3"><a href="#">Privacy Policy</a></li>
                    <li class="mb-3"><a href="#">Terms of Service</a></li>
                    <li class="mb-3"><a href="{{ route('frontend.contact') }}">Contact Us</a></li>
                </ul>
            </div>
            <div class="col-lg-3">
                <h5>Contact</h5>
                <ul class="list-unstyled text-muted-custom">
                    <li class="mb-3"><i class="fas fa-map-marker-alt me-2 text-neon"></i> Phnom Penh, Cambodia</li>
                    <li class="mb-3"><i class="fas fa-envelope me-2 text-neon"></i> info@mgmevent.com</li>
                    <li class="mb-3"><i class="fas fa-phone me-2 text-neon"></i> (+855) 10 33 66 20</li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom d-flex justify-content-between flex-wrap gap-2 text-muted-custom">
            <span>© {{ date('Y') }} MGM Event Platform. All rights reserved.</span>
            <span>Made with <i class="fas fa-heart text-neon mx-1"></i> in Cambodia</span>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>