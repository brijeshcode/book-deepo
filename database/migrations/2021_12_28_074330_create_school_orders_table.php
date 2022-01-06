<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->date('date');
            $table->string('contact_person')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->string('fax')->nullable();
            $table->text('note')->nullable();
            $table->unsignedBigInteger('total_quantity')->default(0);
            $table->double('total_amount', 10,2)->default(0);

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
        Schema::dropIfExists('school_orders');
    }
}
