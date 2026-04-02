<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\SupplierBooking;
use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplierBookingController extends Controller
{
    private function scopedQuery()
    {
        $query = SupplierBooking::with('event')
            ->where('status', '!=', 'cancelled');

        if ($this->isSupplier()) {
            $query->where('created_by', Auth::id());
        }

        return $query;
    }

    private function isSupplier(): bool
    {
        return strtolower(Auth::user()->role->role_name) === 'supplier';
    }

    // ── Active events helper (end_date >= today) ──────────────────────────────
    private function activeEvents()
    {
        return Event::whereDate('end_date', '>=', today())
                    ->orderBy('event_name')
                    ->get(['event_id', 'event_name', 'price', 'currency', 'end_date']);
    }

    // ── Index ─────────────────────────────────────────────────────────────────
    public function index()
    {
        $bookings = $this->scopedQuery()->latest()->paginate(15);
        return view('backend.supplier_bookings.index', compact('bookings'));
    }

    // ── Show (Receipt) ────────────────────────────────────────────────────────
    public function show(SupplierBooking $supplier_booking)
    {
        if ($this->isSupplier() && $supplier_booking->created_by !== Auth::id()) {
            abort(403, 'You do not have permission to view this booking.');
        }
        $supplier_booking->load('event', 'track');
        return view('backend.supplier_bookings.show', compact('supplier_booking'));
    }

    // ── Create ────────────────────────────────────────────────────────────────
    public function create()
    {
        $events = $this->activeEvents();
        $tracks = collect(); // empty until event is selected via AJAX
        return view('backend.supplier_bookings.create', compact('events', 'tracks'));
    }

    // ── Store ─────────────────────────────────────────────────────────────────
    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_id'      => 'required|exists:events,event_id',
            'track_id'      => 'nullable|exists:tracks,track_id',
            'supplier_name' => 'required|string|max:150',
            'description'   => 'nullable|string|max:255',
            'booking_date'  => 'required|date',
            'status'        => 'required|in:pending,confirmed,cancelled,paid',
        ]);

        $event = Event::where('event_id', $validated['event_id'])
                      ->select('event_id', 'price', 'currency')
                      ->firstOrFail();

        $validated['amount']     = (float) $event->getRawOriginal('price') ?: 0;
        $validated['currency']   = $event->currency ?? 'USD';
        $validated['created_by'] = Auth::id();

        SupplierBooking::create($validated);

        return redirect()->route('supplier_booking.index')
            ->with('success', 'Booking created successfully.');
    }

    // ── Edit ──────────────────────────────────────────────────────────────────
    public function edit(SupplierBooking $supplier_booking)
    {
        if ($this->isSupplier() && $supplier_booking->created_by !== Auth::id()) {
            abort(403, 'You do not have permission to edit this booking.');
        }

        $events = Event::whereDate('end_date', '>=', today())
                    ->orWhere('event_id', $supplier_booking->event_id)
                    ->orderBy('event_name')
                    ->get(['event_id', 'event_name', 'price', 'currency', 'end_date']);

        $tracks = Track::where('event_id', $supplier_booking->event_id)
                       ->orderBy('sort_order')
                       ->get();

        return view('backend.supplier_bookings.edit', compact('supplier_booking', 'events', 'tracks'));
    }

    // ── AJAX: get tracks by event ─────────────────────────────────────────────
    public function tracksByEvent(Request $request)
    {
        $tracks = Track::where('event_id', $request->event_id)
                       ->orderBy('sort_order')
                       ->get(['track_id', 'track_name']);

        return response()->json($tracks);
    }

    // ── Update ────────────────────────────────────────────────────────────────
    public function update(Request $request, SupplierBooking $supplier_booking)
    {
        if ($this->isSupplier() && $supplier_booking->created_by !== Auth::id()) {
            abort(403, 'You do not have permission to update this booking.');
        }

        $validated = $request->validate([
            'event_id'      => 'required|exists:events,event_id',
            'supplier_name' => 'required|string|max:150',
            'description'   => 'nullable|string|max:255',
            'booking_date'  => 'required|date',
            'status'        => 'required|in:pending,confirmed,cancelled,paid',
        ]);

        $event = Event::where('event_id', $validated['event_id'])
                      ->select('event_id', 'price', 'currency')
                      ->firstOrFail();

        $validated['amount']   = (float) $event->getRawOriginal('price') ?: 0;
        $validated['currency'] = $event->currency ?? 'USD';

        $supplier_booking->update($validated);

        return redirect()->route('supplier_booking.index')
            ->with('success', 'Booking updated successfully.');
    }

    // ── Destroy (Soft Cancel) ─────────────────────────────────────────────────
    public function destroy(SupplierBooking $supplier_booking)
    {
        if ($this->isSupplier()) {
            abort(403, 'You do not have permission to delete bookings.');
        }

        $supplier_booking->update(['status' => 'cancelled']);

        return redirect()->route('supplier_booking.index')
            ->with('success', 'Booking has been cancelled successfully.');
    }
}