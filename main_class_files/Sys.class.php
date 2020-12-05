<?php
#ExpressEdit 3.01
/*
ExpressEdit is an integrated Theme Creation CMS
	Copyright (c) 2018   expressedit.org  

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <https://www.gnu.org/licenses/>.*/
  
#Note if you are using the advanced setup for one set of master classes to run multiple websites than read this.  Ideally you can put all your master classes common to all domains on the directory higher than the public_html, ie user home,  and change your php.ini include_path directive to indicate this. Otherwise if it is difficult to change your php.ini include_path  keep the Cfg_master.class.php and Sys.php files locally in the public_html/includes and for subdomains the subdomain dir/include folder and the proper autoload function will be generated.
#For simple straightforward setup put all master class include files in the public_html/includes and for subdomains the subdomain dir/include folder and the proper autoload function will be generated.
if (!empty(Cfg::Time_zone))
     date_default_timezone_set (Cfg::Time_zone); 
else date_default_timezone_set(date_default_timezone_get()); 
#Cfg classes used in autoloader to read editdirectory therefore preloaded.
if (!isset($_SERVER['HTTP_HOST'])||empty($_SERVER['HTTP_HOST']))
	trigger_error( 'System error in '.__FILE__.' accessing: $_SERVER[\'HTTP_HOST\']');
$edit=(strpos($_SERVER['SCRIPT_FILENAME'],Cfg::PrimeEditDir)!==false||strpos($_SERVER['SCRIPT_NAME'],Cfg::PrimeEditDir)!==false)?true:false;
$common_dir=(is_dir('./'.Cfg::Common_dir))?'./'.Cfg::Common_dir:((defined('PATHINC'))?PATHINC.Cfg::Common_dir:((is_dir(TWO_UP.Cfg::Common_dir))?TWO_UP.Cfg::Common_dir:((is_dir(ONE_UP.Cfg::Common_dir))?ONE_UP.Cfg::Common_dir:'unknown')));
if ($common_dir=='unknown'&&$edit)exit('Misconfiguration or missing/invalid path for '.Cfg::Common_dir.'  not found in Sys.php will affect file generation of common files and configs. Best to leave single copy around in public_html or User home dir which will serve multiple websites as needed.'); 
$loc=false;
$web=true; 

$bypass=false;
if (!empty(Cfg::Local_document_root)){  
	$localarr=explode(',',Cfg::Local_document_root);
	foreach ($localarr as $srvarr){
		$web=0;
		$loc=true;
		if (strpos(ONE_UP,$srvarr)===0){//  local development system
			$bypass=true;
			}
		}
	}
if ($edit) ini_set('memory_limit',Cfg::Memory_limit);//set in Cfg_master.class.php 
if ($edit) ini_set('max_execution_time',Cfg::Max_execution_time);//" 
if ($edit) ini_set('session.gc_maxlifetime', 10800);
if ($edit) ini_set('session.gc_probability', 1);
if ($edit) ini_set('session.gc_divisor', 100);  

#  ****** Initialize Sessions  *************
#sessions are used for back-up access, creating restricted pages, page user stats  and creating persistant info access when logged in as admin/Owner
//turn off  ob_start if default config has on
if (!isset($_SESSION)){ 
     $sessdir=Cfg_loc::Root_dir.Cfg::Session_save_path;
     if (!is_dir($sessdir))mkdir( $sessdir,0755);  
     session_save_path($sessdir); 
     }
#  ****** Initialize Sessions  *************
#sessions are used for back-up access, creating restricted pages, page user stats  and creating persistant info access when logged in as admin/Owner
if (!isset($_SESSION)){ 
	$sessdir=Cfg_loc::Root_dir.Cfg::Session_save_path;
	if (!is_dir($sessdir))mkdir($sessdir,0755);  
	session_save_path($sessdir); 
     if(Cfg::Secure_session){//go to secure mode...
          $sess->sec_session_start();  
          }
     else session_start();
     } 
if (isset($_REQUEST['session_destroy'])){
     session_destroy();  
     }
