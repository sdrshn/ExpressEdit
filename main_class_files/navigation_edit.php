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
function nav_order($no){  //mainmenu_2_38|mainmenu_1_38
	$mysqlinst=mysql::instance();
	$mysqlinst->dbconnect();
     $navobj=navigate::instance(); 
	$nav_arr=explode('|',$no);
	$q='update '.Cfg::Directory_dir." set dir_time='".time()."',token='".mt_rand(1,mt_getrandmax())."', dir_temp='temp'";   
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);  
	if (explode('_',$nav_arr[0])[0]=='mainmenu'){    
		if (count($nav_arr)<2){
               $msg='Your Nav Menu Needs 2 Links to Sort!';
               mail::alert($msg);
               return;
               }
		foreach ($nav_arr as $key=>$nav){ 
			$na=explode('_',$nav);
			$key++;
			$dmid=$na[2]; 
			$q='update '.Cfg::Directory_dir." set dir_time='".time()."',token='".mt_rand(1,mt_getrandmax())."', dir_temp='".$key."' where dir_menu_order='".$na[1]."' AND dir_menu_id='$dmid'"; 
			$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); 
			}
		$q2='update '.Cfg::Directory_dir.' set dir_time=\''.time()."',token='".mt_rand(1,mt_getrandmax())."',dir_menu_order=dir_temp where  dir_temp !='0' and dir_menu_id='$dmid'";    
		$mysqlinst->query($q2,__METHOD__,__LINE__,__FILE__,false); 
		}
	else  if (explode('_',$nav_arr[0])[0]=='submenu'){   
		if (count($nav_arr)<2){
               $msg='Your Sub Nav Menu Needs 2 Links to Sort!';
               mail::alert($msg);
               printer::alert($msg);
               return;
               }
          $qtab='';
		foreach ($nav_arr as $key=>$nav){
			$na=explode('_',$nav);
			$key++;
			$dmid=$na[3];
			$q='update '.Cfg::Directory_dir.' set dir_time=\''.time()."',token='".mt_rand(1,mt_getrandmax()).'\', dir_temp=\''.$key.'\' where dir_menu_order=\''.$na[1].'\'  AND dir_sub_menu_order=\''.$na[2]."' AND dir_menu_id='$dmid'";  
			$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);$qtab.=NL.$q;
			}
		$q2='update '.Cfg::Directory_dir.' set dir_time=\''.time()."',token='".mt_rand(1,mt_getrandmax())."',dir_sub_menu_order=dir_temp where  dir_sub_menu_order >0 and dir_menu_order='".$na[1]."' and dir_menu_id='$dmid'";   
		$mysqlinst->query($q2,__METHOD__,__LINE__,__FILE__,false); process_data::log_to_file($qtab.NL.$q2);
		}
	else  {
		$msg='Error in Navigate_edit parse li element';
		mail::alert($msg);
		exit($msg);
		} 
	return array($dmid,$na[0],$na[1]);			
	}//end function nav_order

function process_pdf(){
      
$max_upload = (ini_get('upload_max_filesize')<10000)?(int)(ini_get('upload_max_filesize')):(int)(ini_get('upload_max_filesize')/1000000);
     $max_post = (ini_get('post_max_size')<10000)?(int)(ini_get('post_max_size')):(int)(ini_get('post_max_size')/1000000); 
     $config=((int)Cfg::Upload_max_filesize<10000)?(int)Cfg::Upload_max_filesize:(int)Cfg::Upload_max_filesize/1000000;//see Cfg_master.class.php 
     $upload_mb = $config;
     $max=$upload_mb*1000000;
     $maxup=min($max_upload,$max_post); 
     $instructions="Maximum filesize of  $maxup  Mb has been exceeded.";
     $instructions.= ' Only the filetypes '.Cfg::Valid_pdf_ext.' will work';
list ($uploadverification,$fiupl)=upload::upload_file(Cfg::Valid_pdf_mime,Cfg::Valid_pdf_ext,$instructions,Cfg_loc::Root_dir);
     if ($uploadverification='true')   
          printer::alert_pos('Success. Check to see if your pdf file has been uploaded to your site root directory.');
     else {
          printer::alert_neg('Upload verification of pdf file failed to load to home directory'); 
		  
	    }
	}
     
