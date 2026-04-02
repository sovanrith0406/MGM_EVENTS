@extends('frontend.layouts.app')
@section('title', $event->event_name . ' — MGM Event')
@section('nav_events', 'active')
@section('content')

{{-- Page Header --}}
<div class="page-header">
    <span class="badge badge-published px-3 py-2 rounded-pill mb-3 d-inline-block" style="font-size:12px;">
        {{ ucfirst($event->status) }}
    </span>
    <h1 class="fw-bold">{{ $event->event_name }}</h1>
    @if($event->description)
        <p class="text-secondary mt-2" style="max-width:650px; margin:0 auto;">
            {{ Str::limit($event->description, 120) }}
        </p>
    @endif
</div>

<section class="py-5">
    <div class="container">
        <div class="row g-4">

            {{-- Left Column --}}
            <div class="col-lg-8">

                {{-- About --}}
                <div class="card border-0 shadow-sm rounded-3 mb-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3">
                            <i class="fas fa-info-circle text-primary me-2"></i> About This Event
                        </h5>
                        <p class="text-secondary" style="line-height:1.8;">
                            {{ $event->description ?? 'No description available.' }}
                        </p>
                    </div>
                </div>

                {{-- Schedule --}}
                @if($schedules->count())
                <div class="mb-4">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-list-alt text-primary me-2"></i> Schedule
                    </h5>
                    @foreach($schedules as $s)
                    <div class="card border-0 shadow-sm rounded-3 mb-3">
                        <div class="card-body p-3 d-flex gap-3">
                            <div class="schedule-time text-center px-3 py-2 rounded-3 flex-shrink-0">
                                {{ \Carbon\Carbon::parse($s->start_time)->format('H:i') }}<br>
                                <small>—</small><br>
                                {{ \Carbon\Carbon::parse($s->end_time)->format('H:i') }}
                            </div>
                            <div>
                                <h6 class="fw-semibold mb-1">{{ $s->title }}</h6>
                                @if($s->description)
                                    <p class="text-secondary small mb-2">{{ $s->description }}</p>
                                @endif
                                <div class="d-flex flex-wrap gap-2">
                                    <span class="tag tag-{{ $s->session_type }}">
                                        {{ ucfirst($s->session_type) }}
                                    </span>
                                    @foreach($s->speakers as $sp)
                                        <span class="tag" style="background:#f1f5f9; color:#475569;">
                                            <i class="fas fa-user me-1"></i>{{ $sp->full_name }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif

                {{-- Speakers --}}
                @if($speakers->count())
                <h5 class="fw-bold mb-3">
                    <i class="fas fa-microphone text-primary me-2"></i> Speakers
                </h5>
                <div class="row g-3">
                    @foreach($speakers as $sp)
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="speaker-card card border-0 shadow-sm text-center p-3 h-100">
                            @if($sp->photo_url)
                                <img src="{{ asset('storage/' . $sp->photo_url) }}"
                                     class="speaker-avatar mx-auto mb-2"
                                     alt="{{ $sp->full_name }}"
                                     onerror="this.replaceWith(Object.assign(document.createElement('div'), {className:'speaker-avatar-placeholder mx-auto mb-2', innerHTML:'<i class=\'fas fa-user\'></i>'}))">
                            @else
                                <div class="speaker-avatar-placeholder mx-auto mb-2">
                                    <i class="fas fa-user"></i>
                                </div>
                            @endif
                            <h6 class="fw-bold mb-1 small">{{ $sp->full_name }}</h6>
                            <div class="text-primary" style="font-size:12px;">{{ $sp->title ?? '' }}</div>
                            <div class="text-secondary" style="font-size:12px;">{{ $sp->company ?? '' }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            {{-- Right Column: Info Card --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-3 sticky-top" style="top:80px;">
                    <div class="card-body p-4">
                        <div class="card-price mb-4" style="font-size:28px;">
                            {{ $event->currency }} {{ number_format($event->price, 2) }}
                        </div>

                        <ul class="list-unstyled d-flex flex-column gap-3 mb-3">
                            <li class="d-flex align-items-start gap-2">
                                <i class="fas fa-calendar-alt text-primary mt-1"></i>
                                <span class="small text-secondary">
                                    {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}
                                    @if($event->start_date != $event->end_date)
                                        — {{ \Carbon\Carbon::parse($event->end_date)->format('d M Y') }}
                                    @endif
                                </span>
                            </li>
                            <li class="d-flex align-items-start gap-2">
                                <i class="fas fa-clock text-primary mt-1"></i>
                                <span class="small text-secondary">{{ $event->timezone }}</span>
                            </li>
                            @if($event->venue)
                            <li class="d-flex align-items-start gap-2">
                                <i class="fas fa-map-marker-alt text-primary mt-1"></i>
                                <span class="small text-secondary">{{ $event->venue->venue_name }}</span>
                            </li>
                            <li class="d-flex align-items-start gap-2">
                                <i class="fas fa-city text-primary mt-1"></i>
                                <span class="small text-secondary">{{ $event->venue->city }}, {{ $event->venue->country }}</span>
                            </li>
                            @endif
                        </ul>

                        <hr class="my-3">

                        @auth
                            <a href="{{ route('frontend.booking.form', $event->event_id) }}"
                               class="btn btn-primary w-100 rounded-3 d-flex align-items-center justify-content-center gap-2">
                                <i class="fas fa-ticket-alt"></i> Register Interest
                            </a>
                        @else
                            <a href="{{ route('login') }}?redirect={{ urlencode(route('frontend.booking.form', $event->event_id)) }}"
                               class="btn btn-primary w-100 rounded-3 d-flex align-items-center justify-content-center gap-2">
                                <i class="fas fa-sign-in-alt"></i> Login to Register
                            </a>
                            <p class="text-center text-secondary mt-2 mb-0" style="font-size:12px;">
                                <i class="fas fa-info-circle me-1"></i>
                                You need an account to register for this event.
                            </p>
                        @endauth

                        {{-- Sponsors --}}
                        @if($sponsors->count())
                        <hr class="my-3">
                        <p class="text-uppercase fw-bold mb-2" style="font-size:11px; color:#64748b; letter-spacing:1px;">
                            Sponsors
                        </p>
                        @foreach($sponsors as $sp)
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span>🏢</span>
                                <span class="small text-secondary">{{ $sp->name }}</span>
                            </div>
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection