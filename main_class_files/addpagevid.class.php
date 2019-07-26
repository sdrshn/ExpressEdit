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
class addpagevid extends Singleton { 
function submitted(){
	$mysqlinst=mysql::instance();
	$backupinst=backup::instance();
	$mysqlinst->dbconnect();	
	$id_ref=request::check_request_data('id_ref'); 
	$id=request::check_request_data('id'); 
	$width=request::check_request_num('width'); 
	$type=request::check_request_data('type');
	$f=request::check_request_data('fff');
	$masterpost=request::check_request_data('masterpost');
	if (!empty($f)){   
		$vidinfo=$f;
		}
	else {
          $msg='field info missing';
          mail::alert($msg);
          printer::alert_neg($msg);
          return;
          } 
	$t=$tablename=request::check_request_data('ttt');
	if (empty($t)){ 
			 $msg='table info missing';
			 mail::alert($msg);
			 printer::alert_neg($msg);
			 return;
                }
	$pt=request::check_request_data('pgtbn');
	if (!empty($pt)){   
			$pgtablename=$pt;  
			}
	else {
          $msg='pgtablename info missing';
          mail::alert($msg);
          printer::alert_neg($msg);
          return;
		}  
	// Check if the form has been submitted: 
	#if (!$sess->session_check){mail::error('session check problem');}
		
	if  (Sys::Debug) Sys::debug(__LINE__,__METHOD__,__FILE__);
		$max_upload = (ini_get('upload_max_filesize')<10000)?(int)(ini_get('upload_max_filesize')):(int)(ini_get('upload_max_filesize')/1000000);
		$max_post = (ini_get('post_max_size')<10000)?(int)(ini_get('post_max_size')):(int)(ini_get('post_max_size')/1000000); 
		$config=(int)Cfg::Vid_upload_max; 
		$maxup=min($max_upload,$max_post,$config); 
		$instructions="Maximum filesize of $maxup Mb has been exceeded.";
          $instructions.= ' Only the filetypes '.Cfg::Valid_vid_ext.' will work';
          list($uploadverification,$fiupl)=upload::upload_file(Cfg::Valid_vid_mime,Cfg::Valid_vid_ext,$instructions,Cfg_loc::Root_dir.Cfg::Upload_dir);
		if ($uploadverification='true'){ 
			if ($type==='background'){
				$vidpath=Cfg_loc::Root_dir.Cfg::Vid_background_dir;
				switch ($vidinfo){
					case 'page_style':
						$master_table=Cfg::Master_page_table;
						$prefix='page_';
						break; 
					case 'col_style':
						$master_table=Cfg::Columns_table;
						$prefix='col_';
						break; 
					default :
						$master_table=$masterpost;
						$prefix='blog_';
						break;
					}
				$q="select $vidinfo from $master_table where $id_ref='$id'";
				$r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);    
				list($styles)=$mysqlinst->fetch_row($r,__LINE__);
				$ele_arr=explode(',',$styles);  
				$styleindexes=explode(',',Cfg::Style_functions);
				foreach($styleindexes as $key =>$index){
					if (!empty($index)) ${$index.'_index'}=$key;
					}
				$count=count($styleindexes);
				for ($i=0; $i<$count; $i++){
					(!array_key_exists($i,$ele_arr))&&$ele_arr[$i]=0;
					}
				$background_array=explode('@@',$ele_arr[$background_index]); 
				$backindexes=explode(',',Cfg::Background_styles);
				foreach($backindexes as $key =>$index){
					if (!empty($index)) ${$index.'_index'}=$key;
					}
				$count=count($backindexes);
				for ($i=0; $i<$count; $i++){
					(!array_key_exists($i,$background_array))&&$background_array[$i]=0;
					}
				$background_array[$background_video_index]=$fiupl;
				$background_array[$background_video_display_index]='display';  
				$background_implode=implode('@@',$background_array); 
				$ele_arr[$background_index]=$background_implode;
				$style_implode=implode(',',$ele_arr);
				$q="UPDATE $master_table SET $vidinfo='$style_implode',{$prefix}time='".time()."',token='".mt_rand(1,mt_getrandmax())."',{$prefix}update='".date("dMY-H-i-s")."' where blog_table='$t' and blog_table_base='$pgtablename' and $id_ref='$id'";   
				} 
			else { 
				$vidpath=Cfg_loc::Root_dir.Cfg::Vid_dir;
				$q="UPDATE $masterpost SET $vidinfo='$fiupl',token='". mt_rand(1,mt_getrandmax())."',blog_time='".time()."' where blog_table='$t' and blog_table_base='$pgtablename' and $id_ref='$id'";  
                    }
			$mysqlinst->query($q,__LINE__,__FILE__,true);//  insert into database for each db
			if($mysqlinst->affected_rows()){
				if(!copy(Cfg_loc::Root_dir.Cfg::Upload_dir.$fiupl,$vidpath.$fiupl))mail::error('failure to copy background video in add page video core: '.$fiupl);#this places in folder video  no video resizing done straitforward deal 	  
				if  (Sys::Debug) print_r($message);
				#success has happened
				$backupinst->render_backup($pgtablename);
				$pageref=($pgtablename=='indexpage')?'Home Page':$pgtablename;
				$msg = "The Video $fiupl has successfully been sent to $pageref Please double check";
				mail::success($msg);
				$_SESSION[Cfg::Owner.'update_msg'][]=printer::alert_pos($msg,.9,1);
				}
			else {
				$msg="Error Updating with $q";
				mail::error($msg);
				printer::alert_neg($msg);
				}
			}// end of upload verification
		else {
               $msg="Upload Verification Failed";
               mail::error($msg);
               printer::alert_neg($msg);
               }
    } // End of function submitted
    
}//end class addpagevid
?>
   