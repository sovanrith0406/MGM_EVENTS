<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Venue;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::with('schedules.speakers', 'sponsors');

        if ($request->filled('search'))
            $query->where('event_name', 'like', '%' . $request->search . '%');
        if ($request->filled('status'))
            $query->where('status', $request->status);

        $events = $query->latest()->paginate(10);
        return view('backend.events.index', compact('events'));
    }

    public function create()
    {
        $venues = Venue::all();
        return view('backend.events.create', compact('venues'));
    }

    public function store(Request $request, Event $event)
    {
        $request->validate([
            'sponsor_id' => 'required|exists:sponsors,id',
            'tier'       => 'required|in:platinum,gold,silver,bronze,partner',
            'amount'     => 'nullable|numeric|min:0',
        ]);

        if ($event->sponsors()->where('sponsor_id', $request->sponsor_id)->exists()) {
            return back()->with('error', 'This sponsor is already attached to this event.');
        }

        $event->sponsors()->attach($request->sponsor_id, [
            'tier'   => $request->tier,
            'amount' => $request->amount,
        ]);

        return back()->with('success', 'Sponsor added to the event successfully.');
    }

    public function edit(Event $event)
    {
        $venues = Venue::all();
        return view('backend.events.edit', compact('event', 'venues'));
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'event_name' => 'required|string|max:180',
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
            'timezone'   => 'required|string',
            'venue_id'   => 'nullable|exists:venues,venue_id',
            'status'     => 'required|in:draft,published,cancelled,completed',
            'price'      => 'required|numeric|min:0',
            'currency'   => 'required|in:USD,KHR,EUR',
        ]);

        $event->update($request->only([
            'event_name',
            'description',
            'start_date',
            'end_date',
            'timezone',
            'venue_id',
            'status',
            'price',
            'currency',
        ]));

        return redirect()->route('events.index')
                        ->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('events.index')
                         ->with('success', 'Event deleted successfully.');
    }
}