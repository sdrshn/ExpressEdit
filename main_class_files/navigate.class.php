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
class navigate {
	private static $instance=false; //store instance 
	private static $nav_Instance;
	private static $app_inc=0;//append increments top-level class id
	public $expand_px=false;
	public $ext='.php';
	public $tablename='';
	//public $navcolorreturn='';
	public $navfn;
	protected $getnav='';
	private $dir_filename;
	private $dir_title;
	private $dir_menu_type;
	private $dir_gall_type;
	public $view_br='';
	public $edit;
	public $menu_icon='black_menu_icon.gif';
	public $menu_icon_width=50;
	public $current_color='navy';
	public $master_page_table=Cfg::Master_page_table;//may be subbed out for displaying backups
	public $master_gall_table=Cfg::Master_gall_table;//may be subbed out for displaying backups
	public $view_webpage=true;
	public $nav_repeat_submenu=false;
     public $force_caps=false;
	public $nav_post_class='null';
     public $no_icon=false;//show icon for normal pages
     const Nav_norm_li_li_close='</ul></li>';
	const Dropdown_li_li_close='</ul>
     <!--[if lte IE 6]></td></tr></table></a><![endif]--></li>';
     //const Li_close_long='</a></li>';
     //const Ul_open_long='</a><ul>';
     //const Dropdown_li_li_close='</ul></a></li>';
     const Nav_close='</ul>
    </div>';
    const Clear='<div class="clear"></div>';
    
    
function render_menu($dir_menu_id,$style='',$nav_return=true){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	
	//$this->view_br=(strpos($style,'vert')!==false)?'<br>':'';
	self::$app_inc++;
	$this->automate_menu($dir_menu_id,$style,$nav_return);
	}
 
function utility_menu($style=''){ //addpics, vids utility  etc.
	$style=(empty($style))?'horiz_nav':$style;
	$this->edit=true;
	$mysqlinst=mysql::instance();
	$mysqlinst->dbconnect();
	$q="select  dir_menu_id from directory where dir_filename='index' limit 1";
	$r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	list($dir_menu_id)=$mysqlinst->fetch_row($r,__LINE__); 
	$nav_class=$this->automate_menu($dir_menu_id,$style,false);
	$this->util_menu_id=$dir_menu_id;//used in navigation_edit 
	
	}

function automate_menu($dir_menu_id,$nav_class='',$nav_return=true){
	if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	$mysqlinst=mysql::instance();
	$mysqlinst->dbconnect();
	(!$this->edit)&&$this->nav_to_edit();  
	($this->edit&&$nav_return)&&$this->return_url($this->tablename); 
	echo'<div class="nav_gen"><!--nav_gen_'.$dir_menu_id.'-->';
		$this->auto_nav_data($dir_menu_id,$nav_class); 
	echo'</div><!--nav_gen_'.$dir_menu_id.'-->';
	return $nav_class;
	}
	
	
function auto_nav_data($dir_menu_id,$nav_class){
	$reorder=($this->edit)?Cfg::Edit_gall_ext:''; //add to gallery edit menu's
	//$fields='dir_menu_style,dir_menu_order,dir_filename,dir_title,dir_pgMaster,dir_ref,dir_menu_type,dir_is_gall,dir_gall_type,dir_gall_display,dir_expand,dir_global_style,dir_gallery_content,dir_menu_options';
	$fields=Cfg::Dir_fields;
	$field_arr=explode(',',$fields); 
	//'dir_ref,dir_menu_order,dir_filename,dir_title,dir_menu_type,dir_gall_type,dir_menu_opts,dir_hide_sub_menu,dir_external';
	$q="select dir_id,$fields from ".Cfg::Dbn_nav ." where dir_menu_id='$dir_menu_id'  order by dir_menu_order asc, dir_sub_menu_order asc";
	$mysqlinst=mysql::instance();
	$mysqlinst->dbconnect();
	$r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	echo '<ul id="ulTop_'.self::$app_inc.'" class="top-level">';
	$navArray=array();
	while ($rows=$mysqlinst->fetch_assoc($r,__LINE__)){
		for ($i=0; $i< count($field_arr); $i++){
			${$field_arr[$i]}=$rows[$field_arr[$i]];
			}
		## MINIMIZE DATABASE CALLS
		$array=array();
		for ($i=0; $i< count($field_arr); $i++){
			$array[$field_arr[$i]]=$rows[$field_arr[$i]];
			}
		$navArray[$dir_menu_order][]=$array;
		}
		
	foreach (array_keys($navArray) as $dir_menu_order){
		$close=false; //multiple menu
		foreach ($navArray[$dir_menu_order] as $array){
			for ($i=0; $i< count($field_arr); $i++){
				${$field_arr[$i]}=$array[$field_arr[$i]]; 
				 }
			$this->dir_ref=$dir_ref;
			$this->de=$dir_external;
			if ($this->edit&&$dir_external)continue; 
			if ($dir_sub_menu_order>0|| count($navArray[$dir_menu_order])==1)//
				$this->nav_single($dir_filename,$dir_title,$dir_menu_opts,$dir_external);
				 
			else {
				$this->nav_single($dir_filename,$dir_title,$dir_menu_opts,$dir_external,true);
				echo'<ul class="sub-level">';
				($this->nav_repeat_submenu)&&$this->nav_single($dir_filename,$dir_title,$dir_menu_opts,$dir_external); 
				$close=true;
				}//end else
			}//end foreach menu order
			if($close)print '</ul><!--sub_level--> 
				</li><!--'.$nav_class.'-->';//close sub_level
			
			//else print '</li>';	
		}  //end  foreach keys
		# toggleClass javascript will also remove hover class..
	$style='';//{height: \'100%\'}'; gen_Proc.styleit(\'ulTop_'.self::$app_inc.'\','.$style.');
     if (!$this->no_icon){
          echo '
          <li class="show_icon">
              <p class="aShow cursor" title="show menu" onclick="gen_Proc.toggleClass(\'ulTop_'.self::$app_inc.'\',\'menuRespond\',1000);gen_Proc.toggleClassOut(\''.$this->nav_post_class.'\',\'hover\',1000); return false;"><img src="'.Cfg_loc::Root_dir.Cfg::Menu_icon_dir.$this->menu_icon.'" alt="mobile menu icon"></p>
         </li>
          </ul><!--top-level -->';//close top-level
          }
	else {
          echo '
          </ul><!--top-level -->';//close top-level
          }
	}

		
function nav_to_edit($gotoedit=false){   if (!Sys::Info) return;
	 static $once=0;
	//$navcolorreturn=(!empty($this->navcolorreturn))?$this->navcolorreturn:'';
	 if($once>=1)return;
	 $once++;  #in case top and side navigation in use will do only once..
	 if (isset($_GET['returnedit'])){
		$this->expand_px=true;
	    $link=$_GET['returnedit'];      
	    echo '
		 <p class="navr1 smallest"><a href="'.$link.'">return to edit page</a> 
		   </p>';
		 }
     else if (Cfg_loc::Domain_extension!=''||$gotoedit){
		$this->expand_px=true;
	 #  if  (!strpos(Sys::Self,'expand')){  //because it lowers the navigation menu in expand and its not up for editiing. in both..
		   echo '
		  <p class="navr1"><a href="'.Cfg_loc::Root_dir.Cfg::PrimeEditDir.'index.php">Go to Edit Pages</a> 
		  <br></p>
		  ';
		#  }
		
		}
	}
function return_url($tablename,$listed='',$style='navr1 floatleft',$show_all=false){  if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	if (Sys::Pass_class)return;
     $mysqlinst=mysql::instance();
	if(isset($_GET['backuphtml']))return;
	$flag=true;    
	$return_url=check_data::check_array_strpos(Sys::Self,Cfg::Aux_scripts); #no return url for addgallerycore.php etc.
	$appendReturnUrl='';//(!$return_url)?'?returnedit='.Sys::Self :'?returnedit='.Cfg_loc::PrimeEditDir;
	if (!empty($listed)){// this is not used anymore
		$list=(is_array($listed))?$listed:explode(',',$listed);
		foreach ($list as $var){
			if ($tablename==$var){
				$flag=false;
				continue;
				}
			}
		}      
	if (!$flag)$file='../index.php';//send to default page if flag reset to false
	elseif (strpos(Sys::Self,'expandgalleryedit')!==false&&is_file('../expand-'.$tablename.'-1.php')&&isset($_GET['pic'])){ 
		$pic=$_GET['pic'];
		$file=(is_file('../expand-'.$tablename.'-'.$pic.'.php'))?'../expand-'.$tablename.'-'.$pic.'.php':'../expand-'.$tablename.'-1.php';
		}
	 else {
		$tablename=check_data::dir_to_file(__METHOD__,__LINE__,__FILE__,$tablename);
		$file='../'.$tablename.'.php';
		}
    
	$show_all=(!empty($show_all))?'?showallunpub':'';//$appendReturnUrl not used
	$msg=(!empty($show_all))?'<span class="info bold" title="Will Additionally Show Non-Published Posts including this one on Your Web Page View!">Preview All</span>':'View Web '.$this->view_br.'Page changes'; 
	printer::pclear();
	($this->view_webpage)&&print '
	 <p class="navr1 editfontfamily smaller"><a  href="'.$file.$appendReturnUrl.$show_all.'" >'.$msg.'</a></p>
		';
	printer::pclear(1);
    }
 
function nav_open($div_name){
     echo '<div class="'.$div_name.'">
    <ul>';
    }
  
    
  
function populate_menu_content($tablename){
	if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	$this->navi3=array();
	$this->navi4=array();
	$mysqlinst = mysql::instance(); 
	$mysqlinst->dbconnect();
	$q="select galleryname, imagetitle from $this->master_gall_table where gall_ref='$tablename' order by pic_order";    
	//$columns='nav1,nav2,nav3,nav4,nav5,nav6,nav8,nav9,nav10,nav11';
	//$r=$this->mysqlinst->select(Cfg::Info_nav,$columns,'id=1');
	$r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);   
	while($rows=$mysqlinst->fetch_assoc($r,__LINE__)){
		$this->navi3[]=trim($rows['galleryname']);// the xtra tablename will be used in addgallerypicccore.php
		$this->navi4[]=trim($rows['imagetitle']);
		}
	//list($this->nav1,$this->nav2,$this->nav3,$this->nav4,$this->nav5,$this->nav6,$this->nav8,$this->nav9,$this->nav10,$this->nav11)=$this->mysqlinst->fetch_row($r,__LINE__);
     $this->{$tablename.'_nav3'}=$this->navi3;  
	}
 
 

	