$sess=session::instance(); 
$sess->referrer();
$sess_auto=array('nobuffer','advanced','advancedoff','quietmode','error_no_exit','count','custom','clearoff','onsubmitoff','printoff','cssoff','norefresh','styleoff','mysql','server','tables','request','debug','session','gallery_info','methods','query','bufferoutput','includes','constants');//These are used as Sys::Constants
$sess_arr=array('secsubmitoff','defined','showlist');//these not used as Sys::constants
$allon_arr=array('norefresh','mysql','server','tables','request','debug','session','gallery_info','methods','query','includes'); //these will respond to ?allon request and turn on for debug info  and individually with with ?val  on and ?valoff  off..
$combine=array_merge($sess_auto,$sess_arr);
$logged_in=session::session_check('logged_in');
//must checkout whole editmode thing with render_html other requests to be true allows special $_REQUESTS to show info info
if(isset($_GET['advanced']))unset($_SESSION[Cfg::Owner.'advancedoff']); 
foreach($combine as  $val){
	$$val=0;
	if(($logged_in)&&in_array($val,$allon_arr)) $$val=session::session_batch_create($val,$allon_arr);
	else $$val=session::session_batch_create($val);
	}
$pass_web=array('viewdb','deltatime','info','deltatimepost');//Sys session vars that provide info  on non edit pages also
foreach($pass_web as  $val){
	$$val=0;
	$$val=session::session_batch_create($val,$allon_arr);//logged in not necessary
	}
$sess_auto=array_merge($sess_auto,$pass_web);
foreach ($sess_auto as $auto){ 
	$value=$$auto;  
	$uppervar=strtoupper($auto);
	define($uppervar,$value); // globals are defined, unset yet are still available to defins Sys::Const
	unset($GLOBALS[$uppervar]);// globals are defined, unset and YET are still available to defins Sys::Const
	}
$post_token=(isset($_SESSION[Cfg::Owner.'sess_token'])&&isset($_POST['sess_token'])&&$_POST['sess_token']===$_SESSION[Cfg::Owner.'sess_token'])?true:false;
$get_token=(isset($_SESSION[Cfg::Owner.'sess_token'])&&isset($_GET['sess_token'])&&$_GET['sess_token']===$_SESSION[Cfg::Owner.'sess_token'])?true:false;
//(!isset($_GET[Cfg::Owner.'sess_override']))&&
$sess->create_token();  
$onload=(empty($onload))?'':$onload;
if (isset($_SERVER['MYSQL_HOME'])&&!empty($_SERVER['MYSQL_HOME'])) 
	$mysqlserver=$_SERVER['MYSQL_HOME'];
elseif (!empty(Cfg::Mysqlserver)&&!is_dir(Cfg::Mysqlserver)) 
	$mysqlserver='';
else $mysqlserver=Cfg::Mysqlserver;
#**********check if this site is restricted  if so it will require login if live server and if restrict value = true in local check
$check_restricted=($web&&(strpos($_SERVER['PHP_SELF'],'file_gen.php')!==false||strpos($_SERVER['PHP_SELF'],'display_user_db.php')!==false))?true:false;//check if file should require admin login access 
if (isset($_GET['viewdboff'])){
     unset($_SESSION[Cfg::Owner.'dbname']);//view import page from external database
     unset($_SESSION[Cfg::Owner.'viewdb']);//viewing backup database
     }
$pass_class=(!isset($_GET['viewdboff'])&&($logged_in||($loc&&!Cfg::Force_local_login))&&((strpos($_SERVER['PHP_SELF'],Cfg::Pass_class_page)!==false&&isset($_SESSION[Cfg::Owner.'dbname']))||(isset($_SESSION[Cfg::Owner.'viewdb'])&&$_SESSION[Cfg::Owner.'viewdb']==true)||isset($_GET['viewdb'])))?true:false; 
$pass_class=(!isset($_POST['submit']))?$pass_class:false;  
$returnpass=(isset($_GET['returnpass']))?$_GET['returnpass']:'';
(isset($_GET['logout']))&&secure_login::logout(); //logout if requested
###   Note here we are detecting if local development system or live serveR
#first  check for local developement system for windows or linux 'var/www/
if ($debug)echo  "<br>\n".__LINE__ .' is line and file is '. __FILE__;
$testsite=0;//no longer used
$storeinst=store::instance();
$storeinst->msg=array();
$nl = "<br>\n";    
if(($logged_in||($loc&&!Cfg::Force_local_login))&&!isset($_GET['viewdboff'])&&((isset($_SESSION[Cfg::Owner.'viewdb'])&&$_SESSION[Cfg::Owner.'viewdb']==true)||isset($_GET['viewdb']))){
     $dbname=Cfg::View_db;
     }
elseif (($logged_in||($loc&&!Cfg::Force_local_login))&&strpos($_SERVER['PHP_SELF'],Cfg::Pass_class_page)!==false&&isset($_SESSION[Cfg::Owner.'dbname'])){
     $dbname=$_SESSION[Cfg::Owner.'dbname'];
     }
