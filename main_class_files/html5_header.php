<?php
echo <<<eol
 <!DOCTYPE html>
<html lang="en"> 
<head>
<script>
document.cookie='screenW='+screen.width+','+screen.height; 
document.cookie="clientW="+window.innerWidth|| document.documentElement.clientWidth|| document.body.clientWidth+"; path=/";
</script>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
eol;
if (isset($this->meta_data)){
if ($this->meta_data)echo '
<meta name="keywords" content="'.$this->keywords.'">
<meta name="description" content="'. $this->metadescription . '">
';
 
echo '
<link rel="shortcut icon" href="'.Cfg_loc::Root_dir.Cfg::Favicon.'">';  
 if ($this->edit) 
 {echo '<title>Edit ' .$this->page_title .'</title>';  
 }
else {
 echo'
   <title> '.$this->page_title .'</title>';}
 }//isset meta data
?>