<?php
#ExpressEdit 2.0.1
class check_data {
     
static function checkIP($ip) {
     if (!emptyempty($ip) && ip2long($ip)!=-1 && ip2long($ip)!=false) {
          $private_ips = array (
               array('0.0.0.0','2.255.255.255'),
               array('10.0.0.0','10.255.255.255'),
               array('127.0.0.0','127.255.255.255'),
               array('169.254.0.0','169.254.255.255'),
               array('172.16.0.0','172.31.255.255'),
               array('192.0.2.0','192.0.2.255'),
               array('192.168.0.0','192.168.255.255'),
               array('255.255.255.0','255.255.255.255')
               );
          foreach ($private_ips as $r) {
               $min = ip2long($r[0]);
               $max = ip2long($r[1]);
               if ((ip2long($ip) >= $min) && (ip2long($ip) <= $max)) return false;
               }
          return true;
          }
     else {
         return false;
          }
     }
 
static function check_gallery_master($method,$line,$file,$tablename,$return_list=false){ 
	$mysqlinst = mysql::instance();
	$mysqlinst->dbconnect();
	$storeinst=store::instance();
	if (isset($storeinst->mastergalls)&&!$return_list){ 
		if (array_key_exists($tablename,$storeinst->mastergalls))return true;
		else return false;
		}
	elseif (isset($storeinst->mastergalls))return $storeinst->mastergalls;
	$q='select dir_ref from '.Cfg::Directory_dir. ' where dir_is_gall=1';
	$r=$mysqlinst->query($q,$method,$line,$file,true);
	$return=false;  
	if (!($mysqlinst->affected_rows())){
		mail::alert('mysql mastergall problem'); 
		return false;
		}
	$storeinst->mastergalls=array();
	while(list($mt)=$mysqlinst->fetch_row($r,__LINE__)){
		$storeinst->mastergalls[$mt]=1;
		if($mt===$tablename){
			$return=true;
			}
	    }
	$return=($return_list)?$storeinst->mastergalls:$return;
	return $return;
	}
	
static function check_disabled($func){
    $disabled=ini_get('disable_function');
    $disarray=explode(',',$disabled);
    if (in_array($func,$disarray))return true;
    return false;
    }
    
static function key_up($array, $value, $return='val',$maxval=''){
     $maxval='';
     $arr=$array;
     $arr=(is_array($arr))?$arr:explode(',',$arr);
     $prev=0;
     if ($return==='val'){
          sort($arr);
          foreach($arr as $key => $keyval){
              if ($keyval >=$value){  
                    if (empty($maxval))return $keyval;
                    elseif ($keyval <= $maxval)return $keyval;
                    else return $prev;
                    }
               $prev=$keyval; 
               }
         return $keyval;
         }
     else {
          $arrKeys=array_keys($arr);
          $newArr=array();
          foreach($arrKeys as $keyval){  
               if (strpos($keyval,'max')===false) 
                   $newArr[]=$keyval;
                    
               else $maxkey=$keyval;
               }
          sort($newArr);
          foreach($newArr as $keyval){
               if ($keyval >= $value) return array($keyval,$arr[$keyval]);
               }
          return array($maxkey,$array[$maxkey]);
          }         
     }
     
static function key_down_check($arr, $value,$default=1){
     $keytrack=0;
     if (empty(count($arr)))return $default;
     foreach($arr as $key => $keyval){
          if ($key >=$value) 
               $keytrack=$keyval;
          elseif (!empty($keytrack))return $keytrack;
          else return $default; 
          }  
     }
    
static function key_down($array, $value){
     $arr=$array;
     $arr=(is_array($arr))?$arr:explode(',',$arr);
     $prev=0;
     rsort($arr);
     foreach($arr as $key => $keyval){ 
          if ($value >=$keyval){
              return $keyval;
              }
          }
     return $keyval;
     }      
    
static function objectToArray($d){  
     if (is_object($d)) {
	   //http://stackoverflow.com/questions/19495068/convert-stdclass-object-to-array-in-php
          $d = get_object_vars($d);
          }

    if (is_array($d)) {
        return array_map(array('check_data','objectToArray'), $d);
	   }
     else { 
          return $d;
          }
     }
     
static function return_master_gall($method,$line,$file,$tablename){
	$masterlist=self::check_gallery_master($tablename,true);
	foreach ($masterlist as $mastergall=>$val){  
		if ($tablename==$mastergall)return $mastergall;
		$tables=self::return_gall_list($mastergall,$method,$line,$file);
		if (in_array($tablename,$tables))return $mastergall;
		}
	return false;
	}
	
static function color_validate($color){
	if ( preg_match('|^([A-Fa-f0-9]{3}){1,2}$|', $color ) ) return true;
	return false;
	}
	 
static function  return_galleries($method,$line,$file,$where='where pic_order=1',$remove_data='',$print=false,$db=Sys::Dbname){
	$tables=self::return_refs($method,$line,$file,Cfg::Master_gall_table,"gall_ref",$where,$remove_data,$print,$db);
	return $tables;
	}
static function return_gallery_info($method,$line,$file,$type='gall'){
     $mysqlinst = mysql::instance();
     $mysqlinst->dbconnect();
     $return_array=array();
     if ($type='gall')$where="where master_gall_status != 'master_gall'";
     else if ($type='all')$where='';
     else if ($type='master_gall')$where="where master_gall_status = 'master_gall'";
     $q='select gall_ref,gall_table from '.Cfg::Master_gall_table." $where";   
     $r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
     if ($mysqlinst->affected_rows()) {
          while(list($gall_ref,$gall_table)=$mysqlinst->fetch_row($r,__line__)){
               $return_array[]=array($gall_ref,$gall_table);
               }
          return $return_array;
          }
     return array();
     }
    
static function is_mobile() {
     $userAgent = strtolower($_SERVER['HTTP_USER_AGENT']);
     return strpos($userAgent, 'mobile');
     }
    
	 
static function return_posts($where='where blog_order=10',$remove_data='',$print=false,$db=Sys::Dbname){
	$tables=self::return_refs($method,$line,$file,Cfg::Master_post_table,"blog_table",$where,$remove_data,$print,$db);
	return $tables;
	}
static function noexpand($filename){ 
    if (!is_file($filename))return true;
    $path_parts = pathinfo($filename);  
    $ext=(array_key_exists('extension',$path_parts))?strtolower($path_parts['extension']):'';
    if (empty($ext))return true;
    if (strtolower($ext)==='svg')return true;
    if(strtolower($ext)!=='gif')return false;
    $file = file_get_contents($filename);
    $animated=preg_match('#(\x00\x21\xF9\x04.{4}\x00\x2C.*){2,}#s', $file);
    if ($animated==1) return true;
    else return false;    
    }
    
static function return_pages($method,$line,$file,$where='',$remove_data='',$print=false,$db=Sys::Dbname){
	$tables=self::return_refs($method,$line,$file,Cfg::Master_page_table,"page_ref",$where,$remove_data,$print,$db);
	return $tables;
	}
	
static function return_page_filenames($method,$line,$file,$where='',$remove_data='',$print=false,$db=Sys::Dbname){
	$tables=self::return_refs($method,$line,$file,Cfg::Master_page_table,'page_filename',$where,$remove_data,$print,$db);
	return $tables;
	}
	
static function return_all($method,$line,$file,$remove_data='',$print=false,$db=Sys::Dbname){
	$tables1=self::return_refs($method,$line,$file,Cfg::Master_page_table,"page_ref",'',$remove_data,$print,$db);
	$tables2=self::return_refs($method,$line,$file,Cfg::Master_post_table,"blog_table",'where blog_order=10',$remove_data,$print,$db);
	$return_tables=array_merge($tables1,$tables2);
	return $return_tables; 
	}
     
#table_to_file
static function dir_to_file($method,$line,$file,$tablename,$return_list=false){
	$mysqlinst = mysql::instance();
	$mysqlinst->dbconnect();
	$storeinst=store::instance();
	if (isset($storeinst->dir_to_file)){
		if ($return_list) return $storeinst->dir_to_file;
		$return= (array_key_exists($tablename,$storeinst->dir_to_file))? $storeinst->dir_to_file[$tablename]:$tablename;
		return $return;
		}
	$q='select page_ref, page_filename from '.Cfg::Master_page_table;
	$r=$mysqlinst->query($q,$method,$line,$file,false);
	if (!($mysqlinst->affected_rows())){
		//mail::alert('dir to file error returning false');
		return false;
		}
	$storeinst->dir_to_file=array();
	while(list($tref,$fname)=$mysqlinst->fetch_row($r,__LINE__)){
		$storeinst->dir_to_file[$tref]=$fname;
		}
	if ($return_list) return $storeinst->dir_to_file;
	$return= (array_key_exists($tablename,$storeinst->dir_to_file))? $storeinst->dir_to_file[$tablename]:$tablename;
	return $return;
	}
	
static function return_refs($method,$line,$file,$mastertable,$selection,$where='',$remove_data=false,$print=false,$dbase=Sys::Dbname){
	 #field as option not being used
	$mysqlinst = mysql::instance();
	$dbase=(!empty($dbase))?$dbase:Sys::Dbname;
	$mysqlinst->dbconnect($dbase);  
	$q="select $selection from $mastertable $where";   
	$r=$mysqlinst->query($q,$method,$line,$file,false);
	$tables=array();
	$remove_data=(is_array($remove_data))?$remove_data:explode(',',$remove_data);
	if (!($mysqlinst->affected_rows())){
		return array();
		}
	while($rows=$mysqlinst->fetch_row($r,__LINE__)){
	    (!in_array($rows[0],$remove_data))&&$tables[]=trim($rows[0]);
	    }
	($print)&&printer::vert_print($tables);   
	return($tables);
	}

static function return_field_value($method,$line,$file,$mastertable,$input_value,$input_field,$output_field){
	if (isset($storeinst->return_field_value[$mastertable][$input_value][$input_field]))return $storeinst->return_field_value[$mastertable][$input_value][$input_field];
	$storeinst=store::instance();
	$storeinst->return_field_value=array();
	$mysqlinst = mysql::instance();
	$mysqlinst->dbconnect();  
	$q="select $output_field from $mastertable  where $input_field='$input_value' Limit 1";
	$r=$mysqlinst->query($q,$method,$line,$file,true);
	if (!($mysqlinst->affected_rows())){
		mail::alert('return field value  error returning false');
		return false;
		}
	list($output)=$mysqlinst->fetch_row($r,__LINE__);
	(!empty($output))&&$storeinst->return_field_value[$mastertable][$input_value][$input_field]=$output;
	return $output;
	}
    
    
static function table_to_title($tablename,$method,$line,$file){
	$mysqlinst = mysql::instance();
	$mysqlinst->dbconnect();  
	$q='select page_title from '.Cfg::Master_page_table." where page_ref='$tablename'";
	$r=$mysqlinst->query($q,$method,$line,$file,false);
	if (!($mysqlinst->affected_rows())){
		return $tablename;
		}
	list($output)=$mysqlinst->fetch_row($r,__LINE__);
	$output=(!empty($output))?$output:$tablename;
	return $output;
	}
    
static function get_tables($database=Sys::Dbname){// this has been replaced
     $mysqlinst = mysql::instance();
     $mysqlinst->dbconnect($database);         
     $q = "SHOW TABLES";   
     $result = $mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
     $table_list=array();
     while ($row = $mysqlinst->fetch_row($result)) {
          $table_list[]=$row[0];   
          }
     return $table_list; 
     }

static function check_num($min,$max,$val,$return=''){   if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__); 
     $boo=false;
     if (is_numeric($val))  { 
          if ($val <=$max && $val  >= $min) {
               $boo=true;
               return $boo;
               }
          else if ($val> $max){
               $boo='YOUR '.$return.' NUMBER IS TOO BIG';
               return $boo;
               }
          else if ($val<$min){
               $boo=' YOUR '.$return.' NUMBER IS TOO SMALL,';
               return  $boo;
               }
          }
     }

