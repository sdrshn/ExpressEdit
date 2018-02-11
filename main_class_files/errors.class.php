<?php
Class errors {
function __construct() {if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	 //this function is within __construct which calls this function from within
	 
	function my_error_handler($e_number, $e_message, $e_file, $e_line, $e_vars) { 	if (Sys::Debug)Sys::Debug(__LINE__,__FILE__,__METHOD__);
	   	$message ="errors class ". date("dMYHis"). NL."url is: ".request::return_full_url().NL.' An error occurred in script '. $e_file.' on line '. $e_line.': '. $e_message.NL.  printer::print_wordwrap($_SERVER) ;
	   #********************************
	  if  (strpos(Sys::Self,'edit')){  
	   echo '<pre>' . $message . "\n";
				echo '</pre><br>'; 
				echo '<pre>' . $message . "\n";
				debug_print_backtrace();
				echo '</pre><br>';
		}
			#**************************
		if (Sys::Web)   { 	 		 
			$subject=mail::country_subject().' system errors class report';
			$addresses=explode(',',Cfg::Admin_email);
			foreach ($addresses as $address){
				if (!mail($address,$subject,$message)){
					exit('error class mail send program error');
					}
				 
				}//if web
			 }
	 
		else {  
		$message = wordwrap($message,Cfg::Wordwrap);
			  echo '<pre>' . $message . debug_print_backtrace(); 
		    '</pre><br>';
		    if ( mail::Localmailsend ===true){
			   error_log($message,1,Cfg::Admin_email,"From: Cfg::Mail_from");
			   }
		    }
		if (!is_dir(Sys::Home_pub.Cfg::Backup_dir.Cfg::Logfile_dir))mkdir(Cfg_loc::Root_dir.Cfg::Backup_dir.Cfg::Logfile_dir);  
		(!is_file(Cfg_loc::Root_dir.Cfg::Backup_dir.Cfg::Logfile_dir.Cfg::Log_file))&&file_put_contents(Cfg_loc::Root_dir.Cfg::Backup_dir.Cfg::Logfile_dir.Cfg::Log_file,''); 
		(!is_file(Cfg_loc::Root_dir.Cfg::Backup_dir.Cfg::Logfile_dir.Cfg::Last_log))&&file_put_contents(Cfg_loc::Root_dir.Cfg::Backup_dir.Cfg::Logfile_dir.Cfg::Last_log,'');  
		
		$log_send_dir=Sys::Home_pub.Cfg::Backup_dir.Cfg::Logfile_dir;
		$log_send= $log_send_dir.Cfg::Log_file;
		$lastLogFile=$log_send_dir.Cfg::Last_log;
		$fp = new WriteToFile($log_send, 'a');// uses file
		$fp->write($message);
		$fp->close();  
		file_put_contents($lastLogFile,$message);   
		}//function error handler.NL
	
	 
	if (Sys::Debug)Sys::Debug(__LINE__,__FILE__,__METHOD__);
	set_error_handler('my_error_handler'); 
	if (Sys::Debug)Sys::Debug(__LINE__,__FILE__,__METHOD__); 
	
	}// end construct	   
}//end class

?>
