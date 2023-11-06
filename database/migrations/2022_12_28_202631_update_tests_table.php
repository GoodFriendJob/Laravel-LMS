<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tests', function (Blueprint $table) {
            $table->text('text1')->nullable();
            $table->text('text2')->nullable();
            $table->string('color1')->nullable();
            $table->string('color2')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('tests', function (Blueprint $table) {
            $table->dropColumn('text1');
            $table->dropColumn('text2');
            $table->dropColumn('color1');
            $table->dropColumn('color2');
        });
    }
}
