<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class PartialTripsChangePriceToInteger extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('partial_trips', function (Blueprint $table) {
            DB::statement('ALTER TABLE partial_trips MODIFY price INTEGER');
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
            DB::statement('ALTER TABLE partial_trips MODIFY price VARCHAR(4)');
        });
    }

}
