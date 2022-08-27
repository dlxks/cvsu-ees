<?php

namespace Database\Seeders;

use App\Helpers\Helper;
use App\Models\Applicant;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class ApplicantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // factory(Applicant::class, 10)->create();


        $applicant_id = Helper::IDGenerator(new Applicant(), 'id', 5, date('ym'));

        $user1 = User::create([
            'name' =>  'Tristan Sangangbayan',
            'email' => 'sangangbayant@gmail.com',
            'phone_number' => '639072203266',
            'role' => 'applicant',
            'password' => bcrypt('changetorandomstring')
        ]);
        $applicant1 = Applicant::create([
            'id' => $applicant_id,
            'user_id' => $user1->id,
            'fname' => 'Tristan',
            'mname' => 'Martinez',
            'lname' => 'Sangangbayan',
            'birthday' => '2000-08-31',
            'email' => 'sangangbayant@gmail.com',
            'phone_number' => '639072203266',
        ]);

        $user2 = User::create([
            'name' =>  'Dan Lloyd Rosarda',
            'email' => 'ljohnmark9@gmail.com',
            'phone_number' => '639558076388',
            'role' => 'applicant',
            'password' => bcrypt('changetorandomstring')
        ]);
        $applicant2 = Applicant::create([
            'id' => $applicant_id,
            'user_id' => $user2->id,
            'fname' => 'Dan Lloyd',
            'mname' => 'Martinez',
            'lname' => 'Rosarda',
            'birthday' => '2000-07-31',
            'email' => 'ljohnmark9@gmail.com',
            'phone_number' => '639558076388',
        ]);
    }
}
