<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveArchivedDataTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement('ALTER TABLE trips DROP COLUMN status');
        DB::statement('ALTER TABLE trip_requests DROP COLUMN status');
        Schema::drop('archived_trips');
        Schema::drop('archived_trip_requests');
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
