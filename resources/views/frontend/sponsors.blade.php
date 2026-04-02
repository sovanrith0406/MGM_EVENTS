@extends('frontend.layouts.app')
@section('title', 'Sponsors — MGM Event')
@section('nav_sponsors', 'active')
@section('content')

{{-- Page Header --}}
<div class="page-header">
    <h1 class="fw-bold">Our Sponsors</h1>
    <p class="text-secondary">Meet the companies and organizations powering our events</p>
</div>

<section class="py-5">
    <div class="container">
        <div class="row g-4 justify-content-center">
            @forelse($sponsors as $sponsor)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="sponsor-card card border-0 shadow-sm text-center p-4 h-100 d-flex flex-column align-items-center justify-content-center">

                    {{-- Logo --}}
                    @if($sponsor->logo_url)
                        <img src="{{ asset($sponsor->logo_url) }}"
                             class="sponsor-logo mb-3"
                             alt="{{ $sponsor->name }}"
                             onerror="this.replaceWith(Object.assign(document.createElement('div'), {textContent:'🏢', style:'font-size:40px;margin-bottom:12px'}))">
                    @else
                        <div class="mb-3" style="font-size:40px;">🏢</div>
                    @endif

                    <h6 class="fw-bold mb-2">{{ $sponsor->name }}</h6>

                    @if(isset($sponsor->tier))
                        <span class="badge tier-{{ strtolower($sponsor->tier) }} mb-2">
                            {{ ucfirst($sponsor->tier) }}
                        </span>
                    @endif

                    @if($sponsor->website)
                        <a href="{{ $sponsor->website }}" target="_blank"
                           class="small text-primary text-decoration-none d-block mb-1">
                            <i class="fas fa-globe me-1"></i> Visit Website
                        </a>
                    @endif

                    @if($sponsor->contact_name)
                        <p class="small text-secondary mb-0">
                            Contact: {{ $sponsor->contact_name }}
                        </p>
                    @endif
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5 text-secondary">
                <i class="fas fa-handshake mb-3 d-block" style="font-size:56px; color:#cbd5e1;"></i>
                No sponsors found.
            </div>
            @endforelse
        </div>
    </div>
</section>
@endsection