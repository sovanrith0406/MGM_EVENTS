@extends('frontend.layouts.app')
@section('title', 'Events — MGM Event')
@section('nav_events', 'active')
@section('content')

{{-- Page Header --}}
<div class="page-header">
    <h1 class="fw-bold">All Events</h1>
    <p class="text-secondary">Discover and register for upcoming events across Cambodia</p>
</div>

<section class="py-5">
    <div class="container">

        {{-- Filter Bar --}}
        <form method="GET" action="{{ route('frontend.events') }}" class="mb-4">
            <div class="d-flex gap-2 flex-wrap align-items-center">
                <input type="text" name="search" class="form-control" style="max-width:280px;"
                       placeholder="🔍 Search events..." value="{{ request('search') }}">
                <select name="month" class="form-select" style="max-width:160px;">
                    <option value="">All Months</option>
                    @foreach(range(1,12) as $m)
                        <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary px-4 rounded-3">Search</button>
                <a href="{{ route('frontend.events') }}" class="btn btn-outline-secondary px-4 rounded-3">Reset</a>
            </div>
        </form>

        {{-- Events Grid --}}
        <div class="row g-4">
            @forelse($events as $event)
            <div class="col-md-6 col-lg-4">
                <div class="card event-card h-100 border-0 shadow-sm">
                    <div class="card-img-placeholder">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div class="card-body p-4">
                        <span class="badge badge-published px-3 py-2 rounded-pill mb-2 d-inline-block" style="font-size:11px;">
                            Published
                        </span>
                        <h5 class="fw-bold mb-2">{{ $event->event_name }}</h5>
                        @if($event->description)
                            <p class="text-secondary small mb-3">{{ Str::limit($event->description, 90) }}</p>
                        @endif
                        <div class="d-flex gap-3 flex-wrap mb-3">
                            <span class="small text-secondary">
                                <i class="fas fa-calendar text-primary me-1"></i>
                                {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}
                            </span>
                            <span class="small text-secondary">
                                <i class="fas fa-map-marker-alt text-primary me-1"></i>
                                {{ $event->venue->venue_name ?? 'TBA' }}
                            </span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="card-price">{{ $event->currency }} {{ number_format($event->price, 2) }}</div>
                            <a href="{{ route('frontend.events.show', $event->event_id) }}"
                               class="btn btn-primary btn-sm px-3 rounded-3">
                                Details <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5 text-secondary">
                <i class="fas fa-calendar-times mb-3 d-block" style="font-size:56px; color:#cbd5e1;"></i>
                No events found.
            </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($events->hasPages())
        <div class="d-flex justify-content-center mt-5">
            {{ $events->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
        @endif

    </div>
</section>
@endsection