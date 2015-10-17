<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCollegesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('colleges', function(Blueprint $table) {
            $table->increments('collegeId');
            $table->string('collegeName');
            $table->string('collegeContactNo');
            $table->string('collegeEmailId')->unique();
            $table->integer('addressId')->unsigned();
            $table->foreign('addressId')->references('addressId')->on('addresses');
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
        Schema::drop('colleges');
    }
}
