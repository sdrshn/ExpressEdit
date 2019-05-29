<?php
#ExpressEdit 2.0
class search_replace  {
	private $_extensions = array(".class.php", ".inc", ".class.inc", ".php");
     private $include_dir=Sys::Include_dir;
	public $filename_lax=1;
	protected $block_temp='';
	protected $test_dir='testincludes/';#we will add Sys::Base_dir to this...
	
 function render_search ($array){
	$this->test_dir=Sys::Base_dir.$this->test_dir;
	//print_r($_POST);
	//printer::print_request();
	//printer::vert_print($_POST);
	
	foreach ($array AS $key=>$var){
		$this->$key=$var;
		}
	
	#^^^^^^^^^^^^^^^
	set_time_limit(1000);
	ini_set('memory_limit','4000000000');
	if (Sys::Debug) Sys::debug(__LINE__);
	$this->searchstring_low=($this->case)?trim($this->searchstring):strtolower(trim($this->searchstring));
	$this->find_file_lower=strtolower($this->find_file);
	#ignore files are user input....
	$ignore_list=(!is_array($this->ignore_file))?explode(',',$this->ignore_file):$this->ignore_file; 
	$this->ignore_file=arrayhandler::arraytolower($ignore_list); 
	$block=(!empty($this->block_temp))?$this->block_temp:Cfg::Exclude; //$block='';
	$block_arr=explode(',',$block);
	$this->block_dir=arrayhandler::arraytolower($block_arr); 
	//printer::vert_print($array);
	echo  NL. "block_file array is $block";
	   if ($this->include_php==true){
	   self::search($this->include_dir);   
	   }
    self::search($this->dir);
if (isset($this->html)){echo 'html log file created';
	$this->html.='</div></body></html>';
	echo "entered writing Html";
	file_put_contents($this->log_html,$this->html);
	}
 }
  
