<?php
class file_generate {
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
 
static function file_folder_generate($loc_overwrite){ #this will generate all folders and some general files for all folders such as default.html and robots.txt
	$files_copy=Cfg::Default_image.','.Cfg::Pass_image.','.Cfg::Background_image_dir.Cfg::Default_image.','.Cfg::Small_thumb_dir.Cfg::Default_image.','.Cfg::Large_image_dir.Cfg::Default_image.','.Cfg::Master_thumb_dir.Cfg::Default_image.','.Cfg::Upload_dir.Cfg::Default_image.','.Cfg::Page_images_expand_dir.Cfg::Default_image.','.Cfg::Page_images_dir.Cfg::Default_image.','.
Cfg::Background_image_dir.Cfg::Pass_image.','.Cfg::Small_thumb_dir.Cfg::Pass_image.','.Cfg::Large_image_dir.Cfg::Pass_image.','.Cfg::Master_thumb_dir.Cfg::Pass_image.','.Cfg::Upload_dir.Cfg::Pass_image.','.Cfg::Upload_dir.Cfg::Default_image
.','.Cfg::Page_images_expand_dir.Cfg::Pass_image.','.Cfg::Page_images_dir.Cfg::Pass_image.',refresh_button.png,'.Cfg::Style_dir.'utility.css,fonts.css,OmFabicon.ico,apple-touch-icon-precomposed.png,resize_image.php,blank.gif,php.ini,400.shtml,401.shtml,403.shtml,404.shtml,500.shtml,501.shtml,mailsend.php,sha512.js,default.jpg,default_vid.jpg,next_gallery.gif,prev_gallery.gif,karma.ico'; 
  	#full_copy copies entire directory
	if (Sys::Debug)echo NL. "Generating ".__METHOD__." for current Database";
	#here we are simply creating empty folders.
	$folder_array=array(Cfg::Tiny_orig_sz_dir,Cfg::Tiny_upload_dir,Cfg::Tiny_resize_dir,Cfg::Vid_background_dir,Cfg::Data_dir,Cfg::Data_dir.Cfg::Image_info_dir,Cfg::Data_dir.Cfg::Gall_info_dir,Cfg::Data_dir.Cfg::Page_info_dir,Cfg::Image_noresize_dir,Cfg::Vid_image_dir,Cfg::Data_dir,Cfg::Auto_slide_dir,Cfg::Contact_dir,Cfg::Watermark_dir,Cfg::Background_image_dir,Cfg::Page_images_dir,Cfg::Page_images_expand_dir,Cfg::Backup_dir,Cfg::Backup_dir.Cfg::Logfile_dir,Cfg::Backup_ext_folder,Cfg::PrimeEditDir,Cfg::PrimeEditDir.Cfg::Include_dir,Cfg::Display_dir.Cfg::Include_dir,Cfg::PrimeEditDir.Cfg::Style_dir,Cfg::Upload_dir,Cfg::Include_dir,Cfg::Small_thumb_dir,Cfg::Large_image_dir,Cfg::Master_thumb_dir);
	//********Use  edit pages  $folder_array_foreign_tesite instead for foreign and testsite
	(!is_dir(Sys::Home_pub.Cfg::Theme_dir))&&mkdir(Sys::Home_pub.Cfg::Theme_dir,0755,1);
	foreach($folder_array as $folder){#if not exist folder create folder only
		echo NL.$folder. ' is being generated';
		file_generate::generate_folder(Sys::Home_pub.$folder);
		self::generate_folder(Sys::Home_pub.Cfg::Theme_dir.$folder);
		} 
	$response_folders=explode(',',Cfg::Image_response);
	foreach ($response_folders as $val){
		$dir=Cfg_loc::Root_dir.Cfg::Page_images_dir.'imagedir'.$val;
		 if (!is_dir($dir))mkdir( $dir,0755,1);
		 } 
	if (Sys::Common_dir !== Sys::Home_pub){
		self::full_copy(Sys::Common_dir.Cfg::Theme_dir,Sys::Home_pub.Cfg::Theme_dir,$loc_overwrite);
		self::full_copy(Sys::Common_dir.Cfg::Style_dir,Sys::Home_pub.Cfg::Style_dir,$loc_overwrite); 
		self::full_copy(Sys::Common_dir.Cfg::Style_dir,Sys::Home_pub.Cfg::Theme_dir.Cfg::Style_dir,$loc_overwrite); 
	   	self::full_copy(Sys::Common_dir.Cfg::Menu_icon_dir,Sys::Home_pub.Cfg::Menu_icon_dir,$loc_overwrite);
		self::full_copy(Sys::Common_dir.Cfg::Graphics_dir,Sys::Home_pub.Cfg::Graphics_dir,$loc_overwrite); 
		self::full_copy(Sys::Common_dir.Cfg::Script_dir,Sys::Home_pub.Cfg::Script_dir,$loc_overwrite);
		self::full_copy(Sys::Common_dir.Cfg::Script_dir,Sys::Home_pub.Cfg::Theme_dir.Cfg::Script_dir,$loc_overwrite);
		self::full_copy(Sys::Common_dir.Cfg::Font_dir,Sys::Home_pub.Cfg::Font_dir,$loc_overwrite);
		self::full_copy(Sys::Common_dir.Cfg::Font_dir,Sys::Home_pub.Cfg::Theme_dir.Cfg::Font_dir,$loc_overwrite);
		self::full_copy(Sys::Common_dir.Cfg::Social_dir,Sys::Home_pub.Cfg::Social_dir,$loc_overwrite); 
		self::full_copy(Sys::Common_dir.Cfg::Social_dir,Sys::Home_pub.Cfg::Theme_dir.Cfg::Social_dir,$loc_overwrite);
		self::full_copy(Sys::Common_dir.Cfg::Display_dir,Sys::Home_pub.Cfg::Display_dir,$loc_overwrite);
		self::full_copy(Sys::Common_dir.Cfg::Watermark_dir,Sys::Home_pub.Cfg::Watermark_dir,$loc_overwrite);
		self::full_copy(Sys::Common_dir.Cfg::Playbutton_dir,Sys::Home_pub.Cfg::Playbutton_dir,$loc_overwrite);
		self::full_copy(Sys::Common_dir.Cfg::Vid_dir,Sys::Home_pub.Cfg::Vid_dir,$loc_overwrite); #copy video contents to each website root dir
		self::full_copy(Sys::Common_dir.Cfg::Include_dir,Sys::Home_pub.Cfg::Include_dir,$loc_overwrite);  
		self::full_copy(Sys::Common_dir.Cfg::Vid_dir,Sys::Home_pub.Cfg::Theme_dir.Cfg::Vid_dir,$loc_overwrite); #copy video contents to each website root dir
		}
     #Here we are copying a list of files from the Common_dir to Current Directory root
     self::gen_copy_files(Sys::Common_dir,Sys::Home_pub,$files_copy);
     if (!is_file(Sys::Home_pub.Cfg::Backup_dir.Cfg::Logfile_dir.Cfg::Log_file)){
          file_put_contents(Sys::Home_pub.Cfg::Backup_dir.Cfg::Logfile_dir.Cfg::Log_file
          ,'In the beginning');
          }
	
     $default_html='<!DOCTYPE html>
<html lang="en"> 
<head>
 <title>Website of '.Cfg::Owner.'</title>
 <link rel="SHORTCUT ICON" href="OmFabicon.ico"> <link rel="apple-touch-icon" href="OmFabicon.ico" type="image-x-icon"></head>
<frameset rows="100%,*">
<frame name="top" src="http://'.Sys::Http_host.'" noresize frameborder=0 >
<noframes> 
</noframes>
</frameset>
</html>';

	$robots=
'User-Agent: *   
Disallow: /';
     
     $access_deny='deny from all'; 
	self::directory_put	($default_html,'default.html',Sys::Home_pub);//puts in all directories...
	file_put_contents(Sys::Home_pub.Cfg::Session_save_path.'.htaccess',$access_deny);//puts
	file_put_contents(Sys::Home_pub.Cfg::Upload_dir.'.htaccess',$access_deny);
	file_put_contents(Sys::Home_pub.Cfg::Tiny_upload_dir.'.htaccess',$access_deny);
	printer::alert_pos('End Files Copy');
     }//end function
	
	
static function gen_copy_files($sourcedir,$finaldir,$filelist){#copy specified files to specified directory
	if (Sys::Debug)echo NL. "Generating ".__METHOD__." for database";
	$filelist=(is_array($filelist))?$filelist:explode(',',$filelist);
	foreach($filelist as $file){//printer::alert_neg($file. ' is file copied'.NL);
		if (Cfg::Overwrite||(strpos($finaldir.$file,'.php')!==false||!is_file($finaldir.$file))){//if exists do not overcopy
			if (!copy($sourcedir.$file,$finaldir.$file))
			printer::alert_neg(NL."Error Copying  $sourcedir$file to $finaldir$file ");
			else echo NL. '<p> Successfully Copied ' . "$sourcedir$file  to $finaldir$file</p>";
			}
		else echo NL. 'file exists: '. $finaldir.$file;
		}
	}
	
static function generate_folder($folder){#creates empty folder  exit('folder is '.$folder);
	if (Sys::Debug)echo NL. "Generating ".__METHOD__." : $folder"; 
	if(!is_dir($folder)){
		echo NL. "gen folder making dir: $folder";
		if (!check_data::check_filename($folder)){
			printer::alert_neg('bad folder name with '.$folder);
			return;
			}
		if(!mkdir($folder,0755,1))printer::alert_neg('Error Creating '.$folder);
		}
	echo NL.'directory '.$folder.' exists';
	}
	
static function directory_put($content,$filename,$dir=Sys::Home_Pub,$exclusion=''){//puts
     #the supplied exclusion is not to put copies in that directory...
	#the Cfg::Exclusion is not to run through the directory list at all...
	if (substr($dir,-1)!='/')$dir.='/';
$exclude=explode(',',$exclusion);
	$dir_check=$dir;
	if(substr($dir, -1) == "/")$dir_check=substr_replace($dir,"",-1);
	$dir_check=substr($dir_check,(strrpos($dir_check,'/')+1));   
	$block=explode(',',Cfg::Exclude);
	if (in_array($dir_check,$exclude)){
		echo "excluded $filename from $dir";
		return;
		}
	else {
		if(!file_put_contents($dir.$filename,$content)){
			printer::alert_neg('problem with directory_put with '.$filename);
			return;
			}
		}
	 if ($directory_handle = opendir($dir)) {  
	   while (($file_handle = readdir($directory_handle))!== false) {  
		  if(substr($file_handle,0,1) == '.') continue;
		  if (is_dir($dir.$file_handle)&&(!in_array($file_handle, $block))) { 
			self::directory_put($content,$filename,$dir.$file_handle,$exclusion);
			} 
		}// end while
	   }// if directory
    }// end function buildlist
 


static function full_copy( $source, $target,$loc_overwrite ) {echo NL. "entered full copy  $source is fc source and $target is target";#copies entire directory 
	//exit('full copy needs to be checked out');
	 static $c=0;
	if ( !is_dir( $source ) ) {
		exit('Problem with source directory');
		}
       if (!is_dir($target)){
		echo NL. "full copy making dir $target";
		if (!mkdir($target,0755,1)){
			 printer::alert_neg(NL.NL.NL."Problem created directory for $target".NL.NL.NL);
			return;
			}
		}
	if ($directory_handle = opendir($source)) {
		while (($entry = readdir($directory_handle)) !== false) {  
			if ( $entry == '.' || $entry == '..' ) continue;
			$target = rtrim($target, "/") ."/";   

			$Entry = $source . '/' . $entry; 
			 if ( is_dir( $Entry ) ) {
				self::full_copy( $Entry, $target.$entry,$loc_overwrite );
				continue;
				}
			 echo  NL . "$c source is $source$entry and target is $target$entry";
			$c++;
               if (!$loc_overwrite&&strpos($target.$entry,'class.php')!==false){
				echo NL. "bypassing loc_overwriting copy of $entry ";
				
				continue;//do not override local custom classes..
				}
			if (Cfg::Overwrite||!is_file($target.$entry)){//||strpos($target.$entry,'.php')!==false
				echo NL. "copied $entry";
                    if (!copy( $Entry, $target.$entry)){
					printer::alert_neg("Error in copy  $Entry to $target/$entry" );
					}
				}
			else echo NL. "skipped copy of $entry is file and not php?";
			}
		}
	} 
	
static function rrmdir($dir,$exceptions=Cfg::Exclude,$subdirectory=true,$removedir=false) {
	 if (Sys::Debug)echo NL. "Generating ".__METHOD__." for current Database";
	 printer::alert_neg("removing dir contents: $dir",.7); 
    if (!is_dir($dir)) {
          printer::alert_neg("remove $dir does not exist in ".__METHOD__,.8);
		return;
		}
     $dir=trim($dir,'/').'/'; 
     $files = glob($dir . '*', GLOB_MARK);
     foreach ($files as $file) {
          if (is_dir($file)) {
               self::rrmdir($file);
               }
          else {
               unlink($file);
               }
          }
     rmdir($dir);
     }
  

static function expand_file($gall_ref,$gall_table){
	return;//currently not necessary!! 
	if (Sys::Debug)echo NL. "Generating ".__METHOD__." for $gall_table";
	$file_pre='expand-'.$gall_ref;  
	$file=$file_pre.'.php'; 
	$new_file=Cfg_loc::Root_dir.$file; 
     $ex_file=<<<eol
<?php
#ExpressEdit 3.01
include './includes/Cfg_loc.class.php';
include Cfg_loc::Root_dir.'includes/path_include.class.php'; 
\$expand=expandgallery_loc::instance();
\$expand->clone=(isset(\$_GET['clone_ref']))?\$_GET['clone_ref']:'';
\$expand->gall_ref='$gall_ref';
\$expand->gall_table='$gall_table';
\$expand->page_source=true;
\$expand->pre_render_data();
?>	   		   
eol;
	if (file_put_contents($new_file,$ex_file)){
		//echo NL.'Generated expand '.$new_file;
		}
	else  mail::error('Error in expand edit generated expand '.$new_file);
	}// end function
	
static function create_new_page($newpage_ref,$newtitle,$starterpage,$ext){
	$mysqlinst=mysql::instance();
	$page_fields=Cfg::Page_fields;
	$page_field_arr=explode(',',$page_fields);
	if (!empty($starterpage)){
          $q="select $page_fields from master_page where page_ref='$starterpage'";  
          $r = $mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
          $row  = $mysqlinst->fetch_row($r,__LINE__); 
          for ($i=0; $i < count($page_field_arr); $i++){
               ${$page_field_arr[$i]}=$row[$i];
               }
          }
	else {
		foreach ($page_field_arr as $field) {
			$$field=0;
			}
		}
	$values='';	
	$page_ref=$newpage_ref;
	$page_ref_base=$newpage_ref;
	$page_filename=$newpage_ref;
	$page_title=str_replace('_',' ',$newtitle);
	$outertitle=$page_title; 
	$page_update=date("dMY-H-i-s");
	$page_time=time();
	$page_ref_ext='';
	$token=mt_rand(1,mt_getrandmax());
	$page_fields=Cfg::Page_fields_all;
	$page_all_arr=explode(',',Cfg::Page_fields_all);
	foreach ($page_all_arr as $field) {
		$values.="'".$$field."', ";
		}
	$values=substr_replace($values,'',-2);
	$q='insert into '. Cfg::Master_page_table." ($page_fields)  values ($values)";   
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);   
	self::page_generate($newpage_ref);
	self::pageEdit_generate($newpage_ref);
	self::create_new_page_class($newpage_ref);
	}//end create new page
	
