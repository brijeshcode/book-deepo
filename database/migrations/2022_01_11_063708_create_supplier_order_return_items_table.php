<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplierOrderReturnItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier_order_return_items', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->unsignedBigInteger('supplier_order_return_id');
            $table->unsignedBigInteger('supplier_order_item_id');
            $table->unsignedBigInteger('book_id');
            $table->integer('quantity')->default(0);
            $table->double('unit_price', 10,2)->default(0);
            $table->double('price', 10,2)->default(0)->comment('quantity x unit_price');


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
        Schema::dropIfExists('supplier_order_return_items');
    }
}