  function search ($dir=Sys::Pub) {
	 if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	if ($this->regenerate_test){
		self::regenerate();
		return;
		}
	$dir = rtrim($dir, "/") ."/"; 
	if ($directory_handle = opendir($dir)) {
		while (($file_handle = readdir($directory_handle)) !== false) {  
			// Is the file in the ignore_file list
			//echo $file_handle;
			//$file_handle=strtolower($file_handle);
			 if (($file_handle == '.') || ($file_handle== '..'))continue; 
			if (in_array(strtolower($file_handle), $this->ignore_file)) {  echo NL. 'ignored: '.$this->ignore_file;  
				continue;
				}
			if (in_array(strtolower($file_handle), $this->block_dir)) {    
				continue;
				}
			if (is_dir($dir. $file_handle)) { //echo NL. NL. "directory is ".$dir.$file_handle.NL;
				//(empty($this->rename_file))&&!empty($this->find_file)&&self::find_fn($dir.$file_handle);#report if directory matches filename
				(!empty($this->find_file))&&self::find_fn($dir.$file_handle);//search for directory also
				(!empty($this->subdirectory))&& $this->search($dir. $file_handle);
				}
			else if (!empty($this->cross_ref)){
				self::cross_ref($dir.$file_handle);
				} 
			else if (!empty($this->replace_space)){
				self::replace_space($dir.$file_handle);
				}
			else if (!empty($this->find_file)){
				self::find_fn($dir.$file_handle);
				}
			else if (!empty($this->delete_file)){
				self::delete_fn($dir.$file_handle);
				}
			else if (!empty($this->cleanup)){ 
				self::cleanup($dir.$file_handle);
				}
			else if (!empty($this->clear_mylog)){ 
				self::clear_mylog($dir.$file_handle);
				}
			else if ($this->replace_it==""&&!empty($this->searchstring)) {
				self::search_return($dir.$file_handle);
				}
			else if (!empty($this->replace_it)) { 
				self::replace($dir.$file_handle);
				}
			}// end while
		 }// if directory
	  }// end function buildlist

function replace_space($file_handle){
rename($file_handle,str_replace(' ','',$file_handle));   
}

function cross_ref($file_handle){
	 
	if (empty($this->extension))exit('you must specify an extension');
	if (strpos($file_handle, $this->extension)=== false)return;#if empty use all filetypes
	$sPattern = '/\s/'; 
	$sReplace = ''; 
	$data= strtolower(preg_replace( $sPattern, $sReplace,file_get_contents($file_handle)));
	 $array=explode(',',strtolower(str_replace(' ','',$this->cross_ref)));
	if (count($array)==1){
		echo 'you must enter two or three comma separated search terms';
		return;
		}
	 foreach ($array as $check){
		if (!strpos($data,trim($check)))return;
		//if (!preg_match("/$check/",$data))return;
		//echo NL." $check in $file_handle"; 
		    }
		echo NL. '. only crossed Ref search'.NL. 'found all crosslinked in: '.$file_handle.' last modified: '. date ("F d Y H:i:s.", filemtime($file_handle));
		return;
	foreach ($array as $search){
		$this->searchstring_low=trim($search);
		self::search_return($file_handle);
		}
	}	
	
	
function delete_fn($file_handle){  if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	if (!empty($this->delete_file)&&strpos($file_handle, $this->delete_file)!==false){
		printer::alert('Delete by Renamed with .del extension '. $file_handle.'.del last modified: '. date ("F d Y H:i:s.", filemtime($file_handle)),'',"ramana neg"); 
		rename($file_handle,$file_handle.'.del'); 
		}
	}
    
function find_fn($file_handle){  if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	   if (strpos($file_handle, $this->find_file_lower)!==false)   
	   echo NL.'found lowercase: '. $file_handle.' last modified: '. date ("F d Y H:i:s.", filemtime($file_handle)); 
   if (strpos($file_handle, $this->find_file)!==false){  
	   echo NL. $file_handle.' last modified: '. date ("F d Y H:i:s.", filemtime($file_handle)); 
	
	
	
	
	   if (!empty($this->rename_file)){
		  $new_name=str_replace($this->find_file,$this->rename_file,$file_handle);
		  rename($file_handle,$new_name);
		  echo $this->find_file.' is has been renamed to '.$new_name;
		  }
		 
	   }
    }    
    
    
 function search_return($file_handle){  if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__); 
	 static $print_once=0; $print_once++;
	if ($print_once<2)echo 'function search return entered';
	//if (empty($this->extension))exit('you must specify an extension');
	if (!empty($this->extension)&&strpos($file_handle, $this->extension)=== false)return;#if empty use all filetypes
	
	 if ($this->searchstring[0]=='/'&& preg_match_all('/\//',$this->searchstring,$matches)>1) {
		self::preg_search($file_handle);
		return;
		}
	elseif ($this->searchstring_low[0]=='/')exit(NL.'need to modify program to begin search with / on non-preg query');
	static $count=0;
	static $pregcount=0;
	static $pregcount2=0;
	if ($this->case){
	   if (! $data=file_get_contents($file_handle)){
			 echo 'file permission access problem? or not found: '.$file_handle;
			 return;
			 }
	   }
	   else {
			 if (!$data=file_get_contents($file_handle)){
				  echo 'file permission access problem? or not found: '.$file_handle;
				  return;
				  }
			 $data=strtolower($data);
			 }
	$data=str_replace('<?php','',$data); $data1=$data; 
	$pattern="/$this->searchstring_low/";  
	$sPattern = '/\s/'; 
	$sReplace = ''; 
	$data_compress= preg_replace( $sPattern, $sReplace, $data);
	$pattern_compress="/".preg_replace($sPattern, $sReplace,$this->searchstring_low)."/";
	$pcount=preg_match_all($pattern,$data,$matches);  
	$pcount2=preg_match_all($pattern_compress,preg_replace($sPattern, $sReplace, $data),$matches2); 
	$pregcount=$pcount+$pregcount;
	$pregcount2=$pcount2+$pregcount2;
	if (!empty($pcount))echo NL."pregmatch count is $pregcount";
	if (!empty($pcount2))echo NL."stripped pregmatch count is $pregcount2";
	$data = explode("\n", $data);
	for ($line = 0; $line < count($data); $line++) {
		if (strpos($data[$line], $this->searchstring_low)!==false) {  
			$count++;
			printer::alert_pos(" count $count filename is $file_handle");
			echo NL. "line $line: ". $data[$line];
			}
		else if (strpos(str_replace(' ','',$data[$line]), str_replace(' ','',$this->searchstring_low))!==false) {  
			$count++;
			printer::alert_pos("However with spaces removed".NL. "count $count filename is $file_handle");
			echo NL. "line $line: ". $data[$line];
			}
		else{
			$countline=preg_match_all($pattern_compress, str_replace(' ','',$data[$line]), $matches);
			if (!empty($countline)) {
				printer::alert_pos("filename is $file_handle");
				echo NL. "line $line: ". $data[$line];
				foreach($matches[0] as $match){
					echo NL."preg match compressed matches:". $data[$line];;
					}
				}
			}
		}			
    }
