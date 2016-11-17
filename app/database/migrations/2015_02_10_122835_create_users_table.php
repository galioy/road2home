<?php

use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function ($t) {
            $t->increments('id');
            $t->string('email');
            $t->string('username');
            $t->string('password');
            $t->string('password_temp');
            $t->string('code');
            $t->boolean('active');
            $t->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }

}
