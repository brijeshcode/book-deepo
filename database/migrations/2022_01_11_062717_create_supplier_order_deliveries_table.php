<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplierOrderDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier_order_deliveries', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->unsignedBigInteger('supplier_id');
            $table->unsignedBigInteger('school_id');
            $table->unsignedBigInteger('supplier_order_id');
            $table->unsignedBigInteger('school_order_id');
            $table->enum('payment_status', ['paid','due','partial'])->default('due');
            $table->integer('quantity')->default(0);
            $table->double('discount_percent', 10,2)->default(0);
            $table->double('discount', 10,2)->default(0);
            $table->double('sub_total', 10,2)->default(0);
            $table->double('total_amount', 10,2)->default(0);
            $table->double('amount', 10,2)->default(0);// this is temp veariable
            $table->text('note')->nullable();



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
        Schema::dropIfExists('supplier_order_deliveries');
    }
}
