<?php

use App\CN\CNMessages\Message;
use Faker\Factory as Faker;

class MessageTableSeeder extends \Illuminate\Database\Seeder {
	
	/**
	 * Fills the salon users table with fake data
	 */
	/*public function run() {
		$faker = Faker::create ();
		foreach ( range ( 1, 10 ) as $index ) {
			CNMessageModel::create ( [ 
					'msg_title' => $faker->sentence,
					'msg_body' => $faker->paragraph(4),
					'updated_at' => $faker->dateTime,
					'created_at' => $faker->dateTime 
			] );
		}
	}*/

	public function run(){

		DB::table('messages')->delete();

		$faker = Faker::create ();
		foreach ( range ( 1, 10 ) as $index ) {
			Message::create([
				'title' => $faker->sentence,
				'recipients' => $faker->name,
				'description' => $faker->text,
				'isRead' => 1,
				'userId' =>1,
				'senderId' => 1,
				'bucketId' =>1,
				'updated_at' => $faker->dateTime,
				'created_at' => $faker->dateTime
			]);
		}

	}
}