else $dbname=Cfg::Dbname; 
$gall_pic_path=Cfg_loc::Root_dir.Cfg::Small_thumb_dir;
$gall_pic_path2=Cfg_loc::Root_dir.Cfg::Large_image_dir;
$gall_pic_path3=Cfg_loc::Root_dir.Cfg::Master_thumb_dir;
$gall_vid_path=Cfg_loc::Root_dir.'video/';
$uploads_path=HOME_PUB.Cfg::Upload_dir; 
$docs=$_SERVER['DOCUMENT_ROOT'];  
$self= $_SERVER['PHP_SELF'];
$http_host=$_SERVER['HTTP_HOST'];//uRL REQUESSTED PUBLIC
//All Sys::Const are automatically defined. through the use of temporary Globals 
//Globals are defined by Cfg::Constants, Admin::Constants and the varibles defined above, then unset, then used to define Sys::Const;
//these are not sessions
//get_token,post_token,
$globs_2b='bypass,edit,get_token,post_token,returnpass,pass_class,common_dir,http_host,docs,self,logged_in,check_restricted,mysqlserver,testsite,loc,web,uploads_path,gall_vid_path,gall_pic_path,gall_pic_path2,gall_pic_path3,dbname';//these globals are not made into sessions and most become Sys::constants
$glob_arr=explode(',',$globs_2b);//transient global array
foreach($glob_arr as $glob){ 
	$value=$$glob;
	$uppervar=strtoupper($glob);
	define($uppervar,$value); // globals are defined, unset yet are still available to defins Sys::Const
	unset($GLOBALS[$uppervar]);// globals are defined, unset and YET are still available to defins Sys::Const
	} 	
define ('NL',$nl);// used as global for printing  line break
class Sys {
     const Bypass=BYPASS;
	const One_up=ONE_UP;
	const Two_up=TWO_UP;
	const Advanced=ADVANCED;//show advanced
	const Advancedoff=ADVANCEDOFF;//turn off advanced on by default! 
	const Info=INFO;//gives return url to editpages and gives viewport width
	const Edit=EDIT;
     const Constants=CONSTANTS;
	const Count=COUNT;
	const Viewdb=VIEWDB;
	const Clearoff=CLEAROFF;
	const Custom=CUSTOM;
	const Get_token=GET_TOKEN;
	const Error_no_exit=ERROR_NO_EXIT;
	const Post_token=POST_TOKEN;//for checking sess_token security between sender and reciever during post
	const Returnpass=RETURNPASS;
	const Pass_class=PASS_CLASS;//  no editing...
	const Common_dir=COMMON_DIR;  //A reposition of common files and vid dir used  for installing files to sub_domains
	const Logged_in=LOGGED_IN;//boolean whether logged in
	const Debug=DEBUG; //reports progress of rendering methods...
	const Check_restricted=CHECK_RESTRICTED;//Boolean LOGIN required to view user information on display pages! 
	const Nobuffer=NOBUFFER;//Boolean for no editpage ajax buffer
	const Bufferoutput=BUFFEROUTPUT;//Boolean ALL CONTENT GET OUTPUTTED TO bufferoutput.txt
	const Mysqlserver=MYSQLSERVER; // IF SELF IS TESTSITE BOOLEAN
	const Testsite=TESTSITE; // IF SELF IS TESTSITE BOOLEAN 
	const Web=WEB;   // live site BOOLEAN
	const Includes=INCLUDES;   // is  BOOLEAN
	const Loc=LOC;   // is local site  BOOLEAN
	//const Home_site=HOME_SITE; // url address web or local 
	const Uploads_path=UPLOADS_PATH;
	const Gall_vid_path=GALL_VID_PATH;
	const Gall_pic_path=GALL_PIC_PATH;
	const Gall_pic_path2=GALL_PIC_PATH2;
	const Gall_pic_path3=GALL_PIC_PATH3;
	const Deltatimepost=DELTATIMEPOST;
	const Deltatime=DELTATIME;
	const Dbname=DBNAME;
	const Tables=TABLES;
	const Server=SERVER;
	const Request=REQUEST;
	const Docs = DOCS;// Sys:Docs=server document root
	//const Pub=PUB;
	const Home_pub=HOME_PUB;#gives local root dir
	const Self=SELF;      //page file name   
	const Methods=METHODS;
	const Mysql=MYSQL;//give mysql query info etc.
	const Query=QUERY; 
	const Http_host=HTTP_HOST; //ACTUAL REQUESTED HOST
	const Onsubmitoff=ONSUBMITOFF;//TURN OFF BEFORESUBMIT JAVASCRIPT TO ALLOW ALL FIELDS TO POST
	const Quietmode=QUIETMODE;//silent turn off printer Styles to minimize output for debugging
	const Styleoff=STYLEOFF;//shut of all edit styles
	const Printoff=PRINTOFF;//Turn off Printer For Debug Analysis
	const Cssoff=CSSOFF;//shut off create new css file
	const Norefresh=NOREFRESH;//the system refreshes the page with a header redirect  use ?norefresh to prevent this for tracking errors
	const Style=true;// this is now simply set to true as not enough reason to turn off styling edit option for customers then  use request override for admin   
	const Session=SESSION;//FOR PRINTING OUT SESSIONS IF LOGGED IN
	static function includes() { //prints out included files for troubleshooting
		$files = get_included_files();
		$nl=NL;
		$indent =  '   ';
		 $tpl = "{$nl}included files = &#123;$nl%s$indent}$nl";
		$str = '';
	foreach($files as $spec) {  
		$str .= $nl.$spec;    
		}
	$str  = $nl.sprintf($tpl,$str).$nl;
	echo $str;
	} # php::includes()
	 
static function debug($lineno,$file="",$method="") { 
	echo NL."MOVING PAST: ";
	echo NL."file is ".$file;
	echo NL. "method is ".$method;
	echo NL.'called at line no: '.$lineno.'';
	echo NL;
	}
     
static function error_info($lineno,$file="",$method="") {
     $send= "php self is ".Sys::Self. NL."file is ".$file. NL. "method is ".$method;
     if ($lineno != false) $send.= NL.'called at line no: '.$lineno.'';
     return $send;
     }
     
}//end class Sys
 
