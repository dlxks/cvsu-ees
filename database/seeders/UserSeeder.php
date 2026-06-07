<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'phone_number' => '639072203267',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ],
            [
                'name' => 'Personnel',
                'email' => 'personnel@admin.com',
                'phone_number' => '639558076389',
                'password' => Hash::make('password'),
                'role' => 'personnel',
            ],
        ]);
    }
}
