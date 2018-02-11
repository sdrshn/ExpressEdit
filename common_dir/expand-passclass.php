<?php 
include ("includes/Sys.php");
$expand=expandgallery::instance();
if (!isset($_GET['tbn'],$_GET['gall_ref']))exit('Error Status'); 
$expand->gall_table=$_GET['tbn'];
$expand->gall_ref=$_GET['gall_ref'];
$expand->page_source=true;
$expand->pre_render_data();
?>	   		   