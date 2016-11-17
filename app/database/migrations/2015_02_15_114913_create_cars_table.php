<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCarsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('make');
            $table->string('model');
            $table->integer('seats');
            $table->string('color');
            $table->enum('type', Config::get('enums.car_types'));
            $table->integer('year');
            $table->timestamps();

            //foreign keys
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cars', function ($table) {
            $table->dropForeign('cars_user_id_foreign');
        });

        Schema::drop('cars');
    }

}
