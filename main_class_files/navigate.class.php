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

     #use class navigate_loc extends navigate  ie local includes navigate_loc.class.php to make method changes etc. that will not be overridden by updates to the navigate class..
class navigate {
	private static $instance=false; //store instance 
	private static $nav_Instance;
	private static $app_inc=0;//append increments top-level class id
	public $expand_px=false;
	public $ext='.php';
	public $pagename='';
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
     public $nav_animate='';
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
	self::$app_inc++;
	$this->automate_menu($dir_menu_id,$nav_return);
	}
 
function utility_menu($style=''){ //addpics, vids utility  etc.
	$style=(empty($style))?'horiz_nav':$style;
	$this->edit=true;
	$mysqlinst=mysql::instance();
	$mysqlinst->dbconnect();
	$q="select  dir_menu_id from directory where dir_filename='index' limit 1";
	$r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	list($dir_menu_id)=$mysqlinst->fetch_row($r,__LINE__); 
	$this->automate_menu($dir_menu_id);
	$this->util_menu_id=$dir_menu_id;//used in navigation_edit 
	}

function automate_menu($dir_menu_id,$nav_return=true){
	if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	$mysqlinst=mysql::instance();
	$mysqlinst->dbconnect();   
	($this->edit&&$nav_return)&&$this->return_url($this->pagename); 
	echo'<div class="nav_gen"><!--nav_gen_'.$dir_menu_id.'-->';
	$this->auto_nav_data($dir_menu_id); 
	echo'</div><!--nav_gen_'.$dir_menu_id.'-->';
	}
	
function auto_nav_data($dir_menu_id){
	$fields=Cfg::Dir_fields;
	$field_arr=explode(',',$fields); 
	$q="select dir_id,$fields from ".Cfg::Directory_dir ." where dir_menu_id='$dir_menu_id'  order by dir_menu_order asc, dir_sub_menu_order asc";
	$mysqlinst=mysql::instance();
	$mysqlinst->dbconnect();
	$r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	echo '<ul class="ulTop top-level '.$this->nav_animate.'">';
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
               $aria=($dir_sub_menu_order>0)?true:false;
			if ($dir_sub_menu_order>0|| count($navArray[$dir_menu_order])==1)//
				$this->nav_single($dir_filename,$dir_title,$dir_menu_opts,$dir_external,true,false,$aria);
				 
			else {
				$this->nav_single($dir_filename,$dir_title,$dir_menu_opts,$dir_external,false,true,false);
				echo'<ul class="sub-level">';
				($this->nav_repeat_submenu)&&$this->nav_single($dir_filename,$dir_title,$dir_menu_opts,$dir_external,true,false,$aria); 
				$close=true;
				}//end else
			}//end foreach menu order
		if($close)print '</ul><!--sub_level--> 
			</li><!--sub_level-->';//close sub_level
		}  //end  foreach keys
		#aShow toggleClass event listener javascript will also remove hover class..
	$style='';
     if (!$this->no_icon&&!Sys::Edit){ 
          echo <<<eol
     <li class="show_icon">
          <div class="aShow cursor" title="show menu" >
      <p class="bar1"></p>
  <p class="bar2"></p>
  <p class="bar3"></p>
  </div>
         </li>
          </ul><!--top-level -->
eol;
          }
	else {
          echo '
          </ul><!--top-level -->';//close top-level
          }
	}
	
function nav_single($dir_filename,$name,$option='',$nav_add_url=false,$close=true,$show_arrow=false,$aria=false){ 
	(empty($option))&&$option='';   
	$activeclass= (strpos(Sys::Self,'/'.$dir_filename.$this->ext)!==false)?' class="active"':'';
	$ext=($nav_add_url)?'':$this->ext; 
	$makeedit=(Sys::Pass_class&&Sys::Viewdb)?Cfg::PrimeEditDir:'';  
	$href=(Sys::Pass_class&&!Sys::Viewdb)?Cfg::Pass_class_page.'?returnpass='.Sys::Returnpass.'&amp;tbn='.$this->dir_ref:$dir_filename.$ext.$this->getnav;
     $edit='';//($this->edit)?'EDIT ':'';
     $name=($this->force_caps)?str_replace('&NBSP;','&nbsp;',strtoupper($name)):$name;
     $show=($show_arrow)?' <span class="show_arrow">&#9660;</span>':'';
	if($nav_add_url&&$this->edit)return;
     $li_close=($close)?'</li>':'';
     $aria=($aria)?' aria-haspopup="true"':'';
     $name2 =mb_convert_encoding($name,'UTF-8');
     ($name2!==$name)&&str_replace('?',' ',$name);
	$name =mb_convert_encoding($name,'HTML-ENTITIES'); 
	echo '<li '.$activeclass.'><a  href="'.$makeedit.$href.'" '.$option.$aria.'>'.$edit.process_data::convert_line_break($name).$show. '</a>'.$li_close;
	}
       		
 
function return_url($pagename,$listed='',$class='navr1 floatleft',$show_all=false){  if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);  
	if (Sys::Pass_class)return;
     $mysqlinst=mysql::instance();
	if(isset($_GET['backuphtml']))return;
	$flag=true;    
	$return_url=check_data::check_array_strpos(Sys::Self,Cfg::Aux_scripts); #no return url for addgallerycore.php etc.
	$appendReturnUrl='';
	if (!empty($listed)){// this is not used anymore
		$list=(is_array($listed))?$listed:explode(',',$listed);
		foreach ($list as $var){
			if ($pagename==$var){
				$flag=false;
				continue;
				}
			}
		}      
	if (!$flag)$file='../index.php';//send to default page if flag reset to false
	else {
		$pagename=check_data::dir_to_file(__METHOD__,__LINE__,__FILE__,$pagename);
		$file='../'.$pagename.'.php';
		}
	$show_all=(!empty($show_all))?'?showallunpub':'';//$appendReturnUrl not used
	$msg=(!empty($show_all))?'<span class="info bold" title="Will Additionally Show Non-Published Posts including this one on Your Web Page View!">Preview All</span>':' Web '.$this->view_br.'Page mode'; 
	printer::pclear();
	($this->view_webpage)&&print '
	 <p class="'.$class.' editfontfamily "><a  style="color:inherit;" target="_blank"  href="'.$file.$appendReturnUrl.$show_all.'">'.$msg.'</a></p>
		';
	printer::pclear(1);
     }  
 
function put($reference,$vname){
    $vname=trim($vname);
    $this->$reference=$vname;
    }
 
public static function instance(){ if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);//static allows it to create an instance without creating a new object
    if  (empty(self::$instance)) {
		$nav_page=(is_file(Cfg_loc::Root_dir.Cfg::Include_dir.'navigate_loc.class.php'))?'navigate_loc':'navigate';
		self::$instance =new $nav_page(); 
          } 
     return self::$instance; 
     }
     
}//end class
?>