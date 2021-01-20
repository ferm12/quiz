<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin_rule extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        // 'name', 'customer_priv', 'customer_report_priv', 'deal_priv', 'deal_report_priv', 
        // 'user_permission_priv', 'config_priv', 'init_default',
        'name', 'customer_priv', 'user_permission_priv', 'config_priv', 'init_default'
         
    ];

}
