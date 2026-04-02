<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierBooking extends Model
{
    protected $primaryKey = 'booking_id';

    protected $fillable = [
        'event_id',
        'track_id',
        'supplier_name',
        'description',
        'booking_date',
        'amount',
        'currency',
        'status',
        'created_by',
    ];

    protected $casts = [
        'booking_date' => 'date',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id', 'event_id');
    }

    public function track()
    {
        return $this->belongsTo(Track::class, 'track_id', 'track_id');
    }
}