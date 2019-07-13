<?php
#ExpressEdit 2.0.3
#see top of global edit master class for system overview comment dir..
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

class global_process_master extends Singleton{ 

function clean_break_point_fields($page_ref){//clean up bp changes and grid unit number changes..
      if ($page_ref==='all'){
          $q="select page_ref from $this->master_page";
          $r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
           while (list($page_id) = $this->mysqlinst->fetch_row($r,__LINE__)){
               self::clean_break_point_fields($page_ref);
               }
          }
     $flag=false;
      $master_bp_arr=$this->page_break_arr;
     array_unshift($master_bp_arr,'max'.$this->page_break_arr[0]); //prepend array for max bp  
     $count=count($master_bp_arr);   
     foreach (array('col','post','csscol','csspost') as $tabletype){
          switch ($tabletype){
               case 'col':
                    $typeid='col_id';
                    $table=$this->master_col_table;
                    $table_base='col_table_base';
                    $gridwid='col_grid_width';
                    $gridright='col_gridspace_right';
                    $gridleft='col_gridspace_left'; 
                    $type_msg='columns';
                    $where='';
                    break;
               case 'csscol':
                    $typeid='css_id';
                    $table=$this->master_col_css_table;
                    $table_base='col_table_base';
                    $gridwid='col_grid_width';
                    $gridright='col_gridspace_right';
                    $gridleft='col_gridspace_left'; 
                    $type_msg='local style cloned columns';
                    $where='';
                    break;
               case 'post':
                    $typeid='blog_id';
                    $table=$this->master_post_table;
                    $table_base='blog_table_base';
                    $gridwid='blog_grid_width';
                    $gridright='blog_gridspace_right';
                    $gridleft='blog_gridspace_left';
                    $type_msg='posts';
                    $where=" blog_type!='nested_column' and ";
                    break;
               case 'csspost':
                    $typeid='css_id';
                    $table=$this->master_post_css_table;
                    $table_base='blog_table_base';
                    $gridwid='blog_grid_width';
                    $gridright='blog_gridspace_right';
                    $gridleft='blog_gridspace_left';
                    $type_msg='local style cloned posts';
                    $where=" blog_type!='nested_column' and ";
                    break;
               }//end switch
          $q="select $typeid,$gridwid,$gridright,$gridleft from $table where $where $table_base='$page_ref'"; 
          $r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
          if (!$this->mysqlinst->affected_rows())continue;
          ${$tabletype.'_arr'}=array();
          while (list($idv,$gridwidv,$gridrightv,$gridleftv) = $this->mysqlinst->fetch_row($r,__LINE__)){
               ${$tabletype.'_arr'}[]=array($idv,$gridwidv,$gridrightv,$gridleftv);
               }//here we simply replace mysql into foreach array in as it remove potential multiple nested mysql call issues..
          foreach (${$tabletype.'_arr'} as $array){
               list($idv,$gridwidv,$gridrightv,$gridleftv)=$array;     
                   foreach (array($gridwidv=>'wid',$gridrightv=>'right',$gridleftv=>'left') as $arrvaltype=>$type){
                         $collect_arr=array();
                         $order_arr=array();//fallback if bp mismatch
                         $old_order_arr=array();
                         $new_array=array();
                         $grid_arr=explode(',',$arrvaltype);
                         foreach($grid_arr as $pgrid){// breakup to individual choices under each type array  whether wid right left
                              $pgrid_arr=explode('-',$pgrid);
                              if (count($pgrid_arr)>4&&count($pgrid_arr)<7){ 
                                   if (array_key_exists($pgrid_arr[2],$collect_arr)){
                                        $this->message[]=$msg=printer::alert_neg('Duplicate Array key for  bp '.$pgrid_arr[2]." was overriden in page_ref: $page_ref in $table for $typeid = $idv. Be sure to check values.",.9,1);
                                        }
                                   elseif (count($pgrid_arr)===5){
                                        $order_arr[]= $collect_arr[$pgrid_arr[2]]=array($pgrid_arr[3],$pgrid_arr[4]);
                                        }
                                   elseif (count($pgrid_arr)===6){
                                        $order_arr[]= $collect_arr[$pgrid_arr[2]]=array($pgrid_arr[4],$pgrid_arr[5]);
                                        }
                                   }//end count
                               
                              }//end foreach grid type array...
                         
                        for ($i=0; $i < $count; $i++){//for  each page bp render proper css construct  under left right or wid..
                              $bp=$master_bp_arr[$i];
                              if (array_key_exists($bp,$collect_arr)){//ok we good to go
                                   $arr=$collect_arr[$bp];
                                   list($current_gu,$total_gu)=$arr;
                                   }
                              else {//make new
                                   if ($i<1){
                                        if (array_key_exists($master_bp_arr[0],$collect_arr))//use present top leve/ if exists..
                                             list($current_gu,$total_gu)=$collect_arr[$master_bp_arr[0]];
                                        if (!array_key_exists($master_bp_arr[0],$collect_arr)||$current_gu===$total_gu){
                                             if (array_key_exists(1,$master_bp_arr)&&array_key_exists($master_bp_arr[1],$collect_arr))
                                                  list($current_gu,$total_gu)=$collect_arr[$master_bp_arr[1]];
                                             if (!array_key_exists(1,$master_bp_arr)||!array_key_exists($master_bp_arr[1],$collect_arr)||$current_gu===$total_gu){
                                                  if (array_key_exists(0,$order_arr))//fallback 
                                                       list($current_gu,$total_gu)=$order_arr[0];
                                                  else
                                                       $current_gu=$total_gu=$this->page_grid_units;
                                                  }    
                                             }
                                               
                                        }
                                   else {
                                        if (array_key_exists($master_bp_arr[$i-1],$collect_arr))//use present top leve/ if exists..
                                             list($current_gu,$total_gu)=$collect_arr[$master_bp_arr[$i-1]];
                                        if (!array_key_exists($master_bp_arr[$i-1],$collect_arr)||$current_gu===$total_gu){
                                             if (array_key_exists($i+1,$master_bp_arr)&&array_key_exists($master_bp_arr[$i+1],$collect_arr))
                                                  list($current_gu,$total_gu)=$collect_arr[$master_bp_arr[$i+1]];
                                             if (!array_key_exists($i+1,$master_bp_arr)||!array_key_exists($master_bp_arr[$i+1],$collect_arr)||$current_gu===$total_gu){
                                                  if (array_key_exists($i,$order_arr))//fallback 
                                                       list($current_gu,$total_gu)=$order_arr[$i];
                                                  else
                                                       $current_gu=$total_gu=$this->page_grid_units;
                                                  }    
                                             }
                                               
                                        }
                                       
                                   }
                              $current_gu=str_replace('x','.',$current_gu);
                              echo "floor($current_gu*$this->page_grid_units/$total_gu);";
                              if($this->page_grid_units!==$total_gu)
                                   $current_gu=floor($current_gu*$this->page_grid_units/$total_gu);
                              if (($type==='wid'||$this->page_grid_units!==$total_gu)&&strpos($bp,'max')!==false){
                                   $new_array[]=$type.'-bp-'.$bp.'-'.$current_gu.'-'.$this->page_grid_units;
                                   }
                              elseif ($type==='wid'||$this->page_grid_units!==$current_gu){
                                   $lower_bp=(array_key_exists($i+1,$master_bp_arr))?$master_bp_arr[$i+1]:$bp;
                                   $new_array[]=$type.'-bp-'.$bp.'-'.$lower_bp.'-'.$current_gu.'-'.$this->page_grid_units;
                                   }
                              }//end bp for loop
                         $final_arr[$type]=implode(',',$new_array); 
                         } //foreach arraytype +> type
                    $widarr=(array_key_exists('wid',$final_arr))?$final_arr['wid']:'';
                    $leftarr=(array_key_exists('left',$final_arr))?$final_arr['left']:'';
                    $rightarr=(array_key_exists('right',$final_arr))?$final_arr['right']:'';
                    $q2="update $table set $gridwid='$widarr',$gridright='$rightarr',$gridleft='$leftarr' where $typeid='$idv' and $table_base='$page_ref'";echo $q;
                    $this->mysqlinst->query($q2,__METHOD__,__LINE__,__FILE__,false);
                    if ($this->mysqlinst->affected_rows()){
                         $success_arr[]="page: $page_ref updated for bps"; 
                         }
               }//foreach
          }//foreach table type  col blog colcss blogcss  update arr
     }
     
function page_adjust_break_points(){
	if (!isset($_POST['page_adjust_break_points']))return;
	$count=count($this->page_break_arr); 
	for ($i=0; $i<$count; $i++){
		if (isset($this->page_break_arr[$i+1])){
			if ($this->page_break_arr[$i]<=$this->page_break_arr[$i+1]){
				$this->message[]='break point value mismatch: Your substitutions should follow descending values';
				return;
				}
			}
		}
	$x=0;
	$change_bp_arr=array();
	foreach ($_POST['page_adjust_break_points']  as $bp => $newbp){//check values first
		if ($this->page_break_arr[$x]===$newbp){
		    $x++;
		    continue;
		    }
		if ($newbp <101){
			$this->message[]='Break Points must be greater than 100';
			return;
			}
		$change_bp_arr[$bp]=$newbp;
          $x++;
		}//end foreach
	if (count($change_bp_arr)<1)return;
	$wheretable=(isset($_POST['page_sub_bp'])&&	$_POST['page_sub_bp']==='site')?'':" where page_ref='$this->pagename'";
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
			if ($this->page_id===$update[0]){ 
                    $this->page_break_points=$update[2];
                    $this->page_break_arr=explode(',',$update[2]);
                    }
		
               $success_arr[]=$update[1];
			}
		}//end for each update
	if (count($success_arr)>0){
		$string=implode(',',array_unique($success_arr));
		$this->success[]='Page Config Break Points altered on pages:'.$string;
		}
	else $this->message[]='No page config break points were changed';
	###############column col_grid_clone update
	foreach (array('master_col_table','master_col_css_table') as $table){
          $q='select col_id,col_grid_clone from '.$this->$table." $wheretable"; 
          $r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);  
          while (list($id,$clone) = $this->mysqlinst->fetch_row($r,__LINE__)){
               $update_arr[]=array($id,$clone);
               }
          foreach ($update_arr as $update){
               foreach($change_bp_arr as $bp =>$newbp){
                    $update[1]=str_replace($bp,$newbp,$update[1]);
                    }
               $q='update '.$this->$table." set col_grid_clone='".$update[1]."' where col_id=".$update[0];   
               $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
               }
          }
	##end col_grid_clone
	$flag=false;
	foreach (array('col','post','csscol','csspost') as $type){
		switch ($type){
			case 'col':
				$id='col_id';
				$table=$this->master_col_table;
				$gridwid='col_grid_width';
				$gridright='col_gridspace_right';
				$gridleft='col_gridspace_left';
				$gridclone='col_grid_clone';
				$table_base='col_table_base';
				$type_msg='columns';
				break;
			case 'csscol':
				$id='css_id';
				$table=$this->master_col_css_table;
				$gridwid='col_grid_width';
				$gridright='col_gridspace_right';
				$gridleft='col_gridspace_left';
				$gridclone='col_grid_clone';
				$table_base='col_table_base';
				$type_msg='local style cloned columns';
				break;
			case 'post':
				$id='blog_id';
				$table=$this->master_post_table;
				$gridwid='blog_grid_width';
				$gridright='blog_gridspace_right';
				$gridleft='blog_gridspace_left';
				$table_base='blog_table_base';
				$type_msg='posts';
				break;
			case 'csspost':
				$id='css_id';
				$table=$this->master_post_css_table;
				$gridwid='blog_grid_width';
				$gridright='blog_gridspace_right';
				$gridleft='blog_gridspace_left';
				$table_base='blog_table_base';
				$type_msg='local style cloned posts';
				break;
			}//end switch
		$wheretable=(isset($_POST['page_sub_bp'])&&$_POST['page_sub_bp']==='site')?'':" where $table_base='$this->pagename'";
		$q="select $id,$gridwid,$gridright,$gridleft,$table_base from $table $wheretable"; 
		$r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
		if ($this->mysqlinst->affected_rows()){ 
			$update_arr=array();
			$success_arr=array();
			while (list($idv,$gridwidv,$gridrightv,$gridleftv,$table_basev) = $this->mysqlinst->fetch_row($r,__LINE__)){
				if (strlen($gridwidv)>10||strlen($gridrightv)>10||strlen($gridleftv)>10)
					$update_arr[]=array($idv,$gridwidv,$gridrightv,$gridleftv,$table_basev);
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
                         $flag=true;   
				
					}
				}//foreach update arr
			if (count($success_arr)>0){
					$_SESSION[Cfg::Owner.'page_update_clones']= (isset($_SESSION[Cfg::Owner.'page_update_clones']))?array_unique(array_merge($_SESSION[Cfg::Owner.'page_update_clones'],$success_arr)):$success_arr;//update session array for iframe regeneration of substitued data.. so that styling is up to date
					$string=implode(',',array_unique($success_arr));
					$this->success[]="Css Grid width/spacings on 
				$type_msg were altered on pages:".$string;
					}
				
			}//affected rows
		}//foreach type 
          if (!$flag)  $this->message[]='No Grid breakpoint chosen width/spacings settings were affected';
     $clean_id= (isset($_POST['page_sub_bp'])&& $_POST['page_sub_bp']==='site')?'all':$this->pagename;
     $this->clean_break_point_fields($clean_id);     
	}//end clean_break_points
	
function force_color_reset(){ 
	$where=($_POST['force_color_reset']==="reset_all")?'':"where page_ref='$this->pagename'";
	 $q="update $this->master_page_table  set page_dark_editor_value='', page_light_editor_value='', page_dark_editor_order='', page_light_editor_order='' $where";
	$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	 $q="update $this->master_page_table  set page_dark_editor_value='', page_light_editor_value='', page_dark_editor_order='', page_light_editor_order='' $where";
	$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	}
	
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
								if ($file_handle==='.'||$file_handle==='..')continue;
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
		if ($directory_handle = opendir($dir)) {
			while (($file_handle = readdir($directory_handle)) !== false) {
				if ($file_handle==='.'||$file_handle==='..')continue;
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

function java_page_iframe_all(){  
	if (!$this->edit||!isset($_POST['page_iframe_all']))return; 
	store::setVar('backup_clone_refresh_cancel',true);//this can be set on any class 
	$this->iframe_update_msg='Wait For Loading to Finish. Allowing for all pages to update styles, flat files etc. with each page generating an iframe. This will take awhile to finish loading at top of this page.';
	file_generate::javascript_render_backup_all(); 
	}
function page_iframe_all(){ return;
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
		$dir=Cfg_loc::Root_dir.Cfg::Data_dir.$sub_dir;
		if (!is_dir($dir))mkdir($dir,0755,1);
		}
	store::setVar('backup_clone_refresh_cancel',true);//this can be set on any class 
	$this->iframe_update_msg='Allowing for all pages to update image cache directories with each page generating an iframe. This will take awhile to finish loading at top of this page.';
	file_generate::iframe_backup_all();
	}


function page_opts_export(){
	if (!isset($_POST['page_opts_export']))return;
	$list= Cfg::Page_fields;//,page_tiny_data3,page_tiny_data4,  these are in reserve for future use
	$blacklist='page_ref,page_title,page_filename,page_id,page_tiny_data1,page_tiny_data2,page_tiny_data3';
	$blacklist_arr=explode(',',$blacklist);
	$list_arr=explode(',',$list);
	$value='';
	$q="update $this->master_page_table c, $this->master_page_table p SET ";
	foreach ($list_arr as $field){
		if(in_array($field,$blacklist_arr))continue;
		$value.="c.$field = p.$field, ";
		}
	$q.=" $value c.page_update='".date("dMY-H-i-s")."', c.page_time='".time()."',c.token='".mt_rand(1,mt_getrandmax()). "' where p.page_ref='$this->page_ref'";
	 $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	if ($this->mysqlinst->affected_rows()){
		$this->success[]="$this->page_ref has updated all styles and configs to all other pages";
		}
	}//end export page function


	
function page_opts_import(){
	if (!isset($_POST['page_opts_import']))return;
	$list= Cfg::Page_fields;//,page_tiny_data3,page_tiny_data4,  these are in reserve for future use
	$blacklist='page_ref,page_title,page_filename,page_id,page_tiny_data1,page_tiny_data2,page_tiny_data3';
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
		if ($field==='page_ref')$q.="'$themename',";
		else if ($field==='page_title')$q.="'$themename',"; 
		else if ($field==='page_filename')$q.="'$themename',";
		else $q.="'".$row[$field]."',";
		}
	$q="$q '".date("dMY-H-i-s")."','".time()."','".$this->token_gen()."')";
	$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	$msg="Your New Theme Page $themename has been copied";
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
     unset($_SESSION[Cfg::Owner.'dbname']);
	} 
	
function import_page(){if (Sys::Quietmode||Sys::Pass_class)return;
     $col_fields=Cfg::Col_fields;
	$post_fields=Cfg::Post_fields;
	$page_fields=Cfg::Page_fields;
	####################
	if (isset($_POST['add_theme_db'])&&strpos($_POST['add_theme_db'],'theme')!==false){ 
		$db=$_POST['add_theme_db'];
		$functionCheck= (!isset($_POST['cancel_clean_import']))?'strict_db_check':'non_strict_db_check';
		printer::alert_neu('Database Cleaning if selected may take a moment.');
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
		$this->show_more('View/Choose Theme Pages','asis','neg editbackground editfont smallest button'.$this->column_lev_color,'',500 ); 
		printer::alertx('<p class="fsminfo editbackground editfont editcolor floatleft">Db: '.$db.'<br><br>Click  Page Link to View<br>OR<br>use Copy radio button for Page Import </p>');
		printer::pclear();
		echo '<div class="inline editbackground editfont">';
		echo'<fieldset class="redfield"><!--Configure--><legend></legend>'; 
	
		$q="select distinct page_ref, page_title, page_filename from $db.$this->master_page_table  order by page_title ASC";   
		$r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
		echo '<div class="editcolor editbackground editfont">';
		$msg='Your Choice is unselected';
		echo '<input class="import_page" type="radio" name="import_page" value="none" onchange="gen_Proc.on_check_event(\'import_page\',\''.$msg.'\');">Undo Any Copy Selection<br>';
		while (list($page_ref,$title,$filename) = $this->mysqlinst->fetch_row($r,__LINE__)){
			if ($page_ref=='setupmaster'||trim($filename)==='')continue;
			$msg= "Page $page_ref will be copied as Page theme1 to the website or theme2, etc.  if that page already exists.   Look for it under the full page navigation button at the top of page";
			echo '<span class="pos">&nbsp;Copy: </span><input class="import_page small" type="radio" name="import_page" value="'.$page_ref.'" onchange="gen_Proc.on_check_event(\'import_page\',\''.$msg.'\');">&nbsp;&nbsp;Or&nbsp; <span class="pos">&nbsp;&nbsp;View:&nbsp;  </span><a class="underline highlight" href="'.Cfg_loc::Root_dir.Cfg::Theme_dir.Cfg::Pass_class_page.'?editgen&amp;tkn='.$token.'&amp;tbn='.$page_ref.'&amp;returnpass='.Sys::Self.'"> '.str_replace(array('&nbsp','&nbs','&nb','&','<br>'),' ',substr($title,0,17)).'</a><br>'; 
			}
		echo '</div><!--end horiz utility full nav-->';
		echo'</fieldset><!--full nav-->';  
		echo '</div><!--full nav float buttons-->';
		$this->show_close('theme pages');// 
		echo '</div><!-- float buttons--><!--full nav editbackground editfont-->'; 
		}//db activated
	 
	$msg_choose_db=(isset($_SESSION[Cfg::Owner.'dbname']))?'Choose Different Theme Db':'Importing Theme Page';
     $this->display_themes($msg_choose_db);
     $this->mysqlinst->dbconnect();
	
	}//end import page
     
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
			$this->success[]="New Page has been Created. <a class=\"link\" href=\"$newpage_ref$this->ext\"><u>  $newtitle</u></a>";
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
	$this->show_more('Add/Del Pages','asis',$this->column_lev_color.'  smallest editpages editbackground editfont button'.$this->column_lev_color,'','full' );
	$this->print_wrap('add delete page','info',false,'editbackground editcolor editfont floatleft');
	
	$this->show_more('Add Page','','editcolor smallest editpages editbackground editfont');
	$this->print_wrap('add page',true);
	printer::alertx('<p class="'.$this->column_lev_color.' left editbackground editfont inline ">A Link for editing Your New Page Will Appear in the Editor but Will Not Appear in the Website till YOU ADD the link to a Page Navigation Menu. This way Make Changes to the page and not have it appear on the website till you are ready.  Create as many navigations menus on a page as you wish. Options for Creating Navigation Menus are found under the Choose Post Options in each Column</p>');
	printer::pclear(1);
	printer::alertx('<p class="highlight" title="The Title should express the basic idea, ie about, CONTACT, Photography, using one or more words!">Title name for Your New Page link: <textarea class="utility left" name="create_page" style="width:80%" rows="3" cols="50"   ></textarea></p>');
	
	printer::pclear(1);
	$indexfileref='';
	$included_arr=array();
	$q="select distinct page_ref, page_title, page_filename from $this->master_page_table order by page_title";
	$indexref=$indextitle='';
	$r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	while (list($page_ref,$title,$filename) = $this->mysqlinst->fetch_row($r,__LINE__)){
		if ($page_ref==='setupmaster')continue;   
		if ($filename==='index'){$indexref=$page_ref;$indextitle=$title;}
		$included_arr[]=array($page_ref,$title);
		}
	if (empty($indexref)){
		echo '</div></div>';
		printer::alert_neg("Proper filename for the index page not found ie index.php",1);
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
	printer::alertx('<p class="fsminfo editbackground editfont '.$this->column_lev_color.'">New Pages Will Appear as a Link in the menu dropdown at the top of any page in editmode. When Your Page is Ready to Publish 
	add it in Whatever order you Wish to Any existing Navigation Menu  or create a new Navigation Post andand then add it</p>');
	printer::alertx('<p class="fsminfo editbackground editfont '.$this->column_lev_color.'">Choose a Starter Page for Your initial Config/Styles</p>'); 
	$count=count($included_arr);
	if($count>0){ 
		echo'<p> <select class="editcolor editbackground editfont"  name="use_newpage_ref">';       
          echo '<option  value="'.$indexref.'" selected="selected">'.$indextitle.'</option>';
		for ($i=0;$i<count($included_arr);$i++){
			echo '<option  value="'.$included_arr[$i][0].'">'.$included_arr[$i][1].'</option>';
			}
	    echo'	
	    </select></p>';
		}
	printer::pclear(5); 
	$this->submit_button(); 
	$this->close_print_wrap('add  page');
	$this->show_close('Add Page');
	$this->show_more('Delete Page','','editcolor  smallest editpages editbackground editfont');
	$this->print_wrap('delete page');
	printer::alertx('<p class="left editcolor editbackground editfont">First Delete All Primary Columns in Page &#40;This Also Removes all Nested Columns and Post&#41; Within. Then Select Your Page For Deleting Here and Make Sure Your On a Different Page then the One You Wish To Delete!!<br>Be sure to Remove Your Page On the Navigation Menu Editor</p>');
	$q="select distinct page_ref, page_title, page_filename from $this->master_page_table order by page_ref";  
	$r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	while (list($page_ref,$title,$filename) = $this->mysqlinst->fetch_row($r,__LINE__)){
		if ($page_ref==='setupmaster'||trim($filename)==='')continue;if ($filename==='index')
			echo '<p class="rs1redAlert">'.$title.' <span class="redAlert whitebackground smallest">This Page is Currently Your Opening Page Often referred to as Home page and You Need to Select a Different Opening Page before Deleting This Page.  Visit the Edit Links Under the Navigation Menu, go to Change your Opening/home page Link and then change Your Opening Page to a New Page Link</span></p>'; 
		elseif ($page_ref===$this->pagename)
			echo '<p class="rs1redAlert">'.$title.' <span class="redAlert whitebackground smallest">To Delete this Page Navigate to a Page Other than Itself!!!</span></p>'; 
		else echo '<p class="editcolor editfont editbackground"><input type="checkbox" name="delete_page['.$page_ref.']">&nbsp;<span class="bold italic">page_ref: </span>'.substr($page_ref,0,23).'&nbsp;<span class="bold italic">title: </span>
		'.substr($title,0,23).'</p>'; 
		}
	$this->close_print_wrap('delete page');
	$this->show_close('delet page');
	printer::pclear();
	$this->close_print_wrap('add delete page');
	$this->show_close('Add/Del Pages');//<!--Show More Add Page-->'; 
	echo '</div><!--float buttons-->';
	}//end add del

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
 
function delete_col($col_id,$clone=false){   
	$this->delete_col_arr[]=$col_id;//used in funct blog render
	static $inc=0;  $inc++;
	$q="select  blog_id,blog_type,blog_data1,blog_status from $this->master_post_table where blog_col='$col_id' and blog_table_base='$this->pagename'";
	$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	if ($this->mysqlinst->affected_rows()){
		while (list($blog_id,$blog_type,$blog_data1,$status)=$this->mysqlinst->fetch_row($r,__LINE__)){
			$q="delete from $this->master_post_table where blog_id='$blog_id' and blog_table_base='$this->pagename'";
			$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
			if ($this->mysqlinst->count_field($this->comment_table,'com_id','',false," where comment_blog_id='$blog_id'")){
					$q="delete from ".$this->comment_table." where comment_blog_id='$blog_id' and blog_table_base='$this->pagename'"; 
					$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
					} 	
			if ($this->mysqlinst->count_field($this->master_post_css_table,'blog_id','',false,"Where blog_id='$blog_id'")>0){
				$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
				$q="delete from ".$this->master_post_css_table." where blog_id='p$blog_id' and blog_table_base='$this->pagename'";
				$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
				}  
			if ($blog_type==='nested_column'&&!empty($blog_data1)&&is_numeric($blog_data1)){
				if ($status !=='clone')
				$this->delete_col($blog_data1);
				}
			} 
		}
	$q="delete from $this->master_post_table where blog_data1='$col_id' and blog_table_base='$this->pagename' ";  
	$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	$q="DELETE FROM $this->master_col_table WHERE col_id='$col_id' and col_table_base='$this->pagename'";   
	$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	$msg=(!$clone)?"Column ID $col_id and all its posts have Been Deleted":'Cloned Column has been removed';
	$this->success[]=$msg;
	}
	
function process_col(){   
     $q="select col_table, col_id from $this->master_col_table where col_table_base='$this->pagename'";  
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
               (isset($_POST['col_widthexport'][$col_id]))&& 
                    $this->process_col_widthexport($col_id);  
               (isset($_POST['col_rwdcopy'][$col_id]))&& 
                    $this->process_col_rwdcopy($col_id);  
               (isset($_POST['col_flexcopy'][$col_id]))&& 
                    $this->process_col_flexcopy($col_id);
               }
          }
     $q="select col_table, css_id from $this->master_col_css_table where col_table_base='$this->pagename'";  
     $r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
     if ($this->mysqlinst->affected_rows()){
          while (list($col_table,$css_id)=$this->mysqlinst->fetch_row($r,__LINE__)){ 
               $where2=" and col_table_base='$this->pagename'";
               $this->process_col_data($col_table,$css_id,$this->master_col_css_table,Cfg::Col_fields,$where2,'clone_');
               }
          }
     }//func
		
		
