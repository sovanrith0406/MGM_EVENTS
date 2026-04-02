<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Speaker extends Model
{
    // Important: Tell Laravel your primary key name
    protected $primaryKey = 'speaker_id';

    protected $fillable = [
        'full_name', 'title', 'company', 'bio', 
        'email', 'phone', 'photo_url', 'status'
    ];
    public function schedules()
    {
        return $this->belongsToMany(Schedule::class, 'schedule_speaker', 'speaker_id', 'schedule_id');
    }
}