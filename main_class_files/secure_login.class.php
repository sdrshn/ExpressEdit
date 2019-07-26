<?php
#ExpressEdit 2.0.4
#based on Larry Ullman php5 & 6 writings
    
class secure_login {
     protected $login_msg='';
     private $registration='true';
     private $register=false;

function __construct($login_type, $register=false){
	if (isset($_GET['logout']))secure_login::logout(); 
	$this->login_type=$login_type;
	$this->rc4 = new encrypt;//decode the hashed password
	$this->mysqli= mysql::instance(); 
	$this->dbc=$this->mysqli->dbconnect(); 
	//self::sec_session_start();  
	(isset($_GET['genuserinfo']))&&self::get_salt($_GET['genuserinfo'],$login_type);
	(isset($_GET['logout']))&&self::logout();
     if (!isset($_SESSION[Cfg::Owner.'logcheck']))$_SESSION[Cfg::Owner.'logcheck']=process_data::create_token(20);
	if ($register&&isset($_GET['registration'])&&$login_type!=='ownerAdmin'){ 
		self::registration('Create your new login account  registration information:');
		exit();
		}
	if(isset($_POST['user'], $_POST['p'])) {  
		$user = $_POST['user'];
		$password = $_POST['p']; // The hashed password.
		if(self::login($user, $password) == true) {
			$_SESSION[Cfg::Owner.'logged_in']=1;
			return;//which will allow page to render
			}
		else {
			unset($_SESSION[Cfg::Owner.'logged_in']);
			self::render_login_form('Error Logging In!'); exit();		//give login again....
			}
		}
	//no login parameters
	if ($this->login_type==='ownerAdmin'){  
		if ($stmt=$this->mysqli->prepare("SELECT count(id) AS count_id  FROM members WHERE   login_type = ?")) { //  
			$stmt->bind_param('s', $this->login_type); // Bind "user" to parameter.
			$stmt->execute(); // Execute the prepared query.
			$stmt->store_result();
			$stmt->bind_result($count); // get variables from result.
			$stmt->fetch();
			if ($count<1){ 
				self::registration('Please setup your new login credentials to enable editing of this site');
				exit();
				}
			elseif ($count>1) {
				mail::alert('Mulitple Users Secure login','Multiple Users');
				exit('User Account Problem');
				}
			}
		}
	if(self::login_check()===true){  
		return;// all is well so let the page render.....
		}
	else	{
		unset ($_SESSION[Cfg::Owner.'logged_in']);
		$this->login_msg= 'This edit site requires a login user name and password!';
		self::render_login_form(); exit();	
		}
	}
 
function get_salt($user,$login_type){
	if ($stmt=$this->mysqli->prepare("SELECT salt FROM members WHERE login_type = ? AND username = ? LIMIT 1")) { 
		if (!$stmt->bind_param('ss', $login_type, $user)) {
			echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
			} 
		$stmt->execute(); // Execute the prepared query.
		$stmt->store_result();
		$stmt->bind_result($salt); // get variables from result.
		$stmt->fetch();
		if($stmt->num_rows != 1) { 
			self::render_login_form('Invalid Login Attempt!!'); 
			exit();
			}// The hashed password from the form
		exit("trsfu=$salt");
		}//end prepare
	}
/*
This function makes your login script a whole lot more secure. It stops hackers been able to access the session id cookie through javascript (For example in an XSS attack).
Also by using the "session_regenerate_id()" function, which regenerates the session id on every page reload, helping prevent session hijacking.
Note: If you are using https in your login application set the "$secure" variable to true.
2Create Login Function.
This function will check the email and password against the database, it will return true if there is a match.
Secure Login Function:
$rc4 = new encrypt; 
$thestring = $rc4->endecrypt($thepasswd,$thestring); 
echo $thestring;
$thestring = $rc4->endecrypt($thepasswd,$thestring,'de'); */ 

function login($user, $password) {  
   // Using prepared Statements means that SQL injection is not possible.
     (!isset($_SESSION[Cfg::Owner.'session_salt']))&&exit('BROWSER COOKIES MUST BE ENABLED TO ALLOW LOGIN ACCESS FOR ACTIVE SESSIONS and may have timed out and needs page refresh');
     $num=self::checkbrute();
     if($num>1) {
          mail::alert('login attempts locked_out','Log In Locked Out');
          exit("too many login attempts try again in $num minutes or reset password");
		}
	if ($stmt=$this->mysqli->prepare("SELECT id, password  FROM members WHERE username = ? AND login_type = ?  LIMIT 1")) { //  
		$stmt->bind_param('ss', $user,$this->login_type); // Bind "user" to parameter.
		$stmt->execute(); // Execute the prepared query.
		$stmt->store_result();
		$stmt->bind_result($user_id, $db_password); // get variables from result.
		$stmt->fetch();
		$db_password = hash('sha512', $this->rc4->endecrypt(Cfg::Encrypt_pass,$db_password,'de').$_SESSION[Cfg::Owner.'session_salt']); // nhashing with the session_salt created in the form rendering...
		if($stmt->num_rows == 1) { 
			if($db_password == $password) { // Check if the password in the database matches the password the user submitted. 
			  // Password is correct!
				$ip_address = $_SERVER['REMOTE_ADDR']; // Get the IP address of the user. 
				$user_browser = $_SERVER['HTTP_USER_AGENT']; // Get the user-agent string of the user.
				//$user_id = preg_replace("/[^0-9]+/", "", $user_id); // XSS protection as we might print this value
				$_SESSION[Cfg::Owner.'user_id'] = $user_id; 
				//$username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username); // XSS protection as we might print this value
				 $_SESSION[Cfg::Owner.'login_string'] = hash('sha512', $password.$ip_address.$user_browser.$this->login_type);
				 return true;    
			    }
			else if($num=self::checkbrute()>1) { 
                    
				exit("too many login attempts try again in $num minutes");
				}
			else { 
				$now = time();
				 if ($stmt=$this->mysqli->prepare("INSERT INTO login_attempting (user_id, time, salt,lockout) VALUES (?, '$now','".$_SESSION[Cfg::Owner.'logcheck']."','')")) {  
					$stmt->bind_param('s', $user_id); 
					// Execute the prepared query.
					$stmt->execute();
                          
					$valid_attempts =  (.33 * 60 * 60);
					$q="DELETE FROM `vwpkbpmy_secure_login`.`login_attempting` WHERE `login_attempting`.`time` < ($now-$valid_attempts)"; 
					$this->mysqli->query($q,__METHOD__,__LINE__,__FILE__,false);
					self::render_login_form('Invalid Login Attempt!!');exit();
					}
				}
			}	
		else {// If the user does not exists
               $now = time();
               if ($stmt=$this->mysqli->prepare("INSERT INTO login_attempting (user_id, time, salt,lockout) VALUES ('1000', '$now','".$_SESSION[Cfg::Owner.'logcheck']."','')")) {    
                   // Execute the prepared query.
                   $stmt->execute(); 
                   $valid_attempts =  (.33 * 60 * 60);
                   $q="DELETE FROM `vwpkbpmy_secure_login`.`login_attempting` WHERE `login_attempting`.`time` < ($now-$valid_attempts)"; 
                   $this->mysqli->query($q,__METHOD__,__LINE__,__FILE__,false);
                   }
			 self::render_login_form('Invalid Login Attempt!!');exit();
			}
		} //end statement prepare
	else {
		$msg='mysql problem in secure loggin';
		echo $msg;
		}
	}
  
//Create login_check function:
function login_check() {  
	// Check if all session variables are set
	if(isset($_SESSION[Cfg::Owner.'user_id'],  $_SESSION[Cfg::Owner.'login_string'],$_SESSION[Cfg::Owner.'session_salt'])) {  
		$user_id = $_SESSION[Cfg::Owner.'user_id'];
		$login_string = $_SESSION[Cfg::Owner.'login_string'];
		$ip_address = $_SERVER['REMOTE_ADDR']; // Get the IP address of the user. 
		$user_browser = $_SERVER['HTTP_USER_AGENT']; // Get the user-agent string of the user.
		if ($stmt=$this->mysqli->prepare("SELECT password FROM members WHERE id = ? LIMIT 1")) { 
			$stmt->bind_param('i', $user_id); // Bind "$user_id" to parameter.
			$stmt->execute(); // Execute the prepared query.
			$stmt->store_result();
	   
			if($stmt->num_rows == 1) { // If the user exists
				$stmt->bind_result($password); // get variables from result.
				$stmt->fetch();
				$login_check = hash('sha512', hash('sha512', $this->rc4->endecrypt(Cfg::Encrypt_pass,$password,'de').$_SESSION[Cfg::Owner.'session_salt']).$ip_address.$user_browser.$this->login_type);
				if($login_check == $login_string) {
				   // Logged In!!!!
					return true;
					}
				else {
					// Not logged in
					return false;
					}
				}
			else {
				// Not logged in
				return false;
				}
			}
		else {
			// Not logged in
			return false;
			}
		}
	else {
		// Not logged in
		return false;
		}
	}

function checkbrute() {
	// Get timestamp of current time
	$now = time();
     $wait=.33*60*60; //seconds of wait..
	// All login attempts are counted from the past 1 hours. 
	$valid_attempts = $now - $wait; 
	$q="select time,salt from login_attempting where lockout='locked_out' and time  > '$valid_attempts' and salt='".$_SESSION[Cfg::Owner.'logcheck']."'";     
     $r=$this->mysqli->query($q,__METHOD__,__LINE__,__FILE__,false);
     if ($this->mysqli->affected_rows()){ 
          list($time)=$this->mysqli->fetch_row($r);
          $timeleft=round(($time+$wait-$now)/60,1);    
          return $timeleft;
          } 
     #first we check if locked out then we if we need to lockout
	$q="SELECT time FROM login_attempting WHERE  time > '$valid_attempts'"; 
     $r=$this->mysqli->query($q,__METHOD__,__LINE__,__FILE__,false); 
     if ($this->mysqli->num_rows($r) > 5) {  
          $q="insert into login_attempting (user_id, time, salt,lockout) VALUES (1000, '$now','".$_SESSION[Cfg::Owner.'logcheck']."','locked_out')"; 
          $this->mysqli->query($q,__METHOD__,__LINE__,__FILE__,false);
          return $wait/60;
          }
     else {
          return false;
          }	
		 
	}
/*
Registration Page.
To create the password hash you will need to use the following code:

Hash Script:
*/
// The hashed password from the form
function registration($regmsg=''){//retrieves registration information and passes to database....
	$self=Sys::Self;//to circumvent repeating get request
	$jsdir=Cfg_loc::Root_dir.'sha512.js'; 
  	if(isset($_POST['user'], $_POST['regp'],$_POST['email'])) {
		$q="SELECT count(username) AS count_user FROM members WHERE   login_type = '$this->login_type' LIMIT 1"; //
		$r=$this->mysqli->query($q,__METHOD__,__LINE__,__FILE__,false);	 
		if (!$this->mysqli->affected_rows()) {
			mail::alert('problem with registration retrieval', 'registration difficulty');
			exit();
			}// The hashed password from the form
		$row=$this->mysqli->fetch_assoc($r,__LINE__);
		$count=$row['count_user'];
		if (!empty($count)){ 
			self::registration('This username is taken.  Please choose another'); exit();
			}
		$user = $_POST['user'];
		$password = $this->rc4->endecrypt(Cfg::Encrypt_pass,$_POST['regp'],'en');  
		$email=$_POST['email'];
		$stmt =$this->dbc->stmt_init();
		if ($stmt->prepare("insert into members (login_type,username,email,password,salt) values (?, ?, ?, ?, ?)")) { 
			$stmt->bind_param('sssss',$this->login_type, $user, $email, $password, $_SESSION[Cfg::Owner.'salt']); 
			// Execute the prepared query.
			$stmt->execute();
			}
		//$this->mysqli->query("INSERT INTO members (login_type,username,email,password,salt) VALUES ('$this->login_type','$user', '$email','$password','$salt')");
		self::render_login_form('registration completed: now please login');exit();
		}			
	$salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
	$_SESSION[Cfg::Owner.'salt']=$salt;  
	$html=<<<eol
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Registration Request </title>
<script type="text/javascript" src="$jsdir"></script>
<script type="text/javascript">
    function formhash(form, password,password2) {
    if (password.value != password2.value){
	alert('passwords do not match '+password.value+' and '+password2.value);
	return false;
	}
	  var regp = document.createElement("input");
	  var formation=
	  form.appendChild(regp);
	  regp.name = "regp";
	  regp.type = "hidden";
	  regp.value = hex_sha512(password.value +'$salt');
	   password.value = "";
	  form.submit();
	}
    </script>
</head>
<body>
<div>
<form action="" method="post" name="login_form">
<p>$regmsg</p>
 <p>  Username: <input type="text" name="user" autofocus ><br>
    Your Email: <input type="text" name="email" ><br>
   <input type="hidden" name="registration" value="true"><br>
   Password: <input type="password" name="password" id="password"><br>
   Repeat password:  <input type="password" name="password2" id="password2">
   <input type="button" value="Login" onclick="formhash(this.form, this.form.password, this.form.password2);" ></p>
</form>
</div>
</body>
</html>
eol;
     echo $html;
     }//end function

function render_login_form($error=''){//error message
     $gotowebpage=
	$jsdir=Cfg_loc::Root_dir.'sha512.js';
    // Create a random salt
	$session_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));  
	$_SESSION[Cfg::Owner.'session_salt']=$session_salt; 
	//send the salt to the javascript in the browser.. apend it the password to be hashed...
	//use the heredoc syntax to send to sent javascript to the browser...
     $register_msg=($this->register)?'<a href="'.Sys::Self.'?registration">Or Register Here</a>':'';
     $html=<<<eol
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Log On Request</title>
<script type="text/javascript" src="$jsdir"></script>
<script type="text/javascript">
<!--
function submitenter(myform, password,user,e){
	var keycode;  
	if (window.event) keycode = window.event.keyCode;
	else if (e) keycode = e.which;
	else return true;

	if (keycode == 13){
		initForm(myform, password, user, e);
		return false;
		}
	else
	return true;
	}
