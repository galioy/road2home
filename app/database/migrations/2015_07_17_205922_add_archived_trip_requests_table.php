<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddArchivedTripRequestsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('archived_trip_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_requester_id');
            $table->string('route_from');
            $table->string('route_to');
            $table->dateTime('date_from');
            $table->dateTime('date_to');
            $table->integer('status');
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
        Schema::drop('archived_trip_requests');
    }

}
