@extends('backend.layouts.master')
@section('title', 'Edit Supplier Booking | Event')

@section('main-content')
<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Supplier Booking</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('supplier_booking.index') }}">Supplier Bookings</a>
                        </li>
                        <li class="breadcrumb-item active">Edit Booking</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">Edit Booking Information</h3>
                </div>

                <form action="{{ route('supplier_booking.update', $supplier_booking->booking_id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Event --}}
                        <div class="form-group">
                            <label for="event_id">Event <span class="text-danger">*</span></label>
                            <select name="event_id" id="event_id"
                                    class="form-control @error('event_id') is-invalid @enderror">
                                <option value="">-- Select Event --</option>
                                @foreach($events as $event)
                                    <option value="{{ $event->event_id }}"
                                            data-price="{{ $event->price }}"
                                            data-currency="{{ $event->currency ?? 'USD' }}"
                                        {{ old('event_id', $supplier_booking->event_id) == $event->event_id ? 'selected' : '' }}>
                                        {{ $event->event_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('event_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Price Preview --}}
                        @php
                            $previewEventId = old('event_id', $supplier_booking->event_id);
                            $previewEvent   = $events->firstWhere('event_id', $previewEventId);
                        @endphp

                        <div class="form-group" id="price_preview_group"
                             style="{{ $previewEvent ? '' : 'display:none;' }}">
                            <label>Event Price</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="currency_label">
                                        {{ $previewEvent->currency ?? 'USD' }}
                                    </span>
                                </div>
                                <input type="text" id="price_preview" class="form-control"
                                       value="{{ $previewEvent ? number_format($previewEvent->price, 2) : '' }}"
                                       readonly style="background:#f4f6f9; cursor:not-allowed; font-weight:600;">
                            </div>
                            <small class="text-muted">Price is taken from the event and cannot be modified.</small>
                        </div>

                        {{-- Track --}}
                        <div class="form-group" id="track_group">
                            <label for="track_id">Track</label>
                            <select name="track_id" id="track_id"
                                    class="form-control @error('track_id') is-invalid @enderror">
                                <option value="">-- Select Track (Optional) --</option>
                                @foreach($tracks as $track)
                                    <option value="{{ $track->track_id }}"
                                        {{ old('track_id', $supplier_booking->track_id) == $track->track_id ? 'selected' : '' }}>
                                        {{ $track->track_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('track_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Supplier Name --}}
                        <div class="form-group">
                            <label for="supplier_name">Supplier Name <span class="text-danger">*</span></label>
                            <input type="text" name="supplier_name" id="supplier_name"
                                   class="form-control @error('supplier_name') is-invalid @enderror"
                                   value="{{ old('supplier_name', $supplier_booking->supplier_name) }}">
                            @error('supplier_name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" rows="3"
                                      class="form-control @error('description') is-invalid @enderror"
                                      placeholder="Optional notes about this booking">{{ old('description', $supplier_booking->description) }}</textarea>
                            @error('description')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Booking Date --}}
                        <div class="form-group">
                            <label for="booking_date">Booking Date <span class="text-danger">*</span></label>
                            <input type="date" name="booking_date" id="booking_date"
                                   class="form-control @error('booking_date') is-invalid @enderror"
                                   value="{{ old('booking_date', \Carbon\Carbon::parse($supplier_booking->booking_date)->format('Y-m-d')) }}">
                            @error('booking_date')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Status --}}
                        <div class="form-group">
                            <label for="status">Status <span class="text-danger">*</span></label>
                            <select name="status" id="status"
                                    class="form-control @error('status') is-invalid @enderror">
                                <option value="pending"   {{ old('status', $supplier_booking->status) == 'pending'   ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ old('status', $supplier_booking->status) == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="paid"      {{ old('status', $supplier_booking->status) == 'paid'      ? 'selected' : '' }}>Paid</option>
                                <option value="cancelled" {{ old('status', $supplier_booking->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            @error('status')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save mr-1"></i> Update Booking
                        </button>
                        <a href="{{ route('supplier_booking.index') }}" class="btn btn-secondary ml-2">
                            <i class="fas fa-times mr-1"></i> Cancel
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const eventSelect    = document.getElementById('event_id');
    const priceGroup     = document.getElementById('price_preview_group');
    const pricePreview   = document.getElementById('price_preview');
    const currencyLabel  = document.getElementById('currency_label');
    const trackGroup     = document.getElementById('track_group');
    const trackSelect    = document.getElementById('track_id');
    const oldTrackId     = "{{ old('track_id', $supplier_booking->track_id) }}";

    function loadTracks(eventId, selectedTrackId = null) {
        trackSelect.innerHTML = '<option value="">-- Select Track (Optional) --</option>';

        if (!eventId) return;

        fetch(`{{ route('supplier_booking.tracks_by_event') }}?event_id=${eventId}`)
            .then(r => r.json())
            .then(tracks => {
                tracks.forEach(t => {
                    const opt = document.createElement('option');
                    opt.value       = t.track_id;
                    opt.textContent = t.track_name;
                    if (selectedTrackId && t.track_id == selectedTrackId) opt.selected = true;
                    trackSelect.appendChild(opt);
                });
            });
    }

    function updatePreview(eventId) {
        const opt = eventSelect.querySelector(`option[value="${eventId}"]`);
        if (!opt || !eventId) {
            priceGroup.style.display  = 'none';
            pricePreview.value        = '';
            currencyLabel.textContent = 'USD';
            return;
        }
        pricePreview.value        = parseFloat(opt.dataset.price || 0).toFixed(2);
        currencyLabel.textContent = opt.dataset.currency || 'USD';
        priceGroup.style.display  = 'block';

        loadTracks(eventId, oldTrackId);
    }

    eventSelect.addEventListener('change', function () {
        updatePreview(this.value);
    });

    // On page load — pre-load tracks for the current event
    if (eventSelect.value) {
        loadTracks(eventSelect.value, oldTrackId);
    }
});
</script>
@endpush