<body style='background:#F6F6F6; font-family: Arial, Helvetica, Verdana, Sans-serif; font-size:12px; margin:0; padding:0;'>
<div style='background:#F6F6F6; font-family: Arial, Helvetica, Verdana, Sans-serif; font-size:12px; margin:0; padding:0;'>
<table cellspacing='0' cellpadding='0' border='0' height='100%' width='100%'>
<tr>
    <td align='center' valign='top' style='padding:10px'>

        <table bgcolor='FFFFFF' cellspacing='0' cellpadding='20' border='0' width='100%' style='text-align:left;'>
        <tr>
        	<td valign='top'>

		        <h1 style='font-size:18px; font-weight:normal; line-height:22px; margin:0 0 11px 0;'>
		        	{{ isset($subject) ? $subject : '' }}
		        </h1><br/>

		        <p>Start Time: {{ isset($startTime) ? $startTime : '' }}
		        <br>End Time: {{ isset($endTime) ? $endTime : '' }}</p>

		        <p>&nbsp;</p>
		        <p><font style='font-size:14px; font-weight: bold;'>Partner Signup</font></p>
		        <table border='0' cellspacing='0' cellpadding='6' style='width: 100%; text-align:center; border:1px solid #E0E0E0;border-collapse:collapse;'>
			        <tr>
				        <td style='border:1px solid #E0E0E0;border-collapse:collapse;'><strong>Total Count</strong></td>
				        <td style='border:1px solid #E0E0E0;border-collapse:collapse;'><strong>Confirmed</strong></td>
				        <td style='border:1px solid #E0E0E0;border-collapse:collapse;'><strong>Refused</strong></td>
				        <td style='border:1px solid #E0E0E0;border-collapse:collapse;'><strong>Pending</strong></td>
			        </tr> 
			        <tr>
				        <td style='border:1px solid #E0E0E0;border-collapse:collapse;'>{{ isset($customerCount) ? $customerCount : '' }}</td>
				        <td style='border:1px solid #E0E0E0;border-collapse:collapse;'>{{ isset($customerConfirmedCount) ? $customerConfirmedCount : '' }}</td>
				        <td style='border:1px solid #E0E0E0;border-collapse:collapse;'>{{ isset($customerRefusedCount) ? $customerRefusedCount : '' }}</td>
				        <td style='border:1px solid #E0E0E0;border-collapse:collapse;'>{{ isset($customerPendingCount) ? $customerPendingCount : '' }}</td>
			        </tr> 
		        </table>

		        <p>&nbsp;</p>
		        <p><font style='font-size:14px; font-weight: bold;'>Deal Registration</font></p>
		        <table border='0' cellspacing='0' cellpadding='6' style='width: 100%; text-align:center;border:1px solid #E0E0E0;border-collapse:collapse;'>
			        <tr>
				        <td style='border:1px solid #E0E0E0;border-collapse:collapse;'><strong>Total Count</strong></td>
				        <td style='border:1px solid #E0E0E0;border-collapse:collapse;'><strong>Approved</strong></td>
				        <td style='border:1px solid #E0E0E0;border-collapse:collapse;'><strong>Declined</strong></td>
				        <td style='border:1px solid #E0E0E0;border-collapse:collapse;'><strong>Pending</strong></td>
				        <td style='border:1px solid #E0E0E0;border-collapse:collapse;'><strong>Qualifying Call Needed</strong></td>
				        <td style='border:1px solid #E0E0E0;border-collapse:collapse;'><strong>Account Mgr. Reaching out to ISS</strong></td>
				        <td style='border:1px solid #E0E0E0;border-collapse:collapse;'><strong>Missing Qualification Call</strong></td>
				        <td style='border:1px solid #E0E0E0;border-collapse:collapse;'><strong>CAM Working with Reseller</strong></td>
			        </tr> 
			        <tr>
				        <td style='border:1px solid #E0E0E0;border-collapse:collapse;'>{{ isset($dealCount) ? $dealCount : '' }}</td>
				        <td style='border:1px solid #E0E0E0;border-collapse:collapse;'>{{ isset($dealApprovedCount) ? $dealApprovedCount : '' }}</td>
				        <td style='border:1px solid #E0E0E0;border-collapse:collapse;'>{{ isset($dealDeclinedCount) ? $dealDeclinedCount : '' }}</td>
				        <td style='border:1px solid #E0E0E0;border-collapse:collapse;'>{{ isset($dealPendingCount) ? $dealPendingCount : '' }}</td>
				        <td style='border:1px solid #E0E0E0;border-collapse:collapse;'>{{ isset($dealQCNCount) ? $dealQCNCount : '' }}</td>
				        <td style='border:1px solid #E0E0E0;border-collapse:collapse;'>{{ isset($dealAMRICount) ? $dealAMRICount : '' }}</td>
				        <td style='border:1px solid #E0E0E0;border-collapse:collapse;'>{{ isset($dealMQCCount) ? $dealMQCCount : '' }}</td>
				        <td style='border:1px solid #E0E0E0;border-collapse:collapse;'>{{ isset($dealCWRCount) ? $dealCWRCount : '' }}</td>
			        </tr> 
		        </table>

		        <p>&nbsp;</p>
		        <p><font style='font-size:14px; font-weight: bold;'>Product Summary of Approved Deal</font></p>
		        <table border='0' cellspacing='0' cellpadding='10' style='width: 100%; text-align:left; border:1px solid #E0E0E0; border-collapse:collapse;'>
			        <tr>
				        <td style='border:1px solid #E0E0E0;border-collapse:collapse;'><strong>Product</strong></td>
				        <td style='border:1px solid #E0E0E0;border-collapse:collapse;'><strong>Quantity</strong></td>
				        <td style='border:1px solid #E0E0E0;border-collapse:collapse;'><strong>Price</strong></td>
				        <td style='border:1px solid #E0E0E0;border-collapse:collapse;'><strong>Amount</strong></td>
			        </tr>

		        @if (isset($productList)) 
		            @foreach ($productList as $row) 
		                <tr>
			                <td style='border:1px solid #E0E0E0;border-collapse:collapse;'>{{ isset($row['product']) ? $row['product'] : '' }}</td>
			                <td style='border:1px solid #E0E0E0;border-collapse:collapse;'>{{ isset($row['count']) ? $row['count'] : '' }}</td>
			                <td style='border:1px solid #E0E0E0;border-collapse:collapse;'>{{ isset($row['price']) ? $row['price'] : '' }}</td>
			                <td style='border:1px solid #E0E0E0;border-collapse:collapse;'>{{ isset($row['amount']) ? $row['amount'] : '' }}</td>
		                </tr>
		            @endforeach
		        @endif
		        
		        </table>

		        <p>&nbsp;</p>
		        <p>Sincerely,<br>Actiontec Channel Partner Team
		        <br><br>Note: This is an automatically generated email, please do not reply.</p> 

        	</td>
        </tr>             
        </table>

    </td>
</tr>
</table>
</div>
</body>
        