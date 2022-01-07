<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sale_id');
            $table->unsignedBigInteger('bundle_id');
            $table->unsignedBigInteger('book_id');
            $table->Integer('quantity')->default(0);
            $table->double('cost',10,2)->default(0);
            $table->string('class')->nullable();
            $table->string('subject')->nullable();
            $table->string('book_name')->nullable();
            $table->string('system_quantity')->nullable();

            $table->unsignedBigInteger('user_id')->default('1');
            $table->ipAddress('user_ip')->default('127.0.0.1');

            // $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
            // $table->foreign('bundle_id')->references('id')->on('bundles')->onDelete('cascade');

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
        Schema::dropIfExists('sale_items');
    }
}