function menu_add_item($dir_menu_id,$dir_menu_order,$dir_sub_menu_order,$sub,$title=''){
	//echo "<p>$dir_menu_id is dmi,$dir_menu_order is dmo ,$dir_sub_menu_order is dsmo ,$sub is sub</p>";
     $mysqlinst=mysql::instance();
     $mysqlinst->dbconnect(); 
     $page_table=Cfg::Master_page_table;
     $directory_table=Cfg::Directory_dir;
     $page_arr=array();
     $print_arr=array(); 
	$link=($sub)?'SUB-MENU': 'MAIN MENU';
	show_more('Add NEW '.$link.' links Here', 'Add <span class="  italic">NEW '.$link.'</span> links Here','editbackground white fs2white floatleft');
echo '<div class="navbackground fsm2redAlert">';
	echo '<fieldset class="fs5navy"><!--Add Link--><legend>Add '.$link.'</legend>';
	printer::alertx('<p class="fsminfo editfont editcolor editbackground">Note: This is To Add a New Page Already Created But Not Yet in This Menu. Otherwise Visit the Link at the Top of Any Regular Page To Create A New Page</p>');
	if ($sub) 
          printer::alertx('<p class="info left fsminfo editbackground floatleft" title="Sub Links are Hidden Links That Appear When the Cursor Hovers Over Them">Choose From the Options Below for Adding a New Sub-menu Link under the main Link: '.$title.'</p>');
	else printer::alertx('<p class="floatleft left fsminfo editfont editcolor editbackground">Choose From the Options Below for Adding a New Main Link</p>');
	printer::pclear();
	printer::printx('<p class="fsminfo editcolor editfont editbackground">Note: New Pages Are Created On the Create New Page Link at the top of every Page Edit</p>');   
     $q="select distinct page_ref,page_title from $page_table order by page_ref ASC";
     $r = $mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
     if (!$mysqlinst->affected_rows()){ mail::alert('No Pages Created. Create a Page First'.__line__,__file__); return;}
     $x=1;
     while (list($page_ref,$page_title) = $mysqlinst->fetch_row($r,__LINE__)){
           
           $page_arr[]=$page_ref;
           $add_table=' <p class="pos whitebackground"><input   value="'.$dir_menu_id.'_x_'.$dir_menu_order.'_x_'.$dir_sub_menu_order.'_x_'.$page_ref.'" type="checkbox" name="menu_add_newpage[]" >&nbsp;Add:&nbsp;</p> ';
           
            
           
           $print_arr[]=array('ADD'=>$add_table,'Page Table Reference'=>$page_ref,'Current Page Title'=>$page_title);
          }
     printer::pclear(5);
     printer::alertx('<p class="fsminfo editbackground editcolor editfont floatleft">This Table Lists the Created Pages and a Default Title Which You May Alter Later.  Note: Titles may Be Changed Without Affecting  Different  Titles to the same Page in a Different Menu');
     printer::horiz_print($print_arr,'','','','',false);
	if(count($page_arr)<1) 
		printer::alert('You Have no New Pages Created. New Pages are Pages that have been created but not yet Added to  any Menu. You May Create a New Page From the  New Page Link at the top of every Navigation Menu on the EditPages',1.2,'navy');
	printer::pclear(9); 
	show_more('Other Options', 'Close Other Options','white fs2white editbackground floatleft','Link to External Site, Link to Internal PDF or HTML Page, Upload Internal Page'); 
     printer::print_wrap('other ops','info',false,'nativeback editcolor editfont');
	show_more('Add Navigation Menu Link to an External Website', '','white fs1info editbackground','This Link Will Take Your Website Viewer Off Your Own Site');
     printer::print_wrap('External website add link','info',false,'nativeback editcolor editfont');
	printer::print_info('Generally Links to Other Sites are made in Your Text.  However You May Wish to Create a Formal Menu Link To a Related Company or Personal Site of Your Own,Etc!','','navy');
	printer::alertx('<p class="opacitybackground black floatleft">Enter the url address of the External Link. http:// will be appended automatically if you do not include it ie www.mysite.com<input type="text" name="add_external_link_url['.$dir_menu_id.'_x_'.$dir_menu_order.'_x_'.$dir_sub_menu_order.']" value="" size="60" maxlength="100"></p>');
	printer::alert('Enter the title of the External Link. <textarea class="utility"  name="add_external_link_name['.$dir_menu_id.'_x_'.$dir_menu_order.'_x_'.$dir_sub_menu_order.']" style="width:90%;" rows="3" cols="50" ></textarea>');
     printer::close_print_wrap('add external link');
	echo '</div><!--close show_more External Link-->';  
	printer::pclear(2); 
	 
	show_more('Add a Navigation Link to an Uploaded PDF file', 'Close add PDF Link','editcolor editbackground');
     printer::print_wrap('pdf link','info',false,'nativeback editcolor editfont');
	printer::alert('Go To Upload a PDF file <a style="color:#'.Cfg::Navy_color.';"  href="#uploadpdf"  onclick="return gen_Proc.scroll_to_view(\'uploadpdf\');" >Here</a>','','navy');
	printer::alertx('<p class="opacitybackground black">Enter the filename of the Uploaded PDF file: ie myfile.pdf<input type="text" name="add_internal_link_filename['.$dir_menu_id.'_x_'.$dir_menu_order.'_x_'.$dir_sub_menu_order.'" value="" size="60" maxlength="60"></p>');
	printer::alertx('<p class="opacitybackground black">Enter the title for Your PDF link. <textarea class="utility"  name="add_internal_link_title['.$dir_menu_id.'_x_'.$dir_menu_order.'_x_'.$dir_sub_menu_order.']" style="width:90%;" rows="3" cols="50" ></textarea></p>');     
     printer::close_print_wrap('add pdf');
	echo '</div><!--close show_more Internal Link-->'; 
	 
     printer::print_wrap('add pdf link','info',false,'nativeback editcolor editfont');
	echo '<p class="left small floatleft"><a class="black opacitybackground" href="#uploadpdf"  onclick="return gen_Proc.scroll_to_view(\'uploadpdf\');" >GoTo Upload a PDF file</a></p>';
     
     printer::close_print_wrap('add pdf link'); 
     printer::close_print_wrap('other opts');
	echo '</div><!--close show_more Other Options-->';  
	 echo '</div><!--close show_more Add Link-->';
     submit();
	echo '</div><!--class="navbackground fsm2redAlert"-->';
	printer::pclear();
     submit();
	}
	
function sort_box($dir_menu_id,$menutype,$mo){
	$subsort=($menutype=='submenu')?" AND dir_menu_order='$mo' ":'';
	$orderby=($menutype=='submenu')?'dir_sub_menu_order':'dir_menu_order';
	$smo=($menutype=='submenu')?' > 0 ':'=0 ';
	$mysqlinst=mysql::instance();
	$mysqlinst->dbconnect();
	$q="select dir_menu_order,dir_sub_menu_order,dir_title from ".Cfg::Directory_dir." where dir_menu_id='$dir_menu_id' $subsort AND dir_sub_menu_order$smo order by $orderby asc";   
	$r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true); 
	$output='';
	while (list($dir_menu_order,$dir_sub_menu_order,$dir_title)=$mysqlinst->fetch_row($r,__LINE__)){
		$dsmo=($menutype=='submenu')?intval($dir_sub_menu_order).'_':'';
		$dir_title=process_data::clean_sort($dir_title);
		While (strlen($dir_title)<36)$dir_title.='*';
		$line1=process_data::restore_sort(substr($dir_title,0,18));
		$line2=process_data::restore_sort(substr($dir_title,18,36));  
		$output.= '<li class="box" id="'.$menutype.'_'.intval($dir_menu_order).'_'.$dsmo.$dir_menu_id.'">'.$line1.'<br>'.$line2.'</li>';
		}//end while     ////id="submenu_'.intval($dir_menu_order).'_'.intval($dir_sub_menu_order).'_'.$dir_menu_id.'"
	return $output;
	}
	