static function create_new_page_class($newpage_ref){
     if (strpos(Sys::Self,'install_file')!==false||Cfg::Overwrite_page_class||!is_file(Cfg_loc::Root_dir.Cfg::Include_dir.$newpage_ref.'.class.php')){
          $newpage=<<<EOL
<?php
#ExpressEdit 3.01
class $newpage_ref extends site_master {
     protected \$pagename='$newpage_ref'; 
      // It is recommended to  add   customized page specific functions here which will override the same function name in the main engine:  global_master.class.php   or global_edit_master.class.php
      //use site_master.class.php to replace  functions with a site wide scope instead of replacing them in global_master.class.php or global_edit_master.class  
      // this way updating will not affect your custom code unless its placed in the main engine
      // You can also express custom code then the main engine code as per example with render_body_main below
      // You can entirely replace any function here  or add to it like this example below by also invoking the parent ie:
function render_body_main(){
     //you can render page specific custom code here...
      parent::render_body_main();
     //or here
     }//end main body
function header_insert(){
     //custom header <scripts>
     //custom js css files can go here
	parent::header_insert();//calls parent in site.class.php
     }
#***********BEGIN CUSTOM CSS FUNCTIONS***********

function css_custom_page(){
	//add page specific css to  $newpage_ref here
	// use site_master.class.php to add site wide custom css
	\$this->css.='
    .mypagecss { }
   '; 
    }
    
#**********END CSS FUNCTIONS*************
}//end class page
?>
EOL;
          file_put_contents(Cfg_loc::Root_dir.Cfg::Include_dir.$newpage_ref.'.class.php',$newpage);
          }
     }
	    
