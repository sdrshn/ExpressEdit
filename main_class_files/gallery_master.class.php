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
class gallery_master  {
	private $no_error=true;
	private $delete_flag=false;
	private $undo_flag=false;
	private $vid_tablename='video';
	private $testpage=false;
	protected $pad_top=true;
	protected $menu_place=90;
	protected $edit_foreign=false;
	protected $highslide_background='fff';
	protected $high_back_cap='fff';
	protected $highslide_image='fff';
	public  $gall_topbot_pad=12; 
	protected $highslide_show_control='true';
	public $instruct=array();
	public $preload='';
	
	
function textarea($dataname,$name,$width,$fontsize){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
     $cols=process_data::width_to_col($width,$fontsize);
	$rowlength=process_data::row_length($this->$dataname,$cols); 
	//$height='';
	 echo '<textarea style="float:left;" class="fs1'.$this->column_lev_color.'" name="'.$name.'" rows="'.$rowlength.'" cols="'.$cols.'"   
	 onkeyup="gen_Proc.autoGrowFieldScroll(this)">' . process_data::textarea_validate($this->$dataname).'</textarea>'; 
    }
    
function submit_button($value=''){ if(Sys::Custom)return;if  (Sys::Pass_class||Sys::Quietmode)return;
	(empty($value))&& $value='SUBMIT All';//:'SUBMIT ALL CHANGES';
	echo'  <p><input class="editbackground rad5 small cursor button'.$this->column_lev_color.' '.$this->column_lev_color.' mb10"   type="submit" name="submit"   value="'.$value.'" ></p>';
	}
	  
function show_more($msg_open,$msg_close='close',$class='',$title='',$width='',$showwidth='',$styledirect='float:left;'){ if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	$full_width=(!empty($width)&&$width>50)?'gen_Proc.fullWidth(id,'.$width.');':'';      
	static  $show_more=0; $show_more++; 
	 printer::printx('<input type="text" style="height:2px;   color:rgba(255,255,255,0); background:rgba(255,255,255,0);border: 1px solid rgba(255,255,255,0); width:2px;" size="1" value="" id="showGall'.$show_more.'f">'); 
	(empty($class))&&$class=$this->column_lev_color.' floatleft editbackground button'.$this->column_lev_color;
	$this->show_msg=$msg_open;
	$msg_open_mod=str_replace(array('<','>'),'',$msg_open);
	$msg_close_mod=str_replace(array('<','>'),'',$msg_close);
	$lesswidth=($this->current_net_width<80)?5:20; 
	$stylewidth=(!empty($showwidth))?'style="max-width:'.$showwidth.$styledirect.'"':((isset($this->current_net_width)&&!empty($this->current_net_width))?'style="max-width:'.($this->current_net_width-$lesswidth).'px;'.$styledirect.'"':(!empty($styledirect)?'style="'.$styledirect.';"':''));
	//$border=($border)?' fs2'.$this->column_lev_color:'';
    echo '<p class="underline normal shadowoff cursor '.$class.' " title="'.$title.'" '.$stylewidth.'  onclick="gen_Proc.show(\'showGall'.$show_more.'\',\''.$msg_open_mod.'\',\''.$msg_close_mod.'\');'.$full_width.'" id="showGall'.$show_more.'">'.$msg_open.'</p>';
    printer::pclear();
    echo '<div class="inline"   id="showGall'.$show_more.'t" style="display: none; '.$styledirect.'"><!--'.$msg_open.' Gallery Master-->';
    
	// echo '<input type="text" style="height:10px;" size="1" value="" id="show'.self::$show_more.'f1">'; 
	
    }	
	
function pre_render_data(){ if (Sys::Debug) Sys::Debug(__LINE__,__FILE__,__METHOD__);   if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	
	//caution in master gallery mode  gall_ref refers to reference of master_gallery and master_gall_ref to a normal gall ref  referenced within...   whereas for normal galleries gall_ref refers to normal gallery and master gall ref is unused...  this allow gall_ref and coding to handle both normal and master gallery similiarly
	$this->passclass_ext=(Sys::Pass_class)?Cfg::Temp_ext:'';		 
	$this->sess=session::instance();  
	$this->addgallery=addgallery::instance(); 
	$this->mysqlinst=mysql::instance(); 
	$this->mysqlinst->dbconnect();
	$this->addgallery->tablename=$this->tablename; 
	$this->addgallery->gall_table=$this->gall_table;
	$this->sess=session::instance();
	if ($this->edit){ 
		$dir=Cfg_loc::Root_dir.Cfg::Large_image_dir;
		(!is_dir($dir))&&mkdir($dir,0755,1); 
		foreach($this->page_cache_arr as $ext){  
			(!is_dir($dir.Cfg::Response_dir_prefix.$ext))&&mkdir($dir.Cfg::Response_dir_prefix.$ext,0755,1); 
			}
		 }
		
	if ($this->edit&&!$this->master_gallery){
		//maxexpand value for each gallref will be collected and used in calculation for preloading first image to be displayed when a master gallery thumbnail is clicked..
		if (!is_file(Cfg_loc::Root_dir.'expand-'.$this->gall_ref.'.php')){
			file_generate::expand_file($this->gall_ref,$this->gall_table);
			}//generate expand image separate pagefile version  ie non ajax
		if (is_file(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Gall_info_dir.'data_maxexpand'.$this->passclass_ext)){
			$maxexpand_arr=unserialize(file_get_contents(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Gall_info_dir.'data_maxexpand'.$this->passclass_ext));
			$maxexpand_arr[$this->gall_ref]=$this->largepicplus;
			(!is_dir(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Gall_info_dir))&&mkdir(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Gall_info_dir,0755,1);
			file_put_contents(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Gall_info_dir.'data_maxexpand'.$this->passclass_ext,serialize($maxexpand_arr));
			}
		else {
			$maxexpand_arr=array();
			$maxexpand_arr[$this->gall_ref]=$this->largepicplus;
			(!is_dir(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Gall_info_dir))&&mkdir(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Gall_info_dir,0755,1);
			file_put_contents(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Gall_info_dir.'data_maxexpand'.$this->passclass_ext,serialize($maxexpand_arr));
			}
		 
		 
		 
		$q="select picname,gall_ref from $this->master_gall_table where master_gall_status!='master_gall' and pic_order=1 ";  
		$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
		$gallfirstimage=array();
		if ($this->mysqlinst->affected_rows()){ 
			while (list($firstpicname,$gall_ref_list)=$this->mysqlinst->fetch_row($r,__LINE__)){
				list($width,$height)=process_data::get_size($firstpicname,Cfg_loc::Root_dir.Cfg::Upload_dir);
				$ratio=$width/$height;
				$gallfirstimage[$gall_ref_list]=array($firstpicname,$ratio);
				}
			(!is_dir(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Gall_info_dir))&&mkdir(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Gall_info_dir,0755,1);	
			file_put_contents(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Gall_info_dir.'data_gall_firstimagelist'.$this->passclass_ext,serialize($gallfirstimage)); 
			//this is used in expandgallery for preloading first image in next gallery option and master gallery for preloading first image also.. this is generated in each gallery in edit mode as first image can be changed for any gallery without master galler being invoked for file update
			}
		 
		}
	elseif ($this->edit&&$this->master_gallery){//create flatfile array for expanded image gallery next gallery for when preview images are used
		$this->page_arr=array();
		$q='select page_filename,page_ref from '.Cfg::Master_page_table;
		$pa=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
		while(list($pagefn,$pageref)=$this->mysqlinst->fetch_row($pa)){
			$this->page_arr[$pageref]=$pagefn;
			}
		(!is_dir(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Gall_info_dir))&&mkdir(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Gall_info_dir,0755,1);	
		file_put_contents(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Gall_info_dir.'page_fname_arr_data'.$this->passclass_ext,serialize($this->page_arr));
		$collect=array();
		$gall_list=$gall_info=array();
		$q="select master_table_ref,imagetitle,master_gall_ref,pic_order from  $this->master_gall_table where master_gall_status='master_gall' AND gall_ref ='$this->gall_ref' order by pic_order"; 
		$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
		if ($this->mysqlinst->affected_rows()){   
			while ($rows=$this->mysqlinst->fetch_assoc($r,__LINE__)){
				$galleryfname=(array_key_exists($rows['master_table_ref'],$this->page_arr))?$this->page_arr[$rows['master_table_ref']]:'PageNotFound';
				$gall_info[$rows['pic_order']]=array($galleryfname,$rows['master_gall_ref'],$rows['master_table_ref']);
				 $gall_list[]=array($rows['imagetitle'],$galleryfname);
				}
			$this->show_more('Edit Individual Galleries');
			echo '<div class="editbackground editcolor  width300">';
			foreach ($gall_list as $array){
				echo '<p class="floatleft editbackground editcolor"><a class="click" href="'.$array[1].$this->ext.'">Edit '.substr($array[0],0,18).'</a></p>';
				printer::pclear();
				}
			
			echo '</div><!-- class="editpages editcolor  width300"-->';
			$this->show_close('Edit Individual Galleries');
			printer::pclear();
			(!is_dir(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Gall_info_dir))&&mkdir(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Gall_info_dir,0755,1);
			file_put_contents(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Gall_info_dir.'nextgall_data_'. $this->gall_ref.$this->passclass_ext,serialize($gall_info));
			}//affected rows
		$q="select master_gall_ref,gall_ref from  $this->master_gall_table where master_gall_status='master_gall'"; // do this for all master galleries
		
		$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
		if ($this->mysqlinst->affected_rows()){
			$mastergalllookup=array();
			while ($rows=$this->mysqlinst->fetch_assoc($r,__LINE__)){
				$mastergalllookup[$rows['master_gall_ref']]=$rows['gall_ref'];
				}
			(!is_dir(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Gall_info_dir))&&mkdir(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Gall_info_dir,0755,1);	 
			file_put_contents(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Gall_info_dir.'data_master_gall_ref'.$this->passclass_ext,serialize($mastergalllookup));
			}//affected rows 
	   
		}//edit and master gallery
		#$$$$$$$$$$$$$4
	else {//  not edit
			if (is_file(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Gall_info_dir.'page_fname_arr_data'.$this->passclass_ext)){
				$this->page_arr=unserialize(file_get_contents(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Gall_info_dir.'page_fname_arr_data'.$this->passclass_ext));
				}
               else $this->page_arr=array(); 
			}
	 
	
	if ($this->edit){
		if (!$this->master_gallery)
			$q="select pic_id,pic_order,picname from $this->master_gall_table where master_gall_status !='master_gall' and gall_ref='$this->gall_ref'"; 
		else $q="select pic_id,pic_order,picname from $this->master_gall_table where master_gall_status='master_gall' and gall_ref='$this->gall_ref'";
		$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);   
		if ($this->mysqlinst->affected_rows()){
			$page_arr=check_data::return_pages(__METHOD__,__LINE__,__FILE__);
			$resize_list='';
			$this->show_more('Expanded Image Info');
			while(list($pic_id,$pic_order,$picname)=$this->mysqlinst->fetch_row($r,__LINE__)){
				if (isset($_POST['submitted'])){
					if (isset($_POST['delete_gall'][$pic_id])){
						if ($this->master_gallery){
							$q="DELETE FROM $this->master_gall_table
								WHERE  pic_id = $pic_id AND master_gall_status='master_gall' AND gall_ref='$this->gall_ref'";
							$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
							 $msg="Success: gallery has been removed from $this->gall_ref...";  
							$_SESSION[Cfg::Owner.'update_msg'][]=printer::alert_pos($msg,1.3,true);
							}
						else {
							$q="DELETE FROM $this->master_gall_table
							WHERE  pic_id = $pic_id AND gall_ref='$this->gall_ref'";
							$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); 
							$msg="Success: picture has been deleted in $this->gall_ref...";  
							$_SESSION[Cfg::Owner.'update_msg'][]=printer::alert_pos($msg,1.3,true);
							}  
						}// if delete
					if (isset($_POST['update_caption'][$pic_id])){  
						$q='';
						foreach(array('imagetitle','subtitle','description') as $posted){
							if (isset($_POST['update_caption'][$pic_id][$posted])){
								$val=process_data::spam_scrubber($_POST['update_caption'][$pic_id][$posted]);
								$q.="$posted='$val', ";
								}
							}//end foreach
						if (!empty($q)){
							$q="update $this->master_gall_table set $q gall_time=".time().",token='". mt_rand(1,mt_getrandmax())."' where pic_id='$pic_id'";
							
							$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
							 $msg="Success: gallery image caption has been updated for image # $pic_order";  
							$_SESSION[Cfg::Owner.'update_msg'][]=printer::alert_pos($msg,1.3,true);
							}
						}//if caption_updat
					}//if submitted 	
				if (!$this->master_gallery){
					$parr=array();
					$total=$x=0;
					$maxfullwidth=check_data::key_up($this->page_cache_arr,$this->largepicplus,'val',$this->page_width);//this for naximum cache image generation...
					 
					$dir=Cfg_loc::Root_dir.Cfg::Large_image_dir.Cfg::Response_dir_prefix; 
					foreach($this->page_cache_arr as $ext){
						if ($ext <=$maxfullwidth){
							if (!is_file($dir.$ext.'/'.$picname)||isset($_POST[$this->data.'_blog_data2'][$this->image_quality_index])){
								$resize_list.=printer::alert_pos('Creating: '.$dir.$ext.'/'.$picname,.8,1);
								image::image_resize($picname,$ext,0,0,Cfg_loc::Root_dir.Cfg::Upload_dir, $dir.$ext,'file',NULL,$this->quality);
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
							}
						else{//size cache of this image is unnecessary as maxwidth is less
							if (is_file($dir.$ext.'/'.$picname)){//we will delete
								foreach($page_arr as $page_ref){ 
									$file='image_info_large_images_'.$page_ref.$this->passclass_ext; 
									if (is_file(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Image_info_dir.$file)){
									$array=unserialize(file_get_contents(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Image_info_dir.$file));
								
									$flag=true;
									$file=trim(Cfg::Large_image_dir,'/');
									$array=unserialize(file_get_contents(Cfg_loc::Root_dir.Cfg::Data_dir.$file));
									foreach ($array as $index => $arr){
								
										if (!array_key_exists('maxwidth',$arr))continue;
										if ($arr['id']==$this->blog_id){
											if ($arr['maxwidth']>=$ext){
												$flag=false;
												break;
												}
											}
										}//foreach array
									}//foreach page array
								}//
								if ($flag){	
									unlink($dir.$ext.'/'.$picname); //save disk space
									mail::info($dir.$ext.'/'.$picname. ' was unlinked');
									}
								}
							}
						}//foreach
					if ($x>0){ 
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
						@ Quality: $this->quality <br>
						Uploaded Master Img in uploads/:<br>
						filesize: $filesize Kb<br>
						width: {$width}px<br>
						height: {$height}px <br>
						density: $density ";
						echo $msg;
						printer::close_print_wrap('image info quality');
						$this->large_images_arr[]=array('id'=>$this->blog_id,'data'=>$this->data,'picname'=>$picname,'is_clone'=>$this->is_clone,'clone_local_style'=>$this->clone_local_style,'clone_local_data'=>$this->clone_local_data,'maxwidth'=>$maxfullwidth,'quality'=>$this->quality,'quality_option'=>$this->quality_option);
						}//if x
					}//not master gall
				}//end while
			
			$this->show_close('Expanded Image Info');
			echo $resize_list;
			if (isset($_SESSION[Cfg::Owner.'temp_msg'])){
				foreach($_SESSION[Cfg::Owner.'temp_msg'] as $msg){
					echo $msg;
					}
				unset($_SESSION[Cfg::Owner.'temp_msg']);
				}
			$this->tidy_gall_order();
			}//end affected rows
		}//if this edit 
	}//pre render

	
	
