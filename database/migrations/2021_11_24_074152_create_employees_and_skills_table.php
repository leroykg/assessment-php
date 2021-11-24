<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesAndSkillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uniqueId')->unique()->nullable();
            $table->string('firstName');
            $table->string('lastName');
            $table->string('emailAddress')->nullable();
            $table->string('telephone')->nullable();
            $table->date('dateOfBirth')->nullable();
            $table->string('streetAddress')->nullable();
            $table->string('city')->nullable();
            $table->string('postalCode')->nullable();
            $table->string('country')->nullable();
            $table->timestamps();
        });

        Schema::create('skills', function (Blueprint $table) {
            $table->increments('id');
            $table->string('skill');
            $table->integer('yearsExperience')->nullable();;
            $table->string('seniorityRating')->nullable();;
            $table->unsignedInteger('employee_id');
            $table->timestamps();
            $table->foreign('employee_id')->references('id')->on("employees")->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('skills');
        Schema::dropIfExists('employees');
    }
}
