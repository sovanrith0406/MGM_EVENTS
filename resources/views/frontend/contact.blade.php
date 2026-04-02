@extends('frontend.layouts.app')
@section('title', 'Contact — MGM Event')
@section('nav_contact', 'active')
@section('content')

{{-- Page Header --}}
<div class="page-header">
    <h1 class="fw-bold">Contact Us</h1>
    <p class="text-secondary">Get in touch with our team for any inquiries</p>
</div>

<section class="py-5">
    <div class="container">

        {{-- Success Alert --}}
        @if(session('success'))
        <div class="alert alert-success d-flex align-items-center gap-2 rounded-3 mb-4">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
        @endif

        <div class="row g-5">

            {{-- Form --}}
            <div class="col-lg-7">
                <h5 class="fw-bold mb-4">Send us a Message</h5>
                <form method="POST" action="{{ route('frontend.contact.submit') }}">
                    @csrf

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Your Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control rounded-3 @error('name') is-invalid @enderror"
                                   value="{{ old('name') }}" placeholder="John Doe" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Email Address <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control rounded-3 @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}" placeholder="john@example.com" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold small">Related Event <span class="text-secondary fw-normal">(Optional)</span></label>
                            <select name="event_id" class="form-select rounded-3">
                                <option value="">-- Select Event --</option>
                                @foreach($events as $event)
                                    <option value="{{ $event->event_id }}"
                                        {{ old('event_id') == $event->event_id ? 'selected' : '' }}>
                                        {{ $event->event_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold small">Subject <span class="text-danger">*</span></label>
                            <input type="text" name="subject" class="form-control rounded-3 @error('subject') is-invalid @enderror"
                                   value="{{ old('subject') }}" placeholder="How can we help?" required>
                            @error('subject')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold small">Message <span class="text-danger">*</span></label>
                            <textarea name="message" rows="5"
                                      class="form-control rounded-3 @error('message') is-invalid @enderror"
                                      placeholder="Your message here..." required>{{ old('message') }}</textarea>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary w-100 py-3 rounded-3 fw-semibold">
                                <i class="fas fa-paper-plane me-2"></i> Send Message
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Info --}}
            <div class="col-lg-5">
                <h5 class="fw-bold mb-4">Get in Touch</h5>

                <div class="d-flex gap-3 mb-4">
                    <div class="flex-shrink-0 d-flex align-items-center justify-content-center rounded-3 bg-primary bg-opacity-10"
                         style="width:44px; height:44px;">
                        <i class="fas fa-map-marker-alt text-primary"></i>
                    </div>
                    <div>
                        <h6 class="fw-semibold mb-1">Location</h6>
                        <p class="text-secondary small mb-0">Phnom Penh, Cambodia</p>
                    </div>
                </div>

                <div class="d-flex gap-3 mb-4">
                    <div class="flex-shrink-0 d-flex align-items-center justify-content-center rounded-3 bg-primary bg-opacity-10"
                         style="width:44px; height:44px;">
                        <i class="fas fa-envelope text-primary"></i>
                    </div>
                    <div>
                        <h6 class="fw-semibold mb-1">Email</h6>
                        <p class="text-secondary small mb-0">info@mgmevent.com</p>
                    </div>
                </div>

                <div class="d-flex gap-3 mb-4">
                    <div class="flex-shrink-0 d-flex align-items-center justify-content-center rounded-3 bg-primary bg-opacity-10"
                         style="width:44px; height:44px;">
                        <i class="fas fa-phone text-primary"></i>
                    </div>
                    <div>
                        <h6 class="fw-semibold mb-1">Phone</h6>
                        <p class="text-secondary small mb-0">(+855) 10 33 66 20</p>
                    </div>
                </div>

                <div class="d-flex gap-3 mb-4">
                    <div class="flex-shrink-0 d-flex align-items-center justify-content-center rounded-3 bg-primary bg-opacity-10"
                         style="width:44px; height:44px;">
                        <i class="fas fa-clock text-primary"></i>
                    </div>
                    <div>
                        <h6 class="fw-semibold mb-1">Office Hours</h6>
                        <p class="text-secondary small mb-0">Mon–Fri, 8:00 AM – 5:00 PM (ICT)</p>
                    </div>
                </div>

                {{-- Sponsorship CTA --}}
                <div class="card border-0 rounded-3 p-4 mt-2" style="background:#f8fafc;">
                    <p class="small text-secondary mb-0" style="line-height:1.7;">
                        <strong class="text-dark">Want to become a sponsor?</strong><br>
                        Contact us to learn about our sponsorship packages and how your brand can reach thousands of attendees.
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection