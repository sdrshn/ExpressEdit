<?php
#ExpressEdit 2.0
#testchange 336333
class mail {
	private static $instance=false; //store instance 
    const Mail_send_backup=false; //email database backup
    const Localmailsend=false;//LOCALMAILSEND;   gives defaul on and use ? localmailoff   to shut off//use local smtp
    const Mailsend=true;// send email of messages
    const Mail_from='ekarasa@ekarasa.com';     
    const Webmaster='Sudarshan';
    const Defined_vars=false;//use get_defined_vars in error messages  takes up alot of log space
    const Post_vars=false;
    const Reply_to='sdrshn@ekarasa.com';
    const Contact_loc_mailer='mailsend.php'; 
    public $OSB;
    public $TheIP; 
    private $printmaildata=false;
/*  
echo 'sapi.name = '.php_sapi_name().'; ';
#f (substr(php_sapi_name(),0,3)=='cgi') {
    echo 'server.new()'."\n";
    $srv = new Server();
    echo 'server.render(), '."\n";
    $srv->render();
    echo 'server.done'."\n";
#    }*/     
function user_info(){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	$usr=users::instance();
	$this->OS=$usr->get('OS');
	$this->OSB="OS and browser: $this->OS";
	$this->TheIp=$usr->get('ip');
	$this->ip=$_SERVER['REMOTE_ADDR']?:($_SERVER['HTTP_X_FORWARDED_FOR']?:$_SERVER['HTTP_CLIENT_IP']);
	$this->user_info=$usr->user_info();
	}
 

static function country_subject(){
	$usr=users::instance();
	$print= substr($usr->get('country_code3')." " .$usr->get('city'),0,10);  
	return $print; 
	}

static function iplookup($ipaddress=''){
	$usr=users::instance();#this->usr will be referred to in contact master!
	$print="\n".'The following Location Information is Provided to identify Where this email was sent from:'."\n";
	$print.="\n"."ip is ".$usr->get('ip');
	$print.="\n". "3 letter country code is: " . $usr->get('country_code3') . " name is: " . $usr->get('country') ."\n";
	$print.="\n". "Region is: ".$usr->get('region');
	$print.="\n". "City/town of Internet Provider (close or same as sender's location): ". $usr->get('city') ."\n";
	$print.="\n". "continent is: " .$usr->get('continent') ."\n";
	return $print;
	}
	#" " . $GEOIP_REGION_NAME[$usr->country_code][$usr->region] ."\n";
	#$print.= $usr->postal_code ."\n";
	#$print.= "latitude is: ".$usr->latitude ."\n";
	#$print.= "longitude is: ". $usr->longitude ."\n";
	#$print.= $usr->metro_code ."\n";
	#$print.= $usr->area_code ."\n";

static function user_full_lookup(){ 
	$usr=users::instance();#this->usr will be referred to in contact master!
	$print="\n". "full url is ". request::return_full_url();
	$print.="\n". "3 letter country code is: " . $usr->get('country_code3') . " name is: " . $usr->get('country') ."\n";
	$print.="\n". "Region is: ".$usr->get('region');
	$print.="\n". "City/town of Internet Provider (close or same as sender's location): ". $usr->get('city') ."\n";
	$print.="\n".'OS and browser: '.$usr->get('OS');
	$print.="\n". "continent is: " .$usr->get('continent') ."\n";
	$print.="\n"."ip is ".$usr->get('ip');  
	return $print;
	}
	
function mailwebmaster($succmessage, $errmessage, $vars='',$echo=true){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);  if (Sys::Debug) echo "\n".'made it function mailwebmaster'."\n". 'address is '.Cfg::Admin_email; 
	$storeinst=store::instance();
	$backtrace=false;
	$succmessage=(!is_array($succmessage))? explode(',',$succmessage):$succmessage; 
	$errmessage=(!is_array($errmessage))? explode(',',$errmessage):$errmessage; 
	if ($this->printmaildata)  echo printer::print_wordwrap($vars);   
	//if ($arrayhandle->is_empty_array($succmessage)==true){echo "\n".  'success is true';}else echo 'success is false'; 
	//if ($arrayhandle->is_empty_array($errmessage)==true){echo "\n".  'mess is true';}else echo 'mess is false'; 
	if (!empty($succmessage[0])&& !empty($errmessage[0])){
		$subject='Success and Error in '. Sys::Self.' @'.$storeinst->tablename;  
		$new_message=array_merge($succmessage, $errmessage);
		}
	else if(!empty($succmessage[0])){
		$subject='updated site on '. Sys::Self.'  '.Sys::Dbname.' @'.$storeinst->tablename;  
		$new_message=$succmessage;
		}
	else if(!empty($errmessage[0])){  //error message is true
		$subject='Mistake in '. Sys::Self.'  '.Sys::Dbname.' @'.$storeinst->tablename;  
		$new_message=$errmessage;
		if (Sys::Debug===true && $echo===true){ //not being mailed so testing going on and print values
			foreach ($errmessage  as $msg)  {// Print each error.
			printer::alert_neg("Error message: - $msg");
			}
		}
	}
	else return;
	if (!Cfg::Debug_backtrace)$data="If necessary Enable debug backtrace by setting Cfg::Debug_backtrace to true in Config file";
	elseif (!empty($errmessage[0])){
		ob_start();
		echo  "\n". 'debug print'."\n";
		debug_print_backtrace();
		#print_r(debug_backtrace());
		echo "\n".' end debug print ';
		$data = ob_get_contents();
		ob_end_clean();
		$data=wordwrap($data,Cfg::Wordwrap,"\n",true);
		}
     else $data='';
	$subject_append= self::country_subject();  
	$subject=$subject_append.' '.$subject;   
	$my_message="\n".'Mail Class Message: the date is '.date("dMY-H-i-s"). self::user_full_lookup()."\n".  " database is ". Sys::Dbname;
	foreach ($new_message as $msg) { 
		$my_message.= "\n"."\n"."\n"." direct message= \n \n \n". $msg;
		}
     $my_message.= "\n \n \n";
	if (isset($_POST)&&self::Post_vars){  
		foreach ($_POST as $key =>$var) { // Print each error.
			if (is_array($var)){
				$var=print_r($var,true);
				}
			$my_message.=  "\n post variable is $key = $var";
			}
		}
	else $my_message.="\n post variables verbose is false. Set mail::Post_vars to true for Reqest Vars";
	if (isset($_GET)&&self::Post_vars){
		foreach ($_GET as $key =>$var) { // Print each error.
			$my_message.= "\n".'$_get variable '. $key .'='. $var ."\n";
			}
		}//if $-GET 
	$my_message=wordwrap($my_message,Cfg::Wordwrap)."\n". $data;
	
