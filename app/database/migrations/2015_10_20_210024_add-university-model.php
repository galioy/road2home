<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddUniversityModel extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('universities', function (Blueprint $table) {
            $table->increments("id");
            $table->string("name");
            $table->string("initials", 10);
            $table->string("country");
            $table->string("city");
            $table->string("address");
            $table->string("post_code");
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('university');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->unsignedInteger('university')->after('surname');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('universities');
    }

}