function process_col_data($tablename,$col_id,$dbtable=Cfg::Columns_table,$fields=Cfg::Col_fields,$where2='',$prefix=''){
	#prefix used for cloned tables to distinguish when from originating from same page.. intra clones
	$field_array=explode(',',$fields); 
	$process=process_data::instance();
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
	
	if ($update=== 'SET ')return; 
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
	}#end funct

function process_blog($tablename,$col_id){ 
	$this->is_blog=true;
	$this->blog_id_array=array(); 
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
	$q="select blog_id,blog_order,blog_table,blog_type from ".$this->master_post_table." Where blog_table='$tablename' order by blog_order";  
	$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	$tidy=false;
	while($rows=$this->mysqlinst->fetch_assoc($r,__LINE__)){
		$blog_order=$rows['blog_order'];
          $this->blog_type=$rows['blog_type'];
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
		(isset($_POST['post_rwdcopy'][$blog_id]))&&
			$this->process_post_rwdcopy($blog_id); 
		(isset($_POST['post_widthmodeexport'][$blog_id]))&& 
			$this->process_post_widthmodeexport($blog_id);
		(isset($_POST['post_rwdexport'][$blog_id]))&& 
			$this->process_post_rwdexport($blog_id);
		(isset($_POST['post_heightexport'][$blog_id]))&& 
			$this->process_post_heightexport($blog_id);
		(isset($_POST['post_widthexport'][$blog_id]))&& 
			$this->process_post_widthexport($blog_id);
		(isset($_POST['post_floatexport'][$blog_id]))&& 
			$this->process_post_floatexport($blog_id); 
		(isset($_POST['post_flexexport'][$blog_id]))&& 
			$this->process_post_flexexport($blog_id);  
		(isset($_POST['post_styleexport'][$blog_id]))&& 
			$this->process_post_styleexport($blog_id); 
		(isset($_POST['col_flexitemexport'][$blog_id]))&& 
			$this->process_col_flexitemexport($blog_id); 
		(isset($_POST['post_flexcopy'][$blog_id]))&& 
			$this->process_post_flexcopy($blog_id); 
		(isset($_POST['col_widthmodeexport'][$blog_id]))&& 
			$this->process_col_widthmodeexport($blog_id);
		(isset($_POST['col_floatexport'][$blog_id]))&& 
			$this->process_col_floatexport($blog_id);
		(isset($_POST['post_configexportdump'][$blog_id]))&& 
			$this->process_post_configexportdump($blog_id);
		(isset($_POST['post_configimportdump'][$blog_id]))&& 
			$this->process_post_configimportdump($blog_id);
          (isset($_POST['import_blog_option_donor'][$blog_id]))&&
               $this->blog_option_choices('import_option',$blog_id);
          (isset($_POST['export_blog_options'][$blog_id]))&& 
               $this->blog_option_choices('export_option',$blog_id);
          (isset($_POST['import_blog_style_donor'][$blog_id]))&&
               $this->port_style_choices('import_option',$blog_id,'blog');
          (isset($_POST['export_blog_style'][$blog_id]))&& 
               $this->port_style_choices('export_option',$blog_id,'blog');
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
                    $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);	//this is affecting only one pagename... intra...
                    }
			}
		} 
	if (isset($_POST['delete_blog'][$tablename])){
		$this->delete_blog($tablename);
		$tidy=true;
		}
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
	if (!isset($_POST['submitted']))return;
     if ($tidy)$this->blog_tidy($tablename);
     else{  
          $q="SELECT blog_order, COUNT(*) c FROM $this->master_post_table where blog_table='$tablename' GROUP BY blog_order HAVING c > 1 ";
          $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
          if ($this->mysqlinst->affected_rows()){
               $this->blog_tidy($tablename);
               }
          }
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
				$msg=($blog_status==='clone')?'Your Cloned Post Has Been Deleted':'Your Post Has Been Deleted Id: P'.$blog_id; 
				$delete_arr[]=array($this->master_post_table,"where blog_id='$blog_id'",'message',$msg); 
				$delete_arr[]=array($this->master_post_css_table," where blog_id='$blog_id'",'message',"Blog id $blog_id Deleted from $this->master_post_css_table");
				$delete_arr[]=array($this->comment_table," where comment_blog_id='$blog_id'",'message',"Blog id $blog_id Deleted from $this->comment_table"); 
				 if ($blog_type==='gallery'){
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
function process_post_configcopy($blog_id){
     $parent_id=$_POST['post_configcopy'][$blog_id];
     if (strtolower(substr(trim($parent_id),0,1))!=='p'){
          $this->message[]='Post IDs Are FOUND AT THE TOP OF Each Post ie. The Number having the ID: P1, P2, etc. FORMAT. BE SURE TO INCLUDE THE P PREFIX ';
          return;
          }
    
     
     $base_value='blog_id,blog_clone_table,blog_col,blog_order,blog_type,blog_table,blog_table_base,blog_date,blog_status,blog_unstatus,blog_clone_target,blog_target_table_base,blog_temp';
     switch ($this->blog_type){
          case  'text':
          $data_val=$base_value.',blog_text';
          break;
          case  'navigation_menu':
          $data_val=$base_value.',blog_data1';
          break;
          case  'image':
		$data_val=$base_value.',blog_data1,blog_tiny_data3,blog_tiny_data4,blog_tiny_data5,blog_tiny_data6';
          break;
          case  'float_image_right':
		$data_val=$base_value.',blog_data1,blog_tiny_data3,blog_tiny_data4,blog_tiny_data5,blog_tiny_data6';
          break;
          case  'float_image_left': 
          $data_val=$base_value.'blog_data1,blog_tiny_data3,blog_tiny_data4,blog_tiny_data5,blog_tiny_data6';
          break; 
          case  'contact':
          $data_val=$base_value.',blog_data1';
          break;
          case  'social_icons':
          $data_val=$base_value.',blog_data1';
          break;
          case 'gallery':
          $data_val=$base_value.',blog_data1,blog_data7,blog_tiny_data4,blog_tiny_data5';
          break;
          case 'auto_slide':
          $data_val=$base_value.',blog_data1';
          break;
          case 'video':
          $data_val=$base_value.',blog_data1,blog_data2,blog_data3,blog_data4,blog_tiny_data1';
          break;
          default:
          $data_val=$base_value;
          }
     if (!isset($_POST['post_allconfigcopy'][$blog_id])){ 
		$fields2=',blog_width,blog_,blog_gridspace_right,blog_gridspace_left,blog_grid_width,blog_float';
		$data_val.=$fields2; 
		} 
     $black_arr=explode(',',$data_val);
     $style_list='';
     foreach(explode(',',Cfg::Post_fields) as $list){
          if (!in_array($list,$black_arr)){
               $style_list.=$list.',';
               }
          }
	$field_arr=explode(',',substr_replace($style_list,'',-1));
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
	   
function process_col_configexport($col_id){
     $parent_id=$_POST['col_configexport'][$col_id]; 
	$fields='col_options,col_grid_clone,col_gridspace_right,col_gridspace_left,col_grid_width,col_tcol_num,col_style,col_style2,col_grp_bor_style,col_comment_style,col_comment_date_style,col_comment_view_style,col_date_style,col_width,col_hr';
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
     
function process_post_flexcopy($blog_id){
     $parent_id=$_POST['post_flexcopy'][$blog_id];
          if (strtolower(substr(trim($parent_id),0,1))!=='p'){
			$this->message[]='Post IDs Are FOUND AT THE TOP OF Each Post ie. The Number having the ID: P1, P2, etc. FORMAT. BE SURE TO INCLUDE THE P PREFIX ';
			return;
			}
	$parent_id=str_replace(array('p','P'),'',$parent_id);
     $q="update $this->master_post_table t, $this->master_post_table r SET t.blog_flex_box=r.blog_flex_box, t.token='".mt_rand(1,mt_getrandmax()). "',t.blog_update='".date("dMY-H-i-s")."',t.blog_time='".time()."'"; 
     $q="$q  where t.blog_id=$blog_id and r.blog_id=$parent_id";
     
     $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
     if ($this->mysqlinst->affected_rows()){
             $this->success[]="Post p$blog_id was updated using RWD settings  from Post p$parent_id";
             }
     else $this->message[]="Problem updating with $q to Post p$blog_id from Post p$parent_id"; 
     }
     
function process_post_rwdcopy($blog_id){
     $parent_id=$_POST['post_rwdcopy'][$blog_id];
          if (strtolower(substr(trim($parent_id),0,1))!=='p'){
			$this->message[]='Post IDs Are FOUND AT THE TOP OF Each Post ie. The Number having the ID: P1, P2, etc. FORMAT. BE SURE TO INCLUDE THE P PREFIX ';
			return;
			}
	$parent_id=str_replace(array('p','P'),'',$parent_id);
     $q="update $this->master_post_table t, $this->master_post_table r SET t.blog_gridspace_right=r.blog_gridspace_right,t.blog_gridspace_left=r.blog_gridspace_left,t.blog_grid_width=r.blog_grid_width, t.token='".mt_rand(1,mt_getrandmax()). "',t.blog_update='".date("dMY-H-i-s")."',t.blog_time='".time()."'"; 
     $q="$q  where t.blog_id=$blog_id and r.blog_id=$parent_id";
     
     $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
     if ($this->mysqlinst->affected_rows()){
             $this->success[]="Post p$blog_id was updated using RWD settings  from Post p$parent_id";
             }
     else $this->message[]="Problem updating RWD settings to Post p$blog_id from Post p$parent_id"; 
     }

function process_col_rwdcopy($blog_id){
     $parent_id=$_POST['col_rwdcopy'][$blog_id];
          if (strtolower(substr(trim($parent_id),0,1))!=='c'){
			$this->message[]='Col IDs Are FOUND AT THE TOP OF Each Col ie. The Number having the ID: C1, C2, etc. FORMAT. BE SURE TO INCLUDE a c or C PREFIX ';
			return;
			}
	$parent_id=str_replace(array('c','C'),'',$parent_id);
     $q="update $this->master_col_table t, $this->master_col_table r SET t.col_gridspace_right=r.col_gridspace_right,t.col_gridspace_left=r.col_gridspace_left,t.col_grid_width=r.col_grid_width, t.token='".mt_rand(1,mt_getrandmax()). "',t.col_update='".date("dMY-H-i-s")."',t.col_time='".time()."'"; 
     $q="$q  where t.col_id=$col_id and r.col_id=$parent_id";
     $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
     if ($this->mysqlinst->affected_rows()){
             $this->success[]="Post p$col_id was updated using RWD settings  from Post p$parent_id";
             }
     else $this->message[]="Problem updating RWD settings to Post p$col_id from Post p$parent_id"; 
     }
     
function process_col_flexcopy($blog_id){
     $parent_id=$_POST['col_flexcopy'][$blog_id];
          if (strtolower(substr(trim($parent_id),0,1))!=='c'){
			$this->message[]='Col IDs Are FOUND AT THE TOP OF Each Col ie. The Number having the ID: C1, C2, etc. FORMAT. BE SURE TO INCLUDE a c or C PREFIX ';
			return;
			}
	$parent_id=str_replace(array('c','C'),'',$parent_id);
     $q="update $this->master_col_table t, $this->master_col_table r SET t.col_flex_box=r.col_flex_box, t.token='".mt_rand(1,mt_getrandmax()). "',t.col_update='".date("dMY-H-i-s")."',t.col_time='".time()."'"; 
     $q="$q  where t.col_id=$col_id and r.col_id=$parent_id";
     $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
     if ($this->mysqlinst->affected_rows()){
             $this->success[]="Post p$col_id was updated using flex settings  from Post p$parent_id";
             }
     else $this->message[]="Problem updating flex settings to Post p$col_id from Post p$parent_id"; 
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
	$parent_ref=$_POST[$port.'_import'][$this->pagename]; echo $port.' is port';  echo $parent_ref .' is pr';
	$value=''; 
	$q="update $this->master_page_table c, $this->master_page_table p SET ";
	foreach (explode(',',$fields) as $field){
		$value.="c.$field = p.$field, ";
		}
	$q.=" $value c.page_update='".date("dMY-H-i-s")."', c.page_time='".time()."',c.token='".mt_rand(1,mt_getrandmax()). "' where c.page_ref='$this->pagename' and p.page_ref='$parent_ref'";
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
		$q="update $this->master_page_table set page_options='$implode_opts' where page_ref='$this->pagename'";
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
	$value='';
	$q="update $this->master_page_table c, $this->master_page_table p   SET ";
	foreach (explode(',',$fields) as $field){
		$value.="c.$field = p.$field, ";
		}
	$q.=" $value c.page_update='".date("dMY-H-i-s")."', c.page_time='".time()."',c.token='".mt_rand(1,mt_getrandmax()). "' where  p.page_ref='$this->pagename'";
	$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	if ($this->mysqlinst->affected_rows()){
		$this->success[]="Page Configs  were imported";
		}
	else $this->message[]="Msg1: No Page Configs were affected with $q";
	if (!empty($page_opts)){
		$q="select page_options,page_id,page_ref from $this->master_page_table";  
		$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);    
		while (list($page_options,$page_id,$page_ref)=$this->mysqlinst->fetch_row($r,__LINE__)){
			if ($page_ref===$this->pagename)continue;
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
			else $this->message[]="Msg2.No Page Configs were affected with $q"; 
			}//end while
		}//end if 
	}

function process_col_rwdexport($col_id){ 
	$q="update $this->master_col_table t, $this->master_col_table r, $this->master_post_table pt, $this->master_post_table pr SET t.col_gridspace_right=r.col_gridspace_right,t.col_gridspace_left=r.col_gridspace_left,t.col_grid_width=r.col_grid_width, t.token='".mt_rand(1,mt_getrandmax()). "',t.col_update='".date("dMY-H-i-s")."',t.col_time='".time()."' where  t.col_primary!=1 and r.col_primary!=1 and r.col_id=$col_id and pt.blog_data1=t.col_id and pr.blog_data1=r.col_id and pt.blog_col=pr.blog_col"; // bt.blog_col and br.blog_col refer to the parent col ids being a match... 
	$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	if ($this->mysqlinst->affected_rows()){
		$this->success[]="col p$col_id RWD Grid settings were exported to Nested column col types directly in the parent column";
		}
	else $this->message[]="No cols were affected for RWD Grid settings update using $q in col id P$col_id";
	if (isset($_POST['col_post_rwdexport'])){
		$q="update $this->master_col_table r, $this->master_post_table pt, $this->master_post_table pr SET pt.blog_gridspace_right=r.col_gridspace_right,pt.blog_gridspace_left=r.col_gridspace_left,pt.blog_grid_width=r.col_grid_width, pt.token='".mt_rand(1,mt_getrandmax()). "',pt.blog_update='".date("dMY-H-i-s")."',pt.blog_time='".time()."' where r.col_id=$col_id and pr.blog_data1=r.col_id and pt.blog_col=pr.blog_col"; // bt.blog_col and br.blog_col refer to the parent col ids being a match... 
		$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
		if ($this->mysqlinst->affected_rows()){
		$this->success[]="col p$col_id RWD Grid settings were also exported to all direct Post types in the parent column";
		}
		else $this->message[]="No non nested columns were affected for RWD Grid settings update using $q in col id P$col_id";
		}
	}

function process_col_widthexport($col_id){ 
	$q="update $this->master_col_table t, $this->master_col_table r, $this->master_post_table pt, $this->master_post_table pr SET t.col_width=r.col_width, t.token='".mt_rand(1,mt_getrandmax()). "',t.col_update='".date("dMY-H-i-s")."',t.col_time='".time()."' where  t.col_primary!=1 and r.col_primary!=1 and r.col_id=$col_id and pt.blog_data1=t.col_id and pr.blog_data1=r.col_id and pt.blog_col=pr.blog_col"; // bt.blog_col and br.blog_col refer to the parent col ids being a match...
     $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	if ($this->mysqlinst->affected_rows()){
		$this->success[]="col p$col_id width value setting  was exported to Nested column col types directly in the parent column";
		}
	else $this->message[]="No cols were affected for RWD Grid settings update using $q in col id P$col_id";
	if (isset($_POST['col_post_widthexport'])){
		$q="update $this->master_col_table r, $this->master_post_table pt, $this->master_post_table pr SET pt.blog_width=r.col_width, pt.token='".mt_rand(1,mt_getrandmax()). "',pt.blog_update='".date("dMY-H-i-s")."',pt.blog_time='".time()."' where r.col_id=$col_id and pr.blog_data1=r.col_id and pt.blog_col=pr.blog_col"; // bt.blog_col and br.blog_col refer to the parent col ids being a match... 
		$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
		if ($this->mysqlinst->affected_rows()){
		$this->success[]="col p$col_id width value setting was also exported to all direct Post types in the parent column";
		}
		else $this->message[]="No non nested columns were affected for width value setting update using $q in col id P$col_id";
		}
	} 
 
function process_col_floatexport($blog_id){
     $include_nested=(isset($_POST['col_post_floatexport']))?'':"and t.blog_type='nested_column'";
	$q="update $this->master_post_table t, $this->master_post_table r  SET t.blog_float=r.blog_float, t.token='".mt_rand(1,mt_getrandmax()). "',t.blog_update='".date("dMY-H-i-s")."',t.blog_time='".time()."' where  r.blog_id=$blog_id and r.blog_type='nested_column'  and t.blog_col=r.blog_col $include_nested";  
	$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	if ($this->mysqlinst->affected_rows()){
		$this->success[]="col Alternative-RWD settings were exported to nested column col types in same parent column";
		}
	else $this->message[]="No cols were affected for Alternative-RWD settings update using $q "; 
	}
     
function process_col_widthmodeexport($blog_id){
     $include_nested=(isset($_POST['col_post_widthmodeexport']))?'':"and t.blog_type='nested_column'";
	$q="update $this->master_post_table t, $this->master_post_table r  SET t.blog_width_mode=r.blog_width_mode, t.token='".mt_rand(1,mt_getrandmax()). "',t.blog_update='".date("dMY-H-i-s")."',t.blog_time='".time()."' where  r.blog_id=$blog_id and r.blog_type='nested_column'  and t.blog_col=r.blog_col $include_nested";  
	$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	if ($this->mysqlinst->affected_rows()){
		$this->success[]="col Alternative-RWD settings were exported to nested column col types in same parent column";
		}
	else $this->message[]="No cols were affected for Alternative-RWD settings update using $q "; 
	}
     
function process_post_configexportdump($blog_id){//inter database
	$dir= (is_dir(Sys::Common_dir))?Sys::Common_dir:Sys::Home_pub;
	$dir=rtrim($dir,'/').'/';
     $parent_id=$_POST['post_configexportdump'][$blog_id];
	$collect=array();
	$base_value='blog_id,blog_clone_table,blog_col,blog_order,blog_type,blog_table,blog_table_base,blog_date,blog_status,blog_unstatus,blog_clone_target,blog_target_table_base,blog_temp';
     $black_arr=explode(',',$base_value);
     $style_list='';
     foreach(explode(',',Cfg::Post_fields) as $list){
          if (!in_array($list,$black_arr)){
               $style_list.=$list.',';
               }
          }
     $fields=substr_replace($style_list,'',-1);
	$field_arr=explode(',',$fields);	
	$q="select $fields from $this->master_post_table where blog_id=$parent_id"; 
	$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	if ($this->mysqlinst->affected_rows()){
		$row=$this->mysqlinst->fetch_assoc($r);
		foreach ($field_arr as $field){
			$collect[$field]=$row[$field];
			}
		file_put_contents($dir.'lastpostdump.dat',serialize($collect));
		}
	}
     
function process_post_configimportdump($blog_id){//inter database
	$dir= (is_dir(Sys::Common_dir))?Sys::Common_dir:Sys::Home_pub;
	$dir=rtrim($dir,'/').'/';
	if (!is_file($dir.'lastpostdump.dat')){
		$this->message[]=$dir.'lastpostdump.dat'.' file does not exist for data import';
		}
     $child_id=$_POST['post_configimportdump'][$blog_id];
	$collect=array();
	$base_value='blog_id,blog_clone_table,blog_col,blog_order,blog_type,blog_table,blog_table_base,blog_date,blog_status,blog_unstatus,blog_clone_target,blog_target_table_base,blog_temp';
     $black_arr=explode(',',$base_value);
     $style_list='';
     foreach(explode(',',Cfg::Post_fields) as $list){
          if (!in_array($list,$black_arr)){
               $style_list.=$list.',';
               }
          }
     $style_list=substr_replace($style_list,'',-1);
	$field_arr=explode(',',$style_list);
	$array=unserialize(file_get_contents($dir.'lastpostdump.dat'));print_r($array); 
	$q="update $this->master_post_table set "; 
	foreach ($field_arr as $field){
		$q.="$field='".$array[$field]."',";  
		}
	$q="$q token='".mt_rand(1,mt_getrandmax()). "',blog_update='".date("dMY-H-i-s")."',blog_time='".time()."' where  blog_id=$child_id";  
	$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	}
	
function process_post_configexport($blog_id){
     $parent_id=$_POST['post_configexport'][$blog_id]; 
     $base_value='blog_id,blog_clone_table,blog_col,blog_order,blog_type,blog_table,blog_table_base,blog_date,blog_status,blog_unstatus,blog_clone_target,blog_target_table_base,blog_temp';
     switch ($this->blog_type){
          case  'text':
          $data_val=$base_value.',blog_text';
          break;
          case  'navigation_menu':
          $data_val=$base_value.',blog_data1';
          break;
          case  'image':
		$data_val=$base_value.',blog_data1,blog_tiny_data3,blog_tiny_data4,blog_tiny_data5,blog_tiny_data6';
          break;
          case  'float_image_right':
		$data_val=$base_value.',blog_data1,blog_tiny_data3,blog_tiny_data4,blog_tiny_data5,blog_tiny_data6';
          break;
          case  'float_image_left':
		$data_val=$base_value.',blog_data1,blog_tiny_data3,blog_tiny_data4,blog_tiny_data5,blog_tiny_data6'; 
          break; 
          case  'contact':
          $data_val=$base_value.',blog_data1';
          break;
          case  'social_icons':
          $data_val=$base_value.',blog_data1';
          break;
          case 'gallery':
          $data_val=$base_value.',blog_data1,blog_data7,blog_tiny_data4,blog_tiny_data5';
          break;
          case 'auto_slide':
          $data_val=$base_value.',blog_data1';
          break;
          case 'video':
          $data_val=$base_value.',blog_data1,blog_data2,blog_data3,blog_data4,blog_tiny_data1';
          break;
          default:
          $data_val=$base_value;
          }
     if (!isset($_POST['post_allconfigcopy'][$blog_id])){ 
		$fields2=',blog_width,blog_,blog_gridspace_right,blog_gridspace_left,blog_grid_width,blog_float';
		$data_val.=$fields2; 
		} 
     $black_arr=explode(',',$data_val);
     $style_list='';
     foreach(explode(',',Cfg::Post_fields) as $list){
          if (!in_array($list,$black_arr)){
               $style_list.=$list.',';
               }
          }
     
	
     $field_arr=explode(',',substr_replace($style_list,'',-1));
	$q="update $this->master_post_table t, $this->master_post_table r SET ";
	foreach($field_arr as $field){
		$q.="t.$field=r.$field,";
		}
	$q="$q t.token='".mt_rand(1,mt_getrandmax()). "',t.blog_update='".date("dMY-H-i-s")."',t.blog_time='".time()."' where  t.blog_type=r.blog_type and r.blog_id=$blog_id and t.blog_table=r.blog_table";
	$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	if ($this->mysqlinst->affected_rows()){
		$this->success[]="Post p$blog_id configs  and styles were exported to the same post types directly in the parent column";
		}
	else $this->message[]="No Posts configs  and styles were exported using post id P$blog_id";	
	}
     
function process_post_rwdexport($blog_id){ 
	$q="update $this->master_post_table t, $this->master_post_table r SET t.blog_gridspace_right=r.blog_gridspace_right,t.blog_gridspace_left=r.blog_gridspace_left,t.blog_grid_width=r.blog_grid_width, t.token='".mt_rand(1,mt_getrandmax()). "',t.blog_update='".date("dMY-H-i-s")."',t.blog_time='".time()."' where  t.blog_type!='nested_column' and r.blog_id=$blog_id and t.blog_table=r.blog_table";
	$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	if ($this->mysqlinst->affected_rows()){
		$this->success[]="Post p$blog_id RWD Grid settings were exported to  non nested column post types directly in the parent column";
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
function process_post_widthmodeexport($blog_id){
	$include_nested=(isset($_POST['post_col_widthmodeexport']))?'':"t.blog_type!='nested_column' and";
	$msg_nested=(isset($_POST['post_col_widthmodeexport']))?' including nested column posts':'';
	$q="update $this->master_post_table t, $this->master_post_table r SET t.blog_width_mode=r.blog_width_mode,
		 t.token='".mt_rand(1,mt_getrandmax()). "',t.blog_update='".date("dMY-H-i-s")."',t.blog_time='".time()."' where $include_nested  r.blog_id=$blog_id and t.blog_table=r.blog_table";
	$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	if ($this->mysqlinst->affected_rows()){
		$this->success[]="Post p$blog_id Alternative-RWD settings were exported to  post types $msg_nested in this parent column";
		}
	else $this->message[]="No Posts were affected for Alternative-RWD settings update using $q in post id P$blog_id";
	}
     
function process_post_heightexport($blog_id){ return;
	$include_nested=(isset($_POST['post_col_heightexport']))?'':"t.blog_type!='nested_column' and";
	$msg_nested=(isset($_POST['post_col_heightexport']))?' including nested column posts':'';
	$q="update $this->master_post_table t, $this->master_post_table r SET t.blog_height=r.blog_height,
	 t.token='".mt_rand(1,mt_getrandmax()). "',t.blog_update='".date("dMY-H-i-s")."',t.blog_time='".time()."' where $include_nested r.blog_id=$blog_id and t.blog_table=r.blog_table";
	$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	if ($this->mysqlinst->affected_rows()){
		$this->success[]="Post p$blog_id height setting was exported to post types $msg_nested in this column";
		}
	else $this->message[]="No Posts were affected for height update using using post id P$blog_id";
	}
     
function process_post_floatexport($blog_id){
	$include_nested=(isset($_POST['post_col_floatexport']))?'':"t.blog_type!='nested_column' and";
	$msg_nested=(isset($_POST['post_col_floatexport']))?' including nested column posts':'';
	$q="update $this->master_post_table t, $this->master_post_table r SET t.blog_float=r.blog_float,
	 t.token='".mt_rand(1,mt_getrandmax()). "',t.blog_update='".date("dMY-H-i-s")."',t.blog_time='".time()."' where $include_nested r.blog_id=$blog_id and t.blog_table=r.blog_table";
	$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	if ($this->mysqlinst->affected_rows()){
		$this->success[]="Post p$blog_id float setting was exported to  post types$msg_nested in the parent column";
		}
	else $this->message[]="No Posts were affected for float update using using post id P$blog_id";
	}
     
function process_post_flexexport($blog_id){ 
     $where2=(isset($_POST['post_col_flex_item_export'][$blog_id]))?'':"and t.blog_type !='nested_column'"; 
	 $q="update $this->master_post_table t, $this->master_post_table r SET t.blog_flex_box=r.blog_flex_box,
	 t.token='".mt_rand(1,mt_getrandmax()). "',t.blog_update='".date("dMY-H-i-s")."',t.blog_time='".time()."' where  r.blog_id=$blog_id and t.blog_table=r.blog_table $where2";
	$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	if ($this->mysqlinst->affected_rows()){
		$this->success[]="Post p$blog_id flex setting was exported to  post types in the parent column";
		}
	else $this->message[]="No Posts were affected for flex update using using post id P$blog_id";
		#note the above query also updated the blog width of the nested column pointer record but nested column value is actually set in col_width so will subsequently be copied here in second query.  
		 
	}
     
function process_post_styleexport($blog_id){
     $type_option=(isset($_POST['export_allpoststyle_match'][$blog_id]))?' and r.blog_type=t.blog_type ':'';
     $field=$_POST['post_styleexport'][$blog_id];
     $q="update $this->master_post_table t, $this->master_post_table r SET t.$field=r.$field,
	 t.token='".mt_rand(1,mt_getrandmax()). "',t.blog_update='".date("dMY-H-i-s")."',t.blog_time='".time()."' where  r.blog_id=$blog_id and t.blog_table=r.blog_table $type_option";
	$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	if ($this->mysqlinst->affected_rows()){
		$this->success[]="Post p$blog_id $field setting was exported to  post types in the parent column";
		}
	else $this->message[]="No Posts were affected for flex update using using post id P$blog_id";
		#note the above query also updated the blog width of the nested column pointer record but nested column value is actually set in col_width so will subsequently be copied here in second query.  
		 
	}
     
function process_col_flexitemexport($blog_id){ //will affect same field as process_post_flexexport
     $where2=(isset($_POST['col_post_flexitemexport'][$blog_id]))?'':"and t.blog_type ='nested_column'"; 
	 $q="update $this->master_post_table t, $this->master_post_table r SET t.blog_flex_box=r.blog_flex_box,
	 t.token='".mt_rand(1,mt_getrandmax()). "',t.blog_update='".date("dMY-H-i-s")."',t.blog_time='".time()."' where  r.blog_id=$blog_id and t.blog_table=r.blog_table $where2";
	$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	if ($this->mysqlinst->affected_rows()){
		$this->success[]="Post p$blog_id flex setting was exported to  nested column types in the parent column";
		}
	else $this->message[]="No Posts were affected for flex update using using post id P$blog_id";
		#note the above query also updated the blog width of the nested column pointer record but nested column value is actually set in col_width so will subsequently be copied here in second query.  
	 }
     
function process_post_widthexport($blog_id){
	$q="update $this->master_post_table t, $this->master_post_table r SET t.blog_width=r.blog_width,
	 t.token='".mt_rand(1,mt_getrandmax()). "',t.blog_update='".date("dMY-H-i-s")."',t.blog_time='".time()."' where  r.blog_id=$blog_id and t.blog_table=r.blog_table";
	$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	if ($this->mysqlinst->affected_rows()){
		$this->success[]="Post p$blog_id width setting was exported to post types in the parent column";
		}
	else $this->message[]="No Posts were affected for width update using using post id P$blog_id";
	if(isset($_POST['post_col_widthexport'][$blog_id])){
		#note the above query also updated the blog width of the nested column pointer record but nested column value is actually set in col_width so will subsequently be copied here in second query.  
		$q="update $this->master_col_table t, $this->master_post_table s, $this->master_post_table r SET t.col_width=r.blog_width,
	 t.token='".mt_rand(1,mt_getrandmax()). "',t.col_update='".date("dMY-H-i-s")."',t.col_time='".time()."' where r.blog_type='nested_column' and r.blog_data1=t.col_id and s.blog_id=$blog_id and s.blog_table=r.blog_table";
		$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
		if ($this->mysqlinst->affected_rows()){
			$this->success[]="Post p$blog_id width setting was exported to nested col types in the parent column";
			}
		else $this->message[]="$q  No Posts were affected for width update to include nested columns using using post id P$blog_id";
		}
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
			$this->message[]="col table base not found with $q";
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
	$fields='col_options,col_status,col_grid_width,col_grid_clone,col_gridspace_right,col_gridspace_left,col_primary,col_clone_target,col_clone_target_base,col_style,col_style2,col_grp_bor_style,col_comment_style,col_comment_date_style,col_comment_view_style,col_date_style,col_width';	
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

function blog_option_choices($type,$blog_id=''){
    $blog_fields_arr=array('comment_options'=>array('blog_comment','blog_comment_display'),
                           'date_options'=>array('blog_date_on','blog_date_format'),
                           'vertical_alignment_non_flexmode'=>array('blog_vert_pos'),
                           'display_options'=>array('blog_display_max','blog_display_min'),
                           'animation_options'=>array('blog_animation'),
                           'opacity_option'=>array('blog_opacity'), 
                           'alt_width_unit_em_rem_etc_options'=>array('blog_width_opt','blog_min_width_opt','blog_max_width_opt'),
                           'height_options'=>array('blog_height_opt','blog_min_height_opt','blog_max_height_opt','blog_height_media'),
                           'position_options'=>array('blog_position','blog_pos_vert_val','blog_pos_horiz_val'),
                           'overflow_options'=>array('blog_overflowx','blog_overflowy'));
     if ($type==='export'){//one has to select and parse each blog for the individaal styles chosen...
          $this->show_more('Check individual Fields to export');
          $this->print_redwrap('individual export');
          printer::print_tip('Use individual blog options from this post to be exported to all other post types (except nested columns) directly within the same parent column. Parses field: blog_options');
          printer::alertx('<p class="fs1info editfontfamily info editbackground floatleft clear italic underline" title="If checking this box only '.$this->blog_type.' posts within the parent column will be updated with chosen options"><input type="checkbox" value="1" name="export_blog_option_match['.$this->blog_id.']" value="">Require matching post type.</p>');
          printer::alert('Check individual fields to export:');
          foreach ($blog_fields_arr as $index => $array){
               printer::alert('<input type="checkbox" value="1" name="export_blog_options['.$this->blog_id.']['.$index.']">'.str_replace('_',' ',$index));
               }
          $this->submit_button();
          printer::close_print_wrap('individual export');
          $this->show_close('Check individual Fields to export');
          }//end export
     elseif ($type==='import'){
          $this->show_more('Check individual Fields to import');
          $this->print_redwrap('individual export');
          printer::print_tip('Choose the post id you wish to import individual post options from. Can be any post type to any post type (except nested columns). Use p prefix. parses field: blog_options');
          printer::alert('<input type="text" size="6" name="import_blog_option_donor['.$this->blog_id.']" value="">Enter post id you wish to import blog option values from to this post.'); 
          printer::alert('Check individual fields to export:');
          foreach ($blog_fields_arr as $index => $array){
               printer::alert('<input type="checkbox" value="'.$this->blog_id.'" name="import_blog_options['.$this->blog_id.']['.$index.']">'.str_replace('_',' ',$index));
               }
          $this->submit_button();
          printer::close_print_wrap('individual export');
          $this->show_close('Check individual Fields to export');
          }//end import
     elseif ($type==='import_option'){
          
          if (!isset($_POST['import_blog_option_donor'][$blog_id]))return;
          $parent_id=$_POST['import_blog_option_donor'][$blog_id];
          if (trim(strtolower(substr($parent_id,0,1)))!=='p'){
               $this->message[]='Use p prefix for post ids';
               return;
               }
          $parent_id=substr_replace(trim($parent_id),'',0,1);
          #get and explode blog options that will be individually replaced
          $q="select blog_options from $this->master_post_table where blog_id=$blog_id";
          $r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
          if (!$this->mysqlinst->affected_rows()){
               $this->message[]=$q .' no affected rows searching for blog_options from post id p'.$blog_id;
               return;
               }
          list($blog_options) = $this->mysqlinst->fetch_row($r,__LINE__);
          $blog_options=explode(',',$blog_options);
          $count=count(explode(',',Cfg::Blog_options));
          for ($i=0; $i<$count; $i++){
               if (!array_key_exists($i,$blog_options)){
                    $blog_options[$i]=0;
                    }
               }
          #get and explode blog options of parent that will individually be used for substituting into post
          $q="select blog_options from $this->master_post_table where blog_id=$parent_id";
          $r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
          if (!$this->mysqlinst->affected_rows()){
               $this->message[]=$q .' no affected rows searching for blog_options from post id p'.$parent_id;
               return;
               }
          list($im_blog_options) = $this->mysqlinst->fetch_row($r,__LINE__);
          $im_blog_arr=explode(',',$im_blog_options); 
          for ($i=0; $i<$count; $i++){
               if (!array_key_exists($i,$im_blog_arr)){
                    $im_blog_arr[$i]=0;
                    }
               }
           $new_blog_arr=array();
          foreach ($blog_fields_arr as $index => $array){
               if (isset($_POST['import_blog_options'][$blog_id][$index])){
                    foreach ($array as $subindex){
                         $new_blog_arr[$this->{$subindex.'_index'}]=$im_blog_arr[$this->{$subindex.'_index'}];
                         }
                    }//if post exists
               else { 
                    foreach ($array as $subindex){
                         $new_blog_arr[$this->{$subindex.'_index'}]=$blog_options[$this->{$subindex.'_index'}];
                         }
                    }//post does not exist
               }
           $exarr=array();
               for ($a=0; $a<$count; $a++){  
                    if (!array_key_exists($a,$new_blog_arr)){ 
                         $new_blog_arr[$a]=0;
                         }
                    $exarr[]=$new_blog_arr[$a];
                    }   
          $new_blog_opt=implode(',',$exarr);  
          $q="update $this->master_post_table  set token='".mt_rand(1,mt_getrandmax()). "',blog_update='".date("dMY-H-i-s")."',blog_time='".time()."',blog_options='$new_blog_opt' where blog_id=$blog_id ";   
          $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
          if ($this->mysqlinst->affected_rows()){
                  $this->success[]="Post p$blog_id was updated using individual blog_options from Post p$parent_id";
                  }
          else $this->message[]="Using $q there was No updating Post p$blog_id with Post p$parent_id blog options"; 
          }//end import
     elseif ($type==='export_option'){  
          if (!isset($_POST['export_blog_options'][$blog_id]))return;
          $parent_id=$blog_id;
          $type_option=(isset($_POST['export_blog_option_match'][$blog_id]))?' and r.blog_type=d.blog_type ':'';
          $count=count(explode(',',Cfg::Blog_options));
          $q="select blog_options from master_post where blog_id=$parent_id"; 
          $r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
          if (!$this->mysqlinst->affected_rows()){
               $this->message[]=$q .' no affected rows searching for blog_options from post id p'.$parent_id;
               return;
               }
          list($blog_opts)=$this->mysqlinst->fetch_row($r,__LINE__);
          $blog_options=explode(',',$blog_opts); 
          for ($i=0; $i<$count; $i++){ 
               if (!array_key_exists($i,$blog_options)){
                   $blog_options[$i]=0;
                    } 
               }
         $q="select r.blog_id,r.blog_options from master_post as r, master_post as d where r.blog_col=d.blog_col and r.blog_id != $blog_id and d.blog_id=$blog_id $type_option";  
          $r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
          if (!$this->mysqlinst->affected_rows()){
               $this->message[]=$q ." no affected rows searching for blog_options from post id p$parent_id";
               return;
               }
          
          while(list($blog_id,$im_blog_options) = $this->mysqlinst->fetch_row($r,__LINE__)){ 
               $im_blog_arr=explode(',',$im_blog_options); 
               for ($i=0; $i<$count; $i++){ 
                    if (!array_key_exists($i,$im_blog_arr)){
                         $im_blog_arr[$i]=0;
                         } 
                    }
               $new_blog_arr=array();
               foreach ($blog_fields_arr as $index => $array){
                    if (isset($_POST['export_blog_options'][$parent_id][$index])){
                         foreach ($array as $subindex){ 
                              $new_blog_arr[$this->{$subindex.'_index'}]=$blog_options[$this->{$subindex.'_index'}];  
                              }
                         }//if post exists
                    else { 
                         foreach ($array as $subindex){
                              $new_blog_arr[$this->{$subindex.'_index'}]=$im_blog_arr[$this->{$subindex.'_index'}];
                              }
                         }//post does not exist
                    }
               $exarr=array();
               for ($a=0; $a<$count; $a++){  
                    if (!array_key_exists($a,$new_blog_arr)){ 
                         $new_blog_arr[$a]=0;
                         }
                    $exarr[]=$new_blog_arr[$a];
                    }   
               $new_blog_opt=implode(',',$exarr);  
               $q="update $this->master_post_table set token='".mt_rand(1,mt_getrandmax())."',blog_update='".date("dMY-H-i-s")."',blog_time='".time()."',blog_options='$new_blog_opt' where blog_id=$blog_id ";   
               $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
               if ($this->mysqlinst->affected_rows()){
                       $this->success[]="Post p$blog_id was updated using individual blog_options from Post p$parent_id";
                       }
               else $this->message[]="Using $q there was No updating Post p$blog_id with Post p$parent_id blog options"; 
               }//end while.. 
          }//end export
     }
     

function port_style_choices($type,$id,$ptype,$field='',$list_order=''){ 
     switch($ptype){
          case 'page' :
               $table=$this->master_page_table;
               $typeid='page_id';
               $prefix='';
               break;
          case 'col':
               $table=$this->master_col_table;
               $typeid='col_id';
               $prefix='';
               break;
          case 'blog':
               $table=$this->master_post_table;
               $typeid='blog_id';
               
               $prefix='';
               break;
          case 'colclone':
               $table=$this->master_col_css_table;
               $typeid='col_id';
               $prefix='c';
               break;
          case 'blogclone':
               $table=$this->master_post_css_table;
               $typeid='blog_id';
               $prefix='p';
               break;
          default: return;
          }
               
              
     if (empty($list_order))$list_order=explode(',',Cfg::Style_functions);
     $blog_fields_arr['Advanced Style']=array('custom_style'); 
     foreach ($list_order as $fstyle){
          if ($fstyle==='custom_style')continue;
          elseif (!empty($fstyle))$blog_fields_arr[$fstyle]=array($fstyle);//note you can add grouping such as all margins.. see example with blog_option_choices
          } 
     $list_order[]='Advanced Style';//diff name used for custom_style
     if ($type==='export'){//one has to select and parse each blog for the individaal styles chosen...
          $this->show_more('Check individual Fields to export');
          $this->print_redwrap('individual export');
          printer::print_tip('Choose individual style options from this post to be exported to all other post types (except nested columns) directly within the same parent column. Parses field: '.$field);
          printer::alertx('<p class="fs1info editfontfamily info editbackground floatleft clear italic underline" title="If checking this box only '.$this->blog_type.' posts within the parent column will be updated with chosen options"><input type="checkbox" value="1" name="export_blog_style_match['.$this->blog_id.']" value="">Require matching post type.</p>');
          printer::alert('Check individual fields to export:');
          foreach ($blog_fields_arr as $index => $array){
               (in_array($index,$list_order))&&printer::alert('<input type="checkbox" value="1" name="export_'.$ptype.'_style['.$id.']['.$index.']['.$field.']">'.str_replace('_',' ',$index));
               }
          $this->submit_button();
          printer::close_print_wrap('individual export');
          $this->show_close('Check individual Fields to export');
          }//end export
     elseif ($type==='import'){
          $this->show_more('Check individual Fields to import');
          $this->print_redwrap('individual export');
          $list_order[]='Advanced Style';//diff name used for custom_style
          printer::print_tip('Choose the post id you wish to import individual styling options from. Can be any post type to any post type (except nested columns). Use p prefix. parses field: '.$field);
          printer::alert('<input type="text" size="6" name="import_blog_style_donor['.$this->blog_id.']" value="">Enter post id you wish to import blog option values from to this post.'); 
          printer::alert('Check individual fields to export:');
          foreach ($blog_fields_arr as $index => $array){
               (in_array($index,$list_order))&&printer::alert('<input type="checkbox" value="'.$this->blog_id.'" name="import_'.$ptype.'_style['.$id.']['.$index.']['.$field.']">'.str_replace('_',' ',$index));
               }
          $this->submit_button();
          printer::close_print_wrap('individual export');
          $this->show_close('Check individual Fields to export');
          }//end import
     elseif ($type==='import_option'){ 
          if (!isset($_POST['import_blog_style_donor'][$id])){
               $this->message[]='You Also Need to enter a post id from which to copy the selected style';
               return;
               }
          $parent_id=$_POST['import_blog_style_donor'][$id];
          if (trim(strtolower(substr($parent_id,0,1)))!=='p'){
               $this->message[]='Use p prefix for post ids';
               return;
               }
          $parent_id=substr_replace(trim($parent_id),'',0,1);
          foreach ($_POST['import_blog_style'][$id] as $key =>$val){
               $field=key($val);
               #get and explode blog options that will be individually replaced
               $q="select $field from $table where $typeid=$prefix$id";
               $r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
               if (!$this->mysqlinst->affected_rows()){
                    $this->message[]=$q ." no affected rows searching for $field from type $ptype using $prefix  $id";
                    return;
                    }
               list($blog_style) = $this->mysqlinst->fetch_row($r,__LINE__);
               $blog_style=explode(',',$blog_style);
               $count=count(explode(',',Cfg::Style_functions));
               for ($i=0; $i<$count; $i++){
                    if (!array_key_exists($i,$blog_style)){
                         $blog_style[$i]=0;
                         }
                    }
               #get and explode blog options of parent that will individually be used for substituting into post
               $q="select $field from $table where $typeid=$parent_id";
               $r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
               if (!$this->mysqlinst->affected_rows()){
                    $this->message[]=$q ." no affected rows searching for $field from post id p $parent_id";
                    return;
                    }
               list($im_blog_style) = $this->mysqlinst->fetch_row($r,__LINE__);
               $im_blog_arr=explode(',',$im_blog_style); 
               for ($i=0; $i<$count; $i++){
                    if (!array_key_exists($i,$im_blog_arr)){
                         $im_blog_arr[$i]=0;
                         }
                    }
                $new_blog_arr=array();
               foreach ($blog_fields_arr as $index => $array){
                    if (isset($_POST['import_blog_style'][$id][$index])){
                         foreach ($array as $subindex){ 
                              $new_blog_arr[$this->{$subindex.'_index'}]=$im_blog_arr[$this->{$subindex.'_index'}];
                              }
                         }//if post exists
                    else { 
                         foreach ($array as $subindex){
                              $new_blog_arr[$this->{$subindex.'_index'}]=$blog_style[$this->{$subindex.'_index'}];
                              }
                         }//post does not exist
                    } 
                $exarr=array();
                    for ($a=0; $a<$count; $a++){  
                         if (!array_key_exists($a,$new_blog_arr)){ 
                              $new_blog_arr[$a]=0;
                              }
                         $exarr[]=$new_blog_arr[$a];
                         }   
               $new_blog_opt=implode(',',$exarr);  
               $q="update $table  set token='".mt_rand(1,mt_getrandmax()). "',blog_update='".date("dMY-H-i-s")."',blog_time='".time()."',$field='$new_blog_opt' where $typeid='$prefix$id'";   
               $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
               if ($this->mysqlinst->affected_rows()){
                       $this->success[]="Post p$id was updated using individual blog style in field $field from Post p$parent_id";
                       }
               else $this->message[]="Using $q there was No updating Post p$id with Post p$parent_id blog options";
               }
          }//end import
     elseif ($type==='export_option'){  
          if (!isset($_POST['export_blog_style'][$id]))return;
               $type_option=(isset($_POST['export_'.$ptype.'_style_match'][$id]))?' and r.blog_type=d.blog_type ':'';
           foreach ($_POST['export_blog_style'][$id] as $key =>$val){
               $field=key($val);
               $parent_id=$id;
               $count=count(explode(',',Cfg::Style_functions));
               $q="select $field from $table where $typeid='$prefix$parent_id'"; 
               $r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
               if (!$this->mysqlinst->affected_rows()){
                    $this->message[]=$q ." no affected rows searching for blog style in $field from post id p$parent_id";
                    return;
                    }
               list($blog_opts)=$this->mysqlinst->fetch_row($r,__LINE__);
               $blog_style=explode(',',$blog_opts); 
               for ($i=0; $i<$count; $i++){ 
                    if (!array_key_exists($i,$blog_style)){
                        $blog_style[$i]=0;
                         } 
                    }
              $q="select r.$typeid,r.$field from $table as r, $table as d where r.blog_col=d.blog_col and r.blog_id != $id and d.blog_id=$id $type_option";  
               $r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
               if (!$this->mysqlinst->affected_rows()){
                    $this->message[]=$q ." no affected rows searching for blog style in $field from post id p$parent_id";
                    return;
                    }
               
               while(list($blog_id,$im_blog_style) = $this->mysqlinst->fetch_row($r,__LINE__)){ 
                    $im_blog_arr=explode(',',$im_blog_style); 
                    for ($i=0; $i<$count; $i++){ 
                         if (!array_key_exists($i,$im_blog_arr)){
                              $im_blog_arr[$i]=0;
                              } 
                         }
                    $new_blog_arr=array();
                    foreach ($blog_fields_arr as $index => $array){
                         if (isset($_POST['export_blog_style'][$parent_id][$index])){
                              foreach ($array as $subindex){ 
                                   $new_blog_arr[$this->{$subindex.'_index'}]=$blog_style[$this->{$subindex.'_index'}];  
                                   }
                              }//if post exists
                         else { 
                              foreach ($array as $subindex){
                                   $new_blog_arr[$this->{$subindex.'_index'}]=$im_blog_arr[$this->{$subindex.'_index'}];
                                   }
                              }//post does not exist
                         }
                    $exarr=array();
                    for ($a=0; $a<$count; $a++){  
                         if (!array_key_exists($a,$new_blog_arr)){ 
                              $new_blog_arr[$a]=0;
                              }
                         $exarr[]=$new_blog_arr[$a];
                         }   
                    $new_blog_opt=implode(',',$exarr);  
                    $q="update $this->master_post_table set token='".mt_rand(1,mt_getrandmax())."',blog_update='".date("dMY-H-i-s")."',blog_time='".time()."',$field='$new_blog_opt' where blog_id=$blog_id ";   
                    $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
                    if ($this->mysqlinst->affected_rows()){
                            $this->success[]="Post p$blog_id was updated using individual blog style in $field from Post p$parent_id";
                            }
                    else $this->message[]="Using $q there was No updating Post p$blog_id with Post p$parent_id blog options"; 
                    }//end while..
                    }
          }//end export
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
	$q="select col_table,col_id,col_status from $this->master_col_table where col_table_base='$this->pagename'";
	$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	while(list($col_table,$col_id,$col_status)=$this->mysqlinst->fetch_row($r,__LINE__)){
		if(isset($_POST['deletecolumn'][$col_table])&&$_POST['deletecolumn'][$col_table]==='delete'){
			$status=($col_status==='clone')?true:false; 
			$this->delete_col($col_id,$status);
			//$this->message[]='Cloned Column Id'.$col_id.' has Successfully Been Deleted';
			}
		} 
	}
	
function process_new_blog_table(){ //creates new primary ppCol and also orders col_num for primaries  
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
	$col_table_base=$this->pagename;
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
		$q="update $this->master_col_table set col_table='$this->pagename".Cfg::Col_suffix."$col_id' where col_id='$col_id'"; 
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
	$q="select col_id,col_tcol_num  from $this->master_col_table where col_table_base='$this->pagename' and col_primary=1 order by col_tcol_num"; 
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
		if ($type==='post'){
			$q="delete from $this->master_post_table where blog_id='$id' and blog_table_base='$this->pagename'";
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
					$q="delete from $this->master_post_table where blog_data1='$id' and blog_table_base='$this->pagename'";
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
		if ($switch===$this->choose_blog_type)continue;
		if (isset($_POST['unclone_option_copy'][$blog_id])){ 
			$msg='You have choosen both UnClone Clone and a Mirror release Fresh Dropdown  Option  for post Id: P'. $blog_id. ': Choose Only One';
			$this->message[]=$msg;  
			continue;
			} 
		$tablename='uncle_'.$this->pagename.'_id'.$blog_id;
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
		$tablename='uncle_'.$this->pagename.'_id'.$blog_id;  
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
               if($field==='blog_table_base')$value.="'$this->pagename',";
               elseif($field==='blog_table')$value.="'$tablename',";
               elseif($field==='blog_col')$value.="'0',";
               elseif($field==='blog_clone_target')$value.="'',";//clear off instead ".$row1['blog_id']."',";
               elseif($field==='blog_status')$value.="'unclone',";
               elseif($field==='blog_order')$value.="'10',";
               elseif($field==='blog_unstatus')$value.="'unclone',";
               elseif($field==='blog_unclone')$value.="'$blog_id',";
               elseif($field==='blog_data6')$value.="'$parent_id',";
               else $value.="'$row1[$field]',";
               }
		$q="insert into $this->master_post_table  ($post_fields,blog_update,blog_time,token) values ($value '".date("dMY-H-i-s")."','".time()."','".mt_rand(1,mt_getrandmax())."')";   
		$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
		$this->mysqlinst->count_field($this->master_post_table,'blog_id','',false,'');  
		$blog_id=$this->mysqlinst->fieldmax;
		if  ($row1['blog_type']==='nested_column'&&is_numeric($row1['blog_data1'])){
			$q="select $col_fields from $this->master_col_table where col_id=".$row1['blog_data1'];   
			$r3=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
			$row2 = $this->mysqlinst->fetch_assoc($r3,__LINE__); 
			$value='';
			foreach ($this->col_field_arr as $field) {
				if($field==='col_table_base')$value.="'$this->pagename',";
				elseif($field==='col_table')$value.="'',";
				elseif($field==='col_num')$value.="0,";  
				elseif($field==='col_status')$value.="'unclone',";
				elseif($field==='col_clone_target')$value.="'".$row1['blog_data1']."',";
				elseif($field==='col_clone_target_base')$value.="'".$row2['col_table_base']."',";
				elseif($field==='col_status')$value.="'copy',";
				else $value.="'".$row2[$field]."',"; 
				}   
			$q="insert into $this->master_col_table ($col_fields,col_update,col_time,token) values ( $value '".date("dMY-H-i-s")."','".time()."','".mt_rand(1,mt_getrandmax())."')";    
			$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
			$this->mysqlinst->count_field($this->master_col_table,'col_id','',false,'');  
			$col_id=$this->mysqlinst->fieldmax;
			$q="update $this->master_col_table set col_table='$this->pagename".Cfg::Col_suffix."$col_id' where col_id='$col_id'"; 
			$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
			$q="update $this->master_post_table set token='".mt_rand(1,mt_getrandmax()). "',blog_data1='$col_id',blog_data2='$this->pagename".Cfg::Col_suffix."$col_id' where blog_id=$blog_id";   
			$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
			$this->copy_col($col_id,$row1['blog_data1'],'copy',false);
			}
		$this->success[]="You Have Created a New Mirror release Post";
		}
	}
	
function create_blog($tablename,$switch,$blog_order,$insert_amt,$blog_unclone='',$blog_unstatus='',$blog_width='',$blog_float='center row',$blog_data6=''){
     #get the processed blog updated style 
	$bigtext='In Edit mode click the image to upload a new one. "Well, in our country," said Alice, still panting a little, "you&#39;d generally get to somewhere else—if you run very fast for a long time, as we&#39;ve been doing."<br><br>

"A slow sort of country!" said the Queen. "Now, here, you see, it takes all the running you can do, to keep in the same place. If you want to get somewhere else, you must run at least twice as fast as that!"--everything seemed to have changed since her swim in the pool, and the great hall, with the glass table and the little door, had vanished completely. '; 
	$default_video='';
          for ($x=1;$x<16;$x++){
               ${'blog_data'.$x}='';
               ${'blog_tiny_data'.$x}='';
               }
     $blog_options='';
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
          case	$this->blog_drop_array[0]:# nested column
               //$this->column_new_array[]=$col_id;
               //$this->mysqlinst->count_field($this->master_col_table,'col_num','',false,'');
               $col_width=(!empty($blog_width))?$blog_width:'';//blog width is updated in funct col_data and $blog_width is copied for intitialize unclone for position consistency of unclone columns and posts!!
               $col_fields=Cfg::Col_fields; 
               $col_field_arr=explode(',',$col_fields);
               $value='';
               foreach ($col_field_arr as $field) {
                    if($field==='col_table_base')$value.="'$this->pagename',";
                    elseif($field==='col_options')$value.="'',";//adjusted subsequent 
                    elseif($field==='col_num')$value.="0,";
                    elseif($field==='col_status')$value.="'$blog_unstatus',";
                    elseif($field==='col_primary')$value.="'0',";
                    elseif($field==='col_width')$value.="'$col_width',";  
                    elseif($field==='col_tcol_num')$value.="'0',";
                    else $value.="'',"; 
                    }    
               $q="insert into $this->master_col_table ($col_fields,col_update,col_time,token) values ($value '".date("dMY-H-i-s")."','".time()."','".mt_rand(1,mt_getrandmax())."')";  
               $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
               $this->mysqlinst->count_field($this->master_col_table,'col_id','',false,'');  
               $new_col_id=$this->mysqlinst->fieldmax;
               $q="update $this->master_col_table set col_table='$this->pagename".Cfg::Col_suffix."$new_col_id' where col_id='$new_col_id'"; 
               $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
               $blog_text='Nested Column';
               $blog_type='nested_column';
               $blog_pub=1;//set nested column publish true by default
               $blog_data1=$new_col_id;
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
          case $this->blog_drop_array[9]:#gall 
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
               $blog_options=',,,,,,,,,,,,,,absolute@@768@@@@right@@40.0@@top@@15.0@@30,,,,,,,0,20,0@@@@1.5';
               $blog_data2 =',0,0,20,0,0,0,0,0,0,0,0,left,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat';
$blog_data3 ='';
$blog_data4 =',10,10,10,10,0,0,0,0,0,18,500,left,0,0,0,0,0,0,0,@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat,0,0,0,0,0,0@@555@@0@@No Border,,a:0:{},,,,,,,,,,,,,';
$blog_data5 =',0,0,0,768,0,2.30,0,0,0,0,0,0,0,zero,10,0,zero,right,220@@@@none@@none,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat,none';
$blog_data6 =',0,0,0,0,0,0,0,0,0,0,0,0,604679,0,0,0,0,0,0,FAFCFF@@vertical@@F4F6F9@@ffffff@@ffffff@@ffffff@@ffffff@@fafcff@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat,,,,@@@@0@@6@@0@@inset';
$blog_data7 =',0,0,0,0,30,0,20,0,0,0,0,0,0,0,0,0,0,0,0,ffffff@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat,,,,,,0@@0@@@@No Border,,a:0:{},,,,,,,,,,40,,20';
$blog_data8 =',0,,,,36,,,,,,,,,,,,,,,FFFfff@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat,,,,,,3@@D6DBDD@@@@top bottom left right,,a:1:{i:0;a:1:{i:1;s:11:"right:10px;";}}';
$blog_data12 =',,,,,,,,,,,,,,,,,,,,0@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat';
$blog_tiny_data1 ='0,0,0,0,950,white,4.00,100,Over,0,nomanage,1,,fadeInRight,,5';
$blog_tiny_data11 =',,,,,,,,,,,,,632E0E,,,,,,,FFF7F7@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat';
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
		if($field==='blog_clone_table')$value.="'$blog_clone_table',";
		elseif($field==='blog_data1')$value.="'$blog_data1',";
		elseif($field==='blog_data2')$value.="'$blog_data2',";
		elseif($field==='blog_data3')$value.="'$blog_data3',";
		elseif($field==='blog_data4')$value.="'$blog_data4',";
		elseif($field==='blog_data5')$value.="'$blog_data5',";
		elseif($field==='blog_data6')$value.="'$blog_data6',";
		elseif($field==='blog_data7')$value.="'$blog_data7',";
		elseif($field==='blog_data8')$value.="'$blog_data8',";
		elseif($field==='blog_data9')$value.="'$blog_data9',";
		elseif($field==='blog_data10')$value.="'$blog_data10',";
		elseif($field==='blog_data11')$value.="'$blog_data11',";
		elseif($field==='blog_data12')$value.="'$blog_data12',";
		elseif($field==='blog_data13')$value.="'$blog_data13',";
		elseif($field==='blog_data14')$value.="'$blog_data14',";
		elseif($field==='blog_data15')$value.="'$blog_data15',";
		elseif($field==='blog_tiny_data1')$value.="'$blog_tiny_data1',";
		elseif($field==='blog_tiny_data2')$value.="'$blog_tiny_data2',";
		elseif($field==='blog_tiny_data3')$value.="'$blog_tiny_data3',";
		elseif($field==='blog_tiny_data4')$value.="'$blog_tiny_data4',";
		elseif($field==='blog_tiny_data5')$value.="'$blog_tiny_data5',";
		elseif($field==='blog_tiny_data6')$value.="'$blog_tiny_data6',";
		elseif($field==='blog_tiny_data7')$value.="'$blog_tiny_data7',";
		elseif($field==='blog_tiny_data8')$value.="'$blog_tiny_data8',";
		elseif($field==='blog_tiny_data9')$value.="'$blog_tiny_data9',";
		elseif($field==='blog_tiny_data10')$value.="'$blog_tiny_data10',";
		elseif($field==='blog_tiny_data11')$value.="'$blog_tiny_data11',";
		elseif($field==='blog_tiny_data12')$value.="'$blog_tiny_data12',";
		elseif($field==='blog_tiny_data13')$value.="'$blog_tiny_data13',";
		elseif($field==='blog_tiny_data14')$value.="'$blog_tiny_data14',";
		elseif($field==='blog_tiny_data15')$value.="'$blog_tiny_data15',";
		elseif($field==='blog_style')$value.="'$blog_style',";
		elseif($field==='blog_date')$value.="'$blog_date',";
		elseif($field==='blog_text')$value.="'$blog_text',";
		elseif($field==='blog_type')$value.="'$blog_type',";
		elseif($field==='blog_table')$value.="'$tablename',";
		elseif($field==='blog_table_base')$value.="'$this->pagename',";
		elseif($field==='blog_col')$value.="'$col_id',";
		elseif($field==='blog_float')$value.="'$blog_float',";
		elseif($field==='blog_order')$value.="'$blog_order',"; 
		elseif($field==='blog_options')$value.="'$blog_options',"; 
		elseif($field==='blog_unclone')$value.="'$blog_unclone',";
		elseif($field==='blog_unstatus')$value.="'$blog_unstatus',";
		elseif($field==='blog_width')$value.="'$blog_width',";
		elseif($field==='blog_pub')$value.="'$blog_pub',";
		elseif($field==='blog_temp')$value.="0,";
		elseif($field==='blog_unstatus')$value.="'',";
		elseif($field==='blog_unclone')$value.="'',";
		elseif($field==='blog_unstatus')$value.="'',";
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
	$q="select blog_id,blog_order from ".$this->master_post_table." where blog_table='$tablename' order by blog_order"; 
	$r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	if (!$this->mysqlinst->affected_rows())return;
	while (list($blog_id,$blog_order)=$this->mysqlinst->fetch_row($r,__LINE__)){
		$q2="UPDATE  $this->master_post_table set blog_temp=$i, token='".mt_rand(1,mt_getrandmax())."' where blog_id='$blog_id' AND blog_order=$blog_order"; 
	     $this->mysqlinst->query($q2,__METHOD__,__LINE__,__FILE__,true);
		$i+=$this->insert_full;
		}
	$q="Update  $this->master_post_table set blog_time='".time()."',token='".mt_rand(1,mt_getrandmax())."',blog_order=blog_temp where blog_table='$tablename'";  
	$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	}

function col_primary_tidy(){  //using primary order update  
	if (Sys::Methods){Sys::Debug(__LINE__,__FILE__,__METHOD__);}
	$i=1; 
	$q="select col_num  from ".$this->master_col_table." where col_primary=1 and col_table_base='$this->pagename' order by col_num"; 
	$r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	if (!$this->mysqlinst->affected_rows())return;
	while (list($col_num)=$this->mysqlinst->fetch_row($r,__LINE__)){
		$q2="UPDATE  $this->master_col_table set col_temp=$i, token='".mt_rand(1,mt_getrandmax())."' where col_table_base='$this->pagename'  AND col_num=$col_num";   
	     $this->mysqlinst->query($q2,__METHOD__,__LINE__,__FILE__,true);
		$i++;
		}
	$q="Update  $this->master_col_table  set col_time='".time()."',token='".mt_rand(1,mt_getrandmax())."',col_num=col_temp where col_table_base='$this->pagename' and col_primary=1";  
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
	}
	
function delete_option(){ 
	if ($this->pagename!=$this->blog_table_base)return;
	$type=(isset($this->blog_type))?$this->blog_type:'Divison';
	$msg=($this->blog_unstatus==='unclone')?'Delete This Mirror released '.$type.' &#40;Will Return to Cloned Parent&#41;':'Delete this Post';
	echo'<p class="warn1 floatleft redAlert left"><input type="checkbox" name="delete_blog['.$this->blog_table.']['.$this->blog_order.']" value="delete" onchange="edit_Proc.oncheck(\'delete_blog['.$this->blog_table.']['.$this->blog_order.']\',\'THIS ENTRY WILL BE DELETED WHEN YOU HIT CHANGE, UNCHECK TO CANCEL\');gen_Proc.use_ajax(\''.Sys::Self.'?unclone_list_post='.$this->blog_id.'@@del_unc_'.$this->blog_id.'\',\'handle_replace\',\'get\');" >&nbsp;'.$msg.'</p>';
	printer::pclear();
	echo '<p id="del_unc_'.$this->blog_id.'"></p>';
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
		if ($dir_filename!='index'){  //passed the check
			#first change the present index filenames
			#CHANGE BACK TO DIR_REF
			//$newindex=process_data::new_file($dir_ref,$this->ext);
			$q="select dir_menu_id,dir_title,dir_ref from $this->directory_table where dir_filename='index'";
			$r2=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__);
			while($rows2=$this->mysqlinst->fetch_assoc($r2,__LINE__)){
				$dir_menu_id2=$rows2['dir_menu_id'];
				$dir_ref2=$rows2['dir_ref'];
				$dir_title=$rows2['dir_title'];
				$index_msg.=NL.'The Old Opening/Homepage having the title '.$dir_title.' and the data_ref: '.$dir_ref2.' has had a filename change from index ('.$this->ext.')  to '.$dir_ref2. '('.$this->ext.') in dir menu id '.$dir_menu_id2;
				if (!copy('index'.$this->ext,$dir_ref2.$this->ext)){
					mail::alert("failure to copy index  to $newname$this->ext  Having the title $dir_title in editpages");
					}
				if (!copy(Cfg_loc::Root_dir.'index'.$this->ext,Cfg_loc::Root_dir.$dir_ref2.$this->ext)){
                         mail::alert("failure to copy index  to $newname$this->ext  Having the title $dir_title in Root dir");
					}
				}//end while rename index pages to newindex 
			$q="UPDate $this->directory_table  set dir_update='".date("dMY-H-i-s")."',dir_time='".time()."',token='".mt_rand(1,mt_getrandmax()). "',dir_filename=dir_ref where dir_filename='index'";
			$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__);
			$q="UPDate $this->master_page_table  set page_time='".time()."',token='".mt_rand(1,mt_getrandmax()). "',page_filename=page_ref where page_filename='index'";
			$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__);
			#now set the chosen dir_ref to index.php
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
			$q="UPDate $this->master_page_table  set page_time='".time()."',token='".mt_rand(1,mt_getrandmax()). "',page_filename='index' where page_filename='$dir_ref'";
			$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__);
			#now set the chosen dir_ref to index.php
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
					if ($field==='dir_menu_id')$value.="'$dir_menu_id',";
					else if ($field==='dir_menu_order')$value.="'$dir_menu_order',";
					else if ($field==='dir_sub_menu_order')$value.="'$dir_sub_menu_order',";
					else if ($field==='dir_menu_order')$value.="'$dir_menu_order',";
					else if ($field==='dir_filename')$value.="'$dir_filename',";
					else if ($field==='dir_title')$value.="'$dir_title',";
					else if ($field==='dir_ref')$value.="'$dir_ref',";
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
	}//end func 
 
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
			$ii++; 
			}//end while dir_sub_menu_order
		$q="update $this->directory_table set dir_update='".date("dMY-H-i-s")."',dir_time='".time()."',token='".mt_rand(1,mt_getrandmax()). "',dir_sub_menu_order=dir_temp where dir_menu_id='$dir_menu_id' and dir_menu_order='$dir_menu_order'";
		$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); 
		$q="update $this->directory_table set dir_update='".date("dMY-H-i-s")."',dir_time='".time()."',token='".mt_rand(1,mt_getrandmax()). "',dir_temp2=$i  where dir_menu_id='$dir_menu_id' and dir_menu_order='$dir_menu_order'";   
		$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);      
		$i++; 
		}//end while dir_menu_order
	$q="update $this->directory_table set dir_update='".date("dMY-H-i-s")."',dir_time='".time()."',token='".mt_rand(1,mt_getrandmax()). "',dir_menu_order=dir_temp2 where dir_menu_id='$dir_menu_id'"; 
	$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);	 
	####### update dir_menu_type
	}#end dir tidy 

function copy_col_theme($parent_id,$child_id,$db,$page_ref){
	$col_fields=Cfg::Col_fields;
	$col_fields_all=Cfg::Col_fields_all;
	$col_fields_arr=explode(',',$col_fields);
	$q="select $col_fields from $db.$this->master_col_table where col_id=$parent_id";  
	$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	$row = $this->mysqlinst->fetch_assoc($r,__LINE__);
	$q="insert into $this->master_col_table ($col_fields_all) values (";
	foreach ($col_fields_arr as $field){
		if ($field==='col_table_base')$q.="'$page_ref',";
		elseif($field==='col_table')$q.="'$page_ref".Cfg::Col_suffix."$child_id',";  
		else $q.="'".$row[$field]."',";
		}
	$q="$q '".date("dMY-H-i-s")."','".time()."','".$this->token_gen()."')"; 
	$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	$preserve=false;
	$this->copy_col($child_id,$parent_id,'copy',$preserve,$page_ref,$db.'.');
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
			$tablen='uncle_'.$this->pagename.'_id'.$rows2['blog_unclone'];
			$nblog_id=$rows2['blog_id'];
			if($field==='blog_table_base')$value.="'$this->pagename',";
			elseif($field==='blog_table')$value.="'$tablen',";
			elseif($field==='blog_pub')$value.="'1',";
			elseif($field==='blog_status')$value.="'clone',";//elseif($field==='blog_clone_target_base')$value.="'$col_table_base',";
			elseif($field==='blog_clone_target')$value.="'{$rows2['blog_data1']}',";//elseif($field==='blog_clone_table')$value.="'{$rows2['blog_table']}',";
			else $value.="'$rows2[$field]',";
			}
		$where="where blog_table='$tablen' and  blog_data1='{$rows2['blog_data1']}' and blog_data6='{$rows2['blog_data6']}' and blog_table_base='$this->pagename' "; // echo NL.NL.'where is: '.$where;
		$count=$this->mysqlinst->count_field($this->master_post_table,'blog_id','',false,$where);
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
		if	(is_numeric($rows['blog_data1'])){
               //run through all whether ==clone or not ==clone..
               $this->clone_preserve_unclone($rows['blog_data1'],$col_table_base,$db='',$post_target_clone_column_id); 
               }
		}//while
	}//end clone_preserve_unclone 
	
function choose_column($child_id,$nested){
	//child id  is actually the hosting column id..
	//whereas parent id is the column being moved. 
	$post_fields=Cfg::Post_fields;
	$post_field_arr=explode(',',$post_fields);
	echo '<div class="editbackground editfont fsmblack"><!--choose column-->';  
	if (isset($_POST['column_copy'][$child_id])&&!isset($_POST['column_copy_id_'.$child_id])){ 
		$this->message[]='You Did Not select a Column Id to '.$_POST['column_copy_'.$child_id];  
		}
	elseif (isset($_POST['column_copy_id_'.$child_id])&&!isset($_POST['column_copy'][$child_id])){
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
		$status=$_POST['column_copy'][$child_id];
		$where="where col_id=$parent_id";   
		$count=$this->mysqlinst->count_field($this->master_col_table,'col_id','',false,$where);
		if ($count>0){ 
			$col_fields=Cfg::Col_fields;
			$col_fields_arr=explode(',',$col_fields);
			$q="select $col_fields from $this->master_col_table where col_id=$parent_id";
			$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
			$row = $this->mysqlinst->fetch_assoc($r,__LINE__);
			if ($nested&&in_array($parent_id,$this->column_id_array)&&$row['col_table_base']===$this->pagename){ 
				if (array_search($parent_id,$this->column_id_array)<=$this->column_level){//	
					$this->message[]="Please Choose a distinct Nested Column Tree.  You have choosen to $status Column Id C$parent_id  INTO ITSELF OR ONE OF ITS NESTED COLUMNS Which Appears To Be a Mstake. this column level is $this->column_level";
					return;
					}
				}
			#PLEASE NOTE CURRENT POST IS UP SO VALUES OF ARE POPULATED ALREADY!
			if ($status==='move'){
					if  ($row['col_table_base']===$this->pagename){ //intra 
						if ($nested){ 
							if($row['col_primary']){//parent primary child nested
								/*column  move
								intrapage....
								if primary parent child nested   update new record insert
								set blog data1=parent column id
								set column to nested column...
								blog data2  parent table   //not imp
								no previous post to delete since primary*/
								$q="update  $this->master_post_table set  blog_pub=1,blog_data1='$parent_id',blog_data2='',blog_update='".date("dMY-H-i-s")."',blog_time='".time()."' where blog_order='$this->blog_order' and blog_table='$this->blog_table' and blog_type='nested_column' and blog_data2='column_choice'";
								$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
								$q="update $this->master_col_table set col_primary=0,col_width='',col_time='".time()."',col_num=0 where col_id='$parent_id'";    
								$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
								}
							else{//parent nested child nested
								 //delete new record blog insert...
								//update old parent blog  record changing references  blog_order
								if ($this->blog_unstatus!=='unclone'){ 	 
									$q="update $this->master_post_table SET blog_unstatus='',blog_col='$this->col_id',blog_data2='',blog_order='$this->blog_order',blog_table='$this->blog_table',token='".mt_rand(1,mt_getrandmax()). "',blog_update='".date("dMY-H-i-s")."',blog_time='".time()."' WHERE blog_data1='$parent_id' AND blog_table_base='$this->pagename' and blog_type='nested_column'";
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
										$q="delete from $this->master_post_table   WHERE blog_data1='$parent_id' AND blog_table_base='$this->pagename' and blog_type='nested_column' and blog_id !=$child_id";   
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
								$q="delete from $this->master_post_table where blog_data1='$parent_id' and blog_status!='clone' and blog_type='nested_column' and blog_table_base='$this->pagename'";
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
							//delete original posting...
							$where="WHERE blog_table_base='$this->pagename' and blog_type='nested_column' and blog_status='clone' and blog_data1='$parent_id'";
							$count=$this->mysqlinst->count_field($this->master_post_table,'blog_id','',false,$where);
							if ($count <1){
								$q="delete from  $this->master_post_table where blog_status!='clone' and blog_type='nested_column' and blog_data1='$parent_id' and blog_table_base='".$row['col_table_base']."'";   
								$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
								} 
							}
						else { //parent primary
							//count  primary check on clones
							$where="WHERE col_table_base='$this->pagename' and col_primary=1 and col_status='clone' and col_clone_target='$parent_id'";
							$count=$this->mysqlinst->count_field($this->master_col_table,'col_id','',false,$where);
							}
					 if ($count >0){// 
							$this->message[]='There is Already a Clone of Column Id'.$parent_id.' From Page Title: '.strtoupper(check_data::table_to_title($row['col_table_base'],__method__,__LINE__,__file__)).' on this Page.  To Be sure you wish to Move the Actual Parent Column and Not the Clone of it, Delete the Clone on this Page First then repeat what you did.  However, To Move the Clone on this page first Delete the clone on this page, then  Clone Column Id'.$parent_id.' Where you want on this page';
							}
						else { //still inter  
							if ($nested){//child nested    
                                        //update new record for child nested column set column parent_id to move it...
								 $q="update $this->master_post_table SET blog_data1='$parent_id',blog_data2='',blog_time='".time()."',blog_data2='$this->pagename".Cfg::Col_suffix."$parent_id' where blog_order='$this->blog_order' and blog_table='$this->blog_table' and blog_type='nested_column' and blog_data2='column_choice'";  //blog_data2 being/was being used as reference  
								$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
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
								if($field==='col_table_base')$q.="$field='$this->pagename',";
								elseif($field==='col_table')$q.="$field='$this->pagename".Cfg::Col_suffix."$parent_id',";
								elseif($field==='col_num'){
									if ($nested)$q.="$field=0,";
									else $q.="$field='$this->col_num',";
									}
								elseif($field==='col_primary'){
									if ($nested)$q.="$field='0',";
									else $q.="$field='1',";
									}
								elseif($field==='col_width'){
									if ($nested&&!empty($row['col_primary']))$q.="$field=0,";
									elseif (empty($nested)&&empty($row['col_primary']))$q.="$field=0,";
									else $q.="$field='".$row['col_width']."',";
									}
								elseif($field==='col_status')$q.="$field='$status',";
								else  $q.="$field='$row[$field]',"; 
								}
							$q=substr_replace($q ,'',-1) . " where col_id=$parent_id"; 
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
							$bo_update= ($this->blog_unstatus==='unclone')? ", blog_order='$blog_order',blog_clone_table='$blog_table'":'';//blog table remains unclone so not called up normally but reference to real table made in blog_clone_table instead...
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
							if($field==='blog_type')$value.="'nested_column',";   
							elseif($field==='blog_data1')$value.="'$parent_id',";
							elseif($field==='blog_status')$value.="'clone',";
							elseif($field==='blog_col')$value.="'$child_id',";
							elseif($field==='blog_date')$value.="'$blog_date',";
							elseif($field==='blog_order')$value.="'10',";
							elseif($field==='blog_table')$value.="'$this->pagename".Cfg::Col_suffix."$child_id',";
							elseif($field==='blog_table_base')$value.="'$this->pagename',";
							elseif($field==='blog_clone_target')$value.="'{$row['col_table_base']}',";
							elseif($field==='blog_temp')$value.="0,";
							elseif($field==='blog_pub')$value.="'1',";
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
					if ($row['col_table_base']!==$this->pagename)
						$this->clone_preserve_unclone($parent_id,$row['col_table_base']);
					}
				else {//copy
					if ($nested){ 
						$col_fields=Cfg::Col_fields;
						$col_field_arr=explode(',',$col_fields); 
						$value='';
						foreach ($col_field_arr as $field) {
							if($field==='col_table_base')$value.="'$this->pagename',";
							else $value.="'0',"; 
							}
						$this->mysqlinst->count_field($this->master_col_table,'col_id','',false,'');  
						$col_id=$this->mysqlinst->field_inc;
						$q="insert into $this->master_col_table ($col_fields,col_id,col_update,col_time,token) values ($value $col_id,'".date("dMY-H-i-s")."','".time()."','".mt_rand(1,mt_getrandmax())."')"; 
						$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
						}
                         else $col_id=$child_id;//using primary already created
					$q="update $this->master_col_table set ";
					foreach ($col_fields_arr as $field) {
						if($field==='col_table_base')$q.="$field='$this->pagename',";
						elseif($field==='col_table')$q.="$field='$this->pagename".Cfg::Col_suffix."$col_id',";
						elseif($field==='col_num'){
							if (!empty($nested))$q.="$field=0,";
							}
						elseif($field==='col_primary'){
							if (!empty($nested))$q.="$field='0',";
							else $q.="$field='1',";
							}
						elseif($field==='col_width'){
							if ($nested&&!empty($row['col_primary']))$q.="$field='100',";
							elseif (empty($nested)&&empty($row['col_primary']))$q.="$field=0,";
							else $q.="$field='".$row['col_width']."',";
							}
						elseif($field==='col_clone_target')$q.="$field='',"; //$parent_id
						elseif($field==='col_clone_target_base')$q.="$field='',";//".$row['col_table_base']."
						elseif($field==='col_status'&&$status!=='move')$q.="$field='$status',";
						elseif($field==='col_style')$q.="$field='".$this->back_image_copy($row['col_style'])."',"; 
						elseif($field==='col_style2')$q.="$field='".$this->back_image_copy($row['col_style2'])."',"; 
						elseif($field==='col_grp_bor_style')$q.="$field='".$this->back_image_copy($row['col_grp_bor_style'])."',";
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
	echo '<div class="fsminfo editcolor editbackground editfont left floatleft"><!--wrap copy move clone column-->';
	printer::alertx('<p class="editbackground editfont editcolor">Copy, Move or Clone a <span class="bold">'.$column.'</span>  including all its Nested Columns and Posts from any page Here. </p><br> If You <span class="bold">Copy </span> A Column it is editable and Completely Independant of the Original with a New Column Id.</p> <p><br> If You  <span class="bold"> Move</span> a Column the Original Column will be moved to the new location within the page or to another page and maintain the original Ids. Moving will preserve clones but not mirror releases which may be copied separately.</p> <p><br><span class="bold">Cloning </span> a Column from Another Page effectively makes an Template out of the Original Column.  <br>With A Cloned Column The Original Will Be Expressed Here and Will Not Be Editable And Changes Made To the Parent Column &#40;the Original&#41; will Appear in This Cloned Column and on Other Pages if Similarly Created </p> <p><br>Furthermore, With a Cloned Column, easily <span class="bold">Mirror release</span> Any Particlular Post/Nested Column Within it to Customize it for that Particular Page which Effectively means you can make a Clone of an Entire Page if you wanted to then Customize the Page Specific Portion!!</p>');
	if ($nested){
		$delete_msg= 'Remove This Choose Column Post';
		printer::alertx('<p class="editbackground editfont redAlert floatleft"><input type="checkbox" name="delete_blog['.$this->blog_table.']['.$this->blog_order.']" value="delete" onchange="edit_Proc.oncheck(\'delete_blog['.$this->blog_table.']['.$this->blog_order.']\',\'THIS ENTRY WILL BE DELETED WHEN YOU HIT CHANGE, UNCHECK TO CANCEL\')" >'.$delete_msg.'</p>');
		}
	else { 
		echo '<p class="left neg"><input type="checkbox" name="deletecolumn['.$this->col_table.']" value="delete" onchange="edit_Proc.oncheck(\'deletecolumn['.$this->col_table.']\',\'Deleting This Column Choice Option, UNCHECK TO CANCEL \');" >Delete This Column Choice Option</p>';
		}
	printer::pclear();
	printer::printx('<p class="editcolor editbackground editfont"><input type="radio" name="column_copy['.$child_id.']" value="copy">Copy Column');
	printer::printx('<span class="small highlight" title="By default Cloned Columns and Posts will be Copied as independent duplicates. Checking here will preserve them as clones instead together with any associated mirror releases"><input type="checkbox" name="column_copy_preserve_clones_'.$child_id.'" value="preserve">Option: Preserve Clone/Mirror release Post Status within Copied Columns</span></p>');
	printer::printx('<p class="editcolor editbackground editfont"><input type="radio" name="column_copy['.$child_id.']" value="clone">Clone Column Here</p>');
	printer::printx('<p class="editcolor editbackground editfont"><input type="radio" name="column_copy['.$child_id.']" value="move" >Move Column</p>');
	printer::printx('<p class="editcolor editbackground editfont" title="Be Sure to Enter the Column Id  Which Begin with a C ie C10.  Do Not Use the Column# which simply refers to the Column Display Order Within the Page. Both column Ids and #s are displayed at the top of each Column"><input style="background:#'.$this->editor_background.';color:#'.$this->editor_color.';" type="text" name="column_copy_id_'.$child_id.'"  size="5" maxlength="8">Enter the <span class="info">Column Id </span><span class="red">(Not Column#)</span> that you wish to Copy/Move/Clone</p>');
	printer::pclear(10);
	$this->show_more('Import Column','','editbackround small highlight ','Import a column from template master tables or a database');
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
	echo '<div class="editbackground editfont fsmblack"><!--choose post-->';
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
	elseif (isset($_POST['post_copy_id_'.$this->blog_id])&&strtolower(substr(trim($_POST['post_copy_id_'.$this->blog_id]),0,1))!=='p'){
		$this->message[]='Post IDs Are FOUND AT THE TOP OF Each Post ie. The Number having the ID: P#.. FORMAT. BE SURE TO INCLUDE THE P PREFIX ';
		}
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
			if ($row['blog_type']==='nested_column'){
				$msg="Your Post Choice is actually a Nested Column.  To Copy/Clone or Move a Column Choose this Option from the dropdown Menu along with the Column Id";
				$this->message[]=$msg;
				}
			if ($status==='copy'){//remember original will be copied not clone   however with subsequent nested  post differrnt depending on preserve status   
				$q="update $this->master_post_table as c, $this->master_post_table as p set ";
				foreach ($post_field_arr as $field){ 
					if ($field==='blog_col'||$field==='blog_order'||$field==='blog_table'||$field==='blog_table_base'||$field==='blog_status'||$field==='blog_unstatus'||$field==='blog_unclone'||$field==='blog_clone_target'||$field==='blog_target_table_base')continue; 
                         if ($field==='blog_type'){
                              if ($row['blog_type']==='image'||$row['blog_type']==='float_image_right'||$row['blog_type']==='float_image_left'){ 
                                   $q.="c.blog_data1='".$this->image_copy('image',$row['blog_data1'])."', ";//duplicate image
                                   }
                              elseif ($row['blog_type']==='auto_slide'){ 
                                   $q.="c.blog_data1='".$this->image_copy('auto_slide',$row['blog_data1'])."', ";//duplicate slide iamges
                                   }
                              elseif ($row['blog_type']==='gallery'){ 
                                   $q.="c.blog_data1='".$this->image_copy('gallery_copy',$row['blog_data1'],$row['blog_table_base'])."', ";//duplicate gallery
                                   }
                              elseif ($row['blog_type']==='navigation_menu'){ 
                                   $q.="c.blog_data1='".$this->navigation_copy($row['blog_data1'])."',";//duplicate nav
                                   }
                              else $q.="c.blog_data1=p.blog_data1, ";
                              }
                         if ($field==='blog_border_start')$q.="c.blog_border_start=0, ";
                         elseif ($field==='blog_border_stop')$q.="c.blog_border_stop=0, ";
                         elseif ($field==='blog_style')$q.="c.blog_style='".$this->back_image_copy($row['blog_style'])."', "; 
                         elseif ($field==='blog_style2')$q.="c.blog_style2='".$this->back_image_copy($row['blog_style2'])."', "; 
                         elseif ($field==='blog_data2')$q.="c.blog_data2='".$this->back_image_copy($row['blog_data2'])."', "; 
                         elseif ($field==='blog_data3')$q.="c.blog_data3='".$this->back_image_copy($row['blog_data3'])."', "; 
                         elseif ($field==='blog_data4')$q.="c.blog_data4='".$this->back_image_copy($row['blog_data4'])."', "; 
                         elseif ($field==='blog_data5')$q.="c.blog_data5='".$this->back_image_copy($row['blog_data5'])."', ";
                         elseif ($field==='blog_data6')$q.="c.blog_data6='".$this->back_image_copy($row['blog_data6'])."', ";
                         elseif ($field==='blog_data7')$q.="c.blog_data7='".$this->back_image_copy($row['blog_data7'])."', ";
                         elseif ($field==='blog_data8')$q.="c.blog_data8='".$this->back_image_copy($row['blog_data8'])."', ";
                         elseif ($field==='blog_data9')$q.="c.blog_data9='".$this->back_image_copy($row['blog_data9'])."', ";
                         elseif ($field==='blog_data10')$q.="c.blog_data10='".$this->back_image_copy($row['blog_data10'])."', ";
                         elseif ($field==='blog_data11')$q.="c.blog_data11='".$this->back_image_copy($row['blog_data11'])."', ";
                         elseif ($field==='blog_data12')$q.="c.blog_data12='".$this->back_image_copy($row['blog_data12'])."', "; 
                         elseif ($field==='blog_data13')$q.="c.blog_data13='".$this->back_image_copy($row['blog_data13'])."', "; 
                         elseif ($field==='blog_data14')$q.="c.blog_data14='".$this->back_image_copy($row['blog_data14'])."', "; 
                         elseif ($field==='blog_data15')$q.="c.blog_data15='".$this->back_image_copy($row['blog_data15'])."', ";
                         elseif ($field !=='blog_data1'){ 
                              $q.="c.$field=p.$field, ";
                              }
                         }//end foreach 
				$q.="c.blog_status='copy' where c.blog_id='$this->blog_id' and p.blog_id='$parent_id'";    
				$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
				if ($this->mysqlinst->affected_rows()){
					$this->copy_comment($parent_id,$this->blog_id);
					$this->success[]="Your post Id: P$parent_id has been copied to P$this->blog_id!";
					}
				}
			elseif ($status==='move'){
				$q="update $this->master_post_table as c, $this->master_post_table as p set ";
				foreach ($post_field_arr as $field){ 
					if ($field==='blog_col'||$field==='blog_order'||$field==='blog_table'||$field==='blog_table_base'||$field==='blog_status'||$field==='blog_unstatus'||$field==='blog_unclone'||$field==='blog_clone_target'||$field==='blog_target_table_base')continue; 
                         if ($field==='blog_type'){ 
                              if ($row['blog_type']==='gallery'&&$row['blog_table_base']!==$this->pagename){
                                   $q.="c.blog_data1='".$this->image_copy('gallery_move',$row['blog_data1'],$row['blog_table_base'])."', ";//duplicate gallery	 
                                   }
                              else $q.="c.blog_data1=p.blog_data1, ";
                              }
                         if ($field !=='blog_data1'){ 
                             $q.="c.$field=p.$field, ";
                             }
                         }//end foreach 
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
			elseif ($status==='clone'){
				//check if the record is for a unclone if so update blog_order...
				$bo_update= ($this->blog_unstatus==='unclone')? ', blog_order='.$row['blog_order'].",blog_clone_table='".$row['blog_table']."'":'';
				$q="update $this->master_post_table set blog_status='clone',blog_pub=1,blog_data2='',blog_type='',blog_clone_target='$parent_id',token='".mt_rand(1,mt_getrandmax()). "' $bo_update where blog_id='$this->blog_id'";
				$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
				$this->success[]="Your post Id: P$parent_id has been Cloned";
				}
			}
		else $this->message[]="Post P$parent_id was not found";
		}	  
	echo '<div class="fsminfo editcolor editbackground editfont  left floatleft"><!--wrap copy move clone post-->';
	printer::alertx('<p>Copy, Move or Clone a <span class="bold">POST</span> Here </p><br> If You <span class="bold">Copy </span> A post it is editable and Completely Independant of the Original.</p> <p><br> If You  <span class="bold"> Move</span> a post Here the Original Will Be Deleted!</p> <p><br> With A <span class="bold">Cloned </span>  post The Original Will Be Expressed Here and this Clone Will Not Be Editable But Changes Made To the Original Parent Post will Appear in this and any other Child Clone of this Post. </p>');
	$this->delete_option();
	printer::pclear();
	$this->show_more('About Copy/Clone/Move Choices','noback','','',400);
	printer::printx('<p class="fsminfo editbackground editfont ">The Choices offer flexibility in how to utilize previously created webpages, templates and posts. Copying Posts wil create independent duplicates.  Cloning  posts mirrors the original such that when changes are made to the original the cloned similarly changes.  Moving posts removes the post from the original location moving it to the new location. </p>');
	$this->show_close('coluimn choices');//coluimn choices
	printer::printx('<p class="editcolor editbackground editfont"><input type="radio" name="post_copy_'.$this->blog_id.'" size="8" maxlength="8" value="copy">Copy Post</p>');
	printer::printx('<p class="editcolor editbackground editfont"><input type="radio" name="post_copy_'.$this->blog_id.'"  size="8" maxlength="8" value="clone">Clone post Here</p>');
	printer::printx('<p class="editcolor editbackground editfont"><input type="radio" name="post_copy_'.$this->blog_id.'"  size="8" maxlength="8" value="move">Move post Here</p>');
	printer::printx('<p class="editcolor editbackground editfont" title="Be Sure to Use the Post Id Which Begins with a P ie P42.  Do Not Use the  Post# which simply refer to the Post Display Order Within the Column. Post Ids and #s are displayed at the top of each post"><input  style="background:#'.$this->editor_background.';color:#'.$this->editor_color.';" type="text" name="post_copy_id_'.$this->blog_id.'"  size="8" maxlength="8">Enter the  <span class="info">Post Id</span> <span class="red">(Not Post#) </span>that you wish to Copy Move or Clone</p>');
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
			if ($field==='blog_data1'){
				if ($rows['blog_type']==='gallery'){ 
					$q.="$field='".$this->image_copy('gallery_move',$rows['blog_data1'],$rows['blog_table_base'])."',";//change gall table ref etc.
					}
				}
			elseif($field==='blog_table_base')$q.="$field='$this->pagename',";
			elseif($field==='blog_table')$q.="$field='$this->pagename".Cfg::Col_suffix."$parent_id',";
			elseif($field==='blog_status'){
				if ($rows['blog_status']!=='clone')$q.="$field='$status',";
				else $q.="$field='clone',";
				}
			else  $q.="$field='$rows[$field]',";
			}
		$q="$q blog_update='".date("dMY-H-i-s")."',blog_time='".time()."' where blog_id='".$rows['blog_id']."'";     
		$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
		if  ($rows['blog_type']==='nested_column'&&is_numeric($rows['blog_data1'])&&$rows['blog_status']==='clone') {
			$data6=$rows['blog_data1'];//this was set in creating unclone and represents the clone parent column target for unclone moving
			$q="select blog_id,blog_unclone,blog_type,blog_data1  from $this->master_post_table where blog_table_base='$table_base' and blog_data6='$data6' and  blog_unstatus='unclone'";
			$r2=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
			While ($rows2= $this->mysqlinst->fetch_assoc($r2,__LINE__)){
				$tablen='uncle_'.$this->pagename.'_id'.$rows2['blog_unclone'];
				$blog_id=$rows2['blog_id'];
				$q="update $this->master_post_table set blog_table_base='$this->pagename',blog_table='$tablen', blog_update='".date("dMY-H-i-s")."',blog_time='".time()."' where blog_id='$blog_id'";   
				$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
				if  ($rows2['blog_type']==='nested_column'&&is_numeric($rows2['blog_data1'])){
					$q="select $col_fields from $this->master_col_table where col_id=".$rows2['blog_data1'];   
					$r4=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
					$row3 = $this->mysqlinst->fetch_assoc($r4,__LINE__); 
					$q="update $this->master_col_table set ";
					foreach ($col_field_arr as $field) {
						if($field==='col_table_base')$q.="$field='$this->pagename',";
						elseif($field==='col_table')$q.="$field='$this->pagename".Cfg::Col_suffix."{$rows2['blog_data1']}',";
						elseif($field==='col_num')$q.="$field=0,";
						elseif($field==='col_primary')$q.="$field='0',"; 
						elseif($field==='col_status')$q.="$field='$status',";
						else  $q.="$field='$row3[$field]',";
						}
					$q="$q col_update='".date("dMY-H-i-s")."',col_time='".time()."' where col_id={$rows2['blog_data1']}";
					$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);	
					$this->move_col($rows2['blog_data1'],'move',$table_base);
					}
				}
			}
		elseif  ($rows['blog_type']==='nested_column'&&is_numeric($rows['blog_data1'])&&$rows['blog_status']!=='clone'){
			$q="select $col_fields from $this->master_col_table where col_id=".$rows['blog_data1'];   
			$r3=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
			$row = $this->mysqlinst->fetch_assoc($r3,__LINE__); 
			$q="update $this->master_col_table set ";
			foreach ($col_field_arr as $field) {
				if($field==='col_table_base')$q.="$field='$this->pagename',";
				elseif($field==='col_table')$q.="$field='$this->pagename".Cfg::Col_suffix."{$rows['blog_data1']}',";
				elseif($field==='col_num')$q.="$field=0,";
				elseif($field==='col_primary')$q.="$field='0',"; 
				elseif($field==='col_status')$q.="$field='$status',"; 
				else  $q.="$field='$row[$field]',";
				}
			$q="$q col_update='".date("dMY-H-i-s")."',col_time='".time()."' where col_id={$rows['blog_data1']}";
			$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
			$this->move_col($rows['blog_data1'],$status,$table_base);
			}
		}//while 
	}	//end move column 


function navigation_copy($nav_id,$db=''){
	(empty($n_table))&&$n_table=$this->pagename;
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
				if ($field==='dir_menu_id')$value.="'$new_dir_ref',";
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
			if ($field==='com_blog_id')$value.="'$child_id',";
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
	if (is_file(Cfg_loc::Root_dir.Cfg::Background_image_dir.$oldfile)) {
		if (!copy(Cfg_loc::Root_dir.Cfg::Background_image_dir.$oldfile,Cfg_loc::Root_dir.Cfg::Background_image_dir.$newfile))$this->message[]=printer::alert_neg("CopY Error ".Cfg_loc::Root_dir.Cfg::Background_image_dir.$oldfile .'=>'.Cfg_loc::Root_dir. Cfg::Background_image_dir.$newfile ,1.2,true);
		}
	return $style_implode;
	}
     
function image_copy($type,$field_val,$s_table='',$n_table='',$db=''){
	(empty($n_table))&&$n_table=$this->pagename;
	if ($type==='image'){
		if (empty($field_val)) return;
		$pic_update=process_data::copy_new_image($field_val,Cfg_loc::Root_dir.Cfg::Upload_dir);//relies on local system to copy page_image and page_image_expanded
		if(strpos($pic_update,'.')===false)return $field_val;
		list($file,$alt)=process_data::process_pic($pic_update);
		list($ifile,$ialt)=process_data::process_pic($field_val);
		#resized response directory photos will auto generate as required
		if (is_file(Cfg_loc::Root_dir.Cfg::Page_images_expand_dir.$ifile)){
			copy(Cfg_loc::Root_dir.Cfg::Page_images_expand_dir.$ifile,Cfg_loc::Root_dir.Cfg::Page_images_expand_dir.$file);
			}
		else printer::alert_neg('copying file: '.Cfg_loc::Root_dir.Cfg::Page_images_expand_dir.$ifile.' does not exist in '.__METHOD__);
		return $pic_update;
		}
	elseif ($type==='auto_slide'){
		$img_arr=array();
		if (empty($field_val)) return;
		$pics=explode(',',$field_val);   
		foreach ($pics as $image){
			$img_arr[]=process_data::copy_new_image($image,Cfg_loc::Root_dir.Cfg::Upload_dir);
			}
		$arr=implode(',',$img_arr);   
		return $arr;
		}
	elseif ($type==='gallery_move'){
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
	elseif ($type==='gallery_copy'){  
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
			While (in_array($this->pagename.'_'.$n,$tbn_arr)){
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
				if ($field==='master_gall_ref')$value.="'',"; 
				elseif($field==='gall_ref')$value.="'$new_gall_ref',";
				elseif($field==='gall_table')$value.="'$n_table',";
				elseif($field==='picname')$value.="'$new_picname',";
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
	$table_base=(empty($table_base))?$this->pagename:$table_base;
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
		if (!$preserve&&$rows['blog_status']==='clone'&&is_numeric($rows['blog_clone_target'])){
			$blogord=$rows['blog_order'];
			$q="select blog_id,$post_fields from $db$this->master_post_table where blog_id=".$rows['blog_clone_target'];
			$rget=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
			if(!$this->mysqlinst->affected_rows())continue;
			$rows= $this->mysqlinst->fetch_assoc($rget,__LINE__);//here we substitute the holder record for the cloned record without disrupting the while statement!!
			$rows['blog_order']=$blogord;//ok we want to keep origninal blog order for proper positioning
			}
		foreach ($post_field_arr as $field){  
			if ($field==='blog_data1'){
				if (($rows['blog_type']==='image'||$rows['blog_type']==='float_image_right'||$rows['blog_type']==='float_image_left')){
					if ($preserve && $rows['blog_status']==='clone')
						  $value.="'$rows[$field]',";
					else $value.="'".$this->image_copy('image',$rows['blog_data1'])."',";//duplicate image
					}
				elseif ($rows['blog_type']==='auto_slide'){ 
					if ($preserve && $rows['blog_status']==='clone')
						  $value.="'$rows[$field]',";
					else $value.="'".$this->image_copy('auto_slide',$rows['blog_data1'],$db)."',";//duplicate image
					
					}
				elseif ($rows['blog_type']==='gallery'){ 
					if ($preserve && $rows['blog_status']==='clone')
						  $value.="'$rows[$field]',";
					else $value.="'".$this->image_copy('gallery_copy',$rows['blog_data1'],$rows['blog_table_base'],$table_base,$db)."',";//duplicate image
					}
				elseif ($rows['blog_type']==='navigation_menu'){ 
					if ($preserve && $rows['blog_status']==='clone')
						  $value.="'$rows[$field]',";
					else $value.="'".$this->navigation_copy($rows['blog_data1'],$db)."',";//duplicate image
					}
				else  $value.="'$rows[$field]',";
				}
			elseif($field==='blog_table_base')$value.="'$table_base',";
			elseif($field==='blog_table')$value.="'$table_base".Cfg::Col_suffix."$child_id',";
			elseif($field==='blog_col')$value.="'$child_id',";
			elseif ($field==='blog_style')$value.="'".$this->back_image_copy($rows['blog_style'])."', "; 
               elseif ($field==='blog_style2')$value.="'".$this->back_image_copy($rows['blog_style2'])."', "; 
               elseif ($field==='blog_data2')$value.="'".$this->back_image_copy($rows['blog_data2'])."', "; 
               elseif ($field==='blog_data3')$value.="'".$this->back_image_copy($rows['blog_data3'])."', "; 
               elseif ($field==='blog_data4')$value.="'".$this->back_image_copy($rows['blog_data4'])."', "; 
               elseif ($field==='blog_data5')$value.="'".$this->back_image_copy($rows['blog_data5'])."', ";
               elseif ($field==='blog_data6')$value.="'".$this->back_image_copy($rows['blog_data6'])."', ";
               elseif ($field==='blog_data7')$value.="'".$this->back_image_copy($rows['blog_data7'])."', ";
               elseif ($field==='blog_data8')$value.="'".$this->back_image_copy($rows['blog_data8'])."', ";
               elseif ($field==='blog_data9')$value.="'".$this->back_image_copy($rows['blog_data9'])."', ";
               elseif ($field==='blog_data10')$value.="'".$this->back_image_copy($rows['blog_data10'])."', ";
               elseif ($field==='blog_data11')$value.="'".$this->back_image_copy($rows['blog_data11'])."', ";
               elseif ($field==='blog_data12')$value.="'".$this->back_image_copy($rows['blog_data12'])."', "; 
               elseif ($field==='blog_data13')$value.="'".$this->back_image_copy($rows['blog_data13'])."', "; 
               elseif ($field==='blog_data14')$value.="'".$this->back_image_copy($rows['blog_data14'])."', "; 
               elseif ($field==='blog_data15')$value.="'".$this->back_image_copy($rows['blog_data15'])."', ";
			elseif($field==='blog_status'){
				if ($preserve && $rows['blog_status']==='clone')
						  $value.="'clone',";
				else $value.="'copy',";
				}
			elseif($field==='blog_unclone')$value.="'',";
			elseif($field==='blog_unstatus')$value.="'',";
			elseif($field==='blog_pub')$value.="'1',";
			elseif($field==='blog_clone_target'){
                    if ($preserve && $rows['blog_status']==='clone')
                         $value.="'$rows[$field]',";
                    else $value.="'',";
                    }
			else $value.="'$rows[$field]',";
			} 
		$q="insert into $this->master_post_table ($post_fields,blog_update,blog_time,token) values ($value '".date("dMY-H-i-s")."','".time()."','".mt_rand(1,mt_getrandmax())."')";   
		$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
		$this->mysqlinst->count_field($this->master_post_table,'blog_id','',false,'');  
		$blog_id=$this->mysqlinst->fieldmax;   
		$this->copy_comment($rows['blog_id'],$blog_id,$db);
		#***************preserve unclone section**************************
		if  ($preserve&&$rows['blog_type']==='nested_column'&&is_numeric($rows['blog_data1'])&&$rows['blog_status']==='clone') {  
			$post_target_clone_column_id=$rows['blog_data1'];
			#reference to this post_target_clone_column_id in all unclone posts  was set as blog_data6 when creating unclone
			#and represents the clone target column  unclones of posts within therefore have reference to this target parent 
			#since this is end of the line for actually accessing cloned preseves since they themselves are not duplicated
			#all nested levels within are accessed for unclone posts
			#throught the following select query
			#unclones on the other hand will actually be duplicated at this point....
			#to reiterate: preserved clones are not duplicated, only by reference through the clone marker record is ... whereas
			#unclone referenced posts are all actually duplicated...
			$q="select blog_id,$post_fields from $db$this->master_post_table where blog_table_base='".$rows['blog_table_base']."' and blog_data6='$post_target_clone_column_id' and  blog_unstatus='unclone'";    
			$r2=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
			#rows = parent_blog to copy
			#rows2=  cloned reference in parent blog when presever status is used
			While ($rows2= $this->mysqlinst->fetch_assoc($r2,__LINE__)){
				$value='';  
				foreach ($post_field_arr as $field) {
					$tablen='uncle_'.$table_base.'_id'.$rows2['blog_unclone'];
					$nblog_id=$rows2['blog_id'];
					if($field==='blog_table_base')$value.="'$table_base',";
					elseif($field==='blog_table')$value.="'$tablen',";
					elseif($field==='blog_pub')$value.="'1',";
					else $value.="'$rows2[$field]',";
					}
				$q="insert into $this->master_post_table  ($post_fields,blog_update,blog_time,token) values ($value '".date("dMY-H-i-s")."','".time()."','".mt_rand(1,mt_getrandmax())."')";   
				$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
				$this->mysqlinst->count_field($this->master_post_table,'blog_id','',false,'');  
				$blog_id=$this->mysqlinst->fieldmax;
				if	($rows2['blog_type']==='nested_column'&&is_numeric($rows2['blog_data1'])){
					$q="select $col_fields from $db$this->master_col_table where col_id=".$rows2['blog_data1'];    
					$r4=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
					$row3 = $this->mysqlinst->fetch_assoc($r4,__LINE__);
					#rows = parent_blog to copy
					#rows2=  cloned reference in parent blog when presever status is used
					#rows3= cloned column values when column is directly cloned and preversed
					$value='';
					foreach ($col_field_arr as $field) {
						if($field==='col_table_base')$value.="'$table_base',";
						elseif($field==='col_table')$value.="'',";
						elseif($field==='col_num')$value.="0,";
						elseif($field==='col_status')$value.="'copy',";
						elseif($field==='col_clone_target')$value.="'',";//.$rows['blog_data1']."',";//uncecesary
						elseif($field==='col_clone_target_base')$value.="'',";//.$rows3['col_table_base']."',";//unnecessary
						elseif($field==='col_primary')$value.="'0',";
						elseif($field==='col_style')$value.="'".$this->back_image_copy($row3['col_style'])."',"; 
						elseif($field==='col_style2')$value.="'".$this->back_image_copy($row3['col_style2'])."',"; 
						elseif($field==='col_grp_bor_style')$value.="'".$this->back_image_copy($row3['col_grp_bor_style'])."',"; 
						elseif($field==='col_width'){
							if (!empty($rows2['col_primary'])&&$rows2['col_primary']<100)$value.="'".$row3['col_width']."',";
							else $value.="'0',";//"'".$row3['col_width']."',";
							}
						elseif($field==='col_status')$value.="'copy',";
						else $value.="'".$row3[$field]."',"; 
						}    
					$q="insert into $this->master_col_table ($col_fields,col_update,col_time,token) values ($value '".date("dMY-H-i-s")."','".time()."','".mt_rand(1,mt_getrandmax())."')";  
					$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
                         $this->mysqlinst->count_field($this->master_col_table,'col_id','',false,'');  
					$col_id=$this->mysqlinst->fieldmax;
					$q="update $this->master_col_table set col_table='$table_base".Cfg::Col_suffix."$col_id' where col_id='$col_id'"; 
					$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true); 
					$q="update $this->master_post_table set token='".mt_rand(1,mt_getrandmax()). "',blog_data1='$col_id' where blog_id=$blog_id";   
					$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
                         $this->copy_col($col_id,$rows2['blog_data1'],'copy',$preserve,$table_base);
					}
				}
			}
		if  ((!$preserve||$rows['blog_status']!='clone')&&$rows['blog_type']==='nested_column'&&is_numeric($rows['blog_data1'])){  
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
				if($field==='col_table_base')$value.="'$table_base',";
				elseif($field==='col_table')$value.="'',";
				elseif($field==='col_num')$value.="0,";
				elseif($field==='col_status')$value.="'copy',";
				elseif($field==='col_clone_target')$value.="'',";
				elseif($field==='col_clone_target_base')$value.="'".$row['col_table_base']."',";
				elseif($field==='col_style')$value.="'".$this->back_image_copy($row['col_style'])."',"; 
				elseif($field==='col_style2')$value.="'".$this->back_image_copy($row['col_style2'])."',"; 
				elseif($field==='col_grp_bor_style')$value.="'".$this->back_image_copy($row['col_grp_bor_style'])."',"; 
				elseif($field==='col_primary')$value.="'0',";
				elseif($field==='col_width'){
					if (!empty($row['col_primary']))$value.="'100',";
					else $value.="'".$row['col_width']."',";
					}
				elseif($field==='col_status'&&$status!=='move')$value.="'$status',";
				else $value.="'".$row[$field]."',"; 
				}    
			$q="insert into $this->master_col_table ($col_fields,col_update,col_time,token) values ($value '".date("dMY-H-i-s")."','".time()."','".mt_rand(1,mt_getrandmax())."')"; 
               $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true); 
			$this->mysqlinst->count_field($this->master_col_table,'col_id','',false,'');  
			$col_id=$this->mysqlinst->fieldmax;
			$q="update $this->master_col_table set col_table='$table_base".Cfg::Col_suffix."$col_id' where col_id='$col_id'"; 
			$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true); 
			$q="update $this->master_post_table set token='".mt_rand(1,mt_getrandmax()). "',blog_data1='$col_id' where blog_id=$blog_id";    
			$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true); 
			$this->copy_col($col_id,$rows['blog_data1'],$status,$preserve,$table_base,$db);
			}
		}//while
		$msg=($status==='move')?'MOVED':(($status==='clone')?'CLONED':(($preserve)?'COPIED AND CLONE/MIRROR RELEASE STATUS PRESERVED':'COPIED'));
		$this->success[]="Your Column and All Post have been $msg";
	}// end copy column
 
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
			$q="select page_filename,page_title from $this->master_page_table where page_ref='$dir_ref'";
			$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
			list($dir_filename,$dir_title)=$this->mysqlinst->fetch_row($r,__LINE__);
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

function page_grid_unit_export(){
     $q="select page_options from $this->master_page where page_ref='$this->pagename'";
     $r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);    
     $row=$mysqlinst->fetch_row($r,__LINE__);
     $styled=$row[0];
     $style_array=explode(',',$styled);
     $count=count($style_array);
     if (!array_key_exists($this->page_grid_units_index,$style_array)){
          $this->message[]='Error retrieving page_grid_units from page_options in '.$this->pagename; 
          return;
          }
     $value=$styled_array[$this->page_grid_units_index];
     $q="select page_ref from $this->master_page_table where page_ref !='$this->pagename'";
     $r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);    
     while ($row=$mysqlinst->fetch_row($r,__LINE__)){
          $ref=$row[0];
          $this->update_implode($value,$this->page_grid_units_index,'page_options','page'," where page_ref='$ref'");
          }
     }
function updater($type,$set,$where,$msg=''){
     if ($type==='typeenv'){
          if ($this->is_column){
               if($this->is_clone&&!$this->local_clone_style){
                   $msg="Clone updating attempt with $set  and this id $this->col_id";
                    printer::alert_neg($msg);
                    $this->message[]=$msg;
                    return;
                    }
               elseif($this->is_clone){
                    $type='colcss';
                    }
               else {
                    $type='col';
                    }
               }
          elseif ($this->is_blog){
               if ($this->is_clone&&!$this->local_clone_style){
                    $msg="Clone updating attempt with $set  and this id $this->blog_id";
                    printer::alert_neg($msg);
                    $this->message[]=$msg;
                    }
               elseif($this->is_clone){
                    $type='postcss';
                    }
               else {
                    $type='post';
                    }
               }          
          } 
      if ($where==='idenv'){
          if ($this->is_column){
               if($this->is_clone&&!$this->local_clone_style){
                   $msg="Clone updating attempt with $set  and this id $this->col_id";
                    printer::alert_neg($msg);
                    $this->message[]=$msg;
                    return;
                    }
               elseif($this->is_clone){
                    $where="where col_id='c$this->col_id'";
                    }
               else {
                    $where="where col_id='$this->col_id'";
                    }
               
               }
          elseif ($this->is_blog){
               if ($this->is_clone&&!$this->local_clone_style){
                    $msg="Clone updating attempt with $set  and this id $this->blog_id";
                    printer::alert_neg($msg);
                    $this->message[]=$msg;
                    
                    }
               elseif($this->is_clone){
                    $type='postcss';
                    $where="where blog_id='b$this->blog_id'";
                    }
               else {
                    $where="where blog_id='$this->blog_id'";
                    }
               }          
          } 
     if ($type=='postcss'){//blog_data3-blog-8-20
          $table=Cfg::Master_post_css_table;
          $prefix=Cfg::Blog_prefix;
          }
     elseif ($type=='post'){//posts
          $table=Cfg::Master_post_table;
          $prefix=Cfg::Blog_prefix;
          }// note:  chech for array key 3 now obsolete
     elseif ($type=='colcss'){
          $table=Cfg::Master_col_css_table;
          $prefix=Cfg::Col_prefix;
          }
     elseif($type=='col'){//column
          $table=Cfg::Columns_table;
           $prefix=Cfg::Col_prefix;
          }
     elseif ($type=='page') {//pages
          $table=Cfg::Master_page_table;
          $prefix=Cfg::Page_prefix;
          }
     else {
          $this->message[]='type error in '.__method__.' line:'.__line__;
          return;
          }
     $q="update $table set $set,{$prefix}time='".time()."',token='".mt_rand(1,mt_getrandmax())."',{$prefix}update='".date("dMY-H-i-s")."'  $where";
     $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
     if ($msg){
          if ($this->mysqlinst->affected_rows()){
               $msg="Successfully updated $q";
               $this->success[]=$msg;
               printer::alert_pos($msg);
               }
          else {
               $msg="Unuccessfully updated $q";
               printer::alert_neg($msg);
               $this->message[]=$msg;  
               }
          }
     }
