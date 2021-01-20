<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('configs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->string('type', 50);
            $table->text('value');
        });

        DB::table('configs')->insert([
            [
                'name' => 'sender_name',
                'type' => 'email',
                'value' => 'quiz Admin',
            ], [
                'name' => 'sender_email',
                'type' => 'email',
                'value' => 'pureco.fermin1@gmail.com',       
            ], [
                'name' => 'email_group_registration_notification',
                'type' => 'email',
                'value' => 'pureco.fermin1@gmail.com',       
            ], [
                'name' => 'email_group_mac_id_request_notification',
                'type' => 'email',
                'value' => 'pureco.fermin1@gmail.com',       
            ]
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::drop('configs');
    }
}
