<?php
#ExpressEdit 2.0
class process_data extends Singleton{
private static $instance=false; //store instance 
 
static function spam_scrubber($value,$strict=false,$trim=true,$real_escape=true) {if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	$block=array('?','head');// by default <script> allowed
	#for checkbox's repopulate keys....
     ($strict==='convert')&&$value=self::html_entity($value); //convert database
	($strict==='strict')&&$value=strip_tags($value); //feedback
     foreach($block as $var){
		$var=('?')?'\?':$var;
	     $pattern='/^<\s*('.$var.')/';
	     if(preg_match($pattern,$value)){// detector...
			$msg= "the term'<'  and $var detected and html entities activated";
		     $value=htmlentities($value);
		     }
	     }  
	$value=self::cleanup($value);//multifunction conversion
	if ($real_escape){
		$mysqlinst = mysql::instance(); 
		$value=$mysqlinst->escape($value);
		}
	if ($trim)
	return trim($value);
	return ($value);   
     } // End of spam_scrubber() function.

	# database is stored with breaks <br >
	#these are replaced with remove_html_break

static function un_scrub($value){
	return stripslashes(str_replace(array(' &amp; ',' &amp;','&amp; ','&amp;'),'&',$value));
	}
	
static function implode_retain_vals($value,$oldvalue,$glue=',',$second_glue='',$third_glue=''){
	#psuedo implode the keys, make sure 0 is placed in for any missing key that wasn't posted
	$implode='';
	$value=(is_array($value))?$value:explode($glue,$value); 
	$oldvalue=(is_array($oldvalue))?$value:explode($glue,$oldvalue); 
	$max_key1 = max(array_keys($value)); // these lines are to preserve the imploded order
	$max_key2 = max(array_keys($oldvalue)); // these lines are to preserve the imploded order
	$max_key=max($max_key1,$max_key2); 
	for ($i=0;$i<=$max_key;$i++){#make sure array implode has 0 put in
		if (!array_key_exists($i,$value)){
			if (array_key_exists($i,$oldvalue)){
				$implode.=$oldvalue[$i].$glue;
				}
			else  $implode.=''.$glue;
			}	
		elseif (array_key_exists($i,$value)&&is_array($value[$i])){  
			if (empty($second_glue)){
				mail::alert('going to deep with current recursion in process_data');
				return;
				}
			$oldvalue[$i]=(array_key_exists($i,$oldvalue))?$oldvalue[$i]:'';
			$implode.=self::implode_retain_vals($value[$i],$oldvalue[$i],$second_glue,$third_glue).$glue; 
			}
		elseif (array_key_exists($i,$value)){
			$implode.=trim($value[$i]).$glue;
			} 
		}
	$value=rtrim($implode,',');	
	$value=rtrim($value,'@@');
	$value=self::spam_scrubber($value);
	return $value;
	}
	
	
static function implode_retain_keys($value,$glue=',',$old_glue=','){ 
	$implode='';
	if(is_array($value)){
		$max_key = max(array_keys($value)); // these lines are to preserve the imploded order
		for ($i=0;$i<=$max_key;$i++){#make sure array implode has 0 put in
			if (array_key_exists($i,$value)&&is_array($value[$i])){
				if ($glue=='@@')mail::alert('going to deep with current recursion in process_data');
				$implode.=self::implode_retain_keys($value[$i],'@@',$old_glue).$glue;
				$glue=$old_glue;
				}
			else {
			 	 if (array_key_exists($i,$value)){
					$implode.=$value[$i].$glue;
					}
				else $implode.='0'.$glue;
				}
			}
		$value=rtrim($implode,',');	
		$value=rtrim($value,'@@'); 
		}
	return $value;
	}
     
static function clean_sort($value){//used in navigation
	$value=str_replace('&nbsp;',' ',$value);
	$value=str_replace('&amp;','&',$value);
	$value  = str_replace(array('<br >',' <br>','<br / >','<br>','<br/>','<br  >','<br />',"\r\n","\n","\r"),' ', $value);
	$value = str_replace('&lt;','<', $value);// 
	$value = str_replace('&gt;','>', $value);// 
	$value = str_replace('&#60;','<', $value);// 
	$value = str_replace('&62;','>', $value);// 
	return $value;
	}
     
static function restore_sort($value){
     $value=strip_tags($value);//leaves rest unnec.
	$value=str_replace('*','&nbsp;',$value);
	$value = str_replace('<','&lt;', $value);// 
	$value = str_replace('>','&gt;', $value);// 
	return $value;
	}

static function cleanup ($value){//used during editpages submitted for updating database values
	if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__); #run for processor
	$pattern='/<h(1|2|3|4|5|6)\ >/';
	$value=preg_replace($pattern,'<h$1>',$value);//if inserted htag mce puts space in it
	$pattern='/<\\\\h(1|2|3|4|5|6)\ >/';
	$value=preg_replace($pattern,'<\/h$1>',$value);
	$value = str_replace(array('<br >',' <br>','<br / >','<br/>','<br  >','<br />',"\r\n","\n","\r"),'<br>', $value);//problem in tinymce unknown
	$value =mb_convert_encoding($value,'HTML-ENTITIES');
	$value = str_replace(array("'",'â€™'),'&rsquo;', $value); #had used other quotes from mac 
	$value = str_replace("&lt;a","<a", $value); //convert back
	$value = str_replace("&lt;/a&gt;","</a>", $value);//convert back
	//$value = str_replace("&lt;","<", $value); //convert back
	// $value = str_replace("&gt;",">", $value);//convert back
	$value = str_replace("(CR)","&#169;", $value);
	 //$pattern='/&([^\ #])/';// if not a space.. the following cleans up sea&sand to sea &amp; sand
	 //$value =preg_replace($pattern,'& $1',$value);//$1 in parenthesis
	//$pattern='/([^\ ])&[^#]/'; //means everything but a space or a number
	//$value =preg_replace($pattern,'$1 &',$value);
	$value=str_replace('& amp;','&amp;',$value);
	$value=str_replace('& lt;','&lt;',$value); 
	$value=str_replace('& gt;','&gt;',$value);
	$value=str_replace ('& nbsp;','&nbsp;',$value);
	//$value=str_replace ('& #8217;','&rsquo;',$value);
	//$value=str_replace ('& #169;','&#169;',$value);
	$value=str_replace ('&amp; nbsp;','&nbsp;',$value);
	$value=str_replace (' &nbsp;','&nbsp;',$value);
	$value = str_replace("& ","&amp; ", $value); //convert back
	return $value;
	}
     
