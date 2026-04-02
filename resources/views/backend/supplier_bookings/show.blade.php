@extends('backend.layouts.master')
@section('title', 'Booking Receipt #' . $supplier_booking->booking_id)
@section('b_menu-open', 'menu-open')
@section('b_active', 'active')

@section('main-content')
<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"><h1>Booking Receipt</h1></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('supplier_booking.index') }}">Supplier Bookings</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Receipt #{{ str_pad($supplier_booking->booking_id, 6, '0', STR_PAD_LEFT) }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card" id="receiptCard">
                <div class="card-body">

                    {{-- Receipt Header --}}
                    <div class="row mb-4">
                        <div class="col-sm-6">
                            <h4 class="font-weight-bold text-primary">
                                <i class="fas fa-calendar-alt mr-2"></i> MGM EVENT
                            </h4>
                            <p class="text-muted mb-0">Supplier Booking Receipt</p>
                            <p class="text-muted mb-0">Phnom Penh, Cambodia</p>
                        </div>
                        <div class="col-sm-6 text-right">
                            <h4 class="font-weight-bold">RECEIPT</h4>
                            <p class="mb-0 font-weight-bold">
                                # {{ str_pad($supplier_booking->booking_id, 6, '0', STR_PAD_LEFT) }}
                            </p>
                            <p class="mb-0 text-muted">
                                Booked: {{ \Carbon\Carbon::parse($supplier_booking->booking_date)->format('d M Y') }}
                            </p>
                            <p class="mb-0 text-muted">
                                Issued: {{ \Carbon\Carbon::parse($supplier_booking->created_at)->format('d M Y, h:i A') }}
                            </p>
                            @php
                                $badge = match($supplier_booking->status) {
                                    'confirmed' => 'success',
                                    'pending'   => 'warning',
                                    'paid'      => 'primary',
                                    'cancelled' => 'danger',
                                    default     => 'secondary',
                                };
                            @endphp
                            <span class="badge badge-{{ $badge }} px-3 py-2 mt-1" style="font-size:13px;">
                                {{ ucfirst($supplier_booking->status) }}
                            </span>
                        </div>
                    </div>

                    <hr>

                    {{-- Event + Supplier Info --}}
                    <div class="row mb-4">
                        <div class="col-sm-6">
                            <h6 class="font-weight-bold text-muted text-uppercase mb-2">Event Details</h6>
                            <p class="mb-1 font-weight-bold">
                                {{ $supplier_booking->event->event_name ?? '—' }}
                            </p>
                            @if($supplier_booking->event)
                                <p class="mb-1 text-muted">
                                    <i class="fas fa-calendar mr-1"></i>
                                    {{ \Carbon\Carbon::parse($supplier_booking->event->start_date)->format('d M Y') }}
                                    —
                                    {{ \Carbon\Carbon::parse($supplier_booking->event->end_date)->format('d M Y') }}
                                </p>
                                <p class="mb-1 text-muted">
                                    <i class="fas fa-clock mr-1"></i>
                                    {{ $supplier_booking->event->timezone ?? 'Asia/Phnom_Penh' }}
                                </p>
                            @endif
                            @if($supplier_booking->track)
                                <p class="mb-1 text-muted">
                                    <i class="fas fa-layer-group mr-1"></i>
                                    Track: {{ $supplier_booking->track->track_name }}
                                </p>
                            @endif
                        </div>
                        <div class="col-sm-6 text-right">
                            <h6 class="font-weight-bold text-muted text-uppercase mb-2">Supplier</h6>
                            <p class="mb-1 font-weight-bold">{{ $supplier_booking->supplier_name }}</p>
                            @if($supplier_booking->description)
                                <p class="mb-1 text-muted">{{ $supplier_booking->description }}</p>
                            @endif
                        </div>
                    </div>

                    {{-- Amount Table --}}
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>Description</th>
                                <th class="text-center" style="width:120px">Currency</th>
                                <th class="text-right" style="width:150px">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    Supplier Booking Fee —
                                    <strong>{{ $supplier_booking->event->event_name ?? '—' }}</strong>
                                    @if($supplier_booking->track)
                                        <br><small class="text-muted">Track: {{ $supplier_booking->track->track_name }}</small>
                                    @endif
                                </td>
                                <td class="text-center">{{ $supplier_booking->currency }}</td>
                                <td class="text-right">
                                    {{ number_format($supplier_booking->amount, 2) }}
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2" class="text-right font-weight-bold">Total</td>
                                <td class="text-right font-weight-bold text-success" style="font-size:16px;">
                                    {{ $supplier_booking->currency }}
                                    {{ number_format($supplier_booking->amount, 2) }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>

                    {{-- Footer Note --}}
                    <div class="row mt-3">
                        <div class="col-12">
                            <p class="text-muted text-center" style="font-size:12px; border-top:1px dashed #ccc; padding-top:10px;">
                                This receipt is system-generated by MGM Event Management System.
                                For inquiries, please contact the event organizer.
                            </p>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="row no-print">
                        <div class="col-12 text-right">
                            <a href="{{ route('supplier_booking.index') }}" class="btn btn-secondary mr-2">
                                <i class="fas fa-arrow-left mr-1"></i> Back
                            </a>
                            <button onclick="window.print()" class="btn btn-primary">
                                <i class="fas fa-print mr-1"></i> Print Receipt
                            </button>
                        </div>
                    </div>

                </div>
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
    .content-wrapper { margin: 0 !important; box-shadow: none; }
    .card { border: none !important; box-shadow: none !important; }
}
</style>
@endpush