	 if (empty($vars)&&self::Defined_vars&&!empty($errmessage[0])){
		$vars=get_defined_vars();
		$my_message.='print of defined  vars= '.printer::print_wordwrap($vars);
		}
    else $my_message.="\n Defined Vars  is false. Set mail::Defined_vars to true for all Vars Info";
	
	if (Sys::Web||self::Localmailsend){//if live ek
		if (self::Mailsend===true) {
			$addresses=explode(',',Cfg::Admin_email);
			foreach ($addresses as $address){
				if (!mail($address,$subject, $my_message, "From: ".Cfg::Mail_from)){
					echo 'main mailing error';
					}
				}
			} 
		}//if server ekarsac
		 
	if (!is_dir(Sys::Home_pub.Cfg::Backup_dir.Cfg::Logfile_dir))mkdir(Cfg_loc::Root_dir.Cfg::Backup_dir.Cfg::Logfile_dir);  
	    (!is_file(Cfg_loc::Root_dir.Cfg::Backup_dir.Cfg::Logfile_dir.Cfg::Log_file))&&file_put_contents(Cfg_loc::Root_dir.Cfg::Backup_dir.Cfg::Logfile_dir.Cfg::Log_file,''); 
		(!is_file(Cfg_loc::Root_dir.Cfg::Backup_dir.Cfg::Logfile_dir.Cfg::Last_log))&&file_put_contents(Cfg_loc::Root_dir.Cfg::Backup_dir.Cfg::Logfile_dir.Cfg::Last_log,'');  
		
	$log_send_dir=Sys::Home_pub.Cfg::Backup_dir.Cfg::Logfile_dir;
	$log_send= $log_send_dir.Cfg::Log_file;
	$lastLogFile=$log_send_dir.Cfg::Last_log;
	try {
		$fp = new WriteToFile($log_send, 'a');// uses file
		$fp->write($my_message);
		$fp->close();  
		file_put_contents($lastLogFile,$my_message); 
		} 
	catch (FileException $fe) {
		if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
		$my_message= " The process could not be completed. Debugging information:" . "\n". $fe->__tostring() . "\n" . $fe->get_details() ."\n";
		if (!Sys::Web) return;
		$addresses=explode(',',Cfg::Admin_email);
		foreach ($addresses as $address){
			mail($address, 'Log File Problem', $my_message, "From: ".Cfg::Mail_from);
			}
		} 
	}//function mail

