<?php

use App\CN\CNRoles\Role;
use App\CN\CNRoles\RoleEnum;
use Faker\Factory as Faker;

class RoleTableSeeder extends \Illuminate\Database\Seeder {
	
	/**
	 * Fills the salon users table with fake data
	 */
	/*public function run() {
		$faker = Faker::create ();
		foreach ( range ( 1, 10 ) as $index ) {
			RoleModel::create ( [
					'msg_title' => $faker->sentence,
					'msg_body' => $faker->paragraph(4),
					'updated_at' => $faker->dateTime,
					'created_at' => $faker->dateTime
			] );
		}
	}*/

	public function run(){

		DB::table('roles')->delete();

		$faker = Faker::create ();

		Role::create(array(
			'roleId' => RoleEnum::ADMIN,
			'roleType' => RoleEnum::ADMIN,
			'roleName' => 'Admin',
			'updated_at' => $faker->dateTime,
			'created_at' => $faker->dateTime
		));

		Role::create(array(
			'roleId' => RoleEnum::PRINCIPAL,
			'roleType' => RoleEnum::PRINCIPAL,
			'roleName' => 'Principal',
			'updated_at' => $faker->dateTime,
			'created_at' => $faker->dateTime
		));

		Role::create(array(
			'roleId' => RoleEnum::HOD,
			'roleType' => RoleEnum::HOD,
			'roleName' => 'HOD',
			'updated_at' => $faker->dateTime,
			'created_at' => $faker->dateTime
		));

		Role::create(array(
			'roleId' => RoleEnum::LECTURER,
			'roleType' => RoleEnum::LECTURER,
			'roleName' => 'Lecturer',
			'updated_at' => $faker->dateTime,
			'created_at' => $faker->dateTime
		));

		Role::create(array(
			'roleId' => RoleEnum::STUDENT,
			'roleType' => RoleEnum::STUDENT,
			'roleName' => 'Student',
			'updated_at' => $faker->dateTime,
			'created_at' => $faker->dateTime
		));



	}
}