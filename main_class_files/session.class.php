<?php
#ExpressEdit 2.0
class session {
public  $session_check=''; 
public $token; 
public $page_referrer_1='';
public $page_referrer_2='';
public $page_referrer_3='';
public $sess_var=0;
private static $instance; //store instance 

function sec_session_start() {
	$session_name = 'sec_session_id'; // Set a custom session name
	$secure = false; // Set to true if using https.
	$httponly = true; // This stops javascript being able to access the session id. 
	ini_set('session.use_only_cookies', 1); // Forces sessions to only use cookies. 
	$cookieParams = session_get_cookie_params(); // Gets current cookies params.
	session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly); 
	session_name($session_name); // Sets the session name to the one set above.
	session_start(); // Start the php session
	session_regenerate_id(true); // regenerated the session_id name, delete the old one.  keeps the session variables    
	}
	
function referrer(){    
     if (isset($_GET['iframepos']))return; #this file is from an iframe and need not be register
     if (isset($_SESSION[Cfg::Owner."filename"])) {  //create referrer reference for header redircect bypassing php::self submitting
          $this->page_referrer_1= $_SESSION[Cfg::Owner."filename"];
          if (isset($_SESSION[Cfg::Owner.'page_referrer_1'])){
               $this->page_referrer_2= $_SESSION[Cfg::Owner.'page_referrer_1'];
               if (isset($_SESSION[Cfg::Owner.'page_referrer_2'])){
                    $this->page_referrer_3= $_SESSION[Cfg::Owner.'page_referrer_2'];
                    }
               $_SESSION[Cfg::Owner.'page_referrer_2'] =$this->page_referrer_2;
               }
          $_SESSION[Cfg::Owner.'page_referrer_1'] =$this->page_referrer_1;
          }
     $_SESSION[Cfg::Owner."filename"]=$_SERVER["PHP_SELF"];  
     }
    
static function session_check($check) {
	if (isset($_SESSION[Cfg::Owner.$check]))return 1;
	return 0;  
	} 
   
function create_token() {
     $this->token = md5(uniqid(rand(), true));//microtime(); date("dMYHis");//
     $_SESSION[Cfg::Owner.'token'] =$this->sess_token= $this->token;  //make new token session for security form submissions
     }//end function token

static function session_batch_create($sess_name,$allon_arr='',$prefix=''){//creates session onload and sets return value to true  if request value is present
	if (isset($_GET[$prefix.'allon'])&&is_array($allon_arr)&&in_array($sess_name,$allon_arr)){ 
		$_SESSION[$prefix.Cfg::Owner.$sess_name]=true;
		return true;
		}
	if ((isset($_GET[$prefix.'alloff']))){
		unset($_SESSION[$prefix.Cfg::Owner.$sess_name]);
		return 0;
		}
     if (isset($_GET[$prefix.$sess_name.'off'])){
		unset($_SESSION[$prefix.Cfg::Owner.$sess_name]);
		return 0;
		}
	if (isset($_GET[$prefix.$sess_name])){
		$_SESSION[Cfg::Owner.$sess_name]=true;
		return true;
		}
	if (isset($_SESSION[$prefix.Cfg::Owner.$sess_name]))
		return true;
	return 0;	
	}

static function session_create($sess_name,$unset=false){//creates session onload and sets return value to true  if request value is present
     if($unset==false) 
          $_SESSION[Cfg::Owner.$sess_name]=true;
     else 
          unset($_SESSION[Cfg::Owner.$sess_name]);
     }

static function session_batch_create_value($sess_name,$prefix=''){//creates session onload and sets return value to value of request  if request value is present
	if (isset($_GET[$prefix.'allon'])){ 
		$_SESSION[Cfg::Owner.$sess_name]=true;
		return true;
		}
	if (isset($_GET[$prefix.'alloff'])||isset($_GET[$prefix.$sess_name.'off'])){
		unset($_SESSION[Cfg::Owner.$sess_name]);
		return 0;
		}
	if (isset($_GET[$prefix.$sess_name])){
		if (!empty($_GET[$prefix.$sess_name])){ 
			$_SESSION[Cfg::Owner.$sess_name]=$_GET[$prefix.$sess_name];
			return $_GET[$prefix.$sess_name];
			}
		else {
			$_SESSION[Cfg::Owner.$sess_name]=true;
			return true;
			}
		}
	if (isset($_SESSION[Cfg::Owner.$sess_name]))
		return $_SESSION[Cfg::Owner.$sess_name];
	return 0;	
	}
 
public static function instance(){ //static allows it to create an instance without creating a new object
    if  (empty(self::$instance)) {
	   self::$instance = new session(); 
        } 
    return self::$instance; 
    }
    
 }// ed class session
?>