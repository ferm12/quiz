<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('clearFilesFromDir')) {
    function clearFilesFromDir($path)
    {
        if (is_dir($path)) {
        
            $arr = scandir($path);
            foreach ($arr as $v) {
   
	            if ($v != "." && $v != "..") {

	                if (!is_dir($path . $v)) {
	                    unlink($path . '/' . $v);
	                }
	            }
	        }
        }
    }
}

// 
if (!function_exists('getCurrentUser')) {
 	function getCurrentUser($guard)
 	{
 		return Auth::guard($guard)->user();
 	}
}

// 
if (!function_exists('getUploadLocalPath')) {
 	function getUploadLocalPath()
 	{
 		$basePath = config('filesystems.disks.local.uploads');
 		if (!empty($basePath)) {

 			$path = $basePath . '/' . date('Y');
 			if (!file_exists($path))
 				mkdir($path);

 			$path .= '/' . date('m');
 			if (!file_exists($path))
 				mkdir($path);

 			return array('base_dir' => $basePath,
 						 'short_dir' => date('Y') . '/' . date('m'));
 		}

  		return null;
 	}
}

// 
if (!function_exists('getUploadPublicURI')) {
 	function getUploadPublicURI()
 	{
 		return config('filesystems.disks.public.uploads');
 	}

}

//
if (!function_exists('generatePassword')) {
	function generatePassword($length)   
	{   
	   	$pattern = '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLOMNOPQRSTUVWXYZ';  
	   	$key = '';
	   	
	    for ($i = 0; $i < $length; $i ++) {   
	        $key .= $pattern[mt_rand(0, 61)];
	    }   
	    return $key;   
	}   
}

// id: '1', '2', '3', ... 
if (!function_exists('getCustomerStatusById')) {
 	function getCustomerStatusById($id)
 	{
 		if ($id) {
 			$arr = trans('customer.status');
 			if ($arr) {
 				foreach ($arr as $k => $v) {
 					if ($k == $id)
 						return $v;
 				}
 			}
 		}

  		return '';
 	}
}

// id: '1', '2', '3', ... 
if (!function_exists('getDealStatusById')) {
 	function getDealStatusById($id)
 	{
 		if ($id) {
 			$arr = trans('deal.status');
 			if ($arr) {
 				foreach ($arr as $k => $v) {
 					if ($k == $id)
 						return $v;
 				}
 			}
 		}

  		return '';
 	}
}

// id: '1', '2', '3', ... 
if (!function_exists('getAdminStatusById')) {
 	function getAdminStatusById($id)
 	{
 		if ($id) {
 			$arr = trans('admin.status');
 			if ($arr) {
 				foreach ($arr as $k => $v) {
 					if ($k == $id)
 						return $v;
 				}
 			}
 		}

  		return '';
 	}
}

// id: '1', '2', '3', ... 
if (!function_exists('getDealRejectionReasonById')) {
 	function getDealRejectionReasonById($id)
 	{
 		if ($id) {
 			$arr = trans('deal.rejections');
 			if ($arr) {
 				foreach ($arr as $k => $v) {
 					if ($k == $id)
 						return $v;
 				}
 			}
 		}

  		return '';
 	}
}

// id: '1', '2', '3', ... 
if (!function_exists('getDistributorById')) {
 	function getDistributorById($id)
 	{
 		if ($id) {
 			$arr = trans('common.distributors');
 			if ($arr) {
 				foreach ($arr as $k => $v) {
 					if ($k == $id)
 						return $v;
 				}
 			}
 		}

  		return '';
 	}
}

// id: '1', '2', '3', ... 
if (!function_exists('getPartnerTypeById')) {
 	function getPartnerTypeById($id)
 	{
 		if ($id) {
 			$arr = trans('common.partners');
 			if ($arr) {
 				foreach ($arr as $k => $v) {
 					if ($k == $id)
 						return $v;
 				}
 			}
 		}

  		return '';
 	}
}

// id: '1', '2', '3', ... 
if (!function_exists('getAccountManagerById')) {
 	function getAccountManagerById($id)
 	{
 		if ($id) {
 			$arr = trans('common.managers');
 			if ($arr) {
 				foreach ($arr as $k => $v) {
 					if ($k == $id)
 						return $v;
 				}
 			}
 		}

  		return '';
 	}
}

// id: '1', '2', '3', ... 
if (!function_exists('getCountryById')) {
 	function getCountryById($id)
 	{
 		if ($id) {
 			$arr = trans('common.countries');
 			if ($arr) {
 				foreach ($arr as $k => $v) {
 					if ($k == $id)
 						return $v;
 				}
 			}
 		}

  		return '';
 	}
}

// id: '1', '2', '3', ... 
if (!function_exists('getRegionById')) {
 	function getRegionById($country_id, $id)
 	{
 		if ($id) {
 			$arr = trans('common.provinces');
 			if ($arr) {
 				foreach ($arr as $k => $v) {
 					if ($k == $country_id) {
 						
 						// 
 						if ($v) {
 							foreach($v as $k2 => $v2) {

 								if ($k2 == $id)
 									return $v2;
 							}
 						}

 					}
 				}
 			}
 		}

  		return '';
 	}
}

// id: '1', '2', '3', ... 
if (!function_exists('getRegionIdByName')) {
 	function getRegionIdByName($name)
 	{
 		if ($name) {
 			$arr = trans('common.provinces');
 			if ($arr) {
 				foreach ($arr as $k => $v) {

					foreach($v as $k2 => $v2) {

						if (strtoupper($v2) == strtoupper($name))
							return $k2;
					}
 				}
 			}
 		}

  		return '';
 	}
}




