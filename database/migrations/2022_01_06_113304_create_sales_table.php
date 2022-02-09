<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->unsignedBigInteger('school_id');
            $table->unsignedBigInteger('bundle_id');
            $table->string('student_name');
            $table->enum('status', ['completed','cancel'])->default('completed');
            $table->string('student_mobile')->nullable();
            $table->string('student_email')->nullable();
            // $table->string('transaction_id')->unique();
            $table->double('discount_percent',10,2)->default(0);
            $table->double('discount_amount',10,2)->default(0);
            $table->double('total_amount',10,2)->default(0);
            $table->integer('total_quantity')->default(0);
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
        Schema::dropIfExists('sales');
    }
}
