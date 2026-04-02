<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $primaryKey = 'event_id';

    protected $fillable = [
        'venue_id', 'event_name', 'description',
        'start_date', 'end_date', 'timezone',
        'status', 'created_by',
        'price',
        'currency',
    ];

    // ── Relationships ────────────────────────────────────────────
    public function venue()
    {
        return $this->belongsTo(Venue::class, 'venue_id', 'venue_id');
    }

    public function schedules()
    {
        return $this->hasMany(\App\Models\Schedule::class, 'event_id', 'event_id');
    }

    public function ticketTypes()
    {
        return $this->hasMany(TicketType::class, 'event_id', 'event_id');
    }

    public function supplierBookings()
    {
        return $this->hasMany(SupplierBooking::class, 'event_id', 'event_id');
    }

    public function orders()
    {
        return $this->hasMany(SupplierBooking::class, 'event_id', 'event_id');
    }

    public function sponsors()
    {
        return $this->belongsToMany(
            Sponsor::class,
            'event_sponsors',
            'event_id',
            'sponsor_id'
        )->withPivot('tier', 'amount');
    }
}