static function import_cleanup ($value){//used during editpages submitted for updating database values
	if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__); #run for processor
		$value = str_replace(array("'"),'&rsquo;', $value); #had used other quotes from mac
	$value =mb_convert_encoding($value,'HTML-ENTITIES');
	$value = str_replace("&lt;a","<a", $value); //convert back
	$value = str_replace("&lt;/a&gt;","</a>", $value);//convert back
	//$value = str_replace("&lt;","<", $value); //convert back
	// $value = str_replace("&gt;",">", $value);//convert back
	 //$pattern='/&([^\ #])/';// if not a space.. the following cleans up sea&sand to sea &amp; sand
	 //$value =preg_replace($pattern,'& $1',$value);//$1 in parenthesis
	//$pattern='/([^\ ])&[^#]/'; //means everything but a space or a number
	//$value =preg_replace($pattern,'$1 &',$value);
	$value=str_replace('& amp;','&amp;',$value);
	$value=str_replace('& lt;','&lt;',$value); 
	$value=str_replace('& gt;','&gt;',$value);
	$value=str_replace ('& nbsp;','&nbsp;',$value);
	//$value=str_replace ('& #8217;','&rsquo;',$value);
	//$value=str_replace ('& #169;','&#169;',$value);
	$value=str_replace ('&amp; nbsp;','&nbsp;',$value);
	$value=str_replace (' &nbsp;','&nbsp;',$value);
	$value = str_replace("& ","&amp; ", $value); //convert back
	return $value;
	}
     
static function clean_break($value){ 
	$value =mb_convert_encoding($value,'UTF-8');
	$value =mb_convert_encoding($value,'HTML-ENTITIES');
	$patterns = "/<br >|< br>|<br \/>|<br\/>|<br  >|<br \/>|<br >/i";
     $replacements = "<br>";
	$value = preg_replace($patterns, $replacements, $value);  
	return $value;                        
	}
     
static function convert_line_break($value) { // for  javascript text box applications
	$patterns = "/\r\n|\n|\r/i";
     $replacements = "<br>";                         
	//$value = preg_replace($patterns, $replacements, self::clean_break($value)); 
	return $value;
	}
     
static function remove_line_break($value) { // for  javascript text box applications
	$value=self::clean_break($value);  
	$patterns = "/<br>/i";
     $replacements = "\n";                         
	$value = preg_replace($patterns, $replacements, $value); 
	return $value;
	}
     
static function remove_html_break($value) {  //normal transaction used for editpages_obj to populate edit data...
	$value=self::clean_break($value);
	$patterns = "/<br>\r\n|<br>\r|<br>\n|<br>|\r\n|\n|\r/i";
     $replacements = "\n";                         
	$value = preg_replace($patterns, $replacements, $value);
	$value=self::remove_characters($value);// replaces all breaks include nl2br treated with "\n"
	 //$value  = str_replace("&#169;" , "(CR)", $value );  
     return $value;
	}	
	
