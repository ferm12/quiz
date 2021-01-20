<?php

namespace App\Http\Controllers\Admin;

use Validator, Redirect, Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

use App\Http\Controllers\Admin\BaseController as Controller;
use App\Models\Admin;
use App\Models\Password_reset;

class PasswordController extends Controller
{

    public function change(Request $request)
    {   
        $dataArray = ['userPermission' => $this->getUserPermission()];

        if ($request->isMethod('post')) {

            $validator = $this->validatorChange($request->input());
            if ($validator->fails()) {

                $request->flash();
                return view('admin.auth.password_change', $dataArray)->withErrors($validator)
                                                         ->withInput($request->input());
            }

            $admin = Auth::guard($this->getGuard())->user();
            if (\Hash::check($request->old_password, $admin->password)) {
                
                $admin->password = bcrypt($request->password); 
                $admin->save();

                return view('admin.auth.password_change', $dataArray)->with('successMsg', trans('common.info.success_password_change'));

            } else {

                return view('admin.auth.password_change', $dataArray)->with('errorMsg', trans('common.error.invalid_password'));
            }
        }

        return view('admin.auth.password_change', $dataArray);
    }


    //
    public function reset(Request $request) 
    {

        if ($request->isMethod('post')) {

            $validator = $this->validatorReset($request->all());

            if ($validator->fails()) {

                $request->flash();
                return view('admin.auth.password_reset')->withErrors($validator)
                                                        ->withInput($request->input());
            }

            try {

                $admin = Admin::where(['email' => $request->email])->first();
                if (empty($admin)) {

                    $request->flash();
                    return view('admin.auth.password_reset')->withErrors($validator)
                                                            ->withInput($request->input())
                                                            ->with('errorMsg', trans('common.error.invalid_email'));                    
                }

                //
                $token = Str::random(60);
                Password_reset::create([
                    'email' => $request->email,
                    'token' => $token,
                ]);

                $emailConfig = $this->getConfig('email');
                if ($emailConfig && !empty($emailConfig['sender_email'])) {

                    $data = [
                        'link' => url('admin/password/reset/enter') . '?id=' . $admin->id . '&token=' . $token,
                        'username' => $admin->firstname . ' ' . $admin->lastname,
                    ];
                    Mail::send('admin.emails.password_reset_link', $data, function ($message) use($request, $emailConfig) {

                        $message->from($emailConfig['sender_email'], empty($emailConfig['sender_name']) ? trans('email.config.sender_name') : $emailConfig['sender_name']);
                        $message->to($request->email)->subject(trans('email.subject.password_reset_link_admin'));

                    }); 
                }           


                $successMsg = trans('common.info.notice_password_reset_check_email');
                $successMsg = str_replace('%1', $request->email, $successMsg);

                return view('admin.auth.login')->with('successMsg', $successMsg);

            } catch (Exception $e) {
          
                return view('admin.auth.password_reset', $dataArray)->with('errorMsg', trans('common.error.db_save_failed'));

            }
            
        }

        return view('admin.auth.password_reset');
    }

    public function resetEnter(Request $request) 
    {
        $currentTime = strtotime(date("y-m-d h:i:s"));
        $timeOffset = intval(config('auth.passwords.admins.expire')) * 60;
        $id = intval($request->id);

        if ($request->isMethod('post')) {

            $validator = $this->validatorResetEnter($request->all());

            if ($validator->fails()) {

                $request->flash();
                return view('admin.auth.password_reset_enter')->withErrors($validator)
                                                            ->withInput($request->input());
            }

            //
            $admin = $this->getLinkAdmin($id, $request->token);
            if (empty($admin)) {

                $request->flash();
                return view('admin.auth.password_reset_enter')->with('errorMsg', trans('common.error.invalid_parameter'));
            }

            //
            try {

                $admin->password = bcrypt($request->password);
                $admin->remember_token = Str::random(60);
                $admin->save();

                return view('admin.auth.login')->with('successMsg', trans('common.info.notice_password_reset_login_again'));           

            } catch (Exception $e) {
          
                return view('admin.auth.password_reset_enter')->with('errorMsg', trans('common.error.db_operation_error'));
            } 

        }

        $createTime = $this->getLinkCreateTime($id, $request->token);
        if ($createTime > 0) {

            if (($currentTime - $createTime) >  $timeOffset) {

                return view('admin.auth.password_reset')->with('errorMsg', trans('common.error.password_reset_link_invalid_or_expired'));    

            } else {

                return view('admin.auth.password_reset_enter', ['id' => $id, 'token' => $request->token]);
            }

        } else {

            return view('admin.auth.password_reset')->with('errorMsg', trans('common.error.password_reset_link_invalid_or_expired'));    

        }

    }

    protected function getLinkAdmin($id, $token)
    {
        try {

            $admin = Admin::where(['id' => $id])->first();
            if (empty($admin)) {
                return null;                    
            }

            //
            $reset = Password_reset::where(['email' => $admin->email, 'token' => $token])->first();
            if (empty($reset)) {
                return null;                    
            } 

            return $admin;

        } catch (Exception $e) {
      
            return null;
        } 

    }

    protected function getLinkCreateTime($id, $token)
    {
        try {

            $admin = Admin::where(['id' => $id])->first();
            if (empty($admin)) {
                return -1;                    
            }

            //
            $reset = Password_reset::where(['email' => $admin->email, 'token' => $token])->first();
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
