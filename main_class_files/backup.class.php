<?php
/*
ExpressEdit is an integrated Theme Creation CMS
	Copyright (c) 2018  Brian Hayes expressedit.org  

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
	private $backup_clone_check='pub,blog_clone_table,blog_col,blog_order,blog_type,blog_table,blog_data2,blog_data3,blog_data4,blog_data5,blog_data6,blog_data7,blog_data8,blog_data9,blog_data10,blog_tiny_data1,blog_tiny_data2,blog_tiny_data3,blog_tiny_data4,blog_tiny_data5,blog_tiny_data6,blog_tiny_data7,blog_tiny_data8,blog_tiny_data9,blog_tiny_data10,blog_grid_clone,blog_style,blog_table_base,blog_global_style,blog_date,blog_width,blog_status,blog_unstatus,blog_clone_target,blog_target_table_base,blog_float,blog_unclone,blog_tag,blog_options';
	#blog_border_start,blog_border_stop,blog_grid_class,blog_gridspace_right,blog_gridspace_left,blog_grid_width,   //check effect
function __construct($return=false){
    if ($return)return;
	$this->mailinst=mail::instance();
	$this->mysqlinst = mysql::instance();
	$this->navobj=navigate::instance();//see line above  
   
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
	(Cfg_loc::Domain_extension=='')&&$this->backup_master_db();  
		   
	//self::ftp_sync();#upload html to external website..
	
	$this->mail_backup_message();
    #printer::alert_neu(NL.memory_get_usage(true) . " ".__LINE__. "is memory usage\n");
	// $this->clean_backups(Sys::Home_pub.Cfg::Backup_dir);
	 if (Sys::Debug||Sys::Deltatime||Sys::Debug){
		$delta=$backupdelta->delta();
		echo NL. "time to render backup page is $delta seconds";
		}
	 #printer::alert_neu(NL.memory_get_usage(true) . " ".__LINE__. "is memory usage\n");
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
	
function backup_html_batch($tablename, $globalize=false){
	return; //obsolete
	 
	  
	 if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	$this->backup_url($tablename);
	# because a changed gallery also needs updated expanded backup!! 
	if (check_data::check_gallery_master(__METHOD__,__LINE__,__FILE__,$tablename))return;
	$mastertablename=check_data::return_master_gall(__METHOD__,__LINE__,__FILE__,$tablename);
	//check that this is not master gallery as the expanded gallery_1 is taken care of presumbably in addgallerypic
	$this->backup_expand_html($tablename,Cfg_loc::Root_dir);//will backup the lot and make new jsfile
		 
	if ($mastertablename&&Cfg::Gallery_global&&$globalize&&(strpos(Sys::Self,'expandgallery')!==false)){ #globalize is false for file_generate as explained below
		$tables=check_data::return_gall_list(__METHOD__,__LINE__,__FILE__,$mastertablename);
	
			#this will actually delete and copy tablenameexpand  for database table expand field 1
			#this should only be done if gallery expand has been updated and submitted, not done as a file generator backup
			#this is because then and only then will the tablename will be a template for others...
			#this is why globalize is otherwise set to false by default 
		$this->backup_gallery_global_db($mastertablename,'expand',$tables);////clone tablename data (ie styles) to all tables in grouping...
			 
		}
	}
	
function backup_gallery_global_db($masterTablename,$ext,$tables=''){//clone tablename data (ie styles) to all tables in grouping...
	return;  //obsolete
	if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	if(!Cfg::Gallery_global)return; 
//print "$masterTablename is master tablename and the tables are: "; print_r($tables);
	$tables=(is_array($tables))?$tables:explode(',',$tables); 
	$tables[]=Cfg::Setup_table;#be sure to update the setup table with any new styling
	$field_array=explode(',',Cfg::Page_fields);
	foreach ($tables as $tablename){  
		if ($masterTablename==$tablename)continue;   
		$q='UPDATE '.Cfg::Master_page_table.' t, '.Cfg::Master_page_table.' r SET ';
		for ($x=0; $x<count($field_array); $x++){
		    (strpos($field_array[$x],'page_ref')===false)&&$q.=" t.{$field_array[$x]}=r.{$field_array[$x]},";
			}
		$q=substr_replace($q ,"",-1);
		$q.=" WHERE r.page_ref='$masterTablename$ext' And t.page_ref='$tablename$ext'";    
		$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
		}//end foreach; 
	}    


function backupdb ($dbname=Sys::Dbname,$tablename='',$restoredate='',$restorefname=''){ if (Sys::Debug)  Sys::Debug(__LINE__,__FILE__,__METHOD__); if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	if (isset($_POST['page_restore_dbopt'])&&empty($restoredate))return;
	if (isset($_POST['page_restore_view']))return;
	if (isset($_GET['iframepos']))return;// is iframe doing style/config  backup only

	$table_backup=false;
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
	//$tablename=$tableback='';
	$restoredate=(empty($restoredate))?'':$restoredate;
	$restorefname=(empty($restorefname))?'':$restorefname;
	$backupfile= $dbname.$tablename . date("dMY-H-i-s") . Cfg::Db_ext.'.gz';
	$backupfileSql= $dbname.$tablename . date("dMY-H-i-s") . Cfg::Db_ext;
		$respathbackupfile=Cfg::Backup_dir.$backupfile;    if (Sys::Debug) echo  NL. Sys::Mysqlserver.' is mysqlserver';//--ignore-table=$dbname.".Cfg::Backups_table."
		system(Sys::Mysqlserver."mysqldump  -h ".Cfg::Dbhost." -u ".Cfg::Dbuser." -p".Cfg::Dbpass."  --ignore-table=$dbname.".Cfg::Backups_table." $dbname  $tableback | gzip --rsyncable > ".Cfg_loc::Root_dir.$respathbackupfile);
		
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
function backup_get_parent($col_id,$ptable){return;
		//this collects nested column tree up to primary column  col_id's
		$q="select blog_col  from ".Cfg::Master_post_table." where blog_table_base='$ptable' and blog_data1='$col_id' and blog_type='nested_column'";
		$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
		if ($this->mysqlinst->affected_rows()){
			list($blog_col_id)=$this->mysqlinst->fetch_row($r);
			$this->coll_col_arr[]=$blog_col_id;
			self::backup_get_parent($blog_col_id,$ptable);
			}
		else $this->coll_col_arr[]=$col_id;
		return;// returned entire tree in form of coll_col_arr
	}
function backup_check_clone($backup_page_arr){return;
	if (isset($_GET['iframepos']))return;// is iframe doing style/config  backup only
	//we run back on tree cause if cloned elsewhere it could have been from any of the parent columns so we check..
	if (empty($backup_page_arr))return; 
	printer::vert_print($backup_page_arr);
	$backup=array();
	$backupclone=new time();
	$this->coll_col_arr=array();
	$backup_clone_check_arr=explode(',',$this->backup_clone_check);
	//so here we are tracing back to see if the column and post changes have cloned counterparts on other pages.  
	foreach ($backup_page_arr as $b_arr){
		if(Cfg::Columns_table===$b_arr[0]){//column query
			$q='select col_id,col_primary,col_table_base from '.Cfg::Columns_table.' '.$b_arr[1];
			$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
			if ($this->mysqlinst->affected_rows()){//will get original
				list($col_id,$col_primary,$ptable)=$this->mysqlinst->fetch_row($r);
				$this->coll_col_arr[]=$col_id;
				//if empty column is nested and get parent column in order to check for possibility that parent of this column was cloned on diff page..
				//recurse upwards..
				if (empty($col_primary))$col_arr=self::backup_get_parent($col_id,$ptable);//go up entire tree
				$value='';
				//here we gathering any pages that have targeted cloned column tree!
				foreach($this->coll_col_arr as $target){
					$value.="or col_clone_target='$target' ";
					}
				$value=substr($value,3,strlen($value));
				//now we gather pages based on original column query..
				$q="select col_table_base from ".Cfg::Columns_table." where ($value)  and (col_status='clone')"; 
				$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
				if ($this->mysqlinst->affected_rows()){
					while(list($page)=$this->mysqlinst->fetch_row($r)){
						$backup[]=$page;
						}
					}//affected 2
				}//affected 1
			}//col
		elseif(Cfg::Master_post_table===$b_arr[0]){
			$flag=false;
			foreach($backup_clone_check_arr as $field){
				if (strpos($b_arr[2],$field)!==false){
					$flag=true;
					$break;
					}
				}
			if (!$flag)continue;
			$q='select blog_id,blog_col,blog_table_base from '.Cfg::Master_post_table.' '.$b_arr[1];  
			$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
			if ($this->mysqlinst->affected_rows()){
				//here we checking if this blog post was directly cloned elsewhere
				list($blog_id,$blog_col,$ptable)=$this->mysqlinst->fetch_row($r);
				$q="select blog_table_base,blog_col from ".Cfg::Master_post_table." where blog_status='clone' and blog_clone_target=$blog_id";
				$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);   
				if ($this->mysqlinst->affected_rows()){ 
					//if cloned then gather the page name!
					while(list($page,$blog_col_id)=$this->mysqlinst->fetch_row($r)){
						$backup[]=$page;
						self::backup_get_parent($blog_col_id,$page);//check indirect lineage of cloned along cloned already  within  a cloned parent column as well!!
						}
					}//affected 2
				//here we gathering column tree of updated post to see if it was cloned
				self::backup_get_parent($blog_col,$ptable);//direct lineage check if columns containing changed field were cloned
				$value='';
				//foreach of the parent column tree check to see if cloned on different page
				foreach($this->coll_col_arr as $target){
					$value.="or col_clone_target='$target' ";
					}
				$value=substr($value,3,strlen($value));  
				$q="select col_table_base  from ".Cfg::Columns_table." where ($value)  and (col_status='clone')";  
				$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
				if ($this->mysqlinst->affected_rows()){  
					while(list($page)=$this->mysqlinst->fetch_row($r)){
						$backup[]=$page;
						}
					}//affected 2
				}//affected 1
			$q='select blog_table_base from '.Cfg::Master_post_data_table." where blog_id='p$blog_id'";
			$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
			if ($this->mysqlinst->affected_rows()){  
					while(list($page)=$this->mysqlinst->fetch_row($r)){
					$backup[]=$page;
					}
				}
			}//blog
		//we must also check if blog is clone_local_data positive which means that pages will be effected...
		
				 
		}//foreach
	$backup=array_unique($backup);
	$countback=count($backup);
	$array=array();
	foreach ($backup as $page){ 
		$q="select page_filename from ".Cfg::Master_page_table." where page_ref='$page' limit 1"; 
		$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
		if ($this->mysqlinst->affected_rows()){
			list($page)=$this->mysqlinst->fetch_row($r);
			$array[]=$page;
			 file_generate::render_backup_iframe($page.'.php',500,400); 
			}
			print_r($array);
		}//end foreach 
	$_SESSION[Cfg::Owner.'page_update_clones']= (isset($_SESSION[Cfg::Owner.'page_update_clones']))?array_unique(array_merge($_SESSION[Cfg::Owner.'page_update_clones'],$array)):$array;//add our new page filename listing to session array for update clone message and 
	//$delta=$backupclone->delta(); 
	//echo NL. "time to  backup clone data is $delta seconds";
	//(!empty($backup))&&store::setVar('backup_clone_refresh_cancel',true);
	}

function clean_backups($path,$match='',$delete=true){
	return;//Using different system now 30days=2500000
	if (isset($_GET['iframepos']))return;// is iframe doing style/config  backup only
	empty($match)&&$match='*'.Cfg::Db_ext;
	//date_default_timezone_set('America/New_York'); //make sure set
	//#this is now controlled by cron job to run once a week!
	 $newArray=array();  
	$files = glob($path.$match);  
	foreach($files as $file){ 
		$newArray[]=array('file'=>$file,'filetime'=>filemtime($file));
		}  
	
	process_data::array_sort_by_subval($newArray, 'filetime');
	 
	 $max=count($newArray); 
	for ($i=0; $i<$max-Cfg::Max_sql_backups; $i++){#will always keep at least this->max_backups backups
	  
		$gz_file_to_produce= $newArray[$i]['file'].date("dMY-H-i-s").".gz"; # printer::alert_neu(NL.memory_get_usage(true) . " ".__LINE__. "");
		$data = file_get_contents($newArray[$i]['file']);# printer::alert_neu(memory_get_usage(true) . " ".__LINE__. "");
		$gzdata = gzencode($data, 9);# printer::alert_neu(memory_get_usage(true) . " ".__LINE__. "");
		if(!file_put_contents($gz_file_to_produce,$gzdata)) echo 'Error gzipping files'. $$gz_file_to_produce .' in clean backups';
		else unlink($newArray[$i]['file']);
		}
	#clean gz files based on deleting files more than 30 and older than 60 days
	$newArray=array();
	$files = glob($path.'*.gz');  
	foreach($files as $file){ 
		$newArray[]=array('file'=>$file,'filetime'=>filemtime($file));
		}  
	
	process_data::array_sort_by_subval($newArray, 'filetime');
	 
	 $max=count($newArray); 
	 $pastdue=(time()-(Cfg::Max_gz_days*24*3600));  //not currently used
	for ($i=0; $i<$max-Cfg::Max_gz_backups; $i++){#deletes bases on number gz allowed over number days allowed
	     if( filemtime($newArray[$i]['file']) < $pastdue ){  
			unlink($newArray[$i]['file']);
			}
		}
	#clean logfile....
	if (!is_dir(Cfg_loc::Root_dir.Cfg::Logfile_dir))mkdir(Cfg_loc::Root_dir.Cfg::Logfile_dir);
	
	$file=$path.Cfg::Logfile_dir.Cfg::Log_file;  
	if (!is_file($file)){ 
		if (!file_put_contents($file,''))return;
		echo  'file for clean backups '.$file. 'was created' ;
		}
	$filesize=filesize($file); 
	#printer::alert_neu(NL.memory_get_usage(true) . " ".__LINE__. "is memory usage\n");
	if ($filesize>5000000){
		$delete=true;
	    if ($delete){
		    if (!unlink($file))mail::alert("problem unlinking $file");
		    else mail::alert( 'Large file deleted : '.$file. ' Too Big to gzip, file deleted in '.__METHOD__.__FILE__);
		    }
		else mail::alert( 'Large file problem with '.$file. ' Too Big to gzip in '.__METHOD__.__FILE__);
		}
	else	if ($filesize>600000){   
	    //any type of file 
		$gz_file_to_produce=$path.Cfg::Logfile_dir.'old_mylog'.date("dMY-H-i-s").".gz"; # printer::alert_neu(NL.memory_get_usage(true) . " ".__LINE__. "");
		$data = file_get_contents($file);# printer::alert_neu(memory_get_usage(true) . " ".__LINE__. "");
		$gzdata = gzencode($data, 9);# printer::alert_neu(memory_get_usage(true) . " ".__LINE__. "");
		if(!file_put_contents($gz_file_to_produce,$gzdata)) mail::alert('Error gzipping logfile  '. $$gz_file_to_produce .' in clean backups'); 
		if(!file_put_contents($path.Cfg::Logfile_dir.Cfg::Log_file,'Gzipped and regenerated  mylog.txt on '.date("dMY-H-i-s")))mail::alert('error in start new logfile/mylog.txt file');
	 
		}
	} 
 
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
	system(Sys::Mysqlserver."mysqldump  ".Cfg::Dbhost." -u ".Cfg::Dbuser." -p".Cfg::Dbpass. "  ".Sys::Dbname ."  > ".$pathfile);
	if (Sys::Debug)echo NL."path restoredb is $path";
	}
	
 
    
function restoredb($restorepath,$dbname=Sys::Dbname,$masterdb=''){#this is used for testsite... takes dbname and removes testsite from it involing master parent db
	return;
	$testsitename='';// not used 
	if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	if (Sys::Debug)  Sys::Debug(__LINE__,__FILE__,__METHOD__); 
	$masterdb=(empty($masterdb))?str_replace($testsitename,'',$dbname):$masterdb;
	$fullpathfile= $restorepath.$masterdb.Cfg::Db_ext;
	if (Sys::Debug){ 
	   echo NL.'<br>full path file of testsite restore'.$fullpathfile;
	   echo NL. '<br>restorepath is'. $restorepath;
	   echo NL. '<br> dbnametorestore'.  $dbname;
	   }  
    if (file_exists($fullpathfile)) {   if (Sys::Debug) echo' full pathfile exists in restoredb';
	   $file_size= filesize($fullpathfile);
	   if ($file_size > '1000'){     if (Sys::Debug)  echo 'filesize is '. $file_size;
		  $mysqlinst=mysql::instance();
		  $mysqlinst->drop_tables($dbname);#the idea here is to clean up tables first...
		

		system(Sys::Mysqlserver."mysql -h".Cfg::Dbhost." -u".Cfg::Dbuser." -p".Cfg::Dbpass." $dbname  < $fullpathfile");
		  if (Sys::Debug) echo NL.'this file was restored: '.$fullpathfile;
		  return (true);  
		  }//if filesize >
	   else $this->message[]='filesize is too small to pass in restoredb using '.Sys::Self;
	   if (Sys::Debug)echo 'filesize is too small to pass in restoredb using '.Sys::Self;
	   }//if file exists
    else  {
	   $this->message[]="Backup restoredb file does not exist using ".$fullpathfile;
	   } 
		
    }//end function
    
 
 
function backup_url($tablename,$dir=Cfg_loc::Root_dir){
	$fname=check_data::dir_to_file(__METHOD__,__LINE__,__FILE__,$tablename);
	if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);if (Sys::Debug) Sys::Debug(__LINE__,__FILE__,__METHOD__); 
	$prefix=(Cfg_loc::Domain_extension=="") ? '':Cfg_loc::Domain_extension.'/';
	$url_prefix=Sys::Home_site.$prefix;  
	#render set as asp file and menu extension
	$url=$url_prefix.$fname.'.php?html&render_return'; //render_return prevents caching
	//$out1=file_get_contents($url);   
	// file_put_contents(Cfg_loc::Root_dir.Cfg::Backup_ext_folder.$fname.'.html', $out1);   // complete asp version filename and menu for temporary redirect
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
   // file_put_contents(Cfg_loc::Root_dir.Cfg::Backup_ext_folder.$fname.'.php', $out1);   // create full php backup in subfolder
   //  file_put_contents(Cfg_loc::Root_dir.Cfg::Backup_ext_folder.$tablename.'.html', $out1);   // create html with php menu for caching purposes using render_return....
    if (Sys::Debug)echo NL.'<p style="font-weight: bold; color:#'.Cfg::Info_color.';">YOU ARE BACKING UP THESE WEBSITE PAGES NOW</p>';
    return;	    
    }//end function

function backup_expand_html($tablename,$dir=Cfg_loc::Root_dir ){return;
	//obsolete
	if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__); 
	if (Sys::Debug) Sys::Debug(__LINE__,__FILE__,__METHOD__); 
	# echo 'tablename is '.$tablename .' and you have made it too expand backback';  // $this->backup_expand_array($tablename,$order);// this will create javascript array update for expand gallery  which in turn calls
	  $gall_expand=check_data::return_field_value(__METHOD__,__LINE__,__FILE__,Cfg::Master_gall_table,$tablename,'gall_ref','gall_expand');
	if ($gall_expand!='expand')return;     
	if (check_data::check_gallery_master(__METHOD__,__LINE__,__FILE__,$tablename))return;
	if(!isset($_GET['backuphtml'])){#note that testsite will be backed up to this point...  appeneded in
		file_generate::expand_file($tablename); 
	 //file_generate::expand_js_array($tablename);#unction expand file to create new expand php class files..... outdated...
		}
	
	if (Cfg_loc::Domain_extension!='') return;#no need for this type of backup for foreign and testsite!!
	if (Sys::Debug)  echo NL.'<p style="font-weight: bold; color:#'.Cfg::Pos_color.';">YOU ARE BACKING UP THESE expanded GALLERY PAGES NOW</p>';
	$prefix=(Cfg_loc::Domain_extension=="") ? '':Cfg_loc::Domain_extension.'/';   
	$url_prefix=Sys::Home_site.$prefix;  if (Sys::Debug)  echo NL."url prefix is $url_prefix";  
	$this->mysqlinst->dbconnect(Sys::Dbname); 
	$maxcount=$this->mysqlinst->count_field(Cfg::Master_gall_table,'pic_order','',false,"Where gall_ref='$tablename'");
	//$tablename=arrayhandler::key_to_var_check($tablename);
	for ($i=1; $i<=$maxcount; $i++){
		if (!empty($order)){$i=$order;}//called in expandgallery to update all  ?backupall
		$url_file='expand-'.$tablename.'-'.$i;
		$url=$url_prefix.$url_file.'.php?html&render_return';  if (Sys::Debug)  echo NL."url is $url";//need to check if working and check render out///
		copy($url,Cfg_loc::Root_dir.Cfg::Backup_ext_folder.$url_file.'.html');
		
		//$out1=file_get_contents($url);    //get from outside
		//file_put_contents(Cfg_loc::Root_dir.$url_file.'.html', $out1); // complete html version in root directory
		 $url=$url_prefix.$url_file.'.php?render_return';  if (Sys::Debug)  echo NL."url is $url";//need to check if working and check render out///
		
		 copy ($url,Cfg_loc::Root_dir.Cfg::Backup_ext_folder.$url_file.'.php');//put html rendered php copy in backup directory
   //$out1=file_get_contents($url);    //get from outside
		//file_put_contents(Cfg_loc::Root_dir.Cfg::Backup_ext_folder.$url_file.'.php', $out1); // complete php version in backupphp folder
		//file_put_contents(Cfg_loc::Root_dir.Cfg::Backup_ext_folder.$url_file.'.html', $out1);   // create html with php menu for caching purposes using render_return....
		if (!empty($order))return;
		}//end for loop
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
	//print_r($newArray);
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