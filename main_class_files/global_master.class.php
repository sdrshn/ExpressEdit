<?php
#ExpressEdit 2.0.1
#see top of global edit master class for system overview comment dir..
/*
 *ExpressEdit is an integrated Theme Creation CMS
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
     protected $flexfail=true;// if true and edimode init flex is off  see #flexfail affects editmode flex on or off
     protected $express=array();//update messages express after body call.
	protected static $colinc=0;
	protected $show_text_style=false;//set default
	protected $comment='Comment';//used to refer to comment or feedback 
	protected $directory_table=Cfg::Directory_dir;
	protected $master_col_table=Cfg::Columns_table;
	protected $master_page_table=Cfg::Master_page_table;//this can be subbed out for displaying backup pages
	protected $master_post_css_table=Cfg::Master_post_css_table;//this can be subbed out for displaying backup pages
	protected $master_post_table=Cfg::Master_post_table;//this can be subbed out for displaying backup pages
	protected $master_gall_table=Cfg::Master_gall_table;//this can be subbed out for displaying backup pages
	protected $master_col_css_table=Cfg::Master_col_css_table;//this can be subbed out for displaying backup pages
	protected $master_post_data_table=Cfg::Master_post_data_table; 
	protected $comment_table='comments';
	protected $login_forum=false; //set to true to  provide security for a forum pages  ie forum_master.class.php
	protected $locked_pages=false;//set to true in site_master.class.php to provide security for whole site or specify for a particlar page ie about_master.class.php
	protected $meta_data=true;// 
	protected $blog_date_on=0;  
	protected $edit_font_size=Cfg::Edit_font_size;
	protected $edit_font_family=Cfg::Edit_font_family;
	protected $header_style='styling/animate.css,styling/slippry.css,styling/photoswipe.css,styling/photoswipe-skin.css';
	protected $header_edit_style='nouislider.css';
	protected $header_script='jquery.min.js,hammer.js';
	protected $header_script_webmode='prefixfree.js';//webmode only
	protected $header_script_function='onload,gen_Proc,autoShow,fadeTo';  //outscript for normal page
	protected $header_edit_script_function='onload_edit,edit_Proc'; //scripts for edit page
	protected $header_edit_script='nouislider.js,jscolor.js,tool-man/core.js,tool-man/events.js,tool-man/css.js,tool-man/coordinates.js,tool-man/drag.js,tool-man/dragsort.js'; //outsidescript for edit page
	//add included php file::   use header_insert function to add to head  links ie css external files etc. 
	protected $onload='';
	protected $edit_onload='';#other copies of edit onload in gallery master addgallerypiccore add page pic core add video
	protected $roots=Cfg_loc::Root_dir;// so test sites render new css etc.  in local root dir  this is antiquated
	protected $css_suffix='';// allows testing with second set of css
	protected $onsubmit='onSubmit="return edit_Proc.beforeSubmit()"';
	protected $form_load='';
	protected $at_fonts=array();//initialized for @fonts css construction...
	protected $pageeditcss='';//initializes all editcss
	protected $editgencss='';//initializes all editgencss
	protected $editoverridecss='';//initializes all edit override css
	protected $css='';//initializes all page 
	protected $sitecss='';
	protected $imagecss='';//initialize build image css
	protected $navcss='';//initializes all page css
	protected $initcss='';//initializes all page css
	protected $highslidecss='';//initializes all page css
	protected $mediacss='';
	protected $fontcss='';
	protected $pagecss='';
	protected $advancedmediacss='';
	protected $success='';
	protected $message='';
	protected $field_data=Cfg::Page_fields;
	protected $append_script='';
	protected $gallery_global=false;
	protected $users_record=false;
	protected $echo_eob='';//concate echo for end of body rendering... 
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
	protected $show_more=0;
	protected  $col_child_table='';
	#column level colors 
	protected  $redAlert='c82c1d';  //message error color       
     protected  $brown='816227';
	protected  $maroon='800000';
	protected  $cherry='C91B45';
	protected  $yellow='FFFF00';
	protected  $aqua='00ffff';
	protected  $magenta='ff00ff';
	protected  $brightgreen='00ff00';
	protected  $orange='ff6600';
	protected  $pos='64C91D';// success color  and column level 1 color 
	protected  $info='e5d805'; //information hover and instructional message
	protected  $ekblue='0075a0';
	protected  $blue='1DBAC9';
	protected  $navy='2B1DC9';
     protected  $white='ffffff';
     protected  $black='000000';
     protected  $green='266a2e';
	protected  $purple='800080';
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
	protected $lightmaroon='c6a5a5';
	protected $lightermaroon='dccbcb';
	protected $lightestmaroon='ede5e5';
	#end column level colors colors
	protected $block_style=false;//if padding etc. too excessive  blocks rendering
	protected $page_pic_quality=95;
	protected $next_image='photonav_next2.gif';
	protected $hover_image=85;#percentage in the field for vert position with 100 being bottom
	protected $editor_background='#fff';//defaults set in editor configs
	protected $editor_color='#000';//defaults set in editor configs
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
	protected $column_masonry_status_arr=array(); 
	protected $page_stylesheet_inc=array();//used to include all cloned page styles
	protected $is_clone=false;//initialize
	protected $preload='';
	protected $page_images_arr=array();//hold current page_images_dir images and quality info
	protected $page_images_expanded_arr=array();//hold current page_images_expanded_dir images and quality info
	protected $auto_slide_arr=array();//hold current auto_slide_dir images and quality info
	protected $large_images_arr=array();//hold current gallery large_image_dir images and quality info
	protected $css_view=array();
	protected $animate_arr=array();
	protected $display_edit_data='block';//set default  
     protected $flex_box_item=false;
     protected $flex_box_container=false;
	protected $column_flex_arr=array(); 
	protected $rwd_post=false;
     protected $current_font_size='';//obsolete  checkout
     protected $current_font_source='';//obsolete checkout
     protected $use_col_main_width=false;//whether main width value is active or not
     protected $hidden_array=array();//collects hidden fields not sent to browser ie. under ajax to all be expressed
     protected $overlapbutton=false; 
     protected $id_array=array();
     protected $write_to_file=array();//
     #FOLLOWING COLUMN DEPENDENT  check at #passthruarray
     protected $current_font_em_px=16;
	protected $current_font_em=16;
     protected $terminal_font_em_px=16;//font size converted to px
     protected $terminal_px_scale=false;
     protected $terminal_em_scale=false;
     protected $terminal_rem_scale=false;
	protected $is_masonry=false; 
     protected $font_scale=false;
     protected $rem_scale=false;//whether scaling affects rem units 
     protected $current_em_scale=false;//whether scaling affects em units 
     
#__con   #cons  
function __construct($edit=false,  $return=false){
     if($return)return; 
	$this->viewport_current_width=process_data::get_viewport(); 
	$this->color_arr_long=explode(',',Cfg::Light_editor_color_order);//default value
	$this->deltatime=time::instance(); $this->deltatime->delta_log('global construct delta'); 
	$this->column_width_array[0]='body'; 
	$this->edit=($edit=='edit')?true:$edit;// this is set in editpages for each web page individually....
     $this->ext=request::check_request_ext();  
	$this->page_initiate(); 
	#****** Require login for  editsites and restricted  access ie.   display_user_db.php   display/    file_gen.php 
	if ((!Sys::Bypass||(Sys::Loc&&Cfg::Force_local_login))&&(($this->edit&&!Sys::Pass_class)||Sys::Check_restricted)){//this is always on for security for editpages and other restricted utilities such as file_gen.php and display user pages see (Sys.php)
#logged_in #login
		new secure_login('ownerAdmin',false); //for access to editpages  
		}  
	$this->css_suffix=$this->passclass_ext=(Sys::Pass_class)?Cfg::Temp_ext:'';		 
	if ($this->edit && (isset($_POST['page_restore_view'])&&!empty($_POST['page_restore_view']))||(isset($_SESSION[Cfg::Owner.'db_to_restore'])&&isset($_GET['page_restore_dbopt'])))$this->db_backup_restore();
	$this->ajax_check();
     if ($this->edit){//clear last round editpage outputbuffer generation
          if (!is_dir(Cfg_loc::Root_dir.Cfg::Data_dir))mkdir(Cfg_loc::Root_dir.Cfg::Data_dir,0755,1);
          if (!is_dir(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Buffer_dir))mkdir(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Buffer_dir,0755,1);
          if (!isset($_SESSION['clean_buffer'])){
               foreach (glob(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Buffer_dir .'*.dat') as $filename) { 
                    unlink($filename);
                    }
               $_SESSION['clean_buffer']=true;
               }
          else {
               foreach (glob(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Buffer_dir.'*'.$this->pagename.'.dat') as $filename) { 
                    unlink($filename);
                    }
               }
          } 
	(Sys::Onsubmitoff)&&$this->onsubmit='';
	#*************  End Restrict Access
	
	if ($this->edit)$_SESSION[Cfg::Owner.'editmode']=1;//prevents pages from cacheing if cacheing were on also this session created when logged in or by request
	$file=Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'sibling_id_arr_'.$this->pagename.'.dat';
     if (is_file($file)){
          $this->sibling_id_arr=unserialize(file_get_contents($file));
          }
     else $this->sibling_id_arr=array();
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
	/*$indexes=explode(',',Cfg::Blog_height_opts);
	foreach($indexes as $key =>$index){
		if (!empty($index)) {
			$this->{$index.'_index'}=$key;  
			}
		}*/
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
	$indexes=explode(',',Cfg::Animation_options );
	foreach($indexes as $key =>$index){
		if (!empty($index)) {
			$this->{$index.'_index'}=$key;
			  //print NL.  $index." = $key"; 
			}
		}
	$indexes=explode(',',Cfg::Position_options );
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
	$indexes=explode(',',Cfg::Main_width_options);
	foreach($indexes as $key =>$index){
		if (!empty($index)) {
			$this->{$index.'_index'}=$key;
			 // print NL.  $index." = $key"; 
			}
		}
	$indexes=explode(',',Cfg::Box_shadow_options);
	foreach($indexes as $key =>$index){
		if (!empty($index)) {
			$this->{$index.'_index'}=$key;
			 // print NL.  $index." = $key"; 
			}
		}
          
     $indexes=explode(',',Cfg::Col_flex_options);
	foreach($indexes as $key =>$index){
		if (!empty($index)) {
			$this->{$index.'_index'}=$key;
			 // print NL.  $index." = $key"; 
			}
		}
          
     $indexes=explode(',',Cfg::Image_options);
	foreach($indexes as $key =>$index){
		if (!empty($index)) {
			$this->{$index.'_index'}=$key; 
			}
		}
          
     $indexes=explode(',',Cfg::Blog_flex_options);
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
	((!Sys::Debug&&!Sys::Norefresh&&(isset($_POST['submit'])||Sys::Bufferoutput))||isset($_GET['advanced'])||isset($_GET['advancedoff']))&&ob_start();  #ob
	if (Sys::Debug||Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__); 
	$this->set_cookie(); 
	$this->deltatime->delta_log('page initiate');  
	$this->update_db(); 
	if ($this->edit){  
	$this->edit_script();
	   }	
	else {
	   	$this->page_script();   
		}
	}//end __construct
      
#flex
function flex_items($type){// handles col and blog flex-items
     if ($this->is_clone&&!$this->clone_local_style)return;
     if(!$this->flex_box_item){
         // printer::print_info('Flex box flex-item positioning of this '.$this->blog_typed.' is <b>Not Active</b> as not enabled in parent column.'); 
          return;
          }
     $flexitems=explode(',',$this->blog_flex_box); 
     $count=count(explode(',',Cfg::Blog_flex_options));
     $mcount=4*$count;
     for ($c=0; $c<$mcount; $c++){
          if (!array_key_exists($c,$flexitems)) 
               $flexitems[$c]=''; 
          }
     $css_id=($type==='col')?$this->col_dataCss:$this->dataCss;
     $align_self_arr=array('def','sta','end','cen','bas','str');//flex-start default 
     $align_self_assoc=array('def'=>'parent column setting','sta'=>'flex-start','end'=>'flex-end','cen'=>'center','bas'=>'baseline','str'=>'stretch');
     $this->show_more('Choose flex-item options');
     $this->print_redwrap('flex items');
     printer::print_tip('Choose flex-item options here along with flex-column options in parent column to position this '.$type.' post');
     printer::print_tip(' For clear flex-box overview: <a  class="underline ekblue" href="https://css-tricks.com/snippets/css/a-guide-to-flexbox/" target="_blank"  >https://css-tricks.com/snippets/css/a-guide-to-flexbox/</a>'); 
     for ($i=0; $i<4; $i++){
          $k=$i*$count;//
          $max_flex=(is_numeric($flexitems[$this->blog_max_flex_index+$k])&&$flexitems[$this->blog_max_flex_index+$k]>0&&$flexitems[$this->blog_max_flex_index+$k]<=3000)?$flexitems[$this->blog_max_flex_index+$k]:'none';
          $min_flex=(is_numeric($flexitems[$this->blog_min_flex_index+$k])&&$flexitems[$this->blog_min_flex_index+$k]>0&&$flexitems[$this->blog_min_flex_index+$k]<=3000)?$flexitems[$this->blog_min_flex_index+$k]:'none';
          if ($i>0){
               if ($max_flex!=='none'||$min_flex!=='none'){
                    printer::print_notice('Activated Media Query Below');
                    }
               $this->show_more('Add additional @media query controlled option tweaks for flex-items');
               $this->print_redwrap('additional media wrap #'.$i);
               }
          $optional=($i<1)?'Not necessary to choose a max-width and/or min-width for this main flex-item values for this post. Tweak settings as necessary with up to 3 additional @media query controlled choices below.':'Choose additional @media max-width and/or min-width queries to tweak the main setting'; 
          printer::print_tip("<i>$optional</i>");
          $order=(is_numeric($flexitems[$this->flex_order_index+$k])&&$flexitems[$this->flex_order_index+$k]>=0&&$flexitems[$this->flex_order_index+$k]<=30)?$flexitems[$this->flex_order_index+$k]:0;
          $grow=(is_numeric($flexitems[$this->flex_grow_index+$k])&&$flexitems[$this->flex_grow_index+$k]>0&&$flexitems[$this->flex_grow_index+$k]<=100)?$flexitems[$this->flex_grow_index+$k]:0;
          ######## turn on  flex_grow_enabled
          if ($this->is_column&&!empty($grow)&&$this->flex_box_item)$this->flex_grow_enabled=true;
          $shrink=(is_numeric($flexitems[$this->flex_shrink_index+$k])&&$flexitems[$this->flex_shrink_index+$k]>0&&$flexitems[$this->flex_shrink_index+$k]<=100)?$flexitems[$this->flex_shrink_index+$k]:0;
          $align_self=(in_array($flexitems[$this->flex_align_self_index+$k],$align_self_arr))?$flexitems[$this->flex_align_self_index+$k]:'def';
          $align_self_css=($align_self==='def')?'':'align-self:'.$align_self_assoc[$align_self].';';
          $mediacss='';
          $floatstyle='';'margin-left:0 !important;margin-right:0 !important;';//margin auto blog item creates some problems with rendering
		printer::print_wrap1('flex order',$this->column_lev_color);
          printer::alert('Alter source order here:');
          $this->mod_spacing($this->data.'_blog_flex_box['.($this->flex_order_index+$k).']',$order,0,30,1,'','none');
          printer::close_print_wrap1('flex order');
          printer::print_wrap1('flex grow',$this->column_lev_color);
          printer::print_tip('Flex-Grow value determines distribution of extra space beyond initial value of width setting (whether main width or flex-basis width value set)');
          printer::alert('Choose flex-grow here:');
          $this->mod_spacing($this->data.'_blog_flex_box['.($this->flex_grow_index+$k).']',$grow,0,100,.1,'');
          printer::close_print_wrap1('flex grow');
          printer::print_wrap1('flex shrink',$this->column_lev_color);
          printer::print_tip('Flex-Shrink value is applied when the flex-column setting for flex-wrap is set for nowrap and space becomes limiting. It then determines the relative rate of shrinking of the flex items within the container.');
          printer::alert('Choose flex-shrink here.');
          $this->mod_spacing($this->data.'_blog_flex_box['.($this->flex_shrink_index+$k).']',$shrink,0,100,.1,'','none'); 
          printer::close_print_wrap1('flex shrink');
          printer::print_wrap1('flex basis',$this->column_lev_color);
          printer::print_tip('You can Set the flex basis width value directly. In this mode selecting a flex-basis width value will override the main setting  width but not max/min-width specifications.  Or Use Auto to use the main settings width value (&amp; in addition to main settings  max/min-width made) for initial width size before flex-grow and flex-shrink settings are applied.<br><br> Or use 0 for flex-grow distribution of extra space according to natural content width.');
          $basis=(empty($flexitems[$this->flex_basis_index+$k])||$flexitems[$this->flex_basis_index+$k]==='zero')?'zero':$flexitems[$this->flex_basis_index+$k];
          $checked1=($basis==='auto')?'checked="checked"':'';
          $checked2=($basis==='zero')?'checked="checked"':'';
          printer::alert('Choose flex-basis here:');
          printer::alert('<input name="'.$this->data.'_blog_flex_box['.($this->flex_basis_index+$k).']" value="auto" type="radio" '.$checked1.'>Use auto'); 
          printer::alertx('<input name="'.$this->data.'_blog_flex_box['.($this->flex_basis_index+$k).']" value="0" type="radio" '.$checked2.'>Use 0');
          printer::pclear();
          $this->{$this->data.'_blog_flex_box'}[$this->flex_basis_index+$k]=($basis==='auto'||$basis==='zero')?0:$basis;
          printer::print_tip(' Or Choose Flex Basis value (Overrides other choices)');
          $flex_width_value=$this->spacing($this->data.'_blog_flex_box',$this->flex_basis_index+$k,'return','Flex-basis value','Sets initial width value &amp; ','','','','');
          if($basis!=='auto'&&$basis!=='zero'){
               $basis=$flex_width_value;
               printer::alert('Current flex-basis: '.$flex_width_value);
               }
          $basis_css=($basis==='zero')?0:$basis;
          printer::close_print_wrap1('flex basis'); 
          printer::print_wrap1('align self',$this->column_lev_color);
          printer::alert('Change default align-self here if you need to override the parent column align-item setting for this post and all siblings.  Override individual setting for this post here');
          foreach ($align_self_arr as $asa){
               if ($align_self===$asa)
                    $checked='checked="checked"';
               else $checked=''; 
               echo '<p><input type="radio" name="'.$this->data.'_blog_flex_box['.($this->flex_align_self_index+$k).']" value="'.$asa.'" '.$checked.'> '.$align_self_assoc[$asa].'</p>';
          
               }//end foreach
          printer::close_print_wrap1('align self');
          printer::print_wrap1('max flex',$this->column_lev_color);
          printer::alert('Add a flex-item @media max-width');
          $this->mod_spacing($this->data.'_blog_flex_box['.($this->blog_max_flex_index+$k).']',$max_flex,100,3000,1,'px','none');
          printer::close_print_wrap1('max flex');
          printer::print_wrap1('min flex',$this->column_lev_color);
          printer::alert('Add a flex-item @media min-width');
          $this->mod_spacing($this->data.'_blog_flex_box['.($this->blog_min_flex_index+$k).']',$min_flex,100,3000,1,'px','none');
          printer::close_print_wrap1('min flex');
          if ($max_flex==='none'&&$min_flex==='none'){
               if ($i>0)echo 'Choose @media max or min width to initiate viewport responsive flex settings';
                
               else
                    $this->css.='
.'.$css_id.'{flex:'.$grow.' '.$shrink.' '.$basis_css.';
order:'.$order.';
'.$align_self_css.$floatstyle.'}
';
			} 
		elseif ($max_flex!=='none'&&$min_flex!=='none') {
			 $this->mediacss.='
@media screen and (max-width:'.$max_flex.'px) and (min-width:'.$min_flex.'px){  	
'.$css_id.'{flex:'.$grow.' '.$shrink.' '.$basis_css.';
order:'.$order.';
'.$align_self_css.$floatstyle.'}
     }';
			}
		elseif ($max_flex!=='none'){
			 $this->mediacss.='
@media screen and (max-width: '.$max_flex.'px){  	
.'.$css_id.'{flex:'.$grow.' '.$shrink.' '.$basis_css.';
order:'.$order.';
'.$align_self_css.$floatstyle.'}
     }';
			}
		else {
			 $this->mediacss.='
@media screen and (min-width: '.$min_flex.'px){  	
.'.$css_id.'{flex:'.$grow.' '.$shrink.' '.$basis_css.';
order:'.$order.';
'.$align_self_css.$floatstyle.'}
     }';
			} 
          if ($i>0){
               
               $this->submit_button( );
               printer::close_print_wrap('additional media wrap #'.$i);
               $this->show_close('Add any additional @media query controlled option tweak(s) for flex-items'); 
               } 
          }//end for 
     $this->submit_button();
     printer::close_print_wrap('flex items');
     $this->show_close('Choose flex-item options'); 
     }
     
function flex_container(){ 
     if ($this->is_clone&&!$this->clone_local_style)return;
     $display1_arr=array('fle','inf','off'); 
     $display1_assoc=array('fle'=>'flex','inf'=>'inline-flex','off'=>'off');
     $display2_arr=array('inb','blo','off'); 
     $display2_assoc=array('inb'=>'inline-block','blo'=>'block','off'=>'off'); 
     $flex_direction_arr=array('row','rrv','col','crv');
     $flex_direction_assoc=array('row'=>'row','rrv'=>'row-reverse','col'=>'column','crv'=>'column-reverse');//row
     $flex_wrap_arr=array('now','wra','wrv');//nowrap
     $flex_wrap_assoc=array('now'=>'nowrap','wra'=>'wrap','wrv'=>'wrap-reverse');//nowrap 
     $justify_content_arr=array('sta','end','cen','spb','spa','spe');//flex-start
     $justify_content_assoc=array('sta'=>'flex-start','end'=>'flex-end','cen'=>'center','spb'=>'space-between','spa'=>'space-around','spe'=>'space-evenly');//flex-start 
     $align_content_arr=array('sta','end','cen','spb','spa','str');//flex-start
     $align_content_assoc=array('sta'=>'flex-start','end'=>'flex-end','cen'=>'center','spb'=>'space-between','spa'=>'space-around','str'=>'stretch');//flex-start
     $align_items_arr=array('sta','end','cen','bas','str');//flex-start default 
     $align_items_assoc=array('sta'=>'flex-start','end'=>'flex-end','cen'=>'center','bas'=>'baseline','str'=>'stretch');
      ################################
      printer::pclear(5);
     if($this->column_level>0&&$this->column_use_grid_array[$this->column_level-1]==='use_grid'){
          printer::print_tip('Note: RWD Grid Positioning is enabled in parent column and overrides Flex Box Mode'); 
          return;
          }
     $flexcontainer=explode(',',$this->col_flex_box);
     $count=count(explode(',',Cfg::Col_flex_options));
     $mcount=4*$count;
     for ($c=0; $c<$mcount; $c++){
          if (!array_key_exists($c,$flexcontainer)) 
               $flexcontainer[$c]=''; 
          }
     $css_id=$this->col_dataCss;
     $this->show_more('Choose flex-box flex-container options');
     $this->print_redwrap('flex container');
     printer::print_tip('Choose flex-container options here together with flex-item options in the child posts to position the child posts (including nested column if present) within this column.');
     printer::print_tip(' For clear flex-box overview: <a  class="underline ekblue" href="https://css-tricks.com/snippets/css/a-guide-to-flexbox/" target="_blank"  >https://css-tricks.com/snippets/css/a-guide-to-flexbox/</a>'); 
     for ($i=0; $i<4; $i++){
          $k=$i*$count;//
          $max_flex=(is_numeric($flexcontainer[$this->col_max_flex_index+$k])&&$flexcontainer[$this->col_max_flex_index+$k]>0&&$flexcontainer[$this->col_max_flex_index+$k]<=3000)?$flexcontainer[$this->col_max_flex_index+$k]:'none';
          $min_flex=(is_numeric($flexcontainer[$this->col_min_flex_index+$k])&&$flexcontainer[$this->col_min_flex_index+$k]>0&&$flexcontainer[$this->col_min_flex_index+$k]<=3000)?$flexcontainer[$this->col_min_flex_index+$k]:'none';
          if ($i>0){
                if ($max_flex!=='none'||$min_flex!=='none'){
                    printer::print_notice('Activated Media Query Below');
                    }
               $this->show_more('Add additional @media query controlled option tweaks for flex-container');
          
               $this->print_redwrap('additional media wrap #'.$i);
               }
          $dis_suffix=($i<1)?'1':'2';//choose display array
          $display=(in_array($flexcontainer[$this->flex_display_index+$k],${'display'.$dis_suffix.'_arr'}))?$flexcontainer[$this->flex_display_index+$k]:'off';
          $display_css=($display==='off')?'':'display:'.${'display'.$dis_suffix.'_assoc'}[$display].';';      $direction=(in_array($flexcontainer[$this->flex_direction_index+$k],$flex_direction_arr))?$flexcontainer[$this->flex_direction_index+$k]:'row';
          $direction_css='flex-direction:'.$flex_direction_assoc[$direction].';';
          $wrap=(in_array($flexcontainer[$this->flex_wrap_index+$k],$flex_wrap_arr))?$flexcontainer[$this->flex_wrap_index+$k]:'now';
          $wrap_css='flex-wrap:'.$flex_wrap_assoc[$wrap].';';
          $justify_content=(in_array($flexcontainer[$this->flex_justify_content_index+$k],$justify_content_arr))?$flexcontainer[$this->flex_justify_content_index+$k]:'sta';
          $justify_content_css='justify-content:'.$justify_content_assoc[$justify_content].';';
          $align_items=(in_array($flexcontainer[$this->flex_align_items_index+$k],$align_items_arr))?$flexcontainer[$this->flex_align_items_index+$k]:'sta';
          $align_items_css='align-items:'.$align_items_assoc[$align_items].';';
          $align_content=(in_array($flexcontainer[$this->flex_align_content_index+$k],$align_content_arr))?$flexcontainer[$this->flex_align_content_index+$k]:'sta';
          $align_content_css='align-content:'.$align_content_assoc[$align_content].';';
          $mediacss='';
          if ($i<1)
               printer::print_info('Optionally Control The flex-container settings with max-width and/or min-width @media query. Choose additional flex-container settings/tweaks @media queries below.'); 
          
          if ($display==='off'&&$i<1)
               printer::print_info('Turn main flex display option to flex or flex-inline to turn flex mode on for position child posts within this column.');
		else if ($max_flex==='none'&&$min_flex==='none'){
               if ($i>0)printer::alert('Choose @media max or min width to initiate additional viewport responsive flex settings'); 
               else
                    $this->css.='
.'.$css_id.'{'.$display_css.$direction_css.$wrap_css.$justify_content_css.$align_items_css.$align_content_css.'}
';
			} 
		elseif ($max_flex!=='none'&&$min_flex!=='none') {
			 $this->mediacss.='
@media screen and (max-width:'.$max_flex.'px) and (min-width:'.$min_flex.'px){  	
     .'.$css_id.'{'.$display_css.$direction_css.$wrap_css.$justify_content_css.$align_items_css.$align_content_css.'}
}';
			}
		elseif ($max_flex!=='none'){
			 $this->mediacss.='
@media screen and (max-width: '.$max_flex.'px){  
     .'.$css_id.'{'.$display_css.$direction_css.$wrap_css.$justify_content_css.$align_items_css.$align_content_css.'}
}';
               }
		else {
			 $this->mediacss.='
@media screen and (min-width: '.$min_flex.'px){
.'.$css_id.'{'.$display_css.$direction_css.$wrap_css.$justify_content_css.$align_items_css.$align_content_css.'}
}';
			}
         ################
               printer::print_wrap1('display mode',$this->column_lev_color);
          $msg=($i<1)?'Choose to turn on Flex mode by choosing main value display: flex or flex-inline.  Both modes will render child posts in flex arrangement whereas column will have block or inline-block properties depending on which you choose. You can override flex enabled settings for child posts below for the  @media min max width range additional flex settings by choosing display:block or inline below.':'You can override flex settings for child posts by chosing display display:block or display:inline for the @media setting you choose here';
          printer::alert($msg);
          foreach (${'display'.$dis_suffix.'_arr'} as $asa){
               if ($display===$asa)
                    $checked='checked="checked"';
               else $checked=''; 
               echo '<p><input type="radio" name="'.$this->col_name.'_col_flex_box['.($this->flex_display_index+$k).']" value="'.$asa.'" '.$checked.'> '.${'display'.$dis_suffix.'_assoc'}[$asa].'</p>';
          
               }//end foreach
          printer::close_print_wrap1('display mode');
          ###################
          printer::print_wrap1('flex wrap',$this->column_lev_color);
          printer::alert('Change default flex-wrap. Nowrap for one line, wrap and wrap-reverse will use multiple lines as needed with wrap-reverse wrapping onto multiple lines from bottom to top.');
          foreach ($flex_wrap_arr as $asa){
               if ($wrap===$asa)
                    $checked='checked="checked"';
               else $checked=''; 
               echo '<p><input type="radio" name="'.$this->col_name.'_col_flex_box['.($this->flex_wrap_index+$k).']" value="'.$asa.'" '.$checked.'> '.$flex_wrap_assoc[$asa].'</p>';
          
               }//end foreach
               printer::close_print_wrap1('flex wrap');
               #############################
                printer::print_wrap1('flex direction',$this->column_lev_color);
          printer::alert('Change default flex-direction of child posts to arrange in row or column in natural or reverse order.');
          foreach ($flex_direction_arr as $asa){
               if ($direction===$asa)
                    $checked='checked="checked"';
               else $checked=''; 
               echo '<p><input type="radio" name="'.$this->col_name.'_col_flex_box['.($this->flex_direction_index+$k).']" value="'.$asa.'" '.$checked.'> '.$flex_direction_assoc[$asa].'</p>';
          
               }//end foreach
          printer::close_print_wrap1('flex direction');
               #############################
          printer::print_wrap1('justify content',$this->column_lev_color);
          printer::alert('justify-content: Justifies content of child posts along main-axis when extra horizontal space is available. This default value may be overriden in each child post');
          foreach ($justify_content_arr as $asa){
               if ($justify_content===$asa)
                    $checked='checked="checked"';
               else $checked=''; 
               echo '<p><input type="radio" name="'.$this->col_name.'_col_flex_box['.($this->flex_justify_content_index+$k).']" value="'.$asa.'" '.$checked.'> '.$justify_content_assoc[$asa].'</p>';
          
               }//end foreach
               printer::close_print_wrap1('justify content');
               ################################
          
          printer::print_wrap1('align items',$this->column_lev_color);
          printer::alert('align-items: Choose default vertical arrangement for aligning child posts within each row.  Will align the content of posts of a particular row vertically. This setting may be overriden for an individual child post(s) as needed using align-self option.');
          foreach ($align_items_arr as $asa){
               if ($align_items===$asa)
                    $checked='checked="checked"';
               else $checked=''; 
               echo '<p><input type="radio" name="'.$this->col_name.'_col_flex_box['.($this->flex_align_items_index+$k).']" value="'.$asa.'" '.$checked.'> '.$align_items_assoc[$asa].'</p>';
          
               }//end foreach
               printer::close_print_wrap1('align items');
               ###########################
                printer::print_wrap1('align content',$this->column_lev_color);
          printer::alert('align-content:   Arranges entire spacing between rows along cross-axis when extra column height available.');
          foreach ($align_content_arr as $asa){
               if ($align_content===$asa)
                    $checked='checked="checked"';
               else $checked=''; 
               echo '<p><input type="radio" name="'.$this->col_name.'_col_flex_box['.($this->flex_align_content_index+$k).']" value="'.$asa.'" '.$checked.'> '.$align_content_assoc[$asa].'</p>';
          
               }//end foreach
          printer::close_print_wrap1('align content');
          printer::print_wrap1('max flex',$this->column_lev_color);
          printer::alert('Add a flex-containers @media max-width');
          $this->mod_spacing($this->col_name.'_col_flex_box['.($this->col_max_flex_index+$k).']',$max_flex,100,3000,1,'px','none');
          printer::close_print_wrap1('max flex');
          printer::print_wrap1('min flex',$this->column_lev_color);
          printer::alert('Add a flex-containers @media min-width');
          $this->mod_spacing($this->col_table.'_col_flex_box['.($this->col_min_flex_index+$k).']',$min_flex,100,3000,1,'px','none');
          printer::close_print_wrap1('min flex');    
               ####################
          if ($i>0){
               $this->submit_button();
               printer::close_print_wrap('additional media wrap #'.$i);
               $this->show_close('Add any additional @media query controlled option tweak(s) for flex-container');
               }
          }//end for
     $this->submit_button();
     printer::close_print_wrap('flex container');
     $this->show_close('Choose flex-containers options');
     }#end flex-container
     
function overlapbutton(){
     $style=' {position: \'relative !important\'}';  
	printer::alertx('<div class="floatleft editbackground underline editfont underline rad5 tiny cursor button'.$this->column_lev_color.'mini highlight" title="this may happen when a post in editmode with background image opacity set overlaps show_more style fields with another background image opacity post above it." onclick="this.parentNode.style.cssText +=\';position:static !important;\'">EditMode: Turn Off opacity background Image if overlapping Post above from Proper Editing</div>');
     printer::pclear();
     } 

function col_info_prime(){
     $this->show_more('info','off','info smaller');
	$this->print_wrap('primal info');
	printer::alert('Column Css &amp; ID/CLASS: '.$this->col_dataCss);
     printer::alert('Name: '.$this->col_name);
     $info=$this->check_spacing($this->col_options[$this->col_max_width_opt_index],'max-width');
     $info.=$this->check_spacing($this->col_options[$this->col_width_opt_index],'width');
     $info.=$this->check_spacing($this->col_options[$this->col_min_width_opt_index],'min-width');
     $altunits=(empty($info))?'&#x2715;':'&#x2713;';
     $this->scale_width_enabled=(empty($info))?false:true; 
     $maxwidthSetting='&#x2715;';
	$parentGrid='NA'; 
	$float='NA'; 
	$altGridFull='NA';
	$altGridPercent='NA'; 
	$masonryParent='NA';
     $childrenEnableMasonry='&#x2715;';//no masonry eanable in prime column due to outer div requirement  ie js issue
	$childrenEnableGrid='&#x2715;';
     $childrenEnableFlex='&#x2715;';
	if ($this->column_use_grid_array[$this->column_level]==='use_grid'){	
		$childrenEnableGrid='&#x2713;';
          printer::print_info('RWD grid on direct Child posts is active');
	
		}
	elseif ($this->column_use_flex_array[$this->column_level]){	
          $childrenEnableFlex='&#x2713;';
          printer::print_info('Flex Box on <b>direct child Items</b> Active.'); 
		}
	 
	if ($this->use_col_main_width) 
          printer::print_info('Primary Main Width Mode  <b>is Active</b> using max-width.');
     $emscale=($this->terminal_em_scale)?'on':'off';
     printer::print_info("1 em unit currently equivalent to {$this->terminal_font_em_px}px with scaling $emscale");
     $remscale=($this->rem_scale)?'on':'off';
     printer::print_info("1 rem unit equivalent to $this->rem_root px with scaling $remscale");  
     $spacing_arr=array('padding_right','padding_left','margin_right','margin_left');
     $col_pad_info='';
     foreach ($spacing_arr as $space){
          if (!empty($this->{$space.'_info'})){
               $type=str_replace('_','-',$space);
               $col_pad_info.=$type.' set: '.$this->{$space.'_info'}.'<br>';
               } 
          }
     if (!empty($col_pad_info)){
          printer::print_info('right and left padding and margin info:<br>'.$col_pad_info);
          }
     else printer::print_info('No right or left padding or margin set');
         
	
     (!empty($this->left_border_info))&&printer::print_info('Left Border info: '.$this->left_border_info);
     (!empty($this->right_border_info))&&printer::print_info('Right Border info: '.$this->right_border_info);
     printer::print_tip('In primary columns you can enable a RWD grid or flex-box (using display flex/flex-inline, or masonry RWD to position posts that are within it, but the column itself is positioned centerally in the body so RWD grid percentage choices and flex box item choices, and float options are not are not usuable',.8); 
	echo '<table class="p10 editcolor editbackground editfont" style="max-width:700px">
	<tr><th style="width:15%">Status</th><th style="width:85%">Setting</th></tr>
	<tr><td class="tiny">&nbsp; '.$parentGrid.' in primary</td><td>Active RWD Grid Unit System to position this column </td></tr>
	<tr><td> &nbsp; '.$childrenEnableGrid.'</td><td>  RWD Grid Unit System Enabled for positioning child posts this column</td></tr>
	<tr><td class="tiny">&nbsp; NA in primary</td><td>Active Flex Box System to position this column</td></tr>
	<tr><td> &nbsp; '.$childrenEnableFlex.'</td><td>  Flex Mode Enabled for positioning child posts within this column</td></tr>
	<tr><td> &nbsp; '.$maxwidthSetting.'</td><td>Active Main Width Setting</td></tr>
	<tr><td> &nbsp; '.$altunits.'</td><td>Active alternative Width Unit Setting (ie. em rem ww )</td></tr>
	<tr><td class="tiny">&nbsp; '.$float.' in primary</td><td>Active Float Setting to position this column</td></tr>  
	<tr><td class="tiny">&nbsp; '.$altGridFull.' in primary</td><td>Main Width Full Percentage Compress</td></tr>  
	<tr><td class="tiny">&nbsp; '.$altGridPercent.' in primary</td><td>Main Width Percentage Compress to Min Width</td></tr>
	<tr><td class="tiny">&nbsp; '.$masonryParent.' in primary</td><td >Enabled Masonry Assist System in Primary Column</td></tr> 
	<tr><td class="tiny">&nbsp; NA in primary</td><td>Masonry Assist availble for child posts of nested columns only</td></tr></table>';
	
	$this->close_print_wrap('primal info',false);	
	$this->show_close('info','','info fs1info');
     }//end col info prime

