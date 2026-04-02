@extends('frontend.layouts.app')
@section('title', 'Schedule — MGM Event')
@section('nav_schedule', 'active')

@push('styles')
<style>
    /* ── View Toggle ── */
    .view-toggle .btn { font-size: 13px; }
    .view-toggle .btn.active { background: #2563eb; color: #fff; border-color: #2563eb; }

    /* ── Timeline ── */
    .timeline { position: relative; padding-left: 32px; }
    .timeline::before {
        content: '';
        position: absolute; left: 10px; top: 0; bottom: 0;
        width: 2px; background: #e2e8f0;
    }
    .timeline-item { position: relative; margin-bottom: 28px; }
    .timeline-dot {
        position: absolute; left: -28px; top: 14px;
        width: 16px; height: 16px; border-radius: 50%;
        background: #2563eb; border: 3px solid #fff;
        box-shadow: 0 0 0 2px #2563eb;
        z-index: 1;
    }
    .timeline-dot.type-workshop  { background: #d97706; box-shadow: 0 0 0 2px #d97706; }
    .timeline-dot.type-keynote   { background: #be185d; box-shadow: 0 0 0 2px #be185d; }
    .timeline-dot.type-panel     { background: #15803d; box-shadow: 0 0 0 2px #15803d; }
    .timeline-dot.type-break     { background: #94a3b8; box-shadow: 0 0 0 2px #94a3b8; }
    .timeline-dot.type-talk      { background: #2563eb; box-shadow: 0 0 0 2px #2563eb; }

    .timeline-card {
        border-left: 4px solid #2563eb;
        border-radius: 0 12px 12px 0 !important;
        transition: box-shadow .2s;
    }
    .timeline-card:hover { box-shadow: 0 6px 24px rgba(37,99,235,.12) !important; }
    .timeline-card.type-workshop { border-left-color: #d97706; }
    .timeline-card.type-keynote  { border-left-color: #be185d; }
    .timeline-card.type-panel    { border-left-color: #15803d; }
    .timeline-card.type-break    { border-left-color: #94a3b8; }
    .timeline-card.type-talk     { border-left-color: #2563eb; }

    .timeline-time {
        font-size: 12px; font-weight: 700; color: #2563eb;
        white-space: nowrap;
    }

    /* ── Table ── */
    .schedule-table thead th {
        background: #1e293b; color: #fff;
        font-size: 13px; font-weight: 600;
        padding: 14px 16px; border: none;
    }
    .schedule-table tbody tr { transition: background .15s; }
    .schedule-table tbody tr:hover { background: #f8fafc; }
    .schedule-table tbody td { padding: 14px 16px; vertical-align: middle; font-size: 14px; border-color: #f1f5f9; }
    .time-cell { font-weight: 700; color: #2563eb; font-size: 13px; white-space: nowrap; }
    .time-end  { color: #94a3b8; font-weight: 400; }

    /* ── Tags (shared) ── */
    .tag { font-size: 11px; padding: 3px 10px; border-radius: 20px; font-weight: 600; text-transform: uppercase; }
    .tag-talk     { background: #dbeafe; color: #1d4ed8; }
    .tag-workshop { background: #fef9c3; color: #b45309; }
    .tag-keynote  { background: #fce7f3; color: #be185d; }
    .tag-panel    { background: #dcfce7; color: #15803d; }
    .tag-break    { background: #f1f5f9; color: #64748b; }
</style>
@endpush

@section('content')

{{-- Page Header --}}
<div class="page-header">
    <h1 class="fw-bold">Event Schedule</h1>
    <p class="text-secondary">Plan your day with our detailed session schedule</p>
</div>

<section class="py-5">
    <div class="container">

        {{-- Filter + View Toggle --}}
        <div class="d-flex flex-wrap gap-3 align-items-center justify-content-between mb-4">
            <form method="GET" action="{{ route('frontend.schedule') }}">
                <div class="d-flex gap-2 flex-wrap align-items-center">
                    <select name="event_id" class="form-select rounded-3" style="max-width:280px;">
                        <option value="">All Events</option>
                        @foreach($events as $event)
                            <option value="{{ $event->event_id }}"
                                {{ request('event_id') == $event->event_id ? 'selected' : '' }}>
                                {{ $event->event_name }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-primary px-4 rounded-3">
                        <i class="fas fa-filter me-1"></i> Filter
                    </button>
                    <a href="{{ route('frontend.schedule') }}" class="btn btn-outline-secondary px-4 rounded-3">Reset</a>
                </div>
            </form>

            {{-- View Toggle --}}
            <div class="view-toggle btn-group" role="group">
                <button type="button" class="btn btn-outline-primary active" id="btn-timeline"
                        onclick="switchView('timeline')">
                    <i class="fas fa-stream me-1"></i> Timeline
                </button>
                <button type="button" class="btn btn-outline-primary" id="btn-table"
                        onclick="switchView('table')">
                    <i class="fas fa-table me-1"></i> Table
                </button>
            </div>
        </div>

        {{-- ── TIMELINE VIEW ── --}}
        <div id="view-timeline">
            @if($schedules->count())
            <div class="timeline">
                @foreach($schedules as $schedule)
                @php
                    $start = \Carbon\Carbon::parse($schedule->start_time);
                    $end   = \Carbon\Carbon::parse($schedule->end_time);
                @endphp
                <div class="timeline-item">
                    <div class="timeline-dot type-{{ $schedule->session_type }}"></div>
                    <div class="card border-0 shadow-sm timeline-card type-{{ $schedule->session_type }}">
                        <div class="card-body p-4">
                            <div class="d-flex flex-wrap justify-content-between align-items-start gap-2 mb-2">
                                <div>
                                    <h6 class="fw-bold mb-1">{{ $schedule->title }}</h6>
                                    <p class="small text-secondary mb-0">
                                        <i class="fas fa-calendar-alt text-primary me-1"></i>
                                        {{ $schedule->event->event_name ?? '' }}
                                        &nbsp;·&nbsp;
                                        <i class="fas fa-calendar text-primary me-1"></i>
                                        {{ $start->format('d M Y') }}
                                    </p>
                                </div>
                                <div class="text-end">
                                    <div class="timeline-time">
                                        {{ $start->format('H:i') }}
                                        <span class="text-secondary fw-normal">→</span>
                                        {{ $end->format('H:i') }}
                                    </div>
                                    @if($start->format('Y-m-d') !== $end->format('Y-m-d'))
                                        <div class="text-muted" style="font-size:11px;">
                                            ends {{ $end->format('d M Y') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            @if($schedule->description)
                                <p class="small text-secondary mb-2">{{ $schedule->description }}</p>
                            @endif
                            <div class="d-flex flex-wrap gap-2 mt-2">
                                <span class="tag tag-{{ $schedule->session_type }}">
                                    {{ ucfirst($schedule->session_type) }}
                                </span>
                                @foreach($schedule->speakers as $sp)
                                    <span class="tag" style="background:#f1f5f9; color:#475569;">
                                        <i class="fas fa-user me-1"></i>{{ $sp->full_name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-5 text-secondary">
                <i class="fas fa-calendar-times mb-3 d-block" style="font-size:56px; color:#cbd5e1;"></i>
                No schedule found.
            </div>
            @endif
        </div>

        {{-- ── TABLE VIEW ── --}}
        <div id="view-table" style="display:none;">
            @if($schedules->count())
            <div class="table-responsive rounded-3 shadow-sm overflow-hidden">
                <table class="table schedule-table mb-0">
                    <thead>
                        <tr>
                            <th><i class="fas fa-clock me-2"></i>Time</th>
                            <th><i class="fas fa-tag me-2"></i>Session</th>
                            <th><i class="fas fa-calendar-alt me-2"></i>Event</th>
                            <th><i class="fas fa-layer-group me-2"></i>Type</th>
                            <th><i class="fas fa-users me-2"></i>Speakers</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($schedules as $schedule)
                        @php
                            $start = \Carbon\Carbon::parse($schedule->start_time);
                            $end   = \Carbon\Carbon::parse($schedule->end_time);
                        @endphp
                        <tr>
                            <td class="time-cell">
                                {{ $start->format('H:i') }}<br>
                                <span class="time-end">{{ $end->format('H:i') }}</span>
                                @if($start->format('Y-m-d') !== $end->format('Y-m-d'))
                                    <br><span style="font-size:11px; color:#94a3b8;">ends {{ $end->format('d M') }}</span>
                                @endif
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $schedule->title }}</div>
                                @if($schedule->description)
                                    <div class="small text-secondary mt-1">{{ Str::limit($schedule->description, 60) }}</div>
                                @endif
                            </td>
                            <td class="small text-secondary">
                                {{ $schedule->event->event_name ?? '—' }}<br>
                                <span class="text-muted" style="font-size:12px;">
                                    {{ $start->format('d M Y') }}
                                </span>
                            </td>
                            <td>
                                <span class="tag tag-{{ $schedule->session_type }}">
                                    {{ ucfirst($schedule->session_type) }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex flex-column gap-1">
                                    @forelse($schedule->speakers as $sp)
                                        <span class="small">
                                            <i class="fas fa-user text-primary me-1"></i>{{ $sp->full_name }}
                                        </span>
                                    @empty
                                        <span class="small text-secondary">—</span>
                                    @endforelse
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-5 text-secondary">
                <i class="fas fa-calendar-times mb-3 d-block" style="font-size:56px; color:#cbd5e1;"></i>
                No schedule found.
            </div>
            @endif
        </div>

    </div>
</section>
@endsection

@push('scripts')
<script>
function switchView(view) {
    document.getElementById('view-timeline').style.display = view === 'timeline' ? 'block' : 'none';
    document.getElementById('view-table').style.display     = view === 'table'    ? 'block' : 'none';
    document.getElementById('btn-timeline').classList.toggle('active', view === 'timeline');
    document.getElementById('btn-table').classList.toggle('active', view === 'table');
    localStorage.setItem('scheduleView', view);
}

// Restore last chosen view
const saved = localStorage.getItem('scheduleView');
if (saved) switchView(saved);
</script>
@endpush