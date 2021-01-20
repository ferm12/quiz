<body style='background:#F6F6F6; font-family: Arial, Helvetica, Verdana, Sans-serif; font-size:12px; margin:0; padding:0;'>
<div style='background:#F6F6F6; font-family: Arial, Helvetica, Verdana, Sans-serif; font-size:12px; margin:0; padding:0;'>
<table cellspacing='0' cellpadding='0' border='0' height='100%' width='100%'>
<tr>
	<td align='center' valign='top' style='padding:10px'>

		<table bgcolor='FFFFFF' cellspacing='0' cellpadding='20' border='0' width='100%' style='text-align:left;'>
		<tr>
			<td valign='top'>

				<p>&nbsp;</p>
				<p>Dear {{ isset($username) ? $username : '' }},</p>

				<p><br>Unfortunately, your request to become a ScreenBeam Partner was unsuccessful. 
					We were unable to verify the information you provided due to using a personal e-mail or address or outside of the US or Canada. 
					As a result, you will not be able to log into the Actiontec Partner Portal and have access to information about how to market and sell ScreenBeam wireless display products. </p>

				<p>&nbsp;</p>
				<p>You have the option to:</p>
				<ul>
					<li style='padding: 5px;'>
						Try again and submit the form by clicking on the link below<br><br>
						<a href="{{ url('user/register') }}" target='_blank'>{{ url('user/register') }}</a>
					</li>
					<li style='padding: 5px;'>
						Reach out to your account manager for further support or contact<br><br>
						<a href='mailto:channel-marketing@actiontec.com'>channel-marketing@actiontec.com</a>
					</li>
				</ul>

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

   