@extends('frontend.layouts.app')
@section('title', 'Register Interest — ' . $event->event_name)
@section('nav_events', 'active')
@section('content')

{{-- Page Header --}}
<div class="page-header">
    <span class="badge badge-published px-3 py-2 rounded-pill mb-3 d-inline-block" style="font-size:12px;">
        {{ ucfirst($event->status) }}
    </span>
    <h1 class="fw-bold">Register Interest</h1>
    <p class="text-secondary mt-1">{{ $event->event_name }}</p>
</div>

<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">

                {{-- Success --}}
                @if(session('success'))
                <div class="alert alert-success d-flex align-items-center gap-2 rounded-3 mb-4">
                    <i class="fas fa-check-circle fs-5"></i>
                    <div>{{ session('success') }}</div>
                </div>
                @endif

                {{-- Event Summary --}}
                <div class="card border-0 rounded-3 mb-4 p-4" style="background:linear-gradient(135deg,#eff6ff,#f0fdf4);">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                        <div>
                            <h6 class="fw-bold mb-2">{{ $event->event_name }}</h6>
                            <div class="d-flex flex-wrap gap-3">
                                <span class="small text-secondary">
                                    <i class="fas fa-calendar-alt text-primary me-1"></i>
                                    {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}
                                    @if($event->start_date != $event->end_date)
                                        — {{ \Carbon\Carbon::parse($event->end_date)->format('d M Y') }}
                                    @endif
                                </span>
                                @if($event->venue)
                                <span class="small text-secondary">
                                    <i class="fas fa-map-marker-alt text-primary me-1"></i>
                                    {{ $event->venue->venue_name }}, {{ $event->venue->city }}
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="card-price" style="font-size:22px;">
                            {{ $event->currency }} {{ number_format($event->price, 2) }}
                        </div>
                    </div>
                </div>

                {{-- Form --}}
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body p-4 p-md-5">
                        <h5 class="fw-bold mb-4">
                            <i class="fas fa-clipboard-list text-primary me-2"></i> Your Details
                        </h5>

                        <form method="POST" action="{{ route('frontend.booking.store', $event->event_id) }}">
                            @csrf
                            <div class="row g-3">

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small">
                                        Full Name <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="supplier_name"
                                           class="form-control rounded-3 @error('supplier_name') is-invalid @enderror"
                                           value="{{ old('supplier_name', auth()->user()->name) }}"
                                           placeholder="Your full name" required>
                                    @error('supplier_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small">
                                        Email Address <span class="text-danger">*</span>
                                    </label>
                                    <input type="email" name="email"
                                           class="form-control rounded-3 @error('email') is-invalid @enderror"
                                           value="{{ old('email', auth()->user()->email) }}"
                                           placeholder="you@example.com" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small">Phone Number</label>
                                    <input type="text" name="phone"
                                           class="form-control rounded-3 @error('phone') is-invalid @enderror"
                                           value="{{ old('phone') }}"
                                           placeholder="+855 12 345 678">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small">
                                        Interest Type <span class="text-danger">*</span>
                                    </label>
                                    <select name="service_type"
                                            class="form-select rounded-3 @error('service_type') is-invalid @enderror"
                                            required>
                                        <option value="">-- Select type --</option>
                                        <option value="attendee"  {{ old('service_type') == 'attendee'  ? 'selected' : '' }}>Attendee</option>
                                        <option value="speaker"   {{ old('service_type') == 'speaker'   ? 'selected' : '' }}>Speaker</option>
                                        <option value="sponsor"   {{ old('service_type') == 'sponsor'   ? 'selected' : '' }}>Sponsor</option>
                                        <option value="vendor"    {{ old('service_type') == 'vendor'    ? 'selected' : '' }}>Vendor / Supplier</option>
                                        <option value="media"     {{ old('service_type') == 'media'     ? 'selected' : '' }}>Media / Press</option>
                                        <option value="volunteer" {{ old('service_type') == 'volunteer' ? 'selected' : '' }}>Volunteer</option>
                                        <option value="other"     {{ old('service_type') == 'other'     ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('service_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-semibold small">Additional Notes</label>
                                    <textarea name="notes" rows="4"
                                              class="form-control rounded-3 @error('notes') is-invalid @enderror"
                                              placeholder="Any additional information or questions...">{{ old('notes') }}</textarea>
                                    @error('notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 d-flex gap-3 flex-wrap mt-2">
                                    <button type="submit" class="btn btn-primary px-5 py-2 rounded-3 fw-semibold">
                                        <i class="fas fa-paper-plane me-2"></i> Submit Registration
                                    </button>
                                    <a href="{{ route('frontend.events.show', $event->event_id) }}"
                                       class="btn btn-outline-secondary px-4 py-2 rounded-3">
                                        <i class="fas fa-arrow-left me-1"></i> Back to Event
                                    </a>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection