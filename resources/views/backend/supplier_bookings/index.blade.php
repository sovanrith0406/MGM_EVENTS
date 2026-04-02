{{-- resources/views/backend/supplier_bookings/index.blade.php --}}
@extends('backend.layouts.master')
@section('title', 'Supplier Bookings | Event')
@section('b_menu-open', 'menu-open')
@section('b_active', 'active')

@section('main-content')
<div class="content-wrapper">

    {{-- Page Header --}}
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Supplier Bookings</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Supplier Bookings</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mx-3">
            <strong>Success!</strong> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mx-3">
            <strong>Error!</strong> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    <section class="content">
        <div class="container-fluid">
            <div class="card">

                {{-- Card Header --}}
                <div class="card-header d-flex justify-content-between align-items-center">
                    <a href="{{ route('supplier_booking.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus mr-1"></i> Add Booking
                    </a>

                    @if(strtolower(auth()->user()->role->role_name) === 'supplier')
                        <span class="badge badge-info px-3 py-2">
                            <i class="fas fa-eye mr-1"></i> Viewing your bookings only
                        </span>
                    @endif
                </div>

                <div class="card-body p-0">
                    <table class="table table-striped projects">
                        <thead>
                            <tr>
                                <th style="width:1%">#</th>
                                <th style="width:22%">Title Event</th>
                                <th style="width:15%">Date</th>
                                <th style="width:13%">Amount</th>
                                <th style="width:15%" class="text-center">Status</th>
                                <th style="width:20%" class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bookings as $booking)
                            <tr>
                                <td>{{ $loop->iteration + ($bookings->currentPage() - 1) * $bookings->perPage() }}</td>

                                <td>
                                    <strong>{{ $booking->event->event_name ?? '—' }}</strong>
                                    @if($booking->supplier_name)
                                        <br><small class="text-muted">{{ $booking->supplier_name }}</small>
                                    @endif
                                </td>

                                {{-- Safe date format regardless of cast --}}
                                <td>{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</td>

                                <td>{{ $booking->currency }} {{ number_format($booking->amount, 2) }}</td>

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

                                <td class="text-right">
                                    <a href="{{ route('supplier_booking.show', $booking->booking_id) }}"
                                       class="btn btn-success btn-sm" title="Receipt">
                                        <i class="fas fa-receipt"></i> Receipt
                                    </a>
                                    <a href="{{ route('supplier_booking.edit', $booking->booking_id) }}"
                                       class="btn btn-info btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>

                                    @if(strtolower(auth()->user()->role->role_name) !== 'supplier')
                                        <form action="{{ route('supplier_booking.destroy', $booking->booking_id) }}"
                                              method="POST" class="d-inline"
                                              onsubmit="return confirm('Cancel this booking?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    No bookings found.
                                    <a href="{{ route('supplier_booking.create') }}">Add one now.</a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($bookings->hasPages())
                <div class="card-footer">
                    {{ $bookings->links() }}
                </div>
                @endif

            </div>
        </div>
    </section>
</div>
@endsection