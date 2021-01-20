<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Config;

class BaseController extends Controller
{
	//
    protected $guard = 'user';
    protected $redirectTo = 'user';
 
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
