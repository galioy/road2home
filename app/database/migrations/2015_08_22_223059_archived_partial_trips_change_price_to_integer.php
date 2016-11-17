<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class ArchivedPartialTripsChangePriceToInteger extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('archived_partial_trips', function (Blueprint $table) {
            DB::statement('ALTER TABLE archived_partial_trips MODIFY price INTEGER');
            $table->renameColumn('from', 'route_from');
            $table->renameColumn('to', 'route_to');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('archived_partial_trips', function (Blueprint $table) {
            DB::statement('ALTER TABLE archived_partial_trips MODIFY price VARCHAR(4)');
        });
    }

}
