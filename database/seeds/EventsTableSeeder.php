<?php

use App\CN\CNEvents\Event;
use App\CN\CNEvents\Events;
use App\CN\CNRoles\RoleEnum;
use Faker\Factory as Faker;

class EventsTableSeeder extends \Illuminate\Database\Seeder {
	
	/**
	 * Fills the CN users table with fake data
	 */
	public function run() {
		$faker = Faker::create ();
		foreach ( range ( 1, 10 ) as $index ) {
			Events::create ( [
					'eventId' => $index,
					'eventTitle' => $faker->title,
					'eventDescription' => $faker->sentence,
					'startDate' => $faker->dateTime,
					'endDate' => $faker->dateTime,
					'startTime' => $faker->time(),
					'endTime' => $faker->time(),
					'creatorId' => RoleEnum::ADMIN,
					'collegeId' => 1,
					'updated_at' => $faker->dateTime,
					'created_at' => $faker->dateTime
			] );
		}
	}
}