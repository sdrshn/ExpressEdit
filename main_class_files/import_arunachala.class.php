<?php
#ExpressEdit 2.0
class import_arunachala {
     #  <([{\^-=$!|]})?*+.>
     #non greed (.*?)
function __construct(){
     $this->mysqlinst = mysql::instance();
     $this->mysqlinst->dbconnect('arunachala'); 
      
     if (is_file('noDivMatch.txt'))unlink('noDivMatch.txt');
     if (is_file('created.txt'))unlink('created.txt');
     if (is_file('copied.txt'))unlink('copied.txt');
     if (is_file('uncopied.txt'))unlink('uncopied.txt');
     if (is_file('unopened.txt'))unlink('unopened.txt');
     $html_pmatch='/\<div id\="pgData"\>(.*?)\<div class\="clr bkg"/s';
     $key_pmatch='/\<meta name\="keywords"(.*)"\>/';
     $description_pmatch='/\<meta name="description"(.*)"\>/';
     $style_pmatch='/\<style\>(.*?)\<\/style\>/s';
     $script_pmatch='/\<script\>(.*?)\<\/script\>/s'; 
     $title_pmatch='/\<title\>(.*?)\<\/title\>/s'; 
     $dir="htmlFiles/"; 
     $pregmatchhtml='/body/';
     $url_arr=array();
     $file_arr=array();
     if ($directory_handle = opendir($dir)) {
          while (($file_handle = readdir($directory_handle)) !== false) { 
               if (($file_handle == '.') || ($file_handle== '..'))continue;
               $data=file_get_contents($dir.$file_handle);
               if (!preg_match($pregmatchhtml,$data))continue;
               $file_arr[]=$file_handle;
               }
          sort($file_arr);
          $this->file_arr=$file_arr;
          }
     else exit('yo man no open');
     $imax=0;
     
     foreach($file_arr as $file_handle) { 
          echo NL.$imax.' is count';
          $imax++;
          //if ($imax > 4)exit('done');
          if (($file_handle == '.') || ($file_handle== '..'))continue;
          
          $data=file_get_contents($dir.$file_handle);
          if (!preg_match($pregmatchhtml,$data)){
               if (!($fp = fopen('unopened.txt', 'a'))) { 
                    fwrite($fp,  "$file_handle \n");
                    printer::alert_neg('cannot open error log file');
                    fclose($fp);
                    continue;
                    }
               else {
                    fwrite($fp,  "$file_handle \n");
                    fclose($fp);
                    printer::alert_neg('file: '.$dir.$file_handle.' No Body');                 
                    continue;
                    }
                                  
                  
               continue;
               }
           if (preg_match($html_pmatch,$data)){ //may be good
               preg_match($html_pmatch,$data,$matches);
               if (!array_key_exists(1,$matches)){
                    echo NL."No match continue: $file_handle" ;
                    process_data::write_to_file('noDivMatch.txt',"$file_handle no match1 \n",false,false);
                    continue;
                    }
               $divMatch = '<div id="pgData">'.$matches[1];
               $divMatch=self::replaceDiv($divMatch);
               $divMatch=process_data::import_cleanup($divMatch);
               process_data::write_to_file('created.txt',"$file_handle \n",false,false);
               printer::alert_pos('file: '.$file_handle.'   Found');
               }
          else {//not good
                 process_data::write_to_file('noDivMatch.txt',"$file_handle no initial match \n",false,false);
               printer::alert_neg('file: '.$file_handle.'   No Match for init div');
               continue;
              }
          $file_handle=process_data::clean_filename($file_handle,40,'_');
          printer::alert_pos(NL. $file_handle);
          if (preg_match($title_pmatch,$data)){ //may be good
               preg_match($title_pmatch,$data,$matches);
               $title=(array_key_exists(1,$matches))?$matches[1]:'';
               $title=process_data::import_cleanup($title);
               }
          if (preg_match($description_pmatch,$data)){ //may be good
               preg_match($description_pmatch,$data,$matches);
               $description=(array_key_exists(1,$matches))?$matches[1]:'';
               $description=process_data::import_cleanup($description);
               }
          if (preg_match($key_pmatch,$data)){ //may be good
               preg_match($key_pmatch,$data,$matches);
               $key=(array_key_exists(1,$matches))?$matches[1]:'';
               }
          if (preg_match($script_pmatch,$data)){ //may be good
               preg_match_all($script_pmatch,$data,$matches);
               $script='';
               if (isset($matches[1])){
                    foreach ($matches[1] as $match){
                         $script.="\n <script> \n $match</script>";
                         }
               $script=process_data::import_cleanup($script);
                    }
               }
          if (preg_match($style_pmatch,$data)){ //may be good
               preg_match_all($style_pmatch,$data,$matches);
               $style='';
               if (isset($matches[1])){
                    foreach ($matches[1] as $match){
                         $style.="<style>
                         $match
                         </style>";
                         }
                $style=process_data::import_cleanup($style);
                    }
               }
          $this->create_page($file_handle);
          $phead=$script.$style;
           $q="update master_page set page_title='$title',metadescription='$description',page_head='$phead',keywords='$key' where page_ref='$file_handle'";
          $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
          //echo NL.NL.NL.$q;
          file_generate::create_new_page_class($file_handle);
          file_generate::pageEdit_generate($file_handle);
          file_generate::page_generate($file_handle);
          $this->clone_page($file_handle);
          $this->unclone_column($file_handle,$divMatch);
          }//foreach
     }//end construct
function create_page($page_ref){
     $this->mysqlinst->count_field('master_page','page_id','',false, "");
     $id=$this->mysqlinst->field_inc;//reuse deleted values
    $q="insert into master_page (page_id,page_custom_css,page_head,page_ref,page_title,page_filename,page_width,page_pic_quality,page_style,page_options,page_break_points,page_cache,page_light_editor_value,page_dark_editor_value,page_dark_editor_order,page_light_editor_order,page_comment_style,page_date_style,page_comment_view_style,page_comment_date_style,page_style_day,page_style_month,page_grp_bor_style,page_link,keywords,metadescription,page_data1,page_data2,page_data3,page_data4,use_tags,page_hr,page_h1,page_h2,page_h3,page_h4,page_h5,page_h6,page_myclass1,page_myclass2,page_myclass3,page_myclass4,page_myclass5,page_myclass6,page_myclass7,page_myclass8,page_myclass9,page_myclass10,page_myclass11,page_myclass12,page_clipboard,page_update,page_time,token)
    values ($id,'', '', '$page_ref', 'my new page title', '$page_ref', '1005', '0', ',0,0,0,0,0,0,0,0,Lucida Sans Unicode=> Lucida Grande=> sans-serif;,0,0,0,444,0,0,0,0,0,0,ffffff@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat,0,0,0,0@@0@@0@@0@@0@@inset,0,8@@000@@0@@top', 'dark,7B081A,0,ffffff,000000', '950', '100,200,300,400,500,700,900,1100,1300,1700,2100', '', '64C91D,00ffff,00ff00,FFFF00,afeeee,ffe4b5,98fb98,0075a0,ff6600,2B1DC9,ff00ff,800000,816227,266a2e,a9a9a9,bdb76b,8b008b,556b2f,ff8c00,9932cc,8b0000,e9967a,8fbc8f,483d8b,2f4f4f,00ced1,9400d3,ff1493,00bfff,696969,696969,1e90ff,b22222,fffaf0,228b22,ff00ff,dcdcdc,ffdead,fdf5e6,808000,6b8e23,ff4500,da70d6,eee8aa,d87093,ffefd5,ffdab9,cd853f,dda0dd,b0e0e6,bc8f8f,4169e1,8b4513,fa8072,f4a460,2e8b57,C91B45,000000,ffffff,e5d805,c82c1d', '', '', ',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat', ',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat', ',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat', ',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat', ',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat', ',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat', ',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat', '', ' ', ' ', '', '', '', '', '0', ',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat', ',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat', ',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat', ',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat', ',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat', ',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat', ',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat', ',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat', ',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat', ',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat', ',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat', ',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat', ',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat', ',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat', ',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat', ',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat', ',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat', ',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat', ',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat', '', '".date("dMY-H-i-s")."','".time()."','".mt_rand(1,mt_getrandmax())."' )";
    //echo $q;
    $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
    }//end create_page
    
function replaceDiv($divMatch){
     foreach ($this->file_arr as $replace){  
          $search =  str_replace('_','/',$replace) ;
          $search="'/$search/'"; 
          $replace="'/$replace/'";  
          $divMatch2=preg_replace($search,$replace,$divMatch); 
          $divMatch3=str_replace('href="/','href="',$divMatch2); 
          }   
     return $divMatch3;  
     }//end replace textarea....

function clone_page($ref){      
	$this->mysqlinst->count_field('columns','col_id','',false, "");
     $id=$this->mysqlinst->field_inc;//reuse deleted values
     $q="insert into columns  (col_id,col_table_base,col_table,col_num,col_options,col_status,col_grid_clone,col_gridspace_right,col_gridspace_left,col_grid_width,col_tcol_num,col_primary,col_clone_target,col_clone_target_base,col_style,col_temp,col_grp_bor_style,col_comment_style,col_date_style,col_comment_view_style,col_comment_date_style,col_width,col_hr,col_update,col_time,token) values ($id,'$ref', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '0', '0', '0', 'column_choice', '0', '0', '0', '0', '0', '0', '0',  '".date("dMY-H-i-s")."','".time()."','".mt_rand(1,mt_getrandmax())."' )";   $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true); 
$q="update columns set col_table='{$ref}_id$id',col_num=1,col_temp='',col_status='clone',col_clone_target='1',col_clone_target_base='indexpage',col_update='".date("dMY-H-i-s")."',col_time='".time()."',token='".mt_rand(1,mt_getrandmax()). "' where col_id=$id"; 
   $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true); 
     }//end clone page