function tidy_gall_order(){ 
	if (!$this->master_gallery)
		$q="select pic_id from $this->master_gall_table where master_gall_status !='master_gall' and gall_ref='$this->gall_ref'"; 
	else $q="select pic_id from $this->master_gall_table where master_gall_status ='master_gall' and gall_ref='$this->gall_ref'";
	$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	if ($this->mysqlinst->affected_rows()){
		while(list($pic_id)=$this->mysqlinst->fetch_row($r,__LINE__)){
			$q="update $this->master_gall_table set temp_pic_order=''";
			$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
			if ($this->master_gallery){
				$q="select pic_id from $this->master_gall_table
					WHERE  master_gall_status ='master_gall' AND gall_ref='$this->gall_ref' order by pic_order ASC";
				 
				}
			else {
				$q="select pic_id from $this->master_gall_table
				WHERE  gall_ref='$this->gall_ref' order by pic_order ASC";
				}
			$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
			$x=1;
			while(list($pic_id)=$this->mysqlinst->fetch_row($r,__LINE__)){
				$q="update $this->master_gall_table set token='".mt_rand(1,mt_getrandmax())."',  gall_time='".time()."',pic_order='$x' where pic_id='$pic_id'";
				$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
				$x++;
				}
			}
		}
	}
 
function show_close(){
	echo '</div><!-- Gallery Master-->';
	}
  
