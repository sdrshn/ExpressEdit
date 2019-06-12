<?php
#ExpressEdit 2.0.1
echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
<meta http-equiv="Cache-control" content="NO-CACHE">
<meta http-equiv="content-type" content="text/html; charset=utf-8">	
<meta name="keywords" content="'.$this->keywords.'">
<meta name="description" content="'. $this->metadescription . '" >
<link rel="shortcut icon" href="'.Cfg_loc::Root_dir.Cfg::Favicon.'">';     
if ($this->edit) 
 {echo '<title>Edit ' .$this->page_title .'</title>';  
 }
else {
 echo'
   <title> '.$this->page_title .'</title>';}
?>