$deltatime=time::instance(); (Sys::Deltatime)&&$deltatime->delta_log('Server Start: '); 
if ($showlist)echo <<<eol
<div class="editbackground editcolor left">Debugging information can be displayed through the use of requests. <br>  
?showlist prints out this list <br>  ']); 
the following requests provide the following information and persist for the current session unless turned off<br>
?showlistoff turns off  appending off to any info request turns it off
?allon  provides all available information<br> 
?alloff   all information rendered off<br> 
****for debugging and to determine script progress if error message not present <br> use ?debug  and/or ?methods<br> 
?methods     returns    method names  that the running classes have invoked <br>  ?debug...  <br> 
?debug    providest some loaded method info and  additional information   to determine what rendering error has occured<br> 
**************
?info  gives screen viewport size on when logged in on reg page<br> 
?constants  displays values of all the Sys::Consts<br> 
?styleoff  shuts off styles for easier html viewing and debugging<br> 
?gallery_info  parameters surrounding gallery rendering<br> 
?cacheon  returns  caching to On (going to edit pages turns it off) <br>
?server gives server printout<br/ >
?tables    gives request and session printout<br>
?session print session  info    print session  info  .<br>
?session_destroy    kill all sessions<br>
?includes   returns included files   unless script error: if error use ?debug and ?methods  <br>  
?query    returns request query called by global_master header for every page! <br>  
?deltatime    time rendering <br>
?deltatimepost concise list of post time rendering
?request    gives \$_POST and \$_GET  printout <br>  
?bufferoutput  buffers entire page and echo's at end...<br>
?mysql output of mysql queries,etc.
individual requests may be turned off by appending off to the request  ie  ?queryoff
</div>
eol;
#define instances and vars for utility scripts not used directly  in the main global master class b 
$mailinst=mail::instance();
$navobj=navigate::instance();//for local scripts   class version will be called.
new errors();
$mysqlinst = mysql::instance();
$message=array(); 
$success=array();
if ($debug) echo NL.'exiting sys.php';
if ($debug)echo NL.'deltatime end of Sys is '.$deltatime->delta();
if ($debug)echo NL. __LINE__ .' is line and file is '. __FILE__; 
#*********   End Session initialize ***
#control sessions:
# Token  is turned on when $sess->token variable is present in request..  token is a long string password generated in each session so provides a security key that can be employed for  various uses
#***************debugging to screen infor ************************************888
#To access debugging info you must be logged in
# OR in cases where an error occurs before logging in is possible 
#  turning on debugging informatin to screen   will last for sessions (till the browser is completely closed)  or enter  the url request ?alloff 
# debug info proceedure
#Login   OR 
#for example your can use   yoursite.com?methods   and methods will report being intitiated in order...
# yoursite.com?sessionoff  and session info will stop rendering
#  yoursite.com?allon   and all  information keys will be turned on
#yoursite.com?alloff and all informatin keys will be turned off    
#use  yoursite.com?showlist for a complete list of debugging information
#*****************************************End*************************8
#Below various information variables are defined as Boolean session variables based on whether present in a request
	
?>