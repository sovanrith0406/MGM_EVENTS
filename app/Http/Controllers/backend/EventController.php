<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

    public function store(Request $request)
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
            'image'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only([
            'event_name', 'description', 'start_date', 'end_date',
            'timezone', 'venue_id', 'status', 'price', 'currency',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('events', 'public');
        }

        $data['created_by'] = auth()->id();

        Event::create($data);

        return redirect()->route('events.index')
                         ->with('success', 'Event created successfully.');
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
            'image'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only([
            'event_name', 'description', 'start_date', 'end_date',
            'timezone', 'venue_id', 'status', 'price', 'currency',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image from storage if it exists
            if ($event->image) {
                Storage::disk('public')->delete($event->image);
            }
            $data['image'] = $request->file('image')->store('events', 'public');
        }

        $event->update($data);

        return redirect()->route('events.index')
                         ->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        // Delete image from storage when event is deleted
        if ($event->image) {
            Storage::disk('public')->delete($event->image);
        }

        $event->delete();

        return redirect()->route('events.index')
                         ->with('success', 'Event deleted successfully.');
    }
}