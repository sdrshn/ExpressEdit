<?php 
     require_once('includes/config_file_gen.php');
     $cfg_included=true;//for prevent includes Cfg in Sys.php
     file_generate::config_gen_init();//this is done first in case...  for primordial file generation of config files....   
     file_generate::file_folder_generate(); 
     file_generate::editMaster_generate();
     file_generate::config_gen_edit();//after file folder gen
     file_generate::class_local_gen();
     $pagetables=check_data::return_pages(__METHOD__,__LINE__,__FILE__,""); #set to   remove expand,highslide, and data tables
     $table_assoc=check_data::dir_to_file(__METHOD__,__LINE__,__FILE__,'',true);
   
     foreach ($pagetables as $tablename){  
          if(!array_key_exists($tablename,$table_assoc))continue;//weed out the kruft!
          $filetablename=$table_assoc[$tablename]; 	  
          //echo NL. $filename .' is filename'; continue;
          file_generate::pageEdit_generate($tablename);//to generate editpages table reorder.php 
          file_generate::page_generate($tablename);// this will create gallery master file
          file_generate::create_new_page_class($tablename);
          } 
     $galltables=check_data::return_gallery_info(__METHOD__,__LINE__,__FILE__); #set to   remove expand,highslide, and data tables
     foreach ($galltables as $array){
          list($gall_ref,$gall_table)=$array;
          file_generate::expand_file($gall_ref,$gall_table);
          }
     echo printer::alert_pos('Starter Files Generated');
     echo 'Begin editing Go To <a href="./'.Cfg::PrimeEditDir.'index.php">Edit Home Page</a>"';
          
?>