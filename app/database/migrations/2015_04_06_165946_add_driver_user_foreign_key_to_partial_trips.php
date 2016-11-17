<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddDriverUserForeignKeyToPartialTrips extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('partial_trips', function (Blueprint $table) {
            $table->unsignedInteger('driver_user_id')->nullable()->after('main_trip_id');
        });

        Schema::table('partial_trips', function (Blueprint $table) {
            $table->foreign('driver_user_id')
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
        Schema::table('partial_trips', function (Blueprint $table) {
            $table->dropForeign('partial_trips_driver_user_id_foreign');
        });

        Schema::table('partial_trips', function (Blueprint $table) {
            $table->dropColumn('driver_user_id');
        });
    }

}
