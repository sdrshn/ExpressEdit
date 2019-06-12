<?php
#ExpressEdit 2.0.1
class redirect {
function page_referrer_redirect($msg,$succ='', $redirect='', $display=false,$refresh=false){ if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
     $message=array($msg);    
     $success=array($succ);
     if (Sys::Debug==1||Sys::Debug==1){
          $display=Sys::error_info(__LINE__,__FILE__,__METHOD__);
	     $display.= NL."referrer is ". $redirect;
		$display.= NL."mesage is $msg";
	     $display.= NL."success is $succ";
		$display.= NL."sessions are ";
		echo $display;
		print_r($_SESSION);
          }
     else {  
          if (empty($redirect)){  
               $redirect=(isset($_SESSION[Cfg::Owner.'page_referrer_1']))?$_SESSION[Cfg::Owner.'page_referrer_1']:'index.php'; 
               }
		if (Sys::Self==$redirect) {  
			$redirect=(isset($_SESSION[Cfg::Owner.'page_referrer_2'])&&$_SESSION[Cfg::Owner.'page_referrer_2']!=Sys::Self)?$_SESSION[Cfg::Owner.'page_referrer_2']:'index.php'; 
			}
          $mailinst=mail::instance();
          $msg=$msg.$succ;   
          $msg=str_replace(' ','%20',$msg); //for url
          $msg=str_replace('=','*equals*',$msg); #this replacement wont allow url to be further parsed in request::parse_request_url//for url
          $msg=str_replace('&','*and*',$msg); #this replacement wont allow url to be further parsed in request::parse_request_url//for url
          $url=$redirect.'?';
          $mailinst->mailwebmaster($success, $message,'',false);
          if ($display){
              $url=$url.'msg='.$msg;
              }
          if ($refresh){
              $url=$url.'refresh=1';
              }
          header("Location: $url");
          exit();
          }//not test
     }//end function post referrer redirect
     
static function home_redirect(){
	$url='http://'.Cfg::Site;
	header("Location: $url");
	exit();
	}
     
}
?>