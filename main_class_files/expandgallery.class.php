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
class expandgallery { 
	private static $instance=false; //store instance
	public $master_gall_table=Cfg::Master_gall_table; 
	public $page_source=false;
	public $maxexpand=1;
	public $no_prev_page=false;//start off display with no preview page 
	public $ext='.php';
	public $transition='fade';//set default
	public $clone='';
	public $preload=array();
	public $navigated=false;
	public $sfil='';
    
function check_json($file){ 
	if (!is_file($file))return false; 
	$json=unserialize(file_get_contents($file)); 
	if (is_array($json)&&count($json)>8)return $json;
	return false;
	}
  
function pre_render_data(){ 
	$this->passclass_ext=(Sys::Pass_class)?Cfg::Temp_ext:'';	  
	$this->viewport_width=process_data::get_viewport();
	$transition_append=($this->page_source)?'page_source':$this->transition;
	$transition_append='';
	 $file=Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Gall_info_dir.'json2_'.$this->gall_ref.$this->clone.$this->passclass_ext.'.dat';
	
	$file2=Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Gall_info_dir.'json2_'.$this->gall_ref.$this->passclass_ext.'.dat';
	
	if (is_array($return=self::check_json($file))){
		$fjson=$return;
		}//else provide options for when configured for ajax mode but receiving expand-{gall_ref}.php  page_source files  will continue to utilize page sources... 
	elseif (is_array($return=self::check_json($file2) )){ 
		$fjson=$return;
		} 
	 
	elseif(!Sys::Edit){  //exit ( $this->clone.' is this clone andgall ref is '.$this->gall_ref.'  checking for '.$file. ' and ' .$file2);
		if (headers_sent()){
			mail::alert('Expand Gallery Error'. __METHOD__,__LINE__,__FILE__);
			printer::alert_neu('Expanded Gallery Maintenance1');
			return;
			}
		$url = Sys::Home_site;
		header("Location: $url");
		}
	else {
		printer::alert_neg('gallery files not found ie: '.Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Gall_info_dir.'json2_'.$this->gall_ref.$this->clone.$this->passclass_ext.'.dat');
		exit();
		}
	
	if (is_file(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Gall_info_dir.'gall_image_data_'. $this->gall_ref.$this->passclass_ext)){
		$this->img_array=unserialize(file_get_contents(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Gall_info_dir.'gall_image_data_'. $this->gall_ref.$this->passclass_ext));
		}
	else{
		if (headers_sent()){
			mail::alert('Expand Gallery Error'. __METHOD__,__LINE__,__FILE__);
			printer::alert_neu('Expanded Gallery Maintenance2');
			return;
			}
		$url = Sys::Home_site;
		header("Location: $url");
		}
	$count=count($fjson);
	 if ($count<9) {
		mail::alert('Redirect in expandgallery Count jason is '.$count.' in '.Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Gall_info_dir.'data_'.$this->gall_ref.$this->clone.'.dat');
		//process_data::write_to_file('checkout.txt',Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Gall_info_dir.'data_'.$this->gall_ref.$this->clone.'.dat file on the light side');
		 $url = Sys::Home_site;
		 header("Location: $url");
		 }
		
	if (is_file(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Gall_info_dir.'data_master_gall_ref'.$this->passclass_ext)){
		$mastergalllookup=unserialize(file_get_contents(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Gall_info_dir.'data_master_gall_ref'.$this->passclass_ext));
		}
	else $mastergalllookup=array();
	$this->master_gall_ref=(array_key_exists($this->gall_ref,$mastergalllookup))?$mastergalllookup[$this->gall_ref]:'';
	$ajson=array();
	foreach($fjson as $key=>$value){
		$this->$key=$value;
		$ajson[$key]=$value;
		}
	$file=Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Gall_info_dir.'json_'.$this->blog_id.$this->passclass_ext.'.dat';//deal with second file parent orginal 
	if (is_array($return=self::check_json($file))){
		$fjson2=$return;
		}
	else{
		if (headers_sent()){
			mail::alert('Expand Gallery Error'. __METHOD__,__LINE__,__FILE__);
			printer::alert_neu('Expanded Gallery Maintenance');
			return;
			}
		$url = Sys::Home_site;
		header("Location: $url");
		}
	foreach($fjson2 as $key=>$value){
		$this->$key=$value;
		$ajson[$key]=$value;
		}
	 
	/*$this->gall_table=$json['gall_table'];
	$this->blog_id=$json['blog_id'];
	$this->next_gallery=$json['next_gallery']; 
	$this->parent_wid=$json['parent_wid']; 
	$this->data=$json['data'];
	
	$this->gall_expand_menu_icon=$json['gall_expand_menu_icon'];
	$this->maxexpand=$json['maxexpand'];  
	$this->thumbnail_height=$json['thumbnail_height'];
	$this->transition=$json['transition'];
	$this->transition_time=$json['transition_time'];
	$this->current_net_width=$json['current_net_width'];
	$this->page_cache_arr=$json['page_cache_arr'];
	$this->page_width=$json['page_width'];
	$this->new_page_effect=$json['new_page_effect'];
	$this->default_imagetitle=trim($json['default_imagetitle']);
	$this->default_subtitle=trim($json['default_subtitle']);
	$this->default_description=trim($json['default_description']);
	$this->show_under_preview=$json['show_under_preview'];
	*/
	if (isset($_GET['pic_order']))$this->pic_order=$_GET['pic_order']; 
	else $this->pic_order=1;
	
	$this->mysqlinst=mysql::instance();
	$this->mysqlinst->dbconnect();
	$this->navobj=navigate::instance();
	if ($this->page_source){
		if (!isset($this->transition)){
			$this->transition='fade';
			}
		}
	 
	if ($this->page_source){
		$where=" where pic_order='$this->pic_order'";
		$count=$this->mysqlinst->count_field($this->master_gall_table,'pic_id','',false,$where);
		if ($count<1){
			$url = Sys::Home_site.'?msg=Page not found';
			header("Location: $url");
			}
		if ($this->transition!=='none')
			$this->transition='fade';//expand- gallery.php called while flat file transtion value inappropriately ajax.. ie. configured for ajax but directly accessing non ajax by bot crawler...
		}
	   
	$blog_data2=explode(',',$this->blog_data2);
	for ($i=0; $i <10; $i++){  
		if (!array_key_exists($i,$blog_data2)){
			$blog_data2[$i]=0;
			}
		}
	$use_ajax=(!empty($blog_data2[5]))?true:false;
	//$gall_display=($blog_data2[0]=='single'||$blog_data2[0]=='no_preview'||$blog_data2[0]=='preview_slide')?$blog_data2[0]:'expandgallery';
	//$captions=($blog_data2[3]=='global'||$blog_data2[3]=='none')?$blog_data2[3]:'individual';
	//$wpplus=($blog_data2[1]>=50&&$blog_data2[1]<10001)?$blog_data2[1]:300;
	//$wfplus=($blog_data2[2]>=125&&$blog_data2[2]<10001)?$blog_data2[2]:800;
	$this->main_menu=$blog_data2[4]; 
	 
    $this->picmax=count($this->img_array)-1;
	if ($this->picmax<$this->pic_order){
		if ($this->picmax==1){
			$this->pic_order=1;
			$this->pic_next=1;
			$this->pic_prev=1;
			}
		elseif ($this->picmax==2){
			$this->pic_order=1;  
			$this->pic_next=2;
			$this->pic_prev=1;
			}
		else {
			$this->pic_order=2;  
			$this->pic_next=3;
			$this->pic_prev=1;
			}
		}
	else {
		$this->pic_prev=check_data::loopminmaxnum('1',$this->picmax,$this->pic_order,'prev');    //for gallery controling loop 
		$this->pic_next=check_data::loopminmaxnum('1',$this->picmax,$this->pic_order,'next');  //for gallery controlling loop
		} 
	$preloadnums=check_data::preloaded('1', $this->picmax, $this->pic_order);// for slidshow to preload images  get two forward and one back
	
    
    
	    
    $row_array=array();       
    $preload_array=array();	  
   
	
    foreach ($preloadnums as $var){
		$ratio=$this->img_array[$var][4]/$this->img_array[$var][5]; 
		if ($ratio > 1){
			$pwidth=$this->maxexpand;
			$pheight=$pwidth/$ratio;
			}
		else {
			$pheight=$this->maxexpand;
			$pwidth=$pheight*$ratio;
			}
		$maxed_width=($this->viewport_width >200)?min($this->viewport_width,$pwidth):$pwidth;//precaution if < 200 may be inaccurate
		$image_width=check_data::key_up($this->page_cache_arr,$maxed_width,'val',$this->page_width);
		$image_dir=Cfg::Response_dir_prefix.$image_width.'/';
		$preload_array[]='"'.Cfg_loc::Root_dir.Cfg::Large_image_dir.$image_dir."{$this->img_array[$var][0]}".'"';
		}
	 #preload array will automatically return 1, 3,4 or so if pic_order not correct
	$this->preload= implode(",",$preload_array); //ready for header js preloader
	//if ($this->navobj->expand_px)$this->prevnextgoto=' style="top: 245px;"';  
	
	$this->picname=$this->img_array[$this->pic_order][0];
	$this->imagetitle=$this->img_array[$this->pic_order][1];
	$this->subtitle=$this->img_array[$this->pic_order][2];
	$this->description=$this->img_array[$this->pic_order][3];
	$this->image_ratio=$this->img_array[$this->pic_order][4]/$this->img_array[$this->pic_order][5];
	$this->alt='img: '.$this->picname;
	$this->render_body_main();
	if ($this->page_source)self::close_page();
	
	}//function pre render data
 
function page_open(){
$transtion=($this->transition!=='none')?'fadeTo.fadeTo_init(\'holder_'.$this->blog_id.'\','.$this->transition_time.',0,100,2);':'';
$background=(!empty($this->background))?'background:#'.$this->background.';':'';
 if (isset($_SESSION[Cfg::Owner.'factor'])) 
	$factor=$_SESSION[Cfg::Owner.'factor'];
	else $factor=1;
	$size=16*$factor;
$title='Expand Gallery';
include ('includes/html5_header.php');
//$size=($this->maxexpand+50).'px'; 
$style='{background: \'none\', border : \'none\', boxShadow:\'none\'}';	 	
 
echo'
<title>Expand Gallery Images</title>
<script type="text/javascript" src="scripts/docReady.js"></script>  
<script type="text/javascript" src="jquery.js"></script> 
<script type="text/javascript" src="'.Cfg_loc::Root_dir.Cfg::Script_dir.$this->gall_table.'scripts.js"></script> 
<link href="'.Cfg_loc::Root_dir.Cfg::Style_dir.'gen_page.css" rel="stylesheet" type="text/css" > 
<link href="'.Cfg_loc::Root_dir.Cfg::Style_dir.$this->gall_table.'.css" rel="stylesheet" type="text/css" > 
<script type="text/javascript" src="'.Cfg_loc::Root_dir.Cfg::Script_dir.'addEvent.js"></script>
<script type="text/javascript"> 

 
docReady(function () {
	document.body.style.backgroundImage=gen_Proc.getComputedStyle(\''.$this->data.'\',"background-image");
	document.body.style.backgroundColor=gen_Proc.getComputedStyle(\''.$this->data.'\',"background-color");
	gen_Proc.styleit(\''.$this->data.'\','.$style.');
	//gen_Proc.addClass(\'body\',\''.$this->data.'\')
	gen_Proc.scroll_to_view("mainPicInfo_'.$this->blog_id.'");
	window.scrollBy(0, -200);
	fadeTo.preloading('.$this->preload.');
	'.$transtion.'
	});
</script>
<style type="text/css">
#holder_'.$this->blog_id.' {width:100%;}

body {font-size: '.$size.'px;text-align:center;}
.menu-icon{position: absolute; left:20%; top:50px; z-index:100px;}
.containbackto { position:relative; float:left;  width:9em;  margin-left:200px; padding:.3em 0 .7em 0; }
.backto { position:absolute; top: 0px; left: 0px; background:#fff; filter:alpha(opacity=35);opacity:.35; 
  width:100%; height:100%; padding:   .6em 0 .7em 0;
  -moz-border-radius:3px; -webkit-border-radius:3px; border-radius:3px;}
.refbackto{ position:absolute; top: 10px; left: 0px; width:100%;
text-align:center; font-size: .9em; font-family: arial,sans-serif;font-weight: 700;
 color:rgba(217, 224, 152, 1);
	     }

	 
.backtoborder{ position:absolute; top: 0px; left: 0px;
 width:100%; height:100%; padding:   .5em 0 .9em 0;
 -moz-border-radius:3px; -webkit-border-radius:3px; border-radius:3px;
-moz-box-shadow: 1px 1px 5px -4px #0a2268;
-webkit-box-shadow: 1px 1px 5px -4px #0a2268;
box-shadow: 1px 1px 5px -4px #0a2268; 
	     }
</style>
<title>Expand '.$this->gall_ref.' Image#'.$this->pic_order.'</title>
</head>
<body>'; //#9383f6;
(Sys::Logged_in)&&self::browser_size_display();
if (Sys::Pass_class&&!Sys::Viewdb){
	printer::alert_neg('Viewing Database: '.Sys::Dbname);  
	printer::alert_neu('<a href="'.Sys::Returnpass.'">Return to ..</a>');
	}
  self::nav();
}


function nav(){
	$url=Cfg_loc::Root_dir."{$this->gall_table}.php"; 
	printer::pspace(10);
	if (!empty($this->main_menu)){   
		$mm=explode('@@',$this->main_menu);
		if (count($mm)==3){ 
			$dir_menu_id=$mm[0];
			$menu_style=$mm[1];
			$nav_wrap=$mm[2];
			
			echo '<div class="'.$nav_wrap.'"><!--nav wrap-->';
			$this->navobj->render_menu($dir_menu_id,$menu_style);
			echo '</div><!--nav wrap-->';
			echo '<div class="marginauto inline"><!--margin center-->';
			}
		}
	else if (!Sys::Pass_class)
		echo '<div class="prevD menu-icon"><a href="'.$url.'" onclick="fadeTo.fadeTo_init(\''.$this->fadeout_id.'\','.$this->transition_time.',100,0,-2);gen_Proc.delayGoTo(this,'.$this->transition_time.');return false;"><img src="'.Cfg_loc::Root_dir.Cfg::Menu_icon_dir.$this->gall_expand_menu_icon.'" alt="menu icon" width="50" height="30"></a></div>';
	
	printer::pclear(80);
	echo '<div class="'.$this->data.'" id="'.$this->data.'"  style="display:block; margin:0 auto;">';
	
	}//close nav
function browser_size_display(){
	echo '<div class="inline floatleft"><!-- float buttons-->';
	
	printer::printx('<p id="displayCurrentSize" class="buttonpos rad5 smallest editbackground pos floatleft"></p>');
	echo '</div><!--float buttons-->';
	}	
	
function close_page(){
	echo '</div></div><!-- margin center--></body></html>';
	}
function render_body_main(){ //process_data::write_to_file('lookout.txt','no prev page is '.$this->no_prev_page);
	$json=array(); 
	$json[]=$this->blog_id;
	$json[]=$this->transition;
	$json[]=($this->new_page_effect)?'body':'holder_'.$this->blog_id;//determines whether body or holder id  gets innerHTML   
	$class='';
	$fade_opacity=''; 
	$this->fadeout_id='holder_'.$this->blog_id;
	$passview=(Sys::Viewdb&&Sys::Pass_class)?'viewdb&amp;':'';
	$passclass=(Sys::Pass_class&&!empty(Sys::Returnpass))?'returnpass='.Sys::Returnpass.'&amp;tbn='.$this->gall_table.'&amp;gall_ref='.$this->gall_ref.'&amp;transition='.$this->transition.'&amp':((Sys::Viewdb&&Sys::Pass_class)?'viewdb&amp;':'');
	 
	$gotoexpand=(Sys::Pass_class&&!Sys::Viewdb)?Cfg::Expand_pass_page.'?'.$passclass.'&amp;':'expand-'.$this->gall_ref.'.php?'.$passview;//actual  filename
   $clone='&amp;clone_ref='.$this->clone;//provides fallback when ajax not enable  ie. becomes expand-tablename.php
	switch ($this->transition) {
	case  'ajax_fade' :  
		$class=' class="prevD" ';
		$onclicknext='onclick="fadeTo.fadeTo_init(\''.$this->fadeout_id .'\','.$this->transition_time.',100,0,-2); setTimeout(function(){gen_Proc.Override=1;gen_Proc.use_ajax(\''.Sys::Self.'?'.$passclass.'pic_order='.$this->pic_next.'&amp;clone_ref='.$this->clone.'&amp;gall_ref='.$this->gall_ref.'&amp;transition=ajax_fade\',\'handle_image\',\'get\')},'.$this->transition_time.');return false;"';
		$onclickprev='onclick="fadeTo.fadeTo_init(\''.$this->fadeout_id.'\','.$this->transition_time.',100,0,-2); fadeTo.fadeTo_init(\'thePhoto_'.$this->blog_id.'\','.$this->transition_time.',100,0,-2); setTimeout(function(){gen_Proc.Override=1;gen_Proc.use_ajax(\''.Sys::Self.'?'.$passclass.'pic_order='.$this->pic_prev.'&amp;clone_ref='.$this->clone.'&amp;gall_ref='.$this->gall_ref.'&amp;transition=ajax_fade\',\'handle_image\',\'get\')},'.$this->transition_time.');return false;"';
		
		break;
	case 'none' :
		$onclicknext='';
		$onclickprev=''; 
		break; 
	case 'fade' : 
		$class=' class="prevD" ';
		$fade_opacity='style="opacity:0"'; 
		$onclicknext='onclick="fadeTo.fadeTo_init(\''.$this->fadeout_id.'\','.$this->transition_time.',100,0,-2);gen_Proc.delayGoTo(this,'.$this->transition_time.');return false;"';
		$onclickprev ='onclick="fadeTo.fadeTo_init(\''.$this->fadeout_id.'\','.$this->transition_time.',100,0,-2);gen_Proc.delayGoTo(this,'.$this->transition_time.');return false;"';
		break;
	case 'ajax' : 
		$onclicknext='onclick="gen_Proc.Override=1;gen_Proc.use_ajax(\''.Sys::Self.'?'.$passclass.'gall_ref='.$this->gall_ref.'&amp;clone_ref='.$this->clone.'&amp;pic_order='.$this->pic_next.'&amp;gall_table='.$this->gall_table.'&amp;transition=ajax\',\'handle_image\',\'get\'); return false;"';
		$onclickprev='onclick="gen_Proc.Override=1;gen_Proc.use_ajax(\''.Sys::Self.'?'.$passclass.'gall_ref='.$this->gall_ref.'&amp;clone_ref='.$this->clone.'&amp;pic_order='.$this->pic_prev.'&amp;gall_table='.$this->gall_table.'&amp;transition=ajax\',\'handle_image\',\'get\'); return false;"';
		break;
	    default:   
		$class=' class="prevD" ';
		$fade_opacity='style="opacity:0"'; 
		$onclicknext='onclick="fadeTo.fadeTo_init(\''.$this->fadeout_id.'\','.$this->transition_time.',100,0,-2);gen_Proc.delayGoTo(this,'.$this->transition_time.');return false;"';
		$onclickprev ='onclick="fadeTo.fadeTo_init(\''.$this->fadeout_id.'\','.$this->transition_time.',100,0,-2);gen_Proc.delayGoTo(this,'.$this->transition_time.');return false;"';
		}
		
	if ($this->image_ratio > 1){
		$width=$this->maxexpand;
		$height=$width/$this->image_ratio;
		}
	else {
		$height=$this->maxexpand;
		$width=$height*$this->image_ratio;
		}
	
	$maxed_width=($this->viewport_width >200)?min($this->viewport_width,$width):$width;//precaution if < 200 may be inaccurate
	$image_width=check_data::key_up($this->page_cache_arr,$maxed_width,'val',$this->page_width);
	$image_dir=Cfg::Response_dir_prefix.$image_width.'/';
	if (!is_file(Cfg_loc::Root_dir.Cfg::Large_image_dir.$image_dir.$this->picname)){
		$return=image::resize_check($this->picname,0,0,$image_width,Cfg_loc::Root_dir.Cfg::Upload_dir,Cfg_loc::Root_dir.Cfg::Large_image_dir.$image_dir,$this->blog_id);
		}			
	//$outertitle=$this->imagetitle; #set outertitle in header to imagetitle 
	$style= 'style="max-width:'.$width.'px; "';//max-height:'.$height.'px;
	 $unit='px';
	if ($this->page_source)self::page_open();
	 
	$fade_opacity='';
	ob_start();
	 if ($this->page_source) echo '<div id="holder_'.$this->blog_id.'" '.$fade_opacity.'><!--holder ps-->';
	  
	 elseif ($this->new_page_effect&&!$this->no_prev_page) {//simulate and not displaying page previews  
		echo ' <div class="'.$this->data.'" id="'.$this->data.'" style="display:block; margin:0 auto;"><!--holdback--><div id="holder_'.$this->blog_id.'"><!--used for fading display-->';
		if (Sys::Pass_class){
			printer::alert_neg('Viewing Database: '.Sys::Dbname);
			printer::alert_neu('<a class="acolor click" href="'.Sys::Returnpass.'">Return Back to Edit Pages</a>');
			//printer::alert_neu('<a class="click" href="'.Sys::Self.'?viewdboff">Return Back to Normal WebPages</a>');
			}
 
		echo '
		 <div class="menu-icon"><a '.$class.' href="'.$this->returnto.'?gen'. mt_rand(1,mt_getrandmax()).'=differ&amp:#'.$this->data.'" onclick="gen_Proc.goTo(this); return false; "><img src="'.Cfg_loc::Root_dir.Cfg::Menu_icon_dir.$this->gall_expand_menu_icon.'"" alt="menu icon" width="50" height="30"></a></div> ';
		 printer::pclear(80);
		 }
		 if (!is_file(Cfg_loc::Root_dir.Cfg::Large_image_dir.$image_dir. $this->picname)){
			if (is_dir(Cfg_loc::Root_dir.Cfg::Large_image_dir.$image_dir)){
				image::image_resize($this->picname,$image_width,0,0,Cfg_loc::Root_dir.Cfg::Upload_dir, Cfg_loc::Root_dir.Cfg::Large_image_dir.$image_dir);
				mail::alert('Image resizing in expandgallery: '.Cfg::Large_image_dir.$image_dir);
				}
			else
				mail::alert('image dir not found in expandgallery:'. Cfg::Large_image_dir.$image_dir);
			}
				
		 echo '
		<div class="main marginauto center imagerespond" '.$style.' id="main_'.$this->blog_id.'" data-max-wid="'.$this->maxexpand.'">
		<div class="image-wrap"><!--new page effect-->
		 <img  style="max-width:95%" class="gall_img_'.$this->blog_id.'"   src="'.Cfg_loc::Root_dir.Cfg::Large_image_dir.$image_dir. $this->picname
			. '"  id="thePhoto_'.$this->blog_id.'"   title="Navigation menu up on photo" alt="'. $this->alt. '" > 
		<div class="prevnext"> 
		<p class="prev"><a '.$class.' style="display:block; width:100%;height:100%" '.$onclickprev.' href="'.Cfg_loc::Root_dir.$gotoexpand.'pic_order='.$this->pic_prev.$clone.'"></a></p>	<!--End prev-->
		<p class="next"><a '.$class.' style="display:block; width:100%;height:100%" '.$onclicknext.' href="'.Cfg_loc::Root_dir.$gotoexpand.'pic_order='.$this->pic_next.$clone.'"></a></p><!--End next-->
		</div><!--End prevnext-->
		</div><!--End image-wrap-->
		</div><!--End Main-->';
		//echo '<p id="goto_'.$this->gall_ref.'"></p>';//used for focusing below image
		//echo '<p id="goto_'.$this->blog_id.'"></p>';//also used ajax focusing below image
		$imagetitle=(!empty(trim($this->imagetitle)))?$this->imagetitle:((!empty($this->default_imagetitle))?$this->default_imagetitle:'');
		$subtitle=(!empty($this->subtitle))?$this->subtitle:((!empty($this->default_subtitle))?$this->default_subtitle:'');
		$description=(!empty($this->description))?$this->description:((!empty($this->default_description))?$this->default_description:'');	
		$des_wid=max(strlen($imagetitle),strlen($subtitle),strlen($description));
		 if ($des_wid > 5){ 
		 echo'<div style="max-width:'.($this->maxexpand).'px;" class="marginauto"><!--min width wrap--> 
			<div class="maxwidth95 displaytable marginauto mainPicInfo_'.$this->blog_id.' " id="mainPicInfo_'.$this->blog_id.'">';// 
			
			if (!empty($imagetitle)){   
				echo '<p id="imagetitle_'.$this->blog_id.'" class="imagetitle_'.$this->blog_id.'" > 
				'. $imagetitle . '</p>';  
				}
				
			if (!empty(trim($subtitle))){ 
				echo' <p id=="subtitle_'.$this->blog_id.'" class="subtitle_'.$this->blog_id.'">' . $subtitle . '</p>';
				}
			   
			if (!empty($description)){
				echo '<p id="description_'.$this->blog_id.'" class="description_'.$this->blog_id.'">'.$description. '</p>';
				}
			 echo '</div><!--End mainPicInfo--></div><!--max width wrap--> ';
			}
		else echo ' <div   class="mainPicInfo_'.$this->blog_id.'" style="padding-top:20px;"></div>';
	if ($this->show_under_preview){ 
		
		echo'<div style="max-width:'.($this->maxexpand).'px;" class="marginauto"> 
		<div class="gall_preview_'.$this->blog_id.' marginauto" style="max-width:90%;"  ><!--gall preview-->';
		  
		for ($i=1;$i<$this->picmax+1;$i++){  //create array so order can be by preload nums not pic_order
			$picname=$this->img_array[$i][0]; 
			$imagetitle=$this->img_array[$i][1]; 
			$wid=$this->img_array[$i][4]; 
			$height=$this->img_array[$i][5]; 
			$this->alt=substr($imagetitle,0,25);
			$width=round(($wid/$height*$this->thumbnail_height));
			$opacity= ($this->pic_order==$i)?100:50;
			$opacity2= ($this->pic_order==$i)?1 :.50;
			$clone='&amp;clone_ref='.$this->clone;//acts as fallback in ajax
			
			 
			if ($this->transition==='ajax_fade'):
				$onclick='onclick="fadeTo.fadeTo_init(\''.$this->fadeout_id.'\','.$this->transition_time.',100,0,-2);setTimeout(function(){gen_Proc.use_ajax(\''.Sys::Self.'?'.$passclass.'pic_order='.$i.'&amp;clone_ref='.$this->clone.'&amp;gall_ref='.$this->gall_ref.'&amp;transition=ajax_fade\',\'handle_image\',\'get\')},'.$this->transition_time.');return false;"'; 
			elseif ($this->transition==='ajax'):
			$onclick='onclick="gen_Proc.use_ajax(\''.Sys::Self.'?'.$passclass.'&amp;gall_ref='.$this->gall_ref.'&amp;clone_ref='.$this->clone.'&amp;pic_order='.$i.'&amp;gall_table='.$this->gall_table.'&amp;transition=ajax\',\'handle_image\',\'get\'); return false;"'; 
			elseif ($this->transition==='none'):
				$onclick='';
			elseif ($this->transition==='fade'):
				$onclick='onclick="fadeTo.fadeTo_init(\''.$this->fadeout_id.'\','.$this->transition_time.',100,0,-2);gen_Proc.delayGoTo(this,'.$this->transition_time.');return false;"';
			
			endif; 
			echo'
			<p class="thumbs"> 
			<a '.$class.' href="'.Cfg_loc::Root_dir.$gotoexpand.'pic_order='.$i.'" '.$onclick.'>
			<img class=" thumbpad thumbnail_'.$this->blog_id.'" style="filter:alpha(opacity='.$opacity.');opacity:'.$opacity2.';"  onmouseover="fadeTo.setOpacity(this, 100);"
			onmouseout="fadeTo.setOpacity(this, '.$opacity.');"  src="'.Cfg_loc::Root_dir.'small_images/'. $picname
			. '" width="'.$width.'" height="'.$this->thumbnail_height.'" alt="'. $this->alt. '" > </a> </p>';
			}//foreach
		 if ($this->next_gallery&&is_file(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Gall_info_dir.'nextgall_data_'.$this->master_gall_ref.$this->passclass_ext)){
			$fgall_info=unserialize(file_get_contents(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Gall_info_dir.'nextgall_data_'. $this->master_gall_ref.$this->passclass_ext)); 
			$gall_ref=array();
			$gall_table=array(); 
			$fname_arr=array();
			foreach ($fgall_info as $key => $arr){
				$fname_arr[$key]=$arr[0];
				$gall_refarr[$key]=$arr[1];
				$gall_tablearr[$key]=$arr[2];  
				} 
			$maxkey=count($gall_refarr); 
			if ($maxkey > 1){
				$current_order=array_search($this->gall_table,$gall_tablearr); 
				$onclick='onclick="fadeTo.fadeTo_init(\''.$this->fadeout_id.'\','.$this->transition_time.',100,0,-2);gen_Proc.delayGoTo(this,'.$this->transition_time.');return false;"';  
				if ($current_order > 1){
					
					list($wid,$height)=process_data::get_size('prev_gallery.gif'); 
					$width=round(($wid/$height*$this->thumbnail_height));
					//expand-'.trim($gall_info[$current_order-1]).'-1'.$this->ext.'"
					echo '<div class="floatleft"> <a href="'.trim($fname_arr[$current_order-1]).$this->ext.'" '.$onclick.'><img class="thumbnail thumbpad" src="prev_gallery.gif" width="'.$width.'" height="'.$this->thumbnail_height.'" alt="View Previous Gallery"/></a></div>';
					}
				 if ($current_order < $maxkey){
					 
					list($wid,$height)=process_data::get_size('next_gallery.gif'); 
					$width=round(($wid/$height*$this->thumbnail_height));
					echo '<div class="floatleft"> <a href="'.trim($fname_arr[$current_order+1]).$this->ext.'" '.$onclick.'><img class="thumbnail thumbpad" src="next_gallery.gif" width="'.$width.'" height="'.$this->thumbnail_height.'" alt="View Next Gallery"/></a></div>';
					//lets preload nextgallery first image....
					$gallfirstimage=unserialize(file_get_contents(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Gall_info_dir.'data_gall_firstimagelist'.$this->passclass_ext));//printer::vert_print($gallfirstimage);
					$gallref=$gall_refarr[$current_order+1];  
					$picname=$gallfirstimage[$gallref][0];
					$ratio=$gallfirstimage[$gallref][1];
					if ($ratio > 1){
						$pwidth=$this->maxexpand;
						$pheight=$pwidth/$ratio;
						}
					else {
						$pheight=$this->maxexpand;
						$pwidth=$pheight*$ratio;
						}
					$maxed_width=($this->viewport_width >200)?min($this->viewport_width,$pwidth):$pwidth;//precaution if < 200 may be inaccurate
					$image_width=check_data::key_up($this->page_cache_arr,$maxed_width,'val',$this->page_width);
					$image_dir=Cfg::Response_dir_prefix.$image_width.'/';
					$this->preload.=',"'.Cfg::Large_image_dir.$image_dir.$picname.'"';
					}
				printer::pclear();
				} //arra key exists
			 }//if next gall 
			 
	 
		printer::pclear();
		 echo '
		<script type="text/javascript">
		fadeTo.preloading('.$this->preload.');
		</script>
		</div><!--end gall preview-->
		</div>';
		printer::pclear();
		 
		}//end show preview
	
	 
	 
	/* 
	if ($this->new_page_effect&&$this->navigated){ 
		$style='{background: \'none\', border : \'none\', boxShadow:\'none\'}';
		echo '<script type="text/javascript">
		document.body.style.backgroundImage=gen_Proc.getComputedStyle(\''.$this->data.'\',"background-image");
	document.body.style.backgroundColor=gen_Proc.getComputedStyle(\''.$this->data.'\',"background-color");
	gen_Proc.styleit(\''.$this->data.'\','.$style.');
		</script>';
		}*/
	printer::pclear(100);
	if ($this->new_page_effect&&!$this->no_prev_page)   print ('</div><!--holdback--></div><!--holder_.. used for fading display-->');
	
	$data = ob_get_contents();
	
		//file_put_contents('checkout.txt',$data);
	ob_end_clean();
	if (!$this->no_prev_page&&!$this->page_source ){  
		$json[]=str_replace('  ',' ',$data);
		$json[]=$this->preload;
		if ($this->new_page_effect&&$this->navigated){
			$json[]=$this->data;
			}
		echo  json_encode($json); exit();
		}  
	 print $data;
	 ($this->page_source)&& print '</div><!--End holder--> ';

  #****************display gallery*****************************
	}//end render_body

public static function instance(){ if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);//static allows it to create an instance without creating a new object
     if  (empty(self::$instance)) {
	   self::$instance = new expandgallery(); 
        } 
    return self::$instance; 
    }    

}//end class contact_master
?>