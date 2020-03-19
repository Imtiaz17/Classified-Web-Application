<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->increments('id');
            $table->string('store_name');
            $table->text('store_details')->nullable();
            $table->string('store_logo')->nullable();
            $table->string('store_cphoto')->nullable();
            $table->string('address');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('open_days')->nullable();
            $table->string('opening_hours')->nullable();
            $table->string('closing_hours')->nullable();
            $table->integer('user_id');
            $table->integer('store_id');
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
        Schema::dropIfExists('stores');
    }
}
