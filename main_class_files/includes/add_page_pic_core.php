<?php # Script 10.3 - upload_image.php
function show_close(){
	echo '</div><!--Close Show More-->';
	}  

function show_more($msg_open,$msg_close='close',$class='ramana left',$tag=''){ if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
 static  $show_more=0; $show_more++; //echo 'show more is '.$this->show_more;
    echo '<p class="'.$class.'" style="display:inline-block; text-decoration:underline; cursor:pointer;" title="'.$tag.'" onclick="gen_Proc.show(\'show'.$show_more.'\',\''.$msg_open.'\',\''.$msg_close.'\');" id="show'.$show_more.'" onmouseover="this.style.cursor=\'pointer\'" >'.$msg_open.'</p>';	 
	printer::spanclear('0');
	echo'<div  id="show'.$show_more.'t" style="display: none; ">  ';
    }
   
$sess_token=request::check_request_data('sess_token');
//$thumb_quality=request::check_request_data('thumb_quality');
//$large_quality=request::check_request_data('large_quality');
$clone_local_style=request::check_request_data('clone_local_style');
$vidname=request::check_request_data('vidname');  
$contact=request::check_request_data('contact');  
$addvid=request::check_request_data('addvid');    
$postreturn=request::check_request_data('postreturn');
$playbuttonadd=request::check_request_data('playbuttonadd');
$watermarkadd=request::check_request_data('watermarkadd');
$wwwexpand=request::check_request_data('wwwexpand');//this is obsolete now
$expandfield=request::check_request_data('expandfield');//data field for image no expand
$quality=request::check_request_data('quality');
if (empty($postreturn)){
		mail::alert('empty postreturn'); 
		$refer=new redirect;
		$refer->page_referrer_redirect("!MISSING POST INFORMATION: TRY AGAIN!", '', $sess->page_referrer_2,'true'); 
		}
$css=request::check_request_data('css');// css provides current styling for the add_page_pic_core.php page
$append=request::check_request_data('append'); 
$table_list=check_data::return_all(__METHOD__,__LINE__,__FILE__,true); 
$id_ref=request::check_request_data('id_ref');
(empty($id_ref))&&$id_ref='';
$id=request::check_request_data('id');
(empty($id))&&$id='';
$image_noresize=request::check_request_num('image_noresize');
$www=request::check_request_num('www'); 
$ttt=request::check_request_data('ttt');
if (!empty($ttt)){  
	   if (in_array($ttt, $table_list)){$tablename=$ttt; }
	   elseif ($www!=12345654321){
		   $refer=new redirect;
		   $refer->page_referrer_redirect("!MISSING TABLE INFORMATION: TRY AGAIN!", '', $sess->page_referrer_2,'true'); 
		   }
	}//end if isset($_GET)
else if(!$watermarkadd){
	$refer=new redirect;
	$refer->page_referrer_redirect("!!MISSING TABLE INFORMATION: TRY AGAIN!!", '',$sess->page_referrer_2,'true'); 
	}
$pgtbn=request::check_request_data('pgtbn'); 
if (!empty($pgtbn)){  
if (in_array($pgtbn, $table_list)){$pgtablename=$pgtbn; }
	else {
		$pgtablename=$ttt;
		}
	}//end if isset($_GET)t=request::check_request_data('tbn');
 else {
	$pgtablename=$ttt;
	}
/*if (!empty($www)){#default width for no image
	$proceed=check_data::check_num(5,Cfg::Max_pic_width,$www,'MAX WIDTH');
	if ($proceed===true){
		$www=round($www);
		}
	else {
	    $refer=new redirect;
	    $refer->page_referrer_redirect($proceed, '',$sess->page_referrer_2,'true');
	    }	
	}//end if  */
 if (empty($www)&&!$watermarkadd&&!$playbuttonadd) {//watermark upload will be full size no so widthspec needed
	$refer=new redirect;
		$refer->page_referrer_redirect("MISSING WIDTH INFORMATION: TRY AGAIN!", '',$sess->page_referrer_2,'true'); 
	}
 
$fff=request::check_request_data('fff');
if (!empty($fff)){
	$g=$fff.'-';//to account for background image instances
	$g=substr($fff,0,strpos($g,'-'));//will take first '-' ie to give background only for blogs?
	if (check_data::check_array($g,Cfg::Page_fields)||check_data::check_array($g,Cfg::Post_fields)||check_data::check_array($g,Cfg::Col_fields)){
		$dbfield=$fff;
		}
	else {
		$refer=new redirect;
		$refer->page_referrer_redirect("MISSING INFORMATION: TRY AGAIN!!!", '',$sess->page_referrer_2,'true');
		}
	}
