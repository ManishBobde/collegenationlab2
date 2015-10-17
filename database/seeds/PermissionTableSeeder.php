<?php

use App\CN\CNPermissions\Permission;
use Faker\Factory as Faker;

class PermissionTableSeeder extends \Illuminate\Database\Seeder {
	
	/**
	 * Fills the salon users table with fake data
	 */
	public function run() {
		$faker = Faker::create ();
		//foreach ( range ( 1, 10 ) as $index ) {
			Permission::create ( [
					'permissionId' => 1,
                    'permissionType' => 1,
                    'permissionName' => 'CanCompose'
			] );
		}
	//}
}