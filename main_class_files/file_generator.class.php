<?php
#ExpressEdit 2.0.4
class file_generator extends file_generate{
protected static $count_it=0;
protected $file=false;
protected $style=false;
protected $blog_temp='';
protected $up_size='1800';
function __construct($return=false){  

	 if(!$return===false)return;
	   set_time_limit(300); 
	   
	   $load=new fullloader();
          $load->fullpath('Cfg_master.class.php');
	   $load=new fullloader();
          $load->fullpath('Cfg.class.php');
	   $cfg_included=true;//for prevent includes Cfg in Sys.php
	   self::config_gen_init();//this is done first in case...  for primordial file generation of config files....   
	   $load=new fullloader();
          $load->fullpath('Sys.class.php');
        
	
    



	
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
      ($file===true) && self::config_gen_edit();
	 $pagetables=check_data::return_pages(__METHOD__,__LINE__,__FILE__,""); #set to   remove expand,highslide, and data tables
	 $table_assoc=check_data::dir_to_file(__METHOD__,__LINE__,__FILE__,'',true);
	 
      foreach ($pagetables as $pagename){  
		if(!array_key_exists($pagename,$table_assoc))continue;//weed out the kruft!
		$filepagename=$table_assoc[$pagename]; 	  
		//echo NL. $filename .' is filename'; continue;
		($cache==true) && $backupinst->backup_url($pagename);
		($style===true) && file_generate::iframe_backup($filepagename.'.php');
		($file===true) &&  file_generate::pageEdit_generate($pagename);//to generate editpages table reorder.php 
		($file===true) &&  file_generate::page_generate($pagename);// this will create gallery master file
		} 
	     $galltables=check_data::return_gallery_info(__METHOD__,__LINE__,__FILE__); #set to   remove expand,highslide, and data tables
          foreach ($galltables as $array){
               list($gall_ref,$gall_table)=$array;
               ($file===true) && self::expand_file($gall_ref,$gall_table);
               }

	unset($_SESSION[Cfg::Owner.'filegen']); 
     return "success";
      
    }//end function file_generate
 
static function array_map_database_mod($db, $function, $continue=true){  
	 $mysqlinst = mysql::instance();
	 $mysqlinst->dbconnect($db);
	 
	 $table_array=check_data::get_tables($db); 
	 foreach ($table_array as $pagename){
		  $_SESSION[Cfg::Owner.'pagename']=$pagename;
		  $q="SHOW COLUMNS FROM $pagename";
		  $r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); 
		  $field_arr=array();
		  while ($rows=$mysqlinst->fetch_assoc($r,__LINE__)){
			   $field_arr[]=$rows['Field'];   
			   }   
		  $field_data=implode(',',$field_arr);
		  $q = "SELECT $field_data FROM  $pagename";    
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
							 $q="UPDATE $db.$pagename $update token='".mt_rand(1,mt_getrandmax())."' $where";  
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
	 $arr=array('vwpkbpmy_karmawebsite');
	 $path='/wdwn/';
	 foreach ($arr as $db){
		  $pathfile=$path.$db.'.sql';
		  $mysqlserver='';
		  system($mysqlserver."mysqldump -hlocalhost -uvwpkbpmy_sdrshn -p118cheznut  $db   >  $pathfile");
		  
		  echo NL.'<p style="color:green; background:white">'.$db . ' is exported</p>';
		  }
	 }//end export
      
static function update_page_class(){
	 $pagetables=check_data::return_pages(__METHOD__,__LINE__,__FILE__,""); #set to   remove expand,highslide, and data tables
	 $table_assoc=check_data::dir_to_file(__METHOD__,__LINE__,__FILE__,'',true);
	 foreach ($pagetables as $pagename){
		  file_generate::create_new_page_class($pagename);
		  }
     printer::alert_pos('Regenerating Class Pages');
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

  }//end class


 ?>