<?php
#ExpressEdit 2.0
    if(!defined('xinstall')&&!is_file('./includes/Cfg.class.php')) {
          die('Direct access not permitted from this location. Move to and Run from Your Domain/SubDirectory Root'); 
     //taken from php.net  pages zelnaga at gmail dot com ¶
          }
   
if (!function_exists('stream_resolve_include_path')) {
     
     function stream_resolve_include_path($filename)
    {
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
     $msg=(is_file('./includes/Cfg.class.php'))?'This file will be moved to the includes directory from which it has been configured not to run from direct access to prevent anyone from. If you need to rerun this file to generate intital files if the system isnt running then move it to the domain root directory for this webpage again.':'';
echo '<html>
     <head>
     </head>
     <body><b>This file Runs from website home directory site for initial installs and will rerun if Cfg_loc.class.php files are missing!!</b><br><p style="color:green;">'.$msg.'</p>'; 
if (!isset($_SERVER['SCRIPT_FILENAME'])||empty($_SERVER['SCRIPT_FILENAME'])){
	trigger_error( 'System error in '.__FILE__.' reading: $_SERVER[\'SCRIPT_FILENAME\']');
     exit();
     }
$home_pub= rtrim(pathinfo($_SERVER['SCRIPT_FILENAME'])['dirname'],DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR; 
#if Cfg.class.php is included it extends Cfg_master.class.php which may be in user server home directory so we need to determine that path if its not included in the php.ini include_path...
#to do this will physically derive from the Cfg.class.php setup
$one_up=rtrim(dirname(rtrim($home_pub,DIRECTORY_SEPARATOR)),DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;
$two_up=rtrim(dirname(rtrim($one_up,DIRECTORY_SEPARATOR)),DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;
define('ONE_UP',$one_up); 
define('TWO_UP',$two_up);
#RENAME this file back to includes directory so that cant be malicously launched!! 
define('HOME_PUB',$home_pub);
#Cfg classes used in Sys.php  autoloader therefore preloaded. 
function autoloading($file){
     if (is_file('./includes/'.$file.'.class.php')) 
          include_once './includes/'.$file.'.class.php';
	else {  
		$path= stream_resolve_include_path('includes/'.$file.'.class.php'); 
		if (!$path===false){ 
			include_once $path;
               $pathinc=str_replace('includes/'.$file.'.class.php','',$path);
			} 
          elseif (is_file(TWO_UP.'includes/'.$file.'.class.php')){ 
               include_once TWO_UP.'includes/'.$file.'.class.php';
               }
          elseif (is_readable(ONE_UP.'includes/'.$file.'.class.php')) 
               include_once ONE_UP.'includes/'.$file.'.class.php'; 
          else {
               print "<p>
           System has unsuccessfully searched for you master classes to include them in the program:
     <br>Include path for including the master classes will Search the following directories in this order:
     <br>Web Site directory Home path: $home_pub
     <br>Following the ".PATH_SEPARATOR." separated list of directories in  the php.ini include_path directive:   ". get_include_path."
    <br>Two Directories Up: $two_up (for for subdomains and subdirectories will be user home directory)
     <br>Then One Directory Up: $one_up 
    <br><br></p>";
               }
          } 
     }//end autoloading
 spl_autoload_register("autoloading");
     foreach(array('Cfg_master','Cfg','file_generate') as $incfile){echo $incfile;
          new $incfile();
          }
     printer::alert('The following common_files will be auto regenerated if missing and configurations will be updated');
      
     file_generate::config_gen_init();//this is done first in case...  for primordial file generation of config files....
     new Sys(); return;
     
?>