<?php
function nav_order($no){  //mainmenu_2_38|mainmenu_1_38
	$mysqlinst=mysql::instance();
	$mysqlinst->dbconnect();
	$nav_arr=explode('|',$no);
	$q='update '.Cfg::Dbn_nav." set dir_time='".time()."',token='".mt_rand(1,mt_getrandmax())."', dir_temp='temp'";   
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
			$q='update '.Cfg::Dbn_nav." set dir_time='".time()."',token='".mt_rand(1,mt_getrandmax())."', dir_temp='".$key."' where dir_menu_order='".$na[1]."' AND dir_menu_id='$dmid'"; 
			$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); 
			}
		$q2='update '.Cfg::Dbn_nav.' set dir_time=\''.time()."',token='".mt_rand(1,mt_getrandmax())."',dir_menu_order=dir_temp where  dir_temp !='0' and dir_menu_id='$dmid'";    
		$mysqlinst->query($q2,__METHOD__,__LINE__,__FILE__,false); 
		}
	else  if (explode('_',$nav_arr[0])[0]=='submenu'){   
		//id="submenu_'.intval($dir_menu_order).'_'.intval($dir_sub_menu_order).'_'.$dir_menu_id.'"
		
		if (count($nav_arr)<2){
		$msg='Your Sub Nav Menu Needs 2 Links to Sort!';
		mail::alert($msg);
		printer::alert($msg);
		return;
		}$qtab='';
		foreach ($nav_arr as $key=>$nav){
			$na=explode('_',$nav);
			$key++;
			$dmid=$na[3];
			$q='update '.Cfg::Dbn_nav.' set dir_time=\''.time()."',token='".mt_rand(1,mt_getrandmax()).'\', dir_temp=\''.$key.'\' where dir_menu_order=\''.$na[1].'\'  AND dir_sub_menu_order=\''.$na[2]."' AND dir_menu_id='$dmid'";  
			$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);$qtab.=NL.$q;
			}
		$q2='update '.Cfg::Dbn_nav.' set dir_time=\''.time()."',token='".mt_rand(1,mt_getrandmax())."',dir_sub_menu_order=dir_temp where  dir_sub_menu_order >0 and dir_menu_order='".$na[1]."' and dir_menu_id='$dmid'";   
		$mysqlinst->query($q2,__METHOD__,__LINE__,__FILE__,false); process_data::log_to_file($qtab.NL.$q2);
		}
	else  {
		$msg='Error in Navigate_edit parse li element';
		mail::alert($msg);
		exit($msg);
		} 
	return array($dmid,$na[0],$na[1]);			
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
		

$dir_fields=Cfg::Dir_fields;
$dir_fields_arr=explode(',',$dir_fields);
$directory_table=Cfg::Dbn_nav;
$page_table=Cfg::Master_page_table;
$ext=$navobj->ext;
$dir_ref_arr=array();
$included_arr=array();
$excluded_arr=array();
 
$master_gall_table=Cfg::Master_gall_table;
function process_pdf(){
	list ($uploadverification,$fiupl)=upload::upload_file(Cfg::Valid_pdf_mime,'pdf','review max filesize of 15mb and use .pdf file','');
	if ($uploadverification){  //upload verification is true if file uploaded in include uploadthis then do image and database
		$msg='Your file: '.$fiupl.' has been uploaded';
		printer::alert_pos($msg);
		mail::success('uploaded alert: '.$fiupl, 'uploaded file alert');
		}
	else {
		 $msg='your file has not uploaded';
		 printer::alert_neg($msg);
		 mail::alert('upload failure: '.$fiupl, 'uploaded failure alert');
		 exit('Upload failure try again');
	    }
	       

	}
