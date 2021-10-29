<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Masterfile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('province', function (Blueprint $table) {
            $table->string('id',36)->unique();
            $table->string('state');
            $table->string('pin');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('municipality', function (Blueprint $table) {
            $table->string('id',36)->unique();
            $table->string('state');
            $table->string('pin');
            $table->string('name');
            $table->string('parentid',36);
            $table->foreign('parentid')->references('id')->on('province');
            $table->timestamps();
        });

        Schema::create('barangay', function (Blueprint $table) {
            $table->string('id',36)->unique();
            $table->string('state');
            $table->string('pin');
            $table->string('name');
            $table->string('parentid',36);
            $table->foreign('parentid')->references('id')->on('municipality');
            $table->timestamps();
        });

        Schema::create('school', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('code')->nullable();
            $table->string('description')->nullable();
            $table->string('municipalityid',36);
            $table->foreign('municipalityid')->references('id')->on('municipality');
            $table->timestamps();
        });

        Schema::create('schoollevel', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('type');
            $table->string('code')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        Schema::create('schoolsection', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('schoolid')->unsigned();
            $table->foreign('schoolid')->references('id')->on('school');
            $table->bigInteger('schoollevelid')->unsigned();
            $table->foreign('schoollevelid')->references('id')->on('schoollevel');
            $table->string('name')->nullable();
            $table->string('code')->nullable();
            $table->string('description')->nullable();
            $table->string('programname')->nullable();
            $table->string('programcode')->nullable();
            $table->string('programdescription')->nullable();
            $table->string('sin');
            $table->timestamps();
        });

        Schema::create('survey', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sectionid');
            $table->string('totalmale');
            $table->string('totalfemale');
            $table->bigInteger('surveyperiodid');
            $table->timestamps();
        });

        Schema::create('surveyperiod', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('state');
            $table->string('name');
            $table->string('code')->nullable();
            $table->string('description')->nullable();
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
        Schema::dropIfExists('schoolsection');
        Schema::dropIfExists('schoollevel');
        Schema::dropIfExists('school');
        Schema::dropIfExists('municipality');
        Schema::dropIfExists('barangay');
        Schema::dropIfExists('province');
        Schema::dropIfExists('survey');
        Schema::dropIfExists('surveyperiod');
    }
}
