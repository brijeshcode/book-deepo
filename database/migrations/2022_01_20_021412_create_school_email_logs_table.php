<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolEmailLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_email_logs', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('school_order_id');
            $table->unsignedBigInteger('reciver_id');
            $table->string('reciver_type' )->comment('this is for who recived mail like supplier, publisher, school, student or any other module');

            $table->string('reciver_email');
            $table->string('reciver_name');
            $table->string('subject');
            $table->text('body');

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
        Schema::dropIfExists('school_email_logs');
    }
}
