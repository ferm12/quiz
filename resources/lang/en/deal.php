<?php

return [

    // Title & labels
    'label_create_deal' => 'Create a Deal Registration',
    'label_my_deals' => 'My Registered Deals', 
    'label_view_deal' => 'View a Deal Registration', 
    'label_deal_number' => 'Deal Reg Number',

    'label_reseller_info' => 'Reseller Information',
    'label_distributor_info' => 'Distributor Information',
    'label_enduser_info' => 'End User Information',

    'label_sales_contact' => 'Sales Contact Name',
    'label_opportunity_name' => 'Name of the Opportunity (i.e: Acme-phase1-SB-Pro)',
    'label_opportunity_shortname' => 'Opportunity Name',
    'label_opportunity_status' => 'Opportunity Status',
    'label_opportunity_rejection' => 'Rejection Reason',
    'label_opportunity_date' => 'Estimated Close Date',
    'label_opportunity_submit_date' => 'Date of Submission',
    'label_product_quantity' => 'Product - Quantity',
    'label_product' => 'Product',
    'label_product_summary' => 'Product Summary',
    'label_quantity' => 'Quantity',
    'label_aei_account_manager' => 'Actiontec Account Manager',   
    'label_account_manager' => 'Account Manager',
    'label_account_manager_irregular' => 'Irregular data',
    'label_preferred_distributor' => 'Preferred Distributor',
    'label_distributor' => 'Distributor',
    'label_sales_contact_distributor' => 'Distributor Sales Contact',
    'label_contact_name' => 'Contact Name',
    'label_select_product' => 'Select Product',
    'label_company_enduser' => 'Company (End User)',
    'label_end_customer' => 'End Customer Name',

    // Button & links
    'btn_create_deal' => 'Create a Deal Registration',
    'btn_my_deals' => 'My Registered Deals',
    'btn_deal_registration' => 'Deal Registration',
    'btn_select_product' => 'Select Product',

    // String & messages
    'str_opportunity_name' => 'Name of the Opportunity',
    'str_argeement' => "<p>Actiontec offers deal registration to support their ScreenBeam partners. Deal Registration is granted on a first-come, first serve basis only valid for the opportunity registered.</p>
                        <p>Partner is responsible to ensure that the end user will buy through them. Actiontec cannot influence end user’s decisions. Actiontec reserves the right to cancel an approved registration deal. It is the responsibility of the partner to manage the deal registration and update it when necessary.</p>
                        <p><b>Benefits include:</b><br />Additional discount (based on the MSRP) for <span style='color: red'>North America ONLY</span>.</p> 
                        <ul style='list-style: disc;'>
                            <li>Extra 10% <sup><strong>*</strong></sup> margin on all ScreenBeam deal quantities upon acceptance. (<span style='color: red'>ScreenBeam commercial SKUs only</span>)</li>
                        </ul>
                        <p style='margin-left: 25px; color: gray; font-style: italic;'><strong>*Required</strong>: buddy call with your Actiontec account manager, and your end customer to qualify opportunity</p>
                        <p>Increased chance to win the sale.<br />Assistance from your account manager to help you close the deal.<br />Early pre-sales and engineering support to help win the business.</p>
                        <p><b>Program Highlights:</b><br />Offered to Partners in the United States who are registered within the online partner portal with current and accurate information.<br />Deal Registration is awarded on a first-come, first serve basis.<br />Once the information is submitted, the Director of Channel reviews the request and responds within TWO business days.<br />The registration will remain valid for 120 days.</p>
                        <p><b>Rules of Engagement:</b><br />Only one registration per opportunity will be accepted.<br />Opportunities cannot be combined.<br />Registered opportunities will typically be accepted or rejected within TWO business days.<br />Buddy calls are required for deals of 50 or more units. <br />Once an opportunity is registered and approved, your Actiontec account manager will reach out to you to support you through the entire sales cycle. If you don’t have an account manager, we’ll provide one for you.</p>
                        <p><b>Type of possible Rejections:</b><br />Opportunity already exists in Actiontec database.</p>",
    
    'str_deal_confirmation_title' => 'Deal successfully submitted',
    'str_deal_confirmation_summary' => 'Deal Registration Summary',
    'str_deal_confirmation_description' => "<p>Dear %1,<br><br>The deal you submitted was successfully saved in the partner portal under My Registered Deals. <br><br> 
                                            The Actiontec sales team will review it and come back to you. Registered opportunities will typically be accepted or declined within two business days. Don’t forget, the registration will remain valid for 120 days (and may be renewed).</p>",
    'str_deal_confirmation_emailto' => "<p>If you have any question about deal registration, please send an email to <a href='mailto:Deal-reg-USA@actiontec.com'><font style='color: #41ade2; text-decoration: underline;'>Deal-reg-USA@actiontec.com</font></a></p>",

    // Dictionary
    'status' => [
        '1' => 'Pending',
        '2' => 'Approved',
        '3' => 'Declined',
        '4' => 'Qualifying Call Needed',
        '5' => 'Account Mgr. Reaching out to ISS',
        '6' => 'Missing Qualification Call',
        '7' => 'CAM Working with Reseller',
    ],

    'products' => [
        '' => 'Please Choose',
        '1' => '# SBWD1100 ScreenBeam 1100 Wireless Display Receiver with CMS',
        '2' => '# SBWD960A ScreenBeam 960 Wireless Display Receiver with CMS',
        '3' => '# SBWD750W ScreenBeam 750 Wireless Display Receiver with CMS (Wireless)',
        '4' => '# SBWD750E ScreenBeam 750 Wireless Display Receiver with CMS (Ethernet)',
        '5' => '# SBCC01L ScreenBeam Classroom Commander',
        '6' => '# SBWD1000EDU ScreenBeam 1000 Wireless Display Receiver - For Education Only',
     
        //'11' => '# SBWD200TX02 ScreenBeam USB Transmitter 2',
        //'12' => '# SBWD100E2V ScreenBeam Education Edition 2',
        //'13' => '# SBTC90KIT ScreenBeam Touch 90 - Whiteboard',
        //'14' => '# SBCMS CMS Perpetual License for Enterprise 950/950P #SBWD950 Legacy',
        //'15' => '# SBCMSE CMS Perpetual License for Education Ed 2/SMB/Business Ed (Wireless)',
        //'16' => '# SBCMSW CMS Perpetual License for Education Ed 2/SMB/Business Ed (Ethernet)',
        //'17' => '# SBCC01R ScreenBeam Classroom Commander - 1 year renewal license (eligible for 5% only if approved)',

    ],

    'rejections' => [
        '1' => 'Deal is already in the Actiontec system',
        '2' => 'Your account manager will be reaching out regarding questions on your submission',
 
    ],

];
