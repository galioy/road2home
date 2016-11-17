<?php

use Illuminate\Database\Migrations\Migration;

class CreateTripPassengersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trip_passengers', function ($t) {
            $t->increments('id');
            $t->unsignedInteger('trip_id');
            $t->unsignedInteger('user_id');
        });

        Schema::table('trip_passengers', function ($t) {

            $t->foreign('trip_id')
                ->references('id')
                ->on('trips')
                ->onDelete('cascade');

            $t->foreign('user_id')
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
        Schema::table('trip_passengers', function ($t) {
            $t->dropForeign('trip_passengers_trip_id_foreign');
            $t->dropForeign('trip_passengers_user_id_foreign');
        });

        Schema::drop('trip_passengers');
    }

}
