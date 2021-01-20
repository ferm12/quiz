<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMacIdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mac_ids', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id');
            $table->string('sn', 50);
            $table->string('mac_id', 50);
            $table->string('purchased_from', 50);
            $table->string('taken', 10);
            $table->text('license_number');
            $table->text('activation_key');

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
        Schema::drop('mac_ids');
    }
}
