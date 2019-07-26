<?php
#ExpressEdit 2.0.4
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

#note: display property and advanced styles use css #id to override normal styles which use distinct classnames    
#info
#width# find #width# for various width info
#style# find overview of style mechanism info
#flatfile# flatfile info for main system
#blogrender# function blog_render is the central method of the system
#for reasons of size and content grouping the main class was broken up to four classes...
#the extended main class is broken into 4 classes with each  limited to under ~7000 lines for quick editing in komodo edit 8.5 ::  global_master  extends global_edit_master  extends global_post_master extends global_process_master
class global_edit_master extends global_post_master{
	protected $blog_drop_array=array(	'New Column Here',
								'New Text',
								'New Image',
								'New Left Image-Text Wrap',
								'New Right Image-Text Wrap',
								'New Video/Iframe', 
								'New Contact Form',
								'New Social Icon Links',
								'New Auto Slide Show',
								'New Gallery',
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
	protected $default_blog_text='Ready for Action. Put Your Text Here. Posts will not appear on the webpage till you Check the Publish Box!';
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
	protected $file_generate_css=false;#will generate css for all pages file_generator::file_generate(true,false);// css  file generate after update
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
	protected $position_arr=array('center_row','center_float','left_float','right_float','left_float_no_next','right_float_no_next','center_float_no_next');
	protected $position_val_arr=array('center row','center float','left float','right float','left float no next','right float no next','center float no next');
	protected $table_prefix='table_';
	static protected  $col_count=1;
	static protected  $xyz=1;
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
	(Sys::Deltatime)&&$this->deltatime->delta_log(__LINE__.' @ '.__method__.'  ');
     $_SESSION['write_to_file']=array();
     $this->editpages_obj($this->master_page_table,'page_id,'.Cfg::Page_fields,'','page_ref',$this->pagename,'','','all','',",page_time=".time().",token='". mt_rand(1,mt_getrandmax())."', page_update='".date("dMY-H-i-s")."'");
     
     $this->generate_bps(); 
	$this->page_populate_options();//separately called  in non edit pages 
     $this->page_grid_units=(is_numeric($this->page_options[$this->page_grid_units_index])&&$this->page_options[$this->page_grid_units_index]>11&&$this->page_options[$this->page_grid_units_index]<101)?intval($this->page_options[$this->page_grid_units_index]):100;
     $this->color_populate();
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
	if (isset($_POST['copy_to_clipboard']))$this->copy_to_clipboard();
	if (isset($_POST['paste_from_clipboard']))$this->paste_from_clipboard();
	if (isset($_POST['page_iframe_all']))$this->page_iframe_all();
	if (isset($_POST['page_iframe_all_website']))$this->page_iframe_all_website();
	if (isset($_POST['cache_regenerate']))$this->cache_regenerate();
	if (isset($_POST['cache_regenerate_flatfiles']))$this->cache_regenerate_flatfiles();
	if (isset($_POST['submitted']))$this->process_col();
	if (isset($_POST['delete_blog_clunc']))$this->process_delete_clunc(); 
	if (isset($_POST['col_transfer_clone']))$this->process_col_transfer_clone();
	if (isset($_POST['force_color_reset']))$this->force_color_reset();  
	if (isset($_POST['gallpicsubmitted'])){
		$addgallery=addgallery::instance();
		$addgallery->submitted();
		}
	if (isset($_POST['file_generate_site'])){
		$msg=file_generator::file_generate(false,true,false);
		if ($msg==='success')$this->success[]='files successfully generated';
		}
	if (isset($_POST['page_class_generate'])){
		$msg=file_generator::update_page_class();
		if ($msg==='success')$this->success[]='files successfully generated';
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
	$this->pre_render_data();
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
     $this->tool_man_init();
	$this->tinymce();
	$this->gen_Proc_init(); 
	$this->header_close();
     $this->column_lev_color=$this->color_arr_long[0]; 
	$this->edit_body();  
	(Sys::Deltatime)&&$this->deltatime->delta_log('End Edit body '.__LINE__.' @ '.__method__.'  ');
	if (isset($_POST['submitted'])){
		$this->backupinst->backup_copies=$this->backup_copies;//configurable in page settings..
		$this->backup();//it gatheres the master pagename and makes sure not a blog pagename...
		(Sys::Deltatime)&&$this->deltatime->delta_log('Begin backup check clone  '.__LINE__.' @ '.__method__.'  ');
		//$this->backupinst->backup_check_clone($this->backup_page_arr);//not necessary with new system
		(Sys::Deltatime)&&$this->deltatime->delta_log('End backup check clone  '.__LINE__.' @ '.__method__.'  ');
		}
	 ($this->file_generate_css)&& file_generator::file_generate(true,false); 
	$this->render_css();//after edit page has rendered.
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
     $this->java_page_iframe_all();
     foreach ($this->express as $msg){
          echo NL.$msg;
          }
	$this->edit_form_head();  
	$this->echo_msg();//will echo success msgs  //submit call in destructor to collect all mgs
	echo <<<eol
     <script>
	jQuery("document").ready(function(\$){
		var scrollTimer='';
	setTimeout(function(){	\$('#displaycurrentsize').css({'width':\$('#displaycurrentsize').width()*1.2+'px'});
       },50);
	   \$(window).scroll(function () {
		clearTimeout(scrollTimer);
		scrollTimer = setTimeout(function(){ //this will limit no of scroll events responding but may delay appearance of down arrow
               if (\$(this).scrollTop() > 30) {  
				\$('#topmenu,#topoutmenu, #botmenu, #botoutmenu,#displayCurrentSize2').removeClass("hide");   
										\$('#displayCurrentSize2').css({'position':'fixed','top':'0px','left':'30px','z-index':'100000'});
				}
			else if(\$(this).scrollTop() < 30) {
				\$('#topmenu,#topoutmenu,#botoutmenu,#botmenu,#displayCurrentSize2').addClass("hide");    
				}
				
			},20);
        }); 
});
</script>
eol;
	echo '<div id="topconfig">
	<div id="topoutmenu" title="Page Top" class="hide" onclick="window.scrollTo(0,0);return false;">&#9650;</div><div id="toprefresh"><a title="refresh page url  NO RESUBMIT" href="'.Sys::Self.'"><img  src="'.Cfg_loc::Root_dir.'refresh_button.png" alt="refresh button" width="15" height="15"></a></div><div id="topmenu" title="Page Top" class="hide"><p id="gotop" onclick="window.scrollTo(0,0);return false;">&#9650;</p><p id="topunder"><a title="refresh page url" href="'.Sys::Self.'"><img  src="'.Cfg_loc::Root_dir.'refresh_button.png" alt="refresh button" width="15" height="15"></a></p></div><!--close topmenu-->
			<div id="botoutmenu" class="hide" title="Page bottom" onclick="window.scrollTo(0,100000);return false;">&#9660;</div><div id="botmenu" class="hide" title="Page bottom" onclick="window.scrollTo(0,100000);return false;">&#9660;</div>';
	echo '<div id="top_contain" class="showclass">'; 
	$this->uploads_spacer();
     $this->browser_size_display();
	$this->top_submit();
     $this->display_anchor(); 
	$this->track_font_em($this->page_style);
	$this->generate_cache();
	$this->add_new_page();
	$this->configure();
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
	echo '</div><!--close topfix--></div><!--close contain configs-->';
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
     
function advanced_button(){
     ##################### advance off button
	echo '<div class="inline floatleft"><!-- float buttons-->';
	$msg='Advanced Style Css refers to custom css manually added at the bottom of the style options. You can change the default status of whether advances css is expressed in editmode under configure settings then toggle on or off here as needed. Please note some editor default styles may overwrite advanced css so always check results in webpage mode';
	if (!Sys::Advanced) 
		printer::printx('<p class="click buttoninfo highlight editfont tiny" title="'.$msg.'"> <a style="color:inherit;" href="'.Sys::Self.'?advanced">Display Adv CSS in Editmode</a></p>');
	else printer::printx('<p class="info click buttoninfo highlight tiny" title="'.$msg.'"> <a style="color:inherit;"  href="'.Sys::Self.'?advancedoff">Disable Display Adv CSS in Editmode</a></p>'); 
	echo '</div><!-- float buttons-->';
     }

function debug_activate(){
     ##################### advance off button
	echo '<div class="inline floatleft"><!-- float buttons-->';
	$this->show_more('Debug Tools','',$this->column_lev_color.' smallest editbackground editfont button'.$this->column_lev_color,'','','','','asis');
	printer::print_wrap('configure wrap',true); 
     printer::alert('<a class="info" title="Turn off all active debug queries" href="'.Sys::Self.'?alloff">All Debug Queries off</a>');
     printer::alert('<a class="info" title="Submitted Page refreshes to update css. Will prevent this to show submitted $_POST array and mysql queries and any error msg" href="'.Sys::Self.'?norefresh">Prevent Submitted Page Refresh</a><a href="'.Sys::Self.'?norefreshoff">&nbsp;&nbsp;<span class="underline cursor">Off</span></a>');
     printer::alert('<a class="info" title="Show Request" href="'.Sys::Self.'?request&amp;#requested">Show Requests </a><a href="'.Sys::Self.'?requestoff">&nbsp;&nbsp;<span class="underline cursor">Off</span></a>');
     printer::alert('<a class="info" title="Show called methods" href="'.Sys::Self.'?methods&amp;#bottom">Show Methods Called </a><a href="'.Sys::Self.'?methodsoff">&nbsp;&nbsp;<span class="underline cursor">Off</span></a>');
     printer::alert('<a class="info" title="Show mysqli calls" href="'.Sys::Self.'?mysql">Show Mysql Calls </a><a href="'.Sys::Self.'?mysqlsoff">&nbsp;&nbsp;<span class="underline cursor">Off</span></a>');
     printer::alert('<a class="info" title="Show constants" href="'.Sys::Self.'?constants&amp;#bottom">Show constants</a><a href="'.Sys::Self.'?contantsoff">&nbsp;&nbsp;<span class="underline cursor">Off</span></a>');
     printer::alert('<a class="info" title="Show Session" href="'.Sys::Self.'?session&amp;#bottom">Show session info </a><a href="'.Sys::Self.'?sessionoff">&nbsp;&nbsp;<span class="underline cursor">Off</span></a>');
     printer::alert('<a class="info" title="Show included files" href="'.Sys::Self.'?includes&amp;#bottom">Show included files </a><a href="'.Sys::Self.'?includesoff">&nbsp;&nbsp;<span class="underline cursor">Off</span></a>');
     printer::alert('<a class="info" title="Show delta time take for methods to run" href="'.Sys::Self.'?deltatime&amp;#bottom">Clock Method Rendering on Server </a><a href="'.Sys::Self.'?deltatimeoff">&nbsp;&nbsp;<span class="underline cursor">Off</span></a>'); 
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
	echo '<div class="inline floatleft"><!-- float buttons-->';
	$msg='Click Button to enlarge borders and add margin and padding spacing in order to better see column arrangement. In certain circumstance can cause a floated post to break to new line';
     if (!isset($_GET['magnify_margins']))
          printer::printx('<p class="info click buttoninfo highlight tiny" title="'.$msg.'"> <a style="color:inherit;"  href="'.Sys::Self.'?magnify_margins">Enable Margin Magnify</a></p>');
     else 
          printer::printx('<p class="info click buttoninfo highlight tiny" title="'.$msg.'"> <a style="color:inherit;"  href="'.Sys::Self.'">Disable Margin Magnify</a></p>'); 
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
							$q='select '.$field_array[$x]." from $master_table WhErE $ref1 ='$refval1' $where2 $where3";    
							$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);  
							list($c_val)=$this->mysqlinst->fetch_row($r,__LINE__);
							 
							${$field_array[$x]}=process_data::implode_retain_vals($_POST[$post_prepend.$field_array[$x].$check_suffix],$c_val,',','@@'); 
							}
						
						else ${$field_array[$x]}=process_data::spam_scrubber($_POST[$post_prepend.$field_array[$x].$check_suffix]);//chdnged from blog_check.$field_array.$check_suffix
						$update.=" {$field_array[$x]}='${$field_array[$x]}',"; 
						}
					 }
				}
			if ($update=== 'SET '&& $do_all!=='all')return;
			elseif ($update!= 'SET '){  
				$update=substr_replace($update ,"",-1);     
				$q="UPDATE $master_table $update $update2 WherE $ref1 ='$refval1' $where2 $where3";    ($print)&&printer::alert_pos($q. '  q is',1.5); 
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
      
function color_populate(){
	$this->page_options[$this->page_darkeditor_background_index]=(preg_match(Cfg::Preg_color,$this->page_options[$this->page_darkeditor_background_index]))?$this->page_options[$this->page_darkeditor_background_index]:'000000';
	$this->page_options[$this->page_darkeditor_color_index]=(preg_match(Cfg::Preg_color,$this->page_options[$this->page_darkeditor_color_index]))?$this->page_options[$this->page_darkeditor_color_index]:'F7FDFF';
	$this->page_options[$this->page_lighteditor_background_index]=(preg_match(Cfg::Preg_color,$this->page_options[$this->page_lighteditor_background_index]))?$this->page_options[$this->page_lighteditor_background_index]:'ffffff';
	$this->page_options[$this->page_lighteditor_color_index]=(preg_match(Cfg::Preg_color,$this->page_options[$this->page_lighteditor_color_index]))?$this->page_options[$this->page_lighteditor_color_index]:'000000';
	if ($this->page_options[$this->page_editor_choice_index]==='dark') : 
		$indexes=explode(',',Cfg::Dark_editor_color_order);
		foreach($indexes as $key =>$index){
			if (!empty($index)) {
				$this->{$index.'_index'}=$key; 
				 //  print NL.  $index." = $key";  
				}
			}  
		$config_darkeditor_arr=explode(',',Cfg::Dark_editor_color_order);
		$count=count($config_darkeditor_arr);
		$this->page_dark_editor_value=(empty($this->page_dark_editor_value))?array():explode(',',$this->page_dark_editor_value);
		$color_order=($count===count(explode(',',$this->page_dark_editor_order)))?$this->page_dark_editor_order:Cfg::Dark_editor_color_order; 
		foreach($config_darkeditor_arr as $key => $color){
			if (!isset($this->$color)){
				$msg="Error: Unconfigured color value for  $color being temporarily set to black";
				$this->message[]=$msg;
				$this->$color='000000';
				}
			$this->{$color.'_index'}=$key; 
			if (array_key_exists($key,$this->page_dark_editor_value)&&preg_match(Cfg::Preg_color,$this->page_dark_editor_value[$key])) 
				$this->$color=$this->page_dark_editor_value[$key];
			else {
				$this->page_dark_editor_value[$key]=$this->$color;
				$this->hidden_array[]='<input class="allowthis" type="hidden" name="page_dark_editor_value['.$key.']" value="'.$this->$color.'">';
				} 	
			}
		$this->editor_background=$this->page_options[$this->page_darkeditor_background_index];
		$this->editor_color=$this->page_options[$this->page_darkeditor_color_index];
	else :
		$indexes=explode(',',Cfg::Light_editor_color_order);
		foreach($indexes as $key =>$index){
		if (!empty($index)) {
			$this->{$index.'_index'}=$key; 
			  //  print NL.  $index." = $key";  
			}
		} 
		$config_lighteditor_arr=explode(',',Cfg::Light_editor_color_order);
		$count=count($config_lighteditor_arr);
		$this->page_light_editor_value=(empty($this->page_light_editor_value))?array():explode(',',$this->page_light_editor_value);
		$color_order=($count===count(explode(',',$this->page_light_editor_order)))?$this->page_light_editor_order:Cfg::Light_editor_color_order;  
		foreach($config_lighteditor_arr as $key => $color){
			if (!isset($this->$color)){
				$msg="Error: Unconfigured color value for  $color being temporarily set to black";
				$this->message[]=$msg;
				$this->$color='000000';
				}
			$this->{$color.'_index'}=$key; 
			if (array_key_exists($key,$this->page_light_editor_value)&&preg_match(Cfg::Preg_color,$this->page_light_editor_value[$key])) 
				$this->$color=$this->page_light_editor_value[$key];
			else {
				$this->page_light_editor_value[$key]=$this->$color;
				$this->hidden_array[]='<input class="allowthis" type="hidden" name="page_light_editor_value['.$key.']" value="'.$this->$color.'">';
				} 
			}
		$this->editor_background=$this->page_options[$this->page_lighteditor_background_index];
		$this->editor_color=$this->page_options[$this->page_lighteditor_color_index];
	endif;
	$this->color_order_arr=explode(',',$color_order); 
	$this->color_arr_long=$this->color_order_arr;//explode(',',substr_replace(str_repeat($color_order.',',3),'',-1)); 
	}//end function
     
function top_submit(){if(Sys::Custom)return;if (Sys::Quietmode||Sys::Pass_class) return;
	echo '<div class="inline floatleft"><!-- float buttons-->';
	echo'  <p><input class="editbackground editfontfamily '.$this->column_lev_color.' shadowoff cursor  smallest buttoneditcolor"   type="submit" name="submit"   value="submit All" ></p>';
	echo '</div><!--float buttons-->'; 
	} 
 
function editor_overview(){if (Sys::Quietmode) return;
	$scaling='Responsive units are totally optional and often unnecessary to set up. However they can also be quite useful. There are 3 basic ways to set up responsize scaling of rem em and px units so that the widths paddings borders and font sizes they specify will smallerize on progressively smaller screen sizes. To make scaling more relevant you can choose the upper and lower widths over which scaling is to take place. Each scaling choice also allows for a modification of the one to one scaling. Smallerization is done  automatically through @media queries over the range of sizes of upper and lower screen widths you choose. <br><br>
     The first scaling choice is for rem which is always linked to  font-size directly under the html tag and and found just below. If no scaling is chosen each rem unit choice specifies an original default value 16px per unit of size by default for any width, font, padding, or margin, etc. choice. However, you can increase or decrease this rem unit size directly affecting all rem unit values on the page. Moreso, by choosing to scale the value of a rem unit the absolute width value will decrease  proportionally to user view screen width. <br> However a one to one relationship between width and view screen doesnt suffice in all circumstances. This relationship is adjusted in the rem scaling (for rem units) and the rwd scale (for px units that also effect em size when done to font units.<br><br>Setting up  em scaling and customization is done similarly  except this option is tied to the font-size choices you make in the default page styles you make under page options, and under column font-styles settings. These choices will affect all em choices made in child posts. Please Note em settings are compoundable meaning em units themselves mulitply a parent em value if previously chosen.  <br><br>
So the actually scalability of em units is made through font-size choice as initially setup under the page options or in any column by choosing font-size px, then choose the rwd_scale option, the relavent upper and lower widths at which scaling takes place and any modification of one to one relationship that may better suit you needs. Note em compoundabilty ends when a new font-size  choice is made not directly in em units.<br><br>
Lastly scaling may be set up directly in any width, padding, margin, border, and other options in any post or column for needs that are not met by currently scaled em or rem choices in much the same way,  by choosing font size and then rwd scale options.';   
$instructions=' 
Hover Over <span class="highlight" title="hovering over this color text having white background will reveal more info">Highlighted Text</span> for More Information on choosing Options. Each post may be edited for styles including background colors, text colors, text size, and many more.  Use an optional grid percentage system. Each grid is one percent by default. Or instead of choosing a grid system width restrictions on a post may be implemented for  "floating" multiple posts including nested columns of posts next to another instead of below. For example  align a text post next to an image posts if the width of both adds up to less than than the total width of the parent column. If your not using the grid system, Check the float checkbox in each post, whether image or text. Limit the width of the text, and if the overall width permits it will happen!';
	printer::print_tip($scaling); 
	printer::alert($instructions);
     printer::print_tip('Configure a few general default styles in page options which  can be later changed as individiual columns and posts require.   
	<br>  
	To enable consistent navigation between pages it is a good idea to to set all your webpages to the same width, so that navigation menus line up in same place page to page. Use import and export page options to standardize pages if needed.  
	<br> 
	Make multiple changes on various posts, then Hit a Change All button below to submit them all at once.  
	<br> 
	-paste complex text from WORD or other editors into the post editor text box to retain spacing<br> 
	');
	}

     
function token_gen(){
	return mt_rand(1,mt_getrandmax());
	}
     

     
function view_page(){ if (Sys::Quietmode)return;  
	echo '<div class="inline floatleft"><!-- float buttons-->';
	$this->navobj->return_url($this->pagename,'','white darkslatebluebackground rad5 tiny buttondarkslateblue');
	echo '</div><!--float buttons-->';
	}
function leftover_view(){
	echo '<div class="inline floatleft" id="handle_leftovers" ><!-- float buttons-->';
	if(!isset($_SESSION[Cfg::Owner.'_'.$this->pagename.'_leftovers'])){
		echo '</div>';
		return;
		} 
	echo '</div><!--float buttons-->';
	}
function restore_backup(){if (Sys::Quietmode) return;  if (Sys::Pass_class)return;
	echo '<div class="inline floatleft"><!-- float buttons-->';
	echo '<p class="smallest  editbackground editfont buttoneditcolor click" title="View and restore saved backedup databases Here" onclick="gen_Proc.toggleClass2(\'#display_backups\',\'hide\');gen_Proc.use_ajax(\''.Sys::Self.'?display_backups\',\'handle_replace\',\'get\');" >Display Backup List</p>';
	printer::pclear();
	echo '<div id="display_backups" class="hide">'; 
	$this->submit_button('Submit Backup choice');
	echo'</div>'; 
	echo '</div><!--float buttons-->';
	}

     function display_themes($msg){if (Sys::Quietmode) return;  if (Sys::Pass_class)return;
	echo '<div class="inline floatleft"><!-- float buttons-->';
	echo '<p class="'.$this->column_lev_color.' smallest  editbackground editfont buttoneditcolor click" title="View and restore saved backedup databases Here" onclick="gen_Proc.toggleClass2(\'#theme_choice\',\'hide\');gen_Proc.use_ajax(\''.Sys::Self.'?theme_choice\',\'handle_replace\',\'get\');" >'.$msg.'</p>';
	printer::pclear();
	echo '<div id="theme_choice" class="hide">'; 
	$this->submit_button('Submit Theme choice');
	echo'</div>'; 
	echo '</div><!--float buttons-->';
	}
     
function display_nav(){if (Sys::Quietmode) return;  if (Sys::Pass_class)return;
	echo '<div class="inline floatleft"><!-- float buttons-->';
	echo '<p class="'.$this->column_lev_color.' smallest  editbackground editfont buttoneditcolor click"  onclick="gen_Proc.toggleClass2(\'#display_fullnav\',\'hide\');gen_Proc.use_ajax(\''.Sys::Self.'?display_fullnav\',\'handle_replace\',\'get\');" >Full Nav</p>';
	echo '<div id="display_fullnav" class="hide small width100 left floatleft fsminfo editbackground editfont editcolor"></div>';  
	echo '</div><!--float buttons-->';
	}
     
function display_anchor(){if (Sys::Quietmode) return;  if (Sys::Pass_class)return; 
	echo '<div class="inline floatleft"><!-- float buttons-->';
	echo '<p class="'.$this->column_lev_color.' smallest  editbackground editfont buttoneditcolor click"  onclick="gen_Proc.toggleClass2(\'#display_anchor\',\'hide\');gen_Proc.use_ajax(\''.Sys::Self.'?display_anchor\',\'handle_replace\',\'get\');" >GoTo Anchors</p>';
	echo '<div id="display_anchor" class="hide small left floatleft fsminfo editbackground editfont editcolor"></div>';  
	echo '</div><!--float buttons-->';
	}
     

function browser_size_display(){if (!Sys::Info&&!$this->edit)return;
	$background=($this->edit)?'editbackground editfont':'whitebackground';
	$style=(!$this->edit)?'style="position:fixed;top:0px; left:0px;z-index:1000000"':'';
	$class1=(!$this->edit)?'hide':'';
	$class2=($this->edit)?'hide':'';
	echo '<div id="displayCurrentSize"  class="'.$class1.' editfontfamily floatleft smallest buttoneditcolor rad5 editbackground editcolor"><!-- float buttons-->
	<div class="editfontfamily editcolor editbackground "><p id="clientw"></p>
	</div>
	</div><!--float buttons-->';
	echo '<div id="displayCurrentSize2" '.$style.' class="'.$class2.' editfontfamily whitebackground "><p id="clientw2"></p>
	</div>';
	}
function generate_cache($cache='',$resize=false){   
		$this->page_cache=(empty($cache))?trim($this->page_cache):trim($cache);
	if (!empty($this->page_cache)){
		$pattern='/\s+/';
		$this->page_cache=preg_replace($pattern,'',$this->page_cache); 
		$this->page_cache_arr=explode(',',$this->page_cache);
		$page_cacheupdate_arr=array();
		foreach($this->page_cache_arr as $ext){ 
			if (is_numeric($ext)&&trim($ext) > 99&&trim($ext) < 2401){ 
				$page_cacheupdate_arr[]=($ext); 
				}
			else {  
				$msg='Error in Cache: '.$ext.' cache dir size must be greater than 99 and less than 2401';
				$this->message[]=$msg; 
				}
			}//end foreach
		$this->page_cache_arr=$page_cacheupdate_arr;
		}//not empty
	else { 
		$this->page_cache_arr=explode(',',Cfg::Image_response );
		}
	sort($this->page_cache_arr);
	if ($resize) return $this->page_cache_arr;
	if (implode(',',$this->page_cache_arr)!==$this->page_cache){  
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

#pageimport
function page_import_export_options(){
     $page_configs='Rem Units, RWD bps, Image Cache Sizes, Default Primary Column Width, Editor Colors, Special Class Styles';
	echo '<div class="inline floatleft"><!-- float buttons-->';
     $this->show_more('Port Page Opts','noback',$this->column_lev_color.' smallest editbackground editfont button'.$this->column_lev_color,'Import  Page options from another page or export chosen option of this page to all other pages',600);
	$this->print_wrap('import page options',true);
	echo '<div class="fsmcolor Os3darkslategray editbackground editfont floatleft" ><!--import page defaults-->Import the Page Level Settings ie('.$page_configs.')  from Another Page (Will Not Import Page Slide show). ';  
	printer::pclear(1);
	$included_arr=array();
	$q="select distinct page_ref, page_title, page_filename from $this->master_page_table";  
	$r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	while (list($page_ref,$title,$filename) = $this->mysqlinst->fetch_row($r,__LINE__)){
		$included_arr[]=array($page_ref,$title);
		}
	echo'<p> <select class="editcolor editbackground editfont"  name="page_opts_import['.$this->page_ref.']">';       
     echo '<option  value="none" selected="selected">Choose Page for full Page level opts/styles</option>';
     for ($i=0;$i<count($included_arr);$i++){
          echo '<option  value="'.$included_arr[$i][0].'">ref:'.$included_arr[$i][0].' &nbsp;&nbsp;&nbsp;title: '.$included_arr[$i][1].'</option>';
          }
     echo'	
     </select></p>';
     echo '</div><!--import page defaults-->';
     printer::pclear(); 
     echo '<div class="fsmcolor Os3darkslategray editbackground editfont left "><!--export-->Export All Page Settings ('.$page_configs.') from this Page to all other Pages';
     printer::printx( '<p class="editcolor editbackground editfont" ><input class="editcolor editbackground editfont" name="page_opts_export['.$this->page_ref.']"  type="checkbox" value="'.$this->page_ref.'">Export These Page Level Settings to other Pages</p>'); 
     echo '</div><!--export-->';
     printer::pclear();
     echo '<div class="fsmcolor Os3darkslategray editbackground editfont left "><!--import-->Import Page Width from another page. ';
     echo'<p> <select class="editcolor editbackground editfont"  name="page_width_import['.$this->page_ref.']">';       
     echo '<option  value="none" selected="selected">Choose Page for Import of Page Width </option>';
     for ($i=0;$i<count($included_arr);$i++){
          echo '<option  value="'.$included_arr[$i][0].'">ref:'.$included_arr[$i][0].' &nbsp;&nbsp;&nbsp;title: '.$included_arr[$i][1].'</option>';
          }
     echo'	
     </select></p>';
     echo '</div>'; 
     echo '<div class="fsmcolor Os3darkslategray editbackground editfont left "><!--export-->Export Page Width settings from this Page to all other Pages';
     printer::printx( '<p class="editcolor editbackground editfont" ><input class="editcolor editbackground editfont" name="page_width_export['.$this->page_ref.']"  type="checkbox" value="'.$this->page_ref.'">Export this Page Width to other Pages</p>'); 
     echo '</div><!--export-->'; 
     echo '<div class="fsmcolor Os3darkslategray editbackground editfont left "><!--import-->Import RWD Grid Break Points from another page. ';
     echo'<p> <select class="editcolor editbackground editfont"  name="page_rwd_import['.$this->page_ref.']">';       
     echo '<option  value="none" selected="selected">Choose Page for Import of RWD break point settings </option>';
     for ($i=0;$i<count($included_arr);$i++){
          echo '<option  value="'.$included_arr[$i][0].'">ref:'.$included_arr[$i][0].' &nbsp;&nbsp;&nbsp;title: '.$included_arr[$i][1].'</option>';
          }
     echo'	
     </select></p>';
     echo '</div>'; 
     echo '<div class="fsmcolor Os3darkslategray editbackground editfont left "><!--export-->Export RWD Grid Break Points settings from this Page to all other Pages';
     printer::printx( '<p class="editcolor editbackground editfont" ><input class="editcolor editbackground editfont" name="page_rwd_export['.$this->page_ref.']"  type="checkbox" value="'.$this->page_ref.'">Export this Page RWD Grid Break Points to other Pages</p>'); 
     echo '</div><!--export-->'; 
     echo '<div class="fsmcolor Os3darkslategray editbackground editfont left "><!--export-->';
     printer::printx( '<p class="editcolor editbackground editfont" ><input class="editcolor editbackground editfont" name="page_grid_unit_export['.$this->page_ref.']"  type="checkbox" value="'.$this->page_ref.'">Export Number of Units in Grid from this Page to all other Pages</p>'); 
     echo '</div><!--export-->'; 
     echo '<div class="fsmcolor Os3darkslategray editbackground editfont left "><!--import-->Import HTag and Class Special Styles from another page. ';
     echo'<p> <select class="editcolor editbackground editfont"  name="page_special_class_import['.$this->page_ref.']">';       
     echo '<option  value="none" selected="selected">Choose Page for Import of HTag and Class Special Styles settings </option>';
     for ($i=0;$i<count($included_arr);$i++){
          echo '<option  value="'.$included_arr[$i][0].'">ref:'.$included_arr[$i][0].' &nbsp;&nbsp;&nbsp;title: '.$included_arr[$i][1].'</option>';
          }
     echo'	
     </select></p>';
     echo '</div>'; 
     echo '<div class="fsmcolor Os3darkslategray editbackground editfont left "><!--export-->Export RWD Grid Unit setting from this Page to all other Pages';
     printer::printx( '<p class="editcolor editbackground editfont" ><input class="editcolor editbackground editfont" name="page_option['.$this->page_grid_units_index.']"  type="checkbox" value="'.$this->page_ref.'">Export this Page  RWD Grid Break Points to other Pages</p>'); 
     echo '</div><!--export-->'; 
     echo '<div class="fsmcolor Os3darkslategray editbackground editfont left "><!--export-->Export HTag and Class Special Styles from this Page to all other Pages';
     printer::printx( '<p class="editcolor editbackground editfont" ><input class="editcolor editbackground editfont" name="page_special_class_export['.$this->page_ref.']"  type="checkbox" value="'.$this->page_ref.'">Export this Page HTag and Class Special Styles to other Pages</p>'); 
     echo '</div><!--export-->'; 
     ######################################################
     echo '<div class="fsmcolor Os3darkslategray editbackground editfont left "><!--import-->Import Editor Colors from another page. ';
     echo'<p> <select class="editcolor editbackground editfont"  name="page_editor_color_import['.$this->page_ref.']">';       
     echo '<option  value="none" selected="selected">Choose Page for Import of Editor Colors settings </option>';
     for ($i=0;$i<count($included_arr);$i++){
          echo '<option  value="'.$included_arr[$i][0].'">ref:'.$included_arr[$i][0].' &nbsp;&nbsp;&nbsp;title: '.$included_arr[$i][1].'</option>';
          }
     echo'	
     </select></p>';
     printer::pclear();
     echo '</div>'; 
     printer::pclear();
     echo '<div class="fsmcolor Os3darkslategray editbackground editfont left "><!--export-->Export Editor Colors from this Page to all other Pages';
     printer::printx( '<p class="editcolor editbackground editfont" ><input class="editcolor editbackground editfont" name="page_editor_color_export['.$this->page_ref.']"  type="checkbox" value="'.$this->page_ref.'">Export this Page  Editor Colors to other Pages</p>');
     printer::pclear();
     echo '</div><!--export-->';
     printer::pclear();
     #######################################
     echo '<div class="fsmcolor Os3darkslategray editbackground editfont left "><!--import-->Import Default Page styles from another page. ';
     echo'<p> <select class="editcolor editbackground editfont"  name="page_style_import['.$this->page_ref.']">';       
     echo '<option  value="none" selected="selected">Choose Page for Import of Default Page Style settings </option>';
     for ($i=0;$i<count($included_arr);$i++){
          echo '<option  value="'.$included_arr[$i][0].'">ref:'.$included_arr[$i][0].' &nbsp;&nbsp;&nbsp;title: '.$included_arr[$i][1].'</option>';
          }
     echo'	
     </select></p>';
     echo '</div>'; 
     echo '<div class="fsmcolor Os3darkslategray editbackground editfont left "><!--export-->Export Default Page styles from this Page to all other Pages';
     printer::printx( '<p class="editcolor editbackground editfont" ><input class="editcolor editbackground editfont" name="page_style_export['.$this->page_ref.']"  type="checkbox" value="'.$this->page_ref.'">Export this Page  Default Page Styles to other Pages</p>'); 
     echo '</div><!--export-->';
     ################################################
     echo '<div class="fsmcolor Os3darkslategray editbackground editfont left "><!--import-->Import Image Cache Sizes from another page. ';
     echo'<p> <select class="editcolor editbackground editfont"  name="page_cache_import['.$this->page_ref.']">';       
     echo '<option  value="none" selected="selected">Choose Page for Import of Image Cache Sizes </option>';
     for ($i=0;$i<count($included_arr);$i++){
          echo '<option  value="'.$included_arr[$i][0].'">ref:'.$included_arr[$i][0].' &nbsp;&nbsp;&nbsp;title: '.$included_arr[$i][1].'</option>';
          }
     echo'	
     </select></p>';
     echo '</div>'; 
     echo '<div class="fsmcolor Os3darkslategray editbackground editfont left "><!--export-->Export Image Cache Sizes from this Page to all other Pages';
     printer::printx( '<p class="editcolor editbackground editfont" ><input class="editcolor editbackground editfont" name="page_cache_export['.$this->page_ref.']"  type="checkbox" value="'.$this->page_ref.'">Export this Page Image Cache Sizes to other Pages</p>'); 
     echo '</div><!--export-->';
     echo '<div class="fsmcolor Os3darkslategray editbackground editfont left "><!--export-->Export Image Quality Setting from this Page to all other Pages';
     printer::printx( '<p class="editcolor editbackground editfont" ><input class="editcolor editbackground editfont" name="page_image_quality_export['.$this->page_ref.']"  type="checkbox" value="'.$this->page_ref.'">Export this Page Export Image Quality to other Pages</p>'); 
     echo '</div><!--export-->';
     echo '<div class="fsmcolor Os3darkslategray editbackground editfont left "><!--export-->Export the number of Backup Db copies from this Page to all other Pages';
     printer::printx( '<p class="editcolor editbackground editfont" ><input class="editcolor editbackground editfont" name="page_dbbackups_export['.$this->page_ref.']"  type="checkbox" value="'.$this->page_ref.'">Export this Page Export the number of stored Backup Dbs to other Pages</p>'); 
     echo '</div><!--export-->';
	printer::close_print_wrap('import page options');
	$this->submit_button();
	printer::pclear(5);
	$this->show_close('Import Page Options');
	echo '</div><!-- float buttons-->';
     }//end page import export
     
#pageconf #pageop
function configure(){if(Sys::Custom)return; if (Sys::Quietmode) return; 
	echo '<div class="inline floatleft"><!-- float buttons-->';
	$this->show_more('Configure this Page','buffer_configure_page',$this->column_lev_color.' smallest editbackground editfont button'.$this->column_lev_color,'','','','','asis');
	$this->print_wrap('configure wrap',true);
     $this->submit_button();
     printer::alertx('<p class="info smaller floatleft clear">Cur Db: '.Sys::Dbname.'</p>');
     $this->show_more('Scale Units Overview &amp; Some Basic Pointers on the editor system','noback','','',800);
	$this->print_redwrap('basic pointers');
     $this->editor_overview();
     $this->close_print_wrap('basic pointers');
	$this->show_close('Some Basic Pointers on the editor system');
     printer::pclear(2);
	$this->configure_editor();
	printer::pclear();
	$this->show_more('Set Image Dir Cache Sizes','noback','','',600);
	$msg='Change the default cache directory sizes for responsive image sizes here. <br>Directory sizes needed are calculated for each image and larger than necessary directories not filled to minimize server space required. More directory sizes means served images are more efficiently downloaded and decreases bandwidth. However, more sizes also means more server disk space is used to cache the images. Adjust the default balance here.  Note: Quality level also affects download speed and server space used and can be adjusted for the ideal balance with page defaults, but also on the configuaration for images, slideshows and galleries';
	$this->print_redwrap('cache sizes'); 
	printer::printx('<p class="fsmnavy editbackground editfont editcolor smaller">'.$msg.'</p>');
	printer::alertx('<p class="warnlite">Changes of this setting will apply to every page in the site and images will generated to fill any new cache directory sizes on all pages. This may take awhile, wait for all iframes to load before leaving this page.</p>',1.1);
	echo '<div class="fsmnavy editbackground editfont highlight floatleft" title=" Be sure to enter numerical values separated by commas ie: '.Cfg::Image_response.'">Change Image Default Cache Dir Sizes <span class="editcolor small">(comma separate):</span> 
	<input type="text" value="'.$this->page_cache.'" name="page_cache"   size="50" maxlength="65">
	';
	echo'</div>';
	printer::pclear();
	$this->close_print_wrap('cache sizes');
	$this->show_close('Set Image Dir Cache Sizes');
	#######################
	$this->show_more('Edit RWD Grid Settings','noback','');
	$this->print_redwrap('Edit RWD Grid Settings'); 
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
	$this->close_print_wrap('Edit RWD Grid Settings'); 
	$this->show_close('Edit RWD Grid Settings','noback','');
     printer::pclear();
     $msg=printer::print_info('Optionally Set up em scaling units using the font size choice below. Check out the overview under the Scale Units Overview button above',.9,1);
	$msg.=printer::print_info('Borders and Box shadows will only affect the current element ie. never inherited whereas Text and Background Styles  are. <br>  Inherited styles set here mean that you do not have set them again in Columns and Posts unless you wish them to be different. Many more styling choices are available in each post. Border choices include choosing top border only',.9,1);
	$this->edit_styles_close('body','page_style','html body.'.$this->pagename,'background,font_color,text_shadow,font_family,font_size,borders','Set Body Background and Default Text Styles','noback',$msg);
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
	$this->show_more('Style H-Tags and Special Classes','noback'); 
	 $this->print_wrap('special styles',true);
	 if(is_file(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'css_data_sheet_'.$this->pagename.$this->passclass_ext)){
		$this->render_view_css=unserialize(file_get_contents(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'css_data_sheet_'.$this->pagename.$this->passclass_ext)); 
		$this->show_more('View Current Tag and Class Styles');
		printer::array_print($this->render_view_css); 
		$this->show_close('View Current Tag and Class Styles');
		}
	else $this->render_view_css='';
	printer::printx('<p class="fsminfo editbackground editfont editcolor">Style H tags ad class styles here which will be in affect page wise.</p>');
	$msg='Set style HR tags.  HR can be placed anywhere in text and the styles you set here will be expressed. HR are theme breaks, typically bordered lines with spacing. HR Styles may changed in individual column Settings';
	$this->edit_styles_close('bodyview','page_hr','.'.$this->pagename.' hr','width_special,width_max_special,width_min_special,background,padding_top,padding_bottom,padding_left,padding_right,margin_top,margin_bottom,margin_left,borders,box_shadow,outlines,radius_corner','Set HR Tags','noback',$msg);
	$htag_styles='width_special,width_max_special,width_min_special,float,background,padding_top,padding_bottom,padding_left,padding_right,margin_top,margin_bottom,margin_left,margin_right,borders,box_shadow,outlines,radius_corner,font_color,text_shadow,font_family,font_size,font_weight,text_align,text_shadow,line_height,letter_spacing,italics_font,small_caps,text_underline';
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
	$this->css.= "body div a:hover{ $palhc}";
	$span_color=(preg_match(Cfg::Preg_color,$this->page_options[$this->page_alink_hover_color_index]))?'<span class="fs1npred" style="background-color:#'.$this->page_options[$this->page_alink_hover_color_index].';">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>':''; 
	printer::alert('Set Default Link Hover Color <input onclick="jscolor.installByClassName(\'colorhover_id\');" style="cursor:pointer;background:#'.$this->editor_background.';color:#'.$this->editor_color.';" type="text" name="page_options['.$this->page_alink_hover_color_index.']" id="colorhover_id" value="'.$page_alink_hover_color.'" size="12" maxlength="6" class="colorhover_id {refine:false}">'.$span_color.'<br>',false,'left editcolor editbackground editfont');
	$this->close_print_wrap('hover link');
	$this->show_close('Style Hover Over Link Color');
	printer::close_print_wrap('alinks');
	$this->show_close('Style A Links');
	$msg='Add links, tags, scripts to head';
	$this->show_more($msg,'','','','700');
	$this->print_wrap($msg);
	printer::print_tip('Append Custom links to css and script files or additional meta tags and css or scripts to the head section');
	$this->textarea($this->page_head,'page_head','100','16');
	$this->submit_button();
	$this->css.=$this->page_custom_css;
	printer::close_print_wrap($msg);
	$this->show_close($msg);
	printer::pclear(5);
	$this->show_more('Custom Page CSS','','','','700');
	$this->print_wrap('Custom Page CSS');
	printer::print_tip('Add Custom CSS Must Include Classname or Id. Include CSS complete, Everything except the style Tags. CAUTION; Mistakes in this may likely affect all CSS');
	$this->textarea($this->page_custom_css,'page_custom_css','100','16');
	$this->submit_button();
	$this->css.=$this->page_custom_css;
	printer::close_print_wrap('Custom Page CSS');
	$this->show_close('Custom Page CSS');
	printer::pclear(5);
	$this->show_more('Maintenance &amp; Uploads');
	$this->print_redwrap('maintenance',true);
     $this->submit_button();
	$msg='Generate any missing icons &amp; all edit directory files, &amp; non-flat file folders, etc. for this website. <br> Will not overwrite custom class files. <br>Setting Override=true in config files will cause all icons to be overriden.'; 
	$this->print_wrap('file gnerate');
	printer::print_tip($msg);
	echo '<p class="caution white fsmsalmon"><input type="checkbox" name="file_generate_site" value="1" >Generate Files</p>';
	printer::close_print_wrap('file gnerate');
	$msg='Generate/update any missing page class files. Caution: will overwrite any custom page class content';
	$this->print_wrap('file gnerate');
	printer::print_tip($msg);
	echo '<p class="caution white fsmsalmon"><input type="checkbox" name="page_class_generate" value="1" >Re-generate Page Class Files</p>';
	printer::close_print_wrap('file gnerate');
	$this->print_wrap('regen_backup_table','fsmredAlert');
	$msg='Regenerates the backup database. Will recompile list of all stored backup gzipped sql files and delete old files in excess of '.$this->backup_copies. ' (Stored Db gz Copies Setting may be changed in the page_configurations or the setting default in the Cfg file';
	printer::print_tip($msg);
	echo '<p class="caution white fsmsalmon"><input type="checkbox" name="regen_backup_table" value="1">Re-Generate Backup database Files</p>';
	printer::close_print_wrap('regen_backup_table');
	$msg='Allowing for all pages to update any caches, style css files, or flat files that may have escapted proper updating. Runs all pages in editmode in iframes';
	$this->print_wrap('iframe all','fsmredAlert');
	printer::print_tip($msg);
	echo '<p class="caution white fsmsalmon"><input type="checkbox" name="page_iframe_all" value="1" onchange="edit_Proc.oncheck(\'page_iframe_all\',\'Checking Here for Maintenance only. All edit-mode pages will be generated in Iframes and this will take a Long Time to Finish, Uncheck to Cancel\')" >Generate all Css,Page Flat Files, etc. for all Edit Mode Pages in Iframes</p>';
	echo '<p title="Navigating to bottom of Iframe Quickly allows for a check of any error message" class="info  whitebackground fsmsalmon"><input type="checkbox" name="iframe_bottom" value="1">Nav to Iframe Bottom</p>';
	printer::close_print_wrap('iframe all');
	$this->submit_button();
	$msg='Generate all Webpages in iframes (non-edit mode) to quickly check for any errors or intitate custom query';
	$this->print_wrap('iframe all_website');
	printer::print_tip($msg);
	echo '<p class="infobackground white fsmsalmon"><input type="checkbox" name="page_iframe_all_website" value="1">Quick Check, etc. all web-mode pages in iframes</p>';
	echo '<p title="Navigating to bottom of Iframe Quickly allows for a check of any error message" class="highlight  whitebackground fsmsalmon"><input type="checkbox" name="iframe_bottom" value="1">Nav to Iframe Bottom</p>';
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
	echo '<p class="caution white fsmsalmon"><input type="checkbox" name="cache_regenerate_flatfiles" value="1"  >Remove and RegGenerate all Page Flat Files & Generate Css.  Utilizes Iframes</p>';
	echo '<p title="Navigating to bottom of Iframe Quickly allows for a check of any error message" class="highlight  whitebackground fsmsalmon"><input type="checkbox" name="iframe_bottom" value="1">Nav to Iframe Bottom</p>';
	printer::close_print_wrap('cache regen');
     $this->show_more('Reset Colors');
	printer::print_wrap('color reset');
	printer::print_tip('If you add new color choices or change the default color order in the configurations, the color matching may be out of sync. Check here to reset colors. Note the color order will return to default Order and colors will be in sync');
	printer::printx('<p class="editbackground editcolor small"><input type="radio" value="reset" name="force_color_reset">Reset Colors on this Page Only</p>');
	printer::printx('<p class="editbackground editcolor small"><input type="radio" value="reset_all" name="force_color_reset">Reset Colors on all the Pages in this Website</p>');
	printer::close_print_wrap('color reset');
	$this->show_close('Reset Colors');
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
	echo '<div class="inline floatleft"><!-- float buttons-->';
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
	
function left($style, $val, $field){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	$this->spacing($style,$val,'left','left positioning','Adjust Position of absolute or relative positioned element/post/column','','','',$field);
     }
function right($style, $val, $field){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	$this->abs_spacing($style,$val,'right','Right Spacing','Position from Right Relative Absolute positioned elements');
	}
function top($style, $val, $field){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	$this->abs_spacing($style,$val,'top','Top Spacing','Position from Top Relative Absolute positioned elements. ');
	}
function bottom($style, $val, $field){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	$this->abs_spacing($style,$val,'bottom','Bottom Spacing','Position from Bottom Relative Absolute positioned elements');
	}
	
function abs_spacing($style,$val,$css_class,$msg,$title){
	$maxspace=500;
	$size=(is_numeric($this->{$style}[$val])&&$this->{$style}[$val]<=$maxspace&&$this->{$style}[$val]>=0)?$this->{$style}[$val]:'None'; 
		#all values will be store as px
	$sizepx=($size !=='None')?$this->{$style}[$val].'px':$size;
	echo '
	    <div class="floatleft editbackground editfont editcolor editfont fs1color  left"> <span class="highlight" title="'.$title.'" >'.$msg.'</span>: Currently '.$sizepx
	    .'<br>';
		$unit1='px';
		$msgjava='Choose px Spacing:'; 
		$factor=1;
		$unit2='';  
		$this->mod_spacing($style.'['.$val.']',$size,0,$maxspace,1,'%','none',$msgjava);   
	echo'  </div>';
	printer::pclear(1); 
	$final=$sizepx.';';
	$fstyle='final_'.$style; 
     $this->{$fstyle}[$val]=($sizepx==='None')?'':$css_class.':'.$final;
    }//end functio   
function uploads_spacer(){
     echo '<div style="padding-left:15px;" class="inline hidden floatleft"><!-- float buttons-->';
     #this is a spacer within the form for uploads function which cannot be in the form which absolute position of it.
     $this->show_more('uploads','','tiny button'.$this->column_lev_color,'','full' );
     $this->show_close('uploads_spacer');
     echo '</div><!-- float buttons-->';
     }
function uploads(){ 
     echo '<div id="top_upload"><!-- float buttons-->';
	$this->show_more('uploads','',$this->column_lev_color.'  tiny editpages editbackground editfont button'.$this->column_lev_color,'','full' );
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
     $folders=array('home','uploads');
     printer::pclear(15);
     printer::print_info('Choose your upload dir');
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
	
function font_size($style,$val,$field,$directcss=false){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__); 
     $font_arr=explode('@@',$this->{$style}[$val]);
     for ($i=0; $i <4; $i++){
          if (!array_key_exists($i,$font_arr)){
               $font_arr[$i]=0;
               }
          }
     $px='px';
     $fontsize1=(!empty($font_arr[0])&&is_numeric($font_arr[0])&&$font_arr[0]<=100&&$font_arr[0]>=1)?$font_arr[0]:0; 
     $msg= (empty($fontsize1))? 'none ': $fontsize1;  
     $fontsize2=(!empty($font_arr[2])&&is_numeric($font_arr[2])&&$font_arr[2]>0&&$font_arr[2]<=10)?$font_arr[2]:0;
     $msg2= (empty($fontsize2))? 'none ': $fontsize2;  
     $scaleunit=(!empty($font_arr[1])&&$font_arr[1]==='em'||$font_arr[1]==='rem')?$font_arr[1]:'none'; 
     if ($field==='return_val'){
          if (!empty($fontsize1)){
               $msgscale=$this->rwd_scale($this->{$style}[$val],'return_val',"",'font-size','font size px','px',0,7,true,1);
               if (!empty($msgscale)){
                    return "$fontsize1$px $msgscale";
                    }
               elseif (empty($fontsize2)||$scaleunit==='none')
                    return "$fontsize1$px";
               }
          elseif(!empty($fontsize2)&&$scaleunit!=='none'){
               return "$fontsize2$scaleunit";
               }
          return;
          }
     
     echo '
     <div class="fsminfo '.$style.'_hidefont" style="display:none;"><!-- font-->';
     $this->show_more('Font-Size','',' highlight editbackground editfontfamily','In columns and posts, body font-size may be used to setup em units with or without scaling effect');
     $this->print_wrap('Font-Size Choices','','highlight editbackground editfontfamily','Choose px or scalable font sizes');
    
     $this->show_more('Use font px units &amp; scaling px units');
     printer::print_wrap('font px');
     echo'<p class="'.$this->column_lev_color.' clear editbackground editfont">Font Size: Currently '.$msg.'px<br>';
     $msgjava='Choose font-size:'; 
     $this->mod_spacing($style.'['.$val.'][0] ',$fontsize1,0,100,1,'px','none',$msgjava); 
     printer::print_tip('Optionally choose to Scale px font-size or choose alt units below ie. rem, em');
     $msgscale=$this->rwd_scale($this->{$style}[$val],$style.'['.$val.']',"$this->pelement",'font-size','font size px','px',0,7,true,1);
     printer::close_print_wrap('font px');
     $this->show_close('Use font px units ');
     if (!empty($msgscale))printer::print_notice($msgscale);
     $final='';
     if (!empty($fontsize2)&&$scaleunit!=='none'){
          if ($scaleunit==='rem'){
               $value=$this->rem_root*$fontsize2;
               $scale=($this->rem_scale)?'on':'off';
               }
          else { 
               $scale=($this->terminal_em_scale)?'on':'off';
               $value=$this->terminal_font_em_px; 
               $final="<br>giving value of 1em unit = {$this->terminal_font_em_px}px for padding/margins/widths/etc. in this post/col";
               }
          (!empty($fontsize2)&&strpos($fontsize2,'0.00')===false)&&printer::print_notice("Current Alt font-size  $fontsize2$scaleunit = {$value}px with scaling $scale");
          }
	$style1=(!empty($fontsize1))?'font-size:'.$fontsize1.'px;':'';
	$style2=(is_numeric($fontsize2)&&$fontsize2<=10&&$scaleunit!=='none')?'font-size:'.$fontsize2.$scaleunit.';':''; 
	
     
     if (!empty($style2)){
		if ($this->is_page&&$directcss!==false){//use html body to give greater priority
			$this->pagecss.="
     $directcss".'{'.$style1.$style2.'}';
			}
		elseif ($directcss!==false){
               $this->css.="
	$directcss".'{'.$style1.$style2.'}
	';
			}
		} 	
	printer::pclear();
	$this->show_more('Use other font-size units');
	$this->print_redwrap('other fontsize units');
     printer::print_notice("Equivalent of 1em for font-size: {$this->current_font_em_px}px $final"); 
     ($this->is_page)&&printer::print_warn('Using em for the default page level font-size (body) multiplies with the html level font-size of '.$this->rem_root.'px including scaling if initiated for rem units.');
      $more='';/*(!$this->is_page&&(!$this->col_primary||$this->is_blog))?'
4. Choose VW units.':'';*/
	printer::print_tip('AND/OR Choose a scalable font-size unit here.  <b>You can enable scaling for rem (appropriately between the upper and lower viewport size of your choice) in the page options under page options and spacing &amp; other values using rem will scale according to the settings you make there.
<br>
</b>There are different units available to enable font scaling ie font size relative to the viewport size:<br>
1. Choose px value then enable rwd scaling in the options below. Be sure not to choose a rem or em value for this option or px values including scaling will be overriden<br>
2. Use REM units with px scaling enabled in the page default settings option.<br>
3. Use Em units here with font-size px scaling enabled in a parent column or in the body. ie: Em units are directly proportional to the current active inherited font-size.<br>'.$more);
     printer::print_tip('Choose value and unit type.');
     $checked=' checked="checked" ';
     $checked1=($scaleunit==='none')?$checked:'';
     $checked2=($scaleunit==='em')?$checked:'';
     $checked3=($scaleunit==='rem')?$checked:'';  
     printer::alert('Choose scale unit:');
     printer::alert('<input type="radio" name="'.$style.'['.$val.'][1]" value="none" '.$checked1.'>None');
     printer::alert('<input type="radio" name="'.$style.'['.$val.'][1]" value="em" '.$checked2.'>em units');
     printer::alert('<input type="radio" name="'.$style.'['.$val.'][1]" value="rem" '.$checked3.'>rem units'); 
     printer::pclear(5);
     echo'<p class="'.$this->column_lev_color.' editbackground editfont">Alt. Unit Font Size: Currently '.$msg2.'<br>';
     $msgjava='Choose Alt. font-size:'; 
     $this->mod_spacing($style.'['.$val.'][2] ',$fontsize2,0,10,.01,'units','none',$msgjava); 
	$this->submit_button();  
	printer::close_print_wrap('other fontsize units');  
	$this->show_close('Use other font-size units');  
          printer::close_print_wrap('Font-Size Choices'); 
          $this->show_close('Font-Size Choices'); 
	echo'
	    </div><!-- font-->'; 
     if (!$directcss){  
          $fstyle='final_'.$style;
          if (!empty($style1)||!empty($style2))
               $this->{$fstyle}[$val]=$style1.$style2;
               //if ($this->is_page&&empty($style1)&&empty($style2))
                  //  $this->{$fstyle}[$val]='font-size:16px';//insure value of default font size this will be for body not html..
              // if (!empty($style1)&&!empty($style2)){//give redundant specificity priority
              // $this->css.='
      //html '.$this->pelement.'{'.$style2.'}';
               //}
               /*
          if (!$this->is_blog&&!empty($style2)){
               $this->current_font_source=($this->is_page)?'body':'c'.$this->col_id;
               $this->current_font_size=$style2;
               }
          elseif(!$this->is_blog&&!empty($style1)){ 
               $this->current_font_source=($this->is_page)?'body':'c'.$this->col_id; 
               $this->current_font_size=$style1;
               }
               */
          
          } 
    
     }   
	
function width_special($style,$val,$field,$directcss=false,$norendercss=false){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
     $width= ($norendercss)?'none':'width';//if true no css 
	$this->spacing($style,$val,$width,'Width','Straight forward Width option will not override a max-width or min-width property','','',false, $field,$directcss,0,'',array('auto'=>'width:auto;'));
     }
  
function width_max_special($style,$val,$field,$directcss=false,$norendercss=false){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
     $width= ($norendercss)?'none':'max-width';//if true no css 
	$this->spacing($style,$val,$width,'Max Width','Max-Width sets a maximum width and overrides width property','','',false, $field,$directcss,0,'',array('none'=>'max-width:none;'));
     }
 
function width_min_special($style,$val,$field,$directcss=false,$norendercss=false){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
     $width= ($norendercss)?'none':'min-width';//if true no css 
     $this->spacing($style,$val,$width,'Min-Width','Note: Media Query removing Minimum Width is automatically generated at viewports at or below the min-width value set! Minimum Width sets a minimum width and overrides width property','','',false, $field,$directcss,0,'',array('none'=>'min-width:none;'));
     }

function height_special($style,$val,$field,$directcss=false,$start=0){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	$return=$this->spacing($style,$val,$field,'Height','Straight forward Height option will not override  a max-height or min-height property','','',false, $field,$directcss,$start,'',array('auto'=>'height:auto;'));
     return $return;
     }

  
function height_max_special($style,$val,$field,$directcss=false,$start=0){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	$return=$this->spacing($style,$val,$field,'Max Height','Max-Height sets a maximum height and overrides height property','','',false, $field,$directcss,$start,'',array('none'=>'max-height:none;'));
     return $return;
     }

 
function height_min_special($style,$val,$field,$directcss=false,$start=0){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
     $return=$this->spacing($style,$val,$field,'Min-Height','Minimum Height sets a minimum height and overrides height property','','',false, '',$directcss,$start,'',array('none'=>'min-height:none;'));
     return $return;
     }

function media_max_width($style,$val){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	$this->show_more('Optionally Add @media max-width','','highlight editbackground editfont highlight editstyle','Adding a @media max-width will affect all values of this style grouping above except advanced styles');
     $media_maxpx=($this->{$style}[$val]>=200&&$this->{$style}[$val]<=3000)?$this->{$style}[$val]:'none';
     $max_name=$style.'['.$val.']';
     printer::print_wrap('wrap @mediamax');
     $this->submit_button();
     printer::print_info('Optionally choose a max-width here or min-width below or both at which all the above grouping of custom styles will be expressed. (Except the advanced style option which has individual @media options for each css directive)');  
     echo '<div class="fsminfo"><!--wrap max width-->';
     printer::printx('<p class="smaller '.$this->column_lev_color.'">Chosen max-width: <span class="navybackground white">'.$media_maxpx.'</span><br></p>');   
     printer::alert('Choose @media screen max-width px');
     $this->mod_spacing($max_name,$media_maxpx,200,3000,1,'px','none');  
     printer::printx('<p ><input type="checkbox" name="'.$max_name.'" value="0">Remove max-width</p>');
     echo '</div><!--wrap max width-->';
     printer::close_print_wrap('wrap @mediamax');
	$this->show_close('Optionally Add @media max-width');
	$fstyle='final_'.$style; 
     $this->{$fstyle}[$val]=($media_maxpx==='none')?'':array('mediamax',$media_maxpx);
     }
     
function media_min_width($style,$val){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	$media_minpx=($this->{$style}[$val]>=200&&$this->{$style}[$val]<=3000)?$this->{$style}[$val]:'none'; 
     $min_name=$style.'['.$val.']';
	$this->show_more('Optionally Add @media min-width','','highlight editbackground editfont highlight editstyle','Adding a @media min-width will affect all values of this style grouping above except advanced styles');
     printer::print_wrap('wrap @mediamin');
     $this->submit_button();
     printer::print_info('Optionally choose a min-width here or max-width below or both at which all the above grouping of custom styles will be expressed. (Except the advanced style option which has individual @media options for each css directive)');  
     echo '<div class="fsminfo"><!--wrap min width-->';
     printer::printx('<p class="smaller '.$this->column_lev_color.'">Chosen min-width: <span class="navybackground white">'.$media_minpx.'</span></p>');
      printer::alert('Choose @media screen min-width px'); 
     $this->mod_spacing($min_name,$media_minpx,200,3000,1,'px','none');
     printer::printx('<p ><input type="checkbox" name="'.$min_name.'" value="0">Remove min-width</p>');
     printer::close_print_wrap('wrap @mediamin');
	$this->show_close('Optionally Add @media min-width');
     echo '</div><!--wrap min width-->';
	$fstyle='final_'.$style; 
     $this->{$fstyle}[$val]=($media_minpx==='none')?'':array('mediamin',$media_minpx);
     }    
     
function width($style,$val){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__); 
     echo'  <div class="floatleft">'; 
	$maxspace=$this->column_net_width[$this->column_level];
	$wid=$this->{$style}[$val]=(!empty($this->{$style}[$val])&&is_numeric($this->{$style}[$val])&&$this->{$style}[$val]<=100)?$this->{$style}[$val]:'';
	$widval=(!empty($wid)&&$this->use_blog_main_width)?$wid:0;
	$percent =(empty($wid))?'':'&#40;'.(intval(ceil($wid*10)/10)).'%&#41;';
	$px=(empty($wid))?'None Chosen':(intval(ceil($wid*$this->column_net_width[$this->column_level]/10)/10)).'px';
 	(!$this->flex_enabled_twice)&&printer::alertx('<p class="highlight editbackground editfont" title="The Column Width less its margins and paddings sets the Upper Limit for Post Width. Optionally set a narrower Post Width if required (does not effect other posts in this Column). The total width Available for your actual content such as text or an images will be narrowed by values of padding and margin styles made in this post styles">Max Width Available: <span class="editcolor editbackground editfont">'.(intval(ceil($this->column_net_width[$this->column_level]*10)/10)).'px</span></p>');
     
     if ($this->use_blog_main_width&&$this->flex_enabled_twice)
          printer::print_warn('Previous activation of Flex Box in column tree means that max-width chosen here is not longer accurate. Instead you can select mode 2 for percent or 2 for alt rwd grid percent choices below. Alternatively, you can  Use Alt width units to set a direct width or for flex-item use basis specific width is now recommended');
     elseif ($this->use_blog_main_width)
          printer::alertx('<p class="highlight editbackground editfont" title="The Post width + spacing, borders,etc. will take up  to 100% of the available parent column width if no limiting width value is chosen! Limit the width if required. Both the percentage available of the parent column width and the px value that your selection represents will be shown">This Post Amount Used: <span class="editcolor editbackground editfont">: '.$px.'   '.$percent.'</span></p>');
     else
          printer::alertx('<p class="editcolor editbackground editfont" >Main Width Mode not used. px value of alt width units used  and percent of total available for this Post: <span class="editcolor editbackground editfont">: '.$px.'   '.$percent.'</span></p>'); 
	printer::alertx('<p class="editcolor editbackground editfont" ></p>');  
	printer::pclear();
	printer::print_tip('Choose width value percent/px and choose below that whether the width is expressed as max-width (default) or percent  <b>Or Alternatively, use the alt rwd percentages @mediawidths below which overwrites the main width setting if made.</b>');
		$msgjava='Set Custom Width:';
		$factor=($this->flex_enabled_twice)?1:$this->column_net_width[$this->column_level]/100;
          $unit2=($this->flex_enabled_twice)?'':'px';
          $this->mod_spacing($style.'['.$val.']',$widval,0,100,.05,'%','',$msgjava,$factor,$unit2);
     printer::print_info('Choosing a main width value overrides any choice made  from option under em, rem, %, px & px scale opt for min-width, max-width, & width choices');
	$this->submit_button();		 
     echo '</div><!--width-->'; 
     }

function check_spacing($spacing_arr,$type){  
	if (empty($spacing_arr))return '';
	$spacing_arr=explode('@@',$spacing_arr);
	for ($i=0; $i<12; $i++){
		if (!array_key_exists($i,$spacing_arr)){
			$spacing_arr[$i]=0;
			}
		}
	$return='';
	$maxspace=($this->is_page)?4000:$this->column_total_width[0];//limit width
	$current_px=$spacing_arr[0];
	$current_px=(is_numeric($current_px)&&$current_px<=$maxspace&&$current_px>=1)?$current_px:0;
	if (!empty($current_px))   
		$return.='<br>The Alternative '.$type.' px unit choice <b>Is Chosen</b>'; 
	if (is_numeric($spacing_arr[2])&&$spacing_arr[2]<=100&&$spacing_arr[2]>=.05)$return.='<br>The Alternative Percent Units for '.$type.' <b>Is Chosen</b>.'; 
	if (is_numeric($spacing_arr[3])&&$spacing_arr[3]<=100&&$spacing_arr[3]>=.05)$return.='<br>The Alternative em Units for '.$type.' <b>Is Chosen</b>';   
	if (is_numeric($spacing_arr[4])&&$spacing_arr[4]<=100&&$spacing_arr[4]>=.05)$return.='<br>Alternative rem Units for '.$type.' <b>Is Chosen</b>';
     if (!empty($return))$this->scale_width_enabled=true;
	return $return;
	}
	
function spacing($style,$val,$css_style,$msg,$title,$hide='',$ifempty='',$showpercent=false,$field='',$directcss=false,$start=0,$msg2='',$radio='',$pxmaxwidth='4000'){ if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
#10-11 indexes  7 + 3
#field is not currently used here
	#show_percent true for mar/pad left/right
	#css style none means no css property chosen yet ie left vs. right top vs. bottom but number can be chosen!
	$type=($this->is_page)?'page':(($this->is_column)?'column':'blog'); 
	$use_percent=false;
     $start=(is_numeric($start))?$start:0;
	$spacing_arr=explode('@@',$this->{$style}[$val]);
	for ($i=0; $i<12+$start; $i++){
		if (!array_key_exists($i,$spacing_arr)||$spacing_arr[$i]==='00'||$spacing_arr[$i]==='0.0'||$spacing_arr[$i]==='0.00'){
			$spacing_arr[$i]=0;
			}
		}
         
	$maxspace=($this->is_page&&$showpercent)?$this->page_width:(($showpercent)?$this->column_total_width[$this->column_level]:4000);//limit width
     $maxspace=min($maxspace,$pxmaxwidth);
	$current_px=$spacing_arr[$start];//index key  of first value
	$current_px=(is_numeric($current_px)&&$current_px<=$maxspace&&$current_px>=0)?$current_px:0;  
	$current_percent=$spacing_arr[$start+2];
	$current_percent=(is_numeric($current_percent)&&$current_percent<=100&&$current_percent>=.05)?$current_percent:0;
	$current_em=$spacing_arr[$start+3];
	$current_em=(is_numeric($current_em)&&$current_em<=200&&$current_em>=.05)?$current_em:0; 
	$current_rem=$spacing_arr[$start+4];
	$current_rem=(is_numeric($current_rem)&&$current_rem<=200&&$current_rem>=.01)?$current_rem:0;  
	$current_vw=$spacing_arr[$start+5];
	$current_vw=(is_numeric($current_vw)&&$current_vw<=100&&$current_vw>=.02)?$current_vw:0; 
	$current_vh=$spacing_arr[$start+6];
	$current_vh=(is_numeric($current_vh)&&$current_vh<=100&&$current_vh>=.02)?$current_vh:0; 
		#all values will be store as px
		#percent will be calculated for overall post size using post width...
	$scaleunit=(!empty($spacing_arr[1])&&$spacing_arr[1]!=='%'&&$spacing_arr[1]!=='em'&&$spacing_arr[1]!=='rem'&&$spacing_arr[1]!=='vw'&&$spacing_arr[1]!=='vh')?'none':$spacing_arr[1];
	$pos_neg=($spacing_arr[$start+1]==='-')?'-':''; 
     //used for locally comparing this value to another then expressing the css ie not here.
     $returnval='';
  foreach (array('rem','em','percent','px') as $ext){ 
          if (!empty(${'current_'.$ext})){
               $empty=false;
               
               if ($ext==='rem'){
                     $returnval=$pos_neg.${'current_'.$ext}.'rem';
                     }
               elseif ($ext==='em'){
                    $returnval=$pos_neg.${'current_'.$ext}.'em';
                    }
               elseif ($ext==='percent'){
                    $returnval=$pos_neg.${'current_'.$ext}.'%';
                    }
               elseif ($ext==='px'){
                    $returnval=$pos_neg.${'current_'.$ext}.'px';
                    $msgscale=$this->rwd_scale($this->{$style}[$val],'return_val',"",'font-size','font size px','px',0,7,true,1);
                    if (!empty($msgscale)){
                         $returnval.=$msgscale;
                         }
                    }
               break;
               }
          }
     if ($css_style==='display_style'){//used for parsing style values for displaying values...
          if (is_array($radio)){ 
               $overridevalue='';
               foreach ($radio as $value=>$rvar){ 
                    if($spacing_arr[$start]===$value){
                         $overridevalue=$rvar;
                         }
                    }
               if (!empty($overridevalue))return 'Override: '.$overridevalue;
               }
          return $returnval;
          }
	($this->is_page)&&$showpercent=false;	 
	$sizepx=$current_px.'px'; 
	$percent=($showpercent&&is_numeric($this->{$style}[$val]))?(ceil($this->{$style}[$val]*100/$this->column_total_width[$this->column_level]*10)/10):''; 
	$current=($showpercent)?$sizepx.'  ('.$percent.'%)':$sizepx;
	$size=$sizepx; 
	$class=(!empty($hide))?$hide:'';
	$negmsg=($pos_neg==='-')?' &amp; chosen value expressed as negative value':''; 
	$this->show_more($msg,'',$class.' editbackground editfont italic info',$title);
	$this->print_redwrap('spacing funct wrap');
	(!empty($msg2))&& printer::print_info($msg2);	 
	echo '<div class="floatleft editbackground editfont editcolor editfont fs1color '.$class.' left"><!--funct spacing choose other units-->';
     printer::alertx('<p class="tip center">Choose units/value for '.$msg.'.<br><b>Last chosen will override other units.</b></p>');
	(!empty($title))&&printer::print_tip($title);
	if (strpos($css_style,'width')===false&&strpos($css_style,'height')===false){
          $this->show_more('Negative Value Option','','highlight click editbackground editfont smaller');
		$checked1=($pos_neg!=='-')?'checked="checked"':'';
		$checked2=($pos_neg!=='-')?'':'checked="checked"';
          printer::print_wrap('wrap neg');
		printer::alert_size('<input name="'.$style.'['.$val.']['.($start+1).']" '.$checked1.' type="radio"  value="">Use Positive Value',1);
		printer::alert_size('<input name="'.$style.'['.$val.']['.($start+1).']" type="radio" '.$checked2.' value="-">Set to Negative Value',1);
          printer::close_print_wrap('wrap neg');
          $this->show_close('Negative Val Option');
		} 
	printer::pclear(7);
	printer::print_wrap('wrap px choice');
     $pxpercent=(!$this->is_page&&$showpercent)?'&nbsp;&nbsp;('.$current_px*100/$this->current_total_width.'% Avail Parent Wid)':'';
	echo '<span class="highlight" title="'.$title.'" >px '.$msg.'</span>: Currently '.$sizepx.$negmsg.$pxpercent.'<br>';
     $this->show_more('Choose Px Units'); 
     $this->print_redwrap('px units'); 
	$unit1='px';
	$msgjava='Choose px '.$msg.':';
	$factor=(!$this->is_page)?100/$this->current_total_width:1;
	$unit2=(!$this->is_page&&$showpercent)?'%':'';  
	$this->mod_spacing($style.'['.$val.']['.$start.']',$current_px,0,$maxspace,1,$unit1,'',$msgjava,$factor,$unit2);
      printer::print_tip('Optionally create px viewport proportional units (uses media queries) or choose scalable units ie em,rem,% below');
     $pass_element=($directcss!==false&&!empty($directcss))?$directcss:$this->pelement;
	 if (strpos($css_style,'return')===false)$msgscale=$this->rwd_scale($pos_neg.$this->{$style}[$val],$style.'['.$val.']'," $pass_element",$css_style,$msg.' px','px',$start,7,true,1);
      else $msgscale='';
	$this->submit_button();
     printer::close_print_wrap('px units'); 
     $this->show_close('Choose Px Units');
	printer::close_print_wrap('wrap px choice'); 
     if (!empty($msgscale))printer::print_notice($msgscale);
	printer::pclear();
     $overridecss=false;#override css is passed on as checkable value ie none or auto..
     if (is_array($radio)){ 
          $overridecss=false;
          foreach ($radio as $value=>$rvar){
               if($spacing_arr[$start]===$value){
                    $overridecss=true;
                    printer::alertx('<p class="clear floatleft smallest whitebackground black fs1salmon">Active Override Css Value checked for: <b>'.$rvar.'</b></p>');
                    }
               }
          }
      
    	printer::print_wrap('funct spacing choose other units');
     if (!$overridecss){ //checked value options expressing the css ie not here.
          foreach (array('rem','em','percent') as $ext){ 
               if (!empty(${'current_'.$ext})){
                    $empty=false;
                    if ($ext==='rem'){
                         $remscale=($this->rem_scale)?'px scaling on':'px scaling off';
                         $pxequiv='&nbsp;&nbsp; = '.round($this->rem_root*${'current_'.$ext},1).$remscale;
                        // $pxequiv='&nbsp;&nbsp; = '.$this->rem_root.$remscale;
                          }
                    elseif ($ext==='em'){
                         $emscale=($this->terminal_em_scale)?'px scaling on':'px scaling off';
                         $pxequiv='&nbsp;&nbsp; = '.round($this->terminal_font_em_px*${'current_'.$ext},1).$emscale;
                         }
                    else $pxequiv=''; 
                    $scaleunit=($ext==='percent')?'%':$ext;
                    printer::alertx('<p class="clear floatleft smallest whitebackground black fs1salmon">Active '.$msg.': <b>'.$pos_neg.${'current_'.$ext}.$scaleunit.$pxequiv.'</b></p>');
                    break;
                    }
               }
          } 
     
     printer::pclear();
	$this->show_more('Use Other '.$msg.' Units');
	$this->print_redwrap('funct spacing more other spacing units');
     $emscale=($this->terminal_em_scale)?'px scaling on':'px scaling off';
     $remscale=($this->rem_scale)?' px scaling on':' px scaling off';
     printer::print_info("each em unit (if used) has current equivalent = $this->terminal_font_em_px$emscale");
     printer::print_info("1 rem equivalent to $this->rem_root$remscale");
     $this->show_more('Setting up em rem info','','info editbackground tiny','Click for important info on em rem');
	printer::print_tip('Choose an alternative spacing unit here.  <b>You can enable rwd scaling for rem (appropriately related to content-size at different viewports) in the page options under configure setting defaults and spacing values using rem will scale according to the settings you make there and the rem value you set here.</b> Em rwd scaling is determined by font-size scaling on the nearest font-size selection. See font-size unit choices for more info. <br> Choose value and unit type.  You can choose more than one unit type but rem will overrides em which overrides % which ovrrides px.');
     $this->show_close('Setting up em rem info');
	printer::alert(' <b> The following value types will override px setting on browsers that support it.</b>');
     printer::print_wrap('percent');
	printer::alert('Currently: '.$current_percent.'%  Choose Percent Value:');
	$this->mod_spacing($style.'['.$val.']['.($start+2).']',$current_percent,0,100,.05,'%','none');
     printer::close_print_wrap('percent');
     printer::print_wrap('em');
     $pxpercent=(!$this->is_page&&$showpercent)?'&nbsp;&nbsp;('.$current_em*$this->terminal_font_em_px*100/$this->current_total_width.'% Avail Parent Wid)':''; 
	$factor=(!$this->is_page)?$this->terminal_font_em_px*100/$this->current_total_width:1;
	$unit2=(!$this->is_page&&$showpercent)?'%':''; 
	printer::alert('Currently: '.$current_em.'em'.$pxpercent.'<br> Choose em value: ');
	$this->mod_spacing($style.'['.$val.']['.($start+3).']',$current_em,0,200,.05,'em','none','',$factor,$unit2);
     printer::close_print_wrap('em');
     printer::print_wrap('rem');
     $pxpercent=(!$this->is_page&&$showpercent)?'&nbsp;&nbsp;('.$current_rem*$this->rem_root*100/$this->current_total_width.'% Avail Parent Wid)':''; 
	$factor=(!$this->is_page)?$this->rem_root*100/$this->current_total_width:1;
	$unit2=(!$this->is_page&&$showpercent)?'%':''; 
	printer::alert('Currently: '.$current_rem.'rem'.$pxpercent.'<br> Choose rem value: '); 
	$this->mod_spacing($style.'['.$val.']['.($start+4).']',$current_rem,0,200,.01,'rem','none','',$factor,$unit2);
     printer::close_print_wrap('rem');
     #vw currently not enabled
     /*printer::print_wrap('vw');
	printer::alert('Currently: '.$current_vw.'vw Choose vw Value:');
	$this->mod_spacing($style.'['.$val.']['.($start+5).']',$current_vw,0,100,.02,'vw','none');
     printer::close_print_wrap('vw'); 
	if (strpos($css_style,'top')||strpos($css_style,'bottom')||strpos($css_style,'height')){ 
          printer::print_wrap('vh');
		printer::alert('Currently: '.$current_vh.'vh Choose vh Value:');
		$this->mod_spacing($style.'['.$val.']['.($start+6).']',$current_vh,0,100,.02,'vh','none');
          printer::close_print_wrap('vh'); 
		}*/
	
	$this->submit_button();
	printer::close_print_wrap('funct spacing  other spacing units'); 
	$this->show_close('funct spacing  Use other spacing units'); 
    	printer::close_print_wrap('funct spacing  wrap other units');
	if (is_array($radio)){ 
          printer::print_wrap1('radio spacing'); 
          printer::print_tip('Checking This Css Option overrides all other chosen values.'); 
          $overridecss=false;
          $overridevalue='';
          foreach ($radio as $value=>$rvar){
               if($spacing_arr[$start]===$value){ 
                    $checked='checked="checked"';
                    $overridecss=true; 
                    $returnval=$overridevalue=$rvar;
                    }
               else $checked='';
               printer::alert('<input name="'.$style.'['.$val.']['.($start).']" type="radio" value="'.$value.'" '.$checked.'">Use '.$rvar);
               }
          ($overridecss)&&printer::alert('<input name="'.$style.'['.$val.']['.$start.']" type="radio" value="0"><span class="orange">Remove</span> Override Option: '.$overridevalue);
          printer::close_print_wrap1('funct spacing  radio spacing');
          }
	echo'  </div><!--spacing hide-->';
     
     printer::pclear();
	$this->submit_button(); 
	printer::close_print_wrap('funct spacing  spacing wrap');
	$this->show_close($msg); 
     if (strpos($css_style,'return')!==false){
          return $returnval;
          } 
	printer::pclear(); 
     $empty=true;
     $directReturn='';
	if ($css_style!=='none'){//
          $csstype=($this->is_page)?'pagecss':'css';
           if ($directcss!==false&&!empty($directcss)){//direct css is css expressed directly with this->css.=   instead of collected and aggregrated with other css that is expressed under same classname through the main style editor
               if (!$overridecss){ 
                    foreach (array('rem','em','percent','px') as $ext){ 
                         if (!empty(${'current_'.$ext})){
                              $empty=false;
                              if ($ext==='rem'){
                                   $remscale=($this->rem_scale)?'px scaling on':'px scaling off';
                                   $pxequiv='&nbsp;&nbsp; = '.round($this->rem_root*${'current_'.$ext}).$remscale;
                                   }
                              elseif ($ext==='em'){
                                   $emscale=($this->terminal_em_scale)?'px scaling on':'px scaling off'; 
                                   $pxequiv='&nbsp;&nbsp; = '.round($this->terminal_font_em_px*${'current_'.$ext}).$emscale;
                                   }
                              else $pxequiv='';
                              $scaleunit=($ext==='percent')?'%':$ext;
                              $this->$csstype.=$directReturn="
          $directcss".'{'.$css_style.':'.$pos_neg.${'current_'.$ext}.$scaleunit.';}';
                              printer::print_notice('Active '.$msg.': '.$pos_neg.${'current_'.$ext}.$scaleunit.$pxequiv);
                              break;
                              } 
                         printer::pclear();
                         }//end foreach
                    if(!empty($ifempty)&&$empty) { //is empty 
                         $this->$csstype.=$directReturn=$directcss.'{'.$ifempty.'}';  
                         } 
                    }//if directcss not false or !empty
               else {//use cssoverride value
                    $this->$csstype.=$directReturn=$directcss.'{'.$overridevalue.'}';
                    } 
               } 
          else  {// direct css is false
               $fstyle='final_'.$style;
               $this->{$fstyle}[$val]='';
               $empty=true; 
               if (!$overridecss){ 
                    foreach (array('rem','em','percent','px') as $ext){
                         if (!empty(${'current_'.$ext})){ 
                              $empty=false; 
                              $scaleunit=($ext==='percent')?'%':$ext; 
                              $this->{$fstyle}[$val].=$css_style.':'.$pos_neg.${'current_'.$ext}.$scaleunit.';'; 
                             /*if (!empty($current_px)&&$ext!=='percent'){// when px is used it will be overriden by other units .
                                   $this->$csstype.='
html '.$this->pelement.'{'.$css_style.':'.$pos_neg.${'current_'.$ext}.$scaleunit.';}';//this is backup only
                                   }*/
                              if (strpos($css_style,'min-width')!==false){//if device width is less than min-width cancel min-width;
                                   $this->$csstype.='
          @media screen and (max-width: '.${'current_'.$ext}.$scaleunit.'){
               html '.$this->pelement.'{min-width:0px;}
               }';
                                   } 
                              break;
                              }//if !empty
                         }//foreach 
                   if ($empty&&!empty($ifempty)){
                         $this->{$fstyle}[$val]=$ifempty;
                         }  
                    }//!cssovverride
               else {
                    $this->{$fstyle}[$val]=$overridevalue;
                    }
               }//directcss is false 
           }//if css_style !none
     if(!empty($directReturn))return $directReturn;
     return (!empty($returnval))?true:false;
	} #end spacing  //end
   
 
function padding_bottom($style, $val, $field){ if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	$this->spacing($style,$val,'padding-bottom','Padding Bottom Spacing','Adding bottom padding-spacing creates space below this post, column, etc. Augments the background color and spacing within borders if either used!','hidepad','','','','','','Default Value 0 Check padding-bottom:0 to insure',array('zero'=>'padding-bottom:0;'));
	}

function padding_right($style, $val, $field){ if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	$this->spacing($style,$val,'padding-right','Padding Right Spacing','Adding right padding-spacing creates space on the right of this post, column, etc. Augments the background color and spacing within borders if either used!','hidepad','',true, '','','','Default Value 0 Check padding-right:0 to insure',array('zero'=>'padding-right:0;'));
	}


function padding_left($style, $val, $field){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
     $this->spacing($style,$val,'padding-left','Padding Left Spacing','Creates space on the left of this post, column, etc. Augments the background color and spacing within borders if either used!','hidepad','',true, $field,'','','Default Value 0. Check padding-left:0 to insure',array('zero'=>'padding-left:0;'));
	}
     
function padding_top($style, $val, $field){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	if ($this->is_page|| ($this->is_blog&&!$this->is_clone)||($this->is_column&&!$this->is_clone||$this->clone_local_style)){  
		static $topinc=0; $topinc++; 
          echo '<p class="highlight click  left floatleft" id="padding'.$topinc.'" title="Padding Spacing choices add spacing to your post, column, etc. If borders are used the space will be within the border. If backgrounds are used it will extend the background space."  onclick="edit_Proc.getTags(\'hidepad\',\'showhide\',id);return false;">Spacing by Padding</p>';
		printer::pclear();
		}
    $this->spacing($style,$val,'padding-top','Padding Top Spacing' ,'Creates space on the top of this post, column, etc. Augments the background color and spacing within borders if either used.','hidepad',false,'','','','','Default Value typically 0 check padding:0 to insure',array('zero'=>'padding-top:0;'));
	}

function margin_top($style, $val, $field){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	if ($this->is_page|| ($this->is_blog&&!$this->is_clone)||($this->is_column&&!$this->is_clone||$this->clone_local_style)){ 
		static $marginc=0; $marginc++; 
		echo '<p class="highlight click left floatleft" id="margin'.$marginc.'" title=" Margin Spacing also adds spacing to your post, column, etc. However, if borders are used the space will be outside of it and if a  background color is used  the spacing will be outside the background color!"  onclick="edit_Proc.getTags(\'hidemar\',\'showhide\',id);return false;">Spacing by Margin</p>';
		printer::pclear();
		}
	$this->spacing($style,$val,'margin-top','Margin top Spacing','Creates space on the top of this post, column, etc. The Space will be outside of borders or Background Colors if either is used!!','hidemar','','','','','','Default Value typically 0',array('auto'=>'margin-top:auto;','zero'=>'margin-top:0;'));  
	}  
function margin_bottom($style, $val, $field){ if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
     $this->spacing($style,$val,'margin-bottom','Margin Bottom Spacing','Creates space on the bottom of this post, column, etc. The Space will be outside of borders or Background Colors if either is used!!','hidemar','','','','','','Default Value typically 0',array('auto'=>'margin-bottom:auto;','zero'=>'margin-bottom:0;')); 
     }

function margin_right($style, $val, $field){ if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	if ($this->rwd_post&&strpos($style,'style')!==false)return; 
     $this->spacing($style,$val,'margin-right','Margin Right Spacing','Creates space to the right of this post, column, etc. that will be outside of borders or Background Colors if either is used!!','hidemar','',true,$field,'','','Typical Default Value: margin-right:auto; (for centering).',array('zero'=>'margin-right:0;','auto;'=>'margin-right:auto;'));
	}
     
function margin_left($style, $val, $field){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	if ($this->is_page|| ($this->is_blog&&!$this->is_clone)||($this->is_column&&!$this->is_clone||$this->clone_local_style)){ 
		if ($this->rwd_post&&strpos($style,'style')!==false){
			$this->show_more('RWD Margin Left Right Info','noback','info underline italic');
			printer::printx('<p class="fsminfo '.$this->column_lev_color.' editbackground editfont">When in RWD mode set left and right Spaces as options when choosing pos Grid units. The spaces will also be added as information in the total grid unit tracker!</p>'); 
			$this->show_close('RWD Margin Left Right Info');
			
			return;
			}
		}
	$this->spacing($style,$val,'margin-left','Margin Left Spacing','Creates space on the left of this post, column, etc. that  will be outside of borders or Background Colors if either is used!!','hidemar','',true,$field,'','','Default Value: margin-left:auto; (for centering)',array('zero'=>'margin-left:0;','auto;'=>'margin-left:auto;'));  
	}
	
function font_family($style, $val, $field,$show_style=false){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__); 
	$showstyle=($show_style)?'':' hide';
	if ($this->is_page|| ($this->is_blog&&!$this->is_clone)||($this->is_column&&!$this->is_clone||$this->clone_local_style)){  
		$msg= (empty($this->{$style}[$val]))? 'Default Value': str_replace(';','',str_replace('=>',',',$this->{$style}[$val]));  
		echo'<div class="fsminfo editcolor editbackground editfont '.$style.'_hidefont '.$showstyle.'" ><!--font family-->';
		$this->show_more('Font Family ', 'noback','editbackground editfont '.$this->column_lev_color.' italic info',' Choose the Font Family Style for this post here','500');
		$this->print_redwrap('font family');
          $this->submit_button();
          echo'<div class="fsminfo editbackground editfont"><!--font family-->';
		echo '<p class="fs1red"><span class="highlight" title="Select a new text style (font-family) for this post from the dropdown menu. View a image of how the text style looks, click the link below. Choose None to return to the inherited font-family value.  &#40;Inherited Parent Values are the most recent values that have been set in the parent Columns and if not set there then in the body or the default browser font if none has been chosen in any parent!!">Text Font Style: </span>Currently:<br><span class="'.$this->column_lev_color.'"> '.$msg.'</span></p>';
               $mod_val=str_replace(';','',$this->{$style}[$val]);
               $init= ($mod_val=='inherit')?'checked="checked"':'';
		   echo  "\n".'<p style="font-family:inherit" ><input type="radio" name="'.$style.'['.$val.']" '.$init.' value="inherit">inherit</p>';
             foreach ($this->fonts_all as $family){ 
			$mod_family=str_replace(',','=>',$family);
			$checked=(trim($mod_family)===trim($mod_val))?'checked="checked"':'';
			echo  "\n".'<p style="font-family:'.$family.';" ><input type="radio" name="'.$style.'['.$val.']" '.$checked.' value="'.$mod_family.';">'.$family.'</p>';
			}
		$this->submit_button();
		echo'</div><!--font family-->';
		printer::close_print_wrap('font family');
          $this->show_close('Font Family');
		echo'</div><!--font family-->';
		}
	$value=str_replace('=>',',',$this->{$style}[$val]);
	$v=str_replace(';','',$value);
	if (in_array($v,$this->fonts_extended)){
		$this->at_fonts[]=$v;
		}
	$value=rtrim(trim($value),';');
	$fstyle='final_'.$style;
	$this->{$fstyle}[$val]=(!empty($value))?'font-family: '.$value.';':'0';
	} 
 
function font_weight($style, $val, $field){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	if ($this->is_page|| ($this->is_blog&&!$this->is_clone)||($this->is_column&&!$this->is_clone||$this->clone_local_style)){  
		$msg= (empty($this->{$style}[$val]))? 'None ': $this->{$style}[$val];
		$selected=(!empty($this->{$style}[$val]))?$this->{$style}[$val]:400;
		echo '
		<div class="fsminfo editbackground editfont '.$style.'_hidefont hide"><!--font_weight--><p class="highlight" title="Select new Font Weight &#40;the thickness or relative boldness of the font&#41; from dropdown menu list. The normal default font-weight is 400 whereas the traditional bold font-weight is 700.">Font Weight: Currently '.$msg.'<br>
		<select class="editcolor editbackground editfont"  name="'.$style.'['.$val.']" id="'.$style.'_'.$val.'">        
		<option  value="'.$this->{$style}[$val].'" selected="selected">'.$selected.'</option>
		<option  value="0">Choose None</option>
		<option  value="100">100-Super Light Font</option>
		<option  value="200">200</option> 
		<option  value="300">300-slightly fainter</option>  
		<option  value="400">400-normal</option>  
		<option  value="500">500-slightly bold</option>
		<option  value="600">600</option>
		<option  value="700">700-bold</option>
		<option  value="800">800</option>
		<option  value="900">900-Super Bold</option>   
		</select>';
		echo'
		</p></div><!--font_weight-->';
		}
     $fstyle='final_'.$style;
     $this->{$fstyle}[$val]=(empty($this->{$style}[$val]))?'0':'font-weight: '.$this->{$style}[$val].'; ';
    }

function float($style,$val){
 	if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
     $msg= ($this->{$style}[$val]==='center'||$this->{$style}[$val]==='right'||$this->{$style}[$val]==='left')?  $this->{$style}[$val]:'Full Row (margin-right:auto;margin-left:auto;';
     $this->show_more('Float Right/Left/Center', 'noback','editbackground editfont highlight',' Choose to Position Next to instead of full Space',500);
	printer::print_tip('Use  no previous options to prevent floating with previous post and and then center, go left, go right depending on your choice');
     $current=($this->{$style}[$val]==='center'||$this->{$style}[$val]==='right'||$this->{$style}[$val]==='left')?$this->{$style}[$val]:'none';
     echo '
        <fieldset class="sfield"><legend></legend><p class="'.$this->column_lev_color.' editbackground editfont  Os3salmon fsminfo float">Float: Currently '.$msg.'<br>
    Float (positions along side) setting:<br>
         <select class="editcolor editbackground editfont"  name="'.$style.'['.$val.']" id="'.$style.'_'.$val.'">        
    <option  value="'.$this->{$style}[$val].'" selected="selected">'.$current.'</option>
    <option  value="center">Center Width</option> 
    <option  value="right">Float Right</option>
    <option  value="left">Float Left</option>
    <option  value="center no previous">Center Width No Previous</option> 
    <option  value="right no previous">Float Right No Previous</option>
    <option  value="left no previous">Float Left No Previous</option>
    <option value="none">None</option>
    </select>';
    echo $this->{$style}[$val]. ' is style val';
    switch ($this->{$style}[$val]){
          case 'center' :
               $floatstyle='margin-right:auto;margin-left:auto;';
               break;
          case 'right' :
               $floatstyle='float:right;';
               break;
          case 'left' :
               $floatstyle='float:left;';
               break;
          case 'center no previous' :
               $floatstyle='margin-right:auto;margin-left:auto;clear:both;';
               break;
          case 'right no previous' :
               $floatstyle='float:right;clear:both;';
               break;
          case 'left no previous' :
               $floatstyle='float:left;clear:both;';
               break; 
          case 'none' :
               $floatstyle='';
               break; 
          default :
               $floatstyle='';
               break;
          }
     echo'
    </p></fieldset>';
     $this->show_close('Float Right/Left');
     $fstyle='final_'.$style;
	$this->{$fstyle}[$val]=$floatstyle;
	}
function radius_corner($style, $val,$field){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	if (arrayhandler::is_empty_array($this->{$style}[$val])){//default may be set to 1
		$radius_array=array();
		for ($i=0; $i<18;$i++){ 
			$radius_array[$i]=0;
			}
		}
	else	{ //note that input type text will give 0value for defaults...
		$radius_array=explode('@@',$this->{$style}[$val]);
		for ($i=0; $i<18;$i++){ 
			if (!array_key_exists($i,$radius_array)){
				$radius_array[$i]=0;
				}
			}
		} 
	if ($this->is_page|| ($this->is_blog&&!$this->is_clone)||($this->is_column&&!$this->is_clone||$this->clone_local_style)){  
          $this->show_more('Radius Background', 'noback','editbackground editfont highlight',' Radius a Colored Post Background if in use Here!',500);
          $this->print_redwrap('wrap radius',false);
          echo '<p class="fsminfo editbackground editfont rad10 '.$this->column_lev_color.' editfont">As an Example we have used a radius around this text with a border to show the radius effect. A value of 10px was selected for each corner<br> <span class="italic"> Note that your Radius will only show up when background colors, box shadows, and borders are used</span> <br> Radius the stylized corners of Column, Posts, and Menu-Link Button Area, and Images directly.</p>'; 
          $check='checked="checked"';
          $checked1=($radius_array[4]!=='individual')?$check:'';
          $checked2=($radius_array[4]==='individual')?$check:'';
          printer::print_wrap('radio choice radius');
          printer::alert('<input type="radio" '.$checked1.' value="all" name="'.$style.'['.$val.'][4]">1.Activate Using one value choice for all four corners. Select from range of unit types. Note percentage units will round entire sides');
          printer::alert('<input type="radio" '.$checked2.' value="individual" name="'.$style.'['.$val.'][4]">2.Choose size for individual corner values using px units');
          printer::close_print_wrap('radio choice radius');
          $css_type=($radius_array[4]!=='individual')?'border-radius':'none';
          $this->spacing($style,$val,$css_type,'Radius All Corners','Creates Radius on all four background corners using one value &amp; multiple unit choices','','','','','',8);//allowing three xtra for incorporation of px radius scale units..
          $size1= (empty($radius_array[0])||!is_numeric($radius_array[0]))? '0':$radius_array[0];
          $this->show_more('or choose value for each corner in px');
          printer::print_wrap('individual radius');
          echo '<fieldset class="sfield"><legend></legend>
             <p class="'.$this->column_lev_color.' editbackground editfont">Choose: Top Left Radius:
              <select class="editcolor editbackground editfont"  name="'.$style.'['.$val.'][0]" >        
              <option  value="'.$radius_array[0].'" selected="selected">'.$radius_array[0].'</option>';
               for ($i=0; $i<95; $i+=1){
                  echo '<option  value="'.$i.'">'.$i.'</option>';
                  }
             
          echo'	
              </select></p>';
              printer::pclear(1);
               $size2= (empty($radius_array[1])||!is_numeric($radius_array[1]))? '0':$radius_array[1];
             echo '
             <p class="'.$this->column_lev_color.' editbackground editfont">Choose: Top Right Radius:
              <select class="editcolor editbackground editfont"  name="'.$style.'['.$val.'][1]" >        
              <option  value="'.$radius_array[1].'" selected="selected">'.$radius_array[1].'</option>';
          for ($i=0; $i<95; $i+=1){
               echo '<option  value="'.$i.'">'.$i.'</option>';
               }
          echo'	
              </select></p>';
               $size3= (empty($radius_array[2])||!is_numeric($radius_array[2]))? '0':$radius_array[2];
             echo '
             <p class="'.$this->column_lev_color.' editbackground editfont"> Choose: Bottom Right Radius:
              <select class="editcolor editbackground editfont"  name="'.$style.'['.$val.'][2]" >        
              <option  value="'.$radius_array[2].'" selected="selected">'.$radius_array[2].'</option>';
          for ($i=0; $i<95; $i+=1){
               echo '<option  value="'.$i.'">'.$i.'</option>';
               }
          echo'	
              </select></p>';
          $size4= (empty($radius_array[3])||!is_numeric($radius_array[3]))? '0':$radius_array[3];
             echo '
               <p class="'.$this->column_lev_color.' editbackground editfont">Choose: Bottom Left Radius:
               <select class="editcolor editbackground editfont"  name="'.$style.'['.$val.'][3]" >        
               <option  value="'.$radius_array[3].'" selected="selected">'.$radius_array[3].'</option>';
               for ($i=0; $i<95; $i+=1){
                    echo '<option  value="'.$i.'">'.$i.'</option>';
                    }
          echo'	
              </select></p>';
          echo'</fieldset>';
          printer::close_print_wrap('individual radius'); 
          $this->show_close('or choose value for each corner in px');
          $this->submit_button();
          printer::close_print_wrap('wrap radius');
          $this->show_close('radius');
		}// if page or clone and not local style 
	if ($css_type==='none'&&(!empty($size1)||!empty($size2)||!empty($size3)||!empty($size4))){
          $radiuscss='
		-webkit-border-radius: '.$size1.'px '.$size2.'px '.$size3.'px '.$size4.'px;
	border-radius: '.$size1.'px '.$size2.'px '.$size3.'px '.$size4.'px;
		';
          $fstyle='final_'.$style;
          $this->{$fstyle}[$val]=$radiuscss;
          } 
	}//end fuc radius

function transform($style, $val,$field){ 
	if (arrayhandler::is_empty_array($this->{$style}[$val])){//default may be set to 1
		$transform_array=array();
		 for ($i=0; $i<3;$i++){ 
			$transform_array[$i]=0;
			}
		}
	else	{ //note that input type text will give 0value for defaults...
		$transform_array=explode('@@',$this->{$style}[$val]);
		for ($i=0; $i<3;$i++){ 
			if (!array_key_exists($i,$transform_array)||empty($transform_array[$i])){
				$transform_array[$i]=0;
				}
			}
		}   
	if ($this->is_page|| ($this->is_blog&&!$this->is_clone)||($this->is_column&&!$this->is_clone||$this->clone_local_style)){   
		$this->show_more('Rotate/Skew', 'noback','highlight editbackground editfont',' Rotate or Skew the Content of this post!',500);
		//echo '<div class="fs2moccasin editbackground editfont editcolor"><!--tranform border-->';
		$this->print_redwrap('transform',false);
		echo '<p class="fsminfo editbackground editfont rad5 skewx3 '.$this->column_lev_color.' editfont">we have demonstrated a skew Xdirection of 4 degrees around this text to show the transform option in practice.  Be sure to allow enough width for your final effect! For more info on using the css3 transform feature and examples see <a href="http://www.w3schools.com/cssref/css3_pr_transform.asp"> Column Examples</a></p>'; 
          $size= (empty($transform_array[0]))? '0':$transform_array[0];
		echo '
		<p class="'.$this->column_lev_color.' editbackground editfont">Degrees of Rotation: Currently '.$size.'<br>
		 <span class="editcolor editbackground editfont">Choose Rotation Degrees:</span>
		 <select class="editcolor editbackground editfont"  name="'.$style.'['.$val.'][0]" >        
		 <option  value="'.$transform_array[0].'" selected="selected">'.$transform_array[0].'</option>';
		for ($i=-90; $i<-15; $i+=5){
			echo '<option  value="'.$i.'">'.$i.'&#176;</option>';
			}
		for ($i=-15; $i<15; $i+=1){
			echo '<option  value="'.$i.'">'.$i.'&#176;</option>';
			}
		for ($i=15; $i<90; $i+=5){
			echo '<option  value="'.$i.'">'.$i.'&#176;</option>';
			}
		echo'	
		 </select></p>';
		$size= (empty($transform_array[1]))? '0':$transform_array[1];
		echo'<p class="'.$this->column_lev_color.' editbackground editfont">Skew Xdirection  Degrees: Currently '.$size.'<br>
		 <span class="editcolor editbackground editfont">Choose Skew Xdirection Degrees:</span>
		 <select class="editcolor editbackground editfont"  name="'.$style.'['.$val.'][1]" >        
		 <option  value="'.$transform_array[1].'" selected="selected">'.$transform_array[1].'</option>';
		for ($i=-45; $i<-15; $i+=5){
			echo '<option  value="'.$i.'">'.$i.'&#176;</option>';
			}
		for ($i=-15; $i<15; $i+=1){
			echo '<option  value="'.$i.'">'.$i.'&#176;</option>';
			}
		for ($i=15; $i<50; $i+=5){
			echo '<option  value="'.$i.'">'.$i.'&#176;</option>';
			}
		echo'	
		 </select></p>';
		$size= (empty($transform_array[2]))? '0':$transform_array[2];
		echo'<p class="'.$this->column_lev_color.' editbackground editfont">Skew Ydirection Degrees: Currently '.$size.'<br>
		 <span class="editcolor editbackground editfont">Choose Skew Ydirection Degrees:</span>
		 <select class="editcolor editbackground editfont"  name="'.$style.'['.$val.'][2]" >        
		 <option  value="'.$transform_array[2].'" selected="selected">'.$transform_array[2].'</option>';
		for ($i=-45; $i<-15; $i+=5){
			echo '<option  value="'.$i.'">'.$i.'&#176;</option>';
			}
		for ($i=-15; $i<15; $i+=1){
			echo '<option  value="'.$i.'">'.$i.'&#176;</option>';
			}
		for ($i=15; $i<50; $i+=5){
			echo '<option  value="'.$i.'">'.$i.'&#176;</option>';
			}  
		echo'	
		 </select></p>';
          $this->submit_button();
		printer::close_print_wrap('transform');
		$this->show_close('tranform border');
		}
	$transformcss='
	-moz-transform: rotate('.$transform_array[0].'deg) skewX('.$transform_array[1].'deg) skewY('.$transform_array[2].'deg);
	-webkit-transform: rotate('.$transform_array[0].'deg) skewX('.$transform_array[1].'deg) skewY('.$transform_array[2].'deg);
	-o-transform: rotate('.$transform_array[0].'deg) skewX('.$transform_array[1].'deg) skewY('.$transform_array[2].'deg);
	-ms-transform: rotate('.$transform_array[0].'deg) skewX('.$transform_array[1].'deg) skewY('.$transform_array[2].'deg);
	transform: rotate('.$transform_array[0].'deg) skewX('.$transform_array[1].'deg) skewY('.$transform_array[2].'deg);
	';
	 
	$transformcss= (empty($transform_array[0])&&empty($transform_array[1])&&empty($transform_array[2]))?'':$transformcss;
	$fstyle='final_'.$style;
	$this->{$fstyle}[$val]=$transformcss;
	}

function columns($style, $val,$field){ 
	if (arrayhandler::is_empty_array($this->{$style}[$val])){//default may be set to 1
		$column_array=array();
		for ($i=0; $i<3;$i++){ 
			$column_array[$i]=1;
               }
		}
	else	{ //note that input type text will give 0value for defaults...
		$column_array=explode('@@',$this->{$style}[$val]);
		for ($i=0; $i<3;$i++){ 
			if (!array_key_exists($i,$column_array)||$column_array[$i]==1){
				$column_array[$i]=1;
					}
			}
		}
	if ($this->is_page|| ($this->is_blog&&!$this->is_clone)||($this->is_column&&!$this->is_clone||$this->clone_local_style)){  
		$this->show_more('Multiple Columns', 'noback','highlight editbackground editfont',' turn this text into 2 or more columns',300);
		$this->print_redwrap('multiple cols');
		echo '<p class="column2 '.$this->column_lev_color.' fsminfo editbackground editfont rad3 editfont">This text you are reading was set up with 2 columns and a space of 16px between the columns with no divider line showing. The columns will be split between the available width.<br>For quick overview of using the css3 column feature and examples see <a href="http://css-tricks.com/snippets/css/css-box-column/"> Column Examples.</a><br> </p>';
		printer::pclear(8);
		   $size= (empty($column_array[0]))? 'One':$column_array[0];
		echo '
		<p class="'.$this->column_lev_color.' editbackground editfont">Choose the number of columns: Currently '.$size.'<br>
		<span class="editcolor editbackground editfont">Choose # of Columns:</span>
		<select class="editcolor editbackground editfont"  name="'.$style.'['.$val.'][0]" >        
		<option  value="'.$column_array[0].'" selected="selected">'.$column_array[0].'</option>';
		for ($i=1; $i<6; $i+=1){
			echo '<option  value="'.$i.'">'.$i.'</option>';
			}
		 echo'	
		 </select></p>';
		$size= (empty($column_array[1]))? 'None':$column_array[1];
		echo'<p class="'.$this->column_lev_color.' editbackground editfont">Choose the spacing between columns Currently '.$size.' px <br>
		<span class="editcolor editbackground editfont">Choose Spacing between columns:</span>
		<select class="editcolor editbackground editfont"  name="'.$style.'['.$val.'][1]" >        
		<option  value="'.$column_array[1].'" selected="selected">'.$column_array[1].'</option>';
		for ($i=0; $i<200; $i+=1){
			 echo '<option  value="'.$i.'">'.$i.'px</option>';
			}
		echo'	
		</select></p>'; 
		$column_array[2]=($column_array[2]==='Line Separator True')?$column_array[2]:'Line Separator False';
		echo'<p class="'.$this->column_lev_color.' editbackground editfont">Show  line Separator Between Columns: Currently '.$column_array[2].'<br>
		<span class="editcolor editbackground editfont">Choose Show Divider:</span>
		<select class="editcolor editbackground editfont"  name="'.$style.'['.$val.'][2]" >        
		<option  value="'.$column_array[2].'" selected="selected">'.$column_array[2].'</option>';
		echo '<option  value="Line Separator False">Line Separator False</option> 
			<option  value="Line Separator True">Line Separator True</option> 
               </select></p>';
          $this->submit_button(); 
		printer::close_print_wrap('multiple cols');
		$this->show_close('multiple columns');
		}   
	$col=(!empty($this->{$style}[$this->font_color_index]))?$this->{$style}[$this->font_color_index]:$this->editor_color;
	 //color was transformed by color funct so need to replace
	$col=trim(str_replace(array('color',':','#',';'),'',$col));
	$line=($column_array[2]==='Line Separator True')?'-moz-column-rule: 1px solid #'.$col.'; -webkit-column-rule: 1px solid #'.$col.';  column-rule: 1px solid #'.$col.';':'';
	$columncss='
	-moz-column-count: '.$column_array[0].';
	-moz-column-gap: '.$column_array[1].'px;
	-webkit-column-count: '.$column_array[0].';
	-webkit-column-gap: '.$column_array[1].'px;
	column-count: '.$column_array[0].';
	column-gap: '.$column_array[1].'px;
	'.$line;
	$columncss= (empty($column_array[0])||$column_array[0]<2)?'':$columncss;
	$fstyle='final_'.$style;
	$this->{$fstyle}[$val]=$columncss;
	}

function borders($style, $val,$field){ 
	static $inc=0; $inc++; 	
	$border_sides=$this->border_sides;
     $css_id=$this->pelement;
	//array('No Border','top bottom left right','top bottom','top','bottom','left','right','top left','top right','bottom left','bottom right','left right','Force No Border');
	if (arrayhandler::is_empty_array($this->{$style}[$val])){//default may be set to 1
		$parr=$border_array=array();
		for ($i=0; $i<8;$i++){ 
			$border_array[$i]=0;
			}
		}
	else	{ //note that input type text will give 0value for defaults...
		$parr=$border_array=explode('@@',$this->{$style}[$val]);
		for ($i=0; $i<8;$i++){ 
			if (!array_key_exists($i,$border_array)){
				$border_array[$i]=0;
				}
			}
		}  
     $border_opacity=(!empty($border_array[4])&&$border_array[4]<100&&$border_array[4]>0)?$border_array[4]:100;
	$blog_border_sides=$border_array[3]=(!empty($border_array[3])&&in_array($border_array[3],$border_sides))?$border_array[3]:'No Border';
	$border_line=$border_array[0]= (is_numeric($border_array[0])&&$border_array[0]>0)? $border_array[0]:0;
     $border_line=round($border_line,1);
	$px='px ';
     $scaleunit=(!empty($border_array[7])&&$border_array[7]==='em'||$border_array[7]==='rem')?$border_array[7]:'none'; 
	$border_value2=(!empty($border_array[8])&&is_numeric($border_array[8]))?$border_array[8]:0;
     if ($scaleunit!=='none'&&!empty($border_value2)){
          $msginfo=printer::print_notice('em/rem unit active: '.$border_value2.$scaleunit,.9,1);
          $border_line=$border_value2;
          $px=$scaleunit;
          }
     else $msginfo=printer::print_notice('No active em/rem unit',.9,1);
	switch ($border_array[3]) { 
          case $border_sides[1]:# all
               $border_width="$border_line$px $border_line$px $border_line$px $border_line$px";
               $barr=$border_line.'x@x@x'.$border_line.'x@x@x'.$border_line.'x@x@x'.$border_line;
               break;
          case $border_sides[2]:# top bottom
               $border_width=" $border_line$px 0 $border_line$px 0";
                $barr=$border_line.'x@x@x0x@x@x'.$border_line.'x@x@x0';
               break; 
          case $border_sides[3]:# top
               $border_width="$border_line$px 0 0 0";
                $barr=$border_line.'x@x@x0x@x@x0x@x@x0';
               break;
          case $border_sides[4]:# bottom
               $border_width="0 0 $border_line$px 0";
                $barr='0x@x@x0x@x@x'.$border_line.'x@x@x0';
               break;
          case $border_sides[5]:# left
               $border_width="0 0 0 $border_line$px";
                $barr='0x@x@x0x@x@x0x@x@x'.$border_line;
               break;
          case $border_sides[6]:# right
               $border_width="0 $border_line$px 0 0";
                $barr='0x@x@x'.$border_line.'x@x@x0x@x@x0';
               break;
          case $border_sides[7]:# top left
               $border_width="$border_line$px 0 0 $border_line$px";
                $barr=$border_line.'x@x@x0x@x@x0x@x@x'.$border_line;
               break;
          case $border_sides[8]:# top right
               $border_width="$border_line$px $border_line$px 0 0";
               $barr=$border_line.'x@x@x'.$border_line.'x@x@x0x@x@x0';
               break;
          case $border_sides[9]:# bottom left
               $border_width="0 0 $border_line$px $border_line$px";
               $barr='0x@x@x0x@x@x'.$border_line.'x@x@x'.$border_line;
               break;
          case $border_sides[10]:# bottom right
               $border_width="0 $border_line$px $border_line$px  0";
                $barr='0x@x@x'.$border_line.'x@x@x'.$border_line.'x@x@x0';
               break;
          case $border_sides[11]:# left right
               $border_width="0 $border_line$px 0 $border_line$px";
                $barr='';
               break;
          case $border_sides[12]:# force no border
               $border_width='0';
                $barr='';
               break;
          default:
          $border_width=0;
          $barr='';	 
          }//end switch 
     if ($scaleunit!=='none'&&!empty($border_value2))$barr=0;
	$blog_border_color=$border_array[1]=(preg_match(Cfg::Preg_color,$border_array[1]))?$border_array[1]:'';
	if (!empty(trim($blog_border_color))){
		if ($border_opacity <100) 
			$br_color=process_data::hex2rgba($blog_border_color,$border_opacity);
		else $br_color='#'.$blog_border_color;
		$border_color='border-color: '.$br_color.';'; 
		}
	else $border_color='';
     $border_types=array('dotted','dashed','solid','double','groove','ridge','inset','outset');
	$border_value=(is_numeric($border_array[0])&&$border_array[0]<=100)?$border_array[0]:0; 
     $blog_border_type=$border_array[2]=(!empty($border_array[2])&&in_array($border_array[2],$border_types))?$border_array[2]:'solid';
	if ($this->is_page|| ($this->is_blog&&!$this->is_clone)||($this->is_column&&!$this->is_clone||$this->clone_local_style)){  
		$this->show_more('Border styling','noback','editfont highlight editbackground editfont', 'For Information on Borders and to Choose Border Type, Colors, and Edges click Here',500);
		$this->print_redwrap('border styling wrap');
		echo '<div class="Os2maroon fs1color  editbackground editfont"><!--Border sides-->';
		echo '<p style="margin:13px; padding:13px;border-width: 3px 0 3px 0; border-style:double; border-color:#'.$this->aqua.';" class="'.$this->column_lev_color.' editbackground editfont"><!--End function border style-->We have used a light blue border selecting top and bottom around this text with a border type: double and a border thickness of 4'.$px.'. Borders are lines dashes dots,etc. stylize around columns, posts, groups of posts or menu link &#34;buttons&#34; depending on which of these you are currently styling! <br></p>'; 
		printer::spanclear(5);
          printer::print_wrap('choose sides');
		echo'<p class="'.$this->column_lev_color.' editbackground editfont">Choose Border Profile (Top Bottom Sides) Currently: '.$border_array[3].'<br></p>';
          printer::print_tip('Use the Force No Border Option for explicit border-width:0; if necessary in navigation menus (ie sub menu vs top menu');
		echo '<p class="editcolor editbackground editfont" title="For Example Choose top bottom left right for a normal box border around the entire column, or if wish to show a border only around one or two sides for expample, the top and right, choose the top right option instead">Border Sides Info';
		echo '<select class="editcolor editbackground editfont"  name="'.$style.'['.$val.'][3]" >        
		<option  value="'.$border_array[3].'" selected="selected">'.$border_array[3].'</option>'; 
		foreach ($border_sides as $type){
			echo'<option  value="'.$type.'">'.$type.'</option> ';
			}
		echo '</select></p>';
		printer::close_print_wrap('choose sides');
          printer::print_wrap('px border');
		echo'<p class="editfont editcolor left5 editbackground editfont"> Border Line Thickness:';
          $this->mod_spacing($style.'['.$val.'][0]',$border_value,0,100,1,'px');
		$css_style=(!empty($barr)&&$border_array[3]!=='No Border'&&!empty($blog_border_color))?'border-width':'none'; 
          $parr[0]=$barr;
          $parr=implode('@@',$parr);
          $this->rwd_scale($parr,$style.'['.$val.']',$css_id,$css_style,'border-width','px',0,5,true); 
          printer::close_print_wrap('px border'); 
		printer::spanclear(5);
          #############
          echo $msginfo;
          printer::pclear(5);
          $this->show_more('Use other border-size units');
          $this->print_redwrap('other bordersize units');
          $more='';/*(!$this->is_page&&(!$this->col_primary||$this->is_blog))?'
4. Choose VW units.':'';*/
          printer::print_tip('OR Choose alt border-size units here.  <b>You can optionally enable scaling (responive size according to viewport) for rem (appropriately between the upper and lower viewport size of your choice) and similarly for em under font-size choice.'); 
          printer::print_tip('Choose value and unit type.');
	     $checked=' checked="checked" ';
          $checked1=($scaleunit==='none')?$checked:'';
          $checked2=($scaleunit==='em')?$checked:'';
          $checked3=($scaleunit==='rem')?$checked:'';   
          printer::alert('Choose scale unit:');
          printer::alert('<input type="radio" name="'.$style.'['.$val.'][7]" value="none" '.$checked1.'>None');
          printer::alert('<input type="radio" name="'.$style.'['.$val.'][7]" value="em" '.$checked2.'>em units');
          printer::alert('<input type="radio" name="'.$style.'['.$val.'][7]" value="rem" '.$checked3.'>rem units'); 
          // (!$this->is_page&&(!$this->col_primary||$this->is_blog))&&printer::alert('<input type="radio" name="'.$style.'['.$val.'][1]" value="vw" '.$checked4.'>vw units'); 
          printer::pclear(5);
          echo'<p class="'.$this->column_lev_color.' editbackground editborder">Scalable border Size: Currently '.$border_value2.'<br>
          Choose:';
          $this->mod_spacing($style.'['.$val.'][8]',$border_value2,0,10,.1,'unit');
		echo'	
	    </select></p>';
          $this->submit_button();  
          printer::close_print_wrap('other bordersize units');  
          $this->show_close('Use other border-size units');
          printer::pclear(5);
          printer::print_wrap('border color');
          $span_color=(!empty($border_array[1]))?'<span class="fs1npred" style="background-color:#'.$border_array[1].';">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>':''; 
		printer::alert('Set border Color <input onclick="jscolor.installByClassName(\'border_id'.$inc.'_'.self::$xyz.'\');" style="cursor:pointer;background:#'.$this->editor_background.';color:#'.$this->editor_color.';" type="text" name="'.$style.'['.$val.'][1]" id="border_id'.$inc.'_'.self::$xyz.'" value="'.$border_array[1].'" size="12" maxlength="6" class="border_id'.$inc.'_'.self::$xyz.' {refine:false}">'.$span_color.'<br>',false,'left editcolor editbackground editfont');
          printer::close_print_wrap('border color');
          printer::print_wrap1('border opacity');
          echo '<p class="editcolor editbackground editfont ">Change Border  Opacity: '.$border_opacity.'% </p>';
		$this->mod_spacing($style.'['.$val.'][4]',$border_opacity,0,100,1,'%');
          printer::close_print_wrap1('border opacity');
		echo'<p class="left '.$this->column_lev_color.'">Set Border Type Currently: '.$border_array[2].'<br>
		<span class="editcolor editbackground editfont">Border Type:</span>
		<select class="editcolor editbackground editfont"  name="'.$style.'['.$val.'][2]" >        
		<option  value="'.$border_array[2].'" selected="selected">'.$border_array[2].'</option>'; 
		foreach ($border_types as $type){
			echo'<option  value="'.$type.'">'.$type.'</option> ';
			}
		echo '</select></p>';
		echo '</div><!--End function border style-->';
		printer::spanclear(5); 
          $this->submit_button();
		printer::close_print_wrap('border styling wrap');
		$this->show_close('Border styling');
		}//if !clone || local style
     $fstyle='final_'.$style;
     $this->{$fstyle}[$val]=($border_array[3]=='Force No Border'||($border_array[3]!='No Border'&&!empty($blog_border_color)))?$this->{$style}[$val]='border-width: '.$border_width.'; border-style:'. $blog_border_type.';'.$border_color:'';//this 
     }//end   borders

function outlines($style, $val,$field){ 
	static $inc=0; $inc++; 
	$px='px'; 
	if (arrayhandler::is_empty_array($this->{$style}[$val])){//default may be set to 1
		$outline_array=array();
		 for ($i=0; $i<3;$i++){ 
			$outline_array[$i]=0;
			}
		}
	else	{ //note that input type text will give 0value for defaults...
		$outline_array=explode('@@',$this->{$style}[$val]);
		for ($i=0; $i<3;$i++){ 
			if (!array_key_exists($i,$outline_array)){
				$outline_array[$i]=0;
				}
			}
		}
	$outline_width=(is_numeric($outline_array[0])&&$outline_array[0]<81)?$outline_array[0]:0;
	$blog_outline_color=$outline_array[1]=(preg_match(Cfg::Preg_color,$outline_array[1]))?$outline_array[1]:'';
	$outline_types=array('dotted','dashed','solid','double','groove','ridge','inset','outset');
	$blog_outline_type=$outline_array[2]=(!empty($outline_array[2])&&in_array($outline_array[2],$outline_types))?$outline_array[2]:'solid';
	if ($this->is_page|| ($this->is_blog&&!$this->is_clone)||($this->is_column&&!$this->is_clone||$this->clone_local_style)){  
          $this->show_more('Outline Styling','noback','editfont highlight editbackground editfont', 'For Information on outlines and to Choose outline Type, Colors, and Edges click Here',500);
          $this->print_redwrap('outline style');
		echo '<div class="fsminfo editcolor editbackground editfont"><!--  outline style-->';
		printer::alertx('<p class="Os4ekblue">We have used a blue outline around this text with a outline type: single and a outline thickness of 4px. Outlines are similar to borders except 4 sides always. They wrap around outside of borders (if used). Create and stylize these around columns, posts, groups of posts or menu links as needed<br></p>'); 
		printer::spanclear(5);
		echo'<p class="editfont left5 editbackground editfont"> outline Line Thickness:
		<select class="editcolor editbackground editfont"  name="'.$style.'['.$val.'][0]" >        
		<option  value="'.$outline_array[0].'" selected="selected">'.$outline_array[0].$px.'</option>';
		for ($i=0; $i< 81; $i+=1){
			echo '<option  value="'.$i.'">'.$i.$px.'</option>';
			}
		 echo'	
		</select></p>';
		printer::spanclear(5);
		$span_color=(!empty($outline_array[1]))?'<span class="fs1npred" style="background-color:#'.$outline_array[1].';">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>':''; 
		printer::alert('Set outline Color Here.  Use 0 or non color to remove outline<input onclick="jscolor.installByClassName(\'outline_id'.$inc.'_'.self::$xyz.'\');" style="cursor:pointer;background:#'.$this->editor_background.';color:#'.$this->editor_color.';" type="text" name="'.$style.'['.$val.'][1]" id="outline_id'.$inc.'_'.self::$xyz.'" value="'.$outline_array[1].'" size="12" maxlength="6" class="outline_id'.$inc.'_'.self::$xyz.' {refine:false}">'.$span_color.'<span style="font-size: 1.1em; color: yellow;" id="outline_id'.$inc.'_'.self::$xyz.'instruct"></span><br>',false,'left editcolor editbackground editfont'); 
		echo'<p class="left '.$this->column_lev_color.'">Set outline Type Currently: '.$outline_array[2].'<br>
		<span class="editcolor editbackground editfont">outline Type:</span>
		<select class="editcolor editbackground editfont"  name="'.$style.'['.$val.'][2]" >        
		<option  value="'.$outline_array[2].'" selected="selected">'.$outline_array[2].'</option>'; 
		foreach ($outline_types as $type){
			echo'<option  value="'.$type.'">'.$type.'</option> ';
			}
          $this->submit_button();
		echo '</select></p>';
		echo '</div><!--  outline style-->';
		printer::spanclear(5);
          printer::close_print_wrap('outline style');
		$this->show_close('Style Table params');//<!--Show More outline Style Table params-->'; 
		}//if editable
	$fstyle='final_'.$style; 
	$this->{$fstyle}[$val]=(preg_match(Cfg::Preg_color,$blog_outline_color))?$this->{$style}[$val]='outline-width: '.$outline_width.'px; outline-style:'. $blog_outline_type.'; outline-color:  #'.$blog_outline_color.';':'';//this
	}//end fun outlines

function box_shadow($style, $val,$field){
	static $inc=0;  $inc++;   
	if (arrayhandler::is_empty_array($this->{$style}[$val])){ 
		$shadow_array=array();
		for ($i=0; $i<6;$i++){ 
			$shadow_array[$i]=0;
			}
		}
	else	{ //note that input type text will give 0value for defaults...
		$shadow_array=explode('@@',$this->{$style}[$val]);
		for ($i=0; $i<6;$i++){ 
			if (!array_key_exists($i,$shadow_array)){
				$shadow_array[$i]=0;
				}
			}
		}
	$shadow_array[$this->shadowbox_blur_radius_index]= (empty($shadow_array[$this->shadowbox_blur_radius_index]))? 0:$shadow_array[$this->shadowbox_blur_radius_index];
	$shadow_array[$this->shadowbox_spread_radius_index]= (empty($shadow_array[$this->shadowbox_spread_radius_index]))? 0:$shadow_array[$this->shadowbox_spread_radius_index];
	$shadow_array[$this->shadowbox_horiz_offset_index]= (empty($shadow_array[$this->shadowbox_horiz_offset_index]))? 0:$shadow_array[$this->shadowbox_horiz_offset_index];
	$shadow_array[$this->shadowbox_insideout_index]= ($shadow_array[$this->shadowbox_insideout_index]!=='inset')? '':'inset';	
	$shadow_array[$this->shadowbox_vert_offset_index]= (empty($shadow_array[$this->shadowbox_vert_offset_index]))? 0:$shadow_array[$this->shadowbox_vert_offset_index];
	if (!preg_match(Cfg::Preg_color,$shadow_array[$this->shadowbox_color_index]))$shadow_array[$this->shadowbox_color_index]="0";
	if ($this->is_page|| ($this->is_blog&&!$this->is_clone)||($this->is_column&&!$this->is_clone||$this->clone_local_style)){  
		$this->show_more('Box Shadow', 'noback','editfont highlight editbackground editfont',' add a Shadow around this text or image post',500);  
		$this->print_redwrap('Box shadow',false);
		echo '<p class="fbs1info '.$this->column_lev_color.' whitebackground editfont">We have used a maroon box shadow effect on the bottom right of this text. <span class="highlight" title="Blur Radius: 7px; Spread Radius -6px; Horizontal Offset: 4px; Vertical Offset: 4px; Color:#f7f2a8;">See Settings</span> for this box shadow!<br>Like Borders, Box Shadows provide styling around a Column Post or Menu Link Area, though providing a customizable shadow instead. For a quick overview  and examples see <a href="http://css-tricks.com/snippets/css/css-box-shadow/">Shadow Examples.</a>  </p>';
		printer::pclear(8);
		echo '<p class="fsminfo editbackground editfont rad3 floatleft '.$this->column_lev_color.' editfont">Shadow may be an outside box shadow (recommended for styling directly around images or an inside box shadow :<br> ';
          $checked2=($shadow_array[$this->shadowbox_insideout_index]==='inset')?'checked="checked"':''; 
          $checked1=($shadow_array[$this->shadowbox_insideout_index]!=='inset'&&$shadow_array[$this->shadowbox_insideout_index]!=='forceoff')?'checked="checked"':'';
          $checked3=($shadow_array[$this->shadowbox_insideout_index]==='forceoff')?'checked="checked"':''; 
          printer::alertx('<span class="editcolor editbackground editfont"><input type="radio" value="outset" '.$checked1.' name="'.$style.'['.$val.'][5]">Choose Outside Box Shadow</span><br>');
          printer::alertx('<span class="editcolor editbackground editfont"><input type="radio" value="inset" '.$checked2.' name="'.$style.'['.$val.'][5]">Choose Inside Box Shadow</span>');
          if(($this->is_blog&&$this->blog_type==='navigation_menu')||$shadow_array[$this->shadowbox_insideout_index]==='forceoff')
               printer::alertx('<br><span class="editcolor editbackground editfont"><input type="radio" value="forceoff" '.$checked3.' name="'.$style.'['.$val.'][5]">Turn off Box Shadow (ie. if necesary in Nav Sub Menu)</span></p>');
          else printer::alertx('</p>');
          printer::pspace(4); 
		echo ' <p class="fsminfo editbackground editfont rad3 '.$this->column_lev_color.' editfont">The blur radius: 
		If set to 0 the shadow will be sharp, the higher the number, the more blurred it will be: ';
		echo ' <span class="'.$this->column_lev_color.' left5 editbackground editfont">Currently '.$shadow_array[$this->shadowbox_blur_radius_index].'</span><br>
		<span class="editcolor editbackground editfont">Choose Blur Radius:</span>
	    <select class="editcolor editbackground editfont"  name="'.$style.'['.$val.'][2]" >        
	    <option  value="'.$shadow_array[$this->shadowbox_blur_radius_index].'" selected="selected">'.$shadow_array[$this->shadowbox_blur_radius_index].'</option>';
	    for ($i=0; $i<30; $i+=1){
		   echo '<option  value="'.$i.'">'.$i.'px</option>';
		   }
          echo '</select></p>';
		echo ' <p class="fsminfo editbackground editfont rad3 '.$this->column_lev_color.' editfont">The spread radius gives all sides even shadow width: A positive values increase the size of the shadow
		 whereas negative values decrease the size: ';
		echo ' <span class="'.$this->column_lev_color.' left5 editbackground editfont">Currently '.$shadow_array[$this->shadowbox_spread_radius_index].'</span><br>
	    <span class="editcolor editbackground editfont">Choose New Spread Radius:</span>
	    <select class="editcolor editbackground editfont"  name="'.$style.'['.$val.'][3]" >        
	    <option  value="'.$shadow_array[$this->shadowbox_spread_radius_index].'" selected="selected">'.$shadow_array[$this->shadowbox_spread_radius_index].'</option>';
          for ($i=-5; $i<30; $i+=1){
               echo '<option  value="'.$i.'">'.$i.'px</option>';
               }
          echo '</select></p>';
		echo '<p class="fsminfo editbackground editfont rad3 '.$this->column_lev_color.' editfont">Box Shadow Horizonal offet, more negative value  means more on left side of the box, positive right: '; 
          echo '<span class="'.$this->column_lev_color.' left5 editbackground editfont">Currently '.$shadow_array[$this->shadowbox_horiz_offset_index].'</span><br> 
	    <span class="editcolor editbackground editfont left">Choose: Horizontal offset:</span>
	    <select class="editcolor editbackground editfont"  name="'.$style.'['.$val.'][0]" >        
	    <option  value="'.$shadow_array[$this->shadowbox_horiz_offset_index].'" selected="selected">'.$shadow_array[$this->shadowbox_horiz_offset_index].'</option>';
          for ($i=-30; $i<30; $i+=1){
               echo '<option  value="'.$i.'">'.$i.'px</option>';
               }
          echo'	
	    </select></p>';
		echo '<p class="fsminfo editbackground editfont rad3 '.$this->column_lev_color.' editfont">Box Shadow Vertical offet, more negative value means more above the box, more positive more below: ';
		echo '   <span class="'.$this->column_lev_color.' left5  editbackground editfont">Currently '.$shadow_array[$this->shadowbox_vert_offset_index].'</span><br>
		<span class="editcolor editbackground editfont">Choose: Vertical offset:</span>
	    <select class="editcolor editbackground editfont"  name="'.$style.'['.$val.'][1]" >        
	    <option  value="'.$shadow_array[$this->shadowbox_vert_offset_index].'" selected="selected">'.$shadow_array[$this->shadowbox_vert_offset_index].'</option>';
	    for ($i=-30; $i<30; $i+=1){
               echo '<option  value="'.$i.'">'.$i.'px</option>';
               }
          echo'	
		 </select></p>';
		echo '<p class="fsminfo editbackground editfont rad3 '.$this->column_lev_color.' editfont">Use 0 to remove box shadow<br>You Color Choice Can Also Produce a More or Less Subtle Shadow Effect!:</p> ';
		$span_color=(!empty($shadow_array[$this->shadowbox_color_index]))?'<span class="fs1npred" style="background-color:#'.$shadow_array[$this->shadowbox_color_index].';">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>':''; 
		if (preg_match(Cfg::Preg_color,$shadow_array[$this->shadowbox_color_index])){
			$msg="Change the Current Shadow Color: #";
			}
		else {
			$msg= (!empty($shadow_array[$this->shadowbox_color_index]))?$shadow_array[$this->shadowbox_color_index] . ' is not a valid color code. Enter a new shadow color code: #':'Enter a box-shadow color code: #';
			}
		printer::alert($msg.'<input onclick="jscolor.installByClassName(\''.$style.'-'.$val.$inc.'\');" style="cursor:pointer;background:#'.$this->editor_background.';color:#'.$this->editor_color.';" type="text" name="'.$style.'['.$val.'][4]" id="'.$style.'-'.$val.$inc.'" value="'. $shadow_array[$this->shadowbox_color_index].'" size="6" maxlength="6" class="'.$style.'-'.$val.$inc.' {refine:false}">'.$span_color); 
		$this->submit_button();
		printer::close_print_wrap('Box shadow');
		$this->show_close('edit shadow');//'edit shadow'
		}
	$shadowcss='-moz-box-shadow:'.$shadow_array[$this->shadowbox_insideout_index].' '.$shadow_array[$this->shadowbox_horiz_offset_index].'px '.$shadow_array[$this->shadowbox_vert_offset_index].'px '.$shadow_array[$this->shadowbox_blur_radius_index].'px '.$shadow_array[$this->shadowbox_spread_radius_index].'px '. '#'. $shadow_array[$this->shadowbox_color_index].';  
	-webkit-box-shadow:'.$shadow_array[$this->shadowbox_insideout_index].'  '.$shadow_array[$this->shadowbox_horiz_offset_index].'px '.$shadow_array[$this->shadowbox_vert_offset_index].'px '.$shadow_array[$this->shadowbox_blur_radius_index].'px '.$shadow_array[$this->shadowbox_spread_radius_index].'px '. '#'. $shadow_array[$this->shadowbox_color_index].';   
	box-shadow:'.$shadow_array[$this->shadowbox_insideout_index].'  '.$shadow_array[$this->shadowbox_horiz_offset_index].'px '.$shadow_array[$this->shadowbox_vert_offset_index].'px '.$shadow_array[$this->shadowbox_blur_radius_index].'px '.$shadow_array[$this->shadowbox_spread_radius_index].'px '. '#'. $shadow_array[$this->shadowbox_color_index].';';  
	$intial='-moz-box-shadow:initial; -webkit-box-shadow: initial; box-shadow:initial;';//initial for default none
	$shadowcss= (!preg_match(Cfg::Preg_color,$shadow_array[$this->shadowbox_color_index]))?'':(($shadow_array[$this->shadowbox_insideout_index]==='forceoff')?'box-shadow:none;':$shadowcss); 
	$fstyle='final_'.$style;
	$this->{$fstyle}[$val]=$shadowcss;
	}
function text_shadow($style, $val,$field){
	static $inc=0;  $inc++;if (arrayhandler::is_empty_array($this->{$style}[$val])){//default may be set to 1
		$shadow_array=array();
		for ($i=0; $i<4;$i++){ 
			$shadow_array[$i]=0;
			}
		}
	else	{ //note that input type text will give 0value for defaults...
		$shadow_array=explode('@@',$this->{$style}[$val]);
		for ($i=0; $i<4;$i++){ 
			if (!array_key_exists($i,$shadow_array)){
				$shadow_array[$i]=0;
				}
			}
		}
	$shadow_array[0]= (empty($shadow_array[0]))? 0:$shadow_array[0];
	$shadow_array[1]= (empty($shadow_array[1]))? 0:$shadow_array[1];
	$shadow_array[2]= (empty($shadow_array[2]))? 0:$shadow_array[2];
	if ($this->is_page|| ($this->is_blog&&!$this->is_clone)||($this->is_column&&!$this->is_clone||$this->clone_local_style)){  
		echo'<div class="fsminfo '.$style.'_hidefont hide floatleft" ><!--text shadow-->';
          $this->show_more('Text Shadow','noback','highlight editbackground editfont','Add a Shadow to the text fonts',500);
          $this->print_redwrap('shadow group wrapper');
		 echo '
		<p class="fsminfo aqua textshadow">We have used a blue shadow color with this lighter blue text. <span class="highlight" title="Horizontal Offset: -1.4px; Vertical Offset: -1.4px; Blur Radius .8px;">Hover for View Settings</span> for this Text Shadow! For quick overview of using the css3 shadow feature and examples see <a target="_blank" href="http://css-tricks.com/snippets/css/css-box-shadow/">Shadow Examples</a> </p>';
		printer::pclear(8);
		echo' <div class="fsminfo editbackground editfont rad3 '.$this->column_lev_color.' editfont"><!--leftrightoffset-->Text Shadow Left/Right offet, more negative value  means more left, positive right:';
          echo'<p class="'.$this->column_lev_color.' left5 editbackground editfont">Currently '.$shadow_array[0].'<br>
		<span class="editcolor editbackground editfont">Choose: Horizontal offset:</span>
	    <select class="editcolor editbackground editfont"  name="'.$style.'['.$val.'][0]" >        
	    <option  value="'.$shadow_array[0].'" selected="selected">'.$shadow_array[0].'</option>';
          for ($i=-3; $i<3.1; $i+=.1){
			($i < .01&& $i > -.01)&&$i=0;
               echo '<option  value="'.$i.'">'.$i.'px</option>';
               }
          echo' </select>  
	   </div><!--leftrightoffset-->';
		echo'<div class="fsminfo editbackground editfont rad3 '.$this->column_lev_color.' editfont"><!--vert offset-->Text Shadow Above/Below offet 
		More negative value  means more above the text 
		More positive value  more below:<br>';
		echo'<p class="'.$this->column_lev_color.' rad3 editbackground editfont">Currently '.$shadow_array[1].'<br>
		<span class="editcolor editbackground editfont">Choose Vertical offset:</span>
	    <select class="editcolor editbackground editfont"  name="'.$style.'['.$val.'][1]" >        
	    <option  value="'.$shadow_array[1].'" selected="selected">'.$shadow_array[1].'</option>';
          for ($i=-3; $i<3; $i+=.1){
			($i < .01&& $i > -.01)&&$i=0;
               echo '<option  value="'.$i.'">'.$i.'px</option>';
               }
          echo' </select></p>
	   </div><!--vert offset-->';	
		echo'<div class="'.$this->column_lev_color.' fsminfo editbackground editfont rad3 editfont"><!--Blur length-->Set Shadow Blur Length: Currently '.$shadow_array[2].'<br>
		<span class="editcolor editbackground editfont">Choose New blur radius:</span>
	    <select class="editcolor editbackground editfont"  name="'.$style.'['.$val.'][2]">        
	    <option  value="'.$shadow_array[2].'" selected="selected">'.$shadow_array[2].'</option>';
          for ($i=0; $i<6; $i+=.1){
               echo '<option  value="'.$i.'">'.$i.'px</option>';
               }
		echo' </select>
		  </div><!--Blur length-->';
          
		if (preg_match(Cfg::Preg_color,$shadow_array[3])){ 
			$msg="Change the Current Box-Shadow Color:<br> #";
			}
		else {
			$msg= (!empty($shadow_array[3]))?$shadow_array[3] . ' is not a valid color code. Enter a new shadow color code:<br> #':'Enter a box-shadow color code:<br> #';
			}
          
          $msg=$msg.printer::print_info('Use 0 to remove box-shadow',.9,1);
		$span_color=(!empty($shadow_array[3]))?'<span class="fs1npred" style="background-color:#'.$shadow_array[3].';">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>':'';   
		echo '<div class="'.$this->column_lev_color.' fsminfo editbackground editfont">Edit the Text Shadow color <br><span class="editcolor editbackground editfont"><!--shadow text color-->'.$msg.'</span><input onclick="jscolor.installByClassName(\''.$style.'-'.$val.$inc.'\');" style="cursor:pointer;background:#'.$this->editor_background.';color:#'.$this->editor_color.';"   type="text" name="'.$style.'['.$val.'][3]" id="'.$style.'-'.$val.$inc.'" value="'. $shadow_array[3].'" size="6" maxlength="6" class="'.$style.'-'.$val.$inc.' {refine:false}">'.$span_color;
		echo'</div><!--shadow text color-->';
          $this->submit_button();
          printer::close_print_wrap('shadow group wrapper');
		$this->show_close('text shadow');
		echo'</div><!--text shadow-->';
		}
	$shadowcss='text-shadow: '.$shadow_array[0].'px '.$shadow_array[1].'px '.$shadow_array[2].'px #'. $shadow_array[3].';'; 
	$shadowcss= (empty($shadow_array[3])||(empty($shadow_array[0])&&empty($shadow_array[2])&&empty($shadow_array[1])))?'':$shadowcss;
	$fstyle='final_'.$style;
	$this->{$fstyle}[$val]=$shadowcss;
	}//end text shadow
     
function overflow($type,$data){
     $this->show_more('Set '.$type.' Overflow Property');
     printer::print_redwrap('overflow');
     printer::print_tip('Choose overflow property. By default height is will automatically adjust to content and most width options will automatically adjust to available width. Hoever, Setting a direct height or width property may overflow the parent element and byfault overflow will be visible. But you can set overflow of content to scroll or be hidden for the post.  Note: Images in responsive mode automatically resize image image so no scroll bars used there.<br>');
     printer::print_wrap1('overflowx');
     printer::alert('Choose overflow-x direction for width');
     $overflow_arr=array('hidden','visible','scroll','auto');
     $overflowx=(in_array($this->{$type.'_options'}[$this->{$type.'_overflowx_index'}],$overflow_arr))?$this->{$type.'_options'}[$this->{$type.'_overflowx_index'}]:'';
     $overflowy=(in_array($this->{$type.'_options'}[$this->{$type.'_overflowy_index'}],$overflow_arr))?$this->{$type.'_options'}[$this->{$type.'_overflowy_index'}]:'';
	$checked='checked="checked"';
	$check1=($overflowx==='hidden')?$checked:'';
	$check2=($overflowx==='scroll')?$checked:'';
	$check3=(empty($overflowx)||$overflowx==='visible')?$checked:'';	
	$check4=($overflowx==='auto')?$checked:'';	  
	printer::alert('<input type="radio"  name="'.$data.'_'.$type.'_options['.$this->{$type.'_overflowx_index'}.']" value="hidden" '.$check1.'>hidden');
	printer::alert('<input type="radio"  name="'.$data.'_'.$type.'_options['.$this->{$type.'_overflowx_index'}.']" value="scroll" '.$check2.'>scroll');
	printer::alert('<input type="radio"  name="'.$data.'_'.$type.'_options['.$this->{$type.'_overflowx_index'}.']" value="visible" '.$check3.'>visible');
	printer::alert('<input type="radio"  name="'.$data.'_'.$type.'_options['.$this->{$type.'_overflowx_index'}.']" value="auto" '.$check4.'>auto');
     printer::close_print_wrap1('overflowx');
     printer::print_wrap1('overflowy'); 
     printer::alert('Choose overflow-y direction for height');
     $check1=($overflowy==='hidden')?$checked:'';
	$check2=($overflowy==='scroll')?$checked:'';
	$check3=(empty($overflowy)||$overflowy==='visible')?$checked:'';	
	$check4=($overflowy==='auto')?$checked:'';	  
	printer::alert('<input type="radio"  name="'.$data.'_'.$type.'_options['.$this->{$type.'_overflowy_index'}.']" value="hidden" '.$check1.'>hidden');
	printer::alert('<input type="radio"  name="'.$data.'_'.$type.'_options['.$this->{$type.'_overflowy_index'}.']" value="scroll" '.$check2.'>scroll');
	printer::alert('<input type="radio"  name="'.$data.'_'.$type.'_options['.$this->{$type.'_overflowy_index'}.']" value="visible" '.$check3.'>visible');
	printer::alert('<input type="radio"  name="'.$data.'_'.$type.'_options['.$this->{$type.'_overflowy_index'}.']" value="auto" '.$check4.'>auto');
     $css_id=($type==='blog')?$this->dataCss:$this->col_dataCss;
     printer::close_print_wrap1('overflowy');  
     $css='';
     if(!empty($overflowx)||!empty($overflowy)){
          $overflowx=(!empty($overflowx))?'overflow-x:'.$overflowx.';':'';
          $overflowy=(!empty($overflowy))?'overflow-y:'.$overflowy.';':'';
		$this->css.=$css.= '.'.$css_id.'{'.$overflowx.$overflowy.'}';
		}
     $this->show_more('Style info','','info italic smaller');
     printer::print_wrap1('techinfo');
     printer::print_info('Current setting Css: '.$css);
     $msg='Changes default css overflow x direction and y direction properties.';
     printer::print_info($msg);
     printer::close_print_wrap1('techinfo');
     $this->show_close('Tech info');
     
     printer::close_print_wrap('overflow');
     $this->show_close('Set Post Overflow Property');
     }
     
function custom_style($style, $val,$field=''){
     #note: display property and advanced styles use css #id to override normal styles which use distinct classnames
	static $topinc=0; $topinc++;
	$serial_data=$this->{$style}[$val];  
	$idref=($this->is_column)?$this->col_dataCss:(($this->is_blog)?$this->dataCss:$this->pagename);
	$localprefix='';  
	if($this->is_page) 
		$db_table=$this->master_page_table;
	elseif ($this->is_column&&!$this->clone_local_style)
		$db_table=$this->master_col_table;
	elseif ($this->is_column){
		$localprefix='c';
		$db_table=$this->master_col_css_table;
		}
	elseif ($this->is_blog&&!$this->clone_local_style)
		$db_table=$this->master_post_table;
	else {
		$db_table=$this->master_post_css_table;
		$localprefix='p';
		}
	$ref_id=($this->is_page)?'page_id':(($this->is_column)?'col_id':'blog_id');
	if (!empty($serial_data)&&$this->isSerialized($serial_data)){ 
		$media_added_style_arr=unserialize($serial_data);//for correct storage in style field value..
		$count=count($media_added_style_arr);
		}
	else {
		if (strlen($this->{$style}[$val]>6))echo serial_data. ' is not recognized as serialized';
		if (strpos($field,'tiny')!==false&&strlen($this->$field)>253){ 
               printer::print_warn("Tiny field  $field only holds limited data and your advanced styling most likely contains too many characters, was truncated, will not render properly and will be removed.");
               }
          $count=0;
		$media_added_style_arr=array();
		} 
	//update submitted posts to database
	if (isset($_POST['media_added_style_'.$this->clone_ext.$field.'_'.$this->$ref_id])){
		foreach($_POST['media_added_style_'.$this->clone_ext.$field.'_'.$this->$ref_id] as $index => $array){
			if (array_key_exists(0,$array)) 
				$media_added_style_arr[$index][0]=str_replace('<br>','break',process_data::spam_scrubber($array[0],false,false));
			if (array_key_exists(1,$array)) 
				$media_added_style_arr[$index][1]=str_replace('<br>','break',process_data::spam_scrubber($array[1]));
			if (array_key_exists(2,$array)) 
				$media_added_style_arr[$index][2]=$array[2];
			if (array_key_exists(3,$array)) 
				$media_added_style_arr[$index][3]=$array[3]; 
			}
		$arrhold=array();
		foreach ($media_added_style_arr as $index => $array){
			if (array_key_exists(1,$array)&&strlen($array[1]) > 5) //here we omit empties..
				$arrhold[]=$array;
			}
		$media_added_style_arr=$arrhold;
		$update_val=str_replace(',','=>',serialize($arrhold));
		$style_arr=explode(',',$this->$field);
		for ($i=0; $i<count(explode(',',Cfg::Style_functions)); $i++){ 
			if (!array_key_exists($i,$style_arr)){  
				$style_arr[$i]='';
				}
			} 
		$style_arr[$this->custom_style_index]=$update_val; 
		$implode_style_arr=implode(',',$style_arr);
		$ref=($this->is_page)?'page_':(($this->is_column)?'col_':'blog_');
		$q="update $db_table set $field='$implode_style_arr',{$ref}time='".time()."',{$ref}update='".date("dMY-H-i-s")."', token='".mt_rand(1,mt_getrandmax()). "' where $ref_id='$localprefix{$this->$ref_id}'"; 
		$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
		}//if submitted
	//now generate css
	foreach ($media_added_style_arr as $index => $array){//$array[1]=str_replace('<br>',"\n",str_replace('=>',',',$array[1]));
		$class_suffix=(array_key_exists($index,$media_added_style_arr)&&array_key_exists(0,$media_added_style_arr[$index])&&strlen($array[0])>1&&!is_numeric($array[0]))?str_replace('=>',',',$array[0]):'';
		$customcss=(array_key_exists($index,$media_added_style_arr)&&array_key_exists(1,$media_added_style_arr[$index]))?str_replace('<br>',"\n",str_replace('=>',',',$array[1])):'';
		$media_maxpx=(array_key_exists($index,$media_added_style_arr)&&array_key_exists(2,$media_added_style_arr[$index])&&$media_added_style_arr[$index][2]>199&&$media_added_style_arr[$index][2]<2001)?$media_added_style_arr[$index][2]:'';
		$media_minpx=(array_key_exists($index,$media_added_style_arr)&&array_key_exists(3,$media_added_style_arr[$index])&&$media_added_style_arr[$index][3]>199&&$media_added_style_arr[$index][3]<3001)?$media_added_style_arr[$index][3]:'';
		$data=str_replace('=>',',',str_replace('break',"\n",$array[1]));//for correct storage in style field value..
		$newref=(!$this->is_page)?str_replace('.'.$idref,'#'.$idref,$this->pelement):$this->pelement;//so here we switch class to ids. same name diff prefix is all!//
          $css_class_id= $newref.$class_suffix;
		$mediacss='';
		if (empty($media_minpx)&&empty($media_maxpx)){ 
			$mediacss.=
			$css_class_id.'{'.$data.'}';
			}
		elseif (!empty($media_minpx)&&!empty($media_maxpx)) {
			$mediacss.='
			@media screen and (max-width:'.$media_maxpx.'px) and (min-width:'.$media_minpx.'px){'.  	
				$css_class_id.'{'.$data.'}
				}
				';
			}
		elseif (!empty($media_maxpx)){
			$mediacss.='
			@media screen and (max-width: '.$media_maxpx.'px){'.  	
				$css_class_id.'{'.$data.'}
			}';
			}
		else {
			$mediacss.='
			@media screen and (min-width: '.$media_minpx.'px){'.  	
				$css_class_id.'{'.$data.'}
			}';
			}
		$this->advancedmediacss.=$mediacss;
		$this->advancedstyles[$this->pelement]=$mediacss; 
		}//end foreach css
	if ($this->is_page|| ($this->is_blog&&!$this->is_clone)||($this->is_column&&!$this->is_clone||$this->clone_local_style)){
		 $this->show_more('Advanced Styling Options','','highlight editbackground editfont highlight editstyle','Manually enter Css &amp; Css @media Rules Here');
		$ptype=($this->is_page)?' body&#123;&#125;':(($this->is_column)?'this column':'this post');
     $this->print_redwrap('advanced style');
	echo '<div><!--custom style-->';
	echo '<div class="Od2olivedrab fsminfo editbackground editfont '.$this->column_lev_color.' "><!--custom style inner-->';
		printer::printx('<span class="warn1 redAlert ">Caution: Adding curly brackets {} can potentially Break all following CSS Styling</span>');
		printer::print_tip('Custom Css Rules Specific For this <b>'.$ptype.'</b> can be manually entered here. Append any further css specificity under suffix. Additionally Choose to add @media screen max-width and min-width media query-css entries for each grouping of custom css properties you add. New  Fields will appear as needed if additional entries are required. Removing Custom Css will delete the field. <br><span class="whitebackground green">Additionally you can change the behavior so the system generates a series of media queries spanning the max-width and min-width values you selected. See the option below!</span><br><br><span style="background: rgba(255,255,255,.33)"> <b>Media Query, Classname and {} will be entered automatically</b></span>');
		$count=$count+4;
		#mediafor
		for ($i=0; $i < $count; $i++){
			$class_suffix=(array_key_exists($i,$media_added_style_arr)&&array_key_exists(0,$media_added_style_arr[$i])&&!is_numeric($media_added_style_arr[$i][0]))?$media_added_style_arr[$i][0]:'';
			$newref=(!$this->is_page)?str_replace('.'.$idref,'#'.$idref,$this->pelement):$this->pelement;//so here we switch class to ids. same name diff prefix is all!
               $css_class_id=$newref.$class_suffix;// ($newref===$this->pelement)?$this->pelement.$class_suffix:$this->pelement.$class_suffix.','.$newref;
			$customcss=(array_key_exists($i,$media_added_style_arr)&&array_key_exists(1,$media_added_style_arr[$i]))?str_replace('=>',',',str_replace('break',"\n",$media_added_style_arr[$i][1])):'';   
			$media_maxpx=(array_key_exists($i,$media_added_style_arr)&&array_key_exists(2,$media_added_style_arr[$i])&&$media_added_style_arr[$i][2]>199&&$media_added_style_arr[$i][2]<2001)?$media_added_style_arr[$i][2]:0;
			$media_minpx=(array_key_exists($i,$media_added_style_arr)&&array_key_exists(3,$media_added_style_arr[$i])&&!empty($media_added_style_arr[$i][3]))?$media_added_style_arr[$i][3]:0;
			echo '<div class="editbackground editfont"><!--media array wrap-->';
			echo '<div class="fs2orange editbackground editfont"><!--array wrapper media inner-->';
			echo '<div class="fs1green editbackground editfont editcolor"><!--array wrapper media css-->';
			printer::printx('<p class="info floatleft">'.$css_class_id.'</p>'); 
			echo '<div class="floatleft"><!--floatwrap css suffix-->';
			if (empty($class_suffix))$this->show_more('Selector Suffix Option','','tiny info','Add a class suffix');
			$msg=(empty($class_suffix))?'Add optional additional class specifier Here: ':'';
			echo '<p class="editbackground editfont editcolor">'.$msg.'<input type="text" name="media_added_style_'.$this->clone_ext.$field.'_'.$this->$ref_id.'['.$i.'][0]" value="'.$class_suffix.'" size="30" maxlength="100"></p>';
			printer::pclear();
			if (empty($class_suffix))$this->show_close('suffix');
			printer::pclear();
			echo '</div><!--floatwrap css suffix-->';
			printer::pclear();
			printer::printx('<p>&#123;</p>');
			printer::pclear();
			$this->textarea($customcss,'media_added_style_'.$this->clone_ext.$field.'_'.$this->$ref_id.'['.$i.'][1]','600','16');
			printer::spanclear();
			printer::printx('<p>&#125;</p>');
			echo '</div><!--array wrapper media css-->';
			$cur_maxpx=($media_maxpx>199&&$media_maxpx<2001)?$media_maxpx.'px':'none';
			$cur_minpx=($media_minpx>199&&$media_minpx<2001)?$media_minpx.'px':'none'; 
			echo '<div class="fsminfo"><!--wrap max width-->';
			printer::printx('<p class="smaller '.$this->column_lev_color.'">Chosen max-width: <span class="navybackground white">'.$cur_maxpx.'</span><br></p>');
			$msgjava='Choose @media screen max-width px:';  
			printer::alert('Choose @media screen max-width px'); 
			$this->mod_spacing('media_added_style_'.$this->clone_ext.$field.'_'.$this->$ref_id.'['.$i.'][2]',$media_maxpx,200,2000,1,'px','',$msgjava);
               printer::printx('<p ><input type="checkbox" name="media_added_style_'.$this->clone_ext.$field.'_'.$this->$ref_id.'['.$i.'][2]" value="0">Remove max-width</p>');
			echo '</div><!--wrap max width-->';
			echo '<div class="fsminfo"><!--wrap min width-->';
			printer::printx('<p class="smaller '.$this->column_lev_color.'">Chosen min-width: <span class="navybackground white">'.$cur_minpx.'</span></p>');
			 $msgjava='Choose @media screen min-width:';   
			printer::alert('Choose @media screen min-width px'); 
			$this->mod_spacing('media_added_style_'.$this->clone_ext.$field.'_'.$this->$ref_id.'['.$i.'][3]',$media_minpx,200,2000,1,'px','',$msgjava);
               printer::printx('<p ><input type="checkbox" name="media_added_style_'.$this->clone_ext.$field.'_'.$this->$ref_id.'['.$i.'][3]" value="0">Remove min-width</p>');
			echo '</div><!--wrap min width-->';
			printer::print_wrap('generate advanced media query');
			printer::print_tip('By default you can add a max-width and min_width media screen query to this option. Alternatively, by checking the create media query series option here a series of max-width queries will be created');
			printer::close_print_wrap('generate advanced media query');
			echo '</div><!--array wrapper media inner-->';
			$this->submit_button();
			echo '</div><!--array wrapper media-->';
			printer::pclear();
			}// end for loop
		printer::printx('<p class="fsminfo tip smaller">Note: Page Related Css &amp; Modified Custom functions affecting  this page only may be made in: <b>includes/'.$this->pagename.'.class.php</b><br>Custom css and functions affecting pages site-wide may be made in: <b>includes/site_master.class.php</b></p>');
		echo '</div><!--custom style inner-->'; 
		printer::pclear();
		echo '</div><!--custom style-->';
          printer::close_print_wrap('advanced style');
		$this->show_close('Advanced Styling Options');
		}//if editable 
	printer::pclear();
	}//end custom style

function background($style, $val,$field='',$msg='Background color'){  
	static $inc=0;  $inc++;
	$opacitybackground=false;//set default otherwise creates :after
	$imagepx=(isset($this->background_img_px)&&$this->background_img_px>4)? $this->background_img_px:(($this->is_page)?$this->page_width:$this->current_net_width);   
	$backindexes=explode(',',Cfg::Background_styles);
	foreach($backindexes as $key =>$index){
		if (!empty($index)) ${$index.'_index'}=$key;
		}  
	if (empty($this->{$style}[$val])){ 
		$background_array=array();
		 for ($i=0; $i<count($backindexes);$i++){ 
			$background_array[$i]=0;
			}
		}
	else	{   
		$background_array=explode('@@',$this->{$style}[$val]);
		for ($i=0; $i<count($backindexes);$i++){ 
			if (!array_key_exists($i,$background_array)){
				$background_array[$i]=0;
				}
			 }
		}
	if ($this->is_blog){// determine the name of the field for adding new background image!!
		if(!empty($field)){  
			$maxwid=$this->current_net_width;
			$background_image_field=$field.'-blog-'.$val.'-'.$this->blog_order;
			$table=$this->blog_table;
			}
		else{//fields currently always present.
               mail::alert('background image upload field missing');
			$maxwid=$this->current_net_width;
			$background_image_field='blog_style-blog-' .$val.'-'.$this->blog_order;
			$table=$this->blog_table;
			}
		}
	elseif ($this->is_column) {
		$maxwid=$this->current_net_width;
		$background_image_field=$field.'-column-'. $val;
		$table=$this->col_name;
		}
	elseif ($this->is_page) { 
		$background_image_field=$field.'-page-'.$val;
		$maxwid=Cfg::Default_background_image_width;
		$table=$this->pagename;
		}
	else {
	echo '</div><!--background issue-->';
		mail::alert('background function issue');
		return;
		}
	(empty($width))&&$width=$maxwid;
	#the above is for uploading background image below...
	$background_color_off=($background_array[$background_color_off_index]==='coloroff')?true:false;
	$background_image_off=($background_array[$background_image_off_index]==='imageoff')?true:false;
	$background_color_opacity=(!empty($background_array[$background_opacity_index])&&$background_array[$background_opacity_index]<100&&$background_array[			$background_opacity_index]>0)?$background_array[$background_opacity_index]:100;
	$back_color=(preg_match(Cfg::Preg_color,$background_array[$background_color_index]))?$background_array[$background_color_index]:'';
	if (!empty(trim($back_color))){
		if ($background_color_opacity <100) 
			$back_color=process_data::hex2rgba($back_color,$background_color_opacity);
		else $back_color='#'.$back_color;
		$background_color='background-color: '.$back_color.';'; 
		}
	else $background_color='';
	$background_image_used= ($background_array[$background_image_use_index]==1&&is_file(Cfg_loc::Root_dir.Cfg::Background_image_dir.$background_array[$background_image_index]))?true:false; 
	$background_gradient_type_array=array('none','vertical','repeating vertical','horizontal','repeating horizontal','diagonal top left','repeating diagonal top left','diagonal top right','repeating diagonal top right','radial ellipse','repeating radial ellipse','radial circle','repeating radial circle');
	$background_gradient_type= (!empty($background_array[$background_gradient_type_index])&&in_array($background_array[$background_gradient_type_index],$background_gradient_type_array))?$background_array[$background_gradient_type_index]:'';
	if (!empty($background_gradient_type)&&$background_gradient_type!=='none'){   
		$gradient_color_arr=array();
		$gradient_colors='';
		for ($i=1; $i<7; $i++){
			$mycolor= (preg_match(Cfg::Preg_color,$background_array[${'background_gradient_color'.$i.'_index'}]))?$background_array[${'background_gradient_color'.$i.'_index'}]:'';   
			$opacity=$background_array[${'background_gradient_transparency'.$i.'_index'}];  
			if(empty($mycolor)&&$opacity!=='transparent')continue;
			$color_stop=($background_array[${'background_gradient_color_stop'.$i.'_index'}]>2)?' '.$background_array[${'background_gradient_color_stop'.$i.'_index'}].'%':'';
			$gradient_color_arr[]=array($mycolor,$opacity,$color_stop);
			} 
		if (count($gradient_color_arr)>1){
			foreach($gradient_color_arr as $colors){
				if ($colors[1]==='transparent'){
					$gradient_colors.='rgba(255,255,255,0)'.$colors[2].',';
					}
				elseif ($colors[1]<100){
					$gradient_colors.=process_data::hex2rgba($colors[0],$colors[1]).$colors[2].',';
					}
				else $gradient_colors.='#'.$colors[0].$colors[2].',';
				}
				
			}
			$gradient_colors=substr_replace($gradient_colors, '',-1); 
		}
	$background_gradient_position_keyword=(!empty($background_array[$background_gradient_position_keyword_index]))?$background_array[$background_gradient_position_keyword_index]:'farthest-corner';
	$background_gradient_position1=(!is_numeric($background_array[$background_gradient_position1_index]))?'50':$background_array[$background_gradient_position1_index];
	$background_gradient_position2=(!is_numeric($background_array[$background_gradient_position2_index]))?'50':$background_array[$background_gradient_position2_index];
	$background_gradient_percent=$background_gradient_position1.'% '.$background_gradient_position2.'%,';
	$at=' at ';
	$comma=', ';
	//   https://developer.mozilla.org/en-US/docs/Web/CSS/radial-gradient
	switch ($background_array[$background_gradient_type_index]){
		case('none'):
			$gradient_css='';
			break;
		case('vertical'):
			$gradient_css='
				background: -webkit-linear-gradient('.$gradient_colors.'); /* For Safari 5.1 to 6.0 */
				background: -o-linear-gradient('.$gradient_colors.'); /* For Opera 11.1 to 12.0 */
				background: -moz-linear-gradient('.$gradient_colors.'); /* For Firefox 3.6 to 15 */
				background: linear-gradient('.$gradient_colors.');
				';
			break;
		case('repeating vertical'):
			$gradient_css='
				background: -webkit-repeating-linear-gradient('.$gradient_colors.'); /* For Safari 5.1 to 6.0 */
				background: -o-repeating-linear-gradient('.$gradient_colors.'); /* For Opera 11.1 to 12.0 */
				background: -moz-repeating-linear-gradient('.$gradient_colors.'); /* For Firefox 3.6 to 15 */
				background: repeating-linear-gradient('.$gradient_colors.');
				';
			break;
		case('horizontal'):
			$gradient_css='
			background: -webkit-linear-gradient(left, '.$gradient_colors.'); /* For Safari 5.1 to 6.0 */
			background: -o-linear-gradient(right, '.$gradient_colors.'); /* For Opera 11.1 to 12.0 */
			background: -moz-linear-gradient(right, '.$gradient_colors.'); /* For Firefox 3.6 to 15 */
			background: linear-gradient(to right, '.$gradient_colors.'); /* Standard syntax */
			';
			break;
		
		case('repeating horizontal'):
			$gradient_css='
			background: -webkit-repeating-linear-gradient(left, '.$gradient_colors.'); /* For Safari 5.1 to 6.0 */
			background: -o-repeating-linear-gradient(right, '.$gradient_colors.'); /* For Opera 11.1 to 12.0 */
			background: -moz-repeating-linear-gradient(right, '.$gradient_colors.'); /* For Firefox 3.6 to 15 */
			background: repeating-linear-gradient(to right, '.$gradient_colors.'); /* Standard syntax */
			';
			break;
		case('diagonal top left'):
			$gradient_css='
			background: -webkit-linear-gradient(left top, '.$gradient_colors.'); /* For Safari 5.1 to 6.0 */
			background: -o-linear-gradient(bottom right, '.$gradient_colors.'); /* For Opera 11.1 to 12.0 */
			background: -moz-linear-gradient(bottom right, '.$gradient_colors.'); /* For Firefox 3.6 to 15 */
			background: linear-gradient(to bottom right,'.$gradient_colors.');
			';
			break;
		case('repeating diagonal top left'):
			$gradient_css='
			background: -webkit-repeating-linear-gradient(left top, '.$gradient_colors.'); /* For Safari 5.1 to 6.0 */
			background: -o-repeating-linear-gradient(bottom right, '.$gradient_colors.'); /* For Opera 11.1 to 12.0 */
			background: -moz-repeating-linear-gradient(bottom right, '.$gradient_colors.'); /* For Firefox 3.6 to 15 */
			background: repeating-linear-gradient(to bottom right,'.$gradient_colors.');
			';
			break;
		
		case('diagonal top right'):
			$gradient_css='
			background: -webkit-linear-gradient(right top, '.$gradient_colors.'); /* For Safari 5.1 to 6.0 */
			background: -o-linear-gradient(bottom left, '.$gradient_colors.'); /* For Opera 11.1 to 12.0 */
			background: -moz-linear-gradient(bottom left, '.$gradient_colors.'); /* For Firefox 3.6 to 15 */
			background: linear-gradient(to bottom left, '.$gradient_colors.');
			';
			break;
		case('repeating diagonal top right'):
			$gradient_css='
			background: -webkit-repeating-linear-gradient(right top, '.$gradient_colors.'); /* For Safari 5.1 to 6.0 */
			background: -o-repeating-linear-gradient(bottom left, '.$gradient_colors.'); /* For Opera 11.1 to 12.0 */
			background: -moz-repeating-linear-gradient(bottom left, '.$gradient_colors.'); /* For Firefox 3.6 to 15 */
			background: repeating-linear-gradient(to bottom left, '.$gradient_colors.');
			';
			break;
		case('radial ellipse'): 
			$gradient_css='
			background: -webkit-radial-gradient('.$background_gradient_percent.$background_gradient_position_keyword.$comma.$gradient_colors.'); /* Safari 5.1 to 6.0 */
			background: -o-radial-gradient('.$background_gradient_percent.$background_gradient_position_keyword.$comma.$gradient_colors.'); /* For Opera 11.6 to 12.0 */
			background: -moz-radial-gradient('.$background_gradient_percent.$background_gradient_position_keyword.$comma.$gradient_colors.'); /* For Firefox 3.6 to 15 */
			background: radial-gradient('.$background_gradient_position_keyword.$at.$background_gradient_percent.$gradient_colors.'); /* Standard syntax */
			';
			break;
		case('repeating radial ellipse'): 
			$gradient_css='
			background: -webkit-repeating-radial-gradient('.$background_gradient_percent.$background_gradient_position_keyword.$comma.$gradient_colors.'); /* Safari 5.1 to 6.0 */
			background: -o-repeating-radial-gradient('.$background_gradient_percent.$background_gradient_position_keyword.$comma.$gradient_colors.'); /* For Opera 11.6 to 12.0 */
			background: -moz-repeating-radial-gradient('.$background_gradient_percent.$background_gradient_position_keyword.$comma.$gradient_colors.'); /* For Firefox 3.6 to 15 */
			background: repeating-radial-gradient('.$background_gradient_position_keyword.$at.$background_gradient_percent.$gradient_colors.'); /* Standard syntax */
			';
			break;
		case('radial circle'): 
			$gradient_css='
			background: -webkit-radial-gradient(circle '.$background_gradient_percent.$background_gradient_position_keyword.$comma.$gradient_colors.'); /* Safari 5.1 to 6.0 */
			background: -o-radial-gradient(circle '.$background_gradient_percent.$background_gradient_position_keyword.$comma.$gradient_colors.'); /* For Opera 11.6 to 12.0 */
			background: -moz-radial-gradient(circle '.$background_gradient_percent.$background_gradient_position_keyword.$comma.$gradient_colors.'); /* For Firefox 3.6 to 15 */
			background: radial-gradient(circle '.$background_gradient_position_keyword.$at.$background_gradient_percent.$gradient_colors.'); /* Standard syntax */
			';
			break;
		case('repeating radial circle'): 
			$gradient_css='
			background: -webkit-repeating-radial-gradient(circle '.$background_gradient_percent.$background_gradient_position_keyword.$comma.$gradient_colors.'); /* Safari 5.1 to 6.0 */
			background: -o-repeating-radial-gradient(circle '.$background_gradient_percent.$background_gradient_position_keyword.$comma.$gradient_colors.'); /* For Opera 11.6 to 12.0 */
			background: -moz-repeating-radial-gradient(circle '.$background_gradient_percent.$background_gradient_position_keyword.$comma.$gradient_colors.'); /* For Firefox 3.6 to 15 */
			background: repeating-radial-gradient(circle '.$background_gradient_position_keyword.$at.$background_gradient_percent.$gradient_colors.'); /* Standard syntax */
			';
		
			break;
		default:
			$gradient_css='';
		}  
	$invalid='';//(!empty($gradient_css)||!empty($back_image_used))?'<img class="floatleft" src="'.Cfg_loc::Root_dir.'invalid.gif" height="25" width="25" alt="background color is overridden">':'';
	$opacity=($background_color_opacity<100&&$background_color_opacity>0)?'@'.$background_color_opacity.'%&nbsp;Opacity ':''; 
	$span_color=(!empty($background_color))?'<span class="fs1npred floatleft" style="height:25px;width:25px; '.$background_color.'">'.$invalid.'&nbsp;&nbsp;</span>'.$opacity:''; 
	if (!preg_match(Cfg::Preg_color,$background_array[$background_color_index]))$background_array[$background_color_index]="0";
     $gradcolor='navy';
	$colorprint=(!empty($back_image_used))?'red':$gradcolor;
	$background_gradient_type=(!empty($background_array[$background_gradient_type_index])&&in_array($background_array[$background_gradient_type_index],$background_gradient_type_array))?$background_array[$background_gradient_type_index]:'none';
	$background_video_ratio=(!empty($background_array[$background_video_ratio_index])&&is_numeric($background_array[$background_video_ratio_index])&&$background_array[$background_video_ratio_index]>.1&&$background_array[$background_video_ratio_index]<10)?$background_array[$background_video_ratio_index]:1.333;
	$background_image_opacity=(empty($background_array[$background_image_opacity_index]))?100:$background_array[$background_image_opacity_index];
	if (is_numeric($background_array[$background_horiz_index])&&$background_array[$background_horiz_index]<101&&$background_array[$background_horiz_index]>-1){
          $bhval=$background_array[$background_horiz_index];
          $poshclass='';
          }
     else {
          $bhval=0;
          $poshclass='allowthis';
          }
     if (is_numeric($background_array[$background_vert_index])&&$background_array[$background_vert_index]<101&&$background_array[$background_vert_index]>-1){
          $bvval=$background_array[$background_vert_index];
          $posvclass='';
          }
     else {
          $bvval=0;
          $posvclass='allowthis';
          }
	if ($this->is_page|| ($this->is_blog&&!$this->is_clone)||($this->is_column&&!$this->is_clone||$this->clone_local_style)){ 
          $this->show_more('Background Styling','main2','highlight click editbackground editfont','Edit Colors, Gradient   Background Image','300');
		echo '<div class="0s2dodgerblue fsminfo floatleft editbackground editfont"  ><!--background style -->';
		printer::pclear(1);
		echo '<div class="editbackground editfont floatleft"><!--show background color floatwrap-->';
		$this->show_more('Background Color', 'noback','highlight  editbackground editfont','A background Color and Color Opacity May be Chosen Here',500); 
		$colorprint=(!empty($gradient_css)||!empty($back_image_used))?'red':$this->column_lev_color;
		$this->print_redwrap('wrap background color');
		printer::printx( '<div class="fs1black editbackground editfont rad3 '.$colorprint.' editfont"><!--background color-->Background colors will be overridden by valid Background Images or Background Gradients!<br>');
		if (preg_match(Cfg::Preg_color,$background_array[$background_color_index])){
			$msg="Change the Current Background Color, Use 0 to remove: #";
			}
		else {
			$msg= (!empty($background_array[$background_color_index]))?$background_array[$background_color_index] . ' is not a valid color code. Enter or choose a new background color code: #':'Enter or Click to choose a  background color code: #';
			}
		printer::alertx('<span class="highlight left5" title="Add a background color 3 or 6 digit color code or click in the entry box to open the Color finder tool! Enter any blank or 0 to go back to the parent default">'.$msg.'</span><br>');  
		printer::printx('<p class="floatleft"><input style="cursor:pointer;background:#'.$this->editor_background.';color:#'.$this->editor_color.';" onclick="jscolor.installByClassName(\''.$style.'-'.$val.'_'.$inc.'\');" type="text" name="'.$style.'['.$val.']['.$background_color_index.']" id="'.$style.'-'.$val.'_'.$inc.'" value="'. $background_array[$background_color_index].'" size="6" maxlength="6" class="'.$style.'-'.$val.'_'.$inc.' {refine:false}">' .$span_color.'</p>');
		printer::pclear();
		echo '</div><!--background color-->';
		printer::pclear();
		echo '<div class="editbackground editfont fs1color"><!--border opacity-->';
		echo '<p class="fsminfo  rad3   editfont" style="color:rgba(0,0,255,1); background:rgba(0,0,255,.25);">Background color of this text is set at  blue,   the same hexcode blue as the text except the blue background color has been set  with a 25% opacity. The parent background color is the editbackground editfont color which bleeds through. Change the opacity of your background color by choosing an opacity near 0% for very transparent allowing most of the parent background color or image to bleed through. At 50% opacity we see ~ half background color half parent background and at 100% opacity the parent background is colored over completely! </p>';
		echo '<p class="editcolor editbackground editfont ">Change Background Color Opacity:  </p>';
		$this->mod_spacing($style.'['.$val.']['.$background_opacity_index.']',$background_color_opacity,0,100,1,'%');
		echo '</div><!--border opacity-->'; 
          $this->submit_button();
		printer::close_print_wrap('wrap background color');
		$this->show_close('back colors');echo '<!--show back colors-->';
		echo '</div><!--show background color floatwrap-->';
		echo $span_color;
		printer::pclear();
		printer::pclear(1);
		echo '<div class="floatleft"><!--show background gradient floatwrap-->';
		$this->show_more('Background Gradients', 'noback','highlight editbackground editfont','A background Color Gradient of 2 or more colors may be  used instead of a single color',500);echo '<!--show gradients-->';
		$this->print_redwrap('gradient wrap' );
		echo '<div class="fsmblack whitebackground"><!--show gradients-->';
		echo '<div class=" rad3 utilitygrad '.$gradcolor.' editfont floatleft"><div style="margin: 30px auto; width:80%; padding:10px;  background:rgba(255,255,255,.65);">We have used a background gradient behind this info box using the diagonal top left  option and using six colors  to demonstate how a  page or column background effect can be used together along with a post having a white background set at 65% opacity which allows some of the background to bleed through.  When making a gradient Use from two to six colors when making a background gradient  effect. Set any degree on your gradient color choices which will allow the parent background color to bleed through to the degree of the percentage chosen.  Selecting the transparent option without a valid color is still a valid choice and will display 100% background. Otherwise a valid color option must be selected.';
		printer::pclear();	
		$this->show_more(' more gradient info', 'cnoback','click floatleft editbackground editfont');
		printer::printx('Gradient options include none, vertical (top to bottom),  horizontal (left to right gradient),  diagonal top left (a diagonal gradient from top left to bottom  right), repeating diagonal top left,  diagonal top right (a diagonal gradient from top right to bottom left),  radial ellipse (elliptical from inner to outer) and radial circle (circlular from inner to outer).  In additon each choice has a corresponding <b>repeating</b> option. Set how many times the gradient should repeat by setting a colorstop on the last valid color/transparent option of the gradient.  If its set to 50% the gradient can repeat twice, if it is set to 33.3% the gradient will repeat 3 times, 25% and the gradient can repeat 4 times, 40% and the gradient will repeat 2.5 times and so on!!.<span class="'.$colorprint.'">Note: Background Images Will Override Background Gradients</span>');
		$this->show_close('utilitygrad');
		echo '</div></div><!--end utilitygrad-->';
		printer::printx('<p class="'.$this->column_lev_color.' editbackground editfont">Choose Which Gradient Type: Currently: '.$background_gradient_type.'<br>');
		echo '<select class="editcolor editbackground editfont"  name="'.$style.'['.$val.']['.$background_gradient_type_index.']" >        
		<option  value="'.$background_gradient_type.'" selected="selected">'.$background_gradient_type.'</option>'; 
		foreach ($background_gradient_type_array as $type){
			echo'<option  value="'.$type.'">'.$type.'</option> ';
			}
		echo '</select></p>';
		printer::printx('<p class="highlight editbackground editfont" title="By default opacity is 100%.  If you choose the transparent option which is 0% opacity, Skip choosing a color if you wish!">Choose Your Background Gradient Colors and Opacity:<br></p>');
		for ($i=1; $i<7; $i++){
			echo '<div class="fs2black editbackground editfont floatleft"><!--choose grad color-->';
			$opacity=(empty($background_array[${'background_gradient_transparency'.$i.'_index'}]))?100:$background_array[${'background_gradient_transparency'.$i.'_index'}];
			$span_color=(preg_match(Cfg::Preg_color,$background_array[${'background_gradient_color'.$i.'_index'}]))?'<span class="fs1npred" style="background:#'. $background_array[${'background_gradient_color'.$i.'_index'}].'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>':'';
			printer::printx('<p class="editcolor editbackground editfont">Enter Color Hexcode or Choose Color# '.$i.'&nbsp;<input style="cursor:pointer;background:#'.$this->editor_background.';color:#'.$this->editor_color.';" type="text" name="'.$style.'['.$val.']['.${'background_gradient_color'.$i.'_index'}.']" id="'.$style.'-'.$val.'_'.$inc.$i.'"  value="'. $background_array[${'background_gradient_color'.$i.'_index'}].'" size="6" maxlength="6"  onclick="jscolor.installByClassName(\''.$style.'-'.$val.'_'.$inc.$i.'\');" class="'.$style.'-'.$val.'_'.$inc.$i.' {refine:false}">'.$span_color.'</p>');
               printer::printx('<p class="editcolor editbackground editfont">Set an opacity:</p>');
			$this->mod_spacing($style.'['.$val.']['.${'background_gradient_transparency'.$i.'_index'}.']',$opacity,0,100,1,'%',false,'transparent');
			$this->show_more('Optional Colorstop for Color#'.$i,'noback','click editbackground editfont smaller '.$this->column_lev_color);
			echo '<div class="fsminfo editbackground editfont '.$this->column_lev_color.'"><!--color stop-->Gradient Colors will normally blend evenly spaced, however specifying a Colorstop percentage  determines at which point along the gradient the color will stop blending';
			$colorstop=(empty($background_array[${'background_gradient_color_stop'.$i.'_index'}]))?'none':$background_array[${'background_gradient_color_stop'.$i.'_index'}];
               $this->mod_spacing($style.'['.$val.']['.${'background_gradient_color_stop'.$i.'_index'}.']',$colorstop,0,100,1,'%','none');
			echo '</div><!--color stop-->';
			$this->show_close('color stop');
			echo '</div><!--choose grad color-->';
			}
		echo '<div class="editcolor editbackground editfont"><!--wrap position radial-->';
		$this->show_more('Optionally Position Radial Gradient','noback','click editbackground editfont smaller '.$this->column_lev_color);
          $this->print_redwrap('pos radial grad');
		echo '<p class="fsminfo editbackground editfont '.$this->column_lev_color.'">Radial Gradients (ellipses and circles) will Normally Be Centered Positioned. Its also possible Choose To Custom Size and Position Your Gradient Here. See http://gradientcss.com/radial-gradient for a detailed explanation of the gradient options!</p>';
		printer::printx('<p class="'.$this->column_lev_color.' editbackground editfont">Change Radial Horizontal Position (default:50%) Currently: '.$background_gradient_position1.'%<br></p>');
		$this->mod_spacing($style.'['.$val.']['.${'background_gradient_position1_index'}.']', $background_gradient_position1,0,100,1,'%');
		printer::printx('<p class="'.$this->column_lev_color.' editbackground editfont">Change Radial Vertical Position (default:50%) Currently: '.$background_gradient_position2.'%<br></p>');
		$this->mod_spacing($style.'['.$val.']['.${'background_gradient_position2_index'}.']',$background_gradient_position2,0,100,1,'%');
		printer::printx('<p class="'.$this->column_lev_color.' editbackground editfont">Optionally Change Radial Sizing Keyword: Currently: '.$background_gradient_position_keyword.'<br></p>');
		$background_gradient_keyword_array=array('closest-side','closest-corner','farthest-side','farthest-corner');
		echo '<select class="editcolor editbackground editfont"  name="'.$style.'['.$val.']['.$background_gradient_position_keyword_index.']" >        
		<option  value="'.$background_gradient_position_keyword.'" selected="selected">'.$background_gradient_position_keyword.'</option>'; 
		foreach ($background_gradient_keyword_array as $type){
			echo'<option  value="'.$type.'">'.$type.'</option> ';
			}
		echo '</select>'; 
          printer::close_print_wrap('pos radial grad');
		$this->show_close('Position radial gradient');//Position radial gradient
		echo '</div><!--wrap position radial-->';
		$this->submit_button();
		echo '</div><!-- show gradients-->';	
		printer::close_print_wrap('gradient wrap');
		$this->show_close('show gradients');echo '<!--show gradients-->';
		echo '</div><!--show background gradient floatfloatwrap-->';
		$invalid='';//(!empty($back_image_used))?'<img src="'.Cfg_loc::Root_dir.'invalid.gif" height="25" width="25" alt="background color is overridden">':'';
		$span_color='<span class="fs1npred floatleft" style="width:25px; height:25px; '. $gradient_css.'">'.$invalid.'</span>';
		(!empty($gradient_css))&&printer::printx($span_color);
		printer::pclear(1);
		################Background Image Begin	
		echo '<div class="floatleft"><!--background floatwrap-->';
		 $this->show_more('Background Image', 'noback','highlight editbackground editfont',' Use a Background Image  instead of color or color gradients.  Use them in posts, columns and menu link buttons',500);
		if(!empty($background_array[$background_video_index]))
			printer::print_caution('Note: Background image may be overriden by working background video',.7); 
		$this->print_redwrap('wrap background image');
		echo '<div class="fsminfo editbackground editfont rad3 '.$this->column_lev_color.' editfont"><!--background image enter-->A background image behaves similar to background color.  It may also be positioned if necessary<br>'; 
		if (is_file(Cfg_loc::Root_dir.Cfg::Background_image_dir.$background_array[$background_image_index])){    
               $msg2='Change the current Background Image to another previously uploaded image or click the image below to upload a new one:';
               $size	= GetImageSize(Cfg_loc::Root_dir.Cfg::Background_image_dir.$background_array[$background_image_index]);
               $width 			= $size[0];
               $height 		= $size[1];
               }
	    else {
			$width=0;
			$msg2=(empty($background_array[$background_image_index]))?'No Background Image in Use:  Enter a previously uploaded Image or click the link below to upload a new one:':'The Current Background Image is Not a Valid file: Enter a previously Uploaded Image or click the link below to upload a new one:';
			$background_image="";
			}
		echo '</div><!--background image enter-->';
		echo '<div class="'.$this->column_lev_color.' fsminfo editbackground editfont"><!--Upload background image-->Upload a Larger than Needed Background Image Size and the Size Will Always Be Updated to Match the Current Width   + any Padding Left &amp; Right Space Added. Margin Spacings Are Always Outside of Background Effects. Repeating images horizontally, and Uploaded Images smaller than the spaces provided will remain their original sizes!!<br>';
		$clone_local_style=($this->clone_local_style)?'&amp;clone_local_style=1':'';
		printer::alert('<a href="add_page_pic.php?wwwexpand=0&amp;www='.$imagepx.'&amp;ttt='.$table.'&amp;fff='.$background_image_field.'&amp;postreturn='.Sys::Self.'&amp;pgtbn='.$this->pagename.'&amp;bbb=background_image_style'.$clone_local_style.'&amp;css='.$this->roots.Cfg::Style_dir.$this->pagename.'&amp;sess_override&amp;sess_token='.$this->sess->sess_token.'"><u> Upload a new background image ...</u></a>');
		echo '</div><!--Upload background image-->';
		echo '<div class="fsminfo editbackground editfont rad3 '.$this->column_lev_color.'"><!--configure background image -->Configure Your Background Image:<br>';
		$background_image_render=true; 
		if(!empty($background_array[$background_image_index])&&!empty($background_array[$background_image_use_index])){
			printer::print_info("Background Image is enabled: ".$background_array[$background_image_index]);
			$quality=(!empty($this->page_options[$this->page_image_quality_index])&&$this->page_options[$this->page_image_quality_index]<101&&$this->page_options[$this->page_image_quality_index]>9)?$this->page_options[$this->page_image_quality_index]:Cfg::Pic_quality;
			if (!is_file(Cfg_loc::Root_dir.Cfg::Background_image_dir.$background_array[$background_image_index])){
				if (is_file(Cfg_loc::Root_dir.Cfg::Upload_dir.$background_array[$background_image_index])){
					if ($background_array[$background_image_noresize_index]){
						if (copy(Cfg_loc::Root_dir.Cfg::Upload_dir.$background_array[$background_image_index],Cfg_loc::Root_dir.Cfg::Background_image_dir.$background_array[$background_image_index])){
							($this->edit)&&printer::alert_pos('Missing Background Image has been copied to background directory');
							}
						else mail::alert('Failure to copy background image');
						}
					else {//copy resize image to background image folder
						image::image_resize($background_array[$background_image_index],$imagepx,0,0,Cfg_loc::Root_dir.Cfg::Upload_dir,Cfg_loc::Root_dir.Cfg::Background_image_dir,'file','',$quality,NULL);
						}
					}
				else {
					$tid=($this->is_blog)?$this->blog_id:(($this->is_column)?$this->col_id:'pageback '.$this->pagename);
					$msg='Missing Background image: '.$background_array[$background_image_index]. ' in Ref:'.$tid ;
					printer::alert_neg($msg);
					(Sys::Web)&&mail::alert($msg);
					$background_image_render=false;
					}
				}
			if (is_file(Cfg_loc::Root_dir.Cfg::Background_image_dir.$background_array[$background_image_index])){ 
				echo '<p class="fsmredAlert rad3 '.$this->column_lev_color.' editbackground editfont">Note: A background image is in use which overlays the background color.: '.Cfg_loc::Root_dir.Cfg::Background_image_dir.$background_array[$background_image_index].'</p>';
			    echo '<p class="left5 editcolor editbackground editfont">Edit your background image here:</p>';
			    list($width,$height)=$this->get_size($background_array[$background_image_index], Cfg_loc::Root_dir.Cfg::Background_image_dir);
			    $size=($width/$height >1)?' width="150"':' height="150"'; 
			    printer::printx('<img  src="'.Cfg_loc::Root_dir.Cfg::Background_image_dir.$background_array[$background_image_index].'" '.$size.' alt="background-images">');
			    }
			}
		printer::pclear();
		if (!is_file(Cfg_loc::Root_dir.Cfg::Background_image_dir.$background_array[$background_image_index])&&$background_array[$background_image_use_index]==1){
			printer::alert('<input name="'.$style.'['.$val.']['.$background_image_use_index.']" type="checkbox" value="0" >Turn off Background Image<br>');
			}
		else if (is_file(Cfg_loc::Root_dir.Cfg::Background_image_dir.$background_array[$background_image_index])&&$background_array[$background_image_use_index]==1){
			if ($this->edit&&(empty($background_array[$background_repeat_index])||$background_array[$background_repeat_index]==='no-repeat'||$background_array[$background_repeat_index]==='repeat-y')&&!$background_array[$background_image_noresize_index]){  
				list($width,$height)=$this->get_size($background_array[$background_image_index],Cfg_loc::Root_dir.Cfg::Background_image_dir);
				if ($imagepx > $width*1.03 || $imagepx < $width * .97){
					$return=$this->resize($background_array[$background_image_index],$imagepx,0,0,Cfg_loc::Root_dir.Cfg::Upload_dir,Cfg_loc::Root_dir.Cfg::Background_image_dir,'backgroundimage field: '.$field.' style:'.$style,'file','Background Image',NULL,'95','center',false );
					($return)&&$this->success[]="image px is $imagepx and required width is $width ".'<div><img src="'.Cfg_loc::Root_dir.Cfg::Background_image_dir.$background_array[$background_image_index].'" class="floatleft" height="50" ><p class="pl10 maxwidth400 small floatleft">This Background Image photo '.$background_array[$background_image_index].' in Post Id'.$this->blog_id.' was resized to width '. $imagepx.'</p></div>';
					} 
				}
			printer::alert('<input name="'.$style.'['.$val.']['.$background_image_use_index.']" type="checkbox" value="0" >Turn off Background Image<br>');
			}
		else if (is_file(Cfg_loc::Root_dir.Cfg::Background_image_dir.$background_array[$background_image_index]))
			printer::alert('<input name="'.$style.'['.$val.']['.$background_image_use_index.']" type="checkbox" value="1" >Turn on Previously Loaded Background Image<br>');			 
		else {
			if ($background_array[$background_image_none_index]==1)
				printer::alert('<input name="'.$style.'['.$val.']['.$background_image_none_index.']" type="checkbox" value="0" >Allow Background Image<br>');
			else printer::alert('<input name="'.$style.'['.$val.']['.$background_image_none_index.']" type="checkbox" value="1" >Prevent Background Image<br>');
			}
		$repeatclass='';
		$a1='no-repeat'; $a2='repeat-x'; $a3='repeat-y'; $a4='repeat';
		$b1=$b2=$b3=$b4='';$flag=false;
		for ($i=1;$i<5;$i++){
			if(!empty($background_array[$background_repeat_index])&&$background_array[$background_repeat_index]===${'a'.$i}){ ${'b'.$i}=' checked="checked" ';$flag=true; }
			}
		if(!$flag){
			$b1=' checked="checked" ';
			$repeatclass='class="allowthis"';
			}
		printer::alert('
	    <input name="'.$style.'['.$val.']['.$background_repeat_index.']" '.$repeatclass.' type="radio" value="no-repeat" '.$b1.' >Do Not Repeat this image<br>
	    <input name="'.$style.'['.$val.']['.$background_repeat_index.']" type="radio" value="repeat-x" '.$b2.'>Repeat this image horizontally only<br>
	    <input name="'.$style.'['.$val.']['.$background_repeat_index.']" type="radio" value="repeat-y" '.$b3.'>Repeat this image vertically only<br>
	    <input name="'.$style.'['.$val.']['.$background_repeat_index.']" type="radio" value="repeat" '.$b4.'>Repeat this image vertically and horizontally<br>');
          printer::pclear(7);
          printer::print_wrap('Opac pos tweak');
          printer::print_tip('Optional Tweak Image Position If Using opacity < 98% ');
		printer::printx('<p class="'.$posvclass.' editcolor editbackground editfont">Image Position left (0) to right (100) Change:</p>');
          $msgjava = 'Choose horizontal Positioning:';
		$this->mod_spacing($style.'['.$val.']['.$background_horiz_index.']',$bhval,0,100,1,'%','',$msgjava);
          printer::pclear(7);
		printer::printx('<p class="'.$posvclass.' editcolor editbackground editfont">Image Position top (0) to bottom (100) Change:'); 
          $msgjava = 'Choose vertical Positioning:'; 
		$this->mod_spacing($style.'['.$val.']['.$background_vert_index.']',$bvval,0,100,1,'%','',$msgjava);
          
          printer::close_print_wrap('Opac pos tweak');
          printer::pclear(7); 
		echo '</div><!--configure background image -->';
          echo '<div class="fsminfo editbackground editfont rad3 '.$this->column_lev_color.' editfont"><!--Background Image Size-->Choose Background Image Size:<br>';
          $a1='auto'; $a2='cover'; $a3='contain'; $a4='hundred';$a5='custom';
		$b1=$b2=$b3=$b4=$b5='';$flag=false;
		for ($i=1;$i<6;$i++){
			if(!empty($background_array[$background_size_index])&&$background_array[$background_size_index]===${'a'.$i}){ ${'b'.$i}=' checked="checked" ';$flag=true; }
			}
		(!$flag)&&$b1=' checked="checked" ';
		printer::alertx('
	    <p class="highlight" title="Use Original Uploaded Image Size" ><input name="'.$style.'['.$val.']['.$background_size_index.']" type="radio" value="auto" '.$b1.' >Use As Is Image Size</p>
	    <p class="highlight" title="Image resized to 100% width and height scaled to maintain width/height ratio"><input  name="'.$style.'['.$val.']['.$background_size_index.']" type="radio" value="cover" '.$b2.'>Cover to Full Width</p>
	    <p class="highlight" title="Image is proportionally scaled to maximum size without exceeding full width or full height" ><input name="'.$style.'['.$val.']['.$background_size_index.']" type="radio" value="contain" '.$b3.'>Contain Width</p>
	    <p class="highlight" title="Image width and height each independenly stretched to occupy 100% of the available space."><input  name="'.$style.'['.$val.']['.$background_size_index.']" type="radio" value="hundred" '.$b4.'>Image to Fill 100% width and 100% height</p>'); 
		//echo '<div class="fs1npinfo floatleft"><!--wrap background size-->';
		printer::alertx('<p onclick="edit_Proc.displaythis(\''.$style.'_displaypercent\',this,\'#fdf0ee\')"  class="highlight" title="Enter Percentage of Width to Fill, Percentage of Height to Fill" ><input class="myinput" name="'.$style.'['.$val.']['.$background_size_index.']" type="radio" value="custom" '.$b5.' >Use Custom Percentage for width and height&nbsp;</p>');
		$display=($background_array[$background_size_index]===$a5)?'block':'none'; 
		echo'<p style="display:'.$display.'" id="'.$style.'_displaypercent" class="editcolor editbackground editfont ">
		Image Size Fill Percentage of Available Width: ';
          $msgjava = 'Choose Percentage:'; 
		$this->mod_spacing($style.'['.$val.']['.$background_pos_width_index.']',$background_array[$background_pos_width_index],0,100,1,'%','',$msgjava);
          printer::pclear(7); 
		$this->mod_spacing($style.'['.$val.']['.$background_pos_height_index.']',$background_array[$background_pos_height_index],0,100,1,'%','',$msgjava); 
          printer::pclear(7);
          echo '</div><!--Background Image Size-->';
          echo '<div class="fsminfo editbackground editfont"><!--Image opacity-->';
          echo '<p class="editcolor editbackground editfont ">Change Background Image Opacity:  </p>';
          $this->mod_spacing($style.'['.$val.']['.$background_image_opacity_index.']',$background_image_opacity,1,100,1,'%');
          echo '</div><!--image opacity-->';
          echo '<div class="fsminfo"><!--wrap resize fixed-->';
          if (empty($background_array[$background_fixed_index])){
			printer::alertx('<p class="highlight editbackground editfont" title="When you Scroll Down the Page The Background Image Normally Scrolls Also But with a Checked Box Here the Background Image will Remain Stationary"><input type="checkbox"  name="'.$style.'['.$val.']['.$background_fixed_index.']"  value="1">Check for a Stationary Background Image</p>');
			}
		else {
			printer::alertx('<p class="highlight editfont  editbackground editfont" title="When you Scroll Down the Page The Background Image Normally Scrolls Also But with a Checked Box Here The Body Background Image is currently Set to Remain Fixed and Not Scroll Down As You Scroll Down."><input type="checkbox"  name="'.$style.'['.$val.']['.$background_fixed_index.']"  value="1">Check to Scroll the Body Background Image</p>');
			}
		if ($background_array[$background_image_noresize_index]==1)
			printer::alertx('<p class="highlight smallest" title="Allow Background Images to be resized when post is resized according to available width and image size"><input name="'.$style.'['.$val.']['.$background_image_noresize_index.']" type="checkbox" value="0" >Allow Background Image Resizing<br></p>');
		else printer::alertx('<p class="highlight smallest" title="Prevent Background Images from being resized (and image resize messages when updating) "><input name="'.$style.'['.$val.']['.$background_image_noresize_index.']" type="checkbox" value="1" >Prevent Background Images from resizing<br></p>');
		echo '</div><!--wrap resize fixed-->'; 
		printer::pclear(2);
          $this->submit_button();
		printer::close_print_wrap('wrap background image');
		$this->show_close('Background Image');//background
		#########videoback
               /*
                *Background Video is not mobile compatabile as written
                *if ($field==='blog_style'||$field==='col_style'||$field==='page_style'){
               $this->show_more('Upload Background Video','noback','infoclick editbackground editfont',' Videos can be used instead of a background color! Use them in posts, columns and menu link buttons',800);
               this->print_wrap('Upload Background Video','Os3aqua fsminfo editcolor editbackground editfont');
			
			$this->show_more('More Config Info','','small info click');
			$msg='For animated Gifs upload like ordinary background images. But Here its possible to upload mp4 videos for responsive background effect and best support with recommended codec H264. Also accepted for upload: webm, ogg and m4v';
			$id=($this->is_page)?$this->page_id:(($this->is_column)?$this->col_id:$this->blog_id);
			$id_ref=($this->is_page)?'page_id':(($this->is_column)?'col_id':'blog_id');
			printer::print_tip($msg);
			$this->show_close('More Config Info'); 
			#videoback
			echo'<p class="editcolor editbackground editfont"> <a href="add_page_vid.php?ttt='.$this->pagename.'&amp;type=background&amp;fff='.$field.'&amp;id='.$id.'&amp;id_ref='.$id_ref.'&amp;pgtbn='.$this->pagename.'&amp;postreturn='.Sys::Self.'&amp;css='.$this->roots.Cfg::Style_dir.$this->pagename.'&amp;sess_override&amp;sess_token='.$this->sess->sess_token.'"><u>Upload New Background Video</u></a></p>';
			$checked1=($background_array[$background_video_display_index]==='no_display')?'':'checked="checked"'; 
			$checked2=($background_array[$background_video_display_index]!=='no_display')?'':'checked="checked"'; echo $background_array[$background_video_display_index].' is display';
			$this->print_wrap('display','fs1salmon editcolor editbackground editfont');
			printer::alert('<input type="radio" name="'.$style.'['.$val.']['.$background_video_display_index.']" '.$checked1.' value="display" >Display background video');
			printer::alert('<input type="radio" name="'.$style.'['.$val.']['.$background_video_display_index.']" '.$checked2.' value="no_display" >No background video');
			printer::close_print_wrap('display');
			printer::print_tip('Videos will resize automatically to fill the available width and height completely.  Enter the width/height ratio of your video for proper proportions');
			printer::alert('Change the ratio of width over height to get the proper video aspect ratio<input type="text" name="'.$style.'['.$val.']['.$background_video_ratio_index.']" value="'.$background_video_ratio.'" size="5" maxlength="5">');
			printer::close_print_wrap('Upload Background Video');
			$this->show_close('Upload Background Video');
			}#End backvideo*/
		echo '</div><!--  show more background floatwrap-->';
		if(!empty($background_array[$background_image_index])&&!empty($background_array[$background_image_use_index])&&is_file(Cfg_loc::Root_dir.Cfg::Background_image_dir.$background_array[$background_image_index])){
			$opacitybackground=true;
			$size=($width/$height >1)?'width="25"':'height="25"'; 
			printer::printx('<img  class="fs1npred mt5" src="'.Cfg_loc::Root_dir.Cfg::Background_image_dir.$background_array[$background_image_index].'" '.$size.' alt="background image">');
			}
          $this->show_more('Background Toggle Off','','highlight  editbackground editfont');
          printer::print_wrap('Background Toggle off');
          printer::print_info('Quickly Toggle on/off background color or  a background Gradients/Image without changing configs here. Can also be used in nav submenus to disable particlular styles made in main menu.<br> Specifies background-color:transparent;<br>or background-image:none; for images or gradient'); 
          $checked=' checked="checked" ';
          $checked1=($background_array[$background_color_off_index]==='coloroff')?$checked:''; 
          $checked2=($background_array[$background_color_off_index]!=='coloroff')?$checked:'';    
          printer::alert('<input type="radio" name="'.$style.'['.$val.']['.$background_color_off_index.']" '.$checked1.' value="coloroff" >Display background color OFF');
          printer::alert('<input type="radio" name="'.$style.'['.$val.']['.$background_color_off_index.']" '.$checked2.' value="1" >Display background color ON');
          $checked1=($background_array[$background_image_off_index]==='imageoff')?$checked:''; 
          $checked2=($background_array[$background_image_off_index]!=='imageoff')?$checked:'';    
          printer::alert('<input type="radio" name="'.$style.'['.$val.']['.$background_image_off_index.']" '.$checked1.' value="imageoff" >Display background image or gradient OFF');
          printer::alert('<input type="radio" name="'.$style.'['.$val.']['.$background_image_off_index.']" '.$checked2.' value="1" >Display background image or gradient ON');
          printer::close_print_wrap('Background Toggle off');
          $this->show_close('Background Toggle off');     
		echo '</div><!--background style border -->';
		$this->show_close('background');//<!--show close background-->';
		printer::pclear();
		}//if editable
	$background_fixed=(!empty($background_array[$background_fixed_index]))?'
	background-attachment: fixed; ':'';
	switch ($background_array[$background_size_index]){
		case 'auto' :
			$background_size='background-size:auto;';
			break;
		case 'cover' :
			$background_size='background-size:cover;';
			break;
		case 'contain' :
			$background_size='background-size:contain;';
			break; 
		case 'hundred' :
			$background_size='background-size:100% 100%;';
			break;
		case 'custom' :
			$background_size='background-size:'.
$background_array[$background_pos_width_index].'% '.$background_array[$background_pos_height_index].'%;';
			break;
		default:
			$background_size='background-size:auto;';
		}
     $background_repeat=($background_array[$background_repeat_index]==='repeat-x'||$background_array[$background_repeat_index]==='repeat-y') ?' background-repeat: '.$background_array[$background_repeat_index].';':' background-repeat:no-repeat;'; 
	$background_position='background-position: '.$bhval.'% '.$bvval.'%;';
	$video_css='';//currently not used (!empty($background_array[$background_video_index])&&strlen($background_array[$background_video_index])>30&&($field==='blog_style'||$field==='col_style'))?'position:relative;z-index:1;':''; 
	$fstyle='final_'.$style; 
	if (strpos($style,'page_style')!==false&&!empty($gradient_css)&&!empty($background_image_off)){
          //hack to use body:before for background gradient.
          $this->pagecss.='
body:before {
	content:"";
	position:fixed;
	left:0;
	top:0;
	right:0;
	bottom:0;
	z-index:-1;'  
	.$gradient_css.' 
     }'; 
          $gradient_css='';
          }
     $gradient_css=($background_image_off)?'':$gradient_css;
     $background_color=($background_color_off)?'':$background_color;
	if ($background_image_opacity>96||!$opacitybackground){
		$background_image=($background_image_off)?'background:none;':((is_file(Cfg_loc::Root_dir.Cfg::Background_image_dir.$background_array[$background_image_index])&&!empty($background_array[$background_image_use_index]))?$background_fixed.' background-image:url('.Cfg_loc::Root_dir.Cfg::Background_image_dir.$background_array[$background_image_index].'); '.$background_repeat . $background_position.$background_size :(($background_array[$background_image_none_index])?'background-image:none;':''));  
		$fstyle='final_'.$style;
		$this->{$fstyle}[$val]=$background_color.$gradient_css.$background_image.$video_css; 
		}
	else{ 
		$fstyle='final_'.$style; 
		$this->{$fstyle}[$val]='position:relative;z-index:1;'.$background_color.$gradient_css;
		$background_image=$background_image=($background_image_off)?'background:none;':((is_file(Cfg_loc::Root_dir.Cfg::Background_image_dir.$background_array[$background_image_index])&&!empty($background_array[$background_image_use_index]))?$background_fixed.' background-image:url('.Cfg_loc::Root_dir.Cfg::Background_image_dir.$background_array[$background_image_index].'); '.$background_repeat .' left: '.$bhval.'%; top:'.$bvval.'%;'.$background_size :(($background_array[$background_image_none_index])?'background-image:none;':''));
	$background_opacity='opacity:'.($background_image_opacity/100).';';
	if (strpos($background_image.$background_opacity,'@@')!==false)return;
		$pelement=str_replace(',',':after,',trim($this->pelement,','));
		$this->css.="\n".trim($pelement).':after { 
    content : "";
    width: 100%;
    height: 100%;
    display: block;
    position: absolute;
    z-index: -1;
    '.
$background_image.'
   '.$background_opacity.'}'; 
          $css_id=($this->is_column)?$this->col_dataCss:$this->dataCss;
          $this->editoverridecss.='#'.$css_id.' {position:relative !important;}';
          $this->overlapbutton=true; 
		}//end opacity
	}//end background#end background 
	
function text_align($style, $val, $field){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	//show_text_style is a hack to enable display of only the text-align option when display menu general styles which actually affects menu link position justificcation. is false for other applications ie display none until main text style link is clicked in styling options
	$display=($this->show_text_style)?'':' style="display:none;"';
	$class=($this->show_text_style)?'':'fsminfo';
	$txtmsg=(($this->is_blog&&$this->blog_type==='navigation_menu')&&$field==='blog_style')?'Link Align: ':'Text Align: ';
	$title=(($this->is_blog&&$this->blog_type==='navigation_menu')&&$field==='blog_style')?'This setting will change the positioning of Links within Navigation Menus':'Select Left right or Center Align the text widthin this post/Can also Effect Image. If none is selected it will inherit the value from the parent &#40;Which may be a Column or the Body Setting&#41;';
	if ($this->is_page|| ($this->is_blog&&!$this->is_clone)||($this->is_column&&!$this->is_clone||$this->clone_local_style)){  
		$textalign= (empty($this->{$style}[$val]))? 'Inherited': $this->{$style}[$val];
		echo '<div class="'.$class.' editbackground editfont floatleft '.$style.'_hidefont"'.$display.'><!--text align border-->';
		echo'<p class="highlight" title="'.$title.'">'.$txtmsg.' Currently '.$textalign.'</p>';
		echo '<p>
		<select class="editcolor editbackground editfont"  name="'.$style.'['.$val.']" id="'.$style.'_'.$val.'">        
		<option  value="'.$this->{$style}[$val].'" selected="selected">'.$textalign.'</option>
		<option  value="0">Choose None</option>
		<option  value="left">Left Align</option>
		<option  value="center">Center Align</option> 
		<option  value="right">Right align</option> 
		</select>';
		echo'
		</p></div><!--text align border-->';
		printer::pclear(2);
		}
	$fstyle='final_'.$style;
	$this->{$fstyle}[$val]=(!empty($this->{$style}[$val]))?' text-align: '.$this->{$style}[$val].';':'0';
    }
    
//italics-font,small-caps,line-height,letter-spacing';
function line_height($style,$val){   if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	$sval=(!empty($this->{$style}[$val])&&$this->{$style}[$val]>29&&$this->{$style}[$val]<251)?$this->{$style}[$val]:100;
	if ($this->is_page|| ($this->is_blog&&!$this->is_clone)||($this->is_column&&!$this->is_clone||$this->clone_local_style)){  
		echo '<div class="fs1color floatleft '.$style.'_hidefont" style="display:none;"><!--Edit line height-->';  
		echo '<p class="'.$this->column_lev_color.' editfont ">Adjust line height between lines:</p>';
		$arr=array(30,40,50,60,70,80,90,100,150,200,250,300);
		$arr2=array('30%','40%','50%','60%','70%','80%','90%','100% normal','150%','200%','250%','300%');
		forms::form_dropdown($arr,$arr2,'','',$style.'['.$val.']',$sval,false,'editcolor editbackground editfont left');
		echo '</div><!--Edit line height-->';
          }
	$fstyle='final_'.$style;
	$this->{$fstyle}[$val]=($sval!==100)?'line-height:'.$sval.'%;':'';
	}//end function

function letter_spacing($style,$val){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
    $letter_arr=explode('@@',$this->{$style}[$val]);
    for ($i=0; $i<2;$i++){
          if(!array_key_exists($i,$letter_arr))$letter_arr[$i]=0;
          }
    $letter_unit=($letter_arr[1]==='rem'||$letter_arr[1]==='em')?$letter_arr[1]:'em';
    $sval=(!empty($letter_arr[0])&&$letter_arr[0]>=-.3&&$letter_arr[0]<=5)?$letter_arr[0]:0;
	if ($this->is_page|| ($this->is_blog&&!$this->is_clone)||($this->is_column&&!$this->is_clone||$this->clone_local_style)){  
          echo '<div class="fs1color floatleft pt10 pb10 '.$style.'_hidefont" style="display:none;"><!--Edit letter spacing-->';
          $this->show_more('Letter Spacing','',' highlight editbackground editfontfamily','Change default letter-spacing of 0 by adding or subtracting space between leters');
          printer::print_redwrap('letter spacing');
		echo '<p class="'.$this->column_lev_color.' editfont ">Add or Subtract space between letters</p>'; 
		 printer::alert('Choose unit:');
          $checked=' checked="checked" ';
          $checked1=($letter_unit!=='rem')?$checked:'';
          $checked2=($letter_unit==='rem')?$checked:'';     
          printer::alert('<input type="radio" name="'.$style.'['.$val.'][1]" value="em" '.$checked1.'>em units');
          printer::alert('<input type="radio" name="'.$style.'['.$val.'][1]" value="rem" '.$checked2.'>rem units'); 
          printer::pclear(5);
          $msg=(empty($sval))?'default':$sval;
          echo'<p class="'.$this->column_lev_color.' editbackground editfont">Letter-spacing: Currently '.$msg.'<br>';
          $msgjava='Choose letter spacing:'; 
          $this->mod_spacing($style.'['.$val.'][0] ',$sval,-.3,5,.01,'units','none',$msgjava); 
          printer::close_print_wrap('letter spacing');
		$this->show_close('Letter Spacing');
          echo '</div><!--Edit letter spacing-->';
          }
	$fstyle='final_'.$style;
	$this->{$fstyle}[$val]=(!empty($sval)&&is_numeric($val))?'letter-spacing:'.$sval.$letter_unit.';':'';
     }//end function
	 
function italics_font($style,$val){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
     $var='font-style:italic;';  
     $this->font_effects($style,$val,$var);
     }//end function
	 
function small_caps($style,$val){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
    $var='font-variant: small-caps;';
    $this->font_effects($style,$val,$var);
     }//end function 

function text_underline($style, $val, $field){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
     $var='text-decoration:underline;';
     $this->font_effects($style,$val,$var);
     }//end function
	 	 
function font_effects($style,$val,$var){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);  
     if ($this->is_page|| ($this->is_blog&&!$this->is_clone)||($this->is_column&&!$this->is_clone||$this->clone_local_style)){
		$functions=explode(',',Cfg::Style_functions);
		if (array_key_exists($val,$this->$style)&&$this->{$style}[$val]) :
			echo '<p class="'.$this->column_lev_color.' editfont '.$style.'_hidefont" style="display:none; text-align: left;"><input type="checkbox"  name="'.$style.'['. $val .']"   value="0">Turn Off '. $functions[$val].'</p>';
		else :
			echo '<p class="'.$this->column_lev_color.' editfont '.$style.'_hidefont" style="display:none;text-align: left;"><input type="checkbox"  name="'.$style.'['. $val .']"  value="1">Turn On '. $functions[$val].'</p>';
		endif;
		}
	$fstyle='final_'.$style; 
	$this->{$fstyle}[$val]=($this->{$style}[$val])?$var:'';
	}
  
function font_color($style, $val, $field ,$msg=''){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	if ($this->is_page|| ($this->is_blog&&!$this->is_clone)||($this->is_column&&!$this->is_clone||$this->clone_local_style)){  
		static $fontcinc=0; $fontcinc++;
		(empty($msg))&&print '<p class="highlight click   floatleft" title="edit various text styles" id="font'.$fontcinc.'"  onclick="edit_Proc.getTags(\''.$style.'_hidefont\',\'showhide\',id);return false;">Text Styles</p>';
		if (!empty($msg)) {
			$hidefont='';
			$bordercolor='';
			$styledisplay='';
			}
		else {
			$msg='Enter/Choose Font Color';
			$hidefont=$style.'_hidefont';
			$bordercolor='fsminfo editbackground editfont';
			$styledisplay='style="display:none"';
			} 
		printer::pclear();  
		$background=(preg_match(Cfg::Preg_color,$this->{$style}[$val]))?'background: #'.$this->{$style}[$val].';':'background: #'.$this->current_color.';';
          $currentcolor=(preg_match(Cfg::Preg_color,$this->{$style}[$val]))?$this->{$style}[$val]:'inherited';
		$span_color='<span class="fs1npred" style="'.$background.' color:#'.$this->current_background_color.';">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>';
		echo'
		<div class="'.$bordercolor.' floatleft '.$hidefont.'" '.$styledisplay.'> <p class="highlight" title="Change the text color (font) of this post by Entering a valid font color 3 or 6 digit color code or clicking in the entry box which opens the Color Selector tool! Enter any blank or 0 to go back to the inherited parent color &#40;Inherited Parent Values are the most recent values that have been set in the parent Columns and if not set there then in the body or the default black!!">'.$msg.' : #<input onclick="jscolor.installByClassName(\''.$style.'_'.$val.'\');"  style="cursor:pointer;background:#'.$this->editor_background.';color:#'.$this->editor_color.';"  class="'.$style.'_'.$val.' {refine:false}"   name="'.$style.'['.$val.']"  id="'.$style.'_'.$val.'" value="'.$currentcolor.'"
		size="6" maxlength="6"  >'.$span_color.'</p>  
		';
		printer::pclear(1); 
		echo'
		</div>';
		}
	$fstyle='final_'.$style;
	$this->{$fstyle}[$val]=(!empty($this->{$style}[$val])&&preg_match(Cfg::Preg_color,$this->{$style}[$val]))?'color: #'.$this->{$style}[$val].';':0;//'color: #'.$this->current_color.';';   
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
		$this->col_width=(is_numeric($this->col_width)&&$this->col_width > 5 &&$this->col_width <= Cfg::Col_maxwidth)?$this->col_width:0;
          if (empty($this->col_width)){
               $this->current_total_width=$this->column_total_width[$this->column_level]= (!empty($this->page_width))?$this->page_width:Cfg::Page_width;// page_width setting passes to create new page. 
               $mxw=$this->alt_width_calc($this->col_options[$this->col_max_width_opt_index]);
               $this->col_width_info.='Column alt max-width: '.$this->width_info; 
               $minw=$this->alt_width_calc($this->col_options[$this->col_min_width_opt_index]);
               $this->col_width_info.='Column alt min-width: '.$this->width_info;
               $w=$this->alt_width_calc($this->col_options[$this->col_width_opt_index]);
               $col_width=($w >9&&$mxw>9)?min($mxw,$w):max($mxw,$w);//takes the smaller of the two if both widths exist
               $col_width=max($col_width,$minw);//takes the larger of the two
               $this->col_width_info.='Column alt width: '.$this->width_info;
               if (empty($col_width)){
                    $this->use_col_main_width=false;
                    $col_width=$this->page_width; 
                    }
               else $this->use_col_main_width=false;
               }
		else { 
               $this->use_col_main_width=true;
               $col_width=$this->col_width;
               }
          $this->track_col_width=$col_width;
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
               $mxw=min($widmax,$this->alt_width_calc($this->col_options[$this->col_max_width_opt_index]));
               $this->col_width_info.='Column alt max-width: '.$this->width_info; 
               $minw=min($widmax,$this->alt_width_calc($this->col_options[$this->col_min_width_opt_index]));
               $this->col_width_info.='Column alt min-width: '.$this->width_info;
               $w=min($widmax,$this->alt_width_calc($this->col_options[$this->col_width_opt_index]));
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
               $mxw=$this->alt_width_calc($this->blog_options[$this->blog_max_width_opt_index]); 
               $this->blog_width_info.='Blog alt max-width: '.$this->width_info; 
               $minw=$this->alt_width_calc($this->blog_options[$this->blog_min_width_opt_index]);
               $this->blog_width_info.='Blog alt min-width: '.$this->width_info;
               $w=$this->alt_width_calc($this->blog_options[$this->blog_width_opt_index]);
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
		/* if ($this->blog_type==='image'){
			list($bw,$bh)=$this->border_calc($this->blog_data4,false);
			$hwidth=$this->calc_image_height($bh); 
			if ($hwidth > 9&&$hwidth<$widmax){ //we dont want to overexpand image..
				//percentage expressed in compress_to_percentage...  choice
				$this->current_net_width_percent=$blog_width-($bw*$this->column_total_width[$this->column_level]/100+$this->current_padded_width_percent);
				$this->current_total_width_percent=$hwidth/$this->current_total_width*$this->blog_width;
				$this->current_net_width=$hwidth-($bw+$this->current_padded_width_px);//current padded calculate for border sides presuming same for height
				$this->current_total_width=$hwidth; 
				}
			}*/
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
     $this->show_more($msg_open_prefix.$msg.' Col#'.$this->column_order_array[$this->column_level],'','highlight fs1'.$this->column_lev_color.' editbackground editfont  rad3 editfont ','Click Here To Add New Posts/Column and For More info on making Choices',250);
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
	echo'  <p class="clear"><input  type="hidden" name="submitted"  value="1" ></p><p><input class="editbackground editfont rad5 smallest cursor button'.$this->column_lev_color.' '.$this->column_lev_color.' mb10" type="submit" name="submit"   value="'.$value.'" ></p>';
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

#alt_resp
function width_options($type,$data){ 
	$this->show_more('em, rem, %, px &amp; px scale opt for  min-width, max-width, &amp; width choices');
	$this->print_redwrap('more width');
     printer::print_info('Note: Choosing a main width mode value (or using RWD Grid) overrides any choices made from options here. To deactivate main width use mode 1 with main value 0');
	if ($this->is_column)
		printer::print_tip('As rem em and px choices made here may be tied directly to viewport rwd scaling, the width tracking information for rwd grid and the main max-width choices will not be available for subsequent posts within this column. RWD grid w/o width calc however will still be usuable if needed.',.7);
     printer::print_tip('Alt scaling width units  ie. em, rem,  %, px may be used instead of the main width mode without width tracking and is compatible with active flex-items initial sizing');
     if ($this->{'use_'.$type.'_main_width'})printer::print_info('Main width choice is activated and will override these options.');
	$css_id=($this->is_column)?$this->col_dataCss:$this->dataCss;
     $this->show_more('Style info','','info italic smaller');
     printer::print_wrap1('techinfo');
     printer::print_info('Width choices made here are directly applied to '.$type.' main div class: .'.$css_id .' (unless overriden as outlined above)');
     printer::close_print_wrap1('techinfo');
     $this->show_close('Tech info');
	$this->width_max_special($data.'_'.$type.'_options',$this->{$type.'_max_width_opt_index'},'','.'.$css_id,$this->{'use_'.$type.'_main_width'});
	$this->width_special($data.'_'.$type.'_options',$this->{$type.'_width_opt_index'},'','.'.$css_id,$this->{'use_'.$type.'_main_width'});
	$this->width_min_special($data.'_'.$type.'_options',$this->{$type.'_min_width_opt_index'},'','.'.$css_id,$this->{'use_'.$type.'_main_width'});
	printer::close_print_wrap('more width');	
	$this->show_close('em, rem, px with scale, min-width, max-width, &amp; width choices');
	}
     
function isSerialized($s){//from stackoverflow
     if(stristr($s, '{' ) != false &&
          stristr($s, '}' ) != false &&
          stristr($s, ';' ) != false &&
          stristr($s, ':' ) != false){
          return true;
          } 
     return false;
     }

function position(){
	$options=($this->is_column)?$this->col_options[$this->col_position_index]:$this->blog_options[$this->blog_position_index];
     $type=($this->is_column)?'Column':'Post';
	$prefix=($this->is_column)?'col':'blog'; 
	$options=explode('@@',$options);
	$opacity_index=($this->is_column)?$this->col_opacity_index:$this->blog_opacity_index;
	//see Cfg::Position_options for keys to $options array.
	$c_opts=count(explode(',',Cfg::Position_options));
     $count=3;//number of @media position options
	$mcount=$count*$c_opts;
     for ($i=0;$i<$mcount; $i++){
		if (!array_key_exists($i,$options))$options[$i]=0;
		}  
	$pos_horiz_vals_arr=array('none','left','right','center horizontally');
	$pos_vert_vals_arr=array('none','top','bottom','center vertically'); 
	$pos_arr=array('static','relative','absolute','fixed','none'); 
	#note: pos property, pos property, and advanced styles use css 	#id to override normal styles which use distinct classnames
	$msg='Responsive positioning option for this '.$type;
	$this->show_more('Position & Opacity Option','','',$msg,'800');
	$this->print_redwrap('wrap advanced position',true);
     $css_id=($this->is_column)?$this->col_dataCss:$this->dataCss;
     for ($i=0; $i<3; $i++){
          $k=$i*$count;//
          if ($i>0){
               $this->show_more('Add additional @media query controlled option tweak for position options');
               $this->print_redwrap('additional media wrap #'.$i);
               }
     $name=($this->is_column)?$this->col_name.'_col_options['.$this->col_position_index.']':$this->data.'_blog_options['.$this->blog_position_index.']';
     $pos_horiz_val_name=($this->is_column)?$this->col_name.'_col_options':$this->data.'_blog_options';
     $pos_vert_val_name=($this->is_column)?$this->col_name.'_col_options':$this->data.'_blog_options'; 
	$max_name=$name.'['.($this->position_max_index+$k).']';
	$min_name=$name.'['.($this->position_min_index+$k).']';
	$pos_name=$name.'['.($this->position_index+$k).']';
	$pos_vert_name=$name.'['.($this->position_vert_index+$k).']';
	$pos_horiz_name=$name.'['.($this->position_horiz_index+$k).']';
	$pos_zindex_name=$name.'['.($this->position_zindex_index+$k).']';
     $opacity_name=$name.'['.($this->position_opacity_index+$k).']';
	$opacity_val=(is_numeric($options[$this->position_opacity_index+$k])&&$options[$this->position_opacity_index+$k]>=6&&$options[$this->position_opacity_index+$k]<=100)?$options[$this->position_opacity_index+$k]:'none';
     $pos_horiz_val=$options[$this->position_horiz_val_index+$k];
	$pos_vert_val=$options[$this->position_vert_val_index+$k];
	$pos_horiz=(!empty($options[$this->position_horiz_index+$k])&&in_array($options[$this->position_horiz_index+$k],$pos_horiz_vals_arr))?$options[$this->position_horiz_index+$k]:'none'; 
	$pos_vert=(!empty($options[$this->position_vert_index+$k])&&in_array($options[$this->position_vert_index+$k],$pos_vert_vals_arr))?$options[$this->position_vert_index+$k]:'none';
     $pos_type=(!is_numeric($options[$this->position_index+$k])&&in_array($options[$this->position_index+$k],$pos_arr))?$options[$this->position_index+$k]:'none';  
	$ifemptyvert=($pos_type!='static'&&$pos_type!='none'&&$pos_vert==='top'||$pos_vert==='bottom')?$pos_vert.':0;':'';
     $ifemptyhoriz=($pos_type!='static'&&$pos_type!='none'&&$pos_horiz==='right'||$pos_horiz==='left')?$pos_horiz.':0;':'';
	$pos_zindex=($pos_type!='static'&&$pos_type!='none'&&is_numeric($options[$this->position_zindex_index+$k]))?$options[$this->position_zindex_index+$k]:'none';
	$val_max=$options[$this->position_max_index+$k];
	$val_min=$options[$this->position_min_index+$k];
	$pos_maxpx=($val_max>=200&&$val_max<=3000)?$val_max:'none';
	$pos_minpx=($val_min>=200&&$val_min<=3000)?$val_min:'none';
	$mediacss='';
	$pos_zindex_style=(is_numeric($pos_zindex))?'z-index:'.(int)$pos_zindex.';':'';
	if ($pos_type!='static'&&$pos_type!='none'&&$pos_horiz==='center horizontally')
		$pos_horiz_style='left: 0;  right: 0;  margin-left: auto; margin-right: auto;'; 
	else $pos_horiz_style='';
	if ($pos_type!='static'&&$pos_type!='none'&&$pos_vert==='center vertically') 
		$pos_vert_style='top: 50%;transform: translateY(-50%); -ms-transform: translateY(-50%);-webkit-transform: translateY(-50%);';
	else $pos_vert_style='';
	$opacity= ($opacity_val!=='none')?'opacity:'.($opacity_val/100).';':'';
	$pos_css='position:'.$pos_type.';';
     if ((($pos_type!='static'&&$pos_type!='none')||!empty($opacity))&&$pos_minpx!=='none'&&$pos_maxpx!=='none') {
		$mediacss.='
		@media screen and (max-width:'.$pos_maxpx.'px) and (min-width:'.$pos_minpx.'px){
		.'.$css_id.'{'.$pos_css.'
		'.$pos_zindex_style.$pos_vert_style.$pos_horiz_style.$opacity.'}
			}
			';
		}
	elseif ((($pos_type!='static'&&$pos_type!='none')||!empty($opacity))&&$pos_maxpx!=='none'){
		$mediacss.='
		@media screen and (max-width: '.$pos_maxpx.'px){
		.'.$css_id.'{'.$pos_css.';
		'.$pos_zindex_style.$pos_vert_style.$pos_horiz_style.$opacity.'}
		}';
		}
	elseif ((($pos_type!='static'&&$pos_type!='none')||!empty($opacity))&&$pos_minpx!=='none') {
		$mediacss.='
		@media screen and (min-width: '.$pos_minpx.'px){
		.'.$css_id.'{'.$pos_cs.';
		'.$pos_zindex_style.$pos_vert_style.$pos_horiz_style.$opacity.'}
		}';
		}
	elseif ((($pos_type!='static'&&$pos_type!='none')||!empty($opacity))) {
		$mediacss.=' 
		.'.$css_id.'{'.$pos_css.';
		'.$pos_zindex_style.$pos_vert_style.$pos_horiz_style.$opacity.'}';
		}
	
     elseif ($pos_type!='none') {
		$mediacss.=' 
		.'.$css_id.'{position:static;'.$opacity.'}';
		}
     elseif (!empty($opacity)) {
		$mediacss.=' 
		.'.$css_id.'{'.$opacity.'}';
		}
	$this->css.=$mediacss;
     $this->show_more('Style info','','info italic smaller');
     printer::print_wrap1('techinfo');
     printer::print_info('Current setting Css: '.$mediacss);
     $msg='The following position/opacity css is applied to the main div class '.$css_id.' of this '.$prefix;
     printer::print_info($msg);
     printer::close_print_wrap1('techinfo');
     $this->show_close('Tech info');
	$this->editoverridecss.='#'.$css_id.',.'.$css_id.'{opacity:1;position:static !important; transform: none;-ms-transform: none;-webkit-transform: none;z-index:0 !important;}';
	//$this->editoverridecss.='.'.$css_id.'{opacity:1; }';  
	$this->submit_button();
     printer::print_tip('Set Advanced  Options for Position and Opacity Here with optional max-width and min-width for responsive design. Changes to position and opacity will NOT EFFECT EDIT MODE display. View changes in webpage mode!');
	printer::print_wrap1('opacity value');  
     printer::print_tip('Change Opacity will affect entire '.$type.'. To affect the opacity of background color, gradients or images use the opacity options for those under the background styling options. Note: Opacity changes here may also Modify the Stacking Order of positioned posts <b>otherwise the opacity option functions independently of the postion options</b>');
     printer::alert('Choose opacity Value.');
     $this->mod_spacing($opacity_name,$opacity_val,6,100,1,'%','none');
     printer::close_print_wrap1('opacity value'); 	
     printer::pclear(5);
	printer::alertx('<div class="'.$this->column_lev_color.' fsminfo  floatleft editbackground editfont">Choose Advanced Position Option');
	printer::print_tip('Normal layout displays use static. Choose it to turn off advanced position option. Fixed position will lock the post or column from scrolling down the page and useful for anchor menus. Relative and Absolute may be use to overlap posts and or columns relative to a parent column "set to relative" or absolute to the body. Position Top Bottom Left and Right, or center only work with Fixed, Relative, or Absolute Positioning enabled.');
	forms::form_dropdown($pos_arr,'','','',$pos_name,$pos_type,false,'editcolor editbackground editfont left');
	printer::alertx('</div>');
     printer::print_wrap1('horiz value');  
     printer::print_tip('If Position is Set to Relative or Absolute Choose to Modify the left right alignment of this '.$type.' by selecting the option type and value<br>');
     printer::pclear();
     printer::alertx('<div class="'.$this->column_lev_color.' fsminfo maxwidth500 floatleft editbackground editfont">Choose Right or Left, None (As is), or use Center Horizonally.'); 
     forms::form_dropdown($pos_horiz_vals_arr,'','','',$pos_horiz_name,$pos_horiz,false,'editcolor editbackground editfont left');
     printer::alertx('</div>');
     printer::pclear();
     printer::print_wrap('Choose pos units');
     printer::print_tip('Choose px, em, rem, units. Otherwise a default value of 0 will be used');
     printer::pclear(); 
     $horizpass=($pos_horiz==='left'||$pos_horiz==='right')?$pos_horiz:'none';
      $this->spacing($pos_horiz_val_name,$this->{$prefix.'_pos_horiz_val_index'},$horizpass,'Choose left or right positioning value','Adjust Horiz Position of absolute or relative positioned element/post/column','',$ifemptyhoriz,'','','.'.$css_id);  
     printer::close_print_wrap('Choose pos units');
     printer::close_print_wrap1('horiz value');
     printer::pclear(5);
     printer::print_wrap1('vert value');  
     printer::print_tip('If Position is Set to Relative or Absolute Choose to Modify the Top Bottom alignment of this '.$type.' by selecting the option type and value<br>');
     printer::alertx('<div class="'.$this->column_lev_color.' fsminfo maxwidth500 floatleft editbackground editfont">Choose to position using Top or Bottom, None (As is), or use Center Vertically. <b>Note using both Center Vertically and an animation on this same post can change the animation path ie. on sliding animations</b>'); 
     forms::form_dropdown($pos_vert_vals_arr,'','','',$pos_vert_name,$pos_vert,false,'editcolor editbackground editfont left'); 
     printer::alertx('</div>');
     printer::pclear(); 
     printer::alertx('<div class="fs1black editcolor editbackground editfont">If Position is Set to Relative or Absolute and you also Choose a position Top or Bottom  choose a numeric value here in percent, px, em, rem, vw, or vh units. Otherwise a default value of 0 will be used');
     printer::pclear();
     $vertpass=($pos_vert==='top'||$pos_vert==='bottom')?$pos_vert:'none';
     $this->spacing($pos_vert_val_name,$this->{$prefix.'_pos_vert_val_index'},$vertpass,'top or bottom positioning value','Adjust Vert Position of absolute or relative positioned element/post/column','',$ifemptyvert,'','','.'.$css_id); 
     printer::alertx('</div>');
     printer::close_print_wrap1('vert value'); 	
     printer::pclear(5);  
     printer::print_wrap1('zindex value');  
     printer::print_tip('Change Zindex to Modify the Stacking Order of this '.$type.'. Higher numbers overlap lower numbers');
     printer::alert('Choose z-index Value.');
     $this->mod_spacing($pos_zindex_name,$pos_zindex,-100,1000,.5,'','none');
     printer::close_print_wrap1('zindex value'); 	
     printer::pclear(5); 
     printer::print_info('Optionally choose a @media screen size min-width or max-width or both at which this '.$type.' will Position to custom setting.');  
     echo '<div class="fsminfo"><!--wrap max width-->';
     printer::printx('<p class="smaller '.$this->column_lev_color.'">(0 = none)Current Max-width: <span class="navybackground white">'.$pos_maxpx.'</span><br></p>');   
     printer::alert('Choose @media screen max-width px');
     $this->mod_spacing($max_name,$pos_maxpx,200,3000,1,'px','none');  
     printer::printx('<p ><input type="checkbox" name="'.$max_name.'" value="0">Remove max-width</p>');
     echo '</div><!--wrap max width-->';
     echo '<div class="fsminfo"><!--wrap min width-->';
     printer::printx('<p class="smaller '.$this->column_lev_color.'">(0 = none) Chosen Min-width: <span class="navybackground white">'.$pos_minpx.'</span></p>');
      printer::alert('Choose @media screen min-width px'); 
     $this->mod_spacing($min_name,$pos_minpx,200,3000,1,'px','none');
     printer::printx('<p ><input type="checkbox" name="'.$min_name.'" value="0">Remove min-width</p>');
     echo '</div><!--wrap min width-->';	 
     $this->submit_button();
     if ($i>0){
               
               $this->submit_button( );
               printer::close_print_wrap('additional positon media wrap #'.$i);
               $this->show_close('Add additional @media query controlled option tweak for position options'); 
               } 
          }//end for 
     printer::pclear();  
     printer::close_print_wrap('wrap advanced position');
     $this->show_close('wrap advanced position'); 
     printer::pclear();
	}//end position
      
function height_style($type,$data){  
	static $topinc=0; $topinc++;
	$this->show_more('Post Height Option');
	$this->print_redwrap('Uniform Post Height Option');
     if ($type==='blog')
          printer::print_tip('Normally Heights are automatically set and setting a height is unnecessary. However you can set heights here for effects such as having all posts in a column the same height for a tile effect.</em> <br>');
     else 
          printer::print_notice('Setting a Column Height specifies the overall Column Height not the height of individual posts within.');
     printer::print_wrap1('height style');
	printer::print_tip('Height is generally determined automatically from Content height but can be custom specified here. Choose from height, max-height, min-height and units');
     if ($type=='blog'&&$this->blog_type==='image')
          printer::print_warn('Images have an image specific config to set the image height identical to post height and an optional mediaq query to revert to width:auto;  You can also choose a sufficiently large max-width option to limit the download width and the correct image ratio w/h will still be maintained by the height you choose.'); 
	printer::pclear(4); 
	printer::close_print_wrap1('height style');
	$this->height_options($type,$data);
     printer::close_print_wrap('image height');
	$this->show_close('Post Height Option');
     $css_id=($type==='col')?$this->col_dataCss:$this->dataCss;
     if($type==='blog'&&($this->blog_type==='image'||$this->blog_type==='auto_slide')) 
          $this->editoverridecss.='#'.$css_id.' img{height:auto;}
          ';
     $this->editoverridecss.='#'.$css_id.'{min-height:0px;height:100%;overflow:visible;}';
	}//end height_style
	
     
function height_options($type,$data){
     $index_arr=array('mediamax0','mediamin0','mediamax1','mediamin1','mediamax2','mediamin2');
     $blog_media_arr=explode('@@',$this->{$type.'_options'}[$this->{$type.'_height_media_index'}]);
     for ($i=0;$i<18;$i++){# 3 iterations* 6 values
          if (!array_key_exists($i,$blog_media_arr))
               $blog_media_arr[$i]=0;
          }
     foreach ($index_arr as $key=>$value){
          ${$value.'_index'}=$key;
          }
     $name=$data.'_'.$type.'_options['.$this->{$type.'_height_media_index'}.']';
     $css_id=($this->is_column)?$this->col_dataCss.'.webmode':$this->dataCss.'.webmode';
     if ($this->is_blog&&$this->blog_type==='image'){
          $css_id.=',.'.$css_id.' img';//style image as well if image_height_set
          }
     if ($this->is_blog&&$this->blog_type==='auto_slide'){
          $css_id.=',html .'.$css_id.' img';
          }
     $count=12;//number of @media position options
	for ($i=0; $i<3; $i++){
          $k=$i*$count;//
          if ($i>0){
               $this->show_more('Add additional @media query controlled option tweak for height options');
               $this->print_redwrap('additional media wrap #'.$i);
               }
     $this->show_more('em, rem, px with scale opt for  min-height, max-height, &amp; height choices'); 
	printer::print_wrap('more height');
     $max_name=$name.'['.(${'mediamax'.$i.'_index'}).']';
	$min_name=$name.'['.(${'mediamin'.$i.'_index'}).']';
	$mediamax=(is_numeric($blog_media_arr[${'mediamax'.$i.'_index'}])&&$blog_media_arr[${'mediamax'.$i.'_index'}]>=200&&$blog_media_arr[${'mediamax'.$i.'_index'}]<=3000)?$blog_media_arr[${'mediamax'.$i.'_index'}]:0;
     $mediamin=(is_numeric($blog_media_arr[${'mediamin'.$i.'_index'}])&&$blog_media_arr[${'mediamin'.$i.'_index'}]>=200&&$blog_media_arr[${'mediamin'.$i.'_index'}]<=3000)?$blog_media_arr[${'mediamin'.$i.'_index'}]:0;
     #here we making compatible for spacing function name="" input options..
	 if (!empty($mediamin)||!empty($mediamax)) 
          $fieldmin=$field=$fieldmax='return';
     else {
          $fieldmin='min-height';
          $fieldmax='max-height';
          $field='height';
          }
     $this->{$data.'_'.$type.'_options'}[$this->{$type.'_max_height_opt_index'}]=$this->{$type.'_options'}[$this->{$type.'_max_height_opt_index'}];//here we are setting up the use of for double duty as obj value and name as in styling functions
      
     $hmax=$this->height_max_special($data.'_'.$type.'_options',$this->{$type.'_max_height_opt_index'},$fieldmax,'.'.$css_id,$k);
	$this->{$data.'_'.$type.'_options'}[$this->{$type.'_height_opt_index'}]=$this->{$type.'_options'}[$this->{$type.'_height_opt_index'}];
	$h=$this->height_special($data.'_'.$type.'_options',$this->{$type.'_height_opt_index'},$field,'.'.$css_id,$k);
	$this->{$data.'_'.$type.'_options'}[$this->{$type.'_min_height_opt_index'}]=$this->{$type.'_options'}[$this->{$type.'_min_height_opt_index'}];  
	$hmin=$this->height_min_special($data.'_'.$type.'_options',$this->{$type.'_min_height_opt_index'},$fieldmin,'.'.$css_id,$k);
     $mediacss=$css='';
      $appendcss=($type==='blog'&&($this->blog_type==='image'||$this->blog_type==='auto_slide'))?' width:auto;max-width:none;':''; 
     if ((!empty($mediamin)||!empty($mediamax))&&(!empty($hmax)||!empty($hmin)||!empty($h))){ 
          $hmax=(!empty($hmax))?' max-height:'.$hmax.';':'';
          $hmin=(!empty($hmin))?' min-height:'.$hmin.';':'';
          $h=(!empty($h))?' height:'.$h.';':'';
          if (!empty($mediamin)&&!empty($mediamax)) {
              $mediacss.='
     @media screen and (max-width:'.$mediamax.'px) and (min-width:'.$mediamin.'px){
     html .'.$css_id.'{'.$hmax.$hmin.$h.$appendcss.'}
          }
          ';
               }
          elseif (!empty($mediamax)){
               $mediacss.='
     @media screen and (max-width: '.$mediamax.'px){
     html .'.$css_id.'{'.$hmax.$hmin.$h.$appendcss.'}
          }
          ';
               }
          elseif (!empty($mediamin)) {
               $mediacss.='
     @media screen and (min-width: '.$mediamin.'px){
     
     html .'.$css_id.'{'.$hmax.$hmin.$h.$appendcss.'}
          }
          ';
               }
          $this->mediacss.=$mediacss;
          }
     else if (!empty($hmax)||!empty($hmin)||!empty($h)){ //css expressed already expressed in ion style but lets append
         $this->css.=$mediacss='
     html .'.$css_id.'{'.$appendcss.'}
          ';
          $mediacss='
     html .'.$css_id.'{'.$hmax.$hmin.$h.$appendcss.'}
          ';
          }
	printer::close_print_wrap('more height');
     
     $this->show_more('Style info','','info italic smaller');
     printer::print_wrap1('techinfo');
     printer::print_info('Current setting Css: '.$mediacss);
     $msg='Direct height, max-height, or min-height applied to main div of '.$type.' with optional media queries';
     printer::print_info($msg);
     printer::close_print_wrap1('techinfo');
     $this->show_close('Tech info');
     
	 printer::print_info('Optionally choose a @media screen size min-width or max-width or both at which this '.$type.' will specify custom Height setting.');  
     echo '<div class="fsminfo"><!--wrap max width-->';
     printer::printx('<p class="smaller '.$this->column_lev_color.'">(0 = none) Chosen Height max-width: <span class="navybackground white">'.$mediamax.'</span><br></p>');   
     printer::alert('Choose @media screen max-width px');
     $this->mod_spacing($max_name,$mediamax,200,3000,1,'px','none');  
     printer::printx('<p ><input type="checkbox" name="'.$max_name.'" value="0">Remove max-width</p>');
     echo '</div><!--wrap max width-->';
     echo '<div class="fsminfo"><!--wrap min width-->';
     printer::printx('<p class="smaller '.$this->column_lev_color.'">Chosen min-width: <span class="navybackground white">'.$mediamin.'</span></p>');
      printer::alert('Choose @media screen min-width px'); 
     $this->mod_spacing($min_name,$mediamin,200,3000,1,'px','none');
     printer::printx('<p ><input type="checkbox" name="'.$min_name.'" value="0">Remove min-width</p>');
     echo '</div><!--wrap min width-->';	
     $this->show_close('em, rem, px with scale, min-height, max-height, &amp; height choices');
	
      if ($i>0){
               $this->submit_button( );
               printer::close_print_wrap('additional positon media wrap #'.$i);
               $this->show_close('Add additional @media query controlled option tweak for position options'); 
               } 
          }//end for
     }
     
function width_mode(){//uses blog altwidth value for nested columns also
     $type='blog';//
	if ($this->is_clone&&!$this->clone_local_style)return;
	$check0=$check1=$check2=$check3=$check4=$check5='';
	$checked=' checked="checked"';
	$data=$this->data; 
	$name='name="'.$data.'_blog_width_mode['.$this->blog_width_mode_index.']" ';
     switch ($this->blog_width_mode[$this->blog_width_mode_index]) {
          case  'off':
               $check0=$checked;
               break;
          case  'maxwidth':
               $check1=$checked;
               break;
          case 'compress_full_width':
               $check2=$checked;
               break; 
          case 'compress_to_percentage': 
               $check3=$checked;
               break;
          default:
          $this->blog_width_mode[$this->blog_width_mode_index]='maxwidth';
          $check1=$checked; 
          }//end switch
          $altype=($this->blog_type==='nested_column')?'nested column post':'post';
		$colmsg=($this->blog_type==='nested_column')?'<b>Note: Setting alternative width on a nested column directly affects the column sizing itself</b>':'';
		echo '<div class="fsminfo editbackground editfont '.$this->column_lev_color.'"><!--alt width wrapper1-->';
		
     $default_mode=Cfg::Default_width_mode; 
     $msg=($this->flex_enabled_twice)?'Max-Width option not available following flex box previous activation':'Using this main width response mode is a simple but effective means for responsive design  and also keeps track of width px sizes in nested column structures and other post types. Is sutiable  when using the RWD Grid break point Medthod or Flex Box is not necessary for more complicated layouts. It works in conjuction with the float left, right, or float center mode when two or more posts (including a nested column post) occupy a row in a column. The full size screen width value chosen above can then respond to smaller viewports according to the following 3 choices which have different behavior for how post sharing a row will behave</p>';
     printer::printx('<p class="tip">'.$msg);
          if(!$this->flex_enabled_twice)$msg='Recommended for a single post which occupies a whole Column Row or shared posts in row that you wish to maximized individual posts by breaking to new row (ie smaller viewports) instead of compressing to some degree first</b><br>Chosen Floated Posts will not compress beyond thier initial sizing as viewports becoming limiting and origin size will be maintained by breaking to new a row as space permits.(default mode).';
          else $msg=printer::print_warn('Previous Flex Box Activation renders this max-width option innaccurate due to width tracking off. Use another option ie. option mode 2 or 3 below or alt width units or flex basis for flex items',1); 
          echo '<p class="fsmcolor editbackground editfont editcolor">
     <input type="radio" '.$name.$check0.' value="off">0.<span class="orange"> Turn Off </span> Main Width Option. Use Alt width Units Instead: </span> 
     <br></p>';
    echo '<p class="fsmcolor editbackground editfont editcolor">
     <input type="radio" '.$name.$check1.' value="maxwidth">1. Choose max-width option:  '.$msg.'
     <br><input type="radio" '.$name.$check2.' value="compress_full_width">2. Choose percent option : All floated posts with this setting will continue compressing without minimum size<br>
     <div class="fsmcolor editbackground editfont editcolor"><!--wrap percentage choices to option3-->
     <br><input type="radio" '.$name.$check3.' value="compress_to_percentage">3. Choose alt rwd percentage option. Works similar to RWD grid system except is simpler to implement and works well when fewer break points are necessary. Each post acts independently and does not require parent column activation or matching break points with other posts however works best when media widths are syncronized with other posts that are in the same row so they respond at the same time. <b>Does not utilize width tracking. <br><br>
     ';
     printer::pclear(5);
     
    
     printer::print_info('Margins: Leave Blank to specify no margin declaration. 0 will specify margin left or right 0');
     $mediapercent=(is_numeric($this->blog_width_mode[$this->{'blog_percent_init_index'}])&&$this->blog_width_mode[$this->{'blog_percent_init_index'}]>0&&$this->{$type.'_width_mode'}[$this->{'blog_percent_init_index'}]<=100)?$this->{$type.'_width_mode'}[$this->{'blog_percent_init_index'}]:'';
     $marginleft=(is_numeric($this->blog_width_mode[$this->{'blog_marginleft_init_index'}])&&$this->{$type.'_width_mode'}[$this->{'blog_marginleft_init_index'}]>=0&&$this->{$type.'_width_mode'}[$this->{'blog_marginleft_init_index'}]<=100)?$this->{$type.'_width_mode'}[$this->{'blog_marginleft_init_index'}]:'';
     $marginright=(is_numeric($this->blog_width_mode[$this->{'blog_marginright_init_index'}])&&$this->{$type.'_width_mode'}[$this->{'blog_marginright_init_index'}]>=0&&$this->{$type.'_width_mode'}[$this->{'blog_marginright_init_index'}]<=100)?$this->{$type.'_width_mode'}[$this->{'blog_marginright_init_index'}]:'';
     $name2=$data.'_'.$type.'_width_mode['.$this->{'blog_percent_init_index'}.']';
     $name3=$data.'_'.$type.'_width_mode['.$this->{'blog_marginleft_init_index'}.']';
     $name4=$data.'_'.$type.'_width_mode['.$this->{'blog_marginright_init_index'}.']';
     printer::print_tip('Enter Initial width and margin settings for large view screens. Will override the main width value if set.'); 
     echo '<table class="rwdmedia">
     <tr><th>Set Initial % Width</th><th>% left-margin</th><th>% right-margin</th></tr>';
     echo '<tr><td><input name="'.$name2.'" type="text" value="'.$mediapercent.'" ></td><td><input name="'.$name3.'" type="text" value="'.$marginleft.'" ></td><td><input name="'.$name4.'" type="text" value="'.$marginright.'" ></td></tr>
     </table>';
      echo '<div class="fsmnavy"><!--wrap percentage alt rwd-->';
     printer::print_tip('Enter up to eight break point max-widths as between 250-3000 px (without the units) in any order and specify percentages width/margin-left/margin-right required between 0 and 100 included');
     echo '<table class="rwdmedia">
     <tr><th>Media max-width bp</th><th>% Width</th><th>% left-margin</th><th>% right-margin</th></tr>';
     for ($i=1; $i<9;$i++){ 
          $mediawidth=(is_numeric($this->blog_width_mode[$this->{'blog_media_'.$i.'_index'}])&&$this->{$type.'_width_mode'}[$this->{'blog_media_'.$i.'_index'}]>=250&&$this->{$type.'_width_mode'}[$this->{'blog_media_'.$i.'_index'}]<=3000)?$this->{$type.'_width_mode'}[$this->{'blog_media_'.$i.'_index'}]:'';
          $mediapercent=(is_numeric($this->blog_width_mode[$this->{'blog_percent_'.$i.'_index'}])&&$this->{$type.'_width_mode'}[$this->{'blog_percent_'.$i.'_index'}]>0&&$this->{$type.'_width_mode'}[$this->{'blog_percent_'.$i.'_index'}]<=100)?$this->{$type.'_width_mode'}[$this->{'blog_percent_'.$i.'_index'}]:'';
           $marginleft=(is_numeric($this->blog_width_mode[$this->{'blog_marginleft_'.$i.'_index'}])&&$this->{$type.'_width_mode'}[$this->{'blog_marginleft_'.$i.'_index'}]>=0&&$this->{$type.'_width_mode'}[$this->{'blog_marginleft_'.$i.'_index'}]<=100)?$this->{$type.'_width_mode'}[$this->{'blog_marginleft_'.$i.'_index'}]:'';
           $marginright=(is_numeric($this->blog_width_mode[$this->{'blog_marginright_'.$i.'_index'}])&&$this->{$type.'_width_mode'}[$this->{'blog_marginright_'.$i.'_index'}]>=0&&$this->{$type.'_width_mode'}[$this->{'blog_marginright_'.$i.'_index'}]<=100)?$this->{$type.'_width_mode'}[$this->{'blog_marginright_'.$i.'_index'}]:'';
          $name1=$data.'_'.$type.'_width_mode['.$this->{'blog_media_'.$i.'_index'}.']';
          $name2=$data.'_'.$type.'_width_mode['.$this->{'blog_percent_'.$i.'_index'}.']';
          $name3=$data.'_'.$type.'_width_mode['.$this->{'blog_marginleft_'.$i.'_index'}.']';
          $name4=$data.'_'.$type.'_width_mode['.$this->{'blog_marginright_'.$i.'_index'}.']';
          echo '<tr><td><input name="'.$name1.'" type="text" value="'.$mediawidth.'" ></td><td><input name="'.$name2.'" type="text" value="'.$mediapercent.'" ></td><td><input name="'.$name3.'" type="text" value="'.$marginleft.'" ></td><td><input name="'.$name4.'" type="text" value="'.$marginright.'" ></td></tr>';
          }
     
     echo '</table>';
     printer::print_tip('The total width, margin-left, margin-right % of all posts combined sharing row space at a given @media bp will need to be less than or equal to 100%');
    echo '</div><!--wrap percentage again-->
     </div><!--wrap percentage choices to option3-->';
     $this->submit_button();
     echo ' </div><!--alt width wrapper1-->';	
	}// end alt width response

function advanced_width_mode(){//uses blog altwidth value for nested columns also
     $type='blog';//
	if ($this->is_clone&&!$this->clone_local_style)return;
	$check1=$check2=$check3=$check4=$check5='';
	$checked=' checked="checked"';
	$data=$this->data; 
          $altype=($this->blog_type==='nested_column')?'nested column post':'post';
		$colmsg=($this->blog_type==='nested_column')?'<b>Note: Setting alternative width on a nested column directly affects the column sizing itself</b>':'';
		echo '<div class="fsminfo editbackground editfont '.$this->column_lev_color.'"><!--alt width wrapper1-->';
     printer::print_info('Margins: Leave Blank to specify no margin declaration. 0 will specify margin left or right 0');
    
      echo '<div class="fsmnavy"><!--wrap percentage alt rwd-->';
     printer::print_tip('Enter up to eight @media tweaks setting a max-width between 250-3000 px (without the units) in any order and optionally specify one or more width/margin-left/margin-right/paddding-left/paddding-right values with units.');
     printer::print_info('All @media widths will automatically be in px. Included width value followed by one of px,rem,em or % for tweak value @media width supplied');
     echo '<table class="rwdmedia">
     <tr><th>Media max-width bp</th><th>Width</th><th>left-margin</th><th> right-margin</th><th>left-padding</th><th> right-padding</th></tr>';
     for ($i=1; $i<9;$i++){
          //blog_adv_media_1,blog_adv_width_1,blog_adv_marginleft_1
          $mediawidth=(is_numeric($this->blog_adv_media[$this->{'blog_media_'.$i.'_index'}])&&$this->blog_adv_media[$this->{'blog_media_'.$i.'_index'}]>=250&&$this->blog_adv_media[$this->{'blog_media_'.$i.'_index'}]<=3000)?$this->blog_adv_media[$this->{'blog_media_'.$i.'_index'}]:'';
          $mediapercent=(is_numeric($this->blog_adv_media[$this->{'blog_percent_'.$i.'_index'}])&&$this->blog_adv_media[$this->{'blog_percent_'.$i.'_index'}]>0&&$this->blog_adv_media[$this->{'blog_percent_'.$i.'_index'}]<=100)?$this->blog_adv_media[$this->{'blog_percent_'.$i.'_index'}]:'';
           $marginleft=(is_numeric($this->blog_adv_media[$this->{'blog_marginleft_'.$i.'_index'}])&&$this->blog_adv_media[$this->{'blog_marginleft_'.$i.'_index'}]>=0&&$this->blog_adv_media[$this->{'blog_marginleft_'.$i.'_index'}]<=100)?$this->blog_adv_media[$this->{'blog_marginleft_'.$i.'_index'}]:'';
           $marginright=(is_numeric($this->blog_adv_media[$this->{'blog_marginright_'.$i.'_index'}])&&$this->blog_adv_media[$this->{'blog_marginright_'.$i.'_index'}]>=0&&$this->blog_adv_media[$this->{'blog_marginright_'.$i.'_index'}]<=100)?$this->blog_adv_media[$this->{'blog_marginright_'.$i.'_index'}]:'';
          $name1=$data.'_'.$type.'_width_mode['.$this->{'blog_media_'.$i.'_index'}.']';
          $name2=$data.'_'.$type.'_width_mode['.$this->{'blog_percent_'.$i.'_index'}.']';
          $name3=$data.'_'.$type.'_width_mode['.$this->{'blog_marginleft_'.$i.'_index'}.']';
          $name4=$data.'_'.$type.'_width_mode['.$this->{'blog_marginright_'.$i.'_index'}.']';
          echo '<tr><td><input name="'.$name1.'" type="text" value="'.$mediawidth.'" ></td><td><input name="'.$name2.'" type="text" value="'.$mediapercent.'" ></td><td><input name="'.$name3.'" type="text" value="'.$marginleft.'" ></td><td><input name="'.$name4.'" type="text" value="'.$marginright.'" ></td></tr>';
          }
     
     echo '</table>';
     printer::print_tip('The total width, margin-left, margin-right % of all posts combined sharing row space at a given @media bp will need to be less than or equal to 100%');
    echo '</div><!--wrap percentage again-->
     </div><!--wrap percentage choices to option3-->';
     $this->submit_button();
     echo ' </div><!--alt width wrapper1-->';	
	}// end alt width response
     
#rwdbuild  #rwdop  #grid
function rwd_scale($numbers,$name,$css,$style,$type,$unit='px',$index,$after_index,$tiny=false,$convert=1,$incs='auto'){
     $notice='';//return notice
     if ($this->is_page){//add to css specificty
          if (!strpos($css,'html'))$css='html '.$css;
          }
     else if ($this->is_column){
          if (!strpos($css,'html'))$css='html '.$css;
          elseif (!strpos($css,'body'))$css=str_replace('html','html body',$css);
          elseif ($this->column_level>0)$css='div '.$css;
          }
     else{
          if (!strpos($css,'html'))$css='html '.$css;
          elseif (!strpos($css,'body'))$css=str_replace('html','html body',$css);
          else $css='div '.$css;
          }
	if (!$this->edit)return;  
	$beforeindexes='';
	$afterindexes='';   
	for ($i=0; $i<$index; $i++) $beforeindexes.=',';
	for ($i=$index+1; $i<$index+$after_index; $i++) $afterindexes.=',';
	$indexes=$beforeindexes.'scale_val,'.$afterindexes.'bp1,bp2,mod_percent'; 
	$index_arr=explode(',',$indexes);
	$bp_arr=explode('@@',$numbers);
	for ($i=0; $i<count($index_arr);$i++){ 
		if (!array_key_exists($i,$bp_arr)){
			$bp_arr[$i]=0;
			}
		 }
	foreach($index_arr as $key =>$index){
		if (!empty($index)) {
			${$index.'_index'}=$key;  
			}
		}	
	$upper_width=4000;
	$mod_percent=(is_numeric($bp_arr[$mod_percent_index])&&$bp_arr[$mod_percent_index]<=400&&$bp_arr[$mod_percent_index]>=24)? $bp_arr[$mod_percent_index]:100;  
	$value=(is_numeric($bp_arr[$scale_val_index])&&is_numeric($convert))?$bp_arr[$scale_val_index]*$convert:'';  
	$sort_arr=array();
	$bp1 = ($bp_arr[$bp1_index]>=300 && $bp_arr[$bp1_index] <=$upper_width)?$bp_arr[$bp1_index]:0;
	$bp2 = ($bp_arr[$bp2_index]>=250 && $bp_arr[$bp2_index] <=$upper_width)?$bp_arr[$bp2_index]:0;
     if ($name==='return_val'){ 
          if(!empty($value)&&is_numeric($bp1)&&is_numeric($bp2)&&($bp1-$bp2)>=50){
               return "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;scale enabled <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;upper-vp: $bp1 <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;lower-vp: $bp2 <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;linear mod percent: $mod_percent";
               }
          return;
          }
	$fsize=($tiny)?'tiny':'small';
	$this->show_more('RWD Scale '.$type,'','highlight floatleft editfont '.$fsize.' editbackground buttoninfo','Choose bps to further RWD scale the size value you choose here'); 
	$this->print_wrap('break points');
	printer::print_tip('The above  size choice for this '.$type.' can change according to the user viewport width.  Choose the relevant upper and lower widths at which to scale down your chosing value.  Media queries will be generated to  linearly scale down the chosen px starting at the viewport width  you wish this '.$type.' to begin to smallerize  and finshing at a minimum vp width that you choose, ie 320px. Rwd scaling down will start for uppermax value through the  lower max setting  at which px is no longer resized. By default the scaling will be proportional to the difference in screen size, however you can <em>adjust the rate of change</em> using the third option below.'); 
	printer::print_tip('Note: A handy means of creating custom scaled em units is to scale the font-size px in the parent column or even a particlar post and em will scale accordingly!'); 
	printer::print_wrap('Choose scale break point');
	$upper_msg=($this->is_page)?'Page width in default page settings':'Primary Column Width';
	printer::alert('Choose Upper viewport break point Width to begin Scaling '.$type.' the upper limit is set by the '.$upper_msg);
	$this->mod_spacing($name.'['.$bp1_index.']',$bp1,300,$upper_width,1,'px','none'); 
	printer::alert('Choose lower viewport Point to end Scaling '.$type);
	$this->mod_spacing($name.'['.$bp2_index.']',$bp2,250,$upper_width,1,'px','none');
	 if ($mod_percent!==100){
               printer::print_notice('Linear Scaling @100% modified to: '.$mod_percent.'%');
              }
     $this->show_more('Modify default Linear Scaling','','smaller editcolor editfont editbackground');
	printer::print_wrap('linear modify');
	printer::alert('By default size change will scale one to one with changes in viewport size between the max and min viewport sizes you choose.  You can change this default behavior which occurs at a setting 100% to either speed up to 400% increase the rate of change (ie. 4x smaller) or decrease  down to 25% the rate of change to minimizing the final size change to get the exact rate change you need. <b>However Keep in mind much a smaller percentage of change makes bigger differences in the final unit value of the lower screen width setting for larger differences between upper and lower viewport sizes.</b> ');
     $msgjava='Choose percent adjust rate of change';
	$this->mod_spacing($name.'['.$mod_percent_index.']',$mod_percent,24,400,.1,'%','none',$msgjava);
     $this->submit_button();
	printer::close_print_wrap('linear modify');
	$this->show_close('Modify default One to One Scaling','','smaller editcolor editfont editbackground');
	printer::close_print_wrap('Choose scale break point');   
	printer::pclear(); 
     $this->submit_button();
	$this->close_print_wrap('break points'); 
	$this->show_close('Set RWD Breakpoints');
	if ($style==='none')  return; //ie. proper top bottom left right position not chosen
     $arr='';
	if (strpos($bp_arr[$scale_val_index],'x@x@x')!==false){
          $arr=explode('x@x@x',$bp_arr[$scale_val_index]); 
          } 
		##############
	
     if (!is_numeric($bp1)||!is_numeric($bp2)||($bp1-$bp2)<=50){
          //printer::print_warn('Insufficient Size Difference upper to lower width');
          return;
          }
     printer::print_notice('Activated Scaling on Px');
     $notice=true;
     if (!empty($value)){
          $this->scale_render($arr,$value,$mod_percent,$incs,$css,$style,$bp1,$bp2,$unit);
          return 'Scaled Px units Activated! Typically overrides other unit settings';
          }
     
	}//end rwd_scale
              
function scale_render($arr,$value,$mod_percent,$incs,$css,$style,$bp1,$bp2,$unit){
     //the $arr is for border,radius with 4 values not 1
     if (!is_numeric($bp1)||!is_numeric($bp2)||($bp1-$bp2)<=50)return;
     $diff=$bp1-$bp2;
     #right now incs used to adjust the factor and not used for the >100% mod_percent
     if ($incs==='auto')
          $incs=$diff/10;
     $incs=100;
     $adjust=($mod_percent-100)/$incs;
    $typecss=($this->is_page)?'pagecss':'mediacss';
     $factor=$mod_percent;
     $increment = $bp1/100; //increments will gradulal decrease  proportional to current @media width.
     $this->$typecss.='
@media screen and (min-width:'.($bp1+1).'px){'
     .$css.' {'.$style.':'.$value.$unit.';}
     }';
     $keytrack=0;
     $flag=true;
     for ($i=$bp1; $i >= $bp2; $i-=$increment){
          $j=($i-$increment);
          if ($mod_percent>100){ 
               $factor-=$adjust; 
              $ratio=($j/$bp1)*($factor/$mod_percent);#factor starts out at mod_percent then gradually decreases..
              } 
          else $ratio=  1 - ((($bp1-$j)*($mod_percent/100))/$bp1);      //@100 ratio is linear to width change
          $increment=$i/100;          //as $mod_percent grows the $ratio decreases faster so the size decrease speeds up..
          
          if (!is_array($arr)){
               $finalcss=$css.' {'.$style.':'.($ratio*$value).$unit.'}'; 
               
               }
          else {
               $finalcss=$css.' {'.$style.':';
               foreach($arr as $val){
                    $finalcss.=($ratio*$val).$unit.' ';
                    }
               $finalcss.=';}';
               }
          #here we are going to store inarray the value for all scaling px size units @ the primary column width for width reference which takes into acount all pading and margins.  Also will tablulate font-size scaling which is directly related to em units which are valid units for paddings and widths... this mirrors the check_data key_down_check function ...
          $minbp=$i-$increment;
          $minw=($minbp>$bp2)?' and (min-width:'.$minbp.'px)':''; 
          $this->$typecss.='
          @media screen and (max-width:'.$i.'px)'.$minw.'{
               '.$finalcss.' 
          }'; //i/bp1 =
          }
     if ($this->is_page)return;
     $id=($this->is_column)?'c'.$this->col_id:'b'.$this->blog_id;
     if ($flag&&$i>=$this->max_width_limit) 
          $keytrack=$ratio*$val; 
     elseif ($flag&&!empty($keytrack)){
          $flag=false;
          }
     elseif ($flag) {
          $flag=false;
          }
     }
#rwdbuild  #build     
function rwd_build($type,$data){
     $width_enabled=true;
     if ($this->flex_enabled_twice){
          printer::print_notice('RWD grid width calc. off following parent tree activation of flexbox');
          $width_enabled=false;//turn off width calculator
          }
	if ($this->is_blog&&$this->blog_type==='gallery'&&$this->blog_tiny_data2==='master_gall')printer::printx('<p class="tip"> Master Galleries are fully responsive and perfom best at 100% of available width for each break point. directly set a maximum availble width in the configuration</p>');
	if ($type==='col'&&$this->column_level <1) return;  
	$cid=($this->blog_type==='nested_column')?$this->column_id_array[$this->column_level-1]:$this->col_id;
     $bc_id=($this->is_column)?'col_'.$this->col_id:'blog_'.$this->blog_id;
   
    if($this->edit&&!$this->is_clone){
         if ($type==='col'){
              $new_colgc="{$this->current_grid_units}@@$this->page_br_points";///col_grid_clone used as reference for use of configured page  grid units and bps and serve as a reference for cloned posts that if not matching throws error 
              if ($new_colgc !== $this->col_grid_clone){
                   $q="update $this->master_col_table set col_grid_clone='$new_colgc' where col_id=$this->col_id";
                   $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
                   }
              }
         else {
              $new_bloggc="{$this->current_grid_units}@@$this->page_br_points";
              if ($new_bloggc !== $this->blog_grid_clone){
                   $q="update $this->master_post_table set blog_grid_clone='$new_bloggc' where blog_id=$this->blog_id";
         
                   $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
                   }
              }
         }
   
    if($this->is_clone&&!$this->clone_local_style){ //col_grid_clone used as reference for use of configured page  grid units and bps and serve as a reference for cloned posts that if not matching throws error
         $msg=''; 
         if (!empty($this->{$type.'_grid_clone'})){
               $c=explode('@@',$this->{$type.'_grid_clone'});
               if (count($c)>1){
                    $tarr=explode('@@',$this->{$type.'_grid_clone'});
                    if ($tarr[0]!=$this->current_grid_units){ 
                         $msg='Current Grid Units Mismatch & ';
                         }
                    if ($tarr[1]!=implode(',',$this->page_break_arr)){
                         $msg.='Page Break Point Mismatch';
                         }
                    if (!empty($msg)){
                         $msg.=NL.'RWD Mismatch of clone with this page setting for bps.  If   necessary you can choose the local style and cofig settings to reset! or match with the original parent settings: Grid Units: '.$tarr[0].' ; Page Grid Units: '.$tarr[1];
                         printer::alertx('<p class="neg supersmall floatleft">'.$msg.'</p>');
                        }
                   }
              }//count 2
         else{
              $msg="If Parent of Clone page setting for Break Points or Grid Units Differ From this page Current Break Points or Grid Settings enable clone local style and configure for proper width response";
              printer::alertx('<p class="neg whitebackground supersmall floatleft">'.$msg.'</p>');
              }
         }
     $bp_arr=$this->page_break_arr;
     rsort($bp_arr);//
     array_unshift($bp_arr,'max'.$bp_arr[0]); //insert @ beggining of array
     $gu=$this->current_grid_units;
     $countbp=count($bp_arr); 
     $current_calc=array();
      //new local version will be append class version
     $setup_arr=array('wid'=>$type.'_grid_width','left'=>$type.'_gridspace_left','right'=>$type.'_gridspace_right');
     if(!isset($this->grid_width_record[$cid]))
          $this->grid_width_record[$cid]=array();
     foreach($setup_arr as $prefix=>$field){ 
          if(!isset($this->{'column_total_gu_arr'}))$this->{'column_total_gu_arr'}=array();
          if(!array_key_exists($cid,$this->{'column_total_gu_arr'}))$this->{'column_total_gu_arr'}[$cid]=array();
          ${$field.'_arr'}=explode(',',$this->{$field});
          ${$prefix.'_grid_width'}=array();
          foreach ($bp_arr as $bp){
               ${$prefix.'_grid_width'}[$bp]=0;//set default
               }
          $x=0;
          foreach  (${$field.'_arr'} as $pgrid){//override default
               $pgrid_arr=explode('-',$pgrid);
               if (count($pgrid_arr)>4&&count($pgrid_arr)<7){
                    $bp=$pgrid_arr[2];
                    ${$prefix.'_grid_width'}[$bp]=$pgrid;//this is actual  previoulsy  chosen value and setting to wid lefet or right_grid_width value
                    }
               }//end foreach grid type array... 
          ${'select_'.$prefix.'_arr'}=array();
          ${$prefix.'_grid_unit'}=array();
          /*if ((!$this->is_clone||$this->clone_local_style)&&count(${$field.'_arr'})>$countbp){
              //class grid styles for columns and blogs are subbed out individually using the master updating mechanism..  Because of this if the number of break points decrease there will be too many classes and they are removed here!
              $newval=implode(',',array_slice(${$field.'_arr'},0,$countbp));
              $this->hidden_array[]='<input type="hidden" name="'.$data.'_'.$field.'" value="'.$newval.'">';//cut off xtra classes if bps for column less than previous
              } */
#rwd
         //here we pre-generating select choice array options for each bp and wid, left or right
         for ($i=0; $i<$countbp; $i++){
              $bp=$bp_arr[$i];
              $bp_class_specify=(substr($bp,0,3)==='max')?'':(($i<$countbp-1)?'-'.$bp_arr[$i+1]:'-'.$bp);  
              if(!array_key_exists($bp,$this->{'column_total_gu_arr'}[$cid]))$this->{'column_total_gu_arr'}[$cid][$bp]=0;
              if(!array_key_exists($bp,$current_calc))$current_calc[$bp]=0;
              ${'select_'.$prefix.'_arr'}[$bp]=array();
              $match=false;
              if($prefix==='wid'){
                   for ($ii=0; $ii<$gu+1; $ii++){
                         $ch=${'select_'.$prefix.'_arr'}[$bp][$ii]=$prefix.'-bp-'.$bp.$bp_class_specify.'-'.$ii.'-'.$gu;//creating full select arr for editor dropdown choice...
                         if ($ch===${$prefix.'_grid_width'}[$bp]){
                             // column_total_gu_arr is used as record for augmenting running tally on column_total_gu_array for this column wid units and breakpoint for displaying current row fill percentage 
                             $this->{'column_total_gu_arr'}[$cid][$bp]+=$ii;
                             // the selected grid unit is used to build the current class and populate in this case the wid_array  which is used to populate...$this->grid_width_record[$cid] for display
                             ${$prefix.'_grid_unit'}[$bp]=$ii;
                             //the prefix grid unit for breakpoints furthe go on to populated the grid class selected array used directly in css generation in global_master.class.php
                             //and of course in used for selected="selected"
                             $match=true;
                             $current_calc[$bp]+=$ii;
                             }
                        } 
                   }
              else{
                    for ($ii=0; $ii<$gu; $ii+=.5){//$prefix here refers to non wid type
                         $ii2=(strpos($ii,'.5')===false)?$ii:str_replace('.5','',$ii).'x5';
                         $ch=${'select_'.$prefix.'_arr'}[$bp][$ii2]=$prefix.'-bp-'.$bp.$bp_class_specify.'-'.$ii2.'-'.$gu;
                         if ($ch===${$prefix.'_grid_width'}[$bp]){
                              $this->{'column_total_gu_arr'}[$cid][$bp]+=$ii;
                              ${$prefix.'_grid_unit'}[$bp]=$ii;
                              $match=true;
                              $current_calc[$bp]+=$ii; 
                              }
                         }
                    ${'select_'.$prefix.'_arr'}[$bp][0]='';//do not write 0 gu classname to element...
                    if(empty(${$prefix.'_grid_width'}[$bp])){//for non widths
                         ${$prefix.'_grid_unit'}[$bp]=0;
                         $match=true;
                         }
                    elseif (${$prefix.'_grid_width'}[$bp]===$prefix.'-bp-'.$bp.$bp_class_specify.'-0-'.$gu)
                         $match=false;//it will be set to empty class instead.
                    }
               if (!$match){//fill default class values for rendering classes... ie. not immed plugin values
                    $default_calc=($prefix==='wid')?$gu:0;
                    ${$prefix.'_grid_width'}[$bp]=($prefix==='wid')?$prefix.'-bp-'.$bp.$bp_class_specify.'-'.$default_calc.'-'.$gu:'';
                    ${$prefix.'_grid_unit'}[$bp]=$default_calc;
                    $this->{'column_total_gu_arr'}[$cid][$bp]+=$default_calc;
                    $current_calc[$bp]+=$default_calc; //gu tracker...
                    //$this->hidden_array[]='<input type="hidden" name="'.$data.'_'.$field.'" value="'.$finalarr.'">';//
                    //$this->instruct[]=('ReHit A SUBMIT Button For THIS TO UPDATE rwd break points of this m '.$type.' id:'.$bc_id.' so that it updates to  match with new bp settings on this current page. Check for  appropriate bps settings.');
                    }
               $id=($this->blog_type==='nested_column')?'c'.$cid:'p'.$this->blog_id;	
               $this->{'grid_class_selected_'.$prefix.'_array'}=(isset($this->{'grid_class_selected_'.$prefix.'_array'}))?array_merge($this->{'grid_class_selected_'.$prefix.'_array'},array(${$prefix.'_grid_width'}[$bp])):array(${$prefix.'_grid_width'}[$bp]);
               }//end for  bp 
         }//foreach  field
#gridarray
    $bpcalc_arr=array(); 
    $bptotalcalc_arr=array();
    $msgcurr='';
    $msgtot='';
    for ($i=0; $i<count($bp_arr); $i++){
         $bp=$bp_arr[$i];
         if (!isset($bpcalc_arr))$bpcalc_arr=array();
         foreach($setup_arr as $prefix=>$field){  
              if (!isset(${$prefix.'_array'}))${$prefix.'_array'}=array(); 
              ${$prefix.'_array'}[substr($prefix,0,3).' @bp '.$bp]=${$prefix.'_grid_unit'}[$bp];
              }
         //prefix ie  wid left right 
         $bpcalc_arr['Cur Tot '.$bp]=$current_calc[$bp];
         $msgcurr.=$id.' @bp '.$bp.': '.$current_calc[$bp].'gu or '.(floor(($current_calc[$bp]/$gu)*10000)/100).'% of row<br>';
         $bptotalcalc_arr['Tot Tot '.$bp]=$this->{'column_total_gu_arr'}[$cid][$bp];
         $msgtot.='Tot Tot @bp '.$bp.': '.$this->{'column_total_gu_arr'}[$cid][$bp].'gu or '.(round($this->{'column_total_gu_arr'}[$cid][$bp]/$gu,4)).' full row(s)<br>';
         }
    $colpost=($type==='col')?'Column':'Posted Content';
    if((!$this->is_clone||$this->clone_local_style)){   
         printer::printx('<p class="fsm'.$this->column_lev_color.' '.$this->column_lev_color.' editbackground editfont">Posts and Columns within the Parent Column of this '.$colpost.' are enabled as a responsive Grid to share the total width of the column parent. Choose the relative width percentage display for this '.$colpost.'  for each break point which correspond to viewer device width values!.</p>');	
         $this->grid_width_record[$cid][]=array_merge(array('id:'=>$id),$wid_array,$right_array,$left_array,$bpcalc_arr,$bptotalcalc_arr);
         printer::printx('<p class="fsm'.$this->column_lev_color.' '.$this->column_lev_color.' editbackground editfont"><span class="bold center">'.$gu.'gu/row in use</span><br>'.$msgcurr.'</p>'); 
         $this->show_more('View Complete Grid Unit Use Table & Info','noback','italic editbackground editfont '.$this->column_lev_color.' underline','','600');
         printer::printx('<p class="fsm'.$this->column_lev_color.' '.$this->column_lev_color.' editbackground editfont"><span class="bold center">Tot# Rows Used For Posts Up to Current Post</span>in Col Id C'.$cid.'<br>'.$msgtot.'</p>');
         printer::printx('<p class="fsm'.$this->column_lev_color.' '.$this->column_lev_color.' editbackground editfont">Table below shows values in Grid Units. You are configured for '.$gu.'gu per row. Each row has values for a single Post up to the post your curently viewing for each break point class.<br><span class="info">"max"</span>  value refers to Device Screen Width greater than the largest break point.
<br>
<span class="info">"@bp"</span> or break point values target maximum screem width between its value and that greater than the next lowest value break point.<br> <span class="info">"wid"</span> refers to content width at the specified break point.<br><span class="info">"Rig"</span> or <span class="info">"Lef"</span> refer  to right or left (margin) spacing selected between posts; <br><span class="info">"Cur Tot"</span> refers to the total (wid+lef+rig) of each post at the particlar break point specified.<br> <span class="info">"Tot Tot"</span>  calculates the running total adding together all Cur Tot up to the current post.</p>');
         printer::horiz_print($this->grid_width_record[$cid],'','','','',false,false,'editcolor editbackground editfont smallest');
    $this->show_close('Show Grid Unit Use Table');
         }
    else {
         printer::print_tip('Note that RWD Grid Width Tracking is currently disabled following Activation of flex box, or other width units such em width, rem width, or  px scaled widths, also Alt Width with Min Width set in the parent column tree');
         }
    #rwdupdate  #gridupdate	#gridwid			  
     $grid_width='';//used for updating col_width and blog_width
     $column_level=($type==='col')?($this->column_level-1):$this->column_level;
     $this->grid_width_chosen_arr=array();
     $this->grid_post_percent_arr=array();
     $grid_width_arr=array();
     ### All the following pertains only to calculating physical px which does not in any way affect the normal column flow ....but provides information px and enables correct image rendering...
     // $this->column_bp_width_arr[$this->column_level]=array();
     foreach ($bp_arr as $bp){ 
          $grid_width.= (floor($wid_grid_unit[$bp]/$gu*10000)/100).',';//used for updating col_width and blog_width   
     if ($type==='col'){
          $maxlimit=(substr($bp,0,3)==='max')?$this->column_bp_width_arr[$this->column_level-1][$bp][1]:min($bp,$this->column_bp_width_arr[$this->column_level-1][$bp][1]);
          if($this->column_bp_width_arr[$this->column_level-1][$bp][1]>$bp) 
               $percentlimit=$wid_grid_unit[$bp]/$gu*$this->column_bp_width_arr[$this->column_level-1][$bp][0];
          else 
               $percentlimit=$wid_grid_unit[$bp]/$gu*$this->column_bp_width_arr[$this->column_level-1][$bp][0]*$wid_grid_unit[$bp]/$gu;
          $grid_temp=$this->column_bp_width_arr[$this->column_level][$bp][1]= $maxlimit* $wid_grid_unit[$bp]/$gu;//set new column_bp_width_arr for current by multipling parent value by current percent
          $this->column_bp_width_arr[$this->column_level][$bp][0]=$percentlimit;
          $this->grid_width_chosen_arr[$bp]=$grid_temp;//chosen width px
          $this->grid_width_available[$this->column_level][$bp]=$maxlimit;  
          }//end type = col
     else {  //post type
          $maxlimit=(substr($bp,0,3)==='max')?$this->column_bp_width_arr[$this->column_level][$bp][1]:min($bp,$this->column_bp_width_arr[$this->column_level][$bp][1]);
          $grid_temp= $this->grid_post_percent_arr[$bp]=$maxlimit*$wid_grid_unit[$bp]/$gu;//multiply parent value by current percent
          $this->grid_width_chosen_arr[$bp]=$grid_temp; //(substr($bp,0,3)==='max')?$this->max_width_limit*$grid_temp/100:$grid_temp*$maxlimit/100; 
          $this->grid_width_available[$this->column_level][$bp]=(substr($bp,0,3)==='max')?$this->column_net_width[0]*$this->column_total_net_width_percent[$this->column_level]/100:$this->column_total_net_width_percent[$this->column_level]*$maxlimit/100;
          $this->grid_width_available[$this->column_level][$bp]=$maxlimit;
          }//endelse post
     }//end foreach...
     # update the total bp array
     #Track and Update width according to max break point percentage value
     if ($this->edit&&!$this->is_clone&&isset($_POST['submitted'])){//this is more relaxed
          $grid_width=substr_replace($grid_width,'',-1);
          if($type==='col'){
               $new_col_width= floor($wid_grid_unit[$bp_arr[0]]/$gu*10000)/100;  
               if ($this->track_col_width!=$new_col_width){ 
                    $q="update $this->master_col_table set col_width='$new_col_width', col_update='".date("dMY-H-i-s")."',col_time='".time()."',token='".mt_rand(1,mt_getrandmax()). "' where col_id=$this->col_id";
                   $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
                    }
               }
          else{
               $new_blog_width=floor($wid_grid_unit[$bp_arr[0]]/$gu*10000)/100;
               if($this->blog_width!=$new_blog_width){
                    $q="update $this->master_post_table set blog_width='$new_blog_width', token='".mt_rand(1,mt_getrandmax()). "',blog_update='".date("dMY-H-i-s")."',blog_time='".time()."' where blog_id=$this->blog_id";//this is how we   keep current_net_width and current_net_width_percent current... with use of rwd...
                    $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
                    }
               }
          } 
     if($this->is_clone&&!$this->clone_local_style){
         return;
         }
    printer::printx('<p class="floatleft editbackground editfont left '.$this->column_lev_color.'">RWD Grid Set the % Width  of this '.$colpost.' Display For Device Width Conditions (break points)</p>');
    printer::pclear();
    $this->show_more('Style info','','info italic smaller');
     printer::print_wrap1('techinfo');
     printer::print_info('Current Grid Classes Applied to main div: '.$this->dataCss.':<br><br> Grid Width: '.$this->{$type.'_grid_width'}.'<br>
     Grid  margin left Spacing: '.$this->{$type.'_gridspace_left'}.'<br>Grid  margin right Spacing: '.$this->{$type.'_gridspace_right'});
      $msg='Class names are generated from  chosen grid percentage values and applied as supplemental class names to main div post type or  column. Corresponding css is generated only for each class name that is generated';
     printer::print_info($msg);
     printer::close_print_wrap1('techinfo');
     $this->show_close('Style info');
     printer::pclear();
    for ($i=0; $i<count($bp_arr); $i++){
          $bp=$bp_arr[$i];
          $curwid= ($width_enabled)?floor($this->grid_width_chosen_arr[$bp]):'';  
          $cur_wid_avail=($width_enabled)?floor($this->grid_width_available[$this->column_level][$bp]):'';
          $curleft=($width_enabled)?floor($left_grid_unit[$bp]/$gu*$cur_wid_avail):'';
          $curright=($width_enabled)?floor($right_grid_unit[$bp]/$gu*$cur_wid_avail):'';
          $px=($width_enabled)?'px':'';
          echo '<div class="fsminfo editcolor editbackground editfont" ><!--wrap bp line of choices-->';
           $msg=(substr($bp,0,3)==='max')?'View Screen Up to &amp; Over: '.$this->max_width_limit.'px':'Max Wid Screen:'.$bp.':';
          echo '<span class="bold">'.$msg."</span> total {$gu} gu/row<br>";
          echo '<p class="floatleft navybackground white .pl10"><!--Bp class choice-->     
          Width:
          <select class="editcolor editbackground editfont"  name="'.$data.'_'.$type.'_grid_width['.$i.']">        
          <option   value="'.$wid_grid_width[$bp].'" selected="selected">'.(floor($wid_grid_unit[$bp]/$gu*10000)/100).'% &nbsp;: &nbsp;'.$wid_grid_unit[$bp].' gu : '. $curwid.$px.'</option>';
          
          for ($num=0; $num<$gu+1; $num++){
               $swid=($width_enabled)?$cur_wid_avail*$num/$gu:'';
             echo '<option  value="'.$select_wid_arr[$bp][$num].'">'.(floor($num/$gu*10000)/100).'% &nbsp;: &nbsp;'.$num.' gu&nbsp;:&nbsp;'.$swid.$px.'</option>';
             }
          echo'	
          </select> </p><!--Bp class choice-->';
          printer::pclear(15);
                         #&&&&&&&&&&&&&&&&&&& Begin  Left  
         $msg2='Left Space:';
         echo '<p class=" smallest" title="Add Spacing To The Left of This Post For The Given Breakpoint . Useful for tweaking Post Width For Different Size Groupings. Space added is Outside of Borders and Background Features if used. Analogous to Margins"><!--Bp class choice-->     
         '.$msg2.'
         <select class="editcolor editbackground editfont"  name="'.$data.'_'.$type.'_gridspace_left['.$i.']">        
         <option   value="'.$left_grid_width[$bp].'" selected="selected">'.(floor($left_grid_unit[$bp]/$gu*10000)/100).'% :'.$left_grid_unit[$bp].'gu : '. $curleft.$px.'</option>';
         for ($num=0; $num<$gu; $num+=.5){
               $num2=(strpos($num,'.5')===false)?$num:str_replace('.5','',$num).'x5';
               $slef=($width_enabled)?$cur_wid_avail*$num/$gu:'';
               echo '<option  value="'.$select_left_arr[$bp][$num2].'">'.(floor($num/$gu*10000)/100).'% &nbsp;: &nbsp;'.$num.' gu/'.$gu.'gu :&nbsp;'.($slef).$px.'</option>';
               }
          echo'	
          </select> </p><!--Bp class choice-->';
          printer::pclear();
          #&&&&&&&&&&&&&&&&&&&		end left spacing
          #&&&&&&&&&&&&&&&&&&&  begin  Right 
         $msg2='Right Space:';
         echo '<p class=" smallest" title="Add Spacing To The Left or Right of This Post For The Given Breakpoint. Space added is Outside of Borders and Background Features if used. Will add to total gu use. See gu table for totals.  Analogous to Margins"><!--Bp class choice--><span class="info center">Add Left/Right Spacing (between posts)</span><br>      
         '.$msg2.'
         <select class="editcolor editbackground editfont"  name="'.$data.'_'.$type.'_gridspace_right['.$i.']">        
         <option   value="'.$right_grid_width[$bp].'" selected="selected">'.(floor($right_grid_unit[$bp]/$gu*10000)/100).'% &nbsp;: &nbsp;'.$right_grid_unit[$bp].' gu : '. $curright.$px.'</option>';
         for ($num=0; $num<$gu; $num+=.5){
               $num2=(strpos($num,'.5')===false)?$num:str_replace('.5','',$num).'x5';
               $srig=($width_enabled)?$cur_wid_avail*$num/$gu:'';
               echo '<option   value="'.$select_right_arr[$bp][$num2].'">'.(floor($num/$gu*10000)/100).'% &nbsp;: &nbsp;'.$num.' gu :&nbsp;'.($srig).$px.'</option>';
               }
          echo'	
          </select> </p><!--Bp class choice-->';
          #&&&&&&&&&&&&&&&&&&&&&&&  End Right
          printer::pclear();
          //echo '</div><!--Spacing Rwd Wrap-->';
          //$this->show_close('Add Spacing'); 
          echo '</div><!--wrap bp line of choices-->';
          $countbp--;
          }//for bp 
	#&&&&&&&&&&&&&&&&&&&&&&&&&&  END CLASS QUERY FOR  ACTIVE RWD POSTS  &&&&&&&&&&&&&&&&&&
	}//end ion rwd_build
#style#
#$style_field is the name of the sql field holding raw style data
#$this->style_field is the raw data itself
#css_classname which is the classname to which the styling applies
#element  provides uniqueness to the name input etc. and also the style array (that is for non body non bodyview elements) holding the the final style rendering and also is used is as special reference for providing information on a particlular style grouping ie bodyview...
#the show list is the particlar style functions to render in order they written. If show list is empty the default function order from Cfg::Style_functions_order is used
#   the function iteself retrieves the css functions  and depending on the key sort order provided or by using the default order, it determines from the relative key value of the function needed to pipe the relevant style array value to.  ie  func  background will receive the style array value from the index ['background'].. The background function and others are where the styling editing for each style takes place and a css rule  generated for the particular values sent. These final css rules   are stored as final_style class variables  named in the general format of the particular "element_style_field_arrayed" format. Reference to the name of returned css value is passed to render_array using the element and css class reference. It also passes the class name reference  The render array is called upon at the close of the page by the method css_generate. Css_generate serves the purpose of collecting the various individual css rules for a given css class name and compiling them in one css statement. To do this the render array is then passed through foreach. Each resulting array provides Reference to a class name   and reference to the style array the gives the collected css values ie;   background:#ffffff;  and color:#aaaaa; All css values for a give classname are collected and rule applied.   the css name may be further modified according to $css_ext if used 
	
function edit_styles_close($element,$style_field,$css_classname,$show_list='',$mod_msg="Edit styling",$show_option='',$msg='',$mainstyle=false,$clone_option=true){  
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
		$this->render_array[]=array($element,'final_'.$style,$css_classname);
		}
	elseif (!empty($style_field)){   
		$style=$element.'_'.$style_field.'_arrayed';#for blog array:::: this leaves the orginal $this->blog_style alone...
		$this->$style=$this->$style_field;#this is object to refer to actual current value in syle functions..
		#set both  as element will define    render_array for css_generate and style for style functions
		$this->render_array[]=array($element,'final_'.$style,$css_classname);//or css_generate all elements called will generate css..
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
		if(isset($this->render_view_css)&&is_array($this->render_view_css)&&count($this->render_view_css)>0){
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
               $this->display_style($type,$style_field,$id);	
			$this->show_more('Special Tag and Class Styles','','highlight tiny editbackground editfont floatleft','Style text through the use of tags and classes with Styles set in page options');
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
		printer::printx('<p class="fsminfo smaller editbackground editfont editcolor">Class Name: <span class="'.$this->column_lev_color.'">'.$class.'</span><br>'.$type_ref.' Style Field: <span class="'.$this->column_lev_color.'"> '.$style_field.'</span></p>');
		(!empty($msg))&&printer::print_tip($msg,.7);
          printer::pclear(10);
          printer::alert('<input type="checkbox" name="'.$ndata.'" value="0" onchange="edit_Proc.oncheck(\''.$ndata.'\',\'Delete all styles within this style grouping for '.$type.' when YOU HIT CHANGE, UNCHECK TO CANCEL\')">Delete all styles for this Style grouping');
          printer::pclear(10);
		if ($this->is_blog&&($this->blog_type==='text'||$this->blog_type==='float_image_right'||$this->blog_type==='float_image_left'||$this->blog_type==='image'||$this->blog_type==='video')){
			if (isset($_POST[$this->data.'_blog_global_style'])&&$_POST[$this->data.'_blog_global_style']==='global'){
				$q="update $this->master_post_table set blog_global_style='0' where blog_col='$this->col_id' and blog_id!='$this->blog_id' and blog_type='$this->blog_type'";  //remove anothe current global setting if exists
				$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); 
				}
			if (isset($_POST['delete_global_styles_'.$this->data.'_'.$style_field])&&$_POST['delete_global_styles_'.$this->data.'_'.$style_field]==='delete'){
				$q="update $this->master_post_table set $style_field='0' where blog_col='$this->col_id' and blog_id!='$this->blog_id' and blog_type='$this->blog_type'";   
				$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); 
				}
			 if ($this->blog_global_style!=='global'){
				$this->show_more('Globalize this style grouping');
				echo '<div class="fsminfo editbackground editfont editcolor"><!--globalize style wrap-->';
                    printer::printx('<p class="tip ">These styles made here will be applied to all '.$this->blog_type.' posts within this column.  Styles made in the individual posts will override these. Any Previous Globalized '.$this->blog_type.' styles will be removed.</p>');
				printer::printx('<p class="'.$this->column_lev_color.' editbackground editfont"><input type="checkbox" name="'.$this->data.'_blog_global_style" value="global">Globalize these Styles</p>');
				printer::printx('<p class="'.$this->column_lev_color.' editbackground editfont"><input type="checkbox" name="delete_global_styles_'.$this->data.'_'.$style_field.'" value="delete"  onchange="edit_Proc.oncheck(\'delete_global_styles_'.$this->data.'_'.$style_field.'\',\'SIMILAR STYLES OF SAME TYPE POSTS WITHIN PARENT COLUMN WILL BE DELETED WHEN YOU HIT CHANGE, UNCHECK TO CANCEL\')">Pre delete this style type in all other posts within this same column so now pre-existing posts of this  '.$this->blog_type.' will match exactly. </p>');
				echo '</div><!--globalize style wrap-->';
				$this->show_close('Globalize this '.$this->blog_type.' within Column');
				}// option not global
			else {
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
	$function_order[]='custom_style';//enable for all 
	$function_order[]='media_max_width';//enable for all 
	$function_order[]='media_min_width';//enable for all 
	foreach ($function_order as $index){  
		$i=$this->{$index.'_index'};
		(Sys::Deltatime)&&$this->deltatime->delta_log('Begin EditStyle function:    ele: '.$element.'  css:  '.$css_classname .' funct: '.$functions[$i]);
		$this->{$functions[$i]}($style,$i,$style_field);  #this calls the functions.... 
		(Sys::Deltatime)&&$this->deltatime->delta_log('End Function : '.$functions[$i]);
		printer::pclear();
		} 
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
               if ($style_field==='blog_style'||$style_field==='col_style'){
                    #add another main style field for media@ width rules
                    printer::print_tip("For @media control Optionally Add a second main @media width $style_field of grouped posts"); 
                    $this->edit_styles_close($element,$style_field.'2',$css_classname,$show_list,"@media$mod_msg",$show_option,$msg='Secondary for Re Styling @mediawidth ',$mainstyle,$clone_option);
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
	printer::alert('Current Clipboard styles: <br>');
	$this->display_style('page','page_clipboard',$this->page_id);
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
			}
		else {
			$msg='Array Error'; 
			mail::alert($msg);
			$this->message[]=$msg;
			}
	     if (!isset($this->$style)||!is_array($this->$style)||count($this->$style)<2){  
			$msg='improper array formation with element '.$element.Sys::error_info(__LINE__,__FILE__,__METHOD__);
			$message[]=$msg;
			(Sys::Loc)&&print NL.$msg;
			continue;
			}   
		$style_css=$css_classname; 
		$csstype=($element==='bodyview'||$element==='body')?'pagecss':'css';
	     //$this->{$csstype}.="\n".'  '.$style_css .'{';
	     $css="\n".'  '.$style_css .'{'; 
		$count=count(explode(',',Cfg::Style_functions)); 
		array_splice($this->$style, $count);//trim appendages..
          $maxwidth=$minwidth=0;
		foreach ($this->$style as $genstyle){
               if (is_array($genstyle)) {
                    if ($genstyle[0]==='mediamax')$maxwidth=$genstyle[1];
                    elseif($genstyle[0]==='mediamin')$minwidth=$genstyle[1];
                    continue;
                    }
			if (strpos($genstyle,'@@')!==false)continue;
			if (!empty(trim($genstyle))) {
				$css.=$genstyle.' ';   
				}
			} //end foreach  
		$css.='}
          ';
          if (!empty($maxwidth)&&!empty($minwidth)) {
		$mediaopen='
@media screen and (max-width:'.$maxwidth.'px) and (min-width:'.$minwidth.'px){
';
               $mediaclose='
     }';
               }
          elseif (!empty($maxwidth)){
               $mediaopen='
@media screen and (max-width: '.$maxwidth.'px){
';
               $mediaclose='
     }';
               }
          elseif (!empty($minwidth)) {
		$mediaopen='
@media screen and (min-width: '.$minwidth.'px){
';
               $mediaclose='
     }';
               }
          else {
               $mediaopen='';
               $mediaclose='';
               }
		$this->{$csstype}.=$mediaopen.$css.$mediaclose;
          $this->id_class=false;//set back to false: set true if you wish to use # instead of .
		$advanced= (array_key_exists($css_classname,$this->advancedstyles)&&!empty($this->advancedstyles[$css_classname]))?NL.$this->advancedstyles[$css_classname]:''; 
		($element==='bodyview')&&$this->css_view[]=$css. $advanced;//for previewing special tags and classes styling only
		(Sys::Deltatime)&&$this->deltatime->delta_log('After Insert '.__LINE__.' @ '.__method__.'  ');
		} //end foreach
	file_put_contents(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'css_data_sheet_'.$this->pagename.$this->passclass_ext,serialize($this->css_view));//for previewing special tags and classes styling only
	(Sys::Deltatime)&&$this->deltatime->delta_log('End of '.__LINE__.' @ '.__method__.'  ');
	}

function display_style($type,$field,$id){
	static $inc=0; $inc++;
	$show_msg='Display Styles';
	$this->show_more($show_msg,'','highlight editbackground editfont left floatleft smallest','Sent request for Styling Info breakdown of this current style');
	echo '<p class="highlight Os3darkslategray fsmyellow editbackground editfont click floatleft" title="View Chosen Styles" onclick="gen_Proc.use_ajax(\''.Sys::Self.'?display_styles='.$type.'@@'.$id.'@@'.$field.'&amp;display_id=display_styles_'.$inc.'\',\'handle_replace\',\'get\');" >Click to display Parsed Styles</p>';
	echo '<div id="display_styles_'.$inc.'"></div>'; 
	$this->show_close($show_msg);
	printer::pclear();
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
	$this->show_more('info','','info smaller');
	$this->print_wrap('primal');
	printer::alert('Post Css &amp; ID/CLASS: '.$this->dataCss);
	printer::alert('Parent Col Id: '.$this->col_id);
	printer::alert('Blog Order: '.$this->blog_order);
     printer::alert('Name: '.$this->data);
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
               $scale=($widthSetting==='&#x2713;')?'using max-width':(($widthSetting==='compress_full_width')?'using  % scale':'using % scale to a min-width');
               printer::print_info('Main Width Set '.$scale);
               }
          else {  
               $info=$this->check_spacing($this->blog_options[$this->blog_max_width_opt_index],'max-width');
               $info.=$this->check_spacing($this->blog_options[$this->blog_width_opt_index],'width');
               $info.=$this->check_spacing($this->blog_options[$this->blog_min_width_opt_index],'min-width');
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
	<tr><td>&nbsp; '.$altGridPercent.'</td><td>Main Width Percentage Compress to Min Width</td></tr>
	<tr><td>&nbsp; '.$scaleMode.'</td><td>Alt Width Units (em rem % px)</td></tr> 
	<tr><td>&nbsp; '.$enableMasonry.'</td><td>Masonry Assist Enabled<br></td></tr></table>';
	$this->close_print_wrap('primal'); 	
	$this->show_close('info','','info fs1info');
	echo '</div><!--end edit style open-->'; 
	printer::pclear(2);
	}
 
function misc($data){ return;  //outdated option
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
		echo '<p onclick="gen_Proc.showIt(\''.$data.'_show\');" class="click  smaller style_comment_view pos">Add Yours</p>';
		forms::form_open('','onsubmit="return gen_Proc.funcPass({funct:\'validateEntered\',pass:{idVal:\'comment_name_'.$this->blog_id.'\',ref:\'name\'}},{funct:\'validateEntered\',pass:{idVal:\'comment_text_'.$this->blog_id.'\',ref:\'comment textarea\'}});"');
		echo '<div id="'.$data.'_show" class="hide" style="background:white;color:#444; padding:5px; margin:4px; border: solid 3px #e9967a"><!--leave comment-->';
		printer::printx('<p class="tiny nopostemail">Email addresses will not be posted</p>
		<p class="floatleft smaller" style="background:white;color:red;">Your Name:&nbsp;&nbsp;</p>
		 <input  style="color:red;background:white;" type="text" name="comment_name['.$this->blog_id.']" id="comment_name_'.$this->blog_id.'"  maxlength="35" value=""> ');
		printer::pclear(7);
		printer::printx('
		<p class="floatleft smaller" style="background:white;color:red;">Your Email:&nbsp;&nbsp;</p>
		 <input style="color:red;background:white;" type="text" name="comment_email['.$this->blog_id.']" id="comment_email_'.$this->blog_id.'"  maxlength="35" value=""> ');
		printer::pclear(7);
		printer::printx('<p class="floatleft smaller" style="background:white;color:red;float:left; margin-left:2px;">'.$this->comment.':</p>'); 
		printer::pclear(7);
		printer::printx('<textarea   id="comment_text_'.$this->blog_id.'" class="width100 editbackground editfont fs1'.$this->column_lev_color.'" name="comment_text['.$this->blog_id.']" rows="3"    onkeyup="gen_Proc.autoGrowFieldScroll(this);"></textarea>');
		echo '</div><!--class hide-->';
		forms::form_close('','Add '.$this->comment,'feedback_submit');
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
	$max_name=($this->is_column)?$this->col_name.'_col_options['.$this->col_display_max_index.']':$this->data.'_blog_options['.$this->blog_display_max_index.']';
	$min_name=($this->is_column)?$this->col_name.'_col_options['.$this->col_display_min_index.']':$this->data.'_blog_options['.$this->blog_display_min_index.']';
	$type=($this->is_column)?'Column':'Post'; 
	$msg='Select a min-width or max-width or both at which to display:none this '.$type;
	$val_max=($this->is_column)?$this->col_options[$this->col_display_max_index]:$this->blog_options[$this->blog_display_max_index];
	$val_min=($this->is_column)?$this->col_options[$this->col_display_min_index]:$this->blog_options[$this->blog_display_min_index];
	$this->show_more('Display '.$type.' Off',$msg,'','','800');
	$this->print_redwrap('Display state');
	printer::print_tip('Optionally set a maximum and/or minimum with at which will initate a display:none for this post in webpage mode only. <br> Note: Display Property for RWD grid mode may be responsively Turned off using 0 grid units (ie %) for particular break pts.');
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
     $this->submit_button(); 
          printer::pclear();
     $this->close_print_wrap('Display state');
     $this->show_close('display state Off'); 
     printer::pclear();
     }//end display 
     

function preanimation(){ 
	$max_duration=10;
	$max_delay=20;
	$max_repeat=15;
	$max_height=100;
	$max_width=2000;
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
	$animate_type=(in_array($options[$this->animate_type_index],$animation_arr,true))?$options[$this->animate_type_index]:'none';   
	if ($animate_type==='none')return array('none','','','');
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
			$target='var obj_id=$("#'.$id_ref.'").prevAll("div:first").attr("id");
			 var target=document.getElementById(obj_id);';
			}
		elseif($animate_sibling==='next'){
			$target='var obj_id=$("#'.$id_ref.'").nextAll("div:first").attr("id");
			 var target=document.getElementById(obj_id);';
			}
		elseif($animate_sibling==='parent'){
			$target='var obj_id=$("#'.$id_ref.'").parent("div:first").attr("id");
			 var target=document.getElementById(obj_id);';
			}
		else {
			 $target='var target = document.getElementById("'.$active_element_follow.'")';
			}
		$animateJava='
		$(document).ready(function(){
		'
		.$target.' 
		var observer = new MutationObserver(function(mutations) { 
			mutations.forEach(function(mutation) { 
			if (mutation.attributeName==="data-status"&&target.getAttribute("data-status")==="finished"){
			     $("#'.$id_ref.'").addClass("active-anim");
                    '.$lock.'
                    '.$java.'
				observer.disconnect();
				}
			});
		}); 
	var config = { attributes: true }; 
	observer.observe(target, config);
      });
		';
     
     echo '<script>'
	    .$animateJava.'
	    </script>';
	    }//end if
	//here we set up followup animation!!
	elseif (($animate_after_type!=='none'||$animate_lock>0)&&$animate_repeats!=='infinite'){//secondary animation  present
		$animateJava='
		$(document).ready(function(){
			$("#'.$id_ref.'").one(animationStart,function(){';
			$lock_timing=$animate_after_duration*$animate_after_repeats;
			$java=($animate_lock>0)?'
				gen_Proc.animateLockReady(\''.$id_ref.'\',\''.$lock_timing.'\');':'';
			$afterJava=($animate_after_type!=='none')?'
				gen_Proc.animateFollow(\''.$id_ref.'\',\''.$animate_type.'\',\''.$animate_after_type.'\','.$inittotaldelay.','.($followupdelay).',\''.$animate_final_display.'\');':'';
		$closeJava='
			});
		});	
		';
	    echo '<script>'
	    .$animateJava.'
	    '.$java.'
	    '.$afterJava.'
	    '.$closeJava.'
	    </script>';
	    }//end if animate type
	elseif ($animate_repeats!=='infinite'){//no secondary animation
		$animateJava='
		$(document).ready(function(){
			$("#'.$id_ref.'").one(animationStart,function(){  
			gen_Proc.animateFinish(\''.$id_ref.'\','.($inittotaldelay).',\''.$animate_final_display.'\');
			});
		});	
		';
	    echo '<script>'
	    .$animateJava.'
	    </script>';  
	    }//end if
         
	return array($animate_type,$animate_height,$animate_lock,$aef); 
	}//end preanimation
 
function animation(){ 
	$max_duration=10;
	$max_delay=20;
	$max_repeat=15;
	$max_height=100;
	$max_width=2000;
	$min_width=200;
	$max_prior_delay=30;
	$default_animate_height=80;
	$max_animate_lock=4;
	$msg='Configure Animation type and Optionally change default settings here!';
	$col_level=($this->is_column)?$this->column_level:$this->column_level;
	$anim_data=($this->is_column)?$this->col_dataCss:$this->dataCss;
	$anim_name=($this->is_column)?$this->col_name.'_col_options['.$this->col_animation_index.']':$this->data.'_blog_options['.$this->blog_animation_index.']';
	$check_anim_name=($this->is_column)?$this->col_name.'_col_options':$this->data.'_blog_options';
	$check_anim_index=($this->is_column)?$this->col_animation_index:$this->blog_animation_index;
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
			$this->css.=$css.='
			@media screen and (min-width:'.$animate_width.'px){   
				'; $css.='<br>';
			}
		if ($animate_visibility ==='hidden'){
			$this->css.=$css.='
			.'.$id_ref.'{visibility:hidden;}
			.'.$id_ref.'.active-anim.in-view{visibility:visible;}
			'; 
			$this->editoverridecss.='
			html div#'.$id_ref.'{visibility:visible;}
			html div.'.$id_ref.' textarea{visibility:visible;} 
			';
			} 
		if ($animate_visibility ==='nodisplay'){
			$this->css.=$css.='
			.'.$id_ref.'{display:none;}
			.'.$id_ref.'.active-anim.in-view{display:'.$this->display_edit_data.';}
			';
			} 
			 
		$alternate_css=($animate_alternate)?
		'-webkit-animation-direction: alternate;
			animation-direction: alternate;':'';
		$animate_repeats=($animate_alternate)?$animate_repeats*2:$animate_repeats;	
		$this->css.=$css.='
		#'.$id_ref.'.'.$animate_type.'.in-view.active-anim{
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
               $this->css.=$css.='
		#'.$id_ref.'.'.$animate_after_type.'.in-view.active-anim {
		 -webkit-animation-name: '.$animate_after_type.';
		animation-name: '.$animate_after_type.';
		animation-duration: '.$animate_after_duration.'s;
		-webkit-animation-duration: '.$animate_after_duration.'s;
		-moz-animation-duration:'.$animate_after_duration.'s;
		animation-iteration-count: '.$animate_after_repeats.';
		-webkit-animation-iteration-count: '.$animate_after_repeats.';
		-moz-animation-iteration-count: '.$animate_after_repeats.';
		visibility:visible;
		}
		';
			}//endif animate_after_type
		if ($animate_final_display==='visibleoff'){
               $this->css.=$css.='
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
			$this->css.=$css.='
			}';//close bracket for @media css
			}
		}//if animate_type !==none
      $this->show_more('Style info','','info italic smaller');
     printer::print_wrap1('techinfo');
     printer::print_info('Current setting Css: '.$css);
     $msg='Curent Css shown here is specific for main div id '.$id_ref.'. The general animation css in the animate.css file is modified from the daneden git hub open source project. Aditionally javascript is used to help program timings of animations and is pieced together from various discussions found on stackoverflow.com, etc.';
     printer::print_info($msg);
     printer::close_print_wrap1('techinfo');
     $this->show_close('Style info');
	$this->show_more('Control Initial visibility');	
	$this->print_redwrap('anim visibility'); 
	$checked1=($animate_visibility==='hidden')? 'checked="checked"':'';
	$checked2=($animate_visibility==='nodisplay')?'checked="checked"':'';
	$checked3=($animate_visibility!=='hidden'&&$animate_visibility!=='nodisplay')?'checked="checked"':''; 
	printer::print_tip('By default '.$type.'s initial visibility is set to be visible prior to animatation start. In certain circumstances it may be advantageous to insure an initial visibility to hidden which hides visibilty but the original space remains until animation opacity css fadeIn is activated. You can also choose to display none which hides the element and removes its space until activated for animation<br>');
	printer::alert('<p class="editbackground editfont highlight" title="Set initial visibility to hidden to insure that the '.$type.' is hidden prior to scroll activation of animation;uses css (visibily:hidden) property"><input type="radio" '.$checked1.' name="'.$anim_name.'['.$this->animate_visibility_index.']" value="hidden">Insure Non visibility of Initial State<p>');
	printer::alertx('<p class="editbackground editfont highlight" title="Set '.$type.' initial visibility to visibile"><input type="radio"  name="'.$anim_name.'['.$this->animate_visibility_index.']" value="nodisplay" '.$checked2.'>Use No Display No space State<p>');
	printer::alertx('<p class="editbackground editfont highlight" title="Set '.$type.' initial visibility to visibile"><input type="radio"  name="'.$anim_name.'['.$this->animate_visibility_index.']" value="visible" '.$checked3.'>Use Normal Visible Display State<p>');	 
	printer::pclear(5); 
	printer::close_print_wrap('anim visibility');
	$this->show_close('Control Initial visibility');	
	##################################
	$this->show_more('Enable '.$type.' Initial Animation','','',' ','800');
	$this->print_redwrap('inital wrap animate ',true);
	$this->print_wrap('animate type','editbackground editfont Os3salmon fsmaqua');
	printer::print_tip('Choose an Initial Animation Type Here. See below to optionally choose a follow-up animation type');
	printer::alert('Select animation type here:');
	echo '
	<!--animate.css -http://daneden.me/animate-->
	<select class="editcolor editbackground editfont" name="'.$anim_name.'['.$this->animate_type_index.']">
		<option value="'.$animate_type.'" selected="selected">'.$animate_type.'</option>
		<option value="none">None</option>
          <option value="skewSubtle">skewSubtle</option>	
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
        </optgroup>
      </select>';
	 printer::close_print_wrap('animate type');
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
	printer::alertx('<p class="editbackground editfont editcolor" title="Set '.$type.' initial alternate to visibile"><input type="radio"  name="'.$anim_name.'['.$this->animate_alternate_index.']" value="0" '.$checked2.'>No Reversing<p>');	 	
	printer::pclear(5);
	printer::close_print_wrap('anim alternate');
     ####################################-animate_complete_id
	$this->print_wrap('anim complete_id','editbackground editfont Os3salmon fsmaqua');
	 /*if (isset($_POST[$check_anim_name][$check_anim_index][$this->animate_complete_id_index])){
		$table=($type==='Column')?$this->master_col_table:$this->master_post_table;
		$idn=($type==='Column')?'col_id':'blog_id';
		$bid=substr($animate_complete_id,1);
		$count=$this->mysqlinst->count_field($table,$idn,'',false,"where $idn=$bid");
		 if ($count < 1){
			$msg="Error as no id exists for $bid in $type record. Please Review you ID choice for ".$options[$this->animate_complete_id_index];
			$this->message[]=$msg;
			} 
		} old requirement*/
	printer::print_warn('When using id or sibling activation for  series of animations be sure to remove the in view activation option below choosing the none option for uniterrupted animation flow of each animation in the series.<br><input type="checkbox" value="none" name="'.$anim_name.'['.$this->animate_height_index.']">Turn off any in view requirement for this post');
     printer::print_tip('Delay this animation until another animation completes and this one is within the scrolling parameter you specified. Enter the id ie. p## for the animated post or c## for animated column that you wish to complete before this animation begins. Set to 0 remove this option');
	printer::alert('Enter the id of the animated post or column you wish to complete before this animation starts:<input type="text" value="'.$animate_complete_id.'" name="'.$anim_name.'['.$this->animate_complete_id_index.']">');
	printer::print_tip('Alternatively, you can check the options for using previous post or next post (previous sibling or next sibling) or the Parent Column option and this animation will initiate based on the animation you checked finishing.  These options will override the ID options. <br>Note that your chosen method must have an animation itself chosen afterwhich this particlar animation will commence');
	$checked1=($animate_sibling==='prev')? 'checked="checked"':'';
	$checked2=($animate_sibling==='next')? 'checked="checked"':'';
	$checked3=($animate_sibling==='parent')? 'checked="checked"':'';
	$checked4=($animate_sibling!=='prev'&&$animate_sibling!=='next'&&$animate_sibling!=='parent')?'checked="checked"':'';  
     printer::alert('<p class="editbackground editfont info" ><input type="radio" '.$checked1.' name="'.$anim_name.'['.$this->animate_sibling_index.']" value="prev">Use Previous Sibling Activation of this Animation<p>');
	printer::alert('<p class="editbackground editfont info" ><input type="radio" '.$checked2.' name="'.$anim_name.'['.$this->animate_sibling_index.']" value="next">Use Next Sibling Activation of this Animation<p>');
	printer::alert('<p class="editbackground editfont info" ><input type="radio" '.$checked3.' name="'.$anim_name.'['.$this->animate_sibling_index.']" value="parent">Use Parent Column (animation completing) for Activation of this Animation<p>');
	printer::alertx('<p class="editbackground editfont info"><input type="radio"  name="'.$anim_name.'['.$this->animate_sibling_index.']" value="inactive" '.$checked4.'>Turn Off Sibling/Parent Activation of this Animation<p>');	 	
	printer::close_print_wrap('anim complete_id'); 
     printer::pclear(5);	
	####################################-
	$this->print_wrap('anim height','editbackground editfont Os3salmon fsmaqua'); 
	printer::print_tip('Scrolling to the animation will trigger the start of the animation. Use none to turn off this feature.  However you can exactly set how far into the animation space the trigger will kick off (if a sibling,parent,or id triger is also chosen both triggers must be true).. Setting a value of 1% will enable the hight trigger just as the top of the animation element is scrolled to. Setting a value of none will set the height trigger immediately. Choosing a value of 100% for example sets the height trigger only when the scroll reaches the bottom of the element. The value is currently set to '.$animate_height.'%.'); 
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
		<option value="'.$animate_after_type.'" selected="selected">'.$animate_after_type.'</option>
		<option value="none">None</option>
          <option value="skewSubtle">skewSubtle</option>
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

      </select>';
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
	printer::alert('<p class="editbackground editfont info" ><input type="radio" '.$checked2.' name="'.$anim_name.'['.$this->animate_final_display_index.']" value="visibleoff">Set Visibilty None-Space Occupied After animation(s) complete.<p>');
	printer::alertx('<p class="editbackground editfont info" ><input type="radio"  name="'.$anim_name.'['.$this->animate_final_display_index.']" value="visible" '.$checked3.'>Display No Change<p>');	 	 
	printer::close_print_wrap('anim final_display');
	printer::pclear(5);
	$this->show_close('Final Visibility');
	printer::close_print_wrap('wrap  _animations');
	$this->show_close('animations'); 
	}//end func animation
	
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
	$this->show_more('Import/Export Styles &amp; Configurations Option');
	$this->print_redwrap('import/export',true);
     $this->submit_button();
	echo '<div class="'.$this->column_lev_color.' fsminfo  editbackground editfont left "><!--import-->Import to this post only all styles and certain configuration from another '.$this->blog_type.' post from any page. <b>Will Not change configurations for main width, Rwd Grid settings, height, and alternative RWD settings, unless you check the additional box below  to import these also,  or these can be changed separately below. Will not change basic data such as Image Names and caption data, feedback, text, etc.</b> Post types must match.';
	printer::printx( '<p class="editcolor editbackground editfont" title="Be Sure to Use the Post Id Which Begins with a P ie P42.  Do Not Use the  Post# which simply refer to the Post Display Order Within the Column. Post Ids and #s are displayed at the top of each post"><input class="editcolor editbackground editfont" name="post_configcopy['.$this->blog_id.']" size="8" maxlength="8" type="text">Enter the  <span class="info">Post Id</span> <span class="red">(Not Post#) </span>that you wish to Copy Configurations and Styles to this post</p>');
	printer::printx( '<p class="editcolor editbackground editfont"><input class="editcolor editbackground editfont" name="post_allconfigcopy['.$this->blog_id.']"   type="checkbox" value="'.$this->blog_id.'">Copy Include <b> All Width and RWD Configs</b> to this post also.</p>');
	echo '</div>'; 
	echo '<div class="'.$this->column_lev_color.' fsminfo  editbackground editfont left "><!--export-->Export styles and configuration (<b>Will Not change configurations for width,Rwd Grid settings, or float settings, or click the additional option just below to includes these also. Alternatively, these can be changed separately below.  Will not change basic data such as Image Names and caption data, feedback, text, etc.</b>) from this '.$this->blog_type.' post to any other '.$this->blog_type.' post that is directly within this Column Post types must match.';
	printer::printx( '<p class="editcolor editbackground editfont" 	><input class="editcolor editbackground editfont" name="post_configexport['.$this->blog_id.']"   type="checkbox" value="'.$this->blog_id.'">Export these Styles and Configs to '.$this->blog_type.' posts within this column</p>');
	printer::printx( '<p class="editcolor editbackground editfont" 	><input class="editcolor editbackground editfont" name="post_allconfigexport['.$this->blog_id.']"   type="checkbox" value="'.$this->blog_id.'">Also Include Exporting <b> Main Width, RWD Configs, and Float Settings</b> to '.$this->blog_type.' posts within this parent column</p>');
	echo '</div><!--export-->';
	//$this->show_more('Or choose individual Configuration to Export/Import');
     $this->print_redwrap('individual port options'); 
     printer::print_tip('Styles may exported/imported by using that option located at the bottom of every grouping of particular style options. Here we import/export other configuration options on indiviudal basis.');
	echo '<div class="'.$this->column_lev_color.' fsminfo  editbackground editfont left "><!--import-->Import RWD Grid percentage selections to this post from another post from any page that has the same Grid Break Points set in the page options. Field: <span class="info" title="blog_gridspace_right, blog_gridspace_left, blog_grid_width">Info</span>';
	printer::printx( '<p class="editcolor editbackground editfont" title="Be Sure to Use the Post Id Which Begins with a P ie P42.  Do Not Use the  Post# which simply refer to the Post Display Order Within the Column. Post Ids and #s are displayed at the top of each post"><input class="editcolor editbackground editfont" name="post_rwdcopy['.$this->blog_id.']" size="8" maxlength="8" type="text">Enter the  <span class="info">Post Id</span> <span class="red">(Not Post#) </span>that you wish to copy Post RWD grid break point percentages</p>');
	printer::printx( '<p class="editcolor editbackground editfont" 	><input class="editcolor editbackground editfont" name="post_allconfigcopy['.$this->blog_id.']"   type="checkbox" value="'.$this->blog_id.'">Also Include Importing <b> All  Width, Float &amp; RWD Configs</b> to this post</p>'); 
	echo '</div>'; 
	echo '<div class="'.$this->column_lev_color.' fsminfo  editbackground editfont left "><!--export-->Export RWD Grid percentage settings and width mode choice from this  post to any other non nested column post that is directly within this Column.';
	printer::printx( '<p class="editcolor editbackground editfont" ><input class="editcolor editbackground editfont" name="post_rwdexport['.$this->blog_id.']"  type="checkbox" value="'.$this->blog_id.'">Export this Posts RWD Grid settings to other posts within this column</p>');
	printer::printx( '<p class="editcolor editbackground editfont" ><input class="editcolor editbackground editfont" name="post_col_rwdexport['.$this->blog_id.']"  type="checkbox" value="'.$this->blog_id.'">Also include RWD Grid export to Nested Columns directly in same parent </p>');
	echo '</div><!--export-->';
	#######################################################
	echo '<div class="'.$this->column_lev_color.' fsminfo  editbackground editfont left "><!--export-->Export the Alt RWD Percentage and width mode settings from this nested column to nested columns that are directly within this same parent Column. Field: blog_width_mode';
	printer::printx( '<p class="editcolor editbackground editfont" ><input class="editcolor editbackground editfont" name="post_widthmodeexport['.$this->blog_id.']"  type="checkbox" value="'.$this->blog_id.'">Export the Alt RWD Percentage setting of this column to all posts directly in this parent column</p>');
	
	printer::printx( '<p class="editcolor editbackground editfont" ><input class="editcolor editbackground editfont" name="post_col_widthmodeexport['.$this->blog_id.']"  type="checkbox" value="'.$this->blog_id.'">Also include Alt RWD Percentage settings export to Nested Columns directly in same parent </p>');
	echo '</div><!--export-->';
	######################################################
	echo '<div class="'.$this->column_lev_color.' fsminfo  editbackground editfont left "><!--export-->Export the Main Width value (affects posts in non-rwd grid mode) from this post to posts that are directly within this Column. Field: blog_width';
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
     ##########
	printer::print_wrap('blog option Port');
     printer::print_tip('Additional individual field choices to import or export from field blog_options');
	$this->blog_option_choices('import');
	$this->blog_option_choices('export');
      $this->submit_button();
	printer::close_print_wrap('blog option Port');
    // $this->show_close('Or choose individual Configuration to Export/Import');
     printer::close_print_wrap('individual port options');
     ########## 
	$this->show_more('Inter-Database Export/Import Configs/Settings');
	$dir= (is_dir(Sys::Common_dir))?Sys::Common_dir:Sys::Home_pub;
	$dir=rtrim($dir,'/').'/';
	$this->print_redwrap('interdatabase');
	printer::print_tip('If you are running multiple datbases you can export/import all configs/Styles of this post to/from another database.  First Choose export dump data from donor post. Data will dump from database to file. Navigate to new webpage and post you wish to import data, and it will automatically import the file and update that database. File will dump to the common_dir if it exists otherwise the home directory.  Currently to import the file or export data the system will use/look-for the file: <span class="red">'.$dir.'lastpostdump.dat</span>'); 
				    
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
     $convert= ($size>0&&$unit2 !== '' && $factor !=='1') ?'  &nbsp;'.(round($size*$factor,2)).$unit2:'';  
     printer::print_tip2($msg.' <b>Currently: '.$size.$showunit.$convert.'</b> &nbsp;&nbsp;&nbsp; Use 0 to Remove'.$ornone ,.7);
     $none=($none==='none')?' <input id="slider-checkbox_'.$inc.'" type="checkbox"  '.$checked.'  name="'.$name.'"  value="none"> Choose None':'';
	echo '
     <div id="toggle_'.$inc.'" class="clear editbackground editfont editcolor"  style="display:none;"><!--toggle hide mod_spacing-->';
	echo '<p style="height:5px">';for ($i=0; $i<60;  $i++)echo '&nbsp; &nbsp;'; echo '</p><!--mod spacer -->';//fillspacing avail for larger slider
     echo '
	<div class="clear editfont tip2"> <!--mod_spacing choose-->
    Choose:  
 <input style="visibility:hidden;" data-max="'.$range2.'" data-min=".'.$range1.'" id="slider-input_'.$inc.'" type="text" value="'.$size.'" name="'.$name.'">
 <div id="slider-update_'.$inc.'"  ></div>
<p class="pt10"><span id="slider-update-value_'.$inc.'"></span>'.$none.'</p>
<p class="pt5"></p></div><!--mod_spacing choose-->
</div><!--toggle hide mod_spacing-->';
     echo <<<eol
<p id="button-create-slide_$inc" class="clear tip2 cursor radius5 fsmgrey floatleft grey" onclick="gen_Proc.toggleIt('toggle_$inc');setTimeout(function(){initnoUiSlider($inc,$range1,$range2,'$init',$increment,'$unit',$factor,'$unit2')},100);">Initiate Slider</p>
<p id="button-refine-slide_$inc" class="cursor tip2 fsmgrey floatleft grey hide" onclick="updateSliderRange($inc);document.getElementById('button-reinit-slide_$inc').classList.remove('hide');">Refine Slider Choice</p> 
<p id="button-reinit-slide_$inc" class="cursor tip2 fsmgrey floatleft grey hide" onclick="initnoUiSlider($inc,$range1,$range2,'$size',$increment,'$unit',$factor,'$unit2',true);"><b>Full Range</b></p>
eol;
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
      \$(function() {
            // document.getElementById('autosubmit').submit();
     });
     </script>
     </form><!--autosubmit-->
eol;
          }
	}
     
function editor_appearance(){
     echo '<div class="inline floatleft"><!-- float buttons-->';
     $this->show_more('Edit Mode Style','asis',$this->column_lev_color.' smallest  editbackground editfont button'.$this->column_lev_color);
	$this->print_wrap('editor appearance');
	$this->show_more('Configure Editor Colors','noback');
	$this->print_redwrap('Editor colorWrap',true);
	if($this->page_options[$this->page_editor_choice_index]==='dark'){
		$checked1='';
		$checked2='checked="checked"';
		$page_color_value_property='page_dark_editor_value';
		$editorref='Dark'; 
		}
	else {
		$checked2='';
		$checked1='checked="checked"';
		$page_color_value_property='page_light_editor_value';
		$editorref='Light';
		}
	printer::alertx('<p class="smaller  editcolor left editbackground editfont" style="padding: 4px 4px 4px 5px; border-width: 3px 0px 3px 0px;  border-style:solid; border-color: #'. $this->page_options[$this->page_darkeditor_color_index].';cursor:pointer;background:#'.$this->page_options[$this->page_darkeditor_background_index].';color:#'.$this->page_options[$this->page_darkeditor_color_index].';">  #<input onclick="jscolor.installByClassName(\'darkeditorbackcolor\');" style="cursor:pointer;background:#'.$this->page_options[$this->page_darkeditor_background_index].';color:#'.$this->page_options[$this->page_darkeditor_color_index].';" type="text"  name="page_options['.$this->page_darkeditor_background_index.']"   value="'.$this->page_options[$this->page_darkeditor_background_index].'" size="6" maxlength="6" class="darkeditorbackcolor {refine:false}">Change  Background Color of Dark Theme Editor</p>');
	printer::pclear(3);
	printer::alertx('<p class="fs1'.$this->page_options[$this->page_darkeditor_color_index].' smaller  editcolor left editbackground editfont" style="padding: 4px 4px 4px 5px; border-width: 3px 0px 3px 0px;  border-style:solid; border-color: #'. $this->page_options[$this->page_darkeditor_color_index].'; cursor:pointer;background:#'.$this->page_options[$this->page_darkeditor_background_index].';color:#'.$this->page_options[$this->page_darkeditor_color_index].';">  #<input onclick="jscolor.installByClassName(\'darkeditorcolor\');" style="cursor:pointer;background:#'.$this->page_options[$this->page_darkeditor_background_index].';color:#'.$this->page_options[$this->page_darkeditor_color_index].';" type="text"  name="page_options['.$this->page_darkeditor_color_index.']"   value="'.$this->page_options[$this->page_darkeditor_color_index].'" size="6" maxlength="6" class="darkeditorcolor {refine:false}">Change Editor Misc. Text Colors of Dark Theme </p>');
	
	printer::pclear(3);
	printer::alertx('<p class=" smaller  editcolor left editfont" style="padding: 4px 4px 4px 5px; border-width: 3px 0px 3px 0px;  border-style:solid; border-color: #'. $this->page_options[$this->page_lighteditor_color_index].';cursor:pointer;background:#'.$this->page_options[$this->page_lighteditor_background_index].';color:#'.$this->page_options[$this->page_lighteditor_color_index].';"> #<input onclick="jscolor.installByClassName(\'lighteditorbackcolor\');" style="cursor:pointer;background:#'.$this->page_options[$this->page_lighteditor_background_index].';color:#'.$this->page_options[$this->page_lighteditor_color_index].';" type="text"  name="page_options['.$this->page_lighteditor_background_index.']"   value="'.$this->page_options[$this->page_lighteditor_background_index].'" size="6" maxlength="6" class="lighteditorbackcolor {refine:false}">Change Background Color of Editor Light Theme </p>');
	printer::pclear(3);
	printer::alertx('<p class="smaller  left editfont" style="padding: 4px 4px 4px 5px; border-width: 3px 0px 3px 0px;  border-style:solid; border-color: #'. $this->page_options[$this->page_lighteditor_color_index].';cursor:pointer;background:#'.$this->page_options[$this->page_lighteditor_background_index].';color:#'.$this->page_options[$this->page_lighteditor_color_index].';">#<input onclick="jscolor.installByClassName(\'lighteditorcolor\');" style="cursor:pointer;background:#'.$this->page_options[$this->page_lighteditor_background_index].';color:#'.$this->page_options[$this->page_lighteditor_color_index].';" type="text"  name="page_options['.$this->page_lighteditor_color_index.'];"   value="'.$this->page_options[$this->page_lighteditor_color_index].'" size="6" maxlength="6" class="lighteditorcolor {refine:false}">Change Misc. Colors of Light Theme Editor</p>');
	printer::pclear(3);
	printer::alert('Choose Light or Dark Editor / Change the Default Editor Light/Dark Editor Colors. Text Color and Background Color Should Contrast One Another For Readability');
	printer::alert('<input type="radio" name="page_options['.$this->page_editor_choice_index.']" '.$checked1.' value="light">Use Light Editor');
	printer::alert('<input type="radio" name="page_options['.$this->page_editor_choice_index.']" '.$checked2.' value="dark">Use Dark Editor');
	$this->show_more('Test View '.$editorref,'noback');
	$this->print_wrap('test color view');
	$x=1;
	printer::printx('<p class="smaller floatleft editbackground editfont fs1info" style="margin:1px;width:110px; height:100px;color:#'.$this->info.'">Info color is the Information Text Color</p><p class="smaller floatleft editbackground editfont fs1redAlert" style="margin:1px;width:110px; height:100px;color:#'.$this->redAlert.'">redAlert is an Alert Text Message Color </p><p class="smallest floatleft editbackground editfont fs1pos" style="margin:1px;width:110px; height:100px;color:#'.$this->pos.'">Pos acts as a Positive Alert Color and Used to indicate Primary Column text and Borders</p>');
	printer::pclear(5);
	printer::printx('<p class="fsminfo editbackground editfont">Note: Column Colors Are Useful To Indicate the Grouping of Posts within a Parent Column so Colors Change as the level of Nested Columns Changes. The lower level # Colors Generally Go unused whereas #1 #2 #3 and #4 are most extensively used.  Change the color level order for your chosen editor color theme in this section</p>');
	printer::pclear(5); 
	foreach ($this->color_order_arr as $color){
		echo '<p class="smaller floatleft editbackground editfont fs1'.$color.'" style="margin:1px; width:100px; height:100px;color:#'.$this->$color.'">This Color is '.$color.' @ Col Level: #'.$x.'</p>';
		$x++;
		}
	$this->close_print_wrap('test color view');	
	$this->show_close('Test View '.$editorref.' Editor Text Colors');
	$this->show_more('Rearange '.$editorref.' Column Colors','noback');
	$this->print_wrap('rearrange color view');
	printer::printx('<p class="fsminfo editbackground editfont editcolor">Basically each successive layer of columns gets its own main text color and border color in the editor as a way to distinguish to which column a new post is being added, etc.');
	printer::printx('<p class="fsminfo editbackground editfont editcolor">Rearrange Colors that go with your theme towards the top of the color list which most often gets used.');
	print'<p class="'.$this->column_lev_color.' large fsminfo floatleft left editbackground editfont">Drag color box to sort the color order. </p>';
		printer::pclear();
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
	$this->show_more('Color adjust '.$editorref.' Column Colors','noback');
	$this->print_wrap('adjust color view');
	printer::printx('<p>Basically each successive layer of columns gets its own main text color and border color in the editor as a way to distinguish to which column a new post is being added, etc.');
	printer::printx('<p class="fsminfo editbackground editfont editcolor">If any of your colors do not contrast with your editor background then  adjust the color here or rearrange their column order to suit your style');
	foreach ($this->color_order_arr as $color){
		printer::alertx('<p class="smaller '.$color.' left editbackground editfont"> Color Adjust: #<input onclick="jscolor.installByClassName(\'color_array_'.$this->{$color.'_index'}.'\');" style="cursor:pointer;background:#'.$this->editor_background.';color:#'.$this->editor_color.';" type="text" id="color_array_'.$this->{$color.'_index'}.'" name="'.$page_color_value_property.'['.$this->{$color.'_index'}.']"   value="'.$this->$color.'" size="6" maxlength="6" class="color_array_'.$this->{$color.'_index'}.' {refine:false}">'.$color.'</p>'); 
		} 
	$this->close_print_wrap('adjust color view');
   $this->show_close('Color adjust '.$editorref.' Column Colors');
	$this->show_more('Reset Colors');
	printer::print_wrap('color reset');
	printer::print_tip('If you add new color choices or change the default color order in the configurations, the color matching may be out of sync. Check here to reset colors. Note the color order will return to default Order and colors will be in sync');
	printer::printx('<p class="editbackground editcolor small"><input type="radio" value="reset" name="force_color_reset">Reset Colors on this Page Only</p>');
	printer::printx('<p class="editbackground editcolor small"><input type="radio" value="reset_all" name="force_color_reset">Reset Colors on all the Pages in this Website</p>');
	printer::close_print_wrap('color reset');
	$this->show_close('Reset Colors');
	$this->close_print_wrap('Editor colorWrap');
     $this->show_close('Configure Editor Colors');
     printer::pclear();
     $this->show_more('Configure Editor Font Family','noback','','Choose the font style of the Editor Only');
     $this->print_wrap('editor font family');
	printer::printx('<p>Change the Default editor font family style</p>');
	$this->font_family('page_options',$this->page_editor_fontfamily_index,'',true);
	$this->edit_font_family=(!empty($this->page_options[$this->page_editor_fontfamily_index])&&strpos($this->page_options[$this->page_editor_fontfamily_index],'=>')!==false)? str_replace('=>',',',$this->page_options[$this->page_editor_fontfamily_index]):  str_replace('=>',',',$this->edit_font_family);
	$this->edit_font_family=str_replace(';','!important;',$this->edit_font_family);  
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
	$this->show_close('Configure Editor Font');$this->show_more('Configure Editor Font Size','noback','','Choose the font size style of the Editor Only');
	$this->print_wrap('editor font size');
	printer::printx('<p>Change the Default editor font size</p>');
     $this->pelement=' .editfont';
	$this->font_size('page_options',$this->page_editor_fontsize_index,'',$this->pelement);
	if (!empty($this->page_options[$this->page_editor_fontsize_index])&&is_numeric($this->page_options[$this->page_editor_fontsize_index]))  $this->edit_font_size=$this->page_options[$this->page_editor_fontsize_index];
	$this->close_print_wrap('editor font size');
     $this->show_close('Configure Editor Font');
     $this->close_print_wrap('editor appearance');
	$this->show_close('Edit Mode Style'); 
     echo '</div><!-- float buttons-->';
     }#end editor_appear
   
function configure_editor(){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
     $this->rem_root=($this->page_options[$this->page_rem_unit_index]>=3&&$this->page_options[$this->page_rem_unit_index]<=100)?$this->page_options[$this->page_rem_unit_index]:16;//initialize before editor font choice 
	$this->current_font_size=$page_rem_unit=$this->rem_root; 
     $page_mod_percent=(is_numeric($this->page_options[$this->page_mod_percent_index])&&$this->page_options[$this->page_mod_percent_index]<=400&&$this->page_options[$this->page_mod_percent_index]>=25)? $this->page_options[$this->page_mod_percent_index]: 100; 
	$page_width_scale_upper=(!empty($this->page_options[$this->page_width_scale_upper_index])&&is_numeric($this->page_options[$this->page_width_scale_upper_index])&&$this->page_options[$this->page_width_scale_upper_index]<=Cfg::Col_maxwidth&&$this->page_options[$this->page_width_scale_upper_index]>=500)?$this->page_options[$this->page_width_scale_upper_index]:'none';
	$page_width_scale_lower=(!empty($this->page_options[$this->page_width_scale_lower_index])&&is_numeric($this->page_options[$this->page_width_scale_lower_index])&&$this->page_options[$this->page_width_scale_lower_index]<Cfg::Col_maxwidth*.75)?$this->page_options[$this->page_width_scale_lower_index]:'none';
     //$this->current_font_em_px=$page_rem_unit;  
     $this->show_more('Enable viewport Responsive rem units');
	$this->print_redwrap('Enable viewport Responsive rem units');
     printer::alert('Current full value: '.$page_rem_unit.'px');
	$this->show_more('Tweak default rem value');
     printer::print_redwrap('Tweak rem');
     printer::print_info('Original default rem unit value is 16px');
     printer::alert('Current full value: '.$page_rem_unit.'px');
     printer::print_tip('Scaling rem is done below this. However here you can tweak up or down the overal value of scaled or unscaled rem units when a global rem value change is called for');//
     $this->mod_spacing('page_options['.$this->page_rem_unit_index.']',$page_rem_unit,4,100,.1,'px');
     printer::close_print_wrap('Tweak rem');
     $this->show_close('Tweak default rem value');
     printer::print_tip2('Under any spacing or font-size choice you can choose to make a px choice scale responsively, ie smallerize according to the users viewport size, or you can choose other units such as %, em, rem, or vw. Both em and rem units can simlarly be set up to responsizely scale.  Here you can setup rem responsive unit sizing proportional to the viewport sizes over which you wish the rem unit to decreasingly respond in size in a one to one proportion.  However, there is also an option below to modify this one to one relationship if desired');
     
	printer::print_tip('Enter both an upper and lower viewport range over which the use of rem  scaling is to take place and the system will automatically generate the necessary media queries linked to the hml tag which sets up rem units.  The result of specifying your minimum and maximum range will be a more appropriately scaled rem unit when scaling is required.  For best results the upper size limit should be the size of a viewport which begins to compress your content or more generally no greater than the width of the primary column. Lower end generally between 300-350px for lower screen size mobile devices. <b>Find an overview of the various scaling unit options under the Scale Units Overview &amp; Some Basic Pointers on the editor system option just above.</b>'); 
     printer::alert('Enter Viewport Upper Begin Scale Width:');
	$this->mod_spacing('page_options['.$this->page_width_scale_upper_index.']',$page_width_scale_upper,500,Cfg::Col_maxwidth,1,'px','none');
     printer::alert('Enter Viewport Lower End Scale Width:'); 
	$this->mod_spacing('page_options['.$this->page_width_scale_lower_index.']',$page_width_scale_lower,100,Cfg::Col_maxwidth*.75,1,'px','none');
	#REM #rem
	
     $this->show_more('REM Mod Percent','','smaller editfont editcolor editbackground floatleft');
	$this->print_wrap('mod page percent');
	printer::alert('By default size change will scale one to one with changes in viewport size between the max and min viewport sizes you choose. You can change this default behavior which occurs at a setting 100% to either speed up to 300% and increase the rate of change (ie. ~ 3x smaller) or decrease down to 25% the rate of change to minimizing the final size change to get the exact rate change you need');
     $msgjava='Choose percent rate of change';
	$this->mod_spacing('page_options['.$this->page_mod_percent_index.']',$page_mod_percent,24,400,.1,'%','none',$msgjava);
	$this->close_print_wrap('mod page percent');
	$this->show_close('Page Mod Percent');
     if (is_numeric($page_width_scale_upper)&&is_numeric($page_width_scale_lower)&&(($page_width_scale_upper-$page_width_scale_lower)>75)){
          $this->terminal_em_scale=$this->current_em_scale=true;
          $this->rem_scale=true;
          $initrem=$page_rem_unit; #using  px;  
          #$initrem=$page_rem_unit/16*100; #using 100%  
          $this->scale_render(0,$initrem,$page_mod_percent,'auto','html','font-size',$page_width_scale_upper,$page_width_scale_lower,'px');
          }
     else  $this->pagecss.='
html {font-size:'.$page_rem_unit.'px}';//set default rem unit size
     printer::pclear(5);
     $this->submit_button();
	printer::close_print_wrap('Enable viewport Responsive rem units');
	$this->show_close('Enable viewport Responsive rem units');
	$this->show_more('Configure Setting Defaults','noback');
	$this->print_redwrap('settings defaults wrap',true); 
	$this->page_width=($this->page_width >99 && $this->page_width < Cfg::Col_maxwidth)?$this->page_width:1280;
	echo'<div class="floatleft editbackground editfont fsminfo editcolor" ><!--page width-->Set Default  Primary Column Width:';
     printer::print_tip('Optionally Set the  maximum Page Content Width which limits the width of Columns and Posts within Columns. Consistent width between pages lead to consistent navigation transtions. Wil also set the width in circumstances of cloned nested columns to a primary column position in a new page. Default page width: '.Cfg::Page_width);
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
     $quality=(!empty($this->page_options[$this->page_image_quality_index])&&$this->page_options[$this->page_image_quality_index]>10&&$this->page_options[$this->page_image_quality_index]<101)?$this->page_options[$this->page_image_quality_index]:Cfg::Pic_quality;
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