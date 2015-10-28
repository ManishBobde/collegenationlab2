<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSectionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('departmentsections', function(Blueprint $table) {
			$table->increments('sectionId');
			$table->string('teacherStrength');
			$table->string('academicYears');
			$table->string('streamCapacity');
			$table->string('totalCapacity');//academicyears*streamCapacity
			$table->string('deptRegistrationToken');
			$table->integer('semesterId')->unsigned();
			$table->foreign('semesterId')->references('semesterId')->on('departmentsemesters');
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
		Schema::drop('departmentsections');

	}

}
