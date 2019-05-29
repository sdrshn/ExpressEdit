<?php
#ExpressEdit 2.0
     include('includes/Sys.php');
     $mysqlinst=mysql::instance();
     $mysqlinst->dbconnect('vwpkbpmy_imaginewebsite');
     $gall=array("ALTER TABLE `master_gall_backup` DROP ` master_display `",
     "ALTER TABLE `master_gall_backup` DROP ` gall_glob_title `;",
     "ALTER TABLE `master_gall_backup` CHANGE `bigname` `picname` TINYTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;",
      "ALTER TABLE `master_gall_backup` DROP ` littlename `;",
      "ALTER TABLE `master_gall_backup` DROP ` imagetype `;",
      "ALTER TABLE `master_gall_backup` CHANGE `gall_token` `token` TINYTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;",
      "ALTER TABLE `master_gall_backup` CHANGE `gall_expand` `gall_table` TINYTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;",
      "ALTER TABLE `master_gall_backup` DROP ` text `",
      "ALTER TABLE `master_gall_backup` DROP ` gall_transition`",
      "ALTER TABLE `master_gall_backup` DROP ` gall_expand_option`",
      "ALTER TABLE `master_gall_backup` DROP ` gall_display`",
      "ALTER TABLE `master_gall_backup` CHANGE `time` `gall_time` TINYTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;",
      "ALTER TABLE `master_gall_backup` ADD `gall_update` TINYTEXT NOT NULL AFTER `gall_time`;",
      "ALTER TABLE `master_gall_backup` ADD `master_gall_status` TINYTEXT NOT NULL AFTER `master_gall_ref`;",
      "ALTER TABLE `master_gall_backup` ADD `master_table_ref` TINYTEXT NOT NULL AFTER `master_gall_status`;");
     foreach ($gall as $q){
          echo $q;
         // $mysqlinst->query($q); 
          } 
      $q="update master_gall_status='master_gall' where gall_ref=master_gall_ref";    
      $oldPost_fields='blog_table,blog_table_base,blog_ext,blog_date,blog_tag,blog_border_start,blog_border_stop,blog_string_break,blog_order,blog_type,blog_text,blog_pic_info,blog_vid_info,blog_style,blog_break,blog_float,blog_info,blog_drop_down,blog_token,blog_link,blog_data1,blog_data2,blog_temp,blog_update,blog_time,blog_data3,blog_data4,blog_data5,blog_data6,blog_data7,blog_linkref,time';
         
     $mysqlinst=mysql::instance();
     $mysqlinst->dbconnect('vwpkbpmy_ekarasawebsite_backup');
     $q="select * from master_post";
     $r=$mysqlinst->query($q);
     $collect=array();
     while($rows=$mysqlinst->fetch_assoc($r)){
          $collect[]=$rows;
          }
     $mysqlinst->dbconnect('vwpkbpmy_ekarasawebsite');
     $i=1;
     $post_fields=Cfg::Post_fields;
     $newpost_field_arr=explode(',',$post_fields);
     $post_field_arr_old=explode(',',$oldPost_fields);
    
foreach ($collect as $row){
      $value='';
	foreach ($newpost_field_arr as $field){  
		 $value.="'0',";
		}
     
	$q="insert into master_post  (blog_id,$post_fields,blog_update,blog_time,token) values ($i,$value '".date("dMY-H-i-s")."','".time()."','".mt_rand(1,mt_getrandmax())."')";   
		$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
          $q="update master_post  set ";
          foreach ($post_field_arr_old as $field){ 
               
               if ($field=='blog_data1'){
                    if ($row['blog_type']==='image'||$row['blog_type']==='float_image_right'||$row['blog_type']==='float_image_left'){
                         $q.="blog_pic_info='".$row['blog_data1']."', ";
                         }
                    else 
                         $q.="blog_data1='".$row['blog_data1']."', ";
                    }
               elseif (in_array($field,$newpost_field_arr)){ 
                    $q.="$field='".$row[$field]."', ";
                    }
               }
          $q=" $q token='".mt_rand(1,mt_getrandmax()). "',blog_update='".date("dMY-H-i-s")."',blog_time='".time()."' where  blog_id=$i";
          echo NL. $q. ' is q';
          
         $mysqlinst->query($q);
          $i++;  
          }//end foreach
          
     $q= " INSERT INTO `master_page` (`page_id`, `page_ref`, `page_ref_base`, `page_title`, `page_filename`, `page_width`, `page_pic_quality`, `page_style`, `keywords`, `metadescription`, `page_data1`, `page_data2`, `page_update`, `page_data3`, `page_data4`, `use_tags`, `page_options`, `page_break_points`, `page_dark_editor_value`, `page_light_editor_value`, `page_dark_editor_order`, `page_light_editor_order`, `page_comment_style`, `page_date_style`, `page_comment_date_style`, `page_comment_view_style`, `page_style_day`, `page_style_month`, `page_grp_bor_style`, `page_time`, `token`) VALUES (NULL, 'indexpage', 'indexpage', '', 'HOME', 'index', '1280', '0', ' ', ' ', ' ', 'Home', '', ' ', '', '', '0', '', '1000,768,600', '', ' ', '', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ')";
          
          
          
?>
				 
				 