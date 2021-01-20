<?php

namespace App\Http\Controllers\Admin;

use Validator, Redirect, Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use \GuzzleHttp\Client;

use App\Http\Controllers\Admin\BaseController as Controller;
use App\Models\User;
// use App\Models\Deal_registration;
use App\Models\Mac_id;

class CustomerController extends Controller
{
    protected $modulePath = 'customers';

    //
    public function index(Request $request)
    {
        // $userPermission = $this->getUserPermission();
        // if ($userPermission && $userPermission['customer_priv'] != 'Y') {
        //     return Redirect::to($this->redirectPath());
        // }

        $errorMsg = $request->session()->pull('errorMsg', '');
        $successMsg = $request->session()->pull('successMsg', '');
        $soracoMsg = $request->session()->pull('soracoMsg', '');

        $customers = null;
        // $dataArray = [
        //     'param' => [
        //         'status' => trans('customer.status'),
        //         'countries' => trans('common.countries') 
        //     ]
        // ];
        $dataArray = [];

        if ($request->isMethod('post')) {

            $searchArray = [
                'search_first_name'         => $request->search_first_name,
                'search_last_name'          => $request->search_last_name,
                'search_email'              => $request->search_email,
                'search_phone'              => $request->search_phone,
                'search_organization_name'  => $request->search_organization_name,
                'search_address'            => $request->search_address,
                'search_city'               => $request->search_city,
                'search_state'              => $request->search_state,
                'search_zip_code'           => $request->search_zip_code,
                'search_country'            => $request->search_country,
                'search_purchased_from'     => $request->search_purchased_from,
                'search_license_key'        => $request->search_license_key,
                'search_created_date'       => $request->search_created_date,
            ];

            $customers = $this->getCustomers($searchArray, $this->eachPageCount);
            $dataArray['search'] = base64_encode(json_encode($searchArray));
            $dataArray['searchArray'] = $searchArray;

        } else {

            if (empty($request->search)) {

                // Show all customers
                // $customers = User::where('is_confirmed', '>', '0')
                //     ->orderBy('id', 'DESC')
                //     ->paginate($this->eachPageCount);       
                $customers = User::orderBy('id', 'DESC')
                    ->paginate($this->eachPageCount);

            } else {

                $searchArray = json_decode(base64_decode($request->search), true);
                $customers = $this->getCustomers($searchArray, $this->eachPageCount);

                $dataArray['searchArray'] = $searchArray;             
            }

            $dataArray['search'] = $request->search;
        }

        $dataArray['customers'] = $customers;
        // $dataArray['userPermission'] = $userPermission;

        $view = view('admin.customer_index', $dataArray);
        if (!empty($successMsg)) {
            $view->with('successMsg', $successMsg);
        }
        if (!empty($errorMsg)) {
            $view->with('errorMsg', $errorMsg);
        }
        if (!empty($soracoMsg)){
            $view->with('soracoMsg', $soracoMsg); 
        }
        return $view;
    }

    public function modify(Request $request, $id, $page)
    {
        // $userPermission = $this->getUserPermission();
        // if ($userPermission && $userPermission['customer_priv'] != 'Y') {
        //     return Redirect::to($this->redirectPath());
        // }

        $whereArray = [
            ['id', '=', $id]
        ];
        $customer = User::where($whereArray)->first();
        if (empty($customer)) {
            return view('errors.404');;
        }

        // $dataArray = [
        //     'userPermission' => $userPermission,
        //     'param' => [
        //         'status'    => trans('customer.status'),
        //         'countries' => trans('common.countries'),
        //         'provinces' => json_encode(trans('common.provinces')),
        //         'partners'  => trans('common.partners') 
        //     ]
        // ];

        $dataArray['customer'] = [
            'id'                => $id,
            'first_name'        => $customer->first_name,
            'last_name'         => $customer->last_name,
            'email'             => $customer->email,
            'phone'             => $customer->phone,
            'organization_name' => $customer->organization_name,
            'address'           => $customer->address,
            'city'              => $customer->city,
            'state'             => $customer->state,
            'zip_code'          => $customer->zip_code,
            'country'           => $customer->country,
            'purchased_from'    => $customer->purchased_from,
            'license_key'       => $customer->license_key,
            'page'              => $page
        ];

        return view('admin.customer_modify', $dataArray);
    }

