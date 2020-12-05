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
class backup {
	protected $message=array();
	protected $success=array(); 
	private static $instance=false; //store instance
	protected  $page_fn='';
	const Testsite_restore=true;
	
function __construct($return=false){
    if ($return)return;
	$this->mailinst=mail::instance();
	$this->mysqlinst = mysql::instance();
    }
    
 function mail_backup_message(){   
    if (!(empty($this->message[0])&&empty($this->success[0]))){ 
	    $this->mailinst->mailwebmaster($this->success,$this->message);
	   }
    }
 
function render_backup($tablename){ 
	if (isset($_GET['iframepos']))return;// is iframe doing style/config  backup only
	//echo 'render back return full url: '.request::return_full_url() .' tablename: '.$tablename; exit();
	if (strpos($tablename,'_blog')){
		mail::alert('blogged in backup render');
		return;
		}  
	#set_time_limit(300);
	if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	$backupdelta=new time();
	$tables=check_data::return_pages(__METHOD__,__LINE__,__FILE__);
	if (in_array($tablename,$tables)){
		//$this->is_gall=false;
		$tablename=check_data::return_field_value(__METHOD__,__LINE__,__FILE__,Cfg::Master_page_table,$tablename,'page_ref','page_ref');
		$this->backupdb(Sys::Dbname,$tablename);//do for everybody
		}
	 	#THIS   WILL TAKE UPDATED DATABASE FROM PRIME DIRECTORY AND CREATE MASTER FILE TO BE USED FOR Sys::testSITE PAGES AUTOMATIC BACKUP SYSTEM!!!!!
	$this->mail_backup_message();
     if (Sys::Debug||Sys::Deltatime||Sys::Debug){
		$delta=$backupdelta->delta();
		echo NL. "time to render backup page is $delta seconds";
		}
	}
     
