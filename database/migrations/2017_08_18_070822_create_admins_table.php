<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('email', 100)->unique();
            $table->string('password', 100);
            $table->rememberToken();
            $table->timestamps();
        });

        DB::table('admins')->insert([
            'first_name' => 'fermin',
            'last_name' => 'pureco',
            'email' => 'pureco.fermin1@gmail.com',
            'password' => bcrypt('123456'),
            'remember_token' => Str::random(60),
            'created_at' => date("y-m-d h:i:s"),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('admins');
    }
}
