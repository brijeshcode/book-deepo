<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplierOrderDeliveryItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier_order_delivery_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('supplier_order_delivery_id');
            $table->unsignedBigInteger('supplier_order_item_id');
            $table->unsignedBigInteger('book_id');
            $table->integer('quantity')->default(0);
            $table->double('unit_price', 10,2)->default(0);
            $table->double('price', 10,2)->default(0)->comment('quantity x unit_price');
            $table->double('discount_percent', 10,2)->default(0);
            $table->double('discount_total', 10,2)->default(0);
            $table->double('price_total', 10,2)->default(0)->comment('quantity x unit_price - disocunt total');

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
        Schema::dropIfExists('supplier_order_delivery_items');
    }
}
