<?php

use App\CN\CNColleges\College;
use Faker\Factory as Faker;

class CollegeTableSeeder extends \Illuminate\Database\Seeder {
	
	/**
	 * Fills the CN users table with fake data
	 */
	public function run() {
		$faker = Faker::create ();
		//foreach ( range ( 1, 10 ) as $index ) {
			College::create ( [
					'collegeId' => 1,
					'collegeName' => 'Test College',
					'collegeContactNo'=> '123456789',
					'collegeEmailId' => 'contact@testcollege.com',
					'addressId'=>1,
					'updated_at' => $faker->dateTime,
					'created_at' => $faker->dateTime 
			] );
		}
	//}
}