static function pageEdit_generate($pagename){#generates page edit for page tables
	if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	if (Sys::Debug)echo NL. "Generating ".__METHOD__." for $pagename";
	$filename=check_data::dir_to_file(__METHOD__,__LINE__,__FILE__,$pagename);
$pageedit=<<<eol
<?php
#ExpressEdit 3.01
include '../includes/path_include.class.php';
new Sys();
if (!is_file('../includes/$pagename.class.php'))file_generate::create_new_page_class('$pagename');
\$master_render=new $pagename('edit');
?>
eol;
	if(!file_put_contents(Cfg_loc::Root_dir.Cfg::PrimeEditDir.$filename.'.php',$pageedit))printer::alert_neg('file put contents did not put in '.__METHOD__); 
		#file generation will be done with style selection
	}

static function page_generate($pagename,$path='../'){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
     if (Sys::Debug)echo NL. "Generating ".__METHOD__." for $pagename";
     $filename=check_data::dir_to_file(__METHOD__,__LINE__,__FILE__,$pagename);
     $page=<<<eol
<?php
#ExpressEdit 3.01
include './includes/path_include.class.php';
new Sys();
\$render= new render_html('$pagename');
if (!is_file('./includes/$pagename.class.php'))file_generate::create_new_page_class('$pagename');
\$render_master=new $pagename();	
?>
eol;
   file_put_contents(Cfg_loc::Root_dir.$filename.'.php',$page);
	} 

  

