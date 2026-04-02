@extends('backend.layouts.master')

@section('title', 'Dashboard | Event')
@section('d_menu-open', 'menu-open')
@section('d_active', 'active')

@section('main-content')
<div class="content-wrapper">

    {{-- Page Header --}}
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            {{-- ═══════════════════════════════════════
                 ROW 1 — Stat Boxes
            ═══════════════════════════════════════ --}}
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $totalEvents }}</h3>
                            <p>Total Events</p>
                        </div>
                        <div class="icon"><i class="ion ion-calendar"></i></div>
                        <a href="{{ route('events.index') }}" class="small-box-footer">
                            More info <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $totalSpeakers }}</h3>
                            <p>Registered Speakers</p>
                        </div>
                        <div class="icon"><i class="ion ion-mic-a"></i></div>
                        <a href="{{ route('speakers.index') }}" class="small-box-footer">
                            More info <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $totalUsers }}</h3>
                            <p>User Registrations</p>
                        </div>
                        <div class="icon"><i class="ion ion-person-add"></i></div>
                        <a href="{{ route('users.index') }}" class="small-box-footer">
                            More info <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $totalSponsors }}</h3>
                            <p>Event Sponsors</p>
                        </div>
                        <div class="icon"><i class="ion ion-ribbon-b"></i></div>
                        <a href="{{ route('sponsors.index') }}" class="small-box-footer">
                            More info <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            {{-- ═══════════════════════════════════════
                 ROW 2 — Main Content (Left: Events | Right: Sponsors & Stats)
            ═══════════════════════════════════════ --}}
            <div class="row">

                {{-- LEFT COLUMN --}}
                <div class="col-lg-8">
                    {{-- Upcoming Events Table (Moved to Top/Left) --}}
                    <div class="card">
                        <div class="card-header border-0">
                            <h3 class="card-title">
                                <i class="fas fa-calendar-alt mr-1 text-success"></i>
                                Upcoming Events
                            </h3>
                            <div class="card-tools">
                                <a href="{{ route('events.index') }}" class="btn btn-sm btn-outline-success">
                                    View All
                                </a>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-sm table-hover mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Event Name</th>
                                        <th>Date</th>
                                        <th>Location</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($upcomingEvents as $i => $event)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>
                                            <strong>{{ $event->event_name }}</strong>
                                        </td>
                                        <td>
                                            <i class="far fa-calendar mr-1 text-muted"></i>
                                            {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}
                                        </td>
                                        <td>
                                            <i class="fas fa-map-marker-alt mr-1 text-muted"></i>
                                            {{ $event->location ?? '—' }}
                                        </td>
                                        <td>
                                            @php
                                                $daysLeft = now()->diffInDays($event->start_date, false);
                                            @endphp
                                            @if($daysLeft <= 7)
                                                <span class="badge badge-danger">This Week</span>
                                            @elseif($daysLeft <= 30)
                                                <span class="badge badge-warning">This Month</span>
                                            @else
                                                <span class="badge badge-info">Upcoming</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-3">
                                            <i class="fas fa-inbox mr-1"></i> No upcoming events.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- RIGHT COLUMN --}}
                <div class="col-lg-4">
                    
                    {{-- Sponsors Card (Moved to Right) --}}
                    <div class="card">
                        <div class="card-header border-0">
                            <h3 class="card-title">
                                <i class="fas fa-handshake mr-1 text-warning"></i>
                                Sponsors
                            </h3>
                        </div>
                        <div class="card-body text-center">
                            <h1 class="display-4 text-warning font-weight-bold">{{ $totalSponsors }}</h1>
                            <p class="text-muted">Total Registered Sponsors</p>
                            <a href="{{ route('sponsors.index') }}" class="btn btn-outline-warning btn-sm">
                                <i class="fas fa-list mr-1"></i> View All Sponsors
                            </a>
                        </div>
                    </div>

                    {{-- Quick Stats Cards --}}
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-info elevation-1">
                            <i class="fas fa-calendar-check"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Events This Month</span>
                            <span class="info-box-number">
                                {{ \App\Models\Event::whereMonth('start_date', now()->month)->count() }}
                            </span>
                        </div>
                    </div>

                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1">
                            <i class="fas fa-user-plus"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">New Users This Month</span>
                            <span class="info-box-number">
                                {{ \App\Models\User::whereMonth('created_at', now()->month)->count() }}
                            </span>
                        </div>
                    </div>

                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-success elevation-1">
                            <i class="fas fa-ticket-alt"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Bookings</span>
                            <span class="info-box-number">
                                {{ \App\Models\SupplierBooking::count() }}
                            </span>
                        </div>
                    </div>

                </div>

            </div>
            {{-- End Row 2 --}}

        </div>
    </section>
</div>
@endsection

{{-- ═══════════════════════════════════════
     Chart.js Scripts
═══════════════════════════════════════ --}}