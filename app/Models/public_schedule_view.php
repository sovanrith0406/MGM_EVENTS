<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class public_schedule_view extends Model
{
    //
    // 1. Tell Laravel to look at the VIEW, not a table
    protected $table = 'v_public_schedule';

    // 2. Since it's a VIEW, it likely doesn't have a standard 'id' incrementing key
    protected $primaryKey = 'session_id';
    public $incrementing = false;

    // 3. Views are usually read-only
    public $timestamps = false;
}
