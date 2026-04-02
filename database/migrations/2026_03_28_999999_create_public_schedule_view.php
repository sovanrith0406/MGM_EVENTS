<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    // public function up(): void
    // {
    //     DB::statement('DROP VIEW IF EXISTS v_public_schedule');

    //     DB::statement("
    //         CREATE VIEW v_public_schedule AS
    //         SELECT
    //             s.session_id,
    //             e.event_name,
    //             s.title,
    //             s.description,
    //             s.start_time,
    //             s.end_time,
    //             r.room_name,
    //             v.venue_name,
    //             t.track_name,
    //             s.session_type
    //         FROM event_sessions s   -- ← fix table name here
    //         JOIN events e ON s.event_id = e.event_id
    //         LEFT JOIN rooms r ON s.room_id = r.room_id
    //         LEFT JOIN venues v ON r.venue_id = v.venue_id
    //         LEFT JOIN tracks t ON s.track_id = t.track_id
    //     ");
    // }
    public function up(): void
    {
        DB::statement('DROP VIEW IF EXISTS v_public_schedule');

        // DB::statement("CREATE VIEW v_public_schedule AS ..."); // ← comment out temporarily
    }

    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS v_public_schedule');
    }
};