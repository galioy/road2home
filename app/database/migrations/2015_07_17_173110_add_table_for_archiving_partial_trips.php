<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddTableForArchivingPartialTrips extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('archived_partial_trips', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('main_trip_id');
            $table->double('price', 15, 8);
            $table->string('from');
            $table->string('to');
            $table->dateTime('start_date');
            $table->dateTime('arrival_date');
            $table->integer('status')->default(0);
            $table->timestamps();
        });

        Schema::table('archived_partial_trips', function ($table) {
            $table->foreign('main_trip_id')
                ->references('id')
                ->on('archived_trips')
                ->onDelete('cascade');
        });

        Schema::table('archived_trips', function (Blueprint $table) {
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
        Schema::table('archived_partial_trips', function ($table) {
            $table->dropForeign('archived_partial_trips_main_trip_id_foreign');

        });

        Schema::drop('archived_partial_trips');

        Schema::table('archived_trips', function (Blueprint $table) {
            $table->dropTimestamps();
        });
    }

}
