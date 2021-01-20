<?php
 
    $create_customer = [
        [
            'key' => 'is_vendor',
            'val' => 'zapier',
        ],
        [
            'key' => 'is_user',
            'val' => 'sb#!@$%^*()qlm',
        ],
        [
            'key' => 'is_pwd',
            'val' => 'ScreenBeam@95054',
        ]
    ]; 

    $create_customer_url = "https://quicklicensemanager.com/actiontec/QlmLicenseServer/qlmservice.asmx/UpdateUserInformation";

    function buildQueryStr($url, $key, $val)
    {
        $url .= "&" . $key . "=" . $val;
        return $url;
    
    }

    foreach ($create_customer as $c){

        $create_customer_url = buildQueryStr($create_customer_url, $c['key'], $c['val']);

    }


    $create_customer_url = preg_replace("/^([^?&]+)&/", "$1?", $create_customer_url  );

    echo $create_customer_url;

    // $url = "https://quicklicensemanager.com/actiontec/QlmLicenseServer/qlmservice.asmx/UpdateUserInformation";
    // $key = "email";
    // $val = "fermin@gmail.com";
    // 
    // echo $url .= "&" . $key . "=" . $val;
