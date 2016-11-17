<?php

use enums;
use Illuminate\Database\Migrations\Migration;

class CreateTripsTable extends Migration {


    public function up()
    {
        Schema::create('trips', function ($t) {
            $t->increments('id');
            $t->string('from');
            $t->string('to');
            $t->dateTime('start_date');
            $t->dateTime('arrival_date');
            $t->integer('km');
            $t->integer('status');
            $t->boolean('women_only');
            $t->boolean('smoking_allowed');
            $t->double('price', 15, 8);
            $t->enum('luggage_size', Config::get('enums.luggage_sizes'));
            $t->enum('trip_type', Config::get('enums.trip_types'));
            $t->longText('additional_info');
            $t->unsignedInteger('driver_user_id');
            $t->unsignedInteger('return_trip_id');
        });

        Schema::table('trips', function ($t) {
            $t->foreign('driver_user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $t->foreign('return_trip_id')
                ->references('id')
                ->on('trips')
                ->onDelete('cascade');
        });
    }


    public function down()
    {
        Schema::table('trips', function ($t) {
            $t->dropForeign('trips_driver_user_id_foreign');
            $t->dropForeign('trips_return_trip_id_foreign');
        });

        Schema::drop('trips');
    }

}
