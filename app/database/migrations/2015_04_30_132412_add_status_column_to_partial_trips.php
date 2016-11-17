<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddStatusColumnToPartialTrips extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('partial_trips', function (Blueprint $table) {
            $table->integer('status')->after('arrival_date');
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
            $table->dropColumn('status');
        });
    }

}
