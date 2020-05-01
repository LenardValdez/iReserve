<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_schedules', function (Blueprint $table) {
            $table->bigIncrements('class_id')->unique();
            $table->string('subject_code');
            $table->string('user_id');
            $table->string('room_id');
            $table->string('section');
            $table->time('stime_class');
            $table->time('etime_class');
            $table->char('day', 2);
            $table->unsignedTinyInteger('term_number');
            $table->date('sdate_term');
            $table->date('edate_term');
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('users');
            $table->foreign('room_id')->references('room_id')->on('rooms');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('class_schedules');
    }
}
