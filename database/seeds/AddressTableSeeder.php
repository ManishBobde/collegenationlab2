<?php

use App\CN\CNAddresses\Address;
use Faker\Factory as Faker;

class AddressTableSeeder extends \Illuminate\Database\Seeder {
	
	/**
	 * Fills the address  table with fake data
	 */
	public function run() {
		$faker = Faker::create ();
		//foreach ( range ( 1, 10 ) as $index ) {

		Address::create ( [
					'street1' => 'some street',
					'city' => 'nagpur',
					'state' => 'maharashtra',
					'country' => 'india',
					'pinCode' => 400001
			] );
		}
	//}
}