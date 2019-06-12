<?php
#ExpressEdit 2.0.1
class catch_exceptions extends Exception{
function __construct() {
    if (Sys::Debug) echo ' begin exceptions construct';
    function my_exceptions($message) {	if (Sys::Debug)Sys::Debug(__LINE__,__FILE__,__METHOD__);
          // Build the error message:
          try {throw new Exception($message);
               }
          catch (Exception $e){ 
               $message = date("dMY-H-i-s"). NL."url is: ".request::return_full_url().NL. " An uncaught exception occurred :" . $this->getFile.NL; 
               if (Sys::Web)  {  
                    if (mail::Mailsend===false)  { 
                         echo '<pre>' . $message . "\n";
                         echo '</pre><br>'; 
                         echo '<pre>' . $message . "\n";
                         debug_print_backtrace();
                         echo '</pre><br>';
                         } 
                    else {  
                         $usr=users::instance();
                         $data=$usr->user_info;
                         $subject_append= (Sys::Logged_in||Sys::DebugOn) ? 'Owner/Admin_Ip':str_replace('.','-',$usr->ip);  
                         $subject=$subject_append.' system error report';
                         ob_start();
                         echo  NL. 'debug print'.NL;
                         debug_print_backtrace();
                         echo NL.' end debug print ';
                         $data.= ob_get_contents();
                         ob_end_clean();
                         $message.=$message.NL." catch_exceptions.class report ".$data;
                         $addresses=explode(',',Cfg::Admin_email);
                         foreach ($addresses as $address){
                              mail($address,$subject,$message,"From: ".Cfg::Mail_from);
                              }
                         }
                    }//  end web
               else {  
                    echo '<pre>' . $message . "\n";
                    debug_print_backtrace();
                    echo '</pre><br>';
                    if ( mail::Localmailsend ===true)
                        error_log($message,1,Cfg::Admin_email,"From: ".Cfg::Mail_from);
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
     if (Sys::Debug)echo 'made it to class catch_exceptions';
     set_exception_handler('my_exceptions');
     if (Sys::Debug)Sys::Debug(__LINE__,__FILE__,__METHOD__);
     }//function construct
    
}//end class
?>