function menu_add_item($dir_menu_id,$dir_menu_order,$dir_sub_menu_order,$sub,$title=''){
	//echo "<p>$dir_menu_id is dmi,$dir_menu_order is dmo ,$dir_sub_menu_order is dsmo ,$sub is sub</p>";
$mysqlinst=mysql::instance();
$mysqlinst->dbconnect(); 
$page_table=Cfg::Master_page_table;
$directory_table=Cfg::Dbn_nav;
$page_arr=array();
$print_arr=array(); 
	$link=($sub)?'SUB-MENU': 'MAIN MENU';
	show_more('Add NEW '.$link.' links Here', 'Add <span class=" purple italic">NEW '.$link.'</span> links Here','posbackground whitecolor fs2white floatleft');
	echo '<fieldset class="fs5navy"><!--Add Link--><legend>Add '.$link.'</legend>';
	printer::alertx('<p class="fsminfo editfont editcolor editbackground">Note: To Add a New Page Already Created But Not Yet in This Menu. Visit the Link at the Top of Any Regular Page To Create A New Page</p>');
	
	if ($sub) 
	printer::alertx('<p class="info left fsminfo editbackground floatleft" title="Sub Links are Hidden Links That Appear When the Cursor Hovers Over Them">Choose From the Options Below for Adding a New Sub-menu Link under the main Link: '.$title.'</p>');
	else printer::alertx('<p class="floatleft left fsminfo editfont editcolor editbackground">Choose From the Options Below for Adding a New Main Link</p>');
	printer::pclear();
	//echo '<fieldset class="fs1navy"><!--Add New Page--><legend>Add Page Link</legend>';
	//show_more('Add a New Page to the Menu', '','white fs2white posbackground floatleft');
	printer::printx('<p class="fsminfo editcolor editfont editbackground">Note: New Pages Are Created On the Create New Page Link at the top of every Page Edit</p>');   
$q="select distinct page_ref,page_title from $page_table order by page_ref ASC";
$r = $mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);

if (!$mysqlinst->affected_rows()){ mail::alert('No Pages Created. Create a Page First'.__line__,__file__); return;}
$x=1;
while (list($page_ref,$page_title) = $mysqlinst->fetch_row($r,__LINE__)){
 	 
	 $page_arr[]=$page_ref;
	 $add_table=' <span class="pos whitebackground"><input   value="'.$dir_menu_id.'_x_'.$dir_menu_order.'_x_'.$dir_sub_menu_order.'_x_'.$page_ref.'" type="checkbox" name="menu_add_newpage[]" >&nbsp;Add:&nbsp;</span> ';
	 
	  
	 
	 $print_arr[]=array('ADD'=>$add_table,'Page Table Reference'=>$page_ref,'Current Page Title'=>$page_title);
	}
printer::alertx('<p class="fsminfo editbackground editcolor editfont floatleft">This Table Lists the Created Pages and a Default Title Which You May Alter Later.  Note: Titles may Be Changed Without Affecting  Different  Titles to the same Page in a Different Menu');
printer::horiz_print($print_arr,'','','','',false);
	if(count($page_arr)<1) 
		printer::alert('You Have no New Pages Created. New Pages are Pages that have been created but not yet Added to  any Menu. You May Create a New Page From the  New Page Link at the top of every Navigation Menu on the EditPages',1.2,'navy');
	//echo '</div><!--close show_more New Page-->'; 
	//echo '</fieldset><!--end New Page-->';
			printer::pclear(9); 
	 
	//echo '<fieldset class="fs1navy"><!--Other Options --><legend>Options</legend>';
	show_more('Other Options', 'Close Other Options','white fs2white posbackground floatleft','Link to External Site, Link to Internal PDF or HTML Page, Upload Internal Page');
	echo '<fieldset class="fs1navy editbackground"><!--Add External Link --><legend></legend>';
	show_more('Add Navigation Menu Link to an External Website', 'Close Add a Link to an External Website','info fs2white','This Link Will Take Your Website Viewer Off Your Own Site');
	printer::alert('Generally Links to Other Sites are made in Your Text.  However You May Wish to Create a Formal Menu Link To a Related Company or Personal Site of Your Own,Etc!','','navy');
	printer::alert('Enter the url address of the External Link. http:// will be appended automatically if you do not include it ie www.mysite.com<input type="text" name="add_external_link_url['.$dir_menu_id.'_x_'.$dir_menu_order.'_x_'.$dir_sub_menu_order.']" value="" size="60" maxlength="100">');
	printer::alert('Enter the title of the External Link. <textarea class="utility"  name="add_external_link_name['.$dir_menu_id.'_x_'.$dir_menu_order.'_x_'.$dir_sub_menu_order.']" style="width:90%;" rows="3" cols="50" ></textarea>');
	echo '</div><!--close show_more External Link-->'; 
	echo '</fieldset><!--end External Link-->';
	printer::pclear(2); 
	echo '<fieldset class="fs1navy"><!--Add Internal Link --><legend></legend>';
	show_more('Add a Navigation Link to an Uploaded PDF file', 'Close add PDF Link','navy fs2white');
	printer::alert('Go To Upload a PDF file <a style="color:#'.Cfg::Navy_color.';"  href="#uploadpdf"  onclick="return gen_Proc.scroll_to_view(\'uploadpdf\');" >Here</a>','','navy');
	printer::alert('Enter the filename of the Uploaded PDF file: ie myfile.pdf<input type="text" name="add_internal_link_filename['.$dir_menu_id.'_x_'.$dir_menu_order.'_x_'.$dir_sub_menu_order.'" value="" size="60" maxlength="60">');
	printer::alert('Enter the title for Your PDF link. <textarea class="utility"  name="add_internal_link_title['.$dir_menu_id.'_x_'.$dir_menu_order.'_x_'.$dir_sub_menu_order.']" style="width:90%;" rows="3" cols="50" ></textarea>');
	
	
	echo '</div><!--close show_more Internal Link-->'; 
	echo '</fieldset><!--end Internal Link-->'; 
	echo '<fieldset class="fs1navy"><!--Add Upload PDF --><legend></legend>';
	echo '<p class="navy left small"><a class="navy left small" href="#uploadpdf"  onclick="return gen_Proc.scroll_to_view(\'uploadpdf\');" >GoTo Upload a PDF file</a></p>'; 
	echo '</fieldset><!--end Upload PDF-->';
	echo '</div><!--close show_more Other Options-->'; 
	//echo '</fieldset><!--end Other Options-->';
	echo '</fieldset><!--end Add Link-->';
	echo '</div><!--close show_more Add Link-->';
	printer::pclear();
	}
	
