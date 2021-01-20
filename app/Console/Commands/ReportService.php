<?php

namespace App\Console\Commands;

use Mail;
use Illuminate\Console\Command;

use App\Models\Deal_registration;
use App\Models\User;
use App\Models\Config;

class ReportService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rservice';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Report Service';

    //
    protected $reportFileLocalPath = ''; 
    protected $logFileLocalPath = '';

    protected $prefixSignupList = 'partner_portal_signup_list_';
    protected $prefixDealList = 'partner_portal_deal_registration_list_';
    protected $lastMsgStr = '';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->reportFileLocalPath = config('filesystems.disks.local.reports'); 
        $this->logFileLocalPath = config('filesystems.disks.local.logs');

    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $debug = false;
        $outPut = '';
        $timeStr = date('Y-m-d H:i:s', time());

        // Daily
        $this->lastMsgStr = '';
        if ($this->execDayReport($debug)) {
            $outPut .= $timeStr . " | Execute daily report, success (" . $this->lastMsgStr . ")\n";     
        } else {
            $outPut .= $timeStr . " | Execute daily report, error (" . $this->lastMsgStr . ")\n";
        }

        // Weekly
        $this->lastMsgStr = '';
        if ($this->execWeekReport($debug)) {
            $outPut .= $timeStr . " | Execute weekly report, success (" . $this->lastMsgStr . ")\n";        
        } else {
            $outPut .= $timeStr . " | Execute weekly report, error (" . $this->lastMsgStr . ")\n";
        }

        // Monthly      
        $this->lastMsgStr = '';           
        if ($this->execMonthReport($debug)) {
            $outPut .= $timeStr . " | Execute monthly report, success (" . $this->lastMsgStr . ")\n";
        
        } else {
             $outPut.= $timeStr . " | Execute monthly report, error (" . $this->lastMsgStr . ")\n";
        }

        //
        $this->comment($outPut);
        $this->saveToFile($this->logFileLocalPath . '/service.log', $outPut);

        //
        clearFilesFromDir($this->reportFileLocalPath);

    }

    protected function execMonthReport($debug=false) {

        $currentDay = date('j');
        if ($currentDay != 1 && $debug != true) {
            $this->lastMsgStr = 'Invalid month day: ' . $currentDay;
            return false;
        }

        $prevMonth = date('n') - 1;
        if ($prevMonth <= 0)
            $prevMonth = 12;

        $days = date('t', mktime(0, 0, 0, $prevMonth, 1, date('Y')));
        if ($days <= 0 || $days > 31)
            $days = 30;


        $currentTime = time();
        $monthSeconds = 60*60*24*$days;

        return $this->execStartTimeMonthReport($currentTime - $monthSeconds, $debug);
    }

    //////////////////////////////////////////////////////////////
    // $startTime: return value of time()
    //
    protected function execStartTimeMonthReport($startTime, $debug=false) {

        $currentTime = time();
        if (empty($startTime) || $startTime >= $currentTime) {
            $this->lastMsgStr = 'Invalid start time: ' . (empty($startTime)? '0' : date('Y-m-d H:i:s', $startTime));
            return false;
        }

        //
        $timeStr = date('YmdHis', $currentTime);
        $unitPrice = 1.00;
        $data = [];

        // Customer
        $customers = User::whereRaw("UNIX_TIMESTAMP(created_at) > " . $startTime)->orderBy('created_at', 'DESC')->get(['is_confirmed', 'created_at']);

        $data['customerPendingCount'] = 0;
        $data['customerConfirmedCount'] = 0;
        $data['customerRefusedCount'] = 0;

        $data['customerCount'] = count($customers);
        if ($data['customerCount'] > 0) {

            foreach ($customers as $row) {

                if ($row->is_confirmed == '2') {
                    $data['customerConfirmedCount'] ++;
                } else if ($row->is_confirmed == '3') {
                    $data['customerRefusedCount'] ++;
                } else {
                    $data['customerPendingCount'] ++;
                }

            } // foreach
        }   

        // Deal registration
        $deals = Deal_registration::whereRaw("UNIX_TIMESTAMP(created_at) > " . $startTime)->orderBy('created_at', 'DESC')->get(['opportunity_status', 'opportunity_product', 'created_at']);

        $data['dealPendingCount'] = 0;
        $data['dealApprovedCount'] = 0;
        $data['dealDeclinedCount'] = 0;
        $data['dealQCNCount'] = 0;
        $data['dealAMRICount'] = 0;
        $data['dealMQCCount'] = 0;
        $data['dealCWRCount'] = 0;
        $data['productList'] = [];

        $data['dealCount'] = count($deals );
        if ($data['dealCount'] > 0) {

            foreach ($deals as $row) {

                if ($row->opportunity_status == '2') {
                    $data['dealApprovedCount'] ++;
                } else if ($row->opportunity_status == '3') {
                    $data['dealDeclinedCount'] ++;
                    continue;
                } else if ($row->opportunity_status == '4') {
                    $data['dealQCNCount'] ++;
                    continue;
                } else if ($row->opportunity_status == '5') {
                    $data['dealAMRICount'] ++;
                    continue;
                } else if ($row->opportunity_status == '6') {
                    $data['dealMQCCount'] ++;
                    continue;
                } else if ($row->opportunity_status == '7') {
                    $data['dealCWRCount'] ++;
                    continue;
                } else {
                    $data['dealPendingCount'] ++;
                    continue;
                }

                // Product
                if (!empty($row->opportunity_product)) {

                    $lineArray = explode(',', $row->opportunity_product);
                    foreach ($lineArray as $item) {

                        $pos = strrpos($item, '-');
                        if ($pos > 0) {

                            $productName = trim(substr($item, 0, $pos-1));
                            $productCount = trim(substr($item, $pos+1));

                            if (count($data['productList']) > 0) {

                                $b = false;
                                foreach ($data['productList'] as $k => $v) {

                                    if ($v['product'] == $productName) {
                                        $data['productList'][$k]['count'] += $productCount;
                                        $b = true;
                                        break;
                                    }
                                }

                                if ($b == false) {
                                    array_push($data['productList'], array('product' => $productName,
                                                                           'count' => $productCount));                                  
                                }

                            } else {
                            
                                array_push($data['productList'], array('product' => $productName,
                                                                       'count' => $productCount));
                            }

                        }                   
                    }   // foreach
                }   // if

            }   // foreach

        }

        // Calculate amount and total
        if (count($data['productList']) > 0) {

            $totalCount = 0;
            $totalAmount = 0;
            foreach ($data['productList'] as $k => $v) {

                $data['productList'][$k]['price'] = number_format($unitPrice, 2);

                $amount = $v['count'] * $unitPrice;
                $data['productList'][$k]['amount'] = number_format($amount, 2);

                $totalAmount += $amount;
                $totalCount += $v['count'];
            }

            array_push($data['productList'], array('product' => 'Total',
                                                'price' => '-',
                                                'count' => $totalCount,
                                                'amount' => number_format($totalAmount, 2)));                                   
        } 

        $data['subject'] = trans('email.subject.report_summary_monthly');
        $data['startTime'] = date('Y-m-d H:i:s', $startTime);
        $data['endTime'] = date('Y-m-d H:i:s', $currentTime);

        //
        $param = ['template' => 'service.emails.report_summary',
                  'data' => $data,
                  'subject' => trans('email.subject.report_summary_monthly'),
                  'to' => 'email_group_monthly_summary_report' ];

        $this->sendeReportEmail($param);        

        $this->lastMsgStr = 'Signup count: ' . $data['customerCount'] . ', Deal count: ' . $data['dealCount'];
        return true;
    }

    protected function execWeekReport($debug=false) {

        $week = date('w');
        if ($week != 5 && $debug != true) {
            $this->lastMsgStr = 'Invalid week day: ' . $week;
            return false;
        }

        $currentTime = time();
        $weekSeconds = 60*60*24*7;

        return $this->execStartTimeWeekReport($currentTime-$weekSeconds, $debug);
    }

    protected function execStartTimeWeekReport($startTime, $debug=false) {

        $registerReportEmailSubject = 'Actiontec Partner Portal - Signup Weekly Report';
        $dealReportEmailSubject = 'Actiontec Partner Portal - Deal Registration Weekly Report';

        $currentTime = time();
        if (empty($startTime) || $startTime >= $currentTime) {
            $this->lastMsgStr = 'Invalid start time: ' . (empty($startTime)? '0' : date('Y-m-d H:i:s', $startTime));
            return false;
        }

        $timeStr = date('YmdHis', $currentTime);
        $customerSucc = false;
        $dealSucc = false;

        // Customers
        $customers = User::whereRaw("UNIX_TIMESTAMP(created_at) > " . $startTime)->orderBy('created_at', 'DESC')->get();

        $customerCount = count($customers);
        if ($customerCount > 0) {

            $data  = "\"ID\",\"First Name\",\"Last Name\",\"Email\",\"Phone\",\"Job Title\",\"Company\",";
            $data .= "\"Address\",\"City\",\"Country\",\"State/Province\",\"Postcode\",";
            $data .= "\"Who Referred You\",\"Partner Type\",\"Status\",\"Create Time\",\"Confirm Time\"";
            
            foreach ($customers as $row) {

                // region
                $region = (empty($row->province))? getRegionById($row->country, $row->province_id):$row->province;

                $line  = "\"" . $row->id . "\",\"" . $row->firstname . "\",\"";
                $line .= $row->lastname . "\",\"" . $row->email . "\",\"";
                $line .= $row->phone . "\",\"" . $row->job_title . "\",\"";
                $line .= $row->company . "\",\"" . $row->address . "\",\"";
                $line .= $row->city . "\",\"" . getCountryById($row->country) . "\",\"";
                $line .= $region . "\",\"" . $row->postal_code . "\",\"";
                $line .= $row->referred_person . "\",\"" . getPartnerTypeById($row->partner_type) . "\",\"";
                $line .= getCustomerStatusById($row->is_confirmed) . "\",\"" . $row->created_at . "\",\"";
                $line .= $row->confirm_time . "\"";

                $data .= "\r\n" . $line;
            }

            // Save to file
            $filePath = $this->reportFileLocalPath . '/' . $this->prefixSignupList .'weekly_' . $timeStr . '.csv';
            if ($this->saveToFile($filePath, $data)) {

                $data = ['subject' => trans('email.subject.report_signup_weekly'),
                         'signupCount' => $customerCount,
                         'startTime' => date('Y-m-d H:i:s', $startTime),
                         'endTime' => date('Y-m-d H:i:s', $currentTime) ];

                $param = ['template' => 'service.emails.report_signup',
                          'data' => $data,
                          'subject' => trans('email.subject.report_signup_weekly'),
                          'to' => 'email_group_weekly_reg_report',
                          'attach' => $filePath ];

                $this->sendeReportEmail($param);

                $customerSucc = true;
            }
        } else {

            $data = ['subject' => trans('email.subject.report_signup_weekly'),
                     'signupCount' => 0,
                     'startTime' => date('Y-m-d H:i:s', $startTime),
                     'endTime' => date('Y-m-d H:i:s', $currentTime) ];

            $param = ['template' => 'service.emails.report_signup',
                      'data' => $data,
                      'subject' => trans('email.subject.report_signup_weekly'),
                      'to' => 'email_group_weekly_reg_report' ];

            $this->sendeReportEmail($param);            

            $customerSucc = true;
        }

        // Deal registration
        $deals = Deal_registration::whereRaw("UNIX_TIMESTAMP(created_at) > " . $startTime)->orderBy('created_at', 'DESC')->get();

        $dealCount = count($deals);
        if ($dealCount > 0) {

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

            }   // foreach

            // Save to file
            $filePath = $this->reportFileLocalPath . '/' . $this->prefixDealList .'weekly_' . $timeStr . '.csv';
            if ($this->saveToFile($filePath, $data)) {

                $data = ['subject' => trans('email.subject.report_deal_registration_weekly'),
                         'dealCount' => $dealCount,
                         'startTime' => date('Y-m-d H:i:s', $startTime),
                         'endTime' => date('Y-m-d H:i:s', $currentTime) ];

                $param = ['template' => 'service.emails.report_deal_registration',
                          'data' => $data,
                          'subject' => trans('email.subject.report_deal_registration_weekly'),
                          'to' => 'email_group_weekly_deal_report',
                          'attach' => $filePath ];

                $this->sendeReportEmail($param);

                $dealSucc = true;
            }
        } else {

            $data = ['subject' => trans('email.subject.report_deal_registration_weekly'),
                     'dealCount' => 0,
                     'startTime' => date('Y-m-d H:i:s', $startTime),
                     'endTime' => date('Y-m-d H:i:s', $currentTime) ];

            $param = ['template' => 'service.emails.report_deal_registration',
                      'data' => $data,
                      'subject' => trans('email.subject.report_deal_registration_weekly'),
                      'to' => 'email_group_weekly_deal_report' ];

            $this->sendeReportEmail($param);

            $dealSucc = true;
        } 

        //
        if ($customerSucc && $dealSucc) {

            $this->lastMsgStr = 'Signup count: ' . $customerCount . ', Deal count: ' . $dealCount;
            return true;

        } else {

            if ($customerSucc) {
                $this->lastMsgStr = 'Signup count: ' . $customerCount;
            } else {
                $this->lastMsgStr = 'Signup error';
            }

            if ($dealSucc) {
                $this->lastMsgStr .= ', Deal count: ' . $dealCount;
            } else {
                $this->lastMsgStr .= ', Deal error';
            }
        }

        return false;
    }

    protected function execDayReport($debug=false) {
/*
        $time = date('H:i');

        if ($time != '23:00' && $debug != true) {
            $this->lastMsgStr = 'Invalid time: ' . $time;
            return false;
        }
*/

        $currentTime = time();
        $daySeconds = 60*60*24;

        return $this->execStartTimeDayReport($currentTime-$daySeconds, $debug);
    }

    protected function execStartTimeDayReport($startTime, $debug=false) {

        $currentTime = time();
        if (empty($startTime) || $startTime >= $currentTime) {
            $this->lastMsgStr = 'Invalid start time: ' . (empty($startTime)? '0' : date('Y-m-d H:i:s', $startTime));
            return false;
        }

        $timeStr = date('YmdHis', $currentTime);
        $customerSucc = false;
        $dealSucc = false;

        // Customers
        $customers = User::whereRaw("UNIX_TIMESTAMP(created_at) > " . $startTime)->orderBy('created_at', 'DESC')->get();

        $customerCount = count($customers);
        if ($customerCount > 0) {

            $data  = "\"ID\",\"First Name\",\"Last Name\",\"Email\",\"Phone\",\"Job Title\",\"Company\",";
            $data .= "\"Address\",\"City\",\"Country\",\"State/Province\",\"Postcode\",";
            $data .= "\"Who Referred You\",\"Partner Type\",\"Status\",\"Create Time\",\"Confirm Time\"";
            
            foreach ($customers as $row) {

                // region
                $region = (empty($row->province))? getRegionById($row->country, $row->province_id):$row->province;

                $line  = "\"" . $row->id . "\",\"" . $row->firstname . "\",\"";
                $line .= $row->lastname . "\",\"" . $row->email . "\",\"";
                $line .= $row->phone . "\",\"" . $row->job_title . "\",\"";
                $line .= $row->company . "\",\"" . $row->address . "\",\"";
                $line .= $row->city . "\",\"" . getCountryById($row->country) . "\",\"";
                $line .= $region . "\",\"" . $row->postal_code . "\",\"";
                $line .= $row->referred_person . "\",\"" . getPartnerTypeById($row->partner_type) . "\",\"";
                $line .= getCustomerStatusById($row->is_confirmed) . "\",\"" . $row->created_at . "\",\"";
                $line .= $row->confirm_time . "\"";

                $data .= "\r\n" . $line;
            }

            // Save to file
            $filePath = $this->reportFileLocalPath . '/' . $this->prefixSignupList .'daily_' . $timeStr . '.csv';
            if ($this->saveToFile($filePath, $data)) {

                $data = ['subject' => trans('email.subject.report_signup_daily'),
                         'signupCount' => $customerCount,
                         'startTime' => date('Y-m-d H:i:s', $startTime),
                         'endTime' => date('Y-m-d H:i:s', $currentTime) ];

                $param = ['template' => 'service.emails.report_signup',
                          'data' => $data,
                          'subject' => trans('email.subject.report_signup_daily'),
                          'to' => 'email_group_weekly_reg_report',
                          'attach' => $filePath ];

                $this->sendeReportEmail($param);

                $customerSucc = true;
            }
        } else {

            $data = ['subject' => trans('email.subject.report_signup_daily'),
                     'signupCount' => 0,
                     'startTime' => date('Y-m-d H:i:s', $startTime),
                     'endTime' => date('Y-m-d H:i:s', $currentTime) ];

            $param = ['template' => 'service.emails.report_signup',
                      'data' => $data,
                      'subject' => trans('email.subject.report_signup_daily'),
                      'to' => 'email_group_weekly_reg_report'];

            $this->sendeReportEmail($param);

            $customerSucc = true;
        }

        //
        if ($customerSucc) {
            $this->lastMsgStr = 'Signup count: ' . $customerCount;
            return true;
        } else {
            $this->lastMsgStr = 'Signup error';
        }

        return false;
    }

    // $param : [ 'template' => '',
    //            'data' => '',
    //            'subject' => '',
    //            'to' => '',
    //            'attach' => '' ]
    protected function sendeReportEmail($param) {

        $emailConfig = $this->getConfig('email');
        if ($emailConfig && !empty($emailConfig['sender_email'])) {

            Mail::send($param['template'], $param['data'], function ($message) use($emailConfig, $param) {

                $toArray = explode(',', $emailConfig[$param['to']]);
                foreach ($toArray as $k => $v) {
                    $toArray[$k] = trim($v);
                }

                $message->from($emailConfig['sender_email'], empty($emailConfig['sender_name']) ? trans('email.config.sender_name') : $emailConfig['sender_name']);
                $message->to($toArray)->subject($param['subject']);

                if (isset($param['attach']) && !empty($param['attach']))
                    $message->attach($param['attach']);
            });
        }

    }

    protected function saveToFile($filename, $content) {

        $handle = fopen($filename, "a+");
        if (!$handle) {
            return false;
        }

        if (!fwrite($handle, $content)) {
            return false;
        }

        return true;
    }

    protected function getConfig($type='all') 
    {
        $configs = null;
        if ($type == 'all') {
            $configs = Config::get();
        } else {
            $configs = Config::where('type', '=', $type)->get();
        }

        if ($configs) {

            $configArray = [];

            foreach ($configs as $row) {
                $configArray[$row->name] = $row->value;
            }

            if (!empty($configArray)) {
                return $configArray;
            }
        }

        return null;
    }

}
