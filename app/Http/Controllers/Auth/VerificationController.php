<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use \GuzzleHttp\Client;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\VerifiesEmails;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;
use Illuminate\Auth\Access\AuthorizationException;


class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = '/user/api/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth:user');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    /**
     * Mark the authenticated user's email address as verified when user
     * click on the links sent.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function verify(Request $request)
    {
        $user = User::find($request->id);

        // if ($request->route('id') != $request->user()->getKey()) {
        if ($request->route('id') != $user->getKey()) {

            throw new AuthorizationException;
        }

        // if ($request->user()->hasVerifiedEmail()) {
        if ($user->hasVerifiedEmail()) {
            // return redirect($this->redirectPath());
            $msg = [
                'customer_verified_msg' => 'User has already been verified.',
            ];

            return redirect('/user/api/login')->with($msg);
        }

        // if ($request->user()->markEmailAsVerified()) {
        if ($user->markEmailAsVerified()) {

            // event(new Verified($request->user()));
            event(new Verified($user));

            // // Customers creation

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
            //         'val' => $user->first_name . ' ' . $user->last_name,
            //     ],
            //     [
            //         'key' => 'email',
            //         'val' => $user->email,
            //     ],
            //     [
            //         'key' => 'company',
            //         'val' => $user->organization_name,
            //     ],
            //     [
            //         'key' => 'address1',
            //         'val' => $user->address,
            //     ],
            //     [
            //         'key' => 'phone',
            //         'val' => $user->phone,
            //     ],
            //     [   
            //         'key' => 'region',
            //         'val' => $user->state,
            //     ],
            //     [
            //         'key' => 'country',
            //         'val' => $user->country,
            //     ],
            //     [
            //         'key' => 'postalcode',
            //         'val' => $user->zip_code,
            //     ],
            //     [
            //         'key' => 'city',
            //         'val' => $user->city,
            //     ],
            //     [
            //         'key' => 'is_affiliateid',
            //         'val' => $this->determineUserGroup($user->country),
            //     ],

            // ];
            // 
            // $create_customer_url = "https://quicklicensemanager.com/actiontec/QlmLicenseServer/qlmservice.asmx/UpdateUserInformation";

            // foreach ($create_customer as $c){
            //      $create_customer_url = $this->buildQueryStr($create_customer_url, $c['key'], $c['val']);
            // }
            // 
            // $create_customer_url = preg_replace("/^([^?&]+)&/", "$1?", $create_customer_url  );

            // $create_customer_http_request = new Client();
            // $customer_created_response = $create_customer_http_request->get($create_customer_url);

            // //  license key creation 
            // $create_key = [
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
            //         'key' => 'email',
            //         'val' => $user->email,
            //     ],
            //     [
            //         'key' => 'is_affiliateid',
            //         'val' => $this->determineUserGroup($user->country),
            //     ],
            //     [
            //         'key' => 'is_productid',
            //         'val' => '1',
            //     ],
            //     [
            //         'key' => 'is_majorversion',
            //         'val' => '9',
            //     ],
            //     [
            //         'key' => 'is_minorversion',
            //         'val' => '24',
            //     ],
            //     [
            //         'key' => 'is_features',
            //         'val' => '0:1',
            //     ],
            //     [
            //         'key' => 'is_usemultipleactivationskey',
            //         'val' => 'false',
            //     ],
            //     [   
            //         'key' => 'is_quantity',
            //         'val' => '1',
            //     ],
            //     [
            //         'key' => 'is_additionalactivations',
            //         'val' => '0',
            //     ],
            //     [
            //         'key' => 'is_numberofactivationsperkey',
            //         'val' => '10000', // Number of activations per key
            //     ],
            //     [
            //         'key' => 'is_maintenance_plan',
            //         'val' => '1',
            //     ],
            //     [
            //         'key' => 'is_maintduration',
            //         'val' => '36500', // 100 years
            //     ],
            //     [
            //         'key' => 'is_licensemodel',
            //         'val' => 'subscription',
            //     ],
            //     [
            //         'key' => 'is_floating',
            //         'val' => '0',
            //     ],
            // ];

            // $create_key_url = "https://quicklicensemanager.com/actiontec/qlmlicenseserver/qlmservice.asmx/GetActivationKey";

            // foreach ($create_key as $a){
            //      $create_key_url = $this->buildQueryStr($create_key_url, $a['key'], $a['val']);
            // }

            // $create_key_url = preg_replace("/^([^?&]+)&/", "$1?", $create_key_url  );

            // $create_key_http_request = new Client();
            // $create_key_response = $create_key_http_request->get($create_key_url);

            // $user = User::where(['id' => $request->route('id')])->first();

            // $user->license_key = $create_key_response->getBody();

            // $user->save();

        }

        $msg = [
            'verified' => true,
            'customer_verified_msg' => 'User has been verified.',
        ];

        // Auth::logou();

        return redirect('/user/api/login')->with($msg);
    }

    /**
     * Show the email verification notice.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
       
        if ($user->hasVerifiedEmail()) {
            return redirect($this->redirectPath());
        }else{
            return view('auth.not_verified');
        }
        // return $request->user()->hasVerifiedEmail()
        //                 ? redirect($this->redirectPath())
        //                 : view('auth.not_verified')
        //                 ->with('user_id', $request->id)
        //                 ->with('email', $request->email);
    }

    public function resend(Request $request)
    {
        $user = User::find($request->id);

        if (!isset($user)){
            return abort('404');
        }

        // if ($request->user()->hasVerifiedEmail()) {
        if ($user->hasVerifiedEmail()) {
            $msg = [
                'customer_verified_msg' => 'User already verified.',
            ];
            // return redirect($this->redirectPath());
            return redirect('/user/api/login')->with($msg);
        }

        // $request->user()->sendEmailVerificationNotification();
        $user->sendEmailVerificationNotification();

        // return back()->with('resent', true);
        return view('auth.verify')
            ->with('user_id', $request->id)
            ->with('email', $user->email);
    
    }

    public function buildQueryStr($url, $key, $val)
    {
        $url .= "&" . $key . "=" . $val;
        return $url;
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
}
