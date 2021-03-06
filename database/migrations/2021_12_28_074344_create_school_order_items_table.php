<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_order_id');
            $table->unsignedBigInteger('book_id');
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->unsignedBigInteger('publisher_id')->nullable();
            $table->enum('order_to', ['Supplier', 'Publisher']);
            $table->integer('quantity')->default(0);
            $table->enum('status', ['Requested', 'Delivered', 'Partial', 'Cancelled'])->default('Requested');
            $table->integer('recived_quantity')->default(0);

            // $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
            // $table->foreign('order_id')->references('id')->on('school_orders')->onDelete('cascade');

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
        Schema::dropIfExists('school_order_items');
    }
}