function col_info(){  
	
     $this->show_more('info','','info smaller');
	$this->print_wrap('non primal col info');
	printer::alert('Post Parent Blog id'.$this->blog_id);
	printer::alert('Column Css &amp; ID/Class: '.$this->col_dataCss);
     printer::alert('Name: '.$this->col_name);
     $info=$this->check_spacing($this->col_options[$this->col_max_width_opt_index],'max-width');
          $info.=$this->check_spacing($this->col_options[$this->col_width_opt_index],'width');
     $info.=$this->check_spacing($this->col_options[$this->col_min_width_opt_index],'min-width');
     $altunits=(empty($info))?false:true;
     $maxwidthSetting='&#x2715;';
     $parentGrid='&#x2715;';//'&#10004';
     $flexBoxParent='&#x2715;';
     $masonryParent='&#x2715;';
     $float='&#x2715;'; 
     $altGridFull='&#x2715;';
     $scaleWidth='&#x2715;';
     $altGridPercent='&#x2715;';
     $childrenEnableGrid='&#x2715;';
	$childrenEnableMasonry='&#x2715;';
	$childrenEnableFlex='&#x2715;';
     $masonryParent=($this->column_masonry_status_arr[$this->column_level-1])?'&#x2713;':'&#x2715;';
     $float=($this->blog_float==='center_row')?'&#x2715;':'<span class="tiny">'.str_replace('_','',ucwords($this->blog_float ,'_')).'</span>'; 
	if ($this->column_use_grid_array[$this->column_level-1]==='use_grid'){
		$parentGrid='&#x2713;';
          printer::print_info('RWD grid Active. Overrides other width Modes');
		}  
	elseif ($this->column_use_flex_array[$this->column_level-1]){  
		$flexBoxParent='&#x2713;';
		$float='<span class="tiny">Flex Sharing</span>';
          printer::print_info('Flex Box Item Active. Compatible with Main Width Mode or  Alt width Units. Overrides Masonry assist'); 
		}
         
     if ($this->column_use_grid_array[$this->column_level-1]!=='use_grid'){
          if(!$this->use_col_main_width){
               printer::print_info($this->col_width_info); 
               $scaleWidth=($this->scale_width_enabled)?'&#x2713;':'&#x2715;';
               }    
          else{ 
               $maxwidthSetting=($this->blog_width_mode[$this->blog_width_mode_index]!=='compress_full_width'&&$this->blog_width_mode[$this->blog_width_mode_index]!=='compress_to_percentage')?'&#x2713;':'&#x2715;';  
               
               $altGridFull=($this->blog_width_mode[$this->blog_width_mode_index]==='compress_full_width')?'&#x2713;':'&#x2715;';
               $altGridPercent=($this->blog_width_mode[$this->blog_width_mode_index]==='compress_to_percentage')?'&#x2713;':'&#x2715;'; 
               $scale=($maxwidthSetting==='&#x2713;')?'using max-width':(($maxwidthSetting==='compress_full_width')?'using  % scale':'using % scale to a min-width');
                printer::print_info('Main Width Set '.$scale);
               }
          }
	if ($this->column_use_grid_array[$this->column_level]==='use_grid'){	
		$childrenEnableGrid='&#x2713;';
		}
     elseif ($this->column_use_flex_array[$this->column_level]){
		$childrenEnableFlex='&#x2713;';
          }
	if ($this->is_masonry){	
		$childrenEnableMasonry='&#x2713;';
		}
	$emscale=($this->terminal_em_scale)?'on':'off';
     printer::print_info("1 em unit currently equivalent to {$this->terminal_font_em_px}px with scaling $emscale");
     $remscale=($this->rem_scale)?'on':'off';
     printer::print_info("1 rem unit equivalent to $this->rem_root px with scaling $remscale"); 
     $spacing_arr=array('padding_right','padding_left','margin_right','margin_left');
     $col_pad_info='';
	foreach ($spacing_arr as $space){
          if (!empty($this->{$space.'_info'})){
               $type=str_replace('_','-',$space);
               $col_pad_info.=$type.' set: '.$this->{$space.'_info'}.'<br>';
               } 
          }
     if (!empty($col_pad_info)){
          printer::print_info('right and left padding and margin info:<br>'.$col_pad_info);
          }
     else printer::print_info('No right or left padding or margin set'); 
     (!empty($this->left_border_info))&&printer::print_info('Left Border info: '.$this->left_border_info);
     (!empty($this->right_border_info))&&printer::print_info('Right Border info: '.$this->right_border_info);
	 printer::print_tip('Note: when you choose to enable the RWD Grid option what it means is that rwd grid setting percentage choices will now be enabled in its children posts and these settings in the children posts will then determine how much relative percentage widths they occupy in this column. If enabled it will have no effect on the positioning of the column itself. To position a column along with sibling post enable RWD Grid settings in its parent first. <br><br>Flex box mode is similarly activated in the parent column to position child posts and works with alternative width mode if chosen. <br>If these two are not active Masonry can also be be activated in the parent column and works with either main width mode or alternative units mode.',.7);
     echo '<table class="p10 editcolor editbackground editfont" style="max-width:700px;">
	<tr><th style="width:15%">Status</th><th style="width:85%;">Setting</th></tr>
	<tr><td>&nbsp; '.$parentGrid.'</td><td>Activation status of RWD Grid Unit System to position this column (overrides other settings and Enabled in Parent Column compatible with masonry)</td></tr>
	<tr><td >&nbsp; '.$flexBoxParent.'</td><td>Activation status of flex-box system to position this column (compatible with main width and Alternative width settings. )</td></tr>
	<tr><td>&nbsp; '.$float.'</td><td>Active Float Setting</td></tr>
	<tr><td> &nbsp; '.$maxwidthSetting.'</td><td>Main Width max-width Setting status on sizing this column itself</td></tr> 
	<tr><td>&nbsp; '.$altGridFull.'</td><td>Main Width Full Percentage Compress status</td></tr>  
	<tr><td>&nbsp; '.$altGridPercent.'</td><td>Main Width Percentage Compress to Min Width status</td></tr>
     <tr><td>&nbsp; '.$scaleWidth.'</td><td>Alt width alt units status (ie. em rem %)</td></tr>
	<tr><td>&nbsp; '.$masonryParent.'</td><td >Enabled Masonry Assist System Acting on this column (set in parent column)<br>Automatic Float Center on column</td></tr>
	<tr><td> &nbsp; '.$childrenEnableGrid.'</td><td>  RWD Grid Unit System Enabled for child posts within in this column</td></tr>
	<tr><td> &nbsp; '.$childrenEnableFlex.'</td><td>  Flex Box System Enabled for child posts within this column</td></tr>
	<tr><td>&nbsp; '.$childrenEnableMasonry.'</td><td>Enable Masonry Assist System for child posts within this column<br>Automatic Float Center on Posts Within</td></tr></table>'; 
	$this->close_print_wrap('non primal col info',false);
	$this->show_close('info','','info fs1info');
     }//end col info..

 
#coldata 
function col_data($prime=false){
     $this->prime=$prime;
     $tablename=($this->is_clone&&$this->clone_local_style)?'clone_'.$this->col_table:$this->col_table;
     $this->col_name=$tablename;  //col name for form name fields parent blog data names
	if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	self::$xyz++;
	$this->col_width=(empty($this->col_width)||!is_numeric($this->col_width))?0:$this->col_width;
	if (isset($_POST[$this->col_name.'_express_pub']))$this->publish($this->col_id);
	if ($prime){//set primary defaults 
          $this->flex_enabled_arr=array();//once flex is enabled second round of max-width calculations are not enabled..
          $this->flex_enabled_twice=false;
          $this->grid_width_available=array();
		$this->bp_total_arr=array();
		$this->column_net_width_percent=array();
		$this->current_net_width_percent=100;
		$this->column_use_grid_array=array();
		$this->column_use_flex_array=array();
		$this->column_bp_width_arr=array();
		$this->grid_width_available=array();
          $this->flex_grow_enabled=false;//flex grow enabled in 
        //flex grow enabled inconserve image space mode turns on full cache for images to account for flex grow..
          $this->max_width_limit=$this->column_total_width[0];
		if($this->edit){
               $this->rem_width_percent=100;
               } 
		$this->column_id_array=array();
		}
     
     $this->overlapbutton=false;//works for editmode to change stacking order of columns with opacity background images when a post needs to overlap it when  show_more is clicked.. 
	$this->{$tablename.'_col_options'}=$this->col_options;//for passing name array directly to style functions for exploding  multi array values '@@'
	$this->background_video('col_style');	 
	//used in styling suchas advanced styles
	$col_id=$this->col_id;
	$this->col_order=self::$col_count++;     
	#&&&&&&&&&&&&&&&& END CLONE STYLING OPTION  &&&&&&&&&&&&&7*/
	$blog_id=($this->column_level==0)?0:$this->blog_id;
	$this->blog_id_arr[$this->column_level]=$blog_id;
	$this->column_id_array[$this->column_level]=$col_id; 
     $pass=$this->column_use_grid_array[$this->column_level]=$this->col_options[$this->col_use_grid_index];  
     $this->column_use_flex_array[$this->column_level]=($pass!=='use_grid'&&(substr($this->col_flex_box,0,3)==='fle'||substr($this->col_flex_box,0,3)==='inf'))?true:false;
     $this->is_masonry=($this->col_options[$this->col_enable_masonry_index]==='masonry')?true:false;
     //!$this->column_use_flex_array[$this->column_level]&&$pass!=='use_grid'&&
	$this->column_masonry_status_arr[$this->column_level]=$this->is_masonry;
	$this->column_level_base[$this->column_level]=$this->col_table_base;
	$this->current_overall_floated_total[$this->column_level]=0;//initiate 
	$styles=explode(',',$this->col_style);
     for ($i=0; $i<count(explode(',',Cfg::Style_functions));$i++){
          (!array_key_exists($i,$styles))&&$styles[$i]='';
          }
	$this->current_background_color=$this->column_background_color_arr[$this->column_level]=(preg_match(Cfg::Preg_color,explode('@@',$styles[$this->background_index])[0]))?explode('@@',$styles[$this->background_index])[0]:$this->current_background_color;//begins with page body setting if any 
	$this->current_color=$this->column_color_arr[$this->column_level]=(preg_match(Cfg::Preg_color,$styles[$this->font_color_index]))?$styles[$this->font_color_index]:$this->current_color; //begins with page body setting if any
	$this->current_font_px=$this->column_font_px_arr[$this->column_level]=(!empty($styles[$this->font_size_index])&&$styles[$this->font_size_index]>=.3&&$styles[$this->font_size_index]<=4.5)?$styles[$this->font_size_index]*16:((array_key_exists($this->column_level-1,$this->column_font_px_arr))?$this->column_font_px_arr[$this->column_level-1]:16);//font px may need updating..
	$this->column_total_width_percent[$this->column_level]=($this->column_level>0)?($this->column_total_width_percent[$this->column_level-1]*$this->col_width/100):100; 
	$this->column_total_width[$this->column_level]=$this->current_total_width;//set in total_float  max float only
	$this->column_net_width[$this->column_level]=$this->current_net_width;
	$this->column_net_width_percent[$this->column_level]=($this->column_level>0)?$this->current_net_width_percent:100;
	$this->column_total_net_width_percent[$this->column_level]=($this->column_level>0)?$this->column_total_net_width_percent[$this->column_level-1]*$this->current_net_width_percent/100:100;
	//set in total float  refers to max width
	$this->column_order_array[$this->column_level]=$this->col_order;
	//$this->column_num_array[$this->column_level]=$this->col_num;_
	$this->column_id_array[$this->column_level]=$this->col_id;
	$this->blog_order_array[$this->column_level]=$this->blog_order_mod; 
	 printer::pclear();	if(Sys::Custom)return;
     if (!$this->edit){
          return;
          }  
	$fmsg='';
	#clone status for columns is held in col_clone where since primary columns cannot be cloned and uncloned   unclone status is held in blog_unstatus
	$clone_msg=($this->is_clone)?'<span class="red">Cloned </span>':(($this->blog_unstatus==='unclone')?'<span class="orange">Mirror release Column</span><br>':''); 
	$title=(!$this->is_clone)?'title="The Unique Column Id: C'.$this->col_id.' would be Used to Copy/Mirror/Move This Entire Column"':'title="This entire column is cloned"';
	$info=$this->check_spacing($this->col_options[$this->col_max_width_opt_index],'max-width');
     $info.=$this->check_spacing($this->col_options[$this->col_width_opt_index],'width');
     $info.=$this->check_spacing($this->col_options[$this->col_min_width_opt_index],'min-width');
     $this->col_info=$info;// used in col_options and also gives status of $this->scale_width_enabled
    if ($this->column_level > 0){
		if ($this->blog_unstatus==='unclone'){
               $this->show_more('Mirror Release Info','','info underline italic small editbackground editfont');
               if ($this->orig_val['blog_type'] ==='nested_column')
                    printer::print_info('The Original Column post which was indirectly cloned then unmirrored here is from page_ref: '.$this->orig_val['blog_table_base'].'  and is Col Id:'.$this->orig_val['blog_data1'].'. If doing a template tranfer include this column in your template and you will automatically include this content from this current column here!');
               else printer::print_info('The Original '.$this->orig_val['blog_type'].' Post which was indirectly cloned then unmirrored here  is from page_ref: '.$this->orig_val['blog_table_base'].'  and is Post Id:'.$this->orig_val['blog_id'].'. If doing a template tranfer include this Post in your new template and you will automatically include this content from this current column here!');
               $this->show_close('From Info');
               }//$this->blog_unstatus==='unclone'
          printer::print_wrap('column info', $this->column_lev_color.' fs1'.$this->column_lev_color.' floatleft editbackground editfont left'); 
          printer::alertx('<p '.$title.'>'.$clone_msg.'Col #'.$this->col_order.'<br><span class="info">'.$clone_msg.'Column Id: C'.$this->col_id.'</span><br><span class="highlight smaller">From: <br>Column#'.$this->column_order_array[$this->column_level-1].' Post#'.$this->blog_order_array[$this->column_level].'</span>'); 
          $this->col_info();
          printer::pclear();
          printer::close_print_wrap('column info',false);
		}//$this->column_level > 0
	else  {// is prime
		$clone=($this->is_clone)?'<span class="red">Cloned </span>':'';
		$title=(!$this->is_clone)?'title="The Unique Column Id: C'.$this->col_id.' would be Used to Copy/Mirror/Move This Entire Column"':'title="This entire column is cloned"';
          printer::print_wrap('primal',$this->column_lev_color.' fs1'.$this->column_lev_color.' floatleft');
		printer::alertx('<p '.$title.'>'.$clone.'Column#'.$this->col_order.'<br><span class="highlight ">Column Id: C'.$this->col_id.'</span><br><span class="info smaller">From: <br>The Body'.'</span> </p>');
          $this->col_info_prime();  
          printer::pclear();
          printer::close_print_wrap('primal',false);
          }	 
	printer::printx('<span id="col_'.$col_id.'"></span>');
     //Note is_clone can be directly cloned column or nested_column within directly cloned column
     if ($this->is_clone){ //if cloning local style for nested columns styles & config already populated such that tablename does equal pp table base!! 
          if (!$prime&&$this->blog_status !=='clone'){
               $clone_msg='<span class="info" title="The Parent Column C'.$this->parent_col_clone.' was directly Cloned and this Column is Nested  Within"> Info </span>';
               }
          else{
               $clone_msg='<span class="info" title="This Column was directly Cloned and all its Posts and Nested Columns Within It Will Be Automatically Cloned as Well."> Directly </span>';
               $this->parent_col_clone=$col_id;
				}
		printer::alertx('<p class="editbackground editfont editcolor fs2npred small left shadowoff floatleft">Cloned Column '.$clone_msg.' and Changes to the Parent Column Id C'.$col_id.' on Page <a class="whiteshadow2" style="color:#0075a0;" target="_blank"  href="'.check_data::dir_to_file(__METHOD__,__LINE__,__FILE__,$this->col_table_base).$this->ext.'#col_'.$col_id.'"><u>'.check_data::table_to_title($this->col_table_base,__method__,__LINE__,__file__).'</u></a> Will Also Appear Here ');
		printer::pclear();
		if (in_array('c'.$col_id,$this->clone_check_arr)){
				printer::alertx('<p class="redAlertbackground white smaller">'."OOPs Column Id P$col_id has been cloned twice on this Page And multiple identical Clones on same page affect one another</p>");
				} 
		if (!$prime&&$this->blog_unstatus!=='unclone'){
			$this->unclone_options('c'.$col_id,$this->post_target_clone_column_id);
			}
		 
		#&&&&&&&&&&&&& BEGIN CHECK CLONE STYLING OPTION  &&&&&&&&&&&&&&&&&&&&&&&		
		if ($this->edit&&!Sys::Quietmode){
			if (empty($this->clone_local_style)){
				$this->show_more('Enable Local Col Settings','noback','small highlight editbackground editfont rad3 fs2npinfo click','Enable Local Column Styling and Other Column Settings Without Affecting the Parent.  This only affects the Column Styles and not those Set in the Posts or Nested Column content within!',600); 
				$msg='Enable local styling &amp; other settings of this Cloned Column without affecting those of the parent or styles and settings of  those Set in the Posts or Nested Column content within!';
				echo '<div class="fsminfo editbackground editfont  floatleft '.$this->column_lev_color.'"><!--Local clone style-->';
				printer::printx('<input type="checkbox" name="add_collocalstyle['.$col_id.']" value="1" >'.$msg);
				printer::alert_neu('Note: When Enabled the Column Styling &amp; Settings will not Update When the Parent Style Updates, instead only when you make Styling Changes here.',.8);
				echo '</div><!--Local clone style-->';
				$this->show_close('Local clone style');
				}
			else {
				$this->show_more('Disable Local Settings','noback','small highlight editbackground editfont rad3 fs2npinfo click','Disable Local Styling of this Column Clone and Return to Updating When the Parent of this Clone Updates',600); 
				$msg='Check to Disable local Settings and Column Styles for this Column Clone';
				echo '<div class="fsminfo editbackground editfont  floatleft '.$this->column_lev_color.'"><!--Local clone style-->';
				printer::printx('<input type="checkbox" name="delete_collocalstyle['.$col_id.']" value="1" >'.$msg);
				printer::alertx('<p class="small info">Note: By disabling Local Settings and Column Style the Column WILL NOW assume the Settings of the Parent Column and Update When the Parent Column Style and Other Features Updates. Style Settings for the Posts and Columns within will Remain as they Are</p>');
				echo '</div><!--Local clone style-->';
				$this->show_close('Disable Local Settings');
				}
		 	
			if (($prime && $this->col_status==='clone')||(!$prime && $this->blog_status==='clone')){ 
				$this->switch_clone_options($col_id,$prime,'column');  
				}
			}//end is edit  
		} //end if is_clone
	if($this->col_status==='clone'){ 
		$delete_msg= 'This Cloned Column and not The Parent Column Will Be Deleted if you Check this Box.';
			printer::alertx('<p class="editbackground editfont left neg fs2npred floatleft">&nbsp;&nbsp;&nbsp;<input type="checkbox" name="deletecolumn['.$this->col_child_table.']" value="delete" onchange="edit_Proc.oncheck(\'deletecolumn['.$this->col_child_table.']\',\''.$delete_msg.' ie.  THIS ClONED COLUMN AND ALL THE POSTS AND NESTED COLUMNS WITHIN IT WILL BE DELETED WHEN YOU HIT CHANGE, UNCHECK TO CANCEL\')" >REMOVE This Cloned Column &nbsp;&nbsp;</p>');
			printer::pclear();
		} 
#colsettings
	self::$colinc++;
	if (!$this->is_clone||$this->clone_local_style){
		$this->show_more('Settings for Column Id'.$this->col_id, 'buffer_column_settings_'.$this->col_id.'_'.self::$colinc,'','',500,'','float:left');
		//$this->column_tree();//column tree info not used currently
		$this->print_wrap('Settings for Column',true);
		$this->primestat=($prime)?'prime':'notprime';
		printer::pclear(); 
          $this->column_options();//cloned columns without local styling have no access to column_options as it shares cloned parent options
		}//!is clone || clone local style
     else $this->column_bp_width_track();//update column_bp_width array regardless of clone status...
	 $msg='Add Spacing Within (padding) or Outside (margin) this Column,  Change the Column Background Color or Create a Column Border or Box Shadow Here. Column Borders and Box Shadows style an edge or edge(s) of the column based on the colors, the edges chosen, and type of style you choose. Radius the corners of the column Here. In addition,  set new <span class="bold">Column Specific Text Style Defaults</span> Here. Each Post has its own styling options (a wide choice for text based posts) for further Changes as Needed. !!';
	$class=($prime)?'primary':'nested';
	$class='';
	$this->edit_styles_close($tablename,'col_style','.'.$this->col_dataCss,'background,padding_top,padding_bottom,padding_left,padding_right,margin_top,margin_bottom,margin_left,margin_right,borders,box_shadow,outlines,radius_corner,font_color,text_shadow,font_size,font_family','Edit Column Styles','noback',$msg);
	printer::pclear(2); 
	
	$msg='&#34;Group Styles&#34; provide an quick means to select consequitive posts within a Column and group style them such as with a border, background, etc.  You begin by checking the begin box on the first post and end box on the last post you wish to style!  Make any number of groups within a column and they will all have the styles you set Here!!  Options included to style borders or box shadows,  background colors, background images, etc. Padding spacing changes made here will increase spacing between posts and borders if used!.  Begin by checking the begin box on the first non column post and check the end box on the last non-column post you wish to distinguish within the same column! Span column posts between open and close tags if you wish.  Be sure to match with a close groupstyle before beginning with a new one in the same column.  Unmatched open border and close border checked options will generate an alert mesage and can mess up the webpage styling.   Check both boxes on the same post to end an group and begin another group or to wrap a single post, the system will determine which one is intended as long as your consistent with closing every opening  ';
     if(!$this->is_clone||$this->clone_local_style){
          $this->show_more('Style Group, Tags,Date, and Comment for Column','noback');
     $this->print_wrap('Style Group,Date',true);
     printer::printx('<p class="fsminfo">Group Styles are a quick way to wrap several posts with Style. YSet default Group, Comments and date styles Here and Adjust as necessary with column specific options for the same. Finally style HR tags here which will be in affect page wise.</p>');
    $this->edit_styles_close($tablename,'col_grp_bor_style','.'.$this->col_dataCss.'>.style_groupstyle','','Set &#34;Group Styles&#34;','noback',$msg);
    $msg='Set style HR tags.  HR can be placed anywhere in text and the styles you set here will be expressed. HR are theme breaks, typically bordered lines with spacing';
     $this->edit_styles_close($tablename,'col_hr','.'.$this->col_dataCss.' .post>hr','width_special,width_max_special,width_min_special,background,padding_top,padding_bottom,padding_left,padding_right,margin_top,margin_bottom,margin_left,margin_right,borders,box_shadow,outlines,radius_corner','Set Col Specific HR Tags if needed','noback',$msg);
    
     $this->edit_styles_close($tablename,'col_comment_style', '.'.$this->col_dataCss.' .posted_comment','','Style Comment Entries','noback','Comment Styles will affect all comment post feedback styles for posts made directly in this column');	
     $this->edit_styles_close($tablename,'col_date_style','.'.$this->col_dataCss.' .style_date','','Style Post Date Entries','noback','Date Styling Affects Posts within this Column (And within any nested columns unless set there) with Show Post Date Enabled');
     $this->edit_styles_close($tablename,'col_comment_date_style','.'.$this->col_dataCss.' .style_comment_date','','Style Comment Date Entries','noback','Comment Date Styling Affects Comments within this Column (And within any nested columns unless set there)');
     $this->edit_styles_close($tablename,'page_comment_view_style','.'.$this->col_dataCss.' .style_comment_view','','Style #/view/Leave Comments','noback','Style the #of Comments  and View/Leave Comments Link');
     }
     if (!$this->is_clone||$this->clone_local_style){
          $this->submit_button();
          printer::close_print_wrap('Style Group,Date');
          $this->show_close('Style Group,Date, and Comment for Column');
          printer::pclear(7);
          $this->submit_button(); 
          printer::close_print_wrap('Settings for Column');  
          $this->show_close('Settings for Column#','buffer_column_settings_'.$this->col_id."_".self::$colinc);//<!--Show More Master col Settings-->';
          printer::pclear(2);
         }  
	($this->edit&&$this->overlapbutton)&&$this->overlapbutton();#when mulitple posts with background image opacity  set the element is set to position relative and may prevent overlapping 
	}#end col_data
     #postop #blogop
     
function column_main_width(){
     $prime=$this->prime;
     $maxwid=($this->column_level==0)?Cfg::Col_maxwidth:$this->column_net_width[$this->column_level-1];
     $column_percent=($this->column_level==0)?($this->column_total_width[$this->column_level]/$this->page_width*100):$this->col_width; 
     $opt=($prime)?'Primary Max-width Main Wrapper':'Main Width Options';
     $this->show_more($opt);//Main Width Options
     printer::print_wrap('column width');  
     if ($this->column_level==0){
               //means the last primary column width gets passed on to new page start width
          $msg='Choose a Max-Width For this Top Level Column. This value will override any alterative max-width settings ie. px em % and rem. This perfoms the simple task of setting an upper limit on the overall size of Images and other Content Displays on Larger Size Screens. Default Value is '.Cfg::Page_width.' which can be changed here and by default in Page Setttings';
          $cw=(is_numeric($this->column_total_width[$this->column_level])&&$this->column_total_width[$this->column_level]>1)?$this->column_total_width[$this->column_level]:$this->page_width;
          printer::print_tip('The Primary column is sized using a max width setting whereas nested columns and other post types which may share row space with all post types and use one of several RWD responsize width options. However, alternative width units choices are also available without subsequent width tracking info.');
          printer::print_tip($msg);
          if (empty($this->col_width))printer::print_warn('<b>Primary Column width setting empty. Current Page width is referred to as default</b>');
          printer::alert('Current max-width Setting:'.$cw.'px');
          if (!$this->use_col_main_width){
               printer::alert('Main Width Units for this primary column not used. Alternative width units may be Active but are overriden by choosing a value here.'); 
               }
          echo '<div class="fsminfo editbackground editfont floatleft" ><!--width float wrap-->';//Choose Column Width:
          }//column_level==0 main column
     else{
          if (!$this->flex_enabled_twice) {
               printer::alertx('<p class="highlight editbackground editfont" title="The Parent Column Width is the Upper Limit for this Nested Column. Optionally set a narrower Column Width as required.">Max Width Available: <span class="editcolor editbackground editfont">'.intval(ceil($maxwid*10)/10).'px</span></p>'); 
               echo '<div class="highlight editbackground editfont" title="The Column width setting will include the value of margins and will take up 100% of the available column width if no limiting width value is chosen! Limit the width if required.  Both the percentage available of the parent column width and the pixel value will be shown"><!--width float wrap-->Current Column Width: <span class="editcolor editbackground editfont">: '.intval(ceil($this->column_total_width[$this->column_level]*10)/10).'px   ('.(ceil($column_percent*10)/10).'%)</span>';
               }
                    #column width  #col width  
          else{
               printer::print_warn('Previous activation of Flex Box in column tree means that max-width chosen here may no longer be accurate and percent (ie. choice 2) used instead or choose other width options');
                echo '<div class="highlight editbackground editfont" ><!--width float wrap-->Current Column Width: <span class="editcolor editbackground editfont">: '.(ceil($column_percent*10)/10).'%</span>';
               }
          if (!$this->use_col_main_width){
               printer::alert('Main Width Units for this primary column not used. Alternative width units are Active and are overridden by choosing a value here.'); 
               }
          printer::pclear(); 
          }//not prime
     $currwidth=(!empty($this->col_width)&&$this->use_col_main_width)?round($this->col_width,2):0; 
     $mode=($this->column_level>0)?'':'simple'; 
     $factor=($this->flex_enabled_twice)?1:$maxwid/100;
     $unit2=($this->flex_enabled_twice)?'':'px';
     $msgjava='Choose Width:';
     printer::print_info('Choosing a main width value overrides any choice made  from option under em, rem, %, px & px scale opt for min-width, max-width, & width choices');
     if (!$prime)
          $this->mod_spacing($this->col_name.'_col_width',$currwidth,0,100,.05,'%','',$msgjava,$factor,$unit2);
      else
          $this->mod_spacing($this->col_name.'_col_width',$currwidth,0,$maxwid,1,'px','',$msgjava); 
     echo'</div><!--width float wrap-->	';
     printer::pclear(2); 
     (!$prime)&&$this->width_mode();
     $this->submit_button();
     printer::close_print_wrap('column width');  
     $this->show_close('Main Width Options');
     }//end col_main_width     

function column_bp_width_track(){
     //here we are adjusting the column_bp_width_arr which keeps track of the column level net width percent...
	 // if rwd is used then not used then used again it should maintain the correct  column level width percent... 
     if($this->column_use_grid_array[$this->column_level]==='use_grid'){#setup conditions for all posts within column  note that this->rwd build called before enabling correct parent column vals
          $this->column_grid_css_arr[]=$this->page_grid_units.'@@'.$this->page_br_points;//for rendering css
          $this->current_grid_units=$this->page_grid_units;//now just set in page instead of column for simplicity..
          }
     if ($this->column_level<1){   
		$this->column_bp_width_arr[0]=array();
		$this->column_bp_width_arr[0]['max'.$this->page_break_arr[0]]=array(100,$this->track_col_width);
		foreach ($this->page_break_arr as $bp){
			if (strpos($bp,'max')!==false)continue;
			$this->column_bp_width_arr[0][$bp]=array(100,min($bp,$this->track_col_width));
			}
		}
	else if ($this->column_use_grid_array[$this->column_level-1]!=='use_grid'){   
		foreach ($this->column_bp_width_arr[$this->column_level-1]  as $bp => $value){
			$curpercent=($value[0] * $this->current_net_width_percent/100);
			$curwidth=$curpercent*$this->column_total_width[0]/100;
			$curwidth=(strpos($bp,'max')!==false)?$curwidth:min($curwidth,$bp);
			$this->column_bp_width_arr[$this->column_level][$bp]=array($curpercent,$curwidth);
				//adjust the array directly if exists
			}
		}
     elseif ($this->is_clone)
          $this->rwd_build('col',$this->col_name);//this is necessary as it will generate the subsequent levels of column_bp_width_array
     }
     