function update_implode($value, $key, $field, $type, $where){
     if ($type=='postcss'){//blog_data3-blog-8-20
          $table=Cfg::Master_post_css_table;
          $prefix=Cfg::Blog_prefix;
          }
     elseif ($type=='post'){//posts
          $table=Cfg::Master_post_table;
          $prefix=Cfg::Blog_prefix;
          }// note:  chech for array key 3 now obsolete
     elseif ($type=='colcss'){
          $table=Cfg::Master_col_css_table;
          $prefix=Cfg::Col_prefix;
          }
     elseif($type=='col'){//column
          $table=Cfg::Columns_table;
           $prefix=Cfg::Col_prefix;
          }
     elseif ($type=='page') {//pages
          $table=Cfg::Master_page_table;
          $prefix=Cfg::Page_prefix;
          }
     else {
          $this->message[]='type error in '.__method__.' line:'.__line__;
          return;
          }
     $q="select $field from $table $where";
     $r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);    
     $row=$this->mysqlinst->fetch_assoc($r,__LINE__);
     $styled=$row[$field];
     $style_array=explode(',',$styled);
     $count=count($style_array);
     if ($count < $key){
          for ($i=0; $i<$key+1; $i++){
               (!array_key_exists($i,$style_array))&&$style_array[$i]=0;
               }
          }
     
     if($style_array[$key]===$value)return;
     $style_array[$key]=$value;
     $style_implode=implode(',',$style_array);  
     $q="UPDATE $table SET $field='$style_implode',{$prefix}time='".time()."',token='".mt_rand(1,mt_getrandmax())."',{$prefix}update='".date("dMY-H-i-s")."'  $where";
     $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
     }
     
