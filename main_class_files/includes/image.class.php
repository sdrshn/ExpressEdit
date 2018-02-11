<?php
class image {
    private $pagetest=false;
 
### Please Note that The following code has been modified by myself 
##Please send adittiional  info  on origins of this script if known
####https://github.com/Nimrod007/PHP_image_resize   

static function hex2rgb($hex,$implode=false) {
    	$hex = str_replace("#", "", $hex);
 
	if(strlen($hex) == 3) {
		$r = hexdec(substr($hex,0,1).substr($hex,0,1));
		$g = hexdec(substr($hex,1,1).substr($hex,1,1));
		$b = hexdec(substr($hex,2,1).substr($hex,2,1));
		}
	else {
		$r = hexdec(substr($hex,0,2));
		$g = hexdec(substr($hex,2,2));
		$b = hexdec(substr($hex,4,2));
	}
	$rgb = array($r, $g, $b);
	if($implode)return implode(",", $rgb); // returns the rgb values separated by commas
	return $rgb; // returns an array with the rgb values
	}

	
	
static function resize_check($picname,$tmaxw,$maxh,$maxplus,$storage_path,$final_path,$blog_id,$image_resize_msg='',$output='file',$watermark=NULL,$quality='95',$watermarkposition='center',$errormsg=true , $imgtype='post'){
    
     

     if (!extension_loaded('gd')) { // it's not loaded
	   if (!function_exists('dl') || !dl('gd.so')){// and we can't load it either
		  $msg='You must enable the GD extension to make use of Image Resizing for Resposive Images. Change your php.ini file or enable in apache options';
		  mail::alert($msg);
		  printer::alert_neg($msg,1.3);
		  return;
		  // no GD available, so deliver the image straight up
		 // trigger_error('You must enable the GD extension to make use of Adaptive Images', E_USER_WARNING);
		//  sendImage($source_file, $browser_cache);
		  }
	   }

	(!empty(Cfg_loc::Root_dir)&&strpos($final_path,Cfg_loc::Root_dir)===false)
	   &&$final_path=Cfg_loc::Root_dir.$final_path;//check used for ajax Response image in editmode
	$final_path=trim($final_path,'/').'/';
	if (!is_file($storage_path.$picname)){
		$msg='Your Width Changes Require Resizing your photo in Post Id'.$blog_id.', However Your  Uploaded Image '.$picname.' used for Resizing the current image display is missing from dir: '.$storage_path.'. You may wish to upload a new image.';
		(Cfg::Development)&&$_SESSION[Cfg::Owner.'update_msg'][]=printer::alert_neg($msg,.8,true);
		return false;//returning with no action just message for missing upload 
		}
	$maxw=$tmaxw;
	list($up_width,$up_height)=process_data::get_size($picname,$storage_path);
	//basing calc on width  conversion
	if ($maxh > $maxplus && $maxh > $maxw) $maxw=$maxh*$up_width/$up_height;
	else if ($maxplus >$maxw && $maxplus > $maxh) $maxw= $maxplus / (1 + $up_height/$up_width);
	if (!is_file($final_path.$picname)){
		if ($maxw > $up_width){
			$msg='<img src="'.$storage_path.$picname.'" class="floatleft" height="50" >This 
		'.$image_resize_msg.' uploaded photo '.$picname.' in Post Id'.$blog_id.' has a limited width and isn&#39;t large enough for the space available. You can replace with a larger image, decrease the available width setting, delete it, leave as is, etc.';
		 (Cfg::Development)&&$_SESSION[Cfg::Owner.'update_msg'][]=printer::alert_neg($msg,.8,true);
			$return=false;
			}
		}
	else {
		list($width,$height)=process_data::get_size($picname,$final_path);
		if ($width > $up_width && $maxw > $width){
			$msg='<img src="'.$final_path.$picname.'" class="floatleft" height="50" >This 
			'.$image_resize_msg.' uploaded photo '.$picname.' in Post Id'.$blog_id.' has a limited width and isn&#39;t large enough for the space available. You can replace with a larger image, decrease the available width setting, delete it, leave as is, etc'; 
			 (Cfg::Development)&&$_SESSION[Cfg::Owner.'update_msg'][]=printer::alert_neg($msg,.8,true);
			return false; //returning no action as uploaded width not big enough to increase size
			}
		
		if ($up_width > $width * 1.01  && $maxw > $up_width*1.03){  
			$msg='<img src="'.$final_path.$picname.'" class="floatleft" height="50" ><p class="pl10 width400max small floatleft">This '.$image_resize_msg.' photo '.$picname.' in Post Id'.$blog_id.' is resized to the full orginal upload width although still not large enough for the full space available. You can replace with a larger image, decrease the available width setting, delete it, leave as is, etc.</p>';
			$return=false; //action continues  pic to be resized but not enough
			}
		elseif ($up_width <= $width * 1.01&&$maxw>$up_width*1.03){ 
			$instruct='<img src="'.$final_path.$picname.'" class="floatleft" height="40" >This '.$image_resize_msg.' Original Uploaded Image '.$picname.' in Post Id'.$blog_id.' is not large enough for the full space available.';
			(Cfg::Development)&&$_SESSION[Cfg::Owner.'update_msg'][]=printer::alert_neu($instruct,.8,true);
			return false;  //no action upload not large enough
			}
		else $return=true;
		}// is file $final_path
		 
    image::image_resize($picname, $tmaxw, $maxh,$maxplus,$storage_path,$final_path,$output,$watermark,$quality,$watermarkposition,$errormsg);
	$instruct='Hit the Browser Refresh Button <img src="../refresh_button.png" alt="refresh button" width="20" height="20"> to Insure All New Image Widths are Updated!!'; 
	$_SESSION[Cfg::Owner.'update_msg'][]=printer::alert_neu($instruct,.8,true);
	return  true;  //image has been resized
	}
	
		
static function image_resize($file,$maxWidth=0,$maxHeight=0,$maxWidHeight=0,$storage_path='',$final_path='',$output='file',	$watermark=NULL, $quality='95',$watermarkposition='center', $errormsg=true,$expand=false,$imageToGif=false){
     $final_path=trim($final_path,'/').'/';
    $path_parts = pathinfo($file);  
    $ext=(array_key_exists('extension',$path_parts))?strtolower($path_parts['extension']):'';
    if (empty($ext)){
	   $msg=('Extension failure in image resize with '.$final_path.'@ '.$file);
	   mail::alert($msg);
	   if (!isset($_SESSION[Cfg::Owner.'temp_msg']))$_SESSION[Cfg::Owner.'temp_msg']=array(); 
	   $_SESSION[Cfg::Owner.'temp_msg'][]=printer::alert_neg($msg,.8,1);//used if needed for display iwth show_more tag
	   return $msg;
	   }
    if($ext==='svg'){
	  $msg='This image is an an svg<br>
	   Try again and Check the box on the uploads page for not resizing this image';
	   return $msg;
	   } 
    else if ($ext=='gif'){ 
	   $animated=check_data::noexpand($storage_path.$file); 
	   if ($animated==1){
		  $msg='This image is an animated gif<br>
		  Try again and Check the box on the uploads page for not resizing this image';
		   $_SESSION[Cfg::Owner.'update_msg'][]=printer::alert_neg($msg,.8,true);
		  return $msg;
		 }
	   }
    //echo NL.'current memory peak used '.memory_get_peak_usage();
    ini_set('memory_limit','400M');
    ini_set('max_execution_time', 300);
    if(Sys::Edit&&Cfg::Development)echo printer::alert_pos("Image Resize in progress: $final_path$file",.8);;
    $maxPlus=0;//using maxwidHeight instead for gallery 
     if (!extension_loaded('gd')) { // it's not loaded
	   if (!function_exists('dl') || !dl('gd.so')){// and we can't load it either
		  $msg='You must enable the GD extension to make use of Image Resizing for Resposive Images. Change your php.ini file or enable in apache options';
		  mail::alert($msg);
		  printer::alert_neg($msg,1.3);
		  return $msg;
		  // no GD available, so deliver the image straight up
		 // trigger_error('You must enable the GD extension to make use of Adaptive Images', E_USER_WARNING);
		//  sendImage($source_file, $browser_cache);
		  }
	   }
   
    (!empty(Cfg_loc::Root_dir)&&strpos($final_path,Cfg_loc::Root_dir)===false)
	   &&$final_path=Cfg_loc::Root_dir.$final_path;//ajax Response image in editmode
    (!empty(Cfg_loc::Root_dir)&&strpos($storage_path,Cfg_loc::Root_dir)===false)
	   &&$final_path=Cfg_loc::Root_dir.$storage_path;//ajax Response image in editmode
    if(!is_file($storage_path.$file)){
	   $msg=$storage_path.$file.' is missing in image.class.php '.__LINE__;
	   mail::alert($msg);
	   return $msg;
	   }
    $init_size=filesize($storage_path.$file);  //will be compared to final size if not smaller by 10 percent deliver back original for whatever directory to go in!  
    $quality=($quality > 1 && $quality < 101)?$quality:95;  
    $color=false;
    $offsetX= $offsetY=0;
   if (!is_dir($final_path)){
	   if (!mkdir($final_path,'0755')){
		  $msg='Image resize of '.$file.' problem using Final file path problem in image resize for: '.$final_path.' in '.__FILE__.' on line '.__LINE__;
		  $_SESSION[Cfg::Owner.'update_msg'][]=printer::alert_neg($msg,.8,true);
		  mail::alert($msg);
		  return $msg;
		  }
	   }
    	if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);	
	  
