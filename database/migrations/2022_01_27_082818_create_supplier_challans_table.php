<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplierChallansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier_challans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_order_id');

            $table->unsignedBigInteger('supplier_delivery_id')->nullable();
            $table->unsignedBigInteger('supplier_order_id')->nullable();
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->unsignedBigInteger('delivery_id')->nullable();
            $table->unsignedBigInteger('return_id')->nullable();

            $table->date('date');
            $table->string('challan_no');
            $table->double('amount',10,2)->default(0);
            $table->text('path')->nullable();
            $table->enum('challan_type', ['delivery','return'])->default('delivery');
            $table->enum('payment_status', ['paid','due','partial'])->default('due');
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
        Schema::dropIfExists('supplier_challans');
    }
}
