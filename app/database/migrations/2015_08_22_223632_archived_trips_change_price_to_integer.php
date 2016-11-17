<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class ArchivedTripsChangePriceToInteger extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('archived_trips', function (Blueprint $table) {
            DB::statement('ALTER TABLE archived_trips MODIFY price INTEGER');
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
            DB::statement('ALTER TABLE archived_trips MODIFY price VARCHAR(4)');
        });
    }

}
