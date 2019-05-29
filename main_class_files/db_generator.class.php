<?php
#ExpressEdit 2.0
class db_generator {
//update person set person.school = 'Harvard3' where person.id in (select t.id from (select *, @num:= if(@type = number, @num + 1, 1) as num, @type := number as Dummy from person order by it desc) as t where t.number = '223' and num = '3')
//db_generator::dbase_pass('clean_rows','','blog');

static function add_field_update($db='vwpkbpmy_expresswebsite'){ return; 
     $db='vwpkbpmy_imaginewebsite';
     $table='columns';
     $table='master_page';
	$mysqlinst=mysql::instance();  
	$mysqlinst->dbconnect($db);
     $fields=Cfg::Col_fields;
     $fields=Cfg::Page_fields;
     $field_arr=explode(',',$fields);
     foreach($field_arr as $field){
          $q="SHOW COLUMNS FROM $table LIKE '$field'";
          $r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
          if ($mysqlinst->num_rows($r)>0){
               printer::alert_pos($field.' exists and rows '.$mysqlinst->num_rows($r));
               }
          else {
               $type=(strpos($field,'tiny')!==false)?'tinytext':'TEXT';
               $q="ALTER TABLE $table ADD $field $type NOT NULL AFTER `token`;";
               $mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
               printer::alert_neg('adding : '.$field.' using '.$q);
               
               }
          }
     exit();
     }
     
     
     
 static function  run_db_table(){  #run localhost/run_db_table.php 
	self::alter_table('vwpkbpmy_ekarasawebsite'); 
	self::alter_table('vwpkbpmy_expresswebsite');
	self::alter_table('vwpkbpmy_imaginewebsite');
	self::alter_table('vwpkbpmy_bmtwebsite');exit();
	
	 
	 
	
	self::populate_table('vwpkbpmy_karmawebsite');
	self::populate_table('vwpkbpmy_imaginewebsite');
	self::populate_table('vwpkbpmy_florencewebsite');exit();
	self::populate_table('vwpkbpmy_ekarasawebsite'); 
	self::create_my_table('vwpkbpmy_ekarasawebsite'); 
	self::create_my_table('vwpkbpmy_karmawebsite'); 
	self::create_my_table('vwpkbpmy_imaginewebsite'); 
	self::create_my_table('vwpkbpmy_florencewebsite'); exit();
	 
	 
	self::move_post_images('vwpkbpmy_imaginewebsite','imagine/','imagine/page_images/','imagine/page_images_expanded/'); 
	self::move_post_images('vwpkbpmy_florencewebsite','florence/','florence/page_images/','florence/page_images_expanded/'); 
	self::move_post_images('vwpkbpmy_karmawebsite','karma/','karma/page_images/','karma/page_images_expanded/'); 
	self::move_post_images('vwpkbpmy_ekarasawebsite','','page_images/','page_images_expanded/'); exit();
	
	
	 exit();
	 
	self::move_post_images('vwpkbpmy_imaginewebsite','/var/www/imagine/','/var/www/imagine/page_images/','/var/www/imagine/page_images_expanded/'); 
	self::move_post_images('vwpkbpmy_florencewebsite','/var/www/florence/','/var/www/florence/page_images/','/var/www/florence/page_images_expanded/'); 
	
	self::move_post_images('vwpkbpmy_karmawebsite','/var/www/karma/','/var/www/karma/page_images/','/var/www/karma/page_images_expanded/'); 
	self::move_post_images('vwpkbpmy_ekarasawebsite','/var/www/','/var/www/page_images/','/var/www/page_images_expanded/'); exit();
	
	self::master_gall_gen('vwpkbpmy_karmawebsite',''); exit();
	self::master_gall_gen('vwpkbpmy_florencewebsite','');
	self::master_gall_gen('vwpkbpmy_imaginewebsite','');
	self::master_gall_gen('vwpkbpmy_ekarasawebsite','');
	 
	//  self::dbase_pass('auxillary','','passthru');exit();
	  self::dbase_pass('change_field_values','','passthru');exit();  
	 // self::dbase_pass('alter_table','','passthru');exit(); 
	//self::master_gall_gen('vwpkbpmy_ekarasawebsite','');exit();
	 self::get_tables('master_gall_gen','vwpkbpmy_karmawebsite','gallery');
	 self::get_tables('master_gall_gen','vwpkbpmy_florencewebsite','gallery');
	 self::get_tables('master_gall_gen','vwpkbpmy_imaginewebsite','gallery');exit('done');
	  $mysqlinst=mysql::instance();  
	 $mysqlinst->dbconnect($db);
	$q="update vwpkbpmy_ekarasawebiste.master_gall set gall_display='expandgallery' where master_gall_ref!='self' and gall_ref='indexpage_thumbs'; ";
	 
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);exit();
	 self::get_tables('master_blog_gen','vwpkbpmy_karmawebsite','blog');
	 self::get_tables('master_blog_gen','vwpkbpmy_florencewebsite','blog');
	 self::get_tables('master_blog_gen','vwpkbpmy_imaginewebsite','blog');
	 self::get_tables('master_blog_gen','vwpkbpmy_ekarasawebsite','blog');
	 self::get_tables('master_data_gen','vwpkbpmy_karmawebsite','data'); 
	self::get_tables('master_data_gen','vwpkbpmy_florencewebsite','data');
	 self::get_tables('master_data_gen','vwpkbpmy_imaginewebsite','data');
	 self::get_tables('master_data_gen','vwpkbpmy_ekarasawebsite','data');exit('done');
	exit('done');
	
	
	self::dbase_pass('master_blog_gen','', 'blog');  
	 exit();
	$db='vwpkbpmy_karmawebsite';
	$tablename='events';
    self::add_dbfield_style($db,$tablename);
	$tablename='events_blog1';
	self::add_blog_style($db,$tablename);
	}#end function
static function dbase_pass($function, $dblist='',$tabletype='all'){
	
	$dbs=(empty($dblist))?Cfg_master::Dbase_update:$dblist;
	$arr=(is_array($dbs))?$dbs:explode(',',$dbs);
	foreach ($arr as $db){ 
		(empty($dblist)) &&
		 $db=Cfg_master::Dbn_prefix.$db;
		// echo 'db is '.$db;
		if ($tabletype==='passthru')
		       self::$function($db);
		else
		 self::get_tables($function, $db,$tabletype);
		} 
	}
		
static function get_tables($function, $db,$tabletype){ 
	 $mysqlinst=mysql::instance();  
	 $mysqlinst->dbconnect($db);
	    switch ($tabletype) {
		  case 'all':
			   $table_array=check_data::return_all(__METHOD__,__LINE__,__FILE__,true,'',false,$db); 
			   break;
		  case 'blog':
			 // $table_array=check_data::return_data_tables('blog_type',false,false,$db); echo 'past table array call';
			   $table_array=check_data::return_posts(__METHOD__,__LINE__,__FILE__,'where blog_order=10','',false,$db); echo 'past table array call';
			   break;
		  case 'data':
			 $table_array=check_data::return_pages(__METHOD__,__LINE__,__FILE__,'','',false,$db); echo 'past table array call';
			  
			  // $table_array=check_data::return_data_tables('keywords',false,false,$db);
			   break;
		  case 'gallery': 
			   $table_array=check_data::return_galleries(__METHOD__,__LINE__,__FILE__) ;//'where pic_order=1','',false,$db);
			   break;
		  }//end switch  
	     //echo NL. print_r($table_array);echo NL.NL;
	   foreach ($table_array as $tablename){ 
		 //echo NL.NL.NL.$tablename.' is tablename';
		  self::$function($db,$tablename);
		  }		
	 }//end get tables

	

	
static function populate_table($db){
	
	$mysqlinst=mysql::instance();  
	 $mysqlinst->dbconnect($db);
	$q="select blog_params1,blog_params2,blog_params3,blog_params4,blog_params5,blog_params6,page_ref from master_page where page_ref_ext=''";
	 $r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	 while(list($p1,$p2,$p3,$p4,$p5,$p6,$ref)=$mysqlinst->fetch_row($r)){
		for ($i=1;$i <7; $i++){
			if(!empty(${'p'.$i})){
				$q="insert into post_params (pp_table,pp_num,time,pp_params)
					values ('$ref',$i,'".time()."','".${'p'.$i}."')";
				$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
				}
			}
		}
	}

	 
