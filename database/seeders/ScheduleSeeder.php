<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = DB::table('schedule as s')
            ->leftJoin('rooms as r', 's.room_id', '=', 'r.room_id')
            ->leftJoin('venues as v', 'r.venue_id', '=', 'v.venue_id')
            ->leftJoin('tracks as t', 's.track_id', '=', 't.track_id')
            ->leftJoin('session_speakers as ss', 's.schedule_id', '=', 'ss.schedule_id')
            ->leftJoin('speakers as sp', 'ss.speaker_id', '=', 'sp.speaker_id')
            ->leftJoin('events as e', 's.event_id', '=', 'e.event_id')
            ->select(
                's.schedule_id',
                's.title',
                's.description',
                's.start_time',
                's.end_time',
                's.session_type',
                's.status',
                'r.room_name',
                'v.venue_name',
                't.track_name',
                'sp.full_name as speaker_name',
                'e.event_name'
            )
            ->orderBy('s.start_time', 'asc')
            ->get();

        return view('backend.schedule.index', [
            'Schedule' => $schedules,
        ]);
    }
}