<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->updateOrInsert(
            ['email' => 'admin@example.com'], // Conditions to check if the record exists
            [
                'name' => 'Admin',
                'password' => Hash::make('password'), // Use Hash::make to hash the password
                'phone' => '1234567890',
            ]
        );
    }
}