function process_uploads($type){
     switch($type){
          case  'pic' :
               $validext=Cfg::Valid_pic_ext;
               $config=(int)Cfg::Pic_upload_max;//see Cfg_master.class.php 
               $mime=Cfg::Valid_pic_mime;
               $dir=(isset($_POST['pic_folder_type'])&&$_POST['pic_folder_type']==='uploads')?Cfg_loc::Root_dir.Cfg::Upload_dir:Cfg_loc::Root_dir;
               break;
          case  'vid' :
               $config=(int)Cfg::Vid_upload_max;//see Cfg_master.class.php 
               $validext=Cfg::Valid_vid_ext;
               $mime=Cfg::Valid_vid_mime;
               $dir=(isset($_POST['vid_folder_type'])&&$_POST['vid_folder_type']==='video')?Cfg_loc::Root_dir.Cfg::Video_dir:Cfg_loc::Root_dir;
               break;
          default:
               echo "error in upload";
               return;
          }
     $max_upload = (ini_get('upload_max_filesize')<10000)?(int)(ini_get('upload_max_filesize')):(int)(ini_get('upload_max_filesize')/1000000);
     $max_post = (ini_get('post_max_size')<10000)?(int)(ini_get('post_max_size')):(int)(ini_get('post_max_size')/1000000); 
     $maxup=min($max_upload,$max_post,$config); 
     $instructions="Maximum filesize of  $maxup  Mb has been exceeded.";
     $instructions.= ' Only the filetypes '.$validext.' will work';
list ($uploadverification,$fiupl)=upload::upload_file($mime,$validext,$instructions,$dir);
     if ($uploadverification='true')   
          $this->success[]='Success. Check to see if your '.$type.' file has been uploaded to your site '.$dir;
     else {
          $this->message[]='Upload verification of '.$type.' file failed to load to home directory'; 
		}
	}
     

function import_gallery(){//gallery items are tagged to table using gall_table..  not absolutely necessary but it provides for pagename equals page name which is handy when choosing galleries for master gallery
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
					$q="update $post_table set blog_data1='$value' where blog_id='$prefix$blog_id' and blog_type='gallery' and blog_table_base='$this->pagename'";  
					$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
					if ($this->mysqlinst->affected_rows()){
						$q="update $this->master_gall_table set gall_table='$this->pagename' where master_gall_status !='master_gall' and gall_ref='$value'"; 
						$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
						}
					}
				}
			else if($value==='create_new_gallery'){
				$q="update $post_table set blog_data1='' where blog_id='$prefix$blog_id' and blog_table_base='$this->pagename' and blog_type='gallery'";
				$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
				}
			}//end foreach	
		}//end foreach
	}//end fuction import_gallery
     
function db_backup_restore(){//const View_db='viewbackupdb';
	#so here we are either using page_restore view to populate viewdb for viewing or  we are going to restore the present databse with the backup (page_restore_dbopt)
	if (!check_data::check_disabled('exec'))$command='exec';
	elseif (!check_data::check_disabled('system'))$command='system';
	else {
		$msg='Both system and exec commands necessary for automatically making backups and restoring them are disabled by php ini directive: disable_function which is set and can only be changed in the php.ini file(s). Remove either system or exec from the disable_function directive and automatic backups may be made.  Otherwise, manually backup you database from phpMyAdmin in your control panel or use the command line! Disable this message in file '.__file__.' on line '.__line__;
		mail::alert($msg);//disable
		$this->message[]=$msg;//disable
		} 
	if (isset($_POST['page_restore_view'])){  
		list($fname,$time)=explode('@@',$_POST['page_restore_view']);
		$dbname=Cfg::View_db;
		}
	 else if(isset($_GET['page_restore_dbopt'])){
		 if (!empty($_GET['page_restore_dbopt'])) //direct
			 list($fname,$time)=explode('@@',$_GET['page_restore_dbopt']);
		 else {
			 list($fname,$time)=explode('@@',$_SESSION[Cfg::Owner.'db_to_restore']);//from viewpages first
			 unset($_SESSION[Cfg::Owner.'db_to_restore']);
			 }
		 $dbname=Cfg::Dbname;
		 
		 }
	 $bfile=str_replace('.gz','',$fname);
	 $fullpathfile=Sys::Home_pub.Cfg::Backup_dir.$bfile;
	 $flag=false;
	 if (is_file(Sys::Home_pub.Cfg::Backup_dir.$bfile)){
		 $cmd1='';
		 $flag=true;
		 }
	 elseif (is_file(Sys::Home_pub.Cfg::Backup_dir.$fname)){ 
		 $cmd1='gunzip  '.Sys::Home_pub.Cfg::Backup_dir.$fname.';';
	 	 $flag=true;
		 
		 }
		 
	 if ($flag){
		 $host=Cfg::Dbhost;
		 $user=Cfg::Dbuser;
		 $pass=Cfg::Dbpass; 
		 $cmd2=Sys::Mysqlserver.'mysql  -h'.$host.' -u'.$user.' -p'.$pass.' '. $dbname.'  < '.$fullpathfile.';';
		//$this->success[]="Now viewing database $dbname with  with pushed $fullpathfile";  
		 $command($cmd1. $cmd2);
           $this->update_db($dbname);
		 if(isset($_GET['page_restore_dbopt'])){
               #first make backup copy of present db
			if (!is_file(Sys::Home_pub.Cfg::Backup_dir.$fname))$fname=str_replace('.gz','',$fname);
			 $this->backupinst->backupdb(Sys::Dbname,'',$time,$fname);
			 $msg='Chosen Db was restored: '.$fname;
			 printer::alert_pos($msg);
			 }
		 else {
			 $_SESSION[Cfg::Owner.'viewdb']=true;
			 $this->success[]='Db View initated from '.$this->get_time_ago($time);
			 $_SESSION[Cfg::Owner.'db_to_restore']=$_POST['page_restore_view'];
			 }
		 }
	 else $this->message[]='Problem with Backup restore fullfilepath of '.$fullpathfile.' in '.__METHOD__.__LINE__;	 
	}//end db_backup_restore

	
function update_sort_list($no,$big){
	$img_arr=array();
	$sort_arr=explode('|',$no);
	foreach ($sort_arr as $e){
		$img_arr[]=explode('!@!',$e)[1];
		}
	$sorted=implode(',',$img_arr);
	if (strpos($big,'page')!==false){
		$big=str_replace('page','',$big);
		$q="update $this->master_page_table set page_data1='$sorted' where page_id='$big'"; 
		}
	else $q="update $this->master_post_table set  blog_data1='$sorted' where  blog_id='$big'";   
	$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	if (!$this->mysqlinst->affected_rows())return false;
	return true;
	}
function update_gall_list($no,$big){ 
	$img_arr=array();
	$sort_arr=explode('|',$no);
	$x=1;
	foreach ($sort_arr as $e){
		$img_arr=explode('!@!',$e);
		$q="update $this->master_gall_table set gall_time='".time()."',token='".mt_rand(1,mt_getrandmax())."',pic_order='".$x."' where pic_id=".$img_arr[1]; 
		$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);  
		$x++;
		} 
	}

function update_editor_color_list($no){ 
	$img_arr=array();
	$sort_arr=explode('|',$no);
	$color_list='';
	$x=0;
	foreach ($sort_arr as $e){
		$new_arr=explode('!@!',$e);
		$color_list.=$new_arr[1].',';
		$x++;
		}
	
	$editor_ref=strtolower($new_arr[2]);
	$color_list=substr_replace($color_list,'',-1);
	$q="update $this->master_page_table set page_{$editor_ref}_editor_order='$color_list' where page_ref='$this->pagename'";
	$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); 
	}
function get_image_list($gall_ref,$re_id){
	$q="select picname from $this->master_gall_table where gall_ref='$gall_ref'";  
	$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	$return='<p class="editcolor editbackground  editfont">Choose an Image from your selected gallery to represent this gallery in the Gallery Link Page:</p>';
	$return.= '<div class="editcolor editbackground  editfont"><!--Image Select Wrap-->';
	While ($rows=$this->mysqlinst->fetch_row($r)){
	 	$return.= '<p class="floatleft"><input type="radio" name="gallref_image_choice['.$re_id.']" value="'.$rows[0].'"><img src="'.Cfg_loc::Root_dir.Cfg::Small_thumb_dir.$rows[0].'" width="150"></p>';
		}
	$return.='
	</div><!--Image Select Wrap-->';
	return $return;
	}
function display_image_list($gall_ref){
	$q="select picname from $this->master_gall_table where gall_ref='$gall_ref'";
	$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	 
	$return= '<div class="editcolor editbackground  editfont"><!--Image Select Wrap-->
	 <p><br></p>
	<p style="padding-top:10px;">Images Within this Gallery Choice:<br></p>';
	if ($this->mysqlinst->affected_rows()){
		While ($rows=$this->mysqlinst->fetch_row($r)){
			$return.= '<p class="floatleft pt10 pl10"><img src="'.Cfg_loc::Root_dir.Cfg::Small_thumb_dir.$rows[0].'" height="50"></p>';
			}
		}//affected
	else $return.="This gallery is Empty";
	$return.=' 
	<p class="clear"></p> <p class="smallest floatleft">Submit Gallery Change using any Change Button</p>
	</div><!--Image Select Wrap-->';
	return $return;
	}	
function iframe_list_gen($pages){
	$pages=explode(',',$pages);
	$frames='';
	if(isset($_SESSION[Cfg::Owner.'page_update_clones']))unset($_SESSION[Cfg::Owner.'page_update_clones']);
	foreach ($pages as $page){ 
		$frames.=file_generate::render_backup_iframe($page.'.php',500,400,'visible','px','px',true);
		}
	return $frames;	
	}

function gen_display_styles($data){//ajax style parser for quick reference
	$arr=explode('@@',$data);
	//'.$type.'@@'.$id.'@@'.$field
	$field=$arr[2];
	$id=$arr[1];
	switch($arr[0]){
		case 'page' :
			$table=$this->master_page_table;
			$ref='page_id';
			break;
		case 'col':
			$table=$this->master_col_table;
			$ref='col_id';
			break;
		case 'blog':
			$table=$this->master_post_table;
			$ref='blog_id';
			break;
		default: return $data;
		}
	$q="select $field from $table where $ref='$id'";
	$r=$this->mysqlinst->query($q);
	if ($this->mysqlinst->affected_rows()){
		list($styles)=$this->mysqlinst->fetch_row($r);
		}
	else return "No Styles found";
	$style_array=explode(',',$styles);
	$indexes=explode(',',Cfg::Style_functions);
	foreach($indexes as $key =>$index){ 
		if (!empty($index)) {
			${$index.'_index'}=$key; 
			}
		}
	
	$return=printer::alertx('<div class="Os3darkslategray fd2brightgreen editbackground editcolor editfont">',1);
     for ($i=0; $i < count($indexes); $i++){
		if (array_key_exists($i,$style_array)&&strpos($indexes[$i],'width')!==false&&strpos($indexes[$i],'media')===false){
               $this->my_temp_array=$style_array;
               $returnval=$this->spacing('my_temp_array',$i,'display_style','','','','',false,'',false,0,'',array('none'=>'use no value','auto'=>'set auto','zero'=>'set explicit 0'));
               $return.=printer::alertx( NL."{$indexes[$i]} value: $returnval",1);
               }
          elseif (!empty($indexes[$i])&&strpos($indexes[$i],'width')!==false&&strpos($indexes[$i],'media')===false) $return.=printer::alertx( NL."{$indexes[$i]} value: 0 ",1);     
          }
	for ($i=0; $i < count($indexes); $i++){
		if ($indexes[$i]==='background')continue;
		if ($indexes[$i]==='custom_style')continue;
		if (strpos($indexes[$i],'width')!==false&&strpos($indexes[$i],'media')===false)continue;
          if (array_key_exists($i,$style_array)&&(strpos($indexes[$i],'padding')!==false||strpos($indexes[$i],'margin')!==false)){
               $this->my_temp_array=$style_array;
               $returnval=$this->spacing('my_temp_array',$i,'display_style','','','','',false,'',false,0,'',array('none'=>'use no value','auto'=>'set auto','zero'=>'set explicit 0'));
               $return.=printer::alertx( NL."{$indexes[$i]} value: $returnval",1);
               }
          elseif(array_key_exists($i,$style_array)&&$indexes[$i]==='font_size'){
               $this->my_temp_array=$style_array;
               $returnval=$this->font_size('my_temp_array',$i,'return_val');
               $return.=printer::alertx( NL."{$indexes[$i]} value: $returnval",1);
               }
		elseif (array_key_exists($i,$style_array)&&!empty($indexes[$i]))$return.=printer::alertx( NL."{$indexes[$i]} value: {$style_array[$i]}",1);
		elseif (!empty($indexes[$i])) $return.=printer::alertx( NL."{$indexes[$i]} value: 0 ",1);
		}
	#####################################################################
	if(!array_key_exists($custom_style_index,$style_array)){
		$return.='<br><br>Custom Css Advanced Style:0 <br>'; 
		}
	else {
		$custom_style=$style_array[$custom_style_index];
		if (!empty($custom_style)&&$this->isSerialized($custom_style)){ 
		
			$media_added_style_arr=unserialize($custom_style);//for correct storage in style field value..
			$count=count($media_added_style_arr);
			}
		else {
			$count=0;
			$media_added_style_arr=array();
               $return.='<br><br>Custom Css Advanced Style:0 <br>'; 
               }
		foreach ($media_added_style_arr as $index => $array){//$array[1]=str_replace('<br>',"\n",str_replace('=>',',',$array[1]));
			$class_suffix=(array_key_exists($index,$media_added_style_arr)&&array_key_exists(0,$media_added_style_arr[$index])&&strlen($array[0])>1&&!is_numeric($array[0]))?str_replace('=>',',',$array[0]):'';
			$customcss=(array_key_exists($index,$media_added_style_arr)&&array_key_exists(1,$media_added_style_arr[$index]))?str_replace('<br>',"\n",str_replace('=>',',',$array[1])):'';
			$media_maxpx=(array_key_exists($index,$media_added_style_arr)&&array_key_exists(2,$media_added_style_arr[$index])&&$media_added_style_arr[$index][2]>199&&$media_added_style_arr[$index][2]<2001)?$media_added_style_arr[$index][2]:'';
			$media_minpx=(array_key_exists($index,$media_added_style_arr)&&array_key_exists(3,$media_added_style_arr[$index])&&$media_added_style_arr[$index][3]>199&&$media_added_style_arr[$index][3]<3001)?$media_added_style_arr[$index][3]:'';
			$data=str_replace('=>',',',str_replace('break',"\n",$array[1]));//for correct storage in style field value..
			$return.=  '<br><br>Custom Css Advanced Style: <br>';
		
			if (empty($media_minpx)&&empty($media_maxpx)){ 
				$return.= 'extension: '.$class_suffix.' Rules: { '.$data.'}';
				}
			elseif (!empty($media_minpx)&&!empty($media_maxpx)) {
				$return.= '
				@media screen and (max-width:'.$media_maxpx.'px) and (min-width:'.$media_minpx.'px){<br>
					Extension: '. $class_suffix.'<br>Rule: '.$class_suffix.'{'.$data.'}
					}
					';
				}
			elseif (!empty($media_maxpx)){
				$return.='
				@media screen and (max-width: '.$media_maxpx.'px){<br>  	
					Extension: '. $class_suffix.'<br>Rule: '.$class_suffix.'{'.$data.'}
				}';
				}
			else {
				$return.='
				@media screen and (min-width: '.$media_minpx.'px){<br>  	
					Extension: '. $class_suffix.' <br>Rule: '.$class_suffix.'{'.$data.'}
				}';
				} 
			}//end foreach css
		}
		
		
		
	###################################
	$return.='<br><br>Background Styles:';
	$background_styles=explode(',',Cfg::Background_styles);
	if(!array_key_exists($background_index,$style_array)){
		printer::alertx('Background: value: 0 ',1);
		return $return;
		}
		
	$background_value_array=explode('@@',$style_array[$background_index]);
	
	for ($i=0; $i<count($background_styles); $i++){ 
		if (array_key_exists($i,$background_value_array))$return.=printer::alertx(NL."{$background_styles[$i]} value: {$background_value_array[$i]}",1);
		else$return.=printer::alertx(NL."{$background_styles[$i]} value: 0",1);
		}
 	foreach($background_styles as $key =>$index){
		if (!empty($index)) {
			${$index.'_index'}=$key;
			   //print NL.  $index." = $key"; 
			}
		}
		
	$return.=printer::alertx(NL.NL.
	'<img src="'.Cfg_loc::Root_dir.Cfg::Background_image_dir.$background_value_array[$background_image_index].'"  width="75">',1);
	$return.=printer::alertx($background_value_array[$background_image_index].'</div>',1);
	return $return;
	}// function style display