else {
	$refer=new redirect;
	$refer->page_referrer_redirect("!!MISSING FIELD INFORMATION: TRY AGAIN!!!!" , '', $sess->page_referrer_2,'true');
	}
 $bbb=request::check_request_data('bbb');//back_ground image in styling
 $background=$bbb;  
	 
$prevwid=request::check_request_num('prevpic');
if (!empty($prevwid)){#default width for no image
	if ($prevwid==48.4)	$prevwid='unknown';
		 
     else if (check_data::check_num(5,Cfg::Max_pic_width,$prevwid,'PREV WIDTH'))$prevwid=round($prevwid);
		 
	else $prevwid='unknown';
	}
 
 
//$checkit=explode(',',Cfg::Table_suffix);
$ttt=$tablename;
 //foreach ($checkit as $ext){ 
	// if (strpos($tablename,$ext))$tablename =str_replace($ext,'',$tablename); continue;
	// }
	 
$fff=$dbfield;//also repassed in form fields
$bbb=$background;//also repassed in formfields
if (is_file('../includes/html5_header_utility.php'))	
	include ('../includes/html5_header_utility.php');
else include ('includes/html5_header_utility.php');
echo '<title>Upload Post Image</title>';
$java=new javascript('gen_Proc,checkPicFiles,checkUploadFile','print');
echo $java->javascript_return;
echo'
<link href="'.$css.'.css" rel="stylesheet" type="text/css" > 
<link href="'.$css.'edit.css" rel="stylesheet" type="text/css" ><style type="text/css"> 
.container{margin:70px auto 30px auto;
	max-width:800px;
	padding-top: 10px;
	width: 80%;
	}
.addpicbackto {float:left; margin-left 50px; max-width:200px; margin-bottom:20px; padding:.5em .9em ;background-color: rgba(255,255,255,0.5);
	 font-size: .9rem; font-family: arial,sans-serif;font-weight: 700;
	-moz-box-shadow: 0px 0px 5px 0px #FFC0C7;
	-webkit-box-shadow: 0px 0px 5px 0px #FFC0C7;
	box-shadow: 0px 0px 5px 0px #FFC0C7;
	 -moz-border-radius:3px; -webkit-border-radius:3px; border-radius:3px;
-moz-box-shadow: 1px 1px 5px -4px #0a2268;
-webkit-box-shadow: 1px 1px 5px -4px #0a2268;
	}
