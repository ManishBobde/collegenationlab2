<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class CollegeDepartmentsTableSeeder extends Seeder
{
    public function run() {
       $faker = Faker::create ();
        //foreach ( range ( 1, 10 ) as $index ) {
        App\CN\CNCollegeDepartments\CollegeDepartment::create ( [
            'collegeDeptId' => 1,
            'teacherStrength' => 10,
            'academicYears'=> 6,
            'streamCapacity' => 60,
            'totalCapacity'=>60,
            'deptRegistrationToken'=> '33067484-c64d-4835-b356-6d2cbb299d6e',
            'deptId' => 1,
            'collegeId'=>1,
            'updated_at' => $faker->dateTime,
            'created_at' => $faker->dateTime
        ] );
        App\CN\CNCollegeDepartments\CollegeDepartment::create ( [
            'collegeDeptId' => 2,
            'teacherStrength' => 10,
            'academicYears'=> 6,
            'streamCapacity' => 60,
            'totalCapacity'=>60,
            'deptRegistrationToken'=> '209dbc3a-cf61-4659-9d0b-c375f73b6553',
            'deptId' => 2,
            'collegeId'=>1,
            'updated_at' => $faker->dateTime,
            'created_at' => $faker->dateTime
        ] );
    }
}
