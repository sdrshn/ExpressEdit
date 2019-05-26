/*  <?php
#ExpressEdit 2.0
$d=120;
$q="delete from user_data where  timestamp < ".(time()-(($d-1) * 86400))."
?>
*/
	//from image.class.php  resize program  
    
    
    // Clean up the memory
    
    
    
    // See if the browser already has the image
    
    //doConditionalGet($etag, $lastModifiedString);
    
    // Send the image to the browser with some delicious headers
    
    
    
    /*function doConditionalGet($etag, $lastModified)
    {
	    header("Last-Modified: $lastModified");
	    header("ETag: \"{$etag}\"");
		    
	    $if_none_match = isset($_SERVER['HTTP_IF_NONE_MATCH']) ?
		    stripslashes($_SERVER['HTTP_IF_NONE_MATCH']) : 
		    false;
	    
	    $if_modified_since = isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) ?
		    stripslashes($_SERVER['HTTP_IF_MODIFIED_SINCE']) :
		    false;
	    
	    if (!$if_modified_since && !$if_none_match)
		    return;
	    
	    if ($if_none_match && $if_none_match != $etag && $if_none_match != '"' . $etag . '"')
		    return; // etag is there but doesn't match
	    
	    if ($if_modified_since && $if_modified_since != $lastModified)
		    return; // if-modified-since is there but doesn't match
	    
	    // Nothing has changed since their last request - serve a 304 and exit
	    header('HTTP/1.1 304 Not Modified');
	    exit();
    } // doConditionalGet()*/
    
    // old pond
    // a frog jumps
    // the sound of water
    //Just added the $apply_watermark argument to smart_resize():
    
    //function smart_resize_image( $file, $width = 325, $height = 0, $proportional = true, $output = 'browser', $delete_original = false, $use_linux_commands = false, $apply_watermark = true )
    //Then added this if/else construct to replace the imagecopyresampled() function with code that combines the re-sized image with a watermark gif, (could be a png I suppose), if $apply_watermark is true.. Otherwise it functions like normal.
     