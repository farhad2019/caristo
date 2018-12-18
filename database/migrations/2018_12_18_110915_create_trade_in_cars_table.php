<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTradeInCarsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trade_in_cars', function (Blueprint $table) {
            $table->increments('id');
            $table->increments('owner_car_id');
            $table->increments('customer_car_id');
            $table->increments('user_id');
            $table->float('amount');
            $table->text('notes', 65535);
            $table->datetime('deleted_at');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('trade_in_cars');
    }
}
