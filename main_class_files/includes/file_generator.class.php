<?php
class file_generator extends file_generate{
protected static $count_it=0;
  //onsubmit="return confirm(\'' .$msg. ' do you wish to proceed?\');"  $msg ='You have chosen to clone '.Cfg::Owner. ' database to testsite and foreign Arrays'; $msg=  'You have chosen to update css  info'; $msg= 'You are generating new files based on tablenames from Root directory..  Will also update testsite and foreign databases';
protected $file=false;
protected $style=false;
protected $blog_temp='';
protected $up_size='1800';
function __construct($return=false){  
	
	 if(!$return===false)return;
	   set_time_limit(500); 
	   if (isset($_REQUEST['photo_submit'])) { 
		  include_once ('includes/photo_batch_resize.class.php');
		  $image_resize=new photo_batch_resize();
		 if(isset($dbname)) $image_resize->dbname=$dbname;
		  $image_resize->build();
		  return;
		  }
	   if (isset($_REQUEST['image_dir'])) { 
		  include_once ('includes/image_directory.class.php');
		  $image_resize=new image_directory();
		  $image_resize->dbname=$dbname;
		  $image_resize->build();
		  return;
		  }
	   include ('includes/Cfg_master.class.php');
	   include ('includes/Cfg.class.php');
	   $cfg_included=true;//for prevent includes Cfg in Sys.php
	   self::config_gen_init();//this is done first in case...  for primordial file generation of config files....   
	   include ('includes/Sys.php');
        
	 echo '
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
<title>File Gen</title>
<style type="text/css">
body {color:white;background:black;}
table, td, th {border: white 1px solid;line-height:155%;}
t
.editcolor{color:white;}
.editbackground{background:black;}
</style>
<script  type="text/javascript">
 <!--
 function displaythis(displaydoc){
 document.getElementById(displaydoc).style.display="block";
 	}
 -->
 </script>
</head>
<body>';
     if   (Sys::Check_restricted){
           
		 new secure_login('ownerAdmin',false); //for access to editpages  
		}// 
	  (Cfg_loc::Domain_extension!='')&& exit('This program is meant to run in root directory!');
	   
	$msg1='File Generate htdoc local from Tables, Css, Js Generate';
	$msg2='New Css  Generate and Backup Gen Html Htm and Php files';
	$msg3='Clone BHMaster Local to active db\'s copy to testsite and/or foreign dbs';
	$msg3B='Clone All Server Dbs to BHMaster Local';
	$msg4='Modify Dbfields for data page structure: Create new configuration of '.Sys::Dbname; 
	$msg5='Scrub all data'; 
	$msg6='Echo Data Fields in all Tables';
	$msg7='Update  specific  fields in Gallery';
	$msg8='Resize Images';
	$msg9='Image Directory';
	$msg10='backup Folder';
	$msg11='backup Documents';
	$msg12='backup Includes/bash';
	$msg13='backup htdocs';
	$msg14='backup Music';
	$msg15='backup Test';
	$msg16='backup Patents';
	$msg17='backup fdrive';
	$msg18='backup xampp';
     $msg18='Query Sql : specify database';
     $msg20='Generate the cache';
	$msg21='backup Downloads';
	$msg22='Export Local Database';
	$msg23='Import Local Database';
	$msg24='Update Page Class. <span style="font-size:8px;background:white; color:red">Caution: will overwrite any custom modifications directly made in class files ie. indexpage.class.php</p>';
	$msg25='Disc Space Managment: Limit Uploaded Images to '.$this->up_size.'px';
	
	
	$block=(!empty($this->block_temp))?$this->block_temp:Cfg::Exclude; //$block='';
	$block_arr=explode(',',$block);
	$this->block_dir=arrayhandler::arraytolower($block_arr); 
	//printer::vert_print($array);
	echo  NL. "block_file array is $block";
	if(isset($_REQUEST['submitted'])){ 
		if (isset($_REQUEST['choose'])){
    
		   
			   if ($_REQUEST['choose']=='file_generate_all'){echo 'Generating files  All Directories';  //this uses $_GET['choose'] = file_generate request!!!
				   $this->file=true;
				   self::file_generate_all();
				   }
			   if ($_REQUEST['choose']=='file_generate'){echo 'Generating files';
				   $this->file=true;
				   self::file_generate(false,true,false);
				   }
			   if($_REQUEST['choose']=='css_update') { echo 'Generating Css';
				   self::file_generate(true,false,false);
				   }
			   if($_REQUEST['choose']=='cache') { echo 'Generating Cache';
				   self::file_generate(false,false,true);
				   }
			    if ($_REQUEST['choose']=='db_upload') {echo 'Cloning master dbase';
				   self::db_upload();   
				   }
			   //if ($_REQUEST['choose']=='db_copy_server') {echo 'Cloning Server dbase';
				   //self::db_copy_server();   
				   //}
			   if ($_REQUEST['choose']=='db_field_generate') {echo 'Restructure Master Database';
				   self::db_field_generate();   
				 }
			   if ($_REQUEST['choose']=='scrub_data') {echo 'Scrub data';
				   self::array_map_database('syntax_checker');   
				   }
			   if ($_REQUEST['choose']=='strreplace_database') {echo 'String_replace Database';
				   if (isset($_POST['old_data'])&&isset($_POST['new_data']))
				   self::database_replace_data($_POST['old_data'],$_POST['new_data']);
				   else exit('Posted old and new not found');
				   }
			   if ($_REQUEST['choose']==='echo_data') {echo 'Print all data';
				   self::echo_data();   
				   }
			   if ($_REQUEST['choose']==='update_field') {echo 'Update Gallery Field';
				   self::update_gallery_field();   
				   }
			   if ($_REQUEST['choose']==='update_page_class') {echo 'Update Page_Class';
				   self::update_page_class();   
				   }
			   if ($_REQUEST['choose']==='uploads_resize') {echo 'Uploads Resize';
				    self::uploads_resize();
				   }
			   if ($_REQUEST['choose']==='resize_image') {echo 'Resize Images';
				   $image_resize=new photo_batch_resize();
				   $image_resize->dbname=$dbname;
				   $image_resize->build();
				   return;
				   }
			   if ($_REQUEST['choose']=='image_dir') {echo 'Image Directory';
				   $image_resize=new image_directory();
				   $image_resize->dbname=$dbname;
				   $image_resize->build();
				   return;
				   }
			   if ($_REQUEST['choose']=='export_local') {  
					   echo NL.NL.$msg22;
					   self::export_local();
					   }
			   if ($_REQUEST['choose']=='import_local'){
				 echo NL.NL.$msg23;
				 self::import_local();
				 }	
			   if ($_REQUEST['choose']=='backup_folder') {
				 set_time_limit(300);
				    if (is_dir('G:/fdrive/')) $dir='G:/fdrive/';
				    elseif (is_dir('/media/sudarshan/Iomega2'))$dir='/media/sudarshan/Iomega2/'; 
				    elseif (is_dir('/media/sudarshan/Seagate3tb'))$dir='/media/sudarshan/Seagate3tb/'; 
				    elseif (is_dir('/media/sudarshan/59E4298B085EB9DC'))$dir='/media/sudarshan/59E4298B085EB9DC/'; 
				    elseif (is_dir('/media/sudarshan/CAA3-E364'))$dir='/media/sudarshan/CAA3-E364/'; 
				    elseif (is_dir('/media/sudarshan/AFC9-B862'))$dir='/media/sudarshan/AFC9-B862/';
				    elseif (is_dir('/media/sudarshan/B364-2007'))$dir='/media/sudarshan/B364-2007/';
				    elseif (is_dir('/media/sudarshan/53EE-9410'))$dir='/media/sudarshan/53EE-9410/';
                        else if (is_dir('J:/fdrive/')) $dir='J:/fdrive/';
				    //else if (is_dir('E:/fdrive/')) $dir='E:/fdrive/';
				    else if (is_dir('K:/fdrive/')) $dir='K:/fdrive/';
				    else if (is_dir('I:/fdrive/')) $dir='I:/fdrive/';
				    else if (is_dir('M:/fdrive/')) $dir='M:/fdrive/';
				    else 
					 
					   exit('<p style="color:red;">proper backup directory not found');
						
						  
				    $Fdir=  (is_dir('F:/'))? 'F:/':'/media/VolF/';
				    $fdrive='fdrive/';
				    $parent_inc_dir = (is_dir('C:xampp'))?'C:xampp/':'/vh/include-share/';
				    $bashdir='/var/bash';
				    $includes='includes/';
				    $commondir='common_dir/';
				    $htdocs='/media/VolH/htdocs/';
				    $hdrive='/vh/';
				    if (isset($_REQUEST['backup_documents'])){
						 echo $msg11;
						 $file='My Documents/';
						 self::backup_folder($Fdir.$file,$dir.$fdrive.$file);
						 echo NL. 'total copied ' . self::$count_it. ' files in '.$file;
						 self::$count_it=0;
						 }
					 if (isset($_REQUEST['backup_downloads'])){
						 echo $msg11;
						 $dwnarr=array('Downloads/','Downloads1/','Downloads2/','Downloads3/','Downloads4/','Downloads5/','DownloadsWin7/');
						 foreach ($dwnarr as $dwndir){
							  
							 self::backup_folder($Fdir.$dwndir,$dir.$dwndir);
							 echo NL. 'total copied ' . self::$count_it. ' files in '.$dwndir;
							 }
						self::$count_it=0;
						} 
					 if  (isset($_REQUEST['backup_includes'])){
						 echo $msg12;
						 self::backup_folder($parent_inc_dir.$includes,$dir.$fdrive.$includes);
						 echo NL. 'total copied ' . self::$count_it. ' files in includes';
						 self::$count_it=0;
						 self::backup_folder($bashdir,$dir.$fdrive.'bash/');
						 echo NL. 'total copied ' . self::$count_it. ' files in bash';
						 self::$count_it=0;
						 self::backup_folder($parent_inc_dir.$commondir,$dir.$fdrive.$commondir);
						  echo NL. 'total copied ' . self::$count_it. ' files in common dir';
						 //self::$count_it=0;
						 }
					 if (isset($_REQUEST['backup_htdocs'])){
						 echo $msg13;
						 self::backup_folder($htdocs,$dir.$fdrive.'htdocs/');
						 echo NL. 'total copied ' . self::$count_it. ' files in htdocs';
						 self::$count_it=0;
						 }
					 if (isset($_REQUEST['backup_music'])){
						 echo $msg14;
						 self::backup_folder($hdrive.'My Music2/',$dir.'My Music2/');
						 echo NL. 'total copied ' . self::$count_it. ' files in music';
						 self::$count_it=0;
						 }
					
				   
					 }//end backup folder
			   }//END REQUEST CHOOSE
		if (isset($_REQUEST['query_sql'])&&!empty($_REQUEST['query_sql'])) {
			echo 'Query Sql';
			self::query_sql();   
			}
		
		}#submitted end
    


#
#<p class="ramana"><input name="choose" value="db_copy_server" type="radio"   >'.$msg3B.'</p>
#<p class="ramana"><input name="backup_music" type="checkbox" value="true"  >'.$msg14.'</p>


	echo'<form action="'. Sys::Self.'" method="POST">  <p><input type="hidden" name="submitted" value="TRUE" ></p>

<p class="ramana"><input name="choose" value="file_generate" type="radio" onclick="alert("hello");"  >'.$msg1.'</p>
<p class="ramana"><input name="choose" value="css_update" type="radio"  >'.$msg2.'</p>
<p class="ramana"><input name="choose" value="cache" type="radio"  >'.$msg20.'</p>
<p class="ramana"><input name="choose" value="db_upload" type="radio"   >'.$msg3.'</p>
<p class="ramana"><input name="choose" value="db_field_generate" type="radio"   >'.$msg4.'</p>
<p class="ramana"><input name="choose" value="scrub_data" type="radio"   >'.$msg5.'</p>
<p class="ramana"><input name="choose" value="strreplace_database" type="radio"  onclick="displaythis(\'checkbox_replace_db\')" >String Find/replace Database</p>
<div id="checkbox_replace_db" style="display:none">
<p class="ramana"><input name="old_data" type="text" >Enter Old Value</p>';

echo 'Note:  using the word "blank" to string delete with no replace, otherwise leave enoty to return search only';
echo '<p class="ramana"><input name="new_data" type="text" >Enter New Value</p>
</div>


<p class="ramana"><input name="choose" value="echo_data" type="radio"   >'.$msg6.'</p>
<p class="ramana"><input name="choose" value="update_field" type="radio"   >'.$msg7.'</p>
<p class="ramana"><input name="choose" value="resize_image" type="radio"   >'.$msg8.'</p>
<p class="ramana"><input name="choose" value="image_dir" type="radio"   >'.$msg9.'</p> 
<p class="ramana"><input name="choose" value="export_local" type="radio" >'.$msg22.'</p>
<p class="ramana"><input name="choose" value="import_local" type="radio" >'.$msg23.'</p>
<p class="ramana"><input name="choose" value="update_page_class" type="radio">'.$msg24.'</p>
<p class="ramana"><input name="choose" value="uploads_resize" type="radio">'.$msg25.'</p>
<p class="ramana"><input name="choose" value="backup_folder" type="radio"  onclick="displaythis(\'checkbox_backup\')" >'.$msg10.'</p>

<div id="checkbox_backup" style="display:none">
<p class="ramana"><input name="backup_documents" type="checkbox" value="true"  >'.$msg11.'</p> 
<p class="ramana"><input name="backup_downloads" type="checkbox" value="true"  >'.$msg21.'</p>
<p class="ramana"><input name="backup_includes" type="checkbox"  value="true" >'.$msg12.'</p>
<p class="ramana"><input name="backup_htdocs" type="checkbox" value="true"  >'.$msg13.'</p>
<p class="ramana"><input name="backup_music" type="checkbox"  value="true" >'.$msg14.'</p>
</div 
<p class="ramana"><input name="query_sql"  type="text">'.$msg18.'</p> 
<input type="submit" name="submit" value="Proceed"> </form>
<p class="ramana"><a href="ftp.php">DownLoad Upload FTP</a></p>
<p class="ramana"><a href="resize_image.php">Resize Images</a></p>
<p class="ramana"><a href="display.php">Display Database</a></p>
<p class="ramana"><a href="db_files.php">Db List Files(ie:Movies)</a></p>
<p class="ramana"><a href="text_image_gen.php">Text Image Generate</a></p>';
if(isset($_REQUEST['submitted']))printer::print_request();
printer::vert_print($_SESSION); 
echo '
</body></html>';
}//end construct

#?backupall is gotten in editpages and then used backup html batch which in turns backup all urls and filegenerator....!

static function file_generate($style,$file,$cache=false){
     set_time_limit(20);
	 echo  "Generating ".__METHOD__." for current Database";
		
	 $_SESSION[Cfg::Owner.'filegen']=1;
	 $galltable='';
	 $nongall='';
	 $backupinst=backup::instance();
	 $mysqlinst = mysql::instance();
	 ($file===true) && self::file_folder_generate(); 
	 ($file===true) && self::editMaster_generate();
      ($file===true) && self::class_local_gen();
	 $pagetables=check_data::return_pages(__METHOD__,__LINE__,__FILE__,""); #set to   remove expand,highslide, and data tables
	 $table_assoc=check_data::dir_to_file(__METHOD__,__LINE__,__FILE__,'',true);
	 
      foreach ($pagetables as $tablename){  
		if(!array_key_exists($tablename,$table_assoc))continue;//weed out the kruft!
		$filetablename=$table_assoc[$tablename]; 	  
		//echo NL. $filename .' is filename'; continue;
		($cache==true) && $backupinst->backup_url($tablename);
		($style===true) && file_generate::iframe_backup($filetablename.'.php');
		($file===true) &&  file_generate::pageEdit_generate($tablename);//to generate editpages table reorder.php 
		($file===true) &&  file_generate::page_generate($tablename);// this will create gallery master file
		} 
	     $galltables=check_data::return_gallery_info(__METHOD__,__LINE__,__FILE__); #set to   remove expand,highslide, and data tables
          foreach ($galltables as $array){
               list($gall_ref,$gall_table)=$array;
               ($file===true) && self::expand_file($gall_ref,$gall_table);
               }

	unset($_SESSION[Cfg::Owner.'filegen']); 
     return "success";
      
    }//end function file_generate
 

static function update_page_class(){
	 $pagetables=check_data::return_pages(__METHOD__,__LINE__,__FILE__,""); #set to   remove expand,highslide, and data tables
	 $table_assoc=check_data::dir_to_file(__METHOD__,__LINE__,__FILE__,'',true);
	 foreach ($pagetables as $tablename){
		  file_generate::create_new_page_class($tablename);
		  }
	 }
	
function uploads_resize(){
	 $match='*';
	 $collect=array();
	 $dir=Cfg_loc::Root_dir.Cfg::Upload_dir; 
	 $fdir=Cfg_loc::Root_dir.Cfg::Upload_dir; 
	 $ext_arr=explode(',',Cfg::Valid_pic_ext); 
	 if ($directory_handle = opendir($dir)) {
		  while (($file = readdir($directory_handle)) !== false) {  
			   if (is_dir($file))continue;
			   if (strpos($file,'.')<1)continue;
			   $path_parts=pathinfo($file);
			   if (in_array(strtolower($path_parts['extension']),$ext_arr)){
				    $size=filesize($dir.$file);
				    echo  NL. "$file";
				    list($width,$h)=process_data::get_size($file,$dir);
				    if ($width > $this->up_size +$this->up_size*.2){
						//printer::alert_pos("resizing $file to $dir");
						image::image_resize($file,$this->up_size,0,0,$dir,$fdir,'file',NULL,90);
						$fsize=filesize($fdir.$file);
				   
						$collect[]=array('Name'=>$file,'Px Initial'=>$width,'Size Init'=>$size,'Size Final'=>$fsize);
						
						}
				    //else printer::alert_neg( NL. "not resized $dir$file of $width");
				    }
			   }//while
		  printer::horiz_print($collect);
		  }
	 }
      
function str_replace_data($value) {if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);  //echo "value begin is $value";
  #called by db_replace_data
   #this first part is set up to remove dashes from filenames
	 if (!isset($_SESSION[Cfg::Owner.'old']) || !isset($_SESSION[Cfg::Owner.'new'])) exit('problem with session new or old');
		if ($_SESSION[Cfg::Owner.'old']==='-'){
		
		if (substr($value,0,1)===$_SESSION[Cfg::Owner.'old']){ 
			echo 'now put in any new value to punch it through';
			printer::alert_neg($value);
			$value=str_replace('-','',$value); echo $value;
			}
		 #else  if (strpos($value,'-')!==false) printer::alert_pos($value);
		 return trim($value);
		}
	