#column_options     
function column_options(){
     $prime=$this->prime;
     $col_id=$this->col_id;
     $this->show_more('Column Options','noback','','',350); 
     $this->print_wrap('Col Opts',true);
     $this->submit_button();
     echo '<p class="highlight floatleft" title="Info: From parent nested column with Post Id#'.$this->blog_id.' Post Order#'.$this->blog_order_mod .' in Column '. $this->blog_table.'">Info</p>';
     printer::pclear();
     $delete_msg=($this->blog_unstatus!=='unclone')?'Delete This Entire Column':'Remove this Mirror release Column';
     $delete_alert= ($this->col_status==='unclone')?"THIS MIRROR RELEASE COLUMN WILL BE DELETED AND THE PARENT CLONE WILL NOW BE EXPRESSED":'';
    (!$this->is_clone)&&printer::printx( '<p class="left warn1 floatleft neg"><input type="checkbox" name="deletecolumn['.$this->col_name.']" value="delete" onchange="edit_Proc.oncheck(\'deletecolumn['.$this->col_name.']\',\''.$delete_alert.' CAUTION THIS ENTIRE COLUMN AND ALL THE POSTS AND NESTED COLUMNS WITHIN IT WILL BE DELETED WHEN YOU HIT CHANGE, UNCHECK TO CANCEL\');gen_Proc.use_ajax(\''.Sys::Self.'?unclone_list_column='.$col_id.'@@del_col_unc_'.$col_id.'@@'.$this->primestat.'\',\'handle_replace\',\'get\');" >'.$delete_msg.'</p>');
     printer::pclear(); 
     echo '<p id="del_col_unc_'.$col_id.'"></p>';
     if (!$this->col_primary&&$this->blog_pub){
          printer::alertx('<p class="highlight floatleft" title="Turn Off Publication of this Column and all Posts and Nested Columns Within to Web Page"><input type="checkbox" value="0" name="'.$this->data.'_blog_pub">Un-Publish Entire Column</p>');
          }
     printer::pclear(5);
     (!$this->clone_local_style)&&printer::alertx('<p class="highlight floatleft" title="Turn On Publication for all Posts and Nested Columns Within this Column"><input type="checkbox" value="1" name="'.$this->col_name.'_express_pub">Express Publish Entire Column all Posts Within</p>'); 
     printer::pclear(2); 
     $this->show_more('Width &amp; float Options / RWD systems');
     $this->print_redwrap('wrap width float rwd');
     $this->submit_button();
     printer::print_wrap1('width status',$this->column_lev_color);   
     if ($this->rwd_post){
          printer::print_caution('RWD GRID System is On. Turn Off in parent Column to enable other width choices');
          printer::print_info('RWD Grid <b>is enabled</b> in the parent Column and overrides all other width modes ie main width, alt width units, flex-box used to position this column within the parent column');
          }
     else  printer::print_info('RWD Grid <b>Not enabled</b> in the parent Column');
     if (!$this->rwd_post){
          if ($this->flex_box_item)
               printer::print_info('Flex Box Container <b>is enabled </b>in the parent Column. Disables float positioning for flex items ie. this nested column.  Use scaling width unit selection ie. em rem vw % px as needed.');
          else printer::print_info('Flex Box Container <b>Not enabled</b> in the parent Column');
          if ($this->use_col_main_width){
               $mode=($this->column_level<1)?'max-width':(($this->blog_width_mode[$this->blog_width_mode_index]==='max-width'||$this->blog_width_mode[$this->blog_width_mode_index]==='compress_full_width'||$this->blog_width_mode[$this->blog_width_mode_index]==='compress_to_percentage')?$this->blog_width_mode[$this->blog_width_mode_index]:'max-width');
              printer::print_info('Main Width using '.$mode.' <b>Is Active</b> <br>&amp; Overrides any chosen alt width units',.8); 
               }
          else printer::print_info('Main Width <b>Not Active</b>',.8);    
          if (empty($this->col_info))printer::print_info('<b>No Active</b> values for alt width units em, rem, vw, %, px  sizing this Column'); 
          else printer::print_info('Alt width unit(s) <b>Chosen:</b> '.$this->col_info);
          }
     if($this->column_use_grid_array[$this->column_level])
               printer::print_info('RWD Grid <b>Enabled</b> to position child posts within'); 
     else
          printer::print_info('RWD Grid <b>Not Enabled</b> to position child posts within');   
     if($this->column_use_flex_array[$this->column_level])
               printer::print_info('Flex Box <b>Enabled</b> to position child posts within'); 
     else
          printer::print_info('Flex Box <b>Not Enabled</b> to position child posts within');    
     if ($this->column_level>0&&$this->is_masonry)
          printer::print_info('Masonry <b>Is Active </b>for posts within',.8);
     else if ($this->column_level>0&&!$this->is_masonry)
          printer::print_info('Masonry <b>Not Active</b> for post within',.8);
     else 
          printer::print_info('Masonry Primary Column <b>NA</b>',.8); 
     printer::close_print_wrap1('width status');   
     if ($this->column_level>0){
          $this->show_more('Float Choices for Column');
          printer::print_wrap1('wrap width float',$this->column_lev_color);
          printer::print_info('<b>Note setting the float value on a nested column will directly affect the entire column ie. not the posts within it.</b>');
          printer::print_info('<b>An Acive flex Box Container &amp; Active Flex Box Items Ignore these float settings</b>');
           $this->show_more('More Info..','noback','highlight editbackground editfont floatleft','Click Here For info on Post Horizontal Post Sharing (Floating)  Choices',400);
          printer::print_wrap('more info');
          printer::alertx('<p class="$this->column_lev_color fsminfo maxwidth500 floatleft editbackground editfont">By default in RWD grid mode columns will float left to share grid space allowed and non-Grid columns will occupy entire row. Change this default behavior to Manually choose whether this nest-column floats next to another nested column or posted content! <br>Note:
                         <br><b>Center Row:</b> This single column will occupy full row and be centered.<br><b>Center Float:</b> Centers Column and shares the row space with other Floated posts. Utilizes inline-block css styling.<br><b>Left float:</b> uses float:left. Moves to left allows sharing of next post to its right.<br><b>Right float</b> uses float:right css. post justifies right allows sharing of next post to its left. <br>  <b>Float right or float left no next </b>means an element with  clear:both css follows to prevent sharing the next post on the same row.</p>');
          $this->close_print_wrap('more info');
          $this->show_close('Float type Info..');
          printer::pclear(); 
          printer::alert('Column Float Alignment Choices:','','left editcolor editbackground editfont'); 
          $chosen=(in_array($this->blog_float,$this->position_arr))?$this->blog_float:'center_row';
          forms::form_dropdown($this->position_arr,$this->position_val_arr,'','',$this->data.'_blog_float',$chosen,false,'editcolor editbackground editfont left');
          
          printer::close_print_wrap1('wrap width float');
          $this->show_close('Column Float Choices');
          }#column level >0 and not flex box
     elseif($this->column_level<1)printer::printx('<p class="fsminfo editbackground editfont left '.$this->column_lev_color.'">Note: Primary Columns Are Always Aligned Centrally and do not share space with other columns or posts. Create columns and other post types within this column and share row space as needed using  RWD grids, flex-box, alternative widths, and masonry.js for desktop to mobile responsive layout. <p>'); 
     #width calculate w/o grid... parent grid turn on!!  
     if ($this->column_level>0&&$this->column_use_grid_array[$this->column_level-1]==='use_grid'){#&&&&&&&&&&&&&&&&&&&&&&&&&&  BEGIN CLASS QUERY FOR  ACTIVE RWD POSTS  &&&&&&&&&&&&&&&&&&
          $this->rwd_build('col',$this->col_name); 
          }//if parent column RWD
     if ($this->column_level>0&&!$this->rwd_post){
          $this->flex_items('col');
          }
          #############        Finish   RWD QUERY   ##################
     ################  Begin   Manual width/float  response for this Column  &&&&&&&&&&&&& 
     #colwidth
     printer::pclear(5); 
     printer::pclear();
     $msg='';
	#colusegrid
	#width#  Information  follows..
	/*using column_bp_width_track for keeping track of width between using rwd and when not using it...
	 when not using rwd width is determined by directly choosing a width stored in col_width for columns or blog_width for normal posts..   col_width is a max px value for primary columns then a percentage for all nested columns.   RWD posts do not directly use these values but a tally of rwd grid percent values are stored  in $this->column_bp_width_arr once a rwd column is chosen and updated with grid percent for each successive column level.  
	 The selected RWD Grid values are then used to directly update col_width or blog_width and here we approximate that width corresponding to maxbp gives the maximum  width. Non RWD widths can then continue to be had and current net width percentages are used to update the $this->column_bp_width_arr. Percentages will always be true to value. If RWD is returned on after being on and off Widths should be calculated exactly accurate again for each bp. Haven yet tried this.  Similary, a running tally for max_width_limit is used to inform what is the max width limit for Rwd Grid breakpoints or when RWD is not used updated with the current_net_width_percent determined from col_width..
	*/ 
	$this->column_bp_width_track();
     if($this->column_use_grid_array[$this->column_level]!=='use_grid'){
          $msg= ' RWD Grid Sizing for posts (incuding this nested column) within the parent Column is not set. Manually narrow the maximum width of this Column Here. If instead you want to use RWD Grid to size and position this entire column then enable it in its <b>Parent Column</b>';  
          printer::print_wrap1('rwd mode',$this->column_lev_color);
          (!$prime)&&printer::alertx('<p class="tip" >'.$msg.'</p>');
          $gridstyle='style="display:none;"';
          printer::printx('<p class="editbackground editfont highlight floatleft" title="Enable Responsive Web Sizing/Positioning for Child Posts Within This Column"><input type="checkbox" name="'.$this->col_name.'_col_options['.$this->col_use_grid_index.']" onclick="edit_Proc.displaythis(\''.$this->col_name.'_grid_show\',this,\'\')" value="use_grid">Enable RWD Grid Positioning for Child Posts Within This Column</p>');
          printer::close_print_wrap1('rwd mode');
          printer::pclear();	
          }
     else{
          printer::print_info('Posts within this column are set to RWD display on grid. Flex Box Mode not available');
          $gridstyle='style="display:block;"';
          printer::printx('<p class="editbackground editfont highlight left" '.$gridstyle.' title="Disable Responsive Web Sizing for Posts Within This Column"><input type="checkbox" name="'.$this->col_name.'_col_options['.$this->col_use_grid_index.']"  value="0">Disable RWD Grid Positioning for Posts Within This Column</p>');
          printer::pclear();
          } 
     printer::pclear();
     if ($this->column_level==0||($this->column_level>0&&$this->column_use_grid_array[$this->column_level-1]!=='use_grid')){
		$msg=($this->column_level==0)?'Choose Maximum Display Width For this Top Level Column. Used for limiting Image Size and Content Displays on Larger Size Screens. Default is specified by the current page_width setting.' : ' RWD Grid Sizing for posts (incuding this nested column) is not enabled within the <b>Parent Column</b>. Manually narrow the maximum width of this Column Here'; 
		$this->column_main_width();
          printer::pclear(2);  
		##############################################
		$this->width_options('col',$this->col_name);
		 ############   End manual width/float  Control for this column  &&&&&&&&&&& 
          $this->flex_container();
          printer::pclear(2); 
		}//non rwd parent column or primary column
	if (!$prime){
		$checked1=($this->col_options[$this->col_enable_masonry_index]!=='masonry')?'checked="checked"':'';
		$checked2=($this->col_options[$this->col_enable_masonry_index]==='masonry')?'checked="checked"':'';
          $this->show_more('Masonry Option');
		$this->print_redwrap('wrap masonry','maroon');
	if ($this->column_use_flex_array[$this->column_level])printer::print_warn('Note: Flex Box Container enabled and masonry assist currently overrides various Flex Box features.  ie. the two are not fully compatible.');
		$msg='Optionally enable Masonry to Assist in grid layout of Posts (including a nested column) directly within this column. Masonry will work in conjunction with your post width settings and alternative width settings. Post Float settings should be set to float left or float right. Float center may also be used but appropriate margin percents will need to be included as masonry otherwise overlooks the centering. Masonry will override Flex Box functionality';
		printer::print_tip($msg);
		printer::print_tip('Masonry if enabled may change the order of your posts to get the best fit');
          printer::print_tip('The width of the first post in a masonry column will set the grid width for all other posts. Best results often using widest post in first position');
		printer::printx('<p><input type="radio" '.$checked1.' value="nomasonry" name="'.$this->col_name.'_col_options['.$this->col_enable_masonry_index.']">No Masonry</p>');
		printer::printx('<p><input type="radio" '.$checked2.' value="masonry" name="'.$this->col_name.'_col_options['.$this->col_enable_masonry_index.']">Enable Post Masonry Assist</p>');
          $this->submit_button();
		$this->close_print_wrap('wrap masonry' );
          $this->show_close('Masonry Option');
		}
	else{
		$this->show_more('Primary Column Masonry Info');
		printer::print_tip('Masonry enabling not available in Primary Column because the masonry enabling column needs to be wrapped itself by a column. Simply create a nested a column in the primary column and posts within will be masonry enabled when you enable the masonry option in the nested column. Any primary column can easily become a nested column by checking the box to create a new primary column under the add primary option, submit,  then choose to <b>move</b> the  old primary column entering its id. Thats it, you can then enable masonry mode in that column.'); 
		$this->show_close('Primary Column Masonry Info'); 
		}	
	$this->submit_button();
	printer::close_print_wrap('wrap width float rwd');
	$this->show_close('Width and float Options / RWD Grid System');
		//this should display for all rwd and non rwd
	printer::pclear();
	$this->show_more('Import/Export Column Config Option');
	$this->print_redwrap('import/export',true);
     printer::print_info('Individual Column Style settings are imported/exported for the various groups of styles by using options at the bottom of each type list of style options');
	echo '<div class="'.$this->column_lev_color.' fsminfo floatleft editbackground editfont left "><!--import-->Import Column Configurations and Column styles from another Column from any page. Will Not change the basic Data such Images, captions, text within your column';
	printer::printx( '<p class="editcolor editbackground editfont" title="Be Sure to Use the Column Id Which Begins with a C ie C11.  Do Not Use the  Col# which simply refer to the Column Display Order Within the Page. Col Ids and #s are displayed at the top of each column"><input class="editcolor editbackground editfont" name="col_configcopy['.$this->col_id.']" size="8" maxlength="8" type="text">Enter the  <span class="info">Col Id</span> <span class="red">(Not Col#) </span>that you wish to Copy Configurations and Styles</p>');
	printer::pclear();
	echo '</div><!--import-->';
	printer::pclear();
	###########################################################Begin Import/Export Col
	if ($this->column_level>0){  
		
		echo '<div class="'.$this->column_lev_color.' fsminfo  editbackground editfont left "><!--export-->Export styles and configuration from this Nested Column post to any other Nested Column post that is directly within the same parent Column';
		printer::printx( '<p class="editcolor editbackground editfont" 	><input class="editcolor editbackground editfont" name="col_configexport['.$this->col_id.']"   type="checkbox" value="'.$this->col_id.'">Export these Styles and Configs to other nested column posts within this column</p>');
		echo '</div><!--export-->';
		####################################################
		echo '<div class="'.$this->column_lev_color.' fsminfo  editbackground editfont left "><!--import-->Import RWD Grid percentage selections  from another nested column post from any page that has the same Grid Break Points set in the page options.  ';
		printer::printx( '<p class="editcolor editbackground editfont" title="Be Sure to Use the Column Id Which Begins with a C ie C42.  Do Not Use the  Column# which simply refer to the Column Display Order Within the Primary Column. Column Ids and #s are displayed at the top of each post"><input class="editcolor editbackground editfont" name="col_rwdcopy['.$this->col_id.']" size="8" maxlength="8" type="text">Enter the  <span class="info">Column Id</span> <span class="red">(Not Column#) </span>that you wish to copy Column RWD grid break point percentages</p>');
		echo '</div>'; 
		echo '<div class="'.$this->column_lev_color.' fsminfo  editbackground editfont left "><!--export-->Export RWD settings from this Nested Column to any other nested column post that is directly within the same parent Column as this column';
		printer::printx( '<p class="editcolor editbackground editfont" ><input class="editcolor editbackground editfont" name="col_rwdexport['.$this->col_id.']"  type="checkbox" value="'.$this->col_id.'">Export this Columns RWD Grid settings to other nested columns directly within the parent column</p>');
		printer::printx( '<p class="editcolor editbackground editfont" ><input class="editcolor editbackground editfont" name="col_post_rwdexport['.$this->col_id.']"  type="checkbox" value="'.$this->col_id.'">Also inlude exporting these nested column RWD GRID settings to non-nested post types also directly within the same parent column (will not affect posts within this nested column)</p>'); 
		echo '</div><!--export-->'; 
		#######################################################
		echo '<div class="'.$this->column_lev_color.' fsminfo  editbackground editfont left "><!--export-->Export the Main Width value setting (affects posts in non-RWD grid mode) from this post to  posts that are in the same parent Column as this column';
		printer::printx( '<p class="editcolor editbackground editfont" ><input class="editcolor editbackground editfont" name="col_widthexport['.$this->col_id.']"  type="checkbox" value="'.$this->blog_id.'">Export the Main Width value setting of this nested column to all other nested columns directly in the same parent column</p>');
          printer::printx( '<p class="editcolor editbackground editfont" ><input class="editcolor editbackground editfont" name="col_post_widthexport['.$this->col_id.']"  type="checkbox" value="'.$this->blog_id.'">Also include exporting this nested column width value setting  to non-nested post types also directly within the same parent column (will not affect posts within this nested column)</p>'); 
		echo '</div><!--export-->'; 
		#######################################################
		echo '<div class="'.$this->column_lev_color.' fsminfo  editbackground editfont left "><!--export-->Export the Alt RWD Percentage settings (affects posts in non-RWD grid mode) from this post to  posts that are in the same parent Column as this column';
		printer::printx( '<p class="editcolor editbackground editfont" ><input class="editcolor editbackground editfont" name="col_widthmodeexport['.$this->blog_id.']"  type="checkbox" value="'.$this->blog_id.'">Export the Alt RWD Percentage settings of this nested column to all other nested columns directly in the same parent column</p>');
          printer::printx( '<p class="editcolor editbackground editfont" ><input class="editcolor editbackground editfont" name="col_post_widthmodeexport['.$this->blog_id.']"  type="checkbox" value="'.$this->blog_id.'">Also include exporting these nested column width mode settings to non-nested post types also directly within the same parent column (will not affect posts within this nested column)</p>'); 
		echo '</div><!--export-->'; 
		#######################################################
		echo '<div class="'.$this->column_lev_color.' fsminfo  editbackground editfont left "><!--export-->Export the Float Mode settings (affects posts sharing rows in non Flex Box mode) from this post to  posts that are directly within the same parent Column as this column';
		printer::printx( '<p class="editcolor editbackground editfont" ><input class="editcolor editbackground editfont" name="col_floatexport['.$this->blog_id.']"  type="checkbox" value="'.$this->blog_id.'">Export Float setting of this nested column to all other nested columns directly in the same parent column (will not affect posts within this nested column)</p>');
          printer::printx( '<p class="editcolor editbackground editfont" ><input class="editcolor editbackground editfont" name="col_post_floatexport['.$this->blog_id.']"  type="checkbox" value="'.$this->blog_id.'">Also include exporting these nested column float settings to non-nested post types also directly within the same parent column (will not affect posts within this nested column)</p>'); 
		echo '</div><!--export-->'; 
		 ################
		 #############################
       echo '<div class="'.$this->column_lev_color.' fsminfo  editbackground editfont left "><!--export-->Export the <b>Flex Item settings</b> (see flex-container setting down below for this option) for this Column to sibling columns when the parent column is activated for flex box (affects nested column posts in non-rwd grid mode). Copies flex-item settings from this nested column post to others  directly within the parent Column. Field: blog_flex_box';
	printer::printx( '<p class="editcolor editbackground editfont" ><input class="editcolor editbackground editfont" name="col_flexitemexport['.$this->blog_id.']"  type="checkbox" value="'.$this->blog_id.'">Export the Flex Item settings of this nested column to all nested columns directly in the parent column</p>');
     printer::printx( '<p class="editcolor editbackground editfont" ><input class="editcolor editbackground editfont" name="col_post_flexitemexport['.$this->blog_id.']"  type="checkbox" value="'.$this->blog_id.'">Also include Flex Item export of values to non nested column posts directly in same parent column. Field: blog_flex_box</p>');
	echo '</div><!--export-->'; 
          }
		#End Import/Export col ..
	####################################################
	echo '<div class="'.$this->column_lev_color.' fsminfo  editbackground editfont left "><!--import-->Import Flex Container  settings from another column to this column. Will affect behavior of posts within column and whether this column itself has inline property or not';
		printer::printx( '<p class="editcolor editbackground editfont" title="Be Sure to Use the Column Id Which Begins with a C ie C42.  Do Not Use the  Column# which simply refer to the Column Display Order Within the Primary Column. Column Ids and #s are displayed at the top of each post"><input class="editcolor editbackground editfont" name="col_flexcopy['.$this->col_id.']" size="8" maxlength="8" type="text">Enter the  <span class="info">Column Id</span> <span class="red">(Not Column#) </span>that you wish to copy Column Flex Container settings</p>');
		echo '</div>';
     
	#######################################################33
     if ($prime)printer::print_tip('Note: Additional import/export options availible for nested column types');
     $this->submit_button();
     printer::close_print_wrap('import/export');
     $this->show_close('Import Column Configurations Option');
     printer::pclear();
	$this->show_more('Adjust default Vertical Alignment within row');
	$this->print_redwrap('Adjust default Vertical');
     printer::print_tip('Flex Box Settings if enabled in parent column will override these Vertical settings according to flex container align-item settings and flex-item align-self setting');
	printer::print_tip('By Default Nested Columns will Vertically Top Align with Other Posts within the Parent Column. Affects non-flex mode columns. Change that Default Here '); 
	printer::alert('Column Vertical Positioning Choice','','left editcolor editbackground editfont');
	$current_vert_val=($this->col_options[$this->col_vert_pos_index]!=='middle'&&$this->col_options[$this->col_vert_pos_index]!=='bottom')?'top':$this->col_options[$this->col_vert_pos_index];
	forms::form_dropdown(array('top','middle','bottom'),'','','',$this->col_name.'_col_options['.$this->col_vert_pos_index.']',$current_vert_val,false,'editcolor editbackground editfont left');
	$this->css.="\n.". $this->col_dataCss.'{vertical-align:'.$current_vert_val.'}';
	printer::close_print_wrap('Adjust default Vertical'); 
	$this->show_close('Adjust default Vertical Positioning');	
		#colopt  #colconf 
			printer::pclear();
		$tag=(!empty($this->col_options[$this->col_tag_display_index]))?$this->col_options[$this->col_tag_display_index]:'';
	$this->show_more('Tagged Post Display');
		$this->print_redwrap('tagged area');
		printer::print_tip('Optionally Display tagged Posts here and Only Posts matching the tag you enter here will be displayed in this column. Posts Previously made in this column will not not be displayed unless similary tagged');
		printer::printx('<div><p class="editcolor editbackground editfont info floatleft"><input type="text" value="'.$tag.'" name="'.$this->col_name.'_col_options['.$this->col_tag_display_index.']" size="20" maxlength="20">Enter Tags to Display Here (space separate):&nbsp;</p></div>');
		printer::pclear();
		printer::close_print_wrap('tagged area');
          $this->show_close('Enter Tagged posts to dispaly only');
		$this->animation();
		printer::pclear();
		$this->position();
          $this->overflow('col',$this->col_name);
          $this->height_style('col',$this->col_name);
		(!$prime)&&$this->display_state();//RWD control display_state
		$this->show_more('Transfer Clone Column');
	$this->print_redwrap('clone transfer');
	echo '<p class="highlight Os3darkslategray fsmyellow editbackground editfont click floatleft" title="View Pages with clones of this column" onclick="gen_Proc.use_ajax(\''.Sys::Self.'?check_clones='.$this->col_id.'&amp;check_id=check_clones_'.self::$xyz.'\',\'handle_replace\',\'get\');" >Click to display Pages with Clones of this Column</p>';
	echo '<div id="check_clones_'.self::$xyz.'"></div>';
	printer::pclear();
	printer::print_tip('If this Column is directly cloned ie. used as a template you can change the template to another Column by entering its Column Id and submitting.  All the former Column Clones of id C'.$this->col_id.' will then be changed to the new template and unmirrored content if any is retrieved by importing the unmirorred post/col.');
	($this->col_primary)&&printer::print_caution('Clone Transfer of a Primary Column to a Nested Column will reset the nested column to the default Page Width configuration on the cloned page rendering',.8);
	printer::printx( '<p class="editcolor editbackground editfont" title="Be Sure to Use the Column Id Which Begins with a C ie C11.  Do Not Use the  Col# which simply refer to the Column Display Order Within the Page. Col Ids and #s are displayed at the top of each column"><input class="editcolor editbackground editfont" name="col_transfer_clone['.$this->col_id.']" size="8" maxlength="8" type="text">Enter the new <span class="info">Col Id</span> <span class="red">(Not Col#) </span>that you wish to Clone Transfer to</p>');
	printer::close_print_wrap('clone transfer');
	$this->show_close('Transfer Clone Column');
     printer::pclear(2); 
     $this->submit_button();
     printer::close_print_wrap('Col Opts');
     $this->show_close('Column Options');echo '<!--column options-->';
     printer::pclear(2);
     }//end column_options #end


     
function blog_options($data,$tablename){if(Sys::Custom)return; 
	if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	if(!$this->edit)return;
     $this->{$data.'_blog_options'}=$this->blog_options;//for passing name array directly to style functions  
	if ($this->is_clone&&!$this->clone_local_style){
          $this->width_mode(); 
		return;
		}
	elseif ($this->is_clone&&!$this->clone_local_style)return; 
	if (empty($tablename))return;#not a blog request 
	$this->show_more('Post Settings','buffer_post_settings_'.$this->orig_val['blog_id'],'','',500,'','float:left;',true);
	$this->print_redwrap('blog opts',true);
     $this->submit_button();
	echo '<div class="fsminfo editbackground editfont floatleft "><!--Checkbox OPtions Border-->';	
	$this->delete_option();
	printer::pclear();
	if ($this->blog_pub){
		printer::alertx('<p class="highlight floatleft" title="Turn Off Publication of this Post to Web Page"><input type="checkbox" value="0" name="'.$this->data.'_blog_pub"> Un-Publish Post to WebPages</p>');
		}
	printer::pclear();
	if (!empty($this->blog_border_start)){
		$name='blog_border_start_remove['.$data.']';
		$msg='<span class="warnlight">Remove Begin Post Group Styles</span>';
		}
	else	{
		$name=$data.'_blog_border_start';
		$msg='Begin Post Group Styles';
		}
	echo '<p class="highlight floatleft"  title="&#34;Group Styles&#34; provide an opportunity to quickly select group(s) of posts within a Column to distinguish them as related such as using a simple border. Begin by checking the begin box on the first non column post and check the end box on the last non column post you wish to distinguish within the same column! Span column posts between open and close tags if you wish.  Be sure to match with a close groupstyle before beginning with a new one in the same column.  Unmatched open border and close border checked options will generate an alert message and can mess up the webpage styling. For more info on Post Grouping Styles and to set styling options go to the &#34;Group Style&#34; options under the master column settings. Check both boxes on the same post to end an group and begin another group or to wrap a single post, the system will determine which one is intended as long as your consistent with closing every opening. "><input type="checkbox" name="'.$name.'" value="1">&nbsp;'.$msg.'</p>';
	 
	 if (!empty($this->blog_border_stop)){
		$name='blog_border_stop_remove['.$data.']';
		$msg='<span class="warnlight">Remove End Post Group Styles</span>';
		}
	else	{
		$name=$data.'_blog_border_stop';
		$msg='End Post Group Styles';
		}
	echo '<p class="highlight floatleft"  title="Checking here ends Group Post styles started on a post above and this post will be included."><input type="checkbox" name="'.$name.'" value="1">&nbsp;'.$msg.' </p>';
	printer::pclear();
	if ($this->blog_type==='float_image_left'||$this->blog_type==='float_image_right'||$this->blog_type==='text'){
		$msg=($this->blog_options[$this->blog_editor_use_index]==='use_editor')?'Toggle TinyMCE Editor':'Keep On TinyMCE Editor';
		if ($this->blog_options[$this->blog_editor_use_index]==='use_editor')	
			echo '<p class="highlight floatleft" title="Check to Utilize TinyMCE only when needed and submit with other changes"><input type="checkbox" name="'.$data.'_blog_options['.$this->blog_editor_use_index.']" value="0">'.$msg.'</p>';
				
		else echo '<p class="highlight floatleft" title="Check to keep TinyMCE Editor On in addition to the normal editing options below this post then submit to commit along with other changes on the page"><input type="checkbox" name="'.$data.'_blog_options['.$this->blog_editor_use_index.']" value="use_editor">&nbsp;'.$msg.'</p>';
		printer::pclear();
		if ($this->blog_options[$this->blog_comment_index]==='comment_on') 
			printer::printx ('<p class="highlight floatleft" title="Check to Turn off the display of Viewing Comments for this Post"><input type="checkbox" name="'.$data.'_blog_options['.$this->blog_comment_index.']" value="0">Turn off Commenting </p>');
					
		else printer::printx ('<p onclick="edit_Proc.displaythis(\''.$data.'_comments_show\',this,\'\')"  class="highlight floatleft" title="Check to enable Viewers to Submit for Display Comments to this Post"><input type="checkbox" name="'.$data.'_blog_options['.$this->blog_comment_index.']" value="comment_on">Allow Commenting</p>');
		printer::pclear();
		$genstyle=($this->blog_options[$this->blog_comment_index]==='comment_on')?'style="display:block;"':'style="display:none;"';
		$checked1=($this->blog_options[$this->blog_comment_display_index]!=='display_comment')?'checked="checked"':'';
		$checked2=($this->blog_options[$this->blog_comment_display_index]==='display_comment')?'checked="checked"':'';
		printer::printx('<p id="'.$data.'_comments_show" class="editcolor editbackground editfont" '.$genstyle.'><input type="radio" '.$checked1.' name="'.$data.'_blog_options['.$this->blog_comment_display_index.']" value="0">Hide-n-Click to Open Comments<br><input type="radio" '.$checked2.' name="'.$data.'_blog_options['.$this->blog_comment_display_index.']" value="display_comment" >Display Comments Directly</p>');
		}// if text and float image text types
	if ($this->blog_options[$this->blog_date_on_index]==='date_on') 
			
		printer::printx('<p class="'.$this->column_lev_color.'"><input type="checkbox" name="'.$data.'_blog_options['.$this->blog_date_on_index.']" value="0">Turn Off Date Display</p>');
		  
	else	printer::printx('<p class="highlight editbackground editfont" title="Display the Posted Date" ><input type="checkbox" name="'.$data.'_blog_options['.$this->blog_date_on_index.']" value="date_on">Turn On Current Post Date Display</p>');
	
	echo '</div ><!--Checkbox Options Border-->';
	printer::pclear(5); 
	$this->show_more('Width and float Options / RWD Grid System');
	$this->print_redwrap('width and float post options');
	printer::pclear();
     $this->submit_button();
     printer::pclear(5);
     printer::print_wrap1('width status',$this->column_lev_color);   
     if ($this->rwd_post){
          printer::print_caution('RWD GRID System is On. Turn Off in parent Column to enable other width choices');
          printer::print_info('RWD Grid <b>is enabled</b> in the parent Column. Overrides other width modes');
          }
     else  printer::print_info('RWD Grid <b>Not enabled</b> in the parent Column');
     if (!$this->rwd_post){ 
          if ($this->flex_box_item)
               printer::print_info('Flex Box <b>is enabled</b> in the parent Column. Use along with main or alternative width units as needed.');
          else printer::print_info('Flex Box <b>Not enabled</b> in the parent Column');
         if ($this->use_blog_main_width){
               $mode=($this->blog_width_mode[$this->blog_width_mode_index]==='maxwidth'||$this->blog_width_mode[$this->blog_width_mode_index]==='compress_full_width'||$this->blog_width_mode[$this->blog_width_mode_index]==='compress_to_percentage')?$this->blog_width_mode[$this->blog_width_mode_index]:'maxwidth';
          
               if($this->flex_box_item)
                    printer::print_info('<b> Active Flex Box </b> Enabled in Parent column. May be using may width options.');
               else printer::print_info('Main Width Mode using <b>'.$mode.' is Active</b>. Overrides Alt em, rem, vw, %, px units if set');
               }
          else { 
               printer::print_info('Main Width <b>Not Active</b>. ');
               }
          }//!$this->rwd_post
     
	$info=$this->check_spacing($this->blog_options[$this->blog_max_width_opt_index],'max-width');
	$info.=$this->check_spacing($this->blog_options[$this->blog_width_opt_index],'width');
	$info.=$this->check_spacing($this->blog_options[$this->blog_min_width_opt_index],'min-width');
     if (empty($info))printer::print_info('<b>No Active</b> alt width units em, rem,  %, px  sizing this '.$this->blog_typed); 
     else printer::print_info('Alternative Width Units Selected: '.$info);
     
     if ($this->is_masonry)printer::print_info('<b>Active</b> masonry assist in parent column positioning this post');
     else printer::print_info('<b>No active</b> masonry assist in parent column acting on this post');
     printer::close_print_wrap1('width status');
     $this->show_more('Float Mode Share Row Space ');
     printer::print_tip('Flex Box Settings if enabled in parent column will override these Float settings according to flex container justify-content setting');
     printer::alertx('<div class="'.$this->column_lev_color.' maxwidth400  floatleft left fsminfo editbackground editfont">Share Horizontal Space');
     printer::print_tip('Sets behavior or RWD Grid Mode. Works with Main Width Mode, or scaling width units  ie. em, rem, vw, %, px without or without masonry to share available row space betweem posts.');
     printer::pclear();
     $this->show_more('Float Info..','noback','highlight editbackground editfont floatleft','Click Here For More info on Post Horizontal Share (Floating)  Choices',400);
     printer::print_wrap('more info');
     printer::alertx('<p class="floatleft editbackground editfont editcolor">By default in RWD grid mode Posts will float left to share grid space allowed and non-RWD-Grid posts will occupy an entire row. Change this default behavior to Manually choose whether this posts floats next to another or occupies a full row. <br>
     Enable manually floating a post next to another by limiting the respective widths to a total cumulative percentage less than 100% and then choosing a float option. By default, the center row option causes the post to occupy the whole role, whereas the other choices allow space sharing.<b><br><b>Center Row:</b> This single post will occupy full row and be centered.<br><b>Center Float:</b> Centers post and shares the row space with other Floated posts. Utilizes inline-block css styling.<br><b>Left float:</b> uses float:left. Moves to left allows sharing of next post to its right.<br><b>Right float</b> uses float:right css. post justifies right allows sharing of next post to its left. <br>  <b>Float right or float left no next </b>means an element with  clear:both css follows to prevent sharing the next post on the same row.</p>','',"");
     printer::close_print_wrap('more info');
     
     $this->show_close('Post Position Choices');//<!--Show More Post Position Choices-->';
     echo '<div class="fs1color floatleft editcolor editbackground editfont"><!--Position- Border-->';
     printer::alert('Float Choices');
     $chosen=(in_array($this->blog_float,$this->position_arr))?$this->blog_float:'center_row';
      
     forms::form_dropdown($this->position_arr,$this->position_val_arr,'','',$data.'_blog_float',str_replace('_',' ',$chosen),false,'ramana');
     echo '</div><!--end pos choices-->';  
      echo '</div><!--End form dropdown Post Positions-->';
      
     $this->show_close('Share Row Space float Mode');
     printer::pclear(2); 
     if ($this->flex_box_item)$this->flex_items('blog');
     if (!$this->rwd_post){
          $this->show_more('Choose Main Width Options');
          $this->print_redwrap('width wrap');
          if ($this->flex_box_item){
                printer::alert('Flex-box mode is enabled in the parent column. Use flex box or disable it');
               }
          printer::print_tip('The main width Mode keeps track of width sizes through nested column levels ( tracker is also compatible mixing with RWD Grid Width use). This  Width mode is expresed as either max-width, percent, or dynamic percent together with min-width explained below.  Below these are further width with em, rem, &amp; vw unit options. To width size this post/column using Flex Box or RWD Grid instead, enable them in the parent column.');
          echo '<div class="fsminfo editbackground editfont "><!--width options-->';
          $this->blog_width=(is_numeric($this->blog_width))?$this->blog_width:0;
          $this->{$data.'_blog_width_arrayed'}=explode(',',$this->blog_width);
          $this->width($data.'_blog_width_arrayed',0);
          printer::pclear();
          echo '</div><!--width options-->';	 
          printer::pclear(3);
          $this->width_mode();   
          printer::pclear(5);
          ### 
          printer::close_print_wrap('width wrap');
          $this->show_close('Choose Max-width &amp width% with min-width options');
          $this->width_options('blog',$this->data);//alt width units
          }//rwd grid and flex box not enabled...
     
	else{//using RWD select classes
		$this->rwd_build('blog',$data);
		}//end RWD select classes
      
	$this->submit_button();
	$this->close_print_wrap('width and float post options'); 
	$this->show_close('Width and float Options / RWD Grid System');
	################################## 
	printer::pclear(5);
	$this->animation();
	printer::pclear(5);
     $this->blog_import_export_options();
	$this->display_state();//RWD control display_state 
	printer::pclear(5);
	#########################################
	$maxheight=1500; 
	#####################################
	$this->position();
	#######################################
	$this->show_more('Vertical Align Posts');
     $this->print_redwrap('vertical align');
     printer::print_tip('Flex Box Settings if enabled in parent column will override these Vertical settings according to flex container align-item settings and flex-item align-self setting');
     printer::alertx('<div class="'.$this->column_lev_color.' fsminfo maxwidth500 floatleft editbackground editfont">By Default Posts will Vertically Top Align with Other Posts within the Parent Column. Change that Default Here '); 
     printer::alert('Post Vertical Positioning Choice','','left editcolor editbackground editfont');
     $current_vert_val=($this->blog_options[$this->blog_vert_pos_index]!=='middle'&&$this->blog_options[$this->blog_vert_pos_index]!=='bottom')?'top':$this->blog_options[$this->blog_vert_pos_index];
     forms::form_dropdown(array('top','middle','bottom'),'','','',$data.'_blog_options['.$this->blog_vert_pos_index.']',$current_vert_val,false,'editcolor editbackground editfont left');
     $this->css.="\n.".$this->dataCss.'{vertical-align:'.$current_vert_val.'}';
     printer::alertx('</div>');
     printer::pclear();
     printer::close_print_wrap('vertical align');
     $this->show_close('Vertical Align Posts');
     $this->overflow('blog',$this->data);
	$this->height_style('blog',$this->data);
	###################################
	$blog_custom_class=(!empty($this->blog_options[$this->blog_custom_class_index])&&!is_numeric($this->blog_options[$this->blog_custom_class_index]))?$this->blog_options[$this->blog_custom_class_index]:'';
	echo '<div class="fsminfo info editbackground editfont floatleft"><!--Blog Tag Border-->'; 
	printer::printx('<p title="">Add one or more Custom Classnames:&nbsp;<input type="text" value="'.$blog_custom_class.'" name="'.$data.'_blog_options['.$this->blog_custom_class_index.']" size="20" maxlength="40"></p>');
	$this->show_more('More Info','','tiny info','Add a class suffix');
     printer::print_wrap1('more info custom class');
     printer::print_tip('The idea is that you can selectively style a subset of posts within a column or a page by giving the subset of posts the same classname then setting styles for that classname only once instead of in each post.  You can then specify the styles on the parent column level using advanced styles or on the page level by using custom class option styling. Either way will work! <br><br>Parent column level styling:  To style posts with this classname within a parent column go the parent column, then settings, then edit Column styles, go down to  Advanced Styling Options and add your styles manually. Be sure to select the Add Suffice Option and first include a space (which designates look for descendant classname ie child post with this classname)  followed by the "." then your classname.<br><br>Page Level: Set your styles in the page level custom class options. Go to configure this page options. Go to Style H-Tags and Special Classes option. Make your style choices under a classname ie myclass6. Use same custom classname here and on other posts you wish to style the same.');
     printer::close_print_wrap1('more info tag');
	$this->show_close('More Info'); 
	echo '</div><!--Blog Tag-->';
	echo '<div class="fsminfo info editbackground editfont floatleft"><!--Blog Tag Border-->'; 
	printer::printx('<p title="Enter an optional tag for this post. All posts with the tag will be displayed if you set a  column with matching tag to display. Enter more than one tag as required.">Tag this Post:&nbsp;<input type="text" value="'.$this->blog_tag.'" name="'.$data.'_blog_tag" size="20" maxlength="40"></p>');
	$this->show_more('More Info','','tiny info','Add a class suffix');
	printer::print_wrap1('more info custom class');
     printer::print_tip('You can specify a tag name here and the same tag in other posts within this page or on other pages. Then to display posts with this tag within a column on any page go to column setting then select Tagged Post Display option and add this tag name. Multiple tag names can be used. The column will then only display those posts with that tagname.');
     printer::close_print_wrap1('more info tag');
	$this->show_close('More Info');  
	echo '</div><!--Blog Tag-->';
	printer::pclear(); 
	$this->submit_button();
	printer::close_print_wrap('blog opts');
	$this->show_close('Post Settings','buffer_post_settings_'.$this->orig_val['blog_id']);echo '<!--Post Options-->';
	printer::pclear(2);
	}//end blog options
     
     
#br	#blogrender# this is the main method to process posts for a given column and send them with populated values to their repective functions for content rendering.  
#$this->render_body_main() calls the primary columns.  This function will recursively be called with each successsive nested column and the posts within called. This occurs by accessing the master_post table in the data base  which holds each post type including nested column post type in  a separate record with reference to the parent column id (blog_col) and the blog_order which orders each post. If a record is a nested column it will hold an additional id of record in separte table columns which holds general column data in addition to certain configurations the column uses held in the original master post table for example blog_float pertains not only to normal posts but to column float row sharing as well.  However col_style in the column record holds the main col styling and blog_style pertains only to non nested column post types.  
function blog_render($col_id,$prime=false,$col_table_base=''){
	if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	if (in_array($col_id,$this->column_moved))return; 
	$this->col_id=$col_id;
	$this->col_table_base=$col_table_base;
	$tablename=$col_table_base.Cfg::Col_suffix.$col_id;
     if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	$border_end_ref='';
	$border_begin_ref='';
	$floating=false;
	$this->is_masonry=false;
	$this->blog_border_stop=false;
	$show_new_blog=false;
	$this->clone_ext=($this->is_clone&&$this->clone_local_style)?'clone_'.$this->orig_val['blog_id'].'_':'';//for main columns 
	if($prime){ 
          $this->fieldmax=0;
		$this->col_options=(!is_array($this->col_options))?explode(',',$this->col_options):$this->col_options;
		for ($i=0;$i <count(explode(',',Cfg::Column_options)); $i++){
			if (!array_key_exists($i,$this->col_options))$this->col_options[$i]=0;
			}
          $this->total_float(true);//initiates some prime column values concerning the total width including borders margins padding etc.  As separate call to this function is made for post types including nested columns.
          $this->col_dataCss=$this->clone_ext.$this->col_table_base.'_col_'.$col_id;//this will be updated with new values just before # nested_column div is rendered to file with the new values for the next round...
          $this->pelement=".$this->col_dataCss.primary";//set for nested column types
          if ($this->edit&&$this->use_col_main_width){
               $this->css.="$this->pelement {max-width: {$this->current_total_width}px;}";
               }
          ($this->edit)&&$this->id_array[]=array('col',$this->col_dataCss,$this->column_level,'<span class="bold">column</span> id: c'.$this->col_id,$this->is_clone,'show');
          }
	$this->sibling_id_arr['c'.$col_id]=$this->col_dataCss;
	if ($col_table_base!==$this->pagename&&!$this->clone_local_style)
	#page stylesheet will collect additional page references for the expression of cloned css. 
	$this->page_stylesheet_inc[]=$col_table_base; 
	$this->is_column=true;
	#with cloning, records from another post   can be presented identically on the same or different page as a clone without disturbing the original..
     #this->is_clone below is very important value. When set as true at the  column level, ie right here,  any posts within that column will be set as is_clone = true.  Is clone when true will prevent styling options from being presented in the cloned presentation. But it will also initiate a search for unclones and local styling and local data as well which allows for restyling, or main data switchout while preserving all configs and styles  or completely substituting out a portion ( post type of any kind) within a cloned column, respectively.
	$this->is_clone=(array_key_exists($this->column_level,$this->column_clone_status_arr))?(($this->column_clone_status_arr[$this->column_level])?true:false):false;
	($this->edit)&&$this->column_lev_color=$this->color_arr_long[$this->column_level];
	 if ($this->edit){
		if(isset($_POST['submitted'])&&!$this->is_clone){
			$this->process_blog($tablename,$col_id);
			#process blog will initiate searches for submitted data changes within this pagename
			}
		if(isset($_POST['submitted'])&&in_array($col_id,$this->delete_col_arr))return;//column has been deleted
		} 
	#primary
	#Note if prime column,  data for this column has been populated already in method   render_body_main  
	$style=''; 
	if($prime&&!$this->edit){
		list($anim_type,$anim_height,$anim_lock,$aef_class)=$this->preanimation(); 
		$anim_class=($anim_type!=='none' && !$aef_class)?" $anim_type animated active-anim " :(($anim_type!=='none')?" $anim_type animated ":'');
		$dataAnimHeight=($anim_type!=='none')?' data-hchange="'.$anim_height.'" ':'';
		$dataAnimLock=($anim_type!=='none')?' data-hlock="'.$anim_lock.'" ':'';
          #primediv #primarydiv
		print '<div id="'.$this->col_dataCss.'"  class="'.$this->col_dataCss.$anim_class.' primary" '.$dataAnimHeight.$style.'><!--Begin Primary Column id'.($this->col_id).'-->';
		}
	elseif ($prime){// this is edit
        list($bw,$bh)=$this->border_calc($this->col_style);
		if (!empty($bw)) 
			$bs=$this->calc_border_shadow($this->col_style);
		$addclass=(empty($bw))?' bdoub'.$this->page_editborder.$this->column_lev_color.' ':((empty($bs))?' bshad'.$this->page_editborder.$this->column_lev_color.' ':'editcol');
		print '<div  id="'.$this->col_dataCss.'" class="'.$addclass.' '.$this->col_dataCss.' primary column edit editdefaultcol" '.$style.'><!--Begin edit  Primary Column id'.($this->col_id).'-->';
		printer::pclear();echo '<!--begin primary-->';
		if ($this->edit&&$this->col_options[$this->col_use_grid_index]!=='use_grid'&&(substr($this->col_flex_box,0,3)==='fle'||substr($this->col_flex_box,0,3)==='inf')){
               echo '<div class="flexstay"><!--wrap controls flexbox primary div-->';
               if ($this->flexfail)
                    $this->editoverridecss='
                    .'.$this->col_dataCss.'{display:block !important;}';
               }
          echo '<p class="lineh90 shadowoff editcolor editfont editbackground ">Primary Column</p>';
          list($padding_total,$margin_total)=$this->pad_mar_calc($this->col_style,$this->column_total_width[$this->column_level]);
		##width## @media tweak setting for primary column if margins are set then enable margin values.. margin auto will be set only when minimum width is > than the total column width!
		$this->css.='
		@media screen and (min-width:'.($margin_total+$this->current_total_width).'px){
			 .'.$this->col_dataCss.'.primary{margin-left:auto;margin-right:auto;}
			}';
		if (!$this->is_clone){
               #see below for complete description of flat filing.
               #presently primary column records (complete information) are directly obtained from the database whereas all post types (nested columns and non-nested column post types) information is only obtained directly from the database in editmode, processed then flatfiled for data retrieval in regular webpage mode for fastest rendering of webpages.
               #however here in editmode only we also flatfile primary columns as primary columns may be cloned to nested column positions on other pages as well ( enabling for robust versatility of the cloning process.).  In addition we will mimic the master_post record which we will flat file. ie. all nested columns have records in the master_post table which then link to the column record. Primary columns bypass the master_post record. All master_post record data is normally then processed and flatfiled. Here we will create a flatfile (termed post_subbed_row... ) referencing the primary column in case the primary column is ever cloned to a nested column position.
               
               ######  Additional flatfiles will be created related to the primary for the same reason..  
               
               #here we directly create the data for a subbed_post_row for a primary column. And also flatfile the primary column column data record as well.  Further down  below we will similarly deal with nested columns and regular subbed post id flatfiles..
			
               #for prime columns in case the are cloned elsewhere  as nested columns we must set up a initial post subbed row that will be used in this limited case  
               #cloned columns and posts     Below we will see that if local styling or data is enabled those respective fields will be obtained from separate flatfiles to replace only relevant  parent fields derived from the main column/post flatfiles.
			
               #here we create the column faux post_subbed_row_data flat file
			
               $post_fields=Cfg::Post_fields;
			$post_field_arr=explode(',',$post_fields);
			$value='';   
			foreach ($post_field_arr as $field) {
				$collect[$field]=''; //for post subbed row flat filing.
				}
			$collect['blog_id']=''; 
			$collect['blog_type']='nested_column';//needed in nested column position only so safe to specify
			$collect['blog_data1']=$this->col_id;
			$collect['blog_pub']=1;
			(!is_dir(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir))&&mkdir(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir,0755,1);
			(!Sys::Pass_class&&!$this->is_clone)&&file_put_contents(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'post_subbed_row_data_col_'.$this->col_id,serialize($collect));//this fits with post_subbed_row  .$subbed_row_id for columns
			#here we are similarly flat filing the primary column data in edit mode in case needed if this column is cloned as a nested column. Otherwise primary column data itself is currently obtained directly from mysql database and not from flatfile unlike nested columns.
			$collect_col_data_arr=array();//all clones will use/access the parent column flatfile as well for accessing the parent column data ie. (column_data_'.$this->col_id). Note for cloned columns:  cloned and local enabled styling and configs for clones will generate a further set of localized styles or data which is flatfiled and relevant fields obtained and substituted back in in webpage mode similarly to post type flat files previously described.
			foreach ($this->col_field_arr as $field) {
				$collect_col_data_arr[$field]=$this->$field;//for flat file webpage use.. 
				} 
			$collect_col_data_arr['col_id']=$this->col_id;//add in the col_id as well..
			#column data  
			#col data flat files the field values of individual columns directly
			file_put_contents(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'column_data_'.$this->col_id,serialize($collect_col_data_arr));
			}//!clone 
		$this->fieldmax=0;
		$border_status='begin';
		$subbed_row_id='';
		$blog_status=false;
		$blog_order='';
		$blog_unstatus=false;//
		$col_field_arr2=$this->col_field_arr;
		$col_field_arr2[]='col_id';
          #removed primary append file for cloned primary columns to secondary positions
		}//$prime and is edit
		 
	#ok we need to explode column options for the primary column	
	#Important:  for restoration of previous column values following nested column recursion  #remember column values are originally populated in previous recursion prior to their application in this round... this is because certain column values are necessary for rendering the opening nested column div tag and other functions before reaching the col_data method. Through this recursive function process variables but not class properties will retain their local scope values which makes it easy to return to previous recursive value..
	foreach ($this->col_field_arr as $field) {
		${'restore_'.$field}=$this->$field; 
		}
	${'restore_col_id'}=$this->col_id;
	
	#set some defaults
	$this->background_image_px=0;
	$this->is_blog=false;
	//col_data is the main method for directing the processing of columns...
	######### call to column #######
	#col_data #coldata
	 $this->col_data($prime);# this is column render edit call to col_data where the main column configurations and styles are set and edited in editmode. Certain values will be populated here necessary for webpage mode as well.#################
     ################
     $this->is_column=true;
	$this->previous_post='';
	$this->blog_status=false;
	
	#**********end !IMPORTANT *****positoning entire blog
		#*****BEGIN  AND RENDER POSTS AND POST styles
	$start_fields='blog_pub,blog_status,blog_clone_target,blog_target_table_base,blog_type,blog_data1,blog_data2,blog_data3,blog_id,blog_order,blog_table,blog_col,blog_table_base';
	#these start fields refer to those in editmode
	#a subset of these will be cherry picked for using in webpage mode.
	#these fields will be populated in editmode and the subset will be flatfiled for webpage mode.
	#these fields create an array of values for each post within each column. A  limited subset of values for each post is flatfiled for each nested column thereby elimating the need for mysql record access to the data. Instead a foreach statement will be used to access the id of each record and through that each flatfile record of each post will be retrieved and re-constitued in webpage mode eliminated the needed for multiple mysqli calls. 
		#But first Lets check for tagged post rendering for this column.  if tagged only posts with the same tag will be rendered regardless of page or column origin.
	if (!empty(trim($this->col_options[$this->col_tag_display_index]))){
	//tagged post values when tags set in parent column will be displayed
	//ie will select posts with tags in this column if true
		$this->tagged=true;
		$this->is_clone=$this->column_clone_status_arr[$this->column_level]=true;//set tagged posts to clone status ie no editing
		$tag=trim($this->col_options[$this->col_tag_display_index]);
		$like='';
		if (strpos($tag,' ')!==false){ 
			$tag_arr=explode(' ',$tag);
			foreach ($tag_arr as $tag){
				$tag=trim($tag);
				$like.=" || blog_tag like '%".trim($tag)."%'";
				}
			$like=substr_replace($like,'',0,3); 
			$where="where blog_status!='clone' and ($like)";  
			}
		else {
			$like='%'.trim($this->col_options[$this->col_tag_display_index]).'%';
			$where="where blog_tag like $like and blog_status!='clone'";
			}
		$tags=true;
		$q="select $start_fields from $this->master_post_table $where";  
		}
	else { 
		$this->tagged=false;
		$where="where blog_table='$tablename'";
		$q="select $start_fields from $this->master_post_table  $where  order by blog_order";
		$tags=false;
		}
	$col_identify='col_'.$this->col_id; 
	$columnArrayFile=Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'data_col_list_'.$col_identify;  
	if ($this->edit||$prime){
		$count=$this->mysqlinst->count_field($this->master_post_table,'blog_order','',false, $where);
		$this->fieldmax=$this->mysqlinst->get('fieldmax');
	
		if ($count<1) {
			if ($tags){
				if ($this->edit){//edit re check is redundant for flat file system  
					$where="where blog_table='$tablename'";
					$count=$this->mysqlinst->count_field($this->master_post_table,'blog_order','',false, $where);
					if ($count>0)
						echo '<p class="red addheight rad10 whitebackground small floatleft">Caution: Because posts tagged with "'.$this->col_options[$this->col_tag_display_index].'" were chosen in the Column Options to display here '.$count.' number of posts already made in this column but without this tag are not being displayed here.</p>';   
					}
		
				if ($this->edit)echo '<p class="red addheight rad10 whitebackground small floatleft">Currently, there are no posts tagged with any of the  words: "'.$this->col_options[$this->col_tag_display_index].'" to display here!</p>'; 
				}//end not tags
			elseif($this->edit) {//not tags
				$colmsg='Ok, Now ';
				printer::printx('<p class="editbackground editfont editcolor floatleft fs2info">'.$colmsg. ' Choose Below your First Post Type or Nested Column for your New Column from the dropdown Menu',false,'left large '.$this->column_lev_color.'</p>');
				printer::pclear();echo '<!--clear choose first-->';
				$this->blog_new($tablename.'_0',$tablename,0,'','Insert Post Top of',true);
				}
			if ($this->edit&&is_file($columnArrayFile))unlink($columnArrayFile); 
			$this->col_return=true; //table lacks posts...
			($this->edit)&&printer::pclear(1);echo '<!--clear choose first 2-->';
			if($this->edit&&$prime)
		#fieldset  switched to class
				print'</div><!--End Empty Primary Column id'.$this->col_id.'  -->';
			elseif($prime)
				print'</div><!--End Empty Div Primary Column id'.$this->col_id.'-->';
			$this->col_table==='none';
			return;
			}//end count < 0
          
		}//if this edit or prime
     
	if($this->edit||Sys::Pass_class){  
          $this->blog_new($tablename.'_0',$tablename,0,'','Insert Post Top of',true); 
		if (!$prime&&$this->flex_box_container)echo '</div><!--wrap controls flexbox-->';
          elseif($prime&&$this->col_options[$this->col_use_grid_index]!=='use_grid'&&(substr($this->col_flex_box,0,3)==='fle'||substr($this->col_flex_box,0,3)==='inf')){
               echo '</div><!--wrap controls flexbox prime col-->';
               $this->flex_enabled_arr[$this->column_level]=true;
               }
          elseif($prime){
               $this->flex_enabled_arr[$this->column_level]=false;
               }
               
          $rpost=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
		#mainwhile
		$orig_val_arr=array(); 
		$id_arr=array();
		$reset=false;
		while($mainrow=$this->mysqlinst->fetch_assoc($rpost,__LINE__)){#while
			if (!isset($_POST['submit'])&&!empty($mainrow['blog_order'])&&is_numeric($mainrow['blog_order'])&&substr($mainrow['blog_order'],-1)!=='0'){ 
				$reset=true;//  this is outdated and perhaps unnecessary all blog_order should end in a zero. check that prior  blog_tidy timing picked up all inserted new blogs which dont end in zero.  If so rerun procedure... 
				}
			$orig_val_arr[]=$mainrow;//these values accessible throughout editmode
			$id_arr[]=array('blog_id'=>$mainrow['blog_id'],'blog_order'=>$mainrow['blog_order'],'blog_pub'=>$mainrow['blog_pub'],'blog_status'=>$mainrow['blog_status']); //for flat filing data_col_list and becomes only values available as orig_vals in webpage mode, just add them in as needed..
			} //end mainwhile
		if ($reset){//repeat the process after blog_tidy
			$orig_val_arr=array(); 
			$id_arr=array();
			$this->blog_tidy($tablename);  
			$rpost2=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
			while($mainrow=$this->mysqlinst->fetch_assoc($rpost2,__LINE__)){#while 
				$orig_val_arr[]=$mainrow;//
				$id_arr[]=array('blog_id'=>$mainrow['blog_id'],'blog_order'=>$mainrow['blog_order'],'blog_pub'=>$mainrow['blog_pub']);
			#so the id_arr $columnArrayFile  flat files cherry pics critical post fields foreach post record recalled within the column and can be accessed from the flat file directly in webpage mode by the original or clones .  Notice in webpage mode how the flat file becomes the  orig_val_arr following unserialization to plug into the same foreach statement that the editmode uses. the foreach call is used to accomodate the array whether derived in editmode mysqli call or webpage mode from flatfile.
			
               ##In editmode the foreach insulates the bulk of code from the original mysqli record call..
				} //end mainwhile
			}
		
		(!is_dir(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir))&&mkdir(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir,0755,1); 
		file_put_contents($columnArrayFile,serialize($id_arr));
          //data_col_list_ here we flat file the id_arr as record to recall each flat file record  we will be flat filing on originals and
          # ** clones will also use originals directly****
          # thus allowing for when the parent column updates  the updates immediately reflect  on the  clone page as well before the clone page has a chance to update its own flatfiles!! 
		 }// if edit
	
	else {//not edit get stored serialize column query
		if (is_file($columnArrayFile)){
			#here for webpage mode  we retrieve the ordered list of posts to render...  
			$main_id_list=file_get_contents($columnArrayFile);
			if(strlen($main_id_list)>15){
				$orig_val_arr=unserialize($main_id_list);
                    #master column posting list is obtained from flatfile in webpage mode.
				}
			else $orig_val_arr=array();
			}
		else $orig_val_arr=array();
		}
	#mainstrategy...^^^^^^^^^^^^^..............^^^^^^^^^^^^^^Main Strategy Here
	#In Edit Mode
          #select basic query with limited fields for checking clone unclone basic status
          #check for clones and resub necessary limited field values in directly cloned posts or columns  posts within cloned columns will not need substitutions..
          #check for unclone.. will also be  re-subbing limited fields when a cloned column is called and has an uncloned post within
          #then with the limited fields in place whether subbed out or original for non-cloned posts then call editpages _obj  and repopulate all the fields...
          #check clones for local clone data or local clone style options and flat file results in editmode or subbout the particlar fields directly for edit mode...
          #flat file the full final field values for use in editmode
          #refinement of flat file system is further discussed below regarding cloned posts  vs. not cloned posts. Cloned posts will use clone parent flat file as it is identical. However in cases where clone local style or clone local data is enabled those particular values will later be substitued in with respective flat file created in edit mode and used in webpage mode.
	
	#In Webpage mode access the post_subbed_row data directly with no need for queries
          #If the post blog_type field is a nested column  populate the new column values... However these values are used even before calling the blog_render method which passes it's id so that the opening division tag can be rendered properly (even though the width is not directly inline anymore) and for timing in nested column restoration following recursion of nested columns.
          #recursively call method blog_render with new nested column id. Current column values are always populated in before the call to the blog_render function so that proper division values facillite timings..   
     #when the nested column method called for nested_column blog_type is finished and returns the flatfiled ${'restore_'.$field values collected prior in this method will be repopulated back and any remaining posts in the parent column are rendered..
     #both column fields and  master post fields may used for stying the column  depending on needs ie blog_float is used to set column float position in nested columns as well as in all other post types.
          #flat files incorporated to remove query calls duing non-edit use...
          #towards the end of the edit section there is full list of flat files created with general information
#populate #popclone values will be editpages_obj populated and then any values for clone will be substitued
	foreach($orig_val_arr as $orig_val){// this is now main while.. this was done for nested mysql
		$this->orig_val['blog_id']=$orig_val['blog_id']; 
		#######begin big edit  between which edit checks are reduntant 
		if ($this->edit||Sys::Pass_class){#begin big#big begin/begin big edit
			$this->orig_val=$orig_val; 
			$this->is_clone=(array_key_exists($this->column_level,$this->column_clone_status_arr)&&$this->column_clone_status_arr[$this->column_level])?true:false;
			$this->clone_local_style=false; //set default 
			$this->clone_local_data=false; //set default 
			if (isset($this->blog_moved[$orig_val['blog_id']]))continue;
			if ($orig_val['blog_type']==='nested_column'&&isset($this->nested_col_moved[$orig_val['blog_data1']]))continue;//allow for moving of column... 
			$this->background_image_px=0;//set default width for background images
			if($orig_val['blog_data2']==='post_choice'){//select new post type is requested...  
				$this->blog_id=$orig_val['blog_id'];
				$this->blog_table=$orig_val['blog_table'];
				$this->blog_order=$orig_val['blog_order'];
				$this->blog_col=$orig_val['blog_col'];
				$this->blog_order_mod=$orig_val['blog_order']/10;
				$this->blog_table_base=$orig_val['blog_table_base'];
				$this->blog_unstatus=false;
				$this->choose_post();
				continue;//post completed
				}
			$this->overlapbutton=false;//when mulitple posts with background image opacity  set the element is set to position relative and may prevent overlapping
		   #render each blog post set defaults
		   //initiating some fallbacks
			$blog_clunc_id=$blog_unstatus=$deleteclone='';//init unmirror values etc.
			$blog_id=$orig_val['blog_id'];
			$this->is_blog=true;//true for all will be reset for nested columns...
			$blog_order=$orig_val['blog_order']; 
			$blog_table_base=$orig_val['blog_table_base'];
			$blog_status=$orig_val['blog_status'];
			$blog_clone_target=$orig_val['blog_clone_target'];
			$blog_type=$orig_val['blog_type'];     
			$blog_table=$orig_val['blog_table']; //these values used for editpages_obj to retrieve all values unless subbed out prior to reaching editpages_obj 
			$this->column_clone_status_arr[$this->column_level+1]=(array_key_exists($this->column_level,$this->column_clone_status_arr)&&$this->column_clone_status_arr[$this->column_level])?true:false;// set initial then check clone status 
			#is_clone
			if ($orig_val['blog_status']==='clone'){   #clone
				#get parent post id blog_order blog_table which is used to get all parent class vars
                    $this->is_clone=true;
				if ($orig_val['blog_type'] !=='nested_column'&&!empty($orig_val['blog_clone_target'])){// blog_clone_target is the targeted cloned id for content posts
					$q="select blog_type,blog_id,blog_order, blog_table from $this->master_post_table  where blog_id='".$orig_val['blog_clone_target']."'";
					}
				else { //direct cloned nested column
					$this->post_target_clone_column_id=$orig_val['blog_clone_target'];// used for uncloning options
					$q="select blog_type,blog_id,blog_order, blog_table from $this->master_post_table  where blog_type='nested_column' and blog_status!='clone' and blog_data1='{$orig_val['blog_data1']}'"; // blog_data1 subbed in and refers to parent clone column col_id && parent  clone post blog_data1 values.
					$this->is_clone=$this->column_clone_status_arr[$this->column_level+1]=true;//child column level is now to be marked as is_clone.. remember column_level will not change till method nested_column calls the blog_render function for that upcoming col_id...
					} 
				$cl=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
				if ($this->mysqlinst->affected_rows()) {
					list ($blog_type,$blog_id,$blog_order, $blog_table)=$this->mysqlinst->fetch_row($cl,__LINE__,__method__);
					//$clone_val=$this->mysqlinst->fetch_assoc($unc,__LINE__,__method__);
					}
				else{
					if($orig_val['blog_type'] !=='nested_column'){
					   $msg="Parent Post p{$orig_val['blog_clone_target']} was deleted and its cloned post is now removed";
						printer::pclear();echo '<!--continue-->';
						printer::alert($msg); 
						$this->delete($this->master_post_table,"where blog_id=$blog_id",'message',$msg);
						continue;
						}
					else {
						$where="where col_id={$orig_val['blog_data1']}";
						$count=$this->mysqlinst->count_field($this->master_col_table,'col_id','',false, $where);
						if ($count <1){
							$msg="Parent Post p{$orig_val['blog_data1']} was deleted and its cloned post is now removed";
							printer::pclear();echo '<!--where-->';
							printer::alert($msg); 	
							$this->delete($this->master_post_table,"where blog_id=$blog_id",'message',$msg);
							} 
						}
					}
				#remember col_status or blog_status being equal to 'clone' means original post is directly clone
				#whereas for cloned columns  posts within are cloned but blog_status will not be 'clone' as they are indirectly cloned as and is_clone will be marked true
				#only directly cloned posts and columns will have the delete option available.  Indirect clones can be uncloned  or locally styled and unpublished to remove locally..
				if ($this->col_status!=='clone'){   
					$deleteclone=printer::alertx('<p class="editbackground editfont neg fs2npred floatleft" title="DELETE THIS CLONED '.strtoupper(str_replace('_',' ',$blog_type)).' AND THE PARENT WILL NOT BE AFFECTED"><input type="checkbox" name="delete_blog['.$orig_val['blog_table'].']['.$orig_val['blog_order'].']" value="delete" onchange="edit_Proc.oncheck(\'delete_blog['.$orig_val['blog_table'].']['.$orig_val['blog_order'].']\',\'THIS ENTRY WILL BE DELETED WHEN YOU HIT CHANGE, UNCHECK TO CANCEL\')" >&nbsp;Remove this Cloned '.strtoupper(str_replace('_',' ',$blog_type)).'</p>',1);						
					}//end if 
				}//end if clone and setting up initial values..
			#unclone #unmirror
			#READ IN THE UNCLONE VALUES if any checking for for is_clone property (ie posts within a cloned parent column.) then checking databases against blog_table_base = current  page and blog_unclone = blog_id which is a post within a cloned column
			#blog_unclone is the cloned post id that is being uncloned!!
			#this can further target a cloned post which if  is referred to as clone target
			#selecting blog_order and blog_table to use for editpage_obj populate values. these values will be re-selected if  is blog_status turns out to be immediately recloned!  
			if ($this->is_clone &&$orig_val['blog_status']!=='unclone'){#check for unclone in cloned nested column
				$q="select blog_type,blog_order,blog_table,blog_data1,blog_status,blog_clone_target,blog_id,blog_data2 from $this->master_post_table  where blog_unstatus='unclone' and blog_table_base='$this->pagename' and blog_unclone='$blog_id' limit 1";  
				$unc=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
				if ($this->mysqlinst->affected_rows()) {
                         $this->is_clone=false;//uncloned posts not consider cloned anymore and open for full editing unless recloned immediately which will change status
					$blog_unstatus='unclone';
					$temp_blog_id=$blog_id;
					$temp_blog_order=$blog_order;  
					$temp_table=$blog_table;
					list ($blog_type,$blog_order,$blog_table,$blog_data1,$blog_status,$blog_clone_target,$blog_id,$blog_data2)=$this->mysqlinst->fetch_row($unc,__LINE__,__method__); // the unclone data itself will be sent as it contains the relevant info!
					if($blog_data2==='post_choice'){   
						if (isset($_POST['delete_blog'][$blog_table][$blog_order])){ //removing unclone back to clone && entry updates...
							$blog_id=$temp_blog_id;
							$blog_order=$temp_blog_order;  
							$blog_table=$temp_table; //subbing back in for continuing
							$this->delete_blog($blog_table);  
							continue;
							}
						else {#assign for choose post
							$this->blog_id=$blog_id;
							$this->blog_table=$blog_table;
							$this->blog_order=$blog_order;
							$this->blog_col=$orig_val['blog_col'];
							$this->blog_order_mod=$orig_val['blog_order']/10;
							$this->blog_table_base=$this->pagename;
							$this->choose_post();
							continue;
							}
						}
					#unclones can turn around immediately clone another post or columns
					#cloneunclone  #uncclone  
					if ($blog_status==='clone'){ //Note: checking status of new subbed in values after unclone was true and checking of blog_status of new unclone...
						#two options either fix blog  clone parent table etc. query values using the id!
						if ($blog_type==='nested_column'){
							#original nested column could be uncloned! but not cloned so selected using blog_status != clone
							$unc_record=$blog_id;
							$blog_clunc_id=$blog_id;// this triggers option to delete unclone
							$q="select blog_id,blog_table, blog_order from $this->master_post_table where blog_data1='$blog_data1' and blog_status !='clone'";//make sure not to reselect unclone record  and here we getting important clone values for editpage_obj
							}
						else {
							$blog_clunc_id=$blog_id;// this triggers option to delete unclone
							$unc_record=$blog_id; //actual unclone record blog_id
							$q="select blog_id,blog_table, blog_order from $this->master_post_table where blog_id='$blog_clone_target'";
							}
						$ucc=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
						if ($this->mysqlinst->affected_rows()){
							list($blog_id,$blog_table,$blog_order)=$this->mysqlinst->fetch_row($ucc);//getting critical values for calling editpages_obj
							}
						$this->is_clone=true;
						$this->current_unclone_table[]=$unc_record;
						}
					else {
						$this->current_unclone_table[]=$blog_id;
						}
					if (isset($_POST['submit'])){  
						($blog_status!=='clone')&&$this->process_blog($blog_table,$col_id);//clone_local_style and clone_local_data will do own processing checks..
						if (isset($_POST['delete_blog'][$blog_table]))continue; 
						}
					$this->current_unclone_table[]=$blog_id; //for checking orphans if parent of unclone post is ever deleted
					}//end if affected & means unclone is true  
				} //end clones... 
			$this->blog_order_mod=$blog_order/$this->insert_full; #for data presentation 
			#For unclones which are not immediately recloned they will contain information directly...
			#Here we get main values of post to be displayed using the table and blog_order of the regular post, or clone, or uncloned post..     
			$this->editpages_obj($this->master_post_table,'blog_id,'.Cfg::Post_fields,'','blog_order',$blog_order,'blog_table',$blog_table,'populate_data');
               //class properties have  been populated with latest clone and unclone substitutions..  
			if ($this->blog_type==='nested_column'){
				if ($blog_status==='clone'&&$blog_unstatus==='unclone'&&!empty($blog_clunc_id)){
                         //using local variable checks for directly cloned and unclone
					$this->is_clone=true;//so clone is uncloned then recloned!!!    
					$this->column_clone_status_arr[$this->column_level+1]=true;
					}
				elseif ($blog_unstatus==='unclone'){// this is uncloned and not recloned
					 //using local variable checks for directly  unclone
					$this->is_clone=false; //switch off clone status
					$this->column_clone_status_arr[$this->column_level+1]=false;//child column level is now to be marked as !is_clone...
					}
				if($this->blog_data2==='column_choice'){
					$this->choose_column($this->blog_id,true); 
					continue;//next while statement
					}
				$this->col_id=$this->blog_data1; 
				$col_field_arr2=$this->col_field_arr;
				$col_field_arr2[]='col_id';
                    #Lets get column values of next go round ie nested column data we just obtained.  We can do this to prepare using these properties to properly render prior to rendering the nested column opening div tag.  
				##get column fields for nested column needed in next go round!
				#colpop #column populate   Note: this may catch primary columns cloned to nested column positions (ie they become nested columns). 
				$q='select '.Cfg::Col_fields." from $this->master_col_table where col_id='$this->blog_data1'";  
				$pp=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
				if (!$this->mysqlinst->affected_rows()){  
					printer::alert_neg('The Parent Column Id c'.$this->blog_data1.' Has Been Deleted and This Cloned Column Will No Longer Display.');
					$q="delete from $this->master_post_table where blog_data1='$this->blog_data1'";   
					$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
					continue;
					}	
				else{
					$collect_col_data_arr=array();//all clones will use the parent column target as well.  Column local style configs will be collected below and added in for webpage mode where local col css styles and configs are enbable
					$row=$this->mysqlinst->fetch_assoc($pp,__LINE__,__METHOD__); 
					foreach ($this->col_field_arr as $field) { 
						$this->$field=$row[$field];// create upcoming nested column values; these values will be further substituted for css cloning options below if initiatited...
						$collect_col_data_arr[$field]=$row[$field];//for webpage use.. 
						}
					$collect_col_data_arr['col_primary']=0;
					$collect_col_data_arr['col_id']=$this->blog_data1;
					#column data #coldata
					#col data flat files the field values of individual columns directly
					if (!$this->is_clone) file_put_contents(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'column_data_'.$this->blog_data1,serialize($collect_col_data_arr));//stores info for primary columns used as nested columns in clones of the primary col also
					}
				$this->col_primary=false;//primary has done its work. Any cloned primary now nested
				 //this will be updated with new values just before # nested_column div is rendered to file with the new values for the next round...
				}//if nested
               #localstyle  uses #blacklisting
			#Now Here we create Local Css Table post if local styling of Clones (mirrors) is selected !!  This is our only indication if clone local styling is true.  if local styling is cancelled its record is deleted  
			#Note: No Direct indication for clone_local_style otherwise exists!
			#So we select for matching record tied to this page ie this->pagename which probably be this->page not this->pagename as system setup has changed..
			$origval_id=$this->orig_val['blog_id'];
			if ($this->is_clone){ //#clonestyle 
				$this->blog_clone_target=$orig_val['blog_clone_target'];   
				$this->blog_target_table_base=$orig_val['blog_target_table_base'];
				$this->blog_status=$blog_status;  
				if 	($this->blog_type!=='nested_column'){  
					if (isset($_POST['delete_bloglocalstyle'][$origval_id])){	 
						$q="delete from $this->master_post_css_table Where blog_id='p$blog_id' and blog_orig_val_id='$origval_id' and blog_table_base='$this->pagename'";
						$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
						$this->clone_local_style=false;
                              if (is_file(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'blog_clone_local_style_'.$this->pagename.'_'.$origval_id))
                                   unlink(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'blog_clone_local_style_'.$this->pagename.'_'.$origval_id);
						}
					else{// 
						$count=$this->mysqlinst->count_field($this->master_post_css_table,'css_id','',false,"where blog_id='p$this->blog_id' and blog_orig_val_id='$origval_id' and blog_table_base='$this->pagename' and blog_table='$this->blog_table'");  
						if ($count < 1){ //check for new clone_local_style submits and if so create record  
							if (isset($_POST['submitted'])&&isset($_POST['add_bloglocalstyle'][$origval_id])&&!isset($_POST['add_bloglocaldata'][$origval_id])){ 
								$this->mysqlinst->count_field($this->master_post_css_table,'css_id','',false);
								$css_id=$this->mysqlinst->field_inc;//reuse deleted values
								$post_fields=Cfg::Post_fields;
								$post_field_arr=explode(',',$post_fields);
								$value='';  
								foreach ($post_field_arr as $field) {
									if($field==='blog_table_base')$value.="'$this->pagename',";
									elseif($field==='blog_table')$value.="'$this->blog_table',";
									else $value.="'".$this->{$field}."',";
									}
								$q="insert into $this->master_post_css_table (css_id,blog_id,blog_orig_val_id,$post_fields,blog_update,blog_time,token) values ($css_id,'p$blog_id','$origval_id',$value '".date("dMY-H-i-s")."','".time()."','".mt_rand(1,mt_getrandmax())."')";   
                                        $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);			                           $this->clone_local_style=true;
								}
							else {
                                        $this->clone_local_style=false;
                                        if (is_file(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'blog_clone_local_style_'.$this->pagename.'_'.$origval_id))
                                             unlink(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'blog_clone_local_style_'.$this->pagename.'_'.$origval_id);//file presence and is_clone status will be determination of whether to sub in these local_clone_style values after post_subbed_row_data is read in from flatfile in webpage mode
                                             }
							}
						else { //local style is true going to switch back in local values
#popclones for local clone styles							
							if (isset($_POST['submitted'])){
								$this->editpages_obj($this->master_post_css_table,Cfg::Post_fields,'clone_'.$origval_id.'_'.$this->blog_table.'_'.$blog_order.'_','blog_order',$blog_order,'blog_table',$this->blog_table,'update',"AND blog_table_base='$this->pagename'",",blog_time=".time().",token='". mt_rand(1,mt_getrandmax())."',blog_update= '".date("dMY-H-i-s")."'");
								}
                                        ##get local values from the local css record. Only the values corresponding to styles and configurations will be switched back in for each post type and depends on the post type.  Note values will NOT be directly switched in for flatfiling to the main flat file of post_subbed_row_data for webpage mode but instead a separate flat file will be created and subbed in after reading in post_subbed_row_data. This will allow for the parent of cloned posts to update the post_subbed_row_data  which creates necessary data for both the parent clone and for the part of the cloned post which is not switch in.    
								#switch
								#switch fields are the relevant style and config fields for a given post type subbed when clone local style is engaged.
								#base value refers to the common fields that relevant fields for all blog types for local clone style..  and the switch fields are addition base on the blog_types 
							$base_value='blog_id,blog_clone_table,blog_col,blog_order,blog_type,blog_table,blog_table_base,blog_date,blog_status,blog_unstatus,blog_clone_target,blog_target_table_base,blog_temp';
                                   switch ($this->blog_type){
								case  'text':
								$data_val=$base_value.',blog_text';
								break;
								case  'navigation_menu':
								$data_val=$base_value.',blog_data1';
								break;
								case  'image':
								$data_val=$base_value.',blog_data1,blog_tiny_data3,blog_tiny_data4,blog_tiny_data5,blog_tiny_data6';
								break;
								case  ',float_image_right':
								$data_val=$base_value.',blog_data1,blog_tiny_data3,blog_tiny_data4,blog_tiny_data5,blog_tiny_data6';
								break;
								case  'float_image_left':
								$data_val=$base_value.',blog_data1,blog_tiny_data3,blog_tiny_data4,blog_tiny_data5,blog_tiny_data6'; 
								break; 
								case  'contact':
								$data_val=$base_value.',blog_data1';
								break;
								case  'social_icons':
								$data_val=$base_value.',blog_data1';
								break;
								case 'gallery':
								$data_val=$base_value.',blog_data1,blog_data7,blog_tiny_data4,blog_tiny_data5';
								break;
								case 'auto_slide':
								$data_val=$base_value.',blog_data1';
								break;
								case 'video':
								$data_val=$base_value.',blog_data1,blog_data2,blog_data3,blog_data4,blog_tiny_data1';
								break;
								default:
								$data_val=$base_value;
								} 
                                   $black_arr=explode(',',$data_val);
                                   $style_list='';
                                   foreach(explode(',',Cfg::Post_fields) as $list){
                                        if (!in_array($list,$black_arr)){
                                             $style_list.=$list.',';
                                             }
                                        }
                                   $style_list=substr_replace($style_list,'',-1);
                                   $q="select $style_list from $this->master_post_css_table where blog_table_base='$this->pagename' and blog_orig_val_id='$origval_id' and blog_id='p$blog_id' and blog_table='$this->blog_table' limit 1";  
							//$true_order=$this->blog_order; 
							$lc=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
							$css_row=$this->mysqlinst->fetch_assoc($lc,__LINE__);
							$css_local_arr=array();
							foreach(explode(',',$style_list) as $cfield){
								$this->{$cfield}=$css_row[$cfield];#direct edit mode substition
								$css_local_arr[$cfield]=$css_row[$cfield];#Note values will NOT be directly switched in for flatfiling to the main flat file of post_subbed_row_data for webpage mode but instead  blog_clone_local_style_'.$this->pagename.'_'.$this->blog_id flat file will be created and subbed in after reading in post_subbed_row_data. This will allow for the parent of cloned posts to update the post_subbed_row_data  which creates necessary data for both the parent clone and for the part of the cloned post which is not switch in. 
								}
							(!Sys::Pass_class)&&file_put_contents(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'blog_clone_local_style_'.$this->pagename.'_'.$origval_id,serialize($css_local_arr));#these will be resubstitued in editmode for clone local styles
							$this->clone_local_style=true;//enable clone styling and configuration options
                                  }//count > 0
                              }//not deleted clone local style
                         #localdata  #clonedata
					if (isset($_POST['delete_bloglocaldata'][$origval_id])){	 
						$q="delete from $this->master_post_data_table Where blog_id='p$blog_id' and blog_orig_val_id='$origval_id' and blog_table_base='$this->pagename'";
						$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
						$this->clone_local_data=false;
                              if (is_file(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'blog_clone_local_data_'.$this->pagename.'_'.$origval_id))
                                   unlink(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'blog_clone_local_data_'.$this->pagename.'_'.$origval_id);
						}
					else{//check for cloned data local
						#now do similar for local data setting by checking if local data record exists for this column.  remember there is no direct link to this page for posts within a cloned column other than the parent column or ancestor column being directly cloned.. otherwise could be a directly cloned post and either way a record is created for the local linking
						$count=$this->mysqlinst->count_field($this->master_post_data_table,'data_id','',false," where blog_id='p$this->blog_id' and blog_orig_val_id='$origval_id' and blog_table_base='$this->pagename'"); 
						if ($count < 1){  
							if (isset($_POST['submitted'])&&isset($_POST['add_bloglocaldata'][$origval_id])){
								$this->mysqlinst->count_field($this->master_post_data_table,'data_id','',false);
								$data_id=$this->mysqlinst->field_inc;//reuse deleted values
								$post_fields=Cfg::Post_fields;
								$post_field_arr=explode(',',$post_fields);
								$value='';  
								foreach ($post_field_arr as $field) {
									if($field==='blog_table_base')$value.="'$this->pagename',";
									elseif($field==='blog_table')$value.="'$this->blog_table',";//not necessary as no change actually being made compared to default substitution
									elseif ($field==='blog_data1'){
										if ($this->blog_type==='gallery')$value.="'',";//appears not necessary as this field will not be used anyway
										else $value.="'".$this->{$field}."',";
										}
									else $value.="'".$this->{$field}."',";
									}
								$q="insert into $this->master_post_data_table   (data_id,blog_id,blog_orig_val_id,$post_fields,blog_update,blog_time,token) values ($data_id,'p$this->blog_id','$origval_id',$value '".date("dMY-H-i-s")."','".time()."','".mt_rand(1,mt_getrandmax())."')";   
								$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);			 
								$this->clone_local_data=true;
								$count=1;
								}
							else {
                                        $this->clone_local_data=false;
                                        if (is_file(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'blog_clone_local_data_'.$this->pagename.'_'.$origval_id))
                                            unlink(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'blog_clone_local_data_'.$this->pagename.'_'.$origval_id);//file presence and is_clone status will be determination of whether to sub in these local_clone_data values after post_subbed_row_data is read in from flatfile in webpage mode
                                        }
							}
						else {
                                  
                                   if (isset($_POST['submitted'])){
								$this->editpages_obj($this->master_post_data_table,Cfg::Post_fields,'localdata_'.$this->orig_val['blog_id'].'_'.$this->blog_table.'_'.$blog_order.'_','blog_order',$blog_order,'blog_table',$this->blog_table,'update'," and blog_id='p$this->blog_id'  and blog_orig_val_id='$origval_id' AND blog_table_base='$this->pagename'",",blog_time=".time().",token='". mt_rand(1,mt_getrandmax())."',blog_update= '".date("dMY-H-i-s")."'");
								}
							}
						if ($count>0){//we accounted for new data record being inserted	
								#switch fields are the relevant data fields for a given post type subbed when clone local data is engaged.
                                   $base_value='';//
							switch ($this->blog_type){
								case  'text':
								$data_val=$base_value.'blog_text';
								break;
								case  'navigation_menu':
								$data_val=$base_value.'blog_data1';
								break;
								case  'image':
								$data_val=$base_value.'blog_data1,blog_tiny_data3,blog_tiny_data4,blog_tiny_data5,blog_tiny_data6';
								break;
								case  'float_image_right':
								$data_val=$base_value.'blog_data1,blog_tiny_data3,blog_tiny_data4,blog_tiny_data5,blog_tiny_data6';
								break;
								case  'float_image_left': 
								$data_val=$base_value.'blog_data1,blog_tiny_data3,blog_tiny_data4,blog_tiny_data5,blog_tiny_data6';
								break; 
								case  'contact':
								$data_val=$base_value.'blog_data1';
								break;
								case  'social_icons':
								$data_val=$base_value.'blog_data1';
								break;
								case 'gallery':
								$data_val=$base_value.'blog_data1,blog_data7,blog_tiny_data4,blog_tiny_data5';
								break;
								case 'auto_slide':
								$data_val=$base_value.'blog_data1';
								break;
								case 'video':
								$data_val=$base_value.'blog_data1,blog_data2,blog_data3,blog_data4,blog_tiny_data1';
								break;
								default:
								$data_val=$base_value;
								}
							if ($this->blog_type==='image'||$this->blog_type==='video'||$this->blog_type==='social_icons'||$this->blog_type==='auto_slide'||$this->blog_type==='text'||$this->blog_type==='gallery'){//only these are presently configured
								$q="select $data_val from $this->master_post_data_table where blog_table_base='$this->pagename' and blog_orig_val_id='$origval_id' and blog_id='p$blog_id' limit 1";  //sub out if present
								#popclone #populate local data here we do this differently with clone local data
								#we are going to use the parent post_subbed_row_data for webpage mode then subbout the local fields when in local mode..   Here we will create the necessary array to be called in local data posts in webpage mode..
								#we are doing it this way because if the parent is changed, say a style is changed then unless each page containing a clone with local data enabled is refreshed in editmode the  local flat file will not be recreated to reflect this..!!
								$true_order=$this->blog_order;
								$lc=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
								$data_row=$this->mysqlinst->fetch_assoc($lc,__LINE__);
								#make direct sub for editmode use 
								foreach(explode(',',$data_val) as $dfield){
									$this->{$dfield}=$data_row[$dfield];//for editmode substitution
									$local_data_arr[$dfield]=$data_row[$dfield];//used for local data sub in webpage mode
									}
                                        
								(!Sys::Pass_class)&&file_put_contents(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'blog_clone_local_data_'.$this->pagename.'_'.$origval_id,serialize($local_data_arr)); 
								$this->clone_local_data=true;
								}//end is enabled blog_type ie text gallery
							
							}//count > 0
							
						}//not deleted clone local data
					}//if ! nested column
					
				#localclonecol  #clonelocalcol #colclone  
				else{//is nested column
					$col_fields=Cfg::Col_fields;  
					if (isset($_POST['delete_collocalstyle'][$this->blog_data1])){
						$q="delete from $this->master_col_css_table Where col_id='c$this->blog_data1' and col_table_base='$this->pagename'";
						$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
						$this->clone_local_style=false;
                              if (is_file(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'column_css_clone_'.$this->pagename.'_'.$this->blog_data1))
                                   unlink(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'column_css_clone_'.$this->pagename.'_'.$this->blog_data1);
						}
					else {  
						($blog_status==='clone')&&$this->parent_col_clone=$this->blog_data1;//for providing information
						$count=$this->mysqlinst->count_field($this->master_col_css_table,'css_id','',false,"where col_id='c$this->blog_data1' and col_table_base='$this->pagename'"); 
						if ($count < 1){// local column style/config is enabled
							if (isset($_POST['submitted'])&&isset($_POST['add_collocalstyle'][$this->blog_data1])){//create new column css local style record
								$q="select $col_fields from $this->master_col_table where col_id='$this->blog_data1'"; //get parent values 
								$ins=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
								$col_rows=$this->mysqlinst->fetch_assoc($ins,__LINE__);
								$this->mysqlinst->count_field($this->master_col_css_table,'css_id','',false);
								$value=''; 
								$css_id=$this->mysqlinst->field_inc;
								foreach ($this->col_field_arr as $field) {
									if($field==='col_table_base')$value.="'$this->pagename',";
									elseif($field==='col_table')$value.="'$this->col_table',";
									else $value.="'".$col_rows[$field]."',";
									}
								$q="insert into $this->master_col_css_table   (css_id,col_id,$col_fields,col_update,col_time,token) values ($css_id,'c$this->blog_data1',$value '".date("dMY-H-i-s")."','".time()."','".mt_rand(1,mt_getrandmax())."')";   
								$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true); 
								$this->clone_local_style=true;
								if (is_file(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'column_css_clone_'.$this->pagename.'_'.$this->blog_data1))unlink(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'column_css_clone_'.$this->pagename.'_'.$this->blog_data1);
								}//submitted
							else {//no col clone css record exists
                                        $this->clone_local_style=false;
                                        if (is_file(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'column_css_clone_'.$this->pagename.'_'.$this->blog_data1))
                                             unlink(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'column_css_clone_'.$this->pagename.'_'.$this->blog_data1);//remove file
                                        }
							}
						else {//count >1 col css style local
                                   //in each editpage round we will regenerate the file regardless of submit condition in case file is deleted...
                                   //Here no switch selection is necessary as all values can be switched out and flatfiled from the local column css record and there is no data to worry about parent column changes...
							$q="select $col_fields from $this->master_col_css_table where col_table_base='$this->pagename' and col_id='c$this->blog_data1'"; 
							$lc=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
							$col_css_row=$this->mysqlinst->fetch_assoc($lc,__LINE__);
							$col_local_clone_collect_arr=array();
							foreach($this->col_field_arr as $cfield){//here we select and replace all replacable values in local column enabled cloned columns
								$col_local_clone_collect_arr[$cfield]=$col_css_row[$cfield];
								$this->$cfield=$col_css_row[$cfield];
								}
							$this->col_table_base=$col_table_base;//correct value for next nested column go round
							$this->clone_local_style=true;
							$cssfile=Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'column_css_clone_'.$this->pagename.'_'.$this->blog_data1;
							file_put_contents($cssfile,serialize($col_local_clone_collect_arr)); 
							} //style count	  
						}//not delete
					}//nested column cloned
				}//end is_cloned section checking for  local styles and local data
			 // begin setup flat file including ! blog pub
			//setting up some style arrays used in editmode only
			$stylecount=count(explode(',',Cfg::Style_functions));
			$styles=explode(',',$this->blog_style);
			for ($i=0; $i<count(explode(',',Cfg::Style_functions));$i++){
				(!array_key_exists($i,$styles))&&$styles[$i]='';
				}
			$this->current_background_color= (preg_match(Cfg::Preg_color,explode('@@',$styles[$this->background_index])[0]))?explode('@@',$styles[$this->background_index])[0]:$this->current_background_color;
			$this->current_color= (preg_match(Cfg::Preg_color,$styles[$this->font_color_index]))?$styles[$this->font_color_index]:$this->current_color;
			$this->current_font_px=(!empty($styles[$this->font_size_index])&&$styles[$this->font_size_index]>=.5&&$styles[$this->font_size_index]<=4.5)?$styles[$this->font_size_index]*16:((array_key_exists($this->column_level,$this->column_font_px_arr))?$this->column_font_px_arr[$this->column_level]:16);
		#subbed row id
		     #clone cols posts will not make new subbed row data
               $subbed_row_id=($this->blog_type==='nested_column')?'col_'.$this->blog_data1:$this->blog_id;
               #subbed_row_id will be used for retrieving the final post_subbed_row_data for every post record stored in flatfiles and used directly for retrieving append 		  
               #once again flatfiling to save non edit page queries
               #collecting important miscellaneous values for the current blog post both variables and class properties.. for flatfiling in editmode for use in webpage mode
			#remove if edit
			 if(!Sys::Pass_class&&!$this->is_clone){ 
			#we will access the parent post_subbed_data_row directly and sub in case of local data or local style!
                    $collect=array();
                    $post_fields=Cfg::Post_fields;
                    $post_field_arr=explode(',',$post_fields);
                    $value='';
                    foreach ($post_field_arr as $field) {
                         $collect[$field]=$this->$field; //for post subbed row...
                         }
                    $collect['blog_id']=$this->blog_id;
                     file_put_contents(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'post_subbed_row_data_'.$subbed_row_id,serialize($collect));#ok here if  cloned and not clone local style use parent page flat file version of this particular blog post so do not flat file.  The big advantage here is that all clones are immediately updated when the parent column updates since it will use the same flat file and config changes..  styles will be taken from the parent stylesheet ..
                    } 
               $append_arr=array();
			$append_arr['obj']=$append_arr['var']=array();
              #the following values contain important misc info including is_clone and clone_local_data and clone local style info which will be used for retrieving is_clone,clone_local_style,clone_local_data flatfiles  and subbed_row_id value for retrieving post_subbed_row flat file
              #passthruarray
			$objvars=explode(',','rwd_post,blog_float,blog_table,column_lev_color,blog_border_stop,col_num,blog_order,blog_order_mod,fieldmax,is_clone,clone_local_style,clone_local_data,clone_ext,is_masonry,flex_box_container,flex_enabled_twice,current_font_em_px,current_font_em,terminal_font_em_px,terminal_px_scale,terminal_em_scale,terminal_rem_scale,font_scale,rem_scale,current_em_scale');
               foreach ($objvars as $ov){ 
				$append_arr['obj'][$ov]=$this->$ov;
				}
			$vars=explode(',','blog_order,tablename,blog_status,blog_unstatus,subbed_row_id'); 
			foreach ($vars as $v){
				$append_arr['var'][$v]=$$v;
				}  
               (!is_dir(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir))&&mkdir(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir,0755,1);
                if($this->blog_unstatus!=='unclone'&&!$this->is_clone){
				$appfile=$orig_val['blog_id'];// same as this->blog_id
                    file_put_contents(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'post_append_data_'.$appfile,serialize($append_arr));//this is done so initial clones can access original
				}
			$appfile=$this->pagename.'_'.$orig_val['blog_id'];
			file_put_contents(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'post_append_data_'.$appfile,serialize($append_arr));
				//contigency plan for a situation where a  post or column in a template/cloned column has been added on the parent column adding a new clone and the page where clone is expressed hasn't been updated in edit mode...
			if ($this->blog_table_base!==$this->pagename&&!$this->clone_local_style){ 
				$this->page_stylesheet_inc[]=$this->blog_table_base; 
				}//this is used to include stylesheets of cloned posts 
               #clones will not make new post subbed row data
               #flatfile info #flat file info
			#the following flat files are generated in editmode for use in webpage mode
			#data_col_list_  (see columnArrayFile)  is array of post id's within a particlar column.. this is the main flatfile used above in the main foreach call to render each post within a column above at the start of this function.
			#column_data flat file of field values of particlar columns...
			#post_append_data: the primary key (based on $orig_val['blog_id']) to contain  initial data in order to access the correct post_subbed_row_data which itself contains all the original stored record fields from editmode for a particular post.  Post_append_data also contains all other necessary variables   generated in the editmode such as is_clone see  $append_arr. 
			#post_subbed_row_data contains main records for each blog post.  Importantly, cloned posts access the parent post version of post_subbed_row_data directly so changes made in the parent post can appear directly and when cloned posts have local styling or data changes made these values  held in a local flatfile will be subbed in.  
			#un_clone_master_arr: records the $orig_val['blog_id'] and reference to the correct append_data record with which the unclone data may further populate values using the appned data and post subbed data records for this post.  Unlike clone flatfiles, the unclone flatfile post sub data contains the full record necessary and no parent data needs to be substituted into.  
			#Note $this->blog_id=$orig_val['blog_id'] for posts which are not cloned or uncloned..
			#blog_clone_local_data_  page specific flat files local clone data for population in webpage mode to replace parent clone values for data fields
			#blog_clone_local_style_  page specific flat files local clone style fields for population in webpage mode  replace parent clone values for style and config fields 
			$uncFile=Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'un_clone_master_arr';
			if (!is_file($uncFile)) 
				$unc_file_arr=array();
			else $unc_file_arr=unserialize(file_get_contents($uncFile));
			if ($blog_unstatus==='unclone'){	 	
				$unc_file_arr[$this->pagename.'_'.$orig_val['blog_id']]=$orig_val['blog_id']; 
				}
			else if (array_key_exists($this->pagename.'_'.$orig_val['blog_id'],$unc_file_arr)){
				unset($unc_file_arr[$this->pagename.'_'.$orig_val['blog_id']]);//update
				} 
			file_put_contents($uncFile,serialize($unc_file_arr));
			}//end Big edit || pass_class
			#big
		else {//! big edit   not edit begin
               //leaving edit mode  and restoring data using flat files..  post_append_data includes info also necessary to direct the retreiving of other flat files 
			$this->is_blog=true;//will be reset if nested column in col_data
			$uncFile=Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'un_clone_master_arr';
               if(!is_file($uncFile))file_put_contents($uncFile,serialize(array()));//initialize
               $append_rescue=false;//this is outdated 
               $unc_file_arr=unserialize(file_get_contents($uncFile));
               $appfile='appendfile';
               if (array_key_exists($this->pagename.'_'.$orig_val['blog_id'],$unc_file_arr)){ 
                    $unc_id=$unc_file_arr[$this->pagename.'_'.$orig_val['blog_id']];
                    $appfile=Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'post_append_data_'.$this->pagename.'_'.$unc_id;  
                    if (is_file($appfile)){ //choose the local if cloned first otherwise choose the parent data...
                         $append_arr=unserialize(file_get_contents($appfile));
                         }
                    else {
                         mail::alert('unclone error '.__LINE__.' with orig val blog_id: '.$orig_val["blog_id"]);
                         continue;
                         }
                    }
               elseif (is_file(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'post_append_data_'.$this->pagename.'_'.$orig_val['blog_id'])){  
                    $append_arr=unserialize(file_get_contents(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'post_append_data_'.$this->pagename.'_'.$orig_val['blog_id']));
                    }
               elseif (is_file(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'post_append_data_'.$orig_val['blog_id'])){
                    $append_arr=unserialize(file_get_contents(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'post_append_data_'.$orig_val['blog_id']));
                    }
               else {//arriving here should be outdated..   if file not found above send message
                    $this->blog_tidy($this->blog_table);//in case two posts sharing same blog_order...  refresh page and see if it fixes situation.
                   // mail::alert('refresh page for retry. A file not found '.$appfile);
                    continue;
                    }
			foreach ($append_arr['obj'] as $key => $ov){  
				$this->$key=$append_arr['obj'][$key];    ;
				}
			foreach ($append_arr['var'] as $key =>$v){
				$$key=$append_arr['var'][$key];
				} 
			if ($append_rescue){//this is now outdated and unnecesary 
				$this->is_clone=true;  
				$this->clone_local_data=$this->clone_local_style=false;
				}
              #sub in main blog fields..  below this any local clone or data fields will be subbed in
               if (!Sys::Pass_class&&is_file(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'post_subbed_row_data_'.$subbed_row_id)){ 
				$collect_arr=file_get_contents(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'post_subbed_row_data_'.$subbed_row_id);//from appended data
				$collect=unserialize($collect_arr);
                    
				$post_fields=Cfg::Post_fields;
				$post_field_arr=explode(',',$post_fields);
				$value=''; 
				foreach ($post_field_arr as $field){ 
					$this->$field=$collect[$field];  //populate blog row fields retrieved from flat file
                        }
				$this->blog_id=$collect['blog_id'];
				}//
			else if (!Sys::Pass_class){
				mail::alert('flat file '.Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'post_subbed_row_data_'.$subbed_row_id.' not found line '.__LINE__);
				return;
				}   
			}//end if not edit
         if (!$this->edit&&!Sys::Pass_class&&$this->is_clone&&$this->clone_local_data){//now for local clone data if true we retrieve flatfile the relevant localclonedata fields...
		 	$data_arr=array();
               #now subbed in any local clone values if present..
               $bcld=Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'blog_clone_local_data_'.$this->pagename.'_'.$this->orig_val['blog_id'];
			if (is_file($bcld)){ 
				$data_value=unserialize(file_get_contents($bcld));
				foreach($data_value as $index => $field){
					$this->$index=$data_value[$index];
                         }
				}
			else {
				mail::alert('flat file '.$bcld.' not found line '.__LINE__);
				return;
				}
			}//if clone local data
          if ($this->blog_type==='nested_column'){//here we reset for sake of !edit
			$this->is_column=true;
			$this->is_blog=false;
			}
		else {
			$this->is_column=false;
			$this->is_blog=true;
			} 
		if (!$this->edit&&!Sys::Pass_class&&$this->is_clone&&$this->clone_local_style&&$this->blog_type!=='nested_column'){//now for local clone style if true we must retrieve flatfile for the relevant localclonestyle fields... 
			$style_arr=array();
			if (is_file(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'blog_clone_local_style_'.$this->pagename.'_'.$this->orig_val['blog_id'])){
				$style_value=unserialize(file_get_contents(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'blog_clone_local_style_'.$this->pagename.'_'.$this->orig_val['blog_id']));
				foreach($style_value as $index => $field){
					$this->$index=$style_value[$index];
					}
				}
			else {
				mail::alert('flat file '.Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'blog_clone_local_style_'.$this->pagename.'_'.$this->orig_val['blog_id'].' not found line '.__LINE__);
				return;
				} 
			}//if clone local style
          ##if post is an original post clone substitute then reestablish original blog order for proper adding of new blog post. otherwise the cloned blog order will give incorrect value.
          if(!$this->edit&&!$this->blog_pub&&!isset($_GET['showallunpub'])&&!Sys::Pass_class){
			continue;//main foreach
			} 
		if(!$this->edit&&!Sys::Pass_class&&$this->blog_type==='nested_column'){ //!edit  for sake of flat filing and avoiding queries.. 
			$col_par_masonry=$this->is_masonry;//value of col_masonry whether prev col was enabled
			#north
			$file2=Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'column_data_'.$this->blog_data1;
			 if (is_file($file2))$file=$file2; 
			else continue;
			$col_collect=file_get_contents($file);  
			$collect=unserialize($col_collect); 
               $col_field_arr2=$this->col_field_arr;
               $col_field_arr2[]='col_id'; 
			foreach ($col_field_arr2 as $field){
				// create upcoming nested column values; these values will be further substituted for css cloning options below if initiated...
				$this->$field=$collect[$field];//store parent column values for return replacement of parent values following each nested column iteration...
				}
			if ($this->is_clone&&is_file(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'column_css_clone_'.$this->pagename.'_'.$this->blog_data1)){ 
				$col_local_clone_collect_arr=unserialize(file_get_contents(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'column_css_clone_'.$this->pagename.'_'.$this->blog_data1));
				foreach ($this->col_field_arr as $field){  
					// create upcoming nested column values; these values will be further substituted for css cloning options below if initiated...
					$this->$field=$col_local_clone_collect_arr[$field];//store parent column values for return replacement of parent values following each nested column iteration... 
					} 
				}
			}//nested column
		else $col_par_masonry='';
		if ($this->blog_type==='nested_column'){ 
			$this->col_options=(!is_array($this->col_options))?explode(',',$this->col_options):$this->col_options;//populate column options from locally cloned value
			for ($i=0;$i <count(explode(',',Cfg::Column_options)); $i++){
				if (!array_key_exists($i,$this->col_options))$this->col_options[$i]=0; 
				} 
			}//if nested column...
		$this->clone_ext=($this->is_clone&&$this->clone_local_style)?'clone_':'';//for all post types in edit mode & non edit mode
          $this->clone_name_ext=($this->is_clone&&$this->clone_local_style)?'clone_'.$this->orig_val['blog_id'].'_':'';//for all post types in edit mode & non edit mode
           #setup default $this->pelement which will be overridden in edit_styles_close but useful for other css being styled using spacing function width functions etc....
		#pelement for primary columns will be set up @ top of this function  for primary and reset in nested_column function for nested_columns following recursion
		#params #setup params
		$this->data_ext=($this->is_clone&&$this->clone_local_data&&!$this->clone_local_style)?'localdata_'.$this->orig_val['blog_id'].'_':'';//for all post types in edit mode & non edit mode
		$this->data=$data=$this->clone_name_ext.$this->data_ext.$this->blog_table.'_'.$blog_order;//form  name fields for both nested column and blog
          if($this->blog_type==='nested_column'){  
               $this->col_dataCss=$this->clone_ext.$this->col_table_base.'_col_'.$this->col_id;
               $this->pelement=".$this->col_dataCss.'nested_column";//set for nested column types
               
               }
          else { 
               $this->dataCss=$this->clone_ext.$this->blog_table_base.'_postId_'.$this->blog_id;//this id is to form immutable css for
               $this->pelement=".$this->dataCss.$this->blog_type"; 
               $this->sibling_id_arr['p'.$this->blog_id]=$this->dataCss;//keeps track for animation 
               }
          if ($orig_val['blog_status']==='clone')$blog_order=$this->blog_order=$orig_val['blog_order']; $this->blog_order_mod=$blog_order/10;#timing is important here...
          #here we are rendering from flat files if !edit..
          #column_level
          #if is_column then column level still one above (lower in number)
          $this->flex_box_container=false;//init value
          if ($this->blog_type==='nested_column'&&$this->col_options[$this->col_use_grid_index]!=='use_grid'&&(substr($this->col_flex_box,0,3)==='fle'||substr($this->col_flex_box,0,3)==='inf')){
               $this->flex_enabled_arr[$this->column_level+1]=true; 
               $this->flex_box_container=true;
               $flexcontainerdisplay=(substr($this->col_flex_box,0,3)==='fle')?'flex':'inline-flex';
               $inlinecontainerdisplay='inline-block';//because flex-block acts like inline-block when col parent is flex..
                #flexfail=true;set up in global_master properties #currently flex not working for edit display mode due to hidden settings elements failure when clicked, ie. being obscured behind neighboring posts due to flexbox having its own stacking order (even in position static mode) and affecting the javascript positioning absolute with dominant z-index to show more in show_more functions when clicked
              }
          elseif ($this->blog_type==='nested_column'){
               $this->flex_enabled_arr[$this->column_level+1]=false;
               }
          //for all:
          if ($this->edit){
               $c=0;
               for ($i=0;$i<$this->column_level+1;$i++){//includes nested and blog posts set flex enabled to turn off maxwidth and rwd grid tracker due to ambiguity of flex box width calculator..
                    if ($this->flex_enabled_arr[$i])$c++;
                    if ($c>1){
                         $this->flex_enabled_twice=true;
                         break;
                         }
                    $this->flex_enabled_twice=false;
                    }
               }
          #floatstyle
		if(($this->blog_type==='nested_column'&&$this->column_use_grid_array[$this->column_level]==='use_grid')||($this->blog_type!=='nested_column'&&$this->col_options[$this->col_use_grid_index]==='use_grid')){ //column_level has not rounded the corner hence not column_level-1
			$show_new_blog=false;//modifies new blog choice positioning
			$this->rwd_post=true;
               $this->flex_box_item=false;  
			}
		elseif (($this->blog_type==='nested_column'&&$this->column_use_flex_array[$this->column_level])|| $this->blog_type!=='nested_column'&&(substr($this->col_flex_box,0,3)==='fle'||substr($this->col_flex_box,0,3)==='inf')){
               $floating=true;
			$floatstyle='';
			$this->rwd_post=false;
               $this->flex_box_item=true;
			$this->display_edit_data='inline-block'; 
               }
		else {
			$floatstyle='';   
			$this->rwd_post=false;
			$floating=false;
               $this->flex_box_item=false; 
			//floating when true sets up float condition for add new post before   post </div close so as not to break float
			#masonryfloat
			if(!$this->is_column&&$this->is_masonry||$this->column_masonry_status_arr[$this->column_level]
){//float adjust too...
				$this->display_edit_data='inline-block'; 
				$floatstyle='display:inline-block;';// center floating by default...
				$floating=true;//clear float checks same parameters so will use value for floating
				}
			if (!$floating){
                    //printer::pclear();echo '<!--clear border float-->';
                    }
			}//not rwd
         //here we control whether blogs share space within the row of a column width permitting...  this is for non-rwd posts..   show new blogs are controlled so as not to break floating or inline-block shares... by putting them within the post division instead of following...
			#mainfloat
		if (!$this->flex_box_item){
               if (empty($this->blog_float)||$this->blog_float==$this->position_arr[0])://center row 
                    printer::pclear();
                    $floatstyle='margin-left:auto;margin-right:auto;';//default..
                     $floating=false;
                    $this->display_edit_data='block';
               elseif ($this->blog_float===$this->position_arr[1])://float center
                    $this->display_edit_data='inline-block'; 
                    $floatstyle='display:inline-block;';// center floating by default...
                    $floating=true;
               elseif ($this->blog_float===$this->position_arr[2])://float left
                    $floatstyle='float:left;';
                    
                    $floating=true;//clear float checks same parameters so will use value for floating
                    $this->display_edit_data='inline-block';
               elseif ($this->blog_float===$this->position_arr[3])://float right
                    $floatstyle='float: right;';//this sets up float for local...
                   
                    $floating=true;//clear float checks same parameters so will use value for floating
                    $this->display_edit_data='inline-block';
               elseif ($this->blog_float===$this->position_arr[4])://float left no next
                    $floatstyle='float: left;';//this sets up float for local...
                    $floating=false;//clear float checks same parameters so will use value for floating
                    $this->display_edit_data='inline-block';
               elseif ($this->blog_float===$this->position_arr[5])://float right no next
                    $floatstyle='float: right;';//this sets up float for local...
                    
                    $floating=false;//clear float checks same parameters so will use value for floating
                    $this->display_edit_data='inline-block';
               elseif ($this->blog_float===$this->position_arr[6])://float center no next
                    $floating=false;//clear float checks same parameters so will use value for floating
                   $this->display_edit_data='inline-table'; 	   
                    $floatstyle='display:inline-table; ';//this sets up float for local...margin-left:auto;margin-right:auto;
                   
                    
               else:
                    
                    if ($this->rwd_post){
                         $floatstyle='float:left;';
                         
                         $floating=true;//clear float checks same parameters so will use value for floating
                        }
                    else {
                         printer::pclear();
                         $this->display_edit_data='block';
                         $floatstyle='margin-left:auto;margin-right:auto;';
                         $floating=false;
                         }
               endif;
               }
          //if flex-container is true use display:flex in editpages still a problem not used
           if($this->edit&&$this->is_column&&$this->flex_box_container){
               if ($this->flexfail)$this->display_edit_data=$inlinecontainerdisplay;
               else {
                    $this->display_edit_data='';
                    #position & z-index attempts in styling editoverride css failed @ overriding innate flex z-index see flexfail set value note above...
                    //$this->editoverridecss.="\n.$this->col_dataCss{flex-wrap:wrap;flex-direction:row;justify-content:flex-start;align-items:flex-start;align-content:flex-start;z-index:0;}";
                 }
              
               }
               
          (!empty($floatstyle)&&$this->blog_type!=='nested_column')&& $this->css.="\n.$this->dataCss{".$floatstyle.'}'; 
          ($this->is_blog)&&$this->css.
         $this->pic_ext='_blog_pic';#extension for data to refer to pics .
		  $width='';   
		if(!empty($this->blog_border_start)){  
			 (isset($this->groupstyle_begin_col_id_arr[$this->col_id])&&isset($this->groupstyle_begin_blog_id_arr[$this->col_id]))&&printer::alertx('<p class="floatleft warn1">Caution need closing groupstyle for post Id '.$this->groupstyle_begin_blog_id_arr[$this->col_id]. " within this parent Column id $this->col_id before opening another</p>");
			printer::pclear();echo '<!--clear caution group border-->';
			$this->groupstyle_begin_blog_id_arr[$this->col_id]=$this->blog_id;
			$this->groupstyle_begin_col_id_arr[$this->col_id]=true;
			print('<fieldset class="style_groupstyle"'.$width.'><legend></legend><!-- begin Group Style Border-->');// begin the border
			}
          if (empty($this->blog_options)){ 
               $this->blog_options=array();
               for ($i=0; $i<count(explode(',',Cfg::Blog_options));$i++){ 
				$this->blog_options[$i]=0;
				}
			}
		else {   
			$this->blog_options=explode(',',$this->blog_options);
			for ($i=0; $i<count(explode(',',Cfg::Blog_options));$i++){ 
				if (!array_key_exists($i,$this->blog_options)){
					$this->blog_options[$i]=0;
					} 
				}
			}
          
           if (empty($this->blog_width_mode)){ 
               $this->blog_width_mode=array();
               for ($i=0; $i<count(explode(',',Cfg::Main_width_options));$i++){ 
				$this->blog_width_mode[$i]='';
				}
			}
		else {   
			$this->blog_width_mode=explode(',',$this->blog_width_mode);
			for ($i=0; $i<count(explode(',',Cfg::Main_width_options));$i++){ 
				if (!array_key_exists($i,$this->blog_width_mode)){
					$this->blog_width_mode[$i]='';
					} 
				}
			}
		if($this->blog_data2!=='column_choice'||$this->blog_type!=='nested_column')$this->total_float();//this does take nested columns...
		else $this->current_net_width_percent=100; //else   applies only to nested columns undergoing column_choice 
          if ($this->edit&&$this->current_net_width <150){//make viewable
               $setwid=$this->current_total_width;
			$this->current_net_width=400;  
			$this->current_net_width_percent=100;
			$show_more_on=true;//signal to close out show_more following render
			}
		else $show_more_on=false;
          if($this->edit&&$this->blog_type==='nested_column'){
               if($show_more_on){
                    $idl="c$this->col_id";
                    echo '<div id="'.$idl.'" style="'.$floatstyle.' width:'.$setwid.'px;">';//create anchor before show_more statement
                    $this->show_more('Edit Nested Column Post Id'.$this->col_id,'','small info fsmorange posbackground white  click','',500,'',$floatstyle,'','');echo '<!--open show more on-->';
                     printer::print_wrap('Expand current width '.$this->blog_type);
                     }
               else   $idl=$this->col_dataCss;
               $this->id_array[]=array('col',$idl,$this->column_level+1,'<span class="bold ">column</span> id: c'.$this->col_id,$this->is_clone,$idl); // id_array for quick navigation to posts in editmode
               }
          elseif($this->edit){//is blog
               $idl="p{$this->orig_val['blog_id']}";
               if($show_more_on){
                    echo '<div id="'.$idl.'" style="'.$floatstyle.' width:'.$setwid.'px" >';//create anchor before show_more statement
                    $this->show_more('Edit '.str_replace('_',' ',strtoupper($this->blog_type)). ' Post Id'.$this->blog_id,'','small info fsm2orange posbackground white  click','',500,'',$floatstyle,'','');echo '<!--open show more on-->';
                    printer::single_style_wrap('Expand current width '.$this->blog_type,'border: solid 3px orange;color:#'.$this->current_color.';background-color:#'.$this->current_background_color.';');
                    } 
               $this->id_array[]=array($this->blog_type,$idl,$this->column_level,$this->blog_type.' id: p'.$this->blog_id,$this->is_clone);// id_array for quick navigation to posts in editmode
               }
          #mainwidth render
		#stylewidth
		#altrespon
		$cb_data=($this->blog_type==='nested_column')?$this->col_dataCss:$this->dataCss;
		$type=($this->is_column)?'col':'blog';
          #here we sort out the use type main_width value
          #use_blog_main_width #use_col_main_with #use_'.$type.'_main_width
          #this value for blog or col use_blog_main_width is set in function total float
          #if blog main width not set we may be using #3 blog width main mode and we can update the main width value to equal this initial setting made in mode #3 so we allow it here
          if ($this->edit)$mediapercent=(is_numeric($this->blog_width_mode[$this->{'blog_percent_init_index'}])&&$this->blog_width_mode[$this->blog_percent_init_index]>0&&$this->blog_width_mode[$this->blog_percent_init_index]<=100)?$this->blog_width_mode[$this->blog_percent_init_index]:''; 
          #mainmode  #mode 
          if ($this->edit&&!$this->rwd_post&&(is_numeric($this->{$type.'_width'})&&$this->{$type.'_width'}>0&&$this->{'use_'.$type.'_main_width'} ||$this->blog_width_mode[$this->blog_width_mode_index]==='compress_to_percentage'&&!empty($mediapercent))){ 
               $mode=($this->blog_width_mode[$this->blog_width_mode_index]==='maxwidth'||$this->blog_width_mode[$this->blog_width_mode_index]==='compress_full_width'||$this->blog_width_mode[$this->blog_width_mode_index]==='compress_to_percentage'||$this->blog_width_mode[$this->blog_width_mode_index]==='off')?$this->blog_width_mode[$this->blog_width_mode_index]:'maxwidth'; 
               if ($mode==='compress_to_percentage'||$mode==='compress_full_width'){//takes care of  width css for regular and nested column posts 
                    if ($mode==='compress_full_width'){
                         $this->css.='
               div .'.$cb_data.'{width:'.($this->current_total_width_percent).'%;}';
                         }
                    elseif ($mode==='compress_to_percentage'){
                         $fitfactor=($this->is_masonry)?.985:.995;
                         $marginleft=(is_numeric($this->blog_width_mode[$this->blog_marginleft_init_index])&&$this->blog_width_mode[$this->blog_marginleft_init_index]>=0&&$this->blog_width_mode[$this->{'blog_marginleft_init_index'}]<=100)?'margin-left:'.($fitfactor*$this->blog_width_mode[$this->{'blog_marginleft_init_index'}]).'%;':'';
                         $marginright=(is_numeric($this->blog_width_mode[$this->blog_marginright_init_index])&&$this->blog_width_mode[$this->blog_marginright_init_index]>=0&&$this->blog_width_mode[$this->blog_marginright_init_index]<=100)?'margin-right:'.($fitfactor*$this->blog_width_mode[$this->blog_marginright_init_index]).'%;':'';
                          if (!empty($mediapercent)){
                              if($this->edit&&$this->blog_width!==$mediapercent){
                                   $this->updater('typeenv',"{$type}_width='$mediapercent'",'idenv'); #here we update blog_width ie main width value because setting this will set this->use_blog_main_width to true and will also update width values in function total float. 
                                   }
                              $this->css.='
                    html div .'.$cb_data.'{width:'.($mediapercent*$fitfactor).'%;'.$marginleft.$marginright.'}
                         ';
                              }
                         $array_key=$array_collect=array();
                         for ($i=1; $i<9;$i++){
                              $mediawidth=(is_numeric($this->blog_width_mode[$this->{'blog_media_'.$i.'_index'}])&&$this->blog_width_mode[$this->{'blog_media_'.$i.'_index'}]>=250&&$this->blog_width_mode[$this->{'blog_media_'.$i.'_index'}]<=3000)?$this->blog_width_mode[$this->{'blog_media_'.$i.'_index'}]:'';
                              $mediapercent=(is_numeric($this->blog_width_mode[$this->{'blog_percent_'.$i.'_index'}])&&$this->blog_width_mode[$this->{'blog_percent_'.$i.'_index'}]>0&&$this->blog_width_mode[$this->{'blog_percent_'.$i.'_index'}]<=100)?$this->blog_width_mode[$this->{'blog_percent_'.$i.'_index'}]:'';
                              $marginleft=(is_numeric($this->blog_width_mode[$this->{'blog_marginleft_'.$i.'_index'}])&&$this->blog_width_mode[$this->{'blog_marginleft_'.$i.'_index'}]>=0&&$this->blog_width_mode[$this->{'blog_marginleft_'.$i.'_index'}]<=100)?'margin-left:'.($fitfactor*$this->blog_width_mode[$this->{'blog_marginleft_'.$i.'_index'}]).'%;':'';
                              $marginright=(is_numeric($this->blog_width_mode[$this->{'blog_marginright_'.$i.'_index'}])&&$this->blog_width_mode[$this->{'blog_marginright_'.$i.'_index'}]>=0&&$this->blog_width_mode[$this->{'blog_marginright_'.$i.'_index'}]<=100)?'margin-right:'.($fitfactor*$this->blog_width_mode[$this->{'blog_marginright_'.$i.'_index'}]).'%;':'';
                              $array_collect[$mediawidth]=array($mediapercent,$marginleft,$marginright);
                              }
                         krsort($array_collect);
                         foreach ($array_collect as $key=>$sorted){
                              $mediawidth=$key;
                              $mediapercent=$sorted[0];
                              $marginleft=$sorted[1];
                              $marginright=$sorted[2];
                              (!empty($mediawidth)&&!empty($mediapercent))&&
                                   $this->mediacss.='
               @media screen and (max-width:'.$mediawidth.'px){
                    html div .'.$cb_data.'{width:'.($mediapercent*$fitfactor).'%;'.$marginleft.$marginright.'}
                         }';   
               
                              }//end for loop
                         }
                    }
                    elseif ($this->flex_enabled_twice&&$mode==='maxwidth'){ 
                         //flex box enabled in parent tree and widthcalculator not correct..
                         $this->css.='
               div .'.$cb_data.'{width:'.($this->current_total_width_percent).'%;}';
                         }
               elseif($mode==='maxwidth'){// default maxwidth
                    $this->css.='
          div.'.$cb_data.'{max-width:'.$this->current_total_width.'px;}';
                         }
               }//$this->edit&&use_blog/col main width
         #mainanimation && !$this->rwd_post&&!$this->flex_box_item
		$masonclass=($this->is_masonry)?' grid-item_'.$this->col_id:''; 
		if (!$this->edit){//note these  values are also used below in nested column divisions 
			list($anim_type,$anim_height,$anim_lock,$aef_class)=$this->preanimation(); 
			$anim_class=($anim_type!=='none' && !$aef_class)?" $anim_type animated active-anim " :(($anim_type!=='none')?" $anim_type animated ":'');
			$dataAnimHeight=($anim_type!=='none')?' data-hchange="'.$anim_height.'" ':'';
			$dataAnimLock=($anim_type!=='none')?' data-hlock="'.$anim_lock.'" ':''; 
			} 
		if ($this->blog_type!=='nested_column'){
               $blog_custom_class=(!empty($this->blog_options[$this->blog_custom_class_index])&&!is_numeric($this->blog_options[$this->blog_custom_class_index]))?$this->blog_options[$this->blog_custom_class_index]:''; 
			$style=($this->edit&&$this->current_total_width<50)?'style="width:50px;"':'';
			list($bw,$bh)=$this->border_calc($this->blog_style);
			if (!empty($bw)) 
				$bs=$this->calc_border_shadow($this->col_style); 
			$class=($this->rwd_post)?$this->dataCss.' post '.str_replace(',',' ',$this->blog_grid_width).' '.str_replace(',',' ',$this->blog_gridspace_right).' '.str_replace(',',' ',$this->blog_gridspace_left).' '.$blog_custom_class:$this->dataCss.' post '.$blog_custom_class;
			$nav_class='';
			if ($this->blog_type==='navigation_menu'){
				$nav_class=($this->blog_tiny_data2==='force_vert')?' vert':' horiz';
				$nav_class.=($this->blog_tiny_data3==='nav_display')?' display':' hover';
				}
		//call in animation info for webpage mode this will retrieve minimal javascript if animation enabled as well as main division class and data attributes..
		#maindiv blog    #mainwidth 
			$float_image=($this->blog_type==='float_image_left'||$this->blog_type==='float_image_right')?' float_image':'';//this is used for globalizing styles within a column with float image right and left we dont want to copy the image styles because of necessary padding between right and left but we do want to copy the text styles..  whereas image styles can also be globalized if type matches. to accomadate this in render textarea we use the css extenstion : float images and in images we use the the full blog type css extension.  Here we include both to cover all situations
		#maindiv 
			$dataMinheight='';//($this->blog_height_arr[$this->blog_min_height_index]>=5&&$this->blog_height_arr[$this->blog_min_height_index]<=1000)?' data-minHeight="'.$this->blog_height_arr[$this->blog_min_height_index].'" ':'  data-minHeight="1" ';
			$classHeight='';//($this->blog_height_arr[$this->blog_image_height_index]==='adjust')?' respondHeight ':''; 
			$dataHeight='';//($this->blog_height_arr[$this->blog_image_height_index]==='adjust')?' data-rwd="'.$this->rwd_post.'" data-type="'.$this->blog_type.'" data-height="init" data-hwid="init" ':'';
			
		 	if (!$this->edit)
				print '<div id="'.$this->dataCss.'" '.$style.' class="'.$class.$nav_class.$anim_class.$classHeight.$masonclass.' '.$this->blog_type.$float_image.' webmode"'.$dataHeight.$dataMinheight.$dataAnimHeight.$dataAnimLock.' >';
			else {
				$addclass=(empty($bw))?' bs'.$this->page_editborder.$this->column_lev_color.' ':((empty($bs))?' bshad'.$this->page_editborder.$this->column_lev_color.' ':'');
		#fieldset  switched to class  //removed style="max-width:'.$this->current_total_width.'px;"
          
                    $stylemore=($show_more_on)?'style="max-width:500px !important;width:500px;"':'';
                    $pid=(!$show_more_on)?' id="p'.$this->orig_val['blog_id'].'"':'';
				 print '<div id="'.$this->dataCss.'" '.$stylemore.' class="'.$class.$nav_class.$addclass.' '.$this->blog_type.$float_image.' edit post"><!--Editpage fieldset post border--><p '.$pid.' class="lineh90  editcolor shadowoff editbackground editfont ">Post</p>'; 
				printer::pclear();echo '<!--clear edit main blog div begin-->';
                    } 
			$this->background_video('blog_style');
			}//if !nested column
		if ($this->edit&&$this->blog_type!='nested_column'){ 
			if ($blog_status==='clone'&&$blog_unstatus==='unclone'&&!empty($blog_clunc_id)){
				$this->delete_unc_clone_option($blog_clunc_id);//give option to remove unclone
				}
			if (empty($this->blog_pub)){
				if (!$this->is_clone||$this->clone_local_style){
					echo '<div class="fsminfo editbackground editfont rad10 floatleft"><!--wrap publish-->';
					printer::alertx('<p class="pos floatleft editbackground editfont bold"><input type="checkbox" value="1" name="'.$data.'_blog_pub"> Publish Post to Web Pages<br></p>');
					$this->navobj->return_url($this->pagename,'',$this->column_lev_color.' floatleft    smallest button'.$this->column_lev_color,true);
					echo '</div><!--wrap publish-->';
					printer::pclear();echo '<!--clear publish-->';
					}
				}
			//self::print_total_float();
			$id=$blog_id; 
			printer::printx('<span id="post_'.$blog_id.'"></span>');//this was/is used for url return focus
			if (($orig_val['blog_status']==='clone'||$this->is_clone)&&!$this->tagged){
				if ($this->blog_status !=='clone'&&$this->parent_col_clone!==$this->col_id){
					$clone_msg='<span class="info" title="Parent Column Id c'.$this->parent_col_clone.' was directly Cloned and this Post and Any Nested Columns Within it were Automated Cloned as Well."> Info </span>';
					}
				elseif ($this->blog_status !=='clone'){
						$clone_msg='<span class="info" title="Parent Column Id c'.$this->parent_col_clone.' was directly Mirrored and this Post within is mirrored along with it."> Info </span>';
					}
				else if ($blog_unstatus==='unclone'){ //needs check
					$clone_msg='<span class="info" title="This Post was Mirror released then mirrored again with different Parent Blog p'.$blog_clone_target.' ">Mirror released and ReMirrored</span>'; 
					} 
				else{
					$clone_msg='<span class="info" title="This Post was directly Cloned From Parent Post p$this->blog_id"> Directly </span>';
					$this->parent_col_clone=$col_id;
					printer::pclear(10);echo '<!--clear direct clone -->';
					if ($blog_type !=='nested_column'&&!empty($blog_clone_target)&&!$this->is_clone){
						 $this->switch_clone_options($blog_clone_target,false,'post');
						}
					}	 
				 printer::alertx('<p class="editcolor fs2npred small floatleft editbackground editfont "><span class="red">Cloned Post </span> '.$clone_msg.' changes to: P'.$this->blog_id.' @ Page <a class="whiteshadow2" style="color:#0075a0;"  target="_blank" href="'.check_data::dir_to_file(__METHOD__,__LINE__,__FILE__,$this->blog_table_base).$this->ext.'#post_'.$this->blog_id.'"><u>'.check_data::table_to_title($this->blog_table_base,__method__,__LINE__,__file__).'</u></a> Appear Here Also </p>');
				printer::pclear();echo '<!--clear clone 1-->';
				echo $deleteclone;
				printer::pclear();echo '<!--clear clone 2-->';
				if (in_array('p'.$blog_id,$this->clone_check_arr)){
					printer::alertx('<p class="orangebackground white smaller floatleft">'."Well, Post Id P$blog_id has been cloned twice on this Page And multiple identical Clones on same page affect one another!!</p>");
					}
				else {
					if ($orig_val['blog_status']!=='clone')
					$this->unclone_options('p'.$blog_id,$this->post_target_clone_column_id);
					}
				 printer::pclear();echo '<!--clone otps-->';
				#enable clone options
				#enable local post
				if (!$this->clone_local_style&&$this->is_clone&&!$this->clone_local_data){ 
					$this->show_more('Enable Local Post Settings','noclose','small highlight editbackground editfont rad3 fs2npinfo click','Enable Local Styling/Configs of this Cloned Post Without Affecting the styling of the Parent Post',600); 
					$msg='Check to enable local styling/configs of this clone without affecting the parent style';
					echo '<div class="fsminfo editbackground editfont  floatleft '.$this->column_lev_color.'"><!--Local clone style-->';
					printer::printx('<input type="checkbox" name="add_bloglocalstyle['.$this->orig_val['blog_id'].']" value="1" >'.$msg);
					printer::alert_neu('Note: By enabling Local Styling/Configs of this Post the Styling which includes floating and width, and various settings, will not Update When the Parent Style Updates, instead only when you make styling changes here',.8);
					echo '</div><!--Local clone style-->';
					$this->show_close('Local clone style');
					}
				elseif ($this->clone_local_style){
					$this->show_more('Disable Local Post Style','noclose','small highlight editbackground editfont rad3 fs2npinfo click','Disable Local Styling of this Cloned Post and Return to the Parent Post Style',600); 
					$msg='Disable local post styling';
					echo '<div class="fsminfo editbackground editfont  floatleft '.$this->column_lev_color.'"><!--Local clone style-->';
					printer::printx('<input type="checkbox" name="delete_bloglocalstyle['.$this->orig_val['blog_id'].']" value="1" >'.$msg);
					printer::alertx('<p class="small info">Note: By disabling Local Styling of this Post the Styling which includes floating and width, colors,etc, WILL NOW assume the style of the Parent and Update When the Parent Style Updates</p>');
					echo '</div><!--Local clone style-->';
					$this->show_close('Local clone style2');
					}
				if ($this->blog_type==='image'||$this->blog_type==='video'||$this->blog_type==='social_icons'||$this->blog_type==='auto_slide'||$this->blog_type==='text'||$this->blog_type==='gallery'){
					if (!$this->clone_local_data&&$this->is_clone&&!$this->clone_local_style){ 
						$this->show_more('Enable Local Post Data','noclose','small highlight editbackground editfont rad3 fs2npinfo click','Enable Local Data while keeping all Cloned Styling of this Cloned Post Without Affecting the Data of the Parent Post',600); 						
                              $msg='Check to enable local data while retaining cloned style of this clone post and without affecting the parent data';
						echo '<div class="fsminfo editbackground editfont  floatleft '.$this->column_lev_color.'"><!--Local clone style-->';
						printer::printx('<input type="checkbox" name="add_bloglocaldata['.$origval_id.']" value="1" >'.$msg);
						echo '</div><!--Local clone style-->';
						$this->show_close('Local clone style3');
						}
					elseif ($this->clone_local_data){
						$this->show_more('Disable Local Post Data','noclose','small highlight editbackground editfont rad3 fs2npinfo click','Disable Local Styling of this Cloned Post and Return to the Parent Post Style',600); 
						$msg='Disable local post Data';
						$msg='Will return to full clone without local data changes';
						echo '<div class="fsminfo editbackground editfont  floatleft '.$this->column_lev_color.'"><!--Local clone style-->';
						printer::printx('<input type="checkbox" name="delete_bloglocaldata['.$origval_id.']" value="1" >'.$msg);
						printer::alertx('<p class="small info">Note: By disabling Local Styling of this Post the Styling which includes floating and width, colors,etc, WILL NOW assume the style of the Parent and Update When the Parent Style Updates</p>');
						echo '</div><!--Local clone style-->';
						$this->show_close('Local clone style4');
						}
					}//blog types enabled for local data
				}//not tagged and is clone
				
			elseif($this->is_clone && $this->tagged){
				printer::alertx('<p class="neg fs2npred small floatleft editbackground editfont left shadowoff">This Post is a <u><span class="orange whitebackground">Tagged Post</span></u> and Changes to the Parent Post Id: P'.$blog_id.' on Page <a style="color:#0075a0;"  target="_blank" href="'.check_data::dir_to_file(__METHOD__,__LINE__,__FILE__,$this->blog_table_base).$this->ext.'#post_'.$blog_id.'"><u>'.check_data::table_to_title($this->blog_table_base,__method__,__LINE__,__file__).'</u></a> Will Appear Here </p>');
				printer::pclear();echo '<!--clear tagged Post-->';
				}
			}// is edit and !nested_column
		$alerted=($this->is_clone)?'this is clone': ' this is not clone';
		// if ($this->blog_type!=='nested_column')echo printer::alert_neg($alerted);
		#functs
		
          $this->blog_typed=str_replace('_',' ',$this->blog_type);
		 if($this->blog_options[$this->blog_date_on_index]==='date_on'){
			list($date,$v,$n)=$this->format_date($this->blog_date);
			echo '<div class="floatleft style_date">'.$date.'</div>';
			
			if ($this->edit){
				printer::pclear();
				echo '<!--clear date entry-->';
				}
			}
		(Sys::Deltatime)&&$this->deltatime->delta_log('Blog Render Id '.$this->blog_id.' blog:type: '.$this->blog_type.'  '.__line__.' @ '.__method__.'  ');   
		$floatnewblog=($this->edit)?$floating:false;
          if ($this->blog_type==='text'){ 
			$this->text_render($data,$this->blog_table);
			($this->blog_options[$this->blog_comment_index]==='comment_on')&&$this->comment_display($data,'blog_data7');
			
			 }
			#blog_type,blog_pic,blog_style,blog_text,blog_link,blog_linkref,blog_order
		elseif ($this->blog_type==='image'){ 
               $this->build_pic($data,Cfg_loc::Root_dir.Cfg::Page_images_dir); 
			
			}
		elseif ($this->blog_type==='float_image_right'){
			$this->float_pic($data, Cfg_loc::Root_dir.Cfg::Page_images_dir); 
			($this->blog_options[$this->blog_comment_index]==='comment_on')&&$this->comment_display($data,'blog_data7');
			}
		elseif ($this->blog_type==='float_image_left'){
			$this->float_pic($data, Cfg_loc::Root_dir.Cfg::Page_images_dir); 
			($this->blog_options[$this->blog_comment_index]==='comment_on')&&$this->comment_display($data,'blog_data7');
			 }
		 
		elseif ($this->blog_type==='video'){  
			$this->video_post($data);
			}
		 
		elseif ($this->blog_type==='contact'){ 
			$this->contact_form($data,'',false,'Edit Overall Contact Styling',true,$this->blog_table); 
			}
		elseif ($this->blog_type==='social_icons'){
			$this->social_icons($data,'',false,'Edit Social Icon Styling',true,$this->blog_table); 
			}
		elseif ($this->blog_type==='auto_slide'){
			$this->auto_slide($data,'blog'); 
			}
		elseif ($this->blog_type==='gallery'){ 
			$this->gallery($data,$this->blog_data1); 
			}
		elseif ($this->blog_type==='navigation_menu'){  
			$this->nav_menu($data,$this->blog_data1,false,'',true,$tablename);  
			
			}  
		elseif ($this->blog_type==='misc'){  return;//not in play
			$this->misc($data);  
			} 
 #nested  #nc
		elseif ($this->blog_type==='nested_column'){
			 
			#&&&&&&&&&  Note: till nest column function called column level still parent!  &&&&&&&&&&&&&&&&&&&
			 $this->blog_order_arr[$this->column_level]=$orig_val['blog_order'];//this currently appears to be used for html div <!-- reference only --> 
	#nesteddiv  
			 
			$textalign=($this->rwd_post)?'':' text-align:center;';//this is applied for cases in which rwd is not used and center float (inline-block) is used for posts within this column in order that ..  also use when rwd is in play for consistency 
			($this->edit)&&$this->css.="\n .$this->col_dataCss{".$floatstyle.$textalign.'}';
			#NON RWD WIDTHS HANDLED BY CSS IN maindiv
			 $width_express=''; 
			#width of nested columns now set along with post width go to # maindiv
			 $class=($this->rwd_post)?$this->col_dataCss.' '.str_replace(',',' ',$this->col_grid_width).' '.str_replace(',',' ',$this->col_gridspace_right).' '.str_replace(',',' ',$this->col_gridspace_left):$this->col_dataCss; 
			list($bw,$bh)=$this->border_calc($this->col_style); 
			if (!empty($bw)) 
				$bs=$this->calc_border_shadow($this->col_style);
			if (!$this->edit){ 
				 $col_masonry=($col_par_masonry)?' grid-item_'.$col_id:'';#we could go with col level arr setup but this works also..
				$enablemasonclass='';
	 #################
			#Here we are checking raw col_option data as it hasn't been passed around yet to col_data.
			
				if ($this->col_options[$this->col_enable_masonry_index]==='masonry'){
                         $enablemasonclass=' gridcol_'.$this->col_id; 
					$this->load_masonry();//load files..
					$masonryClass='gridcol_'.$this->col_id;
					$mclass=".$masonryClass";
					if (!$this->edit){// padleft,
						echo <<<eol
					
<script>
var resizeTimer1_$this->col_id='';
var mopts={
     gutter: 0,  
     isFitWidth: false,
     itemSelector: '.grid-item_$this->col_id' 
     } 
\$(function(){ 
     
          $('$mclass').imagesLoaded().always( function( instance ) {
               setTimeout( function(){
                    \$gridcol_$this->col_id=\$('$mclass').masonry(mopts); 
                    \$gridcol_$this->col_id=\$('$mclass').masonry(mopts); //initiating twice
                    }, 100);
               var windowWidth = \$(window).width();
               window.addEventListener('resize', function(){//overcomes 
               if (\$(window).width() != windowWidth) {
                    windowWidth = \$(window).width();
                    if (\$gridcol_$this->col_id.masonry()!=='undefined')\$gridcol_$this->col_id.masonry('destroy'); 
                     clearTimeout(resizeTimer1_$this->col_id); 
                     resizeTimer1_$this->col_id=setTimeout( function(){ 
                     \$gridcol_$this->col_id=\$('$mclass').masonry(mopts); 
                     \$gridcol_$this->col_id=\$('$mclass').masonry(mopts);//initiating twice 
                    }, 200);
                    }
                }, true); 
     });
});
</script>
eol;
						}//masonry but not edit\
					}//end is masonry  
				print '<div id="'.$this->col_dataCss.'" class="'.$class.$anim_class.$enablemasonclass.$col_masonry.' nested webmode" '.$dataAnimHeight.$dataAnimLock.'><!--Begin Nested Column id:'.$this->col_id.'-->';
				}
			else  {//edit mode and nested colmn
				$addclass=(empty($bw))?' bdot'.$this->page_editborder.$this->color_arr_long[$this->column_level+1].' ':((empty($bs))?' bshad'.$this->page_editborder.$this->column_lev_color.' ':'');
                    $stylemore=($show_more_on)?'style="max-width:500px !important;width:500px;"':'';
			#fieldset  switched to class     add addclass for edit border...
				echo '<div id="'.$this->col_dataCss.'" '.$stylemore.' class="'.$class.$addclass.' nested column edit" ><!--Begin edit  Nested Column id'.$this->col_id.'-->';
                    #flexstay
                    if ($this->edit&&$this->flex_box_container)echo '<div class="flexstay"><!--wrap controls flexbox-->';
                    echo'<p class="lineh90  shadowoff editcolor editbackground editfontcol">Nested Column</p>';
				printer::pclear();echo '<!--clear nested col info-->';  
				if($this->edit&&$show_more_on)printer::print_spacer();
                    if($blog_status==='clone'&&$blog_unstatus==='unclone'&&!empty($blog_clunc_id)){
					$this->delete_unc_clone_option($blog_clunc_id);
					$this->is_clone=true;
					}
				echo $deleteclone;
				printer::pclear();echo '<!--clear field level2-->';
				if (empty($this->blog_pub)){
					if (!$this->is_clone||$this->clone_local_style){
						printer::alertx('<p class="pos editfont floatleft editbackground editfont  bold"><input type="checkbox" value="1" name="'.$data.'_blog_pub"> Publish Nested Column to WebPages</p>');
						}
					} 
				}  
			########################
			#values from primary or previous nested to replace once next nested column is closed.. 
			#note property vals will be restored with recursion whereas vars will automatically retain their column level value in the nested column render in this method..!!
	
	$objvars_hold=array();
     #passthruarray
	$objvars=explode(',','rwd_post,blog_float,blog_table,column_lev_color,blog_border_stop,col_num,blog_order,blog_order_mod,fieldmax,is_clone,clone_local_style,clone_local_data,clone_ext,is_masonry,flex_box_container,flex_enabled_twice,current_font_em_px,current_font_em,terminal_font_em_px,terminal_px_scale,terminal_em_scale,terminal_rem_scale,font_scale,rem_scale,current_em_scale');
	foreach ($objvars as $ov){ 
		$objvars_hold[$ov]=$this->$ov;
		} 
			$this->nested_column();
			//now we begin restore restore function scope class properties ...
			//class functions need to be restored
			//variables will restore automatically as original scope returns by default
			$this->blog_type='nested_column'; 
			$col_field_arr2=$this->col_field_arr; 
			$col_field_arr2[]='col_id';
			#values from primary or previous nested to replace once next nested column is closed.. 
			#note property vals will be restored with recursion whereas vars will automatically retain their column level value in the nested column render in this method..!!
			#here we restore the previous round of column values stored as variables not properties 
			foreach ($col_field_arr2 as $field){ 
				$this->$field=${'restore_'.$field};
                    $newf=(is_array($this->$field))?implode(',',$this->$field):$this->$field;
                    }
			foreach ($objvars_hold as $key => $ov){
				$this->$key=$objvars_hold[$key]; 
				}
               //repopulate values after coming out of last nested column	 
			$this->col_dataCss=$this->clone_ext.$this->col_table_base.'_col_'.$this->col_id;
               $this->pelement=".$this->col_dataCss.nested_column";//set for nested column types
			$this->current_net_width=$this->column_net_width[$this->column_level];
               if ($floatnewblog){
                   
                    if ($this->edit&&$this->col_options[$this->col_use_grid_index]!=='use_grid'&&(substr($this->col_flex_box,0,3)==='fle'||substr($this->col_flex_box,0,3)==='inf')){
                         echo '<div class="flexstay"><!--wrap column flexbox control Bottom  div-->';
                    $this->blog_new($data,$this->blog_table,$blog_order, $this->blog_order_mod.' in ');
                     echo '</div><!--close wrap column flexbox control Bottom  div-->';
                    }
               else  $this->blog_new($data,$this->blog_table,$blog_order, $this->blog_order_mod.' in ');
               }
			($this->edit)&&printer::print_spacer();
               printer::pclear(); echo '<!--preclosing-->';
			print '</div><!--End Nested Column id:'. $this->column_id_array[$this->column_level+1].' -->';
			 if ($this->edit&&$show_more_on){
                    $show_more_on=false; 
                    //printer::close_single_style_wrap('Expand current width');
                    $this->show_close('show more on');echo '<!--close show more column on-->';
                    echo '</div><!--wrap show id-->';
                   }
               }//end nested column.. 
		else {
			$msg="Missed the boat with blog id $this->blog_id and type $this->blog_type  in ".__method__ ;
			mail::alert($msg);
			echo $msg;
			}
		#reinit clone status for all
		$this->is_clone=(array_key_exists($this->column_level,$this->column_clone_status_arr)&&$this->column_clone_status_arr[$this->column_level])?true:false;
		if ($this->blog_type!=='nested_column'){
               ($floatnewblog)&&$this->blog_new($data,$this->blog_table,$blog_order, $this->blog_order_mod.' in ');
			print '</div><!-- id#'.$this->blog_id.' '.$this->blog_type.'-->';
               if ($this->edit&&$show_more_on){
                    $show_more_on=false;
                    printer::close_single_style_wrap('Expand current width '.$this->blog_type);
                   $this->show_close('show more on');echo '<!--close show more on '.$this->blog_type.'-->';
                    echo '</div><!--wrap show id-->';
                   
                   }
               if(!$floating){printer::pclear(); echo '<!--clear post level-->';} 
			}
		if (!empty($this->blog_border_stop)) {
			//($this->edit)&&printer::alert_neg('Extra blog boarder alert Above Post');
			unset($this->groupstyle_begin_col_id_arr[$this->col_id]);
			unset($this->groupstyle_begin_blog_id_arr[$this->col_id]);
			print('</fieldset><!--'.$this->blog_table.' .style _groupstyle-->'); #end the border
			}
		(!$floatnewblog)&&$this->blog_new($tablename.'_'.$this->blog_order,$tablename,$blog_order, $this->blog_order_mod.' in');	//services both nest and blog types 	
		$this->clone_local_style=false; //reinitialize
		$this->clone_local_data=false;		 
		}#end while #actually a foreach now
	
	($this->edit&&isset($this->groupstyle_begin_col_id_arr[$this->col_id]))&&printer::alertx('<p class="floatleft warn1">Caution You have an error having not closed  an open groupstyle for post Id '.$this->groupstyle_begin_blog_id_arr[$this->col_id]. " within this parent Column id $this->col_id</p>");
		if ($prime){
               ($this->edit)&&printer::print_spacer();
			printer::pclear();echo '<!--clear prime level-->';
               print'</div><!--End Primary Column id '.$this->col_id.'-->';
				}
			
		if  ($this->blog_float===$this->position_arr[0]||$this->blog_float===$this->position_arr[4]||$this->blog_float===$this->position_arr[5]||$this->blog_float===$this->position_arr[6]){ 
			 printer::pclear(); echo '<!--clear Column level-->';
			}
	$this->is_blog=false;//turned off...   first use is for determining element size for rendering font size preview in styling options..
	$this->blog_status='';
	}#end blog_render function	

		
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
      $this->current_font_size=$this->rem_root=(is_numeric($this->page_options[$this->page_rem_unit_index])&&$this->page_options[$this->page_rem_unit_index]<=50&&$this->page_options[$this->page_rem_unit_index]>=5)? $this->page_options[$this->page_rem_unit_index]: 16;//needed for webpage mode and editpages..
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
	$this->page_images_arr[$this->pagename]=array(); 
	$this->page_images_expanded_arr[$this->pagename]=array();
	$this->auto_slide_arr[$this->pagename]=array();// 
	$this->large_images_arr[$this->pagename]=array(); 
	}
     
