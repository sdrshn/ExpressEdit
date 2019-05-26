<?php
#ExpressEdit 2.0
class Cfg extends Cfg_master{
     const Favicon='karma.ico';//tab image
     const Debug_backtrace=Cfg_master::Debug_backtrace;//For error logging backtrace...optionally refer to value set in Cfg_master.class.php or set true false here
	const Error_exit=Cfg_master::Error_exit;//if set to true exits following call to error_handler.php  exits on non fatal errors  optionally refer to value set Cfg_master.class.php or set true false here
	const Local_site='localhost,htdocs';//list to strpos local development systems if used   local sites do not require logon..
   	#the following class constants require changing..
     const Encrypt_pass='$%*)^RTtCVrr12';//use strong password this is used in secure_login
	const Owner   = 'yourname';//reference used in sessions, misc. 
     const Owner_dir='/';//if your not directly in the "public_html" directory specify the directory name..  ie 'subdomainname/'
     const Dbpass= 'mypass';  //latest mysqli requirement: specific at least 1 of each: uppercase, special characters  numeric
     const Dbuser = 'myusername';//enter your database user name
     const Dbhost='localhost';//typical setting
     const Dbname='yourdbnamehere';//enter your dbname
     const View_db='backupDb';//set up database that backups can be imported to for viewing ie a copy of Dbname except used for backup restoration.. put name here
     const PrimeEditDir = 'eddirnameXXX/'; // acts as secondary password make unobvious to prevent login attemps
     const Site='www.yourSite.com/';//used in emails to delete unwanted comments or publish them..
     const Session_save_path='session_bgfhXaByzrt5';//specify a unique session save path directory ..  use no special characters 
     ###################
     #**Contact+++++++++++
	const Admin_email='sample@hotmail.com,sample@yahoo.com';//error reporting   comma separate emails
	const Contact_email='sample@hotmail.com';//notice of comment feedback list of comma separated emails also used if contact form emails are not set. 
	const Mail_from='site@site.com';//optionally put a return mail from address.
     ##Sizes of Page/Post Images
	 
	 
}
?>