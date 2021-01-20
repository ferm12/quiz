<?php

namespace App\Http\Controllers\Admin;

use Validator, Redirect, Mail, DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Admin\BaseController as Controller;
// use App\Models\Deal_registration;
use App\Models\Mac_id;
use App\Models\User;

class MacidController extends Controller
{
    // protected $modulePath = 'deals';
    protected $modulePath = 'macids';

    //
    public function index(Request $request)
    {
        // $userPermission = $this->getUserPermission();
        // if ($userPermission && $userPermission['deal_priv'] != 'Y') {
        //     return Redirect::to($this->redirectPath());
        // }

        $errorMsg = $request->session()->pull('errorMsg', '');
        $successMsg = $request->session()->pull('successMsg', '');

        $deals = null;
        // $dataArray = ['param' => ['status' => trans('deal.status'),
        // 						  'managers' => trans('common.managers'),
        //                           'distributors' => trans('common.distributors') ]];

        if ($request->isMethod('post')) {

            $searchArray = [
                'search_user_id'        => $request->search_user_id,
                'search_sn'             => $request->search_sn,
                'search_mac_id'         => $request->search_mac_id,
                'search_purchased_from' => $request->search_purchased_from,
                'search_taken'          => $request->search_taken,
                'search_license_number' => $request->search_license_number,
                'search_activation_key' => $request->search_activation_key,
                'search_created_date'   => $request->search_created_date,
            ];

            // $deals = $this->getDeals($searchArray, $this->eachPageCount);
            $mac_ids = $this->getMacIds($searchArray, $this->eachPageCount);

            $dataArray['search'] = base64_encode(json_encode($searchArray));
            $dataArray['searchArray'] = $searchArray;

        } else {

            if (empty($request->search)) {

                // Show all deals
                // $deals = Deal_registration::where('opportunity_status', '>', '0')
                //     ->orderBy('id', 'DESC')
                //     ->paginate($this->eachPageCount);       

                $mac_ids = Mac_id::orderBy('id', 'DESC')
                    ->paginate($this->eachPageCount);       

            } else {

                $searchArray = json_decode(base64_decode($request->search), true);
                $deals = $this->getDeals($searchArray, $this->eachPageCount);

                $dataArray['searchArray'] = $searchArray;             
            }

            $dataArray['search'] = $request->search;
        }

        // $dataArray['deals'] = $deals;
        // $dataArray['userPermission'] = $userPermission;
        $dataArray['mac_ids'] = $mac_ids;
        
        $view = view('admin.macid_index', $dataArray);
        if (!empty($successMsg)) {
            $view->with('successMsg', $successMsg);
        }
        if (!empty($errorMsg)) {
            $view->with('errorMsg', $errorMsg);
        }

        return $view;
    }

    public function modify(Request $request, $id, $page)
    {
        // $userPermission = $this->getUserPermission();
        // if ($userPermission && $userPermission['deal_priv'] != 'Y') { //     return Redirect::to($this->redirectPath());
        // }

        $whereArray = [
            // ['opportunity_status', '>', '0'],
            ['id', '=', $id],
        ];

        // $deal = Deal_registration::where($whereArray)->first();
        $mac_ids = Mac_id::where($whereArray)->first();
        if (empty($mac_ids)) {
            return view('errors.404');
        }

        // $dataArray = ['userPermission' => $userPermission,
        //               'param' => ['status' => trans('deal.status'),
        //                           'rejections' => trans('deal.rejections'),
        //                           'managers' => trans('common.managers'),
        //                           'distributors' => trans('common.distributors') ]];

        $dataArray['mac_id'] = [
            'id'                => $mac_ids->id,
            'user_id'           => $mac_ids->user_id,
            'sn'                => $mac_ids->sn,
            'mac_id'            => $mac_ids->mac_id,
            'purchased_from'    => $mac_ids->purchased_from,
            'taken'             => $mac_ids->taken,
            'license_number'    => $mac_ids->license_number,
            'activation_key'    => $mac_ids->activation_key,
            'created_date'      => $mac_ids->created_date,
            'page'              => $page
        ];                       

        return view('admin.macid_modify', $dataArray);
    }

