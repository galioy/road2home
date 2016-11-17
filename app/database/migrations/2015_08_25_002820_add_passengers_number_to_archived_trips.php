<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddPassengersNumberToArchivedTrips extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('archived_trips', function (Blueprint $table) {
            $table->tinyInteger('passengers')->after('km');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('archived_trips', function (Blueprint $table) {
            $table->dropColumn('passengers');
        });
    }

}
