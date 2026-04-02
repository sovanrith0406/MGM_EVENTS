<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $table = 'schedule';
    protected $primaryKey = 'schedule_id';

    protected $fillable = [
        'event_id',
        'track_id',
        'room_id',
        'title',
        'description',
        'start_time',
        'end_time',
        'session_type',
        'status',
        'capacity',
    ];

    // ── Relationships ────────────────────────────────────────────
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id', 'event_id');
    }

    public function speakers()
    {
        return $this->belongsToMany(
            Speaker::class,
            'session_speakers',  // pivot table
            'schedule_id',       // FK on pivot pointing to schedule
            'speaker_id'         // FK on pivot pointing to speakers
        );
    }
}