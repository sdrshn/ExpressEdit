<?php
/*
ExpressEdit is an integrated Theme Creation CMS
	Copyright (c) 2018  Brian Hayes expressedit.org  

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <https://www.gnu.org/licenses/>.*/
class global_master extends global_edit_master{
	protected $comment='Comment';//used to refer to comment or feedback 
	protected $directory_table=Cfg::Dbn_nav;
	protected $master_col_table=Cfg::Columns_table;
	protected $master_page_table=Cfg::Master_page_table;//this can be subbed out for displaying backup pages
	protected $master_post_css_table=Cfg::Master_post_css_table;//this can be subbed out for displaying backup pages
	protected $master_post_table=Cfg::Master_post_table;//this can be subbed out for displaying backup pages
	protected $master_gall_table=Cfg::Master_gall_table;//this can be subbed out for displaying backup pages
	protected $master_col_css_table=Cfg::Master_col_css_table;//this can be subbed out for displaying backup pages
	protected $master_post_data_table=Cfg::Master_post_data_table;
	protected $rwd_post=false;
	protected $rwd_enabled=false;//has the rwd grid been enabled in present column
	protected $column_grid_css_arr=array();
	protected $comment_table='comments';
	protected $login_forum=false; //set to true to  provide security for a forum pages  ie forum_master.class.php
	protected $locked_pages=false;//set to true in site_master.class.php to provide security for whole site or specify for a particlar page ie about_master.class.php
	protected $meta_data=true;//show meta_data: false for karma article page.
	protected $blog_date_on=0;  
	protected $edit_font_size=Cfg::Edit_font_size;
	protected $edit_font_family=Cfg::Edit_font_family;
	protected $header_style='';
	protected $header_script='docReady.js';
	protected $header_script_function='onload,gen_Proc,imgSizer,autoShow,fadeTo';  //outscript for normal page
	protected $header_edit_script_function='onload_edit,edit_Proc'; //scripts for edit pageprotected $tablename='contact';
	protected $header_edit_script='jscolor.js,tool-man/core.js,tool-man/events.js,tool-man/css.js,tool-man/coordinates.js,tool-man/drag.js,tool-man/dragsort.js'; //outsidescript for edit page
	protected $header_include='';
	protected $onload='';
	protected $edit_onload='';#other copies of edit onload in gallery master addgallerypiccore add page pic core add video
	protected $roots=Cfg_loc::Localroot_dir;// so test sites render new css etc.  in local root dir  this is antiquated
	protected $css_suffix='';// allows testing with second set of css
	protected $onsubmit='onSubmit="return edit_Proc.beforeSubmit()"';
	protected $form_load='';
	protected $at_fonts=array();//initialized for @fonts css construction...
	protected $editcss='';//initializes all editcss
	protected $css='';//initializes all page 
	protected $sitecss='';
	protected $imagecss='';//initialize build image css
	protected $navcss='';//initializes all page css
	protected $initcss='';//initializes all page css
	protected $highslidecss='';//initializes all page css
	protected $mediacss='';
	protected $advancedmediacss='';
	protected $success='';
	protected $message='';
	protected $field_data=Cfg::Page_fields;
	protected $append_script='';
	protected $gallery_global=false;
	protected $users_record=false;
	protected $echo_eob='';#concate echo for end of body rendering... 
	protected $header_type='html5_header.php';
	protected $text_box_javascript=false;
	protected $editer_on=true; #halt the main editor
	protected $editor_message='';
	protected $cookie_count='0';
	protected $cookie_date='0';  
	protected $cookie_reference='0';
	protected $session_log_count=0;
	protected $session_log_id=0; 
	protected $browser_info=false;
	protected $browser_active=true;
	protected $px=16;
	protected $clone_ext=''; //initialize
	private $redirect_exclude='';
	private $redirect_exclude_strpos=''; 
	protected $highslide_show_control='false';
	protected $column_level=0;
	static protected $pluscount=0;
	static protected $plusmod=0;
	static protected $show_more=0;
	protected  $col_child_table='';
	protected  $redAlert=Cfg::RedAlert_color;
     protected  $brown=Cfg::Brown_color;
	protected  $maroon=Cfg::Maroon_color;
	protected  $cherry=Cfg::Cherry_color;
	protected  $yellow=Cfg::Yellow_color;
	protected  $aqua=Cfg::Aqua_color;
	protected  $magenta=Cfg::Magenta_color;
	protected  $brightgreen=Cfg::Brightgreen_color;
	protected  $orange=Cfg::Orange_color;
	protected  $pos=Cfg::Pos_color;
	protected  $info=Cfg::Info_color;
	protected  $ekblue=Cfg::Ek_blue_color;
	protected  $blue=Cfg::Blue_color;
	protected  $navy=Cfg::Navy_color;
     protected  $white=Cfg::White_color;
     protected  $black=Cfg::Black_color;
     protected  $green=Cfg::Green_color;
	protected  $purple=Cfg::Purple_color;
	protected $darkgrey='a9a9a9';
	protected $darkkhaki='bdb76b';
	protected $darkmagenta='8b008b';
	protected $darkolivegreen='556b2f';
	protected $darkorange='ff8c00';
	protected $darkorchid='9932cc';
	protected $darkred='8b0000';
	protected $darksalmon='e9967a';
	protected $darkseagreen='8fbc8f';
	protected $darkslateblue='483d8b';
	protected $darkslategray='2f4f4f'; 
	protected $darkturquoise='00ced1';
	protected $darkviolet='9400d3';
	protected $deeppink='ff1493';
	protected $deepskyblue='00bfff';
	protected $dimgray='696969';
	protected $dimgrey='696969';
	protected $dodgerblue='1e90ff';
	protected $firebrick='b22222';
	protected $floralwhite='fffaf0';
	protected $forestgreen='228b22';
	protected $fuchsia='ff00ff';
	protected $gainsboro='dcdcdc';
	protected $moccasin='ffe4b5';
	protected $navajowhite='ffdead'; 
	protected $oldlace='fdf5e6';
	protected $olive='808000';
	protected $olivedrab='6b8e23'; 
	protected $orangered='ff4500';
	protected $orchid='da70d6';
	protected $palegoldenrod='eee8aa';
	protected $palegreen='98fb98';
	protected $paleturquoise='afeeee';
	protected $palevioletred='d87093';
	protected $papayawhip='ffefd5';
	protected $peachpuff='ffdab9';
	protected $peru='cd853f';
	protected $plum='dda0dd';
	protected $powderblue='b0e0e6'; 
	protected $rosybrown='bc8f8f';
	protected $royalblue='4169e1';
	protected $saddlebrown='8b4513';
	protected $salmon='fa8072';
	protected $sandybrown='f4a460';
	protected $seagreen='2e8b57'; 
	protected $block_style=false;//if padding etc. too excessive  blocks rendering
	protected $page_pic_quality=95;
	protected $next_image='photonav_next2.gif';
	protected $hover_image=85;#percentage in the field for vert position with 100 being bottom
	protected $editor_background='#fff';
	protected $editor_color='#000';
	protected $thumnail_pad_right=5;
	protected $main_top=45;
	protected $prevnext_top=190;# probably set in local height of div wrapping for cursor 
	protected $previous_image='photonav_prev2.gif';
	private static $instance=false; //store instance
	protected $main_menu_check=array();
	protected $rem='rem';//css style unit
	protected $blog_id='null';//set default
	protected $post_target_clone_column_id='000';
	protected $blog_unstatus='null';
	protected $viewport_current_width='';
	protected $column_clone_status_arr=array();
	protected $page_stylesheet_inc=array();//used to include all cloned page styles
	//protected $backup_page_arr=array();//backuping up pages which have cloned version of changes Not used anymore
	protected $is_clone=false;//initialize
	protected $preload='';
	protected $page_images_arr=array();//hold current page_images_dir images and quality info
	protected $page_images_expanded_arr=array();//hold current page_images_expanded_dir images and quality info
	protected $auto_slide_arr=array();//hold current auto_slide_dir images and quality info
	protected $large_images_arr=array();//hold current gallery large_image_dir images and quality info
	protected $css_view=array(); 
	
function temp(){
	
	if (!$this->edit&&Sys::Web&&strpos(Sys::Self,'express_video')!==false){
		mail('info@expressedit.org','Entered Express Video','Video Express Alert');mail::alert('Entered Express Video','Video Express Alert'); } 
	return;
	 
 $q="update $this->master_post_table as c, $this->master_col_table as p set c.blog_grid_width=p.col_grid_width,c.blog_gridspace_right=p.col_gridspace_right,c.blog_gridspace_left=p.col_gridspace_left where c.blog_data1=p.col_id and c.blog_type='nested_column'";
   //$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);  
   	 echo $q; exit();
	
	
	return;
 $q="update $this->master_post_table as p, $this->master_post_table as g set p.blog_grid_width=g.blog_grid_class where p.blog_id=g.blog_id";
   $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);  
   	

	
 return;
 $q="update $this->master_post_data_table as p, $this->master_gall_table as g set p.blog_tiny_data4=g.imagetitle,p.blog_tiny_data5=g.subtitle where p.blog_data1=g.master_gall_ref ";
   $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);  
   	
	echo $q;   exit();

return;
	 $q="update $this->master_post_data_table as p, $this->master_gall_table as g set p.blog_data1=g.gall_ref where p.blog_table_base=g.gall_table and g.pic_order=1";
   $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);  
   	
	echo $q;
	return;
	$q="select distinct gall_table from $this->master_gall_table where master_gall_status=''";
	$r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	$garr=array();
	while (list($page_ref) = $this->mysqlinst->fetch_row($r,__LINE__)){
		$newpage_ref=process_data::clean_filename($page_ref);
		$where=" where page_ref='$newpage_ref'";
		$count=$this->mysqlinst->count_field($this->master_page_table,'page_id','',false,$where);
		if ($count >0 ){
			printer::alert_neg("NL. page ref $page_ref already created");
			continue;
			}
		echo NL." trying $page_ref ";
		$_POST['create_page']=$page_ref;
		$_POST['use_newpage_ref']='events';
		$this->add_new_page(true);
		}
	exit('done'); 
	
	return;
	$q="select blog_id,blog_table,blog_col from $this->master_post_table where blog_type='nested_column' and blog_table_base='$this->tablename'";
	$temp=$this->mysqlinst->query($q);
	
	while(list($blog_id,$blog_table,$blog_col)=$this->mysqlinst->fetch_row($temp)){ 
		$arr=explode('post_id',$blog_table);
		if (count($arr)!==2){
			printer::alert_neg("blog id $blog_id has table $blog_table");
			}
		else {
			if ($blog_col !==$arr[1]){
				$q="update $this->master_post_table set blog_col='{$arr[1]}' where blog_id=$blog_id";
				$this->mysqlinst->query($q);
				printer::alert_pos("blog_col was $blog_col and now updating with $q");
				}
			else printer::alert_pos("No changes ncess with $blog_id");
			}
		}//end while
	}//end temp
#__con	
function __construct($edit=false,  $return=false){
	if($return)return;
	//echo Sys::Dbname." is sys dbname";
	// printer::vert_print($_POST);
	$this->viewport_current_width=process_data::get_viewport();
	$this->color_arr_long=explode(',',Cfg::Light_editor_color_order);//default value
	$this->deltatime=time::instance(); $this->deltatime->delta_log('global construct delta'); 
	$this->column_width_array[0]='body'; 
	$this->edit=($edit=='edit')?true:$edit;// this is set in editpages for each web page individually....
	$this->ext=request::check_request_ext();  
	$this->page_initiate();    
	#****** Require login for  editsites and restricted  access ie.   display_user_db.php   display/    file_gen.php 
	if ((Sys::Web||(Sys::Loc&&Cfg::Local_login))&&(($this->edit&&!Sys::Pass_class)||Sys::Check_restricted)){//this is always on for security for editpages and other restricted utilities such as file_gen.php and display user pages see (Sys.php)
#logged_in #login
		new secure_login('ownerAdmin',false); //for access to editpages  
		}  
	$this->css_suffix=$this->passclass_ext=(Sys::Pass_class)?Cfg::Temp_ext:'';		 
	if ($this->edit && (isset($_POST['page_restore_view'])&&!empty($_POST['page_restore_view']))||(isset($_SESSION[Cfg::Owner.'db_to_restore'])&&isset($_GET['page_restore_dbopt'])))$this->db_backup_restore();
		
	$this->ajax_check();   
	(Sys::Onsubmitoff)&&$this->onsubmit='';
	 
	#*************  End Restrict Access
	
	if ($this->edit)$_SESSION[Cfg::Owner.'editmode']=1;//prevents pages from cacheing if cacheing were on also this session created when logged in or by request
	  
	if($edit==='return'){#class object invoked for global_function access only  by add_gallery utility
		$this->edit='return';
		return;
		}
	if (isset($_GET['xpzawn2'])){//this is a ajax response request to get accumulate further browser information from user see browser info();
		$this->browser_info();
		exit();
		}
	$indexes=explode(',',Cfg::Page_options);
	foreach($indexes as $key =>$index){
		if (!empty($index)) {
			$this->{$index.'_index'}=$key;  
			}
		}
	$backindexes=explode(',',Cfg::Column_options);
	foreach($backindexes as $key =>$index){   
		$this->{$index.'_index'}=$key;
		}
	$indexes=explode(',',Cfg::Style_functions );
	foreach($indexes as $key =>$index){
		if (!empty($index)) {
			$this->{$index.'_index'}=$key;
			  //print NL.  $index." = $key"; 
			}
		}
	
	$indexes=explode(',',Cfg::Blog_options);
	foreach($indexes as $key =>$index){
		if (!empty($index)) {
			$this->{$index.'_index'}=$key;  
			}
		}  
	$indexes=explode(',',Cfg::Style_functions );
	foreach($indexes as $key =>$index){
		if (!empty($index)) {
			$this->{$index.'_index'}=$key;
			 // print NL.  $index." = $key"; 
			}
		}
	$indexes=explode(',',Cfg::Alt_rwd_options);
	foreach($indexes as $key =>$index){
		if (!empty($index)) {
			$this->{$index.'_index'}=$key;
			 // print NL.  $index." = $key"; 
			}
		}
	$indexes=explode(',',Cfg::Box_shadow_options );
	foreach($indexes as $key =>$index){
		if (!empty($index)) {
			$this->{$index.'_index'}=$key;
			 // print NL.  $index." = $key"; 
			}
		}
	$this->col_field_arr_all=explode(',',Cfg::Col_fields_all);
	$this->col_field_arr=explode(',',Cfg::Col_fields); 
	if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);  
	store::setVar('backup_clone_refresh_cancel',false);
	#buffer    ||($this->edit&&Sys::Pass_class)
	((!Sys::Debug&&!Sys::Refreshoff&&(isset($_POST['submit'])||Sys::Bufferoutput))||isset($_GET['advanced'])||isset($_GET['advancedoff']))&&ob_start(); 
	if (Sys::Debug||Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__); 
	$this->set_cookie(); 
	$this->deltatime->delta_log('page initiate');
	
	$this->temp();  
	if ($this->edit){  
	$this->edit_script();
	   }	
	else {
	    // $this->request_redirect_check();
		$this->page_script();   
		}
	}//end __construct
	
function db_backup_restore(){//const View_db='viewbackupdb';
	#so here we are either using page_restore view to populate viewdb for viewing or  we are going to restore the present databse with the backup (page_restore_dbopt)
		if (isset($_POST['page_restore_view'])){  
		    list($fname,$time)=explode('@@',$_POST['page_restore_view']);
		    $dbname=Cfg::View_db;
		    }
		else if(isset($_GET['page_restore_dbopt'])){
			if (!empty($_GET['page_restore_dbopt'])) //direct
				list($fname,$time)=explode('@@',$_GET['page_restore_dbopt']);
			else {
				list($fname,$time)=explode('@@',$_SESSION[Cfg::Owner.'db_to_restore']);//from viewpages first
				unset($_SESSION[Cfg::Owner.'db_to_restore']);
				}
			$dbname=Cfg::Dbname;
			
			}
		$bfile=str_replace('.gz','',$fname);
		$fullpathfile=Sys::Home_pub.Cfg::Backup_dir.$bfile;
		$flag=false;
		if (is_file(Sys::Home_pub.Cfg::Backup_dir.$bfile)){
			$cmd1='';
			$flag=true;
			}
		elseif (is_file(Sys::Home_pub.Cfg::Backup_dir.$fname)){ 
			$cmd1='gunzip -k '.Sys::Home_pub.Cfg::Backup_dir.$fname.';';
			//$bfile=process_data::gunzip(Sys::Home_pub. Cfg::Backup_dir.$fname); php unzip response not doing it
			$flag=true;
			
			}
			
		if ($flag){
			$host=Cfg::Dbhost;
			$user=Cfg::Dbuser;
			$pass=Cfg::Dbpass; 
			$cmd2=Sys::Mysqlserver.'mysql  -h'.$host.' -u'.$user.' -p'.$pass.' '. $dbname.'  < '.$fullpathfile.';';
			
			system($cmd1. $cmd2);
			echo printer::print_info(NL.'View DB system() populated');
			if(isset($_GET['page_restore_dbopt'])){
				$this->backupinst->backupdb(Sys::Dbname,'',$time,$fname);
				$msg='Chosen Db was restored: '.$fname;
				printer::alert_pos($msg);
				}
			else {
				$_SESSION[Cfg::Owner.'viewdb']=true;
				$this->success[]='Db View initated from '.$this->get_time_ago($time);
				$_SESSION[Cfg::Owner.'db_to_restore']=$_POST['page_restore_view'];
				}
			}
		else $this->message[]='Problem with Backup restore fullfilepath of '.$fullpathfile.' in '.__METHOD__.__LINE__;	 
	}//end db_backup_restore
		
