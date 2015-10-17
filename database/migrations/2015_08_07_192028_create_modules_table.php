<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modules', function(Blueprint $table) {
            $table->increments('moduleId');
            $table->integer('moduleType')->unique();
            $table->string('moduleName');
            $table->string('moduleDesc');
            $table->string('subscriptionType');//Free or paid
            $table->string('basePrice');
            $table->string('moduleState');//active or deactive
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
        Schema::drop('modules');
    }
}