function add_gall_form($msg){  echo $msg; 
	}
	
function gallery_display(){ if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__); 
	//key to master gallery fields
	//master_table_ref is page ref ($this->tablename) of the guest gallery record
	// gall_table is the page ref ($this->tablename ) for the master gallery itself
	// gall_table is the page ref ($this->tablename)  in normal gallery records
	//gall_ref  for both 
	//gall_ref is the particular reference for either normal or master gall as found in blog_data1 of the  post record in master_post_table  
	// master_gall_ref is the  gall_ref of the guest gallery record
	// master_gall_status is master gallery status or not as determined by 'master_gall'
	//master_gall_status determines true/false for master_gallery
	$height_array=array();
	$img_arr=array(); 
	if ($this->edit||Sys::Pass_class){//generate flatfile of master query display	 
		if (!$this->master_gallery){
			 
			$q = "SELECT  master_gall_ref,master_table_ref,pic_order, height, width, picname, pic_id, imagetitle, subtitle, description FROM $this->master_gall_table WHERE gall_ref='$this->gall_ref'  ORDER BY pic_order ASC"; 
			}//!master gall
		
		else {//   is master gallery
			$q = "SELECT  master_gall_ref,master_table_ref, pic_order,  height, width, picname, pic_id, imagetitle, subtitle, description FROM $this->master_gall_table WHERE master_gall_status='master_gall' and gall_ref='$this->gall_ref'  ORDER BY pic_order ASC";   //for master gallery
			}   
		$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); 
		if (!($this->mysqlinst->affected_rows())) {
			if (!$this->master_gallery){
				$msg="Add Your first image to the gallery";
				echo '<p id="return_'.$this->gall_ref.'">&nbsp;</p>';
				printer::printx('<p class="fs2'.$this->column_lev_color.' editbackground '.$this->column_lev_color.'"><a  class="fs2'.$this->column_lev_color.' editbackground '.$this->column_lev_color.'" href="addgallerypic.php?gall_ref='.$this->gall_ref.'&amp;postreturn='.Sys::Self.'&amp;addimage=1&amp;tbn='.$this->gall_table.'&amp;smallpicplus='.$this->smallpicplus.'&amp;largepicplus='.$this->largepicplus.'&amp;pgtbn='.$this->tablename.'&amp;sess_override&amp;sess_token='.$this->sess->sess_token.'">'.$msg.'</a><br/></p>');
				printer::pspace(25);
				return;
				}
			else printer::alert_neg('Add Master Gallery or remove');
			}// not affected rows 
		$collect_rows=array();
		while ($collect= $this->mysqlinst->fetch_row($r,__LINE__)) {
			$collect_rows[]=$collect; //we are building master query array
			}
		(!is_dir(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Gall_info_dir))&&mkdir(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Gall_info_dir,0755,1);	
		file_put_contents(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Gall_info_dir.'data_gall_main_'.$this->tablename.'_'.$this->blog_id.$this->passclass_ext,serialize($collect_rows));	
		}//end edit generate main query
	else { //not edit
		if (is_file(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Gall_info_dir.'data_gall_main_'.$this->tablename.'_'.$this->blog_id.$this->passclass_ext)){
			$collect_rows=unserialize(file_get_contents(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Gall_info_dir.'data_gall_main_'.$this->tablename.'_'.$this->blog_id.$this->passclass_ext));
			}
		else if (!$this->edit&&!$this->master_gallery){
			$msg="New Gallery Coming Soon";
			printer::alert_pos($msg);
			return;
			}
		
		}//end not edit 
	if (!isset($collect_rows)||count($collect_rows)<1){
		if (!$this->edit&&!$this->master_gallery){
			$msg="New Gallery Coming Soon";
			printer::alert_pos($msg);
			}
		return;//returns for all if no selected queries
		}
	$this->maxexpand=0;
	$ia=array();
	$ia[]='';
	$this->heightmax=0;
	$this->page_ref_arr=array();
	 
	foreach ($collect_rows as $collected){ 
		list($master_gall_ref,$master_table_ref, $pic_order, $height,$width,$picname,$pic_id,$imagetitle,$subtitle,$description)= $collected;//master_gall_ref and master table ref used in master gallery only 
		$dir=($this->master_gallery)?Cfg_loc::Root_dir.Cfg::Master_thumb_dir:Cfg_loc::Root_dir.Cfg::Small_thumb_dir;
		
		if ($this->master_gallery){
			list($width,$height)=process_data::get_size($picname,$dir); 
			}
		
		$galleryname=($this->master_gallery&&array_key_exists($master_table_ref,$this->page_arr))?$this->page_arr[$master_table_ref]:'';//used for filename.php
		 if (!is_file($dir.$picname)&&!is_file(Cfg_loc::Root_dir.Cfg::Upload_dir.$picname)){ 
			(!Sys::Pass_class)&&printer::alert_neg('Image '.$dir.$picname .' not found');
			$picname=Cfg::Pass_image;
			} 
		else if ($this->edit){
			if ($this->thumb_width_type==='width'){
				$resizewidth=$this->smallpicplus;
				$smallpicplus=0;
				}
			else {
				$resizewidth=0;
				$smallpicplus=$this->smallpicplus;
				}
			#generate small images no image response
			 if (!is_file($dir.$picname)){
				
				if (!$this->master_gallery){
					
					$return=image::resize_check($picname,$resizewidth,0,$smallpicplus,Cfg_loc::Root_dir.Cfg::Upload_dir,$dir,$this->blog_id);
					list($newwidth,$newheight)=process_data::get_size($picname,$dir);
					if ($width > $newwidth * 1.03 || $width < $newwidth * .97){
					    $q="update $this->master_gall_table set width='$newwidth', height='$newheight' where pic_id=$pic_id";//small pic listing
					    $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
					    //$this->instruct[]="Gall preview image $picname resized";
					    $width=$newwidth; $height=$newheight;
					    }
					}//!master gall
				else {  
					//smallpicplus size covers both setting for master gall thumbs and regular gallery
					 
					$return=image::resize_check($picname,$resizewidth,0,$smallpicplus,Cfg_loc::Root_dir.Cfg::Upload_dir,$dir,$this->blog_id);
					list($newwidth,$newheight)=process_data::get_size($picname,$dir); 
					}//!master gall
				}
			else {//submit removed... 
				list($pwidth,$pheight)=process_data::get_size($picname,$dir);
				$plus=($this->thumb_width_type==='width_height')?max($pwidth,$pheight):$pwidth;
				if ($plus > $this->smallpicplus * 1.03 || $plus < $this->smallpicplus * .97){ 
					$return=image::resize_check($picname,$resizewidth,0,$smallpicplus,Cfg_loc::Root_dir.Cfg::Upload_dir,$dir,$this->blog_id);
					$msg="Gallery preview image $picname was resized to the new plus width setting.";
					//($return)&&$_SESSION[Cfg::Owner.'update_msg'][]=printer::alert_pos($msg,1.1,true);
					list($newwidth,$newheight)=process_data::get_size($picname,$dir);
					if (!$this->master_gallery&& ($width > $newwidth * 1.03 || $width < $newwidth * .97)){
						$q="update $this->master_gall_table set width='$newwidth', height='$newheight' where pic_id=$pic_id";
						$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
						//$this->instruct[]="Gall preview image $picname resized";
						}
					
					$width=$newwidth; $height=$newheight;
					}
				}
			if (is_file(Cfg_loc::Root_dir.Cfg::Upload_dir.$picname)){
				$dir=Cfg_loc::Root_dir.Cfg::Large_image_dir.Cfg::Response_dir_prefix;
				$extarr=$this->page_cache_arr;
				$imgmaxkey=check_data::key_up($this->page_cache_arr,$this->maxexpand,'val',$this->page_width);
				foreach($extarr as $ext){
					if ($ext > $imgmaxkey)continue;
					if (!is_file($dir.$ext.'/'.$picname)){ 
						 image::resize_check($picname,0,0,$ext,Cfg_loc::Root_dir.Cfg::Upload_dir,$dir.$ext.'/',$this->blog_id);
						}
					}
				}
			else $this->message[]=printer::alert_neg('Missing expanded gallery image '.Cfg_loc::Root_dir.Cfg::Upload_dir.$picname,1,1);
			}//end if edit..
		//list($pwidth,$pheight)=process_data::get_size($picname,Cfg_loc::Root_dir.Cfg::Large_image_dir);
		$this->maxexpand=$this->largepicplus; 
		if ($this->edit&&!is_file(Cfg_loc::Root_dir.Cfg::Upload_dir.$picname))$this->message[]="missing image file $picname in uploads directory. Necessary for serving the correct Device sized Expanded Images";  		
		
		$ia[]=array($picname,$imagetitle,$subtitle,$description,$width,$height); 
		$this->height_array[$pic_order]=array('height'=>$height,'width'=>$width);  //this fully generates height_array info
		$this->img_arr[]=array('galleryname'=>$galleryname,'picname'=>$picname,'pic_id'=>$pic_id,'imagetitle'=>$imagetitle,'subtitle'=>$subtitle,'description'=>$description,'pic_order'=>$pic_order,'height'=>$height,'width'=>$width);// for edit pages
			
		}//end while
	 
	if ($this->edit&&!$this->master_gallery){
		(!is_dir(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Gall_info_dir))&&mkdir(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Gall_info_dir,0755,1);
		file_put_contents(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Gall_info_dir.'gall_image_data_'. $this->gall_ref.$this->passclass_ext,serialize($ia));#here  specific reference to gall_ref  will reflect  the clone local data decision of which gall_ref to use  
		$json=$json2=array();
		$json['blog_id']=$this->blog_id;  
		$json['gall_table']=$this->gall_table;
		$json['parent_wid']=$this->parent_wid;
		$json['returnto']=Sys::Self;
		$json['page_cache_arr']=$this->page_cache_arr;//sizes of cache..
		$json['data']=$this->data;
		//$json['img_array']=$ia;
		$json['clone_local_style']=$this->clone_local_style;
		$json['clone_local_data']=$this->clone_local_data; 
		//$json['background']=$this->background;
		$json['page_width']=$this->page_width;
		$json['current_net_width']=$this->current_net_width;
		$json['default_imagetitle']=$this->default_imagetitle;
		$json['default_subtitle']=$this->default_subtitle;
		$json['default_description']=$this->default_description;
		$json2['maxexpand']=$this->maxexpand;  
		$json2['transition_time']=$this->transition_time;
		$json2['thumbnail_height']=$this->thumbnail_height;
		$json2['transition']=$this->transition;
		$json2['show_under_preview']=$this->show_under_preview;
		$json2['maxwidth_adjust_expanded']=$this->maxwidth_adjust_expanded;
		$json2['new_page_effect']=$this->new_page_effect; //simulate..
		$json2['gall_expand_menu_icon']=$this->gall_expand_menu_icon;
		$json2['blog_data2']=$this->blog_data2;
		$json2['next_gallery']=$this->next_gallery; //set to true affects preview under expand only
		$transition_append=($this->transition==='fade'||$this->transition==='none')?'page_source':$this->transition;
		 
		(!is_dir(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Gall_info_dir))&&mkdir(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Gall_info_dir,0755,1);
		(!$this->is_clone)&&file_put_contents(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Gall_info_dir.'json_'.$this->blog_id.$this->passclass_ext.'.dat',serialize($json2));//clone references specific page table
		file_put_contents(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Gall_info_dir.'json2_'.$this->gall_ref.$this->clone.$this->passclass_ext.'.dat',serialize($json));//clone references specific page table
		  
		} 
	printer::pclear(); 
	($this->edit)&&self::show_more('View Current Preview/Gall Arrangement');
	if (!$this->master_gallery&&$this->gall_display==='no_display'){
		$expand=expandgallery::instance();
		$expand->gall_ref=$this->gall_ref; 
		$expand->page_source=false;
		$expand->clone=$this->clone;
		$expand->no_prev_page=true; 
		$expand->transition=$this->transition;
		$expand->pre_render_data();
		}
	$this->class_single_multiple=($this->preview_display=='single')?'marginauto center':'inlineblock'; 
	($this->gall_display==='highslide')&&printer::printx('<p id="goto_'.$this->gall_ref.'"></p>');//for gallery navigation go to
	if ($this->gall_display!=='no_display'||$this->edit) {  
		foreach($this->img_arr as $arr){
			
			$this->galleryname=$arr['galleryname'];
			$this->picname=$arr['picname']; 
			$this->imagetitle=$arr['imagetitle'];
			$this->subtitle=$arr['subtitle'];
			$this->description=$arr['description'];
			$this->width=$arr['width']; 
			$this->height=$arr['height'];
			$this->pic_id=$arr['pic_id'];
			$this->pic_order=$arr['pic_order'];
			$this->alt=str_replace('"','',substr($this->imagetitle,0,25));
			$this->width=round($this->width); 
			$this->continue=true;
			######&&&&&&&&&  Percent Convert Here!!  &&&&&&&&&&&&&
			// $percent_conv= 1/$this->current_net_width*$this->wpercent;
			
			//here we set up for preloading of images for regular gallery  thumbnail picname same as expanded image name   same ratio
			
				  
			$this->style_single='style="max-width:'.$this->width.'px;height:auto; margin-bottom: '.$this->gall_topbot_pad.'px;"';
			$this->style='style="max-width:'.$this->width.'px;height:auto; margin-bottom:'.$this->gall_topbot_pad.'px; vertical-align: middle; margin-left: '.($this->padleft/2).'%;margin-right: '.($this->padleft/2).'%; "';//padding:0; removed
			$this->style_widheight='style="max-width:'.$this->width.'px; height:auto;"';
			 //display appropriate reference
			if ($this->gall_display=='highslide'):
				 $this->highslide();
			elseif ($this->gall_display=='rows_caption'):
				 $this->rows_caption();
			elseif ($this->gall_display=='expandgallery'):   
				 $this->expandgallery();
			elseif ($this->gall_display=='gallerycontent'):
				 $this->gallerycontent();
			elseif ($this->gall_display=='display_single_row'): 
				 $this->display_single_row();
				//reinitialize as we are using 1 image per row only...
				$this->padleft=0;
				$this->lastpad=false;
				$this->position=1;
				$flag=false;
			endif;
			if (!$this->master_gallery&&!$this->edit){ 
				$ratio=$this->width/$this->height;
				$maxexpand=$this->maxexpand;
				if ($ratio > 1){
					$pwidth=$maxexpand;//maxexpand is set in individual galleries.. 
					$pheight=$pwidth/$ratio;
					}
				else {
					$pheight=$maxexpand;
					$pwidth=$pheight*$ratio;
					}
				$this->viewport_width=process_data::get_viewport();
				$maxed_width=($this->viewport_width >200)?min($this->viewport_width,$pwidth):$pwidth;//precaution if < 200 may be inaccurate
				$image_width=check_data::key_up($this->page_cache_arr,$maxed_width,'val',$this->page_width);
				$image_dir=Cfg::Response_dir_prefix.$image_width.'/';
				$preload_array[]='"'.Cfg::Large_image_dir.$image_dir.$this->picname.'"'; //collected expand dir.picname
				}
			} // End of WHILE loop.
		}
		
	($this->edit)&&self::show_close();
	#continue preload...
	if (!$this->master_gallery&&!$this->edit&&$this->gall_display!=='no_display') 
		$this->preload=implode(',',$preload_array);//this gets fed back to mainpage and will end up in javascript call to fadeTo.preloading in function javascript_preload in global_master.class.php
	if ($this->master_gallery&&!$this->edit){//get dir.firstimage from each gallery for preload
		if (is_file(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Gall_info_dir.'data_maxexpand')&&is_file(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Gall_info_dir.'data_maxexpand'.$this->passclass_ext&&is_file(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Gall_info_dir.'data_gall_firstimagelist'.$this->passclass_ext))){
			$gallfirstimage=unserialize(file_get_contents(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Gall_info_dir.'data_gall_firstimagelist'.$this->passclass_ext));
			$maxexpand_arr=unserialize(file_get_contents(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Gall_info_dir.'data_maxexpand'.$this->passclass_ext));
			$preload_arr=array();
			foreach ($collect_rows as $collected){
				list($master_gall_ref,$master_table_ref, $pic_order, $height,$width,$picname,$pic_id,$imagetitle,$subtitle,$description)= $collected;//here all we really need is master_gall_ref otherwise picname is for master gall thumbnails not first actual image of referred to gallery
				$picname=$gallfirstimage[$master_gall_ref][0];
				$ratio=$gallfirstimage[$master_gall_ref][1];
				$maxexpand=(array_key_exists($master_gall_ref,$maxexpand_arr))?$maxexpand_arr[$master_gall_ref]:'800';
				if ($ratio > 1){
					$pwidth=$maxexpand;//maxexpand is set in individual galleries.. 
					$pheight=$pwidth/$ratio;
					}
				else {
					$pheight=$maxexpand;
					$pwidth=$pheight*$ratio;
					}
				$this->viewport_width=process_data::get_viewport();
				$maxed_width=($this->viewport_width >200)?min($this->viewport_width,$pwidth):$pwidth;//precaution if < 200 may be inaccurate
				$image_width=check_data::key_up($this->page_cache_arr,$maxed_width,'val',$this->page_width);
				$image_dir=Cfg::Response_dir_prefix.$image_width.'/';
				$preload_array[]='"'.Cfg::Large_image_dir.$image_dir.$picname.'"'; 
				}
			$this->preload=implode(',',$preload_array);
			}
		 
		
		}
	
	printer::pclear();
	($this->edit)&&$this->edit_display();
	}//end  

 
 

