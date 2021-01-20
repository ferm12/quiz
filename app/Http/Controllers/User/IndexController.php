<?php


namespace App\Http\Controllers\User;

use Validator, Redirect, Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use \GuzzleHttp\Client;

use App\Http\Controllers\User\BaseController as Controller;
use App\Models\User;

class IndexController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return Redirect::to($this->redirectPath());
        return Redirect::to('/user/accountsummary');
        //return view('user.index');
    }

    public function account(Request $request)
    {

        // $dataArray = ['username' => $customer->firstname . ' ' . $customer->lastname,
        //               'param' => ['partners' => trans('common.partners')]];

        $user = Auth::guard($this->getGuard())->user();

        if ($request->isMethod('post')) {
            $customer = [
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
                'license_key'       => "None",
            ];

            $dataArray['customer'] = $customer;

            $validator = $this->validatorAccount($request->input());
            if ($validator->fails()) {
                $request->flash();
                return view('user.account', $dataArray)->withErrors($validator)
                    ->withInput($request->input());
            }

            try {

                // // update license customer
                // $user->first_name       = $request->first_name;
                // $user->last_name        = $request->last_name;
                // // $user->email         = $request->email;
                // $user->phone            = $request->phone;
                // $user->organization_name= $request->organization_name;
                // $user->address          = $request->address;
                // $user->city             = $request->city;
                // $user->state            = $request->state;
                // $user->zip_code         = $request->zip_code;
                // $user->country          = $request->country;
                // $user->purchased_from   = $request->purchased_from;

                // $user->save();

                // // update Soraco
                // $create_customer = [
                //     [
                //         'key' => 'is_vendor',
                //         'val' => 'zapier',
                //     ],
                //     [
                //         'key' => 'is_user',
                //         'val' => 'sbqlm',
                //     ],
                //     [
                //         'key' => 'is_pwd',
                //         'val' => 'ScreenBeam@95054',
                //     ],
                //     [
                //         'key' => 'name',
                //         'val' => $request->first_name . ' ' . $request->last_name,
                //     ],
                //     [
                //         'key' => 'email',
                //         'val' => $request->email,
                //     ],
                //     [
                //         'key' => 'company',
                //         'val' => $request->organization_name,
                //     ],
                //     [
                //         'key' => 'address1',
                //         'val' => $request->address,
                //     ],
                //     [
                //         'key' => 'phone',
                //         'val' => $request->phone,
                //     ],
                //     [   
                //         'key' => 'region',
                //         'val' => $request->state,
                //     ],
                //     [
                //         'key' => 'country',
                //         'val' => $request->country,
                //     ],
                //     [
                //         'key' => 'postalcode',
                //         'val' => $request->zip_code,
                //     ],
                //     [
                //         'key' => 'city',
                //         'val' => $request->city,
                //     ],
                //     [
                //         'key'  => 'is_affiliateid',
                //         'val' => $this->determineUserGroup($request->country),
                //     ],
                // ];
                // 
                // $create_customer_url = "https://quicklicensemanager.com/actiontec/QlmLicenseServer/qlmservice.asmx/UpdateUserInformation";

                // foreach ($create_customer as $c){
                //      $create_customer_url = $this->buildQueryStr($create_customer_url, $c['key'], $c['val']);
                // }

                // $create_customer_url = preg_replace("/^([^?&]+)&/", "$1?", $create_customer_url  );
                // 
                // $create_customer_http_request = new Client();
                // $customer_created_response = $create_customer_http_request->get($create_customer_url);
                // // $create_customer_http_request->get($create_customer_url);

                // // end update Soraco

                $customer = [
                    'first_name'        => $user->first_name,
                    'last_name'         => $user->last_name,
                    'email'             => $user->email,
                    'phone'             => $user->phone,
                    'organization_name' => $user->organization_name,
                    'address'           => $user->address,
                    'city'              => $user->city,
                    'state'             => $user->state,
                    'zip_code'          => $user->zip_code,
                    'country'           => $user->country,
                    'purchased_from'    => $user->purchased_from,
                    'license_key'       => "None",
                ];

   
                $dataArray['customer'] = $customer;
                // return view('user.account', $dataArray)->with('successMsg', trans('common.info.success_modify_account'));
                return redirect('/user/accountsummary')
                    ->with('successMsg', trans('common.info.success_modify_account'));
                    // ->with('soracoMsg', $customer_created_response);

            } catch (Exception $e) {

                return view('user.account', $dataArray)->with('errorMsg', trans('common.error.db_save_failed'));
            } 

        }else{
            $customer = [
                'first_name'        => $user->first_name,
                'last_name'         => $user->last_name,
                'email'             => $user->email,
                'phone'             => $user->phone,
                'organization_name' => $user->organization_name,
                'address'           => $user->address,
                'city'              => $user->city,
                'state'             => $user->state,
                'zip_code'          => $user->zip_code,
                'country'           => $user->country,
                'purchased_from'    => $user->purchased_from,
                'license_key'       => "None",
            ];

            $dataArray['customer'] = $customer;


            return view('user.account',  $dataArray); 

        }

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



    public function accountSummary(Request $request) 
    {
        $user = Auth::guard($this->getGuard())->user();
        $customer = [
            'first_name'        => $user->first_name,
            'last_name'         => $user->last_name,
            'email'             => $user->email,
            'phone'             => $user->phone,
            'organization_name' => $user->organization_name,
            'address'           => $user->address,
            'city'              => $user->city,
            'state'             => $user->state,
            'zip_code'          => $user->zip_code,
            'country'           => $user->country,
            'purchased_from'    => $user->purchased_from,
            'license_key'       => $user->license_key,
        ];

        $dataArray['customer'] = $customer;

        return view('user.account_summary',  $dataArray); 
    }

    public function contact(Request $request)
    {

        $customer = Auth::guard($this->getGuard())->user();
        $dataArray = ['username' => $customer->firstname . ' ' . $customer->lastname,
                      'param' => ['countries' => trans('common.countries'),
                                  'provinces' => json_encode(trans('common.provinces'))]];

        if ($request->isMethod('post')) {

            $validator = $this->validatorContact($request->input());
            if ($validator->fails()) {
                $request->flash();
                return view('user.contact', $dataArray)->withErrors($validator)
                                              ->withInput($request->input());
            }

            try {

                $customer->firstname = $request->firstname;
                $customer->lastname = $request->lastname;
                $customer->company = $request->company;
                $customer->phone = $request->phone;
                $customer->address = $request->address;
                $customer->country = $request->country;
                $customer->city = $request->city;
                $customer->postal_code = $request->postal_code;

                if ($request->province_type == '2') {
                    $customer->province_id = $request->province_id;
                    $customer->province = '';
                } else {
                    $customer->province = $request->province;
                    $customer->province_id = '';
                }

                $customer->save();

                $dataArray['customer'] = $customer;

                return view('user.contact', $dataArray)->with('successMsg', trans('common.info.success_modify_contact'));

            } catch (Exception $e) {

                return view('user.contact', $dataArray)->with('errorMsg', trans('common.error.db_save_failed'));
            } 
        }

        $dataArray['customer'] = $customer;
        return view('user.contact',  $dataArray); 
    }

    public function uploads(Request $request)
    { 
        $uri = base64_decode($request->uri);
        if (!empty($uri)) {

            $uploadPath = getUploadLocalPath();
            if (!empty($uploadPath)) {
                if (file_exists($uploadPath['base_dir'] . '/' . $uri)) {
                    return response()->file($uploadPath['base_dir'] . '/' . $uri);
                }
            }
        }
    }

    public function testEmail(Request $request)
    {

/*
        $emailConfig = $this->getConfig('email');
        $addrArray = explode(',', $emailConfig['email_group_reg_notification']);

        foreach ($addrArray as $k => $v) {
            $addrArray[$k] = trim($v);
        }

        return $addrArray;
*/

/*
        $data = ['msg' => 'Test message'];
        Mail::send('user.emails.hello', $data, function ($message) {

            $message->from('service@ksmstock.com', 'KSMStock Service');
            $message->to('sl.ksm@sohu.com')->subject('Test Subject');

        });
        
        return 'Send email - OK';
        */
    }

    protected function validatorAccount(array $data)
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
    }
    protected function validatorContact(array $data)
    {
        $checkRule = [
            'firstname'         => 'required|max:50',
            'lastname'          => 'required|max:50',
            'phone'             => 'required|max:50',
            'company'           => 'required|max:50',
            'address'           => 'required|max:100',
            'city'              => 'required|max:50',
            'country'           => 'required|max:50',
            'postal_code'       => 'required|max:50',
        ];

        if ($data['province_type'] == '2') {
            $checkRule['province_id'] = 'required|max:32';
        } else {
            $checkRule['province'] = 'required|max:50';
        }

        return Validator::make($data, $checkRule);
    } 

}