static function update_table($db){echo 'here';
	
	$mysqlinst=mysql::instance();  
	$mysqlinst->dbconnect($db);  
	$q="show tables";
	$r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	while(list($table)=$mysqlinst->fetch_row($r,__LINE__)){
    $q="ALTER TABLE $table  CONVERT TO CHARACTER SET  utf8 COLLATE utf8_general_ci ";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	}
 
echo "The collation of your database has been successfully changed!";
return;

$res->free();
$conn1->close();
	//$q="update master_post set blog_float='center row' where blog_float='' OR blog_float='break' or blog_float='0' or blog_float='none'";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	$q="update master_post set blog_float='left float' where blog_float='float' OR blog_float='left'";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	$q="update master_post set blog_float='right float' where blog_float='right'"; 
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true); 
	return;
	$q="select pp_params,pp_id from post_params";
	$r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	while(list($ppp,$pp_id)=$mysqlinst->fetch_row($r,__LINE__)){
		$width=explode(',',$ppp)[0];
		$q="update post_params set pp_width='$ppp' where pp_id='$pp_id'";
		$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
		}
	return;
	$columns='blog_master_style,blog_master_style1,blog_master_style2,blog_master_style3,blog_master_style4,blog_master_style5,blog_master_style6,blog_params1,blog_params2,blog_params3,blog_params4,blog_params5,blog_params6,header1,header2,header3,header4,header5,header6,header7,header8,header9,header10,text1,text2,text3,text4,text5,text6,text7,text8,text9,text10,text11,text12,text13,text14,text15,text16,text17,text18,text19,text20,footer,color_edit,color_bot,background_inner,background,use_background_inner,master_font,background_image_inner,background_image,pic1,pic2,pic3,pic4,pic5,h1,h2,h3,h4,data1,data2,data3,data4,data5,data6,data7,data8,data9,data10,data11,data12,data13,data14,data15,data16,data17,data18,data19,data20,data21,data22,data23,data24,data25,data26,data27,data28,data29,data30,nav1,nav2,nav3,nav4,nav5,nav6,nav7,nav8,nav9,nav10,nav11,nav12,nav13,nav14,nav15,nav16,nav17,nav18,nav19,nav20,nav21,nav22,nav23,nav24,nav25,styletitle,stylenav,stylesidenav,styleheader1,styleheader2,styleheader3,styleheader4,styleheader5,styleheader6,styleheader7,styleheader8,styleheader9,styleheader10,styletext1,styletext2,styletext3,styletext4,styletext5,styletext6,styletext7,styletext8,styletext9,styletext10,styletext11,styletext12,styletext13,styletext14,styletext15,styletext16,styletext17,styletext18,styletext19,styletext20,stylefooter,stylepic1,stylepic2,stylepic3,stylepic4,stylepic5,styleh1,styleh2,styleh3,styleh4,style1,style2,style3,style4,style5,style6,style7,style8,style9,style10,style11,style12,style13,style14,style15,style16,style17,style18,style19,style20,style21,style22,style23,style24,style25,style26,style27,style28,style29,style30,style31,style32,style33,style34,style35,style36,style37,style38,style39,style40,style41,style42,style43,style44,style45,style46,style47,style48,style49,style50, data30,data31,data32,data33,data34,data35,data36,data37,data38,data39,data40,data41,data42,data43,data44,data45,data46,data47,data48,data49,data50,nav17,nav18,nav19,nav20,nav21,nav22,nav23,nav24,nav25';
  
	//$columns=array('pp_template','pp_template_num','pp_template','pp_template_base','pp_sublevel1_num','pp_sublevel2_num','pp_sublevel3_num','pp_sublevel4_num','pp_sublevel5_num','pp_sublevel6_num');
	self::procedure_drop_column('master_page',$columns,$db);
	 
	return;  
	$q="update master_page set page_style=background,token_store='.rand(1,10000000).'";
	$r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); return;
	$relationship=array();
	$q="select dir_filename,dir_ref,dir_title from directory";
	$r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	while(list($fn,$ref,$title)=$mysqlinst->fetch_row($r,__LINE__)){
		$relationship[$ref]=array($fn,$title);
		}
	printer::vert_print($relationship);
	$q="select page_ref_base,page_title from master_page";  echo $q;
	$r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	while(list($ref,$title)=$mysqlinst->fetch_row($r,__LINE__)){ echo NL. 'entry';
		 if (array_key_exists($ref,$relationship)){
			$dir_filename=$relationship[$ref][0];  echo NL.' dir fle is '.$dir_filename;
			}
		else {
			echo $ref. ' ref key not found';
			continue;
			}
		$dir_title=$relationship[$ref][1];  echo NL. ' dir title is '.$dir_title;
		$title=(empty($title))?", page_title='$dir_title'":'';   echo " title is $title"; 
		 $q2="update master_page set page_filename='$dir_filename',token_store=".rand(1,10000000000)."$title where page_ref_base='$ref'"; echo NL.$q2;
		 $mysqlinst->query($q2,__METHOD__,__LINE__,__FILE__,false);echo NL. 'am here once';
		}
		 
	return;
	switch ($db){
	case 'vwpkbpmy_ekarasawebsite':
	$subdir='';
	break;
	case'vwpkbpmy_karmawebsite':
	$subdir='karma/';
	break;
	case 'vwpkbpmy_florencewebsite':
	$subdir='florence/';
	break;
	case 'vwpkbpmy_imaginewebsite';
	$subdir='imagine/';
	break;
	default:
	echo '<p style="color:red; font-size:4em">switch error add new db for '.$db.'</p>';
	}
	$mysqlinst=mysql::instance();  
	$mysqlinst->dbconnect($db);
	###
	$q="select blog_id,blog_type, blog_pic_info, blog_style,blog_width,blog_table,blog_order from master_post"; echo $q;
	$r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	while(list($blog_id,$blog_type,$blog_pic_info,$blog_style,$blog_width,$blog_table,$blog_order)=$mysqlinst->fetch_row($r,__LINE__)){
		echo "blogid is blogid#$blog_id";
		if (empty($blog_width)&&$blog_width < 5){echo  '<p style="color:orange;  font-size:2em;">Checking out id#'.$blog_id.' in '.$db.'</p>';
			if ($blog_type=='image'){ 
				list($picname,$alt)=process_data::process_pic($blog_pic_info);  echo " pic name is $picname and dir is ".Sys::Home_pub.$subdir.Cfg::Page_images_dir.$picname;
				list($width,$height)=process_data::get_size($picname,Sys::Home_pub.$subdir.Cfg::Page_images_dir); echo $width. ' is width';
				if (!empty($width)&&$width>5){
					//shut down blog width for images $q1="update master_post  set token='".process_data::create_password()."',blog_width=$width where blog_id=$blog_id";  echo NL.$q1;
					//$mysqlinst->query($q1,__METHOD__,__LINE__,__FILE__,true);
					echo '<p style="color:green;font-size:2em">Ok so far on Image??  for blog table '.$blog_table.' Post#'.$blog_order.'</p>';
					}
				else echo '<p style="color:red;  font-size:2em;">Width information in post image is missing for blog table '.$blog_table.' Post#'.$blog_order.'</p>';
				}
			elseif($blog_type=='nested_column') 
				echo '<p style="color:green;font-size:2em">this is nested column for blog table '.$blog_table.' Post#'.$blog_order.'</p>';
			else {
				$style=explode(',',$blog_style);
				$indexes=explode(',',Cfg::Style_functions);
				foreach($indexes as $key =>$index){
					if (!empty($index)) {
						${$index.'_index'}=$key;
						}
					}   
				$width=$style[$width_index];
				if (!empty($width)&&$width>5){
					$q1="update master_post  set token='.process_data::create_password().',blog_width=$width where blog_id=$blog_id"; echo NL.$q1;
					$mysqlinst->query($q1,__METHOD__,__LINE__,__FILE__,true);
					echo '<p style="color:green;font-size:2em">Ok so far on Style?? for blog table '.$blog_table.' Post#'.$blog_order.'</p>';
					}
				else echo '<p style="color:red;  font-size:2em;">Width information in post Style is missing for blog table '.$blog_table.' Post#'.$blog_order.' and blog type is :'.$blog_type.'</p>';
			
				}
			
			}
		else echo  '<p style="color:purple;  font-size:2em;">Width already Set in id#'.$blog_id.' in '.$db.'</p>';
		}//end while
	return;
	$q="UPDATE `master_post` SET  blog_width='' WHERE blog_width='none'";
	$q=" UPDATE directory   set dir_menu_type='' where directory_menu_type=NULL";
	$q=" UPDATE directory   set dir_menu_id=1";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	$q=" UPDATE directory   set dir_menu_style='nav_vert' where dir_menu_style='nav1_vert';";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	$q=" UPDATE directory   set dir_menu_style='nav_horiz' where dir_menu_style='nav1_horiz';";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	$q=" UPDATE directory   set dir_menu_style='side_nav' where dir_menu_style='nav_vert';";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	$q=" UPDATE directory   set dir_menu_style='dropdown' where dir_menu_style='nav_horiz';";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	return;
	$q=" UPDATE master_gall   set gall_transition='ajax_fade'";
	//$q="update post_params set pp_table_base=pp_table";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	return;
	$q="select pp_id,pp_table, pp_num from post_params";
	$r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	return;
	while(list($id,$table,$ext)=$mysqlinst->fetch_row($r,__LINE__)){
		$q="update post_params set pp_table='$table".'_blog'.$ext."' where pp_id=$id";
		$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
		}
	return;
	$r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	while(list($id,$base,$ext)=$mysqlinst->fetch_row($r,__LINE__)){
		$q="update master_post set blog_table_base='indexpage_blog',  blog_table='indexpage_blog$ext' where blog_id=$id";
		$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
		}
	}
	
	
static function alter_table($db){
	$mysqlinst=mysql::instance();  
	$mysqlinst->dbconnect($db);
     $q="ALTER TABLE `master_post_data` ADD `blog_height` TINYTEXT NOT NULL AFTER `blog_width`;";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); 
$q="ALTER TABLE `master_post_data` ADD `blog_alt_rwd` TINYTEXT NOT NULL AFTER `blog_height`;";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); 
$q="ALTER TABLE master_post_data DROP COLUMN blog_grid_class;";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); 

$q="ALTER TABLE master_post_css DROP COLUMN blog_grid_class;";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
     exit;
     
     
     
     $q="ALTER TABLE `master_page` ADD `page_link_hover` TEXT NOT NULL AFTER `page_link`;";
     
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); 
$q="ALTER TABLE `master_page` CHANGE `page_link` `page_link` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;";
     
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); 
$q="ALTER TABLE `master_page` CHANGE `page_data1` `page_data1` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, CHANGE `page_data2` `page_data2` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, CHANGE `page_data3` `page_data3` TEXT CHARACTER SET utf8 COLLATE utf8_bin NOT NULL, CHANGE `page_data4` `page_data4` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;";

	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); 
$q="ALTER TABLE `master_page` ADD `page_data5` TEXT NOT NULL AFTER `page_data4`, ADD `page_data6` TEXT NOT NULL AFTER `page_data5`, ADD `page_data7` TEXT NOT NULL AFTER `page_data6`, ADD `page_data8` TEXT NOT NULL AFTER `page_data7`, ADD `page_data9` TEXT NOT NULL AFTER `page_data8`, ADD `page_data10` TEXT NOT NULL AFTER `page_data9`;";

	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); 

$q="ALTER TABLE `master_page` ADD `page_tiny_data1` TINYTEXT NOT NULL AFTER `page_myclass12`, ADD `page_tiny_data2` TINYTEXT NOT NULL AFTER `page_tiny_data1`, ADD `page_tiny_data3` TINYTEXT NOT NULL AFTER `page_tiny_data2`, ADD `page_tiny_data4` TINYTEXT NOT NULL AFTER `page_tiny_data3`, ADD `page_tiny_data5` TINYTEXT NOT NULL AFTER `page_tiny_data4`, ADD `page_tiny_data6` TINYTEXT NOT NULL AFTER `page_tiny_data5`, ADD `page_tiny_data7` TINYTEXT NOT NULL AFTER `page_tiny_data6`, ADD `page_tiny_data8` TINYTEXT NOT NULL AFTER `page_tiny_data7`, ADD `page_tiny_data9` TINYTEXT NOT NULL AFTER `page_tiny_data8`, ADD `page_tiny_data10` TINYTEXT NOT NULL AFTER `page_tiny_data9`;";

	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); 
     
     
     return;
	$q="ALTER TABLE  `post_params` ADD  `pp_width` MEDIUMINT NOT NULL AFTER  `pp_parent_table_base` ;";
	$q="ALTER TABLE  `master_post_css` ADD  `css_type` TINYTEXT NOT NULL ;";
	$q="ALTER TABLE  `directory` CHANGE  `dir_temp`  `dir_temp` TINYTEXT NOT NULL ;";
	$q="ALTER TABLE  `directory` ADD  `dir_time` TINYTEXT NOT NULL ;";
	$q="ALTER TABLE  `directory` CHANGE  `id`  `dir_id` SMALLINT( 3 ) UNSIGNED NOT NULL AUTO_INCREMENT ;";
	$q="ALTER TABLE  `master_post_css` ADD  `css_table_base` TINYTEXT NOT NULL ;";
	$q="ALTER TABLE `master_post` CHANGE `blog_unclone` `blog_unclone` TINYTEXT NOT NULL;";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);  
	$q="ALTER TABLE  `post_params` ADD  `pp_time` TINYTEXT NOT NULL ;";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);  
	$q="ALTER TABLE  `master_post` CHANGE  `blog_width`  `blog_width` TINYTEXT NOT NULL ;";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);  
	$q="ALTER TABLE `master_post`  ADD `blog_unstatus` TINYTEXT NOT NULL AFTER `blog_status`;";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);  
	$q="ALTER TABLE `master_post`  ADD `blog_unclone` TINYTEXT NOT NULL;";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);  
	 $q="ALTER TABLE `master_post`  ADD `blog_parent_table_base` TINYTEXT NOT NULL AFTER `blog_parent`;";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);  
	$q="ALTER TABLE `post_params` CHANGE `pp_grp_bor_style` `pp_grp_bor_style` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);  
	$q="ALTER TABLE `post_params` CHANGE `pp_col_style` `pp_col_style` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); 
	$q="ALTER TABLE `post_params` CHANGE `pp_num` `pp_num` TINYINT(4) NOT NULL;";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);  
	$q="ALTER TABLE `master_post`  modify `blog_data1` TINYTEXT NOT NULL AFTER `blog_type`;";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);  
	$q="ALTER TABLE `post_params`  ADD `pp_parent_table_base` TINYTEXT CHARACTER SET utf8 COLLATE utf8_bin NOT NULL AFTER `pp_float`;";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); 
	$q="ALTER TABLE `master_post`  ADD `blog_status` TINYTEXT CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,  ADD `blog_fol_style` BOOLEAN NOT NULL,  ADD `blog_fol_data` BOOLEAN NOT NULL,  ADD `blog_parent` TINYTEXT NOT NULL;";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); return;
	$q="ALTER TABLE `post_params` DROP `pp_template_base`;"; 
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); 
	$q="ALTER TABLE `post_params` DROP `pp_template_num`";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);  
	$q="ALTER TABLE `post_params` DROP `pp_template`";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); return;
	$q="ALTER TABLE `post_params`  ADD `pp_parent` TINYTEXT NOT NULL AFTER `pp_num`;";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);  
	$q="ALTER TABLE `post_params`  modify `pp_status` TINYTEXT NOT NULL AFTER `pp_parent`;";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); return;
	$q="ALTER TABLE `master_post` CHANGE `blog_data3` `blog_data3` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);  return;
	$q="ALTER TABLE `master_page`  ADD `page_style` TINYTEXT NOT NULL AFTER `page_filename`;";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);  
	$q="ALTER TABLE `master_page`  ADD `page_width` TINYTEXT NOT NULL AFTER `page_style`;";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);  return;
	$q="ALTER TABLE `master_page`  ADD `page_filename` TINYTEXT NOT NULL AFTER `page_title`;";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);  
	$q="ALTER TABLE  `master_page` ADD  `page_title` TINYTEXT NOT NULL AFTER  `page_ref_ext` ;";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);  return;
	$q="ALTER TABLE  `post_params` ADD  `pp_float` TINYINT NOT NULL AFTER  `pp_grp_bor_style` ;";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); 
	$q="ALTER TABLE  `post_params` ADD  `pp_net_width` SMALLINT NOT NULL ;";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);return;
	$q="ALTER TABLE `master_post` CHANGE `blog_style` `blog_style` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_general_ci   NOT NULL";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);return;
	$q="ALTER TABLE `master_post`  ADD `blog_width` SMALLINT NOT NULL;";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);return;
	$q="ALTER TABLE `post_params`  ADD `pp_grp_bor_style` TINYTEXT NOT NULL;";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	return;
	$q="ALTER TABLE `post_params` ADD `pp_col_style`   TINYTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); 
	
	$q="ALTER TABLE `post_params`  ADD `pp_primary` boolean NOT NULL AFTER `pp_num`";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); 
	$q="ALTER TABLE `directory`  ADD `dir_internal` tinytext NOT NULL AFTER `dir_external`";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);  
	$q="ALTER TABLE `post_params`  ADD `pp_tcol_num` DECIMAL(5,1) NOT NULL AFTER `pp_num`";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);  
	$q="ALTER TABLE `master_post`  ADD `blog_float_next` TINYTEXT NOT NULL AFTER `blog_float`";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);  
	$q="ALTER TABLE `post_params`  ADD `pp_template_base` TINYTEXT NOT NULL AFTER `pp_num`, ADD `pp_template` TINYTEXT NOT NULL AFTER `pp_template_base`,  ADD `pp_template_num` INT NOT NULL AFTER `pp_template`;";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);  
	$q="ALTER TABLE `directory` CHANGE `dir_menu_type` `dir_menu_type` TINYTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL  ;";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);  
	$q="ALTER TABLE `directory` CHANGE `dir_sub_menu_order` `dir_sub_menu_order` DECIMAL(5,1) NOT NULL;";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); 
	$q="ALTER TABLE `directory` CHANGE `dir_menu_order` `dir_menu_order` DECIMAL(5,1) NOT NULL ";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); 
	$q="ALTER TABLE `directory`  ADD `time` TINYTEXT NOT NULL,  ADD `token` TINYTEXT NOT NULL;";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); 
	$q="ALTER TABLE `directory`  ADD `dir_temp` DECIMAL(5,1) NOT NULL;";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); 
	$q="ALTER TABLE `directory`  ADD `dir_temp2` DECIMAL(5,1) NOT NULL;";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); 
	$q="ALTER TABLE `directory` CHANGE `id` `id` SMALLINT(3) UNSIGNED NOT NULL AUTO_INCREMENT;";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); 
	$q="ALTER TABLE `directory`  ADD `dir_menu_id` SMALLINT NOT NULL AFTER `id`;";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); 
	$q="ALTER TABLE  `directory` CHANGE  `dir_gall_ref`  `dir_gall_table` TINYTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ;";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	return;
	
	$num='_num';
	
	for ($i=4; $i<8; $i++){
	$j=$i-1;
	
	
	
	$q="ALTER TABLE `master_post` ADD `blog_data$i` TEXT CHARACTER SET utf8 COLLATE utf8_bin NOT NULL AFTER `blog_data$j`;";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	}
	return;
	$q="ALTER TABLE `post_params`  ADD `pp_table_base` TINYTEXT CHARACTER SET utf8 COLLATE utf8_bin NOT NULL AFTER `pp_id`;";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	return;
	$q="ALTER TABLE  `master_gall` ADD  `gall_glob_title` TINYTEXT CHARACTER SET utf8 COLLATE utf8_bin NOT NULL AFTER  `gall_display`";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	return;
	$q="ALTER TABLE  `directory` CHANGE  `dir_gall_type`  `dir_gall_ref` TINYTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ;";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	$q="ALTER TABLE  `directory` CHANGE  `id`  `id` SMALLINT( 5 ) UNSIGNED NOT NULL AUTO_INCREMENT ";
	 $mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	$q="ALTER TABLE  `directory` CHANGE  `dir_ref`  `dir_ref` TINYTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL";
	 $mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	$q="ALTER TABLE  `directory` CHANGE  `dir_menu_ref`  `dir_menu_style` TINYTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL" ;
	 $mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	 $q="ALTER TABLE  `master_post` CHANGE  `blog_id`  `blog_id` SMALLINT( 4 ) UNSIGNED NOT NULL AUTO_INCREMENT" ;
	 $mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	 $q="ALTER TABLE  `master_page` CHANGE  `id`  `id` SMALLINT( 4 ) UNSIGNED NOT NULL AUTO_INCREMENT ";
	 $mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	 $q="ALTER TABLE  `master_gall` CHANGE  `pic_id`  `pic_id` SMALLINT( 5 ) UNSIGNED NOT NULL AUTO_INCREMENT ";
	 $mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	 $q="ALTER TABLE  `master_gall` ADD  `gall_display` TINYTEXT CHARACTER SET utf8 COLLATE utf8_bin NOT NULL AFTER  `gall_expand` ";
	 $mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	 $q="ALTER TABLE  `master_gall` ADD  `time` TINYTEXT NOT NULL ";
	 $mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	}
	
	