function show_more($msg_open,$msg_close='close',$class='',$title='',$border=false){ if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__); 
	static $show_more=0; $show_more++; //echo 'show more is '.$this->show_more; 
	$msg_open_mod=str_replace(array('<','>'),'',$msg_open);
	$msg_close_mod=str_replace(array('<','>'),'',$msg_close);
	
	if (strpos($msg_close,'<span')!==false){ 
		$msg_open=$msg_close;
		}
	$class=(!empty($class))?$class:'editbackground white floatleft cursor buttonekblue';
	//$border=($border)?' fs2'.$this->column_lev_color:'';
    echo '<p class="cursor underline fs1info rad5 '.$class.'" title="'.$title.'" onclick="gen_Proc.show(\'show'.$show_more.'\',\''.$msg_open_mod.'\',\'\');" id="show'.$show_more.'">'.$msg_open.'</p>';
    printer::pclear(1);
    echo '<div class="floatleft floatleft" id="show'.$show_more.'t" style="display: none; "><!--'.$msg_open.' openshowtrack'.$show_more.'-->';
    } 
     
function submit(){
    echo '<p><input class="rad5 editbackground editcolor fs1pos" type="submit" name="submit" value="SUBMIT CHANGES" ></p>';
    }
    
$mysqlinst=mysql::instance();
$mysqlinst->dbconnect();
if (isset($_GET['update_sort_submit'])){   
	if (empty($_GET['update_sort_submit'])){mail::alert('problem with update_sort_list');die();}
	$json_arr=array();  
	list($dmid,$menutype,$mo)=nav_order($_GET['update_sort_submit']);
	
	$json_arr[]='passfunct';
	$json_arr[]='refresh';
	$json_arr[]='';  
	echo json_encode($json_arr);
	exit(); 
    } 
if (isset($_GET['request']))printer::print_request();
if (isset($_POST['nav_send'])){
	$nav_order=$_POST['nav_send'];
	if (empty($nav_order))mail::alert('Empty Nav Order Received');
	else  nav_order($nav_order);
	}
$sess=new session();
$dir_fields=Cfg::Dir_fields;
$dir_fields_arr=explode(',',$dir_fields);
$directory_table=Cfg::Directory_dir;
$page_table=Cfg::Master_page_table;
$navobj=navigate::instance();
$ext=$navobj->ext;
$dir_ref_arr=array();
$included_arr=array();
$excluded_arr=array();
$master_gall_table=Cfg::Master_gall_table;
$navobj=navigate::instance();
$pgtbn=request::check_request_data('pgtbn'); 
$table_ref=request::check_request_data('table_ref');
$postreturn=request::check_request_data('postreturn');
$style=request::check_request_data('style');
$ttt=request::check_request_data('ttt');
$order=request::check_request_data('order');
$css=request::check_request_data('css');// css provides current styling for the add_page_pic_core.php page
$css=(!empty($css))?$css:Cfg_loc::Root_dir.'addeditmaster'; 
$dir_menu_id=request::check_request_data('menuid'); 
$data=request::check_request_data('data');
$navstyle=request::check_request_data('style');
if (empty($postreturn)){
     if (Sys::Loc){
          print_r(get_defined_vars());
          mail::alert('empty postreturn');
          exit;
          }
     
     mail::alert('empty postreturn');
	$refer=new redirect;
	$refer->page_referrer_redirect("!MISSING POST INFORMATION: TRY AGAIN!", '', $sess->page_referrer_2,'true'); 
	}
if (empty($dir_menu_id)){
	$refer=new redirect;
	$refer->page_referrer_redirect("MISSING NAV INFORMATION: TRY AGAIN!!!!" , '', $sess->page_referrer_2,'true');
	}
$load=new fullloader();
$load->fullpath('transitional.nometa.php'); 
echo'
<script language="JavaScript" type="text/javascript" src="'.Cfg_loc::Root_dir.'scripts/jquery.min.js"></script>
<script language="JavaScript" type="text/javascript" src="'.Cfg_loc::Root_dir.'scripts/tool-man/core.js"></script>
<script language="JavaScript" type="text/javascript" src="'.Cfg_loc::Root_dir.'scripts/tool-man/events.js"></script>
<script language="JavaScript" type="text/javascript" src="'.Cfg_loc::Root_dir.'scripts/tool-man/css.js"></script>
<script language="JavaScript" type="text/javascript" src="'.Cfg_loc::Root_dir.'scripts/tool-man/coordinates.js"></script>
<script language="JavaScript" type="text/javascript" src="'.Cfg_loc::Root_dir.'scripts/tool-man/drag.js"></script>
<script language="JavaScript" type="text/javascript" src="'.Cfg_loc::Root_dir.'scripts/tool-man/dragsort.js"></script>
<script  src="../scripts/gen_Procscripts.js?19188?28088"></script>
<script    src="../scripts/gen_Proceditscripts.js"></script>
<link href="../styling/gen_edit.css" rel="stylesheet" type="text/css" >
<link href="'.Cfg_loc::Root_dir.Cfg::Style_dir.'gen_page.css" rel="stylesheet" type="text/css" > 
<link href="'.$css.'.css" rel="stylesheet" type="text/css" > 
<link href="'.$css.'pageedit.css" rel="stylesheet" type="text/css" >
<link  href="'.Cfg_loc::Root_dir.Cfg::Style_dir.'utility.css"  rel="stylesheet" type="text/css" >
<link rel="stylesheet" type="text/css" href="'.Cfg_loc::Root_dir.'scripts/tool-man/common.css">
<link rel="stylesheet" type="text/css" href="'.Cfg_loc::Root_dir.'scripts/tool-man/lists.css">
<!--	//tool-man  dragsort related  js created by Tim Taylor Consulting <http://tool-man.org/>  and is modified for Ajax Response-->
<script language="JavaScript" type="text/javascript"><!--
 	var dragsort = ToolMan.dragsort()
	var junkdrawer = ToolMan.junkdrawer()';
	echo '
	window.onload = function() {
		dragsort.makeListSortable(document.getElementById("sort1"))
		';
	$q="select page_title from  master_page where page_ref='$table_ref' limit 1"; 
	$r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	list($page_title)=$mysqlinst->fetch_row($r,__LINE__);
	$q="select dir_menu_order from $directory_table where dir_menu_id='$dir_menu_id' AND dir_sub_menu_order=2 order by dir_menu_order asc"; 
	$resource1=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	if ($mysqlinst->affected_rows()){
		//mysqli_data_seek($resource1, 0) ;
		while (list($dir_menu_order)=$mysqlinst->fetch_row($resource1,__LINE__)){ //#java id,self,changeId,style,sortid
			echo '
			dragsort.makeListSortable(document.getElementById("subsort_'.intval($dir_menu_order).'"))  
			';
			}//end while
		}//if affected
	echo ' 
		}//onload
	//-->