	if (strpos($value,$_SESSION[Cfg::Owner.'old'])===false){  
	}
	else    { 
		if ($_SESSION[Cfg::Owner.'new']==''){
			echo NL.'use "blank" for new to replace';
			printer::alert_pos($value);
			return $value;
			}
		echo NL.'Being replaced';
		printer::alert_pos($value);
		$value = str_replace($_SESSION[Cfg::Owner.'old'],$_SESSION[Cfg::Owner.'new'], $value);
		
		}
	 if (strpos(strtolower($value),$_SESSION[Cfg::Owner.'old'])!==false){
		 printer::alert_neg('A lower case ');  printer::alert($value); printer::alert_neg(' has been found');
		#$value = str_replace($_SESSION[Cfg::Owner.'old'],$_SESSION[Cfg::Owner.'new'], $value);
		}
	 
	return trim($value);
	} // End of () function.	
	
static function str_replace_data_mod($value) {
	 #called by db_replace_data
   #this first part is set up to remove dashes from filenames
	 if (!isset($_SESSION[Cfg::Owner.'old']) || !isset($_SESSION[Cfg::Owner.'new'])) exit('problem with session new or old');
		 
	
	if (strpos($value,$_SESSION[Cfg::Owner.'old'])===false){
		  if (strpos(strtolower($value),$_SESSION[Cfg::Owner.'old'])!==false){
		 printer::alert_neg('A lower case ');  printer::alert($value); printer::alert_neg(' has been found');
		 echo ' in '. $_SESSION[Cfg::Owner.'tablename'];
		#$value = str_replace($_SESSION[Cfg::Owner.'old'],$_SESSION[Cfg::Owner.'new'], $value);
		}
		return trim($value); 
	}
	else  if ($_SESSION[Cfg::Owner.'new']==''){
			echo NL.'use "blank" for new to replace with "" ';
		 echo NL.' in '. $_SESSION[Cfg::Owner.'tablename'];
			printer::alert_neu($value);
			  return trim($value);
			}
	 $replace=($_SESSION[Cfg::Owner.'new']==='blank')?'':$_SESSION[Cfg::Owner.'new'];
	 echo NL.'Being replaced';
		 echo NL.' in '. $_SESSION[Cfg::Owner.'tablename'];
	 printer::alert_pos($value);
	 $value = str_replace($_SESSION[Cfg::Owner.'old'],$replace, $value);
	 return trim('xxxx'.$value);#so that only changed values are updated!!!
	} // End of () function.	
 
 static function database_replace_data_mod_local(){
	//new=$_SESSION[Cfg::Owner.'old']='http://bmtacupuncture.com'; //values passed through sessions
	  // $search='www.trekkinglightly.com';
	  // $replace='localhost/trish';
	  $_SESSION[Cfg::Owner.'old']='localhost/stanley'; //values passed through sessions'localhost/stanley';
	  $new=$_SESSION[Cfg::Owner.'new']='www.ekarasa.com/stanley';
	   $db='oceanside-back'; $continue=true;  #recommend using http:  if www not present for url changes
	 
	   ($new=='') && $continue=false;
	
	$function='str_replace_data_mod';
	self::array_map_database_mod($db,$function,$continue);
	}	
 static function array_map_database_mod($db, $function, $continue=true){  
	 $mysqlinst = mysql::instance();
	 $mysqlinst->dbconnect($db);
	 
	 $table_array=check_data::get_tables($db); 
	 foreach ($table_array as $tablename){
		  $_SESSION[Cfg::Owner.'tablename']=$tablename;
		  $q="SHOW COLUMNS FROM $tablename";
		  $r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); 
		  $field_arr=array();
		  while ($rows=$mysqlinst->fetch_assoc($r,__LINE__)){
			   $field_arr[]=$rows['Field'];   
			   }   
		  $field_data=implode(',',$field_arr);
		  $q = "SELECT $field_data FROM  $tablename";    
		  $r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
		  while ($rows=$mysqlinst->fetch_assoc($r,__LINE__)){
			   $update= 'SET ';
			   $where='Where ';
			   #USING LOCAL SPAM SCRUBBER
			   $new_map = array_map(array('file_generator',$function), $rows );
			   if ($continue){   //echo $new_map[$field_array[3]]. ' is the field';	
				    for ($x=0; $x<count($field_arr); $x++){ 
						${$field_arr[$x]}=$new_map[$field_arr[$x]]; 
						if ($field_arr[$x]!=='token'&&isset($new_map[$field_arr[$x]])&&substr($new_map[$field_arr[$x]],0,4)==='xxxx') {
							 $new_map[$field_arr[$x]]=substr_replace($new_map[$field_arr[$x]],'',0,4);
							 $update.=" {$field_arr[$x]}='{$new_map[$field_arr[$x]]}',";  
							 }
						$id=strtolower($field_arr[$x]);   
						if (strpos($id,'_id')!==false||$id==='id'){
							 $where.=" $id=".$new_map[$field_arr[$x]] ." AND ";		     
							 }
						}//end for
				    if ($update!=='SET '){ 
						if (!empty($where)){ 
							 $where=substr_replace($where ,"",-4,3);
							 $q="UPDATE $db.$tablename $update token='".mt_rand(1,mt_getrandmax())."' $where";  
							 $mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
							 }
						  
						}# not empty update
				    }//end continue
			   }//end while
		  }//end foreach
	 
	 
			 
		 
	}//end array_map_database_mod
	
