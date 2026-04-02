@extends('backend.layouts.master')
@section('title', 'Edit Schedule | Event')
@section('sc_menu-open', 'menu-open')
@section('sc_active', 'active')

@section('main-content')
<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Schedule</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('/schedule') }}">Schedule</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">Edit Session: <strong>{{ $schedule->title }}</strong></h3>
                </div>

                <form action="{{ url('/schedule/' . $schedule->schedule_id) }}" method="POST">
                    @csrf
                    @method('PUT')
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
                                           value="{{ old('title', $schedule->title) }}"
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
                                            <option value="{{ $val }}"
                                                {{ old('session_type', $schedule->session_type) == $val ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
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
                                                {{ old('event_id', $schedule->event_id) == $event->event_id ? 'selected' : '' }}>
                                                {{ $event->event_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('event_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                </div>
                            </div>

                            {{-- Track --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="track_id">Track</label>
                                    <select name="track_id" id="track_id"
                                            class="form-control @error('track_id') is-invalid @enderror">
                                        <option value="">-- Select Track --</option>
                                        @foreach($tracks as $track)
                                            <option value="{{ $track->track_id }}"
                                                {{ old('track_id', $schedule->track_id) == $track->track_id ? 'selected' : '' }}>
                                                {{ $track->track_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('track_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                </div>
                            </div>

                            {{-- Room --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="room_id">Room</label>
                                    <select name="room_id" id="room_id"
                                            class="form-control @error('room_id') is-invalid @enderror">
                                        <option value="">-- Select Room --</option>
                                        @foreach($rooms as $room)
                                            <option value="{{ $room->room_id }}"
                                                {{ old('room_id', $schedule->room_id) == $room->room_id ? 'selected' : '' }}>
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
                                           value="{{ old('start_time', \Carbon\Carbon::parse($schedule->start_time)->format('Y-m-d\TH:i')) }}"
                                           required>
                                    @error('start_time')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                </div>
                            </div>

                            {{-- End Time --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="end_time">End Time <span class="text-danger">*</span></label>
                                    <input type="datetime-local" name="end_time" id="end_time"
                                           class="form-control @error('end_time') is-invalid @enderror"
                                           value="{{ old('end_time', \Carbon\Carbon::parse($schedule->end_time)->format('Y-m-d\TH:i')) }}"
                                           required>
                                    @error('end_time')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                </div>
                            </div>

                            {{-- ── Speaker Picker ──────────────────────────────── --}}
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Speaker(s)</label>

                                    {{-- Hidden inputs for form submission --}}
                                    <div id="speaker-hidden-inputs">
                                        @foreach($selectedSpeakerIds as $sid)
                                            <input type="hidden" name="speaker_ids[]" value="{{ $sid }}">
                                        @endforeach
                                    </div>

                                    {{-- Clickable display field --}}
                                    <div id="speaker-display"
                                         class="form-control d-flex flex-wrap align-items-center"
                                         style="min-height:42px; height:auto; cursor:pointer;"
                                         data-toggle="modal" data-target="#speakerModal">
                                        <span id="speaker-placeholder" class="text-muted"
                                              style="{{ count($selectedSpeakerIds) > 0 ? 'display:none' : '' }}">
                                            <i class="fas fa-user-plus mr-1"></i> Click to choose speakers...
                                        </span>
                                        {{-- Pre-fill badges for existing speakers --}}
                                        @foreach($assignedSpeakers as $sp)
                                            <span class="badge badge-primary d-inline-flex align-items-center mr-1 mb-1 px-2 py-1 pre-badge"
                                                  style="font-size:12px;" data-val="{{ $sp->speaker_id }}">
                                                <i class="fas fa-user mr-1"></i>{{ $sp->full_name }}
                                                <span class="ml-2 remove-badge" data-val="{{ $sp->speaker_id }}"
                                                      style="cursor:pointer; font-size:14px; line-height:1;">&times;</span>
                                            </span>
                                        @endforeach
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
                                            <option value="{{ $val }}"
                                                {{ old('speaker_role', $currentRole) == $val ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
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
                                           value="{{ old('capacity', $schedule->capacity) }}"
                                           placeholder="e.g. 200" min="1">
                                    @error('capacity')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                </div>
                            </div>

                            {{-- Status --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="status">Status <span class="text-danger">*</span></label>
                                    <select name="status" id="status"
                                            class="form-control @error('status') is-invalid @enderror" required>
                                        @foreach(['draft'=>'Draft','confirmed'=>'Confirmed','cancelled'=>'Cancelled'] as $val => $label)
                                            <option value="{{ $val }}"
                                                {{ old('status', $schedule->status) == $val ? 'selected' : '' }}>
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
                                              placeholder="Brief description of the session...">{{ old('description', $schedule->description) }}</textarea>
                                    @error('description')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                </div>
                            </div>

                        </div>{{-- end .row --}}
                    </div>{{-- end .card-body --}}

                    <div class="card-footer">
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save mr-1"></i> Update Schedule
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
<div class="modal fade" id="speakerModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header bg-warning">
                <h5 class="modal-title">
                    <i class="fas fa-user-tie mr-2"></i> Select Speaker(s)
                </h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>

            <div class="modal-body">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                    </div>
                    <input type="text" id="speaker-search" class="form-control"
                           placeholder="Search by name or company...">
                </div>

                <div class="row" id="speaker-list">
                    @forelse($speakers as $speaker)
                        <div class="col-md-6 col-lg-4 mb-3 speaker-item"
                             data-name="{{ strtolower($speaker->full_name) }}"
                             data-company="{{ strtolower($speaker->company ?? '') }}">

                            <div class="speaker-card card card-body p-2 h-100"
                                 data-id="{{ $speaker->speaker_id }}"
                                 style="cursor:pointer; border:2px solid #dee2e6; transition: border-color .2s, background .2s; position:relative;">

                                <div class="d-flex align-items-center">
                                    <input type="checkbox"
                                           class="speaker-checkbox mr-2"
                                           value="{{ $speaker->speaker_id }}"
                                           data-name="{{ $speaker->full_name }}"
                                           data-company="{{ $speaker->company ?? 'N/A' }}"
                                           {{ in_array($speaker->speaker_id, old('speaker_ids', $selectedSpeakerIds)) ? 'checked' : '' }}
                                           style="width:16px; height:16px; cursor:pointer;">

                                    {{-- <img src="{{ asset('backend/dist/img/avatar.png') }}"
                                         class="img-circle mr-2"
                                         style="width:40px; height:40px; object-fit:cover;"> --}}

                                    <div class="overflow-hidden">
                                        <strong class="d-block text-truncate" style="font-size:13px;">
                                            {{ $speaker->full_name }}
                                        </strong>
                                        <small class="text-muted d-block text-truncate">
                                            {{ $speaker->title ?? '' }}
                                            @if(!empty($speaker->company)) &mdash; {{ $speaker->company }} @endif
                                        </small>
                                    </div>
                                </div>

                                <span class="selected-tick text-warning"
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
                <span id="modal-selected-count"
                      class="badge badge-warning badge-pill px-3 py-2" style="font-size:13px;">
                    0 selected
                </span>
                <div>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Cancel
                    </button>
                    <button type="button" class="btn btn-warning" id="btn-confirm-speakers" data-dismiss="modal">
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

    const display    = document.getElementById('speaker-display');
    const hiddenWrap = document.getElementById('speaker-hidden-inputs');
    const placeholder= document.getElementById('speaker-placeholder');
    const countBadge = document.getElementById('modal-selected-count');
    const searchInput= document.getElementById('speaker-search');

    function styleCard(cb) {
        const card = cb.closest('.speaker-card');
        const tick = card.querySelector('.selected-tick');
        if (cb.checked) {
            card.style.borderColor = '#ffc107';
            card.style.background  = '#fff9e6';
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

    // Init cards (pre-check existing speakers)
    document.querySelectorAll('.speaker-checkbox').forEach(cb => {
        styleCard(cb);
        cb.closest('.speaker-card').addEventListener('click', function (e) {
            if (e.target !== cb) cb.checked = !cb.checked;
            styleCard(cb);
            refreshCount();
        });
    });
    refreshCount();

    // Wire up remove buttons on pre-filled badges
    document.querySelectorAll('.remove-badge').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            removeSpeaker(this.dataset.val);
        });
    });

    function removeSpeaker(val) {
        // Uncheck modal card
        const cbEl = document.querySelector(`.speaker-checkbox[value="${val}"]`);
        if (cbEl) { cbEl.checked = false; styleCard(cbEl); refreshCount(); }

        // Remove hidden input
        hiddenWrap.querySelector(`input[value="${val}"]`)?.remove();

        // Remove badge from display
        const badge = display.querySelector(`[data-val="${val}"]`);
        if (badge) badge.closest('.badge')?.remove();

        // Show placeholder if no badges left
        if (!display.querySelector('.badge')) placeholder.style.display = '';
    }

    // Confirm: rebuild badges + hidden inputs from checked boxes
    document.getElementById('btn-confirm-speakers').addEventListener('click', function () {
        const checked = document.querySelectorAll('.speaker-checkbox:checked');

        hiddenWrap.innerHTML = '';
        // Keep only the placeholder, remove old badges
        display.querySelectorAll('.badge').forEach(b => b.remove());

        if (checked.length === 0) {
            placeholder.style.display = '';
            return;
        }

        placeholder.style.display = 'none';

        checked.forEach(cb => {
            const input  = document.createElement('input');
            input.type   = 'hidden';
            input.name   = 'speaker_ids[]';
            input.value  = cb.value;
            hiddenWrap.appendChild(input);

            const badge         = document.createElement('span');
            badge.className     = 'badge badge-primary d-inline-flex align-items-center mr-1 mb-1 px-2 py-1';
            badge.style.fontSize= '12px';
            badge.setAttribute('data-val', cb.value);
            badge.innerHTML     = `<i class="fas fa-user mr-1"></i>${cb.dataset.name}
                <span class="ml-2 remove-badge" data-val="${cb.value}"
                      style="cursor:pointer; font-size:14px; line-height:1;">&times;</span>`;

            badge.querySelector('.remove-badge').addEventListener('click', function (e) {
                e.stopPropagation();
                removeSpeaker(this.dataset.val);
            });

            display.appendChild(badge);
        });
    });

    // Search
    searchInput.addEventListener('input', function () {
        const q = this.value.toLowerCase().trim();
        document.querySelectorAll('.speaker-item').forEach(item => {
            item.style.display = (item.dataset.name.includes(q) || item.dataset.company.includes(q)) ? '' : 'none';
        });
    });

    document.getElementById('speakerModal').addEventListener('hidden.bs.modal', function () {
        searchInput.value = '';
        document.querySelectorAll('.speaker-item').forEach(i => i.style.display = '');
    });
});
</script>
@endsection