static function config_gen_init(){
	$config=<<<eol
<?php
#ExpressEdit 3.01
class Cfg_loc  {
	const Root_dir='';
	}
?>
eol;
     if (!file_put_contents(Cfg_loc::Root_dir.Cfg::Include_dir.'Cfg_loc.class.php',$config))exit('Problem with initial config');
     }

static function config_gen_edit(){ 
     $configedit=<<<eol
<?php
#ExpressEdit 3.01
class Cfg_loc {
	const Root_dir='../';
    }
?>
eol;
     if (!file_put_contents(Cfg_loc::Root_dir.Cfg::PrimeEditDir.Cfg::Include_dir.'Cfg_loc.class.php',$configedit))print('Problem with config 1'); 
     if (!file_put_contents(Cfg_loc::Root_dir.Cfg::Theme_dir.Cfg::Include_dir.'Cfg_loc.class.php',$configedit))print('Problem with config 1'); 
     
     }//end function config
    
	
static function editMaster_generate(){#generate editpage URL response files ie addgallerypiccore.php
     if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
     if (Sys::Debug)echo NL. "Generating ".__METHOD__." for Current Database";
     $addgalleryedit=<<<eol
<?php
#ExpressEdit 3.01
include '../includes/path_include.class.php'; 
new Sys();
new addgallerypiccore();
?>
eol;
$navigation_edit=<<<eol
<?php
#ExpressEdit 3.01
include '../includes/path_include.class.php';
new Sys();
\$load=new fullloader();
\$load->fullpath('navigation_edit.php');
?>
eol;
    $add_page_vid=<<<eol
<?php
#ExpressEdit 3.01
include '../includes/path_include.class.php'; 
new Sys();
new add_page_vid_core(); 
?>
eol;
      
     $add_page_pic=<<<eol
<?php
#ExpressEdit 3.01
include '../includes/path_include.class.php'; 
new Sys();
new add_page_pic_core(); 
?>
eol;
   $editDir=Cfg::PrimeEditDir;
     //file_put_contents(Cfg_loc::Root_dir.$editDir.'php.ini',$php_ini); 
     //file_put_contents(Cfg_loc::Root_dir.$editDir.'user.ini',$php_ini);  
     file_put_contents(Cfg_loc::Root_dir.$editDir.'addgallerypic.php',$addgalleryedit);   
     file_put_contents(Cfg_loc::Root_dir.$editDir.'add_page_pic.php',$add_page_pic);
     file_put_contents(Cfg_loc::Root_dir.$editDir.'add_page_vid.php',$add_page_vid);
     file_put_contents(Cfg_loc::Root_dir.$editDir.'navigation_edit_page.php',$navigation_edit);
	}
 