static function textarea_validate($value){# still used 
	$value =mb_convert_encoding($value,'HTML-ENTITIES');
     $value = str_replace('<a','&lt;a', $value); 
     $value = str_replace('</a>','&lt;/a&gt;', $value);
     $value = str_replace('<span','&lt;span', $value);
     $value = str_replace('</span','&lt;/span', $value);
     return  $value;
     } // End	
	
 static function remove_characters($value){//this takes place in editpages_obj to populate the data so affects only the editpages display so it doesn't display the breaks..
	#not currently used...
	$value  = str_replace(array('<br>','<br >','<br>'),"\r\n" , $value);
	if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);   
 	//$value  = str_replace( "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;","(tab)", $value );
	$value = str_replace("'","&rsquo;",$value); 
 	#$value = str_replace("<a","&lt;a", $value); //convert to remove error validation
	#$value = str_replace("</a>","&lt;/a&gt;", $value);//convert to remove error validation
	return  $value;
	}
    
static function replace_break($value){//not used currently
	$value  = str_replace(array('<br>', '<br/ >','< br>','<br >','<br>'), "\n", $value);   #this acts to disoplay only on editmode where it appears in textbox and will behave  for the normal line break:  line breaks won't show up with echo of line stream!!
	return  $value;
	}
    
static function  html_entity($value){
	$pattern='/<(.*)>/Us';
	preg_match_all($pattern,$value,$matches);
	$arr=explode(',','a,abbr,address,area,article,aside,audio,b,base,bdi,bdo,blockquote,body,br,br/,br /,button,canvas,caption,cite,code,col,colgroup,data,datalist,dd,del,details,dfn,dialog,div,dl,dt,em,embed,fieldset,figcaption,figure,footer,form,h1,h2,h3,h4,h5,h6,head,header,hgroup,hr,html,i,img,input,ins,kbd,keygen,label,legend,li,link,main,map,mark,menu,menuitem,meta,meter,nav,noscript,ol, optgroup,option,output,p,param,pre,progress,q,rb,rp,rt,rtc,ruby,s,samp,section,select,small,source,span,strong,style,sub,summary,sup,table,tbody,td,template,textarea,tfoot,th,thead,time,title,tr,track,u,ul,var,video,wbr');
	foreach ($matches[1] as $match){ 
		$flag=true;
		foreach ($arr as $check){
			$sl=strlen($check)+1; 
			if ($match===$check||$match==='/'.$check||substr($match,0,$sl)===$check.' '){
				$flag=false;  
				break;
				}
			}//foreach arr
		if ($flag){
			$value=str_replace('<'.$match,'&lt;xxxx'.$match.'xxxx',$value);
			//$value=str_replace('<'.$match,'&lt;'.$match,$value);
			$msg=NL.$match . ' is blocked in imported database record starting with '. substr($value,0,50);
			//mail::alert($msg);
			$_SESSION[Cfg::Owner.'update_msg'][]=printer::alert_neg($msg,1.3,true);
			}
		}//foreach matches
	return $value;
	}
     
static function explode_breaks($value){  
	if(strpos($value,'<br>')===false){
		$value=self::non_break_space($value);//replace spaces with nbsp at beggining of value
		return $value;
		}
	$value_array=explode('<br>',$value);// this will cleanup empty spaces around line breaks..
	$new_value='';				 
	foreach ($value_array as $value){
		if (!empty($value))$value=self::non_break_space($value);
		$new_value.=$value.'<br>';
		} 
	return rtrim($new_value,'<br>');
	}
	
static function non_break_space($value){ 
	$i=true; $x=0; 
	while ($i===true){
		if (substr($value,$x,1)===' '){
			$x++;
			}
		else $i=false;
		if ($x>5)$i=false;#allow for upto 15 spaces
		}
	$nb='';	
	if ($x >0){
		for ($i=0;$i<$x;$i++){
			$nb.='&nbsp;';
			}
		$value=substr_replace($value,$nb,0,$x);   
		} 
	return $value;	
	}

static function natkrsort($array){
    $keys = array_keys($array);
    natsort($keys);
     $new_array=array();
     foreach ($keys as $k){
          $new_array[$k] = $array[$k];
          }
	$new_array = array_reverse($new_array, false);
	return $new_array;
	}
	
static function email_scrubber($value){
	$very_bad = array('to:', 'cc:', 'bcc:', 'content-type:', 'mime-version:', 'multipart-mixed:', 'content-transfer-encoding:');
	foreach ($very_bad as $v) {
		if (strpos($value, $v) !== false){ 
			$value= '';
			return;
			}
		}
	$value = str_replace(array('"', "\\r", "\\n", "%0a", "%0d"), ' ', $value);
	$value=htmlentities(strip_tags($value));
	return $value;
	}

