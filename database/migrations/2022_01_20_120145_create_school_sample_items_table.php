<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolSampleItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_sample_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_sample_id');
            $table->string('name');
            $table->string('class')->nullable();
            $table->string('subject')->nullable();

            $table->unsignedBigInteger('publisher_id');
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
        Schema::dropIfExists('school_sample_items');
    }
}
