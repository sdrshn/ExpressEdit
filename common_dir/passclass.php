<?php 
if (!isset($_GET['tbn']))exit('Error!!'); 
$tablename=$_GET['tbn'];
$edit=(isset($_GET['editgen']))?true:false;
include ('includes/Sys.php');
//$sess=$_SESSION['tkn'];
//if ($_GET['tkn']!==$_SESSION['tkn'])exit($sess.'Are Two Edit Browsers Open? Go Back to Editpages Hit refresh  and try Again!!!');
$render_master= new passclass($tablename,$edit);
?>
