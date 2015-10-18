<?php

//use App\CN\CNAccessTokens\AccessToken;
//use App\AccessToken;
use App\CN\CNAccessTokens\AccessToken;
use Faker\Factory as Faker;

class AccessTokenTableSeeder extends \Illuminate\Database\Seeder {
	
	/**
	 * Fills the CN users table with fake data
	 */
	public function run() {
		$faker = Faker::create ();
		//foreach ( range ( 1, 10 ) as $index ) {
			AccessToken::create ( [
					'accessTokenId' => 1,
					'accessToken' => '33067484-c64d-4835-b356-6d2cbb299d6e',
					'pushRegistrationId'=>'33067484-c64d-4835-b356-6d2cbb299d6e',
					'deviceType' => 1,
					'mediaType' => 1,
					'osName' => 'Android',
					'userId' => 1,
					'updated_at' => $faker->dateTime,
					'created_at' => $faker->dateTime
			] );
		//}
	}
}