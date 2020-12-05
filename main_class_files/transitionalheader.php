<?php
#ExpressEdit 3.01
  echo'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" >	
<meta name="keywords" content="'.$keywords.'" >
<meta name="description" content="'. $metadescription . '" >
<meta http-equiv="X-UA-Compatible" content="ie=Emulateie7" >
 <linkrel="shortcut icon" href="'.Cfg_loc::Root_dir.Cfg::Favicon.'">';    
if (strpos(Sys::Self, 'editpages')) 
 {echo '<title>Edit ' .$page_title .'</title>';
include ('includes/editscripts.php');}
else {
  echo' <title> '.$page_title .'</title>';}
?>