static function procedure_drop_column($table,$columns,$db){
	$mysqlinst=mysql::instance();  
	$mysqlinst->dbconnect($db); 
	
	$columns=(is_array($columns))?$columns:explode(',',$columns);
	foreach ($columns as $column){
		$q="drop procedure if exists  schema_change;";
		$r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);  
		//echo NL.$q;
		$q="
create procedure schema_change() begin if exists(select * from information_schema.columns where table_name = '$table' and column_name = '$column' and TABLE_SCHEMA='$db') then 
alter table $table drop column $column; 
end if;
end";
echo $q;
		$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);  
	$q="
	call  schema_change();"; 
		
		$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
		
		}
	$q="drop procedure if exists  schema_change;";
		$r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);  
	
	}
	
	
	
static function master_gall_gen($db,$tablename){  
//page_refname
//data_expand_type
	//const Gallery_fields='pic_order,bigname,littlename,imagetitle,description,subtitle,width,height,imagetype,galleryname,text,temp_pic_order,reset_id';
   	if($tablename=='master_gall') return;
	 $mysqlinst=mysql::instance();  
	 $mysqlinst->dbconnect($db);
	  $q="truncate table master_gall";
	 $mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);

	 $master_gall=array();
	 $fields='pic_order,bigname,littlename,imagetitle,description,subtitle,width,height,imagetype,galleryname,text,temp_pic_order,reset_id';
	$masterfields='master_gall_ref,gall_ref,gall_expand,gall_display,pic_order,bigname,littlename,imagetitle,description,subtitle,width,height,imagetype,galleryname,text,temp_pic_order,reset_id';
	$field_array=explode(',',$fields);
	$count=count($field_array);
	$mastertable='master_gall'; 
	  $q="select dir_ref,dir_expand,dir_gall_display from directory where dir_menu_type='gallery'";
	 $r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	
	 while($rows=$mysqlinst->fetch_row($r)){
	  
		(!empty($rows[0]))&&$master_gall[$rows[0]]=array($rows[1],$rows[2]);
		}
	 	
		 
	 
		 
	foreach ($master_gall as $master=>$expand){echo $master . ' is master'; 
		$q1="select $fields   from $master order by pic_order"; echo NL.$q1.' is q1'; 
		$r1= $mysqlinst->query($q1,__METHOD__,__LINE__,__FILE__,true);
		while ($rows1=$mysqlinst->fetch_row($r1)){
			$collect1="'self','$master','$expand[0]','$expand[1]',"; echo NL.$collect1.' is collect1';
			for ($i=0; $i<$count; $i++){
				$collect1.="'".process_data::cleanup($rows1[$i])."',";
				}
			$collect1=substr_replace($collect1,'',-1);
			 $qq="insert into $mastertable ($masterfields) values ($collect1)";
				$mysqlinst->query($qq,__METHOD__,__LINE__,__FILE__,false);  
			$q2="select $fields from $rows1[9] order by pic_order"; echo NL.NL. NL.NL.$qq;
			$r2=$mysqlinst->query($q2,__METHOD__,__LINE__,__FILE__,false);
			while ($rows2=$mysqlinst->fetch_row($r2)){//begin while 2
				$collect2="'$master','$rows1[9]','$expand[0]','$expand[1]',";
				for ($ii=0; $ii<$count; $ii++){
				    $collect2.="'".process_data::cleanup($rows2[$ii])."',";
				    } 
				$collect2=substr_replace($collect2,'',-1);   
				$qqq="insert into $mastertable ($masterfields) values ($collect2)"; echo NL.NL.NL.$qqq;
				$mysqlinst->query($qqq,__METHOD__,__LINE__,__FILE__,false);
				}//end while 2
			}//end while 1
			
		 //echo NL.NL.$q . ' in '.$db;
          }//end foreach
          
    } //end function
    
 static function create_my_table($db){  $tb='post_params';
	$mysqlinst=mysql::instance();  
	 $mysqlinst->dbconnect($db);
	$q="DROP TABLE IF EXISTS $tb";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	$q="create TABLE $tb (
		pp_id SMALLINT  UNSIGNED NOT NULL AUTO_INCREMENT,
		pp_table TINYTEXT CHARACTER SET utf8 COLLATE utf8_bin, 
		pp_num tinyint, 
		pp_params TINYTEXT CHARACTER SET utf8 COLLATE utf8_bin,
		pp_style TINYTEXT CHARACTER SET utf8 COLLATE utf8_bin,
		time TINYTEXT CHARACTER SET utf8 COLLATE utf8_bin,
		token TINYTEXT CHARACTER SET utf8 COLLATE utf8_bin,
			
		    PRIMARY KEY (pp_id)
		  ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	}//end create my table
	
static function insert_select($db,$tablename, $fields, $fields2, $sub=''){//jumped ship
	$mysqlinst=mysql::instance();  
	 $mysqlinst->dbconnect($db);
	$q="insert into $tablename ($fields) select ($fields) from $tablename where ";
	}

static function move_post_images($db,$dir,$dir2,$dir3){
	$mysqlinst=mysql::instance();
	$mysqlinst->dbconnect($db);
	$q="select blog_pic_info from master_post where blog_pic_info !='' and blog_type='image' or blog_type='float_image_right'  or blog_type='float_image_left'";
	$r1= $mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	while (list($blog_pic)=$mysqlinst->fetch_row($r1)){
		list($blog_pic,$alt)=process_data::process_pic($blog_pic);  
	
		if (is_file($dir.$blog_pic)){
			copy($dir.$blog_pic, $dir2.$blog_pic);
			rename($dir.$blog_pic, $dir3.$blog_pic);
			}
		else echo NL. "cannot find $dir$blog_pic";
		}//end while
	}
		




static function auxillary($db){
	$mysqlinst=mysql::instance();
	$mysqlinst->dbconnect($db);
	$q="UPDATE vwpkbpmy_karmawebsite.master_gall set gall_expand_option='highslide'";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true); 
	$q="UPDATE vwpkbpmy_ekarasawebsite.master_gall set gall_expand_option='standard'";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true); 
	$q="UPDATE vwpkbpmy_imaginewebsite.master_gall set gall_expand_option='preview'";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true); 
	$q="UPDATE vwpkbpmy_florencewebsite.master_gall set gall_expand_option='side_nav_pic'";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true); 
	$q="UPDATE vwpkbpmy_karmawebsite.master_gall set gall_display='highslide_single' where master_gall_ref!='self'";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	$q="UPDATE vwpkbpmy_imaginewebsite.master_gall set gall_display='rows_caption_single' where master_gall_ref!='self'";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	$q="UPDATE vwpkbpmy_florencewebsite.master_gall set gall_display='expandgallery' where master_gall_ref!='self'";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	$q="UPDATE vwpkbpmy_ekarasawebsite.master_gall set gall_display='expandgallery' where master_gall_ref!='self'";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	return;
	}
static function change_field_values($db){
	
	$mysqlinst=mysql::instance();
	$mysqlinst->dbconnect($db);
	// $q="update master_gall_table t,  master_gall_table r SET 
	//			t.gall_display=r.gall_display WHERE t.master_gall_ref='self' AND r.pic_order=1 AND r.master_gall_ref=t.master_gall_ref";
	//$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true); echo NL.$q;
	//return;
	$q="select gall_display from master_gall where master_gall_ref='self' and pic_order=1 limit 1"; echo NL.NL.$q;
	$r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	list($val)=$mysqlinst->fetch_row($r,__LINE__);
	
	
	 $q="update master_gall    SET 
				 master_display='$val'";echo NL.NL.$q;
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);  
	$q="select gall_display from master_gall where master_gall_ref!='self' and pic_order=1 limit 1";echo NL.NL.$q;
	$r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	list($val)=$mysqlinst->fetch_row($r,__LINE__);
	
	
	 $q="update master_gall    SET 
				gall_display='$val'";echo NL.NL.$q;
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);  
	 
	}
	

  