function mail_attachment($filename, $full_path, $mailto, $from_mail, $from_name, $replyto, $subject, $message) {
	if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	if (Sys::Debug) echo 'made it to mailinst->mail_attachment';
     if (Sys::Loc ){
		if (self::Localmailsend) {
			$addresses=explode(',',Cfg::Admin_email);
			foreach ($addresses as $address){
				mail($address,'Backup Database',$message,"Cfg::");
				}
			return;
			} 
		else {echo $message; return;}
		}
	$subject_append= self::country_subject();  
	$subject=$subject_append.' '.$subject;   	
    $file = $full_path.$filename;
    $file_size = filesize($file);
    $handle = fopen($file, "r");
    $content = fread($handle, $file_size);
    fclose($handle);
    $content = chunk_split(base64_encode($content));
    $uid = md5(uniqid(time()));
    $name = basename($file);
    $header = "From: ".$from_name." <".$from_mail.">\r\n";
    //$header .= "Reply-To: ".$replyto."\r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
    $header .= "This is a multi-part message in MIME format.\r\n";
    $header .= "--".$uid."\r\n";
    $header .= "Content-type:text/plain; charset=iso-8859-1\r\n";
    $header .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
    $header .= "--".$uid."\r\n";
    $header .= "Content-Type: application/octet-stream; name=\"".$filename."\"\r\n"; // use diff. tyoes here 
    $header .= "Content-Transfer-Encoding: base64\r\n";
    $header .= "Content-Disposition: attachment; filename=\"".$filename."\"\r\n\r\n";
    $header .= $content."\r\n\r\n";
    $header .= "--".$uid."--";
    $addresses=explode(',',$mailto);
	foreach ($addresses as $address){
		 if(!mail($address, $subject, $message, $header)){  
			$subject='Mail failure';
			$message[]="A problem in  mail send attachement with $address";
			}
		} 
   	}//end function mail attachment
 
static function email_scrubber($value) {if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
   
	   // List of very bad values:
	   $very_bad = array('to:', 'cc:', 'bcc:', 'content-type:', 'mime-version:', 'multipart-mixed:', 'content-transfer-encoding:');
	   
	   // If any of the very bad strings are in 
	   // the submitted value, return an empty string:
	   foreach ($very_bad as $v) {
		   if (strpos($value, $v) !== false) return '';
	   }//if found will terminate script returning '' to calling script
	   
	   // Replace any newline characters with spaces:
	   $value = str_replace(array('"', "\\r", "\\n", "%0a", "%0d"), ' ', $value);
	   $value= str_replace('http' ,  '(Deativated link: if trusted put http here)' ,$value);
	  $value=htmlentities(strip_tags($value));
   
	   // Return the value:  gets here only if verybad things not found!!
	   return trim($value);  //
   
	  } // End of email_scrubber() function.
/*
 static function mail_send($email,$subject,$message,$from=''){
	 	if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);if (Sys::Debug) echo 'made it to mail:mail_send';
     if (Sys::Loc){
	   echo "\n".$subject;
	   echo "\n".$message;
	  return;
	   }
    
	$headers  =(!empty($from))?"From: $from\r\n": "From: ".Cfg::Mail_from."\r\n"; 
    $headers .= "Content-type: text/html\r\n";
    if (Sys::Debug)echo "headers is $headers";
    //options to send to cc+bcc 
    //$headers .= "Cc: [email]maa@p-i-s.cXom[/email]"; 
    //$headers .= "Bcc: [email]email@maaking.cXom[/email]"; 
     
     $message =nl2br(wordwrap($message, 100));
     $body = <<<EOF
    <html> 
    <body style="background: #d0d195"> 
    <table width="700" border="0" align="center" style="padding-top: 30px; padding-bottom:30px; background-color: #e7e9c0">
    <tr><td>
    <table width="90%" border="0" align="center" style="background-color: #fff">
    <tr><td>
    <table width="90%" border="0" align="center"  style="background-color: #fff; padding-bottom: 30px;">
    <tr><td>
     $message
	 </td></tr></table>
    </td></tr></table>
    </td></tr></table>
     </body> 
    </html> 
EOF;
if(Sys::Debug)echo "mail is $email subject is $subject body is $body and header is $headers";
  if (!mail($email, $subject, $body, $headers)) {if (Sys::Debug)echo 'Mail send error';}
  }
  */
static function error($msg,$subject='Mail error called:'){
	$msg='  **  url: '.request::return_full_url()."\n".$subject.' '. $msg;
	process_data::log_to_file($subject."\n".$msg."\n");
	process_data::write_to_file('error_last_log',$subject."\n".$msg."\n");
	if (Sys::Loc){
		printer::alert_neg($msg,1.2);
		debug_print_backtrace();
		}
	else {
		process_data::log_to_file($subject."\n".$msg."\n"); 
		ob_start();
		echo  "\n". 'debug print'."\n";
		debug_print_backtrace();
		print_r(debug_backtrace());
		echo "\n".' end debug print ';
		$data = ob_get_contents();
		ob_end_clean();
		$data=wordwrap($data,Cfg::Wordwrap,"\n",true);
		$msgx="\n". wordwrap($msg,Cfg::Wordwrap) .  $data;
		$addresses=explode(',',Cfg::Admin_email);
		foreach ($addresses as $address){
			if (!mail($address,$subject, $msgx, "From: ".Cfg::Mail_from)){
				echo 'mail error send problem in mail::error';
				}
			}
		self::alert($msg,'error backup::alert backup called');
		}
    }
    
