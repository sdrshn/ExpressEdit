<?php 
if (!isset($_GET['tbn']))exit('Error!!'); 
$tablename=$_GET['tbn'];
$edit=(isset($_GET['editgen']))?true:false;
include '../includes/path_include.class.php';
new Sys();  
$render_master= new passclass($tablename,$edit);
 

?>