function nav_single($dir_filename,$name,$option='',$nav_add_url=false,$submenu=false){ 
	(empty($option))&&$option='';   
	$activeclass= (strpos(Sys::Self,'/'.$dir_filename.$this->ext)!==false)?' class="active"':'';
	$ext=($nav_add_url)?'':$this->ext; 
	$makeedit=(Sys::Pass_class&&Sys::Viewdb)?Cfg::PrimeEditDir:'';  
	$href=(Sys::Pass_class&&!Sys::Viewdb)?Cfg::Pass_class_page.'?returnpass='.Sys::Returnpass.'&amp;tbn='.$this->dir_ref:$dir_filename.$ext.$this->getnav;
     $edit='';//($this->edit)?'EDIT ':'';
     $name=($this->force_caps)?str_replace('&NBSP;','&nbsp;',strtoupper($name)):$name;
	if($nav_add_url&&$this->edit)return;
     $li_close=($submenu)?'':'</li>';
	 echo '<li '.$activeclass.'><a  href="'.$makeedit.$href.'" '.$option. '>'.$edit.process_data::convert_line_break($name). '</a>'.$li_close;
	 }
      
function nav_dropdown_open($dir_filename,$name,$option='',$nav_add_url=false){
	(empty($option))&&$option='';
	$edit='';//($this->edit)?'EDIT ':'';
     $name=($this->force_caps)?strtoupper($name):$name;
	$activeclass= (strpos(Sys::Self,'/'.$dir_filename.$this->ext)!==false)?' class="active"':'';
	if($nav_add_url&&$this->edit)return;
	$makeedit=(Sys::Pass_class&&Sys::Viewdb)?Cfg::PrimeEditDir:'';
	$ext=(!empty($nav_add_url))?'':$this->ext; 
	$href=(Sys::Pass_class)?Cfg::Pass_class_page.'?returnpass='.Sys::Returnpass.'&amp;tbn='.$dir_ref:$dir_filename.$ext.$this->getnav;
	echo '<li><a '.$activeclass.' href="'.$makeedit.$href.'" '.$option.'>'.$edit.$name.'</a>';
	}
		 
