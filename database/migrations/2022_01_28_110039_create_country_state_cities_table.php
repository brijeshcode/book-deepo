<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountryStateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('country_state_cities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('parent_id')->default(0);

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
        Schema::dropIfExists('country_state_cities');
    }
}
