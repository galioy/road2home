<?php

use Illuminate\Database\Migrations\Migration;

class CreatePartialTripsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partial_trips', function ($t) {
            $t->increments('id');
            $t->unsignedInteger('main_trip_id');
            $t->double('price', 15, 8);
            $t->string('from');
            $t->string('to');
            $t->dateTime('start_date');
            $t->dateTime('arrival_date');
        });

        Schema::table('partial_trips', function ($t) {
            $t->foreign('main_trip_id')
                ->references('id')
                ->on('trips')
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
        Schema::table('partial_trips', function ($t) {
            $t->dropForeign('partial_trips_main_trip_id_foreign');

        });

        Schema::drop('partial_trips');
    }

}
