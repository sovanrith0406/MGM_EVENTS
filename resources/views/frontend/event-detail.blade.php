@extends('frontend.layouts.app')
@section('title', $event->event_name . ' — MGM Event')
@section('nav_events', 'active')
@section('content')

@push('styles')
<style>
    /* Dark Theme Cards */
    .card-dark {
        background: var(--bg-card);
        border: 1px solid rgba(255,255,255,0.05);
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.2);
    }

    /* Status Badge */
    .badge-status {
        background: rgba(255, 0, 127, 0.15);
        color: var(--primary-neon);
        border: 1px solid rgba(255, 0, 127, 0.3);
        letter-spacing: 2px;
        text-transform: uppercase;
        font-weight: 700;
        padding: 8px 16px;
    }

    /* ── Hero Banner ─────────────────────────────────────────── */
    .event-hero {
        position: relative;
        width: 100%;
        max-height: 460px;
        overflow: hidden;
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }
    .event-hero img {
        width: 100%;
        height: 460px;
        object-fit: cover;
        display: block;
        filter: brightness(0.55);
    }
    /* Dark overlay so text stays readable */
    .event-hero-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(
            to bottom,
            rgba(0,0,0,0.15) 0%,
            rgba(0,0,0,0.6) 70%,
            rgba(10,7,16,1) 100%
        );
    }
    /* Text sits on top of overlay */
    .event-hero-content {
        position: absolute;
        bottom: 0; left: 0; right: 0;
        padding: 40px 0 48px;
        text-align: center;
    }
    /* Fallback header when no image */
    .page-header-plain {
        background: radial-gradient(circle at center, rgba(255,0,127,0.1) 0%, transparent 70%);
        border-bottom: 1px solid rgba(255,255,255,0.05);
        padding: 80px 0;
        text-align: center;
    }

    /* ── Right-column Event Image thumbnail ──────────────────── */
    .event-thumb {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 12px;
        border: 1px solid rgba(255,255,255,0.05);
        display: block;
        margin-bottom: 20px;
    }

    /* Schedule Styling */
    .schedule-card {
        background: rgba(255,255,255,0.02);
        border: 1px solid rgba(255,255,255,0.05);
        border-radius: 12px;
        transition: all 0.3s ease;
    }
    .schedule-card:hover {
        background: rgba(255,255,255,0.04);
        border-color: rgba(255, 0, 127, 0.2);
        transform: translateX(5px);
    }
    .schedule-time-box {
        background: rgba(0,0,0,0.3);
        border: 1px solid rgba(255,255,255,0.05);
        color: var(--primary-neon);
        min-width: 80px;
        border-radius: 10px;
        font-weight: 800;
        font-size: 14px;
    }

    /* Tags */
    .tag-dark {
        background: rgba(255,255,255,0.05);
        color: var(--text-muted);
        border: 1px solid rgba(255,255,255,0.1);
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .tag-neon {
        background: rgba(255, 0, 127, 0.1);
        color: var(--primary-neon);
        border: 1px solid rgba(255, 0, 127, 0.3);
    }

    /* Mini Speaker Card */
    .speaker-mini-card {
        background: rgba(255,255,255,0.02);
        border: 1px solid rgba(255,255,255,0.05);
        border-radius: 12px;
        transition: all 0.3s ease;
    }
    .speaker-mini-card:hover {
        border-color: rgba(255, 0, 127, 0.3);
        transform: translateY(-3px);
    }
    .speaker-avatar-sm {
        width: 70px; height: 70px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--primary-neon);
        padding: 2px;
    }
    .speaker-avatar-placeholder-sm {
        width: 70px; height: 70px;
        border-radius: 50%;
        background: rgba(255,255,255,0.05);
        border: 2px solid rgba(255,255,255,0.1);
        display: flex; align-items: center; justify-content: center;
        font-size: 24px;
        color: rgba(255,255,255,0.2);
    }
</style>
@endpush

{{-- ── Page Header ──────────────────────────────────────────────── --}}
@if($event->image)
    {{-- Hero banner with the event image --}}
    <div class="event-hero">
        <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->event_name }}">
        <div class="event-hero-overlay"></div>
        <div class="event-hero-content">
            <div class="container">
                <span class="badge badge-status rounded-pill mb-3 d-inline-block" style="font-size:12px;">
                    {{ ucfirst($event->status) }}
                </span>
                <h1 class="fw-bold text-white mb-3" style="font-size: clamp(28px, 5vw, 48px); text-shadow: 0 2px 12px rgba(0,0,0,0.6);">
                    {{ $event->event_name }}
                </h1>
                @if($event->description)
                    <p class="text-white mt-2 fs-5" style="max-width:700px; margin:0 auto; line-height:1.6; opacity:0.75;">
                        {{ Str::limit($event->description, 120) }}
                    </p>
                @endif
            </div>
        </div>
    </div>
