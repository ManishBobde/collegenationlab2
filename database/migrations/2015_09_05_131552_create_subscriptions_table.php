<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function(Blueprint $table) {
            $table->increments('subscriptionId');
            $table->string('subscriptionInDays')->nullable();
            $table->string('subscriptionInMonths')->nullable();
            $table->string('subscriptionInYears')->nullable();
            $table->string('subscriptionTotalPrice')->nullable();
            $table->integer('moduleId')->unsigned();
            $table->foreign('moduleId')->references('moduleId')->on('modules');
            $table->integer('collegeId')->unsigned();
            $table->foreign('collegeId')->references('collegeId')->on('colleges');
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
        Schema::drop('subscriptions');
    }
}
