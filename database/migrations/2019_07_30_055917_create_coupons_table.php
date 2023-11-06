<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('code');
            $table->tinyInteger('type')->default(1)->comment('1 - Discount, 2 - Flat Amount');
            $table->float('amount')->comment('Percentage or Amount');
            $table->float('min_price')->default(0)->comment('Minimum price to allow coupons');
            $table->string('expires_at')->nullable();
            $table->integer('per_user_limit')->default(1)->comment('0 - Unlimited');
            $table->tinyInteger('status')->default(0)->comment('0 - Disabled, 1 - Enabled, 2 - Expired');
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
        Schema::dropIfExists('coupons');
    }
}
