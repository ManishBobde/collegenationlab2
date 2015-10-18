<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttachmentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('attachments', function(Blueprint $table) {
			$table->increments('attachmentId');
			$table->string('fileName');
			$table->string('fileType')->unique()->nullable();
			$table->integer('fileSize')->nullable();
			$table->string('attachmentUrl')->nullable();
			$table->string('attachmentPreviewUrl')->nullable();
			$table->integer('messageId')->unsigned()->index();
			$table->foreign('messageId')->references('messageId')->on('messages')->onDelete('cascade');
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
		Schema::drop('attachments');
	}

}
