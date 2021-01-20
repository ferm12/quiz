<?php

namespace App\Http\Controllers\User;

use Validator, Redirect, Captcha, Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use \GuzzleHttp\Client;

use App\Http\Controllers\User\BaseController as Controller;
use App\Models\User;

class AuthController extends Controller
{
    use RegistersUsers;

    public function index()
    {
        if (Auth::guard($this->getGuard())->guest()) {
            return view('user.auth.login');
        } else {
            return Redirect::to($this->redirectPath());
        }
    }  

    //
    public function login(Request $request)
    {

        if (!Auth::guard($this->getGuard())->guest()) {
            return Redirect::to($this->redirectPath());
        }

        if ($request->isMethod('post')) {

            $validator = $this->validatorLogin($request->input());
            if ($validator->fails()) {
                $request->flash();
                return view('user.auth.login', ['return_url' => $request->return_url])->withErrors($validator)
                    ->withInput($request->input());
            }

            if (!Captcha::check($request->captcha)) {
                $request->flash();
                return view('user.auth.login', ['return_url' => $request->return_url])->withErrors($validator)
                   ->withInput($request->input())
                   ->with('errorMsg', trans('common.error.invalid_captcha'));
            }

            try {

                $customer = User::where(['email' => $request->email])->first();
                // if ($customer && $customer->is_confirmed != '2') {
                if ($customer) {
                    $request->flash();
                    return view('user.auth.login', ['return_url' => $request->return_url])->withErrors($validator)
                       ->withInput($request->input())
                       ->with('errorMsg', trans('common.error.account_not_confirmed'));                    
                }

                if (Auth::guard($this->guard)->attempt(['email'=>$request->email, 'password'=>$request->password])) {
                    
                    if (!empty($request->return_url)) {
                        return Redirect::to($request->return_url);
                    } else {
                        return Redirect::to($this->redirectPath());
                    }

                } else {

                    return view('user.auth.login', ['return_url' => $request->return_url])
                        ->with('errorMsg', trans('common.error.invalid_account_or_password'));
                }

            } catch (Exception $e) {
      
                return view('user.auth.login', $dataArray)->with('errorMsg', trans('common.error.db_save_failed'));

            }
        }

        return view('user.auth.login', ['return_url' => $request->return_url]);
    }

