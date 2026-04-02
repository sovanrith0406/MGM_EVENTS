@extends('backend.layouts.master')
@section('title', 'Booking Report')
@section('r_menu-open', 'menu-open')
@section('r_active', 'active')

@section('main-content')
<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"><h1>Booking Report</h1></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Booking Report</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            {{-- Filter Card --}}
            <div class="card card-outline card-primary no-print">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-filter mr-1"></i> Filter</h3>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('reports.booking') }}">
                        <div class="row">
                            {{-- Event --}}
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Event</label>
                                    <select name="event_id" class="form-control form-control-sm">
                                        <option value="">-- All Events --</option>
                                        @foreach($events as $event)
                                            <option value="{{ $event->event_id }}"
                                                {{ request('event_id') == $event->event_id ? 'selected' : '' }}>
                                                {{ $event->event_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            {{-- Status --}}
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control form-control-sm">
                                        <option value="">-- All Status --</option>
                                        <option value="pending"   {{ request('status') == 'pending'   ? 'selected' : '' }}>Pending</option>
                                        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                        <option value="paid"      {{ request('status') == 'paid'      ? 'selected' : '' }}>Paid</option>
                                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </div>
                            </div>
                            {{-- Date From --}}
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Date From</label>
                                    <input type="date" name="date_from" class="form-control form-control-sm"
                                           value="{{ request('date_from') }}">
                                </div>
                            </div>
                            {{-- Date To --}}
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Date To</label>
                                    <input type="date" name="date_to" class="form-control form-control-sm"
                                           value="{{ request('date_to') }}">
                                </div>
                            </div>
                            {{-- Buttons --}}
                            <div class="col-md-3 d-flex align-items-end">
                                <div class="form-group w-100">
                                    <button type="submit" class="btn btn-primary btn-sm mr-1">
                                        <i class="fas fa-search mr-1"></i> Search
                                    </button>
                                    <a href="{{ route('reports.booking') }}" class="btn btn-outline-secondary btn-sm mr-1">
                                        <i class="fas fa-redo mr-1"></i> Reset
                                    </a>
                                    <button type="button" onclick="window.print()" class="btn btn-success btn-sm">
                                        <i class="fas fa-print mr-1"></i> Print
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Summary Cards --}}
            <div class="row no-print">
                <div class="col-md-3">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $totalBookings }}</h3>
                            <p>Total Bookings</p>
                        </div>
                        <div class="icon"><i class="fas fa-edit"></i></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>USD {{ number_format($totalAmount, 2) }}</h3>
                            <p>Total Paid Amount</p>
                        </div>
                        <div class="icon"><i class="fas fa-dollar-sign"></i></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $countPending }}</h3>
                            <p>Pending</p>
                        </div>
                        <div class="icon"><i class="fas fa-clock"></i></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $countCancelled }}</h3>
                            <p>Cancelled</p>
                        </div>
                        <div class="icon"><i class="fas fa-times-circle"></i></div>
                    </div>
                </div>
            </div>

            {{-- Report Table --}}
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-table mr-1"></i> Booking List
                    </h3>
                    {{-- Print Header Info --}}
                    <span class="print-only d-none">
                        Generated: {{ now()->format('d M Y, h:i A') }}
                        @if(request('date_from') || request('date_to'))
                            | Period: {{ request('date_from', '—') }} to {{ request('date_to', '—') }}
                        @endif
                    </span>
                    <small class="text-muted no-print">
                        {{ $totalBookings }} record(s) found
                    </small>
                </div>
                <div class="card-body p-0">
                    <table class="table table-bordered table-striped table-hover mb-0">
                        <thead class="thead-dark">
                            <tr>
                                <th style="width:40px">#</th>
                                <th>Event</th>
                                <th>Supplier</th>
                                <th>Track</th>
                                <th>Booking Date</th>
                                <th class="text-right">Amount</th>
                                <th class="text-center">Status</th>
                                <th class="no-print text-center" style="width:100px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bookings as $booking)
                            <tr>
                                <td>{{ $loop->iteration + ($bookings->currentPage()-1) * $bookings->perPage() }}</td>
                                <td><strong>{{ $booking->event->event_name ?? '—' }}</strong></td>
                                <td>{{ $booking->supplier_name }}</td>
                                <td>{{ $booking->track->track_name ?? '—' }}</td>
                                <td>{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</td>
                                <td class="text-right font-weight-bold">
                                    {{ $booking->currency }} {{ number_format($booking->amount, 2) }}
                                </td>
                                <td class="text-center">
                                    @php
                                        $badge = match($booking->status) {
                                            'confirmed' => 'success',
                                            'pending'   => 'warning',
                                            'paid'      => 'primary',
                                            'cancelled' => 'danger',
                                            default     => 'secondary',
                                        };
                                    @endphp
                                    <span class="badge badge-{{ $badge }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </td>
                                <td class="text-center no-print">
                                    <a href="{{ route('supplier_booking.show', $booking->booking_id) }}"
                                       class="btn btn-success btn-xs" title="Receipt">
                                        <i class="fas fa-receipt"></i>
                                    </a>
                                    <a href="{{ route('supplier_booking.edit', $booking->booking_id) }}"
                                       class="btn btn-warning btn-xs" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                    No bookings found for the selected filters.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        @if($bookings->count() > 0)
                        <tfoot>
                            <tr class="bg-light">
                                <td colspan="5" class="text-right font-weight-bold">
                                    Total (this page)
                                </td>
                                <td class="text-right font-weight-bold text-success">
                                    USD {{ number_format($bookings->sum('amount'), 2) }}
                                </td>
                                <td colspan="2" class="no-print"></td>
                            </tr>
                            <tr class="bg-light">
                                <td colspan="5" class="text-right font-weight-bold">
                                    Grand Total — Paid Only
                                </td>
                                <td class="text-right font-weight-bold text-primary" style="font-size:15px;">
                                    USD {{ number_format($totalAmount, 2) }}
                                </td>
                                <td colspan="2" class="no-print"></td>
                            </tr>
                        </tfoot>
                        @endif
                    </table>
                </div>
                @if($bookings->hasPages())
                <div class="card-footer no-print">
                    {{ $bookings->links() }}
                </div>
                @endif
            </div>

        </div>
    </section>
</div>
@endsection

@push('styles')
<style>
@media print {
    .main-sidebar, .main-header, .content-header,
    .breadcrumb, .no-print { display: none !important; }
    .content-wrapper { margin: 0 !important; }
    .card { border: none !important; box-shadow: none !important; }
    .print-only { display: inline !important; }
    thead { background-color: #343a40 !important; color: #fff !important; -webkit-print-color-adjust: exact; }
}
</style>
@endpush