    public function modifyPost(Request $request)
    {
        // $userPermission = $this->getUserPermission();
        // if ($userPermission && $userPermission['deal_priv'] != 'Y') {
        //     return Redirect::to($this->redirectPath());
        // }

        if ($request->isMethod('post')) {

            try {

                // $whereArray = [
                //     // ['opportunity_status', '>', '0'],
                //     ['id', '=', $request->id],
                // ];

                // $deal = Deal_registration::where($whereArray)->first();
                // if (!empty($deal)) {

                $mac_id = Mac_id::where(['id' => $request->id])->first();
                $customer = User::where(['id' => $mac_id->user_id])->first();

                if (!empty($customer)) {

                    $mac_id->sn             = $request->sn;
                    $mac_id->mac_ID         = $request->mac_id;
                    $mac_id->purchased_from = $request->purchased_from;
                    $mac_id->taken          = $request->taken;
                    $mac_id->license_number = $request->license_number;
                    $mac_id->activation_key = $request->activation_key;

                    $mac_id->save();

                    if ($request->sendemail == 'on') {
                        
                        $data = [
                            'sn'                => $request->sn,
                            'mac_id'            => $request->mac_id,
                            'purchased_from'    => $request->purchased_from,
                            'taken'             => $request->taken,
                            'license_number'    => $request->license_number,
                            'activation_key'    => $request->activation_key,
                        ];

                        // if (empty($data['customer_province'])) {
                        //     $data['customer_province'] = getRegionById($deal->customer_country, $deal->customer_province_id);
                        // }

                        $emailConfig = $this->getConfig();
                        if ($emailConfig && !empty($emailConfig['sender_email'])) {

                            $username = $customer->first_name . ' ' . $customer->last_name;


                            // Mail::send('user.emails.deal_approved', ['username' => $username, 'mac_id' => $data], function ($message) use($customer, $emailConfig) {
                            Mail::send('user.emails.mac_id_modified', ['username' => $username, 'mac_id' => $data], function ($message) use($customer, $emailConfig) {

                                $message->from($emailConfig['sender_email'], empty($emailConfig['sender_name']) ? trans('email.config.sender_name') : $emailConfig['sender_name']);
                                $message->to($customer->email)->subject('Mac ID updated.');

                            });
                        }
                    }
                    
                    // $request->session()->put('successMsg', str_replace('%1', $request->id, trans('common.info.success_modify_deal')));
                    $request->session()->put('successMsg',"Modified Mac ID (ID:{$request->id}) successfully");

                } else {

                    $request->session()->put('errorMsg', 'Failed to save to the database. Invalid user id');                    
                }

                $url =  $this->redirectPath() . '/' . $this->modulePath;
                if (!empty($request->page))
                    $url .= '?page=' . $request->page;

                return Redirect::to($url);

            } catch (Exception $e) {

                return view('admin.macid_modify', $dataArray)->with('errorMsg', 'Failed to save to the database');
            }           
        }        
    }

    public function delete(Request $request, $id, $page)
    {
        // $userPermission = $this->getUserPermission();
        // if ($userPermission && $userPermission['deal_priv'] != 'Y') {
        //     return Redirect::to($this->redirectPath());
        // }
        
        $url =  $this->redirectPath() . '/' . $this->modulePath;
        if (!empty($page))
            $url .= '?page=' . $page;

        try {

            $whereArray = [
                // ['opportunity_status', '>', '0'],
                ['id', '=', $id],
            ];

            // $deal = Deal_registration::where($whereArray)->first();
            // if (!empty($deal)) {
            $mac_id = Mac_id::where($whereArray)->first();
            if (!empty($mac_id)) {

                $mac_id->delete();

                $successMsg = "Deleted Mac ID (ID: {$id} successfully)";

                $request->session()->put('successMsg', $successMsg);

            } else {

                $request->session()->put('errorMsg', trans('common.error.db_operation_error'));

            }

        } catch (Exception $e) {

            $request->session()->put('errorMsg', trans('common.error.db_operation_error'));
        }

        return Redirect::to($url); 

    }