function nav_populate_gallery_menu($tablename){  if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__); 
	$this->navfn=array();
	$this->navtitle=array();  
	$mysqlinst = mysql::instance();
	$mysqlinst->dbconnect(); 
	 $q="select galleryname, imagetitle from $this->master_gall_table where gall_ref='$tablename' order by pic_order";    
	//$columns='nav1,nav2,nav3,nav4,nav5,nav6,nav8,nav9,nav10,nav11';
	//$r=$this->mysqlinst->select(Cfg::Info_nav,$columns,'id=1');
	$r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);  
	while($rows=$mysqlinst->fetch_assoc($r,__LINE__)){ 
		$this->navfn[]=trim($rows['galleryname']);// the xtra tablename will be used in addgallerypicccore.php
		$this->navtitle[]=trim($rows['imagetitle']);
		}
	//list($this->nav1,$this->nav2,$this->nav3,$this->nav4,$this->nav5,$this->nav6,$this->nav8,$this->nav9,$this->nav10,$this->nav11)=$this->mysqlinst->fetch_row($r,__LINE__);
     $this->{$tablename.'_nav3'}=$this->navfn;// this is used in addgallerypiccore.php  for dropdown menu!    
	}


function delete_nav_entry($dir_ref,$dir_menu_order){
	mail::error('deleting '.$dir_ref. 'dir table and menu order is: '.$dir_menu_order);
	} 
 
function put($reference,$vname){
    $vname=trim($vname);
    $this->$reference=$vname;
    }

 
public static function instance(){ if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);//static allows it to create an instance without creating a new object
    if  (empty(self::$instance)) {
		$nav_page=(!is_file(Cfg_loc::Root_dir.Cfg::Include_dir.'navigation_loc.class.php'))?'navigate':'navigation_loc';
		self::$instance =new $nav_page(); 
        } 
    return self::$instance; 
    }       
}
?>