function edit_display($title=false,$subtitle=false,$description=false){  if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	static $inc=0; $inc++;   
	if (!$this->enable_edit)return; 
	$dir=(is_file(Cfg_loc::Root_dir.Cfg::Small_thumb_dir.$this->picname))?Cfg::Small_thumb_dir:Cfg::Master_thumb_dir;
	if ($this->master_gallery){  
		printer::pclear(15);
		echo '<div class="fsminfo  editbackground floatleft Os5ekblue"><!--gallery master edit-->'; 
		printer::printx('<p class="floatleft '.$this->column_lev_color.' bold  editfont">Master Gall Image Order, Delete, Captions, Add Gallery Collection</p>');
		printer::pclear();
		$this->show_more('Rearrange Images Here','','','',900);
		echo '<div class="editbackground fsminfo floatleft"><!--rearrange background wrap-->';
		print'<p class="'.$this->column_lev_color.' large fsminfo floatleft left editbackground">Drag the image box to sort the image order. </p>';
		printer::pclear();
		echo '<p id="updateGallMsg_'.$this->inc.'" class="pos left larger editbackground"></p>';
		printer::pclear(5);
		echo '<ul id="sortGall_'.$this->inc.'" data-inc="'.$inc.'" data-id="'.$this->blog_id.'" class="nolist sortGall" >';
		printer::pclear(5);
		foreach ($this->img_arr as $key => $ia){
			$image= $ia['picname'];
			$pic_id=$ia['pic_id'];
			printer::printx('<li class="floatleft pb2 m1all fs2npinfo editbackground"  id="sortGall!@!'.$pic_id.'!@!'.$key.'"> <img class="pb5" src="'. Cfg_loc::Root_dir.$dir. $image
			. '" height="90" alt="'. $this->alt.
			'Artwork by '.Cfg::Owner. '"><br> ');
			echo ' <p class="inlinehighlight small center pt2 pb2"># ' .$key   .'<br></p></li>'; 
			}//end foreach
		print '</ul><!--end gall_center-->';
		echo '</div><!--rearrange background wrap-->';
		printer::pclear();
		$this->show_close('Rearrange Images Here');
		printer::pclear(5); 
		$this->show_more('Edit Image Captions or Delete a Gallery Entry Here','','','',700);
		echo '<div class="editbackground editcolors fsminfo"><!--edit image captions wrap outer master-->';
		$msg="Edit Captions";
		printer::printx('<p class="'.$this->column_lev_color.' large fsminfo floatleft left editbackground">'.$msg.'<br> <span class="neg whitebackground"> Checking the checkbox next to an image will DELETE the Gallery Image Link for the Master Gallery (Not the actual Gallery)</span><br>You Can Also Delete a Gallery Here and re-add-it to change the Chosen Gallery Image as Needed</p>');
		printer::pclear(5);
		
		echo '<ul class="nolist" >'; 
		foreach ($this->img_arr as $key => $ia){
			$image= $ia['picname'];
			$pic_id=$ia['pic_id'];
			$this->imagetitle=$ia['imagetitle'];
			$this->subtitle=$ia['subtitle'];
			$this->description=$ia['description'];
			echo '<li class="floatleft pb2 m1all fs2npinfo editbackground"><input type="checkbox" name="delete_gall['.$pic_id.'][]" value="delete"><img class="pb5" src="'. Cfg_loc::Root_dir.$dir. $image
			. '" height="90" alt="'. $this->alt.
			'Artwork by '.Cfg::Owner. '"> ';
			printer::pclear(1);
			$this->show_more('Edit Captions','','','',600);
			echo '<div class="fs3red editbackground"><!--wrap edit captions inner master-->';
			printer::printx('<p class="fs2info   center inline '.$this->column_lev_color.'">Filename: '.$image.'</p>');
			printer::pclear();
			echo '<div class="fsminfo floatleft left editcolor editbackground "><span class="'.$this->column_lev_color.'"> Edit Title:</span>';
			self::textarea('imagetitle','update_caption['.$pic_id.'][imagetitle]','600','16');
			printer::pclear();
			echo '</div>';
			printer::pclear();
			echo '<div class="fsminfo floatleft left editcolor editbackground "><span class="'.$this->column_lev_color.'"> Edit Subtitle:</span>';
			self::textarea('subtitle','update_caption['.$pic_id.'][subtitle]','600','16');
			printer::pclear();
			echo '</div>';
			printer::pclear();
			echo '<div class="fsminfo floatleft left editcolor editbackground "><span class="'.$this->column_lev_color.'"> Edit description:</span>';
			self::textarea('description','update_caption['.$pic_id.'][description]','600','16');
			echo '</div>';
			printer::pclear();
			
			echo '</div><!--wrap edit captions inner master-->';
			
			printer::pclear(5);
			$this->show_close('Edit Captions');
			printer::pclear(5); 
			}//end foreach
		 echo '</ul><!--nolist-->';
		
		printer::pclear(5);
		echo '</div><!--edit image captions wrap outer-->'; 
		$this->show_close('Edit Image Captions or Delete a Gallery Entry Here'); 
		$this->show_more('Add a New  Gallery Collection in Master Gallery','noback','button'.$this->column_lev_color.' rad3 small editbackground '.$this->column_lev_color,'','full');
		echo '<div class="fs4black floatleft editbackground maxwidth700"><!--wrap master gall href-->';
		printer::pclear();
		 
		printer::alertx('<p class="floatleft editcolor editbackground">Choose a previously Created Gallery to Add to This Master Gallery Collection Here:
		 <select class="smaller editcolor editbackground" onchange="edit_Proc.imageSelectMaster(this,\'gallref2_image_choice_'.$inc.'\',\'gallref2_title_'.$inc.'\',\''.$this->gall_ref.'\');"  name="create_master_gallery['.$this->gall_ref.']">');
		printer::alertx('<option value="" select="selected">Choose Gallery to Add</option>');
		$q="select distinct gall_ref,gall_table from $this->master_gall_table where master_gall_status!='master_gall' order by gall_table"; 
		$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
		$g_arr=array();
		if ($this->mysqlinst->affected_rows()){ 
			While ($gRows=$this->mysqlinst->fetch_assoc($r)){
				$g_arr[]=$gRows;
				}
			} 
		foreach($g_arr as $arr){
			$choosegall_ref=$arr['gall_ref'];
			$ch_gall_table=$arr['gall_table'];
			$where="where master_gall_ref='$choosegall_ref'";
			 $count=$this->mysqlinst->count_field($this->master_gall_table,'gall_ref','',false,$where);//if chosen before omit for master gallery
			 if ($count>0)continue;
			// $in_use= ($count>0)?'<span class="tiny alertRed">Prev Chosen </span>':'';   NOT USED Creates error
			
			$q='select page_title,page_ref, page_filename from '.Cfg::Master_page_table." where page_ref='$ch_gall_table'";   
			$rpag = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
			
			list($page_title,$page_ref,$page_filename)=$this->mysqlinst->fetch_row($rpag);
			 if (empty($page_ref)||$page_ref!==$ch_gall_table)continue;
		
			$menu_title=(!empty($page_title))?'Menu Title: '.substr($page_title,0,15):'';
			printer::printx('<option  value="'.$choosegall_ref.'">'."GallRef: $choosegall_ref on PageRef: $ch_gall_table $menu_title".'</option>');
			}
		printer::printx('</select></p>');
		printer::pclear(10); 
		echo '<div id="gallref2_image_choice_'.$inc.'"><!--display image choice--></div><!--display image choice-->';
		printer::pclear(10);
		echo '<div id="gallref2_title_'.$inc.'" class="editbackground editcolor" style="display:none">Enter a title For Your Gallery<input type="text" name="master_title['.$this->gall_ref.']" maxlength="50" size="50"></div>'; 
		printer::pclear();
		echo '<div id="dis_gallref2_title_'.$inc.'"><!--or Continue-->';
		 	
		echo '</div><!--or Continue-->';
		printer::pspace(20);
		echo'<div id="show_gallref2_title_'.$inc.'" class="warn1 center inline" style="display:none;">Following your selection of image and entering the title hit submit button to Add Gallery Collection to the Master Gallery (&amp; other changes)<!--show submit button and info-->';
		 self::submit_button('Submit Changes');
		echo'</div>';
		echo '</div><!--wrap master gall href-->';
		$this->show_close('Master Gallery Info');
//printer::printx('<p class="fs2'.$this->column_lev_color.' floatleft rad5  underline left ml5 '.$this->column_lev_color.'"><a  href="addgallerypic.php?gall_ref='.$this->gall_ref.'&amp;postreturn='.Sys::Self.'&amp;addimage=1&amp;tbn='.$this->gall_table.'&amp;smallpicplus='.$this->smallpicplus.'&amp;pgtbn='.$this->tablename.'&amp;largepicplus='.$this->largepicplus.'&amp;sess_override&amp;sess_token='.$this->sess->sess_token.'">Add a New Image To this Gallery</a><br/></p>');
 
		echo '</div><!--gallery master edit-->';
		printer::pclear(15);
		}
		
	else {//not master gall
		printer::pclear(15);
		
		echo '<div class="fsminfo Os5ekblue marginauto"><!--gallery master edit-->';
		 
		printer::printx('<p class="'.$this->column_lev_color.' bold  editfont">Edit Image Order, Delete Images, and Add/Change Image Caption</p>');
		printer::pclear();
		$this->show_more('Rearrange Images Here','','','','full');
		echo '<div class="editbackground editcolors fsminfo"><!--rearrange images wrap  regular-->';
		print'<p class="'.$this->column_lev_color.' large fsminfo floatleft left editbackground">Drag the image box to sort the image order. </p>';
		printer::pclear(5);
		echo '<p id="updateGallMsg_'.$this->inc.'" class="red larger editbackground"></p>';
		printer::pclear(5);
		echo '<ul id="sortGall_'.$this->inc.'" data-inc="'.$inc.'" data-id="'.$this->blog_id.'" class="nolist sortGall" >';
		foreach ($this->img_arr as $key => $ia){
			$image= $ia['picname'];
			$pic_id=$ia['pic_id'];
			printer::printx('<li class="floatleft pb2 m1all fs2npinfo editbackground"  id="sortGall!@!'.$pic_id.'!@!'.$key.'"> <img class="pb5" src="'. Cfg_loc::Root_dir.$dir. $image
			. '" height="90" alt="'. $this->alt.
			'Artwork by '.Cfg::Owner. '"><br> ');
			
			echo ' <p class="inlinehighlight small center pt2 pb2"># ' .$key   .'<br></p></li>'; 
			}//end foreach
		print '</ul><!--end gall_center-->';
		printer::pclear(5);
		echo '</div><!--rearrange images wrap  regular-->';
		
		$this->show_close('Rearrange Images Here');
		printer::pclear(5); 
		$this->show_more('Edit Image Captions or Delete an Image Here','','','',900);
		echo '<div class="editbackground editcolors fsminfo"><!--edit image captions wrap outer regular-->';
		printer::pclear(5);
		$msg="Edit Captions";
		printer::printx('<p class="'.$this->column_lev_color.' large fsminfo floatleft left editbackground">'.$msg.'<br> <span class="neg"> Checking the checkbox next to an image will DELETE the Image</span> </p>');
		printer::pclear(5);
		
		echo '<ul class="nolist" >'; 
		foreach ($this->img_arr as $key => $ia){
			$image= $ia['picname'];
			$pic_id=$ia['pic_id'];
			$this->imagetitle=$ia['imagetitle'];
			$this->subtitle=$ia['subtitle'];
			$this->description=$ia['description'];
			echo '<li class="floatleft pb2 m1all fs2npinfo editbackground"><input type="checkbox" name="delete_gall['.$pic_id.'][]" value="delete"><img class="pb5" src="'. Cfg_loc::Root_dir.$dir. $image
			. '" height="90" alt="'. $this->alt.
			'Artwork by '.Cfg::Owner. '"> ';
			printer::pclear(1);
			$this->show_more('Edit Captions','','','',600);
			echo '<div class="fs3red editbackground editcolor"><!--wrap edit captions regular-->';
			printer::printx('<p class="fs2info   center inline '.$this->column_lev_color.'">Filename: '.$image.'</p>');
			printer::pclear();
			echo '<div class="fsminfo floatleft left '.$this->column_lev_color.'"> Edit Title:';
			self::textarea('imagetitle','update_caption['.$pic_id.'][imagetitle]','600','16');
			printer::pclear();
			echo '</div>';
			printer::pclear();
			echo '<div class="fsminfo floatleft left '.$this->column_lev_color.'"> Edit Subtitle:';
			self::textarea('subtitle','update_caption['.$pic_id.'][subtitle]','600','16');
			printer::pclear();
			echo '</div>';
			printer::pclear();
			echo '<div class="fsminfo floatleft left '.$this->column_lev_color.'"> Edit description:';
			self::textarea('description','update_caption['.$pic_id.'][description]','600','16');
			echo '</div>';
			printer::pclear();
			
			echo '</div><!--wrap edit captions regular-->';
			$this->show_close('Edit Captions');
			printer::pclear(5); 
			}//end foreach
			printer::pclear();
		 echo '</ul><!--nolist-->';
		 printer::pclear();
		 echo '</div><!--edit image captions wrap outer regular-->';
		$this->show_close('Edit Image Captions or Delete an Image Here');
		echo '<p id="return_'.$this->gall_ref.'" style="height:8px;">&nbsp;</p>';
		printer::printx('<p class="fs2'.$this->column_lev_color.' editbackground floatleft rad5  underline left ml5 '.$this->column_lev_color.'"><a  href="addgallerypic.php?gall_ref='.$this->gall_ref.'&amp;postreturn='.Sys::Self.'&amp;addimage=1&amp;tbn='.$this->gall_table.'&amp;smallpicplus='.$this->smallpicplus.'&amp;pgtbn='.$this->tablename.'&amp;largepicplus='.$this->largepicplus.'&amp;sess_override&amp;sess_token='.$this->sess->sess_token.'">Add a New Image To this Gallery</a><br/></p>');
		printer::pclear(6);
		echo '</div><!--gallery master edit-->';
		printer::pclear(15);
		
		}//not master gall
    }
 
 
function highslide(){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	$style=($this->preview_display=='single')?$this->style_single:$this->style;
	$image_ratio=$this->width/$this->height;
	$viewport_width=process_data::get_viewport();
	if ($image_ratio > 1){
		$width=$this->maxexpand;
		$height=$width/$image_ratio;
		}
	else {
		$height=$this->maxexpand;
		$width=$height*$image_ratio;
		}
	$maxed_width=($viewport_width >200)?min($viewport_width,$width):$width;//precaution if < 200 may be inaccurate
	$maxed_height=$maxed_width/$image_ratio;
	$image_width=check_data::key_up($this->page_cache_arr,$maxed_width,'val',$this->page_width);
	$image_dir=Cfg::Response_dir_prefix.$image_width.'/';
	if (!is_file(Cfg_loc::Root_dir.Cfg::Large_image_dir.$image_dir.$this->picname)){
		$return=image::resize_check($this->picname,0,0,$image_width,Cfg_loc::Root_dir.Cfg::Upload_dir,Cfg_loc::Root_dir.Cfg::Large_image_dir.$image_dir,$this->blog_id);
		}			
	if (!$this->edit){  //width:'.($maxed_width*.95).',height:'.($maxed_height*.95).',  No effect
	 	echo '<div  class="inlineblock" '.$style.'> <!--highslide-wrap--><a href="'.Cfg_loc::Root_dir.Cfg::Large_image_dir.$image_dir. $this->picname .'"   
			class="highslide" onclick="return hs.expand(this, { slideshowGroup: \''.$this->gall_ref.'\' , wrapperClassName: \'gall_img_'.$this->blog_id.'\' ,  outlineType: null,allowSizeReduction : true})"><img  class="preview_border_'.$this->blog_id.'" style="width:'.$this->maxwidth_adjust_preview.'%" src="'.Cfg_loc::Root_dir.'small_images/'. $this->picname 
		  . '" alt="'. $this->alt. '" > </a>';
		 }
	else echo '<div  '.$this->style.'><!--highslide--><!--highslide-wrap--><img class="preview_border_'.$this->blog_id.' cursor" onclick="alert(\'Expanded Images not available in Highslide Edit Mode\');"  '.$this->style.' src="'.Cfg_loc::Root_dir.'small_images/'. $this->picname 
		  . '"  alt="'. $this->alt. '" >';
	$des_wid=max(strlen($this->imagetitle),strlen($this->subtitle),strlen($this->description));
	if ($des_wid > 5){  	 
		
		echo '<div class="highslide-caption highslide-caption_'.$this->blog_id.'" >';
		echo '<div class="highslide-caption-inner">';
		if (!empty($this->imagetitle )){
			 echo '<p class="imagetitle_'.$this->blog_id.'">'
			 . $this->imagetitle  
			 . '</p>';
			}
		echo'
		<p class="subtitle_'.$this->blog_id.'">' . $this->subtitle  . '</p>
		<p class="description_'.$this->blog_id.'">' . $this->description .'</p> 
		</div><!--highslide-caption-inner--> 
		</div><!--highslide-caption-->';
		}
	echo '
		</div><!--highslide-wrap-->';
		if($this->preview_display=='single')printer::pclear();
	}
	   
 
   
function expandgallery(){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);   
	$background='';
	$passview=(Sys::Viewdb&&Sys::Pass_class)?'viewdb&amp;':'';
	$passclass=(!Sys::Viewdb&&Sys::Pass_class&&!empty(Sys::Returnpass))?'returnpass='.Sys::Returnpass.'&amp;tbn='.$this->gall_table.'&amp;gall_ref='.$this->gall_ref.'&amp;':((Sys::Viewdb&&Sys::Pass_class)?'viewdb&amp;':'');
	$gotoexpand=(Sys::Pass_class&&!Sys::Viewdb)?Cfg::Expand_pass_page.'?'.$passclass:'expand-'.$this->gall_ref.'.php?'.$passview;//actual  filename
    //$single=($this->preview_display=='single')?'<div class="marginauto center" style="width:100%">':'';  
	//$singleclose=($this->preview_display=='single')?'</div>':'';
	$class='';
	$clone='&amp;clone_ref='.$this->clone;
	$fadeout_id='holder_'.$this->blog_id;//all holder at this point
	switch ($this->transition) {
	case  'ajax_fade' :
		$class=' class="prevD" ';
		$onclick='onclick="'.$background.'fadeTo.fadeTo_init(\''.$fadeout_id.'\','.$this->transition_time.',100,0,-2);setTimeout(function(){gen_Proc.Override=1;gen_Proc.use_ajax(\''.Sys::Self.'?'.$passclass.'gall_ref='.$this->gall_ref.'&amp;clone_ref='.$this->clone.'&amp;pic_order='.$this->pic_order.'&amp;transition=ajax_fade\',\'handle_image\',\'get\')},'.$this->transition_time.');  "';//tbn for classpass
		break;
	case 'none' :
		$onclick=''; 
		break;
	case 'fade' : 
		$class=' class="prevD" ';
		$onclick='onclick="fadeTo.fadeTo_init(\''.$fadeout_id.'\','.$this->transition_time.',100,0,-1.5);gen_Proc.delayGoTo(this,'.$this->transition_time.'); return false;"';
		break;
	case 'ajax' :
		$onclick='onclick="gen_Proc.Override=1;gen_Proc.use_ajax(\''.Sys::Self.'?'.$passclass.'maxexpand='.$this->maxexpand.'&amp;pwid='.$this->parent_wid.'&amp;gall_ref='.$this->gall_ref.'&amp;pic_order='.$this->pic_order.'&amp;gall_table='.$this->gall_table.'&amp;transition=ajax\',\'handle_image\',\'get\'); return false;"';
		break;
	default :
		$class=' class="prevD" ';
		$onclick='onclick="fadeTo.fadeTo_init(\''.$fadeout_id.'\','.$this->transition_time.',100,0,-1.5);gen_Proc.delayGoTo(this,'.$this->transition_time.'); return false;"';
		}
	
	echo '<div class="'.$this->class_single_multiple.'" '.$this->style.'><!--expandgall preview--><a '.$class.' href="'.Cfg_loc::Root_dir.$gotoexpand.'pic_order='.$this->pic_order.$clone.'" '.$onclick.'><img class="preview_border_'.$this->blog_id.'" style="width:'.$this->maxwidth_adjust_preview.'%"  src="'.Cfg_loc::Root_dir.'small_images/'. $this->picname 
	 . '" alt="'. $this->alt. '" ></a></div>';
	  
	}//end expandgallery
	   

