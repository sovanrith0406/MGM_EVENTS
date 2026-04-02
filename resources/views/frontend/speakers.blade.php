@extends('frontend.layouts.app')
@section('title', 'Speakers — MGM Event')
@section('nav_speakers', 'active')
@section('content')

@push('styles')
<style>
    /* Shared form styles from events page */
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

    /* Pagination (Same as events page) */
    .pagination .page-link { background-color: var(--bg-card); border-color: rgba(255,255,255,0.05); color: var(--text-muted); transition: all 0.3s ease; }
    .pagination .page-link:hover { background-color: rgba(255,0,127,0.1); border-color: var(--primary-neon); color: var(--primary-neon); }
    .pagination .page-item.active .page-link { background-color: var(--primary-neon); border-color: var(--primary-neon); color: #fff; }
    .pagination .page-item.disabled .page-link { background-color: rgba(255,255,255,0.02); border-color: rgba(255,255,255,0.05); color: rgba(255,255,255,0.2); }

    /* Speaker Cards */
    .speaker-card-dark {
        background: var(--bg-card);
        border: 1px solid rgba(255,255,255,0.05);
        border-radius: 16px;
        transition: all 0.4s ease;
    }
    .speaker-card-dark:hover {
        border-color: rgba(255, 0, 127, 0.4);
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.5), 0 0 20px rgba(255,0,127,0.1);
    }

    .speaker-avatar-wrapper {
        width: 120px; height: 120px;
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
</style>
@endpush

{{-- Page Header --}}
<div class="page-header py-5 text-center" style="background: radial-gradient(circle at center, rgba(255, 0, 127, 0.1) 0%, transparent 70%); border-bottom: 1px solid rgba(255,255,255,0.05);">
    <div class="container py-4">
        <h1 class="fw-bold text-white mb-3" style="font-size: clamp(32px, 5vw, 50px);">Our <span class="text-neon">Speakers</span></h1>
        <p class="text-muted-custom fs-5 mb-0">Meet the industry leaders and innovators sharing their knowledge</p>
    </div>
</div>

<section class="py-5">
    <div class="container py-4">

        {{-- Search --}}
        <form method="GET" action="{{ route('frontend.speakers') }}" class="mb-5 text-center">
            <div class="d-inline-flex gap-3 flex-wrap align-items-center p-3 rounded-4" style="background: var(--bg-card); border: 1px solid rgba(255,255,255,0.05);">
                <div style="min-width: 300px;">
                    <input type="text" name="search" class="form-control form-control-lg form-dark" 
                           placeholder="🔍 Search speakers by name or role..." value="{{ request('search') }}">
                </div>
                <button type="submit" class="btn-neon border-0 px-4 py-2" style="height: 48px;">Search</button>
                <a href="{{ route('frontend.speakers') }}" class="btn-outline-neon text-decoration-none px-4 py-2 text-center" style="height: 48px; line-height: 28px;">Reset</a>
            </div>
        </form>

        {{-- Grid --}}
        <div class="row g-4 mt-2">
            @forelse($speakers as $speaker)
            <div class="col-12 col-md-6 col-lg-3">
                <div class="speaker-card-dark text-center p-4 h-100 d-flex flex-column">
                    <div class="speaker-avatar-wrapper">
                        @if($speaker->photo_url)
                            <img src="{{ asset($speaker->photo_url) }}"
                                 class="speaker-avatar"
                                 alt="{{ $speaker->full_name }}"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="speaker-avatar" style="display:none; align-items:center; justify-content:center; font-size:40px; color:rgba(255,255,255,0.2);">
                                <i class="fas fa-user"></i>
                            </div>
                        @else
                            <div class="speaker-avatar d-flex align-items-center justify-content-center" style="font-size:40px; color:rgba(255,255,255,0.2);">
                                <i class="fas fa-user"></i>
                            </div>
                        @endif
                    </div>
                    
                    <h5 class="text-white fw-bold mb-1">{{ $speaker->full_name }}</h5>
                    <div class="text-neon small fw-bold mb-1">{{ $speaker->title ?? '—' }}</div>
                    <div class="text-muted-custom small mb-3">{{ $speaker->company ?? '' }}</div>
                    
                    @if($speaker->bio)
                        <p class="text-muted-custom mt-auto mb-0" style="font-size:13px; line-height:1.6;">
                            {{ Str::limit($speaker->bio, 90) }}
                        </p>
                    @endif
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5 text-muted-custom">
                <i class="fas fa-users mb-3 d-block" style="font-size:64px; opacity: 0.2;"></i>
                <h3 class="text-white mt-3">No Speakers Found</h3>
                <p>We couldn't find any speakers matching your criteria.</p>
            </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($speakers->hasPages())
        <div class="d-flex justify-content-center mt-5 pt-4">
            {{ $speakers->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
        @endif

    </div>
</section>
@endsection