function page_script(){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	$fields='page_id,'.Cfg::Page_fields;  
	$this->accessvar_obj($this->master_page_table,$fields,'page_ref',$this->pagename);
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
	// $this->render_yt_embed_player();
	$this->header_close(); $this->deltatime->delta_log('header'); 
	$this->render_body();
	//(Sys::Deltatime)&&print $this->deltatime->return_delta_log();
	}
	
function accessvar_obj($master_table,$field_data,$ref1,$refval1,$ref2='',$refval2=''){//accessvar no longer used for posts in webpage mode due to flat filing in editpage mode..  used to render page level and for displaying unclone columns and posts in function destructor
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
		mail::alert('Page not found and page file needs to be deleted using database:'.Sys::Dbname.' and query: '.$q);
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
			mail::alert('Multiple select for pagename and field: '. $refval1.' and '.$refval2. ' using query '.$q);
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
function nav_return(){return;//unnecessary
	if (!$this->edit&&Sys::Logged_in){ 
		echo '<div style="float:left;">';
          echo '<a href="'.Cfg::PrimeEditDir.Sys::Self.'">Edit-Nav</a>';
		echo '</div>';
		}
	}	
#rb
function render_body(){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__); 
	(Sys::Deltatime)&&$this->deltatime->delta_log(__line__.' @ '.__method__.'  ');
	$this->call_body();
	$this->track_font_em($this->page_style);
     $opts_arr=explode(',',$this->page_tiny_data2); 
   	if (array_key_exists(3,$opts_arr)&&$opts_arr[3]==='enable_page_slideshow'){
		$this->auto_slide($this->pagename,'page');
		}
	$this->nav_return(); 
	$this->browser_size_display(); 
	$this->render_body_main(); 
	$this->javascript_preload();
	$this->render_body_end();
	}

