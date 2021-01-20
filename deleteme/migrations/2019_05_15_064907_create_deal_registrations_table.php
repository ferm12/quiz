<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDealRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('deal_registrations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('opportunity_id', 50)->unique();
            $table->string('opportunity_name', 100);
            $table->datetime('opportunity_date');
            $table->tinyInteger('opportunity_status');
            $table->text('opportunity_product');
            $table->string('opportunity_account_manager', 50);
            $table->string('opportunity_rejection_code', 50);
            $table->text('opportunity_rejection_text');
            $table->string('reseller_company', 50);
            $table->string('reseller_contact', 50);
            $table->string('reseller_email', 100);
            $table->string('reseller_phone', 50);
            $table->string('distributor_preferred', 50);
            $table->string('distributor_contact_firstname', 50);
            $table->string('distributor_contact_lastname', 50);
            $table->string('distributor_email', 100);
            $table->string('distributor_phone', 50);
            $table->string('customer_company', 50);
            $table->string('customer_contact', 50);
            $table->string('customer_email', 100);
            $table->string('customer_phone', 50);
            $table->string('customer_address', 100);
            $table->string('customer_city', 50);
            $table->string('customer_province', 50);
            $table->string('customer_province_id', 32);
            $table->string('customer_postal_code', 50);
            $table->string('customer_country', 50);
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
        //
        Schema::drop('deal_registrations');
    }
}
