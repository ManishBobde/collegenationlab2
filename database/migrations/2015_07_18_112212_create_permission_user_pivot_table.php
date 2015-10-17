<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionUserPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permission_user', function(Blueprint $table) {
            $table->integer('permissionId')->unsigned()->index();
            $table->foreign('permissionId')->references('permissionId')->on('permissions')->onDelete('cascade');
            $table->integer('userId')->unsigned()->index();
            $table->foreign('userId')->references('userId')->on('users')->onDelete('cascade');
            $table->boolean('isEnabled');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('permission_user');
    }
}