static function iframe_backup_all($loc=''){
	$pages=check_data::return_page_filenames(__METHOD__,__LINE__,__FILE__);
	foreach ($pages as $page){ 
		file_generate::render_backup_iframe($loc.$page.'.php',500,400,'visible','px','px');
		}
	}
#this method prevents some systems Server errors by spacing out iframe request by using javascript interval delay to generate iframes
static function javascript_render_backup_all($time=3000){
     if (Sys::Loc)$time=50;//basically no delay
     $bottom=(isset($_POST['iframe_bottom']))?'&#bottom':'';
     $pages=check_data::return_page_filenames(__METHOD__,__LINE__,__FILE__);
     $page_arr=array(); 
     foreach ($pages as $page){
          $page_arr[]="'./{$page}.php?iframepos&editstyle$bottom'";
          }
	$pjArr=implode(',',$page_arr);
     echo <<<eol
     <div id="append_iframe"></div>
     <script> 
function openPages(i) {
     var pageArr= [ $pjArr ];
     var max = pageArr.length;
          setTimeout(function () {
               src=(pageArr[i]);
               var appendTo=document.getElementById('append_iframe');
               var iframe = document.createElement('iframe');
               iframe.src = pageArr[i];
               iframe.frameBorder = 1;
               iframe.width = "300px";
               iframe.height = "400px";
               appendTo.appendChild(iframe);
               i++;
               if (i < max) openPages(i);
                    }, $time)
               
               }  
     
window.onload = openPages(0);
</script>
eol;
     }//end function...

