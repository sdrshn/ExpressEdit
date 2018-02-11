<?php # Script 10.3 - upload_image.php
if (Sys::Web)set_time_limit(200);
ini_set('memory_limit','300M'); 
#notes: used ini_set(and didn't work);  
$succmsg='';
$succmsg2='';
$width=0;
$height=0;
$table_list=check_data::get_tables();
$t=request::check_request_data('tbn');
if (!empty($t)){  
 if (check_data::check_array($t, $table_list)=='true'){$tablename=$t; }
    else {
	   $refer=new redirect;
	   $refer->page_referrer_redirect("!MISSING INFORMATION: TRY AGAIN!", '', $sess->page_referrer_2,'true'); 
	   }
    }//end if isset($_GET)
else {
    $refer=new redirect;
    $refer->page_referrer_redirect("!!MISSING INFORMATION: TRY AGAIN!!", '',$sess->page_referrer_2,'true'); 
    }
$storeinst=store::instance();
($storeinst->get('tablename')===false)&&$storeinst->put('tablename',$tablename);//store tablename so any script can access it!

$mysqlinst->dbconnect(Sys::Dbname);	
// Check if the form has been submitted:
$checkheight=false;
$checkwidth=false;
if (isset($_POST['submitted'])){  
	#if (!$sess->session_check){mail::error('session check problem');}
	if  (isset($_POST['width']) && isset($_POST['height']) && is_numeric($_POST['width']) && is_numeric($_POST['height'])){
		$width = $_POST['width'];
		$height  = $_POST['height'];  
		}//end isset width 
	 
	if  (Sys::Debug) Sys::debug(__line__,__method__,__file__);
	    //include ('includes/uploadthis.php');//this file does the upload work to upload directory returns validation
	if  (Sys::Testsite){//if testsite
	    $max=Cfg::Vid_test_max/1000000;
	    $instructions='Maximum filesize has been exceeded.';
	    $instructions.=' For this demo, max video size is '."$max".'Mb';
	    $instructions.= 'Currently the filetypes '.Cfg::Valid_pic_ext.' will work.  Let me know if you would like another';
	    }
	else {
	    $max=Cfg::Vid_max/1000000;
		$instructions="Maxium filesize of  $max Mb has been exceeded.";
		$instructions.= 'Currently the filetypes '.Cfg::Valid_pic_ext.' will work.  Let me know if you would like another';
	    }
	list($uploadverification,$fiupl)=upload::upload_file(Cfg::Valid_vid_mime,Cfg::Valid_vid_ext,$instructions);
	if ($uploadverification='true'){if(!copy(Sys::Uploads_path.$fiupl,Cfg_loc::Root_dir.Cfg::Vid_dir.$fiupl))mail::error('failure to copy video in add pge video core');#this places in folder video  no image resizing done straitforward deal
		if (strpos($fiupl,'zip'))exit('zip file delivered');
		if(!copy(Sys::Uploads_path.$fiupl,Cfg_loc::Root_dir.Cfg::Vid_dir.$fiupl))mail::error('failure to copy video in add pge video core');#this places in folder video  no image resizing done straitforward deal
		list($width,$height)=process_data::process_vid_size($fiupl,$width,$height);#this will check width with predefined defaults
		if (defined('Cfg::Foreign_array')&&Cfg_loc::Domain_extension==''){
		    $add_db_array=explode(',',Cfg::Foreign_array); 
		    $add_db_array[]=Sys::Dbname;
		    }
		else{
		    $add_db_array=array();
		    $add_db_array[]=Sys::Dbname;
		    }
		foreach ($add_db_array as $dbvar){
			$mysqlinst->count_field($tablename,'pic_order',$dbvar);//get pic order placement 
			$q="INSERT INTO $tablename (pic_order, bigname, littlename, imagetitle,imagetype, description, subtitle, width, height, temp_pic_order, reset_id) VALUES
			('$mysqlinst->pic_ord', '$fiupl', '$fiupl', 'No Title','vid', NULL, '".Cfg::Subtitle."','$width', '$height', 0, '$mysqlinst->pic_ord')";
			$mysqlinst->build_update($dbvar, $q);//  insert into database for each db
			if (Sys::Debug){echo "add db array is ";  print_r ($add_db_array);}
			}
		if  (Sys::Debug) print_r($message);
	    #success has happened
	   #unset($_SESSION['redirect']); #this was created to prevent recurring redirect
	   $backupinst->render_backup($tablename);
	   $pageurl=($tablename=='indexpage')?'index.php':$tablename.'reorder.php';
	   $pageref=($tablename=='indexpage')?'Home Page':$tablename;
	   $msg = "The Video $fiupl has successfully been sent to gallery: $pageref Please double check";
	   $success[]=$msg;
	   $succmsg=printer::alert_pos($msg,1.3,true);
	   $msg='You may go to the editgallery page '.$pageref.'<a class="ramana" href="'.$pageurl.'">  here </a>';
	   $succmsg2.=printer::alert_pos($msg,1.1,true); 
	   }// end of upload verification
    } // End of the submitted conditional.
