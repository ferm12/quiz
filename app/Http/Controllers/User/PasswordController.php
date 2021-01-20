<?php

namespace App\Http\Controllers\User;

use Validator, Redirect, Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;


use App\Http\Controllers\User\BaseController as Controller;
use App\Models\User;
use App\Models\Password_reset;

class PasswordController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function change(Request $request)
    {   
        $customer = Auth::guard('user')->user();
        $dataArray = ['username' => $customer->firstname . ' ' . $customer->lastname];

        if ($request->isMethod('post')) {

            $validator = $this->validatorChange($request->input());
            if ($validator->fails()) {

                $request->flash();
                return view('user.auth.password_change', $dataArray)->withErrors($validator)
                                                        ->withInput($request->input());
            }


            if ($customer->validatePassword($request->old_password)) {
                
                $customer->password = $customer->getHashPassword($request->password, 32);
                $customer->save();

                return view('user.auth.password_change', $dataArray)->with('successMsg', trans('common.info.success_password_change'));

            } else {

                return view('user.auth.password_change', $dataArray)->with('errorMsg', trans('common.error.invalid_password'));
            }
        }

        return view('user.auth.password_change', $dataArray);
    }

    //
    public function reset(Request $request) 
    {

        if ($request->isMethod('post')) {

            $validator = $this->validatorReset($request->all());

            if ($validator->fails()) {

                $request->flash();
                return view('user.auth.password_reset')->withErrors($validator)
                    ->withInput($request->input());
            }

            try {

                // $customer = User::where(['email' => $request->email, 'is_confirmed' => '2'])->first();
                $customer = User::where(['email' => $request->email])->first();

                if (empty($customer)) {

                    $request->flash();
                    return view('user.auth.password_reset')->withErrors($validator)
                        ->withInput($request->input())
                        ->with('errorMsg', trans('common.error.invalid_email_or_not_confirmed'));                    
                }

                //
                $token = Str::random(60);
                Password_reset::create([
                    'email' => $request->email,
                    'token' => $token,
                ]);

                //
                $emailConfig = $this->getConfig('email');
                if ($emailConfig && !empty($emailConfig['sender_email'])) {

                    $data = [
                        'link' => url('user/password/reset/enter') . '?id=' . $customer->id . '&token=' . $token,
                        'username' => $customer->firstname . ' ' . $customer->lastname,
                    ];
                    Mail::send('user.emails.password_reset_link', $data, function ($message) use($request, $emailConfig) {

                        $message->from($emailConfig['sender_email'], empty($emailConfig['sender_name']) ? trans('email.config.sender_name') : $emailConfig['sender_name']);
                        $message->to($request->email)->subject(trans('email.subject.password_reset_link'));

                    }); 
                }

                $successMsg = trans('common.info.notice_password_reset_check_email');
                $successMsg = str_replace('%1', $request->email, $successMsg);

                // return view('user.auth.login')->with('successMsg', $successMsg);
                return view('user.auth.api_login')->with('successMsg', $successMsg);

            } catch (Exception $e) {
          
                return view('user.auth.password_reset', $dataArray)->with('errorMsg', trans('common.error.db_save_failed'));

            }
            
        }

        return view('user.auth.password_reset');
    }

    public function resetEnter(Request $request) 
    {
        $currentTime = strtotime(date("y-m-d h:i:s"));
        $timeOffset = intval(config('auth.passwords.users.expire')) * 60;
        $id = intval($request->id);

        if ($request->isMethod('post')) {

            $validator = $this->validatorResetEnter($request->all());

            if ($validator->fails()) {

                $request->flash();
                return view('user.auth.password_reset_enter')->withErrors($validator)
                    ->withInput($request->input());
            }

            //
            $customer = $this->getLinkCustomer($id, $request->token);
            if (empty($customer)) {

                $request->flash();
                return view('user.auth.password_reset_enter')->with('errorMsg', trans('common.error.invalid_parameter'));
            }

            //
            try {

                $customer->password = $customer->getHashPassword($request->password, 32);
                $customer->remember_token = Str::random(60);
                $customer->save();

                return view('user.auth.api_login')->with('successMsg', trans('common.info.notice_password_reset_login_again'));           

            } catch (Exception $e) {
          
                return view('user.auth.password_reset_enter')->with('errorMsg', trans('common.error.db_operation_error'));
            } 

        }

        $createTime = $this->getLinkCreateTime($id, $request->token);
        if ($createTime > 0) {

            if (($currentTime - $createTime) >  $timeOffset) {

                return view('user.auth.password_reset')->with('errorMsg', trans('common.error.password_reset_link_invalid_or_expired'));    

            } else {

                return view('user.auth.password_reset_enter', ['id' => $id, 'token' => $request->token]);
            }

        } else {

            return view('user.auth.password_reset')->with('errorMsg', trans('common.error.password_reset_link_invalid_or_expired'));    

        }

    }

    protected function getLinkCustomer($id, $token)
    {
        try {

            // $customer = User::where(['id' => $id, 'is_confirmed' => '2'])->first();
            $customer = User::where(['id' => $id])->first();
            if (empty($customer)) {
                return null;                    
            }

            //
            $reset = Password_reset::where(['email' => $customer->email, 'token' => $token])->first();
            if (empty($reset)) {
                return null;                    
            } 

            return $customer;

        } catch (Exception $e) {
      
            return null;
        } 

    }

    protected function getLinkCreateTime($id, $token)
    {
        try {

            // $customer = User::where(['id' => $id, 'is_confirmed' => '2'])->first();
            $customer = User::where(['id' => $id])->first();
            if (empty($customer)) {
                return -1;                    
            }

            //
            $reset = Password_reset::where(['email' => $customer->email, 'token' => $token])->first();
            if (empty($reset)) {
                return -1;                    
            } 

            return strtotime($reset->created_at);

        } catch (Exception $e) {
      
            return -1;
        } 

    }

    protected function validatorReset(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|email|max:100',
        ]);
    }

    protected function validatorResetEnter(array $data)
    {
        return Validator::make($data, [
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required|min:6'
        ]);
    }

    protected function validatorChange(array $data)
    {
        return Validator::make($data, [
            'old_password' => 'required',
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required|min:6'
        ]);
    }

}
