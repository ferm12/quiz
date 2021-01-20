<?php

return [

    // Title & labels
    'title_app' => 'Partner Portal',
    'title_app_admin' => 'Partner Portal Admin',
    'title_screenbeam' => 'ScreenBeam by Actiontec',

    'label_home' => 'Home',
    'label_dashboard' => 'Dashboard',
    'label_contact_us' => 'Contact us',
    'label_tech_support' => 'Technical Support',
    'label_operation' => 'Operation',
    'label_comments' => 'Comments',
    'label_create_time' => 'Create Time',
    'label_confirm_time' => 'Confirm Time',
    'label_expired_time' => 'Expired Time',
    'label_status' => 'Status',
    'label_accept' => 'Accept',
    'label_account_info' => 'Account Information',
    'label_contact_info' => 'Contact Information',
    'label_welcome' => 'Welcome, %1',
    'label_click_show' => 'Click Show',
    'label_all' => 'All',

    // Button & links
    'btn_back' => 'Back',
    'btn_ok' => 'OK',
    'btn_cancel' => 'Cancel',
    'btn_apply' => 'Apply',
    'btn_accept' => 'Accept',
    'btn_view' => 'View',
    'btn_modify' => 'Modify',
    'btn_delete' => 'Delete',
    'btn_duplicate' => 'Duplicate',
    'btn_save' => 'Save',
    'btn_save_continue' => 'Save & Continue',
    'btn_close' => 'Close',
    'btn_submit' => 'Submit',
    'btn_default' => 'Default',
    'btn_reset' => 'Reset',
    'btn_select' => 'Select',
    'btn_search' => 'Search', 
    'btn_change' => 'Change',
    'btn_clear' => 'Clear',
    'btn_export_to_csv' => 'Export to CSV',

    'btn_my_account' => 'My Account',
    'btn_my_contact' => 'My Contact',
    'btn_training' => 'Training',
    'btn_sales_toolbox' => 'Sales Toolbox',
    'btn_technical_resources' => 'Technical Resources',

    // String & messages
    'str_read_only' => 'Read Only',
    'str_no_record' => 'No record',
    'str_no_match' => 'No data match',
    'str_no_authorization' => 'No authorization',
    'str_no_return_url' => 'No return url',
    'str_searching' => 'Searching ...',
    'str_loading' => 'Loading ...',  
    'str_paginate_title' => 'Page %1 of %2 pages | Total %3 records',
    'str_copyright' => 'All Rights Reserved.',

    'info' => [

        'notice_select_option' => 'Please select %1',
        'notice_enter_input' => 'Please enter %1',
        'notice_consist_of_digit' => '%1 is consist of digits',
        'notice_big_than_zero' => '%1 must > 0',

        'notice_password_reset_check_email' => 'If there is an account associated with \'%1\' you will receive an email with a link to reset your password.',
        'notice_password_reset_login_again' => 'Password reset successfully, please enter your new password to login again.',

        'confirm_delete_item' => 'Are you sure you want to delete this item?',
        'confirm_delete_item_by_id' => 'Are you sure you want to delete this item ( ID: %1 )?',

        'success_save_to_db' => 'Save to database successfully',

        'success_create_customer' => 'Create customer successfully',
        'success_modify_customer' => 'Modify customer ( ID: %1 ) successfully',
        'success_delete_customer' => 'Delete customer ( ID: %1 ) successfully',
        'success_password_change' => 'Change password successfully',

        'success_modify_account' => 'Modify account information successfully',
        'success_modify_contact' => 'Modify contact information successfully',

        'success_modify_deal' => 'Modify deal registration ( ID: %1 ) successfully',
        'success_delete_deal' => 'Delete deal registration ( ID: %1 ) successfully',

        'success_create_user' => 'Create user successfully',
        'success_delete_user' => 'Delete user ( ID: %1 ) successfully',
        'success_modify_user' => 'Modify user ( ID: %1 ) successfully',

        'success_create_admin_rule' => 'Create admin rule successfully',
        'success_delete_admin_rule' => 'Delete admin rule ( ID: %1 ) successfully',
        'success_modify_admin_rule' => 'Modify admin rule ( ID: %1 ) successfully',        
    ],

    'error' => [

        'already_exists' => '%1 ( \'%2\' ) already exists',
        'account_not_confirmed' => 'This account is not confirmed. We are reviewing your application to become an Actiontec Partner.',
        'account_inactive' => 'This account is inactive. Please contact your web administrator to active this account.',
        'password_reset_link_invalid_or_expired' => 'This password reset link is invalid or has expired.',
        'unable_to_delete_customer_contain_deal' => 'Unable to delete the customer ( ID: %1 ) which contains deal registration.',
        'unable_to_delete_default_admin_user' => 'Unable to delete the user ( ID: %1 ) which is the default administrator.',
        'unable_to_delete_default_admin_rule' => 'Unable to delete the rule ( ID: %1 ) which is the default admin rule.',
        'unable_to_delete_rule_which_in_use' => 'Unable to delete the rule ( ID: %1 ) which some admin user using.',

        'invalid_id' => 'Invalid ID',
        'invalid_email' => 'Invalid email',
        'invalid_parameter' => 'Invalid parameter',
        'invalid_password' => 'Invalid password',
        'invalid_captcha' => 'Invalid captcha',
        'invalid_account_or_password' => 'Invalid account or password',
        'invalid_email_or_not_confirmed' => 'Invalid email or account not confirmed',
        
        'failed_register' => 'Failed to register',

        'db_read_failed' => 'Failed to read from database',
        'db_save_failed' => 'Failed to save to database',
        'db_operation_error' => 'Database operation error',

        '404' => 'Page Not Found - 404',
        '503' => 'Server Error - 503',
    ],

    // Dictionary
    'distributors' => [
        '8' => 'AMT',
        '9' => 'Anixter International',
        '1' => 'ASI',
        //'7' => 'Douglas Stewart',
        '2' => 'D&H',
        '3' => 'Ingram Micro',
        '5' => 'Synnex',
        //'6' => 'Tech Data',
        '99' => 'Other',
    ],

    'partners' => [
        '1' => 'Distributor',
        '2' => 'Reseller',
        '3' => 'Retailer',
    ],

    'managers' => [
        'Daryn Rank' => 'Daryn Rank',
        'Jason Eisenberg' => 'Jason Eisenberg',
        'Jeffery Calnan' => 'Jeffery Calnan',
        'John Zindle' => 'John Zindle',
        'Laura Nelson' => 'Laura Nelson',
        'Ron Dominguez' => 'Ron Dominguez',
        'Not sure' => 'Not sure',
    ],

    'countries' => [
        'CA' => 'Canada',
        'US' => 'United States',
    ],

    'provinces' => [
        'CA' => ['AB' => 'Alberta',
                 'BC' => 'British Columbia',
                 'MB' => 'Manitoba',
                 'NB' => 'New Brunswick',
                 'NL' => 'Newfoundland and Labrador',
                 'NS' => 'Nova Scotia',
                 'NT' => 'Northwest Territories',
                 'NU' => 'Nunavut',
                 'ON' => 'Ontario',
                 'PE' => 'Prince Edward Island',
                 'QC' => 'Quebec',
                 'SK' => 'Saskatchewan',
                 'YT' => 'Yukon Territory'],
        'US' => ['AK' => 'Alaska',
                 'AL' => 'Alabama',
                 'AR' => 'Arkansas',
                 'AS' => 'American Samoa',
                 'AZ' => 'Arizona',
                 'CA' => 'California',
                 'CO' => 'Colorado',
                 'CT' => 'Connecticut',
                 'DC' => 'District of Columbia',                 
                 'DE' => 'Delaware',
                 'FL' => 'Florida',
                 'FM' => 'Federated States Of Micronesia',
                 'GA' => 'Georgia',
                 'GU' => 'Guam',
                 'HI' => 'Hawaii',
                 'IA' => 'Iowa',
                 'ID' => 'Idaho',
                 'IL' => 'Illinois',
                 'IN' => 'Indiana',
                 'KS' => 'Kansas',
                 'KY' => 'Kentucky',
                 'LA' => 'Louisiana',
                 'MA' => 'Massachusetts',
                 'MD' => 'Maryland',
                 'ME' => 'Maine',
                 'MH' => 'Marshall Islands',
                 'MI' => 'Michigan',
                 'MN' => 'Minnesota',
                 'MO' => 'Missouri',
                 'MP' => 'Northern Mariana Islands',
                 'MS' => 'Mississippi',
                 'MT' => 'Montana',
                 'NC' => 'North Carolina',
                 'ND' => 'North Dakota',
                 'NE' => 'Nebraska',
                 'NH' => 'New Hampshire',
                 'NJ' => 'New Jersey',
                 'NM' => 'New Mexico',
                 'NV' => 'Nevada',
                 'NY' => 'New York',
                 'OH' => 'Ohio',
                 'OK' => 'Oklahoma',
                 'OR' => 'Oregon',
                 'PA' => 'Pennsylvania',
                 'PR' => 'Puerto Rico',
                 'PW' => 'Palau',
                 'RI' => 'Rhode Island',
                 'SC' => 'South Carolina',
                 'SD' => 'South Dakota',
                 'TN' => 'Tennessee',
                 'TX' => 'Texas',
                 'UT' => 'Utah',
                 'VA' => 'Virginia',
                 'VI' => 'Virgin Islands',
                 'VT' => 'Vermont',
                 'WA' => 'Washington',
                 'WI' => 'Wisconsin',
                 'WV' => 'West Virginia',
                 'WY' => 'Wyoming'],
    ],
];