static function master_blog_gen($db,$tablename){  
	$masterfields='blog_table,blog_table_base,blog_col,blog_date,blog_tag,blog_border_start,blog_border_stop,blog_string_break,blog_order,blog_type,blog_text,blog_pic_info,blog_vid_info,blog_style,blog_break,blog_float,blog_info,blog_drop_down,token,blog_link,blog_data1,blog_data2,blog_temp,blog_update,blog_time,blog_data3,blog_linkref';
	
	
	if($tablename=='master_post') return;
	
	//if($tablename=='blog_reset'){ echo 'Alert reset_blog still lives';  } return;
	 $mysqlinst=mysql::instance();  
	 $mysqlinst->dbconnect($db);
	 $q="drop table  $tablename";
	 $mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true); return;
	
	 
 
	  $field='blog_table,blog_date,blog_tag,blog_border_start,blog_border_stop,blog_string_break,blog_order,blog_type,blog_text,blog_pic_info,blog_vid_info,blog_style,blog_break,blog_float,blog_info,blog_drop_down,token,blog_link,blog_data1,blog_data2,blog_temp,blog_update,blog_time,blog_data3,blog_linkref';
 
	$field_array=explode(',',$field);
	$count=count($field_array);
	$mastertable='master_post'; 
	$q="select $field   from $tablename order by blog_order";  echo NL.$q;
	$r= $mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	while ($rows=$mysqlinst->fetch_row($r)){
           $collect='';
		 for ($i=0; $i<$count; $i++){ 
			if ($field_array[$i]=='blog_table'){
				$split=substr($rows[$i],-1);
				 $split2=str_replace($split,'',$rows[$i]);
				$collect.="'$rows[$i]','$split2','$split',";
				echo $collect;
				 
				 
				}
		 
               else $collect.="'$rows[$i]',";
               }
		$collect=substr_replace($collect,'',-1);
		//echo NL.$collect;
		$q="insert into $mastertable ($masterfields)
  values ($collect)";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
		 echo NL.NL.$q . ' in '.$db;
          }//end while
          
    } //end function
 

	
static function master_data_gen($db,$tablename){  
//page_refname
//data_expand_type
   $masterfields='page_ref,page_ref_base,page_ref_ext,blog_params1,blog_params2,blog_params3,blog_params4,blog_params5,blog_params6,check_data,token_store,updatedate,blog_master_style,keywords,metadescription,abstract,title,header1,header2,header3,header4,header5,header6,header7,header8,header9,header10,text1,text2,text3,text4,text5,text6,text7,text8,text9,text10,text11,text12,text13,text14,text15,text16,text17,text18,text19,text20,footer,color_edit,color_bot,background_inner,background,use_background_inner,master_font,background_image_inner,background_image,pic1,pic2,pic3,pic4,pic5,h1,h2,h3,h4,data1,data2,data3,data4,data5,data6,data7,data8,data9,data10,data11,data12,data13,data14,data15,data16,data17,data18,data19,data20,data21,data22,data23,data24,data25,data26,data27,data28,data29,nav1,nav2,nav3,nav4,nav5,nav6,nav7,nav8,nav9,nav10,nav11,nav12,nav13,nav14,nav15,nav16,nav17,nav18,nav19,nav20,nav21,nav22,nav23,nav24,nav25,styletitle,stylenav,stylesidenav,styleheader1,styleheader2,styleheader3,styleheader4,styleheader5,styleheader6,styleheader7,styleheader8,styleheader9,styleheader10,styletext1,styletext2,styletext3,styletext4,styletext5,styletext6,styletext7,styletext8,styletext9,styletext10,styletext11,styletext12,styletext13,styletext14,styletext15,styletext16,styletext17,styletext18,styletext19,styletext20,stylefooter,stylepic1,stylepic2,stylepic3,stylepic4,stylepic5,styleh1,styleh2,styleh3,styleh4,style1,style2,style3,style4,style5,style6,style7,style8,style9,style10,style11,style12,style13,style14,style15,style16,style17,style18,style19,style20,style21,style22,style23,style24,style25,style26,style27,style28,style29,style30,style31,style32,style33,style34,style35,style36,style37,style38,style39,style40,style41,style42,style43,style44,style45,style46,style47,style48,style49,style50';
   
	if($tablename=='master_page') return;
	 $mysqlinst=mysql::instance();  
	 $mysqlinst->dbconnect($db);
	 
	 $q="drop table  $tablename";
	 $mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true); return;
	 
	  $field='blog_params1,blog_params2,blog_params3,blog_params4,blog_params5,blog_params6,check_data,token_store,updatedate,blog_master_style,keywords,metadescription,abstract,title,header1,header2,header3,header4,header5,header6,header7,header8,header9,header10,text1,text2,text3,text4,text5,text6,text7,text8,text9,text10,text11,text12,text13,text14,text15,text16,text17,text18,text19,text20,footer,color_edit,color_bot,background_inner,background,use_background_inner,master_font,background_image_inner,background_image,pic1,pic2,pic3,pic4,pic5,h1,h2,h3,h4,data1,data2,data3,data4,data5,data6,data7,data8,data9,data10,data11,data12,data13,data14,data15,data16,data17,data18,data19,data20,data21,data22,data23,data24,data25,data26,data27,data28,data29,nav1,nav2,nav3,nav4,nav5,nav6,nav7,nav8,nav9,nav10,nav11,nav12,nav13,nav14,nav15,nav16,nav17,nav18,nav19,nav20,nav21,nav22,nav23,nav24,nav25,styletitle,stylenav,stylesidenav,styleheader1,styleheader2,styleheader3,styleheader4,styleheader5,styleheader6,styleheader7,styleheader8,styleheader9,styleheader10,styletext1,styletext2,styletext3,styletext4,styletext5,styletext6,styletext7,styletext8,styletext9,styletext10,styletext11,styletext12,styletext13,styletext14,styletext15,styletext16,styletext17,styletext18,styletext19,styletext20,stylefooter,stylepic1,stylepic2,stylepic3,stylepic4,stylepic5,styleh1,styleh2,styleh3,styleh4,style1,style2,style3,style4,style5,style6,style7,style8,style9,style10,style11,style12,style13,style14,style15,style16,style17,style18,style19,style20,style21,style22,style23,style24,style25,style26,style27,style28,style29,style30,style31,style32,style33,style34,style35,style36,style37,style38,style39,style40,style41,style42,style43,style44,style45,style46,style47,style48,style49,style50';

	$field_array=explode(',',$field);
	$count=count($field_array);
	$mastertable='master_page'; 
	$q="select $field  from $tablename";  echo NL.$q;
	$r= $mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	$row=$mysqlinst->fetch_row($r);
		if (strpos($tablename,'data')!==false){
			$base=str_replace('data','',$tablename);
			$collect="'$tablename','$base','data',";
			}
		else if (strpos($tablename,'expand')!==false){
			$base=str_replace('expand','',$tablename);
			$collect="'$tablename','$base','expand',";
			}
		else if (strpos($tablename,'highslide')!==false){
			$base=str_replace('highslide','',$tablename);
			$collect="'$tablename','$base','highslide',";
			}
		else $collect="'$tablename','$tablename','',";
		 for ($i=0; $i<$count; $i++){ 
			$collect.="'$row[$i]',";
               }
		$collect=substr_replace($collect,'',-1);
		//echo NL.$collect;
		$q="insert into $mastertable ($masterfields)
  values ($collect)";
	 $mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
		 echo NL.NL.$q . ' in '.$db;
           
          
    } //end function
  
 
//const Page_fields='blog_params1,blog_params2,blog_params3,blog_params4,blog_params5,blog_params6,check_data,token_store,updatedate,blog_master_style,id,keywords,metadescription,abstract,title,header1,header2,header3,header4,header5,header6,header7,header8,header9,header10,text1,text2,text3,text4,text5,text6,text7,text8,text9,text10,text11,text12,text13,text14,text15,text16,text17,text18,text19,text20,footer,color_edit,color_bot,background_inner,background,use_background_inner,master_font,background_image_inner,background_image,pic1,pic2,pic3,pic4,pic5,h1,h2,h3,h4,data1,data2,data3,data4,data5,data6,data7,data8,data9,data10,data11,data12,data13,data14,data15,data16,data17,data18,data19,data20,data21,data22,data23,data24,data25,data26,data27,data28,data29,nav1,nav2,nav3,nav4,nav5,nav6,nav7,nav8,nav9,nav10,nav11,nav12,nav13,nav14,nav15,nav16,nav17,nav18,nav19,nav20,nav21,nav22,nav23,nav24,nav25,styletitle,stylenav,stylesidenav,styleheader1,styleheader2,styleheader3,styleheader4,styleheader5,styleheader6,styleheader7,styleheader8,styleheader9,styleheader10,styletext1,styletext2,styletext3,styletext4,styletext5,styletext6,styletext7,styletext8,styletext9,styletext10,styletext11,styletext12,styletext13,styletext14,styletext15,styletext16,styletext17,styletext18,styletext19,styletext20,stylefooter,stylepic1,stylepic2,stylepic3,stylepic4,stylepic5,styleh1,styleh2,styleh3,styleh4,style1,style2,style3,style4,style5,style6,style7,style8,style9,style10,style11,style12,style13,style14,style15,style16,style17,style18,style19,style20,style21,style22,style23,style24,style25,style26,style27,style28,style29,style30,style31,style32,style33,style34,style35,style36,style37,style38,style39,style40,style41,style42,style43,style44,style45,style46,style47,style48,style49,style50';
     
 
 	 
static function clean_rows($db,$tablename){
	$mysqlinst=mysql::instance();  
	 $mysqlinst->dbconnect($db);
	$count=$mysqlinst->count_field($tablename,'blog_order','',false);
	$fieldmax=$mysqlinst->get('fieldmax');
	  $q="select blog_order from $tablename where blog_type='text' and blog_text='Ready for Action And will not appear on the webpage till you change it!'";
	$r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	while(list($blog_order)=$mysqlinst->fetch_assoc($r,'',false)){
		// $q="delete from $tablename where blog_type='text' and blog_text='Ready for Action And will not appear on the webpage till you change it!'";
		// echo $q;
		$r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
		while(list($blog_order)=$mysqlinst->fetch_row($r,'',false)){
			echo NL."blog order is $blog_order and filemax is $fieldmax  and  &nbsp;&nbsp;&nbsp;&nbsp;         $db  and $tablename";
			}
		}
	}
	
	
	
static function master_db_tablename_pass($functionQuery,$page_ref=true, $table_check='',$removetables=false){
	  require_once('includes/Sys.php');
	  echo 'pass Sys.php';
	   $arr=explode(',',Cfg_master::Dbase_update);
		$mysqlinst=mysql::instance();  
	   foreach ($arr as $db){ 
			 $db=Cfg_master::Dbn_prefix.$db; 
	           $mysqlinst->dbconnect($db);
			($page_ref===true)&&$tables=check_data::return_pages(__METHOD__,__LINE__,__FILE__) ; #set to true to remove expand,highslide, and data tables
			($page_ref===false)&&$tables=check_data::return_galleries(__METHOD__,__LINE__,__FILE__,'',false,false,$db);
			 foreach ($tables as $tablename){
				self::$functionQuery($db,$tablename);#it is passing function out
				} 
			}	
		}
static function add_dbfield3($db,$tablename){
	$mysqlinst=mysql::instance();  
	$mysqlinst->dbconnect($db);
	$fields='this_css,site_css,use_tags,use_dates,use_reply, container_width,blog_master_style1,blog_master_style2,blog_master_style3,blog_master_style4,blog_master_style5,blog_master_style6';
	$fields=explode(',',$fields);
	foreach ($fields as $field){
		$q="ALTER TABLE  $tablename ADD  $field tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL";
		$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
		}
	}
	
 
	
static function add_dbfield($db,$tablename){ 
 
	$mysqlinst=mysql::instance();  
	$mysqlinst->dbconnect($db);
	for ($i=1; $i<7; $i++){  
	$q="ALTER TABLE  $tablename ADD  blog_params$i tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	$q=" ALTER TABLE $tablename DROP blog_parms$i"; 
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
}
	 
	// $q="ALTER TABLE $tablename  CHANGE `blog_break` `blog_float` TINYTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL";
	//$q="ALTER TABLE $tablename ADD `blog_tag` TINYTEXT CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,
	//	ADD `blog_date` TINYTEXT CHARACTER SET utf8 COLLATE utf8_bin NOT NULL";
	$q="ALTER TABLE  $tablename ADD  blog_master_style tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	$q="ALTER TABLE  $tablename ADD  check_data tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	$q="ALTER TABLE  $tablename ADD  token_store tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	$q="ALTER TABLE  $tablename ADD  updatedate tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
$q="UPDATE $tablename SET `updatedate` = `style46`"; 
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	
	$q="UPDATE $tablename SET `blog_master_style` = `style44`"; 
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	// $q=" ALTER TABLE $tablename DROP `update`"; 
	// $q=" ALTER TABLE $tablename DROP `process_check_data`";
 
	}
   
