<body style='background:#F6F6F6; font-family: Arial, Helvetica, Verdana, Sans-serif; font-size:12px; margin:0; padding:0;'>
<div style='background:#F6F6F6; font-family: Arial, Helvetica, Verdana, Sans-serif; font-size:12px; margin:0; padding:0;'>
<table cellspacing='0' cellpadding='0' border='0' height='100%' width='100%'>
<tr>
	<td align='center' valign='top' style='padding:10px'>
		<table bgcolor='FFFFFF' cellspacing='0' cellpadding='20' border='0' width='100%' style='text-align:left;'>
			<tr>
				<td valign='top'>

					<p>&nbsp;</p>
	            	<p>Dear {{ $first_name . ' ' . $last_name  }},</p>

	            	<p>&nbsp;</p>
	            	<p>We received a request to change your password for the ScreenBeam Classroom Commander License Portal </p>

                    <p>Here is your new password:</p>

                    <p> {{ $password }}</p>

		            <p>&nbsp;</p>
                    <p>Sincerely,
                        <br>ScreenBeam Team<br><br>       
		            	Note: This is an automatically generated email, please do not reply.</p>              

	            </td>
	         </tr>             
	    </table>
	</td>
</tr>
</table>
</div>
</body>
