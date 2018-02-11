<?php 
class file_generate {
	
	#not for foreign databases may need some specific updating! such as full_copycc
	//const Files_copy=Cfg::Theme_dir.Cfg::Upload_dir.Cfg::Pass_image.','.Cfg::Theme_dir.Page_images_expand_dir.Cfg::Pass_image.','.Cfg::Theme_dir.Page_images_dir.Cfg::Pass_image.',expandgallery.php,includes/expandgallery_loc.class.php,scripts/jscolor.js,refresh_button.png,styling/utility.css,fonts.css,OmFabicon.ico,apple-touch-icon-precomposed.png,resize_image.php,blank.gif,php.ini,addeditmaster.css,cssHoverFix.htc,robots.txt,400.shtml,401.shtml,403.shtml,404.shtml,500.shtml,501.shtml,HelveticaNeue-Roman.otf,mailsend.php,text_image_gen.php,photonav_prev2.gif,photonav_next2.gif,sha512.js,fonts.html,cssHoverFix.htc,plus.jpg,minus.jpg,navimage_prev.gif,navimage_next.gif,default.jpg,default_vid.jpg,file_gen.php,ftp.php';
	#
static function file_folder_generate(){ #this will generate all folders and some general files for all folders such as default.html and robots.txt
	$files_copy=Cfg::Background_image_dir.Cfg::Default_image.','.Cfg::Small_thumb_dir.Cfg::Default_image.','.Cfg::Large_image_dir.Cfg::Default_image.','.Cfg::Master_thumb_dir.Cfg::Default_image.','.Cfg::Upload_dir.Cfg::Default_image.','.Cfg::Page_images_expand_dir.Cfg::Default_image.','.Cfg::Page_images_dir.Cfg::Default_image.','.
Cfg::Background_image_dir.Cfg::Pass_image.','.Cfg::Small_thumb_dir.Cfg::Pass_image.','.Cfg::Large_image_dir.Cfg::Pass_image.','.Cfg::Master_thumb_dir.Cfg::Pass_image.','.Cfg::Upload_dir.Cfg::Pass_image.','.Cfg::Page_images_expand_dir.Cfg::Pass_image.','.Cfg::Page_images_dir.Cfg::Pass_image.','.Cfg::Include_dir.'expandgallery_loc.class.php,refresh_button.png,styling/utility.css,fonts.css,OmFabicon.ico,apple-touch-icon-precomposed.png,resize_image.php,blank.gif,php.ini,robots.txt,400.shtml,401.shtml,403.shtml,404.shtml,500.shtml,501.shtml,HelveticaNeue-Roman.otf,mailsend.php,text_image_gen.php,photonav_prev2.gif,photonav_next2.gif,sha512.js,fonts.html,cssHoverFix.htc,plus.jpg,minus.jpg,navimage_prev.gif,navimage_next.gif,default.jpg,default_vid.jpg,file_gen.php,ftp.php,next_gallery.gif,prev_gallery.gif';
	#B
  	#full_copy copies entire directory
	if (Sys::Debug)echo NL. "Generating ".__METHOD__." for current Database";
	#here we are simply creating empty folders.
	$folder_array=array(Cfg::Vid_background_dir,Cfg::Data_dir,Cfg::Data_dir.Cfg::Image_info_dir,Cfg::Data_dir.Cfg::Gall_info_dir,Cfg::Data_dir.Cfg::Page_info_dir,Cfg::Image_noresize_dir,Cfg::Vid_image_dir,Cfg::Data_dir,Cfg::Auto_slide_dir,Cfg::Contact_dir,Cfg::Watermark_dir,Cfg::Background_image_dir,Cfg::Page_images_dir,Cfg::Page_images_expand_dir,Cfg::Backup_dir,Cfg::Backup_dir.Cfg::Logfile_dir,Cfg::Backup_ext_folder,Cfg::PrimeEditDir,Cfg::PrimeEditDir.Cfg::Include_dir,Cfg::Display_dir.Cfg::Include_dir,Cfg::PrimeEditDir.Cfg::Style_dir,Cfg::Style_dir,Cfg::Upload_dir,Cfg::Include_dir,Cfg::Small_thumb_dir,Cfg::Large_image_dir,Cfg::Master_thumb_dir);
	//********Use  edit pages  $folder_array_foreign_tesite instead for foreign and testsite
	 (!is_dir(Sys::Home_pub.Cfg::Theme_dir))&&mkdir(Sys::Home_pub.Cfg::Theme_dir,0755,1);
	foreach($folder_array as $folder){#if not exist folder create folder only
		 
		self::generate_folder(Sys::Home_pub.$folder);
		self::generate_folder(Sys::Home_pub.Cfg::Theme_dir.$folder);
		} 
	
	$response_folders=explode(',',Cfg::Image_response);
	foreach ($response_folders as $val){
		$dir=Cfg_loc::Root_dir.Cfg::Page_images_dir.'imagedir'.$val;
		 if (!is_dir($dir))mkdir( $dir,0755,1);
		 } 
	if (Sys::Common_dir !== Sys::Home_pub){echo 'entering list for full copy';
	   	self::full_copy(Sys::Common_dir.Cfg::Menu_icon_dir,Sys::Home_pub.Cfg::Menu_icon_dir);
		self::full_copy(Sys::Common_dir.Cfg::Graphics_dir,Sys::Home_pub.Cfg::Graphics_dir); 
		self::full_copy(Sys::Common_dir.Cfg::Script_dir,Sys::Home_pub.Cfg::Script_dir);
		self::full_copy(Sys::Common_dir.Cfg::Script_dir,Sys::Home_pub.Cfg::Theme_dir.Cfg::Script_dir);
		self::full_copy(Sys::Common_dir.Cfg::Font_dir,Sys::Home_pub.Cfg::Font_dir);
		self::full_copy(Sys::Common_dir.Cfg::Font_dir,Sys::Home_pub.Cfg::Theme_dir.Cfg::Font_dir);
		self::full_copy(Sys::Common_dir.Cfg::Social_dir,Sys::Home_pub.Cfg::Social_dir); 
		self::full_copy(Sys::Common_dir.Cfg::Social_dir,Sys::Home_pub.Cfg::Theme_dir.Cfg::Social_dir);
		self::full_copy(Sys::Common_dir.Cfg::Display_dir,Sys::Home_pub.Cfg::Display_dir);
		self::full_copy(Sys::Common_dir.Cfg::Watermark_dir,Sys::Home_pub.Cfg::Watermark_dir);
		self::full_copy(Sys::Common_dir.Cfg::Playbutton_dir,Sys::Home_pub.Cfg::Playbutton_dir);
		self::full_copy(Sys::Common_dir.Cfg::Vid_dir,Sys::Home_pub.Cfg::Vid_dir); #copy video contents to each website root dir
	 
		self::full_copy(Sys::Common_dir.Cfg::Vid_dir,Sys::Home_pub.Cfg::Theme_dir.Cfg::Vid_dir); #copy video contents to each website root dir   
		}
  
	 
#Here we are copying a list of files from the Common_dir to Current Directory root
//(Cfg::Owner_dir!='')&&
self::gen_copy_files(Sys::Common_dir,Sys::Home_pub,$files_copy);
self::gen_copy_files(Sys::Common_dir,Sys::Home_pub.Cfg::Theme_dir,$files_copy);	#copy files from  Pub to Home Pub
//$for_test_arr=array();

//if (defined('Cfg::Foreign_dirs')&&Cfg_loc::Domain_extension==''){
	//$for_test_arr =explode(',',Cfg::Foreign_dirs);
	//}
copy(Sys::Common_dir.'passclass.php',Sys::Home_pub.Cfg::Theme_dir.'passclass.php');
copy(Sys::Common_dir.'expand-passclass.php',Sys::Home_pub.Cfg::Theme_dir.'expand-passclass.php');
self::config_generate();
if (!is_file(Sys::Home_pub.Cfg::Backup_dir.Cfg::Logfile_dir.Cfg::Log_file)){
	file_put_contents(Sys::Home_pub.Cfg::Backup_dir.Cfg::Logfile_dir.Cfg::Log_file
	,'In the beginning');
	}
if (!is_file(Sys::Home_pub.Cfg::Theme_dir.Cfg::Backup_dir.Cfg::Logfile_dir.Cfg::Log_file)){
	file_put_contents(Sys::Home_pub.Cfg::Theme_dir.Cfg::Backup_dir.Cfg::Logfile_dir.Cfg::Log_file
	,'In the beginning');
	}
 
	

 /*
	self::generate_folder(Sys::Home_pub.'highslide');
	self::full_copy(Sys::Common_dir.'highslide/',Sys::Home_pub.'highslide/');
	self::full_copy(Sys::Common_dir.'highslide/',Sys::Home_pub.Cfg::Script_dir.'highslide/');
	self::full_copy(Sys::Common_dir.'highslide/',Sys::Home_pub.Cfg::Style_dir.'highslide/');
	*/ 
  
$default_html='<!DOCTYPE html>
<html lang="en"> 
<head>
 <title>Website of '.Cfg::Owner.'</title>
 <link rel="SHORTCUT ICON" href="OmFabicon.ico"> <link rel="apple-touch-icon" href="OmFabicon.ico" type="image-x-icon"></head>
<frameset rows="100%,*">
<frame name="top" src="http://'.Cfg::Site.'" noresize frameborder=0 >
<noframes> 
</noframes>
</frameset>
</html>';

	$robots=
'User-Agent: *   
Disallow: /';

$hello_world='
<?php
echo "hello world";
?>';

$sys_hello='<?php
include ("includes/Sys.php");
echo Sys::Hello;
echo Cfg::Hello;
';
$include_hello='<?php
include ("hello.php");
';
$access_deny='deny from all';
	//$exclude=Cfg::Dbase_update.','.Sys::Home_pub;
$maxf=max(Cfg::Pic_max,Cfg::Vid_max);
$php_ini=<<<EOD
php_value upload_max_filesize $maxf
php_value post_max_size $maxf
php_value max_execution_time 30
php_value max_input_time 30
EOD;
	
	#self::directory_put($robots,'robots.txt',Sys::Home_pub,$exclude);
	self::directory_put	($default_html,'default.html',Sys::Home_pub);//puts in all directories...
	//self::directory_put	($hello_world,'hello.php',Sys::Home_pub);//puts in all directories...
	//self::directory_put	($include_hello, 'includes_hello.php',Sys::Home_pub);//puts in all directories...
	//self::directory_put	($sys_hello, 'sys_hello.php',Sys::Home_pub);//puts in all directories...
	//file_put_contents(Sys::Home_pub.Cfg::PrimeEditDir.'.htaccess',$php_ini);//causes error on vpn
	file_put_contents(Sys::Home_pub.Cfg::Upload_dir.'.htaccess',$access_deny);//puts
	}//end function

	
	
static function gen_copy_files($sourcedir,$finaldir,$filelist){#copy specified files to specified directory
	 
	if (Sys::Debug)echo NL. "Generating ".__METHOD__." for database";
	$filelist=(is_array($filelist))?$filelist:explode(',',$filelist);
	foreach($filelist as $file){//printer::alert_neg($file. ' is file copied'.NL);
		if (Cfg::Override||!is_file($finaldir.$file)){//if exists do not overcopy
			if (!copy($sourcedir.$file,$finaldir.$file))
			printer::alert_neg("Error Copying  $sourcedir$file to $finaldir$file ");
			else echo '<p> Successfully Copied ' . "$sourcedir$file  to $finaldir$file</p>";
			}
		}
	}
	
static function generate_folder($folder){#creates empty folder  exit('folder is '.$folder);
	if (Sys::Debug)echo NL. "Generating ".__METHOD__." : $folder";
	if(!is_dir($folder)){
		echo NL. "gen folder making dir: $folder";
		if(!mkdir($folder,0755,true))printer::alert_neg('Error Creating '.$folder);
		}
	}
	
static function directory_put($content,$filename,$dir=Sys::Home_Pub,$exclusion=''){//puts
#the supplied exclusion is not to put copies in that directory...
	#the Cfg::Exclusion is not to run through the directory list at all...
	if (substr($dir,-1)!='/')$dir.='/';
	// echo NL. "Generating ".__METHOD__." for  database"; echo 'hello world';
 //echo NL. " and $filename is filename"; echo " and $dir is directory";
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
		#chmod("$dir.$filename", 0755);
	 
		if(!file_put_contents($dir.$filename,$content)){
			printer::alert_neg('problem with directory_put with '.$filename);
			return;
			}
		}
	 if ($directory_handle = opendir($dir)) {  
	   while (($file_handle = readdir($directory_handle))!== false) {  
		  if(substr($file_handle,0,1) == '.') continue; 
		  if (is_dir($dir. $file_handle)&&(!in_array($file_handle, $block))) { 
			self::directory_put($content,$filename,$dir.$file_handle,$exclusion);
			} 
		}// end while
	   }// if directory
    }// end function buildlist
 


