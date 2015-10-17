<?php

use App\CN\CNBuckets\Bucket;
use Faker\Factory as Faker;

class BucketTableSeeder extends \Illuminate\Database\Seeder {

	/**
	 * Fills the CN users table with fake data
	 */
	public function run() {
		$faker = Faker::create ();
		$buckets = "Inbox Sent Draft Trash Outbox";
		$array=explode(" ", $buckets);
		foreach ( range ( 0, 4 ) as $index ) {
			Bucket::create ( [
					'bucketType' => $index+1,
					'bucketName' =>$array[$index],
					'updated_at' => $faker->dateTime,
					'created_at' => $faker->dateTime
			] );
		}
	}
}