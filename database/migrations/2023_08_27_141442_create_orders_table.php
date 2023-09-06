<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->nullable();
            $table->bigInteger('user_id');
            $table->string('payment_status')->nullable();
            $table->string('payment_mode')->nullable();
            $table->string('order_status')->nullable();
            $table->string('address')->nullable();
            $table->longText('reject_res')->nullable();
            $table->longText('remark')->nullable();
            $table->longText('invoice')->nullable();
            $table->date('delivered_date')->nullable();
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
        Schema::dropIfExists('orders');
    }
};