     #attention expandarray.js files are now obsolete
     #backup html is set out separately so it may be called by file_gen to backup all the tables and expand galleries with htmls and not do a full dbbackup
	# backup render is called only when submitted and then will backup a particlar table
	# filegen will backup all the tables using ?backupextension in the url which
	#edit_obj will read the ?backupextension and call backup_html_batch in situations where not submitted
	#  ?backupextension will not trigger a backup_gallery_global_db function call ($globalize is set to false) because nothing has been changed
	#the css files and javascript files except for jsexpandarray files are backuped everytime without a submit as well and globally backed up in database when submitted changes are made that
	#have expand in it and Cfg::Gallery_global is true...
	# 
	#as in file_generate::expand_file($tablename,$order);#if order supplied will only do one extra...
	#and file_generate::expand_js_array($tablename);#unction expand file to create new expand php class files.....
	#sessions_restoredb will take current main expandjs from main directory and copy it to testsite/includes
	#expandjs does not update with the filegenerator otherwise becasue not in testsite directory
	#when backing up with dbcopy using file-gen program it  updates with the bluehost copy into all active dbs and will replace the backup  copy with the bluehost copy of that dbase...


function ftp_sync(){
	if (defined('Cfg::Remote_user')&&defined('Cfg::Remote_pass')&&defined('Cfg::Remote_server')){
		$ftp=new ftp_files(); 
		$ftp->connect(Cfg::Remote_user,Cfg::Remote_pass,Cfg::Remote_server);
		$ftp->sync_editor_uploader();
		}
	}
     
function backupdb ($dbname=Sys::Dbname,$tablename='',$restoredate='',$restorefname=''){ if (Sys::Debug)  Sys::Debug(__LINE__,__FILE__,__METHOD__); if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	 if (!check_data::check_disabled('exec'))$command='exec';
	elseif (!check_data::check_disabled('system'))$command='system';
	else {
		$msg='Both system and exec commands necessary for automatically making backups and restoring them are disabled by php ini directive: disable_function which is set and can only be changed in the php.ini file(s). Remove either system or exec from the disable_function directive and automatic backups may be made.  Otherwise, manually backup you database from phpMyAdmin in your control panel or use the command line! This message in file '.__file__.' on line '.__line__;
		mail::alert($msg);//disable
		$this->message[]=$msg;//disable
		return;
		} 
	if (isset($_POST['page_restore_dbopt'])&&empty($restoredate))return;
	if (isset($_POST['page_restore_view']))return;
	if (isset($_GET['iframepos']))return;// is iframe doing style/config  backup only
     $table_backup=false;
	//exit($dbname.' is the dbname');
	if (!session::session_check('backed_full')){// do a full backup for first session visit
		session::session_create('backed_full');
		$tablename='';//set tablename to false to backup full database
		$tableback='';
		}
	else {
		$tableback=Cfg::Master_page_table.' '.Cfg::Master_post_table;
		}
	$tableback=($table_backup)?$tableback:'';
	$tablename=($table_backup)?$tablename:'';
	$restoredate=(empty($restoredate))?'':$restoredate;
	$restorefname=(empty($restorefname))?'':$restorefname;
	$backupfile= $dbname.$tablename . date("dMY-H-i-s") . Cfg::Db_ext.'.gz';
	$backupfileSql= $dbname.$tablename . date("dMY-H-i-s") . Cfg::Db_ext;
		$respathbackupfile=Cfg::Backup_dir.$backupfile;    if (Sys::Debug) echo  NL. Sys::Mysqlserver."mysqldump  -h ".Cfg::Dbhost." -u ".Cfg::Dbuser." -p".Cfg::Dbpass."  --ignore-table=$dbname.".Cfg::Backups_table." $dbname  $tableback | gzip --rsyncable > ".Cfg_loc::Root_dir.$respathbackupfile. ' is mysqldump';//--ignore-table=$dbname.".Cfg::Backups_table."
		$command(Sys::Mysqlserver."mysqldump  -h ".Cfg::Dbhost." -u ".Cfg::Dbuser." -p".Cfg::Dbpass."  --ignore-table=$dbname.".Cfg::Backups_table." $dbname  $tableback | gzip --rsyncable > ".Cfg_loc::Root_dir.$respathbackupfile);
		 //--ignore-table=$dbname.members --ignore-table=$dbname.login_attempting $dbname
		$fullpathbackupfile=Cfg_loc::Root_dir.Cfg::Backup_dir.$backupfile;
		if (file_exists($fullpathbackupfile)) {
			$file_sizer = filesize($fullpathbackupfile);  
			if ($file_sizer > 2000){  
				$q='insert into '.Cfg::Backups_table." (backup_filename,backup_date,backup_time,backup_restore_time,backup_data1,token) values ('$backupfile','".date("dMY-H-i-s")."','".time()."','$restoredate','$restorefname','".mt_rand(1,mt_getrandmax())."')"; 
				$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
				$count=$this->mysqlinst->count_field(Cfg::Backups_table,'backup_id','',false);
				if (!isset($this->backup_copies)){
					$store=store::instance();
					$this->backup_copies=(isset($store->backup_copies))?$store->backup_copies:$count+1;
					}
				if ($count>$this->backup_copies){
					$limit=($count>$this->backup_copies+5)?5:1;
					$q='SELECT backup_id FROM '.Cfg::Backups_table." ORDER BY backup_time ASC LIMIT $limit";
					$clean=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
					while(list($id)=$this->mysqlinst->fetch_row($clean)){
						$q='delete from '.Cfg::Backups_table." where backup_id=$id";
						$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
						}
					}
				$date= date("dMY-H-i-s");
				$this->success[]='DATABASE SUCCESSFULLY BACKED UP';
				$this->mailinst->user_info(); 
				$body =  $this->mailinst->OSB  .  $this->mailinst->TheIp;  
				$my_file =  $backupfile;
				$subject_append= (Sys::Logged_in) ? 'admin/owner':str_replace('.','-',$this->mailinst->TheIp);  
				$my_subject = $subject_append." backup database. $dbname"; 
				$my_message =  $body  . NL. "This is your backup  database attachment ".NL." database name= $dbname.$tablename ".NL. "backupfile = $backupfile".NL." sending page is ".Sys::Self. NL ;  
				if (Sys::Debug) { echo ' full path backup file is '.$fullpathbackupfile .'<br> filesize  is '. $file_sizer;}
				if (mail::Mail_send_backup===true) { 
				    $this->mailinst->mail_attachment($my_file, Sys::Home_pub.Cfg::Backup_dir, Cfg::Admin_email, Cfg::Mail_from, mail::Webmaster, Cfg::Mail_from, $my_subject, $my_message);
					}
				}
			else { //>300
				if (Sys::Debug) {echo 'gz file not found '.$fullpathbackupfile .'<br> filesize 2 is '. $file_sizer;}
				$this->message[]="backup failure: file not gzipped '.$fullpathbackupfile";
				}
			}
		else { //>3000
			if (Sys::Debug) {echo 'full path backup file is '.$fullpathbackupfile .'<br> filesize 2 is '. $file_sizer;}
			$this->message[]="backup failure: full path backup file is '.$fullpathbackupfile .'<br> filesize is '. $file_sizer";
			}
	    if (Sys::Debug) echo 'exiting backupdb';	    
    }//function backup
    

 

function backup_master_db(){return;if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);//this creates a single copy of latest backup master folder which is later used for backing up testsite master database also provides latest verion of database for all db's
	if (isset($_GET['iframepos']))return;// is iframe doing style/config  backup only
	$path=Sys::Home_pub.Cfg::Backup_dir.Cfg::Master_dir;
	$pathfile=$path.Sys::Dbname.Cfg::Db_ext;
	if (!is_dir($path)||!is_file($pathfile.$pathfile)){
		$this->message[]='path file probem in '.__METHOD__;
		return;
		}
	$dbname=Sys::Dbname;
	if (Sys::Debug)  echo NL. 'path for auto test restore is ' .$path;
	exec(Sys::Mysqlserver."mysqldump  ".Cfg::Dbhost." -u ".Cfg::Dbuser." -p".Cfg::Dbpass. "  ".Sys::Dbname ."  > ".$pathfile);
	if (Sys::Debug)echo NL."path restoredb is $path";
	}
    
 
 
