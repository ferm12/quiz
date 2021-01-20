<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

// class User extends Authenticatable
class User extends Authenticatable implements MustVerifyEmail
{

    use Notifiable;

    public function getAuthPassword()
    { 
        $hashArr = explode(':', $this->attributes['password']);
        switch (count($hashArr)) {
            case 1:
                return $this->attributes['password'];
            case 2:
                return [
                    'password' => $hashArr[0], 
                    'salt' => $hashArr[1],
                ]; 
        }

        return '';
    }

    public function getHashPassword($password, $salt = false)
    {
        if (is_integer($salt)) {
            $salt = Str::random($salt);
        }

        return $salt === false ? bcrypt($password) : md5($salt . $password) . ':' . $salt;
    }

    public function validatePassword($password) 
    {
        $authPassword = $this->getAuthPassword(); 
        
        if (is_array($authPassword)) {

            return md5($authPassword['salt'] . $password) == $authPassword['password'];

        } else {

            return \Hash::check($password, $authPassword);

        }
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'phone','organization_name', 'address', 
        'city', 'state', 'zip_code', 'country', 'purchased_from', 'license_key', 'remember_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
