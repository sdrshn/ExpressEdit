<?php
#ExpressEdit 2.0.1
class fullloader{ 
function fullpath($file) {
	if (is_file(Cfg_loc::Root_dir.'includes/'.$file)) 
          include_once Cfg_loc::Root_dir.'includes/'.$file;
	else {
		$path= stream_resolve_include_path('includes/'.$file);
		if (!$path===false){ 
			include_once $path; 
			} 
          elseif (is_file(TWO_UP.'includes/'.$file)) 
               include_once TWO_UP.'includes/'.$file;
          elseif (is_file(ONE_UP.'includes/'.$file)) 
               include_once ONE_UP.'includes/'.$file; 
          else {
               print "<p>
      System fullloader is searching for you master classes to include them in the program:
     <br>Include path for including the master classes will Search the following directories in this order:
     <br>Web Site directory Home path: ".HOME_PUB."
     <br>Following the ".PATH_SEPARATOR." separated list of directories in  the php.ini include_path directive:   ". get_include_path()."
    <br>Two Directories Up: ".TWO_UP." (for subdomains and subdirectories will be user home directory)
     <br>Then One Directory Up: ".ONE_UP." 
    <br><br></p>";
               }
          }
     }
 
}//end class
?>