function rows_caption(){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__); 
     if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__); 
	 list($width,$height)=process_data::get_size(Cfg_loc::Root_dir.Cfg::Master_thumb_dir. $this->picname); 
	$style=($this->preview_display=='single')?$this->style_single:$this->style; 
	$style_caption=(!empty($this->caption_width))?'style="width:'.$this->caption_width.'px;"':'';	
	echo '<div '.$style.' class="inlineblock"><!--wrap rows caption -->
	<div class="marginauto gall_img_'.$this->blog_id.'"  style="max-width:'.$this->smallpicplus.'px; "><a href="'.$this->galleryname.$this->ext.'?&amp#goto_'.$this->master_gall_ref.'">   
 <!--caption rows--><img class="maxwidth95" src="'.Cfg_loc::Root_dir.Cfg::Master_thumb_dir. $this->picname 
	 . '"  alt="'. $this->alt. '" > </a></div>
	 	<div   class="mainPicInfo_'.$this->blog_id.'" '.$style_caption.'>';//display table throws off center text
	  if (!empty($this->imagetitle )){
	 
		echo '<p class="imagetitle_'.$this->blog_id.'"><a href="'.$this->galleryname.$this->ext.'?&amp#goto_'.$this->master_gall_ref.'"> '//&#8220;
			. $this->imagetitle  
			. '</a></p>';//&#8221;
		 }
	   echo'
	   <p class="subtitle_'.$this->blog_id.'">' . $this->subtitle .'</p> 
	   <p class="description_'.$this->blog_id.'">' . $this->description .'</p></div>
	   </div><!--wrap rows caption -->';
	   }
	
	