function unclone_column($ref,$text){
     $this->mysqlinst->count_field('columns','col_id','',false, "");
     $cid=$this->mysqlinst->field_inc;//reuse deleted values
       
     
     $q="insert into columns (col_id,col_table_base,col_table,col_num,col_options,col_status,col_grid_clone,col_gridspace_right,col_gridspace_left,col_grid_width,col_tcol_num,col_primary,col_clone_target,col_clone_target_base,col_style,col_temp,col_grp_bor_style,col_comment_style,col_comment_date_style,col_comment_view_style,col_date_style,col_width,col_hr,col_update,col_time,token) values ($cid,'$ref','{$ref}_post_id$cid',0,'','unclone','','','','','0','0','','','','','','','','','','','','".date("dMY-H-i-s")."','".time()."','".mt_rand(1,mt_getrandmax())."' )";//echo $q;
     $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true); 
     $this->mysqlinst->count_field('master_post','blog_id','',false, "");
     $bid=$this->mysqlinst->field_inc;//reuse deleted values  
      # Note we need to hardwire the post that holds the post pointing to the cloned column we wish to unclone!!  In this case the magic # is 3954
      $pid_clone_unclone=3954;
     $q="insert into master_post (blog_id,blog_clone_table,blog_col,blog_order,blog_type,blog_table,blog_gridspace_right,blog_gridspace_left,blog_grid_width,blog_data1,blog_data2,blog_data3,blog_data4,blog_data5,blog_data6,blog_data7,blog_data8,blog_data9,blog_data10,blog_tiny_data1,blog_tiny_data2,blog_tiny_data3,blog_tiny_data4,blog_tiny_data5,blog_tiny_data6,blog_tiny_data7,blog_tiny_data8,blog_tiny_data9,blog_tiny_data10,blog_grid_clone,blog_style,blog_table_base,blog_text,blog_border_start,blog_border_stop,blog_global_style,blog_date,blog_width,blog_height,blog_alt_rwd,blog_status,blog_unstatus,blog_clone_target,blog_target_table_base,blog_float,blog_unclone,blog_pub,blog_tag,blog_temp,blog_options,blog_update,blog_time,token) values ($bid,'','0','10','nested_column','uncle_{$ref}_id$bid','','','','$cid','','','','','1','','','','','','','','','','','','','','','','','$ref','Nested Column','','','','".date("dMY-H-i-s")."','','','','','unclone','','','center row','$pid_clone_unclone','1','',0,'',  '".date("dMY-H-i-s")."','".time()."','".mt_rand(1,mt_getrandmax())."')";
   $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true); 
