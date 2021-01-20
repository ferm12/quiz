<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin_rule;
use App\Models\Config;

class BaseController extends Controller
{
    //
    protected $guard = 'admin';
    protected $redirectTo = 'admin';
    
    protected $eachPageCount = 10;

 	//
    public function getGuard() {

    	return $this->guard;
    }

    public function redirectPath()
    {
        if (property_exists($this, 'redirectPath')) {
            return $this->redirectPath;
        }

        return property_exists($this, 'redirectTo') ? $this->redirectTo : '/';
    }

    protected function getUserPermission() 
    {
        $admin = Auth::guard($this->guard)->user();
        // var_dump(highlight_string( var_export($admin, true) ));

        if ($admin) {

            // $rule = Admin_rule::where('id', '=', $admin->rule_id)->first();
            $rule = Admin_rule::where('id', '=', '1')->first();
            // if ($rule) {

                return [
                    'first_name' => $admin->first_tname,
                    'last_name' => $admin->last_name,
                    'rule_name' => $rule->name,
                    'customer_priv' => $rule->customer_priv,
                    // 'customer_report_priv' => $rule->customer_report_priv,
                    // 'deal_priv' => $rule->deal_priv,
                    // 'deal_report_priv' => $rule->deal_report_priv,
                    'user_permission_priv' => $rule->user_permission_priv,
                    'config_priv' => $rule->config_priv,
                ];
            // }
        }

        return null;
    }

    protected function getConfig($type='all') 
    {
        $configs = null;
        if ($type == 'all') {
            $configs = Config::get();
        } else {
            $configs = Config::where('type', '=', $type)->get();
        }

        if ($configs) {

            $configArray = [];

            foreach ($configs as $row) {
                $configArray[$row->name] = $row->value;
            }

            if (!empty($configArray)) {
                return $configArray;
            }
        }

        return null;
    }  

}