static function non_strict_db_check($value){  
	 if (empty(trim($value)) || is_numeric($value))return $value;
	 $nval=process_data::spam_scrubber($value,false);
	 if ($nval !== $value) return ('xxxx'.$nval);
	 return trim($value);
	 }
	 
static function strict_db_check($value){
	 if (empty($value) || is_numeric($value))return $value;
	 $nval=process_data::spam_scrubber($value,'convert');
	 if (trim($nval) !== trim($value)){ 
		  return ('xxxx'.$nval);
		  }
	 return trim($value);
	 }
function export_local(){
	 $arr=array('ekarasac_karmawebsite');
	 $path='/wdwn/';
	 foreach ($arr as $db){
		  $pathfile=$path.$db.'.sql';
		  $mysqlserver='';
		  system($mysqlserver."mysqldump -hlocalhost -uekarasac_sdrshn -p118cheznut  $db   >  $pathfile");
		  
		  echo NL.'<p style="color:green; background:white">'.$db . ' is exported</p>';
		  }
	 }//end export
	 
function import_local(){
	 $arr=array('ekarasac_karmawebsite');
	 $path='D:/';
	 foreach ($arr as $db){
		  $pathfile=$path.$db.'.sql';
		  $mysqlserver='C:/xampp/mysql/bin/';
		  system($mysqlserver."mysql  -hlocalhost -uekarasac_sdrshn -p118cheznut  $db  <  $pathfile");
		  echo NL.'<p style="color:green;background:white"">'.$db . ' is imported</p>';  
		  }
	 }//end import	 
	 