static function add_dbfield2($db,$tablename){
	$mysqlinst=mysql::instance();  
	$mysqlinst->dbconnect($db);
	$q="ALTER TABLE $tablename ADD `blog_tag_start` TINYTEXT CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,
	ADD `blog_border_stop` TINYTEXT CHARACTER SET utf8 COLLATE utf8_bin NOT NULL";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	}
 
 
	
static function add_dbfield_style($db,$tablename){// this is for updaing/adding style fields to non blog tables
	$mysqlinst=mysql::instance();  
	$mysqlinst->dbconnect($db);
        $field_data=Cfg::Page_fields;
    $field_array=explode(',',$field_data);  
      $q = "SELECT $field_data FROM ". $tablename . " where id=1";  
	   $r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); 
 
	 
	   
	    while ($rows=$mysqlinst->fetch_assoc($r,__LINE__,false)) {
			 for ($x=0; $x<count($field_array); $x++){
			    ${$field_array[$x]}=trim($rows[$field_array[$x]]);#creates variable with name and value of field;
			    $oldval=explode(',',${$field_array[$x]});
				 if(array_key_exists(15,$oldval)&&!array_key_exists(17,$oldval)){
					$newval=self::add_dbfield_style_values($oldval);
					$q="update $tablename set $field_array[$x]='$newval'";
					echo $q;
					$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	}
				//echo  NL.$db.'  '.$tablename.'  ' .$field_array[$x].' = '. ${$field_array[$x]};
			    }
		  }//end while
	 
	 
	}

static function add_blog_style($db,$tablename){// this is for updaing/adding style fields   blog tables
	$mysqlinst=mysql::instance();  
	$mysqlinst->dbconnect($db);
        $q = "SELECT blog_style,blog_order FROM ". $tablename;  
	   $r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); 
 
	 
	   
	while ($rows=$mysqlinst->fetch_assoc($r,__LINE__,false)) {
		$oldval=explode(',',$rows['blog_style']);  
			 if(array_key_exists(15,$oldval)&&!array_key_exists(17,$oldval)){
				$newval=self::add_dbfield_style_values($oldval);		
				$q = "Update $tablename set blog_style='$newval' where blog_order=".$rows['blog_order'];
				echo $q;
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
				}
		}//end while
	$q="ALTER TABLE $tablename ADD `blog_break` TINYTEXT CHARACTER SET utf8 COLLATE utf8_bin NOT NULL";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);

	}

static function add_dbfield_style_values($array){
	$newarray=$array;
	for ($i=5; $i<count($array); $i++){
		$newarray[$i+4]=$array[$i];
		}
	for ($i=5; $i<9; $i++){	
		$newarray[$i]=0;
		  }
	$newarray=implode(',',$newarray);
					
	return $newarray;
	}
/*  prior to running mysql updating
private  function db_copy_server(){#server copy of bluehost generated and copies blue host master t0 LOCAL  to testsite foreign and restore self
	 (!Sys::Loc)&& exit('you must be in local directory to run this!');
	 
	$this->iframe(Cfg::Db_backup_server);//ATTENTION:  THIS IS ON SERVER AND GENERATES THE DATABASE INFO!!!
	$arr=explode(',',Cfg::Dbase_update);
	  $path=Sys::Home_site.'master/'.Cfg::Blue_host;
	  $localpath=Sys::Pub.'master/'.Cfg::Blue_host; 
   
	foreach ($arr as $db){
		$db=Cfg::Dbn_prefix.$db.'.sql';  
		if (!copy ($path.$db,$localpath.$db)) 
			echo NL.$localpath.$db.' has NOT been copied';
		else echo NL.$localpath.$db.' has   been copied';
		}
	}*/
	
	
static function run(){
	 //self:dbase_pass('plugin_update_params','vwpkbpmy_ekarasawebsite,vwpkbpmy_karmawebsite,vwpkbpmy_imaginewebsite','data');
	 //self::plugin_update_params('vwpkbpmy_karmawebsite','facilitation');
	//self::dbase_pass('plugin_update_params','vwpkbpmy_ekarasawebsite,vwpkbpmy_imaginewebsite,vwpkbpmy_florencewebsite','data');
	echo 'hello world';
	 }
	 
	 

	 
static function plugin_update_params($db,$tablename){
	 require_once('includes/Sys.php');
	 $mysqlinst=mysql::instance();  
	 $mysqlinst->dbconnect($db);
	 for ($a=1; $a<7; $a++){  
		  $q="select blog_params$a from $tablename";  
		  $r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
		  $val=$mysqlinst->fetch_row($r);
		  if (!empty($val[0])){
			   $value=$val[0];
			   echo " begin value is $value";  
			    $value=explode(',',$value);
			    $count=count($value);
			    if ($count != 10) {
				    printer::alert_neg('count is '. $count.' in '.$db.$tablename);
				    continue;
				    }
			    $newArr=array();
			    $newArr[0]=$value[0];
			    $newArr[1]=0;
			    $newArr[2]=0; //print_r($newArr);
			    for ($i=1; $i <$count; $i++){ 
				    $newArr[$i+2]=$value[$i];
				    }
				   
			     $value=implode(',',$newArr);
			    printer::alert_pos("  new value is $value using   $db.$tablename ");
			    $q="update $tablename set blog_params$a='$value'";
			   $mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
			   }
		  else echo "null value for params$a in $db.$tablename";
		  }//end for 
	 }//end function
	 
	 
	/* old change list
	 $q="update $tablename set pic_id=pic_order";
			  // $r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
			// $q="ALTER TABLE $tablename  ADD PRIMARY KEY (pic_id)";
			  //$r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
			 //$q="ALTER TABLE $tablename CHANGE pic_id pic_id TINYINT( 3 ) UNSIGNED NOT NULL AUTO_INCREMENT"; 
			// $q="Update $tablename set blog_break='break' where blog_break='return'"; 
			 // $r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
			//  }
	  
	   $q="select master_font from $tablename";
	    $r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
			 list($style)=$mysqlinst->fetch_row($r);
			 ($style=='master_font')&& printer::alert( $tablename . 'is table and db is '.$d);
			 }
	   
			//  $q="alter table $tablename change blog_style_pic blog_string_break tinytext";    
			// $r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
			   $q="Update $tablename set blog_break='float' where blog_break=''";  
			  $r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
			   $q="Update $tablename set blog_break='break' where blog_break='true'"; 
			  $r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	  
	 
	 // $q="select background,background_inner from $tablename where id =1";
	  $q="alter table $tablename change use_background master_font tinytext";   echo $q;
	      $r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	  // list($background, $background_inner)=$mysqlinst->fetch_row($r);
	   //$newbackground=str_replace('center,top','50,0',$background);
	 //  $newinnerbackground=str_replace('center,top','50,0',$background);
	 $q="select styletext1 from indexpage";
	   $r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	   if ($mysqlinst->affected_rows()){
			 list($style)=$mysqlinst->fetch_row($r);
			 $style=explode(',',$style);
			 $count=count($style);
			 if ($count > 7){
				    $style=str_replace('=>',",",$style[5]);
				    $q="update $tablename set master_font = '$style'";
					$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
				    }
			 }
	   else {
			 $q="select blog_style from index_blog1 where blog_order=1";
			  $r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
			 if ($mysqlinst->affected_rows()){
				    list($style)=$mysqlinst->fetch_row($r);
				    $style=explode(',',$style);
				    $count=count($style);
				    if ($count > 7){
						 $style=str_replace('=>',",",$style[5]);
						  $q="update $tablename set master_font = '$style'";
						   $mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
						  }
			 else echo NL. 'style not found in '.$tablename;	 
			   
			   }
		}//mysqli affected rows..
		//$q=" Update $tablename set background='$newbackground'";
		 
		// $q=" Update $tablename set background_inner='$newinnerbackground'";
		// $mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
		 }//end foreach  
	 
 AUTOINCREMENT  AUTO_INCREMENT   SETTING UP AUTO  INCREMENT
  $q="update $tablename set pic_id=pic_order";
			   $r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
			 $q="ALTER TABLE $tablename  ADD PRIMARY KEY (pic_id)";
			  $r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
			 $q="ALTER TABLE $tablename CHANGE pic_id pic_id TINYINT( 3 ) UNSIGNED NOT NULL AUTO_INCREMENT"; 
			// $q="Update $tablename set blog_break='break' where blog_break='return'"; 
			  $r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
			  
			  */






static function users_db_adjust($db){
$mysqlinst=mysql::instance();
$mysqlinst->dbconnect_no_db();
$usr=users::instance();
$q="select OS,id from  $db.user_data order by id";   
$r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
$robots=$usr->get('ROBOT_USER_AGENTS');
$fields=$usr->get('db_fields'); 
while(list($OS,$id)=$mysqlinst->fetch_row($r)){ 
	   foreach ($robots as $bot){  
			 $bot=strtolower($bot);
			 $OS=strtolower($OS);
			 if (preg_match("/$bot/",$OS)==true){
					//$q=insert into `vwpkbpmy_user_data`.`bot_data`  select $fields from vwpkbpmy_user_data.user_data where id='$id'";
				    $q="update $db.user_data set bot='$bot' where id=$id";
				    $mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
				    $q="insert into $db.bot_data   ($fields) select $fields from $db.user_data where id=$id";
				    $mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true); 
				    $q="DELETE FROM $db.user_data WHERE id = $id";
				    $mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
				    break; 
				    }
			 }
	   }
}//end function

static function createDBandPermissions(){
include ('includes/Sys.php');
	$mysqlinst = mysql::instance();
	$backupinst= backup::instance();
	$mysqlinst->dbconnect_no_db('root','lover');
$arr=explode(',',Cfg::Dbase_update);
$arr[]='user_data';
foreach($arr as $db){
   	$dbname=Cfg::Dbn_prefix.$db;echo "dbname is $dbname";
	$db_file=$dbname.'.sql';
	//	if(strpos($db,'ekarasa')!==false)continue;// Make my_db the current database
			//	$q="drop database $dbname";
		//	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);continue;
		$mysqlinst->permissions($dbname,'vwpkbpmy_sdrshn','118cheznut');
		if (strpos($db,'karma')!==false){echo 'karma user added';
			$mysqlinst->permissions($dbname,'vwpkbpmy_karma','hariomtatsat');
		}
		if (strpos($db,'user_data')!==false){
		  $mysqlinst->permissions($dbname,'sdrshn2','xXyYzZaA4321');
		}
		mysql::restoreDB(Sys::Pub.Cfg::Db_bluehost_path, $db_file, $dbname, Cfg::Dbn_prefix.Cfg::Dbuser, Cfg::Dbpass);
		}  
	}
#test script outcome unknown..
static function cliwindows(){ echo 'made it to begin';#a test script
		exec("mklink /d C:\xampp\htdocs\florence\tinymce C:\xampp\htdocs\tinymce");
		echo 'made it to end';
		}
static function exec(){ echo 'made it to begin';#a test script
/*<?php
#ExpressEdit 2.0
 echo exec('ls -l');
 echo system('whoami');
 ?>*/

		exec("scp /sf/htdocs/florence/includes/Cfg.class.php vwpkbpmy@ekarasa.com:/home1/vwpkbpmy/public_html/florence/includes");
		echo 'made it to end';
		}	 
 
private function db_upload(){#copies blue host master to testsite foreign and restore self
	//(!Sys::Loc)&& exit('you must be in local directory to run this!');
	(Cfg_loc::Domain_extension!='')&&exit('you must be root directory to copy databases');
	
	$backupinst= backup::instance();
	$backupinst->backup_master_db();// send copy of root dir database to master folder
	$mysqlinst = mysql::instance();
	# am now using a bluehost directory on the server so that I can do test updates live then easily replace with the generator!!$directory=(Sys::Loc)?Cfg::Blue_host:'';#use bluehost master files locally .... downloaded to bluehost folder
	$array=array();
	$array[]=Cfg::Dbn_prefix.Cfg::Owner.'website';
	
	if  (defined('Cfg::Foreign_array')&&Cfg_loc::Domain_extension==''&&Cfg::Foreign_overwrite_allow){  
		$arr=explode(',',Cfg::Foreign_array);
		foreach ($arr as $db){
			$array[]=$db;
			}
		}
	
	(Cfg::Test_site)&& $array[]=Cfg::Dbn_prefix.Cfg::Owner.'websitetestsite';
	#first make copy of all auxillary databases then 
	$mysqlinst->dbconnect();#do this to first connect so possible to create dbase if not exists
	foreach ($array AS $var){
		echo NL. $var.' is for db';
		$backupinst-> backupdb ($var);#copy current databases foreingn testsite etc. to respective backup directories
		if (Sys::Loc){#no privelidge on server
			$q="CREATE DATABASE IF NOT EXISTS $var";
			$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
			}
		 $mysqlinst->drop_tables($var,true);
		echo NL.'backup plan is '.Sys::Home_Pub.Cfg::Backup_dir.Cfg::Master_dir.Cfg::Blue_host.' goes to '.$var .' param 2 and param 3 is  '. Sys::Dbname.NL;
		 $backupinst-> restoredb(Sys::Home_Pub.Cfg::Backup_dir.Cfg::Master_dir.Cfg::Blue_host,$var,Sys::Dbname);#RESTORE PATH, DBNAME TO RESTORE, MASTERDB
		}
	#go ahead and upday the masterfile from which testpage will draw its copy!
	$msg=NL . 'copying '.Sys::Home_Pub.Cfg::Backup_dir.Cfg::Master_dir.Sys::Dbname.'.sql to '.Sys::Home_Pub.Cfg::Backup_dir.Cfg::Master_dir.Sys::Dbname.'.sql';
	if (!copy(Sys::Home_Pub.Cfg::Backup_dir.Cfg::Master_dir.Cfg::Blue_host.Sys::Dbname.'.sql',Sys::Home_Pub.Cfg::Backup_dir.Cfg::Master_dir.Sys::Dbname.'.sql')){
		mail::alert('A problem with '.$msg);
		}
	else echo $msg;
		 
	}   

