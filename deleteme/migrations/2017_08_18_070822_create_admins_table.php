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
            $table->string('firstname', 50);
            $table->string('lastname', 50);
            $table->string('email', 100)->unique();
            $table->string('password', 100);
            $table->smallInteger('rule_id');
            $table->tinyInteger('init_default');
            $table->tinyInteger('status');
            $table->rememberToken();
            $table->timestamps();
        });

        DB::table('admins')->insert([
            'firstname' => 'fermin',
            'lastname' => 'pureco',
            'email' => 'fpurecoortega@actiontec.com',
            'rule_id' => '1',
            'init_default' => '1',
            'status' => '1',
            'password' => bcrypt('teresa12'),
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
