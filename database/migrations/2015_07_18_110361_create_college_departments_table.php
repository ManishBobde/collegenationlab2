<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCollegeDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collegedepartments', function(Blueprint $table) {
            $table->increments('collegeDeptId');
            $table->string('teacherStrength');
            $table->string('academicYears');
            $table->string('streamCapacity');
            $table->string('totalCapacity');//academicyears*streamCapacity
            $table->string('deptRegistrationToken');
            $table->integer('deptId')->unsigned();
            $table->foreign('deptId')->references('deptId')->on('departments');
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
        Schema::drop('collegedepartments');
    }
}
