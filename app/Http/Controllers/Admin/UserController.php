<?php

namespace App\Http\Controllers\Admin;

use Validator, Redirect, Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Http\Controllers\Admin\BaseController as Controller;
use App\Models\Admin;
use App\Models\Admin_rule;

class UserController extends Controller
{
    protected $modulePath = 'users';

    //
    public function index(Request $request)
    {
        $userPermission = $this->getUserPermission();
        if ($userPermission && $userPermission['user_permission_priv'] != 'Y') {
            return Redirect::to($this->redirectPath());
        }
       
        $errorMsg = $request->session()->pull('errorMsg', '');
        $successMsg = $request->session()->pull('successMsg', '');
        
        // $admins = Admin::where('status', '>', '0')
        $admins = Admin::orderBy('id', 'DESC')
            ->paginate($this->eachPageCount);

        // $adminRules = $this->getAdminRules();
        // var_dump(highlight_string(var_export($adminRules, true)));
        $dataArray = [
            'admins'            => $admins,        
            'userPermission'    => $userPermission,
            // 'param' => [
            //     'rules' => $adminRules 
            // ]
        ];

        $view = view('admin.users.user_index', $dataArray);

        if (!empty($successMsg)) {
            $view->with('successMsg', $successMsg);
        }
        if (!empty($errorMsg)) {
            $view->with('errorMsg', $errorMsg);
        }

        return $view;
    }

    public function create(Request $request)
    {
        // $userPermission = $this->getUserPermission();
        // if ($userPermission && $userPermission['user_permission_priv'] != 'Y') {
        //     return Redirect::to($this->redirectPath());
        // }

        // $adminRules = $this->getAdminRules();

        // $dataArray = [
        //     'userPermission' => $userPermission,
        //     'param' => [
        //         'rules' => $adminRules 
        //     ]
        // ];

        $dataArray = [];

        if ($request->isMethod('post')) {

            $validator = $this->validatorCreate($request->input());
            var_dump( ($request->input() ));

            if ($validator->fails()) {

                $request->flash();          
                return view('admin.users.user_create', $dataArray)->withErrors($validator)
                    ->withInput($request->input());
            }

            try {

                $admin = Admin::where(['email' => $request->email])->first();
                if (!empty($admin)) {
                    $errorMsg = trans('common.error.already_exists');
                    $errorMsg = str_replace('%1', trans('customer.label_email'), $errorMsg);
                    $errorMsg = str_replace('%2', $request->email, $errorMsg);

                    $request->flash();
                    return view('admin.users.user_create', $dataArray)->withErrors($validator)
                        ->withInput($request->input())
                        ->with('errorMsg', $errorMsg);                    
                }  

                Admin::create([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    // 'rule_id' => $request->rule_id,
                    'password' => bcrypt($request->password),
                    'remember_token' => Str::random(60),
                    // 'status' => '1',
                ]);

                $request->session()->put('successMsg', trans('common.info.success_create_user'));

                $url =  $this->redirectPath() . '/' . $this->modulePath;
                return Redirect::to($url); 

            } catch (Exception $e) {

                return view('admin.users.user_create', $dataArray)->with('errorMsg', trans('common.error.db_save_failed'));
            } 

        }

        return view('admin.users.user_create', $dataArray);        
    }

    public function modify(Request $request, $id, $page)
    {
        $userPermission = $this->getUserPermission();
        if ($userPermission && $userPermission['user_permission_priv'] != 'Y') {
            return Redirect::to($this->redirectPath());
        }

        // $whereArray = [
        //     ['status', '>', '0'],
        //     ['id', '=', $id],
        // ];
        // $admin = Admin::where($whereArray)->first();
        $admin = Admin::where('id', '=', $id)->first();

        if (empty($admin)) {
            return view('errors.404');
        }

        $dataArray = [
            'userPermission' => $userPermission,
            // 'param' => [ 
            //     'rules' => $this->getAdminRules(),
            //     'status' => trans('admin.status') 
            // ]
        ];

        $dataArray['admin'] = [
            'id' => $id,
            'first_name' => $admin->first_name,
            'last_name' => $admin->last_name,
            'email' => $admin->email,
            // 'rule_id' => $admin->rule_id,
            // 'init_default' => $admin->init_default,
            // 'status' => $admin->status,
            'page' => $page
        ];

        return view('admin.users.user_modify', $dataArray);
    }

