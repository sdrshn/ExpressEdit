<?php  
class Cfg extends Cfg_master{
     const Time_zone='America/New_York';
    
	const Debug_backtrace=Cfg_master::Debug_backtrace;//For error logging backtrace...optionally refer to value set in Cfg_master.class.php or set true false here
	const Error_exit=Cfg_master::Error_exit;//if set to true exits following call to error_handler.php  exits on non fatal errors  optionally refer to value set Cfg_master.class.php or set true false here
	
     const Local_site='localhost,htdocs';//list to strpos local development systems if used
   	
     #the following class constants require changing..
     const Encrypt_pass='$%*)^RTtCVrr12';//use strong password this is used in secure_login
	 const Favicon='karma.ico';   
     const Owner   = 'yourname';//reference used in sessions, misc. 
     const Owner_dir='/';//if your not directly in the "public_html" directory specify the directory name..
     const Dbpass= 'mypass';  //latest mysqli requirement: specific at least 1 of each: uppercase, special characters  numeric
     const Dbuser = 'myusername';//enter your database user name
     const Dbhost='localhost';//typical setting
     const Dbname='yourdbnamehere';//enter your dbname
     const View_db='yourbackupdbnamehere';//set up database that backups can be imported to for viewing ie a copy of Dbname except used for backup restoration.. put name here
     const PrimeEditDir = 'eddirnameXXX/'; // acts as secondary password make unobvious
     const Site='www.yourSite.com/';//
     const Session_save_path='session_bgfhXaByzrt5';//specify your session save path directory .. may be specified in local Cfg.class.php  use no special characters 
     #**Contact+++++++++++
	const Admin_email='sample@hotmail.com,sample@yahoo.com';//error reporting   comma separate emails
	const Contact_email='sample@hotmail.com';//feedback list of comma separated emails 
	const Mail_from='site@site.com';//
	 ##Sizes of Page/Post Images
	 
	 
}
?>