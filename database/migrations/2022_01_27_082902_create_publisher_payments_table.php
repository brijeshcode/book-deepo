<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePublisherPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publisher_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('publisher_order_id');
            $table->unsignedBigInteger('publisher_id');
            $table->date('date');
            $table->double('amount', 10,2)->default(0);
            $table->text('note')->nullable();
            $table->string('payment_mode')->defalt('cash');

            $table->unsignedBigInteger('user_id')->default('1');
            $table->ipAddress('user_ip')->default('127.0.0.1');
            $table->softDeletes();
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
        Schema::dropIfExists('publisher_payments');
    }
}
