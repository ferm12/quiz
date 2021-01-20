<?php

namespace App\Foundation; 

use Illuminate\Support\Str;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;

class PortalEloquentUserProvider extends EloquentUserProvider
{

    public function validateCredentials(UserContract $user, array $credentials)
	{
		$plain = $credentials['password'];

	    $authPassword = $user->getAuthPassword(); 
	    if (is_array($authPassword)) {

	    	return md5($authPassword['salt'] . $plain) == $authPassword['password'];

	    } else {

        	return $this->hasher->check($plain, $authPassword);

	    }
	}

}