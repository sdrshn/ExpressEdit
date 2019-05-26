<?php
#ExpressEdit 2.0
$webmaster='sudarshan';
function mailadmin($newmessage){
	global $mail_from;
	global  $webmaster; 
	global $mastermail;
	global $mailsend;
	global $localmailsend;
	global $my_page;
	global $dbname;
	global $subject;
	global $vars;
	global $SERVER;
	global $test;
	global $localmail;
	global $restorepath;
	global $root_dir;
    $OSB= "OS and browser: {$_SERVER['HTTP_USER_AGENT']}\n";
    if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $TheIp=$_SERVER['HTTP_X_FORWARDED_FOR'];
    else $TheIp=$_SERVER['REMOTE_ADDR'];  
 
    $UIP="Users address: $TheIp";
    $my_message=date("dMYHis"). " $OSB \n   $UIP \n my_page is $my_page \n database is $dbname \n";
    $my_message.='testing the arrays';
    foreach ($newmessage as $msg) { 
	   $my_message.= "message array value= $msg \n";
	   } 
				
				 
    if (isset($_POST)){
	   foreach ($_POST as $key =>$var) { // Print each error.
		  $my_message.= " post variable is $key = $var \n";
		  }
	   }
    if (isset($_GET)){
	   foreach ($_GET as $key =>$var) { // Print each error.
		  $my_message.= '$_get variable '. $key .'='. $var ."\n";
		  }
	   }//if $-GET


    if (isset($vars)) $my_message.='print of defined  vars= '.print_r($vars,true);
    if (!($fp = fopen($_SERVER['DOCUMENT_ROOT'].'/'.$restorepath.'logfile/mylog.txt', 'a'))) {
	   $my_message.='Cannot open log file';
	   }
    else fwrite($fp, "$my_message");
    if (strpos($_SERVER['DOCUMENT_ROOT'], WEBSERVER))   {
	   if (isset($mailsend)&& $mailsend=='true'){
		  if (!mail($mastermail,$subject, $my_message, "From:  $mail_from")){
			 echo 'contact '.$webmaster.' about mailfunction';
			 }
		  }//! $test
	   }//if server ekarsac
    if (strpos($_SERVER['DOCUMENT_ROOT'], LOCAL ))  {   
	   if (VARDATA)  echo print_r($vars); 
	   if (isset($localmailsend)&& $localmailsend=='true')  mail($localmail, $subject, $my_message, "From:  $mail_from");
	   }
    $mailvars = get_defined_vars();
    return $mailvars;
    }//function mail
 
    $vars = get_defined_vars();
    if (VARDATA)  echo print_r($vars); 
    if (!empty($message)) {   
	  	$subject="Mistake in  $my_page  $dbname";
	   if (!$mailsend=='true'){
		  echo '<p>';
		  foreach ($message  as $msg){
			 echo " - $msg<br /> ";
			 }
		  echo '</p>';
		  }
	 $mailvars1=mailadmin($message);} 
    else if (!empty($success)){
	   $subject='updated site '.$my_page. $dbname;
	   echo '<p>';
	   $mailvars2=mailadmin($success);
	   }
 
		
?>