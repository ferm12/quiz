<?php

namespace App\Http\Controllers\User;

use Validator, Redirect, Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Http\Controllers\User\BaseController as Controller;
use App\Models\Deal_registration;
use App\Models\User;

class DealController extends Controller
{
    public function index()
    {
        $customer = Auth::guard($this->getGuard())->user();

        $deals = Deal_registration::where(['user_id' => $customer->id])
            ->orderBy('id', 'DESC')
            ->paginate($this->eachPageCount);

        return view('user.deal.index', [
            'username'  => $customer->firstname . ' ' . $customer->lastname, 
            'deals'     => $deals
        ]);
    }

    public function create(Request $request)
    {
        $customer = Auth::guard('user')->user();
        $dataArray = [
            'username' => $customer->firstname . ' ' . $customer->lastname,
            'param' => [
                'countries'     => trans('common.countries'),
                'managers'      => trans('common.managers'),
                'distributors'  => trans('common.distributors'),
                'provinces'     => json_encode(trans('common.provinces')),
                'products'      => trans('deal.products') 
            ]
        ];

        if ($request->isMethod('post')) {

            $validator = $this->validatorCreate($request->input());
            if ($validator->fails()) {

                $request->flash();
                return view('user.deal.create', $dataArray)->withErrors($validator)
                                                           ->withInput($request->input())
                                                           ->with('errorMsg', trans('common.error.invalid_parameter'));
            }

            try {

                $deal = Deal_registration::where(['opportunity_name' => $request->opportunity_name])->first();
                if (!empty($deal)) {

                    $errorMsg = trans('common.error.already_exists');
                    $errorMsg = str_replace('%1', trans('deal.str_opportunity_name'), $errorMsg);
                    $errorMsg = str_replace('%2', $request->opportunity_name, $errorMsg);

                    $request->flash();
                    return view('user.deal.create', $dataArray)->withErrors($validator)
                                                                ->withInput($request->input())
                                                                ->with('errorMsg', $errorMsg);
                }

                $newDeal = [
                    'opportunity_id' => crc32($request->opportunity_name),
                    'opportunity_name' => $request->opportunity_name,
                    'opportunity_date' => $request->opportunity_date,
                    'opportunity_account_manager' => $request->opportunity_account_manager,
                    'opportunity_product' => $request->opportunity_product,
                    'reseller_company' => $request->reseller_company,
                    'reseller_contact' => $request->reseller_contact,
                    'reseller_email' => $request->reseller_email,
                    'reseller_phone' => $request->reseller_phone,
                    'distributor_preferred' => $request->distributor_preferred,
                    'distributor_contact_firstname' => $request->distributor_contact_firstname,
                    'distributor_contact_lastname' => $request->distributor_contact_lastname,
                    'distributor_email' => $request->distributor_email,
                    'distributor_phone' => $request->distributor_phone,
                    'customer_company' => $request->customer_company,
                    'customer_contact' => $request->customer_contact,
                    'customer_email' => $request->customer_email,
                    'customer_phone' => $request->customer_phone,
                    'customer_address' => $request->customer_address,
                    'customer_city' => $request->customer_city,
                    'customer_postal_code' => $request->customer_postal_code,
                    'customer_country' => $request->customer_country,
                    'opportunity_status' => '1',
                    'user_id' => $customer->id,
                ];

                if ($request->customer_province_type == '2') {
                    $newDeal['customer_province_id'] = $request->customer_province_id;
                    $newDeal['customer_province'] = '';
                } else {
                    $newDeal['customer_province'] = $request->customer_province;
                    $newDeal['customer_province_id'] = '';
                }

                Deal_registration::create($newDeal);

                //
                $emailConfig = $this->getConfig('email');
                if ($emailConfig && !empty($emailConfig['sender_email'])) {

                    $data = [
                        'opportunity_id' => $newDeal['opportunity_id'],
                        'opportunity_name' => $newDeal['opportunity_name'],
                        'opportunity_date' => date('Y-m-d', strtotime($newDeal['opportunity_date'])),
                        'opportunity_account_manager' => getAccountManagerById($newDeal['opportunity_account_manager']),
                        'opportunity_product' => $newDeal['opportunity_product'],
                        'reseller_company' => $newDeal['reseller_company'],
                        'reseller_contact' => $newDeal['reseller_contact'],
                        'reseller_email' => $newDeal['reseller_email'],
                        'reseller_phone' => $newDeal['reseller_phone'],
                        'distributor_preferred' => getDistributorById($newDeal['distributor_preferred']),
                        'distributor_contact_firstname' =>$newDeal['distributor_contact_firstname'],
                        'distributor_contact_lastname' => $newDeal['distributor_contact_lastname'],
                        'distributor_email' => $newDeal['distributor_email'],
                        'distributor_phone' => $newDeal['distributor_phone'],
                        'customer_company' => $newDeal['customer_company'],
                        'customer_contact' => $newDeal['customer_contact'],
                        'customer_email' => $newDeal['customer_email'],
                        'customer_phone' => $newDeal['customer_phone'],
                        'customer_address' => $newDeal['customer_address'],
                        'customer_city' => $newDeal['customer_city'],
                        'customer_postal_code' => $newDeal['customer_postal_code'],
                        'customer_country' => getCountryById($newDeal['customer_country']),
                        'customer_province' => empty($newDeal['customer_province']) ? getRegionById($newDeal['customer_country'], $newDeal['customer_province_id']) : $newDeal['customer_province'],
                        'opportunity_submit_date' => date('Y-m-d', time()),  
                    ];
                    $username = $customer->firstname . ' ' . $customer->lastname;

                    // Thanks email
                    Mail::send('user.emails.deal_thanks', 
                                ['username' => $username, 'deal' => $data], 
                                function ($message) use($customer, $emailConfig) {

                        $message->from($emailConfig['sender_email'], empty($emailConfig['sender_name']) ? trans('email.config.sender_name') : $emailConfig['sender_name']);
                        $message->to($customer->email)->subject(trans('email.subject.deal_registration_thanks'));

                    });

                    // Notification email
                    if (!empty($emailConfig['email_group_deal_notification'])) {

                        Mail::send('user.emails.deal_notification', 
                                    ['username' => $username, 'deal' => $data],
                                    function ($message) use($username, $emailConfig) {
                            
                            $addrArray = explode(',', $emailConfig['email_group_deal_notification']);
                            foreach ($addrArray as $k => $v) {
                                $addrArray[$k] = trim($v);
                            }

                            $subject = trans('email.subject.deal_registration_notification');
                            $subject = str_replace('%1', $username, $subject);

                            $message->from($emailConfig['sender_email'], empty($emailConfig['sender_name']) ? trans('email.config.sender_name') : $emailConfig['sender_name']);
                            $message->to($addrArray)->subject($subject);

                        });
                    }

                }

                // Show confirm page
                $newDeal['opportunity_submit_date'] = date('Y-m-d');
                $newDeal['customer_country'] = getCountryById($request->customer_country);
                $newDeal['opportunity_account_manager'] = getAccountManagerById($request->opportunity_account_manager);
                $newDeal['distributor_preferred'] = getDistributorById($request->distributor_preferred);

                if (empty($newDeal['customer_province']))
                    $newDeal['customer_province'] = getRegionById($request->customer_country, $request->customer_province_id);

                return view('user.deal.create_confirm', ['username' => $customer->firstname, 'deal' => $newDeal]);

            } catch (Exception $e) {

                return view('user.deal.create', $dataArray)->with('errorMsg', trans('common.error.db_save_failed'));
            } 
        }

        //
        if ($customer) {
            $dataArray['customer'] = array('reseller_company' => $customer->company,
                                           'reseller_phone' => $customer->phone,
                                           'reseller_email' => $customer->email,
                                           'reseller_contact' => $customer->firstname . ' ' . $customer->lastname);
        }

        return view('user.deal.create', $dataArray);
    }

