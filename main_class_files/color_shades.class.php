<?php
#ExpressEdit 2.0
class color_shades{
private static $instance='';

function render_color(){
 
$video=video::instance();
//<html><head><title>Open Color Finder</title></head><body>
echo'

<div class="whitegreen relative" style="width:480px;"> 																	
<h1>To Generate Your  Hex Colors Here:</h1>
<p class="ramana">
1. Click Inside or Drag the 
black 
bar on the &quot;Hue&quot; selector to 
generate the desired base 
color.   <br>
 
 2. Next 
double click inside the 
Brightness/Saturation grid 
to activate the cursor.&nbsp; 
Drag it until the desired 
brightness is achieved.&nbsp;<br>
 

 The &quot;Swatch&quot; 
bar shows you the <b>final</b> 
color result. <br>
 
 3. The hex 
color code is generated at 
the bottom of the grid in 
the &quot;Hex&quot; box.&nbsp; Simply 
copy and paste the 6 digit code into 
the color field for a final submit or find a complementary color from the chart below.   </p> 
';
$video->render_video('color000.swf','',484,1,Cfg_loc::Root_dir.'video/');
 
     echo'
	
<p > 
<br> You May Choose a Color Scheme Below!  <br>
<br> Once you have your hex color value from 
the chart  
copy and paste it (<b>without the #</b>) into the form below the color wheel and choose 
 a matching color 
scheme for your website.<br> Be sure to Paste final hex color in the form field for final submission.
 </p> '; 
$video->render_video('col00000.swf','',484,1,Cfg_loc::Root_dir.'video/');
 echo'<p class="ramana pos larger"> Be sure to Paste final hex color in the form field for final submission.</p>
 Color Tools courtesy of http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0
 </div> 
 ';//</body></html
}

public static function instance(){ if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);//static allows it to create an instance without creating a new object
    if  (empty(self::$instance)) {
	   self::$instance = new color_shades(); 
        } 
    return self::$instance; 
    }
}
?>