static function full_copy( $source, $target ) {echo NL. "entered full copy  $source is source and $target is target";#copies entire directory 
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
				self::full_copy( $Entry, $target . $entry );
				continue;
				}
			 echo  NL . "$c source is $source$entry and target is $target$entry";
			$c++;
			if (Cfg::Override||!is_file($target   . $entry)){
				if (!copy( $Entry, $target   . $entry )){
					printer::alert_neg("Error in copy  $Entry to $target/$entry" );
					}
				}
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
        } else {
            unlink($file);
        }
    }
    rmdir($dir);
}
 
 

static function expand_file($gall_ref,$gall_table){  
	if (Sys::Debug)echo NL. "Generating ".__METHOD__." for $gall_table";
	$file_pre='expand-'.$gall_ref;  
	$file=$file_pre.'.php';
	//$ext=(Cfg_loc::Domain_extension=="") ? '':Cfg_loc::Domain_extension.'/';   
	$new_file=Cfg_loc::Root_dir.$file;    
	 
	 
$ex_file=<<<eol
<?php
include ("includes/render_html.class.php");
\$render= new render_html('$file_pre');
include ("includes/Sys.php");
\$expand=expandgallery_loc::instance();
\$expand->clone=(isset(\$_GET['clone_ref']))?\$_GET['clone_ref']:'';
\$expand->gall_ref='$gall_ref';
\$expand->gall_table='$gall_table';
\$expand->page_source=true;
\$expand->pre_render_data();
?>	   		   
eol;
	
	if (file_put_contents($new_file,$ex_file)){
		echo NL.'Generated expand '.$new_file;
		}
	else  mail::error('Error in expand edit generated expand '.$new_file);
		 
	
   
    }// end function

	
	