function page_populate_options(){
	if (empty($this->page_options)){ 
			$this->page_options=array();
			 for ($i=0; $i<count(explode(',',Cfg::Page_options));$i++){ 
				$this->page_options[$i]=0;
				}
			}
	else	{   
		$this->page_options=explode(',',$this->page_options);
		for ($i=0; $i<count(explode(',',Cfg::Page_options));$i++){ 
			if (!array_key_exists($i,$this->page_options)){
				$this->page_options[$i]=0;
				} 
			}
		}
	}

function page_initiate(){ if (Sys::Debug) Sys::Debug(__LINE__,__FILE__,__METHOD__); if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
 	$this->alert=array();
	$this->instruct=array();
	$this->message = array();
	$this->success=array();
	$this->session_initiate();
	$this->db_initiate();
	$this->mysqlinst->dbconnect(Sys::Dbname);
	$this->mail_initiate(); 
	$this->navigation_initiate();
	$this->storeinst=store::instance();
	($this->edit)&&$this->backup_initiate();
	$this->page_images_arr[$this->tablename]=array(); 
	$this->page_images_expanded_arr[$this->tablename]=array();
	$this->auto_slide_arr[$this->tablename]=array();// 
	$this->large_images_arr[$this->tablename]=array(); 
	}
	
function update_sort_list($no,$big){
	$img_arr=array();
	$sort_arr=explode('|',$no);
	foreach ($sort_arr as $e){
		$img_arr[]=explode('!@!',$e)[1];
		}
	$sorted=implode(',',$img_arr);
	if (strpos($big,'page')!==false){
		$big=str_replace('page','',$big);
		$q="update $this->master_page_table set page_data1='$sorted' where page_id='$big'"; 
		}
	else $q="update $this->master_post_table set  blog_data1='$sorted' where  blog_id='$big'";   
	$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	if (!$this->mysqlinst->affected_rows())return false;
	return true;
	}
function update_gall_list($no,$big){ 
	$img_arr=array();
	$sort_arr=explode('|',$no);
	$x=1;
	foreach ($sort_arr as $e){
		$img_arr=explode('!@!',$e);
		$q="update $this->master_gall_table set gall_time='".time()."',token='".mt_rand(1,mt_getrandmax())."',pic_order='".$x."' where pic_id=".$img_arr[1]; 
		$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);  
		$x++;
		}
	}

function update_editor_color_list($no){ 
	$img_arr=array();
	$sort_arr=explode('|',$no);
	$color_list='';
	$x=0;
	foreach ($sort_arr as $e){
		$new_arr=explode('!@!',$e);
		$color_list.=$new_arr[1].',';
		$x++;
		}
	
	$editor_ref=strtolower($new_arr[2]);
	$color_list=substr_replace($color_list,'',-1);
	$q="update $this->master_page_table set page_{$editor_ref}_editor_order='$color_list' where page_ref='$this->tablename'";
	$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	process_data::write_to_file('testthis.txt',$q,true);
	}
function get_image_list($gall_ref,$re_id){
	$q="select picname from $this->master_gall_table where gall_ref='$gall_ref'";
	$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	$return='<p class="editcolor editbackground">Choose an Image from your selected gallery to represent this gallery in the Gallery Link Page:</p>';
	$return.= '<div class="editcolor editbackground"><!--Image Select Wrap-->';
	While ($rows=$this->mysqlinst->fetch_row($r)){
	 	$return.= '<p class="floatleft"><input type="radio" name="gallref_image_choice['.$re_id.']" value="'.$rows[0].'"><img src="'.Cfg_loc::Root_dir.Cfg::Small_thumb_dir.$rows[0].'" width="150"></p>';
		}
	$return.='
	</div><!--Image Select Wrap-->';
	return $return;
	}
function display_image_list($gall_ref){
	$q="select picname from $this->master_gall_table where gall_ref='$gall_ref'";
	$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	 
	$return= '<div class="editcolor editbackground"><!--Image Select Wrap-->
	 <p><br></p>
	<p style="padding-top:10px;">Images Within this Gallery Choice:<br></p>';
	if ($this->mysqlinst->affected_rows()){
		While ($rows=$this->mysqlinst->fetch_row($r)){
			$return.= '<p class="floatleft pt10 pl10"><img src="'.Cfg_loc::Root_dir.Cfg::Small_thumb_dir.$rows[0].'" height="50"></p>';
			}
		}//affected
	else $return.="This gallery is Empty";
	$return.=' 
	<p class="clear"></p> <p class="smallest floatleft">Submit Gallery Change using any Change Button</p>
	</div><!--Image Select Wrap-->';
	return $return;
	}	
function iframe_list_gen($pages){
	$pages=explode(',',$pages);
	$frames='';
	if(isset($_SESSION[Cfg::Owner.'page_update_clones']))unset($_SESSION[Cfg::Owner.'page_update_clones']);
	foreach ($pages as $page){ 
		$frames.=file_generate::render_backup_iframe($page.'.php',500,400,'visible','px','px',true);
		}
	return $frames;	
	}

function gen_display_styles($data){
	$arr=explode('@@',$data);
	//'.$type.'@@'.$id.'@@'.$field
	
	$field=$arr[2];
	$id=$arr[1];
	switch($arr[0]){
		case 'page' :
			$table=$this->master_page_table;
			$ref='page_id';
			break;
		case 'col':
			$table=$this->master_col_table;
			$ref='col_id';
			break;
		case 'blog':
			$table=$this->master_post_table;
			$ref='blog_id';
			break;
		default: return $data;
		}
	$q="select $field from $table where $ref='$id'";
	$r=$this->mysqlinst->query($q);
	if ($this->mysqlinst->affected_rows()){
		list($styles)=$this->mysqlinst->fetch_row($r);
		}
	else return "No Styles found";
	$style_array=explode(',',$styles);
	$indexes=explode(',',Cfg::Style_functions);
	foreach($indexes as $key =>$index){ 
		if (!empty($index)) {
			${$index.'_index'}=$key; 
			}
		}
	
	$return=printer::alertx('<div class="Os3darkslategray fd2brightgreen editbackground editcolor editfont">',1);
	for ($i=0; $i < count($indexes); $i++){
		if ($indexes[$i]==='background')continue;
		if ($indexes[$i]==='custom_style')continue;
		if (array_key_exists($i,$style_array))$return.=printer::alertx( NL."{$indexes[$i]} value: {$style_array[$i]}",1);
		else $return.=printer::alertx( NL."{$indexes[$i]} value: 0 ",1);
		}
	#####################################################################
	if(!array_key_exists($custom_style_index,$style_array)){
		printer::alertx('Custom Styles: value: 0 ',1); 
		}
	else {
		$custom_style=$style_array[$custom_style_index];
		if (!empty($custom_style)&&$this->isSerialized($custom_style)){ 
		
			$media_added_style_arr=unserialize($custom_style);//for correct storage in style field value..
			$count=count($media_added_style_arr);
			}
		else {
			$count=0;
			$media_added_style_arr=array();
			}
		foreach ($media_added_style_arr as $index => $array){//$array[1]=str_replace('<br>',"\n",str_replace('=>',',',$array[1]));
			$class_suffix=(array_key_exists($index,$media_added_style_arr)&&array_key_exists(0,$media_added_style_arr[$index])&&strlen($array[0])>1&&!is_numeric($array[0]))?str_replace('=>',',',$array[0]):'';
			$customcss=(array_key_exists($index,$media_added_style_arr)&&array_key_exists(1,$media_added_style_arr[$index]))?str_replace('<br>',"\n",str_replace('=>',',',$array[1])):'';
			$media_maxpx=(array_key_exists($index,$media_added_style_arr)&&array_key_exists(2,$media_added_style_arr[$index])&&$media_added_style_arr[$index][2]>199&&$media_added_style_arr[$index][2]<2001)?$media_added_style_arr[$index][2]:'';
			$media_minpx=(array_key_exists($index,$media_added_style_arr)&&array_key_exists(3,$media_added_style_arr[$index])&&$media_added_style_arr[$index][3]>199&&$media_added_style_arr[$index][3]<3001)?$media_added_style_arr[$index][3]:'';
			$data=str_replace('=>',',',str_replace('break',"\n",$array[1]));//for correct storage in style field value..
			$return.=  '<br><br>Custom Css Advanced Style: <br>';
		
			if (empty($media_minpx)&&empty($media_maxpx)){ 
				$return.= 'extension: '.$class_suffix.' Rules: { '.$data.'}';
				}
			elseif (!empty($media_minpx)&&!empty($media_maxpx)) {
				$return.= '
				@media screen and (max-width:'.$media_maxpx.'px) and (min-width:'.$media_minpx.'px){<br>
					Extension: '. $class_suffix.'<br>Rule: '.$class_suffix.'{'.$data.'}
					}
					';
				}
			elseif (!empty($media_maxpx)){
				$return.='
				@media screen and (max-width: '.$media_maxpx.'px){<br>  	
					Extension: '. $class_suffix.'<br>Rule: '.$class_suffix.'{'.$data.'}
				}';
				}
			else {
				$return.='
				@media screen and (min-width: '.$media_minpx.'px){<br>  	
					Extension: '. $class_suffix.' <br>Rule: '.$class_suffix.'{'.$data.'}
				}';
				} 
			}//end foreach css
		}
		
		
		
	###################################
	$return.='<br><br>Background Styles:';
	$background_styles=explode(',',Cfg::Background_styles);
	if(!array_key_exists($background_index,$style_array)){
		printer::alertx('Background: value: 0 ',1);
		return $return;
		}
		
	$background_value_array=explode('@@',$style_array[$background_index]);
	
	for ($i=0; $i<count($background_styles); $i++){ 
		if (array_key_exists($i,$background_value_array))$return.=printer::alertx(NL."{$background_styles[$i]} value: {$background_value_array[$i]}",1);
		else$return.=printer::alertx(NL."{$background_styles[$i]} value: 0",1);
		}
 	foreach($background_styles as $key =>$index){
		if (!empty($index)) {
			${$index.'_index'}=$key;
			   //print NL.  $index." = $key"; 
			}
		}
		
	$return.=printer::alertx(NL.NL.
	'<img src="'.Cfg_loc::Root_dir.Cfg::Background_image_dir.$background_value_array[$background_image_index].'"  width="75">',1);
	$return.=printer::alertx($background_value_array[$background_image_index].'</div>',1);
	return $return;
	}// function style display
#ajax
function gen_check_clones($id){
	$q="select col_table_base from $this->master_col_table where col_status='clone' and col_clone_target='$id'";
	$r=$this->mysqlinst->query($q);
	$array=array();
	$return='<p class="redAlertbackground white">The following Page References Have Clones of This column:</p>';
	if ($this->mysqlinst->affected_rows()){
		while (list($col_table_base) = $this->mysqlinst->fetch_row($r,__LINE__)){
			$return.='<p class="posbackground white">'.$col_table_base.'</p>';
			}
		return $return;
		}
	else return "No Pages Have Clones of This column ";
	}
function get_time_ago( $time )
{
    $time_difference = time() - $time;

    if( $time_difference < 1 ) { return 'less than 1 second ago'; }
    $condition = array( 12 * 30 * 24 * 60 * 60 =>  'year',
                30 * 24 * 60 * 60       =>  'month',
                24 * 60 * 60            =>  'day',
                60 * 60                 =>  'hour',
                60                      =>  'minute',
                1                       =>  'second'
    );

    foreach( $condition as $secs => $str )
    {
        $d = $time_difference / $secs;

        if( $d >= 1 )
        {
            $t = round($d,1);
            return  $t . ' ' . $str . ( $t > 1 ? 's' : '' ) . ' ago';
        }
    }
}
function display_backups(){
	$q='select backup_filename,backup_date,backup_time,backup_restore_time,backup_data1 from '.Cfg::Backups_table.' order by backup_time desc';
	$r=$this->mysqlinst->query($q);
	process_data::write_to_file('ajax_mysql',$q,true);
	$color='EBFCEE'; 
	$return='<div  class="Os3darkslategray fsminfo black editbackground small left"><span class="warn">Selecting a restore file will negate any current edits you have made</span><br><br><span class="tip">First Restore File is Present State of Website</span><br><br><div style="padding-left:10px;padding-bottom:10px;color:black; background:#'.$color.'"><input type="radio" name="page_restore_view" value="">None<br></div>';
	$color='EBFCEE';
	if ($this->mysqlinst->affected_rows()){
		while (list($fname,$date,$time,$restoredate,$restorefname) = $this->mysqlinst->fetch_row($r,__LINE__)){
			
			 if (!is_file(Cfg_loc::Root_dir.Cfg::Backup_dir.$fname))continue;
			$data=file_get_contents(Cfg_loc::Root_dir.Cfg::Backup_dir.$fname);
			if (strpos($data,Cfg::Backups_table)!==false){
				$return.=printer::alert_neg('Omitted file: '.$fname.' contain table: '.Cfg::Backups_table.' and would overwrite backups','.8',1);
				continue;
				}
			$color=($color==='E9E9FC')?'EBFCEE':'E9E9FC';
			$restime=(!empty($restoredate))?'<p class="fs2npred">Restored file orig from '.date("dMY-H-i-s",$restoredate).'  Orig filename: '.$restorefname.'</p>':'';
			$return.='<div style="padding:10px;color:black; background:#'.$color.'"><input type="radio" name="page_restore_view" value="'.$fname.'@@'.$time.'">TimeAgo: '.$this->get_time_ago($time).'&nbsp; Date: '.$date.'&nbsp;Filename: '.$fname.'&nbsp; Size: '.(filesize(Cfg_loc::Root_dir.Cfg::Backup_dir.$fname)/1000).'Kb'.$restime.'</div>';
			}
		$return.='</div>';
		return $return;
		}
	else return "No Backup files found $q";
	}
	
