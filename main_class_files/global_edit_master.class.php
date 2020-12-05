<?php
#ExpressEdit 3.01
/*
ExpressEdit is an integrated Theme Creation CMS
	Copyright (c) 2018   expressedit.org
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

#note: display property and advanced styles use css #id to override normal styles which use distinct classnames    
#info
#width# find #width# for various width info
#style# find overview of style mechanism info
#flatfile# flatfile info for main system
#blogrender# function blog_render is the central method of the system
#for reasons of size and content grouping the main class was broken up to four classes...
#the extended main class is broken into 4 classes with each  limited to under ~7000 lines for quick editing in komodo edit 8.5 ::  global_master  extends global_edit_master  extends global_post_master extends global_process_master
class global_edit_master extends global_style_master{
	protected $blog_drop_array=array(	'New Column Here',
								'New Text',
								'New Image',
								'New Left Image-Text Wrap',
								'New Right Image-Text Wrap',
								'New Video/Iframe', 
								'New Contact Form',
								'New Mailing List Signup',
								'New Social Icon Links',
								'New Auto Slide Show',
								'New Gallery',
                                        'New Carousel',
								'New Navigation Menu',
								'Copy/Move/Clone Post',
								'Copy/Move/Clone Column' 
								);
	//private $autowidth=false;//  
	protected $tidy_blog=false; #if set true in process_blog data then reorder blog_order
	protected $render_array=array();//generate in edit style close 
	protected $new_blog=true;// this has become appendage needs to be removed
	protected $blog_table='';
	protected $border_spacing=15; //spacing between border boxes ie kb.com home
	private $text_box_index=4;#used  for ref blog drop array text box element
	protected $blog_float='';
	protected $blog_order='Om';
	protected  $pic_ext='';#used to add pic extension for float image css styling in blog_render
	protected $default_blog_text='Content Goes Here. Posts will not appear on the webpage till you Check the Publish Box!';
	protected $page_background='background-color:white;';//default for highslide dimming
	protected $styler_blog_instructions='Styles '; 
	protected $styler2_instruct='';
	protected $new_blog_array=array();
	protected $choose_blog_type='CHOOSE NEW POST TYPE';
	protected $insert_full=10;
	protected $insert_half=5;
	protected $dir_insert_full=1;  
	protected $image_link=false; 
	protected $is_blog=false;//if blog being served up
	protected $is_column=false;//if column being served up
	protected $is_page=true;//if page being served up, initial state
	protected $column_net_width=array();
	protected $column_total_width=array();
	protected $blog_id_arr=array();
	protected $column_background_color_arr=array();
	protected $column_color_arr=array();
	protected $column_font_px_arr=array(); 
	protected $column_fol_arr=array();
	protected $column_id_array=array(); 
	//protected $column_table_array=array();
	protected $column_level_base=array();
	protected $blog_order_arr=array();
	protected $column_total_gu_arr=array();		
	protected $inforef;//pass info to Column#
	protected $blog_order_mod=''; // initialize
	protected $column_new=false;//used to alert new column creation in render column data
	//protected $post_ref_array=array();//current progression of post_refs
	protected $blog_order_array=array();  
	protected $column_order_array=array(); 
	protected $column_lev_color='pos';
	protected $current_total_width='';
	protected $current_net_width='800';//set as default value for intital page styling
	protected $current_background_color='';
	protected $current_font_px='';
	protected $current_color='000';
	protected $column_total_net_width_percent=array();
	protected $col_num_max=0; 
	protected $clone_check_arr=array();
	protected $blog_moved=array();
	protected $nested_col_moved=array();
	protected $css_fonts_extended_dir='fonts.css';
	protected $column_moved=array();
	protected $advancedstyles=array();
	protected  $sibling_id_arr=array();//keep track to get id dataCss or col_dataCss based on id for animation
	protected $menu_icon_color='white,yellow,gold,lightestblue,lightlightblue,lightblue,lavender,blue2,blue,navy,ekblue,electricblue,ekaqua,forestgreen,green,lime,electricgreen,ekdarkpurple,olive,orange,ekmagenta,magenta,red,ekred,lightbrown,brown,black,silverlightest,silverlight,silver,greydark,greydarkest';
	protected $marketing_default='';
	protected $position_arr=array('center_row','center_float','left_float','right_float','left_float_no_next','right_float_no_next','center_float_no_next','force_float_off');
	protected $position_val_arr=array('center row','center float','left float','right float','left float no next','right float no next','center float no next','Off Completely');
	protected $table_prefix='table_';
	static protected  $col_count=1;
	static protected  $rangecount=0;
	protected $col_num=0;
	protected $styleoff=false;//turn off style editing
	protected $column_new_array=array();
	protected $navcss='';
	protected $previous_post='first post';
	protected $float_width_record=array();
	protected $current_overall_floated_total=array(); 
	protected $border_sides=array('No Border','top bottom left right','top bottom','top','bottom','left','right','top left','top right','bottom left','bottom right','left right','Force No Border');
	protected $current_padded=0;
	protected $auto_width=0; //ajax derived browser width
	protected $delete_col_arr=array();//collects deleted col ids
	protected static $styleinc=0;
	protected $table_updater_arr=array();
	protected $list=array();
	protected $current_unclone_table=array();
	protected $clone_local_style=false;
	protected $clone_local_data=false;
	protected $parent_col_clone='';
	protected $image_resize_msg='';
	private static $instance=false; //store instance not curr used
	protected $groupstyle_begin_blog_id_arr=array();
	protected $groupstyle_begin_col_id_arr=array();
	//if in backup clone check array will  iframe   regenerate cloned post styles in backup class :: blog_text blog_data1 are examples of frequently changed fields with no effect on styling  in clones		
#css_generate will happen without an submit!  It generates the element css automatically..
#the render array for css_generate is generated it edit_styles_close();
#editpages handles arrays of submitted values and implodes them in process_data::spam_scrubber
#each style funct  creates a full css elementstyle with its $value for rendering the css in css_generate!!
#**************BEGIN EDIT FUNCTIONS***************
function backup(){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__); 
	(Sys::Deltatime)&&$this->deltatime->delta_log('begin backup '.__LINE__.' @ '.__method__.'  '); 
	 $this->backupinst->render_backup($this->pagename);
	(Sys::Deltatime)&&$this->deltatime->delta_log('end  backup '.__LINE__.' @ '.__method__.'  ');
	}
     
function edit_script(){if (Sys::Debug)  Sys::Debug(__LINE__,__FILE__,__METHOD__);  if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
     if (isset($_POST['firstposttestjavascript'])){
          $msg='Broken Javascript Bypassing beforeSubmit Allowing Non Changed Form Fields to Be Submitted';
          mail::alert($msg);
          exit($msg);
          }
	(Sys::Deltatime)&&$this->deltatime->delta_log(__LINE__.' @ '.__method__.'  ');
     $_SESSION['write_to_file']=array();
     $this->editpages_obj($this->master_page_table,'page_id,'.Cfg::Page_fields,'','page_ref',$this->pagename,'','','all','',",page_time=".time().",token='". mt_rand(1,mt_getrandmax())."', page_update='".date("dMY-H-i-s")."'");
     $this->generate_bps(); 
	if(!is_array($this->page_options))
          $this->page_populate_options();//separately called  in non edit pages
     $this->color_populate();
     $this->page_grid_units=(is_numeric($this->page_options[$this->page_grid_units_index])&&$this->page_options[$this->page_grid_units_index]>11&&$this->page_options[$this->page_grid_units_index]<101)?intval($this->page_options[$this->page_grid_units_index]):100;
     $this->backup_copies=(is_numeric($this->page_options[$this->page_backup_copies_index])&&$this->page_options[$this->page_backup_copies_index]>20&&$this->page_options[$this->page_backup_copies_index]<1001)?$this->page_options[$this->page_backup_copies_index]:Cfg::Backup_copies;
	$ports='page_style,page_editor_color,page_special_class,page_width,page_rwd,page_cache';
	$exports='page_quality,page_dbbackups';
	foreach (explode(',',$ports) as $port){ 
		if (isset($_POST[$port.'_import']))$this->process_import($port);
		if (isset($_POST[$port.'_export']))$this->process_export($port);
		}
	foreach (explode(',',$exports) as $port){
		if (isset($_POST[$port.'_export']))$this->process_export($port);
		}
	if (isset($_POST['regen_backup_table']))backup::regen_backup_table($this->backup_copies);
     if (isset($_POST['tiny_image_quality'])&&isset($_FILES['file']))add_tiny_pic::submitted();
	if (isset($_POST['copy_to_clipboard']))$this->copy_to_clipboard();
	if (isset($_POST['paste_from_clipboard']))$this->paste_from_clipboard();
	if (isset($_POST['page_iframe_all']))$this->java_page_iframe_all();
	if (isset($_POST['page_iframe_all_website']))$this->page_iframe_all_website();
	if (isset($_POST['cache_regenerate']))$this->cache_regenerate();
	if (isset($_POST['cache_regenerate_flatfiles']))$this->cache_regenerate_flatfiles();
	if (isset($_POST['submitted']))$this->process_col();
	if (isset($_POST['delete_blog_clunc']))$this->process_delete_clunc(); 
	if (isset($_POST['col_transfer_clone']))$this->process_col_transfer_clone();
	if (isset($_POST['force_color_reset']))$this->force_color_reset();
	if (isset($_POST['reset_editor_background_colors']))$this->reset_editor_background_colors();
	if (isset($_POST['gallpicsubmitted'])){
		$addgallery=addgallery::instance();
		$addgallery->submitted();
		}
	if (isset($_POST['file_generate_site'])){
			if (isset($_POST['file_generate_local']))  
				$msg=file_generator::file_generate(false,true,false,true);
		else $msg=file_generator::file_generate(false,true,false);
		if ($msg==='success')$this->success[]='common files successfully generated';
		}
	if (isset($_POST['page_class_generate'])){
		$msg=file_generator::update_page_class();
		if ($msg==='success')$this->success[]='page files successfully generated';
		}
	if (isset($_POST['page_opts_import']))$this->page_opts_import();
	if (isset($_POST['page_opts_export']))$this->page_opts_export(); 
	if (isset($_POST['deletecolumn']))$this->check_delete_col();//do before add
	if (isset($_POST['delete_nav_menu']))$this->delete_nav_menu();
	if (isset($_POST['addnewcolumn'])||isset($_POST['copynewcolumn'])) 
		 $this->process_new_blog_table();
	if (isset($_POST['import_gallery'])||isset($_POST['clone_import_gallery']))$this->import_gallery();
	if (isset($_POST['addpagevidsubmitted'])) { 
		$this->addpagevid=addpagevid::instance();
		$this->addpagevid->submitted();	
		}
	if (isset($_POST['create_master_gallery']))$this->create_master_gallery();
	if (isset($_POST['pagepicsubmitted'])) {
		$this->addpagepic=addpagepic::instance();
		$this->addpagepic->submitted();
		}
	if (isset($_POST['nav_edit_submitted'])) { 
		$this->parse_menu_edit($_POST['nav_edit_submitted']);
		}
	if (isset($_POST['unclone_option_copy']))
		$this->create_unclone_copy();
	if (isset($_POST['remove_unclone_column']))
		$this->remove_unclone('column');
	if (isset($_POST['remove_unclone_post']))
		$this->remove_unclone('post');
     if (isset($_POST['configvidsubmitted']))
          $this->process_uploads('vid');
     if (isset($_POST['configpdfsubmitted']))
          $this->process_uploads('pdf');
     if (isset($_POST['configpicsubmitted']))
          $this->process_uploads('pic');
	if (isset($_POST['create_unclone']))
		$this->create_unclone_fresh();
     if (isset($_POST['page_options'][$this->page_grid_units_index])){
           $clean_id= (isset($_POST['page_grid_unit_change'])&&$_POST['page_grid_unit_change']==='site')?'all':$this->pagename;
          $this->clean_break_point_fields($clean_id);
          }
     elseif (isset($_POST['page_grid_unit_change'])){
           $clean_id= ($_POST['page_grid_unit_change']==='site')?'all':$this->pagename;
          $this->clean_break_point_fields($clean_id);
          }
     if (isset($_POST['page_break_points'])){//for changing page_rwd_grid
          $clean_id= (isset($_POST['page_add_bp'])&&$_POST['page_add_bp']==='site')?'all':$this->pagename;
          $this->clean_break_point_fields($clean_id);
          }
     
     elseif (isset($_POST['page_add_bp'])){//for changing page_rwd_grid
          $clean_id= ($_POST['page_add_bp']==='site')?'all':$this->pagename;
          $this->clean_break_point_fields($clean_id);
          }
	if (isset($_POST['page_adjust_break_points'])){//
          $this->page_adjust_break_points();
          } 
	if (isset($_POST['page_grid_unit_export'])){
          $this->page_grid_unit_export();
          $this->clean_break_point_fields('all');
          } 
	if (isset($_POST['page_rwd_export'])){
          $this->clean_break_point_fields('all');
          } 
	if (isset($_POST['page_rwd_import'])){
          $this->clean_break_point_fields($this->page_ref);
          } 
     $this->fonts_browser=explode(';',Cfg::Fonts_browser);//
	$this->fonts_extended=explode(';',Cfg::Fonts_extended);
	$this->fonts_all=array_merge($this->fonts_browser,$this->fonts_extended);  
	natcasesort($this->fonts_all); 
	//editpages_obj was moved from here up
	if (isset($_POST['page_cache']))$this->page_cache_update();//waited for page_cache to be rendered
	$this->pre_render_data();//empty function for customization
	if (!empty($this->header_script_function)){  
	   $javascript=new javascript($this->header_script_function,'', 'gen_Proc',$this->append_script);
	   }
    if (!empty($this->header_edit_script_function)){
	   $javascript_edit=new javascript($this->header_edit_script_function,'','gen_Procedit');
	    $this->header_edit_script=(!is_array($this->header_edit_script))?explode(',',$this->header_edit_script):$this->header_edit_script;    
	    $this->header_edit_script[]='gen_Proceditscripts.js';   
	   } 
	$this->render_header_open();
	$this->edit_header();
	$this->header_insert_edit();//for custom insert
	$this->header_close();
     $this->edit_body();  
     $this->column_lev_color=$this->color_arr_long[0];
	(Sys::Deltatime)&&$this->deltatime->delta_log('End Edit body '.__LINE__.' @ '.__method__.'  ');
	if (isset($_POST['submitted'])){
		$this->backupinst->backup_copies=$this->backup_copies;//configurable in page settings..
		$this->backup();//it gatheres the master pagename and makes sure not a blog pagename...
		(Sys::Deltatime)&&$this->deltatime->delta_log('Begin backup check clone  '.__LINE__.' @ '.__method__.'  ');
		//$this->backupinst->backup_check_clone($this->backup_page_arr);//not necessary with new system
		(Sys::Deltatime)&&$this->deltatime->delta_log('End backup check clone  '.__LINE__.' @ '.__method__.'  ');
		}
	$this->render_css();//after edit page has rendered.
     //$this->js_render_file();//after edit page has rendered.
	
	(Sys::Deltatime)&&$this->deltatime->delta_log('End of '.__LINE__.' @ '.__method__.'  ');
	$this->render_body_end();
	(Sys::Deltatime)&&$this->deltatime->delta_log('End of '.__LINE__.' @ '.__method__.'  ');
	}//edit script
     //note gallery master has its own edit_body

function header_insert_edit(){
	//for custom insert..
	}

function tool_man_init(){
	print(' 
	<!-- Modified tool-man  dragsort related  js created by Tim Taylor Consulting <http://tool-man.org/>  -->
	<script > 
	var dragsort = ToolMan.dragsort()
	var junkdrawer = ToolMan.junkdrawer()
	</script>');
	}
     
function edit_body(){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	$this->call_body();
     foreach ($this->express as $msg){
          echo NL.$msg;
          }
	$this->edit_form_head();  
	$this->echo_msg();//will echo success msgs  //submit call in destructor to collect all mgs
	echo <<<eol
     <script>
	jQuery("document").ready(function(jQuery){
		var scrollHeadTimer='';
	setTimeout(function(){	jQuery('#displaycurrentsize').css({'width':jQuery('#displaycurrentsize').width()*1.2+'px'});
       },50);
	   jQuery(window).scroll(function () {
		clearTimeout(scrollHeadTimer);
		scrollHeadTimer = setTimeout(function(){ //this will limit no of scroll events responding but may delay appearance of down arrow
               if (jQuery(this).scrollTop() > 30) {  
				jQuery('#topmenu,#topoutmenu, #botmenu, #botoutmenu,#displayCurrentSize2').removeClass("hide");   
										jQuery('#displayCurrentSize2').css({'position':'fixed','top':'0px','left':'30px','z-index':'100000'});
				}
			else if(jQuery(this).scrollTop() < 30) {
				jQuery('#topmenu,#topoutmenu,#botoutmenu,#botmenu,#displayCurrentSize2').addClass("hide");    
				}
				
			},40);
        }); 
});
</script>
eol;
	echo '<div id="topconfig">
	<div id="topoutmenu" title="Page Top" class="hide" onclick="window.scrollTo(0,0);return false;">&#9650;</div><div id="toprefresh"><a title="refresh page url  NO RESUBMIT" href="'.Sys::Self.'"><img  src="'.Cfg_loc::Root_dir.'refresh_button.png" alt="refresh button" width="15" height="15"></a></div><div id="topmenu" class="hide"><p id="gotop" onclick="window.scrollTo(0,0);return false;">&#9650;</p><p id="topunder"><a title="refresh page url" href="'.Sys::Self.'"><img  src="'.Cfg_loc::Root_dir.'refresh_button.png" alt="refresh button" width="15" height="15"></a></p><p class="clear"><p><input id="fixedsubmit" class="rad5 tiny cursor button'.$this->column_lev_color.' mb10" type="submit" name="submit"   value="submit" ></p></div><!--close topmenu-->
			<div id="botoutmenu" class="hide" title="Page bottom" onclick="window.scrollTo(0,100000);return false;">&#9660;</div><div id="botmenu" class="hide" title="Page bottom" onclick="window.scrollTo(0,100000);return false;">&#9660;</div>';
	echo '<div id="top_contain" class="showclass">'; 
	$this->uploads_spacer();
     $this->display_anchor(); 
     $this->browser_size_display();
	$this->top_submit();
	$this->track_font_em($this->page_style);
	$this->add_new_page();
	$this->configure();//configures certain values necessary for subsequent intits for tinymce gen_Proc..
     $this->body_defaults();//determine initial colors, fonts
     $this->page_import_export_options(); 
	$this->display_nav(); 
	$this->view_page();
     $this->editor_appearance();
	$this->restore_backup();
	$this->import_page();
     $this->advanced_button();
     $this->debug_activate();
     $this->magnify_margins();
	$this->leftover_view(); 
	echo '</div><!--close top_contain--></div><!--close contain configs-->';
	 echo '<input name="firstposttestjavascript" style="visibility:hidden;height:20px;" type="text" value="true">';//this is too test if javascript is working!
	printer::pclear(2);
     if (Sys::Pass_class&&strpos(Sys::Self,Cfg::Theme_dir)!==false){
          printer::alertx('<p class="underline orange whitebackground fsmredAlert italic"><a href="'.Cfg_loc::Root_dir.Cfg::PrimeEditDir.'index.php">Back to View Copy Theme Page<br></a><a href="'.Cfg_loc::Root_dir.Cfg::PrimeEditDir.'index.php?viewdboff"> OR Return to Normal Editpage mode</a></p>');
          printer::pclear();
          }
	if ($this->page_slide_show){
		print '<fieldset class="border3 borderridge border'.$this->color_arr_long[0].'"><legend class="shadowoff editbackground editfont">Configure Page Slide Show</legend><!--Begin edit fieldset Configure Page slide show-->';
		$this->auto_slide($this->pagename,'page');
		print '</fieldset><!--End edit fieldset Configure Page slide show-->';
		}
	$this->is_page=false;//for styling
     $this->tool_man_init();
	$this->tinymce();
	$this->gen_Proc_init(); 
	$this->render_body_main();
	printer::pclear();
	}//note gallery master has its own edit_body

function body_defaults(){
     $styles=explode(',',$this->page_style);
     for ($i=0; $i<count(explode(',',Cfg::Style_functions));$i++){
          (!array_key_exists($i,$styles))&&$styles[$i]='';
          }
     $background=$styles[$this->background_index];
     $colors=$styles[$this->font_color_index];
     $this->current_background_color=(preg_match(Cfg::Preg_color,explode('@@',$background)[0]))?explode('@@',$background)[0]:'fffff';
	$this->current_color=(preg_match(Cfg::Preg_color,$colors))?$colors:'000000'; 
     }
     
function advanced_button(){return;
     ##################### advance off button
	echo '<div class="floatbutton"><!-- float buttons-->';
	$msg='Advanced Style Css refers to custom css manually added at the bottom of the style options. You can change the default status of whether advances css is expressed in editmode under configure settings then toggle on or off here as needed. Please note some editor default styles may overwrite advanced css so always check results in webpage mode';
	if (!Sys::Advanced) 
		printer::printx('<p class="click buttoninfo highlight editfont tiny" title="'.$msg.'"> <a style="color:inherit;" href="'.Sys::Self.'?advanced">Display Adv CSS in Editmode</a></p>');
	else printer::printx('<p class="info click buttoninfo highlight tiny" title="'.$msg.'"> <a style="color:inherit;"  href="'.Sys::Self.'?advancedoff">Disable Display Adv CSS in Editmode</a></p>'); 
	echo '</div><!-- float buttons-->';
     }

function debug_activate(){
     ##################### advance off button
	echo '<div class="floatbutton"><!-- float buttons-->';
	$this->show_more('Debug Tools','',$this->column_lev_color.' smallest editbackground editfont button'.$this->column_lev_color,'','','','','asis');
	printer::print_wrap('configure wrap',true); 
     printer::alert('<a class="info" title="Turn off all active debug queries" href="'.Sys::Self.'?alloff">All Debug Options off</a>');
     printer::alert('<a class="info" title="Submitted Page refreshes to update css. Will prevent this to show submitted $_POST array and mysql queries and any error msg" href="'.Sys::Self.'?norefresh">Display $_POST and query Info during Submit </a><a href="'.Sys::Self.'?norefreshoff">&nbsp;&nbsp;<span class="underline cursor">Off</span></a>');
     printer::alert('<a class="info" title="Show Request" href="'.Sys::Self.'?request&amp;#requested">Show Requests </a><a href="'.Sys::Self.'?requestoff">&nbsp;&nbsp;<span class="underline cursor">Off</span></a>');
     printer::alert('<a class="info" title="Debug Messages" href="'.Sys::Self.'?debug">Debug Messages</a><a href="'.Sys::Self.'?debugoff">&nbsp;&nbsp;<span class="underline cursor">Off</span></a>');
     printer::alert('<a class="info" title="Show called methods" href="'.Sys::Self.'?methods&amp;#bottom">Show Methods Called </a><a href="'.Sys::Self.'?methodsoff">&nbsp;&nbsp;<span class="underline cursor">Off</span></a>');
     printer::alert('<a class="info" title="Show mysqli calls" href="'.Sys::Self.'?mysql">Show Mysql Calls </a><a href="'.Sys::Self.'?mysqlsoff">&nbsp;&nbsp;<span class="underline cursor">Off</span></a>');
     printer::alert('<a class="info" title="Show constants" href="'.Sys::Self.'?constants&amp;#bottom">Show constants</a><a href="'.Sys::Self.'?contantsoff">&nbsp;&nbsp;<span class="underline cursor">Off</span></a>');
     printer::alert('<a class="info" title="Show Session" href="'.Sys::Self.'?session&amp;#bottom">Show session info </a><a href="'.Sys::Self.'?sessionoff">&nbsp;&nbsp;<span class="underline cursor">Off</span></a>');
     printer::alert('<a class="info" title="Show included files" href="'.Sys::Self.'?includes&amp;#bottom">Show included files </a><a href="'.Sys::Self.'?includesoff">&nbsp;&nbsp;<span class="underline cursor">Off</span></a>');
     printer::alert('<a class="info" title="Show delta time take for methods to run" href="'.Sys::Self.'?deltatime&amp;#bottom">Clock Time Rendering on Server </a><a href="'.Sys::Self.'?deltatimeoff">&nbsp;&nbsp;<span class="underline cursor">Off</span></a>'); 
     printer::alert('<a class="info" title="Show delta time take for methods to run" href="'.Sys::Self.'?deltatimepost&amp;#bottom">Clock Time Rendering per Post type on Server </a><a href="'.Sys::Self.'?deltatimepostoff">&nbsp;&nbsp;<span class="underline cursor">Off</span></a>'); 
     printer::alert('<a class="info" title="display server variables" href="'.Sys::Self.'?server&amp;#bottom">Display Server Vals </a>
                    <a href="'.Sys::Self.'?serveroff">&nbsp;&nbsp;<span class="underline cursor">Off</span></a>'); 
	printer::close_print_wrap('configure wrap',true);
     $this->show_close('Configure this Page');
	echo '</div><!-- float buttons-->';
     }
 /*Debugging information can be displayed through the use of requests.
?showlist prints out this list
the following requests provide the following information and persist for the current session unless turned off
?showlistoff turns off appending off to any info request turns it off ?allon provides all available information
?alloff all information rendered off
****for debugging and to determine script progress if error message not present
use ?debug and/or ?methods
?methods returns method names that the running classes have invoked
?debug...
?debug providest some loaded method info and additional information to determine what rendering error has occured
************** ?info gives screen viewport size on when logged in on reg page
?constants displays values of all the Sys::Consts
?styleoff shuts off styles for easier html viewing and debugging
?gallery_info parameters surrounding gallery rendering
?cacheon returns caching to On (going to edit pages turns it off)
?server gives server printout
?tables gives request and session printout
?session print session info print session info .
?session_destroy kill all sessions
?includes returns included files unless script error: if error use ?debug and ?methods
?query returns request query called by global_master header for every page!
?deltatime time rendering
?request gives $_POST and $_GET printout
?bufferoutput buffers entire page and echo's at end...
?mysql output of mysql queries,etc. individual requests may be turned off by appending off to the request ie ?queryoff  */   
function magnify_margins(){
     ##################### advance off button
	echo '<div class="floatbutton"><!-- float buttons-->';
	$msg='Click Button to enlarge borders and add margin and padding spacing in order to better see column arrangement. In certain circumstance can cause a floated post to break to new line';
     if (!isset($_GET['magnify_margins']))
          printer::printx('<p class="info click buttoneditcolor editfont smallest" title="'.$msg.'"> <a style="color:inherit;"  href="'.Sys::Self.'?magnify_margins">Margin Magnify</a></p>');
     else 
          printer::printx('<p class="info click buttoneditcolor editfont smallest" title="'.$msg.'"> <a style="color:inherit;"  href="'.Sys::Self.'">Disable Margin Magnify</a></p>'); 
	echo '</div><!-- float buttons-->';
     }
    
function edit_header(){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
 (Sys::Deltatime)&&$this->deltatime->delta_log(__LINE__.' @ '.__method__.'  '); 
    
    if (!empty($this->header_edit_script)){
	  foreach ($this->header_edit_script as $var){
		  if (!empty($var)){
			 echo ' 
			 <script    src="'.$this->roots.Cfg::Script_dir.$var.'"></script> ';
			 }
		  }
	   }
    }

#editpages_obj     
function editpages_obj($master_table,$field_data,$post_prepend,$ref1,$refval1,$ref2='',$refval2='',$do_all='all',$where3='',$update2=''){ #update# Updating posts in main process_blog function calling this function handles originals ie non-clones.. whereas updaing for local clone style and local clone data call this function in each repective section in the main blog_render function..  for the clones same parameters are passed cept has additional where blog_table_base='$this->pagename' clause  and instead of using master_post uses master_post_css or master_post_data for clone_local_style and  clone_local_data respectively
	#the system uses the pagename and order instead of id  which allows for proper order information ie. placement to occur naturally
	$print=($do_all!=='populate_data'&&isset($_POST['submitted'])&&(false))?true:false;    
	($print)&&printer::alert_neu( NL.NL."master table: $master_table, field_data,$post_prepend,ref1: $ref1,refval: $refval1,ref2: $ref2,refval2 $refval2='',do: $do_all and where3 is $where3 and update2= $update2",1.5);
	$where2=(empty($ref2))?'':" AND $ref2='$refval2' "; 
	$field_array=explode(',',$field_data); 
	if (isset($_POST['submitted'])){	 
		  if ($do_all!='populate_data'){#in blog_render updating will be done after new entries are added..   
			# Note:
			#remember that the post will handle the individual posted array elements if they exist!...
			# process spam scrubber will psuedo implode all the data for storage in database
			#the post will pass the variable as array if sent as keys 
			$update= 'SET '; 
			//standard form for processing is $this->blog_table.'_'.$refval1.'_blog_field
			for ($x=0; $x<count($field_array); $x++){
				foreach (array('','_arrayed') as $check_suffix){
				 	if (isset($_POST[$post_prepend.$field_array[$x].$check_suffix])){ ($print)&&printer::alert_neg('is post '.$post_prepend.$field_array[$x].$check_suffix); 
						if (is_array($_POST[$post_prepend.$field_array[$x].$check_suffix])){
                                    ($print)&&printer::alert_pos('Is array ');
							
                                   $q='select '.$field_array[$x]." from $master_table WhErE $ref1 ='$refval1' $where2 $where3";   ($print)&&printer::alert_pos("Select $q"); 
							$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);  
							list($c_val)=$this->mysqlinst->fetch_row($r,__LINE__);
							 
							${$field_array[$x]}=process_data::implode_retain_vals($_POST[$post_prepend.$field_array[$x].$check_suffix],$c_val,',','@@'); 
							}
						
						else {#check for tiny-mce submit from text post
                                    if ($check_suffix==='_arrayed'&&strpos($field_array[$x].$check_suffix,'blog_text_arrayed')!==false)
                                        ${$field_array[$x]}=process_data::pre_spam_scrubber($_POST[$post_prepend.$field_array[$x].$check_suffix]);
                                   else ${$field_array[$x]}=process_data::spam_scrubber($_POST[$post_prepend.$field_array[$x].$check_suffix]);//chdnged from blog_check.$field_array.$check_suffix
                                   }
						$update.=" {$field_array[$x]}='${$field_array[$x]}',"; 
						}
					 }
				}
			if ($update=== 'SET '&& $do_all!=='all')return;
			elseif ($update!= 'SET '){  
				$update=substr_replace($update ,"",-1);     
				$q="UPDATE $master_table $update $update2 WherE $ref1 ='$refval1' $where2 $where3";
                    ($print)&&printer::alert_pos('  q is'.$q ,1.5); 
				$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
				$vars=(mail::Defined_vars)?get_defined_vars():'defined vars set off';
				$vars=print_r($vars,true); 
				try {  
					if ($this->mysqlinst->affected_rows()) { 
						$msg=($this->is_blog)?'POST ENTRIES HAVE BEEN UPDATED PLEASE DOUBLE CHECK':'PAGES HAVE BEEN UPDATED PLEASE DOUBLE CHECK';
						(!in_array($msg,$this->success))&&$this->success[]=$msg;
						// $this->backup_page_arr[]=array($master_table,"WherE $ref1 ='$refval1' $where2 $where3",$update);#used for generating styles of pages where clones of posts may be used.
						}
					else {
						if (Sys::Debug)echo NL. $q. NL;
						$msg="Problem Updating with: $q  End Q";
						$this->message[]=$msg;
							throw new mail_exception($msg." ".$q);
						}
					}	
				catch(mail_exception $me){
					$me->exception_message();  
					}
				}//end update
				 	
			
			(!$this->is_blog)&&$this->master_page_ref=$this->pagename;// this is for render_backups()..
			#regardless of affected or not backup
			##remember css is generated whether submitted or not whereas otherwise backups must be submitted
			}
		}// if submitted
		
		
	if ($do_all==='update')return; #job in blog_render is done...
	$q = "SELeCT $field_data FROM $master_table  where $ref1 ='$refval1' $where2";    
	$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); 
	if ($refval1==='indexpage'&&$ref1==='page_ref'&&$where2==''&&!$this->mysqlinst->affected_rows()) {
		$page_fields=Cfg::Page_fields;
		$page_fields_all=Cfg::Page_fields_all;
		$page_fields_arr=explode(',',$page_fields);
		$this->mysqlinst->count_field($this->master_page_table,'page_id','',false,'');  
		$page_id=$this->mysqlinst->field_inc;
		$q="insert into $this->master_page_table ($page_fields_all) values (";
		foreach ($page_fields_arr as $field){
			if ($field==='page_id')$q.="'$page_id',";
			elseif ($field==='page_ref')$q.="'indexpage',";
			else if ($field==='page_title')$q.="'Home',"; 
			else if ($field==='page_filename')$q.="'index',";
			else if ($field==='page_style')$q.="',,0,0,0,0,0,0,0,0,Lucida Sans Unicode=> Lucida Grande=> sans-serif;,20@@@@@@@@@@@@@@2000@@250,0,0,444,0,0,0,0,0,0,ffffff@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat,0,0,0,0@@0@@0@@0@@0@@inset,0,8@@000@@0@@top',";
			else if ($field==='page_options')$q.="'dark,0,0,0,0,,,,,,page_rem_scale_enable,,,,,,2,,2000,240,100,20.00,0,ffffff,000000,c82c1d,c82c1d,64C91D,64C91D,,turnon,,,disabled,,media_style_off',";
			else if ($field==='page_dark_editor_value')$q.="'00ffff,0FCEA6,00bfff,FFFF00,ffefd5,afeeee,eee8aa,fdf5e6,dcdcdc,b0e0e6,8fbc8f,ffffff,1e90ff,800000,2B1DC9,C91B45,00ff00,ff4500,ff6600,c6a5a5,0075a0,816227,266a2e,a9a9a9,dccbcb,bdb76b,8b008b,556b2f,ff8c00,9932cc,8b0000,e9967a,483d8b,CDFFF5,2f4f4f,d87093,98fb98,9400d3,ff1493,696969,b22222,fffaf0,228b22,ff00ff,ffe4b5,ff00ff,808000,6b8e23,da70d6,ffdab9,00ced1,ffdead,cd853f,dda0dd,bc8f8f,4169e1,8b4513,fa8072,f4a460,2e8b57,ede5e5,000000,e5d805,7AFFE8,04B18D',";
			else if ($field==='page_dark_editor_order')$q.="'aqua,darkaqua,deepskyblue,yellow,papayawhip,paleturquoise,palegoldenrod,oldlace,gainsboro,powderblue,darkseagreen,white,dodgerblue,maroon,navy,cherry,brightgreen,orangered,orange,lightmaroon,ekblue,brown,green,darkgrey,lightermaroon,darkkhaki,darkmagenta,darkolivegreen,darkorange,darkorchid,darkred,darksalmon,darkslateblue,lightlightaqua,darkslategray,palevioletred,palegreen,darkviolet,deeppink,dimgrey,firebrick,floralwhite,forestgreen,fuchsia,moccasin,magenta,olive,olivedrab,orchid,peachpuff,darkturquoise,navajowhite,peru,plum,rosybrown,royalblue,saddlebrown,salmon,sandybrown,seagreen,lightestmaroon,black,gold,lighteraqua,darkeraqua',";
			
			else $q.="'0',";
			}
		$q="$q '".date("dMY-H-i-s")."','".time()."','".$this->token_gen()."')";
		$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); 
		$q = "SELeCT $field_data FROM $master_table  where $ref1 ='$refval1' $where2";    
		$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
		}
	try {
		if (!$this->mysqlinst->affected_rows()) { 
			if (Sys::Debug)echo NL.'failed '. $q. NL;
			$msg=' in db '.Sys::Dbname.  " Edit Site Temporarily Down-  Check back later line: " .__LINE__.' in '.__method__;
			$this->message[]=$msg .' with '.$q;
			echo '<p style="font-weight: bold; font-size: 1.4em; color:#'.$this->redAlert.'">'.$msg.'</p>';
			throw new mail_exception($msg." ".$q);
			
			}
		}
	catch(mail_exception $me){
		$me->exception_message();
		return;
		}
	$rows=$this->mysqlinst->fetch_assoc($r,__LINE__);
		#in order to render a html break to javascript tinymce box when enabled and a validated line break to plain textarea the
		#followiing is being implemented
		$process=process_data::instance();    
	 for ($x=0; $x<count($field_array); $x++){
		$this->{$field_array[$x]}= $rows[$field_array[$x]];//populate data
		}  
	if (Sys::Debug) echo 'leaving funct editpage entirely!!';  
	}#end function edit pages_obj


     
function top_submit(){if(Sys::Custom)return;if (Sys::Quietmode||Sys::Pass_class) return;
	echo '<div class="floatbutton"><!-- float buttons-->';
	echo'  <p><input class="editbackground editfontfamily '.$this->column_lev_color.' shadowoff cursor  smallest buttoneditcolor"   type="submit" name="submit"   value="submit All" ></p>';
	echo '</div><!--float buttons-->'; 
	} 
 
function editor_overview(){if (Sys::Quietmode) return;
	$scaling='There are 3 basic ways to set up responsize scaling of rem em and px units so that the widths paddings borders and font sizes they specify will smallerize on progressively smaller screen sizes. To make scaling more relevant you can choose the upper and lower widths over which scaling is to take place. Each scaling choice also allows for a modification of the one to one scaling. Smallerization is done  automatically through @media queries over the range of sizes of upper and lower screen widths you choose. <br><br>
		Rem which is always linked to  font-size directly under the html tag and and found just below. If no scaling is chosen each rem unit choice specifies an original default value 16px per unit of size by default for any width, font, padding, or margin, etc. choice. However, you can increase or decrease this rem unit size directly affecting all rem unit values on the page. Moreso, by choosing to scale the value of a rem unit the absolute width value will decrease  proportionally to user view screen width. <br> However a one to one relationship between width and view screen doesnt suffice in all circumstances. This relationship is adjusted in the rem scaling (for rem units) and the rwd scale (for px units that also effect em size when done to font units.<br><br>Setting up  em scaling and customization is done similarly  except this option is tied to the font-size choices you make in the default page styles you make under page options, and under column font-styles settings. These choices will affect all em choices made in child posts. Please Note em settings are compoundable meaning em units themselves mulitply a parent em value if previously chosen.  <br><br>
So the actually scalability of em units is made through font-size choice as initially setup under the page options or in any column by choosing font-size px, then choose the rwd_scale option, the relavent upper and lower widths at which scaling takes place and any modification of one to one relationship that may better suit you needs. Note em compoundabilty ends when a new font-size  choice is made not directly in em units.<br><br>
Lastly scaling may be set up directly in any width, padding, margin, border, and other options in any post or column for needs that are not met by currently scaled em or rem choices in much the same way,  by choosing font size and then rwd scale options.';   

	printer::alert($scaling);
     printer::print_tip('
	To enable consistent navigation between pages it is a good idea to to set all your webpages to the same width, so that navigation menus line up in same place page to page. Use import and export page options to standardize pages if needed.  
	<br> 
	');
	}


function isJson($string) {
     json_decode($string);
     return (json_last_error() == JSON_ERROR_NONE);
    }

     
function token_gen(){
	return mt_rand(1,mt_getrandmax());
	}
         
function view_page(){ if (Sys::Quietmode)return;  
	echo '<div class="floatbutton"><!-- float buttons-->';
	$this->navobj->return_url($this->pagename,'','white darkslatebluebackground rad5 smallest buttondarkslateblue');
	echo '</div><!--float buttons-->';
	}
function leftover_view(){
	echo '<div class="floatbutton" id="handle_leftovers" ><!-- float buttons-->';
	if(!isset($_SESSION[Cfg::Owner.'_'.$this->pagename.'_leftovers'])){
		echo '</div>';
		return;
		} 
	echo '</div><!--float buttons-->';
	}
     

function display_anchor(){if (Sys::Quietmode) return;  if (Sys::Pass_class)return; 
	echo '<div class="floatbutton"><!-- float buttons-->';
	echo '<p class="'.$this->column_lev_color.' smallest  editbackground editfont buttoneditcolor click"  onclick="gen_Proc.toggleClass2(\'#display_anchor\',\'hide\');gen_Proc.use_ajax(\''.Sys::Self.'?display_anchor\',\'handle_replace\',\'get\');" >GoTo Posts</p>';
	echo '<div id="display_anchor" class="hide small left floatleft fsminfo editbackground editfont editcolor"></div>';  
	echo '</div><!--float buttons-->';
	}
     

function browser_size_display(){if (!Sys::Info&&!$this->edit)return;
	$background=($this->edit)?'editbackground editfont':'whitebackground';
	$style=(!$this->edit)?'style="position:fixed;top:0px; left:0px;z-index:1000000"':'';
	$class1=(!$this->edit)?'hide':'';
	$class2=($this->edit)?'hide':'';
	echo '<div class="floatbutton"><!-- float buttons-->
	<div id="displayCurrentSize"  class="'.$class1.' editfontfamily smallest buttoneditcolor rad5 editbackground editcolor">
	<div class="editfontfamily editcolor editbackground "><p id="clientw"></p>
	</div>
	</div>
	</div><!--float buttons-->';
	echo '<div id="displayCurrentSize2" '.$style.' class="'.$class2.' editfontfamily whitebackground "><p id="clientw2" class="rad5"></p>
	</div>';
	}
     
function generate_cache($cache='page_cache',$resize=false){ 
     $name=$cache;
	$cache=trim($this->$cache);
     $page_cacheupdate_arr=array();
	if (!empty($cache)){
		$pattern='/\s+/';
		$cache=preg_replace($pattern,'',$cache);
          $cache=str_replace('@@',',',$cache);//taking into account page_option values which cannot have commas
		$cache_arr=explode(',',$cache);
		foreach($cache_arr as $ext){ 
			if (is_numeric($ext)&&trim($ext) > 99&&trim($ext) < 2401){ 
				$page_cacheupdate_arr[]=($ext); 
				}
			else {  
				$msg='Error in Cache: '.$name.' for ext:'.$ext.'  cache dir size must be greater than 99 and less than 2401';
				//$this->message[]=$msg; 
				}
			}//end foreach
          sort($page_cacheupdate_arr); 
		($name==='page_cache')&&$this->page_cache_arr=$page_cacheupdate_arr;
		}//not empty
           
	if (empty($page_cacheupdate_arr)) { 
          switch($name){
               case 'page_cache':
                    $this->page_cache_arr=explode(',',Cfg::Image_response );
                    $this->page_cache=Cfg::Image_response;
                    break;
               case 'page_tiny_cache';
                    $this->page_tiny_cache=Cfg::Tiny_image_cache;
                    break;
               case 'page_carousel_cache';
                    $this->page_carousel_cache=Cfg::Tiny_image_cache;
                    break;
               }
		}
     else { 
          $cache=implode(',',$page_cacheupdate_arr);
          $this->$name=$cache;
          }
	if ($resize) return $this->page_cache_arr;
	if ($name==='page_cache'&&implode(',',$this->page_cache_arr)!==$this->page_cache){  
		$q="update $this->master_page_table set  page_update='".date("dMY-H-i-s")."', page_time=".time().",token='".mt_rand(1,mt_getrandmax()). "',page_cache='".implode(',',$this->page_cache_arr)."' where page_ref='$this->page_ref'";
		$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
		}  
	}	

function generate_bps(){ 
	$this->page_br_points=trim($this->page_break_points); 
	if (!empty($this->page_br_points)){ 
		$pattern='/\s+/';
		$this->page_br_points=preg_replace($pattern,'',$this->page_br_points); 
		$this->page_break_arr=explode(',',$this->page_br_points);
               $page_breakupdate_arr=array();
               foreach($this->page_break_arr as $bp){ 
				if (is_numeric($bp)&&trim($bp) > 100){ 
					$page_breakupdate_arr[]=($bp); 
					}
				else {  
					$msg='Error in Breakpoints: '.$bp.' breakpoints must be greater than 100 and this entry has been removed.';
					$this->message[]=$msg; 
					}
				$this->page_break_arr=$page_breakupdate_arr;
				}//end foreach
		}//not empty
	else { 
		$this->page_break_arr=explode(',',Cfg::Column_break_points);
		$this->page_br_points=Cfg::Column_break_points;
		}
	rsort($this->page_break_arr);
	if (implode(',',$this->page_break_arr)!==$this->page_break_points){  
		$q="update $this->master_page_table set  page_update='".date("dMY-H-i-s")."', page_time=".time().",token='".mt_rand(1,mt_getrandmax()). "',page_break_points='".implode(',',$this->page_break_arr)."' where page_ref='$this->page_ref'";
		$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
		}
	}


#pageconf #pageop
function configure(){ 
	echo '<div class="floatbutton"><!-- float buttons-->';
	$this->show_more('Configure Page','buffer_configure_page',$this->column_lev_color.' smallest editbackground editfont button'.$this->column_lev_color,'','','','','asis');
	$this->print_wrap('configure wrap',true);
     $this->submit_button();
     printer::alertx('<p class="info smaller floatleft clear">Cur Db: '.Sys::Dbname.'</p>');
     printer::pclear();
     $this->display_parse_options('page',$this->page_id);
     printer::pclear(7);
     $this->show_more('Scale Units Overview &amp; Some Basic Pointers on the editor system','noback','','',800);
	$this->print_redwrap('basic pointers');
     $this->editor_overview();
     $this->close_print_wrap('basic pointers');
	$this->show_close('Some Basic Pointers on the editor system');
     printer::pclear(2);
	$this->configure_editor();
	printer::pclear();
	$this->show_more('Set Image Dir Cache Sizes','noback','','',600);
	$msg='<b>Image Posts and Auto slide Posts Cache Sizes</b><br> More directory sizes means served images are more efficiently downloaded and decreases bandwidth. However, more sizes also means more server disk space is used to cache the images. Adjust the default balance here depending on limiting server space or bandwidth.  Note: Quality level also affects download speed and server space used and can be adjusted for the ideal balance with page defaults, but also on the configuaration for images, autoslide show and galleries';
	$this->print_redwrap('cache sizes');
     printer::print_wrap('page image cache');
     printer::print_info('Separately set Cache sizes for image and autoslide posts, carousel posts, and images uploaded with tiny-mce in text posts');
	printer::print_tip($msg);
	printer::alertx('<p class="warnlight">Changes of this setting will apply to every page in the site and images will generated to fill any new cache directory sizes on all pages. This may take awhile, wait for all iframes to load before leaving this page.</p>');
	echo '<p class="ramana" title=" Be sure to enter numerical values separated by commas ie: '.Cfg::Image_response.'">Change Image Default Cache Dir Sizes <span class="editcolor small">(comma separate):</span> 
	<input type="text" value="'.$this->page_cache.'" name="page_cache" size="50" maxlength="65"></p>
	';
	printer::close_print_wrap('page image cache');
    // $this->page_options[$this->page_tiny_cache_index]=str_replace('@@',',',$this->page_options[$this->page_tiny_cache_index]);
     if (!is_dir(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir))
          mkdir(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir,0775,1);
     #ajax calls need to process this data for javascript update if file missing! they do not go pass through normal value processing from database but will retreive vale from file
     file_put_contents(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'tiny_cache.dat',$this->page_tiny_cache);
     file_put_contents(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'carousel_cache.dat',$this->page_carousel_cache);
     printer::print_wrap1('tiny cache');
     printer::print_tip('<b>Text Post Tiny-mce Uploaded Image Cache sizes</b><br>A default tiny-mce minimum width size is downloaded then automatically according to any width specification made through class or direct styling on the element using the cache image size that is the same or next size larger');
      $this->mod_spacing('page_options['.$this->page_tiny_min_index.']',$this->page_tiny_cache_min,100,1000,10,'px');
     $this->show_more('Min effective cache Info','','editbackground editcolor italic');
     
     printer::print_tip('Uploaded images smaller than '.$this->page_tiny_cache_min.' set here will be served without resizing at the original width and browser-sized as needed. Larger uploaded images will be cached to sizes smaller or equal to the uploaded image size.  Responsive sizing occurs on onloading to provide next optimum over or equal to size required up to largest cache size or original size whichever is smaller.'); 
     $this->show_close('Min effective cache Info');
	echo '<div class="fsmnavy editbackground editfont highlight floatleft" title=" Be sure to enter numerical values separated by commas ie: '.Cfg::Image_response.'">Change tiny-mce uploaded images in text type posts. Minimum effective cache: '.$this->page_tiny_cache_min.'. Current Cache Dir Sizes: <span class="editcolor small">(comma separate):</span> ';
     
     echo'
	<input type="text" value="'.$this->page_tiny_cache.'" name="page_options['.$this->page_tiny_cache_index.']"   size="50" maxlength="65">
	';
	echo'</div>';
     printer::close_print_wrap1('tiny cache');
	printer::pclear();
	#######################
	printer::print_wrap1('carousel cache');
     printer::print_tip('Change carousel default downloaded image size which Larger Sized images will be automatically replaced according to the width specification you make and the next largest cache size specified');
      $this->mod_spacing('page_options['.$this->page_carousel_min_index.']',$this->page_carousel_cache_min,100,1000,10,'px');
     
     $msg='You can also change default cache sizes used in the text areas for carousel uploaded images';
	printer::print_tip($msg);
	printer::alertx('<p class="warnlight">Changes of this setting will apply to every page in the site and images will generated to fill any new cache directory sizes on all pages. This may take awhile, wait for all iframes to load before leaving this page.</p>',1.1);
	$this->show_more('Min effective cache Info','','editbackground editcolor italic'); 
     printer::print_tip('Uploaded images smaller than '.$this->page_carousel_cache_min.' set here may be served without resizing at the original width and browser-sized as needed. Larger uploaded images will be cached to sizes smaller or equal to the uploaded image size.  Responsive sizing occurs on onloading to provide next optimum over or equal to size required up to largest cache size or original size whichever is smaller.'); 
     $this->show_close('Min effective cache Info');
     echo '<div class="fsmnavy editbackground editfont highlight floatleft" title=" Be sure to enter numerical values separated by commas ie: '.Cfg::Image_response.'">Change carousel-mce uploaded images in text type posts. Minimum effective cache: '.$this->page_carousel_cache_min.'. Current Cache Dir Sizes: <span class="editcolor small">(comma separate):</span> ';
      echo'
	<input type="text" value="'.$this->page_carousel_cache.'" name="page_options['.$this->page_carousel_cache_index.']"   size="50" maxlength="65">
	';
	echo'</div>';
     printer::close_print_wrap1('carousel cache');
	printer::pclear();  
	$this->close_print_wrap('cache sizes');
	$this->show_close('Set Image Dir Cache Sizes');
	#######################
	$this->show_more('Init Orig RWD Grid Settings','noback','');
	$this->print_redwrap('Edit RWD Grid Settings');
	printer::print_tip('Note: This original version Rwd system may be discontinued in the future. Configure the original RWD Grid Settings here. An easier to use more versatile RWD grid system is available under the main width options #3 choice with no pre-configuration necessary.');
	printer::print_tip('This 100 grid unit RWD system tracks available full screen width at all break points being used through successful parent/child generations if used for easy percentage selections');
	$this->show_more('Set RWD Breakpoints','noback','');
	$msg='Breakpoints for the RWD grid set Here, otherwise Default values are presented<br><span class="editfont lightestmaroonbackground info "> Keeping this breakpoint setting consistent between pages enables using cloning moving and copying of rwd columns between pages without resetting the rwd chosen width percentages in posts on the receiving page and also keeps the width calculator accurate.</span><br>You can also choose page export/import option to keep RWD bps consistent between pages.';
     
	$this->print_redwrap('break points'); 
	printer::printx('<p class="fsmnavy editbackground editfont editcolor smaller">'.$msg.'</p>');
     printer::print_tip('Adding or removing bps on either end should not disrupt current gu selection. Adding in middle will disrupt seeting. See the tune option below to preserve settings');
	echo '<div class="fsmnavy editbackground editfont highlight floatleft" title="The RWD system uses 1 to 10 max-width break points for user Device Screen Size to Deliver appropriate sized content. Be sure to enter numerical values separated by a comma ie: '.Cfg::Column_break_points.'. 10 break point max. Min size bp 101">Change Default Break Points <span class="editcolor small">(comma separate):</span> 
	<input type="text" value="'.$this->page_br_points.'" name="page_break_points"   size="20" maxlength="40">';
	echo'</div>';
	printer::pclear();
     printer::print_warn('Better to use the tune Rwd setting below to adjust the numeric value of a setting without disturbing current RWD post percent selections.');
	###############
	echo '<p class="fsm'.$this->column_lev_color.'"><input type="radio" name="page_add_bp" value="page" checked="checked">Add/Subtract Break Point(s) this page<br>
		<input type="radio" name="page_add_bp" value="site"><span class="highlight" title="make this change on all pages to keep breaks consistent for cloning, copying and moving options">Add/Subtract Break Point(s) on All Pages</span></p>'; 
	###########
     $this->close_print_wrap('break points');
     
	$this->show_close('Set RWD Breakpoints');
	$this->show_more('Tune RWD Breakpoints','noback','');
	$msg='If you have already set-up  RWD grid percentages and wish to maintain the settings but change a bp value then here its possible to Tune the Value of a Breakpoint for a New Value Without Disturbing the current RWD Grid settings. Also choose the sitewide option to adjust bps to all other pages for consistent rendering across pages. Adjustments should also follow descending order when multiple bps are used'; 
	$this->print_redwrap('tune break points'); 
	printer::print_tip($msg);
	echo '<div class="fsmnavy editbackground editfont editcolor floatleft"><!--wrap change bp-->Enter Changes for New  Break Point Adjust';
	foreach ($this->page_break_arr as $bp){
		echo '<p>Previous Value:'.$bp.'
	<input type="text"  name="page_adjust_break_points['.$bp.']"   size="4" maxlength="4" value="'.$bp.'">';
		}//end foreach
	printer::pclear();
	echo '<p class="fsm'.$this->column_lev_color.'"><input type="radio" name="page_sub_bp" value="page" checked="checked">Substite Break Point(s) this page<br>
		<input type="radio" name="page_sub_bp" value="site"><span class="highlight" title="make this change on all pages to keep breaks consistent for cloning, copying and moving options">Substite Break Point(s) on All Pages</span></p>';
	echo'</div><!--wrap change bp-->';
	printer::pclear();
	$this->close_print_wrap('tune break points'); 
	$this->show_close('Change RWD Breakpoints');
     
       $this->show_more('Change default Grid Units','noback');
       printer::print_wrap('grid choices');
        $this->show_more('Grid info choice','noback','smaller editbackground editfont italic editcolor');
     echo'<p class="fsminfo editbackground editfont editcolor floatleft" > By Default the RWD system uses a "Grid System" with 100 grid units or 1 percent of the row width for each gu chosen for posts and .5gu increments for any spacing between posts. In the event even smaller spacing increments are necessary up to 200 grid units may be chosen. Note:(Higher Grid Unit Choices will not produce extra class styles as only the relevant choices are generated"</p>';
    $this->show_close('Grid info choice');
     $this->mod_spacing('page_options['.$this->page_grid_units_index.']',$this->page_grid_units,12,200,1,'grid-units');
     printer::alert_neu('Resetting grid unit value should auto update current gu settings of rwd grid activated posts within this column to occupy close to the same % of row. (floor is used and could lower % when going to much smaller grid units)');
      echo '<p class="fsm'.$this->column_lev_color.'"><input type="radio" name="page_grid_unit_change" value="page" checked="checked">Change grid unit value this page<br>
		<input type="radio" name="page_grid_unit_change" value="site"><span class="highlight" title="make this change on all pages to keep grid units consistent for cloning, copying and moving options">Change grid unit value on All Pages</span></p>'; 
     printer::close_print_wrap('grid choices');
     $this->show_close('Change default Grid Units');
	$this->close_print_wrap('RWD Grid Settings'); 
	$this->show_close('Edit RWD Grid Settings','noback','');
     printer::pclear();
     $msg='Optionally Set up em scaling units using the font size choice below'.NL.
	'Borders and Box shadows will only affect the current element ie. never inherited whereas Text and Background Styles  are. <br> ';
	$this->edit_styles_close('body','page_style','body.'.$this->pagename,'background,font_color,text_shadow,font_family,font_size,font_media_unit,borders','Set Body Background and Default Text Styles','noback',$msg);
     $this->show_more('Add Full Page background Slide Show');
	$msg="Enable or disable a Full Page Background slide Show Here and make posts as required";
	$this->print_wrap('Page background Slide Show');
     #we are converting page enable slide show from a page option to a page tiny data2 option because we need to prevent it from being exported to other pages when page options are updated.  all page slide options should now be under page_tiny_data1,2,3 
     $options_arr=explode(',',$this->page_tiny_data2);
	if (array_key_exists(3,$options_arr)&&$options_arr[3]==='enable_page_slideshow'){ 
          $this->page_slide_show=true;
		printer::printx('<p class="editcolor"><input type="checkbox" name="page_tiny_data2[3]" value="0">Disable Page Auto Slide Show</p>'); 
		}
	else {// 
          $this->page_slide_show=false;
		printer::printx('<p class="editcolor"><input type="checkbox" name="page_tiny_data2[3]" value="enable_page_slideshow">Enable Page Auto Slide Show</p>');
          
		} 
	$this->close_print_wrap('Page background Slide Show'); 
	$this->show_close('Add Full Page background Slide Show');
	$msg='Group styles are a quick way to style  group of posts and style them &#34;Group Styles&#34; provide a quick means to select consecutive posts within a Column to distinguish them as related such as a simple border or background color.   You begin by checking the begin box on the first post and end box on the last post you wish to style!  Make any number of groups within a column and they will all have the styles you set Here!!  Style borders or box shadows,  background colors, background images, etc. Padding spacing changes made here will increase spacing between posts and borders if used!.  Begin by checking the begin box on the first non column post and check the end box on the last non-column post you wish to distinguish within the same column! Using RWD within the column (as opposed to the whole  or floating within the same with group borders can cause anomolies.  Span column posts between open and close tags as needed.  Match with a close groupstyle before beginning with a new one in the same column.  Unmatched open border and close border checked options will generate an alert mesage and can mess up the webpage styling.   Check both boxes on the same post to end an group and begin another group or to wrap a single post, the system will determine which one is intendted as long as your consistent with closing every opening  ';
	$this->show_more('Default Style Date, and Comment Styles','noback'); 
	$this->print_wrap('Page Style Group, Date',true); 
	printer::printx('<p class="fsminfo editbackground editfont editcolor">Set default Comment and date styles Here. Column level changes will override any default settings made here.  The options to leave Feedback and comments exists in the post options for text type posts only.</p>');
	$this->edit_styles_close('body','page_comment_style', '.'.$this->pagename.' .posted_comment','','Style Overall Comment Entries',false,'Comment Styles will affect all comment post feedback styles for posts made directly in this column');	
	$this->edit_styles_close('body','page_date_style', '.'.$this->pagename.'  .style_date','','Style Post Date Entries',false,'Date Styling Affects Posts within this Column (And within any nested columns unless set there) with Show Post Date Enabled');
	$this->edit_styles_close('body','page_comment_date_style', '.'.$this->pagename.' .style_comment_date','','Style Comment Date Entries',false,'Comment Date Styling Affects Comments within this Column (And within any nested columns unless set there)');
	$this->edit_styles_close('body','page_comment_view_style', '.'.$this->pagename.' .style_comment_view','','Style #/view/Leave Comments',false,'Style the #of Comments  and View/Leave Comments Link');
	#options
	list($fdate,$val,$num)=$this->format_date();
	$this->show_more('Choose/Style Date Format','noback');
     $this->print_redwrap('choose style/date');
	echo '<div class="editcolor editbackground editfont fsminfo"><!--displaydate div-->';
	printer::printx('<p >Choose a date format</p>');
	echo '<div class="style_date"><!--displaydate custom style-->';
	for ($i=0; $i<$num; $i++){
		$checked=($i===$this->page_options[$this->page_date_format_index])?'checked="checked"':'';
		$onclick=(strpos($this->{'fdate'.$i},'style_month')!==false)?'onclick="edit_Proc.displaythis(\'page_style_day\',this,\'#ebf4e7\')"':'';
		printer::printx('
	<input type="radio" '.$onclick.' name="page_options['.$this->page_date_format_index.']" '.$checked.' value="'.$i.'">'.$this->{'fdate'.$i}.'<br>');
		}
	$i++;
	echo '</div><!--displaydate custom style-->';
	$val=(is_numeric($this->page_options[$this->page_date_format_index])&&$this->page_options[$this->page_date_format_index]<$i)?$this->page_options[$this->page_date_format_index]:0;
	$styleit=(strpos($this->{'fdate'.$val},'style_month')!==false)?'style="background:#ebf4e7;"':'style="display:none"';
	echo '<div id="page_style_day" '.$styleit.'><!--additional styling options-->';
	printer::printx('<p class="tip">The Style Date Options Above will style the entire date but for this option there are addition options to independently style the date and the month</p>');
	$this->edit_styles_close('body','page_style_day', '.'.$this->pagename.' .style_day','','Additional Style Day in Date',false,'Additionally style    the day in your chosen date format');
	$this->edit_styles_close('body','page_style_month', '.'.$this->pagename.'  .style_month','','Additional Style Month in Date',false,'Additionally style the Month in your chosen date format');
	echo '</div><!--additional styling options-->';
	echo '</div><!--displaydate div-->';
     printer::close_print_wrap('choose style/date');
	$this->show_close('Choose/Style Date Format');
	$this->close_print_wrap('Page Style Group, Date'); 
	$this->show_close('Style Group,Date, and Comment Styles');
	####################
	$this->show_more('Style Page level H-Tags &amp; Special Classes','noback'); 
	 $this->print_wrap('special styles',true);
	 if(is_file(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'css_data_sheet_'.$this->pagename.$this->passclass_ext)){
		$this->render_view_css=unserialize(file_get_contents(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'css_data_sheet_'.$this->pagename.$this->passclass_ext)); 
		$this->show_more('Current Page Level Tag/Class Styles','', $this->column_lev_color.' editbackground editfont italic ');
		printer::array_print($this->render_view_css); 
		$this->show_close('View Current Tag and Class Styles');
		}
	else $this->render_view_css='';
	printer::printx('<p class="fsminfo editbackground editfont editcolor">Style H tags and class styles here which will be in affect page wise.</p>');
	$msg='Set style HR tags.  HR can be placed anywhere in text and the styles you set here will be expressed. HR are theme breaks, typically bordered lines with spacing. HR Styles may changed in individual column Settings';
	$this->edit_styles_close('bodyview','page_hr','.'.$this->pagename.' hr','width_special,width_max_special,width_min_special,background,padding_all,padding_top,padding_bottom,padding_left,padding_right,margin_all,margin_top,margin_bottom,margin_left,borders,box_shadow,outlines,radius_corner','Set HR Tags','noback',$msg);
	$htag_styles='width_special,width_max_special,width_min_special,width_media_unit,float,background,padding_top,padding_bottom,padding_left,padding_right,margin_top,margin_bottom,margin_left,margin_right,borders,box_shadow,outlines,radius_corner,font_color,text_shadow,font_family,font_size,font_media_unit,font_weight,text_align,text_shadow,line_height,letter_spacing,italics_font,small_caps,text_underline';
	$msg='Set style H1 tags. H tags in general can be placed anywhere in text and the styles you set here will be expressed.';
     $this->edit_styles_close('bodyview','page_h1','.'.$this->pagename.' div h1',$htag_styles,'Set H1 Tags','noback',$msg);
     $msg='Set style H2 tags.  H tags in general can be placed anywhere in text and the styles you set here will be expressed.';
     $this->edit_styles_close('bodyview','page_h2','.'.$this->pagename.' div h2',$htag_styles,'Set H2 Tags','noback',$msg);
     $msg='Set style H3 tags.  H tags in general can be placed anywhere in text and the styles you set here will be expressed.';
     $this->edit_styles_close('bodyview','page_h3','.'.$this->pagename.' div h3',$htag_styles,'Set H3 Tags','noback',$msg);
     $msg='Set style H3 tags.  H tags in general can be placed anywhere in text and the styles you set here will be expressed.';
     $this->edit_styles_close('bodyview','page_h4','.'.$this->pagename.' div h4',$htag_styles,'Set H4 Tags','noback',$msg);
     $msg='Set style H5 tags.  H tags in general can be placed anywhere in text and the styles you set here will be expressed.';
     $this->edit_styles_close('bodyview','page_h5','.'.$this->pagename.' div h5',$htag_styles,'Set H5 Tags','noback',$msg);
     $msg='Set style H6 tags.  H tags in general can be placed anywhere in text and the styles you set here will be expressed.';
     $this->edit_styles_close('bodyview','page_h6','.'.$this->pagename.' div h6',$htag_styles,'Set H6 Tags','noback',$msg);
     $msg='Set a custom class to style a div p  or span style or instead it can be used to style a hr tag (typically for lines) ie.  text styles will not apply.'; 
     $this->edit_styles_close('bodyview','page_myclass1','.'.$this->pagename.' .myclass1',$htag_styles,'Set Class myclass1 Styles','noback',$msg); 
     $this->edit_styles_close('bodyview','page_myclass2','.'.$this->pagename.'  .myclass2',$htag_styles,'Set Class myclass2 Styles','noback',$msg); 
     $this->edit_styles_close('bodyview','page_myclass3','.'.$this->pagename.'  .myclass3',$htag_styles,'Set Class myclass3 Styles','noback',$msg); 
     $this->edit_styles_close('bodyview','page_myclass4','.'.$this->pagename.' .myclass4',$htag_styles,'Set Class myclass4 Styles','noback',$msg); 
     $this->edit_styles_close('bodyview','page_myclass5','.'.$this->pagename.' .myclass5',$htag_styles,'Set Class myclass5 Styles','noback',$msg); 
     $this->edit_styles_close('bodyview','page_myclass6','.'.$this->pagename.' .myclass6',$htag_styles,'Set Class myclass6 Styles','noback',$msg); 
     $this->edit_styles_close('bodyview','page_myclass7','.'.$this->pagename.' .myclass7',$htag_styles,'Set Class myclass7 Styles','noback',$msg); 
     $this->edit_styles_close('bodyview','page_myclass8','.'.$this->pagename.' .myclass8',$htag_styles,'Set Class myclass8 Styles','noback',$msg); 
     $this->edit_styles_close('bodyview','page_myclass9','.'.$this->pagename.' .myclass9',$htag_styles,'Set Class myclass9 Styles','noback',$msg);  
     $this->edit_styles_close('bodyview','page_myclass10','.'.$this->pagename.' .myclass10',$htag_styles,'Set Class myclass10 Styles','noback',$msg); 
     $this->edit_styles_close('bodyview','page_myclass11','.'.$this->pagename.' .myclass11',$htag_styles,'Set Class myclass11 Styles','noback',$msg); 
     $this->edit_styles_close('bodyview','page_myclass12','.'.$this->pagename.' .myclass12',$htag_styles,'Set Class myclass12 Styles','noback',$msg);
     $this->submit_button();
	printer::close_print_wrap('special styles');
	$this->show_close('Style H-Tags and Special Classe');
	##############################333
	$this->show_more('Style A Links');
	$this->print_wrap('alinks','b3salmon editbackground editfont');
	$msg="Style default anchor links styles here .";
	printer::print_tip($msg);
	$this->edit_styles_close('body','page_link', ' A:LINK,body A:visited','font_family,font_weight,font_color,text_shadow,letter_spacing,italics_font,small_caps,text_underline','Style Links'); 
	$this->show_more('Style Hover Over Link Color');
	$this->print_wrap('hover link');
	$page_alink_hover_color=(preg_match(Cfg::Preg_color,$this->page_options[$this->page_alink_hover_color_index]))?$this->page_options[$this->page_alink_hover_color_index]:'inherit';
	$palhc=($page_alink_hover_color==='inherit')?'color:inherit':'color:#'.$page_alink_hover_color.';';
	$this->pagecss.= "body div a:hover{ $palhc}";
	$span_color=(preg_match(Cfg::Preg_color,$this->page_options[$this->page_alink_hover_color_index]))?'<span class="fs1npred" style="background-color:#'.$this->page_options[$this->page_alink_hover_color_index].';">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>':''; 
	printer::alert('Set Default Link Hover Color <input onclick="jscolor.installByClassName(\'colorhover_id\');" style="cursor:pointer;background:#'.$this->editor_background.';color:#'.$this->editor_color.';" type="text" name="page_options['.$this->page_alink_hover_color_index.']" id="colorhover_id" value="'.$page_alink_hover_color.'" size="12" maxlength="6" class="colorhover_id {refine:false}">'.$span_color.'<br>',false,'left editcolor editbackground editfont');
	$this->close_print_wrap('hover link');
	$this->show_close('Style Hover Over Link Color');
	printer::close_print_wrap('alinks');
	$this->show_close('Style A Links');
	$msg='Add links, tags, scripts to head';
	$this->show_more($msg,'','','','700');
	$this->print_wrap($msg);
	printer::print_notice('Caution Advanced Use only. Script Mistakes may break editor function. Database removal under table: master_page table field: page_head');
	printer::print_tip('Append Custom links to css and script files or additional meta tags and css or scripts to the head section');
	$this->page_head=process_data::remove_line_break($this->page_head);
	$this->textarea($this->page_head,'page_head','100','16');
	$this->submit_button();
	printer::close_print_wrap($msg);
	$this->show_close($msg);
	printer::pclear(5);
	$this->show_more('Custom Page CSS','','','','700');
	$this->print_wrap('Custom Page CSS');
	printer::print_tip('Add Custom CSS Must Include Classname or Id. Include CSS complete, Everything except the style Tags. CAUTION; Advanced Use only. Mistakes in this may likely affect all CSS. uses table: master_page field: page_custom_css');
	$this->page_custom_css=process_data::remove_line_break($this->page_custom_css);
	$this->textarea($this->page_custom_css,'page_custom_css','100','16');
	$this->submit_button();
	$this->pagecss.=$this->page_custom_css;
	printer::close_print_wrap('Custom Page CSS');
	$this->show_close('Custom Page CSS');
	printer::pclear(5);
	$this->show_more('Maintenance &amp; Uploads');
	$this->print_redwrap('maintenance',true);
     printer::print_tip('Recommended to Perform One Group Operation at a time');
     $this->submit_button();
	$msg='Generate any missing icons &amp; all edit directory files, &amp; non-flat file folders, etc. for this website. <br> Will not overwrite custom class files. <br>Setting Override=true in config files will cause all icons to be overriden.';
	printer::print_wrap('file generate wrap');
	printer::print_wrap('file generate stu;e','',false,'caution white fsmsalmon');
	echo '<p class=""><input type="checkbox" name="file_generate_site" value="1" >Generate Files</p>';
     printer::pclear(6);
     $this->show_more('Info on Overwriting Common files','','italic tiny editcolor editbackground');
     printer::print_wrap1('overwriting');
     printer::print_tip('System files including default placeholder images, slippry next and prev gallery images, php.ini, .htaccess will not be overwritten if they exist unless you set Cfg::Overwrite to true in the Cfg_master.class.php or if Cfg::Overwrite is true in the Cfg.class.php file which supercedes Cfg_master.php.');
	printer::close_print_wrap1('overwriting'); 
     $this->show_close('Info on Overwriting Common files');
	
     printer::close_print_wrap('file generate style');
	printer::print_wrap('file gnerate','',false,'caution white fsmsalmon');
	echo '<p class=""><input type="checkbox" name="file_generate_local" value="1" >Also Re-Generate Local Class Overwrite if present</p>';
	$this->show_more('Info on Overwriting local override files','','italic tiny editcolor editbackground');
     printer::print_wrap1('overwriting');
     printer::print_tip('site_master.class.php provides means for overwriting or adding to all system functions. Also provides convienant opportunity to include google analytic code expressed sitewide in production not development mode, adding js code, header code etc. This and additional *_loc.class.php files in the local includes file will be overwritten if you check this box.');
	printer::close_print_wrap1('overwriting'); 
     $this->show_close('Info on Overwriting Common files');
     printer::close_print_wrap('file generate style');
     printer::close_print_wrap('file generate wrap');
	printer::print_wrap('page generate','',false,'caution white fsmsalmon');
	echo '<p ><input type="checkbox" name="page_class_generate" value="1" >Re-generate Page Class Files. See info on overwriting</p>';
     printer::pclear(6);
     $this->show_more('Info on Overwriting Page class files','','italic tiny editcolor editbackground');
     printer::print_wrap1('overwriting');
     printer::print_tip('Page class files provide opportunity to manually override functions on a per page basis will not be overwritten if they exist unless you configure Cfg::Overwrite_page_class to true in local file Cfg.class.php settings or for all sites on system using Cfg_master.class.php.');
	printer::close_print_wrap1('overwriting');
     $this->show_close('Info on Overwriting Common files');
	printer::close_print_wrap('page gnerate');
	printer::print_wrap('regen_backup_table','',false,'caution white fsmredAlert'); 
	$msg='Regenerates the backup database. Will recompile list of all stored backup gzipped sql files and delete old files in excess of '.$this->backup_copies. ' (Stored Db gz Copies Setting may be changed in the page_configurations or the setting default in the Cfg file';
	echo '<p ><input type="checkbox" name="regen_backup_table" value="1">Re-Generate Backup database Files</p>';
      $this->show_more('Info on Regenerating Backups','','italic tiny editcolor editbackground');
     printer::print_wrap1('regen');
     printer::print_tip($msg);
	printer::close_print_wrap1('regen');
     $this->show_close('regen');
	printer::close_print_wrap('regen_backup_table');
	$msg='Allowing for all pages to update any caches, style css files, or flat files that may have escapted proper updating. Runs all pages in editmode in iframes';
	$this->print_wrap('iframe all','fsmredAlert');
	printer::print_tip($msg);
	echo '<p class="caution white fsmsalmon"><input type="checkbox" name="page_iframe_all" value="1" onchange="edit_Proc.oncheck(\'page_iframe_all\',\'Checking Here for Maintenance only. All edit-mode pages will be generated in Iframes and this will take a Long Time to Finish, Uncheck to Cancel\')" >Generate all Css,Page Flat Files, etc. for all Edit Mode Pages in Iframes</p>';
	echo '<p title="Navigating to bottom of Iframe Quickly allows for a check of any error message" class="caution white fsmsalmon"><input type="checkbox" name="iframe_bottom" value="1">Also Nav to Iframe Bottom</p>';
	printer::close_print_wrap('iframe all');
	$this->submit_button();
	$msg='Generate all Webpages in iframes (non-edit mode) to quickly check for any errors or intitate custom query';
	$this->print_wrap('iframe all_website');
	printer::print_tip($msg);
	echo '<p class="white goldbackground white fsmsalmon"><input type="checkbox" name="page_iframe_all_website" value="1">Quick Check, etc. all web-mode pages in iframes</p>';
	echo '<p title="Navigating to bottom of Iframe Quickly allows for a check of any error message" class="white goldbackground fsmsalmon"><input type="checkbox" name="iframe_bottom" value="1">Also Nav to Iframe Bottom</p>';
	printer::close_print_wrap('iframe all');
	$this->submit_button();
	$msg='Remove all cached Images and flat files then Re-Generate. Will removed all Images from posts that have been deleted and save disk space.';
	$this->print_wrap('cache regen','fsmredAlert');
	printer::print_tip($msg);
	printer::printx('<p class="redAlert small whitebackground fsmredAlert">Caution: All images will be re-generated from uploads folder images.  Any missing uploads folder images and image will not be re-generated</p>');
	echo '<p class="redAlertbackground white fsmnavy"><input type="checkbox" name="cache_regenerate" value="1" onchange="edit_Proc.oncheck(\'cache_regenerate\',\'Checking Here for Maintenance only. All image caches will be removed then regenerated in Iframes. This will take a Long Time to Finish, Uncheck to Cancel\')" >Remove and Regenerate all Image Caches, Page Flat Files & Generate Css.  Utilizes Iframes</p>';
	printer::close_print_wrap('cache regen');
	$this->submit_button();
	$msg='Remove all flat files then Re-Generate. .';
	$this->print_wrap('cache regen','fsmredAlert');
	printer::print_tip($msg);
	echo '<p class="caution white fsmsalmon"><input type="checkbox" name="cache_regenerate_flatfiles" value="1"  >Remove and Re-Generate all Page Flat Files & Generate Css.  Utilizes Iframes</p>';
	echo '<p title="Navigating to bottom of Iframe Quickly allows for a check of any error message" class="caution white fsmsalmon"><input type="checkbox" name="iframe_bottom" value="1">Also Nav to Iframe Bottom</p>';
	printer::close_print_wrap('cache regen');
     $this->color_reset();
	$this->submit_button();
	printer::close_print_wrap('maintenance');
	$this->show_close('Maintenance');
	printer::pclear(5); 
	$this->edit_metadata();
	$this->submit_button(); 
	printer::close_print_wrap('configure wrap',true); 
	$this->show_close('Configure this Page','buffer_configure_page');//<!--End Show More Configure-->
	echo '</div><!--float buttons-->';
	}
 		
function full_nav(){ if (Sys::Quietmode) return;  
	echo '<div class="floatbutton"><!-- float buttons-->';
	$this->show_more('Full Pages Navigation','','button'.$this->column_lev_color.' navnavy smallest','',' ');
	$this->print_wrap('full page navigation');
	printer::alertx('<p class="tip">This is a full navigation list to edit created pages whether published yet or not. </p>');
	$q="select distinct page_ref, page_title, page_filename from $this->master_page_table  order by page_ref ASC";  
	$r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); 
	while (list($page_ref,$title,$filename) = $this->mysqlinst->fetch_row($r,__LINE__)){
		if (trim($filename)==='')continue;
		echo '<p class="editbackground editfont"><a style="color:inherit;"  href="'.$filename.$this->ext.'">'.$title.': &nbsp;&nbsp;<span class="smaller highlight" title="Page Ref:'. $page_ref.' filename: '.$filename.$this->ext.'">'.$page_ref.'</a></p><br>'; 
		} 
	$this->close_print_wrap('full page navigation');
	$this->show_close('full pages nav'); 
	echo '</div><!-- float buttons--><!--full nav editbackground editfont-->'; 
	}//end full nav

    
function uploads_spacer(){
     echo '<div style="padding-left:15px;" class="floatbutton hidden "><!-- float buttons-->';
     #this is a spacer within the form for uploads function which cannot be in the form which absolute position of it.
     $this->show_more('uploads','','tiny button'.$this->column_lev_color,'','full' );
     $this->show_close('uploads_spacer');
     echo '</div><!-- float buttons-->';
     }
function uploads(){ 
     echo '<div id="top_upload" ><!-- float buttons-->';
	$this->show_more('uploads','',$this->column_lev_color.'  smallest p10 editpages editbackground editfont button'.$this->column_lev_color,'','full' );
     printer::print_wrap('uploads');
     $msg='Image and video are uploaded through image and video posts to the uploads dir for images and the video directory for videos. However, additionally, images, video, and pdf files may be uploaded directly';
     printer::print_info($msg);
     $selected='home';
     $max_upload = (ini_get('upload_max_filesize')<10000)?(int)(ini_get('upload_max_filesize')):(int)(ini_get('upload_max_filesize')/1000000);
	$max_post = (ini_get('post_max_size')<10000)?(int)(ini_get('post_max_size')):(int)(ini_get('post_max_size')/1000000); 
	
     printer::print_info('Pdf file uploader available @ bottom of navigation menu link add/remover page');
     
     $this->show_more('Add Image File Here','','floatleft editbackground editcolor','','navedit_id');
     printer::print_wrap('add img');
     $config=(int)Cfg::Pic_upload_max;//see Cfg_master.class.php 
	$maxup=min($max_upload,$max_post,$config);
     echo '
		Current php.ini limits and User Configurations:
		<table  class="fsminfo editcolor editbackground">
		<tr><th>upload max  <br> php.ini</th><th>post_max_size <br> php.ini</th><th>Cfg::Pic_upload_max; <br>Cfg_master.class.php or Cfg.class.php</th>
		</tr>
		<tr>
		<td>'.$max_upload.'Mb</td><td>'.$max_post.'Mb</td><td>'.$config.'Mb</td>
		</tr> 
		</table>
          <table  class="fsminfo editcolor editbackground">
		<tr><th><b>Upload filesize limit:</b></th></tr>
		<tr><td><b>'.$maxup.'Mb</b></td></tr>
		</table>';
     $maxbytes=$maxup*1000000;
     printer::alert('Upload an image file directly to root dir.',1.1,'navy');
     echo '<div id="upload_formation"></div>';
    echo '<form  id="imageform"  enctype="multipart/form-data" action="'.request::return_full_url().'" method="post" onsubmit="return edit_Proc.checkPicFiles(this,\''.$maxbytes.'\',\'fileinput1\'); return edit_Proc.beforeSubmit();">';
     $folders=array('home','uploads','background_images');
     printer::pclear(15);
     printer::print_info('Choose your upload dir<br><br>For normal images use the upload directory and appropriate copying to cache directories will automatically occur.<br><br> Use tinymce to upload images directly to text posts for special styling. <br><br>  Background_images are loaded through the styling background setting for each post and column. <br>But for special advanced styling you can choose background_image directly.');

     forms::form_dropdown($folders,false,'','','pic_folder_type',$selected,false,$this->column_lev_color);
     printer::pclear(15);
     echo '<p><input type="hidden" name="MAX_FILE_SIZE" value="'.$maxbytes.'"></p> 	
      <fieldset class="navy"><legend> Upload Image File</legend>';
      
     printer::pclear(15);
     echo '
     <p ><b>File:</b> <input id ="fileinput1" style="color: #0ff;" type="file" name="upload" ></p> 
     <p style="padding:25px 10px;"><input type="submit" name="submit" value="Submit Pic Upload" ></p>
     <p><input type="hidden" name="configpicsubmitted" value="TRUE" ></p>';
     echo '</fieldset></form><!--imageform-->';
     printer::pclear(7);
     printer::close_print_wrap('add pic');
     $this->show_close('Add Image Here');
     
     $this->show_more('Add Video Here','','floatleft editbackground editcolor','','navedit_id');
     printer::print_wrap('add vid');
      $config=(int)Cfg::Vid_upload_max;//see Cfg_master.class.php 
	$maxup=min($max_upload,$max_post,$config);
     echo '
		Current php.ini limits and User Configurations:
		<table class="fsminfo editcolor editbackground">
		<tr><th>upload_max_filesize <br> php.ini</th><th>post_max_size <br> php.ini</th><th>Cfg::Vid_upload_max; <br>Cfg_master.class.php or Cfg.class.php</th>
		</tr>
		<tr>
		<td>'.$max_upload.'Mb</td><td>'.$max_post.'Mb</td><td>'.$config.'Mb</td>
		</tr> 
		</table>
          <table  class="fsminfo editcolor editbackground">
		<tr><th><b>Upload filesize limit:</b></th></tr>
		<tr><td><b>'.$maxup.'Mb</b></td></tr>
		</table>';
     $maxbytes=$maxup*1000000;
     printer::alert('Upload a Video file Here',1.1,'navy');
     echo '<form enctype="multipart/form-data" id="videoform" action="'.request::return_full_url().'" method="post" onsubmit="return edit_Proc.checkVidFile(this,\''.$maxbytes.'\',\'fileinput2\'); return edit_Proc.beforeSubmit();">';
      printer::pclear(7);
     printer::print_info('Choose your upload dir');
     $folders=array('home','video');
     forms::form_dropdown($folders,false,'','','vid_folder_type',$selected,false,$this->column_lev_color);
     printer::pclear(7);
     echo '<p><input type="hidden" name="MAX_FILE_SIZE" value="'.$maxbytes.'"></p> 	
      <fieldset class="navy"><legend> Upload Vid File</legend>';
     printer::pclear(7);
     echo '
     <p  ><b>File:</b> <input id ="fileinput2" style="color: #0ff;" type="file" name="upload" ></p> 
     <p style="padding:25px 10px;"><input type="submit" name="submit" value="Submit Video Upload" ></p>
     <p><input type="hidden" name="configvidsubmitted" value="TRUE" ></p>';
     echo '</fieldset></form><!--videoform-->';
     printer::pclear(7);
     printer::close_print_wrap('add vid');
     $this->show_close('Add vid Here');
     printer::close_print_wrap('uploads');
     $this->show_close('Special Uploads');
     echo '</div><!-- float buttons-->';
     }
	

 
  
  
function column_tree(){//column tree info not used currently
     if (isset($_POST['deletecolumn']))return;
     $this->show_more('tech info','noback','fs2info editbackground editfont highlight left5 right5','Click for Tech Information',500);
	echo '<div class="editbackground editfont fsminfo editbackground editfont maxwidth500  '.$this->column_lev_color.' floatleft"><!--tech info-->'; 
	$this->blog_order_array[0]=''; 
	printer::alertx('<p class="highlight left" title="Unique Column Id: C'.$this->col_id.' would be Used for Copying/Mirroring/Moving This Entire Column">The Unique Column Id: C'.$this->col_id.'</p>');
	printer::alert('Present <span class="highlight" title="The column level depth refers to columns within columns ie. level 2 would be a nested column within a nested column within a primary column">column level depth</span>: '.($this->column_level),'','editcolor editbackground editfont left');
	printer::pclear(2);
	for ($i=0; $i<=$this->column_level; $i++){
		$column=($i==0)?'':'Column#'.$this->column_order_array[$i-1];
		$post=($i==0)?'The Body':'Post#';
		$from=($i!=$this->column_level)?' from which => ':' which is this column';
	     $begat=($i!=0||!$this->is_clone)?' => gave rise to Column#':'';
		$postid=($i==0)?'':' having Post Id P'.$this->blog_id_arr[$i];
		printer::alertx('<p class="left">'.$column.$post.$this->blog_order_array[$i]. $postid.
          $this->column_fol_arr[$i].$begat.
          $this->column_order_array[$i].' Id: C'.
          $this->column_id_array[$i].' => of Net Width: '.
          (intval(ceil($this->column_net_width[$i]*10)/10)).'px '.$from.'</p>');
          }
	echo '</div><!--division- border tech-->';
	$this->show_close('tech');//tech 
	printer::pclear(2);
	}
     

function unclone_options($id,$post_target_clone_column_id){if(Sys::Custom)return;if (Sys::Quietmode)return; 
	if (($this->blog_status==='clone')||($this->is_column&&$this->col_status==='clone'))return;  
	static $statinc=0; $statinc++;
	$this->clone_check_arr[]=$id;
	$this->show_more('Mirror release Options','Close Mirror release Options','fs2npinfo small highlight editbackground editfont floatleft','Modify/Change This Cloned '.str_replace('_',' ',strtoupper($this->blog_type)),500);//show_more un clone options
	echo '<div class="fsmblack editbackground editfont"><!--Mirror release Options-->';
	echo '<div class="fsminfo editbackground editfont left '.$this->column_lev_color.'" >With this Duplicate and Modify Option a Copy of this '.str_replace('_',' ',strtoupper($this->blog_type)).' will Be Created and May Then Be Modified Here Without Affecting the Original!<br>'; 
	printer::printx('<p class="editcolor editbackground editfont left"><input type="checkbox" value="'.$this->post_target_clone_column_id.'" name="unclone_option_copy['.$this->blog_id.']"> Duplicate and Modify Option</p>');
	echo '</div><!--Duplicate Mirror release-->';
	echo '<div class="left fsminfo editbackground editfont '.$this->column_lev_color.'" >With this Replace Fresh Option Select Any New Post/Column Type to Replace this '.str_replace('_',' ',strtoupper($this->blog_type)).'<br/>';
	printer::printx('<p class="editcolor editbackground editfont left">	And Choose Your New Post Type <br><span class="small">From the Dropdown Menu Here:</span></p>');
	$new_blog='create_unclone['.$this->blog_id.']['.$this->post_target_clone_column_id.']';  
	$selected=$this->choose_blog_type;
	forms::form_dropdown($this->blog_drop_array,false,'','',$new_blog,$selected,false,$this->column_lev_color  );
	echo '</div><!--Unclone Fresh-->';
	$this->submit_button();
	echo '</div><!--UnClone Options-->';
	$this->show_close('un clone options');//show_more un clone options
	printer::pclear();echo '<!--clear unclone opts-->';
	}

function switch_clone_options($target_id,$prime,$type){
	if (!$this->edit)return;
	$globalize=(isset($_POST['globalize_clone_switch_'.$target_id])&&$_POST['globalize_clone_switch_'.$target_id]==1)?true:false;
	if (isset($_POST['primary_switch_clone'][$target_id])){  
		if (is_numeric(substr_replace(trim($_POST['primary_switch_clone'][$target_id]),'',0,1))){
			$newclone=substr_replace(trim($_POST['primary_switch_clone'][$target_id]),'',0,1);
			if (strtolower(substr(trim($_POST['primary_switch_clone'][$target_id]),0,1))==='c'){
				$AND=($globalize)?'':" AND col_base='$this->pagename'";
				$q="update $this->master_col_table set col_clone_target='$newclone'  where   col_clone_target='$target_id' $AND";
				$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
				if ($this->mysqlinst->affected_rows())$this->success[]="You have successfully switched cloned Primary Column Id$target_id to column Id$newclone";
				else $this->message[]='No clone switch updates were made for Primary Column Id'.$target_id;
				}
			else $this->message[]='Enter an Id Prefix c(for column) and the column Id to clone here';
			}
		}
	elseif (isset($_POST[$type.'_switch_clone'][$target_id])&&!empty($_POST[$type.'_switch_clone'][$target_id])){
		if (is_numeric(substr_replace(trim($_POST[$type.'_switch_clone'][$target_id]),'',0,1))){
			$newclone=substr_replace(trim($_POST[$type.'_switch_clone'][$target_id]),'',0,1);
			if (strtolower(substr(trim($_POST[$type.'_switch_clone'][$target_id]),0,1))==='p'){
				$AND=($globalize)?'':" AND blog_table_base='$this->pagename'";
				$q="update $this->master_post_table set blog_clone_target='$newclone'  where   blog_clone_target='$target_id' $AND";
				$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
				if ($this->mysqlinst->affected_rows())$this->success[]="You have successfully switched cloned '.$type Id$target_id to post Id$newclone";
				else $this->message[]='No clone switch updates were made for '.$type.' Id'.$target_id;
				}
			elseif (strtolower(substr(trim($_POST[$type.'_switch_clone'][$target_id]),0,1))==='c'){
				$AND=($globalize)?'':" AND blog_table_base='$this->pagename'";
				$q="update $this->master_post_table set blog_data1='$newclone'  where   blog_data1='$target_id' $AND";
				$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
				if ($this->mysqlinst->affected_rows())$this->success[]="You have successfully switched cloned $type Id$target_id to column Id$newclone";
				else $this->message[]='No clone switch updates were made for '.$type.' Id'.$target_id;
				}
			else $this->message[]='Include the column or post Id prefix  (ie. c4 or p52)';
			}
		}
	$msg='Option for quickly switching to a different targeted clone';
	$this->show_more('Switch Clone Option','noback','tiny fs1info rad5 highlight editbackground editfont',$msg,500);
	$msg=($prime)?'Change this Cloned Primary Column by entering a new Column Id (ie c5) from another page to Clone Here instead':(($type==='column')?'Change this Cloned Nested Column by entering a new Column Id (ie. c5) or Post Id (ie. p55) from another page to Clone Here instead':'Change this cloned Post by entering a Column Id (ie. c5) or Post Id (ie. p55) from another page to Clone Here instead'); 
	echo '<div class="fsminfo editcolor editbackground editfont ">'.$msg.'<!--switch div-->';
	if ($prime)
          printer::printx('<p class="editcolor editbackground editfont"><input   style="background:#'.$this->editor_background.';color:#'.$this->editor_color.';" type="text" name="primary_switch_clone['.$target_id.']" size="6" maxlength="7" value="">Enter New Column Id </p>');
	else  
          printer::printx('<p class="editcolor editbackground editfont"><input  style="background:#'.$this->editor_background.';color:#'.$this->editor_color.';" type="text" name="'.$type.'_switch_clone['.$target_id.']"  size="6" maxlength="7" value="">Enter Id to Clone Here/p>');
	$msg="Check Here To Switch Cloned $type Id$target_id for every page on the website that it occurs to the new clone Id choice.";
	$msg_alert="Switching $type Id$target_id to a new clone will be globalized to everypage.  Uncheck to Effect only the Current Page";
	printer::printx('<p class="caution small"><input class="global_switch_clone" type="checkbox" name="globalize_clone_switch_'.$target_id.'"   onchange="gen_Proc.on_check_event(\'globalize_clone_switch_'.$target_id.'\',\''.$msg_alert.'\');" value="1">'.$msg.'</p>');
	echo '</div><!--switch div-->';
	$this->show_close('switch to new clone');	
	} 
	
function total_float($prime_col=false,$return=false){
     #if both alternative width units and main width option are not used  then main width will be activated to full width. If both used main width will override.  If alt used and main width not main width will be inactive and alt units active.
     $this->col_width_info=''; 
     $this->blog_width_info=''; 
     if ($prime_col){   
		if (!$this->col_primary&&$this->pagename!==$this->col_table_base){//is a nested column clone in pp primary position..
			$this->col_width=''; 
			}
		$styles=explode(',',$this->col_style);
		}
	elseif ($this->blog_type==='nested_column'){ 
		$styles=explode(',',$this->col_style);
		}
	else $styles=explode(',',$this->blog_style); 
	$this->track_font_em($styles);
	list($border_width,$border_height)=$this->border_calc($styles);   
	if ($prime_col){
		$this->col_width=(is_numeric($this->col_width)&&$this->col_width > 5 )?$this->col_width:0;//&&$this->col_width <= Cfg::Col_maxwidth   we removed so that column_width ie max-width set in main width settings can override page settings
          if (empty($this->col_width)){//here we will use alternative width if is set otherwise page width..
               $this->current_total_width=$this->column_total_width[$this->column_level]= (!empty($this->page_width))?$this->page_width:Cfg::Page_width;// page_width setting passes to create new page. 
               $mxw=$this->alt_width_calc($this->col_options[$this->col_max_width_alt_opt_index]);
               $this->col_width_info.='Column alt max-width: '.$this->width_info; 
               $minw=$this->alt_width_calc($this->col_options[$this->col_min_width_alt_opt_index]);
               $this->col_width_info.='Column alt min-width: '.$this->width_info;
               $w=$this->alt_width_calc($this->col_options[$this->col_width_alt_opt_index]);
               $col_width=($w >9&&$mxw>9)?min($mxw,$w):max($mxw,$w);//takes the smaller of the two if both widths exist
               $col_width=max($col_width,$minw);//takes the larger of the two
               $this->col_width_info.='Column alt width: '.$this->width_info;
               if (empty($col_width)){
                    $this->use_col_main_width=true;
                    $col_width=$this->page_width; 
                    }
               else $this->use_col_main_width=false;
               }
		else { 
               $this->use_col_main_width=true;
               $col_width=$this->col_width;
               }
		
          $this->col_width=$this->track_col_width=$col_width;
          $this->current_total_width=$this->column_total_width[$this->column_level]= (!empty($col_width))?$col_width:((!empty($this->page_width))?$this->page_width:Cfg::Page_width);// page_width setting passes to create new page. 
		list($padding_total,$margin_total)=$this->pad_mar_calc($styles,$this->column_total_width[$this->column_level]);
          if ($this->column_total_width[$this->column_level]-($border_width+$padding_total)<10)    
               printer::alert_neg("Incorrect padding margins due to :<br>padding total: $padding_total + margin total: $margin_total <br>too big for overall width.  ie. overall Column width  includes margins and padding");
		$this->current_net_width=$this->column_net_width[$this->column_level]=$this->column_total_width[$this->column_level]-(($border_width+$padding_total)); //margins not limiting in primary column
		$this->background_img_px=$this->current_net_width; 
		return;
		}
	
     $widmax=$this->column_net_width[$this->column_level];
	$mode=($this->blog_width_mode[$this->blog_width_mode_index]==='maxwidth'||$this->blog_width_mode[$this->blog_width_mode_index]==='compress_full_width'||$this->blog_width_mode[$this->blog_width_mode_index]==='compress_to_percentage'||$this->blog_width_mode[$this->blog_width_mode_index]==='off')?$this->blog_width_mode[$this->blog_width_mode_index]:'maxwidth'; 
     if ($this->blog_type==='nested_column'){  
		$this->col_width= ($mode!=='off'&&!empty($this->col_width)&&is_numeric($this->col_width)&&$this->col_width>0&&$this->col_width<=100)?$this->col_width:0; 
		if (empty($this->col_width)){  
               $mxw=min($widmax,$this->alt_width_calc($this->col_options[$this->col_max_width_alt_opt_index]));
               $this->col_width_info.='Column alt max-width: '.$this->width_info; 
               $minw=min($widmax,$this->alt_width_calc($this->col_options[$this->col_min_width_alt_opt_index]));
               $this->col_width_info.='Column alt min-width: '.$this->width_info;
               $w=min($widmax,$this->alt_width_calc($this->col_options[$this->col_width_alt_opt_index]));
               $col_width=($w >9&&$mxw>9)?min($mxw,$w):max($mxw,$w);//takes the smaller of the two if both widths exist
               $col_width=max($col_width,$minw);//takes the larger of the two
               $this->use_col_main_width=false;
               if (!empty($col_width)){
                    $col_width=$col_width/$widmax*100; 
                    }
               else { 
                    $col_width=100;
                    }
               }
          else { 
               $this->use_col_main_width=true;
               $col_width=$this->col_width;
               }
          
          $this->track_col_width=$col_width;
		$this->current_total_width=$this->column_total_width[$this->column_level+1]= ($col_width)*$widmax/100;
		$this->current_total_width_percent=$col_width;
		list($padding_total,$margin_total)=$this->pad_mar_calc($styles,$this->column_total_width[$this->column_level]);
		//this is parent column  as the column level changes with   $this->nested_column()  call which we haven't done yet. Other type posts are in current column level;
		#NOTE: Widmax is the important calculation in that it is using the parent col net width    goes on to be used in calculation of column level  total and  net widths  for columns for  level.. becoming current level...
		$margin_total_percent=$margin_total/$this->column_total_width[$this->column_level]*100;
		$padding_total_percent=$padding_total/$this->column_total_width[$this->column_level]*100;
		$border_percent=$border_width/$this->column_total_width[$this->column_level]*100;
		#current padded width used to calculate net widths
		#table out now reserved for rwd floating which is not calulated here 
		$this->current_padded_width_percent=$border_percent+$padding_total_percent;//margins also not included in calculation for nested columns 
		$this->current_padded_width_px= $border_width+$padding_total;
		if ($this->rwd_post)$this->current_padded_width_percent=$this->current_padded_width_px=0;//rwd posts do not utilize margins widths same way..
          if ($col_width*$widmax/100-$this->current_padded_width_px<10)  
               printer::alert_neg("Incorrect padding margins due to :<br>padding total: $padding_total  <br>too big for overall width.  ie. overall Column width  includes margins and padding");
		$this->current_net_width=$this->column_net_width[$this->column_level+1]=$col_width*$widmax/100-$this->current_padded_width_px; 
		$this->current_net_width_percent=$col_width-$this->current_padded_width_percent; //col_width for nested columns are stored as percentages 
		} //end nested
	else  {// is blog 
		$this->blog_width=($mode!=='off'&&!empty($this->blog_width)&&is_numeric($this->blog_width)&&$this->blog_width>0)?$this->blog_width:0;
		if (empty($this->blog_width)){ 
               $mxw=$this->alt_width_calc($this->blog_options[$this->blog_max_width_alt_opt_index]); 
               $this->blog_width_info.='Blog alt max-width: '.$this->width_info; 
               $minw=$this->alt_width_calc($this->blog_options[$this->blog_min_width_alt_opt_index]);
               $this->blog_width_info.='Blog alt min-width: '.$this->width_info;
               $w=$this->alt_width_calc($this->blog_options[$this->blog_width_alt_opt_index]);
               $this->blog_width_info.='Blog alt width: '.$this->width_info;
               $blog_width=($w >9&&$mxw>9)?min($mxw,$w):max($mxw,$w);//takes the smaller of the two if both widths exist
               $blog_width=max($blog_width,$minw);//takes the larger of the two
               if (!empty($blog_width)){
                    $this->use_blog_main_width=false;
                    $blog_width=$blog_width/$widmax*100;
                    }
               else {
                    $blog_width=100;
                    $this->use_blog_main_width=false;
                    }
               }
          else {
               $this->use_blog_main_width=true;
               $blog_width=$this->blog_width;
               } 
		$this->current_total_width=$blog_width*$widmax/100;
		$this->current_total_width_percent=$blog_width;
		list($padding_total,$margin_total)=$this->pad_mar_calc($styles,$this->column_total_width[$this->column_level]);
		//this is parent column  as the column level changes with   $this->nested_column()  call which we haven't done yet. Other type posts are in current column level;
		#########    NOTE: Widmax is the important calculation in that it is using the parent col net width    goes on to be used in calculation of column level  total and  net widths  for columns for  level.. becoming current level...
		$margin_total_percent=$margin_total*$this->column_total_width[$this->column_level]/100;
		$padding_total_percent=$padding_total*$this->column_total_width[$this->column_level]/100;
		$border_percent=$border_width*$this->column_total_width[$this->column_level]/100;
		#current padded width used to calculate net widths
		#table out now reserved for rwd floating which is not calulated here
		$this->current_padded_width_percent=$border_percent+$margin_total_percent+$padding_total_percent;//margins are relevant in calculation for nested columns
		$this->current_padded_width_px= $border_width+$margin_total+$padding_total;
		if ($this->rwd_post)$this->current_padded_width_percent=$this->current_padded_width_px=0;//rwd posts do not utilize margins widths same way..
		$this->current_net_width_percent=$blog_width-$this->current_padded_width_percent;
          if ($blog_width*$widmax/100-$this->current_padded_width_px<10) 
               printer::alert_neg("Incorrect padding margins or width left due to :<br>padding total: $padding_total + margin total: $margin_total <br> or width left in parent column  ie. overall Column width  includes margins and padding");
		$this->current_net_width=$blog_width*$widmax/100-$this->current_padded_width_px; 
		
		} 
	$this->background_img_px=$this->current_net_width; 
	}	 
			
	
function get_parent($col_id,$ptable){
     //this collects nested column tree up to primary column  col_id's
     $q="select blog_col  from ".Cfg::Master_post_table." where blog_table_base='$ptable' and blog_data1='$col_id' and blog_type='nested_column'";
     $r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
     if ($this->mysqlinst->affected_rows()){
          list($blog_col_id)=$this->mysqlinst->fetch_row($r);
          $this->coll_col_arr[]=$blog_col_id;
          self::backup_get_parent($blog_col_id,$ptable);
          }
     else $this->coll_col_arr[]=$col_id;
     return;// returned entire tree in form of coll_col_arr
	}
     
function check_clone($col_id){
     $q="select blog_id,blog_type,blog_data1 from  $this->master_post_table where blog_col=$col_id and blog_table_base='$this->pagename' and blog_status!='clone'";
     $r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
     if ($this->mysqlinst->affected_rows()){
          while(list($blog_id,$blog_type,$blog_data1)=$this->mysqlinst->fetch_row($r)){
               if ($blog_type==='nested_column'){
                    $this->clone_delete_list[]=$blog_id.'@@'.$blog_type.'@@'.$blog_data1;
                    self::check_clone($blog_data1);
                    }
               else $this->clone_delete_list[]=$blog_id.'@@'.$blog_type.'@@'.'none';
               }
          }//affected 2 
     }		
		
function blog_new($data,$tablename,$blog_order, $msg='', $msg_open_prefix='Insert New After Post #', $msg_close_prefix='Insert <span class="purple">New</span> After Post #'){
	if ($blog_order==='Om')exit('om');
	if(Sys::Custom)return;if(Sys::Quietmode) return;    
	if (Sys::Methods)Sys::Debug(__LINE__,__FILE__,__METHOD__);
	if (!$this->edit)return;
	printer::pclear(); 
     if ($this->is_clone){
          $this->submit_button();
          return;
          }
     static $id=0; $id++;  
     if (!empty($blog_order)){
          $this->mysqlinst->count_field($this->master_post_table,'blog_order','',false," where blog_table='$tablename'");
          $max=$this->mysqlinst->get('fieldmax');
          $insert=($max===$blog_order)?'To Add':'To Insert';
          }
     else $insert='';        
     $new_blog=$data.'_blog_new'; 
     $selected=$this->choose_blog_type;
     printer::pspace(5);
     $this->show_more($msg_open_prefix.$msg.' Col#'.$this->column_order_array[$this->column_level],'',$this->column_lev_color.' fs1'.$this->column_lev_color.' editbackground editfont  rad5 editfont ','Click Here To Add New Posts/Column and For More info on making Choices',250);
	echo '<div class="editbackground editfont fsminfo"><!-- Add New Posts/Column wrap-->';
	$this->show_more('Info Post Choices','noback','highlight smaller','click for more info on post choices');   
	printer::alertx('<p class="width500 fsminfo editbackground editfont '.$this->column_lev_color.' editfont left">Not only create Post content here such as Text, Images, a Navigation menu, or Social Icons etc.  andalso Create a Nested Column as well or copy clone move previous posts and columns of posts.  A nested Column is a Column within a column  used for organizing the posts (and other columns) that you create within it.  Please Review the discussion of this important topic in the Overview Section at the top of the Page!!</p>');
	$this->show_close('Info Post Choices');
	forms::form_dropdown($this->blog_drop_array,false,'','',$new_blog,$selected,false,$this->column_lev_color );
	printer::pclear();
	$this->show_more('Additional new','','floatleft smallest highlight italic','Add an additional new post type here','asis');
	forms::form_dropdown($this->blog_drop_array,false,'','',$new_blog.'_add_second',$selected,false,$this->column_lev_color );
	$this->show_close('Additional new');
	echo '</div><!-- Add New Posts/Column wrap-->';
	$this->show_close($msg);
	//echo '</div><!--center wrap-->';
	printer::pclear(1); 
	$this->submit_button();
	printer::pspace(20);
	}
	
function submit_button($value=''){ if(Sys::Custom)return;if  (Sys::Pass_class||Sys::Quietmode)return;
	(empty($value))&& $value='SUBMIT All';//:'SUBMIT ALL CHANGES'; 
	echo'  <p class="clear"><input  type="hidden" name="submitted"  value="1" ></p><p><input class="editbackground editfont rad5 smallest cursor buttoneditcolor editcolor mb10" type="submit" name="submit"   value="'.$value.'" ></p>';
	}
     	
function format_date($date=''){
	if (!empty($date)&&(strlen($date)!=10||!is_numeric($date))) 
		return $date;
	else if (empty($date))$date=time();
	$i=0;
	$this->{'fdate'.$i}=date("F j, Y",$date);$i++;
	$this->{'fdate'.$i}=date("M j, y",$date);$i++;
	$this->{'fdate'.$i}=date("j F, Y",$date);$i++;
	$this->{'fdate'.$i}=date("M j",$date);$i++;
	$this->{'fdate'.$i}=date("j M",$date);$i++;
	$this->{'fdate'.$i}=date("n/j/Y",$date);$i++;
	$this->{'fdate'.$i}=date("n/j/y",$date);$i++;
	$this->{'fdate'.$i}=date("j/n/Y",$date);$i++;
	$this->{'fdate'.$i}=date("j/n/y",$date);$i++;
	$this->{'fdate'.$i}='<p class="center style_day">'.date("j",$date).'</p><p class="center style_month">'.date("M",$date).'</p>';$i++;
	$this->{'fdate'.$i}='<p class="center style_month">'.date("M",$date).'</p><p class="center style_day">'.date("j",$date).'</p>';$i++;
	$this->{'fdate'.$i}=date("F j, Y g:i A",$date);$i++;
	$this->{'fdate'.$i}=date("M j, y g:i A",$date);$i++; 
	$this->{'fdate'.$i}=date("j F, Y g:i A",$date);$i++;
	$this->{'fdate'.$i}=date("j M, y g:i A",$date);$i++;
	$this->{'fdate'.$i}=date("F j g:i A",$date);$i++;
	$this->{'fdate'.$i}=date("M j g:i A",$date); $i++;
	$this->{'fdate'.$i}=date("j F g:i A",$date);$i++;
	$this->{'fdate'.$i}=date("j M g:i A",$date);$i++;  
	$val=(is_numeric($this->page_options[$this->page_date_format_index])&&$this->page_options[$this->page_date_format_index]<$i)?$this->page_options[$this->page_date_format_index]:0;
	$fdate=$this->{'fdate'.$val}; 
	return array($fdate,$val,$i);
	}//end function format_date

#style#
#$style_field is the name of the sql field holding raw style data
#$this->style_field is the raw data itself
#css_classname which is the classname to which the styling applies
#element  provides uniqueness to the name input etc. and also the style array (that is for non body non bodyview elements) holding the the final style rendering and also is used is as special reference for providing information on a particlular style grouping ie bodyview...
#the show list is the particlar style functions to render in order they written. If show list is empty the default function order from Cfg::Style_functions_order is used
#   the function iteself retrieves the css functions  and depending on the key sort order provided or by using the default order, it determines from the relative key value of the function needed to pipe the relevant style array value to.  ie  func  background will receive the style array value from the index ['background'].. The background function and others are where the styling editing for each style takes place and a css rule  generated for the particular values sent. These final css rules   are stored as final_style class variables  named in the general format of the particular "element_style_field_arrayed" format. Reference to the name of returned css value is passed to render_array using the element and css class reference. It also passes the class name reference  The render array is called upon at the close of the page by the method css_generate. Css_generate serves the purpose of collecting the various individual css rules for a given css class name and compiling them in one css statement. To do this the render array is then passed through foreach. Each resulting array provides Reference to a class name   and reference to the style array the gives the collected css values ie;   background:#ffffff;  and color:#aaaaa; All css values for a give classname are collected and rule applied.   the css name may be further modified according to $css_ext if used 
	
function edit_styles_close($element,$style_field,$css_classname,$show_list='',$mod_msg="Edit styling",$show_option='',$msg='',$mainstyle=false,$clone_option=true,$global=true){  
	//$mainstyle main class style relates to show_more and javascript to toggle static style so show_more isn't visually overlapped ie overrides stacking order...
     $this->pelement=$css_classname;
	if(!$this->edit||Sys::Printoff||Sys::Styleoff||Sys::Quietmode||$this->styleoff|| Sys::Custom)return;
     if ($this->is_clone&&!$this->clone_local_style)return; 
	(Sys::Deltatime)&&$this->deltatime->delta_log('begin edit styles close line:'.__LINE__.' @ '.__method__);   
	self::$styleinc++;
	if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	$list='';
	$functions=explode(',',Cfg::Style_functions); #this is list of master functions...
	$func_count=count($functions);
	if ($element==='body'||$element==='bodyview'){
		$style=$style_field.'_arrayed';
		$this->$style=$this->$style_field;
		$this->render_array[]=array($element,'final_'.$style,$css_classname,'body');
		}
	elseif (!empty($style_field)){   
		$style=$element.'_'.$style_field.'_arrayed';#for blog array:::: this leaves the orginal $this->blog_style alone...
		$this->$style=$this->$style_field;#this is object to refer to actual current value in syle functions..
		#set both  as element will define    render_array for css_generate and style for style functions
		$idref = ($this->is_column)?'c'.$this->col_id:(($this->is_blog)?'b'.$this->blog_id:'body');
		$this->render_array[]=array($element,'final_'.$style,$css_classname,$idref);//or css_generate all elements called will generate css..
		
		}
	else {
		 $msgx='Array key does not exist'.$element. ' is element'.Sys::error_info(__LINE__,__FILE__,__METHOD__);
		 $this->message[]=$msgx;
		 mail::alert($msgx);
		return; 
		}  
	 if ($this->is_page|| ($this->is_blog&&!$this->is_clone)||($this->is_column&&!$this->is_clone||$this->clone_local_style)){
		$globalstyle=($this->is_blog&&$this->blog_global_style==='global')?$this->column_lev_color.' floatleft border9 borderinfo shadowoff editbackground editfont glowbutton'.$this->column_lev_color:'';
          $show_option='buffer_'.self::$styleinc;
		$this->show_more($mod_msg,$show_option,$globalstyle,'',550,'','',$mainstyle);#mainshow
		$this->print_redwrap('mainstyle wrap',true);
          if (isset($this->render_view_css)&&is_array($this->render_view_css)&&count($this->render_view_css)>0){
			if ($this->is_page){
				$type='page';
				$id=$this->page_id;
				}
			elseif ($this->is_column){
				$type='col';
				$id=$this->col_id; 
				}
			else {
				$type='blog';
				$id=$this->blog_id; 
				}
			$this->submit_button();
               $this->display_parse_style($type,$style_field,$id,$show_list);
			$this->show_more('Page Level Tag and Class Styles','','highlight tiny editbackground editfont floatleft','Style text through the use of tags and classes with Styles set in page options');
			printer::array_print($this->render_view_css); 
			$this->show_close('View Current Tag and Class Styles');
			}
		if ($this->is_page){
               $type='page';
               $ndata=$style;
               }
          elseif ($this->is_column){
               $type='col';
               $ndata=$style; 
               }
          else {
               $type='blog';
               $ndata=$style;
               }
          $class=($this->pelement==='body')?'body':$this->pelement;
		$type_ref=($this->is_page)?'Page Ref: "'.$this->pagename.'"':(($this->is_column)?'Col Id: "C'.$this->col_id.'"':'Post Id: "P'.$this->blog_id.'"');
               $count=strlen($this->$style_field);
          $cmsg = (strpos($style_field,'tiny')!==false)?"Tiny data field use: <span class='$this->column_lev_color'>$count</span>/255":''; 
		printer::printx('<p class="fsminfo smaller editbackground editfont editcolor">Class Name: <span class="'.$this->column_lev_color.'">'.$class.'</span><br>'.$type_ref.' Style Field: <span class="'.$this->column_lev_color.'"> '.$style_field.'</span><br>'.$cmsg.'</p>');
		(!empty(trim($msg)))&&printer::print_tip($msg,.7);
          printer::pclear(10);
          printer::alert('<input type="checkbox" name="'.$ndata.'" value="0" onchange="edit_Proc.oncheck(\''.$ndata.'\',\'Delete all styles within this style grouping for '.$type.' when YOU HIT CHANGE, UNCHECK TO CANCEL\')">Delete all styles for this Style grouping');
          printer::pclear(10);
		if ($this->is_blog&&($this->blog_type==='text'||$this->blog_type==='float_image_right'||$this->blog_type==='float_image_left'||$this->blog_type==='image'||$this->blog_type==='video')){
			if ($global&&isset($_POST[$this->data.'_blog_global_style'])&&$_POST[$this->data.'_blog_global_style']==='global'){
				$q="update $this->master_post_table set blog_global_style='0' where blog_col='$this->col_id' and blog_id!='$this->blog_id' and blog_type='$this->blog_type'";  //remove anothe current global setting if exists
				$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); 
				}
			if ($global&&isset($_POST['delete_global_styles_'.$this->data.'_'.$style_field])&&$_POST['delete_global_styles_'.$this->data.'_'.$style_field]==='delete'){
				$q="update $this->master_post_table set $style_field='0' where blog_col='$this->col_id' and blog_id!='$this->blog_id' and blog_type='$this->blog_type'";   
				$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); 
				}
			 if ($global&&$this->blog_global_style!=='global'){
				$this->show_more('Globalize this style grouping');
				echo '<div class="fsminfo editbackground editfont editcolor"><!--globalize style wrap-->';
                    printer::printx('<p class="tip ">These styles made here will be applied to all '.$this->blog_type.' posts within this column.  Styles made in the individual posts will override these. Any Previous Globalized '.$this->blog_type.' styles will be removed.</p>');
				printer::printx('<p class="'.$this->column_lev_color.' editbackground editfont"><input type="checkbox" name="'.$this->data.'_blog_global_style" value="global">Globalize these Styles</p>');
				printer::printx('<p class="'.$this->column_lev_color.' editbackground editfont"><input type="checkbox" name="delete_global_styles_'.$this->data.'_'.$style_field.'" value="delete"  onchange="edit_Proc.oncheck(\'delete_global_styles_'.$this->data.'_'.$style_field.'\',\'SIMILAR STYLES OF SAME TYPE POSTS WITHIN PARENT COLUMN WILL BE DELETED WHEN YOU HIT CHANGE, UNCHECK TO CANCEL\')">Pre delete this style type in all other posts within this same column so now pre-existing posts of this  '.$this->blog_type.' will match exactly. </p>');
				echo '</div><!--globalize style wrap-->';
				$this->show_close('Globalize this '.$this->blog_type.' within Column');
				}// option not global
			else if ($global){
				$this->show_more('Undo Globalize these styles');
				echo '<div class="fsminfo editbackground editfont editcolor"><!--globalize style wrap-->';
                    printer::printx('<p class="tip ">Undo globalization means styles made here will longer be applied to all '.$this->blog_type.' posts within this column. </p>');
				printer::printx('<p class="'.$this->column_lev_color.' editbackground editfont"><input type="checkbox" name="'.$this->data.'_blog_global_style" value="0">Check this box to Undo Globalize these Styles</p>');
                    printer::printx('<p class="'.$this->column_lev_color.' editbackground editfont"><input type="checkbox" name="delete_global_styles_'.$this->data.'_'.$style_field.'" value="delete"  onchange="edit_Proc.oncheck(\'delete_global_styles_'.$this->data.'_'.$style_field.'\',\'SIMILAR STYLES OF SAME TYPE POSTS WITHIN PARENT COLUMN WILL BE DELETED WHEN YOU HIT CHANGE, UNCHECK TO CANCEL\')">Delete this style grouping in all other posts within this same column. Will affect this style in other type '.$this->blog_type.' posts only. </p>');
				echo '</div><!--globalize style wrap-->';
				$this->show_close('Globalize this '.$this->blog_type.' within Column');
				}
			}//if blog and text
		}
	if (!empty($this->$style)){
		$this->$style= explode(',',$this->$style);// this for all sub $funtions....
		for ($x=0;$x<$func_count;$x++){ 
			(!array_key_exists($x,$this->{$style}))&&$this->{$style}[$x]='';#all style functions for empty css vals will have value of empty.. because all style elements must have count number of array elements
			}
		}
	else  { #count functions and populate array..
		$this->$style=array();# as one cannot explode empty values...
		for ($x=0;$x<$func_count;$x++){ 
			$this->{$style}[]='';#all style functions for empty css vals will have value of zero.. because all style elements must have count number of array elements
			}
		$message[]='empty array formation'.Sys::error_info(__LINE__,__FILE__,__METHOD__);
		}
          
	#stylefunction 
	if (!empty(trim($show_list)))$function_order=explode(',',str_replace(' ','',$show_list));
	else  $function_order=explode(',',Cfg::Style_functions_order);
	array_unshift($function_order , 'media_styler');//enclose non- function css_generated css in the media queries as set forth herein 
	foreach ($function_order as $index){  
		$i=$this->{$index.'_index'};
		(Sys::Deltatime)&&$this->deltatime->delta_log('Begin EditStyle function:    ele: '.$element.'  css:  '.$css_classname .' funct: '.$functions[$i+1]);
		$this->{$functions[$i]}($style,$i,$style_field);  #this calls the functions....
		
		(Sys::Deltatime)&&$this->deltatime->delta_log('End Function : '.$functions[$i]);
		printer::pclear();
		}
	$this->media_styler($style,$this->media_styler_index,'display');//here we display the media_styler settings options and close the media query tag if chosen!  media query opened above by using array_unshift($function_order , 'media_styler'); 
	$this->custom_style($style,$this->custom_style_index,$style_field);
	 #styleclone #stylecopy
          if  ($this->is_blog&&$this->is_clone&&$this->clone_local_style){
               $this->show_more('Blog Copy Style','','highlight click editbackground editfont');
               $this->clipboard('blogclone',$this->blog_id,$style_field);
               $this->show_close('Blog Copy Style');
               }
          elseif  ($this->is_column&&$this->is_clone&&$this->clone_local_style){
               $this->show_more('Column Copy Style','','highlight click editbackground editfont');
               $this->clipboard('colclone',$this->col_id,$style_field);
               $this->show_close('Column Copy Style');
               }
          elseif ($this->is_blog&&(!$this->is_clone||$this->clone_local_style)) $this->port_blog_style($style_field,$function_order);//
		elseif ($this->is_column&&!$this->is_clone&&$clone_option&&!$this->clone_local_style)$this->port_col_style($style_field,$function_order);//  
		elseif ($this->is_page&&$clone_option&&!$this->clone_local_style)  
			$this->port_page_style($style_field,$function_order);
          printer::pclear(); 
          if ($this->is_page|| ($this->is_blog&&!$this->is_clone)||($this->is_column&&!$this->is_clone||$this->clone_local_style)){  
               $this->submit_button();
               if ($style_field==='page_style'||$style_field==='blog_style'||$style_field==='col_style'){
			 printer::print_tip("Additional @media control Optionally Enable to Add a second and third main @media width $style_field of grouped styles except for advanced styles and any animation/effects options"); 
			$media_name=($this->is_page)?'page_options['.$this->page_enable_media_style_index.']':(($this->is_column)?$this->col_name.'_col_options['.$this->col_enable_media_style_index.']':$this->data.'_blog_options['.$this->blog_enable_media_style_index.']');
                    #add another main style field for media@ width rules
			$type=($this->is_page)?'page':(($this->is_column)?'col':'blog');   
				$media_style= ($this->{$type.'_options'}[$this->{$type.'_enable_media_style_index'}]==='media_style_on')?true:false;
			 if ($media_style) 
				  printer::alert('<input type="checkbox" value="media_style_off" name="'.$media_name.']">Disable additional @media Style Groups if not used to save editmode render time.');
			 else 
				  printer::alert('<input type="checkbox" value="media_style_on" name="'.$media_name.'">Enable Additional @media Main Style Grouping Tweaks');
			 if ($media_style){
                    
                    $this->edit_styles_close($element,$style_field.'2',$css_classname,$show_list,"Add Additional @media$mod_msg{2}",$show_option,$msg='Secondary for Re-Styling @mediawidth.',$mainstyle,$clone_option);
				
                    $this->edit_styles_close($element,$style_field.'3',$css_classname,$show_list,"Add Additional @media$mod_msg{3}",$show_option,$msg='Third for Re-Styling @mediawidth ',$mainstyle,$clone_option);
                    }
			}
               printer::close_print_wrap('mainstyle wrap');
               $this->show_close($mod_msg,$show_option);//<!--end plus more class="white relative hide" for Edit Styles Close-->';
               printer::pclear(2);   
               }
          (Sys::Deltatime)&&$this->deltatime->delta_log('End edit styles close: '.$element.'  css:  '.$functions[$i]);
	}//end edit_styles_close

function paste_from_clipboard(){//here we take clipboard and paste to checked posts...
     $table2=$this->master_page_table;
	foreach(array('col','page','blog','colclone','blogclone')  as $type){
		if(!isset($_POST['paste_from_clipboard'][$type]))continue;
		foreach($_POST['paste_from_clipboard'][$type] as $record){
			foreach($record as $key => $paste){
				if (!strtolower(trim($paste))==='paste')continue;
				$data= key($_POST['paste_from_clipboard'][$type]); 
				list($f,$id)=explode('@x@x',$data);
				switch($type){
					case 'page' :
						$table=$this->master_page_table;
						$field='page_id';
                              $prefix='';
						break;
					case 'col':
						$table=$this->master_col_table;
						$field='col_id';
                              $prefix='';
						break;
					case 'blog':
						$table=$this->master_post_table;
						$field='blog_id';
                              $prefix=''; 
						break;
					case 'blogclone':
						$table=$this->master_post_css_table;
						$field='blog_id'; 
                              $prefix='p';
						break;
                         case 'colclone':
						$table=$this->master_col_css_table;
						$field='col_id';
                              $prefix='c';
						break;
					default: return;
					}
				$q="update $table2 as p, $table as c set c.$f=p.page_clipboard  where p.page_clipboard !='' and c.$field='$prefix$id'";  
				$this->mysqlinst->query($q);
				if ($this->mysqlinst->affected_rows()){
					$this->success[]="Field: $f  from $id pasted from clipboard";
					}
				else $this->message[]="Field: $f from $id failed to paste from clipboard: $q";
					 
				}
			}
		}
	}

function port_page_style($style_field,$style_list_order){//style_list_order not used currently
     $this->show_more('Page Style Copy','noback','italic highlight editbackground editfont floatleft underline','Copy all the styles from a previoulsy styled Page by entering page ref  here.');
     $this->print_wrap('page style',true);
     printer::printx('<p class="fsminfo editbackground editfont editcolor">Page Ref: '.$this->pagename.'&nbsp;&nbsp;&nbsp;Style Field: '.$style_field.'</p>');
     printer::pclear(10);
     echo '<div class="'.$this->column_lev_color.'floatleft left editbackground editfont"><!--global clone field column-->';
     if(isset($_POST['globalize_style_copy'][$this->page_ref][$style_field])){
          $parent_id=trim($_POST['globalize_style_copy'][$this->page_ref][$style_field]);
          $where="where  page_ref='$parent_id'";
          $count=$this->mysqlinst->count_field($this->master_page_table,'page_id','',false,$where);
          if ($count==='1'){
               $q="update $this->master_page_table as c, $this->master_page_table as p set
                 c.$style_field=p.$style_field where p.page_ref='$parent_id' and c.page_ref='$this->page_ref'";  
               $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);  
               $this->success[]="Your Page Styles from Page ref $parent_id has been copied!"; 
               }
          else $this->message[]='No Page found for page Ref '.$parent_id;
          } //post glaobalize 
     if(isset($_POST['page_style_export_glob'][$this->page_ref][$style_field])){  
          $q="update $this->master_page_table as c, $this->master_page_table as p set
            c.$style_field=p.$style_field where p.page_ref='$this->page_ref'";  
          $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);  
          if ($this->mysqlinst->affected_rows())
          $this->success[]="Your Page Styles from Page ref $this->page_ref has been exported!";
          else $this->message[]="No styles update from Page ref $this->page_ref being exported using $style_field";
          } //post glaobalize 
     $included_arr=array();
     $q="select distinct page_ref, page_title, page_filename from $this->master_page_table";  
     $r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
     while (list($page_ref,$title,$filename) = $this->mysqlinst->fetch_row($r,__LINE__)){
          $included_arr[]=array($page_ref,$title);
          }
     echo'<p class="editcolor editbackground editfont">Choose Page for Import of '.$style_field.' Styles <select class="editcolor editbackground editfont"  name="globalize_style_copy['.$this->page_ref.']['.$style_field.']">';       
     echo '<option  value="none" selected="selected">Choose Page </option>';
     for ($i=0;$i<count($included_arr);$i++){
          echo '<option  value="'.$included_arr[$i][0].'">'.$included_arr[$i][1].'</option>';
          }
     echo'	
    </select></p>';
     printer::alert('<input type="checkbox" name="page_style_export_glob['.$this->page_ref.']['.$style_field.']" value="1">Export This style collection to all other page configs.');
     echo '</div><!--global clone field column-->';
     $this->clipboard('page',$this->page_id,$style_field);
     printer::close_print_wrap('page style');
     $this->show_close('Page Style Copy');
     }//end style page port
     
function port_col_style($style_field,$style_list_order){//style_list_order not used currently
     $this->show_more('Column Style Copy','noback','italic highlight editbackground editfont floatleft underline','Copy all the styles from a previoulsy styled element by entering the id here.');
     $this->print_wrap('Column Style copy');
     echo '<div class="fsminfo '.$this->column_lev_color.' floatleft left editbackground editfont"><!--global clone field column-->';
      ##########
	
     printer::printx('<p class="fsminfo editbackground editfont editcolor editfont">Column Id: C'.$this->col_id.'&nbsp;&nbsp;&nbsp;Style Field: '.$style_field.'</p>');
     printer::pclear(10);
     if(isset($_POST['globalize_style_copy'][$this->col_id][$style_field])){
          $parent_id=$_POST['globalize_style_copy'][$this->col_id][$style_field];
          if (strtolower(substr(trim($parent_id),0,1))==='c'){
               $parent_id=substr_replace(trim($parent_id),'',0,1);
               }
          $where="where  col_id=$parent_id";
          $count=$this->mysqlinst->count_field($this->master_col_table,'col_id','',false,$where);
          if ($count==='1'){
                 $q="update $this->master_col_table as c, $this->master_col_table as p set
                 c.$style_field=p.$style_field where p.col_id=$parent_id and c.col_id=$this->col_id";
               $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);  
               $this->success[]="Your column Id: C$this->col_id has imported $style_field from $parent_id!";
                 
               }
          else $this->message[]='No Column Id found for C'.$parent_id;
          } 
     printer::alertx('<p class="editcolor editbackround editfont">Enter a Column Id (ie. C44) to copy its <span class="highlight" title="Specifically all styles similarly grouped under field '.$style_field.'"> Collection of Styles</span> Here
     <input  type="text" name="globalize_style_copy['.$this->col_id.']['.$style_field.']"  size="7" maxlength="7" value=""> '); 
     echo '</div><!--global clone field column-->';
     $this->clipboard('col',$this->col_id,$style_field);
     printer::close_print_wrap('Column Style copy');
     $this->show_close('Column Style Copy');
     } //end style col port
     
function port_blog_style($style_field,$style_list_order){
     $this->show_more('Import/Export Style Settings','noback','italic highlight editbackground editfont floatleft underline','Copy all the styles from a previoulsy styled Post by entering the id  here.');
     $this->print_redwrap('copy styles',false);
      printer::printx('<p class="floatleft fsminfo editcolor editbackground editfont">Blog Id: P'.$this->blog_id.'&nbsp;&nbsp;&nbsp;Style Field: '.$style_field.'</p>');
     printer::pclear(10);
      ##########
	printer::print_wrap('blog option Port');
     printer::print_tip('Optionally Select individual Style field choices to import or export from field '.$style_field);
     $type=($this->is_clone&&$this->clone_local_style)?'blogclone':'blog';
	$this->port_style_choices('import',$this->blog_id,$type,$style_field,$style_list_order);
	$this->port_style_choices('export',$this->blog_id,$type,$style_field,$style_list_order);
      $this->submit_button();
	printer::close_print_wrap('blog option Port');
     printer::print_wrap('global clone field blog');
     if(isset($_POST['globalize_style_copy'][$this->blog_id][$style_field])){
          $parent_id=$_POST['globalize_style_copy'][$this->blog_id][$style_field];
          if (strtolower(substr(trim($parent_id),0,1))==='p'){
               $parent_id=substr_replace(trim($parent_id),'',0,1);
               }
          $where="where  blog_id=$parent_id";
          $count=$this->mysqlinst->count_field($this->master_post_table,'blog_id','',false,$where);
          if ($count==='1'){
               $q="update $this->master_post_table as c, $this->master_post_table as p set
                 c.$style_field=p.$style_field where p.blog_id=$parent_id and c.blog_id=$this->blog_id";
               $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);  
               $this->success[]="Your post Id: P$parent_id has been copied!";
               }
          else $this->message[]='No Post Id found for P'.$parent_id;
          }
     $msg=($this->blog_type!=='text')?'For Style Group stored under '.$style_field:'';
     printer::alertx('<p class="floatleft editbackground editfont editcolor">Enter a Post Id to copy those <span class="highlight edit" title="Specifically all styles similarly grouped under field '.$style_field.'"> Grouping of Styles</span> Here
                 <input  type="text" name="globalize_style_copy['.$this->blog_id.']['.$style_field.']"  size="7" maxlength="7" value=""> ');
     printer::print_wrap1('tie export style');
     printer::alertx('<p class="floatleft editbackground editfont editcolor"><input  type="checkbox" name="post_styleexport['.$this->blog_id.']"  size="7" maxlength="7" value="'.$style_field.'"> Export all these styles to all other non-nested post within the same parent column <span class="highlight edit" title="Specifically all styles similarly grouped under field '.$style_field.'"> Grouping of Styles</span> Here
                 ');
      printer::alertx('<p class="fs1info editfontfamily info editbackground floatleft clear italic underline" title="If checking this box only '.$this->blog_type.' posts within the parent column will be updated with chosen style"><input type="checkbox" value="1" name="export_allpoststyle_match['.$this->blog_id.']" value="">Require matching post type.</p>');
     printer::close_print_wrap1('tie export style');
     printer::close_print_wrap('global clone field blog');
     $this->clipboard('blog',$this->blog_id,$style_field);
     $this->submit_button();
     printer::close_print_wrap('copy styles');
     $this->show_close('Style Copy Settings');
     }//end style blog port
     
function copy_to_clipboard(){ 
	$table2=$this->master_page_table;
     $q="update $this->master_page_table set page_clipboard=''";//initializeby setting all as empty for cross page compatibility 
	$this->mysqlinst->query($q);
	if (count($_POST['copy_to_clipboard'])>1){
		printer::alert_neg('Only Copy 1 Style field to Clipboard with each submit');
		return;
		}
	else{
		foreach(array('col','page','blog','colclone','blogclone')  as $type){
			if (isset($_POST['copy_to_clipboard'][$type])){
				$data=$_POST['copy_to_clipboard'][$type];
				if (is_array($data)){
                         $this->message[]='Submit 1 copy to clipbard only';
					return;
					}
				$data=$_POST['copy_to_clipboard'][$type];
				if (strpos($data,'@x@x')!==false){
					list($f,$id)=explode('@x@x',$data);  
					switch($type){
						case 'page' :
							$table=$this->master_page_table;
							$field='page_id';
                                   $prefix='';
							break;
						case 'col':
							$table=$this->master_col_table;
							$field='col_id';
                                   $prefix='';
							break;
						case 'blog':
							$table=$this->master_post_table;
							$field='blog_id';
                                   $prefix='';
							break;
						case 'colclone':
							$table=$this->master_col_css_table;
							$field='col_id';
                                   $prefix='c';
							break;
						case 'blogclone':
							$table=$this->master_post_css_table;
							$field='blog_id';
                                   $prefix='p';
							break;
						default: return;
						}
					$q="update $table2 as c, $table as p set c.page_clipboard=p.$f where p.$field='$prefix$id' and c.page_ref='$this->pagename'";  
					$this->mysqlinst->query($q);  
					if ($this->mysqlinst->affected_rows()){
						$this->success[]="Field: $field from $id copied to clipboard";
						}
					else $this->message[]="Field: $field from $id did not change";
					}
				else  $this->message[]="Entry failed to copy to clipboard";
				}
			}	
		}
	} 
     
function clipboard($type,$id,$field){
	$this->print_wrap('global paste');
	printer::print_tip('Copy to clipboard all the styles here then paste the current clipboard styles to any post, page, or column styles! Allows you to copy between different fields and between post &amp; column &amp; page styles.  Note:Copying from one style and Pasting on another results in the latest paste being the one copied. Only styles normally expressed will be utilized. Only one Copy to clipboard event will be registered.');
     $this->show_more('Clipboard Style info','','info italic smaller');
     printer::print_wrap1('techinfo');
      $msg='Clipboard style is saved to the master_page table under the field page_clipboard then retrieved with a paste event. You can do both operations at once or do paste in separate submits. Always the last copied styles are used for pasting and may viewed below under current clipboard styles'; 
     printer::print_info($msg);
     printer::close_print_wrap1('techinfo');
     $this->show_close('Style info');
	printer::alert('Current Clipboard styles: <br>');
	$this->display_parse_style('page','page_clipboard',$this->page_id);
	printer::alert('<input type="text" value=""  size="6" maxlength="6" name="paste_from_clipboard['.$type.']['.$field.'@x@x'.$id.'][]">Type the word "paste" into into box to paste the current clipboard replacing these styles');
	printer::alert('<input type="checkbox" value="'.$field.'@x@x'.$id.'" name="copy_to_clipboard['.$type.']">Check here to copy these styles to current clipboard (Only one copy event will be registered)');
	$this->submit_button();
     printer::close_print_wrap('global paste');
	}
     
 function css_generate(){
	if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);  
 (Sys::Deltatime)&&$this->deltatime->delta_log(__LINE__.' @ '.__method__.'  '); 
    //what this will do is generate a css element and then the style for each element automatically!! 
	if (!isset($this->render_array)||empty($this->render_array)){
		mail::alert(__LINE__.' : line#   Missing render array');
		return;
		}
     foreach($this->render_array as $elem){ //render array is generated with each call to edit styles close!!
		if (is_array($elem)) {
			$css_classname=trim($elem[2]);
			$style=trim($elem[1]);
			$element = trim($elem[0]);
			$idref = trim($elem[3]);
			}
		else {
			$msg='Array Error'; 
			mail::alert($msg);
			$this->message[]=$msg;
			}
			
		if (!isset($this->$style)||!is_array($this->$style)||count($this->$style)<1){  
			$msg='improper array formation with element '.$element.Sys::error_info(__LINE__,__FILE__,__METHOD__);
			
			continue;
			}    
		
		$count=count(explode(',',Cfg::Style_functions)); 
		array_splice($this->$style, $count);//trim appendages..
          $mediastyler='';
		$collect='';
		
		foreach ($this->$style as $genstyle){
               if (is_array($genstyle)) {
                    if ($genstyle[0]==='mediastyler')$mediastyler=$genstyle[1];
                    continue;
                    }
			if (strpos($genstyle,'@@')!==false)continue;
			if (!empty(trim($genstyle))) {
				$collect.=$genstyle.' ';   
				}
			} //end foreach
		if (empty($collect))continue;
		$style_css=$css_classname; 
		$csstype=($element==='bodyview'||$element==='body')?'pagecss':'css';
	     $css="\n".'  '.$style_css .'{'.$collect; 
		$css.='}
          ';
		 
          if (!empty($mediastyler)) { 
			$mediaopen='
'.$mediastyler.'{
';
               $mediaclose='
     }';
               }
         
          else {
               $mediaopen='';
               $mediaclose='';
               }
		
		if ($csstype==='css'){
			$this->css=$mediaopen.$css.$mediaclose;  
			$this->handle_css_edit($idref,'cssgen');
			}
		else $this->{$csstype}.=$mediaopen.$css.$mediaclose;
          $this->id_class=false;//set back to false: was set true if you wish to use # instead of.
		$advanced= (array_key_exists($css_classname,$this->advancedstyles)&&!empty($this->advancedstyles[$css_classname]))?NL.$this->advancedstyles[$css_classname]:''; 
		($element==='bodyview')&&$this->css_view[]=$css. $advanced;//for previewing special tags and classes styling only
		(Sys::Deltatime)&&$this->deltatime->delta_log('After Insert '.__LINE__.' @ '.__method__.'  ');
		} //end foreach
	file_put_contents(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'css_data_sheet_'.$this->pagename.$this->passclass_ext,serialize($this->css_view));//for previewing special tags and classes styling only
	(Sys::Deltatime)&&$this->deltatime->delta_log('End of '.__LINE__.' @ '.__method__.'  ');
	}

function display_parse_style($type,$field,$id,$showlist=''){
	static $inc=0; $inc++;
	$show_msg='Display Styles';
	echo '<div id="display_styles_'.$inc.'"><p class="smallest italic editbackground editfont click floatleft" title="View Chosen Styles" onclick="gen_Proc.use_ajax(\''.Sys::Self.'?display_styles='.$type.'@@'.$id.'@@'.$field.'&amp;style_list='.$showlist.'&amp;display_id=display_styles_'.$inc.'\',\'handle_replace\',\'get\');" >Click to display Parsed Styles</p></div>'; 
	printer::pclear(5);
    }

function display_parse_options($type,$id){ 
	static $inc=0; $inc++;
	$show_msg='Quick View Current Settings';
     printer::pclear(5);
     echo '<div id="display_options_'.$inc.'"><p class="smaller italic editbackground editfont click floatleft" title="View Chosen Settings Options" onclick="gen_Proc.use_ajax(\''.Sys::Self.'?display_options='.$type.'@@'.$id.'&amp;display_id=display_options_'.$inc.'\',\'handle_replace\',\'get\');" >Click to display Parsed options</p></div>';
	}
		 
function globalize_text_post($dataname){ if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
    static $x=0;
    $this->alert('<input type="checkbox" name="globalize_text['.$x.']" value="'.$dataname.'">Click here to Globalize the text for '.$dataname.' To All Pages in Website');
    $x++;
    }

function edit_styles_open(){if(Sys::Custom)return;if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);   
     if (!$this->edit)return;
     printer::pclear();
	if (!$this->is_blog){ 
		return;
		}   
	$class=($this->current_net_width<100)?'supersmall':'smaller';
	echo '<div class="shadowoff fs1'.$this->column_lev_color.' editbackground editfont left5 right5 floatleft editfont" style="max-width:'.$this->current_net_width.'px;"><!--edit styles open-->';
    $a='Post#'.$this->blog_order_mod.' in Col#'.$this->column_order_array[$this->column_level];
	$b='<span class="'.$class.'">Type: '.strtoupper(str_replace('_',' ',$this->blog_type)).'</span>';
	$c="Post Id: P$this->blog_id";
	if ($this->blog_unstatus==='unclone'){
		$this->show_more('Mirror Release Info','','info underline italic small editbackground editfont');
		if ($this->orig_val['blog_type'] ==='nested_column')
			printer::print_info('The Original Column post which was indirectly cloned then unmirrored here is from is page_ref: '.$this->orig_val['blog_table_base'].'  and is Col Id:'.$this->orig_val['blog_data1'].'. If doing a template tranfer include this column in your template and you will automatically include this content from this current column here!');
		else printer::print_info('The Original '.$this->orig_val['blog_type'].' Post which was indirectly cloned then unmirrored here is from page_ref: '.$this->orig_val['blog_table_base'].'  and is Post Id:'.$this->orig_val['blog_id'].'. If doing a template tranfer include this Post in your new template and you will automatically include this content from this current Post here!');
		$this->show_close('From Info');
		}
	($this->blog_unstatus==='unclone')&&printer::alert('Mirror release Post','','orange left ');
	printer::alert($a.NL.$b,'',$this->column_lev_color.' left ');
	printer::alertx('<p class="highlight left" title="The Unique '.$c.' Would Be Used for Copying/Cloning/Moving this Post Elsewhere. For Styles look for '.$this->data.' For Advanced Styles look for #post_'.$this->blog_id.'. Parent column has Id:'.$this->col_id.'">'.$c.'</p>');
	$this->show_more('info','noclear','info smaller floatleft');
	$this->print_wrap('primal');
	printer::alert('Post Css &amp; ID/CLASS: '.$this->dataCss);
	printer::alert('Parent Col Id: '.$this->col_id);
	printer::alert('Blog Order: '.$this->blog_order);
     printer::alert('Post Full Class Names: '.$this->post_full_class);
     if ($this->is_clone)printer::alert('Original Blog_id: '.$this->orig_val['blog_id']);
	$widthSetting='&#x2715;';
     $float='&#x2715;'; 
     $altGridFull='&#x2715;';
     $altGridPercent='&#x2715;'; 
     $enableGrid='&#x2715;'; 
     $scaleMode='&#x2715;';
     $flexMode='&#x2715;';
     $enableMasonry=($this->is_masonry)?'&#x2713;':'&#x2715;';
     $float=($this->blog_float==='center_row')?'&#x2715;':'<span class="tiny">'.str_replace('_','',ucwords($this->blog_float ,'_')).'</span>';
	if ($this->rwd_post){
		$enableGrid='&#x2713;';
          printer::print_info('RWD grid Active. Overrides other width Modes'); 
		}
     else{
          if ($this->flex_box_item){
               $flexMode='&#x2713;';
               printer::print_info('Flex Box Item Active. Use along with Main Width Modeor Alt width Units. Overrides Masonry assist');
               }  
          if($this->use_blog_main_width){
               $widthSetting=($this->blog_width_mode[$this->blog_width_mode_index]!=='compress_full_width'&&$this->blog_width_mode[$this->blog_width_mode_index]!=='compress_to_percentage')?'&#x2713;':'&#x2715;';    
              $altGridFull=($this->blog_width_mode[$this->blog_width_mode_index]==='compress_full_width')?'&#x2713;':'&#x2715;';
               $altGridPercent=($this->blog_width_mode[$this->blog_width_mode_index]==='compress_to_percentage')?'&#x2713;':'&#x2715;'; 
               $scale=($widthSetting==='&#x2713;')?'using max-width':(($widthSetting==='compress_full_width')?'using fully compressable by percent':'using percent with set media width percent tweaks.');
               printer::print_info('Main Width Set '.$scale);
               }
          else {  
               $info=$this->check_spacing($this->blog_options[$this->blog_max_width_alt_opt_index],'max-width');
               $info.=$this->check_spacing($this->blog_options[$this->blog_width_alt_opt_index],'width');
               $info.=$this->check_spacing($this->blog_options[$this->blog_min_width_alt_opt_index],'min-width');
               if (empty($info))
                    printer::print_info('<b>No Active</b> alt width units em, rem,  %, px  sizing this '.$this->blog_typed);
                    
               else {
                    printer::print_info('Alternative Width Units Selected: '.$info);
                         printer::print_info($this->blog_width_info);
                         $scaleMode='&#x2713;';
                    }
               }
          }
     $emscale=($this->terminal_em_scale)?'on':'off';
     printer::print_info("1 em unit currently equivalent to {$this->terminal_font_em_px}px with scaling $emscale");
     $remscale=($this->rem_scale)?'on':'off';
     printer::print_info("1 rem unit equivalent to $this->rem_root px with scaling $remscale");
     $blog_pad_info='';
	$spacing_arr=array('padding_right','padding_left','margin_right','margin_left');
	foreach ($spacing_arr as $space){
          if (!empty($this->{$space.'_info'})){
               $type=str_replace('_','-',$space);
               $blog_pad_info.=$type.' set: '.$this->{$space.'_info'}.'<br>';
               } 
          }
     if (!empty($blog_pad_info)){
          printer::print_info('right and left padding and margin info:<br>'.$blog_pad_info);
          }
     else printer::print_info('No right or left padding or margin set');
     (!empty($this->left_border_info))&&printer::print_info($this->left_border_info);
     (!empty($this->right_border_info))&&printer::print_info($this->right_border_info);
     printer::print_tip('In the parent column of posts RWD grid may be enabled which enables choosing the RWD Grid Percentages to lay out this post as a percentage of the available column width at different break points which correspond to different viewer screen sizes. <br><br>Similarly, Flex Box or Masonry may be enabled in the parent column which assists layouts of the posts.',.8);
	echo '<table class="p10 editcolor editbackground editfont" style="max-width:700px">
	<tr><th style="width:15%">Status</th><th style="width:85%">Setting</th></tr>
	<tr><td> &nbsp; '.$enableGrid.'</td><td>Post RWD Grid Unit Choices Enabled</td></tr>
	<tr><td> &nbsp; '.$flexMode.'</td><td>Post Flex Box Choices Enabled</td></tr>
	<tr><td>&nbsp; '.$float.'</td><td>Active Float Setting</td></tr>  
	<tr><td> &nbsp; '.$widthSetting.'</td><td>Active Main Width max-width Setting</td></tr>
	<tr><td>&nbsp; '.$altGridFull.'</td><td>Main Width Full Percentage Compress</td></tr>  
	<tr><td>&nbsp; '.$altGridPercent.'</td><td>Main Width Percentage with set media width tweaks</td></tr>
	<tr><td>&nbsp; '.$scaleMode.'</td><td>Alt Width Units (em rem % px)</td></tr> 
	<tr><td>&nbsp; '.$enableMasonry.'</td><td>Masonry Assist Enabled<br></td></tr></table>';
	$this->close_print_wrap('primal'); 	
	$this->show_close('info','','info fs1info');
     echo '<a title="go to post bottom" href="#pbot_'.$this->blog_id.'" style="color:#'.$this->editor_color.'" class="cursor pr15 editcolor editbackground tiny italic underline floatright">Go pBot</a>';
	echo '</div><!--end edit style open-->'; 
	printer::pclear(2);
	}
 
function misc($data){return;  //outdated option
	 ($this->edit)&&    
		$this->blog_options($data,$this->blog_table);
	if ($this->edit){
		printer::print_tip('100% length width or height line separators between posts may be created when styling borders in each Post styling options.   Choose top bottom left or right side.<br>  Here, create a horizontal svg line  and choose  percentage of available width  to begin or end the line');
		$startx=$endx=$colorx=$widthx=0;
		$this->show_more('Create a Line Here');
		$this->print_wrap('create line');
		$this->print_wrap('create start line');
		printer::alert('Choose Starting Percentage of Line');
		$this->mod_spacing($data.'_blog_tiny_data1',$startx,1,100,1,'%');
		printer::close_print_wrap('create start line');
		$this->print_wrap('create end line');
		printer::alert('Choose Starting Percentage of Line');
		$this->mod_spacing($data.'_blog_tiny_data2',$endx,1,100,1,'%');
		printer::close_print_wrap('create end line');			    
		$this->print_wrap('choose line width');
		printer::alert('Choose Line Width');
		$this->mod_spacing($data.'_blog_tiny_data3',$widthx,1,100,1,'px');
		printer::close_print_wrap('choose line width');			    
		$this->print_wrap('choose line color');
		printer::alert('Choose Your Line color');
		$this->mod_spacing($data.'_blog_tiny_data4',$colorx,1,100,1,'px');
		printer::close_print_wrap('choose line color');
		printer::close_print_wrap('create line');
		$this->show_close('Create a Line Here');
		}//end edit
		 
	echo '<svg style=" width:100%;">
  <line x1="20%" y1="0%" x2="80%" y2="0%" style="stroke: rgb(234, 243, 234);stroke-width: 5;"></line>
</svg>';
	$style_list=''; 
	$this->edit_styles_close($data,'blog_style','.'.$data, $style_list ,"Add Additional Background Styling Features Here");
	}//end misc
	
#textarea    
function textarea($dataname,$name,$width='600',$fontsize=16,$turn_on='',$float='left',$percent=100,$inherit=false,$class=''){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	$display_editor=($turn_on)?'mytextarea ':'';
	$cols= 'cols="'.(process_data::width_to_col($width,$fontsize)).'"'; 
	$data=(isset($this->$dataname))?$this->$dataname:$dataname;    
	$rowlength=(!empty($data))?process_data::row_length($data,$cols):3; 
     $style=(!empty($float)&&!empty($percent))?'style="width:'.$percent.'%; float:'.$float.';"':((!empty($float))?'style="float:'.$float.';"':((!empty($percent))?'style="max-width:'.$percent.';"':((!empty($float))?'style="float:'.$float.';"':'')));
	echo '<textarea '.$style.' class="'.$class.' scrollit '.$display_editor.' fs1'.$this->column_lev_color.'" name="'.$name.'" cols="50" rows="'.$rowlength.'" onkeyup="gen_Proc.autoGrowFieldScroll(this)">' . process_data::textarea_validate($data).'</textarea>'; 
	}

function comment_display($data){ 
	if (!$this->edit&&$this->blog_options[$this->blog_comment_index]!=='comment_on')return;
	$num=80;  
	if ($this->edit){
		if(isset($_POST['comment_remove'][$this->blog_id])){
			foreach($_POST['comment_remove'][$this->blog_id] as $del_id =>$del_name){
				$q="delete from $this->comment_table  where com_blog_id='$this->blog_id' and com_id='$del_id'";
				$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
				if ($this->mysqlinst->affected_rows()){
					$this->success[]='Comment from '.$del_name.' has been Deleted for postId p'.$this->blog_id;
					}
				else $this->message[]='Comment from '.$del_name.' has not been Deleted for postId p'.$this->blog_id;
				}//end foreach
			}//coment remove
		if (isset($_POST['comment_accept'][$this->blog_id])){
			foreach($_POST['comment_accept'][$this->blog_id] as $acc_id =>$acc_name){
			$q="update $this->comment_table set com_status=1 where com_blog_id='$this->blog_id' and com_id='$acc_id'";
			$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
			if ($this->mysqlinst->affected_rows()){
				$this->success[]='Comment from '.$acc_name.' has been Added for postId p'.$this->blog_id;
				}
			else $this->message[]='Comment from '.$acc_name.' has not been Addedfor postId p'.$this->blog_id;
				}//end foreach
			}
		if(isset($_POST['delete_all_comments'][$this->blog_id])){
			$q="delete from $this->comment_table  where com_blog_id='$this->blog_id'";
				$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
				if ($this->mysqlinst->affected_rows()){
					$this->success[]='All Comments from have been Deleted for postId p'.$this->blog_id;
					}
				else $this->message[]='No Comments have been Deleted for postId p'.$this->blog_id;
				}//end foreach
			}//end if edit
	if (isset($_GET['accept_'.$this->blog_id])&&strlen($_GET['accept_'.$this->blog_id])===$num){
		$q="update $this->comment_table set com_status=1 where com_blog_id='$this->blog_id' and com_token='".$_GET['accept_'.$this->blog_id]."'";
		$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
		if ($this->mysqlinst->affected_rows()){
			printer::alert_pos('Comment has been Added');
			}
		else {
			$where="WHERE com_blog_id='$this->blog_id' and  com_token='".$_GET['accept_'.$this->blog_id]."'"; 
			$count=$count=$this->mysqlinst->count_field($this->comment_table,'com_blog_id','',false,$where);
			if ($count > 0)printer::alert_pos('This Comment has already been Added');
			else printer::alert_neg('Comment has not been Added');
			}
		}
	if (isset($_GET['remove_'.$this->blog_id])&&strlen($_GET['remove_'.$this->blog_id])===$num){
		$q="delete from $this->comment_table  where com_blog_id='$this->blog_id' and com_token='".$_GET['remove_'.$this->blog_id]."'";
		$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
		if ($this->mysqlinst->affected_rows()){
			printer::alert_pos('Comment has been Deleted');
			}
		else printer::alert_neg('Comment has not been Deleted');
		}
	$comment_email='';	
	if (isset($_POST['feedback_submit'])){
		if (isset($_POST['comment_name'][$this->blog_id])&&!empty($_POST['comment_name'][$this->blog_id])){
			$comment_name=$_POST['comment_name'][$this->blog_id]; 
			}
		if (isset($_POST['comment_email'][$this->blog_id])&&!empty($_POST['comment_email'][$this->blog_id])){
			$comment_email=$_POST['comment_email'][$this->blog_id]; 
			}
		if (isset($_POST['comment_text'][$this->blog_id])&&!empty($_POST['comment_text'][$this->blog_id])){
			$comment_text=$_POST['comment_text'][$this->blog_id];
			}
		if (isset($comment_text)&&!isset($comment_name))printer::alert_neg("Name field was omitted in postId$this->blog_id Comment");
		elseif (!isset($comment_text)&&isset($comment_name))printer::alert_neg("Name field was omitted in postId$this->blog_id ");
		else if (isset($comment_text)&&isset($comment_name)){
			$comment_token=process_data::create_token($num);//sent to email
			$comment_text=process_data::spam_scrubber($comment_text,'strict');
			$comment_email=process_data::spam_scrubber($comment_email,'strict');
			$comment_name=process_data::spam_scrubber($comment_name,'strict');
			$q="insert into  $this->comment_table (com_blog_id,com_text,com_name,com_email,com_status,com_token,com_time,com_update,token)   values ('$this->blog_id','$comment_text','$comment_name','$comment_email','0','$comment_token','".time()."','".date('dMY-H-i-s')."','".mt_rand(1,mt_getrandmax())."')";  
			$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
			if ($this->mysqlinst->affected_rows()){
				$site=trim(str_replace(array('https://','http://'),'',Cfg::Site),'/').'/'.Sys::Filename; 
				$msg="Your Feedback for Post is awaiting Review";
				printer::alert_pos($msg);
				$addresses=explode(',',Cfg::Contact_email);
				$msg.='<br>'.date('dMY-H-i-s');
				$msg.='<br>'.$comment_name." has sent a comment post to your post id$this->blog_id on page $this->pagename  "; 
				$msg.='<br> Visit the editpage to delete or accept comments or click the links below';
				$msg.='<br><a style="color:red" href="http://'.$site.'?remove_'.$this->blog_id.'='.$comment_token.'&amp;msg=Comment from '.$comment_name.' has been Deleted">Click Here To Delete This Comment</a>';
				$msg.='<br>'.$comment_name; 
				$msg.='<br> comment text is :';
				$msg.='<br>'.$comment_text;
				$msg.='<br> comment email is :';
				$msg.='<br>'.$comment_email;
				$msg.='<br><br> <a style="color:green;" href="http://'.$site.'?accept_'.$this->blog_id.'='.$comment_token.'&amp;msg=Comment from '.$comment_name.' has been approved">Click Here To Publish This '.$this->comment.'</a>';
				$msg.='<br>Message(s)  sent to: '.Cfg::Contact_email;
				$this->body=$msg;
				$this->subject='Website Feedback Recieved on '.Cfg::Owner;
				foreach ($addresses as $address){ 
					$this->contact_mail_send($address);
					}
				printer::printx('<script >alert(\'Thankyou	'.$comment_name.' Your feedback has been sent\');</script>');
				}
			else{
				printer::alert_neg("Problem Posting Your Feedback for Post");
				mail::alert('Feedback Mail send Problem');
				}
			}
		}//post comment_submit
	printer::pclear(10);
	$where="WHERE com_blog_id='$this->blog_id' and com_status=1";
	$count=$count=$this->mysqlinst->count_field($this->comment_table,'com_blog_id','',false,$where);
	$count=(empty($count))?0:$count;
	$comment=($count===1)?' '.$this->comment.'':' '.$this->comment.'s';
	printer::printx('<p class="floatleft">&nbsp;</p>'); 
	if (!$this->edit&&$this->blog_options[$this->blog_comment_display_index]!=='display_comment') 
		$this->show_more($count.$comment,'slow','style_comment_view floatleft small');
	else	printer::alertx('<p class="smallest style_comment_view floatleft">'.$count.$comment.'&nbsp;&nbsp;</p>');
	printer::pclear();
	###begin again except with Acceptance Mesage 
	if ($this->edit){ 
		$where="WHERE com_blog_id='$this->blog_id' and com_status!=1";
		$accept_count=$this->mysqlinst->count_field($this->comment_table,'com_blog_id','',false,$where);
		$comment=($accept_count==1)?' '.$this->comment.'':' '.$this->comment.'s'; 
		if ($accept_count >0 )printer::alertx('<p class="small  fs1npred lightredAlertbackgroundnp floatleft">'.$accept_count.$comment.'&nbsp;Awaiting Approval</p>');
		printer::pclear();
		}
	if (!$this->edit){
		$upper_maxwidth=500*$this->current_font_px/16;//upper contact form max width
		$current_net_width=($this->current_net_width<$upper_maxwidth)?$this->current_net_width:$upper_maxwidth;
		$current_total_width_left=$current_net_width*.60;
		echo '<p onclick="gen_Proc.toggleClass2(\'#'.$data.'_show\',\'hide\');" class="click  smaller style_comment_view pos">Add Yours</p>';
		forms::form_open('','onsubmit="return gen_Proc.funcPass({funct:\'validateEntered\',pass:{idVal:\'comment_name_'.$this->blog_id.'\',ref:\'name\'}},{funct:\'validateEntered\',pass:{idVal:\'comment_text_'.$this->blog_id.'\',ref:\'comment textarea\'}});"');
		echo '<div id="'.$data.'_show" class="hide" style="background:white;color:#444; padding:5px; margin:4px; border: solid 3px #e9967a"><!--leave comment-->';
		printer::printx('<p class="tiny nopostemail">Email addresses will not be posted</p>
		<p class="floatleft smaller" style="background:white;color:#555;">Your Name:&nbsp;&nbsp;</p>
		 <input  style="background:white;color:#555;" type="text" name="comment_name['.$this->blog_id.']" id="comment_name_'.$this->blog_id.'"  maxlength="35" value=""> ');
		printer::pclear(7);
		printer::printx('
		<p class="floatleft smaller" style="background:white;color:#555;">Your Email:&nbsp;&nbsp;</p>
		 <input style="color:red;background:white;" type="text" name="comment_email['.$this->blog_id.']" id="comment_email_'.$this->blog_id.'"  maxlength="35" value=""> ');
		printer::pclear(7);
		printer::printx('<p class="floatleft smaller" style="background:white;color:#555;float:left; margin-left:2px;">'.$this->comment.':</p>'); 
		printer::pclear(7);
		printer::printx('<textarea style="background:white;color:#555;" id="comment_text_'.$this->blog_id.'" class="width100  fs1'.$this->column_lev_color.'" name="comment_text['.$this->blog_id.']" rows="3"    onkeyup="gen_Proc.autoGrowFieldScroll(this);"></textarea>');
		forms::form_close('','Add '.$this->comment,'feedback_submit');
		echo '</div><!--class hide-->';
		
           if ($this->blog_options[$this->blog_comment_display_index]!=='display_comment')
			$this->show_close('Leave '.$this->comment.'');
		}//!edit and leave feedback	 
	if ($count>0 || ($this->edit&&$accept_count>0)){
		if($this->edit){
			printer::pclear();
               $this->show_more('Accept/Remove Comments');
			printer::pclear(); 
			printer::printx('<p class="editcolor editbackground editfont fsminfo editbackground editfont">Specific Styles for Comments may be set for all posts under the  column master settings or page config settings.  Immediate Columns Settings if set will override page and parent column settings</p>');
			printer::pclear();
			}
		$q="select com_id,com_name,com_email,com_text,com_status,com_time from $this->comment_table where com_blog_id='$this->blog_id' order by com_time DESC";  
		$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
		#commentdisplay
		($this->edit)&&$this->print_wrap('wrap edit comments');
		while(list($com_id,$name,$email,$text,$status,$date)=$this->mysqlinst->fetch_row($r,__LINE__,__METHOD__)){
			$date=date("F j, Y   g:i A",$date);
			if (!$this->edit){
				if ($status){
					echo '<div class="posted_comment"><!--comments-->';
					printer::printx('<p class="bold">'.$name.'</p>');
					printer::printx('<p class="style_comment_date">Posted: '.$date.'</p>');
					printer::printx('<p>'.$text.'</p>');
					printer::pclear();
					echo '</div><!--comments-->';
					printer::pclear(5);
					}
				}
			else	{// is edit
				echo '<div class="posted_comment"><!--comments-->';
				printer::printx('<p style="padding-bottom:10px;">'.$name.'</p>');
				printer::printx('<p style="padding-bottom:10px;">'.$email.'</p>');
				printer::printx('<p>'.$text.'</p>');
				printer::printx('<p class="style_comment_date" style="float:left;">Posted: '.$date.'</p>');
				printer::pclear();
				echo '<div class="rs1redAlert"><!--wrap comment-->';
				(!$status)&&printer::printx('<p class="editbackground editfont editcolor editfont"><input type="checkbox" name="comment_accept['.$this->blog_id.']['.$com_id.']" value="'.$name.'"><span class="bold white posbackground">Accept New '.$this->comment.' </span></p>');
				printer::printx('<p class="editbackground editfont editcolor editfont"><input type="checkbox" name="comment_remove['.$this->blog_id.']['.$com_id.']" value="'.$name.'"><span class="white bold redAlertbackground">Remove New Feedback </span></p><br>');
				echo '</div><!--wrap comment-->';
				echo '</div><!--comments-->'; 
				}//is edit
			}//end while
		($this->edit)&&printer::close_print_wrap('wrap edit comments');
		$delete_msg= 'Caution All Accepted and Pending Comments Will Be Deleted if you Check this Box.';
		($this->edit)&&printer::alertx('<p class="redAlertbackground left white Os2redAlert fs2npblack floatleft smaller">&nbsp;&nbsp;&nbsp;<input type="checkbox" name="delete_all_comments['.$this->blog_id.']" value="delete" onchange="edit_Proc.oncheck(\'delete_all_comments['.$this->blog_id.']\',\''.$delete_msg.'\')" >REMOVE All COMMENTS FOR THIS POST &nbsp;&nbsp;</p>');
		($this->edit)&&$this->show_close('Accept/Remove Comments');	
		printer::pclear();
		}//if count
		if (!$this->edit&&$this->blog_options[$this->blog_comment_display_index]!=='display_comment') 
			$this->show_close($count.$comment);
	if ($this->edit){ 
		$this->css.='
		@media screen and (max-width: 400px){
			.'.$this->dataCss.' input{max-width:250px;}
			}
		@media screen and (max-width: 350px){
			.'.$this->dataCss.' input{max-width:200px;}
			}
		@media screen and (max-width: 300px){
			.'.$this->dataCss.' input{max-width:160px;}
			}';
		}
	}//end comment_display
	

function edit_form_head(){   if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__); 
     echo'<form id="mainform" action="'.Sys::Self.'" ' .$this->form_load.' method="post" '.$this->onsubmit.'><!--mainform begin-->';
	}
	
function display_state(){
	#note: display property and advanced styles use css #id to override normal styles which use distinct classnames
	$css_id=($this->is_column)?$this->col_dataCss:$this->dataCss;
	$max_name=($this->is_column)?$this->col_name.'_col_options['.$this->display_max_index.']':$this->data.'_blog_options['.$this->display_max_index.']';
	$min_name=($this->is_column)?$this->col_name.'_col_options['.$this->display_min_index.']':$this->data.'_blog_options['.$this->display_min_index.']';
	$type=($this->is_column)?'Column':'Post'; 
	$msg='Select a min-width or max-width or both at which to display:none this '.$type;
	$val_max=($this->is_column)?$this->col_options[$this->display_max_index]:$this->blog_options[$this->display_max_index];
	$val_min=($this->is_column)?$this->col_options[$this->display_min_index]:$this->blog_options[$this->display_min_index];
	$this->show_more('Display @media Off ',$msg,'','','800');
	$this->print_redwrap('Display state');
     printer::print_tip('Control display based on <b>@media queries</b>  or <b>scroll height methods</b>');
     printer::print_wrap('display media method');
	printer::print_tip('<b>Use @media queries</b> to optionally set a maximum and/or minimum width at which will initate a display:none for this post in webpage mode only. <br> Note: Display Property for RWD grid mode may also be responsively Turned off using 0 grid units (ie %) for particular break pts. <b>Flex elements will not respond</b>');
	$displayoff_maxpx=($val_max>199&&$val_max<2001)?$val_max:'none';
	$displayoff_minpx=($val_min>199&&$val_min<3001)?$val_min:'none';
	$mediacss=$css='';
	if ($displayoff_minpx!=='none'&&$displayoff_maxpx!=='none') {
          $mediacss.=$css.='
          @media screen and (max-width:'.$displayoff_maxpx.'px) and (min-width:'.$displayoff_minpx.'px){
          #'.$css_id.'{display:none;}
               }
               ';
          }
     elseif ($displayoff_maxpx!=='none'){
          $mediacss.=$css.='
          @media screen and (max-width: '.$displayoff_maxpx.'px){
          #'.$css_id.'{display:none;}
          }';
          }
     elseif ($displayoff_minpx!=='none') {
          $mediacss.=$css.='
          @media screen and (min-width: '.$displayoff_minpx.'px){
          #'.$css_id.'{display:none;}
          }';
          }
     
     $this->show_more('Style info','','info italic smaller');
     printer::print_wrap1('techinfo');
     printer::print_info('Current setting Css: '.$css);
     $msg='Uses @media control of display:none; css property';
     printer::print_info($msg);
     printer::close_print_wrap1('techinfo');
     $this->show_close('Tech info');
     
     $btype=($this->is_blog)?$this->blog_type:'nested';
     $this->css.=$mediacss;
     (!empty($this->display_edit_data))&&$this->editoverridecss.=" 
     html div#{$css_id}.$btype {display: $this->display_edit_data;}";//display state on in editmode  
     printer::printx('<p class="info floatleft">#'.$css_id.'</p>'); 
     printer::print_info('Optionally choose a min-width or max-width or both at which this '.$type.' will not appear (will not effect editmode).');  
     echo '<div class="fsminfo"><!--wrap max width-->';
     printer::printx('<p class="smaller '.$this->column_lev_color.'">Chosen Display Off max-width: <span class="navybackground white">'.$displayoff_maxpx.'</span><br></p>'); 
     printer::alert('Choose @media screen max-width px');
     $this->mod_spacing($max_name,$displayoff_maxpx,200,2000,1,'px','none');  
     printer::printx('<p ><input type="checkbox" name="'.$max_name.'" value="0">Remove max-width</p>');
     echo '</div><!--wrap max width-->';
     echo '<div class="fsminfo"><!--wrap min width-->';
     printer::printx('<p class="smaller '.$this->column_lev_color.'">Chosen min-width: <span class="navybackground white">'.$displayoff_minpx.'</span></p>');
     printer::alert('Choose @media screen min-width px');
     $this->mod_spacing($min_name,$displayoff_minpx,200,2000,1,'px','none');  
     printer::printx('<p ><input type="checkbox" name="'.$min_name.'" value="0">Remove min-width</p>');
     echo '</div><!--wrap min width-->';
     printer::close_print_wrap('display media method');
     $this->submit_button(); 
          printer::pclear();
     $this->close_print_wrap('Display state');
     $this->show_close('display state Off'); 
     printer::pclear();
     }//end display 

     
function display_px_scroll(){
     self::$xyz++;   
      #this is for all posts including nested columns
      $options=($this->is_column)?$this->col_options[$this->col_display_state_px_index]:$this->blog_options[$this->blog_display_state_px_index]; 
     $options=explode('@@',$options);
     $px_options='display_max,display_min,display_fade_px,display_fade_choice,display_fade_mode,display_basis,display_speed';
	$px_options=explode(',',$px_options);
	$c_opts=count($px_options);
      foreach($px_options as $key =>$index){
		${$index.'_index'}=$key;
		}
     $repeats=3*$c_opts;
     $cb_data=($this->blog_type==='nested_column')?$this->col_dataCss:$this->dataCss;
     $this->show_more('Display Scroll Px');
     printer::print_wrap('display scroll');
	for ($i=0;$i<$repeats; $i++){ 
		if (!array_key_exists($i,$options))$options[$i]=0;
		} 
     for ($i=0; $i<3; $i++){
          $k=$i * $c_opts ;//
          if ($i>0){
               $this->show_more('Additional @Media Controlled');
               printer::print_wrap('Additional display');
               }
          $this->submit_button();
          $element_arr=array('self','id','Closest Matching Previous Class','Closest Matching Next Class');
          printer::print_tip('Use both maxwidth and minwidth for  multiple selected @media widths. Uses Jquery window.width.');
              $basis=($options[$display_basis_index+$k]==='on')?$options[$display_basis_index+$k]:'off'; 
          $display_max=(is_numeric($options[$display_max_index+$k])&&$options[$display_max_index+$k]>0&&$options[$display_max_index+$k]<=4000)?$options[$display_max_index+$k]:'none';
         $display_min=(is_numeric($options[$display_min_index+$k])&&$options[$display_min_index+$k]>0&&$options[$display_min_index+$k]<=4000)?$options[$display_min_index+$k]:'none';
         $display_speed=(is_numeric($options[$display_speed_index+$k])&&$options[$display_speed_index+$k]>=.1&&$options[$display_speed_index+$k]<=3)?$options[$display_speed_index+$k]:1;
          $fadepx=($options[$display_fade_px_index+$k]>0&&$options[$display_fade_px_index+$k]<=750)?$options[$display_fade_px_index+$k]:'0';
          $fadechoice=($options[$display_fade_choice_index+$k]==='fadein'||$options[$display_fade_choice_index+$k]==='fadeout')?$options[$display_fade_choice_index+$k]:'fadein';
          $fademode=($options[$display_fade_mode_index+$k]==='display')?$options[$display_fade_mode_index+$k]:'visible';
          
           
          $display_name=($this->is_column)?$this->col_name.'_col_options['.$this->col_display_state_px_index.']':$this->data.'_blog_options['.$this->blog_display_state_px_index.']';
          $speed_name=$display_name.'['.($display_speed_index+$k).']';
          $max_name=$display_name.'['.($display_max_index+$k).']';
          $min_name=$display_name.'['.($display_min_index+$k).']';
          $fade_px_name=$display_name.'['.($display_fade_px_index+$k).']';
          $basis_name=$display_name.'['.($display_basis_index+$k).']';
          $mode_name=$display_name.'['.($display_fade_mode_index+$k).']';
          $value_name=$display_name.'['.($display_fade_px_index+$k).']';
          $choice_name=$display_name.'['.($display_fade_choice_index+$k).']';
          $type=($this->blog_type==='nested_column')?'nested column':'post';
          $id=($this->blog_type==='nested_column')?$this->col_id:$this->blog_id;
          printer::print_wrap1('max @media');
          printer::alert('specify @media max-width option');
          $this->mod_spacing($max_name,$display_max,100,4000,1,'px','none');
          printer::close_print_wrap1('max @media');
          printer::print_wrap1('min @media',$this->column_lev_color);
          printer::alert('specify @media min-width option');
          $this->mod_spacing($min_name,$display_min,100,4000,1,'px','none');
          printer::close_print_wrap1('min @media');
          printer::print_wrap1('scroll height fade');
          
          #######################
          $checked1=($basis!=='on')?'checked="checked"':'';
          $checked2=($basis==='on')?'checked="checked"':''; 
          printer::alert('<input type="radio" name="'.$basis_name.'" value="off" '.$checked1.'>Turn Off');
          printer::alert('<input type="radio" name="'.$basis_name.'" value="on" '.$checked2.'> Turn On'); 
          printer::close_print_wrap1('scroll height fade');
          ################
          $checked1=($fadechoice!=='fadeout')?'checked="checked"':'';
          $checked2=($fadechoice==='fadeout')?'checked="checked"':'';
          printer::print_wrap1('fade in or out display');
          printer::alert('<input type="radio" name="'.$choice_name.'" value="fadein" '.$checked1.'>Choose fadein to initially hide this '.$type.' till specified scroll height is surpassed then make display/visible');
          printer::alert('<input type="radio" name="'.$choice_name.'" value="fadeout" '.$checked2.'>Choose fadeout to initially display this '.$type.' till specified scroll height is surpassed then hide');
          printer::close_print_wrap1('fade in or out display');
          $checked1=($fademode!=='display')?'checked="checked"':'';
          $checked2=($fademode==='display')?'checked="checked"':'';
          printer::print_wrap1('vis/display');
          printer::print_tip('Visibility:hidden changes the opacity &amp; visibility properties. display:none is emulated by additionally including absolute positioning on the element so it removes the occupied space as well. If the post types/nested columns to fade is already using <b>absolute  positioning</b> use the visibility option so that top left parameters are preserved!');
          printer::alert('<input type="radio" name="'.$mode_name.'" value="visible" '.$checked1.'>Use Visibility:hidden (Preserves spacing affects visiblity only. Use if this '.$type.' to fade in/out is <b>absolutely positioned already</b> to preserve additional settings: top/left etc.)');
          printer::alert('<input type="radio" name="'.$mode_name.'" value="display" '.$checked2.'>Emulate Display:none (Removes/Puts Back Spacing and Visibility)');
          printer::close_print_wrap1('vis/display');

          printer::print_wrap1('duration');
          printer::alert('Specify fade-in fade-out duration option in seconds');
          $this->mod_spacing($speed_name,$display_speed,.1,3,.1,'sec');
          printer::close_print_wrap1('duration');
          
          printer::print_wrap1('choose display fade px');
          printer::print_tip('Set the scroll height for the Visibility/display Transition');
          $this->mod_spacing($value_name,$fadepx,1,750,1,'px'); 
          printer::close_print_wrap1('choose display fade px'); 
          if ($basis==='on'){
               $ms=$display_speed * 1000;
               if ($fademode==='visible')
                    $this->css.='
               .'.$cb_data.'.visibleTransitionOn,.'.$cb_data.'.visibleTransitionOff { 
       -webkit-transition: opacity '.$ms.'ms, visibility '.$ms.'ms;
       transition: opacity '.$ms.'ms, visibility '.$ms.'ms;}
       ';
               else $this->css.='
               .'.$cb_data.'.displayTransitionOff,.'.$cb_data.'.displayTransitionOn  {
  -webkit-transition: opacity '.$ms.'ms, visibility '.$ms.'ms;
  transition: opacity '.$ms.'ms, visibility '.$ms.'ms;
     }
       ';
               $minheight='500px';
               if($fadechoice==='fadein'){ 
                    if ($fademode!=='visible'){ 
                         $inout='displayTransitionOn';
                         $rev_inout='displayTransitionOff';
                         $initclass='displayOff';
                         }
                         
                    else{ 
                         $inout='visibleTransitionOn';
                         $rev_inout='visibleTransitionOff';
                         $initclass='visibleOff';
                         }
                    }
               else {
                    $initclass='';
                    if ($fademode!=='visible'){ 
                         $inout='displayTransitionOff';
                         $rev_inout='displayTransitionOn';
                         }
                         
                    else{ 
                         $inout='visibleTransitionOff';
                         $rev_inout='visibleTransitionOn';
                         }
                    }
            
     
               $initaddclass= ($fadechoice==='fadein')?"jQuery('.$cb_data').addClass('$initclass');":'';
               $display_max=($display_max==='none')?10000 : $display_max;
               $display_min=($display_min==='none')?100 : $display_min;
               $timer='fadethis_scroll_'.self::$xyz++;  
                    $this->script.= <<<eol
               
               
               // display px scroll $type for $cb_data
               if (gen_Proc.vpw <= $display_max && gen_Proc.vpw >= $display_min){
               $initaddclass                    
               jQuery('body').css('min-height','$minheight');
               var $timer='';
               jQuery(window).on('scroll resize', function(){
                    clearTimeout($timer);
                    $timer = setTimeout(function(){ //this will limit no of scroll events responding
                   
                         if (jQuery(this).scrollTop() >= $fadepx) {   
                              jQuery('.$cb_data').addClass('$inout').removeClass('$initclass').removeClass('$rev_inout');  
                              }
                         else if(jQuery(this).scrollTop() < $fadepx) {
                              jQuery('.$cb_data').addClass('$rev_inout').removeClass('$inout');    
                              }
                              
                         },40);
                    });
               }//if media
eol;
               }//if basis
     
          if ($i>0){ 
               $this->submit_button();
               printer::close_print_wrap('Additional display');
               $this->show_close('Additional Media Conrolled Choices');
               }    
          }//for loop
      $this->submit_button();
      printer::close_print_wrap('display scroll');
      $this->show_close('Choose Display Scroll Visibility');
      }//end display       
     
function column_vertical_align(){
		$this->show_more('Vertical Alignment');
	$this->print_redwrap('Adjust default Vertical');
     printer::print_tip('Flex Box Settings if enabled in parent column will override these Vertical settings according to flex container align-item settings and flex-item align-self setting');
	printer::print_tip('By Default center floated Nested Columns (display:inline-block) will Vertically Top Align with Other Posts within the Parent Column. Affects non-flex mode columns. Change that Default Here '); 
	printer::alert('Column Vertical Positioning Choice','','left editcolor editbackground editfont');
	$current_vert_val=($this->col_options[$this->col_vert_pos_index]!=='middle'&&$this->col_options[$this->col_vert_pos_index]!=='bottom')?'top':$this->col_options[$this->col_vert_pos_index];
	forms::form_dropdown(array('top','middle','bottom'),'','','',$this->col_name.'_col_options['.$this->col_vert_pos_index.']',$current_vert_val,false,'editcolor editbackground editfont left');
	$this->css.=$css="\n.". $this->col_dataCss.'{vertical-align:'.$current_vert_val.'}';
     
     $this->show_more('Style info','','info italic smaller');
     printer::print_wrap1('techinfo');
     printer::print_info('Current setting Css: '.$css.' in '.$this->roots.Cfg::Style_dir.$this->pagename.'.css');
     $msg='Vertical Positioning applied to col main div.';
     printer::print_info($msg);
     printer::close_print_wrap1('techinfo');
     $this->show_close('Tech info');
	printer::close_print_wrap('Adjust default Vertical'); 
	$this->show_close('Adjust default Vertical Positioning');
		}
     
 //this will be combined with display_scroll     
function fadethis_scroll(){
	static $inc=20000;  $inc++;
      #this is for all posts including nested columns
     $display_arr=array('none','fadethis-slide-left','fadethis-slide-right','fadethis-slide-top','fadethis-slide-bottom','@media_force_off');
     $options=($this->is_column)?$this->col_options[$this->col_display_fadethis_animate_index]:$this->blog_options[$this->blog_display_fadethis_animate_index]; 
	$options=explode('@@',$options);
	$c_opts=count(explode(',',Cfg::Display_options));
     $repeats=4*$c_opts;
     $cb_data=($this->blog_type==='nested_column')?$this->col_dataCss:$this->dataCss;
     $this->show_more('Animated fadeThis');
     printer::print_wrap('display scroll');
     printer::print_info('Reversible Scrolling Animation from FadeThis@lwiesel <a href="https://github.com/lwiesel/jquery-fadethis" class="ekblue underline cursor" target="blank">see on github</a>');
	printer::print_tip('For use on default position static elements');
	for ($i=0;$i<$repeats; $i++){ 
		if (!array_key_exists($i,$options))$options[$i]=0;
		}
     $script='';
	$listen=false;//set to true if additional media query && ie absolute 
     for ($i=0; $i<4; $i++){
          $k=$i * $c_opts ;//
     if ($i>0){
          $this->show_more('Additional @Media Controlled');
          printer::print_wrap('Additional display');
          }
     $this->submit_button();
     //display_fade_px,display_fade_type,display_fade_mode,display_basis,display_speed';
     printer::print_tip('Use both maxwidth and minwidth for  multiple selected @media widths. Uses Jquery window.width.');
     $display_max=(is_numeric($options[$this->display_max_index+$k])&&$options[$this->display_max_index+$k]>0&&$options[$this->display_max_index+$k]<=4000)?$options[$this->display_max_index+$k]:'none';
     $display_min=(is_numeric($options[$this->display_min_index+$k])&&$options[$this->display_min_index+$k]>0&&$options[$this->display_min_index+$k]<=4000)?$options[$this->display_min_index+$k]:'none';
     $display_speed=(is_numeric($options[$this->display_speed_index+$k])&&$options[$this->display_speed_index+$k]>=.1&&$options[$this->display_speed_index+$k]<=3)?$options[$this->display_speed_index+$k]:'1';
     $display_reverse=($options[$this->display_reverse_index+$k]==='untrue')?false:true;
     $display_distance=(is_numeric($options[$this->display_distance_index+$k])&&$options[$this->display_distance_index+$k]>=0&&$options[$this->display_distance_index+$k]<=200)?$options[$this->display_distance_index+$k]:'50';
     $display_offset=(is_numeric($options[$this->display_offset_index+$k])&&$options[$this->display_offset_index+$k]>=-100&&$options[$this->display_offset_index+$k]<=1000)?$options[$this->display_offset_index+$k]:'0';
	$fade_choice=(!empty($options[$this->display_fade_choice_index+$k])&&in_array($options[$this->display_fade_choice_index+$k],$display_arr))?$options[$this->display_fade_choice_index+$k]:'none';
     $display_name=($this->is_column)?$this->col_name.'_col_options['.$this->col_display_fadethis_animate_index.']':$this->data.'_blog_options['.$this->blog_display_fadethis_animate_index.']';
     $max_name=$display_name.'['.($this->display_max_index+$k).']';
     $min_name=$display_name.'['.($this->display_min_index+$k).']';
     $speed_name=$display_name.'['.($this->display_speed_index+$k).']';
     $distance_name=$display_name.'['.($this->display_distance_index+$k).']';
     $reverse_name=$display_name.'['.($this->display_reverse_index+$k).']';
     $offset_name=$display_name.'['.($this->display_offset_index+$k).']';
     $choice_name=$display_name.'['.($this->display_fade_choice_index+$k).']';
	 $type=($this->blog_type==='nested_column')?'nested column':'post';
     $id=($this->blog_type==='nested_column')?$this->col_id:$this->blog_id;
     printer::print_wrap1('max @media');
     printer::alert('specify @media max-width option');
     $this->mod_spacing($max_name,$display_max,100,4000,1,'px','none');
     printer::close_print_wrap1('max @media');
     printer::print_wrap1('min @media',$this->column_lev_color);
     printer::alert('specify @media min-width option');
     $this->mod_spacing($min_name,$display_min,100,4000,1,'px','none');
     printer::close_print_wrap1('min @media');
     printer::print_wrap1('fade in or out display');
	printer::print_tip('For responsive resizing turning off active setting @media query use @media Force off instead of none');
     printer::alert('Choose Fade effect / None  / @media Force off');
     forms::form_dropdown($display_arr,'','','',$choice_name,$fade_choice,false,'maroon whitebackground left'); 
     printer::close_print_wrap1('fade in or out display'); 
     printer::print_wrap1('duration');
     printer::alert('Specify fade-in fade-out duration option in seconds');
     $this->mod_spacing($speed_name,$display_speed,.1,3,.1,'sec','none');
     printer::close_print_wrap1('duration');
     printer::print_wrap1('percent');
     printer::print_tip('Choose fade slide distance.  Use 0 to fade in place.  ');
     $this->mod_spacing($distance_name,$display_distance,0,200,1,'px'); 
     printer::close_print_wrap1('percent');
     printer::print_wrap1('offset');
     printer::print_tip('Choose offset. Shorter height elements work will with negative values whereas larger values work with greater height elements. Uses 0 by default.');
     $this->mod_spacing($offset_name,$display_offset,-100,1000,1,'px'); 
     $final_offset=( $display_offset < 0 )? abs($display_offset) : -$display_offset;
	printer::close_print_wrap1('offset');
     printer::print_wrap('reverse');
     $checked1=($display_reverse)?'checked="checked"':'';
     $checked2=(!$display_reverse)?'checked="checked"':'';
     printer::alert('<input type="radio" name="'.$reverse_name.'" value="true" '.$checked1.'>Reverse Fading Effect on Scroll up');
     printer::alert('<input type="radio" name="'.$reverse_name.'" value="untrue" '.$checked2.'>Turn Reverse Off');
     printer::close_print_wrap('reverse');
     $display_speed=$display_speed*1000;
     $reverse=($display_reverse)?',"reverse":true':',"reverse":false';
     $display_max=($display_max==='none')?10000 : $display_max;
     $display_min=($display_min==='none')?100 : $display_min;
     if ($fade_choice!=='none'){
		if ($i>0)$listen=true;
		$this->handle_script_edit('fadethis/jquery.fadethis.js','fadeThis_header_once','header_script_once');
$script.= <<<eol
     if (gen_Proc.vpw <= $display_max && gen_Proc.vpw >= $display_min){
			var baseName='fadethis-slide-';
		if (jQuery('.$cb_data').hasClass(baseName + "right")) {
				jQuery('.$cb_data').css("left",'auto');
			 } else if (jQuery('.$cb_data').hasClass(baseName + "left")) {
				jQuery('.$cb_data').css("right",'auto');
			 } else if (jQuery('.$cb_data').hasClass(baseName + "top")) {
				jQuery('.$cb_data').css("bottom",'auto');
			 } else if (jQuery('.$cb_data').hasClass(baseName + "bottom")) {
				jQuery('.$cb_data').css("top",'auto');
			 } 
           
		jQuery('.$cb_data').attr('class', function(i, c){
			return c.replace(/(^|\s)fadethis-slide-\S+/g, '');
			});
		jQuery('.$cb_data').addClass('$fade_choice');
		jQuery('.$cb_data').data('fadethis-id',jQuery('.$cb_data').attr('id'));//make post level compatible with class level fadeThis using fadethis-id
		if ('$fade_choice'!=='@media_force_off')
			jQuery('.$cb_data').fadeThis({"speed": $display_speed, "distance": $display_distance,"offset": $final_offset $reverse});
		else{
			jQuery('.$cb_data').fadeThis({"forceOff":true});
			}
		}//if media
		
eol;
              }
          if ($i>0){ 
               $this->submit_button();
               printer::close_print_wrap('Additional display');
               $this->show_close('Additional Media Controlled Choices');
               }
               
          }//for loop
     if (!empty($script)){
		
		$this->handle_script_edit("
		
		//fadeThis $type for .$cb_data 
			$script",'post_anim_scroll','script');
		if ($listen) {//we have multiple media query controled fadeThis and if window resizes we re-initate fadeThis according to current width
$resize_script= <<<eol
	
	
	//fadeThis  resize $type for .$cb_data";
	$script
	
eol;
			$this->handle_script_edit($resize_script,'post_anim_scroll','onresizescript');
			}
		}
      $this->submit_button();
      printer::close_print_wrap('display scroll');
      $this->show_close('Choose Display Scroll Visibility');
     }//end display  

function parallax_stellar(){
	static $n=0; $n++;
     if (!$this->edit)return;
     //this implementation of stellar.js is geared to affect elements in reponsive non-px required mode 
      //background_images also avail
      
     $scrollArr=array('scroll','position','margin','transform');
     $stellararr=array('max','min','stellaron','speed','offset','scrollProperty','horizScroll','vertScroll','responsive','scrollparent','para_back','para_elem','hide_elems','position');
     foreach($stellararr as $key =>$index){
		${$index.'_index'}=$key;
		}
     $options=($this->is_column)?$this->col_options[$this->col_parallax_stellar_index]:$this->blog_options[$this->blog_parallax_stellar_index]; 
	$options=explode('@@',$options);
	$c_opts=count($stellararr);
     $repeats=4*$c_opts;
     $this->show_more('Stellar Parallax');
     printer::print_wrap('parallax scroll');
     printer::print_info('Parallax Implementation of stellar.js @markdalgleish  <a href="https://github.com/markdalgleish/stellar.js/" class="underline ekblue cursor" target="_blank">Checkout Stellar Project on GitHub</a>');
     $this->show_more('Info on Responsive Implementation','','editbackground editcolor italic smaller underline');
     printer::print_wrap('parallax info');
     printer::print_tip(' Here is one way to easily add a  parallax effect responsively (without the recommend px units) using Stellar.js for parallaxElements. Parallax Background images are also enabled <br>Limited options thus far presented for easy implementation of non px required usages. The default options as set here are for :<br>positionProperty: transform  which keeps the initial visible elements as they appear naturally. <br>positionProperty: position will change the display state property prior to scrolling and top spacing of subsequent elements would need to be implemented.<br>
     Using stellar vertical offset for vertical effects was effectivey used to offset the initial in-view position of an absolute  positioned element. Additional tweaking of the px units used to offset may be necessary depending on the viewers view-port screen.<br>
     <br><br>
     By default a 500px view screen size is implemented as full mobile implementation has not been enabled here.');
     $cb_data=($this->is_column)?$this->col_dataCss:$this->dataCss;
     printer::close_print_wrap('parallax info');
     $this->show_close('Info on Responsive Implementation');
	for ($i=0;$i<$repeats; $i++){ 
		if (!array_key_exists($i,$options))$options[$i]=0;
		}
     $script='';
	$listen=false;
     for ($i=0; $i<4; $i++){
          $k=$i * $c_opts ;//
          if ($i>0){
               $this->show_more('Additional @Media Controlled');
               printer::print_wrap('Additional parallax');
               }
          $this->submit_button();
          printer::print_tip('Use both maxwidth and minwidth for  multiple selected @media widths. Uses Jquery window.width.');
          $max=(is_numeric($options[$max_index+$k])&&$options[$max_index+$k]>100&&$options[$max_index+$k]<=4000)?$options[$max_index+$k]:'none';
          $min=(is_numeric($options[$min_index+$k])&&$options[$min_index+$k]>=100&&$options[$min_index+$k]<=4000)?$options[$min_index+$k]:'none';
          $speed=(is_numeric($options[$speed_index+$k])&&$options[$speed_index+$k]>=.2&&$options[$speed_index+$k]<=2)?$options[$speed_index+$k]:1; 
          //full options shown not all used!
          $stellaron=($options[$stellaron_index+$k]==='stellar_on'||$options[$stellaron_index+$k]==='stellar_force_off')?$options[$stellaron_index+$k]:'stellar_off';  
          $hide_elems=($options[$hide_elems_index+$k]==='hide')?false:true;
          $para_elem=($options[$para_elem_index+$k]==='elemoff')?false:true;
          $para_back=($options[$para_back_index+$k]==='stellarbackon')?true:false;
          $position=($options[$para_back_index+$k]==='position')?'position':'transform';
          $vertScroll=($options[$vertScroll_index+$k]==='vertoff')?false:true;
          $responsive=($options[$responsive_index+$k]==='responsiveoff')?false:true;
          $horizScroll=($options[$horizScroll_index+$k]==='horiztrue')?true:false;
          //$scrollProperty=($options[$scrollProperty_index+$k]==='untrue')?false:true;
          $offset=(is_numeric($options[$offset_index+$k])&&$options[$offset_index+$k]>=-1000&&$options[$offset_index+$k]<=2000)?$options[$offset_index+$k]:0;
          $name=($this->is_column)?$this->col_name.'_col_options['.$this->col_parallax_stellar_index.']':$this->data.'_blog_options['.$this->blog_parallax_stellar_index.']';
          $max_name=$name.'['.($max_index+$k).']';
          $min_name=$name.'['.($min_index+$k).']';
          $hide_elems_name=$name.'['.($hide_elems_index+$k).']';
          $para_elem_name=$name.'['.($para_elem_index+$k).']';
          $speed_name=$name.'['.($speed_index+$k).']';
          
          $stellaron_name=$name.'['.($stellaron_index+$k).']';
          $para_back_name=$name.'['.($para_back_index+$k).']';
          $vertScroll_name=$name.'['.($vertScroll_index+$k).']';
          $responsive_name=$name.'['.($responsive_index+$k).']';
          $horizScroll_name=$name.'['.($horizScroll_index+$k).']';
          $offset_name=$name.'['.($offset_index+$k).']';
          $scrollProperty_name=$name.'['.($scrollProperty_index+$k).']';
          $type=($this->is_column)?'column':'post';
          $id=($this->is_column)?$this->col_id:$this->blog_id;
          printer::print_wrap1('enable para');
          $checked1=($stellaron==='stellar_on')?'checked="checked"':'';
          $checked3=($stellaron==='stellar_force_off')?'checked="checked"':'';
		$checked2=($stellaron!=='stellar_on'&&$stellaron!=='stellar_force_off')?'checked="checked"':'';
          printer::alert('<input type="radio" name="'.$stellaron_name.'" '.$checked1.' value="stellar_on" '.$checked1.'>Turn On Parallax');
          printer::alert('<input type="radio" name="'.$stellaron_name.'" '.$checked2.' value="stellar_off" '.$checked2.'>Off Parallax');
          printer::alert('<input type="radio" name="'.$stellaron_name.'" '.$checked3.' value="stellar_force_off" '.$checked3.'>Force Off Parallax at particlar @media width if turned on @ different width then resized.');
          printer::close_print_wrap1('off para');
          printer::print_wrap1('ele mode');
          $checked1=(!$para_back)?'checked="checked"':'';
          $checked2=($para_back)?'checked="checked"':'';
          printer::alert('<input type="radio" name="'.$para_back_name.'" '.$checked1.' value="stellarbackoff" '.$checked1.'>Use Element Mode');
          printer::alert('<input type="radio" name="'.$para_back_name.'" '.$checked2.' value="stellarbackon" '.$checked2.'>Use Background Mode');
          printer::close_print_wrap1('ele mode');
          printer::print_wrap1('speed');
          printer::alert('Scroll ratio: 2 means 2x scroll speed etc. ');
          $this->mod_spacing($speed_name,$speed,.2,2,.05,'&nbsp;ratio');
          printer::close_print_wrap1('speed');
          printer::print_wrap1('offset');
          printer::print_tip('Choose offset distance to correct for initial scroll distance of elemnt for correct in-view timing.  Uses 0 by default.');
		$this->mod_spacing($offset_name,$offset,-1000,2000,1,'px'); 
          printer::close_print_wrap1('offset');
          /*
		 * Currently using transform which won't interfere with positioned elements after they are forced off.  We can sue use custom css var to set inital css values positioned @mediaa width and then retrieved and implemented to get around this and allow positioned elements to be selected by so far no limitatins using transform property other than if initial transform values to element were required...
		 * 
           printer::print_wrap('position');
          $checked1=($position!=='position')?'checked="checked"':'';
          $checked2=(!$position==='position')?'checked="checked"':'';
          
          printer::alert('<input type="radio" name="'.$position_name.'" value="transform" '.$checked1.'>Use Transform property');
          printer::alert('<input type="radio" name="'.$position_name.'" value="position" '.$checked2.'>Use position property');
          
          printer::close_print_wrap('position');*/
		printer::print_wrap1('max @media');
          printer::alert('specify @media max-width option');
          $this->mod_spacing($max_name,$max,100,4000,1,'px','none');
          printer::close_print_wrap1('max @media');
          printer::print_wrap1('min @media',$this->column_lev_color);
          //printer::print_warnlight('By default min-width is set at 500px due to scrolling limits on mobile devices causing jitters');
          printer::alert('specify @media min-width option');
          $this->mod_spacing($min_name,$min,0,4000,1,'px','none');
          printer::close_print_wrap1('min @media');
          $max=($max==='none')?10000 : $max;
          $min=($min==='none')?100 : $min;
		//replace initial height if we select to force off stellar @media width following a resizing..
          if ($stellaron !=='stellar_off' && $i < 1){
			//$once="jQuery('body').attr('data-stellar-offset-parent','true');";//if activated it using body for offset parent else nearest relative or abs parent or body whichever closest..
			//$this->handle_script_edit($once,'initiate_script_once','initiate_script_once');          
			$once='
			
			//stellar parallax initialize function
			setTimeout(function(){
				jQuery(window).stellar({//using window have not gotten initiation by element to work which would be more advantageous 
					horizontalScrolling: false,
					horizontalOffset: 0,
					responsive:false,//timing 
					positionProperty: "transform",
					hideDistantElements: false
					});
				},25);//delay for more consistent ie abs positioning post over image ie images loading height involved.. ie alternatively  setting the image height in percent works but height might not respond correctly on resizing window
				';//
			$this->handle_script_edit($once,'stellar_initiate_script_once','initiate_script_once');
			$this->handle_script_edit('stellar/jquery.stellar.min.js','stellar_header_once','header_script_once');
               $msg = "//stellar.js  parallax Element   for $cb_data";
			$script.="
	
	$msg
	"; 
               } 
          $attr=($para_back)?'data-stellar-background-ratio':'data-stellar-ratio';
          $attr2=($para_back)?'stellar-background-ratio':'stellar-ratio';
          if ($stellaron==='stellar_on' ){
               $this->css.='
               .'.$cb_data.'.webmode{visibility:hidden;}';
			}
			
     if ($stellaron==='stellar_on'||$stellaron==='stellar_force_off'){  
			if ($i>0)	$listen=true;
$script.= <<<eol
          
     jQuery('.$cb_data').css('visibility','visible'); 
     if (gen_Proc.vpw <= $max && gen_Proc.vpw >= $min){ 
          var speed=$speed;
          var offset=$offset;  
          if ( '$stellaron' === 'stellar_on' ){ 
                jQuery('.$cb_data').attr('$attr',$speed);
			 
			 jQuery('.$cb_data').data({'stellar-vertical-offset':$offset,'$attr2':$speed});
			}
		else { 
			jQuery('.$cb_data').data('$attr2',null).removeAttr('$attr').css('transform','');
			} 
          }//if media
eol;
               }//if valid turnon selections          
                    
               if ($i>0){ 
                    $this->submit_button();
                    printer::close_print_wrap('Additional parallax');
                    $this->show_close('Additional Media Conrolled Choices');
                    }
          }//for loop
     if (!empty($script)){
		$this->handle_script_edit("$script",' parallax_gen_script','script');
		if ($listen){//make resize ready 
		 
$resize_script= <<<eol
	
	$script
eol;
			$this->handle_script_edit($resize_script,'settings_parallax','onresizescript');
			$resize_script= <<<eol

//stellar parallax refresh on resize
jQuery(window).data('plugin_stellar').refresh({
		horizontalScrolling: false,
		horizontalOffset: 0,
		responsive:false,
		positionProperty: "transform",
		hideDistantElements: false
		});		
eol;
			$this->handle_script_edit($resize_script,'settings_parallax_resize_once','onresizescriptonce'); 
			}//$listen=true;
		}//!empty script
	
	$this->submit_button();
      printer::close_print_wrap('parallax stellar');
      $this->show_close('Parallax stellar');
      }//end parallax
	 
function masonry(){ 
	$masonarr=array('mason','max','min');
	foreach($masonarr as $key =>$index){
		${$index.'_index'}=$key;
		}
	$options=$this->col_options[$this->col_enable_masonry_index]; 
	$options=explode('@@',$options);
	for ($i=0; $i < count($masonarr); $i++){
		if (!array_key_exists($i,$options)){
			$options[$i]=0;
			}
		}
	if (!$this->prime){
		$checked1=($options[$mason_index]!=='masonry')?'checked="checked"':'';
		$checked2=($options[$mason_index]==='masonry')?'checked="checked"':'';
		$this->show_more('Masonry Option');
		$this->print_redwrap('wrap masonry','maroon');
	if ($this->column_use_flex_array[$this->column_level])printer::print_warn('Note: Flex Box Container enabled and masonry assist currently overrides various Flex Box features.  ie. the two are not fully compatible.');
		$msg='Optionally enable Masonry to Assist in grid layout of Posts (including a nested column) directly within this column. Masonry will work in conjunction with your post width settings and alternative width settings. Post Float settings should be set to float left or float right. Float center may also be used but appropriate margin percents will need to be included as masonry otherwise overlooks the centering. Masonry will override Flex Box functionality';
		printer::print_tip($msg);
		$this->show_more('Style info','','info italic smaller');
		printer::print_wrap1('techinfo');
		$msg='Info: Masonry is a javascript open source Git Hub project by Desandro. When activated, the parent column recieves the class name of grid and the posts directly within this parent column receive the classname of grid-item. Both inline javascript and external file javascript then control the grid-like behavior of the child posts within the parent column. Masonry works in conjunction with width settings as outlined previously.'; 
		printer::print_info($msg);
		printer::close_print_wrap1('techinfo');
		$this->show_close('Style info');
		$name=$this->col_name.'_col_options['.$this->col_enable_masonry_index.']['.$mason_index.']';
		$max_name=$this->col_name.'_col_options['.$this->col_enable_masonry_index.']['.$max_index.']';
		$min_name=$this->col_name.'_col_options['.$this->col_enable_masonry_index.']['.$min_index.']';
		printer::print_tip('Masonry if enabled may change the order of your posts to get the best fit');
		printer::print_tip('The width of the first post in a masonry column will set the grid width for all other posts. Best results often using widest post in first position');
		printer::printx('<p><input type="radio" '.$checked1.' value="nomasonry" name="'.$name.'">No Masonry</p>');
		printer::printx('<p><input type="radio" '.$checked2.' value="masonry" name="'.$name.'">Enable Post Masonry Assist</p>');
		printer::print_wrap1('max @media');
		printer::print_tip('By default masonry if initiated above will work at all view screen widths, but you can optionally choose a @media width range to activate masonry here');
		printer::print_tip('Please note masonry will set its own right and left margins having  a minimum of about 20px whereas top and bottom margins are set in the post styles.');
		printer::alert('specify @media max-width option');
		$max=(is_numeric($options[$max_index])&&$options[$max_index]>0&&$options[$max_index]<=4000)?$options[$max_index]:10000;
		$min=(is_numeric($options[$min_index])&&$options[$min_index]>0&&$options[$min_index]<=4000)?$options[$min_index]:0;
		$this->mod_spacing($max_name,$max,100,4000,1,'px','none');
		printer::close_print_wrap1('max @media');
		printer::print_wrap1('min @media',$this->column_lev_color);
		printer::alert('specify @media min-width option');
		$this->mod_spacing($min_name,$min,100,4000,1,'px','none');
		printer::close_print_wrap1('min @media');
		$this->submit_button();
		$this->close_print_wrap('wrap masonry' );
		$this->show_close('Masonry Option');
		$masonryClass='gridcol_'.$this->col_id;
          $mclass=".$masonryClass";
		if ($options[$mason_index]==='masonry'){
			$this->css.="
		.$this->col_dataCss { opacity:0;}";
			$this->handle_script_edit('/masonry/masonry.js','masonry_header_once','header_script_once');
			$this->handle_script_edit('imagesLoaded/imagesLoaded.js','imagesLoaded_header_once','header_script_once');
			$script= <<<eol
if (gen_Proc.vpw <= $max && gen_Proc.vpw >= $min){			
	var mopts={
		gutter: 20,
		itemSelector: '.grid-item_$this->col_id' 
		}
	
	jQuery('.$this->col_dataCss').removeAttr('style');
     jQuery('.$this->col_dataCss').addClass('$masonryClass');
	$('$mclass').imagesLoaded().always( function( instance ) {
		setTimeout( function(){
			new Masonry( '$mclass', {
				mopts
				});
			jQuery('$mclass').masonry(mopts); //initiating twice
			
			}, 130);
		setTimeout( function(){
			jQuery('.$this->col_dataCss').css('opacity','1');
			}, 500);	
		});
	}
else { 
	jQuery('.$this->col_dataCss > .grid-item_$this->col_id').removeAttr('style');
	jQuery('.$this->col_dataCss').removeAttr('style');
     jQuery('.$this->col_dataCss').css('opacity','1');
	}
eol;
			$this->handle_script_edit("
				//masonry $masonryClass  $this->col_dataCss
				$script
				",'col_masonry_active','script');//
			$resize_script= <<<eol
	
	
	//masonry  resize col for $this->col_dataCss
	jQuery('.$this->col_dataCss').css({'opacity':'0',
	'visibility':'hidden'});
	$script
eol;
			$this->handle_script_edit($resize_script,'col_masonry_resize','onresizescript');
			}//masonry but not edit\
		}
	else{
		$this->show_more('Primary Column Masonry Info');
		printer::print_tip('Masonry enabling not available in Primary Column because the masonry enabling column needs to be wrapped itself by a column. Simply create a nested a column in the primary column and posts within will be masonry enabled when you enable the masonry option in the nested column. Any primary column can easily become a nested column by checking the box to create a new primary column under the add primary option, submit,  then choose to <b>move</b> the  old primary column entering its id. Thats it, you can then enable masonry mode in that column.'); 
		$this->show_close('Primary Column Masonry Info'); 
		}
	}//end masonry
		
function sticky_scroll(){
     if (!$this->edit)return;
     //this is an implementation of AndrewHenderson/jSticky
     $stickyarr=array('max','min','stickyon','offset','stopper','zIndex','stuck');
     foreach($stickyarr as $key =>$index){
		${$index.'_index'}=$key;
		}
     $options=($this->is_column)?$this->col_options[$this->col_sticky_index]:$this->blog_options[$this->blog_sticky_index]; 
	$options=explode('@@',$options);
	$c_opts=count($stickyarr);
     $repeats=4*$c_opts;
	$cb_data=($this->is_column)?$this->col_dataCss:$this->dataCss;
     $this->show_more('Position Sticky Scroll');
     printer::print_wrap('sticky scroll');
     printer::print_wrap('sticky info');
     printer::print_info('Implementation of AndrewHenderson <a class="cursor ekblue underline" target="_blank" href="https://github.com/AndrewHenderson/jSticky">see GitHub jSticky Project</a>');
     printer::print_tip('By default, this  element will Stick to the top of the viewport when scrolled to vertically.<br><br>Use Media Controlled Values to turn/off effect and taylor further options:
     ');
     printer::close_print_wrap('sticky info');
  for ($i=0;$i<$repeats; $i++){ 
		if (!array_key_exists($i,$options))$options[$i]=0;
		}
     $script='';
     for ($i=0; $i<2; $i++){
          $k=$i * $c_opts ;//
          if ($i>0){
               $this->show_more('Additional @Media Controlled');
               printer::print_wrap('Additional sticky');
               }
          $this->submit_button();
          printer::print_tip('Use both maxwidth and minwidth for  multiple selected @media widths. Uses Jquery window.width.');
          $max=(is_numeric($options[$max_index+$k])&&$options[$max_index+$k]>0&&$options[$max_index+$k]<=4000)?$options[$max_index+$k]:'none';
          $min=(is_numeric($options[$min_index+$k])&&$options[$min_index+$k]>0&&$options[$min_index+$k]<=4000)?$options[$min_index+$k]:'none';
           //full options shown not all used!
          $stickyon=($options[$stickyon_index+$k]==='stickyon')?true:false;
          $stopper=(!empty($options[$stopper_index+$k]))?$options[$stopper_index+$k]:false;
          $stuck=(!empty($options[$stuck_index+$k]))?$options[$stuck_index+$k]:false;
          $zIndex=(is_numeric($options[$zIndex_index+$k])&&$options[$zIndex_index+$k]>-1001&&$options[$zIndex_index+$k]<=5000)?$options[$zIndex_index+$k]:'100';
          $offset=(is_numeric($options[$offset_index+$k])&&$options[$offset_index+$k]>-100&&$options[$offset_index+$k]<=1000)?$options[$offset_index+$k]:0;
          $name=($this->is_column)?$this->col_name.'_col_options['.$this->col_sticky_index.']':$this->data.'_blog_options['.$this->blog_sticky_index.']';
          $max_name=$name.'['.($max_index+$k).']';
          $min_name=$name.'['.($min_index+$k).']';
          $zIndex_name=$name.'['.($zIndex_index+$k).']';
          $stopper_name=$name.'['.($stopper_index+$k).']';
          $stuck_name=$name.'['.($stuck_index+$k).']'; 
          $stickyon_name=$name.'['.($stickyon_index+$k).']';
          $offset_name=$name.'['.($offset_index+$k).']';
          $type=($this->is_column)?'column':'post';
          $id=($this->is_column)?$this->col_id:$this->blog_id;
          printer::print_wrap1('enable stick');
          $checked1=($stickyon)?'checked="checked"':'';
          $checked2=(!$stickyon)?'checked="checked"':'';
          printer::alert('<input type="radio" name="'.$stickyon_name.'" '.$checked1.' value="stickyon" '.$checked1.'>Turn On Sticky');
          printer::alert('<input type="radio" name="'.$stickyon_name.'" '.$checked2.' value="stickyoff" '.$checked2.'>Off Sticky');
          printer::close_print_wrap1('off stick');
          printer::print_wrap1('max @media');
          printer::alert('specify @media max-width option');
          $this->mod_spacing($max_name,$max,100,4000,1,'px','none');
          printer::close_print_wrap1('max @media');
          printer::print_wrap1('min @media',$this->column_lev_color);
          printer::alert('specify @media min-width option');
          $this->mod_spacing($min_name,$min,100,4000,1,'px','none');
          printer::close_print_wrap1('min @media');
          printer::print_wrap1('offset');
          printer::print_tip('Choose offset distance. For initial in-view elements with non-static positioning visible non-static elements Uses 0 by default.');
          $this->mod_spacing($offset_name,$offset,-100,1000,1,'px'); 
          printer::close_print_wrap1('offset');
          printer::print_wrap1('zIndex');
          printer::print_tip('Choose zIndex for when @pagetop. ');
          $this->mod_spacing($zIndex_name,$zIndex,-100,5000,5,'px'); 
          printer::close_print_wrap1('zIndex');
          printer::print_wrap1('stuck');
          $this->show_more('Info to Style the stuck @ pagetop element','','italic editcolor editbackground smaller');
          printer::print_wrap1('stuck2'); 
          printer::print_tip('To  customize the styling of this element differently when "stuck" @ the top the page optionally enter a classname beginning with a letter which will automaticaly be added to this element when fixed @ top of page. You can then set styles for  the classname using page/col custom classes. <b>Class name only. Begin with Letter ie. col1, ie do not use selector prefix (. or # )</b><br><br> To style the class added for all post types use its parent columns special class styling under setting (for nested columns be sure to use its parent column!). Alternatively use advanced styles and add classname to suffix. See video on advanced styles / or check out other videos such as creating a page from the ground up which show the tecnique.');
          printer::close_print_wrap1('stuck2');
          $this->show_close('Info for Stuck');
          printer::alert('<input type="text" name="'.$stuck_name.'" value="'.$stuck.'" size="15">Optionally Enter Class name for custom styling of stuck element @ pagetop'); 
          printer::close_print_wrap1('stuck');
          printer::print_wrap1('stopper'); 
          $this->show_more('Info to Unstuck the stuck @ pagetop element','','italic editcolor editbackground smaller');
          printer::print_wrap1('stopper2'); 
          printer::print_tip('There are two different choices for releasing and allowing scrolling of this element after it has been stuck to the top of this page.<br><br>1. Enter the id or class selector of a stopper element which is an element further down the page. When the stopper element approaches the page top this element will release and scroll out of view. <b>Use full selector for class or id ie. #customid  or .customclass</b><br><br>
2. Simply use a numeric value to indicate how far down the page to scroll before the elemnt is released in px.  ie: 400');
          printer::close_print_wrap1('stopper2');
          $this->show_close('Info for Stopper');
          printer::alert('<input type="text" name="'.$stopper_name.'" value="'.$stopper.'" size="15">Add stopper numeric px or classname/id selector if you wish re-enable scrolling of "stuck @ top" element when stopper element appears. '); 
          printer::close_print_wrap1('stopper');
         
          $max=($max==='none')?10000 : $max;
          $min=($min==='none')?100 : $min;
          if ($stickyon && $i < 1){
			$this->handle_script_edit('jsticky/jquery.jsticky.js','jsSticky_header_once','header_script_once');  
               $msg = "$type sticky Element on   for $cb_data";
               }
          else $msg='';
          if ($stickyon){
			$this->css.='
			.'.$cb_data.'{transition-property:static;}';//set default current transition-pproperty will change to aboslute if position property is set and jsticky will dynamically detect.  transtion property is being used as custom css property for position state detection
               echo "
               <!--$this->pagename.js  @ jSticky $cb_data-->";
     
               $script.= <<<eol
          
     //<!--jSticky  post $cb_data-->
     if (gen_Proc.vpw <= $max && gen_Proc.vpw >= $min){
         jQuery('.$cb_data').sticky({
               topSpacing: $offset, // Space between element and top of the viewport
               zIndex: $zIndex, // z-index
               stopper: "$stopper", // Id, class, or number value
               stickyClass: '$stuck' // Class applied to element when it's stuck
               });
          }//if media
eol;
               }//if valid speed and turnon selections          
                    
               if ($i>0){ 
                    $this->submit_button();
                    printer::close_print_wrap('Additional sticky');
                    $this->show_close('Additional Media Conrolled Choices');
                    }
          }//for loop
     if (!empty($script))$this->handle_script_edit($script,'sticky_sticky','script');
      $this->submit_button();
      printer::close_print_wrap('sticky sticky');
      $this->show_close('Parallax sticky');
      }//end sticky
      
      
function preanimation(){ 
	$max_duration=10;
	$max_delay=20;
	$max_repeat=15;
	$max_height=100;
	$max_width=3000;
	$min_width=200;
	$max_prior_delay=30;
	$default_animate_height=80;
	$max_animate_lock=4; 
	$id_ref=($this->is_column)?$this->col_dataCss:$this->dataCss;
	$animation_arr=explode(',',Cfg::Animation_types);
	$col_level=($this->is_column)?$this->column_level:$this->column_level;
	$options=($this->is_column)?$this->col_options[$this->col_animation_index]:$this->blog_options[$this->blog_animation_index];
    $options=explode('@@',$options);
	$c_opts=count(explode(',',Cfg::Animation_options));
	for ($i=0;$i<$c_opts; $i++){
		if (!array_key_exists($i,$options))$options[$i]=0;
		}
	$animate_type=(!empty($options[$this->animate_type_index])&&in_array($options[$this->animate_type_index],$animation_arr,true))?$options[$this->animate_type_index]:'none';  
	if ($animate_type==='none')return array('none','','','');
     echo "
     <!--$this->pagename.js expresedit @ animation script generated $id_ref-->
     ";
     $animate_height=($options[$this->animate_height_index]==='none'||(is_numeric($options[$this->animate_height_index])&&$options[$this->animate_height_index]>0&&$options[$this->animate_height_index]<=$max_height))?$options[$this->animate_height_index]:$default_animate_height; 
	$animate_duration=(is_numeric($options[$this->animate_duration_index])&&$options[$this->animate_duration_index]>=.05&&$options[$this->animate_duration_index]<=$max_duration)?$options[$this->animate_duration_index]:1; 
	$animate_width=(is_numeric($options[$this->animate_width_index])&&$options[$this->animate_width_index]>=$min_width&&$options[$this->animate_width_index]<=$max_width)?$options[$this->animate_width_index]:0;
	$animate_repeats=($options[$this->animate_repeats_index]==='infinite'||(is_numeric($options[$this->animate_repeats_index])&&($options[$this->animate_repeats_index]>0&&$options[$this->animate_repeats_index]<=$max_repeat)))?$options[$this->animate_repeats_index]:'1'; 
	$animate_after_type=(in_array($options[$this->animate_after_type_index],$animation_arr,true))?$options[$this->animate_after_type_index]:'none';
	$animate_after_delay=(is_numeric($options[$this->animate_after_delay_index])&&$options[$this->animate_after_delay_index]<$max_delay)?$options[$this->animate_after_delay_index]:1; 
	$animate_prior_delay=(is_numeric($options[$this->animate_prior_delay_index])&&$options[$this->animate_prior_delay_index]>=0&&$options[$this->animate_prior_delay_index]<=$max_prior_delay)?$options[$this->animate_prior_delay_index]:0; 
     $animate_after_duration=(is_numeric($options[$this->animate_after_duration_index])&&$options[$this->animate_after_duration_index]>=.1&&$options[$this->animate_after_duration_index]<=$max_duration)?$options[$this->animate_after_duration_index]:1;
	$animate_after_repeats=($options[$this->animate_after_repeats_index]==='infinite'||(is_numeric($options[$this->animate_after_repeats_index])&&($options[$this->animate_after_repeats_index]>0&&$options[$this->animate_after_repeats_index]<=$max_repeat)))?$options[$this->animate_after_repeats_index]:'1'; 
	$animate_lock=(is_numeric($options[$this->animate_lock_index])&&$options[$this->animate_lock_index]<=$max_animate_lock)?$options[$this->animate_lock_index]:0;
	$animate_final_display=($options[$this->animate_final_display_index]==='displaynone')?'displaynone':(($options[$this->animate_final_display_index]==='visibleoff')?'visibleoff':'visible');
	$animate_complete_id=(check_data::check_id($options[$this->animate_complete_id_index]))?$options[$this->animate_complete_id_index]:'';
	$animate_sibling=($options[$this->animate_sibling_index]==='prev'||$options[$this->animate_sibling_index]==='next'||$options[$this->animate_sibling_index]==='parent')?$options[$this->animate_sibling_index]:'inactive'; 	 
	$active_element_follow=(array_key_exists($animate_complete_id,$this->sibling_id_arr))?$this->sibling_id_arr[$animate_complete_id]:'';
     $inittotaldelay=(($animate_repeats*$animate_duration)+$animate_after_delay+$animate_prior_delay)*1000;
     $followupdelay=1000*$animate_after_duration*$animate_after_repeats;
	$fulltotaldelay=$followupdelay+$inittotaldelay;
      $script="
      
      //Post Animation $animate_type ExpressEdit @ danedan $id_ref;";
	
     #the following is not a follow up animation but a followup element when an element id is given  or prev sibling chosen and has completed for a subsequent element to start
	#followup animate is setup below
	#the mutational observer  determines when the initiating requirement of finishing a animation has completed by monitoring when the the attribute data-status=finish has been added to the element which when finished starts the animation of the current element. The mutational obsver futher adds the  class activ-anim to current posttype thus initiating the new animation. Affects those current elments which are dependend on sibling  parent or id completions 
	#animatefollow and animate finish both  controls the final visisbility or display setting and both add the data-status finish attributed
	#animatefollow and animatefinsh are controlled by total time calc
	#animatefollow controls the animate classes when a folowup animation type is being used.
	$aef=false; 
	if (!empty($active_element_follow)||$animate_sibling!=='inactive'){
		$aef=true;
          if (($animate_after_type!=='none'||$animate_lock>0)&&$animate_repeats!=='infinite'){//secondary animation  present
               $lock_timing=$animate_after_duration*$animate_after_repeats;
			$lock=($animate_lock>0)?'
				gen_Proc.animateLockReady(\''.$id_ref.'\',\''.$lock_timing.'\');':'';
			$java=($animate_after_type!=='none')?'
				gen_Proc.animateFollow(\''.$id_ref.'\',\''.$animate_type.'\',\''.$animate_after_type.'\','.$inittotaldelay.','.($followupdelay).',\''.$animate_final_display.'\');':'';
		}//end if animate type
	elseif ($animate_repeats!=='infinite'){//no secondary animation
		$java='
		 gen_Proc.animateFinish(\''.$id_ref.'\','.($inittotaldelay).',\''.$animate_final_display.'\');
		';
          $lock='';
          }//end if
	else {
          $lock=$java='';
          }
          if($animate_sibling==='prev'){
			$target='var obj_id=jQuery("#'.$id_ref.'").prevAll("div:first").attr("id");
			 var target=document.getElementById(obj_id);';
			}
		elseif($animate_sibling==='next'){
			$target='var obj_id=jQuery("#'.$id_ref.'").nextAll("div:first").attr("id");
			 var target=document.getElementById(obj_id);';
			}
		elseif($animate_sibling==='parent'){
			$target='var obj_id=jQuery("#'.$id_ref.'").parent("div:first").attr("id");
			 var target=document.getElementById(obj_id);';
			}
		else {
			 $target='var target = document.getElementById("'.$active_element_follow.'")';
			}
		$animateJava='
		'
		.$target.' 
		var observer = new MutationObserver(function(mutations) {
			mutations.forEach(function(mutation) {
			//target.getAttribute("data-status")  );
			if (mutation.attributeName==="data-status"){
			     jQuery("#'.$id_ref.'").addClass("active-anim");
                    '.$lock.'
                    '.$java.'
				observer.disconnect();
				}
			});
		}); 
	var config = { attributes: true }; 
	observer.observe(target, config);
		';
     $script.= '
          '.$animateJava.'
	    ';
	    }//end if
	//here we set up followup animation!!
	elseif (($animate_after_type!=='none'||$animate_lock>0)&&$animate_repeats!=='infinite'){//secondary animation  present
		$animateJava='
			jQuery("#'.$id_ref.'").one(animationStart,function(){';
			$lock_timing=$animate_after_duration*$animate_after_repeats;
			$java=($animate_lock>0)?'
				gen_Proc.animateLockReady(\''.$id_ref.'\',\''.$lock_timing.'\');':'';
			$afterJava=($animate_after_type!=='none')?'
				gen_Proc.animateFollow(\''.$id_ref.'\',\''.$animate_type.'\',\''.$animate_after_type.'\','.$inittotaldelay.','.($followupdelay).',\''.$animate_final_display.'\');':'';
		$closeJava='
			});
		';
	    $script.= '
         '.$animateJava.'
	    '.$java.'
	    '.$afterJava.'
	    '.$closeJava;
	    }//end if animate type
	elseif ($animate_repeats!=='infinite'){//no secondary animation
		$animateJava='
			jQuery("#'.$id_ref.'").one(animationStart,function(){  
			gen_Proc.animateFinish(\''.$id_ref.'\','.($inittotaldelay).',\''.$animate_final_display.'\');
			});
		';
	   $script.= '
         '.$animateJava;  
	    }//end if 
     if ($this->edit&&$animate_type!=='none'){
          $this->handle_script_edit($script,'animate_post','script');
          }  
	return array($animate_type,$animate_height,$animate_lock,$aef); 
	}//end preanimation


function animation_option(){
     echo '
     <option value="none">None</option>
          <option value="skewSubtle">skewSubtle</option>
         <optgroup label="Scale Effects">
	     <option value="hoverScale05">Hover Scale-05 (1.05x)</option>
	     <option value="hoverScale1">Hover Scale-1 (1.1x)</option>
	     <option value="hoverScale2">Hover Scale-2 (1.2x)</option>
	     <option value="hoverScale3">Hover Scale-3 (1.3x)</option>
	     <option value="hoverScale4">Hover Scale-4 (1.4x)</option>
	     <option value="hoverScale5">Hover Scale-5 (1.5x)</option>
	     <option value="transformScale3">Transform Scale-3 (.3x -> 1x)</option>
	     <option value="transformScale5">Transform Scale-5 (.5x -> 1x)</option>
	     <option value="transformScale7">Transform Scale-7 (.7x -> 1x)</option>
	     <option value="transformScale8">Transform Scale-8 (.8x -> 1x)</option>
	     <option value="transformScale9">Transform Scale-9 (.9x -> 1x)</option>
	     <option value="transformScale11">Transform Scale-11 (1.1x -> 1x)</option>
	     <option value="transformScale12">Transform Scale-12 (1.2x -> 1x)</option>
	     <option value="transformScale15">Transform Scale-15 (1.5x -> 1x)</option>
		</optgroup>
	   <optgroup label="Fading Entrances">
          <option value="fadeIn">fadeIn</option>
          <option value="fadeInDownSubtle">fadeInDownSubtle</option>
          <option value="fadeInDown">fadeInDown</option>
          <option value="fadeInDownBig">fadeInDownBig</option>
          <option value="fadeInLeft">fadeInLeft</option>
          <option value="fadeInLeftBig">fadeInLeftBig</option>
          <option value="fadeInRight">fadeInRight</option>
          <option value="fadeInRightBig">fadeInRightBig</option>
          <option value="fadeInUpSubtle">fadeInUpSubtle</option>
          <option value="fadeInUp">fadeInUp</option>
          <option value="fadeInUpBig">fadeInUpBig</option>
        </optgroup>

        <optgroup label="Fading Exits">
          <option value="fadeOut">fadeOut</option>
          <option value="fadeOutDownSubtle">fadeOutDownSubtle</option>
          <option value="fadeOutDown">fadeOutDown</option>
          <option value="fadeOutDownBig">fadeOutDownBig</option>
          <option value="fadeOutLeft">fadeOutLeft</option>
          <option value="fadeOutLeftBig">fadeOutLeftBig</option>
          <option value="fadeOutRight">fadeOutRight</option>
          <option value="fadeOutRightBig">fadeOutRightBig</option>
          <option value="fadeOutUpSubtle">fadeOutUpSubtle</option>
          <option value="fadeOutUp">fadeOutUp</option>
          <option value="fadeOutUpBig">fadeOutUpBig</option>
        </optgroup>
	   <optgroup label="Fading-Sliding Entrances with Scale">
		<option value="fadeInDownSubtleScale">fadeInDownSubtleScale</option>
		<option value="fadeInUpSubtleScale">fadeInUpSubtleScale</option>
		<option value="fadeInLeftSubtleScale">fadeInLeftSubtleScale</option>
		<option value="fadeInRightSubtleScale">fadeInRightSubtleScale</option>
	   </optgroup>
        <optgroup label="Sliding Entrances">
          <option value="slideInUpSubtle">slideInUpSubtle</option>
          <option value="slideInUp">slideInUp</option>
          <option value="slideInDownSubtle">slideInDownSubtle</option>
          <option value="slideInDown">slideInDown</option>
          <option value="slideInLeftSubtle">slideInLeftSubtle</option>
          <option value="slideInLeft">slideInLeft</option>
          <option value="slideInRightSubtle">slideInRightSubtle</option>
          <option value="slideInRight">slideInRight</option>
     </optgroup>
        <optgroup label="Sliding Exits">
          <option value="slideOutUp">slideOutUp</option>
          <option value="slideOutDown">slideOutDown</option>
          <option value="slideOutLeft">slideOutLeft</option>
          <option value="slideOutRight">slideOutRight</option>
          
        </optgroup>
     <optgroup label="Attention Seekers">
          <option value="bounce">bounce</option>
          <option value="flash">flash</option>
          <option value="pulse">pulse</option>
          <option value="rubberBand">rubberBand</option>
          <option value="shake">shake</option>
          <option value="swing">swing</option>
          <option value="tada">tada</option>
          <option value="wobble">wobble</option>
          <option value="jello">jello</option>
        </optgroup>

        <optgroup label="Bouncing Entrances">
          <option value="bounceIn">bounceIn</option>
          <option value="bounceInDown">bounceInDown</option>
          <option value="bounceInLeft">bounceInLeft</option>
          <option value="bounceInRight">bounceInRight</option>
          <option value="bounceInUp">bounceInUp</option>
        </optgroup>

        <optgroup label="Bouncing Exits">
          <option value="bounceOut">bounceOut</option>
          <option value="bounceOutDown">bounceOutDown</option>
          <option value="bounceOutLeft">bounceOutLeft</option>
          <option value="bounceOutRight">bounceOutRight</option>
          <option value="bounceOutUp">bounceOutUp</option>
        </optgroup>

        <optgroup label="Flippers">
          <option value="flip">flip</option>
          <option value="flipInX">flipInX</option>
          <option value="flipInY">flipInY</option>
          <option value="flipOutX">flipOutX</option>
          <option value="flipOutY">flipOutY</option>
        </optgroup>

        <optgroup label="Lightspeed">
          <option value="lightSpeedIn">lightSpeedIn</option>
          <option value="lightSpeedOut">lightSpeedOut</option>
        </optgroup>

        <optgroup label="Rotating Entrances">
          <option value="rotateIn">rotateIn</option>
          <option value="rotateInDownLeft">rotateInDownLeft</option>
          <option value="rotateInDownRight">rotateInDownRight</option>
          <option value="rotateInUpLeft">rotateInUpLeft</option>
          <option value="rotateInUpRight">rotateInUpRight</option>
        </optgroup>

        <optgroup label="Rotating Exits">
          <option value="rotateOut">rotateOut</option>
          <option value="rotateOutDownLeft">rotateOutDownLeft</option>
          <option value="rotateOutDownRight">rotateOutDownRight</option>
          <option value="rotateOutUpLeft">rotateOutUpLeft</option>
          <option value="rotateOutUpRight">rotateOutUpRight</option>
        </optgroup>

        </optgroup>
       
        
        <optgroup label="Zoom Entrances">
          <option value="zoomIn">zoomIn</option>
          <option value="zoomInDown">zoomInDown</option>
          <option value="zoomInLeft">zoomInLeft</option>
          <option value="zoomInRight">zoomInRight</option>
          <option value="zoomInUp">zoomInUp</option>
        </optgroup>
        
        <optgroup label="Zoom Exits">
          <option value="zoomOut">zoomOut</option>
          <option value="zoomOutDown">zoomOutDown</option>
          <option value="zoomOutLeft">zoomOutLeft</option>
          <option value="zoomOutRight">zoomOutRight</option>
          <option value="zoomOutUp">zoomOutUp</option>
        </optgroup>

        <optgroup label="Specials">
          <option value="hinge">hinge</option>
          <option value="jackInTheBox">jackInTheBox</option>
          <option value="rollIn">rollIn</option>
          <option value="rollOut">rollOut</option>
        </optgroup>';
        }//end funct
        
function animation(){ 
	$max_duration=10;
	$max_delay=20;
	$max_repeat=15;
	$max_height=100;
	$max_width=3000;
	$min_width=200;
	$max_prior_delay=30;
	$default_animate_height=80;
	$max_animate_lock=4;
	$msg='Configure Animation type and Optionally change default settings here!';
	$col_level=($this->is_column)?$this->column_level:$this->column_level;
	$anim_data=($this->is_column)?$this->col_dataCss:$this->dataCss;
	$anim_name=($this->is_column)?$this->col_name.'_col_options['.$this->col_animation_index.']':$this->data.'_blog_options['.$this->blog_animation_index.']';
	$type=($this->is_column)?'Column':'Post';
	$id_ref=($this->is_column)?$this->col_dataCss:$this->dataCss;
	$animation_arr=explode(',',Cfg::Animation_types); 
	$this->show_more($type.' Animations','','','',300);
	$this->print_redwrap('wrap animations',true);
     $this->submit_button();
	$options=($this->is_column)?$this->col_options[$this->col_animation_index]:$this->blog_options[$this->blog_animation_index]; 
	$options=explode('@@',$options);
	$c_opts=count(explode(',',Cfg::Animation_options));
	for ($i=0;$i<$c_opts; $i++){
		if (!array_key_exists($i,$options))$options[$i]=0;
		} 
	$animate_type=(in_array($options[$this->animate_type_index],$animation_arr,true))?$options[$this->animate_type_index]:'none';  
	$animate_visibility=($options[$this->animate_visibility_index]==='hidden')?'hidden':(($options[$this->animate_visibility_index]==='nodisplay')?'nodisplay':'visible');  
	$animate_sibling=($options[$this->animate_sibling_index]==='prev'||$options[$this->animate_sibling_index]==='next'||$options[$this->animate_sibling_index]==='parent')?$options[$this->animate_sibling_index]:'inactive'; 
	$animate_alternate=($options[$this->animate_alternate_index]==='alternate')?true:false;
	$animate_repeats=($options[$this->animate_repeats_index]==='infinite'||(is_numeric($options[$this->animate_repeats_index])&&($options[$this->animate_repeats_index]>0&&$options[$this->animate_repeats_index]<=$max_repeat)))?$options[$this->animate_repeats_index]:'1'; 
	$animate_duration=(is_numeric($options[$this->animate_duration_index])&&$options[$this->animate_duration_index]>=.05&&$options[$this->animate_duration_index]<=$max_duration)?$options[$this->animate_duration_index]:1; 
	$animate_prior_delay=(is_numeric($options[$this->animate_prior_delay_index])&&$options[$this->animate_prior_delay_index]>=0&&$options[$this->animate_prior_delay_index]<=$max_prior_delay)?$options[$this->animate_prior_delay_index]:0; 
	$animate_height=($options[$this->animate_height_index]==='none'||(is_numeric($options[$this->animate_height_index])&&$options[$this->animate_height_index]>0&&$options[$this->animate_height_index]<=$max_height))?$options[$this->animate_height_index]:$default_animate_height; 
	$animate_width=(is_numeric($options[$this->animate_width_index])&&$options[$this->animate_width_index]>=$min_width&&$options[$this->animate_width_index]<=$max_width)?$options[$this->animate_width_index]:'none';
	$animate_after_type=(in_array($options[$this->animate_after_type_index],$animation_arr,true))?$options[$this->animate_after_type_index]:'none';
	$animate_after_delay=(is_numeric($options[$this->animate_after_delay_index])&&$options[$this->animate_after_delay_index]<$max_delay)?$options[$this->animate_after_delay_index]:1;
	$animate_after_repeats=($options[$this->animate_after_repeats_index]==='infinite'||(is_numeric($options[$this->animate_after_repeats_index])&&($options[$this->animate_after_repeats_index]>0&&$options[$this->animate_after_repeats_index]<=$max_repeat)))?$options[$this->animate_after_repeats_index]:'1'; 
	$animate_after_duration=(is_numeric($options[$this->animate_after_duration_index])&&$options[$this->animate_after_duration_index]>=.1&&$options[$this->animate_after_duration_index]<=$max_duration)?$options[$this->animate_after_duration_index]:1;
	$animate_final_display=($options[$this->animate_final_display_index]==='displaynone')?'displaynone':(($options[$this->animate_final_display_index]==='visibleoff')?'visibleoff':'visible');
	$animate_lock=(is_numeric($options[$this->animate_lock_index])&&$options[$this->animate_lock_index]<=$max_animate_lock)?$options[$this->animate_lock_index]:0;
	$animate_complete_id=$options[$this->animate_complete_id_index];
	$active_element_follow=(array_key_exists($animate_complete_id,$this->sibling_id_arr))?$this->sibling_id_arr[$animate_complete_id]:''; 
	(!empty($animate_complete_id)&&empty($active_element_follow))&&printer::alert_neg("Animate Chosen Id to Activate this Animation does not refer to a previous post or column id :   $animate_complete_id  @ col level $col_level");
 	$inittotaldelay=(($animate_repeats*$animate_duration)+$animate_after_delay+$animate_prior_delay)*1000;
     $followupdelay=1000*$animate_after_duration*$animate_after_repeats;
	$fulltotaldelay=$followupdelay+$inittotaldelay;
     $css='';
     if ($animate_type!=='none'){
		if (!empty($animate_width)&&is_numeric($animate_width)) {#all goes within min-width specification
			$css.='
			@media screen and (min-width:'.$animate_width.'px){   
				';  
			}
		if ($animate_visibility ==='hidden'){
			$css.='
			.'.$id_ref.'{visibility:hidden;}
			.'.$id_ref.'.active-anim.in-view{visibility:visible;}
			'; 
			$this->editoverridecss.='
			html div#'.$id_ref.'{visibility:visible;}
			html div.'.$id_ref.' textarea{visibility:visible;} 
			';
			} 
		if ($animate_visibility ==='nodisplay'){
			$css.='
			.'.$id_ref.'{display:none;}
			.'.$id_ref.'.active-anim.in-view{display:'.$this->display_edit_data.';}
			';
			} 
		
		$alternate_css=($animate_alternate)?
		'-webkit-animation-direction: alternate;
			animation-direction: alternate;':'';
		$animate_repeats=($animate_alternate)?$animate_repeats*2:$animate_repeats;	
		$css.='
		#'.$id_ref.'.in-view.active-anim{
		 -webkit-animation-name: '.$animate_type.';
		animation-name: '.$animate_type.'; 
		animation-duration: '.$animate_duration.'s;
		-webkit-animation-duration: '.$animate_duration.'s;
		-moz-animation-duration:'.$animate_duration.'s;
		animation-iteration-count: '.$animate_repeats.';
		-webkit-animation-iteration-count: '.$animate_repeats.';
		-moz-animation-iteration-count: '.$animate_repeats.';
		-webkit-animation-delay: '.$animate_prior_delay.'s;
		-moz-animation-delay: '.$animate_prior_delay.'s;
		animation-delay: '.$animate_prior_delay.'s;
		'.$alternate_css.'
		}
		';
           
     
          if ($animate_after_type!=='none'){
               $css.='
		#'.$id_ref.'.'.$animate_after_type.'.in-view.active-anim {
		 -webkit-animation-name: '.$animate_after_type.';
		animation-name: '.$animate_after_type.';
		animation-duration: '.$animate_after_duration.'s;
		-webkit-animation-duration: '.$animate_after_duration.'s;
		-moz-animation-duration:'.$animate_after_duration.'s;
		animation-iteration-count: '.$animate_after_repeats.';
		-webkit-animation-iteration-count: '.$animate_after_repeats.';
		-moz-animation-iteration-count: '.$animate_after_repeats.';
		}
		';//visibility:visible;
			}//endif animate_after_type
		if ($animate_final_display==='visibleoff'){
               $css.='
		#'.$id_ref.'.fadeOut.in-view.active-anim {
	-webkit-animation-name: fadeOut;
	animation-name: fadeOut;
	animation-duration: 1s;
	-webkit-animation-duration: 1s;
	-moz-animation-duration:1s;
	}
	';
               }//endif animate_after_type
		if (!empty($animate_width)&&is_numeric($animate_width)) {
			$css.='
			}';//close bracket for @media css
			}
		}//if animate_type !==none the whole deal
     for ($i=1; $i <4; $i++){//animation_max3,animation_min3,animation_type3
          ${'animate_visibility'.$i}=($options[$this->{'animate_visibility'.$i.'_index'}]==='hidden')?'hidden':(($options[$this->{'animate_visibility'.$i.'_index'}]==='nodisplay')?'nodisplay':'visible'); 
          ${'animate_type'.$i}=(in_array($options[$this->{'animate_type'.$i.'_index'}],$animation_arr,true))?$options[$this->{'animate_type'.$i.'_index'}]:'none';
          ${'animate_max'.$i}=(is_numeric($options[$this->{'animate_max'.$i.'_index'}])&&$options[$this->{'animate_max'.$i.'_index'}]>=$min_width&&$options[$this->{'animate_max'.$i.'_index'}]<=$max_width)?$options[$this->{'animate_max'.$i.'_index'}]:'none';
          ${'animate_min'.$i}=(is_numeric($options[$this->{'animate_min'.$i.'_index'}])&&$options[$this->{'animate_min'.$i.'_index'}]>=$min_width&&$options[$this->{'animate_min'.$i.'_index'}]<=$max_width)?$options[$this->{'animate_min'.$i.'_index'}]:'none';
          if ($animate_type!=='none'&&${'animate_type'.$i}!=='none'){ 
               if (${'animate_max'.$i} !=='none'||${'animate_min'.$i} !=='none'){
                    $max=(${'animate_max'.$i} !=='none')?' and (max-width:'.${'animate_max'.$i}.'px)':'';
                    if (${'animate_max'.$i} !=='none'||${'animate_min'.$i} !=='none'){
                         $min=(${'animate_min'.$i} !=='none')?' and (min-width:'.${'animate_min'.$i}.'px)':'';
                    $addcss='';
                         if (${'animate_visibility'.$i} ==='hidden'){
                              $addcss.='
                              #'.$id_ref.'{visibility:hidden;}
                              #'.$id_ref.'.active-anim.in-view{visibility:visible;}
                              '; 
                              $this->editoverridecss.='
                              html div#'.$id_ref.'{visibility:visible!important;}
                              html div#'.$id_ref.' textarea{visibility:visible!important;} 
                              ';  
                              } 
                         if (${'animate_visibility'.$i} ==='nodisplay'){
                              $addcss.='
                              #'.$id_ref.'{display:none;}
                              .'.$id_ref.'.active-anim.in-view{display:'.$this->display_edit_data.';}
                              ';
                              } //if no display
                    $css.=' 
@media screen '.$max.$min.'{  
		#'.$id_ref.'.in-view.active-anim{
		 -webkit-animation-name: '.${'animate_type'.$i}.';
		animation-name: '.${'animate_type'.$i}.';}
          '.$addcss.'
               }';
                         }//if
                    }//if
               }//if
          }//end for
     $this->show_more('Style info','','info italic smaller');
     printer::print_wrap1('techinfo');
     printer::print_info('Current setting Css: '.$css); 
     $this->css.=$css;
     $msg='Curent Css shown here is specific for main div id '.$id_ref.'. The general animation css in the animate.css file is adapted from the daneden git hub open source project.';
     printer::print_info($msg);
     printer::close_print_wrap1('techinfo');
     $this->show_close('Style info');
	$this->show_more('Control Initial visibility');	
	$this->print_redwrap('anim visibility'); 
	$checked1=($animate_visibility==='hidden')? 'checked="checked"':'';
	$checked2=($animate_visibility==='nodisplay')?'checked="checked"':'';
	$checked3=($animate_visibility!=='hidden'&&$animate_visibility!=='nodisplay')?'checked="checked"':''; 
	printer::print_tip('Initial visibility is naturally set at visible prior to animation start. For fading in and other types it may be advantageous to insure an initial visibility to hidden which hides visibilty but the original space remains until animation opacity css fadeIn is activated. Alternatively choose to display none which hides the element and removes its space until activated for animation<br>');
	printer::alert('<p class="editbackground editfont highlight" title="Set initial visibility to hidden to insure that the '.$type.' is hidden prior to scroll activation of animation;uses css (visibily:hidden) property"><input type="radio" '.$checked1.' name="'.$anim_name.'['.$this->animate_visibility_index.']" value="hidden">Insure Non visibility of Initial State<p>');
     printer::print_warn('No Display will not effect flex-item use non visible instead');
	printer::alertx('<p class="editbackground editfont highlight" title="Set '.$type.' initial display to display:none;"><input type="radio"  name="'.$anim_name.'['.$this->animate_visibility_index.']" value="nodisplay" '.$checked2.'>Use No Display No space State. <p>');
	printer::alertx('<p class="editbackground editfont highlight" title="No display change"><input type="radio"  name="'.$anim_name.'['.$this->animate_visibility_index.']" value="visible" '.$checked3.'>Use Normal Visible Display State<p>');	 
	printer::pclear(5); 
	printer::close_print_wrap('anim visibility');
	$this->show_close('Control Initial visibility');	
	##################################
	$this->show_more('Enable '.$type.' Animation','','',' ','800');
	$this->print_redwrap('inital wrap animate ',true);
     printer::print_info('Animation effects utilize Danedan animate.css  colection:<a class="cursor underline" target="_blank" href="https://daneden.github.io/animate.css/"> see Project on GitHub</a>');
     printer::print_tip('Use animation effects as simple animations, or add in followup animations, and/or chain link animation series');
	printer::print_wrap('animate type','editbackground editfont Os3salmon fsmaqua');
	printer::print_tip('Choose an Initial Animation Type Here  and optional media query controlled initial animation types. See below to optionally choose a follow-up animation type');
	printer::alert('Select animation type here:');
	echo '
	<!--animate.css -http://daneden.me/animate-->
	<select class="editcolor editbackground editfont" name="'.$anim_name.'['.$this->animate_type_index.']">
		<option value="'.$animate_type.'" selected="selected">'.$animate_type.'</option>';
	$this->animation_option();	
      echo '</select>';
      $this->close_print_wrap('animate type');
      $this->show_more('Add upto 3 @media query Animation Tweaks');
      printer::print_wrap('additional animate type','editbackground editfont Os3salmon fsmaqua');
	printer::print_tip('Choose up to 3 media query controlled max/min  to change the Animation Types here.');
     
     for ($i=1; $i<4; $i++){
          printer::print_wrap('for loop animate type');
          printer::print_tip('Set #'.$i);
          printer::print_wrap1('for loop maxwidth');
          printer::alert('@media max-width');
          $this->mod_spacing($anim_name.'['.$this->{'animate_max'.$i.'_index'}.']',${'animate_max'.$i},$min_width,$max_width,1,'px','none');
	     
          printer::close_print_wrap1('for loop maxwidth');
          printer::print_wrap1('for loop minwidth');
          printer::alert('@media min-width');
          $this->mod_spacing($anim_name.'['.$this->{'animate_min'.$i.'_index'}.']',${'animate_min'.$i},$min_width,$max_width,1,'px','none');
	 
          printer::close_print_wrap1('for loop minwidth');
          printer::pclear(5);
          printer::print_wrap('anim visibility'); 
          $checked1=(${'animate_visibility'.$i}==='hidden')? 'checked="checked"':'';
          $checked2=(${'animate_visibility'.$i}==='nodisplay')?'checked="checked"':'';
          $checked3=(${'animate_visibility'.$i}!=='hidden'&&${'animate_visibility'.$i}!=='nodisplay')?'checked="checked"':''; 
          printer::print_tip('If media query is selected for additional animation types then also chose initial display state again.');  
	##############33
	printer::alert('<p class="editbackground editfont highlight" title="Set initial visibility to hidden to insure that the '.$type.' is hidden prior to scroll activation of animation;uses css (visibily:hidden) property"><input type="radio" '.$checked1.' name="'.$anim_name.'['.$this->{'animate_visibility'.$i.'_index'}.']" value="hidden">Insure Non visibility of Initial State<p>');
     printer::print_warn('No Display will not effect flex-item use non visible instead');
	printer::alertx('<p class="editbackground editfont highlight" title="Set '.$type.' initial display to display:none;"><input type="radio"  name="'.$anim_name.'['.$this->{'animate_visibility'.$i.'_index'}.']" value="nodisplay" '.$checked2.'>Use No Display No space State<p>');
	printer::alertx('<p class="editbackground editfont highlight" title="No display change"><input type="radio"  name="'.$anim_name.'['.$this->{'animate_visibility'.$i.'_index'}.']" value="visible" '.$checked3.'>Use Normal Visible Display State<p>');
      
          printer::pclear(5); 
          printer::close_print_wrap('anim visibility'); 
          printer::print_wrap1('for loop type');
          printer::alert('Select animation type here:');
          echo '
          <!--animate.css -http://daneden.me/animate-->
          <select class="editcolor editbackground editfont" name="'.$anim_name.'['.$this->{'animate_type'.$i.'_index'}.']">
               <option value="'.${'animate_type'.$i}.'" selected="selected">'.${'animate_type'.$i}.'</option>';
          $this->animation_option();	
           echo '</select>';
          printer::close_print_wrap1('for loop type');
           printer::close_print_wrap('for loop animate type');
          }//end for loop
	 printer::close_print_wrap('additional animate type');
      $this->show_close('@media query tweak Animation Type');
	/*
	 animate_type_index
	 animate_visibility_index
	 animate_repeats_index
	 animate_duration_index
	 animate_height_index 
	 animate_width_index
	 animate_mobile_off_index
	 animate_after_type_index
	 animate_after_delay_index
	 animate_after_repeats_index
	 animate_after_duration_index
	 animate_final_display_index 
	 name="'.$anim_name.'['.$this->animate_type_index.']
	 */ 
	printer::pclear(5);
	##############
	$this->print_wrap('anim alternate','editbackground editfont Os3salmon fsmaqua'); 
	$checked1=($animate_alternate==='alternate')? 'checked="checked"':'';
	$checked2=($animate_alternate==='alternate')?'':'checked="checked"';
	printer::print_tip('Choose to alternate reverse an animation here (animate:alternate). The animation will go forward then immediately reverse for each iteration. if chosen the animate repeats setting will automatically be doubled to account for the reverse cycle.  Note: the reverse animations will not pause between the alternating animations. For example, to fade-in an animation pause three seconds and fade-out, follow a fade-in animation with the enable followup option to fade-out animation choice and choose a followup delay option of 3 seconds');
	printer::alert('<p class="editbackground editfont editcolor"><input type="radio" '.$checked1.' name="'.$anim_name.'['.$this->animate_alternate_index.']" value="alternate">Reverse repeat this animation<p>');
	printer::alertx('<p class="editbackground editfont editcolor" title="Set '.$type.' initial alternate to visible"><input type="radio"  name="'.$anim_name.'['.$this->animate_alternate_index.']" value="0" '.$checked2.'>No Reversing<p>');	 	
	printer::pclear(5);
	printer::close_print_wrap('anim alternate');
     ####################################-animate_complete_id
	$this->print_wrap('anim complete_id','editbackground editfont Os3salmon fsmaqua');
	 
	printer::print_warn('When using id or sibling activation for  series of animations be sure to remove the in view activation option below choosing the none option for uniterrupted animation flow of each animation in the series.<br><input type="checkbox" value="none" name="'.$anim_name.'['.$this->animate_height_index.']">Turn off any in view requirement for this post');
     printer::print_tip('Delay this animation until another animation completes and this one is within the scrolling parameter you specified. Enter the id ie. p## for the animated post or c## for animated column that you wish to complete before this animation begins. Set to 0 remove this option');
	printer::alert('Enter the id of the animated post or column you wish to complete before this animation starts:<input type="text" value="'.$animate_complete_id.'" name="'.$anim_name.'['.$this->animate_complete_id_index.']">');
	printer::print_tip('Alternatively, you can check the options for using previous post or next post (previous sibling or next sibling) or the Parent Column option and this animation will initiate based on the animation you checked finishing.  These options will override the ID options. <br>Note that your chosen method must have an animation itself chosen afterwhich this particlar animation will commence');
	$checked1=($animate_sibling==='prev')? 'checked="checked"':'';
	$checked2=($animate_sibling==='next')? 'checked="checked"':'';
	$checked3=($animate_sibling==='parent')? 'checked="checked"':'';
	$checked4=($animate_sibling!=='prev'&&$animate_sibling!=='next'&&$animate_sibling!=='parent')?'checked="checked"':'';  
     printer::alert('<p class="editbackground editfont info" ><input type="radio" '.$checked1.' name="'.$anim_name.'['.$this->animate_sibling_index.']" value="prev">Use Previous Sibling (animation completing) for activation this Animation<p>');
	printer::alert('<p class="editbackground editfont info" ><input type="radio" '.$checked2.' name="'.$anim_name.'['.$this->animate_sibling_index.']" value="next">Use Next Sibling (animation completing) for activation this Animation<p>');
	printer::alert('<p class="editbackground editfont info" ><input type="radio" '.$checked3.' name="'.$anim_name.'['.$this->animate_sibling_index.']" value="parent">Use Parent Column (animation completing) for Activation of this Animation<p>');
	printer::alertx('<p class="editbackground editfont info"><input type="radio"  name="'.$anim_name.'['.$this->animate_sibling_index.']" value="inactive" '.$checked4.'>Turn Off Sibling/Parent Activation of this Animation<p>');	 	
	printer::close_print_wrap('anim complete_id'); 
     printer::pclear(5);	
	####################################-
	$this->print_wrap('anim height','editbackground editfont Os3salmon fsmaqua'); 
	printer::print_tip('Scrolling to the animation will trigger the start of the animation. Use none to turn off this feature.  However you can exactly set how far into the animation space the trigger will kick off (if a sibling,parent,or id triger is also chosen both triggers must be true).. Setting a value of 1% will enable the height trigger just as the top of the animation element is scrolled to. Setting a value of none will set the height trigger immediately. Choosing a value of 100% for example sets the height trigger only when the scroll reaches the bottom of the element. The value is currently set to '.$animate_height.'%.'); 
	printer::alert('Change In-View Requirement element px depth for animation trigger:');
     $this->mod_spacing($anim_name.'['.$this->animate_height_index.']',$animate_height,1,$max_height,1,'%','none');
	printer::close_print_wrap('anim height'); 
     printer::pclear(5);
     ####################################-animate_complete_id
	$this->print_wrap('anim repeats','editbackground editfont Os3salmon fsmaqua'); 
	printer::print_tip('By default animations repeat once. You can change the default behavior here from 1 to 10 or infinite repeat! <br>');
	printer::alert('Select animation repeats here:');
	echo '
	<select class="editcolor editbackground editfont" name="'.$anim_name.'['.$this->animate_repeats_index.']">
	<option value="'.$animate_repeats.'" selected="selected">'.$animate_repeats.'</option>';
		for ($i=1; $i<$max_repeat+1; $i++ ){
			echo '<option value="'.$i.'">'.$i.'</option>';
			}
          echo'
          <option value="infinite">infinite</option>
		</select>'; 		 	 
	printer::close_print_wrap('anim repeats'); 	
	printer::pclear(5);
	$this->print_wrap('anim prior_delay','editbackground editfont Os3salmon fsmaqua'); 
	printer::print_tip('By default animation prior_delay is 0 second. Meaning once activated by scrolling/etc it will begin immediately<br>');
	printer::alert('Add initial startoff animation delay:');
	$this->mod_spacing($anim_name.'['.$this->animate_prior_delay_index.']',$animate_prior_delay,0,$max_prior_delay,.01,'sec');
	printer::close_print_wrap('anim prior_delay'); 	
	printer::pclear(5); 
	##################################
	$this->print_wrap('anim duration','editbackground editfont Os3salmon fsmaqua'); 
	printer::print_tip('By default animation duration is 1 second. <br>');
	printer::alert('Change initial animation speed:');
	$this->mod_spacing($anim_name.'['.$this->animate_duration_index.']',$animate_duration,.05,$max_duration,.05,'sec');
	printer::close_print_wrap('anim duration'); 	
	printer::pclear(5);
	##################################
	$this->print_wrap('anim width','editbackground editfont Os3salmon fsmaqua'); 
	printer::print_tip('You can set a minimum width for animating this '.$type.'. Smaller widths will display it non-animated and larger widths will animate normally.  To disappear the animation at smaller/larger widths choose the RWD display Off option in the configs and choose the width there.');
	printer::alert('Optionally Set a minimum width requiremnt to enable the chosen animation for this '.$type.'. For example by setting a width of 500px, viewports of less than 500px will not animate this '.$type.'. Choose none to remove any width requirement for animation.');
	$this->mod_spacing($anim_name.'['.$this->animate_width_index.']',$animate_width,$min_width,$max_width,1,'px','none');
	printer::close_print_wrap('anim width');
	printer::pclear(5);
	############################################ 
	$this->print_wrap('anim lock','editbackground editfont Os3salmon fsmaqua'); 
	 printer::print_tip('Disable scroling is an <b>experimental</b> feature in which you can temporarily disable scrolling past the bottom of an animation by enabling a maximum time for a scroll delay of up to '.$max_animate_lock.' seconds. Scrolling will be released following the max time set or the end of the initial animation which ever is shorter.');
	printer::alert('Disable scrolling Timeout:');
	$this->mod_spacing($anim_name.'['.$this->animate_lock_index.']',$animate_lock,0,$max_animate_lock,.2,'sec');
	printer::close_print_wrap('anim lock');  
	printer::pclear(5);
	$this->submit_button();	
	printer::pclear(5); 
	printer::close_print_wrap('inital wrap animate');
	$this->show_close('Enable '.$type.' Initial Animation');
	printer::pclear(5);
	##################################
	$this->show_more('Pause Delay to Follup Animation');
	$this->print_redwrap('animate_after_delay','editbackground editfont Os3salmon fsmaqua'); 
	printer::print_tip('Choose a delay after the initial animation if you wish to disappear it or followup with another animation on this same '.$type.'. This means after the initial animination finishes animating, the number of seconds till the followup animation or disappear starts<br>');
	printer::alert('Change animation delay after the initial animation completes:');
	$this->mod_spacing($anim_name.'['.$this->animate_after_delay_index.']',$animate_after_delay,0,$max_delay,.1,'sec');
	printer::close_print_wrap('anim duration'); 
	$this->show_close('Pause Delay to Follup Animation');	
	printer::pclear(5);
	######################################################
	$this->show_more('Enable '.$type.' Follup Animation','','','The followup animation runs following the final completion of the inital animation follow any delay selected below','800');
	$this->print_redwrap('anim after','editbackground editfont fsminfo 0s3darkgray');	
	$this->print_wrap('animate after_type','editbackground editfont Os3salmon fsmaqua');
	printer::print_tip('Choose a Follow Up Animation Type Here for this '.$type.'. Will run after the initial animation ends following any after delay set for the intital animation.  An initial Animation need be chosen above');
	printer::alert('Select a  followup animation type here:');
	echo '
	<!--animate.css -http://daneden.me/animate-->
	<select class="editcolor editbackground editfont" name="'.$anim_name.'['.$this->animate_after_type_index.']">
		<option value="'.$animate_after_type.'" selected="selected">'.$animate_after_type.'</option>';
	$this->animation_option();
      echo '</select>';
	 printer::close_print_wrap('animate after_type');
	printer::pclear(5);
	############## 
	$this->print_wrap('anim after_repeats','editbackground editfont Os3salmon fsmaqua'); 
	printer::print_tip('By default animations repeat once. You can change the default behavior of the followup animation effect here from 1 to 10 or infinite repeat! <br>');
	printer::alert('Select animation repeats here:');
	echo '
	<select class="editcolor editbackground editfont" name="'.$anim_name.'['.$this->animate_after_repeats_index.']">
	<option value="'.$animate_after_repeats.'" selected="selected">'.$animate_after_repeats.'</option>';
		for ($i=1; $i<$max_repeat+1; $i++ ){
			echo '<option value="'.$i.'">'.$i.'</option>';
			}
          echo'
          <option value="infinite">infinite</option>
		</select>'; 		 	 
	printer::close_print_wrap('animate_after_delay'); 	
	printer::pclear(5);
	##################################
	$this->print_wrap('anim after_duration','editbackground editfont Os3salmon fsmaqua');
	printer::print_tip('By default animation duration is 1 second. <br>');
	printer::alert('Change followup animation speed:');
	$this->mod_spacing($anim_name.'['.$this->animate_after_duration_index.']',$animate_after_duration,.1,$max_duration,.1,'sec');
	printer::close_print_wrap('anim after_duration'); 	
	printer::pclear(5);
	$this->submit_button();	
	printer::pclear(5);
	printer::close_print_wrap('anim after');	
	printer::pclear(5);
	$this->show_close('Enable '.$type.' Follup Animation'); 
	####################################-####################################-
	$this->show_more('Final Visibility');
	$this->print_redwrap('anim final display','editbackground editfont Os3salmon fsmaqua'); 
	$checked1=($animate_final_display==='displaynone')? 'checked="checked"':'';
	$checked2=($animate_final_display==='visibleoff')? 'checked="checked"':'';
	$checked3=($animate_final_display!=='displaynone'&&$animate_final_display!=='visibleoff')?'checked="checked"':'';
	printer::print_tip('Optionally Choose your final display state here. You may wish your animation to fadeOut after its display and whether to retain the empty space or remove it. And Even animation choices that already fade out will still occupy their original space but you can choose to remove the occupied space for any animation by selecting the display none property here.');
	printer::alert('<p class="editbackground editfont info" ><input type="radio" '.$checked1.' name="'.$anim_name.'['.$this->animate_final_display_index.']" value="displaynone">Set Display None-No Space After animation(s) complete<p>');
     printer::pclear(6);
	printer::alert('<p class="editbackground editfont info" ><input type="radio" '.$checked2.' name="'.$anim_name.'['.$this->animate_final_display_index.']" value="visibleoff">Set Visibilty None- Space will be Occupied After animation(s) complete. <span class="caution smallest">(its use with fade-out type animations will cause double fadeout)</span><p>');
     printer::pclear(6);
	printer::alertx('<p class="editbackground editfont info" ><input type="radio"  name="'.$anim_name.'['.$this->animate_final_display_index.']" value="visible" '.$checked3.'>Display No Change<p>');	 	 
	printer::close_print_wrap('anim final_display');
	printer::pclear(5);
	$this->show_close('Final Visibility');
	printer::close_print_wrap('wrap  _animations');
	$this->show_close('animations'); 
	}//end func animation


#handlecss #css 
function handle_css_edit($key,$value='',$type='css'){ 
	if (!array_key_exists($key,$this->css_page_array))$this->css_page_array[$key]=array();
	
	if  ($value==='cssgen'){ //individual to post/col/page
		$this->css_page_array[$key][]=array('css',$this->css); 
		$this->css='';
		}
	elseif ($type==='css'){ 
		if (strlen($this->mediacss)>50)
			$this->css_page_array[$key][]=array('css',"/* $key has scaling media css rules in  currentpage *_media.css */");
		 $this->css_page_array[$key][]=array('css',$this->css);
		$this->css_page_array[$key][]=array('mediacss',$this->mediacss);
		
		$this->css_page_array[$key][]=array('editoverridecss',$this->editoverridecss);
		$this->editoverridecss=$this->css=$this->mediacss='';
		}
	else { 
		$this->css_page_array[$this->key][]=array($type,$value);
		}
	}


function handle_script_edit($script,$subkey,$arrType){
     if (!$this->edit||(!$this->col_primary&&!$this->blog_pub)||($this->is_blog&&!$this->blog_pub))return;
     #here we make sure any page with clone will have latest script direct from the clones original so any updates are curent even when the editpages that contain the clone are not updated!
     #this will be done for cloned posts/columns by passing the array key reference of the original to populate the scripts from the master array containing all key and value of scripts.  To populate final page specific scripts utilizes function script_handle_webmode called in the header of webmode pages
     #master script array stays current by deleted all keys associated with the page when in editmode for that page before repopulating with the new page entrees to account for any deleted/moved posts/columns
     if ($this->is_clone&&!$this->clone_local_style)return; 
	if (strpos($arrType,'once')===false)
		$this->{$arrType}.=$script;
	else
		$this->{$arrType}[]=$script;
		//subkey index prevents index over-write
	if (!array_key_exists($this->key,$this->scriptArr))$this->scriptArr[$this->key]=array();
     $this->scriptArr[$this->key][]=array($arrType,$script);//this will go to master script array in update_arrays 
         // }	
     }//end function
    
     
function border_calc($styles,$image=false){
     if (!$image){
          $this->left_border_info='';
          $this->right_border_info='';
          $image=' image border:';
          }
     else $image='';
     $border_sides=$this->border_sides;//aray of border types
	$styles=(is_array($styles))?$styles:explode(',',$styles);   
	$border_array=(array_key_exists($this->borders_index,$styles))?explode('@@',$styles[$this->borders_index]):array(); 
	for ($i=0; $i < 8; $i++){
		$border_array[$i]=(array_key_exists($i,$border_array))?$border_array[$i]:0;
		}
     if($border_array[3]==='No Border'||!preg_match(Cfg::Preg_color,$border_array[1]))   return array(0,0); 
     $scaleunit=(!empty($border_array[7])&&$border_array[7]==='em'||$border_array[7]==='rem')?$border_array[7]:'none'; 
     $border_value2=(!empty($border_array[8])&&is_numeric($border_array[8]))?$border_array[8]:0;
     if ($scaleunit!=='none'&&!empty($border_value2)){ 
          if ($scaleunit==='rem'){
               $border_width=16*$border_value2;
               $scale=($this->rem_scale)?'on':'off';
               $value="$image {$border_value2}rem equivalent to {$border_width}px with scale $scale";
               }
          if ($scaleunit==='em'){
               $border_width=$this->terminal_font_em_px*$border_value2;
               $scale=($this->terminal_em_scale)?'on':'off'; 
               $value="$image {$border_value2}em equivalent to {$border_width}px with scale $scale";
               }     
          }
	elseif (empty($border_array[0])||!is_numeric($border_array[0]))return array(0,0); 
	else  {
          $border_width=$border_array[0]; 
          $scale=(is_numeric($border_array[5])&&is_numeric($border_array[6])&&($border_array[5]-$border_array[6])>=75)?'on':'off';
          $value=(!empty($border_width)&&$border_width>=1)?"$image {$border_width}px with px scale $scale" :'';
          } 
		switch ($border_array[3]) {
               case $border_sides[0]:# none 
				$border_width=0; 
				$border_height=0; 
				break; 
			case $border_sides[1]:# all;
				$border_height=$border_width*2;
				$border_width=$border_width*2;
                    $this->left_border_info=$this->left_border_info.' Left Border: '. $value;
                    $this->right_border_info=$this->right_border_info.' Right Border: '.$value;
				break;
			case $border_sides[2]:# top bottom
				$border_height=$border_width*2;
				$border_width=0;
				break;
			case $border_sides[3]:# top
				$border_height=$border_width;
				$border_width=0;
				break;
			case $border_sides[4]:# bottom
				$border_height=$border_width;
				$border_width=0;
				break;
			case $border_sides[5]:# left
                    $this->left_border_info=$this->left_border_info.' Left Border: '.$value; 
				$border_height=0;
				$border_width=$border_width;
				break;
			case $border_sides[6]:# right 
                    $this->right_border_info=$this->right_border_info.' Right Border: '.$value;
				$border_height=0;
				$border_width=$border_width;
				break;
			case $border_sides[7]:# top left
                    $this->left_border_info=$this->left_border_info.' Left Border: '.$value; 
				$border_height=$border_width;
				$border_width=$border_width;
				break;
			case $border_sides[8]:# top right 
                    $this->right_border_info=$this->right_border_info.' Right Border: '.$value;
				$border_height=$border_width;
				$border_width=$border_width;
				break;
			case $border_sides[9]:# bottom left
                    $this->left_border_info=$this->left_border_info.' Left Border: '.$value; 
				$border_height=$border_width;
				$border_width=$border_width;
				break;
			case $border_sides[10]:# bottom right 
                    $this->right_border_info=$this->right_border_info.' Right Border: '.$value;
				$border_height=$border_width;
				$border_width=$border_width;
				break;
			case $border_sides[11]:# left right
                    $this->left_border_info=$this->left_border_info.' Left Border: '.$value;
                    $this->right_border_info=$this->right_border_info.' Right Border: '.$value;
				$border_height=0;
				$border_width=$border_width*2;
				break;
			default:
			$border_height=$border_width=0;
		}
	return array($border_width,$border_height);
	}

function track_font_em($styles){ 
	$styles=(is_array($styles))?$styles:explode(',',$styles);
	$font_arr=(array_key_exists($this->font_size_index,$styles))?explode('@@',$styles[$this->font_size_index]):array();
	for ($i=0; $i <11; $i++){
		if (!array_key_exists($i,$font_arr)){
               $font_arr[$i]=0;
               }
		}	 
     $fontsize1=(!empty($font_arr[0])&&is_numeric($font_arr[0])&&$font_arr[0]<=100&&$font_arr[0]>=1)?$font_arr[0]:0;
     $msg= (empty($fontsize1))? 'none ': $fontsize1;  
     $fontsize2=(!empty($font_arr[2])&&is_numeric($font_arr[2]))?$font_arr[2]:0;
     $scaleunit=(!empty($font_arr[1])&&$font_arr[1]==='em'||$font_arr[1]==='rem'||$font_arr[1]==='vw')?$font_arr[1]:'none';
     if (($font_arr[1]==='em'||$font_arr[1]==='rem'||$font_arr[1]==='vw')&&is_numeric($font_arr[2])&&$font_arr[2]>=.05&&$font_arr[2]<=10){
          if ($font_arr[1]==='em'){
               if ($this->is_page){//values will be  inherited from rem setting
                    $this->current_font_em_px=$this->terminal_font_em_px=$font_arr[2] *$this->rem_root;  
                    //current_em_scale refers to whether scaling true or false
                    $this->current_em_scale=$this->terminal_em_scale=$this->rem_scale;                   
                    }
               else{ 
                    $this->terminal_font_em_px=$font_arr[2] * $this->current_font_em_px;  
                    $this->terminal_em_scale=$this->current_em_scale;
                    if (!$this->is_blog){
                         $this->current_font_em_px=$font_arr[2] * $this->current_font_em_px; //this will track 
                         }
                    }
               }
          elseif ($font_arr[1]==='rem'){ 
               //$this->terminal_rem_scale=$this->current_rem_scale;
               $this->terminal_font_em_px=$font_arr[2] *$this->rem_root;  
               $this->terminal_em_scale=$this->rem_scale;
               if (!$this->is_blog){
                    $this->current_font_em_px=$font_arr[2] *$this->rem_root; // 
                    $this->current_em_scale=$this->rem_scale;
                    }
               } 
          elseif($font_arr[1]==='vw') {exit ('vw unit in use');//is vw
               $this->list[]='show up vw';
               $this->terminal_font_em_px=$font_arr[2] * $this->max_width_limit/100; // percentage of primary column width 
               $this->terminal_em_scale=true;
               if (!$this->is_blog){
                    $this->current_font_em_px=$font_arr[2] * $this->max_width_limit/100; // percentage of primary column width
                    $this->current_em_scale=true;
                    }
               }
		} 
	elseif ($font_arr[0]>=1&&$font_arr[0]<=100){
          $this->terminal_font_em_px=$font_arr[0];  
          if (!$this->is_blog){
               $this->current_font_em_px=$font_arr[0];
               }
          if ($font_arr[7]>300&&$font_arr[8]>200&&$font_arr[7]-$font_arr[8]>=75){
               $this->terminal_em_scale=true;     
               if (!$this->is_blog){
                    $this->current_em_scale=true;
                    } 
               }
          else {//no px scaling  
               $this->terminal_em_scale=false; 
               if (!$this->is_blog){
                    $this->current_em_scale=false;
                    } 
               } 
          }//is font px
	else { 
          $this->terminal_font_em_px=$this->current_font_em_px;  
          $this->terminal_px_scale=$this->current_em_scale;  
          }
    }

    
function calc_alt_percent(){
	
	
	
	}
	
function alt_width_calc($styles){
     $this->width_info='';
     $this->width_percent=false;
     $styles_arr=(is_array($styles))?$styles:explode('@@',$styles);
     for ($i=0;$i<12;$i++){
          if (!array_key_exists($i,$styles_arr)){
               $styles_arr[$i]=0;
               }
          }
     if (array_key_exists(4,$styles_arr)&&is_numeric($styles_arr[4])&&$styles_arr[4]>=.01){
          $width=$styles_arr[4]*$this->rem_root;//rem
          $this->width_scale=($this->rem_scale)?'rem scaling on':'rem scaling off';
          $this->width_info.=$styles_arr[4]."rem = {$width}px $this->width_scale<br>";
          
          }
     elseif (array_key_exists(3,$styles_arr)&&is_numeric($styles_arr[3])&&$styles_arr[3]>=.01){//em
          $width=$styles_arr[3]*$this->terminal_font_em_px;
          $this->width_scale=($this->terminal_em_scale)?'em scaling on':'em scaling off';
          $this->width_info.=$styles_arr[3]."em = {$width}px $this->width_scale<br>";
          }
     elseif (array_key_exists(2,$styles_arr)&&is_numeric($styles_arr[2])&&$styles_arr[2]>=.01){ 
          $width=$styles_arr[2]* $this->current_total_width/100;
          $this->width_scale='% scale';
          $this->width_info.=$styles_arr[2]."% = {$width}px $this->width_scale<br>";
          $this->width_percent=true;
          }
     elseif (array_key_exists(0,$styles_arr)&&is_numeric($styles_arr[0])&&$styles_arr[0]>=.01){ 
           $width=$styles_arr[0]; 
           $this->width_scale=($this->terminal_px_scale)?'px scaling on':'px scaling off';
           $this->width_info.="{$width}px $this->width_scale<br>";
           }
     else {
          $width=0; 
           $this->width_info.="Not set<br>";
           }
	return $width;
	}  
	
function pad_mar_calc($styles,$containerwid){  
	$styles=(is_array($styles))?$styles:explode(',',$styles);
	$spacing_arr=array('padding_right','padding_left','margin_right','margin_left');
	foreach ($spacing_arr as $space){
          $this->{$space.'_info'}='';//intialize
		${$space.'_arr'}=(array_key_exists($this->{$space.'_index'},$styles))?explode('@@',$styles[$this->{$space.'_index'}]):array();
          for ($i=0;$i<10;$i++){
               if (!array_key_exists($i,${$space.'_arr'})){
                    ${$space.'_arr'}[$i]=0;
                    }
               }
          if (array_key_exists(4,${$space.'_arr'})&&is_numeric(${$space.'_arr'}[4])&&${$space.'_arr'}[4]>=.01){
               $$space=${$space.'_arr'}[4]*$this->rem_root;//rem
               $this->{$space.'_info'}=($this->rem_scale)?$$space.'px equiv using rem scaling on':$$space.'px equiv using rem scaling off';
               }
          elseif (array_key_exists(3,${$space.'_arr'})&&is_numeric(${$space.'_arr'}[3])&&${$space.'_arr'}[3]>=.01){//em
               $$space=${$space.'_arr'}[3]*$this->terminal_font_em_px;
               $this->{$space.'_info'}=($this->terminal_em_scale)?$$space.'px equiv using em scaling on':$$space.'px equiv using em scaling off';
               }
          elseif (array_key_exists(2,${$space.'_arr'})&&is_numeric(${$space.'_arr'}[2])&&${$space.'_arr'}[2]>=.01){
               $$space=${$space.'_arr'}[2]* $this->current_total_width/100;
               $this->{$space.'_info'}=$$space.'px equiv using % scale';
               }
          elseif (array_key_exists(0,${$space.'_arr'})&&is_numeric(${$space.'_arr'}[0])&&${$space.'_arr'}[0]>=.01){
               $$space=${$space.'_arr'}[0]; 
               if (${$space.'_arr'}[7]>300&&${$space.'_arr'}[8]>200&&${$space.'_arr'}[7]-${$space.'_arr'}[8]>=75){
                    $this->{$space.'_info'}=$$space.'px scaling on';
                    }
               else $this->{$space.'_info'}=$$space.'px scaling off';
               }
          else $$space=0; 
		}
     return array(($padding_left+$padding_right),($margin_left+$margin_right));
	}

#calcshadow
#boxcalc #calcbox
function calc_border_shadow($styles){  //shadowbox_horiz_offset,shadowbox_vert_offset,shadowbox_blur_radius,shadowbox_spread_radius,shadowbox_color,shadowbox_insideout
	$styles=(is_array($styles))?$styles:explode(',',$styles);
	if (!array_key_exists($this->box_shadow_index,$styles))return 0; 
	$shadows=$styles[$this->box_shadow_index];
	$shadow_arr=explode('@@',$shadows);
	if (!array_key_exists($this->shadowbox_color_index,$shadow_arr))return 0;
	if (!preg_match(Cfg::Preg_color,$shadow_arr[$this->shadowbox_color_index]))return 0;
	if ($shadow_arr[$this->shadowbox_spread_radius_index]<0)return abs($shadow_arr[$this->shadowbox_horiz_offset_index])-$shadow_arr[$this->shadowbox_spread_radius_index];
	$max=max($shadow_arr[$this->shadowbox_spread_radius_index],abs($shadow_arr[$this->shadowbox_horiz_offset_index])); 
	$max= ($shadow_arr[$this->shadowbox_blur_radius_index]>$max&&$shadow_arr[$this->shadowbox_spread_radius_index]>0)?$max+ min(3*$max,$shadow_arr[$this->shadowbox_blur_radius_index]/$shadow_arr[$this->shadowbox_spread_radius_index]):$max+$shadow_arr[$this->shadowbox_blur_radius_index]*.67;
	return round(2*$max);
	}
#end 
	
function nested_column(){ 
	$this->column_level++;
	$this->column_lev_color=$this->color_arr_long[$this->column_level];
	if($this->blog_data2==='column_choice'){
		$this->choose_column($this->blog_id,true);   
		$this->column_level--;   
		return;
		}
	$this->blog_render($this->blog_data1,false,$this->col_table_base);
	$this->column_level--;   
	$this->column_lev_color=$this->color_arr_long[$this->column_level];  
	} 
	
function blog_import_export_options(){
     if ($this->is_clone)return;
	$this->show_more('Import/Export Styles &amp; Configurations Option');
	$this->print_redwrap('import/export',true);
     $this->submit_button();
	echo '<div class="'.$this->column_lev_color.' fsminfo  editbackground editfont left "><!--import-->Import to this post only all styles and certain configuration from another '.$this->blog_type.' post from any page. <b>Will Not change configurations for main width, Rwd Grid settings, flexbox, height, and alternative RWD settings, unless you check the additional box below  to import these also,  or these can be changed separately below. Will not change basic data such as Image Names and caption data, feedback, text, etc.</b> Post types must match.';
	printer::printx( '<p class="editcolor editbackground editfont" title="Be Sure to Use the Post Id Which Begins with a P ie P42.  Do Not Use the  Post# which simply refer to the Post Display Order Within the Column. Post Ids and #s are displayed at the top of each post"><input class="editcolor editbackground editfont" name="post_configcopy['.$this->blog_id.']" size="8" maxlength="8" type="text">Enter the  <span class="info">Post Id</span> <span class="red">(Not Post#) </span>that you wish to Copy Configurations and Styles to this post</p>');
	printer::printx( '<p class="editcolor editbackground editfont"><input class="editcolor editbackground editfont" name="post_allconfigcopy['.$this->blog_id.']"   type="checkbox" value="'.$this->blog_id.'">Copy Include <b> All Width, Float &amp; RWD Configs</b> to this post also.</p>');
	echo '</div>'; 
	echo '<div class="'.$this->column_lev_color.' fsminfo  editbackground editfont left "><!--export-->Export styles and configuration (<b>Will Not change configurations for width,Rwd Grid settings, or float settings, or click the additional option just below to includes these also. Alternatively, these can be changed separately below.  Will not change basic data such as Image Names and caption data, feedback, text, etc.</b>) from this '.$this->blog_type.' post to any other '.$this->blog_type.' post that is directly within this Column Post types must match.';
	printer::printx( '<p class="editcolor editbackground editfont" 	><input class="editcolor editbackground editfont" name="post_configexport['.$this->blog_id.']"   type="checkbox" value="'.$this->blog_id.'">Export these Styles and Configs to '.$this->blog_type.' posts within this column</p>');
	printer::printx( '<p class="editcolor editbackground editfont" 	><input class="editcolor editbackground editfont" name="post_allconfigexport['.$this->blog_id.']"   type="checkbox" value="'.$this->blog_id.'">Also Include Exporting <b> Main Width, RWD Configs, and Float Settings</b> to '.$this->blog_type.' posts within this parent column</p>');
	echo '</div><!--export-->';
	//$this->show_more('Or choose individual Configuration to Export/Import');
     //$this->print_redwrap('individual port options'); 
     printer::print_tip('Styles may exported/imported by using that option located at the bottom of every grouping of particular style options. Here we import/export other configuration options on indiviudal basis.');
	
	
	echo '</div>'; 
	
	#######################################################
	printer::print_wrap('alt widthunits');
		printer::print_tip('<b>Alt min max width Units</b> (ie percentage,rem,em,vw) available under the Additional individual field choices to import or export from field blog_options');
	printer::close_print_wrap('alt widthunits');
		#######################################################
	
	echo '<div class="'.$this->column_lev_color.' fsminfo  editbackground editfont left "><!--export-->Export the Main Width value including max-width, percentage, and Alt RWD Percentage from this post to posts that are directly within this Column. Field: blog_width';
	printer::printx( '<p class="editcolor editbackground editfont" ><input class="editcolor editbackground editfont" name="post_widthexport['.$this->blog_id.']"  type="checkbox" value="'.$this->blog_id.'">Export the Main width value of this post to all posts directly in this column</p>'); 
	printer::printx( '<p class="editcolor editbackground editfont" ><input class="editcolor editbackground editfont" name="post_col_widthexport['.$this->blog_id.']"  type="checkbox" value="'.$this->blog_id.'">Also include Width value export to Nested Columns directly in same parent Field: col_width</p>');
	echo '</div><!--export-->';
	
	#######################################################33
	printer::print_wrap('flex port');
	echo '<div class="'.$this->column_lev_color.' fsminfo  editbackground editfont left "><!--import-->Import Post Flex Items to this post from another non nested column post from any other post in the site. Field: blog_flex_box';
	printer::printx( '<p class="editcolor editbackground editfont" title="Be Sure to Use the Post Id Which Begins with a P ie P42.  Do Not Use the  Post# which simply refer to the Post Display Order Within the Column. Post Ids and #s are displayed at the top of each post"><input class="editcolor editbackground editfont" name="post_flexcopy['.$this->blog_id.']" size="8" maxlength="8" type="text">Enter the  <span class="info">Post Id</span> <span class="red">(Not Post#) </span>that you wish to copy Post Flex Items from</p>');  
	echo '</div><!--import-->'; 
     echo '<div class="'.$this->column_lev_color.' fsminfo  editbackground editfont left "><!--export-->Export the Flex Item setting (affects posts in non-rwd grid mode) from this post to posts that are directly within this Column. Field: blog_flex_box';
	printer::printx( '<p class="editcolor editbackground editfont" ><input class="editcolor editbackground editfont" name="post_flexexport['.$this->blog_id.']"  type="checkbox" value="'.$this->blog_id.'">Export the Flex Item settings of this post to all posts directly in the parent column</p>');
     printer::printx( '<p class="editcolor editbackground editfont" ><input class="editcolor editbackground editfont" name="post_col_flex_item_export['.$this->blog_id.']"  type="checkbox" value="'.$this->blog_id.'">Also include Flex Item export of values to Nested Columns directly in same parent Field: col_flex_box</p>');
	echo '</div><!--export-->'; 
	printer::close_print_wrap('flex port');
	#######################################################33
	echo '<div class="'.$this->column_lev_color.' fsminfo  editbackground editfont left "><!--export-->Export the  Float row share setting (affects posts in non-rwd grid mode) from this post to all posts including nested column that are directly within this Column';
	printer::printx( '<p class="editcolor editbackground editfont" ><input class="editcolor editbackground editfont" name="post_floatexport['.$this->blog_id.']"  type="checkbox" value="'.$this->blog_id.'">Export the Float setting of this post to all posts directly in this column. Field: blog_float</p>');
	printer::printx( '<p class="editcolor editbackground editfont" ><input class="editcolor editbackground editfont" name="post_col_floatexport['.$this->blog_id.']"  type="checkbox" value="'.$this->blog_id.'">Also include Float setting export to Nested Columns directly in same parent </p>');
	echo '</div><!--export-->';
	printer::print_tip('Original RWD Grid with set page wide break points');
	echo '<div class="'.$this->column_lev_color.' fsminfo  editbackground editfont left "><!--export-->Export RWD Grid percentage settings and width mode choice from this  post to any other non nested column post that is directly within this Column.';
	printer::printx( '<p class="editcolor editbackground editfont" ><input class="editcolor editbackground editfont" name="post_rwdexport['.$this->blog_id.']"  type="checkbox" value="'.$this->blog_id.'">Export this Posts RWD Grid settings to other posts within this column</p>');
	printer::printx( '<p class="editcolor editbackground editfont" ><input class="editcolor editbackground editfont" name="post_col_rwdexport['.$this->blog_id.']"  type="checkbox" value="'.$this->blog_id.'">Also include RWD Grid export to Nested Columns directly in same parent </p>');
	echo '</div><!--export-->';
	echo '<div class="'.$this->column_lev_color.' fsminfo  editbackground editfont left "><!--import-->Import RWD Grid percentage selections to this post from another post from any page that has the same Grid Break Points set in the page options. Field: <span class="info" title="blog_gridspace_right, blog_gridspace_left, blog_grid_width">Info</span>';
	printer::printx( '<p class="editcolor editbackground editfont" title="Be Sure to Use the Post Id Which Begins with a P ie P42.  Do Not Use the  Post# which simply refer to the Post Display Order Within the Column. Post Ids and #s are displayed at the top of each post"><input class="editcolor editbackground editfont" name="post_rwdcopy['.$this->blog_id.']" size="8" maxlength="8" type="text">Enter the  <span class="info">Post Id</span> <span class="red">(Not Post#) </span>that you wish to copy Post RWD grid break point percentages</p>');
     ##########
	printer::print_wrap('blog option Port');
     printer::print_tip('Additional individual field choices to import or export from field blog_options');
	$this->blog_option_choices('import');
	$this->blog_option_choices('export');
      $this->submit_button();
	printer::close_print_wrap('blog option Port');
    // $this->show_close('Or choose individual Configuration to Export/Import');
     //printer::close_print_wrap('individual port options');
     ########## 
	$this->show_more('Inter-Database Export/Import Entire Post Data Style Configs');
	$dir= (is_dir(Sys::Common_dir))?Sys::Common_dir:Sys::Home_pub;
	$dir=rtrim($dir,'/').'/';
	$this->print_redwrap('interdatabase');
	printer::print_tip('If you are running multiple databases you can export/import all  data &amp; configs/Styles of this post to/from another database.  First Choose export dump data from donor post. Data will dump from database to file. Navigate to new webpage and post you wish to import data, and it will automatically import the file and update that database. File will dump to the common_dir if it exists otherwise the home directory.  Currently to import the file or export data the system will use/look-for the file: <span class="red">'.$dir.'lastpostdump.dat</span>'); 
				    
	printer::printx( '<p class="editcolor editbackground editfont" ><input class="editcolor editbackground editfont" name="post_configexportdump['.$this->blog_id.']"   type="checkbox" value="'.$this->blog_id.'">Export Dump these Styles and Config Settings to file.</p>');
	printer::printx( '<p class="editcolor editbackground editfont" ><input class="editcolor editbackground editfont" name="post_configimportdump['.$this->blog_id.']"   type="checkbox" value="'.$this->blog_id.'">Import Grab Style and Cofigure Settings from file '.$dir.'lastpostdump.dat</p>');
	printer::close_print_wrap('interdatabase');
	$this->show_close('Inter-Database Export/Import Configs/Settings');
	##########################################333
	$this->submit_button();
	printer::close_print_wrap('import/export'); 
	$this->show_close('Import All Styles &amp; Configurations Option');
	printer::pclear(5);
			################33
	}//end blog import export options
     
function light_dark($data,$field,$value){  
	$select=(!empty($value)&&is_numeric($value))?$value:'0';
     if (empty($value))$selected='none';
     elseif ($value==='.9')$selected='Lighten';
     elseif ($value==='.8')$selected='Lighter';
     elseif ($value==='.7')$selected='Lightish';
     elseif ($value==='.6')$selected='Even Lighter';
     elseif ($value==='.5')$selected='More Lighter';
     elseif ($value==='.4')$selected='Lightest';
     elseif ($value==='-.9')$selected='Darken';
     elseif ($value==='-.8')$selected='Darker';
     elseif ($value==='-.7')$selected='Darkish';
     elseif ($value==='-.6')$selected='Even Darker';
     elseif ($value==='-.5')$selected='More Darker';
     elseif ($value==='-.4')$selected='Darkish';
     else $selected='none';
     echo'<p><select class="editcolor editbackground editfont"  name="'.$data.'_'.$field.'">        
     <option   value="'.$select.'" selected="selected">'.$selected.'</option>';  
         echo '<option  value="0">None</option>';
         echo '<option  value=".9">Lighten</option>';
         echo '<option  value=".8">Lighter</option>';
         echo '<option  value=".7">Lightish</option>';
         echo '<option  value=".6">Even Lighter</option>';
         echo '<option  value=".5">More Lighter</option>';
         echo '<option  value=".4">Lightest</option>';
         echo '<option  value="-.9">Darken</option>';
         echo '<option  value="-.8">Darker</option>';
         echo '<option  value="-.7">Darkish</option>';
         echo '<option  value="-.6">Even Darker</option>';
         echo '<option  value="-.5">More Darker</option>';
         echo '<option  value="-.4">Darkest</option>'; 
     echo'	
     </select></p>';
	}

function resize($picname,$tmaxw,$maxh,$maxplus,$storage_path,$final_path,$msg='',$output='file',$watermark=NULL,$quality='95',$watermarkposition='center',$errormsg=false , $imgtype='post'){
	$return='';
	$final_path=trim($final_path,'/').'/';
	if (!is_file($storage_path.$picname)){
		list($width,$height)=$this->get_size($picname,$final_path);
		if ($width < $tmaxw){
			$this->message[]='<img src="'.$final_path.$picname.'" class="floatleft" height="50" ><p class="pl10 maxwidth400 small floatleft">Not Finding the original uploaded image for resizing  photo '.$picname.' in:'.$msg.' </p>';  
			return false;
			}
		else if ($width > $tmaxw){
			copy($final_path.$picname,$storage_path.$picname);
			$this->message[]='<img src="'.$final_path.$picname.'" class="floatleft" height="50" ><p class="pl10 maxwidth400 small floatleft">Tech Notice: Missing Orignal uploaded image replaced by resized page image :'.$picname.' in:'.$msg;
			}
		}
	$maxw=$tmaxw;
	list($up_width,$up_height)=$this->get_size($picname,$storage_path);
	if ($maxh > $maxplus && $maxh > $maxw) $maxw=$maxh*$up_width/$up_height;
	else if ($maxplus >$maxw && $maxplus > $maxh) $maxw= $maxplus / (1 + $up_height/$up_width); 
	if (!is_file($final_path.$picname)){
		if ($maxw > $up_width){
			$this->message[]='<img src="'.$storage_path.$picname.'" class="floatleft " height="50" ><p class="pl10 maxwidth400 small floatleft redAlertbackground white">This 
		'.$this->image_resize_msg.' uploaded photo '.$picname.' in Post Id'.$this->blog_id.' has a limited width and isn&#39;t large enough for the space available. Replace with a larger image, decrease the available width setting, delete it, leave as is, etc.</p>'; 
			$return=false;
			}
		}
	else {
		list($width,$height)=$this->get_size($picname,$final_path);
		if ($width > $up_width && $maxw > $width){
			$this->message[]='<img src="'.$final_path.$picname.'" class="floatleft" height="50" ><p class="pl10 maxwidth400 small floatleft redAlertbackground white">This 
			'.$this->image_resize_msg.' uploaded photo '.$picname.' in Post Id'.$this->blog_id.' has a limited width and isn&#39;t large enough for the space available. Replace with a larger image, decrease the available width setting, delete it, leave as is, etc.</p>'; 
			return false;
			}
		if ($up_width > $width * 1.01  && $maxw > $up_width*1.03){  
			$this->message[]='<img src="'.$final_path.$picname.'" class="floatleft" height="50" ><p class="pl10 maxwidth400 small floatleft redAlertbackground white">This '.$this->image_resize_msg.' photo '.$picname.' in Post Id'.$this->blog_id.' is resized to the full orginal upload width although still not large enough for the full space available. Replace with a larger image, decrease the available width setting, delete it, leave as is, etc.</p>';
			$return=false;
			}
		elseif ($up_width <= $width * 1.01&&$maxw>$up_width*1.03){ 
			////$this->instruct[]='<img src="'.$final_path.$picname.'" class="floatleft" height="40" ><p class="pl10 maxwidth400 small floatleft redAlertbackground white">This '.$this->image_resize_msg.' Original Uploaded Image '.$picname.' in Post Id'.$this->blog_id.' is not large enough for the full space available.</p>';
			return false;
			}
		else $return=true;
		}// is file $final_path
	image::image_resize($picname, $tmaxw, $maxh,$maxplus,$storage_path,$final_path,$output,$watermark,$quality,$watermarkposition,$errormsg);
	$this->instruct[]='Refresh Button <a href="'.Sys::Self.'"> <img src="../refresh_button.png" alt="refresh button" width="20" height="20"></a> to Insure All New Image Widths are Updated!!'; 
	return  $return;
	}

     
function checking($id,$name,$value,$text,$title,$class="ramanaleft"){   /// not in use
	$checked= ($var==1)?' checked="checked" ':''; 
     echo '<p class="'.$class.'" ><input type="checkbox" id="'. $style.'_'. $val  .'" name="'.$style.'['. $val .']"'.$checked.' value="1">Select '. $functions[$val].'</p>';
	}
	
function mod_spacing($name,$size,$range1=0,$range2=300,$increment=5,$unit='px',$none='',$msg='',$factor=1,$unit2=''){ if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__); 
	self::$rangecount++; 
	$inc=self::$rangecount; 
	$css_id=($this->is_page)?$this->pagename:(($this->is_column)?$this->col_name:$this->dataCss);
	$checked= ($size==='none')?'checked="checked"':''; 
	$showunit=(is_numeric($size))?$unit:''; 
     $init=(is_numeric($size))?$size:0; 
     $ornone=($none==='none')?' Or Check none':'';
     printer::single_custom_wrap('mod width','fs1info editbackground editcolor');
     $convert= ($unit2 !== '' && $factor !=='1') ?'  &nbsp;'.(round($size*$factor,2)).$unit2:'';  
     printer::print_tip2($msg.' <b>Currently: '.$size.$showunit.$convert.'</b> &nbsp;&nbsp;&nbsp; Use 0 to Remove'.$ornone ,.7);
     $nomsg=($none==='none')?' <input id="slider-checkbox_'.$inc.'" type="checkbox"  '.$checked.' onchange="edit_Proc.allowThis(this);" name="'.$name.'"  value="none"  > Choose None':'';
	echo '
     <div id="toggle_'.$inc.'" class="clear editbackground editfont editcolor"  style="display:none;"><!--toggle hide mod_spacing-->';
	echo '<p style="height:5px">';for ($i=0; $i<60;  $i++)echo '&nbsp; &nbsp;'; echo '</p><!--mod spacer -->';//fillspacing avail for larger slider
     echo '
	<div class="clear editfont tip2"> <!--mod_spacing choose-->
    Choose:  
 <input style="visibility:hidden;" data-max="'.$range2.'" data-min="'.$range1.'" id="slider-input_'.$inc.'" type="text" value="'.$size.'" name="'.$name.'">
 <div id="slider-update_'.$inc.'"  ></div>
<p class="pt10"><span id="slider-update-value_'.$inc.'"></span>'.$nomsg.'</p>
<p class="pt5"></p></div><!--mod_spacing choose-->
</div><!--toggle hide mod_spacing-->';
     echo <<<eol
<p id="button-create-slide_$inc" class="clear tip2 cursor radius5 fsmgrey floatleft grey" onclick="gen_Proc.openIt('toggle_$inc');setTimeout(function(){initnoUiSlider($inc,$range1,$range2,'$init',$increment,'$unit',$factor,'$unit2')},100);">Initiate Slider</p>
<p id="button-refine-slide_$inc" class="cursor tip2 fsmgrey floatleft grey hide" onclick="updateSliderRange($inc);document.getElementById('button-reinit-slide_$inc').classList.remove('hide');">Refine Slider Choice</p> 
<p id="button-reinit-slide_$inc" class="cursor tip2 fsmgrey floatleft grey hide" onclick="initnoUiSlider($inc,$range1,$range2,'$size',$increment,'$unit',$factor,'$unit2',true);"><b>Full Range</b></p>
eol;

	if($none==='auto')printer::alert('<input type="checkbox" name="'.$name.'" value="auto">Choose value auto');
     printer::close_single_wrap('mod width'); 
   }
   
function edit_form_end($value='SUBMIT ALL CHANGES'){  if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
     (Sys::Deltatime)&&$this->deltatime->delta_log(__LINE__.' @ '.__method__.'  ');

     foreach($this->hidden_array as $render){
          echo $render;
          }
     
	echo '<div class="clear spacer"></div>';
	echo '<input type="hidden" name="sess_token" value="'.$this->sess->sess_token.'">';
	echo ' <p><input type="submit" name="submit" value="'.$value.'" ><br><br><br></p>';
	echo '<p> <input class="editbackground editfont cursor buttonpos pos mb10" type="hidden" name="submitted" value="true" > </p>';
	printer::pspace(25);
     print('</form><!--mainform end-->');
      if(count($this->hidden_array)>0){
          $action=Sys::Self;
          echo '<form id="autosubmit" action="'.$action.'"  method="post">';
          foreach($this->hidden_array as $render){
               echo $render;
               }
          echo '<input type="hidden" name="submitted" value="true" >';
          echo <<<eol
     <script>
      jQuery(function() {
            // document.getElementById('autosubmit').submit();
     });
     </script>
     </form><!--autosubmit-->
eol;
          }
	}
function page_parallax_css(){
     $this->show_more('Enable Parallax');
	printer::print_wrap('Enable Parallax');
     printer::print_tip('Turn on page parallax Option Here.  Utilizes The Keith Clarks Css method which "Limits the effect to relatively modern browsers also narrows the scope to reasonably modern mobile/tablet hardware, so there s a realistic chance of the effect being performant." <br> You can Optionaly choose a view screen min-width in which to enable the parallax effect.');
     
     printer::print_tip('Enter classname <b>parallax</b> into  column options Add Custom classnames option. Then in posts/nested columns within add classname option <b>para_back</b> and <b>para_base</b> for parallax effect correpondeing to Keith Clarks classes for parallax__layer parallax__layer--back and parallax__layer parallax__layer--base. Although para_group also available (ie. parallax__group) it hasnt seemed to produce positive effect.');
     $parallax_min=(!empty($this->page_options[$this->page_parallax_minwidth_index])&&$this->page_options[$this->page_parallax_minwidth_index]>299)?$this->page_options[$this->page_parallax_minwidth_index]:'0';
     $checked1=($this->page_options[$this->page_parallax_index]==='turnon')?'checked="checked"':''; 
	$checked2=($this->page_options[$this->page_parallax_index]!=='turnon')?'checked="checked"':''; 
	printer::alert('<input type="radio" value="turnon" '.$checked1.' name="page_options['.$this->page_parallax_index.']">Parallax On<br>');
	printer::alert('<input type="radio" value="disabled" '.$checked2.' name="page_options['.$this->page_parallax_index.']">Parallax Off');
     printer::pclear(5);
     printer::alert('Set Parallax Min-Width view screen size:');
	$this->mod_spacing('page_options['.$this->page_parallax_minwidth_index.']',$parallax_min,300,1400,1,'px','none');
	printer::pclear();
     if ($this->page_options[$this->page_parallax_index]==='turnon'){
         if (!empty($paralax_min))
               $this->pagecss.='
          @media screen and (min-width: 40em) {';
          $this->pagecss.='
          @supports ((perspective: 1px) and (not (-webkit-overflow-scrolling: touch))) {
          
     .parallax{
        perspective: 1px;
      -webkit-perspective-origin: 100vw 50%;
      -moz-perspective-origin: 100vw 50%;
      -ms-perspective-origin: 100vw 50%;
      perspective-origin: 100vw 50%;
        height: 100vh;
        overflow-x: hidden;
        overflow-y: auto;
          }
 
     .para_back{
          position: absolute;
          top:0;
          right:0;
          bottom:0;
          left:0;
          transform: translateZ(-0.85px)scale(1.85);
          -webkit-transform-origin-y: 100% 100% 0px;
          -moz-transform-origin: 100% 100% 0px;
          -ms-transform-origin: 100% 100% 0px;
          transform-origin: 100% 100% 0px;
          }
     .para_base{
          position: absolute;
          top:0;
          right:0;
          bottom:0;
          left:0;
          transform: translateZ(0px);
          }
     .para_group{
               position: relative;
               height: 100vh;
               transform-style: preserve-3d;
               }';
          if (!empty($paralax_min))
               $this->pagecss.='
          }';
          }
	printer::close_print_wrap('Enable Parallax');
	$this->show_close('Enable Parallax');
     }
function editor_appearance(){
     echo '<div class="floatbutton"><!-- float buttons-->';
     $this->show_more('EditMode Style','asis',$this->column_lev_color.' smallest  editbackground editfont button'.$this->column_lev_color);
	$this->print_wrap('editor appearance');
	$this->show_more('Configure Editor Colors','noback');
	$this->print_redwrap('Editor colorWrap',true);
	if($this->page_options[$this->page_editor_choice_index]==='dark'){
		$checked1='';
		$checked2='checked="checked"';
		$page_color_order_property='page_dark_editor_order';
		$page_color_value_property='page_dark_editor_value';
		$editorref='Dark'; 
		}
	else {
		$checked2='';
		$checked1='checked="checked"';
		$page_color_order_property='page_light_editor_order';
		$page_color_value_property='page_light_editor_value';
		$editorref='Light';
		}
	printer::alertx('<p class="smaller  editcolor left editbackground editfont" style="padding: 4px 4px 4px 5px; border-width: 3px 0px 3px 0px;  border-style:solid; border-color: #'. $this->page_options[$this->page_darkeditor_color_index].';cursor:pointer;background:#'.$this->page_options[$this->page_darkeditor_background_index].';color:#'.$this->page_options[$this->page_darkeditor_color_index].';">  #<input onclick="jscolor.installByClassName(\'darkeditorbackcolor\');" style="cursor:pointer;background:#'.$this->page_options[$this->page_darkeditor_background_index].';color:#'.$this->page_options[$this->page_darkeditor_color_index].';" type="text"  name="page_options['.$this->page_darkeditor_background_index.']"   value="'.$this->page_options[$this->page_darkeditor_background_index].'" size="6" maxlength="6" class="darkeditorbackcolor {refine:false}">Change Background Color of Dark Theme Editor</p>');
	printer::pclear(3);
	printer::alertx('<p class="fs1color smaller  editcolor left editbackground editfont" style="padding: 4px 4px 4px 5px; border-width: 3px 0px 3px 0px;  border-style:solid; border-color: #'. $this->page_options[$this->page_darkeditor_color_index].'; cursor:pointer;background:#'.$this->page_options[$this->page_darkeditor_background_index].';color:#'.$this->page_options[$this->page_darkeditor_color_index].';">  #<input onclick="jscolor.installByClassName(\'darkeditorcolor\');" style="cursor:pointer;background:#'.$this->page_options[$this->page_darkeditor_background_index].';color:#'.$this->page_options[$this->page_darkeditor_color_index].';" type="text"  name="page_options['.$this->page_darkeditor_color_index.']"   value="'.$this->page_options[$this->page_darkeditor_color_index].'" size="6" maxlength="6" class="darkeditorcolor {refine:false}">Change Editor Misc. Text Colors of Dark Theme </p>');
	
	printer::pclear(3);
	printer::alertx('<p class=" smaller  editcolor left editfont" style="padding: 4px 4px 4px 5px; border-width: 3px 0px 3px 0px;  border-style:solid; border-color: #'. $this->page_options[$this->page_lighteditor_color_index].';cursor:pointer;background:#'.$this->page_options[$this->page_lighteditor_background_index].';color:#'.$this->page_options[$this->page_lighteditor_color_index].';"> #<input onclick="jscolor.installByClassName(\'lighteditorbackcolor\');" style="cursor:pointer;background:#'.$this->page_options[$this->page_lighteditor_background_index].';color:#'.$this->page_options[$this->page_lighteditor_color_index].';" type="text"  name="page_options['.$this->page_lighteditor_background_index.']"   value="'.$this->page_options[$this->page_lighteditor_background_index].'" size="6" maxlength="6" class="lighteditorbackcolor {refine:false}">Change Background Color of Editor Light Theme </p>');
	printer::pclear(3);
	printer::alertx('<p class="smaller  left editfont" style="padding: 4px 4px 4px 5px; border-width: 3px 0px 3px 0px;  border-style:solid; border-color: #'. $this->page_options[$this->page_lighteditor_color_index].';cursor:pointer;background:#'.$this->page_options[$this->page_lighteditor_background_index].';color:#'.$this->page_options[$this->page_lighteditor_color_index].';">#<input onclick="jscolor.installByClassName(\'lighteditorcolor\');" style="cursor:pointer;background:#'.$this->page_options[$this->page_lighteditor_background_index].';color:#'.$this->page_options[$this->page_lighteditor_color_index].';" type="text"  name="page_options['.$this->page_lighteditor_color_index.'];"   value="'.$this->page_options[$this->page_lighteditor_color_index].'" size="6" maxlength="6" class="lighteditorcolor {refine:false}">Change Misc. Colors of Light Theme Editor</p>');
     
     printer::pclear(10);
     $this->show_more('Change Info/Clone/Sucess/Error text colors &amp; Envelope background color for small width posts');
     printer::print_wrap('Change Message Colors');
     printer::print_tip('Style info color differently than editor text color. The info color is text that provides information upon hovering also used in submit messages &amp; other info purposes');
printer::alertx('<p class="smaller  editcolor left editbackground editfont" style="padding: 4px 4px 4px 5px; cursor:pointer;background:#'.$this->page_options[$this->page_darkeditor_background_index].';color:#'.$this->page_options[$this->page_darkeditor_color_index].';">  #<input onclick="jscolor.installByClassName(\'darkeditorinfo\');" style="cursor:pointer;background:#'.$this->page_options[$this->page_darkeditor_background_index].';color:#'.$this->page_options[$this->page_darkeditor_color_index].';" type="text"  name="page_options['.$this->page_darkeditor_info_index.']"   value="'.$this->page_options[$this->page_darkeditor_info_index].'" size="6" maxlength="6" class="darkeditorinfo {refine:false}">Change information color for  Dark Theme Editor</p>');
printer::alertx('<p class="smaller  editcolor left editbackground editfont" style="padding: 4px 4px 4px 5px; cursor:pointer;background:#'.$this->page_options[$this->page_lighteditor_background_index].';color:#'.$this->page_options[$this->page_lighteditor_color_index].';">  #<input onclick="jscolor.installByClassName(\'lighteditorinfo\');" style="cursor:pointer;background:#'.$this->page_options[$this->page_lighteditor_background_index].';color:#'.$this->page_options[$this->page_lighteditor_color_index].';" type="text"  name="page_options['.$this->page_lighteditor_info_index.']"   value="'.$this->page_options[$this->page_lighteditor_info_index].'" size="6" maxlength="6" class="lighteditorinfo {refine:false}">Change information color for Light Theme Editor</p>');
     printer::pclear(20);
     printer::print_tip('Style the successful upload/msg color and envelope color for small width posts differently than the default green shade.');
printer::alertx('<p class="smaller  editcolor left editbackground editfont" style="padding: 4px 4px 4px 5px; cursor:pointer;background:#'.$this->page_options[$this->page_darkeditor_background_index].';color:#'.$this->page_options[$this->page_darkeditor_color_index].';">  #<input onclick="jscolor.installByClassName(\'darkeditorpos\');" style="cursor:pointer;background:#'.$this->page_options[$this->page_darkeditor_background_index].';color:#'.$this->page_options[$this->page_darkeditor_color_index].';" type="text"  name="page_options['.$this->page_darkeditor_pos_index.']"   value="'.$this->page_options[$this->page_darkeditor_pos_index].'" size="6" maxlength="6" class="darkeditorpos {refine:false}">Change the successful upload/etc. alert color for  Dark Theme Editor</p>');
printer::alertx('<p class="smaller  editcolor left editbackground editfont" style="padding: 4px 4px 4px 5px; cursor:pointer;background:#'.$this->page_options[$this->page_lighteditor_background_index].';color:#'.$this->page_options[$this->page_lighteditor_color_index].';">  #<input onclick="jscolor.installByClassName(\'lighteditorpos\');" style="cursor:pointer;background:#'.$this->page_options[$this->page_lighteditor_background_index].';color:#'.$this->page_options[$this->page_lighteditor_color_index].';" type="text"  name="page_options['.$this->page_lighteditor_pos_index.']"   value="'.$this->page_options[$this->page_lighteditor_pos_index].'" size="6" maxlength="6" class="lighteditorpos {refine:false}">Change the successful upload/etc. alert color for Light Theme Editor</p>');
     printer::pclear(20);
     printer::print_tip('Style Error messages and Clone alert color differently than the default Red color.');
printer::alertx('<p class="smaller  editcolor left editbackground editfont" style="padding: 4px 4px 4px 5px; cursor:pointer;background:#'.$this->page_options[$this->page_darkeditor_background_index].';color:#'.$this->page_options[$this->page_darkeditor_color_index].';">  #<input onclick="jscolor.installByClassName(\'darkeditorred\');" style="cursor:pointer;background:#'.$this->page_options[$this->page_darkeditor_background_index].';color:#'.$this->page_options[$this->page_darkeditor_color_index].';" type="text"  name="page_options['.$this->page_darkeditor_red_index.']"   value="'.$this->page_options[$this->page_darkeditor_red_index].'" size="6" maxlength="6" class="darkeditorred {refine:false}">Change the clone and error alert color for Dark Theme Editor</p>');
printer::alertx('<p class="smaller  editcolor left editbackground editfont" style="padding: 4px 4px 4px 5px; cursor:pointer;background:#'.$this->page_options[$this->page_lighteditor_background_index].';color:#'.$this->page_options[$this->page_lighteditor_color_index].';">  #<input onclick="jscolor.installByClassName(\'lighteditorred\');" style="cursor:pointer;background:#'.$this->page_options[$this->page_lighteditor_background_index].';color:#'.$this->page_options[$this->page_lighteditor_color_index].';" type="text"  name="page_options['.$this->page_lighteditor_red_index.']"   value="'.$this->page_options[$this->page_lighteditor_red_index].'" size="6" maxlength="6" class="lighteditorred {refine:false}">Change the clone and error alert color for Light Theme Editor</p>');
     printer::close_print_wrap('Change Message and Info Colors');
     $this->show_close('Change Message and Info Colors');
   	printer::pclear(10);
	printer::alert('Choose Light or Dark Editor / Change the Default Editor Light/Dark Editor Colors. Text Color and Background Color Should Contrast One Another For Readability');
	printer::alert('<input type="radio" name="page_options['.$this->page_editor_choice_index.']" '.$checked1.' value="light">Use Light Editor');
	printer::alert('<input type="radio" name="page_options['.$this->page_editor_choice_index.']" '.$checked2.' value="dark">Use Dark Editor');
	$this->show_more('Test View '.$editorref,'noback');
	$this->print_wrap('test color view');
	$x=1;
	printer::printx('<p class="smaller floatleft editbackground editfont fs1info" style="margin:1px;width:110px; height:100px;color:#'.$this->info.'">Info color is the Information Text Color</p>
  <p class="smaller floatleft editbackground editfont fs1redAlert" style="margin:1px;width:110px; height:100px;color:#'.$this->redAlert.'">redAlert used in error a clone alert Message Color </p><p class="smallest floatleft editbackground editfont fs1pos" style="margin:1px;width:110px; height:100px;color:#'.$this->pos.'">Pos alerts successful messages &amp; background envelope color for small posts.</p>');
	printer::pclear(5);
	printer::printx('<p class="fsminfo editbackground editfont">Note: Column Colors Are Useful To Indicate the Grouping of Posts within a Parent Column so Colors Change as the level of Nested Columns Changes. The highter # Colors Generally Go unused whereas #1 #2 #3 and #4 #5 #6 are most extensively used.  Change the color level order for your chosen editor color theme in this section</p>');
	printer::pclear(5); 
	foreach ($this->color_order_arr as $color){
		echo '<p class="smaller floatleft editbackground editfont fs1'.$color.'" style="margin:1px; width:100px; height:100px;color:#'.$this->$color.'">This Color is '.$color.' @ Col Level: #'.$x.'</p>';
		$x++;
		}
	$this->close_print_wrap('test color view');	
	$this->show_close('Test View '.$editorref.' Editor Text Colors');
	$this->show_more('Rearange '.$editorref.' Column Colors','noback');
	$this->print_wrap('rearrange color view');
	printer::printx('<p class="fsminfo editbackground editfont editcolor">Basically each successive layer of degree of column nesting gets its own main text color and border color in the editor as a way to help distinguish to which column a new post is being added, etc.');
	printer::printx('<p class="fsminfo editbackground editfont editcolor">Rearrange Colors that go with your theme towards the top of the color list which most often gets used.');
	print'<p class="'.$this->column_lev_color.' large fsminfo floatleft left editbackground editfont">Drag color box to sort the color order. </p>';
		printer::pclear();
          #################
          ##  class sortEdit initiates gen_Proc.classPass('sortEdit',edit_Proc.makelistSortable,edit_Proc.sendEditOrder);
		echo '<p id="updatePageEdMsg" class="pos editbackground editfont larger "></p>';
		printer::pclear(5);
		echo '<div class="editbackground editfont editcolor"><ul id="sortPageEditor" class="nolist sortEdit" data-id="'.$this->pagename.'" data-inc="1">';
		foreach ($this->color_order_arr as $key => $color){ 
			printer::printx('<li title="'.$color.'" class="floatleft center editcolor pb2 m1all fs2npinfo  '.$color.'background" style="width:50px;height:20px;"  id="sortEditorColor!@!'.$color.'!@!'.$editorref.'">#'.$key.'</li>'); 
			}//end foreach
	print '</ul><!--end gall_center--></div>';
	$this->close_print_wrap('rearrange color view');
	$this->show_close('Rearange '.$editorref.' Column Colors');
	printer::pclear();
	$this->show_more('Add or Adjust '.$editorref.' Column Colors','noback');
	$this->print_wrap('adjust color view');
	printer::print_tip('Basically each successive degree of column nesting gets its own main text color and border color in the editor as a way to help distinguish to which column a new post is being added, etc.');
     printer::printx('<p class="fsminfo editbackground editfont editcolor">Customize your colors by adding your own that work for you. Be sure to give them an unique name</p>');  
     $begin=count($this->color_order_arr);
     for ($i=$begin; $i<$begin+11; $i++){
          printer::alertx('<div class="smaller '.$color.' left editbackground editfont">New Color choose: #<input name="'.$page_color_value_property.'['.$i.']" onclick="jscolor.installByClassName(\'addcolor_array_'.$i.'\');" style="cursor:pointer;background:#'.$this->editor_background.';color:#'.$this->editor_color.';" type="text" id="addcolor_array_'.$i.'"  value="" size="6" maxlength="6" class="addcolor_array_'.$i.' {refine:false}">Add Name:<input type="text" value="" size="20" maxlength="25" name="'.$page_color_order_property.'['.$i.']"></div>');
          }
     $this->submit_button();
     printer::printx('<p class="fsminfo editbackground editfont editcolor">Current color  names and values. You can tweak a color value insteading of adding new.</p>');
	foreach ($this->color_order_arr as $color){
          if (!isset($this->{$color.'_index'}))continue;
		printer::alertx('<p class="smaller '.$color.' left editbackground editfont"> Color Adjust: #<input onclick="jscolor.installByClassName(\'color_array_'.$this->{$color.'_index'}.'\');" style="cursor:pointer;background:#'.$this->editor_background.';color:#'.$this->editor_color.';" type="text" id="color_array_'.$this->{$color.'_index'}.'" name="'.$page_color_value_property.'['.$this->{$color.'_index'}.']"   value="'.$this->$color.'" size="6" maxlength="6" class="color_array_'.$this->{$color.'_index'}.' {refine:false}">'.$color.'</p>'); 
		}
     $this->submit_button();
	$this->close_print_wrap('adjust color view');
     $this->show_close('Color adjust '.$editorref.' Column Colors');
	$this->color_reset();
     $this->submit_button();
	$this->close_print_wrap('Editor colorWrap');
     $this->show_close('Configure Editor Colors');
     printer::pclear();
     $this->show_more('Configure Editor Font Family','noback','','Choose the font style of the Editor Only');
     $this->print_wrap('editor font family');
	printer::printx('<p>Change the Default editor font family style</p>');
	$this->font_family('page_options',$this->page_editor_fontfamily_index,'',true);
	$this->edit_font_family=(!empty($this->page_options[$this->page_editor_fontfamily_index])&&strpos($this->page_options[$this->page_editor_fontfamily_index],'=>')!==false)? str_replace('=>',',',$this->page_options[$this->page_editor_fontfamily_index]):  str_replace('=>',',',$this->edit_font_family);
	//$this->edit_font_family=str_replace(';','!important;',$this->edit_font_family);  
	$this->close_print_wrap('editor font family');
     $this->show_close('Configure Editor Font Family');
     printer::pclear();
     $this->page_editborder=(is_numeric($this->page_options[$this->page_editor_bordersize_index])&&$this->page_options[$this->page_editor_bordersize_index]>=1&&$this->page_options[$this->page_editor_bordersize_index]<=4 )?$this->page_options[$this->page_editor_bordersize_index]:2;  
     $this->show_more('Configure Editor Border Size','noback','','Choose the border size style of the Editor Only');
	$this->print_wrap('editor border size');
	printer::print_tip('The editor border refers to the dotted border wrapping  around columns  and  solid border wrapping around the posts within it acting as color coded guide to keep track of where your at',.8); 
	printer::printx('<p>Change the Default editor border size</p>');
     echo'<p> <select class="editcolor editbackground editfont"  name="page_options['.$this->page_editor_bordersize_index.']">';       
          echo '<option  value="'.$this->page_editborder.'" selected="selected">'.$this->page_editborder.'px</option>';
		for ($i=1;$i<5;$i++){
			echo '<option  value="'.$i.'">'.$i.'px</option>';
			}
	    echo'	
	    </select></p>';
	if (!empty($this->page_options[$this->page_editor_bordersize_index])&&is_numeric($this->page_options[$this->page_editor_bordersize_index]))  $this->edit_border_size=$this->page_options[$this->page_editor_bordersize_index];
	$this->close_print_wrap('editor border size');
	$this->show_close('Configure Editor Font');
	$this->show_more('Configure Editor Font Size','noback','','Choose the font size style of the Editor font size');
	$this->print_wrap('editor font size');
	printer::printx('<p>Change the Default editor font size</p>');
     $this->pelement=' .editfont';
	$this->page_options[$this->page_editor_fontsize_index]=(!empty($this->page_options[$this->page_editor_fontsize_index]))?$this->page_options[$this->page_editor_fontsize_index]:'16';
	$this->font_size('page_options',$this->page_editor_fontsize_index,'',$this->pelement);
	$this->edit_font_size=(!empty($this->page_options[$this->page_editor_fontsize_index])&&is_numeric($this->page_options[$this->page_editor_fontsize_index]))?  $this->page_options[$this->page_editor_fontsize_index]:'16'; 
	$this->close_print_wrap('editor font size');
     $this->show_close('Configure Editor Font');
     $this->close_print_wrap('editor appearance');
	$this->show_close('Edit Mode Style'); 
     echo '</div><!-- float buttons-->';
     }#end editor_appear
   
function configure_editor(){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
     $this->rem_root=($this->page_options[$this->page_rem_unit_index]>=3&&$this->page_options[$this->page_rem_unit_index]<=100)?$this->page_options[$this->page_rem_unit_index]:$this->default_rem;//initialize before editor font choice 
	$this->current_font_size=$page_rem_unit=$this->rem_root; 
     $page_mod_percent=(is_numeric($this->page_options[$this->page_mod_percent_index])&&$this->page_options[$this->page_mod_percent_index]<=400&&$this->page_options[$this->page_mod_percent_index]>=25)? $this->page_options[$this->page_mod_percent_index]: 100; 
     $page_rem_scale_enable=($this->page_options[$this->page_rem_scale_enable_index]!=='page_rem_scale_disable')?true:false;
	$page_rem_scale_upper=(!empty($this->page_options[$this->page_rem_scale_upper_index])&&is_numeric($this->page_options[$this->page_rem_scale_upper_index])&&$this->page_options[$this->page_rem_scale_upper_index]<=Cfg::Col_maxwidth&&$this->page_options[$this->page_rem_scale_upper_index]>=300)?$this->page_options[$this->page_rem_scale_upper_index]:'none';
	$page_rem_scale_lower=(!empty($this->page_options[$this->page_rem_scale_lower_index])&&is_numeric($this->page_options[$this->page_rem_scale_lower_index])&&$this->page_options[$this->page_rem_scale_lower_index]<Cfg::Col_maxwidth*.75)?$this->page_options[$this->page_rem_scale_lower_index]:'none';
     //$this->current_font_em_px=$page_rem_unit;  
     $this->show_more('Enable viewport Responsive rem units');
	$this->print_redwrap('Enable viewport Responsive rem units');
     printer::alert('Current 1 rem full value: '.$page_rem_unit.'px');
	$this->show_more('Tweak default rem value');
     printer::print_redwrap('Tweak rem');
     printer::print_info('Original default rem unit value is '.$this->default_rem.'px');
     printer::alert('Current 1 rem full value: '.$page_rem_unit.'px');
     printer::print_tip('However here you can tweak up or down the overal value of scaled or unscaled rem units when a global rem value change is called for');//			
     $this->mod_spacing('page_options['.$this->page_rem_unit_index.']',$page_rem_unit,4,100,.1,'px');
     printer::close_print_wrap('Tweak rem');
     $this->show_close('Tweak default rem value');
	printer::pspace(5);
	$this->show_more('Rem Scale Info','','highlight italic small');
     printer::print_wrap('rem info');
     printer::print_tip2('Under any spacing or font-size choice you can choose to make a px choice scale responsively, ie smallerize according to the users viewport size, or you can choose other units such as %, em, rem, or vw. Both em and rem units can simlarly be set up to responsizely scale.  Here you can setup rem responsive unit sizing proportional to the viewport sizes over which you wish the rem unit to decreasingly respond in size in a one to one proportion.  However, there is also an option below to modify this one to one relationship if desired');
	printer::print_tip('Enter both an upper and lower viewport range over which the use of rem  scaling is to take place and the system will automatically generate the necessary media queries linked to the hml tag which sets up rem units.  The result of specifying your minimum and maximum range will be a more appropriately scaled rem unit when scaling is required.  For best results the upper size limit should be the size of a viewport which begins to compress your content or more generally no greater than the width of the primary column. Lower end need to be 75px or more less than Upper setting. <b>Find an overview of the various scaling unit options under the Scale Units Overview &amp; Some Basic Pointers on the editor system option just above.</b>');
	printer::close_print_wrap('rem info');
     $this->show_close('Rem Scale Info'); 
	printer::pspace(5);
	
	if ($page_rem_scale_enable)
		printer::alert('<input type="checkbox" name="page_options['.$this->page_rem_scale_enable_index.']" value="page_rem_scale_disable">Disable Rem Scaling');
	else printer::alert('<input type="checkbox" name="page_options['.$this->page_rem_scale_enable_index.']" value="page_rem_scale_enable">Enable Rem Scaling ');
	printer::pspace(10);	
     printer::alert('Enter Viewport Upper Begin Scale Width:');
	$this->mod_spacing('page_options['.$this->page_rem_scale_upper_index.']',$page_rem_scale_upper,300,Cfg::Col_maxwidth,1,'px','none');
     printer::alert('Enter Viewport Lower End Scale Width:'); 
	$this->mod_spacing('page_options['.$this->page_rem_scale_lower_index.']',$page_rem_scale_lower,100,Cfg::Col_maxwidth*.75,1,'px','none');
	#REM #rem
	
     $this->show_more('REM Mod Percent','','smaller editfont editcolor editbackground floatleft');
	$this->print_wrap('mod page percent');
	printer::alert('By default size change will scale one to one with changes in viewport size between the max and min viewport sizes you choose. You can change this default behavior which occurs at a setting 100% to either speed up to 300% and increase the rate of change (ie. ~ 3x smaller) or decrease down to 25% the rate of change to minimizing the final size change to get the exact rate change you need');
     $msgjava='Choose percent rate of change';
	$this->mod_spacing('page_options['.$this->page_mod_percent_index.']',$page_mod_percent,24,400,.1,'%','none',$msgjava);
	$this->close_print_wrap('mod page percent');
	$this->show_close('Page Mod Percent');
     if ($page_rem_scale_enable&&is_numeric($page_rem_scale_upper)&&is_numeric($page_rem_scale_lower)&&(($page_rem_scale_upper-$page_rem_scale_lower)>75)){
          $this->terminal_em_scale=$this->current_em_scale=true;
          $this->rem_scale=true;
          $initrem=$page_rem_unit; #using  px;  
          #$initrem=$page_rem_unit/16*100; #using 100%  
          $this->scale_render(0,$initrem,$page_mod_percent,'auto','html','font-size',$page_rem_scale_upper,$page_rem_scale_lower,'px');
          }
     else  $this->pagecss.='
html {font-size:'.$page_rem_unit.'px}';//set default rem unit size
     printer::pclear(5);
     $this->submit_button();
	printer::close_print_wrap('Enable viewport Responsive rem units');
	$this->show_close('Enable viewport Responsive rem units');
     //$this->page_parallax_css();//not enabled experimental
	$this->show_more('Configure Setting Defaults','noback');
	$this->print_redwrap('settings defaults wrap',true); 
	$this->page_width=($this->page_width >99 && $this->page_width < Cfg::Col_maxwidth)?$this->page_width:Cfg::Page_width;
	echo'<div class="floatleft editbackground editfont fsminfo editcolor" ><!--page width-->Set Default Primary Column Width:';
     printer::print_tip('Optionally Set a max-width Width for primary columns which sets the max-width of primary columns in the absence of a column-setting.  Consistent width between pages lead to consistent navigation transitions. Will also set the width in circumstances of cloned nested columns to a primary column position in a new page. Overriden by other Width choices made in the primary column.  Default page width: '.Cfg::Page_width);
	$this->mod_spacing('page_width',$this->page_width,100,Cfg::Col_maxwidth,1,'px');
	echo'</div><!-- page width-->';
	printer::pclear(5);
	echo'<div class="floatleft editbackground editfont fsminfo left" ><!--page adv-->';
     printer::print_tip('Set whether advanced styles are initially enable or not on edit page. Advanced styles are any custom css that may be manually added under the styling options for each post or styling options for sub features of a post or column and will affect only that post or sub feature. Set to false if advanced styles enabled causes editing difficulty. Advanced styles will always be rendered in normal webpage mode');
     printer::alert('Advanced Styles: Enable or Disable manually added css rendering in Edit Pages.  Use the the buttons at the top or the bottom of the page to toggle Edit Page Css Rendering of Advanced Styles'); 
	$checked2=($this->page_options[$this->page_advanced_index]==='disabled')?'checked="checked"':''; 
	$checked1=($this->page_options[$this->page_advanced_index]!=='disabled')?'checked="checked"':''; 
	printer::alert('<input type="radio" value="enabled" '.$checked1.' name="page_options['.$this->page_advanced_index.']">Default Adv Css On<br>');
	printer::alert('<input type="radio" value="disabled" '.$checked2.' name="page_options['.$this->page_advanced_index.']">Default Adv Css Off');
	printer::pclear();
	echo'</div><!-- page adv-->';
	printer::pclear(5);
     $maxplus=(!empty($this->page_options[$this->page_max_expand_image_index])&&$this->page_options[$this->page_max_expand_image_index]>299)?$this->page_options[$this->page_max_expand_image_index]:Cfg::Page_pic_expand_plus;
     echo'<div class="floatleft editbackground editfont fsminfo"    ><!--expand image-->';
     printer::print_tip('By Default Posted Images when clicked will expand to a preset  width or height max value whichever is larger. Change the Default value  '.$maxplus.'px here which will effect all images on the site that are not specifically configured for this value in the post options configuration. Larger sizes mean slower downloads and use up more disk space');
     printer::alert('Change Expanded Image max width/height setting:');
	$this->mod_spacing('page_options['.$this->page_max_expand_image_index.']',$maxplus,300,2800,1,'px');
	echo'</div><!--expand image-->';
	printer::pclear(5);
     $this->page_image_quality=$quality=(!empty($this->page_options[$this->page_image_quality_index])&&$this->page_options[$this->page_image_quality_index]>10&&$this->page_options[$this->page_image_quality_index]<101)?$this->page_options[$this->page_image_quality_index]:Cfg::Pic_quality;
     echo'<div class="floatleft editbackground editfont fsminfo " title=""  ><!--quality image-->';
	printer::print_tip('By Default Page Images will have a Default Quality factor  with 100 being the highest and 10 the lowest. The higher the image quality the larger the filesize and the slower the download speed. Change the Default value  in the Page Configuration options which will effect all uploaded images on the site that are not specifically configured for this value in the post type: image, slideshow, or gallery configurations');
     printer::alert('Change Current Image Quality setting:');
	$this->mod_spacing('page_options['.$this->page_image_quality_index.']',$quality,10,100,1,'%','','page_quality_show');
	echo '<div id="page_quality_show" class="fsmredAlert hide" >';
	echo '<input type="checkbox" name="page_quality" value="1">Update all images without local quality setting to newly chosen default setting on this page<br>';
	echo '<input type="checkbox" name="site_quality" value="1">Update newly chosen setting to all page configs<br>';
	echo '<input type="checkbox" name="site_quality_update" value="1">Update newly chosen setting to all pages and resize all site images that are not localled configured for quality<b>(can take few minutes on slow connections)</b>';
     echo '</div><!--page_quality_show-->';
	echo'</div><!--quality image-->';
	printer::pclear(5);
     $this->backupinst->backup_copies=$this->storeinst->backup_copies=$this->backup_copies;
     echo'<div class="floatleft editbackground editfont fsminfo " title=""  ><!--expand image-->';
     printer::print_tip('By Default 100 full database backups are stored as sql.gz compressed files everytime a post is submitted with changes and are available for viewing and restoring. Choose more or less copies depending on your disk space');
     printer::alert('Change the number of backup copies saved:');
	$this->mod_spacing('page_options['.$this->page_backup_copies_index.']',$this->backup_copies,20,1000,1,' copies');
	echo'</div><!--expand image-->';
     printer::pclear(20);
	$this->close_print_wrap('settings defaults wrap');
	$this->show_close('Configure Setting Defaults');
	printer::pclear();
     }//end function configure editor
}//end class
?>