static function render_backup_iframe($fileurl,$width=100,$height=30,$vis='visible',$wunit='px',$hunit='px',$return=false){   
	$bottom=(isset($_POST['iframe_bottom']))?'&#iframe_bottom':'';
	static $x=0; $x++;#for iframe numbering
	#to prevent sessions from registering url append &noreferals
	$fileurl.=(strpos($fileurl,'?')!==false)?'&iframepos&editstyle':'?iframepos&editstyle';
	$fileurl.=$bottom;
	if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);   
     if(Sys::Debug)   echo NL.'iframe No: '.$x.NL.'iframe backup  of '.$fileurl;
	$frame='<iframe style="visibility: '.$vis.';  width="'.$width.$wunit.'"  height="'.$height.$hunit.'"  src="'.$fileurl.'"></iframe> ';  
      #overflow: hidden; will hide the scrollbars...
     if ($return)return $frame;
	echo $frame;
     } 
    
static function iframe($fileurl,$width=100,$height=30,$wunit='%',$hunit=''){
	if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
     echo' iframe  width="'.$width.$wunit.'" height="'.$height.$hunit.'" src="'.$fileurl.'"> /iframe> ';  
     echo'<iframe  width="'.$width.$wunit.'" height="'.$height.$hunit.'"  src="'.$fileurl.'"></iframe> ';  
     } 

static function pdf_object($url,$width=600){
     static $xyz=0; $xyz++;
     if ($xyz <2)
          echo ' <script type="text/javascript" src="pdfobject.js"></script>';
     $px='px';
     $html=<<<EOD
<div  style="width:$width$px">
<script type="text/javascript">
     window.onload = function (){
        var success = new PDFObject({ url: "$url" }).embed();
     };  
    </script>
</div>
EOD;
     echo $html;
     }
}//end class 
 ?>