function ajax_check(){
	(Sys::Deltatime)&&$this->deltatime->delta_log(__line__.' @ '.__method__.'  '); 
	if ($this->edit&&isset($_GET['check_clones'],$_GET['check_id'])){   
		$json_arr=array();    
		$json_arr[]=$_GET['check_id']; 
		$json_arr[]=$this->gen_check_clones($_GET['check_clones']);
		echo json_encode($json_arr); 
		exit(); 
		}
	if ($this->edit&&isset($_GET['display_backups'])){   
		$json_arr=array();    
		$json_arr[]='display_backupst'; 
		$json_arr[]=$this->display_backups();
		$json_arr[]='passfunct';
		$json_arr[]='fullWidth';
		$json_arr[]='display_backups@x@full@x@';
		echo json_encode($json_arr); 
		exit(); 
		}
	if ($this->edit&&isset($_GET['display_styles'],$_GET['display_id'])){   
		$json_arr=array();    
		$json_arr[]=$_GET['display_id']; 
		$json_arr[]=$this->gen_display_styles($_GET['display_styles']);
		echo json_encode($json_arr); 
		exit(); 
		}
	if ($this->edit&&isset($_GET['iframe_gen'],$_GET['pages'])){   
		$json_arr=array();   
		$json_arr[]='page_iframe_contain'; 
		$json_arr[]=$this->iframe_list_gen($_GET['pages']);
		$json_arr[]='page_mirror_update';
		$json_arr[]='<span class="floatleft Os5pos fd5pos">No problem to continue editing on this page below. These iframe(s) are updating the mirrored, rwd tuned, etc.  pages</span>';
		echo json_encode($json_arr);
		
		exit(); 
		}
	if ($this->edit&&isset($_GET['imageSelectGallery'])){   
		$json_arr=array();
		$arr=explode('@@',$_GET['imageSelectGallery']);
		$json_arr[]=$arr[1]; 
		$json_arr[]=$this->display_image_list($arr[0]);
		echo json_encode($json_arr);
		exit(); 
		}	
	if ($this->edit&&isset($_GET['imageChoiceMaster'])){   
		$json_arr=array();
		$arr=explode('@@',$_GET['imageChoiceMaster']);
		$json_arr[]=$arr[2]; 
		$json_arr[]=$this->get_image_list($arr[0],$arr[1]);
		echo json_encode($json_arr);
		exit(); 
		}
	if ($this->edit&&isset($_GET['toggle_class_reload'])){ 
		$json_arr=array();
		$arr=explode('@@',$_GET['toggle_class_reload']);
		$q="update $this->master_post_table set blog_data1='".$arr[2]."' where blog_id='".$arr[1]."'";
		$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
		 
		 
		$data=str_replace('_blog_text','',$arr[0]);
		$url=Sys::Self.'?#'.$data;
		$json_arr[]='passfunct';
		$json_arr[]='locationAssign';
		$json_arr[]=$url; 
		echo json_encode($json_arr);
		exit(); 
		}
	if (Sys::Get_token&&isset($_GET['create_image'])){ //create missing slide images etc
		$json_arr=array();
		$arr=explode('@@',$_GET['create_image']);
		$this->resize($arr[0],$arr[1],0,0,Cfg_loc::Root_dir.Cfg::Upload_dir,$arr[2]); 
		//echo json_encode($json_arr);
		exit(); 
		}
	if (Sys::Get_token&&isset($_GET['create_image2'])){// create missing from js imageResponse images etc
		$json_arr=array();
		$arr=explode('@@',$_GET['create_image2']);
		$path_parts=pathinfo($arr[0]);
		$picname=$path_parts['basename'];
		$dirname=$path_parts['dirname'];
		$dirarr=array(Cfg::Page_images_dir,Cfg::Large_image_dir); //parse filename of img.src provided missing image
		foreach ($dirarr as $dir){
			if (strpos($dirname,$dir)!==false){
				$dirname=substr($dirname,strpos($dirname,$dir),strlen($dirname));
				break;
				}
			}
		image::image_resize($picname,$arr[1],0,0,Cfg_loc::Root_dir.Cfg::Upload_dir,$dirname); 
		mail::info("Msg Only No further xml response:  javascript image resize message:$dirname $picname");
		exit(); 
		}
	 
	if (isset($_GET['gall_ref'],$_GET['pic_order'],$_GET['clone_ref'],$_GET['transition'])){//normal navigation for editpages 
		$expand=expandgallery::instance(); 
		$expand->gall_ref=$_GET['gall_ref'];
		$expand->clone=$_GET['clone_ref']; 
		$expand->transition=$_GET['transition'];
		$expand->page_source=false; 
		$expand->pic_order=$_GET['pic_order'];
		$expand->navigated=true;   
		$expand->pre_render_data();
		exit();
		}
	if ($this->edit&&isset($_GET['auto_sort'])){   
		$json_arr=array();
		$arr=explode('@@',$_GET['auto_sort']);
		$msgreturn=$this->update_sort_list($arr[0],$arr[1]);
		$msg=($msgreturn)?$arr[3]:'';
		$json_arr[]=$arr[2]; 
		$json_arr[]=$msg;
		echo json_encode($json_arr);
		exit(); 
		}	  
	if ($this->edit&&isset($_GET['gall_sort'])){   
		$json_arr=array();
		$arr=explode('@@',$_GET['gall_sort']);
		$this->update_gall_list($arr[0],$arr[1]);
		$json_arr[]=$arr[2]; 
		$json_arr[]=$arr[3];
		echo json_encode($json_arr);
		exit(); 
		}
	if ($this->edit&&isset($_GET['pageEd_sort'])){   
		$json_arr=array();
		$arr=explode('@@',$_GET['pageEd_sort']);
		$this->update_editor_color_list($arr[0],$arr[1]);
		$json_arr[]=$arr[2]; 
		$json_arr[]=$arr[3];
		echo json_encode($json_arr);
		exit(); 
		}
	if ($this->edit&&isset($_GET['leftovers'])){
		$json_arr=array();
		$json_arr[]='handle_leftovers';
		$json_arr[]=printer::alert('<a href="#leftovers">Delete/Move Leftover Unclones</a>',true,'neg normal shadowoff smallest button'.$this->column_lev_color );
		echo json_encode($json_arr);
		exit();
		}
	if ($this->edit&&isset($_GET['unclone_list_post'])||isset($_GET['unclone_list_column'])){
		$type= (isset($_GET['unclone_list_post']))?' POST':' COLUMN';
		$value=(isset($_GET['unclone_list_post']))?$_GET['unclone_list_post']:$_GET['unclone_list_column'];
		$msg=(isset($_GET['unclone_list_post']))?'.':' but any Unclones will Not Be Deleted and a Link Will Be Provided For them to Be Moved or Deleted:';
		$val_arr=explode('@@',$value);
		$clone_id=$val_arr[0];
		
		if (isset($_GET['unclone_list_post']))
			$q="select blog_id,blog_table_base from $this->master_post_table where blog_clone_target='$clone_id'"; 
		elseif ($val_arr[2]=='prime')
			$q="select col_id,col_table_base from $this->master_col_table where col_clone_target='$clone_id'";
		elseif ($val_arr[2]=='notprime') 
			$q="select blog_data1,blog_table_base from $this->master_post_table where blog_data1='$clone_id'"; // 
			$r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
		if ($this->mysqlinst->affected_rows()){
			$json_arr=array();  
			$json_arr[0]=$val_arr[1];
			$json_arr[1]=printer::alert(NL."The Following Clones of this $type Will Also Not Appear on Their Respective Pages$msg",true,'neg');
			while (list($blog_id,$blog_table_base) = $this->mysqlinst->fetch_row($r,__LINE__)){
				$page=check_data::table_to_title($blog_table_base,__method__,__line__,__file__);
				$json_arr[1].="<p class=\"neu\">$type Id:$blog_id  From Page Title: $page</p>";
				}
			echo json_encode($json_arr);
			}
		exit();
		}
	}
function page_script(){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	$fields='page_id,'.Cfg::Page_fields;  
	$this->accessvar_obj($this->master_page_table,$fields,'page_ref',$this->tablename);
	if($this->page_ref==='indexpage'&&!is_dir(Cfg::PrimeEditDir)){//check for completely new database manual clone
		//new secure_login('ownerAdmin',false);
		}
	$this->page_populate_options();
	$this->generate_cache(); 
	$this->generate_bps();
	$this->deltatime->delta_log('accessvar.obj');
	$this->pre_render_data();$this->deltatime->delta_log('pre_render_data');
	$this->render_header_open();
	$this->render_analytics();  //note will not render  unless cached..// renders with ?render_return
	$this->gen_Proc_init();
	$this->render_highslide();
	// $this->render_yt_embed_player();
	$this->header_close(); $this->deltatime->delta_log('header'); 
	$this->render_body();
	//(Sys::Deltatime)&&print $this->deltatime->return_delta_log();
	}
 

	
	
	
function accessvar_obj($master_table,$field_data,$ref1,$refval1,$ref2='',$refval2=''){
	$where2=(!empty($ref2))?" AND $ref2='$refval2' ":'';
	$field_array=explode(',',$field_data);  
	$q = "SELECT $field_data FROM $master_table where $ref1='$refval1' $where2 ";  
	$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);	 
	$vars=(mail::Defined_vars)?get_defined_vars():'defined vars set off';
	$vars=print_r($vars,true);// this prints to variable
	try {
		if (!$this->mysqlinst->affected_rows()) {
			if (Sys::Debug)echo NL. $q. NL;
			$msg="Page Error or site down:  Redirection will happen with ".Sys::Dbname. ' '.$q;
			$msg=$q;
			throw new mail_exception($msg);  
			}
		}
	catch(mail_exception $me){
		$url = Sys::Home_site;
		mail::alert('Page not found and page file needs to be deleted: '.Sys::Script_filename);
		header("Location: $url");
		}
	//$this->mailinst->mailwebmaster($this->success, $this->message, $vars);		
	$flag=true;
	while ($rows=$this->mysqlinst->fetch_assoc($r,__LINE__)) {
		if ($flag){
			for ($x=0; $x<count($field_array); $x++){
				$this->{$field_array[$x]}=trim($rows[$field_array[$x]]);
				}
			}
		else {
			mail::alert('Multiple select for tablename and field: '. $refval1.' and '.$refval2. ' using query '.$q);
			break;
			}
		$flag=false; 
		}//while
	}

function set_cookie(){ return;  //for collecting browser information  needs updating  
	if  (headers_sent())return; //setting cookies after output started creates error;
	if (!isset($_SESSION[Cfg::Owner.'session_log'])){  
		$this->session_log_count=$_SESSION[Cfg::Owner.'session_log']=1;
		$this->session_log_id=$_SESSION[Cfg::Owner.'session_log_id']=mt_rand(1,mt_getrandmax());
		$this->browser_info=true;
		}
	else { 
		$this->session_log_count=$_SESSION[Cfg::Owner.'session_log']+1;
		$_SESSION[Cfg::Owner.'session_log']=$this->session_log_count;
		$this->session_log_id=$_SESSION[Cfg::Owner.'session_log_id'];
		}
	
	if (isset($_COOKIE[Cfg::Cookie_id]['count'])&&isset($_COOKIE[Cfg::Cookie_id]['last_date'])&&isset($_COOKIE[Cfg::Cookie_id]['reference'])){
		$count=$this->cookie_count=$_COOKIE[Cfg::Cookie_id]['count'];
		$this->cookie_date=$_COOKIE[Cfg::Cookie_id]['last_date'];
		$this->cookie_reference=$_COOKIE[Cfg::Cookie_id]['reference'];
		$this->browser_info=false;
		$count++;
		setcookie(Cfg::Cookie_id.'[count]'   ,$count,time() + (10 * 365 * 24 * 60 * 60),'/','',0,0);
		setcookie(Cfg::Cookie_id.'[last_date]',time(),  time() + (10 * 365 * 24 * 60 * 60),'/','',0,0);
		}
	else{
		$this->cookie_reference=mt_rand(1,mt_getrandmax());
		setcookie(Cfg::Cookie_id.'[count]',1,  time() + (10 * 365 * 24 * 60 * 60),'/','',0,0);
		setcookie(Cfg::Cookie_id.'[last_date]',time(),  time() + (10 * 365 * 24 * 60 * 60),'/','',0,0);
		setcookie(Cfg::Cookie_id.'[reference]',$this->cookie_reference,  time() + (10 * 365 * 24 * 60 * 60),'/','',0,0);
		}
	}

function deltatime($funct){
	 if (!Sys::Debug&&!Sys::Deltatime)return;
		$this->echo_eob.=NL.'deltatime post '.$funct.':'.$this->deltatime->delta();
		}
function nav_return(){
	if (!$this->edit){
		echo '<div style="float:left;">';
		$this->navobj->nav_to_edit();
		echo '</div>';
		}
	}	
function render_body(){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__); 
	(Sys::Deltatime)&&$this->deltatime->delta_log(__line__.' @ '.__method__.'  ');
	$this->call_body(); 
	if ($this->page_options[$this->page_slideshow_index]==='enable_page_slideshow'){
		$this->auto_slide($this->tablename,'page');
		}
	$this->nav_return(); 
	$this->browser_size_display(); 
	 
	//printer::vert_print($_SESSION);
	($this->edit)&&$this->echo_msg();#actually called in edit_body #drop in success message after nav
	$this->render_body_main();
	//$this->render_body_footer();  
	$this->initiate_menu_tab();
	$this->javascript_preload();
	$this->render_body_end();
	}
#br
function javascript_preload(){
	if (!empty($this->preload )){
		echo '<script >
		fadeTo.preloading('.$this->preload.');
		</script>';
		}
	}