static function clean_filename($value,$length=30,$replacement='_'){
	While ($value[0]=='.'||$value[0]=='_'){ 
		$value=substr_replace($value,'',0,1);
		}  
	return substr(self::spam_scrubber(preg_replace('/[^a-zA-Z0-9_.]/', $replacement,str_replace(' ',$replacement,strtolower($value)))),0,$length);
	}
     
static function clean_title($value,$length=125){ 
	$value=substr(self::spam_scrubber($value),0,$length); 
	return $value;
	}
	
static function copy_new_image($file,$dir){
	$alt='';
	if (strpos($file,','))list($file,$alt)=self::process_pic($file); 
	if (strpos($file,'.')===false)return false;
	$path_parts = pathinfo($file);  
	$ext=$path_parts['extension'];
	$ext_arr=explode(',',Cfg::Valid_pic_ext);
	if (!in_array(strtolower($ext),$ext_arr))return false; 
	if (!is_file($dir.$file))return Cfg::Pass_image;
	$ext='.'.$ext;  
	$filename=$path_parts['filename'];
	$x=1;
	$array=explode('__',$filename); 
	$last=$array[count($array)-1];   
	if (is_numeric($last)&&$last<1000){ 
		$filename=array_pop($array);
		$filename=implode('__',$array).'__';
		$x=$last++;
		}
	else {
		$filename=$filename.'__';
		$x=1;
		}
	while (is_file($dir.$filename.$x.$ext)){
		$x++;
		}
	if (!copy($dir.$file,$dir.$filename.$x.$ext))$_SESSION[Cfg::Owner.'update_msg'][]=printer::alert_neg("Copy ErroR $dir$file => $dir.$filename.$x.$ext",1.2,true);
	$alt=str_replace($file,$filename.$x.$ext,$alt);
	if(!empty($alt)) return  $filename.$x.$ext.','.$alt;
	return  $filename.$x.$ext;
	}
	
static function new_file($new_file,$ext='.php',$dir=Cfg_loc::Root_dir,$length=60){
	if (empty($new_file)||is_numeric($new_file)){
		$msg="Your filename $new_file is improperly formed1";
		mail::alert($msg);
		exit ('tryagain');
		}
	$ext='.'.trim($ext,'.');
	if (!is_file($dir.$new_file.$ext))return substr($new_file,0,$length);
	$new_file=substr($new_file,0,$length-1);
	if (empty($new_file)||is_numeric($new_file)){
		$msg="Your filename $new_file is improperly formed2";
		mail::alert($msg);
		exit ('tryagain');
		}
	$i=1;
	while (is_file($dir.$new_file.$i.$ext)){
		$i++;
		}
	return $new_file.$i;
	} 
 
static function check_gallery(){
	$check=explode(',',Cfg::Check_gallery);#currently expand reorder and gallery
	foreach ($check as $ext){//checking for gallery reorder  status
		if (strpos(Sys::Self,$ext)){
			return true;
			}
		}
	return false;
	}
	
static function html2rgb($color)//stack overflow
{
     if ($color[0] == '#')
         $color = substr($color, 1);
 
     if (strlen($color) == 6)
         list($r, $g, $b) = array($color[0].$color[1],
                                  $color[2].$color[3],
                                  $color[4].$color[5]);
     elseif (strlen($color) == 3)
         list($r, $g, $b) = array($color[0].$color[0], $color[1].$color[1], $color[2].$color[2]);
     else
         return false;
 
     $r = hexdec($r); $g = hexdec($g); $b = hexdec($b);
 
     return array($r, $g, $b);
     }


static function rgb2html($r, $g=-1, $b=-1)//stack overflow
{
    if (is_array($r) && sizeof($r) == 3)
        list($r, $g, $b) = $r;

    $r = intval($r); $g = intval($g);
    $b = intval($b);

    $r = dechex($r<0?0:($r>255?255:$r));
    $g = dechex($g<0?0:($g>255?255:$g));
    $b = dechex($b<0?0:($b>255?255:$b));

    $color = (strlen($r) < 2?'0':'').$r;
    $color .= (strlen($g) < 2?'0':'').$g;
    $color .= (strlen($b) < 2?'0':'').$b;
    return $color;
}

static function process_backgrounddata($style){
     $stylearray=(is_array($style))?$style:explode($style);
     $back_index=$style_array[$this->background_index]; 
     $blogbackgroundcolor=explode('@@',$back_index)[0];
     echo  $blogbackgroundcolor. ' is back col';
     return  $blogbackgroundcolor;
     }

