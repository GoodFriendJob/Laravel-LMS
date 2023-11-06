<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPdfToUserTestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_test', function (Blueprint $table) {
            $table->text('questions_ans_pdf')->nullable()->after('reported');
            $table->text('report_pdf')->nullable()->after('reported');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_test', function (Blueprint $table) {
            //
        });
    }
}
