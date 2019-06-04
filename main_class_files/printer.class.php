<?php
#ExpressEdit 2.0
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
	echo '<div id="requested" >'.NL.'Posted Data: ';
	if (isset($_POST)){
		printer::vert_print($_POST);
		}
	if (isset($_GET)){ 
		if (isset($_GET)){
			echo NL.' $_Get data: '.
			printer::vert_print($_GET);
			}//if $-GET
		}
	echo '</div>'; 
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
          } 
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
     echo (!empty($msg))?'<tr><th style="padding: .5px 16px;" colspan="'.$colspan.'">'.$msg.'</th></tr>':'';
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
			echo '<td>'.$printval.'</td>';
			}
		echo '</tr>';
		$x++;
		}
		return;
	 echo '<tr class="smaller">'; 
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
	$class=(Sys::Edit)?'editbackground editcolor editfont':'whitebackground black';
     if (is_array($array) == 1){          // check if input is an array
          foreach($array as $key_val => $value) {$x++;  
               $offset = "";
               if (is_array($value) == 1){   // array is multidimensional
                    echo "<tr>"; 
                    $offset = self::v_do_offset($level);
                    echo $offset . "<td class=\"$class\">" . $key_val . "</td>";// *$x* 
                    self::vert_show_array($value, $level+1, 1);
                    }
               else{                   
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
	$class=(Sys::Edit)?'editbackground editfont info fsminfo':'whitebackground neu fsminfo';
	echo '<div class="'.$class.'"><!--print vert-->';
     echo "<table style=\"border:2px;\">\n";
     self::vert_show_array($array, 1, 0);
     echo "</table>\n";
	echo '</div><!--print vert-->';
     }
     
static function alert_neu($msg,$size=1.3,$return=false){if(Sys::Printoff||Sys::Quietmode)return;	
	 (empty($size))&&$size=.9;
     $msg= '<p style="background:#e5d805;color: white; font-size:'.($size*16).'px;">'.$msg.'</p>';
     if($return)return $msg;
     echo $msg; 
     }
     
static function alert_neg($msg,$size=.9,$return=false){if(Sys::Printoff||Sys::Quietmode)return;	
	(empty($size))&&$size=1.3;
     $msg=  '<p  style="color:white; background:red ;font-size:'.($size*16).'px;font-weight: bold; ">'.$msg.'</p>';
     if($return)return $msg;
     echo $msg;
	}
     
static function alert_span_neg($msg,$size=.9,$return=false){if(Sys::Printoff||Sys::Quietmode)return;	
	echo "\n";
	(empty($size))&&$size=1.3;
     $msg=  '<span style="clear:both;background:red;color: white; font-size:'.($size*16).'px; font-weight: bold; ">'.$msg.'</span>';
     if($return)return $msg;
     echo $msg;
	self::pclear();
     }
     
static function alert_pos($msg,$size=.9,$return=false){if(Sys::Printoff||Sys::Quietmode)return;	
	 (empty($size))&&$size=.9;
     $msg='<p class="clear editfont" style="background:#64C91D;color: white; font-size:'.($size*16).'px; font-weight: bold; ">'.$msg.'</p>';
     if($return)return $msg;
     echo $msg; 
     }
     
static function alert_span_pos($msg,$size=.9,$return=false){if(Sys::Printoff||Sys::Quietmode)return;	
	echo "\n";
	(empty($size))&&$size=1.3;
     $msg='<span class="clear editfont"  style="background:#64C91D;color: white; font-size:'.($size*16).'px; font-weight: bold; ">'.$msg.'</span>';
     if($return)return $msg;
     echo $msg;
     }

static function alert_conf($msg,$color='000',$size='1',$font='Tahoma, Geneva, sans-serif'){if(Sys::Printoff||Sys::Quietmode)return;	
	echo "\n";
	(empty($size))&&$size=1;
	$msg= '<p class="clear editbackground editfont" style="color:#'.$color.'; font-size:'.($size*16).'px; font-family:'.$font.';">'.$msg.'</p>';
     echo $msg; 
	self::pclear();
     }
     
static function alert($msg,$return=false,$class="editcolor editbackground editfont"){if(Sys::Printoff||Sys::Quietmode)return;	
     echo "\n";
     $msg= '<p class="clear '.$class.'">'.$msg.'</p>';
     if($return)return $msg;
     echo $msg;
	self::pclear();
     }
     
static function alert_size($msg,$size=.9,$class="editcolor editbackground editfont"){if(Sys::Printoff||Sys::Quietmode)return;	
	echo "\n";
     $msg= '<p style="font-size:'.($size*16).'px;" class="clear '.$class.'">'.$msg.'</p>'; 
     echo $msg;
	self::pclear();
     }
     
static function alert_span($msg,$return=false,$class="editcolor editbackground editfont"){if(Sys::Printoff||Sys::Quietmode)return;	
	echo "\n";
    $msg= '<span class="clear '.$class.'">'.$msg.'</span>';
    if($return)return $msg;
    echo $msg;
    }
    
static function printp($msg,$size=.9,$return=false){if(Sys::Printoff||Sys::Quietmode)return;	
	echo "\n";
     $msg= '<p class="clear floatleft left inherit" style="font-size:'.($size*16).'px">'.$msg.'</p>';
     if($return)return $msg;
     echo $msg;
	self::pclear();
     }
static function printx($msg,$return=false){if(Sys::Printoff||Sys::Quietmode)return;
     echo "\n";
     if($return)return $msg;
     echo $msg;
     }
     
 static function alertx($msg,$return=false){if(Sys::Printoff||Sys::Quietmode)return;	
	echo "\n";
     if($return)return $msg;
     echo $msg;
     }
     
static function print_tip($msg,$size='.9'){
	if(Sys::Printoff||Sys::Quietmode)return;
	echo "\n";
	$msg= '<p class="tip floatleft clear editfont " style="font-size:'.($size*16).'px;">'.$msg.'</p>';
	echo $msg;
	self::pclear();
	}
     
static function print_tip2($msg,$size='.9'){
	if(Sys::Printoff||Sys::Quietmode)return;
	echo "\n";
	$msg= '<p class="floatleft clear tip2 editfont" style="font-size:'.($size*16).'px;">'.$msg.'</p><!--print_tip2-->';
	echo $msg;
	self::pclear();echo '<!--print_tip2-->';
	}
     
static function print_caution($msg,$size='1'){
	if(Sys::Printoff||Sys::Quietmode)return;
	echo "\n";
	$msg= '<p class="editfont floatleft clear caution" style="font-size:'.($size*16).'px;">'.$msg.'</p>';
	echo $msg;
	self::pclear();
	}
     
static function print_warn($msg,$size='.9',$return=false){
	if(Sys::Printoff||Sys::Quietmode||empty($msg))return;
	echo "\n";
	$msg= '<p class="editfont fsminfo floatleft clear lightestmaroonbackground orange " style="font-size:'.($size*16).'px;">'.$msg.'</p>';
	echo $msg;
	self::pclear();
	}
     
static function print_notice($msg,$size='.9',$return=false){
	if(empty($msg)||Sys::Printoff||Sys::Quietmode)return;
	echo "\n";
	$msg= '<p class="bold floatleft clear smallest whitebackground black fs1salmon" style="font-size:'.($size*16).'px;">'.$msg.'</p>';
     if ($return)return $msg;
	echo $msg; 
	self::pclear();
	}	       
     
static function print_info($msg,$size=.9,$return=false){
	if(empty($msg)||Sys::Printoff||Sys::Quietmode)return;
	$size=(!is_numeric($size))?.9:$size;
     echo "\n";
	$msg= '<p class="fs1info editfontfamily info editbackground floatleft clear" style="font-size:'.($size*16).'px;">'.$msg.'</p>';
     if ($return)return $msg;
	echo $msg; 
	self::pclear();
	}
     
static function print_custom_wrap($msg,$color,$class){
	if(Sys::Printoff||Sys::Quietmode)return;
	echo "\n";  
	$class=' floatleft clear '.$class.' editfont';
	$msg= '<div class="bs1'.$color.$class.'"><!--print_custom_wrap-->
	<div class="fsm2'.$color.'"><!--print_custom_wrap second print div wrap-->';
	echo $msg; 
	self::pclear();
	}
     
static function single_custom_wrap($msg,$class){
	if(Sys::Printoff||Sys::Quietmode)return;
	echo "\n";  
	$class=' floatleft clear '.$class.' editfont';
	$msg= '<div class="'.$class.'"><!--single custom wrap -->';
     echo $msg; 
	self::pclear();
	}
     
static function close_single_wrap($msg){
	if(Sys::Printoff||Sys::Quietmode)return;
     printer::print_spacer();
	$msg= '</div><!--close_single_wrap -->';
	echo $msg; 
	self::pclear();
	}
     
static function print_spacer(){
     if (!Sys::Edit)return;
     echo '<p style="height:0px;overflow-y:hidden;visibility:hidden;">';
     for ($i=0; $i<40;  $i++)echo 'xx xx'; echo '</p><!--print spacer-->';
     }
    
static function print_wrap($msg,$color='info',$main=false,$class='editbackground editcolor editfont'){
	if(Sys::Printoff||Sys::Quietmode)return;
	echo "\n";
	$border1= ($main===true)?'bs2'.$color:'fsminfo';
	$class2=($main===true)?'fsm2'.$color:'';
	$class1=$border1.' floatleft clear '.$class;
	$msg= '<div class="'.$class1.'"><!--print_wrap-->
	<div class="'.$class2.'"><!--print_wrap second print div wrap-->';
	echo $msg; 
	}

static function print_redwrap($msg,$color=''){
	if(Sys::Printoff||Sys::Quietmode)return;
	echo "\n"; 
	$class2='fsmwhite';
	$class1='bs3redAlert bshad3'.$color.' floatleft editbackground editcolor editfont';
	$msg= '<div class="'.$class1.'"><!--print_redwrap-->
	<div class="'.$class2.'"><!--print_redwrap second print -->';
	echo $msg; 
	}     
static function print_wrap1($msg,$color='info'){
	if(Sys::Printoff||Sys::Quietmode)return;
	echo "\n";  
	$class='fsm1'.$color.' floatleft clear editbackground editcolor editfont';
	$msg= '<div class="'.$class.'"><!-print_wrap1-->';
	echo $msg; 
	}
 
static function close_print_wrap($msg='',$spacer=true){
	if(Sys::Printoff||Sys::Quietmode)return;
     ($spacer===true)&&printer::print_spacer(); 
	$msg= '</div><!--close_print_wrap close second-->
	</div><!--close_print_wrap-->';
	echo $msg; 
	printer::pclear();
	}
     
static function close_print_wrap1($msg=''){
	if(Sys::Printoff||Sys::Quietmode)return;
     printer::print_spacer();
	$msg= '</div><!--close_print_wrap1-->';
	echo $msg; 
	printer::pclear();
	}
     
static function close_print_wrap3($msg=''){
	if(Sys::Printoff||Sys::Quietmode)return;
     printer::print_spacer();
	$msg= '</div><!--close_print_wrap3-->';
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
	echo "\n";  if(Sys::Printoff||Sys::Quietmode)return;//&& print ' pclear '.$x. ' height:'.$height; 
	$height=($height==='none')?'height:0px;':'height:'.$height.'px;';  
	$msg='<p style="clear:both;display:block; '.$height.'"></p><!--pclear-->';
	if($return)return $msg;
	echo $msg;
	}

static function pclearme($height='none',$return=false){ 
	static $x=0; $x++; //if ($x==11||$x==4||$x==9)return;
	echo "\n";  if(Sys::Printoff||Sys::Quietmode)return;//&& print ' pclear '.$x. ' height:'.$height; 
	$height=($height==='none')?'height:0px;':'height:'.$height.'px;';  
	$msg='<p style="clear:both;display:block; '.$height.'"></p><!--pclearme-->';
	if($return)return $msg;
	echo $msg;
	}
		
static function pspace($height=0,$return=false){if(Sys::Printoff||Sys::Quietmode)return;	
	echo "\n";
	$msg= '<p style="height:'.$height.'px;">&nbsp;</p><!--pspace-->';
     if($return)return $msg;
     echo $msg;
	}	

static function divspace($padding=50,$return=false){	if(Sys::Printoff||Sys::Quietmode)return;
	echo "\n";
	$msg= '<div style="padding-top:'.$padding.'px;">&nbsp;</div><!--divspace-->';
     if($return)return $msg;
     echo $msg;
	}
 
static function divclear($return=false){if(Sys::Printoff||Sys::Quietmode)return;
	echo "\n";
	$msg='<div class="clear">&nbsp;</div><!--div clear-->';
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