    public function modifyPost(Request $request)
    {
        // $userPermission = $this->getUserPermission();
        // if ($userPermission && $userPermission['customer_priv'] != 'Y') {
        //     return Redirect::to($this->redirectPath());
        // }

        if ($request->isMethod('post')) {

            // $dataArray = [
            //     'userPermission' => $userPermission,
            //     'param' => [
            //         'status' => trans('customer.status'),
            //         'countries' => trans('common.countries'),
            //         'provinces' => json_encode(trans('common.provinces')),
            //         'partners' => trans('common.partners') 
            //     ]
            // ];
            $dataArray['customer'] = [
                'id'                => $request->id,
                'first_name'        => $request->first_name,
                'last_name'         => $request->last_name,
                'email'             => $request->email,
                'phone'             => $request->phone,
                'organization_name' => $request->organization_name,
                'address'           => $request->address,
                'city'              => $request->city,
                'state'             => $request->state,
                'zip_code'          => $request->zip_code,
                'country'           => $request->country,
                'purchased_from'    => $request->purchased_from,
                'license_key'       => $request->license_key,
                'page'              => $request->page
            ];


            $validator = $this->validatorModify($request->input());
            if ($validator->fails()) {

                $request->flash();          
                return view('admin.customer_modify', $dataArray)->withErrors($validator)
                    ->withInput($request->input());
            }

            try {

                $whereArray = [
                    // ['is_confirmed', '>', '0'],
                    ['id', '=', $request->id],
                ];

                $customer = User::where($whereArray)->first();
                if (!empty($customer)) {

                    $customer->first_name       = $request->first_name;
                    $customer->last_name        = $request->last_name;
                    $customer->email            = $request->email;                    
                    $customer->phone            = $request->phone;
                    $customer->organization_name= $request->organization_name; 
                    $customer->address          = $request->address; 
                    $customer->city             = $request->city; 
                    $customer->state            = $request->state;
                    $customer->zip_code         = $request->zip_code; 
                    $customer->country          = $request->country; 
                    $customer->purchased_from   = $request->purchased_from; 
                    $customer->license_key      = $request->license_key; 


                    // if ($request->province_type == '2') {
                    //     $customer->province_id = $request->province_id;
                    //     $customer->province = '';
                    // } else {
                    //     $customer->province = $request->province;
                    //     $customer->province_id = '';
                    // }

                    // Approved
                    // if ($request->status == 'approved') {

                    //     $password = '';                       
                    //     if (empty($customer->password)) {

                    //         if (empty($request->password)) {
                    //             $password = generatePassword(8);
                    //         } else {
                    //             $password = $request->password;
                    //         }
                    //         $customer->password = $customer->getHashPassword($password, 32);
                    //         $customer->remember_token = Str::random(60);

                    //     } else {

                    //         if (!empty($request->password)) {
                    //             $password = $request->password;
                    //             $customer->password = $customer->getHashPassword($password, 32);
                    //             $customer->remember_token = Str::random(60);
                    //         }
                    //     }

                    //     $customer->save();

                    //     if ($request->sendemail == 'on' && !empty($password)) {

                    //         $emailConfig = $this->getConfig('email');
                    //         if ($emailConfig && !empty($emailConfig['sender_email'])) {

                    //             $data = [
                    //                 'username' => $request->first_name . ' ' . $request->last_name,
                    //                 'company' => $request->organization_name,
                    //                 'email' => $request->email,
                    //                 'password' => $password 
                    //             ];

                    //             Mail::send('user.emails.register_approved', $data, function ($message) use($request, $emailConfig) {

                    //                 $message->from($emailConfig['sender_email'], empty($emailConfig['sender_name']) ? trans('email.config.sender_name') : $emailConfig['sender_name']);
                    //                 $message->to($request->email)->subject(trans('email.subject.customer_register_approved'));

                    //             });
                    //         }
                    //     }

                    // } else if ($request->status == 'declined') {

                    //     $customer->save();

                    //     if ($request->sendemail == 'on') {

                    //         $emailConfig = $this->getConfig('email');
                    //         if ($emailConfig && !empty($emailConfig['sender_email'])) {
  
                    //             $data = ['username' => $request->firstname . ' ' . $request->lastname];

                    //             Mail::send('user.emails.register_declined', $data, function ($message) use($request, $emailConfig) {

                    //                 $message->from($emailConfig['sender_email'], empty($emailConfig['sender_name']) ? trans('email.config.sender_name') : $emailConfig['sender_name']);
                    //                 $message->to($request->email)->subject(trans('email.subject.customer_register_declined'));

                    //             });
                    //         }
                    //     }

                    // } else {

                    //     $customer->save();
                    // }

                    $customer->save();
                    
                    // update Soraco
                    $create_customer = [
                        [
                            'key' => 'is_vendor',
                            'val' => 'zapier',
                        ],
                        [
                            'key' => 'is_user',
                            'val' => 'sbqlm',
                        ],
                        [
                            'key' => 'is_pwd',
                            'val' => 'ScreenBeam@95054',
                        ],
                        [
                            'key' => 'name',
                            'val' => $request->first_name . ' ' . $request->last_name,
                        ],
                        [
                            'key' => 'email',
                            'val' => $request->email,
                        ],
                        [
                            'key' => 'company',
                            'val' => $request->organization_name,
                        ],
                        [
                            'key' => 'address1',
                            'val' => $request->address,
                        ],
                        [
                            'key' => 'phone',
                            'val' => $request->phone,
                        ],
                        [   
                            'key' => 'region',
                            'val' => $request->state,
                        ],
                        [
                            'key' => 'country',
                            'val' => $request->country,
                        ],
                        [
                            'key' => 'postalcode',
                            'val' => $request->zip_code,
                        ],
                        [
                            'key' => 'city',
                            'val' => $request->city,
                        ],
                        [
                            'key'  => 'is_affiliateid',
                            'val' => $this->determineUserGroup($request->country),
                        ],
                    ];
                    
                    $create_customer_url = "https://quicklicensemanager.com/actiontec/QlmLicenseServer/qlmservice.asmx/UpdateUserInformation";

                    foreach ($create_customer as $c){
                         $create_customer_url = $this->buildQueryStr($create_customer_url, $c['key'], $c['val']);
                    }
                    
                    $create_customer_url = preg_replace("/^([^?&]+)&/", "$1?", $create_customer_url);

                    $create_customer_http_request = new Client();
                    $customer_created_response = $create_customer_http_request->get($create_customer_url);
                    // $request->session()->put('soracoMsg', $customer_created_response);

                    // end update Soraco

                    $request->session()->put('successMsg', str_replace('%1', $request->id, trans('common.info.success_modify_customer')));

                } else {

                    $request->session()->put('errorMsg', trans('common.error.invalid_id'));
                }

                $url =  $this->redirectPath() . '/' . $this->modulePath;
                if (!empty($request->page))
                    $url .= '?page=' . $request->page;

                return Redirect::to($url);

            } catch (Exception $e) {

                return view('admin.customer_modify', $dataArray)->with('errorMsg', trans('common.error.db_save_failed'));
            }           
        }        
    }