</script>
<script type="text/javascript" >
gen_Proc.tiny_cache=[];//set init not used in nav_edit..
function checkpdffiles(f){ 
    f = f.elements;
    if(/.*\.(pdf)$/.test(f["upload"].value.toLowerCase())){ 
	    return true;
	   }
    alert("file chosen is " + f["upload"].value + " Please Upload pdf Files Only.");
    f["upload"].focus();
    return false;
    }//end js function
function gotoid(id){ 
	document.getElementById(id).style.display ="block";	
	document.getElementById(id).focus();
	return true;
	}
    </script>
<style type="text/css" >
body, div, textarea, p {background:#accecd;color:black}
.editbackground {background:#687867;}
.navbackground {background:#accecd;}
.editcolor {color:white;}
.nativeback {background:#accecd;}
.nav_gen{padding:12px;}
input {color:black;}
div .black, ul .black, div textarea, div li, textarea.black, div input {color:#333;}
html div input {background-color:#c5c8c5;}
#containbackto {float:left;width:100px;}
.backto { position:absolute; top: 0px; left: 0px; background:#fff; filter:alpha(opacity=50);opacity:.5; 
  width:100%; height:100%; padding:   .5rem 0 .5rem 0;
  -moz-border-radius:3px; -webkit-border-radius:3px; border-radius:3px;}
.navbackto{border: solid black 2px; padding:7px; background:white; float:left;  
  font-size: 16px; text-decoration:underline;  color: #4F0D7F; 
 width:220px; margin-top:30px;    }
.backtoborder{ position:absolute; top: 0px; left: 0px;
 width:100%; height:100%; padding:   .5rem 0 1rem 0;
 -moz-border-radius:3px; -webkit-border-radius:3px; border-radius:3px;
-moz-box-shadow: 1px 1px 5px -4px #0a2268;
-webkit-box-shadow: 1px 1px 5px -4px #0a2268;
box-shadow: 1px 1px 5px -4px #0a2268; 
	     } 
</style>
</head>
<body>
<div style="max-width:1000px;margin:0 auto;padding-top:10px;">';
(isset($_POST['pagepdfsubmitted']))&&process_pdf();
$url=$postreturn.'?#'.$data;
echo'<div id="topoutmenu" title="Page Top"  onclick="window.scrollTo(0,0);return false;">&#9650;</div></div><!--close topmenu-->';
echo '<p class="navbackto"><a href="'.$url.'">Back to '.$page_title.'</a></p>';
printer::pclear(5);
 show_more('GoTo Edit Link Directory');
echo '<div class="navbackground fsm2redAlert">';
printer::print_info('Go To Edit Links');
$q="select dir_menu_order,dir_sub_menu_order,dir_title,dir_ref from ".Cfg::Directory_dir." where dir_menu_id='$dir_menu_id'  order by dir_menu_order asc,dir_sub_menu_order asc";
$r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true); 
while (list($dir_menu_order,$dir_sub_menu_order,$dir_title,$dir_ref)=$mysqlinst->fetch_row($r,__LINE__)){
     if ($dir_sub_menu_order>0){
          $space='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
          $type='sub_';
          }
     else {
          $space='';
          $type='main_';
          }
     printer::alertx('<p class="clear opacitybackground floatleft">'.$space.'<a class="cursor black underline" href="#'.$type.$dir_title.'">'.$dir_title.' ref:'.$dir_ref.'</a></p>');
     }
     printer::pclear();

echo '</div><!-- class="navbackground"-->';
echo '</div><!--show close choose goto menu-->'; 
 
$q2="select distinct dir_menu_id from $directory_table where dir_menu_id !='$dir_menu_id'";
$r2=$mysqlinst->query($q2,__METHOD__,__LINE__,__FILE__,false);
if ($mysqlinst->affected_rows()){
     printer::pclear(40);
     show_more('Choose Different Menu', ' ','fsminfo editcolor editbackground floatleft','You Can change Menu while keeping Old Styling!!'); //menu created
     echo '<div class="editbackground editcolor editfont"><!--lightgreenbackground choose dif menu-->';
     printer::printx('<form  enctype="multipart/form-data" action="'.$postreturn.'" method="post" onSubmit="return edit_Proc.beforeSubmit()" >');
     printer::printx('<p class="fsminfo editcolor editbackground floatleft">Change to Different Menu. Allows you to preserve all styles and Configurations for current Menu while changing Links Only !!</p>'); 
     printer::pclear(3);
          while (list($ndir_menu_id)=$mysqlinst->fetch_row($r2)){
          echo '<div class="fs1gray  pb10 editbackground"><!--choose menu-->';
          printer::alertx('<p class=""><input type="radio" value="'.$ndir_menu_id.'"  name="'.$data.'_blog_data1_arrayed">Use Menu Id: '.$ndir_menu_id.' Instead </p>');
          $navobj->no_icon=true;
          $navobj->render_menu($ndir_menu_id,'utility_horiz',false);
          echo '</div><!--end choose menu-->';
          printer::pclear(2);
          }//end while
     printer::printx('<p class="center"><input class="rad5 fs3pos editcolor editbackground" type="submit" name="submit" value="Submit Menu Switch" ></p>
     <p><input  type="hidden" name="submitted" value="true" ></p>
     </form>');
     printer::pclear(10);
     echo '</div><!--lightgreenbackground choose dif menu-->';
     echo '</div><!--show close choose diff menu-->';
     }//affected rows 
printer::pclear();	
show_more('Select Entire Menus to Delete', ' ','floatleft white editbackground fsmoldlace rad5 smaller','',800); //menu created
echo '<div class="editbackground editcolor"><!--lightredAlertbackground choose dif menu-->';
printer::printx('<form  enctype="multipart/form-data" action="'.$postreturn.'" method="post" onSubmit="return edit_Proc.beforeSubmit()" >');
printer::pclear();
printer::printx('<p class="fsminfo editcolor editbackground floatleft">You Can Delete Unneeded Menus Here</p>'); 
printer::pclear();
$q3="select distinct dir_menu_id from $directory_table";
$r3=$mysqlinst->query($q3,__METHOD__,__LINE__,__FILE__,false);
if ($mysqlinst->affected_rows()){
     while (list($ndir_menu_id)=$mysqlinst->fetch_row($r3)){
          echo '<div class="fs1color floatleft pb10 editbackground"><!--choose menu-->';
          printer::alertx('<p class="red"><input type="checkbox" value="delete"  name="delete_nav_menu['.$ndir_menu_id.']">Delete Menu Id: '.$ndir_menu_id.' </p>');
          $navobj->no_icon=true;
          $navobj->render_menu($ndir_menu_id,'utility_horiz',false);
          echo '</div><!--end choose menu-->';
          printer::pclear(2);
          }//end while
     }//if menu id exists
printer::pclear();
printer::printx('<p class="center"><input class="rad5 fs3red editcolor editbackground" type="submit" name="submit" value="Submit Delete Menu" ></p>
<p><input type="hidden" name="submitted" value="true" ></p>
</form>');
printer::pclear();
echo '</div><!--lightredAlertbackground choose dif menu-->';
echo '</div><!--show_close-->';//menu created
printer::pclear();
$count=$mysqlinst->count_field($directory_table,'dir_menu_id','',false,"where dir_menu_id='$dir_menu_id' AND dir_sub_menu_order=0 ");
if ($count>0){ 
	printer::alertx('<p class="fsminfo inline center editcolor editbackground">Your Menu for Editing is below</p>'); 
	printer::pclear(7);
	//$passnavclass=(isset($_GET['passnavclass']))?$_GET['passnavclass']:'';
	echo '<div class="'.$data.'">';
	$navobj->no_icon=true;
     $navobj->render_menu($dir_menu_id,$navstyle);
	echo '</div>';
	printer::pclear(7);
	if ($count>1){
		printer::pclear();
		 
		
		echo '
		<div style=" text-align:left;  display:inline-block; margin-bottom:30px; border:3px solid white;  padding: 20px 60px" ><!--Sorting-->';
		printer::print_tip('Caution: Updating main or sub menus will submit only menu link order change');
		echo'
		<p>Drag Link To ReOrder Main Menu List. </p>
		<ul id="sort1" class="boxes">';//#sort
		echo sort_box($dir_menu_id,'mainmenu',1); 
		echo '</ul>';
		printer::pclear(10);
		echo '<p><button class="button cursor" type="button" onclick="edit_Proc.sendListOrder(\'sort1\',\''.Sys::Self.'\');">Update Main Menu ReOrder</button></p>';
		echo '</div><!--Sorting-->';
		
		 
		printer::pclear(10);
		}
	echo '
	 <div class="white editfont"  style=" width:700px; float:left;   border:3px solid '.Cfg::RedAlert_color.';  padding: 10px 30px 60px 30px;">
	<form  enctype="multipart/form-data" action="'.$postreturn.'" method="post" onSubmit="return edit_Proc.beforeSubmit()" >';
	
	printer::alertx('><p class="info editbackground floatleft fsminfo left " title="Each Menu has its id and this post will use Menu ID#'.$dir_menu_id.'">Editing Menu Id'.$dir_menu_id.' </p>');
	printer::pclear(5);
	
     printer::pclear();
     $count2=$mysqlinst->count_field(Cfg::Directory_dir,'dir_filename','',false,"where dir_filename='index'"); 
     if ($count>0&&$count2 <1)printer::printx('<p class="fsminfo neg floatleft whitebackground"><!--No Opening/Home-->No Opening/Home page has been Selected.  Select Your Home/Opening Page:</p>'); 
     echo '<div class=""><!--change home page-->';
     show_more('Select Opening/home page','Close Change Your Opening Page','fs2white editbackground white floatleft');
     printer::print_wrap('select','info',false,'nativeback editcolor editfont');
     $q="select dir_external,dir_internal,dir_filename,dir_title,dir_menu_order from ".Cfg::Directory_dir." where dir_menu_id='$dir_menu_id' AND dir_sub_menu_order=0 order by dir_menu_order asc";
     $r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
     printer::alertx('<p class="info floatleft editbackground fs1info" title="When your web address is typed in it first goes to the Opening Page.  You may also change Your home page and old home page titles below">Choices Available: </p>');
     while ($rows=$mysqlinst->fetch_assoc($r,__LINE__)){
          $dir_filename=$rows['dir_filename'];
          $dir_title=process_data::remove_line_break($rows['dir_title']);
          $dir_menu_order=$rows['dir_menu_order'];
          $dir_external=$rows['dir_external'];
          $dir_internal=$rows['dir_internal'];
          $checked=($dir_filename==='index')?'checked="checked"':''; 
          (!$dir_internal&&!$dir_external)&&printer::alertx('<p class="clear opacitybackground black floatleft"><input type="radio" value="'.$dir_menu_id.'_'.$dir_menu_order.'_0" '.$checked.' name="dir_change_homepage">'.$dir_title.'</p>');
          }//end while
     printer::close_print_wrap('select');
     echo '</div><!--show_more home page-->';
     echo '</div><!--end change home page-->';
     printer::pclear(5);
	submit();
     printer::pclear(5);
     if ($count>0&&$count2 <1)printer::printx('</div><!--No Opening/Home-->');
     $q="select $dir_fields from $directory_table where dir_menu_id='$dir_menu_id' AND dir_sub_menu_order=0 order by dir_menu_order asc";
     $r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
     $mainlink=0;
     while ($rows=$mysqlinst->fetch_assoc($r,__LINE__)){//main menu while
          $mainlink++;
          printer::pspace(7);
          for ($i=0;$i<count($dir_fields_arr);$i++){  
               ${$dir_fields_arr[$i]}=process_data::remove_line_break($rows[$dir_fields_arr[$i]]);
               }
          ($mainlink===1)&& menu_add_item($dir_menu_id,($dir_menu_order-.5),0,false,false);
           printer::pspace(15);
          echo '<fieldset id="main_'.$dir_title.'"class="border7 borderridge pos"><!--Surround While Link fields--><legend></legend>';
          printer::pclear(4);
          printer::alertx('<p class="editbackground info inline fsminfo" title="This refers to the visible Title Name of  your Menu Link: ie '.$dir_title.' for this page.">Change the Title of The <b>Main Menu Link</b> Having the Title: </p>');
          printer::pclear();
         
          printer::alertx('<textarea class="black large"  style="width:90%;" name="dir_title_'.$dir_menu_id.'_'.intval($dir_menu_order).'_'.intval($dir_sub_menu_order).'" rows="3" cols="50" onkeyup="gen_Proc.autoGrowFieldScroll(this)">' . process_data::remove_characters($dir_title).'</textarea>');
          printer::pclear(2);
          printer::printx('<p class="left whtebackground black fsminfo floatleft"> Or  Upload a Link Image instead of using the Text Title. Note: Use Exact Size Image. Will not be resized. &nbsp;<a href="add_page_pic.php?wwwexpand=0&amp;www=0&amp;ttt='.intval($dir_menu_order).'&amp;fff='.intval($dir_sub_menu_order).'&amp;id='.$dir_menu_id.'&amp;id_ref=blog_id&amp;postreturn='.request::return_full_url().'&amp;css='.$css. '&amp;sess_override&amp;"><u>Upload Here</u></a></p>');
          printer::pclear();
          show_more('Info','close Tech Info','editbackground info small fs2info floatleft','click for mysql directory tech info');
          printer::print_wrap('info','info',false,'nativeback editcolor editfont floatleft');
          printer::alertx('
          <strong> <em>Info For Developers</em></strong><br>
          <strong> Navigation Title </strong>  <br>
          field: dir_title, value: '.$dir_title.'<br>
          <strong>The  URL filename for this page</strong><br>
          field: dir_filename,value: '.$dir_filename.' ('.$ext.')<br>
          <strong>The Directory data reference for this entry</strong><br>
          field: dir_ref, value: '.$dir_ref.' <br> <em>AND references to: </em><br>
          field page_ref in '.Cfg::Master_page_table.' table<br>
          <em>The Directory table</em>: '.Cfg::Directory_dir); 
           printer::close_print_wrap('info');
          echo '</div><!--show_more Mysql Info-->'; 
          printer::pclear(2);
          if ($dir_external)printer::alertx('<p class="information" title="Change Your External URL (You may include the http://  for external site  reference ).">Change Your external URL address<input type="text" value="'.$dir_filename.'" size="60" maxlength="60" name="dir_filename_'.$dir_menu_id.'_'.intval($dir_menu_order).'_'.intval($dir_sub_menu_order).'"></p>');
          elseif ($dir_internal)printer::alertx('<p class="information" title="Change Your Internal URL (Make  sure  you have uploaded a file and have the correct filename entered. Valid filetypes are (.html and .pdf ).
          (without the http://) here">Change Your Internal Menu Link address to an uploaded PDF or HTML PAGE ONLY<input type="text" value="'.$dir_filename.'" size="60" maxlength="60" name="dir_filename_'.$dir_menu_id.'_'.intval($dir_menu_order).'_'.intval($dir_sub_menu_order).'"></p>');
          elseif ($dir_filename!=='index'){
               show_more('Advanced Option Filename', 'close advanced option filename','editbackground fs2white whitecolor floatleft');
               printer::print_wrap('Advanced Option Filename');
               printer::print_warn('Caution: Filenames only appear in the url address bar and generally go unnoticed.  However, Changing  the URL FILENAME  of the page will effect your search engine maximization, and render links that people have stored to your page useless');
               printer::pclear();
               printer::alertx('<p class="info" title="Currently the URL filename is '.$dir_filename.' (.'.$ext.')">Advanced Option: Change the Menu Link filename of this Link<input class="editfont black" type="text" value="'.$dir_filename.'" size="60" maxlength="60"
               name="dir_filename_'.$dir_menu_id.'_'.intval($dir_menu_order).'_'.intval($dir_sub_menu_order).'"></p>');
               printer::close_print_wrap('Advanced Option Filename');
               echo '</div><!--close show_more dir_filename-->'; 
               printer::pclear(2);
               }//  ! index #1
          if ($dir_is_gall){
               printer::alert('<a href="'.$dir_filename.$ext.'">Click Here To Add and Delete Galleries that are Under the link:&nbsp;<span class=""> '.$dir_title.'</span></a>');
               echo '</fieldset><!--close fieldset for Link-->';
               printer::pspace(40);
               continue;
               }
          $count2=$mysqlinst->count_field($directory_table,'dir_sub_menu_order','',false,"where dir_menu_id='$dir_menu_id' AND dir_menu_order='$dir_menu_order' AND dir_sub_menu_order > 0 ");
          $count3=$mysqlinst->count_field($master_gall_table,'galleryname','',false,"where gall_ref='$dir_gall_table'");
          $msg=($count2>0)?'AND The Next Sub-Menu Link under this  Dropdown Menu will assume this position':'';
          if ($dir_filename==='index'){
               printer::print_warn('YOU CANNOT DELETE THE OPENING/HOME PAGE. CHOOSE A NEW OPENING/HOME PAGE ABOVE FIRST',1);
               }
          else {
               printer::alertx('<p class="editbackground  whitecolor floatleft fs2white"><input type="checkbox" name="nav_delete[]"   value= "'.$dir_menu_id.'_'.$dir_menu_order.'_'.$dir_sub_menu_order.'">Delete this Main Menu Link '. $msg.'</p>');
               } // not index page
          printer::pclear(2);
          if ($count2 > 0){
               echo '<fieldset class="borderridge black border6 "><!--submenu border--> <legend class="black">Begin Sub Menu Link(s)</legend>'; 
               printer::alertx ('<p class="marginauto pt10 center inline fsminfo editbackground info"> Edit the Dropdown Sub-Menu Links under the Menu link '.$dir_title.' </p>');
               if ($count2>1){
                    printer::pclear();
                    echo '<div  style=" color:black; text-align:left;    border:3px solid '.Cfg::RedAlert_color.';  padding: 10px 30px 30px 30px;" ><!--Sorting-->';
				printer::print_tip('Caution: Updating main or sub menus will submit only menu link order change');
                    echo
				'<p>Drag Link To ReOrder This Sub Menu List</p>
                         <ul id="subsort_'.intval($dir_menu_order).'" class="boxes">';
                         echo sort_box($dir_menu_id,'submenu',$dir_menu_order);
                    echo '</ul>';
                    printer::pclear();
                    echo '<p><button class="button cursor" type="button"   onclick="ToolMan._junkdrawer.sendListOrder(\'subsort_'.intval($dir_menu_order).'\',\''.Sys::Self.'\');">Update This Sub Menu ReOrder</button></p>';
                    echo '</div><!--Sorting-->';
                    }
               
               $q="select $dir_fields from $directory_table where dir_menu_id='$dir_menu_id' AND dir_menu_order='$dir_menu_order' AND dir_sub_menu_order > 0 order by dir_sub_menu_order asc";
               $r2=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
               $submenunum=0;
               while ($rows2=$mysqlinst->fetch_assoc($r2,__LINE__)){//submenu while
                    $submenunum++;
                    printer::pspace(7);
                    for ($i=0;$i<count($dir_fields_arr);$i++){
                         ${$dir_fields_arr[$i].'_sub'}=process_data::remove_line_break($rows2[$dir_fields_arr[$i]]);
                         }
                     
                    printer::pclear(7);
                    submit();
                   ($submenunum<2)&&menu_add_item($dir_menu_id,intval($dir_menu_order_sub),(intval($dir_sub_menu_order_sub)-.5),true,$dir_title);//add link beginning of submenu!  
                    echo '<fieldset id="sub_'.$dir_title_sub.'" class="fsmwhite"><legend>Edit Sub Link</legend>';
                    printer::pclear(4);
                    printer::alertx('<p class="inline fsminfo editbackground info" title="Sub Menu Links are links that show (dropdown) when you hover over the main Links that are always visible.  The visible name is used as the title for this page">Change the Title of The <b>Sub-Menu</b> Link#'.$submenunum.':</p>');
                    printer::pclear();
                    printer::alertx('<textarea class="black larger"  style="width:90%;" name="dir_title_'.$dir_menu_id.'_'.intval($dir_menu_order_sub).'_'.intval($dir_sub_menu_order_sub).'" rows="3" cols="50"  
                    onkeyup="gen_Proc.autoGrowFieldScroll(this)">' . process_data::remove_characters($dir_title_sub).'</textarea>'); 
                    printer::pclear(2);
                    show_more('Info','close Tech Info','editbackground fs2info small floatleft info');
                    printer::print_wrap('info','info',false,'nativeback editcolor editfont floatleft');
                    printer::alert('<strong> <em>Info For Developers</em></strong><br>
                    <strong> Navigation Title </strong>  <br>
                    field: dir_title, value: '.$dir_title_sub.'<br>
                    <strong>The  URL filename for this page</strong><br>
                    field: dir_filename,value: '.$dir_filename_sub.' ('.$ext.')<br>
                    <strong>The Directory data reference for this entry</strong><br>
                    field: dir_ref, value: '.$dir_ref_sub.' <br> <em>AND references to: </em><br>
                    field page_ref in '.Cfg::Master_page_table.' table<br>
                    <em>The Directory table</em>: '.Cfg::Directory_dir); 
                    printer::close_print_wrap('info');
                    
                    echo '</div><!--show_more Mysql Info-->'; 
                    printer::pclear(2);
                    if ($dir_external_sub)printer::alertx('<p class="information" title="Change Your External URL (Be sure to include the http://  for external site  reference) or link to an uploaded PDF file ie myfile.pdf  (without the http://) here">Change Your external URL address or "Sub-Link" address to an uploaded PDF<input type="text" value="'.$dir_filename_sub.'" name="dir_filename_'.$dir_menu_id.'_'.intval($dir_menu_order_sub).'_'.intval($dir_sub_menu_order_sub).'"></p>');
                    elseif ($dir_filename_sub!=='index'){
                         show_more('Advanced Option: Filename', 'close advanced option filename','editbackground fs2white whitecolor floatleft');
                         printer::print_wrap('wrap filename','info',false,'nativeback editcolor editfont');
                         printer::print_warn('Caution: Filenames only appear in the url address bar and generally go unnoticed.  However, Changing  the URL FILENAME  of the page will effect your search engine maximization, and render links that people have stored to your page useless');
                         printer::pclear();
                         printer::alertx('<p class="info nativeback fsminfo black" title="Currently the URL filename is '.$dir_filename_sub.' (.'.$ext.')">Advanced Option: Change the filename of this Sub-Menu Link<input type="text" value="'.$dir_filename_sub.'" 	name="dir_filename_'.$dir_menu_id.'_'.intval($dir_menu_order_sub).'_'.intval($dir_sub_menu_order_sub).'" ></p>');
                         printer::close_print_wrap('wrap filename');
                         echo '</div><!--close show_more filename-->';
                         }//  ! index #1
                    else { 
                         show_more('Advanced Option: Filename', 'close advanced option filename','editbackground whitecolor floatleft');
                         printer::alert('This is Your Current Opening/home page. Please note  there is no option to change the opening/Home page link filename which is index (.php) You must first select a new Home page as all Home page filenames must be index (.php)');
                         echo '</div><!--close show_more filename !index-->'; 
                         }//        else ! index #2
                    printer::pclear(2); 
                    printer::print_wrap('delete sub','info',false,'nativeback editcolor editfont');
                    printer::alert('<input type="checkbox" name="nav_delete[]"  value= "'.$dir_menu_id.'_'.intval($dir_menu_order_sub).'_'.intval($dir_sub_menu_order_sub).'" >Delete this  Dropdown Menu Sub-Menu Link'); 	
                     printer::close_print_wrap('delete sub');
                    printer::pclear();	
                    echo '</fieldset><!--close fieldset for Sub Link-->';
                    printer::pclear(2);	
                    }//end while dir sub menu
               printer::pclear(7);	
               menu_add_item($dir_menu_id,intval($dir_menu_order_sub),(intval($dir_sub_menu_order_sub)+.5),true,$dir_title);//add link end of submenu!
               printer::pclear(7);	
               echo '</fieldset><!--close fieldset for Edit Sub Menu Links-->';
               }// end count2 > 0
          else menu_add_item($dir_menu_id,$dir_menu_order,1,true,$dir_title);
          echo '</fieldset><!--close fieldset for Link-->';
           printer::pspace(20);
          }// end while main dir menu
     menu_add_item($dir_menu_id,$dir_menu_order+.5,($dir_sub_menu_order+.5),false,false);//add menu item end of main menu
     }
else {//empty count menu items
     echo '<form  enctype="multipart/form-data" action="'.$postreturn.'" method="post" onSubmit="return edit_Proc.beforeSubmit()" >';
     menu_add_item($dir_menu_id,0,0,false,false); //add first main menu!!
     }
submit();
echo '
<p><input type="hidden" name="nav_edit_submitted" value="'.$dir_menu_id.'" ></p>
</form>';
printer::pspace(7);
show_more('Add PDF Here','Close Add PDF','floatleft editbackground editcolor','','navedit_id');
$max_upload = (ini_get('upload_max_filesize')<10000)?(int)(ini_get('upload_max_filesize')):(int)(ini_get('upload_max_filesize')/1000000);
	$max_post = (ini_get('post_max_size')<10000)?(int)(ini_get('post_max_size')):(int)(ini_get('post_max_size')/1000000); 
	$config=(int)Cfg::Pdf_upload_max;//see Cfg_master.class.php 
	$maxup=min($max_upload,$max_post,$config);
     echo '
		Current php.ini limits and User Configurations:
		<table border="1"  class="fsminfo editcolor editbackground">
		<tr><th>upload max  <br> php.ini</th><th>post_max_size <br> php.ini</th><th>Cfg::Upload_max_filesize <br>Cfg_master.class.php or Cfg.class.php</th>
		</tr>
		<tr>
		<td>'.$max_upload.'Mb</td><td>'.$max_post.'Mb</td></td><td>'.$config.'Mb</td>
		</tr> 
		</table>
          <table  class="fsminfo editcolor editbackground">
		<tr><th><b>Upload filesize limit:</b></th></tr>
		<tr><td><b>'.$maxup.'Mb</b></td></tr>
		</table>';
     $maxbytes=$maxup*1000000;
printer::alert('Here you may upload a pdf that you can link to in Your menu. Begin by Uploading a PDF file Here',1.1,'navy');
echo '<form   enctype="multipart/form-data" action="'.request::return_full_url().'" method="post" onsubmit="return checkpdffiles(this); return edit_Proc.beforeSubmit();">
<p><input type="hidden" name="MAX_FILE_SIZE" value="'.$maxbytes.'"></p> 	
 <fieldset class="navy"><legend> Upload PDF File</legend>
<p  ><b>File:</b> <input id ="fileinput" style="color: #0ff;" type="file" name="upload" ></p> 
<p><input type="submit" name="submit" value="Submit PDF Upload" ></p>
<p><input type="hidden" name="pagepdfsubmitted" value="TRUE" ></p>';
echo '</fieldset></form></div><!--show_more Add PDF-->
<div id="uploadpdf" style="padding-bottom:100px;"></div>
</div><!--width 700-->
</div><!--div width 1000--> 
</body>
</html>';
?>