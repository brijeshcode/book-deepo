<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('publisher_id')->nullable();
            $table->unsignedBigInteger('location_id')->nullable();
            $table->unsignedBigInteger('warehouse_id')->nullable();
            $table->string('name');
            $table->string('sku_no')->unique();
            $table->integer('quantity')->default(0);
            $table->double('cost', 10, 2)->default(0);
            $table->string('author_name')->nullable();
            $table->string('class')->nullable();
            $table->string('subject')->nullable();
            $table->string('description')->nullable();
            $table->string('note')->nullable()->comment('additional information for this entry');
            $table->boolean('active')->default(true);

            $table->unsignedBigInteger('actor_id')->default('1');
            $table->ipAddress('actor_ip')->default('127.0.0.1');
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
        Schema::dropIfExists('books');
    }
}
