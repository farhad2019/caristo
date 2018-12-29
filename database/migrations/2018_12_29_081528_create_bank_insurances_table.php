<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBanksRatesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_insurances', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 255);
            $table->string('phone_no', 255);
            $table->text('address', 65535);
            $table->float('rate');
            $table->increments('type');
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
        Schema::drop('bank_insurances');
    }
}
