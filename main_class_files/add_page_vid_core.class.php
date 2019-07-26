<?php
#ExpressEdit 2.0.4
class add_page_vid_core {
function __construct(){
	$id_ref=request::check_request_data('id_ref');
	(empty($id_ref))&&$id_ref='id';
	$id=request::check_request_data('id');
	$sess_token=request::check_request_data('sess_token');
	(empty($id))&&$id=1; 
	$table_list=check_data::return_all(__METHOD__,__LINE__,__FILE__,false);
	$type=request::check_request_data('type');  
	$width=request::check_request_num('www'); 
	$f=request::check_request_data('fff');
	$masterpost=request::check_request_data('masterpost');
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
		}
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
	$load=new fullloader();
	$load->fullpath('html5_header_utility.php'); 
	echo '<title>Upload Post Image</title>';
	echo '
     <script  src="../scripts/jquery.min.js"></script>'; 
	$java=new javascript('gen_Proc,edit_Proc','print');
	echo $java->javascript_return;
	echo'
	<link href="'.$css.'.css" rel="stylesheet" type="text/css" > 
	<link href="'.$css.'edit.css" rel="stylesheet" type="text/css" >
	<link href="../styling/gen_edit.css" rel="stylesheet" type="text/css" >
	<link href="../styling/gen_page.css" rel="stylesheet" type="text/css" >
	<style type="text/css">  
	.container{margin:70px auto 30px auto;
		max-width:800px;
		padding-top: 10px;
		width: 80%;
		}
	
	table {border-width:1px;}
	.addvidbackto {float:left; margin-left: 50px; max-width:200px; margin-bottom:20px; padding:.5em .9em ;background-color: rgba(255,255,255,0.5);
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
	echo '<div class="addvidbackto"><a href="'.$postreturn.'?#return_'.$id.'">Back to '.substr($pgtablename,0,15).'</a></div>';
	printer::pclear(70);
	$instructions=NL.'Currently the filetypes '.Cfg::Valid_vid_ext.' will work.  Let me know if you would like another';
	$instructions.=NL.'You can click on the link below the video in the edit page and upload a preview photo';
	$max_upload = (ini_get('upload_max_filesize')<10000)?(int)(ini_get('upload_max_filesize')):(int)(ini_get('upload_max_filesize')/1000000);
	$max_post = (ini_get('post_max_size')<10000)?(int)(ini_get('post_max_size')):(int)(ini_get('post_max_size')/1000000); 
	$config=(int)Cfg::Vid_upload_max; //see Cfg_master.class.php
	$maxup=min($max_upload,$max_post,$config); 
     $maxbytes=$maxup*1000000;
	$instructions=NL."The maximimum video file size is limited to $maxup Mb $instructions";
	$this->show_more('Upload Filesize Limit: '.$maxup.'Mb','','info pt5 pb5 pl10 floatleft');
	printer::print_wrap('wrap filesize table');
	echo '
	Current php.ini limits and User Configurations:
	<table   class="fsminfo editcolor editbackground">
	<tr><th>upload_max_filesize <br>php.ini</th><th>post_max_size<br>php.ini</th><th>Cfg::Vid_upload_max<br>Cfg_master.class.php or Cfg.class.php</th>
	</tr>
	<tr>
	<td>'.$max_upload.'Mb</td><td>'.$max_post.'Mb</td><td>'.$config.'Mb</td>
	</tr> 
	</table>
          <table  class="fsminfo editcolor editbackground">
		<tr><th><b>Upload filesize limit:</b></th></tr>
		<tr><td><b>'.$maxup.'Mb</b></td></tr>
		</table>';
	printer::close_print_wrap('wrap filesize table');
	$this->show_close();
	printer::pclear(3);
	echo'
	<form  enctype="multipart/form-data" action="'.$postreturn.'" method="post" onsubmit="return edit_Proc.checkVidFile(this,'.$maxbytes.',\'fileinput\');">
	 <p><input class="editbackground editcolor"   type="hidden" name="MAX_FILE_SIZE" value="'.$maxbytes.'"></p>
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
	<p><input type="hidden" name="masterpost" value="'.$masterpost.'" ></p>
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
	}//end construct
	
function show_close(){
	echo '</div><!--Close Show More-->';
	}  

function show_more($msg_open,$msg_close='close',$class='ramana left',$tag=''){ if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
 static  $show_more=0; $show_more++; //echo 'show more is '.$this->show_more;
    echo '<p class="'.$class.'" style="display:inline-block; text-decoration:underline; cursor:pointer;" title="'.$tag.'" onclick="gen_Proc.show(\'show'.$show_more.'\',\''.$msg_open.'\',\''.$msg_close.'\');" id="show'.$show_more.'" onmouseover="this.style.cursor=\'pointer\'" >'.$msg_open.'</p>';	 
	printer::spanclear('0');
	echo'<div  id="show'.$show_more.'t" style="display: none; ">  ';
    }
}//end class
?>	