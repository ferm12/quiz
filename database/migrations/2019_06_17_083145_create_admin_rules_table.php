<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('admin_rules', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50)->unique();
            $table->string('customer_priv', 32);
            // $table->string('customer_report_priv', 32);
            // $table->string('deal_priv', 32);
            // $table->string('deal_report_priv', 32);
            $table->string('user_permission_priv', 32);
            $table->string('config_priv', 32);
            $table->tinyInteger('init_default');
            $table->timestamps();
        });

        DB::table('admin_rules')->insert([[
                'name' => 'Administrator',
                'customer_priv' => 'Y',
                // 'customer_report_priv' => 'Y',
                // 'deal_priv' => 'Y',
                // 'deal_report_priv' => 'Y',
                'user_permission_priv' => 'Y',
                'config_priv' => 'Y',
                'init_default' => '1',
                'created_at' => date("y-m-d h:i:s"),
            ], [
                'name' => 'Normal User',
                'customer_priv' => 'Y',
                // 'customer_report_priv' => 'N',
                // 'deal_priv' => 'Y',
                // 'deal_report_priv' => 'N',
                'user_permission_priv' => 'N',
                'config_priv' => 'N',
                'init_default' => '0',
                'created_at' => date("y-m-d h:i:s"),           
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
        Schema::drop('admin_rules');
    }
}
