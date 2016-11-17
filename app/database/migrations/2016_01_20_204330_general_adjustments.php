<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class GeneralAdjustments extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('archived_partial_trips');
        DB::statement('ALTER TABLE trip_requests DROP COLUMN date_to');
        DB::statement('ALTER TABLE trips DROP COLUMN women_only');
        DB::statement("ALTER TABLE trips MODIFY COLUMN luggage_size ENUM('Small', 'Medium', 'Large') NOT NULL, MODIFY COLUMN trip_type ENUM('Single', 'Repeating')");
        DB::statement('ALTER TABLE trips DROP COLUMN arrival_date');
        Schema::table('trip_requests', function (Blueprint $table) {
            $table->string('country_to')->after('route_to');
            $table->string('country_from')->after('route_from');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }

}
