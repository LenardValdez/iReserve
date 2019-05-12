<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reg_forms', function (Blueprint $table) {
            $table->bigIncrements('form_id')->unique();
            $table->string('user_id');
            $table->string('room_id');
            $table->string('users_involved')->nullable();
            $table->dateTime('stime_res');
            $table->dateTime('etime_res');
            $table->string('purpose');
            $table->integer('isApproved')->default(0);
            $table->boolean('isCancelled')->default(false);
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
        Schema::dropIfExists('reg_forms');
    }
}
