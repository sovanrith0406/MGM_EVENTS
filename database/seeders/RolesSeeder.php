<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing records to avoid duplicates if you run it multiple times
        // DB::table('roles')->truncate(); // Uncomment if you want to wipe the table before seeding

        DB::table('roles')->insert([
            [
                'role_id' => 1,
                'role_name' => 'Admin',
            ],
            [
                'role_id' => 2,
                'role_name' => 'User',
            ],
            [
                'role_id' => 3,
                'role_name' => 'Supplier',
            ]
        ]);
    }
}