static function xxprocess_backgrounddata($background){   
     $background_array=explode(',',$background);
     $color=$background_array[0];  
     if(array_key_exists(1,$background_array)&&!empty($background_array[1]))$picname=$background_array[1];
     else $picname=0;
     if(array_key_exists(2,$background_array)&&!empty($background_array[2]))$use_image=$background_array[2];
     else $use_image=0;
     if(array_key_exists(3,$background_array)&&!empty($background_array[3]))$repeat_image=$background_array[3];
     else $repeat_image='no-repeat';
     if(array_key_exists(4,$background_array)&&!empty($background_array[4]))$image_horiz=$background_array[4];
     else $image_horiz='0';
     if(array_key_exists(5,$background_array)&&$background_array[5]!=='')$image_vert=$background_array[5];
     else $image_vert='50';
     $background_repeat=($repeat_image==1) ?' background-repeat:no-repeat; ':' background-repeat: '.$repeat_image.'; ';   
     $background_image=(!empty($use_image)&&!empty($picname)&&$picname!=1) ? ' background-image:url('.Cfg_loc::Root_dir.$picname.'); '.$background_repeat .'background-position: '.$image_horiz.'% '.$image_vert.'% ' : ' ';   
     $backgroundColor=(preg_match(Cfg::Preg_color,$color))?' background:#'.$color.'; ':""; //checks validity of color 
     return $backgroundColor.$background_image;
	}
	
static function process_pic($pic){
	$pic_array=explode(',',$pic);
	$pic=$pic_array[0];  
	if(array_key_exists(1,$pic_array)&&!empty($pic_array[1]))$alt=$pic_array[1];
	else $alt='Image Pic '.substr($pic,0,strpos($pic,'.'));
	return array($pic,$alt);
	}
	
 
      
static function process_link($link_info){
	$link_info_array=explode(',',$link_info);   
	$link_info=str_replace(array('http://','http:/','http:','http;//','http'),'',$link_info_array[0]);  
	$display=(array_key_exists(1,$link_info_array)&&!empty($link_info_array[1]))?$link_info_array[1]:$link_info;
	return array($link_info,$display);
	}
  
static function check_duo_data($var,$var2){ if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
     if (!empty($var)){//at this time the second var is an appendix  with unknown function haha!
          return trim($var);
          }
     if (!empty($var2)){//at this time the second var is an appendix  with unknown function haha!
          return trim($var2);
          }
     return NULL;
     }

static  function title_case($title) { if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
     $smallwordsarray = array('of','a','the','and','an','or','nor','but','is','if','then','else','when', 
       'at','from','by','on','off','for','in','out','over','to','into','with'); 
     $words = explode(' ', $title); 
     foreach ($words as $key => $word){ 
          if ($key == 0 or !in_array($word, $smallwordsarray)) 
               $words[$key] = ucwords(strtolower(str_replace(array('data','_'),' ',str_replace('indexpage','Home Page',$word)))); 
          } 
     $newtitle = implode(' ', $words); 
     return $newtitle; 
     }
 
static function create_table($tablename){
	$q="CREATE TABLE IF NOT EXISTS `$tablename` (
		`pic_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
		`pic_order` tinyint(3) unsigned NOT NULL,
		`bigname` tinytext NOT NULL,
		`littlename` tinytext NOT NULL,
		`imagetitle` tinytext,
		`description` text,
		`subtitle` text,
		`width` smallint(4) unsigned NOT NULL DEFAULT '150',
		`height` smallint(4) unsigned NOT NULL DEFAULT '150',
		`imagetype` tinytext,
		`galleryname` tinytext,
		`text` text,
		`temp_pic_order` tinyint(3) unsigned NOT NULL DEFAULT '0',
		`reset_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
		   PRIMARY KEY (`pic_id`)
	   ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ";
	return $q; 
	}
     
static function get_viewport($height=false){
	#modified implementation of GitHub:    https://github.com/MattWilcox/Adaptive-Images
	#used for serving appropriate image-sizes...
	$viewport_current_width=0;
	$viewport_total_height=0;
	$dpiRatio = 1; 
	if (isset($_COOKIE['dpiRatio'])) { 
		$dpiRatio = $_COOKIE['dpiRatio'];
		if ( preg_match("/^[0-9]+[,]*[0-9\.]+$/", "$dpiRatio"))  { // the cookie is valid, do stuff with it
			$cookie_data   = explode(",", $_COOKIE['dpiRatio']);
			$dpiRatio  =  $cookie_data[0]; // the base resolution (CSS pixels)
			($dpiRatio >.2)&&$dpiRatio=min($dpiRatio,2.5); 
			} 
		} 
	if (isset($_COOKIE['clientW'])) { 
		$cookie_value = $_COOKIE['clientW'];
		if (preg_match("/^[0-9]+[,]*[0-9\.]+$/", "$cookie_value")) {  // the cookie is valid, do stuff with it
			$cookie_data   = explode(",", $_COOKIE['clientW']);
			$client_width  =  $cookie_data[0]; // the base resolution (CSS pixels)
			if ($client_width >100){
				$viewport_current_width = $client_width;
				return (int) ($viewport_current_width);//*$dpiRatio
				}
			}
		}
	if (isset($_COOKIE['screenW'])) { 
		$cookie_value = $_COOKIE['screenW'];
		if (preg_match("/^[0-9]+[,]*[0-9\.]+$/", "$cookie_value")) {
			$cookie_data   = explode(",", $_COOKIE['screenW']);
			$screen_width  =   $cookie_data[0]; // the base resolution (CSS pixels)
			if (array_key_exists(1,$cookie_data)&&is_numeric($cookie_data[1])) { // the device's pixel density factor (physical pixels per CSS pixel)
				$viewport_total_height = $cookie_data[1];// not being used
				return (int)($viewport_current_width);//*$dpiRatio
				}
			$viewport_current_width=$screen_width; 
			}
		}
	return 500;
	}
     