function backup_url($tablename,$dir=Cfg_loc::Root_dir){exit('update render cache backup url');//use for caching which not being used 
	$fname=check_data::dir_to_file(__METHOD__,__LINE__,__FILE__,$tablename);
	if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);if (Sys::Debug) Sys::Debug(__LINE__,__FILE__,__METHOD__); 
	//$url_prefix=Sys::Home_site;  
	$url=$url_prefix.$fname.'.php?html&render_return'; //render_return prevents caching
	if (!copy ($url,Cfg_loc::Root_dir.$fname.'.html')){//make copy right in root directory
		$msg= "url: $url to folder to ".Cfg_loc::Root_dir.$fname.'.html';
		$msg.="problem in ".__METHOD__.__FILE__.__LINE__;
		mail::alert($msg,'Mail alert:backup copy problem');
		}
    #render set as php backupphp folder
    $url=$url_prefix.$fname.'.php?render_return';//render_return also used in contact_master to switch to form action=mailsend.php
    if (!copy ($url,Cfg_loc::Root_dir.Cfg::Backup_ext_folder.$fname.'.php')){//put html rendered php copy in backup directory
		$msg= "url: $url to folder to ".Cfg_loc::Root_dir.Cfg::Backup_ext_folder.$fname.'.php';
		$msg.="problem in ".__METHOD__.__FILE__.__LINE__;
		mail::alert($msg,'Mail alert:backup copy problem');//$out1=file_get_contents($url);
		}
     if (Sys::Debug)echo NL.'<p style="font-weight: bold; color:#'.Cfg::Info_color.';">YOU ARE BACKING UP THESE WEBSITE PAGES NOW</p>';
     return;	    
     }//end function

