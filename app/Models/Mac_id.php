<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mac_id extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'sn', 'mac_id', 'purchased_from', 'taken', 'license_number', 'activation_key'
    ];

}
