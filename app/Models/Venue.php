<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    protected $primaryKey = 'venue_id';

    protected $fillable = [
        'name',
        'address',
        'city',
        'country',
        'capacity',
    ];

    public function events()
    {
        return $this->hasMany(Event::class, 'venue_id', 'venue_id');
    }
    public function create()
    {
        return view('backend.schedule.create', [
            'events'        => \App\Models\Event::all(),
            'speakers'      => \App\Models\Speaker::all(),
            'tracks'        => \App\Models\Track::all(),
            'rooms'         => \App\Models\Venue::all(),         // ← Venue model
            'eventVenueMap' => \App\Models\Event::pluck('venue_id', 'event_id'),
        ]);
    }
}