static function regen_backup_table($backnum){
	$newArray=array();
	$mysqlinst = mysql::instance(); 
	$mysqlinst->dbconnect(Sys::Dbname); 
	$match='*'.Cfg::Db_ext.'.gz';
	$path=Cfg_loc::Root_dir.Cfg::Backup_dir;
	$oldcwd = getcwd();
	chdir($path);
	$files = glob($match);
	chdir($oldcwd);
	foreach($files as $file){
		$newArray[]=array('file'=>$file,'filetime'=>filemtime($path.$file));
		}  
	process_data::array_sort_by_subval($newArray, 'filetime');
	$q="show tables like 'backups_db'";  
	$r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	if ($mysqlinst->num_rows($r)<1){//table ! exists
		$q="CREATE TABLE `backups_db` (
  `backup_id` int(11) NOT NULL AUTO_INCREMENT,
  `backup_filename` tinytext COLLATE utf8_bin NOT NULL,
  `backup_time` tinytext COLLATE utf8_bin NOT NULL,
  `backup_date` tinytext COLLATE utf8_bin NOT NULL,
  `backup_restore_time` tinytext COLLATE utf8_bin NOT NULL,
  `backup_data1` tinytext COLLATE utf8_bin NOT NULL,
  `token` tinytext COLLATE utf8_bin NOT NULL,
   PRIMARY KEY (backup_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;";  
		$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
		for ($i=0; $i < $backnum; $i++){
			$j=$i+1;
			if (!array_key_exists($i,$newArray))break;
			$backup=$newArray[$i];
			$time=$backup['filetime'];
			$date=date("dMY-H-i-s",$time);
			$q="INSERT INTO `backups_db` (backup_id,`backup_filename`, `backup_time`, `backup_date`, `backup_restore_time`, `backup_data1`, `token`) VALUES
	( $j,'".$backup['file']."','$time','$date','','','".mt_rand(1,mt_getrandmax())."')";
			$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); 
			}
		for ($i=$backnum; $i < count($newArray); $i++){
			$backup=$newArray[$i]['file'];
			unlink(Cfg_loc::Root_dir.Cfg::Backup_dir.$backup);
			}
		}
	else { 
		$oldArray=array();
		$q='select backup_filename, backup_time, backup_date, backup_restore_time, backup_data1 from '.Cfg::Backups_table;
		$r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
		while (list($fname,$time,$date,$restore,$data1)=$mysqlinst->fetch_row($r)){
			$oldArray[$fname]=array('time'=>$time,'date'=>$date,'restore'=>$restore,'data1'=>$data1);
			}
		$q='truncate '.Cfg::Backups_table;
		$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
		for ($i=0; $i < $backnum; $i++){
			$j=$i+1;
			if (!array_key_exists($i,$newArray))break;
			$backup=$newArray[$i];
			$file=$backup['file'];
			if (array_key_exists($file,$oldArray)){
				$obackup=$oldArray[$file];
				$restore=$obackup['restore'];
				$data1=$obackup['data1'];
				$time=$obackup['time'];
				$date=$obackup['date'];
				}
			else {
				$restore=$data1='';
				$time=$backup['filetime'];
				$date=date("dMY-H-i-s",$backup['filetime']);
				}
			$q="INSERT INTO `backups_db` (backup_id,`backup_filename`,  `backup_date`, `backup_time`,`backup_restore_time`, `backup_data1`, `token`) VALUES
	( $j,'$file','$date','$time','$restore','$data1','".mt_rand(1,mt_getrandmax())."')"; 
			$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); 
			}
		for ($i=$backnum; $i < count($newArray); $i++){
			$backup=$newArray[$i]['file'];
			unlink(Cfg_loc::Root_dir.Cfg::Backup_dir.$backup);
			} 
		}
	}
     
public static function instance(){ //static allows it to create an instance without creating a new object
    if  (empty(self::$instance)) {
	   self::$instance = new backup(); 
	   } 
    return self::$instance; 
    }
	    
}//end class
?>