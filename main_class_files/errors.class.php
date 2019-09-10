<?php
#ExpressEdit 2.0.4

Class errors {
     
function __construct() {if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	 //this function is within __construct which calls this function from within
	function my_error_handler ($e_number, $e_message, $e_file, $e_line, $e_vars) {
	if (Sys::Web)$exit=Cfg::Error_exit;
     else $exit=true;
	(Sys::Error_no_exit)&&$exit=false;
     echo '<div class="editbackground editcolor editfont">';
     $message1="e_message: $e_message  e_file: $e_file,  e_line: $e_line  <br><br>";
     if (Sys::Loc)  
		echo $message1;
      
	$ip = $_SERVER['REMOTE_ADDR']?:($_SERVER['HTTP_X_FORWARDED_FOR']?:$_SERVER['HTTP_CLIENT_IP']);
	$message = NL.NL."newlog".NL.NL."error handler.php ".date("dMYHis").' IP:'.$ip. NL."url is: ".request::return_full_url().NL.' An error occurred in script '. $e_file.' on line '. $e_line.': '. $e_message.NL;
	$data='';
	if (Cfg::Debug_backtrace){
	    ob_start();
		echo  NL. 'debug print'.NL;
		debug_print_backtrace();
		echo NL.' end debug print ';
		$data= ob_get_contents();
		ob_end_clean();
		}
	else $message.= "If necessary Enable debug backtrace by setting Cfg::Debug_backtrace to true in Config file";
	if (Sys::Loc){  
		echo $message.$data;
		if ($exit){
			echo 'exiting set to true in error_handler for local system';
			exit();
			}
		}
	$message=$message.$data;
	if  (strpos(Sys::Self,'editpage')!==false||(defined('Cfg::PrimeEditdir')&&strpos(Sys::Self,Cfg::PrimeEditdir)!==false)) {  
		echo '<pre>' . $message . "\n";
			echo '</pre><br>';  
               }
	if (Sys::Web)   { 	 		 
		$subject=' system error handler report';
		$addresses=explode(',',Cfg::Admin_email);
		foreach ($addresses as $address){
			$addresses=explode(',',Cfg::Admin_email);
			foreach ($addresses as $address){
				if (!mail($address,$subject,$message1.$message)){
					print('error handler mail send error');
					}
				}
			}
		}//if web
	 else {  
		$message = wordwrap($message,Cfg::Wordwrap);
		}
	if (!is_dir(Sys::Home_pub.Cfg::Backup_dir.Cfg::Logfile_dir)){
		if (mkdir(Sys::Home_pub.Cfg::Backup_dir.Cfg::Logfile_dir,0755,true)){
			$log_send_dir=Sys::Home_pub.Cfg::Backup_dir.Cfg::Logfile_dir;
			}
	     else {
			if (!is_dir(Cfg_loc::Root_dir.Cfg::Backup_dir.Cfg::Logfile_dir)){
				if (mkdir(Cfg_loc::Root_dir.Cfg::Backup_dir.Cfg::Logfile_dir,0755,true)){
					$log_send_dir=Cfg_loc::Root_dir.Cfg::Backup_dir.Cfg::Logfile_dir;
					}
				else mail::error("problem in __FILE__, __LINE__ Logging $message1 $message");
				exit("problem in __FILE__, __LINE__ Logging $message");
				}
			}
		}
	else $log_send_dir=Sys::Home_pub.Cfg::Backup_dir.Cfg::Logfile_dir;
	(!is_file($log_send_dir.Cfg::Log_file))&&file_put_contents($log_send_dir.Cfg::Log_file,'In the beginning:'); 
	(!is_file($log_send_dir.Cfg::Last_log))&&file_put_contents($log_send_dir.Cfg::Last_log,'In the beginning:');  
	$log_send_dir=Sys::Home_pub.Cfg::Backup_dir.Cfg::Logfile_dir;
	$log_send= $log_send_dir.Cfg::Log_file;
	$lastLogFile=$log_send_dir.Cfg::Last_log;
	$fp = new WriteToFile($log_send, 'a');// uses file
	$fp->write($message);
	$fp->close();  
	file_put_contents($lastLogFile,$message); 
	if ($exit){
          echo 'exiting set to true in error_handler2';
          //process_data::log_to_file($message.$data);
          exit();
          }
     echo '</div>';
     } // End of my_error_handler function .
 
set_error_handler ('my_error_handler',E_ALL); 
	
	}// end construct	   
}//end class

?>
