<body style='background:#F6F6F6; font-family: Arial, Helvetica, Verdana, Sans-serif; font-size:12px; margin:0; padding:0;'>
<div style='background:#F6F6F6; font-family: Arial, Helvetica, Verdana, Sans-serif; font-size:12px; margin:0; padding:0;'>
<table cellspacing='0' cellpadding='0' border='0' height='100%' width='100%'>
<tr>
    <td align='center' valign='top' style='padding:10px'>

        <table bgcolor='FFFFFF' cellspacing='0' cellpadding='20' border='0' width='100%' style='text-align:left;'>
        <tr>
        	<td valign='top'>

                <p>&nbsp;</p>
                <h1 style='font-size:18px; font-weight:normal; line-height:22px; margin:0 0 11px 0;'>
                    {{ isset($username) ? $username : '' }} added a new deal to ScreenBeam Partner Portal:
                </h1>

                <p>&nbsp;</p>
                <p style='font-weight: bold;'>DEAL REGISTRATION SUMMARY</p>
                
                <table border='0' cellspacing='10' cellpadding='0' style='width: 100%; margin-left: 15px;'>
                <tr>
                    <td width='160px;'>Opportunity Name: </td>
                    <td>{{ isset($deal['opportunity_name']) ? $deal['opportunity_name'] : '' }}</td>
                </tr>
                <tr>
                    <td>Date of Submission: </td>
                    <td>
                        {{ isset($deal['opportunity_submit_date']) ? $deal['opportunity_submit_date'] : '' }}
                    </td>
                </tr>
                <tr>
                    <td valign='top'>Product Summary: </td>
                    <td>
                        {!! isset($deal['opportunity_product']) ? str_replace(',', '<br>', $deal['opportunity_product']) : '' !!}
                    </td>
                </tr>
                <tr>
                    <td>Estimated Close Date: </td>
                    <td>
                        {{ isset($deal['opportunity_date']) ? $deal['opportunity_date'] : '' }}
                    </td>
                </tr>  
                <tr>
                    <td>Actiontec Account Manager:</td>
                    <td>
                        {{ isset($deal['opportunity_account_manager']) ? $deal['opportunity_account_manager'] : '' }}
                    </td>
                </tr>                        
                </table>    
                
                <p style='font-weight: bold;'>Reseller Information</p>
                <table border='0' cellspacing='10' cellpadding='0' style='width: 100%; margin-left: 15px;'>
                <tr>
                    <td width='160px;'>Company Name: </td>
                    <td>
                        {{ isset($deal['reseller_company']) ? $deal['reseller_company'] : '' }}
                    </td>
                </tr>
                <tr>
                    <td>Sales Contact Name: </td>
                    <td>
                        {{ isset($deal['reseller_contact']) ? $deal['reseller_contact'] : '' }}
                    </td>
                </tr>            
                <tr>        
                    <td>Phone Number: </td>
                    <td>
                        {{ isset($deal['reseller_phone']) ? $deal['reseller_phone'] : '' }}
                    </td>
                </tr>
                <tr>        
                    <td>Email: </td>
                    <td>
                        {{ isset($deal['reseller_email']) ? $deal['reseller_email'] : '' }}
                    </td>
                </tr>              
                </table> 

                <p style='font-weight: bold;'>Distributor Information</p>
                <table border='0' cellspacing='10' cellpadding='0' style='width: 100%; margin-left: 15px;'>
                <tr>
                    <td width='160px;'>Preferred Distributor:</td>
                    <td>
                        {{ isset($deal['distributor_preferred']) ? $deal['distributor_preferred'] : '' }}
                    </td>
                </tr>
                <tr>        
                    <td>Distributor Sales Contact: </td>
                    <td>
                        {{ (isset($deal['distributor_contact_firstname']) ? $deal['distributor_contact_firstname'] : '') . ' ' . (isset($deal['distributor_contact_lastname']) ? $deal['distributor_contact_lastname'] : '') }}
                    </td>
                </tr> 
                <tr>
                    <td>Phone Number: </td>
                    <td>
                        {{ isset($deal['distributor_phone']) ? $deal['distributor_phone'] : '' }}
                    </td>
                </tr>        
                <tr>
                    <td>Email: </td>
                    <td>
                        {{ isset($deal['distributor_email']) ? $deal['distributor_email'] : '' }}
                    </td>
                </tr>  
                </table>

                <p style='font-weight: bold;'>End User Information</p>
                <table border='0' cellspacing='10' cellpadding='0' style='width: 100%; margin-left: 15px;'>
                <tr>
                    <td width='160px;'>Company Name: </td>
                    <td>
                        {{ isset($deal['customer_company']) ? $deal['customer_company'] : '' }}
                    </td>
                    <td width='160px;'>Sales Contact Name: </td>
                    <td>
                        {{ isset($deal['customer_contact']) ? $deal['customer_contact'] : '' }}
                    </td>
                </tr> 
                <tr>
                    <td>Address: </td>
                    <td>
                        {{ isset($deal['customer_address']) ? $deal['customer_address'] : '' }}
                    </td>
                    <td>Phone Number: </td>
                    <td>
                        {{ isset($deal['customer_phone']) ? $deal['customer_phone'] : '' }}
                    </td>         
                </tr> 
                <tr>
                    <td>City: </td>
                    <td>
                        {{ isset($deal['customer_city']) ? $deal['customer_city'] : '' }}
                    </td>
                    <td>Email: </td>
                    <td>
                        {{ isset($deal['customer_email']) ? $deal['customer_email'] : '' }}
                    </td>           
                    </tr> 
                <tr>
                    <td>State/Province: </td>
                    <td>
                        {{ isset($deal['customer_province']) ? $deal['customer_province'] : '' }}
                    </td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>            
                </tr> 
                <tr>
                    <td>Zip/Postal Code: </td>
                    <td>
                        {{ isset($deal['customer_postal_code']) ? $deal['customer_postal_code'] : '' }}
                    </td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>           
                </tr> 
                <tr>
                    <td>Country: </td>
                    <td>
                        {{ isset($deal['customer_country']) ? $deal['customer_country'] : '' }}
                    </td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>            
                </tr>             
                </table> 

                <p>&nbsp;</p>
                <p>Note: This is an automatically generated email, please do not reply.</p>              

            </td>
        </tr>             
        </table>

    </td>
</tr>
</table>
</div>
</body>