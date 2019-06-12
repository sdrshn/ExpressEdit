<?php
#ExpressEdit 2.0.1
class addgallerypiccore {
function __construct(){ 
     $table_list=check_data::return_all(__METHOD__,__LINE__,__FILE__) ;  
     $tbn=request::check_request_data('tbn');    //printer::horiz_print($table_list);
     $sess_token=request::check_request_data('sess_token');
     $lp=request::check_request_num('largepicplus'); 
     $postreturn=request::check_request_data('postreturn');
     $pgtbn=request::check_request_data('pgtbn'); 
     $gall_ref=request::check_request_data('gall_ref');
     $addimage=request::check_request_data('addimage');
     $thumb_quality=request::check_request_data('thumb_quality');
     $large_quality=request::check_request_data('large_quality');
     $gallerycontentswitch=request::check_request_data('gallerycontentswitch');//switch out photo for master gallery
     $pic_order_switch=request::check_request_data('pic_order_switch'); 
     $largepicplus=(!empty($lp)&&check_data::check_num(5,Cfg::Max_pic_width,$lp,'large plus WIDTH')===true)?round($lp):Cfg::Large_gall_pic_plus; 
     $sp=request::check_request_num('smallpicplus');
     $smallpicplus=(!empty($sp)&&check_data::check_num(5,Cfg::Max_pic_width,$sp,'small plus WIDTH')===true)?round($sp):Cfg::Small_gall_pic_plus; 
     $mtw=request::check_request_num('masterthumbwidth');
     $masterthumbwidth=(check_data::check_num(25,Cfg::Max_pic_width,$mtw,'Gallery content plus WIDTH')===true)?round($mtw):Cfg::Master_gall_pic_width;
     $addtbn=request::check_request_data('addtbn'); //for gallery_content master page
     //these have different purposes before and after submitting 
     $addgall=request::check_request_data('addgall');// for standalone new gallery page....
     $css=Cfg_loc::Root_dir.Cfg::Style_dir.$pgtbn;
     if (!$addtbn){
          if (!empty($tbn)){  
               if (check_data::check_array($tbn,$table_list)){$tablename=$tbn; }#this checks to see if tbn is valid table
                     
               else { 
                    $refer=new redirect;
                    $refer->page_referrer_redirect("!MISSING CORRECT INFORMATION: Go BACK TO THE GALLERY YOU WISH TO ADD PHOTO AND START AGAIN", '', $sess->page_referrer_2,'true'); 
                    }
               }//end if isset($_GET)	   
          else { 
              $refer=new redirect;
              $refer->page_referrer_redirect("!!MISSING ALL INFORMATION: Go BACK TO THE GALLERY YOU WISH TO ADD PHOTO AND START AGAIN!", '',$sess->page_referrer_2,'true'); 
              }
          }
     else $tablename=$pgtbn;
     $load=new fullloader();
     $load->fullpath('html5_header_utility.php');
     echo '<title>Upload Gallery Image</title>';
     echo '
     <script  src="../scripts/jquery.min.js"></script>';  
     $java=new javascript('gen_Proc,edit_Proc','print');
     echo $java->javascript_return; 
     echo '  
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
     .addgallbackto {float:left; margin-left: 50px; max-width:200px; margin-bottom:20px; padding:.5em .9em ;background-color: rgba(255,255,255,0.5);
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
     .indent {padding:20px 40px; text-align:left;}
     .fsminfo   {margin: 4px; padding:4px; border: 4px  double #e5d805 }
     .info {color:#e5d805;}
     .left {text-align:left;}
     .maroon{color:#800000;}
     .fs2maroon{padding: 4px 4px 4px 5px; border: 2px  solid #800000;}  
     .fs2forest{padding: 4px 4px 4px 5px; border: 2px  solid #30720f;} 
     .mback {background:#f8e7e6;}
     .italic{font-style: oblique;}
     .backtoborder{ position:absolute; top: 0px; left: 0px;
      width:100%; height:100%; padding:   .5rem 0 .9rem 0;
      -moz-border-radius:3px; -webkit-border-radius:3px; border-radius:3px;
     -moz-box-shadow: 1px 1px 5px -4px #0a2268;
     -webkit-box-shadow: 1px 1px 5px -4px #0a2268;
     box-shadow: 1px 1px 5px -4px #0a2268; 
               } 
     .shadow{font-weight:200; text-shadow: #f2f0e4 1px 0px 1px} 
     </style>
     </head>
     <body class="editbackground editcolor"> 
     <div class="container">';
     #if either has value of 1 then one is adding a table.. after submitting it merely would hold value of dropdown menu
     $msg=($addtbn==1||$addgall==1)?'Create New Gallery':'You Are Adding A New Image to the Gallery: '.$tablename;
     printer::alert($msg,1.2); 
     $vars=(mail::Defined_vars)?get_defined_vars():'defined vars set off';
     echo '<div class="addgallbackto"><a class="info" href="'.$postreturn.'?#return_'.$gall_ref.'">Back to Gallery</a></div>';
     printer::pclear(80);
     $max_upload = (ini_get('upload_max_filesize')<10000)?(int)(ini_get('upload_max_filesize')):(int)(ini_get('upload_max_filesize')/1000000);
     $max_post = (ini_get('post_max_size')<10000)?(int)(ini_get('post_max_size')):(int)(ini_get('post_max_size')/1000000); 
     $config=(int)Cfg::Pic_upload_max; 
     $maxup=min($max_upload,$max_post,$config); 
     $maxbytes=$maxup*1000000;
	 $instructions=NL.'Only the filetypes '.Cfg::Valid_pic_ext.' will work'.NL.
      'Upload  a large and it will be resized automatically to your configuration settings.  Be Sure to Upload a Photo Large enough for any future Configuration/Resize Changes!! ';
     $instructions=NL."The maximimum image file size is limited to $maxup Mb.".$instructions;
     echo' 
     <form  enctype="multipart/form-data" action="'. $postreturn.'" method="post" onsubmit="return edit_Proc.checkPicFiles(this,'.$maxbytes.',\'fileinput\');">';
     if ($addgall)  {
          $msg='Give a new title to this new gallery slide show:<br>';
          $msg2='After naming the gallery/nav link, now also select your first slide show image:';
          $name='addgall';
          }
     if ($addtbn)  {
          $msg='Give a new Title reference for your new Gallery of Galleries:<br>';
          $msg2='Now also select your new gallery link image:<br>';
          $name='addtbn';
          }
     if ($addgall==1||$addtbn==1){#check if equals to one which means its original:  cause after submitting they will  have values from the dropedown table chose
          #this way the form is ready to add to the newly created gallery only
          echo'<p class="ramana left">'.$msg.'<input type="text" name="newtablename"  size="50" maxlength="50" ></p>';
            $msg='Now also select your new gallery link image<br>this image will also be added to the slideshow as its first image: <br>
          ';
          } 
     else $msg2=$msg='';
     printer::alert($msg.$instructions,1.1);
     printer::pclear(20);
     printer::alertx('<p class="left">'.$msg2.'</p>');
     echo'<p class="left"><input type="hidden" name="MAX_FILE_SIZE" value="'.($maxbytes).'"></p>
     <fieldset><legend class="info left">File must be a .jpg .png  sor .gif</legend>';
    $this->show_more('Upload Filesize Limit: '.$maxup.'Mb','','info pt5 pb5 pl10 floatleft');
     printer::print_wrap('wrap filesize table'); 
		echo '
		Current php.ini limits and User Configurations:
		<table   class="fsminfo editcolor editbackground">
		<tr><th>upload max <br>php.ini</th><th>post_max_size <br>php.ini</th><th>Cfg::Pic_upload_max <br>Cfg_master.class.php or Cfg.class.php</th>
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
          echo '<p class="indent">Upload  a large File and it will be resized automatically to your configuration settings.    <span class="italic">&nbsp;&nbsp;Be Sure to Upload a Photo Large enough for any future Configuration/Resize Changes!!</span></p>
     <p><b>File:</b> <input id="fileinput" style="background:#fff;color: #5b0554;" type="file" name="upload" ></p>
     </fieldset>';
     printer::pclear(15);
          $this->show_more('Add a Watermark','','left info','Use a Watermark Image to be programmatically blended to your Uploaded Image. Watermarks are a means to prevent images from being downloaded and used by others, by merging your image with a transparent  watermark  image.');
          $dir=Cfg_loc::Root_dir.Cfg::Watermark_dir;
          echo '<div class="fsminfo background editcolor"><!--wrapper-->';
          $this->show_more('Use an Default or Custom Uploaded Watermark','','left info','Custom watermarks may first be uploaded using the link below. Read the watermark guide information before creating your watermark image for the best results!!'); 
          echo '
                <div class="fs2forest"><!--wrap choose default/custom watermark-->     
               <p class="left fs2npinfo"><input type="radio" value="none"  name="watermarkinfo[0]" checked="checked">Use No Watermark</p>';
               if ($directory_handle = opendir($dir)) {
                    while (($file = readdir($directory_handle)) !== false) {    
                         if (($dir.$file  == '.') || ($dir.$file == '..'))continue; 
                         if (strpos($dir.strtolower($file),'gif')===false && strpos($dir.strtolower($file),'.png')==false )continue; 
                 
                         echo '<p class="left fs2npinfo"><input type="radio" value="'.$dir.$file.'" name="watermarkinfo[0]"><img src="'.$dir.$file.'" height="100" alt="choose watermark image">'.$file.'</p>';
                         }//while
                    }    
          printer::alertx('<p class="left info" title="
          After resizing to match widths your watermark image height may differ from your image to upload height so you may align the two according to their bottoms, centers, or tops">Choose Watermark Vertical Alignment with Image</p>');
          echo '
         <select class="editcolor editbackground" name="watermarkinfo[1]">       
          <option value="center" selected="selected">Center to Center</option>
          <option value="top">Top to Top</option>
          <option value="bottom" >Bottom to Bottom</option> 
         </select>';
          echo '</div><!--wrap choose default/custom watermark--> '; 
          $this->show_close();//choose custom/default
          printer::pclear(5);
          echo '
               <p class="info left" title="After Uploading Your Custom Watermark Image Navigate back to Continue Your Normal Upload"> Upload Your Own Custom Watermark image
               <a class="deeppurple" href="add_page_pic.php?watermarkadd=1&amp;wwwexpand=0&amp;ttt='.$tablename.'&amp;fff=blog_data1&amp;postreturn='.$postreturn.'&amp;pgtbn='.$tablename.'&amp;bbb=watermark&amp;css='.Cfg_loc::Root_dir.Cfg::Style_dir.$tablename.'"><b>HERE</b></a></p>';
          $this->show_more('Guideline for Creating a Custom Watermark','noback','left maroon shadow','','full');		    
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
          $this->show_close();//watermark info
          printer::pclear(5);
          echo '</div><!--wrapper-->';
          $this->show_close('Watermark Options');//Watermarks option
          printer::pclear(15);
          foreach (array('masterthumbwidth','large_quality','thumb_quality','gall_ref','addimage','tbn','smallpicplus','largepicplus','addtbn','pic_order_switch','gallerycontentswitch') as $pass){ 
               echo '<p><input type="hidden" name="'.$pass.'" value="'.$$pass.'" ></p>
               ';
               }
     echo '	 
     <p><input type="hidden" name="time" value="'. time() .'" ></p>
     <p><input type="hidden" name="sess_token" value="'. $sess_token .'" ></p>
     <p><input class="editbackground editcolor fs3pos rad10" type="submit" name="submit" value="Submit Upload Image" ></p>
     <p><input type="hidden" name="gallpicsubmitted" value="TRUE" ></p>
     </form>
     </div>
     </body>
     </html>';
     }//end construct
     
function show_more($msg_open,$msg_close='close',$class='  left',$tag=''){ if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
     static  $show_more=0; $show_more++; //echo 'show more is '.$this->show_more;
     echo '<p class="'.$class.'" style="display:inline-block; text-decoration:underline; cursor:pointer;" title="'.$tag.'" onclick="gen_Proc.show(\'show'.$show_more.'\',\''.$msg_open.'\',\''.$msg_close.'\');" id="show'.$show_more.'" onmouseover="this.style.cursor=\'pointer\'" >'.$msg_open.'</p>';	 
	printer::spanclear('0');
	echo'<div  id="show'.$show_more.'t" style="display: none; ">  ';
     }
     
function show_close(){
	echo '</div><!--Close Show More-->';
	}     
}//endclass

?>