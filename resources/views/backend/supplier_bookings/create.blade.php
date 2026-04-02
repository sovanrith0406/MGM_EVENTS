@extends('backend.layouts.master')
@section('title', 'Add Supplier Booking | Event')

@section('main-content')
<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"><h1>Add Supplier Booking</h1></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('supplier_booking.index') }}">Supplier Bookings</a>
                        </li>
                        <li class="breadcrumb-item active">Add Booking</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Booking Information</h3>
                </div>

                <form action="{{ route('supplier_booking.store') }}" method="POST">
                    @csrf
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
                                        {{ old('event_id') == $event->event_id ? 'selected' : '' }}>
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
                            $selectedEvent = old('event_id')
                                ? $events->firstWhere('event_id', old('event_id'))
                                : null;
                        @endphp

                        <div class="form-group" id="price_preview_group"
                             style="{{ $selectedEvent ? '' : 'display:none;' }}">
                            <label>Event Price</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="currency_label">
                                        {{ $selectedEvent->currency ?? 'USD' }}
                                    </span>
                                </div>
                                <input type="text" id="price_preview" class="form-control"
                                       value="{{ $selectedEvent ? number_format($selectedEvent->price, 2) : '' }}"
                                       readonly style="background:#f4f6f9; cursor:not-allowed; font-weight:600;">
                            </div>
                            <small class="text-muted">Price is taken from the event and cannot be modified.</small>
                        </div>

                        <input type="hidden" name="amount"   id="amount"
                               value="{{ $selectedEvent ? $selectedEvent->price : '' }}">
                        <input type="hidden" name="currency" id="currency_hidden"
                               value="{{ $selectedEvent->currency ?? 'USD' }}">

                        {{-- Track --}}
                        <div class="form-group" id="track_group" style="{{ $selectedEvent ? '' : 'display:none;' }}">
                            <label for="track_id">Track</label>
                            <select name="track_id" id="track_id"
                                    class="form-control @error('track_id') is-invalid @enderror">
                                <option value="">-- Select Track (Optional) --</option>
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
                                   value="{{ old('supplier_name') }}"
                                   placeholder="e.g. ABC Catering Co.">
                            @error('supplier_name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" rows="3"
                                      class="form-control @error('description') is-invalid @enderror"
                                      placeholder="Optional notes about this booking">{{ old('description') }}</textarea>
                            @error('description')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Booking Date --}}
                        <div class="form-group">
                            <label for="booking_date">Booking Date <span class="text-danger">*</span></label>
                            <input type="date" name="booking_date" id="booking_date"
                                   class="form-control @error('booking_date') is-invalid @enderror"
                                   value="{{ old('booking_date') }}">
                            @error('booking_date')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Status --}}
                        <div class="form-group">
                            <label for="status">Status <span class="text-danger">*</span></label>
                            <select name="status" id="status"
                                    class="form-control @error('status') is-invalid @enderror">
                                <option value="pending"   {{ old('status', 'pending') == 'pending'   ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ old('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="paid"      {{ old('status') == 'paid'      ? 'selected' : '' }}>Paid</option>
                                <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            @error('status')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i> Save Booking
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
    const amountHidden   = document.getElementById('amount');
    const currencyHidden = document.getElementById('currency_hidden');
    const priceGroup     = document.getElementById('price_preview_group');
    const pricePreview   = document.getElementById('price_preview');
    const currencyLabel  = document.getElementById('currency_label');
    const trackGroup     = document.getElementById('track_group');
    const trackSelect    = document.getElementById('track_id');
    const oldTrackId     = "{{ old('track_id') }}";

    function loadTracks(eventId, selectedTrackId = null) {
        trackSelect.innerHTML = '<option value="">-- Select Track (Optional) --</option>';

        if (!eventId) {
            trackGroup.style.display = 'none';
            return;
        }

        fetch(`{{ route('supplier_booking.tracks_by_event') }}?event_id=${eventId}`)
            .then(r => r.json())
            .then(tracks => {
                if (tracks.length === 0) {
                    trackGroup.style.display = 'none';
                    return;
                }
                tracks.forEach(t => {
                    const opt = document.createElement('option');
                    opt.value       = t.track_id;
                    opt.textContent = t.track_name;
                    if (selectedTrackId && t.track_id == selectedTrackId) opt.selected = true;
                    trackSelect.appendChild(opt);
                });
                trackGroup.style.display = 'block';
            });
    }

    function fillFromEvent(eventId) {
        const opt = eventSelect.querySelector(`option[value="${eventId}"]`);

        if (!opt || !eventId) {
            amountHidden.value        = '';
            currencyHidden.value      = 'USD';
            pricePreview.value        = '';
            currencyLabel.textContent = 'USD';
            priceGroup.style.display  = 'none';
            trackGroup.style.display  = 'none';
            trackSelect.innerHTML     = '<option value="">-- Select Track (Optional) --</option>';
            return;
        }

        const price    = parseFloat(opt.dataset.price || 0).toFixed(2);
        const currency = opt.dataset.currency || 'USD';

        amountHidden.value        = price;
        currencyHidden.value      = currency;
        pricePreview.value        = price;
        currencyLabel.textContent = currency;
        priceGroup.style.display  = 'block';

        loadTracks(eventId, oldTrackId);
    }

    eventSelect.addEventListener('change', function () {
        fillFromEvent(this.value);
    });

    // On page load — restore state after validation failure
    if (eventSelect.value) {
        fillFromEvent(eventSelect.value);
    }
});
</script>
@endpush