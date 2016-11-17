<?php

use Illuminate\Database\Migrations\Migration;

class AddTableForArchivingTrips extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('archived_trips', function ($table) {
            $table->increments('id');
            $table->string('route_from');
            $table->string('route_to');
            $table->dateTime('start_date');
            $table->dateTime('arrival_date');
            $table->integer('km');
            $table->integer('status')->default(0);
            $table->boolean('women_only');
            $table->boolean('smoking_allowed');
            $table->boolean('chat_allowed');
            $table->boolean('music_allowed');
            $table->boolean('children_allowed');
            $table->boolean('animals_allowed');
            $table->double('price', 4, 2);
            $table->enum('luggage_size', Config::get('enums.luggage_sizes'));
            $table->enum('trip_type', Config::get('enums.trip_types'));
            $table->longText('additional_info');
            $table->integer('seats_total');
            $table->integer('seats_taken');
            $table->unsignedInteger('driver_user_id');
            $table->unsignedInteger('return_trip_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('archived_trips', function ($table) {
            $table->dropForeign('archived_trips_driver_user_id_foreign');
            $table->dropForeign('archived_trips_return_trip_id_foreign');
        });

        Schema::drop('archived_trips');
    }

}
