<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpeakerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Speaker::create([
        'full_name' => 'John Doe',
        'title'     => 'Senior Developer',
        'company'   => 'Tech Corp',
        'bio'       => 'Expert in Laravel and database design.',
        'email'     => 'john@example.com',
        'status'    => 'active',
    ]);
    }
}
