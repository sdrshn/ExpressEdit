<?php
#ExpressEdit 2.0.4
class mail_exception extends Exception{
function exception_message () {if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	$usr=users::instance();
	$data=$usr->user_info();
	ob_start();
	echo  NL. 'debug print'.NL;
	debug_print_backtrace();
	echo NL.' end debug print ';
	$data.= ob_get_contents();
	ob_end_clean();
	$subject=mail::country_subject().'Exception Report';
	//this function is within __construct which calls this function from within    
     $message= 'mail exception occureed '. date("dMYHis"). NL."url is: ".request::return_full_url().NL."Message: " .NL. $this->getMessage() .NL. "File: " . $this->getFile()
	  .NL."Line: " . $this->getLine();
	if (Sys::Web){
		$addresses=explode(',',Cfg::Admin_email);
		foreach ($addresses as $address){
			if(!mail($address,$subject,$message.$data)){
				echo 'mail send error with '.$address . ' in mail exception class';
				}
			}
		return;
		}
	if (Sys::Loc){ echo $message;	debug_print_backtrace();}
	}//function     

}//end class
?>
