<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		$this->call('AddressTableSeeder');
		$this->call('BucketTableSeeder');
		$this->call('CollegeTableSeeder');
		$this->call('PermissionTableSeeder');
		$this->call('RoleTableSeeder');
		$this->call('DomainTableSeeder');
		$this->call('DepartmentsTableSeeder');
		$this->call('CollegeDepartmentsTableSeeder');
		$this->call('UserTableSeeder');
		$this->call('NewsTableSeeder');
		$this->call('MessageTableSeeder');
		$this->call('EventsTableSeeder');
		$this->call('AccessTokenTableSeeder');

	}

}
