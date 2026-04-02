<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\SupplierBooking;
use Illuminate\Http\Request;

class BookingReportController extends Controller
{
    public function index(Request $request)
    {
        $events = Event::orderBy('event_name')->get(['event_id', 'event_name']);

        $query = SupplierBooking::with('event', 'track')
            ->when($request->filled('event_id'), fn($q) =>
                $q->where('event_id', $request->event_id))
            ->when($request->filled('status'), fn($q) =>
                $q->where('status', $request->status))
            ->when($request->filled('date_from'), fn($q) =>
                $q->whereDate('booking_date', '>=', $request->date_from))
            ->when($request->filled('date_to'), fn($q) =>
                $q->whereDate('booking_date', '<=', $request->date_to))
            ->latest('booking_date');

        $bookings = $query->paginate(15)->withQueryString();

        // Summary totals (unfiltered by pagination)
        $summary        = $query->getQuery()->get();
        $totalBookings  = $summary->count();
        $countPaid      = $summary->where('status', 'paid')->count();
        $countPending   = $summary->where('status', 'pending')->count();
        $countConfirmed = $summary->where('status', 'confirmed')->count();
        $countCancelled = $summary->where('status', 'cancelled')->count();
        $totalAmount    = $summary->where('status', 'paid')->sum('amount'); // paid only

        return view('backend.reports.booking', compact(
            'bookings', 'events',
            'totalAmount', 'totalBookings',
            'countPaid', 'countPending', 'countConfirmed', 'countCancelled'
        ));
    }
}