	$read_file =$storage_path.$file;
	if (!is_file($read_file)){
		  mail::alert('Missing Image file $read_file');
		  return $msg;
		  }
	$size	= GetImageSize($read_file); 
	$mime	= $size['mime']; 
	
	// Make sure that the requested file is actually an image
	if (substr($mime, 0, 6) != 'image/'){ 
	    $msg= 'Error: requested file is not an accepted type: ' ; 
	    mail::error($msg); 
	   $_SESSION[Cfg::Owner.'update_msg'][]=printer::alert_neg($msg,.8,true);
		return $msg;
	    }
	 
    $width	= $size[0];
    $height	= $size[1];
    $total=$width+$height;    
    $maxUpWidHeight=max($width,$height);
    if ($maxWidHeight>10){//resize according to maximum width or height which ever is larger...
		  $ratio = $width / $height;
		  $maxw=($ratio >= 1)?$maxWidHeight:$maxWidHeight*$ratio;
		  
		  $maxh=$maxw/$ratio; 
		  if (($maxw+$maxh)>$total&&$expand){
			 $maxw=$maxw*$total/$maxWidHeight;//limit the size
			 $maxh=$maxh*$total/$maxWidHeight;//limit the size
			 }
		  
		  $tnHeight=round($maxh); 
		  $tnWidth=round($maxw);
		  if (($tnHeight + $tnWidth) > $total+5 ){
			 $maxtn=max($tnHeight,$tnWidth);
			   $exp_msg=($expand)?' An Expanded image is also created when uploading post images and is typically a larger version that appears when the posted photo is clicked. The max width height of your uploaded image is '.$maxUpWidHeight.'px whereas the max width/height of image size called for in the post config is set at: '.$maxWidHeight.'px and will not be expanded further. In your image configuration you can check the no expand option or change the max width height configuration to a lower width to prevent this message</p>' :' Your Uploaded Image: '.$file.' with width @ '.$width.'px was expanded to fill the available width and you may loose image quality.  If this is a problem, reload a larger image for resizing to a better quality or change the configuration size</p>';
		  $msg_admin="<br>final file path: $final_path$file  "; 
			   $msg=printer::alert_neg('<img class="floatleft" src="'.$final_path.$file.'" alt="img resizing" height="50">'.$exp_msg.$msg_admin);
			 ($errormsg)&&$_SESSION[Cfg::Owner.'update_msg'][]=$msg;
			   } 
		  } 
    // If either a max width or max height are not specified, we default to something
    // large so the unspecified dimension isn't a constraint on our resized image.
    // If neither are specified but the color is, we aren't going to be resizing at 
        
