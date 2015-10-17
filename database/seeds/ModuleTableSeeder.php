<?php

use App\CN\CNModules\Module;
use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class ModuleTableSeederTableSeeder extends Seeder
{
    /**
     * Fills the CN Modules table with fake data
     */
    public function run() {
        $module = "Messages News Events Time-Table Attendance MeetingInvites";
        $modules = explode(" ", $module);
        $faker = Faker::create ();
        foreach ( range ( 0, 6 ) as $index ) {
            Module::create ( [
                'moduleId' => $index+1,
                'moduleType' => $index+1,
                'moduleName' => $modules[$index],
                'moduleDesc' => "Some Description",
                'subscriptionType' => "free",
                'basePrice' => 100 + $index,
                'created_at' => $faker->dateTime,
                'updated_at' => $faker->dateTime
            ] );
        }
    }
}