//Escape a string to be used as a regular expression pattern
//Ex: escape_string_for_regex('http://www.example.com/s?q=php.net+docs')
// returns http:\/\/www\.example\.com\/s\?q=php\.net\+docs
function escape_string_for_regex($str)
{
        //All regex special chars (according to arkani at iol dot pt below):
        // \ ^ . $ | ( ) [ ]
        // * + ? { } ,
        
        $patterns = array('/\//', '/\^/', '/\./', '/\$/', '/\|/',
 '/\(/', '/\)/', '/\[/', '/\]/', '/\*/', '/\+/', 
'/\?/', '/\{/', '/\}/', '/\,/');
        $replace = array('\/', '\^', '\.', '\$', '\|', '\(', '\)', 
'\[', '\]', '\*', '\+', '\?', '\{', '\}', '\,');
        
        return preg_replace($patterns,$replace, $str);
}


 function preg_search($file_handle){
	static $print_once=0; $print_once++;
	if ($print_once<2)echo 'function preg search entered';
 static $count=0;
	static $count=0;
	static $pregcount=0;
	static $pregcount2=0;
	//if (empty($this->extension))exit('you must specify an extension');
	if (!empty($this->extension)&&strpos($file_handle, $this->extension)=== false)return;#if empty use all filetypes
	
	$data=file_get_contents($file_handle);
	$pattern="$this->searchstring";  
	$sPattern = '/\s/'; 
	$sReplace = ''; 
	$data_compress= preg_replace($sPattern, $sReplace, $data);
	$pattern_compress=preg_replace($sPattern, $sReplace,$this->searchstring);
	$pcount=preg_match_all($pattern,$data,$matches);  
	$pcount2=preg_match_all($pattern_compress,preg_replace($sPattern, $sReplace, $data),$matches2);
	if (empty($pcount2))return;
	//echo NL.NL.'matches are: ';printer::vert_print($matches);
	//echo NL.NL.'matches2 are: ';printer::vert_print($matches2);
	//echo NL. 'print r for matches2 is '.print_r($matches2);
	//printer::vert_print($_SERVER);
	//print_r($_SERVER);
	$pregcount=$pcount+$pregcount;
	$pregcount2=$pcount2+$pregcount2;
	$data = explode("\n", $data);
	for ($line = 0; $line < count($data); $line++) {
		$countline=preg_match_all($pattern,$data[$line], $matches);
		$countline_comp=preg_match_all($pattern_compress, str_replace(' ','',$data[$line]), $matches2);
		if (!empty($countline)) {
			printer::alert_pos("filename is $file_handle");
			echo NL. "line $line: ". $data[$line];
			foreach($matches[0] as $match){
				$count++;
				echo NL."count is $count preg match normal matches:". NL. $data[$line];;
				}
			}
		else if (!empty($countline_comp)) {
			printer::alert_pos("filename is $file_handle");
			echo NL. "line $line: ". $data[$line];
			foreach($matches[0] as $match){
				$count++;
				echo NL."count is $count preg match compressed matches:". NL. $data[$line];;
				}
			}	
		}			
    if (!empty($pcount))echo NL."pregmatch count is $pregcount";
		if (!empty($pcount2))echo NL."stripped pregmatch count is $pregcount2";
		
		}
 
 
