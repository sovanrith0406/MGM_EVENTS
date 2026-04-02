@extends('frontend.layouts.app')
@section('title', 'Events — MGM Event')
@section('nav_events', 'active')
@section('content')

@push('styles')
<style>
    /* Dark Theme Form Elements */
    .form-dark {
        background-color: rgba(255,255,255,0.05) !important;
        border: 1px solid rgba(255,255,255,0.1) !important;
        color: #fff !important;
        border-radius: 8px;
    }
    .form-dark::placeholder { color: rgba(255,255,255,0.4); }
    .form-dark:focus {
        background-color: rgba(255,255,255,0.08) !important;
        border-color: var(--primary-neon) !important;
        box-shadow: 0 0 15px rgba(255, 0, 127, 0.2) !important;
    }

    /* Dark Theme Pagination */
    .pagination .page-link {
        background-color: var(--bg-card);
        border-color: rgba(255,255,255,0.05);
        color: var(--text-muted);
        transition: all 0.3s ease;
    }
    .pagination .page-link:hover {
        background-color: rgba(255,0,127,0.1);
        border-color: var(--primary-neon);
        color: var(--primary-neon);
    }
    .pagination .page-item.active .page-link {
        background-color: var(--primary-neon);
        border-color: var(--primary-neon);
        color: #fff;
    }
    .pagination .page-item.disabled .page-link {
        background-color: rgba(255,255,255,0.02);
        border-color: rgba(255,255,255,0.05);
        color: rgba(255,255,255,0.2);
    }

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

    /* Image container — fixed height, covers area */
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
    /* Fallback placeholder (no image) */
    .event-card-img .img-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 50px;
        color: rgba(255,255,255,0.1);
    }
    /* Gradient overlay on bottom of image */
    .event-card-img::after {
        content: '';
        position: absolute;
        bottom: 0; left: 0; right: 0;
        height: 50%;
        background: linear-gradient(to top, var(--bg-card), transparent);
        pointer-events: none;
    }
    /* Status badge always on top of overlay */
    .event-card-img .badge-status {
        position: absolute;
        top: 12px;
        right: 12px;
        z-index: 2;
        background: rgba(255,0,127,0.2);
        color: var(--primary-neon);
        border: 1px solid var(--primary-neon);
        padding: 6px 12px;
        font-weight: 600;
        border-radius: 6px;
    }
</style>
@endpush

{{-- Page Header --}}
<div class="page-header py-5 text-center" style="background: radial-gradient(circle at center, rgba(255, 0, 127, 0.1) 0%, transparent 70%); border-bottom: 1px solid rgba(255,255,255,0.05);">
    <div class="container py-4">
        <h1 class="fw-bold text-white mb-3" style="font-size: clamp(32px, 5vw, 50px);">Explore <span class="text-neon">Events</span></h1>
        <p class="text-muted-custom fs-5 mb-0">Discover and register for upcoming events across Cambodia</p>
    </div>
</div>

<section class="py-5">
    <div class="container py-4">

        {{-- Filter Bar --}}
        <form method="GET" action="{{ route('frontend.events') }}" class="mb-5 p-4 rounded-4" style="background: var(--bg-card); border: 1px solid rgba(255,255,255,0.05);">
            <div class="d-flex gap-3 flex-wrap align-items-center">
                <div class="flex-grow-1" style="min-width: 250px;">
                    <input type="text" name="search" class="form-control form-control-lg form-dark"
                           placeholder="🔍 Search events..." value="{{ request('search') }}">
                </div>
                <div style="min-width: 180px;">
                    <select name="month" class="form-select form-select-lg form-dark">
                        <option value="" class="bg-dark">All Months</option>
                        @foreach(range(1,12) as $m)
                            <option value="{{ $m }}" class="bg-dark" {{ request('month') == $m ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn-neon border-0 px-4 py-2" style="height: 48px;">Search</button>
                <a href="{{ route('frontend.events') }}" class="btn-outline-neon text-decoration-none px-4 py-2 text-center" style="height: 48px; line-height: 28px;">Reset</a>
            </div>
        </form>

        {{-- Events Grid --}}
        <div class="row g-4">
            @forelse($events as $event)
            <div class="col-md-6 col-lg-4">
                <div class="event-card h-100 d-flex flex-column">

                    {{-- Image / Placeholder --}}
                    <div class="event-card-img">
                        @if($event->image)
                            <img src="{{ asset('storage/' . $event->image) }}"
                                 alt="{{ $event->event_name }}">
                        @else
                            <div class="img-placeholder">
                                <i class="fas fa-microphone-alt"></i>
                            </div>
                        @endif

                        <span class="badge-status">
                            {{ ucfirst($event->status ?? 'Published') }}
                        </span>
                    </div>

                    <div class="card-body p-4 d-flex flex-column">
                        <h4 class="text-white mb-3">{{ $event->event_name }}</h4>

                        @if($event->description)
                            <p class="text-muted-custom small mb-4 flex-grow-1">{{ Str::limit($event->description, 90) }}</p>
                        @endif

                        <div class="mb-4 text-muted-custom small">
                            <div class="mb-2">
                                <i class="fas fa-calendar-alt text-neon me-2" style="width: 15px;"></i>
                                {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}
                            </div>
                            <div>
                                <i class="fas fa-map-marker-alt text-neon me-2" style="width: 15px;"></i>
                                {{ $event->venue->venue_name ?? 'TBA' }}
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center border-top pt-4 mt-auto" style="border-color: rgba(255,255,255,0.05) !important;">
                            <div class="fs-4 fw-bold text-white">{{ $event->currency }} {{ number_format($event->price, 2) }}</div>
                            <a href="{{ route('frontend.events.show', $event->event_id) }}" class="btn-neon text-decoration-none" style="padding: 8px 20px;">
                                Details <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5 text-muted-custom">
                <i class="fas fa-calendar-times mb-3 d-block" style="font-size:64px; opacity: 0.2;"></i>
                <h3 class="text-white mt-3">No Events Found</h3>
                <p>Try adjusting your search filters to find what you're looking for.</p>
            </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($events->hasPages())
        <div class="d-flex justify-content-center mt-5 pt-4">
            {{ $events->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
        @endif

    </div>
</section>
@endsection