<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCountryColumnTrips extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('trips', function(Blueprint $table)
		{
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
		Schema::table('trips', function(Blueprint $table)
		{
			$table->dropColumn('country_to');
            $table->dropColumn('country_from');
		});
	}

}
