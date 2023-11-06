<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCertificatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('certificates')) {

            Schema::create('certificates', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name')->nullable();
                $table->integer('user_id')->unsigned()->nullable();
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->integer('course_id')->unsigned()->nullable();
                $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
                $table->text('url')->nullable();
                $table->tinyInteger('status')->default(1)->comment('1-Generated 0-Not Generated');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('certificates');
    }
}