function render_body_main(){ //if (isset($_POST))print_r($_POST); 
	//if (strpos(Sys::Self,'index.php')!==false)printer::alert_neg('Site Being Updated',1);
	$this->clone_ext='';//extension used for delinieate if column or post is clone: may affect  style and submitted data  elements
	(Sys::Deltatime)&&$this->deltatime->delta_log(__line__.' @ '.__method__.'  ');
	($this->edit)&&printer::alertx( '<p id="javascriptcheck" class="neg editbackground fsmred vlarge" style="display:block">Caution: Your Javascript is Disabled. This Edit Site Requires Javascript Be Enabled in Your Browser. Submitting Changes Without Javascript Enabled Can Result in Data Loss</p>
	<script > 
		document.getElementById("javascriptcheck").style.display="none" 
     </script>');
	 
	$styles=explode(',',$this->page_style);//for background
	$this->current_background_color=$this->column_background_color_arr[0]= (array_key_exists($this->background_index,$styles)&&preg_match(Cfg::Preg_color,explode('@@',$styles[$this->background_index])[0]))?explode('@@',$styles[$this->background_index])[0]:'ffffff';
	$this->current_color=$this->column_color_arr[0]= (array_key_exists($this->font_color_index,$styles)&&preg_match(Cfg::Preg_color,$styles[$this->font_color_index]))?$styles[$this->font_color_index]:'000000';
	$this->current_font_px=$this->column_font_px_arr[0]=(array_key_exists($this->font_size_index,$styles)&&!empty($styles[$this->font_size_index])&&$styles[$this->font_size_index]>=.5&&$styles[$this->font_size_index]<=4.5)?$styles[$this->font_size_index]*16:16;
	$where="WHERE col_table_base='$this->tablename' and col_primary=1";
	$count_column=$count=$this->mysqlinst->count_field($this->master_col_table,'col_id','',false,$where);
	if ($count_column <1){
		if ($this->edit){
			printer::alertx('<div class="left fs2'.$this->column_lev_color.' '.$this->column_lev_color.' right10 left10 editbackground left maxwidth700" title=""><input type="checkbox" value="1" name="addnewcolumn[]">Check this box to Begin Creating Your Content Column From Scratch and hit the Submit Change Button. ');
			printer::pclear(10);
			echo '</div>';
			printer::alertx('<p class="left fs2'.$this->column_lev_color.' '.$this->column_lev_color.' right10 left10 editbackground left maxwidth700" title=""><input type="checkbox" value="1" name="copynewcolumn[]">OR Copy/Clone/Move   Any Previous Column from another Page (ie Template Starter) Here </p>');
			printer::pclear(10);
			 
			$this->submit_button('SUBMIT ALL');
			//echo '</div>';
			}
		elseif (Sys::Logged_in){  
			printer::alertx('<p style="font-size:2em; color:#'.$this->info.';background:#ffffff;">Navigate to Editpages To Create Your First Page</p>',1.75);
			}
		else 
			printer::alertx('<p style="font-size:2em; color:#'.$this->pos.';background:#ffffff;">New Page Coming Soon</p>');
			
		}
	else { 
		if ($this->edit){
			$this->show_more('Add Special','Close Add Special','editbackground floatleft editcolor editfontsupersmall rad5 fsminfo','',600);
			printer::alertx('<p class="editbackground fs2'.$this->column_lev_color.' '.$this->column_lev_color.' right10 left10 left  maxwidth700" title=""><input type="checkbox" value="0" name="addnewcolumn[]">Check the box to Create another Primary Column directly on Top of Your Previous Primary Column in the body (as opposed to a &#34;Nested Column&#34; which is Column with a  Column as typically done in websites. Primary Columns occupy the center space of a page and do not &#34;float&#34; which is to say do not sit side by side with other columns.  Normally, Columns are created within the Main Column by choosing the New Column option in the Post Dropdown Menu. However you may directly create an additonal Primary Columns  HERE on Top of the Page Body or Following the Current Primary Column(s) Under  Add Special Option  Below</p>');
			printer::alertx('<p class="editbackground fs2'.$this->column_lev_color.' '.$this->column_lev_color.' right10 left10 left maxwidth700" title=""><input type="checkbox" value="0" name="copynewcolumn[]">OR Copy/Move/Clone a Column Starter HERE </p>');
			$this->show_close();//<!--End Add Special-->';
			printer::pclear();
			$this->submit_button('SUBMIT ALL');
			printer::pclear(2);
			}
		  
		$col_field_arr2=$this->col_field_arr;
		$col_field_arr2[]='col_id';
		
		$q='select col_id,'.Cfg::Col_fields." from $this->master_col_table where col_table_base='$this->tablename' AND col_primary=1 order by col_num";
		$primer=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
		$prime_col_arr=array();
		while ($prime_rows=$this->mysqlinst->fetch_assoc($primer,__LINE__,__METHOD__)){ 
			$prime_col_arr[]=$prime_rows;
			}
		foreach ($prime_col_arr as $rows){
			foreach ($col_field_arr2 as $field) {
				$this->$field=$rows[$field];
				} 
		$i=1;
			$this->clone_ext=false;//set default
		 	$col_num= $this->col_num;
			$this->clone_local_style=false;
			if (in_array($this->col_id,$this->column_moved))continue;
			$this->col_child_table='';//to remove child clone
			if ($this->col_temp=='column_choice'){
				$this->choose_column($this->col_id,false);
				$i++;
				continue;
				}
			#	begin clone local check.... 
			$this->column_clone_status_arr[0]=false;
			$this->is_clone=false;
			if ($this->col_status==='clone'&&is_numeric($this->col_clone_target)&&$this->col_clone_target>0){
				$this->post_target_clone_column_id=$this->col_clone_target;//will used cloned value to match  and just be consistent with being last col_id reported to unclone blog_data6
				$this->clone_ext='clone_'; 	
				$this->column_clone_status_arr[0]=true;
				$this->is_clone=true;
				$this->col_id=$this->col_clone_target;
				$this->parent_col_clone=$this->col_clone_target;//for column/post is cloned moreinfo msg
				$col_status=$this->col_status;
				$this->col_child_table=$this->col_table;//If cloned primary table needs to be deleted
				$count=$this->mysqlinst->count_field($this->master_col_table,'col_id','',false,"where col_id='$this->col_id'");
				if ($count<1)continue;
				$q='select '.Cfg::Col_fields." from $this->master_col_table where col_id='$this->col_id'";
				$r2=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
				if (!$this->mysqlinst->affected_rows()){
					mail::alert('Cloned Primary Column problem with ID'.$this->col_clone_target);
					continue;
					}
				$row=$this->mysqlinst->fetch_assoc($r2,__LINE__,__METHOD__,true); 
				foreach ($this->col_field_arr as $field) {
					$this->$field=$row[$field];
					}
				$this->col_status=$col_status;//reinstate status of clone or not
				if ($this->edit&&$this->col_primary!=1){
					printer::print_info('Nested Clone in Primary position. Width is set to the current page_width configuration!!',.7);
					}
				//$this->col_width=(is_numeric($this->col_width)&&$this->col_width>100)?$this->col_width:((!empty($this->page_width))?$this->page_width:Cfg::Page_width);
				$column_css_fields=Cfg::Col_css_fields;
				$column_css_fields_arr=explode(',',$column_css_fields);
				$col_fields=Cfg::Col_fields;
				$col_fields_arr=explode(',',$col_fields);
				if (isset($_POST['delete_collocalstyle'][$this->col_id])){
					$q="delete from $this->master_col_css_table Where col_id='c$this->col_id' and col_table_base='$this->tablename'";
					$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
					$this->clone_local_style=false;
					}
				else {   
					$this->parent_col_clone=$this->col_clone_target;
					$count=$this->mysqlinst->count_field($this->master_col_css_table,'css_id','',false,"where col_id='c$this->col_id' and col_table_base='$this->tablename'");   
					if ($count < 1){//
						if (isset($_POST['submitted'])&&isset($_POST['add_collocalstyle'][$this->col_id])){
							$q="select $col_fields from $this->master_col_table where col_id='$this->col_id'";  
							$ins=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
							$col_rows=$this->mysqlinst->fetch_assoc($ins,__LINE__);
							$this->mysqlinst->count_field($this->master_col_css_table,'css_id','',false);
							$value='';
							$css_id=$this->mysqlinst->field_inc;
							foreach ($col_fields_arr as $field) {
								if($field==='col_table_base')$value.="'$this->tablename',";
								elseif($field==='col_table')$value.="'$this->col_table',";
								else $value.="'".$col_rows[$field]."',";
								}
		 
							$q="insert into $this->master_col_css_table   (css_id,col_id,$col_fields,col_update,col_time,token) values ($css_id,'c$this->col_id',$value '".date("dMY-H-i-s")."','".time()."','".mt_rand(1,mt_getrandmax())."')";   
							$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true); 
							$this->clone_local_style=true; 
							}
						else $this->clone_local_style=false;
						}
					else {
						 $q="select $column_css_fields from $this->master_col_css_table where col_table_base='$this->tablename' and col_id='c$this->col_id'"; 
						$loc=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
						$col_css_row=$this->mysqlinst->fetch_assoc($loc,__LINE__);
						foreach($column_css_fields_arr as $cfield){//here we select and replace all replacable values in local column enabled cloned columns
							$this->{$cfield}=$col_css_row[$cfield];
							}
						$this->clone_local_style=true;
						}//count
					}//not delete
					 
				 
				
				 
				}//pp clone status
			printer::pclear();
			$this->current_background_color=$this->column_background_color_arr[0];//reset to top level level colors and font px///  will track through color and individual posts...
			$this->current_color=$this->column_color_arr[0];
			$this->current_font_px=$this->column_font_px_arr[0];   
			($this->edit)&&$this->css.="\n.$this->clone_ext$this->col_table{margin-left:auto;margin-right:auto; text-align:center;}";//text align used for non rwd posts using  center float  ie  inline-block
			$this->blog_render($this->col_id,true,$this->col_table_base); 
			if ($this->edit){   
				$this->submit_button('SUBMIT ALL');
				printer::pclear(2);
				$this->show_more('Add Special','Close Add Special','floatleft editbackground editcolor editfontsupersmall rad5 fsminfo','',600);
				printer::alertx('<p class="editbackground fs2'.$this->column_lev_color.' '.$this->column_lev_color.' right10 left10 margincenter maxwidth700" title=""><input type="checkbox" value="'.($col_num +.5).'" name="addnewcolumn[]">Check the box to Create another Primary Column directly in the body (as opposed to a &#34;Nested Column&#34; which is Column with a  Column as typically done in websites. Primary Columns occupy the center space of a page and do not &#34;float&#34; which is to say do not sit side by side with other columns. Normally, Columns are created within the Main Column by choosing the nested column option in the Post Dropdown Menu all within a Single Primary Column. However you may directly create additonal Primary Columns in the main Body by checking here. Create a new Primary Column HERE after Primary Column#'.$col_num.'</p>');
				printer::alertx('<p class="editbackground fs2'.$this->column_lev_color.' '.$this->column_lev_color.' right10 left10 left maxwidth700" title=""><input type="checkbox" value="'.($col_num+.5).'" name="copynewcolumn[]">OR Copy/Move/Clone a Column Starter HERE after Primary Column#'.$col_num.'</p>');
				$this->show_close();//<!--End Add Special-->';
				printer::pclear(2);
				}  
			$i++;
			}//end while
		if ($this->edit&&isset($_POST['submitted']))$this->primary_order_update();
		//$this->echo_msg();//will echo success msgs  //submit call in destructor to collect all mgs
		//$colmsg='';
		//$count=$this->mysqlinst->count_field(Cfg::master_col_table,'col_num','',false,"where col_table_base='$this->tablename' AND col_primary=1");
		//$ppfieldmax=$this->mysqlinst->fieldmax+.5;
		}
	/*if (isset($_POST['addnewcolumn'][$this->tablename]))$this->blog_render($this->tablename.'_blog'.($this->ppnumber+1),($this->ppnumber+1)); 
		} 
	elseif($this->edit) {
		if (isset($_POST['addnewcolumn'][$this->tablename]))$this->blog_render($this->tablename.'_blog1',1); 
		$this->ppnumber=0;
		$colmsg='<legend class="pos">Create Your First Column for Adding Posts</legend>';
		}
		
		setup: function(ed) { ed.onKeyPress.add( function(ed, evt) {alert('showme') } );},
	
	#############
	function lookdeep(object,num){
	 num++;
    var collection= [], index= 0, next, item;
    for(item in object){
        if(object.hasOwnProperty(item)){
            next= object[item];
            if(typeof next== 'object' && next!= null&&num <3){
                collection[index++]= item +
                ':{ '+ lookdeep(next).join(',<br><br> ')+'}';
            }
            else collection[index++]= [item+':'+String(next)];
        }
    }
    return collection;
}

 
 
 //var lookdeepSample= 'O={'+ lookdeep(ed,0).join(',<br>')+'}';
// document.write(lookdeepSample);
###########################33
	
	
	
	
	*/
	  
	}
	
function pre_render_data(){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
    }//used for customization to render normal pages by pre configuring data    

	
#tinymce	
function tinymce(){ 
//function tinymce_4_4_dev(){
	/*setup : function(ed) {
        ed.onBeforeSetContent.add(function(ed, o) {
            if (o.initial) {
               // o.content = o.content.replace(/\r?\n/g, '<br>');
            }
        });
    },*/
               
	$style=Cfg_loc::Root_dir.'styling/'.$this->tablename.'.css';
	$script=Cfg_loc::Root_dir.'scripts/tinymce/js/tinymce/tinymce.dev.js';
	$return='/\r?\n/g';
	
	echo <<<eol
<script  src="$script"></script>
  <script >
   
  tinymce.init({
	setup: function (editor) {
		editor.on('BeforeSetContent', function (contentEvent) {
		contentEvent.content = contentEvent.content.replace($return, '<br>'); 
		})   
		},
    selector: '.enableTiny',  
	inline: true, 
    	fontsize_formats: ".6em .7em .8em .9em 1em 1.1em 1.25em 1.5em 1.75em 2em 2.25em 2.5 2.75em 3em ",
	content_css: "$style", 
	remove_linebreaks : false,
     forced_root_block : false,
	force_p_newlines  : '',
     plugins: [
             "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
             "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
             "save table contextmenu directionality emoticons template paste textcolor"
       ],
	
        
       toolbar: " undo | redo | styleselect | bold |italic | alignleft | aligncenter | alignright | alignjustify | bullist | numlist | outdent | indent | link | print | media | fullpage |  forecolor | backcolor | fontselect | fontsizeselect | emoticons   ", 
       style_formats: [
            {title: 'h1', inline: 'h1'},
            {title: 'h2', inline: 'h2'},
            {title: 'h3', inline: 'h3'},
            {title: 'h4', inline: 'h4'},
            {title: 'h5', inline: 'h5'},
            {title: 'h6', inline: 'h6'},
            {title: 'div myclass1', inline: 'div', 'classes' : 'myclass1', exact : true},
            {title: 'div myclass2', inline: 'div', 'classes' : 'myclass2', exact : true}, 
            {title: 'div myclass3', inline: 'div', 'classes' : 'myclass3', exact : true}, 
            {title: 'div myclass4', inline: 'div', 'classes' : 'myclass4', exact : true}, 
            {title: 'div myclass5', inline: 'div', 'classes' : 'myclass5', exact : true}, 
            {title: 'div myclass6', inline: 'div', 'classes' : 'myclass6', exact : true}, 
            {title: 'div myclass7', inline: 'div', 'classes' : 'myclass7', exact : true}, 
            {title: 'div myclass8', inline: 'div', 'classes' : 'myclass8', exact : true}, 
            {title: 'div myclass9', inline: 'div', 'classes' : 'myclass9', exact : true}, 
            {title: 'div myclass10', inline: 'div', 'classes' : 'myclass10', exact : true}, 
            {title: 'div myclass11', inline: 'div', 'classes' : 'myclass11', exact : true}, 
            {title: 'div myclass12', inline: 'div', 'classes' : 'myclass12', exact : true},
            {title: 'p myclass1', inline: 'p', 'classes' : 'myclass1', exact : true},
            {title: 'p myclass2', inline: 'p', 'classes' : 'myclass2', exact : true}, 
            {title: 'p myclass3', inline: 'p', 'classes' : 'myclass3', exact : true}, 
            {title: 'p myclass4', inline: 'p', 'classes' : 'myclass4', exact : true}, 
            {title: 'p myclass5', inline: 'p', 'classes' : 'myclass5', exact : true}, 
            {title: 'p myclass6', inline: 'p', 'classes' : 'myclass6', exact : true}, 
            {title: 'p myclass7', inline: 'p', 'classes' : 'myclass7', exact : true}, 
            {title: 'p myclass8', inline: 'p', 'classes' : 'myclass8', exact : true}, 
            {title: 'p myclass9', inline: 'p', 'classes' : 'myclass9', exact : true}, 
            {title: 'p myclass10', inline: 'p', 'classes' : 'myclass10', exact : true}, 
            {title: 'p myclass11', inline: 'p', 'classes' : 'myclass11', exact : true}, 
            {title: 'p myclass12', inline: 'p', 'classes' : 'myclass12', exact : true},
            {title: 'span myclass1', inline: 'span', 'classes' : 'myclass1', exact : true},
            {title: 'span myclass2', inline: 'span', 'classes' : 'myclass2', exact : true}, 
            {title: 'span myclass3', inline: 'span', 'classes' : 'myclass3', exact : true}, 
            {title: 'span myclass4', inline: 'span', 'classes' : 'myclass4', exact : true}, 
            {title: 'span myclass5', inline: 'span', 'classes' : 'myclass5', exact : true}, 
            {title: 'span myclass6', inline: 'span', 'classes' : 'myclass6', exact : true}, 
            {title: 'span myclass7', inline: 'span', 'classes' : 'myclass7', exact : true}, 
            {title: 'span myclass8', inline: 'span', 'classes' : 'myclass8', exact : true}, 
            {title: 'span myclass9', inline: 'span', 'classes' : 'myclass9', exact : true}, 
            {title: 'span myclass10', inline: 'span', 'classes' : 'myclass10', exact : true}, 
            {title: 'span myclass11', inline: 'span', 'classes' : 'myclass11', exact : true}, 
            {title: 'span myclass12', inline: 'span', 'classes' : 'myclass12', exact : true},
           
          
        ]
  });
  </script>
eol;
//image | video |
  }  
  
  
 
#gen_Proc	javascript initiate
function gen_Proc_init(){
	$image_response_array=json_encode(explode(',',$this->page_cache));
	$response_dir_prefix=Cfg::Response_dir_prefix;
	$largegalldir=Cfg::Large_image_dir;
	$token=(isset($_SESSION[Cfg::Owner."sess_token"]))?$_SESSION[Cfg::Owner."sess_token"]:'';
	$maxlimit=$this->page_width;
	$slidedir=Cfg::Auto_slide_dir;
	$sysedit=Sys::Edit;
	$sysloc=Sys::Loc;
	$cfgdev=Cfg::Development;
	$passclass=Sys::Pass_class;
echo <<<eol
<script >
gen_Proc.edit='$this->edit';
gen_Proc.image_response = $image_response_array;
gen_Proc.image_response_dir_prefix = '$response_dir_prefix';
gen_Proc.large_gall_dir =  '$largegalldir';
gen_Proc.auto_slide_dir =  '$slidedir';
gen_Proc.token='$token';
gen_Proc.Edit='$sysedit';
gen_Proc.Loc='$sysloc';
gen_Proc.Dev='$cfgdev';
gen_Proc.maxPicLimit=$maxlimit;
gen_Proc.passclass='$passclass';
</script>
eol;
	}
#highslide	
function render_highslide(){  
	$scriptdir=Cfg_loc::Root_dir.Cfg::Script_dir.'highslide/highslide-with-gallery.js';
	$graphicsdir=Cfg_loc::Root_dir."scripts/highslide/graphics/";
echo <<<eol
<script  src="$scriptdir"></script> 
<script >
hs.graphicsDir = '$graphicsdir';
//  expand images utilize   highslide.com  Torstein Hønsi
hs.align = "center"; 
hs.transitions = ["expand", "crossfade"];
hs.outlineType = 'rounded-white'; //beveled drop-shadow outer-glow rounded-black glossy-dark rounded-white  null
hs.fadeInOut = true;
hs.repeat= true;
//hs.allowSizeReduction = true;
hs.currentWrapthis='';
hs.useControls=true;
hs.dimmingOpacity=1;
hs.fixedControls= "fit";
hs.expandCursor='zoomin.cur';
hs.overlayOptions={
		opacity: .7,   //set the opacity of the controlbar
		position: "bottom center",  //position of controlbar  
		hideOnMouseOut: false
	}
// Add the controlbar

</script>
eol;
	}
	
 function render_body_addtop(){
	#to put data at top of body within  body tag
	}
