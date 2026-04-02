<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    protected $primaryKey = 'track_id';

    protected $fillable = ['event_id', 'track_name', 'sort_order'];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id', 'event_id');
    }
}