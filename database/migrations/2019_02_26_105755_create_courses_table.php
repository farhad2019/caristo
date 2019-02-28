<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCoursesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->increments('id');
            $table->increments('category_id');
            $table->float('latitude');
            $table->float('longitude');
            $table->string('location', 255);
            $table->string('language', 55);
            $table->string('duration', 155);
            $table->date('date');
            $table->time('time');
            $table->increments('price');
            $table->string('currency', 55);
            $table->string('intro_link', 255);
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
        Schema::drop('courses');
    }
}