    else {  
		if (!$maxWidth && !$maxHeight)  {
			$msg='alert : no height or width or maxWidHeight specified ';
			mail::alert($msg);
			
			 $_SESSION[Cfg::Owner.'update_msg'][]=printer::alert_neg($msg,.8,true);
			 return $msg;
			 }
		
	   else if (!$maxWidth && $maxHeight) {
		  $msg='alert : max height option Not Yet Implemented!! ';
			mail::alert($msg);
			 $_SESSION[Cfg::Owner.'update_msg'][]=printer::alert_neg($msg,.8,true);
			 return $msg;
		  }
		  	 
	   else if ($maxWidth && !$maxHeight) {
		  if ( $maxWidth >  $width +2){ 
			 $exp_msg='Your uploaded  image '.$file.' has been artificially expanded to fill the available width and may loose image quality.
			 If this is unintended reupload a larger image, or decrease the available width, or for background images check the box not to resize when uploading your image. The width of the uploaded image was: '.$width.'  and has been expanded to '.$maxWidth.'px</p>';
	   
			 $msg=printer::alert_neg('<img class="floatleft" src="'.$final_path.$file.'" alt="img resize '.$file.'" height="50">'.$exp_msg,.8,true);
			// ($errormsg)&&$_SESSION[Cfg::Owner.'update_msg'][]=$msg;
			 }
		  $tnWidth=$maxWidth;
		  $tnHeight=$maxWidth*$height/$width;
		  }//maxwidth
	   }//not $maxPlus
	// Determine the quality of the output image 
    // Set up a blank canvas for our resized image (destination)
   
     
    // Set up the appropriate image handling functions based on the original image's mime type
  
   
	   
