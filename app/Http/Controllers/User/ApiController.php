<?php

namespace App\Http\Controllers\User;

use Validator, Redirect, Captcha;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Http\Controllers\User\BaseController as Controller;
use App\Models\User;

class ApiController extends Controller
{
    protected $clientKeyArray = array(
        array(
            'client_key' => '7bebed39ca4b92714b2c7d120d3ad772', // md5('API-Client-KEY456PartnerPortal#001')
            'secret_key' => '09d46d1086b3d6e0823f1a70df55d777', // md5('API-Secret-KEY#AEI!345PartnerPortal#001')
            'from_host' => array(
                'www.screenbeam.com', 'w4.screenbeam.com'
            )
        ),
        array(
            'client_key' => '5eb747c625fd24b0728438f0475eb341', // md5('API-Client-KEY456PartnerPortal#002')
            'secret_key' => '90b23ec3448a0eab81e27a2d75632aa1', // md5('API-Secret-KEY#AEI!345PartnerPortal#002')
            'from_host' => array(
                'partner.screenbeam.com', 'partners4.screenbeam.com'
            )
        )
    );
    protected $authSessionTimeoutValue = 1800;  // 30 minutes

    //
    public function login(Request $request)
    {

        if ($request->isMethod('post')) {
            $user = User::where(['email' => $request->email])->first();
            if ( isset($user) ){
                if ( !$user->hasVerifiedEmail()) {
                    return view('user.auth.api_login')
                        ->with('errorMsg', 'User has not been verified. Please check your email.');

                }
            }

            // if (empty($request->nonce)) {

            //     //return view('errors.message', ['message' => trans('common.str_no_authorization') ]);
            //     return Redirect::to($this->redirectPath());
            // } 

            // if (empty($request->return_url)) {

            //     //return view('errors.message', ['message' => trans('common.str_no_return_url') ]);
            //     return Redirect::to($this->redirectPath());
            // }

            // $dataArray = ['nonce' => $request->nonce, 'return_url' => $request->return_url];
 
            $validator = $this->validatorLogin($request->input());
            if ($validator->fails()) {
                $request->flash();
                // return view('user.auth.api_login', $dataArray)
                return view('user.auth.api_login')
                    ->withErrors($validator)
                    ->withInput($request->input());
            }

            // if (!Captcha::check($request->captcha)) {
            //     $request->flash();
            //     // return view('user.auth.api_login', $dataArray)
            //     return view('user.auth.api_login')
            //         ->withErrors($validator)
            //         ->withInput($request->input())
            //         ->with('errorMsg', trans('common.error.invalid_captcha'));
            // }

            $customer = User::where(['email' => $request->email])->first();
            
            if ( Auth::guard($this->guard)->attempt(['email'=>$request->email, 'password'=>$request->password]) ) {
                
                // $currentTime = time();
                // $apiToken = hash('md5', $customer->email . '|' . $currentTime);
                // $request->session()->put('api_token', $apiToken);

                // $nonceArray = explode('|', base64_decode($request->nonce));

                // $digestString = $this->generateDigest($nonceArray[0], $apiToken, $currentTime);
                // $r = $this->encodeAuthParam($nonceArray[0], $apiToken, $digestString);               
 
                // return Redirect::to($request->return_url . '?r=' . $r);
                return Redirect::to('/user/accountsummary');

            } else {

                // return view('user.auth.api_login', $dataArray)
                return view('user.auth.api_login')
                    ->with('errorMsg', trans('common.error.invalid_account_or_password'));
            }

        } else {

            // if (empty($request->k) || !$this->checkClientKey($request->k)) {

            //     //return view('errors.message', ['message' => trans('common.str_no_authorization') ]);
            //     return Redirect::to($this->redirectPath());
            // } 

            // if (empty($request->url)) {

            //     //return view('errors.message', ['message' => trans('common.str_no_return_url') ]);
            //     return Redirect::to($this->redirectPath());
            // }

            // if (!Auth::guard($this->getGuard())->guest()) {

            //     $customer = Auth::guard($this->getGuard())->user();

            //     $currentTime = time();
            //     $apiToken = $request->session()->get('api_token');

            //     if (empty($tokenString)) {                   
            //         $apiToken = hash('md5', $customer->email . '|' . $currentTime);
            //         $request->session()->put('api_token', $apiToken);                    
            //     }

            //     $digestString = $this->generateDigest($request->k, $apiToken, $currentTime);
            //     $r = $this->encodeAuthParam($request->k, $apiToken, $digestString);               
 
            //     return Redirect::to($request->url . '?r=' . $r);
            // }

            $data = [
                'nonce'         => base64_encode($request->k . '|' . $this->generateNonce(32)), 
                'return_url'    => $request->url
            ];
            // dd($request->session()->all());
            $dataArray['data'] = $data;

            return view('user.auth.api_login', $dataArray);
        }
    }

    public function logout(Request $request)
    {
        if (Auth::guard($this->getGuard())->user()){
            Auth::guard($this->getGuard())->logout();
        }

        // if ($request->session()->has('customer_verified_msg')){
            // dd($request->session()->all());
            // $request->session()->put('customer_verified_msg', $request->session()->get('customer_verified_msg'));
            // return redirect('/user/api/login')->with(['customer_verified_msg' => $request->session()->get('customer_verified_msg')]);


            // dd($request->session()->all());
            // $customer_verified_msg = $request->session()->pull('customer_verified_msg');
            // return Redirect::to($this->redirectPath())->with('customer_verified_msg', $customer_verified_msg);
            // $request->session()->put('customer_verified_msg', $customer_verified_msg);
        // }

        return Redirect::to($this->redirectPath());
    }

    public function redirectLogin() 
    {
        // $str = '?k=' . config('auth.api.local_client_key') . '&url=' . config('auth.api.default_client_url');
        // return Redirect::to($this->redirectPath() . '/api/login' . $str);
        return Redirect::to($this->redirectPath() . '/api/login'); 
    }

    public function redirectLogout() 
    {
         return Redirect::to($this->redirectPath() . '/api/logout');       
    }

    protected function validatorLogin(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|email|max:100',
            'password' => 'required|min:6',
            // 'captcha' => 'required',
        ]);
    }

    //
    protected function checkClientKey($key) {
        if (!empty($key)) {
            foreach ($this->clientKeyArray as $row) {
                if ($row['client_key'] == $key) {
                    return true;
                }
            }
        }

        return false;
    }

    protected function generateDigest($key, $token, $timevalue) {

        if (!empty($key) && !empty($token) && !empty($timevalue)) {
            foreach ($this->clientKeyArray as $row) {
                if ($row['client_key'] == $key) {
                    return hash('sha1', $token . ':' . $row['secret_key'] . ':' . $timevalue);
                }
            }
        }

        return '';
    }

    protected function generateNonce($length = 16)
    {
        return Str::random($length);
    }

    protected function encodeAuthParam($key, $token, $digest)
    {

        if (!empty($key) && !empty($token) && !empty($digest)) 
        {
            return base64_encode($key. '|' . $token. '|' . time() . '|' . $digest);
        }

        return '';
    }

    protected function decodeAuthParam($param) 
    {

        if (!empty($param)) {

            $array = explode('|', base64_decode($param));
            if (!empty($array)) {

                return array('client_key' => $array[0],
                             'token' => $array[1],
                             'digest' => $array[3]);
            }
        }

        return null;
    }

}
