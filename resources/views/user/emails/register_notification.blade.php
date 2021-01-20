<body style='background:#F6F6F6; font-family: Arial, Helvetica, Verdana, Sans-serif; font-size:12px; margin:0; padding:0;'>
<div style='background:#F6F6F6; font-family: Arial, Helvetica, Verdana, Sans-serif; font-size:12px; margin:0; padding:0;'>
<table cellspacing='0' cellpadding='0' border='0' height='100%' width='100%'>
<tr>
	<td align='center' valign='top' style='padding:10px'>
		<table bgcolor='FFFFFF' cellspacing='0' cellpadding='20' border='0' width='100%' style='text-align:left;'>
			<tr>
				<td valign='top'>

			        <h1 style='font-size:18px; font-weight:normal; line-height:22px; margin:0 0 11px 0;'>
			        A new License request was just submitted:
			        </h1>

			        <p>&nbsp;</p>
			        <p><font style='font-size:14px; font-weight: bold;'>PRIMARY CONTACT</font>
			        <br><br><strong>First Name:</strong> {{ isset($first_name) ? $first_name : '' }}
			        <br><br><strong>Last Name:</strong> {{ isset($last_name) ? $last_name : '' }}
			        <br><br><strong>Email:</strong> {{ isset($email) ? $email : '' }}
			        <br><br><strong>Phone:</strong> {{ isset($phone) ? $phone : '' }}</p>

			        <p>&nbsp;</p>
			        <p><font style='font-size:14px; font-weight: bold;'>ORGANIZATION</font>
			        <br><br><strong>Organization Name:</strong> {{ isset($organization_name) ? $organization_name : '' }}
			        <br><br><strong>Address:</strong> {{ isset($address) ? $address : '' }}
			        <br><br><strong>City:</strong> {{ isset($city) ? $city : '' }}
			        <br><br><strong>State/Province:</strong> {{ isset($state) ? $state : '' }}
			        <br><br><strong>Zip/Postal Code:</strong> {{ isset($zip_code) ? $zip_code : '' }}
			        <br><br><strong>Country:</strong> {{ isset($country) ? $country : '' }}  
			        <br><br><strong>Purchased From:</strong> {{ isset($purchased_from) ? $purchased_from : '' }}  
			        
			        <p>&nbsp;</p>  
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
