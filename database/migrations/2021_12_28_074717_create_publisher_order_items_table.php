<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePublisherOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publisher_order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('publisher_id');
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('book_id');
            $table->string('class')->nullable();
            $table->string('subject')->nullable();
            $table->integer('quantity')->default(0);
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
        Schema::dropIfExists('publisher_order_items');
    }
}