function render_header_open() { if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	//use of $this->roots is antiquated having dealt with translation or test sites that could run in subdirectory
	if($this->edit){
		if (is_file('../includes/'.$this->header_type))include_once('../includes/'.$this->header_type);
		else include_once ('includes/'.$this->header_type);
		} 
	else include ('includes/'.$this->header_type); 
     if (!empty($this->page_head)) 
		printer::printx( "\n".$this->page_head);
     printer::printx( "\n".'<link href="'.$this->roots.Cfg::Style_dir.$this->tablename.$this->css_suffix.'.css?'.rand(0,32323).'" rel="stylesheet" type="text/css">'); 
	(Sys::Advanced||!$this->edit||(!Sys::Advancedoff&&$this->page_options[$this->page_advanced_index]!=='disabled'))&&printer::printx( "\n".'<link href="'.$this->roots.Cfg::Style_dir.$this->tablename.'_adv'.$this->css_suffix.'.css?'.rand(0,32323).'" rel="stylesheet" type="text/css">');
	($this->edit)&&printer::printx( "\n".'<link href="'.$this->roots.Cfg::Style_dir.$this->tablename.$this->css_suffix.'edit.css?'.rand(0,32323).'" rel="stylesheet" type="text/css">');
	echo '
	<link href="'.$this->roots.Cfg::Style_dir.'gen_page.css" rel="stylesheet" type="text/css">
	    ';
	$page_array=array();
	if (is_file(Cfg_loc::Root_dir.Cfg::Data_dir.'page_stylesheet_'.$this->tablename)){ 
		$csspage=explode(',',file_get_contents(Cfg_loc::Root_dir.Cfg::Data_dir.'page_stylesheet_'.$this->tablename));
		if (count($csspage)>0){ 
			foreach ($csspage as $page){
				if(strlen($page)>2){
					$page_array[]=$page;
					if (is_file(Cfg_loc::Root_dir.Cfg::Data_dir.'page_stylesheet_'.$page)){ 
						$css2page=explode(',',file_get_contents(Cfg_loc::Root_dir.Cfg::Data_dir.'page_stylesheet_'.$page));
						if (count($css2page)>0){ 
							foreach ($css2page as $page2){
								if(strlen($page2)>2){
									$page_array[]=$page2;
									}
								}
							}
						}
					}
				}
			}
		}
	
	$page_array=array_unique($page_array);
	foreach  ($page_array as $page){
		echo '
			<link href="'.$this->roots.Cfg::Style_dir.$page.'.css?'.rand(0,32323).'" rel="stylesheet" type="text/css">';
					((Sys::Advanced||!$this->edit)||(!Sys::Advancedoff&&$this->page_options[$this->page_advanced_index]!=='disabled') )&&printer::printx("\n". '<link href="'.$this->roots.Cfg::Style_dir.$page.'_adv.css?'.rand(0,32323).'" rel="stylesheet" type="text/css">'); 
		}
	if (is_file(Cfg_loc::Root_dir.Cfg::Data_dir.'page_stylesheet_'.$this->tablename.$this->passclass_ext)&&!empty($this->passclass_ext)){//here we are doubling up to replace the former with the current if it has been rendered  otherwise we need to iframe_generate the pages of clone originals
		$csspage=explode(',',file_get_contents(Cfg_loc::Root_dir.Cfg::Data_dir.'page_stylesheet_'.$this->tablename.$this->passclass_ext));
		if (count($csspage)>0){ 
			foreach ($csspage as $page){
				if(strlen($page)>2){
					print '
					<link href="'.$this->roots.Cfg::Style_dir.$page.$this->css_suffix.'.css?'.rand(0,32323).'" rel="stylesheet" type="text/css">
					';
					(Sys::Advanced||!$this->edit||(!Sys::Advancedoff&&$this->page_options[$this->page_advanced_index]!=='disabled') )&&printer::printx( '<link href="'.$this->roots.Cfg::Style_dir.$page.'_adv'.$this->css_suffix.'.css?'.rand(0,32323).'" rel="stylesheet" type="text/css">');
					}
				}
			}
		}
	if (!empty($this->header_style)){
		$this->header_style=(!is_array($this->header_style))?explode(',',$this->header_style):$this->header_style;    
		foreach($this->header_style as $var){  
		    if (!empty($var)){
				echo'
				<link href="'.$this->roots.$var.'?'.rand(0,32323).'" rel="stylesheet" type="text/css">'; 
				}
			}
		}
     
	if (!empty($this->header_script_function)){#note that the standard tablename script will be dumped here...!!
	    $this->header_script=(!is_array($this->header_script))?explode(',',$this->header_script):$this->header_script;    
	    $this->header_script[]=$this->tablename.$this->css_suffix.'scripts.js?'.rand(0,32323); //     
	    }
    
	if (!empty($this->header_script)){  
		$this->header_script=(!is_array($this->header_script))?explode(',',$this->header_script):$this->header_script;    
		 foreach ($this->header_script as $var){
	   	if (!empty($var)){
			    echo ' 
			    <script  src="'.$this->roots.Cfg::Script_dir.$var.'?'.rand(0,32323).'"></script> ';
			    }
			}
		 }
     
	if (!empty($this->header_include)){ 
		$this->header_include=(!is_array($this->header_include))?explode(',',$this->header_include):$this->header_include;    
		foreach ($this->header_include as $var){  
		    include($this->roots.$var);
		    }
		}  
	$this->header_insert(); 
    }
function header_insert(){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	//add site wide custom scripts   styles or links to .css and .js files in
	//site_master.class.php for site wide effect that will not be updated over
	//use individual page class ie about.class.php for the same but page specific..
	}

function header_close(){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__); 
	echo'</head>';
    }    
    
function render_analytics(){   
	   if ($this->edit||Sys::Loc)return;
	   if (Sys::Debug ) return;  
	   $this->analytics();
	   }
	   
function analytics(){
	//use site_master.class function to prevent updating
	}	 

function render_message(){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
    if (isset($_POST['submit'])&&!isset($_POST['mailsubmitted']))   printer::alertx('<p class="ramana  large"> <a href="'.Sys::Self.'?clickagain">Click Here </a><span class="information" title="Not all Styling Changes Appear in the Editor. View Web Page itself for Final Result" >To Insure Styling Changes Appear in the Editor.</span></p>');
	else if (isset($_GET['clickagain']))   printer::alertx('<p class="ramana  large"> <a href="'.Sys::Self.'">Once More For Good Luck</a><span class="information" title="Not all Styling Changes Appear in the Editor. View Web Page itself for Final Result" >to insure the style sheet is refreshed</span></p>');
	/*else  printer::alertx('<p class="information fs1info floatleft pt10" title="This will insure that the latest Edit Changes affecting the Styling Show UP in the Editor. Not all Page Changes Show UP in the Editor So Please Check The Final Result on the Web Page Itself!"> <a href="'.Sys::Self.'">Refresh Edit Page Style Changes</a></p>');*/
	if (count($this->message)>0||count($this->success)>0){
	   $this->mailinst->mailwebmaster($this->success,$this->message);
	   }
	#success messages will be printed in $this->echo_msg;
   }
  

    
function call_body(){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	if($this->edit){ 
		echo '<body id="'.$this->tablename.'" class="'.$this->tablename.'" '.$this->edit_onload.'>';
		} 
    else 
	    echo '<body id="'.$this->tablename.'" class="'.$this->tablename.'" '.$this->onload.'>';
	(isset($_GET['iframepos']))&&printer::alertx('<p class="smallest cursor Od3navy fs3green rad5 floatleft whitebackground navy"><a href="'.request::return_full_url().'"><u>'.request::return_full_url().'</u></a></p>');
		$this->background_video('page_style');
		if ($this->edit&&Sys::Pass_class&&Sys::Viewdb){
			printer::print_wrap('restore opts','white redbackground Os3salmon fsminfo');
			printer::alert_neg('Viewing Database: '.Sys::Dbname);
			printer::alert_neu('Use Normal Edit Page Navigations to Check Pages. Use Restore Link Below to Restore entire web Page as needed');
			$tablename=check_data::dir_to_file(__METHOD__,__LINE__,__FILE__,$this->tablename); 
			$tablename=($tablename)?$tablename:'index'; 
			$file='./'.$tablename.'.php?viewdboff';
			printer::alert_neu('Return Back to <a class="acolor click" href="'.$file.'"> Normal Edit Page</a>');
			$file='../'.$tablename.'.php?viewdb';
			printer::alert_neu('View this restore choice page in <a class="acolor click" href="'.$file.'">View Restore as regular Webpage</a>');
			$file='./'.$tablename.'.php?viewdboff&amp;page_restore_dbopt';
			list($fname,$time)=explode('@@',$_SESSION[Cfg::Owner.'db_to_restore']);
			$msg='Restore this Previous Website replacing the current Db';
			$msg1=' from TimeAgo: '.$this->get_time_ago($time).'&nbsp; Date: '.date("dMY-H-i-s",$time).'&nbsp;Filename: '.$fname.'&nbsp; Size: '.(filesize(Sys::Home_pub.Cfg::Backup_dir.$fname)/1000).'Kb';
			printer::alert_neg('<a class="acolor click" onclick="return gen_Proc.confirm_click(\'Confirm if you wish to '.$msg.' \');" href="'.$file.'">Restore this Webite </a>'.$msg1);
			printer::close_print_wrap('restore opts');
			}
		elseif (Sys::Pass_class&&Sys::Viewdb){
			printer::print_wrap('restore opts','white redbackground  fsminfo');
			printer::alert_neg('Viewing Database: '.Sys::Dbname);
			$tablename=check_data::dir_to_file(__METHOD__,__LINE__,__FILE__,$this->tablename); 
			$tablename=($tablename)?$tablename:'index'; 
			$file=Cfg_loc::Root_dir.Cfg::PrimeEditDir.$tablename.'.php';
			printer::alert_neu('Return Back to <a class="acolor click" href="'.$file.'">View Restore Db Edit Page</a>');
			//printer::alert_neu('<a class="acolor click" href="'.Sys::Self.'?viewdboff">Return Back to Normal WebPages</a>');
			printer::close_print_wrap('restore opts');  
			}
	} 

function echo_msg(){  if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	  
	if (count($this->storeinst->msg)>0){
		foreach ($this->storeinst->msg as $msg){
			echo NL.$msg;
			}
		}
	if  (isset($_SESSION[Cfg::Owner.'update_msg'])&&!empty($_SESSION[Cfg::Owner.'update_msg'])&&!isset($_POST['submit'])){ 
		$mymessages=array_unique($_SESSION[Cfg::Owner.'update_msg']);
		echo '<div class="fs1redAlert"><!--outerwrap message alerting-->';
		echo '<div class="fsminfo whitebackground"><!--innerwrap message alerting-->';
		printer::printx('<p class="fsmred editbackground info floatleft large">Hit the Browser Refresh Button <img src="'.Cfg_loc::Root_dir.'refresh_button.png" alt="refresh button" width="20" height="20"> to Insure All New Styles are Updated!!</p>');
		printer::pclear();
		print '<div class="fs3navy left large p10all editbackground maxwidth700"><!--Alert Messages--> ';
		foreach ($mymessages as $message){
			print($message);
			printer::pclear();
			}
			
		echo ' </div><!--Alert Messages-->';
		
		echo '</div><!--outerwrap message alerting-->';
		echo '</div><!--innerwrap message alerting-->';
		unset($_SESSION[Cfg::Owner.'update_msg']); 
		}
	}
function alert_neu($msg,$size=1.2,$return=false){
     printer::alert_neu($msg,$size,$return);
    }
function alert_neg($msg,$size=1.2,$return=false){
     printer::alert_neg($msg,$size,$return);
    }
function alert_pos($msg,$size=1.2,$return=false){
     printer::alert_pos($msg,$size,$return);
    } 
function alert($msg,$return=false){
     printer::alert($msg,$return);
    } 
 
  
 
function render_body_end(){   if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	(Sys::Deltatime)&&$this->deltatime->delta_log(__line__.' @ '.__method__.'  ');
	  $this->deltatime->delta_log('body main');
	if (Sys::Debug){
		echo $this->echo_eob;#echo the time
		}
	  // $this->render_body_end_add2();//just depends where you want the extra info		
	if ($this->edit){// css is rendered to file before destructor
		$this->destructor();	//get destructor in before form  close for orphan unclone choices...
		$this->edit_form_end(); 
		}
	 
	//if (!$this->edit&&!empty($this->add_container))echo '</div><!--addcontainerinner--></div><!--addcontainer-->';
	else ($this->edit)&& printer::alert('bottom view');//
	(Sys::Logged_in&&$this->edit)&&printer::alert_neu('<a href="'.Sys::Self.'?logout">logout as admin</a>');
	(Sys::Logged_in&&$this->edit)&&printer::alert_neu('<a href="'.Sys::Self.'?changepass">change your password</a>');
	(Sys::Logged_in)&&printer::pspace(50);
	(isset($_GET['iframepos']))&&print('<p id="iframe_bottom"></p>');
echo <<<eol
    </body>
    </html>
eol;
    }//end function render_body
 #these empty functions are called up in chain of events and provide opportunities for custom functions specificed in child classes site_master or page_master.    
function render_body_end_add(){
	}
function render_body_end_add2(){
	}
function mail_initiate(){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
    $this->mailinst=mail::instance();
    }

function db_initiate(){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
    $this->mysqlinst = mysql::instance();
    } 
 
function session_initiate(){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
    $this->sess=session::instance();
    $this->sess->referrer(); 
 
    //$this->sess->session_check();
   // $this->sess->token=create_token(); 
    }
 
 function backup_initiate(){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__); 
    $this->backupinst=backup::instance();
    }
    
function navigation_initiate(){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__); 
    $this->navobj=navigate::instance();
    
    $this->navobj->put('ext',$this->ext);
    $this->navobj->put('tablename',$this->tablename);
    $this->navobj->put('edit',$this->edit); 
    }
function get_size_string($pic, $dir=Cfg_loc::Root_dir){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
    if (is_file($dir.$pic)){
	   $size	= GetImageSize($dir.$pic);   
	   return $size[3];
	  }
	else 
		return 'width="50" height="50"';
	}


function render_img($pic,$alt='',$dir=Cfg_loc::Root_dir){
	$alt=(empty($alt))?'image file '.$pic:$alt;
	echo '<img src="'.$dir.$pic.'"' .$this->get_size_string($pic,$dir).' alt="'.$alt.'">';
	}

function get_size($pic, $dir=Cfg_loc::Root_dir,$alertmsg=true){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
    if (is_file($dir.$pic)){
	   $size	= GetImageSize($dir.$pic);
	  $width			= $size[0];
	  $height			= $size[1];
	  return (array($width,$height));
	  }
	else
		return (array('48.4','50'));
    }
#show_more 
function show_more($msg_open,$msg_var='noback',$class='',$title='',$width=400,$showwidth='',$styledirect='float:left;'){ if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	$noback=($msg_var==='noback')?'noback':''; 
	###Note: Close js function just appends close..   the $msg_var slot is used to indicate slow or include span html styling which substitutes into open without affecting html
	$full_width=(!empty($width)&&$width>50)?'gen_Proc.fullWidth(id,'.$width.',\''.$noback.'\');':(($width!='full')?'gen_Proc.fullWidth(id,0);':'gen_Proc.fullWidth(id,\'full\');');    
	self::$show_more++; //echo 'show more is '.$this->show_more;
	(empty($class))&&$class=$this->column_lev_color.' floatleft shadowoff editbackground button'.$this->column_lev_color;
	
	//$msg_open_mod=str_replace(array('<','>'),'',$msg_open);
	$msg_open_mod=$msg_open;
	if (strpos($msg_var,'<span')!==false){ // this way msg_open_mod can be correct  js version without <> and msg open read with span and html tags
		$msg_open=$msg_var; 
		}
	$lesswidth=($this->current_net_width<80)?5:20;
	$zstyle='';//'position:relative;';
	$msg_slow=($msg_var=='slow')?'slow':'';//to fade in hidden div  
	$stylewidth='style="'.$zstyle.'"';(!empty($showwidth))?'style="'.$zstyle.'max-width:'.$showwidth.$styledirect.'"':((isset($this->current_net_width)&&!empty($this->current_net_width))?'style="'.$zstyle.'max-width:'.($this->current_net_width-$lesswidth).'px;'.$styledirect.'"':(!empty($styledirect)?'style="'.$zstyle.$styledirect.';"':''));
	//$border=($border)?' fs2'.$this->column_lev_color:'';
	$floatleft=(strpos($class,'floatleft')===false)?'floatleft':'';
    echo '<p class="'.$floatleft.' underline editfont shadowoff cursor '.$class.' " title="'.$title.'" '.$stylewidth.'  onclick="gen_Proc.show(\'show'.self::$show_more.'\',\''.$msg_open_mod.'\',\''.$msg_slow.'\');'.$full_width.'" id="show'.self::$show_more.'">'.$msg_open.'</p>';
    printer::pclear();
    echo '<div class="inline"   id="show'.self::$show_more.'t" style="display: none; '.$styledirect.'"><!--'.$msg_open_mod.'-->';
    
	// echo '<input type="text" style="height:10px;" size="1" value="" id="show'.self::$show_more.'f1">'; 
	
    }
    
