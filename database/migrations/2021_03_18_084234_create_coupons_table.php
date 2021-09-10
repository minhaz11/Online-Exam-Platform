<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('name');
            $table->string('details');
            $table->decimal('amount_type')->comment('1 = percentage, 2 = neat amount');
            $table->decimal('coupon_amount',18,8);
            $table->decimal('min_order_amount',18,8);
            $table->string('coupon_code');
            $table->integer('use_limit')->nullable();
            $table->integer('usage_per_user')->nullable();
            $table->date('start_date');
            $table->date('end_date');
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
