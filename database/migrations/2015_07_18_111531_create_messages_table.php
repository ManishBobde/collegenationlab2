<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function(Blueprint $table) {
            $table->increments('messageId');
            $table->string('title');
            $table->string('recipients');
            $table->text('description')->nullable();
            $table->boolean('isRead')->default('0');
            $table->integer('userId')->unsigned();
            $table->foreign('userId')->references('userId')->on('users');
            $table->integer('senderId')->unsigned();
            $table->foreign('senderId')->references('userId')->on('users');
            $table->integer('bucketId')->unsigned();
            $table->foreign('bucketId')->references('bucketId')->on('buckets');
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
        Schema::drop('messages');
    }
}