function plus($msg,$width=''){ if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	self::$pluscount++;  
	$full_width=(!empty($width)&&$width>50)?'fullWidth(id,'.$width.')':'';      
	$this->plus_msg=$msg;
	 echo '
	<p class="underline shadowoff editbackground floatleft button'.$this->column_lev_color.' '.$this->column_lev_color.' editfont" style="max-width:'.($this->current_net_width-20).'px;">
	<input type="button" value="'.$msg.'" id="plusdata'.self::$pluscount.'" onclick="plus(id,\''.$msg.'\','.$show_width.');$full_width;">
	</p>
    printer::pclear(1);
	 <div  id="plusdata'.self::$pluscount.'t" style="width:10px; display: none; "><!--'.$msg.' plus openplustrack'.self::$pluscount.'-->'; 
	}
 

#plus_mod avoids the use of field set 
function plus_mod($msg="Edit styling here",$width=''){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__); //used in editing styles
   	self::$plusmod++; 
	$full_width=(!empty($width)&&$width>50)?'fullWidth(id,'.$width.')':'';      
	   printer::printx('<input type="text" style="height:2px;   color:rgba(255,255,255,0); background:rgba(255,255,255,0);border: 1px solid rgba(255,255,255,0);" size="1" value="" id="plusmoddata'.self::$plusmod.'f">'); 
	$this->plus_msg=$msg;
    if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
    $maxwidth=(isset($this->current_net_width)&&$this->current_net_width>50)?$this->current_net_width:$this->current_total_width;
   echo '
	<p style="max-width:'.($maxwidth-20).'px;" class="underline shadowoff editbackground floatleft button'.$this->column_lev_color.' '.$this->column_lev_color.' editfont" id="plusmoddata'.self::$plusmod.'" onclick="plus(id,\''.$msg.'\');'.$full_width.';">'.$msg.
	'</p>';   
    printer::pclear(1);  
	echo ' <div class="hide"  id="plusmoddata'.self::$plusmod.'t"><!--'.$msg.' plus mod openplustrack'.self::$pluscount.'-->'; 
    }

 
function show_close($ref=''){
     echo '</div><!--Close '.$ref.'-->';
	printer::pclear(2);
	}
function plus_close(){
     echo '</div><!--'.$this->plus_msg. ' closeplustrack'.self::$pluscount.'-->';
	printer::pclear(2);
	}

function plus2($msg){ if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
    self::$pluscount++; 
    echo '
    <fieldset ><legend>Click + '.$msg.'</legend>
    <img src="'.Cfg_loc::Root_dir.'plus.jpg" alt="plus add data" width="20" height="20" id="plusdata'.self::$pluscount.'" onclick="plus(id);">
    <div  id="plusdata'.self::$pluscount.'t" style="display: none; "><!--'.$msg.' plus2 openplustrack'.self::$pluscount.'-->'; 
    }

function page_update_clones(){ //if(isset($_SESSION[Cfg::Owner.'page_update_clones']))unset($_SESSION[Cfg::Owner.'page_update_clones']);
	$countsess=count($_SESSION[Cfg::Owner.'page_update_clones']);
		if ($countsess>0){
			echo '<div id="page_mirror_update" class="floatleft cherrybackground white"><!--page mirror wrap-->';
			$this->show_more('There are '.$countsess.'  Pages with css or configuraton content awaiting update do to parent column updates or bp changes, etc.','','underline cherrybackground white rad5');
			echo '<div class="fsmcherry editbackground editcolor"><!--unclone update wrap-->';
			//print_r($_SESSION[Cfg::Owner.'page_update_clones']);
			$pages=implode(',',$_SESSION[Cfg::Owner.'page_update_clones']); 
			printer::printx('<p class="fsminfo editcolor editbackground">There are '.$countsess.'  Parent page(s) have updated now mirrored content awaiting styling/config update</p>');
			$info='You Choose when to update styling and config content of pages when the parent page is updated by submitting mirror update now which publishes the changes to all changed page at once, or when you done styling/config the parent page as this option persists. Visiting any page in editmode automatically updates styles and configs forthat particlar page at any time.';
			printer::printx('<p class="tip">'.$info.'</p>'); 
			echo '<div class="rad5 smaller floatleft fsmcherry cursor cherrybackground white" onclick="gen_Proc.use_ajax(\''.Sys::Self.'?iframe_gen&amp;pages='.$pages.'\',\'handle_replace\',\'get\');">Update Mirrors</div>';
			printer::pclear();
			}//count >0
		else unset($_SESSION[Cfg::Owner.'page_update_clones']);
			echo '</div><!--unclone update wrap-->';
			
		$this->show_close('There are '.$countsess.'  Pages with mirrored content awaiting update');
	echo '</div><!--page mirror wrap-->';
	printer::pclear();
	echo '<div id="page_iframe_contain"></div>';
	}

function update_image_arr(){
	if (Sys::Pass_class)return;
	foreach(array(Cfg::Page_images_dir,Cfg::Page_images_expand_dir,Cfg::Large_image_dir,Cfg::Auto_slide_dir) as $dir){
		if ($dir=== Cfg::Page_images_dir) 
			$current=$this->page_images_arr;
		elseif ($dir=== Cfg::Page_images_expand_dir) 
			$current=$this->page_images_expanded_arr;  
		elseif ($dir===Cfg::Auto_slide_dir)
			$current=$this->auto_slide_arr;  
		elseif ($dir===Cfg::Large_image_dir)
			$current=$this->large_images_arr;   
		$file=trim($dir,'/');
		$file='image_info_'.$file.'_'.$this->tablename; 
		(!is_dir(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Image_info_dir))&&mkdir(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Image_info_dir,0755,1);
		if (!file_put_contents(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Image_info_dir.$file,serialize($current))){
			mail::alert('Problem Saving '.Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Image_info_dir.$file);
			}
		}
	}
	
function destructor(){// css is rendered to file before destructor
	($this->edit)&&$this->update_image_arr(); 
	$this->deltatime->delta_log('begin destructor'); 
//$this->tinymce();f
	echo '<div class="inline floatleft"><!-- float buttons-->';
	$msg='Advanced Style Css is Always Displayed On in Normal Webpage but toggled in the editor. Toggle here';
	if (!Sys::Advanced) 
		printer::printx('<p class="buttonnavymini info supertiny" title="'.$msg.'"> <a class="info click" href="'.Sys::Self.'?advanced">Enable Advanced Display</a></p>');
	else printer::printx('<p class="buttonnavymini info supertiny" title="'.$msg.'"> <a class="info click" href="'.Sys::Self.'?advancedoff">Disable Advanced Display</a></p>'); 
		echo '</div><!-- float buttons--><!--float button-->'; 
	if (isset($_GET['iframepos']))return;//the following unnecessary for updating css and flatfiles.
	if (Sys::Methods)   Sys::Debug(__LINE__,__FILE__,__METHOD__);if (Sys::Quietmode) return;
	if (isset($_POST['submit'])){//printer::vert_print($this->backup_page_arr); 
		if (isset($_SESSION[Cfg::Owner.'QUERY'])){
			printer::horiz_print($_SESSION[Cfg::Owner.'QUERY']);
			unset($_SESSION[Cfg::Owner.'QUERY']);
			}
		if (isset($_SESSION[Cfg::Owner.'QUERY_select'])){
			$this->show_more('Show select Queries');
			printer::horiz_print($_SESSION[Cfg::Owner.'QUERY_select']);
			$this->show_close('Show select Queries');
			unset($_SESSION[Cfg::Owner.'QUERY_select']);
			} 
		(!isset($_SESSION[Cfg::Owner.'update_msg']))&& $_SESSION[Cfg::Owner.'update_msg']=array();
		/*if (isset($this->backup_page_arr)&&count($this->backup_page_arr)>0){
			$_SESSION[Cfg::Owner.'backup_page_arr']=$this->backup_page_arr;
			 
			}*/ //not used anymore
		if (count($this->success)>0){
			foreach($this->success as $msg){
				$_SESSION[Cfg::Owner.'update_msg'][]=NL.printer::alert_pos($msg,1,true);
				echo printer::alert_pos($msg,1);
				}
			}
		if (count($this->message)>0){ 
			foreach($this->message as $msg){
				$_SESSION[Cfg::Owner.'update_msg'][]=NL.printer::alert_neg($msg,1,true);
				echo printer::alert_neg($msg,1);
				}
			}
    
		if (count($this->instruct)>0){ 
			foreach($this->instruct as $msg){
				$_SESSION[Cfg::Owner.'update_msg'][]=NL.printer::alert_neu($msg,1,true);
				echo printer::alert_neu($msg,1);
				}
			}
		if (count($this->alert)>0){
			foreach($this->message as $msg){
				$_SESSION[Cfg::Owner.'update_msg'][]=NL.printer::alert_neu($msg,1,true);
				echo printer::alert_neg($msg,1);
				}
			}
		}
	(Sys::Deltatime)&&$this->deltatime->delta_log(__line__.' @ '.__method__.'  ');
	if($this->edit){
		if ($this->edit&&Sys::Pass_class){  
			 
			//header( 'location:'.Sys::Self.'?returnpass='.Sys::Returnpass.'&tbn='.$this->tablename);
			}
		if (count($this->list)>0){
			print NL.'Collect List:'.NL;
			printer::vert_print($this->list);
			}
		(Sys::Deltatime)&& $this->deltatime->return_delta_log();
	printer::pclear();
		}
	
	$q="select blog_id from $this->master_post_table where blog_unclone!='' and blog_unstatus='unclone' AND blog_table_base='$this->tablename'";  
	$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	$count=0;
	if ($this->mysqlinst->affected_rows()) {
		while(list($blog_id)=$this->mysqlinst->fetch_row($r,__line__,__method__)){
			if (in_array($blog_id,$this->current_unclone_table)) continue;
			$count++;
			}
		}
	if ($this->edit&&$count>0){  
		$this->styleoff=true;//redundant
		echo '<div class="editbackground width600 editfont fd5brightgreen" id="leftovers"><!--begin Unclone Orphans-->';
		$q="select blog_id,blog_type,blog_order,blog_table,blog_data1 from $this->master_post_table where blog_unclone!='' and blog_unstatus='unclone' AND blog_table_base='$this->tablename'";  
		$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);	 
		if ($this->mysqlinst->affected_rows()) {
			printer::printx('<p class="fsminfo editbackground large editcolor width500">This is a list of <span class="info" title="leftover unclones are unclones of deleted parents previously cloned on this page"> leftover unclones </span> which you may Delete or Move elsewhere.</p>');// <span class="red">Caution: </span> Unclones remain active if the parent is ReCloned they Will Again Arise and Unclone!</p>');
			while(list($blog_id,$blog_type,$blog_order,$blog_table,$blog_data1)=$this->mysqlinst->fetch_row($r,__line__,__method__)){
				$this->edit=false;
				$data=$blog_table.'_'.$blog_order;
				if (in_array($blog_id,$this->current_unclone_table)) continue;
				 echo '<div class="fs4aqua maxwidth500"><!--Wrap View-->';
				 //
				 $this->accessvar_obj($this->master_post_table,Cfg::Post_fields,'blog_table',$blog_table,'blog_order',$blog_order);
  				//self::editpages_obj($this->master_post_table,Cfg::Post_fields,'','blog_order',$blog_order,'blog_table',$blog_table,'populate_data');
				$this->blog_id=$blog_id;
				$this->column_level=0;
		
				$this->column_net_width[$this->column_level]=500;
		
				
				//$this->total_float(false,true);  
				$id=($this->blog_type=='nested_column')?$this->blog_data1:$this->blog_id;
				$name=($this->blog_type=='nested_column')?'remove_unclone_column':'remove_unclone_post';
				$msg=($this->blog_type=='nested_column')?' To MOVE IT ENTIRELY Elsewhere OR SELECT specific POST IDs To Copy/Move Elsewhere':' to Move This Post Elsewhere';
				$post_prefix=($this->blog_type==='nested_column')?'C':'P';
				printer::printx('<p class="fs1black editbackground editcolor"><input type="checkbox" name="'.$name.'[]" value="'.$id.'">Check Here to Delete Orphaned Unclone Type: ' .str_replace('_',' ',strtoupper($this->blog_type)).' OR Use Id '.$post_prefix.$id.$msg.'  </p>');
				$this->viewport_current_width=500;
				$this->show_more('View '.$blog_type,'Close View');//show more View
				echo '<div style="max-width:500px" class="maxwidth500 fs4pos"><!--view unclone wrap-->';
				$this->blog_table_base='';
				$this->col_table_base='';
				if ($this->blog_type==='text'){
				
					$this->text_render($data,$this->blog_table);
					}
					#blog_type,blog_pic,blog_style,blog_text,blog_link,blog_linkref,blog_order
				if ($this->blog_type==='image'){
					$this->build_pic($data,Cfg_loc::Root_dir.Cfg::Page_images_dir); 
					 }
				if ($this->blog_type==='float_image_right'){
					$this->css.="\n.$data$this->pic_ext {float:right;}";
					$this->float_pic($data.$this->pic_ext,$data, Cfg_loc::Root_dir.Cfg::Page_images_dir); 
					}
				if ($this->blog_type==='float_image_left'){
					$this->css.="\n.$data$this->pic_ext {float:left;}";
					$this->float_pic($data.$this->pic_ext,$data, Cfg_loc::Root_dir.Cfg::Page_images_dir); 
					 }
				 if ($this->blog_type==='video'){  
					$this->video_post($data,$this->blog_vid_info);
					}
				 if ($this->blog_type==='contact'){ 
					$this->contact_form($data,'',false,'Edit Overall Contact Form Styling',true,$this->blog_table); 
					}
				if ($this->blog_type==='social_icons'){
					$this->social_icons($data,'',false,'Edit Social Icon Styling',true,$this->blog_table); 
					}
				 if ($this->blog_type==='navigation_menu'){  
					$this->nav_menu($data,$this->blog_data1,false,'',true,$tablename); 
					} 
		 
				if ($this->blog_type==='nested_column'){
					$q="select col_table from $this->master_col_table where col_id=$this->blog_data1"; 
					$rnc=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
					list ($col_table)=$this->mysqlinst->fetch_row($rnc, false);
					
					$this->publish($this->blog_data1);//view unpublished posts if any
					//we must pre populate all values for this column as it is done in previous round of blog_render! 
					$col_field_arr2=$this->col_field_arr;
					$col_field_arr2[]='col_id';
					##get column fields for nested column needed in next go round!
					$q='select col_id,'.Cfg::Col_fields." from $this->master_col_table where col_id='$this->blog_data1'";
					$pp=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
					if (!$this->mysqlinst->affected_rows()){
						 
						printer::alert_neg('No  Rows Selected Delete Me Anyway');
						}
					 
					 
					
					else{  
						$row=$this->mysqlinst->fetch_assoc($pp,__LINE__,__METHOD__);
						foreach ($col_field_arr2 as $field) {
							$this->$field=$row[$field];// create upcoming nested column values
							}
						$this->column_options=explode(',',$this->col_options);
						for ($i=0;$i <count(explode(',',Cfg::Column_options)); $i++){
							if (!array_key_exists($i,$this->column_options))$this->column_options[$i]=0;
							}  
						$this->column_level=0;
						$this->col_primary=1; //avoids problems with column level
						$this->blog_render($this->blog_data1,true,$this->tablename);		  
						}			 
					 
					 
					}//end nested column....
					
				echo '</div><!--view unclone wrap-->';
				$this->show_close();//show more View
				echo '</div><!--Wrap View-->';
					
					 
				}//end while..
			
			echo '</div><!--begin Unclone Orphans-->';
				 
			}//if affected rows
		$this->edit=true; //reset back after displaying orphaned unclones
		if ($count>0&&!isset($_SESSION[Cfg::Owner.'_'.$this->tablename.'_leftovers'])){
			echo '<script >
			gen_Proc.use_ajax(\''.Sys::Self.'?leftovers\',\'handle_replace\',\'get\'); 
			</script>
			';
		
			}
		if ($count==0)unset($_SESSION[Cfg::Owner.'_'.$this->tablename.'_leftovers']);
		else $_SESSION[Cfg::Owner.'_'.$this->tablename.'_leftovers']=true;
				
		}// if this edit...
	 
			
	($this->edit&&(Sys::Tables||Sys::Server))&&printer::vert_print($_SERVER);
	((Sys::Tables||Sys::Request))&&printer::print_request();
	($this->edit&&(Sys::Tables||Sys::Session))&&printer::vert_print($_SESSION);
	// Turn off bottom print(isset($_POST['submit'])&&Sys::Request)&&$_SESSION[Cfg::Owner.'update_msg_bottom']=printer::print_request(true);
	
		$iframe_msg= (!isset($this->iframe_update_msg))?'Allowing for Data Update of Content in iframes to finish loading at top of this page':$this->iframe_update_msg;	
	  if (store::getVar('backup_clone_refresh_cancel')){//cancel header redirect style refresh and allow iframes to complete
	#this is replaced with alert message to update when ready not everytime!!
		if (ob_get_contents()) {
			$data = ob_get_contents();
			ob_end_clean();
			 
			printer::alert_neg($iframe_msg);
			printer::alert_pos('<a style="text-decoration:underline" href="'.Sys::Self.'">When Finished Click here to Refresh Page for Messages, etc. without resubmitting content</a>');
			echo $data;
			return;
			}
		else printer::alert_neg('No ob get contents message');
		}
	if (Sys::Methods)   Sys::Debug(__LINE__,__FILE__,__METHOD__);
	#header 
	if((!Sys::Debug&&!Sys::Refreshoff&&(isset($_POST['submit'])||Sys::Bufferoutput))||isset($_GET['advanced'])||isset($_GET['advancedoff'])){ 
		ob_end_clean();
		header( 'location:'.Sys::Self); // this is for css updating mostly
		} 
	//the $_GETs will auto refresh w/o the get so easy there
	if (Sys::Methods)   Sys::Debug(__LINE__,__FILE__,__METHOD__); 
	
	if($this->edit==='return')return;#class object invoked for function access only
	if (request::check_request_data('editstyle')||request::check_request_data('iframepos'))return;
	if (Sys::Methods)   Sys::Debug(__LINE__,__FILE__,__METHOD__);
     if (Sys::Debug||Sys::Includes){  
		Sys::Includes();#shows all included files...
		}
   if (Sys::Debug){
		$dv=get_defined_vars();
		echo NL.'defined vars: '; print_r($dv);
		}
	if ($this->users_record){ return; 
		$usr=users::instance();
	   //($this->edit)&&$usr->put('edit','edit');#defualt is noedit..
		//$usr->delta_log($this->deltatime->return_delta_log());
		$usr->diff_request_ini=$this->deltatime->diff_request_ini;
		($this->browser_info&&$this->browser_active)&&$usr->browser_info='true'; 	
		$usr->cookie_count=$this->cookie_count;
		$usr->cookie_date=$this->cookie_date;  
		$usr->cookie_reference=$this->cookie_reference;
		$usr->session_log_count=$this->session_log_count;
		$usr->session_log_id=$this->session_log_id; 
		$usr->gen_data_base();
		}
	
	if (Sys::Methods)   Sys::Debug(__LINE__,__FILE__,__METHOD__);   
	   if (Sys::Loc)(isset($php_errormsg))&&$this->alert($php_errormsg);
	  if (Sys::Debug||Sys::Deltatime)echo 'deltatime end: '.$this->deltatime->delta(); #do not register hit//($this->edit&&Sys::Pass_class)
	//if(!Sys::Debug&&!Sys::Refreshoff&&(isset($_POST['submit'])||Sys::Bufferoutput)||isset($_GET['advanced'])||isset($_GET['advancedoff'])){//we are buffering output upon submit for a header( refresh) in order to refresh styling changes...
	if (ob_get_level()){//if not redirected by the header location redirect and if ob_start is true then buffer output automatically
		#editpages is output
		#buffer
		$data = ob_get_contents();
		 ob_end_clean();
		 echo $data;
		 mail::alert('ob_get_contents bypassed header redirect');
		 //if (!file_put_contents(Sys::Home_pub.'bufferoutput.txt',$data)) mail::alert('buffer output data file failure');
		}
	if (Sys::Methods)   Sys::Debug(__LINE__,__FILE__,__METHOD__);
	$this->deltatime->delta_log('end destructor');  
    }       
