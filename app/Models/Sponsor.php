<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model
{
    protected $primaryKey = 'sponsor_id';

    protected $fillable = [
        'name', 'website', 'logo_url',
        'contact_name', 'contact_email', 'contact_phone',
    ];

    public function events()
    {
        return $this->belongsToMany(
            Event::class,
            'event_sponsors',
            'sponsor_id',
            'event_id'
        )->withPivot('tier', 'amount');
    }
}