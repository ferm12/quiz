<body style='background:#F6F6F6; font-family: Arial, Helvetica, Verdana, Sans-serif; font-size:12px; margin:0; padding:0;'>
<div style='background:#F6F6F6; font-family: Arial, Helvetica, Verdana, Sans-serif; font-size:12px; margin:0; padding:0;'>
<table cellspacing='0' cellpadding='0' border='0' height='100%' width='100%'>
<tr>
	<td align='center' valign='top' style='padding:10px'>
		<table bgcolor='FFFFFF' cellspacing='0' cellpadding='20' border='0' width='100%' style='text-align:left;'>
			<tr>
				<td valign='top'>

					<p>&nbsp;</p>
	            	<p>Dear {{ $username }},</p>

	            	<p>&nbsp;</p>
	            	<p>We received a request to change the password for your account.</p>

					<p>If you requested this admin password change, please click on the following link to reset your admin password: </p>

					<p><a href="{{ $link }}"> {{ $link }} </a></p>

					<p>&nbsp;</p>
					<p>If clicking the link does not work, please copy and paste the URL into your browser instead.<br>
					   If you did not make this request, you can ignore this message and your password will remain the same.</p>

		            <p>&nbsp;</p>
		            <p>Sincerely,<br>Actiontec Channel Partner Team<br><br>       
		            	Note: This is an automatically generated email, please do not reply.</p>              

	            </td>
	         </tr>             
	    </table>
	</td>
</tr>
</table>
</div>
</body>