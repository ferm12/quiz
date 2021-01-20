<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('firstname', 50);
            $table->string('lastname', 50);
            $table->string('email', 100)->unique();
            $table->string('password', 100);
            $table->string('phone', 50);
            $table->string('job_title', 50);
            $table->string('company', 50);
            $table->string('address', 100);
            $table->string('city', 50);
            $table->string('province_id', 32);
            $table->string('province', 50);
            $table->string('postal_code', 50);
            $table->string('country', 50);
            $table->string('referred_person', 50);
            $table->string('partner_type', 50);
            $table->string('preferred_distributor', 50);
            $table->tinyInteger('is_confirmed');
            $table->datetime('confirm_time');         
            $table->rememberToken();
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
        Schema::drop('users');
    }
}
