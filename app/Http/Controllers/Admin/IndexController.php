<?php

namespace App\Http\Controllers\Admin;

use Validator, Redirect, DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Admin\BaseController as Controller;
use App\Models\Config;

class IndexController extends Controller
{
    public function index()
    {
        return view('admin.index', ['userPermission' => $this->getUserPermission()]);
    }

    public function config(Request $request)
    {
        // $userPermission = $this->getUserPermission();
        // if ($userPermission && $userPermission['config_priv'] != 'Y') {
        //     return Redirect::to($this->redirectPath());
        // }

        // $dataArray = ['userPermission' => $userPermission];
        $dataArray = [];

        if ($request->isMethod('post')) {

            $dataArray['configs'] = [
                'sender_name' => $request->sender_name,
                'sender_email' => $request->sender_email,
                'email_group_registration_notification' => $request->email_group_registration_notification,
                'email_group_mac_id_request_notification' => $request->email_group_mac_id_request_notification,
                // 'email_group_deal_filter' => $request->email_group_deal_filter,
                // 'email_group_weekly_reg_report' => $request->email_group_weekly_reg_report,
                // 'email_group_weekly_deal_report' => $request->email_group_weekly_deal_report,
                // 'email_group_monthly_summary_report' => $request->email_group_monthly_summary_report,
                // 'ten_off_mini_product_count' => $request->ten_off_mini_product_count,
            ];

            try {

                if (isset($request->sender_name)) {
                    Config::where([['type', '=', 'email'], ['name', '=', 'sender_name']])
                        ->update(['value' => $request->sender_name]);
                }
                if (isset($request->sender_email)) {
                    Config::where([['type', '=', 'email'], ['name', '=', 'sender_email']])
                        ->update(['value' => $request->sender_email]);
                }
                if (isset($request->email_group_registration_notification)) {
                    Config::where([['type', '=', 'email'], ['name', '=', 'email_group_registration_notification']])
                        ->update(['value' => $request->email_group_registration_notification]);
                }
                if (isset($request->email_group_mac_id_request_notification)) {
                    Config::where([['type', '=', 'email'], ['name', '=', 'email_group_mac_id_request_notification']])
                        ->update(['value' => $request->email_group_mac_id_request_notification]);
                }

                return view('admin.config', $dataArray)->with('successMsg', trans('common.info.success_save_to_db'));

            } catch (Exception $e) {

                return view('admin.config', $dataArray)->with('errorMsg', trans('common.error.db_save_failed'));
            }  

        } else {
            
            $configObjs = Config::get();

            if ($configObjs) {

                $configs = [];

                foreach ($configObjs as $row) {
                    $configs[$row->name] = $row->value;
                }

                if (!empty($configs)) {
                    $dataArray['configs'] = $configs;
                }
            }

        }

        return view('admin.config', $dataArray);
    }  

    public function testPdf() {
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML('<h1>Test</h1>');
        return $pdf->stream();
    }