    //
    public function logout()
    {
        if (Auth::guard($this->getGuard())->user()){
            Auth::guard($this->getGuard())->logout();
        }

        return Redirect::to($this->redirectPath());
    }  

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {

        if (!Auth::guard($this->getGuard())->guest()) {
            return Redirect::to($this->redirectPath());
        }

        $validator = $this->validatorRegister($request->all());
        // dd($validator);

        if ($validator->fails()) {
            $request->flash();
            // return view('user.auth.register', $dataArray)
            return view('user.auth.register')
                ->withErrors($validator)
                ->withInput($request->input())
                ->with('errorMsg', 'There was a problem with your form submission.');
        }

        if (!Captcha::check($request->captcha)) {
            $request->flash();
            // return view('user.auth.register', $dataArray)->withErrors($validator)
            return view('user.auth.register')->withErrors($validator)
                ->withInput($request->input())
                ->with('errorMsg', trans('common.error.invalid_captcha'));
        }

        try {

            $customer = User::where(['email' => $request->email])->first();
            // if already exist show the reload the resiter page with already_exists message
            if (!empty($customer)) {

                $errorMsg = trans('common.error.already_exists');
                $errorMsg = str_replace('%1', trans('customer.label_email'), $errorMsg);
                $errorMsg = str_replace('%2', $request->email, $errorMsg);

                $request->flash();
                // return view('user.auth.register', $dataArray)
                return view('user.auth.register')
                    ->withErrors($validator)
                    ->withInput($request->input())
                    ->with('errorMsg', $errorMsg);
            }

            $emailConfig = $this->getConfig('email');
            if ($emailConfig && !empty($emailConfig['sender_email'])) {

                // Thanks email to the registered user
                // Mail::send('user.emails.register_thanks', [], function ($message) use($request, $emailConfig) {

                //     $message->from($emailConfig['sender_email'], empty($emailConfig['sender_name']) ? trans('email.config.sender_name') : $emailConfig['sender_name']);
                //     // $message->to($request->email)->subject(trans('email.subject.customer_register_thanks'));
                //     $message->to($request->email)->subject( 'Thank You for Your Request to Retrive Your SBCC License Key' );

                // });

                // Notification email to admin/group of new user registration
                if (!empty($emailConfig['email_group_registration_notification'])) {
                    $data = [
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
                        'purchased_from'    => $request->purchased_from
                        // 'partner_type' => getPartnerTypeById($request->partner_type),
                        // 'referred_person' => $request->referred_person,
                    ];
                    Mail::send('user.emails.register_notification', $data, function ($message) use($emailConfig) {
                        
                        if (strpos($emailConfig['email_group_registration_notification'], ",")){
                            $addrArray = explode(',', $emailConfig['email_group_registration_notification']);
                            foreach ($addrArray as $k => $v) {
                                $addrArray[$k] = trim($v);
                            }
                       
                        }else {
                            $addrArray[0] = trim($emailConfig['email_group_registration_notification']);
                        }

                        $message->from($emailConfig['sender_email'], empty($emailConfig['sender_name']) ? trans('email.config.sender_name') : $emailConfig['sender_name']);
                        // $message->to($addrArray)->subject(trans('email.subject.customer_register_notification'));
                        $message->to($addrArray)->subject('A new user has requested access to the License Portal');

                    });
                }

            }

            // if it gets to this point then create the user and send email verification
            event(new Registered($user = $this->createUser($request->all() ) ) );

            //dd($user->id);

            // $this->guard()->login($user);

            // return $this->registered($request, $user) ? : redirect($this->redirectPath());

            // $ret = $this->createUser($request->all());
            // Auth::guard($this->getGuard())->login($ret);
            $dataArray = [
                "data" => [
                    "email"     => $request->email,
                    'user_id'   => $user->id,
                ]
            ];

            return view('user.auth.register_thanks', $dataArray);

        } catch (Exception $e) {
      
            // return view('user.auth.register', $dataArray)->with('errorMsg', trans('common.error.db_save_failed'));
            return view('user.auth.register')->with('errorMsg', trans('common.error.db_save_failed'));

        }

    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        // 
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
    //   $customer = [
    //     'is_vendor'   => 'vendor_val',
    //     'is_user'     => 'user_val',
    //     'is_pwd'      => 'pwd_val',
    //     'name'        => 'name_val',
    //     'email'       => 'email_val',
    //     'company'     => 'company_val',
    //     'address1'    => 'address1_val',
    //     'phone'       => 'phone_val',
    //     'region'      => 'region_val',
    //     'country'     => 'country_val',
    //     'postalcode'  => 'postalcode_val',
    //     'city'        => 'city_val',
    // ];

    // dd($customer['phone']);
        
        // $client = new Client();
        // $res = $client->get('http://quicklicensemanager.com/qlmdemov11/qlmLicenseServer/qlmservice.asmx/GetActivationKeyWithExpiryDate?is_productid=1&is_majorversion=1&is_minorversion=0&is_expduration=30');
        // // echo $res->getStatusCode(); // 200
        // echo $res->getBody(); // { "type": "User", .



        if (!Auth::guard($this->getGuard())->guest()) {
            return Redirect::to($this->redirectPath());
        }

//         $dataArray = [
//             'param' => [
//                 'countries' => trans('common.countries'),
//                 'provinces' => json_encode(trans('common.provinces')),
//                 'partners' => trans('common.partners') 
//             ]
//         ];
 
        // if ($request->isMethod('post')) {

        //     $validator = $this->validatorRegister($request->all());

        //     if ($validator->fails()) {
        //         $request->flash();
        //         return view('user.auth.register', $dataArray)
        //             ->withErrors($validator)
        //             ->withInput($request->input());
        //     }

        //     if (!Captcha::check($request->captcha)) {
        //         $request->flash();
        //         return view('user.auth.register', $dataArray)->withErrors($validator)
        //             ->withInput($request->input())
        //             ->with('errorMsg', trans('common.error.invalid_captcha'));
        //     }

        //     try {

        //         $customer = User::where(['email' => $request->email])->first();
        //         // if already exist show the reload the resiter page with already_exists message
        //         if (!empty($customer)) {

        //             $errorMsg = trans('common.error.already_exists');
        //             $errorMsg = str_replace('%1', trans('customer.label_email'), $errorMsg);
        //             $errorMsg = str_replace('%2', $request->email, $errorMsg);

        //             $request->flash();
        //             return view('user.auth.register', $dataArray)
        //                 ->withErrors($validator)
        //                 ->withInput($request->input())
        //                 ->with('errorMsg', $errorMsg);
        //         }

        //         // if it gets to this point then create the user.
        //         $ret = $this->createUser($request->all());
        //         // Auth::guard($this->getGuard())->login($ret);

        //         $emailConfig = $this->getConfig('email');
        //         if ($emailConfig && !empty($emailConfig['sender_email'])) {

        //             // Thanks email to the registered user
        //             Mail::send('user.emails.register_thanks', [], function ($message) use($request, $emailConfig) {

        //                 $message->from($emailConfig['sender_email'], empty($emailConfig['sender_name']) ? trans('email.config.sender_name') : $emailConfig['sender_name']);
        //                 // $message->to($request->email)->subject(trans('email.subject.customer_register_thanks'));
        //                 $message->to($request->email)->subject( 'Thank You for Your Request to Retrive Your SBCC License Key' );

        //             });

        //             // Notification email to admin/group of new user registration
        //             if (!empty($emailConfig['email_group_registration_notification'])) {
        //                 $data = [
        //                     'first_name'        => $request->first_name,
        //                     'last_name'         => $request->last_name,
        //                     'email'             => $request->email,
        //                     'phone'             => $request->phone,
        //                     'organization_name'       => $request->shool_name,
        //                     'address'           => $request->address,
        //                     'city'              => $request->city,
        //                     'state'             => $request->state,
        //                     'zip_code'          => $request->zip_code
        //                     // 'partner_type' => getPartnerTypeById($request->partner_type),
        //                     // 'referred_person' => $request->referred_person,
        //                 ];
        //                 Mail::send('user.emails.register_notification', $data, function ($message) use($emailConfig) {
        //                     
        //                     if (strpos($emailConfig['email_group_registration_notification'], ",")){
        //                         $addrArray = explode(',', $emailConfig['email_group_registration_notification']);
        //                         foreach ($addrArray as $k => $v) {
        //                             $addrArray[$k] = trim($v);
        //                         }
        //                    
        //                     }else {
        //                         $addrArray[0] = trim($emailConfig['email_group_registration_notification']);
        //                     }

        //                     $message->from($emailConfig['sender_email'], empty($emailConfig['sender_name']) ? trans('email.config.sender_name') : $emailConfig['sender_name']);
        //                     $message->to($addrArray)->subject(trans('email.subject.customer_register_notification'));

        //                 });
        //             }

        //         }

        //         return view('user.auth.register_thanks');

        //     } catch (Exception $e) {
        //   
        //         return view('user.auth.register', $dataArray)->with('errorMsg', trans('common.error.db_save_failed'));

        //     }
        // }

        // return view('user.auth.register', $dataArray);
        return view('user.auth.register');
    }

