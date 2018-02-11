<?php
include ('includes/Sys.php'); 
$expand =   expandgallery_loc::instance(); 
if (isset($_GET['pic_order']))$expand->pic_order=$_GET['pic_order'];   
if (isset($_GET['css']))$expand->css=$_GET['css'];
if (isset($_GET['gall_ref']))$expand->gall_ref=$_GET['gall_ref'];
if (isset($_GET['id']))$expand->id=$_GET['id'];
if (isset($_GET['transition']))$expand->transition=$_GET['transition'];
if (isset($_GET['main_menu']))$expand->main_menu=$_GET['main_menu'];
$expand->expand_page=true;
$expand->pre_render_data();
?>