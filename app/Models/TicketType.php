<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketType extends Model
{
    protected $primaryKey = 'ticket_type_id';

    protected $fillable = [
        'event_id',
        'name',
        'price',
        'currency',
        'quota',
        'sale_start',
        'sale_end',
        'is_active',
    ];

    protected $casts = [
        'sale_start' => 'datetime',
        'sale_end'   => 'datetime',
        'is_active'  => 'boolean',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id', 'event_id');
    }
}