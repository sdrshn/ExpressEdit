<?php
#ExpressEdit 2.0
class ftp_files {	
private $conn_id; 
private $ftp_server='ekarasa.com';
private $user_suffix='v3~!R~TF!q';
private $connected = false;

// set up basic connection

/*
<?php
#ExpressEdit 2.0
$path_parts = pathinfo('/www/htdocs/inc/lib.inc.php');

echo $path_parts['dirname'], "\n";
echo $path_parts['basename'], "\n";
echo $path_parts['extension'], "\n";
echo $path_parts['filename'], "\n"; // since PHP 5.2.0
?>

The above example will output:

/www/htdocs/inc
lib.inc.php
php
lib.inc

*/

function list_options($name='',$pass='',$server=''){
	 $exceptions=  explode(',',Cfg::Exclude);
	$array_ex=('Thumbs.db,Cfg.class.php,default.html,Cfg_loc.class.php');
	$array_ex=explode(',',$array_ex);
	$this->exceptions=array_merge($exceptions,$array_ex);

	$display=array();		
	$where='';
	$cols=array();
	$radio_array=array('check_dir_name','clean_download_dirs','view_rawlist','sync_editor_uploader');
	$radio_text_array=array('Check name validity for files and folders','Serv_to_Loc Check, Del,Download <br/>Files for images/scripts/style<br/>','View Ftp file/folder INfo','sync_editor_uploader');
	 
	$array =array(
		array(
		    "name" => $radio_array,
		    "value" => $radio_text_array,
		    "type" =>'radio_array' ,
		    "selected" =>'NA',
		    "ref" => 'ftp_choice',
		    "text1" =>'',
		    "text2"=>'NA'
		    )
		);  
		if (isset($_POST['submitted'])) { //  echo NL.'post is  this one'; printer::horiz_print($_POST);   print_r($_POST);
		$this->connect($name,$pass,$server);  
		list ($pass_arr,$array)=forms::form_process($array);
		if (isset($pass_arr['ftp_choice'])){
			self::$pass_arr['ftp_choice']();
			}
		else printer::alert_neg('No radio button choic');
		 
		}//end submitted	
	include ('includes/strictheader.nometa.php'); 
		
	echo '
	<link href="'.Cfg_loc::Root_dir.'program.css" rel="stylesheet" type="text/css" />  
	</head>
	<body>
	<div class="container">';
		
	forms::form_render($array,'','');
	echo'
	<p class="ramana"><a href="db_files.php">Db List Files</a></p>';
	echo'
	</div>
	</body>
	</html>';
	}//end function construct

	
function connect($ftp_user_name='',$ftp_user_pass='',$ftp_server=''){
	if ($this->connected)return;
	$this->checktime=time::instance();
	$ftp_server=(!empty($ftp_server))?$ftp_server:$this->ftp_server; echo $ftp_server;
	$this->conn_id = ftp_connect($ftp_server);
	$ftp_user_name=(!empty($ftp_user_name))?$ftp_user_name:Cfg::Owner.'@ekarasa.com';
	$this->ftp_server=$ftp_server;
	$ftp_user_pass=(!empty($ftp_user_pass))?$ftp_user_pass:$this->user_suffix.Cfg::Ftp_pass.Cfg::Pwall;  
	 // login with username and password
	$login_result = ftp_login($this->conn_id, $ftp_user_name, $ftp_user_pass);
	// check connection
	if ((!$this->conn_id) || (!$login_result)) {
		die("FTP connection has failed !");
		}
	ftp_pasv($this->conn_id,true);
	self::cktime(__line__.__method__);
	$this->connected=true;
	}



function sync_editor_uploader(){
	$msg='Updated File Server: '.$this->ftp_server;
	 if (!strpos(Sys::Self,'micrometer')!==false)exit('sudarshan test site only');
	echo Sys::Self. ' is sys self';  ;
	set_time_limit(900);
	$upload_check=array('small_images/','med_images/','big_thumbs/','scripts/','styling/','video/');//this array will not overwrite
 	$upload_all=array(); //this array will overwrite
	//$upload_dir_to_root=array('backupversions/,htm');//goes to root directory..//
	$upload_dir_to_root=array();//goes to root directory..
	$upload_dir_exclude=array('.,php psd');
	foreach($upload_all as $dir){
		if (is_dir($dir)){
			$msg.=NL. 'Directory is '.$dir.NL;
			$msg.=$this->ftp_upload_files($dir,$this->exceptions,'all');    // Use "." if you are in the current directory
			}
			
		else {
			$msg='directory error problem1 '.$dir;
			mail::error($msg);
			exit ($msg);
			}
		}
	foreach($upload_check as $dir){
		if (is_dir($dir)){
			$msg.=NL. 'Directory is '.$dir.NL;
			$msg.=$this->ftp_upload_files($dir,$this->exceptions,'check');    // Use "." if you are in the current directory
			}
		else {
			$msg='directory error problem2 '.$dir;
			mail::error($msg);
			exit ($msg);
			}
		}
	 foreach($upload_dir_to_root as $dir){
		$ext=''; 
		 if (strpos($dir,',')!==false){
			list($dir,$ext)=explode(',',$dir);
			}
		if (is_dir($dir)){
			$msg.=NL. 'Directory is '.$dir.NL;
			$msg.=$this->ftp_upload_files($dir,$this->exceptions,'d_t_r',$ext);    // Use "." if you are in the current directory
			}
			 
		else {
			$msg='directory error problem3 '.$dir;
			mail::error($msg);
			exit ($msg);
			}
		}
	 foreach($upload_dir_exclude as $dir){
		$ext=''; 
		if (strpos($dir,',')!==false){
			list($dir,$ext)=explode(',',$dir);
			}
		if (is_dir($dir)){
			$msg.=NL. 'Directory is '.$dir.NL;
			$msg.=$this->ftp_upload_files($dir,$this->exceptions,'excl',$ext);    // Use "." if you are in the current directory
			}
		else {
			$msg='directory error problem4 '.$dir;
			mail::error($msg);
			exit ($msg);
			}
		}
		
	ftp_close($this->conn_id);  	
	mail::alert($msg,'FtP_Backup');
	}
	
	
function ftp_upload_files($dir,$exceptions,$mode,$ext=''){//recursion can be implemented if need arises
	$msg='';
	$gotodir=($mode=='d_t_r')?'':$dir;
	self::cktime(__line__.__method__);
	$num=0;
	$rawfiles=ftp_rawlist($this->conn_id,$dir);
	$parsedList=self::parseRawList($rawfiles);
	$newlist=array();
	foreach ($parsedList as $list){
		if ($list['type']!='file')continue;//elimate these from new array
		$remotestamp=  strtotime(implode(' ',array($list['month'], $list['day'], $list['time'])));
		$newlist[$list['name']]=$remotestamp; 
		}
	$dir = rtrim($dir, "/") ."/";//run parselist without the / if directory because ./ will not read!!!
		
	if ($directory_handle = opendir($dir)) { 
		while (($file_handle = readdir($directory_handle)) !== false) {
			if ($file_handle=='.'||$file_handle=='..')continue; 
			if (!is_file($dir.$file_handle))continue;
			
			switch ($mode){
			case 'all':  
			
				if (!ftp_put($this->conn_id, $gotodir.$file_handle, $dir.$file_handle, $this->get_ftp_mode($file_handle))) 
					mail::alert('problem with ftp_put1 '.$dir);
					$msg.=  NL.'overwrote all '.$file_handle;
				break;
			
			case 'check':
				if (!array_key_exists($file_handle,$newlist)){
					if (!ftp_put($this->conn_id, $gotodir.$file_handle, $dir.$file_handle, $this->get_ftp_mode($file_handle))) {
						mail::alert('problem with ftp_put2 '.$dir);
						}
					$msg.=  NL.'none preexisting.. uploaded new '.$dir.$file_handle;
					break;	
					}
				if (filemtime($dir.$file_handle)>$newlist[$file_handle]){
					 
					if (!ftp_put($this->conn_id, $dir.$file_handle, $gotodir.$file_handle, $this->get_ftp_mode($file_handle))) {
						mail::alert('problem with ftp_put3 '.$dir);
						}
					$msg.=  NL. 'uploaded newer version of '.$dir.$file_handle;	
					}
				break;
			
			case 'd_t_r':
				$exts=explode(' ',$ext);//check for allowed extensions...
				$path_parts = pathinfo($dir.$file_handle); 
				if (!isset($path_parts['extension']))continue;
				if (!in_array($path_parts['extension'],$exts))continue;
				if (!array_key_exists($file_handle,$newlist)){
					if (!ftp_put($this->conn_id, $gotodir.$file_handle, $dir.$file_handle, $this->get_ftp_mode($file_handle))) {
						mail::alert('problem with ftp_put2 '.$dir);
						}
					$msg.=  NL.'no prexisting with ext check & uploaded new '.$dir.$file_handle;
					break;	
					}
				if (filemtime($dir.$file_handle)>$newlist[$file_handle]){
					if (!ftp_put($this->conn_id, $gotodir.$file_handle, $dir.$file_handle, $this->get_ftp_mode($file_handle))) {
						mail::alert('problem with ftp_put3');
						break;
						}
					$msg.=  NL.'extension check & uploaded new '.$dir.$file_handle;
					}
				break;
			case 'excl': 
				$exts=explode(' ',$ext);//check for allowed extensions...
				$path_parts = pathinfo($dir.$file_handle); 
				if (!isset($path_parts['extension']))continue;
				if (in_array($path_parts['extension'],$exts))continue;
				if (!array_key_exists($file_handle,$newlist)){
					if (!ftp_put($this->conn_id, $dir.$file_handle, $dir.$file_handle, $this->get_ftp_mode($file_handle))) {
						mail::alert('problem with ftp_put2 '.$dir);
						}
					$msg.=  NL.'exclude check & uploaded new '.$dir.$file_handle;
					break;	
					}
				if (filemtime($dir.$file_handle)>$newlist[$file_handle]){
					if (!ftp_put($this->conn_id, $gotodir.$file_handle, $dir.$file_handle, $this->get_ftp_mode($file_handle))) {
						mail::alert('problem with ftp_put3');
						break;
						}
					$msg.=  NL. 'uploaded latest version of '.$dir.$file_handle;
					}
				break;
				}
			}
			
		}	 
	else mail::error('directory not opening '.$dir);	
	self::cktime(__line__.__method__);
	return $msg; 
	}
	
	
	
	
	
	
	
	
	
	
	
	
function clean_download_dirs(){  
	set_time_limit(900);
	self::cktime(__line__.__method__);
	$purgebuild_dir=array('includes/');
	$checkdownload_del_dir=array('small_images/','med_images/','big_thumbs/','uploads/');//this array will not overwrite
	//$checkdownload_dir_array=array('big_thumbs/');//this array will not overwrite
 	$checkdownload_del_dir_overwrite=array('scripts/','styling/'); //this array will overwrite
	$check_download_only=array('.,psd error bac htaccess');
	foreach($purgebuild_dir as $dir){
		if (is_dir($dir)){
			 $num=file_generate::rrmdir($dir,$this->exceptions,true);
			echo "deleted $num files from $dir";
			}
		else exit ($dir.' does not exist');
		 $this->download_files($dir,$this->exceptions);    // Use "." if you are in the current directory
		echo "copied $num files to $dir";
		}
	foreach($checkdownload_del_dir as $dir){
		  $this->check_delete_download_files($dir,$this->exceptions);
		}
	foreach($checkdownload_del_dir_overwrite as $dir){
		  $this->check_delete_download_files($dir,$this->exceptions,true);
		}
	foreach($check_download_only as $dir){
		$excl=''; 
		if (strpos($dir,',')!==false){
			list($dir,$excl)=explode(',',$dir);
			}
		if (is_dir($dir)){
			$this->check_download_only($dir,$this->exceptions,$excl);   // Use "." if you are in the current directory
			}
		else {
			$msg='directory error problem44 '.$dir;
			exit ($msg);
			}
		 
		}
	
	ftp_close($this->conn_id);
	exit();
	}
 
 
 
 
function download_files($dir,$exceptions=''){// this will fail if directory present
	self::cktime(__line__.__method__);
	$num=0;
	$rawfiles=ftp_rawlist($this->conn_id,$dir);
	$parsedList=self::parseRawList($rawfiles);
	$dir = rtrim($dir, "/") ."/";//error on parlist ./ sp do this after!
	foreach ($parsedList as $list){
		 $file=$list['name'];
		 if ($list['type']=='dir'){
			printer::alert_neg("ignored 'folder' $file");
			continue;
			}
		 if ($list['type']=='l'){
			mail::alert_neg("myster l type ' $file");
			continue;
			}
		if (ftp_get($this->conn_id, $dir.$file, $dir.$file, $this->get_ftp_mode($file))) {
			echo NL."successfully downloaded $dir$file";
			$num++;
			}
		else {
			echo NL."There was a problem while uploading $dir$file";
			} 
		}
		printer::alert_pos( NL. 'cleaned the directory '.$dir);
		
	self::cktime(__line__.__method__);
		 return $num;
	}

	
function check_delete_download_files($dir,$exceptions='',$overwrite=false){
	#checks if file present on server will optionally overwrite.
	#if not on server will delete locally...   skips folders...
	$downloaded=0;
	$deleted=0;
	$retained=0;
	$rawfiles=ftp_rawlist($this->conn_id,$dir);// order is important as ./ will not parselist
	$parsedList=self::parseRawList($rawfiles);
	$dir = rtrim($dir, "/") ."/";
	self::cktime(__line__.__method__);
	$ftp_file_array=ftp_nlist($this->conn_id,$dir);
	if ($directory_handle = opendir($dir)) {
		while (($file_handle = readdir($directory_handle)) !== false) {
			if ($file_handle=='.'||$file_handle=='..')continue;
			//if (strpos($file_handle,'.')===false){
			if (is_dir($file_handle)){
				printer::alert_neg("ignored 'folder' $file_handle");
				continue;
				}
			if (in_array($file_handle,$exceptions)){echo NL.'skpped '. $file_handle;
				continue;}
			if (!in_array($file_handle,$ftp_file_array)&&is_file($dir.$file_handle)){
				if (!unlink($dir.$file_handle)){
					printer::alert_neg('Problem Unlinking '.$dir.$file_handle);
					}
				else {printer::alert('deleted '. $dir.$file_handle);
					$deleted++;
					}
				}
			else {
				if (!$overwrite){echo NL. 'Retained '.$dir.$file_handle;
					$retained++;
					}
				}
			}
		}
	self::cktime(__line__.__method__);
	foreach ($parsedList as $list){
			$file=$list['name'];
			if (!$overwrite)continue;//do not download if already present....
			if ($list['type']!=='file')continue;//folder
			if (ftp_get($this->conn_id, $dir.$file, $dir.$file,  $this->get_ftp_mode($file))) {
				echo NL."successfully downloaded $dir$file";
				$downloaded++;
				}
			else {
				echo NL."There was a problem while uploading $dir$file";
				} 
			}
		
			
		$retained=($overwrite)?'0':$retained;
		printer::alert_pos( NL. 'cleaned the directory '.$dir.NL."retained: $retained \n deleted: $deleted \n downloaded: $downloaded\n");
		self::cktime(__line__.__method__);	
	}

 
function check_download_only($dir,$exceptions='',$excl=''){
	#checks if file present on server will optionally overwrite.
	#if not on server will delete locally...   skips folders...
	$downloaded=0;
	$deleted=0;
	$retained=0;
	$rawfiles=ftp_rawlist($this->conn_id,$dir);// order is important as ./ will not parselist
	$parsedList=self::parseRawList($rawfiles);
	$dir = rtrim($dir, "/") ."/";
	self::cktime(__line__.__method__);
	$excls=explode(' ',$excl);//check for allowed extensions...
	foreach ($parsedList as $list){
			$file=$list['name'];
			$remotemod=  strtotime(implode(' ',array($list['month'], $list['day'], $list['time'])));
			$excl = substr(strrchr($file, "/"), 1);
			if (in_array($excl,$excls))continue;
			if ($list['type']!=='file')continue;//folder
			if (!is_file($dir.$file)||(filemtime($dir.$file)<$remotemod)){
				if (ftp_get($this->conn_id, $dir.$file, $dir.$file,  $this->get_ftp_mode($file))) {
					echo NL."successfully downloaded $dir$file";
					$downloaded++;
					}
				else {
					echo NL."There was a problem while uploading $dir$file";
					} 
				}
			}
		
		printer::alert_pos( NL. 'download and check the directory '.$dir.NL." \n downloaded: $downloaded\n");
		self::cktime(__line__.__method__);	
	}
/*
 				
				
				if (!array_key_exists($file_handle,$newlist)){
					if (!ftp_put($this->conn_id, $dir.$file_handle, $dir.$file_handle, $this->get_ftp_mode($file_handle))) {
						mail::alert('problem with ftp_put2 '.$dir);
						}
					$msg.=  NL.'exclude check & uploaded new '.$dir.$file_handle;
					break;	
					}
				if (filemtime($dir.$file_handle)>$newlist[$file_handle]){
					if (!ftp_put($this->conn_id, $gotodir.$file_handle, $dir.$file_handle, $this->get_ftp_mode($file_handle))) {
						mail::alert('problem with ftp_put3');
						break;
						}
					$msg.=  NL. 'uploaded latest version of '.$dir.$file_handle;
					}
				break;
				}
			}

*/
function cktime($funct){return;
	if (!Sys::Debug)return;
	echo 'line: '.$funct.' deltatime: '.$this->checktime->delta();
	}
	
function get_ftp_mode($file)
{    
    $path_parts = pathinfo($file);
    
    if (!isset($path_parts['extension'])) return FTP_BINARY;
    switch (strtolower($path_parts['extension'])) {
        case 'am':case 'asp':case 'bat':case 'c':case 'cfm':case 'cgi':case 'conf':
        case 'cpp':case 'css':case 'dhtml':case 'diz':case 'h':case 'hpp':case 'htm':
        case 'html':case 'in':case 'inc':case 'js':case 'm4':case 'mak':case 'nfs':
        case 'nsi':case 'pas':case 'patch':case 'php':case 'php3':case 'php4':case 'php5':
        case 'phtml':case 'pl':case 'po':case 'py':case 'qmail':case 'sh':case 'shtml':
        case 'sql':case 'tcl':case 'tpl':case 'txt':case 'vbs':case 'xml':case 'xrc':
            return FTP_ASCII;
    }
    return FTP_BINARY;
}
	
	
function ftp_sync ($dir) { //for files with directories... will show warning errors
	static $num=0;
	if ($dir != ".") { 
		if (ftp_chdir($this->conn_id, $dir) == false) { 
			echo ("Change Dir Failed: $dir<BR>\r\n"); 
			return; 
			} 
		if (!(is_dir($dir))) 
			mkdir($dir); 
			chdir ($dir); 
			} 

	$rawfiles=ftp_rawlist($this->conn_id,'.');
	$parsedList=self::parseRawList($rawfiles);
	foreach ($parsedList as $list){
			$file=$list['name'];
		 
		if ($list['name']=='dir'){//folders being used do not contain '.' and all files do
			ftp_sync ($file); 
			} 
		else {
			ftp_get($this->conn_id, $file, $file, $this->get_ftp_mode($file));
			printer::alert_pos("copied $file to $dir");
			}
		} 
		
	ftp_chdir ($this->conn_id, ".."); 
	chdir (".."); 

	} //end function syn
	