function syntax_checker($value) {if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);  //echo "value begin is $value";
     #for checkbox's repopulate keys....
    $implode='';
    
     $value = str_replace('<br />','<br>', $value);
   $value = str_replace("& ","&amp; ", $value);
    $value = str_replace("'","&#8217;", $value); //echo "value end is $value";
    return trim($value);
    } // End of spam_scrubber() function.





private function echo_data(){
	 $mysqlinst = mysql::instance(); 
	 $mysqlinst->dbconnect(Sys::Dbname);
	 $process=new process_data();
	 $field_data=Cfg::Page_fields;
	 $field_array=explode(',',$field_data);  
	 $table_array=check_data::return_page_refs('stylenav');#use all tables false=no skipping
	 echo ' page table values are ';
	 foreach ($table_array as $tablename){   
		  $q = "SELECT $field_data FROM ". $tablename . " where id=1";  
		  $r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); 
		  while ($rows=$mysqlinst->fetch_assoc($r,__LINE__,false)) {
			   for ($x=0; $x<count($field_array); $x++){
				    ${$field_array[$x]}=trim($rows[$field_array[$x]]);#creates variable with name and value of field;
				    echo  NL.$tablename .$field_array[$x].' = '. ${$field_array[$x]};
				    }
			   }//end while
		  }//end foreach
    
	 $field_data=Cfg::Gallery_fields;
	 $field_array=explode(',',$field_data);  
	 $table_array= check_data::return_page_refs('bigname');#use all tables false=no skipping
	 echo 'gallery table values are ';
	 foreach ($table_array as $tablename){   
		  $q = "SELECT $field_data FROM ". $tablename;  
		  $r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); 
   
	 
	   
		  while ($rows=$mysqlinst->fetch_assoc($r,__LINE__,false)) {
			   for ($x=0; $x<count($field_array); $x++){
				    ${$field_array[$x]}=trim($rows[$field_array[$x]]);#creates variable with name and value of field;
				    echo  NL. $tablename .$field_array[$x].' = '. ${$field_array[$x]};
				    }
			   }//endwhile
		  }//end foreach
	 }//end print data


 