function javascript_preload(){
	if (!empty($this->preload )){
		echo '<script >
		fadeTo.preloading('.$this->preload.');
		</script>';
		}
	}
function render_body_main(){ //if (isset($_POST))print_r($_POST); 
	(Sys::Deltatime)&&$this->deltatime->delta_log('Begin render body main '.__line__.' @ '.__method__.'  '); 
	$this->clone_ext='';//extension used for delinieate if column or post is clone: may affect  style and submitted data  elements
	(Sys::Deltatime)&&$this->deltatime->delta_log(__line__.' @ '.__method__.'  ');
	($this->edit)&&printer::alertx( '<p id="javascriptcheck" class="neg editbackground  editfont fsmred vlarge" style="display:block">Caution: Your Javascript is Disabled. This Edit Site Requires Javascript Be Enabled in Your Browser. Submitting Changes Without Javascript Enabled Can Result in Data Loss</p>
	<script > 
		document.getElementById("javascriptcheck").style.display="none" 
     </script>');
	 
	$styles=explode(',',$this->page_style);//for background
	$this->current_background_color=$this->column_background_color_arr[0]= (array_key_exists($this->background_index,$styles)&&preg_match(Cfg::Preg_color,explode('@@',$styles[$this->background_index])[0]))?explode('@@',$styles[$this->background_index])[0]:'ffffff';
	$this->current_color=$this->column_color_arr[0]= (array_key_exists($this->font_color_index,$styles)&&preg_match(Cfg::Preg_color,$styles[$this->font_color_index]))?$styles[$this->font_color_index]:'000000';
	$this->current_font_px=$this->column_font_px_arr[0]=(array_key_exists($this->font_size_index,$styles)&&!empty($styles[$this->font_size_index])&&$styles[$this->font_size_index]>=.5&&$styles[$this->font_size_index]<=4.5)?$styles[$this->font_size_index]*16:16;
	$where="WHERE col_table_base='$this->pagename' and col_primary=1";
	$count_column=$count=$this->mysqlinst->count_field($this->master_col_table,'col_id','',false,$where);
	if ($count_column <1){
		if ($this->edit){
			printer::alertx('<div class="left fs2'.$this->column_lev_color.' '.$this->column_lev_color.' right10 left10 editbackground  editfont left maxwidth700" title=""><input type="checkbox" value="1" name="addnewcolumn[]">Check this box to Begin Creating Your Content Column From Scratch and hit the Submit Change Button. ');
			printer::pclear(10);
			echo '</div>';
			printer::alertx('<p class="left fs2'.$this->column_lev_color.' '.$this->column_lev_color.' right10 left10 editbackground  editfont left maxwidth700" title=""><input type="checkbox" value="1" name="copynewcolumn[]">OR Copy/Clone/Move   Any Previous Column from another Page (ie Template Starter) Here </p>');
			printer::pclear(10);
			 
			$this->submit_button('SUBMIT ALL'); 
			}
		elseif (Sys::Logged_in){  
			printer::alertx('<p style="font-size:2em; color:#'.$this->info.';background:#ffffff;">Navigate to Editpages To Create Your First Page</p>',1.75);
			}
		else 
			printer::alertx('<p style="font-size:2em; color:#'.$this->pos.';background:#ffffff;">New Page Coming Soon</p>');
			
		}
	else { 
		if ($this->edit){
			$this->show_more('Add Primary','','editbackground floatleft editcolor editfont supersmall rad3 fs1info','',600);
			printer::alertx('<p class="editbackground fsm'.$this->column_lev_color.' '.$this->column_lev_color.' editfont left maxwidth700" title=""><input type="checkbox" value="0" name="addnewcolumn[]">Check the box to Create another Primary Column directly on Top of Your Previous Primary Column in the body (as opposed to a &#34;Nested Column&#34; which is Column with a  Column as typically done in websites. Primary Columns occupy the center space of a page and do not &#34;float&#34; which is to say do not sit side by side with other columns.  Normally, Columns are created within the Main Column by choosing the New Column option in the Post Dropdown Menu. However you may directly create an additonal Primary Columns  HERE on Top of the Page Body or Following the Current Primary Column(s) Under  Add Primary Option  Below</p>');
			printer::alertx('<p class="editbackground  editfont fs2'.$this->column_lev_color.' '.$this->column_lev_color.' right10 left10 left maxwidth700" title=""><input type="checkbox" value="0" name="copynewcolumn[]">OR Copy/Move/Clone a Column Starter HERE </p>');
			$this->show_close();//<!--End Add Special-->';
			printer::pclear();
			$this->submit_button('SUBMIT ALL');
			printer::pclear(2);
			}
		  
		$col_field_arr2=$this->col_field_arr;
		$col_field_arr2[]='col_id'; 
		$q='select col_id,'.Cfg::Col_fields." from $this->master_col_table where col_table_base='$this->pagename' AND col_primary=1 order by col_num";
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
			$this->clone_ext='';//set default
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
				$this->post_target_clone_column_id=$this->col_clone_target;// 
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
				$col_fields=Cfg::Col_fields;
				$col_fields_arr=explode(',',$col_fields);
				if (isset($_POST['delete_collocalstyle'][$this->col_id])){
					$q="delete from $this->master_col_css_table Where col_id='c$this->col_id' and col_table_base='$this->pagename'";
					$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
					$this->clone_local_style=false;
					}
				else {   
					$this->parent_col_clone=$this->col_clone_target;
					$count=$this->mysqlinst->count_field($this->master_col_css_table,'css_id','',false,"where col_id='c$this->col_id' and col_table_base='$this->pagename'");   
					if ($count < 1){//
						if (isset($_POST['submitted'])&&isset($_POST['add_collocalstyle'][$this->col_id])){
							$q="select $col_fields from $this->master_col_table where col_id='$this->col_id'";  
							$ins=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
							$col_rows=$this->mysqlinst->fetch_assoc($ins,__LINE__);
							$this->mysqlinst->count_field($this->master_col_css_table,'css_id','',false);
							$value='';
							$css_id=$this->mysqlinst->field_inc;
							foreach ($col_fields_arr as $field) {
								if($field==='col_table_base')$value.="'$this->pagename',";
								elseif($field==='col_table')$value.="'$this->col_table',";
								else $value.="'".$col_rows[$field]."',";
								}
							$q="insert into $this->master_col_css_table   (css_id,col_id,$col_fields,col_update,col_time,token) values ($css_id,'c$this->col_id',$value '".date("dMY-H-i-s")."','".time()."','".mt_rand(1,mt_getrandmax())."')";   
							$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true); 
							$this->clone_local_style=true; 
							}
						else {
                                   $this->clone_local_style=false;
                                   
                                   }
						}
					else {//record exists
                              #NOTE this is all for primary column positions only.  this process is repeated in blog_render for nested columns. The difference is that for nested columns the values will be further flatfiled for webpage mode.  Primary columns at this point are not flat filed for webpage mode..
						 $q="select $column_css_fields from $this->master_col_css_table where col_table_base='$this->pagename' and col_id='c$this->col_id'"; 
						$loc=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
						$col_css_row=$this->mysqlinst->fetch_assoc($loc,__LINE__);
						foreach($column_css_fields_arr as $cfield){//here we select and replace all replacable values in local clone style column enabled cloned columns.  For nested columns and all post types a system of flat filing is used... 
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
			($this->edit)&&$this->css.="\n.{$this->clone_ext}col_$this->col_id{text-align:center;margin-left:auto;margin-right:auto; }";//text align used for non rwd posts using  center float  ie  inline-block margin-left:auto;margin-right:auto; 
			$this->blog_render($this->col_id,true,$this->col_table_base); 
			if ($this->edit){   
				$this->submit_button('SUBMIT  ALL');
				printer::pclear(2);
				$this->show_more('Add Primary','','floatleft editbackground  editfont editcolor editfontsupersmall rad5 fsminfo','',600);
				printer::alertx('<p class="editbackground fsm'.$this->column_lev_color.' '.$this->column_lev_color.' editfont  maxwidth700"  title=""><input type="checkbox" value="'.($col_num +.5).'" name="addnewcolumn[]">Check the box to Create another Primary Column directly in the body (as opposed to a &#34;Nested Column&#34; which is Column with a  Column as typically done in websites. Primary Columns occupy the center space of a page and do not &#34;float&#34; which is to say do not sit side by side with other columns. Normally, Columns are created within the Main Column by choosing the nested column option in the Post Dropdown Menu all within a Single Primary Column. However you may directly create additonal Primary Columns in the main Body by checking here. Create a new Primary Column HERE after Primary Column#'.$col_num.'</p>');
				printer::alertx('<p class="editbackground  editfont fs2'.$this->column_lev_color.' '.$this->column_lev_color.' right10 left10 left maxwidth700" title=""><input type="checkbox" value="'.($col_num+.5).'" name="copynewcolumn[]">OR Copy/Move/Clone a Column Starter HERE after Primary Column#'.$col_num.'</p>');
				$this->show_close();//<!--End Add Special-->';
				printer::pclear(2);
				}  
			$i++;
			}//end while
		if ($this->edit&&(isset($_POST['column_copy'])||isset($_POST['addnewcolumn'])||isset($_POST['deletecolumn'])))$this->primary_order_update();
		}//if column exists
	(Sys::Deltatime)&&$this->deltatime->delta_log('End render body main '.__line__.' @ '.__method__.'  '); 
	}
     
function pre_render_data(){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
    }//used for customization to render normal pages by pre configuring data    

#noUiSlider
function initnoUiSlider(){ 
echo <<<eol

<script>
function initnoUiSlider(inc,range1,range2,size,increment,unit,factor,unit2){ 
if (arguments.length>7&&arguments[8]){
     size=(window['updateinput_'+inc].value);
     window['updateSlider_'+inc].noUiSlider.destroy();
     }
else document.getElementById('button-create-slide_'+inc).className += " hide";
var diff=(range2-range1); 
var nextincrement=0;
var totaldiff=diff/increment; 
if  (totaldiff >=2000 ){
     nextincrement=increment;
     increment=20*increment;
     }
else if  (totaldiff >=1000 ){
     nextincrement=increment;
     increment=10*increment;
     }
else if  (totaldiff >=400 ){
     nextincrement=increment;
     increment=5*increment;
     } 
window['updateSlider_'+inc] = document.getElementById('slider-update_'+inc);
window['updateSliderValue_'+inc] = document.getElementById('slider-update-value_'+inc);
window['updateinput_'+inc]=document.getElementById('slider-input_'+inc); 
var datarange1=window['updateinput_'+inc].getAttribute('data-min');
var datarange2=window['updateinput_'+inc].getAttribute('data-max');
if (document.getElementById('slider-checkbox_'+inc))
     window['updateslidercheck_'+inc]=document.getElementById('slider-checkbox_'+inc);

noUiSlider.create(window['updateSlider_'+inc], {
	range: {
		'min': range1,
		'max': range2
	}, 
	start: size, 
	step: increment
});

var convert= unit2 !== '' && factor !=='1' ?'  &nbsp;'+(parseFloat(window['updateinput_'+inc].value*factor).toFixed(2))+unit2:'';
window['updateSliderValue_'+inc].innerHTML=window['updateinput_'+inc].value+unit+convert;//inititial

window['updateSlider_'+inc].noUiSlider.on('slide', function( values, handle ) { 
     var num= Number.isInteger(increment) ? Number(values[handle]) : values[handle];
      var convert= unit2 !== '' && factor !=='1' ?'  &nbsp;'+(parseFloat(num*factor).toFixed(2))+unit2:'';
	 window['updateSliderValue_'+inc].innerHTML = num+unit+convert;
});

window['updateSlider_'+inc].noUiSlider.on('change', function( values, handle ) { 
     var num= Number.isInteger(increment) ? Number(values[handle]) : values[handle];
      var convert= unit2 !== '' && factor !=='1' ?'  &nbsp;'+(parseFloat(num*factor).toFixed(2))+unit2:'';
	window['updateSliderValue_'+inc].innerHTML = num+unit+convert;
	window['updateinput_'+inc].style.visibility='visible';
	window['updateinput_'+inc].setAttribute('type','hidden');
	window['updateinput_'+inc].value=num;
     if (document.getElementById('slider-checkbox_'+inc)) 
          window['updateslidercheck_'+inc].checked=false;
});
window['updateSlider_'+inc].noUiSlider.on('change', function( values, handle ) { 
          if (nextincrement>0){ 
               document.getElementById('button-refine-slide_'+inc).classList.remove('hide');
               var current = values[handle];
               window['updatenoUiSlidermin_'+inc]=Math.max(datarange1,+current-75*nextincrement);
               window['updatenoUiSlidermax_'+inc]=Math.min(datarange2,+current+75*nextincrement);
               window['updatenoUiSliderincrement_'+inc]=nextincrement; 
               }
     });
}

function updateSliderRange(inc) { 
	window['updateSlider_'+inc].noUiSlider.updateOptions({
		range: {
			'min': window['updatenoUiSlidermin_'+inc],
			'max': window['updatenoUiSlidermax_'+inc]
		},
          
     step: window['updatenoUiSliderincrement_'+inc]
	});
} 
</script>
eol;
}
#tinymce	
function tinymce(){  
//function tinymce_4_4_dev 
           
	$style=Cfg_loc::Root_dir.'styling/'.$this->pagename.'.css';
	$script=Cfg_loc::Root_dir.'scripts/tinymce/js/tinymce/tinymce.dev.js';
	$return='/\r?\n/g';
	
	echo <<<eol

<script  src="$script"></script>
  <script >
	 <!--Tiny MCE: by Ephox-->
  tinymce.init({
	setup: function (editor) {
		editor.on('BeforeSetContent', function (contentEvent) {
		contentEvent.content = contentEvent.content.replace($return, '<br>'); 
		})   
		},
    selector: '.enableTiny',  
	inline: true,
	entity_encoding : "raw",//disable
	
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
function load_slippry(){
	static $enter=0; $enter++; if ($enter >1)return;
	$scriptdir=Cfg_loc::Root_dir.Cfg::Script_dir.'slippry.js';
	echo '<script  src="'.$scriptdir.'"></script>';
	}
function load_masonry(){
	if ($this->edit)return;
	static $enter=0; $enter++; if ($enter >1)return;
	$scriptdir=Cfg_loc::Root_dir.Cfg::Script_dir.'masonry.js';
	echo '<script  src="'.$scriptdir.'"></script>';
	$scriptdir=Cfg_loc::Root_dir.Cfg::Script_dir.'imagesLoaded.js';
	echo '<script  src="'.$scriptdir.'"></script>';
	}
function load_photoswipe(){
	if ($this->edit)return;
	static $enter=0; $enter++; if ($enter >1)return;
	$scriptdir=Cfg_loc::Root_dir.Cfg::Script_dir.'photoswipe.js';
	$scriptdir2=Cfg_loc::Root_dir.Cfg::Script_dir.'photoswipe-ui-default.js';
	echo '<script  src="'.$scriptdir.'"></script>';
	echo '<script  src="'.$scriptdir2.'"></script>';
	}
function render_highslide(){    
	static $enter=0; $enter++; if ($enter >1)return;
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
function render_header_open(){ if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	$load=new fullloader();
	$load->fullpath($this->header_type);
	if ($this->meta_data)echo '
<meta name="keywords" content="'.$this->keywords.'">
<meta name="description" content="'. $this->metadescription . '">
';
//<script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
	echo '
<link rel="shortcut icon" href="'.Cfg_loc::Root_dir.Cfg::Favicon.'"> ';
     if (Sys::Info||$this->edit){
          printer::printx( "\n".'<link href="'.$this->roots.Cfg::Style_dir.'displayCurrent.css" rel="stylesheet" type="text/css">');
          }
	if (isset($_GET['magnify_margins']))
          printer::printx('<style>
     .column.edit{margin:2px !important;padding:2px !important;border-width: 4px !important;}</style>');
	if (!empty($this->page_head)) 
		printer::printx( "\n".$this->page_head);
		printer::printx( "\n".'<link href="'.$this->roots.Cfg::Style_dir.$this->css_suffix.$this->pagename.'.css?'.rand(0,32323).'" rel="stylesheet" type="text/css">'); 
		printer::printx( "\n".'<link href="'.$this->roots.Cfg::Style_dir.$this->pagename.'_paged.css?'.rand(0,32323).'" rel="stylesheet" type="text/css">');
		printer::printx( "\n".'<link href="'.$this->roots.Cfg::Style_dir.$this->pagename.'_mediacss.css?'.rand(0,32323).'" rel="stylesheet" type="text/css">');  
		(Sys::Advanced||!$this->edit||(!Sys::Advancedoff&&$this->page_options[$this->page_advanced_index]!=='disabled'))&&printer::printx( "\n".'<link href="'.$this->roots.Cfg::Style_dir.$this->pagename.'_adv.css?'.rand(0,32323).'" rel="stylesheet" type="text/css">');
		($this->edit)&&printer::printx( "\n".'<link href="'.$this->roots.Cfg::Style_dir.$this->pagename.'pageedit.css?'.rand(0,32323).'" rel="stylesheet" type="text/css">');
		 ($this->edit)&&printer::printx("\n".'<link href="'.Cfg_loc::Root_dir.$this->css_fonts_extended_dir.'"  rel="stylesheet" type="text/css">');

		($this->edit)&&printer::printx( "\n".'<link href="'.$this->roots.Cfg::Style_dir.$this->pagename.'editoverride.css?'.rand(0,32323).'" rel="stylesheet" type="text/css">'); 
		($this->edit)&&printer::printx( "\n".'<link href="'.$this->roots.Cfg::Style_dir.'gen_edit.css?'.rand(0,32323).'" rel="stylesheet" type="text/css">');
		echo '
		<link href="'.$this->roots.Cfg::Style_dir.'gen_page.css" rel="stylesheet" type="text/css">
		    ';
	$page_array=array();
	if (is_file(Cfg_loc::Root_dir.Cfg::Data_dir.'page_stylesheet_'.$this->pagename)){ 
		$csspage=explode(',',file_get_contents(Cfg_loc::Root_dir.Cfg::Data_dir.'page_stylesheet_'.$this->pagename));
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
			<link href="'.$this->roots.Cfg::Style_dir.$page.'.css?'.rand(0,32323).'" rel="stylesheet" type="text/css"> 
			<link href="'.$this->roots.Cfg::Style_dir.$page.'_mediacss.css?'.rand(0,32323).'" rel="stylesheet" type="text/css">';
		 ($this->edit)&& print '
			  <link href="'.$this->roots.Cfg::Style_dir.$page.'editoverride.css?'.rand(0,32323).'" rel="stylesheet" type="text/css">';
					((Sys::Advanced||!$this->edit)||(!Sys::Advancedoff&&$this->page_options[$this->page_advanced_index]!=='disabled') )&&printer::printx("\n". '<link href="'.$this->roots.Cfg::Style_dir.$page.'_adv.css?'.rand(0,32323).'" rel="stylesheet" type="text/css">'); 
		}
	if (is_file(Cfg_loc::Root_dir.Cfg::Data_dir.'page_stylesheet_'.$this->pagename.$this->passclass_ext)&&!empty($this->passclass_ext)){//here we are doubling up to replace the former with the current if it has been rendered  otherwise we need to iframe_generate the pages of clone originals
		$csspage=explode(',',file_get_contents(Cfg_loc::Root_dir.Cfg::Data_dir.'page_stylesheet_'.$this->pagename.$this->passclass_ext));
		if (count($csspage)>0){ 
			foreach ($csspage as $page){
				if(strlen($page)>2){
					(Sys::Advanced||!$this->edit||(!Sys::Advancedoff&&$this->page_options[$this->page_advanced_index]!=='disabled') )&&printer::printx( '<link href="'.$this->roots.Cfg::Style_dir.$page.'_adv.css?'.rand(0,32323).'" rel="stylesheet" type="text/css">');
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
     if ($this->edit&&!empty($this->header_edit_style)){
		$this->header_edit_style=(!is_array($this->header_edit_style))?explode(',',$this->header_edit_style):$this->header_edit_style;    
		foreach($this->header_edit_style as $var){  
		    if (!empty($var)){
				echo'
				<link href="'.$this->roots.Cfg::Style_dir.$var.'?'.rand(0,32323).'" rel="stylesheet" type="text/css">'; 
				}
			}
		}
	($this->edit)&&$this->initnoUiSlider(); //javascript slider
	if (!empty($this->header_script_function)){#note that the standard pagename script will be dumped here...!!
	    $this->header_script=(!is_array($this->header_script))?explode(',',$this->header_script):$this->header_script;    
	    $this->header_script[]='gen_Procscripts.js?'.rand(0,32323); //     
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
	if (!$this->edit&&!empty($this->header_script_webmode)){ 
		$this->header_script=(!is_array($this->header_script))?explode(',',$this->header_script):$this->header_script;    
		 foreach ($this->header_script as $var){
	   	if (!empty($var)){
			    echo ' 
			    <script  src="'.$this->roots.Cfg::Script_dir.$var.'?'.rand(0,32323).'"></script> ';
			    }
			}
		 }
	if ($this->edit){
	    echo '<title>Edit ' .$this->page_title .'</title>';  
		}
	else {
		echo'
		<title> '.$this->page_title .'</title>';
		} 
 $this->header_insert();
	$this->header_global();
    }
function header_global(){
	return;
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
	//use site_master.class function to prevent updating erasage
	}	 

function render_message(){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__); 
    
   }
  

    
function call_body(){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	if($this->edit){ 
		echo '<body id="'.$this->pagename.'" class="editcoldefault '.$this->pagename.'" '.$this->edit_onload.'>';
          $this->echo_msg();#actually called in edit_body #drop in success message after nav
		$this->uploads();
          } 
	else 
	    echo '<body id="'.$this->pagename.'" class="'.$this->pagename.'" '.$this->onload.'>';
	(isset($_GET['iframepos']))&&printer::alertx('<p class="smallest cursor Od3navy fs2green rad5 floatleft whitebackground navy"><a href="'.request::return_full_url().'"><u>'.request::return_full_url().'</u></a></p>');
		$this->background_video('page_style');
		if ($this->edit&&Sys::Pass_class&&Sys::Viewdb){
			$this->print_wrap('restore opts','white redbackground Os3salmon fsminfo');
			printer::alert_neg('Viewing Database: '.Sys::Dbname);
			printer::alert_neu('Use Normal Edit Page Navigations to Check Pages. Use Restore Link Below to Restore entire web Page as needed');
			$pagename=check_data::dir_to_file(__METHOD__,__LINE__,__FILE__,$this->pagename); 
			$pagename=($pagename)?$pagename:'index'; 
			$file='./'.$pagename.'.php?viewdboff';
			printer::alert_neu('Return Back to <a class="acolor click" href="'.$file.'"> Normal Edit Page</a>');
			$file='../'.$pagename.'.php?viewdb';
			printer::alert_neu('View this restore choice page in <a class="acolor click" href="'.$file.'">View Restore as regular Webpage</a>');
			$file='./'.$pagename.'.php?viewdboff&amp;page_restore_dbopt';
			
			list($fname,$time)=explode('@@',$_SESSION[Cfg::Owner.'db_to_restore']);
			if (!Sys::Home_pub.Cfg::Backup_dir.$fname)$fname=str_replace('.gz','',$fname);
			$msg='Restore this Previous Website replacing the current Db';
			$msg1=' from TimeAgo: '.$this->get_time_ago($time).'&nbsp; Date: '.date("dMY-H-i-s",$time).'&nbsp;Filename: '.$fname.'&nbsp; Size: '.(filesize(Sys::Home_pub.Cfg::Backup_dir.$fname)/1000).'Kb';
			printer::alert_neg('<a class="acolor click" onclick="return gen_Proc.confirm_click(\'Confirm if you wish to '.$msg.' \');" href="'.$file.'">Restore this Webite </a>'.$msg1);
			printer::close_print_wrap('restore opts');
			}
		elseif (Sys::Pass_class&&Sys::Viewdb){
			$this->print_wrap('restore opts','white redbackground  fsminfo');
			printer::alert_neg('Viewing Database: '.Sys::Dbname);
			$pagename=check_data::dir_to_file(__METHOD__,__LINE__,__FILE__,$this->pagename); 
			$pagename=($pagename)?$pagename:'index'; 
			$file=Cfg_loc::Root_dir.Cfg::PrimeEditDir.$pagename.'.php';
			printer::alert_neu('Return Back to <a class="acolor click" href="'.$file.'">View Restore Db Edit Page</a>');
			//printer::alert_neu('<a class="acolor click" href="'.Sys::Self.'?viewdboff">Return Back to Normal WebPages</a>');
			printer::close_print_wrap('restore opts');  
			}
	} 

     function update_db($dbname=''){
     if (!$this->edit)return;
      $table_array=array('master_post','master_post_css','master_post_data');
     /*foreach ($table_array as $table ){
          $q="ALTER TABLE $table CHANGE blog_data1 blog_data1 text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;";
          $r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
          $q="UPDATE $table SET `blog_table` = REPLACE(`blog_table`, '_post', '_col') WHERE `blog_table` LIKE '%_post%'";
          $r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
          $q="UPDATE $table SET `blog_table` = REPLACE(`blog_table`, '_blog', '_col_id') WHERE `blog_table` LIKE '%_blog%'";
          $r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
          }*/
     if(!isset($_POST['submit']))return;
     if (!empty($dbname)) 
          $this->mysqlinst->dbconnect($dbname);
      else return;//return if not backup restore or viewing external theme db
     $this->express[]=printer::alert_neu('Database fields being updated mode',1,1); 
     $q="UPDATE master_col_data SET col_table = REPLACE(col_table, '_post_', '_col_') WHERE col_table LIKE '%_post_%'";
     $r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
     $columns_array=array('col_id'=>'key','col_table_base'=>'tinytext','col_table'=>'tinytext','col_num'=>'tinyint(4)','col_primary'=>'tinyint(1)','col_options'=>'text','col_clone_target'=>'tinytext','col_status'=>'tinytext','col_gridspace_right'=>'tinytext','col_gridspace_left'=>'tinytext','col_flex_box'=>'tinytext','col_grid_width'=>'tinytext','col_grid_clone'=>'tinytext','col_style'=>'text','col_style2'=>'tinytext','col_temp'=>'tinytext','col_grp_bor_style'=>'text','col_comment_style'=>'text','col_date_style'=>'text','col_comment_date_style'=>'text','col_comment_view_style'=>'text','col_clone_target_base'=>'tinytext','col_hr'=>'tinytext','col_update'=>'tinytext','col_width'=>'tinytext','col_tcol_num'=>'decimal(5,1)','token'=>'tinytext','col_time'=>'tinytext');
     $master_col_css_array=array('css_id'=>'smallint(5) unsigned','col_id'=>'tinytext','col_table_base'=>'tinytext','col_table'=>'tinytext','col_num'=>'tinyint(4)','col_primary'=>'tinyint(1)','col_options'=>'tinytext','col_clone_target'=>'tinytext','col_status'=>'tinytext','col_gridspace_right'=>'tinytext','col_gridspace_left'=>'tinytext','col_grid_width'=>'tinytext','col_grid_clone'=>'tinytext','col_flex_box'=>'tinytext','col_style'=>'text','col_style2'=>'tinytext','col_temp'=>'tinytext','col_grp_bor_style'=>'text','col_comment_style'=>'text','col_date_style'=>'text','col_comment_date_style'=>'text','col_comment_view_style'=>'text','col_clone_target_base'=>'tinytext','col_hr'=>'tinytext','col_update'=>'tinytext','col_width'=>'tinytext','col_tcol_num'=>'decimal(5,1)','token'=>'tinytext','col_time'=>'tinytext');

     $master_page_array=array('page_id'=>'key','page_ref'=>'tinytext','page_title'=>'tinytext','page_filename'=>'tinytext','page_width'=>'smallint(6)','page_pic_quality'=>'tinyint(4)','page_style'=>'text','page_custom_css'=>'tinytext','page_head'=>'text','keywords'=>'tinytext','metadescription'=>'tinytext','page_data1'=>'text','page_data2'=>'text','page_update'=>'tinytext','page_data3'=>'text','page_data4'=>'text','page_data5'=>'text','page_data6'=>'text','page_data7'=>'text','page_data8'=>'text','page_data9'=>'text','page_data10'=>'text','use_tags'=>'tinyint(4)','page_options'=>'text','page_break_points'=>'tinytext','page_cache'=>'tinytext','page_dark_editor_value'=>'text','page_light_editor_value'=>'text','page_dark_editor_order'=>'text','page_light_editor_order'=>'text','page_comment_style'=>'text','page_date_style'=>'text','page_comment_date_style'=>'text','page_comment_view_style'=>'text','page_style_day'=>'text','page_style_month'=>'text','page_grp_bor_style'=>'text','page_hr'=>'tinytext','page_h1'=>'text','page_h2'=>'text','page_h3'=>'text','page_h4'=>'text','page_h5'=>'text','page_h6'=>'text','page_myclass1'=>'text','page_myclass2'=>'text','page_myclass3'=>'tinytext','page_myclass4'=>'text','page_myclass5'=>'text','page_myclass6'=>'text','page_myclass7'=>'text','page_myclass8'=>'text','page_myclass9'=>'text','page_myclass10'=>'text','page_myclass11'=>'text','page_myclass12'=>'text','page_tiny_data1'=>'tinytext','page_tiny_data2'=>'tinytext','page_tiny_data3'=>'tinytext','page_tiny_data4'=>'tinytext','page_tiny_data5'=>'tinytext','page_tiny_data6'=>'tinytext','page_tiny_data7'=>'tinytext','page_tiny_data8'=>'tinytext','page_tiny_data9'=>'tinytext','page_tiny_data10'=>'tinytext','page_clipboard'=>'text','page_link'=>'text','page_link_hover'=>'text','page_time'=>'tinytext','token'=>'tinytext');
     $master_post_array=array('blog_id'=>'key','blog_col'=>'mediumint(11) unsigned','blog_order'=>'smallint(5) unsigned','blog_type'=>'tinytext','blog_table'=>'tinytext','blog_gridspace_right'=>'tinytext','blog_gridspace_left'=>'tinytext','blog_grid_width'=>'tinytext','blog_flex_box'=>'tinytext','blog_data1'=>'text','blog_data2'=>'text','blog_data3'=>'text','blog_data4'=>'text','blog_data5'=>'text','blog_data6'=>'text','blog_data7'=>'text','blog_data8'=>'text','blog_data9'=>'text','blog_data10'=>'text','blog_data11'=>'text','blog_data12'=>'text','blog_data13'=>'text','blog_data14'=>'text','blog_data15'=>'text','blog_tiny_data1'=>'tinytext','blog_tiny_data2'=>'tinytext','blog_tiny_data3'=>'tinytext','blog_tiny_data4'=>'tinytext','blog_tiny_data5'=>'tinytext','blog_tiny_data6'=>'tinytext','blog_tiny_data7'=>'tinytext','blog_tiny_data8'=>'tinytext','blog_tiny_data9'=>'tinytext','blog_tiny_data10'=>'tinytext','blog_tiny_data11'=>'tinytext','blog_tiny_data12'=>'tinytext','blog_tiny_data13'=>'tinytext','blog_tiny_data14'=>'tinytext','blog_tiny_data15'=>'tinytext','blog_grid_clone'=>'tinytext','blog_style'=>'text','blog_style2'=>'tinytext','blog_table_base'=>'tinytext','blog_text'=>'text','blog_border_start'=>'tinytext','blog_border_stop'=>'tinytext','blog_global_style'=>'tinytext','blog_date'=>'tinytext','blog_width'=>'tinytext','blog_width_mode'=>'tinytext','blog_status'=>'tinytext','blog_unstatus'=>'tinytext','blog_clone_target'=>'tinytext','blog_target_table_base'=>'tinytext','blog_clone_table'=>'tinytext','blog_float'=>'tinytext','blog_unclone'=>'tinytext','blog_tag'=>'tinytext','blog_options'=>'text','blog_update'=>'tinytext','blog_pub'=>'tinyint(4)','blog_temp'=>'mediumint(5) unsigned','blog_time'=>'tinytext','token'=>'tinytext');
     $master_post_css_array=array('css_id'=>'key','blog_id'=>'tinytext','blog_orig_val_id'=>'tinytext','blog_col'=>'mediumint(11) unsigned','blog_order'=>'smallint(5) unsigned','blog_type'=>'tinytext','blog_table'=>'tinytext','blog_gridspace_right'=>'tinytext','blog_gridspace_left'=>'tinytext','blog_grid_width'=>'tinytext','blog_data1'=>'text','blog_data2'=>'text','blog_data3'=>'text','blog_data4'=>'text','blog_data5'=>'text','blog_data6'=>'text','blog_data7'=>'text','blog_data8'=>'text','blog_data9'=>'text','blog_data10'=>'text','blog_data11'=>'text','blog_data12'=>'text','blog_data13'=>'text','blog_data14'=>'text','blog_data15'=>'text','blog_tiny_data1'=>'tinytext','blog_tiny_data2'=>'tinytext','blog_tiny_data3'=>'tinytext','blog_tiny_data4'=>'tinytext','blog_tiny_data5'=>'tinytext','blog_tiny_data6'=>'tinytext','blog_tiny_data7'=>'tinytext','blog_tiny_data8'=>'tinytext','blog_tiny_data9'=>'tinytext','blog_tiny_data10'=>'tinytext','blog_tiny_data11'=>'tinytext','blog_tiny_data12'=>'tinytext','blog_tiny_data13'=>'tinytext','blog_tiny_data14'=>'tinytext','blog_tiny_data15'=>'tinytext','blog_grid_clone'=>'tinytext','blog_style'=>'text','blog_style2'=>'tinytext','blog_table_base'=>'tinytext','blog_text'=>'text','blog_border_start'=>'tinytext','blog_border_stop'=>'tinytext','blog_global_style'=>'tinytext','blog_date'=>'tinytext','blog_width'=>'tinytext','blog_flex_box'=>'tinytext','blog_width_mode'=>'tinytext','blog_status'=>'tinytext','blog_unstatus'=>'tinytext','blog_clone_target'=>'tinytext','blog_target_table_base'=>'tinytext','blog_clone_table'=>'tinytext','blog_float'=>'tinytext','blog_unclone'=>'tinytext','blog_tag'=>'tinytext','blog_options'=>'tinytext','blog_update'=>'tinytext','blog_pub'=>'tinyint(4)','blog_temp'=>'mediumint(5) unsigned','blog_time'=>'tinytext','token'=>'tinytext');
     $master_post_data_array=array('data_id'=>'key','blog_id'=>'tinytext','blog_orig_val_id'=>'tinytext','blog_col'=>'mediumint(11) unsigned','blog_order'=>'smallint(5) unsigned','blog_type'=>'tinytext','blog_table'=>'tinytext','blog_gridspace_right'=>'tinytext','blog_gridspace_left'=>'tinytext','blog_grid_width'=>'tinytext','blog_adv_media'=>'tinytext','blog_data1'=>'text','blog_data2'=>'text','blog_data3'=>'text','blog_data4'=>'text','blog_data5'=>'text','blog_data6'=>'text','blog_data7'=>'text','blog_data8'=>'text','blog_data9'=>'text','blog_data10'=>'text','blog_data15'=>'text','blog_data11'=>'text','blog_data12'=>'text','blog_data13'=>'text','blog_data14'=>'text','blog_tiny_data1'=>'tinytext','blog_tiny_data2'=>'tinytext','blog_tiny_data3'=>'tinytext','blog_tiny_data4'=>'tinytext','blog_tiny_data5'=>'tinytext','blog_tiny_data6'=>'tinytext','blog_tiny_data7'=>'tinytext','blog_tiny_data8'=>'tinytext','blog_tiny_data9'=>'tinytext','blog_tiny_data10'=>'tinytext','blog_tiny_data11'=>'tinytext','blog_tiny_data12'=>'tinytext','blog_tiny_data13'=>'tinytext','blog_tiny_data14'=>'tinytext','blog_tiny_data15'=>'tinytext','blog_grid_clone'=>'tinytext','blog_style'=>'text','blog_style2'=>'tinytext','blog_table_base'=>'tinytext','blog_text'=>'text','blog_border_start'=>'tinytext','blog_border_stop'=>'tinytext','blog_global_style'=>'tinytext','blog_date'=>'tinytext','blog_width'=>'tinytext','blog_width_mode'=>'tinytext','blog_flex_box'=>'tinytext','blog_status'=>'tinytext','blog_unstatus'=>'tinytext','blog_clone_target'=>'tinytext','blog_target_table_base'=>'tinytext','blog_clone_table'=>'tinytext','blog_float'=>'tinytext','blog_unclone'=>'tinytext','blog_tag'=>'tinytext','blog_options'=>'tinytext','blog_update'=>'tinytext','blog_pub'=>'tinyint(4)','blog_temp'=>'mediumint(5) unsigned','blog_time'=>'tinytext','token'=>'tinytext');
$backups_db_array=array('backup_id'=>'key','backup_filename'=>'tinytext','backup_time'=>'tinytext','backup_date'=>'tinytext','backup_restore_time'=>'tinytext','backup_data1'=>'tinytext','token'=>'tinytext');
     $table_array=array('master_page'=>'page_style','columns'=>'col_style','master_col_css'=>'col_style','master_post'=>'blog_style','master_post_css'=>'blog_style','master_post_data'=>'blog_style','backups_db'=>'backup_time');
     $char_arr=array('text','char','blob');
     foreach ($table_array as $table => $table_field){
          $q = "SHOW COLUMNS FROM $table";  
          $rx = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
          if (!$this->mysqlinst->affected_rows())continue;
          $page_list=array();
          while($row = mysqli_fetch_array($rx)){
               $page_list[$row['Field']]=$row['Type'];
               #page_list[' field name' ]=Type text or Int etc.
               #creates actual list of what is present vs. the array archetypes
               } 
          foreach (${$table.'_array'} as $field => $type){
                $character=(in_array($type,$char_arr))?'CHARACTER SET utf8 COLLATE utf8_bin':'';
               $after=(array_key_exists($table_field,$page_list))?"AFTER $table_field":''; 
               if ($type=='key'&&!array_key_exists($field,$page_list)){ 
                    $q="ALTER TABLE `$table` ADD `$field` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (`$field`)";echo $q;
                    $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
                    }
               elseif (!array_key_exists($field,$page_list)){
                   $q="ALTER TABLE `$table` ADD `$field` $type $character NOT NULL $after";
                    $this->express[]=printer::alert_neg("updating missing field: $q",1,1);
                    $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
                    }
               elseif($type!=='key'&&${$table.'_array'}[$field]!==$page_list[$field]){
                    #if field type does not match
                    $q="ALTER TABLE $table CHANGE $field $field $type $character NOT NULL;";
                    $this->express[]=printer::alert_neg("updating field type: $q",1,1);
                    $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
                    }
               }
          foreach ($page_list as $field => $type){
               if (!array_key_exists($field,${$table.'_array'})){
                    $q="ALTER TABLE $table DROP $field;";
                    $this->express[]=printer::alert_neg('<span class="info">dropping</span> extra field:'. $q,1,1);
                    $r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
                    }
               }//field foreach   
          }//table foreach
     if (!$this->edit)return;
     $q="SHOW COLUMNS FROM master_post_data"; 
     $r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); 
     $field_arr=array();
     while ($rows=$this->mysqlinst->fetch_assoc($r,__LINE__)){
          $field_arr[]=$rows['Field'];   
          }
     if (!in_array('blog_orig_val_id',$field_arr)){ 
          $q="ALTER TABLE `master_post_data` ADD `blog_orig_val_id` TINYTEXT NOT NULL AFTER `blog_id`";
           $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
          $q="ALTER TABLE `master_post_css` ADD `blog_orig_val_id` TINYTEXT NOT NULL AFTER `blog_id`";
          $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
          $q="update master_post_data set blog_orig_val_id=REPLACE(`blog_id`, 'p', '')";
          $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
           $q="update master_post_data set blog_orig_val_id=REPLACE(`blog_id`, 'p', '')";
          $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
           $q="update master_post_css set blog_orig_val_id=REPLACE(`blog_id`, 'p', '')";
          $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
          }
     if (!empty($dbname)) 
          $this->mysqlinst->dbconnect(Sys::Dbname); 
           
     }//end update_db
     
function echo_msg(){  if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	 if (count($this->storeinst->msg)>0){
		foreach ($this->storeinst->msg as $msg){
			echo NL.$msg;
			}
		}
	if (isset($_POST['submit'])){
		if (count($this->message)>0||count($this->success)>0){
			$this->mailinst->mailwebmaster($this->success,$this->message);
			}
		}
	 
	if  (isset($_SESSION[Cfg::Owner.'update_msg'])&&!empty($_SESSION[Cfg::Owner.'update_msg'])&&!isset($_POST['submit'])){ //here we dont display on submit but when reaching destructor function we refresh page ie. new page will not be submitted. 
	 
		$mymessages=array_unique($_SESSION[Cfg::Owner.'update_msg']);
		echo '<div class="fs1redAlert"><!--outerwrap message alerting-->';
		echo '<div class="fsminfo whitebackground"><!--innerwrap message alerting-->';
		printer::printx('<p class="fsmred editbackground  editfont info floatleft large">Hit the Browser Refresh Button <a href="'.Sys::Self.'">  <img src="'.Cfg_loc::Root_dir.'refresh_button.png" alt="refresh button" width="20" height="20"> once or twice to Insure All New Styles are Updated!!</a></p>');
		printer::pclear();
		print '<div class="fs2navy left large p10all editbackground  editfont maxwidth700"><!--Alert Messages--> ';
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
          echo '<p id="bottom"></p>';
		}
	 
	//if (!$this->edit&&!empty($this->add_container))echo '</div><!--addcontainerinner--></div><!--addcontainer-->';
	else ($this->edit)&& printer::alert('bottom view');//
	(Sys::Logged_in&&$this->edit)&&printer::alert_neu('<a href="'.Sys::Self.'?logout">logout as admin</a>');
	(Sys::Logged_in&&$this->edit)&&printer::alert_neu('<a href="'.Sys::Self.'?changepass">change your password</a>');
	(Sys::Logged_in&&$this->edit)&&printer::pspace(50);
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
     if (is_file(Cfg_loc::Root_dir.Cfg::Include_dir.'navigate_loc.class.php'))
         $this->navobj=navigate_loc::instance();
    else $this->navobj=navigate::instance();
    $this->navobj->put('ext',$this->ext);
    $this->navobj->put('pagename',$this->pagename);
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
function print_redwrap($msg,$main=false){
	//$color=($main===true)?'moccasin':$this->column_lev_color;
	$color=$this->column_lev_color;
	printer::print_redwrap($msg,$this->column_lev_color);
	}
     
function print_wrap($msg,$main=false){
	//$color=($main===true)?'moccasin':$this->column_lev_color;
	$color=$this->column_lev_color;
	printer::print_wrap($msg,$color,$main);
	}
     
function close_print_wrap($msg,$spacer=true){
	printer::close_print_wrap($msg,$spacer);
	}

function show_more($msg_open,$msg_var='',$class='',$title='',$width=800,$showwidth='',$styledirect='float:left;',$mainstyle=false,$background='editbackground editfont'){ if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__); 
	#msg_var key:  
	# $mainstyle true is equivalent to msg_var='main' and is used currently similiar to msg var ...
	# $msg_var='slow' slow open/close hidden element
	#msg_var strpos span html styling which substitutes into open without affecting html.
	#msg_var= 'main2'   bypasses current width setting. Used for secondary master menu of menus  Similar to mainstyle true without the positioning;
	#msg_var='asis' returns without any fullwidth manipulation
	 #msg_var buffer...  used to initate buffer output capture
	 
	$width=(!empty($width)&&$width>50)?$width:(($width==='full')?'full':0); 
	$this->show_more++; //echo 'show more is '.$this->show_more;
     $class=(empty($class))?$this->column_lev_color.' floatleft editfont editbackground button'.$this->column_lev_color:$class;
     if($this->is_page)$class=str_replace('button'.$this->column_lev_color,'buttoneditcolor',$class); 
	$msg_open_mod=$msg_open;
	if (strpos($msg_var,'<span')!==false){ // this way msg_open_mod can be correct  js version without <> and msg open read with span and html tags
		$msg_open=$msg_var;
		$msg_var='';
		}
	$lesswidth=($this->current_net_width<80)?5:20;
	$zstyle='';//'position:relative;';
	 
	$stylewidth='style="'.$zstyle.'"';(!empty($showwidth))?'style="'.$zstyle.'max-width:'.$showwidth.$styledirect.'"':((isset($this->current_net_width)&&!empty($this->current_net_width))?'style="'.$zstyle.'max-width:'.($this->current_net_width-$lesswidth).'px;'.$styledirect.'"':(!empty($styledirect)?'style="'.$zstyle.$styledirect.';"':''));
	$floatleft=(strpos($class,'float')===false)?'floatleft':'';
     $onClick=(strpos($msg_var,'buffer')!==false&&!Sys::Nobuffer)?'gen_Proc.use_ajax(\''.Sys::Self.'?bufferOutput='.$msg_var.'\',\'handle_replace\',\'get\');':'';
     $id=(strpos($msg_var,'buffer')!==false&&!Sys::Nobuffer)?$msg_var:'show'.$this->show_more;
    echo '<p class="clear '.$floatleft.' left underline  shadowoff cursor '.$class.'" title="'.$title.'" '.$stylewidth.'  onclick="gen_Proc.show(\''.$id.'\',\''.$msg_open_mod.'\',\''.$msg_var.'\',\''.$width.'\', \''.$mainstyle.'\');'.$onClick.'" id="'.$id.'">'.$msg_open.'</p>';
    printer::pclear();
    echo '<div class="clear floatleft '.$background.' left"   id="'.$id.'t" style="display: none; '.$styledirect.'"><!--'.$msg_open_mod.'-->';
     $type=($this->is_page)?' is page and '.$msg_open:(($this->is_column)?' is column id '.$this->col_id.' '.$msg_open:' is blog and id is '.$this->blog_id. '  '.$msg_open); 
    if (strpos($msg_var,'buffer')!==false&&!Sys::Nobuffer){ 
           ob_start();
          }
    }
 
function show_close($ref='',$buffer=''){
     if(strpos($buffer,'buffer')!==false&&!Sys::Nobuffer){
          $text=ob_get_clean();
          process_data::write_to_file(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Buffer_dir.'output_'.$buffer.$this->pagename.'.dat',$text,true,false,Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Buffer_dir);  
          }  
     echo '</div><!--Close '.$ref.'-->'; 
	}
     
function plus($msg,$width=''){ if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	self::$pluscount++;  
	$full_width=(!empty($width)&&$width>50)?'fullWidth(id,'.$width.')':'';      
	$this->plus_msg=$msg;
	 echo '
	<p class="underline left shadowoff editbackground  editfont floatleft button'.$this->column_lev_color.' '.$this->column_lev_color.' editfont" style="max-width:'.($this->current_net_width-20).'px;">
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
	<p style="max-width:'.($maxwidth-20).'px;" class="underline shadowoff editbackground  editfont floatleft button'.$this->column_lev_color.' '.$this->column_lev_color.' editfont" id="plusmoddata'.self::$plusmod.'" onclick="plus(id,\''.$msg.'\');'.$full_width.';">'.$msg.
	'</p>';   
    printer::pclear(1);  
	echo ' <div class="hide"  id="plusmoddata'.self::$plusmod.'t"><!--'.$msg.' plus mod openplustrack'.self::$pluscount.'-->'; 
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

function update_arrays(){  
	if (Sys::Pass_class)return;
	if (!$this->edit)return;
     file_put_contents(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'sibling_id_arr_'.$this->pagename.'.dat',serialize($this->sibling_id_arr));
     file_put_contents(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'display_anchor_'.$this->pagename.'.dat',serialize($this->id_array));
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
		$file='image_info_'.$file.'_'.$this->pagename; 
		(!is_dir(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Image_info_dir))&&mkdir(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Image_info_dir,0755,1);
		if (!file_put_contents(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Image_info_dir.$file,serialize($current))){
			mail::alert('Problem Saving '.Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Image_info_dir.$file);
			}
		}
	}
	
function destructor(){// css is rendered to file before destructor 
	$this->update_arrays(); 
	$this->deltatime->delta_log('begin destructor');  
	echo '<div class="inline floatleft"><!-- float buttons-->';
	$msg='Advanced Style Css is Always Displayed On in Normal Webpage but toggled in the editor. Toggle here';
	if (!Sys::Advanced) 
		printer::printx('<p class="buttonnavymini highlight supertiny" title="'.$msg.'"> <a class="highlight click" href="'.Sys::Self.'?advanced">Enable Advanced Display</a></p>');
	else printer::printx('<p class="buttonnavymini highlight supertiny" title="'.$msg.'"> <a class="highlight click" href="'.Sys::Self.'?advancedoff">Disable Advanced Display</a></p>'); 
		echo '</div><!-- float buttons--><!--float button-->'; 
	if (isset($_GET['iframepos']))return;//the following unnecessary for updating css and flatfiles.
	if (Sys::Methods)   Sys::Debug(__LINE__,__FILE__,__METHOD__);if (Sys::Quietmode) return;
	if (isset($_POST['submit'])&&Sys::Norefresh){//printer::vert_print($this->backup_page_arr); 
		printer::print_request();
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
		}
	if (isset($_POST['submit'])){
		$this->success[]='Page Changes Have Been Submitted for Update';
		(!isset($_SESSION[Cfg::Owner.'update_msg']))&& $_SESSION[Cfg::Owner.'update_msg']=array();
		 if (count($this->success)>0){
			foreach($this->success as $msg){
				$_SESSION[Cfg::Owner.'update_msg'][]=NL.printer::alert_pos($msg,1,true);
				echo printer::alert_pos($msg,1);//this will print on bottom page iwth refreshoff
				}
			}
		if (count($this->message)>0){ 
			foreach($this->message as $msg){
				$_SESSION[Cfg::Owner.'update_msg'][]=NL.printer::alert_neg($msg,1,true);
				echo printer::alert_neg($msg,1);//this will print on bottom page iwth refreshoff
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
		if (count($this->write_to_file)>0){
               process_data::write_to_file(Cfg::Root_dir.'list_last.txt','begin',1,1);
               foreach ($this->write_to_file as $line){
                    process_data::write_to_file(Cfg::Root_dir.'list_last.txt',$line);
                    }
               }
		if (count($this->list)>0){
			print NL.'Collect List:'.NL;
			printer::vert_print($this->list);
			}
          if (Sys::Deltatime&&isset($_POST['submit'])&&!Sys::Norefresh){
               $_SESSION[Cfg::Owner.'update_msg'][]=printer::alert($this->deltatime->return_delta_log(),1,'small');
               }
		else if(Sys::Deltatime) printer::alert( $this->deltatime->return_delta_log());
	printer::pclear();
		}
	//check for unclones
	$q="select blog_id from $this->master_post_table where blog_unclone!='' and blog_unstatus='unclone' AND blog_table_base='$this->pagename'";  
	$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	$count=0;
	if ($this->mysqlinst->affected_rows()) {
		while(list($blog_id)=$this->mysqlinst->fetch_row($r,__line__,__method__)){#checking in array to remove valid unclones from list to find orphans
			if (in_array($blog_id,$this->current_unclone_table)) continue;
			$count++;
			}
		}
	if ($this->edit&&$count>0){  
		$this->styleoff=true;//redundant
		echo '<div class="editbackground  editfont width600 editfont fd5brightgreen" id="leftovers"><!--begin Unclone Orphans-->';
		$q="select blog_id,blog_col,blog_type,blog_order,blog_table,blog_data1 from $this->master_post_table where blog_unclone!='' and blog_unstatus='unclone' AND blog_table_base='$this->pagename'";  
		$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);	 
		if ($this->mysqlinst->affected_rows()) {
			printer::printx('<p class="fsminfo editbackground  editfont large editcolor width500">This is a list of <span class="info" title="leftover unclones are unclones of deleted parents previously cloned on this page"> leftover unclones </span> which you may Delete or Move elsewhere.</p>'); 
			while(list($blog_id,$blog_col,$blog_type,$blog_order,$blog_table,$blog_data1)=$this->mysqlinst->fetch_row($r,__line__,__method__)){
				$this->edit=false;
				 
				$data=$this->pagename.'_colId_'.$blog_col.'_postId_'.$blog_id;
				if (in_array($blog_id,$this->current_unclone_table)) continue;
				 echo '<div class="fs2aqua maxwidth500"><!--Wrap View-->';
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
				printer::printx('<p class="fs1black editbackground  editfont editcolor"><input type="checkbox" name="'.$name.'[]" value="'.$id.'">Check Here to Delete Orphaned Unclone Type: ' .str_replace('_',' ',strtoupper($this->blog_type)).' OR Use Id '.$post_prefix.$id.$msg.'  </p>');
				 $this->show_more('View '.$blog_type,'Close View');//show more View
				echo '<div style="max-width:500px" class="maxwidth500 fs2pos"><!--view unclone wrap-->';
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
						$this->blog_render($this->blog_data1,true,$this->pagename);		  
						}	 
					}//end nested column.... 
				echo '</div><!--view unclone wrap-->';
				$this->show_close();//show more View
				echo '</div><!--Wrap View-->'; 
				}//end while.. 
			echo '</div><!--begin Unclone Orphans-->'; 
			}//if affected rows
		$this->edit=true; //reset back after displaying orphaned unclones
		if ($count>0&&!isset($_SESSION[Cfg::Owner.'_'.$this->pagename.'_leftovers'])){
			echo '<script >
			gen_Proc.use_ajax(\''.Sys::Self.'?leftovers\',\'handle_replace\',\'get\'); 
			</script>
			';
		
			}
		if ($count==0)unset($_SESSION[Cfg::Owner.'_'.$this->pagename.'_leftovers']);
		else $_SESSION[Cfg::Owner.'_'.$this->pagename.'_leftovers']=true;
				
		}// if this edit...
	 
			
	($this->edit&&(Sys::Tables||Sys::Server))&&printer::vert_print($_SERVER);
	((Sys::Tables||Sys::Request))&&printer::print_request();
	($this->edit&&(Sys::Tables||Sys::Session))&&printer::vert_print($_SESSION);
	if ($this->edit&&Sys::Constants){
          $refl = new ReflectionClass('Sys');
          printer::vert_print($refl->getConstants());
          }
	if (store::getVar('backup_clone_refresh_cancel')){//cancel header redirect style refresh and allow iframes to complete
          $iframe_msg= (!isset($this->iframe_update_msg))?'Allowing for Data Update of Content in iframes to finish loading at top of this page':$this->iframe_update_msg;	
	
        #this is replaced with alert message to update when ready not everytime!!
          if (ob_get_contents()) {
                    $data = ob_get_contents();
                    ob_end_clean();
                     
                    printer::alert_neg($iframe_msg);
                    printer::alert_pos('<a style="font-size:25px;padding:10px;text-decoration:underline" href="'.Sys::Self.'">When Finished Click here to Refresh Page for Messages, etc. without resubmitting content</a>');
                    echo $data;
                    return;
                    }
          else printer::alert_neg('No ob get contents message');
          }
   
	if (Sys::Methods)   Sys::Debug(__LINE__,__FILE__,__METHOD__);
	#header
	 if(!isset($_POST['submit'])&&count($this->hidden_array)>0){
          $this->edit_form_end(); 
          $action=Sys::Self;
          echo '<form id="autosubmit" action="'.$action.'"  method="post">';
          $coll_hid=htmlentities(implode('@@',$this->hidden_array));
          foreach($this->hidden_array as $render){
               echo $render;
               }
          echo '<input type="hidden" name="submitted" value="true" >';
         
          $msg='autoform submitted update in ion destruc '. $coll_hid;
          $_SESSION[Cfg::Owner.'update_msg'][]=NL.printer::alert_pos($msg,1,true); 
          echo <<<eol
     <script>
      \$(function() {
     \$('#autosubmit').css('background','green');
           document.getElementById('autosubmit').submit();
     });
     </script>
eol;
          }
          
          
	if((!Sys::Debug&&!Sys::Norefresh&&(isset($_POST['submit'])||Sys::Bufferoutput))||isset($_GET['advanced'])||isset($_GET['advancedoff'])){ 
		ob_end_clean();#ob
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
	//if(!Sys::Debug&&!Sys::Norefresh&&(isset($_POST['submit'])||Sys::Bufferoutput)||isset($_GET['advanced'])||isset($_GET['advancedoff'])){//we are buffering output upon submit for a header( refresh) in order to refresh styling changes...
	if (ob_get_level()){//if not redirected by the header location redirect and if ob_start is true then buffer output automatically
		#editpages is output
		#buffer
		$data = ob_get_contents();#ob
		 ob_end_clean();
		 echo $data;
		 mail::alert('ob_get_contents bypassed header redirect');
		 //if (!file_put_contents(Sys::Home_pub.'bufferoutput.txt',$data)) mail::alert('buffer output data file failure');
		}
     printer::alert_pos(NL.'memory: '.memory_get_usage(),1.3);
	if (Sys::Methods)   Sys::Debug(__LINE__,__FILE__,__METHOD__);
	$this->deltatime->delta_log('end destructor');  
    }
    
    
    
    
    
    
				
#********************************BEGIN CSS FUNCTIONS**************************
#csscreate  #cssinit

function css_stylesheet_include(){
	$array=array_unique($this->page_stylesheet_inc);  
	$data= (count($array)>0)?implode(',',$array):''; 
	file_put_contents(Cfg_loc::Root_dir.Cfg::Data_dir.'page_stylesheet_'.$this->pagename.$this->passclass_ext,$data);
	}
	
		

function render_css(){  //accessed in edit mode only
	(Sys::Deltatime)&&$this->deltatime->delta_log(__line__.' @ '.__method__.'  '); 
	$this->css_stylesheet_include();//include stylesheets of non local clones
	if(!Sys::Style)return;
	$this->css_at_fonts();//gen specific local fonts and all for editpages 
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
	/*$this->css_grid='
	[class^="wid-bp"], [class*=" wid-bp-"],[class^="left-bp"], [class*=" left-bp-"],[class^="right-bp"], [class*=" right-bp-"] {
	float:left;  
	}';*/
    //display:inline-block ;vertical-align: middle;baseline;  not working
      foreach (array('wid','right','left')as $type){
			$this->{'grid_class_selected_'.$type.'_array'}=array_unique($this->{'grid_class_selected_'.$type.'_array'});
		}
		
	foreach(array_unique($this->column_grid_css_arr) as $arr){
		list($gu,$bpv)=explode('@@',$arr); 
		$punit=floor(100000/$gu)/1001;
		$width100=1000/1005*100;
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
#leave copy of custom functions here and put same function in site_master.class or page class in includes directory .. will override parent custom class..
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
	$font_ext=array('woff','woff2','ttf');
	$check=array(); 
	foreach($this->at_fonts as $af){   
		$af=explode(',',$af);
		$after=str_replace(' ','',$af[0]);
		if (!in_array($after,$check)){
			foreach($font_ext as $ext){ 
				if (is_file('../fonts/'.$after.'.'.$ext)){
					$type=($ext==='ttf')?'truetype':$ext;
			$this->fontcss.='
@font-face {
  font-family: \''.$af[0].'\';
  src: url(../fonts/'.$after.'.'.$ext.') format(\''.$type.'\');
}';
					break;
					} 
				}//foreach 
			$check[]=$after;  
			}//not in array
		}//foreach
	foreach($this->fonts_extended as $af){   
		$af=explode(',',$af);
		$after=str_replace(' ','',$af[0]); 
          foreach($font_ext as $ext){ 
               if (is_file('../fonts/'.$after.'.'.$ext)){
                    $type=($ext==='ttf')?'truetype':$ext;
          $this->editgencss.='
@font-face {
font-family: \''.$af[0].'\';
src: url(../fonts/'.$after.'.'.$ext.') format(\''.$type.'\');
}';
                     
                    } 
               }//foreach 
		}//foreach 
	}
 
function css_initiate(){
	$font=(!empty($this->master_font))?'font-family: '.$this->master_font.';':'';
	$color=(!empty($this->editor_color))?'color: #'.$this->editor_color.'; ':'color: #FF5900; ';
	/*   *:not(input):not(textarea) {
 -webkit-user-select: none !important;  
 -webkit-touch-callout: none !important;  
		}*/
     $this->initcss.='
	.editfontfamily {font-family:'.$this->edit_font_family.';} 
	.editfont {font-family:'.$this->edit_font_family.';text-shadow:none; text-align:left;font-size:'.($this->edit_font_size*16).'px;letter-spacing:0;}  
	#displayCurrentSize{padding:2px;z-index:10000000;} 
     @media screen and (max-width:1000px) and (min-width:600px){ 
          html .editfont #displayCurrentSize{font-size:12px;padding:0px;}
          }
     @media screen and (max-width:600px) {
          html body div #displayCurrentSize{font-size:18px;padding:0px;}
          html .editfont #displayCurrentSize{font-size:10px;padding:0px;}
          }
     .hidden{visibility:hidden;}     
	.hide{display:none;}		 
	#scrWid,#top_contain, #topmenu,#loadingsize,#displayCurrentSize{float:left;}
	#clientw,#clientw2{padding:0 5px;text-align:center;margin:0 auto;}
     *{-webkit-box-sizing: border-box;
      -moz-box-sizing: border-box;
      box-sizing: border-box; }}
         ul {list-style-type:none;}
         html, body, div, span, applet, object, iframe,
    h1, h2, h3, h4, h5, h6, p, blockquote, pre,
    a, abbr, acronym, address, big, cite, code,
    del, dfn, em, font, img, ins, kbd, q, s, samp,
    small, strike, strong, sub, sup, tt, var,
    dl, dt, dd, ol, ul, li,
    fieldset, form, label, legend,
    table, caption, tbody, tfoot, thead, tr, th, td {
         margin-top: 0;
         margin-bottom: 0;
         margin-right: 0;
         margin-left: 0;
         padding: 0;
         outline: 0;   
         vertical-align: baseline;
    }
    body h1,body h2, body h3,body h4,body h5,body h6{ 
         padding: 0;
         outline: 0;
         padding-bottom:0; 
         vertical-align: baseline;
    }
    body{font-size:16px;height:100%;margin-right:0px;margin-left:0px;}
    .show_arrow{opacity:.7; font-size:.6em;}
    .fixed{position:fixed;top:0;}
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
    /*from stackoverflow video iframe 100%*/
    .videoWrapper {
    position: relative;
    padding-bottom: 56.25%; /* 16:9 */
    padding-top: 25px;
    height: 0;
     }
.videoWrapper iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
     }
	.nav ul li {LIST-STYLE-TYPE: none;}
	a:link,a:visited,a:active,body ul a:link {text-decoration:none;}
	td, th {border-width:1px;  border-style:solid;}
	.border2{border-width:2px;}
	a:link.acolor, a:visited.acolor {text-decoration: underline;}
	a:link.acolor:hover,a.acolor:visited:hover,a.acolor:hover {color:blue}
	a:link.alistblue {background:#170F7E; color:#F7FDFF;  text-decoration:underline;}
	a:link.alist{text-decoration: underline;color:#5340D1;}
	 a:visited.alistblue {color:#9D97E3;}
	a:link.alistblue:hover, a.alistblue:visited:hover,a:link.alistblue:visited:hover, a.alistblue:visited:hover{color:blue}
	a:link.alist,a.alist:visited{text-decoration: underline;color:inherit;} 
	a:link.alist:hover,a.alist:visited:hover,a:link.alist:visited:hover,a.alist:visited:hover{color:blue}
	a:link.info,a:visited.link {color:#'.$this->info.';background:rgba(255,255,255,0.33)}
	a:link.click,a:visited.click {text-decoration: underline;padding:3px 3px;display:inline-block;text-align:left; cursor: pointer;  text-decoration: underline;}
	.click{padding:3px 3px;display:inline-block;text-align:left; cursor: pointer;  text-decoration: underline;}
	.navnavy {color:#'.$this->navy.'; text-shadow: -.8px -.8px  0.4px #ffffff;}
	.highlight,.highlight:visited{color:#'.$this->info.';font-style:italic;font-weight:500;}
	.navr1 a:link, .navr1 a:visited{color:#'.$this->navy.';}
	.navr1{display:inline-block; margin:  5px 0; font-size: 1em; background: #e6eff1; padding:  3px;
	color:#'.$this->navy.';
	-moz-border-radius:5px;
	   -webkit-border-radius:5px;
	   border-radius:5px; 
	   border: 2px  double #'.$this->navy.'}
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
	.height100 {height:100%;}
	.inherit{ color:inherit;background:inherit;}
    .alert_neg {color:#'.Cfg::RedAlert_color.';}
    .ramana{padding:.1em .5em;text-align:left; color:#'.$this->editor_color.';background:#'.$this->editor_background.'; display:inline-block;}
	.ramanaleft{padding:.1em .5em;color:#'.$this->editor_color.'; text-align: left;background:#'.$this->editor_background.'; display:inline-block;}
	a img { border: none;}
	input {line-height:125%;}
	.addheight{line-height:200%;}
	.heightauto{height:auto;}
	.whitebackground {background:#ffffff}
	 a:link, a:visited{color: inherit;}
	.link {text-decoration:underline;cursor:pointer;color:blue;}
     .clear{ clear: both; }
     .clear:after { 
     content: "."; 
     visibility: hidden; 
     display: block; 
     height: 0; 
     clear: both;
     }
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
    #coverall{background-color:#fefbed;} 
    #coverall img {
	border-width: 5px 5px 5px 5px;
	border-style: solid;
	border-color: #ffffff;
	-moz-box-shadow: 0px 0px 5px 0px #D8D8D8;
	-webkit-box-shadow: 0px 0px 5px 0px #D8D8D8;
	box-shadow: 0px 0px 5px 0px #D8D8D8;
	outline-width: 0px;
	outline-style: solid;
	outline-color: #ffffff;
	-webkit-border-radius: 15px 15px 15px 15px;
	border-radius: 15px 15px 15px 15px;
	margin-top:20px;}
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
	.fixed{position:fixed;}
	.editcolor{color:#'.$this->editor_color.';}
	.editbackground{ background:#'.$this->editor_background.';} 
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
	   border-width:1px;
	   border-style: solid;
	   border-color:#2B1DC9;  
	   -moz-border-radius:3px;
	   -webkit-border-radius:3px;
	   border-radius:3px;
	   -moz-box-shadow:inset -1px -1px  1px  #aaa5e9,inset 1px  1px  1px  #aaa5e9;
	   -webkit-box-shadow:inset -1px -1px 1px  #aaa5e9,inset 1px  1px  1px  #aaa5e9;
	   box-shadow:inset  -1px -1px  1px #aaa5e9, inset 1px  1px  1px  #aaa5e9;
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
	$this->css.="\n".$this->fontcss."\n".$this->navcss."\n".$this->imagecss; 
    file_put_contents($this->roots.Cfg::Style_dir.$this->pagename.'.css',$this->css);
    //for add pages Pics etc.
    file_put_contents($this->roots.Cfg::Style_dir.$this->pagename.'_paged.css',$this->pagecss);
    file_put_contents($this->roots.Cfg::Style_dir.'gen_page.css','@charset "UTF-8";'. $this->sitecss);//for add pages Pics etc.
     file_put_contents($this->roots.Cfg::Style_dir.$this->pagename.'_adv.css','@charset "UTF-8";'. $this->advancedmediacss);// 
     file_put_contents($this->roots.Cfg::Style_dir.$this->css_suffix.$this->pagename.'_mediacss.css','@charset "UTF-8";'. $this->mediacss."\n".$this->css_grid);//
     /*the following was for developement work to update automatically
	$return=include_copy_gen::copypath('slippry.js',$this->roots.Cfg::Script_dir.'slippry.js');
	(!$return)&&mail::alert('False return on   slippry.js'.$this->roots.Cfg::Script_dir.'slippry.js');
	$return=include_copy_gen::copypath('slippry.css',$this->roots.Cfg::Style_dir.'slippry.css');
	(!$return)&&mail::alert('False return on   slippry.css'.$this->roots.Cfg::Style_dir.'slippry.css');*/
	printer::alert_pos('Css file Gen Complete');  
	}
    
function css_edit_file(){
    $this->css_edit_page_common();
    $this->css_edit_page();   // this is for page_specific editcss...
     file_put_contents($this->roots.Cfg::Style_dir.$this->pagename.$this->css_suffix.'editoverride.css', $this->editoverridecss);// 
	file_put_contents($this->roots.Cfg::Style_dir.$this->pagename.'pageedit.css', $this->pageeditcss);// editcss generated by all the system css for editcss 
   file_put_contents($this->roots.Cfg::Style_dir.'gen_edit.css', $this->editgencss);// editcss generated by all the system css for editcss
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
function css_highslide(){   
$this->highslidecss=' 
	 div.highslide-container   { }
	.highslide-container table{background:none;}
	.highslide{outline:none;text-decoration:none;}
	.highslide-active-anchor img{visibility:hidden;}
	.highslide-gallery .highslide-active-anchor img{visibility:visible;cursor:default;}
	.highslide-caption{display:none;}
	.highslide-caption-inner{display:inline-block;}
	.highslide-controls li{float:left;margin:0;padding:1px 0;}
	div.highslide-controls {opacity:.4;}
	div.highslide-controls:hover{opacity:1;}
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
	.expand-menu-icon{position: absolute; top:15px; z-index:100;}
	.expand-menu-icon .xbar1, .expand-menu-icon .xbar2, .expand-menu-icon .xbar3 {
    width: 1em;
    height: .1em;
    margin: .15em 0;
    -webkit-border-radius: .1em .1em .1em .1em;
	border-radius: .1em .1em .1em .1em;
    } 
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
	';
	}
function css_nav(){
     /*.navigation_menu.edit .nav_gen ul.top-level li {
	display: block !important;
}*/
	$this->nav_site_css='
  .nav_gen ul.top-level.menuRespond   { 
  -webkit-transition: max-height 2s ease;
  -moz-transition: max-height 2s ease;
  -o-transition: max-height 2s ease;
  transition: max-height 2s ease;  
    max-height:2000px;
	}
.nav_gen .ulTop.menuRespond2 li.show_icon:hover,.nav_gen ul li.show_icon.nav_gen ul li.show_icon{background-image:none; background:none; border-width:0px;box-shadow:none;}
.nav_gen{margin-left: auto;	margin-right: auto; display:table;}
.nav_gen A {cursor: pointer;display:block; }
.nav_gen UL UL LI A:LINK,.nav_gen LI A:LINK {color:inherit;}
.nav_gen UL UL  {  text-align: center; vertical-align: top;}
.horiz .nav_gen UL LI {display:inline-block;  vertical-align: top;}
.horiz .nav_gen UL UL LI {display:block;}
.vert  .nav_gen UL LI {display: block; vertical-align: top; }
.hover .nav_gen UL  LI  {position:relative;}
.hover .nav_gen  UL UL {Z-INDEX: 100; LEFT:0; TOP:0; VISIBILITY: hidden;  overflow:hidden;   POSITION: absolute;  }
  .hover .nav_gen  UL :hover UL :hover UL  { VISIBILITY: visible;} 
.hover .nav_gen  UL LI:hover UL  { VISIBILITY: visible } 
.hover .nav_gen ul.sub-level,.hover .nav_gen  ul ul  {  Z-INDEX: 100; }
.hover .nav_gen  UL UL LI  {margin-right:auto; margin-left:auto;} 
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

    
function edit_metadata(){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
     $this->show_more('Configure Outer Tab Title, keywords and Meta data','noback','','',500);
     $this->print_redwrap('outer tab');
     printer::alert('Optionally configure keywords and meta data which has limited effect on search engines');
    echo '<fieldset ><legend>Edit/Translate metadescription </legend> 
    <textarea class="utility" name="metadescription" cols="50" rows="3" id="metadescription">' . $this->metadescription.'</textarea>
    </fieldset><!--end Meta data-->';
    printer::pclear();
    
    echo '<fieldset ><legend>Edit/Translate keywords </legend> 
    <textarea class="utility" name="keywords" cols="50" rows="3" id="keywords">' . $this->keywords.'</textarea>
    </fieldset><!--End Keywords-->';
      
    echo '<fieldset ><legend>Change The Outer Title on Your Page Tab </legend> 
    <textarea class="utility" name="page_title" cols="50" rows="3" id="page_title">' . $this->page_title.'</textarea>
    </fieldset><!--End Keywords-->';
     printer::pclear();
	$this->close_print_wrap('outer tab'); 
     $this->show_close('Configure Outer Tab Title');  
     }#end metadata
  
 
     #***************BEGIN EDIT CSS FUNCTIONS********************
    #editstyle #editcss
    
     //text area is set to font-size 1.0 em which will allow element size to work properly... color is a default only   
function css_edit_page_common(){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
/*.navigation_menu.edit .nav_gen ul.top-level{max-height:1000px;display:block;}
	.navigation_menu.edit .nav_gen ul.top-level li{display:block;}
	*/
	$fontfamily=(!empty($this->master_font))? 'font-family: '.$this->master_font.'; ':' font-family: Arial, helvetica,  sans-serif; '; 
   $this->editgencss.=' 
table.rwdmedia{
     font-size:12px;
     border:2px;
     table-layout: fixed;
     word-wrap:break-word;
     width:300px;
     overflow:hidden;
     }
table.rwdmedia td,table.rwdmedia th{
     width:75px;
     overflow:hidden;
     }
html .button {
   float:left;
   font-size:1em;
   background: #6e9fb6;
   color: #fff;
   margin: 0 5px ;
   padding: 0  5px;
   border-width:4px;
   border-style: solid;
   border-color:#6399b2;  
   -moz-border-radius:10px;
   -webkit-border-radius:10px;
   border-radius:10px;
   -moz-box-shadow:inset 0 10px 0 rgba(255,255,255,0.5);
   -webkit-box-shadow:inset 0 10px 0 rgba(255,255,255,0.5);
   box-shadow:inset 0 10px 0 rgba(255,255,255,0.5);
   cursor:pointer;
   }
     #topunder{background:rgba(255,255,255,.7);position:relative;left:0px; top:5px;}
	#topmenu {left:8px; top:10px;}
	#botmenu {right:2px;top:6px;}
	#topoutmenu {left:0;top:0px;opacity:.7;}
     #top_upload{position:absolute;left:15px;}
     #toprefresh{position:absolute;left:0px; top:0px}
	#botoutmenu {right:0px;top:3px;opacity:.7;}
	#topconfig #topmenu,#topconfig  #botmenu{font-size:10px;color:black;cursor:pointer; z-index:10000000; position:fixed;padding:0;margin:0;}
	#botoutmenu,#topoutmenu{font-size:20px;color:white;cursor:pointer; z-index:1000000; position:fixed;padding:0;margin:0;} 
	#topconfig{top:10px;}  
	#topconfig #topoutmenu,#topconfig   
	#edit-menu-icon .xbar1, #edit-menu-icon .xbar2, #edit-menu-icon .xbar3 {
    width: 20px;
    height: 2px;
    margin-bottom: 2px;
    -webkit-border-radius: 1px 1px 1px 1px;
	border-radius: 1px 1px 1px 1px;
    }
    #topconfig #scrwid,#topconfig #loadingsize{display:block;}
#topconfig #edit-menu-icon .xbar1 {margin-top:0px; margin-bottom:2px;}
	.navigation_menu.edit .nav_gen ul.top-level {display:inline-block !important;}
	.navigation_menu.edit .nav_gen ul.top-level ul li {display:none !important;}
    .navigation_menu.edit .nav_gen ul.top-level li:hover ul  li{display:block  !important;}
     .navigation_menu.edit ul.top-level li{display:inline-block !important;}
      .navigation_menu.edit .nav_gen ul.top-level{max-height:1000px;} 
	.z100 {z-index:100;position:relative;} 
	.tip {background:rgb(243,243,243); margin: 4px; padding:4px; border: 2px  double #a0a4a5; color:#352c3e;
	background: -webkit-linear-gradient(rgb(224,224,224),rgb(243,243,243),rgb(243,243,243),rgb(243,243,243),rgb(243,243,243),rgb(224,224,224));
background: -o-linear-gradient(rgb(224,224,224),rgb(243,243,243),rgb(243,243,243),rgb(243,243,243),rgb(243,243,243),rgb(224,224,224));
background: -moz-linear-gradient(rgb(224,224,224),rgb(243,243,243),rgb(243,243,243),rgb(243,243,243),rgb(243,243,243),rgb(224,224,224));
background: linear-gradient(rgb(224,224,224),rgb(243,243,243),rgb(243,243,243),rgb(243,243,243),rgb(243,243,243),rgb(224,224,224));
	}
	.tip2 {background:rgb(223,223,223); margin: 2px; padding:2px; border: 1px  double #a0a4a5; color:#352c3e;
	background: -webkit-linear-gradient(rgb(214,214,214),rgb(223,223,223),rgb(223,223,223),rgb(223,223,223),rgb(223,223,223),rgb(214,214,214));
background: -o-linear-gradient(rgb(214,214,214),rgb(223,223,223),rgb(223,223,223),rgb(223,223,223),rgb(223,223,223),rgb(214,214,214));
background: -moz-linear-gradient(rgb(214,214,214),rgb(223,223,223),rgb(223,223,223),rgb(223,223,223),rgb(223,223,223),rgb(214,214,214));
background: linear-gradient(rgb(214,214,214),rgb(223,223,223),rgb(223,223,223),rgb(223,223,223),rgb(223,223,223),rgb(214,214,214));
	}
     .min100{min-width:100px;min-height:100px;}
     .flexstay {flex:0 0 auto;width:100%;
     order:0;}
	.choose {background:rgb(243,243,243); margin: 1px; padding:1px; color:#352c3e;}
	.oldtip {background:#dee0f7; margin: 4px; padding:4px; border: 4px  double #6d5c80; color:#352c3e;}
     a.underline,a:link.underline,.underline {text-decoration:underline;}
     .opacitybackground{background:rgba(255,255,255,.25);}
   .italic{font-style:italic;}
   .bold {font-weight: bold;}
	.nolist{list-style-type: none;}
    .inline {display:inline-block;padding:2px;}
    .purple{color:#'.$this->purple.';}
    .information {display:inline-block;padding:.2em .5em;text-align:left; color:#'.Cfg::Info_color.'; display:inline;  }
    .informationcenter {text-align:center;   font-style:italic; color:#'.Cfg::Info_color.'; }
    .hightlight{color:#'.Cfg::Info_color.';text-decoration:italic;font-weight:700;}
   .infoclick,a.infoclick{padding:3px 3px;display:inline-block;text-align:left; cursor: pointer; font-style:italic; color:#'.Cfg::Info_color.'; text-decoration: underline;}
	.inlinehighlight { padding:3px 10px;display:inline;background:#1E2F4D;color:#FFFAFF;}
	.red, .neg{color:red;}
	.expand{display:block; width:100%;} 
	.hide,.hidemar,.hidepad,.hidefont,#hide_leftovers {display:none;} 
	.bordernavy{border-color:#'.$this->navy.';}
	.borderblue{border-color:#'.$this->blue.';}
	.borderekblue{border-color:#'.$this->ekblue.';}
	.borderpos{border-color:#'.$this->pos.';}
	.borderred{border-color:#'.$this->redAlert.';}
	.borderinfo{border-color:#'.$this->info.';}
	.border1{border-width:1px}
	.border2{border-width:2px}
	.border3{border-width:3px}
	.border4{border-width:4px}
	.border5{border-width:5px}
	.border6{border-width:6px}
	.border7{border-width:7px}
	.border8{border-width:8px}
	.border9{border-width:9px}
	.border10{border-width:10px}
	.bordersolid{border-style:solid;}
	.borderdash{border-style:dashed;}
	.borderdotted{border-style:dotted;}
	.borderdouble{border-style:double;}
	.bordergroove{border-style:groove;}
	.borderridge{border-style:ridge;}
	.borderinset{border-style:inset;}
	.borderoutset{border-style:outset;}
	.postborder {border-width: 3px 0 3px 0;}
	.floatleft {float:left; }
	.navr2{display:inline-block; margin:  4px 0; background: #e6eff1; padding:  1px;
	color:#'.$this->pos.';
	-moz-border-radius:5px;
	   -webkit-border-radius:5px;
	   border-radius:5px; 
	   border: 3px  double #'.$this->navy.';
	   outline: 2px solid #'.$this->floralwhite.';}
    textarea.cloak { width: 100%; background-color: #e7c7a5; color:#000; font-size:1em;}
	.width200 {width:200px;}
	.width300 {width:300px;}
	.width400 {width:400px;}
	.width500 {width:500px;}
	.width600 {width:600px;}
	.width700 {width:700px;}
	 input,legend,label,option,select  {margin:0; padding:0;color:#'.$this->editor_color.';}
	.warn1,.warn{margin:1px;  background: #f1d8d8; padding:1px 3px; color: #'.$this->orange.';}
	.warnlight{margin:1px; background: #fff2f2; padding:1px 3px; border: 2px  double #'.$this->redAlert.'}
	.warn2{margin:1px; background: #f1d8d8; padding:1px 3px; }
	.caution{margin:1px; background: orange; padding:1px 3px; border: 2px  double #'.$this->redAlert.'}
	.cautionmaroon{color:maroon; margin:1px; background: #f1d8d8; padding:1px 3px; border: 2px  double #'.$this->redAlert.'}
	.neg{color:#'.$this->redAlert.';}
	.alertnotice {font-weight:800; color:#'.$this->redAlert.';}
	.fs1npred {border: 1px  solid #'.$this->redAlert.';}
	.fs1npinfo {border: 1px  solid #'.$this->info.';} 
	.fs1lpinfo{padding: 4px 4px 4px 25px; border: 1px  solid #'.$this->info.';} 
	.fs2npred {margin:0;padding:0;border: 2px  solid #'.$this->redAlert.';}
	.fs2npinfo {border: 2px  solid #'.$this->{'info'}.';}
	 
	.fsmcolor   { margin: 4px; padding:10px; border: 2px  double #'.$this->editor_color.' } 
	.fsmlightred {margin: 4px auto; padding:10px; border: 2px  double #dc8c8c; }
	.utilitygrad {
		margin: 4px; padding:4px;
		border: 4px  double #'.$this->info.';
		background: -webkit-linear-gradient(top left,#96bfbb,#aa739b,#c7e3cd,#0075a0,#FFFAFF,rgba(200,44,29,0.23));  
		background: -o-linear-gradient(to bottom right,#96bfbb,#aa739b,#c7e3cd,#0075a0,#FFFAFF,rgba(200,44,29,0.23));  
		background: -moz-linear-gradient(to bottom right,#96bfbb,#aa739b,#c7e3cd,#0075a0,#FFFAFF,rgba(200,44,29,0.23)); 
		background: linear-gradient(to bottom right,#96bfbb,#aa739b,#c7e3cd,#0075a0,#FFFAFF,rgba(200,44,29,0.23) );
		}
	 
	.fbs1info{margin: 12px; padding:4px; -moz-box-shadow: 4px 4px 7px -6px #800000; 
-webkit-box-shadow:  4px 4px 7px -6px #800000;   
box-shadow:  4px 4px 7px -6px #800000;} 
	
	
	.skewx3{-moz-transform: rotate(0deg) skewX(3deg) skewY(0deg);
	-webkit-transform: rotate(0deg) skewX(3deg) skewY(0deg);
	-o-transform: rotate(0deg) skewX(3deg) skewY(0deg);
	-ms-transform: rotate(0deg) skewX(3deg) skewY(0deg);
	transform: rotate(0deg) skewX(3deg) skewY(0deg);}

	.lineh90{float: left; line-height:90%; font-size:12px;}
 
     * HTML .utility_horiz UL UL A, * HTML .utility_horiz UL UL A:visited,.utility_horiz UL UL A,.utility_horiz UL UL A:visited,.utility_horiz UL UL A:hover, * HTML .utility_horiz UL UL,.utility_horiz UL UL,.utility_horiz UL UL A:active{WIDTH:190px}	
	.utility_horiz UL UL li A:visited, .utility_horiz UL UL li A:link{Z-INDEX: 100;}
	.utility_horiz UL UL li A:visited, .utility_horiz UL UL li A:link,
	  .utility_horiz UL {  LIST-STYLE-TYPE: none; }
          .utility_horiz LI { vertical-align: top; position: relative; display:inline-block;   LIST-STYLE-TYPE: none;}
      .utility_horiz A,.utility_horiz A:visited, .utility_horiz A:active {DISPLAY: block;   padding: .4em 0 .4em 1em; TEXT-DECORATION: none}
    .utility_horiz ul ul a:hover,  .utility_horiz ul ul li a:hover   { text-align:left; padding: .4em 0 .4em 5px; color:#ae7ba1; background:#f4edeb;}
	.utility_horiz ul :hover ul li {width:190px;}
	 .utility_horiz ul li a:hover {color:#ae7ba1; background:#f4edeb;}
	 .utility_horiz UL UL A,.utility_horiz UL UL A:active,.utility_horiz UL UL A:visited,.utility_horiz UL UL A:active {text-align:left; padding:.4em 0 .4em 5px; MARGIN-TOP: 0px; DISPLAY: block;}
   .utility_horiz UL UL {Z-INDEX: 100; LEFT: 0px; POSITION: absolute;}
     .utility_horiz UL UL {LEFT: 0px; VISIBILITY: hidden;   POSITION: absolute; HEIGHT: 0px}
	  .utility_horiz UL :hover UL :hover UL  { VISIBILITY: visible;}
    .utility_horiz UL LI:hover UL  { VISIBILITY: visible }
      .utility_horiz UL A:hover UL  { VISIBILITY: visible; }
    .utility_horiz UL :hover UL UL { VISIBILITY: hidden }
     .utility_horiz UL UL  { VISIBILITY: hidden }
     ';	
$this->pageeditcss.='
	 .editfontcol {font-size:'.($this->edit_font_size*16).'px;font-family:'.$this->edit_font_family.'text-shadow:none; text-align:center;}
	.editdefaultcol { text-shadow:none; text-align:center;}
	editcolor{color:#'.$this->editor_color.';}
	.ramanablock {max-width:700px; text-align:left;background:#'.$this->editor_background.';color:#'.$this->editor_color.';}
	.ramanafullblock {text-align:left;background:#'.$this->editor_background.';color:#'.$this->editor_color.';}
     input,textareax,.uncloak{background:#'.$this->editor_background.';}
	 legend {font-size: 1em; '.$fontfamily.' font-size: 1em;}
     textarea {  border: 1px solid #'.$this->editor_color.';}
     input.utility{color:#'.$this->editor_color.';background:#'.$this->editor_background.';} 
     textarea.utility {'.$fontfamily.' width:90%; border: 1px solid #'.$this->editor_color.'; color: #'.$this->editor_color.';background:#'.$this->editor_background.';}
    .utility_horiz ul ul  li  {background-color: #'.$this->editor_background.'; width:195px; } 
	.utility_horiz {background:#'.$this->editor_background.'; color:#'.$this->editor_color.'; WIDTH: 100%; margin: 0 auto;}
    .photoupload{color:#'.$this->editor_color.';display:block;} 
	.editbackground{ background:#'.$this->editor_background.';} 
	.fs1color{border:1px solid  #'.$this->editor_color.';}
	.fs1npblack {border: 1px  solid #'.$this->editor_color.';}
	.editfontcenter {font-size:'.($this->edit_font_size*16).'px;font-family:'.$this->edit_font_family.';text-align:center;}
	';
	$this->editgencss.='
     .buttoneditcolor{ text-align:left;  color:#'.$this->editor_color.'; 
	   background: #'.$this->editor_background.';   margin: 2px;
	   padding: 2px; line-height:110%; border-width:1px; border-style: solid; border-color:#'.$this->editor_color.';  
	   -moz-border-radius:1px; -webkit-border-radius:1px; border-radius:2px; 
	    cursor:pointer; }  .buttoneditcolor{ text-align:left;  color:#'.$this->editor_color.' !important; 
	   background: #'.$this->editor_background.';   margin: 2px;
	   padding: 2px; line-height:110%; border-width:1px; border-style: solid; border-color:#'.$this->editor_color.';  
	   -moz-border-radius:1px; -webkit-border-radius:1px; border-radius:2px; 
	    cursor:pointer; }
	 ';    
foreach ($this->color_order_arr as $color){ 
     $colorlight=process_data::colourBrightness($this->$color,.4);
 
	//text-shadow: #f2f0e4 0.1em 0.1em 0.1em;
	$this->editgencss.='
		.button'.$color.'{ text-align:left;
	   background: #'.$this->editor_background.';   margin: 2px;
	   padding: 2px; line-height:110%; border-width:1px; border-style: solid; border-color:#'.$this->$color.';  
	   -moz-border-radius:1px; -webkit-border-radius:1px; border-radius:2px;
	   -moz-box-shadow:inset -1px -1px  1px  #'.$colorlight.',inset 1px  1px  1px  #'.$colorlight.';
	   -webkit-box-shadow:inset -1px -1px 1px  #'.$colorlight.',inset 1px  1px  1px  #'.$colorlight.';
	   box-shadow:inset  -1px -1px  1px #'.$colorlight.', inset 1px  1px  1px  #'.$colorlight.'; 
	    cursor:pointer; }  
		.button'.$color.'mini{ text-align:left;
	   background: #'.$this->editor_background.';   margin: 2px;
	   padding: 2px; border-width:2px; border-style: solid; border-color:#'.$this->$color.';  
	   -moz-border-radius:3px; -webkit-border-radius:3px; border-radius:3px;
	    cursor:pointer; }  
	.glowbutton'.$color.'{ text-align:left;
	   background: #'.$this->editor_background.';   margin: 5px 5px ;
	   padding: 2px; line-height:120%; border-width:9px; border-style: solid; border-color:#'.$this->info.';  
	   -moz-border-radius:5px; -webkit-border-radius:5px; border-radius:5px;
	   -moz-box-shadow:inset -3px -3px  3px  #'.$colorlight.',inset 2px  2px  2px  #'.$colorlight.';
	   -webkit-box-shadow:inset -3px -3px 3px  #'.$colorlight.',inset 2px  2px  2px  #'.$colorlight.';
	   box-shadow:inset  -3px -3px  3px #'.$colorlight.', inset 2px  2px  2px  #'.$colorlight.'; 
	    cursor:pointer; } '; 
	} //foreach color
	$carr=$this->color_order_arr;
	$carr[]='white';
	$carr[]='black';
foreach ($carr as $color){
	$this->editgencss.= 
	'.fs1'.$color.'{padding:3px; margin:3px; border: 1px  solid #'.$this->$color.';} 
	.fs2'.$color.'{padding: 3px; margin:3px; border: 2px  solid #'.$this->$color.';}  
	.fs3'.$color.'{padding: 3px; margin:3px; border: 3px  solid #'.$this->$color.';} 
	.fd1'.$color.'{padding: 4px; margin:4px; border: 1px  double #'.$this->$color.';} 
	.fd2'.$color.'{padding: 4px; margin:4px; border: 2px  double #'.$this->$color.';}  
	.fd3'.$color.'{padding: 4px; margin:4px; border: 3px  double #'.$this->$color.';}    
	.bs1'.$color.'{border: 1px  solid #'.$this->$color.';}   
	.bs2'.$color.'{border: 2px  solid #'.$this->$color.';}  
	.bs3'.$color.'{border: 3px  solid #'.$this->$color.';} 
	.bs4'.$color.'{border: 4px  solid #'.$this->$color.';}
	.Os3'.$color.'{outline: 3px  solid #'.$this->$color.';}
	.bdot1'.$color.'{margin:1px;border: 1px  dotted #'.$this->$color.';} 
	
	.bdoub1'.$color.'{border: 1px  double #'.$this->$color.';} 
     .bshad1'.$color.'{-moz-box-shadow: 0px 0px 1px 1px #'.$this->$color.'; 
-webkit-box-shadow:  0px 0px 1px 1px #'.$this->$color.';    
box-shadow:  0px 0px 1px 1px #'.$this->$color.';}
	.bdoub2'.$color.'{border: 2px  double #'.$this->$color.';} 
	.bdot2'.$color.'{border: 2px  dotted #'.$this->$color.';} 
	.bshad2'.$color.'{-moz-box-shadow: 0px 0px 2px 2px #'.$this->$color.'; 
-webkit-box-shadow:  0px 0px 2px 2px #'.$this->$color.';    
box-shadow:  0px 0px 3px 3px #'.$this->$color.';}
	.bdoub3'.$color.'{border: 3px  double #'.$this->$color.';} 
	.bdoub4'.$color.'{border: 4px  double #'.$this->$color.';} 
	.bdot3'.$color.'{border: 3px  dotted #'.$this->$color.';} 
	.bdot4'.$color.'{border: 4px  dotted #'.$this->$color.';} 
	.bshad3'.$color.'{-moz-box-shadow: 0px 0px 3px 3px #'.$this->$color.'; 
-webkit-box-shadow:  0px 0px 3px 3px #'.$this->$color.';    
box-shadow:  0px 0px 3px 3px #'.$this->$color.';}
	.bshad4'.$color.'{-moz-box-shadow: 0px 0px 4px 4px #'.$this->$color.';
-webkit-box-shadow:  0px 0px 4px 4px #'.$this->$color.';    
box-shadow:  0px 0px 4px 4px #'.$this->$color.';}
	.fsec'.$color.'{margin: 2px; padding:3px; border: 4px  double #'.$this->$color.';}
	.fsm2'.$color.'{margin: 4px; padding:10px; border: 2px  double #'.$this->$color.';}
	.fsm'.$color.'{margin: 4px; padding:10px; border: 2px  double #'.$this->$color.';} 
	.fsm1'.$color.'{margin: 4px; padding:10px; border: 1px  solid #'.$this->$color.';}';
	}
foreach ($carr as $color){
	$this->editgencss.= 
	'.'.$color.'{color:#'.$this->$color.';}';
	}
foreach ($carr as $color){
	$this->editgencss.= 
	'.border'.$color.'{border-color:#'.$this->$color.';}';
	}	
	 
foreach ($carr as $color){
	$this->editgencss.=
	'.'.$color.'background{background:#'.$this->$color.';}';
	}
	
   $this->editgencss.='
     h7 {color:#'.$this->info.';} 
	.static{ position:static !important;}
	.staticdim{ opacity:.98;}
	.fullopacity{opacity:1.0}
	 a:link.linkcolorinherit, a:visited.linkcolorinherit{color:inherit;}
	.infoback {background:#f4f3e0;}
	.lightgreenbackground{background:#ebf4e7;padding: 20px 10px 40px 10px}
	.lightredAlertbackground{background:#fff2f2;padding: 20px 10px 40px 10px}
	.lightgreenbackgroundnp{background:#ebf4e7;}
	.lightredbackmar{background:#fff2f2;padding:10px; margin:7px 0;}
	.lightredAlertbackgroundnp{background:#fff2f2;}
	.nestedcolumn{margin-top:10px;margin-bottom:10px;}
	.fs1npred .highslide-image {border: 16px  solid #'.$this->redAlert.';} 
     .moveright {position: relative;  right:300px;}
   .whitehide {border:3px solid #'.Cfg::Pos_color.';  background-color:#FFFAFF; }
   .whitecolor{color:white;}
   .whitegreen {border:3px solid  #000; padding: 20px 30px 40px 20px; background-color:#fff; color:#555}
   .relative {position:relative;}
   .fcol{ border:1px dashed #'.$this->redAlert.';}
   .sfield{text-align:left; border:1px solid #'.$this->redAlert.';}
   .redfield{text-align:left; border:3px solid #'.$this->redAlert.';}
      textarea.textarea,textarea {padding:0 !important; margin:0 !important}
	.margincenter {margin: 0 auto;}
	
	.editfontsmall {font-size:14px;text-align:left;}
	.editfontsmaller {font-size:12.5px;text-align:left;}
	.editfontsmallest {font-size:11px;text-align:left;}
	.editfontsupersmall{font-size:9.5px;text-align:left;}
	
	.shadow {text-shadow: #f2f0e4 -1.4px -1.4px  0.8px }
	.textshadow {font-family: Tahoma, Geneva, sans-serif; text-shadow: -1.4px -1.4px  0.8px #1E47FF;}
	.whiteshadow {text-shadow: 0px 0px 3px #ffffff; }
	.whiteshadow2 {text-shadow: 1px 1px 1px #ffffff; }
	.maroonshadow {text-shadow: 0px 0px .2px #800000; }
	.greyshadow {text-shadow: 0px 0px .2px #555; }
	.shadowoff {text-shadow: none;box-shadow:none; }
	.column2{-moz-column-count: 2;
	-moz-column-gap: 16px;
	-webkit-column-count: 2;
	-webkit-column-gap: 16px;
	column-count: 2;
	column-gap: 16px;}
	.cursor{cursor:pointer} 
     '; 
     }#end css_edit_page_common
     
function css_edit_page(){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	}
    
public static function xxinstance($msg='return'){ if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);//static allows it to create an instance without creating a new object
     if  (empty(self::$instance)) {
	   self::$instance = new global_master($msg); 
        } 
    return self::$instance; 
    }    

}//end class
?>