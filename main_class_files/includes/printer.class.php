<?php
class printer {

static function return_array($array){
	 
	$print='';
	foreach ($array as $key=>$val){
		if (is_array($val)){
		    self::return_array($val);
			}
		else $print.=NL.'['.$key.'] '.$val;
		}
	return $print;	
	}
	
 
	
static   function print_request($return=false) {
	if ($return) ob_start(); 
	echo NL.'Posted Data: ';
	if (isset($_POST)){
		printer::vert_print($_POST);
		}
	if (isset($_GET)){
		if (!arrayhandler::is_empty_array($_GET)){
			echo NL.' $_Get data: '.
			printer::vert_print($_GET);
			}//if $-GET
		}
	 
	if ($return){
		$data = ob_get_contents();
		 ob_end_clean();
		 return $data;
		}
    }
    
static function printkey($arr, $echo=true) {  
    $my_message=NL.'requested print: ';
	if ($echo===true){
	   if ($arr=='post'){
		  if (isset($_POST)){
			  foreach ($_POST as $key =>$var) { // Print each error.
				echo NL." post variable is $key = $var";
				}
			 return;  	 
			 }
		  else echo 'NO POST TODAY';
		  return;
		  }
	   else if ($arr=='session'){  
		  if (isset($_SESSION)){
			  foreach ($_SESSION as $key =>$var) { // Print each error.
				echo NL." SESSION variable is $key = $var";
				}
			 return;  	 
			 }
		  else echo 'NO SESSION TODAY';
		  return;
		  }   
	   else   if ($arr=='get'){  echo 'made it to get';
		  if (isset($_GET)){
			  foreach ($_GET as $key =>$var) { // Print each error.
				echo NL." GET variable is $key = $var";
				}
			 return ;	 
			 }
		  else echo 'NO GETS TODAY';
		  return;
		  }  
	   else {
		  foreach ($arr as $key =>$var) { // Print each error.
			 echo NL."array key:  $key  var: $var"; 
			 }
		  return;
		  }
	   
	   }//if echo
    
    
    
    else {
	   if ($arr=='post'){
		  if (isset($_POST)){
			  foreach ($_POST as $key =>$var) { // Print each error.
				$my_message= NL." post variable is $key = $var";
				}
			 return $my_message;  	 
			 }
		  else $my_message=  'NO POST TODAY';
		  return $my_message;
		  }
	   else if ($arr=='session'){
		  if (isset($_SESSION)){
			  foreach ($_SESSION as $key =>$var) { // Print each error.
				$my_message=  NL." SESSION variable is $key = $var";
				}
			 return $my_message; 	 
			 }
		  else $my_message= 'NO SESSION TODAY';
		  return $my_message;
		  }   
	   else   if ($arr=='session'){
		  if (isset($_GET)){
			  foreach ($_GET as $key =>$var) { // Print each error.
				$my_message= NL." GET variable is $key = $var";
				}
			 return $my_message;;	 
			 }
		  else $my_message= 'NO GETS TODAY';
		  return $my_message;
		  }  
	   else {
		  foreach ($arr as $key =>$var) { // Print each error.
			 $my_message= NL."array key:  $key  var: $var"; 
			 }
		 return $my_message;
		  }
	   
	   }//if $my_message=if ($arr=='post'){
	    
    }

static function print_wordwrap($array,$wrap=70){
	static $html='Print Array= ';
	if (is_array($array)||is_object($array)){
		foreach ($array as $var){
			if (is_array($var)||is_object($var)){
			   foreach ($var as $var1){
					if (is_array($var1)||is_object($var1)){
						 foreach ($var1 as $var2){
							if (is_array($var2)||is_object($var2)){
								 foreach ($var2 as $var3){
									if (is_array($var3)||is_object($var3)){
										$html.='ALERT LEVEL 5 ARRAY'.print_r($var3,true);   
										}
									else if (is_string($var3)||is_numeric($var3))$html.=NL.'['.key($var2).']='.wordwrap($var3,$wrap);
									else	if(!empty($var3))$html.=NL. $var3;//so wordwrap doesn't throw error with leaked through non-string...
									}   
								}
							else if (is_string($var2)||is_numeric($var2))$html.=NL.'['.key($var1).']='.wordwrap($var2,$wrap);
							else	if(!empty($var2))$html.=NL. $var2;//so wordwrap doesn't throw error with leaked through non-string...
							}  
						}
					else if (is_string($var1)||is_numeric($var1))$html.=NL.'['.key($var).']='.wordwrap($var1,$wrap);
					else	if(!empty($var1))$html.=NL.$var1;//so wordwrap doesn't throw error with leaked through non-string...
					}
				} 
			else if (is_string($var)||is_numeric($var))$html.=NL.'['.key($array).']='.wordwrap($var,$wrap);
			else	if(!empty($var))$html.=NL. $var;//so wordwrap doesn't throw error with leaked through non-string...
			}
		}
	else return (wordwrap($array,$wrap));	
	return $html;
	}
    
 
static function dir_list($dir,$gallery_only=false){  
    // array to hold return value
    $retval = array();

    // add trailing slash if missing
    if(substr($dir, -1) != "/") $dir .= "/";

    // open pointer to directory and read list of files
    $d = @dir($dir) or die("getFileList: Failed opening directory $dir for reading");
    while(false !== ($entry = $d->read())) {
	    if($entry[0] == ".") continue;
	  if (check_data::validate_image_type($entry,$dir)){
		  $size=GetImageSize("$dir$entry");
		  $width=$size[0];
		  $height=$size[1];
		  $widthHeight=$width+$height;
		  $mime=$size['mime'];
		  }
	   else{
		  if ($gallery_only)continue;
		  $width='NA';
		  $height='NA';
		  $widthHeight='NA';
		  $mime='NA';
		  }
	    if(is_dir("$dir$entry")) {
		  $retval[] = array(
		  "name" => "$entry",
		  "type" => filetype("$dir$entry"),
		  "size" => 0,
		  "lastmod" => date("dMY-H-i-s",filemtime("$dir$entry")),
		  "$width" => $width,
		    "height" => $height,
		    "width+height" => $widthHeight,
		    "mime" => $mime);
		}
	   elseif(is_readable("$dir$entry")) {
		  $retval[] = array(
		    "name" => "$entry",
		    "size" =>  round((filesize("$dir$entry")/1000),1).'KB',
		    "type" =>  filetype("$dir$entry") ,
		    "lastmod" =>date("dMY-H-i-s",filemtime("$dir$entry")),
		    "width" => $width,
		    "height" => $height,
		    "width+height" => $widthHeight,
		    "mime" => $mime
		  );
	   }
    }
    $d->close();
    return $retval;
    }
static function array_print($value,$class='editcolor editfont editbackground'){
	if(!is_array($value)||empty($value))return;
	 
	echo '<div class="Os3salmon fsminfo"><!--print array-->';
	foreach ($value as $val){
		if (strpos($val,'{')===false)continue;
		$split=preg_split('/{/',$val,2); 
		if (count($split)==2)
			echo '<p class="'.$class.'"><span class="greenbackground white">'.$split[0].'</span>{'.$split[1].'</p>';
			 
		else	echo '<p class="'.$class.'">'.$val.'</p>';
		}
	echo '</div><!--print array-->';
	}
static function horiz_print($array,$array_keys='',$nototal='',$unit='',$msg='',$show_count=false,$emphasize=false,$class=''){ 
  if (empty($array)||!is_array($array)){ echo NL. 'Your Array is empty'; return;}
  $colspan=($show_count)?(count($array[0])+1):count($array[0]);
  $class=(empty($class)&&Sys::Edit)?'editcolor editfont editbackground border2':((!empty($class))?$class:'whitebackground black');
  echo '<table class="'.$class.'" >
  <thead>';
  echo (!empty($msg))?'<tr><th style="padding: .3em 1em;" colspan="'.$colspan.'">'.$msg.'</th></tr>':'';
  echo '<tr>';
  ($show_count)&& print '<th>Count</th>'; 
  foreach ($array[0] as $key=>$val){
    echo "<th>$key</th>";
    }
  echo'</tr>  
</thead>
<tbody>';
 self::horiz_show_array($array,$array_keys,$nototal,$unit,$show_count,$emphasize);
  echo "</tbody>
    </table>\n";
}  


static function horiz_show_array($array,$array_keys,$nototal,$unit,$show_count,$emphasize){
	$array_keys= (is_array($array_keys))?$array_keys:explode(',',$array_keys);
	$nototal= (is_array($nototal))?$nototal:explode(',',$nototal);
	if (!process_data::is_indexed($nototal)){
		foreach($nototal as $key=>$subarray){
			${$key.'_custom'}=$subarray[0];   
			${$key.'_style'}=(is_array($subarray))?' style="background:'.$subarray[1].'"':'';
			}
		 $nototal=array_keys($nototal);  
		}
	
 	foreach ($array[0]  as $key=>$val){
		${$key.'_total'}=0;  
		} 
	$x=1; 
     foreach($array as $key_val => $value) {  
          echo '<tr>';
		($show_count)&&print'<td>'.$x.'</td>';
		foreach ($value as $key_val2 =>$value2){
			if(!in_array($key_val2,$nototal)&&in_array($key_val2,$array_keys)){
				${$key_val2.'_total'}+=$value2;
				}
			$printval=(in_array($key_val2,$array_keys))?(ceil(round($value2,4)*100)/100).$unit:$value2;
			//$printval=(strlen($printval)>50)?wordwrap($printval,50,"<br>\n",true):$printval;  
			 echo '<td>'.$printval.'</td>';
			 }
		echo '</tr>';
		
		$x++;
		}
		return;
	 echo '<tr class="smaller">';// style="color:#'.Cfg::Info_color.' border-color:#'.Cfg::Info_color.' font-size:.8em;   padding: 0 5em;" colspan="'.$colspan.'">Totals: </td></tr>';
	foreach ($value as $key_val2 =>$value2){
			$total=(!in_array($key_val2,$nototal)&&in_array($key_val2,$array_keys))?'Total:':'';
			 echo '<td>'.$total.'</td>';
			 }
		echo '</tr>';  
	echo '<tr>';
	 
	foreach ($value as $key_val2 =>$value2){
			$total=(!in_array($key_val2,$nototal)&&in_array($key_val2,$array_keys))?(ceil(round(${$key_val2.'_total'},4)*100)/100).$unit:((isset(${$key_val2.'_custom'}))?${$key_val2.'_custom'}:'--');
			$style=($emphasize==$key_val2)?' style="background:#aef9b9;"':((isset(${$key_val2.'_style'}))?${$key_val2.'_style'}:'');
			 echo '<td '.$style.'>'.$total.'</td>';
			 }
		echo '</tr>';    
    } 

static function vert_show_array($array, $level, $sub ){
	static $x=0;
	$class=(Sys::Edit)?'editbackground editcolor':'whitebackground black';
    if (is_array($array) == 1){          // check if input is an array
       foreach($array as $key_val => $value) {$x++;  
           $offset = "";
           if (is_array($value) == 1){   // array is multidimensional
           echo "<tr>";
		 
           $offset = self::v_do_offset($level);
           echo $offset . "<td class=\"$class\">" . $key_val . "</td>";// *$x* 
           self::vert_show_array($value, $level+1, 1);
           }
           else{                        // (sub)array is not multidim
           if ($sub != 1){          // first entry for subarray
               echo '<tr class="nosub">';
               $offset = self::v_do_offset($level);
           }
           $sub = 0;
           echo $offset . '<td class="'.$class.'" >' . $key_val . 
               '</td><td class="'.$class.'"> ' . $value .'</td>'; //*'.$x.'*
           echo "</tr>\n";
           }
       } //foreach $array
    }  
    else{ // argument $array is not an array
        return;
    }
}
static function v_do_offset($level){
    $offset = "";             // offset for subarry 
    for ($i=1; $i<$level;$i++){
    $offset = $offset . "<td></td>";
    }
    return $offset;
}
static function vert_print($array){
	if (count($array)==0)return;
	$class=(Sys::Edit)?'editbackground info fsminfo':'whitebackground neu fsminfo';
	echo '<div class="'.$class.'"><!--print vert-->';
	 echo "<table style=\"border:2px;\">\n";
	 self::vert_show_array($array, 1, 0);
	 echo "</table>\n";
	echo '</div><!--print vert-->';
}
static function alert_neu($msg,$size=1.3,$return=false){if(Sys::Printoff||Sys::Quietmode)return;	
	echo "\n";
	(empty($size))&&$size=.9;
     $msg= '<p style="background:#e5d805;color: white; font-size:'.$size.'em;">'.$msg.'</p>';
    if($return)return $msg;
    echo $msg;
    }
static function alert_neg($msg,$size=.9,$return=false){if(Sys::Printoff||Sys::Quietmode)return;	
	echo "\n";
	(empty($size))&&$size=1.3;
      $msg=  '<p  style="color:white; background:red ;font-size:'.$size.'em;font-weight: bold; ">'.$msg.'</p>';
    if($return)return $msg;
    echo $msg;
    }
static function alert_span_neg($msg,$size=.9,$return=false){if(Sys::Printoff||Sys::Quietmode)return;	
	echo "\n";
	(empty($size))&&$size=1.3;
      $msg=  '<span style="background:red;color: white; font-size:'.$size.'em; font-weight: bold; ">'.$msg.'</span>';
    if($return)return $msg;
    echo $msg;
    }    
static function alert_pos($msg,$size=.9,$return=false){if(Sys::Printoff||Sys::Quietmode)return;	
	echo "\n";
	(empty($size))&&$size=.9;
      $msg='<p style="background:#64C91D;color: white; font-size:'.$size.'em; font-weight: bold; ">'.$msg.'</p>';
    if($return)return $msg;
    echo $msg;
    }
static function alert_span_pos($msg,$size=.9,$return=false){if(Sys::Printoff||Sys::Quietmode)return;	
	echo "\n";
	(empty($size))&&$size=1.3;
      $msg='<span style="background:#64C91D;color: white; font-size:'.$size.'em; font-weight: bold; ">'.$msg.'</span>';
    if($return)return $msg;
    echo $msg;
    }

static function alert_conf($msg,$color='000',$size='1',$font='Tahoma, Geneva, sans-serif'){if(Sys::Printoff||Sys::Quietmode)return;	
	echo "\n";
	(empty($size))&&$size=1;
	 $msg= '<p class="editbackground" style="color:#'.$color.'; font-size:'.$size.'em; font-family:'.$font.';">'.$msg.'</p>';
    
    echo $msg;
    }
static function alert($msg,$return=false,$class="editcolor editbackground"){ if(Sys::Printoff||Sys::Quietmode)return;	
	echo "\n";
    $msg= '<p class="'.$class.'">'.$msg.'</p>';
    if($return)return $msg;
    echo $msg;
    }
static function alert_span($msg,$return=false,$class="editcolor editbackground"){ if(Sys::Printoff||Sys::Quietmode)return;	
	echo "\n";
    $msg= '<span class="'.$class.'">'.$msg.'</span>';
    if($return)return $msg;
    echo $msg;
    }
    
static function printit($msg,$return=false,$class="ramanafullblock"){ if(Sys::Printoff||Sys::Quietmode)return;	
	echo "\n";
    $msg= '<p class="'.$class.'">'.$msg.'</p>';
    if($return)return $msg;
    echo $msg;
    }
static function printx($msg,$return=false){ if(Sys::Printoff||Sys::Quietmode)return;

	echo "\n";
     if($return)return $msg;
    echo $msg;
    }    
 static function alertx($msg,$return=false){if(Sys::Printoff||Sys::Quietmode)return;	
	echo "\n";
     if($return)return $msg;
    echo $msg;
    }
static function print_tip($msg,$size='1'){
	 if(Sys::Printoff||Sys::Quietmode)return;
	echo "\n";
	$msg= '<p class="tip width100" style="font-size:'.$size.'em;">'.$msg.'</p>';
	echo $msg;
	}
static function print_caution($msg,$size='1'){
	 if(Sys::Printoff||Sys::Quietmode)return;
	echo "\n";
	$msg= '<p class="caution width100" style="font-size:'.$size.'em;">'.$msg.'</p>';
	echo $msg;
	}
static function print_warn($msg,$size='1'){
	 if(Sys::Printoff||Sys::Quietmode)return;
	echo "\n";
	$msg= '<p class="warn1 width100" style="font-size:'.$size.'em;">'.$msg.'</p>';
	echo $msg;
	}
static function print_info($msg,$size='1'){
	 if(Sys::Printoff||Sys::Quietmode)return;
	echo "\n";
	$msg= '<p class="fsminfo editcolor editbackground floatleft" style="font-size:'.$size.'em;">'.$msg.'</p>';
	echo $msg;
	printer::pclear();
	}	   

static function print_wrap($msg,$class='editbackground floatleft fsminfo editcolor'){
	 if(Sys::Printoff||Sys::Quietmode)return;
	echo "\n";
	$msg= '<div class="'.$class.'"><!--wrap '.$msg.'-->';
	echo $msg;
	printer::pclear();
	}
static function close_print_wrap($msg){
	 if(Sys::Printoff||Sys::Quietmode)return;
	$msg= '</div><!--wrap '.$msg.'-->';
	echo $msg;
	printer::pclear();
	}
static function spanspace($padding=50,$return=false){	if(Sys::Printoff||Sys::Quietmode)return;
	echo "\n";
	$msg= '<span style="padding-top:'.$padding.'px;">&nbsp;</span>';
    if($return)return $msg;
    echo $msg;
	}
static function spanclear($height=0,$return=false){if(Sys::Printoff||Sys::Quietmode)return;
	static $x=0; $x++; //if ($x==11||$x==4||$x==9)return;
	echo "\n";   (Sys::Printoff||Sys::Quietmode)&& print ' spanclear '.$x; 
	$height=($height==='none')?'height:0px;':'height:'.$height.'px;';
	$msg='<span style="clear:both;display:block; '.$height.'"></span>';
	if($return)return $msg;
	echo $msg;
	}

static function pclear($height='none',$return=false){if(Sys::Clearoff)return;
	static $x=0; $x++; //if ($x==11||$x==4||$x==9)return;
	echo "\n";   if(Sys::Printoff||Sys::Quietmode)return;//&& print ' pclear '.$x. ' height:'.$height; 
	$height=($height==='none')?'height:0px;':'height:'.$height.'px;';  
	$msg='<p style="clear:both;display:block; '.$height.'"></p>';
	if($return)return $msg;
	echo $msg;
	}

static function pclearme($height='none',$return=false){ 
	static $x=0; $x++; //if ($x==11||$x==4||$x==9)return;
	echo "\n";   if(Sys::Printoff||Sys::Quietmode)return;//&& print ' pclear '.$x. ' height:'.$height; 
	$height=($height==='none')?'height:0px;':'height:'.$height.'px;';  
	$msg='<p style="clear:both;display:block; '.$height.'"></p>';
	if($return)return $msg;
	echo $msg;
	}
		
static function pspace($height=0,$return=false){if(Sys::Printoff||Sys::Quietmode)return;	
	echo "\n";
	$msg= '<p style="height:'.$height.'px;">&nbsp;</p>';
    if($return)return $msg;
    echo $msg;
	}	

static function divspace($padding=50,$return=false){	if(Sys::Printoff||Sys::Quietmode)return;
	echo "\n";
	$msg= '<div style="padding-top:'.$padding.'px;">&nbsp;</div>';
    if($return)return $msg;
    echo $msg;
	}
 
static function divclear($return=false){if(Sys::Printoff||Sys::Quietmode)return;
	echo "\n";
	$msg='<div class="clear">&nbsp;</div>';
    if($return)return $msg;
    echo $msg;
	}
 
static function defined_configs(){
	}
	
static function html_header(){
	echo '<html><head><title>Test Run</title>
	</head><body>';
	}
}//end class
?>