<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class TripsChangePriceToInteger extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trips', function (Blueprint $table) {
            DB::statement('ALTER TABLE trips MODIFY price INTEGER');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trips', function (Blueprint $table) {
            DB::statement('ALTER TABLE trips MODIFY price VARCHAR(4)');
        });
    }

}
