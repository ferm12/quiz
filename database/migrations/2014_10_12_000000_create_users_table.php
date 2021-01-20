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
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('email', 100)->unique();
            $table->string('phone', 50);
            $table->string('organization_name', 50);
            $table->string('address', 100);
            $table->string('city', 50);
            $table->string('state', 50);
            $table->string('zip_code', 50);
            $table->string('country', 50);
            // $table->string('status', 20);
            $table->string('purchased_from', 50);
            $table->text('license_key');
            $table->string('password', 100);
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
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
