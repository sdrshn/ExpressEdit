<?php
 require_once('includes/path_include.class.php');#diffs from path include slightly.
     new Sys();
     echo '
     <!DOCTYPE html>
<html lang="en"> 
     <head><title>Install Express Edit</title>
     </head>
     <body>
     <p style="color:green;font-size:1.2em;">Necessary Files Being Generated.<br> Go to Bottom and check for Success Message and Follow link to  Home Directory Edit Page. <br></p><p style="color:black;font-weight:600;">Upon Successful completion delete/move this install_file_gen.php file to prevent rerun!</p>';
      
     file_generate::config_gen_init();//this is done first in case...  for primordial file generation of config files....   
     file_generate::file_folder_generate(true);
     printer::alert_pos('Returned from file_folder_generate');
     file_generate::editMaster_generate();
     printer::alert_pos('Returned from editMaster_generate');
     file_generate::config_gen_edit();//after file folder gen
     printer::alert_pos('Returned from config_gen_edit'); printer::alert_neu('if installation ends here your not accessing the database with the Cfg.class.php credentials ie passname username databasename that match those here');
     $pagetables=check_data::return_pages(__METHOD__,__LINE__,__FILE__,""); #set to   remove expand,highslide, and data tables
    
     $table_assoc=check_data::dir_to_file(__METHOD__,__LINE__,__FILE__,'',true);
     foreach ($pagetables as $tablename){
          if(!array_key_exists($tablename,$table_assoc))continue;//weed out the kruft!
          $filetablename=$table_assoc[$tablename]; 	  
           echo NL. $filetablename .' creating file for '.$tablename;  
          file_generate::pageEdit_generate($tablename);//to generate editpages table reorder.php 
          printer::alert_pos('Returned from pageEdit_gen');
          file_generate::page_generate($tablename);// this will create gallery master file
          printer::alert_pos('Returned from page_generate');
          file_generate::create_new_page_class($tablename);
          printer::alert_pos('Returned from config_gen_edit');             
          } 
     
     echo printer::alert_pos('Starter Files Generated');
     printer::alert_neu( 'move this file: install_file_gen.php to another location so it cannot be rerun.',1.2);
     echo 'Begin editing Go To <a href="./'.Cfg::PrimeEditDir.'index.php">Edit Home Page</a>';
     printer::pspace(120);
     echo 'EditExpress</body></html>';
          
?>