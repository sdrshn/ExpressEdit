<?php
echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">';
if ($this->meta_data)echo '
<meta name="keywords" content="'.$this->keywords.'">
<meta name="description" content="'. $this->metadescription . '">';
echo '
<link rel="shortcut icon" href="'.Cfg_loc::Root_dir.Cfg::Favicon.'">';   
if ($this->edit) 
 {echo '<title>Edit ' .$this->page_title .'</title>';  
 }
else {
 echo'
   <title> '.$this->page_title .'</title>';}
   //<meta http-equiv="X-UA-Compatible" content="ie=Emulateie7" >
   
   // echo'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   // "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
//<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
?>