    public function createCaptcha(Request $request)
    {
         return Captcha::create('default');
    }

    protected function validatorLogin(array $data)
    {
        return Validator::make($data, [
            'email'     => 'required|email|max:100',
            'password'  => 'required|min:6',
            'captcha'   => 'required',
        ]);
    }

    protected function validatorRegister(array $data)
   {
       // alpha num with spaces and special chars .,*-_$#&  =>regex:/^[a-zA-Z0-9\s.,*-_$#&]*$/
       // alpha num with spaces                             =>regex:/^[a-zA-Z0-9\s]*$/
        $checkRule = [
            'first_name'        => 'required|alpha_num|max:50',
            'last_name'         => 'required|alpha_num|max:50',
            'email'             => 'required|email|max:50',
            // 'email'             => [
            //                             'required',
            //                             // 'regex:/gmail|yahoo|hotmail|live|aol|outlook|screenbeam/',
            //                             'regex:/^(?!.*gmail|.*yahoo|.*hotmail|.*live|.*aol|.*outlook).*$/',
            //                             'email',
            //                             'max:50',
            //                         ],
            'phone'             => 'required|regex:/^[a-zA-Z0-9\s-_+*()]*$/|max:50',
            'organization_name' => 'required|regex:/^[a-zA-Z0-9\s-_+.,!@$%^*()]*$/|max:50',
            'address'           => 'required|regex:/^[a-zA-Z0-9\s-_+.,!@$%^*()]*$/|max:100',
            'city'              => 'required|regex:/^[a-zA-Z0-9\s]*$/|max:50',
            'state'             => 'required|regex:/^[a-zA-Z0-9\s]*$/|max:50',
            'zip_code'          => 'required|alpha_num|max:50',
            'purchased_from'    => 'required|regex:/^[a-zA-Z0-9\s-_+.,!@$%^*()]*$/|max:100',
            'password'          => 'required|confirmed|min:6',
            'captcha'           => 'required',
        ];

        // if ($data['province_type'] == '2') {
        //     $checkRule['province_id'] = 'required|max:32';
        // } else {
        //     $checkRule['province'] = 'required|max:50';
        // }

        return Validator::make($data, $checkRule);
    }

    protected function createUser(array $data)
    {
        $tempArray = [
            'organization_name' => $data['organization_name'],
            'address'           => $data['address'],
            'city'              => $data['city'],
            'state'             => $data['state'],
            'zip_code'          => $data['zip_code'],
            'country'           => $data['country'],
            'first_name'        => $data['first_name'],
            'last_name'         => $data['last_name'],
            'email'             => $data['email'],
            'phone'             => $data['phone'],
            'purchased_from'    => $data['purchased_from'],
            'password'          => bcrypt($data['password']),
        ];

        // if ($data['province_type'] == '2') {
        //     $tempArray['province_id'] = $data['province_id'];
        //     $tempArray['province'] = '';
        // } else {
        //     $tempArray['province'] = $data['province'];
        //     $tempArray['province_id'] = '';
        // }

        // returns the saved model instance
        return User::create($tempArray);
    }

}