function gallerycontent(){//displays double rows
	exit('gallery content not used');
    if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
    //galleryname  will carry tablename 
	echo ' <div class="content" '.$this->gallerycontent_style.'><!--Gallery content--><a href="'.'expand-'.$this->galleryname.'-1'.$this->ext.'">   
 <img  '.$this->style_widheight.' src="'.Cfg_loc::Root_dir.'small_images/'. $this->picname. '"  alt="'. $this->alt. '" > </a>
	 	<div '.$this->gallerycontent_style_text.'>';
	  if (!empty($this->imagetitle )){
	 
       echo '<p class="imagetitle">&#8220;'
		  . $this->imagetitle  
		  . '&#8221;</p>';
	   }
	   echo'
	   <p class="subtitle">' . $this->subtitle .'</p> 
	   <p class="description">' . $this->description .'</p></div></div>';
	   }
	   
 function display_single_row(){#imagine...
	 
	if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__); 
	 //list($width,$height)=process_data::get_size(Cfg_loc::Root_dir.Cfg::Master_thumb_dir. $this->picname);
	 
	$style_caption=(!empty($this->caption_width))?'style="vertical-align:'.$this->caption_vertical_align.';max-width:'.$this->caption_width.'px;"':'';	
	echo ' 
	<div class="'.$this->display_float.' gall_img_'.$this->blog_id.'"  style="padding-bottom:'.$this->gall_topbot_pad.'px;"><!--gall_img--><a style="vertical-align:'.$this->caption_vertical_align.'; max-width:'.$this->smallpicplus.'px; "href="'.$this->galleryname.$this->ext.'?&amp#goto_'.$this->master_gall_ref.'">   
 <!--display single row--><img  class="maxwidth95" src="'.Cfg_loc::Root_dir.Cfg::Master_thumb_dir. $this->picname 
	 . '"  alt="'. $this->alt. '" > </a>
	 	<div   class="mainPicInfo_'.$this->blog_id.' '.$this->display_float.'" '.$style_caption.'><!--display single mainPicInfo-->';
	  if (!empty($this->imagetitle )){
	 
		echo '<p class="imagetitle_'.$this->blog_id.'"><a href="'.$this->galleryname.$this->ext.'?&amp#goto_'.$this->master_gall_ref.'"> '//&#8220;
			. $this->imagetitle  
			. '</a></p>';//&#8221;
		 }
	   echo'
	   <p class="subtitle_'.$this->blog_id.'">' . $this->subtitle .'</p> 
	   <p class="description_'.$this->blog_id.'">' . $this->description .'</p></div><!--display single mainPicInfo--></div><!--gall_img-->';
	   printer::pclear();
	   }
	   #***********BEGIN CSS FUNCTIONS***********
  
  
 
#**********END CSS FUNCTIONS*************
}//end class contact_master
 ?>