@extends('frontend.layouts.app')
@section('title', 'MGM Event — Home')
@section('nav_home', 'active')

@section('content')

<style>
    .hero-section {
        position: relative;
        padding: 80px 0 60px;
        background: radial-gradient(circle at 70% 30%, rgba(255, 0, 127, 0.1) 0%, transparent 50%);
    }
    .hero-title {
        font-size: clamp(40px, 6vw, 70px);
        line-height: 1.1;
        margin-bottom: 20px;
    }

    /* Stats Banner */
    .stats-banner {
        background: linear-gradient(90deg, #151221 0%, #1a162b 50%, #151221 100%);
        border-top: 1px solid rgba(255,255,255,0.05);
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }
    .stat-item { text-align: center; padding: 30px 15px; }
    .stat-num { font-size: 40px; font-weight: 800; color: #fff; margin-bottom: 5px; }
    .stat-num span { color: var(--primary-neon); }
    .stat-label { font-size: 14px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 2px; }

    /* Event Cards */
    .event-card {
        background: var(--bg-card);
        border: 1px solid rgba(255,255,255,0.05);
        border-radius: 16px;
        transition: all 0.4s ease;
        overflow: hidden;
    }
    .event-card:hover {
        border-color: rgba(255, 0, 127, 0.4);
        box-shadow: 0 10px 30px rgba(0,0,0,0.5), 0 0 20px rgba(255,0,127,0.1);
        transform: translateY(-5px);
    }

    /* Image container */
    .event-card-img {
        height: 200px;
        background: #0a0710;
        position: relative;
        overflow: hidden;
    }
    /* Actual uploaded image */
    .event-card-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.4s ease;
    }
    .event-card:hover .event-card-img img {
        transform: scale(1.05);
    }
    /* Fallback placeholder */
    .event-card-img .img-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 50px;
        color: rgba(255,255,255,0.1);
    }
    /* Gradient overlay */
    .event-card-img::after {
        content: '';
        position: absolute;
        bottom: 0; left: 0; right: 0;
        height: 50%;
        background: linear-gradient(to top, var(--bg-card), transparent);
        pointer-events: none;
    }
    /* Status badge always above overlay */
    .event-card-img .badge-status {
        position: absolute;
        top: 12px; right: 12px;
        z-index: 2;
        background: rgba(255,0,127,0.2);
        color: var(--primary-neon);
        border: 1px solid var(--primary-neon);
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
    }

    /* Speakers */
    .speaker-avatar-wrapper {
        width: 140px; height: 140px;
        margin: 0 auto 20px;
        border-radius: 50%;
        padding: 4px;
        background: linear-gradient(45deg, var(--primary-neon), transparent);
    }
    .speaker-avatar {
        width: 100%; height: 100%;
        border-radius: 50%;
        object-fit: cover;
        background-color: var(--bg-card);
        border: 4px solid var(--bg-card);
    }

    /* Sponsors */
    .sponsor-wrapper {
        filter: grayscale(100%) opacity(0.5);
        transition: all 0.3s;
    }
    .sponsor-wrapper:hover { filter: grayscale(0%) opacity(1); }

    /* Section Headers */
    .section-subtitle {
        color: var(--primary-neon);
        font-size: 14px;
        letter-spacing: 3px;
        text-transform: uppercase;
        margin-bottom: 10px;
        font-weight: 600;
    }

    /* CTA */
    .cta-section {
        background: linear-gradient(rgba(10, 7, 16, 0.8), rgba(10, 7, 16, 0.9)),
                    url('https://images.unsplash.com/photo-1492684223066-81342ee5ff30?q=80&w=2070&auto=format&fit=crop') center/cover;
        border-top: 1px solid rgba(255, 0, 127, 0.3);
        border-bottom: 1px solid rgba(255, 0, 127, 0.3);
    }
</style>

{{-- Hero Section --}}
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center min-vh-75">
            <div class="col-lg-6 z-1 position-relative">
                <div class="d-inline-block px-3 py-1 rounded-pill mb-4"
                     style="background: rgba(255,0,127,0.1); border: 1px solid rgba(255,0,127,0.3); color: var(--primary-neon); font-size: 12px; letter-spacing: 2px; text-transform: uppercase;">
                    🇰🇭 Cambodia's #1 Event Platform
                </div>
                <h1 class="hero-title text-white">
                    Discover & Join <br>
                    <span class="text-neon">Amazing Events</span><br>
                    Across Cambodia
                </h1>
                <p class="text-muted-custom fs-5 mb-5" style="max-width: 500px; line-height: 1.6;">
                    Connect with top speakers, industry sponsors, and professionals at the most impactful conferences and workshops in the region.
                </p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="{{ route('frontend.events') }}" class="btn-neon btn-lg text-decoration-none">
                        Browse Events <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                    <a href="{{ route('frontend.speakers') }}" class="btn-outline-neon btn-lg text-decoration-none">
                        Meet Speakers
                    </a>
                </div>
            </div>
            <div class="col-lg-6 d-none d-lg-block text-center position-relative">
                <div style="width:450px; height:450px; border-radius:50%; background: radial-gradient(circle, rgba(255,0,127,0.2) 0%, transparent 60%); margin:0 auto; position:relative;">
                    <img src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?q=80&w=800&auto=format&fit=crop"
                         alt="Event Highlight"
                         style="width:100%; height:100%; object-fit:cover; border-radius:50%; clip-path:polygon(0 0,100% 0,100% 90%,0 100%); border:2px solid rgba(255,255,255,0.1); box-shadow:0 0 40px rgba(255,0,127,0.3);">
                    <div class="position-absolute" style="bottom:20px; left:-20px; background:var(--bg-card); padding:15px 25px; border-radius:12px; border:1px solid rgba(255,0,127,0.3);">
                        <div class="text-white fw-bold fs-4">{{ $totalEvents }}+</div>
                        <div class="text-neon" style="font-size:12px; letter-spacing:1px;">ACTIVE EVENTS</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Stats Banner --}}