function sort_box($dir_menu_id,$menutype,$mo){
	$subsort=($menutype=='submenu')?" AND dir_menu_order='$mo' ":'';
	$orderby=($menutype=='submenu')?'dir_sub_menu_order':'dir_menu_order';
	$smo=($menutype=='submenu')?' > 0 ':'=0 ';
	$mysqlinst=mysql::instance();
	$mysqlinst->dbconnect();
	$q="select dir_menu_order,dir_sub_menu_order,dir_title from ".Cfg::Dbn_nav." where dir_menu_id='$dir_menu_id' $subsort AND dir_sub_menu_order$smo order by $orderby asc";   
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
	$class=(!empty($class))?$class:'editbackground floatleft   cursor buttonekblue shadow green';
	//$border=($border)?' fs2'.$this->column_lev_color:'';
    echo '<p class="cursor underline fs1info rad5 '.$class.'" title="'.$title.'" onclick="gen_Proc.show(\'show'.$show_more.'\',\''.$msg_open_mod.'\',\'\');" id="show'.$show_more.'">'.$msg_open.'</p>';
    printer::pclear(1);
    echo '<div class="floatleft floatleft" id="show'.$show_more.'t" style="display: none; "><!--'.$msg_open.' openshowtrack'.$show_more.'-->';
    
    } 
     
function submit(){
    echo '<p><input class="rad5 editbackground editcolor fs3pos" type="submit" name="submit" value="CHANGE" ></p>';
    }
$pgtbn=request::check_request_data('pgtbn'); 
$table_ref=request::check_request_data('table_ref');
$postreturn=request::check_request_data('postreturn');
$style=request::check_request_data('style');
$ttt=request::check_request_data('ttt');
$order=request::check_request_data('order');
if (empty($postreturn)){
	mail::alert('empty postreturn');
	$refer=new redirect;
	$refer->page_referrer_redirect("!MISSING POST INFORMATION: TRY AGAIN!", '', $sess->page_referrer_2,'true'); 
	}
$css=request::check_request_data('css');// css provides current styling for the add_page_pic_core.php page
$css=(!empty($css))?$css:Cfg_loc::Root_dir.'addeditmaster'; 
$www=request::check_request_data('www');// 
$dir_menu_id=request::check_request_data('menuid'); 
$data=request::check_request_data('data');
$navstyle=request::check_request_data('style'); 
if (empty($dir_menu_id)){
	$refer=new redirect;
	$refer->page_referrer_redirect("MISSING NAV INFORMATION: TRY AGAIN!!!!" , '', $sess->page_referrer_2,'true');
	}
  