    public function resetPassword(Request $request, $id){

        $customer = User::where([['id', '=', $id]])->first();
        if (empty($customer)) {
            return view('errors.404');;
        }

        $dataArray['customer'] = [
            'id'            => $id,
            'first_name'    => $customer->first_name,
            'last_name'     => $customer->last_name,
        ];

        if ($request->isMethod('post')) {

            $customer->password = bcrypt($request->password); 
            $customer->save();

            if ($request->sendemail == 'on' && !empty($customer->password)) {

                $emailConfig = $this->getConfig('email');
                if ($emailConfig && !empty($emailConfig['sender_email'])) {

                    $data = [
                        'first_name'=> $request->first_name,
                        'last_name' => $request->last_name,
                        'password'  => $customer->password,
                    ];

                    Mail::send('admin.emails.password_reset_email', $data, function ($message) use($request, $emailConfig) {

                        $message->from($emailConfig['sender_email'], empty($emailConfig['sender_name']) ? trans('email.config.sender_name') : $emailConfig['sender_name']);
                        $message->to($request->email)->subject(trans(' ScreenBeam Classroom Commander License Portal Password Reset'));

                    });
                }
            }

            return redirect('/admin/customers/modify/' . $id . '/1')->with('successMsg', trans('common.info.success_password_change'));
       }

        return view('admin.users.reset_password', $dataArray);

    }

    public function delete(Request $request, $id, $page)
    {
        // $userPermission = $this->getUserPermission();
        // if ($userPermission && $userPermission['customer_priv'] != 'Y') {
        //     return Redirect::to($this->redirectPath());
        // }
        
        $url =  $this->redirectPath() . '/' . $this->modulePath;
        if (!empty($page))
            $url .= '?page=' . $page;

        //
        $whereArray = [
            // ['opportunity_status', '>', '0'],
            ['user_id', '=', $id],
        ];

        // $deal = Deal_registration::where($whereArray)->first();
        $mac_id = Mac_id::where($whereArray)->first();
        // if (!empty($deal)) {
        if (!empty($mac_id)) {

            // $errorMsg = trans('common.error.unable_to_delete_customer_contain_deal');
            $errorMsg = "Unable to delete customer contains Mac ID";
            $errorMsg = str_replace('%1', $id, $errorMsg);

            $request->session()->put('errorMsg',  $errorMsg);

            return Redirect::to($url);
        }

        try {
            //
            $whereArray = [
                // ['is_confirmed', '>', '0'],
                ['id', '=', $id],
            ];

            $customer = User::where($whereArray)->first();
            if (!empty($customer)) {
                
                $customer->delete();

                $successMsg = trans('common.info.success_delete_customer');
                $successMsg = str_replace('%1', $id, $successMsg);

                $request->session()->put('successMsg', $successMsg);
            } else {
                $request->session()->put('errorMsg', trans('common.error.db_operation_error'));
            }

        } catch (Exception $e) {

            $request->session()->put('errorMsg', trans('common.error.db_operation_error'));
        }

        return Redirect::to($url); 

    }

