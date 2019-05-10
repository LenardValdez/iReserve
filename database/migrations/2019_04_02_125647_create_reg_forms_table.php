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
            $table->string('room_id');
            $table->foreign('room_id')
                  ->references('room_id')->on('rooms');
            $table->string('user_id');
            $table->foreign('user_id')
                  ->references('user_id')->on('users');
            $table->string('users_involved');
            $table->dateTime('stime_res');
            $table->dateTime('etime_res');
            $table->string('purpose');
            $table->boolean('isApproved')->default(NULL)->nullable();
            $table->boolean('isCancelled')->default(false);
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
        Schema::dropIfExists('reg_forms');
    }
}