 function check_dir_name($dir='.'){
	static $x=0;
	(Sys::Loc&&$x<1) &&printer::alert_neg('To check Server Files Run on Server');
	$x++;
	printer::alert_pos('fol');
	if ($directory_handle = opendir($dir)) {
		while (($file_handle = readdir($directory_handle)) !== false) {
			if ($file_handle=='.'||$file_handle=='..')continue;
			if (in_array($file_handle,$this->exceptions))continue;
	
			if (is_dir($file_handle)){
				if (strpos($file_handle,'.')!==false){
					printer::alert_neg(getcwd() ."$file_handle not conforming to naming standard for folders");
					}
				else {
					//print(" folder $file_handle OK ");
					}
				chdir($file_handle);
				self::check_dir_name('.');
				}
			else {
				if (strpos($file_handle,'.')===false){
					printer::alert_neg(getcwd().' ' ."$file_handle not conforming to naming standard for files");
					if (!rename($file_handle,$file_handle.'.error')){
						printer::alert_neu('renaming failed');
						}
						
					}
				else echo 'ok';
				}
			}
		}
		chdir (".."); 
	}//end function
	
function view_rawlist(){//note windows and linux lists the rawlist differently !!!!!
	$rawfiles = ftp_rawlist($this->conn_id, "."); //true being for recursive
	$parsedList=self::parseRawList($rawfiles);
	printer::vert_print($parsedList);
	}//end function
	
function parseRawList($rawList){
      $orderList = array("d", "l", "-");
      $typeCol = "type";
      $cols = array("permissions", "number", "owner", "group", "size", "month", "day", "time", "name");
      $parsedList=array();  
     foreach($rawList as $key=>$value){
          $parser   = preg_split("/[\s]+/", $value, 9);
		if ($parser[8]=='.'||$parser[8]=='..')continue;
		foreach($parser as $key=>$item){ 
			$parser[$cols[$key]] = $item;
			unset($parser[$key]);
			}
		$parsedList[] = $parser;
		}
     
	foreach($parsedList as $key=>$parsedItem) {  
		$type = substr(current($parsedItem), 0, 1);
		switch ($type){
			case'd':
			$parsedItem[$typeCol]='dir';
			unset($parsedList[$key]);//totally remove
			$parsedList[] = $parsedItem;//rebuild with $parsed item...
			break;
			case'-':
			$parsedItem[$typeCol]='file';
			unset($parsedList[$key]);
			$parsedList[] = $parsedItem;
			break;	
			case'-':
			$parsedItem[$typeCol]='l';
			unset($parsedList[$key]);
			$parsedList[] = $parsedItem;
			mail::alert('l filetype in rawlist parse function for filename'.$rawList[$key]);
			break;	 
			default:$parsedItem[$typeCol]='UNK';
			unset($parsedList[$key]);
			$parsedList[] = $parsedItem;
			mail::alert('Unknown filetype in rawlist parse function for filename'.$rawList[$key]);	
			}
		}
       return array_values($parsedList);
    }//end function
 
/*try { 
			if (ftp_chdir($this->conn_id, $file)) {
				ftp_chdir ($this->conn_id, "..");
				ftp_sync ($file);
				}
			else {
				ftp_get($this->conn_id, $file, $file, $this->get_ftp_mode($file));
				printer::alert_pos("copied $file to $dir");
				throw new buffer_exception($msg);
			}
		catch(buffer_exception $me){
			$me->exception_message();
			
				
			}	
	*/
	
}//end class
?>