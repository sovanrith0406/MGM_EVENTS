@extends('backend.layouts.master')
@section('title', 'Sponsor Report')
@section('r_menu-open', 'menu-open')
@section('r_active', 'active')

@section('main-content')
<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"><h1>Sponsor Report</h1></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Sponsor Report</li>
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
                    <form method="GET" action="{{ route('reports.sponsor') }}">
                        <div class="row">
                            {{-- Event --}}
                            <div class="col-md-4">
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
                            {{-- Keyword --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Sponsor Name</label>
                                    <input type="text" name="keyword" class="form-control form-control-sm"
                                           placeholder="Search by name..."
                                           value="{{ request('keyword') }}">
                                </div>
                            </div>
                            {{-- Buttons --}}
                            <div class="col-md-4 d-flex align-items-end">
                                <div class="form-group w-100">
                                    <button type="submit" class="btn btn-primary btn-sm mr-1">
                                        <i class="fas fa-search mr-1"></i> Search
                                    </button>
                                    <a href="{{ route('reports.sponsor') }}" class="btn btn-outline-secondary btn-sm mr-1">
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
                <div class="col-md-4">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $totalSponsors }}</h3>
                            <p>Total Sponsors</p>
                        </div>
                        <div class="icon"><i class="fas fa-handshake"></i></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>USD {{ number_format($totalRaised, 2) }}</h3>
                            <p>Total Amount Raised</p>
                        </div>
                        <div class="icon"><i class="fas fa-dollar-sign"></i></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $totalEventLinks }}</h3>
                            <p>Total Event Participations</p>
                        </div>
                        <div class="icon"><i class="fas fa-calendar-check"></i></div>
                    </div>
                </div>
            </div>

            {{-- Report Table --}}
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-table mr-1"></i> Sponsor List
                    </h3>
                    <span class="print-only d-none">
                        Generated: {{ now()->format('d M Y, h:i A') }}
                    </span>
                    <small class="text-muted no-print">
                        {{ $totalSponsors }} record(s) found
                    </small>
                </div>
                <div class="card-body p-0">
                    <table class="table table-bordered table-striped table-hover mb-0">
                        <thead class="thead-dark">
                            <tr>
                                <th style="width:40px">#</th>
                                <th style="width:80px">Logo</th>
                                <th>Company</th>
                                <th>Contact</th>
                                <th>Website</th>
                                <th class="text-center">Events</th>
                                <th class="text-right">Amount (USD)</th>
                                <th class="no-print text-center" style="width:90px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sponsors as $sponsor)
                            <tr>
                                <td>{{ $loop->iteration + ($sponsors->currentPage()-1) * $sponsors->perPage() }}</td>

                                {{-- Logo --}}
                                <td>
                                    @if($sponsor->logo_url)
                                        <img src="{{ asset('uploads/sponsors/' . $sponsor->logo_url) }}"
                                             alt="{{ $sponsor->name }}"
                                             style="max-width:60px; height:35px; object-fit:contain;">
                                    @else
                                        <div class="bg-secondary d-flex align-items-center justify-content-center"
                                             style="width:60px; height:35px; border-radius:4px;">
                                            <i class="fas fa-building text-white"></i>
                                        </div>
                                    @endif
                                </td>

                                {{-- Company --}}
                                <td><strong>{{ $sponsor->name }}</strong></td>

                                {{-- Contact --}}
                                <td>
                                    @if($sponsor->contact_name)
                                        <span class="d-block">
                                            <i class="fas fa-user fa-xs text-muted mr-1"></i>
                                            {{ $sponsor->contact_name }}
                                        </span>
                                    @endif
                                    @if($sponsor->contact_email)
                                        <small class="text-muted d-block">
                                            <i class="fas fa-envelope fa-xs mr-1"></i>
                                            {{ $sponsor->contact_email }}
                                        </small>
                                    @endif
                                    @if($sponsor->contact_phone)
                                        <small class="text-muted d-block">
                                            <i class="fas fa-phone fa-xs mr-1"></i>
                                            {{ $sponsor->contact_phone }}
                                        </small>
                                    @endif
                                </td>

                                {{-- Website --}}
                                <td>
                                    @if($sponsor->website)
                                        <a href="{{ $sponsor->website }}" target="_blank" rel="noopener">
                                            <i class="fas fa-external-link-alt fa-xs mr-1"></i>
                                            {{ parse_url($sponsor->website, PHP_URL_HOST) ?? $sponsor->website }}
                                        </a>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>

                                {{-- Events count --}}
                                <td class="text-center">
                                    <span class="badge badge-info badge-pill">
                                        {{ $sponsor->events_count ?? 0 }}
                                    </span>
                                </td>

                                {{-- Amount --}}
                                <td class="text-right font-weight-bold text-success">
                                    {{ number_format($sponsor->total_amount ?? 0, 2) }}
                                </td>

                                {{-- Actions --}}
                                <td class="text-center no-print">
                                    <a href="{{ url('/sponsors/' . $sponsor->sponsor_id . '/edit') }}"
                                       class="btn btn-warning btn-xs" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                    No sponsors found for the selected filters.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        @if($sponsors->count() > 0)
                        <tfoot>
                            <tr class="bg-light">
                                <td colspan="6" class="text-right font-weight-bold">
                                    Total (this page)
                                </td>
                                <td class="text-right font-weight-bold text-success">
                                    {{ number_format($sponsors->sum('total_amount'), 2) }}
                                </td>
                                <td class="no-print"></td>
                            </tr>
                            <tr class="bg-light">
                                <td colspan="6" class="text-right font-weight-bold">
                                    Grand Total
                                </td>
                                <td class="text-right font-weight-bold text-primary" style="font-size:15px;">
                                    USD {{ number_format($totalRaised, 2) }}
                                </td>
                                <td class="no-print"></td>
                            </tr>
                        </tfoot>
                        @endif
                    </table>
                </div>
                @if($sponsors->hasPages())
                <div class="card-footer no-print">
                    {{ $sponsors->links() }}
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