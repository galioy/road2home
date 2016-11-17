<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddTripRequestsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trip_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_requester_id');
            $table->string('route_from');
            $table->string('route_to');
            $table->dateTime('date_from');
            $table->dateTime('date_to');
            $table->integer('status')->default(1);
            $table->timestamps();
        });

        Schema::table('trip_requests', function ($table) {
            $table->foreign('user_requester_id')
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
        Schema::table('trip_requests', function ($table) {
            $table->dropForeign('trip_requests_user_requester_id_foreign');
        });

        Schema::drop('trip_requests');
    }

}
