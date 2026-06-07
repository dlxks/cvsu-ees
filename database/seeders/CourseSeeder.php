<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\DB;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('courses')->insert([
            [
                'college_id' =>  1,
                'course_name' => 'BSCE',
                'course_desc' => 'BS Computer Engineering',
            ],
            [
                'college_id' =>  1,
                'course_name' => 'BSIT',
                'course_desc' => 'BS Information Technology',
            ],
            [
                'college_id' =>  1,
                'course_name' => 'BSCS',
                'course_desc' => 'BS Computer Science',
            ],
            [
                'college_id' =>  2,
                'course_name' => 'BSMT',
                'course_desc' => 'BS Medical Technology',
            ],
            [
                'college_id' =>  2,
                'course_name' => 'BSM',
                'course_desc' => 'BS Nursing',
            ],
            [
                'college_id' =>  9,
                'course_name' => 'BSA',
                'course_desc' => 'BS Agriculture',
            ],
            [
                'college_id' =>  9,
                'course_name' => 'BSFT',
                'course_desc' => 'BS Food Technology',
            ],
        ]);
    }
}
