@extends('frontend.layouts.app')
@section('title', 'Sponsors — MGM Event')
@section('nav_sponsors', 'active')
@section('content')

@push('styles')
<style>
    /* Sponsor Cards */
    .sponsor-card-dark {
        background: var(--bg-card);
        border: 1px solid rgba(255,255,255,0.05);
        border-radius: 16px;
        transition: all 0.4s ease;
        position: relative;
        overflow: hidden;
    }
    .sponsor-card-dark:hover {
        border-color: rgba(255, 0, 127, 0.4);
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.5), 0 0 20px rgba(255,0,127,0.1);
    }

    /* Logo Wrapper to make logos pop on dark background */
    .sponsor-logo-wrapper {
        background: rgba(255,255,255,0.02);
        border-radius: 12px;
        padding: 20px;
        height: 120px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid rgba(255,255,255,0.05);
    }
    .sponsor-logo {
        max-width: 100%;
        max-height: 80px;
        object-fit: contain;
        filter: grayscale(100%) brightness(200%);
        transition: all 0.3s ease;
    }
    .sponsor-card-dark:hover .sponsor-logo {
        filter: grayscale(0%) brightness(100%);
    }

    /* Tier Badges Dark Mode */
    .badge-tier { font-size: 11px; letter-spacing: 1px; text-transform: uppercase; padding: 5px 12px; border-radius: 20px; font-weight: 700; }
    .tier-platinum { background: rgba(224, 231, 255, 0.1); color: #a5b4fc; border: 1px solid rgba(165, 180, 252, 0.3); }
    .tier-gold     { background: rgba(253, 224, 71, 0.1); color: #fde047; border: 1px solid rgba(253, 224, 71, 0.3); }
    .tier-silver   { background: rgba(241, 245, 249, 0.1); color: #cbd5e1; border: 1px solid rgba(203, 213, 225, 0.3); }
    .tier-bronze   { background: rgba(217, 119, 6, 0.1); color: #fbbf24; border: 1px solid rgba(251, 191, 36, 0.3); }
    .tier-partner  { background: rgba(255, 0, 127, 0.1); color: var(--primary-neon); border: 1px solid rgba(255, 0, 127, 0.3); }
</style>
@endpush

{{-- Page Header --}}
<div class="page-header py-5 text-center" style="background: radial-gradient(circle at center, rgba(255, 0, 127, 0.1) 0%, transparent 70%); border-bottom: 1px solid rgba(255,255,255,0.05);">
    <div class="container py-4">
        <h1 class="fw-bold text-white mb-3" style="font-size: clamp(32px, 5vw, 50px);">Our <span class="text-neon">Partners</span></h1>
        <p class="text-muted-custom fs-5 mb-0">Meet the visionaries, companies, and organizations powering our events.</p>
    </div>
</div>

<section class="py-5">
    <div class="container py-4">
        <div class="row g-4 justify-content-center">
            @forelse($sponsors as $sponsor)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="sponsor-card-dark text-center p-4 h-100 d-flex flex-column align-items-center justify-content-center">

                    {{-- Logo --}}
                    <div class="sponsor-logo-wrapper w-100 mb-4 text-center">
                        @if($sponsor->logo_url)
                            <img src="{{ asset($sponsor->logo_url) }}"
                                 class="sponsor-logo"
                                 alt="{{ $sponsor->name }}"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                            <h5 class="text-white mb-0" style="display: none; font-weight: 800; letter-spacing: 1px;">
                                {{ $sponsor->name }}
                            </h5>
                        @else
                            <h5 class="text-white mb-0" style="font-weight: 800; letter-spacing: 1px;">
                                {{ $sponsor->name }}
                            </h5>
                        @endif
                    </div>

                    <h5 class="text-white fw-bold mb-3">{{ $sponsor->name }}</h5>

                    @if(isset($sponsor->tier))
                        <div class="mb-3">
                            <span class="badge badge-tier tier-{{ strtolower($sponsor->tier) }}">
                                {{ ucfirst($sponsor->tier) }}
                            </span>
                        </div>
                    @endif

                    @if($sponsor->website)
                        <a href="{{ $sponsor->website }}" target="_blank"
                           class="small text-neon text-decoration-none d-block mb-2 transition-all">
                            <i class="fas fa-globe me-1"></i> Visit Website
                        </a>
                    @endif

                    @if($sponsor->contact_name)
                        <p class="small text-muted-custom mb-0 mt-auto pt-2 border-top w-100" style="border-color: rgba(255,255,255,0.05) !important;">
                            Contact: <span class="text-white">{{ $sponsor->contact_name }}</span>
                        </p>
                    @endif
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5 text-muted-custom">
                <i class="fas fa-handshake mb-3 d-block" style="font-size:64px; opacity: 0.2;"></i>
                <h3 class="text-white mt-3">No Sponsors Yet</h3>
                <p>Become the first to sponsor our upcoming events!</p>
            </div>
            @endforelse
        </div>
    </div>
</section>
@endsection