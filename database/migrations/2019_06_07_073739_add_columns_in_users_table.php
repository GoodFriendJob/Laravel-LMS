<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('dob')->nullable()->after('email');
            $table->string('phone')->nullable()->after('dob');
            $table->string('gender')->nullable()->after('phone');
            $table->longText('address')->nullable()->after('gender');
            $table->string('city')->nullable()->after('address');
            $table->string('pincode')->nullable()->after('city');
            $table->string('state')->nullable()->after('pincode');
            $table->string('country')->nullable()->after('state');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['dob','phone','gender','address','city','pincode','state','country']);
        });
    }
}
