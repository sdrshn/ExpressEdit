<?php
function show_close(){
	echo '</div><!--Close Show More-->';
	}  

function show_more($msg_open,$msg_close='close',$class='ramana left',$tag=''){ if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
 static  $show_more=0; $show_more++; //echo 'show more is '.$this->show_more;
    echo '<p class="'.$class.'" style="display:inline-block; text-decoration:underline; cursor:pointer;" title="'.$tag.'" onclick="gen_Proc.show(\'show'.$show_more.'\',\''.$msg_open.'\',\''.$msg_close.'\');" id="show'.$show_more.'" onmouseover="this.style.cursor=\'pointer\'" >'.$msg_open.'</p>';	 
	printer::spanclear('0');
	echo'<div  id="show'.$show_more.'t" style="display: none; ">  ';
    }
$id_ref=request::check_request_data('id_ref');
(empty($id_ref))&&$id_ref='id';
$id=request::check_request_data('id');
$sess_token=request::check_request_data('sess_token');
(empty($id))&&$id=1; 
$table_list=check_data::return_all(__METHOD__,__LINE__,__FILE__,false);
$type=request::check_request_data('type');  
$width=request::check_request_num('www'); 

$f=request::check_request_data('fff');
if (!empty($f)){   
	$vidinfo=$f;
	}
else {
   $refer=new redirect;
   $refer->page_referrer_redirect("!MISSING INFORMATION: TRY AGAIN!", '', $sess->page_referrer_2,'true'); 
   }
$css=request::check_request_data('css');
$css=(!empty($css))?$css:Cfg_loc::Root_dir.'addeditmaster';
$t=request::check_request_data('ttt');
if (!empty($t)){   
 if (in_array($t, $table_list)){$tablename=$t; }
    else {
	   $refer=new redirect;
	   $refer->page_referrer_redirect("!MISSING INFORMATION: TRY AGAIN!", '', $sess->page_referrer_2,'true'); 
	   }
    }//end if isset($_GET)
else {
    $refer=new redirect;
    $refer->page_referrer_redirect("!!MISSING INFORMATION: TRY AGAIN!!", '',$sess->page_referrer_2,'true'); 
    }
$pt=request::check_request_data('pgtbn');
if (!empty($pt)){  
	if (in_array($t, $table_list)){$pgtablename=$pt; }
	else {
		$pgtablename=$tablename;
		}
	}//end if isset($_GET)t=request::check_request_data('tbn');
else {
	$pgtablename=$tablename;
	}  
$postreturn=request::check_request_data('postreturn');
if (empty($postreturn)){
		mail::alert('empty postreturn');
		$refer=new redirect;
		$refer->page_referrer_redirect("!MISSING POST INFORMATION: TRY AGAIN!", '', $sess->page_referrer_2,'true'); 
		}
		
if (is_file('../includes/html5_header_utility.php'))	
	include ('../includes/html5_header_utility.php');
else include ('includes/html5_header_utility.php');
echo '<title>Upload Post Image</title>';
$java=new javascript('gen_Proc,checkVidFile,checkUploadFile','print');
echo $java->javascript_return;
echo'
<link href="'.$css.'.css" rel="stylesheet" type="text/css" > 
<link href="'.$css.'edit.css" rel="stylesheet" type="text/css" >
<style type="text/css">  
.container{margin:70px auto 30px auto;
	max-width:800px;
	padding-top: 10px;
	width: 80%;
	} 
.addvidbackto {float:left; margin-left 50px; max-width:200px; margin-bottom:20px; padding:.5em .9em ;background-color: rgba(255,255,255,0.5);
	 font-size: .9rem; font-family: arial,sans-serif;font-weight: 700;
	-moz-box-shadow: 0px 0px 5px 0px #FFC0C7;
	-webkit-box-shadow: 0px 0px 5px 0px #FFC0C7;
	box-shadow: 0px 0px 5px 0px #FFC0C7;
	 -moz-border-radius:3px; -webkit-border-radius:3px; border-radius:3px;
-moz-box-shadow: 1px 1px 5px -4px #0a2268;
-webkit-box-shadow: 1px 1px 5px -4px #0a2268;
	}