function replace($file_handle){
	static $print_once=0; $print_once++;
	if ($print_once<2)echo 'function replace entered';
	if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
 	 if ($this->searchstring[0]=='/'&& preg_match_all('/\//',$this->searchstring,$matches)>1) {
		self::preg_replace($file_handle);
		return;
		}
	static $html='<html><head></head><body><div>';
	//if (empty($this->extension))exit('you must specify an extension');
	if (!empty($this->extension)&&strpos($file_handle, $this->extension)=== false)return;#if empty use all filetypes
		$data =file_get_contents($file_handle);    
	$data1 = explode("\n", $data); 
	$log_detail = '';                  
	$flag=false;  // log and print out all changes line by line before making any substition
	if (strpos($data, $this->searchstring) === false)return; 
	for ($line = 0; $line < count($data1); $line++) {
		if (strpos($data1[$line], $this->searchstring) !== false) {   
			$flag=true;// if true then str_replace below
			$log_detail.=  NL ."substitution at line $line in: ".NL.$data1[$line]; 
			} 
		} 
		// if flag then go ahead and string sub, send log 
	if ($flag!=true)return;             
	$log=NL.NL. "date is ".date("dMY-H-i-s"). NL. " filename is $file_handle ". NL."Written as $file_handle. $this->add_extension with add extension $this->add_extension".NL."replaced $this->searchstring with $this->replace_it in the following lines: ". $log_detail;
	if (!($fp = fopen($this->log_txt, 'a'))) { 
		echo 'cannot open error log file';
		$error=Sys::error_info(__LINE__,__FILE__,__METHOD__);
		$log.=NL.'Cannot open log_replace file'.NL.$error;
		}
	else {  
		if ($this->replace_button==true){#just a double check
			echo "entered In replace button true";
			fwrite($fp, "$log");
			fclose($fp);
			if(!copy($this->log_txt,$this->log_rtf)) echo('backup copy logfile.txt failure');#create backup copy first
			if(!copy($file_handle,$file_handle.'.bac')) exit ('backup copy replace failure');#create backup copy first
			$file_handle=$file_handle.$this->add_extension;
			if(!file_put_contents($file_handle,$data)) exit ('Failure to file put contents in preg replace');
			$data=str_replace($this->searchstring,$this->replace_it,$data);  
			$file_handle=$file_handle.$this->add_extension;
			if(!file_put_contents($file_handle,$data)) exit ('Failure to file put contents in preg replace');
			$log= 'changes written to: '.$log;
			$html.= $log;  $this->html=$html;			
			}
		else echo 'click replace button if your serious';
		}
	echo $log;
	}//end function replace