#ajax
function gen_check_clones($id){
	$q="select col_table_base from $this->master_col_table where col_status='clone' and col_clone_target='$id'";
	$r=$this->mysqlinst->query($q);
	$array=array();
	$return='<p class="redAlertbackground white">The following Page References Have Clones of This column:</p>';
	if ($this->mysqlinst->affected_rows()){
		while (list($col_table_base) = $this->mysqlinst->fetch_row($r,__LINE__)){
			$return.='<p class="posbackground white">'.$col_table_base.'</p>';
			}
		return $return;
		}
	else return "No Pages Have Clones of This column ";
	}
function get_time_ago( $time )
{
    $time_difference = time() - $time;

    if( $time_difference < 1 ) { return 'less than 1 second ago'; }
    $condition = array( 12 * 30 * 24 * 60 * 60 =>  'year',
                30 * 24 * 60 * 60       =>  'month',
                24 * 60 * 60            =>  'day',
                60 * 60                 =>  'hour',
                60                      =>  'minute',
                1                       =>  'second'
    );

    foreach( $condition as $secs => $str )
    {
        $d = $time_difference / $secs;

        if( $d >= 1 )
        {
            $t = round($d,1);
            return  $t . ' ' . $str . ( $t > 1 ? 's' : '' ) . ' ago';
        }
    }
}

function display_fullnav(){
	$q="select distinct page_ref, page_title, page_filename from $this->master_page_table  order by page_ref ASC"; 
	$r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	$return='';
	while (list($page_ref,$title,$filename) = $this->mysqlinst->fetch_row($r,__LINE__)){
		if (trim($filename)==='')continue; 
		$return.= '<p class="editbackground  editfont"><a style="color:inherit;"  href="'.$filename.$this->ext.'">'.$title.': &nbsp;&nbsp;<span class="smaller info" title="Page Ref:'. $page_ref.' filename: '.$filename.$this->ext.'">'.$page_ref.'</a></p>'; 
		}
	return $return;
	}
     
function gen_display_anchor(){
	if (!is_file(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'display_anchor_'.$this->pagename.'.dat'))return 'Refresh Page to generate Goto anchors';
     $id_array=unserialize(file_get_contents(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'display_anchor_'.$this->pagename.'.dat'));
     $return='';   
	foreach($id_array as $idarr){ 
		$space=''; 
          for ($i=1; $i<$idarr[2]+1; $i++){
               $space.="&nbsp;&nbsp;&nbsp;&nbsp;"; 
               }
          if($idarr[0]==='blog'){
               $space.="&nbsp;&nbsp;"; 
               }
          $clone_msg=($idarr[4])?'&nbsp;&nbsp;<span class="italic bold">cloned post</span>':'';
          $return.= '<p class="underline editcolor editbackground  editfont small"><a href="#'.$idarr[1].'">'.$space.$idarr[3].$clone_msg.'</a></p>';
          }
	return $return;
	}
	
function choose_pagenav($data,$index){
	$q="select distinct page_ref, page_title, page_filename from $this->master_page_table  order by page_ref ASC";  
	$r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	$return='<p style="padding:10px;"><input type="radio" name="'.$data.'_blog_data2['.$index.']" value="none">Choose None</p>';
	while (list($page_ref,$title,$filename) = $this->mysqlinst->fetch_row($r,__LINE__)){
		if (trim($filename)==='')continue;
		$return.='<p style="padding:10px;"><input type="radio" name="'.$data.'_'.$index.'" value="'.$filename.$this->ext.'">'.$title.': &nbsp;&nbsp;<span class="smaller highlight" title="Page Ref:'. $page_ref.' filename: '.$filename.$this->ext.'">'.$page_ref.'</p>';  
	} 
	$return.='</div>';
	return $return;
	
	}

function theme_choice(){
     $col_fields=Cfg::Col_fields;
	$post_fields=Cfg::Post_fields;
	$page_fields=Cfg::Page_fields;
     $return='Import choices to Add a theme page. Added theme pages Will Not Automatically replace you current theme'; 
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
		if (strpos($db,Cfg::Theme_match)===false)continue;
          $this->update_db($db);//update db
		$tables=check_data::get_tables($db);   
		if (empty($tables)||!is_array($tables)){ 
			$return.=alert_neg("$db database has no tables",.8,true);
			continue;
			}
		foreach ($table_check as $check){
			if (!in_array($check,$tables))$check=false;
			}
		if ($check){ 
			$q="select $col_fields from $db.$this->master_col_table";
			$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
			if (!$this->mysqlinst->affected_rows()){
				$return.=printer::alert_neg($db .' has differing table fields for a check of '. $this->master_col_table,.8,1);
				}
			else {
				$q="select $post_fields from $db.$this->master_post_table";
				$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
				if (!$this->mysqlinst->affected_rows()){
					$return.=printer::alert_neg("$db has differing table fields for a check of $this->master_post_table  while Ok for $this->master_col_table",.8,true);
					}
				else {
					$q="select $page_fields from $db.$this->master_page_table";
					$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
					if (!$this->mysqlinst->affected_rows()){
						$return.=printer::alert_neg("$db  has differing table fields for a check of  $this->master_page_table while Ok for $this->master_col_table and $this->master_page_table",.8,true);
						}
					else $themedbs[]=$db;
					}
				}
			}
		else printer::alert_neg($db .' has differing tables',.8,true);
		} 
	$this->mysqlinst->dbconnect();//reconnect to current database  as get_tables redirects db
	if (count($themedbs) < 1){ 
		$return.=printer::alert_neg('No Theme Databases are currently installed having the term '.Cfg::Theme_match.' in the dbname',.8,true);
		}
	else {
		$msg="Cleaning of potentially harmful scripts has been disabled. Ensure Theme Database is from a Trusted Source.";
		$return.= '<div title="Import choices to Add a theme page. Added theme pages Will Not Automatically replace you current theme" class="editbackground editfont '.$this->column_lev_color.' fs2'.$this->column_lev_color.' rad5 left highlight">Choose your database to view pages and/or choose to import new theme page to your website <!--Import choices-->'; 
		$return.='<p class="left clear editbackground editfont '.$this->column_lev_color.' rs1redAlert smaller rad5 left highlight" title="Choose This option only if you trust the theme source and require special javascript content." ><input type="checkbox" class="cancel_clean_import" name="cancel_clean_import" value="1" onchange="gen_Proc.on_check_event(\'cancel_clean_import\',\''.$msg.'\');">Disable Cleaning Import of User Scripts</p>';
          foreach ($themedbs as $db){
               $return.='<p class="left editbackground editcolor"><input type="radio" name="add_theme_db" value="'.$db.'">Choose: '.$db.'</p>';
               }
          $return.='</div>';
		}
     $this->mysqlinst->dbconnect(Sys::Dbname);
     return $return;
     }
     
function display_backups(){
	$q='select backup_filename,backup_date,backup_time,backup_restore_time,backup_data1 from '.Cfg::Backups_table.' order by backup_time desc';
	$r=$this->mysqlinst->query($q); 
	$color='EBFCEE';
	$return='<div  class="Os3darkslategray fsminfo black editbackground  editfont small left"><p class="neu">Leave backgup choices  open if checking box otherwise may not submit</p><span class="warn">Selecting a restore file will negate any current edits you have made</span><br><br><span class="tip">First Restore File is Present State of Website</span><br><br><div style="padding-left:10px;padding-bottom:10px;color:black; background:#'.$color.'"><input type="radio" name="page_restore_view" value="">None<br></div>';
	$color='EBFCEE';
	if ($this->mysqlinst->affected_rows()){
		while (list($fname,$date,$time,$restoredate,$restorefname) = $this->mysqlinst->fetch_row($r,__LINE__)){
			
			 if (!is_file(Cfg_loc::Root_dir.Cfg::Backup_dir.$fname))continue;
			$data=file_get_contents(Cfg_loc::Root_dir.Cfg::Backup_dir.$fname);
			if (strpos($data,Cfg::Backups_table)!==false){
				$return.=printer::alert_neg('Omitted file: '.$fname.' contain table: '.Cfg::Backups_table.' and would overwrite backups','.8',1);
				continue;
				}
			$color=($color==='E9E9FC')?'EBFCEE':'E9E9FC';
			$restime=(!empty($restoredate))?'<p class="fs2npred">Restored file orig from '.date("dMY-H-i-s",$restoredate).'  Orig filename: '.$restorefname.'</p>':'';
			$return.='<div style="padding:10px;color:black; background:#'.$color.'"><input type="radio" name="page_restore_view" value="'.$fname.'@@'.$time.'">TimeAgo: '.$this->get_time_ago($time).'&nbsp; Date: '.$date.'&nbsp;Filename: '.$fname.'&nbsp; Size: '.(filesize(Cfg_loc::Root_dir.Cfg::Backup_dir.$fname)/1000).'Kb'.$restime.'</div>';
			}
		$return.='</div>';
		return $return;
		}
	else return "No Backup files found $q";
	}
function clone_check_parent($col_id){
     $this->coll_col_arr[]=$col_id;
     $q="select blog_col  from ".Cfg::Master_post_table." where blog_table_base='$this->pagename' and blog_type='nested_column' and blog_data1='$col_id'";
     $r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
     if ($this->mysqlinst->affected_rows()){
          list($blog_col_id)=$this->mysqlinst->fetch_row($r);
          self::clone_check_parent($blog_col_id);
          }
     else $this->clone_check_id($col_id);//get last col_id . ie primary
	}
     
function clone_check_id($col_id){
     $this->coll_col_arr[]=$col_id;
     $q="select blog_data1  from ".Cfg::Master_post_table." where blog_table_base='$this->pagename' and blog_type='nested_column' and blog_col='$col_id'";
     $r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
     if ($this->mysqlinst->affected_rows()){
          list($blog_col_id)=$this->mysqlinst->fetch_row($r);
          self::clone_check_id($blog_col_id);
          }
     $this->coll_col_arr=array_unique($this->coll_col_arr);
	}
     
function get_check_clone($col_id){
	//we run back on tree cause if cloned elsewhere it could have been from any of the parent columns so we check..   
	$this->coll_col_arr=array();
     $return='';
	//so here we are tracing back to see if the column and post changes have cloned counterparts on other pages.
     $col_clone_id=array();
     $this->clone_check_parent($col_id);
     $q='select col_id,col_table_base from '.Cfg::Columns_table." where col_status='clone' and col_clone_target='$col_id'";
	$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	if ($this->mysqlinst->affected_rows()){
          $return.='Cloned Columns affected: <br>';
          while (list($col_id,$pagename)=$this->mysqlinst->fetch_row($r,__LINE__)){
			$return.='Cloned Column id: '.$col_id.' Page: '.$pagename.'<br>';
			}//affected 1
		}//
     //print_r($this->coll_col_arr); exit('sud');
	foreach($this->coll_col_arr as $id){
          $q='select blog_type,blog_data1,blog_table_base from '.Cfg::Master_post_table." where blog_clone_target='$id' and blog_status='clone'";  
          $r2=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
          if ($this->mysqlinst->affected_rows()){
			list($blog_type,$blog_d1,$ptable)=$this->mysqlinst->fetch_row($r2);
               $return.='Cloned Column id: '.$col_id.' Page: '.$ptable.'<br>';
               }
          $q='select blog_id from '.Cfg::Master_post_table." where blog_type!='nested_column' and blog_col='$id' blog_status !='clone'";//get all non column posts within current column... ie blog_col
          $r3=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
          if ($this->mysqlinst->affected_rows()){
               $return.='Cloned Posts affected: <br>';
               while (list($blog_id)=$this->mysqlinst->fetch_row($r3,__LINE__)){
                    $q='select blog_id,blog_type,blog_table_base from '.Cfg::Master_post_table." where blog_type!='nested_column' and blog_col='$id' blog_status !='clone'";//get all non column posts and then check for clones...
                    $r4=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
                    if ($this->mysqlinst->affected_rows()){
                         list($blog_id,$blog_type,$ptable)=$this->mysqlinst->fetch_row($r4);
                              $return.='Cloned Blog id: '.$blog_id.' Page: '.$ptable.' blog_type: '.$blog_type.'<br>';
                         }//if affected
                    }//while
               }//if affected
		}//foreach
     return $return;
	} 


	
function ajax_check(){
	(Sys::Deltatime)&&$this->deltatime->delta_log(__line__.' @ '.__method__.'  '); 
	if ($this->edit&&isset($_GET['display_anchor'])){   
		$json_arr=array();    
		$json_arr[]='display_anchor'; 
		$json_arr[]=$this->gen_display_anchor();
		echo json_encode($json_arr); 
		exit(); 
		}
     if ($this->edit&&isset($_GET['bufferOutput'])){
          if (!is_file(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Buffer_dir.'output_'.$_GET['bufferOutput'].$this->pagename.'.dat'))exit(json_encode('reBuff rep'));//has been fired once
		$json_arr=array();    
		$json_arr[]=$_GET['bufferOutput'].'t'; 
		$data=$json_arr[]=mb_convert_encoding(process_data::readfile(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Buffer_dir.'output_'.$_GET['bufferOutput'].$this->pagename.'.dat'),'HTML-ENTITIES'); 
          unlink(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Buffer_dir.'output_'.$_GET['bufferOutput'].$this->pagename.'.dat');//remove prevent secondary click replacement 
		echo json_encode($json_arr); 
		exit(); 
		}
     if ($this->edit&&isset($_GET['check_clones'],$_GET['check_id'])){   
		$json_arr=array();    
		$json_arr[]=$_GET['check_id']; 
		$json_arr[]=$this->gen_check_clones($_GET['check_clones']);
		echo json_encode($json_arr); 
		exit(); 
		}
	if ($this->edit&&isset($_GET['display_fullnav'])){   
		$json_arr=array();    
		$json_arr[]='display_fullnav'; 
		$json_arr[]=mb_convert_encoding($this->display_fullnav(),'HTML-ENTITIES');
		echo json_encode($json_arr); 
		exit(); 
		}
	if ($this->edit&&isset($_GET['choose_pagenav'])){
		$data=$_GET['choose_pagenav'];
		$index=$_GET['choose_index'];
		$json_arr=array();    
		$json_arr[]='choose_pagenav_'.$data; 
		$json_arr[]=$this->choose_pagenav($data,$index);
		echo json_encode($json_arr); 
		exit(); 
		}
	if ($this->edit&&isset($_GET['display_backups'])){   
		$json_arr=array();
		$json_arr[]='display_backups'; 
		$json_arr[]=$this->display_backups();
		echo json_encode($json_arr); 
		exit(); 
		}
	if ($this->edit&&isset($_GET['theme_choice'])){   
		$json_arr=array();
		$json_arr[]='theme_choice'; 
		$json_arr[]=$this->theme_choice();
		echo json_encode($json_arr); 
		exit(); 
		}
	if ($this->edit&&isset($_GET['display_styles'],$_GET['display_id'])){   
		$json_arr=array();    
		$json_arr[]=$_GET['display_id']; 
		$json_arr[]=$this->gen_display_styles($_GET['display_styles']);
		echo json_encode($json_arr); 
		exit(); 
		}
	if ($this->edit&&isset($_GET['iframe_gen'],$_GET['pages'])){   
		$json_arr=array();   
		$json_arr[]='page_iframe_contain'; 
		$json_arr[]=$this->iframe_list_gen($_GET['pages']);
		$json_arr[]='page_mirror_update';
		$json_arr[]='<span class="floatleft Os5pos fd5pos">No problem to continue editing on this page below. These iframe(s) are updating the mirrored pages</span>';
		echo json_encode($json_arr);
		
		exit(); 
		}
	if ($this->edit&&isset($_GET['imageSelectGallery'])){   
		$json_arr=array();
		$arr=explode('@@',$_GET['imageSelectGallery']);
		$json_arr[]=$arr[1]; 
		$json_arr[]=$this->display_image_list($arr[0]);
		echo json_encode($json_arr);
		exit(); 
		}	
	if ($this->edit&&isset($_GET['imageChoiceMaster'])){ 
		$json_arr=array();
		$arr=explode('@@',$_GET['imageChoiceMaster']);
		$json_arr[]=$arr[2]; 
		$json_arr[]=$this->get_image_list($arr[0],$arr[1]);
		echo json_encode($json_arr);
		exit(); 
		}
	if ($this->edit&&isset($_GET['toggle_class_reload'])){ 
		$json_arr=array();
		$arr=explode('@@',$_GET['toggle_class_reload']);
		$q="update $this->master_post_table set blog_data1='".$arr[2]."' where blog_id='".$arr[1]."'";
		$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
		 
		 
		$data=str_replace('_blog_text','',$arr[0]);
		$url=Sys::Self.'?#'.$data;
		$json_arr[]='passfunct';
		$json_arr[]='locationAssign';
		$json_arr[]=$url; 
		echo json_encode($json_arr);
		exit(); 
		}
	if (Sys::Get_token&&isset($_GET['create_image'])){ //create missing slide images etc
		$json_arr=array();
		$arr=explode('@@',$_GET['create_image']);
		$this->resize($arr[0],$arr[1],0,0,Cfg_loc::Root_dir.Cfg::Upload_dir,$arr[2]); 
		//echo json_encode($json_arr);
		exit(); 
		}
	if (Sys::Get_token&&isset($_GET['create_image2'])){// create missing from js imageResponse images etc
		$json_arr=array();
		$arr=explode('@@',$_GET['create_image2']);
		$path_parts=pathinfo($arr[0]);
		$picname=$path_parts['basename'];
		$dirname=$path_parts['dirname'];
		$dirarr=array(Cfg::Page_images_dir,Cfg::Large_image_dir); //parse filename of img.src provided missing image
		foreach ($dirarr as $dir){
			if (strpos($dirname,$dir)!==false){
				$dirname=substr($dirname,strpos($dirname,$dir),strlen($dirname));
				break;
				}
			}
		image::image_resize($picname,$arr[1],0,0,Cfg_loc::Root_dir.Cfg::Upload_dir,$dirname); 
		mail::info("Msg Only No further xml response:  javascript image resize message:$dirname $picname");
		exit(); 
		} 
	 
	if ($this->edit&&isset($_GET['auto_sort'])){   
		$json_arr=array();
		$arr=explode('@@',$_GET['auto_sort']);
		$msgreturn=$this->update_sort_list($arr[0],$arr[1]);
		$msg=($msgreturn)?$arr[3]:'';
		$json_arr[]=$arr[2]; 
		$json_arr[]=$msg;
		echo json_encode($json_arr);
		exit(); 
		}	  
	if ($this->edit&&isset($_GET['gall_sort'])){   
		$json_arr=array();
		$arr=explode('@@',$_GET['gall_sort']);
		$this->update_gall_list($arr[0],$arr[1]);
		$json_arr[]=$arr[2]; 
		$json_arr[]=$arr[3];
		echo json_encode($json_arr);
		exit(); 
		}
	if ($this->edit&&isset($_GET['pageEd_sort'])){   
		$json_arr=array();
		$arr=explode('@@',$_GET['pageEd_sort']);
		$this->update_editor_color_list($arr[0],$arr[1]);
		$json_arr[]=$arr[2]; 
		$json_arr[]=$arr[3];
		echo json_encode($json_arr);
		exit(); 
		}
	if ($this->edit&&isset($_GET['leftovers'])){
		$json_arr=array();
		$json_arr[]='handle_leftovers';
		$json_arr[]=printer::alert('<a href="#leftovers">Delete/Move Leftover Unclones</a>',true,'neg normal shadowoff smallest button'.$this->column_lev_color );
		echo json_encode($json_arr);
		exit();
		}
	if ($this->edit&&isset($_GET['unclone_list_post'])){
		$type=' POST';
		$value=$_GET['unclone_list_post']; 
		$val_arr=explode('@@',$value);
		$clone_id=$val_arr[0];  
          $q="select blog_col from $this->master_post_table where blog_clone_target='$clone_id' OR blog_unclone=$clone_id";  
          $r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
		if ($this->mysqlinst->affected_rows()){
			$status=($unstatus==='unclone')?'uncloned':'cloned';
               $json_arr=array();  
			$json_arr[0]=$val_arr[1];
			$json_arr[1]=printer::alert_neg(NL."The Following Post Clones/Unclones Will Also Not Appear on Their Respective Pages.",1,true);
			while (list($blog_id,$blog_table_base,$status) = $this->mysqlinst->fetch_row($r,__LINE__)){
				$page=check_data::table_to_title($blog_table_base,__method__,__line__,__file__);
				$json_arr[1].="<p class=\"neu\">$type Id:$blog_id  From Page Title: $blog_table_base Status: $status</p>";
				}
			echo json_encode($json_arr);
               exit;
			}
		$q="select blog_col from $this->master_post_table where blog_id=$clone_id";  
          $r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
		if ($this->mysqlinst->affected_rows()){
               $json_arr=array();  
			$json_arr[0]=$val_arr[1];
			$json_arr[1]=printer::alert_neg(NL."The Following Post Clones Are within columns that have been cloned to other pages.",1,true);
			while (list($col_id) = $this->mysqlinst->fetch_row($r,__LINE__)){
				$returned=$this->get_check_clone($col_id);
                    if (!empty($returned))
                         $json_arr[1].=$returned;
                    else $json_arr[1]='';
                    echo json_encode($json_arr);
                    exit();
				}
			}
          exit();
		}
     if ($this->edit&&isset($_GET['unclone_list_column'])){ 
		$value=$_GET['unclone_list_column']; 
		$msg=' but any Unclones/Mirror releases will Not Be Deleted and a Link Will Be Provided For them to Be Moved or Deleted:';
		$val_arr=explode('@@',$value);
		$col_id=$val_arr[0];
          $json_arr=array();  
		$json_arr[0]=$val_arr[1];
		$json_arr[1]=printer::alert_neg(NL."The Following Clones of this column, or its nested columns and posts Will Also Not Appear on Their Respective Pages$msg",1,true);
          $returned=$this->get_check_clone($col_id);
          if (!empty($returned))
               $json_arr[1].=$returned;
          else $json_arr[1]='';
          echo json_encode($json_arr);
		exit();
		}
	}


}//end class     
?>