#********************************BEGIN CSS FUNCTIONS**************************
#csscreate  #cssinit

function css_stylesheet_include(){
	$array=array_unique($this->page_stylesheet_inc);  
	$data= (count($array)>0)?implode(',',$array):''; 
	file_put_contents(Cfg_loc::Root_dir.Cfg::Data_dir.'page_stylesheet_'.$this->tablename.$this->passclass_ext,$data);
	}
	
		

function render_css(){  //accessed in edit mode only
	$this->css_stylesheet_include();//include stylesheets of non local clones
	(Sys::Deltatime)&&$this->deltatime->delta_log(__line__.' @ '.__method__.'  ');
 
	if(!Sys::Style)return;
	$this->css_at_fonts();//must run first!! initize css for extended fonts
	//$this->css_color_background(); #!IMPORTANT THAT THIS IS FIRST TO PROCESS BACKGROUND
	 $this->css_initiate(); 
	$this->css_generate();
	$this->css_custom_page();
	 $this->css_nav();  
	$this->css_custom();// can be used to bypass upper css info....    $this->css_pics(); currently not in use
	$this->css_gall();
	$this->css_grid();  
	$this->css_custom_site();
	$this->css_custom_gallery(); 
	$this->css_highslide();
	$this->css_render_file();
	$this->css_edit_file();
	}
#cssgrid #cssrwd  #grid ion css_rwd
function css_grid(){
	$this->css_grid='';
	if (!isset($this->grid_class_selected_wid_array))return;
	$this->css_grid='
	[class^="wid-bp"], [class*=" wid-bp-"],[class^="left-bp"], [class*=" left-bp-"],[class^="right-bp"], [class*=" right-bp-"] {
	float:left;  
	}
    ';//display:inline-block ;vertical-align: middle;baseline;  not working
      foreach (array('wid','right','left')as $type){
			$this->{'grid_class_selected_'.$type.'_array'}=array_unique($this->{'grid_class_selected_'.$type.'_array'});
		}
		
	foreach(array_unique($this->column_grid_css_arr) as $arr){
		list($gu,$bpv)=explode('@@',$arr); 
		$punit=floor(100000/$gu)/1001;
		$width100=1000/1001*100;
		$bp_arr=explode(',',$bpv);
		process_data::natkrsort($bp_arr);
		$this->css_grid.='
		@media screen and (min-width: '.($bp_arr[0]+1).'px){';
			$this->css_grid.=(in_array('wid-bp-max'.$bp_arr[0].'-0-'.$gu,$this->grid_class_selected_wid_array,true))?'
				.wid-bp-max'.$bp_arr[0].'-0-'.$gu.'{display:none}
				':'';
			for($i=1; $i<$gu; $i++){
				$this->css_grid.=(in_array('wid-bp-max'.$bp_arr[0].'-'.$i.'-'.$gu,$this->grid_class_selected_wid_array,true))?'
				.wid-bp-max'.$bp_arr[0].'-'.$i.'-'.$gu.'{width:'.round(($i*$punit),3).'%;}
				':'';
				}
			for($i=.5; $i<$gu; $i+=.5){
				$i2=(strpos($i,'.5')===false)?$i:str_replace('.5','',$i).'x5';
				$this->css_grid.=(in_array('right-bp-max'.$bp_arr[0].'-'.$i2.'-'.$gu,$this->grid_class_selected_right_array,true))?' 
				.right-bp-max'.$bp_arr[0].'-'.$i2.'-'.$gu.'{margin-right:'.round(($i*$punit),3).'%;}
				':''; 
				$this->css_grid.=(in_array('left-bp-max'.$bp_arr[0].'-'.$i2.'-'.$gu,$this->grid_class_selected_left_array,true))?'
				.left-bp-max'.$bp_arr[0].'-'.$i2.'-'.$gu.'{margin-left:'.round(($i*$punit),3).'%;}
				':'';
				}
			$this->css_grid.=(in_array('wid-bp-max'.$bp_arr[0].'-'.$gu.'-'.$gu,$this->grid_class_selected_wid_array,true))?'
				.wid-bp-max'.$bp_arr[0].'-'.$gu.'-'.$gu.'{width:'.$width100.'%;}
				}
				':'}';
			 
		$max=count($bp_arr);
		for ($bc=0; $bc<$max; $bc++){
			$bp=$bp_arr[$bc];
			$mw=$minw='';
			if ($bc < $max-1){
				$minw=' and (min-width:'.($bp_arr[$bc+1]).'px)';
				$mw='-'.$bp_arr[$bc+1];
				}
			else $mw='-'.$bp;
			$this->css_grid.='
			@media screen and (max-width: '.($bp).'px)'.$minw.'{';
			$this->css_grid.=(in_array('wid-bp-'.$bp.$mw.'-0-'.$gu,$this->grid_class_selected_wid_array,true))?'
				.wid-bp-'.$bp.$mw.'-0-'.$gu.'{display:none;}
				':'';
			for($i=1; $i<$gu; $i++){
				$this->css_grid.=(in_array('wid-bp-'.$bp.$mw.'-'.$i.'-'.$gu,$this->grid_class_selected_wid_array,true))?'
				.wid-bp-'.$bp.$mw.'-'.$i.'-'.$gu.'{width:'.round(($i*$punit),3).'%;}
				':''; 
				}
			for($i=.5; $i<$gu; $i+=.5){
				$i2=(strpos($i,'.5')===false)?$i:str_replace('.5','',$i).'x5';
				$this->css_grid.=(in_array('right-bp-'.$bp.$mw.'-'.$i2.'-'.$gu,$this->grid_class_selected_right_array,true))?' 
				.right-bp-'.$bp.$mw.'-'.$i2.'-'.$gu.'{margin-right:'.round(($i*$punit),3).'%;}
				':'';
				$this->css_grid.=(in_array('left-bp-'.$bp.$mw.'-'.$i2.'-'.$gu,$this->grid_class_selected_left_array,true))?'
				.left-bp-'.$bp.$mw.'-'.$i2.'-'.$gu.'{margin-left:'.round(($i*$punit),3).'%;}
				':''; 
				}
			$this->css_grid.=(in_array('wid-bp-'.$bp.$mw.'-'.$gu.'-'.$gu,$this->grid_class_selected_wid_array,true))?'
				.wid-bp-'.$bp.$mw.'-'.$gu.'-'.$gu.'{width:'.$width100.'%;}
				}
				':'}';
			}//foreach bp
		}//foreach 
	}
function css_custom_page(){
	//place custom css in page specific function css_custom_page in ie  pagetitle.class.php
     } 	
function css_custom_site(){
	//place custom css in site specific function css_custom_site in ie  site_master.class.php
	//updates will not affect custom changes made in site_master.class.php or page specific  class.php files
     } 
function css_custom_gallery(){
	//place custom css in site specific function css_custom_gallery in  gllery_loc.class.php
	//updates will not affect custom changes made in site_master.class.php or page specific  class.php files
     } 	
