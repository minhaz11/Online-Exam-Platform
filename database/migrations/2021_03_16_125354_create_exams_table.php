<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->integer('subject_id')->unsigned();
            $table->string('title',191);
            $table->timestamp('start_date');
            $table->timestamp('end_date');
            $table->integer('attempt_count')->unsigned()->default(0)->comment('How much time can attempt, value 0 means unlimited');
            $table->integer('negative_marking')->unsigned()->nullable();
            $table->integer('reduce_mark')->unsigned()->nullable()->comment('mark will be reduce for wrong answer');
            $table->integer('pass_percentage')->unsigned()->comment('pass mark percentage for exam');
            $table->integer('duration')->unsigned()->comment('exam duration time');
            $table->integer('totalmark')->unsigned()->comment('exam total mark');
            $table->integer('value')->unsigned()->comment('1=> paid, 2 => unpaid');
            $table->integer('exam_fee')->unsigned()->nullable()->comment('exam fee');
            $table->integer('random')->unsigned()->default(0)->comment('questions will be random or not');
            $table->integer('option_suffle')->unsigned()->default(0)->comment('question options will be suffle or not');
            $table->string('image');
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
        Schema::dropIfExists('exams');
    }
}