form {margin:0 auto; text-align: center;  max-width:500px; }
.fs2npinfo {border: 2px  solid #e5d805;}
.fsminfo   {margin: 4px; padding:4px; border: 4px  double #e5d805 }
.indent {padding:20px 40px; text-align:left;}
.shadow{font-weight:200; text-shadow: #f2f0e4 1px 0px 1px}  
.fs2forest{padding: 4px 4px 4px 5px; border: 2px  solid #30720f;} 
.mback {background:#f8e7e6;}
.backtoborder{ position:absolute; top: 0px; left: 0px;
 width:100%; height:100%; padding:   .5rem 0 .9rem 0;
 -moz-border-radius:3px; -webkit-border-radius:3px; border-radius:3px;
-moz-box-shadow: 1px 1px 5px -4px #0a2268;
-webkit-box-shadow: 1px 1px 5px -4px #0a2268;
box-shadow: 1px 1px 5px -4px #0a2268;
	     }
		
fieldset {width:80%;}
.addtbn{padding-top:5px;font-variant: small-caps; color:#fff; font-size: 1.2em;}
</style>
</head>
<body class="editbackground editcolor"> 
<div class="container">';
//printer::alert_conf('You Are Adding A New Video to the Page: '.$pgtablename,'000',1.5);   
echo '<div class="addvidbackto"><a href="'.$postreturn.'?#return_'.$id.'">Back to '.substr($pgtablename,0,15).'</a></div>';
printer::pclear(70);
 
$instructions=NL.'Currently the filetypes '.Cfg::Valid_vid_ext.' will work.  Let me know if you would like another';
$instructions.=NL.'You can click on the link below the video in the edit page and upload a preview photo';
    $max_upload = (int)(ini_get('upload_max_filesize'));
	$max_post = (int)(ini_get('post_max_size'));
	$memory_limit = (int)(ini_get('memory_limit'));
	$config=Cfg::Vid_max/1000000;//see Cfg.class.php 
	$upload_mb = min($max_upload, $max_post, $memory_limit,$config);
	$max=$upload_mb*1000000;
   $instructions=NL."The maximimum video file size is limited to $upload_mb Mb $instructions";
    
show_more('Upload Filesize Limit: '.$upload_mb.'Mb','','info pt5 pb5 pl10 floatleft');
	
	echo '
	Current php.ini limits and User Cfg.class.php setting:
	<table border="1"  class="fsminfo editcolor editbackground">
	<tr><th>upload_max_filesize</th><th>post_max_size</th><th>memory_limit</th><th>Cfg::Vid_max</th>
	</tr>
	<tr>
	<td>'.$max_upload.'Mb</td><td>'.$max_post.'Mb</td><td>'.$memory_limit.'Mb</td><td>'.$config.'Mb</td>
	</tr> 
     <th><b>Upload filesize limit:</b></th>
     <tr><td><b>'.$upload_mb.'Mb</b></td></tr>
	</table>';
	show_close();
	printer::pclear(3);
echo'
<form  enctype="multipart/form-data" action="'.$postreturn.'" method="post" onsubmit="return checkVidFile(this,'.$max.');">
 <p><input class="editbackground editcolor"   type="hidden" name="MAX_FILE_SIZE" value="'.$max.'"></p>
<fieldset class="editcolor"><legend class="info">Choose your video to UPload!!</legend>';
echo'
<p><b>File:</b> <input id="fileinput" style="background:#fff;color: #5b0554;"   type="file" name="upload"></p>
</fieldset>';

	
printer::pclear(20);
echo'  
<p><input type="hidden" name="pgtbn" value="'.$pgtablename.'" ></p>
<input type="hidden" name="width" value="'.$width.'">
<p><input type="hidden" name="type" value="'.$type.'" ></p>
<p><input type="hidden" name="id" value="'.$id.'" ></p>
<p><input type="hidden" name="id_ref" value="'.$id_ref.'" ></p>
<p><input type="hidden" name="ttt" value="'.$tablename.'" ></p>
<p><input type="hidden" name="fff" value="'.$vidinfo.'" ></p>  
<p><input type="hidden" name="sess_token" value="'. $sess_token .'" ></p>
<p><input class="fs3pos editcolor editbackground rad10" type="submit" name="submit" value="Submit" ></p>
<p><input type="hidden" name="addpagevidsubmitted" value="TRUE" ></p></div>
</form>
</div>
</body>
</html>';
?>	