<?php
#info
#width# find #width# for various width info
#style# find overview of style mechanism info
#flatfile# flatfile info for main system
#blogrender# function blog_render is the central method of the system
class global_edit_master extends Singleton{
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
	private  $pic_ext='';#used to add pic extension for float image css styling in blog_render
	private $default_blog_text='Ready for Action. Put Your Text Here. Posts will not appear on the webpage till you Check the Publish Box!';
	protected $page_background='background-color:white;';//default for highslide dimming
	private $styler_blog_instructions='Styles '; 
	private $styler2_instruct='';
	private $new_blog_array=array();
	private $choose_blog_type='CHOOSE NEW POST TYPE';
	private $insert_full=10;
	private $insert_half=5;
	private $dir_insert_full=1;  
	private $image_link=false;
	private $css_fonts_extended_dir='fonts.css';
	private $is_blog=false;//if blog being served up
	private $is_column=false;//if column being served up
	private $is_page=false;//if page being served up 
	protected $column_net_width=array();
	private $column_total_width=array();
	private $blog_id_arr=array();
	private $column_background_color_arr=array();
	private $column_color_arr=array();
	private $column_font_px_arr=array(); 
	private $column_fol_arr=array();
	private $column_id_array=array(); 
	//private $column_table_array=array();
	private $column_level_base=array();
	private $blog_order_arr=array();
	private $column_total_gu_arr=array();		
	private $inforef;//pass info to Column#
	private $blog_order_mod=''; // initialize
	private $column_new=false;//used to alert new column creation in render column data
	//private $post_ref_array=array();//current progression of post_refs
	private $blog_order_array=array();  
	private $column_order_array=array(); 
	protected $column_lev_color='pos';
	private $file_generate_css=false;#will generate css for all pages file_generator::file_generate(true,false);// css  file generate after update
	protected $current_total_width='';
	protected $current_net_width='800';//set as default value for intital page styling
	protected $current_background_color='';
	protected $current_font_px='';
	protected $current_color='000';
	protected $column_total_net_width_percent=array();
	private $col_num_max=0; 
	private $clone_check_arr=array();
	private $blog_moved=array();
	private $nested_col_moved=array();
	protected $column_moved=array();
	protected $advancedstyles=array();
	protected $menu_icon_color='white,yellow,gold,lightestblue,lightlightblue,lightblue,lavender,blue2,blue,navy,ekblue,electricblue,ekaqua,forestgreen,green,lime,electricgreen,ekdarkpurple,olive,orange,ekmagenta,magenta,red,ekred,lightbrown,brown,black,silverlightest,silverlight,silver,greydark,greydarkest';
	protected $marketing_default='your business,software,maintenance,development,seo,regarding your website,telemarketing,custome
							    traffic,client,search engine optimization,online leads,businesses thrive, increase your business,increase traffic,increase business,
							    targeted traffic,visitors to your website,marketing,goog,increase,rank,domain,white hat,whitehat';
	private $position_arr=array('center_row','center_float','left_float','right_float','left_float_no_next','right_float_no_next','center_float_no_next');
	private $position_val_arr=array('center row','center float','left float','right float','left float no next','right float no next','center float no next');
	private $table_prefix='table_';
	static protected  $col_count=1;
	static private  $xyz=1;
	protected $col_num=0;
	protected $styleoff=false;//turn off style editing
	private $column_new_array=array();
	protected $navcss='';
	protected $previous_post='first post';
	private $float_width_record=array();
	private $current_overall_floated_total=array(); 
	private $border_sides=array('No Border','top bottom left right','top bottom','top','bottom','left','right','top left','top right','bottom left','bottom right','left right');
	private $current_padded=0;
	private $auto_width=0; //ajax derived browser width
	private $delete_col_arr=array();//collects deleted col ids
	private static $styleinc=0;
	private $table_updater_arr=array();
	protected $list=array();
	protected $current_unclone_table=array();
	protected $clone_local_style=false;
	protected $clone_local_data=false;
	protected $parent_col_clone='';
	protected $image_resize_msg='';
	private static $instance=false; //store instance not curr used
	private $groupstyle_begin_blog_id_arr=array();
	private $groupstyle_begin_col_id_arr=array();
	protected $width_max_px=false;//express width as max-width px  otherwise percent
 
	//if in backup clone check array will  iframe   regenerate cloned post styles in backup class :: blog_text blog_data1 are examples of frequently changed fields with no effect on styling  in clones		
	
#css_generate will happen without an submit!  It generates the element css automatically..
#the render array for css_generate is generated it edit_styles_close();
#editpages handles arrays of submitted values and implodes them in process_data::spam_scrubber
#each style funct  creates a full css elementstyle with its $value for rendering the css in css_generate!!
/*
1 padding_top
2	padding_bottom
3	padding_left
4	padding_right
5	margin_top
6	margin_bottom
7	margin_left
8	margin_right
9	font_family
10	font_size
11 	font_weight
12	text_align
13	font_color
14	italics_font
15	small_caps
16	line_height
17	letter_spacing
18 	text_underline
19	width
20	background
21	radius_corner
22	columns
23	text_shadow
24	box_shadow
25	transform';
	
 
*/	
#**************BEGIN EDIT FUNCTIONS***************

 
function backup(){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__); 
	(Sys::Deltatime)&&$this->deltatime->delta_log('begin backup '.__LINE__.' @ '.__method__.'  '); 
	 $this->backupinst->render_backup($this->tablename);
	(Sys::Deltatime)&&$this->deltatime->delta_log('end  backup '.__LINE__.' @ '.__method__.'  ');
	}
	
	

			
function edit_script(){if (Sys::Debug)  Sys::Debug(__LINE__,__FILE__,__METHOD__);  if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	(Sys::Deltatime)&&$this->deltatime->delta_log(__LINE__.' @ '.__method__.'  ');
	 
	$this->editpages_obj($this->master_page_table,'page_id,'.Cfg::Page_fields,'','page_ref',$this->tablename,'','','all','',",page_time=".time().",token='". mt_rand(1,mt_getrandmax())."', page_update='".date("dMY-H-i-s")."'");
	$this->page_populate_options();//separately called  in non edit pages
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
	if (isset($_POST['gallpicsubmitted'])){
		$addgallery=addgallery::instance();
		$addgallery->submitted();
		}
	if (isset($_POST['file_generate_site'])){
		$msg=file_generator::file_generate(false,true,false);
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
		
	if (isset($_POST['create_unclone']))
		$this->create_unclone_fresh();
	/*if (!Sys::Debug){
		header( 'Expires: Sat, 26 Jul 1997 05:00:00 GMT' );
		header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
		header( 'Cache-Control: no-store, no-cache, must-revalidate' );
		header( 'Cache-Control: post-check=0, pre-check=0', false );
		header( 'Pragma: no-cache' );
		}*/
	$this->fonts_browser=explode(';',Cfg::Fonts_browser);
	$this->fonts_extended=explode(';',Cfg::Fonts_extended);
	$this->fonts_all=array_merge($this->fonts_browser,$this->fonts_extended);  
	//editpages_obj was moved from here up
	if (isset($_POST['page_cache']))$this->page_cache_update();//waited for page_cache to be rendered
	$this->pre_render_data();
	if (!empty($this->header_script_function)){  
	   $javascript=new javascript($this->header_script_function,$this->tablename, $this->css_suffix,$this->append_script);
	   }
    if (!empty($this->header_edit_script_function)){
	   $javascript_edit=new javascript($this->header_edit_script_function,$this->tablename,$this->css_suffix.'edit');
	    $this->header_edit_script=(!is_array($this->header_edit_script))?explode(',',$this->header_edit_script):$this->header_edit_script;    
	    $this->header_edit_script[]=$this->tablename.$this->css_suffix.'editscripts.js';   
	   }
	$this->render_header_open();
	$this->edit_header();
	$this->header_insert_edit();
	$this->tinymce();
	$this->gen_Proc_init();
	$this->render_highslide();
	$this->header_close(); 
	$this->edit_body();  
	
	if (isset($_POST['submitted'])){
		$this->backupinst->backup_copies=$this->backup_copies;
		$this->backup();//it gatheres the master tablename and makes sure not a blog tablename...
		(Sys::Deltatime)&&$this->deltatime->delta_log('Begin backup check clone  '.__LINE__.' @ '.__method__.'  ');
		//$this->backupinst->backup_check_clone($this->backup_page_arr);//not necessary with new system
		(Sys::Deltatime)&&$this->deltatime->delta_log('End backup check clone  '.__LINE__.' @ '.__method__.'  ');
		}
	 ($this->file_generate_css)&& file_generator::file_generate(true,false);//generates global css for element on all pages
	$this->render_css();
	if(isset($_SESSION[Cfg::Owner.'page_update_clones'])){ 
		if(($key = array_search($this->tablename, $_SESSION[Cfg::Owner.'page_update_clones'])) !== false) {
			unset($_SESSION[Cfg::Owner.'page_update_clones'][$key]);
			}
		}
	(Sys::Deltatime)&&$this->deltatime->delta_log('End of '.__LINE__.' @ '.__method__.'  ');
	//collect backup_page_arr values have been collected from posted changes and will be checked for cloned posts to update css if necess by calling iframes of the particular page where cloned match is present
	/*if (isset($_SESSION[Cfg::Owner.'backup_page_arr'])&&count($_SESSION[Cfg::Owner.'backup_page_arr'])>0){
		$this->backup_page_arr=$_SESSION[Cfg::Owner.'backup_page_arr'];
		unset($_SESSION[Cfg::Owner.'backup_page_arr']);
		}*/  //not used anymore
	$this->render_body_end();
	(Sys::Deltatime)&&$this->deltatime->delta_log('End of '.__LINE__.' @ '.__method__.'  ');
	if (Sys::Deltatime){
		if (!isset($_POST['submit'])||Sys::Refreshoff)print $this->deltatime->return_delta_log();
	     else 
		    $_SESSION[Cfg::Owner.'update_msg'][]=$this->deltatime->return_delta_log();
		}  
	}//edit script

	
	//note gallery master has its own edit_body
function header_insert_edit(){
	print(' 
	<!-- Modified tool-man  dragsort related  js created by Tim Taylor Consulting <http://tool-man.org/>  -->
	<script > 
	var dragsort = ToolMan.dragsort()
	var junkdrawer = ToolMan.junkdrawer()
	</script>');
	}
function edit_body(){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	$this->call_body(); 
	$this->echo_msg();//will echo success msgs  //submit call in destructor to collect all mgs
	$this->render_message();//will handle mailing of message and success  
	$this->edit_form_head();
	if (!isset($_GET['iframepos'])&&isset($_SESSION[Cfg::Owner.'page_update_clones'])){
		$this->page_update_clones();
		}// 
	$this->page_options(); 
	//$this->render_body_head();
	$this->top_submit();
	$this->browser_size_display();
	$this->editor_overview();
	$this->generate_cache();
	$this->generate_bps();
	if (isset($_POST['page_adjust_break_points']))$this->page_adjust_break_points(); 
	$this->configure(); 
	$this->full_nav();
	$this->add_new_page();
	$this->view_page();
	$this->leftover_view();##################### advance off button
	echo '<div class="inline floatleft"><!-- float buttons-->';
	$msg='Advanced Style Css is Always Displayed On in Normal Webpage but toggled in the editor. Toggle here';
	if (!Sys::Advanced) 
		printer::printx('<p class="buttonnavymini info supertiny" title="'.$msg.'"> <a class="info click" href="'.Sys::Self.'?advanced">Enable Advanced Display</a></p>');
	else printer::printx('<p class="buttonnavymini info supertiny" title="'.$msg.'"> <a class="info click" href="'.Sys::Self.'?advancedoff">Disable Advanced Display</a></p>'); 
		echo '</div><!-- float buttons--><!--float button-->'; 
	$this->restore_backup();
	$this->import_page();
	
	printer::pclear(2);
	//$this->navigation();
	//$this->render_body_addtop();
	if ($this->page_options[$this->page_slideshow_index]==='enable_page_slideshow'){
		print '<fieldset class="border3 borderridge border'.$this->color_arr_long[0].'"><legend class="shadowoff editbackground">Configure Page Slide Show</legend><!--Begin edit fieldset Configure Page slide show-->';
		$this->auto_slide($this->tablename,'page');
		print '</fieldset><!--End edit fieldset Configure Page slide show-->';
		}
	$this->render_body_main();
	printer::pclear();
	}//note gallery master has its own edit_body
	
 function edit_header(){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
 (Sys::Deltatime)&&$this->deltatime->delta_log(__LINE__.' @ '.__method__.'  '); 
    echo '<link href="'.Cfg_loc::Root_dir.$this->css_fonts_extended_dir.'"  rel="stylesheet" type="text/css">';
    if (!empty($this->header_edit_script)){
	  foreach ($this->header_edit_script as $var){
		  if (!empty($var)){
			 echo ' 
			 <script    src="'.$this->roots.Cfg::Script_dir.$var.'"></script> ';
			 }
		  }
	   }
    }	        
function editpages_obj($master_table,$field_data,$post_prepend,$ref1,$refval1,$ref2='',$refval2='',$do_all='all',$where3='',$update2=''){ #update# Updating posts in main process_blog function calling this function handles originals ie non-clones.. whereas updaing for local clone style and local clone data call this function in each repective section in the main blog_render function..  for the clones same parameters are passed cept has additional where blog_table_base='$this->tablename' clause  and instead of using master_post uses master_post_css or master_post_data for clone_local_style and  clone_local_data respectively
	#the system uses the tablename and order instead of id  which allows for proper order information ie. placement to occur naturally
	$print=(false)?true:false;   
	 ($print)&&print NL.NL.'<p class="neu">'."master table: $master_table, field_data,ref1: $ref1,refval: $refval1,ref2: $ref2,refval2 $refval2='',do: $do_all and update2= $update2".'</p>';
	$where2=(empty($ref2))?'':" AND $ref2='$refval2' "; 
	$field_array=explode(',',$field_data); 
	if (isset($_POST['submitted'])){	 
		  if ($do_all!='populate_data'){#in blog_render updating will be done after new entries are added..
			$process=process_data::instance();   
			# Note:
			#remember that the post will handle the individual posted array elements if they exist!...
			# process spam scrubber will psuedo implode all the data for storage in database
			#the post will pass the variable as array if sent as keys
			 
			$blog_style='';
			$update= 'SET '; 
			//standard form for processing is $this->blog_table.'_'.$refval1.'_blog_field
			for ($x=0; $x<count($field_array); $x++){
				foreach (array('','_arrayed') as $check_suffix){
				 	if (isset($_POST[$post_prepend.$field_array[$x].$check_suffix])){ ($print)&&print   '<p class="pos"> is post '.$post_prepend.$field_array[$x].$check_suffix.'</p>'; 
						if (is_array($_POST[$post_prepend.$field_array[$x].$check_suffix])){
							$q='select '.$field_array[$x]." from $master_table WhErE $ref1 ='$refval1' $where2";   
							$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);  
							list($c_val)=$this->mysqlinst->fetch_row($r,__LINE__);
							 
							${$field_array[$x]}=process_data::implode_retain_vals($_POST[$post_prepend.$field_array[$x].$check_suffix],$c_val,',','@@'); 
							}
						
						else ${$field_array[$x]}=process_data::spam_scrubber($_POST[$post_prepend.$field_array[$x].$check_suffix]);//chdnged from blog_check.$field_array.$check_suffix
						$update.=" {$field_array[$x]}='${$field_array[$x]}',";
						$blog_style=($field_array[$x]=='blog_style')?${$field_array[$x]}:$blog_style;
						 
						}
					 }
				}
			if ($update== 'SET '&& $do_all!=='all')return;
			elseif ($update!= 'SET '){   
				$update=substr_replace($update ,"",-1);  
				//$update2=substr_replace($update2 ,"",-1);  
				$q="UPDATE $master_table $update $update2 WherE $ref1 ='$refval1' $where2 $where3";    ($print)&&print $q. ' the big q is';  
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
				 	
			
			(!$this->is_blog)&&$this->master_page_ref=$this->tablename;// this is for render_backups()..
			#regardless of affected or not backup
	// (strpos($tablename,'_blog')===false)&&$this->back  up();// moved till after all blogs are rendered
			##remember css is generated whether submitted or not whereas otherwise backups must be submitted
			}
			
		}// if submitted  
	 
	if ($do_all=='update')return; #job in blog_render is done...
	$q = "SELeCT $field_data FROM $master_table  where $ref1 ='$refval1' $where2";    
	$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); 
	 
	try {
		if (!$this->mysqlinst->affected_rows()) { 
			if (Sys::Debug)echo NL.'failed '. $q. NL;
                 
			$msg="Edit Site Temporarily Down-  Check back later line: " .__LINE__.' in '.__method__;
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
		//$removed_characters = array_map(array('process_data','remove_characters'), $rows); //class process_data
		//if (isset($this->blog_table)&&$this->blog_table==$tablename) $removed_break_rows=$removed_characters;
		// else $removed_break_rows = array_map(array('process_data','remove_break'), $removed_characters);
		#in order to render a html break to javascript tinymce box when enabled and a validated line break to plain textarea the
		#followiing is being implemented
		$process=process_data::instance();    
	 for ($x=0; $x<count($field_array); $x++){
		$this->{$field_array[$x]}= $rows[$field_array[$x]];//populate data
		}  
	if (Sys::Debug) echo 'leaving funct editpage entirely!!';  
	}#end function edit pages_obj
      
function initiate_menu_tab(){//keeps tabs on which menu used for gallery expanded pic utility menus..
	$q="update $this->master_page_table set page_menu_tab=''";  
	$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	}
function page_options(){
	 
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
				printer::printx('<input class="allowthis" type="hidden" name="page_dark_editor_value['.$key.']" value="'.$this->$color.'">');
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
				printer::printx('<input class="allowthis" type="hidden" name="page_light_editor_value['.$key.']" value="'.$this->$color.'">');
				} 	
		
			}
		$this->editor_background=$this->page_options[$this->page_lighteditor_background_index];
		$this->editor_color=$this->page_options[$this->page_lighteditor_color_index];
	endif;
	$this->color_order_arr=explode(',',$color_order); 
	$this->color_arr_long=$this->color_order_arr;//explode(',',substr_replace(str_repeat($color_order.',',3),'',-1));
	
	}//page populate options
	
	
	
function top_submit(){if(Sys::Custom)return;if (Sys::Quietmode||Sys::Pass_class) return;
	echo '<div class="inline floatleft"><!-- float buttons-->';
	echo'  <p><input class="editbackground editfontfamily '.$this->column_lev_color.' shadowoff cursor  smallest button'.$this->column_lev_color.'"   type="submit" name="submit"   value="submit All" ></p>';
	echo '</div><!--float buttons-->'; 
	} 
 
function editor_overview(){if (Sys::Quietmode) return;
	echo '<div class="inline floatleft"><!-- float buttons-->';
	$this->show_more('Quick Editor Overview','close Editor Overview',$this->column_lev_color.' smallest  editbackground button'.$this->column_lev_color,'',600);
echo '<div class="fsminfo Os3darkolivegreen editbackground floatleft maxwidth600">';
				$instructions=' 
				Hover Over <span class="info" title="hovering over this color text having white background will reveal more info">Highlighted Text</span> for More Information on choosing Options. Each post may be edited for styles including background colors, text colors, text size, and many more.  Use an optional grid percentage system. Each grid is one percent by default. Or instead of choosing a grid system width restrictions on a post may be implemented for  "floating" multiple posts including nested columns of posts next to another instead of below. For example  align a text post next to an image posts if the width of both adds up to less than than the total width of the parent column. If your not using the grid system, Check the float checkbox in each post, whether image or text. Limit the width of the text, and if the overall width permits it will happen!';
	
	
		printer::alert($instructions,false,$this->column_lev_color.' fsmcolor editbackground');
		echo '</div><!--ramanablock editor overview-->'; 
	 $this->show_close('editor overview');//<!--Show More editor overview-->';
	 echo '</div><!--float buttons-->'; 
	}

function token_gen(){
	return mt_rand(1,mt_getrandmax());
	
	}
function page_adjust_break_points(){
	if (!isset($_POST['page_adjust_break_points']))return;
	if (!isset($_POST['page_sub_bp']))mail::alert('submitted page_sub_bp not found');
	$count=count($this->page_break_arr); 
	for ($i=0; $i<$count; $i++){
		if (isset($this->page_break_arr[$i+1])){
			if ($this->page_break_arr[$i]<=$this->page_break_arr[$i+1]){
				$this->message[]='break point value mismatch: Your substions should follow descending values';
				return;
				}
			}
		}
	$x=0;
	$change_bp_arr=array();
	foreach ($_POST['page_adjust_break_points']  as $bp => $newbp){
		if ($this->page_break_arr[$x]===$newbp){
		    $x++;
		    continue;
		    }
		if ($newbp <101){
			$this->message[]='Break Points must be greater than 100';
			return;
			}
		$change_bp_arr[$bp]=$newbp;
		}//end foreach
	if (count($change_bp_arr)<1)return;
	$wheretable=(isset($_POST['page_sub_bp'])&&	$_POST['page_sub_bp']==='site')?'':" where page_ref='$this->tablename'";
	$q="select page_id,page_ref,page_break_points from $this->master_page_table $wheretable"; 
	$r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	$success_arr=array();
	$update_arr=array();
	while (list($id,$page_ref,$pagebps) = $this->mysqlinst->fetch_row($r,__LINE__)){
		$update_arr[]=array($id,$page_ref,$pagebps);
		}
	foreach ($update_arr as $update){
		foreach($change_bp_arr as $bp =>$newbp){
			$update[2]=str_replace($bp,$newbp,$update[2]);
			}
		$q="update $this->master_page_table set page_break_points='".$update[2]."' where page_id=".$update[0];   
		$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
		if ($this->mysqlinst->affected_rows()){
			$success_arr[]=$update[1];
			}
		}//end for each update
	if (count($success_arr)>0){
		$string=implode(',',array_unique($success_arr));
		$this->success[]='Page Config Break Points altered on pages:'.$string;
		}
	else $this->message[]='No page config break points were changed';
	###############column col_grid_clone update
	$q="select col_id,col_grid_clone from $this->master_col_table $wheretable"; 
	$r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);  
	while (list($id,$clone) = $this->mysqlinst->fetch_row($r,__LINE__)){
		$update_arr[]=array($id,$clone);
		}
	foreach ($update_arr as $update){
		foreach($change_bp_arr as $bp =>$newbp){
			$update[1]=str_replace($bp,$newbp,$update[1]);
			}
		$q="update $this->master_col_table set col_grid_clone='".$update[1]."' where col_id=".$update[0];   
		$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
		}
	##end col_grid_clone
	foreach (array('col','post','csscol','csspost') as $type){
		switch ($type){
			case 'col':
				$id='col_id';
				$table=$this->master_col_table;
				$gridwid='col_grid_width';
				$gridright='col_gridspace_right';
				$gridleft='col_gridspace_left';
				$gridclone='col_grid_clone';
				$page_ref='col_table_base';
				$type_msg='columns';
				break;
			case 'csscol':
				$id='css_id';
				$table=$this->master_col_css_table;
				$gridwid='col_grid_width';
				$gridright='col_gridspace_right';
				$gridleft='col_gridspace_left';
				$gridclone='col_grid_clone';
				$page_ref='col_table_base';
				$type_msg='local style cloned columns';
				break;
			case 'post':
				$id='blog_id';
				$table=$this->master_post_table;
				$gridwid='blog_grid_width';
				$gridright='blog_gridspace_right';
				$gridleft='blog_gridspace_left';
				$page_ref='blog_table_base';
				$type_msg='posts';
				break;
			case 'csspost':
				$id='css_id';
				$table=$this->master_post_css_table;
				$gridwid='blog_grid_width';
				$gridright='blog_gridspace_right';
				$gridleft='blog_gridspace_left';
				$page_ref='blog_table_base';
				$type_msg='local style cloned posts';
				break;
			}//end switch
		$wheretable=(isset($_POST['page_sub_bp'])&&$_POST['page_sub_bp']==='site')?'':" where $page_ref='$this->tablename'";
		$q="select $id,$gridwid,$gridright,$gridleft,$page_ref from $table $wheretable"; 
		$r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
		if ($this->mysqlinst->affected_rows()){ 
			$update_arr=array();
			$success_arr=array();
			while (list($idv,$gridwidv,$gridrightv,$gridleftv,$page_refv) = $this->mysqlinst->fetch_row($r,__LINE__)){
				if (strlen($gridwidv)>10||strlen($gridrightv)>10||strlen($gridleftv)>10)
					$update_arr[]=array($idv,$gridwidv,$gridrightv,$gridleftv,$page_refv);
				}
			foreach ($update_arr as $update){
				foreach($change_bp_arr as $bp =>$newbp){
					$update[1]=str_replace($bp,$newbp,$update[1]);
					$update[2]=str_replace($bp,$newbp,$update[2]);
					$update[3]=str_replace($bp,$newbp,$update[3]);
					}
				$q="update $table set $gridwid='".$update[1]."',$gridright='".$update[2]."',$gridleft='".$update[3]."' where $id=".$update[0];
				 
				$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
				if ($this->mysqlinst->affected_rows()){
					$success_arr[]=$update[4];
					}
				}//foreach update arr
			if (count($success_arr)>0){
					$_SESSION[Cfg::Owner.'page_update_clones']= (isset($_SESSION[Cfg::Owner.'page_update_clones']))?array_unique(array_merge($_SESSION[Cfg::Owner.'page_update_clones'],$success_arr)):$success_arr;//update session array for iframe regeneration of substitued data.. so that styling is up to date
					$string=implode(',',array_unique($success_arr));
					$this->success[]="Css Grid width/spacings on 
				$type_msg were altered on pages:".$string;
					}
				else $this->message[]='No Grid breakpoint chosen width/spacings  settings were affected';	
			}//affected rows
		}//foreach type
	}//end page_adjust_break_points
	
function page_cache_update(){
	if (Sys::Pass_class)return;
	if (!isset($_POST['page_cache'])||!isset($_POST['check_page_cache']))return;
	$new_cache=$_POST['page_cache'];
	$new_cache_arr=explode(',',$new_cache);
	$old_cache=$_POST['check_page_cache'];
	$old_cache_arr=explode(',',$old_cache);
	$count =count($new_cache_arr);
	if ($new_cache===$old_cache)return;
	if ($count<1){
		$this->message[]='Mistake in image cache update Changing sizes';
		return;
		}
	$new_cache_arr=$this->generate_cache($new_cache,true); 
	if ($new_cache_arr[$count-1] < 1000){
		$this->message[]='Your Largest cache image directory size must be at least 1000 (px)';
		return;
		}
	$new_cache=implode(',',$new_cache_arr);
	if ($new_cache===$old_cache)return;
	$q="update $this->master_page_table set page_cache='$new_cache'"; 
	$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	$image_dir_arr=array(Cfg::Page_images_dir,Cfg::Auto_slide_dir,Cfg::Large_image_dir);
	$dir_arr=array();
	$flag=false;
	$new_ext=array();
	foreach($new_cache_arr as $ext){
		$dir_arr[]=Cfg::Response_dir_prefix.$ext;//create to check in next step
		if (!in_array($ext,$old_cache_arr)){
			$this->success[]='new cache images to be added for '.Cfg::Response_dir_prefix."$ext on all pages";
			$new_ext[]=$ext;
			$flag=true;
			}
		}//ne 
	if ($flag){
		#to create the newly required directory we will read one of the current directories getting all the image filenames and recreate them at the size of the new cache directory need.  But to do so we will also retreive the gallery info store arrays for each page and each image type and read the quality setting so all images are replaced at the same quality previously specified
		$page_arr=check_data::return_pages(__METHOD__,__LINE__,__FILE__);
		foreach ($image_dir_arr as $image_type_dir){
			foreach($page_arr as $page_ref){ 
				$image_info_file='image_info_page_images_'.$page_ref;
				if (is_file(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Image_info_dir.$image_info_file)){//get image info arrays
					$image_info_arr=unserialize(file_get_contents(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Image_info_dir.$image_info_file));
					//printer::horiz_print($image_info_arr);
					}
				else {
					continue;
					printer::print_neg(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Image_info_dir.$image_info_file.' does not exist',.8);
					}
				$predir=Cfg_loc::Root_dir.$image_type_dir;
				foreach ($new_ext as $ext){
					if (!is_numeric($ext)){
						printer::alert_neg('mal-formed image dir size:'.$ext);
						return;
						}
					if (!is_dir($predir.Cfg::Response_dir_prefix.$ext)){
						mkdir($predir.Cfg::Response_dir_prefix.$ext,0755,1);
						}
					(Cfg::Development)&&printer::alert_neu('creating dir: '.$predir.Cfg::Response_dir_prefix.$ext,.8);
					$min_size_ext=check_data::key_down($old_cache_arr,$ext);//here we are keying down. Our intention is to get next lowest size directory and replicate all the photos but resized to the newest directory.
					$dir=$predir.Cfg::Response_dir_prefix.$min_size_ext;
					printer::alert_neu('get image names dir: '.$predir.Cfg::Response_dir_prefix.$min_size_ext,.8);
					if (is_dir($dir)){
						if ($directory_handle = opendir($dir)) {
							while (($file_handle = readdir($directory_handle)) !== false) {
								if ($file_handle=='.'||$file_handle=='..')continue;
								if (is_dir($dir.$file_handle))continue;
								foreach($image_info_arr as $index=> $arr){
									//image_info_arr is a total list of current images in the website with information concerning the image
									if (array_key_exists('picname',$arr)&&array_key_exists('quality',$arr)){
										if ($arr['picname']===$file_handle){
											image::image_resize($file_handle,$ext,0,0,Cfg_loc::Root_dir.Cfg::Upload_dir, $predir.Cfg::Response_dir_prefix.$ext,'file',NULL,$arr['quality']);
											(Cfg::Development)&&printer::alert_pos('creating '.$predir.Cfg::Response_dir_prefix.$ext.$file_handle,.8);
											}
											 
										 
										}//inside foreach
									else {
										printer::alert_neg("quality array key does not exist in $image_info_file");
										print_r($arr);
										}
									//}//foreach	
									}//outside foreach image info arr	 
								}//while
							}//open dir
						}//is dir
					else {
						 printer::alert_neg('min size dir not found : '.$predir.Cfg::Response_dir_prefix.$min_size_ext,.8);
						}
					}//foreach new extention needed
				}//foreach page_ref
			}//foreach image inf array
		}//if flag
		
	foreach ($image_dir_arr as $dir){
		$dir=Cfg_loc::Root_dir.$dir;
		print_r($dir_arr);
		if ($directory_handle = opendir($dir)) {
			while (($file_handle = readdir($directory_handle)) !== false) {
				if ($file_handle=='.'||$file_handle=='..')continue;
				if (is_dir($dir. $file_handle)){ 
					if (!in_array($file_handle,$dir_arr)){
						file_generate::rrmdir($dir. $file_handle,'',true,true);
						echo "removing $dir. $file_handle";
						}
					}
				} 
			}
		}
	
	 //new directories will take care themselves in individual posts if using iframes but here we are avoiding that and using master array which gives current pic quality percentage which will be used to image::image_resize create the needed image directory images @ the present image quality percentage
	$flag=false;//not using the following now. Am using reading previous imagedir smallest size and then duplicating all those for new directory (may duplicate deleted unnecessary image however but saves generating all these iframes for each image to generate themselves!  There is/will be a maintance option to run through and delete all images not currently in the database!! 
	if($flag){
		store::setVar('backup_clone_refresh_cancel',true);//this can be set on any class 
		$this->iframe_update_msg='Allowing for all pages to update cache directories with each page generating an iframe. This will take awhile to finish loading at top of this page';
		file_generate::iframe_backup_all();
		}
	} 
function page_iframe_all(){
	if (!$this->edit||!isset($_POST['page_iframe_all']))return;
	store::setVar('backup_clone_refresh_cancel',true);//this can be set on any class 
	$this->iframe_update_msg='Wait For Loading to Finish. Allowing for all pages to update styles, flat files etc. with each page generating an iframe. This will take awhile to finish loading at top of this page.';
	file_generate::iframe_backup_all();
	}

function page_iframe_all_website(){
	if (!$this->edit||!isset($_POST['page_iframe_all_website']))return;
	store::setVar('backup_clone_refresh_cancel',true);//this can be set on any class 
	$this->iframe_update_msg='Wait For Loading to Finish. Allow each page to load in iframe. ';
	file_generate::iframe_backup_all(Cfg_loc::Root_dir);
	}

function cache_regenerate_flatfiles(){
	if (!$this->edit||!isset($_POST['cache_regenerate_flatfiles']))return;
	$dir_arr=array(Cfg::Data_dir,);
	foreach ($dir_arr as $type_dir){
		$dir=Cfg_loc::Root_dir.$type_dir;
		printer::alert_neu("Removing All Contents from dir: $dir",.8);
		file_generate::rrmdir($dir,'',true,true);
		}
	
	$dir_arr=array(Cfg::Gall_info_dir,Cfg::Image_info_dir,Cfg::Page_info_dir);
	foreach ($dir_arr as $type_dir){
		$dir=Cfg_loc::Root_dir.$type_dir;
		if (!is_dir($dir))mkdir($dir,0755,1);
		}
	
	store::setVar('backup_clone_refresh_cancel',true);//this can be set on any class 
	$this->iframe_update_msg='Allowing for all pages to update image cache directories with each page generating an iframe. This will take awhile to finish loading at top of this page.';
	file_generate::iframe_backup_all();
	}
	
function cache_regenerate(){
	if (!$this->edit||!isset($_POST['cache_regenerate']))return;
	$dir_arr=array(Cfg::Data_dir,Cfg::Page_images_dir,Cfg::Auto_slide_dir,Cfg::Large_image_dir);
	foreach ($dir_arr as $type_dir){
		$dir=Cfg_loc::Root_dir.$type_dir;
		printer::alert_neu("Removing All Contents from dir: $dir",.8);
		file_generate::rrmdir($dir,'',true,true);
		}
	foreach ($dir_arr as $type_dir){
		$dir=Cfg_loc::Root_dir.$type_dir;
		if (!is_dir($dir))mkdir($dir,0755,1);
		}
	$subdir_arr=array(Cfg::Gall_info_dir,Cfg::Image_info_dir,Cfg::Page_info_dir);
	foreach ($subdir_arr as $sub_dir){
		$dir=Cfg_loc::Root_dir.Cfg_loc::Data_dir.$sub_dir;
		if (!is_dir($dir))mkdir($dir,0755,1);
		}
	store::setVar('backup_clone_refresh_cancel',true);//this can be set on any class 
	$this->iframe_update_msg='Allowing for all pages to update image cache directories with each page generating an iframe. This will take awhile to finish loading at top of this page.';
	file_generate::iframe_backup_all();
	}


function page_opts_export(){
	if (!isset($_POST['page_opts_export']))return;
	$list= Cfg::Page_fields;//,page_data3,page_data4,  these are in reserve for future use
	$blacklist='page_ref,page_title,page_filename,page_id';
	$blacklist_arr=explode(',',$blacklist);
	$list_arr=explode(',',$list);
	$value='';
	$q="update $this->master_page_table c, $this->master_page_table p SET ";
	foreach ($list_arr as $field){
		if(in_array($field,$blacklist_arr))continue;
		$value.="c.$field = p.$field, ";
		}
	$q.=" $value c.page_update='".date("dMY-H-i-s")."', page_time='".time()."',c.token='".mt_rand(1,mt_getrandmax()). "' where p.page_ref='$page_ref'";
	$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	if ($this->mysqlinst->affected_rows()){
		$this->success[]="$page_ref has updated all styles and configs to all other pages";
		}
		
	}//end export page function


	
function page_opts_import(){
	if (!isset($_POST['page_opts_import']))return;
	$list= Cfg::Page_fields;//,page_data3,page_data4,  these are in reserve for future use
	$blacklist='page_ref,page_title,page_filename,page_id';
	$blacklist_arr=explode(',',$blacklist);
	$list_arr=explode(',',$list);
	$value='';
	foreach($_POST['page_opts_import'] as $page_ref => $copy_ref){
		$q="update $this->master_page_table c, $this->master_page_table p SET ";
	foreach ($list_arr as $field){
		if(in_array($field,$blacklist_arr))continue;
		$value.="c.$field = p.$field, ";
		}
	$q.=" $value c.page_update='".date("dMY-H-i-s")."', c.page_time='".time()."',c.token='".mt_rand(1,mt_getrandmax()). "' where c.page_ref='$page_ref' and p.page_ref='$copy_ref'";
	$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	if ($this->mysqlinst->affected_rows()){
			$this->success[]="$page_ref has been updated with styles and configs from $copy_ref";
			}
		}//end foreach...   should only be once
	}//end import page function
	 

function import_page_copy(){if (Sys::Quietmode) return;  
	$col_fields=Cfg::Col_fields;
	$post_fields=Cfg::Post_fields;
	$page_fields=Cfg::Page_fields;
	$page_fields_all=Cfg::Page_fields_all;
	$page_fields_arr=explode(',',$page_fields);
	if (!isset($_SESSION[Cfg::Owner.'dbname'])){
		$msg='session problem with import page copy database not transferred';
		$this->message[]=$msg;
		return;
		}
	
	$db=$_SESSION[Cfg::Owner.'dbname'];
	$page_ref=$_POST['import_page'];
	$q="select page_ref,page_filename from $this->master_page_table where page_ref LIKE 'theme%' or page_filename LIKE 'theme%'";   
	$r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	if (!$this->mysqlinst->affected_rows())$themename='theme1';
	else {
		$themearr=array();
		while (list($page_ref2,$page_filename2) = $this->mysqlinst->fetch_row($r,__LINE__)){
			$themearr[]=$page_ref2;
			$themearr[]=$page_filename2;
			}
		$x=1;   
		While (in_array('theme'.$x,$themearr)){
			$x++;
			}
		$themename='theme'.$x;   
		}
		
	$q="select $page_fields from  $db.$this->master_page_table where page_ref ='$page_ref' limit 1";   
	$r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	if (!$this->mysqlinst->affected_rows()){
		$msg="The Page Ref $page_ref was not found in $db";
		$this->message[]=$msg;
		return;
		}
	$row=$this->mysqlinst->fetch_assoc($r,__LINE__);
	$q="insert into $this->master_page_table ($page_fields_all) values (";
	foreach ($page_fields_arr as $field){
		if ($field=='page_ref')$q.="'$themename',";
		else if ($field=='page_title')$q.="'$themename',"; 
		else if ($field=='page_filename')$q.="'$themename',";
		else $q.="'".$row[$field]."',";
		}
	$q="$q '".date("dMY-H-i-s")."','".time()."','".$this->token_gen()."')";
	$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	$msg="Your New Theme Page has been copied";
	$this->success[]=$msg;
	file_generate::page_generate($themename);
	file_generate::pageEdit_generate($themename);
	file_generate::create_new_page_class($themename);
	$q="select col_id from $db.$this->master_col_table where col_table_base='$page_ref' and col_primary=1 order by col_num "; 
	$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); 
	if (!$this->mysqlinst->affected_rows()){ 
		$this->message[]="No Primary tables found in $page_ref from $db";
		return;
		} 
	while (list($parent_id)=$this->mysqlinst->fetch_row($r,__LINE__)){    
		$this->mysqlinst->count_field($this->master_col_table,'col_id','',false, '');
		$child_id=$this->mysqlinst->field_inc; 
		$this->copy_col_theme($parent_id,$child_id,$db,$themename);
		} 
	} 
	
function import_page(){if (Sys::Quietmode) return;   if (Sys::Pass_class)return; 
	$col_fields=Cfg::Col_fields;
	$post_fields=Cfg::Post_fields;
	$page_fields=Cfg::Page_fields;
	####################
	if (isset($_POST['add_theme_db'])&&strpos($_POST['add_theme_db'],'theme')!==false){ 
		$db=$_POST['add_theme_db'];
		$functionCheck= (!isset($_POST['cancel_clean_import']))?'strict_db_check':'non_strict_db_check';
		printer::alert_neg('Please Wait till Database Cleaning Occurs');
		if (is_dir(Cfg_loc::Root_dir.Cfg::Theme_dir.Cfg::Include_dir)){
			if (!is_file(Cfg_loc::Root_dir.Cfg::Theme_dir.Cfg::Include_dir.'Cfg.class.php')){
				copy (Cfg_loc::Root_dir.Cfg::Include_dir.'Cfg.class.php',Cfg_loc::Root_dir.Cfg::Theme_dir.Cfg::Include_dir.'Cfg.class.php');
				}
			$data=file_get_contents(Cfg_loc::Root_dir.Cfg::Theme_dir.Cfg::Include_dir.'Cfg.class.php');
			$pattern="/Dbname ?= ?'.*';/";
			$replace="Dbname = '$db';";    
			$data=preg_replace($pattern,$replace,$data); 
			if (strpos($data,$db)===false){
				$this->message[]='problem with config file while importing database';
				printer::alert_neg('echo problem importing database with config file');
				}
			else{
				printer::alert_pos('updated theme directory');
				file_put_contents(Cfg_loc::Root_dir.Cfg::Theme_dir.Cfg::Include_dir.'Cfg.class.php',$data);
				file_generator::array_map_database_mod($db, $functionCheck,true,'');
			
				$_SESSION[Cfg::Owner.'dbname']=$db;
			
				$this->success[]=('Database Scrub Complete');
				}
			}
		else $this->message[]="Theme Directories need generating";
		}
	elseif  (isset($_POST['import_page'])&&$_POST['import_page']!=='none')$this->import_page_copy($_POST['import_page']);
	
	if (isset($_SESSION[Cfg::Owner.'dbname'])){  
		$db=$_SESSION[Cfg::Owner.'dbname'];
		$token= $this->sess->sess_token; 
		echo '<div class="inline floatleft"><!-- float buttons-->';
		$this->show_more('View/Choose Theme Pages','noback','neg editbackground smallest button'.$this->column_lev_color,'',500 ); 
		printer::alertx('<p class="fsminfo editbackground editcolor floatleft">Db: '.$db.'<br><br>Click  Page Link to View<br>OR<br>use Radio Button for Page Import </p>');
		printer::pclear();
		echo '<div class="inline editbackground">';
		echo'<fieldset class="redfield"><!--Configure--><legend></legend>'; 
	
		$q="select distinct page_ref, page_title, page_filename from $db.$this->master_page_table  order by page_title ASC";   
		$r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
		echo '<div class="editcolor editbackground">';
		$msg='Your Choice is unselected';
		echo '<input class="import_page" type="radio" name="import_page" value="none" onchange="gen_Proc.on_check_event(\'import_page\',\''.$msg.'\');">Undo Any Copy Selection<br>';
		while (list($page_ref,$title,$filename) = $this->mysqlinst->fetch_row($r,__LINE__)){
			if ($page_ref=='setupmaster'||trim($filename)=='')continue;
			$msg= "Page $page_ref will be copied as Page theme1 to the website or theme2, etc.  if that page already exists.   Look for it under the full page navigation button at the top of page";
			echo '<span class="pos">&nbsp;Copy: </span><input class="import_page small" type="radio" name="import_page" value="'.$page_ref.'" onchange="gen_Proc.on_check_event(\'import_page\',\''.$msg.'\');">&nbsp;&nbsp;Or&nbsp; <span class="pos">&nbsp;&nbsp;View:&nbsp;  </span><a href="'.Cfg_loc::Root_dir.Cfg::Theme_dir.Cfg::Pass_class_page.'?editgen&amp;tkn='.$token.'&amp;tbn='.$page_ref.'&amp;returnpass='.Sys::Self.'"> '.str_replace(array('&nbsp','&nbs','&nb','&','<br>'),' ',substr($title,0,17)).'</a><br>'; 
			}
		echo '</div><!--end horiz utility full nav-->';
		echo'</fieldset><!--full nav-->';  
		echo '</div><!--full nav float buttons-->';
		$this->show_close('theme pages');// 
		echo '</div><!-- float buttons--><!--full nav editbackground-->'; 
		}//db activated
	 	
	
	$msg_choose_db=(isset($_SESSION[Cfg::Owner.'dbname']))?'Choose Different Theme Db':'Importing Theme Page'; 
	$this->show_more($msg_choose_db,'noback','infoclick editbackground  smallest button'.$this->column_lev_color,'Import choices to Add a theme page. Added theme pages Will Not Automatically replace you current theme');
	###############
	echo '<div class="inline floatleft"><!-- float buttons-->';
	$table_check=array($this->directory_table,$this->master_col_table,$this->master_page_table,$this->master_post_css_table,$this->master_col_css_table,$this->master_post_table,$this->master_gall_table);
	$dbases=array();
	$themedbs=array();
	$q="SELECT `SCHEMA_NAME`  FROM  information_schema.SCHEMATA";
	$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	while($rows=$this->mysqlinst->fetch_row($r,__LINE__)){
		$dbases[]=$rows[0];
		} 
	foreach ($dbases as $db){
		$check=true;
		if (strpos($db,'theme')==false)continue;   
		$tables=check_data::get_tables($db);   
		if (empty($tables)||!is_array($tables)){ 
			printer::alert_neg("$db database has no tables");
			continue;
			}
		foreach ($table_check as $check){
			if (!in_array($check,$tables))$check=false;
			
			}
		if ($check){ 
			$q="select $col_fields from $db.$this->master_col_table";
			$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
			if (!$this->mysqlinst->affected_rows()){
				printer::alert_neg($db .' has differing table fields for a check of '. $this->master_col_table);
				}
			else {
				$q="select $post_fields from $db.$this->master_post_table";
				$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
				if (!$this->mysqlinst->affected_rows()){
					printer::alert_neg("$db has differing table fields for a check of $this->master_post_table  while Ok for $this->master_col_table");
					}
				else {
					$q="select $page_fields from $db.$this->master_page_table";
					$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
					if (!$this->mysqlinst->affected_rows()){
						printer::alert_neg("$db  has differing table fields for a check of  $this->master_page_table while Ok for $this->master_col_table and $this->master_page_table");
						}
					else $themedbs[]=$db;
					}
				}
			}
		else printer::alert_neg($db .' has differing tables');
		
		} 
	  $this->mysqlinst->dbconnect();//reconnect to current database  as get_tables redirects db
		 
	######
	 
	if (count($themedbs) < 1){ 
		printer::alert_neg('No Theme Databases are currently installed');
		}
	else {
		 $msg="Cleaning of potentially harmful scripts has been disabled. Ensure Theme Database is from a Trusted Source.";
		 
		echo '<div title="Import choices to Add a theme page. Added theme pages Will Not Automatically replace you current theme" class="editbackground '.$this->column_lev_color.' fs2'.$this->column_lev_color.' rad5 left info">Choose your database to view pages and/or choose to import new theme page to your website <!--Import choices-->';
		printer::pclear();
		echo '<p class="floatleft editbackground '.$this->column_lev_color.' rs1redAlert smaller rad5 left info" title="Choose This option only if you trust the theme source and require special javascript content." ><input type="checkbox" class="cancel_clean_import" name="cancel_clean_import" value="1" onchange="gen_Proc.on_check_event(\'cancel_clean_import\',\''.$msg.'\');">Disable Cleaning Import of User Scripts</p>';
		printer::pclear();
		forms::form_dropdown($themedbs,false,'','','add_theme_db','none',false,'editcolor editbackground left'); 
		printer::alert(' ','',"$this->column_lev_color maxwidth500 floatleft editbackground"); 
		echo '</div><!--End form dropdown Post Positions-->';
		}
	
	$this->submit_button(); 
	 $this->show_close('importing theme page');//<!--Show More Post Choices-->';
	echo '</div><!--Import choices-->'; 
	
	}
function add_new_page($batch_create=false){ if (Sys::Quietmode) return; if (Sys::Pass_class)return;
	if (isset($_POST['create_page'])&&!empty($_POST['create_page'])){
		$newtitle=process_data::clean_title($_POST['create_page']);
		$newpage_ref=process_data::clean_filename($_POST['create_page']);
		$starterpage=(isset($_POST['use_newpage_ref']))?$_POST['use_newpage_ref']:'';
		$included_arr=array();
		$q="select distinct page_ref,page_filename from $this->master_page_table ";
		$r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
		while (list($page_ref,$page_filename) = $this->mysqlinst->fetch_row($r,__LINE__)){
			$included_arr[]=$page_ref;
			$starterpage=(empty($starterpage)&&$page_filename==='index')?$page_ref:$starterpage;
			}
		if (in_array($newpage_ref,$included_arr)){
			$msg="Your Title $newpage_ref has already been created. Use it and add it to your menu, delete it, or alter the name of your new page to distinguish it!";
			mail::alert($msg);
			$this->message[]=$msg;
			}
		else {
			file_generate::create_new_page($newpage_ref,$newtitle,$starterpage,$this->ext);
			$this->success[]="New Page has been Created. <a class=\"link\" href=\"$newpage_ref$this->ext\"><u>Go to $newtitle</u></a>";
			$url=$newpage_ref.$this->ext;
			}
		}
	if ($batch_create)return;
	if (isset($_POST['delete_page'])){
		$q="select distinct page_ref, page_title, page_filename from $this->master_page_table";  
		$r2 = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
		if ($this->mysqlinst->affected_rows()){   
			while (list($page_ref,$title,$filename) = $this->mysqlinst->fetch_row($r2,__LINE__)){ 
		 		if (isset($_POST['delete_page'][$filename])){ 
					$count=$this->mysqlinst->count_field($this->master_col_table,'col_id','',false, " where col_table_base='$page_ref'");
					if ($count<1){
						$q="Delete from $this->master_page_table where page_ref='$page_ref'";
						$r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
						if (!unlink(Cfg_loc::Root_dir.$filename.'.php')) 
							mail::alert(Cfg_loc::Root_dir.$filename.'.php not deleted');
						if (is_file($filename.'.php')){
							if (!unlink($filename.'.php')) 
								mail::alert($filename.'.php not deleted');
								$msg="Your Page $title Has Been Deleted";
								$this->success[]=$msg;
								mail::success($msg);
								}
							}
					else $this->message[]="Empty $title of Columns Before Deleting this Page";	
					}
				}//end while
			}//affected rows
		}//end delete page
	echo '<div class="inline floatleft"><!-- float buttons-->';
	$this->show_more('Add/Del a New Page to the Website','',$this->column_lev_color.'  smallest editpages editbackground button'.$this->column_lev_color,'',500 );
	echo '<div class="fsminfo Os3darkolivegreen maxwidth500 editbackground " >';
	$this->show_more('Delete Page','noback','neg smallest whitebackground','',500);
	echo '<div class="OsredAlert fsmredAlert pb50 pt10 editcolor editbackground floatleft left"><!--delet page-->';
	printer::alertx('<p class="left editcolor editbackground editfont">First Delete All Primary Columns in Page &#40;This Also Removes all Nested Columns and Post&#41; Within. Remove Your Page From Navigation Menus. Then Select Your Page For Deleting Here and Make Sure Your On a Different Page then the One You Wish To Delete!!</p>');
	$q="select distinct page_ref, page_title, page_filename from $this->master_page_table order by page_ref";  
	$r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	while (list($page_ref,$title,$filename) = $this->mysqlinst->fetch_row($r,__LINE__)){
		if ($page_ref=='setupmaster'||trim($filename)=='')continue;if ($filename=='index')
			echo '<p class="rs1redAlert">'.$title.' <span class="redAlert whitebackground smallest">This Page is Currently Your Opening Page Often referred to as Home page and You Need to Select a Different Opening Page before Deleting This Page.  Visit the Edit Links Under the Navigation Menu, go to Change your Opening/home page Link and then change Your Opening Page to a New Page Link</span></p>'; 
		elseif ($page_ref==$this->tablename)
			echo '<p class="rs1redAlert">'.$title.' <span class="redAlert whitebackground smallest">To Delete this Page Navigate to a Page Other than Itself!!!</span></p>'; 
		else echo '<p class="small"><input type="checkbox" name="delete_page['.$page_ref.']">&nbsp;<span class="neg whitebackground">page_ref: </span>'.substr($page_ref,0,23).'&nbsp;<span class="neg">title: </span>
		'.substr($title,0,23).'</p>'; 
		}
	echo '</div><!--delet page-->';
	$this->show_close('delet page');
	printer::pclear();
	echo '<fieldset class="redfield editbackground"><legend class="shadowoff editcolor ">Add Page</legend>';
	printer::alertx('<p class="'.$this->column_lev_color.' left editbackground editfont inline ">A Link for editing Your New Page Will Appear in the Editor but Will Not Appear in the Website till YOU ADD the link to a Page Navigation Menu. This way Make Changes to the page and not have it appear on the website till you are ready.  Create as many navigations menus on a page as you wish. Options for Creating Navigation Menus are found under the Choose Post Options in each Column</p>');
	printer::pclear(1);
	printer::alertx('<p class="information" title="The Title should express the basic idea, ie about, CONTACT, Photography, using one or more words!">Title name for Your New Page link: <textarea class="utility left" name="create_page" style="width:80%" rows="3" cols="50"   ></textarea></p>');
	
	printer::pclear(1);
	$indexfileref='';
	$included_arr=array();
	$q="select distinct page_ref, page_title, page_filename from $this->master_page_table order by page_title";
	$indexref=$indextitle='';
	$r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	while (list($page_ref,$title,$filename) = $this->mysqlinst->fetch_row($r,__LINE__)){
		if ($page_ref=='setupmaster')continue;   
		if ($filename=='index'){$indexref=$page_ref;$indextitle=$title;}
		$included_arr[]=array($page_ref,$title);
		}
	if (empty($indexref)){
		echo '</div></div>';
		printer::alert_neg("Proper filename for the index page not found",1);
		$q="select   page_id, page_title, page_filename from $this->master_page_table where page_filename like 'index%'";
		$r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
		if ($this->mysqlinst->num_rows($r)>0&&$this->mysqlinst->num_rows($r)<2){
			list($page_id,$page_title,$page_ref)=$this->mysqlinst->fetch_row($r);
			printer::alert_neg("Affecting repair setting  page title: $page_title and page id $page_id to the new home page with filename index with (.php) extenstion. Check navigation menus for proper home page",1);
			
			$q=" update $this->master_page_table set page_filename='index' where page_id='$page_id'";
			$r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
			}
		return;
		}
	printer::alertx('<p class="fsminfo editbackground '.$this->column_lev_color.'">New Pages Will Appear as a Link in the menu dropdown at the top of any page in editmode. When Your Page is Ready to Publish 
	add it in Whatever order you Wish to Any existing Navigation Menu  or create a new Navigation Post andand then add it</p>');
	 
	printer::alertx('<p class="fsminfo editbackground '.$this->column_lev_color.'">Choose a Starter Page for Your initial Config/Styles</p>'); 
	$count=count($included_arr);
	if($count>0){ 
		echo'<p> <select class="editcolor editbackground"  name="use_newpage_ref">';       
	    echo '<option  value="'.$indexref.'" selected="selected">'.$indextitle.'</option>';
		 for ($i=0;$i<count($included_arr);$i++){
			  echo '<option  value="'.$included_arr[$i][0].'">'.$included_arr[$i][1].'</option>';
			  }
	    echo'	
	    </select></p>';
		}
	
	printer::pclear(5);
	
	$this->submit_button(); 
	 echo '</fieldset><!--Add Page-->';
	echo '</div><!--Add Page RamanaBlock-->'; 
	 $this->show_close('Add Page');//<!--Show More Add Page-->'; 
	 echo '</div><!--float buttons-->';
	}
function view_page(){if (Sys::Quietmode) return;  
	echo '<div class="inline floatleft"><!-- float buttons-->';
	$this->navobj->return_url($this->tablename,'',$this->column_lev_color.'  shadowoff smallest button'.$this->column_lev_color);
	 echo '</div><!--float buttons-->';
	}
function leftover_view(){
	echo '<div class="inline floatleft" id="handle_leftovers" ><!-- float buttons-->';
	if(!isset($_SESSION[Cfg::Owner.'_'.$this->tablename.'_leftovers'])){
		echo '</div>';
		return;
		} 
		
	//printer::alert('<a href="#leftovers">Delete/Move Leftover Unclones</a>',false,'neg normal shadowoff smallest button'.$this->column_lev_color );
	 echo '</div><!--float buttons-->';
	}
function restore_backup(){if (Sys::Quietmode) return;  if (Sys::Pass_class)return;
	echo '<div class="inline floatleft"><!-- float buttons-->';
	$this->show_more('Restore Backups','',$this->column_lev_color.' smallest  editbackground button'.$this->column_lev_color,'',400);
	echo '<p class="info Os3darkslategray fsmyellow editbackground click" title="View and restore saved backedup databases Here" onclick="gen_Proc.use_ajax(\''.Sys::Self.'?display_backups\',\'handle_replace\',\'get\');" >Display Backup List</p>';
	printer::pclear();
	echo '<div id="display_backupst"></div>'; 
	$this->show_close('restore backups');
	echo '</div><!--float buttons-->';
	}
	
function browser_size_display(){if (!Sys::Info&&!$this->edit)return;
	$background=($this->edit)?'editbackground':'whitebackground';
	echo '<div class="inline floatleft button'.$this->column_lev_color.' rad5 smallest '.$background.' '.$this->column_lev_color.'"><!-- float buttons-->';
	
	printer::printx('<span id="displayCurrentSize" class=""></span><span class="smallest">Cookie-val:</span><span class="smallest red">'.$this->viewport_current_width.'</span>');
	echo '</div><!--float buttons-->';
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
		if (count($this->page_break_arr)>10){  
		    $msg='Error break points exceed 10';
		    $this->message[]=$msg;
		    $this->page_break_arr=explode(' ',Cfg::Column_break_points);
		    $this->page_br_points=Cfg::Column_break_points;
		    }
		else { 
		    $page_breakupdate_arr=array();
		    foreach($this->page_break_arr as $bp){ 
				if (is_numeric($bp)&&trim($bp) > 100){ 
					$page_breakupdate_arr[]=($bp); 
					}
				 else {  
					$msg='Error in Breakpoints: '.$bp.' breakpoints must be greater than 100';
					$this->message[]=$msg; 
					$this->page_break_arr=explode(',',Cfg::Column_break_points);
					$this->page_br_points=Cfg::Column_break_points; 
					break;
					}
				$this->page_break_arr=$page_breakupdate_arr;
				}//end foreach
			}//! greater than 
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
function configure(){if(Sys::Custom)return; if (Sys::Quietmode) return;
	$page_configs='RWD settings, Image Cache Sizes, Default Primary Column Width, Editor Colors, Styles, Page Slide Show settings';
	$this->is_page=true;//for styling
	echo '<div class="inline floatleft"><!-- float buttons-->';
	$this->show_more('Configure this Page','noback',$this->column_lev_color.' smallest editbackground button'.$this->column_lev_color,'',800);
	echo '<div class="editcolor fsminfo Os3darkolivegreen floatleft editbackground"><!--configure wrap-->'; 
	$this->show_more('Some Basic Pointers on the editor system','noback','','',800); 
     echo '<p class="editcolor fsmcolor editbackground"><br> 
	Configure a few general default styles in page options which  can be later changed as individiual columns and posts require!   
	<br>  
	To enable consistent navigation between pages it is a good idea to to set all your webpages to the same width, so that navigation menus line up in same place page to page.  All the standard website content is designed to fit within this main content container.  A common webpage size uses a width of about 1280px but more or less can be used although typically set the same for all pages in a website.  Use the Responsive Web Design setting for mobile and smaller screen fluid layouts.
	
	<br> 
	Make multiple changes on various posts, then Hit a Change All button below to submit them all at once.  
	<br> 
	-paste complex text from WORD or other editors into the post editor text box to retain spacing<br>
	-Typing  &amp;#169; will give the copyright symbol or Use (CR) including paranthesis <br></p>
	';
	$this->show_close('Some Basic Pointers on the editor system');
     
#pageops	 
	$this->show_more('Import/Export Page Options','noback','');
	printer::print_wrap('import page options','fsmcolor Os3darkslategray editbackground');
	
	echo '<div class="fsmcolor Os3darkslategray editbackground floatleft" ><!--import page defaults-->Import All the Page Level Settings ('.$page_configs.')  from Another Page. Will copy Editor Color Settings, Break Point Choices, Default Styles, Page Background, etc. Choose Page From Dropdown Menu.';  
	printer::pclear(1);
	 $included_arr=array();
	$q="select distinct page_ref, page_title, page_filename from $this->master_page_table";  
	$r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	while (list($page_ref,$title,$filename) = $this->mysqlinst->fetch_row($r,__LINE__)){
		 $included_arr[]=array($page_ref,$title);
		}
	 	 
		echo'<p> <select class="editcolor editbackground"  name="page_opts_import['.$this->page_ref.']">';       
	    echo '<option  value="none" selected="selected">Choose Page for Import of  All Options/Styles </option>';
		 for ($i=0;$i<count($included_arr);$i++){
			  echo '<option  value="'.$included_arr[$i][0].'">'.$included_arr[$i][1].'</option>';
			  }
		echo'	
		</select></p>';
		echo '</div><!--import page defaults-->'; 
		echo '<div class="fsmcolor Os3darkslategray editbackground left "><!--export-->Export All Page Settings ('.$page_configs.') from this Page to all other Pages';
		printer::printx( '<p class="editfont editcolor editbackground" ><input style="editcolor editbackground" name="page_opts_export['.$this->page_ref.']"  type="checkbox" value="'.$this->page_ref.'">Export All Page Level Settings to other Pages</p>'); 
		echo '</div><!--export-->'; 
	##########################################################
	    #############################################
	    echo '<div class="fsmcolor Os3darkslategray editbackground left "><!--import-->Import Page Width from another page. ';
	 	 
		echo'<p> <select class="editcolor editbackground"  name="page_width_import['.$this->page_ref.']">';       
	    echo '<option  value="none" selected="selected">Choose Page for Import of Page Width </option>';
		 for ($i=0;$i<count($included_arr);$i++){
			  echo '<option  value="'.$included_arr[$i][0].'">'.$included_arr[$i][1].'</option>';
			  }
	    echo'	
	    </select></p>';
		echo '</div>'; 
		echo '<div class="fsmcolor Os3darkslategray editbackground left "><!--export-->Export Page Width settings from this Page to all other Pages';
		printer::printx( '<p class="editfont editcolor editbackground" ><input style="editcolor editbackground" name="page_width_export['.$this->page_ref.']"  type="checkbox" value="'.$this->page_ref.'">Export this Page Width to other Pages</p>'); 
		echo '</div><!--export-->'; 
	###########################################################Begin  

		####################################################
		echo '<div class="fsmcolor Os3darkslategray editbackground left "><!--import-->Import RWD Grid Break Points from another page. ';
	 	 
		echo'<p> <select class="editcolor editbackground"  name="page_rwd_import['.$this->page_ref.']">';       
	    echo '<option  value="none" selected="selected">Choose Page for Import of RWD break point settings </option>';
		 for ($i=0;$i<count($included_arr);$i++){
			  echo '<option  value="'.$included_arr[$i][0].'">'.$included_arr[$i][1].'</option>';
			  }
	    echo'	
	    </select></p>';
		echo '</div>'; 
		echo '<div class="fsmcolor Os3darkslategray editbackground left "><!--export-->Export RWD Grid Break Points settings from this Page to all other Pages';
		printer::printx( '<p class="editfont editcolor editbackground" ><input style="editcolor editbackground" name="page_rwd_export['.$this->page_ref.']"  type="checkbox" value="'.$this->page_ref.'">Export this Page  RWD Grid Break Points to other Pages</p>'); 
		echo '</div><!--export-->'; 
		#######################################################
		echo '<div class="fsmcolor Os3darkslategray editbackground left "><!--import-->Import HTag and Class Special Styles from another page. ';
	 	 
		echo'<p> <select class="editcolor editbackground"  name="page_special_class_import['.$this->page_ref.']">';       
	    echo '<option  value="none" selected="selected">Choose Page for Import of HTag and Class Special Styles settings </option>';
		 for ($i=0;$i<count($included_arr);$i++){
			  echo '<option  value="'.$included_arr[$i][0].'">'.$included_arr[$i][1].'</option>';
			  }
	    echo'	
	    </select></p>';
		echo '</div>'; 
		echo '<div class="fsmcolor Os3darkslategray editbackground left "><!--export-->Export HTag and Class Special Styles from this Page to all other Pages';
		printer::printx( '<p class="editfont editcolor editbackground" ><input style="editcolor editbackground" name="page_special_class_export['.$this->page_ref.']"  type="checkbox" value="'.$this->page_ref.'">Export this Page HTag and Class Special Styles to other Pages</p>'); 
		echo '</div><!--export-->'; 
		######################################################
		echo '<div class="fsmcolor Os3darkslategray editbackground left "><!--import-->Import Editor Colors from another page. ';
	 	 
		echo'<p> <select class="editcolor editbackground"  name="page_editor_color_import['.$this->page_ref.']">';       
	    echo '<option  value="none" selected="selected">Choose Page for Import of Editor Colors settings </option>';
		 for ($i=0;$i<count($included_arr);$i++){
			  echo '<option  value="'.$included_arr[$i][0].'">'.$included_arr[$i][1].'</option>';
			  }
	    echo'	
	    </select></p>';
		echo '</div>'; 
		echo '<div class="fsmcolor Os3darkslategray editbackground left "><!--export-->Export Editor Colors from this Page to all other Pages';
		printer::printx( '<p class="editfont editcolor editbackground" ><input style="editcolor editbackground" name="page_editor_color_export['.$this->page_ref.']"  type="checkbox" value="'.$this->page_ref.'">Export this Page  Editor Colors to other Pages</p>'); 
		echo '</div><!--export-->'; 
		#######################################
		echo '<div class="fsmcolor Os3darkslategray editbackground left "><!--import-->Import Default Page styles from another page. ';
	 	 
		echo'<p> <select class="editcolor editbackground"  name="page_style_import['.$this->page_ref.']">';       
	    echo '<option  value="none" selected="selected">Choose Page for Import of Default Page Style settings </option>';
		 for ($i=0;$i<count($included_arr);$i++){
			  echo '<option  value="'.$included_arr[$i][0].'">'.$included_arr[$i][1].'</option>';
			  }
	    echo'	
	    </select></p>';
		echo '</div>'; 
		echo '<div class="fsmcolor Os3darkslategray editbackground left "><!--export-->Export Default Page styles from this Page to all other Pages';
		printer::printx( '<p class="editfont editcolor editbackground" ><input style="editcolor editbackground" name="page_style_export['.$this->page_ref.']"  type="checkbox" value="'.$this->page_ref.'">Export this Page  Default Page Styles to other Pages</p>'); 
		echo '</div><!--export-->';
		################################################
		echo '<div class="fsmcolor Os3darkslategray editbackground left "><!--import-->Import Image Cache Sizes from another page. ';
	 	 
		echo'<p> <select class="editcolor editbackground"  name="page_cache_import['.$this->page_ref.']">';       
	    echo '<option  value="none" selected="selected">Choose Page for Import of Image Cache Sizes </option>';
		 for ($i=0;$i<count($included_arr);$i++){
			  echo '<option  value="'.$included_arr[$i][0].'">'.$included_arr[$i][1].'</option>';
			  }
	    echo'	
	    </select></p>';
		echo '</div>'; 
		echo '<div class="fsmcolor Os3darkslategray editbackground left "><!--export-->Export Image Cache Sizes from this Page to all other Pages';
		printer::printx( '<p class="editfont editcolor editbackground" ><input style="editcolor editbackground" name="page_cache_export['.$this->page_ref.']"  type="checkbox" value="'.$this->page_ref.'">Export this Page Image Cache Sizes to other Pages</p>'); 
		echo '</div><!--export-->';
		#########################################################
	 		echo '<div class="fsmcolor Os3darkslategray editbackground left "><!--export-->Export Image Quality Setting from this Page to all other Pages';
		printer::printx( '<p class="editfont editcolor editbackground" ><input style="editcolor editbackground" name="page_image_quality_export['.$this->page_ref.']"  type="checkbox" value="'.$this->page_ref.'">Export this Page Export Image Quality to other Pages</p>'); 
		echo '</div><!--export-->';
		###########################################
		
		echo '<div class="fsmcolor Os3darkslategray editbackground left "><!--export-->Export the number of Backup Db copies from this Page to all other Pages';
		printer::printx( '<p class="editfont editcolor editbackground" ><input style="editcolor editbackground" name="page_dbbackups_export['.$this->page_ref.']"  type="checkbox" value="'.$this->page_ref.'">Export this Page Export the number of stored Backup Dbs to other Pages</p>'); 
		echo '</div><!--export-->';
		##############################################
	
	printer::close_print_wrap('import page options');
	$this->submit_button();
	printer::pclear(5);
	$this->show_close('Import Page Options');
	printer::pclear(2);
	 $this->configure_editor();
	 printer::pclear();
	//echo '<div class="fsminfo floatleft editcolor editbackground"><!--style wrapper-->';
	##############
	
	$this->show_more('Set Image Dir Cache Sizes','noback','');
	$msg='Change the default cache directory sizes for responsive image sizes here. <br>Directory sizes needed are calculated for each image and larger than necessary directories not filled to minimize server space required. More directory sizes means served images are more efficiently downloaded and decreases bandwidth. However, more sizes also means more server disk space is used to cache the images. Adjust the default balance here.  Note: Quality level also affects download speed and server space used and can be adjusted for the ideal balance with page defaults, but also on the configuaration for images, slideshows and galleries';
	echo '<div class="Os3darkslategray fsmcolor editbackground fsmcolor"><!--img cache-->';
	printer::printx('<p class="fsmnavy editbackground editcolor smaller">'.$msg.'</p>');
	printer::alertx('<p class="warnlite">Changes of this setting will apply to every page in the site and images will generated to fill any new cache directory sizes on all pages. This may take awhile, wait for all iframes to load before leaving this page.</p>',1.1);
	
	echo '<div class="fsmnavy editbackground info floatleft" title=" Be sure to enter numerical values separated by commas ie: '.Cfg::Image_response.'">Change Image Default Cache Dir Sizes <span class="editcolor small">(comma separate):</span> 
	<input type="text" value="'.$this->page_cache.'" name="page_cache"   size="50" maxlength="65">
	<input type="hidden" value="'.$this->page_cache.'" name="check_page_cache">';
	echo'</div>';
	printer::pclear();

	echo'</div><!--img cache-->';
	$this->show_close('Set Image Dir Cache Sizes');
	#######################
	$this->show_more('Set RWD Breakpoints','noback','');
	$msg='Breakpoints for the Responisive Web Page Design Grid are set Here, otherwise Default values are presented<br> Keeping this breakpoint setting consistent between pages enables using cloning moving and copying of rwd columns between pages without resetting the rwd chosen width percentages in posts on the receiving page';
	echo '<div class="Os3darkslategray fsmcolor editbackground fsmcolor"><!--break points-->';
	printer::printx('<p class="fsmnavy editbackground editcolor smaller">'.$msg.'</p>');
	echo '<div class="fsmnavy editbackground info floatleft" title="The RWD system uses 1 to 10 max-width break points for user Device Screen Size to Deliver appropriate sized content. Be sure to enter numerical values separated by a comma ie: '.Cfg::Column_break_points.'. 10 break point max. Min size bp 101">Change Default Break Points <span class="editcolor small">(comma separate):</span> 
	<input type="text" value="'.$this->page_br_points.'" name="page_break_points"   size="20" maxlength="40">';
	
	echo'</div>';
	printer::pclear();
	echo'</div><!--break points-->';
	$this->show_close('Set RWD Breakpoints');
	$this->show_more('Tune RWD Breakpoints','noback','');
	$msg='If you have already set-up  RWD grid percentages and wish to maintain the settings but change a bp value then here its possible to Tune the Value of a Breakpoint for a New Value Without Disturbing the current RWD Grid settings. Also choose the sitewide option to adjust bps to all other pages for consistent rendering across pages. Adjustments should also follow descending order when multiple bps are used';
	echo '<div class="Os3darkslategray fsmcolor editbackground fsmcolor"><!--fix break points-->';
	printer::print_tip($msg);
	echo '<div class="fsmnavy editbackground editcolor floatleft"><!--wrap change bp-->Enter Changes for New  Break Point Adjust';
	foreach ($this->page_break_arr as $bp){
		echo '<p>Previous Value:'.$bp.'
	<input type="text"  name="page_adjust_break_points['.$bp.']"   size="4" maxlength="4" value="'.$bp.'">';
		}//end foreach
	printer::pclear();
	echo '<p class="fsm'.$this->column_lev_color.'"><input type="radio" name="page_sub_bp" value="page" checked="checked">Substite Break Point(s) this page<br>
		<input type="radio" name="page_sub_bp" value="site"><span class="info" title="make this change on all pages to keep breaks consistent for cloning, copying and moving options">Substite Break Point(s) on All Pages</span></p>';
		
	echo'</div><!--wrap change bp-->';
	printer::pclear();
	echo'</div><!--fix break points-->';
	
	$this->show_close('Change RWD Breakpoints');
	
	$msg='Borders and Box shadows will only affect the current element ie. never inherited whereas Text and Background Styles  are. <br>  Inherited styles set here mean that you do not have set them again in Columns and Posts unless you wish them to be different. Many more styling choices are available in each post. Border choices include choosing top border only';
	$this->edit_styles_close('body','page_style','body.'.$this->tablename,'background,font_color,text_shadow,font_family,font_size,borders','Set Main Background and Page Default Text Styles','noback',$msg);
	$this->show_more('Add Full Page background Slide Show');
	$msg="Enable or disable a Full Page Background slide Show Here and make posts as required";
	echo '<div class="Os3darkturquoise fsmcolor editbackground '.$this->column_lev_color.'">'.$msg;
	if ($this->page_options[$this->page_slideshow_index]!=='enable_page_slideshow'){
		printer::printx('<p class="editcolor"><input type="checkbox" name="page_options['.$this->page_slideshow_index.']" value="enable_page_slideshow">Enable Page Auto Slide Show</p>');
		
		}
	elseif ($this->page_options[$this->page_slideshow_index]==='enable_page_slideshow'){
		printer::printx('<p class="editcolor"><input type="checkbox" name="page_options['.$this->page_slideshow_index.']" value="0">Disable Page Auto Slide Show</p>'); 
		}
	echo '</div>';
	
	$this->show_close('Add Full Page background Slide Show');
	
	 $msg='Group styles are a quick way to style  group of posts and style them &#34;Group Styles&#34; provide a quick means to select consecutive posts within a Column to distinguish them as related such as a simple border or background color.   You begin by checking the begin box on the first post and end box on the last post you wish to style!  Make any number of groups within a column and they will all have the styles you set Here!!  Style borders or box shadows,  background colors, background images, etc. Padding spacing changes made here will increase spacing between posts and borders if used!.  Begin by checking the begin box on the first non column post and check the end box on the last non-column post you wish to distinguish within the same column! Using RWD within the column (as opposed to the whole  or floating within the same with group borders can cause anomolies.  Span column posts between open and close tags as needed.  Match with a close groupstyle before beginning with a new one in the same column.  Unmatched open border and close border checked options will generate an alert mesage and can mess up the webpage styling.   Check both boxes on the same post to end an group and begin another group or to wrap a single post, the system will determine which one is intendted as long as your consistent with closing every opening  ';
	$this->show_more('Style Group, Date, and Comment Styles','noback'); 
	 echo '<div class="editbackground editcolor Os3darkslategray fsmcolor"><!--inner style wrapper-->'; 
	printer::printx('<p class="fsminfo editbackground editcolor">Group Styles are a quick way to wrap several posts with Style. Set default Group, Comments and date styles Here and Adjust as necessary with column specific options for the same.  </p>');
	 $this->edit_styles_close('body','page_grp_bor_style','body.'.$this->tablename.' .style_groupstyle','background,padding_top,padding_bottom,padding_left,padding_right,margin_top,margin_bottom,margin_left,margin_right,borders,box_shadow,outlines,radius_corner,font_color,text_shadow,font_family,font_size,font_weight,text_align,text_shadow,letter_spacing,italics_font,small_caps,text_underline','Set &#34;Group Styles&#34;',false,$msg);
	 
	$this->edit_styles_close('body','page_comment_style', 'body.'.$this->tablename.' .posted_comment','','Style Overall Comment Entries',false,'Comment Styles will affect all comment post feedback styles for posts made directly in this column');	
	$this->edit_styles_close('body','page_date_style', 'body.'.$this->tablename.'  .style_date','','Style Post Date Entries',false,'Date Styling Affects Posts within this Column (And within any nested columns unless set there) with Show Post Date Enabled');
	$this->edit_styles_close('body','page_comment_date_style', 'body.'.$this->tablename.' .style_comment_date','','Style Comment Date Entries',false,'Comment Date Styling Affects Comments within this Column (And within any nested columns unless set there)');
	$this->edit_styles_close('body','page_comment_view_style', 'body.'.$this->tablename.' .style_comment_view','','Style #/view/Leave Comments',false,'Style the #of Comments  and View/Leave Comments Link');
	 
	#options
	list($fdate,$val,$num)=$this->format_date();
	$this->show_more('Choose/Style Date Format','noback');
	echo '<div class="editcolor editbackground"><!--displaydate div-->';
	printer::printx('<p >Choose a date format</p>');
	echo '<div class="style_date"><!--displaydate custom style-->';
	 
	for ($i=0; $i<$num; $i++){
		$checked=($i==$this->page_options[$this->page_date_format_index])?'checked="checked"':'';
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
	
	$this->edit_styles_close('body','page_style_day', 'body.'.$this->tablename.' .style_day','','Additional Style Day in Date',false,'Additionally style    the day in your chosen date format');
	$this->edit_styles_close('body','page_style_month', 'body.'.$this->tablename.'  .style_month','','Additional Style Month in Date',false,'Additionally style the Month in your chosen date format');
	echo '</div><!--additional styling options-->';
	
	echo '</div><!--displaydate div-->';
	$this->show_close('Choose/Style Date Format');
	echo '</div><!--inner style wrapper-->';
	$this->show_close('Style Group,Date, and Comment Styles');
	####################
	$this->show_more('Style H-Tags and Special Classes','noback'); 
	 echo '<div class="editbackground editcolor Os3darkslategray fsmcolor"><!--inner style wrapper-->';
	 if(is_file(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'css_data_sheet_'.$this->tablename.$this->passclass_ext)){
		$this->render_view_css=unserialize(file_get_contents(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'css_data_sheet_'.$this->tablename.$this->passclass_ext)); 
		$this->show_more('View Current Tag and Class Styles');
		printer::array_print($this->render_view_css); 
		$this->show_close('View Current Tag and Class Styles');
		}
	else $this->render_view_css='';
	printer::printx('<p class="fsminfo editbackground editcolor">Style H tags ad class styles here which will be in affect page wise.</p>');
	
	 $msg='Set style HR tags.  HR can be placed anywhere in text and the styles you set here will be expressed. HR are theme breaks, typically bordered lines with spacing. HR Styles may changed in individual column Settings';
	    $this->edit_styles_close('bodyview','page_hr','.'.$this->tablename.' hr','width_special,width_percent_special,width_max_special,width_min_special,background,padding_top,padding_bottom,padding_left,padding_right,margin_top,margin_bottom,margin_left,padding_left_percent,padding_right_percent,margin_left_percent,margin_right_percent,borders,box_shadow,outlines,radius_corner','Set HR Tags','noback',$msg);
	 $htag_styles='width_special,width_percent_special,width_max_special,width_min_special,float,background,padding_top,padding_bottom,padding_left,padding_right,margin_top,margin_bottom,margin_left,margin_right,padding_left_percent,padding_right_percent,margin_left_percent,margin_right_percent,borders,box_shadow,outlines,radius_corner,font_color,text_shadow,font_family,font_size,font_weight,text_align,text_shadow,line_height,letter_spacing,italics_font,small_caps,text_underline';
	 $msg='Set style H1 tags. H tags in general can be placed anywhere in text and the styles you set here will be expressed.';
	    $this->edit_styles_close('bodyview','page_h1','.'.$this->tablename.' div h1',$htag_styles,'Set H1 Tags','noback',$msg);
	    $msg='Set style H2 tags.  H tags in general can be placed anywhere in text and the styles you set here will be expressed.';
	    $this->edit_styles_close('bodyview','page_h2','.'.$this->tablename.' div h2',$htag_styles,'Set H2 Tags','noback',$msg);
	    $msg='Set style H3 tags.  H tags in general can be placed anywhere in text and the styles you set here will be expressed.';
	    $this->edit_styles_close('bodyview','page_h3','.'.$this->tablename.' div h3',$htag_styles,'Set H3 Tags','noback',$msg);
	    $msg='Set style H3 tags.  H tags in general can be placed anywhere in text and the styles you set here will be expressed.';
	    $this->edit_styles_close('bodyview','page_h4','.'.$this->tablename.' div h4',$htag_styles,'Set H4 Tags','noback',$msg);
	    $msg='Set style H5 tags.  H tags in general can be placed anywhere in text and the styles you set here will be expressed.';
	    $this->edit_styles_close('bodyview','page_h5','.'.$this->tablename.' div h5',$htag_styles,'Set H5 Tags','noback',$msg);
	    $msg='Set style H6 tags.  H tags in general can be placed anywhere in text and the styles you set here will be expressed.';
	    $this->edit_styles_close('bodyview','page_h6','.'.$this->tablename.' div h6',$htag_styles,'Set H6 Tags','noback',$msg);
	    $msg='Set a custom class to style a div p  or span style or instead it can be used to style a hr tag (typically for lines) ie.  text styles will not apply.'; 
	    $this->edit_styles_close('bodyview','page_myclass1','.'.$this->tablename.' .myclass1',$htag_styles,'Set Class myclass1 Styles','noback',$msg); 
	    $this->edit_styles_close('bodyview','page_myclass2','.'.$this->tablename.'  .myclass2',$htag_styles,'Set Class myclass2 Styles','noback',$msg); 
	    $this->edit_styles_close('bodyview','page_myclass3','.'.$this->tablename.'  .myclass3',$htag_styles,'Set Class myclass3 Styles','noback',$msg); 
	    $this->edit_styles_close('bodyview','page_myclass4','.'.$this->tablename.' .myclass4',$htag_styles,'Set Class myclass4 Styles','noback',$msg); 
	    $this->edit_styles_close('bodyview','page_myclass5','.'.$this->tablename.' .myclass5',$htag_styles,'Set Class myclass5 Styles','noback',$msg); 
	    $this->edit_styles_close('bodyview','page_myclass6','.'.$this->tablename.' .myclass6',$htag_styles,'Set Class myclass6 Styles','noback',$msg); 
	    $this->edit_styles_close('bodyview','page_myclass7','.'.$this->tablename.' .myclass7',$htag_styles,'Set Class myclass7 Styles','noback',$msg); 
	    $this->edit_styles_close('bodyview','page_myclass8','.'.$this->tablename.' .myclass8',$htag_styles,'Set Class myclass8 Styles','noback',$msg); 
	    $this->edit_styles_close('bodyview','page_myclass9','.'.$this->tablename.' .myclass9',$htag_styles,'Set Class myclass9 Styles','noback',$msg);  
	    $this->edit_styles_close('bodyview','page_myclass10','.'.$this->tablename.' .myclass10',$htag_styles,'Set Class myclass10 Styles','noback',$msg); 
	    $this->edit_styles_close('bodyview','page_myclass11','.'.$this->tablename.' .myclass11',$htag_styles,'Set Class myclass11 Styles','noback',$msg); 
	    $this->edit_styles_close('bodyview','page_myclass12','.'.$this->tablename.' .myclass12',$htag_styles,'Set Class myclass12 Styles','noback',$msg);
	$this->submit_button();
	echo '</div><!--inner style wrapper-->';
	$this->show_close('Style H-Tags and Special Classe');
	##############################333
	$this->show_more('Style A Links');
	printer::print_wrap('alinks','Os3salmon fsmaqua');
	$msg="Style default text link styles here .";
	printer::print_tip($msg);
	$this->edit_styles_close('body','page_link', 'body A:LINK,body A:visited','font_family,font_weight,font_color,text_shadow,letter_spacing,italics_font,small_caps,text_underline','Style Text Links');
	printer::close_print_wrap('alinks');
	$this->show_close('Style A Links');
	
	$this->show_more('Maintenance');
	printer::print_wrap('maintenance');
	#################
	$msg='Generate any missing page files, editfiles, icons, folders etc. for this website';
	printer::print_wrap('file gnerate','fsmpos');
	printer::print_tip($msg);
	echo '<p class="caution white fsmsalmon"><input type="checkbox" name="file_generate_site" value="1" >Generate Files</p>';
	 
	printer::close_print_wrap('file gnerate');
	####################
	printer::print_wrap('regen_backup_table','fsmredAlert');
	$msg='Regenerates the backup database. Will recompile list of all stored backup gzipped sql files and delete old files in excess of '.$this->backup_copies. ' (Stored Db gz Copies Setting may be changed in the page_configurations or the setting default in the Cfg file';
	printer::print_tip($msg);
	echo '<p class="caution white fsmsalmon"><input type="checkbox" name="regen_backup_table" value="1">Re-Generate Backup database Files</p>';
	 
	printer::close_print_wrap('regen_backup_table');
	
	###############################
	$msg='Allowing for all pages to update any caches, style css files, or flat files that may have escapted proper updating. Runs all pages in editmode in iframes';
	printer::print_wrap('iframe all','fsmredAlert');
	printer::print_tip($msg);
	echo '<p class="caution white fsmsalmon"><input type="checkbox" name="page_iframe_all" value="1" onchange="edit_Proc.oncheck(\'page_iframe_all\',\'Checking Here for Maintenance only. All edit-mode pages will be generated in Iframes and this will take a Long Time to Finish, Uncheck to Cancel\')" >Generate all Css,Page Flat Files, etc. for all Edit Mode Pages in Iframes</p>';
	echo '<p title="Navigating to bottom of Iframe Quickly allows for a check of any error message" class="info  whitebackground fsmsalmon"><input type="checkbox" name="iframe_bottom" value="1">Nav to Iframe Bottom</p>';
	printer::close_print_wrap('iframe all');
	$this->submit_button();
	$msg='Generate all Webpages in iframes (non-edit mode) to quickly check for any errors or intitate custom query';
	printer::print_wrap('iframe all_website','fsmgreen');
	printer::print_tip($msg);
	echo '<p class="infobackground white fsmsalmon"><input type="checkbox" name="page_iframe_all_website" value="1">Quick Check, etc. all web-mode pages in iframes</p>';
	echo '<p title="Navigating to bottom of Iframe Quickly allows for a check of any error message" class="info  whitebackground fsmsalmon"><input type="checkbox" name="iframe_bottom" value="1">Nav to Iframe Bottom</p>';
	printer::close_print_wrap('iframe all');
	
	
	
	$this->submit_button();
	$msg='Remove all cached Images and flat files then Re-Generate. Will removed all Images from posts that have been deleted and save disk space.';
	printer::print_wrap('cache regen','fsmredAlert');
	printer::print_tip($msg);
	printer::printx('<p class="redAlert small whitebackground fsmredAlert">Caution: All images will be re-generated from uploads folder images.  Any missing uploads folder images and image will not be re-generated</p>');
	echo '<p class="redAlertbackground white fsmnavy"><input type="checkbox" name="cache_regenerate" value="1" onchange="edit_Proc.oncheck(\'cache_regenerate\',\'Checking Here for Maintenance only. All image caches will be removed then regenerated in Iframes. This will take a Long Time to Finish, Uncheck to Cancel\')" >Remove and Regenerate all Image Caches, Page Flat Files & Generate Css.  Utilizes Iframes</p>';
	printer::close_print_wrap('cache regen');
	$this->submit_button();
	$msg='Remove all flat files then Re-Generate. .';
	printer::print_wrap('cache regen','fsmredAlert');
	printer::print_tip($msg);
	
	echo '<p class="caution white fsmsalmon"><input type="checkbox" name="cache_regenerate_flatfiles" value="1"  >Remove and RegGenerate all Page Flat Files & Generate Css.  Utilizes Iframes</p>';
	echo '<p title="Navigating to bottom of Iframe Quickly allows for a check of any error message" class="info  whitebackground fsmsalmon"><input type="checkbox" name="iframe_bottom" value="1">Nav to Iframe Bottom</p>';
	printer::close_print_wrap('cache regen');
	$this->submit_button();
	printer::close_print_wrap('maintenance');
	$this->show_close('Maintenance');
	printer::pclear(5); 
	
	//$this->edit_metadata();
	$this->is_page=false;
	$this->submit_button('SUBMIT ALL'); 
	echo '</div><!--configure wrap-->';  
	 $this->show_close('More Configure');//<!--End Show More Configure-->
	 echo '</div><!--float buttons-->';
	}
 		

function full_nav(){ if (Sys::Quietmode) return;  
	echo '<div class="inline floatleft"><!-- float buttons-->';
	$this->show_more('Full Pages Navigation','','navr2 smallest','',400);
	echo '<div class="fsminfo Os3darkolivegreen editbackground editcolor editfont" style="padding-left:30px;">';
	printer::alertx('<p class="tip">This is a full navigation list to edit created pages whether published yet or not. </p>');
	$q="select distinct page_ref, page_title, page_filename from $this->master_page_table  order by page_title ASC";  
	$r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); 
	while (list($page_ref,$title,$filename) = $this->mysqlinst->fetch_row($r,__LINE__)){
		if (trim($filename)=='')continue;
		echo '<span ><a class="alink editcolor editbackground" href="'.$filename.$this->ext.'">'.$title.'</a></span><br>'; 
		} 
	echo '</div><!--full nav -->';
	$this->show_close('full pages nav'); 
	echo '</div><!-- float buttons--><!--full nav editbackground-->'; 
	}//end full nav
	
function left($style, $val, $field){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	$this->abs_spacing($style,$val,'left','Left Spacing','Position Left Dropdown Menus or other Absolute postioned elements');
	}
function right($style, $val, $field){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	$this->abs_spacing($style,$val,'right','Right Spacing','Position from Right Dropdown Menus or other Absolute postioned elements');
	}
	function top($style, $val, $field){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	$this->abs_spacing($style,$val,'top','Top Spacing','Position from Top Dropdown Menus or other Absolute postioned elements');
	}
	function bottom($style, $val, $field){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	$this->abs_spacing($style,$val,'bottom','Bottom Spacing','Position from Bottom Absolute postioned elements');
	}
	
function abs_spacing($style,$val,$css_class,$msg,$title){
	$maxspace=500;
	$size=(is_numeric($this->{$style}[$val])&&$this->{$style}[$val]<=$maxspace&&$this->{$style}[$val]>=0)?$this->{$style}[$val]:'None'; 
		#all values will be store as px
	 
	$sizepx=($size !=='None')?$this->{$style}[$val].'px':$size;
	 
	 	echo '
	    <div class="floatleft editbackground editcolor editfont fs1color  left"> <span class="info" title="'.$title.'" >'.$msg.'</span>: Currently '.$sizepx
	    .'<br>';
		$unit1='px';
		$msgjava='Choose px Spacing:'; 
		$factor=1;
		$unit2=''; 
		$spacing='simple'; 
		echo '<div class="editcolor editbackground editfont click" onclick="gen_Proc.precisionAdd(this,\''.$style.'['.$val.']\',0,\''.$maxspace.'\',\''.$size.'\',\''.$unit1.'\',\''.$factor.'\',\''.$msgjava.'\',\''.$unit2.'\',\''.$spacing.'\');">Choose Spacing:</div>';
		 
		   
	echo'  </div>';
	printer::pclear(1);
	    
	 	
	$final=$sizepx.';';
	$fstyle='final_'.$style; 
    $this->{$fstyle}[$val]=($sizepx==='None')?'':$css_class.':'.$final;
    }//end function
    
    
	
function font_size($style, $val, $field){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	if ($this->is_page|| ($this->is_blog&&!$this->is_clone)||($this->is_column&&!$this->is_clone||$this->clone_local_style)){ 
		$this->myarray3[]=$style;
		$msg= (empty($this->{$style}[$val]))? 'None ': $this->{$style}[$val];
		$chosen=(!empty($this->{$style}[$val])&&is_numeric($this->{$style}[$val]))?$this->{$style}[$val]:0;
		echo '
		<div class="fsminfo editbackground '.$style.'_hidefont" style="display:none;"><!-- font-->';
		echo'<p class="'.$this->column_lev_color.' editbackground editfont">Font Size: Currently '.$msg.'em<br>
		Choose:
		<select class="editcolor editbackground"  name="'.$style.'['.$val.']" id="'.$style.'_'.$val.'">        
		<option  value="'.$chosen.'" selected="selected">'.$this->{$style}[$val].'</option>';
		echo '<option  value="0">choose none</option>';
		for ($i=.5; $i<4.6; $i+=.1){
			if ($i<1.01&&$i>.95)echo '<option  value="'.$i.'">'.$i.'em normal default </option>';
			else echo '<option  value="'.$i.'">'.$i.'em</option>';
			}
		  echo'	
	    </select>';
	     echo'
	    </p></div><!-- font-->';
	    }
   $pxsize=(!empty($this->{$style}[$val])&&is_numeric($this->{$style}[$val]))?$this->{$style}[$val]*16:16;
	$unit='px;';
	  $fstyle='final_'.$style; 
    $this->{$fstyle}[$val]=(!empty($this->{$style}[$val]))?'font-size:'.$pxsize.$unit:'0';
   
    }   
	
function width_special($style,$val,$field){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	
	$wid=(!empty($this->{$style}[$val])&&is_numeric($this->{$style}[$val])&&$this->{$style}[$val]>0)?$this->{$style}[$val]:'none';
	$widunit=($wid==='none')?$wid:$this->{$style}[$val].'px';
	$maxspace=1000;
	$minspace=0;
	$this->show_more('Class Width', 'noback','editfont editbackground infoclick',' Choose Your Width Special',500);
	printer::print_wrap('widthspecialwrap','Os3salmon fsminfo floatleft editbackground editcolor');
	printer::alertx('<p class="'.$this->column_lev_color.' editbackground editfont">Choose PX width <br>Current Width: '.$widunit.'<br> Use 0 to remove if needed</p>');
	$msgjava='Set Width in px:';
	echo '<div class="editcolor editfont editbackground click" onclick="gen_Proc.precisionAdd(this,\''.$style.'['.$val.']\',0,\''.$maxspace.'\',\''.$wid.'\',\'px\',\'1\',\''.$msgjava.'\',\'\');">Set Width in px</div>';
	printer::pclear(8);
	printer::close_print_wrap('widthspecialwrap');
	$this->show_close('Special Width');
	$fstyle='final_'.$style; 
     $this->{$fstyle}[$val]=(is_numeric($this->{$style}[$val])&&$this->{$style}[$val]>0)?'width:'.$this->{$style}[$val].'px;':'';
  }
  
function width_percent_special($style,$val,$field){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	$wid=(!empty($this->{$style}[$val])&&is_numeric($this->{$style}[$val])&&$this->{$style}[$val]>0&&$this->{$style}[$val]<101)?$this->{$style}[$val]:'none';
	$widunit=($wid==='none')?$wid:$this->{$style}[$val].'%';
	$maxspace=100;
	$minspace=0;
	$this->show_more('Class Width Percent','noback','editfont editbackground infoclick','Percent set in width',500);
	printer::print_wrap('maxwidthspecialwrap','Os3salmon fsminfo floatleft editbackground editcolor');
	printer::alertx('<p class="'.$this->column_lev_color.' editbackground editfont">Choose % width <br>Current width Percent: '.$widunit.'<br> Use 0 to remove if needed</p>');
	$msgjava='Set Width in %:';
	echo '<div class="editcolor editfont editbackground click" onclick="gen_Proc.precisionAdd(this,\''.$style.'['.$val.']\',0,\''.$maxspace.'\',\''.$wid.'\',\'%\',\'1\',\''.$msgjava.'\',\'\');">Set width in %</div>';
	printer::pclear(8);
	printer::close_print_wrap('widthspecialwrap');
	$this->show_close('Special Max Width');
	$fstyle='final_'.$style; 
     $this->{$fstyle}[$val]=(is_numeric($this->{$style}[$val])&&$this->{$style}[$val]>0)?'width:'.$this->{$style}[$val].'%;':'';
  }
  
function width_max_special($style,$val,$field){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	$wid=(!empty($this->{$style}[$val])&&is_numeric($this->{$style}[$val])&&$this->{$style}[$val]>0)?$this->{$style}[$val]:'none';
	$widunit=($wid==='none')?$wid:$this->{$style}[$val].'px';
	$maxspace=1000;
	$minspace=0;
	$this->show_more('Class Max-Width','noback','editfont editbackground infoclick','Max-Width width',500);
	printer::print_wrap('maxwidthspecialwrap','Os3salmon fsminfo floatleft editbackground editcolor');
	printer::alertx('<p class="'.$this->column_lev_color.' editbackground editfont">Choose PX width <br>Current Max-width: '.$widunit.'<br> Use 0 to remove if needed</p>');
	$msgjava='Set Max-Width in px:';
	echo '<div class="editcolor editfont editbackground click" onclick="gen_Proc.precisionAdd(this,\''.$style.'['.$val.']\',0,\''.$maxspace.'\',\''.$wid.'\',\'px\',\'1\',\''.$msgjava.'\',\'\');">Set max-width in px</div>';
	printer::pclear(8);
	printer::close_print_wrap('widthspecialwrap');
	$this->show_close('Special Max Width');
	$fstyle='final_'.$style; 
     $this->{$fstyle}[$val]=(is_numeric($this->{$style}[$val])&&$this->{$style}[$val]>0)?'max-width:'.$this->{$style}[$val].'px;':'';
  }		
function width_min_special($style,$val,$field){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	$wid=(!empty($this->{$style}[$val])&&is_numeric($this->{$style}[$val])&&$this->{$style}[$val]>0)?$this->{$style}[$val]:'none';
	$widunit=($wid==='none')?$wid:$this->{$style}[$val].'px';
	$maxspace=1000;
	$minspace=0;
	$this->show_more('Class Min-Width','noback','editfont editbackground infoclick','Min-Width width',500);
	printer::print_wrap('minwidthspecialwrap','Os3salmon fsminfo floatleft editbackground editcolor');
	printer::alertx('<p class="'.$this->column_lev_color.' editbackground editfont">Choose PX width <br>Current min-width: '.$widunit.'<br> Use 0 to remove if needed</p>');
	$msgjava='Set min-width in px:';
	echo '<div class="editcolor editfont editbackground click" onclick="gen_Proc.precisionAdd(this,\''.$style.'['.$val.']\',0,\''.$maxspace.'\',\''.$wid.'\',\'px\',\'1\',\''.$msgjava.'\',\'\');">Set min-width in px</div>';
	printer::pclear(8);
	printer::close_print_wrap('widthspecialwrap');
	$this->show_close('Special Min Width');
	$fstyle='final_'.$style; 
     $this->{$fstyle}[$val]=(is_numeric($this->{$style}[$val])&&$this->{$style}[$val]>0)?'min-width:'.$this->{$style}[$val].'px;':'';
	}
	
function width($style,$val){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__); 
     echo'  <div class="floatleft">';
	// $wid=$this->{$style}[$val]= (empty($this->{$style}[$val]))?'none':((is_numeric($this->{$style}[$val])&&$this->{$style}[$val]<=$this->column_net_width)?$this->{$style}[$val]:$this->column_net_width);
	$maxspace=$this->column_net_width[$this->column_level];
	$wid=$this->{$style}[$val]=(!empty($this->{$style}[$val])&&is_numeric($this->{$style}[$val])&&$this->{$style}[$val]<=$maxspace)?$this->{$style}[$val]:'';
	$percent =(empty($wid))?'':'&#40;'.(intval(ceil($wid*10)/10)).'%&#41;'; 
	$px=(empty($wid))?'Full Width Avail':(intval(ceil($wid*$this->column_net_width[$this->column_level]/10)/10)).'px';
 	printer::alertx('<p class="info editbackground editfont" title="The Column Width less its margins and paddings sets the Upper Limit for Post Width. Optionally set a narrower Post Width if required (does not effect other posts in this Column). The total width Available for your actual content such as text or an images will be narrowed by values of padding and margin styles made in this post styles">Max Width Available: <span class="editcolor editbackground">'.(intval(ceil($this->column_net_width[$this->column_level]*10)/10)).'px</span></p>');
	
	printer::alertx('<p class="info editbackground editfont" title="The Post width + spacing, borders,etc. will take up 100% of the column width if no limiting width value is chosen! Limit the width if required.  Both the percentage available of the parent column width and the px value that your selection represents will be shown">This Post Amount Used: <span class="editcolor editbackground">: '.$px.'   '.$percent.'</span></p>');
	printer::alertx('<p class="editcolor editbackground" ></p>');
	printer::pclear();
	if (!Cfg::Spacings_off){
		echo '  <select class="editcolor editbackground"  name="'.$style.'['.$val.']" id="'.$style.'_'.$val.'">        
		<option class="editcolor editbackground editfint" value="'.$wid.'" selected="selected">'.$px.'   '.$percent.'</option>';
		if ($maxspace<=150){
			 for ($i=0; $i<=$maxspace; $i+=1){
				echo '<option  value="'.($i/$this->column_net_width[$this->column_level]*100).'">'.$i.'px  ('.(ceil($i/$this->column_net_width[$this->column_level]*1000)/10).'%)</option>';
			    }
			}
		else {
			$i=0;
			foreach (array(100 =>5,300=>5,$maxspace=>5) as $max =>$inc){
				$max=min($max,$maxspace);
				while ($i <= $max){
					 echo '<option  value="'.($i/$this->column_net_width[$this->column_level]*100).'">'.$i.'px  ('.(ceil($i/$this->column_net_width[$this->column_level]*1000)/10).'%)</option>';
					if ($i < $maxspace && ($i+$inc)>$maxspace) $i=$maxspace;
					else $i=$i+$inc;
					if ($i >$maxspace)continue;
					}
				if ($i > $maxspace)continue;
				}
			}
		    echo'	
			</select>';
			}//!Spacings_off
	printer::pclear();
	if ($maxspace > 250){
		$msgjava='Set Custom Width:';
		$factor=$this->column_net_width[$this->column_level]/100;
		echo '<div class="editcolor editfont editbackground click" onclick="gen_Proc.precisionAdd(this,\''.$style.'['.$val.']\',0,\''.$maxspace.'\',\''.$px.'\',\'px\',\''.$factor.'\',\''.$msgjava.'\',\'%\');">Set Custom Width</div>';
			
			} 
	
	  
     echo '</div><!--width-->';  
	 
	 $fstyle='final_'.$style; 
     $this->{$fstyle}[$val]=(is_numeric($this->{$style}[$val])&&!empty($this->{$style}[$val]))?' width: '.$this->{$style}[$val].'%;':'';
  }
   
   
function spacing($style,$val,$css_class,$msg,$title,$hide='',$ifempty='',$showpercent=false,$field=''){ if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	#show_percent true for mar/pad left/right
	$type=($this->is_page)?'page':(($this->is_column)?'column':'blog');
	 
	$use_percent=false;
	$maxspace=($this->is_page&&$showpercent)?$this->page_width:(($showpercent)?$this->column_total_width[$this->column_level]:500);//limit width
	$this->{$style}[$val]=(is_numeric($this->{$style}[$val])&&$this->{$style}[$val]<=$maxspace&&$this->{$style}[$val]>=0)?$this->{$style}[$val]:0; 
		#all values will be store as px
		#percent will be calculated for overall post size using post width...
	($this->is_page)&&$showpercent=false;	 
	$sizepx=$this->{$style}[$val].'px'; 
	$percent=($showpercent)?(ceil($this->{$style}[$val]*100/$this->column_total_width[$this->column_level]*10)/10):''; 
	$current=($showpercent)?$sizepx.'  ('.$percent.'%)':$sizepx;
	$size=$sizepx; 
	$class=(!empty($hide))?$hide:''; 	 
	 
		echo '
	    <div class="floatleft editbackground editcolor editfont fs1color '.$class.' left"> <span class="information" title="'.$title.'" >'.$msg.'</span>: Currently '.$current.'<br>';
		$unit1='px';
		$msgjava='Choose px Spacing:'; 
		$factor=(!$this->is_page)?$this->current_total_width/100:'';
		$unit2=($showpercent)?'%':''; 
		$spacing=($showpercent)?'convertboth':'simple';
		#change spacing Sept 22 remove integration with percent
		echo '<div class="editcolor editbackground editfont click" onclick="gen_Proc.precisionAdd(this,\''.$style.'['.$val.']\',0,\''.$maxspace.'\',\''.$size.'\',\''.$unit1.'\',\''.$factor.'\',\''.$msgjava.'\',\''.$unit2.'\',\''.$spacing.'\');">Choose Spacing:</div>';
		 
		  if ((!$this->is_page&&$css_class==='margin-left'||$css_class==='margin-right')&&!empty($this->{$style}[$val])&&strpos($this->blog_float,'float')===false&&strpos($field,'_style')!==false) 
		printer::print_tip('Use margin-left: 0px and margin-right: 0px to reset automatic centering',.7); 
	echo'  </div>';
	printer::pclear(1);
	    
	 	
	$final=$sizepx.';';
	$fstyle='final_'.$style; 
    $this->{$fstyle}[$val]=(empty($this->{$style}[$val]))?$ifempty:$css_class.':'.$final;
	 
	} #end spacing  //end
   
 
function padding_bottom($style, $val, $field){ if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	$this->spacing($style,$val,'padding-bottom','Padding Bottom Spacing','Adding bottom padding-spacing creates space below this post, column, etc. Augments the background color and spacing within borders if either used!','hidepad');
	}

function padding_right($style, $val, $field){ if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	$this->spacing($style,$val,'padding-right','Padding Right Spacing','Adding right padding-spacing creates space on the right of this post, column, etc. Augments the background color and spacing within borders if either used!','hidepad','',true, $field);
	}


function padding_left($style, $val, $field){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
    $this->spacing($style,$val,'padding-left','Padding Left Spacing','Creates space on the left of this post, column, etc. Augments the background color and spacing within borders if either used!','hidepad','',true, $field);
	}

function padding_top($style, $val, $field){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	if ($this->is_page|| ($this->is_blog&&!$this->is_clone)||($this->is_column&&!$this->is_clone||$this->clone_local_style)){  
		static $topinc=0; $topinc++;
		echo '<p class="infoclick" id="padding'.$topinc.'" title="Padding Spacing choices add spacing to your post, column, etc. If borders are used the space will be within the border. If backgrounds are used it will extend the background space."  onclick="edit_Proc.getTags(\'hidepad\',\'showhide\',id);return false;">Spacing by Padding</p>';
		printer::pclear();
		}
    $this->spacing($style,$val,'padding-top','Padding Top Spacing' ,'Creates space on the top of this post, column, etc. Augments the background color and spacing within borders if either used!','hidepad',false);
	}

function margin_top($style, $val, $field){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	if ($this->is_page|| ($this->is_blog&&!$this->is_clone)||($this->is_column&&!$this->is_clone||$this->clone_local_style)){ 
		static $marginc=0; $marginc++;
		echo '<p class="infoclick" id="margin'.$marginc.'" title=" Margin Spacing also adds spacing to your post, column, etc. However, if borders are used the space will be outside of it and if a  background color is used  the spacing will be outside the background color!"  onclick="edit_Proc.getTags(\'hidemar\',\'showhide\',id);return false;">Spacing by Margin</p>';
		printer::pclear();
		}
	$this->spacing($style,$val,'margin-top','Margin top Spacing','Creates space on the top of this post, column, etc. The Space will be outside of borders or Background Colors if either is used!!','hidemar');
	}  
function margin_bottom($style, $val, $field){ if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	$this->spacing($style,$val,'margin-bottom','Margin Bottom Spacing','Creates space on the bottom of this post, column, etc. The Space will be outside of borders or Background Colors if either is used!!','hidemar');
	}

function margin_right($style, $val, $field){ if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	 if ($this->rwd_post&&strpos($style,'style')!==false)return;
	
	$this->spacing($style,$val,'margin-right','Margin Right Spacing','Creates space to the right of this post, column, etc. that will be outside of borders or Background Colors if either is used!!','hidemar','',true,$field);
	}


function margin_left($style, $val, $field){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	
	if ($this->is_page|| ($this->is_blog&&!$this->is_clone)||($this->is_column&&!$this->is_clone||$this->clone_local_style)){ 
		if ($this->rwd_post&&strpos($style,'style')!==false){
			$this->show_more('RWD Margin Left Right Info','noback','info underline italic');
			printer::printx('<p class="fsminfo '.$this->column_lev_color.' editfont editbackground">When in RWD mode set left and right Spaces as options when choosing pos Grid units. The spaces will also be added as information in the total grid unit tracker!</p>');
			 
			$this->show_close('RWD Margin Left Right Info');
			
			return;
			}
		}
	$this->spacing($style,$val,'margin-left','Margin Left Spacing','Creates space on the left of this post, column, etc. that  will be outside of borders or Background Colors if either is used!!','hidemar','',true,$field);
	
	}
function spacing_percent($style,$val,$type,$percent){
		$unit1='%';
		$msgjava='Choose % Spacing:';
		if ($this->is_page) 
			$factor=(!empty($this->page_width)&&is_numeric($this->page_width)&&$this->page_width>99)?100/$this->page_width:Cfg::Page_width;
		else $factor=100/$this->current_total_width;
		$unit2='px'; 
		$spacing='incrementConvert';
		$px=$percent/$factor;
		#change spacing Sept 22 remove integration with percent
		echo '
	    <div class="floatleft editbackground editcolor editfont">  Currently '.$percent.'%&nbsp;&nbsp; ('.$px.$unit2.')<br>';
		$maxspace=100;
		echo '<div class="editcolor editbackground editfont click" onclick="gen_Proc.precisionAdd(this,\''.$style.'['.$val.']\',0,\''.$maxspace.'\',\''.$percent.'\',\''.$unit1.'\',\''.$factor.'\',\''.$msgjava.'\',\''.$unit2.'\',\''.$spacing.'\',\'.1\');">Choose '.$type.' Spacing:</div></div><!--end ion spacing_percent-->';
		printer::pclear();
		}
	
function margin_right_percent($style, $val, $field,$show_style=false){ if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	$percent=(is_numeric($this->{$style}[$val])&&$this->{$style}[$val]>0&&$this->{$style}[$val]<101)?$this->{$style}[$val]:0;
	$showstyle=($show_style)?'':'style="display:none;"'; 
	echo'<div class="'.$style.'_hidepercent" '.$showstyle.'><!--percent-->';
	$this->show_more('Margin Percent Right', 'noback','editbackground '.$this->column_lev_color.' italic info',' Choose Margin Percent Right for this post here. Use 0 (both right and left) for automatic centering','500');
	printer::print_wrap('margin special','Os3darkslategrey fsmsalmon editcolor editbackground');
	printer::alert('Choose a Margin Right <b>Percent</b>:');
	$this->spacing_percent($style, $val,'margin-right',$percent);
	printer::close_print_wrap('margin special');
	($field==='blog_style'||$field==='col_style')&&printer::alert('Note: The centering of Width Limited Posts is done automatically through the use of  Margin: auto which is removed when margin-left  or margin-right is used in either percent or px mode. Use 0 if you need to return to margin: auto',false,'warnlight smallest');
	$this->show_close('Margin Percent Right');
	printer::pclear(8);
	echo'</div><!--mar Percent right-->'; 
	 $fstyle='final_'.$style;
	$this->{$fstyle}[$val]=(!empty($percent))?'margin-right: '.$percent.'%;':'0'; 
	}

function margin_left_percent($style, $val, $field,$show_style=false){ if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	$percent=(is_numeric($this->{$style}[$val])&&$this->{$style}[$val]>0&&$this->{$style}[$val]<101)?$this->{$style}[$val]:0;
	$showstyle=($show_style)?'':'style="display:none;"'; 
	echo'<div class="'.$style.'_hidepercent" '.$showstyle.'><!--percent-->';
	$this->show_more('Margin Percent left', 'noback','editbackground '.$this->column_lev_color.' italic info',' Choose Margin Percent left for this post here. Use 0 (both left and left) for automatic centering','500');
	printer::print_wrap('margin special','Os3darkslategrey fsmsalmon editcolor editbackground');
	 printer::alert('Choose a Margin left Percent:'); 
	$this->spacing_percent($style, $val,'margin-left',$percent);
	printer::close_print_wrap('margin special');
	($field==='blog_style'||$field==='col_style')&&printer::alert('Note: The centering of Width Limited Posts is done automatically through the use of  Margin: auto which is removed when margin-left  or margin-right is used in either percent or px mode. Use 0 if you need to return to margin: auto',false,'warnlight smallest');
	$this->show_close('Margin Percent left');
	printer::pclear(8);
	echo'</div><!--mar Percent left-->'; 
	 $fstyle='final_'.$style;
	$this->{$fstyle}[$val]=(!empty($percent))?'margin-left: '.$percent.'%;':'0'; 
	}
	
function padding_right_percent($style, $val, $field,$show_style=false){ if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	$percent=(is_numeric($this->{$style}[$val])&&$this->{$style}[$val]>0&&$this->{$style}[$val]<101)?$this->{$style}[$val]:0;
	$showstyle=($show_style)?'':'style="display:none;"'; 
	echo'<div class="'.$style.'_hidepercent" '.$showstyle.'><!--percent-->';
	$this->show_more('Padding Percent Right', 'noback','editbackground '.$this->column_lev_color.' italic info',' Choose Padding Percent Right for this post here.','500');
	printer::print_wrap('padding special','Os3darkslategrey fsmsalmon editcolor editbackground');
	printer::alert('Choose a Padding Right <b>Percent</b>:');
	$this->spacing_percent($style, $val,'padding-right',$percent);
	printer::close_print_wrap('padding special');
	$this->show_close('Padding Percent Right');
	printer::pclear(8);
	echo'</div><!--Padding Percent r-->'; 
	 $fstyle='final_'.$style;
	$this->{$fstyle}[$val]=(!empty($percent))?'padding-right: '.$percent.'%;':'0'; 
	}

function padding_left_percent($style, $val, $field,$show_style=false){ if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	$percent=(is_numeric($this->{$style}[$val])&&$this->{$style}[$val]>0&&$this->{$style}[$val]<101)?$this->{$style}[$val]:0;
	$showstyle=($show_style)?'':'style="display:none;"'; 
	static $padinc=0; $padinc++;
	print '<p class="infoclick floatleft" id="padper'.$padinc.'"  onclick="edit_Proc.getTags(\''.$style.'_hidepercent\',\'showhide\',this);return false;">Padding/Margin Percent</p>';
	printer::pclear();
	echo'<div class="'.$style.'_hidepercent" '.$showstyle.'><!--percent-->';
	$this->show_more('Padding Percent left', 'noback','editbackground '.$this->column_lev_color.' italic info',' Choose Padding Percent left for this post here.','500');
	printer::print_wrap('padding special','Os3darkslategrey fsmsalmon editcolor editbackground');
	 printer::alert('Choose a Padding left Percent:'); 
	$this->spacing_percent($style, $val,'padding-left',$percent);
	printer::close_print_wrap('padding special');
	$this->show_close('Padding Percent left');
	printer::pclear(8);
	echo'</div><!--Padding Percent left-->';  
	 $fstyle='final_'.$style;
	$this->{$fstyle}[$val]=(!empty($percent))?'padding-left: '.$percent.'%;':'0'; 
	}
	
function font_family($style, $val, $field,$show_style=false){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__); 
	$showstyle=($show_style)?'':' hide';
	if ($this->is_page|| ($this->is_blog&&!$this->is_clone)||($this->is_column&&!$this->is_clone||$this->clone_local_style)){  
		 
		$msg= (empty($this->{$style}[$val])||strpos($this->{$style}[$val],'=>')===false)? 'Default Value': str_replace('=>',',',$this->{$style}[$val]);
		//$chosen=(empty($this->{$style}[$val]))?'choose none':(($font_px >14.4)?$this->{$style}[$val]:((strlen($this->{$style}[$val])<31)?$this->{$style}[$val]:str_replace(', serif','',str_replace(', sans-serif','',$this->{$style}[$val]))));
		//$chosen=str_replace('=>',',',$chosen);
		
		echo'<div class="fsminfo editcolor editbackground '.$style.'_hidefont '.$showstyle.'" ><!--font family-->';
		$this->show_more('Font Family ', 'noback','editbackground '.$this->column_lev_color.' italic info',' Choose the Font Family Style for this post here','500');
		echo'<div class="fsminfo editbackground"><!--font family-->';
		echo '<p class="fs1red"><span class="information" title="Select a new text style (font-family) for this post from the dropdown menu. View a image of how the text style looks, click the link below. Choose None to return to the inherited font-family value.  &#40;Inherited Parent Values are the most recent values that have been set in the parent Columns and if not set there then in the body or the default browser font if none has been chosen in any parent!!">Text Font Style: </span>Currently:<br><span class="'.$this->column_lev_color.'"> '.$msg.'</span></p>'; 
		   foreach ($this->fonts_all as $family){
			$mod_family=str_replace(',','=>',$family);
			$checked=($mod_family===$this->{$style}[$val])?'checked="checked"':'';
			//$family=(strlen($family)<31)?$family:str_replace(', serif','',str_replace(', sans-serif','',$family));
			//($this->current_total_width/strlen($mod_family)*2.5);
			 echo  "\n".'<p style="font-family:'.$family.';" ><input type="radio" name="'.$style.'['.$val.']"  value="'.$mod_family.';">'.$family.'</p>';
			}
		echo'</div><!--font family-->';
		
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
		    <div class="fsminfo editbackground '.$style.'_hidefont hide"><!--font_weight--><p class="information" title="Select new Font Weight &#40;the thickness or relative boldness of the font&#41; from dropdown menu list. The normal default font-weight is 400 whereas the traditional bold font-weight is 700.">Font Weight: Currently '.$msg.'<br>
		 
			<select class="editcolor editbackground"  name="'.$style.'['.$val.']" id="'.$style.'_'.$val.'">        
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
    
	$this->show_more('Float Right/Left/Center', 'noback','editfont editbackground infoclick',' Choose to Position Next to instead of full Space',500);
	$current=(empty($style[$val]))?'none':$style[$val];
    echo '
        <fieldset class="sfield"><legend></legend><p class="'.$this->column_lev_color.' editbackground editfont  Os3salmon fsminfo float">Float: Currently '.$msg.'<br>
    Float (positions along side) setting:<br>
         <select class="editcolor editbackground"  name="'.$style.'['.$val.']" id="'.$style.'_'.$val.'">        
    <option  value="'.$this->{$style}[$val].'" selected="selected">'.$current.'</option>
    <option  value="center">Center Width (margin centers)</option> 
    <option  value="right">Float Right</option>
    <option  value="left">Float Left</option>
    <option value="none">None</option>
    </select>';
     echo'
    </p></fieldset>';
    $this->show_close('Float Right/Left');
      $fstyle='final_'.$style;
	$this->{$fstyle}[$val]=($this->{$style}[$val]==='right'||$this->{$style}[$val]==='left')?'float:'.$this->{$style}[$val].'; ':(($this->{$style}[$val]==='none')?'':'margin-right:auto;margin-left:auto;');
	}



function radius_corner($style, $val,$field){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	if (arrayhandler::is_empty_array($this->{$style}[$val])){//default may be set to 1
		$radius_array=array();
		 for ($i=0; $i<4;$i++){ 
			$radius_array[$i]=0;
			}
		}
	else	{ //note that input type text will give 0value for defaults...
		$radius_array=explode('@@',$this->{$style}[$val]);
		for ($i=0; $i<4;$i++){ 
			if (!array_key_exists($i,$radius_array)){
				$radius_array[$i]=0;
				}
			}
		}
	
	   $size= (empty($radius_array[0]))? '0':$radius_array[0];
	if ($this->is_page|| ($this->is_blog&&!$this->is_clone)||($this->is_column&&!$this->is_clone||$this->clone_local_style)){  
	$this->show_more('Radius Background', 'noback','editfont editbackground infoclick',' Radius a Colored Post Background if in use Here!',500);
		printer::print_wrap('wrap radius','Os1redAlert fsmblack editbackground editcolor');
		echo '<p class="fsminfo editbackground rad10 '.$this->column_lev_color.' editfont">As an Example we have used a radius around this text with a border to show the radius effect. A value of 10px was selected for each corner<br> <span class="neg"> Please Note that your Radius will only show up when background colors, box shadows, and borders are used and radius can also be used with images!!</span> <br> Radius the stylized corners of Column, Posts, and Menu-Link Button Areas, Images.</p>'; 
	   
	   echo '<fieldset class="sfield"><legend></legend>
	   <p class="'.$this->column_lev_color.' editbackground editfont">Choose: Top Left Radius:
	    <select class="editcolor editbackground"  name="'.$style.'['.$val.'][0]" >        
	    <option  value="'.$radius_array[0].'" selected="selected">'.$radius_array[0].'</option>';
		for ($i=0; $i<95; $i+=1){
		   echo '<option  value="'.$i.'">'.$i.'</option>';
		   }
	   
		echo'	
	    </select></p>';
	    printer::pclear(1);
		$size= (empty($radius_array[1]))? '0':$radius_array[1];
	   echo '
	   <p class="'.$this->column_lev_color.' editbackground editfont">Choose: Top Right Radius:
	    <select class="editcolor editbackground"  name="'.$style.'['.$val.'][1]" >        
	    <option  value="'.$radius_array[1].'" selected="selected">'.$radius_array[1].'</option>';
		for ($i=0; $i<95; $i+=1){
		   echo '<option  value="'.$i.'">'.$i.'</option>';
		   }
		 echo'	
	    </select></p>';
		$size= (empty($radius_array[2]))? '0':$radius_array[2];
	   echo '
	   <p class="'.$this->column_lev_color.' editbackground editfont"> Choose: Bottom Right Radius:
	    <select class="editcolor editbackground"  name="'.$style.'['.$val.'][2]" >        
	    <option  value="'.$radius_array[2].'" selected="selected">'.$radius_array[2].'</option>';
		for ($i=0; $i<95; $i+=1){
		   echo '<option  value="'.$i.'">'.$i.'</option>';
		   }
			 
		echo'	
	    </select></p>';$size= (empty($radius_array[3]))? '0':$radius_array[3];
	   echo '
	   <p class="'.$this->column_lev_color.' editbackground editfont">Choose: Bottom Left Radius:
	    <select class="editcolor editbackground"  name="'.$style.'['.$val.'][3]" >        
	    <option  value="'.$radius_array[3].'" selected="selected">'.$radius_array[3].'</option>';
		for ($i=0; $i<95; $i+=1){
		   echo '<option  value="'.$i.'">'.$i.'</option>';
		   }
			 
		echo'	
	    </select></p>';
	 echo'</fieldset>';
	 
	printer::close_print_wrap('wrap radius');
	 $this->show_close('radius');
		}
	$radiuscss='
		-webkit-border-radius: '.$radius_array[0].'px '.$radius_array[1].'px '.$radius_array[2].'px '.$radius_array[3].'px;
	border-radius: '.$radius_array[0].'px '.$radius_array[1].'px '.$radius_array[2].'px '.$radius_array[3].'px;
		';
	 
	$radiuscss= (empty($radius_array[0])&&empty($radius_array[1])&&empty($radius_array[2])&&empty($radius_array[3]))?'':$radiuscss;
	 $fstyle='final_'.$style;
	$this->{$fstyle}[$val]=$radiuscss;
	 
	}



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
		$this->show_more('Rotate/Skew', 'noback','infoclick editbackground',' Rotate or Skew the Content of this post!',500);
		echo '<div class="fs1color Od2navy whitebackground"><!--tranform border-->';
		echo '<p class="fsminfo editbackground rad5 skewx3 '.$this->column_lev_color.' editfont">we have demonstrated a skew Xdirection of 4 degrees around this text to show the transform option in practice.  Be sure to allow enough width for your final effect! For more info on using the css3 transform feature and examples see <a href="http://www.w3schools.com/cssref/css3_pr_transform.asp"> Column Examples</a></p>'; 
	
	 
		$size= (empty($transform_array[0]))? '0':$transform_array[0];
		echo '
		<p class="'.$this->column_lev_color.' editbackground editfont">Degrees of Rotation: Currently '.$size.'<br>
		 <span class="editcolor editbackground">Choose Rotation Degrees:</span>
		 <select class="editcolor editbackground"  name="'.$style.'['.$val.'][0]" >        
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
		 <span class="editcolor editbackground">Choose Skew Xdirection Degrees:</span>
		 <select class="editcolor editbackground"  name="'.$style.'['.$val.'][1]" >        
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
		 <span class="editcolor editbackground">Choose Skew Ydirection Degrees:</span>
		 <select class="editcolor editbackground"  name="'.$style.'['.$val.'][2]" >        
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
		echo '</div><!--tranform border-->';
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
		$this->show_more('Multiple Columns', 'noback','infoclick editbackground',' turn this text into 2 or more columns',300);
			echo ' <div class="sfield whitebackground Od2navy fsm'.$this->column_lev_color.'"> 
		<p class="column2 '.$this->column_lev_color.' fsminfo editbackground rad3 editfont">This text you are reading was set up with 2 columns and a space of 16px between the columns with no divider line showing. The columns will be split between the available width.<br>For quick overview of using the css3 column feature and examples see <a href="http://css-tricks.com/snippets/css/css-box-column/"> Column Examples.</a><br> </p>';
		printer::pclear(8);
		   $size= (empty($column_array[0]))? 'One':$column_array[0];
		echo '
		<p class="'.$this->column_lev_color.' editbackground editfont">Choose the number of columns: Currently '.$size.'<br>
		<span class="editcolor editbackground">Choose # of Columns:</span>
		<select class="editcolor editbackground"  name="'.$style.'['.$val.'][0]" >        
		<option  value="'.$column_array[0].'" selected="selected">'.$column_array[0].'</option>';
		for ($i=1; $i<6; $i+=1){
			echo '<option  value="'.$i.'">'.$i.'</option>';
			}
		 echo'	
		 </select></p>';
		$size= (empty($column_array[1]))? 'None':$column_array[1];
		echo'<p class="'.$this->column_lev_color.' editbackground editfont">Choose the spacing between columns Currently '.$size.' px <br>
		<span class="editcolor editbackground">Choose Spacing between columns:</span>
		<select class="editcolor editbackground"  name="'.$style.'['.$val.'][1]" >        
		<option  value="'.$column_array[1].'" selected="selected">'.$column_array[1].'</option>';
		for ($i=0; $i<200; $i+=1){
			 echo '<option  value="'.$i.'">'.$i.'px</option>';
			}
		 echo'	
		</select></p>'; 
		$column_array[2]=($column_array[2]==='Line Separator True')?$column_array[2]:'Line Separator False';
		    echo'<p class="'.$this->column_lev_color.' editbackground editfont">Show  line Separator Between Columns: Currently '.$column_array[2].'<br>
		<span class="editcolor editbackground">Choose Show Divider:</span>
		<select class="editcolor editbackground"  name="'.$style.'['.$val.'][2]" >        
		<option  value="'.$column_array[2].'" selected="selected">'.$column_array[2].'</option>';
		
		   echo '<option  value="Line Separator False">Line Separator False</option> 
			<option  value="Line Separator True">Line Separator True</option> 
		 
		</select></p>'; 
		 echo'</div><!--multiple columns-->';
		 $this->show_close('multiple columns');
		}   
	$col=(!empty($this->{$style}[$this->font_color_index]))?$this->{$style}[$this->font_color_index]:$this->editor_color;
	 //color was transformed by color function so need to replace
	$col=trim(str_replace(array('color',':','#',';'),'',$col));
	$line=($column_array[2]=='Line Separator True')?'-moz-column-rule: 1px solid #'.$col.'; -webkit-column-rule: 1px solid #'.$col.';  column-rule: 1px solid #'.$col.';':'';
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
	//array('No Border','top bottom left right','top','bottom','left','right','top left','top right','bottom left','bottom right','left right','top bottom');
	 
	if (arrayhandler::is_empty_array($this->{$style}[$val])){//default may be set to 1
		$border_array=array();
		 for ($i=0; $i<4;$i++){ 
			$border_array[$i]=0;
			}
		}
	else	{ //note that input type text will give 0value for defaults...
		$border_array=explode('@@',$this->{$style}[$val]);
		for ($i=0; $i<4;$i++){ 
			if (!array_key_exists($i,$border_array)){
				$border_array[$i]=0;
				}
			}
		}
	$blog_border_sides=$border_array[3]=(!empty($border_array[3])&&in_array($border_array[3],$border_sides))?$border_array[3]:'No Border';
	$border_line=$border_array[0]= (is_numeric($border_array[0])&&$border_array[0]>0)? $border_array[0]:0;
	$px='px ';
	switch ($border_array[3]) { 
	case $border_sides[1]:# all
		$border_width="$border_line$px $border_line$px $border_line$px $border_line$px";
		break;
	case $border_sides[2]:# top bottom
		$border_width=" $border_line$px 0 $border_line$px 0";
		break; 
	case $border_sides[3]:# top
		$border_width="$border_line$px 0 0 0";
		break;
	case $border_sides[4]:# bottom
		$border_width="0 0 $border_line$px 0";
		break;
	case $border_sides[5]:# left
		$border_width="0 0 0 $border_line$px";
		break;
	case $border_sides[6]:# right
		$border_width="0 $border_line$px 0 0";
		break;
	case $border_sides[7]:# top left
		$border_width="$border_line$px 0 0 $border_line$px";
		break;
	case $border_sides[8]:# top right
		$border_width="$border_line$px $border_line$px 0 0";
		break;
	case $border_sides[9]:# bottom left
		$border_width="0 0 $border_line$px $border_line$px";
		break;
	case $border_sides[10]:# bottom right
		$border_width="0 $border_line$px $border_line$px  0";
		break;
	case $border_sides[11]:# left right
		$border_width="0 $border_line$px 0 $border_line$px";
		break;
	default:
	$border_width=0;	 
	}//end switch
	$blog_border_color=$border_array[1]=(preg_match(Cfg::Preg_color,$border_array[1]))?$border_array[1]:$this->editor_color;
	$border_types=array('dotted','dashed','solid','double','groove','ridge','inset','outset');
	 
	$blog_border_type=$border_array[2]=(!empty($border_array[2])&&in_array($border_array[2],$border_types))?$border_array[2]:'solid';
	if ($this->is_page|| ($this->is_blog&&!$this->is_clone)||($this->is_column&&!$this->is_clone||$this->clone_local_style)){  
	
	
		$this->show_more('Border styling','noback','editfont infoclick editbackground', 'For Information on Borders and to Choose Border Type, Colors, and Edges click Here',500);
		echo '<div class="Os2maroon fs1color  editbackground"><!--Border sides-->';
		echo '<p style="border-width: 3px 0 3px 0; border-style:double; border-color:#'.$this->aqua.';" class="'.$this->column_lev_color.' editbackground editfont pt10 pb10 mt10 mb10"><!--End function border style-->We have used a light blue border selecting top and bottom around this text with a border type: double and a border thickness of 4'.$px.'. Borders are lines dashes dots,etc. stylize around columns, posts, groups of posts or menu link &#34;buttons&#34; depending on which of these you are currently styling! <br></p>'; 
		 
		printer::spanclear(5);
		echo'<p class="'.$this->column_lev_color.' editbackground editfont">Choose Border Profile (Top Bottom Sides) Currently: '.$border_array[3].'<br></p>';
		echo '<p class="editcolor editbackground editfont" title="For Example Choose top bottom left right for a normal box border around the entire column, or if wish to show a border only around one or two sides for expample, the top and right, choose the top right option instead">Border Sides Info'; 
		echo '<select class="editcolor editbackground"  name="'.$style.'['.$val.'][3]" >        
		<option  value="'.$border_array[3].'" selected="selected">'.$border_array[3].'</option>'; 
		foreach ($border_sides as $type){
			echo'<option  value="'.$type.'">'.$type.'</option> ';
			}
		echo '</select></p>';
		
	
		echo'<p class="editfont editcolor left5 editbackground"> Border Line Thickness:
		<select class="editcolor editbackground"  name="'.$style.'['.$val.'][0]" >        
		<option  value="'.$border_array[0].'" selected="selected">'.$border_array[0].$px.'</option>';
		for ($i=0; $i< 60; $i+=1){
			echo '<option  value="'.$i.'">'.$i.$px.'</option>';
			}
		 echo'	
		</select></p>';
		printer::spanclear(5);
		$span_color=(!empty($border_array[1]))?'<span class="fs1npred" style="background-color:#'.$border_array[1].';">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>':''; 
		printer::alert('Set border Color <input style="cursor:pointer;background:#'.$this->editor_background.';color:#'.$this->editor_color.';" type="text" name="'.$style.'['.$val.'][1]" id="border_id'.$inc.'_'.self::$xyz.'" value="'.$border_array[1].'" size="12" maxlength="6" class="jscolor {refine:false}">'.$span_color.'<span style="font-size: 1.1em; color: yellow;" id="border_id'.$inc.'_'.self::$xyz.'instruct"></span><br>',false,'left editcolor editbackground'); 
		 
		echo'<p class="left '.$this->column_lev_color.'">Set Border Type Currently: '.$border_array[2].'<br>
		<span class="editcolor editbackground">Border Type:</span>
		<select class="editcolor editbackground"  name="'.$style.'['.$val.'][2]" >        
		<option  value="'.$border_array[2].'" selected="selected">'.$border_array[2].'</option>'; 
		foreach ($border_types as $type){
			echo'<option  value="'.$type.'">'.$type.'</option> ';
			}
		echo '</select></p>';
		echo '</div><!--End function border style-->';
		printer::spanclear(5); 
		$this->show_close('Border styling');
		}
	 $fstyle='final_'.$style;
	$this->{$fstyle}[$val]=($border_array[3]!='No Border')?$this->{$style}[$val]='border-width: '.$border_width.'; border-style:'. $blog_border_type.'; border-color:  #'.$blog_border_color.';':'';//this
	 
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
	
	
		$this->show_more('Outline Styling','noback','editfont infoclick editbackground', 'For Information on outlines and to Choose outline Type, Colors, and Edges click Here',500);
		 
		echo '<div class="fsminfo editcolor editbackground editfont"><!--  outline style-->';
		printer::alertx('<p class="Os4ekblue">We have used a blue outline around this text with a outline type: single and a outline thickness of 4px. Outlines are similar to borders except 4 sides always. They wrap around outside of borders (if used). Create and stylize these around columns, posts, groups of posts or menu links as needed<br></p>'); 
		 
		printer::spanclear(5);
		 
		
	
		echo'<p class="editfont left5 editbackground"> outline Line Thickness:
		<select class="editcolor editbackground"  name="'.$style.'['.$val.'][0]" >        
		<option  value="'.$outline_array[0].'" selected="selected">'.$outline_array[0].$px.'</option>';
		for ($i=0; $i< 81; $i+=1){
			echo '<option  value="'.$i.'">'.$i.$px.'</option>';
			}
		 echo'	
		</select></p>';
		
		
		printer::spanclear(5);
		$span_color=(!empty($outline_array[1]))?'<span class="fs1npred" style="background-color:#'.$outline_array[1].';">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>':''; 
		printer::alert('Set outline Color Here.  Use 0 or non color to remove outline<input style="cursor:pointer;background:#'.$this->editor_background.';color:#'.$this->editor_color.';" type="text" name="'.$style.'['.$val.'][1]" id="outline_id'.$inc.'_'.self::$xyz.'" value="'.$outline_array[1].'" size="12" maxlength="6" class="jscolor {refine:false}">'.$span_color.'<span style="font-size: 1.1em; color: yellow;" id="outline_id'.$inc.'_'.self::$xyz.'instruct"></span><br>',false,'left editcolor editbackground'); 
		 
		echo'<p class="left '.$this->column_lev_color.'">Set outline Type Currently: '.$outline_array[2].'<br>
		<span class="editcolor editbackground">outline Type:</span>
		<select class="editcolor editbackground"  name="'.$style.'['.$val.'][2]" >        
		<option  value="'.$outline_array[2].'" selected="selected">'.$outline_array[2].'</option>'; 
		foreach ($outline_types as $type){
			echo'<option  value="'.$type.'">'.$type.'</option> ';
			}
		echo '</select></p>';
		echo '</div><!--  outline style-->';
		printer::spanclear(5);
		 $this->show_close('Style Table params');//<!--Show More outline Style Table params-->'; 
		}//if editable
	 $fstyle='final_'.$style; 
	$this->{$fstyle}[$val]=(preg_match(Cfg::Preg_color,$blog_outline_color))?$this->{$style}[$val]='outline-width: '.$outline_width.'px; outline-style:'. $blog_outline_type.'; outline-color:  #'.$blog_outline_color.';':'';//this
	 
	}//end fun outlines

function box_shadow($style, $val,$field){
	 static $inc=0;  $inc++;   
	 //'0shadowbox_horiz_offset,1shadowbox_vert_offset,2shadowbox_blur_radius,3shadowbox_spread_radius,4shadowbox_color,5shadowbox_insideout';
	
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
		$this->show_more('Box Shadow', 'noback','editfont infoclick editbackground',' add a Shadow around this text or image post',500);  
		
		echo ' <fieldset class="fs1color editbackground"><legend></legend>
		<p class="fbs1info '.$this->column_lev_color.' editbackground editfont">We have used a maroon box shadow effect on the bottom right of this text. <span class="info" title="Blur Radius: 7px; Spread Radius -6px; Horizontal Offset: 4px; Vertical Offset: 4px; Color:#f7f2a8;">See Settings</span> for this box shadow!<br>Like Borders, Box Shadows provide styling around a Column Post or Menu Link Area, though providing a customizable shadow instead. For a quick overview  and examples see <a href="http://css-tricks.com/snippets/css/css-box-shadow/">Shadow Examples.</a>  </p>';
		printer::pclear(8);
		 echo '<p class="fsminfo editbackground rad3 floatleft '.$this->column_lev_color.' editfont">Shadow may be an outside box shadow (recommended for styling directly around images or an inside box shadow :<br> ';
		 
				$checked2=($shadow_array[$this->shadowbox_insideout_index]==='inset')?'checked="checked"':''; 
				$checked1=($shadow_array[$this->shadowbox_insideout_index]!=='inset')?'checked="checked"':''; 
				printer::alertx('<span class="editcolor editbackground"><input type="radio" value="outset" '.$checked1.' name="'.$style.'['.$val.'][5]">Choose Outside Box Shadow</span><br>');
				printer::alertx('<span class="editcolor editbackground"><input type="radio" value="inset" '.$checked2.' name="'.$style.'['.$val.'][5]">Choose Inside Box Shadow</span></p>');
				
				printer::pspace(4); 
		echo ' <p class="fsminfo editbackground rad3 '.$this->column_lev_color.' editfont">The blur radius: 
		If set to 0 the shadow will be sharp, the higher the number, the more blurred it will be: ';
		echo ' <span class="'.$this->column_lev_color.' left5 editbackground editfont">Currently '.$shadow_array[$this->shadowbox_blur_radius_index].'</span><br>
		<span class="editcolor editbackground">Choose Blur Radius:</span>
	    <select class="editcolor editbackground"  name="'.$style.'['.$val.'][2]" >        
	    <option  value="'.$shadow_array[$this->shadowbox_blur_radius_index].'" selected="selected">'.$shadow_array[$this->shadowbox_blur_radius_index].'</option>';
	    for ($i=0; $i<30; $i+=1){
		   echo '<option  value="'.$i.'">'.$i.'px</option>';
		   }
	    echo '</select></p>';
		   
		echo ' <p class="fsminfo editbackground rad3 '.$this->column_lev_color.' editfont">The spread radius gives all sides even shadow width: A positive values increase the size of the shadow
		 whereas negative values decrease the size: ';
		echo ' <span class="'.$this->column_lev_color.' left5 editbackground editfont">Currently '.$shadow_array[$this->shadowbox_spread_radius_index].'</span><br>
	    <span class="editcolor editbackground">Choose New Spread Radius:</span>
	    <select class="editcolor editbackground"  name="'.$style.'['.$val.'][3]" >        
	    <option  value="'.$shadow_array[$this->shadowbox_spread_radius_index].'" selected="selected">'.$shadow_array[$this->shadowbox_spread_radius_index].'</option>';
	    for ($i=-5; $i<30; $i+=1){
		   echo '<option  value="'.$i.'">'.$i.'px</option>';
		   }
	    echo '</select></p>';
		 echo '<p class="fsminfo editbackground rad3 '.$this->column_lev_color.' editfont">Box Shadow Horizonal offet, more negative value  means more on left side of the box, positive right: '; 
	   
		echo '<span class="'.$this->column_lev_color.' left5 editbackground editfont">Currently '.$shadow_array[$this->shadowbox_horiz_offset_index].'</span><br> 
	    <span class="editcolor editbackground left">Choose: Horizontal offset:</span>
	    <select class="editcolor editbackground"  name="'.$style.'['.$val.'][0]" >        
	    <option  value="'.$shadow_array[$this->shadowbox_horiz_offset_index].'" selected="selected">'.$shadow_array[$this->shadowbox_horiz_offset_index].'</option>';
	    for ($i=-30; $i<30; $i+=1){
		   echo '<option  value="'.$i.'">'.$i.'px</option>';
		   }
	    echo'	
	    </select></p>';
		echo '<p class="fsminfo editbackground rad3 '.$this->column_lev_color.' editfont">Box Shadow Vertical offet, more negative value means more above the box, more positive more below: ';
		echo '   <span class="'.$this->column_lev_color.' left5  editbackground editfont">Currently '.$shadow_array[$this->shadowbox_vert_offset_index].'</span><br>
		<span class="editcolor editbackground">Choose: Vertical offset:</span>
	    <select class="editcolor editbackground"  name="'.$style.'['.$val.'][1]" >        
	    <option  value="'.$shadow_array[$this->shadowbox_vert_offset_index].'" selected="selected">'.$shadow_array[$this->shadowbox_vert_offset_index].'</option>';
	    for ($i=-30; $i<30; $i+=1){
		   echo '<option  value="'.$i.'">'.$i.'px</option>';
		   }
	    echo'	
		 </select></p>';
		 echo '<p class="fsminfo editbackground rad3 '.$this->column_lev_color.' editfont">You Color Choice Can Also Produce a More or Less Subtle Shadow Effect!:<br> ';
		$span_color=(!empty($shadow_array[$this->shadowbox_color_index]))?'<span class="fs1npred" style="background-color:#'.$shadow_array[$this->shadowbox_color_index].';">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>':''; 
		if (preg_match(Cfg::Preg_color,$shadow_array[$this->shadowbox_color_index])){
			
			$msg="Change the Current Shadow Color: #";
			}
		else {
			$msg= (!empty($shadow_array[$this->shadowbox_color_index]))?$shadow_array[$this->shadowbox_color_index] . ' is not a valid color code. Enter a new shadow color code: #':'Enter a shadow color code: #';
			}
			 //id="shadow"
	 
		printer::alertx('Edit Shadow color '.$msg.'<input style="cursor:pointer;background:#'.$this->editor_background.';color:#'.$this->editor_color.';" type="text" name="'.$style.'['.$val.'][4]" id="'.$style.'-'.$val.$inc.'" value="'. $shadow_array[$this->shadowbox_color_index].'" size="6" maxlength="6" class="jscolor {refine:false}">'.$span_color.'<span style="font-size: 1.1em; color: yellow;" id="'.$style.'-'.$val.$inc.'instruct"></span>');
	    $this->color_info();
		echo'</p></fieldset><!--box shadow-->';
		$this->show_close('edit shadow');//'edit shadow'
		}
	$shadowcss='-moz-box-shadow:'.$shadow_array[$this->shadowbox_insideout_index].' '.$shadow_array[$this->shadowbox_horiz_offset_index].'px '.$shadow_array[$this->shadowbox_vert_offset_index].'px '.$shadow_array[$this->shadowbox_blur_radius_index].'px '.$shadow_array[$this->shadowbox_spread_radius_index].'px '. '#'. $shadow_array[$this->shadowbox_color_index].';  
	-webkit-box-shadow:'.$shadow_array[$this->shadowbox_insideout_index].'  '.$shadow_array[$this->shadowbox_horiz_offset_index].'px '.$shadow_array[$this->shadowbox_vert_offset_index].'px '.$shadow_array[$this->shadowbox_blur_radius_index].'px '.$shadow_array[$this->shadowbox_spread_radius_index].'px '. '#'. $shadow_array[$this->shadowbox_color_index].';   
	box-shadow:'.$shadow_array[$this->shadowbox_insideout_index].'  '.$shadow_array[$this->shadowbox_horiz_offset_index].'px '.$shadow_array[$this->shadowbox_vert_offset_index].'px '.$shadow_array[$this->shadowbox_blur_radius_index].'px '.$shadow_array[$this->shadowbox_spread_radius_index].'px '. '#'. $shadow_array[$this->shadowbox_color_index].';';  
	 
	$intial='-moz-box-shadow:initial; -webkit-box-shadow: initial; box-shadow:initial;';//initial for default none
	$shadowcss= (!preg_match(Cfg::Preg_color,$shadow_array[$this->shadowbox_color_index]))?'':$shadowcss; 
	
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
	    $this->show_more('Text Shadow','noback','infoclick editbackground','Add a Shadow to the text fonts',500);
		 echo '
		 <div class="fs2black editbackground"><!--shadow group wrapper--> 
		<p class="fsminfo aqua textshadow">We have used a blue shadow color with this lighter blue text. <span class="info" title="Horizontal Offset: -1.4px; Vertical Offset: -1.4px; Blur Radius .8px;">Hover for View Settings</span> for this Text Shadow! For quick overview of using the css3 shadow feature and examples see <a target="_blank" href="http://css-tricks.com/snippets/css/css-box-shadow/">Shadow Examples</a> </p>';
		printer::pclear(8);
		echo' <div class="fsminfo editbackground rad3 '.$this->column_lev_color.' editfont"><!--leftrightoffset-->Text Shadow Left/Right offet, more negative value  means more left, positive right:';
	   echo'<p class="'.$this->column_lev_color.' left5 editbackground editfont">Currently '.$shadow_array[0].'<br>
		<span class="editcolor editbackground">Choose: Horizontal offset:</span>
	    <select class="editcolor editbackground"  name="'.$style.'['.$val.'][0]" >        
	    <option  value="'.$shadow_array[0].'" selected="selected">'.$shadow_array[0].'</option>';
	    for ($i=-3; $i<3.1; $i+=.1){
			($i < .01&& $i > -.01)&&$i=0;
		   echo '<option  value="'.$i.'">'.$i.'px</option>';
		   }
	    echo' </select>  
	   </div><!--leftrightoffset-->';
		echo'<div class="fsminfo editbackground rad3 '.$this->column_lev_color.' editfont"><!--vert offset-->Text Shadow Above/Below offet 
		More negative value  means more above the text 
		More positive value  more below:<br>';
		echo'<p class="'.$this->column_lev_color.' rad3 editbackground editfont">Currently '.$shadow_array[1].'<br>
		<span class="editcolor editbackground">Choose Vertical offset:</span>
	    <select class="editcolor editbackground"  name="'.$style.'['.$val.'][1]" >        
	    <option  value="'.$shadow_array[1].'" selected="selected">'.$shadow_array[1].'</option>';
	    for ($i=-3; $i<3; $i+=.1){
			($i < .01&& $i > -.01)&&$i=0;
		   echo '<option  value="'.$i.'">'.$i.'px</option>';
		   }
	   echo' </select></p>
	   </div><!--vert offset-->';	
		echo'<div class="'.$this->column_lev_color.' fsminfo editbackground rad3 editfont"><!--Blur length-->Set Shadow Blur Length: Currently '.$shadow_array[2].'<br>
		<span class="editcolor editbackground">Choose New blur radius:</span>
	    <select class="editcolor editbackground"  name="'.$style.'['.$val.'][2]">        
	    <option  value="'.$shadow_array[2].'" selected="selected">'.$shadow_array[2].'</option>';
	    for ($i=0; $i<3; $i+=.1){
		   echo '<option  value="'.$i.'">'.$i.'px</option>';
		   }
		  echo' </select>
		  </div><!--Blur length-->';	
	 
		if (preg_match(Cfg::Preg_color,$shadow_array[3])){ 
			$msg="Change the Current Shadow Color:<br> #";
			}
		else {
			$msg= (!empty($shadow_array[3]))?$shadow_array[3] . ' is not a valid color code. Enter a new shadow color code:<br> #':'Enter a shadow color code:<br> #';
			}
			 //id="shadow"
	  
		$span_color=(!empty($shadow_array[3]))?'<span class="fs1npred" style="background-color:#'.$shadow_array[3].';">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>':'';   
		echo '<div class="'.$this->column_lev_color.' fsminfo editbackground editfont">Edit the Text Shadow color <br><span class="editcolor editbackground"><!--shadow text color-->'.$msg.'</span><input style="cursor:pointer;background:#'.$this->editor_background.';color:#'.$this->editor_color.';"   type="text" name="'.$style.'['.$val.'][3]" id="'.$style.'-'.$val.$inc.'" value="'. $shadow_array[3].'" size="6" maxlength="6" class="jscolor {refine:false}">'.$span_color.'<span style="font-size: 1.1em; color: yellow;" id="'.$style.'-'.$val.$inc.'instruct"></span>';
		echo'</div><!--shadow text color-->';
		echo '</div><!--shadow group wrapper-->';
		$this->show_close('text shadow');
		echo'</div><!--text shadow-->';
		}
	$shadowcss='text-shadow: '.$shadow_array[0].'px '.$shadow_array[1].'px '.$shadow_array[2].'px #'. $shadow_array[3].';'; 
	
	$shadowcss= (empty($shadow_array[3])||(empty($shadow_array[0])&&empty($shadow_array[2])&&empty($shadow_array[1])))?'':$shadowcss;
	
	 $fstyle='final_'.$style;
	$this->{$fstyle}[$val]=$shadowcss;
	}

	
function height_style($style, $val,$field=''){
	 static $topinc=0; $topinc++;
	$height_arr=explode('@@',$this->{$style}[$val]);
	$hval=$height_arr[0];
	$cancel_scroll=(array_key_exists(1,$height_arr))?$height_arr[1]:'';
	$current=(!empty($hval))?$hval.'px':'Automatically Adjust to Content';
	if ($this->is_page|| ($this->is_blog&&!$this->is_clone)||($this->is_column&&!$this->is_clone||$this->clone_local_style)){
		
		echo '
		<div class="editbackground"><!--height style advanced_hide-->';//hideout sets initial display..
		$this->show_more('Custom Height Style','','italic info click','Height is normally handled automaticly.');
		echo '<div class="fsminfo editbackground "><!--height style-->';
		printer::print_tip('Post Height is generally determined automatically from Content but its custom specified here<br>Post Height: Currently '.$current.'<br><b>Use 0 to remove</b>');
		$maxspace=2000;
		$wid=$hval=(!empty($hval)&&is_numeric($hval)&&$hval<=$maxspace)?$hval:'auto';
		$px=(empty($wid)||$wid==='auto')?'Automatic Height':intval($wid).'px'; 
		printer::pclear(4);
		if (!Cfg::Spacings_off){
			echo '<select class="editcolor editbackground"  name="'.$style.'['.$val.'][0]" id="'.$style.'_'.$val.'">        
			<option  value="'.$wid.'" selected="selected"> '.$px.'</option>
			<option  value="auto">Automatic Height</option>';
			if ($maxspace<=150){
				 for ($i=0; $i<=$maxspace; $i+=1){
					printer::printx('<option  value="'.$i.'">'.$i.'px</option>');
				    }
				}
			else {
				$i=0;
				foreach (array(100 =>5,300=>5,$maxspace=>5) as $max =>$inc){
					$max=min($max,$maxspace);
					while ($i <= $max){
						 printer::printx('<option  value="'.$i.'">'.$i.'px</option>');
						if ($i < $maxspace && ($i+$inc)>$maxspace) $i=$maxspace;
						else $i=$i+$inc;
						if ($i >$maxspace)continue;
						}
					if ($i > $maxspace)continue;
					}
				}
			    echo'	
				</select>';
				}//spacings off
		printer::pclear();
		if ($maxspace > 150){
			$msgjava='Choose Height:';
			$factor=1;
			echo '<div class="editcolor editbackground editfont  click" onclick="gen_Proc.precisionAdd(this,\''.$style.'['.$val.'][0]\',0,\''.$maxspace.'\',\''.$px.'\',\'px\',\''.$factor.'\',\''.$msgjava.'\',\'\');">Choose Height</div>';
				
				}
		if (empty($cancel_scroll)) :
			$msg='Check to cancel scrolling of Content Height Overflow';
			$value=1;
			$msg2='Your Post will scroll the overflow display by default.';
		else :
			$msg='Check to Re-initiate Scrolling of Content Height Overlow';
			$msg2='Default scrolling of  overflow display has been cancelled.';
			$value=0;
		endif;
		printer::printx('<p class="Os3salmon fsmblack editcolor editbackground editfont">'.$msg2.'<br><input type="checkbox"  name="'.$style.'['.$val.'][1]" value="'.$value.'">'.$msg.'</p>');
		echo '</div><!--height style inner-->';
		$this->show_close('Custom Height Style');
		echo '</div><!--height style advanced_hide-->';
		
		}// editable
	 
	$overflow=(empty($cancel_scroll))?'overflow-y:auto;':'';
	$heightval=(is_numeric($hval)&&$hval>4)?'height:'.$hval.'px;'.$overflow:'';
	(!empty($heightval))&&$this->editcss.=$this->pelement.'{min-height:300px;overflow: auto;}/*For Edit  Mode Display*/';  
	
	 $fstyle='final_'.$style;
	$this->{$fstyle}[$val]=$heightval;
	}
function isSerialized($s){//from stackoverflow
if(
    stristr($s, '{' ) != false &&
    stristr($s, '}' ) != false &&
    stristr($s, ';' ) != false &&
    stristr($s, ':' ) != false
    ){
    return true;
}else{
    return false;
}

}
function custom_style($style, $val,$field=''){
	static $topinc=0; $topinc++;
	$serial_data=$this->{$style}[$val]; echo $serial_data. ' this serial data';
	$idref=($this->is_column)?$this->clone_ext.'col_'.$this->col_id:(($this->is_blog)?$this->clone_ext.'post_'.$this->blog_id:$this->tablename);
	if (strpos($idref,'tiny')!==false)return;//not sure if still necessary
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
		//$this->backup_page_arr[]=array($db_table,"where $ref_id=".$this->$ref_id,"set $field='$implode_style_arr',{$ref}time='".time()."',{$ref}update='".date("dMY-H-i-s")."', token='".mt_rand(1,mt_getrandmax()). "'");
		}//if submitted
	//now generate css
	foreach ($media_added_style_arr as $index => $array){//$array[1]=str_replace('<br>',"\n",str_replace('=>',',',$array[1]));
		$class_suffix=(array_key_exists($index,$media_added_style_arr)&&array_key_exists(0,$media_added_style_arr[$index])&&strlen($array[0])>1&&!is_numeric($array[0]))?str_replace('=>',',',$array[0]):'';
		$customcss=(array_key_exists($index,$media_added_style_arr)&&array_key_exists(1,$media_added_style_arr[$index]))?str_replace('<br>',"\n",str_replace('=>',',',$array[1])):'';
		$media_maxpx=(array_key_exists($index,$media_added_style_arr)&&array_key_exists(2,$media_added_style_arr[$index])&&$media_added_style_arr[$index][2]>199&&$media_added_style_arr[$index][2]<2001)?$media_added_style_arr[$index][2]:'';
		$media_minpx=(array_key_exists($index,$media_added_style_arr)&&array_key_exists(3,$media_added_style_arr[$index])&&$media_added_style_arr[$index][3]>199&&$media_added_style_arr[$index][3]<3001)?$media_added_style_arr[$index][3]:'';
		$data=str_replace('=>',',',str_replace('break',"\n",$array[1]));//for correct storage in style field value..
		//$datacss=$this->pelement.$class_suffix.',#' 
		$newref=(isset($this->data))?str_replace('.'.$this->data,'#'.$idref,$this->pelement):$this->pelement;//so here we wish to get in the id of each post in order that advanced styles always take precedence regardless of its css order!
		 
		$css_class_id= ($newref===$this->pelement)?$this->pelement.$class_suffix:$this->pelement.$class_suffix.','.$newref;
		 
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
		 $this->show_more('Advanced Styling Options','','infoclick editbackground info editstyle','Manually enter Css &amp; Css @media Rules Here');
		$ptype=($this->is_page)?' body&#123;&#125;':(($this->is_column)?'this column':'this post');
	
	echo '<div><!--custom style-->';
 
	
	echo '<div class="Od2olivedrab fsminfo editbackground '.$this->column_lev_color.' "><!--custom style inner-->';
		printer::printx('<span class="warn1 redAlert ">Caution: Adding curly brackets {} can potentially Break all following CSS Styling</span><br>
		Custom Css Rules Specific For this <b>'.$ptype.'</b> can be manually entered here. Append any further css specificity under suffix. Additionally Choose to add @media screen max-width and min-width media query-css entries for multiple pixel values. When the media New  Fields will appear as needed if additional entries are required. Removing Css will delete the field.<br><br><span style="background: rgb(255,255,255,.33)"> <b>Media Query, Classname and {} will be entered automatically</b></span>');
		$count=$count+4;
		#mediafor
		for ($i=0; $i < $count; $i++){
			$class_suffix=(array_key_exists($i,$media_added_style_arr)&&array_key_exists(0,$media_added_style_arr[$i])&&!is_numeric($media_added_style_arr[$i][0]))?$media_added_style_arr[$i][0]:'';
			$customcss=(array_key_exists($i,$media_added_style_arr)&&array_key_exists(1,$media_added_style_arr[$i]))?str_replace('=>',',',str_replace('break',"\n",$media_added_style_arr[$i][1])):'';   
			$media_maxpx=(array_key_exists($i,$media_added_style_arr)&&array_key_exists(2,$media_added_style_arr[$i])&&$media_added_style_arr[$i][2]>199&&$media_added_style_arr[$i][2]<2001)?$media_added_style_arr[$i][2]:'';
			$media_minpx=(array_key_exists($i,$media_added_style_arr)&&array_key_exists(3,$media_added_style_arr[$i])&&!empty($media_added_style_arr[$i][3]))?$media_added_style_arr[$i][3]:'';
			echo '<div class="editbackground"><!--media array wrap-->';
			echo '<div class="fs4orange editbackground"><!--array wrapper media inner-->';
			echo '<div class="fs1green editbackground editcolor"><!--array wrapper media css-->';
			printer::printx('<p class="info floatleft">#'.$idref.'</p>'); 
			echo '<div class="floatleft"><!--floatwrap css suffix-->';
			if (empty($class_suffix))$this->show_more('Suffix','','tiny info','Add a class suffix');
			$msg=(empty($class_suffix))?'Add optional additional class specifier Here: ':'';
			echo '<p class="editbackground editcolor">'.$msg.'<input type="text" name="media_added_style_'.$this->clone_ext.$field.'_'.$this->$ref_id.'['.$i.'][0]" value="'.$class_suffix.'" size="30" maxlength="100"></p>';
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
			
			echo '<div class="fsmbrown"><!--wrap max width-->';
			printer::printx('<p class="smaller '.$this->column_lev_color.'">Chosen max-width: <span class="navybackground white">'.$cur_maxpx.'</span><br></p>');
			$msgjava='Choose @media screen max-width px:';  
			echo '<div class="editcolor editfont editbackground  click" onclick="gen_Proc.precisionAdd(this,\'media_added_style_'.$this->clone_ext.$field.'_'.$this->$ref_id.'['.$i.'][2]\',200,\'2000\',\''.$media_maxpx.'\',\'px\',\'1\',\''.$msgjava.'\',\'\');">Choose @media screen max-width px</div>';
			printer::printx('<p ><input type="checkbox" name="media_added_style_'.$this->clone_ext.$field.'_'.$this->$ref_id.'['.$i.'][2]" value="0">Remove max-width</p>');
			echo '</div><!--wrap max width-->';
			echo '<div class="fsmbrown"><!--wrap min width-->';
			printer::printx('<p class="smaller '.$this->column_lev_color.'">Chosen min-width: <span class="navybackground white">'.$cur_minpx.'</span></p>');
			 $msgjava='Choose @media screen min-width:';  
				echo '<div class="editcolor editfont editbackground click" onclick="gen_Proc.precisionAdd(this,\'media_added_style_'.$this->clone_ext.$field.'_'.$this->$ref_id.'['.$i.'][3]\',200,\'2000\',\''.$media_minpx.'\',\'px\',\'1\',\''.$msgjava.'\',\'\');">Choose @media min-width px</div>';
			printer::printx('<p ><input type="checkbox" name="media_added_style_'.$this->clone_ext.$field.'_'.$this->$ref_id.'['.$i.'][3]" value="0">Remove min-width</p>');
			echo '</div><!--wrap min width-->';
			echo '</div><!--array wrapper media inner-->';
			
		$this->submit_button();
			echo '</div><!--array wrapper media-->';
			printer::pclear();
			}// end for loop
		printer::printx('<p class="fsminfo tip smaller">Note: Page Related Css &amp; Modified Custom functions affecting  this page only may be made in: <b>includes/'.$this->tablename.'.class.php</b><br>Custom css and functions affecting pages site-wide may be made in: <b>includes/site_master.class.php</b></p>');
		echo '</div><!--custom style inner-->'; 
		printer::pclear();
		echo '</div><!--custom style-->';
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
		else{
			$maxwid=$this->current_net_width;
			$background_image_field='blog_style-blog-' .$val.'-'.$this->blog_order;
			$table=$this->blog_table;
			}
		}
	elseif ($this->is_column) {
		//$blog_style=explode(',',$this->col_style);
		$maxwid=$this->current_net_width;
		$background_image_field=$field.'-column-'. $val;
		$table=$this->col_table;
		}
	elseif ($this->is_page) { 
		$background_image_field=$field.'-page-'.$val;
		$maxwid=Cfg::Default_background_image_width;
		$table=$this->tablename;
		}
	
	
	else {
	echo '</div><!--background issue-->';
		mail::alert('background function issue');
		return;
		}
	(empty($width))&&$width=$maxwid;
	#the above is for uploading background image below...
	#******************************
	
	
	
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
	#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
	if ($this->is_page|| ($this->is_blog&&!$this->is_clone)||($this->is_column&&!$this->is_clone||$this->clone_local_style)){ 
	
		$this->show_more('Background Styling','','info click editfont editbackground','Edit Colors, Gradient   Background Image, Background Video*',400);
		echo '<div class="0s2dodgerblue fsminfo floatleft editbackground"  ><!--background style -->';
		printer::pclear(1);
		
		echo '<div class="editbackground floatleft"><!--show background color floatwrap-->';
		 $this->show_more('Background Color', 'noback','infoclick  editbackground','A background Color and Color Opacity May be Chosen Here',500); 
		#####back
		$colorprint=(!empty($gradient_css)||!empty($back_image_used))?'red':$this->column_lev_color;
		printer::print_wrap('wrap background color','editbackground Os2dodgerblue fsm'.$this->column_lev_color);
		printer::printx( '<div class="fs1black editbackground rad3 '.$colorprint.' editfont"><!--background color-->Background colors will be overridden by valid Background Images or Background Gradients!<br>');
		 
		 if (preg_match(Cfg::Preg_color,$background_array[$background_color_index])){
				 
				 $msg="Change the Current Background Color, Use 0 to remove: #";
				 }
		   else {
			    $msg= (!empty($background_array[$background_color_index]))?$background_array[$background_color_index] . ' is not a valid color code. Enter or choose a new background color code: #':'Enter or Click to choose a  background color code: #';
				 }
	 
		printer::alertx('<span class="info left5" title="Add a background color 3 or 6 digit color code or click in the entry box to open the Color finder tool! Enter any blank or 0 to go back to the parent default">'.$msg.'</span><br>');  
		printer::printx('<p class="floatleft"><input style="cursor:pointer;background:#'.$this->editor_background.';color:#'.$this->editor_color.';" type="text" name="'.$style.'['.$val.']['.$background_color_index.']" id="'.$style.'-'.$val.'_'.$inc.'" value="'. $background_array[$background_color_index].'" size="6" maxlength="6" class="jscolor {refine:false}">' .$span_color.'</p>');
		printer::pclear();
		echo '</div><!--background color-->';
		printer::pclear();
		echo '<div class="editbackground fs1color"><!--border opacity-->';
		echo '<p class="fsminfo  rad3   editfont" style="color:rgba(0,0,255,1); background:rgba(0,0,255,.25);">Background color of this text is set at  blue,   the same hexcode blue as the text except the blue background color has been set  with a 25% opacity. The parent background color is the editbackground color which bleeds through. Change the opacity of your background color by choosing an opacity near 0% for very transparent allowing most of the parent background color or image to bleed through. At 50% opacity we see ~ half background color half parent background and at 100% opacity the parent background is colored over completely! </p>';
		echo '<p class="editcolor editbackground ">Change Background Color Opacity:  </p>';
		$this->mod_spacing($style.'['.$val.']['.$background_opacity_index.']',$background_color_opacity,1,100,1,'%',false);
		 
		echo '</div><!--border opacity-->';
		printer::close_print_wrap('wrap background color','Os2dodgerblue fsm'.$this->column_lev_color);
		$this->show_close('back colors');echo '<!--show back colors-->';
		echo '</div><!--show background color floatwrap-->';
		echo $span_color;
		printer::pclear();
		//printer::printx('<p class="floatleft fsminfo editbackground '.$this->column_lev_color.' editfont">OR Instead of a Background Color Use:</p>');
		printer::pclear(1);
		###############3
		echo '<div class="floatleft"><!--show background gradient floatwrap-->';
		$this->show_more('Background Gradients', 'noback','infoclick editbackground','A background Color Gradient of 2 or more colors may be  used instead of a single color',500);echo '<!--show gradients-->';
		printer::print_wrap('gradient wrap','Os2dodgerblue editbackground' );
		echo '<div class="fsmblack whitebackground"><!--show gradients-->';
		
			echo '<div class=" rad3 utilitygrad '.$gradcolor.' editfont floatleft"><div style="margin: 30px auto; width:80%; padding:10px;  background:rgba(255,255,255,.65);">We have used a background gradient behind this info box using the diagonal top left  option and using six colors  to demonstate how a  page or column background effect can be used together along with a post having a white background set at 65% opacity which allows some of the background to bleed through.  When making a gradient Use from two to six colors when making a background gradient  effect. Set any degree on your gradient color choices which will allow the parent background color to bleed through to the degree of the percentage chosen.  Selecting the transparent option without a valid color is still a valid choice and will display 100% background. Otherwise a valid color option must be selected.';
			printer::pclear();	
			
			$this->show_more(' more gradient info', 'cnoback','click floatleft editfont editbackground');
			printer::printx('Gradient options include none, vertical (top to bottom),  horizontal (left to right gradient),  diagonal top left (a diagonal gradient from top left to bottom  right), repeating diagonal top left,  diagonal top right (a diagonal gradient from top right to bottom left),  radial ellipse (elliptical from inner to outer) and radial circle (circlular from inner to outer).  In additon each choice has a corresponding <b>repeating</b> option. Set how many times the gradient should repeat by setting a colorstop on the last valid color/transparent option of the gradient.  If its set to 50% the gradient can repeat twice, if it is set to 33.3% the gradient will repeat 3 times, 25% and the gradient can repeat 4 times, 40% and the gradient will repeat 2.5 times and so on!!.<span class="'.$colorprint.'">Note: Background Images Will Override Background Gradients</span>');
			$this->show_close('utilitygrad');
			echo '</div></div><!--end utilitygrad-->';
			
			#background_gradient_type,background_gradient_color1,background_gradient_color2,background_gradient_color3,background_gradient_color4,background_gradient_color5,background_gradient_color6
		#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
		
		
		
		printer::printx('<p class="'.$this->column_lev_color.' editfont editbackground">Choose Which Gradient Type: Currently: '.$background_gradient_type.'<br>');
		 
		echo '<select class="editcolor editbackground"  name="'.$style.'['.$val.']['.$background_gradient_type_index.']" >        
		<option  value="'.$background_gradient_type.'" selected="selected">'.$background_gradient_type.'</option>'; 
		foreach ($background_gradient_type_array as $type){
			echo'<option  value="'.$type.'">'.$type.'</option> ';
			}
		echo '</select></p>';
		##%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%5
		printer::printx('<p class="info editfont editbackground" title="By default opacity is 100%.  If you choose the transparent option which is 0% opacity, Skip choosing a color if you wish!">Choose Your Background Gradient Colors and Opacity:<br></p>');
		for ($i=1; $i<7; $i++){
			echo '<div class="fs2black editbackground floatleft"><!--choose grad color-->';
			$opacity=(empty($background_array[${'background_gradient_transparency'.$i.'_index'}]))?100:$background_array[${'background_gradient_transparency'.$i.'_index'}];
			$span_color='<span class="fs1npred" style="background:#'. $background_array[${'background_gradient_color'.$i.'_index'}].'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>';
			 printer::printx('<p class="editfont editcolor editbackground">Enter Color Hexcode or Choose Color# '.$i.'&nbsp;<input style="cursor:pointer;background:#'.$this->editor_background.';color:#'.$this->editor_color.';" type="text" name="'.$style.'['.$val.']['.${'background_gradient_color'.$i.'_index'}.']" id="'.$style.'-'.$val.'_'.$inc.$i.'" value="'. $background_array[${'background_gradient_color'.$i.'_index'}].'" size="6" maxlength="6" class="jscolor {refine:false}" >'.$span_color.'<span style="font-size: 1.1em; color: yellow;" id="'.$style.'-'.$val.'_'.$inc.$i.'instruct"></span></p>');
			 printer::printx('<p class="editfont editcolor editbackground">Set an opacity:</p>');
			 $this->mod_spacing($style.'['.$val.']['.${'background_gradient_transparency'.$i.'_index'}.']',$opacity,1,100,1,'%',false,'transparent');
			 $this->show_more('Optional Colorstop for Color#'.$i,'noback','click editbackground smaller '.$this->column_lev_color);
			 echo '<div class="fsminfo editbackground editfont '.$this->column_lev_color.'"><!--color stop-->Gradient Colors will normally blend evenly spaced, however specifying a Colorstop percentage  determines at which point along the gradient the color will stop blending';
			$colorstop=(empty($background_array[${'background_gradient_color_stop'.$i.'_index'}]))?'none':$background_array[${'background_gradient_color_stop'.$i.'_index'}];
		
			$this->mod_spacing($style.'['.$val.']['.${'background_gradient_color_stop'.$i.'_index'}.']',$colorstop,3,100,1,'%',false,'none');
			echo '</div><!--color stop-->';
			$this->show_close('color stop');
			
			 echo '</div><!--choose grad color-->';
			  
			 }
		echo '<div class="editfont editcolor editbackground"><!--wrap position radial-->';
		$this->show_more('Optionally Position Radial Gradient','noback','click editbackground smaller '.$this->column_lev_color,'','',150);
		 echo '<p class="fsminfo editbackground '.$this->column_lev_color.'">Radial Gradients (ellipses and circles) will Normally Be Centered Positioned. Its also possible Choose To Custom Size and Position Your Gradient Here. See http://gradientcss.com/radial-gradient for a detailed explanation of the gradient options!</p>';
		printer::printx('<p class="'.$this->column_lev_color.' editbackground editfont">Change Radial Horizontal Position (default:50%) Currently: '.$background_gradient_position1.'%<br></p>');
		$this->mod_spacing($style.'['.$val.']['.${'background_gradient_position1_index'}.']', $background_gradient_position1,0,100,1,'%');
		printer::printx('<p class="'.$this->column_lev_color.' editbackground editfont">Change Radial Vertical Position (default:50%) Currently: '.$background_gradient_position2.'%<br></p>');
		$this->mod_spacing($style.'['.$val.']['.${'background_gradient_position2_index'}.']',$background_gradient_position2,0,100,1,'%');
			printer::printx('<p class="'.$this->column_lev_color.' editbackground editfont">Optionally Change Radial Sizing Keyword: Currently: '.$background_gradient_position_keyword.'<br></p>');
		 $background_gradient_keyword_array=array('closest-side','closest-corner','farthest-side','farthest-corner');
		echo '<select class="editcolor editbackground"  name="'.$style.'['.$val.']['.$background_gradient_position_keyword_index.']" >        
		<option  value="'.$background_gradient_position_keyword.'" selected="selected">'.$background_gradient_position_keyword.'</option>'; 
		foreach ($background_gradient_keyword_array as $type){
			echo'<option  value="'.$type.'">'.$type.'</option> ';
			}
		echo '</select>'; 
		 
		$this->show_close('Position radial gradient');//Position radial gradient
		echo '</div><!--wrap position radial-->';
		
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
		 $this->show_more('Background Image', 'noback','infoclick editbackground',' Use a Background Image  instead of color or color gradients.  Use them in posts, columns and menu link buttons',500);
		if(!empty($background_array[$background_video_index]))
			printer::print_caution('Note: Background image may be overriden by working background video',.7); 
		printer::print_wrap('wrap background image','editbackground Os2dodgerblue fsm'.$this->column_lev_color);
		echo '<div class="fsminfo editbackground rad3 '.$this->column_lev_color.' editfont"><!--background image enter-->A background image behaves similar to background color.  It may also be positioned if necessary<br>'; 
		if (is_file(Cfg_loc::Root_dir.Cfg::Background_image_dir.$background_array[$background_image_index])){    
		   $msg2='Change the current Background Image to another previously uploaded image or click the image below to upload a new one:';
		   //$background_image=$background_array[$background_image_index];
		   $size	= GetImageSize(Cfg_loc::Root_dir.Cfg::Background_image_dir.$background_array[$background_image_index]);
		   $width 			= $size[0];
		   $height 		= $size[1];
		   }
	    else {
			$width=0;
			$msg2=(empty($background_array[$background_image_index]))?'No Background Image in Use:  Enter a previously uploaded Image or click the link below to upload a new one:':'The Current Background Image is Not a Valid file: Enter a previously Uploaded Image or click the link below to upload a new one:';
			$background_image="";
			}
		##printer::alert($msg2.'<input style="cursor:pointer;background:#'.$this->editor_background.';color:#'.$this->editor_color.';" type="text" name="'.$style.'['.$val.']['.$background_image_index.']" value="'.$background_array[$background_image_index].'" size="35" maxlength="70" ><br>');
		echo '</div><!--background image enter-->';
		echo '<div class="'.$this->column_lev_color.' fsminfo editbackground"><!--Upload background image-->Upload a Larger than Needed Background Image Size and the Size Will Always Be Updated to Match the Current Width   + any Padding Left &amp; Right Space Added. Margin Spacings Are Always Outside of Background Effects. Repeating images horizontally, and Uploaded Images smaller than the spaces provided will remain their original sizes!!<br>';
		$clone_local_style=($this->clone_local_style)?'&amp;clone_local_style=1':'';
		printer::alert('<a href="add_page_pic.php?wwwexpand=0&amp;www='.$imagepx.'&amp;ttt='.$table.'&amp;fff='.$background_image_field.'&amp;postreturn='.Sys::Self.'&amp;pgtbn='.$this->tablename.'&amp;bbb=background_image_style'.$clone_local_style.'&amp;css='.$this->roots.Cfg::Style_dir.$this->tablename.'&amp;sess_override&amp;sess_token='.$this->sess->sess_token.'"><u> Upload a new background image ...</u></a>');
			 
		echo '</div><!--Upload background image-->';
		echo '<div class="fsminfo editbackground rad3 '.$this->column_lev_color.'"><!--configure background image -->Configure Your Background Image:<br>';
		 
		if(!empty($background_array[$background_image_index])&&!empty($background_array[$background_image_use_index])){
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
					$tid=($this->is_blog)?$this->blog_id:(($this->is_column)?$this->col_id:'pageback '.$this->tablename);
					mail::alert('Missing Background image: '.$background_array[$background_image_index]. ' in Ref:'.$tid);
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
		 if (is_file(Cfg_loc::Root_dir.Cfg::Background_image_dir.$background_array[$background_image_index])&&$background_array[$background_image_use_index]==1){
			
			if ($this->edit&&(empty($background_array[$background_repeat_index])||$background_array[$background_repeat_index]=='no-repeat'||$background_array[$background_repeat_index]=='repeat-y')&&!$background_array[$background_image_noresize_index]){  
				list($width,$height)=$this->get_size($background_array[$background_image_index],Cfg_loc::Root_dir.Cfg::Background_image_dir);
				 
				if ($imagepx > $width*1.03 || $imagepx < $width * .97){
					$return=$this->resize($background_array[$background_image_index],$imagepx,0,0,Cfg_loc::Root_dir.Cfg::Upload_dir,Cfg_loc::Root_dir.Cfg::Background_image_dir,'backgroundimage field: '.$field.' style:'.$style,'file','Background Image',NULL,'95','center',false );
					($return)&&$this->success[]='<img src="'.Cfg_loc::Root_dir.Cfg::Background_image_dir.$background_array[$background_image_index].'" class="floatleft" height="50" ><p class="pl10 maxwidth400 small floatleft">This Background Image photo '.$background_array[$background_image_index].' in Post Id'.$this->blog_id.' was resized to width '. $imagepx;
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
			if(!empty($background_array[$background_repeat_index])&&$background_array[$background_repeat_index]==${'a'.$i}){ ${'b'.$i}=' checked="checked" ';$flag=true; }
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
		
		echo'<p class="editcolor editbackground editfont">
		Image Position left (0) to right (100) Change: 
		<select class="editcolor editbackground"  name="'.$style.'['.$val.']['.$background_horiz_index.']">         
		<option class="'.$poshclass.' editcolor editbackground" value="'.$bhval.'" selected="selected">'.$bhval.'</option>';
		for ($i=0; $i<101; $i+=1){
			echo  "\n".'<option  value="'.$i.'">'.$i.' </option>';
			}
		echo'
		 </select><br>Image Position top (0) to bottom (100) Change: 
		<select class="'.$posvclass.' editcolor editbackground"  name="'.$style.'['.$val.']['.$background_vert_index.']">         
		<option  value="'.$bvval.'" selected="selected">'.$bvval.'</option>';
		for ($i=0; $i<101; $i+=1){
			echo  "\n".'<option  value="'.$i.'">'.$i.' </option>';
			}
		echo'
		</select></p>';
		
		echo '</div><!--configure background image -->';
	echo '<div class="fsminfo editbackground rad3 '.$this->column_lev_color.' editfont"><!--Background Image Size-->Choose Background Image Size:<br>';
	$a1='auto'; $a2='cover'; $a3='contain'; $a4='hundred';$a5='custom';
		$b1=$b2=$b3=$b4=$b5='';$flag=false;
		for ($i=1;$i<6;$i++){
			if(!empty($background_array[$background_size_index])&&$background_array[$background_size_index]==${'a'.$i}){ ${'b'.$i}=' checked="checked" ';$flag=true; }
			}
		(!$flag)&&$b1=' checked="checked" ';
		printer::alertx('
	    <p class="info" title="Use Original Uploaded Image Size" ><input name="'.$style.'['.$val.']['.$background_size_index.']" type="radio" value="auto" '.$b1.' >Use As Is Image Size</p>
	    <p class="info" title="Image resized to 100% width and height scaled to maintain width/height ratio"><input  name="'.$style.'['.$val.']['.$background_size_index.']" type="radio" value="cover" '.$b2.'>Cover to Full Width</p>
	    <p class="info" title="Image is proportionally scaled to maximum size without exceeding full width or full height" ><input name="'.$style.'['.$val.']['.$background_size_index.']" type="radio" value="contain" '.$b3.'>Contain Width</p>
	    <p class="info" title="Image width and height each independenly stretched to occupy 100% of the available space."><input  name="'.$style.'['.$val.']['.$background_size_index.']" type="radio" value="hundred" '.$b4.'>Image to Fill 100% width and 100% height</p>'); 
		//echo '<div class="fs1npinfo floatleft"><!--wrap background size-->';
		printer::alertx('<p onclick="edit_Proc.displaythis(\''.$style.'_displaypercent\',this,\'#fdf0ee\')"  class="info" title="Enter Percentage of Width to Fill, Percentage of Height to Fill" ><input class="myinput" name="'.$style.'['.$val.']['.$background_size_index.']" type="radio" value="custom" '.$b5.' >Use Custom Percentage for width and height&nbsp;</p>');
		$display=($background_array[$background_size_index]===$a5)?'block':'none'; 
		echo'<p style="display:'.$display.'" id="'.$style.'_displaypercent" class="editcolor editbackground ">
		Image Size Fill Percentage of Available Width: 
		<select class="editcolor editbackground"  name="'.$style.'['.$val.']['.$background_pos_width_index.']">         
		<option  value="'.$background_array[$background_pos_width_index].'" selected="selected">'.$background_array[$background_pos_width_index].'%</option>';
		for ($i=0; $i<101; $i+=1){
			echo  "\n".'<option  value="'.$i.'">'.$i.'% </option>';
			}
		echo'
		 </select><br>Image Size Fill Available Height Change: 
		<select class="editcolor editbackground"  name="'.$style.'['.$val.']['.$background_pos_height_index.']">         
		<option  value="'.$background_array[$background_pos_height_index].'" selected="selected">'.$background_array[$background_pos_height_index].'%</option>';
		for ($i=0; $i<101; $i+=1){
			echo  "\n".'<option  value="'.$i.'">'.$i.'% </option>';
			}
		echo'
			</select></p>';
			 
	//echo '</div><!--wrap background size-->';
	printer::pclear();
	echo '</div><!--Background Image Size-->';
	echo '<div class="fsminfo editbackground"><!--Image opacity-->';
	echo '<p class="editcolor editbackground ">Change Background Image Opacity:  </p>';
		$this->mod_spacing($style.'['.$val.']['.$background_image_opacity_index.']',$background_image_opacity,1,100,1,'%',false);
	echo '</div><!--image opacity-->';
	echo '<div class="fsminfo"><!--wrap resize fixed-->';
				 
		if (empty($background_array[$background_fixed_index])){
			printer::alertx('<p class="info editfont editbackground" title="When you Scroll Down the Page The Background Image Normally Scrolls Also But with a Checked Box Here the Background Image will Remain Stationary"><input type="checkbox"  name="'.$style.'['.$val.']['.$background_fixed_index.']"  value="1">Check for a Stationary Background Image</p>');
			}
		else {
			printer::alertx('<p class="info editfont  editbackground" title="When you Scroll Down the Page The Background Image Normally Scrolls Also But with a Checked Box Here The Body Background Image is currently Set to Remain Fixed and Not Scroll Down As You Scroll Down."><input type="checkbox"  name="'.$style.'['.$val.']['.$background_fixed_index.']"  value="1">Check to Scroll the Body Background Image</p>');
			}
		if ($background_array[$background_image_noresize_index]==1)
			printer::alertx('<p class="info smallest" title="Allow Background Images to be resized when post is resized according to available width and image size"><input name="'.$style.'['.$val.']['.$background_image_noresize_index.']" type="checkbox" value="0" >Allow Background Image Resizing<br></p>');
		else printer::alertx('<p class="info smallest" title="Prevent Background Images from being resized (and image resize messages when updating) "><input name="'.$style.'['.$val.']['.$background_image_noresize_index.']" type="checkbox" value="1" >Prevent Background Images from resizing<br></p>');
		
		echo '</div><!--wrap resize fixed-->'; 
		printer::pclear(2);
		printer::close_print_wrap('wrap background image');
		
		$this->show_close('background');//background
		#########videoback
		/*if ($field==='blog_style'||$field==='col_style'||$field==='page_style'){
		$this->show_more('Upload Background Video','noback','infoclick editbackground',' Videos can be used instead of a background color! Use them in posts, columns and menu link buttons',800);
		
			printer::print_wrap('Upload Background Video','Os3aqua fsminfo editcolor editbackground');
			
			$this->show_more('More Config Info','','small info click');
			$msg='For animated Gifs upload like ordinary background images. But Here its possible to upload mp4 videos for responsive background effect and best support with recommended codec H264. Also accepted for upload: webm, ogg and m4v';
			$id=($this->is_page)?$this->page_id:(($this->is_column)?$this->col_id:$this->blog_id);
			$id_ref=($this->is_page)?'page_id':(($this->is_column)?'col_id':'blog_id');
			
			printer::print_tip($msg);
			$this->show_close('More Config Info'); 
			#videoback
			#heres another attempt to flat file and save making a separate db field for
			echo'<p class="editcolor editbackground editfont"> <a href="add_page_vid.php?ttt='.$this->tablename.'&amp;type=background&amp;fff='.$field.'&amp;id='.$id.'&amp;id_ref='.$id_ref.'&amp;pgtbn='.$this->tablename.'&amp;postreturn='.Sys::Self.'&amp;css='.$this->roots.Cfg::Style_dir.$this->tablename.'&amp;sess_override&amp;sess_token='.$this->sess->sess_token.'"><u>Upload New Background Video</u></a></p>';
			$checked1=($background_array[$background_video_display_index]==='no_display')?'':'checked="checked"'; 
			$checked2=($background_array[$background_video_display_index]!=='no_display')?'':'checked="checked"'; echo $background_array[$background_video_display_index].' is display';
			printer::print_wrap('display','fs1salmon editcolor editbackground');
				printer::alert('<input type="radio" name="'.$style.'['.$val.']['.$background_video_display_index.']" '.$checked1.' value="display" >Display background video');
			  printer::alert('<input type="radio" name="'.$style.'['.$val.']['.$background_video_display_index.']" '.$checked2.' value="no_display" >No background video');
			printer::close_print_wrap('display');
			
			printer::print_tip('Videos will resize automatically to fill the available width and height completely.  Enter the width/height ratio of your video for proper proportions');
			printer::alert('Change the ratio of width over height to get the proper video aspect ratio<input type="text" name="'.$style.'['.$val.']['.$background_video_ratio_index.']" value="'.$background_video_ratio.'" size="5" maxlength="5">');
			printer::close_print_wrap('Upload Background Video');
			$this->show_close('Upload Background Video');
			}####################End backvideo*/
		 echo '</div><!--  show more background floatwrap-->';
		if(!empty($background_array[$background_image_index])&&!empty($background_array[$background_image_use_index])&&is_file(Cfg_loc::Root_dir.Cfg::Background_image_dir.$background_array[$background_image_index])){
			 $opacitybackground=true;
			$size=($width/$height >1)?'width="25"':'height="25"'; 
			printer::printx('<img  class="fs1npred mt5" src="'.Cfg_loc::Root_dir.Cfg::Background_image_dir.$background_array[$background_image_index].'" '.$size.' alt="background image">');
			}
		  
			 
		echo '</div><!--background style border -->';
		$this->show_close('background');//<!--show close background-->';
		printer::pclear(2);
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
	$video_css= (!empty($background_array[$background_video_index])&&strlen($background_array[$background_video_index])>30&&($field==='blog_style'||$field==='col_style'))?'position:relative;z-index:1;':''; 
			$fstyle='final_'.$style; 
			 
	if ($background_image_opacity>95||!$opacitybackground){
		$background_image=(is_file(Cfg_loc::Root_dir.Cfg::Background_image_dir.$background_array[$background_image_index])&&!empty($background_array[$background_image_use_index]))?$background_fixed.' background-image:url('.Cfg_loc::Root_dir.Cfg::Background_image_dir.$background_array[$background_image_index].'); '.$background_repeat . $background_position.$background_size :(($background_array[$background_image_none_index])?'background-image:none;':'');  
		$fstyle='final_'.$style;
		$this->{$fstyle}[$val]=$background_color.$gradient_css.$background_image.$video_css; 
		if ($this->is_page&&$field=='page_style')$this->page_background=$background_color.$gradient_css.$background_image;
		}
	else{ 
		if ($this->is_page&&$field=='page_style'&&!empty($background_color.$gradient_css))  $this->page_background=$background_color.$gradient_css;
		 $fstyle='final_'.$style; 
		$this->{$fstyle}[$val]='position:relative;z-index:1;'.$background_color.$gradient_css;
		$background_image=(is_file(Cfg_loc::Root_dir.Cfg::Background_image_dir.$background_array[$background_image_index])&&!empty($background_array[$background_image_use_index]))?$background_fixed.' background-image:url('.Cfg_loc::Root_dir.Cfg::Background_image_dir.$background_array[$background_image_index].'); '.$background_repeat .' left: '.$bhval.'%; top:'.$bvval.'%;'.$background_size :(($background_array[$background_image_none_index])?'background-image:none;':'');
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
		}//end opacity
	 }//end background#end background
	
	
function text_align($style, $val, $field){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	$display=($this->show_text_style)?'':' style="display:none;"';
	$class=($this->show_text_style)?'':'fsminfo';
	$txtmsg=(($this->is_blog&&$this->blog_type==='navigation_menu')&&$field==='blog_style')?'Link Align: ':'Text Align: ';
	$title=(($this->is_blog&&$this->blog_type==='navigation_menu')&&$field==='blog_style')?'This setting will change the positioning of Links within Navigation Menus':'Select Left right or Center Align the text widthin this post/Can also Effect Image. If none is selected it will inherit the value from the parent &#40;Which may be a Column or the Body Setting&#41;';
	if ($this->is_page|| ($this->is_blog&&!$this->is_clone)||($this->is_column&&!$this->is_clone||$this->clone_local_style)){  
		$textalign= (empty($this->{$style}[$val]))? 'Inherited': $this->{$style}[$val];
		echo '<div class="'.$class.' editbackground floatleft '.$style.'_hidefont"'.$display.'><!--text align border-->';
		echo'<p class="information" title="'.$title.'">'.$txtmsg.' Currently '.$textalign.'</p>';
		echo '<p>
		<select class="editcolor editbackground"  name="'.$style.'['.$val.']" id="'.$style.'_'.$val.'">        
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
		forms::form_dropdown($arr,$arr2,'','',$style.'['.$val.']',$sval,false,'editcolor editbackground left');
		echo '</div><!--Edit line height-->';
	}
	 $fstyle='final_'.$style;
	$this->{$fstyle}[$val]=($sval!==100)?'line-height:'.$sval.'%;':'';
	}//end function

function letter_spacing($style,$val){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
    $sval=(!empty($this->{$style}[$val])&&$this->{$style}[$val]>-.22&&$this->{$style}[$val]<7)?$this->{$style}[$val]:0;
	if ($this->is_page|| ($this->is_blog&&!$this->is_clone)||($this->is_column&&!$this->is_clone||$this->clone_local_style)){  
		echo '<div class="fs1color floatleft '.$style.'_hidefont" style="display:none;"><!--Edit letter spacing-->'; 
		echo '<p class="'.$this->column_lev_color.' editfont ">Add or Subtract space between letters</p>'; 
		$arr=array(-.1,-.05,0,.05,.1,.15,.2,.25);
		$arr2=array('-.1em','-.05em','0em normal','.05em','.1em','.15em','.2em','.25em');
		forms::form_dropdown($arr,$arr2,'','',$style.'['.$val.']',$sval,false,'editcolor editbackground left'); 
		//$this->mod_spacing($style.'['.$val.']',$sval,-.1,2,.05,'em');
		echo '</div><!--Edit letter spacing-->';
	}
	 $fstyle='final_'.$style;
	$this->{$fstyle}[$val]=(!empty($sval)&&is_numeric($val))?'letter-spacing:'.$sval.'em;':'';
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
		  //echo $this->{$style}[$val].' is val of this style var and whether equals '.$var;
		 
		if (array_key_exists($val,$this->$style)&&$this->{$style}[$val]) :
			echo '<p class="'.$this->column_lev_color.' editfont '.$style.'_hidefont" style="display:none; text-align: left;"><input type="checkbox"  name="'.$style.'['. $val .']"   value="0">Turn Off '. $functions[$val].'</p>';
		else :
			echo '<p class="'.$this->column_lev_color.' editfont '.$style.'_hidefont" style="display:none;text-align: left;"><input type="checkbox"  name="'.$style.'['. $val .']"  value="1">Turn On '. $functions[$val].'</p>';
		endif;
		 
		 
		}
	 $fstyle='final_'.$style; 
	$this->{$fstyle}[$val]=($this->{$style}[$val])?$var:'';
	 }
	 
 
 
function background_color($style, $val, $field){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	
	if ($this->is_page|| ($this->is_blog&&!$this->is_clone)||($this->is_column&&!$this->is_clone||$this->clone_local_style)){  
		static $fontcinc=0; $fontcinc++;
		 
		printer::pclear();
		$span_color=(!empty($this->{$style}[$val]))?'<span class="fs1npred" style="background-color:#'.$this->{$style}[$val].';">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>':'';
		echo'
		  <p class="information" title="Change the background color (font) of your element by Entering a valid font color 3 or 6 digit color code. Clicking the entry box opens the Color finder tool! Enter any blank or 0 to go back to the parent default">Enter/Choose Background Color : #<input style="cursor:pointer;background:#'.$this->editor_background.';color:#'.$this->editor_color.';"  class="jscolor {refine:false}"   name="'.$style.'['.$val.']"  id="'.$style.'_'.$val.'" value="'.$this->{$style}[$val].'"
		size="6" maxlength="6"  >'.$span_color.'<span style="font-size: 1.1em; color:#'.Cfg::Info_color.';" id="'.$style.'_'.$val.'instruct"></span></p>  
		';
	 	printer::pclear(1); 
		}
	 $fstyle='final_'.$style;
	$this->{$fstyle}[$val]=(!empty($this->{$style}[$val])&&preg_match(Cfg::Preg_color,$this->{$style}[$val]))?'background-color: #'.$this->{$style}[$val].';':'background-color: #'.$this->current_background_color.';';
    
     
    } 
 
 
 
function font_color($style, $val, $field ,$msg=''){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	if ($this->is_page|| ($this->is_blog&&!$this->is_clone)||($this->is_column&&!$this->is_clone||$this->clone_local_style)){  
		static $fontcinc=0; $fontcinc++;
		(empty($msg))&&print '<p class="infoclick floatleft" id="font'.$fontcinc.'"  onclick="edit_Proc.getTags(\''.$style.'_hidefont\',\'showhide\',id);return false;">Text Styles</p>';
		if (!empty($msg)) {
			$hidefont='';
			$bordercolor='';
			$styledisplay='';
			}
			else {
			$msg='Enter/Choose Font Color';
			$hidefont=$style.'_hidefont';
			$bordercolor='fsminfo editbackground';
			$styledisplay='style="display:none"';
			} 
		printer::pclear();  
		$background=(preg_match(Cfg::Preg_color,$this->{$style}[$val]))?'background: #'.$this->{$style}[$val].';':'background: #'.$this->current_color.';';   
		$span_color='<span class="fs1npred" style="color:#'.$this->current_background_color.';'.$background.'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>';
		$currentcolor=(preg_match(Cfg::Preg_color,$this->{$style}[$val]))?$this->{$style}[$val]:'inherited';
		echo'
		<div class="'.$bordercolor.' floatleft '.$hidefont.'" '.$styledisplay.'> <p class="information" title="Change the text color (font) of this post by Entering a valid font color 3 or 6 digit color code or clicking in the entry box which opens the Color Selector tool! Enter any blank or 0 to go back to the inherited parent color &#40;Inherited Parent Values are the most recent values that have been set in the parent Columns and if not set there then in the body or the default white!!">'.$msg.' : #<input style="cursor:pointer;background:#'.$this->editor_background.';color:#'.$this->editor_color.';"  class="jscolor {refine:false}"   name="'.$style.'['.$val.']"  id="'.$style.'_'.$val.'" value="'.$currentcolor.'"
		size="6" maxlength="6"  >'.$span_color.'<span style="font-size: 1.1em; color:#'.Cfg::Info_color.';" id="'.$style.'_'.$val.'instruct"></span></p>  
		';
		printer::pclear(1);
		// $this->color_info();
		
		echo'
		</div>';
		}
	$fstyle='final_'.$style;
	$this->{$fstyle}[$val]=(!empty($this->{$style}[$val])&&preg_match(Cfg::Preg_color,$this->{$style}[$val]))?'color: #'.$this->{$style}[$val].';':0;//'color: #'.$this->current_color.';';   
    }
 
  
  
function tech_talk(){if (isset($_POST['deletecolumn']))return;//prevent error
	$this->show_more('tech info','noback','fs2info editbackground infoclick left5 right5','Click for Tech Information',500);
	 echo '<div class="editbackground fsminfo editbackground maxwidth500  '.$this->column_lev_color.' floatleft"><!--tech info-->';
	
	
	 $this->blog_order_array[0]='';
	  
	  
	printer::alertx('<p class="info left" title="Unique Column Id: C'.$this->col_id.' would be Used for Copying/Mirroring/Moving This Entire Column">The Unique Column Id: C'.$this->col_id.'</p>');
	printer::alert('Present <span class="info" title="The column level depth refers to columns within columns ie. level 2 would be a nested column within a nested column within a primary column">column level depth</span>: '.($this->column_level),'','editcolor editbackground left');
	printer::pclear(2);
	//print_r($this->blog_order_array); echo 'is blog order array'.NL;
	//print_r($this->column_fol_arr); echo 'is col fol  array'.NL;
	//print_r($this->column_order_array);echo 'is col num array'.NL;
	//print_r($this->column_id_array); echo 'is col id array'.NL;
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
function publish($id){  
	$q="update $this->master_post_table set token='".mt_rand(1,mt_getrandmax()). "',blog_update='".date("dMY-H-i-s")."',blog_time='".time()."',blog_pub=1 where blog_col=$id";   
	$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);  
	 $q="select  blog_data1  from  $this->master_post_table where blog_type='nested_column' and blog_col=$id";   
	$rx=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);   
	if ($this->mysqlinst->affected_rows()) {
		while(list($col_id)=$this->mysqlinst->fetch_row($rx,__LINE__)){
			$this->publish($col_id); 
			}
		}
	}
	
#coldata
#cd
function col_data($prime=false){
	self::$xyz++;
	$this->col_width=(empty($this->col_width)||!is_numeric($this->col_width))?0:$this->col_width;
	 if (isset($_POST[$this->col_table.'_express_pub']))$this->publish($this->col_id);
	if ($prime){//set primary defaults
		$this->grid_width_available=array();
		$this->bp_total_arr=array();
		$this->column_net_width_percent=array();
		$this->current_net_width_percent=100;
		$this->column_use_grid_array=array();
		$this->column_bp_width_arr=array();
		$this->grid_width_available=array();
		$this->max_width_limit=$this->column_total_width[0];
		$this->column_id_array=array();
		}
	$this->background_video('col_style');	
	$tablename=($this->is_clone&&$this->clone_local_style)?'clone_'.$this->col_table:$this->col_table; 
	//(!$prime)&&$this->col_blog_data=$this->data;//when using nested column parent blog data names
	//used in styling suchas advanced styles
	$col_id=$this->col_id;
	$this->col_order=self::$col_count++;   
	//$this->col_order_max=max($this->col_order,$this->col_order_max); 
	#&&&&&&&&&&&&&&&& END CLONE STYLING OPTION  &&&&&&&&&&&&&7*/
	$blog_id=($this->column_level==0)?0:$this->blog_id;
	$this->blog_id_arr[$this->column_level]=$blog_id;
	$this->column_id_array[$this->column_level]=$col_id;
	  
	$this->column_use_grid_array[$this->column_level]=$this->column_options[$this->column_use_grid_index]; 
	//$this->column_table_array[$this->column_level]=$tablename;
	$this->column_level_base[$this->column_level]=$this->col_table_base;
	$this->current_overall_floated_total[$this->column_level]=0;//initiate 
	$styles=explode(',',$this->col_style);
	for ($i=0; $i<count(explode(',',Cfg::Style_functions));$i++){
			(!array_key_exists($i,$styles))&&$styles[$i]='';
			}
	
	$this->current_background_color=$this->column_background_color_arr[$this->column_level]=(preg_match(Cfg::Preg_color,explode('@@',$styles[$this->background_index])[0]))?explode('@@',$styles[$this->background_index])[0]:((array_key_exists($this->column_level-1,$this->column_background_color_arr))?$this->column_background_color_arr[$this->column_level-1]:'ffffff');
	$this->current_color=$this->column_color_arr[$this->column_level]=(preg_match(Cfg::Preg_color,$styles[$this->font_color_index]))?$styles[$this->font_color_index]:((array_key_exists($this->column_level-1,$this->column_color_arr))?$this->column_color_arr[$this->column_level-1]:'000000'); 
	$this->current_font_px=$this->column_font_px_arr[$this->column_level]=(!empty($styles[$this->font_size_index])&&$styles[$this->font_size_index]>=.3&&$styles[$this->font_size_index]<=4.5)?$styles[$this->font_size_index]*16:((array_key_exists($this->column_level-1,$this->column_font_px_arr))?$this->column_font_px_arr[$this->column_level-1]:16);
	 $this->column_fol_arr[$this->column_level]= (isset($this->blog_unstatus)&&$this->blog_unstatus=='unclone')?' WHICH IS AN <span class="red">MIRROR RELEASE</span> within the parent <span class="red">MIRRORED</span> Column' :((isset($this->blog_unstatus)&&$this->blog_unstatus!=='null'&&$this->blog_status=='clone')?' WHICH IS DIRECTLY <span class="red">mirrorD</span> ':(($this->is_clone&&$this->column_level==0)? ' GAVE RISE TO A <span class="red">MIRROREDD</span> PARENT COLUMN#' :(($this->is_clone)?' WHICH IS INDIRECTLY <span class="red">MIRRORED</span> ':''))); 
	 
	//populate values
	$this->column_total_width_percent[$this->column_level]=($this->column_level>0)?($this->column_total_width_percent[$this->column_level-1]*$this->col_width/100):100; 
	$this->column_total_width[$this->column_level]=$this->current_total_width;//set in total_float  max float only
		$this->column_net_width[$this->column_level]=$this->current_net_width;
	$this->column_net_width_percent[$this->column_level]=($this->column_level>0)?$this->current_net_width_percent:100;
	$this->column_total_net_width_percent[$this->column_level]=($this->column_level>0)?$this->column_total_net_width_percent[$this->column_level-1]*$this->current_net_width_percent/100:100;
	//set in total float  refers to max width
	// $this->post_ref_array[$this->column_level]=$tablename;
	$this->column_order_array[$this->column_level]=$this->col_order;
	//$this->column_num_array[$this->column_level]=$this->col_num;_
	$this->column_id_array[$this->column_level]=$this->col_id;
	$this->blog_order_array[$this->column_level]=$this->blog_order_mod; 
	 printer::pclear();	if(Sys::Custom)return;
	if (!$this->edit)return; 
	$fmsg='';
	#clone status for columns is held in col_clone where since primary columns cannot be cloned and uncloned   unclone status is held in blog_unstatus
	
		 
	$clone_msg=($this->is_clone)?'<span class="red">Cloned </span>':(($this->blog_unstatus==='unclone')?'<span class="orange">Mirror release Column</span><br>':''); 
	$title=(!$this->is_clone)?'title="The Unique Column Id: C'.$this->col_id.' would be Used to Copy/Mirror/Move This Entire Column"':'title="This entire column is cloned"';
		
	 if ($this->column_level > 0&&array_key_exists($this->column_level-1,$this->column_order_array)):
		if ($this->blog_unstatus==='unclone'){
		$this->show_more('Mirror Release Info','','info underline italic small editbackground');
		if ($this->orig_val['blog_type'] ==='nested_column')
			printer::print_info('The Original Column post which was indirectly cloned then unmirrored here is from page_ref: '.$this->orig_val['blog_table_base'].'  and is Col Id:'.$this->orig_val['blog_data1'].'. If doing a template tranfer include this column in your template and you will automatically include this content from this current column here!');
		else printer::print_info('The Original '.$this->orig_val['blog_type'].' Post which was indirectly cloned then unmirrored here  is from page_ref: '.$this->orig_val['blog_table_base'].'  and is Post Id:'.$this->orig_val['blog_id'].'. If doing a template tranfer include this Post in your new template and you will automatically include this content from this current column here!');
		$this->show_close('From Info');
		}
		printer::alertx('<p class="'.$this->column_lev_color.' fs1'.$this->column_lev_color.' floatleft editbackground editfont left" '.$title.'>'.$clone_msg.'Column#'.$this->col_order.'<br><span class="info">'.$clone_msg.'Column Id: C'.$this->col_id.'</span><br><span class="info smaller">From: <br>Column#'.$this->column_order_array[$this->column_level-1].' Post#'.$this->blog_order_array[$this->column_level].'</span><br><span title="Post Parent Blog id'.$this->blog_id.'" class="info smallest">Tech</span></p>');
			 
	else: {
		$clone=($this->is_clone)?'<span class="red">Cloned </span>':'';
		$title=(!$this->is_clone)?'title="The Unique Column Id: C'.$this->col_id.' would be Used to Copy/Mirror/Move This Entire Column"':'title="This entire column is cloned"';
		printer::alertx('<p class="'.$this->column_lev_color.' fs1'.$this->column_lev_color.' floatleft editbackground editfont left" '.$title.'>'.$clone.'Column#'.$this->col_order.'<br><span class="info ">Column Id: C'.$this->col_id.'</span><br><span class="info smaller">From: <br>The Body'.'</span></p>');
		}
		endif;
	printer::printx('<span id="col_'.$col_id.'"></span>');
	printer::pclear();
	//if  (!$prime){//$this->column_level > 0
		
		if ($this->is_clone){ //if cloning local style for nested columns styles & config already populated such that tablename does equal pp table base!! 
	
			if (!$prime&&$this->blog_status !='clone'){
				$clone_msg='<span class="info" title="The Parent Column C'.$this->parent_col_clone.' was directly Cloned and this Column is Nested  Within"> Info </span>';
				}
			else{
				$clone_msg='<span class="info" title="This Column was directly Cloned and all its Posts and Nested Columns Within It Will Be Automatically Cloned as Well."> Directly </span>';
				$this->parent_col_clone=$col_id;
				}
			 
		printer::alertx('<p class="editbackground editcolor fs2npred small left shadowoff floatleft">Cloned Column '.$clone_msg.' and Changes to the Parent Column Id C'.$col_id.' on Page <a class="whiteshadow2" style="color:#0075a0;" target="_blank"  href="'.check_data::dir_to_file(__METHOD__,__LINE__,__FILE__,$this->col_table_base).$this->ext.'#col_'.$col_id.'"><u>'.check_data::table_to_title($this->col_table_base,__method__,__LINE__,__file__).'</u></a> Will Also Appear Here ');
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
				$this->show_more('Enable Local Col Settings','noback','small info editbackground rad3 fs2npinfo click','Enable Local Column Styling and Other Column Settings Without Affecting the Parent.  This only affects the Column Styles and not those Set in the Posts or Nested Column content within!',600); 
				$msg='Enable local styling &amp; other settings of this Cloned Column without affecting those of the parent or styles and settings of  those Set in the Posts or Nested Column content within!';
				echo '<div class="fsminfo editbackground  floatleft '.$this->column_lev_color.'"><!--Local clone style-->';
				printer::printx('<input type="checkbox" name="add_collocalstyle['.$col_id.']" value="1" >'.$msg);
				printer::alert_neu('Note: When Enabled the Column Styling &amp; Settings will not Update When the Parent Style Updates, instead only when you make Styling Changes here.',.8);
				echo '</div><!--Local clone style-->';
				$this->show_close('Local clone style');
				}
			else {
				$this->show_more('Disable Local Settings','noback','small info editbackground rad3 fs2npinfo click','Disable Local Styling of this Column Clone and Return to Updating When the Parent of this Clone Updates',600); 
				$msg='Check to Disable local Settings and Column Styles for this Column Clone';
				echo '<div class="fsminfo editbackground  floatleft '.$this->column_lev_color.'"><!--Local clone style-->';
				printer::printx('<input type="checkbox" name="delete_collocalstyle['.$col_id.']" value="1" >'.$msg);
				printer::alertx('<p class="small info">Note: By disabling Local Settings and Column Style the Column WILL NOW assume the Settings of the Parent Column and Update When the Parent Column Style and Other Features Updates. Style Settings for the Posts and Columns within will Remain as they Are</p>');
				echo '</div><!--Local clone style-->';
				$this->show_close('Disable Local Settings');
				}
		 	
			if (($prime && $this->col_status=='clone')||(!$prime && $this->blog_status=='clone')){ 
				$this->switch_clone_options($col_id,$prime,'column');  
				}
			}//end is edit  
		} //end cloned area
		
	if($this->col_status==='clone'){ 
		$delete_msg= 'This Cloned Column and not The Parent Column Will Be Deleted if you Check this Box.';
			printer::alertx('<p class="editbackground left neg fs2npred floatleft">&nbsp;&nbsp;&nbsp;<input type="checkbox" name="deletecolumn['.$this->col_child_table.']" value="delete" onchange="edit_Proc.oncheck(\'deletecolumn['.$this->col_child_table.']\',\''.$delete_msg.' ie.  THIS ClONED COLUMN AND ALL THE POSTS AND NESTED COLUMNS WITHIN IT WILL BE DELETED WHEN YOU HIT CHANGE, UNCHECK TO CANCEL\')" >REMOVE This Cloned Column &nbsp;&nbsp;</p>');
			printer::pclear();
		}
	 
#colsettings	 
	if (!$this->is_clone||$this->clone_local_style){ 
		$this->show_more('Settings for Column Id'.$this->col_id, '','','',500);
		 echo '<div class="editbackground floatleft pb25 Os2darkslateblue fsm'.$this->column_lev_color.'"><!--column settings-->'; 
		//$this->tech_talk();
	    $primestat=($prime)?'prime':'notprime';
	    printer::pclear(20);
		 $this->show_more('Column Options','noback','','',500 );
		echo '<div class="Os2navy fsm'.$this->column_lev_color.' maxwidth500 editcolor editbackground editfont inline floatleft"><!--Col Opts-->'; 
	    echo '<p class="info floatleft" title="Info: From parent nested column with Post Id#'.$this->blog_id.' Post Order#'.$this->blog_order_mod .' in Column '. $this->blog_table.'">Info</p>';
	    printer::pclear();
	    $delete_msg=($this->blog_unstatus!=='unclone')?'Delete This Entire Column':'Remove this Mirror release Column';
		$delete_alert= ($this->col_status=='unclone')?"THIS MIRROR RELEASE COLUMN WILL BE DELETED AND THE PARENT CLONE WILL NOW BE EXPRESSED":'';
	    (!$this->is_clone)&&printer::printx( '<p class="left warn1 floatleft neg"><input type="checkbox" name="deletecolumn['.$this->col_table.']" value="delete" onchange="edit_Proc.oncheck(\'deletecolumn['.$this->col_table.']\',\''.$delete_alert.' CAUTION THIS ENTIRE COLUMN AND ALL THE POSTS AND NESTED COLUMNS WITHIN IT WILL BE DELETED WHEN YOU HIT CHANGE, UNCHECK TO CANCEL\');gen_Proc.use_ajax(\''.Sys::Self.'?unclone_list_column='.$col_id.'@@del_col_unc_'.$col_id.'@@'.$primestat.'\',\'handle_replace\',\'get\');" >'.$delete_msg.'</p>');
		printer::pclear(); 
	    echo '<p id="del_col_unc_'.$col_id.'"></p>';
	    if (!$this->col_primary&&$this->blog_pub){
		    printer::alertx('<p class="info floatleft" title="Turn Off Publication of this Column and all Posts and Nested Columns Within to Web Page"><input type="checkbox" value="0" name="'.$this->data.'_blog_pub">Un-Publish Entire Column</p>');
		    }
	    printer::pclear(5);
	    (!$this->clone_local_style)&&printer::alertx('<p class="info floatleft" title="Turn On Publication for all Posts and Nested Columns Within this Column"><input type="checkbox" value="1" name="'.$tablename.'_express_pub">Express Publish Entire Column all Posts Within</p>'); 
		    printer::pclear(2);
	$this->show_more('Import/Export Column Configurations Option');
	echo '<div class="'.$this->column_lev_color.' fsminfo floatleft editbackground left "><!--import-->Import Column Configurations and Column styles from another Column from any page. Will Not change the basic Data such Images, captions, text within your column';
	printer::printx( '<p class="editfont editcolor editbackground" title="Be Sure to Use the Column Id Which Begins with a C ie C11.  Do Not Use the  Col# which simply refer to the Column Display Order Within the Page. Col Ids and #s are displayed at the top of each column"><input style="editcolor editbackground" name="col_configcopy['.$this->col_id.']" size="8" maxlength="8" type="text">Enter the  <span class="info">Col Id</span> <span class="red">(Not Col#) </span>that you wish to Copy Configurations and Styles</p>');
	echo '</div><!--import-->';
	###########################################################Begin Import/Export Col
	if ($this->column_level>0){ 
		printer::print_wrap('import/export','editbackground editcolor fsmgreen Os3blue');
		
		echo '<div class="'.$this->column_lev_color.' fsminfo  editbackground left "><!--export-->Export styles and configuration  from this Nested Column post to any other Nested Column post that is directly within the same parent Column';
		printer::printx( '<p class="editfont editcolor editbackground" 	><input style="editcolor editbackground" name="col_configexport['.$this->col_id.']"   type="checkbox" value="'.$this->col_id.'">Export these Styles and Configs to other nested column posts within this column</p>');
		echo '</div><!--export-->';
		####################################################
		echo '<div class="'.$this->column_lev_color.' fsminfo  editbackground left "><!--import-->Import RWD Grid percentage selections  from another nested column post from any page that has the same Grid Break Points set in the page options.  ';
		printer::printx( '<p class="editfont editcolor editbackground" title="Be Sure to Use the Column Id Which Begins with a C ie C42.  Do Not Use the  Column# which simply refer to the Column Display Order Within the Primary Column. Column Ids and #s are displayed at the top of each post"><input style="editcolor editbackground" name="col_rwdcopy['.$this->col_id.']" size="8" maxlength="8" type="text">Enter the  <span class="info">Column Id</span> <span class="red">(Not Column#) </span>that you wish to copy Column RWD grid break point percentages</p>');
		echo '</div>'; 
		echo '<div class="'.$this->column_lev_color.' fsminfo  editbackground left "><!--export-->Export RWD settings from this Nested Column to any other  nested column post that is directly within the parent Column';
		printer::printx( '<p class="editfont editcolor editbackground" ><input style="editcolor editbackground" name="col_rwdexport['.$this->col_id.']"  type="checkbox" value="'.$this->col_id.'">Export this Columns RWD Grid settings to other posts within this column</p>'); 
		echo '</div><!--export-->'; 
		#######################################################
		echo '<div class="'.$this->column_lev_color.' fsminfo  editbackground left "><!--export-->Export the Alternative RWD Width settings (affects posts in non-RWD grid mode) from this post to  posts that are directly within this Column';
		printer::printx( '<p class="editfont editcolor editbackground" ><input style="editcolor editbackground" name="col_altrwdexport['.$this->blog_id.']"  type="checkbox" value="'.$this->blog_id.'">Export the Alternative Width settings setting of this post to all posts directly in this column</p>');
		echo '</div><!--export-->';
		######################################################
		 
		 
		printer::close_print_wrap('import/export'); 
		}
	############################################################End Import/Export col
	
	$this->show_close('Import Column Configurations Option');
	
	    //column_use_grid,grid_units,column_break_points
		#&&&&&&&&&&&&&&&&&&&&&&&&&&  BEGIN CLASS QUERY FOR  ACTIVE RWD POSTS  &&&&&&&&&&&&&&&&&&
		}//if   is_clone&&not
	 
	if ($this->column_level>0&&$this->column_use_grid_array[$this->column_level-1]==='use_grid'){
		$this->rwd_build('col',$tablename); 
		}//if parent column RWD
		#############        Finish   RWD QUERY   ##################
	################  Begin   Manual width/float  response for this Column  &&&&&&&&&&&&& 
	#colwidth
	printer::pclear(5);
	 
	printer::pclear();
	$msg='';
	$grid_units=(is_numeric($this->column_options[$this->column_grid_units_index])&&$this->column_options[$this->column_grid_units_index]>11&&$this->column_options[$this->column_grid_units_index]<101)?intval($this->column_options[$this->column_grid_units_index]):Cfg::Column_grid_units;
	if($this->column_use_grid_array[$this->column_level]==='use_grid'){//setup conditions for all posts within column  note that self ::rwd build called before enabling correct parent column vals
		$this->column_grid_css_arr[]=$grid_units.'@@'.$this->page_br_points;//for rendering css
		$this->current_grid_units=$grid_units;//for choosing post width class
		 
		}
	#colusegrid
	#width#  Information  follows..
	/*keeping track of width between using rwd and when not using it...
	 when not using rwd width is determined by directly choosing a width stored in col_width for columns or blog_width for normal posts..   col_width is a max px value for primary columns then a percentage for all nested columns.   RWD posts do not directly use these values but a tally of rwd grid percent values are stored  in $this->column_bp_width_arr once a rwd column is chosen and updated with grid percent for each successive column level.  
	 
	 The selected RWD Grid values are then used to directly update col_width or blog_width and here we approximate that width corresponding to maxbp gives the maximum  width. Non RWD widths can then continue to be had and current net width percentages are used to update the $this->column_bp_width_arr. Percentages will always be true to value. If RWD is returned on after being on and off Widths should be calculated exactly accurate again for each bp. Haven yet tried this.  Similary, a running tally for max_width_limit is used to inform what is the max width limit for Rwd Grid breakpoints or when RWD is not used updated with the current_net_width_percent determined from col_width..
	
	//here we are adjusting the column_bp_width_arr which keeps track of the column level net width percent...
	  if rwd is used then not used then used again it should maintain the correct  column level width percent...
	  
	  */
	if (!$this->is_clone||$this->clone_local_style){
		if ($this->column_level==0||($this->column_level>0&&$this->column_use_grid_array[$this->column_level-1]!=='use_grid')){
			if (isset($this->column_bp_width_arr[$this->column_level-1])&&count($this->column_bp_width_arr[$this->column_level-1])>0){  
				foreach ($this->column_bp_width_arr[$this->column_level-1]  as $bp => $value){
					$this->column_bp_width_arr[$this->column_level][$bp]=$value*$this->current_net_width_percent/100;
					//adjust the array directly if exists
					}
				}
			else {
				#width#  max_width_limit gives running adjustment  of column px available for RWD grid up until the point that   column bp width array comes into existance. It instead keeps track of successive width limitation in percent.  Multiplied by the max_width_limit will proved bp specific widths at given bp assignment....
				$this->max_width_limit=$this->max_width_limit*$this->current_net_width_percent/100;
				
				}
		 
			}//not grid
		if($this->column_use_grid_array[$this->column_level]!=='use_grid'){
			$gridstyle='style="display:none;background:#fdf0ee;"';
			printer::printx('<p class="editbackground info floatleft" title="Enable Responsive Web Sizing/Positioning for Posts Within This Column"><input type="checkbox" name="'.$tablename.'_col_options['.$this->column_use_grid_index.']" onclick="edit_Proc.displaythis(\''.$tablename.'_grid_show\',this,\'#fdf0ee\')" value="use_grid">Enable RWD Positioning for Posts Within This Column</p>');
			printer::pclear();	
			}
		else{
			printer::printx('<p class="fsminfo editbackground info left">Posts within this column are set to RWD display on grid.</p>');
			 $gridstyle='style="display:block;background:#fdf0ee;"';
			printer::printx('<p class="editbackground info left" '.$gridstyle.' title="Disable Responsive Web Sizing for Posts Within This Column"><input type="checkbox" name="'.$tablename.'_col_options['.$this->column_use_grid_index.']"  value="0">Disable RWD Positioning for Posts Within This Column</p>');
			printer::pclear();
			}
		echo '<div id="'.$tablename.'_grid_show" '.$gridstyle.'><!--show Grid opts-->';
		$this->show_more('Grid info choice','noback','smaller editbackground italic editcolor');
		echo'<p class="fsminfo editbackground editcolor floatleft" > By Default the RWD system uses a "Grid System" with 100 grid units or 1 percent of the row width for each gu chosen for posts and .5gu increments for any spacing between posts. In the event even smaller spacing increments are necessary up to 200 grid units may be chosen. Note:(Higher Grid Unit Choices will not produce extra class styles as only the relevant choices are generated"</p>';
		
		$this->show_close('Grid info choice');
		printer::pclear();
		$this->show_more('Change default Grid Units','noback');
		$this->mod_spacing($tablename.'_col_options['.$this->column_grid_units_index.']',$grid_units,12,200,1,'grid-units');
		$this->show_close('Change default Grid Units');
		echo '</div><!--show Grid opts-->';
		printer::pclear();
	if ($this->column_level==0||($this->column_level>0&&$this->column_use_grid_array[$this->column_level-1]!=='use_grid')){
		$msg=($this->column_level==0)?'Choose Maximum Display Width For this Top Level Column. Used for limiting Image Size and Content Displays on Larger Size Screens. Default is specified by the current page_width setting.' : ' RWD Grid Sizing for posts (incuding this nested column) is not enabled within the <b>Parent Column</b>. Manually narrow the maximum width of this Column Here'; 
			  
			$maxwid=($this->column_level==0)?Cfg::Col_maxwidth:$this->column_net_width[$this->column_level-1];
			$column_percent=($this->column_level==0)?($this->col_width/$this->page_width*100):$this->col_width; 
			//$class=($this->column_level==0)?'editcolor editbackground':'  tip';
			  
			if ($this->column_level==0){
					//means the last primary column width gets passed on to new page start width
				$msg='Choose Maximum Display Width For this Top Level Column. Necessary for limiting Image Size and Content Displays on Larger Size Screens.   Default Value is 1280.';
				$cw=(is_numeric($this->column_total_width[$this->column_level])&&$this->column_total_width[$this->column_level]>1)?$this->column_total_width[$this->column_level]:$this->page_width;
				echo '<p class="fsminfo tip floatleft" >'.$msg.'</p>';  
				printer::alert('Current Width Setting:'.$cw.'px');
				echo '<div class="fsminfo editbackground floatleft" ><!--width float wrap-->';//Choose Column Width:
				if (!Cfg::Spacings_off){
					echo '<select class="'.$this->column_lev_color.' editbackground editfont" name="'.$tablename.'_col_width" >        
					<option  value="'.$this->column_total_width[$this->column_level].'" selected="selected">'.intval(ceil($this->column_total_width[$this->column_level]*10)/10).'px</option>';
					$i=0;
					foreach (array(100 =>5,300=>5,$maxwid=>5) as $max =>$inc){
						$max=min($max,$maxwid);
						while ($i <= $max){
							 echo '<option  value="'.$i.'">'.$i.'px</option>';
							if ($i < $maxwid && ($i+$inc)>$maxwid) $i=$maxwid;
							else $i=$i+$inc;
							if ($i >$maxwid)continue;
							}
						if ($i > $maxwid)continue;
						}
					echo '	
				    </select>'; 
					printer::pclear(); 
					$factor=1;
					}
			    }//column_level==0 main column
			else{
				$msg= ' RWD Grid Sizing for posts (incuding this nested column) within the parent Column is not set. Manually narrow the maximum width of this Column Here. If instead you want to use RWD Grid to size this column then enable it in the <b>Parent Column</b>';  
				printer::alertx('<p class="tip" >'.$msg.'</p>');
				#column width  #col width  
				printer::alertx('<p class="info editbackground editfont" title="The Parent Column Width is the Upper Limit for this Nested Column. Optionally set a narrower Column Width as required.">Max Width Available: <span class="editcolor editbackground">'.intval(ceil($maxwid*10)/10).'px</span></p>'); 
				echo '<div class="info editbackground editfont" title="The Column width setting will include the value of margins and will take up 100% of the available column width if no limiting width value is chosen! Limit the width if required.  Both the percentage available of the parent column width and the pixel value will be shown"><!--width float wrap-->Current Column Width: <span class="editcolor editbackground">: '.intval(ceil($this->column_total_width[$this->column_level]*10)/10).'px   ('.(ceil($column_percent*10)/10).'%)</span>';
				printer::pclear();
				if(!Cfg::Spacings_off){
					echo '<select class="editcolor editbackground"  name="'.$tablename.'_col_width">        
					<option  value="'.$column_percent.'" selected="selected">'.(intval(ceil($this->column_total_width[$this->column_level]*10)/10)).'px  ('.(ceil($column_percent*10)/10).'%)</option>';
						$i=0;
						foreach (array(100 =>5,300=>5,$maxwid=>5) as $max =>$inc){
							$max=min($max,$maxwid);
							while ($i <= $max){ 
								   echo '<option  value="'.($i/$maxwid*100).'">'. $i.'px '.(ceil($i/$maxwid*1000)/10).'%)</option>';
								if ($i < $maxwid && ($i+$inc)>$maxwid) $i=$maxwid;
								else $i=$i+$inc;
								if ($i >$maxwid)continue;
								}
							if ($i > $maxwid)continue;
							}
						   
					    echo'	
						</select>
						';
						}
				printer::pclear();	
				}
			$currwidth=(!empty($this->col_width))?(intval(ceil($this->column_total_width[$this->column_level]*10)/10)):0;
			$mode=($this->column_level>0)?'':'simple';
			$unit2=($this->column_level>0)?'%':'';
			$factor=$maxwid/100;
			$msgjava='Choose:';  
			echo '<div class="editcolor edtbackground editfont click" onclick="gen_Proc.precisionAdd(this,\''.$tablename.'_col_width\',0,\''.$maxwid.'\',\''.$currwidth.'\',\'px\',\''.$factor.'\',\''.$msgjava.'\',\''.$unit2.'\',\''.$mode.'\');">Choose Column Width</div>';
			echo'</div><!--width float wrap-->	';
			printer::pclear(2);
			if ($this->column_level>0){ 
				 
				printer::alertx('<div class="$this->column_lev_color fsminfo maxwidth500 floatleft editbackground">For non-RWD grids Change the default behavior to Manually choose whether this nest-column floats next to another nested column or posted content! '); 
				 printer::alert('Column Positioning Choices','','left editcolor editbackground');
				$chosen=(in_array($this->blog_float,$this->position_arr))?$this->blog_float:'center_row';
				forms::form_dropdown($this->position_arr,$this->position_val_arr,'','',$this->data.'_blog_float',$chosen,false,'editcolor editbackground left');
				printer::alertx('</div>');
				 
				
				}
			else printer::printx('<p class="fsminfo editbackground left '.$this->column_lev_color.'">Note: Primary Columns Are Always Positioned Centrally and do not share space with other columns or posts. Create columns and post within this column to share space. Use RWD grids for mobile responsive layout. p>'); 
			 //width calculate w/o grid... parent grid turn on!!
		 
		(!$prime)&&$this->alt_respond('blog'); 
		 ############   End manual width/float  Control for this column  &&&&&&&&&&& 
		}//non rwd parent column or primary column
		//this should display for all rwd and non rwd
	printer::alertx('<div class="'.$this->column_lev_color.' fsminfo maxwidth500 floatleft editbackground">By Default Nested Columns will Vertically Top Align with Other Posts within the Parent Column.  Change that Default Here '); 
				printer::alert('Column Vertical Positioning Choice','','left editcolor editbackground');
				$current_vert_val=($this->column_options[$this->column_vert_pos_index]!=='middle'&&$this->column_options[$this->column_vert_pos_index]!=='bottom')?'top':$this->column_options[$this->column_vert_pos_index];
				forms::form_dropdown(array('top','middle','bottom'),'','','',$tablename.'_['.$this->column_vert_pos_index.']',$current_vert_val,false,'editcolor editbackground left');
				$this->css.="\n.".$tablename.'{vertical-align:'.$current_vert_val.'}';
				printer::alertx('</div>');	 
		
		#colopt  #colconf 
			printer::pclear();
		$tag=(!empty($this->column_options[$this->column_tag_display_index]))?$this->column_options[$this->column_tag_display_index]:'';
		printer::printx('<p class="fsminfo editbackground info floatleft" title="Optionally Display tagged Posts here. Caution: Only Posts matching the tag you enter here will be displayed in this column. Posts Previously made in this column will not not be displayed unless similary tagged">Enter Tags to Display Here (space separate):&nbsp;<input type="text" value="'.$tag.'" name="'.$tablename.'_['.$this->column_tag_display_index.']" size="20" maxlength="20"></p>');
		printer::pclear();
		$this->show_more('Transfer Clone Column');
	printer::print_wrap('clone transfer','Os3green fsmsalmon editcolor editbackground editfont');
	echo '<p class="info Os3darkslategray fsmyellow editbackground click floatleft" title="View Pages with clones of this column" onclick="gen_Proc.use_ajax(\''.Sys::Self.'?check_clones='.$this->col_id.'&amp;check_id=check_clones_'.self::$xyz.'\',\'handle_replace\',\'get\');" >Click to display Pages with Clones of this Column</p>';
	echo '<div id="check_clones_'.self::$xyz.'"></div>';
	printer::pclear();
	printer::print_tip('If this Column is directly cloned ie. used as a template you can change the template to another Column by entering its Column Id and submitting.  All the former Column Clones of id C'.$this->col_id.' will then be changed to the new template and unmirrored content if any is retrieved by importing the unmirorred post/col.');
	($this->col_primary)&&printer::print_caution('Clone Transfer of a Primary Column to a Nested Column will reset the nested column to the default Page Width configuration on the cloned page rendering',.8);
	printer::printx( '<p class="editfont editcolor editbackground" title="Be Sure to Use the Column Id Which Begins with a C ie C11.  Do Not Use the  Col# which simply refer to the Column Display Order Within the Page. Col Ids and #s are displayed at the top of each column"><input style="editcolor editbackground" name="col_transfer_clone['.$this->col_id.']" size="8" maxlength="8" type="text">Enter the new <span class="info">Col Id</span> <span class="red">(Not Col#) </span>that you wish to Clone Transfer to</p>');
	printer::close_print_wrap('clone transfer');
	$this->show_close('Transfer Clone Column');
	    printer::pclear(2);
		//self::option_pad_percent('column',$tablename);
		$this->submit_button();
		echo '</div><!--Col Opts-->'; 	
		$this->show_close('Column Options');echo '<!--column options-->';
		printer::pclear(2);
		}//!is clone || clone local style
	 $msg='Add Spacing Within (padding) or Outside (margin) this Column,  Change the Column Background Color or Create a Column Border or Box Shadow Here. Column Borders and Box Shadows style an edge or edge(s) of the column based on the colors, the edges chosen, and type of style you choose. Radius the corners of the column Here. In addition,  set new <span class="bold">Column Specific Text Style Defaults</span> Here. Each Post has its own styling options (a wide choice for text based posts) for further Changes as Needed. !!';
	$class=($prime)?'primary':'nested';
	$class='';// note cautioon primary used for special tweaking @mediaminwidth for margins in # br
	  $this->edit_styles_close($tablename,'col_style','.'.$tablename,'background,padding_top,padding_bottom,padding_left,padding_right,margin_top,margin_bottom,margin_left,margin_right,padding_left_percent,padding_right_percent,margin_left_percent,margin_right_percent,borders,box_shadow,outlines,radius_corner,font_color,text_shadow,font_size,font_family','Edit Column Styles','noback',$msg);
	  	printer::pclear(2);
		 
	
	
		$msg='&#34;Group Styles&#34; provide an quick means to select consequitive posts within a Column and group style them such as with a border, background, etc.  You begin by checking the begin box on the first post and end box on the last post you wish to style!  Make any number of groups within a column and they will all have the styles you set Here!!  Options included to style borders or box shadows,  background colors, background images, etc. Padding spacing changes made here will increase spacing between posts and borders if used!.  Begin by checking the begin box on the first non column post and check the end box on the last non-column post you wish to distinguish within the same column! Span column posts between open and close tags if you wish.  Be sure to match with a close groupstyle before beginning with a new one in the same column.  Unmatched open border and close border checked options will generate an alert mesage and can mess up the webpage styling.   Check both boxes on the same post to end an group and begin another group or to wrap a single post, the system will determine which one is intended as long as your consistent with closing every opening  ';
		if(!$this->is_clone||$this->clone_local_style){
			$this->show_more('Style Group, Tags,Date, and Comment for Column','noback');
			echo '<div class="fsm'.$this->column_lev_color.' Os2darkslategray editbackground editcolor"><!--Style Group,Date-->';
	   	printer::printx('<p class="fsminfo">Group Styles are a quick way to wrap several posts with Style. YSet default Group, Comments and date styles Here and Adjust as necessary with column specific options for the same. Finally style HR tags here which will be in affect page wise.</p>');
	    $this->edit_styles_close($tablename,'col_grp_bor_style','.'.$tablename.' .style_groupstyle','','Set &#34;Group Styles&#34;','noback',$msg);
	    $msg='Set style HR tags.  HR can be placed anywhere in text and the styles you set here will be expressed. HR are theme breaks, typically bordered lines with spacing';
	    $this->edit_styles_close($tablename,'col_hr','.'.$tablename.' hr','width_special,width_percent_special,width_max_special,width_min_special,background,padding_top,padding_bottom,padding_left,padding_right,margin_top,margin_bottom,margin_left,padding_left_percent,padding_right_percent,margin_left_percent,margin_right_percent,borders,box_shadow,outlines,radius_corner','Set Col Specific HR Tags if needed','noback',$msg);
	    
	    $this->edit_styles_close($tablename,'col_comment_style','.'.$tablename.' .posted_comment','','Style Comment Entries','noback','Comment Styles will affect all comment post feedback styles for posts made directly in this column');	
	    $this->edit_styles_close($tablename,'col_date_style','.'.$tablename .' .style_date','','Style Post Date Entries','noback','Date Styling Affects Posts within this Column (And within any nested columns unless set there) with Show Post Date Enabled');
	    $this->edit_styles_close($tablename,'col_comment_date_style','.'.$tablename.' .style_comment_date','','Style Comment Date Entries','noback','Comment Date Styling Affects Comments within this Column (And within any nested columns unless set there)');
	     $this->edit_styles_close($tablename,'page_comment_view_style','.'.$tablename.' .style_comment_view','','Style #/view/Leave Comments','noback','Style the #of Comments  and View/Leave Comments Link');
		}
	    
	     if(!$this->is_clone||$this->clone_local_style){
			echo '</div><!--Style Group,Date-->';
			$this->show_close('Style Group,Date, and Comment for Column');
			 
			 
			echo '</div><!--column settings-->';
			$this->show_close('Settings for Column#');//<!--Show More Master col Settings-->';
			printer::pclear(2);
			}
	  
	###!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!EXpress the Css for the Entire Blog Column!!!!!!!!!!!!!!!!!!!!
	 #***********!IMPORTANT******** the following pertain to positioning the entire blog
		#begin border css
		
	}#end column_options

 
function unclone_options($id,$post_target_clone_column_id){if(Sys::Custom)return;if (Sys::Quietmode)return; 
	if (($this->blog_status==='clone')||($this->is_column&&$this->col_status==='clone'))return;  
	static $statinc=0; $statinc++;
	$this->clone_check_arr[]=$id;
	$this->show_more('Your Mirror release Options for '.str_replace('_',' ',strtoupper($this->blog_type)),'Close Mirror release Options','fs2npinfo small infoclick editbackground floatleft','Modify/Change This Cloned '.str_replace('_',' ',strtoupper($this->blog_type)),500);//show_more un clone options
	
	
	echo '<div class="fsmblack editbackground"><!--Mirror release Options-->';
	echo '<div class="fsminfo editbackground left '.$this->column_lev_color.'" >With this Duplicate and Modify Option a Copy of this '.str_replace('_',' ',strtoupper($this->blog_type)).' will Be Created and May Then Be Modified Here Without Affecting the Original!<br>'; 
	printer::printx('<p class="editfont editcolor editbackground left"><input type="checkbox" value="'.$this->post_target_clone_column_id.'" name="unclone_option_copy['.$this->blog_id.']"> Duplicate and Modify Option</p>');
	echo '</div><!--Duplicate Mirror release-->';
	
	 
	echo '<div class="left fsminfo editbackground '.$this->column_lev_color.'" >With this Replace Fresh Option Select Any New Post/Column Type to Replace this '.str_replace('_',' ',strtoupper($this->blog_type)).'<br/>';
	 //id="unclone_fresh_'.$this->blog_id.'_'.$statinc.'"><input  type="hidden" value="'.$this->post_target_clone_column_id.'" name="unclone_option_fresh['.$this->blog_id.']" > Replace With Fresh Choice Option 
	 printer::printx('<p class="editfont editcolor editbackground left">	And Choose Your New Post Type <br><span class="small">From the Dropdown Menu Here:</span></p>');
	 
	$new_blog='create_unclone['.$this->blog_id.']['.$this->post_target_clone_column_id.']';  
	$selected=$this->choose_blog_type;
	forms::form_dropdown($this->blog_drop_array,false,'','',$new_blog,$selected,false,$this->column_lev_color  );
	 echo '</div><!--Unclone Fresh-->';
	$this->submit_button();
	echo '</div><!--UnClone Options-->';
	$this->show_close('un clone options');//show_more un clone options
	printer::pclear();echo '<!--clear unclone opts-->';
	}
	 
#br	#blogrender# this is the main method to process posts for a given column and send them with populated values to their repective functions for content rendering 
function blog_render($col_id,$prime=false,$col_table_base=''){
	if (in_array($col_id,$this->column_moved))return; 
	$this->col_id=$col_id;  
	$this->col_table_base=$col_table_base;
	$tablename=$col_table_base.Cfg::Post_suffix.$col_id;
	($prime)&&$this->total_float_mod(true);//initiates some prime column values concerning the total width including borders margins padding etc. 
	if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	$border_end_ref='';
	$border_begin_ref='';
	$floatnew=false;
	$this->blog_border_stop=false;
	$show_new_blog=false;
	$clearfloat=false;//clear float after float no next and other circumstances
	$this->clone_ext=($this->is_clone&&$this->clone_local_style)?'clone_':'';
	if ($col_table_base!==$this->tablename&&!$this->clone_local_style)
	#page stylesheet will collect additional page references for the expression of cloned css. 
		$this->page_stylesheet_inc[]=$col_table_base;
	
	#this is clone is very important value. When set as true at the  column level, ie right here,  any posts within that column will be set as is_clone.  Is clone when true will prevent styling options from being presented. But it will also initiate a search for unclones and local styling and local data as well... 
	$this->is_clone=(array_key_exists($this->column_level,$this->column_clone_status_arr))?(($this->column_clone_status_arr[$this->column_level])?true:false):false;
	($this->edit)&&$this->column_lev_color=$this->color_arr_long[$this->column_level];
	//$class=($this->edit)?"border4 borderridge  $this->column_lev_color":'';// change this and style store.........................
	if ($this->edit){
		if(isset($_POST['submitted'])&&!$this->is_clone){
			$this->process_blog($tablename,$col_id,true);
			#process blog will initiate searches for submitted data changes within this tablename
			}
		if(isset($_POST['submitted'])&&in_array($col_id,$this->delete_col_arr))return;//column has been deleted
		}
		
	#primary
	#Note if prime column,  data for this column has been populated already in method   render_body_main in file global master class
	if($prime&&!$this->edit)
		print '<div id="'.$this->clone_ext.'col_'.$this->col_id.'"  class="'.$this->clone_ext.$tablename.' primary" style="max-width:'.$this->current_total_width.'px;"><!--Begin Primary Column id'.($this->col_id).'-->';
	elseif ($prime){// this is edit 
		list($bw,$bh)=$this->border_calc($this->col_style);
		if (!empty($bw)) 
			$bs=$this->calc_border_shadow($this->col_style);
		$addclass=(empty($bw))?' bdot3'.$this->column_lev_color.' ':((empty($bs))?' bshad3'.$this->column_lev_color.' ':'');
		
		#fieldset no longer used switched to class containing border in editmode
		print '<div  id="'.$this->clone_ext.'col_'.$this->col_id.'" class="'.$addclass.' '.$this->clone_ext.$tablename.' primary" style="max-width:'.$this->current_total_width.'px;"><p class="lineh90 shadowoff editcolor editbackground">Primary Column</p><!--Begin edit  Primary Column id'.($this->col_id).'-->';
		printer::pclear();
		list($padding_total,$margin_total)=$this->pad_mar_calc($this->col_style);
		##width## @media tweak setting for primary column if margins are set then enable margin values.. margin auto will be set only when minimum width is > than the total column width!
		$this->css.='
		@media screen and (min-width:'.($margin_total+$this->current_total_width).'px){
			.'.$tablename.'.primary{margin-left:auto;margin-right:auto;}
			}';
		if (!$this->is_clone){
			#subbed post for prime column
			#because of flat filing parent data then subbing out local blog data we are setting up inital subbed out data for  posts including those that carry limited info for nested columns
		#for prime columns in case the are cloned elsewhere as nested columns we must set up a initial post subbed row that will be used in this limited case and the post values will be empty unless  specified below. .
			$post_fields=Cfg::Post_fields;
			$post_field_arr=explode(',',$post_fields);
			$value='';   
			foreach ($post_field_arr as $field) {
				$collect[$field]=''; //for post subbed row...
				}
			$collect['blog_id']='';
			$collect['blog_type']='nested_column';//needed in nested column position only so safe to specify
			$collect['blog_data1']=$this->col_id;
			$collect['blog_pub']=1;
			(!is_dir(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir))&&mkdir(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir,0755,1);
			(!Sys::Pass_class&&!$this->is_clone)&&file_put_contents(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'post_subbed_row_data_col_'.$this->col_id,serialize($collect));//this fits with post_subbed_row  .$subbed_row_id for columns
			#here we are flat filing the primary column data in edit mode in case needed if this column is cloned as a nested column
			$collect_col_data_arr=array();//all clones will use/access the parent column id as well for accessing the parent column data ie. (column_data_'.$this->col_id). Note for cloned columns:  cloned and local enabled styling and configs for clones will generate a further set of data within this method which will sub-out any style/config fields of the parent.
			foreach ($this->col_field_arr as $field) {
				$collect_col_data_arr[$field]=$this->$field;//for webpage use.. 
				} 
			 
			$collect_col_data_arr['col_id']=$this->col_id;//add in the col_id as well..
			#column data #coldata
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
		#initial post append for primary column
		$append_arr=array();
		$append_arr['var']=$append_arr['obj']=array();
		
		#here we flat file in editmode for webpage mode misc variables and class properties that are important for webpage mode but generated in editpage mode...
		#these "append variables"  are made and attached to this primary col_id in case they are necessary for cloned nested columns otherwise not necessary as the webpage mode currently does a direct mysql call and populates primary only columns..
		$objvars=explode(',','rwd_post,blog_float,blog_table,column_lev_color,blog_border_stop,col_num,blog_order,blog_order_mod,fieldmax,is_clone,clone_local_style,clone_local_data');
		foreach ($objvars as $ov){ 
			$append_arr['obj'][$ov]=$this->$ov;
			}
		$vars=explode(',','subbed_row_id,clearfloat,show_new_blog,blog_order,tablename,blog_status,blog_unstatus,prime,floatnew');
		foreach ($vars as $v){
			$append_arr['var'][$v]=$$v;
			}
		$appfile=Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'post_append_data_'.$this->tablename.'_'.$this->col_id; 
		file_put_contents($appfile,serialize($append_arr));//this is done so initial clones can access original
	
		}//$prime and is edit
		
	#ok we need to explode column options for the primary column	
	if ($prime){
		$this->column_options=explode(',',$this->col_options);
		for ($i=0;$i <count(explode(',',Cfg::Column_options)); $i++){
			if (!array_key_exists($i,$this->column_options))$this->column_options[$i]=0;
			}
		}
	#Important:  for restoration of previous column values following nested column recursion  #remember column values are originally populated in previous recursion prior to there application in this round... this is because certain column values are necessary for rendering the opening nested column div tag and other functions before reaching the col_data method. Through this recursive function process variables but not class properties will retain their local scope values which makes it easy to return to previous recursive value..
	foreach ($this->col_field_arr as $field) {
		${'restore_'.$field}=$this->$field; 
		}
	${'restore_col_id'}=$this->col_id;
	
	#set some defaults
	$this->background_image_px=0;
	$this->is_blog=false;
	$this->is_column=true;
	//col_data is the main method for directing the processing of columns...
	$this->col_data($prime);# this is primary call to col_data#################
	$this->is_column=false;
	$this->previous_post='';
	$this->blog_status=false;
	
	#**********end !IMPORTANT *****positoning entire blog
		#*****BEGIN  AND RENDER POSTS AND POST styles
	$start_fields='blog_pub,blog_status,blog_clone_target,blog_target_table_base,blog_type,blog_data1,blog_data2,blog_data3,blog_id,blog_order,blog_table,blog_col,blog_table_base';
	
		#Lets check for tagged post rendering for this column
	if (!empty(trim($this->column_options[$this->column_tag_display_index]))){
	//tagged post values when tags set in parent column will be displayed
	//ie will select posts with tags in this column if true
		$this->tagged=true;
		$this->is_clone=$this->column_clone_status_arr[$this->column_level]=true;//set tagged posts to clone status ie no editing
		$tag=trim($this->column_options[$this->column_tag_display_index]);
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
			$like='%'.trim($this->column_options[$this->column_tag_display_index]).'%';
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
	 
	if ($this->edit||$prime){
		$count=$this->mysqlinst->count_field($this->master_post_table,'blog_order','',false, $where);
		$this->fieldmax=$this->mysqlinst->get('fieldmax');
	
		if ($count<1) {
			if ($tags){
				if ($this->edit){//edit re check is redundant for flat file system  
					$where="where blog_table='$tablename'";
					$count=$this->mysqlinst->count_field($this->master_post_table,'blog_order','',false, $where);
					if ($count>0)
						echo '<p class="red addheight rad10 whitebackground small floatleft">Caution: Because posts tagged with "'.$this->column_options[$this->column_tag_display_index].'" were chosen in the Column Options to display here '.$count.' number of posts already made in this column but without this tag are not being displayed here.</p>';   
					}
		
				if ($this->edit)echo '<p class="red addheight rad10 whitebackground small floatleft">Currently, there are no posts tagged with any of the  words: "'.$this->column_options[$this->column_tag_display_index].'" to display here!</p>'; 
				}//end not tags
			elseif($this->edit) {//not tags
				$colmsg='Ok, Now ';
				printer::printx('<p class="editbackground editcolor floatleft fs2info">'.$colmsg. ' Choose Below your First Post Type or Nested Column for your New Column from the dropdown Menu',false,'left large '.$this->column_lev_color.'</p>');
				printer::pclear();echo '<!--clear choose first-->';
				$this->blog_new($tablename.'_0',$tablename,0,'','Insert Post Top of',true);
				}
			$this->column_return=true; //table lacks posts...
			($this->edit)&&printer::pclear(1);echo '<!--clear choose first 2-->';
			if($this->edit&&$prime)
		#fieldset  switched to class
				print'</div><!--End Empty Primary Column id'.$this->col_id.'  -->';
			elseif($prime)
				print'</div><!--End Empty Div Primary Column id'.$this->col_id.'-->';
			$this->col_table=='none';
			return;
			}//end count < 0
		}//if this edit or prime
	$col_identify='col_'.$this->col_id;;
	$columnArrayFile=Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'data_col_list_'.$col_identify;
	if($this->edit||Sys::Pass_class){  
          $this->blog_new($tablename.'_0',$tablename,0,'','Insert Post Top of',true); 
		$rpost=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
		#mainwhile
		$orig_val_arr=array(); 
		$id_arr=array();
		$reset=false;
		while($mainrow=$this->mysqlinst->fetch_assoc($rpost,__LINE__)){#while
			if (!isset($_POST['submit'])&&!empty($mainrow['blog_order'])&&is_numeric($mainrow['blog_order'])&&substr($mainrow['blog_order'],-1)!=='0'){ 
				$reset=true;//prior improper blog_tidy may prevent subsequent proper new blog insertion..
				}
			$orig_val_arr[]=$mainrow;
			$id_arr[]=array('blog_id'=>$mainrow['blog_id'],'blog_order'=>$mainrow['blog_order'],'blog_pub'=>$mainrow['blog_pub']); //for flat filing data_col_list_
			} //end mainwhile
		if ($reset){//repeat the process after blog_tidy
			$orig_val_arr=array(); 
			$id_arr=array();
			$this->blog_tidy($tablename);  
			$rpost2=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
			while($mainrow=$this->mysqlinst->fetch_assoc($rpost2,__LINE__)){#while 
				$orig_val_arr[]=$mainrow;
				$id_arr[]=array('blog_id'=>$mainrow['blog_id'],'blog_order'=>$mainrow['blog_order'],'blog_pub'=>$mainrow['blog_pub']);
			#so the id_arr $columnArrayFile  flat files critical post fields foreach post record recalled within the column and can be accessed from the flat file directly in webpage mode by the original or clones .  Notice in webpage mode how the flat file becomes the  orig_val_arr following unserialization. the foreach statement is used to accomodate the array whether derived in editmode mysqli call or webpage mode from flatfile
				} //end mainwhile
			}
		 
		(!is_dir(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir))&&mkdir(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir,0755,1);
		//(!Sys::Pass_class&&!$this->is_clone)&&
		file_put_contents($columnArrayFile,serialize($id_arr));	//data_col_list_ here we flat file the id_arr as record to recall each flat file record  we will be flat filing on originals and clones will also use originals directly when the parent column updates instead of when the local clone page updates!
		 }// if edit
	
	else {//not edit get stored serialize column query 
		if (is_file($columnArrayFile)){
			#here for webpage mode  we retrieve the ordered list of posts to render...  
			$main_id_list=file_get_contents($columnArrayFile);
			
			if(strlen($main_id_list)>15){
				$orig_val_arr=unserialize($main_id_list);
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
	#In Webpage mode access the post_subbed_row data directly with no need for queries
	#If the post blog_type field is a nested column  populate the new column values... However these values are used even before calling the blog_render method which passes it id so that the opening division tag can be rendered properly (even though the width is not directly inline anymore) and for timing in nested column restoration following recursion of nested columns.
	#recursively  call method blog_render with new nested column id or tablename whichever currently used....  Current column values are always populated in before the call to the blog_render function so that proper division values may to facillite timings..  ...
#when the nested column method called for nested_column blog_type is finished and returns (^F #nested_column) the archived ${'restore_'.$field values collected above in this method will be repopulated  back and any remaining posts in the parent column are rendered..
#both column fields and  master post fields may used for stying the column  depending on needs ie blog_float is used to set column float position in nested columns

	#flat files incorporated to remove query calls duing non-edit use...
	#Note    $orig_val_arr  holds just a few vals in non-edit mode whereas a fuller set in editmode...

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
			if ($orig_val['blog_type']=='nested_column'&&isset($this->nested_col_moved[$orig_val['blog_data1']]))continue;//allow for moving of column... 
			
			$this->background_image_px=0;//set default width for background images
			if($orig_val['blog_data2']=='post_choice'){//select new post type is requested...  
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
			$blog_table=$orig_val['blog_table'];  //updating as blog table changes with nested column...  this is needed as check for pages_obj
			$this->column_clone_status_arr[$this->column_level+1]=(array_key_exists($this->column_level,$this->column_clone_status_arr)&&$this->column_clone_status_arr[$this->column_level])?true:false;// set initial then check clone status 
			#is_clone
			if ($orig_val['blog_status']==='clone'){   #clone
				#get   parent post id blog_order blog_table which is used to get all parent class vars
				$this->is_clone=true;
				if ($orig_val['blog_type'] !=='nested_column'&&!empty($orig_val['blog_clone_target'])){// blog_clone_target is the targeted cloned id for content posts
					$q="select blog_type,blog_id,blog_order, blog_table from $this->master_post_table  where blog_id='".$orig_val['blog_clone_target']."'";
					}
				else { //direct cloned nested column
					$this->post_target_clone_column_id=$orig_val['blog_clone_target'];// mark last cloned blog_table //will use  page column value   as long as consistent with being last col_id reported going to unclone blog_data6
					#regrok well we need to regrok  post_target_clone_column_id
					
					$q="select blog_type,blog_id,blog_order, blog_table from $this->master_post_table  where blog_type='nested_column' and blog_status!='clone' and blog_data1='{$orig_val['blog_data1']}'"; // blog_data1 subbed in and refers to parent clone column col_id && parent  clone post blog_data1 values.
					$this->is_clone=$this->column_clone_status_arr[$this->column_level+1]=true;//child column level is now to be marked as is_clone.. remember col_level will not change till method nested_column calls the blog_render function for that upcoming col_id...
					}
				$cl=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
				if ($this->mysqlinst->affected_rows()) {
					list ($blog_type,$blog_id,$blog_order, $blog_table)=$this->mysqlinst->fetch_row($cl,__LINE__,__method__);
					//$clone_val=$this->mysqlinst->fetch_assoc($unc,__LINE__,__method__);
					}
				else{
					if($orig_val['blog_type'] !=='nested_column'){
					   $msg="Parent Post p{$orig_val['blog_clone_target']} was deleted and its cloned post is now removed";
						printer::pclear();
						printer::alert($msg); 
						$this->delete($this->master_post_table,"where blog_id=$blog_id",'message',$msg);
						continue;
						}
					else {
						$where="where col_id={$orig_val['blog_data1']}";
						$count=$this->mysqlinst->count_field($this->master_col_table,'col_id','',false, $where);
						if ($count <1){
							$msg="Parent Post p{$orig_val['blog_data1']} was deleted and its cloned post is now removed";
							printer::pclear();
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
			#READ IN THE UNCLONE VALUES
			#blog_unclone is the cloned post id that is being uncloned!!
			#this can further target a cloned post which if  is referred to as clone target
			#selecting blog_order and blog_table to use for editpage_obj populate values. these values will be re-selected if  is blog_status turns out to be immediately recloned!  
			if ($this->is_clone &&$orig_val['blog_status']!=='unclone'){#check for unclone in cloned nested column  
				$q="select blog_type,blog_order,blog_table,blog_data1,blog_status,blog_clone_target,blog_id,blog_data2 from $this->master_post_table  where blog_unstatus='unclone' and blog_table_base='$this->tablename' and blog_unclone='$blog_id' limit 1";  
				$unc=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
				if ($this->mysqlinst->affected_rows()) {
					$blog_unstatus='unclone';
					$temp_blog_id=$blog_id;
					$temp_blog_order=$blog_order;  
					$temp_table=$blog_table;
					list ($blog_type,$blog_order,$blog_table,$blog_data1,$blog_status,$blog_clone_target,$blog_id,$blog_data2)=$this->mysqlinst->fetch_row($unc,__LINE__,__method__); // the unclone data itself will be sent as it contains the relevant info!
					
					if($blog_data2=='post_choice'){   
						if (isset($_POST['delete_blog'][$blog_table][$blog_order])){ //removing unclone back to clone && entry updates...
							$blog_id=$temp_blog_id;
							$blog_order=$temp_blog_order;  
							$blog_table=$temp_table; 
							$this->delete_blog($blog_table);  
							continue;
							}
						else {#assign for choose post
							$this->blog_id=$blog_id;
							$this->blog_table=$blog_table;
							$this->blog_order=$blog_order;
							$this->blog_col=$orig_val['blog_col'];
							$this->blog_order_mod=$orig_val['blog_order']/10;
							$this->blog_table_base=$this->tablename;
							$this->choose_post();
							continue;
							}
						}
					#unclones can turn around immediately clone another post or columns
					#cloneunclone  #uncclone  
					if ($blog_status=='clone'){ //Note: checking status after unclone is true and checking of blog_status of new unclone...
						#two options either fix blog  clone parent table etc. query values using the id!
						
						if ($blog_type==='nested_column'){
							#original nested column could be uncloned! but not cloned so selected using blog_status != clone
							$blog_clunc_id=$blog_id;
							$unc_record=$blog_id;
							$blog_clunc_id=$blog_id;// this triggers option to delete unclone
							 
							$q="select blog_id,blog_table, blog_order from $this->master_post_table where blog_data1='$blog_data1' and blog_status !='clone'";//make sure not to reselect unclone record
							}
						else { 
							
							$blog_clunc_id=$blog_id;// this triggers option to delete unclone
							$unc_record=$blog_id; //actual unclone record blog_id
							 
							$q="select blog_id,blog_table, blog_order from $this->master_post_table where blog_id='$blog_clone_target'";
							}
						$ucc=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
						if ($this->mysqlinst->affected_rows()){
							list($blog_id,$blog_table,$blog_order)=$this->mysqlinst->fetch_row($ucc);
							 
							}
						$this->is_clone=true;
						$this->current_unclone_table[]=$unc_record;
						}
					else {
						$this->current_unclone_table[]=$blog_id;
						}
					if (isset($_POST['submit'])){  
						($blog_status!=='clone')&&$this->process_blog($blog_table,$col_id);
						if (isset($_POST['delete_blog'][$blog_table]))continue; 
						}
					$this->current_unclone_table[]=$blog_id; //for checking orphans
					 
					}//end if affected & means unclone is true
				
				} //end clones...
				
			$this->blog_order_mod=$blog_order/$this->insert_full; #for data presentation 
			#For unclones which are not immediately recloned they will contain information directly...
			#Here we get main values of post to be displayed using the table and blog_order of the regular post, or clone, or uncloned post..     
			$this->editpages_obj($this->master_post_table,'blog_id,'.Cfg::Post_fields,'','blog_order',$blog_order,'blog_table',$blog_table,'populate_data');
			if ($this->blog_type==='nested_column'){  
				if ($blog_status==='clone'&&$blog_unstatus==='unclone'&&!empty($blog_clunc_id)){ 
					$this->is_clone=true;//this is questionable! and need to check out this situation further.. not sure why direct clone is uncloned..     
					$this->column_clone_status_arr[$this->column_level+1]=true;
					}
				elseif ($blog_unstatus==='unclone'){// this is uncloned
					$this->is_clone=false; //switch off clone status
					$this->column_clone_status_arr[$this->column_level+1]=false;//child column level is now to be marked as !is_clone...
					}
				if($this->blog_data2=='column_choice'){
					$this->choose_column($this->blog_id,true); 
					continue;
					}    
				$col_id=$this->blog_data1; 
				$col_field_arr2=$this->col_field_arr;
				$col_field_arr2[]='col_id';
				##get column fields for nested column needed in next go round!
				#colpop #column populate   Note: this will catch primary columns also as this is collecting column data before next go round!!
				$q='select col_id,'.Cfg::Col_fields." from $this->master_col_table where col_id='$this->blog_data1'";
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
				$this->col_primary=false;//primary has done its work. Cloned primary now nested 
				}//if nested
			#Now Here we create Local Css Table post if local styling of Clones (mirrors) is selected !!  This is our only indication if clone local styling is true.  if cancelled record is deleted  
			#Note: No Direct indication for clone_local_style otherwise exists!
			#So we select for matching record tied to this page ie this->tablename which probably be this->page not this->tablename as system setup has changed..
			if ($this->is_clone){ //#clonestyle   
				$this->blog_clone_target=$orig_val['blog_clone_target'];   
				$this->blog_target_table_base=$orig_val['blog_target_table_base'];
				$this->blog_status=$blog_status;  
				if 	($this->blog_type!=='nested_column'){  
					if (isset($_POST['delete_bloglocalstyle'][$blog_id])){	 
						$q="delete from $this->master_post_css_table Where blog_id='p$blog_id' and blog_table_base='$this->tablename'";
						$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
						$this->clone_local_style=false; 
						}
					else{// 
						$count=$this->mysqlinst->count_field($this->master_post_css_table,'css_id','',false,"where blog_id='p$this->blog_id' and blog_table_base='$this->tablename'");  
						if ($count < 1){   
							if (isset($_POST['submitted'])&&isset($_POST['add_bloglocalstyle'][$blog_id])){ 
								$this->mysqlinst->count_field($this->master_post_css_table,'css_id','',false);
								$css_id=$this->mysqlinst->field_inc;//reuse deleted values
								$post_fields=Cfg::Post_fields;
								$post_field_arr=explode(',',$post_fields);
								$value='';  
								foreach ($post_field_arr as $field) {
									if($field=='blog_table_base')$value.="'$this->tablename',";
									elseif($field=='blog_table')$value.="'$this->blog_table',";
									else $value.="'".$this->{$field}."',";
									}
								$q="insert into $this->master_post_css_table (css_id,blog_id,$post_fields,blog_update,blog_time,token) values ($css_id,'p$blog_id',$value '".date("dMY-H-i-s")."','".time()."','".mt_rand(1,mt_getrandmax())."')";   
								$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);			 
								$this->clone_local_style=true;
								}
							else $this->clone_local_style=false;
							}
						else { //local style is true going to switch back in local values
#popclones for local clone styles							
							if (isset($_POST['submitted'])){
								$this->editpages_obj($this->master_post_css_table,Cfg::Post_fields,'clone_'.$this->blog_table.'_'.$blog_order.'_','blog_order',$blog_order,'blog_table',$this->blog_table,'update',"AND blog_table_base='$this->tablename'",",blog_time=".time().",token='". mt_rand(1,mt_getrandmax())."',blog_update= '".date("dMY-H-i-s")."'");
								}
								#switch
								#switch fields are the relevant style and config fields for a given post type subbed when clone local style is engaged.
								#base value refers to the common fields that relevant fields for all blog types for local clone style..  and the switch fields are addition base on the blog_types 
							$base_value='blog_gridspace_right,blog_gridspace_left,blog_grid_width,blog_border_start,blog_border_stop,blog_width,blog_float,blog_pub,blog_style,blog_options';
							switch ($this->blog_type){
								case  'navigation_menu':
								$css_value=$base_value.',blog_data2,blog_data4,blog_data5,blog_data6,blog_data7,blog_tiny_data1,blog_tiny_data2,blog_tiny_data3';
								break;
								case  'image':
								$css_value=$base_value.',blog_tiny_data1,blog_tiny_data2,blog_data4';
								break;
								case  'float_image_right':
								$css_value=$base_value.',blog_tiny_data1,blog_tiny_data2,blog_data4';
								break;
								case  'float_image_left':
								$css_value=$base_value.',blog_tiny_data1,blog_tiny_data2,blog_data4';
								break; 
								case  'contact':
								$css_value=$base_value.',blog_data1,blog_data2,blog_data4,blog_data5,blog_data6'; 
								break;
								case  'social_icons':
								$css_value=$base_value.',blog_data2,blog_data3,blog_data4,blog_data5'; 
								break;
								case 'gallery':
								$css_value=$base_value.',blog_data2,blog_data3,blog_data4,blog_data5,blog_data6,blog_data7,blog_tiny_data1';
								break;
								case 'auto_slide':
								$css_value=$base_value.',blog_data4,blog_data5,blog_data7';
								break;
								case 'video_post':
								$css_value=$base_value.',blog_data5,blog_data7';
								break;
								default:
								$css_value=$base_value;
								}
							$q="select $css_value from $this->master_post_css_table where blog_table_base='$this->tablename' and blog_id='p$blog_id' limit 1";  
							//$true_order=$this->blog_order;
							$lc=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
							$css_row=$this->mysqlinst->fetch_assoc($lc,__LINE__);
							$css_local_arr=array();
							foreach(explode(',',$css_value) as $cfield){
								$this->{$cfield}=$css_row[$cfield];#direct edit mode substition
								$css_local_arr[$cfield]=$css_row[$cfield];#this is for flatfile webpage mode substition
								}
							(!Sys::Pass_class)&&file_put_contents(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'blog_clone_local_style_'.$this->tablename.'_'.$this->blog_id,serialize($css_local_arr));
							/*if ($true_order != $this->blog_order){// blog order has changed...   needs to sync with editpage_obj populate system submits  so we correct for any reason here if this is the case
								
								#since blog order is never subbed back in and we are using  blog_id there doesnt seem to be a reason to update the master_post_css_table entry for blog_order
								 $q="update $this->master_post_css_table set blog_order='$true_order', blog_update='".date("dMY-H-i-s")."',token='".mt_rand(1,mt_getrandmax())."' where blog_table_base='$this->tablename' and blog_id='p$blog_id'";
								 $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
								#update call to adjust blog_order may be totally unnecesary
								  } */
							
							
							$this->clone_local_style=true;//enable clone styling and configuration options  
							}//count > 0
							
						}//not deleted clone local style
					if (isset($_POST['delete_bloglocaldata'][$blog_id])){	 
						$q="delete from $this->master_post_data_table Where blog_id='p$blog_id' and blog_table_base='$this->tablename'";
						$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
						$this->clone_local_data=false;
						}
					else{//check for cloned data local
						#now do similar for   local data setting by checking if local data record exists for this column.  remember there is no direct link to this page for posts within a cloned column other than the parent column or ancestor column being directly cloned.. otherwise could be a directly cloned post and either way a record is created for the local linking
						$count=$this->mysqlinst->count_field($this->master_post_data_table,'data_id','',false,"where blog_id='p$this->blog_id' and blog_table_base='$this->tablename'");  
						if ($count < 1){  
							if (isset($_POST['submitted'])&&isset($_POST['add_bloglocaldata'][$blog_id])){
								$this->mysqlinst->count_field($this->master_post_data_table,'data_id','',false);
								$data_id=$this->mysqlinst->field_inc;//reuse deleted values
								$post_fields=Cfg::Post_fields;
								$post_field_arr=explode(',',$post_fields);
								$value='';  
								foreach ($post_field_arr as $field) {
									if($field=='blog_table_base')$value.="'$this->tablename',";
									elseif($field=='blog_table')$value.="'$this->blog_table',";//not necessary as no change actually being made compared to default substitution
									elseif ($field==='blog_data1'){
										if ($this->blog_type==='gallery')$value.="'',";//appears not necessary as this field will not be used anyway
										else $value.="'".$this->{$field}."',";
										}
									
									else $value.="'".$this->{$field}."',";
									}
			 
								$q="insert into $this->master_post_data_table   (data_id,blog_id,$post_fields,blog_update,blog_time,token) values ($data_id,'p$blog_id',$value '".date("dMY-H-i-s")."','".time()."','".mt_rand(1,mt_getrandmax())."')";   
								$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);			 
								$this->clone_local_data=true;
								$count=1;
								}
							else $this->clone_local_data=false;
							}
						else {  
							if (isset($_POST['submitted'])){
								$this->editpages_obj($this->master_post_data_table,Cfg::Post_fields,$this->blog_table.'_'.$blog_order.'_','blog_order',$blog_order,'blog_table',$this->blog_table,'update',"AND blog_table_base='$this->tablename'",",blog_time=".time().",token='". mt_rand(1,mt_getrandmax())."',blog_update= '".date("dMY-H-i-s")."'");
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
								$data_val=$base_value.'blog_data1';
								break;
								case  'float_image_right':
								$data_val=$base_value.'blog_data1';
								break;
								case  'float_image_left': 
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
								case 'video_post':
								$data_val=$base_value.'blog_data1,blog_data2,blog_data3,blog_data4,blog_tiny_data1';
								break;
								default:
								$data_val=$base_value;
								}
							if ($this->blog_type==='text'||$this->blog_type==='gallery'){//only these are presently configured
								$q="select $data_val from $this->master_post_data_table where blog_table_base='$this->tablename' and blog_id='p$blog_id' limit 1";  //sub out if present
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
								(!Sys::Pass_class)&&file_put_contents(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'blog_clone_local_data_'.$this->tablename.'_'.$this->blog_id,serialize($local_data_arr)); 
								/*if ($true_order != $this->blog_order){// blog order has changed...  Is this still relevant??
									$q="update $this->master_post_data_table set blog_order='$true_order', blog_update='".date("dMY-H-i-s")."',token='".mt_rand(1,mt_getrandmax())."' where blog_table_base='$this->tablename' and blog_id='p$blog_id'";
									 $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
									 }*/
								
								$this->clone_local_data=true;
								}//end is enabled blog_type ie text gallery
							
							}//count > 0
							
						}//not deleted clone local data
					}//if ! nested column
					
					
				else{//is nested column
					$col_fields=Cfg::Col_fields;  
					if (isset($_POST['delete_collocalstyle'][$this->blog_data1])){
						$q="delete from $this->master_col_css_table Where col_id='c$this->blog_data1' and col_table_base='$this->tablename'";
						$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
						$this->clone_local_style=false;
						continue;
						}//not deleted..
					else {  
						($blog_status=='clone')&&$this->parent_col_clone=$this->blog_data1;//for providing information
						$count=$this->mysqlinst->count_field($this->master_col_css_table,'css_id','',false,"where col_id='c$this->blog_data1' and col_table_base='$this->tablename'"); 
						if ($count < 1){// local column style/config is enabled
							if (isset($_POST['submitted'])&&isset($_POST['add_collocalstyle'][$this->blog_data1])){
								$q="select $col_fields from $this->master_col_table where col_id='$this->blog_data1'";  
								$ins=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
								$col_rows=$this->mysqlinst->fetch_assoc($ins,__LINE__);
								$this->mysqlinst->count_field($this->master_col_css_table,'css_id','',false);
								$value='';
								$css_id=$this->mysqlinst->field_inc;
								foreach ($this->col_field_arr as $field) {
									if($field==='col_table_base')$value.="'$this->tablename',";
									elseif($field==='col_table')$value.="'$this->col_table',";
									else $value.="'".$col_rows[$field]."',";
									}
			 
								$q="insert into $this->master_col_css_table   (css_id,col_id,$col_fields,col_update,col_time,token) values ($css_id,'c$this->blog_data1',$value '".date("dMY-H-i-s")."','".time()."','".mt_rand(1,mt_getrandmax())."')";   
								$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true); 
								$this->clone_local_style=true;
								if (is_file(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'column_css_clone_'.$this->tablename.'_'.$this->blog_data1))unlink(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'column_css_clone_'.$this->tablename.'_'.$this->blog_data1);
								}//submitted
							else $this->clone_local_style=false;
							}
						else {//count >1 col css style local
							 $q="select $col_fields from $this->master_col_css_table where col_table_base='$this->tablename' and col_id='c$this->blog_data1'"; 
							$lc=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
							$col_css_row=$this->mysqlinst->fetch_assoc($lc,__LINE__);
							$col_local_clone_collect_arr=array();
							foreach($this->col_field_arr as $cfield){//here we select and replace all replacable values in local column enabled cloned columns
								$col_local_clone_collect_arr[$cfield]=$col_css_row[$cfield];
								$this->$cfield=$col_css_row[$cfield];
								}
							$this->clone_local_style=true;
							$cssfile=Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'column_css_clone_'.$this->tablename.'_'.$this->blog_data1;
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
			$this->current_background_color= (preg_match(Cfg::Preg_color,explode('@@',$styles[$this->background_index])[0]))?explode('@@',$styles[$this->background_index])[0]:((array_key_exists($this->column_level,$this->column_background_color_arr))?$this->column_background_color_arr[$this->column_level]:'ffffff');
			$this->current_color= (preg_match(Cfg::Preg_color,$styles[$this->font_color_index]))?$styles[$this->font_color_index]:((array_key_exists($this->column_level,$this->column_color_arr))?$this->column_color_arr[$this->column_level]:'000000');
			$this->current_font_px=(!empty($styles[$this->font_size_index])&&$styles[$this->font_size_index]>=.5&&$styles[$this->font_size_index]<=4.5)?$styles[$this->font_size_index]*16:((array_key_exists($this->column_level,$this->column_font_px_arr))?$this->column_font_px_arr[$this->column_level]:16);
		#nested column subbed row id  
		$subbed_row_id=($this->blog_type==='nested_column')?'col_'.$this->blog_data1:$this->blog_id;
		#subbed_row_id will be used for retrieving the final post_subbed_row_data for every post record stored in flatfiles and used directly for retrieving append 		  
		#once again flatfiling to save non edit page queries
		#collecting important miscellaneous values for the current blog post both variables and class properties.. for flatfiling in editmode for use in webpage mode
			#remove if edit
			$append_arr=array();
			$append_arr['obj']=$append_arr['var']=array();
			$post_fields=Cfg::Post_fields;
			$post_field_arr=explode(',',$post_fields);
			$value='';   
			foreach ($post_field_arr as $field) {
				$collect[$field]=$this->$field; //for post subbed row...
				}
			$collect['blog_id']=$this->blog_id;
			$objvars=explode(',','rwd_post,blog_float,blog_table,column_lev_color,blog_border_stop,col_num,blog_order,blog_order_mod,fieldmax,is_clone,clone_local_style,clone_local_data');
			foreach ($objvars as $ov){ 
				$append_arr['obj'][$ov]=$this->$ov;
				}
			$vars=explode(',','subbed_row_id,clearfloat,show_new_blog,blog_order,tablename,blog_status,blog_unstatus,floatnew');
			foreach ($vars as $v){
				$append_arr['var'][$v]=$$v;
				}
			if ($this->blog_table_base!==$this->tablename&&!$this->clone_local_style){ 
				$this->page_stylesheet_inc[]=$this->blog_table_base; 
				}//this is used to include stylesheets of cloned posts
			
			
			
			(!is_dir(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir))&&mkdir(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir,0755,1);
				#popclone clone local data will use the parent and then subin the local clone specific data  see #populate local data above for more explanation
				 
			//if(!Sys::Pass_class&&(!$this->is_clone||$this->blog_status==='unclone'))
			if(!Sys::Pass_class&&!$this->is_clone)
			#we will access the parent post_subbed_data_row directly and sub in case of local data or local style!
			file_put_contents(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'post_subbed_row_data_'.$subbed_row_id,serialize($collect));#ok here if  cloned and not clone local style use parent page flat file version of this particular blog post so do not flat file.  The big advantage here is that all clones are immediately updated when the parent column updates since it will use the same flat file and config changes..  styles will be taken from the parent stylesheet ..
			 
			(!is_dir(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir))&&mkdir(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir,0755,1);	
			#original(!Sys::Pass_class)&&file_put_contents(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'post_append_data_'.$this->tablename.'_'.$orig_val['blog_id'],serialize($append_arr));//this is done foreach original and clone to retain separate directives...
			 
			if($this->blog_unstatus!=='unclone'&&!$this->is_clone){
				$appfile=$this->blog_id;
				file_put_contents(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'post_append_data_'.$appfile,serialize($append_arr));//this is done so initial clones can access original
				}
			else {
				$appfile=$this->tablename.'_'.$orig_val['blog_id'];
				file_put_contents(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'post_append_data_'.$appfile,serialize($append_arr));
				//contigency plan for a situation where a  post or column in a template/cloned column has been added on the parent column adding a new clone and the page where clone is expressed hasn't been updated in edit mode...
				copy(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'post_append_data_'.$appfile,Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'post_append_data_rescue_'.$orig_val['blog_id']);//will will adjust certain values to reflect this if ever used...
				}
			
			#flatfile info #flat file info
			#the following flat files are generated in editmode for use in webpage mode
			#data_col_list_  (see columnArrayFile)  is array of post id's within a particlar column..  this is so that any clones of this column can access this original list without  the clone edit page mode generating the data!!
			#column_data flat file of field values of particlar columns...
			#post_append_data  contains initial data to call the post_subbed_row_data which contains all the stored record fields from editmode.  It also contains all other necessary variables   generated in the editmode such as is_clone see  $append_arr
			#post_subbed_row_data contains main records for each blog post.  Importantly, clones will access the parent of post_subbed_row_data directly so changes can appear directly whereas local changes to styling or data will held in a local specific version of post_subbed_row_data and whatever fields the local version carries will override the values of the parent
			#un_clone_master_arr  the post append data provides a flat file of values after final substitutions for cloned or uncloned data but to reference it to obtain it we will use a consitent value for the flat file which is the $orig_val['blog_id']!  Note $this->blog_id=$orig_val['blog_id'] for posts which are not cloned or uncloned..
			#blog_clone_local_data_  page specific flat files local clone data for population in webpage mode to replace parent clone values for data fields
			#blog_clone_local_style_  page specific flat files local clone style fields for population in webpage mode o replace parent clone values for style and config fields
			 
			$uncFile=Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'un_clone_master_arr';
			if (!is_file($uncFile)) 
				$unc_file_arr=array();
			else $unc_file_arr=unserialize(file_get_contents($uncFile));
				
			    
			if ($blog_unstatus==='unclone'||$this->is_clone){		
				$unc_file_arr[$this->tablename.'_'.$orig_val['blog_id']]=$orig_val['blog_id']; 
				}
			/*elseif ($blog_unstatus==='unclone'&&$blog_status==='clone'){ //is nested column
				$unc_file_arr[$this->tablename.'_'.$orig_val['blog_id']]=$this->blog_id;
				}
			elseif ($blog_unstatus==='unclone'){ // 
				$unc_file_arr[$this->tablename.'_'.$orig_val['blog_id']]=$blog_id;
				}*/
			
			else if (array_key_exists($this->tablename.'_'.$orig_val['blog_id'],$unc_file_arr)){
				unset($unc_file_arr[$this->tablename.'_'.$orig_val['blog_id']]);
				} 
			file_put_contents($uncFile,serialize($unc_file_arr));
			 
			}//end Big edit || pass_class
			#big
		else {//! big edit   not edit begin
			$append_rescue=false;//initialize
			$this->is_blog=true;//will be reset if nested column in col_data
			$uncFile=Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'un_clone_master_arr';
			$unc_file_arr=unserialize(file_get_contents($uncFile));
			if (array_key_exists($this->tablename.'_'.$orig_val['blog_id'],$unc_file_arr)){  
				$unc_id=$unc_file_arr[$this->tablename.'_'.$orig_val['blog_id']];
				$appfile=Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'post_append_data_'.$this->tablename.'_'.$unc_id;  
				if (is_file($appfile)){ //choose the local if cloned first otherwise choose the parent data...
					//$appfile=$this->tablename.'_'.$unc_id;
					$append_arr=unserialize(file_get_contents($appfile));
					}
				else {
					mail::alert('unclone error '.__LINE__.' with orig val blog_id: '.$orig_val["blog_id"]);
					continue;
					}
				}
			elseif (is_file(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'post_append_data_'.$orig_val['blog_id'])){
				$appfile=Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'post_append_data_'.$orig_val['blog_id'];
				$append_arr=unserialize(file_get_contents($appfile));
				}
			else {//we are in a situation where a  post or column in a template/cloned column has been added on the parent column adding a new clone and the editpage for this page has not been accessed to generate the the new post append data file this orig_val[blogid]. However we can simply use the orig_vals to determine which subbed_post data and append data to use and in this case we can use the orig_vals to do a fresh webpage mode mysqli
				$append_rescue=true;//adjust appended values to suit this situation
				$appfile=Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'post_append_data_rescue_'.$orig_val['blog_id'];
				if (is_file($appfile)){
					$append_arr=unserialize(file_get_contents($appfile));
					}
				else {
					mail::alert('append file rescue attempt and files not found '.$appfile);
					continue;
					}
				}  
			foreach ($append_arr['obj'] as $key => $ov){  
				$this->$key=$append_arr['obj'][$key];                                  ;
				}
			foreach ($append_arr['var'] as $key =>$v){
				$$key=$append_arr['var'][$key];
				}
			if ($append_rescue){//see above for explanation
				$this->is_clone=true;
				$this->clone_local_data=$this->clone_local_style=false;
				}
			 	
			//echo NL."subbed row id is $subbed_row_id and this is blog is $this->is_blog and is_column is $this->is_column and $this->is_clone is is clone and this blog unstatus is $this->blog_unstatus and this this blog id is $this->blog_id and this org val blog id is ".$orig_val['blog_id']; 
			$blog_id_ext=($this->is_clone)?'cloned_'.$this->tablename.'_'.$this->blog_id:$this->tablename.'_'.$this->blog_id;//bypassing this for general approach 
			if (!Sys::Pass_class&&is_file(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'post_subbed_row_data_'.$subbed_row_id)){ 
				$collect_arr=file_get_contents(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'post_subbed_row_data_'.$subbed_row_id);//from appended data
				$collect=unserialize($collect_arr); 
				$post_fields=Cfg::Post_fields;
				$post_field_arr=explode(',',$post_fields);
				$value='';  
				foreach ($post_field_arr as $field){
					//if (array_key_exists($field,$collect)) 
					$this->$field=$collect[$field];  //populate blog row fields retrieved from flat file
					//else $this->$field='';
					}
				$this->blog_id=$collect['blog_id'];
				if(!$this->blog_pub&&!isset($_GET['showallunpub'])&&!Sys::Pass_class)continue;//main foreach
				}//
			else if (!Sys::Pass_class){
				mail::alert('flat file '.Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'post_subbed_row_data_'.$subbed_row_id.' not found line '.__LINE__);
				return;
				}
			}//end if not edit 
		if (!$this->edit&&!Sys::Pass_class&&$this->is_clone&&$this->clone_local_data){//now for local clone data if true we must flatfile the relevant localclonedata fields...
		 	$data_arr=array();
			if (is_file(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'blog_clone_local_data_'.$this->tablename.'_'.$this->blog_id)){
				$data_value=unserialize(file_get_contents(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'blog_clone_local_data_'.$this->tablename.'_'.$this->blog_id));
				foreach($data_value as $index => $field){
					$this->$index=$data_value[$index];
					}
				}
			else {
				mail::alert('flat file '.Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'blog_clone_local_data_'.$this->tablename.'_'.$this->blog_id.' not found line '.__LINE__);
				return;
				}
			}//if clone local data 
		if (!$this->edit&&!Sys::Pass_class&&$this->is_clone&&$this->clone_local_style&&$this->blog_type!=='nested_column'){//now for local clone style if true we must flatfile the relevant localclonestyle fields... 
			$style_arr=array();
			if (is_file(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'blog_clone_local_style_'.$this->tablename.'_'.$this->blog_id)){
				$style_value=unserialize(file_get_contents(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'blog_clone_local_style_'.$this->tablename.'_'.$this->blog_id));
				foreach($style_value as $index => $field){
					$this->$index=$style_value[$index];
					}
				}
			else {
				mail::alert('flat file '.Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'blog_clone_local_style_'.$this->tablename.'_'.$this->blog_id.' not found line '.__LINE__);
				return;
				}
			
			}//if clone local style
		 
		if(!$this->edit&&!Sys::Pass_class&&$this->blog_type==='nested_column'){ //!edit  for sake of flat filing and avoiding queries..
			
			//$file1=Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'column_data_unclone_'.$this->tablename.'_'.$this->blog_data1;
			$file2=Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'column_data_'.$this->blog_data1;
			
			if (is_file($file2))$file=$file2;
			//else if (is_file($file2))$file=$file2;
			else continue;
			$col_collect=file_get_contents($file);  
			$collect=unserialize($col_collect); 
               $col_field_arr2=$this->col_field_arr;
               $col_field_arr2[]='col_id'; 
			foreach ($col_field_arr2 as $field){
					// create upcoming nested column values; these values will be further substituted for css cloning options below if initiated...
				$this->$field=$collect[$field];//store parent column values for return replacement of parent values following each nested column iteration...
				}
			 
			if ($this->is_clone&&is_file(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'column_css_clone_'.$this->tablename.'_'.$this->blog_data1)){ 
				$col_local_clone_collect_arr=unserialize(file_get_contents(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'column_css_clone_'.$this->tablename.'_'.$this->blog_data1));
				foreach ($this->col_field_arr as $field){  
					// create upcoming nested column values; these values will be further substituted for css cloning options below if initiated...
					$this->$field=$col_local_clone_collect_arr[$field];//store parent column values for return replacement of parent values following each nested column iteration...
					}
				
				}	 
			}//nested column	
		if ($this->blog_type==='nested_column'){
			$this->column_options=explode(',',$this->col_options);//populate column options from locally cloned value
			for ($i=0;$i <count(explode(',',Cfg::Column_options)); $i++){
				if (!array_key_exists($i,$this->column_options))$this->column_options[$i]=0;	 
				} 
			}//if nested column...
		
		($this->is_clone&&$this->blog_unstatus!=='unclone')&&$blog_order=$this->blog_order=$orig_val['blog_order'];// here we are replacing blog order with orig_val blog_order which was actually derived from data_col_list_col_id which is original cloned column values so that if a post is newly added the updated blog orders will take effect immediately.. perhaps another reason to switch to ids !!
		$this->fieldmax=$this->mysqlinst->get('fieldmax'); 
		$this->clone_ext=($this->is_clone&&$this->clone_local_style)?'clone_':'';
		$this->data=$data=$this->clone_ext.$this->blog_table.'_'.$blog_order;//form  name fields
		if(($this->blog_type==='nested_column'&&$this->column_use_grid_array[$this->column_level]==='use_grid')||($this->blog_type!=='nested_column'&&$this->column_options[$this->column_use_grid_index]==='use_grid')){
			 
			$floatnew=true;
			$floatstyle='';
			$show_new_blog=false;
			$this->rwd_post=true;
			}
			
		else {  
			$this->rwd_post=false;
			$floatnew=false;
			 
			//floatnew when true sets up float condition for add new post before   post </div close so as not to break float 
			//here we control whether blogs share space within the row of a column width permitting...  this is for non-rwd posts..   show new blogs are controlled so as not to break floating or inline-block shares... by putting them within the post division instead of following...
			
			 
			if (empty($this->blog_float)||$this->blog_float==$this->position_arr[0]):
				$floatstyle='margin-left:auto;margin-right:auto;';
				$show_new_blog=true;
				printer::pclear();echo '<!--clear border float-->';
			elseif ($this->blog_float==$this->position_arr[1]):
				$floatstyle='display:inline-block;';// center floating by default...
				($this->fieldmax==$blog_order)&&$clearfloat=true;
				$floatnew=true;//clear float checks same parameters so will use value for floatnew
				$show_new_blog=false;
			elseif ($this->blog_float==$this->position_arr[2]):
				$floatstyle='float:left;';
				$show_new_blog=false;//do not show the new blog here option as it disrupts the floated series...
				($this->fieldmax==$blog_order)&&$clearfloat=true;
				$floatnew=true;//clear float checks same parameters so will use value for floatnew
			elseif ($this->blog_float==$this->position_arr[3]):
				($this->fieldmax==$blog_order)&&$clearfloat=true;	   
				$floatstyle='float: right;';//this sets up float for local...
				$show_new_blog=false;//do not show the new blog here option as it disrupts the floated series..
				$floatnew=true;//clear float checks same parameters so will use value for floatnew
			elseif ($this->blog_float==$this->position_arr[4]):
				$clearfloat=true;
				$floatstyle='float: left;';//this sets up float for local...
				$show_new_blog=true;//
			elseif ($this->blog_float==$this->position_arr[5]):
				$clearfloat=true;
				$floatstyle='float: right;';//this sets up float for local...
				$show_new_blog=true;//do not show the new blog here option as it disrupts the floated series... 
			
			elseif ($this->blog_float==$this->position_arr[6]):
				$clearfloat=true;	   
				$floatstyle='display:inline-table; margin-left:auto;margin-right:auto;';//this sets up float for local...
				$show_new_blog=false;//do not show the new blog here option as it disrupts the floated series..
				$clearfloat=true;
				//$floatnew=true;//clear float checks same parameters so will use value for floatnew
		 
			else:
				
				$floatstyle='margin-left:auto;margin-right:auto;';
				$show_new_blog=true;
				printer::pclear();echo '<!--clear border float-->';
			endif;
			 
			($this->blog_type!=='nested_column')&& $this->css.="\n.$data{".$floatstyle.'}'; 
			(!$this->edit)&&$floatnew=false;
			}//not rwd
		($this->fieldmax==$blog_order)&&$show_new_blog=true; 
		$this->pic_ext='_blog_pic';#extension for data to refer to pics .
		  $width='';   
		if(!empty($this->blog_border_start)){  
			 (isset($this->groupstyle_begin_col_id_arr[$this->col_id])&&isset($this->groupstyle_begin_blog_id_arr[$this->col_id]))&&printer::alertx('<p class="floatleft warn1">Caution need closing groupstyle for post Id '.$this->groupstyle_begin_blog_id_arr[$this->col_id]. " within this parent Column id $this->col_id before opening another</p>");
			 printer::pclear();echo '<!--clear caution group border-->';
			$this->groupstyle_begin_blog_id_arr[$this->col_id]=$this->blog_id;
			$this->groupstyle_begin_col_id_arr[$this->col_id]=true;
			print('<fieldset class="style_groupstyle"'.$width.'><legend></legend><!-- begin Group Style Border-->');// begin the border
			}
		
		 if($this->blog_type!=='nested_column'||$this->blog_data2!=='column_choice')$this->total_float_mod();//this does take nested columns...
		  else $this->current_net_width_percent=100; //else   applies only to nested columns undergoing column_choice
	if ($this->edit&&$this->current_net_width <50){//make viewable
			$this->current_net_width=200; 
			$this->show_more('Click to View '.str_replace('_',' ',strtoupper($this->blog_type)). ' Post','','small info Os3orange fsmoldlace posbackground white  click','',500,'',$floatstyle);echo '<!--open show more on-->';
			$this->current_net_width=250;
			$this->current_net_width_percent=100;
			$this->show_more_on=true;//signal to close out show_more following render
			}
		else $this->show_more_on=false;
		//$stylewidth='style="width:'.($this->current_net_width_percent).'%"';
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
		if (empty($this->blog_alt_rwd)){ 
               $this->blog_alt_rwd=array();
               for ($i=0; $i<count(explode(',',Cfg::Alt_rwd_options));$i++){ 
				$this->blog_alt_rwd[$i]=0;
				}
			}
		else {   
			$this->blog_alt_rwd=explode(',',$this->blog_alt_rwd);
			for ($i=0; $i<count(explode(',',Cfg::Alt_rwd_options));$i++){ 
				if (!array_key_exists($i,$this->blog_alt_rwd)){
					$this->blog_alt_rwd[$i]=0;
					} 
				}
			}
		 
		 #stylewidth
		#altrespon 
		if ($this->edit&&!$this->rwd_post&&strpos($this->blog_float,'float')===false){//here we checking if responsive width will apply at all.. if the post is not sharing space on the column then use max-width only
			$cb_data=($this->blog_type==='nested_column')?$this->col_table:$data; 
			$this->css.='
				.'.$cb_data.'{max-width:'.$this->current_total_width.'px;}';
				#providing css external style sheet with max-width
			}
		elseif ($this->edit&&!$this->rwd_post){//takes care of  width css for regular and nested column posts 
			$bouncewidth_per=($this->blog_alt_rwd[$this->blog_bounce_width_index]>10&&$this->blog_alt_rwd[$this->blog_bounce_width_index]<301)?$this->blog_alt_rwd[$this->blog_bounce_width_index]:0;
			$bouncewidth=$bouncewidth_per*$this->current_total_width/100;
			$minwidth_per=($this->blog_alt_rwd[$this->blog_min_width_index]>0&&$this->blog_alt_rwd[$this->blog_min_width_index]<101)?$this->blog_alt_rwd[$this->blog_min_width_index]:Cfg::Default_min_width;
			$mode=($this->blog_alt_rwd[$this->blog_width_mode_index]=='maxwidth'||$this->blog_alt_rwd[$this->blog_width_mode_index]=='compress_full_width'||$this->blog_alt_rwd[$this->blog_width_mode_index]=='compress_to_percentage')?$this->blog_alt_rwd[$this->blog_width_mode_index]:Cfg::Default_width_mode;
			
			$cb_data=($this->blog_type==='nested_column')?$this->col_table:$data; 
			//echo "mode is ".$this->blog_options[$this->blog_width_mode_index]."  and data is $cb_data"; 
			$minwidth=$minwidth_per*$this->current_total_width/100;
			$screen_min_bounceback=$this->column_total_width[0]*$minwidth_per/100;//check screen width for compression and reset post to original width as max-width
				//set up a min-width of percentage of width chosen... then set to a absolute minimum min-width with media query when screen size below the min width. In addition when the screen size is compressed from full size the amount of blog/col min width then reinstate the post size ie. allow bounce back using max-width....
			if ($mode==='maxwidth'){
			    $this->css.='
				.'.$cb_data.'{max-width:'.$this->current_total_width.'px;}';
				}
			elseif ($mode==='compress_full_width'){
				$this->css.='
				.'.$cb_data.'{width:'.($this->current_total_width_percent).'%;}';
				}
			elseif ($mode==='compress_to_percentage'){   
				$bouncecss= ($bouncewidth>9) ?'
				@media screen and (max-width:'.$screen_min_bounceback.'px){
				.'.$cb_data.'{
				width:'.($bouncewidth_per/100*$this->current_total_width_percent).'%;
				}
					}':'';
				$this->css.='
				.'.$cb_data.'{
				width:'.($this->current_total_width_percent).'%;
				min-width:'.$minwidth.'px;}
				'.$bouncecss.'
				@media screen and (max-width:'.$minwidth.'px){
				.'.$cb_data.'{min-width:0;
				width:auto;
				max-width:95%;}
				}';  
				}
				
			else{// default 
				    $this->css.='
					.'.$cb_data.'{max-width:'.$this->current_total_width.'px;}';
				}
			}//edit && !rwd
			 
		if ($this->blog_type!=='nested_column'){   
			$style=($this->edit&&$this->current_total_width<50)?'style="width:50px;"':'';
			list($bw,$bh)=$this->border_calc($this->blog_style);
			if (!empty($bw)) 
				$bs=$this->calc_border_shadow($this->col_style);
			$addclass=(empty($bw))?' bs3'.$this->column_lev_color.' ':((empty($bs))?' bshad3'.$this->column_lev_color.' ':'');
			 
			 $class=($this->rwd_post)?$data.' '.str_replace(',',' ',$this->blog_grid_width).' '.str_replace(',',' ',$this->blog_gridspace_right).' '.str_replace(',',' ',$this->blog_gridspace_left):$data;
			$nav_class='';
			if ($this->blog_type=='navigation_menu'){
				$nav_class=($this->blog_tiny_data2==='force_vert')?' vert':' horiz';
				$nav_class.=($this->blog_tiny_data3=='nav_display')?' display':' hover';
				}
		#maindiv blog
			$float_image=($this->blog_type==='float_image_left'||$this->blog_type==='float_image_right')?' float_image':'';//this is used for globalizing styles within a column with float image right and left we dont want to copy the image styles because of necessary padding between right and left but we do want to copy the text styles..  whereas image styles can also be globalized if type matches. to accomadate this in render textarea we use the css extenstion : float images and in images we use the the full blog type css extension.  Here we include both to cover all situations
		#maindiv
			$classHeight=($this->blog_height>9)?' respondHeight ':'';
			$dataHeight=($this->blog_height>9)?' data-rwd="'.$this->rwd_post.'" data-type="'.$this->blog_type.'" data-height="'.$this->blog_height.'" data-hwid="'.$this->current_total_width.'" ':'';
	 //echo "$this->current_net_width is curnetwd and total is $this->current_total_width and order is $this->blog_order and padded with is $this->current_padded_width_px";
		 	if (!$this->edit)
				print '<div id="'.$this->clone_ext.'post_'.$this->blog_id.'" '.$style.' class="'.$class.$nav_class.$classHeight.' '.$this->blog_type.$float_image.'"'.$dataHeight.'>';
			else {
		#fieldset  switched to class  //removed style="max-width:'.$this->current_total_width.'px;"
				print '<div id="'.$this->clone_ext.'post_'.$this->blog_id.'" class="'.$class.$nav_class.$addclass.' '.$this->blog_type.$float_image.'" ><!--Editpage fieldset post border--><p class="lineh90  editcolor shadowoff editbackground ">Post</p>'; 
				printer::pclear();
				}
			
			 
			$this->background_video('blog_style');
			}//if !nested column
		 
		
				
		if ($this->edit&&$this->blog_type!='nested_column'){
			
			if ($blog_status=='clone'&&$blog_unstatus=='unclone'&&!empty($blog_clunc_id)){
				$this->delete_unc_clone_option($blog_clunc_id);//give option to remove unclone
				 
				}
			
			if (empty($this->blog_pub)){
				if (!$this->is_clone||$this->clone_local_style){
					echo '<div class="fsminfo editbackground rad10 floatleft"><!--wrap publish-->';
					printer::alertx('<p class="pos floatleft editbackground bold"><input type="checkbox" value="1" name="'.$data.'_blog_pub"> Publish Post to Web Pages<br></p>');
					$this->navobj->return_url($this->tablename,'',$this->column_lev_color.' floatleft   shadowoff smallest button'.$this->column_lev_color,true);
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
				 printer::alertx('<p class="editcolor fs2npred small floatleft editfont editbackground "><span class="red">Cloned Post </span> '.$clone_msg.' changes to: P'.$this->blog_id.' @ Page <a class="whiteshadow2" style="color:#0075a0;"  target="_blank" href="'.check_data::dir_to_file(__METHOD__,__LINE__,__FILE__,$this->blog_table_base).$this->ext.'#post_'.$this->blog_id.'"><u>'.check_data::table_to_title($this->blog_table_base,__method__,__LINE__,__file__).'</u></a> Appear Here Also </p>');
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
				printer::pclear();
				#enable clone options
				#enable local post
				
				if (empty($this->clone_local_style&&$this->is_clone)){ 
					$this->show_more('Enable Local Post Style','noback','small info editbackground rad3 fs2npinfo click','Enable Local Styling of this Cloned Post Without Affecting the styling of the Parent Post',600); 
					$msg='Check to enable local styling of this clone without affecting the parent style';
					echo '<div class="fsminfo editbackground  floatleft '.$this->column_lev_color.'"><!--Local clone style-->';
					printer::printx('<input type="checkbox" name="add_bloglocalstyle['.$blog_id.']" value="1" >'.$msg);
					printer::alert_neu('Note: By enabling Local Styling of this Post the Styling which includes floating and width, and various settings, will not Update When the Parent Style Updates, instead only when you make styling changes here',.8);
					echo '</div><!--Local clone style-->';
					$this->show_close('Local clone style');
					}
				else{
					$this->show_more('Disable Local Post Style','noback','small info editbackground rad3 fs2npinfo click','Disable Local Styling of this Cloned Post and Return to the Parent Post Style',600); 
					$msg='Disable local post styling';
					echo '<div class="fsminfo editbackground  floatleft '.$this->column_lev_color.'"><!--Local clone style-->';
					printer::printx('<input type="checkbox" name="delete_bloglocalstyle['.$blog_id.']" value="1" >'.$msg);
					printer::alertx('<p class="small info">Note: By disabling Local Styling of this Post the Styling which includes floating and width, colors,etc, WILL NOW assume the style of the Parent and Update When the Parent Style Updates</p>');
					echo '</div><!--Local clone style-->';
					$this->show_close('Local clone style2');
					}
				if ($this->blog_type==='text'||$this->blog_type==='gallery'){
					if (empty($this->clone_local_data&&$this->is_clone)){ 
						$this->show_more('Enable Local Post Data','noback','small info editbackground rad3 fs2npinfo click','Enable Local Data while keeping all Cloned Styling of this Cloned Post Without Affecting the Data of the Parent Post',600); 
						$msg='Check to enable local data while retaining cloned style of this clone post and without affecting the parent data';
						echo '<div class="fsminfo editbackground  floatleft '.$this->column_lev_color.'"><!--Local clone style-->';
						printer::printx('<input type="checkbox" name="add_bloglocaldata['.$blog_id.']" value="1" >'.$msg);
						//printer::alert_neg('Note: By enabling Local Styling of this Post the Styling which includes floating and width, and various settings, will not Update When the Parent Style Updates, instead only when you make styling changes here',.8);
						echo '</div><!--Local clone style-->';
						$this->show_close('Local clone style3');
						}
					else{
						$this->show_more('Disable Local Post Data','noback','small info editbackground rad3 fs2npinfo click','Disable Local Styling of this Cloned Post and Return to the Parent Post Style',600); 
						$msg='Disable local post Data';
						$msg='Will return to full clone without local data changes';
						echo '<div class="fsminfo editbackground  floatleft '.$this->column_lev_color.'"><!--Local clone style-->';
						printer::printx('<input type="checkbox" name="delete_bloglocaldata['.$blog_id.']" value="1" >'.$msg);
						printer::alertx('<p class="small info">Note: By disabling Local Styling of this Post the Styling which includes floating and width, colors,etc, WILL NOW assume the style of the Parent and Update When the Parent Style Updates</p>');
						echo '</div><!--Local clone style-->';
						$this->show_close('Local clone style4');
						}
					}//blog types enabled for local data
				}//not tagged and is clone
				
			elseif($this->is_clone && $this->tagged){
				printer::alertx('<p class="neg fs2npred small floatleft editfont editbackground left shadowoff">This Post is a <u><span class="orange whitebackground">Tagged Post</span></u> and Changes to the Parent Post Id: P'.$blog_id.' on Page <a style="color:#0075a0;"  target="_blank" href="'.check_data::dir_to_file(__METHOD__,__LINE__,__FILE__,$this->blog_table_base).$this->ext.'#post_'.$blog_id.'"><u>'.check_data::table_to_title($this->blog_table_base,__method__,__LINE__,__file__).'</u></a> Will Appear Here </p>');
				printer::pclear();echo '<!--clear tagged Post-->';
				}
			}// is edit and !nested_column
		$alerted=($this->is_clone)?'this is clone': ' this is not clone';
		// if ($this->blog_type!=='nested_column')echo printer::alert_neg($alerted);
		//#functs
		if($this->blog_options[$this->blog_date_on_index]==='date_on'){
			list($date,$v,$n)=$this->format_date($this->blog_date);
			echo '<div class="floatleft style_date">'.$date.'</div>';
			
			if ($this->edit){
				printer::pclear();
				echo '<!--clear date entry-->';
				}
			}
		
		
		if ($this->blog_type=='text'){ 
			$this->text_render($data,$this->blog_table);
			($this->blog_options[$this->blog_comment_index]==='comment_on')&&$this->comment_display($data,'blog_data7');
			($floatnew)&&$this->blog_new($data,$this->blog_table,$blog_order, $this->blog_order_mod.' in');
			 }
			#blog_type,blog_pic,blog_style,blog_text,blog_link,blog_linkref,blog_order
		elseif ($this->blog_type=='image'){ 
			$this->build_pic($data,Cfg_loc::Root_dir.Cfg::Page_images_dir); 
			($floatnew)&&$this->blog_new($data,$this->blog_table,$blog_order, $this->blog_order_mod.' in');
			}
		elseif ($this->blog_type=='float_image_right'){
			$this->float_pic($data, Cfg_loc::Root_dir.Cfg::Page_images_dir); 
			($this->blog_options[$this->blog_comment_index]==='comment_on')&&$this->comment_display($data,'blog_data7');
			($floatnew)&&$this->blog_new($data,$this->blog_table,$blog_order, $this->blog_order_mod.' in');
			}
		elseif ($this->blog_type=='float_image_left'){
			$this->float_pic($data, Cfg_loc::Root_dir.Cfg::Page_images_dir); 
			($this->blog_options[$this->blog_comment_index]==='comment_on')&&$this->comment_display($data,'blog_data7');
			($floatnew)&&$this->blog_new($data,$this->blog_table,$blog_order, $this->blog_order_mod.' in');
			 }
		 
		elseif ($this->blog_type=='video'){  
			$this->video_post($data,$this->blog_data3);
			($floatnew)&&$this->blog_new($data,$this->blog_table,$blog_order, $this->blog_order_mod.' in');
			}
		 
		elseif ($this->blog_type=='contact'){ 
			$this->contact_form($data,'',false,'Edit Overall Contact Form Styling',true,$this->blog_table); 
			($floatnew)&&$this->blog_new($data,$this->blog_table,$blog_order, $this->blog_order_mod.' in'); 
			}
		elseif ($this->blog_type=='social_icons'){
			$this->social_icons($data,'',false,'Edit Social Icon Styling',true,$this->blog_table); 
			($floatnew)&&$this->blog_new($data,$this->blog_table,$blog_order, $this->blog_order_mod.' in'); 
			}
		elseif ($this->blog_type=='auto_slide'){
			$this->auto_slide($data,'blog'); 
			($floatnew)&&$this->blog_new($data,$this->blog_table,$blog_order, $this->blog_order_mod.' in'); 
			}
		elseif ($this->blog_type=='gallery'){ 
			$this->gallery($data,$this->blog_data1); 
			($floatnew)&&$this->blog_new($data,$this->blog_table,$blog_order, $this->blog_order_mod.' in'); 
			}
		elseif ($this->blog_type=='navigation_menu'){  
			$this->nav_menu($data,$this->blog_data1,false,'',true,$tablename);  
			($floatnew)&&$this->blog_new($data,$this->blog_table,$blog_order, $this->blog_order_mod.' in');   
			}
		elseif ($this->blog_type=='misc'){  return;//not in play
			$this->misc($data);  
			($floatnew)&&$this->blog_new($data,$this->blog_table,$blog_order, $this->blog_order_mod.' in');   
			} 
 #nested  #nc
		elseif ($this->blog_type==='nested_column'){
			$this->col_id=$this->blog_data1;
			$this->clone_ext=($this->is_clone&&$this->clone_local_style)?'clone_':'';  
			#&&&&&&&&&  Note: till nest column function called column level still parent!  &&&&&&&&&&&&&&&&&&&
			 $this->blog_order_arr[$this->column_level]=$orig_val['blog_order'];//this currently appears to be used for html div <!-- reference only -->
			
	#nesteddiv
			 
			$fscss=(!$this->rwd_post)?$floatstyle:'';
			$textalign=' text-align:center;';//this is applied for cases in which rwd is not used and center float (inline-block) is used for posts within this column in order that ..  also use when rwd is in play for consistency 
			($this->edit&&!$this->rwd_post)&&$this->css.="\n.$this->clone_ext$this->col_table{ ".$fscss.$textalign.'}';
			#NON RWD WIDTHS HANDLED BY CSS IN maindiv
			 $width_express='';//($this->width_max_px)?'style="max-width:'.($this->current_net_width).'px;"':'style="width:'.($this->current_net_width_percent).'%;"'; 
			$stylewidth=($this->column_use_grid_array[$this->column_level]==='use_grid')?'':((!empty($this->current_total_width))?$width_express:'style="width:auto;"'); //echo NL. ' now '.$stylewidth.NL;
			 $class=($this->rwd_post)?$this->clone_ext.$this->col_table.' '.str_replace(',',' ',$this->col_grid_width).' '.str_replace(',',' ',$this->col_gridspace_right).' '.str_replace(',',' ',$this->col_gridspace_left):$this->clone_ext.$this->col_table;
			list($bw,$bh)=$this->border_calc($this->col_style); 
			if (!empty($bw)) 
				$bs=$this->calc_border_shadow($this->col_style);
			$addclass=(empty($bw))?' bdot3'.$this->color_arr_long[$this->column_level+1].' ':((empty($bs))?' bshad3'.$this->column_lev_color.' ':'');
		 	if (!$this->edit)
				print '<div id="'.$this->clone_ext.'col_'.$this->col_id.'" class="'.$class.' nested"><!--Begin Nested Column id'.$this->col_id.'-->';
			else  {
			#fieldset  switched to class     add addclass for edit border...
				echo '<div id="'.$this->clone_ext.'col_'.$this->col_id.'" class="'.$class.$addclass.' nestedcolumn" ><p class="lineh90  shadowoff editcolor editbackground" >Nested Column</p><!--Begin edit faux fieldset Nested Column id'.$this->col_id.'-->';
				printer::pclear();  
				if($blog_status=='clone'&&$blog_unstatus=='unclone'&&!empty($blog_clunc_id)){
					$this->delete_unc_clone_option($blog_clunc_id);
					$this->is_clone=true;
					}
				echo $deleteclone;
				printer::pclear();echo '<!--clear field level2-->';
				if (empty($this->blog_pub)){
					if (!$this->is_clone||$this->clone_local_style){
						printer::alertx('<p class="pos floatleft editbackground large bold"><input type="checkbox" value="1" name="'.$data.'_blog_pub"> Publish Nested Column to WebPages</p>');
						}
					}
				//($this->blog_data2!=='column_choice')&&$this->print_total_float();
				}
					//col_table_base,col_id,col_table,
			
			$objvars_hold=array();
			$objvars=explode(',','rwd_post,blog_float,blog_table,column_lev_color,blog_border_stop,col_num,blog_order,blog_order_mod,fieldmax,is_clone,clone_local_style,clone_local_data');
			foreach ($objvars as $ov){ 
				$objvars_hold[$ov]=$this->$ov;
				}
			 
				 
			//else if (is_file($file2))$file=$file2;
			$this->nested_column();
			//now we begin restore restore function scope class properties ...
			//class functions need to be restored
			//variables will restore automatically as original scope returns by defualt
			 
			$this->blog_type='nested_column'; 
			
			$col_field_arr2=$this->col_field_arr; 
			$col_field_arr2[]='col_id';
			#here we restore the previous round of column values stored as variables not properties 
			foreach ($col_field_arr2 as $field) {  
				$this->$field=${'restore_'.$field}; 
				} 
			$this->column_options=explode(',',$this->col_options);//populate column options from locally cloned value
			for ($i=0;$i <count(explode(',',Cfg::Column_options)); $i++){
				if (!array_key_exists($i,$this->column_options))$this->column_options[$i]=0;	 
				}  
			
			foreach ($objvars_hold as $key => $ov){
				$this->$key=$objvars_hold[$key]; 
				}
			 
			($floatnew)&&$this->blog_new($data,$this->blog_table,$blog_order, $this->blog_order_mod.' in'); 
			$this->current_net_width=$this->column_net_width[$this->column_level];
			$data=$tablename.'_'.$this->blog_order_arr[$this->column_level];//this appears to be used for html div <!-- reference only -->
			print '</div><!--End Nested Column id:'. $this->column_id_array[$this->column_level+1].' -->';
			}//end nested column.... 
		else {
			$msg="Missed the boat with blog id $this->blog_id and type $this->blog_type  in ".__method__ ;
			mail::alert($msg);
			echo $msg;
			}
		
		#reinit clone status for all
		$this->is_clone=(array_key_exists($this->column_level,$this->column_clone_status_arr)&&$this->column_clone_status_arr[$this->column_level])?true:false;
		if ($this->blog_type!=='nested_column')
			print '</div><!--'.$data.' id#'.$this->blog_id.' '.$this->blog_type.'-->';
		if ($this->edit&&$this->show_more_on){
			$this->show_more_on=false;
			$this->show_close('show more on');echo '<!--close show more on-->';
			}
			 
		if  (!$this->rwd_post&&$this->blog_float==$this->position_arr[0]||$this->blog_float==$this->position_arr[4]||$this->blog_float==$this->position_arr[5]||$this->blog_float==$this->position_arr[6]){ 
			 printer::pclear(); echo '<!--clear post level-->';
			}
		 
		if (!empty($this->blog_border_stop)) {
			//($this->edit)&&printer::alert_neg('Extra blog boarder alert Above Post');
			unset($this->groupstyle_begin_col_id_arr[$this->col_id]);
			unset($this->groupstyle_begin_blog_id_arr[$this->col_id]);
			print('</fieldset><!--'.$this->blog_table.' .style _groupstyle-->'); #end the border
			}  
		 
		($this->edit&&!$floatnew)&&$this->blog_new($tablename.'_'.$this->blog_order,$tablename,$blog_order, $this->blog_order_mod.' in ');
		
		$this->clone_local_style=false; //reinitialize
		$this->clone_local_data=false;		 
		}#end while #actually a foreach now
	
	($this->edit&&isset($this->groupstyle_begin_col_id_arr[$this->col_id]))&&printer::alertx('<p class="floatleft warn1">Caution You have an error having not closed  an open groupstyle for post Id '.$this->groupstyle_begin_blog_id_arr[$this->col_id]. " within this parent Column id $this->col_id</p>");
		if ($prime){  
			printer::pclear();echo '<!--clear prime level-->';
				print'</div><!--End Primary Column id '.$this->col_id.'-->';
				}
			
	 // ($clearfloat)&&printer::pclear();echo '<!--Clear Float Column Level-->';
		if  ($this->blog_float==$this->position_arr[0]||$this->blog_float==$this->position_arr[4]||$this->blog_float==$this->position_arr[5]||$this->blog_float==$this->position_arr[6]){ 
			 printer::pclear(); echo '<!--clear Column level-->';
			}
	$this->is_blog=false;//turned off...   first use is for determining element size for rendering font size preview in styling options..
	$this->blog_status='';
	}#end blog_render function	
# Post_fields='blog_type,blog_pic_info,blog_table,blog_style,blog_float,blog_alt,blog_text,blog_link,blog_data1,blog_data2,blog_linkref,blog_order';



function switch_clone_options($target_id,$prime,$type){ 
	##############
	if (!$this->edit)return;
	$globalize=(isset($_POST['globalize_clone_switch_'.$target_id])&&$_POST['globalize_clone_switch_'.$target_id]==1)?true:false;
	if (isset($_POST['primary_switch_clone'][$target_id])){  
		if (is_numeric(substr_replace(trim($_POST['primary_switch_clone'][$target_id]),'',0,1))){
			$newclone=substr_replace(trim($_POST['primary_switch_clone'][$target_id]),'',0,1);
			if (strtolower(substr(trim($_POST['primary_switch_clone'][$target_id]),0,1))=='c'){
				$AND=($globalize)?'':" AND col_base='$this->tablename'";
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
			if (strtolower(substr(trim($_POST[$type.'_switch_clone'][$target_id]),0,1))=='p'){
				$AND=($globalize)?'':" AND blog_table_base='$this->tablename'";
				$q="update $this->master_post_table set blog_clone_target='$newclone'  where   blog_clone_target='$target_id' $AND";
				$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
				if ($this->mysqlinst->affected_rows())$this->success[]="You have successfully switched cloned '.$type Id$target_id to post Id$newclone";
				else $this->message[]='No clone switch updates were made for '.$type.' Id'.$target_id;
				}
			elseif (strtolower(substr(trim($_POST[$type.'_switch_clone'][$target_id]),0,1))=='c'){
				$AND=($globalize)?'':" AND blog_table_base='$this->tablename'";
				$q="update $this->master_post_table set blog_data1='$newclone'  where   blog_data1='$target_id' $AND";
				$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
				if ($this->mysqlinst->affected_rows())$this->success[]="You have successfully switched cloned $type Id$target_id to column Id$newclone";
				else $this->message[]='No clone switch updates were made for '.$type.' Id'.$target_id;
				}
			else $this->message[]='Include the column or post Id prefix  (ie. c4 or p52)';
			}
		}
	$msg='Option for quickly switching to a different targeted clone';
	$this->show_more('Switch Clone Option','noback','tiny fs1info rad5 info editbackground',$msg,500);
	$msg=($prime)?'Change this Cloned Primary Column by entering a new Column Id (ie c5) from another page to Clone Here instead':(($type=='column')?'Change this Cloned Nested Column by entering a new Column Id (ie. c5) or Post Id (ie. p55) from another page to Clone Here instead':'Change this cloned Post by entering a Column Id (ie. c5) or Post Id (ie. p55) from another page to Clone Here instead'); 
	 
	echo '<div class="fsminfo editcolor editbackground ">'.$msg.'<!--switch div-->';
	if ($prime)
	 printer::printx('<p class="editfont editcolor editbackground"><input   style="background:#'.$this->editor_background.';color:#'.$this->editor_color.';" type="text" name="primary_switch_clone['.$target_id.']" size="6" maxlength="7" value="">Enter New Column Id </p>');
	 else  
	printer::printx('<p class="editfont editcolor editbackground"><input  style="background:#'.$this->editor_background.';color:#'.$this->editor_color.';" type="text" name="'.$type.'_switch_clone['.$target_id.']"  size="6" maxlength="7" value="">Enter Id to Clone Here/p>');
	$msg="Check Here To Switch Cloned $type Id$target_id for every page on the website that it occurs to the new clone Id choice.";
	$msg_alert="Switching $type Id$target_id to a new clone will be globalized to everypage.  Uncheck to Effect only the Current Page";
	printer::printx('<p class="caution small"><input class="global_switch_clone" type="checkbox" name="globalize_clone_switch_'.$target_id.'"   onchange="gen_Proc.on_check_event(\'globalize_clone_switch_'.$target_id.'\',\''.$msg_alert.'\');" value="1">'.$msg.'</p>');
	echo '</div><!--switch div-->';
	$this->show_close('switch to new clone');	
	}

	
	
function total_float_mod($prime_col=false,$return=false){ 
       if ($prime_col){ 
			$this->current_overall_floated_total[$this->column_level]=0;//not used..
		if (!$this->col_primary&&$this->tablename!==$this->col_table_base){//is a nested column clone in pp primary position..
			$this->col_width='';// hmm
			}
		$styles=explode(',',$this->col_style);
		}
	 
	elseif ($this->blog_type=='nested_column'){ 
		   $styles=explode(',',$this->col_style);
		   }
	else $styles=explode(',',$this->blog_style); 
	//$margin_left=(array_key_exists($this->margin_left_index,$styles)&&is_numeric($styles[$this->margin_left_index]))? $styles[$this->margin_left_index]:0;
	list($border_width,$border_height)=$this->border_calc($styles); 
	//$margin_right=(array_key_exists($this->margin_right_index,$styles)&&is_numeric($styles[$this->margin_right_index]))? $styles[$this->margin_right_index]:0;
	 if ($prime_col){ 
		$this->col_width=(is_numeric($this->col_width)&&$this->col_width > 1 &&$this->col_width <= Cfg::Col_maxwidth)?$this->col_width:0;
		$this->current_total_width=$this->column_total_width[$this->column_level]= (!empty($this->col_width))?$this->col_width:((!empty($this->page_width))?$this->page_width:1280);// page_width setting passes to create new page..
		list($padding_total,$margin_total)=$this->pad_mar_calc($styles); 
		$this->current_net_width=$this->column_net_width[$this->column_level]=$this->column_total_width[$this->column_level]-(($border_width+$padding_total)); //margins not limiting in primary column
		$this->background_img_px=$this->current_net_width; 
		return;
		}
	$widmax=$this->column_net_width[$this->column_level];
	if ($this->blog_type=='nested_column'){ 
		 
		$this->col_width= (!empty($this->col_width)&&is_numeric($this->col_width)&&$this->col_width>0&&$this->col_width<=100)?$this->col_width:100;
		
		$this->current_total_width=$this->column_total_width[$this->column_level+1]= ($this->col_width)*$widmax/100;
		$this->current_total_width_percent=$this->col_width;
		list($padding_total,$margin_total)=$this->pad_mar_calc($styles);
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
		$this->current_net_width=$this->column_net_width[$this->column_level+1]=$this->col_width*$widmax/100-$this->current_padded_width_px;
		$this->current_net_width_percent=$this->col_width-$this->current_padded_width_percent; //col_width for nested columns are stored as percentages
		
		} //end nested
	else  {// is blog 
		$this->blog_width=(!empty($this->blog_width)&&is_numeric($this->blog_width)&&$this->blog_width>0)?$this->blog_width:100;
		
		$this->current_total_width=$this->blog_width*$widmax/100;
		$this->current_total_width_percent=$this->blog_width;
		list($padding_total,$margin_total)=$this->pad_mar_calc($styles);
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
		$this->current_net_width_percent=$this->blog_width-$this->current_padded_width_percent;
		$this->current_net_width=$this->blog_width*$widmax/100-$this->current_padded_width_px;
		if ($this->blog_type==='image'){
			list($bw,$bh)=$this->border_calc($this->blog_data4);
			$hwidth=$this->calc_image_height($bh); 
			if ($hwidth > 9&&$hwidth<$widmax){ //we dont want to overexpand image..
				//percentage expressed in compress_to_percentage...  choice
				$this->current_net_width_percent=$this->blog_width-($bw*$this->column_total_width[$this->column_level]/100+$this->current_padded_width_percent);
				$this->current_total_width_percent=$hwidth/$this->current_total_width*$this->blog_width;
				$this->current_net_width=$hwidth-($bw+$this->current_padded_width_px);//current padded calculate for border sides presuming same for height
				$this->current_total_width=$hwidth; 
				}
			}
		} 
	$this->background_img_px=$this->current_net_width; 
	}	 
			
function delete_col($col_id,$clone=false){   
	$this->delete_col_arr[]=$col_id;//used in funct blog render
	static $inc=0;  $inc++;
	$q="select  blog_id,blog_type,blog_data1,blog_status from $this->master_post_table where blog_col='$col_id' and blog_table_base='$this->tablename'";
	$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	if ($this->mysqlinst->affected_rows()){
		while (list($blog_id,$blog_type,$blog_data1,$status)=$this->mysqlinst->fetch_row($r,__LINE__)){
			$q="delete from $this->master_post_table where blog_id='$blog_id' and blog_table_base='$this->tablename'";
			 $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
			if ($this->mysqlinst->count_field($this->comment_table,'com_id','',false," where comment_blog_id='$blog_id'")){
					$q="delete from ".$this->comment_table." where comment_blog_id='$blog_id' and blog_table_base='$this->tablename'"; 
					$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
					} 	
			if ($this->mysqlinst->count_field($this->master_post_css_table,'blog_id','',false,"Where blog_id='$blog_id'")>0){
				$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
				$q="delete from ".$this->master_post_css_table." where blog_id='p$blog_id' and blog_table_base='$this->tablename'";
				 $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
				}  
			if ($blog_type=='nested_column'&&!empty($blog_data1)&&is_numeric($blog_data1)){
				if ($status !=='clone')
				$this->delete_col($blog_data1);
				}
			} 
		}
	$q="delete from $this->master_post_table where blog_data1='$col_id' and blog_table_base='$this->tablename' ";  
	$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	$q="DELETE FROM $this->master_col_table WHERE col_id='$col_id' and col_table_base='$this->tablename'";   
	$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	$msg=(!$clone)?"Column ID $col_id and all its posts have Been Deleted":'Cloned Column has been removed';
	$this->success[]=$msg;
	}
	
function process_col(){ 
		
		$q="select col_table, col_id from $this->master_col_table where col_table_base='$this->tablename'";  
		$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
		if ($this->mysqlinst->affected_rows()){
			while (list($col_table,$col_id)=$this->mysqlinst->fetch_row($r,__LINE__)){
				$this->process_col_data($col_table,$col_id);
				if (isset($_POST['col_configcopy'][$col_id])){ 
					$this->process_col_configcopy($col_id);
					}
				(isset($_POST['col_configexport'][$col_id]))&& 
					$this->process_col_configexport($col_id); 
				(isset($_POST['col_rwdexport'][$col_id]))&& 
					$this->process_col_rwdexport($col_id); 
				}
			}
		$q="select col_table, css_id from $this->master_col_css_table where col_table_base='$this->tablename'";  
		$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
		if ($this->mysqlinst->affected_rows()){
			while (list($col_table,$css_id)=$this->mysqlinst->fetch_row($r,__LINE__)){
				$where2=" and col_table_base='$this->tablename'";
				$this->process_col_data($col_table,$css_id,$this->master_col_css_table,Cfg::Col_css_fields,$where2,'clone_');
				}
			}
		

		}
		
		
function process_col_data($tablename,$col_id,$dbtable=Cfg::Columns_table,$fields=Cfg::Col_fields,$where2='',$prefix=''){
	#prefix used for cloned tables to distinguish when from originating from same page.. intra clones
	$field_array=explode(',',$fields); 
	$process=process_data::instance();
	//(!isset($this->post_scrubbed))&&$this->post_scrubbed = array_map(array($process,'spam_scrubber'), $_POST);//class process_data
	$update= 'SET ';  
	
	//standard form for processing is $this->blog_table.'_'.$refval1.'_blog_field
	for ($x=0; $x<count($field_array); $x++){
		$check_suffix=(isset($_POST[$prefix.$tablename.'_'.$field_array[$x].'_arrayed']))?'_arrayed':'';//style holding variables have _arrayed appended.. to preserve original implosion
		if (isset($_POST[$prefix.$tablename.'_'.$field_array[$x].$check_suffix])) {
			if (is_array($_POST[$prefix.$tablename.'_'.$field_array[$x].$check_suffix])){ 
				$q='select '.$field_array[$x]." from  $dbtable wHErE col_table='$tablename' $where2";   
				$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);  
				list($c_val)=$this->mysqlinst->fetch_row($r,__LINE__);
				${$field_array[$x]}=process_data::implode_retain_vals($_POST[$prefix.$tablename.'_'.$field_array[$x].$check_suffix],$c_val,',','@@');
				}
			else ${$field_array[$x]}=process_data::spam_scrubber($_POST[$prefix.$tablename.'_'.$field_array[$x].$check_suffix]);
			$update.=" {$field_array[$x]}='${$field_array[$x]}',";  
			}
		}
	if ($update== 'SET ')return; 
	$update.="col_time='".time()."',token='".mt_rand(1,mt_getrandmax())."',col_update='".date("dMY-H-i-s")."'";//substr_replace($update,'',-1); 
	$q="UPDATE $dbtable $update WhErE col_table='$tablename' $where2";   
	$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);  
	$vars=(mail::Defined_vars)?get_defined_vars():'defined vars set off';
	$vars=print_r($vars,true); 
		try {  
			if ($this->mysqlinst->affected_rows()) { 
				$msg='Column Data HAS BEEN UPDATED.'; 
				(!in_array($msg,$this->success))&&$this->success[]=$msg;
				// $this->backup_page_arr[]=array($dbtable,"WhErE col_table='$tablename' $where2");#used for generating styles of pages where clones of posted content changes may be used.
				}
			else {
				if (Sys::Debug)echo NL. $q. NL;
				$msg="No Column Data Update with $q";
				$this->message[]=$msg;
				// echo '<p style="font-weight: bold; font-size: 1.4em; color:#'.$this->redAlert.'">'.$msg.'</p>';
				throw new mail_exception($msg." ".$q);
				}
			}	
		catch(mail_exception $me){
			$me->exception_message();  
			}
		
	}

function process_blog($tablename,$col_id){ 
	$this->is_blog=true;
	$this->blog_id_array=array();// whether submitted or not this must be populated below... for tinymce
	#check for posted values... without displaying values
	 $count=$this->mysqlinst->count_field($this->master_post_table,'blog_order','',false,"Where blog_table='$tablename'");   
	if ($count<1){  
		if (isset($_POST[$tablename.'_0_blog_new'])){   
			$blogtype=$_POST[$tablename.'_0_blog_new'];  
			  ($blogtype!=$this->choose_blog_type)&&$this->create_blog($tablename,$blogtype,10,0);//this type appears by default so elimate the choice
			}
		if (isset($_POST[$tablename.'_0_blog_new_add_second'])){   
			$blogtype=$_POST[$tablename.'_0_blog_new_add_second'];  
			  ($blogtype!=$this->choose_blog_type)&&$this->create_blog($tablename,$blogtype,10,$this->insert_half);//this type appears by default so elimate the choice
			}
		
		$this->is_blog=false;
		return;
		}  
	 $q="select blog_id,blog_order,blog_table from ".$this->master_post_table." Where blog_table='$tablename' order by blog_order";  
	$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	$tidy=false;
	while($rows=$this->mysqlinst->fetch_assoc($r,__LINE__)){
		$blog_order=$rows['blog_order'];
		if (substr($blog_order,-1)!=='0')$tidy=true;
		$blog_id=$rows['blog_id'];   
		$this->blog_table=$rows['blog_table']; #this is needed as check for edit pages_obj
		#fine to do this befor edit pages_obj
		$this->process_blog_border($tablename.'_'.$blog_order,$tablename,$blog_order);#new blog says don't update posted vals because blog_order will be updated with new_blog Post# process posts  can change current value of border etc..	
		 $this->process_blog_input($tablename.'_'.$blog_order,$tablename,$blog_order);#new blog says don't update posted vals because blog_order will be upda
		$this->editpages_obj($this->master_post_table,Cfg::Post_fields,$this->blog_table.'_'.$blog_order.'_','blog_order',$blog_order,'blog_table',$this->blog_table,'update','',",blog_time=".time().",token='". mt_rand(1,mt_getrandmax())."', blog_update='".date("dMY-H-i-s")."'");#all the posted blogs before tidying is done... the last arguement will return after updating...
		//the following done after updating in case of changes to the post being exported
		(isset($_POST['post_configexport'][$blog_id]))&& 
			$this->process_post_configexport($blog_id);
		(isset($_POST['post_configcopy'][$blog_id]))&&
			$this->process_post_configcopy($blog_id); 
		(isset($_POST['post_altrwdexport'][$blog_id]))&& 
			$this->process_post_altrwdexport($blog_id);
		(isset($_POST['post_rwdexport'][$blog_id]))&& 
			$this->process_post_rwdexport($blog_id);
		(isset($_POST['post_heightexport'][$blog_id]))&& 
			$this->process_post_heightexport($blog_id);
		(isset($_POST['post_widthexport'][$blog_id]))&& 
			$this->process_post_widthexport($blog_id);
		(isset($_POST['post_floatexport'][$blog_id]))&& 
			$this->process_post_floatexport($blog_id); 
		(isset($_POST['col_altrwdexport'][$blog_id]))&& 
			$this->process_col_altrwdexport($blog_id);
		} 
	#this needs to  be done after edit pages updating
	#timing here important also as the following two choices can be made an top should go first
	
	if (isset($_POST['blog_style_copy'])){#setup new master blog_style
		$blog_style_copy=$_POST['blog_style_copy'];#posted value created in function close styles
		foreach ($blog_style_copy as $copy=> $val){
			if (is_numeric($val)){  
			$replace_this=str_replace(array($tablename,'_'),'',$copy);
			
			$q="update $this->master_post_table t, $this->master_post_table r SET set t.time=".time().",
			t.blog_style=r.blog_style WHERE t.blog_table='$tablename' AND r.blog_table='$tablename' AND t.blog_order=$replace_this AND r.blog_order=$val";
			
			#$q="UPDATE $tablename t, $tablename r SET 
			#t.blog_style=r.blog_style WHERE t.blog_order=$replace_this AND r.blog_order=$val";
				$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);	//this is affecting only one tablename... intra...
			}
			
			}
		} 
	 //set default
	if (isset($_POST['delete_blog'][$tablename])){
		$this->delete_blog($tablename);
		$tidy=true;
		}
	#new system
	$where="WHERE blog_table='$tablename'";
	$this->count_blog=$count=$this->mysqlinst->count_field($this->master_post_table,'blog_order','',false,$where);
	$maxcount=$this->mysqlinst->get('fieldmax');
		for ($i=0;$i<=$maxcount+$this->insert_full;$i+=$this->insert_full){
			
			if (isset($_POST[$tablename.'_'.$i.'_blog_new'])){
				$tidy=true;
				$blogtype=$_POST[$tablename.'_'.$i.'_blog_new']; 
				  ($blogtype!=$this->choose_blog_type)&&$this->create_blog($tablename,$blogtype,$i,$this->insert_half);//this type appears by default so elimate the choice
				}
			if (isset($_POST[$tablename.'_'.$i.'_blog_new_add_second'])){
				$tidy=true;
				$blogtype=$_POST[$tablename.'_'.$i.'_blog_new_add_second']; 
				  ($blogtype!=$this->choose_blog_type)&&$this->create_blog($tablename,$blogtype,$i,($this->insert_half+1));//this type appears by default so elimate the choice
				}	
			}
	//$this->count_blog=$count=$this->mysqlinst->count_field($tablename,'blog_order','',false);
	//$maxcount=$this->mysqlinst->get('fieldmax');
	//set up text box as initial blog...
	if (empty($count)){}#$this->create_blog($tablename,$this->blog_drop_array[$this->text_box_index],0,$this->insert_full);
	## do not create a text field let user make own first choice less confusing
	else{ //always make last blog type a text option....
		$q="select blog_type, blog_text from ".$this->master_post_table." where blog_table='$tablename' AND blog_order='$maxcount'";
		$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
		list($type,$text)=$this->mysqlinst->fetch_row($r); 
		//if ($type!='text'||$text!=$this->default_blog_text)$this->create_blog($tablename,$this->blog_drop_array[$this->text_box_index],$maxcount,$this->insert_full);
		} 
	(isset($_POST['submitted'])&&$tidy)&&$this->blog_tidy($tablename);#time to clean them up!!
		 
	}#end function process_blog
	
function delete_blog($tablename){  
	if (isset($_POST['delete_blog'][$tablename])){
		$delete_arr=array();
		$q="select blog_data1,blog_id,blog_type,blog_order,blog_status from  $this->master_post_table  where blog_table='$tablename' order by blog_order";  
		$rdel=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
		while($rows=$this->mysqlinst->fetch_assoc($rdel,__LINE__)){
			$blog_order=$rows['blog_order'];  
			$blog_id=$rows['blog_id'];
			$blog_type=$rows['blog_type'];
			$blog_data1=$rows['blog_data1']; 
			$blog_status=$rows['blog_status'];
			#fine to do this befor edit pages_obj
			if (isset($_POST['delete_blog'][$tablename][$blog_order])){
				$msg=($blog_status=='clone')?'Your Cloned Post Has Been Deleted':'Your Post Has Been Deleted Id: P'.$blog_id; 
				$delete_arr[]=array($this->master_post_table,"where blog_id='$blog_id'",'message',$msg); 
				$delete_arr[]=array($this->master_post_css_table," where blog_id='$blog_id'",'message',"Blog id $blog_id Deleted from $this->master_post_css_table");
				$delete_arr[]=array($this->comment_table," where comment_blog_id='$blog_id'",'message',"Blog id $blog_id Deleted from $this->comment_table"); 
				 if ($blog_type=='gallery'){
					//$msg='Your Gallery Records Have Been Deleted for '.$blog_data1; 
					//$delete_arr[]=array($this->master_gall_table,"where gall_ref='$blog_data1'",'message',$msg); 
					}
				elseif ($blog_type=='navigation_menu'){
					$msg='Your Navigtation Records Have Been Deleted for Menu Id'.$blog_data1; 
					$delete_arr[]=array($this->directory_table,"where dir_menu_id='$blog_data1'",'message',$msg); 
					$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
					} 
				}// if POST
			}//end while
			foreach ($delete_arr as $delete){ 
				$this->delete($delete[0],$delete[1],$delete[2],$delete[3]);
				}
		}
	}//end delete_blog

function delete($tablename,$where,$typemsg,$msg){ 
	$q="delete from $tablename $where";
	$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	if ($this->mysqlinst->affected_rows()){
		$this->{$typemsg}[]=$msg;
		}
	}
					
		
function blog_new($data,$tablename,$blog_order, $msg='', $msg_open_prefix='Insert New After Post #', $msg_close_prefix='Insert <span class="purple">New</span> After Post #'){
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
                $insert=($max==$blog_order)?'To Add':'To Insert';
                }
        else $insert='';        
        $new_blog=$data.'_blog_new'; 
        $selected=$this->choose_blog_type;
        printer::pspace(5);
        //echo '<div class="inline center marginauto"><!--center wrap-->'; 

	 
	 $this->show_more($msg_open_prefix.$msg.' Col#'.$this->column_order_array[$this->column_level],$msg_close_prefix.$msg.' Col#'.$this->column_order_array[$this->column_level],'infoclick fsm'.$this->column_lev_color.' editbackground  rad10 editfont ','Click Here To Add New Posts/Column and For More info on making Choices',250);
	 
	echo '<div class="editbackground fsminfo editbackground"><!-- Add New Posts/Column wrap-->';
	$this->show_more('Info Post Choices','noback','info smaller','click for more info on post choices');   
	printer::alertx('<p class="width500 fsminfo editbackground '.$this->column_lev_color.' editfont left">Not only create Post content here such as Text, Images, a Navigation menu, or Social Icons etc.  andalso Create a Nested Column as well or copy clone move previous posts and columns of posts.  A nested Column is a Column within a column  used for organizing the posts (and other columns) that you create within it.  Please Review the discussion of this important topic in the Overview Section at the top of the Page!!</p>');
	$this->show_close('Info Post Choices');
	 
	forms::form_dropdown($this->blog_drop_array,false,'','',$new_blog,$selected,false,$this->column_lev_color );
	printer::pclear();
	$this->show_more('Additional new','','floatleft smallest info italic','Add an additional new post type here','asis');
	forms::form_dropdown($this->blog_drop_array,false,'','',$new_blog.'_add_second',$selected,false,$this->column_lev_color );
	$this->show_close('Additional new');
	
	echo '</div><!-- Add New Posts/Column wrap-->';
	  $this->show_close($msg);
	//echo '</div><!--center wrap-->';
	printer::pclear();
	printer::pspace(1);
	$this->submit_button();
	printer::pspace(20);
 
	}
#mg 
function create_master_gallery(){  
	if (!$this->edit&&!isset($_POST['create_master_gallery']))return;
	foreach($_POST['create_master_gallery'] as $gall_ref => $newgall_ref){ 
		$q="select blog_id,blog_tiny_data2 from $this->master_post_table where blog_data1='$gall_ref'"; 
		$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
		list($blog_id,$master_gall_status)=$this->mysqlinst->fetch_row($r); 
		if (!isset($_POST['master_title'][$gall_ref])||!isset($_POST['gallref_image_choice'][$gall_ref])){
			 $this->message[]="Choose both a gallery image to display for your new master gallery image link and a title for Gallery Link Reference in  post Id p$blog_id";
			}
		elseif (empty($_POST['create_master_gallery'][ $gall_ref ]||empty($_POST['gallref_image_choice'][ $gall_ref ]))||empty($_POST['master_title'][$gall_ref])){
			$this->message[]="Choose both a gallery image to display for your new master gallery image link and a title for Gallery Link Reference in post Id p$blog_id";
			}
		else{
			$image=$_POST['gallref_image_choice'][$gall_ref];
			$gall_title=$_POST['master_title'][$gall_ref];
			$gall_fields=Cfg::Gallery_fields;
			$gall_field_arr=explode(',',$gall_fields);
			$value='';
			$q="select gall_table from $this->master_gall_table where gall_ref='$newgall_ref' and master_gall_status !='master_gall' limit 1";
			 
			$gt=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
			list($gall_table)=$this->mysqlinst->fetch_row($gt);
			foreach ($gall_field_arr as $field) {
				if ($field==='master_gall_ref')$value.="'$newgall_ref',";
				elseif ($field==='master_table_ref')$value.="'$gall_table',";
				elseif($field==='master_gall_status')$value.="'master_gall',";
				elseif($field==='pic_order')$value.="'30000',";#will be renumbered
				elseif($field==='imagetitle')$value.="'$gall_title',";
				elseif($field==='subtitle')$value.="'',";
				elseif($field==='description')$value.="'',";
				elseif($field==='gall_ref')$value.="'$gall_ref',";//gall ref is trigger for deleting so is used to hold this master gall id  whereas master gall ref will hold particlar gall selection
				elseif($field==='gall_table')$value.="'$this->tablename',";
				elseif($field==='picname')$value.="'$image',";
				else $value.="'0',";
				}
			$this->mysqlinst->count_field($this->master_gall_table,'pic_id','',false,'');
			$inc_id=$this->mysqlinst->field_inc;
			
			$q="insert into $this->master_gall_table  (pic_id,$gall_fields,gall_update,gall_time,token) values ($inc_id,$value '".date("dMY-H-i-s")."','".time()."','".mt_rand(1,mt_getrandmax())."')";  
			$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
			if ($master_gall_status!=='master_gall'){
				$q="update $this->master_post_table set token='".mt_rand(1,mt_getrandmax()). "',blog_update='".date("dMY-H-i-s")."',blog_time='".time()."', blog_tiny_data2='master_gall' where blog_id='$blog_id'";
				$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
				}
			$this->success[]="A new master gallery has been created in  post Id p$blog_id";
			 $this->success[]="A new master gallery has been created in  post Id p$blog_id";
			}
		}
	}
	
function submit_button($value=''){ if(Sys::Custom)return;if  (Sys::Pass_class||Sys::Quietmode)return;
	(empty($value))&& $value='SUBMIT All';//:'SUBMIT ALL CHANGES';
	echo'  <p><input class="editbackground rad5 small cursor button'.$this->column_lev_color.' '.$this->column_lev_color.' mb10"   type="submit" name="submit"   value="'.$value.'" ></p>';
	  }

      
function process_post_configcopy($blog_id){
     $parent_id=$_POST['post_configcopy'][$blog_id];
          if (strtolower(substr(trim($parent_id),0,1))!=='p'){
			$this->message[]='Post IDs Are FOUND AT THE TOP OF Each Post ie. The Number having the ID: P1, P2, etc. FORMAT. BE SURE TO INCLUDE THE P PREFIX ';
			return;
			}
     $fields='blog_float, blog_data2,blog_data3,blog_data4,blog_data5,blog_data6,blog_data7,blog_tiny_data1,blog_tiny_data2,blog_tiny_data3,blog_tiny_data4,blog_tiny_data5,blog_tiny_data6,blog_tiny_data7,blog_tiny_data8,blog_tiny_data9,blog_tiny_data10,blog_data2,blog_data3,blog_data4,blog_data5,blog_data6,blog_data7,blog_data8,blog_data9,blog_data10,blog_tiny_data1,blog_tiny_data2,blog_tiny_data3,blog_options,blog_style';
		$field_arr=explode(',',$fields);
		$parent_id=str_replace(array('p','P'),'',$parent_id);   
		$q="update $this->master_post_table t, $this->master_post_table r SET ";
		foreach($field_arr as $field){
			   $q.="t.$field=r.$field,";
			   }
		$q="$q t.token='".mt_rand(1,mt_getrandmax()). "',t.blog_update='".date("dMY-H-i-s")."',t.blog_time='".time()."' where  t.blog_type=r.blog_type and t.blog_id=$blog_id and r.blog_id=$parent_id";
		
		$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
		if ($this->mysqlinst->affected_rows()){
			   $this->success[]="Post p$blog_id was updated using styles and configs from Post p$parent_id";
			   }
		else $this->message[]="Mismatch updating Post p$blog_id with Post p$parent_id"; 
          
     }
	  
#############################################Columuns
function process_col_configexport($col_id){
     $parent_id=$_POST['col_configexport'][$col_id]; 
	$fields='col_float,col_data2,col_data3,col_data4,col_data5,col_data6,col_data7,col_tiny_data1,col_tiny_data2,col_tiny_data3,col_tiny_data4,col_tiny_data5,col_tiny_data6,col_tiny_data7,col_tiny_data8,col_tiny_data9,col_tiny_data10,col_data2,col_data3,col_data4,col_data5,col_data6,col_data7,col_data8,col_data9,col_data10,col_tiny_data1,col_tiny_data2,col_tiny_data3,col_options,col_style';
	$field_arr=explode(',',$fields); 	
	$q="update $this->master_col_table t, $this->master_col_table r, $this->master_post_table  pt, $this->master_post_table  pr  SET ";
	foreach($field_arr as $field){
		$q.="t.$field=r.$field,";
		}
	$q="$q t.token='".mt_rand(1,mt_getrandmax()). "',t.col_update='".date("dMY-H-i-s")."',t.col_time='".time()."' where  r.col_id=$col_id and pt.blog_data1=t.col_id and pr.blog_data1= r.col_id and pt.blog_col=pr.blog_col";
	
	$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	if ($this->mysqlinst->affected_rows()){
		$this->success[]="col p$col_id configs  and styles were exported to the same col types in this column";
		}
	else $this->message[]="No cols configs  and styles were exported using col id P$col_id";	
		 
	}

function process_import($port){
	$page_opts='';
	switch ($port){
		case 'page_style' :
			$fields='page_style';
			break;
		case 'page_editor_color' :
			$fields='page_dark_editor_value,page_light_editor_value,page_dark_editor_order,page_light_editor_order';
			$page_opts='page_editor_choice,page_darkeditor_background,page_darkeditor_color,page_lighteditor_background,page_lighteditor_color';
			break;
		case 'page_special_class' :
			$fields='page_hr,page_h1,page_h2,page_h3,page_h4,page_h5,page_h6,page_myclass1,page_myclass2,page_myclass3,page_myclass4,page_myclass5,page_myclass6,page_myclass7,page_myclass8,page_myclass9,page_myclass10,page_myclass11,page_myclass12';
			break;
		case 'page_width' :
			$fields='page_width';
			break;
		case 'page_rwd' :
			$fields='page_break_points';
			break;
		case 'page_cache' :
			$fields='page_cache';
		default :
			return;
		}
	############################
	$parent_ref=$_POST[$port.'_import'];
	$value=''; 
	$q="update $this->master_page_table c, $this->master_page_table p SET ";
	foreach (explode(',',$fields) as $field){
		$value.="c.$field = p.$field, ";
		}
	$q.=" $value c.page_update='".date("dMY-H-i-s")."', c.page_time='".time()."',c.token='".mt_rand(1,mt_getrandmax()). "' where c.page_ref='$this->tablename' and p.page_ref='$parent_ref'";
	$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	if ($this->mysqlinst->affected_rows()){
		$this->success[]="Page Configs  were imported";
		}
	else $this->message[]="No Page Configs were affected with $q";
	if (!empty($page_opts)){
		$q="select page_options,page_id,page_ref from $this->master_page_table where page_ref='$parent_ref' limit 1";  
		$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);    
		list($page_options,$page_id,$page_ref)=$this->mysqlinst->fetch_row($r,__LINE__); 
		$mcount=count($this->page_options);
		$opt_array=explode(',',$page_options);
		$count=count($opt_array);
		if ($count < $mcount){
			for ($i=0; $i<$mcount; $i++){
				(!array_key_exists($i,$opt_array))&&$opt_array[$i]=0;
				}
			}
		foreach (explode(',',$page_opts) as $poption){
			$this->page_options[$this->{$poption.'_index'}]=$page_options[$this->{$poption.'_index'}];
			}
		$implode_opts=implode(',',$this->page_options);
		$q="update $this->master_page_table set page_options='$implode_opts' where page_ref='$this->tablename'";
		$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
		if ($this->mysqlinst->affected_rows()){
			$this->success[]="More Page Configs  were imported";
			}
		else $this->message[]="No Page Configs were affected with $q"; 
			 
		}//end if 
	}

function process_export($port){
	$page_opts='';
	switch ($port){
		case 'page_style' :
			$fields='page_style';
			break;
		case 'page_editor_color' :
			$fields='page_dark_editor_value,page_light_editor_value,page_dark_editor_order,page_light_editor_order';
			$page_opts='page_editor_choice,page_darkeditor_background,page_darkeditor_color,page_lighteditor_background,page_lighteditor_color';
			break;
		case 'page_special_class' :
			$fields='page_hr,page_h1,page_h2,page_h3,page_h4,page_h5,page_h6,page_myclass1,page_myclass2,page_myclass3,page_myclass4,page_myclass5,page_myclass6,page_myclass7,page_myclass8,page_myclass9,page_myclass10,page_myclass11,page_myclass12';
			break;
		case 'page_width' :
			$fields='page_width';
			break;
		case 'page_rwd' :
			$fields='page_break_points';
			break;
		case 'page_cache' :
			$fields='page_cache';
			break;
		case 'page_quality' :
			$fields='page_pic_quality';
			break;
		case 'page_cache' :
			$page_opts='page_backup_copies';
			break;
		default :
			return;
		}
	############################ 
	$value='';
	$q="update $this->master_page_table c, $this->master_page_table p   SET ";
	foreach (explode(',',$fields) as $field){
		$value.="c.$field = p.$field, ";
		}
	
	$q.=" $value c.page_update='".date("dMY-H-i-s")."', c.page_time='".time()."',c.token='".mt_rand(1,mt_getrandmax()). "' where  p.page_ref='$this->tablename'";
	$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	if ($this->mysqlinst->affected_rows()){
		$this->success[]="Page Configs  were imported";
		}
	else $this->message[]="No Page Configs were affected with $q";
	######################################
	if (!empty($page_opts)){
		$q="select page_options,page_id,page_ref from $this->master_page_table";  
		$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);    
		while (list($page_options,$page_id,$page_ref)=$this->mysqlinst->fetch_row($r,__LINE__)){
			if ($page_ref===$this->tablename)continue;
			$mcount=count($this->page_options);
			$opt_array=explode(',',$page_options);
			$count=count($opt_array);
			if ($count < $mcount){
				for ($i=0; $i<$mcount; $i++){
					(!array_key_exists($i,$opt_array))&&$opt_array[$i]=0;
					}
				}
			foreach (explode(',',$page_opts) as $poption){
				$opt_array[$this->{$poption.'_index'}]=$this->page_options[$this->{$poption.'_index'}];
				}
			$implode_opts=implode(',',$opt_array);
			$q="update $this->master_page_table set page_options='$implode_opts' where page_id='$page_id'";
			$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
			if ($this->mysqlinst->affected_rows()){
				$this->success[]="More Page Configs  were exported";
				}
			else $this->message[]="No Page Configs were affected with $q"; 
			 
			}//end while
		}//end if 
	}
	
function process_col_rwdexport($col_id){ 
	$q="update $this->master_col_table t, $this->master_col_table r, $this->master_post_table  pt, $this->master_post_table  pr  SET t.col_gridspace_right=r.col_gridspace_right,t.col_gridspace_left=r.col_gridspace_left,t.col_grid_width=r.col_grid_width, t.token='".mt_rand(1,mt_getrandmax()). "',t.col_update='".date("dMY-H-i-s")."',t.col_time='".time()."' where  t.col_primary!=1 and r.col_primary!=1 and r.col_id=$col_id and  pt.blog_data1=t.col_id and pr.blog_data1= r.col_id and pt.blog_col=pr.blog_col"; // bt.blog_col and br.blog_col refer to the parent col ids being a match... 
	$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	if ($this->mysqlinst->affected_rows()){
		$this->success[]="col p$col_id RWD Grid settings were exported to Nested column col types in this column";
		}
	else $this->message[]="No cols were affected for RWD Grid settings update using $q in col id P$col_id"; 
	}	
function process_col_altrwdexport($blog_id){ 
	$q="update $this->master_post_table t, $this->master_post_table r  SET t.blog_alt_rwd=r.blog_alt_rwd, t.token='".mt_rand(1,mt_getrandmax()). "',t.blog_update='".date("dMY-H-i-s")."',t.blog_time='".time()."' where  r.blog_id=$blog_id and t.blog_type='nested_column'  and r.blog_type='nested_column'  and t.blog_col=r.blog_col";  
	
	$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	if ($this->mysqlinst->affected_rows()){
		$this->success[]="col Alternative-RWD settings were exported to nested column col types in same parent column";
		}
	else $this->message[]="No cols were affected for Alternative-RWD settings update using $q "; 
	}
######################################End columns

	
function process_post_configexport($blog_id){
     $parent_id=$_POST['post_configcopy'][$blog_id]; 
	$fields='blog_float,blog_data2,blog_data3,blog_data4,blog_data5,blog_data6,blog_data7,blog_tiny_data1,blog_tiny_data2,blog_tiny_data3,blog_tiny_data4,blog_tiny_data5,blog_tiny_data6,blog_tiny_data7,blog_tiny_data8,blog_tiny_data9,blog_tiny_data10,blog_data2,blog_data3,blog_data4,blog_data5,blog_data6,blog_data7,blog_data8,blog_data9,blog_data10,blog_tiny_data1,blog_tiny_data2,blog_tiny_data3,blog_options,blog_style';
	$field_arr=explode(',',$fields); 	
	$q="update $this->master_post_table t, $this->master_post_table r SET ";
	foreach($field_arr as $field){
		$q.="t.$field=r.$field,";
		}
	$q="$q t.token='".mt_rand(1,mt_getrandmax()). "',t.blog_update='".date("dMY-H-i-s")."',t.blog_time='".time()."' where  t.blog_type=r.blog_type and r.blog_id=$blog_id and t.blog_table=r.blog_table";
	
	$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	if ($this->mysqlinst->affected_rows()){
		$this->success[]="Post p$blog_id configs  and styles were exported to the same post types in this column";
		}
	else $this->message[]="No Posts configs  and styles were exported using post id P$blog_id";	
		 
	}
function process_post_rwdexport($blog_id){ 
	$q="update $this->master_post_table t, $this->master_post_table r SET t.blog_gridspace_right=r.blog_gridspace_right,t.blog_gridspace_left=r.blog_gridspace_left,t.blog_grid_width=r.blog_grid_width, t.token='".mt_rand(1,mt_getrandmax()). "',t.blog_update='".date("dMY-H-i-s")."',t.blog_time='".time()."' where  t.blog_type!='nested_column' and r.blog_id=$blog_id and t.blog_table=r.blog_table";
	
	$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	if ($this->mysqlinst->affected_rows()){
		$this->success[]="Post p$blog_id RWD Grid settings were exported to  non nested column post types in this column";
		}
	else $this->message[]="No Posts were affected for RWD Grid settings update using $q in post id P$blog_id";
	if (isset($_POST['post_col_rwdexport'])){
		$q="update $this->master_col_table t, $this->master_post_table r, $this->master_post_table pt SET t.col_gridspace_right=r.blog_gridspace_right,t.col_gridspace_left=r.blog_gridspace_left,t.col_grid_width=r.blog_grid_width, t.token='".mt_rand(1,mt_getrandmax()). "',t.col_update='".date("dMY-H-i-s")."',t.col_time='".time()."' where  r.blog_id=$blog_id and pt.blog_data1=t.col_id and  pt.blog_col=r.blog_col"; // 
	
		$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
		if ($this->mysqlinst->affected_rows()){
			$this->success[]="Post p$blog_id RWD Grid settings were exported to  non nested column post types in this column";
			}
		else $this->message[]="No Posts were affected for RWD Grid settings update using $q in post id P$blog_id";
		}
	}
function process_post_altrwdexport($blog_id){ 
	$q="update $this->master_post_table t, $this->master_post_table r SET t.blog_alt_rwd=r.blog_alt_rwd,
	 t.token='".mt_rand(1,mt_getrandmax()). "',t.blog_update='".date("dMY-H-i-s")."',t.blog_time='".time()."' where  t.blog_type!='nested_column' and r.blog_id=$blog_id and t.blog_table=r.blog_table";
	
	$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	if ($this->mysqlinst->affected_rows()){
		$this->success[]="Post p$blog_id Alternative-RWD settings were exported to  non nested column post types in this column";
		}
	else $this->message[]="No Posts were affected for Alternative-RWD settings update using $q in post id P$blog_id";
	if (isset($_POST['post_col_altrwdexport'])){
		$q="update $this->master_post_table t, $this->master_post_table r  SET t.blog_alt_rwd=r.blog_alt_rwd, t.token='".mt_rand(1,mt_getrandmax()). "',t.blog_update='".date("dMY-H-i-s")."',t.blog_time='".time()."' where  r.blog_id=$blog_id and t.blog_type='nested column' and t.blog_col=r.blog_col";   
	
		$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
		if ($this->mysqlinst->affected_rows()){
			$this->success[]="Post p$blog_id Alternative RWD  settings were exported to  Nested column post types in this column";
			}
		else $this->message[]="No Posts were affected for Alternative RWD settings update using $q in post id P$blog_id";
		}
	}	
function process_post_heightexport($blog_id){ 
	$q="update $this->master_post_table t, $this->master_post_table r SET t.blog_height=r.blog_height,
	 t.token='".mt_rand(1,mt_getrandmax()). "',t.blog_update='".date("dMY-H-i-s")."',t.blog_time='".time()."' where  t.blog_type!='nested_column' and r.blog_id=$blog_id and t.blog_table=r.blog_table";
	
	$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	if ($this->mysqlinst->affected_rows()){
		$this->success[]="Post p$blog_id height setting was exported to  non nested column post types in this column";
		}
	else $this->message[]="No Posts were affected for height update using using post id P$blog_id";
		 
	}
function process_post_floatexport($blog_id){
	$q="update $this->master_post_table t, $this->master_post_table r SET t.blog_float=r.blog_float,
	 t.token='".mt_rand(1,mt_getrandmax()). "',t.blog_update='".date("dMY-H-i-s")."',t.blog_time='".time()."' where  t.blog_type!='nested_column' and r.blog_id=$blog_id and t.blog_table=r.blog_table";
	
	$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	if ($this->mysqlinst->affected_rows()){
		$this->success[]="Post p$blog_id float setting was exported to  non nested column post types in this column";
		}
	else $this->message[]="No Posts were affected for float update using using post id P$blog_id";
		 
		 
	} 	
function process_post_widthexport($blog_id){ 
	$q="update $this->master_post_table t, $this->master_post_table r SET t.blog_width=r.blog_width,
	 t.token='".mt_rand(1,mt_getrandmax()). "',t.blog_update='".date("dMY-H-i-s")."',t.blog_time='".time()."' where  t.blog_type!='nested_column' and r.blog_id=$blog_id and t.blog_table=r.blog_table";
	
	$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	if ($this->mysqlinst->affected_rows()){
		$this->success[]="Post p$blog_id width setting was exported to  non nested column post types in this column";
		}
	else $this->message[]="No Posts were affected for width update using using post id P$blog_id";
	 
	} 			 
function process_col_transfer_clone(){
	foreach($_POST['col_transfer_clone'] as $parent_id => $child_id){
		if (strtolower(substr(trim($child_id),0,1))!=='c'){
			$this->message[]='col IDs Are FOUND AT THE TOP OF Each col ie. The Number having the ID: C1, C2, etc. FORMAT. BE SURE TO INCLUDE THE C PREFIX ';
			return;
			}
		$child_id=str_replace(array('c','C'),'',$child_id);
		$q="select col_table_base from $this->master_col_table where col_id='$child_id'";
		$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
		if ($this->mysqlinst->affected_rows()){
			list($table_base)=$this->mysqlinst->fetch_row($r);
			}
		else {
			$this->message[]="col table base not ffound with $q";
			return;
			}
		$q="update $this->master_col_table set col_clone_target='$child_id',col_clone_target_base='$table_base' where col_status='clone' and col_clone_target='$parent_id'";
		$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
		if ($this->mysqlinst->affected_rows()){
			$this->success[]="col clone tranfer has occurred tranfering clones of C$parent_id Id to C$child_id";
			}
		else $this->inform[]="No Primary column Column Transfers were made using $q";
		$q="update $this->master_post_table set blog_data1='$child_id',blog_clone_target_base='$table_base' where blog_status='clone' and blog_data1='$parent_id'";
		$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
		if ($this->mysqlinst->affected_rows()){
			$this->success[]="Nested col clone tranfer has occurred tranfering clones of C$parent_id Id to C$child_id";
			}
		else $this->inform[]="No Nested column Column Transfers were made using $q";
		}//end foreach
	}
	
function process_col_configcopy($col_id){
	$parent_id=$_POST['col_configcopy'][$col_id];
	if (strtolower(substr(trim($parent_id),0,1))!=='c'){
		$this->message[]='col IDs Are FOUND AT THE TOP OF Each col ie. The Number having the ID: C1, C2, etc. FORMAT. BE SURE TO INCLUDE THE C PREFIX ';
		return;
		}
	$fields='col_options,col_status,col_grid_width,col_grid_clone,col_gridspace_right,col_gridspace_left,col_primary,col_clone_target,col_clone_target_base,col_style,col_grp_bor_style,col_comment_style,col_comment_date_style,col_comment_view_style,col_date_style,col_width';	
		
	$field_arr=explode(',',$fields);
	$parent_id=str_replace(array('c','C'),'',$parent_id);	
	$q="update $this->master_col_table t, $this->master_col_table r SET ";
	foreach($field_arr as $field){
		$q.="t.$field=r.$field,";
		}
	$q="$q t.token='".mt_rand(1,mt_getrandmax()). "',t.col_update='".date("dMY-H-i-s")."',t.col_time='".time()."' where  t.col_id=$col_id and r.col_id=$parent_id"; 
	$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	if ($this->mysqlinst->affected_rows()){
		$this->success[]="col c$col_id was updated using styles and configs from col c$parent_id";
		}
	else $this->message[]="Mismatch updating col c$col_id with col c$parent_id";	
		 
			
	}
function process_blog_border($data,$tablename,$blog_order){
	if (Sys::Methods){Sys::Debug(__LINE__,__FILE__,__METHOD__);}
	 if (isset($_POST['blog_border_start_remove'][$data])){ 
		$q="update $this->master_post_table set blog_time=".time().",token='".mt_rand(1,mt_getrandmax()). "', blog_border_start=0  where blog_table='$tablename' AND blog_order=$blog_order";  
		$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
		}
	 if (isset($_POST['blog_border_stop_remove'][$data])){ // echo NL. $data.'am here  breaking bud';
		$q="update $this->master_post_table  set blog_time=".time().",token='".mt_rand(1,mt_getrandmax()). "', blog_border_stop=0 where blog_table='$tablename' AND blog_order=$blog_order";  
		$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
		}
	 
	}
function delete_nav_menu(){
	$q3="select distinct dir_menu_id from $this->directory_table"; 
	$r3=$this->mysqlinst->query($q3,__METHOD__,__LINE__,__FILE__,false);
	if ($this->mysqlinst->affected_rows()){ 
		while (list($dir_menu_id)=$this->mysqlinst->fetch_row($r3)){  
			if (isset($_POST['delete_nav_menu'][$dir_menu_id])){
				$q="delete from $this->directory_table where dir_menu_id='$dir_menu_id'"; 
				$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
				if ($this->mysqlinst->affected_rows()){
					$msg='Your Navigtation Records Have Been Deleted for Menu Id'.$dir_menu_id; 
					$this->success[]=$msg;
					}
				else {
					$msg='Problem Deleting Your Navigtation Records for Menu Id'.$dir_menu_id; 
					$this->message[]=$msg;
					} 
				}
			}//while
		}//if rows
	else $this->message[]="No delete Menu Ids Affected";
	}//del nav menu
	
function check_delete_col(){
	if(!isset($_POST['deletecolumn']))return;
	$q="select col_table,col_id,col_status from $this->master_col_table where col_table_base='$this->tablename'";
	$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	while(list($col_table,$col_id,$col_status)=$this->mysqlinst->fetch_row($r,__LINE__)){
		if(isset($_POST['deletecolumn'][$col_table])&&$_POST['deletecolumn'][$col_table]=='delete'){
			$status=($col_status=='clone')?true:false; 
			$this->delete_col($col_id,$status);
			//$this->message[]='Cloned Column Id'.$col_id.' has Successfully Been Deleted';
			}
		}
	$this->primary_order_update();
	}
	
	
function process_new_blog_table(){ //creates new primary ppCol and also orders col_num for primaries  
	//$column_choice=(isset($_POST['copynewcolumn']))?"'column_choice'":'';
	//$post_merge=array_merge 
	$max1=(isset($_POST['copynewcolumn']))?max(array_keys($_POST['copynewcolumn'])):0;
	$max2=(isset($_POST['addnewcolumn']))?max(array_keys($_POST['addnewcolumn'])):0; 
	$max=max($max1,$max2);
	$q="update $this->master_col_table set col_time='".time()."', token='".mt_rand(1,mt_getrandmax())."',col_tcol_num=col_num";
	$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	$col_fields_all=Cfg::Col_fields_all;
	$col_field_arr_all=explode(',',$col_fields_all);
	for ($i=0; $i<$max+1; $i++){
		if (isset($_POST['copynewcolumn'][$i])){
			$tablenum=$_POST['copynewcolumn'][$i];
			$column_choice='column_choice';
			$this->success[]="Primary Column to Clone/Copy/Move has been Created"; 
			}
		elseif (isset($_POST['addnewcolumn'][$i])){
			$tablenum=$_POST['addnewcolumn'][$i];
			$column_choice='';
			$this->success[]="Primary Column to Begin has been Created";
			}
		
		else continue;
		
	
	$values=''; 
	foreach ($this->col_field_arr_all as $field) {
		$$field=0;
		}
	
	$col_primary=1;
	$col_table_base=$this->tablename;
	$col_tcol_num=$tablenum;
	$col_temp=$column_choice;
	$col_update=date("dMY-H-i-s");
	$col_time=time();
	$token=mt_rand(1,mt_getrandmax());
	
	foreach ($col_field_arr_all as $field) {
		$values.="'".$$field."', ";
		}
	$values=substr_replace($values,'',-2);
	 $q="insert into $this->master_col_table ($col_fields_all)  values ($values)";   
		$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true); 
		$this->mysqlinst->count_field($this->master_col_table,'col_id','',false,'');  
		$col_id=$this->mysqlinst->fieldmax;
		$q="update $this->master_col_table set col_table='{$this->tablename}_post_id$col_id' where col_id='$col_id'"; 
		$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
		}
	 $this->primary_order_update(false);
	}
	
function primary_order_update($update=true){
	if ($update){
		$q="update $this->master_col_table set token='".mt_rand(1,mt_getrandmax())."',col_tcol_num=col_num";
		$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
		}
	$order=0;
	$q="select col_id,col_tcol_num  from $this->master_col_table where col_table_base='$this->tablename' and col_primary=1 order by col_tcol_num"; 
	$r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	if ($this->mysqlinst->affected_rows()){
		while (list($col_id,$pptcol)=$this->mysqlinst->fetch_row($r,__LINE__)){
			$order++;
			$q2="UPDATE  $this->master_col_table set col_num=$order, token='".mt_rand(1,mt_getrandmax())."' where col_id=$col_id";   
			$this->mysqlinst->query($q2,__METHOD__,__LINE__,__FILE__,true);
			}
		}
	}
	
function process_blog_input($data,$tablename,$blog_order){
	if (Sys::Methods){Sys::Debug(__LINE__,__FILE__,__METHOD__);}
	if (!isset($_POST['blog_input'][$data]))return;// echo NL. $data.'am here  breaking bud';
	$key=key($_POST['blog_input'][$data]);
	$val=$_POST['blog_input'][$data][$key];
	$q="update $this->master_post_table  set blog_time=".time().",token='".mt_rand(1,mt_getrandmax()). "', $key='$val' where blog_table='$tablename' AND blog_order=$blog_order";   
	$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	}

	
function remove_unclone($type){
	foreach($_POST['remove_unclone_'.$type] as $id){
		 if ($type=='post'){
			$q="delete from $this->master_post_table where blog_id='$id' and blog_table_base='$this->tablename'";
			$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
			$this->message[]='Post Id: P'.$id.' has been Deleted';
			}
		else {
			$q="select blog_data1,blog_status from $this->master_post_table where  blog_data1='$id' and blog_unstatus='unclone' and blog_type='nested_column'"; 
			$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
			if ($this->mysqlinst->affected_rows()){
				list($col_id,$status)=$this->mysqlinst->fetch_row($r,__LINE__);
				if ($status!=='clone'){
					$this->delete_col($col_id);
					}
				else {
					$q="delete from $this->master_post_table where blog_data1='$id' and blog_table_base='$this->tablename'";
					$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
					}//this post will be deleted when column is deleted 
				}	
			}//else 
	
		}//foreach
	}	
function create_unclone_fresh(){ 
	foreach ($_POST['create_unclone'] as $blog_id => $arr){
		$parent_tableID=key($arr);
		$switch=$arr[$parent_tableID];
		if ($switch==$this->choose_blog_type)continue;
		//if (!isset($_POST['unclone_option_fresh'][$blog_id])){ 
			//$msg='No Changes made: To make the change also check the UnClone Refresh Option checkbox For a New Post Here for post Id: P'. $blog_id;
			//$this->message[]=$msg;
			//continue;
			//}
		if (isset($_POST['unclone_option_copy'][$blog_id])){ 
			$msg='You have choosen both UnClone Clone and a Mirror release Fresh Dropdown  Option  for post Id: P'. $blog_id. ': Choose Only One';
			$this->message[]=$msg;  
			continue;
			} 
		$tablename='uncle_'.$this->tablename.'_id'.$blog_id;
		$count=$this->mysqlinst->count_field($this->master_post_table,'blog_order','',false, " where blog_table='$tablename'");
		if ($count>1) {
			$q="delete from $this->master_post_table where blog_table='$tablename'";
			$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
			}
		$q="select blog_width,blog_float from $this->master_post_table where blog_id='$blog_id'";
		$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
		list ($blog_width,$blog_float)=$this->mysqlinst->fetch_row($r,__LINE__,__method__); 
		$this->create_blog($tablename,$switch,'10',$this->insert_half,$blog_id,'unclone',$blog_width,$blog_float,$parent_tableID);
		$this->success[]="You Have Created a New Mirror release $switch";
		}
	}
	
function create_unclone_copy(){  //unclone operation copying 
	$post_fields=Cfg::Post_fields;
	$post_field_arr=explode(',',$post_fields);
	$col_fields=Cfg::Col_fields;
	foreach ($_POST['unclone_option_copy'] as $blog_id => $value){
		 if ((isset($_POST['create_unclone'][$blog_id])&&$_POST['create_unclone'][$blog_id]!=$this->choose_blog_type)){
			$msg='You have choosen to both Mirror release and Copy and also to Mirror release and Start a Fresh Post so Please Choose Only One Option';
			$this->message[]=$msg;  
			continue;
			}
		$parent_id=$_POST['unclone_option_copy'][$blog_id];
			
		 
		$tablename='uncle_'.$this->tablename.'_id'.$blog_id;  
		$count=$this->mysqlinst->count_field($this->master_post_table,'blog_order','',false, " where blog_table='$tablename'");
		if ($count>0) {//leftover   delete and start fresh
			$q="delete from $this->master_post_table where blog_table='$tablename'";
			$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
			} 
		$q="select blog_id,$post_fields from $this->master_post_table where blog_id=$blog_id";   
		$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
		if (!$this->mysqlinst->affected_rows()){
			$this->message[]='Error Copy Mirror release PostID'.$blog_id;
			return;
			}
		$row1= $this->mysqlinst->fetch_assoc($r,__LINE__); 
			$value='';  
			foreach ($post_field_arr as $field) {
				if($field=='blog_table_base')$value.="'$this->tablename',";
				elseif($field=='blog_table')$value.="'$tablename',";
				elseif($field=='blog_col')$value.="'0',";
				elseif($field=='blog_clone_target')$value.="'',";//clear off instead ".$row1['blog_id']."',";
				elseif($field=='blog_status')$value.="'unclone',";
				elseif($field=='blog_order')$value.="'10',";
				elseif($field=='blog_unstatus')$value.="'unclone',";
				elseif($field=='blog_unclone')$value.="'$blog_id',";
				elseif($field=='blog_data6')$value.="'$parent_id',";
				else $value.="'$row1[$field]',";
				}
		 
		$q="insert into $this->master_post_table  ($post_fields,blog_update,blog_time,token) values ($value '".date("dMY-H-i-s")."','".time()."','".mt_rand(1,mt_getrandmax())."')";   
		$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
		$this->mysqlinst->count_field($this->master_post_table,'blog_id','',false,'');  
		$blog_id=$this->mysqlinst->fieldmax;
		
		if  ($row1['blog_type']=='nested_column'&&is_numeric($row1['blog_data1'])){
			$q="select $col_fields from $this->master_col_table where col_id=".$row1['blog_data1'];   
			$r3=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
			$row2 = $this->mysqlinst->fetch_assoc($r3,__LINE__); 
			$value='';
			foreach ($this->col_field_arr as $field) {
				if($field=='col_table_base')$value.="'$this->tablename',";
				elseif($field=='col_table')$value.="'',";
				elseif($field=='col_num')$value.="0,";  
				elseif($field=='col_status')$value.="'unclone',";
				elseif($field=='col_clone_target')$value.="'".$row1['blog_data1']."',";
				elseif($field=='col_clone_target_base')$value.="'".$row2['col_table_base']."',";
					
				//elseif($field=='col_fol_style'&&$status!=='move'){
				//if ($status=='copy'||$status=='follow_data')$value.="'',";
				//else $value.="'1',";
				//}
				//elseif($field=='col_fol_data'&&$status!=='move'){
				//if ($status=='copy'||$status=='follow_style')$value.="'',";
				//else $value.="'1',";
				//}
				elseif($field=='col_status')$value.="'copy',";
				else $value.="'".$row2[$field]."',"; 
				}   
			
			$q="insert into $this->master_col_table ($col_fields,col_update,col_time,token) values ( $value '".date("dMY-H-i-s")."','".time()."','".mt_rand(1,mt_getrandmax())."')";    
			$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
			$this->mysqlinst->count_field($this->master_col_table,'col_id','',false,'');  
			$col_id=$this->mysqlinst->fieldmax;
			$q="update $this->master_col_table set col_table='{$this->tablename}_post_id$col_id' where col_id='$col_id'"; 
			$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
			$q="update $this->master_post_table set token='".mt_rand(1,mt_getrandmax()). "',blog_data1='$col_id',blog_data2='{$this->tablename}_post_id$col_id' where blog_id=$blog_id";   
			$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
			$this->copy_col($col_id,$row1['blog_data1'],'copy',false);
			}
		$this->success[]="You Have Created a New Mirror release Post";
		}
	}
	
//$this->create_blog($tablename,$switch,'10',$this->insert_half,$blog_id,'unclone',$blog_width,$blog_float,$parent_tableID);	
function create_blog($tablename,$switch,$blog_order,$insert_amt,$blog_unclone='',$blog_unstatus='',$blog_width='',$blog_float='center row',$blog_data6=''){
 #get the processed blog updated style
	
	$bigtext='In Edit mode click the image to upload a new one. "Well, in our country," said Alice, still panting a little, "you&#39;d generally get to somewhere else—if you run very fast for a long time, as we&#39;ve been doing."<br><br>

"A slow sort of country!" said the Queen. "Now, here, you see, it takes all the running you can do, to keep in the same place. If you want to get somewhere else, you must run at least twice as fast as that!"--everything seemed to have changed since her swim in the pool, and the great hall, with the glass table and the little door, had vanished completely. '; 
	$default_video='';
	$blog_data1='';
	$blog_data2='';
	$blog_data3=''; 
	$blog_data4='';
	$blog_tiny_data1='';
	$blog_tiny_data2='';
	$blog_style='';
	$blog_text='';
	$blog_clone_table='';
	$jpg='';
	$blog_pub=0;
	if($blog_unstatus!='unclone'){
		$blog_order+=$insert_amt; 
		$q="select col_id from $this->master_col_table where col_table='$tablename' Limit 1";
		$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
		list($col_id)=$this->mysqlinst->fetch_row($r,__LINE__);
		}
	else { 
		$col_id="0";
		}
	switch ($switch) {
	case $this->blog_drop_array[11]:  #copy clone post
		$blog_data2='post_choice';
		$blog_type='choose_post'; 
		$blog_pub=1;   
		break;
	case $this->blog_drop_array[12]: #copy clone column
		$blog_data2='column_choice';
		$blog_type='nested_column';
		$blog_pub=1;
		break;
	case	$this->blog_drop_array[0]:#nested column
		//$this->column_new_array[]=$col_id;
		//$this->mysqlinst->count_field($this->master_col_table,'col_num','',false,'');
		$col_width=(!empty($blog_width))?$blog_width:'';//blog width is updated in funct col_data and $blog_width is copied for intitialize unclone for position consistency of unclone columns and posts!!
		###################
	
	$col_fields=Cfg::Col_fields; 
	$col_field_arr=explode(',',$col_fields);
	$value='';
	foreach ($col_field_arr as $field) {
			if($field=='col_table_base')$value.="'$this->tablename',";
			elseif($field=='col_options')$value.="'',";//adjusted subsequent 
			elseif($field=='col_num')$value.="0,";
			elseif($field=='col_status')$value.="'$blog_unstatus',";
			elseif($field=='col_primary')$value.="'0',";
			elseif($field=='col_width')$value.="'$col_width',";  
			elseif($field=='col_tcol_num')$value.="'0',";
			else $value.="'',"; 
			}    
		$q="insert into $this->master_col_table ($col_fields,col_update,col_time,token) values ($value '".date("dMY-H-i-s")."','".time()."','".mt_rand(1,mt_getrandmax())."')";  
		$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
		$this->mysqlinst->count_field($this->master_col_table,'col_id','',false,'');  
		$new_col_id=$this->mysqlinst->fieldmax;
		$q="update $this->master_col_table set col_table='{$this->tablename}_post_id$new_col_id' where col_id='$new_col_id'"; 
		$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
		$blog_text='Nested Column';
		$blog_type='nested_column';
		$blog_pub=1;//set nested column publish true by default
		$blog_data1=$new_col_id;
		//$blog_data2=$this->tablename.Cfg::Post_suffix.$col_id;
		$blog_style='';//'0,20,20';
		$this->column_new=$col_id;//used in alerting for new column!
		break;
	case $this->blog_drop_array[1]:#   'New Text Editor Box',
		$blog_text=$this->default_blog_text;
		$blog_type='text';
		$blog_style=',,,,,,,,,,,,left';//'0,20,20';
		break;	
	case $this->blog_drop_array[2]:#new image
		$blog_text='image';
		$blog_data1='default.jpg';
		$blog_type='image';
		$blog_style='';//'0,20,20';
		break;  
	case $this->blog_drop_array[3]:#'New Left Image Right Side Text',
		$blog_text='Add your new text here. View the web page changes to see what image on left of text looks like.'.$bigtext;
		$blog_data1='default.jpg';
		$blog_type='float_image_left'; 
		$blog_tiny_data2='50';
		$blog_data4=',5,5,0,10';
		$blog_style=',,,,,,,,,,,,left';//'0,20,20';
		break;
	case $this->blog_drop_array[4]:# 'New Right Image Left Side Text',
		$blog_text='Add your new text here. View the web page changes to see what image on left of text looks like.'.$bigtext;
		$blog_data1='default.jpg';
		$blog_type='float_image_right';
		$blog_style=',,,,,,,,,,,,left';
		$blog_tiny_data2='50';
		$blog_data4=',5,5,10,0';
		break;
	case $this->blog_drop_array[5]:#'New Video',
		$blog_text='video';
		$blog_tiny_data1=Cfg::Default_video_img; 
		$blog_data3='';
		$blog_type='video';
		//$blog_style='0,20,20';
		break;  
	case $this->blog_drop_array[6]:#new contact Form
		$blog_text='contact';
		$blog_type='contact';
		$blog_style='';//'0,20,20';
		break;
	case $this->blog_drop_array[7]:#new social array
		$blog_text='social_icons'; 
		$blog_type='social_icons';
		$blog_style='0,0,0';
		break;
	case $this->blog_drop_array[8]:#slideshow
		$blog_text='auto_slideshow'; 
		$blog_type='auto_slide';
		$blog_style='0,0,0'; 
		break;
	case $this->blog_drop_array[9]:#ga 
		$blog_text='gallery'; 
		$blog_type='gallery';
		$blog_style='0,0,0';
		$blog_data2='expand_preview_multiple,simulate,0,0,0,0,0,0,5,180,0,0,0,0,0,0,0,0,0,0,0,20';
		$blog_data3=',0,0,0,0,0,0,0,0,0,1.1,0,left';
		$blog_data4=',0,0,0,0,0,0,0,0,0,0,0,left';
		$blog_data5=',0,0,0,0,0,0,0,0,0,0,0,left';
		$blog_data6=',20,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat';
		break;
	case $this->blog_drop_array[10]:#new navigation 
		$blog_text='new_nav';
		$blog_type='navigation_menu'; 
		$blog_style='';//'0,20,20';
		break;
		default:
		printer::alert_neg('you must choose a value from dropdown menu',1.5);
		return;
	}//end switch
	
	$blog_date=time();
	$post_fields=Cfg::Post_fields;
	$post_field_arr=explode(',',$post_fields);
	$value='';
	foreach ($post_field_arr as $field){  
		if($field=='blog_clone_table')$value.="'$blog_clone_table',";
		elseif($field=='blog_data6')$value.="'$blog_data6',";
		elseif($field=='blog_data3')$value.="'$blog_data3',";
		elseif($field=='blog_data4')$value.="'$blog_data4',";
		elseif($field=='blog_date')$value.="'$blog_date',";
		elseif($field=='blog_text')$value.="'$blog_text',";
		elseif($field=='blog_data1')$value.="'$blog_data1',";
		elseif($field=='blog_tiny_data1')$value.="'$blog_tiny_data1',";
		elseif($field=='blog_tiny_data2')$value.="'$blog_tiny_data2',";
		elseif($field=='blog_style')$value.="'$blog_style',";
		elseif($field=='blog_type')$value.="'$blog_type',";
		elseif($field=='blog_table')$value.="'$tablename',";
		elseif($field=='blog_table_base')$value.="'$this->tablename',";
		elseif($field=='blog_col')$value.="'$col_id',";
		elseif($field=='blog_float')$value.="'$blog_float',";
		elseif($field=='blog_order')$value.="'$blog_order',"; 
		elseif($field=='blog_data2')$value.="'$blog_data2',";
		elseif($field=='blog_unclone')$value.="'$blog_unclone',";
		elseif($field=='blog_unstatus')$value.="'$blog_unstatus',";
		elseif($field=='blog_width')$value.="'$blog_width',";
		elseif($field=='blog_pub')$value.="'$blog_pub',";
		elseif($field=='blog_temp')$value.="0,";
		elseif($field=='blog_unstatus')$value.="'',";
		elseif($field=='blog_unclone')$value.="'',";
		elseif($field=='blog_unstatus')$value.="'',";
		else $value.="'',";
		} 
	$q="insert into $this->master_post_table  ($post_fields,blog_update,blog_time,token) values ($value '".date("dMY-H-i-s")."','".time()."','".mt_rand(1,mt_getrandmax())."')";  
		$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	
	 if ($this->mysqlinst->affected_rows())$this->success[]="You have Successfuly Created a New $blog_type ";
	 else $this->message[]="Problem with creating New post type $blog_type";
	 
	}
 
function blog_tidy($tablename){ 
	if (Sys::Methods){Sys::Debug(__LINE__,__FILE__,__METHOD__);}
	$i=$this->insert_full; 
	$q="select blog_order  from ".$this->master_post_table." where blog_table='$tablename' order by blog_order"; 
	$r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	if (!$this->mysqlinst->affected_rows())return;
	while (list($blog_order)=$this->mysqlinst->fetch_row($r,__LINE__)){
		$q2="UPDATE  $this->master_post_table set blog_temp=$i, token='".mt_rand(1,mt_getrandmax())."' where blog_table='$tablename' AND blog_order=$blog_order";   
	     $this->mysqlinst->query($q2,__METHOD__,__LINE__,__FILE__,true);
		$i+=$this->insert_full;
		}
	
	$q="Update  $this->master_post_table set blog_time='".time()."',token='".mt_rand(1,mt_getrandmax())."',blog_order=blog_temp where blog_table='$tablename'";  
	$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); 
	 
	}

function col_primary_tidy(){  //using primary order update  
	if (Sys::Methods){Sys::Debug(__LINE__,__FILE__,__METHOD__);}
	$i=1; 
	$q="select col_num  from ".$this->master_col_table." where col_primary=1 and col_table_base='$this->tablename' order by col_num"; 
	$r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	if (!$this->mysqlinst->affected_rows())return;
	while (list($col_num)=$this->mysqlinst->fetch_row($r,__LINE__)){
		$q2="UPDATE  $this->master_col_table set col_temp=$i, token='".mt_rand(1,mt_getrandmax())."' where col_table_base='$this->tablename'  AND col_num=$col_num";   
	     $this->mysqlinst->query($q2,__METHOD__,__LINE__,__FILE__,true);
		$i++;
		}
	
	$q="Update  $this->master_col_table  set col_time='".time()."',token='".mt_rand(1,mt_getrandmax())."',col_num=col_temp where col_table_base='$this->tablename' and col_primary=1";  
	$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); 
	 
	
	}
function process_delete_clunc(){ 
	foreach ($_POST['delete_blog_clunc'] as $key => $value ){
		$q="delete from $this->master_post_table where blog_id=$key";
		$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
		} 
	}	
function	delete_unc_clone_option($blog_id){
	$msg='Delete This Mirror released Recloned '.$this->blog_type.' &#40;Will Return to Original Cloned Parent&#41;';
	echo'<p class="warn1 floatleft redAlert left"><input type="checkbox" name="delete_blog_clunc['.$blog_id.']" value="delete" >&nbsp;'.$msg.'</p>';
	printer::pclear();
	$this->success[]="Your unclone record has been deleted";
	}
	
function delete_option(){ 
	if ($this->tablename!=$this->blog_table_base)return;
	$type=(isset($this->blog_type))?$this->blog_type:'Divison';
	$msg=($this->blog_unstatus=='unclone')?'Delete This Mirror released '.$type.' &#40;Will Return to Cloned Parent&#41;':'Delete this Post';
	echo'<p class="warn1 floatleft redAlert left"><input type="checkbox" name="delete_blog['.$this->blog_table.']['.$this->blog_order.']" value="delete" onchange="edit_Proc.oncheck(\'delete_blog['.$this->blog_table.']['.$this->blog_order.']\',\'THIS ENTRY WILL BE DELETED WHEN YOU HIT CHANGE, UNCHECK TO CANCEL\');gen_Proc.use_ajax(\''.Sys::Self.'?unclone_list_post='.$this->blog_id.'@@del_unc_'.$this->blog_id.'\',\'handle_replace\',\'get\');" >&nbsp;'.$msg.'</p>';
	printer::pclear();
	echo '<p id="del_unc_'.$this->blog_id.'"></p>';
	}

#bp
function break_point(){exit('breakpt exit');
	if ($this->is_page){
		$msg1='page';
		$title1="Break Points Determine when Content Should Break to the Next Line Depending on the Device Screen Size";
		$name1='';
		}
	elseif ($this->is_column){
		$msg1='column';
		$title1='';
		$name1='';
		}
	elseif ($this->is_blog){
		$msg1='post';
		$title1='';
		$name1='';
		}
	else $this->message[]='Overran in break point';
	
	echo '<div class="'.$this->column_lev_color.'  floatleft left fsminfo editbackground editfont"><!--wrap break point-->';
	printer::alertx('<p class="fs1'.$this->column_lev_color.'  floatleft" >This Systems main Responsive Web Design settings, referred to here as RWD,  is based on Current Device Screen Width and Fluid Percentage Styling and avoids "device specific" styling due to the ever increasing variety of device screen sizes.  This system enables you to control CSS styling with @media break points which  sets specific content width based on the viewers device screen dimension and to further customize RWD break points and content width size for individual nested columns or posts or both so it can best respond to your content.  Initially, posts within columns have a width of 100% and no RWD set,  but posts have built in response non-the-less.  And for many column postings layouts this will suffice. </p>');
	printer::pclear(5);
	//printer::alertx('<p class="fs1'.$this->column_lev_color.'  floatleft" >Examples of break Syntax: <br> 
	 //"900,600"  gives the media query: ');
	 
	
	echo '</div><!--wrap break point-->';
	
	printer::pclear();
	}
#format	
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
	
#postop #blogop	
function blog_options($data,$tablename){if(Sys::Custom)return; 
	if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	if(!$this->edit)return;
	if ($this->is_clone&&!$this->clone_local_style){
		if($this->column_use_grid_array[$this->column_level]==='use_grid') 
			$this->rwd_build('blog',$data);
		else $this->alt_respond('blog'); 
		return;
		}
		
	elseif ($this->is_clone&&!$this->clone_local_style)return; 
	if (empty($tablename))return;#not a blog request
	printer::pclear();
	$this->show_more('Post Options','','','',500);
	echo '<div class="shadowoff editbackground editfont fs2black floatleft maxwidth500" ><!--blog opts background-->';
	echo '<div class="fsminfo editfont editbackground floatleft "><!--Checkbox OPtions Border-->';	
	
	$this->delete_option();
	printer::pclear();
	if ($this->blog_pub){
		printer::alertx('<p class="info floatleft" title="Turn Off Publication of this Post to Web Page"><input type="checkbox" value="0" name="'.$this->data.'_blog_pub"> Un-Publish Post to WebPages</p>');
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
	echo '<p class="info floatleft"  title="&#34;Group Styles&#34; provide an opportunity to quickly select group(s) of posts within a Column to distinguish them as related such as using a simple border. Begin by checking the begin box on the first non column post and check the end box on the last non column post you wish to distinguish within the same column! Span column posts between open and close tags if you wish.  Be sure to match with a close groupstyle before beginning with a new one in the same column.  Unmatched open border and close border checked options will generate an alert mesage and can mess up the webpage styling. For more info on Post Grouping Styles and to set styling options go to the &#34;Group Style&#34; options under the master column settings. Check both boxes on the same post to end an group and begin another group or to wrap a single post, the system will determine which one is intendted as long as your consistent with closing every opening. "><input type="checkbox" name="'.$name.'" value="1">&nbsp;'.$msg.'</p>';
	
	printer::pclear(2);	
	 if (!empty($this->blog_border_stop)){
		$name='blog_border_stop_remove['.$data.']';
		$msg='<span class="warnlight">Remove End Post Group Styles</span>';
		}
	else	{
		$name=$data.'_blog_border_stop';
		$msg='End Post Group Styles';
		}
	echo '<p class="info  floatleft"  title="Checking here ends Group Post styles started on a post above and this post will be included."><input type="checkbox" name="'.$name.'" value="1">&nbsp;'.$msg.' </p>';
	printer::pclear();
	if ($this->blog_type=='float_image_left'||$this->blog_type=='float_image_right'||$this->blog_type=='text'){
		$msg=($this->blog_options[$this->blog_editor_use_index]==='use_editor')?'Toggle TinyMCE Editor':'Keep On TinyMCE Editor';
		if ($this->blog_options[$this->blog_editor_use_index]==='use_editor')	
			echo '<p class="info  floatleft" title="Check to Utilize TinyMCE only when needed and submit with other changes"><input type="checkbox" name="'.$data.'_blog_options['.$this->blog_editor_use_index.']" value="0">'.$msg.'</p>';
				
		else echo '<p class="info  floatleft" title="Check to keep TinyMCE Editor On in addition to the normal editing options below this post then submit to commit along with other changes on the page"><input type="checkbox" name="'.$data.'_blog_options['.$this->blog_editor_use_index.']" value="use_editor">&nbsp;'.$msg.'</p>';
		printer::pclear();
		if ($this->blog_options[$this->blog_comment_index]==='comment_on') 
			printer::printx ('<p class="info floatleft" title="Check to Turn off the display of Viewing Comments for this Post"><input type="checkbox" name="'.$data.'_blog_options['.$this->blog_comment_index.']" value="0">Turn off Commenting </p>');
					
		else printer::printx ('<p onclick="edit_Proc.displaythis(\''.$data.'_comments_show\',this,\'#fdf0ee\')"  class="info floatleft" title="Check to enable Viewers to Submit for Display Comments to this Post"><input type="checkbox" name="'.$data.'_blog_options['.$this->blog_comment_index.']" value="comment_on">Allow Commenting</p>');
		printer::pclear();
		$genstyle=($this->blog_options[$this->blog_comment_index]==='comment_on')?'style="display:block;background:#fdf0ee;"':'style="display:none;"';
		$checked1=($this->blog_options[$this->blog_comment_display_index]!=='display_comment')?'checked="checked"':'';
		$checked2=($this->blog_options[$this->blog_comment_display_index]==='display_comment')?'checked="checked"':'';
		printer::printx('<p id="'.$data.'_comments_show" '.$genstyle.'><input type="radio" '.$checked1.' name="'.$data.'_blog_options['.$this->blog_comment_display_index.']" value="0" >Hide-n-Click to Open Comments<br><input type="radio" '.$checked2.' name="'.$data.'_blog_options['.$this->blog_comment_display_index.']" value="display_comment" >Display Comments Directly</p>');
		}// if text and float image text types
	if ($this->blog_options[$this->blog_date_on_index]==='date_on') 
			
		printer::printx('<p class="'.$this->column_lev_color.'"><input type="checkbox" name="'.$data.'_blog_options['.$this->blog_date_on_index.']" value="0">Turn Off Date Display</p>');
		  
	else	printer::printx('<p class="info editbackground editfont" title="Display the Posted Date" ><input type="checkbox" name="'.$data.'_blog_options['.$this->blog_date_on_index.']" value="date_on">Turn On Current Post Date Display</p>');
	
	echo '</div ><!--Checkbox Options Border-->';
	printer::pclear(2);
	$this->show_more('Import/Export Styles &amp; Configurations Option');
	printer::print_wrap('import/export','editbackground editcolor fsmgreen Os3blue');
	echo '<div class="'.$this->column_lev_color.' fsminfo  editbackground left "><!--import-->Import all styles and certain configuration from another '.$this->blog_type.' post from any page. <b>Will Not change configurations for width, Rwd Grid settings, height, and alternative RWD settings, as these can be changed separately below. Will not change basic data such as Image Names and caption data, feedback, text, etc.</b> Post types must match.';
	printer::printx( '<p class="editfont editcolor editbackground" title="Be Sure to Use the Post Id Which Begins with a P ie P42.  Do Not Use the  Post# which simply refer to the Post Display Order Within the Column. Post Ids and #s are displayed at the top of each post"><input style="editcolor editbackground" name="post_configcopy['.$this->blog_id.']['.$this->blog_type.']" size="8" maxlength="8" type="text">Enter the  <span class="info">Post Id</span> <span class="red">(Not Post#) </span>that you wish to Copy Configurations and Styles</p>');
	echo '</div>'; 
	echo '<div class="'.$this->column_lev_color.' fsminfo  editbackground left "><!--export-->Export styles and configuration (see above) from this '.$this->blog_type.' post to any other '.$this->blog_type.' post that is directly within this Column Post types must match.';
	printer::printx( '<p class="editfont editcolor editbackground" 	><input style="editcolor editbackground" name="post_configexport['.$this->blog_id.']"   type="checkbox" value="'.$this->blog_id.'">Export these Styles and Configs to '.$this->blog_type.' posts within this column</p>');
	echo '</div><!--export-->';
	####################################################
	echo '<div class="'.$this->column_lev_color.' fsminfo  editbackground left "><!--import-->Import RWD Grid percentage selections  from another non nested column post from any page that has the same   Grid Break Points set in the page options.  ';
	printer::printx( '<p class="editfont editcolor editbackground" title="Be Sure to Use the Post Id Which Begins with a P ie P42.  Do Not Use the  Post# which simply refer to the Post Display Order Within the Column. Post Ids and #s are displayed at the top of each post"><input style="editcolor editbackground" name="post_rwdcopy['.$this->blog_id.']" size="8" maxlength="8" type="text">Enter the  <span class="info">Post Id</span> <span class="red">(Not Post#) </span>that you wish to copy Post RWD grid break point percentages</p>');
	echo '</div>'; 
	echo '<div class="'.$this->column_lev_color.' fsminfo  editbackground left "><!--export-->Export RWD settings from this  post to any other non nested column post that is directly within this Column';
	printer::printx( '<p class="editfont editcolor editbackground" ><input style="editcolor editbackground" name="post_rwdexport['.$this->blog_id.']"  type="checkbox" value="'.$this->blog_id.'">Export this Posts RWD Grid settings to other posts within this column</p>');
	printer::printx( '<p class="editfont editcolor editbackground" ><input style="editcolor editbackground" name="post_col_rwdexport['.$this->blog_id.']"  type="checkbox" value="'.$this->blog_id.'">Also include RWD Grid export to Nested Columns directly in same parent </p>');
	echo '</div><!--export-->';
	#######################################################
	echo '<div class="'.$this->column_lev_color.' fsminfo  editbackground left "><!--export-->Export the Alternative RWD Width settings (affects posts in non-RWD grid mode) from this post to  posts that are directly within this Column';
	printer::printx( '<p class="editfont editcolor editbackground" ><input style="editcolor editbackground" name="post_altrwdexport['.$this->blog_id.']"  type="checkbox" value="'.$this->blog_id.'">Export the Alternative Width settings setting of this post to all posts directly in this column</p>');
	
	printer::printx( '<p class="editfont editcolor editbackground" ><input style="editcolor editbackground" name="post_col_altrwdexport['.$this->blog_id.']"  type="checkbox" value="'.$this->blog_id.'">Also include Alt RWD export to Nested Columns directly in same parent </p>');
	echo '</div><!--export-->';
	######################################################
	echo '<div class="'.$this->column_lev_color.' fsminfo  editbackground left "><!--export-->Export the Width setting (affects posts in non-rwd grid mode) from this post to all posts including nested column that are directly within this Column';
	printer::printx( '<p class="editfont editcolor editbackground" ><input style="editcolor editbackground" name="post_widthexport['.$this->blog_id.']"  type="checkbox" value="'.$this->blog_id.'">Export the width setting of this post to all posts directly in this column</p>');
	echo '</div><!--export-->';
	#######################################################33
	echo '<div class="'.$this->column_lev_color.' fsminfo  editbackground left "><!--export-->Export the Height setting from this post to all posts including nested column that are directly within this Column';
	printer::printx( '<p class="editfont editcolor editbackground" ><input style="editcolor editbackground" name="post_heightexport['.$this->blog_id.']"  type="checkbox" value="'.$this->blog_id.'">Export the height setting of this post to all posts directly in this column</p>');
	echo '</div><!--export-->';
	##########################################333
	echo '<div class="'.$this->column_lev_color.' fsminfo  editbackground left "><!--export-->Export the Position Float setting (affects posts in non-rwd grid mode) from this post to all posts including nested column that are directly within this Column';
	printer::printx( '<p class="editfont editcolor editbackground" ><input style="editcolor editbackground" name="post_floatexport['.$this->blog_id.']"  type="checkbox" value="'.$this->blog_id.'">Export the Position setting of this post to all posts directly in this column</p>');
	echo '</div><!--export-->';
	##########################################333
	$this->submit_button();
	printer::close_print_wrap('import/export'); 
	$this->show_close('Import All Styles &amp; Configurations Option');
			################33
	if (!$this->rwd_post){//regular mode... 
		echo '<div class="fsminfo editfont editbackground "><!--width options-->';
		$this->blog_width=(is_numeric($this->blog_width))?$this->blog_width:0;
		$this->{$data.'_blog_width_arrayed'}=explode(',',$this->blog_width);
		$this->width($data.'_blog_width_arrayed',0);
		printer::pclear();
		echo '</div><!--width options-->';	 
		 
		printer::pclear();
		printer::alertx('<div class="'.$this->column_lev_color.' maxwidth400  floatleft left fsminfo editbackground editfont">Positioning Choices');
		printer::pclear();
		$this->show_more('More Info..','noback','infoclick editbackground editfont floatleft','Click Here For More info on Post Positioning Choices',400);
		printer::alertx('<p class="floatleft editbackground editcolor"> 
		For posts within a non-RWD grid choices enable manually floating a post next to another by limiting the respective widths to a total cumulative percentage less than 100% and then choosing a float option. By default, the center row option will the post to occupy the whole role, whereas the other choices allow space sharing. </p>','',"");
		$this->show_close('Post Position Choices');//<!--Show More Post Position Choices-->';
		printer::pclear(2);
		echo '<div class="fs1color floatleft editcolor editbackground editfont"><!--Position- Border-->';
		printer::alert('Positioning Choices');
		$chosen=(in_array($this->blog_float,$this->position_arr))?$this->blog_float:'center_row';
		 
		forms::form_dropdown($this->position_arr,$this->position_val_arr,'','',$data.'_blog_float',str_replace('_',' ',$chosen),false,'ramana');
		echo '</div><!--end pos choices-->'; 
		printer::pclear(2);	
		 echo '</div><!--End form dropdown Post Positions-->';
		printer::pclear(3);
		$this->alt_respond('blog'); 
		printer::pclear(5);
		###
		printer::alertx('<div class="'.$this->column_lev_color.' fsminfo maxwidth500 floatleft editbackground">By Default Posts will Vertically Top Align with Other Posts within the Parent Column. Change that Default Here '); 
		printer::alert('Post Vertical Positioning Choice','','left editcolor editbackground');
		$current_vert_val=($this->blog_options[$this->blog_vert_pos_index]!=='middle'&&$this->blog_options[$this->blog_vert_pos_index]!=='bottom')?'top':$this->blog_options[$this->blog_vert_pos_index];
		forms::form_dropdown(array('top','middle','bottom'),'','','',$data.'_blog_options['.$this->blog_vert_pos_index.']',$current_vert_val,false,'editcolor editbackground left');
		$this->css.="\n.".$data.'{vertical-align:'.$current_vert_val.'}';
		printer::alertx('</div>');
		}
#postrwd
	else{//using RWD select classes
		$this->rwd_build('blog',$data);
		}//end RWD select classes
	#########################################
	$maxheight=1000;
	$this->blog_height=($this->blog_height>9||$this->blog_height<=$maxheight)?$this->blog_height:0;
	$this->show_more('Uniform Post Height Option');
	printer::print_wrap('wrap height info','fsminfo editcolor editbackground');
	printer::print_tip('Normally Heights are automatically set and setting a height is unnecessary. However you can set heights Here for effect such as having all posts in a column the same height for a tile effect. You can export a height selection in import/export option above. Longer Posts will scroll beyond the height set.  When height is set on an Image post the width will be auto adjusted if possible.   Value must be at least 10px to have effect. <br><b>Current Value: '.$this->blog_height.'px</b>');
	
	echo '<div class="fs1color"><!--Edit height Adjust-->';  
	$msgjava='Choose Post Height Px:'; 
	$factor=1;
	echo '<div class="editcolor editfont editbackground click" onclick="gen_Proc.precisionAdd(this,\''.$data.'_blog_height\',0,\''.$maxheight.'\',\''.$this->blog_height.'\',\'px\',\''.$factor.'\',\''.$msgjava.'\',\'\',\'simple\');">Image Max Height Px</div>'; 
echo '</div><!--Edit Height Adjust-->';
	printer::close_print_wrap('wrap height info');
	$this->show_close('Image Height Info'); 
	###################################
	echo '<div class="fsminfo info editbackground floatleft"><!--Blog Tag Border-->'; 
	printer::printx('<p title="Enter an optional tag for this post. All posts with the tag will be displayed if you set a  column with matching tag to display. Enter more than one tag as required.">Tag this Post:&nbsp;<input type="text" value="'.$this->blog_tag.'" name="'.$data.'_blog_tag" size="20" maxlength="40"></p>');
	 
	echo '</div><!--Blog Tag-->';
	printer::pclear();
	//$this->option_pad_percent('blog',$this->data);
	$this->submit_button();
	echo '</div><!--blog opts background-->';
	
	
	$this->show_close('End Post Options');echo '<!--Post Options-->';
	printer::pclear(2);	  
	}
#alt_resp
function alt_respond($type){//currently using on post level only
	if ($this->is_clone&&!$this->clone_local_style)return;
	$check1=$check2=$check3=$check4=$check5='';
	$checked='checked="checked"';
	$data=$this->data;
	//Alt_rwd_options='blog_width_mode,blog_min_width,blog_bounce_width';
	$name='name="'.$data.'_'.$type.'_alt_rwd['.$this->{$type.'_width_mode_index'}.']" ';
	if ($type==='blog'){
		switch ($this->{$type.'_alt_rwd'}[$this->{$type.'_width_mode_index'}]) {
			case  'maxwidth':
				$check1=$checked;
				break;
			case 'compress_full_width':
				$check2=$checked;
				break; 
			case 'compress_to_percentage': 
				$check3=$checked;
				break;
			//case 'compress_break2_maxwidth':
				//$check4=$checked;
				//break;
			//case 'compress_break2_fullwidth':
				//$check5=$checked;
				//break;
			default:
			$this->blog_alt_rwd[$this->blog_width_mode_index]='none';//$this->column_options[$this->column_width_mode_index]; 
					//$checked1=$checked;
				//endif;	 
			}//end switch
		}//IF SET
	 
		$this->show_more('Alternative Width Response','','','','800');
		$msg_option=($type==='page')?'the default option for all posts in this page. Values can be changed in indiviual posts as needed':'a response option for this individual post';
		echo '<div class="fsminfo editbackground '.$this->column_lev_color.'"><!--alt width wrapper-->';
		$msg='There are two main methods for positioning posts (including columns) within a parent column. RWD grid or choosing a response option for individual posts. Choices here are for the second type. Set <span class="bold">'.$msg_option.'</span>';
		printer::printx('<p class="tip">'.$msg.'</p>');
		$msg2=" The following choices refer to two or more posts sharing a row in a column  and whether the width of each post will compress (on smaller screens) allowing them to continuing sharing. To what extent they will compress is a separate option. The fully compressable option just keeps shrinking and row sharing of chosen posts. The Maintain width option does not compress at all. The compress to percentage option stops compressing to the percentage of original width chosen. At this point the last shared post will break to a new row and with a second width option which specifies to what extent the posts then rebound in width or not at all.";
		$default_mode=Cfg::Default_width_mode; 
		echo '<p class="fsmnavy editbackground '.$this->column_lev_color.'">'.$msg2.'</p>';
		printer::printx('<p class="tip">The Alternative width response mode  is provides an alternative means for responsive design when not using break points and when two or more posts occupy a row in a column.   By default these posts will not compress as space becomes limiting but change the behavior mode here</p>');
		echo '<p class="fsmcolor editbackground editcolor">
		 	1.<input type="radio" '.$name.$check1.' value="maxwidth">Chosen Floated Posts will not compress before breaking to new row as space permits.(default mode). Perfect for a single post which occupies a whole Column Row<br>
		2.<input type="radio" '.$name.$check2.' value="compress_full_width">Fully Compressable (all floated posts with this setting will continue compressing without minimum size)<br>
		<div class="fsmcolor"><!--wrap percentage choices to option3-->
		3.<input type="radio" '.$name.$check3.' value="compress_to_percentage">Compress to percentage of Width then respond width<br><br> ';
		
		printer::pclear(5);
		echo '<div class="fsmnavy"><!--wrap percentage alt rwd-->';
		
		$compression=(is_numeric($this->{$type.'_alt_rwd'}[$this->{$type.'_min_width_index'}])&&$this->{$type.'_alt_rwd'}[$this->{$type.'_min_width_index'}]<101&&$this->{$type.'_alt_rwd'}[$this->{$type.'_min_width_index'}]>0)?$this->{$type.'_alt_rwd'}[$this->{$type.'_min_width_index'}]:Cfg::Default_min_width;
		
		$name=$data.'_'.$type.'_alt_rwd['.$this->{$type.'_min_width_index'}.']';
		printer::printx('<p class="tip">Change the  compressible Min Width percentage used for all posts in the Page Options. <b>Value currently: '.$compression.'%</b></p>');
		printer::printx('<p class="'.$this->column_lev_color.'">Change current percentage of compressability of this post</p>'); 
		$this->mod_spacing($name,$compression,1,100,1,'%');
		echo '</div><!--wrap percentage alt rwd-->';
		echo '<div class="fsmnavy"><!--wrap bounce alt rwd-->';
		 
		$bounceback=(is_numeric($this->{$type.'_alt_rwd'}[$this->{$type.'_bounce_width_index'}])&&$this->{$type.'_alt_rwd'}[$this->{$type.'_bounce_width_index'}]<301&&$this->{$type.'_alt_rwd'}[$this->{$type.'_bounce_width_index'}]>0)?$this->{$type.'_alt_rwd'}[$this->{$type.'_bounce_width_index'}]:0;
		
		$name=$data.'_'.$type.'_alt_rwd['.$this->{$type.'_bounce_width_index'}.']';// page not setup  was determining different default..
		printer::printx('<p class="tip">Use 0 to remove bounceback width and maintain the images at the Change the default bounce back width percentage used for all posts in the Page Options. <b>Value currently: '.$bounceback.'%. </b><span class="small">100% refers to the original uncompressed width setting. After floating images break to a new row, any compression of images does not naturally spring back even when space allows on a new row but you can enable a spring back percent here! Experiment and See! </span></p>');
		printer::printx('<p class="'.$this->column_lev_color.'">Change Current bounceback percentage of this post</p>');
		$this->mod_spacing($name,$bounceback,0,300,1,'%');
		echo '</div><!--wrap bounce alt rwd-->
		</div><!--wrap percentage choices to option3-->';
		
		//echo '4.<input type="radio" '.$name.$check4.' value="none">Back to follow page default mode<br> 
		echo ' </div><!--alt width wrapper-->';	
		$this->show_close('Alternative Width Response');
	}// end alt width response
	
#rwdbuild  #rwdop  #grid

function option_pad_percent($type,$data){
	printer::print_wrap('percent opt','Os3ekblue fsmoldlace');
	printer::print_tip('By default posts including nested columns use px for padding  and margin but % can be enabled here for the posts main outer padding or width.<span class="neu oldlacebackgrond">Note:Percentage is calcaluted as fraction of the Column container Width (border-box)</p>');
	$checked1=($this->{$type.'_options'}[$this->{$type.'_pad_unit_index'}]!=='percent')?'checked="checked"':'';
	$checked2=($this->{$type.'_options'}[$this->{$type.'_pad_unit_index'}]==='percent')?'checked="checked"':'';
	$checked3=($this->{$type.'_options'}[$this->{$type.'_mar_unit_index'}]!=='percent')?'checked="checked"':'';
	$checked4=($this->{$type.'_options'}[$this->{$type.'_mar_unit_index'}]==='percent')?'checked="checked"':'';
	printer::print_wrap('wrap margin choice','fsmgreen');
	printer::alert('<input type="radio" '.$checked1.' name="'.$data.'_'.$type.'_options['.$this->{$type.'_pad_unit_index'}.']" value="px" '.$checked1.'>Use padding px');
	printer::alert('<input type="radio" name="'.$data.'_'.$type.'_options['.$this->{$type.'_pad_unit_index'}.']" value="percent" '.$checked2.'>Use padding percent');
	printer::close_print_wrap('wrap margin choice');
	printer::print_wrap('wrap pad choice','fsmgreen');
	printer::print_tip('Affects Non-RWD mode Margin left/right selection');
	printer::alert('<input type="radio" name="'.$data.'_'.$type.'_options['.$this->{$type.'_mar_unit_index'}.']" value="px" '.$checked3.'>Use Margin px');
	printer::alert('<input type="radio" name="'.$data.'_'.$type.'_options['.$this->{$type.'_mar_unit_index'}.']" value="percent" '.$checked4.'>Use Margin percent');
	
	printer::close_print_wrap('wrap pad choice');
	printer::close_print_wrap('percent opt');
	}
	
function rwd_build($type,$data){
	if ($this->is_blog&&$this->blog_type==='gallery'&&$this->blog_tiny_data2==='master_gall')printer::printx('<p class="tip"> Master Galleries are fully responsive and perfom best at 100% of available width for each break point. directly set a maximum availble width in the configuration</p>');
	if ($type==='col'&&$this->column_level <1) return; 
		if (!$this->is_clone||$this->clone_local_style) echo '<div class="fsminfo editbackground editcolor"><!--Wrap Post class config-->';
		$cid=($this->blog_type=='nested_column')?$this->column_id_array[$this->column_level-1]:$this->col_id;
		
		//for future reference if this post is cloned!
		//col/blog_grid_clone is used only as means to determine mismatch. ie For giving mismatch error notification between page setting and parent setting if mismatch in grid units or break points
		//value will be updated with every submit to be sure...  will not pass through the normal channels and as such will not trigger clone iframes for css generation which is the present method for updating clone css...
		if($this->edit&&!$this->is_clone&&isset($_POST['submitted'])){
			if ($type==='col') 
				$q="update $this->master_col_table set col_grid_clone='{$this->current_grid_units}@@$this->page_br_points' where col_id=$this->col_id";
			else $q="update $this->master_post_table set blog_grid_clone='{$this->current_grid_units}@@$this->page_br_points' where blog_id=$this->blog_id";
			$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
			}
		if($this->is_clone&&!$this->clone_local_style){ 
			$msg=''; 
			if (!empty($this->{$type.'_grid_clone'})&&count(explode('@@',$this->{$type.'_grid_clone'})>1)){
				$tarr=explode('@@',$this->{$type.'_grid_clone'});
				if ($tarr[0]!=$this->current_grid_units){ 
					$msg='Current Grid Units Mismatch & ';
					}
				if ($tarr[1]!=implode(',',$this->page_break_arr)){
					$msg.='Page Break Point Mismatch';
					}
				if (!empty($msg)){
					$msg.=NL.'Due to Mismatch Local Clone Styling Suggested to Sync Cloned Post with Current Settings!';
					printer::alertx('<p class="neg supersmall floatleft">'.$msg.'</p>');
					}
				}//count 2
			else{
				$msg="If Parent Clone Break Points or Grid Units Differ From this page Current Break Points or Grid Settings enable clone local style and configure for proper width response";
				printer::alertx('<p class="neg whitebackground supersmall floatleft">'.$msg.'</p>');
				}
			}
		$bp_arr=$this->page_break_arr;
		process_data::natkrsort($bp_arr);
		array_unshift($bp_arr,'max'.$bp_arr[0]); 
		$gu=$this->current_grid_units;
		$post__arr=0; 
		$countbp=count($bp_arr); 
		$current_calc=array();
		 //new local version will be append class version
		$setup_arr=array('wid'=>$type.'_grid_width','left'=>$type.'_gridspace_left','right'=>$type.'_gridspace_right');
		if(!isset($this->grid_width_record[$cid]))$this->grid_width_record[$cid]=array();
		foreach($setup_arr as $prefix=>$field){
			if(!isset($this->{'column_total_gu_arr'}))$this->{'column_total_gu_arr'}=array();
			if(!array_key_exists($cid,$this->{'column_total_gu_arr'}))$this->{'column_total_gu_arr'}[$cid]=array();
			${$field.'_arr'}=explode(',',$this->{$field});
			for ($i=0; $i<$countbp;$i++){ 
				if (!array_key_exists($i,${$field.'_arr'})){
					${$field.'_arr'}[$i]=0;
					} 
				}
			${'select_'.$prefix.'_arr'}=array();
			${$prefix.'_grid_unit'}=array();
			${$prefix.'_grid_width'}=array();
			 if ((!$this->is_clone||$this->clone_local_style)&&count(${$field.'_arr'})>$countbp){
				//class grid styles for columns and blogs are subbed out individually using the master updating mechanism..  Because of this if the number of break points decrease there will be too many classes and they are removed here!
				$newval=implode(',',array_slice(${$field.'_arr'},0,$countbp));
				echo '<input type="hidden" name="'.$data.'_'.$field.'" value="'.$newval.'">';//cut off xtra classes if bps for column less than previous
				} 
	#rwd
			//here we pre-generating select choice array options for each bp and wid, left or right
			for ($i=0; $i<$countbp; $i++){
				$bp=$bp_arr[$i];
				$bp_class_specify=(substr($bp,0,3)==='max')?'':(($i<$countbp-1)?'-'.$bp_arr[$i+1]:'-'.$bp);  
				if(!array_key_exists($bp,$this->{'column_total_gu_arr'}[$cid]))$this->{'column_total_gu_arr'}[$cid][$bp]=0;
				if(!array_key_exists($bp,$current_calc))$current_calc[$bp]=0;
				${$prefix.'_grid_width'}[$bp]=${$field.'_arr'}[$i];
				${'select_'.$prefix.'_arr'}[$bp]=array();
				$match=false;
				if($prefix==='wid'){
					for ($ii=0; $ii<$gu+1; $ii++){
						$ch=${'select_'.$prefix.'_arr'}[$bp][$ii]=$prefix.'-bp-'.$bp.$bp_class_specify.'-'.$ii.'-'.$gu;
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
					for ($ii=0; $ii<$gu; $ii+=.5){
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
					if(empty(${$prefix.'_grid_width'}[$bp])){
						${$prefix.'_grid_unit'}[$bp]=0;
						$match=true;
						}
					elseif (${$prefix.'_grid_width'}[$bp]==$prefix.'-bp-'.$bp.$bp_class_specify.'-0-'.$gu)$match=false;//it will be set to empty class instead.
					}
				if (!$match){//fill default class values for rendering classes... ie. not immed plugin values
					$default_calc=($prefix==='wid')?$gu:0;
					
					${$prefix.'_grid_width'}[$bp]=($prefix==='wid')?$prefix.'-bp-'.$bp.$bp_class_specify.'-'.$default_calc.'-'.$gu:'';
					${$prefix.'_grid_unit'}[$bp]=$default_calc;
					$this->{'column_total_gu_arr'}[$cid][$bp]+=$default_calc;
					$current_calc[$bp]+=$default_calc;
					echo '<input type="hidden" name="'.$data.'_'.$field.'['.$i.']" value="'.${$prefix.'_grid_width'}[$bp].'">';//
					}
				$id=($this->blog_type=='nested_column')?'c'.$cid:'p'.$this->blog_id;	
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
		$colpost=($type=='col')?'Column':'Posted Content';
		if(!$this->is_clone||$this->clone_local_style){ 		printer::printx('<p class="fsm'.$this->column_lev_color.' '.$this->column_lev_color.' editfont editbackground"> The Parent Column of this '.$colpost.' is setup as a responsive Grid. Choose the relative width display for this '.$colpost.' Within the parent Column for each break point (viewer device width value!)</p>');	
		$this->grid_width_record[$cid][]=array_merge(array('id:'=>$id),$wid_array,$right_array,$left_array,$bpcalc_arr,$bptotalcalc_arr);
		printer::printx('<p class="fsm'.$this->column_lev_color.' '.$this->column_lev_color.' editfont editbackground"><span class="bold center">'.$gu.'gu/row in use</span><br>'.$msgcurr.'</p>');
		
		$this->show_more('View Complete Grid Unit Use Table & Info','noback','italic editbackground '.$this->column_lev_color.' underline','','600');
		printer::printx('<p class="fsm'.$this->column_lev_color.' '.$this->column_lev_color.' editfont editbackground"><span class="bold center">Tot# Rows Used For Posts Up to Current Post</span>in Col Id C'.$cid.'<br>'.$msgtot.'</p>');
		printer::printx('<p class="fsm'.$this->column_lev_color.' '.$this->column_lev_color.' editfont editbackground">Table below shows values in Grid Units. You are configured for '.$gu.'gu per row. Each row has values for a single Post up to the post your curently viewing for each break point class.<br><span class="info">"max"</span>  value refers to Device Screen Width greater than the largest break point.
<br>
<span class="info">"@bp"</span> or break point values target maximum screem width between its value and that greater than the next lowest value break point.<br> <span class="info">"wid"</span> refers to content width at the specified break point.<br><span class="info">"Rig"</span> or <span class="info">"Lef"</span> refer  to right or left (margin) spacing selected between posts; <br><span class="info">"Cur Tot"</span> refers to the total (wid+lef+rig) of each post at the particlar break point specified.<br> <span class="info">"Tot Tot"</span>  calculates the running total adding together all Cur Tot up to the current post.</p>');
		printer::horiz_print($this->grid_width_record[$cid],'','','','',false,false,'editcolor editbackground smallest');
		$this->show_close('Show Grid Unit Use Table');
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
			if (isset($this->column_bp_width_arr[$this->column_level-1])){//for calculating accumulative percent level tree
			 
				if (array_key_exists($bp,$this->column_bp_width_arr[$this->column_level-1])){//parent column 
					$grid_temp=$this->column_bp_width_arr[$this->column_level][$bp]= $this->column_bp_width_arr[$this->column_level-1][$bp]* $wid_grid_unit[$bp]/$gu;//multiply parent value by current percent
					$maxlimit=(substr($bp,0,3)==='max')?$bp:min($bp,$this->max_width_limit);
					$this->grid_width_chosen_arr[$bp]=(substr($bp,0,3)==='max')?$this->max_width_limit*$grid_temp/100:$grid_temp*$maxlimit/100;
					$this->grid_width_available[$this->column_level][$bp]=(substr($bp,0,3)==='max')?$this->max_width_limit*$this->column_bp_width_arr[$this->column_level-1][$bp]/100:$this->column_bp_width_arr[$this->column_level-1][$bp]*$maxlimit/100;
					}
				 else  exit('array exists but key doesnt '.__LINE__);
				 }
			else{//no array values exist reworked out of the equation as it has limited usefulness...  
				if (!isset($this->column_bp_width_arr[$this->column_level]))$this->column_bp_width_arr[$this->column_level]=array();
				if (!isset($this->grid_width_available[$this->column_level]))$grid_width_total_available[$this->column_level]=array();
				$grid_temp=$this->column_bp_width_arr[$this->column_level][$bp]=$wid_grid_unit[$bp]/$gu*$this->column_total_net_width_percent[$this->column_level-1];
				$this->grid_width_available[$this->column_level][$bp]=(substr($bp,0,3)==='max')?$this->column_net_width[0]*$this->column_total_net_width_percent[$this->column_level-1]/100:$this->column_total_net_width_percent[$this->column_level-1]*$bp/100;
				$this->grid_width_chosen_arr[$bp]=(substr($bp,0,3)==='max')?$this->column_total_width[0]*$grid_temp/100:$grid_temp*$bp/100;
				
				}
			}//end type = col
		else {  //post type
				$maxlimit=(substr($bp,0,3)==='max')?$bp:min($bp,$this->max_width_limit); 
				
			 if (isset($this->column_bp_width_arr[$column_level])&&array_key_exists($bp,$this->column_bp_width_arr[$column_level])){//for calulating accumulative percent level tree
				$grid_temp= $this->grid_post_percent_arr[$bp]=$this->column_bp_width_arr[$column_level][$bp]* $wid_grid_unit[$bp]/$gu;//multiply parent value by current percent
				$this->grid_width_chosen_arr[$bp]=(substr($bp,0,3)==='max')?$this->max_width_limit*$grid_temp/100:$grid_temp*$maxlimit/100;
				$this->grid_width_available[$this->column_level][$bp]=(substr($bp,0,3)==='max')?$this->column_net_width[0]*$this->column_total_net_width_percent[$this->column_level-1]/100:$this->column_total_net_width_percent[$this->column_level-1]*$maxlimit/100;
				 $this->grid_width_available[$this->column_level][$bp]=(substr($bp,0,3)==='max')?$this->max_width_limit*$this->column_bp_width_arr[$this->column_level][$bp]/100:$this->column_bp_width_arr[$this->column_level][$bp]*$maxlimit/100;
				    
				 	 }
			else{//
				 
				$grid_temp=$this->grid_post_percent_arr[$bp]=$wid_grid_unit[$bp]/$gu*$this->column_total_net_width_percent[$this->column_level];
				$this->grid_width_chosen_arr[$bp]=(substr($bp,0,3)==='max')?$this->column_total_width[0]*$grid_temp/100:$grid_temp*$bp/100;
				$maxlimit=(substr($bp,0,3)==='max')?$bp:min($bp,$this->max_width_limit); 
				$this->grid_width_chosen_arr[$bp]=(substr($bp,0,3)==='max')?$this->max_width_limit*$grid_temp/100:$grid_temp*$maxlimit/100;
				$this->grid_width_available[$this->column_level][$bp]=(substr($bp,0,3)==='max')?$this->max_width_limit:$maxlimit;
					}
			###generate column_bp_width_arr for future posts in this column
			}//endelse post
		}//end foreach...
	# update the total bp array
	 
		//if (isset($_POST[$data.'_'.$type.'_grid_width'][0])||isset($_POST[$this->col_table.'_col_width'])||isset($_POST[$this->col_table.'_col_options']['.$this->column_use_grid_index.'])){
		if ($this->edit&&!$this->is_clone&&isset($_POST['submitted'])){//this is more relaxed
			$grid_width=substr_replace($grid_width,'',-1);
			if($type==='col'){ 
				 $q="update $this->master_col_table set col_width='".(floor($wid_grid_unit[$bp_arr[0]]/$gu*10000)/100)."', col_update='".date("dMY-H-i-s")."',col_time='".time()."',token='".mt_rand(1,mt_getrandmax()). "' where col_id=$this->col_id";
				 //removed col_grid_width='$grid_width',
				 }
			else   $q="update $this->master_post_table set blog_width='".(floor($wid_grid_unit[$bp_arr[0]]/$gu*10000)/100)."', token='".mt_rand(1,mt_getrandmax()). "',blog_update='".date("dMY-H-i-s")."',blog_time='".time()."' where blog_id=$this->blog_id";//this is how we   keep current_net_width and current_net_width_percent current... with use of rwd...
	//removed blog_grid_width='$grid_width',		  
			$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
			} 
		if($this->is_clone&&!$this->clone_local_style){
			
			return;
			}
		 
		printer::printx('<p class="floatleft editbackground left '.$this->column_lev_color.'">Fine Tune the Width && Placement of this '.$colpost.' Display For Device Width Conditions (break points)</p>');
		printer::pclear();
		
		for ($i=0; $i<count($bp_arr); $i++){
			$bp=$bp_arr[$i];
			$curwid= floor($this->grid_width_chosen_arr[$bp]); 
			$cur_wid_avail=floor($this->grid_width_available[$this->column_level][$bp]);
			$curleft=floor($left_grid_unit[$bp]/$gu*$cur_wid_avail);
			$curright=floor($right_grid_unit[$bp]/$gu*$cur_wid_avail);
			
			echo '<div class="fsminfo editcolor editbackground" ><!--wrap bp line of choices-->';
			 $msg=(substr($bp,0,3)==='max')?'View Screen Over: '.$bp_arr[1].':':'Max Wid Screen:'.$bp.':';
			echo '<span class="bold">'.$msg."</span> total {$gu} gu/row<br>";
			echo '<p class="floatleft navybackground white .pl10"><!--Bp class choice-->     
			Width:
			<select class="editcolor editbackground"  name="'.$data.'_'.$type.'_grid_width['.$i.']">        
			<option   value="'.$wid_grid_width[$bp].'" selected="selected">'.(floor($wid_grid_unit[$bp]/$gu*10000)/100).'% &nbsp;: &nbsp;'.$wid_grid_unit[$bp].' gu : '. $curwid.'px</option>';
			
			for ($num=0; $num<$gu+1; $num++){
			   echo '<option  value="'.$select_wid_arr[$bp][$num].'">'.(floor($num/$gu*10000)/100).'% &nbsp;: &nbsp;'.$num.' gu&nbsp;:&nbsp;'.($cur_wid_avail*$num/$gu).'px</option>';
			   }
			echo'	
			</select> </p><!--Bp class choice-->';
			 printer::pclear(15);
	
	#&&&&&&&&&&&&&&&&&&& Begin  Left  
			$msg2='Left Space:';
			echo '<p class=" smallest" title="Add Spacing To The Left of This Post For The Given Breakpoint . Useful for tweaking Post Width For Different Size Groupings. Space added is Outside of Borders and Background Features if used. Analogous to Margins"><!--Bp class choice-->     
			'.$msg2.'
			<select class="editcolor editbackground"  name="'.$data.'_'.$type.'_gridspace_left['.$i.']">        
			<option   value="'.$left_grid_width[$bp].'" selected="selected">'.(floor($left_grid_unit[$bp]/$gu*10000)/100).'% :'.$left_grid_unit[$bp].'gu : '. $curleft.'px</option>';
			for ($num=0; $num<$gu; $num+=.5){
				$num2=(strpos($num,'.5')===false)?$num:str_replace('.5','',$num).'x5';
				
				echo '<option  value="'.$select_left_arr[$bp][$num2].'">'.(floor($num/$gu*10000)/100).'% &nbsp;: &nbsp;'.$num.' gu/'.$gu.'gu :&nbsp;'.($cur_wid_avail*$num/$gu).'px</option>';
			   }
			echo'	
			</select> </p><!--Bp class choice-->';
			printer::pclear();
	#&&&&&&&&&&&&&&&&&&&		end left spacing
	#&&&&&&&&&&&&&&&&&&&  begin  Right 
			$msg2='Right Space:'; 
			//$this->show_more('Add RWD Spacing','','italic smallest  ml10 underline info','Add RWD Left and Right Spacing for this post and Width Condition');
			//echo '<div class="fsminfo"><!--Spacing Rwd Wrap-->';
			
			echo '<p class=" smallest" title="Add Spacing To The Left or Right of This Post For The Given Breakpoint. Space added is Outside of Borders and Background Features if used. Will add to total gu use. See gu table for totals.  Analogous to Margins"><!--Bp class choice--><span class="info center">Add Left/Right Spacing (between posts)</span><br>      
			'.$msg2.'
			<select class="editcolor editbackground"  name="'.$data.'_'.$type.'_gridspace_right['.$i.']">        
			<option   value="'.$right_grid_width[$bp].'" selected="selected">'.(floor($right_grid_unit[$bp]/$gu*10000)/100).'% &nbsp;: &nbsp;'.$right_grid_unit[$bp].' gu : '. $curright.'px</option>';
			for ($num=0; $num<$gu; $num+=.5){
				$num2=(strpos($num,'.5')===false)?$num:str_replace('.5','',$num).'x5';
				echo '<option   value="'.$select_right_arr[$bp][$num2].'">'.(floor($num/$gu*10000)/100).'% &nbsp;: &nbsp;'.$num.' gu :&nbsp;'.($cur_wid_avail*$num/$gu).'px</option>';
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
		
		echo '</div><!--Wrap Post class config-->';
	#&&&&&&&&&&&&&&&&&&&&&&&&&&  END CLASS QUERY FOR  ACTIVE RWD POSTS  &&&&&&&&&&&&&&&&&&
	}//end ion rwd_build
	
 
  
 #render show list without enumerated values.... just show all!!
 

#style#
#$style_field is the name of the sql field holding raw style data
#$this->style_field is the raw data itself
#css_classname which is the classname to which the styling applies
#element  provides uniqueness to the name input etc. and also the style array (that is for non body non bodyview elements) holding the the final style rendering and also is used is as special reference for providing information on a particlular style grouping ie bodyview...
#the show list is the particlar style functions to render in order they written. If show list is empty the default function order from Cfg::Style_functions_order is used
#   the function iteself retrieves the css functions  and depending on the key sort order provided or by using the default order, it determines from the relative key value of the function needed to pipe the relevant style array value to.  ie  func  background will receive the style array value from the index ['background'].. The background function and others are where the styling editing for each style takes place and a css rule  generated for the particular values sent. These final css rules   are stored as final_style class variables  named in the general format of the particular "element_style_field_arrayed" format. Reference to the name of returned css value is passed to render_array using the element and css class reference. It also passes the class name reference  The render array is called upon at the close of the page by the method css_generate. Css_generate serves the purpose of collecting the various individual css rules for a given css class name and compiling them in one css statement. To do this the render array is then passed through foreach. Each resulting array provides Reference to a class name   and reference to the style array the gives the collected css values ie;   background:#ffffff;  and color:#aaaaa; All css values for a give classname are collected and rule applied.   the css name may be further modified according to $css_ext if used 
	
function edit_styles_close($element,$style_field,$css_classname,$show_list='',$mod_msg="Edit styling",$show_option='',$msg='',$use_percent=true,$clone_option=true,$show_text=false){
	$this->pelement=$css_classname;
	$this->show_text_style=$show_text;
	$use_percent=false;
	$show_option=(empty($show_option)&&$style_field!=='blog_style')?'noback':'';
	$this->use_percent=$use_percent; 
	if(!$this->edit||Sys::Printoff||Sys::Styleoff||Sys::Quietmode||$this->styleoff|| Sys::Custom)return;
	if ($this->is_clone&&!$this->clone_local_style)return;
	(Sys::Deltatime)&&$this->deltatime->delta_log(__LINE__.' @ '.__method__.'  ');   
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
	 
	else {//error
		 $msgx='Array key does not exist'.$element. ' is element'.Sys::error_info(__LINE__,__FILE__,__METHOD__);
		 $this->message[]=$msgx;
		 mail::alert($msgx);
		return; 
		}
	printer::pclear(2);  
	 if ($this->is_page|| ($this->is_blog&&!$this->is_clone)||($this->is_column&&!$this->is_clone||$this->clone_local_style)){
		$globalstyle=($this->is_blog&&$this->blog_global_style==='global')?$this->column_lev_color.' floatleft border9 borderinfo shadowoff editbackground glowbutton'.$this->column_lev_color:'';
		$this->show_more($mod_msg,$show_option,$globalstyle,'',550);
		echo '<div class="shadowoff editbackground editfont maxwidth500 Os2ekblue fsminfo floatleft"  id="editstylewidth'.self::$styleinc.'t"><!--editfstylefullwidth open-->';
		 if(isset($this->render_view_css)&&count($this->render_view_css)>0){
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
			$this->display_style($type,$style_field,$id);	
			$this->show_more('Special Tag and Class Styles','','info tiny editbackground floatleft','Style text through the use of tags and classes with Styles set in page options');
			printer::array_print($this->render_view_css); 
			$this->show_close('View Current Tag and Class Styles');
			}
		$class=($this->pelement=='body')?'body':$this->pelement;
		
		$type_ref=($this->is_page)?'Page Ref: "'.$this->tablename.'"':(($this->is_column)?'Col Id: "C'.$this->col_id.'"':'Post Id: "P'.$this->blog_id.'"');
		printer::printx('<p class="fsminfo smaller editbackground editcolor">Class Name: <span class="'.$this->column_lev_color.'">'.$class.'</span><br>'.$type_ref.' Style Field: <span class="'.$this->column_lev_color.'"> '.$style_field.'</span></p>');
		(!empty($msg))&&printer::printx('<p class="fsminfo editbackground editcolor floatleft">'.$msg.'</p>');
	 
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
				$this->show_more('Globalize this styles');
				echo '<div class="fsminfo editbackground editcolor"><!--globalize style wrap-->';
			
				printer::printx('<p class="tip ">These styles made here will be applied to all '.$this->blog_type.' posts within this column.  Styles made in the individual posts will override these. Any Previous Globalized '.$this->blog_type.' styles will be removed.</p>');
				printer::printx('<p class="'.$this->column_lev_color.' editbackground"><input type="checkbox" name="'.$this->data.'_blog_global_style" value="global">Globalize these Styles</p>');
				printer::printx('<p class="'.$this->column_lev_color.' editbackground"><input type="checkbox" name="delete_global_styles_'.$this->data.'_'.$style_field.'" value="delete"  onchange="edit_Proc.oncheck(\'delete_global_styles_'.$this->data.'_'.$style_field.'\',\'SIMILAR STYLES OF SAME TYPE POSTS WITHIN PARENT COLUMN WILL BE DELETED WHEN YOU HIT CHANGE, UNCHECK TO CANCEL\')">Delete this style grouping in all other posts within this same column. Will remove all corresponding   post styles made in the other type '.$this->blog_type.' posts only. </p>');
				
				echo '</div><!--globalize style wrap-->';
				$this->show_close('Globalize this '.$this->blog_type.' within Column');
				}// option not global
			else {
				 
				$this->show_more('Undo Globalize these styles');
				echo '<div class="fsminfo editbackground editcolor"><!--globalize style wrap-->';
			
				printer::printx('<p class="tip ">These styles made here will longer be applied to all '.$this->blog_type.' posts within this column. </p>');
				printer::printx('<p class="'.$this->column_lev_color.' editbackground"><input type="checkbox" name="'.$this->data.'_blog_global_style" value="0">Check this box to Undo Globalize these Styles</p>');
				printer::printx('<p class="'.$this->column_lev_color.' editbackground"><input type="checkbox" name="delete_global_styles_'.$this->data.'_'.$style_field.'" value="delete"  onchange="edit_Proc.oncheck(\'delete_global_styles_'.$this->data.'_'.$style_field.'\',\'SIMILAR STYLES OF SAME TYPE POSTS WITHIN PARENT COLUMN WILL BE DELETED WHEN YOU HIT CHANGE, UNCHECK TO CANCEL\')">Delete this style grouping in all other posts within this same column. Will affect this style in other type '.$this->blog_type.' posts only. </p>');
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
	foreach ($function_order as $index){   
		$i=$this->{$index.'_index'};
		(Sys::Deltatime)&&$this->deltatime->delta_log('Begin EditStyle function: '.$functions[$i]);
		$this->{$functions[$i]}($style,$i,$style_field);  #this calls the functions.... 
		(Sys::Deltatime)&&$this->deltatime->delta_log('End Function : '.$functions[$i]);
		printer::pclear();
		 
		} 
	 #styleclone
		if ($this->is_blog&&!$this->is_clone&&$clone_option&&!$this->clone_local_style){ 
			 
				
			$this->show_more('Copy Style Settings','noback','italic info editbackground editfont floatleft underline','Copy all the styles from a previoulsy styled Post by entering the id  here.');
			printer::print_wrap('copy styles','editbackground');
			 echo '<div class="'.$this->column_lev_color.' floatleft left editbackground editfont fsminfo "><!--global clone field blog-->';
			printer::printx('<p class="floatleft fsminfo editcolor editbackground editfont">Blog Id: P'.$this->blog_id.'&nbsp;&nbsp;&nbsp;Style Field: '.$style_field.'</p>');
			printer::pclear(10);
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
			printer::alertx('<p class="floatleft editbackground editcolor">Enter a Post Id to copy this <span class="info edit" title="Specifically all styles similarly grouped under field '.$style_field.'"> Grouping of Styles</span> Here
					  <input  type="text" name="globalize_style_copy['.$this->blog_id.']['.$style_field.']"  size="7" maxlength="7" value=""> '); 
			echo '</div><!--global clone field blog-->';
			
			$this->clipboard('blog',$this->blog_id,$style_field);
			printer::close_print_wrap('copy styles');
			$this->show_close('Style Copy Settings');
			}//end is blog
			
		if ($this->is_column&&!$this->is_clone&&$clone_option&&!$this->clone_local_style){ 
				
			$this->show_more('Column Style Copy','noback','italic info editbackground editfont floatleft underline','Copy all the styles from a previoulsy styled element by entering the id here.');
			 echo '<div class="'.$this->column_lev_color.'floatleft left editbackground editfont"><!--global clone field column-->';
			 printer::printx('<p class="fsminfo editbackground editcolor editfont">Column Id: C'.$this->col_id.'&nbsp;&nbsp;&nbsp;Style Field: '.$style_field.'</p>');
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
			printer::alertx('<p class="editcolor editbackround editfont">Enter a Column Id (ie. C44) to copy its <span class="info" title="Specifically all styles similarly grouped under field '.$style_field.'"> Collection of Styles</span> Here
						  <input  type="text" name="globalize_style_copy['.$this->col_id.']['.$style_field.']"  size="7" maxlength="7" value=""> '); 
			echo '</div><!--global clone field column-->';
			
			$this->clipboard('col',$this->col_id,$style_field);
			$this->show_close('Column Style Copy');
			}//end is column 
			 
			 
		if ($this->is_page&&$clone_option&&!$this->clone_local_style){  
			$this->show_more('Page Style Copy','noback','italic info editbackground editfont floatleft underline','Copy all the styles from a previoulsy styled Page by entering page ref  here.');
			printer::print_wrap('page style','editbackground Os3salmon fsminfo');
			printer::printx('<p class="fsminfo editbackground editfont editcolor">Page Ref: '.$this->tablename.'&nbsp;&nbsp;&nbsp;Style Field: '.$style_field.'</p>');
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
				}  
				$included_arr=array();
				$q="select distinct page_ref, page_title, page_filename from $this->master_page_table";  
				$r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
				 while (list($page_ref,$title,$filename) = $this->mysqlinst->fetch_row($r,__LINE__)){
					$included_arr[]=array($page_ref,$title);
					}
				echo'<p class="editcolor editbackground">Choose Page for Import of '.$style_field.' Styles <select class="editcolor editbackground"  name="globalize_style_copy['.$this->page_ref.']['.$style_field.']">';       
			    echo '<option  value="none" selected="selected">Choose Page </option>';
				 for ($i=0;$i<count($included_arr);$i++){
					  echo '<option  value="'.$included_arr[$i][0].'">'.$included_arr[$i][1].'</option>';
					  }
			    echo'	
			    </select></p>'; 
						 
			echo '</div><!--global clone field column-->';
			$this->clipboard('page',$this->page_id,$style_field);
			printer::close_print_wrap('page style');
			$this->show_close('Page Style Copy');
			}//end is page	 
			 
			  
	printer::pclear();
	
	if ($this->is_page|| ($this->is_blog&&!$this->is_clone)||($this->is_column&&!$this->is_clone||$this->clone_local_style)){  
		$this->submit_button();
		echo '</div><!--end ramanablock in edit styles close-->';
		$this->show_close($mod_msg);//<!--end plus more class="white relative hide" for Edit Styles Close-->';
		printer::pclear(2);   
		//echo'</fieldset><!--Edit Styles Close-->';
		}
	}//end edit_styles_close

function paste_from_clipboard(){//here we take clipboard and paste to checked posts... 
	foreach(array('col','page','blog')  as $type){
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
						break;
					case 'col':
						$table=$this->master_column_table;
						$field='col_id'; 
						break;
					case 'blog':
						$table=$this->master_post_table;
						$field='blog_id'; 
						break;
					default: return;
					}
				$q="update $table as p, $table as c set c.$f=p.page_clipboard  where p.page_clipboard !='' and c.$field='$id' and p.page_ref='$this->tablename'";  
				$this->mysqlinst->query($q);
				if ($this->mysqlinst->affected_rows()){
					$this->success[]="Field: $f  from $id pasted from clipboard";
					}
				else $this->message[]="Field: $f from $id failed to paste from clipboard";
					 
				}
			}
		}
	}
	 
function copy_to_clipboard(){ 
	if (count($_POST['copy_to_clipboard'])>1){
		printer::alert_neg('Only Copy 1 Style field to Clipboard with each submit');
		$q="update $this->master_page_table set page_clipboard='' where page_ref='$this->tablename'";
		$this->mysqlinst->query($q);
		return;
		}
	else{
		foreach(array('col','page','blog')  as $type){
			if (isset($_POST['copy_to_clipboard'][$type])){
				$data=$_POST['copy_to_clipboard'][$type];
				if (is_array($data)){ 
					return;
					}
				$data=$_POST['copy_to_clipboard'][$type];
				if (strpos($data,'@x@x')!==false){
					list($f,$id)=explode('@x@x',$data);  
					switch($type){
						case 'page' :
							$table=$this->master_page_table;
							$field='page_id';
							break;
						case 'col':
							$table=$this->master_column_table;
							$field='col_id';
							break;
						case 'blog':
							$table=$this->master_post_table;
							$field='blog_id';
							break;
						default: return;
						}
					$q="update $table as c, $table as p set c.page_clipboard=p.$f where p.$field='$id' and c.page_ref='$this->tablename'";  
					$this->mysqlinst->query($q);  
					if ($this->mysqlinst->affected_rows()){
						$this->success[]="Field: $field from $id copyied to clipboard";
						}
					else $this->message[]="Field: $field from $id did not change";
					}
				else  $this->message[]="Entry failed to copy to clipboard";
				}
			}	
		}
	}
	//if ($this->edit&&isset($_POST['copy_clipboard'
function clipboard($type,$id,$field){
	printer::print_wrap('global paste','Os3darkslategray fsmcolor');
	printer::print_tip('Copy to clipboard all the styles here or paste all the clipboard styles here replacing all current styles! Allows you to copy between different fields. Note:Copying from one style and Pasting on another results in the latest paste being the one copied. Only styles normally expressed here will be utilized. Only one Copy to clipboard event will be registered');
	printer::alert('Current Clipboard styles: <br>');
	 $this->display_style('page','page_clipboard',$this->page_id);
	printer::alert('<input type="text" value=""  size="6" maxlength="6" name="paste_from_clipboard['.$type.']['.$field.'@x@x'.$id.'][]">Type the word "paste" into into box to paste the current clipboard replacing these styles');
	printer::alert('<input type="checkbox" value="'.$field.'@x@x'.$id.'" name="copy_to_clipboard['.$type.']">Check here to copy these styles to current clipboard (Only one copy event will be registered)');
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
	//$q="Delete from $this->master_post_css_table Where css_table_base='$this->tablename' and css_type='gen'";
	//$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
				
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
		//$style_edit=$css_classname.' textarea';
		 
	     $this->css.="\n".'  '.$style_css .'{';
	     $css="\n".'  '.$style_css .'{';
		//$this->editcss.="\n".'  '.$style_edit .'{'; 
		//$editcss="\n".'  '.$style_edit .'{';
		$count=count(explode(',',Cfg::Style_functions)); 
		array_splice($this->$style, $count);//trim appendages..
		foreach ($this->$style as $genstyle){
			if (strpos($genstyle,'@@')!==false)continue;
			if (!empty(trim($genstyle))) {
				$this->css.=$genstyle.' ';  
				$css.=$genstyle.' ';
				}
			
			} //end foreach
			 
		$this->css.='}
		';
		
		$css.='}';
		$this->id_class=false;//set back to false: set true if you wish to use # instead of .
		$advanced= (array_key_exists($css_classname,$this->advancedstyles)&&!empty($this->advancedstyles[$css_classname]))?NL.$this->advancedstyles[$css_classname]:'';
		
		($element==='bodyview')&&$this->css_view[]=$css. $advanced;//for previewing special tags and classes styling only
		(Sys::Deltatime)&&$this->deltatime->delta_log('After Insert '.__LINE__.' @ '.__method__.'  ');
		} //end foreach
	 	
	file_put_contents(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'css_data_sheet_'.$this->tablename.$this->passclass_ext,serialize($this->css_view));//for previewing special tags and classes styling only
	(Sys::Deltatime)&&$this->deltatime->delta_log('End of '.__LINE__.' @ '.__method__.'  ');
	
	}

function display_style($type,$field,$id){
	static $inc=0; $inc++;
	$show_msg='Display Styles';
	$this->show_more($show_msg,'','info editbackground left floatleft smallest','Sent request for Styling Info breakdown of this current style');
	echo '<p class="info Os3darkslategray fsmyellow editbackground click floatleft" title="View Chosen Styles" onclick="gen_Proc.use_ajax(\''.Sys::Self.'?display_styles='.$type.'@@'.$id.'@@'.$field.'&amp;display_id=display_styles_'.$inc.'\',\'handle_replace\',\'get\');" >Click to display Parsed Styles</p>';
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
	if (!$this->is_blog){ 
		return;
		}   
	$class=($this->current_net_width<100)?'supersmall':'smaller';
	echo '<div class="shadowoff fs2'.$this->column_lev_color.' editbackground left5 right5 floatleft editfont" style="max-width:'.$this->current_net_width.'px;"><!--edit styles open-->';
	$a='Post#'.$this->blog_order_mod.' in Col#'.$this->column_order_array[$this->column_level];
	$b='<span class="'.$class.'">Type: '.strtoupper(str_replace('_',' ',$this->blog_type)).'</span>';
	$c="Post Id: P$this->blog_id";
	if ($this->blog_unstatus==='unclone'){
		$this->show_more('Mirror Release Info','','info underline italic small editbackground');
		if ($this->orig_val['blog_type'] ==='nested_column')
			printer::print_info('The Original Column post which was indirectly cloned then unmirrored here is from is page_ref: '.$this->orig_val['blog_table_base'].'  and is Col Id:'.$this->orig_val['blog_data1'].'. If doing a template tranfer include this column in your template and you will automatically include this content from this current column here!');
		else printer::print_info('The Original '.$this->orig_val['blog_type'].' Post which was indirectly cloned then unmirrored here is from page_ref: '.$this->orig_val['blog_table_base'].'  and is Post Id:'.$this->orig_val['blog_id'].'. If doing a template tranfer include this Post in your new template and you will automatically include this content from this current Post here!');
		$this->show_close('From Info');
		}
	($this->blog_unstatus=='unclone')&&printer::alert('Mirror release Post','','orange left ');
	printer::alert($a.NL.$b,'',$this->column_lev_color.' left ');
	printer::alertx('<p class="info left" title="The Unique '.$c.' Would Be Used for Copying/Cloning/Moving this Post Elsewhere. For Styles look for '.$this->data.'">'.$c.'</p>');
	echo '</div><!--end edit style open-->';
		
	printer::pclear(2);
	}
 
function misc($data){echo 'under construction'; return;  //outdated option
	//($this->edit)&&$this->edit_styles_open();
	 ($this->edit)&&    
			 $this->blog_options($data,$this->blog_table);
	if ($this->edit){
		printer::print_tip('100% length width or height line separators between posts may be created when styling borders in each Post styling options.   Choose top bottom left or right side.<br>  Here, create a horizontal svg line  and choose  percentage of available width  to begin or end the line');
		$startx=$endx=$colorx=$widthx=0;
		$this->show_more('Create a Line Here');
		printer::print_wrap('create line');
		printer::print_wrap('create start line','fs1black');
		printer::alert('Choose Starting Percentage of Line');
		$this->mod_spacing($data.'_blog_tiny_data1',$startx,1,100,1,'%');
		printer::close_print_wrap('create start line');
		printer::print_wrap('create end line','fs1black');
		printer::alert('Choose Starting Percentage of Line');
		$this->mod_spacing($data.'_blog_tiny_data2',$endx,1,100,1,'%');
		printer::close_print_wrap('create end line');			    
		printer::print_wrap('choose line width','fs1black');
		printer::alert('Choose Line Width');
		$this->mod_spacing($data.'_blog_tiny_data3',$widthx,1,100,1,'px');
		printer::close_print_wrap('choose line width');			    
		printer::print_wrap('choose line color','fs1black');
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
	 
	//$this->edit_styles_close($data,'blog_style','.'.$data, $style_list ,"Add Additional Background Styling Features Here");
	}
	
	
#textarea    
function textarea($dataname,$name,$width,$fontsize=16,$turn_on='',$float='left',$percent=90,$inherit=false,$class=''){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	$styling=($inherit)?'background:inherit;color:inherit;':'background:#'.$this->editor_background.';color:#'.$this->editor_color.';';
	$display_editor=($turn_on)?'mytextarea ':'';
	$cols= 'cols="'.(process_data::width_to_col($width,$fontsize)).'"'; 
	//$width= (empty($colsoff))?'width:100%; ':'';
	$data=(isset($this->$dataname))?$this->$dataname:$dataname;    
	$rowlength=(!empty($data))?process_data::row_length($data,$cols):3;
	//$height='';
	echo '<textarea style="'.$styling.'width:'.$percent.'%; float:'.$float.';" class="'.$class.' scrollit '.$display_editor.' fs1'.$this->column_lev_color.'" name="'.$name.'" rows="'.$rowlength.'" onkeyup="gen_Proc.autoGrowFieldScroll(this)">' . process_data::textarea_validate($data).'</textarea>'; 
	}
 	
#text
function text_render($data,$tablename='',$style_list='',$columns=20,$style_open=true){
	static $myinc=0; $myinc++;
	$cols=(!empty($this->current_net_width))?process_data::width_to_col($this->current_net_width,$this->current_font_px):$columns; 
	$display_editor=($this->blog_options[$this->blog_editor_use_index]==='use_editor')?'enableTiny ':'divTextArea';
	 
	$rowlength=($cols<3)?3:process_data::row_length($this->blog_text,$cols); 
	  
	($this->edit)&&$this->edit_styles_open();//
	($this->edit)&&    
			$this->blog_options($data,$this->blog_table);
	 if (!empty($this->blog_text)){
		if (!$this->edit){
			echo process_data::clean_break($this->blog_text);
			 return;
			}
		elseif($this->is_clone&&!$this->clone_local_data)echo process_data::clean_break($this->blog_text);
		} 
	if ($this->edit&&(!$this->is_clone||$this->clone_local_data)){
		
		//$data=($this->is_clone)?'clone_'.$data:$data;
		$print=($this->blog_options[$this->blog_editor_use_index]==='use_editor')?'':
		'<div class="'.$this->column_lev_color.' floatleft cursor smallest editbackground shadowoff rad3 button'.$this->column_lev_color.'" onclick="edit_Proc.enableTiny(this,\''.$data.'_blog_text\',\'divTextArea\');">Use Tiny</div>';
		echo $print;
		 
		printer::pclear(7);
		$this->blog_text=(strlen($this->blog_text)<2||$this->blog_text==='&nbsp;')?'Enter text here':$this->blog_text;
		echo'<div id="'.$data.'_blog_text" class="'.$display_editor.' '.$data.'" >'.process_data::clean_break($this->blog_text).'</div>';// show initial non text area non editor text !
		$blog_text=($this->blog_options[$this->blog_editor_use_index]==='use_editor')?process_data::textarea_validate($this->blog_text):process_data::textarea_validate(process_data::remove_html_break($this->blog_text));
		 
		echo '  
		 <textarea style="background:inherit; display: none; width:100%"  id="'.$data.'_blog_text_textarea"   class="scrollit '.$data.'" name="'.$data.'_blog_text" rows="'.$rowlength.'" cols="'.$cols.'" onkeyup="gen_Proc.autoGrowFieldScroll(this);">' .$blog_text.'</textarea>';
		}//if edit
		#ok here if marked as global the results of these styles choices will directly style this blog type but also the parent column.text..  as shown...
	$type=$this->blog_type;
	$global_field=($this->blog_global_style==='global')?',.'.$this->clone_ext.$this->col_table.' .'.$type:'';
	$this->edit_styles_close($data,'blog_style','.'.$data.'.'.$type.$global_field, $style_list ,$this->styler_blog_instructions. 'Post#'.$this->blog_order_mod.' Col#'.$this->column_order_array[$this->column_level]);
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
				$msg.='<br>'.$comment_name." has sent a comment post to your post id$this->blog_id on page $this->tablename  "; 
				$msg.='<br> Visit the editpage to delete or accept comments or click the links below';
				$msg.='<br><a style="color:red" href="http://'.$site.'?remove_'.$this->blog_id.'='.$comment_token.'&amp;msg=Comment from '.$comment_name.' has been Deleted">Click Here To Delete This Comment</a>';
				$msg.='<br>'.$comment_name; 
				$msg.='<br> comment text is :';
				$msg.='<br>'.$comment_text;
				$msg.='<br> comment email is :';
				$msg.='<br>'.$comment_email;
				$msg.='<br><br> <a style="color:green;" href="http://'.$site.'?accept_'.$this->blog_id.'='.$comment_token.'&amp;msg=Comment from '.$comment_name.' has been approved">Click Here To Publish This '.$this->comment.'</a>';
				$msg.='<br>Message(s)  sent to: '.Cfg::Contact_email;
				process_data::write_to_file('test.txt',$msg); 
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
		 //$this->show_more('Leave '.$this->comment.' Here','slow','click pos smaller style_comment_view','asis');
		 echo '<p onclick="gen_Proc.showIt(\''.$data.'_show\');" class="click pos smaller style_comment_view">Leave '.$this->comment.' Here</p>';
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
		printer::printx('<textarea   id="comment_text_'.$this->blog_id.'" class="width100 editbackground fs1'.$this->column_lev_color.'" name="comment_text['.$this->blog_id.']" rows="3"    onkeyup="gen_Proc.autoGrowFieldScroll(this);"></textarea>');
		echo '</div><!--leave comment-->';
		forms::form_close('','Submit '.$this->comment,'feedback_submit');
		 $this->show_close('Leave '.$this->comment.'');
		}//!edit and leave feedback	 
	if ($count>0 || ($this->edit&&$accept_count>0)){
		if($this->edit){
			printer::pclear();
		$this->show_more('Accept/Remove Comments');
			printer::pclear(); 
			printer::printx('<p class="editcolor editbackground fsminfo editbackground">Specific Styles for Comments may be set for all posts under the  column master settings or page config settings.  Immediate Columns Settings if set will override page and parent column settings</p>');
			printer::pclear();
			}
		$q="select com_id,com_name,com_email,com_text,com_status,com_time from $this->comment_table where com_blog_id='$this->blog_id' order by com_time DESC";  
		$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
		#commentdisplay
		
		($this->edit)&&printer::print_wrap('wrap edit comments','editbackground editcolor Os3 fsminfo');
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
				(!$status)&&printer::printx('<p class="editbackground editcolor editfont"><input type="checkbox" name="comment_accept['.$this->blog_id.']['.$com_id.']" value="'.$name.'"><span class="bold white posbackground">Accept New '.$this->comment.' </span></p>');
				printer::printx('<p class="editbackground editcolor editfont"><input type="checkbox" name="comment_remove['.$this->blog_id.']['.$com_id.']" value="'.$name.'"><span class="white bold redAlertbackground">Remove New Feedback </span></p><br>');
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
			.'.$data.' input{max-width:250px;}
			}
		@media screen and (max-width: 350px){
			.'.$data.' input{max-width:200px;}
			}
		@media screen and (max-width: 300px){
			.'.$data.' input{max-width:160px;}
			}';
		}
	}//end comment_display
	
	
	
function edit_vid($data,$vidinfo,$viddir=Cfg_loc::Root_dir){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	$vidfield='blog_data3';
	$picfield='blog_tiny_data1';
 	$datavid=$data.'_'.$vidfield;    
	$datapic=$data.'_'.$picfield;
	$field=(empty($field))?$data:$field;#this accomodates the blog which is not the $data as with normal pages
	$tablename=(empty($tablename))?$this->tablename:$tablename; #this accomodates the blog whose table name is not this tablename
	if (!$this->edit)return;
	list($vidname,$width,$aspect)=process_data::process_vid($vidinfo);
	printer::pclear();
	echo'<div class="editbackground floatleft"><!--Video Loader-->';
	echo'<p class="editcolor editbackground editfont">Change Video to a Previously Uploaded video<br>:<input style="cursor:pointer;background:#'.$this->editor_background.';color:#'.$this->editor_color.';" name="'.$datavid.'[0]" value="'.$vidname.'" size="40"></p>';
	//echo'<p class="editcolor editbackground editfont">Change Width of Video Player:<input style="cursor:pointer;background:#'.$this->editor_background.';color:#'.$this->editor_color.';" name="'.$datavid.'[1]" value="'.$width.'" size="4"></p>';
	//echo'<p class="editcolor editbackground editfont">Change Width over Height Ratio  of Video Player: :<input style="cursor:pointer;background:#'.$this->editor_background.';color:#'.$this->editor_color.';" name="'.$datavid.'[2]" value="'.$aspect.'" size="4"></p>';
	//echo'<p class="editcolor editbackground editfont"> <a href="add_page_vid.php?www='.$this->current_net_width.'&amp;ttt='.$tablename.'&amp;fff='.$vidfield.'&amp;id='.$this->blog_id.'&amp;id_ref=blog_id&amp;pgtbn='.$this->tablename.'&amp;postreturn='.Sys::Self.'&amp;css='.$this->roots.Cfg::Style_dir.$this->tablename.'&amp;sess_override&amp;sess_token='.$this->sess->sess_token.'">Upload to Change to a New Video</a></p>';
	printer::pspace(15);
	if (strpos($vidname,'wmv') ) printer::alert('WMV videos do not current support displaying a Still Picture Frame',false,''.$this->column_lev_color.' editfont neg');	  
	elseif (strpos(strtolower($vidname),'.swf')===false)
		{
		echo '<fieldset><legend>STILL IMAGE LOADER for video file types</legend>';
		 $this->show_more('Add Video Still Image','Close Add Image','info editbackground','Video Still Images Will Display Image Before Video is Played. ',500);
		printer::alertx('<p class="editcolor editbackground editfont">Change Image to Previously Uploaded image:<input style="cursor:pointer;background:#'.$this->editor_background.';color:#'.$this->editor_color.';" name="'.$datapic.'" value="'.$this->blog_tiny_data1.'" size="40"></p>'); 
		printer::alertx('<p class="left editbackground editcolor"><a class="infoclick" title="Click here to Upload a New  Display Image for the video player (displays before video is Started otherwise could be blank screen)" href="add_page_pic.php?vidname='.$vidname.'&amp;addvid=1&amp;wwwexpand=0&amp;www='.$this->current_net_width.'&amp;ttt='.$this->blog_table.'&amp;fff='.$picfield.'&amp;id='.$this->blog_id.'&amp;id_ref=blog_id&amp;pgtbn='.$this->tablename.'&amp;postreturn='.Sys::Self.'&amp;css='.$this->roots.Cfg::Style_dir.$this->tablename.'&amp;sess_override&amp;sess_token='.$this->sess->sess_token.'">UPLOAD a Starter Image for YOUR VIDEO PLAYER</a></p>');
		$this->show_close('Add Video Still Image');
		echo '<//*fieldset*/></div><!--Video Loader-->';
		
		printer::pclear();
		}
	}
	
 

function edit_form_head(){   if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__); 
   
	 echo'<form action="'.Sys::Self.'" ' .$this->form_load.' method="post" '.$this->onsubmit.'> ';
	 
    }
 
 
#video	
function video_post($data,$vidinfo,$viddir=''){
	$full_replace=false;
	$this->edit_styles_open();
	($this->edit)&&    
			$this->blog_options($data,$this->blog_table);
	 
	if  (!$this->edit||$this->blog_table_base!=$this->tablename){
		if($this->blog_data1==='vid_upload'){
			$vidfield='blog_data3';
			$picfield='blog_tiny_data1';
			list($vidname,$width,$height)=process_data::process_vid($vidinfo);  
			$image=(is_file(Cfg_loc::Root_dir.Cfg::Vid_image_dir.$this->$picfield))?Cfg_loc::Root_dir.Cfg::Vid_image_dir.$this->$picfield:''; #pic in   vid in Cfg::Vid_fir
			$video=video_master::instance();
			echo '<div class="video_resize">';
			$video->render_video($vidname,$image,$width,$height,$viddir,$this->blog_data5);//blog info currently used for flv autoplay
			echo '</div>';
			}
		 
		else	if($this->blog_data1==='iframe_embed'){ 
			$embed= (strpos($this->blog_data4,'iframe')===false&&strpos($this->blog_data4,'object')===false)?'<iframe src="'.$this->blog_data4.'"  width="100%"  frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>':$this->blog_data4;;
			//echo '<div class="video_resize">';
			echo '<div class="video-container"><div>'.$embed.'</div></div>';
			//echo '</div>';
			}
		else printer::alert_neg('Video Coming Soon');
		}//endif not edit
	if (!$this->edit)return; 
	$preg_match=''; 
	 
	if ($this->blog_data1==='iframe_embed'&&strlen($this->blog_data4)>30){//check to resize iframe
		 
		if (strpos($this->blog_data4,'height')!==false){
			#we are not replacing now .. instead will override with css in absolute pos element
			$preg_match_w='/width="(\d*)/';
			//preg_match($preg_match,$this->blog_data4,$matches);
			//$width = $matches[1];
			$preg_match_h='/height="(\d*)/';
			//preg_match($preg_match,$this->blog_data4,$matches);
			//$height = $matches[1];
			//if ($width >75&&$height>75){
			
			if (false){//$width!=$this->current_net_width)
				$newwidth='100%'; round($this->current_net_width);
				//$ratio=$height/$width;
				$newheight=round($newwidth*$ratio);
				$replace=($full_replace)?'height="'.$newheight:'';
				
				$this->blog_data4=str_replace($replace,$this->blog_data4);
				$replace=($full_replace)?'width="'.$width:'';
				
				$this->blog_data4=str_replace($replace,$this->blog_data4);
				}
			elseif (false){
				$this->blog_data4=preg_replace($preg_match_h,'',$this->blog_data4);
				$this->blog_data4=preg_replace($preg_match_w,' width="100%' ,$this->blog_data4);
				$q="update $this->master_post_table set blog_data4='$this->blog_data4',token='". mt_rand(1,mt_getrandmax())."',blog_time='".time()."' where blog_id='$this->blog_id'";	
				$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
				//$this->success[]="Your iframe has been size adjusted in Post Id$this->blog_id";
				}
			}
		//else $this->message[]='Manually Ajust Iframe/Object embed to width and height Requirement';
		 //}//end iframe_embed submit
		}// if iframeembed
	 
	if (isset($_POST[$data.'_blog_data4_vid'])){ 
		$newvid=trim($_POST[$data.'_blog_data4_vid']);
		$q="update $this->master_post_table set  blog_data1='iframe_embed',blog_data4='$newvid',blog_data2='',blog_data3='',token='". mt_rand(1,mt_getrandmax())."',blog_time='".time()."' where blog_id='$this->blog_id'"; 
		$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
		$this->success[]='Video Embed successfully Changed
		';
		$this->blog_data1='iframe_embed';
		$this->blog_data4=$newvid;	 
		}
		
		 
  
	if (!$this->is_clone){
		echo '<div class="fsminfo editbackground '.$this->column_lev_color.' floatleft"><!--Choose video Display--><p class="floatleft">Choose Video iframe/object embed (ie from youtube.com or Vimeo.com) or direct video upload. Other types of Iframes may also be displayed by using the first method. Video should autoadjust to the full post width using either method </p> ';
		printer::pclear();
		if ($this->blog_data1=='vid_upload')$this->show_more('Embed Video Code: ie Youtube.com','','','',500);
		 
		echo '<div class="fsminfo editbackground floatleft left '.$this->column_lev_color.'"><!--Iframe Embed Code-->Place Video/Other Embed code Here, ie from Vimeo or Youtube or other type of iframe or object code.  This method has widest support for all video types on all devices, ie. preferred method<br>Enter Video Iframe, Object (Embed code), or Full Url Only:';
		$this->textarea('blog_data4',$data.'_blog_data4_vid','600','16');
		printer::pclear();
		
		//$msg= ($this->blog_data7)?'<span style="font-weight:800;">REMOVE</span>':'<span style="font-weight:800;">ADD</span>';
		//$value= ($this->blog_data7)?0:1;
		//printer::printx('<input type="checkbox" value="'.$value.'" name="'.$data.'_blog_data7">Check here to '.$msg.' Auto Resize Option>');
		 echo '</div><!--Iframe Embed Code-->';
		if ($this->blog_data1=='vid_upload')$this->show_close('Embed Youtube/Other Video Code Options');
			printer::pclear(10);
		if ($this->blog_data1!=='vid_upload'){
			 $vidfield='blog_data3';
			 //$picfield='_data1';
			echo '<div class="fsminfo editbackground floatleft left '.$this->column_lev_color.'"><!--Upload File-->Or  Upload Video File. Takes mp4,  ogg, webm, m4v';
		echo'<p class="editcolor editbackground editfont  underline"> <a href="add_page_vid.php?www='.$this->current_net_width.'&amp;ttt='.$this->tablename.'&amp;fff='.$vidfield.'&amp;id='.$this->blog_id.'&amp;id_ref=blog_id&amp;pgtbn='.$this->tablename.'&amp;postreturn='.Sys::Self.'&amp;css='.Cfg_loc::Root_dir.Cfg::Style_dir.$this->tablename.'&amp;sess_override&amp;sess_token='.$this->sess->sess_token.'">Upload a Video File</a></p>';
		echo '</div><!--Upload File-->';
			printer::pclear();
			}
		echo '</div><!--Choose video Display-->';
			 
		
		if ($this->blog_data1=='vid_upload'){
			 $vidfield='blog_data3';
			 $picfield='blog_tiny_data1';
			list($vidname,$width,$height)=process_data::process_vid($vidinfo);  
			$image=(is_file(Cfg_loc::Root_dir.Cfg::Vid_image_dir.$this->$picfield))?Cfg_loc::Root_dir.Cfg::Vid_image_dir.$this->$picfield:''; #pic in root dir  vid in Cfg::Vid_fir
			$video=video_master::instance(); 
			printer::pclear(); 
			 $blog_data5=(!empty($this->blog_data5))?false:true;//for autoplay
			 $blog_show_change=(!empty($this->blog_data5))?"false":"true";
			 $blog_show_info=(!empty($this->blog_data5))?"true":"false";
			
			echo '<div class="editbackground fs1color floatleft"><!--border video edit-->';
			
			printer::printx('<p class="fsminfo editbackground '.$this->column_lev_color.' floatleft">Setting Autoplay to True will Cause the Video to Automaticaly Play Immediately! </p>');
			printer::pclear(2);
			printer::printx('<p class="editfont '.$this->column_lev_color.'">Autoplay Curently: '.$blog_show_info.'</p>');
			printer::pclear(2);
			printer::printx('<p class="editfont editcolor editclass editbackground"><input   type="checkbox" name="'.$data.'_blog_data5" value="'.$blog_data5.'" >&nbsp;Set Autoplay to '.$blog_show_change.'</p>');
			$this->edit_vid($data,$vidinfo,$viddir);
			#removed blog break for build video
			$video->render_video($vidname,$image,$width,$height,$viddir,false);//blog info currently used for flv autoplay
			printer::pclear();
			echo '<div class="fsminfo editbackground floatleft left '.$this->column_lev_color.'"><!--Upload File-->Change Video File. Takes mp4,  ogg, webm, m4v.';
		echo'<p class="editcolor editbackground editfont  underline"> <a href="add_page_vid.php?www='.$this->current_net_width.'&amp;ttt='.$this->tablename.'&amp;fff='.$vidfield.'&amp;id='.$this->blog_id.'&amp;id_ref=blog_id&amp;pgtbn='.$this->tablename.'&amp;postreturn='.Sys::Self.'&amp;css='.Cfg_loc::Root_dir.Cfg::Style_dir.$this->tablename.'&amp;sess_override&amp;sess_token='.$this->sess->sess_token.'">Upload a Different Video File:</a></p>';
		echo '</div><!--Upload File-->';
			echo '</div><!--border video edit-->';
			
			printer::pclear();
			}//if vid_upload
		}//if ! clone 
	$style_list='background,padding_top,padding_bottom,padding_left,padding_right,margin_top,margin_bottom,margin_left,margin_right,text_align,borders,box_shadow,outlines,radius_corner'; #do not display edit styling for padding top and bottom
	$global_field=($this->blog_global_style==='global')?',.'.$this->clone_ext.$this->col_table.' .'.$this->blog_type:''; 	
	$this->edit_styles_close($data,'blog_style','.'.$data.'.'.$this->blog_type.$global_field, $style_list ,'Style Video');
	
	 }
 
	
function padding_calc($field,$widmax,$total=true){// for caluculating  background image full size...
	$styles_arr=explode(',',$field); 
	$padding_left_percent=(array_key_exists($this->padding_left_index,$styles_arr)&&is_numeric($styles_arr[$this->padding_left_index]))? $styles_arr[$this->padding_left_index]:0;
	$padding_right_percent=(array_key_exists($this->padding_right_index,$styles_arr)&&is_numeric($styles_arr[$this->padding_right_index]))? $styles_arr[$this->padding_right_index]:0; 
	$padding_left_px=$padding_left_percent*$widmax/100;   
	 $padding_left_px=$padding_left_percent*$widmax/100; 
	$padding_right_px=$padding_right_percent*$widmax/100;
	$mytotal=$padding_left_px+$padding_right_px; 
	if ($total) return $mytotal;
	else return array($padding_left_px,$padding_right_px);
	}
	
function border_calc($styles){ 
	$styles=(is_array($styles))?$styles:explode(',',$styles);   
	$border_array=(array_key_exists($this->borders_index,$styles))?explode('@@',$styles[$this->borders_index]):array(); 
	for ($i=0; $i < 8; $i++){
		$border_array[$i]=(array_key_exists($i,$border_array))?$border_array[$i]:0;
		} 
	$border_sides=$this->border_sides;//aray of border types
	//$border_sides=array('No Border','top bottom left right','top bottom','top','bottom','left','right','top left','top right','bottom left','bottom right','left right'); 
	if (empty($border_array[0])||!is_numeric($border_array[0]))return array(0,0);// 
	else {
		$border_width=$border_array[0];
		switch ($border_array[3]) {
		case $border_sides[0]:# none 
				$border_width=0; 
				$border_height=0; 
				break; 
			case $border_sides[1]:# all;
				$border_height=$border_width*2;
				$border_width=$border_width*2;
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
				$border_height=0;
				$border_width=$border_width;
				break;
			case $border_sides[6]:# right
				$border_height=0;
				$border_width=$border_width;
				break;
			case $border_sides[7]:# top left
				$border_height=$border_width;
				$border_width=$border_width;
				break;
			case $border_sides[8]:# top right
				$border_height=$border_width;
				$border_width=$border_width;
				break;
			case $border_sides[9]:# bottom right
				$border_height=$border_width;
				$border_width=$border_width;
				break;
			case $border_sides[10]:# bottom left
				$border_height=$border_width;
				$border_width=$border_width;
				break;
			case $border_sides[11]:# left right
				$border_height=0;
				$border_width=$border_width*2;
				break;
			default:
			$border_width=8;
			}
		
		}
	return array($border_width,$border_height);
	
	}
	
function pad_mar_calc($styles){
	$styles=(is_array($styles))?$styles:explode(',',$styles);
	$padding_right=(!array_key_exists($this->padding_right_index,$styles))?0:((is_numeric(explode('@@',$styles[$this->padding_right_index])[0]))?explode('@@',$styles[$this->padding_right_index])[0]:0);
	$padding_left=(!array_key_exists($this->padding_left_index,$styles))?0:((is_numeric(explode('@@',$styles[$this->padding_left_index])[0]))?explode('@@',$styles[$this->padding_left_index])[0]:0);
	$margin_right=(!array_key_exists($this->margin_right_index,$styles))?0:((is_numeric(explode('@@',$styles[$this->margin_right_index])[0]))?explode('@@',$styles[$this->margin_right_index])[0]:0);
	$margin_left=(!array_key_exists($this->margin_left_index,$styles))?0:((is_numeric(explode('@@',$styles[$this->margin_left_index])[0]))?explode('@@',$styles[$this->margin_left_index])[0]:0);
	$padding_right_percent=(!array_key_exists($this->padding_right_percent_index,$styles))?0:((is_numeric(explode('@@',$styles[$this->padding_right_percent_index])[0]))?explode('@@',$styles[$this->padding_right_percent_index])[0]:0);
	$padding_left_percent=(!array_key_exists($this->padding_left_percent_index,$styles))?0:((is_numeric(explode('@@',$styles[$this->padding_left_percent_index])[0]))?explode('@@',$styles[$this->padding_left_percent_index])[0]:0);
	$margin_right_percent=(!array_key_exists($this->margin_right_percent_index,$styles))?0:((is_numeric(explode('@@',$styles[$this->margin_right_percent_index])[0]))?explode('@@',$styles[$this->margin_right_percent_index])[0]:0);
	$margin_left_percent=(!array_key_exists($this->margin_left_percent_index,$styles))?0:((is_numeric(explode('@@',$styles[$this->margin_left_percent_index])[0]))?explode('@@',$styles[$this->margin_left_percent_index])[0]:0);
	$total_pad=$padding_right+ $padding_left+$padding_right_percent*$this->current_total_width/100+$padding_left_percent*$this->current_total_width/100;
	$total_mar=$margin_right+$margin_left+$margin_right_percent*$this->current_total_width/100+$margin_left_percent*$this->current_total_width/100;;
	return array($total_pad,$total_mar);
	}

#calcshadow
#boxcalc #calcbox
function calc_border_shadow($styles){ 
	 //shadowbox_horiz_offset,shadowbox_vert_offset,shadowbox_blur_radius,shadowbox_spread_radius,shadowbox_color,shadowbox_insideout
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
 
function calc_image_height($preheight){  
	if ($this->rwd_post)return 1;
	$height_set=(!empty($this->blog_height)&&$this->blog_height>9&&$this->blog_height<1001)?$this->blog_height-$preheight:0;
	if (empty($height_set))return 1;
	list($picname,$alt)=process_data::process_pic($this->blog_data1);
	list($w,$h)=process_data::get_size($picname,Cfg_loc::Root_dir.Cfg::Upload_dir);
	 return  $height_set*($w)/$h;
	}

#buildpic
function build_pic($data,$picdir='',$style_ref='blog_style',$styles_open=true,$blog_options=true){
	$img_opt_arr=explode(',',$this->blog_tiny_data2);
	$img_opt='blog_tiny_data2';//may have to change from tinytext to full text
	$img_options=Cfg::Image_options; 
	$img_opt_tmp_arr=explode(',',$img_options);
	foreach ($img_opt_tmp_arr as $key => $index){
		${$index.'_index'}=$key;
		}
	for ($i=0; $i<count($img_opt_tmp_arr); $i++){
		$img_opt_arr[$i]=(array_key_exists($i,$img_opt_arr))?$img_opt_arr[$i]:0;
		} 
	$width_percent=($this->column_level>0)?$this->column_total_net_width_percent[$this->column_level]:100; 
	$image_min=(!empty($img_opt_arr[$image_min_index])&&$img_opt_arr[$image_min_index]>9&&$img_opt_arr[$image_min_index]<601)?$img_opt_arr[$image_min_index]:0;  
	(empty($picdir))&&$picdir=Cfg_loc::Root_dir.Cfg::Page_images_dir;
	list($picname,$alt)=process_data::process_pic($this->blog_data1);
	($this->edit)&&$maxplus=(!empty($img_opt_arr[$image_max_expand_index])&&$img_opt_arr[$image_max_expand_index]>50)?$img_opt_arr[$image_max_expand_index]:((is_numeric($this->page_options[$this->page_max_expand_image_index])&&$this->page_options[$this->page_max_expand_image_index]>50)?$this->page_options[$this->page_max_expand_image_index]:Cfg::Page_pic_expand_plus);
	$this->edit_styles_open();
	
	($this->edit)&&    
			$this->blog_options($data,$this->blog_table);
	printer::pclear();
	if ($img_opt_arr[$image_noresize_index]==='noresize'){
		$image_noresize=true;
		}
	else if (check_data::noexpand(Cfg_loc::Root_dir.Cfg::Upload_dir.$picname)){ //make sure image is safe to resize
		$image_noresize=true;
		echo '<input type="hidden" name="'.$data.'_'.$img_opt.'['.$image_noresize_index.']"    value="noresize">';//auto set value to noresize when submitted...
		}
	else $image_noresize=false;  
	$image_expand=($img_opt_arr[$image_noexpand_index]==='display')?'display':0;
	$wpercent=($img_opt_arr[$width_limit_index]>5)?$img_opt_arr[$width_limit_index]:100;
	list($border_width,$border_height)=$this->border_calc($this->blog_data4);//img
	list($post_pad_width,$post_mar_width)=$this->pad_mar_calc($this->blog_style); //around post
	$shadowcalc=$this->calc_border_shadow($this->blog_data4); 
	$maxwidth_adjust_shadow_calc=100-$shadowcalc/3;//300 ~ min image width in px conv to %
	list($pad_width,$mar_width)=$this->pad_mar_calc($this->blog_data4);  
	//space for image itself 
	$min_width_val=(!empty($min_width))?'min-width:'.$min_width.'px;':'';
	$width_min_mode=($this->blog_tiny_data1==='maintain_width')?'min-width:'.$wpercent.'%;max-width:'.($this->current_net_width*$wpercent/100).'px':'width:'.$wpercent.'%;'.$min_width_val;
	//$width_max_mode=($this->blog_tiny_data1==='maintain_width')?'width:'.($fwidth-$shadowcalc).'px;max-width:'.$maxwidth_adjust_shadow_calc.'%' :' width:'.$maxwidth_adjust_shadow_calc.'%';
	($this->edit)&&print('<p id="return_'.$this->blog_id.'">&nbsp;</p>');
	if ($this->edit){//|| Sys::Pass_class
		$bp_arr=$this->page_break_arr;
		$maxwidth=0;//intitialize width of maximumun maintain width in maintain_width mode
		if ($this->column_use_grid_array[$this->column_level]==='use_grid'){ 
			$max_pic_size=$this->grid_width_chosen_arr['max'.$bp_arr[0]]*$wpercent/100;
			  foreach($this->page_break_arr as $bp){
				$max_pic_size=max($max_pic_size,$this->grid_width_chosen_arr[$bp]*$wpercent/100);
				if($this->blog_tiny_data1==='maintain_width'){
					$maxwidth=$this->grid_width_chosen_arr['max'.$bp_arr[0]]*$wpercent/100;
					}
				}
			//if ($bp > 359){
			}//end if rwd enabled
		else{//rwd not enabled 
			$max_pic_size=$this->current_net_width*$wpercent/100; 
			$maxwidth=$max_pic_size;
			//$min_pic_size 
			}
		 	$best_guess=($max_pic_size>1000)?800:(($max_pic_size>500)?500:$max_pic_size);//500px image should be javascript scrubbed out..
			 
		$fwidth=$max_pic_size; 
		$type=($this->column_use_grid_array[$this->column_level]==='use_grid')?'rwd':'no_rwd';
		//grid post percent arr   used to determine the percentage width available when grid system is used for each break break point
		//.. from this relevant pic width is calculated..
		$grid_post_percent_arr=($this->column_use_grid_array[$this->column_level]==='use_grid')?$this->grid_width_chosen_arr:'';//array becomes size of pic plugging in viewport 
		$maxfullwidth=check_data::key_up($this->page_cache_arr,$this->current_net_width*$wpercent/100,'val',$this->page_width);//current net width should check out as the maximum width permissible under all circumstances  not accounting for width_limiting...  for this post..  now. if clones are locally resized larger there could be a problem with them finding their new width
		file_put_contents(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'build_pic_'.$this->passclass_ext.$data,$best_guess.'@@'. $type.'@@'.serialize($grid_post_percent_arr).'@@'.$maxfullwidth);
		$quality=(!empty($img_opt_arr[$image_quality_index])&&$img_opt_arr[$image_quality_index]>9&&$img_opt_arr[$image_quality_index]<101)?$img_opt_arr[$image_quality_index]:((!empty($this->page_options[$this->page_image_quality_index])&&$this->page_options[$this->page_image_quality_index]<101&&$this->page_options[$this->page_image_quality_index]>9)?$this->page_options[$this->page_image_quality_index]:Cfg::Pic_quality); 
		if (!$image_noresize&&$image_expand){
			if (is_file(Cfg_loc::Root_dir.Cfg::Page_images_expand_dir.$picname)){
				list($exp_width,$exp_height)=$this->get_size($picname,Cfg_loc::Root_dir.Cfg::Page_images_expand_dir);
				$expandplus=max($exp_width,$exp_height);
				}
			if(!$image_noresize&&!is_file(Cfg_loc::Root_dir.Cfg::Page_images_expand_dir.$picname)||$expandplus > $maxplus*1.03 || $expandplus < $maxplus * .97||isset($_POST[$data.'_'.$img_opt][$image_quality_index])){
				
				image::image_resize($picname,0,0,$maxplus,Cfg_loc::Root_dir.Cfg::Upload_dir,Cfg_loc::Root_dir.Cfg::Page_images_expand_dir,'file',NULL,$quality,'center', true,true);//expand =true
				}//resize 
			$this->page_images_expand_arr=array('id'=>$this->blog_id,'data'=>$this->data,'picname'=>$picname,'is_clone'=>$this->is_clone,'clone_local_style'=>$this->clone_local_style,'clone_local_data'=>$this->clone_local_data,'maxwidth'=>$maxplus,'quality'=>$quality,'quality_option'=>$img_opt_arr[$image_quality_index]); 
			}//display
		if (!$image_noresize){ 
			$dir=Cfg_loc::Root_dir.Cfg::Page_images_dir.Cfg::Response_dir_prefix;
			$parr=array();
			$total=$x=0;
			$page_arr=check_data::return_pages(__METHOD__,__LINE__,__FILE__);
			foreach($this->page_cache_arr as $ext){
				$flag=false;
				(!is_dir($dir.$ext))&&mkdir($dir.$ext,0755,1);
				if ($ext <=$maxfullwidth){
					if (!is_file($dir.$ext.'/'.$picname)||isset($_POST[$data.'_'.$img_opt][$image_quality_index])){
						(Cfg::Development)&&printer::alertx('<p class="tiny white redAlertbackground">Creating: '.$dir.$ext.'/'.$picname.'</p>');
						image::image_resize($picname,$ext,0,0,Cfg_loc::Root_dir.Cfg::Upload_dir, $dir.$ext,'file',NULL,$quality);
						}
					else {
						$x++;
						$size=process_data::get_size($picname,$dir.$ext.'/');
						$fsize=filesize($dir.$ext.'/'.$picname);
						$area=$size[0]*$size[1];
						$ratio=$size[0]/$size[1];
						$density=round($fsize/$area,3);
						$parr[]=array('dir'=>Cfg::Response_dir_prefix.$ext,'wid'=>$size[0],'height'=>$size[1],'area'=>$area,'Kb'=>round($fsize/1000,1),'density'=>$density);
						$total+=$density;
						}
						
					}//if less than maxfullwidth
				elseif (is_file($dir.$ext.'/'.$picname)&&!Sys::Pass_class){//size cache of this image is unnecessary as maxwidth is less
					//note here we are checking all cached images of this blog_id as clones could conceivably have a larger maxwidth
					$continue=false;
					foreach($page_arr as $page_ref){ 
						$file='image_info_page_images_'.$page_ref;
						if ($continue)continue;
						if (is_file(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Image_info_dir.$file)){
							$flag=true;
							 
							$array=unserialize(file_get_contents(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Image_info_dir.$file));
							foreach ($array as $index => $arr){
								if (!array_key_exists('maxwidth',$arr))continue;
								if (!array_key_exists('id',$arr))continue;
								if ($arr['id']==$this->blog_id){
									if ($arr['maxwidth']>=$ext){
										$flag=false;
										}
									}
								
								}//foreach
							
							if ($flag){
								if (is_file($dir.$ext.'/'.$picname)){//double check
									unlink($dir.$ext.'/'.$picname); //save disk space
									(Cfg::Development)&&mail::info($dir.$ext.'/'.$picname. ' was unlinked');
									$continue=true;
									}//double check
								}
							}// is_file 
					 
						}//end foreach
					}//is file
				}//foreach ext...
			if ($x>0){	
				$this->show_more('Image Quality Info');
				printer::horiz_print($parr);
				$avgdensity=round($total/$x,3);  
				$filesize=filesize(Cfg_loc::Root_dir.Cfg::Upload_dir.$picname)/1000;
				$size=process_data::get_size($picname,Cfg_loc::Root_dir.Cfg::Upload_dir);
				$width=$size[0];
				$height=$size[1];
				$ratio=$size[0]/$size[1];
				$density=round($filesize*1000/($size[0]*$size[1]),3);
				$filesize=round($filesize,1);
				$msg="<span class=\"navy whitebackground\">$picname </span><br>avg. pixel/area density: $avgdensity<br>
				@ Quality: $quality <br>
				Uploaded Master Img in uploads/:<br>
				filesize: $filesize Kb<br>
				width: {$width}px<br>
				height: {$height}px <br>
				density: $density ";
				printer::print_info($msg);
				$this->show_close('Image Quality Info');
				#Ok now we are going to include this file along with its current Quality into the Cfg::Page_images_dir array for use in updating caches and possibly deleting unused images!
				$this->page_images_arr[]=array('id'=>$this->blog_id,'data'=>$this->data,'picname'=>$picname,'is_clone'=>$this->is_clone,'clone_local_style'=>$this->clone_local_style,'clone_local_data'=>$this->clone_local_data,'maxwidth'=>$maxfullwidth,'quality'=>$quality,'quality_option'=>$img_opt_arr[$image_quality_index]); ;//this will be compiled in destructor as the current record for this page
				}//x > 0
			}//! $image_noresize
		}//if this edit
	 
	$pic_info_arr=explode('@@',file_get_contents(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'build_pic_'.$this->passclass_ext.$data));
	list($best_guess,$type,$current_grid_chosen_arr,$maxwidth)=$pic_info_arr;  
	$current_grid_chosen_arr=(!empty($current_grid_chosen_arr))?unserialize($current_grid_chosen_arr):'';////array becomes size of pic plugging in viewport
	$best_guess=check_data::key_up($this->page_cache_arr,$best_guess,'val',$this->page_width); //page width provided as ultimate limiter if misconfiged
	if (!empty($this->viewport_current_width)&&$this->viewport_current_width>200){
		 if ($type==='rwd'){ 
			list($key,$width_value)=check_data::key_up($current_grid_chosen_arr,$this->viewport_current_width,'keyval');
			#width#$current_grid_chosen_arr,'keyval',$this->page_width) directly gives the width available of the image a any given breakpoint just beyond the current viewport width...    .
		$image_width=min($this->viewport_current_width,$width_value,$maxwidth);
			}
		else {//non rwd
			$image_width=min($this->current_net_width,$this->viewport_current_width,$maxwidth);
			} 
		}//viewpoint  
	else {
		 $image_width=$best_guess;  //do not repspond to no resize images
		} 
		
	$image_width=check_data::key_up($this->page_cache_arr,$image_width,'val',$this->page_width);
	$respond_data=' data-max-wid="'.$maxwidth.'" data-wid="'.$image_width.'" '; //here we are getting the responsive directory size of image cache... going up in size ...
	$image_width_dir=Cfg::Response_dir_prefix.$image_width.'/';
	$fullpicdir=($image_noresize)?Cfg_loc::Root_dir.Cfg::Image_noresize_dir:Cfg_loc::Root_dir.Cfg::Page_images_dir.$image_width_dir;  
	if (!$image_noresize&&!is_file($fullpicdir.$picname)&&is_file(Cfg_loc::Root_dir.Cfg::Upload_dir.$picname)){#create image even if not in edit mode
		$quality=(!empty($img_opt_arr[$image_quality_index])&&$img_opt_arr[$image_quality_index]>9&&$img_opt_arr[$image_quality_index]<101)?$img_opt_arr[$image_quality_index]:((!empty($this->page_options[$this->page_image_quality_index])&&$this->page_options[$this->page_image_quality_index]<101&&$this->page_options[$this->page_image_quality_index]>9)?$this->page_options[$this->page_image_quality_index]:Cfg::Pic_quality);
		image::image_resize($picname,$image_width,0,0,Cfg_loc::Root_dir.Cfg::Upload_dir, $fullpicdir,'file',NULL,$quality);
		(Cfg::Development)&&mail::alert("creating image resize for $picname edit mode is $this->edit");
		}
	elseif (!is_file($fullpicdir.$picname)&&is_file(Cfg_loc::Root_dir.Cfg::Upload_dir.$picname)){
		copy(Cfg_loc::Root_dir.Cfg::Upload_dir.$picname,$fullpicdir.$picname);
		}
	if ($picname==='default.jpg'){
		$fullpicdir=Cfg_loc::Root_dir; 
		}
	elseif (!is_file($fullpicdir.$picname)){
		if (Sys::Pass_class){
			$picname='default_pass.jpg';
			$alt='';
			$alt='';
			$fullpicdir=Cfg_loc::Root_dir;
			}
		else { 
			if(empty($picname)||!is_file(Cfg_loc::Root_dir.Cfg::Upload_dir.$picname)){
				$msg='Missing main master Image File uploads/'.$picname;
				mail::alert($msg.' on line'.__LINE__,__METHOD__);
				printer::alert_neg($msg);
				($this->edit)&&printer::alert_neg('Your Previous Image Does not Exist. Upload a New Image &nbsp;<a href="add_page_pic.php?blog_image_noexpand='.$image_expand.'&amp;wwwexpand='.$maxplus.'&amp;image_noresize='.$image_noresize.'&amp;expandfield=blog_tiny_data2&amp;prevpic=0&amp;www='.$maxwidth.'&amp;ttt='.$this->blog_table.'&amp;fff=blog_data1&amp;quality='.$quality.'&amp;id='. $this->blog_id.'&amp;id_ref=blog_id&amp;pgtbn='.$this->tablename.'&amp;postreturn='.Sys::Self.'&amp;css='.$this->roots.Cfg::Style_dir.$this->tablename. '&amp;sess_override&amp;sess_token='.$this->sess->sess_token.'"><u>Here</u></a>');
				printer::pclear(5);
				return;
				}
			}
		} //picname not exists
		
	//list($width,$height)=$this->get_size($picname,$picdir);
	switch ($this->blog_type){
		case 'image':
			$fstyle='margincenter';
			break;
		case 'float_image_left' :
			$fstyle='floatleft';
			break;
		case 'float_image_right' :
			$fstyle='floatright';
			break;
		default: $fstyle='margincenter';
			}
			
			
	##&&&& Css tweak
	if ($this->edit){
		#set minimum width for image in image text
		if (!empty($image_min)){  
			$this->imagecss.='
			 .'.$data.' p.imagewrap {min-width:'.$image_min.'px;}
			';
			}
			
		if ($this->blog_tiny_data1==='maintain_width'&&$this->column_use_grid_array[$this->column_level]==='use_grid'){
			$bp_arr=$this->page_break_arr;
			$this->imagecss.='
			 .'.$data.'_img {width:'.($this->grid_width_chosen_arr['max'.$bp_arr[0]]*$wpercent/100-$shadowcalc).'px;max-width:'.$maxwidth_adjust_shadow_calc.'%;
			 }
			';
			
			 #tweaking small text width next to image to disappear..set a width max under which the image takes full space before the text gets too narrow and odd looking!
			 $post_pad_width=$post_pad_width/100*$this->grid_width_chosen_arr['max'.$bp_arr[0]];//convert to px from %
			 $maxdisplay_maintain=$this->grid_width_chosen_arr['max'.$bp_arr[0]]*$wpercent/100+$post_pad_width+150;//ie the padding width diminishes the text width increases the width necessary to transition
			 $this->imagecss.='
			@media screen and (max-width: '.$maxdisplay_maintain.'px){';
			
			$this->imagecss.='
			 .'.$data.' p.imagewrap {  float:none; text-align:center; padding-left:0; padding-right:0;
			 } 
			 .'.$data.'_img { text-align:center; /*padding-left:0; padding-right:0;*/
			 }
			';
			$this->imagecss.='}
			';
			 }
		else {
			$this->imagecss.='
			.'.$data.'_img {width:'.$maxwidth_adjust_shadow_calc.'% 
				 }
				';
			}
		}//if edit css 
	##&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
	//width="100%" height="'.$hpercent.'%"
	$imagerespond=(!$image_noresize)?'imagerespond':'';
	if(!$this->edit||$this->is_clone){
		if (is_file(Cfg_loc::Root_dir.Cfg::Page_images_expand_dir. $picname)&&$img_opt_arr[$image_noexpand_index]==='display'){   
			printer::printx('<p class="'.$imagerespond.' imagewrap '.$fstyle. '" '.$respond_data.' style="'. $width_min_mode.'"><a href="'.Cfg_loc::Root_dir.Cfg::Page_images_expand_dir. $picname .'" class="center highslide" onclick="return hs.expand(this,{ slideshowGroup: \'col_'.$this->column_id_array[$this->column_level].'\' , wrapperClassName: \'page_image\' })"><img class="'.$data.'_img '.$this->blog_type.'_img" src="'.$fullpicdir.$picname.'" alt="'.$alt.'" ></a></p>');
			($this->blog_type!=='image')&&
			$this->blog_text_float_box($data);
			}
		else {
			printer::printx('<p class="'.$imagerespond.' imagewrap '.$fstyle. '"'.$respond_data.'style="'.$width_min_mode.'"> <img class="'.$data.'_img '.$this->blog_type.'_img" src="'.$fullpicdir. $picname.'"   alt="'.$alt.'" ></p>');
			($this->blog_type!=='image')&&
			$this->blog_text_float_box($data);
			}
		}
	if (!$this->edit)return;
	printer::pspace(5); 
	printer::pclear(5);  
	$minwid= ($this->current_net_width >100)?$this->current_net_width:100;//
	$size=process_data::input_size($minwid,16,40);// Not that font size is css hard coded to 16px in edit_build_pic...
	if (!$this->is_clone){ 	
		printer::alert('Click the photo to upload a new one','',' left floatleft fsminfo editbackground infoback rad5 info maroonshadow');
		printer::pclear();
		printer::alertx('<p class="'.$imagerespond.' imagewrap '.$fstyle. '"'.$respond_data.'style="'.$width_min_mode.'"><a  href="add_page_pic.php?blog_image_noexpand='.$image_expand.'&amp;wwwexpand='.$maxplus.'&amp;expandfield=blog_tiny_data2&amp;www='.$fwidth.'&amp;ttt='.$this->blog_table.'&amp;fff=blog_data1&amp;id='.$this->blog_id.'&amp;id_ref=blog_id&amp;pgtbn='.$this->tablename.'&amp;postreturn='.Sys::Self.'&amp;css='.$this->roots.Cfg::Style_dir.$this->tablename.'&amp;quality='.$quality.'&amp;sess_override&amp;sess_token='.$this->sess->sess_token.'"><img class="'.$data.'_img '.$this->blog_type.'_img"  src="'.$fullpicdir. $picname.'"   alt="'.$alt.'"  ></a></p>');
		}
	if($this->blog_type!=='image'&&!$this->is_clone){
		$this->blog_text_float_box($data);
		printer::pclear(5); 
		$this->show_more('Alt Title');
		printer::printx('<div class="info maroonshadow floatleft left fsminfo editbackground fsmblack rad5 infoback editfont">  The alt title has Search Engine (ie. duckduckgo, google) value to better search-rank your site so you can choose a   title which reflects a couple search terms that describe this page and/or image<p class="editcolor editbackground">Optional Alt title for Image:<br><input  name="'.$data.'_blog_data1[1]" value="'.$alt.'" size="'.($size/2).'" ></p></div>');
		$this->show_close('Alt Title'); 
		printer::pclear(5);
		}
	if (!$this->is_clone||$this->clone_local_style){
		$current = $this->current_net_width*$wpercent/100;
		$this->show_more('Configure Image');
		printer::print_wrap('config image');
		#################################################33
		 
		###########################################
		printer::print_wrap('image resize');
		printer::print_tip('Image Resize is enabled by default which enables Optimum download sizes for images.  Animated Gif  and Svg images will not be resized');
		if ($img_opt_arr[$image_noresize_index]!=='noresize') 
			printer::printx ('<p class="info floatleft" title="Check to Allow Image Resize when this Image is clicked"><input type="checkbox" name="'.$data.'_'.$img_opt.'['.$image_noresize_index.']"    value="noresize">Do not Allow Image Resize Cache Generation</p>');
					
		else printer::printx('<p  class="info floatleft fsminfo" title="Check to prevent Image Expansion when this Image is clicked"><input type="checkbox" name="'.$data.'_'.$img_opt.'['.$image_noresize_index.']" value="resize">Allow Image Resize Cache Generation</p>');
		printer::close_print_wrap('image resize');
		printer::print_wrap('image noexpand');
		printer::print_tip('By Default Images will not expand when clicked on. Enable/disable this setting here'); 
		$genstyle=($img_opt_arr[$image_noexpand_index]==='display')?'style="display:block;"':'style="display:none;"';
		 
		if ($img_opt_arr[$image_noexpand_index]!=='display') 
			printer::printx ('<p class="info floatleft" title="Check to Allow Image Expansion when this Image is clicked"><input type="checkbox" name="'.$data.'_'.$img_opt.'['.$image_noexpand_index.']"  onclick="edit_Proc.displaythis(\''.$data.'_expandsize_show\',this,\'#fdf0ee\')" value="display">Allow Expanded Image</p>');
					
		else printer::printx('<p  class="info floatleft fsminfo" title="Check to prevent Image Expansion when this Image is clicked"><input type="checkbox" name="'.$data.'_'.$img_opt.'['.$image_noexpand_index.']" value="no_display">Prevent Image Click Expanded Image</p>');
		printer::pclear();
		$maxplus=(!empty($img_opt_arr[$image_max_expand_index])&&$img_opt_arr[$image_max_expand_index]>50)?$img_opt_arr[$image_max_expand_index]:((!empty($this->page_options[$this->page_max_expand_image_index])&&$this->page_options[$this->page_max_expand_image_index]>50)?$this->page_options[$this->page_max_expand_image_index]:Cfg::Page_pic_expand_plus);
		printer::printx('<div title="Change this default maximum width or height value '.$maxplus.' for this image." id="'.$data.'_expandsize_show" '.$genstyle.' class="fsminfo info floatleft"><!--imageplus-->Change Expanded Image height or width setting whichever is larger:');
		$this->mod_spacing($data.'_'.$img_opt.'['.$image_max_expand_index.']',$maxplus,25,1500,10,'px');
		printer::printx('</div><!--imageplus-->');
		printer::close_print_wrap('image expand');	
		echo'<div class="floatleft editbackground fsminfo info" title="By Default Uploaded Images will have a Quality factor of '.Cfg::Pic_quality.' with 100 being the highest and 10 the lowest. The higher the image quality the larger the filesize and the slower the download speed. Change the Default value here which will effect all uploaded images on the site that are not specifically configured for this value in the image, slideshow, or gallery configurations"  ><!--quality image-->Change Default Image Quality setting:';
		$this->mod_spacing($data.'_'.$img_opt.'['.$image_quality_index.']',$quality,10,100,1,'%');
			printer::print_info('Images will auto reload @ new Quality setting');
		echo'</div><!--quality image-->';
			//$this->show_more('Image Limiter');
		echo '<div class="fsminfo editbackground '.$this->column_lev_color.' floatleft"><!--final width adjust-->';
		
		$px=round($wpercent/100*$this->current_net_width);
		printer::alert('Your image size is determined by the Post  Width Available  and the option here to further limit the image width if you wish for overall styling effects to keep the post width large and the image smaller.  For <b><em>float image-text posts</em></b> the default setting for image limiter is 50% image 50% text. Image limiter  is currently set at <span class="editcolor editbackground">'.$wpercent.'%&nbsp;&nbsp;('.$px.'px)</span> of the available post width.','','info left floatleft infoback maroonshadow fsminfo editbackground  maxwidth500');
		printer::pclear();
		echo '<div class="fs1color floatleft"><!--Edit image Width Adjust-->';  
		$maxspace=$this->current_net_width; 
		$factor=$this->current_net_width/100;
		$msgjava='Choose Width:';
		echo '<div class="editcolor editfont editbackground click" onclick="gen_Proc.precisionAdd(this,\''.$data.'_'.$img_opt.'['.$width_limit_index.']\',5,\''.$maxspace.'\',\''.$px.'\',\'px\',\''.$factor.'\',\''.$msgjava.'\',\'%\');">Width Adjust Image</div>'; 
		echo '</div><!--Edit image Width Adjust-->';
		$checked1=($this->blog_tiny_data1==='maintain_width')? 'checked="checked"':'';
		$checked2=($this->blog_tiny_data1==='maintain_width')?'':'checked="checked"';
		echo '<div class="fsminfo floatleft '.$this->column_lev_color.' editfont editbackground"><!--Edit image Limiter Mode-->';
		printer::print_tip('If Width adjust is being used such as with text image floating posts you can Choose To Scale Image or Maintain Image Size when scaling down For smaller Screen Views <br>');
		printer::alertx('<p class="fs1'.$this->column_lev_color.'" title="In Maintain Image Size Mode, Images with width limiting or Images with float text size will not scale down proportionally but maintain size up to the post max width!"><input type="radio"  name="'.$data.'_blog_tiny_data1" '.$checked1.' value="maintain_width">Maintain Image Size<span class="info"> more info</span<p>');
		$stylemin=($this->blog_tiny_data1==='maintain_width')?'style="display:none;':'';		 
		echo '<div class="fs1'.$this->column_lev_color.'" title="In image Scale mode Mode images will scale down proportionally  with spaces or text on smaller view screens"><!--scale images--><input type="radio" onclick="gen_Proc.showIt(\''.$data.'_showmin\');" name="'.$data.'_blog_tiny_data1" '.$checked2.' value="0">Scale Images<span class="info"> more info</span>';
		echo '<div id="'.$data.'_showmin" '.$stylemin.'><!--show min width-->';
		printer::alert('Optionally Choose a minimum width for scaled images as necessary',0,'fsmredAlert editbackground editcolror editfont');
		$this->mod_spacing($data.'_'.$img_opt.'['.$image_min_index.']',$image_min,10,600,1,'px');
		echo '</div><!--show min width-->';
		echo '</div><!--scale images-->';
		echo '</div><!--Edit image Limiter Mode-->'; 
		printer::pclear();
		echo '</div><!--final width adjust-->';
		
		//$this->show_close('Image Limiter');
		printer::close_print_wrap('config image');
		$this->show_close('Configure Image');
		
		printer::pclear();
		}
	$orginal_bip=$this->background_img_px;
	$original_width=$this->current_net_width;
	$this->current_net_width=$fwidth;
	$this->background_img_px=$fwidth+$pad_width;
	$global_field=($this->blog_global_style==='global')?',.'.$this->clone_ext.$this->col_table.' .'.$this->blog_type.'_img':''; 
	$this->edit_styles_close($data,'blog_data4','.'.$data.'_img'.$global_field,'background,padding_top,padding_bottom,padding_left,padding_right,margin_top,margin_bottom,borders,box_shadow,outlines,radius_corner','Style Image Border &amp; Image Spacing ',false,'Style an Image Border and background effect here. Remember that Margin spacing is outside the image border whereas Padding spacing will put space between a border and the image.');  
	$this->background_img_px=$orginal_bip; 
	$this->current_net_width=$original_width;
	printer::pclear();
	#ok here if marked as global the results of these styles choices will directly style this blog type but also the parent column.text..  as shown...
	#all fields done cause blog_global_style equalling global applies to all fields that are chosen to be included
	$type=($this->blog_type==='float_image_left'||$this->blog_type==='float_image_right')?'float_image':$this->blog_type;
	$global_field=($this->blog_global_style==='global')?',.'.$this->clone_ext.$this->col_table.' .'.$type:''; 
	$style_list='';  
	$this->edit_styles_close($data,$style_ref,'.'.$data.'.'.$type.$global_field, $style_list,'Style the Overall Post');
	}//end build  #end build
 
function float_pic($data,$picdir){  
	$this->build_pic($data,$picdir);
	($this->edit)&&printer::pclear();
	if ($this->edit)printer::alert($this->styler2_instruct);
	 
	}
	
#floattext #floatbox #floatpic
function blog_text_float_box($data){ 
	static $myinc=0; $myinc++;
	if (!empty($this->blog_text&&!$this->edit)){
		echo process_data::clean_break($this->blog_text);
		return; 
		} 
	else if (!$this->edit)return;
	else if ($this->is_clone&&!empty($this->blog_text)){ 
		echo process_data::clean_break($this->blog_text);
		return;
		}
	elseif ($this->is_clone)return;  
	static $myinc=0; $myinc++;
	$cols=(!empty($this->current_net_width))?process_data::width_to_col($this->current_net_width,$this->current_font_px):$columns; 
	$display_editor=($this->blog_options[$this->blog_editor_use_index]==='use_editor')?'enableTiny ':'divTextArea';
	$rowlength=($cols<3)?3:process_data::row_length($this->blog_text,$cols);  
	$print=($this->blog_options[$this->blog_editor_use_index]==='use_editor')?'':
		'<div class="'.$this->column_lev_color.' floatleft cursor smallest editbackground shadowoff rad3 button'.$this->column_lev_color.'" onclick="edit_Proc.enableTiny(this,\''.$data.'_blog_text\',\'divTextArea\');">Use Tiny</div>';
	 echo $print;
	 printer::pspace(3);
	echo  '<div id="'.$data.'_blog_text" class="'.$display_editor.' '.$data.'">'; 
		echo process_data::clean_break($this->blog_text); 
	echo '</div>';
	$blog_text=($this->blog_options[$this->blog_editor_use_index]==='use_editor')?process_data::textarea_validate($this->blog_text):process_data::textarea_validate(process_data::remove_html_break($this->blog_text));
		 
		echo '  
		 <textarea style="background:inherit; display: none; width:100%"  id="'.$data.'_blog_text_textarea"   class="scrollit '.$data.'" name="'.$data.'_blog_text" rows="'.$rowlength.'" cols="'.$cols.'" onkeyup="gen_Proc.autoGrowFieldScroll(this);">' .$blog_text.'</textarea>';
	
	}
	#end function
	
	
function nested_column(){ 
	$this->column_level++;     
	$this->column_lev_color=$this->color_arr_long[$this->column_level];
	if($this->blog_data2=='column_choice'){
		$this->choose_column($this->blog_id,true);   
		$this->column_level--;   
		return;
		}
	$this->blog_render($this->blog_data1,false,$this->col_table_base);
	$this->column_level--;   
	$this->column_lev_color=$this->color_arr_long[$this->column_level];  
	} 
	
	
function parse_menu_edit($dir_menu_id){   
	$reorder=false;
	 $filename_msg='The following filename changes have been made ';
	$i=0;
	$q="select dir_menu_order, dir_sub_menu_order from $this->directory_table where dir_menu_id='$dir_menu_id'";
	$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true); 
	while($rows=$this->mysqlinst->fetch_assoc($r,__LINE__)){ 
		$dir_menu_order=$rows['dir_menu_order']; 
		$dir_sub_menu_order=$rows['dir_sub_menu_order'];
		if (isset($_POST['dir_title_'.$dir_menu_id.'_'.intval($dir_menu_order).'_'.intval($dir_sub_menu_order)])&&!empty($_POST['dir_title_'.$dir_menu_id.'_'.intval($dir_menu_order).'_'.intval($dir_sub_menu_order)])){ 
			$q="select dir_title,dir_ref from $this->directory_table where dir_menu_id='$dir_menu_id' and dir_menu_order='$dir_menu_order' and dir_sub_menu_order='$dir_sub_menu_order'"; 
			$r2=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
			list($dir_title,$dir_ref)=$this->mysqlinst->fetch_row($r2,__LINE__);
			$title=process_data::clean_title($_POST['dir_title_'.$dir_menu_id.'_'.intval($dir_menu_order).'_'.intval($dir_sub_menu_order)]);
			if (trim($dir_title) != trim($title)){  
				$q="update $this->directory_table set dir_update='".date("dMY-H-i-s")."',dir_title='$title' where dir_menu_id='$dir_menu_id' and dir_menu_order='$dir_menu_order' and dir_sub_menu_order='$dir_sub_menu_order'";  
				$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
				$q="update $this->master_page_table set token=".mt_rand(1,mt_getrandmax()).",page_title='$title' where page_ref='$dir_ref'"; 
				$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
			  	$msg='The title '.$dir_title. ' has been changed to '.$title.' in directory menu #'.$dir_menu_id;
				$this->success[]=$msg;
				}//update title
			}
		if (isset($_POST['dir_filename_'.$dir_menu_id.'_'.intval($dir_menu_order).'_'.intval($dir_sub_menu_order)])){  
			$filename=process_data::clean_filename($_POST['dir_filename_'.$dir_menu_id.'_'.intval($dir_menu_order).'_'.intval($dir_sub_menu_order)]);
			if ($filename !=='index'){ 
				$q="select dir_ref,dir_filename from $this->directory_table where dir_menu_id='$dir_menu_id' and dir_menu_order='$dir_menu_order' and dir_sub_menu_order='$dir_sub_menu_order'";//remember all dir_ref and therefore dir_filename must make this change regardless 
				$r2=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
				//any entry having the data_ref associated with this change will be changed...
				list($dir_ref,$dir_filename)=$this->mysqlinst->fetch_row($r2,__LINE__);
				if ($dir_filename !== $filename){
				// echo "  what if ($dir_filename !== $filename){";
				// print "we are at 	if (isset( .$dir_menu_id.'_'.$dir_menu_order.'_'.$dir_sub_menu_order])){";
					$q="UPdate $this->directory_table set dir_update='".date("dMY-H-i-s")."',dir_time='".time()."',token='".mt_rand(1,mt_getrandmax()). "',dir_filename='$filename' where dir_ref='$dir_ref'";
					$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
					$q="UPdate $this->master_page_table set page_update='".date("dMY-H-i-s")."', page_time='".time()."',token='".mt_rand(1,mt_getrandmax()). "',page_filename='$filename' where page_ref='$dir_ref'";
					$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
					
					 $q="select dir_internal,dir_external,dir_menu_id,dir_title from $this->directory_table where dir_ref='$dir_ref'";  
					$r2=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
					$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
					while($rows2=$this->mysqlinst->fetch_assoc($r2,__LINE__)){
						$dir_external=$rows2['dir_external'];
						$dir_internal=$rows2['dir_internal'];
						$dir_menu_id2=$rows2['dir_menu_id'];
						$dir_title=$rows2['dir_title'];
						$filename_msg=NL.'The Page having the title '.$dir_title." has had a filename change from $dir_filename.$this->ext to $filename$this->ext  in dir menu id$dir_menu_id2";
						$ext=(!$dir_internal&&!$dir_external)?$this->ext:'';
						 if (!copy($dir_filename.$ext,$filename.$ext)){
							mail::alert("failure to copy $dir_filename$ext  to $filename$ext  Having the title $dir_title in editpages");
							}
						if (!copy(Cfg_loc::Root_dir.$dir_filename.$ext,Cfg_loc::Root_dir.$filename.$ext)){
							mail::alert("failure to copy $dir_filename$ext  to $filename$ext  Having the title $dir_title in Root dir");
							} 
						}//end while
					$this->success[]=$filename_msg;	
					
					}//end !  filenamechanged
				}//!filename equals index 
				
			}//(isset($_POST['dir_filename...
		}//end while
	if (isset($_POST['dir_change_homepage'])&&!empty($_POST['dir_change_homepage'])){
	$index_msg='Your Homepage has been switched. Homepages always have the filename index ('.$this->ext.')';
	$arr=explode('_',$_POST['dir_change_homepage']);
		$q="select dir_ref,dir_filename from $this->directory_table where dir_menu_id=".$arr[0].' and dir_menu_order='.$arr[1].'  and dir_sub_menu_order=0';  
		$r2=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
		list($dir_ref,$dir_filename)=$this->mysqlinst->fetch_row($r2,__LINE__);
		if ($dir_filename!='index'){  
			#first change the present index filenames
			$newindex=process_data::new_file($dir_ref,$this->ext);
			$q="select dir_menu_id,dir_title,dir_ref from $this->directory_table where dir_filename='index'";
			$r2=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__);
			
			while($rows2=$this->mysqlinst->fetch_assoc($r2,__LINE__)){
				$dir_menu_id2=$rows2['dir_menu_id'];
				$dir_ref2=$rows2['dir_ref'];
				$dir_title=$rows2['dir_title'];
				$index_msg.=NL.'The Old Opening/Homepage having the title '.$dir_title.' and the data_ref: '.$dir_ref2.' has had a filename change from index ('.$this->ext.')  to '.$newindex. ' ('.$this->ext.') in dir menu id '.$dir_menu_id2;
				}//end while rename index pages to newindex 
			$q="UPDate $this->directory_table  set dir_update='".date("dMY-H-i-s")."',dir_time='".time()."',token='".mt_rand(1,mt_getrandmax()). "',dir_filename='$newindex' where dir_filename='index'";
			$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__);
			$q="UPDate $this->master_page_table  setpage_time='".time()."',token='".mt_rand(1,mt_getrandmax()). "',page_filename='$newindex' where page_filename='index'";
			$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__);
			
			if (!copy('index'.$this->ext,$newindex.$this->ext)){
				mail::alert("failure to copy index  to $newname$this->ext  Having the title $dir_title in editpages");
				}
			if (!copy(Cfg_loc::Root_dir.'index'.$this->ext,Cfg_loc::Root_dir.$newindex.$this->ext)){
				mail::alert("failure to copy index  to $newname$this->ext  Having the title $dir_title in Root dir");
				}
			$q="select dir_menu_id,dir_title,dir_filename from $this->directory_table where dir_ref='$dir_ref'";
			$r2=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
			while($rows2=$this->mysqlinst->fetch_assoc($r2,__LINE__)){
				$dir_menu_id2=$rows2['dir_menu_id'];
				$dir_filename=$rows2['dir_filename'];
				$dir_title=$rows2['dir_title'];
				$index_msg.=NL.'The New Opening/Homepage  having the title '.$dir_title.' and the data_ref of '.$dir_ref.' has had its filename changed from  '.$dir_filename. '('.$this->ext.') to index ('.$this->ext.') in dir menu id '.$dir_menu_id2;
				}//end while rename index pages to newindex 
			$q="UPDate $this->directory_table  set dir_update='".date("dMY-H-i-s")."',dir_time='".time()."',token='".mt_rand(1,mt_getrandmax()). "',dir_filename='index' where dir_ref='$dir_ref'";
			$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
			if (is_file($dir_filename.$this->ext)){
				if (!copy($dir_filename.$this->ext,'index'.$this->ext)){
					mail::alert("failure to copy $dir_filename  to index$this->ext  Having the title $dir_title in editpages");
					}
				}
			else printer::alert_neg('Check for existance of '.$dir_filename.$this->ext);
			if (is_file(Cfg_loc::Root_dir.$dir_filename.$this->ext)){
				if (!copy(Cfg_loc::Root_dir.$dir_filename.$this->ext,Cfg_loc::Root_dir.'index'.$this->ext)){
				    mail::alert('failure to copy   '.Cfg_Loc::Root_dir.$newname.$this->ext ." to  index Having the title $dir_title in Root dir");
				    }
				}
			else printer::alert_neg('Check for existance of '.Cfg_loc::Root_dir.$dir_filename.$this->ext);
			$this->success[]=$index_msg;
			}//new homepage not filename index 
		}//end if change homepage
	if (isset($_POST['nav_delete'])){
		foreach ($_POST['nav_delete'] as $delete_post){
			$arr=explode('_',$delete_post);
			$q="select dir_title from $this->directory_table where dir_menu_id=".$arr[0].' and dir_menu_order='.$arr[1].' and dir_sub_menu_order='.$arr[2];
			$x=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
			list($dirtitle)=$this->mysqlinst->fetch_row($x,__LINE__);
			$q="delete from $this->directory_table where dir_menu_id=".$arr[0].' and dir_menu_order='.$arr[1].' and dir_sub_menu_order='.$arr[2];
			$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
			$menu_level=($arr[2]<1)?'Main Menu':'Sub Menu Link';
			$msg="$menu_level Navigation Link Title: <b>$dirtitle</b> has been removed from Menu id{$arr[0]}";
			$this->message[]=$msg;
			}//end foreach
		
		}//end isset
	 
	if (isset($_POST['menu_add_newpage'])){ 
		foreach($_POST['menu_add_newpage'] as $menuaddnewpage){
			if(!empty(explode('_',$menuaddnewpage)[3])){
				$array=explode('_x_',$menuaddnewpage);
				$dir_menu_id=$array[0];
				$dir_menu_order=$array[1];
				$dir_sub_menu_order=$array[2];
				$dir_ref=$array[3];
				$q="select dir_filename, dir_title from $this->directory_table where dir_ref='$dir_ref' limit 1";
				$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
				if ($this->mysqlinst->affected_rows()){
					list($dir_filename,$dir_title)=$this->mysqlinst->fetch_row($r,__LINE__);
					}
				else {
					$q="select page_title,page_filename from $this->master_page_table where page_ref='$dir_ref'";
					$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
					list($dir_title,$dir_filename)=$this->mysqlinst->fetch_row($r,__LINE__);
					$dir_title=(!empty($dir_title))?$dir_title:str_replace('_',' ',$dir_ref);
					$dir_filename=(!empty($dir_filename))?$dir_filename:$dir_ref;
					}
				
				$where="where dir_menu_order='$dir_menu_order'";
				$count=$this->mysqlinst->count_field($this->directory_table,'dir_sub_menu_order','',false,$where);
				if ($count < 1){
					$where="where dir_menu_id='$dir_menu_id'";
					$count=$this->mysqlinst->count_field($this->directory_table,'dir_menu_order','',false,$where);
					$dir_sub_menu_order=0;
					$dir_menu_order=$this->mysqlinst->field_inc;
					}
				else $dir_sub_menu_order=$this->mysqlinst->field_inc;
								$dir_fields=Cfg::Dir_fields;
				$dir_field_arr=explode(',',$dir_fields); 
				$value='';  
				foreach ($dir_field_arr as $field) {
					if ($field=='dir_menu_id')$value.="'$dir_menu_id',";
					else if ($field=='dir_menu_order')$value.="'$dir_menu_order',";
					else if ($field=='dir_sub_menu_order')$value.="'$dir_sub_menu_order',";
					else if ($field=='dir_menu_order')$value.="'$dir_menu_order',";
					else if ($field=='dir_filename')$value.="'$dir_filename',";
					else if ($field=='dir_title')$value.="'$dir_title',";
					else if ($field=='dir_ref')$value.="'$dir_ref',";
					else $value.="'0',";
					}
				$q="insert into  $this->directory_table  ($dir_fields,dir_update,dir_time,token) values ($value '".date("dMY-H-i-s")."','".time()."','".mt_rand(1,mt_getrandmax())."')";    
				$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
$msg="A new Link for  page ref: <b>$dir_ref</b> and title: <b>$dir_title </b>has been added to Menu Id: $dir_menu_id ";
				$this->success[]=$msg;
				}
			}
		}
	if (isset($_POST['add_external_link_url'])){
		foreach($_POST['add_external_link_url'] as $key => $ext){
			if (!empty($ext)){
				$external_link='http://'.str_replace(array('http://','http:/','http:','http','http//:','http//'),'',$_POST['add_external_link_url']);
				$array=explode('_x_',$key);
				$dir_menu_id=$array[0];
				$dir_menu_order=$array[1];
				$dir_sub_menu_order=$array[2]; 
				$dir_title=process_data::clean_title($_POST['add_external_link_name'][$key]);
				if (!empty($dir_title)){
					$q="insert into $this->directory_table (dir_menu_id,dir_menu_order,dir_sub_menu_order,dir_filename,dir_title,dir_ref,dir_menu_style,dir_gall_table,dir_blog_table,dir_menu_type,dir_gall_type,dir_menu_opts,dir_hide_sub_menu,dir_external,dir_internal,dir_is_gall,dir_temp,dir_temp2,dir_update,dir_time,token) values
			($dir_menu_id,$dir_menu_order,$dir_sub_menu_order,'$dir_filename','$dir_title','$dir_ref','','','','','','','','','',0,0,0,'".date("dMY-H-i-s")."','".time()."','".mt_rand(1,mt_getrandmax())."')";   
					$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true); 	 
					}	
				else { $msg='Please include a title along with an external url when adding a link to another website';
					printer::alert_neg($msg);
					}
				}//end if url add
			}//end foreach
		}
 
	$this->directory_tidy($dir_menu_id);
	$msg='POST ENTRIES HAVE BEEN UPDATED PLEASE DOUBLE CHECK..'; 
	$this->success[]=$msg;
	}//end file
	
 
function directory_tidy($dir_menu_id){ 
	if (Sys::Methods){Sys::Debug(__LINE__,__FILE__,__METHOD__);} 
	$token=process_data::create_token();
	$dir_menu_order_arr=array();
	$q="select distinct dir_menu_order from  $this->directory_table  where dir_menu_id='$dir_menu_id' order by dir_menu_order";
	$r2=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	$i=1;
	while (list($dir_menu_order)= $this->mysqlinst->fetch_row($r2,__LINE__)){
		$dir_menu_order_arr[]=$dir_menu_order;
		$q="select dir_sub_menu_order from  $this->directory_table  where dir_menu_id='$dir_menu_id' and dir_menu_order='$dir_menu_order' order by dir_sub_menu_order";
		$r3=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
		$ii=0;
		while (list($dir_sub_menu_order)= $this->mysqlinst->fetch_row($r3,__LINE__)){
			$q="update $this->directory_table set dir_update='".date("dMY-H-i-s")."',dir_time='".time()."',token='".mt_rand(1,mt_getrandmax()). "',dir_temp='$ii' where dir_menu_id='$dir_menu_id' and dir_menu_order='$dir_menu_order'  and dir_sub_menu_order='$dir_sub_menu_order'";  
			$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
			$ii++;//=($ii + $this->dir_insert_full);
			}//end while dir_sub_menu_order
		$q="update $this->directory_table set dir_update='".date("dMY-H-i-s")."',dir_time='".time()."',token='".mt_rand(1,mt_getrandmax()). "',dir_sub_menu_order=dir_temp where dir_menu_id='$dir_menu_id' and dir_menu_order='$dir_menu_order'";
			$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); 
				
		$q="update $this->directory_table set dir_update='".date("dMY-H-i-s")."',dir_time='".time()."',token='".mt_rand(1,mt_getrandmax()). "',dir_temp2=$i  where dir_menu_id='$dir_menu_id' and dir_menu_order='$dir_menu_order'";   
			$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);      
			$i++;//=($i + $this->dir_insert_full);
		}//end while dir_menu_order
	$q="update $this->directory_table set dir_update='".date("dMY-H-i-s")."',dir_time='".time()."',token='".mt_rand(1,mt_getrandmax()). "',dir_menu_order=dir_temp2 where dir_menu_id='$dir_menu_id'"; 
	$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);	 
	####### update dir_menu_type
	}
 	

function copy_col_theme($parent_id,$child_id,$db,$page_ref){
	$col_fields=Cfg::Col_fields;
	$col_fields_all=Cfg::Col_fields_all;
	$col_fields_arr=explode(',',$col_fields);
	$q="select $col_fields from $db.$this->master_col_table where col_id=$parent_id";  
	$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	$row = $this->mysqlinst->fetch_assoc($r,__LINE__);
	$q="insert into $this->master_col_table ($col_fields_all) values (";
	foreach ($col_fields_arr as $field){
		if ($field=='col_table_base')$q.="'$page_ref',";
		elseif($field=='col_table')$q.="'{$page_ref}_post_id$child_id',";  
		else $q.="'".$row[$field]."',";
		}
	$q="$q '".date("dMY-H-i-s")."','".time()."','".$this->token_gen()."')"; 
	$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	$preserve=false;
	$this->copy_col($child_id,$parent_id,'copy',$preserve,$page_ref,$db.'.');
	//$q="update $this->master_col_table set col_temp='',col_time='".time()."',token='".mt_rand(1,mt_getrandmax()). "' where col_id=$child_id";
	//$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	$this->submit_button(); 
	}//end copy_col_theme

function clone_preserve_unclone($parent_id,$col_table_base,$db='',$post_target_clone_column_id=''){
	//we will not check for clones as we recrusively pass cause any nested column will potentially have within it a nested column and and an unclone within that..  so lets just check for the relevant unclone and copy to present page!
	static $inc=0;  $inc++;
	$page_fields=Cfg::Page_fields;
	$post_fields=Cfg::Post_fields;
	$post_field_arr=explode(',',$post_fields);
	$col_fields=Cfg::Col_fields;
	$col_field_arr=explode(',',$col_fields);
	$post_target_clone_column_id=(!empty($post_target_clone_column_id))?$post_target_clone_column_id:$this->post_target_clone_column_id;
	//the rationale here is that cloned primary columns will not have gone through recursion and will have class value of post_target_clone_column_id
	 
			
	$q="select blog_id,$post_fields from $this->master_post_table where blog_table_base='".$col_table_base."' and blog_data6='$post_target_clone_column_id' and  blog_unstatus='unclone'";  // echo NL.NL.$q; 
	$r2=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	// Here we taking care of any unclones @ present level the below get columns and recursively pass in
	While ($rows2= $this->mysqlinst->fetch_assoc($r2,__LINE__)){
		$value='';  
		foreach ($post_field_arr as $field){
			$tablen='uncle_'.$this->tablename.'_id'.$rows2['blog_unclone'];
			$nblog_id=$rows2['blog_id'];
			if($field=='blog_table_base')$value.="'$this->tablename',";
			elseif($field=='blog_table')$value.="'$tablen',";
			elseif($field=='blog_pub')$value.="'1',";
			elseif($field==='blog_status')$value.="'clone',";//elseif($field==='blog_clone_target_base')$value.="'$col_table_base',";
			elseif($field==='blog_clone_target')$value.="'{$rows2['blog_data1']}',";//elseif($field==='blog_clone_table')$value.="'{$rows2['blog_table']}',";
			else $value.="'$rows2[$field]',";
			}
		$where="where blog_table='$tablen' and  blog_data1='{$rows2['blog_data1']}' and blog_data6='{$rows2['blog_data6']}' and blog_table_base='$this->tablename' "; // echo NL.NL.'where is: '.$where;
		$count=$this->mysqlinst->count_field($this->master_post_table,'blog_id','',false,$where);
		//echo NL.NL.$count. ' is count';
		if ($count <1){
			$q="insert into $this->master_post_table  ($post_fields,blog_update,blog_time,token) values ($value '".date("dMY-H-i-s")."','".time()."','".mt_rand(1,mt_getrandmax())."')";  // echo NL.NL.$q;
			$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
			 }
		
		}
			 
	
	
	
	
	//lets recurse in  
	$q="select blog_id,$post_fields from $db$this->master_post_table where blog_col='$parent_id' and blog_type='nested_column' order by blog_order"; //echo NL. $q;     
	$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);  
	if(!$this->mysqlinst->affected_rows()){
		$msg='CLONED AND ANY UNMIRRORS PRESERVED';
		$this->success[]="Your Column and All Post have been $msg";
		return;
		}
	While ($rows= $this->mysqlinst->fetch_assoc($r,__LINE__)){   
		$post_target_clone_column_id=($rows['blog_status']==='clone')?$rows['blog_data1']:$post_target_clone_column_id;
			#funct... clone preserve_unclone was adapted from functin copy_col except here we just copying unclones when	a column that contains clones contains unclones..
			#reference to this post_target_clone_column_id in all unclone posts  was set as blog_data6 when creating unclone
			#and represents the clone target column  unclones of posts within therefore have reference to this target parent 
			#since this is end of the line for actually accessing cloned preseves since they themselves are not duplicated
			#all nested levels within are accessed for unclone posts
			#through  the following select query
			#unclones on the other hand will actually be duplicated at this point....
			# clones are not duplicated, only by reference through the clone marker record   whereas
			#unclone referenced posts are all actually duplicated...
			 
			
			#**********************************************
		if	(is_numeric($rows['blog_data1'])){
				//run through all whether ==clone or not ==clone..
				$this->clone_preserve_unclone($rows['blog_data1'],$col_table_base,$db='',$post_target_clone_column_id); 
				}	
		 
		}//while
		
	}//end clone_preserve_unclone

	
function choose_column($child_id,$nested){
	$post_fields=Cfg::Post_fields;
	$post_field_arr=explode(',',$post_fields);
	
	echo '<div class="editbackground fsmblack"><!--choose column-->';  
	if (isset($_POST['column_copy_'.$child_id])&&!isset($_POST['column_copy_id_'.$child_id])){
		$this->message[]='You Did Not select a Column Id to '.$_POST['column_copy_'.$child_id];  
		}
	
	elseif (isset($_POST['column_copy_id_'.$child_id])&&!isset($_POST['column_copy_'.$child_id])){
		if (is_numeric(substr_replace(trim($_POST['column_copy_id_'.$child_id]),'',0,1))){
			$this->message[]='Select to either Copy/Clone/Move your intended Column in addition to Choosing a Valid Id: '.$_POST['column_copy_id_'.$child_id];  
			}
		else {
			$this->message[]='Select to either Copy/Clone/Move your intended Column. ';
			}
		}
	elseif (isset($_POST['column_copy_id_'.$child_id])&&strtolower(substr(trim($_POST['column_copy_id_'.$child_id]),0,1))!=='c'){
		$this->message[]='COLUMN IDs ARE FOUND AT THE TOP OF COLUMNS  HAVING AN Id: C#.. FORMAT AND INCLUDE THE C Prefix';
		}
	elseif (isset($_POST['column_copy_id_'.$child_id])){
		$parent_id=substr_replace(trim($_POST['column_copy_id_'.$child_id]),'',0,1);
		 
		$status=$_POST['column_copy_'.$child_id];
		$where="where col_id=$parent_id";   
		$count=$this->mysqlinst->count_field($this->master_col_table,'col_id','',false,$where);
		if ($count>0){ 
			$col_fields=Cfg::Col_fields;
			$col_fields_arr=explode(',',$col_fields);
			$q="select $col_fields from $this->master_col_table where col_id=$parent_id";
			$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
			$row = $this->mysqlinst->fetch_assoc($r,__LINE__);
			if ($nested&&in_array($parent_id,$this->column_id_array)&&$row['col_table_base']==$this->tablename){ 
				if (array_search($parent_id,$this->column_id_array)<=$this->column_level){//Ok to move etc. if nested column is moved to lower level in same column tree
					$this->message[]="Please Choose a distinct Nested Column Tree.  You have choosen to $status Column Id C$parent_id  INTO ITSELF OR ONE OF ITS NESTED COLUMNS Which Appears To Be a Mstake. this column level is $this->column_level";
					return;
					}
				}
			if ($status=='move'){
					if  ($row['col_table_base']==$this->tablename){  
						if ($nested){ ;
							
							if($row['col_primary']){//parent primary child nested
								/*column  move
								intrapage....
								if primary parent child nested   update new record insert
								set blog data1=parent column id
								set column to nested column...
								blog data2  parent table   //not imp
								no previous post to delete since primary*/
								$q="update  $this->master_post_table set blog_pub=1,blog_data1='$parent_id',blog_data2='',blog_update='".date("dMY-H-i-s")."',blog_time='".time()."' where blog_order='$this->blog_order' and blog_table='$this->blog_table' and blog_type='nested_column' and blog_data2='column_choice'";
								$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
								$q="update $this->master_col_table set col_primary=0,col_width='',col_time='".time()."',col_num=0 where col_id='$parent_id'";
								$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
								}
							else{//parent nested child nested
								 //delete new record blog insert...
								//update old parent blog  record changing references  blog_order  
								if ($this->blog_unstatus!=='unclone'){ 	
									$q="update $this->master_post_table SET blog_order='$this->blog_order',blog_table='$this->blog_table',token='".mt_rand(1,mt_getrandmax()). "',blog_update='".date("dMY-H-i-s")."',blog_time='".time()."' WHERE blog_data1='$parent_id' AND blog_table_base='$this->tablename' and blog_type='nested_column'";
									$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
									if ($this->mysqlinst->affected_rows()){
										 $q="delete from  $this->master_post_table where blog_order='$this->blog_order' and blog_table='$this->blog_table' and blog_type='nested_column' and blog_data2='column_choice'";
										$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
										}
									}
									
								else { //blog unclone
									//update new choice record...
									$q="update $this->master_post_table SET blog_data1='$parent_id',blog_data2='',blog_pub=1,token='".mt_rand(1,mt_getrandmax()). "',blog_update='".date("dMY-H-i-s")."',blog_time='".time()."' WHERE blog_id=$child_id";   
									$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
									if ($this->mysqlinst->affected_rows()){
										$q="delete from $this->master_post_table   WHERE blog_data1='$parent_id' AND blog_table_base='$this->tablename' and blog_type='nested_column' and blog_id !=$child_id";   
										$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);  
										}
									}
								}
							
							$this->nested_col_moved[$parent_id]=true;
							$this->success[]="Your Column Id: C$parent_id has been moved";
							return; 
							}
							
						else {//primary child  intra table
							//delete new child column marker record....
							 
							
							$q="delete from $this->master_col_table where col_id='$child_id' and col_temp='column_choice'";
							$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
							if($row['col_primary']){
								//parent primary  child primary  intra table
								//simply update parent parent column  col_num to current col_num  column order
							
								$q="update $this->master_col_table set col_num='$this->col_num',col_update='".date("dMY-H-i-s")."',col_time='".time()."',token='".mt_rand(1,mt_getrandmax()). "'  where col_id='$parent_id'";
								$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
								}
							else {
								//parent nested  child primary intra table
								// mark  parent nested column mark as primary and set col_num to current  width becomes default max
								//delete old nested_column order record as now is primary column!
								$q="delete from $this->master_post_table where blog_data1='$parent_id' and blog_status!='clone' and blog_type='nested_column' and blog_table_base='$this->tablename'";
								$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
								$q="update $this->master_col_table set col_num='$this->col_num',col_time='".time()."',col_primary=1,col_width='',col_update='".date("dMY-H-i-s")."',col_time='".time()."',token='".mt_rand(1,mt_getrandmax()). "' where col_id='$parent_id'";
								$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
								}
							$this->column_moved[$parent_id]=true;
							 
							}//end intra
						}
					else {   //interpage
						
						if (empty($row['col_primary'])){//parent nested
							//remove old record for nested column
							//count records to determine whether there is already a clone beginning with this column on this page which
							
							//which is probably a mistake
							//delete original posting...
							$where="WHERE blog_table_base='$this->tablename' and blog_type='nested_column' and blog_status='clone' and blog_data1='$parent_id'";
							$count=$this->mysqlinst->count_field($this->master_post_table,'blog_id','',false,$where);
							if ($count <1){
								$q="delete from  $this->master_post_table where blog_status!='clone' and blog_type='nested_column' and blog_data1='$parent_id' and blog_table_base='".$row['col_table_base']."'";   
								$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
								} 
							}
						else { //parent primary
							//count  primary check on clones
							$where="WHERE col_table_base='$this->tablename' and col_primary=1 and col_status='clone' and col_clone_target='$parent_id'";
							 
							$count=$this->mysqlinst->count_field($this->master_col_table,'col_id','',false,$where);
							 }
						if ($count >0){ 
							$this->message[]='There is  Already a Clone of Column Id'.$parent_id.' From Page Title: '.strtoupper(check_data::table_to_title($row['col_table_base'],__method__,__LINE__,__file__)).' on this Page.  To Be sure you wish to Move the Actual Parent Column and Not the Clone of it, Delete the Clone on this Page First then repeat what you did.  However, To Move the Clone on this page first Delete the clone on this page, then  Clone Column Id'.$parent_id.' Where you want on this page';
							}
						else { //still inter 
							if ($nested){//child nested    
							//  	update new record for child nested column set column parent_id to move it...
								 $q="update $this->master_post_table SET blog_data1='$parent_id',blog_data2='',blog_time='".time()."',blog_data2='{$this->tablename}_post_id$parent_id' where blog_order='$this->blog_order' and blog_table='$this->blog_table' and blog_type='nested_column' and blog_data2='column_choice'";  //blog_data2 being/was being used as reference  
								$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
									echo NL.$q;				
								}//end nested
							else {//child primary
								//remove the new inserted primary reccord column... 
								$q="delete from $this->master_col_table where col_id='$child_id' and col_temp='column_choice'";
								$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
								}
							//The parent column whether formally nested or primary will be updated
							//no need to delete parent  post param column... whether going to nested or primary
							//parent column references are being updated...
							$q="update $this->master_col_table set ";
							foreach ($col_fields_arr as $field) {
								if($field=='col_table_base')$q.="$field='$this->tablename',";
								elseif($field=='col_table')$q.="$field='{$this->tablename}_post_id$parent_id',";
								elseif($field=='col_num'){
									if ($nested)$q.="$field=0,";
									else $q.="$field='$this->col_num',";
									}
								elseif($field=='col_primary'){
									if ($nested)$q.="$field='0',";
									else $q.="$field='1',";
									}
								elseif($field=='col_width'){
									if ($nested&&!empty($row['col_primary']))$q.="$field=0,";
									elseif (empty($nested)&&empty($row['col_primary']))$q.="$field=0,";
									else $q.="$field='".$row['col_width']."',";
									}
								elseif($field=='col_status')$q.="$field='$status',";
								else  $q.="$field='$row[$field]',"; 
								}
							$q=substr_replace($q ,'',-1) . " where col_id=$parent_id"; echo NL. $q;
							$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
							$this->move_col($parent_id,'move',$row['col_table_base']);
							$this->success[]="Your Column Id: C$parent_id has been moved";
							}
						
						}//end interpage
					}
				#chooseclone
				elseif ($status==='clone'){
					$bo_update=''; //initialize 
					if ($nested){  
						$q="select blog_pub,blog_order,blog_table from $this->master_post_table where blog_data1='$parent_id' and blog_type='nested_column' and blog_status!='clone' ";//removed and blog_unstatus!='unclone'
						
						$rr=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
						if ($this->mysqlinst->affected_rows()){ 
							list($blog_pub,$blog_order,$blog_table )=$this->mysqlinst->fetch_row($rr);
							//check if the record is for a unclone if so update blog_order...
							 $bo_update= ($this->blog_unstatus=='unclone')? ", blog_order='$blog_order',blog_clone_table='$blog_table'":'';//blog table remains unclone so not called up normally but reference to real table made in blog_clone_table instead...
							}
						else if (empty($row['col_primary'])) {//presumably an unclone 
							 //$this->message[]=('Mirror Released Columns Should Not Be Directly Cloned.  Choose child or parent available options');
							 $this->message[]="no affected rows with $q";
							return;
							}
							
				 
						$q="update $this->master_post_table set blog_data1=$parent_id,blog_time='".time()."',blog_status='clone',blog_data2='',token='".mt_rand(1,mt_getrandmax()). "',blog_clone_target='$parent_id',blog_target_table_base='{$row['col_table_base']}' $bo_update  where blog_table='$this->blog_table' and blog_order='$this->blog_order'";  
						$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
						$this->success[]="Your Column Id: C$parent_id has been Cloned Here";
						}
					elseif (empty($row['col_primary'])) {//primary column clones nested column
						$value='';
						$blog_date=date("dMY-H-i-s");
						foreach ($post_field_arr as $field){
							if($field=='blog_type')$value.="'nested_column',";   
							elseif($field=='blog_data1')$value.="'$parent_id',";
							elseif($field=='blog_status')$value.="'clone',";
							elseif($field=='blog_col')$value.="'$child_id',";
							elseif($field=='blog_date')$value.="'$blog_date',";
							elseif($field=='blog_order')$value.="'10',";
							elseif($field=='blog_table')$value.="'{$this->tablename}_post_id$child_id',";
							elseif($field=='blog_table_base')$value.="'$this->tablename',";
							elseif($field=='blog_clone_target')$value.="'{$row['col_table_base']}',";
							elseif($field=='blog_temp')$value.="0,";
							elseif($field=='blog_pub')$value.="'1',";
							else $value.="'',";
							} 
						$q="insert into $this->master_post_table  ($post_fields,blog_update,blog_time,token) values ($value '".date("dMY-H-i-s")."','".time()."','".mt_rand(1,mt_getrandmax())."')";   
						$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
						$q="update $this->master_col_table set col_temp='',col_time='".time()."',token='".mt_rand(1,mt_getrandmax()). "' where col_id=$child_id";
						$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
						$this->success[]="Your Column Id: C$parent_id has been Cloned Here";
						}
					else if (!empty($row['col_primary'])) {
						$q="update $this->master_col_table set col_temp='',col_status='clone',col_time='".time()."',col_clone_target='$parent_id',col_clone_target_base='{$row['col_table_base']}',token='".mt_rand(1,mt_getrandmax()). "' where col_id=$child_id";
						$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
						$this->success[]="Your Column Id: C$parent_id has been Cloned Here";
						}
					
					if ($row['col_table_base']!==$this->tablename)
						$this->clone_preserve_unclone($parent_id,$row['col_table_base']);
					}
				else {//copy
					if ($nested){  
						#&&&&&&&&
						$col_fields=Cfg::Col_fields;
						$col_field_arr=explode(',',$col_fields); 
						$value='';
						foreach ($col_field_arr as $field) {
							if($field=='col_table_base')$value.="'$this->tablename',";
							else $value.="'0',"; 
							}    
						$q="insert into $this->master_col_table ($col_fields,col_update,col_time,token) values ($value '".date("dMY-H-i-s")."','".time()."','".mt_rand(1,mt_getrandmax())."')"; 
						#&&&&&&&&&&&&&&&&
						 
						$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
						$this->mysqlinst->count_field($this->master_col_table,'col_id','',false,'');  
						$col_id=$this->mysqlinst->fieldmax;
						//$new_child_id=$col_id;//
						// exit('nested  and '.$new_child_id);
						} 
					else $col_id=$child_id; 
					$q="update $this->master_col_table set ";
					foreach ($col_fields_arr as $field) {
						if($field=='col_table_base')$q.="$field='$this->tablename',";
						elseif($field=='col_table')$q.="$field='{$this->tablename}_post_id$col_id',";
						elseif($field=='col_num'){
							if (!empty($nested))$q.="$field=0,";
							}
						elseif($field=='col_primary'){
							if (!empty($nested))$q.="$field='0',";
							else $q.="$field='1',";
							}
						elseif($field=='col_width'){
							if ($nested&&!empty($row['col_primary']))$q.="$field='100',";
							elseif (empty($nested)&&empty($row['col_primary']))$q.="$field=0,";
							else $q.="$field='".$row['col_width']."',";
							}
						elseif($field=='col_clone_target')$q.="$field='',"; //$parent_id
						elseif($field=='col_clone_target_base')$q.="$field='',";//".$row['col_table_base']."
						elseif($field=='col_status'&&$status!=='move')$q.="$field='$status',";
						 elseif($field=='col_style')$q.="$field='".$this->back_image_copy($row['col_style'])."',"; 
						elseif($field=='col_grp_bor_style')$q.="$field='".$this->back_image_copy($row['col_grp_bor_style'])."',";
						else  $q.="$field='$row[$field]',";
						}
					$q="$q col_time='".time() . "' where col_id=$col_id";
					$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true); 
					 $preserve= (isset($_POST['column_copy_preserve_clones_'.$child_id]))?true:false;
					 
					$this->copy_col($col_id,$parent_id,$status,$preserve);
					if (!empty($nested)){//fill in blog_data1  ?blog_data2 not used anymore
						$q="update $this->master_post_table set blog_data1='$col_id',blog_data2='',blog_time='".time()."',token='".mt_rand(1,mt_getrandmax()). "' where blog_table='$this->blog_table' and blog_order='$this->blog_order'";
						$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
						}
					else {
						$q="update $this->master_col_table set col_temp='',col_time='".time()."',token='".mt_rand(1,mt_getrandmax()). "' where col_id='$col_id'";
						$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
						}
					$this->submit_button(); 
					 
					
					return;
					}
				}
			 
		else {
			 $msg="You entered an Invalid Column Id: C$parent_id to $status here";
			printer::alert_neg($msg);
			$this->message[]=$msg;
			}
		}
	$column=($nested)?'NESTED COLUMN':'PRIMARY COLUMN (sitting Directly in Main Body)';
	echo '<div class="fsminfo editcolor editbackground left floatleft"><!--wrap copy move clone column-->';
	printer::alertx('<p class="editbackground editcolor">Copy, Move or Clone a <span class="bold">'.$column.'</span>  including all its Nested Columns and Posts from any page Here. </p><br> If You <span class="bold">Copy </span> A Column it is editable and Completely Independant of the Original with a New Column Id.</p> <p><br> If You  <span class="bold"> Move</span> a Column the Original Column will be moved to the new location within the page or to another page and maintain the original Ids. Moving will preserve clones but not mirror releases which may be copied separately.</p> <p><br><span class="bold">Cloning </span> a Column from Another Page effectively makes an Template out of the Original Column.  <br>With A Cloned Column The Original Will Be Expressed Here and Will Not Be Editable And Changes Made To the Parent Column &#40;the Original&#41; will Appear in This Cloned Column and on Other Pages if Similarly Created </p> <p><br>Furthermore, With a Cloned Column, easily <span class="bold">Mirror release</span> Any Particlular Post/Nested Column Within it to Customize it for that Particular Page which Effectively means you can make a Clone of an Entire Page if you wanted to then Customize the Page Specific Portion!!</p>');
	 
	if ($nested){
		$delete_msg= 'Remove This Choose Column Post';
		printer::alertx('<p class="editbackground redAlert floatleft"><input type="checkbox" name="delete_blog['.$this->blog_table.']['.$this->blog_order.']" value="delete" onchange="edit_Proc.oncheck(\'delete_blog['.$this->blog_table.']['.$this->blog_order.']\',\'THIS ENTRY WILL BE DELETED WHEN YOU HIT CHANGE, UNCHECK TO CANCEL\')" >'.$delete_msg.'</p>');
		}
	else { 
		echo '<p class="left neg"><input type="checkbox" name="deletecolumn['.$this->col_table.']" value="delete" onchange="edit_Proc.oncheck(\'deletecolumn['.$this->col_table.']\',\'Deleting This Column Choice Option, UNCHECK TO CANCEL \');" >Delete This Column Choice Option</p>';
		}
	printer::pclear();
	/*$this->show_more('About Copy/Clone/Move Choices','About Column Choices','','',400);
		
	printer::printx('<p class="fsminfo editbackground "> </p>');
	$this->show_close('column choices');//column choices
	*/ 
	printer::printx('<p class="editfont editcolor editbackground"><input type="radio" name="column_copy_'.$child_id.'" value="copy">Copy Column');
	printer::printx('<span class="small info" title="By default Cloned Columns and Posts will be Copied as independent duplicates. Checking here will preserve them as clones instead together with any associated mirror releases"><input type="checkbox" name="column_copy_preserve_clones_'.$child_id.'" value="preserve">Option: Preserve Clone/Mirror release Post Status within Copied Columns</span></p>');
	printer::printx('<p class="editfont editcolor editbackground"><input type="radio" name="column_copy_'.$child_id.'" value="clone">Clone Column Here</p>');
	printer::printx('<p class="editfont editcolor editbackground"><input type="radio" name="column_copy_'.$child_id.'" value="move" >Move Column</p>');
	//onchange="edit_Proc.oncheck(\'column_copy_'.$child_id.'\',\'CAUTION THE ORIGINAL ENTRY WILL BE DELETED AND MOVED HERE WHEN YOU HIT CHANGE, UNCHECK TO CANCEL\');"
	//printer::printx('<p class="fsminfo editbackground  left">Be sure to enter the Column Id which are uniqe to each Column and can be found under the Column# which simply references the Column Order and is subject to change. Both can be found at the top of each column  and also in the tech info under settings.!</p>');
	printer::printx('<p class="editfont editcolor editbackground" title="Be Sure to Enter the Column Id  Which Begin with a C ie C10.  Do Not Use the Column# which simply refers to the Column Display Order Within the Page. Both column Ids and #s are displayed at the top of each Column"><input style="background:#'.$this->editor_background.';color:#'.$this->editor_color.';" type="text" name="column_copy_id_'.$child_id.'"  size="5" maxlength="8">Enter the <span class="info">Column Id </span><span class="red">(Not Column#)</span> that you wish to Copy/Move/Clone</p>');
	printer::pclear(10);
	$this->show_more('Import Column','','editbackround small info ','Import a column from template master tables or a database');
	
	$this->show_close('Import Column');
	
	echo '</div><!--wrap copy move clone  column-->';
	printer::pclear();
	echo '</div><!--choose column-->';
	
	$this->submit_button(); 
	}
	
	
function choose_post(){ 
	static $inc=0;  $inc++;
	$post_fields=Cfg::Post_fields;
	$post_field_arr=explode(',',$post_fields);
	echo '<div class="editbackground fsmblack"><!--choose post-->';
	if (isset($_POST['post_copy_'.$this->blog_id])&&!isset($_POST['post_copy_id_'.$this->blog_id])){
		$this->message[]='You Did Not select a Post Id to '.$_POST['post_copy_'.$this->blog_id];  
		}
	
	elseif (isset($_POST['post_copy_id_'.$this->blog_id])&&!isset($_POST['post_copy_'.$this->blog_id])){
		if (is_numeric($_POST['post_copy_id_'.$this->blog_id])){
			$this->message[]='Select to either Move Copy or Clone Your intended post in addition to Choosing a Valid Id '.$_POST['post_copy_id_'.$this->blog_id];  
			}
		else {
			$this->message[]='Select to either Move Copy or Clone your intended post. <br> ';
			}
		}
	#############333
	elseif (isset($_POST['post_copy_id_'.$this->blog_id])&&strtolower(substr(trim($_POST['post_copy_id_'.$this->blog_id]),0,1))!=='p'){
		$this->message[]='Post IDs Are FOUND AT THE TOP OF Each Post ie. The Number having the ID: P#.. FORMAT. BE SURE TO INCLUDE THE P PREFIX ';
		}
	 
		
		#############
	elseif (isset($_POST['post_copy_id_'.$this->blog_id])){  
		$parent_id=substr_replace(trim($_POST['post_copy_id_'.$this->blog_id]),'',0,1);    
		$status=$_POST['post_copy_'.$this->blog_id];   
		$where="where blog_id='$parent_id'"; 
		$count=$this->mysqlinst->count_field($this->master_post_table,'blog_id','',false,$where);
		if ($count>0){  
			$post_fields=Cfg::Post_fields;
			$post_fields_arr=explode(',',$post_fields);
			$q="select $post_fields from $this->master_post_table where blog_id=$parent_id";
			$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
			$row = $this->mysqlinst->fetch_assoc($r,__LINE__);
			if ($row['blog_type']=='nested_column'){
				$msg="Your Post Choice is actually a Nested Column.  To Copy/Clone or Move a Column Choose this Option from the dropdown Menu along with the Column Id";
				$this->message[]=$msg;
				}
			if ($status=='copy'){//remember original will be copied not clone   however with subsequent nested  post differrnt depending on preserve status   
				$q="update $this->master_post_table as c, $this->master_post_table as p set ";
				foreach ($post_field_arr as $field){ 
					if ($field=='blog_col'||$field=='blog_order'||$field=='blog_table'||$field=='blog_table_base'||$field=='blog_status'||$field=='blog_unstatus'||$field=='blog_unclone'||$field=='blog_clone_target'||$field=='blog_target_table_base')continue; 
				if ($field=='blog_type'){
					if ($row['blog_type']=='image'||$row['blog_type']=='float_image_right'||$row['blog_type']=='float_image_left'){ 
						$q.="c.blog_data1='".$this->image_copy('image',$row['blog_data1'])."', ";//duplicate image
						}
					elseif ($row['blog_type']=='auto_slide'){ 
						$q.="c.blog_data1='".$this->image_copy('auto_slide',$row['blog_data1'])."', ";//duplicate slide iamges
						}
					elseif ($row['blog_type']=='gallery'){ 
						$q.="c.blog_data1='".$this->image_copy('gallery_copy',$row['blog_data1'],$row['blog_table_base'])."', ";//duplicate gallery
						}
					elseif ($row['blog_type']=='navigation_menu'){ 
						$q.="c.blog_data1='".$this->navigation_copy($row['blog_data1'])."',";//duplicate nav
						}
					else $q.="c.blog_data1=p.blog_data1, ";
					}
				if ($field=='blog_border_start')$q.="c.blog_border_start=0, ";
				elseif ($field=='blog_border_stop')$q.="c.blog_border_stop=0, ";
				elseif ($field=='blog_style')$q.="c.blog_style='".$this->back_image_copy($row['blog_style'])."', "; 
				elseif ($field=='blog_data2')$q.="c.blog_data2='".$this->back_image_copy($row['blog_data2'])."', "; 
				elseif ($field=='blog_data3')$q.="c.blog_data3='".$this->back_image_copy($row['blog_data3'])."', "; 
				elseif ($field=='blog_data4')$q.="c.blog_data4='".$this->back_image_copy($row['blog_data4'])."', "; 
				elseif ($field=='blog_data5')$q.="c.blog_data5='".$this->back_image_copy($row['blog_data5'])."', ";
				elseif ($field=='blog_data6')$q.="c.blog_data6='".$this->back_image_copy($row['blog_data6'])."', ";
				elseif ($field=='blog_data7')$q.="c.blog_data7='".$this->back_image_copy($row['blog_data7'])."', ";
				elseif ($field !=='blog_data1'){ 
				    $q.="c.$field=p.$field, ";
				    }
				
				}//end while
				//$q=substr_replace($q,'',-2);
				$q.="c.blog_status='copy' where c.blog_id='$this->blog_id' and p.blog_id='$parent_id'";    
				$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
				if ($this->mysqlinst->affected_rows()){
					$this->copy_comment($parent_id,$this->blog_id);
					$this->success[]="Your post Id: P$parent_id has been copied to P$this->blog_id!";
					}
				}
			elseif ($status=='move'){
				$q="update $this->master_post_table as c, $this->master_post_table as p set ";
				foreach ($post_field_arr as $field){ 
					if ($field=='blog_col'||$field=='blog_order'||$field=='blog_table'||$field=='blog_table_base'||$field=='blog_status'||$field=='blog_unstatus'||$field=='blog_unclone'||$field=='blog_clone_target'||$field=='blog_target_table_base')continue; 
				if ($field=='blog_type'){ 
					if ($row['blog_type']=='gallery'&&$row['blog_table_base']!==$this->tablename){
						$q.="c.blog_data1='".$this->image_copy('gallery_move',$row['blog_data1'],$row['blog_table_base'])."', ";//duplicate gallery	 
						}
					else $q.="c.blog_data1=p.blog_data1, ";
					}
				if ($field !=='blog_data1'){ 
				    $q.="c.$field=p.$field, ";
				    }
				}//end while
				//$q=substr_replace($q,'',-2);
				$q.="c.blog_status='move' where c.blog_id='$this->blog_id' and p.blog_id='$parent_id'";   
				$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);  
				$this->success[]="Your post Id: P$parent_id has been copied!";
				
				$q="delete from $this->master_post_table where blog_id='$parent_id'";
				$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
				$q="update $this->master_post_table set blog_id='$parent_id' where blog_id='$this->blog_id'";//keep original
				 
				$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);  //blog_id   updating can be changed aound the other way to update directly...  as time permits
				$this->success[]="Your post Id: P$parent_id has been moved !";
				$this->blog_moved[$parent_id]=true;	
				} 
			elseif ($status=='clone'){
				//check if the record is for a unclone if so update blog_order...
				 $bo_update= ($this->blog_unstatus=='unclone')? ', blog_order='.$row['blog_order'].",blog_clone_table='".$row['blog_table']."'":'';
				$q="update $this->master_post_table set blog_status='clone',blog_pub=1,blog_data2='',blog_type='',blog_clone_target='$parent_id',token='".mt_rand(1,mt_getrandmax()). "' $bo_update where blog_id='$this->blog_id'";
				$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
				$this->success[]="Your post Id: P$parent_id has been Cloned";
				 
				}
			}
		else $this->message[]="Post P$parent_id was not found";
		}	  
	 echo '<div class="fsminfo editcolor editbackground  left floatleft"><!--wrap copy move clone post-->';
	printer::alertx('<p>Copy, Move or Clone a <span class="bold">POST</span> Here </p><br> If You <span class="bold">Copy </span> A post it is editable and Completely Independant of the Original.</p> <p><br> If You  <span class="bold"> Move</span> a post Here the Original Will Be Deleted!</p> <p><br> With A <span class="bold">Cloned </span>  post The Original Will Be Expressed Here and this Clone Will Not Be Editable But Changes Made To the Original Parent Post will Appear in this and any other Child Clone of this Post. </p>');
	  $this->delete_option();
	printer::pclear();
	$this->show_more('About Copy/Clone/Move Choices','noback','','',400);
		
	printer::printx('<p class="fsminfo editbackground ">The Choices offer flexibility in how to utilize previously created webpages, templates and posts. Copying Posts wil create independent duplicates.  Cloning  posts mirrors the original such that when changes are made to the original the cloned similarly changes.  Moving posts removes the post from the original location moving it to the new location. </p>');
	$this->show_close('coluimn choices');//coluimn choices
	printer::printx('<p class="editfont editcolor editbackground"><input type="radio" name="post_copy_'.$this->blog_id.'" size="8" maxlength="8" value="copy">Copy Post</p>');
	printer::printx('<p class="editfont editcolor editbackground"><input type="radio" name="post_copy_'.$this->blog_id.'"  size="8" maxlength="8" value="clone">Clone post Here</p>');
	printer::printx('<p class="editfont editcolor editbackground"><input type="radio" name="post_copy_'.$this->blog_id.'"  size="8" maxlength="8" value="move">Move post Here</p>');
	//printer::printx('<p class="fsminfo editbackground  left">Be sure to enter the post Id which are uniqe to each post and can be found under the post# which simply references the post Order and is subject to change. Both can be found at the top of each post  and also in the tech info under settings.!</p>');
	printer::printx('<p class="editfont editcolor editbackground" title="Be Sure to Use the Post Id Which Begins with a P ie P42.  Do Not Use the  Post# which simply refer to the Post Display Order Within the Column. Post Ids and #s are displayed at the top of each post"><input  style="background:#'.$this->editor_background.';color:#'.$this->editor_color.';" type="text" name="post_copy_id_'.$this->blog_id.'"  size="8" maxlength="8">Enter the  <span class="info">Post Id</span> <span class="red">(Not Post#) </span>that you wish to Copy Move or Clone</p>');
	 echo '</div><!--wrap copy move clone post-->';
	echo '</div><!--choose post-->';
	$this->submit_button();  
	}
		
function move_col($parent_id,$status,$table_base){  //$status always 'move'
	 
	static $inc=0;  $inc++;
	$page_fields=Cfg::Page_fields;
	$post_fields=Cfg::Post_fields;
	$post_field_arr=explode(',',$post_fields);
	$col_fields=Cfg::Col_fields;
	$col_field_arr=explode(',',$col_fields);
	$q="select blog_id,$post_fields from $this->master_post_table where blog_col=$parent_id";    
	$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);  
	if(!$this->mysqlinst->affected_rows())return;
	While ($rows= $this->mysqlinst->fetch_assoc($r,__LINE__)){
		
		$q="update $this->master_post_table set ";
		foreach ($post_field_arr as $field) {
			//if ($this->tablename!==$table_base){//no name change if same page  NOT need i would think
			if ($field=='blog_data1'){
				if ($rows['blog_type']=='gallery'){ 
					//$this->image_copy('gallery_move',$rows['blog_id'],$rows['blog_data1']);//duplicate image
					 $q.="$field='".$this->image_copy('gallery_move',$rows['blog_data1'],$rows['blog_table_base'])."',";//change gall table ref etc.
					}
				}
				//}
			elseif($field=='blog_table_base')$q.="$field='$this->tablename',";
			elseif($field=='blog_table')$q.="$field='{$this->tablename}_post_id$parent_id',";
			elseif($field=='blog_status'){
				if ($rows['blog_status']!=='clone')$q.="$field='$status',";
				else $q.="$field='clone',";
				}
			 //elseif($field=='blog_unclone')$q.="$field='',";
			
			//elseif($field=='blog_unstatus')$q.="$field='',";
			else  $q.="$field='$rows[$field]',";
			}
			 
		$q="$q blog_update='".date("dMY-H-i-s")."',blog_time='".time()."' where blog_id='".$rows['blog_id']."'";     
		$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
		
		
				#***************************************
		 if  ($rows['blog_type']=='nested_column'&&is_numeric($rows['blog_data1'])&&$rows['blog_status']=='clone') {
			$data6=$rows['blog_data1'];//this was set in creating unclone and represents the clone parent column target for unclone moving
			$q="select blog_id,blog_unclone,blog_type,blog_data1  from $this->master_post_table where blog_table_base='$table_base' and blog_data6='$data6' and  blog_unstatus='unclone'";
			$r2=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
			While ($rows2= $this->mysqlinst->fetch_assoc($r2,__LINE__)){
				$tablen='uncle_'.$this->tablename.'_id'.$rows2['blog_unclone'];
				$blog_id=$rows2['blog_id'];
				$q="update $this->master_post_table set blog_table_base='$this->tablename',blog_table='$tablen', blog_update='".date("dMY-H-i-s")."',blog_time='".time()."' where blog_id='$blog_id'";   
				$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
				 if  ($rows2['blog_type']=='nested_column'&&is_numeric($rows2['blog_data1'])){
					$q="select $col_fields from $this->master_col_table where col_id=".$rows2['blog_data1'];   
					$r4=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
					$row3 = $this->mysqlinst->fetch_assoc($r4,__LINE__); 
					$q="update $this->master_col_table set ";
					foreach ($col_field_arr as $field) {
						if($field=='col_table_base')$q.="$field='$this->tablename',";
						elseif($field=='col_table')$q.="$field='{$this->tablename}_post_id{$rows2['blog_data1']}',";
						elseif($field=='col_num')$q.="$field=0,";
						elseif($field=='col_primary')$q.="$field='0',"; 
						elseif($field=='col_status')$q.="$field='$status',";
						else  $q.="$field='$row3[$field]',";
						}
					$q="$q col_update='".date("dMY-H-i-s")."',col_time='".time()."' where col_id={$rows2['blog_data1']}";
					$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);	
					 $this->move_col($rows2['blog_data1'],'move',$table_base);
					}
				}
			}
	
		#***********************************************************************end presere	
			
			//echo "$parent_id is parent id and data1 is ".$rows['blog_data1']." and blod id is ".$rows['blog_id']; 
		elseif  ($rows['blog_type']=='nested_column'&&is_numeric($rows['blog_data1'])&&$rows['blog_status']!=='clone'){
			$q="select $col_fields from $this->master_col_table where col_id=".$rows['blog_data1'];   
			$r3=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
			$row = $this->mysqlinst->fetch_assoc($r3,__LINE__); 
			$q="update $this->master_col_table set ";
			foreach ($col_field_arr as $field) {
				if($field=='col_table_base')$q.="$field='$this->tablename',";
				elseif($field=='col_table')$q.="$field='{$this->tablename}_post_id{$rows['blog_data1']}',";
				elseif($field=='col_num')$q.="$field=0,";
				elseif($field=='col_primary')$q.="$field='0',"; 
				elseif($field=='col_status')$q.="$field='$status',"; 
				else  $q.="$field='$row[$field]',";
				}
			$q="$q col_update='".date("dMY-H-i-s")."',col_time='".time()."' where col_id={$rows['blog_data1']}";
			$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
			
			$this->move_col($rows['blog_data1'],$status,$table_base);
			}
		}//while 
	}	//end move column 


function navigation_copy($nav_id,$db=''){
	(empty($n_table))&&$n_table=$this->tablename;
	if (is_numeric($nav_id)&&$nav_id > 0){  
		$dir_fields=Cfg::Dir_fields;
		$dir_field_arr=explode(',',$dir_fields);
		$this->mysqlinst->count_field($this->directory_table,'dir_menu_id','',false,'');
		$new_dir_ref=$this->mysqlinst->field_inc;
		$q="select $dir_fields from $db.$this->directory_table where dir_menu_id='$nav_id' ";   
		$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
		if(!$this->mysqlinst->affected_rows()){
			$this->message[]='No Menu Id Copied: '.$q;
			return;
			}
		While ($rows= $this->mysqlinst->fetch_assoc($r,__LINE__)){
			$value='';  
			foreach ($dir_field_arr as $field) {
				if ($field=='dir_menu_id')$value.="'$new_dir_ref',";
				else $value.="'$rows[$field]',";
				}
			$q="insert into  $this->directory_table  ($dir_fields,dir_update,dir_time,token) values ($value '".date("dMY-H-i-s")."','".time()."','".mt_rand(1,mt_getrandmax())."')";    
			$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
			}
		}
	else return $nav_id; 
	return $new_dir_ref;
	}
	
	
function copy_comment($parent_id,$child_id,$db=''){  
	if (!empty($db))return;
	$com_fields=Cfg::Comment_fields;
	$com_field_arr=explode(',',$com_fields);
	$count=$this->mysqlinst->count_field($this->comment_table,'com_id','',false,"where com_blog_id='$parent_id'");   
	if ($count < 1)return;
	$q="select $com_fields from $this->comment_table where com_blog_id='$parent_id' ";  
	$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	if(!$this->mysqlinst->affected_rows()){  
		return;
		} 
	While ($rows= $this->mysqlinst->fetch_assoc($r,__LINE__)){
		$value='';  
		foreach ($com_field_arr as $field) {
			if ($field=='com_blog_id')$value.="'$child_id',";
			else $value.="'$rows[$field]',";
			}
		$q="insert into  $this->comment_table  ($com_fields,com_update,com_time,token) values ($value '".date("dMY-H-i-s")."','".time()."','".mt_rand(1,mt_getrandmax())."')";     
		$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
		$this->instruct[]='<span style="color:red">Caution:</span> Comments were also  Copied';
		}
	}

function back_image_copy($field_val){ 
	$indexes=explode(',',Cfg::Style_functions );
	foreach($indexes as $key =>$index){
		if (!empty($index)) {
			${$index.'_index'}=$key; 
			}
		}
	$style_array=explode(',',$field_val);
	$count=count($style_array);
	if ($count  < $background_index)
		return $field_val; 
	$background=$style_array[$background_index];
	$dbbackground_array=explode('@@',$background);
	$backindexes=explode(',',Cfg::Background_styles);
	foreach($backindexes as $key =>$index){   
	    ${$index.'_index'}=$key;
	    }
	$count=count($backindexes);
	for ($i=0; $i<$count; $i++){
		(!array_key_exists($i,$dbbackground_array))&&$dbbackground_array[$i]=0;
		}
	if (empty($dbbackground_array[$background_image_index]))
		return $field_val; 
	$oldfile=$dbbackground_array[$background_image_index];
	$newfile=$dbbackground_array[$background_image_index]=process_data::copy_new_image($oldfile,Cfg_loc::Root_dir.Cfg::Upload_dir);
	if (!$newfile)return $field_val;
	$style_array[$background_index]=implode('@@',$dbbackground_array);
	$style_implode=implode(',',$style_array);
	$this->list[]=$style_implode;
	if (is_file(Cfg_loc::Root_dir.Cfg::Background_image_dir.$oldfile)) {
		if (!copy(Cfg_loc::Root_dir.Cfg::Background_image_dir.$oldfile,Cfg_loc::Root_dir.Cfg::Background_image_dir.$newfile))$this->message[]=printer::alert_neg("CopY Error ".Cfg_loc::Root_dir.Cfg::Background_image_dir.$oldfile .'=>'.Cfg_loc::Root_dir. Cfg::Background_image_dir.$newfile ,1.2,true);
		}
	return $style_implode;
		 	
	}
function image_copy($type,$field_val,$s_table='',$n_table='',$db=''){
	(empty($n_table))&&$n_table=$this->tablename;
	if ($type=='image'){
		if (empty($field_val)) return;
		$pic_update=process_data::copy_new_image($field_val,Cfg_loc::Root_dir.Cfg::Upload_dir);//relies on local system to copy page_image and page_image_expanded
		if(strpos($pic_update,'.')===false)return $field_val;
		list($file,$alt)=process_data::process_pic($pic_update);
		list($ifile,$ialt)=process_data::process_pic($field_val);
		//copy(Cfg_loc::Root_dir.Cfg::Page_images_dir.$ifile,Cfg_loc::Root_dir.Cfg::Page_images_dir.$file);
		#resized response directory photos will auto generate as required
		if (is_file(Cfg_loc::Root_dir.Cfg::Page_images_expand_dir.$ifile)){
			copy(Cfg_loc::Root_dir.Cfg::Page_images_expand_dir.$ifile,Cfg_loc::Root_dir.Cfg::Page_images_expand_dir.$file);
			}
		else printer::alert_neg('copying file: '.Cfg_loc::Root_dir.Cfg::Page_images_expand_dir.$ifile.' does not exist in '.__METHOD__);
		return $pic_update;
		}
	elseif ($type=='auto_slide'){
		$img_arr=array();
		if (empty($field_val)) return;
		$pics=explode(',',$field_val);   
		foreach ($pics as $image){
			$img_arr[]=process_data::copy_new_image($image,Cfg_loc::Root_dir.Cfg::Upload_dir);
			}
		 
		$arr=implode(',',$img_arr);   
		return $arr;
		}
	elseif ($type=='gallery_move'){
		$q="select gall_ref from  $this->master_gall_table where gall_table='$n_table'";  
		$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); 
		if ($this->mysqlinst->affected_rows()){
			$tbn_arr=array();
			while(list($gall_ref)=$this->mysqlinst->fetch_row($r,__LINE__)){
				$tbn_arr[]=$gall_ref;
				}
			$n=1;
			While (in_array($n_table.'_'.$n,$tbn_arr)){
				$n++;
				}
			$gall_ref=$n_table.'_'.$n;
			}
		else $gall_ref=$n_table.'_1';
		$q="update $this->master_gall_table set gall_update='".date("dMY-H-i-s")."', gall_ref='$gall_ref', gall_table='$n_table' where gall_ref='$field_val'"; 
		$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
		file_generate::expand_file($gall_ref,$n_table);
		return $gall_ref;
		}//end gall move
	elseif ($type=='gallery_copy'){  
		$gall_fields=Cfg::Gallery_fields;
		$gall_field_arr=explode(',',$gall_fields);
		$q="select gall_ref from $this->master_gall_table where gall_table='$n_table'"; 
		$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); 
		if ($this->mysqlinst->affected_rows()){
			$tbn_arr=array();
			while(list($gall_ref)=$this->mysqlinst->fetch_row($r,__LINE__)){
				$tbn_arr[]=$gall_ref;
				}
			$n=1;
			While (in_array($this->tablename.'_'.$n,$tbn_arr)){
				$n++;
				}
			$new_gall_ref=$n_table.'_'.$n;
			}
		else $new_gall_ref=$n_table.'_1';  
		$q="select pic_id,$gall_fields from $db.$this->master_gall_table where gall_ref='$field_val'";   
		$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
		if(!$this->mysqlinst->affected_rows())return;
		While ($rows= $this->mysqlinst->fetch_assoc($r,__LINE__)){ 
			$new_picname=process_data::copy_new_image($rows['picname'],Cfg_loc::Root_dir.Cfg::Upload_dir);
			$value='';  
			foreach ($gall_field_arr as $field) {
				if ($field=='master_gall_ref')$value.="'',"; 
				elseif($field=='gall_ref')$value.="'$new_gall_ref',";
				elseif($field=='gall_table')$value.="'$n_table',";
				elseif($field=='picname')$value.="'$new_picname',";
				else $value.="'$rows[$field]',";
				}
			$q="insert into $this->master_gall_table  ($gall_fields,gall_update,gall_time,token) values ($value '".date("dMY-H-i-s")."','".time()."','".mt_rand(1,mt_getrandmax())."')";    
			$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
			}//end while 
		}
	file_generate::expand_file($new_gall_ref,$n_table);
	return $new_gall_ref;
	}
	
	
	
function copy_col($child_id,$parent_id,$status,$preserve='',$table_base='',$db=''){//table base may be new theme table base
	static $inc=0;  $inc++;
	$table_base=(empty($table_base))?$this->tablename:$table_base;
	$page_fields=Cfg::Page_fields;
	$post_fields=Cfg::Post_fields;
	$post_field_arr=explode(',',$post_fields);
	$col_fields=Cfg::Col_fields;
	$col_field_arr=explode(',',$col_fields);
	$q="select blog_id,$post_fields from $db$this->master_post_table where blog_col=$parent_id order by blog_order";     
	$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);  
	if(!$this->mysqlinst->affected_rows())return;
	While ($rows= $this->mysqlinst->fetch_assoc($r,__LINE__)){   
		$value='';
		//echo NL." preserve is $preserve";
		//echo NL.$rows['blog_id']. ' is rows blog id and rows blog status is '.$rows['blog_status'];
		//continue;
		if (!$preserve&&$rows['blog_status']=='clone'&&is_numeric($rows['blog_clone_target'])){
			$q="select blog_id,$post_fields from $db$this->master_post_table where blog_id=".$rows['blog_clone_target'];
			$rget=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
			if(!$this->mysqlinst->affected_rows())continue;
			$rows= $this->mysqlinst->fetch_assoc($rget,__LINE__);//here we substitute the holder record for the cloned record without disrupting the while statement!!
			}
		foreach ($post_field_arr as $field){  
			if ($field=='blog_data1'){
				if (($rows['blog_type']=='image'||$rows['blog_type']=='float_image_right'||$rows['blog_type']=='float_image_left')){
					if ($preserve && $rows['blog_status']=='clone')
						  $value.="'$rows[$field]',";
					else $value.="'".$this->image_copy('image',$rows['blog_data1'])."',";//duplicate image
					}
				elseif ($rows['blog_type']=='auto_slide'){ 
					if ($preserve && $rows['blog_status']=='clone')
						  $value.="'$rows[$field]',";
					else $value.="'".$this->image_copy('auto_slide',$rows['blog_data1'],$db)."',";//duplicate image
					
					}
				elseif ($rows['blog_type']=='gallery'){ 
					if ($preserve && $rows['blog_status']=='clone')
						  $value.="'$rows[$field]',";
					else $value.="'".$this->image_copy('gallery_copy',$rows['blog_data1'],$rows['blog_table_base'],$table_base,$db)."',";//duplicate image
					}
				elseif ($rows['blog_type']=='navigation_menu'){ 
					if ($preserve && $rows['blog_status']=='clone')
						  $value.="'$rows[$field]',";
					else $value.="'".$this->navigation_copy($rows['blog_data1'],$db)."',";//duplicate image
					}
				else  $value.="'$rows[$field]',";
				}
			 
			
			elseif($field=='blog_table_base')$value.="'$table_base',";
			elseif($field=='blog_table')$value.="'{$table_base}_post_id$child_id',";
			elseif($field=='blog_col')$value.="'$child_id',";
			elseif ($field=='blog_style')$value.="'".$this->back_image_copy($rows['blog_style'])."',"; 
			elseif ($field=='blog_data2')$value.="'".$this->back_image_copy($rows['blog_data2'])."',"; 
			elseif ($field=='blog_data3')$value.="'".$this->back_image_copy($rows['blog_data3'])."',"; 
			elseif ($field=='blog_data4')$value.="'".$this->back_image_copy($rows['blog_data4'])."',"; 
			elseif ($field=='blog_data5')$value.="'".$this->back_image_copy($rows['blog_data5'])."',";
			elseif ($field=='blog_data6')$value.="'".$this->back_image_copy($rows['blog_data6'])."',";
			elseif ($field=='blog_data7')$value.="'".$this->back_image_copy($rows['blog_data7'])."',";
			elseif($field=='blog_status'){
				if ($preserve && $rows['blog_status']=='clone')
						  $value.="'clone',";
				else $value.="'copy',";
				}
			elseif($field=='blog_unclone')$value.="'',";
			elseif($field=='blog_unstatus')$value.="'',";
			elseif($field=='blog_pub')$value.="'1',";
			elseif($field=='blog_clone_target'){
			if ($preserve && $rows['blog_status']=='clone')
						  $value.="'$rows[$field]',";
				else $value.="'',";
				}
			
			else $value.="'$rows[$field]',";
			} 
		$q="insert into $this->master_post_table  ($post_fields,blog_update,blog_time,token) values ($value '".date("dMY-H-i-s")."','".time()."','".mt_rand(1,mt_getrandmax())."')";  
		$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
		$this->mysqlinst->count_field($this->master_post_table,'blog_id','',false,'');  
		$blog_id=$this->mysqlinst->fieldmax;   
		$this->copy_comment($rows['blog_id'],$blog_id,$db);
		//echo "$child_id is childid and $parent_id is parent id and $preserve is preserve and ".$rows['blog_status'] ." is blog status";
		
		#***************preserve unclone section**************************
		if  ($preserve&&$rows['blog_type']=='nested_column'&&is_numeric($rows['blog_data1'])&&$rows['blog_status']=='clone') {  
			$post_target_clone_column_id=$rows['blog_data1'];
			#reference to this post_target_clone_column_id in all unclone posts  was set as blog_data6 when creating unclone
			#and represents the clone target column  unclones of posts within therefore have reference to this target parent 
			#since this is end of the line for actually accessing cloned preseves since they themselves are not duplicated
			#all nested levels within are accessed for unclone posts
			#throught the following select query
			#unclones on the other hand will actually be duplicated at this point....
			#to reiterate: preserved clones are not duplicated, only by reference through the clone marker record is ... whereas
			#unclone referenced posts are all actually duplicated...
			$q="select blog_id,$post_fields from $this->master_post_table where blog_table_base='".$rows['blog_table_base']."' and blog_data6='$post_target_clone_column_id' and  blog_unstatus='unclone'";    
			$r2=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
			
			#rows = parent_blog to copy
			#rows2=  cloned reference in parent blog when presever status is used
			While ($rows2= $this->mysqlinst->fetch_assoc($r2,__LINE__)){
				$value='';  
				foreach ($post_field_arr as $field) {
					$tablen='uncle_'.$table_base.'_id'.$rows2['blog_unclone'];
					$nblog_id=$rows2['blog_id'];
					if($field=='blog_table_base')$value.="'$table_base',";
					elseif($field=='blog_table')$value.="'$tablen',";
					elseif($field=='blog_pub')$value.="'1',";
					else $value.="'$rows2[$field]',";
					}
				$q="insert into $this->master_post_table  ($post_fields,blog_update,blog_time,token) values ($value '".date("dMY-H-i-s")."','".time()."','".mt_rand(1,mt_getrandmax())."')";   
				$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
				$this->mysqlinst->count_field($this->master_post_table,'blog_id','',false,'');  
				$blog_id=$this->mysqlinst->fieldmax;
				if	($rows2['blog_type']=='nested_column'&&is_numeric($rows2['blog_data1'])){
					$q="select $col_fields from $this->master_col_table where col_id=".$rows2['blog_data1'];    
					$r4=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
					$row3 = $this->mysqlinst->fetch_assoc($r4,__LINE__);
					#rows = parent_blog to copy
					#rows2=  cloned reference in parent blog when presever status is used
					#rows3= cloned column values when column is directly cloned and preversed
					#xxxxxx
					$value='';
					foreach ($col_field_arr as $field) {
						if($field=='col_table_base')$value.="'$table_base',";
						elseif($field=='col_table')$value.="'',";
						elseif($field=='col_num')$value.="0,";
						elseif($field=='col_status')$value.="'copy',";
						elseif($field=='col_clone_target')$value.="'',";//.$rows['blog_data1']."',";//uncecesary
						elseif($field=='col_clone_target_base')$value.="'',";//.$rows3['col_table_base']."',";//unnecessary
						elseif($field=='col_primary')$value.="'0',";
						 elseif($field=='col_style')$value.="'".$this->back_image_copy($row3['col_style'])."',"; 
						elseif($field=='col_grp_bor_style')$value.="'".$this->back_image_copy($row3['col_grp_bor_style'])."',"; 
						elseif($field=='col_width'){
							if (!empty($rows2['col_primary'])&&$rows2['col_primary']<100)$value.="'".$row3['col_width']."',";
							else $value.="'0',";//"'".$row3['col_width']."',";
							}
						elseif($field=='col_status')$value.="'copy',";
						else $value.="'".$row3[$field]."',"; 
						}    
					$q="insert into $this->master_col_table ($col_fields,col_update,col_time,token) values ($value '".date("dMY-H-i-s")."','".time()."','".mt_rand(1,mt_getrandmax())."')"; 
					$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
				
					$this->mysqlinst->count_field($this->master_col_table,'col_id','',false,'');  
					$col_id=$this->mysqlinst->fieldmax;
					$q="update $this->master_col_table set col_table='{$table_base}_post_id$col_id' where col_id='$col_id'"; 
					$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true); 
					$q="update $this->master_post_table set token='".mt_rand(1,mt_getrandmax()). "',blog_data1='$col_id' where blog_id=$blog_id";   
					$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
				
					#XXXXXXXXXXX
					 
					 $this->copy_col($col_id,$rows2['blog_data1'],'copy',$preserve,$table_base);
					}
				}
			}
			#**********************************************
		
		if  ((!$preserve||$rows['blog_status']!='clone')&&$rows['blog_type']=='nested_column'&&is_numeric($rows['blog_data1'])){  
			$q="select $col_fields from $db$this->master_col_table where col_id=".$rows['blog_data1'];   
			$r3=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
			$row = $this->mysqlinst->fetch_assoc($r3,__LINE__);
			#rows = parent_blog to copy
			#rows2=  cloned reference in parent blog when presever status is used
			#rows3= cloned column values when column is directly cloned and preserved
			#rows is normal handling of copying nested column values before recursively obtainng subposts from that column
			$fields='';
			$value='';
			foreach ($col_field_arr as $field) {
				if($field=='col_table_base')$value.="'$table_base',";
				elseif($field=='col_table')$value.="'',";
				elseif($field=='col_num')$value.="0,";
				elseif($field=='col_status')$value.="'copy',";
				elseif($field=='col_clone_target')$value.="'',";
				elseif($field=='col_clone_target_base')$value.="'".$row['col_table_base']."',";
				 elseif($field=='col_style')$value.="'".$this->back_image_copy($row['col_style'])."',"; 
				elseif($field=='col_grp_bor_style')$value.="'".$this->back_image_copy($row['col_grp_bor_style'])."',"; 
				elseif($field=='col_primary')$value.="'0',";
				elseif($field=='col_width'){
					if (!empty($row['col_primary']))$value.="'100',";
					else $value.="'".$row['col_width']."',";
					}
				elseif($field=='col_status'&&$status!=='move')$value.="'$status',";
				else $value.="'".$row[$field]."',"; 
				}    
			$q="insert into $this->master_col_table ($col_fields,col_update,col_time,token) values ($value '".date("dMY-H-i-s")."','".time()."','".mt_rand(1,mt_getrandmax())."')"; 
		
			$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true); 
			$this->mysqlinst->count_field($this->master_col_table,'col_id','',false,'');  
			$col_id=$this->mysqlinst->fieldmax;
			$q="update $this->master_col_table set col_table='{$table_base}_post_id$col_id' where col_id='$col_id'"; 
			$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true); 
			$q="update $this->master_post_table set token='".mt_rand(1,mt_getrandmax()). "',blog_data1='$col_id' where blog_id=$blog_id";   
			$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true); 
			$this->copy_col($col_id,$rows['blog_data1'],$status,$preserve,$table_base,$db);
			}
		}//while
		$msg=($status=='move')?'MOVED':(($status=='clone')?'CLONED':(($preserve)?'COPIED AND CLONE/MIRROR RELEASE STATUS PRESERVED':'COPIED'));
		$this->success[]="Your Column and All Post have been $msg";
	}// end copy column
	 

 
	

	
	
	/*CREATE TEMPORARY TABLE temp_table 
AS 
SELECT * FROM source_table WHERE id='7'; 
UPDATE temp_table SET id='100' WHERE id='7';
INSERT INTO source_table SELECT * FROM temp_table;
DROP TEMPORARY TABLE temp_table;

improvement
CREATE TEMPORARY TABLE tmptable SELECT * FROM table WHERE primarykey = 1;
UPDATE tmptable SET primarykey = 2 WHERE primarykey = 1;
INSERT INTO table SELECT * FROM tmptable WHERE primarykey = 2;





	
INSERT INTO table (primarykey, col2, col3, ...)
SELECT 567, col2, col3, ... FROM table
  WHERE primarykey = 1	*/
  
  
function process_add_new_page(){   
	if (isset($_POST['menu_start_new'][$this->blog_id]))  {
		$this->mysqlinst->count_field($this->directory_table,'dir_menu_id','',false,'');
		$dir_menu_id=$this->mysqlinst->field_inc;
		$dir_menu_order=1;
		$dir_sub_menu_order=0;
		$dir_ref=$_POST['menu_start_new'][$this->blog_id];
		$q="select dir_filename, dir_title from $this->directory_table where dir_ref='$dir_ref' limit 1";
		$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
		if ($this->mysqlinst->affected_rows()){
			list($dir_filename,$dir_title)=$this->mysqlinst->fetch_row($r,__LINE__);
			}
		else {
			$q="select page_title from $this->master_page_table where page_ref='$dir_ref'";
			$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
			list($dir_title)=$this->mysqlinst->fetch_row($r,__LINE__);
			$dir_filename=process_data::clean_filename($dir_title);
			$dir_filename=process_data::new_file($dir_filename);
			}  
		$q="insert into $this->directory_table (dir_menu_id,dir_menu_order,dir_sub_menu_order,dir_filename,dir_title,dir_ref,dir_menu_style, dir_gall_table,dir_blog_table,dir_menu_type,dir_gall_type,dir_menu_opts,dir_hide_sub_menu,dir_external,dir_internal,dir_is_gall,dir_temp,dir_temp2,dir_update,dir_time,token) values
			($dir_menu_id,$dir_menu_order,$dir_sub_menu_order,'$dir_filename','$dir_title','$dir_ref','','','','','','','','','',0,0,0,'".date("dMY-H-i-s")."','".time()."','".mt_rand(1,mt_getrandmax())."')";    
		$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
		$q="update $this->master_post_table set blog_data1='$dir_menu_id' where blog_id=$this->blog_id";  
		$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
		$msg="New Menu Id: $dir_menu_id has been created with page ref: $dir_ref and title: $dir_title";
		$this->success[]=$msg;
		
		}
	elseif  ((isset($_POST['create_external_link_name'][$this->blog_id])&&!empty($_POST['create_external_link_name'][$this->blog_id]))||(isset($_POST['create_external_link_ur'][$this->blog_id])&&!empty($_POST['create_external_link_ur'][$this->blog_id]))){
		if  ((isset($_POST['create_external_link_name'][$this->blog_id])&&!empty($_POST['create_external_link_name'][$this->blog_id]))&&(isset($_POST['create_external_link_ur'][$this->blog_id])&&!empty($_POST['create_external_link_ur'][$this->blog_id]))){
			 
			$external_link='http://'.str_replace(array('http://','http:/','http:','http','http//:','http//'),'',$_POST['create_external_link_ur'][$this->blog_id]);
			$this->mysqlinst->count_field($this->directory_table,'dir_menu_id','',false,'');
			$dir_menu_id=$this->mysqlinst->field_inc;
			$dir_menu_order=1;
			$dir_sub_menu_order=0;
			$dir_title=process_data::clean_title($_POST['create_external_link_name'][$this->blog_id]);
			if (!empty($dir_title)){
					$q="insert into $this->directory_table (dir_menu_id,dir_menu_order,dir_sub_menu_order,dir_filename,dir_title,dir_ref,dir_menu_style,dir_gall_table,dir_blog_table,dir_menu_type,dir_gall_type,dir_menu_opts,dir_hide_sub_menu,dir_external,dir_internal,dir_is_gall,dir_temp,dir_temp2,dir_update,dir_time,token) values
			($dir_menu_id,$dir_menu_order,$dir_sub_menu_order,'$dir_filename','$dir_title','$dir_ref','','','','','','','','','',0,0,0,'".date("dMY-H-i-s")."','".time()."','".mt_rand(1,mt_getrandmax())."')";  
				$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
				$q="update $this->master_post_table set blog_data1='$dir_menu_id' where blog_id=$this->blog_id";  
				$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
				}	
			else { $msg='Please include a title along with an external url when adding a link to another website';
				$this->message[]=$msg;
				}
			}
		else {
			$msg='Both the URL and Web Page Reference Need to be Provided for external Urls';
			$this->message[]=($msg);
			}
		}	 
	}
#nav  #navmenu
function nav_menu($data,$dir_menu_id,$text){   
		(Sys::Deltatime)&&$this->deltatime->delta_log(__LINE__.' @ '.__method__.'  ');
	$datainc='_'.$this->blog_id;
	
	$this->navobj->current_color=$this->column_lev_color;
	$this->blog_tiny_data2=(empty($this->blog_tiny_data2))?Cfg::Horiz_nav_class:$this->blog_tiny_data2;
	static $inc=0;   $inc++;
	//if ($this->edit&& !$this->is_clone&&isset($_POST ['submitted'])){//passes thru normal styler cept channeled back to horiz or vert menu
		// if (empty($dir_menu_id)) 
			//$dir_menu_id=$this->process_add_new_page();
		//}// end update submit for normal post
	if (empty($dir_menu_id)){ 
		if ($this->edit){
			$dir_menu_id=$this->process_add_new_page();
			$this->edit_styles_open();
			$this->delete_option();
			
			$q="select distinct dir_menu_id from $this->directory_table";
			$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
			if ($this->mysqlinst->affected_rows()){
				$opts=array();
				printer::pclear();
				$this->show_more('Create Menu', ' ','','',800);
				printer::printx('<p class="fsminfo editbackground rad5 maxwidth800 floatleft left maroonshadow infoback info "> Create and Use as Many Menus as you want on a Page whether independent or Common To Other Pages. The Table below assists in finding the best approach to your navigation menu needs:</p>');	
				printer::pclear();							
				$opts[]=array('Your Menu Needs'=>'<span class="pos">Sharing a Common Menu, It&#39;s Styling &amp; All Updates between Pages</span>',
					'Best Approach'=>'<span class="orange">Clone the Menu Post</span>',
					'How To proceed'=>'<span class="info">Delete this Post. Choose the Copy/Move/Clone Column From the Create Post/Column dropdown Option. Choose mirror and enter the Column Id of the the parent Post containing the Menu.  Editing the Parent Menu will also change this menu</span>');
				$opts[]=array('Your Menu Needs'=>'<span class="pos">Same as Above but within a Common Column &#40;ie. Page Headers&#41;</span>',
					'Best Approach'=>'<span class="orange">Clone the Column Containing the Menu</span>',
					'How To proceed'=>'<span class="info">Delete this Post. Choose the Copy/Move/Clone Post From the Create Post/Column dropdown Option.  Choose mirror and enter the Column Id of the the parent Column containing the Menu.  All Editing Changes to the Parent Menu and any other post within the parent Column will also appear on this page</span>');
				$opts[]=array('Your Menu Needs'=>'<span class="pos">Copying a Menu But Customizing the Menu links </span>',
					'Best Approach'=>'<span class="orange">Copy the Menu Post</span>',
					'How To proceed'=>'<span class="info">Delete this Post. Choose the Copy/Move/Clone Post From the Create Post/Column dropdown Option.  Choose copy and enter the Post Id of the the parent Menu. This will make a completely independent Copy of the Menu including Links that can be altered any way without affecting the original.</span>');
				$opts[]=array('Your Menu Needs'=>'<span class="pos">Moving a menu Here</span>',
					'Best Approach'=>'<span class="orange">Move the Menu Post</span>',
					'How To proceed'=>'<span class="info">Delete this Post. Choose the Copy/Move/Clone Post From the Create Post/Column dropdown Option.  Choose move and enter the Post Id of the the parent Menu.</span>');
				$opts[]=array('Your Menu Needs'=>'<span class="pos">Sharing a Common Menu &amp; Menu Link Updates But With Independent Positoning &amp; Styling </span>',
					'Best Approach'=>'<span class="orange">Got to the &#34;Choose a the Menu Already Created&#34; Option Below</span>',
					'How To proceed'=>'<span class="info">Proceed to the Choose a Menu Already Created Option Below. Choose Your Menu. Style as needed. Changes to menu links from here or on any other column using the menu id will appear in all of them but styling changes are independent unless mirror options are chosen!</span>');
				$opts[]=array('Your Menu Needs'=>'<span class="pos">Starting a Brand New Menu</span>',
					'Best Approach'=>'<span class="orange">Go to the &#34;Start a New Menu from Scratch by Selecting a Previously Created Page&#34; Option Below</span>',
					'How To proceed'=>'<span class="info">Open the Option. Select a Page. If needed, create a new page at the &#34;Add a new page to the website&#34; link at the top of this page. </span>'); 

				printer::horiz_print($opts);
				$this->show_more('More Scenarios', ' ','','',800);
				
				$opts=array();
				$opts[]=array('Your Menu Needs'=>'<span class="pos">Changing the Styling/Positioning of a Menu Within a Mirored Column</span>',
					'Best Approach'=>'<span class="orange">Enable the Local Mirror Style</span>',
					'How To proceed'=>'<span class="info">Simply Go to the Mirrored menu within the cloned column and Enable the Local Mirror Style! Changes to the positioning/styling of the mirrored menu will not affect the parent or other mirrors</span>');
				$opts[]=array('Your Menu Needs'=>'<span class="pos">Changing Menu links &#40;&amp; Styling&#41; of a Mirrored Menu Within a Mirrored&nbsp;Column</span>',
					'Best Approach'=>'<span class="orange">Choose the Mirror Release Option</span>',
					'How To proceed'=>'<span class="info">Go to the cloned menu within the cloned column and Choose the mirror release option. Then Check the &#34;Duplicate and Modify&#34; Option. This allows you to independently change and modify a copy of the original menu.  Etc.</span>');
				
				
				printer::horiz_print($opts);
				printer::pclear();
				$this->show_close('menu opts');
				$this->show_close('create menu scenarious');
				
				printer::pclear();							
				printer::pclear();
				$this->show_more('Choose a Menu Already Created to Add Here', ' ','','',800); //menu created
				while (list($dir_menu_id)=$this->mysqlinst->fetch_row($r)){
					echo '<div class="fs1color floatleft pb10 editbackground"><!--choose menu-->';
					printer::alertx('<p class="orange"><input type="radio" value="'.$dir_menu_id.'"  name="'.$data.'_blog_data1_arrayed">Choose Menu Id: '.$dir_menu_id.' </p>');
					
					$this->navobj->render_menu($dir_menu_id,'utility_horiz',false);
					echo '</div><!--end choose menu-->';
					printer::pclear(2);
					}//end while
				$this->show_close('menu created');//menu created
				$Or='Or';
				}//if affected
			else $Or='No Menus Created Yet';
			printer::pclear();
			$this->show_more($Or.' Start a New Menu from Scratch by Selecting a Previously Created Page', ' ','','',500); //menu create
			$msg='New Pages Are Created On the Add a New Page to the Website Link at the top of Edit Pages.';
			printer::printx('<p class="fsminfo editbackground floatleft left '.$this->column_lev_color.'">'.$msg.'</p>');
			$q="select distinct  page_ref, page_title from $this->master_page_table order by page_ref ASC"; 
			$r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
			if (!$this->mysqlinst->affected_rows()){
				printer::alert_neg('Create the Pages First Before Adding then to Your menu '.$msg );
				$this->show_close('Start a New Menu');
				}
			else {
				while (list($page_ref,$page_title) = $this->mysqlinst->fetch_row($r,__LINE__)){
					if ($page_ref=='setupmaster')continue;  
					$page_arr[]=$page_ref;
					$print_arr[]=array('Page Table Reference'=>$page_ref,'Current Page Title'=>$page_title);
					}
				if(count($page_arr)>0){
					printer::alert('This Table Lists the Created Pages and a Default Title Which is alterable  Later as necessary.  Note: Titles may Be Changed Without Affecting  Different  Titles to the same Page in a Different Menu');
					printer::horiz_print($print_arr,'','','','',false);
					echo '<div class="fsminfo editbackground  floatleft left '.$this->column_lev_color.'">Choose your Page Reference to begin your new menu<br>'; 
					echo'<p> <select class="editcolor editbackground"  name="menu_start_new['.$this->blog_id.']">';       
					echo '<option  value="" selected="selected">none</option>';
					for ($i=0;$i<count($page_arr);$i++){
					   echo '<option  value="'.$page_arr[$i].'">'.$page_arr[$i].'</option>';
					   }
					echo'	
					</select></p>';
					echo '</div><!--Page Arr Select-->';
					}
				$this->show_close('more nav menu');
				}//else afected 
			
			$this->show_more('Other Options', 'Close Other Options','info fsminfo editbackground','Link to External Site, Link to Internal PDF or HTML Page, Upload Internal Page');
			echo '<fieldset class="fs1navy"><!--Add External Link --><legend></legend>';
			$this->show_more('Add Navigation Menu Link to an External Website', 'noback','information editbackground fsminfo editbackground','This Link Will Take Your Website Viewer Off Your Own Site');
			printer::alert('Create a Formal Menu Link To a Separate Site such as a Related Company or Personal Site of Your Own,Etc!','','navy');
			printer::alert('Enter the url address of the External Link. http:// will be appended automatically if you do not include it ie www.mysite.com<input   style="background:#'.$this->editor_background.';color:#'.$this->editor_color.';" type="text" name="create_external_link_url" value="" size="60" maxlength="100">');
			printer::alert('Enter the title of the External Link. <textarea class="utility"  name="create_external_link_name['.$this->blog_id.']" style="width:90%;" rows="3" cols="50" ></textarea>');
			$this->show_close('External Link');echo ' <!--close show_more External Link-->'; 
			echo '</fieldset><!--end External Link-->';
			printer::pclear(2); 
			echo '<fieldset class="fs1navy"><!--Add Internal PDF Link --><legend></legend>';
			$this->show_more('Add a Navigation Link to an Uploaded PDF file', 'nback','editbackground fsminfo editbackground navy');
			printer::alert('Go To Upload a PDF file <a style="color:#'.Cfg::Navy_color.';"  href="#uploadpdf"  onclick="return gen_Proc.scroll_to_view(\'uploadpdf\');" >Here</a>','','navy');
			printer::alert('Enter the filename of the Uploaded PDF file: ie myfile.pdf<input  style="background:#'.$this->editor_background.';color:#'.$this->editor_color.';" type="text" name="create_internal_link_filename['.$this->blog_id.']" value="" size="60" maxlength="60">');
			printer::alert('Enter the title for Your PDF link. <textarea class="utility"  name="create_internal_link_title['.$this->blog_id.']" style="max-width:90%;" rows="3" cols="50" ></textarea>');
			$this->show_close('internal PDF Link');echo ' <!--close show_more internal PDF Link-->'; 
			echo '</fieldset><!--end Internal PDF Link-->';
			$this->show_close(' Other');echo ' <!--close show_more Other-->'; 
			
			}//if edit
		return;
		}//EMPTY menu id
	 
	$count=$this->mysqlinst->count_field($this->directory_table,'dir_menu_id','',false,"where dir_menu_id='$dir_menu_id' AND dir_sub_menu_order=0 "); 
	  
	($this->edit)&&$this->edit_styles_open();
	($this->edit)&&    
			$this->blog_options($data,$this->blog_table);
	#navparams 	
	$nav_params=explode(',',$this->blog_tiny_data1);
	$nav_opts='nav_drop_shift,nav_link_width,nav_sub_link_width,nav_link_height,nav_icon_rwd_width,nav_icon_color,nav_icon_width,nav_icon_position,nav_icon_over,nav_icon_vertical_response,nav_link_width_management,nav_repeat_submenu,nav_force_caps';
	$nav_opts=explode(',',$nav_opts);
		// for two arrayed forms are for normal styling and the other for $this->mod_spacing
		// using arrayed form for consistency
	for ($x=0;$x<=count($nav_opts);$x++){ 
	    (!array_key_exists($x,$nav_params))&&$nav_params[$x]=0;# 
	    }
    foreach($nav_opts as $key =>$index){
		if (!empty($index)) {
			${$index.'_index'}=$key;  
			}
		}
		 
	if ($count>0){
		//if  
		($this->edit)&&printer::printx('<p class="editbackground fsminfo editbackground floatleft left '.$this->column_lev_color.'">Menu Id: '.$dir_menu_id.'</p>');
		printer::pclear();
		#navobj choices
		
		if (isset($nav_params)&&isset($nav_icon_color_index)){//normal menu
			if (!empty($nav_params[$nav_icon_color_index])&&strlen($nav_params[$nav_icon_color_index])>3&&strpos($this->menu_icon_color,$nav_params[$nav_icon_color_index])!==false)
			$this->navobj->menu_icon=$nav_params[$nav_icon_color_index].'_menu_icon.gif';
			}
		$this->navobj->force_caps=($nav_params[$nav_force_caps_index]==='force')?true:false;
	
		$this->navobj->nav_post_class=$data;
		$this->navobj->nav_repeat_submenu=($nav_params[$nav_repeat_submenu_index]!=='repeat')?false:true;
		 $this->navobj->render_menu($dir_menu_id,$this->blog_tiny_data2.$datainc);
		}
	elseif(empty($count)&&$this->edit){
		printer::printx('<p class="fsminfo editbackground '.$this->column_lev_color.' floatleft left">Add Your First Already Created Page To This Menu Under the Add Remove &amp; Edit Links Option Below</p>');
		}
		
	if(!$this->edit)return;
	printer::pclear();
	$this->main_menu_check[]=array($this->blog_data1,$this->blog_tiny_data2.$datainc,$this->data,$this->current_net_width); //for creating utility and expand menus
	 
	 
	 #navstyle
	printer::pclear(15); 
	$this->edit_styles_close($data,'blog_style','.'.$data,'background,padding_top,padding_bottom,padding_left,padding_right,margin_top,margin_bottom,margin_left,margin_right,text_align,borders,box_shadow,outlines,radius_corner,transform',"Edit Overall Post Styling",'','Edit Overall Post Styling and align Links left right or center using Text align. Use Detailed Link Styling for Link Text Styling',true,true,true); //last true prevents text_align hiding	
	
	
	$this->{'blog_tiny_data1_arrayed'}=$this->{$data.'_blog_tiny_data1_arrayed'} =$nav_params;
	$this->background_img_px=(is_numeric($nav_params[$nav_link_width_index])&&$nav_params[$nav_link_width_index]>30)?$nav_params[$nav_link_width_index]:200; 
#navwidth		 
	$nav_drop_shift=(is_numeric($nav_params[$nav_drop_shift_index])&&$nav_params[$nav_drop_shift_index]>0&&$nav_params[$nav_drop_shift_index]<201)?'LEFT:'.$nav_params[$nav_drop_shift_index].'px':'';
	$nav_link_height=(is_numeric($nav_params[$nav_link_height_index])&&$nav_params[$nav_link_height_index]>24&&$nav_params[$nav_link_height_index]<101)?'height:'.$nav_params[$nav_link_height_index].'px;':'';
    
      $nav_sub_link_width=(is_numeric($nav_params[$nav_sub_link_width_index])&&$nav_params[$nav_sub_link_width_index]>44&&$nav_params[$nav_sub_link_width_index]<321)?'width:'.$nav_params[$nav_sub_link_width_index].'px;':'';
    if (!Sys::Quietmode&&($this->clone_local_style||!$this->is_clone)){#    PROCEEd FOr NORMAL
		 ############### End Nav Options ###############
		$this->show_more('Detailed Link Area &amp; Custom Menu', '','','',500);
			 
		echo '<div class="ramana editbackground maxwidth500  editfont floatleft" style="width:auto;" id="navstylewidth'.$inc.'t">';
		 printer::pspace(10);
		if($nav_params[$nav_force_caps_index]!=='force'){
			printer::alertx('<p class="fsminfo info" title="Captialize All Main Menu and Sub Menu Link Titles/Names"><input type="radio" value="force"   name="'.$data.'_blog_tiny_data1_arrayed['.$nav_force_caps_index.']">Use Uppercase Text Only</p>');
			}
		else {
			printer::alertx('<p class="fsminfo info" title="Captialize All Main Menu and Sub Menu Link Titles/Names"><input type="radio" value="0"   name="'.$data.'_blog_tiny_data1_arrayed['.$nav_force_caps_index.']">Disable Use Of Uppercase Text Only</p>');
			}
		printer::pclear(5);
           
		$checked1=($nav_params[$nav_repeat_submenu_index]!=='repeat')?'checked="checked"':''; 
          $checked2=($nav_params[$nav_repeat_submenu_index]==='repeat')?'checked="checked"':'';#full 
          echo '<div class="fsminfo"><!--repeat menu wrap-->';
          printer::alertx('<p class="information" title="When Submenu links are Being Used Do Not Repeat the main menu link at the top of list of submenu links "><input type="radio" value="1" '.$checked1.' name="'.$data.'_blog_tiny_data1_arrayed['.$nav_repeat_submenu_index.']">Do Not Repeat Main Link to Submenu</p>');
		printer::pclear();
          printer::alertx('<p class="information" title="When Submenu links are Being Used Repeat the main menu link at the top of list of submenu links"><input type="radio" value="repeat" '.$checked2.' name="'.$data.'_blog_tiny_data1_arrayed['.$nav_repeat_submenu_index.']">Repeat Main Menu Link in sub menu list if used </p>');
          printer::pspace(10); 
		echo '</div><!--repeat menu wrap-->';
		##############   horiz or vert
		$checked1=($this->blog_tiny_data2!=='force_vert')?'checked="checked"':''; 
          $checked2=($this->blog_tiny_data2==='force_vert')?'checked="checked"':'';#full width option
		$pass_nav_class=($this->blog_tiny_data2==='force_vert')?' vert':' horiz';
		$pass_nav_class.=($this->blog_tiny_data3=='nav_display')?' display':' hover';
		//Free Form Menu
          echo '<div class="fsminfo"><!--verthoriz wrap-->';
          printer::alertx('<p class="information" title="Allow Menu To Spread both Horizontally and vertically Depending on Size Available"><input type="radio" value="1" '.$checked1.' name="'.$data.'_blog_tiny_data2">Free Form Menu</p>');
          printer::alertx('<p class="information" title="Force Vertical Menu Display Only"><input type="radio" value="force_vert" '.$checked2.' name="'.$data.'_blog_tiny_data2">Display Vertical Only </p>');
          printer::pspace(10);
		echo '</div><!--verthoriz wrap-->';
		printer::pspace(10);
		echo '<div class="fsminfo"><!--submenu hover-->';
		$checked1=($this->blog_tiny_data3!=='nav_display')?'checked="checked"':''; 
          $checked2=($this->blog_tiny_data3==='nav_display')?'checked="checked"':'';#full width option
		printer::alertx('<p class="information" title="Choose to display submenus when hovered Over "><input type="radio" value="1" '.$checked1.' name="'.$data.'_blog_tiny_data3">Hover Submenus </p>');
		printer::pclear();
		printer::alertx('<p class="information" title=" Display Submenus always"><input type="radio" value="nav_display" '.$checked2.' name="'.$data.'_blog_tiny_data3">Always Display Submenus (Applies Link Width for Horiz Menus)</p>');
		#blog_tiny_data3 display or horiz handled in the # maindiv specific for nav
		echo '</div><!--submenu hover-->';
		
		printer::pspace(10);
		
		####nav
		##### 
		echo '<div class="fs2'.$this->column_lev_color.' inline floatleft"><!--custom Menu wrapper-->';
		
		printer::printx('<p class="fsminfo editbackground floatleft '.$this->column_lev_color.' left">Customize Your Menu Links <br>Style the  background area around each link with borders, colors, images, box shadow, creating a link button if you wish, and set the distance between the &#34;link button&#34; areas: </p>');
		}//clone local style
	/* $this->edit_styles_close($data,'blog_tiny_data4','.'.$data.' .nav_gen ul li  ul li ,.'.$data.' .nav_gen li ','padding_top,padding_bottom,padding_left,padding_right,margin_top,margin_bottom','Link Spacing W/O Hover Sub Menu',false,'Margins and Spacings to pad Main Menu links Will Trigger the Hover Sub Menu if used. However these choices provide spacing around link without increasing the Hover trigger ARea and without increasing the Background area if used.' );      
	*/   
	$style_list='background,padding_top,padding_bottom,padding_left,padding_right,margin_top,margin_bottom,margin_left,margin_right,font_family,font_size,font_weight,text_align,font_color,text_shadow,line_height,letter_spacing,italics_font,small_caps,text_underline,borders,box_shadow,outlines,radius_corner,transform';
	$this->edit_styles_close($data,'blog_data4','.'.$data.' .nav_gen ul li  ul li a,.'.$data.' .nav_gen li a',$style_list,'Style General Menu Link',false,'Styles You Make Here will affect Normal and  Hover or Active Links. Use Nav General Post styling to set nav link alignment center or left. For additional Hover and Active Link effects Style Below<br><span class="pos">To Enlarge Background Area for Images and Background Color Use Padding Spacing<br>To Enlarge Spacing between Background styled links use margin spacing',false );
		printer::pclear(5);
		$this->edit_styles_close($data,'blog_data2','.'.$data.' .nav_gen ul li  ul li a',$style_list,'Style Sub Menu Links Differently',false,'Optionally Style a Dropdown Menu Link Differently than the General Menu Link Settings you Made ',false );
		 printer::pclear(5); 
		$this->edit_styles_close($data,'blog_data6','.'.$data.' .nav_gen ul li  li a:hover, .'.$data.' .nav_gen ul li a:hover','background,font_family,font_size,font_weight,font_color,text_shadow,line_height,letter_spacing,italics_font,small_caps,text_underline,borders,box_shadow,outlines,radius_corner,transform','Style Hover Link',false,'When You Hover Over a Link with the cursor it wil change according to Any Styles set Here' );   
		printer::pclear(5);
		$this->edit_styles_close($data,'blog_data5','.'.$data.' .nav_gen .active','background,font_family,font_size,font_weight,font_color,text_shadow,line_height,letter_spacing,italics_font,small_caps,text_underline,borders,box_shadow,outlines,radius_corner,transform','Style the Active Link',false,'An Active Link is the Particluar Link to the Current Page and its optionaly styled here');   
		printer::pclear(5);
		$this->edit_styles_close($data,'blog_data7','.'.$data.' .nav_gen ul:hover ul,.'.$data.' .nav_gen ul ul','background,padding_top,padding_bottom,padding_left,padding_right,left,top,right,borders,box_shadow,outlines,radius_corner,transform','Style the Sub Menu Background Panel',false,'If you have optionally made sub menus that can be styled the dropdown Panel which contains the dropdown menu links',false);   
		printer::pclear(5);
	/*echo '<div class="fsminfo editbackground  '.$this->column_lev_color.' floatleft"><!--shift panel-->';
		echo '<p class="info left"  title="Optionally Shift Sub Menu Background Panel Rightwards. By Default the Dropdown menu is left 0 aligned with its Parent. Note: Shifting More than the parent link width will Break Dropdown Clicking!!">Optionally right Shift Sub Menu Background Panel</p>';
		$current_drop_shift=(is_numeric($nav_params[$nav_drop_shift_index])&&$nav_params[$nav_drop_shift_index]>0&&$nav_params[$nav_drop_shift_index]<201)?$nav_params[$nav_drop_shift_index]:'default'; 
		$this->mod_spacing($data.'_blog_tiny_data1_arrayed['.$nav_drop_shift_index.']',$current_drop_shift,0,200,2,'px',true,'default'); 
		echo '</div><!--shift panel-->';*/
		   
		printer::pclear(5);
	$min_viewport=100;
	$max_viewport=(!empty($this->column_total_width[0])&&$this->column_total_width[0]>350)?$this->column_total_width[0]:((!empty($this->page_width)&&$this->page_width>350)?$this->page_width:1280);
	$nav_width_manage=($this->column_use_grid_array[$this->column_level]==='use_grid'&&$nav_params[$nav_link_width_management_index]!=='nomanage')?true:false;
	#navvals
	$icon_over_choice=($nav_params[$nav_icon_over_index]==='Over')?'Over':'Next To';
	$icon_width=($nav_params[$nav_icon_width_index]>29&&$nav_params[$nav_icon_width_index]<101)?$nav_params[$nav_icon_width_index]:50;
	$icon_vertical_choice=($nav_params[$nav_icon_vertical_response_index]==='as_is')?'as_is':'vertical';
	$icon_position_choice=(empty($nav_params[$nav_icon_position_index])||!is_numeric($nav_params[$nav_icon_position_index])||$nav_params[$nav_icon_position_index]>100)?0:$nav_params[$nav_icon_position_index];
	//$icon_position_vert_choice=(empty($nav_params[$nav_icon_position_vert_index])||!is_numeric($nav_params[$nav_icon_position_vert_index])||$nav_params[$nav_icon_position_vert_index]>100)?0:$nav_params[$nav_icon_position_index];
	$respond_menu_dimension=($nav_params[$nav_icon_rwd_width_index]>$min_viewport&&$nav_params[$nav_icon_rwd_width_index]<=$max_viewport)?$nav_params[$nav_icon_rwd_width_index]:(($nav_params[$nav_icon_rwd_width_index]==='icon full on')?'icon full on':768);
	 
	if (!Sys::Quietmode&&($this->clone_local_style||!$this->is_clone)){#    PROCEEd FOr NORMAL
	     printer::pclear(5);
		 echo '<div  class="fsminfo editbackground left  floatleft" ><!--Link width Wrapper-->';
	 
		$msg='Vertical Menu links look better with a uniform link  when background color or images are used whereas horizontal menus  make better use of space to auto adjust width matching the length of link text. Link Width management toggles between a block width of 100%  for  menus when available space is under 200px   and provides a  default maximum width of 200px for text lengthy horizontal links when greater than 200px';
		if ($nav_params[$nav_link_width_management_index]==='nomanage'){
			$styleWidthShow='style="display:block;"';//shows in editor only
			printer::printx('<p class="info" title="When in Responsive Grid Mode Check to enable a 200px maximum link width for link text. Very lont text will wrap around instead '.$msg.'"><input type="checkbox" name="'.$data.'_blog_tiny_data1_arrayed['.$nav_link_width_management_index.']" value="1" >Enable Link Width Response Managment for RWD mode</p>');
			}
		else {
			$styleWidthShow='style="display:none;"'; //do not show option
			printer::printx('<p class="info" title="Check to disable a Default Maximum Width Link for text greater than 200px. Optionally choose a specific link width '.$msg.'"><input type="checkbox" name="'.$data.'_blog_tiny_data1_arrayed['.$nav_link_width_management_index.']" onclick="edit_Proc.displaythis(\''.$data.'_navwidth_show\',this,\'#fdf0ee\')" value="nomanage" >Disable Link Width Response Managment</p>');
			}
		echo '<div id="'.$data.'_navwidth_show" class="fsminfo editbackground left   floatleft" '.$styleWidthShow.'><!--Link width-->';
		printer::alertx('<p class="info" title="Optionally select a set width for navigation links" >Choose a specific width for Navigation Links Here. Best if using vertical menus with differing background color or images</p>');
		$current_link_width=(is_numeric($nav_params[$nav_link_width_index])&&$nav_params[$nav_link_width_index]>44&&$nav_params[$nav_link_width_index]<321)?$nav_params[$nav_link_width_index]:'none';
		
		printer::alertx('<p class="editcolor editbackground editfont left" >Optionally Set a Specific Link Width</p>'); 
		$this->mod_spacing($data.'_blog_tiny_data1_arrayed['.$nav_link_width_index.']',$current_link_width,44,320,1,'px',true,'none');
		echo '</div><!--Link width-->';
		 echo '</div ><!--Link width Wrapper-->';
		printer::pclear(5);
		
		#iconic   
		$menu_icon_color_arr=explode(',',$this->menu_icon_color);
		echo '<div class="fsminfo floatleft"><!--RWD Menu Icon Outer wrap-->';
		$this->show_more('Enable/Customize Responsive Menu Icon','','','',600);
		echo '<div class="fs1info editbackground"><!--RWD Menu-->';
		printer::pclear(5);
		echo '<div class="fsminfo editbackground  '.$this->column_lev_color.' floatleft"><!--Menu Icon RWD Width-->';
		printer::alertx('<p class="info left" title="Select a Responsive view device width size under which the menu will be represent by a menu icon. Full Menu will appear when icon is clicked">Select Responsive View Port Width Minimum for Menu Icon Respresentation.<br></p>');
		printer::alertx('<p  class="tip">By default Menu Icon appears with widths smaller than 768. Hover drop down menus do not work on smaller devices and sub menus are shown by default when the icon is clicked</p>');
		$this->mod_spacing($data.'_blog_tiny_data1_arrayed['.$nav_icon_rwd_width_index.']',$respond_menu_dimension,$min_viewport,$max_viewport,1,'px',false);
		$checked=($respond_menu_dimension==='icon full on')?'checked="checked"':'';
		printer::printx('<p class="info" title="checking here will enables menu icon to be displayed at all widths. Menu will appear only when menu icon is clicked"><input type="checkbox" value="icon full on" name="'.$data.'_blog_tiny_data1_arrayed['.$nav_icon_rwd_width_index.']" '.$checked.'>Make Menu Icon Permanant</p>');
		echo '</div><!--Menu Icon RWD Width-->';
		printer::pclear();
		echo '<div class="fsminfo editbackground  '.$this->column_lev_color.' floatleft"><!--Icon Width-->';
		echo '<p class="info left" title="Select a icon width for the Responsize menu icon">Change Default Icon Width</p>';
		
		$this->mod_spacing($data.'_blog_tiny_data1_arrayed['.$nav_icon_width_index.']',$icon_width,30,100,2,'px'); 
		echo '</div><!-- Icon  Width-->';
		printer::pclear(5);
		echo '<div class="fsminfo whitebackground " ><!--link color--><br>';
		echo '<p class="'.$this->column_lev_color.' editbackground editfont">Choose Your Menu Icon Color: </p>';
		printer::pclear(5);
		for ($i=0;$i<count($menu_icon_color_arr);$i++){
			$checked=($nav_params[$nav_icon_color_index]===$menu_icon_color_arr[$i])?'checked="checked"':'';
			 echo  '<p class="floatleft left" title="'.$menu_icon_color_arr[$i].'"><input type="radio" name="'.$data.'_blog_tiny_data1['.$nav_icon_color_index.']." value="'.$menu_icon_color_arr[$i].'" '.$checked.'><img src="'.Cfg_loc::Root_dir.Cfg::Menu_icon_dir.$menu_icon_color_arr[$i].'_menu_icon.gif" width="50"  alt="dropdown choices menu '.$menu_icon_color_arr[$i].'_menu_icon.gif"></p>';
			}//end for loop colors
		
	    printer::pclear();
		echo '</div><!--link color-->';
		printer::pclear(5);
		echo '<div class="fsminfo editbackground  '.$this->column_lev_color.' floatleft"><!--Icon Float-->';
		echo '<p class="info left" title="Select your icon responsive position from left at 0%  to right at 100% or somewhere between. Caution: Values Near 100 may disappear Icon off right end, whereas using 100 gives correct far right positioning">Icon Position (Use 100% for correct Adjusted Far Right Positioning)</p>';
		
		$this->mod_spacing($data.'_blog_tiny_data1_arrayed['.$nav_icon_position_index.']',$icon_position_choice,0,100,1,'%');
		/*echo '<p class="info left" title="Select your icon responsive position from top at 0%  to bottom at 100% or somewhere between. Caution: Values Near 100 may disappear Icon off bottom">Icon Vertical Position (Use 0% for Top)</p>';
		
		$this->mod_spacing($data.'_blog_tiny_data1_arrayed['.$nav_icon_position_vert_index.']',$icon_position_vert_choice,0,100,1,'%');  */
		echo '</div><!-- Icon  Float-->';
		printer::pclear(5);
		/*echo '<div class="fsminfo editbackground  '.$this->column_lev_color.' floatleft"><!--Icon Bottom Space-->';
		echo '<p class="info left" title="Space the menu icon over the menu During Menu Icon Response or next to">Position Menu Icon over or next to Menu</p>'; 
		
		foreach (array('Over','Next To') as $value){
			$checked=($icon_over_choice===$value)?'checked="checked"':'';
			echo '<p><input type="radio" value="'.$value.'" name="'.$data.'_blog_tiny_data1['.$nav_icon_over_index.']." '.$checked.'>'.$value.'</p>';
			}
		echo '</div><!-- Icon  Bottom Space-->';*/
		printer::pclear(5);
		echo '<div class="fsminfo editbackground  '.$this->column_lev_color.' floatleft"><!--Respond Vertical-->';
		echo '<p class="info left" title="Respond Menus Vertical when enabled means horizontal menus will respond vertical only when the menu-icon is clicked below the width threshold chosen">Choose whether Horizontal Menus Will Appear Vertically when Icon is clicked</p>';
		 
			$checked1=($icon_vertical_choice!=='as_is')?'checked="checked"':'';
			$checked2=($icon_vertical_choice==='as_is')?'checked="checked"':'';
			echo '<p><input type="radio" value="vertical" name="'.$data.'_blog_tiny_data1['.$nav_icon_vertical_response_index.']." '.$checked1.'>Vertical Only (Best if Menu has Sublinks)</p>';
			echo '<p><input type="radio" value="as_is" name="'.$data.'_blog_tiny_data1['.$nav_icon_vertical_response_index.']." '.$checked2.'>As Is</p>';
			 
		echo '</div><!-- Respond Vertical-->';
		printer::pclear(5);
		echo '</div><!--RWD Menu-->';
		
		$this->show_close('Enable/Customize Responsive Menu Icon');
		echo '</div><!--RWD Menu Icon Outer wrap-->';
		
		printer::pclear(5);
		echo '<div class="fsminfo editbackground left   floatleft"><!--SubLink width-->';
		printer::alertx('<p class=" '.$this->column_lev_color.'" title="Lengthen you Sub Menu Navigation Link Width independently of the Main Links Here!" >Set Width For Sub Menu Links Only Here <span class="info">More Info</span></p>');
		$current_link_width=(is_numeric($nav_params[$nav_sub_link_width_index])&&$nav_params[$nav_sub_link_width_index]>44&&$nav_params[$nav_sub_link_width_index]<321)?$nav_params[$nav_sub_link_width_index]:'default'; 
		printer::alertx('<p class="editcolor editbackground editfont left" >Optionally Set Specific Sub Link Width</p>'); 
		$this->mod_spacing($data.'_blog_tiny_data1_arrayed['.$nav_sub_link_width_index.']',$current_link_width,44,320,1,'px',true,'default');
		echo '</div><!--SubLink width-->';
		$current_link_height=(is_numeric($nav_params[$nav_link_height_index])&&$nav_params[$nav_link_height_index]>24&&$nav_params[$nav_link_height_index]<101)?$nav_params[$nav_link_height_index]:'default';
		echo '<div class="fsminfo editbackground  '.$this->column_lev_color.' floatleft"><!--Link Height-->';
		echo '<p class="info left"  title="Optionally set a Uniform Height for all the Menu Links. By Default Links have automatic Height Depending on The Number of Rows of Link TEXT. Set a specific Height here">Optionally Set a Fixed Link Height</p>';
		 
		$this->mod_spacing($data.'_blog_tiny_data1_arrayed['.$nav_link_height_index.']',$current_link_height,24,101,1,'px',true,'default'); 
		echo '</div><!--Link Height-->';  
		
		printer::pclear();	
		$this->submit_button();
		echo '</div><!--custom Menu wrapper-->';
		echo '</div><!--End Background Style widthMax  Fullwidth-->'; 
		$this->show_close('Detailed Link Area');//<!--End Show More Edit Nav-->';
		 
		printer::pclear(3); 
		echo'<p class="button'.$this->column_lev_color.' '.$this->column_lev_color.' editbackground editfont floatleft  shadowoff"> <a class="linkcolorinherit" href="navigation_edit_page.php?table_ref='.$this->tablename.'&amp;passnavclass='.$pass_nav_class.'&amp;data='.$data.'&amp;style='.$this->blog_tiny_data2.$datainc.'&amp;menuid='.$dir_menu_id.'&amp;postreturn='.Sys::Self.'&amp;pgtbn='.$this->tablename.'&amp;css='.$this->roots.Cfg::Style_dir.$this->tablename.'">Add Remove &amp; Edit Links for this Menu</a></p>';
		printer::pclear();
		}//END PROCEED NORMAL clone local style
     $pb=(empty($this->{$data.'_blog_data4_arrayed'}[$this->padding_bottom_index]))?0:$this->{$data.'_blog_data4_arrayed'}[$this->padding_bottom_index];
	$pt=(empty($this->{$data.'_blog_data4_arrayed'}[$this->padding_top_index]))?0:$this->{$data.'_blog_data4_arrayed'}[$this->padding_top_index];
	$ptot=$pb+$pt;
	$bp_arr=$this->page_break_arr;
	$nav_link_width=(is_numeric($nav_params[$nav_link_width_index])&&$nav_params[$nav_link_width_index]>44&&$nav_params[$nav_link_width_index]<321)?$nav_params[$nav_link_width_index]:'';
	#blog_tiny_data3 display or horiz handled in the # maindiv specific for nav
	$this->navcss.='
	@media screen and (min-width: '.($bp_arr[0]+1).'px){';
	if ($nav_width_manage){
		if ($this->grid_width_chosen_arr['max'.$bp_arr[0]]>200)
		$this->navcss.='
		.'.$data.' .nav_gen UL.top-level>LI>A {  max-width:200px;}
		';
		else
		$this->navcss.='
		.'.$data.' .nav_gen UL.top-level>LI>A {display:block;  width:100%; }
		.'.$data.' .nav_gen UL.top-level>LI {display:block;  width:95%;margin:0 auto; }/*background tweak prevents menu overflow */
		.'.$data.' .nav_gen UL.top-level>LI.show_icon {display:none;}
		
		';
		}
	$this->navcss.='}
		';
			 
	$max=count($bp_arr);
	for ($bc=0; $bc<$max; $bc++){
		$bp=$bp_arr[$bc];
		$mw=$minw='';
		if ($bc < $max-1){
			$minw=' and (min-width:'.($bp_arr[$bc+1]).'px)';
			//$mw='-'.$bp_arr[$bc+1];
			}
		//else $mw='-'.$bp;
		$this->navcss.='
		@media screen and (max-width: '.($bp).'px)'.$minw.'{';
		 
		if ($nav_width_manage){
			if (isset($this->grid_width_chosen_arr)&&$this->grid_width_chosen_arr[$bp]>200) 
				$this->navcss.='
				.'.$data.' .nav_gen UL.top-level>LI>A {  max-width:200px;}
				';
			else 
			$this->navcss.='
			.'.$data.' .nav_gen UL.top-level>LI>A {display:block; width:100%; }
			.'.$data.' .nav_gen UL.top-level>LI {display:block; width:95%; }/*background tweak prevents menu overflow*/
			.'.$data.' .nav_gen UL.top-level>LI.show_icon {display:none;}
			';
			}
			
		$this->navcss.='}';
		} 
	//new menu directie;
	$nav_link_width=($nav_width_manage)?'':((is_numeric($nav_params[$nav_link_width_index])&&$nav_params[$nav_link_width_index]>44&&$nav_params[$nav_link_width_index]<321)?'width:'.$nav_params[$nav_link_width_index].'px;':'');
#navcss
$icon_over=($icon_over_choice==='Over')?'margin-top:'.($icon_width*.75).'px;':'';
$icon_over_bottom='padding-bottom:'.($icon_width*.75).'px;';
$icon_vertical_choice=($icon_vertical_choice==='Vertical Only')?'float:none;':'';
$icon_position_choice=($icon_position_choice==100)?'right:0; ':'left:'.$icon_position_choice.'%;'; //f 
$respond_menu_dimension=($respond_menu_dimension==='icon full on')?5000:$respond_menu_dimension;//always show
#at respond_menu_dimension convert hover to display css...
$this->navcss.= '
.'.$data.' .nav_gen UL.top-level>LI>A {'.$nav_link_width.$nav_link_height.'} 
/*.'.$data.'.hover .nav_gen  UL UL {'.$nav_drop_shift.'}  */ 
.'.$data.' .nav_gen UL UL A { '.$nav_sub_link_width.'height:auto; } 
 @media screen and (max-width:'.$respond_menu_dimension.'px) {
  .'.$data.'.horiz .nav_gen ul.top-level li,.vert .nav_gen ul.top-level li,.nav_gen ul.top-level li {display: none;}
    .'.$data.'.horiz .nav_gen ul.top-level li.show_icon,.vert .nav_gen ul.top-level li.show_icon,.nav_gen ul.top-level li.show_icon {
    position:absolute;
    top:0;
    '.$icon_position_choice.'
    display: inline-block;
    background:none;
  } 
.'.$data.'.hover  .nav_gen UL LI {display: block; vertical-align: top; position:static; VISIBILITY: visible } 
.'.$data.'.hover  .nav_gen UL UL {display: block; vertical-align: top; position:static; VISIBILITY: visible }  
.'.$data.'.hover   .nav_gen  ul.sub-level,.display .nav_gen  UL UL LI  {margin-right:auto; margin-left:auto; display:block;}
}
.'.$data.' .nav_gen ul.top-level li.show_icon p.aShow img{ width:'.$icon_width.'px; height:auto;}
@media screen and (max-width:'.$respond_menu_dimension.'px) {
   .'.$data.' {position: relative; 
    padding:0; margin:0;}
  .'.$data.' ul.top-level.menuRespond li.show_icon {
    position: absolute; 
    top: 0; 
  }
 .'.$data.'{
 '. $icon_over_bottom.'
 }
 
.nav_gen ul.top-level  {
max-height:0;
overflow:hidden;
-webkit-transition: max-height 1s ease-in;
-moz-transition: max-height 1s ease-in;
  -o-transition: max-height 1s ease-in;
  transition: max-height 1s ease-in;  
	}
 .'.$data.'.horiz .nav_gen ul.top-level.transitionEase li,.vert .nav_gen ul.top-level li,.nav_gen ul.top-level.transitionEase li {display: block;}
.nav_gen ul.top-level.transitionEase {
 max-height:0;
 overflow:hidden;
-webkit-transition: max-height 1s ease;
-moz-transition: max-height 1s ease;
  -o-transition: max-height 1s ease;
  transition: max-height 1s ease;  
		}	
  .'.$data.'.horiz .nav_gen ul.top-level.menuRespond li,.vert .nav_gen ul.top-level.menuRespond li,.nav_gen ul.top-level.menuRespond li{
    display: block;'.$icon_vertical_choice.'
  }
	 .'.$data.'.horiz .nav_gen ul.top-level.menuRespond,.vert .nav_gen ul.top-level.menuRespond,.nav_gen ul.top-level.menuRespond{
	 '. $icon_over.'
  }
   
} 
';    
		 
  
		(Sys::Deltatime)&&$this->deltatime->delta_log('End of '.__LINE__.' @ '.__method__.'  ');
	}// end function
  	
function light_dark($data,$field,$value){  
	$select=(!empty($value)&&is_numeric($value))?$value:'0';
			if (empty($value))$selected='none';
			elseif ($value=='.9')$selected='Lighten';
			elseif ($value=='.8')$selected='Lighter';
			elseif ($value=='.7')$selected='Lightish';
			elseif ($value=='.6')$selected='Even Lighter';
			elseif ($value=='.5')$selected='More Lighter';
			elseif ($value=='.4')$selected='Lightest';
			elseif ($value=='-.9')$selected='Darken';
			elseif ($value=='-.8')$selected='Darker';
			elseif ($value=='-.7')$selected='Darkish';
			elseif ($value=='-.6')$selected='Even Darker';
			elseif ($value=='-.5')$selected='More Darker';
			elseif ($value=='-.4')$selected='Darkish';
			else $selected='none';
			 
		echo'<p><select class="editcolor editbackground"  name="'.$data.'_'.$field.'">        
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
			$this->instruct[]='<img src="'.$final_path.$picname.'" class="floatleft" height="40" ><p class="pl10 maxwidth400 small floatleft redAlertbackground white">This '.$this->image_resize_msg.' Original Uploaded Image '.$picname.' in Post Id'.$this->blog_id.' is not large enough for the full space available.</p>';
			return false;
			}
		else $return=true;
		}// is file $final_path
		 
	image::image_resize($picname, $tmaxw, $maxh,$maxplus,$storage_path,$final_path,$output,$watermark,$quality,$watermarkposition,$errormsg);
	$this->instruct[]='Hit the Browser Refresh Button <img src="../refresh_button.png" alt="refresh button" width="20" height="20"> to Insure All New Image Widths are Updated!!'; 
	return  $return;
	}

function import_gallery(){//gallery items are tagged to table using gall_table..  not absolutely necessary but it provides for tablename equals page name which is handy when choosing galleries for master gallery
	if (!isset($_POST['import_gallery'])&&!isset($_POST['clone_import_gallery']))return;
	$collect=array('import_gallery','clone_import_gallery'); 
	foreach ($collect as $import){
		if (!isset($_POST[$import]))continue;
		$post_table=($import==='import_gallery')?$this->master_post_table:$this->master_post_data_table;
		$prefix=($import==='import_gallery')?'':'p';
		foreach($_POST[$import] as $blog_id =>$value){
			if (!empty($value)&&$value!=='create_new_gallery'){
				$q="select gall_ref from $this->master_gall_table where master_gall_status !='master_gall' and gall_ref='$value'";
				$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
				if ($this->mysqlinst->affected_rows()){
					$q="update $post_table set blog_data1='$value' where blog_id='$prefix$blog_id' and blog_type='gallery' and blog_table_base='$this->tablename'";  
					$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
					if ($this->mysqlinst->affected_rows()){
						$q="update $this->master_gall_table set gall_table='$this->tablename' where master_gall_status !='master_gall' and gall_ref='$value'"; 
						$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
						}
					}
				}
			else if($value==='create_new_gallery'){
				$q="update $post_table set blog_data1='' where blog_id='$prefix$blog_id' and blog_table_base='$this->tablename' and blog_type='gallery'";
				$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
				}
			}//end foreach	
		}//end foreach
	}//end fuction import_gallery
#gallery			
function gallery($data,$gall_ref=''){ 
	static $inc=0;  $inc++;
	$this->master_gallery=($this->blog_tiny_data2==='master_gall')?true:false;
	$msg='Changes are immediate and your Gallery Order has been Updated. Continue sorting as needed then refresh page or submit other changes to View the new Slide Show order';
	 $this->edit_styles_open();
	$count=false;
	
	if ($this->edit){
		$g_arr=array();
		$q="select distinct gall_ref,gall_table from $this->master_gall_table where master_gall_status!='master_gall' order by gall_table asc"; 
		$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
		if ($this->mysqlinst->affected_rows()){ 
			$gcount=$this->mysqlinst->num_rows($r);
			While ($gRows=$this->mysqlinst->fetch_assoc($r)){
				$g_arr[]=$gRows;
				}
			}
		else $gcount=0;
	 
			 
		if (!empty($gall_ref)){
			$where =" where gall_ref='$gall_ref'";
			 $count=$this->mysqlinst->count_field($this->master_gall_table,'pic_id','',false,$where);
			if ($count>1)$count=true;
			}
		if (!$count || empty($gall_ref)){
			 
			#create distinct  gall_ref now
			 
			if(empty($gall_ref)){   
	 
				$q="select distinct gall_ref from $this->master_gall_table where   master_gall_status!='master_gall' and gall_table='$this->tablename' order by gall_table";
				$rg=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
				if ($this->mysqlinst->affected_rows()){
					$tb_arr=array();
					while  (list($gall_tbn)=$this->mysqlinst->fetch_row($rg,__LINE__)){
						$tbn_arr[]=$gall_tbn;
						}
					$n=1;
					While (in_array($this->tablename.'_'.$n,$tbn_arr)){
						$n++;
						}
					$gall_ref=$this->tablename.'_'.$n; 
					}//affected rows
				else $gall_ref=$this->tablename.'_1';
				$ptable=(!$this->clone_local_data)?$this->master_post_table :$this->master_post_data_table;
				$pext=(!$this->clone_local_data)?'':'p';
				$q="update $ptable set blog_data1='$gall_ref'  where blog_id='$pext$this->blog_id' and blog_table_base='$this->tablename'"; 
				$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
				}
			if (!empty($gall_ref)){
				printer::printx('<p class="smallest editcolor fsminfo editbackground floatleft">Gall Ref: '.$gall_ref.'</p>');
				}
			if ($gcount >1){
				
			printer::pclear();
				$this->show_more('Create Master Gallery Info','noback','fsminfo rad3 small editbackground '.$this->column_lev_color,'','full');
				echo '<div class="fs4black floatleft editbackground maxwidth700"><!--wrap master gall href-->';
				printer::alertx('<p class="tip rad3 maxwidth100 floatleft " title="Two or more galleries are required to make a master gallery">'.$gcount.' galleries exist in this site</p>');
				printer::pclear();
				printer::alertx('<p class="'.$this->column_lev_color.' floatleft editbackground">When two or more  galleries are created on this site a "master gallery" may be created to display a Gallery of Galleries or in other words a listing of your galleies with each having a Title, an Image, and link to each individual Gallery Collection.</p>');
				 
				printer::alertx('<p class="floatleft editcolor editbackground">Choose a previously Created Gallery to Begin Your first Master Gallery Collection Here:
				<select class="smaller editcolor editbackground" onchange="edit_Proc.imageSelectMaster(this,\'gallref_image_choice_'.$inc.'\',\'gallref_title_'.$inc.'\',\''.$gall_ref.'\');"  name="create_master_gallery['.$gall_ref.']">');
				printer::alertx('<option value="" select="selected">Choose Gallery to Add</option>');
				foreach($g_arr as $arr){
					$choosegall_ref=$arr['gall_ref'];
					$ch_gall_table=$arr['gall_table'];
					$q="select page_title,page_ref, page_filename from $this->master_page_table where page_ref='$ch_gall_table' order by page_ref asc";   
					$rpag = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
					
					list($page_title,$page_ref,$page_filename)=$this->mysqlinst->fetch_row($rpag);
					 if (empty($page_ref)||$page_ref!==$ch_gall_table)continue;
				
					$menu_title=(!empty($page_title))?'Menu Title: '.substr($page_title,0,15):'';
					printer::printx('<option  value="'.$choosegall_ref.'">'."GallRef: $choosegall_ref on PageRef: $ch_gall_table $menu_title".'</option>');
					}
				printer::printx('</select></p>');
				printer::pclear(20);
				echo '<div id="gallref_image_choice_'.$inc.'"><!--display image choice--></div><!--display image choice-->';
				printer::pclear(20);
				echo '<div id="gallref_title_'.$inc.'" class="editbackground editcolor" style="display:none">Enter a title For Your Gallery<input type="text" name="master_title['.$gall_ref.']" maxlength="50" size="50"></div>'; 
				printer::pclear();
				echo '<div id="dis_gallref_title_'.$inc.'"><!--or Continue-->';
				printer::alert('<br>OR<br><br>');
				printer::pclear();
				printer::alertx('<p class="info  floatleft editbackground" title="two or more galleries required to make master gallery">Continue Below to Configure a Normal Gallery and Upload your first image</p>');
				printer::pspace(20);
				
				echo '</div><!--or Continue-->';
				printer::pspace(20);
				echo'<div id="show_gallref_title_'.$inc.'" class="warn1 center inline" style="display:none;">Following your selection of image and entering the title hit any submit button and Configurations applicable to a Master Gallery Will Appear along with your First Gallery choice in this Master Gallery Post<!--show submit button and info-->';
				$this->submit_button('Submit Create Master Gallery');
				echo'</div>';
				echo '</div><!--wrap master gall href-->';
				$this->show_close('Master Gallery Info');
				}//count <1 
			}//gallery empty
	 	else {
			$this->show_more('Master Gallery Info','noback','fsminfo rad3 tiny editbackground '.$this->column_lev_color,'',500);
			echo '<div class="fsminfo floatleft editbackground"><!--wrap master gall href-->';
			if (!$this->master_gallery)
				printer::alertx('<p class="'.$this->column_lev_color.' floatleft editbackground">  When two or more  galleries are created on this site and A new gallery is created with no images uploaded an option to create a master gallery will be displayed here. A master gallery is a Gallery of Galleries having a Title, an Image, and link to each Gallery Collection.</p>');
			else printer::alertx('<p class="'.$this->column_lev_color.' floatleft editbackground">New Gallery Collections may be added to the Master Gallery see the option below</p>');
			echo '</div><!--wrap master gall href-->';
			$this->show_close('Master Gallery Info');
			} //not empty
		}//edit
		if ($this->edit&&!$this->master_gallery&&(!$this->is_clone||$this->clone_local_data)){
			 if ($gcount >0){
				$this->show_more('Import/Start New Gallery','noback','fsminfo rad3 small editbackground '.$this->column_lev_color,'','full');
				echo '<div class="fs4black floatleft editbackground maxwidth700"><!--wrap reg gall href-->';
				printer::alertx('<p class="tip rad3 maxwidth100 floatleft " title="Move Previously Created gallery Here">'.$gcount.' galleries exist  in this site</p>');
				printer::pclear();
				printer::alertx('<p class="'.$this->column_lev_color.' floatleft editbackground">When two or more  galleries are created on this site a "master gallery" may be created to display a Gallery of Galleries or in other words a listing of your galleies with each having a Title, an Image, and link to each individual Gallery Collection.</p>');
				 
				printer::alertx('<p class="floatleft editcolor editbackground">Choose a previously Created Gallery to Move/Import Here or Select Start New Gall Option.<br>  <span class="caution">Caution: All images from the original gallery will be moved to this page</span>  
				<select class="smaller editcolor editbackground" onchange="edit_Proc.imageSelectGallery(this,\'gall_image_select_'.$inc.'\',\'gallref_title_'.$inc.'\',\''.$gall_ref.'\');"  name="'.$this->clone_ext.'import_gallery['.$this->blog_id.']">');
				printer::alertx('<option value="" select="selected">Choose Gallery to Add</option>');
				printer::printx('<option  value="create_new_gallery">Start Fresh Over: Remove Current Gall Images</option>');
				foreach($g_arr as $arr){
					$choosegall_ref=$arr['gall_ref'];
					$ch_gall_table=$arr['gall_table'];
					printer::printx('<option  value="'.$choosegall_ref.'">'."GallRef: $choosegall_ref with PageRef: $ch_gall_table".'</option>');
					}
				printer::printx('</select></p>');
				echo '<div class="editcolor editbackground" id="gall_image_select_'.$inc.'"><!--display image choice--></div><!--display image choice-->';
				echo '<div class="editcolor editbackground" id="gallref_title_'.$inc.'"><!--display hold--></div><!--display hold-->';//this is not used in regular gallery  provides div id placeholder only because is needed  in master gallery
				printer::pclear(20);
				printer::pclear(20);
				echo '</div><!--wrap reg gall href-->';
				$this->show_close('Import/Start New Gallery');
				
			//else printer::printx('<p class="editbackground floatleft editcolor fsminfo"><input type="checkbox" name="import_gallery['.$this->blog_id.']" value="create_new_gallery"></p>');
			} //count
		
	
		}//end if edit  ! master
	$this->blog_options($data,$this->blog_table);
		#blog data2 indexes
	$gall_indexes='preview,galltype,gall_glob_title,limit_width,mainmenu,controlbar,six,fixed_pad,padleft,smallpic,largepic,caption,preview_padtop,thumbnail_height,transition,thumbnail_pad_right,thumbnail_pad_bottom,thumb_width_type,caption_vertical_align,,caption_width,preview_pad_bottom,gall_icon_color,image_quality';
	
	$gall_index_arr=explode(',',$gall_indexes);
	//$this->{$data.'_blog_data2_arrayed'}=$blog_data2=explode(',',$this->blog_data2);
	$blog_data2=explode(',',$this->blog_data2);//holds the various gall configs..
	for ($i=0; $i <count($gall_index_arr); $i++){  
		if (!array_key_exists($i,$blog_data2)){
			$blog_data2[$i]='';
			$this->{$data.'_blog_data2_arrayed'}[$i]='';
			}
		} 
	foreach($gall_index_arr as $key => $index){
		${$index.'_index'}=$key;
		}
	
	$quality=(!empty($blog_data2[$image_quality_index])&&$blog_data2[$image_quality_index]>9&&$blog_data2[$image_quality_index]<101)?$blog_data2[$image_quality_index]:((!empty($this->page_options[$this->page_image_quality_index])&&$this->page_options[$this->page_image_quality_index]<101&&$this->page_options[$this->page_image_quality_index]>9)?$this->page_options[$this->page_image_quality_index]:Cfg::Pic_quality);
 
	$gall_expand_menu_icon=(!empty($blog_data2[$gall_icon_color_index])&&strlen($blog_data2[$gall_icon_color_index])>3&&strpos($this->menu_icon_color,$blog_data2[$gall_icon_color_index])!==false)?$blog_data2[$gall_icon_color_index].'_menu_icon.gif':'white_menu_icon.gif';
		 
	$caption_width=(is_numeric($blog_data2[$caption_width_index])&&$blog_data2[$caption_width_index]>=50&&$blog_data2[$caption_width_index]<701)?$blog_data2[$caption_width_index]:0;
	$use_ajax=(!empty($blog_data2[$controlbar_index]))?true:false;
$transition_time=(!empty($blog_data2[$transition_index]))?$blog_data2[$transition_index]:.7;
	$captions=($blog_data2[$caption_index]=='global'||$blog_data2[$caption_index]=='none')?$blog_data2[$caption_index]:'individual';
	$smallpicplus=(is_numeric($blog_data2[$smallpic_index])&&$blog_data2[$smallpic_index]>=50&&$blog_data2[$smallpic_index]<1001)?$blog_data2[$smallpic_index]:(($this->master_gallery)?Cfg::Master_gall_pic_width:Cfg::Small_gall_pic_plus);
	 //used for master gallery and normal gallery  
	$largepicplus=(is_numeric($blog_data2[$largepic_index])&&$blog_data2[$largepic_index]>=125&&$blog_data2[$largepic_index]<3001)?$blog_data2[$largepic_index]:800;
	$limit_width=(is_numeric($blog_data2[$limit_width_index])&&$blog_data2[$limit_width_index]>299)?$blog_data2[$limit_width_index]:0;
	//$gall_width= $this->current_net_width_percent*$this->column_total_width[0];
	$main_menu=$blog_data2[$mainmenu_index]; 
	$mm_arr=explode('@@',$main_menu);  
	$main_menu_id_check=(array_key_exists(2,$mm_arr))?$mm_arr[2]:0;  
	$this->default_imagetitle=$this->blog_tiny_data4;
	$this->default_subtitle=$this->blog_tiny_data5;
	$this->default_description=$this->blog_data7;
	$shadowcalc=$this->calc_border_shadow($this->blog_tiny_data3); 
	$maxwidth_adjust_preview=100-$shadowcalc/3;//300 ~ min image width in px conv to %
	$shadowcalc=$this->calc_border_shadow($this->blog_tiny_data1);
	$adjust_previewspace=$shadowcalc/3;
	$maxwidth_adjust_expanded=100-$shadowcalc/3;//300 ~ min image width in px conv to %
	$padleft=(is_numeric($blog_data2[$padleft_index])&&$blog_data2[$padleft_index]>=.2&&$blog_data2[$padleft_index]<21)?$blog_data2[$padleft_index]:8;  
	for ($i=1; $i<7; $i++){
			${'checked'.$i}='';	
			}
		$checked='checked="checked"'; 
		switch ($blog_data2[$preview_index]) {
			case 'highslide_multiple' :
			$gall_display='highslide';
			$preview_display='multiple';
			$checked1=$checked;
			$show_under_preview=false;
			break;
			case 'highslide_single' :
			$gall_display='highslide';
			$show_under_preview=false;
			$preview_display='single';
			$checked2=$checked;
			break; 
			case 'expand_preview_multiple' :
			$gall_display='expandgallery';
			$preview_display='multiple';
			$show_under_preview=false;
			$checked3=$checked;
			break;
			case 'expand_preview_single' :
			$gall_display='expandgallery';
			$preview_display='single';
			$show_under_preview=false;
			$checked4=$checked;
			break; 
			case 'preview_under_expand' :
			$gall_display='no_display'; 
			$preview_display='none';
			$show_under_preview=true;
			$checked5=$checked;
			break;
			case 'expand_preview_none' :
			$gall_display='no_display';
			$preview_display='none';
			$show_under_preview=false;
			$checked6=$checked;
			break;
			case 'rows_caption' :
				#is master gall
			$gall_display='rows_caption';
			$preview_display='none';
			$show_under_preview=false;
			break;
			case 'display_single_row' :
				#is master gall
			$gall_display='display_single_row';
			$preview_display='none';
			$show_under_preview=false;
			break;
			default:
			case 'expand_preview_multiple' :
			$gall_display='expandgallery';
			$preview_display='multiple';
			$show_under_preview=false;
			$checked3=$checked;
			break;
			}
		for ($i=1; $i<7; $i++){
			${'expandchecked'.$i}='';
			}
		$gall_display=($this->master_gallery&&$gall_display!=='rows_caption')?'display_single_row':$gall_display;
		$display_float='inlineblock_'.$this->blog_id.'';//for master gall mode display single
		switch ($blog_data2[$galltype_index]) { 
			case 'simulate' :
			$transition='ajax_fade';
			$new_page_effect=true;
			$expandchecked1=$checked;
			break;
			case 'maintain' :
			$transition='ajax_fade';
			$new_page_effect=false;
			$expandchecked2=$checked;
			break; 
			case 'new' :
			$transition='fade';
			$expandchecked3=$checked;
			$new_page_effect=false;
			break; 
			case 'new_none' :  
			$transition='none';
			$new_page_effect=false;
			$expandchecked4=$checked;
			break;
			case 'float' :  //for master gallery
			$transition='none';
			$new_page_effect=false;
			$expandchecked5=$checked;
			break;
			case 'center' :  
			$display_float='marginauto';
			$transition='none';
			$new_page_effect=false;
			$expandchecked6=$checked;
			break;
			default:
			$transition='ajax_fade';
			$new_page_effect=true;
			$expandchecked1=$checked;
			break;
			}  
			
	if ($this->master_gallery&&$display_float!=='marginauto') 
		$expandchecked5=$checked;
	 if ($gall_display=='highslide'){
		
		$allowSizeReduction=($this->edit)?'hs.allowSizeReduction: false':'hs.allowSizeReduction:true';
echo <<<eol
<script > 
if (hs.addSlideshow) hs.addSlideshow({
	slideshowGroup: "$this->blog_data1",
	interval: 7000, 
	dimmingDuration : $transition_time,
	 fixedControls: "fit",
	 repeat: true,   
        useControls: true, 
         overlayOptions: {
                opacity: .7,   //set the opacity of the controlbar
                position: "bottom center",  //position of controlbar  
                hideOnMouseOut: true
        }

});
</script>
eol;
		}//gal display
	echo '<div class="holder" id="holder_'.$this->blog_id.'"><!--gall holder-->';
	$temp_arr=array();
	$thumb_width_type=($blog_data2[$thumb_width_type_index]==='width_height'||$blog_data2[$thumb_width_type_index]==='width')?$blog_data2[$thumb_width_type_index]:(($this->master_gallery)?'width':'width_height');  
	$thumbnail_height=( $blog_data2[$thumbnail_height_index]>9.9)?$blog_data2[$thumbnail_height_index]:60;
	$thumbnail_pad_right=(is_numeric($blog_data2[$thumbnail_pad_right_index]))?$blog_data2[$thumbnail_pad_right_index]:5;
	$thumbnail_pad_bottom=(is_numeric($blog_data2[$thumbnail_pad_bottom_index]))?$blog_data2[$thumbnail_pad_bottom_index]:5;
	$preview_pad_bottom=(is_numeric($blog_data2[$preview_pad_bottom_index]))?$blog_data2[$preview_pad_bottom_index]:30;
	$preview_padtop=(is_numeric($blog_data2[$preview_padtop_index]))?$blog_data2[$preview_padtop_index]:30;
	$fixed_pad=(empty($blog_data2[$fixed_pad_index]))?false:true;
	$controlbar=(!empty($blog_data2[$controlbar_index]))?$blog_data2[$controlbar_index]:'controlbar-white.gif';
	$caption_vertical_align=($blog_data2[$caption_vertical_align_index]!=='middle'&&$blog_data2[$caption_vertical_align_index]!=='bottom')?'top':$blog_data2[$caption_vertical_align_index];
	if(empty($gall_ref)){ // printer::alert_neg('reinitiate creat new gall ref');
		/*
		//this was moved above and may be obsolete 
			//$msg='Because copied or moved galleries are page specific config information has been copied but new Pictures must be selected';
			//$this->instruct[]=$msg; 
		$q="select distinct gall_ref from $this->master_gall_table where gall_ref!=master_gall_ref and gall_table='$this->tablename'";
		$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
		if ($this->mysqlinst->affected_rows()){
			$tb_arr=array();
			while  (list($gall_tbn)=$this->mysqlinst->fetch_row($r,__LINE__)){
				$tbn_arr[]=$gall_tbn;
				}
			$n=1;
			While (in_array($this->tablename.'_'.$n,$tbn_arr)){
				$n++;
				}
			$gall_ref=$this->tablename.'_'.$n; 
			}//affected rows
		else $gall_ref=$this->tablename.'_1';
		$q="update $this->master_post_table set blog_data1='$gall_ref'  where blog_id='$this->blog_id'";
		$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);*/
		if (!$this->edit){ 
			printer::printx('<p class="fsminfo editbackground  '.$this->column_lev_color.'">New Gallery Coming Soon</p>');
			return;
			}
		} //if empty gall ref
	
	if ($this->edit&&($this->clone_local_style||!$this->is_clone)){
		printer::pclear(5); 
		printer::alertx('<p class="info fsminfo editbackground infoback rad5 floatleft maroonshadow left">All Configurations Changes Will Be Updated Immediately Provided the Original Uploaded Photos are sufficiently Large to Adjust to any Image width changes</p>');
		printer::pclear(5);
		if (!$this->master_gallery){ 
			$this->show_more('Configure Your Gallery Display','','','',700);#<!--Configure gallery-->
			echo '<div class="'.$this->column_lev_color.' fs1color floatleft editbackground left" ><!--config gall settings-->';
			echo '<div class="fsmmaroon floatleft left  maroon" style="background:#c6a5a5;" > <span  class="bold whiteshadow">Choose One of the following  Choices of Preview and Expanded Image Display Settings and any sub option choice</span><!--gall display setting-->';
			printer::pclear(7);
			
			echo '<div class="maroon fs2maroon floatleft left" style="background:#dccbcb;"><!--Expand Gallery display setting-->These first 4 Choices utilize a Gallery in which:<br>
			 
			a. Transitions Utilize a fade-in-out effect for Slide Show navigation of the Expanded Images.<br>
			b. Separate Preview Images Display arranged with single or multiple preview images per row that open to the Expanded Image slide Show when clicked and preview images disapear. 
			c. Expanded Images click to previous or next images depending on whether the left or side side of the image is clicked.<br>
			d. When a preview image is clicked their are options for whether the expanded images keep the same page context (by simply replacing the preview images), or simulate a new page, or navigate to an actual new page for each image.  <i><b>The first two options may result in a smoother transition than actually changing pages!</b></i><br>
			e. Options for preview images under the expanded images instead of shown separately or no preview images at all.<br><br>'; 
			 
			echo '<div class="maroon fs1maroon floatleft left" style="background:#dccbcb;" ><!--separate preview Expand Gallery display setting--> ';
			printer::printx('<p class="bold">1.<input type="radio" value="expand_preview_multiple" name="'.$data.'_blog_data2['.$preview_index.']" '.$checked3.'>Use Multiple Preview Images Per Row for Separate Preview Display</p>');
			printer::printx('<p class="bold">2.<input type="radio" value="expand_preview_single" name="'.$data.'_blog_data2['.$preview_index.']" '.$checked4.'>Use a Single Preview Images Per Row for  Separate Preview Display </p>');
			
			printer::pclear(5);
			
			printer::pclear(15); 
			printer::printx('<p class="bold">3.<input type="radio" value="preview_under_expand" name="'.$data.'_blog_data2['.$preview_index.']" '.$checked5.'>Preview Images Under the Current Expanded Image</p>'); 
			printer::printx('<p class="bold">4.<input type="radio" value="expand_preview_none" name="'.$data.'_blog_data2['.$preview_index.']" '.$checked6.'>No Preview Images</p>'); 
			 
			printer::pclear(5); 
			printer::pclear(5);
			echo '<div  class="fsmlightred marginauto center inline-table" style="width:70%; background: rgba(255,255,255,.5);" ><!--Choose Page Context--><p class="center small bold">Choose your Expand Image Context<span class="smallest"> (for choices 3-6)</span></p>';
			printer::printx('<p class="left"> <input type="radio" value="simulate" name="'.$data.'_blog_data2['.$galltype_index.']" '.$expandchecked1.'>&nbsp;&nbsp;&#8226;Simulate New Page&#8226; </p>');
			printer::printx('<p class="left"> <input type="radio" value="maintain" name="'.$data.'_blog_data2['.$galltype_index.']" '.$expandchecked2.'> &nbsp;&nbsp;&#8226;Maintain Page Context &#8226;  </p>');
			printer::printx('<p class="left"> <input type="radio" value="new" name="'.$data.'_blog_data2['.$galltype_index.']" '.$expandchecked3.'>&nbsp;&nbsp;&#8226;Navigate to New Page With Fade&#8226; </p>');
			 
			printer::printx('<p class="left"> <input type="radio" value="new_none" name="'.$data.'_blog_data2['.$galltype_index.']" '.$expandchecked4.'>&nbsp;&nbsp;&#8226;Navigate to New Page with no Transition Effect&#8226;</p>');
			
			echo '</div><!--Choose Page Context--> ';
			
			echo '</div><!--separate preview Expand Gallery display setting--> ';
			
			echo '</div><!--Expand Gallery display setting--> ';
			printer::pclear(15);
			echo '<div class="maroon fs2maroon floatleft left" style="background:#dccbcb;"><!--highslide display setting-->The next two Choices have the following features:<br>
			a. Utilize the <span class="info maroonshadow" title="www.highslide.com">HighSlide</span> expanding/fade-in-out effect for Slide Show navigation of the Expanded Images.<br>
			b. The Expanded Images simulate being on a new page with only the expand image and captions being displayed<br>
			c.   Separate Preview Images Display arranged with single or multiple preview images per row that open to the Expanded Image slide Show when clicked and preview images disapear. 
			d. Responsive down to 300px View Screen only';
			printer::printx('<p class="bold">5.<input type="radio" value="highslide_multiple" name="'.$data.'_blog_data2['.$preview_index.']" '.$checked1.'>Display with Multiple Representative Images Per Row</p>');
			printer::printx('<p class="bold">6.<input type="radio" value="highslide_single" name="'.$data.'_blog_data2['.$preview_index.']" '.$checked2.'>Display with a Single Image Per Row</p>');
			printer::pclear(5);
			echo '</div><!--highslide display setting-->';
			printer::pclear(15);
			echo '</div><!--gall display setting-->';
			//here is where MENU PLUGIN Goes if DECIDED TO REIMPLement
		#even less one show more	
			$checked='checked="checked"';
			$checked1=($blog_data2[$controlbar_index]!='controlbar-black-border.gif')?$checked:'';
			$checked2=($blog_data2[$controlbar_index]=='controlbar-black-border.gif')?$checked:'';
			echo '<div class="'.$this->column_lev_color.' fsminfo editbackground floatleft left"> <!--highslide control bar-->
			For Highslide Gallery Choose a Light or Dark theme Control Bar 
			<p><input type="radio" name="'.$data.'_blog_data2['.$controlbar_index.']" '.$checked1.' value="controlbar-white.gif">&nbsp;Light Theme Control Bar</p>
			<p><input type="radio" name="'.$data.'_blog_data2['.$controlbar_index.']" '.$checked2.' value="controlbar-black-border.gif">&nbsp;Dark Theme Control Bar</p>
			 
			 </div><!--highslide control bar-->';
			 
			printer::pclear();
			
			echo '<div class="'.$this->column_lev_color.' fsminfo editbackground floatleft left">Configure your Expanded Gallery image size.  Enter the maximum width or  height for your image. (Scaled down Images will be used for Smaller devices)<!--wpplus-->';
			$this->mod_spacing($data.'_blog_data2['.$largepic_index.']',$largepicplus,125,2000,5,'px');// 
			echo '</div><!---wfplus-->';
			printer::pclear();
			echo '<div  class="maroon fs2maroon floatleft left" style="background:#dccbcb;"><!--outer wrap more expand-preview display settings-->';
			printer::pspace(10);
			###########
			$this->show_more('Choose Color For Expanded Images Return Navigation Icon','noback','fs2info rad5 editbackground infoclick left5 right5','',500);
			echo '<div class="fsminfo whitebackground " ><!--link color--><br>';
			echo '<p class="'.$this->column_lev_color.' editbackground editfont">Choose Your Menu Icon Color: </p>';
			printer::pclear(5);
			$menu_icon_color_arr=explode(',',$this->menu_icon_color);
			for ($i=0;$i<count($menu_icon_color_arr);$i++){
				$checked=($blog_data2[$gall_icon_color_index]===$menu_icon_color_arr[$i])?'checked="checked"':'';
			 echo  '<p class="floatleft left" title="'.$menu_icon_color_arr[$i].'"><input type="radio" name="'.$data.'_blog_data2['.$gall_icon_color_index.']." value="'.$menu_icon_color_arr[$i].'" '.$checked.'><img src="'.Cfg_loc::Root_dir.Cfg::Menu_icon_dir.$menu_icon_color_arr[$i].'_menu_icon.gif" width="50"  alt="dropdown choices menu '.$menu_icon_color_arr[$i].'_menu_icon.gif"></p>';
			}//end for loop colors
			printer::pclear();
			echo '</div><!--link color-->';
			$this->show_close('Choose Color For Expanded Images Return Navigation Icon');
			printer::pclear(8);
			$checked='checked="checked"';
			$checked1=(empty($blog_data2['.$fixed_pad_index.']))?$checked:'';// not used currently
			$checked2=(empty($blog_data2['.$fixed_pad_index.']))?'':$checked;
			$this->show_more('Adjust Separate Preview Image Display','noback','fs2info rad5 editbackground infoclick left5 right5','Style/Config an initial Preview Images Page if Selected',500);
			echo '<div class="'.$this->column_lev_color.' fsminfo editbackground floatleft left">Configure your preview image size for separate preview image displays.  Enter the max value for  width  or  height for your image (Scaled down Images will be used for Smaller devices)<!--prev image size-->';
			$this->mod_spacing($data.'_blog_data2['.$smallpic_index.']',$smallpicplus,50,1000,5,'px');// 
			printer::pclear();
			$msg=($this->master_gallery)?'By Default Your Master Gallery Representative Images are equal width but you can choose Equal height/width Depending which is greater': 'By Default you Regular Gallery Preview Page Images (if used) are set to a maximum height/width depending which is greater but theres a choice for equal width instead';
			printer::printx('<p>'.$msg.'</p>');
			 
			$checked1=($thumb_width_type==='width')?'checked="checked"':'';
			$checked2=($thumb_width_type==='width_height')?'checked="checked"':'';
			printer::printx('<p><input type="radio" '.$checked1.' value="width" name="'.$data.'_blog_data2['.$thumb_width_type_index.']">Choose Equal Width Setting</p>');
			printer::printx('<p><input type="radio" '.$checked2.' value="width_height" name="'.$data.'_blog_data2['.$thumb_width_type_index.']">Choose Max Width/Height Setting</p>');
			$this->show_more('Adjusting Multiple Preview Image Rows','noback');
			echo '<div class="fs2info editbackground"><!--border previews-->';
			echo '<div class="fsminfo editbackground '.$this->column_lev_color.' floatleft editfont maxwidth500"><!--preview image spacing-->
			Change default spacing between images when choosing multiple display:
			 ';
			
			printer::alert('Choose your Preview Side Spacing Setting:');
			$this->mod_spacing($data.'_blog_data2['.$padleft_index.']',$padleft,0,20,.2,'%');
			echo '</div><!--preview image spacing-->';
			printer::pclear();
			echo '<div class="fsminfo editbackground editcolor floatleft">Choose the Spacing Between the rows of Preview Images:';
			$this->mod_spacing($data.'_blog_data2['.$preview_pad_bottom_index.']',$preview_pad_bottom,0,175,1,'px');
			echo '</div>';
			printer::pclear();
			echo '<div class="fsminfo editbackground '.$this->column_lev_color.' floatleft editfont maxwidth500"><!--final width adjust gal--> 
			 Additionally set a  maximum width of the available preview presentaion space to narrow the gallery on and create more unused space on the end of the each preview row. This also effects the number of preview images in a  multiple images in a row  option is chosen. The final width will be determined which ever is smallest: the overall post width, the width you set here or the viewers view screen! <br>'; 
				printer::alert('Final Width Adjust Gallery Preview:');
			 $this->mod_spacing($data.'_blog_data2['.$limit_width_index.']',$limit_width,300,1000,1,'px',true);
			echo '</div><!--Edit Final Width Adjust Preview Gall-->'; 
			printer::pclear();
			
			echo '</div><!--border previews-->';
			$this->show_close('Adjusting preview Page with Multiple Preview Image Rows');
			echo '</div><!---prev image size-->';
			$this->show_close('Adjust Separate Preview Image Display');
			printer::pclear(7);
			
			
			$this->show_more('Adjust Preview Under Slide Selection','noback','fs2info editbackground infoclick rad5 left5 right5','Style/Config the Preview Images under a Gallery if Selected',500);
			echo '<div class="fs2info"><!--border previews-->';
			echo '<div class="fsminfo editbackground '.$this->column_lev_color.' floatleft editfont maxwidth500"><!--preview image spacing-->
			If you have chosen to display the preview under slide show option for previewing your photos  change the default sizing and spacing of your preview images here'; 
			printer::alertx('<p class="fs1info">Choose the Spacing Above the first Row of Preview Images:</p>');
			$this->mod_spacing($data.'_blog_data2['.$preview_padtop_index.']',$preview_padtop,0,135,1,'px');
			 printer::alertx('<p class="fs1info">Choose the Height of your  Preview Images:</p>');
			$this->mod_spacing($data.'_blog_data2['.$thumbnail_height_index.']',$thumbnail_height,10,200,2,'px'); 
			printer::alertx('<p class="fs1info">Choose the Side Spacing Between your  Preview Images:</p>');
			$this->mod_spacing($data.'_blog_data2['.$thumbnail_pad_right_index.']',$thumbnail_pad_right,0,35,1,'px'); 
			printer::alertx('<p class="fs1info">Choose the Spacing Between rows of Preview Images:</p>');
			$this->mod_spacing($data.'_blog_data2['.$thumbnail_pad_bottom_index.']',$thumbnail_pad_bottom,0,35,1,'px'); 
			echo '</div><!--preview image spacing-->';
			 
			printer::pclear();
			
			echo '</div><!--border previews-->';
			$this->show_close('Adjusting Multiple Preview Image Rows'); 
			printer::pclear(7);
			$this->show_more('Adjust Expanded Image Quality','noback','fs2info editbackground infoclick rad5 left5 right5','Expanded image quality may be adjusted for better quality versus smaller image size',500);
		echo'<div class="floatleft editbackground fsminfo info" title="By Default Expanded Gallery Images will have a Default Quality factor  with 100 being the highest and 10 the lowest. The higher the image quality the larger the filesize and the slower the download speed. Its possible to change the Default value  in the Page Configuration options which will effect all cache images on the site that are not specifically configured for this value in the post type: image, slideshow, or gallery configurations"  ><!--quality image-->Change Current Image Quality setting:';
	$this->mod_spacing($data.'_blog_data2['.$image_quality_index.']',$quality,10,100,1,'%');
	printer::print_info('Expanded Images will auto reload @ new Quality setting');
	echo'</div><!--quality image-->';
		printer::pclear();//Change Current Image Quality settin
		$this->show_close('Adjust Expanded Image Quality');	
			echo '</div><!--outer wrap more expand-preview display settings-->';
			printer::pclear(7);
			$this->submit_button();
			printer::pclear(7);
			
			 
			echo '</div><!--config gall settings-->';
			$this->show_close('Configure gallery');#<!--Configure gallery-->
			 
			}//not  master_gall
		else { // is Master Gallery
			$checked='checked="checked"';
			$checked1=($blog_data2[$preview_index]==='rows_caption')?$checked:'';
			$checked2=($blog_data2[$preview_index]!=='rows_caption')?$checked:'';
			$this->show_more('Configure Your Master Gallery Display','','','',700);#<!--Configure gallery--> 
			echo '<div class="'.$this->column_lev_color.' fs1color floatleft editbackground left "><!--config gall settings-->';
			################33
			echo '<div class="fsmmaroon floatleft left  maroon" style="background:#c6a5a5;" > <span  class="bold whiteshadow">Choose One of the following Two Choices of Display type for the Gallery Collection Preview Image Link and Title/Caption</span><!--Master gall display setting-->';
			printer::pclear(7);
			echo '<div class="maroon fs2maroon floatleft left" style="background:#dccbcb;"><!--highslide display setting-->';
			echo '<div class="fs1black bold" style="background-color:#b5c6a5;"><!--wrap float caption choice-->';
			printer::printx('<p class="bold">1.<input type="radio" value="rows_caption" name="'.$data.'_blog_data2['.$preview_index.']" '.$checked1.'>Preview with Multiple Images Per Row</p>');
			printer::printx('<p class="left">Captions for Multiple images per row will display under Image</p>');
			echo '</div><!--wrap float caption choice-->';
			echo '<div class="fs1black bold" style="background-color:#b5c6a5;"><!--wrap float caption choice-->2.<input type="radio" value="display_single_row" name="'.$data.'_blog_data2['.$preview_index.']" '.$checked2.'>Preview with a Single Image Per Row';
			printer::printx('<p class="left">Further Choice For Single Image Per Row: </p>');
			printer::printx('<p class="left"> <input type="radio" value="float" name="'.$data.'_blog_data2['.$galltype_index.']" '.$expandchecked5.'>Float Captions to Left of Image</p>');
			printer::printx('<p class="left"> <input type="radio" value="center" name="'.$data.'_blog_data2['.$galltype_index.']" '.$expandchecked6.'>Arrange Captions Under Photo</p>');
			echo '</div><!--wrap float caption choice-->';
			printer::pclear(5);
			
			printer::alertx('<div class="'.$this->column_lev_color.' fsminfo maxwidth500 floatleft editbackground">Vertical Align Left Captions Top Middle or Bottom to photo '); 
		 
		
		forms::form_dropdown(array('top','middle','bottom'),'','','',$data.'_blog_data2['.$caption_vertical_align_index.']',$caption_vertical_align,false,'editcolor editbackground left');
		printer::alertx('</div>');
			echo '</div><!--single-mult display setting-->';
			echo '</div><!--Master gall display setting-->';
			echo '<div class="fsmmaroon floatleft left  maroon" style="background:#c6a5a5;" > <span  class="bold whiteshadow">Choose One of the following Two Choices of Display type for the Gallery Collection Preview Image Link and Title/Caption</span><!--Master gall image display-->';
			printer::pclear(15); 
			$checked='checked="checked"';
			$checked1=(empty($blog_data2['.$fixed_pad_index.']))?$checked:'';// not used currently
			$checked2=(empty($blog_data2['.$fixed_pad_index.']))?'':$checked;
			$this->show_more('Adjust Master Image Display','noback','fs2info rad5 editbackground infoclick left5 right5','Style/Config Image Preview Links in Master Gallery',500);
			echo '<div class="'.$this->column_lev_color.' fsminfo editbackground floatleft left"><!--prev image size-->';
			printer::printx('<p>Configure your thumb image size   Enter the max value for  width  or  width/height for your Master Gallery preview image (Scaled down Images will be used for Smaller devices)');
			$this->mod_spacing($data.'_blog_data2['.$smallpic_index.']',$smallpicplus,50,1000,5,'px');// 
			printer::pclear();
			$msg=($this->master_gallery)?'By Default Your Master Gallery Representative Images are equal width but you can choose Equal height/width Depending which is greater': 'By Default you Regular Gallery Preview Page Images (if used) are set to a maximum  height/width depending which is greater but there is also a choice for equal width instead';
			printer::printx('<p>'.$msg.'</p>');
			
			$checked1=($thumb_width_type==='width')?'checked="checked"':'';
			$checked2=($thumb_width_type==='width_height')?'checked="checked"':'';
			printer::printx('<p><input type="radio" '.$checked1.' value="width" name="'.$data.'_blog_data2['.$thumb_width_type_index.']">Choose Equal Width Setting</p>');
			printer::printx('<p><input type="radio" '.$checked2.' value="width_height" name="'.$data.'_blog_data2['.$thumb_width_type_index.']">Choose Max Width/Height Setting</p>');
			 $this->show_more('Adjusting Gallery Image Rows in Master Gallery','noback');
			echo '<div class="fs2info"><!--border previews-->';
			echo '<div class="fsminfo editbackground '.$this->column_lev_color.' floatleft editfont maxwidth500"><!--preview image spacing-->
			Change default side spacing between images when choosing multiple display:
			';
			
			printer::alert('Choose your Side Spacing Setting:');
			$this->mod_spacing($data.'_blog_data2['.$padleft_index.']',$padleft,0,20,.2,'%');
			echo '</div><!--preview image spacing-->';
			printer::pclear();
			echo '<div class="fsminfo editbackground editcolor floatleft">Choose the Spacing Between the rows of Preview Images:';
			$this->mod_spacing($data.'_blog_data2['.$preview_pad_bottom_index.']',$preview_pad_bottom,0,175,1,'px');
			echo '</div>';
			printer::pclear();
			
			echo '<div class="fsminfo editbackground '.$this->column_lev_color.' floatleft editfont maxwidth500"><!--final width adjust gal-->
			
			 Further adjust the width of the available  presentaion space  and create more unused space on the end of the each image row.   This also effects the number of preview images when the  multiple images in a row  option is chosen. The final width will be determined which ever is smallest: the overall post width, the width you set here or the viewers view screen! <br>'; 
				printer::alert('Final Width Adjust Master Gallery Preview:');
			 $this->mod_spacing($data.'_blog_data2['.$limit_width_index.']',$limit_width,300,1000,1,'px',true);
			echo '</div><!--Edit Final Width Adjust Preview Gall-->'; 
			printer::pclear(); 
				echo '<div class="fsminfo editbackground '.$this->column_lev_color.' floatleft editfont maxwidth500"><!--final width adjust captions--> 
			 Optionally Set width of caption area'; 
				printer::alert('Set Specific Width For Master Gallery Caption. A default width of 300px will be used if using display single row with left float captions. To enable fluid response layout for your page left float Captions will automatically be displayed below the image when the viewport device width is below the total width of the image plus caption  width:');
			 $this->mod_spacing($data.'_blog_data2['.$caption_width_index.']',$caption_width,100,701,5,'px',true);
			echo '</div><!--Edit Final Width Adjust Captons-->'; 
			printer::pclear();
			echo '</div><!--border previews-->';
			$this->show_close('Adjusting Master Gall with Multiple Preview Image Rows');
			echo '</div><!---prev image size-->';
			$this->show_close('Adjust Separate Preview Image Display');
			echo '</div><!--Master gall image display-->';
			printer::pclear(7);
			echo '</div><!--config gall settings-->';
			$this->show_close('Configure gallery');#<!--Configure gallery-->
			}// end else is   master_gall
		printer::pclear();
		} // not is_clone etc
	if ($this->edit&&!$this->master_gallery&&(!empty($this->clone_local_data)||!$this->is_clone)){
		printer::pclear();
	$this->show_more('Default Caption Option','noback','','',600);
			echo '<div class="'.$this->column_lev_color.' fsminfo editbackground floatleft left">Image specific captions are made under the "Edit Image Captions or Delete an Image Here" Link Below.  However, Here  optionally Add Default Title, Subtitle and/or descriptions which will be applied to images that don&#34;t have them<!--global captions-->';
			printer::alertx('<p class="tip">Tip: If You are using a Default title,subtitle, or description but want to leave a certain image caption empty type the word empty and the particular caption for that will not appear!!</p>');	
			echo '<div class="fs3redAlert editbackground"><!--wrap edit captions-->';
			 
			printer::pclear();//$dataname,$name,$width,$fontsize,$turn_on='',$float='left',$percent=90,$inherit=false,$class=''
			echo '<div class="fsminfo width100 editbackground floatleft left '.$this->column_lev_color.'"> Add Default Title:';
			$this->textarea('default_imagetitle',$data.'_blog_tiny_data4','600',16,'','left',100);
			printer::pclear();
			echo '</div>';
			printer::pclear();
			echo '<div class="fsminfo width100 editbackground floatleft left '.$this->column_lev_color.'"> Add Default Subtitle:';
			$this->textarea('default_subtitle',$this->data.'_blog_tiny_data5','600','16','','left',100);
			printer::pclear();
			echo '</div>';
			printer::pclear();
			echo '<div class="fsminfo width100 editbackground floatleft left '.$this->column_lev_color.'"> Add Default description:';
			$this->textarea('default_description',$this->data.'_blog_data7','600','16','','left',100);
			echo '</div>';
			printer::pclear();
			
			echo '</div><!--wrap edit captions-->';
			echo '</div><!--global captions-->';
			$this->show_close('Default Caption Option');
			printer::pclear();
			}//edit not is clone || is clone data	//if(!$this->clone_local_style&&(empty($gall_ref)||strpos($gall_ref,$this->tablename.'_')===false)){
		
	
	//$background_color=(preg_match(Cfg::Preg_color,$this->{$data.'_blog_data2_arrayed'}[6]))?'background:#'.$this->{$data.'_blog_data2_arrayed'}[6].';':'background:#fff;';
	//$back_color=(preg_match(Cfg::Preg_color,$this->{$data.'_blog_data2_arrayed'}[6]))?$this->{$data.'_blog_data2_arrayed'}[6]:'';
	
	if ($this->master_gallery&&$gall_display==='display_single_row'&&$blog_data2[$galltype_index]!=='center'){  
		$caption_width=(!empty($caption_width))?$caption_width:300;
		$total_width=$caption_width+$smallpicplus+10;
		$maxstyle='style="max-width:'.$total_width.'px;"';
		$this->css.='
		@media screen and (min-width: '.($total_width+1).'px){
			.inlineblock_'.$this->blog_id.'{display:inline-block;}
			 .mainPicInfo_'.$this->blog_id.'{width:'.$caption_width.'px}
			}
		@media screen and (max-width: '.$total_width.'px) and (min-width:'.($smallpicplus+1).'px){
		.inlineblock_'.$this->blog_id.'{display:inline-block ; margin-left:0; margin-right:0;}
		.mainPicInfo_'.$this->blog_id.'{width:'.$caption_width.'px} 
			}
		@media screen and (max-width:'.$smallpicplus.'px){
		.inlineblock_'.$this->blog_id.'{display:block; margin-left:0; margin-right:0;}
		.mainPicInfo_'.$this->blog_id.'{width:auto;}
			}'; 
		}
	else {
		$maxstyle=(!empty($limit_width)&&$limit_width>299)?'style="max-width:'.$limit_width.'px;"':'style="max-width:100%"';
		$this->css.='
			.inlineblock_'.$this->blog_id.'{display:inline-block;}';
		}
	list($border_add_width,$border_add_height)=$this->border_calc($this->blog_tiny_data3);
	list($border_add_width2,$border_add_height)=$this->border_calc($this->blog_style);
	$gallery= new gallery_master();
	$gallery->gall_expand_menu_icon=$gall_expand_menu_icon;
	$gallery->gall_display=$gall_display;
	$gallery->page_width=$this->page_width;
	$gallery->next_gallery=true;// need to configure choice for this
	$gallery->new_page_effect=$new_page_effect;
	$gallery->page_cache_arr=$this->page_cache_arr;
	$gallery->thumb_width_type=$thumb_width_type; 
	$gallery->preview_display=$preview_display;
	$gallery->padleft=$padleft;
	$gallery->gall_topbot_pad=$preview_pad_bottom;//actually  padding for between rows..
	$gallery->show_under_preview=$show_under_preview;
	$gallery->fixed_pad=$fixed_pad;
	$gallery->caption_vertical_align=$caption_vertical_align;
	$gallery->transition=$transition;  
	$gallery->thumbnail_height=$thumbnail_height;
	$gallery->transition_time=500;//hard coding as is optimal time -removing user editing
	$gallery->data=$data;
	$gallery->smallpicplus=$smallpicplus; 
	$gallery->caption_width=$caption_width;
	$gallery->largepicplus=min($largepicplus,$this->current_net_width);
	//$gallery->wpercent=$wpercent;
	//$gallery->gallery_row_width=$gall_width-$border_add_width2;
	$gallery->current_net_width=$this->current_net_width;
	$gallery->border_add_width=$border_add_width;
	$gallery->master_gallery=$this->master_gallery;//whether for master gallery collection or normal gallery
	$gallery->master_gall_ref='';
	$gallery->inc=$inc;
	$gallery->quality_option=$blog_data2[$image_quality_index];
	$gallery->quality=$quality;
	$gallery->image_quality_index=$image_quality_index;
	$gallery->css=$this->roots.Cfg::Style_dir.$this->tablename;
	$gallery->column_lev_color=$this->column_lev_color;
	$gallery->edit=$this->edit;
	$gallery->master_gall_table=$this->master_gall_table; 
	$gallery->gall_ref=$gall_ref;
	$gallery->gall_table=$gallery->tablename=$this->tablename;
	$gallery->blog_id=$this->blog_id;
	$gallery->is_clone=$this->is_clone;
	$gallery->clone_local_style=$this->clone_local_style;
	$gallery->clone_local_data=$this->clone_local_data;
	$gallery->gall_glob_title=$blog_data2[$gall_glob_title_index];
	$gallery->main_menu=$main_menu;
	$gallery->large_images_arr=$this->large_images_arr;
	$gallery->parent_wid=$this->current_net_width;
	$gallery->blog_data2=$this->blog_data2;
	$gallery->blog_order=$this->blog_order;
	$gallery->blog_table=$this->blog_table;
	$gallery->display_float=$display_float;//used for master gallery display single
	$gallery->default_imagetitle=$this->default_imagetitle;
	$gallery->default_subtitle=$this->default_subtitle;
	$gallery->default_description=$this->default_description;
	$gallery->enable_edit= (!$this->is_clone||$this->clone_local_data)?true:false;
	$gallery->clone= ($this->is_clone&&!$this->clone_local_data)?'clone_'.$this->tablename:'';//tablename will give specific page reference of clone otherwise the parent page is used and clone will automatically follow parent page updates without itslef updating!
	$gallery->maxwidth_adjust_expanded=$maxwidth_adjust_expanded;//adjust maxwidt 100 to acount for box shadow
	$gallery->maxwidth_adjust_preview=$maxwidth_adjust_preview;//adjust maxwidt 100 to acount for box shadow
	$gallery->ext=$this->ext;
	###
	echo '<div class="inlineblock_'.$this->blog_id.'" '.$maxstyle.'><!--limiter  on width available for preview images-->';
	$gallery->pre_render_data($gall_ref);
	$gallery->gallery_display();
	$this->large_images_arr=$gallery->large_images_arr;//collecting image informations
	$this->preload=(!empty($this->preload))?$this->preload.','.$gallery->preload:$gallery->preload;//collect one or more gallery preloads
	$this->instruct=array_merge($this->instruct,$gallery->instruct);
	echo '</div><!--limiter on width available for preview images-->';
	print '</div><!--gall holder-->';
	if (!$this->edit){ 
		return;
		}
	$msg=($this->master_gallery)?'Edit general Master Gallery Styles':'Edit General Gallery Styles';
	 $this->edit_styles_close($data,'blog_style','.'.$data.',.highslide-dimming.dimming_gall_img_'.$this->blog_id,'background,padding_top,padding_bottom,padding_left,padding_right,margin_top,margin_bottom,margin_left,margin_right,font_family,font_size,font_weight,text_align,font_color,text_shadow,line_height,letter_spacing,italics_font,small_caps,text_underline,borders,box_shadow,outlines,radius_corner',$msg,true,'Background Styles will also affect the Expanded image Background (in Normal Galleries). Set General Caption Styles Here. Individual Caption Styles for Title Subtitle and Description May be set below');
	if (!$this->master_gallery){
		$this->edit_styles_close($data,'blog_tiny_data3','.preview_border_'.$this->blog_id,'borders,box_shadow,outlines,radius_corner','Style Borders for Preview Images',false); 
		printer::pclear();
		}
	if ($this->clone_local_style||!$this->is_clone){
		$msg=($this->master_gallery)?'Special Styles for Master Gallery':'Styles for Expanded Images and Captions';
		$this->show_more($msg);
		echo '<div class="editcolor editbackground fs2black"><!--features of expand gall images-->';
		 
		 
		}//$this->clone_local_style||$this->tablename==$this->blog_table_base
		$image_border='.gall_img_'.$this->blog_id;
		$msg=($this->master_gallery)?'Image Border Style for Master Gallery':'Style the <b>Image Border</b> of Expanded Images for this Gallery';
		$this->edit_styles_close($data,'blog_tiny_data1',$image_border,'borders,box_shadow,outlines,radius_corner',$msg,false,'',false); 
		printer::pclear(); 
		$imagetitle='.imagetitle_'.$this->blog_id;
		$msg=($this->master_gallery)?'':'Expanded';
		$this->edit_styles_close($data,'blog_data3',$imagetitle,'padding_top,font_family,font_size,font_weight,text_align,font_color,text_shadow,text_underline,italics_font,small_caps,line_height,letter_spacing','Style the <b>TITLE</b> of '.$msg.' Image Captions for this Gallery',false,'',false); 
		
		$subtitle='.subtitle_'.$this->blog_id;
		$this->edit_styles_close($data,'blog_data4',$subtitle,'padding_top,font_family,font_size,font_weight,text_align,font_color,text_shadow,italics_font,small_caps,line_height,letter_spacing,text_underline','Style the <b>SUBTITLE</b> of '.$msg.' Image Captions for this Gallery',false,'',false);
		
		$description='.description_'.$this->blog_id; 
		$this->edit_styles_close($data,'blog_data5',$description,'padding_top,font_family,font_size,font_weight,text_align,font_color,text_shadow,italics_font,small_caps,line_height,letter_spacing,text_underline','Style the <b>DESCRIPTION</b> of '.$msg.' Image Captions for this Gallery',false,'',false);
		
		$mainPicInfo='.mainPicInfo_'.$this->blog_id.',.highslide-caption_'.$this->blog_id; 
		 $this->edit_styles_close($data,'blog_data6',$mainPicInfo,'background,padding_top,padding_bottom,padding_left,padding_right,margin_top,margin_bottom,borders,box_shadow,outlines,radius_corner','Style the <b>BACKGROUND AREA</b> of the '.$msg.' Image Captions for this Gallery',false,'',false); 
	 if ($this->clone_local_style||!$this->is_clone){
		
		echo '</div><!--features of expand gall images-->';
		$this->show_close('features of expand gall images');
		printer::pclear(20);
		}//this clone enabled or tablename = this page table
		/*
}*/
 	if ($this->edit){
#gallcss	
		
		$this->css.=' 
#holder_'.$this->blog_id.'{text-align:center}
.holder{text-align:center}

.'.$data.' .gall_preview_'.$this->blog_id.'{margin-left: auto; margin-right:auto;padding-top:'.$preview_padtop.'px;}
	.gall_img_'.$this->blog_id.' .highslide-controls{width:200px;height:40px;background:url(graphics/'.$controlbar.') 0 -90px no-repeat;margin:20px 15px 10px 0;}
	.gall_img_'.$this->blog_id.' .highslide-controls ul{position:relative;left:15px;height:40px;list-style:none;background:url(graphics/'.$controlbar.') right -90px no-repeat;margin:0;padding:0;}
	.gall_img_'.$this->blog_id.' .highslide-controls a{background-image:url(graphics/'.$controlbar.');display:block;float:left;height:30px;width:30px;outline:none;}
	.'.$data.' .thumbnail_'.$this->blog_id.'{float: left; padding-bottom:'.$thumbnail_pad_bottom.'px; padding-right:'.$thumbnail_pad_right.'px;}
	    ';
	   }
	}//end gallery
#endgall
#slide  #auto
function auto_slide($data,$type){ 
	static $inc=0;  $inc++;
	$min_opac=10;
	$shadowcalc=0;//initialize   where $table_ref='$ttt' AND $id_ref='$id'";
	$options='time,transit,image_quality';
	$options_arr=explode(',',$options);
	foreach($options_arr as $key=>$index){
		${$index.'_index'}=$key;
		}
	switch ($type){
		case 'page':
			$background_slide=true;
			$table=$this->tablename;
			$option_field='page_data2';
			$border_field='';//not used for page
			$style_field='';//not used for page
			$delete='delete_auto_page';
			$dbtable=$this->master_page_table;
			$field_id_val=$this->page_id;
			$pic_field='page_data1';
			$field_id='page_id';
			$sort_id='page'.$this->page_id;
			$image_pos_data_arr=(strlen($this->page_data3)>10)?unserialize($this->page_data3):array();
			break;
		case 'blog' :
			$background_slide=($this->blog_tiny_data1==='background_slide')?true:false;
			$option_field='blog_data2';
			$border_field='blog_data2';//blog_data5
			$style_field='blog_style';//not used for col
			$table=$this->blog_table;
			$field_id_val=$this->blog_id;
			$delete='delete_auto_blog';
			$dbtable=$this->master_post_table;
			$pic_field='blog_data1';
			$field_id='blog_id';
			$sort_id=$this->blog_id; 
			break;
		case 'col' : 
			$background_slide=true;
			$option_field='col_data2';
			$table=$this->col_table;
			$border_field='';//not used for col 
			$style_field='';//not used for col
			$delete='delete_auto_col';
			$dbtable=$this->master_col_table; 
			$pic_field='col_data1';
			$field_id_val=$this->col_id; 
			$field_id='col_id';
			break;
			}
	if ($this->edit&&isset($_POST['submitted'])){
		
		if (isset($_POST[$delete][$field_id_val])){
			$new_arr=array();
			$delete_arr=array();
			$pic_arr=explode(',',$this->$pic_field); 
			foreach($_POST[$delete][$field_id_val] as $arrayed =>  $del_img){ 
					$this->message[]=printer::alert_neg('Removed '.$del_img. ' from slide show',.9,1);
					$delete_arr[]=$del_img;
					 
				}
			foreach ($pic_arr as $image){
				if (!in_array($image,$delete_arr)){
					$new_arr[]=$image;
					}
				}
			$newval=implode(',',$new_arr);
			$q="update $dbtable set $pic_field='$newval' where $field_id='$field_id_val'";
			$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
			}
		}
		 
	
	$this->edit_styles_open();
	($this->edit&&$this->is_blog)&&    
			$this->blog_options($data,$this->blog_table);
	 
	if (empty($this->$pic_field)){  
		if (!$this->edit)return;
		$msg=printer::alert_pos('Upload Your First Slide Show Image!!',1.1,true);
		#$maxwid=$this->column_net_width[$this->column_level];
		}
	$piccount=count(explode(',',$this->$pic_field));
	$quality=(!empty($option_field_arr[$image_quality_index])&&$option_field_arr[$image_quality_index]>9&&$option_field_arr[$image_quality_index]<101)?$option_field_arr[$image_quality_index]:((!empty($this->page_options[$this->page_image_quality_index])&&$this->page_options[$this->page_image_quality_index]<101&&$this->page_options[$this->page_image_quality_index]>9)?$this->page_options[$this->page_image_quality_index]:Cfg::Pic_quality); 
	$time=(!empty($option_field_arr[$time_index])&&$option_field_arr[$time_index]>5&$option_field_arr[$time_index]<15)?$option_field_arr[$time_index]:8;// time between images 
	$transit=(!empty($option_field_arr[$transit_index]))?$option_field_arr[$transit_index]:.9; 
	$wpercent=100;//not used at moment($this->blog_data3>4&&$this->blog_data3<=100)?$this->blog_data3:100;
	if (!empty($this->$pic_field)){
		$arr=explode(',',$this->$pic_field);
		$pic_init=$arr[0];
		$flag=false;
		$empty=false;//if auto file ! exist set to true
		//$preload='slideAuto.preload(';
		$pic_arr=explode(',',$this->$pic_field); 
		$maxh=$maxw=$maxAspect=0;  $minAspect=1;
		foreach($pic_arr as $key=>$image){
			if (!is_file(Cfg_loc::Root_dir.Cfg::Upload_dir.$image)){  
				//unset($pic_arr[$key]);
				$this->message[]='file not found in auto slide '.Cfg_loc::Root_dir.Cfg::Upload_dir.$image ;
				$flag=true;
				}
			list($width,$height)=$this->get_size($image,Cfg_loc::Root_dir.Cfg::Upload_dir);
			$ratio=$width/$height;
			$minAspect=min($ratio,$minAspect); 
			$maxAspect=max($ratio,$maxAspect);
			if ($pic_init===$image)$init_ratio=$ratio;
			}
			 
		 
		}
		if (!empty($this->$pic_field)){// rechecking after unsetting... currently unsetting removed...
	  $this->image_resize_msg='Auto Slideshow';
	  ######FOR POST :  ##############################
	 
		if ($this->edit&&$type!=='page'){
			  list($border_width,$border_height)=$this->border_calc($this->$border_field);//img
			  list($post_pad_width,$post_mar_width)=$this->pad_mar_calc($this->$style_field); //around post
			  $shadowcalc=$this->calc_border_shadow($this->$border_field); 
			  $maxwidth_adjust_shadow_calc=100-$shadowcalc/3;//300 ~ min image width in px conv to %
			  list($pad_width,$mar_width)=$this->pad_mar_calc($this->$border_field);  
			    ($this->edit)&&print('<p id="return_'.$this->blog_id.'">&nbsp;</p>');
			   
			  $bp_arr=$this->page_break_arr;
			  $maxwidth=0;//intitialize width of maximumun maintain width in maintain_width mode
			  if ($type==='col'&&$this->column_primary)$max_pic_size=800;
			  else {//columns slide show is not used presently..   page or blog/post only
				  $column_level= ($type!=='col')?$this->column_level:$this->col_level-1; 
				  if ($this->column_use_grid_array[$column_level]==='use_grid'){ 
					  $max_pic_size=$this->grid_width_chosen_arr['max'.$bp_arr[0]]*$wpercent/100;//likely starter
					  foreach($this->page_break_arr as $bp){
						  $max_pic_size=max($max_pic_size,$this->grid_width_chosen_arr[$bp]*$wpercent/100);//relative percent and size can be bigger with smaller break pt calculation
						  }
				   
					  }//end if rwd enabled
				  else{//rwd not enabled 
					  $max_pic_size=$this->current_net_width*$wpercent/100; 
					  $maxwidth=$max_pic_size;
					   }
				  }//not primary column
			  
			 
			  $best_guess=($max_pic_size>1000)?700:(($max_pic_size>500)?500:$max_pic_size);//best guess used for when viewport not set like first intitial page
			  $gtype=($this->column_use_grid_array[$this->column_level]==='use_grid')?'rwd':'no_rwd';
			  //grid post percent arr   used to determine the percentage width available when grid system is used under the relevant break point given the current width... from this relevant pic width is calculated..
			  //$maxwidth=//could be limited by page_width so we will add that here..
			  $grid_post_percent_arr=($this->column_use_grid_array[$this->column_level]==='use_grid')?$this->grid_width_chosen_arr:'';//array becomes size of pic plugging in viewport
			  (!is_dir(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir))&&mkdir(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir,0755,1);
			  file_put_contents(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'auto_slide_'.$this->passclass_ext.$data,$best_guess.'@@'. $gtype.'@@'.serialize($grid_post_percent_arr).'@@'.$maxwidth);
			  
			  
			  }//not page slide show... and edit mode...
		 else if ($type==='page'){//edit && non-edit
			$shadowcalc=0;
			if (!empty($this->viewport_current_width)&&$this->viewport_current_width>200){
				
				$image_width=$this->viewport_current_width;
				}
			else $image_width=600;//best_guess  will be javascript resized if smaller
			}
		if ($type!=='page'){//whether editmode or not.
			$pic_info_arr=explode('@@',file_get_contents(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'auto_slide_'.$this->passclass_ext.$data));
			list($best_guess,$gtype,$grid_width_chosen_arr,$maxwidth)=$pic_info_arr;
			  $grid_width_chosen_arr=(!empty($grid_width_chosen_arr))?unserialize($grid_width_chosen_arr):'';////array becomes size of pic plugging in viewport
			//$best_guess=check_data::key_up($this->page_cache_arr,$best_guess,'val',$this->page_width);
			   
		   
				
			if (!empty($this->viewport_current_width)&&$this->viewport_current_width>200){
				 //check viewport width not artificially high from zooming out...ie not greater than initial column net_width[0]...
				 
				if ($gtype==='rwd'){  
					list($key,$width_value)=check_data::key_up($grid_width_chosen_arr,$this->viewport_current_width,'keyval');  
					$image_width=min($width_value,$this->viewport_current_width);    //not used *$wpercent/100; 
					}
				else {//non rwd 
					$total_width_available=$this->current_net_width; 
					$total_width_available=min($total_width_available,$this->viewport_current_width);
					$image_width=$total_width_available;
					} 
				}//viewpoint small
			else {
				 $image_width=$best_guess; 
				}
			 }//end if type not = page 
		$image_size=check_data::key_up($this->page_cache_arr,$image_width,'val',$this->page_width);//image size used from image directory 
		$respond_data=' data-wid="'.$image_size.'" '; 
		$image_width_dir=Cfg::Response_dir_prefix.$image_size.'/';
		$this->image_resize_msg=''; 
		$width_available=$image_width-$shadowcalc; 
		list($image_max_width,$padtop)=process_data::max_width($width_available,$init_ratio,$minAspect,$maxAspect);//affects padding used in blog post slideshow with javascript fade in/out choice
		$option_field_arr=explode(',',$this->$option_field);
		for ($i=0; $i<count($options_arr); $i++){
			if (!array_key_exists($i,$option_field_arr)){
				$option_field_arr[$i]=0;
				}
			}
		 
		$picdir=Cfg_loc::Root_dir.Cfg::Auto_slide_dir;
		if ($this->edit){//generate images for all sizes
			################################  begin
			$maxfullwidth=($type==='page')?max($this->page_cache_arr):$this->current_net_width;
			$limiter=($type==='page')?max($this->page_cache_arr):$this->page_width;
			$maxfullwidth=check_data::key_up($this->page_cache_arr,$maxfullwidth,'val',$limiter);  
			$dir=Cfg_loc::Root_dir.Cfg::Auto_slide_dir.Cfg::Response_dir_prefix;
			$this->show_more('Image Quality Info');
			printer::print_wrap('Quality info wrap');
			$page_arr=check_data::return_pages(__METHOD__,__LINE__,__FILE__);
			foreach (explode(',',$this->$pic_field) as $picname){
				$this->auto_slide_arr[]=array('id'=>$this->blog_id,'data'=>$data,'picname'=>$picname,'is_clone'=>$this->is_clone,'clone_local_style'=>$this->clone_local_style,'clone_local_data'=>$this->clone_local_data,'maxwidth'=>$maxfullwidth,'quality'=>$quality,'quality_option'=>$option_field_arr[$image_quality_index]);  
				$parr=array();
				$total=$x=0;
				foreach($this->page_cache_arr as $ext){ 
					(!is_dir($dir.$ext))&&mkdir($dir.$ext,0755,1);
					if ($ext <=$maxfullwidth){ 
						if (!is_file($dir.$ext.'/'.$picname)||isset($_POST[$data.'_'.$option_field][$image_quality_index])){
							(Cfg::Development)&&mail::info('Creating: '.$dir.$ext.'/'.$picname,1);
							image::image_resize($picname,$ext,0,0,Cfg_loc::Root_dir.Cfg::Upload_dir, $dir.$ext,'file',NULL,$quality);
							}
						else {
							$x++;
							$size=process_data::get_size($picname,$dir.$ext.'/');
							$fsize=filesize($dir.$ext.'/'.$picname);
							$area=$size[0]*$size[1];
							$density=round($fsize/$area,3);
							$parr[]=array('dir'=>Cfg::Response_dir_prefix.$ext,'wid'=>$size[0],'height'=>$size[1],'area'=>$area,'Kb'=>round($fsize/1000,1),'density'=>$density);
							$total+=$density;
							}
							
						}//if less than maxfullwidth
					elseif (is_file($dir.$ext.'/'.$picname)&&!Sys::Pass_class){//size cache of this image is unnecessary as maxwidth is less
						foreach($page_arr as $page_ref){ 
							$file='image_info_auto_slide_'.$page_ref;
							if (is_file(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Image_info_dir.$file)){
								$array=unserialize(file_get_contents(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Image_info_dir.$file)); 
								foreach ($array as $index => $arr){
									if (!array_key_exists('maxwidth',$arr))continue;
									if ($arr['id']==$this->blog_id){
										if ($arr['maxwidth']>=$ext){
											$flag=false;
											break;
											}
										} 
									}//foreach
								}//else is file
							}//foreach page
						if ($flag){	
							unlink($dir.$ext.'/'.$picname); //save disk space
							(Cfg::Development)&&mail::info($dir.$ext.'/'.$picname. ' was unlinked');
							}
						}// else if is_file
					 
					}//end foreach ext
				if ($x >0){
					printer::print_wrap('image info quality','editbackground floatleft left fsmnavy Od3green '.$this->column_lev_color);
					printer::horiz_print($parr); 
					$avgdensity=round($total/$x,3);
					$filesize=filesize(Cfg_loc::Root_dir.Cfg::Upload_dir.$picname)/1000;
					$size=process_data::get_size($picname,Cfg_loc::Root_dir.Cfg::Upload_dir);
					$width=$size[0];
					$height=$size[1];
					$density=round($filesize*1000/($size[0]*$size[1]),3);
					$filesize=round($filesize,1);
					$msg="<span class=\"navy whitebackground\">$picname </span><br>avg. pixel/area density: $avgdensity<br>
					@ Quality: $quality <br>
					Uploaded Master Img in uploads/:<br>
					filesize: $filesize Kb<br>
					width: {$width}px<br>
					height: {$height}px <br>
					density: $density ";
					echo $msg;
					printer::close_print_wrap('image info quality');
				}//x > 0
				}//foreach picname
			
			printer::close_print_wrap('Quality info wrap');	
			$this->show_close('Image Quality Info');
			############################### end
			}//if edit
			
			
		if (!$this->edit){
			$maxfullwidth=($type==='page')?max($this->page_cache_arr):$this->current_net_width;
			$limiter=($type==='page')?max($this->page_cache_arr):$this->page_width;
			$maxfullwidth=check_data::key_up($this->page_cache_arr,$maxfullwidth,'val',$limiter);   			$dir=Cfg_loc::Root_dir.Cfg::Auto_slide_dir.Cfg::Response_dir_prefix;
			$extarr=$this->page_cache_arr; 
			foreach (explode(',',$this->$pic_field) as $picname){
				foreach($extarr as $ext){  
					if ($ext <= $maxfullwidth){ //echo NL.$dir.$ext.'/'.$picname . ' is curr dir';
						if (!is_file($dir.$ext.'/'.$picname)){ 
							image::image_resize($picname,$ext,0,0,Cfg_loc::Root_dir.Cfg::Upload_dir, $dir.$ext,'file',NULL,$quality);
							mail::alert("resizing image in Non Editpages $dir $ext / $picname");
							}
						}
					}//foreach
				}//foreach
			}//! edit
		if (!is_file($picdir.$image_width_dir.$pic_init)){//  
		    if (Sys::Pass_class){
			    $pic_init='default_pass.jpg';
			    $alt='';
			    $fullpicdir=Cfg_loc::Root_dir;
			    }
		    else {
			    if(!is_file(Cfg_loc::Root_dir.Cfg::Upload_dir.$pic_init)){
					$msg='Missing main master Image File uploads/'.$pic_init;
					mail::alert($msg);
					return;
					}
			    else {
					image::image_resize($pic_init,$image_size,0,0,Cfg_loc::Root_dir.Cfg::Upload_dir, $picdir.$image_width_dir,'file',NULL,$quality);//happens on non editpages...
					mail::alert('non edit auto_slide resize for '.$picdir.$image_width_dir);
					}
			    $fullpicdir=$picdir.$image_width_dir;
			    
			    }
		    }
		else $fullpicdir=$picdir.$image_width_dir; 
		//speed of transition
			//Set currentPicLink to piccount -1 in order to replace init_pic immediately with javascript version
			#displayauto
		if ($this->edit)$this->show_more('View Slideshow','','','','full');
		if (!$background_slide){
				echo'<div id="auto_slide_'.$inc.'" style="text-align:center;margin-left: auto; margin-right:auto;  max-width:'.$width_available.'px;"   class="auto_slide">
				<p id="autoImgContain'.$inc.'" class="center marginauto imagerespond imagewrap " '.$respond_data.'style="max-width:'.$image_max_width.'px;"> 
				<img id="thePhoto'.$inc.'" class="thePhoto'.$inc.' auto_img_'.$inc.'" style="width:100%; text-align: center;margin-top:'.$padtop.'%;margin-bottom:'.$padtop.'%;" src="'.$fullpicdir.$pic_init.'"  alt="Auto Slide Show"></p>  </div>
				<script >
				var myslide_'.$inc.' = Object.create(slideAuto); 
				myslide_'.$inc.'.maxWidth='.$maxwidth.';
				//myslide_'.$inc.'.widMaxPercent='.$wpercent.';
				myslide_'.$inc.'.shadowcalc='.$shadowcalc.';
				myslide_'.$inc.'.currentPicLink='.($piccount-1).'; 
				myslide_'.$inc.'.pic_order = 0; 
				myslide_'.$inc.'.imgId=\'thePhoto'.$inc.'\';
				myslide_'.$inc.'.autoImgContain=\'autoImgContain'.$inc.'\';
				myslide_'.$inc.'.divId=\'auto_slide_'.$inc.'\';
				myslide_'.$inc.'.minAspect='.$minAspect.';
				myslide_'.$inc.'.maxAspect='.$maxAspect.';
				myslide_'.$inc.'.minOpac='.$min_opac.'; 
				myslide_'.$inc.'.picClass=\'auto_img_'.$inc.'\';
				myslide_'.$inc.'.duration='.($transit*1000).'
				myslide_'.$inc.'.time='.($time*1000).';
				myslide_'.$inc.'.dir=\''.Cfg_loc::Root_dir.Cfg::Auto_slide_dir.'\'; 
				myslide_'.$inc.'.slideAuto_init("'.$this->blog_data1.'");
				</script>';
			}// if blog and not background slide
		elseif ($type==='blog'){#autolist li element background slide
			$height=$image_width/$minAspect;  
			echo '
				 <ul style="height:'.$height.'px" data-asp="'.$minAspect.'" data-wid="'.$image_width.'" class="imagerespond limit backauto '.$type.'-slideshow-'.$field_id_val.'">';
				
			for ($i=0; $i<$piccount; $i++){
				echo '			
				<li><span style="background-image: url('.$fullpicdir.$pic_arr[$i].');">Image '.$pic_arr[$i].'</span><div><h3> </h3></div></li>';
				}
			echo '</ul>';
			}
		elseif ($type==='page'){#autolist li element background slide
			#displaypage
			#get background position x and y adjustment from $image_pos_data_arr;
			
			$height=$image_width/$minAspect;  
			echo '
				 <ul class="backauto '.$type.'-slideshow-'.$field_id_val.'" data-asp="'.$minAspect.'" data-wid="'.$image_width.'">'; 
			for ($i=0; $i<$piccount; $i++){
				$image=$pic_arr[$i];
				$image_mod=(strlen($image)<16)?$image:substr($image,-15);
				$current_posx=(array_key_exists($image_mod,$image_pos_data_arr)&&array_key_exists(0,$image_pos_data_arr[$image_mod]))?$image_pos_data_arr[$image_mod][0]:50;
				$current_posy=(array_key_exists($image_mod,$image_pos_data_arr)&&array_key_exists(1,$image_pos_data_arr[$image_mod]))?$image_pos_data_arr[$image_mod][1]:50;
				
				echo '			
				<li><span style="background-position-x:'.$current_posx.'%;background-position-y:'.$current_posy.'%;background-image: url('.$fullpicdir.$pic_arr[$i].');">Image '.$pic_arr[$i].'</span><div><h3> </h3></div></li>';
				}
			echo '</ul>';
			}
		if ($this->edit)$this->show_close('View Slideshow');
		if  (!$this->edit)return; 
		if (!$this->is_clone){
			$this->show_more('Rearrange or Remove Slide Images','','','',900); 
			echo '
			<div style="background:#'.$this->editor_background.'; color:#555; text-align:left; width:1000px; float:left;   border:3px solid #'.$this->redAlert.';  padding: 10px 30px 60px 30px;" ><!--Sorting-->
			
			<p id="updateMsg_'.$inc.'" class="pos larger editbackground left"></p> 
			<p class="fsminfo editbackground editcolor floatleft left">Drag Image To ReOrder Slide Show. <br> <span class="neg">Check box to delete images.</span></p>';
			printer::pclear();
			echo'<ul id="sort_'.$inc.'" data-id="'.$sort_id.'" data-inc="'.$inc.'" class="nolist sortSlide" >';//#sort
			$x=0;
			foreach ($pic_arr as $image){
				printer::printx('<li class="floatleft  fs1npinfo" id="autosort!@!'.$image.'!@!'.$x.'"><input type="checkbox" name="'.$delete.'['.$field_id_val.'][]" value="'.$image.'"><img src="'.Cfg_loc::Root_dir.Cfg::Auto_slide_dir.Cfg::Image100_dir.$image.'" height="75" alt="image rearrange"></li>');
				$x++;
				}
			echo '</ul>';
			 
			echo '</div><!--Sorting-->';
			printer::pclear(10);	
			
			$this->show_close('Rearrange or Remove Slide Images');
			if ($type==='page') {// is page
				
				$this->show_more('Individually Adjust Image Positioning','','','',900); 
				echo '<div class="fsminfo editbackground editcolor floatleft"><!--wrap slide image pos adjust-->';
				$length=15;//long filenames are shortened to last 15 characters
				printer::printx('<p class="floatleft  tip">Optimize you slideshow positioning to show most important part of image on all screen orientations.   The Viewers screens may be horizontally or Vertically (mobile) oriented and images may have longer widths or heights. This slideshow covers the screen entirely so for example on  16:9 width to height desktop display of a vertically oriented will crop the centered top and bottom evenly by default   whereas the full width will appear regardless of how your horizontally positioning is set! So if the better part of the image is near the top  third you would choose a 33% vertical adjustment for that image. Similarly adjust for the prime horizontal portion if not centered for situations where horizontal cropping occurs</p>');
				printer::pclear();
				$update_slide=false;
				foreach ($pic_arr as $image){
					$image_mod=(strlen($image)<16)?$image:substr($image,-15);
					if ($this->edit&&isset($_POST['submit'])&&isset($_POST['pageslide'][$image_mod])){
						if (isset($_POST['pageslide'][$image_mod][0])){
							if (!isset($image_pos_data_arr[$image_mod])) 
							$image_pos_data_arr[$image_mod]=array(); 

							$image_pos_data_arr[$image_mod][0]=$_POST['pageslide'][$image_mod][0];
							}//! is array
						if (isset($_POST['pageslide'][$image_mod][1])){
							if (!isset($image_pos_data_arr[$image_mod])) 
							$image_pos_data_arr[$image_mod]=array(); 

							$image_pos_data_arr[$image_mod][1]=$_POST['pageslide'][$image_mod][1];
							}//! is array
							 
						$update_slide=true;
						}//if post submitted and image_mod submitted
					$current_posx=(array_key_exists($image_mod,$image_pos_data_arr)&&array_key_exists(0,$image_pos_data_arr[$image_mod]))?$image_pos_data_arr[$image_mod][0]:50;
					$current_posy=(array_key_exists($image_mod,$image_pos_data_arr)&&array_key_exists(1,$image_pos_data_arr[$image_mod]))?$image_pos_data_arr[$image_mod][1]:50;
						
					echo '<div class="fsminfo floatleft">';
					
					printer::printx('<p class="floatleft  fs1npinfo"> <img src="'.Cfg_loc::Root_dir.Cfg::Auto_slide_dir.Cfg::Image100_dir.$image.'" height="75" alt="image rearrange"></p>');
					printer::pclear();
					printer::printx('<p class="floatleft editcolor editbackground fs1npinfo">Adjust Image Horizontally</p>');
					$this->mod_spacing('pageslide['.$image_mod.'][0]',$current_posx,0,100,1,'%');
					printer::pclear();
					printer::printx('<p class="floatleft editcolor editbackground fs1npinfo">Adjust Image Vertically</p>');
					$this->mod_spacing('pageslide['.$image_mod.'][1]',$current_posy,0,100,1,'%');
					echo '</div>';
					
					}//foreach
				if ($update_slide){
					$q="update $this->master_page_table set page_data3='".serialize($image_pos_data_arr)."',page_update='".date("dMY-H-i-s")."', page_time=".time().",token='".mt_rand(1,mt_getrandmax()). "' where page_id=$this->page_id";
				 
					$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
					if ($this->mysqlinst->affected_rows())
						$this->success[]="Updated Auto Page Slide Show Positioning";
					else
						$this->message[]="No affected Rows result to update of Auto Page Slide Show";
					}//update slide
				echo '</div><!--wrap slide image pos adjust-->';
				$this->show_close('Individually Adjust Image Positioning');
				}	
			}//$this->blog_table_base==$this->tablename
		}//!empty blog_data1
	else {
		//$width_available=($this->current_net_width*$wpercent/100);
		$time=8;
		$transit=.8;
		$sizes='';//$this->get_size_string($pic_init, Cfg_loc::Root_dir.Cfg::Auto_slide_dir);  
		
		}
	printer::pclear();
	if (!$this->edit)return;
	if ($this->clone_local_style||!$this->is_clone){ 
		$this->show_more('Configure Your Slide Show','','','',600);
		echo '<div class="fsminfo editbackground '.$this->column_lev_color.' left floatleft"><!--Configure slide show-->';
		if ($type==='blog'){
			$checked1=$checked2='';
			if($background_slide)$checked2='checked="checked"'; 
			else $checked1='checked="checked"';
			echo '<div class="fsminfo editbackground '.$this->column_lev_color.' left floatleft">Choose Your SlideShow type. ';
			printer::alertx('<p class="info" title="Javascript fade in/out accomodates various image shapes"><input type="radio" value="1" name="'.$data.'_blog_tiny_data1" '.$checked1.'>Javascript Slide Show with Simple Fade In/Out-Shows full Images when using various images having different shapes</p>');
			printer::pclear();
			printer::alertx('<p class="info" title="Background Slider with CSS smooth Cross Fade Transition. Best if Images have same shape (aspect ration)"><input type="radio" value="background_slide" name="'.$data.'_blog_tiny_data1" '.$checked2.'>CSS slide with cross fade.  Best if images have similar aspect ratio (shape).</p>'); 
			echo '</div><!--Choose Your SlideShow type-->';
			}
		
		elseif ($type==='page'){  
			printer::pclear();
			echo '<div class="fsminfo editbackground floatleft"><!--Edit autoslide Switch time-->';  
			echo '<p class="'.$this->column_lev_color.' editfont ">Adjust Speed of Fade-In/Fade-out Effect:</p>';
			 $this->mod_spacing($data.'_'.$option_field.'[$transit_index]',$transit,.2,1.4,.1,'secs');
			echo '</div><!--Edit autoslide Switch time-->'; 
			}
		printer::pclear(); 
		 
		$background_graphic=(false)?'background: transparent url(../graphics/slidepattern.png) repeat;':''; 
		echo '<div class="fsminfo editbackground floatleft"><!--Edit autoslide Switch time-->';  
			echo '<p class="'.$this->column_lev_color.' editfont ">Customize Time between Photo Changes:</p>';
			 $this->mod_spacing($data.'_'.$option_field.'[$time_index]',$time,6,14,1,'secs');
		echo '</div><!--Edit autoslide Switch time-->';
		printer::pclear();
		echo'<div class="floatleft editbackground fsminfo info" title="By Default Uploaded Slide Show Images will have a Default Quality factor  with 100 being the highest and 10 the lowest. The higher the image quality the larger the filesize and the slower the download speed. Its also possble change the Default value  in the Page Configuration options which will effect all uploaded images on the site that are not specifically configured for this value in the post type: image, slideshow, or gallery configurations"  ><!--quality image-->Change Current Image Quality setting:';
	$this->mod_spacing($data.'_'.$option_field.'['.$image_quality_index.']',$quality,10,100,1,'%');
	printer::print_info('Images will auto reload @ new Quality setting');
	echo'</div><!--quality image-->';
		printer::pclear();
		echo '</div><!--Configure slide show-->';
		$this->show_close('Configure Your Slide Show'); 
	}//if ($this->clone_local_style||$this->tablename==$this->blog_table_base){
	 	 
	
	if (!$this->is_clone){
		printer::print_wrap('upload slide image','editbackground Os3salmon fsminfo');
		printer::alert('Click here for the Image Uploader to add a new photo to the Automatic Slideshow.','',$this->column_lev_color.' left floatleft  ');
	$width_available=(isset($width_available))?$width_available:600;//width available may not be set yet  as with page type
		printer::printx('<p class="navy underline"><a href="add_page_pic.php?www='.$width_available.'&amp;ttt='.$table.'&amp;fff='.$pic_field.'&amp;id='.$field_id_val.'&amp;id_ref='.$field_id.'&amp;bbb=auto_slide&amp;pgtbn='.$this->tablename.'&amp;quality='.$quality.'&amp;postreturn='.Sys::Self.'&amp;append=append&amp;css='.$this->roots.Cfg::Style_dir.$this->tablename.'&amp;no_image_resize&amp;sess_override&amp;sess_token='.$this->sess->sess_token.'">Upload A New SlideShow Image</a></p>');
		printer::close_print_wrap('upload slide image');
		}
		
	if ($type!=='page'){
		
	$this->edit_styles_close($data,'blog_data4','.thePhoto'.$inc.''.$inc,'borders,box_shadow','Style Slide Image Border',false);
	
	 $this->edit_styles_close($data,$style_field,'.'.$data,'background,padding_top,padding_bottom,padding_left,padding_right,margin_top,margin_bottom,margin_left,margin_right,borders,box_shadow,outlines,radius_corner','Edit Auto General Post Styles',true);
	 }
	
if ($background_slide){ 
	$total_duration=$time*$piccount; 
	switch($type){
		case 'blog' :
			$limit='position:relative;margin:0 auto;';
			$position='absolute';
			break;
		case 'page':
			$limit='width:100%';
			$position='fixed';
			break;
		default :
			mail::alert('auto slide show type not specified');
		}
	$background_graphic=(false)?'background: transparent url(../graphics/slidepattern.png) repeat;':''; 
				
	$this->css.= '
	.limit{'.$limit.'}	
		.'.$type.'-slideshow-'.$field_id_val.',
.'.$type.'-slideshow-'.$field_id_val.':after { 
    position: '.$position.';
    width: 100%;
    height: 100%;
    top: 0px;
    left: 0px;
    z-index: -1; 
}

.limit {'.$limit.'}
.'.$type.'-slideshow-'.$field_id_val.':after { 
    content: \'\';
    '.$background_graphic.'
     
}
.'.$type.'-slideshow-'.$field_id_val.' li span { 
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0px;
    left: 0px;
    color: transparent;
    background-size: cover;
    background-position: 50% 50%;
    background-repeat: no-repeat;
    opacity: 0;
    z-index: 0;
	-webkit-backface-visibility: hidden;
    -webkit-animation: imageAnimation '.$total_duration.'s linear infinite 0s;
    -moz-animation: imageAnimation '.$total_duration.'s linear infinite 0s;
    -o-animation: imageAnimation '.$total_duration.'s linear infinite 0s;
    -ms-animation: imageAnimation '.$total_duration.'s linear infinite 0s;
    animation: imageAnimation '.$total_duration.'s linear infinite 0s; 
}
.'.$type.'-slideshow-'.$field_id_val.' li:nth-child(1) span { 
     
    }';


for ($i=1; $i<$piccount; $i++){ 
     $this->css.='
.'.$type.'-slideshow-'.$field_id_val.' li:nth-child('.($i+1).') span { 
    -webkit-animation-delay: '.($i*$time).'s;
    -moz-animation-delay: '.($i*$time).'s;
    -o-animation-delay: '.($i*$time).'s;
    -ms-animation-delay: '.($i*$time).'s;
    animation-delay: '.($i*$time).'s; 
}';
	}//end for
$ease_in_out=2.75 /$total_duration*100;//2.75 refers to secs of transiton
$beg_ease_out=$time /$total_duration *100 ;//basically the setting of time intervals - one ease_in_out because the easing in and easing out overlap
$full_again=$beg_ease_out+$ease_in_out;//basically addding in time of another ease in out transtion

/* Animation for the slideshow images */
$this->css.= '
@-webkit-keyframes imageAnimation { 
    0% { opacity: 0;
    -webkit-animation-timing-function: ease-in; }
    '.$ease_in_out.'% { opacity: 1;
         -webkit-animation-timing-function: ease-out; }
    '.$beg_ease_out.'% { opacity: 1 }
    '.$full_again.'% { opacity: 0 }
    100% { opacity: 0 }
}
@-moz-keyframes imageAnimation { 
    0% { opacity: 0;
    -moz-animation-timing-function: ease-in; }
    '.$ease_in_out.'% { opacity: 1;
         -moz-animation-timing-function: ease-out; }
    '.$beg_ease_out.'% { opacity: 1 }
    '.$full_again.'% { opacity: 0 }
    100% { opacity: 0 }
}
@-o-keyframes imageAnimation { 
    0% { opacity: 0;
    -o-animation-timing-function: ease-in; }
    '.$ease_in_out.'% { opacity: 1;
         -o-animation-timing-function: ease-out; }
    '.$beg_ease_out.'% { opacity: 1 }
    '.$full_again.'% { opacity: 0 }
    100% { opacity: 0 }
}
@-ms-keyframes imageAnimation { 
    0% { opacity: 0;
    -ms-animation-timing-function: ease-in; }
    '.$ease_in_out.'% { opacity: 1;
         -ms-animation-timing-function: ease-out; }
    '.$beg_ease_out.'% { opacity: 1 }
    '.$full_again.'% { opacity: 0 }
    100% { opacity: 0 }
}
@keyframes imageAnimation { 
    0% { opacity: 0;
    animation-timing-function: ease-in; }
    '.$ease_in_out.'% { opacity: 1;
         animation-timing-function: ease-out; }
    '.$beg_ease_out.'% { opacity: 1 }
    '.$full_again.'% { opacity: 0 }
    100% { opacity: 0 }
		}';
	}//if background_slide
	 
	}// end auto slide 1

 
	
#social	
function social_icons($data,$style_list='',$global=false,$mod_msg="Edit styling",$blog=false,$tablename=''){ 
	$colorname='lightestblue,lavendor,lightlightblue,lightblue,ekaqua,electricblue,ekblue,blue2,trueblue,darkerblue,navyblue,lighterred,lightred,ekredorange,red,maroon,orange,brilliantpinkpurple,ekmagenta,purple,ekdarkpurple,electricgreen,lime,lightgreen,green,forest,olive,yellow,gold,lightbrown,brown,white,black';
	$colorname_arr=explode(',',$colorname);
	$corecolor=(preg_match(Cfg::Preg_color,$this->blog_data5))?' style="background:#'.$this->blog_data5.';"':'';
	$icon_arr=array('facebook','linkedin','pinterest','rss','email','twitter','youtube','myspace','google','instagram');
	$range1=10;
	$range2=150;
	$unit='px'; 
	$increment=2;
	$num=0;
	$wid_size=75;
	$default_icon_size=50;
	
 
	if (isset($_POST[$data.'_socialdata'])){
          $social_arr=$_POST[$data.'_socialdata'];
          if (!empty(trim($this->blog_data1))){   
               $old_arr=unserialize($this->blog_data1);   
			$max_key_social = max(array_keys($social_arr));
			$max_key_old = max(array_keys($old_arr));
			$max_key=max($max_key_social,$max_key_old);
			
			for ($i=0;$i<=$max_key;$i++){ // here we replace any values for for newly edited with old edited..   array still imcomplete
				if (array_key_exists($i,$social_arr)&&is_array($social_arr[$i])){
					for ($x=0; $x<4; $x++){
						if(!array_key_exists($x,$social_arr[$i])&&array_key_exists($i,$old_arr)&&array_key_exists($x,$old_arr[$i])){
							$social_arr[$i][$x]=$old_arr[$i][$x];
							} 
						}
					}
				else $social_arr[$i]=$old_arr[$i];
				}
			}
			
		 
			
		$max_key = max(array_keys($social_arr));
		for ($i=0;$i<=$max_key;$i++){ // here we check for new array deletes
			if (array_key_exists($i,$social_arr)&&is_array($social_arr[$i])){
				if(!array_key_exists(0,$social_arr[$i])||strpos($social_arr[$i][0],'delete')!==false||trim($social_arr[$i][0])=='none'){
					(strpos($social_arr[$i][0],'delete')!==false)&&printer::alert_pos($social_arr[$i][0]); 
					array_splice($social_arr,$i, 1); 
					} 
				}
			}  
		$max_key = max(array_keys($social_arr));
		for ($i=0;$i<=$max_key;$i++){#make sure array implode has 0 put in
			if (!array_key_exists(0,$social_arr[$i])||!array_key_exists(1,$social_arr[$i])||!is_file(Cfg_loc::Root_dir.Cfg::Social_dir.$social_arr[$i][0].'/'.$social_arr[$i][1].'.gif')){
				$msg='For New Social Icons You must also select the icon  color and this entry has been deleted';
				$this->message[]=$msg; 
				array_splice($social_arr,$i, 1);
				}
			}
			
		$q="update $this->master_post_table set blog_time=".time().",token='".mt_rand(1,mt_getrandmax()). "',blog_data1='".serialize($social_arr)."' where blog_table='$this->blog_table' and blog_order=$this->blog_order"; 
		$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
		$msg="Your Icon has been Added";
		$this->success[]=$msg;
		$socialdata=$social_arr;
		}//is post social
	else if(!empty($this->blog_data1)) $socialdata=unserialize($this->blog_data1);  
	else $socialdata='';   
	$element=($this->blog_data2=='vertical')?'p':'span';
	$style=($this->blog_data2=='vertical')?' padding-top:':' padding-left:';
	$style=(is_numeric($this->blog_data3)&&$this->blog_data3>0)?' style="'.$style.$this->blog_data3.'px;"':' style="'.$style.'0px;"';
	
	$this->edit_styles_open();
	($this->edit)&&    
			$this->blog_options($data,$this->blog_table);
	if (is_array($socialdata)){
		foreach ($socialdata as $choices){
		if (!array_key_exists(2,$choices))$choices[2]=$default_icon_size;//default size value
		if (!array_key_exists(3,$choices))$choices[3]='http://www.put_your_site_here.com';// 
			$shape_dir=(!empty($this->blog_data4)&&is_dir(Cfg_loc::Root_dir.Cfg::Social_dir.$choices[0].'/'.$this->blog_data4))?$this->blog_data4.'/':'';
			echo '<'.$element.$style.'><a href="'.$choices[3].'"   style="text-decoration: none"> <img '.$corecolor.' src="'.Cfg_loc::Root_dir.Cfg::Social_dir.$choices[0].'/'.$shape_dir.$choices[1].'.gif" width="'.$choices[2].'" height="'.$choices[2].'" alt="'.$choices[0].' Social Icon Link"></a></'.$element.'>';
			}
		}//is array socialdata
	printer::pclear(3);
	if (!$this->edit)return;
	if(!$this->is_clone&&is_array($socialdata)&& !arrayhandler::is_empty_array($socialdata)){ 
		$this->show_more('Edit/Delete Previous Icon Choices','noback','','',400);
		 foreach ($socialdata as $choices){
			if (!array_key_exists(2,$choices))$choices[2]=$default_icon_size;//default size value
		if (!array_key_exists(3,$choices))$choices[3]='http://www.put_your_site_here.com';// 
		echo '<div class="fs2black editbackground maxwidth400 "><!--edit prev icon choice-->';
		//echo'<p><input type="hidden" name="'.$data.'_socialdata['.$num.'][0]" value="'.$choices[0].'"></p>';
		 
		 echo'<p class="'.$this->column_lev_color.' floatleft editbackground editfont">Edit: <img '.$corecolor.' src="'.Cfg_loc::Root_dir.Cfg::Social_dir.$choices[0].'/'.$choices[1].'.gif" width="'.$choices[2].'" height="'.$choices[2].'" alt="mychoice icon" ></p>';
		printer::pclear(5); 
		echo '<p class="'.$this->column_lev_color.' floatleft editfont"><input type="checkbox"  name="'.$data.'_socialdata['.$num.'][0]." value="'.$choices[0].' is deleted" >Check Here to Delete this icon</p>'; 
		printer::pclear(5);  
		$this->show_more('Change your icon color','noback','','',600);
		for ($i=0;$i<count($colorname_arr);$i++){
			$select=($colorname_arr[$i]==$choices[1])?' checked="checked" ' :'';
			 echo '<p class="editbackground floatleft left"><input type="radio" name="'.$data.'_socialdata['.$num.'][1]." '.$select.' value="'.$colorname_arr[$i].'"><img '.$corecolor.' src="'.Cfg_loc::Root_dir.Cfg::Social_dir.'facebook/'.$colorname_arr[$i].'.gif" width="'.$wid_size.'" height="'.$wid_size.'" alt="dropdown choices menu '.$colorname_arr[$i].'" ></p>';
			}//end for loop colors
			printer::pclear();
		$this->show_close('color');//<!--show more color-->p class="'.$this->column_lev_color.' editfont">Change Your Image size</p> ';
		printer::pclear(8); 
		$size=(array_key_exists(2,$choices)&&!empty($choices[2]))?$choices[2]:$default_icon_size;
		echo '<div class="fsminfo fs1color"><!--icon size-->';
		  printer::alertx('<p class="editbackground '.$this->column_lev_color.' rad3 floatleft">Change the size of your Social Icon: </p>');
		
		echo '
		<p class="'.$this->column_lev_color.'   editfont left">Currently: '.$size.$unit.'<br>
		 
		Choose:    
		<select class="editcolor editbackground"  name="'.$data.'_socialdata['.$num.'][2]">        
		<option  value="'.$size.'" selected="selected">'.$size.'</option>';
		for ($i=$range1; $i<=$range2; $i+=$increment){
		   echo '<option  value="'.$i.'">'.$i.$unit.'</option>';
		   }
		echo'	
		</select> </p><!--Change Icon Size-->'; 
		echo '</div><!--Change Icon Size-->';
		printer::pclear(8);
		$value3=(array_key_exists(3,$choices))&&!empty($choices[3])?$choices[3]:'http://';
		echo '<div class="fsminfo"><!--edit social url choice-->';
		 
		echo '
		<p class="'.$this->column_lev_color.' editbackground editfont">Change Your Icon Url&nbsp;<br><input style="cursor:pointer;background:#'.$this->editor_background.';color:#'.$this->editor_color.';" type="text" name="'.$data.'_socialdata['.$num.'][3]" value="'.$value3.'" maxlength="150"></p>';
		
		echo '</div><!--edit social url choice-->';
		printer::pclear(8); 
		$num++;
		echo '</div><!--edit prev icon choice-->';
		printer::pclear(12); 
		}//end foreach edit previous
		$this->show_close('Previous Icon Choices');//<!--Show More Edit Previous Icon Choices--> 
	
		printer::pclear(8); 
		}//if not empty social data
		
		 
	if (!$this->is_clone){
		$this->show_more('Add a new Social Icon','noback','','',600);
		echo '<div class="fs2black  editbackground floatleft"><!--Add new-->';
		  //echo'<p><input type="hidden" name="'.$data.'_socialdata['.$num.'][0]" value="none"></p>';
		 
		echo '
		<p class="left '.$this->column_lev_color.'   editbackground editfont">Choose Your Link  Color Size and URl Here</p>';
		echo '<div class="fsminfo editbackground '.$this->column_lev_color.' " ><!--link type-->Pick a link type:';
		printer::pclear(5);
		foreach ($icon_arr as $icon){
		   echo '<p class="floatleft left"><input  type="radio" name="'.$data.'_socialdata['.$num.'][0]"  value="'.$icon.'"><img src="'.Cfg_loc::Root_dir.Cfg::Social_dir.$icon.'/trueblue.gif" width="'.$wid_size.'" height="'.$wid_size.'" alt="dropdown choices menu  '.$icon.'" > </p>';
		   }
	    printer::pclear();
		echo '</div><!--link type-->';
		printer::pclear(5);
		echo '<div class="fsminfo editbackground " ><!--link color--><br>';
		echo '<p class="'.$this->column_lev_color.' editbackground editfont">Choose Your Color: </p>';
		printer::pclear(5);
		for ($i=0;$i<count($colorname_arr);$i++){
			 echo  '<p class="floatleft left" ><input type="radio" name="'.$data.'_socialdata['.$num.'][1]." value="'.$colorname_arr[$i].'"><img src="'.Cfg_loc::Root_dir.Cfg::Social_dir.'facebook/'.$colorname_arr[$i].'.gif" width="'.$wid_size.'" height="'.$wid_size.'"   alt="dropdown choices menu '.$colorname_arr[$i].'"></p>';
			}//end for loop colors
		
	    printer::pclear();
		echo '</div><!--link color-->'; 
		 
		printer::pclear(8);
		echo'<div class="fsminfo editbackground floatleft"><!--choose size-->';
		 echo '<p class="'.$this->column_lev_color.'  left">Choose Your Icon Size:<br>
		
	    Choose:    
	    <select class="editcolor editbackground"  name="'.$data.'_socialdata['.$num.'][2]">        
	    <option  value="'.$default_icon_size.'" selected="selected">'.$default_icon_size.'px</option>';
	    for ($i=$range1; $i<=$range2; $i+=$increment){
		   echo '<option  value="'.$i.'">'.$i.$unit.'</option>';
		   }
		echo'	
	    </select>  </p>';
	    echo '</div><!--choose size-->'; 
		printer::pclear(8);
		echo '<div class="fsminfo editbackground "><!--Add URl-->';
		  echo '<p class="'.$this->column_lev_color.' editbackground editfont">Add Your New Icon Url&nbsp;<input style="cursor:pointer;background:#'.$this->editor_background.';color:#'.$this->editor_color.';" type="text" name="'.$data.'_socialdata['.$num.'][3]" value="http://" maxlength="100"></p>';
		echo '</div><!--Add URl-->'; 
		 
		echo '</div><!--Add new-->';
		$this->show_close('Add New Icon Choices');//<!--Show More Edit Add New Icon Choices--> 
		}  
	if ($this->clone_local_style||!$this->is_clone){ 
		printer::pclear(8);
		$msg='Edit Your Icon Shape/Icon Core Color/Horiz-Vert/Spacing';
		$this->show_more($msg,'noback','','',400);//<!--shape vert spacing-->
		echo '<div class="editbackground maxwidth400 fs1color"><!--Edit Icon Shape spacing-->';
		echo '<div class=" width300  fsminfo editbackground"><!--Edit Icon Shape-->';
		$checked1=($this->blog_data4!=='round')?'checked="checked"':'';
		$checked2=($this->blog_data4=='round')?'checked="checked"':'';
		echo '<p class="'.$this->column_lev_color.' editbackground editfont">Edit Which Icon Shape to Use:</p>';
		echo '<p><input type="radio" name="'.$data.'_blog_data4" value="square" '.$checked1.'>Square</p>';
		echo '<p><input type="radio" name="'.$data.'_blog_data4" value="round" '.$checked2.'>Round</p>'; 
		echo '</div><!--Edit Icon Shape-->';
		
		echo '<div class="fsminfo editbackground"><!--Edit Icon Vert Horiz-->';
		$checked1=($this->blog_data2!=='vertical')?'checked="checked"':'';
		$checked2=($this->blog_data2=='vertical')?'checked="checked"':'';
		echo '<p class="'.$this->column_lev_color.' editbackground editfont">Select Horizontal or Vertical Display for Your Icon Grouping:</p>';
		echo '<p><input type="radio" name="'.$data.'_blog_data2" value="horizontal" '.$checked1.'>Horizontal</p>';
		echo '<p><input type="radio" name="'.$data.'_blog_data2" value="vertical" '.$checked2.'>Vertical</p>';
		echo '</div><!--Edit Icon Vert Horiz-->';
		 
		 
		echo '<div class="fsminfo editbackground"><!--Edit Icon Center color-->';
		 if (preg_match(Cfg::Preg_color,$this->blog_data5)){
				 
				 $msg="Change the Current Icon Core Color, Use 0 to remove: #";
				 }
		   else {
			    $msg= (!empty($this->blog_data5))?$this->blog_data5 . ' is not a valid color code. Enter a Code/Click On to Open the Color finder tool to Add a Color to the Icon Center!':'Enter a Code/Click On to Open the Color finder tool to Add a Color to the Icon Center!: #';
				 }
		 
		printer::printx('<p class="info floatleft" title="The center core color of your social icon by default will be the color of your background. Add a custom color here">Customize the Center color of your icon choice</p>');
		$this->{$data.'_blog_data5_arrayed'}=array();
		$this->{$data.'_blog_data5_arrayed'}[0]=$this->blog_data5;
		$this->font_color($data.'_blog_data5_arrayed','0','blog_data5','Changing Icon Core Color');
		printer::pclear(); 
		echo '</div><!--Edit Icon Center Color-->';
		 
		echo '<div class="fsminfo editbackground"><!--Edit Icon Additional Spacing-->';  
		echo '<p class="'.$this->column_lev_color.' editbackground editfont">Add Additional Space between Your Icons:</p>';
		 $this->mod_spacing($data.'_blog_data3_arrayed',$this->blog_data3,1,100,1,'px',true,'none');
		echo '</div><!--Edit Icon Additional Spacing-->';
		echo '</div><!--Edit Icon Shape spacing-->';
		$this->show_close('shape vert spacing');//<!--shape vert spacing-->
		printer::pclear(8);
		$this->edit_styles_close($data,'blog_style','.'.$data,'background,text_align,padding_top,padding_bottom,padding_left,padding_right',"Edit Social Icon styling",'','',true,true,true); 
		}
	}//end function social icons..
#contact	
function contact_form($data,$style_list,$global=false,$mod_msg="Edit styling",$blog=false,$tablename=''){  
	$this->noname='';
	$this->noemail='';
	$this->nomessage='';
	   
	$mailsend=(isset($_GET['html'])||isset($_GET['htm']))?mail::Contact_loc_mailer:$_SERVER['PHP_SELF'];
	$default1_array=array('Your Name:','Subject:','Your Email:','Contact','Please enter your message:','none',1,'none',1);
	$default2_array=array(0,0);
	$blog_data1=explode(',',$this->blog_data1);
	foreach ($default1_array as $key=> $val){
		if (!array_key_exists($key,$blog_data1)||empty($blog_data1[$key])){
			$blog_data1[$key]=$val;
			}
		}
	$blog_data6=explode(',',$this->blog_data6);
	foreach ($default2_array as $key=> $val){
		if (!array_key_exists($key,$blog_data6)||empty($blog_data6[$key])){
			$blog_data6[$key]=$val;
			}
		}
		 
	 $this->blog_data1=implode(',',$blog_data1);
	$image_array=array('0','10',0,'10');;
	$blog_data4=(!empty($this->blog_data4))?explode(',',$this->blog_data4):$image_array;
	
	if (count($blog_data4)<4){
		 $blog_data4=$image_array;
		 $this->blog_data4=implode(',',$image_array);
		 }
	$image_pad_left=$blog_data4[1];
	$image_pad_right=$blog_data4[3];
	$this->blog_data2=preg_replace('/\s/','',$this->blog_data2);
	$this->blog_data3=preg_replace('/\s/','',$this->blog_data3);
	 $this->blog_data2=str_replace('<br>','',$this->blog_data2);//spacing control
	// $this->blog_data2=str_replace('  ',' ',$this->blog_data2);
	 //$this->blog_data3=str_replace(',',', ',$this->blog_data3);
	 //$this->blog_data3=str_replace('  ',' ',$this->blog_data3);
	 
	$this->sent=false;//initialize : if true mail was sent
	$this->textarea_contact_default=$blog_data1[4];
	if (isset($_POST['mailsubmitted_'.$data])) $this->contact_mail_process($data,$blog_data1); 
	$color2=(preg_match(Cfg::Preg_color,$blog_data6[0]))?'#'.$blog_data6[0]:'inherit'; //input and textarea font color
	$background2=(preg_match(Cfg::Preg_color,$blog_data6[1]))?'#'.$blog_data6[1]:'inherit';//input and textarea fields
	$color='inherit';//$this->current_color;
	$background='inherit';//$this->current_background_color;
	$upper_maxwidth=500*$this->current_font_px/16;//upper contact form max width
	$current_net_width=($this->current_net_width<$upper_maxwidth)?$this->current_net_width:$upper_maxwidth;
	$current_total_width_left=$current_net_width*.60;
	$size=process_data::input_size($current_total_width_left,$this->current_font_px,30);		$this->textarea_contact_default='';// no text in textarea on normal page!!
	$this->edit_styles_open();
	($this->edit)&&    
			$this->blog_options($data,$this->blog_table);
		
	###display render for edit and non edit
	$show_image=false;
	if(!$this->edit):
		print'<form action="'. $mailsend.'?editmode" method="post"   onsubmit="return gen_Proc.validateReturn({funct:\'validateEntered\',pass:{idVal:\'name'.$data.'\',ref:\'name\'}},{funct:\'validateEmail\',pass:{idVal:\'email'.$data.'\'}},{funct:\'validateEntered\',pass:{idVal:\'message'.$data.'\',ref:\'message\'}});">';
	//<p><input type="hidden" name="email[\'return_address\']" value="'. Sys::Self .'" ></p>';
	
	 else:		
		print '<fieldset class="border5 borderdouble" style="border-color:#'.$this->magenta.';"><!-- Wrap Normal Display Contact-->
		<legend style="background:white; color:#'.$this->magenta.';">Display Only:  Use Editing Below</legend>';
		printer::pspace(15);
		endif;
	####  BEGIN NORMAL CONTACT POST   webpage FORM fields 
	$name=($this->edit)?'':'name="email[name_'.$data.']"';
	$subject=($this->edit)?'':'name="email[subject_'.$data.']"';
	$email=($this->edit)?'':'name="email[email_'.$data.']"';
	$messagename=($this->edit)?'email[\'nonameproxy\']':'email[message'.$data.']" id="message'.$data.'';
	$vmsg=(!$this->sent&&isset($_POST['email']['message'.$data])&&isset($this->clean_message))?$this->clean_message:'textarea_contact_default';
	$vname=(!$this->sent&&isset($_POST['email']['name_'.$data])&&isset($this->clean_name))?$this->clean_name:'';
	$vemail=(!$this->sent&&isset($_POST['email']['name_'.$data])&&isset($this->clean_email))?$this->clean_email:'';  
	echo '
	 <div class="narrow" style="float:left; max-width:500px;"><!--top of Edit contact Left-->'; 
	echo '<div class="contact_table">
	  
        <p class="narrow">'.$blog_data1[0].'</p> 
	 <p class="wide"><input type="text" '.$name.' id="name'.$data.'"  maxlength="50" value="'.$vname.'"><span class="alertnotice">' . $this->noname . '</span> </p>
     <p class="clear">&nbsp;</p>
        <p class="narrow">'.$blog_data1[1].'</p>
        <p class="wide"><input type="text" '.$subject.' id="subject'.$data.'"  maxlength="50" value="'.$blog_data1[3].'"></p>
      <p class="clear">&nbsp;</p>
       <p class="narrow">'.$blog_data1[2].'</p>
    <p class="wide"><input type="text"   '.$email.' id="email'.$data.'"  maxlength="80" value="'.$vemail.'" > <span class="alertnotice">' . $this->noemail . '</span> </p>
	<p class="clear">&nbsp;</p>
        </div><!--contact_table-->
	</div><!--End Narrow Contact-->';
printer::pclear(1); 
echo '<div class="ht0">'; 
$this->textarea('Enter message Here','contact_message_check',$this->current_net_width,$this->current_font_px,'','left',98,true);
echo '</div><!-- class="ht0"-->';	
echo '
<p class="form_message floatleft">'.$blog_data1[4].'<br></p>';
$this->textarea($vmsg,$messagename,$this->current_net_width,$this->current_font_px,'','left',98,true);
	echo '
	<p class="floatleft ht20"><input type="radio" value="nhuman"  name="contact_status_check"><img class="pt5" src="'.Cfg_loc::Root_dir.Cfg::Graphics_dir.'nhuman.gif" width="94" alt="status"></p>';
	 
	echo '
	<p class="floatleft ht20"><input type="radio" value="yhuman" name="contact_status_check"><img class="pt5" src="'.Cfg_loc::Root_dir.Cfg::Graphics_dir.'yhuman.gif"  width="94" alt="status"></p>';
	printer::pclear();
	####  END of  webpage FORM  Begin: edit default form fields and prompts
	if ($this->edit&&!$this->is_clone): 
		$this->show_more('Change/Translate the Default Form Prompts Shown Above','noback','','',500); //form prompts
	
		 
		echo'<div class="fsminfo editbackground '.$this->column_lev_color.' editfont left"><!--Form defaults Modify-->
		 <div class="narrow fs1color" style="float:left; max-width:500px;"><!--narrow contact-->'; 
		$cols=process_data::width_to_col($current_net_width,$this->current_font_px);
		$mytext=(empty($this->blog_data5))?$this->default_blog_text:$this->blog_data5;
		 
		echo'<p class="info" title="Change/translate the default contact form input Prompt Text for Name Subject Email and Message Here">Change/translate the default Form Prompts and Default Fill-in for the Subject Prompt Below</p> 
		 
		   <p class="editfont narrow " style="background:#'.$this->editor_background.';color:#'.$this->editor_color.';">
		   '.$blog_data1[0].' </p> 
		 <p class="wide"><input style="background:#'.$this->editor_background.';color:#'.$this->editor_color.';" type="text"   name="'.$data.'_blog_data1[0]"      maxlength="50" value="'.$blog_data1[0].'"></p>
		 <p class="clear">&nbsp;</p>
		 
		
		 
		   <p class="editfont narrow"  style="background:#'.$this->editor_background.';color:#'.$this->editor_color.';">
		   '.$blog_data1[1].' </p>
		   <p class="wide"><input style="background:#'.$this->editor_background.';color:#'.$this->editor_color.';" type="text"  name="'.$this->blog_table.'_'.$this->blog_order.'_blog_data1[1]"   size="'.$size.'" maxlength="50" value="'.$blog_data1[1].'"></p>
		
		  
		 
		 <p class="clear">&nbsp;</p>
		   <p class="editfont narrow"  style="background:#'.$this->editor_background.';color:#'.$this->editor_color.';">
		  <span class="info" title="Change the default Subject fill-in"> '.$blog_data1[1].' </span></p>
		   <p class="wide"><input style="background:#'.$this->editor_background.';color:#'.$this->editor_color.';" type="text"  name="'.$this->blog_table.'_'.$this->blog_order.'_blog_data1[3]"  size="'.$size.'" maxlength="50" value="'.$blog_data1[3].'"></p>
		 
		 <p class="clear">&nbsp;</p>
		  <p class="editfont narrow"  style="background:#'.$this->editor_background.';color:#'.$this->editor_color.';">   '.$blog_data1[2].'</p>
	    <p class="wide"><input style="background:#'.$this->editor_background.';color:#'.$this->editor_color.';" type="text" name="'.$this->blog_table.'_'.$this->blog_order.'_blog_data1[2]"  value="'.$blog_data1[2].'"  size="'.$size.'" maxlength="60" ></p>
	   
		 <p class="clear">&nbsp;</p>';
		 
		echo '</div><!--narrow contact-->';  
		   printer::pclear();
		 
		$msg='Change the Default Contact Message'; 
		 echo '	 
		<p class="editcolor editbackground editfont">'.$blog_data1[4].'<br></p>
		<p ><textarea class="editfont" style="background:#'.$this->editor_background.';color:#'.$this->editor_color.';font-size:18px; width:90%" name="'.$this->blog_table.'_'.$this->blog_order.'_blog_data1[4]" cols="70" rows="1" >'.$blog_data1[4].'</textarea> </p>';
		echo'</div><!--Form defaults Modify-->'; 
		$this->show_close('Change/Translate the Default Form Prompts Shown Above');//form prompts
		 
	elseif (!$this->edit):
		print '<p class="alertnotice">' . $this->nomessage . '</p>';
		printer::pclear();
		echo'<p><input type="submit" name="submit" value="Send Email" ></p>
		 <p><input type="hidden" name="sess_token" value="'.$this->sess->sess_token.'" ></p>
		<p><input type="hidden" name="mailsubmitted_'.$data.'" value="TRUE" ></p>
		<p><input type="hidden" name="sentto" value="'.Cfg::Owner.'" ></p>
		</form> ';
		return;
	endif;
	($this->edit)&&print '</fieldset><!-- Wrap Normal Display Contact-->'; 
	###end display for edit and non edit 
	$this->css.='     
      .'.$data.' textarea {background:#'.$background2.'; color:'. $color2.';}
	.alertnotice {font-weight:800; color:#'.$this->redAlert.';}
	 .'.$data.' input {color: '.$color2.';
	 background-color: '.$background2.';max-width:100%;}
	 .'.$data.' .clear{clear:both; height:0px;} 
      .'.$data.' .form_message {padding:.7em 0 .15em 0; background:'.$background.'; color: '. $color.';text-align: left; font-size: .9em; text-align: left; } 
	.'.$data.' p.wide{text-align:left;float:left;max-width:300px;}
	@media screen and (max-width: 400px){
		.'.$data.' p.wide{max-width:250px;}
		}
	@media screen and (max-width: 350px){
		.'.$data.' p.wide{max-width:200px;}
		}
	@media screen and (max-width: 300px){
		.'.$data.' p.wide{max-width:160px;}
		}
	.'.$data.'  p.narrow,.'.$data.'  td.narrow label {background:#'.$background.'; color: '. $color.'; text-align: left;float:left; width:100px; }
	
	.'.$data.'  p.narrow label.information {color:#'.Cfg::Info_color.';}
	.'.$data.'  .contact {background:#'.$background.'; color: '. $color.';} 
	';
	 
	if ($this->clone_local_style||!$this->is_clone){
		
		if(empty($this->{'blog_data2'})):
			$msg='  Start Edit Here: Configure Email Addresses and other Contact Form Settings'; 
		else:
			$msg='Congifure Contact Settings'; 
		endif; 
		echo '<div class="Os3darkslategray floatleft fsminfo editcolor editbackground"><!--configure contact-->';
		$this->show_more($msg,'noback','',"Initial Configuration Requires Your Email Address: Add Below:");//show more config
		echo'<div class="fsmblack  editcolor editbackground editfont"><!--Contact Form Wrap-->';
		printer::alertx('<p class="editfont fsminfo editbackground '.$this->column_lev_color.'"> Emails Will Be sent to the  Address(es) You Add Here Whenever a User Submits this Contact Form.  Use commas to separate multiple emails</p>');
		if (empty($this->blog_data2)) :
			$this->blog_data2=(preg_match(Cfg::Preg_email,Cfg::Contact_email))?Cfg::Contact_email:Cfg::Admin_email;
			$class='allowthis'; 
		else : $class='';
		endif;
		printer::alertx('<p class="editbackground editfont">Add/Change Contact Email Addresss(es)</p>');
	 $this->textarea('blog_data2',$this->blog_table.'_'.$this->blog_order.'_blog_data2',$this->current_net_width,$this->current_font_px,'','left',90,false,$class);
		 printer::pclear(); 
		  if ($blog_data1[6]!=='admin_add')
		  
			 printer::alert('<input  type="checkbox"  name="'.$data.'_blog_data1[6]" value="admin_add" ><span class="information" title="Check this box to also send this  contact form emails to the Administrator Email Address(s) set in the Cfg (configuration) Files. ">Check Here to Also Send Contact Emails to the Admin Email(s) '.str_replace(',',', ',Cfg::Admin_email).' </span>',false,'Os3black editfont left');
		else
			printer::alert('<input  type="checkbox"  name="'.$data.'_blog_data1[6]" value=istrator Email Address set in the Cfg (configuration) File.">Check Here to <span class="neg">DO NOT SEND </span>  Contact Emails to the Admin Email(s) '.Cfg::Admin_email.' </span>',false,'editfont left');  
		  
		if ($blog_data1[8]==='none'){
			printer::alertx('<p class="editfont fsminfo editbackground '.$this->column_lev_color.'" >Check Below to Deactivate All http:// Active Urls &#40;http:// website Links&#41; in the Messages you receive. Mistakenly hit Active URLs can potentially take you to a Malware Site. You  can still copy the Url and manually paste into the address  bar if the deactivation option is chosen.</p>');
			printer::alert('<input  type="checkbox"   name="'.$data.'_blog_data1[8]" value="1" >Check Here to Deactivate All Active Urls in the email you receive as a Safety Precaution',false,'left editfont');
			}
		else {
			printer::alertx('<p class="editfont fsminfo editbackground '.$this->column_lev_color.'" >Check Below to Prevent Deactivation of All Webiste Links &#40;URLs&#41; in The Email Message You receive. Mistakenly hit urls can potentially take you to a Malware Site. If NOT Chosen You can still copy the Url and manually paste into the address  bar. 
			<br><input  type="checkbox"   name="'.$data.'_blog_data1[8]" value="none" ><span class="neg">DO NOT DEACTIVATE </span>All Active Urls</p>',false,'left editfont');
			}
		printer::pclear();
		printer::alertx('<p class="left pt10 editbackground editfont"><span class="information" title="If your receiveing spam, Enter a list of comma separated keywords or Terms You would like to Designate as Spam.  Emails will still be sent but SPAM will be added to the subject line">Add/Edit Spam  Keywords and Terms</span></p>');
		$this->textarea('blog_data3',$data.'_blog_data3',$this->current_net_width,$this->current_font_px);
		printer::pclear();
		echo'</div><!--Contact Form Wrap-->';
		$this->show_close('show more config');// </div><!--show more config-->
		 #*************************End Configure Contact
		 
	 
		$msg='Change the Specific Colors of the Text/Background input Fields';
		$this->show_more($msg,'noback','',"Input and Textarea Colors"); 
		   echo'<div class="fs1color"><!--choose colors-->';
		   printer::alertx('<p class="left editbackground editfont"><label class="information" title="In Additon to styling the text color and background color of the Contact Form options in the Edit Contact Link above optionally choose to color the text and background  of the input and textarea fields of the Contact Form separately if you Wish to contrast them from the General Form Background Colors. Change Font Colors Here">Change the Font Color of Contact Form Input/Textarea Fields: #</label><input style="cursor:pointer;background:#'.$this->editor_background.';color:#'.$this->editor_color.';" type="text"  name="'.$this->blog_table.'_'.$this->blog_order.'_blog_data6[0]" id="'.$this->blog_table.'_'.$this->blog_order.'fontcolor" value="'.$blog_data6[0].'" size="6" maxlength="6" class="jscolor {refine:false}"><span style="font-size: 1.1em; color:#'.Cfg::Info_color.';" id="'.$this->blog_table.'_'.$this->blog_order.'fontcolorinstruct"></span></p>');
		   echo '</div><!--choose colors-->';
		echo'<div class="fs1color"><!--choose colors-->';
		   printer::alertx('<p class="left editbackground editfont"><span class="information" title="Optionally Change the text and background colors of the input and textarea fields of the Contact Form if you Wish to contrast them from the General Form Background Colors. Change Background Colors Here">Change the Background Color of Contact Form Input/Textarea Fields: #</span><input style="cursor:pointer;background:#'.$this->editor_background.';color:#'.$this->editor_color.';" type="text"  name="'.$this->blog_table.'_'.$this->blog_order.'_blog_data6[1]" id="'.$this->blog_table.'_'.$this->blog_order.'backgroundcolor" value="'.$blog_data6[1].'" size="6" maxlength="6" class="jscolor {refine:false}"><span style="font-size: 1.1em; color:#'.Cfg::Info_color.';" id="'.$this->blog_table.'_'.$this->blog_order.'backgroundcolorinstruct"></span></p>');
		   
		 
		   echo '</div><!--choose colors-->';
		 $this->show_close('Change Colors');//<!--Show More Change Colors-->';
		  $this->edit_styles_close($data,'blog_style','.'.$data,'',$mod_msg); 
		}
	echo '</div><!--configure contact-->';
}// end render_form
 

static function email_scrubber(&$value,$key,$deactivate) {
if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
    // List of very bad values:
	$very_bad = array('to:', 'cc:', 'bcc:', 'content-type:', 'mime-version:', 'multipart-mixed:', 'content-transfer-encoding:');
	
	// If any of the very bad strings are in 
	// the submitted value, return an empty string:
	foreach ($very_bad as $v) {
		if (strpos($value, $v) !== false){ 
		$value= '';
		return;
		}
	}//if found will terminate script returning '' to calling script
	
	// Replace any newline characters with spaces:
	$value = str_replace(array('"', "\\r", "\\n", "%0a", "%0d"), ' ', $value);
	(!empty($deactivate))&&$value= str_replace('http' ,  '(Deativated link: if trusted put http here)' ,$value);
	$value=htmlentities(strip_tags($value));

	// Return the value:  gets here only if verybad things not found!!
	  //
   
	} // End of email_scrubber() function.


function contact_mail_process($data,$contact_arr){  
	$deactivate=(empty($contact_arr[8])||$contact_arr[8]=='none')?0:1;
	
	$iplookup=mail::iplookup();
	if (isset($_POST['email']['message'.$data])){ 
		$this->post_message=htmlentities($_POST['email']['message'.$data]);
		}    
	if (isset($_POST['email']['name_'.$data])){ 
	    $this->post_name=htmlentities($_POST['email']['name_'.$data]); 
		} 
	if (isset($_POST['email_'.$data])){
		$this->post_email=htmlentities($_POST['email']['email_'.$data]); 
		}
	
	$this->scrubbed=$_POST['email'];
	array_walk($this->scrubbed,array('self','email_scrubber'),$deactivate); //scrubbed is array sent hrou scrubber                                                                     
	//echo $this->scrubbed['message'.$data].' is scrubbed message';
	if (!preg_match(Cfg::Preg_email,$this->scrubbed['email_'.$data])){
		$this->scrubbed['email_'.$data]='';
		}
	   // Minimal form validation:
	if (!empty($this->scrubbed['name_'.$data]) && !empty($this->scrubbed['subject_'.$data]) && !empty($this->scrubbed['message'.$data]) && !empty($this->scrubbed['email_'.$data]) ) {
		   // Create the body:
		$this->clean_email=$clean_email=$this->scrubbed['email_'.$data];
		$this->clean_name=$clean_name=$this->scrubbed['name_'.$data];
		$this->clean_subject=$this->subject=$clean_subject=$this->scrubbed['subject_'.$data];
		$this->clean_message=$clean_message=$this->scrubbed['message'.$data];
		$body = "Do Not Reply Directly with this email".NL."Reply to: $clean_email".NL." Subject: $clean_subject".NL." From: $clean_email".NL.$iplookup.NL."$clean_name has sent you a message!: ".NL.NL .$clean_message.NL;
		$this->body =NL. wordwrap($body, Cfg::Wordwrap);
	    // Send the email:
	    
		
			$sendvar='sent to for each: ';
			if(empty($this->blog_data2)){
				$msg='CONFIGURE YOUR CONTACT INFO ON EDITPAGE ADD EMAIL ADDRESSES';
				mail::alert($msg);
				exit($msg);
				} 
			$newtomail=explode(',',$this->blog_data2);
			$admin_mail=explode(',',Cfg::Admin_email);
			(!empty($contact_arr[6])&&$contact_arr[6]==='admin_add')&&$newtomail=array_merge($newtomail,$admin_mail);// 
			$mailstring=implode(',',$newtomail);//for email reference
			if (!empty($this->blog_data3)){
				$checkarray=explode(',',$this->blog_data3);
				$check_list='';
				foreach($checkarray as $check){
					if (empty($check))continue; 
					$check=trim(strtolower($check));
					if (strpos(strtolower($body),$check)) {
						$check_list.=$check.',';
						}
					if (strpos($this->scrubbed['subject_'.$data],$check)!==false) {
						$check_list.=$check.',';
						}     
				    }
				if (strlen($check_list)){ 
				    $check_list=substr_replace($check_list ,"",-1);
				    $this->body.=NL.'Emails Spammmed due to keywords: '.$check_list;
				    $this->subject='SPAM Alert: '.$this->subject;
				    }
				}#end seo check 
						 
			
			if (Sys::Web){
				
				$usr=new users();
				$this->body = NL. ' Browser info is '
				.$usr->get('OS').NL.
				$usr->get('ip'). " is address".NL.
				' emailed to owner/admin: '.Cfg::Owner.' using: '.$mailstring .NL
				. $this->body; 
				if(!isset($_POST['contact_status_check'])||(isset($_POST['contact_status_check'])&&$_POST['contact_status_check']!=='yhuman')){
					printer::alertx('<p style="background:red;color:white">Seriously, Choose Your Status!</p>');
					
					$this->sent=false;
					}
				elseif (isset($_POST['contact_message_check'])&&$_POST['contact_message_check']!='Enter message Here'){
					$this->sent=true; //giveem sent message without sending 
					}
				
				else { 
					foreach ($newtomail as $var){  
						$this->contact_mail_send($var);
						}
					}
						 
				if ($this->sent){
					//$name=str_replace(' ','%20',$_POST['name_'.$data]);
					$name=htmlentities($this->post_name);//don't use full scrubbed name as giveaway
					printer::alertx('<p style="background:#'.Cfg::Pos_color.';color:white;">Thankyou '.$name. ' your message has been sent</p>'); 
					}
				}//end if sys::web   
			else {// local 
			   $this->body = NL.
			   'local test email:'.NL.			
			   'email subject: '.$this->subject.NL.
			   ' emailed to owner/admin: '.Cfg::Owner.' using: '.$mailstring.NL
			   . $this->body;
			   echo $this->body;
			   $name=htmlentities($this->post_name);//don't use full scrubbed name as giveaway
			   if(!isset($_POST['contact_status_check'])||( isset($_POST['contact_status_check'])&&$_POST['contact_status_check']!=='yhuman')){
					printer::alert_neg('Choose Your Status!!');
					}
			   else printer::alert_pos('Thankyou '.$name. ' your message has been sent');
				   }
			}//close if !empty scrubbed
		else {
		    echo $this->alert[]='Please fill out the form completely.</p>';
		    if (empty($this->scrubbed['name_'.$data])){
			   $this->noname='*Name Required';
			   }
		    if (empty($this->scrubbed['message'.$data])){
			   $this->nomessage='*Message is Required';
			   }
		    if (empty($this->scrubbed['email_'.$data])){
			   $this->noemail='*Valid email is Required';
			}
		}//end else scrubbed is not empty	   
    }//end function contact_mail 
 
function contact_mail_send($email){  mail($email, 'hello', 'body');
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	//$headers.="From: ".Cfg::Mail_from . "\r\n";
	//$headers.='Reply-To: webmaster@example.com' . "\r\n"; #may affect span 
		//$headers.= "Reply-To: $this->scrubbed['email'] \r\n"; note did work with reply to...
		//options to send to cc+bcc 
		//$headers .= "Cc: [email]maa@p-i-s.cXom[/email]"; 
		//$headers .= "Bcc: [email]email@maaking.cXom[/email]"; 
		
	// now lets send the email. 
	$message = <<<EOF
	<html> 
	<body style="background: #d0d195"> 
	<table width="700" align="center" style="padding-top: 30px; padding-bottom:30px; background-color: #e7e9c0">
	<tr><td>
	<table width="90%"  align="center" style="background-color: #fff">
	<tr><td>
	<table width="90%"  align="center"  style="background-color: #fff; padding-bottom: 30px;">
	<tr><td>
	$this->body
	 </td></tr></table>
	</td></tr></table>
	</td></tr></table>
	</body> 
	</html> 
EOF;
$message2 = <<<EOF
	 
	<div style="background: #d0d195"> 
	<table width="700"  align="center" style="padding-top: 30px; padding-bottom:30px; background-color: #e7e9c0">
	<tr><td>
	<table width="90%"  align="center" style="background-color: #fff">
	<tr><td>
	<table width="90%"  align="center"  style="background-color: #fff; padding-bottom: 30px;">
	<tr><td>
	$this->body
	 </td></tr></table>
	</td></tr></table>
	</td></tr></table>
	</div>  
EOF;
	if (Sys::Loc){
		printer::alertx($message2);
		return;
		}
	if (mail($email, $this->subject, $message, $headers)) {
		$this->sent=true;}
	else mail::alert('Problem with mail_send in contact.php'." email is $email and message is ".NL."$message ".NL."and headers are ".NL."$headers and subject is ".$this->subject);	
	}
#background vide  
function background_video($element){
	static $num=0; $num++;
	$ele_arr=explode(',',$this->$element);  
	$styleindexes=explode(',',Cfg::Style_functions);
	foreach($styleindexes as $key =>$index){
		if (!empty($index)) ${$index.'_index'}=$key;
		}
	$count=count($styleindexes);
	for ($i=0; $i<$count; $i++){
		(!array_key_exists($i,$ele_arr))&&$ele_arr[$i]=0;
		}
	$backindexes=explode(',',Cfg::Background_styles);
	foreach($backindexes as $key =>$index){
		if (!empty($index)) ${$index.'_index'}=$key;
		}
	if (array_key_exists($background_index,$ele_arr)&&strlen($ele_arr[$background_index])>30){ 
		$background_array=explode('@@',$ele_arr[$background_index]); 
		$count=count($backindexes);
		for ($i=0; $i<$count; $i++){
			(!array_key_exists($i,$background_array))&&$background_array[$i]=0;
			}
		if (array_key_exists($background_video_index,$background_array)&&strlen($background_array[$background_video_index])>5&&$background_array[$background_video_display_index]!=='no_display'){//display background image
			$vidname=$background_array[$background_video_index];
			$ext_arr=explode(',',Cfg::Valid_vid_ext);
			$path_parts=pathinfo($vidname);
			$ext=(array_key_exists('extension',$path_parts))?$path_parts['extension']:'';
			if (!in_array($ext,$ext_arr)){
				($this->edit)&&printer::alert_neg('Invalid  background video: '.$vidname);
				return;
				}
			//$video=process_data::un_scrub($background_array[$background_video_index]);
			#we are not replacing now .. instead will override with css in absolute pos element
			$ratio=(array_key_exists($background_video_ratio_index,$background_array)&&!empty($background_array[$background_video_ratio_index])&&is_numeric($background_array[$background_video_ratio_index])&&$background_array[$background_video_ratio_index]>.1&&$background_array[$background_video_ratio_index]<10)?$background_array[$background_video_ratio_index]:1.333; 
			if ($this->edit&&$ratio==1.333){
				$msg='Default Video Aspect Ratio (1.333) may be changed in the background style options to balance your width/height ratio';
				printer::alert_neu($msg,.5);
				}
			//$vidname='ean02idlEm4';  	//testing youtube api 
			$width=$this->current_net_width; //auto with background
			$height=$width/$ratio;
			$autoplay=1;
			$mute=1;
			$loop=1;
			$viddir=Cfg_loc::Root_dir.Cfg::Vid_background_dir; 
			$controls=0;
			$cc=0;   
			$image='';  
			$id='';//'id="back_vid_'.$num."';
			$video=video_master::instance();
			echo '<div '.$id.' class="video-back-container" data-rwd="'.$this->rwd_post.'" data-type="'.$element.'" data-vid-ratio ="'.$ratio.'"><div>';
			$video->render_video($vidname,$image,$width,$ratio,$viddir,$autoplay,$loop,$mute,$cc,$controls);//blog info currently used for flv autoplay
			
			#################
			
			
			echo '</div></div>';
			}
			
			 
		}
	}
				

function checking($id,$name,$value,$text,$title,$class="ramanaleft"){   /// not in use
	$checked= ($var==1)?' checked="checked" ':''; 
     echo '<p class="'.$class.'" ><input type="checkbox" id="'. $style.'_'. $val  .'" name="'.$style.'['. $val .']"'.$checked.' value="1">Select '. $functions[$val].'</p>';
	}
	
function mod_spacing($name,$value,$range1=0,$range2=300,$increment=5,$unit='px',$zero=false,$none='',$display=''){ if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__); 
	$showunit=(empty($none))?$unit:''; 
	if (!empty($display))$display='onchange="edit_Proc.displaythis(\''.$display.'\',this)"';
    $size= (is_numeric($value)&&$value>=$range1&&$value<=$range2)?$value:0;
	 
	echo '
	<div class="editfont editcolor editbackground" style="letter-spacing:2px; font-size:1em;">Currently: '.$size.$showunit.'<br> 
    Choose:';  
	$msgjava='Choose:'; 
	echo '<div class="editcolor editfont editbackground click" onclick="gen_Proc.precisionAdd(this,\''.$name.'\',\''.$range1.'\',\''.$range2.'\',\''.$size.'\',\''.$showunit.'\',\''.$increment.'\',\''.$msgjava.'\',\'\',\'increment\');">Choose:</div>';
		 
    echo'  
	    </div>
	    ';
   }
function edit_form_end($value='SUBMIT ALL CHANGES'){  if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
     (Sys::Deltatime)&&$this->deltatime->delta_log(__LINE__.' @ '.__method__.'  ');
	echo '<div class="clear spacer"></div>';
	echo '<input type="hidden" name="sess_token" value="'.$this->sess->sess_token.'">';
	echo ' <p><input type="submit" name="submit" value="'.$value.'" ><br><br><br></p>';
	echo '<p> <input class="editbackground editfont cursor buttonpos pos mb10" type="hidden" name="submitted" value="TRUE" > </p>';
	//($this->innercontainer)&&print('</div><!--innercontainer-->');
	//(!empty($this->container))&&print('</div><!--container-->');
	printer::pspace(25);
	print('</form>');

	} 
	
function configure_editor(){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	
	$this->show_more('Configure Setting Defaults','noback');
	echo'<div class="fsmcolor editbackground editcolor"><!--settings defaults wrap-->';
	if (empty($this->page_width)|| $this->page_width <100 || $this->page_width > 2800)echo '<input type="hidden" name="page_width" value="1280">';
	$this->page_width=($this->page_width >99 && $this->page_width < 2801)?$this->page_width:1280;
	
	 echo'<div class="floatleft editbackground fsminfo info" title="Set the  maximum Page Content Width which limits the width of Columns and Posts within Columns. Consistent width between pages lead to consistent navigation transtions. Default page width: 1280px"><!--page width-->Set Default  Primary Column Width:';
	$this->mod_spacing('page_width',$this->page_width,100,Cfg::Col_maxwidth,1,'px');
	echo'</div><!-- page width-->';
	
	printer::pclear(5);
	
	echo'<div class="floatleft editbackground fsminfo info left" title="Set whether advanced styles are initially enable or not  on edit page. Set to false if advanced styles enabled causes editing difficulty and styles will still be rendered in normal pages"><!--page adv-->Advanced Styles: Enable or Disable css rendering in Edit Pages. Normal Web Pages will always render. Use the the buttons at the top or the bottom of the page to toggle Edit Page Css Rendering of Advanced Styles'; 
	$checked2=($this->page_options[$this->page_advanced_index]==='disabled')?'checked="checked"':''; 
	$checked1=($this->page_options[$this->page_advanced_index]!=='disabled')?'checked="checked"':''; 
	printer::alert('<input type="radio" value="enabled" '.$checked1.' name="page_options['.$this->page_advanced_index.']">Default Adv Css On<br>');
	printer::alert('<input type="radio" value="disabled" '.$checked2.' name="page_options['.$this->page_advanced_index.']">Default Adv Css Off');
	printer::pclear();
	echo'</div><!-- page adv-->';
	
	printer::pclear(5);
   $maxplus=(!empty($this->page_options[$this->page_max_expand_image_index])&&$this->page_options[$this->page_max_expand_image_index]>299)?$this->page_options[$this->page_max_expand_image_index]:Cfg::Page_pic_expand_plus;
   echo'<div class="floatleft editbackground fsminfo info" title="By Default Posted Images when clicked will expand to a preset  width or height max value whichever is larger. Change the Default value  '.$maxplus.'px here which will effect all images on the site that are not specifically configured for this value in the post options configuration. Larger sizes mean slower downloads and use up more disk space"  ><!--expand image-->Change Expanded Image max width/height setting:';
	$this->mod_spacing('page_options['.$this->page_max_expand_image_index.']',$maxplus,300,2800,1,'px');
	echo'</div><!--expand image-->';
	printer::pclear(5);
   $quality=(!empty($this->page_options[$this->page_image_quality_index])&&$this->page_options[$this->page_image_quality_index]>10&&$this->page_options[$this->page_image_quality_index]<101)?$this->page_options[$this->page_image_quality_index]:Cfg::Pic_quality;
  echo'<div class="floatleft editbackground fsminfo info" title="By Default Page Images will have a Default Quality factor  with 100 being the highest and 10 the lowest. The higher the image quality the larger the filesize and the slower the download speed. Change the Default value  in the Page Configuration options which will effect all uploaded images on the site that are not specifically configured for this value in the post type: image, slideshow, or gallery configurations"  ><!--quality image-->Change Current Image Quality setting:';
	 
	$this->mod_spacing('page_options['.$this->page_image_quality_index.']',$quality,10,100,1,'%',false,'','page_quality_show');
	echo '<div id="page_quality_show" class="fsmredAlert hide" >';
	echo '<input type="checkbox" name="page_quality" value="1">Update all images without local quality setting to newly chosen default setting on this page<br>';
	echo '<input type="checkbox" name="site_quality" value="1">Update newly chosen setting to all page configs<br>';
	echo '<input type="checkbox" name="site_quality_update" value="1">Update newly chosen setting to all pages and resize all site images that are not localled configured for quality<b>(can take few minutes on slow connections)</b>';
	
	echo '</div><!--page_quality_show-->';
	echo'</div><!--quality image-->';
	printer::pclear(5);
  
	$this->backupinst->backup_copies=$this->storeinst->backup_copies=$this->backup_copies;
   echo'<div class="floatleft editbackground fsminfo info" title="By Default 100 full database backups are stored as sql.gz compressed files everytime a post is submitted with changes. Choose more or less copies depending on your disk space"  ><!--expand image-->Change the number of backup copies saved:';
	$this->mod_spacing('page_options['.$this->page_backup_copies_index.']',$this->backup_copies,20,1000,1,' copies');
	echo'</div><!--expand image-->';
	
	printer::pclear(20);
	echo'</div><!--settings defaults wrap-->';
	 
   $this->show_close('Configure Setting Defaults'); 
	 $this->show_more('Configure Editor Colors','noback');
	echo '<div class="editcolor editbackground fsminfo"><!--colorWrap-->';
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
	printer::alertx('<p class="smaller  editcolor left editbackground editfont" style="padding: 4px 4px 4px 5px; border: 3px 0 3px 0;  border-style:solid; border-color: #'. $this->page_options[$this->page_darkeditor_color_index].';cursor:pointer;background:#'.$this->page_options[$this->page_darkeditor_background_index].';color:#'.$this->page_options[$this->page_darkeditor_color_index].';">  #<input style="cursor:pointer;background:#'.$this->page_options[$this->page_darkeditor_background_index].';color:#'.$this->page_options[$this->page_darkeditor_color_index].';" type="text"  name="page_options['.$this->page_darkeditor_background_index.']"   value="'.$this->page_options[$this->page_darkeditor_background_index].'" size="6" maxlength="6" class="jscolor {refine:false}">Change  Background Color of Dark Theme Editor</p>');
	printer::pclear(3);
	printer::alertx('<p class="fs1tb'.$this->page_options[$this->page_darkeditor_color_index].' smaller  editcolor left editbackground editfont" style="padding: 4px 4px 4px 5px; border: 3px 0 3px 0;  border-style:solid; border-color: #'. $this->page_options[$this->page_darkeditor_color_index].' cursor:pointer;background:#'.$this->page_options[$this->page_darkeditor_background_index].';color:#'.$this->page_options[$this->page_darkeditor_color_index].';">  #<input style="cursor:pointer;background:#'.$this->page_options[$this->page_darkeditor_background_index].';color:#'.$this->page_options[$this->page_darkeditor_color_index].';" type="text"  name="page_options['.$this->page_darkeditor_color_index.']"   value="'.$this->page_options[$this->page_darkeditor_color_index].'" size="6" maxlength="6" class="jscolor {refine:false}">Change Editor Misc. Text Colors of Dark Theme </p>');
	
	printer::pclear(3);
	printer::alertx('<p class=" smaller  editcolor left editfont" style="padding: 4px 4px 4px 5px; border: 3px 0 3px 0;  border-style:solid; border-color: #'. $this->page_options[$this->page_lighteditor_color_index].';cursor:pointer;background:#'.$this->page_options[$this->page_lighteditor_background_index].';color:#'.$this->page_options[$this->page_lighteditor_color_index].';"> #<input style="cursor:pointer;background:#'.$this->page_options[$this->page_lighteditor_background_index].';color:#'.$this->page_options[$this->page_lighteditor_color_index].';" type="text"  name="page_options['.$this->page_lighteditor_background_index.']"   value="'.$this->page_options[$this->page_lighteditor_background_index].'" size="6" maxlength="6" class="jscolor {refine:false}">Change Background Color of Editor Light Theme </p>');
	
	printer::pclear(3);
	printer::alertx('<p class="smaller  left editfont" style="padding: 4px 4px 4px 5px; border: 3px 0 3px 0;  border-style:solid; border-color: #'. $this->page_options[$this->page_lighteditor_color_index].';cursor:pointer;background:#'.$this->page_options[$this->page_lighteditor_background_index].';color:#'.$this->page_options[$this->page_lighteditor_color_index].';">#<input style="cursor:pointer;background:#'.$this->page_options[$this->page_lighteditor_background_index].';color:#'.$this->page_options[$this->page_lighteditor_color_index].';" type="text"  name="page_options['.$this->page_lighteditor_color_index.'];"   value="'.$this->page_options[$this->page_lighteditor_color_index].'" size="6" maxlength="6" class="jscolor {refine:false}">Change Misc. Colors of Light Theme Editor</p>');
	
	 
	printer::pclear(3);
	printer::alert('Choose Light or Dark Editor / Change the Default Editor Light/Dark Editor Colors. Text Color and Background Color Should Contrast One Another For Readability');
	printer::alert('<input type="radio" name="page_options['.$this->page_editor_choice_index.']" '.$checked1.' value="light">Use Light Editor');
	printer::alert('<input type="radio" name="page_options['.$this->page_editor_choice_index.']" '.$checked2.' value="dark">Use Dark Editor');
	
	 
	 $this->show_more('Test View '.$editorref,'noback');
	$x=1;
	printer::printx('<p class="smaller floatleft editbackground fs1info" style="margin:1px;width:110px; height:100px;color:#'.$this->info.'">Info color is the Information Text Color</p><p class="smaller floatleft editbackground fs1redAlert" style="margin:1px;width:110px; height:100px;color:#'.$this->redAlert.'">redAlert is an Alert Text Message Color </p><p class="smallest floatleft editbackground fs1pos" style="margin:1px;width:110px; height:100px;color:#'.$this->pos.'">Pos acts as a Positive Alert Color and Used to indicate Primary Column text and Borders</p>');
	printer::pclear(5);
	printer::printx('<p class="fsminfo editbackground">Note: Column Colors Are Useful To Indicate the Grouping of Posts within a Parent Column so Colors Change as the level of Nested Columns Changes. The lower level # Colors Generally Go unused whereas #1 #2 #3 and #4 are most extensively used.  Change the color level order for your chosen editor color theme in this section</p>');
	printer::pclear(5); 
	foreach ($this->color_order_arr as $color){
		echo '<p class="smaller floatleft editbackground fs1'.$color.'" style="margin:1px; width:100px; height:100px;color:#'.$this->$color.'">This Color is '.$color.' @ Col Level: #'.$x.'</p>';
		$x++;
		}
	$this->show_close('Test View '.$editorref.' Editor Text Colors');
	$this->show_more('Rearange '.$editorref.' Column Colors','noback');
	printer::printx('<p class="fsminfo editbackground editcolor">Basically each successive layer of columns gets its own main text color and border color in the editor as a way to distinguish to which column a new post is being added, etc.');
	printer::printx('<p class="fsminfo editbackground editcolor">Rearrange Colors that go with your theme towards the top of the color list which most often gets used.');
	print'<p class="'.$this->column_lev_color.' large fsminfo floatleft left editbackground">Drag color box to sort the color order. </p>';
		printer::pclear();
		echo '<p id="updatePageEdMsg" class="pos editbackground larger "></p>';
		printer::pclear(5);
		echo '<div class="editbackground editcolor"><ul id="sortPageEditor" class="nolist sortEdit" data-id="'.$this->tablename.'" data-inc="1">';
		foreach ($this->color_order_arr as $key => $color){ 
			printer::printx('<li class="floatleft center editcolor pb2 m1all fs2npinfo  '.$color.'background" style="width:50px;height:20px;"  id="sortEditorColor!@!'.$color.'!@!'.$editorref.'">#'.$key.'</li>'); 
			}//end foreach
		print '</ul><!--end gall_center--></div>';
	 
	
   $this->show_close('Rearange '.$editorref.' Column Colors');
   printer::pclear();
	$this->show_more('Color adjust '.$editorref.' Column Colors','noback');
	printer::printx('<p class="fsminfo editbackground editcolor">Basically each successive layer of columns gets its own main text color and border color in the editor as a way to distinguish to which column a new post is being added, etc.');
	printer::printx('<p class="fsminfo editbackground editcolor">If any of your colors do not contrast with your editor background then  adjust the color here or rearrange their column order to suit your style');
	foreach ($this->color_order_arr as $color){
		printer::alertx('<p class="smaller '.$color.' left editbackground editfont"> Color Adjust: #<input style="cursor:pointer;background:#'.$this->editor_background.';color:#'.$this->editor_color.';" type="text" id="color_array_'.$this->{$color.'_index'}.'" name="'.$page_color_value_property.'['.$this->{$color.'_index'}.']"   value="'.$this->$color.'" size="6" maxlength="6" class="jscolor {refine:false}">'.$color.'<span style="font-size: 1.1em; color:#'.$this->info.';" id="color_array_'.$this->{$color.'_index'}.'instruct"></span></p>'); 
		}
	
   $this->show_close('Color adjust '.$editorref.' Column Colors');
   
     echo '</div><!--colorWrap-->';
   $this->show_close('Configure Editor Colors');
   printer::pclear();
   $this->show_more('Configure Editor Font Family','noback','','Choose the font style of the Editor Only');
	echo '<div class="editcolor editbackground" style="background-color:#'.$this->editor_background.'"><!--editfont wrap-->';
	printer::printx('<p>Change the Default editor font family style</p>');
	$this->font_family('page_options',$this->page_editor_fontfamily_index,'',true);
	  $this->edit_font_family=(!empty($this->page_options[$this->page_editor_fontfamily_index])&&strpos($this->page_options[$this->page_editor_fontfamily_index],'=>')!==false)? str_replace('=>',',',$this->page_options[$this->page_editor_fontfamily_index]):  str_replace('=>',',',$this->edit_font_family);
	echo '</div><!--editfont wrap-->';
   $this->show_close('Configure Editor Font Family');
   
   printer::pclear();
   ##&&&&&&&&
    $this->show_more('Configure Editor Font Size','noback','','Choose the font size style of the Editor Only');
	echo '<div class="fsminfo editcolor editbackground"><!--editfont wrap-->';
	printer::printx('<p>Change the Default editor font size</p>');
	$this->font_size('page_options',$this->page_editor_fontsize_index,'');
	if (!empty($this->page_options[$this->page_editor_fontsize_index])&&is_numeric($this->page_options[$this->page_editor_fontsize_index]))  $this->edit_font_size=$this->page_options[$this->page_editor_fontsize_index];
	echo '</div><!--editfont wrap-->';
   $this->show_close('Configure Editor Font');
   
   printer::pclear();
   ###&&&&&&&&&&&&&&&&&&

    }
    
    
function edit_metadata(){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);

		//echo '<fieldset ><legend>Edit  outertitle: The little title tab at top of page</legend> 
			//<textarea class="cloak" name="outertitle" cols="50" rows="3" id="outertitle">' . $this->outertitle.'</textarea>  </fieldset>';
    $this->show_more('Configure Outer Tab Title, keywords and Meta data','noback','','',500);
    echo '<div class="width500 editbackground fs1lpinfo">';
    printer::alert('Optionally configure keywords and meta data which has limited effect on search engines');
     if (process_data::check_gallery())  printer::alert('Galleries get appended tablenames to keywords and metadescription to increase variety');
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
	echo '</div><!--keywords-->';
   $this->show_close('Configure Outer Tab Title');  
    }
 
 
 function color_info(){ return;
 if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
    $this->show_more('Open Color Finder','noback','smaller editbackground click '.$this->column_lev_color);
 $color=color_shades::instance();
 $color->render_color();
 echo '</div>';
 printer::pclear(1);
    }
 
 
 #***************BEGIN EDIT CSS FUNCTIONS********************
 

  //text area is set to font-size 1.0 em which will allow element size to work properly... color is a default only   
function css_edit_page_common(){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__); 
$fontfamily='';(!empty($this->master_font))? 'font-family: '.$this->master_font.'; ':' font-family: Arial, helvetica,  sans-serif; ';
   $this->editcss.='
	.z100 {z-index:100;position:relative;} 
	.tip {background:#dee0f7; margin: 4px; padding:4px; border: 4px  double #6d5c80; color:#352c3e;}
     .underline {text-decoration:underline;}
   .italic{font-style:italic;}
   .bold {font-weight: bold;}
	.nolist{list-style-type: none;}
    .inline {display:inline-block;padding:2px;}
    .purple{color:#'.$this->purple.';}
    .information {display:inline-block;padding:.2em .5em;text-align:left; color:#'.Cfg::Info_color.'; display:inline;  }
    .informationcenter {text-align:center;   font-style:italic; color:#'.Cfg::Info_color.'; }
   .infoclick,a.infoclick{padding:3px 3px;display:inline-block;text-align:left; cursor: pointer; font-style:italic; color:#'.Cfg::Info_color.'; text-decoration: underline;}
	.inlinehighlight{ padding:3px 10px;display:inline;background:#1E2F4D;color:#FFFAFF;}
	.red, .neg{color:red;}
	.expand{display:block; width:100%;} 
	.editbackground{ background:#'.$this->editor_background.';} 
	.hide,.hidemar,.hidepad,.hidefont,#hide_leftovers {display:none;}
	 div a,{color:blue;} 
	.bordernavy{border-color:#'.Cfg::Navy_color.';}
	.borderblue{border-color:#'.Cfg::Blue_color.';}
	.borderekblue{border-color:#'.Cfg::Ek_blue_color.';}
	.borderpos{border-color:#'.Cfg::Pos_color.';}
	.borderred{border-color:#'.$this->redAlert.';}
	.borderinfo{border-color:#'.Cfg::Info_color.';}
	.border1{border:1px}
	.border2{border:2px}
	.border3{border:3px}
	.border4{border:4px}
	.border5{border:5px}
	.border6{border:6px}
	.border7{border:7px}
	.border8{border:8px}
	.border9{border:9px}
	.border10{border:10px}
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
    .photoupload{color:#'.$this->editor_color.';display:block;}
	.ramanablock {max-width:700px; text-align:left;background:#'.$this->editor_background.';color:#'.$this->editor_color.';}
	.ramanafullblock {text-align:left;background:#'.$this->editor_background.';color:#'.$this->editor_color.';}
     input,textareax,.uncloak{background:#'.$this->editor_background.';}
	 legend {font-size: 1em; '.$fontfamily.' font-size: 1em;}
     textarea {  border: 1px solid #'.$this->editor_color.';}
    textarea.cloak { width: 100%; background-color: #e7c7a5; color:#000; font-size:1em;}
     input.utility{color:#'.$this->editor_color.';background:#'.$this->editor_background.';} 
     textarea.utility {'.$fontfamily.' width:90%; border: 1px solid #'.$this->editor_color.'; color: #'.$this->editor_color.';background:#'.$this->editor_background.';} 
	.width200 {width:200px;}
	.width300 {width:300px;}
	.width400 {width:400px;}
	.width500 {width:500px;}
	.width600 {width:600px;}
	.width700 {width:700px;}
	 input,legend,label,option,select  {margin:0; padding:0;color:#'.$this->editor_color.';}
	.warn1,.warn{margin:1px; background: #f1d8d8; padding:1px 3px; border: 2px  double #'.$this->redAlert.'}
	.warnlight{margin:1px; background: #fff2f2; padding:1px 3px; border: 2px  double #'.$this->redAlert.'}
	.warn2{margin:1px; background: #f1d8d8; padding:1px 3px; }
	.caution{margin:1px; background: orange; padding:1px 3px; border: 2px  double #'.$this->redAlert.'}
	.cautionmaroon{color:maroon; margin:1px; background: #f1d8d8; padding:1px 3px; border: 2px  double #'.$this->redAlert.'}
	.neg{color:#'.$this->redAlert.';}
	.alertnotice {font-weight:800; color:#'.$this->redAlert.';}
	.fs1color{border:1px solid  #'.$this->editor_color.';}
	.fs1npred {border: 1px  solid #'.$this->redAlert.';}
	.fs1npblack {border: 1px  solid #'.$this->editor_color.';}
	.fs1npinfo {border: 1px  solid #'.$this->info.';} 
	.fs1lpinfo{padding: 4px 4px 4px 25px; border: 1px  solid #'.$this->info.';} 
	.fs2npred {margin:0;padding:0;border: 2px  solid #'.$this->redAlert.';}
	.fs2npinfo {border: 2px  solid #'.$this->{'info'}.';}
	 
	.fsmcolor   { margin: 4px; padding:10px; border: 4px  double #'.$this->editor_color.' } 
	.fsmlightred {margin: 4px auto; padding:10px; border: 4px  double #dc8c8c; }
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
	.utility_horiz {background:#'.$this->editor_background.'; color:#'.$this->editor_color.'; WIDTH: 100%; margin: 0 auto;}
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
    .utility_horiz ul ul  li  {background-color: #'.$this->editor_background.'; width:195px; }
     ';	
	
	
	
	     
foreach ($this->color_order_arr as $color){ 
     $colorlight=process_data::colourBrightness($this->$color,.4);
 
	//text-shadow: #f2f0e4 0.1em 0.1em 0.1em;
	$this->editcss.='
		.button'.$color.'{ text-align:left;
	   background: #'.$this->editor_background.';   margin: 5px 5px ;
	   padding: 2px; line-height:120%; border:2px; border-style: solid; border-color:#'.$this->$color.';  
	   -moz-border-radius:5px; -webkit-border-radius:5px; border-radius:5px;
	   -moz-box-shadow:inset -3px -3px  3px  #'.$colorlight.',inset 2px  2px  2px  #'.$colorlight.';
	   -webkit-box-shadow:inset -3px -3px 3px  #'.$colorlight.',inset 2px  2px  2px  #'.$colorlight.';
	   box-shadow:inset  -3px -3px  3px #'.$colorlight.', inset 2px  2px  2px  #'.$colorlight.'; 
	    cursor:pointer; }  
		.button'.$color.'mini{ text-align:left;
	   background: #'.$this->editor_background.';   margin: 2px;
	   padding: 2px; border:2px; border-style: solid; border-color:#'.$this->$color.';  
	   -moz-border-radius:5px; -webkit-border-radius:5px; border-radius:5px;
	   -moz-box-shadow:inset -3px -3px  3px  #'.$colorlight.',inset 2px  2px  2px  #'.$colorlight.';
	   -webkit-box-shadow:inset -3px -3px 3px  #'.$colorlight.',inset 2px  2px  2px  #'.$colorlight.';
	   box-shadow:inset  -3px -3px  3px #'.$colorlight.', inset 2px  2px  2px  #'.$colorlight.'; 
	    cursor:pointer; }  
	.glowbutton'.$color.'{ text-align:left;
	   background: #'.$this->editor_background.';   margin: 5px 5px ;
	   padding: 2px; line-height:120%; border:9px; border-style: solid; border-color:#'.$this->info.';  
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
	$this->editcss.= 
	'.fs1'.$color.'{padding:4px; margin:2px; border: 1px  solid #'.$this->$color.';} 
	.fs2'.$color.'{padding: 4px; margin:2px; border: 2px  solid #'.$this->$color.';}  
	.fs3'.$color.'{padding: 4px; margin:2px; border: 3px  solid #'.$this->$color.';}   
	.fs4'.$color.'{padding: 4px; margin:2px; border: 4px  solid #'.$this->$color.';}   
	.fs5'.$color.'{padding: 4px; margin:2px; border: 5px  solid #'.$this->$color.';}
	.fd1'.$color.'{padding: 4px; margin:2px; border: 1px  double #'.$this->$color.';} 
	.fd2'.$color.'{padding: 4px; margin:2px; border: 2px  double #'.$this->$color.';}  
	.fd3'.$color.'{padding: 4px; margin:2px; border: 3px  double #'.$this->$color.';}   
	.fd4'.$color.'{padding: 4px; margin:2px; border: 4px  double #'.$this->$color.';}   
	.fd5'.$color.'{padding: 4px; margin:2px; border: 5px  double #'.$this->$color.';} 
	.Os1'.$color.'{padding: 4px; margin:2px; outline: 1px  solid #'.$this->$color.';} 
	.Os2'.$color.'{padding: 4px; margin:2px; outline: 2px  solid #'.$this->$color.';}  
	.Os3'.$color.'{padding: 4px; margin:2px; outline: 3px  solid #'.$this->$color.';}   
	.Os4'.$color.'{padding: 4px; margin:2px; outline: 4px  solid #'.$this->$color.';}   
	.Os5'.$color.'{padding: 4px; margin:2px; outline: 5px  solid #'.$this->$color.';} 
	.Od1'.$color.'{padding: 4px; margin:2px; outline: 1px  double #'.$this->$color.';} 
	.Od2'.$color.'{padding: 4px; margin:2px; outline: 2px  double #'.$this->$color.';}  
	.Od3'.$color.'{padding: 4px; margin:2px; outline: 3px  double #'.$this->$color.';}   
	.Od4'.$color.'{padding: 4px; margin:2px; outline: 4px  double #'.$this->$color.';}   
	.Od5'.$color.'{padding: 4px; margin:2px; outline: 5px  double #'.$this->$color.';} 
	.fs1tb'.$color.'{padding: 4px 4px 4px 5px; border-width: 1px 0px 1px 0px;  border-style:solid; border-color: #'.$this->$color.';}
	.fs2tb'.$color.'{padding: 4px 4px 4px 5px; border-width: 2px 0px 2px 0px;  border-style:solid; border-color: #'.$this->$color.';}
	.fs3tb'.$color.'{padding: 4px 4px 4px 5px; border-width: 3px 0px 3px 0px;  border-style:solid; border-color: #'.$this->$color.';}
	.bs3'.$color.'{border: 3px  solid #'.$this->$color.';}
	.Os3'.$color.'{outline: 3px  solid #'.$this->$color.';}
	.bdot3'.$color.'{border: 3px  dotted #'.$this->$color.';}
	.Odot3'.$color.'{outline: 3px  dotted #'.$this->$color.';}
	.bshad3'.$color.'{-moz-box-shadow: 0px 0px 3px 3px #'.$this->$color.'; 
-webkit-box-shadow:  0px 0px 3px 3px #'.$this->$color.';    
box-shadow:  0px 0px 3px 3px #'.$this->$color.';}
	.fsm'.$color.'{margin: 4px; padding:10px; border: 4px  double #'.$this->$color.';}';
	}
foreach ($carr as $color){
	$this->editcss.= 
	'.'.$color.'{color:#'.$this->$color.';}';
	}
foreach ($carr as $color){
	$this->editcss.= 
	'.border'.$color.'{border-color:#'.$this->$color.';}';
	}	
	 
foreach ($carr as $color){
	$this->editcss.=
	'.'.$color.'background{background:#'.$this->$color.';}';
	}	
   $this->editcss.='
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
	.editcolor{color:#'.$this->editor_color.';}
	.margincenter {margin: 0 auto;}
	.editfont {font-size:'.($this->edit_font_size*16).'px;font-family:'.$this->edit_font_family.';text-align :left;}
	.editfontfamily {font-family:'.$this->edit_font_family.';text-align :left;}
	.editfontsmall {font-size:14px;text-align:left;}
	.editfontsmaller {font-size:12.5px;text-align:left;}
	.editfontsmallest {font-size:11px;text-align:left;}
	.editfontsupersmall{font-size:9.5px;text-align:left;}
	.editfontcenter {font-size:'.($this->edit_font_size*16).'px;font-family:'.$this->edit_font_family.';text-align:center;}
	
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
	    
	   
    }
function css_edit_page(){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	 
    }
}//end class
 
?>