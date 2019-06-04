<?php
#ExpressEdit 2.0
// Image Fit Text Class 0.1 by ming0070913
CLASS ImageFitText{
	
	// Position of the text and the box
	
// If the script cannot fit the text for certain wrap length, it will try the wrap length again with the reduction in this value.
// It reduce the accuracy, but will slightly speed up the process.
	protected $step_wrap = 1;
	// If the script cannot fit the text for certain font size, it will try the the font size again with the reduction in this value.
	// It reduce the accuracy, but will slightly speed up the process.
	protected $step_fontsize = 1;
 
function create_image($font_color, $background_color, $text, $fontsize=18, $output_file='', $width3='',$height3='', $output_dir=Sys::Gall_pic_path2, $output='file', $font='HelveticaNeue-Roman.otf',$min_fontsize=14,$font_constant=2.1 ){
	$font=Cfg_loc::Root_dir.$font;
	(empty($output_file))&&$output_file='x.gif';
	$printout=   
	'font color: '.$font_color .NL.
	'background color: '.$background_color .NL.
	'text: '.$text. NL.
	'font size: '.$fontsize.NL.
	'output file: '.$output_file.NL.
	'width: '. $width3.NL.
	'height: '.$height3.NL.
	'out directory: '.$output_dir.NL.
	'output type (file): '.$output.NL.
	'font used: '.$font.NL.
	'minimum font size: '.$min_fontsize.NL.
	'font constant: '.$font_constant.NL;
	
	 $this->font =Cfg_loc::Root_dir.'fonts/'. $font;
	  $x1 = 30;//adds to overall
	  $x2= 15;//
	  $y1 = 10;
	  $y2=20;//
	 $min_wraplength = 0;// The minimun wrap length for each line. The script will try another font size if it cannot fit the text even with this wrap length.
	 $padding = 5;//The space between the box and the text. It's independent to the script which can be ignored
// The maximun width
	$strlen=strlen($text);
	 switch (true) {
		 
		case $strlen<300:
			$width=250;
			break;
		case $strlen<450:
			$width=350;
			break;
		case $strlen<600:
			$width=450;
			break;
		case $strlen<850:
			$width=550;
			break;
		default:
			$width=650;
		}//end switch
	  $text_arr = explode("\n", $text);
	  $strmax=0;
	  
	//$strlen is total lengh of text
	//$linechars is the number of characters that are going to be on a line on average
	// this will give an approximate overall height calculation
	$linechars=$strlen * $fontsize / $width/$font_constant;  //modification
	$height=$linechars *$fontsize*2.1;//modiciation
	$printout.=NL. "#1 width is $width and height is $height";
	//*****here we begin an alternative method for when the text is preformatted**************
	foreach ($text_arr as $line){
		$strlen=strlen($line);
		($strlen > $strmax)&&$strmax=$strlen;
		}
	 
	$width2=$strmax*$fontsize/$font_constant;
	$height2=count($text_arr)*$fontsize*2.1;
		$printout.=NL."width2 is $width2 and height2 is $height2 and strlen max is $strmax";
	if ($width >$width2){
		$width=$width2;
		$height=$height2;
		}
	$width=$width+$x1*2;
	$height=$height+$y1;
	$width=(empty($width3))?$width:$width3;
	$height=(empty($height3))?$height:$height3;	   
	$printout.=NL."final width is $width and hight is $height";
	 
	// Create a image
	$im = @imagecreatetruecolor($width, $height) or die('Cannot Initialize new GD image stream');
	
	// set background to white
	$color=image::hex2rgb($background_color);
	$backcolor = imagecolorallocate($im, $color[0],$color[1],$color[2]);
	imagefill($im, 0, 0, $backcolor);
	// Start the timer
	//$time_start = microtime_float();
	// The class
	 // Fit the text
	// It returns the result in a array with "fontsize", "text", "width", "height"
	$fit = $this->fit($width-$padding*2, $height-$padding*2, $text, $fontsize, $min_fontsize, $min_wraplength);
	// Stop the timer
	//$time = round(microtime_float()-$time_start, 3);
	$color=image::hex2rgb($font_color);
	$textcolor = imagecolorallocate($im, $color[0],$color[1],$color[2]); 
	// Draw a box
	//imagerectangle($im, $x1, $y1, $x1+$width, $y1+$height, $white);
	// Write the text                                                +8 because the text will move up originally
	imagettftext($im, $fit['fontsize'], 0, $x2, $y2+$padding+8, $textcolor, $font, $fit['text']);
	 if ($output=='file'){
	ImageGif($im,$output_dir.$output_file,.05);//output the file to specified directory..
	return $printout;
	// Print some info. about the text
	//imagestring($im, 5, $x1, $y1+$height+30,  'Fontsize  : '.$fit['fontsize'], $white);
	//imagestring($im, 5, $x1, $y1+$height+45,  'Text Size : '.$fit['width']."x".$fit['height'], $white);
	//imagestring($im, 5, $x1, $y1+$height+60,  'Box Size  : '.($width-$padding*2)."x".($height-$padding*2), $white);
	//imagestring($im, 5, $x1, $y1+$height+75,  'Time used : '.$time.'s', $white);
	// echo ' Fontsize  : '.$fit['fontsize'];
	
	 //echo "$linechars is linechars and strlen is $strlen"; 
	// Print the image
	}
	else {
		header ('Content-Type: image/png');
		imagegif($im);
		}
	imagedestroy($im);
	}
function microtime_float(){	// Timer
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}
	
	
 
	 
	
function fit($width, $height, $text, $fontsize, $min_fontsize=5, $min_wraplength=0){
	$this->fontsize = & $fontsize;
	$text_ = $text;
	
	while($this->TextHeight($text_)>$height && $fontsize>$min_fontsize)
		$fontsize -= $this->step_fontsize;
	
	while(($this->TextWidth($text_)>$width || $this->TextHeight($text_)>$height) && $fontsize>$min_fontsize){
		$fontsize -= $this->step_fontsize;
		$wraplength = $this->maxLen($text);
		$text_ = $text;
		
		while($this->TextWidth($text_)>$width && $wraplength>=$min_wraplength+$this->step_wrap){
			$wraplength -= $this->step_wrap;
			$text_ = wordwrap($text, $wraplength, "\n", true);
			
			//To speed up:
			if($this->TextHeight($text_)>$height) break;
			if($wraplength<=$min_wraplength) break;
			$wraplength_ = $wraplength;
			$wraplength = ceil($wraplength/($this->TextWidth($text_)/$width));
			$wraplength = $wraplength<($min_wraplength+$this->step_wrap)?($min_wraplength+$this->step_wrap):$wraplength;
			}
		}
	
		$this->width = $this->TextWidth($text_);
		 $this->height = $this->TextHeight($text_);
	
		return array("fontsize"=>$fontsize, "text"=>$text_, "width"=>$this->width, "height"=>$this->height);
		}

function maxLen($text){
	$lines = explode("\n", str_replace("\r", "", $text));
	foreach($lines as $line)
		$t[] = strlen($line);
	return max($t);
	}

function TextWidth($text){
	$t = imagettfbbox($this->fontsize, 0, $this->font, $text);
	return $t[2]-$t[0];
	}

function TextHeight($text){  
	$t = imagettfbbox($this->fontsize, 0, $this->font, $text);
	return $t[1]-$t[7];
	}
}
?>