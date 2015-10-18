<?php

use App\CN\CNNews\News;
use App\CN\CNRoles\RoleEnum;
use Faker\Factory as Faker;

class NewsTableSeeder extends \Illuminate\Database\Seeder {
	
	/**
	 * Fills the salon users table with fake data
	 */
	public function run() {
		$faker = Faker::create ();
		foreach ( range ( 1, 10 ) as $index ) {
			News::create ( [
					'newsId' => $index,
					'newsTitle' => $faker->title,
					'newsDescription' =>$faker->sentence,
					'creatorId' => RoleEnum::ADMIN,
					'collegeId' => 1,
					'updated_at'=> $faker->dateTime,
					'created_at'=> $faker->dateTime
			]);
		}
	}
}