include ('includes/strictheader.nometa.php');
$java=new javascript('plus,Checkvidfiles','print');
echo $java->javascript_return;
echo'
<link href="'.Cfg_loc::Root_dir.'addeditmaster.css" rel="stylesheet" type="text/css" /> 
</head>
<body '.Cfg::Onload.'><div class="topline">&nbsp;</div>
<div class="container">';
printer::alert_conf('You Are Adding A New Video to the Gallery: '.$tablename,'000',1.5);
echo'<div class="spacer"></div>';		
$vars=(Cfg::Defined_vars)?get_defined_vars():'defined vars set off';
$mailinst->mailwebmaster($success, $message, $vars);	
//<div id="containerleft">
//<p><a href="../'.$tablename.'.php" >View Web Page changes</a> </p><br/>
//</div>
$navobj->tablename=$tablename;
echo $succmsg;#first give this message...about success   nave render will give view webpages here
$navobj->render_edit();
echo $succmsg2;
$instructions=NL.'Only the filetypes '.Cfg::Valid_vid_ext.' will work'; 
$instructions.=NL.'You can click on the link below the video in the edit gallery and upload a preview photo';
    
if  (Sys::Testsite){//if testsite
    $max_file_size=Cfg::Vid_test_max;
    $max=$max_file_size/1000000;
    $instructions=NL."For this demonstration site the maximimum video file size is limited to $max Mb.".$instructions;
    }
else {
    $max_file_size=	Cfg::Vid_max;
    $max=$max_file_size/1000000;
   $instructions=NL."The maximimum video file size is limited to $max Mb.".$instructions;
    }
if (!isset($_POST['submitted'])){
	$msg=$instructions.NL.'Rename file to descriptive name before uploading!';
	printer::alert($msg);} 
echo'
<form style="width: 600px; margin:0 auto; text-align:center" enctype="multipart/form-data" action="'. Sys::Self.'" method="post"  onsubmit="return Checkvidfiles(this);">
<p><input type="hidden" name="MAX_FILE_SIZE" value="'.$max_file_size.'"/></p>
<fieldset><legend> Choose your video to UPload!!</legend>
<p><b>File:</b> <input class="upload" type="file" name="upload"/></p>
</fieldset>';

$global_master=new global_master('return');
$global_master->plus('to Edit Display Video');
echo'<p class="ramana">Default Values used for the videos  palyer are:<br/>
  Flash .flv  <br/>
  width='.Cfg::Width_flv.'<br/>
				 height='.Cfg::Height_flv.'<br/><br/>
				 
	Quicktime .mov<br/> width='.Cfg::Width_mov.'<br/>
				 height='.Cfg::Height_mov.'<br/><br/>
				 
		Windows Media Player .wmv <br/>
				 width='.Cfg::Width_wmv.'<br/>
				 height='.Cfg::Height_wmv.'<br/><br/>
	and  can be adjusted later on the edit page	</p>	 
<p class="ramana">Change default video width  <input type="text" name="width"  id="width"  size="6" maxlength="5" /></p>
<p class="ramana">Change default video height   <input type="text" name="height"  id="height"  size="6" maxlength="5" /></p>
</div>
</fieldset><p><input type="hidden" name="height" value="'.$height.'" /></p>
<p><input type="hidden" name="width" value="'. $width .'" /></p>
<p><input type="hidden" name="tbn" value="'.$tablename.'" /></p>
<p><input type="hidden" name="token" value="'. $sess->token .'" /></p>
<p><input type="submit" name="submit" value="Submit" /></p>
<p><input type="hidden" name="submitted" value="TRUE" /></p>
</form>
</div>
</body>
</html>';
?>	