static function colourBrightness($hex, $percent) {
	// from Barley Fitz Designs
	$hash = '';
	if (stristr($hex,'#')) {
		$hex = str_replace('#','',$hex);
		$hash = '#';
		}
	if (strlen($hex)==3){
		$hex=  $hex[0] . $hex[0] . $hex[1] . $hex[1]. $hex[2]. $hex[2];
		}
	/// HEX TO RGB
	$rgb = array(hexdec(substr($hex,0,2)), hexdec(substr($hex,2,2)), hexdec(substr($hex,4,2)));
	//// CALCULATE 
	for ($i=0; $i<3; $i++) {
		// See if brighter or darker
		if ($percent > 0) {
			// Lighter
			$rgb[$i] = round($rgb[$i] * $percent) + round(255 * (1-$percent));
		} else {
			// Darker
			$positivePercent = $percent - ($percent*2);
			$rgb[$i] = round($rgb[$i] * $positivePercent) + round(0 * (1-$positivePercent));
		}
		// In case rounding up causes us to go to 256
		if ($rgb[$i] > 255) {
			$rgb[$i] = 255;
		}
	}
	//// RBG to Hex
	$hex = '';
	for($i=0; $i < 3; $i++) {
		// Convert the decimal digit to hex
		$hexDigit = dechex($rgb[$i]);
		// Add a leading zero if necessary
		if(strlen($hexDigit) == 1) {
		$hexDigit = "0" . $hexDigit;
		}
		// Append to the hex string
		$hex .= $hexDigit;
	}
	return $hex;
	}

static function RGBtoHSV($R, $G, $B)    // RGB values:    0-255, 0-255, 0-255
{
/* * Licensed under the terms of the BSD License.
 * (Basically, this means you can do whatever you like with it,
 *   but if you just copy and paste my code into your app, you
 *   should give me a shout-out/credit :)
 */

// HSV values:    0-360, 0-100, 0-100
    // Convert the RGB byte-values to percentages
    $R = ($R / 255);
    $G = ($G / 255);
    $B = ($B / 255);

    // Calculate a few basic values, the maximum value of R,G,B, the
    //   minimum value, and the difference of the two (chroma).
    $maxRGB = max($R, $G, $B);
    $minRGB = min($R, $G, $B);
    $chroma = $maxRGB - $minRGB;

    // Value (also called Brightness) is the easiest component to calculate,
    //   and is simply the highest value among the R,G,B components.
    // We multiply by 100 to turn the decimal into a readable percent value.
    $computedV = 100 * $maxRGB;

    // Special case if hueless (equal parts RGB make black, white, or grays)
    // Note that Hue is technically undefined when chroma is zero, as
    //   attempting to calculate it would cause division by zero (see
    //   below), so most applications simply substitute a Hue of zero.
    // Saturation will always be zero in this case, see below for details.
    if ($chroma == 0)
        return array(0, 0, $computedV);

    // Saturation is also simple to compute, and is simply the chroma
    //   over the Value (or Brightness)
    // Again, multiplied by 100 to get a percentage.
    $computedS = 100 * ($chroma / $maxRGB);

    // Calculate Hue component
    // Hue is calculated on the "chromacity plane", which is represented
    //   as a 2D hexagon, divided into six 60-degree sectors. We calculate
    //   the bisecting angle as a value 0 <= x < 6, that represents which
    //   portion of which sector the line falls on.
    if ($R == $minRGB)
        $h = 3 - (($G - $B) / $chroma);
    elseif ($B == $minRGB)
        $h = 1 - (($R - $G) / $chroma);
    else // $G == $minRGB
        $h = 5 - (($B - $R) / $chroma);

    // After we have the sector position, we multiply it by the size of
    //   each sector's arc (60 degrees) to obtain the angle in degrees.
    $computedH = 60 * $h;

    return array($computedH, $computedS, $computedV);
     }

