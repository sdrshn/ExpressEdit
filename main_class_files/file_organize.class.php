<?php
#ExpressEdit 2.0
class file_organize {
	private $_extensions = array(".class.php", ".inc", ".class.inc", ".php");
     private $include_dir=Sys::Include_dir;
	public $filename_lax=1;
	protected $block_temp='no takers here';
	protected $ignore_dir='';
	protected $tablename='dir_list';
	protected $dbname='file_dir_info';
	protected $truncate=false;
	protected $subdirectory=true;
	protected $reject_file="txt,html,vob,bup,apl,dl,exe,dll,ifo,js,mpg,pdf,tlb,api,bin";
	protected $reject_words_strpos='title,dvd,video,vts,xvid,sumotorrent,src,scr,16x9,16x9ff,4x3,scn'; // strpos
	protected $reject_words='na,ff,lb,ws,d1,d2,d3,d4,d5,d6,d7,d8,ac,,unrated,cd1,cd2,se,fd';//not strpos
	protected $reject_dir="audio_ts,video_ts,mp4,mpeg,flv";
	protected $replace_atring=array('(',')','title','16x9','4x3','disc','8x11');
	protected $outputfile='F:/My documents/moviesCompress.txt';
	protected $reject_strpos='DVD_VIDEO-Title,dvd,DVD,vdk';
	protected $default_dir='K:/movies';
	protected $file='holddata.txt';
	protected $file_pos='datafilepos.txt';
	protected $file_neg='datafileneg.txt';
	protected $ignore_file=array();
	protected $keep='to,in,on,or,at,by,as,if,be,do,go,hi,jo,le,me,my,no,of,oh,op,pa,i,a,so,us,we';
	protected $pre_dir='H:/movies/mp4';
	 
function __construct($return=''){
	printer::print_request();
	if ($return=='return')return;
	$ignore_dir='';#temp situation develop as needed
	$dir=false;
	$ignore_list=(!is_array($ignore_dir))?explode(',',$ignore_dir):$ignore_dir; 
	$this->ignore_dir=arrayhandler::arraytolower($ignore_list);
	$block=(!empty($this->block_temp))?$this->block_temp:Cfg::Exclude;
	$block_arr=explode(',',$block);
	$this->block_dir=arrayhandler::arraytolower($block_arr);
	
	if (isset($_POST['submitprint'])) {
		$this->mysqlinst = mysql::instance();
		$this->mysqlinst->dbconnect($this->dbname);
		if (isset($_POST['duplicates'])&&!empty($_POST['duplicates'])) {
			$this->truncate=true;
			$dir=trim($_POST['dir']);
			self::pre_search($dir,false);
			$this->duplicates();
			}
		 
		if (isset($_POST['print'])&&!empty($_POST['print'])) {
			self::printdb();
			}	
		}
	if (isset($_POST['submitted'])) {printer::print_request();
		$this->mysqlinst = mysql::instance();
		$this->mysqlinst->dbconnect($this->dbname);
		 
		if (isset($_POST['dir'])&&!empty($_POST['dir'])) {
			$dir=trim($_POST['dir']);
			}
		if (isset($_POST['truncate'])&&!empty($_POST['truncate'])) {
			$this->truncate=trim($_POST['dir']);
			}
		
		if (isset($_POST['subdirectory'])){
			$this->subdirectory=trim($_POST['subdirectory']); 
			}	
		$time= new time();
		echo NL."this dir is $dir"; 
		echo NL. "this subdirectory is $this->subdirectory";
		echo NL. "this truncate is $this->truncate".NL;
		$searchout=self::pre_search($dir,true);
		$display=$time->delta();
		echo NL."time to run this is $display";
		}// if submitted
 
include ('includes/strictheader.nometa.php'); 
  
echo '
<link href="'.Cfg_loc::Root_dir.'program.css" rel="stylesheet" type="text/css" >  
</head>
<body">
<p>view last log replace file<a target="_blank" href="/logreplace/log_replace.html">here</a></p> 
<div class="container"> 
<form action="'. Sys::Self.'" method="post">
<p class="ramana">Directory to Db List: <input type="text" name="dir" value="'.$this->default_dir.'" size="50" maxlength="100" ></p><br>
<p class="ramana"><input name="truncate" type="radio" value=true > Truncate the Current Database Before Add Data</p> 
<p class="ramana"><input name="subdirectory" type="radio" value=false   > Do Not Use Subdirectories  </p> 
<input type="hidden" name="token" value="TRUE" >
<p><input type="submit" name="submit" value="Compile Dirs" ><br><br><br></p>
<input type="hidden" name="submitted" value="TRUE" > 
</div>
</form> 
<form action="'. Sys::Self.'" method="post">
<p class="ramana"><input name="duplicates" type="radio" value=true > Show Duplicates </p> 
<p class="ramana"><input name="print" type="radio" value=true> Print DB </p>  
<p class="ramana">Recompile files only  starting at directory: <input type="text" name="dir" value="'.$this->default_dir.'" size="50" maxlength="100" ></p><br>
<p><input type="submit" name="submit" value="Print/Show Duplicates" ><br><br><br></p>
<input type="hidden" name="submitprint" value="TRUE" > 
</div>
</form> 
</body>
</html>';
	}#end function construct

function duplicates(){  
 
$q="

SELECT *
FROM  dir_list
WHERE newname IN (
    SELECT newname
    FROM dir_list
    GROUP BY newname
    HAVING count(newname) > 1
    ) 
ORDER BY newname
 ";   echo $q;  
$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	$x=0;
$array=array();
	 while($rows=$this->mysqlinst->fetch_assoc($r)){
		$x++;
		echo NL. '*# '.$x.'@ '.$rows['size'].'#*'.$rows['dir'].'/'.$rows['prename']; 
	$array[]=array(
		'name'=>$rows['name'],
		'newname'=>$rows['newname'],
		'dir'=>$rows['dir'],
		'size'=>$rows['size'],
		'type'=>$rows['type'],
		'prename'=>$rows['prename'],
		'extension'=>$rows['extension']);
	}
	 printer::horiz_print($array);
    
 }
 
/* 
 
 
php -r  'include ("includes/Sys.php");
$file_org= new file_oranize("return");
$file_org->compare_directory_list("H:/movies", "J:/movies");
'
or:
<?php
#ExpressEdit 2.0
set_time_limit(300);

  include ("includes/Sys.php");
$file_org= new file_organize("return");
$file_org->compare_directory_list("E:/", "K:/Connie Summer13");
 ?>
 */
function  compare_directory_list($dir, $dir2,$reject_words_strpos='') {
	$this->reject_file=explode(',',$this->reject_file);
	file_put_contents($this->file_pos,'');
	file_put_contents($this->file_neg,'');
	 empty($reject_words_strpos) && $reject_words_strpos=$this->reject_words_strpos;
	 if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	 file_put_contents($this->file,'');
	self::create_file_list($dir2);
	$data= file_get_contents($this->file);
	$this->dataarray=explode('@@@',$data);
	printer::vert_print($this->dataarray);
	 self::comp_dir_list($dir,$reject_words_strpos);
	  file_put_contents($this->file,'');
	 self::create_file_list($dir);
	 $data= file_get_contents($this->file);
	$this->dataarray=explode('@@@',$data);
	printer::vert_print($this->dataarray);
	 self::comp_dir_list($dir2,$reject_words_strpos);
	 }

function comp_dir_list($dir,$reject_words_strpos){
	$dir = rtrim($dir, "/") ."/";  
	if (!$directory_handle = opendir($dir))exit ('$dir is not a directory');
	while (($file_handle = readdir($directory_handle)) !== false) {
		 $fullname=$file_handle;
		$file_handle=strtolower($file_handle);
		 if (($file_handle == '.') || ($file_handle== '..') || ($file_handle==$this->file))continue;
		$path_parts = pathinfo($file_handle);
		if ( isset($path_parts['extension'])){ #check etc
			if (in_array($path_parts['extension'],$this->reject_file))continue;
			}
			
	
	
		if (in_array($file_handle, $this->ignore_file)) {  echo NL. 'ignored: '.$this->ignore_file;  
			continue;
			}
		if (is_dir($dir. $fullname)) { //echo NL. NL. "directory is ".$dir.$file_handle.NL;
			(!empty($this->subdirectory))&& $this->comp_dir_list($dir. $fullname,$reject_words_strpos);
			}                
		if (!is_file($dir.$fullname))continue;
		$file_handle=$path_parts['filename'];
		$file_handle=str_replace(array(' ','-'),'_',$file_handle);
		$file_handle=explode('_',$file_handle);
		#$reject_words_strpos=explode(',',$this->reject_words_strpos);
		$chkarr=array();
		$count=0;
		
		foreach($file_handle as $part){
			#is_numeric($part)||s
			if (strlen($part) < 3) continue;
			#if (in_array($part,$reject_words_strpos)) continue;
			if (check_data::check_array_strpos($part, $reject_words_strpos)===true)continue;
			$count++;
			if ($count <= 3)
				$chkarr[]=$part;
			else { if (count($part)>3)
				$chkarr[]=$part; //simple reasoning more parts less need for a 3 letter part..
				}
			}// end foreach
			printer::vert_print($chkarr);
		$newflag=false;
		foreach ($this->dataarray as $fn){
			$flag=true;
			foreach ($chkarr as $ch){
				 (strpos($fn,$ch)===false) && $flag=false;
				//echo NL. "$fn is filename and $ch is fn name part and flag is $flag";
				}//end foreach
			if ($flag==true){
				$dafile=fopen($this->file_pos,"a+");
				fwrite($dafile, NL."$fn compares with $fullname is in $dir \n"); 	
				fclose($dafile);
				$newflag=true;
				continue;
				}
			}//end foreach	 
			if ($newflag==false) {
				$dafile=fopen($this->file_neg,"a+");
				fwrite($dafile, $fullname . " has no matches in $dir \n");
				fclose($dafile);
				}
	
		}#end while
		}#end function