static function create_new_page($newpage_ref,$newtitle,$starterpage,$ext){
	//if (!is_file(Cfg_loc::Root_dir.Cfg::Include_dir.$newpage_ref.'.class.php')){ 
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
	$newpage=<<<EOL
<?php
class $newpage_ref extends site_master {
	protected \$tablename='$newpage_ref'; 
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
	    
static function pageEdit_generate($tablename){#generates page edit for page tables
	if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	if (Sys::Debug)echo NL. "Generating ".__METHOD__." for $tablename";
	 
	$filename=check_data::dir_to_file(__METHOD__,__LINE__,__FILE__,$tablename);
	
$pageedit=<<<eol
<?php  
if (is_file('../includes/Sys.php'))include_once('../includes/Sys.php');
else include_once ('includes/Sys.php');
if (!is_file('../includes/$tablename.class.php'))file_generate::create_new_page_class('$tablename');
\$master_render=new $tablename('edit');
?>
eol;
	 
	if(!file_put_contents(Cfg_loc::Root_dir.Cfg_loc::Domain_ext_dir.Cfg::PrimeEditDir.$filename.'.php',$pageedit))printer::alert_neg('file put contents did not put in '.__METHOD__);
	if (Cfg_loc::Domain_extension !='')return;
	if (!isset($_SESSION[Cfg::Owner.'filegen']))self::iframe_backup($filename.'.php');
		#file generation will be done with style selection
	}

static function page_generate($tablename,$path='../'){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
if (Sys::Debug)echo NL. "Generating ".__METHOD__." for $tablename";

$filename=check_data::dir_to_file(__METHOD__,__LINE__,__FILE__,$tablename);
print NL. 'Creating '.$filename.'.php';
$page=<<<eol
<?php
include ('includes/render_html.class.php');
\$render= new render_html('$tablename');	 
include ('includes/Sys.php');
if (!is_file('./includes/$tablename.class.php'))file_generate::create_new_page_class('$tablename');
\$render_master=new $tablename();	
?>
eol;
   file_put_contents(Cfg_loc::Root_dir.Cfg_loc::Domain_ext_dir.$filename.'.php',$page);
    
     
	} 

  

static function config_gen_init(){
	#maybe no need to  check this
	#if (is_file('includes/Cfg_loc.class.php')){
	#	include('includes/Cfg_loc.class.php'); 
	#	if (Cfg_loc::Domain_extension!="")exit('Cfg_loc::Domain_extension is not empty');
	#	}
   #not currently used as local
	#$foreign=(defined('Cfg::Foreign_array'))?'
	#const Foreign_array_keys=Cfg::Foreign_array_keys;
	#const Foreign_array= Cfg::Foreign_array;
	#const Foreign_dirs=Cfg::Foreign_dirs;':'';
	$config=<<<eol
<?php
class Cfg_loc  {
	const Domain_ext_dir ='';
	const Domain_extension='';
	const Root_dir='';
	const Localroot_dir='';
	}
?>
eol;
if (!file_put_contents(Cfg::Include_dir.'Cfg_loc.class.php',$config))exit('Problem with initial config');
if (is_dir(Cfg::Theme_dir.Cfg::Include_dir)) 
	if (!file_put_contents(Cfg::Theme_dir.Cfg::Include_dir.'Cfg_loc.class.php',$config))exit('Problem with theme config');
}

static function config_generate(){
	$dir= (Sys::Edit)?'../':''; 
$configedit=<<<eol
<?php
class Cfg_loc  extends Cfg{
	const Domain_ext_dir='';
	const Domain_extension  = '';
	const Root_dir='../';
	const Localroot_dir='../'; 
    }
?>
eol;
   
if (!file_put_contents($dir.Cfg::PrimeEditDir.Cfg::Include_dir.'Cfg_loc.class.php',$configedit))exit('Problem with config 1'); 
      
    }//end function config
    
static function class_local_gen(){
	$class_list=array('navigation_loc','site_master','expandgallery_loc');
	foreach ($class_list as $class){
		$file=$class.'.class.php';
		$file_inc=Cfg_loc::Root_dir.Cfg::Include_dir.$file;
		if (!is_file($file_inc)){
			copy(Sys::Common_dir.$file,$file_inc);
			}
		}
	}
	
static function editMaster_generate(){#generate editpage URL response files ie addgallerypiccore.php
if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
if (Sys::Debug)echo NL. "Generating ".__METHOD__." for Current Database";
$addgalleryedit=<<<eol
<?php
if (is_file('../includes/Sys.php'))include_once('../includes/Sys.php');
else include_once ('includes/Sys.php'); 
if (is_file('../includes/addgallerypiccore.php'))
	include_once('../includes/addgallerypiccore.php');
else include_once ('includes/addgallerypiccore.php');

?>
eol;


$navigation_edit=<<<eol
<?php
include('includes/Sys.php');
include('includes/navigation_edit.php');
?>
eol;
 


$add_page_vid=<<<eol
<?php
if (is_file('../includes/Sys.php'))include_once('../includes/Sys.php');
else include_once ('includes/Sys.php');
if (is_file('../includes/add_page_vid_core.php'))
	include_once('../includes/add_page_vid_core.php');
else include_once ('includes/add_page_vid_core.php'); 
?>
eol;

$add_page_pic=<<<eol
<?php
if (is_file('../includes/Sys.php'))include_once('../includes/Sys.php');
else include_once ('includes/Sys.php');
if (is_file('../includes/add_page_pic_core.php'))
	include_once('../includes/add_page_pic_core.php');
else include_once ('includes/add_page_pic_core.php'); 
?>
eol;
$editDir=(Sys::Testsite)?Cfg::PrimeEditDir:Cfg::PrimeEditDir;
file_put_contents(Cfg_loc::Root_dir.Cfg_loc::Domain_ext_dir.$editDir.'addgallerypic.php',$addgalleryedit);   
file_put_contents(Cfg_loc::Root_dir.Cfg_loc::Domain_ext_dir.$editDir.'add_page_pic.php',$add_page_pic);
file_put_contents(Cfg_loc::Root_dir.Cfg_loc::Domain_ext_dir.$editDir.'add_page_vid.php',$add_page_vid);
file_put_contents(Cfg_loc::Root_dir.Cfg_loc::Domain_ext_dir.$editDir.'navigation_edit_page.php',$navigation_edit);
	if (Cfg_loc::Domain_extension !='')return;
     
	
    }
 
static function iframe_backup($fileurl,$width=300,$height=500){  
	if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	 if (true){
		 
	    $vis='visible';
	    }
	else {
	   $vis='hidden';
	   $height=1;
	   }
	if (Sys::Debug||Sys::Deltatime)$backupiframe=new time(); 
     //  $site=(Sys::Loc)?Cfg::Local_site:Cfg::Site;
	# $url_prefix='http://'.$pass.$site;
	$editDir=Cfg::PrimeEditDir;
	$url=Sys::Home_site.Cfg_loc::Domain_ext_dir.$editDir.$fileurl;
     self::render_backup_iframe($url,$width,$height,$vis);
	if (Cfg_loc::Domain_extension !='')return;#cause we already took care of testsite and foreign dir's.....
	if (Sys::Debug||Sys::Deltatime){
	   $delta=$backupiframe->delta();
	   echo NL. "time to render iframe page is $delta seconds";
	   }
	}
 
static function iframe_backup_all($loc=''){
	$pages=check_data::return_page_filenames(__METHOD__,__LINE__,__FILE__);
	foreach ($pages as $page){ 
		file_generate::render_backup_iframe($loc.$page.'.php',500,400,'visible','px','px');
		}
	}
	
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
     #overflow: hidden; will hide the scrollbars...
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