static function max_width($width_available,$current_ratio,$minAspect,$maxAspect){//determine best balance
	$maxH=($maxAspect > 1 && $minAspect < 1)?$width_available:$width_available/$minAspect;
     if (($maxAspect - $minAspect)<=.2){//Pics are reasonable uniform size set to max_avail and calc topPad
          $wa=$width_available;
          $h=$wa/$current_ratio;
          $pt=($maxH-$h)/2;
          }	
     else if ($minAspect < .8 && $maxAspect > 1.25){//variety of sizes
          switch (true){
          case $current_ratio >= 1 && $current_ratio < 1.11 : //image will have largest total area unless limited
               $wa=($width_available*.9);
               $h=$wa/$current_ratio;
               $pt=($maxH-h)/2;
               break;
          case $current_ratio > 1  :   
               $wa=$width_available;
               $h=$wa/$current_ratio;
               $pt=($maxH-$h)/2;
               break;
          case $current_ratio < 1 && $current_ratio >.9  : //this image will also have largest total area unless limited <1 >
               $wa=($width_available*$current_ratio*.9);//ratio less than 1 > .9
               $h=$wa/$current_ratio;
               $pt=($maxH-$h)/2;
               break;
          default :
               $wa=($width_available*$current_ratio);
               $h=$wa/$current_ratio;
               $pt=($maxH-$h)/2; 
               }
          }
     else {// set to maxwidth
          $wa=$width_available;
          $h=$wa/$current_ratio;
          $pt=($maxH-$h)/2; 
          }
     return array($wa,$pt);
	}
		
static function hex2rgba($color, $opacity = false) {
	//from Medks  http://mekshq.com/how-to-convert-hexadecimal-color-code-to-rgb-or-rgba-using-php/
     $default = false;// 'rgb(0,0,0)';
     (!empty($opacity)&&is_numeric($opacity))&&$opacity=$opacity/100;
     //Return default if no color provided
     if(empty($color))
		return $default; 
	 //Sanitize $color if "#" is provided 
     if ($color[0] == '#' ) {
      $color = substr( $color, 1 );
     }

     //Check if color has 6 or 3 characters and get values
     if (strlen($color) == 6) {
             $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
     } elseif ( strlen( $color ) == 3 ) {
             $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
     } else {
             return $default;
     }
     //Convert hexadec to rgb
     $rgb =  array_map('hexdec', $hex);
     //Check if opacity is set(rgba or rgb)
     if(!empty($opacity)&&$opacity<1&&is_numeric($opacity)){
          return 'rgba('.implode(",",$rgb).','.$opacity.')';
          }
     else {
          return 'rgb('.implode(",",$rgb).')';
          }
	}
	
static function log_to_file($text){
     if (!is_file(Cfg_loc::Root_dir.Cfg::Backup_dir.Cfg::Logfile_dir.Cfg::Log_file)){
          file_put_contents(Cfg_loc::Root_dir.Cfg::Backup_dir.Cfg::Logfile_dir.Cfg::Log_file,date("dMY-H-i-s").NL. $text);
          return;
          }
     if (!($fp = fopen(Cfg_loc::Root_dir.Cfg::Backup_dir.Cfg::Logfile_dir.Cfg::Log_file, 'a'))) {
          $my_message.='Cannot open log file '.$filename .' Message: '.date("dMY-H-i-s").NL.$text ;
          $addresses=explode(',',Cfg::Admin_email);
          foreach ($addresses as $address){
               mail($address, ' File Open Problem', $my_message);
               }
          }
     else {
          fwrite($fp,NL. date("dMY-H-i-s").NL. $text);
          file_put_contents(Cfg_loc::Root_dir.Cfg::Backup_dir.Cfg::Logfile_dir.Cfg::Last_log,NL. NL.NL.date("dMY-H-i-s").NL. $text);	
          }
     }
          
static function session_cleanup(){
	   if (!is_file('sessionbatch'))return;
	   $mygroup=file_get_contents('sessionbatch');
	   echo $mygroup;
	   }
        
static function readfile($filename){ 
	if (!$handle = fopen($filename, "r"))return;
	$contents = fread($handle, filesize($filename));
	fclose($handle);
	return $contents;
	}
     
static function write_to_file($filename,$text,$overwrite=false,$adddate=false,$dir=''){ 
	($adddate)&&$text=NL.date("dMY-H-i-s").NL.$text;
	if (!is_file($filename)||$overwrite){
		if (!empty($dir)&&!is_dir($dir))mkdir($dir,0755,1);
		if (!$fp = fopen($filename, "w")) {//save memory
               $my_message.='Cannot open log file '.$filename .' Message: '.$text ;
               $addresses=explode(',',Cfg::Admin_email);
               foreach ($addresses as $address){
                    mail($address, ' File Open Problem', $my_message, "From: ".Cfg::Mail_from);
                    }
               return;
               } 
		else {
			fwrite($fp, "$text");
			fclose($fp);
			return;
			}
		}  
	if (!($fp = fopen($filename, 'a'))) {
               $my_message.='Cannot open log file '.$filename .' Message: '.$text ;
               $addresses=explode(',',Cfg::Admin_email);
               foreach ($addresses as $address){
				mail($address, ' File Open Problem', $my_message, "From: ".Cfg::Mail_from);
                    }
               }
     else {
          fwrite($fp, "$text");
          fclose($fp);
          }
     }
 