 function clean_list($name){
	 
		$name=strtolower($name);
		
	$name=str_replace(array(' ','-','.'),'_',$name);
		$name=explode('_',$name);
		 #$reject_words_strpos=explode(',',$this->reject_words_strpos);
		$chkarr=array();
		$count=0;
		$parts=count($name);
		foreach($name as $part){
			if (strlen($part) < 3 && is_numeric($part) && empty($count)) continue;//check_data::check_array_strpos($part, $this->keep)!==true) continue;
			if (check_data::check_array_strpos($part, $this->reject_words_strpos)===true)continue;
			$rej_arr=explode(',',$this->reject_words);
			if (in_array($part,$rej_arr))continue;
			if (empty($part))continue; 
			$chkarr[]=trim($part);
			$count++;
			}// end foreach
	   
		if (is_numeric(end($chkarr))&&strlen(end($chkarr))<6)array_pop($chkarr);//<4 for dates
		return  implode(' ',$chkarr);
	}#end function


function create_file_list($dir){  
	$dir = rtrim($dir, "/") ."/";  
	if (!$dir_handle = opendir($dir)) exit ('problem with opening $dir_han2');
	while (($file_handle = readdir($dir_handle)) !== false) {
		$fullname=$file_handle;
		$file_handle=strtolower($file_handle);
		 if (($file_handle == '.') || ($file_handle== '..'))continue;
		  $path_parts = pathinfo($file_handle);
                  	if ( isset($path_parts['extension'])){
				if (in_array($path_parts['extension'],$this->reject_file))continue;
				}
		 #if (in_array($file_handle,$this->reject_dir))continue;
		 if (is_dir($dir. $fullname)) { //echo NL. NL. "directory is ".$dir.$file_handle.NL;
			//(empty($this->rename_file))&&!empty($this->find_file)&&self::find_fn($dir.$file_handle);#report if directory matches filename
			(!empty($this->subdirectory))&& $this->create_file_list($dir. $fullname);
			}
			#echo "pt 1";  echo $dir.$fullname;
		if (!is_file($dir.$fullname))continue;  
		$file_handle=$path_parts['filename'];
		$dafile=fopen($this->file,"a+");
		fwrite($dafile, $file_handle.'@@@');  
		} #end while
	}#end function
 
function printdb(){  
	$x=0;
	$output='';
	$q="select distinct  newname  from $this->tablename where type ='file' order by newname";
	$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	while($rows=$this->mysqlinst->fetch_row($r)){
		$name=$rows[0];//(strpos($rows[0],'.')!==false)?substr($rows[0],0,strrpos($rows[0],'.')):$rows[0];
		 if(!empty($name)){
			 $output.='|'.str_replace('_',' ',$name);
			$x++;
			 }
		}
	 $q="SELECT COUNT(distinct(newname)) AS count FROM $this->tablename where type='file'";  // for placing deleted pic to archive... current total is....
				    $r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
				    if ($this->mysqlinst->affected_rows($r) > 0) { 
					    $row = $this->mysqlinst->fetch_assoc($r,__LINE__);
					    $count=$row['count'];
					    }
	$output.=" No. of included files is   $x and distinct-count is $count";	
	echo $output;
	if(!file_put_contents($this->outputfile,$output))echo 'did not print output file to '. $this->outputfile;
	else echo NL. "outputed to $this->outputfile";
	}
function pre_search($dir,$dirreg=true){
	set_time_limit(200);  
	if ($this->truncate==true){
		$q="TRUNCATE $this->tablename"; printer::alert_pos( NL.$q);
		$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
		}
	self::search($dir,$dirreg);
	  (!empty($this->pre_dir))&&self::search($this->pre_dir,$dirreg);
	   
	
	}
  
