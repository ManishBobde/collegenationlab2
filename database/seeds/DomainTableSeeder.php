<?php

use App\CN\CNDomains\Domains;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DomainTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $faker = Faker::create ();
        //foreach ( range ( 1, 10 ) as $index ) {
        Domains::create ( [
            'domainId' => 1,
            'domainName' => 'Engineering',
            'updated_at' => $faker->dateTime,
            'created_at' => $faker->dateTime
        ] );
    }
}
