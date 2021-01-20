<?php

namespace App\Http\Controllers\Admin;

use Validator, Redirect, Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Http\Controllers\Admin\BaseController as Controller;
use App\Models\Admin;
use App\Models\Admin_rule;

class PermissionController extends Controller
{
    protected $modulePath = 'permissions';

    //
    public function index(Request $request)
    {
        $userPermission = $this->getUserPermission();
        if ($userPermission && $userPermission['user_permission_priv'] != 'Y') {
            return Redirect::to($this->redirectPath());
        }

        //
        $errorMsg = $request->session()->pull('errorMsg', '');
        $successMsg = $request->session()->pull('successMsg', '');

        $rules = Admin_rule::where('id', '>', '0')
                        ->orderBy('id', 'DESC')
                        ->paginate($this->eachPageCount);

        $dataArray = [      
            'userPermission' => $userPermission,
            'rules' => $rules,
        ];

        //
        $view = view('admin.users.permission_index', $dataArray);
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
        $userPermission = $this->getUserPermission();
        if ($userPermission && $userPermission['user_permission_priv'] != 'Y') {
            return Redirect::to($this->redirectPath());
        }

        $dataArray = ['userPermission' => $userPermission];

        if ($request->isMethod('post')) {
            $validator = $this->validatorCreate($request->input());
            if ($validator->fails()) {

                $request->flash();          
                return view('admin.users.permission_create', $dataArray)->withErrors($validator)
                                                                ->withInput($request->input());
            }

            try {

                Admin_rule::create([
                    'name' => $request->name,
                    'customer_priv' => empty($request->customer_priv)?'N':'Y',
                    'customer_report_priv' => empty($request->customer_report_priv)?'N':'Y',
                    'deal_priv' => empty($request->deal_priv)?'N':'Y',
                    'deal_report_priv' => empty($request->deal_report_priv)?'N':'Y',
                    'user_permission_priv' => empty($request->deal_report_priv)?'N':'Y',
                    'config_priv' => empty($request->deal_report_priv)?'N':'Y',
                ]);

                $request->session()->put('successMsg', trans('common.info.success_create_admin_rule'));

                $url =  $this->redirectPath() . '/' . $this->modulePath;
                return Redirect::to($url); 

            } catch (Exception $e) {

                return view('admin.users.permission_create', $dataArray)->with('errorMsg', trans('common.error.db_save_failed'));
            } 

        }

        return view('admin.users.permission_create', $dataArray);        
    }

    public function modify(Request $request, $id, $page)
    {
        $userPermission = $this->getUserPermission();
        if ($userPermission && $userPermission['user_permission_priv'] != 'Y') {
            return Redirect::to($this->redirectPath());
        }

        $rule = Admin_rule::where(['id' => $id])->first();
        if (empty($rule)) {
            return view('errors.404');
        }

        $dataArray = ['userPermission' => $userPermission];
        $dataArray['rule'] = ['id' => $id,
                                'name' => $rule->name,
                                'customer_priv' => $rule->customer_priv,
                                'customer_report_priv' => $rule->customer_report_priv,
                                'deal_priv' => $rule->deal_priv,
                                'deal_report_priv' => $rule->deal_report_priv,
                                'user_permission_priv' => $rule->user_permission_priv,
                                'config_priv' => $rule->config_priv,
                                'page' => $page];

        return view('admin.users.permission_modify', $dataArray);
    }

    public function modifyPost(Request $request)
    {
        $userPermission = $this->getUserPermission();
        if ($userPermission && $userPermission['user_permission_priv'] != 'Y') {
            return Redirect::to($this->redirectPath());
        }

        if ($request->isMethod('post')) {

            $dataArray = ['userPermission' => $userPermission];

            $validator = $this->validatorModify($request->input());
            if ($validator->fails()) {
                $request->flash();          
                return view('admin.users.permission_modify', $dataArray)->withErrors($validator)
                                                                ->withInput($request->input());
            }

            try {

                $rule = Admin_rule::where(['id' => $request->id])->first();
                if (!empty($rule)) {

                    $rule->name = $request->name;
                    $rule->customer_priv = empty($request->customer_priv)?'N':'Y';
                    $rule->customer_report_priv = empty($request->customer_report_priv)?'N':'Y';
                    $rule->deal_priv = empty($request->deal_priv)?'N':'Y';
                    $rule->deal_report_priv = empty($request->deal_report_priv)?'N':'Y';
                    $rule->user_permission_priv = empty($request->user_permission_priv)?'N':'Y';
                    $rule->config_priv = empty($request->config_priv)?'N':'Y';
                    $rule->save();
                    
                    $request->session()->put('successMsg', str_replace('%1', $request->id, trans('common.info.success_modify_admin_rule')));
                
                } else {

                    $request->session()->put('errorMsg', trans('common.error.invalid_id'));
                }

                $url =  $this->redirectPath() . '/' . $this->modulePath;
                if (!empty($request->page))
                    $url .= '?page=' . $request->page;

                return Redirect::to($url);

            } catch (Exception $e) {

                return view('admin.users.permission_modify', $dataArray)->with('errorMsg', trans('common.error.db_save_failed'));
            }           
        }        
    }

    public function delete(Request $request, $id, $page)
    {
        $userPermission = $this->getUserPermission();
        if ($userPermission && $userPermission['user_permission_priv'] != 'Y') {
            return Redirect::to($this->redirectPath());
        }
        
        $url =  $this->redirectPath() . '/' . $this->modulePath;
        if (!empty($page))
            $url .= '?page=' . $page;


        //
        $whereArray = [
            ['status', '>', '0'],
            ['rule_id', '=', $id],
        ];

        $admin = Admin::where($whereArray)->first();
        if (!empty($admin)) {

            $errorMsg = trans('common.error.unable_to_delete_rule_which_in_use');
            $errorMsg = str_replace('%1', $id, $errorMsg);

            $request->session()->put('errorMsg',  $errorMsg);

            return Redirect::to($url);
        }

        //
        $rule = Admin_rule::where(['id' => $id])->first();
        if (empty($rule)) {

            $request->session()->put('errorMsg',  trans('common.error.invalid_id'));
            return Redirect::to($url);

        } else {
            if ($rule->init_default == '1') {

                $errorMsg = trans('common.error.unable_to_delete_default_admin_rule');
                $errorMsg = str_replace('%1', $id, $errorMsg);
                $request->session()->put('errorMsg', $errorMsg);
                return Redirect::to($url);
            }
        }

        try {
                          
            $rule->delete();

            $successMsg = trans('common.info.success_delete_admin_rule');
            $successMsg = str_replace('%1', $id, $successMsg);

            $request->session()->put('successMsg', $successMsg);

        } catch (Exception $e) {

            $request->session()->put('errorMsg', trans('common.error.db_operation_error'));
        }

        return Redirect::to($url); 

    }

    protected function getAdminRules() 
    {
        return Admin_rule::where('id', '>', '0')
                        ->orderBy('id', 'DESC')
                        ->get(['id', 'name']);
    }

    protected function validatorCreate(array $data)
    {
        $checkRule = [
            'name' => 'required|max:50',
        ];

        return Validator::make($data, $checkRule);
    }

    protected function validatorModify(array $data)
    {
        $checkRule = [
            'name' => 'required|max:50',
        ];

        return Validator::make($data, $checkRule);
    }

}