var ax = false;
     if (window.XMLHttpRequest) {
          ax = new XMLHttpRequest();
          try {
               ax = new ActiveXObject("Msxml2.XMLHTTP");
               }
          catch (e1) {
               try {
                         ax = new ActiveXObject("Microsoft.XMLHTTP");
                    }
               catch (e2){
                     }
               }
function initForm(form, password,user) {
          var u=document.URL; var x=u.split("?");
          ax.open("get",x[0]+'?genuserinfo=' + user.value);
          ax.onreadystatechange = function(){hashform(form,password);}
          ax.send(null);
          return false;
          }
     }
function hashform(form,password){
	if ( (ax.readyState == 4) && (ax.status == 200) ) {
		if (ax.responseText.length > 10) {
			var s = ax.responseText.split("trsfu=");  
			password.value=(password.value).replace(/\s+/g,'');  
			var p = document.createElement("input");
			form.appendChild(p);
			p.name = "p";
			p.type = "hidden";  
			p.value = hex_sha512(hex_sha512(password.value +s[1])+'$session_salt');
			 password.value = "";
			form.submit();
			}
		}
	}
   //-->
</script>
</head>
<body>
<div>
$this->login_msg 
$error 
<form action="" method="post" name="login_form">
 <p>  Username: <input type="text" name="user" id="user" autofocus ><br>
   Password: <input type="password" name="password" id="password"  onKeyPress="return submitenter(this.form, this.form.password, this.form.user,event);"><br>
   <input type="button" value="Login"  onclick="initForm(this.form, this.form.password, this.form.user);" ></p>
</form>
$register_msg
<br><a href="../index.php">Go to Webpage mode</a>
</div>
</body>
</html>
eol;
     echo $html;
     }//end render_login_form

static function logout(){  
	$_SESSION[Cfg::Owner.'user_id']= $_SESSION[Cfg::Owner.'login_string']='';
	echo('you have been logged out');
	session_destroy();
	exit();
	}

}//end class

?>