function preg_replace($file_handle){
	static $print_once=0; $print_once++;
	if ($print_once<2)echo 'function preg replace entered';
	$replace_asis=false;
	$log_detail = '';                  
	$flag=false;  // log and print out all changes line by line before making any substition
	static $html='<html><head></head><body><div>';
	//if (empty($this->extension))exit('you must specify an extension');
	if (!empty($this->extension)&&strpos($file_handle, $this->extension)=== false)return;#if empty use all filetypes
		$data =file_get_contents($file_handle); 
	if (strpos($this->searchstring,'@@@')){  
		$patternArray=explode('@@@',trim($this->searchstring,'/')); 
		$replaceArray=explode('@@@',$this->replace_it);
		if ($print_once<2){
			echo NL. 'pattern array is '; printer::vert_print($patternArray);
			echo NL. 'replace array is '; printer::vert_print($replaceArray);
			}
		#the way it works is that both pattern with /p/ and replace	with no slashes will have matching number of @@@
		#and those with a '(' will retain the pattern and those without will be replaced by the matching replace...
		$repcount=count($replaceArray);
		$count=count($patternArray);
		if ($count !=$repcount){echo "$count is count and $repcount is repcount";exit('makem match');
			}
		$pattern=str_replace('@@@','',$this->searchstring); #use normal pattern...
		  //echo NL.'the final pattern is '.$pattern.NL; //echo $file_handle; if (strpos($file_handle,'file_generate'))echo $data;
		if (!preg_match($pattern, $data))return;
		echo NL. 'matched file handle is '.$file_handle;
		$count=preg_match_all($pattern, $data, $matches);  #get the match array...
		if (empty($count))return;
		echo NL.NL.'matches from match array: ';printer::vert_print($matches);
		$finds=count($matches[1]);
		for ($f=0;$f<$finds;$f++){
			$m=1;
			$final_replace='';
			for ($c=0;$c<$repcount;$c++){
				 if($patternArray[$c][0]=='('){#if exploded array of pattern  has parenthesis then use what was supplied in orinal matches....
					$final_replace.=$matches[$m][$f];# substitute the match into pattern...
					$m++;
					}
				else $final_replace.=$replaceArray[$c];# else use what  it in the replace array... including empty.
				}	
			$msg=NL ."the pattern was $pattern  replaced by  $final_replace";
			$log_detail.=$msg;
			echo $msg;
			if($this->replace_button&& preg_match($pattern,$data))$data=preg_replace($pattern,$final_replace,$data);# heres the meat of it for @@@
			else echo(NL.'this replace button was not selected and no changes were made');
			}	 
						    //   using matches1 will return only the characters within the parenthesis , the first subpattern
		}
	else {#no @@@
		$pattern=$this->searchstring;
		$final_replace=$this->replace_it;
		if($this->replace_button&& preg_match($this->searchstring,$data)){ 
			$pcount=preg_match_all($this->searchstring,$data,$matches);  
			if (empty($pcount))return;
			$data=preg_replace($this->searchstring,$this->replace_it,$data);
			$msg= 'there are '.$pcount.' matches for your pattern that have been replace with '.$final_replace.' in '.$file_handle;
			$log_detail.=NL.$msg. NL. print_r($matches,true);
			echo $msg;
			printer::vert_print($matches);
			}
		else {
			$pcount=preg_match_all($this->searchstring,$data,$matches);  
			if (empty($pcount))return;
			echo 'there are '.$pcount.' matches for your pattern in '.$file_handle;
			printer::vert_print($matches);
			echo 'you did not select the replace button';
			return;
			}
		}
	if(!$this->replace_button)return;  	 
	$log=NL.NL. "date is ".date ("F d Y H:i:s"). NL. " filename is $file_handle ".
	NL."Written as $file_handle". $this->add_extension. 'and backedup as '.$file_handle. $this->add_extension.'.bac'.NL.
	"replaced $pattern with $final_replace ".NL .$log_detail;
	 if (!($fp = fopen($this->log_txt, 'a'))) {
	    echo 'cannot open error log file';
	    $error=Sys::error_info(__LINE__,__FILE__,__METHOD__);
	    $log.=NL.'Cannot open log_replace file'.NL.$error;
		}
	else { 
		if ($this->replace_button==true){echo "entered In preg replace button true";
			fwrite($fp, "$log");
			fclose($fp);
			if(!copy($this->log_txt,$this->log_rtf)) echo('backup copy logfile.txt failure');#create backup copy first
			if(!copy($file_handle,$file_handle.'.bac')) exit ('backup copy preg replace failure');#create backup copy first
			$file_handle=$file_handle.$this->add_extension;
			if(!file_put_contents($file_handle,$data)) exit ('Failure to file put contents in preg replace');
			$log= 'changes written to: '.$log;
			$html.= $log;
			$this->html=$html;		 	
			}
		else echo NL. 'click replace button if your serious';
		}
	}//end preg_replace

function cleanup($file_handle){ 
	if (substr($file_handle,-3)==$this->cleanup||substr($file_handle,-4)==$this->cleanup){
		echo 'have deleted '. $file_handle;
		 unlink($file_handle);
		}
	if ($this->clear_mylog&&strpos($file_handle,'mylog.txt')!==false){
		 file_put_contents($file_handle,'');
	    }
	}
function clear_mylog($file_handle){  
 
	if ($this->clear_mylog&&strpos($file_handle,'mylog.txt')!==false){
		 file_put_contents($file_handle,'');
	    }
	}	
function regenerate(){
	if (is_dir($this->test_dir)){
		file_generate::rrmdir($this->test_dir);
		}
	echo NL. 'deleted the directory '.$this->test_dir;
	file_generate::full_copy($this->include_dir,$this->test_dir);
	echo NL. 'copied the master directory to '.$this->test_dir;
	}
}// end class search_replace
?>