static function is_indexed($arr){
     return (array_values($arr) === $arr)?true:false;
     }
	  
static function get_size_string($pic, $dir=Cfg_loc::Root_dir){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
     if (is_file($dir.$pic)){
          $size	= GetImageSize($dir.$pic); 
           return ' '.$size[3];
          }
     else  
		return 'width=50 height=50'; 
	}
	
static function create_password($chrRandomLength=14){
	$strList = implode('',array_merge(
          range('A', 'N'), range('P', 'Z'),
          range('a', 'n'), range('p', 'z'),
          range(2, 9), str_split('@#&%!')
          ));
     echo $strList;  
     if (function_exists('openssl_random_pseudo_bytes')){
		return preg_replace($strList, '', base64_encode(openssl_random_pseudo_bytes($chrRandomLength)));
		}
	if (function_exist('microtime')){
		$repeatMin = 1; //  
		$repeatMax = 400; // this further randomizes the microsecond difference in time returned! 
		//$chrList = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ#!@%&';
		$passLen=20;
		$password='';
		while (strlen($password)<$passLen){
			$strmix= mt_rand($repeatMin,$repeatMax);
			for ($i=1; $i <= $strmix; $i++){
				$strList=str_shuffle($strList);
				}
			$strArr=str_split($chrList);
			$microtime=explode(' ',microtime())[0];
			$mtime=substr($microtime,-4,2);
			$mtime=ltrim($mtime,'0');
			($mtime=='')&&$mtime=0;
			if ($mtime <  count($strArr)){
				$password.=$strArr[$mtime];
				$password=str_shuffle($password);
				}
			}
		 return $password;
		}
     $chrRepeatMin = 10; // Minimum times to repeat the seed string
     $chrRepeatMax = 20; // Maximum times to repeat the seed string
     return substr(str_shuffle(str_repeat($strlst, mt_rand($chrRepeatMin,$chrRepeatMax))),1,$chrRandomLength);  
	}

static function gunzip($file_name){
	// Raising this value may increase performance   stack overflow
	$buffer_size = 4096; // read 4kb at a time
	$out_file_name = str_replace('.gz', '', $file_name); 
	// Open our files (in binary mode)
	$file = gzopen($file_name, 'rb');
	$out_file = fopen($out_file_name, 'wb'); 
	// Keep repeating until the end of the input file
	while (!gzeof($file)) {
		// Read buffer-size bytes
		// Both fwrite and gzread and binary-safe
		fwrite($out_file, gzread($file, $buffer_size));
		return $out_file_name;
		 }
	}
     
static function create_token($length=0) { //echo 'token created';
     if (!empty($length)) 
          return  substr(hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true)),1,($length));
     return  hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
     }//end function token
 
static function get_size($pic, $dir=Cfg_loc::Root_dir){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
    if (is_file($dir.$pic)){
		$size	= GetImageSize($dir.$pic);
		$width			= $size[0];
		$height			= $size[1];
		if ($width < 1 )mail::alert("fail image get_size for $dir.$pic");
		return (array($width,$height));
		}
	else return (array(3,3));
	}
     
static function input_size($width,$fontsize,$maxsize=20){
	return ($width/($fontsize*.75)<$maxsize)?ceil($width/($fontsize*.75)):$maxsize; 
	}
	
static function width_to_col($width,$fontsize){ 
     return round($width/$fontsize*2);
     }
	  
static function row_length($var,$col=64){ if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);  
	$col=(empty($col)||!is_numeric($col)||$col<5)?64:$col;
	$count_total=5;
	if (empty($var)){
	   return $count_total;
	   }
	$var_arr = explode("\n", $var);
     $count_total=ceil(count($var_arr)/10); //this initializes count_total and is a fudge factor for overall lenght of rows returned
	foreach ($var_arr as $var){
		if (empty($var))$count_total++;
		else $count_total+= ceil(strlen($var)/(1.1*$col));
		}
     return floor($count_total);
     }
  
static function array_sort_by_subval(&$array, $key) { //for sorting multi-dimensional array from stack overflow
     foreach($array as &$v) {
        $v['__________'] = $v[$key];
          }
     usort($array, array('process_data','sort_by_underscores'));
     foreach($array as &$v) {
          unset($v['__________']);
          }
     }
 
static  function sort_by_underscores($a, $b) { //for sorting multi-dimensional array from stack overflow
    if($a['__________'] == $b['__________']) return 0;
    if($a['__________'] < $b['__________']) return -1;
    return 1;
     }



}
?>