<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deal_registration extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'opportunity_id', 'opportunity_name', 'opportunity_date', 'opportunity_account_manager', 'opportunity_product', 
        'opportunity_status', 'reseller_company', 'reseller_contact', 'reseller_email', 'reseller_phone',
        'distributor_preferred', 'distributor_contact_firstname', 'distributor_contact_lastname', 
        'distributor_email', 'distributor_phone', 'customer_company', 'customer_contact', 
        'customer_email', 'customer_phone', 'customer_address', 'customer_city', 
        'customer_province', 'customer_province_id', 'customer_postal_code', 'customer_country', 'user_id',
    ];

}
