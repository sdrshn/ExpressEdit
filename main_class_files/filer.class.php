<?php
#ExpressEdit 2.0
class filer extends file_organizer {	
function __construct(){
		  $dir=false;
		  $add=false;
		  $ignore=false;
if (isset($_POST['submitted'])) {   
	    if (isset($_POST['dir'])&&!empty($_POST['dir'])) {
		  $dir=trim($_POST['dir']);
		  }
	    
	$time= new time();
	$searchout=self::render_search($dir);
	$display=$time->delta();
	echo NL."time to run this is $display";
	// function __construct ($searchString, $extension="php", $dir=Sys::Docs, $replace_var=false, $subdirectory='false', $include_php=false,$add_extension='.bac' ){
	//function renmae(oldname, newname);
	}// if submitted
 
include ('includes/strictheader.nometa.php'); 
  
echo '
<link href="'.Cfg_loc::Root_dir.'program.css" rel="stylesheet" type="text/css" />  
</head>
<body">
<p>view last log replace file<a target="_blank" href="/logreplace/log_replace.html">here</a></p> 
<div class="container"> 
 <form action="'. Sys::Self.'" method="post">
 <p class="ramana">String to search: <input type="text" name="search" value="'.$search.'" size="50" maxlength="100" /></p><br/>
	 <p class="ramana">String to replace with: <input type="text" name="replaceThis"  size="50" maxlength="100" />All replaced files will be backedup with .bac extension</p>
	  <p class="ramana">Additional Ignore directories:  \'outdated,design\' <input type="text" name="ignore"  value="'.$ignore.'" size="100" maxlength="200" /></p>
	 <p class="ramana">File extension: <input type="text" name="extension" value=".php" size="4" maxlength="10" />Search files with this extension; empty equal all</p>
	 <p class="ramana">Directory Start: <input type="text" name="dir" value="'.Sys::Pub.'" size="80" maxlength="80" /></p>
	 <p class="ramana">Append file extension to deactivate: <input type="text" name="add"   size="4" maxlength="10" />Keeps original filename; replaced files will have this extension</p>
	 
	 <fieldset ><legend>Enable Subdirectory Search</legend>
	   <p class="ramana"><input name="sub" type="radio" value=true   /> Subdirectory True   </p> 
	<p class="ramana"><input name="sub" type="radio" value="" checked="checked"   />Subdirectory false</p>
	</fieldset>
	
	 
	 <fieldset ><legend>Enable Include Dir Search</legend>
	<p class="ramana"><input name="include" type="radio" value=true   /> Include dir True   </p> 
	<p class="ramana"><input name="include" type="radio" value="" checked="checked"/> Include dir false</p><input type="hidden" name="submitted" value="TRUE" />
	</fieldset>
	 <fieldset ><legend>Enable Replace</legend>
	<p class="ramana"><input name="rep_button" type="radio" value=true/> replace True   </p> 
	<p class="ramana"><input name="rep_button" type="radio" value="" checked="checked"   /> Replace false</p>
	</fieldset>
	 <p class="ramana">Filename to search for: <input type="text" name="filename" value="'.$filename.'"  size="50" maxlength="100" /></p>
	<p class="ramana">Filename to replace with Optional: <input type="text" name="rename" value="'.$rename.'"  size="50" maxlength="100" /></p>
	<fieldset ><legend>Delete filename specified</legend>
	<p class="ramana"><input name="delete" type="radio" value=true   /> Delete the file True   </p> 
	<p class="ramana"><input name="delete" type="radio" value="" checked="checked"   /> Delete false</p>
	</fieldset>
	 <fieldset ><legend>Remove filename Spaces in Directory</legend>
	<p class="ramana"><input name="remove_space" type="radio" value=true   /> Remove Space True   </p> 
	<p class="ramana"><input name="remove_space" type="radio" value="" checked="checked"   /> Remove Space False</p>
	</fieldset>
	 <input type="hidden" name="token" value="TRUE" />
  <p><input type="submit" name="submit" value="Find/replaceThis" /><br/><br/><br/></p>
	<input type="hidden" name="submitted" value="TRUE" /> 
</div>
</form> 
 

	
</body>
</html>';
	}#end function construct
}#enc class searc
?>