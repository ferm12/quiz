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

        DB::table('configs')->insert([[
                'name' => 'sender_name',
                'type' => 'email',
                'value' => '',
            ], [
                'name' => 'sender_email',
                'type' => 'email',
                'value' => '',       
            ], [
                'name' => 'email_group_reg_notification',
                'type' => 'email',
                'value' => '',       
            ], [
                'name' => 'email_group_deal_notification',
                'type' => 'email',
                'value' => '',       
            ], [
                'name' => 'email_group_deal_filter',
                'type' => 'email',
                'value' => '',       
            ], [
                'name' => 'email_group_weekly_reg_report',
                'type' => 'email',
                'value' => '',       
            ], [
                'name' => 'email_group_weekly_deal_report',
                'type' => 'email',
                'value' => '',       
            ], [
                'name' => 'email_group_monthly_summary_report',
                'type' => 'email',
                'value' => '',       
            ], [
                'name' => 'ten_off_mini_product_count',
                'type' => 'others',
                'value' => '50',       
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
