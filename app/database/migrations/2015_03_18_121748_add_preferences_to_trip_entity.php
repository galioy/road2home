<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddPreferencesToTripEntity extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trips', function (Blueprint $table) {
            $table->boolean('chat_allowed')->after('smoking_allowed');
        });

        Schema::table('trips', function (Blueprint $table) {
            $table->boolean('music_allowed')->after('chat_allowed');
        });

        Schema::table('trips', function (Blueprint $table) {
            $table->boolean('children_allowed')->after('music_allowed');
        });

        Schema::table('trips', function (Blueprint $table) {
            $table->boolean('animals_allowed')->after('children_allowed');
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
            $table->dropColumn('chat_allowed');
            $table->dropColumn('music_allowed');
            $table->dropColumn('children_allowed');
            $table->dropColumn('animals_allowed');
        });
    }

}