    public function exportCSV(Request $request)
    {
        // $userPermission = $this->getUserPermission();
        // if ($userPermission && $userPermission['customer_priv'] != 'Y') {
        //     return Redirect::to($this->redirectPath());
        // }

        $searchArray = [
            'search_opportunity_id' => $request->search_opportunity_id,
            'search_opportunity_name' => $request->search_opportunity_name,
            'search_opportunity_date' => $request->search_opportunity_date,
            'search_reseller_company' => $request->search_reseller_company,
            'search_reseller_contact' => $request->search_reseller_contact,
            'search_customer_company' => $request->search_customer_company,
            'search_product_quantity' => $request->search_product_quantity,
            'search_distributor_preferred' => $request->search_distributor_preferred,
            'search_opportunity_account_manager' => $request->search_opportunity_account_manager,
            'search_create_time' => $request->search_create_time,
            'search_opportunity_status' => $request->search_opportunity_status,
        ];

        $deals = $this->getDeals($searchArray, 0);

        $count = count($deals);
        if ($count > 0) {

            $data  = "\"Deal Number\",\"Opportunity Name\",\"Estimated Close Date\",\"Product & Quantity\",";
            $data .= "\"Reseller Company\",\"Reseller Contact\",\"Reseller Phone\",\"Reseller Email\",";
            $data .= "\"Preferred Distributor\",\"Distributor Contact\",\"Distributor Phone\",";
            $data .= "\"Distributor Email\",\"Customer Company\",\"Customer Contact\",";
            $data .= "\"Customer Phone\",\"Customer Email\",\"Customer Address\",";
            $data .= "\"Customer City\",\"Customer State/Province\",\"Customer Postal Code\",";
            $data .= "\"Customer Country\",\"Deal Status\",\"Rejection Reason\",\"Create Time\"";

            foreach ($deals as $row) {

                // region
                $region = (empty($row->customer_province))? getRegionById($row->customer_country, $row->customer_province_id):$row->customer_province;

                $line  = "\"" . $row->opportunity_id . "\",\"" . $row->opportunity_name . "\",\"";
                $line .= $row->opportunity_date . "\",\"" . $row->opportunity_product . "\",\"";
                $line .= $row->reseller_company . "\",\"" . $row->reseller_contact . "\",\"";
                $line .= $row->reseller_phone . "\",\"" . $row->reseller_email . "\",\"";
                $line .= $row->distributor_preferred . "\",\"" . $row->distributor_contact_firstname . " " . $row->distributor_contact_lastname . "\",\"";
                $line .= $row->distributor_phone . "\",\"" . $row->distributor_email . "\",\"";
                $line .= $row->customer_company . "\",\"" . $row->customer_contact . "\",\"";
                $line .= $row->customer_phone . "\",\"" . $row->customer_email . "\",\"";
                $line .= $row->customer_address . "\",\"" . $row->customer_city . "\",\"";
                $line .= $region . "\",\"" . $row->customer_postal_code . "\",\"";
                $line .= getCountryById($row->customer_country) . "\",\"" . getDealStatusById($row->opportunity_status) . "\",\"";
                $line .= getDealRejectionReasonById($row->opportunity_rejection_code) . "\",\"" . $row->created_at . "\"";

                $data .= "\r\n" . $line;
            }

            $filename = 'deal_registrations_export_to_' . date('YmdHis', time()) . '.csv';

            return response($data, 200)
                        ->header('Pragma', 'public')
                        ->header('Cache-Control', 'must-revalidate, post-check=0, pre-check=0')
                        ->header('Content-Type', 'text/csv; charset=UTF-8')
                        ->header('Content-Length', strlen($data))
                        ->header('Content-Disposition', 'attachment;filename=' . $filename);
        }

        return trans('common.str_no_record');
    }

