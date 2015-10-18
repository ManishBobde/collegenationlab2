<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function(Blueprint $table) {
            $table->increments('newsId');
            $table->string('newsTitle');
            $table->text('newsDescription');
            $table->string('newsImageUrl', 100)->nullable();
            $table->integer('creatorId')->unsigned();
            $table->foreign('creatorId')->references('userId')->on('users');
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
        Schema::drop('news');
    }
}
