<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStripePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stripe_plans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('product');
            $table->string('plan_id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('amount');
            $table->string('currency');
            $table->string('interval');
            $table->integer('course')->nullable();
            $table->integer('bundle')->nullable();
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stripe_plans');
    }
}
