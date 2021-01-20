<body style='background:#F6F6F6; font-family: Arial, Helvetica, Verdana, Sans-serif; font-size:12px; margin:0; padding:0;'>
<div style='background:#F6F6F6; font-family: Arial, Helvetica, Verdana, Sans-serif; font-size:12px; margin:0; padding:0;'>
<table cellspacing='0' cellpadding='0' border='0' height='100%' width='100%'>
<tr>
    <td align='center' valign='top' style='padding:10px'>

        <table bgcolor='FFFFFF' cellspacing='0' cellpadding='20' border='0' width='100%' style='text-align:left;'>
        <tr>
        	<td valign='top'>

                <p>&nbsp;</p>
                <p>Hi {{ isset($username) ? $username : '' }}, </p>

                <p>&nbsp;</p>
                <p>Your Mac ID has been updated.</p>

                <p style='font-weight: bold;'>MAD ID SUMMARY</p>

                <table border='0' cellspacing='10' cellpadding='0' style='width: 100%; margin-left: 15px;'>
                <tr>
                	<td width='120px;'>SN: </td>
                	<td>{{ isset($mac_id['sn']) ? $mac_id['sn'] : '' }}</td>
                </tr>
                <tr>
                	<td width='120px;'>Mac ID:</td>
        	        <td>
        	        	{{ isset($mac_id['mac_id']) ? $mac_id['mac_id'] : '' }}
        	        </td>
                </tr>
                <tr>
        	        <td width='120px;'>Purchased From: </td>
        	        <td>
        	        	{{ isset($mac_id['purchased_from']) ? $mac_id['purchased_from']: '' }}
        	        </td>
                </tr>
                <tr>
                	<td width='120px;'>Taken: </td>
                    <td>
                        {{ isset($mac_id['taken']) ? $mac_id['taken'] : '' }}
                    </td>
                </tr>  
                <tr>
                	<td width='120px;'>License number:</td>
                	<td>
                		{{ isset($mac_id['license_number']) ? $mac_id['license_number'] : '' }}
                	</td>
                </tr>                        
                <tr>
                	<td width='120px;'>Activation key:</td>
                	<td>
                		{{ isset($mac_id['activation_key']) ? $mac_id['activation_key'] : '' }}
                	</td>
                </tr>     
                </table>    
                
                <p>&nbsp;</p>
                <p>If you have any question, please send an email to <a href='mailto:'></a></p>

                <p>&nbsp;</p>
                <p>Sincerely,<br>Screenbeam Team
                <br><br>Note: This is an automatically generated email, please do not reply.</p> 

        	</td>
        </tr>             
        </table>

    </td>
</tr>
</table>
</div>
</body>