//echo $q;
 $this->mysqlinst->count_field('master_post','blog_id','',false, "");
     $bid=$this->mysqlinst->field_inc;//reuse deleted values 
$q="insert into master_post (blog_id,blog_clone_table,blog_col,blog_order,blog_type,blog_table,blog_gridspace_right,blog_gridspace_left,blog_grid_width,blog_data1,blog_data2,blog_data3,blog_data4,blog_data5,blog_data6,blog_data7,blog_data8,blog_data9,blog_data10,blog_tiny_data1,blog_tiny_data2,blog_tiny_data3,blog_tiny_data4,blog_tiny_data5,blog_tiny_data6,blog_tiny_data7,blog_tiny_data8,blog_tiny_data9,blog_tiny_data10,blog_grid_clone,blog_style,blog_table_base,blog_text,blog_border_start,blog_border_stop,blog_global_style,blog_date,blog_width,blog_height,blog_alt_rwd,blog_status,blog_unstatus,blog_clone_target,blog_target_table_base,blog_float,blog_unclone,blog_pub,blog_tag,blog_temp,blog_options,blog_update,blog_time,token) values ($bid,'','$cid','10','text','{$ref}_post_id$cid','','','','','','','','','','','','','','','','','','','','','','','','',',,,,,,,,,,,,left','$ref','$text','','','','1519518568','','','','','','','','center row','','1','',0,'', '".date("dMY-H-i-s")."','".time()."','".mt_rand(1,mt_getrandmax())."')";
 //echo $q;
   $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true); 
 
 }//end unclone_col 

}//end class  
     
?>