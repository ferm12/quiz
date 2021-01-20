<body style='background:#F6F6F6; font-family: Arial, Helvetica, Verdana, Sans-serif; font-size:12px; margin:0; padding:0;'>
<div style='background:#F6F6F6; font-family: Arial, Helvetica, Verdana, Sans-serif; font-size:12px; margin:0; padding:0;'>
<table cellspacing='0' cellpadding='0' border='0' height='100%' width='100%'>
<tr>
	<td align='center' valign='top' style='padding:10px'>
		<table bgcolor='FFFFFF' cellspacing='0' cellpadding='20' border='0' width='100%' style='text-align:left;'>
			<tr>
				<td valign='top'>
                    
                    <h1 style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#2f3133;font-size:19px;font-weight:bold;margin-top:0;text-align:left">Thank you for registering</h1>
                    <p style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#74787e;font-size:16px;line-height:1.5em;margin-top:0;text-align:left">Please click the button below to verify your email address.</p>

                    @component('mail::button', ['url' => $url])
                        Verify Email
                    @endcomponent

			        <p>&nbsp;</p>
			        <p>Sincerely,<br>Fermin      
			        <br><br>Note: This is an automatically generated email, please do not reply.</p>  
                    <br/>

                    <p style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#74787e;line-height:1.5em;margin-top:0;text-align:left;font-size:12px">If you’re having trouble clicking the "Verify Email Address" button, copy and paste the URL below
into your web browser: <a href="{{ $url }}" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#3869d4" target="_blank">{{ $url }}</a></p>
	            </td>
	         </tr>             
	    </table>
	</td>
</tr>
</table>
</div>
</body>
