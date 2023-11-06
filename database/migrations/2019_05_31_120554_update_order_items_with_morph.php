<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateOrderItemsWithMorph extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('order_items', function (Blueprint $table) {
            $table->renameColumn('course_id','item_id');
            $table->string('item_type')->nullable()->after('order_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->renameColumn('item_id','course_id');
            $table->dropColumn('item_type');
        });
    }
}