    public function import()
    {
        
/*
        $userId = '1';
        $accountId = '3';
        $srcPath = '/Users/tkuang/temp/20171031/account3'; 
        
        $transArray = [];

        //
        $strOut  = 'Uploading files ... <br><br>'; 

        $transaction = Stock_transaction::where(['user_id' => $userId, 
                                                'account_id' => $accountId,
                                                'snap_file' => ''])->get();
        if (count($transaction) > 0) {

            $uploadPath = getUploadLocalPath();

            $fileCount = 0;
            foreach ($transaction as $row) {

                $srcFile = $srcPath . '/' . $row->e_date;
                $filename = $row->e_date;

                if (file_exists($srcFile . '.jpg')) {
                    $srcFile .= '.jpg'; 
                    $filename .= '.jpg';  
                } else {
                    if (file_exists($srcFile . '.JPG')) {
                        $srcFile .= '.JPG';
                        $filename .= '.JPG';   
                    } else {
                        $srcFile = '';
                        $filename = '';
                    }
                }

                if (!empty($srcFile)) {
                    $strOut  .= 'Upload: ' . $srcFile . ' <br><br>';

                    $newFilename = $userId . '_' . $accountId . '_' . md5($row->e_date) . '_' . $filename; 
                    $destFile = $uploadPath['base_dir'] . '/' . $uploadPath['short_dir'] . '/' . $newFilename;

                    if (copy($srcFile, $destFile)) {
                        $strOut  .= 'SrcFile: ' . $srcFile . ' <br>';
                        $strOut  .= 'destFile: ' . $destFile . ' <br><br>';

                        $row->snap_file = $uploadPath['short_dir'] . '/' . $newFilename;
                        $row->save();

                        $fileCount ++;
                    }
                }
            }

            $strOut  .= 'Uploaded ' . $fileCount . ' files <br><br>';

        } else {

            $strOut  .= 'No transaction <br><br>';   
        }

        $strOut  .= 'Upload file finish <br><br>'; 

        return $strOut;
*/

/*
        $userId = '1';
        $accountId = '4';
        $transArray = [];

        //
        $strOut  = 'Importing tbl_fund ... <br><br>'; 

        $collectin = DB::connection('sqlite')->select("SELECT * FROM tbl_fund");
        foreach ($collectin as $row) {

            $transDate = substr($row->e_date, 0, 4) . '-' . substr($row->e_date, 4, 2) . '-' . substr($row->e_date, 6, 2);

            $trans = Stock_transaction::where(['user_id' => $userId, 
                                               'account_id' => $accountId,
                                               'e_date' => $transDate])
                                        ->get();
            if (count($trans) <= 0) {

                $transaction = new Stock_transaction;            
                $transaction->user_id = $userId;
                $transaction->account_id = $accountId;
                $transaction->e_date = $transDate;
                $transaction->trans_type = getTransactionTypeIdByName(mb_convert_encoding($row->o_type, 'UTF8', 'GBK'));
                $transaction->amount = $row->amount;
                $transaction->stock_value = $row->stock_value;
                $transaction->account_value = $row->account_value;
                $transaction->original_value = $row->orginal_value;
                $transaction->comments = mb_convert_encoding($row->comments, 'UTF8', 'GBK');
                $transaction->save();

                array_push($transArray, array('trans_id' => $transaction->id,
                                              'e_date' => $transDate));
            }
        }

        //
        if (count($transArray) > 0) {
            
            $strOut  .= 'Importing tbl_fundstock ... <br><br>'; 

            $collectin = DB::connection('sqlite')->select("SELECT * FROM tbl_fundstock");
            foreach ($collectin as $row) {

                $transDate = substr($row->e_date, 0, 4) . '-' . substr($row->e_date, 4, 2) . '-' . substr($row->e_date, 6, 2);

                $transId = -1;
                foreach ($transArray as $row2) {
                    if ($row2['e_date'] == $transDate) {
                        $transId = $row2['trans_id'];
                        break;
                    }
                }

                if ($transId != -1) {

                    $holding = Stock_transholding::where(['user_id' => $userId, 
                                                       'account_id' => $accountId,
                                                       'trans_id' => $transId,
                                                       'stock_code' => $row->stock_code])
                                                ->get();
                    if (count($holding) <= 0) {

                        //
                        $stock = Stock_list::where(['stock_code' => $row->stock_code])
                                                    ->first();

                        if (!empty($stock)) {

                            $transholding = new Stock_transholding;            
                            $transholding->user_id = $userId;
                            $transholding->account_id = $accountId;
                            $transholding->trans_id = $transId;
                            $transholding->stock_code = $stock->stock_code;
                            $transholding->stock_name = $stock->stock_name;
                            $transholding->count = $row->count;
                            $transholding->in_price = $row->in_price ;
                            $transholding->cur_price = $row->cur_price;

                            $inDate = substr($row->in_date, 0, 4) . '-' . substr($row->in_date, 4, 2) . '-' . substr($row->in_date, 6, 2);
                            $transholding->in_date = $inDate;
                            $transholding->comments = mb_convert_encoding($row->comments, 'UTF8', 'GBK');
                            $transholding->save();

                        }
                    }
                }
            }

        } else {

            $strOut  .= 'No transaction <br><br>';   
        }

        $strOut  .= 'Import task finish <br><br>'; 

        return $strOut;
*/    
    }

}