@else
    {{-- Plain gradient header fallback --}}
    <div class="page-header-plain">
        <div class="container py-4">
            <span class="badge badge-status rounded-pill mb-3 d-inline-block" style="font-size:12px;">
                {{ ucfirst($event->status) }}
            </span>
            <h1 class="fw-bold text-white mb-3" style="font-size: clamp(32px, 5vw, 48px);">
                {{ $event->event_name }}
            </h1>
            @if($event->description)
                <p class="text-muted-custom mt-2 fs-5" style="max-width:700px; margin:0 auto; line-height:1.6;">
                    {{ Str::limit($event->description, 120) }}
                </p>
            @endif
        </div>
    </div>
@endif

<section class="py-5">
    <div class="container py-3">
        <div class="row g-5">

            {{-- ── Left Column ────────────────────────────────────── --}}
            <div class="col-lg-8">

                {{-- About --}}
                <div class="card-dark mb-5">
                    <div class="card-body p-4 p-md-5">
                        <h4 class="fw-bold text-white mb-4">
                            <i class="fas fa-info-circle text-neon me-2"></i> About This Event
                        </h4>
                        <p class="text-muted-custom" style="line-height:1.8; font-size:16px;">
                            {{ $event->description ?? 'No description available.' }}
                        </p>
                    </div>
                </div>

                {{-- Schedule --}}
                @if($schedules->count())
                <div class="mb-5">
                    <h4 class="fw-bold text-white mb-4 ps-2">
                        <i class="fas fa-list-alt text-neon me-2"></i> Event Schedule
                    </h4>
                    <div class="d-flex flex-column gap-3">
                        @foreach($schedules as $s)
                        <div class="schedule-card p-3 p-md-4 d-flex flex-column flex-md-row gap-3 gap-md-4 align-items-md-center">
                            <div class="schedule-time-box text-center px-3 py-3 flex-shrink-0">
                                {{ \Carbon\Carbon::parse($s->start_time)->format('H:i') }}
                                <div style="color:rgba(255,255,255,0.2); font-size:10px; margin:2px 0;">|</div>
                                {{ \Carbon\Carbon::parse($s->end_time)->format('H:i') }}
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="fw-bold text-white mb-2">{{ $s->title }}</h5>
                                @if($s->description)
                                    <p class="text-muted-custom small mb-3">{{ $s->description }}</p>
                                @endif
                                <div class="d-flex flex-wrap gap-2 align-items-center">
                                    <span class="tag-dark tag-neon">{{ ucfirst($s->session_type) }}</span>
                                    @foreach($s->speakers as $sp)
                                        <span class="tag-dark d-flex align-items-center gap-2">
                                            <i class="fas fa-user text-neon" style="font-size:10px;"></i>
                                            {{ $sp->full_name }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Speakers --}}
                @if($speakers->count())
                <h4 class="fw-bold text-white mb-4 ps-2">
                    <i class="fas fa-microphone text-neon me-2"></i> Featured Speakers
                </h4>
                <div class="row g-4">
                    @foreach($speakers as $sp)
                    <div class="col-6 col-md-4">
                        <div class="speaker-mini-card text-center p-4 h-100">
                            @if($sp->photo_url)
                                <img src="{{ asset('storage/' . $sp->photo_url) }}"
                                     class="speaker-avatar-sm mx-auto mb-3"
                                     alt="{{ $sp->full_name }}"
                                     onerror="this.replaceWith(Object.assign(document.createElement('div'), {className:'speaker-avatar-placeholder-sm mx-auto mb-3', innerHTML:'<i class=\'fas fa-user\'></i>'}))">
                            @else
                                <div class="speaker-avatar-placeholder-sm mx-auto mb-3">
                                    <i class="fas fa-user"></i>
                                </div>
                            @endif
                            <h6 class="fw-bold text-white mb-1">{{ $sp->full_name }}</h6>
                            <div class="text-neon" style="font-size:12px; font-weight:600;">{{ $sp->title ?? '' }}</div>
                            <div class="text-muted-custom mt-1" style="font-size:12px;">{{ $sp->company ?? '' }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif

            </div>

            {{-- ── Right Column: Info Card ─────────────────────────── --}}
            <div class="col-lg-4">
                <div class="card-dark sticky-top p-4" style="top:100px;">

                    {{-- Thumbnail (only when no full hero — avoids repeating the image) --}}
                    @if(!$event->image)
                    {{-- no image: nothing extra needed here --}}
                    @else
                        <img src="{{ asset('storage/' . $event->image) }}"
                             alt="{{ $event->event_name }}"
                             class="event-thumb">
                    @endif

                    {{-- Price Tag --}}
                    <div class="text-center mb-4 pb-4 border-bottom" style="border-color:rgba(255,255,255,0.05) !important;">
                        <span class="text-muted-custom d-block mb-1 text-uppercase" style="font-size:12px; letter-spacing:1px;">Ticket Price</span>
                        <div class="fw-bold text-white" style="font-size:36px;">
                            <span class="text-neon">{{ $event->currency }}</span> {{ number_format($event->price, 2) }}
                        </div>
                    </div>

                    {{-- Event Details List --}}
                    <ul class="list-unstyled d-flex flex-column gap-4 mb-4">
                        <li class="d-flex align-items-start gap-3">
                            <div class="icon-box" style="background:rgba(255,0,127,0.1); width:40px; height:40px; border-radius:10px; display:flex; align-items:center; justify-content:center;">
                                <i class="fas fa-calendar-alt text-neon"></i>
                            </div>
                            <div>
                                <span class="d-block text-white fw-semibold mb-1">Date</span>
                                <span class="small text-muted-custom">
                                    {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}
                                    @if($event->start_date != $event->end_date)
                                        — {{ \Carbon\Carbon::parse($event->end_date)->format('d M Y') }}
                                    @endif
                                </span>
                            </div>
                        </li>

                        <li class="d-flex align-items-start gap-3">
                            <div class="icon-box" style="background:rgba(255,0,127,0.1); width:40px; height:40px; border-radius:10px; display:flex; align-items:center; justify-content:center;">
                                <i class="fas fa-clock text-neon"></i>
                            </div>
                            <div>
                                <span class="d-block text-white fw-semibold mb-1">Timezone</span>
                                <span class="small text-muted-custom">{{ $event->timezone }}</span>
                            </div>
                        </li>

                        @if($event->venue)
                        <li class="d-flex align-items-start gap-3">
                            <div class="icon-box" style="background:rgba(255,0,127,0.1); width:40px; height:40px; border-radius:10px; display:flex; align-items:center; justify-content:center;">
                                <i class="fas fa-map-marker-alt text-neon"></i>
                            </div>
                            <div>
                                <span class="d-block text-white fw-semibold mb-1">Location</span>
                                <span class="small text-muted-custom d-block">{{ $event->venue->venue_name }}</span>
                                <span class="small text-muted-custom">{{ $event->venue->city }}, {{ $event->venue->country }}</span>
                            </div>
                        </li>
                        @endif
                    </ul>

                    {{-- Call to Action --}}
                    <div class="mt-4 pt-4 border-top" style="border-color:rgba(255,255,255,0.05) !important;">
                        @auth
                            <a href="{{ route('frontend.booking.form', $event->event_id) }}"
                               class="btn-neon w-100 d-flex align-items-center justify-content-center gap-2 fs-5 text-decoration-none py-3">
                                <i class="fas fa-ticket-alt"></i> Register Now
                            </a>
                        @else
                            <a href="{{ route('login') }}?redirect={{ urlencode(route('frontend.booking.form', $event->event_id)) }}"
                               class="btn-neon w-100 d-flex align-items-center justify-content-center gap-2 fs-5 text-decoration-none py-3">
                                <i class="fas fa-sign-in-alt"></i> Booking Now
                            </a>
                            <p class="text-center mt-3 mb-0" style="font-size:13px; color:rgba(255,255,255,0.4);">
                                <i class="fas fa-lock me-1"></i> Secure registration requires an account.
                            </p>
                        @endauth
                    </div>

                    {{-- Sponsors Mini List --}}
                    @if($sponsors->count())
                    <div class="mt-4 pt-4 border-top" style="border-color:rgba(255,255,255,0.05) !important;">
                        <p class="text-uppercase fw-bold mb-3" style="font-size:11px; color:var(--text-muted); letter-spacing:1px;">
                            Supported By
                        </p>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($sponsors as $sp)
                                <span class="tag-dark d-flex align-items-center gap-2" style="background:rgba(255,255,255,0.02);">
                                    <i class="fas fa-building text-neon" style="font-size:10px;"></i>
                                    {{ $sp->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                </div>
            </div>

        </div>
    </div>
</section>
@endsection