	switch ($ext){
		case 'gif':   
			// We will be converting GIFs to PNGs to avoid transparency issues when resizing GIFs
			// This is maybe not the ideal solution, but IE6 can suck it
		     $creationFunction	= 'ImageCreateFromGif';
		     $outputFunction		= 'ImageGif';
		     $doSharpen			= false;//gives black mat background
			$quality			= round(10 - ($quality / 10)); // We are converting the GIF to a PNG and PNG needs a compression level of 0 (no compression) through 9
	    
			break;
	    
		case 'png':
		  
			$creationFunction	= 'ImageCreateFromPng';
			$outputFunction		= 'ImagePng';
			$doSharpen			= FALSE;
			$quality			= round(10 - ($quality / 10)); // PNG needs a compression level of 0 (no compression) through 9
		break;
	    
		default:
			$creationFunction	= 'ImageCreateFromJpeg';
			$outputFunction	 	= 'ImageJpeg';
			$doSharpen			= false;
	    
		    
		break;
		}
	if ($imageToGif){ 
		$outputFunction = 'ImageGif';
		$doSharpen = false;//gives black mat background
		$quality = round(10 - ($quality / 10)); // We are converting the GIF to a PNG and PNG needs a compression level of 0 (no compression) through 9
		}
 
    // Read in the original image
      
    $src	= $creationFunction($storage_path . $file);  
    (Sys::Debug)&&printer::alert_neu(memory_get_peak_usage(true) . " ".__LINE__. "");
    $dst	= imagecreatetruecolor($tnWidth, $tnHeight);
    if($ext==='png'){
		  imagealphablending($dst, false);
		  imagesavealpha($dst, true);  
	   }
     
    else if ($ext=='gif'){
	   
		  //from vladislav dot net on manual.php for imagecolortransparent
	   
	   $transparent_index = ImageColorTransparent($src); /* gives the index of current transparent color or -1 */
	   if($transparent_index!=(-1)) $transparent_color = ImageColorsForIndex($src,$transparent_index);
	    
	   
	   /* (the new width $nw and height $nh must be defined before) */
	   if(!empty($transparent_color)) /* simple check to find wether transparent color was set or not */
	   {
		  $transparent_new = ImageColorAllocate( $dst, $transparent_color['red'], $transparent_color['green'], $transparent_color['blue'] );
		  $transparent_new_index = ImageColorTransparent( $dst, $transparent_new );
		  ImageFill( $dst, 0,0, $transparent_new_index ); /*  fill the new image with the transparent color */
		  }
	   }
    else if($ext==='jpg'){
	   ImageInterlace($dst, true);
	   }
   
