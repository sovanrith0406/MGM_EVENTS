<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SponsorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $sponsors = DB::table('event_sponsors as es')
    ->join('sponsors as s', 'es.sponsor_id', '=', 's.sponsor_id')
    ->join('events as e',   'es.event_id',   '=', 'e.event_id')
    ->select(
        's.sponsor_id',
        's.name as sponsor_name',
        's.logo_url',
        's.website',
        's.contact_name',
        's.contact_email',
        'e.event_name',
        'es.tier',
        'es.amount'
    )
    ->orderBy('es.tier')
    ->get();
    }
}
