<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMyCarsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->increments('id');
            $table->increments('type_id');
            $table->increments('model_id');
            $table->increments('engine_type_id');
            $table->increments('owner_id');
            $table->date('year');
            $table->boolean('transmission_type');
            $table->string('name', 255);
            $table->string('email', 255);
            $table->string('country_code', 5);
            $table->increments('phone');
            $table->boolean('owner_type');
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
        Schema::drop('cars');
    }
}
