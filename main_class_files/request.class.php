<?php
class request {
static   function print_request() { if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	   $my_message=NL.'Request Data: ';
	   if (isset($_POST)){
		  foreach ($_POST as $key =>$var) { // Print each error.
			$my_message.= NL." post variable is $key = $var";}
			 }
	   if (isset($_GET)){
		 	foreach ($_GET as $key =>$var) { // Print each error.
			$my_message.= NL.'$_get variable '. $key .'='. $var ."\n";}
			}//if $-GET
		  echo $my_message;
    }
    
static function check_request_ext(){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	$array=explode(',',Cfg::Exts); 
	foreach ($array as $var){
		if (isset($_GET[$var])){
			return '.'.$var;
			}
		}
	$navobj=navigate::instance();   
	return $navobj->ext;
	}
 
 
    
static function request_pass($get_keys){  if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
    $pass=''; 
    $get_array=explode(',',$get_keys); 
    foreach ($get_array as $key){ 
	   if (isset($_GET[$key])){
		  $request=(strpos($_SERVER['REQUEST_URI'],'?')!==false)?'&':'?';
		  $pass.=$request.$key;    
		} 
	   
	   }
	   return $pass;
    }
static function get_return($get_vals){//if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);  
    $get=(!is_array($get_vals)) ? explode(',',$get_vals):$get_vals; 
    foreach ($get as $val){   
	   if (isset($_GET[$val])){  
		  return true;
		  }
 
	   } 
    return false;
    }
static function check_request_num($var,$var2=''){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
    if (isset($_GET[$var])&& is_numeric($_GET[$var])){//at this time the second var is an appendix  with unknown function haha!
	   $var=$_GET[$var];
	   return $var;
	   }
    $var2=(empty($var2))? $var:$var2;
    if (isset($_POST[$var2])&& is_numeric($_POST[$var2])){
	  $var=$_POST[$var2];
	   return  $var;
	   }
     return NULL;
    }
static function return_full_url(){
	if (!isset($_SERVER['HTTP_HOST'])||$_SERVER['HTTP_HOST']=='') return 'local php served';
	$url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
	if (!empty($_SERVER["QUERY_STRING"])){
		$url .= "?".$_SERVER['QUERY_STRING'];
		}
	return $url;	
	}
	
static function return_parse_url($url){
	$url_pieces=parse_url($url);
	printer::vert_print($url_pieces);
	}
	
static function parse_request_url(){  
	if (empty($_SERVER["QUERY_STRING"]))return;
	$x=$_SERVER['QUERY_STRING'];
	if (Sys::Query)echo $x." is query";
	$query=explode('&',$x);
	for  ($i = 0; $i < count($query); $i++) {
		$y = explode('=',$query[$i]);
		if ($y[0] == 'passvar'||$y[0] == '&passvar') { 
			$y[1] = substr($y[1],0,12);
			$msg=str_replace('%20',' ',$y[1]);
			echo'<p style="font-size:1.15em;font-weight: bold; color:#'.Cfg::Pos_color.';">Thankyou '. $msg ." your message has been sent</p>";
			}
		if ($y[0] == 'msg'||$y[0] == '&msg') { 
			$y[1] = substr($y[1],0,600);
			 $msg=str_replace(array('%20','%2'),' ',$y[1]);
			 echo'<p style="font-size:1.15em;font-weight: bold; color:#'.Cfg::RedAlert_color.';">'.$msg.'</p>';   
			}
		}
    }

static function check_request($var){
	  if (isset($_GET[$var])||isset($_POST[$var]))
	  return true;
	 return false;
	}
	
static function check_request_data($var){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
    if (isset($_GET[$var])&& !empty($_GET[$var])){
	   $var=trim($_GET[$var]);
	   return  $var;
	   }
    if (isset($_POST[$var])&&  !empty($_POST[$var])){
	  $var=trim($_POST[$var]);
	   return  $var;
	   }
     return NULL;
    }
static function check_get_session($get_vals){//if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);  
    $get=(!is_array($get_vals)) ? explode(',',$get_vals):$get_vals; 
    foreach ($get as $val){   
	   if (isset($_GET[$val])||isset($_SESSION[Cfg::Owner.$val])==1){  
		  return true;
		  }
 
	   } 
    return false;
    }    
    
    
    
}
?>