    // protected function getDeals($searchArray, $eachPageCount) {
    protected function getMacIds($searchArray, $eachPageCount) {

        $whereArray = [];

        if (!empty($searchArray['search_user_id'])) {
            array_push($whereArray, ['user_id', 'like', "%" . $searchArray['search_user_id'] . "%"]);
        }
        if (!empty($searchArray['search_sn'])) {
            array_push($whereArray, ['sn', 'like', "%" . $searchArray['search_sn'] . "%"]);
        }
        if (!empty($searchArray['search_mac_id'])) {
            array_push($whereArray, ['mac_id', 'like', "%" . $searchArray['search_mac_id'] . "%"]);
        }
        if (!empty($searchArray['search_purchased_from'])) {
            array_push($whereArray, ['purchased_from', 'like', "%" . $searchArray['search_purchased_from'] . "%"]);
        }
        if (!empty($searchArray['search_taken'])) {
            array_push($whereArray, ['taken', 'like', "%" . $searchArray['search_taken'] . "%"]);
        }
        if (!empty($searchArray['search_license_number'])) {
            array_push($whereArray, ['license_number', 'like', "%" . $searchArray['search_license_number'] . "%"]);
        }
        if (!empty($searchArray['search_activation_key'])) {
            array_push($whereArray, ['activation_key', 'like', "%" . $searchArray['search_activation_key'] . "%"]);
        }
        if (!empty($searchArray['search_created_date'])) {
            array_push($whereArray, ['created_at', 'like', "%" . $searchArray['search_created_date'] . "%"]);
        }

        // $Query = Deal_registration::where($whereArray)->orderBy('id', 'DESC');
        $Query = Mac_id::where($whereArray)->orderBy('id', 'DESC');

        if ($eachPageCount > 0) {
            return $Query->paginate($eachPageCount);
        } 

        return $Query->get();   

/*
        return Deal_registration::where(function($query) use($searchArray) {

                        $query->where('opportunity_status', '>', '0');

                        if (!empty($searchArray['search_opportunity_id'])) {
                            $query->where('opportunity_id', 'like', "%" . $searchArray['search_opportunity_id'] . "%");
                        }
                        if (!empty($searchArray['search_opportunity_name'])) {
                            $query->where('opportunity_name', 'like', "%" . $searchArray['search_opportunity_name'] . "%");
                        }
                        if (!empty($searchArray['search_opportunity_date'])) {
                            $query->where('opportunity_date', 'like', "%" . $searchArray['search_opportunity_date'] . "%");
                        }
                        if (!empty($searchArray['search_reseller_company'])) {
                            $query->where('reseller_company', 'like', "%" . $searchArray['search_reseller_company'] . "%");
                        }
                        if (!empty($searchArray['search_reseller_contact'])) {
                            $query->where('reseller_contact', 'like', "%" . $searchArray['search_reseller_contact'] . "%");
                        }
                        if (!empty($searchArray['search_customer_company'])) {
                            $query->where('customer_company', 'like', "%" . $searchArray['search_customer_company'] . "%");
                        }
                        if (!empty($searchArray['search_product_quantity'])) {
                            $query->where('opportunity_product', 'like', "%" . $searchArray['search_product_quantity'] . "%");
                        }
                        if (!empty($searchArray['search_distributor_preferred'])) {
                            $query->where('distributor_preferred', '=', $searchArray['search_distributor_preferred']);
                        }
                        if (!empty($searchArray['search_opportunity_account_manager'])) {
                            $query->where('opportunity_account_manager', '=', $searchArray['search_opportunity_account_manager']);
                        }
                        if (!empty($searchArray['search_create_time'])) {
                            $query->where('created_at', 'like', "%" . $searchArray['search_create_time'] . "%");
                        }
                        if (!empty($searchArray['search_opportunity_status'])) {
                            $query->where('opportunity_status', '=', $searchArray['search_opportunity_status']);
                        }

                    })->orderBy('id', 'DESC')
                      ->paginate($this->eachPageCount);

*/

    }

    // $productQuantity format: 
    //      # SBWD100TX01 ScreenBeam USB Transmitter - 67,# SBTC90W ScreenBeam Touch 90 - Whiteboard - 12'
    protected function getProductCount($productQuantity)
    {
        if (!empty($productQuantity)) {

            $productArray = explode(',', $productQuantity);
            $productCount = 0;

            foreach ($productArray as $row) {

                $tempArray = explode(' - ', $row);
                $count = count($tempArray);
                if ($count > 0) {
                    $productCount += intval($tempArray[$count-1]);
                }
            }

            return $productCount;
        }

        return 0;
    }

    // protected function validatorModify(array $data)
    // {
    //     $checkRule = [
    //         'opportunity_account_manager' => 'required|max:50',
    //         'distributor_preferred' => 'required|max:50',
    //         'opportunity_status' => 'required',
    //     ];

    //     if ($data['opportunity_status'] == '3') {
    //         $checkRule['opportunity_rejection_code'] = 'required|max:50';
    //     }

    //     return Validator::make($data, $checkRule);
    // }     

}
