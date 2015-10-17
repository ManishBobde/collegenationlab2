<?php

use App\CN\CNRoles\RoleEnum;
use App\CN\CNUsers\User;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends \Illuminate\Database\Seeder {
	
	/**
	 * Fills the salon users table with fake data
	 */
	public function run() {
		$faker = Faker::create ();
		//foreach ( range ( 1, 10 ) as $index ) {
			User::create ( [
					'userId' => 1,
					'firstName' => 'Admin',
					'lastName' => 'Admin',
					'mobileNumber' => '7894561230',
					'email' => 'admin@somecollege.com',
					'password' => Hash::make('admin'),
					'avatarUrl'=> '/uploads/image.jpg',
					'roleId' => RoleEnum::ADMIN,
					'deptId' => 1,
					'collegeId' => 1,
					'slug'=>'Admin_Admin',
					'updated_at' => $faker->dateTime, // This is automatically added for the statement : $table->timestamp();
					'created_at' => $faker->dateTime // This is automatically added for the statement : $table->timestamp();
			] );

		User::create ( [
			'userId' => 2,
			'firstName' => 'Manish',
			'lastName' => 'Admin',
			'mobileNumber' => '1234',
			'email' => 'admin1@somecollege.com',
			'password' => Hash::make('admin1'),
			'roleId' => RoleEnum::LECTURER,
			'deptId' => 1,
			'collegeId' => 1,
			'slug'=>'Manish_Admin',
			'updated_at' => $faker->dateTime, // This is automatically added for the statement : $table->timestamp();
			'created_at' => $faker->dateTime // This is automatically added for the statement : $table->timestamp();
		] );
		}
	//}
}