static function check_num_bool($min,$max,$val){   if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__); 
	if (is_numeric($val))  { 
	   if ($val <=$max && $val  >= $min) {
		    return true;
			}
		}
	return false; 
	}

static function validate_image_type($filename,$dir){ 
     $flag=false;
     if (is_dir($dir.$filename))return false;
     if (substr($filename,0,1)=='.')return false;   
     if (!is_file($dir.$filename))return false;  
     $allow_ext=  explode(',',Cfg::Valid_pic_ext);		   
	$filenm=strtolower($filename);
	foreach ($allow_ext as $var){
          if (strpos($filenm,$var)){
               $flag=true; break;
               }
          }   
     if(!$flag) return false;
     $size	= GetImageSize($dir.$filename);
     $mime	= $size['mime'];
     if (substr($mime, 0, 6) == 'image/') return true;
     else return false;
	}

static function check_array($val, $check_array){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	$check_array=(!is_array($check_array))?explode(',',$check_array):$check_array;   
	if (in_array(trim($val),$check_array)){
		return true;
		}  
	return false;
	}//end check_tab
    
static function check_array_strpos($val, $check_array){ if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
     $boo=false;
     $check_array=(!is_array($check_array))?explode(',',$check_array):$check_array;    
     foreach ($check_array as $var){   
          if (strpos($val,$var)!==false){  
               $boo=true;
               }   
          }
     return  $boo;	
     }//end function

