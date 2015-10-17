<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccesstokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accesstokens', function(Blueprint $table) {
            $table->increments('accessTokenId');
            $table->string('accessToken');
            $table->string('deviceId')->unique()->nullable();//Type of Device-Mobile,Tab,PC
            $table->string('deviceType')->nullable();//Type of Device-Mobile,Tab,PC
            $table->string('mediaType')->nullable();//Browser or app
            $table->string('osName')->nullable();//android/iphone
            $table->integer('idleTimeAuthTokenExpirationDuration')->nullable();
            $table->integer('userId')->unsigned()->index();
            $table->foreign('userId')->references('userId')->on('users')->onDelete('cascade');
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
        Schema::drop('accesstokens');
    }
}
