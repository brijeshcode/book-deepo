<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplierOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('supplier_id');
            $table->unsignedBigInteger('school_id');
            $table->unsignedBigInteger('school_order_id');
            $table->enum('status', ['Requested','Partial','Completed', 'Cancelled'])->default('Requested');
            $table->date('date');
            $table->unsignedBigInteger('quantity')->default(0);
            $table->double('amount', 10,2)->default(0);
            $table->text('note')->nullable();

            $table->boolean('order_recived_confirmation')->default(false);

            // $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
            // $table->foreign('school_order_id')->references('id')->on('school_orders')->onDelete('cascade');

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
        Schema::dropIfExists('supplier_orders');
    }
}
