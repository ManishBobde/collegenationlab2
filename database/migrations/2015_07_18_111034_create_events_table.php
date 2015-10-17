<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function(Blueprint $table) {
            $table->increments('eventId');
            $table->string('eventTitle');
            $table->text('eventDesc');
            $table->timestamp('startDate');
            $table->timestamp('endDate')->nullable();
            $table->time('startTime');
            $table->time('endTime')->nullable();
            $table->string('eventImageUrl', 100)->nullable();
            $table->integer('creatorId')->unsigned();
            $table->foreign('creatorId')->references('userId')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('events');
    }
}