include ('includes/transitional.nometa.php'); 
$java=new javascript('gen_Proc','print');
echo $java->javascript_return;
echo'
<script language="JavaScript" type="text/javascript" src="'.Cfg_loc::Root_dir.'scripts/tool-man/core.js"></script>
<script language="JavaScript" type="text/javascript" src="'.Cfg_loc::Root_dir.'scripts/tool-man/events.js"></script>
<script language="JavaScript" type="text/javascript" src="'.Cfg_loc::Root_dir.'scripts/tool-man/css.js"></script>
<script language="JavaScript" type="text/javascript" src="'.Cfg_loc::Root_dir.'scripts/tool-man/coordinates.js"></script>
<script language="JavaScript" type="text/javascript" src="'.Cfg_loc::Root_dir.'scripts/tool-man/drag.js"></script>
<script language="JavaScript" type="text/javascript" src="'.Cfg_loc::Root_dir.'scripts/tool-man/dragsort.js"></script>

<link href="'.Cfg_loc::Root_dir.Cfg::Style_dir.'gen_page.css" rel="stylesheet" type="text/css" > 
<link href="'.$css.'.css" rel="stylesheet" type="text/css" > 
<link href="'.$css.'edit.css" rel="stylesheet" type="text/css" >
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
 
.containbackto {position:relative; float:left;  width:15rem;  margin-left:20px; margin-top:30px;margin-bottom:50px; padding:.5rem 0 1rem 0; }
.backto { position:absolute; top: 0px; left: 0px; background:#fff; filter:alpha(opacity=50);opacity:.5; 
  width:100%; height:100%; padding:   .5rem 0 .5rem 0;
  -moz-border-radius:3px; -webkit-border-radius:3px; border-radius:3px;}
.refbackto{ position:absolute; top: 7px; left: 0px; width:100%;
text-align:center; font-size: .9rem; font-family: arial,sans-serif;font-weight: 700;
  
 color: #4F0D7F; 
text-shadow: 0px 0px 3px #FFFEF8;
	     }
.backtoborder{ position:absolute; top: 0px; left: 0px;
 width:100%; height:100%; padding:   .5rem 0 1rem 0;
 -moz-border-radius:3px; -webkit-border-radius:3px; border-radius:3px;
-moz-box-shadow: 1px 1px 5px -4px #0a2268;
-webkit-box-shadow: 1px 1px 5px -4px #0a2268;
box-shadow: 1px 1px 5px -4px #0a2268; 
	     }
</style>
</style>
</head>
<body>
<div style="max-width:1000px;margin:0 auto;padding-top:10px;">';
(isset($_POST['pagepdfsubmitted']))&&process_pdf();
$url=$postreturn.'?#'.$data; 
 echo '<div id="contain"><div class="containbackto"><p class="backto">&nbsp;</p><p class="backtoborder">&nbsp;</p><p class="refbackto"><a href="'.$url.'">Back to '.$page_title.'</a></p></div></div>';
	
