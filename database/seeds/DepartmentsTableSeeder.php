<?php

//use App\CN\CNAccessTokens\AccessToken;
//use App\AccessToken;
use App\CN\CNAccessTokens\AccessToken;
use App\CN\CNDepartments\Department;
use Faker\Factory as Faker;

class DepartmentsTableSeeder extends \Illuminate\Database\Seeder {
	
	/**
	 * Fills the CN Departments table with fake data
	 */
	public function run() {
		$faker = Faker::create ();
		//foreach ( range ( 1, 10 ) as $index ) {
			DepartMent::create ( [
					'deptId' => 1,
					'deptStreamName' => 'Computer Science',
					'domainId' => 1,
					'updated_at' => $faker->dateTime,
					'created_at' => $faker->dateTime
			] );
		DepartMent::create ( [
			'deptId' => 2,
			'deptStreamName' => 'Information Technology',
			'domainId' => 1,
			'updated_at' => $faker->dateTime,
			'created_at' => $faker->dateTime
		] );
		//}
	}
}