static function  restoredb($path,$restoredb,$filename){
	$backupinst= backup::instance();
	$backupinst-> restoredb($path,$restoredb,$filename);#RESTORE PATH, DBNAME TO RESTORE, MASTERDB
	}
		



private function db_field_generate(){   
     $mysqlinst = mysql::instance();
    $field_data=Cfg::Page_fields;
    $field_array=explode(',',$field_data);  
    $table_array=check_data::return_pages(__METHOD__,__LINE__,__FILE__) ;
    $databasename=Sys::Dbname;
    if (isset($_REQUEST['submitted'])){
	   $mysqlinst->dbconnect(Sys::Dbname);
	   
	  $build=<<<EOL
	  -- phpMyAdmin SQL Dump
	  -- version 3.2.2.1
	  -- http://www.phpmyadmin.net
	  --
	  -- Host: localhost
	  -- Generation Time: Feb 10, 2011 at 05:46 PM
	  -- Server version: 5.1.37
	  -- PHP Version: 5.3.0
	  
	  SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
	  
	  
	  /*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
	  /*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
	  /*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
	  /*!40101 SET NAMES utf8 */;
	  
	  --
	  -- Database: '$databasename'
	  --
	  
	  -- --------------------------------------------------------
EOL;
	  
	   foreach ($table_array as $tablename){ echo 'tablename is '.$tablename;
		   $q = "SELECT $field_data FROM $tablename where id=1";   
		  $r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);	 
		  if (!($mysqlinst->affected_rows())) {
			 $message[]='Alert  site error in accessvar.class.php';
			 echo '<p style="font-weight: bold; font-size: 1.4em; color: '.Cfg::Red_color.'">Site Temporarily Down   Check back later</p>';
			 }
		  while ($rows=$mysqlinst->fetch_assoc($r,__LINE__)) {
			 for ($x=0; $x<count($field_array); $x++){
			    ${$field_array[$x]}=trim($rows[$field_array[$x]]);#creates variable with name and value of field;
			    }				 
			}//while	  
		  $build.="    
		 
		  -- --------------------------------------------------------

		  --
		  -- Table structure for table '$tablename'          
		  --
		 			
		  DROP TABLE IF EXISTS $tablename;
		  CREATE TABLE $tablename (
		   id tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
		    keywords text,
		    metadescription text,
		    abstract text,
		    outertitle tinytext, 
			title text,";
			for ($i=1; $i<=10; $i++){
			  $build.="
			 header$i text,";
			}
			 for ($i=1; $i<=20; $i++){
			  $build.="
			 text$i text,";
			 }
		    $build.='
		    footer text,
		    color_edit tinytext,
		    color_bot tinytext,
		    background_inner tinytext,
		    background tinytext,
		    use_background_inner  tinytext,
		    use_background   tinytext,
		     background_image_inner tinytext, 
			background_image tinytext,';
		   for ($i=1; $i<=5; $i++){
			  $build.="
			 pic$i tinytext,";
			 } 
			 for ($i=1; $i<=4; $i++){
			  $build.="
			h$i text,";
			 }
			for ($i=1; $i<=50; $i++){
			  $build.="
			 data$i text,";
			 } 
		   for ($i=1; $i<=25; $i++){
			  $build.="
			 nav$i tinytext,";
			}
		   $build.='
		   styletitle text,
		   stylenav text,
		   stylesidenav text,';
		   
			for ($i=1; $i<=10; $i++){
			  $build.="
			 styleheader$i text,";
			}
			 for ($i=1; $i<=20; $i++){
			  $build.="
			 styletext$i text,";
			 }
		    $build.='
		    stylefooter text,';
		    
		   for ($i=1; $i<=5; $i++){
			  $build.="
			 stylepic$i text,";
			 } 
			  for ($i=1; $i<=4; $i++){
			  $build.="
			styleh$i text,";
			 }
		    
		    for ($i=1; $i<=50; $i++){
			  $build.="
			 style$i text,";
			 } 
		  
		   $build.='
		    PRIMARY KEY (id)
		  ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
		  
		  --
		  -- Dumping data for table \''.$tablename.'\'
		  --
		  ';
			
		  $build.='
		  REPLACE INTO '.$tablename.' (
			 id,
		    keywords,
		    metadescription,
		    abstract,
		    outertitle, 
			title,';
			for ($i=1; $i<=10; $i++){
			  $build.="
			 header$i,";
			}
			 for ($i=1; $i<=20; $i++){
			  $build.="
			 text$i,";
			 }
		    $build.='
		    footer,
		    color_edit,
		    color_bot,
		     background_inner,
		    background,
		    use_background_inner,
		    use_background ,
		     background_image_inner, 
			background_image,';
		   for ($i=1; $i<=5; $i++){
			  $build.="
			 pic$i,";
			 } 
			 for ($i=1; $i<=4; $i++){
			  $build.="
			h$i,";
			 }
		    for ($i=1; $i<=50; $i++){
			  $build.="
			 data$i,";
			 } 
		   for ($i=1; $i<=25; $i++){
			  $build.="
			 nav$i,";
			}
		   $build.='
		   styletitle,
		   stylenav,
		   stylesidenav,';
		   
			for ($i=1; $i<=10; $i++){
			  $build.="
			 styleheader$i,";
			}
			 for ($i=1; $i<=20; $i++){
			  $build.="
			 styletext$i,";
			 }
		    $build.='
		    stylefooter,';
		    
		   for ($i=1; $i<=5; $i++){
			  $build.="
			 stylepic$i,";
			 } 
			  for ($i=1; $i<=4; $i++){
			  $build.="
			styleh$i,";
			 }
		    
		    for ($i=1; $i<=50; $i++){
			  $build.="
			 style$i,";
			 } 
			$build=substr_replace($build,"",-1);
		  $build.=') VALUES (';
		    $build.='
		    1,
		    \''.$keywords.'\',
			\''.$metadescription.'\',
			\''.$abstract.' \',
			\''.$outertitle.' \', 
			\' '.$title.' \',';
			for ($i=1; $i<=10; $i++){
			$build.='\''.${'header'.$i}.'\',';
			}
			  
			  for ($i=1; $i<=10; $i++){
			$build.='\''.${'text'.$i}.'\',';
			 }
		    for ($i=1; $i<=10; $i++){
			 $build.="
			 0,";
			 }
			 $build.= 
		    ' \''.$footer. ' \',
			\''.$color_edit.' \',
			\' '.$color_bot.' \',
			0,
			\''.$background.' \',
			0,
			\' '.$use_background.' \',
			0,
			\' '.$background_image.' \',';
			 
			 for ($i=1; $i<=5; $i++){
			 $build.='\''.${'pic'.$i}.'\',';
			 } 
		    
			 for ($i=1; $i<=4; $i++){
				$build.='\''.${'h'.$i}.'\',';
				}
			 for ($i=1; $i<=29; $i++){
				$build.='\''.${'data'.$i}.'\',';
				 } 
			  for ($i=30; $i<=50; $i++){#more data
				$build.=
				"0,";
				 }
			 for ($i=1; $i<=25; $i++){
			  $build.='\''.${'nav'.$i}.'\',';
				}
 							
		   $build.="'$styletitle','$stylenav','$stylesidenav',";
		   
			for ($i=1; $i<=10; $i++){
			 $build.='\''.${'styleheader'.$i}.'\',';
			}
			 for ($i=1; $i<=10; $i++){
				$build.='\''.${'styletext'.$i}.'\',';
				}
		     for ($i=11; $i<=20; $i++){
				$build.="0,";#for more styletext
				}
			
			 $build.="'$stylefooter',";//stylefooter,';
		    
		     for ($i=1; $i<=5; $i++){
			  $build.='\''.${'stylepic'.$i}.'\',';
			 } 
			  for ($i=1; $i<=4; $i++){
			  $build.='\''.${'styleh'.$i}.'\',';
			 }
		    
		    for ($i=1; $i<=50; $i++){
			  $build.='\''.${'style'.$i}.'\',';
			  }
			
		   
			 $build=substr_replace($build,"",-1);
		   
			 $build.=');';
		  }//end foreach
	   #begin gallery table generate
	   $field_data=Cfg::Gallery_fields;
	   $field_array=explode(',',$field_data);  
	   $table_array=check_data::return_galleries(__METHOD__,__LINE__,__FILE__) ;#use all tables false=no skipping
	   
	   foreach ($table_array as $tablename){ echo 'tablename is '.$tablename;
			
		  $build.="    
		  
		  -- --------------------------------------------------------

		  --
		  -- Table structure for table '$tablename'          
		  --
		 			
		  DROP TABLE IF EXISTS $tablename;
		  CREATE TABLE $tablename (
		   `pic_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `pic_order` tinyint(3) unsigned NOT NULL,
  `bigname` tinytext NOT NULL,
  `littlename` tinytext NOT NULL,
  `imagetitle` tinytext,
  `description` text,
  `subtitle` text,
  `width` smallint(4) unsigned NOT NULL DEFAULT '150',
  `height` smallint(4) unsigned NOT NULL DEFAULT '150',
  `imagetype` tinytext,
  `galleryname` tinytext,
  `text` text,
  `temp_pic_order` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `reset_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
	PRIMARY KEY (`pic_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;
		  
		  --
		  -- Dumping data for table '$tablename'
		  --
		  
		  REPLACE INTO $tablename (pic_id, pic_order, bigname, littlename, imagetitle, description, subtitle, width, height, imagetype, galleryname, text, temp_pic_order, reset_id) VALUES ";
		  $q = "SELECT $field_data FROM $tablename";   
		  $r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);	 
		  if (!($mysqlinst->affected_rows())) {
			 $msg= 'Mysqli Error';
			 echo '<p style="font-weight: bold; font-size: 1.4em; color: '.Cfg::Red_color.'">'.$msg.'</p>';
			 }
		  while ($rows=$mysqlinst->fetch_assoc($r,__LINE__,false)) {
			 for ($x=0; $x<count($field_array); $x++){
			    ${$field_array[$x]}=trim($rows[$field_array[$x]]);#creates variable with name and value of field;
			    }
			 $build.="
			 
			 ('$pic_id','$pic_order','$bigname','$littlename','$imagetitle','$description','$subtitle','$width','$height','$imagetype','$text','$text','$temp_pic_order','$reset_id'),";
			 }//end while
		   $build=substr_replace($build,";",-1);
		   }#end foreach
		  
	   file_put_contents('gen_'.$databasename.'tables.sql',$build);  echo 'look for '. 'gen_'.$databasename.'tables';
	  
	   } //if submitted
	   //style 43 used to store time for pictures in imagine the land home page
	   //style 46  used to store update dates...
	   //style45 used to store width for blog width limitation..
	   //style44 used to store style for blog_style master initial setup..
	     //  being used for background repeat...
	  # style47 in expandgalleryedit.php used to store the token so that pages affected updates! if all else fails...  can make a token field data...

	  
	   # nav3 is reserved for gallery tables list
	   #style50 is reserved for check_data::return_pages ???
	   //style 29 used to sidemenunav=>style29
	 	 
   }#end modify database

private function query_sql(){#original use eludes
	if (isset($_REQUEST['query_sql'])){
		$q=$_REQUEST['query_sql'];
		$mysqlinst = mysql::instance();
		$mysqlinst->dbconnect_no_db();
		$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);	 
		if (!($mysqlinst->affected_rows())) {
		   echo 'No Rows affected';
		    
		    }
		else echo 'rows have been affected';
		}
	}
	

		  
private function update_gallery_field(){echo 'request returned'; return;
     #begin gallery table generate
	     $mysqlinst = mysql::instance();
		$field_data=Cfg::Gallery_fields;
	   $field_array=explode(',',$field_data);  
	   $table_array=check_data::return_galleries(__METHOD__,__LINE__,__FILE__) ;#use all tables false=no skipping
	    $extension=array(Cfg::Expandgallery,'data');
	  foreach ($table_array as $tablename){
		 $tbname= str_replace('_',' ',trim($tablename)); 
		 foreach ($extension as $ext){ //$q="update $tablename set pic_id=pic_order";
			$q2="update $tablename$ext set outertitle='$tbname'";
			$mysqlinst->query($q2,__METHOD__,__LINE__,__FILE__,false);
			}
		}
    }
 

private function non_local_db_replace_data(){  //currently using http://localhost/mysql_procedural.php
	return;   #u this version obsolete !!  use mod version below!!!
	
	  // $search='www.trekkinglightly.com';
	  // $replace='localhost/trish';
	  $search='localhost/stanley';
	   $replace='www.ekarasa.com/stanley';
	   $db='oceanside-wp1-backup';
	   $tablename='wp_posts';
	   $field=array('post_content','guid');
	   $mysqlinst = mysql::instance(); 
	   $mysqlinst->dbconnect(Sys::Dbname); 
	   $id='ID';		
	   foreach ($field as $f){
		   $q="select $f, $id from $tablename";  echo $q;
		   $r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true); 
		   while ($rows=$mysqlinst->fetch_assoc($r,__LINE__)){
			   $val=$rows[$f];
			   $row_id=$rows[$id];  echo 'good to here';
			   if (strpos($val,$search)!==false){
				   $val=str_replace($search,$replace,$val);
				   $q="update $tablename set $f='$val' where $id=$row_id";   
				    $mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
				   }
			   }
		   }
 	}
static function database_replace_data($old,$new){
	$continue=true;
	($new=='') && $continue=false;
	$_SESSION[Cfg::Owner.'new']=$new; //values passed through sessions
	$_SESSION[Cfg::Owner.'old']=$old;
	$function='str_replace_data';
	self::array_map_database($function,$continue);
	}
	
	
	
 function array_map_database($function,$continue=true){
	echo NL.$continue. ' is continue';
	#called by database_replace_data
     $mysqlinst = mysql::instance(); 
	$mysqlinst->dbconnect(Sys::Dbname);
	$field_data=Cfg::Page_fields;
	$field_array=explode(',',$field_data);  
	$table_array=check_data::return_pages(__METHOD__,__LINE__,__FILE__) ;#use all tables false=no skipping
	foreach ($table_array as $tablename){  echo NL. $tablename; 
		$q = "SELECT $field_data FROM ". $tablename . " where id=1";  
		$r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); 
		$rows=$mysqlinst->fetch_assoc($r,__LINE__);
		$update= 'SET ';
		#USING LOCAL SPAM SCRUBBER
		$new_map = array_map(array($this,$function), $rows);//
		if ($continue){
			for ($x=0; $x<count($field_array); $x++){
				if (isset($new_map[$field_array[$x]])) {
					${$field_array[$x]}=$new_map[$field_array[$x]]; $update.=" {$field_array[$x]}='${$field_array[$x]}',";
					}
				}
			$update=substr_replace($update ,"",-1);  
			$q="UPDATE $tablename $update
			WHERE id = 1";   
			 $mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); 
			}//end foreach tablename for page data
		}
	$field_data=Cfg::Gallery_fields;
	$field_array=explode(',',$field_data);  
	$table_array=check_data::return_galleries(__METHOD__,__LINE__,__FILE__) ;#use all tables false=no skipping
	foreach ($table_array as $tablename){ echo NL. $tablename;     
		$q = "SELECT $field_data FROM  $tablename order by pic_order ASC";  
		$r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); 
		while ($rows=$mysqlinst->fetch_assoc($r,__LINE__)){  
			$update= 'SET ';  
			#USING LOCAL SPAM SCRUBBER
			$new_map = array_map(array($this,$function), $rows );  
			if ($continue){
				for ($x=0; $x<count($field_array); $x++){
					if (isset($new_map[$field_array[$x]])) {
						${$field_array[$x]}=$new_map[$field_array[$x]]; $update.=" {$field_array[$x]}='${$field_array[$x]}',";
						
						}
					}
				$update=substr_replace($update ,"",-1); 
				$q="UPDATE $tablename $update where pic_order='$pic_order'";    
				$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); 
				}//end continue
			}//end while
		}//end foreach
	 
	$field_data=Cfg::Post_fields;
	$field_array=explode(',',$field_data);  
	$table_array=check_data::return_post();#use all tables false=no skipping
	 
	foreach ($table_array as $tablename){  echo NL. $tablename; 
		$q = "SELECT $field_data FROM   $tablename  order by blog_order ASC";  
		$r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); 
		while ($rows=$mysqlinst->fetch_assoc($r,__LINE__)){
			 
			$update= 'SET ';  
			#USING LOCAL SPAM SCRUBBER
			$new_map = array_map(array($this,$function), $rows ); 
			if ($continue){
				for ($x=0; $x<count($field_array); $x++){
					if (isset($new_map[$field_array[$x]])) {
						${$field_array[$x]}=$new_map[$field_array[$x]]; $update.=" {$field_array[$x]}='${$field_array[$x]}',";
						}
					}
				$update=substr_replace($update ,"",-1); 
				$q="UPDATE $tablename $update where blog_order='$blog_order'";   
				$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); 
				}#end continue
			}//end while for blog..
		}//end foreach
	}//end array_map_database
function str_replace_data($value) {if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);  //echo "value begin is $value";
  #called by db_replace_data
   #this first part is set up to remove dashes from filenames
	 if (!isset($_SESSION[Cfg::Owner.'old']) || !isset($_SESSION[Cfg::Owner.'new'])) exit('problem with session new or old');
		if ($_SESSION[Cfg::Owner.'old']==='-'){
		
		if (substr($value,0,1)===$_SESSION[Cfg::Owner.'old']){ 
			echo 'now put in any new value to punch it through';
			printer::alert_neg($value);
			$value=str_replace('-','',$value); echo $value;
			}
		 #else  if (strpos($value,'-')!==false) printer::alert_pos($value);
		 return trim($value);
		}
	
	if (strpos($value,$_SESSION[Cfg::Owner.'old'])===false){  
	}
	else    { 
		if ($_SESSION[Cfg::Owner.'new']==''){
			echo NL.'use "blank" for new to replace';
			printer::alert_pos($value);
			return $value;
			}
		echo NL.'Being replaced';
		printer::alert_pos($value);
		$value = str_replace($_SESSION[Cfg::Owner.'old'],$_SESSION[Cfg::Owner.'new'], $value);
		
		}
	 if (strpos(strtolower($value),$_SESSION[Cfg::Owner.'old'])!==false){
		 printer::alert_neg('A lower case ');  printer::alert($value); printer::alert_neg(' has been found');
		#$value = str_replace($_SESSION[Cfg::Owner.'old'],$_SESSION[Cfg::Owner.'new'], $value);
		}
	 
	return trim($value);
	} // End of () function.	
	
static function str_replace_data_mod($value) {
	 #called by db_replace_data
   #this first part is set up to remove dashes from filenames
	 if (!isset($_SESSION[Cfg::Owner.'old']) || !isset($_SESSION[Cfg::Owner.'new'])) exit('problem with session new or old');
		 
	
	if (strpos($value,$_SESSION[Cfg::Owner.'old'])===false){
		  if (strpos(strtolower($value),$_SESSION[Cfg::Owner.'old'])!==false){
		 printer::alert_neg('A lower case ');  printer::alert($value); printer::alert_neg(' has been found');
		 echo ' in '. $_SESSION[Cfg::Owner.'tablename'];
		#$value = str_replace($_SESSION[Cfg::Owner.'old'],$_SESSION[Cfg::Owner.'new'], $value);
		}
		return trim($value); 
	}
	else  if ($_SESSION[Cfg::Owner.'new']==''){
			echo NL.'use "blank" for new to replace with "" ';
		 echo NL.' in '. $_SESSION[Cfg::Owner.'tablename'];
			printer::alert_neu($value);
			  return trim($value);
			}
	 $replace=($_SESSION[Cfg::Owner.'new']==='blank')?'':$_SESSION[Cfg::Owner.'new'];
	 echo NL.'Being replaced';
		 echo NL.' in '. $_SESSION[Cfg::Owner.'tablename'];
	 printer::alert_pos($value);
	 $value = str_replace($_SESSION[Cfg::Owner.'old'],$replace, $value);
	 return trim('xxxx'.$value);#so that only changed values are updated!!!
	} // End of () function.	
 
 static function database_replace_data_mod_local(){
	//new=$_SESSION[Cfg::Owner.'old']='http://bmtacupuncture.com'; //values passed through sessions
	  // $search='www.trekkinglightly.com';
	  // $replace='localhost/trish';
	  $_SESSION[Cfg::Owner.'old']='localhost/stanley'; //values passed through sessions'localhost/stanley';
	  $new=$_SESSION[Cfg::Owner.'new']='www.ekarasa.com/stanley';
	   $db='oceanside-back'; $continue=true;  #recommend using http:  if www not present for url changes
	 
	   ($new=='') && $continue=false;
	
	$function='str_replace_data_mod';
	self::array_map_database_mod($db,$function,$continue);
	}	
 static function array_map_database_mod($db, $function, $continue=true){ 
	 $mysqlinst = mysql::instance();
	 $mysqlinst->dbconnect($db);     
	 $table_array=check_data::get_tables($db);  
	foreach ($table_array as $tablename){
	 $_SESSION[Cfg::Owner.'tablename']=$tablename;
		$q="SHOW COLUMNS FROM $tablename";
		 $r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); 
		  
		 $field_arr=array();
		
		  while ($rows=$mysqlinst->fetch_assoc($r,__LINE__)){
			  $field_arr[]=$rows['Field'];   
		     }
		  $field_data=implode(',',$field_arr);
		  $q = "SELECT $field_data FROM  $tablename";
		  // echo $q;
		   $r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
		  while ($rows=$mysqlinst->fetch_assoc($r,__LINE__)){
			$update= 'SET ';
			$where='Where ';
			#USING LOCAL SPAM SCRUBBER
			$new_map = array_map(array('file_generator',$function), $rows );
			if ($continue){  //echo $new_map[$field_array[3]]. ' is the field';	
				for ($x=0; $x<count($field_arr); $x++){// echo NL.$field_arr[$x].'num is '.$x . ' count array is '.count($field_arr); 
					${$field_arr[$x]}=$new_map[$field_arr[$x]];
					
			
					if (isset($new_map[$field_arr[$x]])&&substr($new_map[$field_arr[$x]],0,4)=='xxxx') {
					     $new_map[$field_arr[$x]]=substr_replace($new_map[$field_arr[$x]],'',0,4);
						 $update.=" {$field_arr[$x]}='{$new_map[$field_arr[$x]]}',";
						}
				    $id=strtolower($field_arr[$x]);   
				    if (strpos($id,'_id')!==false||$id==='id'){
					     $where.=" $id=".$new_map[$field_arr[$x]] ." AND ";		     
					     }
				    }
				if ($update!=='SET '){ 
				    if (empty($where))echo $update . 'is update and $where is empty';
				    else { 
					  $update=substr_replace($update ,"",-1);
					 $where=substr_replace($where ,"",-4,3);
					 $q="UPDATE $tablename $update $where";
					 echo $q;
					  $mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
					  }
					 
				}# not empty update
				}//end continue
			}//end while
		}//end foreach
	 
	 
			 
		 
	}//end array_map_database_mod	

function syntax_checker($value) {if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);  //echo "value begin is $value";
     #for checkbox's repopulate keys....
    $implode='';
    
     $value = str_replace('<br>','<br>', $value);
   $value = str_replace("& ","&amp; ", $value);
    $value = str_replace("'","&#8217;", $value); //echo "value end is $value";
    return trim($value);
    } // End of spam_scrubber() function.





private function echo_data(){
     $mysqlinst = mysql::instance(); 
    $mysqlinst->dbconnect(Sys::Dbname);
    $process=new process_data();
    $field_data=Cfg::Page_fields;
    $field_array=explode(',',$field_data);  
    $table_array=check_data::return_posts(__METHOD__,__LINE__,__FILE__) ;#use all tables false=no skipping
    echo ' page table values are ';
    foreach ($table_array as $tablename){   
	   $q = "SELECT $field_data FROM ". $tablename . " where id=1";  
	   $r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); 
  
	 
	   
	     while ($rows=$mysqlinst->fetch_assoc($r,__LINE__,false)) {
			 for ($x=0; $x<count($field_array); $x++){
			    ${$field_array[$x]}=trim($rows[$field_array[$x]]);#creates variable with name and value of field;
			    echo  NL.$tablename .$field_array[$x].' = '. ${$field_array[$x]};
			    }
		  }//end while
	   }//end foreach
    
     $field_data=Cfg::Gallery_fields;
	$field_array=explode(',',$field_data);  
	$table_array= check_data::return_posts(__METHOD__,__LINE__,__FILE__) ;#use all tables false=no skipping
	echo 'gallery table values are ';
	foreach ($table_array as $tablename){   
		$q = "SELECT $field_data FROM ". $tablename;  
		$r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); 
	     while ($rows=$mysqlinst->fetch_assoc($r,__LINE__,false)) {
			 for ($x=0; $x<count($field_array); $x++){
			    ${$field_array[$x]}=trim($rows[$field_array[$x]]);#creates variable with name and value of field;
			    echo  NL. $tablename .$field_array[$x].' = '. ${$field_array[$x]};
			    }
		  }//endwhile
	   }//end foreach
    }//end print data


private function change_db($value,$field){//called by table_function
	$length=strlen($value);
	$value_arr=explode(',',$value);
	$count=count($value_arr);
	if ($count >10&&$length<100){
		echo NL.$value.' is value and field is '.$field;
		}
	}
 
function table_function($function,$data=false,$gall=false,$blog=false ){
     $mysqlinst = mysql::instance(); 
	$mysqlinst->dbconnect(Sys::Dbname);
	$process=new process_data();
	if ($data){
		echo NL. 'the data fields rendered val: '.NL;
		$field_data=Cfg::Page_fields;
		$field_array=explode(',',$field_data);  
		$table_array=check_data::return_pages(__METHOD__,__LINE__,__FILE__) ;#use all tables false=no skipping
		foreach ($table_array as $tablename){  
			echo NL.$tablename.NL;
			$q = "SELECT $field_data FROM ". $tablename . " where id=1";  
			$r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); 
			  while ($rows=$mysqlinst->fetch_assoc($r,__LINE__)){
				for ($x=0; $x<count($field_array); $x++){
					$value= $rows[$field_array[$x]];
					 $this->change_db($value,$field_array[$x]);	
					}
				}
			}//end foreach tablename for page data
		}
	if ($gall){    
		echo NL. 'the gallery fields rendered val: '.NL;
		$field_data=Cfg::Gallery_fields;
		$field_array=explode(',',$field_data);  
		$table_array=check_data::return_galleries(__METHOD__,__LINE__,__FILE__) ;#use all tables false=no skipping
		foreach ($table_array as $tablename){  
			echo NL.$tablename.NL;
			$q = "SELECT $field_data FROM $tablename";  
			$r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); 
			  while ($rows=$mysqlinst->fetch_assoc($r,__LINE__)){
				for ($x=0; $x<count($field_array); $x++){
					$value= $rows[$field_array[$x]];
					 $this->change_db($value,$field_array[$x]);	 
					}
				}
			}//end foreach tablename for page data
		}
	if($blog){
		echo NL. 'the blog fields rendered val: '.NL;
		print NL. 'blog fields'.NL;
		$field_data=Cfg::Post_fields;
		$field_array=explode(',',$field_data);  
		$table_array=check_data::return_posts(__METHOD__,__LINE__,__FILE__) ;#use all tables false=no skipping
		print_r($table_array);
		foreach ($table_array as $tablename){
			echo NL.$tablename.NL;
			$q = "SELECT $field_data FROM  $tablename";  
			$r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); 
			  while ($rows=$mysqlinst->fetch_assoc($r,__LINE__)){
				for ($x=0; $x<count($field_array); $x++){
					$value= $rows[$field_array[$x]];
					 $this->change_db($value,$field_array[$x]);	
					}
				}
			}//end foreach tablename for page data
		}
	} 
 
private function array_map_update($function){
	$update= 'SET ';
	$scrubbed = array_map(array($this,'syntax_checker'), $rows );  
	for ($x=0; $x<count($field_array); $x++){
		if (isset($scrubbed[$field_array[$x]])) {
			${$field_array[$x]}=$scrubbed[$field_array[$x]]; $update.=" {$field_array[$x]}='${$field_array[$x]}',";
			}
		}
	$update=substr_replace($update ,"",-1); 
	$q="UPDATE $tablename $update where pic_order='$pic_order'";
	return $q;
	}//end function


function highslide_create(){
chdir ('/var/www/trish/');
$valid_pic_ext='jpg,gif,png,jpeg';
$valid_pic_ext=explode(',',$valid_pic_ext);
$dir='thumbs400/';
$meddir='medimages800/';
 $dir = rtrim($dir, "/") ."/";  
	if (!$directory_handle = opendir($dir))exit ('$dir is not a directory');
	while (($file_handle = readdir($directory_handle)) !== false) {
		 if (($file_handle == '.') || ($file_handle== '..') )continue;
		$path_parts = pathinfo($file_handle);
		if ( isset($path_parts['extension'])){ #check etc
			if (!in_array(strtolower($path_parts['extension']),$valid_pic_ext))continue;
			}
		else continue;
		if (is_dir($file_handle))continue;

	$size	= GetImageSize($dir.$file_handle);
		$width			= $size[0];
		$height			= $size[1];
$style='';
echo '<a href="'.$meddir. $file_handle.'" class="highslide" onclick="return hs.expand(this)"><img class="border" '.$style.' src="'.$dir. $file_handle  . '" width="'. $width  . '" height="' . $height  . '" alt="image photo '.$file_handle.'" > </a><div class="highslide-caption"></div><div class="clear"></div><div class="hs_single""></div>'; 
	     
}
	}//end function


function backup_folder($dir,$backupdir) {
	static $count=0;
	$dir = rtrim($dir, "/") ."/";   
	$backupdir = rtrim($backupdir, "/") ."/";
	if ($directory_handle = opendir($dir)) {
		while (($file_handle = readdir($directory_handle)) !== false) { 
			 // Is the file in the ignore_file list
			//echo $file_handle;i
			$file_handle=strtolower($file_handle);
			$reject_folder=explode(',',Cfg::Exclude);
			$flag=false;
			foreach ($reject_folder as $reject){
				if (strtolower($file_handle) ==$reject){
					$flag=true;
					}
				}
				
			if($flag) continue;		
			//if (in_array($file_handle, $this->ignore_file)) {echo NL. 'ignored: '.$this->ignore_file;  
			//	continue;
			//	}
			//if (in_array($file_handle, $this->block_dir)) {    
			//	continue;
			//	}
			if (is_dir($dir. $file_handle)) { //echo NL. NL. "directory is ".$dir.$file_handle.NL; 
					//echo 'entered with '.$dir.$file_handle;
					(!is_dir($backupdir.$file_handle))&&file_generate::generate_folder($backupdir.$file_handle);
					 self::backup_folder($dir. $file_handle,$backupdir.$file_handle);
				}
			
			else if (!is_dir($backupdir)){    exit ('backupdir not found' . $backupdir);
				mkdir($backupdir,0770);
				}
			else if (!is_file($backupdir.$file_handle)){
				echo "copy $dir.$file_handle , $backupdir.$file_handle";
				if(!copy($dir.$file_handle,$backupdir.$file_handle)){ 
					rename($file_handle,substr($file_handle,0,30));
					echo "truncated $dir.$file_handle to ".$dir.substr($file_handle,0,30);
					if(!copy($dir.substr($file_handle,0,30),$dir.substr($file_handle,0,30))){
						echo NL. 'problem copying '. $dir.substr($file_handle,0,30);
						continue;
						}
					}
				self::$count_it++;
				echo NL. 'copied: '. $dir.$file_handle;
				continue;
				} 
			else if (filemtime($dir.$file_handle)==filemtime($backupdir.$file_handle))continue; 
			else if ( (filemtime($dir.$file_handle)>filemtime($backupdir.$file_handle))){
				$cont=false;
				if (strpos($file_handle,'.jpg')||strpos($file_handle,'.gif')||strpos($file_handle,'.png')){
					echo NL.'you have a pic file updated date modification that has not been recopied'. $dir.$file_handle;
					$cont=true;
					}
				if ($cont) continue;
				rename($backupdir.$file_handle,$backupdir.$file_handle. date('Y.m.d.H.i.s',filemtime($backupdir.$file_handle)) . '.bup');
				if(!copy($dir.$file_handle,$backupdir.$file_handle))
					echo NL.'problem backing up this file '.$dir.$file_handle;
				self::$count_it++;
				echo NL. 'copied- '.$dir. $file_handle;
				continue;
				}  
			//else if ($date1<$date2){
				// echo NL. '$date1=filemtime($dir.$file_handle)'; echo   $date1.$dir.$file_handle;
				// echo NL. '$date2=filemtime($backupdir.$file_handle)';echo  $date2.$backupdir.$file_handle; 
				//mail::alert('File backups error1', 'file_backup error');
				//}
			}
		}
	}
static function run_db_table_automate(){#run localhost/run_db_table_automate.php
	 
	$do_function="update_style";
	 self::master_db_tablename_pass($do_function,true,'keywords');
	return;
	$do_function="add_blog_style";
	self::master_db_tablename_pass($do_function,true,'blog_style');
	$do_function='add_dbfield3';
	self::master_db_tablename_pass($do_function,true,'keywords');

	}

function create_table($fields){	   
	$function='serialize';
$defunction='unserialize';
//$function='json_encode';
//$defunction='json_decode';
$tablename='directory';
$main_menu2=array( 
array('type'=>'master_gallery_dropdown','base'=>'index','name'=>'HOME'),
array('type'=>'single','base'=>'about','name'=>'ABOUT'),
array('type'=>'single','base'=>'events','name'=>'EVENTS'),
array('type'=>'single','base'=>'contact','name'=>'CONTACT') 
);
$fields=('id,pgMaster2table,nav2table,nav2pgMaster,gall_params,nav_menu1,nav_menu2,nav_menu3,nav_menu4,nav_menu6,nav_menu7,nav_menu8,nav_menu9,nav_menu10');

$fields=explode(',',$fields);
$main_menu=array();
$main_menu['dog']='cat';
$big=$fields;
$small=array($fields);
foreach ($fields as $val){
    $main_menu[]=$small;
    $small[]=$val;
    
}
 

//print_r($main_menu);  
  $menu=$function($main_menu);
 //print_r($main_menu); 
 //foreach ($menu as $item){print_r($item);}
 
 


function create_it($fields,$tablename){
    include_once('includes/Sys.php');
     $mysqlinst=mysql::instance();
     $mysqlinst->dbconnect();
    //$fields=('menu_cache,gallery_master,gallery_info,gallery_display_type,directory_array,home_table,table_to_page,nav1,nav2,nav3,nav4,nav5,nav6,nav7,nav8,nav9,nav10,nav11');
	 $fields=explode(',',$fields);
    $tablename='directory';
    $q="DROP TABLE IF EXISTS `$tablename`";
     $mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	
    $q="CREATE TABLE $tablename (";
	foreach ($fields as $field){
		$q.="
	`$field` text,";
		}
	$q=substr_replace($q,')',-1);
	$q.='
	 
	ENGINE=MyISAM DEFAULT CHARSET=utf8 ';
      $mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	
	}
$fields=('id,pgMaster2table,nav2table,nav2pgMaster,gall_params,nav_menu1,nav_menu2,nav_menu3,nav_menu4,nav_menu6,nav_menu7,nav_menu8,nav_menu9,nav_menu10');
 include_once('includes/Sys.php');   
create_it($fields,$tablename);
$mysqlinst=mysql::instance();
$r=$mysqlinst->dbconnect();

$menuesc=$mysqlinst->escape($menu);    
$q="insert into $tablename (id,nav_menu1) values (1,'$menu')";   
$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
 
$q='select id, nav_menu1 from '.Cfg::Dbn_nav.' where id=1';

	$mysqlinst=mysql::instance();
	$mysqlinst->dbconnect();
	$r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
     print 'begin retrival';
     while($row =$mysqlinst->fetch_row($r,__LINE__)){
	$val=$row[1];
     }
     echo NL.'done there'.NL;
     $menu2=stripslashes($val);
     echo NL.'menu1 '.$menu;
     echo NL.NL.'menu2 '.$menu2.NL.NL;
	$nav_array=$defunction($val);
     
     echo NL.'done there again'.NL;
	
     print_r($nav_array);
     print_r($defunction($menu2));
     if ($menu===$menu2)echo NL.'they are equal'; else echo NL.'they are unequal';
 foreach ($nav_array as $item){echo 'hello';print_r( $item);}
 
   
	}	  



}//end class 
#may be called by file_generator.php in /var/www   
#ALTER TABLE `about_blog1` CHANGE `blog_break` `blog_float` TINYTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL 
   
	    
	  # style47 in expandgalleryedit.php used to store the token so that pages affected updates! if all else fails...  can make a token field data...

	  
	   # nav3 is reserved for gallery tables list
	   #style50 is reserved for check_data::return_page_refs
	   //style 29 used to sidemenunav=>style29

 ?>