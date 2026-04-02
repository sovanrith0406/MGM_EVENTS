<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
     {
         DB::table('users')->insert([
            [
                 'role_id' => 1, // Assuming 1 is for Admins/Founders
                'full_name' => 'Sovanrith Tha',
                'email' => 'sovanrith.tha@gmail.com',
                 'password_hash' => Hash::make('securepassword123'), // Always hash passwords!
                'avatar_url' => 'https://ui-avatars.com/api/?name=Sovanrith+Tha&background=random', // Placeholder avatar
                'is_active' => 1,
                 'created_at' => now(),
                'updated_at' => now(),
             ],
             [
                 'role_id' => 2, // Assuming 2 is for standard users
                 'full_name' => 'John Doe',
                 'email' => 'john.doe@example.com',
                 'password_hash' => Hash::make('password123'),
                 'avatar_url' => null,
                 'is_active' => 1,
                 'created_at' => now(),
                 'updated_at' => now(),
            ]
         ]);
    }   
    
}