    // public function exportCSV(Request $request)
    // {
    //     $userPermission = $this->getUserPermission();
    //     if ($userPermission && $userPermission['customer_priv'] != 'Y') {
    //         return Redirect::to($this->redirectPath());
    //     }

    //     $searchArray = [
    //         'search_name' => $request->search_name,
    //         'search_email' => $request->search_email,
    //         'search_company' => $request->search_company,
    //         'search_city' => $request->search_city,
    //         'search_province' => $request->search_province,
    //         'search_country' => $request->search_country,
    //         'search_referred_person' => $request->search_referred_person,
    //         'search_is_confirmed' => $request->search_is_confirmed,
    //         'search_create_time' => $request->search_create_time,
    //         'search_confirm_time' => $request->search_confirm_time,
    //     ];

    //     $customers = $this->getCustomers($searchArray, 0);

    //     $count = count($customers);
    //     if ($count > 0) {

    //         $data  = "\"ID\",\"First Name\",\"Last Name\",\"Email\",\"Phone\",\"Job Title\",\"Company\",";
    //         $data .= "\"Address\",\"City\",\"Country\",\"State/Province\",\"Postcode\",";
    //         $data .= "\"Who Referred You\",\"Partner Type\",\"Status\",\"Create Time\",\"Confirm Time\"";
    //         
    //         foreach ($customers as $row) {

    //             // region
    //             $region = (empty($row->province))? getRegionById($row->country, $row->province_id):$row->province;

    //             $line  = "\"" . $row->id . "\",\"" . $row->firstname . "\",\"";
    //             $line .= $row->lastname . "\",\"" . $row->email . "\",\"";
    //             $line .= $row->phone . "\",\"" . $row->job_title . "\",\"";
    //             $line .= $row->company . "\",\"" . $row->address . "\",\"";
    //             $line .= $row->city . "\",\"" . getCountryById($row->country) . "\",\"";
    //             $line .= $region . "\",\"" . $row->postal_code . "\",\"";
    //             $line .= $row->referred_person . "\",\"" . getPartnerTypeById($row->partner_type) . "\",\"";
    //             $line .= getCustomerStatusById($row->is_confirmed) . "\",\"" . $row->created_at . "\",\"";
    //             $line .= $row->confirm_time . "\"";

    //             $data .= "\r\n" . $line;
    //         }

    //         $filename = 'customers_export_to_' . date('YmdHis', time()) . '.csv';

    //         return response($data, 200)
    //                     ->header('Pragma', 'public')
    //                     ->header('Cache-Control', 'must-revalidate, post-check=0, pre-check=0')
    //                     ->header('Content-Type', 'text/csv; charset=UTF-8')
    //                     ->header('Content-Length', strlen($data))
    //                     ->header('Content-Disposition', 'attachment;filename=' . $filename);
    //     }

    //     return trans('common.str_no_record');
    // }

    protected function validatorModify(array $data)
    {
        return Validator::make($data, [
            'first_name'        => 'required|alpha_num|max:50',
            'last_name'         => 'required|alpha_num|max:50',
            'email'             => 'required|email|max:50',
            'phone'             => 'required|regex:/^[a-zA-Z0-9\s-_+*()]*$/|max:50',
            'organization_name' => 'required|regex:/^[a-zA-Z0-9\s-_+.,!@$%^*()]*$/|max:50',
            'address'           => 'required|regex:/^[a-zA-Z0-9\s-_+.,!@$%^*()]*$/|max:100',
            'city'              => 'required|regex:/^[a-zA-Z0-9\s]*$/|max:50',
            'state'             => 'required|regex:/^[a-zA-Z0-9\s]*$/|max:50',
            'zip_code'          => 'required|alpha_num|max:50',
            'purchased_from'    => 'required|regex:/^[a-zA-Z0-9\s-_+.,!@$%^*()]*$/|max:100',
        ]);

        // $checkRule = [
        //     'first_name'        => 'required|max:50',
        //     'last_name'         => 'required|max:50',
        //     'email'             => 'required|max:100',       
        //     'phone'             => 'required|max:50',
        //     'organization_name' => 'required|max:50',
        //     'address'           => 'required|max:100',
        //     'city'              => 'required|max:50',
        //     'state'             => 'required|max:50',
        //     'zip_code'          => 'required|max:50',
        //     'country'           => 'required|max:50',
        //     'purchased_from'    => 'required|max:50',
        // ];

        // if ($data['province_type'] == '2') {
        //     $checkRule['province_id'] = 'required|max:32';
        // } else {
        //     $checkRule['province'] = 'required|max:50';
        // }

        // return Validator::make($data, $checkRule);
    }

