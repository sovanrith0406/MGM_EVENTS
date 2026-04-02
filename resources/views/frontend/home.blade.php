@extends('frontend.layouts.app')
@section('title', 'MGM Event — Home')
@section('nav_home', 'active')

@section('content')

{{-- Hero --}}
<section class="hero-section text-center">
    <div class="container">
        <div class="hero-badge mb-3">🇰🇭 Cambodia's #1 Event Platform</div>
        <h1 class="fw-bold text-dark mb-3">
            Discover & Join <span>Amazing Events</span><br>Across Cambodia
        </h1>
        <p class="text-secondary fs-5 mx-auto mb-4" style="max-width:580px; line-height:1.7;">
            Connect with top speakers, industry sponsors, and professionals at the most impactful events in the region.
        </p>
        <div class="d-flex gap-3 justify-content-center flex-wrap">
            <a href="{{ route('frontend.events') }}" class="btn btn-primary btn-lg px-4 rounded-3">
                <i class="fas fa-calendar-alt me-2"></i> Browse Events
            </a>
            <a href="{{ route('frontend.speakers') }}" class="btn btn-outline-primary btn-lg px-4 rounded-3">
                <i class="fas fa-microphone me-2"></i> Meet Speakers
            </a>
        </div>
    </div>
</section>

{{-- Stats --}}
<section class="py-5 bg-white">
    <div class="container">
        <div class="row g-4">
            <div class="col-6 col-md-3">
                <div class="stat-box bg-white">
                    <div class="stat-num">{{ $totalEvents }}</div>
                    <div class="stat-label mt-1">
                        <i class="fas fa-calendar-alt text-primary me-1"></i> Total Events
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-box bg-white">
                    <div class="stat-num">{{ $totalSpeakers }}</div>
                    <div class="stat-label mt-1">
                        <i class="fas fa-microphone text-primary me-1"></i> Speakers
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-box bg-white">
                    <div class="stat-num">{{ $totalSponsors }}</div>
                    <div class="stat-label mt-1">
                        <i class="fas fa-handshake text-primary me-1"></i> Sponsors
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-box bg-white">
                    <div class="stat-num">{{ $totalBookings }}</div>
                    <div class="stat-label mt-1">
                        <i class="fas fa-ticket-alt text-primary me-1"></i> Bookings
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Upcoming Events --}}
<section class="py-5" style="background:#f8fafc;">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section-label mb-2">📅 Don't Miss Out</div>
            <h2 class="fw-bold">Upcoming Events</h2>
            <p class="text-secondary">Join our upcoming events and be part of something extraordinary</p>
        </div>
        <div class="row g-4">
            @forelse($upcomingEvents as $event)
            <div class="col-md-6 col-lg-4">
                <div class="card event-card h-100 border-0 shadow-sm">
                    <div class="card-img-placeholder">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div class="card-body p-4">
                        <span class="badge badge-{{ $event->status }} px-3 py-2 rounded-pill mb-2 d-inline-block" style="font-size:11px;">
                            {{ ucfirst($event->status) }}
                        </span>
                        <h5 class="fw-bold mb-2">{{ $event->event_name }}</h5>
                        @if($event->description)
                            <p class="text-secondary small mb-3">{{ Str::limit($event->description, 80) }}</p>
                        @endif
                        <div class="d-flex gap-3 flex-wrap mb-3">
                            <span class="small text-secondary">
                                <i class="fas fa-calendar text-primary me-1"></i>
                                {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}
                            </span>
                            <span class="small text-secondary">
                                <i class="fas fa-clock text-primary me-1"></i>
                                {{ $event->timezone }}
                            </span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="card-price">{{ $event->currency }} {{ number_format($event->price, 2) }}</div>
                            <a href="{{ route('frontend.events.show', $event->event_id) }}" class="btn btn-primary btn-sm px-3 rounded-3">
                                View <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5 text-secondary">
                <i class="fas fa-calendar-times mb-3 d-block" style="font-size:48px; color:#cbd5e1;"></i>
                No upcoming events at this time.
            </div>
            @endforelse
        </div>
        @if($upcomingEvents->count() > 0)
        <div class="text-center mt-5">
            <a href="{{ route('frontend.events') }}" class="btn btn-outline-primary px-4 rounded-3">
                View All Events <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>
        @endif
    </div>
</section>

{{-- Featured Speakers --}}
<section class="py-5 bg-white">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section-label mb-2">🎤 Industry Leaders</div>
            <h2 class="fw-bold">Featured Speakers</h2>
            <p class="text-secondary">Learn from the brightest minds in technology and business</p>
        </div>
        <div class="row g-4">
            @foreach($featuredSpeakers as $speaker)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="speaker-card card border-0 shadow-sm h-100 text-center p-4">
                    @if($speaker->photo_url)
                        <img src="{{ asset($speaker->photo_url) }}"
                             class="speaker-avatar mx-auto mb-3"
                             alt="{{ $speaker->full_name }}"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="speaker-avatar-placeholder mb-3" style="display:none;">
                            <i class="fas fa-user"></i>
                        </div>
                    @else
                        <div class="speaker-avatar-placeholder mb-3">
                            <i class="fas fa-user"></i>
                        </div>
                    @endif
                    <h6 class="fw-bold mb-1">{{ $speaker->full_name }}</h6>
                    <div class="text-primary small fw-500 mb-1">{{ $speaker->title ?? '—' }}</div>
                    <div class="text-secondary small">{{ $speaker->company ?? '' }}</div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-5">
            <a href="{{ route('frontend.speakers') }}" class="btn btn-outline-primary px-4 rounded-3">
                All Speakers <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
</section>

{{-- Sponsors --}}
<section class="py-5" style="background:#f8fafc;">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section-label mb-2">🤝 Our Partners</div>
            <h2 class="fw-bold">Event Sponsors</h2>
            <p class="text-secondary">Thank you to our amazing sponsors who make these events possible</p>
        </div>
        <div class="row g-4 justify-content-center">
            @foreach($sponsors as $sponsor)
            <div class="col-6 col-md-4 col-lg-2">
                <div class="sponsor-card card border-0 shadow-sm p-4 text-center h-100 d-flex flex-column align-items-center justify-content-center">
                    @if($sponsor->logo_url)
                        <img src="{{ asset($sponsor->logo_url) }}"
                             class="sponsor-logo mb-3"
                             alt="{{ $sponsor->name }}"
                             onerror="this.replaceWith(Object.assign(document.createElement('div'), {textContent:'🏢', style:'font-size:36px;color:#2563eb;margin-bottom:12px'}))">
                    @else
                        <div class="mb-3" style="font-size:36px; color:#2563eb;">🏢</div>
                    @endif
                    <h6 class="fw-semibold mb-0">{{ $sponsor->name }}</h6>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="cta-section py-5 text-center text-white">
    <div class="container">
        <h2 class="fw-bold mb-2" style="font-size:clamp(24px,4vw,36px);">Ready to Join Our Next Event?</h2>
        <p class="mb-4" style="color:#bfdbfe; font-size:16px;">
            Register today and be part of Cambodia's growing tech community.
        </p>
        <a href="{{ route('frontend.events') }}" class="btn btn-light btn-lg px-4 rounded-3 fw-semibold" style="color:#2563eb;">
            <i class="fas fa-ticket-alt me-2"></i> Get Your Ticket
        </a>
    </div>
</section>

@endsection