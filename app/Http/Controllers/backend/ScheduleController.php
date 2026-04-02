<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = DB::table('schedule as s')
            ->leftJoin('rooms as r',           's.room_id',     '=', 'r.room_id')
            ->leftJoin('venues as v',           'r.venue_id',    '=', 'v.venue_id')
            ->leftJoin('tracks as t',           's.track_id',    '=', 't.track_id')
            ->leftJoin('session_speakers as ss','s.schedule_id', '=', 'ss.schedule_id')
            ->leftJoin('speakers as sp',        'ss.speaker_id', '=', 'sp.speaker_id')
            ->leftJoin('events as e',           's.event_id',    '=', 'e.event_id')
            ->select(
                's.schedule_id', 's.title', 's.start_time', 's.end_time',
                's.session_type', 's.status',
                'r.room_name', 'v.venue_name', 't.track_name',
                'sp.full_name as speaker_name', 'e.event_name'
            )
            ->orderBy('s.start_time', 'asc')
            ->get();

        return view('backend.schedule.index', [
            'Schedule'             => $schedules,
            'public_schedule_view' => $schedules,
        ]);
    }

    public function create()
    {
        // Fetch events WITH start_date & end_date for JS date constraints
        $events = DB::table('events')
            ->select('event_id', 'event_name', 'start_date', 'end_date', 'venue_id')
            ->get();

        // Fetch tracks WITH event_id for JS filtering
        $tracks = DB::table('tracks')
            ->select('track_id', 'track_name', 'event_id')
            ->get();

        // Fetch rooms WITH venue_id for JS filtering
        $rooms = DB::table('rooms')
            ->select('room_id', 'room_name', 'venue_id')
            ->get();

        // Fetch speakers
        $speakers = DB::table('speakers')
            ->select('speaker_id', 'full_name', 'company', 'title')
            ->get();

        // Build event → venue map for JS: { event_id: venue_id, ... }
        $eventVenueMap = $events->pluck('venue_id', 'event_id');

        return view('backend.schedule.create', compact(
            'events', 'tracks', 'rooms', 'speakers', 'eventVenueMap'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'         => 'required|string|max:200',
            'event_id'      => 'required|exists:events,event_id',
            'session_type'  => 'required|in:talk,workshop,panel,keynote,break,networking',
            'start_time'    => 'required|date',
            'end_time'      => 'required|date|after:start_time',
            'status'        => 'required|in:draft,pending,confirmed,cancelled',
            'capacity'      => 'nullable|integer|min:1',
            'speaker_ids'   => 'nullable|array',
            'speaker_ids.*' => 'exists:speakers,speaker_id',
        ]);

        $startTime = Carbon::parse($request->start_time)->format('Y-m-d H:i:s');
        $endTime   = Carbon::parse($request->end_time)->format('Y-m-d H:i:s');

        $scheduleId = DB::table('schedule')->insertGetId([
            'event_id'     => $request->event_id,
            'track_id'     => $request->track_id   ?: null,
            'room_id'      => $request->room_id     ?: null,
            'title'        => $request->title,
            'description'  => $request->description ?: null,
            'start_time'   => $startTime,
            'end_time'     => $endTime,
            'session_type' => $request->session_type,
            'status'       => $request->status,
            'capacity'     => $request->capacity    ?: null,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        if ($request->filled('speaker_ids')) {
            $rows = [];
            foreach ($request->speaker_ids as $speakerId) {
                $rows[] = [
                    'schedule_id'  => $scheduleId,
                    'speaker_id'   => $speakerId,
                    'speaker_role' => $request->speaker_role ?? 'speaker',
                ];
            }
            DB::table('session_speakers')->insert($rows);
        }

        return redirect('/schedule')->with('success', 'Schedule created successfully!');
    }

    public function edit(string $id)
    {
        $schedule = DB::table('schedule')->where('schedule_id', $id)->first();

        if (!$schedule) abort(404);

        $selectedSpeakerIds = DB::table('session_speakers')
            ->where('schedule_id', $id)
            ->pluck('speaker_id')
            ->toArray();

        $assignedSpeakers = DB::table('speakers')
            ->whereIn('speaker_id', $selectedSpeakerIds)
            ->select('speaker_id', 'full_name')
            ->get();

        $currentRole = DB::table('session_speakers')
            ->where('schedule_id', $id)
            ->value('speaker_role') ?? 'speaker';

        $events = DB::table('events')
            ->select('event_id', 'event_name', 'start_date', 'end_date', 'venue_id')
            ->get();

        $tracks = DB::table('tracks')
            ->select('track_id', 'track_name', 'event_id')
            ->get();

        $rooms = DB::table('rooms')
            ->select('room_id', 'room_name', 'venue_id')
            ->get();

        $speakers = DB::table('speakers')
            ->select('speaker_id', 'full_name', 'company', 'title')
            ->get();

        $eventVenueMap = $events->pluck('venue_id', 'event_id');

        return view('backend.schedule.edit', compact(
            'schedule', 'events', 'tracks', 'rooms', 'speakers',
            'selectedSpeakerIds', 'assignedSpeakers', 'currentRole', 'eventVenueMap'
        ));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'title'         => 'required|string|max:200',
            'event_id'      => 'required|exists:events,event_id',
            'session_type'  => 'required|in:talk,workshop,panel,keynote,break,networking',
            'start_time'    => 'required|date',
            'end_time'      => 'required|date|after:start_time',
            'status'        => 'required|in:draft,pending,confirmed,cancelled',
            'capacity'      => 'nullable|integer|min:1',
            'speaker_ids'   => 'nullable|array',
            'speaker_ids.*' => 'exists:speakers,speaker_id',
        ]);

        DB::table('schedule')->where('schedule_id', $id)->update([
            'event_id'     => $request->event_id,
            'track_id'     => $request->track_id    ?: null,
            'room_id'      => $request->room_id      ?: null,
            'title'        => $request->title,
            'description'  => $request->description  ?: null,
            'start_time'   => Carbon::parse($request->start_time)->format('Y-m-d H:i:s'),
            'end_time'     => Carbon::parse($request->end_time)->format('Y-m-d H:i:s'),
            'session_type' => $request->session_type,
            'status'       => $request->status,
            'capacity'     => $request->capacity     ?: null,
            'updated_at'   => now(),
        ]);

        DB::table('session_speakers')->where('schedule_id', $id)->delete();

        if ($request->filled('speaker_ids')) {
            $rows = [];
            foreach ($request->speaker_ids as $speakerId) {
                $rows[] = [
                    'schedule_id'  => $id,
                    'speaker_id'   => $speakerId,
                    'speaker_role' => $request->speaker_role ?? 'speaker',
                ];
            }
            DB::table('session_speakers')->insert($rows);
        }

        return redirect('/schedule')->with('success', 'Schedule updated successfully!');
    }

    public function destroy(string $id)
    {
        DB::table('session_speakers')->where('schedule_id', $id)->delete();
        DB::table('schedule')->where('schedule_id', $id)->delete();

        return redirect('/schedule')->with('success', 'Schedule deleted successfully!');
    }
}