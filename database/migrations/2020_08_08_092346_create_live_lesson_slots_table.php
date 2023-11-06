<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLiveLessonSlotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('live_lesson_slots', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('lesson_id')->unsigned()->nullable();
            $table->string('meeting_id');
            $table->string('topic');
            $table->text('description')->comment('agenda');
            $table->dateTime('start_at');
            $table->integer('duration')->comment('minutes');
            $table->string('password')->comment('meeting password');
            $table->integer('student_limit')->nullable();
            $table->text('start_url');
            $table->text('join_url');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('lesson_id')->references('id')->on('lessons')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('live_lesson_slots');
    }
}
