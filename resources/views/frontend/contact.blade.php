@extends('frontend.layouts.app')
@section('title', 'Contact — MGM Event')
@section('nav_contact', 'active')
@section('content')

@push('styles')
<style>
    /* Dark Theme Form Elements */
    .form-dark {
        background-color: rgba(255,255,255,0.03) !important;
        border: 1px solid rgba(255,255,255,0.08) !important;
        color: #fff !important;
        border-radius: 8px;
        padding: 12px 16px;
    }
    .form-dark::placeholder { color: rgba(255,255,255,0.3); }
    .form-dark:focus {
        background-color: rgba(255,255,255,0.05) !important;
        border-color: var(--primary-neon) !important;
        box-shadow: 0 0 15px rgba(255, 0, 127, 0.2) !important;
    }
    
    /* Select dropdown styling fix for dark mode */
    select.form-dark option { background-color: var(--bg-card); color: #fff; }

    /* Custom Icon Boxes */
    .icon-box-neon {
        width: 50px; 
        height: 50px;
        background: rgba(255, 0, 127, 0.1);
        border: 1px solid rgba(255, 0, 127, 0.2);
        color: var(--primary-neon);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        transition: all 0.3s ease;
    }
    
    /* Success Alert */
    .alert-neon-success {
        background: rgba(16, 185, 129, 0.1);
        border: 1px solid rgba(16, 185, 129, 0.3);
        color: #10b981;
    }
</style>
@endpush

{{-- Page Header --}}
<div class="page-header py-5 text-center" style="background: radial-gradient(circle at center, rgba(255, 0, 127, 0.1) 0%, transparent 70%); border-bottom: 1px solid rgba(255,255,255,0.05);">
    <div class="container py-4">
        <h1 class="fw-bold text-white mb-3" style="font-size: clamp(32px, 5vw, 50px);">Get In <span class="text-neon">Touch</span></h1>
        <p class="text-muted-custom fs-5 mb-0">Have a question or inquiry? Our team is ready to help.</p>
    </div>
</div>

<section class="py-5">
    <div class="container py-4">

        {{-- Success Alert --}}
        @if(session('success'))
        <div class="alert alert-neon-success d-flex align-items-center gap-2 rounded-3 mb-5 p-4 shadow-sm">
            <i class="fas fa-check-circle fs-4"></i>
            <span class="fw-semibold">{{ session('success') }}</span>
        </div>
        @endif

        <div class="row g-5">

            {{-- Form Column --}}
            <div class="col-lg-7">
                <div class="p-5 rounded-4" style="background: var(--bg-card); border: 1px solid rgba(255,255,255,0.05);">
                    <h3 class="text-white fw-bold mb-4">Send a Message</h3>
                    
                    <form method="POST" action="{{ route('frontend.contact.submit') }}">
                        @csrf
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label text-white fw-semibold small letter-spacing-1">YOUR NAME <span class="text-neon">*</span></label>
                                <input type="text" name="name" class="form-control form-dark @error('name') is-invalid @enderror"
                                       value="{{ old('name') }}" placeholder="John Doe" required>
                                @error('name')
                                    <div class="invalid-feedback text-neon">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label text-white fw-semibold small letter-spacing-1">EMAIL ADDRESS <span class="text-neon">*</span></label>
                                <input type="email" name="email" class="form-control form-dark @error('email') is-invalid @enderror"
                                       value="{{ old('email') }}" placeholder="john@example.com" required>
                                @error('email')
                                    <div class="invalid-feedback text-neon">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-12">
                                <label class="form-label text-white fw-semibold small letter-spacing-1">RELATED EVENT <span class="text-muted-custom fw-normal">(Optional)</span></label>
                                <select name="event_id" class="form-select form-dark">
                                    <option value="">-- Select Event --</option>
                                    @foreach($events as $event)
                                        <option value="{{ $event->event_id }}" {{ old('event_id') == $event->event_id ? 'selected' : '' }}>
                                            {{ $event->event_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-12">
                                <label class="form-label text-white fw-semibold small letter-spacing-1">SUBJECT <span class="text-neon">*</span></label>
                                <input type="text" name="subject" class="form-control form-dark @error('subject') is-invalid @enderror"
                                       value="{{ old('subject') }}" placeholder="How can we help?" required>
                                @error('subject')
                                    <div class="invalid-feedback text-neon">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-12">
                                <label class="form-label text-white fw-semibold small letter-spacing-1">MESSAGE <span class="text-neon">*</span></label>
                                <textarea name="message" rows="5" class="form-control form-dark @error('message') is-invalid @enderror"
                                          placeholder="Type your message here..." required>{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="invalid-feedback text-neon">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn-neon w-100 py-3 rounded-3 fs-5">
                                    <i class="fas fa-paper-plane me-2"></i> Send Message
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Info Column --}}
            <div class="col-lg-5">
                <h3 class="text-white fw-bold mb-5">Contact Info</h3>

                <div class="d-flex gap-4 mb-4 align-items-center p-3 rounded-4" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
                    <div class="flex-shrink-0 icon-box-neon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div>
                        <h6 class="text-white fw-semibold mb-1">Location</h6>
                        <p class="text-muted-custom small mb-0">Phnom Penh, Cambodia</p>
                    </div>
                </div>

                <div class="d-flex gap-4 mb-4 align-items-center p-3 rounded-4" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
                    <div class="flex-shrink-0 icon-box-neon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div>
                        <h6 class="text-white fw-semibold mb-1">Email</h6>
                        <p class="text-muted-custom small mb-0">info@mgmevent.com</p>
                    </div>
                </div>

                <div class="d-flex gap-4 mb-4 align-items-center p-3 rounded-4" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
                    <div class="flex-shrink-0 icon-box-neon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <div>
                        <h6 class="text-white fw-semibold mb-1">Phone</h6>
                        <p class="text-muted-custom small mb-0">(+855) 10 33 66 20</p>
                    </div>
                </div>

                <div class="d-flex gap-4 mb-5 align-items-center p-3 rounded-4" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
                    <div class="flex-shrink-0 icon-box-neon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div>
                        <h6 class="text-white fw-semibold mb-1">Office Hours</h6>
                        <p class="text-muted-custom small mb-0">Mon–Fri, 8:00 AM – 5:00 PM (ICT)</p>
                    </div>
                </div>

                {{-- Sponsorship CTA --}}
                <div class="rounded-4 p-4 mt-4" style="background: linear-gradient(135deg, rgba(255,0,127,0.1), transparent); border: 1px solid rgba(255,0,127,0.3);">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <i class="fas fa-bullhorn fs-3 text-neon"></i>
                        <h5 class="text-white fw-bold mb-0">Want to sponsor?</h5>
                    </div>
                    <p class="text-muted-custom small mb-0" style="line-height:1.7;">
                        Contact us to learn about our exclusive sponsorship packages and discover how your brand can reach thousands of industry professionals.
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection