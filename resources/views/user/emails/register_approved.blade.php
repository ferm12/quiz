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

	            	<p><br>On behalf of the global team at Actiontec, we would like to officially welcome you to our partner program. 
	            		{{ isset($company) ? $company : '' }} is now recognized as a member of our elite family of authorized solutions providers and resellers. 
	            		Through our partner program, we will provide you with sales, marketing and technical resources to help enable your business to capitalize on the fast-growing wireless display market opportunity. </p>

	            	<p><br>Customers are rapidly deploying ScreenBeam solutions in their meeting rooms, conference rooms and classrooms. Actiontec leads the way in providing these solutions globally.
	            		We look forward to becoming part of your organization's success story.</p>

	            	<p>&nbsp;</p>
	            	<p>Some of the benefits of the partner portal are:</p>

			           <ul>
			            <li style='padding: 5px;'>Access to the Deal Registration page</li>
			            <li style='padding: 5px;'>Direct access to case studies / white papers</li>
			            <li style='padding: 5px;'>Access to marketing tools and presentations</li>
			            <li style='padding: 5px;'>Access to technical resources, training, and big deal support</li>
		            </ul>

		            <p>&nbsp;</p>
		            <p>Your login and password to our partner portal are:</p>
		            <p style='margin-left:25px;'><a href="{{ url('user/login') }}" target='_blank'>{{ url('user/login') }}</a>
		            	<br><br>Login: {{ isset($email) ? $email : '' }}
		            	<br><br>Password: {{ isset($password) ? $password : '' }}</p>

		            <p>&nbsp;</p>
		            <p>We encourage you to take some time to explore the resources available. If you have any additional questions, please send an email to: 
		            	<a href='mailto:channelsales@actiontec.com'>channelsales@actiontec.com</a></p>
		            
		            <p>&nbsp;</p>
		            <p>Take a few moments to learn more by watching these videos:</p>
		            <ul>
			            <li style='padding: 5px;'>
			            	ScreenBeam Wireless Display for Business and Schools <br>
			            	<a href='https://www.youtube.com/watch?v=MWsFRK8wS_8' target='_blank'>https://www.youtube.com/watch?v=MWsFRK8wS_8</a>
			            </li>
			            <li style='padding: 5px;'>
			            	ScreenBeam Classroom Commander for Windows 10 Classrooms <br>
			            	<a href='https://www.youtube.com/watch?v=rf4zVu5ZBDM&t=45s' target='_blank'>https://www.youtube.com/watch?v=rf4zVu5ZBDM&t=45s</a>
			            </li>
			            <li style='padding: 5px;'>
			            	Microsoft Partnership in Education <br>
			            	<a href='https://www.youtube.com/watch?v=1zWeiTtWZSU' target='_blank'>https://www.youtube.com/watch?v=1zWeiTtWZSU</a>
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