  function search ($dir='c:/xampp/htdocs',$dirreg=true) {  
	if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	$dir = rtrim($dir, "/") ."/";   
	if ($directory_handle = opendir($dir)) {
		while (($file_handle = readdir($directory_handle)) !== false) {  
			// Is the file in the ignore_file list ; 
			//$file_handle=strtolower($file_handle);
		    if ($file_handle[0]=='.')continue;
		    if (in_array($file_handle, $this->ignore_dir)) {    
			  continue;
			   }  
		    if (in_array(strtolower($file_handle), $this->block_dir)) {     
			  continue;
			   }
		    if (is_dir($dir. $file_handle)) {   
			  ($dirreg)&&self::dir_reg($dir. $file_handle); 
			  ($this->subdirectory)&& $this->search($dir. $file_handle,$dirreg);
			  } 
		    else if(is_readable($dir. $file_handle)){  
			 self::file_reg($dir. $file_handle); 
			 }
			
		  }// end while
	   }// if directory
    }// end function buildlist
#note the idea is to get rid of useless name files for videos and
#instead use the directory names as appropriate....
function dir_reg($dir){    
	$dir_check=rtrim($dir,'/');//(substr($dir, -1) != "/")?$dir:substr_replace($dir,"",-1);// here we remove trailing slash can use $dir=rtrim($dir,'/');
	$fullname=trim(substr($dir,(strrpos($dir_check,'/')+1))); #returns last subdirectory only  ie substring(dir,5) return after 5 characters to end..
	$reject_array=explode(',',$this->reject_dir);
	if (in_array($fullname,$reject_array))return;
	$reject_array=explode(',',$this->reject_strpos);
	foreach ($reject_array as $rej){
	   if (strpos(strtolower($fullname),$rej)!==false)return;
	   }
	   $name=strtolower($fullname);
	foreach ($this->replace_atring as $string){
	   $name=trim(str_replace($string, ' ',$name));
	   }
	$retval = array(
	"name" => "$name",
	"newname" =>self::clean_list($name),
	"type" => filetype($dir),
	"size" => 'NA',
	"extension"=>'dir',
	"dir" => "$dir",
	"prename" => "$fullname",#this is actually just subname
	"currentDate" => date("dMY-H-i-s"),
	"lastmod" => date("m/j/y h:i",filemtime($dir)));
	self::db_gen($retval);
	}
function file_reg($file){
	$path_parts = pathinfo($file);
	 $extension=(isset($path_parts['extension']))?$path_parts['extension']:'';//substr($file,strrpos($file,'.')+1);
	$basename=$path_parts['basename'];//this gives filename with extension
	$fullentry=$path_parts['filename'];
	$dir=$path_parts['dirname'];
	$reject_array=explode(',',$this->reject_file);
	if (in_array(strtolower($extension),$reject_array))return;
	$reject_array=explode(',',$this->reject_strpos);
	foreach ($reject_array as $rej){
	   if (strpos(strtolower($file),$rej)!==false)return;
	   }
	//   $file_check=(substr($file, -1) != "/")?$file:substr_replace($file,"",-1);//remove trailing / how about trim($file,'/') instead?                                                                                                                                                                                                                                 
	//$dir=substr($file,0,(strrpos($file_check,'/')+1)); //name before /
	//$fullentry=trim(substr($file,(strrpos($file,'/')+1)));//name after /
	$entry=strtolower($fullentry);
	foreach ($this->replace_atring as $string){
		$entry=trim(str_replace($string, ' ',$entry));
		} 
	$retval= array(
	"name" => "$entry",
	"newname" => self::clean_list($entry),
	"type" =>  filetype($file),
	"size" =>  round((filesize($file)/1000000),0).'MB',
	"extension"=> $extension,
	"dir" => $dir,
	"prename" => "$basename",
	"currentDate" =>  date("dMY-H-i-s"),
	"lastmod" =>date("m/j/y h:i",filemtime($file)));
	self::db_gen($retval);
	}
function db_gen($array){
	#$q="INSERT INTO dir_list (name,size,type,lastmod) values ( 'zeitgeist.flv','802464KB','file','01/13/12 09:44')";$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	$q="INSERT INTO $this->tablename (name,newname,type,size,extension,dir,prename,currentDate,lastmod) values ( ";   
	foreach ($array AS $key => $val){
		$q.="'".str_replace("'",'',$val)."',";   
		}
	$q=substr_replace($q ,"",-1).')';
	 
	$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	}
	#use select distinct name from table to eliminate doubles
}// end class search_replace
?>