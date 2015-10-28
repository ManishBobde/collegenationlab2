<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateSemesterTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('departmentsemesters', function(Blueprint $table) {
			$table->increments('semesterId');
			$table->string('teacherStrength');
			$table->string('academicYears');
			$table->string('streamCapacity');
			$table->string('totalCapacity');//academicyears*streamCapacity
			$table->string('deptRegistrationToken');
			$table->integer('collegeDeptId')->unsigned();
			$table->foreign('collegeDeptId')->references('collegeDeptId')->on('collegedepartments');
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
		Schema::drop('departmentsemesters');
	}

}
