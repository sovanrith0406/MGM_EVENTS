@extends('backend.layouts.master')
@section('title', 'Create Schedule | Event')
@section('sc_menu-open', 'menu-open')
@section('sc_active', 'active')

@section('main-content')
<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Schedule</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('/schedule') }}">Schedule</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">New Session Details</h3>
                </div>

                <form action="{{ url('/schedule') }}" method="POST">
                    @csrf
                    <div class="card-body">

                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="row">

                            {{-- Title --}}
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="title">Session Title <span class="text-danger">*</span></label>
                                    <input type="text" name="title" id="title"
                                           class="form-control @error('title') is-invalid @enderror"
                                           value="{{ old('title') }}"
                                           placeholder="e.g. Opening Keynote" required>
                                    @error('title')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                </div>
                            </div>

                            {{-- Session Type --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="session_type">Session Type <span class="text-danger">*</span></label>
                                    <select name="session_type" id="session_type"
                                            class="form-control @error('session_type') is-invalid @enderror" required>
                                        <option value="">-- Select Type --</option>
                                        @foreach(['talk'=>'Talk','workshop'=>'Workshop','panel'=>'Panel','keynote'=>'Keynote','break'=>'Break','networking'=>'Networking'] as $val => $label)
                                            <option value="{{ $val }}" {{ old('session_type') == $val ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @error('session_type')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                </div>
                            </div>

                            {{-- Event --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="event_id">Event <span class="text-danger">*</span></label>
                                    <select name="event_id" id="event_id"
                                            class="form-control @error('event_id') is-invalid @enderror" required>
                                        <option value="">-- Select Event --</option>
                                        @foreach($events as $event)
                                            <option value="{{ $event->event_id }}"
                                                    data-start="{{ $event->start_date ? \Carbon\Carbon::parse($event->start_date)->format('Y-m-d\TH:i') : '' }}"
                                                    data-end="{{ $event->end_date ? \Carbon\Carbon::parse($event->end_date)->format('Y-m-d\TH:i') : '' }}"
                                                    {{ old('event_id') == $event->event_id ? 'selected' : '' }}>
                                                {{ $event->event_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('event_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                </div>
                            </div>

                            {{-- Track (filtered by event_id) --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="track_id">Track</label>
                                    <select name="track_id" id="track_id"
                                            class="form-control @error('track_id') is-invalid @enderror">
                                        <option value="">-- Select Track --</option>
                                        @foreach($tracks as $track)
                                            <option value="{{ $track->track_id }}"
                                                    data-event="{{ $track->event_id }}"
                                                    {{ old('track_id') == $track->track_id ? 'selected' : '' }}>
                                                {{ $track->track_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('track_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                </div>
                            </div>

                            {{-- Room (filtered by venue_id via event) --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="room_id">Room</label>
                                    <select name="room_id" id="room_id"
                                            class="form-control @error('room_id') is-invalid @enderror">
                                        <option value="">-- Select Room --</option>
                                        @foreach($rooms as $room)
                                            <option value="{{ $room->room_id }}"
                                                    data-venue="{{ $room->venue_id }}"
                                                    {{ old('room_id') == $room->room_id ? 'selected' : '' }}>
                                                {{ $room->room_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('room_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                </div>
                            </div>

                            {{-- Start Time --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="start_time">Start Time <span class="text-danger">*</span></label>
                                    <input type="datetime-local" name="start_time" id="start_time"
                                           class="form-control @error('start_time') is-invalid @enderror"
                                           value="{{ old('start_time') }}" required>
                                    @error('start_time')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                    <small id="start_time_hint" class="text-muted"></small>
                                </div>
                            </div>

                            {{-- End Time --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="end_time">End Time <span class="text-danger">*</span></label>
                                    <input type="datetime-local" name="end_time" id="end_time"
                                           class="form-control @error('end_time') is-invalid @enderror"
                                           value="{{ old('end_time') }}" required>
                                    @error('end_time')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                    <small id="end_time_hint" class="text-muted"></small>
                                </div>
                            </div>

                            {{-- Speaker Picker --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Speaker(s)</label>

                                    <div id="speaker-hidden-inputs">
                                        @foreach(old('speaker_ids', []) as $sid)
                                            <input type="hidden" name="speaker_ids[]" value="{{ $sid }}">
                                        @endforeach
                                    </div>

                                    <div id="speaker-display"
                                         class="form-control d-flex flex-wrap align-items-center"
                                         style="min-height:42px; height:auto; cursor:pointer;"
                                         data-toggle="modal" data-target="#speakerModal">
                                        <span id="speaker-placeholder" class="text-muted">
                                            <i class="fas fa-user-plus mr-1"></i> Click to choose speakers...
                                        </span>
                                    </div>
                                    <small class="text-muted">Click the field to open speaker selection</small>

                                    @error('speaker_ids')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Speaker Role --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="speaker_role">Speaker Role</label>
                                    <select name="speaker_role" id="speaker_role" class="form-control">
                                        @foreach(['speaker'=>'Speaker','co-speaker'=>'Co-Speaker','moderator'=>'Moderator','panelist'=>'Panelist'] as $val => $label)
                                            <option value="{{ $val }}" {{ old('speaker_role') == $val ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Capacity --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="capacity">Capacity</label>
                                    <input type="number" name="capacity" id="capacity"
                                           class="form-control @error('capacity') is-invalid @enderror"
                                           value="{{ old('capacity') }}" placeholder="e.g. 200" min="1">
                                    @error('capacity')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                </div>
                            </div>

                            {{-- Status --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="status">Status <span class="text-danger">*</span></label>
                                    <select name="status" id="status"
                                            class="form-control @error('status') is-invalid @enderror" required>
                                        @foreach(['pending'=>'Pending','confirmed'=>'Confirmed',] as $val => $label)
                                            <option value="{{ $val }}" {{ old('status', 'draft') == $val ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('status')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                </div>
                            </div>

                            {{-- Description --}}
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="description" rows="4"
                                              class="form-control @error('description') is-invalid @enderror"
                                              placeholder="Brief description of the session...">{{ old('description') }}</textarea>
                                    @error('description')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                </div>
                            </div>

                        </div>{{-- end .row --}}
                    </div>{{-- end .card-body --}}

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i> Save Schedule
                        </button>
                        <a href="{{ url('/schedule') }}" class="btn btn-secondary ml-2">
                            <i class="fas fa-times mr-1"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

{{-- ══════════════════════════════════════════════════════
     SPEAKER MODAL
══════════════════════════════════════════════════════ --}}
<div class="modal fade" id="speakerModal" tabindex="-1" role="dialog" aria-labelledby="speakerModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="speakerModalLabel">
                    <i class="fas fa-user-tie mr-2"></i> Select Speaker(s)
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                    </div>
                    <input type="text" id="speaker-search"
                           class="form-control" placeholder="Search by name or company...">
                </div>

                <div class="row" id="speaker-list">
                    @forelse($speakers as $speaker)
                        <div class="col-md-6 col-lg-4 mb-3 speaker-item"
                             data-name="{{ strtolower($speaker->full_name) }}"
                             data-company="{{ strtolower($speaker->company ?? '') }}">

                            <div class="speaker-card card card-body p-2 h-100"
                                 data-id="{{ $speaker->speaker_id }}"
                                 style="cursor:pointer; border:2px solid #dee2e6; transition: border-color .2s, background .2s;">

                                <div class="d-flex align-items-center">
                                    <input type="checkbox"
                                           class="speaker-checkbox mr-2"
                                           value="{{ $speaker->speaker_id }}"
                                           data-name="{{ $speaker->full_name }}"
                                           data-company="{{ $speaker->company ?? 'N/A' }}"
                                           {{ in_array($speaker->speaker_id, old('speaker_ids', [])) ? 'checked' : '' }}
                                           style="width:16px; height:16px; cursor:pointer;">

                                    {{-- <img src="{{ auth()->user()->photo_url ? asset(auth()->user()->photo_url) : asset('backend/dist/img/avatar5.png') }}"
                                        class="img-circle mr-2"
                                        style="width:40px; height:40px; object-fit:cover;"> --}}
                                    <div class="overflow-hidden">
                                        <strong class="d-block text-truncate" style="font-size:13px;">
                                            {{ $speaker->full_name }}
                                        </strong>
                                        <small class="text-muted d-block text-truncate">
                                            {{ $speaker->title ?? '' }}
                                            @if(!empty($speaker->company))
                                                &mdash; {{ $speaker->company }}
                                            @endif
                                        </small>
                                    </div>
                                </div>

                                <span class="selected-tick text-primary"
                                      style="position:absolute; top:6px; right:8px; display:none; font-size:16px;">
                                    <i class="fas fa-check-circle"></i>
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center text-muted py-4">No speakers found.</div>
                    @endforelse
                </div>

            </div>

            <div class="modal-footer d-flex justify-content-between align-items-center">
                <span id="modal-selected-count" class="badge badge-primary badge-pill px-3 py-2" style="font-size:13px;">
                    0 selected
                </span>
                <div>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Cancel
                    </button>
                    <button type="button" class="btn btn-primary" id="btn-confirm-speakers" data-dismiss="modal">
                        <i class="fas fa-check mr-1"></i> Confirm
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════
     SCRIPT
══════════════════════════════════════════════════════ --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    // ══════════════════════════════════════════════════
    // 1. EVENT → TRACK & ROOM FILTERING
    // ══════════════════════════════════════════════════
    const eventVenueMap = @json($eventVenueMap); // { event_id: venue_id, ... }

    const eventSelect = document.getElementById('event_id');
    const trackSelect = document.getElementById('track_id');
    const roomSelect  = document.getElementById('room_id');
    const startInput  = document.getElementById('start_time');
    const endInput    = document.getElementById('end_time');
    const startHint   = document.getElementById('start_time_hint');
    const endHint     = document.getElementById('end_time_hint');

    // Snapshot ALL options once before any filtering
    const allTrackOptions = Array.from(trackSelect.querySelectorAll('option')).map(o => o.cloneNode(true));
    const allRoomOptions  = Array.from(roomSelect.querySelectorAll('option')).map(o => o.cloneNode(true));

    function filterByEvent(eventId) {
        const venueId  = eventId ? String(eventVenueMap[eventId] ?? '') : '';
        const oldTrack = trackSelect.value;
        const oldRoom  = roomSelect.value;

        // ── Filter Tracks by event_id ──
        trackSelect.innerHTML = '';
        allTrackOptions.forEach(opt => {
            if (!opt.value || !eventId || opt.dataset.event == eventId) {
                const clone = opt.cloneNode(true);
                if (clone.value === oldTrack) clone.selected = true;
                trackSelect.appendChild(clone);
            }
        });

        // ── Filter Rooms by venue_id ──
        roomSelect.innerHTML = '';
        allRoomOptions.forEach(opt => {
            if (!opt.value || !venueId || opt.dataset.venue == venueId) {
                const clone = opt.cloneNode(true);
                if (clone.value === oldRoom) clone.selected = true;
                roomSelect.appendChild(clone);
            }
        });
    }

    // ══════════════════════════════════════════════════
    // 2. EVENT → START TIME & END TIME CONSTRAINTS
    // ══════════════════════════════════════════════════
    function formatHint(datetimeLocal) {
        if (!datetimeLocal) return '';
        const d = new Date(datetimeLocal);
        return d.toLocaleString('en-GB', {
            day: '2-digit', month: 'short', year: 'numeric',
            hour: '2-digit', minute: '2-digit'
        });
    }

    function applyDateConstraints(eventId) {
        const selectedOption = eventSelect.querySelector(`option[value="${eventId}"]`);

        if (!selectedOption || !eventId) {
            startInput.removeAttribute('min');
            startInput.removeAttribute('max');
            endInput.removeAttribute('min');
            endInput.removeAttribute('max');
            startHint.textContent = '';
            endHint.textContent   = '';
            return;
        }

        const eventStart = selectedOption.dataset.start; // "2025-06-01T08:00"
        const eventEnd   = selectedOption.dataset.end;   // "2025-06-03T18:00"

        startInput.min = eventStart;
        startInput.max = eventEnd;
        endInput.min   = eventStart;
        endInput.max   = eventEnd;

        // Show human-readable hint below each field
        startHint.textContent = `Allowed: ${formatHint(eventStart)} → ${formatHint(eventEnd)}`;
        endHint.textContent   = `Allowed: ${formatHint(eventStart)} → ${formatHint(eventEnd)}`;

        // Clear out-of-range values
        if (startInput.value && (startInput.value < eventStart || startInput.value > eventEnd)) {
            startInput.value = '';
        }
        if (endInput.value && (endInput.value < eventStart || endInput.value > eventEnd)) {
            endInput.value = '';
        }
    }

    // End time must always be >= start time
    startInput.addEventListener('change', function () {
        if (this.value) {
            endInput.min = this.value;
            if (endInput.value && endInput.value < this.value) endInput.value = '';
        }
    });

    // ── Wire event change ──
    eventSelect.addEventListener('change', function () {
        filterByEvent(this.value);
        applyDateConstraints(this.value);
    });

    // ── Run on page load (handles old() after validation fail) ──
    filterByEvent(eventSelect.value);
    applyDateConstraints(eventSelect.value);


    // ══════════════════════════════════════════════════
    // 3. SPEAKER PICKER
    // ══════════════════════════════════════════════════
    const display     = document.getElementById('speaker-display');
    const hiddenWrap  = document.getElementById('speaker-hidden-inputs');
    const placeholder = document.getElementById('speaker-placeholder');
    const countBadge  = document.getElementById('modal-selected-count');
    const searchInput = document.getElementById('speaker-search');

    function styleCard(cb) {
        const card = cb.closest('.speaker-card');
        const tick = card.querySelector('.selected-tick');
        if (cb.checked) {
            card.style.borderColor = '#007bff';
            card.style.background  = '#e8f0fe';
            tick.style.display     = 'block';
        } else {
            card.style.borderColor = '#dee2e6';
            card.style.background  = '';
            tick.style.display     = 'none';
        }
    }

    function refreshCount() {
        const n = document.querySelectorAll('.speaker-checkbox:checked').length;
        countBadge.textContent = n + ' selected';
    }

    document.querySelectorAll('.speaker-checkbox').forEach(cb => {
        styleCard(cb);
        cb.closest('.speaker-card').addEventListener('click', function (e) {
            if (e.target !== cb) cb.checked = !cb.checked;
            styleCard(cb);
            refreshCount();
        });
    });
    refreshCount();

    document.getElementById('btn-confirm-speakers').addEventListener('click', function () {
        const checked = document.querySelectorAll('.speaker-checkbox:checked');

        hiddenWrap.innerHTML = '';
        display.innerHTML    = '';

        if (checked.length === 0) {
            display.appendChild(placeholder);
            return;
        }

        checked.forEach(cb => {
            const input = document.createElement('input');
            input.type  = 'hidden';
            input.name  = 'speaker_ids[]';
            input.value = cb.value;
            hiddenWrap.appendChild(input);

            const badge          = document.createElement('span');
            badge.className      = 'badge badge-primary d-inline-flex align-items-center mr-1 mb-1 px-2 py-1';
            badge.style.fontSize = '12px';
            badge.innerHTML      = `<i class="fas fa-user mr-1"></i>${cb.dataset.name}
                <span class="ml-2 remove-badge" data-val="${cb.value}"
                      style="cursor:pointer; font-size:14px; line-height:1;">&times;</span>`;

            badge.querySelector('.remove-badge').addEventListener('click', function (e) {
                e.stopPropagation();
                const val  = this.dataset.val;
                const cbEl = document.querySelector(`.speaker-checkbox[value="${val}"]`);
                if (cbEl) { cbEl.checked = false; styleCard(cbEl); refreshCount(); }
                hiddenWrap.querySelector(`input[value="${val}"]`)?.remove();
                badge.remove();
                if (!display.querySelector('.badge')) display.appendChild(placeholder);
            });

            display.appendChild(badge);
        });
    });

    searchInput.addEventListener('input', function () {
        const q = this.value.toLowerCase().trim();
        document.querySelectorAll('.speaker-item').forEach(item => {
            item.style.display =
                (item.dataset.name.includes(q) || item.dataset.company.includes(q)) ? '' : 'none';
        });
    });

    document.getElementById('speakerModal').addEventListener('hidden.bs.modal', function () {
        searchInput.value = '';
        document.querySelectorAll('.speaker-item').forEach(i => i.style.display = '');
    });

});
</script>
@endsection