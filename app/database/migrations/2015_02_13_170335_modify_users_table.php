<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class ModifyUsersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['username', 'code']);

            $table->string('name', 20)->after('active');
            $table->string('surname', 20);
            $table->text('bio');
            $table->integer('age');
            $table->enum('gender', Config::get('enums.gender'));
            $table->enum('driving_style', Config::get('enums.driving_style'));
            $table->boolean('smoker');
            $table->string('university', 50);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'name',
                'surname',
                'bio',
                'age',
                'gender',
                'driving_style',
                'smoker',
                'university']);

            $table->string('username', 15)->after('email');
            $table->string('code');
        });
    }

}
