@extends('backend.layouts.master')
@section('title', 'Event Management')
@section('e_menu-open', 'menu-open')
@section('e_active', 'active')

@section('main-content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"><h1>Event Management</h1></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Events</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <div class="card-header">
        <a href="{{ route('events.create') }}" class="btn btn-primary btn-sm mr-2">
            <i class="fas fa-plus mr-1"></i> Add New Event
        </a>
    </div>

    <section class="content">
        <div class="container-fluid">

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-circle mr-1"></i> {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            @endif

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">All Events</h3>
                </div>

                <div class="card-body">
                    {{-- Search / Filter --}}
                    <form method="GET" action="{{ route('events.index') }}" class="mb-3">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control form-control-sm"
                                       placeholder="Search event name..."
                                       value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3">
                                <select name="status" class="form-control form-control-sm">
                                    <option value="">-- All Status --</option>
                                    <option value="draft"     {{ request('status') == 'draft'     ? 'selected' : '' }}>Draft</option>
                                    <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-secondary btn-sm w-100">
                                    <i class="fas fa-search mr-1"></i> Search
                                </button>
                            </div>
                            <div class="col-md-2">
                                <a href="{{ route('events.index') }}" class="btn btn-outline-secondary btn-sm w-100">
                                    <i class="fas fa-redo mr-1"></i> Reset
                                </a>
                            </div>
                        </div>
                    </form>

                    <table class="table table-bordered table-hover table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th style="width:50px">#</th>
                                <th>Event Name</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Timezone</th>
                                <th style="width:120px">Price</th>
                                <th>Speakers</th>
                                <th>Sponsors</th>
                                <th style="width:110px">Status</th>
                                <th>Created At</th>
                                <th style="width:120px" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($events as $event)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <strong>{{ $event->event_name }}</strong>
                                    @if($event->description)
                                        <br><small class="text-muted">{{ Str::limit($event->description, 60) }}</small>
                                    @endif
                                </td>
                                <td>{{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($event->end_date)->format('d M Y') }}</td>
                                <td><small>{{ $event->timezone }}</small></td>
                                <td>
                                    <span class="text-success font-weight-bold">
                                        {{ $event->currency ?? 'USD' }}
                                        {{ number_format($event->price ?? 0, 2) }}
                                    </span>
                                </td>
                                <td>
                                    @php
                                        $speakers = $event->schedules->flatMap->speakers->unique('speaker_id');
                                    @endphp
                                    @if($speakers->isNotEmpty())
                                        @foreach($speakers as $speaker)
                                            <span class="badge badge-info mr-1">
                                                <i class="fas fa-user mr-1"></i>{{ $speaker->full_name }}
                                            </span>
                                        @endforeach
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    @if($event->sponsors->isNotEmpty())
                                        @foreach($event->sponsors as $sponsor)
                                            <span class="badge badge-secondary mr-1">
                                                <i class="fas fa-handshake mr-1"></i>{{ $sponsor->name }}
                                            </span>
                                        @endforeach
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @php
                                        $badge = match($event->status) {
                                            'published' => 'success',
                                            'draft'     => 'warning',
                                            'cancelled' => 'danger',
                                            'completed' => 'info',
                                            default     => 'secondary',
                                        };
                                    @endphp
                                    <span class="badge badge-{{ $badge }}">
                                        {{ ucfirst($event->status) }}
                                    </span>
                                </td>
                                <td>{{ $event->created_at ? $event->created_at->format('d M Y') : '-' }}</td>
                                <td class="text-center">
                                    <a href="{{ route('events.edit', $event->event_id) }}"
                                       class="btn btn-warning btn-xs" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('events.destroy', $event->event_id) }}"
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('Delete this event?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-xs" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="11" class="text-center text-muted py-4">
                                    <i class="fas fa-calendar-times fa-2x mb-2 d-block"></i>
                                    No events found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($events->hasPages())
                <div class="card-footer clearfix">
                    {{ $events->appends(request()->query())->links() }}
                </div>
                @endif
            </div>

        </div>
    </section>
</div>
@endsection