    ImageCopyResampled($dst, $src, 0, 0, $offsetX, $offsetY, $tnWidth, $tnHeight, $width, $height);
  
	
    if (!empty($watermark)) { if  (Sys::Debug) echo '...made  it to watermark..';
			  
			   
			 
	   $flag=true; 
	    if(is_file($watermark))$wpath=''; 
	   else  if(is_file(Cfg_loc::Root_dir.$watermark))$wpath=Cfg_loc::Root_dir;  
	   else{ 
		
		  $flag=false;
		  $msg='Watermark not found in image class';
		  $msg.=NL."path is $final_path.$watermark";
		  echo "watermark not found";
		  mail::error($msg);
		  if (Sys::Debug) echo $msg;
		  }   
	 
		  if ($flag){
			 $offsetX2	= 0; #we want to resize the watermark and start from lower left corner
			 $offsetY2	= 0;
			 $wsize	= GetImageSize($wpath.$watermark);
			 $waterwidth	= $wsize[0];
			
			$waterfunc= ($wsize['mime']=='image/gif')?'ImageCreateFromGif':(($wsize['mime']=='image/x-png'||$wsize['mime']=='image/png')?'ImageCreateFromPng':'error');
					
			if ($waterfunc=='error'){
				$msg='Use a transparent gif or png   for your watermark instead.<br>';
				 mail::alert($msg);
				printer::alert_neg($msg);
				}
		  
			else {
				if ($tnWidth>$waterwidth){
				    $msg='Caution: Your watermark image is resized to match the width of the parent image. If You wish to have a small watermark image in a much larger image then enlarge the background portion of the watermark image to get the perspective you wish. Using a very large watermark to begin with insures the watermark image quality will not degrade from being enlarged to match the width of the parent image!!!  For a fully transparent watermark effect review the watermark guidelines';  
					   $_SESSION[Cfg::Owner.'update_msg'][]=printer::alert_neg($msg,.8,true);
					   }
				$watermark = $waterfunc($wpath.$watermark);  
				$watermarkWidth =  imagesx($watermark); 
				$watermarkHeight =  imagesy($watermark);
				#lets resize the watermark first!! so it is adjusted to the image...
				 $dst2 = imagecreatetruecolor($tnWidth, $tnWidth*($watermarkHeight/$watermarkWidth));
				
				 #preserve tranparency works for gif or png
				 imagecolortransparent($dst2, imagecolorallocatealpha($dst2, 0, 0, 0, 127));
				 imagealphablending($dst2, false);
				 imagesavealpha($dst2, true);
				//ImagePng($dst2, 'testwatermark.png' , (10 - ($quality / 10))); 
				 
				$src_im=$dst2; 
		
				
				 
				#Here we set width of mark to width of image..
				$finalwatermarkWidth=$tnWidth;
				$finalwatermarkHeight=$finalwatermarkWidth*($watermarkHeight/$watermarkWidth);
				if ($watermarkposition=='top'):
					$startheight= 0;
					 $src_y=0;
				elseif ($watermarkposition=='center'):
					$startheight=($tnHeight-$finalwatermarkHeight)/2; 
					 $src_y=0;
				elseif ($watermarkposition=='bottom'):
					
					$startheight=($tnHeight-$finalwatermarkHeight); 
					 $src_y=0;
				endif;
					
					
				// Resample the original image into the resized canvas we set up earlier
				 ImageCopyResampled($src_im , $watermark, 0, 0, $offsetX2, $offsetY2, $finalwatermarkWidth, $finalwatermarkHeight, $watermarkWidth, $watermarkHeight);
				 
				if (Sys::Debug)echo NL.'watermark file was found in image class';   
				  
				  imagecopy($dst, $src_im, 0, $startheight, 0, $src_y, $finalwatermarkWidth, $finalwatermarkHeight); 
				  imagedestroy($dst2);
				 }
			 }
		 }//end if watermark  
    else if (Sys::Debug)echo '..no watermark...';     
		if ($imageToGif){ $file= str_replace(array("gif", "GIF", "Gif",'jpg','JPG','jpeg','JPEG','png','PNG'), "gif", $file);  }
    
    //$file=($append_size)?pathinfo($file)['filename'].'_'.$tnWidth.'.'.pathinfo($file)['extension']:$file;   
    $file_final=$final_path.$file;   
    
	switch ( strtolower($output) ) {
	   case 'browser': 
		  header("Content-type: $mime");
		  $outputFunction($dst);
		  imagedestroy($dst); 
		  break;
	   case 'file':
		  static $countit=0; $countit++;
		  $outputFunction($dst, $file_final ,$quality);
		  $final_size=filesize($file_final);
		  /*if ($init_size < $final_size&&$width>$tnWidth &&empty($watermark)){//expanded files are not resized by browser so will be limited regardless...
			 //copy($storage_path.$file,$file_final);
			 $msg="large filesize iteration #$countit @ quality:$quality setting";
			 $_SESSION[Cfg::Owner.'update_msg'][]=printer::alert_neg($msg,1.1,true);
			  
			 $quality=$quality *.9;
			 self::image_resize($file,$maxWidth,$maxHeight,$maxWidHeight,$storage_path,$final_path,$output,$watermark, $quality);
			 return;
			 }*/
		  imagedestroy($dst); 
		  return array($tnWidth, $tnHeight, $file);
		  break;
	   case 'return': 
		  ob_start();
		  $outputFunction($dst, null, $quality);//compression set to 0  
		  $data	= ob_get_contents();
		  ob_end_clean();
		  ImageDestroy($dst);
		  return $data;
	   }
    
imagedestroy($dst); 
}//end function resize image 
}//end class	
?>