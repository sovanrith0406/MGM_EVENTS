<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Speaker;
use App\Models\Sponsor;
use App\Models\Schedule;
use App\Models\SupplierBooking;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    // ── Home ──────────────────────────────────────────────────────────────────
    public function home()
    {
        $upcomingEvents  = Event::where('status', 'published')
                                ->whereDate('end_date', '>=', today())
                                ->orderBy('start_date')
                                ->take(6)->get();

        $featuredSpeakers = Speaker::where('status', 'active')->take(8)->get();
        $sponsors         = Sponsor::take(6)->get();
        $totalEvents      = Event::count();
        $totalSpeakers    = Speaker::count();
        $totalSponsors    = Sponsor::count();
        $totalBookings    = SupplierBooking::count();

        return view('frontend.home', compact(
            'upcomingEvents', 'featuredSpeakers', 'sponsors',
            'totalEvents', 'totalSpeakers', 'totalSponsors', 'totalBookings'
        ));
    }

    // ── Events List ───────────────────────────────────────────────────────────
    public function events(Request $request)
    {
        $query = Event::with('venue')
                      ->where('status', 'published')
                      ->whereDate('end_date', '>=', today());

        if ($request->filled('search'))
            $query->where('event_name', 'like', '%' . $request->search . '%');

        if ($request->filled('month'))
            $query->whereMonth('start_date', $request->month);

        $events = $query->orderBy('start_date')->paginate(9);

        return view('frontend.events', compact('events'));
    }

    // ── Event Detail ──────────────────────────────────────────────────────────
    public function eventShow(Event $event)
    {
        $event->load('venue');
        $speakers = Speaker::whereHas('schedules', fn($q) =>
            $q->where('event_id', $event->event_id)
        )->get();

        $schedules = Schedule::where('event_id', $event->event_id)
                             ->with('speakers')
                             ->orderBy('start_time')
                             ->get();

        $sponsors = Sponsor::whereHas('events', fn($q) =>
            $q->where('events.event_id', $event->event_id)
        )->get();

        return view('frontend.event-detail', compact('event', 'speakers', 'schedules', 'sponsors'));
    }

    // ── Speakers ──────────────────────────────────────────────────────────────
    public function speakers(Request $request)
    {
        $query = Speaker::query();

        if ($request->filled('search'))
            $query->where('full_name', 'like', '%' . $request->search . '%')
                  ->orWhere('company', 'like', '%' . $request->search . '%');

        $speakers = $query->where('status', 'active')->orderBy('full_name')->paginate(12);

        return view('frontend.speakers', compact('speakers'));
    }

    // ── Schedule ──────────────────────────────────────────────────────────────
    public function schedule(Request $request)
    {
        $events = Event::where('status', 'published')->orderBy('event_name')->get(['event_id', 'event_name']);

        $query = Schedule::with('speakers', 'event')->where('status', 'confirmed');

        if ($request->filled('event_id'))
            $query->where('event_id', $request->event_id);

        $schedules = $query->orderBy('start_time')->get();

        return view('frontend.schedule', compact('schedules', 'events'));
    }

    // ── Sponsors ──────────────────────────────────────────────────────────────
    public function sponsors()
    {
        $sponsors = Sponsor::with('events')->get();
        return view('frontend.sponsors', compact('sponsors'));
    }

    // ── Contact ───────────────────────────────────────────────────────────────
    public function contact()
    {
        $events = Event::where('status', 'published')->orderBy('event_name')->get(['event_id', 'event_name']);
        return view('frontend.contact', compact('events'));
    }

    public function contactSubmit(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:150',
            'email'   => 'required|email',
            'subject' => 'required|string|max:200',
            'message' => 'required|string',
        ]);

        \App\Models\MailboxMessage::create([
            'sender_name'      => $request->name,
            'sender_email'     => $request->email,
            'recipient_email'  => 'info@mgmevent.com',
            'subject'          => $request->subject,
            'body'             => $request->message,
            'folder'           => 'inbox',
            'event_id'         => $request->event_id ?: null,
        ]);

        return back()->with('success', 'Your message has been sent successfully!');
    }
    // ── Booking Form (public) ─────────────────────────────────────────────────────
    public function bookingForm(Event $event)
    {
        return view('frontend.booking', compact('event'));
    }

    public function bookingStore(Request $request, Event $event)
    {
        $request->validate([
            'supplier_name' => 'required|string|max:150',
            'email'         => 'required|email',
            'phone'         => 'nullable|string|max:30',
            'service_type'  => 'required|string|max:100',
            'notes'         => 'nullable|string',
        ]);
        \App\Models\SupplierBooking::create([
        'event_id'      => $event->event_id,
        'user_id'       => auth()->id(),   // ← add this
        'supplier_name' => $request->supplier_name,
        'email'         => $request->email,
        'phone'         => $request->phone,
        'service_type'  => $request->service_type,
        'notes'         => $request->notes,
        'status'        => 'pending',
    ]);

        return back()->with('success', 'Your registration has been submitted! Our team will contact you shortly.');
    }
    
}