    public function modifyPost(Request $request)
    {
        $userPermission = $this->getUserPermission();
        if ($userPermission && $userPermission['user_permission_priv'] != 'Y') {
            return Redirect::to($this->redirectPath());
        }

        if ($request->isMethod('post')) {

            $dataArray = [
                'userPermission' => $userPermission,
                // 'param' => [ 
                //     'rules' => $this->getAdminRules(),
                //     'status' => trans('admin.status') 
                // ]
            ];

            $validator = $this->validatorModify($request->input());
            // var_dump( highlight_string( $validator ) );
            if ($validator->fails()) {

                $request->flash();          
                return view('admin.users.user_modify', $dataArray)
                    ->withErrors($validator)
                    ->withInput($request->input());
            }

            try {

                $whereArray = [
                    // ['status', '>', '0'],
                    ['id', '=', $request->id],
                ];

                $admin = Admin::where($whereArray)->first();
                if (!empty($admin)) {

                    $admin->first_name = $request->first_name;
                    $admin->last_name = $request->last_name;
                    $admin->email = $request->email;

                    // if ($admin->init_default != '1')                    
                    //     $admin->rule_id = $request->rule_id;

                    if (!empty($request->password)) {
                        $admin->password = bcrypt($request->password);
                        $admin->remember_token = Str::random(60);
                    }

                    // if (!empty($request->status))
                    //     $admin->status = $request->status;

                    $admin->save();
                    
                    $request->session()->put('successMsg', str_replace('%1', $request->id, trans('common.info.success_modify_user')));
                
                } else {

                    $request->session()->put('errorMsg', trans('common.error.invalid_id'));
                }

                $url =  $this->redirectPath() . '/' . $this->modulePath;
                if (!empty($request->page))
                    $url .= '?page=' . $request->page;

                return Redirect::to($url);

            } catch (Exception $e) {

                return view('admin.users.user_modify', $dataArray)->with('errorMsg', trans('common.error.db_save_failed'));
            }           
        }        
    }

    public function delete(Request $request, $id, $page)
    {
        // $userPermission = $this->getUserPermission();
        // if ($userPermission && $userPermission['user_permission_priv'] != 'Y') {
        //     return Redirect::to($this->redirectPath());
        // }
        
        $url =  $this->redirectPath() . '/' . $this->modulePath;
        if (!empty($page))
            $url .= '?page=' . $page;

        //
        $whereArray = [
            // ['status', '>', '0'],
            ['id', '=', $id],
        ];       
        $admin = Admin::where($whereArray)->first();
        if (empty($admin)) {

            $request->session()->put('errorMsg',  trans('common.error.invalid_id'));
            return Redirect::to($url);

        } else {
            // if ($admin->init_default == '1') {

            //     $errorMsg = trans('common.error.unable_to_delete_default_admin_user');
            //     $errorMsg = str_replace('%1', $id, $errorMsg);
            //     $request->session()->put('errorMsg', $errorMsg);
            //     return Redirect::to($url);
            // }
        }

        try {
          
            $admin->delete();

            $successMsg = trans('common.info.success_delete_user');
            $successMsg = str_replace('%1', $id, $successMsg);

            $request->session()->put('successMsg', $successMsg);

        } catch (Exception $e) {

            $request->session()->put('errorMsg', trans('common.error.db_operation_error'));
        }

        return Redirect::to($url); 

    }

    // protected function getAdminRules() 
    // {
    //     return Admin_rule::orderBy('id', 'DESC')->get(['id', 'name']);
    // }

    protected function validatorCreate(array $data)
    {
        $checkRule = [
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'email' => 'required|email|max:100',       
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required|min:6',
        ];

        return Validator::make($data, $checkRule);
    }

    protected function validatorModify(array $data)
    {
        $checkRule = [
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'email' => 'required|email|max:100',
        ];

        // if ($data['init_default'] != '1') {
        //     $checkRule['rule_id'] = 'required';
        // }
        if (!empty($data['password'])) {
            $checkRule['password'] = 'required|confirmed|min:6';
            $checkRule['password_confirmation'] = 'required|min:6';
        }

        return Validator::make($data, $checkRule);
    }

}