form {margin:0 auto; text-align: center; max-width:500px;}
.fs2npinfo {border: 2px  solid #e5d805;} 
.info {color:#e5d805;}
.left {text-align:left;}
.maroon{color:#800000;}
.fs2maroon{padding: 4px 4px 4px 5px; border: 2px  solid #800000;}  
.fs2forest{padding: 4px 4px 4px 5px; border: 2px  solid #30720f;} 
.mback {background:#f8e7e6;}
.italic{font-style: oblique;}
.shadow{font-weight:200; text-shadow: #f2f0e4 1px 0px 1px} 
.addtbn{padding-top:5px;font-variant: small-caps; color:#fff; font-size: 1.2em;}
</style>
</head>
<body class="editbackground editcolor editfont"> 
<div class="container">

 ';
echo '<div class="addpicbackto"><a class="info" href="'.$postreturn.'?#return_'.$id.'">Back to '.substr($pgtbn,0,15).'</a></div>';
printer::pclear(50);
 
//$navobj->tablename=$pgtablename;#//to create return and view web page changes
//$navobj->utility_menu();
$msg=($wwwexpand > $www*1.1)?'Upload a large image file so expanded images may also be used or  in case you should wish to adjust the image size to a larger one in the future without having to reload it!. ':'';
$instructions=($bbb==='background_image_style')?'Currently the filetypes '.str_replace(',','&nbsp;&nbsp;',Cfg::Valid_pic_ext).' are accepted.  Your page post image will be resized automatically<br> 
    ':'Currently the filetypes '.str_replace(',','&nbsp;&nbsp;',Cfg::Valid_pic_ext).' are accepted. <br>' .
 '<br>'.$msg.' Your page post image will be resized automatically to the available width or choose width below<br>';
    
 
 
	$max_upload = (ini_get('upload_max_filesize')<10000)?(int)(ini_get('upload_max_filesize')):(int)(ini_get('upload_max_filesize')/1000000);
	$max_post = (ini_get('post_max_size')<10000)?(int)(ini_get('post_max_size')):(int)(ini_get('post_max_size')/1000000);
	$memory_limit = (int)(ini_get('memory_limit'));
	$config=Cfg::Pic_max/1000000;//see Cfg.class.php 
	$upload_mb = min($max_upload, $max_post, $memory_limit,$config);
	$max=$upload_mb*1000000;
	$bbbwater=($bbb==='watermark'||$bbb==='playbutton')?1:0;
	$instructions=" The maximimum Picture file size is limited to $upload_mb Mb ".$instructions.'';
   
	echo '
<form  enctype="multipart/form-data" action="'.$postreturn.'" method="post" onsubmit="return checkPicFiles(this,'.$bbbwater.','.$max.');">
<p><input class="editbackground editcolor" type="hidden" name="MAX_FILE_SIZE" value="'.$max.'"></p>';

 
	

if ($addvid){
	if (strpos(strtolower($vidname),'.flv')==false&&strpos(strtolower($vidname),'.swf')==false){
	 show_more('Add Play button to image');
	echo '<p class=" fsmnavy" title="For MP4 and MOV type Videos You May Add a Play Button to the Still Image you wish to upload  to indicate its a Play Video LINK. (Note: FLV videos auto add the play button) To add one click the Add a Play Button Link and you may choose the default play button '.Cfg::Vid_button.' or upload your own">Add a MP4 or MOV Play Button</p>';
 
	
		
		$dir=Cfg_loc::Root_dir.Cfg::Playbutton_dir;
		
		
		echo '
	      
		<p class="left fs2npinfo"><input type="radio" value="none"  name="watermarkinfo[0]" checked="checked">Use No Video Play Button</p>';
		 if ($directory_handle = opendir($dir)) {
			while (($file = readdir($directory_handle)) !== false) {    
				if (($dir.$file  == '.') || ($dir.$file == '..'))continue; 
				if (strpos($dir.strtolower($file),'gif')===false && strpos($dir.strtolower($file),'.png')==false )continue; 
		  
			  echo '<p class="left fs2npinfo"><input type="radio" value="'.$dir.$file.'" name="watermarkinfo[0]"><img src="'.$dir.$file.'" height="100" alt="choose watermark image">'.$file.'</p>';
			  }
			} 
		 
		 	printer::alertx('<p class="fsmnavy" title="
			After resizing to match widths your play button image height may differ from your start image for video  upload height so you may align the two according to their bottoms, centers, or tops">Choose Play Button Vertical Alignment with Image</p>');
		
		   echo '
		    <select class="editcolor editbackground" name="watermarkinfo[1]">       
			<option value="center" selected="selected"> Center to Center</option>
			<option value="top">Top to Top</option>
			<option value="bottom" >Bottom to Bottom</option> 
		    </select>';
			
		show_more('Guideline for Creating a Custom Overlay/Watermark Image','noback','left editcolor','','full');		    
	echo '<p class="left fs2maroon maroon mback">Guidelines: <br> <br>
		An Overlay Image differs from a true watermark image in that an overlay image will overlay to 100% opacity in portions thats have less than 100% opacity whereas a transparent watermark image will maintain its partial transparency when mixed with the parent.
		For overlay Images:
		
		 Use a transparency  gif or a png image for your overlay<br><br>
		 png and gif  watermark images will work with jpg, gif and png base images for overlays <br>
		
		For a truly transparent effect a PNG watermark greater than 8bit together with a JPG image does the trick.  Perhaps there are other possibilities?? <br><br> 
		
		To work properly the watermark/Overlay image should be larger than your uploaded base image<br>
		Uploading a 1000px or larger watermark image  insures the watermark image quality will not degrade from being enlarged to match the width of the parent image!!!<br><br>
		
		In other words, the watermark will be scaled to width with your base image, so keep this in mind when you determine the proper image to background  perspective.<br>
		   <br></p>';
		show_close();//watermark info
		show_close();
		} //if strpos
	
	}//if addvid
else if($watermarkadd){  
	printer::alert('UPLOAD YOUR CUSTOM WATERMARK IMAGE, THEN NAVIGATE BACK TO YOUR POST IMAGE TO UPLOAD THE NEW ONE AND SELECT YOUR NEW CUSTOM WATERMARK. WATERMARKS IMAGES ARE PNG OR PNG TYPES ONLY. VIEW THE WATERMARK GUIDELINES BELOW',false,'fsmnmaroon maroon');
	 }
else if($playbuttonadd){  
	printer::alert('UPLOAD YOUR CUSTOM PLAY BUTTON IMAGE, THEN NAVIGATE BACK TO UPLOAD YOUR START IMAGE FOR VIDEO',false,'fsmmaroon');
	 }
else {
	
	$imagerepeatinfo=($bbb==='background_image_style')?'Small Background Images may be repeated to fill background. Check here to upload the Actual width of Repeated Images':'Or check here to use the Actual Width of the image';
	 echo '<input type="hidden" name="www" value="'.$www.'">';
	
	printer::spanclear(5);
	// printer::alert($instructions,false,'fsmnavy' );
	 printer::spanclear(5);
	}
	printer::pclear(10);
	 echo'<p><input type="hidden" name="MAX_FILE_SIZE" value="'.$max.'"></p>
<fieldset class="editcolor"><legend class="info">File must be a '.Cfg::Valid_pic_ext.'</legend>';
show_more('Upload Filesize Limit: '.$upload_mb.'Mb','','info pt5 pb5 pl10 floatleft');
	
	echo '
	Current php.ini limits and User Cfg.class.php setting:

	<table border="1"  class="fsminfo editcolor editbackground">
	<tr><th>upload_max_filesize</th><th>post_max_size</th><th>memory_limit</th><th>Cfg::Pic_max</th>
	</tr>
	<tr>
	<td>'.$max_upload.'Mb</td><td>'.$max_post.'Mb</td><td>'.$memory_limit.'Mb</td><td>'.$config.'Mb</td>
	</tr> 
     <th><b>Upload filesize limit:</b></th>
     <tr><td><b>'.$upload_mb.'Mb</b></td></tr>
	</table>';
	show_close();
	printer::pclear(3);
echo '<p class="indent">Upload  a large File and it will be resized automatically to your width settings.  <span class="italic">&nbsp;&nbsp;Be Sure to Upload a Photo Large enough for any future Configuration/Resize Changes!!</span> <br><br>
</p>

<p><b>File:</b>   <input style="background:#fff;color: #5b0554;" type="file" name="upload" ></p> ';
(!empty($vidname))&&print '<p class="ramana"><br>UPLOAD YOUR STILL IMAGE FOR VIDEO</p>';
if (!$watermarkadd&&!$playbuttonadd&&strpos(strtolower($vidname),'.flv')!==false)echo '<p class="ramana">FLV FILES WILL AUTOMATICALLY ADD A PLAY BUTTON TO YOUR STILL IMAGE</p>';
echo '</fieldset>';
printer::pclear(5);
echo '<p><input class="mb50 fs3pos editcolor editbackground rad10" type="submit" name="submit" value="Submit All" ></p>';
printer::print_wrap('resizing');
if ($bbb==='background_image_style')printer::printx('<p class="info smaller" title="Do Not Resize is particularly suited when repeating images (tiling) or for images intended to be larger or smaller than available background width"><input type="checkbox" name="no_image_resize" value="1">&nbsp;&nbsp;Do Not Resize Background Image</p>');
else {
	printer::print_tip('Resizing Highly Recommended on large images for Cache Generation for optimum speed of your webpage loading',.7);
	if ($image_noresize)printer::print_info('Your Previous Image Did not allow resizing. To disable resizing on new image  check box');
	printer::printx('<p class="info smallest" title="Do Not Resize Animated Gifs, SVG images. "><input type="checkbox" name="no_image_resize" value="1">&nbsp;&nbsp;Do Not Resize Image<br>(Use for animated Gifs Svgs)</p>');
	
	}

printer::close_print_wrap('resizing');	
printer::pclear(10);
	show_more('Add an Overlay/Watermark Image','','left info','Use a Watermark Image to be programmatically blended to your Uploaded Image. Watermarks are a means to prevent images from being downloaded and used by others, by merging your image with a transparent  watermark  image.');
	$dir=Cfg_loc::Root_dir.Cfg::Watermark_dir;
	
	echo '<div class="editbackground editcolor fsminfo"><!--wrapper-->';
	show_more('Use an Default or Custom Uploaded Watermark','','left info','Custom watermarks may first be uploaded using the link below. Read the watermark guide information before creating your watermark image for the best results!!'); 
	echo '
	      <div class="fs2forest"><!--wrap choose default/custom watermark-->  
		<p class="left fs2npinfo"><input type="radio" value="none"  name="watermarkinfo[0]" checked="checked">Use No Watermark</p>';
		 if ($directory_handle = opendir($dir)) {
			while (($file = readdir($directory_handle)) !== false) {    
				if (($dir.$file  == '.') || ($dir.$file == '..'))continue; 
				if (strpos($dir.strtolower($file),'gif')===false && strpos($dir.strtolower($file),'.png')==false )continue; 
		  
			  echo '<p class="left fs2npinfo"><input type="radio" value="'.$dir.$file.'" name="watermarkinfo[0]"><img src="'.$dir.$file.'" height="100" alt="choose watermark image">'.$file.'</p>';
			  }
			} 
	  	printer::alertx('<p class="left info" title="
		After resizing to match widths your watermark image height may differ from your image to upload height so you may align the two according to their bottoms, centers, or tops">Choose Watermark Vertical Alignment with Image</p>');
	
	   echo '
	    <select class="editcolor editbackground" name="watermarkinfo[1]">       
		<option value="center" selected="selected">Center to Center</option>
		<option value="top">Top to Top</option>
		<option value="bottom" >Bottom to Bottom</option> 
	    </select>';
	     echo '<p class="fsmnavy left" title="If checked Post Images will not be given the Watermark but the Expanded Images Will. (Expanded Versions of Post Images appear when Post Images are Clicked.)"><input type="checkbox" name="watermark_large_image" value="1" >Watermark Expanded Images Only</p>';
	echo '</div><!--wrap choose default/custom watermark--> '; 
	 show_close();//choose custom/default
	
	printer::pclear(5); 
	 echo '
		 
		<p class="info left" title="After Uploading Your Custom Overlay/Watermark Image You Must Navigate back to Continue Your Normal Upload"> Upload Your Own Custom Watermark image
		<a class="darkpurple" href="add_page_pic.php?watermarkadd=1&amp;wwwexpand=0&amp;ttt='.$ttt.'&amp;fff=blog_data1&amp;postreturn='.$postreturn.'&amp;pgtbn='.$pgtbn.'&amp;bbb=watermark&amp;css='.$css.'"><b>HERE</b></a></p>';
	show_more('Guideline for Creating a Custom Overlay/Watermark Image','','left maroon shadow');
	
	echo '<p class="left fs2maroon maroon mback">Guidelines: <br> <br>
		An Overlay Image differs from a true watermark image in that an overlay image will overlay to 100% opacity in portions thats have less than 100% opacity whereas a transparent watermark image will maintain its partial transparency when mixed with the parent.
		For overlay Images:
		
		 Use a transparency  gif or a png image for your overlay<br><br>
		 png and gif  watermark images will work with jpg, gif and png base images for overlays <br>
		
		For a truly transparent effect a PNG watermark greater than 8bit together with a JPG image does the trick.  Perhaps there are other possibilities?? <br><br> 
		
		To work properly the watermark/Overlay image should be larger than your uploaded base image<br>
		Uploading a 1000px or larger watermark image  insures the watermark image quality will not degrade from being enlarged to match the width of the parent image!!!<br><br>
		
		In other words, the watermark will be scaled to width with your base image, so keep this in mind when you determine the proper image to background  perspective.<br>
		   <br></p>';
	show_close();//watermark info
	
	printer::pclear(5); 
	echo '</div><!--wrapper-->';
	show_close();//Watermarks option 
	printer::pclear(15);
foreach (array('image_noresize','www','clone_local_style','expandfield','quality','append','wwwexpand','playbuttonadd','watermarkadd','addvid','contact','pgtbn','ttt','id_ref','id','fff','bbb') as $pass){
	echo '<p><input type="hidden" name="'.$pass.'" value="'.$$pass.'" ></p>
	';
	}
 
echo '
<p><input type="hidden" name="sess_token" value="'. $sess_token .'" ></p>
<p><input class="mb50 fs3pos editcolor editbackground rad10" type="submit" name="submit" value="Submit All" ></p>
<p><input type="hidden" name="pagepicsubmitted" value="TRUE" ></p>
</form>
</div>
</body>
</html>';
?>