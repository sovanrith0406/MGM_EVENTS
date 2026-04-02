@extends('frontend.layouts.app')
@section('title', 'Speakers — MGM Event')
@section('nav_speakers', 'active')
@section('content')

{{-- Page Header --}}
<div class="page-header">
    <h1 class="fw-bold">Our Speakers</h1>
    <p class="text-secondary">Meet the industry leaders and innovators sharing their knowledge</p>
</div>

<section class="py-5">
    <div class="container">

        {{-- Search --}}
        <form method="GET" action="{{ route('frontend.speakers') }}" class="mb-4">
            <div class="d-flex gap-2 flex-wrap align-items-center">
                <input type="text" name="search" class="form-control" style="max-width:300px;"
                       placeholder="🔍 Search speakers..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary px-4 rounded-3">Search</button>
                <a href="{{ route('frontend.speakers') }}" class="btn btn-outline-secondary px-4 rounded-3">Reset</a>
            </div>
        </form>

        {{-- Grid --}}
        <div class="row g-4">
            @forelse($speakers as $speaker)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="speaker-card card border-0 shadow-sm text-center p-4 h-100">
                    @if($speaker->photo_url)
                        <img src="{{ asset($speaker->photo_url) }}"
                             class="speaker-avatar mx-auto mb-3"
                             alt="{{ $speaker->full_name }}"
                             onerror="this.replaceWith(Object.assign(document.createElement('div'), {className:'speaker-avatar-placeholder mx-auto mb-3', innerHTML:'<i class=\'fas fa-user\'></i>'}))">
                    @else
                        <div class="speaker-avatar-placeholder mx-auto mb-3">
                            <i class="fas fa-user"></i>
                        </div>
                    @endif
                    <h6 class="fw-bold mb-1">{{ $speaker->full_name }}</h6>
                    <div class="text-primary small fw-semibold mb-1">{{ $speaker->title ?? '—' }}</div>
                    <div class="text-secondary small mb-2">{{ $speaker->company ?? '' }}</div>
                    @if($speaker->bio)
                        <p class="text-secondary mb-0" style="font-size:12px; line-height:1.5;">
                            {{ Str::limit($speaker->bio, 80) }}
                        </p>
                    @endif
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5 text-secondary">
                <i class="fas fa-users mb-3 d-block" style="font-size:56px; color:#cbd5e1;"></i>
                No speakers found.
            </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($speakers->hasPages())
        <div class="d-flex justify-content-center mt-5">
            {{ $speakers->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
        @endif

    </div>
</section>
@endsection