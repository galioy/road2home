<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class FinalizeUpdateUsersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropTimestamps();
            $table->dropColumn(['email', 'bio']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('email', 20)->unique()->after('id');
            $table->string('bio', 150)->after('surname');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // THIS WILL NEVER RUN - there is delition and creation of the same columns
        // that would occur in the same DB call.
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['email', 'bio']);

            $table->string('email')->after('id');
            $table->text('bio')->after('surname');
        });
    }

}
