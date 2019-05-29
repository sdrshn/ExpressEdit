<?php
#ExpressEdit 2.0
class image {
    private $pagetest=false;
    function image_resize ($file,
					   $maxWidth              = 0, 
					   $maxHeight             = 0, 
					   $maxPlus              = 0,
					   $storage_path        ='',
					   $final_path         ='',
					   $output             = 'return', 
					   $watermark          =NULL,
					   $quality              = '95',
					   $cropratio        = NULL, 
					   $color           = NULL,
					   $imageToGif      = false          ) {
					   
					
	if (Sys::Methodcalls) Sys::Debug(__line__,__file__,__method__);							    
    if (Sys::Debug) echo ".........inside image function watermark is $watermark.......";								
    if (!function_exists("findSharp")){	function findSharp($orig, $final) // function from Ryan Rud (http://adryrun.com)
    {
	    $final	= $final * (750.0 / $orig);
	    $a		= 52;
	    $b		= -0.27810650887573124;
	    $c		= .00047337278106508946;
	    
	    $result = $a + $b * $final + $c * $final * $final;
	    
	    return max(round($result), 0);
    } // findSharp()
    }//if not exists
	# Setting defaults and meta
	   $read_file                         =$storage_path.$file;
	    
    $size	= GetImageSize($read_file);
    $mime	= $size['mime'];
    
    // Make sure that the requested file is actually an image
    if (substr($mime, 0, 6) != 'image/'){
	   $msg= 'Error: requested file is not an accepted type: ' ;
	   mail::error($msg);
	    return;
	   }
    
    $width	= $size[0];
    $height	= $size[1];
    
    
     $color		= FALSE;
    
    // If either a max width or max height are not specified, we default to something
    // large so the unspecified dimension isn't a constraint on our resized image.
    // If neither are specified but the color is, we aren't going to be resizing at
    // all, just coloring.
    
    if ($maxPlus>10){//resize according to height plus width total
	    $ratio		= $width / $height;
	    $this->tnHeight=round($maxPlus/(1+$ratio));
	     $this->tnWidth=round($maxPlus-$this->tnHeight);
	  if ($this->pagetest)   echo "$this->tnWidth is width and   $this->tnHeight is height";
        $offsetX	= 0;
	   $offsetY	= 0;
    
    }
    
 else {
	   if (!$maxWidth && $maxHeight)
	   {
		   $maxWidth	= 99999999999999;
	   }
	   elseif ($maxWidth && !$maxHeight)
	   {
		   $maxHeight	= 99999999999999;
	   }
	   elseif ($color && !$maxWidth && !$maxHeight)
	   {
		   $maxWidth	= $width;
		   $maxHeight	= $height;
	   }
	   
	   // If we don't have a max width or max height, OR the image is smaller than both
	   // we do not want to resize it, so we simply output the original image and exit
	   
	   if ((!$maxWidth && !$maxHeight) || (!$color && $maxWidth >= $width && $maxHeight >= $height))
	   {
		   $msg='alert: uploaded file is smaller than final width';
		   mail::alert($msg);
		  }
	   
	   // Ratio cropping
	   $offsetX	= 0;
	   $offsetY	= 0;
	   
	   if (isset($cropratio))
	   {
		   $cropRatio		= explode(':', (string) $cropratio);
		   if (count($cropRatio) == 2)
		   {
			   $ratioComputed		= $width / $height;
			   $cropRatioComputed	= (float) $cropRatio[0] / (float) $cropRatio[1];
			   
			   if ($ratioComputed < $cropRatioComputed)
			   { // Image is too tall so we will crop the top and bottom
				   $origHeight	= $height;
				   $height		= $width / $cropRatioComputed;
				   $offsetY	= ($origHeight - $height) / 2;
			   }
			   else if ($ratioComputed > $cropRatioComputed)
			   { // Image is too wide so we will crop off the left and right sides
				   $origWidth	= $width;
				   $width		= $height * $cropRatioComputed;
				   $offsetX	= ($origWidth - $width) / 2;
			   }
		   }
	   }
	   
	   // Setting up the ratios needed for resizing. We will compare these below to determine how to
	   // resize the image (based on height or based on width)
	   $xRatio		= $maxWidth / $width;
	   $yRatio		= $maxHeight / $height;
	   
	   if ($xRatio * $height < $maxHeight)  //this means that maxwidth is limiting
	   { // Resize the image based on width
		   $this->tnHeight	= ceil($xRatio * $height);
		   $this->tnWidth	= $maxWidth;
	   }
	   else // Resize the image based on height which is limiting or same
	   {
		   $this->tnWidth	= ceil($yRatio * $width);
		   $this->tnHeight	= $maxHeight;
	   }
    
    }//not $maxPlus
    // Determine the quality of the output image
     
    // Set up a blank canvas for our resized image (destination)
    $dst	= imagecreatetruecolor($this->tnWidth, $this->tnHeight);
     
    // Set up the appropriate image handling functions based on the original image's mime type
     
	   switch ($size['mime']){
		  case 'image/gif':   
		    // We will be converting GIFs to PNGs to avoid transparency issues when resizing GIFs
		    // This is maybe not the ideal solution, but IE6 can suck it
		    $creationFunction	= 'ImageCreateFromGif';
		    $outputFunction		= 'ImageGif';
		    //$outputFunction	 = 'ImagePng';
		   //$mime				= 'image/gif'; // We need to convert GIFs to PNGs
		    $doSharpen			= false;//gives black mat background
			$quality			= round(10 - ($quality / 10)); // We are converting the GIF to a PNG and PNG needs a compression level of 0 (no compression) through 9
	    
		   break;
	    
		  case 'image/x-png':
		  case 'image/png':
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
	  if ($imageToGif){ echo 'right on';
		  $outputFunction		= 'ImageGif';
		  $doSharpen			= false;//gives black mat background
		  $quality			= round(10 - ($quality / 10)); // We are converting the GIF to a PNG and PNG needs a compression level of 0 (no compression) through 9
		  }
  
    // Read in the original image
    $src	= $creationFunction($storage_path . $file);
        if (in_array($size['mime'], array('image/gif', 'image/png'))||$imageToGif) 
    {
	    if (!$color)
	    {
		    // If this is a GIF or a PNG, we need to set up transparency
		    imagealphablending($dst, false);
		    imagesavealpha($dst, true);
	    }
	    else
	    {
		    // Fill the background with the specified color for matting purposes
		    if ($color[0] == '#')
			    $color = substr($color, 1);
		    
		    $background	= FALSE;
		    
		    if (strlen($color) == 6)
			    $background	= imagecolorallocate($dst, hexdec($color[0].$color[1]), hexdec($color[2].$color[3]), hexdec($color[4].$color[5]));
		    else if (strlen($color) == 3)
			    $background	= imagecolorallocate($dst, hexdec($color[0].$color[0]), hexdec($color[1].$color[1]), hexdec($color[2].$color[2]));
		    if ($background)
			    imagefill($dst, 0, 0, $background);
	    }
    }
    
    // Resample the original image into the resized canvas we set up earlier
    ImageCopyResampled($dst, $src, 0, 0, $offsetX, $offsetY, $this->tnWidth, $this->tnHeight, $width, $height);
 
    if ($doSharpen) 
    {echo 'made it to sharpen';
	    // Sharpen the image based on two things:
	    //	(1) the difference between the original size and the final size
	    //	(2) the final size
	    $sharpness	= findSharp($width, $this->tnWidth);
	    
	    $sharpenMatrix	= array(
		    array(-1, -2, -1),
		    array(-2, $sharpness + 12, -2),
		    array(-1, -2, -1)
	    );
	    $divisor		= $sharpness;
	    $offset			= 0;
	    imageconvolution($dst, $sharpenMatrix, $divisor, $offset);
    } 
    
    // Make sure the cache exists. If it doesn't, then create it
    //if (!file_exists(CACHE_DIR))
	    //mkdir(CACHE_DIR, 0755);
    
    // Make sure we can read and write the cache directory
    /*if (!is_readable(CACHE_DIR))
    {
	    header('HTTP/1.1 500 Internal Server Error');
	    echo 'Error: the cache directory is not readable';
	    exit();
    }
    else if (!is_writable(CACHE_DIR))
    {
	    header('HTTP/1.1 500 Internal Server Error');f
	    echo 'Error: the cache directory is not writable';
	    exit();
    }
    // Write the resized image to the cache*? */
	
    if (isset($watermark)) { if  (Sys::Debug) echo '...made  it to watermark..';
			 /* 
				 $imagesource = $file_final; 
			 $filetype = substr($imagesource,strlen($imagesource)-4,4); 
			 $filetype = strtolower($filetype); 
			 if($filetype == ".gif")  $image = @imagecreatefromgif($imagesource);  
			 if($filetype == ".jpg")  $image = @imagecreatefromjpeg($imagesource);  
			 if($filetype == ".png")  $image = @imagecreatefrompng($imagesource);  
			 */
	   $flag=true;
	   if(is_file($final_path.$watermark))$wpath=$final_path; 
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
				#resize watermark first
				(substr($watermark,-3)!='png')&&mail::alert('watermark is wrong filetype');
			  
   
			
			 if (Sys::Debug)echo NL.'watermark file was found in image class';   
			 $watermark = imagecreatefrompng($wpath.$watermark); 
			 $watermarkwidth =  imagesx($watermark); 
			 $watermarkheight =  imagesy($watermark);
			 $dst2 	= imagecreatetruecolor($this->tnWidth, $this->tnHeight);
			 $offsetX	= ($watermarkwidth - $this->tnWidth) / 2;  
			 $startheight = (($this->tnHeight  - $watermarkheight));
			   
			 imagecopy($dst, $watermark,  0, $startheight, 0, 0, $watermarkwidth, $watermarkheight); 
			 imagedestroy($watermark);
			 }
		 }//end if watermark  
    else if (Sys::Debug)echo '..no watermark...';     
		if ($imageToGif){ $file= str_replace(array("gif", "GIF", "Gif",'jpg','JPG','jpeg','JPEG','png','PNG'), "gif", $file);  }
    $file_final=$final_path.$file;
    
	switch ( strtolower($output) ) {
	   case 'browser':
	   if (Sys::Debug)echo NL. 'at case browser imgage class';
		  header("Content-type: $mime");
		  $outputFunction($dst);
		  imagedestroy($dst); 
		  break;
	   case 'file':
		  
		  if (Sys::Debug)echo NL.$this->tnWidth, $this->tnHeight, $file.'are the image vars';
		  if (Sys::Debug)echo NL. 'at case file  imgage class';
		  $outputFunction($dst, $file_final ,$quality); 
		  imagedestroy($dst); 
		  return array($this->tnWidth, $this->tnHeight, $file);
		  break;
	   case 'return':
		  if (Sys::Debug)echo NL. 'at case return imgage class';
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