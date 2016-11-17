<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddUniversityForeignToUsers extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('universities')->insert([
            'name'       => 'VIA University College',
            'initials'   => 'VIA',
            'country'    => 'Denmark',
            'city'       => 'Horsens',
            'address'    => 'Chr. M. Oestergaards Vej 4',
            'post_code'  => '8700',
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time())
        ]);

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('university')
                ->references('id')
                ->on('universities')
                ->onDelete('no action');
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
            $table->dropForeign('users_university_foreign');
        });
    }

}
