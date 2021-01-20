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

		        <p>Deal Registration Count: {{ isset($dealCount) ? $dealCount : '' }}</p>
		        <p>Start Time: {{ isset($startTime) ? $startTime : '' }}</p>
		        <p>End Time: {{ isset($endTime) ? $endTime : '' }}</p>
		 
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
        