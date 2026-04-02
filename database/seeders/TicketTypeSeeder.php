<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TicketTypeSeeder extends Seeder
{
    public function run(): void
    {
        // First check your real event IDs
        // Run: SELECT event_id, event_name FROM events;
        
        DB::table('ticket_types')->insert([
            // Event 1
            [
                'event_id'   => 1,
                'name'       => 'VIP Ticket',
                'price'      => 150.00,
                'currency'   => 'USD',
                'quota'      => 100,
                'is_active'  => 1,
                'sale_start' => now(),
                'sale_end'   => now()->addDays(30),
            ],
            [
                'event_id'   => 1,
                'name'       => 'Standard Ticket',
                'price'      => 50.00,
                'currency'   => 'USD',
                'quota'      => 500,
                'is_active'  => 1,
                'sale_start' => now(),
                'sale_end'   => now()->addDays(30),
            ],
            [
                'event_id'   => 1,
                'name'       => 'Early Bird',
                'price'      => 35.00,
                'currency'   => 'USD',
                'quota'      => 200,
                'is_active'  => 1,
                'sale_start' => now(),
                'sale_end'   => now()->addDays(30),
            ],
        ]);
    }
}