    public function view(Request $request, $id, $page)
    {
        $customer = Auth::guard($this->getGuard())->user();

        $deal = Deal_registration::where(['id' => $id, 'user_Id' => $customer->id])->first();
        if (empty($deal)) {
            return view('errors.404');
        }

        return view('user.deal.view', ['username' => $customer->firstname . ' ' . $customer->lastname,
                                       'deal' => $deal]);
    }

    protected function validatorCreate(array $data)
    {
        $checkRule = [
            'accept' => 'required',
            'opportunity_name' => 'required|max:100',
            'opportunity_date' => 'required',
            'opportunity_account_manager' => 'required|max:50',
            'opportunity_product' => 'required',
            'reseller_company' => 'required|max:50',
            'reseller_contact' => 'required|max:50',
            'reseller_email' => 'required|max:100',
            'reseller_phone' => 'required|max:50',
            'distributor_preferred' => 'required|max:50',
            'distributor_contact_firstname' => 'required|max:50',
            'distributor_contact_lastname' => 'required|max:50',
            'distributor_email' => 'required|max:100',
            'distributor_phone' => 'required|max:50',
            'customer_company' => 'required|max:50',
            'customer_contact' => 'required|max:50',
            'customer_email' => 'required|max:100',
            'customer_phone' => 'required|max:50',
            'customer_address' => 'required|max:100',
            'customer_city' => 'required|max:50',
            'customer_postal_code' => 'required|max:50',
            'customer_country' => 'required|max:50',
        ];

        if ($data['customer_province_type'] == '2') {
            $checkRule['customer_province_id'] = 'required|max:32';
        } else {
            $checkRule['customer_province'] = 'required|max:50';
        }

        return Validator::make($data, $checkRule);
    }

}