static function alert($msg,$subject='mail::alert'){   
	$subject= self::country_subject()." ".$subject;  
	$msg.= '  **  url: '.request::return_full_url()."\n".self::user_full_lookup();
	process_data::log_to_file($subject."\n".$msg."\n"); 
	process_data::write_to_file('error_last_log',$subject."\n".$msg."\n");
	if (Sys::Loc){
		printer::alert($subject."\n".$msg."\n");
		# print_r(debug_backtrace());
		//debug_print_backtrace();
		}
	else {
		 $msg.=print_r(debug_backtrace(),true);
		 #$msg.="\n".printer::print_wordwrap(get_defined_vars());
		$addresses=explode(',',Cfg::Admin_email);
		foreach ($addresses as $address){
			if (!mail($address,$subject, $msg, "From: ".Cfg::Mail_from)){
				echo 'alert mail error in mail::alert trying to send msg using SysWeb is true';
				}
			}
		}
    }
    
static function alert2($msg,$subject='mail::alert'){   
	$subject= self::country_subject()." ".$subject;  
	$msg.= '  **  url: '.request::return_full_url()."\n".self::user_full_lookup();
		process_data::log_to_file($subject."\n".$msg."\n"); 
	if (Sys::Loc){	
		printer::alert($subject."\n".$msg."\n");
		# print_r(debug_backtrace());
		//debug_print_backtrace();
		}
	else {
		 $msg.=print_r(debug_backtrace(),true);
		 #$msg.="\n".printer::print_wordwrap(get_defined_vars());
		if (!mail(Cfg::Admin_email,$subject, $msg, "From: ".Cfg::Mail_from)){
			echo 'mail send error in mail::alert2';
			}
		}
    } 

static function success($msg,$subject='Successful Update: '){
	$storeinst=store::instance();
	$subject= self::country_subject()." ".$subject; 
	$msg='  **  url: '.request::return_full_url()."\n".$subject.' '. $msg;
		process_data::log_to_file($subject."\n".$msg."\n"); 
		if (Sys::Loc){
		printer::alert_pos($msg,1); 
		}
	else { 
		$addresses=explode(',',Cfg::Admin_email);
		foreach ($addresses as $address){
			if (!mail($address,$subject, $msg, "From: ".Cfg::Mail_from)){
				echo 'mail send error in success with '. $address;
				}
			}
		}
	}
static function mininfo($msg,$subject='Update Info: '){ 
	$subject= self::country_subject()." ".$subject; 
	if (Sys::Loc){
		process_data::write_to_file('mail',$msg,false,true); 
		}
	else { 
		$addresses=explode(',',Cfg::Admin_email);
		foreach ($addresses as $address){
			if (!mail($address,$subject, $msg, "From: ".Cfg::Mail_from)){
				echo 'mail send error in update info with '. $address;
				}
			}
		}
	}       
static function info($msg,$subject='Update Info: '){
	$storeinst=store::instance();
	$subject= self::country_subject()." ".$subject; 
	$msg='  **  url: '.request::return_full_url()."\n".$subject.' '. $msg;
		process_data::log_to_file($subject."\n".$msg."\n"); 
		if (Sys::Loc){
		printer::alert_neu($msg,1); 
		}
	else { 
		$addresses=explode(',',Cfg::Admin_email);
		foreach ($addresses as $address){
			if (!mail($address,$subject, $msg, "From: ".Cfg::Mail_from)){
				echo 'mail send error in update info with '. $address;
				}
			}
		}
	}    	
 
static function alert_min($msg,$subject='Update Info: '){
	
	$msg='  **  url: '.request::return_full_url()."\n".$subject.' '. $msg;
		process_data::log_to_file($subject."\n".$msg."\n"); 
		if (Sys::Loc){
		printer::alert_neu($msg,1); 
		}
	else { 
		$addresses=explode(',',Cfg::Admin_email);
		foreach ($addresses as $address){
			if (!mail($address,$subject, $msg, "From: ".Cfg::Mail_from)){
				echo 'mail send error in update info with '. $address;
				}
			}
		}
	}
     
public static function instance(){ if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);//static allows it to create an instance without creating a new object
    if  (empty(self::$instance)) {
	   self::$instance = new mail(); 
        } 
    return self::$instance; 
    }  	
}//end class
?>