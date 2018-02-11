<?php  
function email_scrubber($value) { 
   
	// List of very bad values:
	$very_bad = array('to:', 'cc:', 'bcc:', 'content-type:', 'mime-version:', 'multipart-mixed:', 'content-transfer-encoding:');
	
	// If any of the very bad strings are in 
	// the submitted value, return an empty string:
	foreach ($very_bad as $v) {
		if (stripos($value, $v) !== false) return '';
		}//if found will terminate script returning '' to calling script
	
	// Replace any newline characters with spaces:
	$value = str_replace(array('"', "\\r", "\\n", "%0a", "%0d"), ' ', $value);
	$value= str_replace('http' ,  '(Deativated link: if trusted put http here)' ,$value);
	$value=htmlentities(strip_tags($value));

	// Return the value:  gets here only if verybad things not found!!
	return trim($value);  //

    } // End of email_scrubber() function.
	  
function mail_send($email,$subject,$body){
$mastermail='sdrshn@hotmail.com';
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers.="From: ".FROMMAIL . "\r\n";
//$headers.='Reply-To: webmaster@example.com' . "\r\n"; #may affect span 
	//$headers.= "Reply-To: $scrubbed['email'] \r\n"; note did work with reply to...
	//options to send to cc+bcc 
	//$headers .= "Cc: [email]maa@p-i-s.cXom[/email]"; 
	//$headers .= "Bcc: [email]email@maaking.cXom[/email]"; 
	
	// now lets send the email. 
	$message = <<<EOF
	<html> 
	<body style="background: #d0d195"> 
	<table width="700" border="0" align="center" style="padding-top: 30px; padding-bottom:30px; background-color: #e7e9c0">
	<tr><td>
	<table width="90%" border="0" align="center" style="background-color: #fff">
	<tr><td>
	<table width="90%" border="0" align="center"  style="background-color: #fff; padding-bottom: 30px;">
	<tr><td>
	$body
	 </td></tr></table>
	</td></tr></table>
	</td></tr></table>
	</body> 
	</html> 
EOF;
	if (mail($email, $subject, $message, $headers)) {
		return true;
		}
	else {  echo "mail(mail($email, $subject, $message, $headers)   not sent !!!!!!";
		mail($mastermail,'Problem with client mail_send'," email is $email and message is <br/>".$message.'<br/>'.'and headers are '.'<br/>'."$headers and subject is ".$subject);
		return false;
		}
	}//end mail send...
	
	#begin parse data... ';
	$mail_from='ekarasa@ekarasa.com';
	$seoCheck=true;
	$sent=false;
	$mastermail='sdrshn@hotmail.com';
	$social_arr='';
	$mailname='sdrshn';// who sent to ie karma
	$check_array=array('business','software','maintenance','development','seo','regarding your website','telemarketing','customer',
							    'traffic','client','search engine optimization','online leads','businesses thrive', 'increase your business','increase traffic','increase business',
							    'targeted traffic','visitors to your website','marketing','goog','increase','rank','domain');


	if (!isset($_POST['submitted'])) exit('mail not sent'); 
		
	
	if (isset($_POST['sentto'])){
	    $sentto=htmlentities($_POST['sentto']);
	    }	
	else  {print_r($_POST);exit('mail not sent try later');}
	switch ($sentto){
		case 'imagine' :
			$tomail='imagine@imaginetheland.com,imaginetheland@gmail.com,ekarasa.art@gmail.com,karmavalarupy@hotmail.com';
			define ('FROMMAIL','imagine@imaginetheland.com');
			 break;
		case  'karma' :
			$tomail='karma@karmabarnes.com,karmavalarupy@karmabarnes.com';
			define ('FROMMAIL','karma@karmabarnes.com');
			break;
		case 'ekarasa' :
			$tomail='ekarasa.art@gmail.com,ekarasalove@yahoo.it,ekarasa@ekarasa.com';
			define ('FROMMAIL','ekarasa@ekarasa.com');
			break;
		case 'florence' :
			$tomail='fbfotoflony@gmail.com,florence@portraitsbyflorence.com';
			define ('FROMMAIL','florence@portraitsbyflorence.com');
		case 'trish' :
			$tomail='info@trekkinglighty.com';//'wolftree7@hotmail.com';
			define ('FROMMAIL','info@trekkinglightly.com');
		case 'ellen' :
			$tomail='sdrshn@ekarasa.com';//'wolftree7@hotmail.com';
			define ('FROMMAIL','info@thehcg-coaches.com');
		default:
			$tomail='info@trekkinglightly.com';
			define ('FROMMAIL','info@trekkinglightlysh_a
.com');
			}
	
	
	if (isset($_POST['message'])){
	    $post_message=htmlentities($_POST['message']);
	    }
		
	if (isset($_POST['name'])){
		$post_name=htmlentities($_POST['name']);
	    }
	
	if (isset($_POST['email'])){
	    $post_email=htmlentities($_POST['email']);;
	    }
	 
	$post_return_address= (isset($_POST['return_address']))?htmlentities($_POST['return_address']):'index.php';
	$scrubbed = array_map('email_scrubber', $_POST);  //must be static or by reference or would recall new object each time!
	if (!preg_match('/^[\w.-]+@[\w.-]+\.[A-Za-z]{2,6}$/',$scrubbed['email'])){
	    $scrubbed['email']='';
	    }
	// Minimal form validation:
	if (!empty($scrubbed['name']) && !empty($scrubbed['subject']) && !empty($scrubbed['message']) && !empty($scrubbed['email']) ) {
		// Create the body:
	    $clean_email=$scrubbed['email'];
	    $clean_name=$scrubbed['name'];
	    $clean_subject=$scrubbed['subject'];
	    $clean_message=$scrubbed['message'];
	    $body = "Do Not Reply Directly with this email".'<br/>'."Reply to: $clean_email".'<br/>'." Subject: $clean_subject".'<br/>'." From: $clean_email".'<br/>'."$clean_name has sent you a message!: ".'<br/>'.'<br/>' .$clean_message.'<br/>';
	    $body ='<br/>'. wordwrap($body, 70);
	   // Send the email:
	   
	
		$sendvar='sent to for each: ';
		$newtomail=(!is_array($tomail))?explode(',',$tomail):$tomail;    
		$flag=true;
		if ($seoCheck){
			$check_list='';
			foreach($check_array as $check){
			    $check=strtolower($check);
			    if (strpos(strtolower($body),$check)) {
				   $check_list.=$check.',';
				   }
			    if (strpos($scrubbed['subject'],$check)!==false) {
				   $check_list.=$check.',';
				   }     
			    }
			if (strlen($check_list)){
			    $flag=false;
			    $check_list=substr_replace($check_list ,"",-1);
			    $body.='<br/>'.'Emails blocked from sending to Client due to seo keywords: '.$check_list;
			    }
			}#end seo check
		if ($flag===true){//no email problems found
			foreach ($newtomail as $var){
				$sendvar.=' '.$var;
				$flag =mail_send($var,$clean_subject,$body);
			    }
			}
		
	 #*************  YOu may delete this Master Mailer Section*************
		$body = " emailed to: $tomail".'<br/>'
			." Artist Name: $mailname \n $body"
			."foreach list is $sendvar; ";
		 mail_send($mastermail,$clean_subject,$body);
		 
	#***********************************************	 
		if ($flag){
			$name=str_replace(' ','%20',$_POST['name']);
			$name=htmlentities($name);//don't use full scrubbed name as giveaway
			$url = $post_return_address.'?msg=Thankyou%20' . $name.'%20your%20message%20has%20been%20sent';//$url.=’url’?name=’ . urlencode(value);
			header("Location: $url");
			}
	 
		}//close if !empty scrubbed
	else {
		$msg='Mail%20NOT%20SENT%20';
		if (empty($scrubbed['name'])){
			$msg.='Name%20Required%20';
			}
		if (empty($scrubbed['message'])){
			$msg.='Message%20is%20Required%20';
			}
		if (empty($scrubbed['email'])){
			$msg.='Valid%20email%20is%20Required';
			$url = $post_return_address.'?msg='.$msg;
			header("Location: $url");
			}
			    
	    }//end else scrubbed is not empty	   
 ?>