<section class="stats-banner mt-5">
    <div class="container">
        <div class="row">
            <div class="col-6 col-md-3 stat-item border-end border-dark border-opacity-50">
                <div class="stat-num">{{ $totalEvents }}<span>.</span></div>
                <div class="stat-label">Total Events</div>
            </div>
            <div class="col-6 col-md-3 stat-item border-end border-dark border-opacity-50">
                <div class="stat-num">{{ $totalSpeakers }}<span>.</span></div>
                <div class="stat-label">Speakers</div>
            </div>
            <div class="col-6 col-md-3 stat-item border-end border-dark border-opacity-50">
                <div class="stat-num">{{ $totalSponsors }}<span>.</span></div>
                <div class="stat-label">Sponsors</div>
            </div>
            <div class="col-6 col-md-3 stat-item">
                <div class="stat-num">{{ $totalBookings }}<span>.</span></div>
                <div class="stat-label">Tickets Sold</div>
            </div>
        </div>
    </div>
</section>

{{-- Featured Sponsors --}}
<section class="py-5">
    <div class="container text-center py-5">
        <div class="section-subtitle">Our Partners</div>
        <h2 class="text-white mb-5">Featured Organizers</h2>
        <div class="row g-4 justify-content-center align-items-center mt-3">
            @foreach($sponsors as $sponsor)
            <div class="col-6 col-md-4 col-lg-2">
                <div class="sponsor-wrapper text-center">
                    @if($sponsor->logo_url)
                        <img src="{{ asset($sponsor->logo_url) }}"
                             class="img-fluid px-3"
                             alt="{{ $sponsor->name }}"
                             style="max-height:50px;"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                        <h4 class="text-white mb-0" style="display:none; font-family:sans-serif; font-weight:800;">
                            {{ $sponsor->name }}
                        </h4>
                    @else
                        <h4 class="text-white mb-0" style="font-family:sans-serif; font-weight:800;">
                            {{ $sponsor->name }}
                        </h4>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Upcoming Events --}}
<section class="py-5" style="background-color: #0d0a14;">
    <div class="container py-5">
        <div class="text-center mb-5">
            <div class="section-subtitle">Don't Miss Out</div>
            <h2 class="text-white">Upcoming Events</h2>
        </div>

        <div class="row g-4 mt-2">
            @forelse($upcomingEvents as $event)
            <div class="col-md-6 col-lg-4">
                <div class="event-card h-100 d-flex flex-column">

                    {{-- ── Image / Placeholder ── --}}
                    <div class="event-card-img">
                        @if($event->image)
                            <img src="{{ asset('storage/' . $event->image) }}"
                                 alt="{{ $event->event_name }}">
                        @else
                            <div class="img-placeholder">
                                <i class="fas fa-microphone-alt"></i>
                            </div>
                        @endif
                        <span class="badge-status">{{ ucfirst($event->status) }}</span>
                    </div>

                    <div class="card-body p-4 d-flex flex-column">
                        <h4 class="text-white mb-3">{{ $event->event_name }}</h4>
                        @if($event->description)
                            <p class="text-muted-custom small mb-4 flex-grow-1">
                                {{ Str::limit($event->description, 90) }}
                            </p>
                        @endif

                        <div class="mb-4 text-muted-custom small">
                            <div class="mb-2">
                                <i class="fas fa-calendar-alt text-neon me-2" style="width:15px;"></i>
                                {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}
                            </div>
                            <div>
                                <i class="fas fa-globe text-neon me-2" style="width:15px;"></i>
                                {{ $event->timezone }}
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center border-top border-dark pt-4 mt-auto">
                            <div class="fs-4 fw-bold text-white">
                                {{ $event->currency }} {{ number_format($event->price, 2) }}
                            </div>
                            <a href="{{ route('frontend.events.show', $event->event_id) }}"
                               class="btn-neon text-decoration-none" style="padding:8px 20px;">
                                View <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5 text-muted-custom">
                <i class="fas fa-calendar-times mb-3 d-block" style="font-size:48px; opacity:0.2;"></i>
                <p>No upcoming events at this time.</p>
            </div>
            @endforelse
        </div>

        @if($upcomingEvents->count() > 0)
        <div class="text-center mt-5 pt-3">
            <a href="{{ route('frontend.events') }}" class="btn-outline-neon text-decoration-none px-5 py-3">
                View All Schedule
            </a>
        </div>
        @endif
    </div>
</section>

{{-- CTA Section --}}
<section class="cta-section py-5 text-center">
    <div class="container py-5 my-3">
        <h2 class="text-white mb-3" style="font-size: clamp(30px, 5vw, 50px);">Join The Invitation</h2>
        <p class="text-light mb-5 mx-auto" style="max-width:600px; font-size:18px;">
            Secure your spot today and become part of the fastest-growing community of innovators and professionals.
        </p>
        <a href="{{ route('frontend.events') }}" class="btn-neon btn-lg text-decoration-none px-5 py-3 fs-5">
            Get Your Ticket Now
        </a>
    </div>
</section>

@endsection