    protected function getCustomers($searchArray, $eachPageCount) {

        // $Query = User::where(function($query) use($searchArray) {

        //             if (!empty($searchArray['search_name'])) {

        //                 $searchName = $searchArray['search_name'];
        //                 $query->where('firstname', 'like', "%" . $searchName . "%")
        //                       ->orWhere(function($query) use($searchName) {
        //                           $query->where('lastname', 'like', "%" . $searchName . "%");
        //                       });

        //             }
        //             if (!empty($searchArray['search_province'])) {
        //                 
        //                 $searchProvince = $searchArray['search_province'];
        //                 $query->where('province', 'like', "%" . $searchProvince . "%")
        //                       ->orWhere(function($query) use($searchProvince) {
        //                           $query->where('province_id', '=', getRegionIdByName($searchProvince));
        //                       });
        //             }

        //             $whereArray = [
        //                 ['is_confirmed', '>', '0'],
        //             ];
        //             if (!empty($searchArray['search_email'])) {
        //                 array_push($whereArray, ['email', 'like', "%" . $searchArray['search_email'] . "%"]);
        //             }
        //             if (!empty($searchArray['search_company'])) {
        //                 array_push($whereArray, ['company', 'like', "%" . $searchArray['search_company'] . "%"]);
        //             }
        //             if (!empty($searchArray['search_city'])) {
        //                 array_push($whereArray, ['city', 'like', "%" . $searchArray['search_city'] . "%"]);
        //             }
        //             if (!empty($searchArray['search_country'])) {
        //                 array_push($whereArray, ['country', '=', $searchArray['search_country']]);
        //             }
        //             if (!empty($searchArray['search_referred_person'])) {
        //                 array_push($whereArray, ['referred_person', 'like', "%" . $searchArray['search_referred_person'] . "%"]);
        //             }
        //             if (!empty($searchArray['search_is_confirmed'])) {
        //                 array_push($whereArray, ['is_confirmed', '=', $searchArray['search_is_confirmed']]);
        //             }
        //             if (!empty($searchArray['search_create_time'])) {
        //                 array_push($whereArray, ['created_at', 'like', "%" . $searchArray['search_create_time'] . "%"]);
        //             }
        //             if (!empty($searchArray['search_confirm_time'])) {
        //                 array_push($whereArray, ['confirm_time', 'like', "%" . $searchArray['search_confirm_time'] . "%"]);
        //             }
        //             $query->where($whereArray);

        //         })->orderBy('id', 'DESC');


        $whereArray = [];

        if (!empty($searchArray['search_first_name'])) {
            array_push($whereArray, ['first_name', 'like', "%" . $searchArray['search_first_name'] . "%"]);
        }
        if (!empty($searchArray['search_last_name'])) {
            array_push($whereArray, ['last_name', 'like', "%" . $searchArray['search_last_name'] . "%"]);
        }
        if (!empty($searchArray['search_email'])) {
            array_push($whereArray, ['email', 'like', "%" . $searchArray['search_email'] . "%"]);
        }
        if (!empty($searchArray['search_phone'])) {
            array_push($whereArray, ['phone', 'like', "%" . $searchArray['search_phone'] . "%"]);
        }
        if (!empty($searchArray['search_organization_name'])) {
            array_push($whereArray, ['organization_name', 'like', "%" . $searchArray['search_organization_name'] . "%"]);
        }
        if (!empty($searchArray['search_address'])) {
            array_push($whereArray, ['address', 'like', "%" . $searchArray['search_address'] . "%"]);
        }
        if (!empty($searchArray['search_city'])) {
            array_push($whereArray, ['city', 'like', "%" . $searchArray['search_city'] . "%"]);
        }
        if (!empty($searchArray['search_state'])) {
            array_push($whereArray, ['state', 'like', "%" . $searchArray['search_state'] . "%"]);
        }
        if (!empty($searchArray['search_zip_code'])) {
            array_push($whereArray, ['zip_code', 'like', "%" . $searchArray['search_zip_code'] . "%"]);
        }
        if (!empty($searchArray['search_country'])) {
            array_push($whereArray, ['country', 'like', "%" . $searchArray['search_country'] . "%"]);
        }
        if (!empty($searchArray['search_status'])) {
            array_push($whereArray, ['status', 'like', "%" . $searchArray['search_status'] . "%"]);
        }
        if (!empty($searchArray['search_purchased_from'])) {
            array_push($whereArray, ['purchased_from', 'like', "%" . $searchArray['search_purchased_from'] . "%"]);
        }
        if (!empty($searchArray['search_license_key'])) {
            array_push($whereArray, ['license_key', 'like', "%" . $searchArray['search_license_key'] . "%"]);
        }

        if (!empty($searchArray['search_created_date'])) {
            array_push($whereArray, ['created_at', 'like', "%" . $searchArray['search_created_date'] . "%"]);
        }

        $Query = User::where($whereArray)->orderBy('id', 'DESC');
       
        if ($eachPageCount > 0) {
            return $Query->paginate($eachPageCount);
        } 

        return $Query->get();   

    }
    public function determineUserGroup($country)
    {
        // Asia Customer
        // EU Customer
        // N America Customer
        // S/C America Customer
        $user_group = [
            "Afghanistan"                       => "Asia Customer",
            "Åland Islands"                     => "EU Customer",
            "Albania"                           => "EU Customer",
            "Algeria"                           => "EU Customer",
            "American Samoa"                    => "Asia Customer",
            "Andorra"                           => "EU Customer",
            "Angola"                            => "EU Customer",
            "Anguilla"                          => "S/C America Customer",
            "Antarctica"                        => "S/C America Customer",
            "Antigua and Barbuda"               => "S/C America Customer",
            "Argentina"                         => "S/C America Customer",
            "Armenia"                           => "EU Customer",
            "Aruba"                             => "S/C America Customer",
            "Australia"                         => "Asia Customer",
            "Austria"                           => "EU Customer",
            "Azerbaijan"                        => "EU Customer",
            "Bahamas"                           => "S/C America Customer",
            "Bahrain"                           => "EU Customer",
            "Bangladesh"                        => "Asia Customer",
            "Barbados"                          => "S/C America Customer",
            "Belarus"                           => "EU Customer",
            "Belgium"                           => "EU Customer",
            "Belize"                            => "S/C America Customer",
            "Benin"                             => "EU Customer",
            "Bermuda"                           => "S/C America Customer",
            "Bhutan"                            => "Asia Customer",
            "Bolivia"                           => "S/C America Customer",
            "Bonaire, Sint Eustatius and Saba"  => "S/C America Customer",
            "Bosnia and Herzegovina"            => "EU Customer",
            "Botswana"                          => "EU Customer",
            "Bouvet Island"                     => "S/C America Customer",
            "Brazil"                            => "S/C America Customer",
            "British Indian Ocean Territory"    => "EU Customer",
            "Brunei Darrussalam"                => "Asia Customer",
            "Bulgaria"                          => "EU Customer",
            "Burkina Faso"                      => "EU Customer",
            "Burundi"                           => "EU Customer",
            "Cambodia"                          => "Asia Customer",
            "Cameroon"                          => "EU Customer",
            "Canada"                            => "N America Customer",
            "Cape Verde"                        => "EU Customer",
            "Cayman Islands"                    => "S/C America Customer",
            "Central African Republic"          => "EU Customer",
            "Chad"                              => "EU Customer",
            "Chile"                             => "S/C America Customer",
            "China"                             => "Asi Customer",
            "Christmas Island"                  => "S/C America Customer",
            "Cocos Islands"                     => "Asia Customer",
            "Colombia"                          => "S/C America Customer",
            "Comoros"                           => "EU Customer",
            "Congo, Democratic Republic of the" => "EU Customer",
            "Congo, Republic of the"            => "EU Customer",
            "Cook Islands"                      => "Asia Customer",
            "Costa Rica"                        => "S/C America Customer",
            "Côte d'Ivoire"                     => "EU Customer",
            "Croatia"                           => "EU Customer",
            "Cuba"                              => "Asia Customer",
            "Curaçao"                           => "S/C America Customer",
            "Cyprus"                            => "EU Customer",
            "Czech Republic"                    => "EU Customer",
            "Denmark"                           => "EU Customer",
            "Djibouti"                          => "EU Customer",
            "Dominica"                          => "S/C America Customer",
            "Dominican Republic"                => "S/C America Customer",
            "Ecuador"                           => "S/C America Customer",
            "Egypt"                             => "EU Customer",
            "El Salvador"                       => "S/C America Customer",
            "Equatorial Guinea"                 => "EU Customer",
            "Estonia"                           => "EU Customer",
            "Eswatini (Swaziland)"              => "EU Customer",
            "Ethiopia"                          => "EU Customer",
            "Falkland Islands"                  => "S/C America Customer",
            "Faroe Islands"                     => "EU Customer",
            "Fiji"                              => "Asia Customer",
            "Finland"                           => "Asia Customer",
            "France"                            => "EU Customer",
            "French Guiana"                     => "S/C America Customer",
            "French Polynesia"                  => "S/C America Customer",
            "French Southern Territories"       => "EU Customer",
            "Gabon"                             => "EU Customer",
            "Gambia"                            => "EU Customer",
            "Georgia"                           => "EU Customer",
            "Germany"                           => "EU Customer",
            "Ghana"                             => "EU Customer",
            "Gibraltar"                         => "EU Customer",
            "Greece"                            => "EU Customer",
            "Greenland"                         => "N America Customer",
            "Grenada"                           => "S/C America Customer",
            "Guadeloupe"                        => "EU Customer",
            "Guam"                              => "Asia Customer",
            "Guatemala"                         => "S/C America Customer",
            "Guernsey"                          => "EU Customer",
            "Guinea"                            => "EU Customer",
            "Guinea-Bissau"                     => "EU Customer",
            "Guyana"                            => "S/C America Customer",
            "Haiti"                             => "S/C America Customer",
            "Heard and McDonald Islands"        => "EU Customer",
            "Holy See"                          => "EU Customer",
            "Honduras"                          => "S/C America Customer",
            "Hong Kong"                         => "Asia Customer",
            "Hungary"                           => "EU Customer",
            "Iceland"                           => "EU Customer",
            "India"                             => "Asia Customer",
            "Indonesia"                         => "Asia Customer",
            "Iran"                              => "EU Customer",
            "Iraq"                              => "EU Customer",
            "Ireland"                           => "EU Customer",
            "Isle of Man"                       => "EU Customer",
            "Israel"                            => "EU Customer",
            "Italy"                             => "EU Customer",
            "Jamaica"                           => "S/C America Customer",
            "Japan"                             => "Asia Customer",
            "Jersey"                            => "EU Customer",
            "Jordan"                            => "EU Customer",
            "Kazakhstan"                        => "EU Customer",
            "Kenya"                             => "EU Customer",
            "Kiribati"                          => "Asia Customer",
            "Kuwait"                            => "EU Customer",
            "Kyrgyzstan"                        => "EU Customer",
            "Lao People's Democratic Republic"  => "Asia Customer",
            "Latvia"                            => "EU Customer",
            "Lebanon"                           => "EU Customer",
            "Lesotho"                           => "EU Customer",
            "Liberia"                           => "EU Customer",
            "Libya"                             => "EU Customer",
            "Liechtenstein"                     => "EU Customer",
            "Lithuania"                         => "EU Customer",
            "Luxembourg"                        => "EU Customer",
            "Macau"                             => "Asia Customer",
            "Macedonia"                         => "EU Customer",
            "Madagascar"                        => "EU Customer",
            "Malawi"                            => "EU Customer",
            "Malaysia"                          => "Asia Customer",
            "Maldives"                          => "Asia Customer",
            "Mali"                              => "EU Customer",
            "Malta"                             => "EU Customer",
            "Marshall Islands"                  => "Asia Customer",
            "Martinique"                        => "S/C America Customer",
            "Mauritania"                        => "S/C America Customer",
            "Mauritius"                         => "EU Customer",
            "Mayotte"                           => "EU Customer",
            "Mexico"                            => "S/C America Customer",
            "Micronesia"                        => "Asia Customer",
            "Moldova"                           => "EU Customer",
            "Monaco"                            => "EU Customer",
            "Mongolia"                          => "Asia Customer",
            "Montenegro"                        => "EU Customer",
            "Montserrat"                        => "S/C America Customer",
            "Morocco"                           => "EU Customer",
            "Mozambique"                        => "EU Customer",
            "Myanmar"                           => "EU Customer",
            "Namibia"                           => "EU Customer",
            "Nauru"                             => "Asia Customer",
            "Nepal"                             => "Asia Customer",
            "Netherlands"                       => "EU Customer",
            "New Caledonia"                     => "Asia Customer",
            "New Zealand"                       => "Asia Customer",
            "Nicaragua"                         => "S/C America Customer",
            "Niger"                             => "EU Customer",
            "Nigeria"                           => "EU Customer",
            "Niue"                              => "S/C America Customer",
            "Norfolk Island"                    => "Asia Customer",
            "North Korea"                       => "Asia Customer",
            "Northern Mariana Islands"          => "Asia Customer",
            "Norway"                            => "EU Customer",
            "Oman"                              => "EU Customer",
            "Pakistan"                          => "EU Customer",
            "Palau"                             => "Asia Customer",
            "Palestine, State of"               => "EU Customer",
            "Panama"                            => "S/C America Customer",
            "Papua New Guinea"                  => "Asia Customer",
            "Paraguay"                          => "S/C America Customer",
            "Peru"                              => "S/C America Customer",
            "Philippines"                       => "Asia Customer",
            "Pitcairn"                          => "S/C America Customer",
            "Poland"                            => "EU Customer",
            "Portugal"                          => "EU Customer",
            "Puerto Rico"                       => "S/C America Customer",
            "Qatar"                             => "EU Customer",
            "Réunion"                           => "EU Customer",
            "Romania"                           => "EU Customer",
            "Russia"                            => "EU Customer",
            "Rwanda"                            => "EU Customer",
            "Saint Barthélemy"                  => "S/C America Customer",
            "Saint Helena"                      => "EU Customer",
            "Saint Kitts and Nevis"             => "S/C America Customer",
            "Saint Lucia"                       => "S/C America Customer",
            "Saint Martin"                      => "S/C America Customer",
            "Saint Pierre and Miquelon"         => "S/C America Customer",
            "Saint Vincent and the Grenadines"  => "S/C America Customer",
            "Samoa"                             => "Asia Customer",
            "San Marino"                        => "EU Customer",
            "Sao Tome and Principe"             => "EU Customer",
            "Saudi Arabia"                      => "EU Customer",
            "Senegal"                           => "EU Customer",
            "Serbia"                            => "EU Customer",
            "Seychelles"                        => "EU Customer",
            "Sierra Leone"                      => "EU Customer",
            "Singapore"                         => "Asia Customer",
            "Sint Maarten"                      => "N America Customer",
            "Slovakia"                          => "EU Customer",
            "Slovenia"                          => "EU Customer",
            "Solomon Islands"                   => "Asia Customer",
            "Somalia"                           => "EU Customer",
            "South Africa"                      => "EU Customer",
            "South Georgia"                     => "S/C America Customer",
            "South Korea"                       => "Asia Customer",
            "South Sudan"                       => "EU Customer",
            "Spain"                             => "EU Customer",
            "Sri Lanka"                         => "Asia Customer",
            "Sudan"                             => "EU Customer",
            "Suriname"                          => "S/C America Customer",
            "Svalbard and Jan Mayen Islands"    => "EU Customer",
            "Sweden"                            => "EU Customer",
            "Switzerland"                       => "EU Customer",
            "Syria"                             => "EU Customer",
            "Taiwan"                            => "Asia Customer",
            "Tajikistan"                        => "EU Customer",
            "Tanzania"                          => "EU Customer",
            "Thailand"                          => "Asia Customer",
            "Timor-Leste"                       => "Asia Customer",
            "Togo"                              => "EU Customer",
            "Tokelau"                           => "Asia Customer",
            "Tonga"                             => "Asia Customer",
            "Trinidad and Tobago"               => "S/C America Customer",
            "Tunisia"                           => "EU Customer",
            "Turkey"                            => "EU Customer",
            "Turkmenistan"                      => "EU Customer",
            "Turks and Caicos Islands"          => "N America Customer",
            "Tuvalu"                            => "Asia Customer",
            "Uganda"                            => "EU Customer",
            "Ukraine"                           => "EU Customer",
            "United Arab Emirates"              => "EU Customer",
            "United Kingdom"                    => "EU Customer",
            "United States"                     => "N America Customer",
            "Uruguay"                           => "S/C America Customer",
            "US Minor Outlying Islands"         => "N America Customer",
            "Uzbekistan"                        => "EU Customer",
            "Vanuatu"                           => "Asia Customer",
            "Venezuela"                         => "S/C America Customer",
            "Vietnam"                           => "Asia Customer",
            "Virgin Islands, British"           => "S/C America Customer",
            "Virgin Islands, U.S."              => "S/C America Customer",
            "Wallis and Futuna"                 => "Asia Customer",
            "Western Sahara"                    => "EU Customer",
            "Yemen"                             => "EU Customer",
            "Zambia"                            => "EU Customer",
            "Zimbabwe"                          => "EU Customer",
        ];

        return $user_group [$country];
    }

    // public function buildQueryStr($url, $key, $val)
    // {
    //     $uri = preg_replace("/([?&]" . $key . "(?=[=&#]|$)[^#&]*|(?=#|$))/", "&" . $key . "=" . $val, $url);

    //     return preg_replace("/^([^?&]+)&/", "$1?", $uri);
    // 
    // }

    public function buildQueryStr($url, $key, $val)
    {
        $url .= "&" . $key . "=" . $val;
        return $url;
    }


}