static function check_id($id,$param=array('c','p')){ 
    $str1=strtolower(substr($id,0,1)); 
    if (!in_array($str1,$param)) return false;
    $str2=substr($id,1); 
    if (!is_numeric($str2))return false;
    return true;
    }
		 
static function  loopminmaxnum($min,$max,$val,$nexprev){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
     $num= $val;
     $maxi=$max;
     $mini=$min;
     $nexprev=$nexprev;
     if ($nexprev=='next'){
          if ($num==$maxi)   { $num=1;}
          else $num=$num+1;
          }
     elseif($nexprev=='prev'){
          if ($num==$mini)   { $num=$maxi;}
          else $num=$num-1;
          }
     return  $num;
     }//end loopminmaxnum

static function preloaded($min,$max,$val){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
     $num= $val;
     $maxi=$max;
     $mini=$min;
     if ($val>$max){
          return array(1,2,3);
          }
     if ($maxi>4){
          if ($num==$maxi){
               $array_send[]= $mini ; $array_send[]=$mini+1;
               } 
          else if ($num+1==$maxi){
               $array_send[]=$maxi; $array_send[]=$mini;
               } 
          else {
               $array_send[]=$num+1; $array_send[]=$num+2;
               } //   
          if ($num==$mini){
               $array_send[]=$maxi; $array_send[]=$maxi-1;
               }  
          elseif ($num-1==$mini) {
               $array_send[]=$mini; $array_send[]=$maxi;
               }
          else {
               $array_send[]=$num-1; $array_send[]=$num-2;
               } 
          }
     else {
          for ($i = $mini; $i<$maxi+1; $i++) {
               $array_send[]=$i;
               }
          }// end maxi < 5
     return  $array_send;
     }//end preloadnums

}//end class check_data
?>