<?php

namespace App\Http\Controllers\Admin;

use Validator, Redirect, Captcha;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Http\Controllers\Admin\BaseController as Controller;
use App\Models\Admin;

class AuthController extends Controller
{

    public function index()
    {
        if (Auth::guard($this->getGuard())->guest()) {
            return view('admin.auth.login');
        } else {
            return Redirect::to($this->redirectPath());
        }
    }

    //
    public function login(Request $request)
    {      
        if (Auth::guard($this->getGuard())->guest()) {

            if ($request->isMethod('post')) {

                $validator = $this->validatorLogin($request->input());
                if ($validator->fails()) {
                    $request->flash();
                    return view('admin.auth.login')->withErrors($validator)
                        ->withInput($request->input());
                }

                if (!Captcha::check($request->captcha)) {
                    $request->flash();
                    return view('admin.auth.login')->withErrors($validator)
                        ->withInput($request->input())
                        ->with('errorMsg', trans('common.error.invalid_captcha'));
                }

                try {

                    // commenting admin.status for controlling child admins
                    // $admin = Admin::where(['email' => $request->email])->first();
                    // if ($admin && $admin->status != '1') {
                    //     $request->flash();
                    //     return view('admin.auth.login')->withErrors($validator)
                    //         ->withInput($request->input())
                    //         ->with('errorMsg', trans('common.error.account_inactive'));                    
                    // }                    

                    if (Auth::guard($this->guard)->attempt(['email'=>$request->email, 'password'=>$request->password])) {
                        return Redirect::to($this->redirectPath());
                    } else {
                        return view('admin.auth.login')->with('errorMsg', trans('common.error.invalid_account_or_password'));
                    }

                } catch (Exception $e) {
          
                    return view('admin.auth.login', $dataArray)->with('errorMsg', trans('common.error.db_save_failed'));

                }
            }

            return view('admin.auth.login');

        } else {

            return Redirect::to($this->redirectPath());
        }
    }

    //
    public function register(Request $request)
    {
        if ($request->isMethod('post')) {

           $validator = $this->validatorRegister($request->all());

            if ($validator->fails()) {
                $request->flash();
                return view('admin.auth.register')->withErrors($validator)
                    ->withInput($request->input());
            }

            if (!Captcha::check($request->captcha)) {
                $request->flash();
                return view('admin.auth.register')->withErrors($validator)
                    ->withInput($request->input())
                    ->with('errorMsg', trans('common.error.invalid_captcha'));
            }
                           

            Auth::guard($this->getGuard())->login($this->createAdmin($request->all()));

            return redirect($this->redirectPath());
        }

        return view('admin.auth.register');
    }

    //
    public function logout()
    {
        if (Auth::guard($this->getGuard())->user()){
            Auth::guard($this->getGuard())->logout();
        }

        return Redirect::to($this->redirectPath());
    }

    public function createCaptcha(Request $request)
    {
         return Captcha::create('default');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validatorLogin(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|email|max:100',
            'password' => 'required|min:6',
            'captcha' => 'required',
        ]);
    }

    protected function validatorRegister(array $data)
    {
        return Validator::make($data, [
            'firstname' => 'required|max:50',
            'lastname' => 'required|max:50',
            'email' => 'required|email|max:100',
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required|min:6',
            'captcha' => 'required',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return Admin
     */
    protected function createAdmin(array $data)
    {
        return Admin::create([
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

}
