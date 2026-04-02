<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    //
    public function create()
    {
        return view('backend.schedule.create', [
            'events'        => \App\Models\Event::all(),
            'speakers'      => \App\Models\Speaker::all(),
            'tracks'        => \App\Models\Track::all(),
            'rooms'         => \App\Models\Room::all(),
            'eventVenueMap' => \App\Models\Event::pluck('venue_id', 'event_id'),
        ]);
    }
    protected $primaryKey = 'room_id';
    public $timestamps = false; // add this if your rooms table has no created_at/updated_at
}

