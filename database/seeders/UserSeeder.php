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
            // [
            //     'name' =>  'Tristan Sangangbayan',
            //     'email' => 'sangangbayant@gmail.com',
            //     'phone' => '639072203266',
            //     'password' => bcrypt('changetorandomstring'),
            //     'role' => 'applicant',
            // ],
            // [
            //     'name' =>  'Dan Lloyd Rosarda',
            //     'email' => 'danlloyd.rosarda@cvsu.edu.ph',
            //     'phone' => '639761830787',
            //     'password' => bcrypt('changetorandomstring'),
            //     'role' => 'applicant',
            // ],
        ]);
    }
}