private function array_map_update($function){
	$update= 'SET ';
	$scrubbed = array_map(array($this,'syntax_checker'), $rows );  
	for ($x=0; $x<count($field_array); $x++){
		if (isset($scrubbed[$field_array[$x]])) {
			${$field_array[$x]}=$scrubbed[$field_array[$x]]; $update.=" {$field_array[$x]}='${$field_array[$x]}',";
			}
		}
	$update=substr_replace($update ,"",-1); 
	$q="UPDATE $tablename $update where pic_order='$pic_order'";
	return $q;
	}//end function

 
function backup_folder($dir,$backupdir) {   
	static $count=0;
	$dir = rtrim($dir, "/") ."/";   
	$backupdir = rtrim($backupdir, "/") ."/";
	if ($directory_handle = opendir($dir)) {
		while (($file_handle = readdir($directory_handle)) !== false) { 
			 // Is the file in the ignore_file list
			//echo $file_handle;i
			//$file_handle=strtolower($file_handle);
			if (trim($file_handle)!==$file_handle)rename($dir.$file_handle,$dir.trim($file_handle));
			$reject_folder=explode(',',Cfg::Exclude);
			$flag=false;
			foreach ($reject_folder as $reject){
				if (strtolower($file_handle) ==$reject){
					$flag=true;  //($reject !='.'&&$reject !='..')&&print 'folder rejected: '.$reject;
					}
				}
				
			if($flag) continue;		
			//if (in_array($file_handle, $this->ignore_file)) {echo NL. 'ignored: '.$this->ignore_file;  
			//	continue;
			//	}
			//if (in_array($file_handle, $this->block_dir)) {    
			//	continue;
			//	}
			if (is_dir($dir. $file_handle)) { //echo NL. NL. "directory is ".$dir.$file_handle.NL; 
					//echo 'entered with '.$dir.$file_handle;
					(!is_dir($backupdir.$file_handle))&&file_generate::generate_folder($backupdir.$file_handle);
					 self::backup_folder($dir. $file_handle,$backupdir.$file_handle);
				}
			
			else if (!is_dir($backupdir)){   print (NL.'backupdir not found' . $backupdir);
				file_generate::generate_folder($backupdir);
				}
			else if (!is_file($backupdir.$file_handle)||strpos($backupdir,'serverbackup')!==false){//serverbackups need to be overwritten not renamed
			   $x='::';
				echo NL. "Backup copy of this filename not found alert.  copied this file $dir$file_handle , $backupdir$file_handle$x";
				echo NL.'<span style="color:gold">Backup copy not found </span>..   copied this file '.$dir.$file_handle .' to: '. $backupdir.$file_handle ;
				
				if(!copy($dir.$file_handle,$backupdir.$file_handle)){ continue;
					rename($file_handle,substr($file_handle,0,30));
					echo "truncated $dir.$file_handle to ".$dir.substr($file_handle,0,30);
					if(!copy($dir.substr($file_handle,0,30),$dir.substr($file_handle,0,30))){
						printer::alert_neg(NL. 'problem1 copying to '. $backupdir.substr($file_handle,0,30));
						continue;
						}
					}
				self::$count_it++;
				echo NL. 'copied: '. $backupdir.$file_handle;
				continue;
				} 
			else if (filemtime($dir.$file_handle)==filemtime($backupdir.$file_handle)){ echo "equal filetime for $dir.$file_handle";continue;} 
			else if ( (filemtime($dir.$file_handle)>filemtime($backupdir.$file_handle)&&strpos($file_handle,'.bup')===false)){
				$cont=false;
				if (strpos($file_handle,'.jpg')||strpos($file_handle,'.gif')||strpos($file_handle,'.png')){
					echo NL.'you have a pic file updated date modification that has not been recopied'. $dir.$file_handle;
					$cont=true;
					}
				if ($cont) continue;
				if(!rename($backupdir.$file_handle,$backupdir.$file_handle. date('Y.m.d.H.i.s',filemtime($backupdir.$file_handle)) . '.bup'))
				    printer::alert_neg( NL.'Error Problem renaming this file '.$backupdir.$file_handle .' to '. $file_handle. date('Y.m.d.H.i.s',filemtime($backupdir.$file_handle)) . '.bup');
				if(!copy($dir.$file_handle,$backupdir.$file_handle))
					printer::alert_neg(NL.'problem2 backing up to this file '.$backupdir.$file_handle);
				self::$count_it++;
				echo NL. 'copied- '.$dir. $file_handle;
				continue;
				}  
			//else if ($date1<$date2){
				// echo NL. '$date1=filemtime($dir.$file_handle)'; echo   $date1.$dir.$file_handle;
				// echo NL. '$date2=filemtime($backupdir.$file_handle)';echo  $date2.$backupdir.$file_handle; 
				//mail::alert('File backups error1', 'file_backup error');
				//}
			   //else echo NL."passed down thru  ". filemtime($dir.$file_handle) . ' < '.filemtime($backupdir.$file_handle). ' for '.$file_handle;
			}
		}
	}
static function run_db_table_automate(){#run localhost/run_db_table_automate.php
	 
	$do_function="update_style";
	 self::master_db_tablename_pass($do_function,true,'keywords');
	return;
	$do_function="add_blog_style";
	self::master_db_tablename_pass($do_function,true,'blog_style');
	$do_function='add_dbfield3';
	self::master_db_tablename_pass($do_function,true,'keywords');

	}
  }//end class
#may be called by file_generator.php in /var/www   
#ALTER TABLE `about_blog1` CHANGE `blog_break` `blog_float` TINYTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL 
   
	    
	  # style47 in expandgalleryedit.php used to store the token so that pages affected updates! if all else fails...  can make a token field data...

	  
	   # nav3 is reserved for gallery tables list
	   #style50 is reserved for check_data::return_page_refs
	   //style 29 used to sidemenunav=>style29

 ?>