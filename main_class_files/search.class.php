<?php
#ExpressEdit 2.0
class search extends search_replace {
	protected $log_txt='logfile/log_replace.txt';
	protected $log_rtf='logfile/log_replace.rtf';
	protected $log_html='logfile/log_replace.html';
	public $default_arr=array('replace_button','subdirectory','include_php','delete_file','cleanup','regenerate_test','clear_mylog');//these values will not be reposted
function __construct(){
	 
	$pass_post='';
	$name_array=array();
	//$array=array('searchstring','extension','dir','replace_it','subdirectory','include_php','add_extension','replace_button','find_file','ignore_file','delete_file','rename_file','replace_space','case','cross_ref','regenerate_test');
 
	$array =array(
			array(
		    "name" => "searchstring",
		    "value" =>false,
		    "type" =>'text' ,
		    "show_size" =>50,
		    "maxlength" => 100,
		    "text1" =>'String to search: ',
		    "text2"=>'><br>
 Add to preg match i for lower case x for white space <br>
 and s for overlook \n with a (.+?)<br>
 special chars need to be escapted: \ ^ . $ | ( ) [ ]
        // * + ? { } , '
		    ),
		array(
		    "name" => "case",
		    "value" => false,
		    "type" =>'radio' ,
		    "show_size" =>50,
		    "maxlength" => 100,
		    "text1" =>'Make Search Case Sensitive (Works only in normal Search) ',
		    "text2"=>'Case: '
		    ),
		array(
		    "name" => "cross_ref",
		    "value" =>false,
		    "type" =>'text' ,
		    "show_size" =>50,
		    "maxlength" => 100,
		    "text1" =>'Cross ref Search comma separated values   ',
		    "text2"=>''
		    ),  
		array(
		    "name" => "replace_it",
		    "value" => false,
		    "type" =>'text' ,
		    "show_size" =>50,
		    "maxlength" => 100,
		    "text1" =>'String to replace with: ',
		    "text2"=>'all replaced files will be backedup with .bac extension<br>
	You can also preg replace between/ / and $match replace keeping central (portion) using @@@ to split the terms. ie  /strpos@@@(.+)@@@!=false/  and replace with strpos@@@hi there@@@!==false  to give extra =  note: the high  there doenst show up and is not necessary!'
		    ), 
		array(
		    "name" => "replace_button",
		    "value" => false,
		    "type" =>'radio' ,
		    "show_size" =>'NA',
		    "maxlength" => 'NA',
		    "text1" =>'Replace ',
		    "text2"=>'Replace '
		    ),
		array(
		    "name" => "ignore_file",
		    "value" => false,
		    "type" =>'text' ,
		    "show_size" =>50,
		    "maxlength" => 100,
		    "text1" =>'Additional Ignore directories:  \'outdated,design\' ',
		    "text2"=>''
		    ),  
		array(
		    "name" => "extension",
		    "value" => '',
		    "type" =>'text' ,
		    "show_size" =>6,
		    "maxlength" => 12,
		    "text1" =>'Search files with this extension; empty equal all  ',
		    "text2"=>''
		    ),
		array(
		    "name" => "dir",
		    "value" =>   'F:/Documents',
		    "type" =>'text' ,
		    "show_size" =>50,
		    "maxlength" => 100,
		    "text1" =>'Directory Start:  ',
		    "text2"=>' '
		    ), 
		array(
		    "name" => "add_extension",
		    "value" =>false,
		    "type" =>'text' ,
		    "show_size" =>6,
		    "maxlength" => 10,
		    "text1" =>'Append file extension to deactivate:  ',
		    "text2"=>'Keeps original filename; replaced files will have this extension '
		    ),  
		array(
		    "name" => "subdirectory",
		    "value" => false,
		    "type" =>'radio' ,
		    "show_size" =>'NA',
		    "maxlength" => 'NA',
		    "text1" =>'Enable Subdirectory Search  ',
		    "text2"=>'Subdirectory: '
		    ),
		array(
		    "name" => "include_php",
		    "value" => false,
		    "type" =>'radio' ,
		    "show_size" =>'NA',
		    "maxlength" => 'NA',
		    "text1" =>'Utilize include directory ',
		    "text2"=>'Include dir  '
		    ),
		array(
		    "name" => "clear_mylog",
		    "value" => false,
		    "type" =>'radio' ,
		    "show_size" =>'NA',
		    "maxlength" => 'NA',
		    "text1" =>'Truncate mylog files',
		    "text2"=>'Clear mylog.txt '
		    ),
		array(
		    "name" => "find_file",
		    "value" =>false,
		    "type" =>'text' ,
		    "show_size" =>50,
		    "maxlength" => 100,
		    "text1" =>'Filename to search for: ',
		    "text2"=>' '
		    ),
		array(
		    "name" => "delete_file",
		    "value" => false,
		    "type" =>'text' ,
		    "show_size" =>50,
		    "maxlength" => 100,
		    "text1" =>'Delete filename specified: ',
		    "text2"=>'Delete filename '
		    ),
		array(
		    "name" => "rename_file",
		    "value" =>false,
		    "type" =>'text' ,
		    "show_size" =>50,
		    "maxlength" => 100,
		    "text1" =>'Filename to replace with Optional:  ',
		    "text2"=>' '
		    ),
		array(
		    "name" => "replace_space",
		    "value" =>false,
		    "type" =>'text' ,
		    "show_size" =>50,
		    "maxlength" => 100,
		    "text1" =>'Remove filename Spaces in Directory ',
		    "text2"=>'Remove spaces '
		    ),
		array(
		    "name" => "cleanup",
		    "value" =>false,
		    "type" =>'text' ,
		    "show_size" =>8,
		    "maxlength" =>8,
		    "text1" =>'Delet files with this extension',
		    "text2"=>'Delete this extension files '
		    ),
		array(
		    "name" => "regenerate_test",
		    "value" => false,
		    "type" =>'radio' ,
		    "show_size" =>'NA',
		    "maxlength" => 'NA',
		    "text1" =>'Regenerate Test Includes ',
		    "text2"=>'Regenerate: '
		    )
		);
	 list ($pass_arr,$array)=forms::form_process($array,$this->default_arr);
	//echo "array is "; printer::horiz_print($array);
	//echo "padd arr is "; printer::vert_print($pass_arr);
	#set back to false
	 $time= new time();  
	if (isset($_POST['submitted'])) {
		$searchout=self::render_search($pass_arr);
		}
	$display=$time->delta();
	
    include ('includes/strictheader.nometa.php'); 
	
echo '
<link href="'.Cfg_loc::Root_dir.'program.css" rel="stylesheet" type="text/css" >  
</head>
<body>
<p>view last log replace file<a target="_blank" href="'.$this->log_html.'">here</a></p> 
<p>view full log replace file<a target="_blank" href="'.$this->log_txt.'">here</a></p>
<div class="container">';
forms::form_render($array);
echo'
<p class="ramana"><a href="db_files.php">Db List Files</a></p>';
echo NL."time to run this is $display";
echo'
<p class="ramana"><a href="display.php">Display Database</a></p>
</div>
</body>
</html>';
	}#end function construct
 

}#enc class searc
?>