//($style==Cfg::Horiz_nav_class)&&printer::pspace(30);
printer::pclear(15);

     $q2="select distinct dir_menu_id from $directory_table where dir_menu_id !='$dir_menu_id'";
     $r2=$mysqlinst->query($q2,__METHOD__,__LINE__,__FILE__,false);
     if ($mysqlinst->affected_rows()){
           
		printer::printx('<form  enctype="multipart/form-data" action="'.$postreturn.'" method="post" onSubmit="return edit_Proc.beforeSubmit()" >');
	
		printer::pclear(40);
		show_more('Choose Different Menu', ' ','fsminfo editcolor editbackground floatleft','You Can change Menu while keeping Old Styling!!'); //menu created
		echo '<div class="editbackground editcolor editfont"><!--lightgreenbackground choose dif menu-->';
		printer::printx('<p class="fsminfo editcolor editbackground floatleft">Change to Different Menu. Allows you to preserve all styles and Configurations for current Menu while changing Links Only !!</p>'); 
		printer::pclear(3);
		 	while (list($ndir_menu_id)=$mysqlinst->fetch_row($r2)){
			echo '<div class="fs1color floatleft pb10 editbackground"><!--choose menu-->';
			printer::alertx('<p class="pos"><input type="radio" value="'.$ndir_menu_id.'"  name="'.$data.'_blog_data1_arrayed">Use Menu Id: '.$ndir_menu_id.' Instead </p>');
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
	show_more('Select Entire Menus to Delete', ' ','floatleft white redAlertbackground fsmoldlace rad5 smaller','',800); //menu created
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
	
	$passnavclass=(isset($_GET['passnavclass']))?$_GET['passnavclass']:'';
	echo '<div class="'.$data.' '.$passnavclass.'">';
	$navobj->no_icon=true;
     $navobj->render_menu($dir_menu_id,$navstyle);
	echo '</div>';
	printer::pclear(7);
	if ($count>1){
		printer::pclear();
		echo '
		<div  style="background:#fff; color:#555; text-align:left; width:1000px; float:left;   border:3px solid '.Cfg::RedAlert_color.';  padding: 10px 30px 60px 30px;" ><!--Sorting-->
		<p>Drag Link To ReOrder Main Menu List. </p>
		<ul id="sort1" class="boxes">';//#sort
		echo sort_box($dir_menu_id,'mainmenu',1); 
		echo '</ul>';
		printer::pclear(10);
		echo '<p><button class="button cursor" type="button" onclick="ToolMan._junkdrawer.sendListOrder(\'sort1\',\''.Sys::Self.'\');">Update Main Menu ReOrder</button></p>';
		echo '</div><!--Sorting-->';
		printer::pclear(10);
		}
	
	echo '
	 <div class="editbackground editcolor editfont"  style=" width:700px; float:left;   border:3px solid '.Cfg::RedAlert_color.';  padding: 10px 30px 60px 30px;">
	<form  enctype="multipart/form-data" action="'.$postreturn.'" method="post" onSubmit="return edit_Proc.beforeSubmit()" >';
	
	printer::alertx('<p class="info floatleft fsminfo left editbackground" title="Each Menu has its id and this post will use Menu ID#'.$dir_menu_id.'">Editing Menu Id'.$dir_menu_id.' </p>');
	printer::pclear();
	 $count2=$mysqlinst->count_field(Cfg::Dbn_nav,'dir_filename','',false,"where dir_filename='index'");
	 if ($count>0&&$count2 <1)printer::printx('<div class="fsmredAlert neg whitebackground"><!--No Opening/Home-->No Opening/Home page has been Selected.  Select Your Home/Opening Page:'); 
		echo '<div class="fs1neg"><!--change home page-->';
		
	   
		show_more('Change your Opening/home page','Close Change Your Opening Page','infobackground whitecolor fs2white floatleft');
		$q="select dir_external,dir_internal,dir_filename,dir_title,dir_menu_order from ".Cfg::Dbn_nav." where dir_menu_id='$dir_menu_id' AND dir_sub_menu_order=0 order by dir_menu_order asc";
		$r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
		printer::alertx('<p class="information" title="When your web address is typed in it first goes to the Opening Page.  You may also change Your home page and old home page titles below">You May Change Your Opening/Home Page by Selecting a New Page Here</p>');
		while ($rows=$mysqlinst->fetch_assoc($r,__LINE__)){
			$dir_filename=$rows['dir_filename'];
			$dir_title=process_data::remove_line_break($rows['dir_title']);
			$dir_menu_order=$rows['dir_menu_order'];
			$dir_external=$rows['dir_external'];
			$dir_internal=$rows['dir_internal'];
			$checked=($dir_filename=='index')?'checked="checked"':''; 
			(!$dir_internal&&!$dir_external)&&printer::alert('<input type="radio" value="'.$dir_menu_id.'_'.$dir_menu_order.'_0" '.$checked.' name="dir_change_homepage">'.$dir_title );
			}//end while
			 
		echo '</div><!--show_more home page-->';
		echo '</div><!--end change home page-->';
		printer::pclear(10);
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
			  
			submit();
			echo '<fieldset class="border7 borderridge pos"><!--Surround While Link fields--><legend></legend>';
			printer::alertx('<p class="information" title="This refers to the visible Title Name of  your Menu Link: ie '.$dir_title.' for this page.">Change the Title of The Main Menu Link Having the Title: </p>');
			printer::pclear();
			
					
			printer::alert('<textarea class="utility"  style="width:90%;" name="dir_title_'.$dir_menu_id.'_'.intval($dir_menu_order).'_'.intval($dir_sub_menu_order).'" rows="3" cols="50" onkeyup="gen_Proc.autoGrowFieldScroll(this)">' . process_data::remove_characters($dir_title).'</textarea>');
			printer::pclear(2);
			######
			
			printer::printx('<p class="left editbackground fs3redAlert floatleft"> Or  Upload a Link Image instead of using the Text Title. Note: Use Exact Size Image. Will not be resized. &nbsp;<a href="add_page_pic.php?wwwexpand=0&amp;www=0&amp;ttt='.intval($dir_menu_order).'&amp;fff='.intval($dir_sub_menu_order).'&amp;id='.$dir_menu_id.'&amp;id_ref=blog_id&amp;postreturn='.request::return_full_url().'&amp;css='.$css. '&amp;sess_override&amp;"><u>Upload Here</u></a></p>');
			#######
			printer::alertx('<p class="fs2info editbackground">Note: Your Nav Title will Appear Exactly as Entered including Multiline Breaks!!</p>'); 
			show_more('Tech Info','close Tech Info','infobackground whitecolor fs2white floatleft','click for mysql directory tech info');
			printer::alert('
			<strong> <em>Info For Mysql Minded Developers</em></strong><br>
			<strong> Navigation Title </strong>  <br>
			field: dir_title, value: '.$dir_title.'<br>
			<strong>The  URL filename for this page</strong><br>
			field: dir_filename,value: '.$dir_filename.' ('.$ext.')<br>
			<strong>The Directory data reference for this entry</strong><br>
			field: dir_ref, value: '.$dir_ref.' <br> <em>AND references to: </em><br>
			field page_ref in '.Cfg::Master_page_table.' table<br>
			<em>The Directory table</em>: '.Cfg::Dbn_nav.'<br>'); 
			echo '</div><!--show_more Mysql Info-->'; 
			printer::pclear(2);
			
			
			if ($dir_external)printer::alertx('<p class="information" title="Change Your External URL (You may include the http://  for external site  reference ).">Change Your external URL address<input type="text" value="'.$dir_filename.'" size="60" maxlength="60" name="dir_filename_'.$dir_menu_id.'_'.intval($dir_menu_order).'_'.intval($dir_sub_menu_order).'"></p>');
			
			elseif ($dir_internal)printer::alertx('<p class="information" title="Change Your Internal URL (Make  sure  you have uploaded a file and have the correct filename entered. Valid filetypes are (.html and .pdf ).
			(without the http://) here">Change Your Internal Menu Link address to an uploaded PDF or HTML PAGE ONLY<input type="text" value="'.$dir_filename.'" size="60" maxlength="60" name="dir_filename_'.$dir_menu_id.'_'.intval($dir_menu_order).'_'.intval($dir_sub_menu_order).'"></p>');
			elseif ($dir_filename!=='index'){
				//echo '<fieldset class="fs1neg"><!--Advanced option--><legend></legend>';
				show_more('Advanced Option Filename', 'close advanced option filename','redAlertbackground fs2white whitecolor floatleft');
				printer::print_warn('Caution: Filenames only appear in the url address bar and generally go unnoticed.  However, Changing  the URL FILENAME  of the page will effect your search engine maximization, and render links that people have stored to your page useless');
				printer::pclear();
				printer::alertx('<p class="info editbackground" title="Currently the URL filename is '.$dir_filename.' (.'.$ext.')">Advanced Option: Change the Menu Link filename of this Link<input class="info editfont editcolor editbackground" type="text" value="'.$dir_filename.'" size="60" maxlength="60"
				name="dir_filename_'.$dir_menu_id.'_'.intval($dir_menu_order).'_'.intval($dir_sub_menu_order).'"></p>');
				echo '</div><!--close show_more dir_filename-->'; 
				//echo '</fieldset><!--end advanced option-->';
				printer::pclear(2);
				}//  ! index #1
			 
			if ($dir_is_gall){
				printer::alert('<a href="'.$dir_filename.$ext.'">Click Here To Add and Delete Galleries that are Under the link:&nbsp;<span class="pos"> '.$dir_title.'</span></a>');
				echo '</fieldset><!--close fieldset for Link-->';
				printer::pspace(40);
				continue;
				}
			 
			$count2=$mysqlinst->count_field($directory_table,'dir_sub_menu_order','',false,"where dir_menu_id='$dir_menu_id' AND dir_menu_order='$dir_menu_order' AND dir_sub_menu_order > 0 ");
			$count3=$mysqlinst->count_field($master_gall_table,'galleryname','',false,"where gall_ref='$dir_gall_table'");
			$msg=($count2>0)?'AND The Next Sub-Menu Link under this  Dropdown Menu will assume this position':'';
			//echo '<fieldset class="fs1neg"><!--delete link--><legend></legend>';
			//show_more('Delete this Main-Menu Link','close Delete this Main-Menu Link','redAlertbackground  whitecolor floatleft fs2white');
			if ($dir_filename=='index'){
				printer::print_warn('YOU CANNOT DELETE THE OPENING/HOME PAGE. CHOOSE A NEW OPENING/HOME PAGE ABOVE FIRST',1);
				}
			else {
				if ($dir_is_gall){
					if ($count3>0){
						echo 'First You Must Delete All the sub-galleries Under this link by going to <a href="'.$dir_filename.$ext.'">Click Here To Delete Galleries Under this link:&nbsp;<span class="pos"> '.$dir_title.'</span></a>';
						}
					else  printer::alert('<input type="checkbox" 
					name="nav_delete[]"   value= "'.$dir_menu_id.'_'.$dir_menu_order.'_'.$dir_sub_menu_order.'" >Delete this Gallery Menu Link');
					}
				else  printer::alertx('<p class="redAlertbackground  whitecolor floatleft fs2white"><input type="checkbox" name="nav_delete[]"   value= "'.$dir_menu_id.'_'.$dir_menu_order.'_'.$dir_sub_menu_order.'">Delete this   Menu Link '. $msg.'</p>');
				} // not index page
                      			
			//echo '</div><!--show_more delete Link-->';
			 //echo '</fieldset><!--end show more delete-->';
			printer::pclear(2);
			if ($count2 > 0){
				echo '<fieldset class="borderridge blue border6 "><!--submenu border--> <legend class="blue">Begin Sub Menu Link(s)</legend>'; 
				printer::alertx ('<p class="left floatleft border2 borderblue bordersolid editbackground blue"> Edit the Dropdown Sub-Menu Links under the Menu link '.$dir_title.' </p>');
				if ($count2>1){
					
					printer::pclear();
					echo '<div  style="background:#fff; color:#555; text-align:left;    border:3px solid '.Cfg::RedAlert_color.';  padding: 10px 30px 30px 30px;" ><!--Sorting-->
						<p>Drag Link To ReOrder This Sub Menu List</p>
						<ul id="subsort_'.intval($dir_menu_order).'" class="boxes">';
						echo sort_box($dir_menu_id,'submenu',$dir_menu_order);
					/*$q="select dir_sub_menu_order,dir_title from $directory_table where dir_menu_id='$dir_menu_id' AND dir_menu_order='$dir_menu_order' AND dir_sub_menu_order > 0 order by dir_sub_menu_order asc";
					$r3=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
					while (list($dir_sub_menu_order,$dir_title)=$mysqlinst->fetch_row($r3,__LINE__)){ #subsort
						$dir_title=process_data::clean_sort($dir_title);  
						While (strlen($dir_title)<36)$dir_title.='*';
						$line1=process_data::restore_sort(substr($dir_title,0,18));
						$line2=process_data::restore_sort(substr($dir_title,18,36));
						echo '<li class="box" id="submenu_'.intval($dir_menu_order).'_'.intval($dir_sub_menu_order).'_'.$dir_menu_id.'">'.$line1.'<br>'.$line2.'</li>';
						}//end while*/
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
					// menu_add_item($dir_menu_id,$dir_menu_order_sub,($dir_sub_menu_order_sub-.5),true,$included_arr,$excluded_arr,$dir_title_sub);
					 printer::pclear(7);
					 
					submit();
					echo '<fieldset class="fs1neg"><legend></legend>';
					printer::alertx('<p class="information" title="Sub Menu Links are links that show (dropdown) when you hover over the main Links that are always visible.  The visible name is called the title : ie '.$dir_title_sub.' for this page">Change the Title of Your Sub-Menu Link#'.$submenunum.':</p>');
					printer::pclear();
					 printer::alert('<textarea class="utility"  style="width:90%;" name="dir_title_'.$dir_menu_id.'_'.intval($dir_menu_order_sub).'_'.intval($dir_sub_menu_order_sub).'" rows="3" cols="50"  
					 onkeyup="gen_Proc.autoGrowFieldScroll(this)">' . process_data::remove_characters($dir_title_sub).'</textarea>');
					// echo '<p class="neg large">'."name=\"dir_title_'.$dir_menu_id.'_x'.".intval($dir_menu_order_sub)."'_x'".intval($dir_sub_menu_order_sub)."</p>";
		
					 echo '</fieldset><!--Dir Title-->'; 
						printer::pclear(2);
					show_more('Tech Info','close Tech Info','infobackground fs2white floatleft whitecolor');
					printer::alert('Info For Mysql Minded Developers: <br>
							<strong> <em>Info For Mysql Minded Developers</em></strong><br>
					<strong> Navigation Title </strong>  <br>
					field: dir_title, value: '.$dir_title_sub.'<br>
					<strong>The  URL filename for this page</strong><br>
					field: dir_filename,value: '.$dir_filename_sub.' ('.$ext.')<br>
					<strong>The Directory data reference for this entry</strong><br>
					field: dir_ref, value: '.$dir_ref_sub.' <br> <em>AND references to: </em><br>
					field page_ref in '.Cfg::Master_page_table.' table<br>
					<em>The Directory table</em>: '.Cfg::Dbn_nav.'<br>'); 
					echo '</div><!--show_more Mysql Info-->'; 
					printer::pclear(2);
					if ($dir_external_sub)printer::alertx('<p class="information" title="Change Your External URL (Be sure to include the http://  for external site  reference) or link to an uploaded PDF file ie myfile.pdf  (without the http://) here">Change Your external URL address or "Sub-Link" address to an uploaded PDF<input type="text" value="'.$dir_filename_sub.'" name="dir_filename_'.$dir_menu_id.'_'.intval($dir_menu_order_sub).'_'.intval($dir_sub_menu_order_sub).'"></p>');
					elseif ($dir_filename!=='index'){
						 
						show_more('Advanced Option: Filename', 'close advanced option filename','redAlertbackground fs2white whitecolor floatleft');
						printer::print_warn('Caution: Filenames only appear in the url address bar and generally go unnoticed.  However, Changing  the URL FILENAME  of the page will effect your search engine maximization, and render links that people have stored to your page useless');
						
						printer::pclear();
						printer::alertx('<p class="information" title="Currently the URL filename is '.$dir_filename_sub.' (.'.$ext.')">Advanced Option: Change the filename of this Sub-Menu Link<input type="text" value="'.$dir_filename_sub.'" 	name="dir_filename_'.$dir_menu_id.'_'.intval($dir_menu_order_sub).'_'.intval($dir_sub_menu_order_sub).'" ></p>');
						echo '</div><!--close show_more filename-->';
						}//  ! index #1
					else {
						echo '<fieldset class="fs1neg"><!--Advanced option--><legend></legend>';
						show_more('Advanced Option: Filename', 'close advanced option filename','redAlertbackground whitecolor floatleft');
						printer::alert('This is Your Current Opening/home page. Please note  there is no option to change the opening/Home page link filename which is index (.php) You must first select a new Home page as all Home page filenames must be index (.php)');
						echo '</div><!--close show_more filename !index-->';
						echo '</fieldset ><!--Closed Advanced option-->';
						}//        else ! index #2
					printer::pclear(2);
					echo '<fieldset class="fs1neg"><!--delete link--><legend></legend>';
					show_more('Delete this Sub-Menu Link','close Delete this Sub-Menu Link','redAlertbackground fs2white whitecolor floatleft');
					printer::alert('<input type="checkbox" name="nav_delete[]"  value= "'.$dir_menu_id.'_'.intval($dir_menu_order_sub).'_'.intval($dir_sub_menu_order_sub).'" >Delete this  Dropdown Menu Sub-Menu Link');
					echo '</div><!--show_more delete Link-->';
					echo '</fieldset><!--end show more delete-->';
					printer::pclear(2);	
					}//end while dir sub menu
				printer::pspace(7);	
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
show_more('Add PDF Here','Close Add PDF','small navy','','navedit_id');
printer::alert('Here you may upload a pdf that you can link to in Your menu. Begin by Uploading a PDF file Here',1.1,'navy');
echo '<form   enctype="multipart/form-data" action="'.request::return_full_url().'" method="post" onsubmit="return checkpdffiles(this);onSubmit="return edit_Proc.beforeSubmit();">
<p><input type="hidden" name="MAX_FILE_SIZE" value="'.Cfg::Pdf_max.'"></p> 	
 <fieldset class="navy"><legend> Upload PDF File</legend>
<p  ><b>File:</b> <input style="color: #0ff;" type="file" name="upload" ></p>  
<p><input type="submit" name="submit" value="Submit PDF Upload" ></p>';
echo '</fieldset></form></div><!--show_more Add PDF-->

<div id="uploadpdf" style="padding-bottom:100px;"></div>
</div><!--width 700-->
</div><!--div width 1000--> 
<p><input type="hidden" name="pagepdfsubmitted" value="TRUE" ></p>
</body>
</html>';
 
?>