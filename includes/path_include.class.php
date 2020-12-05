<?php
#ExpressEdit 2.0.4
if(ob_get_level())ob_end_clean();//used in editmode
if ( ! defined( "PATH_SEPARATOR" ) ) {
          if ( strpos( $_ENV[ "OS" ], "Win" ) !== false )
               define( "PATH_SEPARATOR", ";" );
          else define( "PATH_SEPARATOR", ":" );
          }
if (!function_exists('stream_resolve_include_path')) {
     //mod from php.net  pages zelnaga at gmail dot com ¶
     function stream_resolve_include_path($filename){
		if ( PATH_SEPARATOR == ':' ) 
			$path=preg_split('#(?<!phar):#', get_include_path()); 
          else 
               $path =explode(PATH_SEPARATOR, get_include_path());
		foreach ($paths as $prefix) {
			$ds = (substr($prefix, -1) == DIRECTORY_SEPARATOR) ? '' : DIRECTORY_SEPARATOR;
			$file = $prefix . $ds . $filename;
			if (file_exists($file)) {
				return $file;
				}
			}
		return false;
		}
	}
if (is_file('./includes/Cfg_loc.class.php'))
     include_once ('./includes/Cfg_loc.class.php');
	 
else exit('Missing Cfg_loc.class.php file in includes directory.'); 
     
if (!isset($_SERVER['SCRIPT_FILENAME'])||empty($_SERVER['SCRIPT_FILENAME'])){
	trigger_error( 'System error in '.__FILE__.' reading: $_SERVER[\'SCRIPT_FILENAME\']');
     exit();
     }
$hp= rtrim(pathinfo($_SERVER['SCRIPT_FILENAME'])['dirname'],DIRECTORY_SEPARATOR); 
if (Cfg_loc::Root_dir==='../'){
     $home_pub=dirname($hp).DIRECTORY_SEPARATOR; 
     }
else $home_pub=$hp.'/'; 
$one_up=rtrim(dirname(rtrim($home_pub,DIRECTORY_SEPARATOR)),DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;
$two_up=rtrim(dirname(rtrim($one_up,DIRECTORY_SEPARATOR)),DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;
define('ONE_UP',$one_up); 
define('TWO_UP',$two_up); 
define('HOME_PUB',$home_pub);  
function my_autoload($file) {
	if (is_file(Cfg_loc::Root_dir.'includes/'.$file.'.class.php')) 
          include_once Cfg_loc::Root_dir.'includes/'.$file.'.class.php';
	else {
		$path= stream_resolve_include_path('includes/'.$file.'.class.php');
		if (!$path===false){ 
			include_once $path;
               $pathinc=str_replace('includes/'.$file.'.class.php','',$path);
               if (!defined('PATHINC'))define('PATHINC',$pathinc);  
			} 
          elseif (is_file(TWO_UP.'includes/'.$file.'.class.php')) 
                
               include_once TWO_UP.'includes/'.$file.'.class.php';
          elseif (is_file(ONE_UP.'includes/'.$file.'.class.php')) 
               include_once ONE_UP.'includes/'.$file.'.class.php'; 
          else {
               print "<p>
          Config problem, Program-System problem or Missing Files. System is searching for you master class incudes directory to include them in the program:
     <br>Include path for including the master classes will Search the following directories in this order:
     <br>Web Site directory Home path: ".HOME_PUB."
     <br>Following the ".PATH_SEPARATOR." separated list of directories in  the php.ini include_path directive:   ". get_include_path()."
    <br>Two Directories Up: ".TWO_UP." (for subdomains and subdirectories will be user home directory)
     <br>Then One Directory Up: ".ONE_UP." 
    <br><br></p>";
               }
          }
     }
     spl_autoload_register("my_autoload");
?>