function css_at_fonts(){
	$check=array();
	$fontcss='';
	//if (empty($this->at_fonts))exit('no vlue'); else print_r($this->at_fonts);
	foreach($this->at_fonts as $af){   
		$af=explode(',',$af);
		$after=str_replace(' ','',$af[0]);
		if (!in_array($after,$check)){
			$fontcss.='
@font-face {
  font-family: \''.$af[0].'\';
  src: url(../fonts/'.$after.'.woff) format(\'woff\');
}';
			}
		$check[]=$after;
	
		}
	$this->sitecss.=$fontcss;
	}
 
 
function css_initiate(){
	$font=(!empty($this->master_font))?'font-family: '.$this->master_font.';':'';
	$color=(!empty($this->editor_color))?'color: #'.$this->editor_color.'; ':'color: #FF5900; ';
     $this->initcss.='
* {
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box; }
	html, body, div, span, applet, object, iframe,
h1, h2, h3, h4, h5, h6, p, blockquote, pre,
a, abbr, acronym, address, big, cite, code,
del, dfn, em, font, img, ins, kbd, q, s, samp,
small, strike, strong, sub, sup, tt, var,
dl, dt, dd, ol, ul, li,
fieldset, form, label, legend,
table, caption, tbody, tfoot, thead, tr, th, td {
	margin: 0;
	padding: 0;
	outline: 0;   
	vertical-align: baseline;
}
body h1,body h2, body h3,body h4,body h5,body h6{
	margin: 0;
	padding: 0;
	outline: 0;
	padding-bottom:0; 
	vertical-align: baseline;
}
textarea {color:inherit;font-family:inherit; font-size:inherit;font-weight:inherit;background:inherit;} 
.nav ul,.nav li{
	list-style: none;list-style-type:none;
}
/* tables still need  cellspacing="0"  in the markup */
table {
	border-collapse: separate;
	border-spacing: 0;
}
caption, th, td {
	text-align: left;
	font-weight: normal;
}
blockquote:before, blockquote:after,
q:before, q:after {
	content: "";
}
blockquote, q {
	quotes: "" "";
}

	.nav ul li {LIST-STYLE-TYPE: none;}
	a:link,a:visited,a:active,body ul a:link {font-size:inherit; text-decoration:none;}
	td, th {border-width:1px;  border-style:solid;}
	.border2{border-width:2px;}
	a:link.acolor, a:visited.acolor {text-decoration: underline;}
	a:link.acolor:hover,a:visited:hover,a:hover {color:blue}
	a:link.alistblue {background:#170F7E; color:#F7FDFF;  text-decoration:underline;}
	a:link.alist{text-decoration: underline;color:#5340D1;}
	 a:visited.alistblue {color:#9D97E3;}
	a:link.alistblue:hover, a.alistblue:visited:hover,a:link.alistblue:visited:hover, a.alistblue:visited:hover{color:blue}
	a:link.alist,a.alist:visited{text-decoration: underline;color:inherit;} 
	a:link.alist:hover,a.alist:visited:hover,a:link.alist:visited:hover,a.alist:visited:hover{color:blue}
	a:link.info,a:visited.link {color:#'.$this->info.';background:rgba(255,255,255,0.33)}
	a:link.click,a:visited.click {text-decoration: underline;padding:3px 3px;display:inline-block;text-align:left; cursor: pointer;  text-decoration: underline;}
	.click{padding:3px 3px;display:inline-block;text-align:left; cursor: pointer;  text-decoration: underline;}
	.navr1{display:inline-block; margin:  5px 0; font-size: 1em; background: #e6eff1; padding:  3px;
	color:#'.$this->navy.';
	-moz-border-radius:5px;
	   -webkit-border-radius:5px;
	   border-radius:5px; 
	   border: 2px  double #'.$this->navy.'}
	dl,li,dt,dd, pre,form,body,html,blockquote,ul,input,h1,h2,h3,h4,p,span,div {margin: 0; padding: 0;}
	.hide{display:none;}
	.width100{width:100%}
	.maxwidth100 {max-width:100%}
	.maxwidth95 {max-width:95%}
	.maxwidth800 {max-width:800px;} 
     .maxwidth700 {max-width:700px;} 
     .maxwidth600 {max-width:600px;}
     .maxwidth500 {max-width:500px;}
     .maxwidth400 {max-width:400px;}
     .maxwidth250 {max-width:250px;}
    .alert_neg {color:#'.Cfg::RedAlert_color.';}
    .ramana{padding:.1em .5em;text-align:left; color:#'.$this->editor_color.';background:#'.$this->editor_background.'; display:inline-block;}
	.ramanaleft{padding:.1em .5em;color:#'.$this->editor_color.'; text-align: left;background:#'.$this->editor_background.'; display:inline-block;}
	a img { border: none;}
	input {line-height:125%;}
	.addheight{line-height:200%;}
	.whitebackground {background:#ffffff}
	 a:link, a:visited{color: inherit;}
	.link {text-decoration:underline;cursor:pointer;color:blue;}
     .clear{ clear: both; }
	.p5all {padding: 5px;}
	.p10all {padding: 10px;}
	.ht0{height:0px;overflow:hidden;}
	.ht20{ height: 20px;}
    .pt50 {padding-top: 50px;}  
    .pb5 {padding-bottom: 5px;} 
    .pb50 {padding-bottom: 50px;}  
    .pb10 {padding-bottom: 10px;}  
    .pt25 {padding-top: 25px;}
    .pb25{padding-bottom:25px;}
    .pt10 {padding-top: 10px;}
    .mspace {margin-bottom:3px; margin-top:3px}
    .pt2 {padding-top: 2px;}
    .pt5 {padding-top: 5px;}
    .pb2{padding-bottom:2px;} 
    .pb5{padding-bottom:5px;} 
    .pb10{padding-bottom:10px;}
	.m1all {margin:1px;}
	.m2all {margin: 2px;}
	.m5all {margin: 5px;}
	.m10all {margin: 10px;}
    .mt5 {margin-top:5px;}
    .mt10 {margin-top:10px;}
    .mt15{margin-top:15px;}
    .mt25{margin-top:25px;}
    .mb5{margin-bottom:5px;} 
    .mb10{margin-bottom:10px;}
    .mb25{margin-bottom:25px;}
    .mb50{margin-bottom:50px;}
    .ml5{margin-left:5px} 
    .ml10{margin-left:10px}
    .pt5 {padding-top: 5px;}
    .pb5{padding-bottom:5px;}
    .pl2 {padding-left:5px;}
    .pl5 {padding-left:2px;}
    .pl10 {padding-left:10px;}
    .pl25 {padding-left:25px;}
	.p10 {padding: 10px;}
	.p5 {padding: 5px;}
	.italic{font-style: italic;}
    .left {text-align:left;}
    .center {text-align:center;}
    .right {text-align:right;}
    .normal {font-size:16px;}
    .large {font-size: 18px;}
    .bold {font-weight:bold;}
    .cenmarg {margin:0 auto;}
    .boldest {font-weight: 900;}
    .larger,.largest {font-size: 21px;}
    .vlarge {font-size: 24px;}
    .tiny{font-size: 9px;}
    .smallest{font-size: 11px; font-weight:400}
    .smaller {font-size: 12.5px;}
	.small {font-size: 14px;}
	.supersmall {font-size:8px;}
	.supertiny{font-size:6px;}
    .med {font-size: 1em;}
    .darkgreen {color:#205820;}
    .white {color:white;}
    .black {color:black}
    .darkergreen {color:#194019;}
    .darkblue {color:#224488;} 
     .pos {color:#'.Cfg::Pos_color.';}
	 a.pos {color:#'.Cfg::Pos_color.';}
    .neu {color:#'.Cfg::Info_color.';}
    .opac {opacity:0}
    .red,.neg{color:#'.Cfg::RedAlert_color.';}
    .rad10{-webkit-border-radius: 10px 10px 10px 10px;
	border-radius: 10px 10px 10px 10px;} 
	.rad5{-webkit-border-radius: 5px 5px 5px 5px;
	border-radius: 5px 5px 5px 5px;} 
	.rad3{-webkit-border-radius: 3px 3px 3px 3px;
	border-radius: 3px 3px 3px 3px;}
    .left5{padding-left:5px}
    .left10{padding-left:10px}
    .left20{padding-left:20px}
    .right5{padding-right:5px}
    .right10{padding-right:10px}
    .right20{padding-right:20px}
	.fs2navy {border: 2px  solid #'.Cfg::Navy_color.' }
	.fs1black {border: 1px  solid #000; }
	.pinkbackground {background:#fdf0ee;} 
    .marginauto {margin-left:auto; margin-right:auto;}
    .block{display:block}
    .displaytable{display:table}
    .inline {display:inline;padding:2px 5px;}
	.inlineblock{display:inline-block;}
	.inlinetable{display:inline-table;margin-left:auto;margin-right:auto;}
	.thumbpad {padding-left:2px; padding-top:2px;}
	.floatleft {float:left; }
	.floatright {float:right; }
	p.aShow img{ width:40px; height:auto;} 
	.margincenter {margin-left:auto; margin-right:auto;text-align:center;}
	.navy{color:#'.Cfg::Navy_color.';}
	.comment { margin-left:auto; margin-right:auto; font-family: Arial, Helvetica, sans-serif; font-weight: 500;  color: #F3FDFF; line-height:125%; 
				background: -webkit-linear-gradient(rgba(245,247,250,0.6),rgba(219,221,223,0.6),rgba(219,221,223,0.6),rgba(216,221,223,0.6),rgba(245,247,250,0.6)); /* For Safari 5.1 to 6.0 */
				background: -o-linear-gradient(rgba(245,247,250,0.6),rgba(219,221,223,0.6),rgba(219,221,223,0.6),rgba(216,221,223,0.6),rgba(245,247,250,0.6)); /* For Opera 11.1 to 12.0 */
				background: -moz-linear-gradient(rgba(245,247,250,0.6),rgba(219,221,223,0.6),rgba(219,221,223,0.6),rgba(216,221,223,0.6),rgba(245,247,250,0.6)); /* For Firefox 3.6 to 15 */
				background: linear-gradient(rgba(245,247,250,0.6),rgba(219,221,223,0.6),rgba(219,221,223,0.6),rgba(216,221,223,0.6),rgba(245,247,250,0.6));
				 }
	.buttonnavy{
	   background: #FFFAFF; 
	   margin: 5px 5px ;
	   padding: 4px;
	   border:2px;
	   border-style: solid;
	   border-color:#2B1DC9;  
	   -moz-border-radius:5px;
	   -webkit-border-radius:5px;
	   border-radius:5px;
	   -moz-box-shadow:inset -3px -3px  3px  #aaa5e9,inset 2px  2px  2px  #aaa5e9;
	   -webkit-box-shadow:inset -3px -3px 3px  #aaa5e9,inset 2px  2px  2px  #aaa5e9;
	   box-shadow:inset  -3px -3px  3px #aaa5e9, inset 2px  2px  2px  #aaa5e9;
	    cursor:pointer; }
	.cursor {cursor: pointer;}
	.mce-btn-group .mce-btn {
    float: left;
}
.mceToolbar td {float: left;}
table.mceToolbar td {float: left;}
#mceu_182-open {font-size:12px}
/*video {
  width: 100%    !important;
  height: auto   !important;*/
  
.video-back-container { 
width:100%;
clear: both;
overflow: hidden;
}

.video-back-container  iframe,
.video-back-container  object,
.video-back-container  embed,
.video-back-container {
position: absolute;
top: 0;
left: 0;
width: 100%;
height: 100%;
z-index:-99;
}
    	
.video-container {
float: none;
    clear: both;
    width: 100%;
    position: relative;
    padding-bottom: 56.25%;
    padding-top: 25px;
    height: 0;  overflow: hidden;
}
  
.video-container div iframe,
.video-container div object,
.video-container div embed 
{
position: absolute;
top: 0;
left: 0;
width: 100%;
height: 100%;
}
body{text-align:center;}
    ';
    }
 
 function css_render_file(){ if (Sys::Cssoff) return;
	if(Sys::Quietmode||Sys::Debug)return;
	$this->sitecss.="\n".$this->gall_css."\n".$this->nav_site_css."\n".$this->initcss."\n".$this->highslidecss;
	$this->css.="\n".$this->navcss."\n".$this->imagecss."\n".$this->css_grid."\n".$this->mediacss; 
    file_put_contents($this->roots.Cfg::Style_dir.$this->tablename.$this->css_suffix.'.css',$this->css);//for add pages Pics etc.
    file_put_contents($this->roots.Cfg::Style_dir.'gen_page.css','@charset "UTF-8";'. $this->sitecss);//for add pages Pics etc.
     file_put_contents($this->roots.Cfg::Style_dir.$this->tablename.'_adv'.$this->css_suffix.'.css','@charset "UTF-8";'. $this->advancedmediacss);//for add pages Pics etc.
       
    /*if ($this->gallery_global===true&&strpos(Sys::Self,'expand')!==false){  
	  	$mastertablename=check_data::return_field_value(__METHOD__,__LINE__,__FILE__,Cfg::Master_gall_table,$this->tablename,'gall_ref','master_gall_ref');
		if (empty($mastertablename))return;
		$table_list=check_data::return_gall_list(__METHOD__,__LINE__,__FILE__,$mastertablename);
		foreach ($table_list as $tablename){ 
			file_put_contents($this->roots.Cfg::Style_dir.$tablename.$this->css_suffix.'.css', $this->css); // echo 'tablename css expand is '.$this->css_suffix.$tablename;
			}
	   }//backs up all the expand css tables *///file_put_contents(Cfg_loc::Localroot_dir.'includes/'.$this->tablename.$this->data28.'.css', $this->css);
   // if (is_file(Cfg_loc::Localroot_dir.'includes/'.$this->tablename.$data_unlink.'.css')){
	 //  unlink(Cfg_loc::Localroot_dir.'includes/'.$this->tablename.$data_unlink.'.css');
	 //  }
	printer::alert_pos('Css file Gen Complete');
    }
    
function css_edit_file(){
    $this->css_edit_page_common();
    $this->css_edit_page();   // this is for page_specific editcss...
    //echo  $this->roots.Cfg::Style_dir.$this->tablename.$this->css_suffix.'edit.css :' . $this->editcss;
   file_put_contents($this->roots.Cfg::Style_dir.$this->tablename.$this->css_suffix.'edit.css', $this->editcss);// editcss generated by all the system css for editcss
   if (Sys::Methods)    Sys::Debug(__METHOD__,__LINE__,__FILE__,' End '.__METHOD__); 
   }// render_edit_file
   
 function css_site_master(){
      $this->css.='
	 ';
	 }
	 
 function css_pics(){
      $this->css.='
	 ';
	 }
  function css_upper(){
     $this->css.='
	 '; 
    }
    function css_mid(){
    $this->css.='
	 ';
    } 
 function css_bottom(){
    $this->css.='
	 ';
    }   
  function css_custom(){
     $this->css.='
	 ';
    }   
function css_highslide(){  //return;
$this->highslidecss='
	.highslide-dimming{background:white}
	 div.highslide-container   { }
	.highslide-container table{background:none;}
	.highslide{outline:none;text-decoration:none;}
	.highslide-active-anchor img{visibility:hidden;}
	.highslide-gallery .highslide-active-anchor img{visibility:visible;cursor:default;}
	.highslide-caption{display:none;}
	.highslide-caption-inner{display:inline-block;}
	.highslide-controls li{float:left;margin:0;padding:5px 0;}
	.highslide-controls a span{display:none;cursor:pointer;}
	.highslide-controls .highslide-previous a{background-position:0 0;}
	.highslide-controls .highslide-previous a:hover{background-position:0 -30px;}
	.highslide-controls .highslide-previous a.disabled{background-position:0 -60px !important;}
	.highslide-controls .highslide-play a{background-position:-30px 0;}
	.highslide-controls .highslide-play a:hover{background-position:-30px -30px;}
	.highslide-controls .highslide-play a.disabled{background-position:-30px -60px !important;}
	.highslide-controls .highslide-pause a{background-position:-60px 0;}
	.highslide-controls .highslide-pause a:hover{background-position:-60px -30px;}
	.highslide-controls .highslide-next a{background-position:-90px 0;}
	.highslide-controls .highslide-next a:hover{background-position:-90px -30px;}
	.highslide-controls .highslide-next a.disabled{background-position:-90px -60px !important;}
	.highslide-controls .highslide-move a{background-position:-120px 0;}
	.highslide-controls .highslide-move a:hover{background-position:-120px -30px;}
	.highslide-controls .highslide-full-expand a{background-position:-150px 0;}
	.highslide-controls .highslide-full-expand a:hover{background-position:-150px -30px;}
	.highslide-controls .highslide-full-expand a.disabled{background-position:-150px -60px !important;}
	.highslide-controls .highslide-close a{background-position:-180px 0;}
	.highslide-controls .highslide-close a:hover{background-position:-180px -30px;}
	 .highslide-overlay,.hidden-container{display:none;} 
	.highslide-controls a.disabled,.highslide-controls a.disabled span{cursor:default;}
	.highslide-controls a.disabled,.highslide-controls a.disabled span{cursor:default;}
	 .dimming_page_image{position:absolute; '.$this->page_background.';} 
	';
	}
#cssnav


/*transition: top 300ms cubic-bezier(0.17, 0.04, 0.03, 0.94);
-webkit-transform-origin: 0 0;
		-webkit-animation: Grow 0.4s ease-in-out;
		-moz-animation: Grow 0.8s ease-in-out;
		-o-animation: Grow 0.4s ease-in-out;
		animation: Grow 0.4s ease-in-out;
		-webkit-backface-visibility: visible !important;
		backface-visibility: visible !important;*/

function css_gall(){
	$this->gall_css='
	 .menu-icon{position: absolute; left:20%; top:50px; z-index:100;}
 .containbackto { position:relative; float:left;  width:6'.$this->rem.';  margin-left:200px; margin-top:100px; }
.backto { position:absolute; top: 0px; left: 0px; background:#fff; filter:alpha(opacity=35);opacity:.35; 
  width:100%; height:100%;  -moz-border-radius:3px; -webkit-border-radius:3px; border-radius:3px;}
.refbackto{ position:absolute; top: 0px; left: 0px; width:100%;
text-align:center; font-size: .9'.$this->rem.'; font-family: arial,sans-serif;font-weight: 700;
 color:rgba(217, 224, 152, 1);}
.fs1color{border:1px solid  #'.$this->editor_color.';}  
 a:link.darkpurple,  a:visited.darkpurple{color:#8700b3;}
.mback {background:#f8e7e6;}
.backtoborder,.backto,.containbackto{padding:.3'.$this->rem.' 0 .4'.$this->rem.' 0;}
.backtoborder{ position:absolute; top: 0px; left: 0px;
 width:100%; height:100%; 
 -moz-border-radius:3px; -webkit-border-radius:3px; border-radius:3px;
-moz-box-shadow: 1px 1px 5px -4px #0a2268;
-webkit-box-shadow: 1px 1px 5px -4px #0a2268;
box-shadow: 1px 1px 5px -4px #0a2268; 
	     } 
.addtbn{padding-top:5px;font-variant: small-caps; color:#fff; font-size: 1.2em;}
.preview{margin: 0 auto;} 
	.image-wrap{margin-top:50px; display:table;margin-right:auto;margin-left:auto; position:relative;}
	.prev{position:absolute; top:0px; left:0;width:50%;height:100%;cursor:pointer;}
	.next{position:absolute; top:0px; left:50%;width:50%;height:100%;cursor:pointer;}
	.prev a:hover{cursor:pointer; background: url(../'.$this->previous_image.');background-position:50% '.$this->hover_image.'%;background-repeat:no-repeat;}
	.next a:hover{cursor:pointer; background: url(../'.$this->next_image.');background-position:50% '.$this->hover_image.'%;background-repeat:no-repeat;}
	';
	}
function css_nav(){
	$this->nav_site_css='
  .nav_gen ul.top-level.menuRespond   { 
  -webkit-transition: max-height 2s ease;
  -moz-transition: max-height 2s ease;
  -o-transition: max-height 2s ease;
  transition: max-height 2s ease;  
    max-height:2000px;
	}	
.nav_gen{margin-left: auto;	margin-right: auto; display:table;}
.nav_gen A {cursor: pointer;display:block; }
.nav_gen UL UL  {  text-align: center; vertical-align: top;}
.horiz .nav_gen UL LI {display:inline-block;  vertical-align: top;}
.vert  .nav_gen UL LI {display: block; vertical-align: top; }
.hover .nav_gen UL  LI  {position:relative;}
.hover .nav_gen  UL UL {Z-INDEX: 100; LEFT:0; TOP:0; VISIBILITY: hidden;  overflow:hidden;   POSITION: absolute;  }
  .hover .nav_gen  UL :hover UL :hover UL  { VISIBILITY: visible;} 
.hover .nav_gen  UL LI:hover UL  { VISIBILITY: visible } 
.hover .nav_gen ul.sub-level,.hover .nav_gen  ul ul  {  Z-INDEX: 100; }
.hover .nav_gen  UL UL LI  {margin-right:auto; margin-left:auto; display:block;} 
.display .nav_gen  ul.sub-level,.display .nav_gen  UL UL LI  {margin-right:auto; margin-left:auto; display:block;}    
.nav_gen ul li.show_icon   {display:none;}
 .nav_gen ul li:hover ul li.show_icon a:after,
.nav_gen ul li:hover li.show_icon a:hover:after,
 .nav_gen ul li:hover li.show_icon a:hover:after,
 .nav_gen ul li.show_icon a:hover:after,
 .nav_gen ul li:hover ul li.show_icon a:after,
 .nav_gen ul.top-level li.show_icon,.nav_gen li.show_icon a:after{display:none;} 
    .nav_gen ul.top-level li.show_icon p.aShow, ul.top-level li.show_icon p:after{
	background:none; border:none; box-shadow:none;
	webkit-box-shadow:none;moz-box-shadow:none;
	padding:0;
	margin:0;
	}

';
}#end navcss
    
public static function xxinstance($msg='return'){ if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);//static allows it to create an instance without creating a new object
     if  (empty(self::$instance)) {
	   self::$instance = new global_master($msg); 
        } 
    return self::$instance; 
    }    

}//end class
?>