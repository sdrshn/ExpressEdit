<?php
#ExpressEdit 2.0.3
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

    
class addgallery {
private static $instance=false; //store instance\

function show_more($msg_open,$msg_close='close',$class='ramana left',$tag=''){ if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
     static  $show_more=1000; $show_more++; //echo 'show more is '.$this->show_more;
      echo '<p    class="'.$class.'" title="'.$tag.'" onclick="show(\'show'.$show_more.'\',\''.$msg_open.'\',\''.$msg_close.'\');" id="show'.$show_more.'" onmouseover="this.style.cursor=\'pointer\'" style="  text-decoration: underline;">'.$msg_open.'</p>	 
	<div  id="show'.$show_more.'t" style="display: none; ">  ';  
     }
	
function submitted(){  
     $sess=session::instance(); 
     $backupinst=backup::instance();	
     $succmsg='';
     $succmsg2='';
     $mysqlinst=mysql::instance();
     $mysqlinst->dbconnect();
     $lp=request::check_request_num('largepicplus'); 
     $gall_ref=request::check_request_data('gall_ref');
     $addimage=request::check_request_data('addimage'); 
     $sp=request::check_request_num('smallpicplus');
     $smallpicplus=(!empty($sp)&&check_data::check_num(5,Cfg::Max_pic_width,$sp,'small plus WIDTH')===true)?round($sp):Cfg::Small_gall_pic_plus;  
     $thumb_quality=request::check_request_data('thumb_quality');
     $large_quality=request::check_request_data('large_quality');
     $inittbn=request::check_request_data('inittbn'); 
     $lp=request::check_request_num('largepicplus');
     $gallerycontentswitch=request::check_request_data('gallerycontentswitch');//switch out photo for master gallery
     $pic_order_switch=request::check_request_data('pic_order_switch');
     $gall_expand=request::check_request_data('gall_expand');
     $largepicplus=(!empty($lp)&&check_data::check_num(5,Cfg::Max_pic_width,$lp,'large plus WIDTH')===true)?round($lp):Cfg::Large_gall_pic_plus; 
     $sp=request::check_request_num('smallpicplus');
     $smallpicplus=(!empty($sp)&&check_data::check_num(5,Cfg::Max_pic_width,$sp,'small plus WIDTH')===true)?round($sp):Cfg::Small_gall_pic_plus; 
     $gcp=request::check_request_num('gallery_content_plus');
     $gallerycontentplus=(!empty($sp)&&check_data::check_num(5,Cfg::Max_pic_width,$gcp,'Gallery content plus WIDTH')===true)?round($gcp):Cfg::Master_gall_pic_plus;     
     $t=request::check_request_data('tbn');
           if (!empty($t)){  
               if (check_data::check_array($t,$table_list)){$tablename=$t; }#this checks to see if tbn is valid table
                    #tablename will come from original url and then retransmitted as hidden post
               else {
                    $this->pic_start=true;
                    //"adding pic/gallery as first gall/image to $t");
                     $tablename=$t;
                     }
               }//end if isset($_GET)	   
          else {$msg=' table in addgallery'; 
               mail::alert($msg);
               printer::alert_neg($msg);
               return;
               }
         
     //these have different purposes before and after submitting 
     $backuptablename=$tablename;  
     #three possiblilites:  the first is just add photo to gallery, then addtbn and addgall are false
     #addtbn is for a master slide show and will add both a record to the master gallery and create a new gallery slide show
     #addtbn allows for using the images of a previous gallery accessed from dropdown menu and referred to as mastergallery
	$newtablename=request::check_request_data('newtablename');#newtablename is for the creation of a new gallery
	if (!empty($newtablename)) {
		$newtablename=process_data::spam_scrubber($newtablename);
		$tablename=substr(str_replace(' ','_',strtolower(trim($newtablename))),0,20);
		$tablename = preg_replace('/[^a-zA-Z0-9_]/', '',$tablename);
		for ($i=1; $i<10; $i++){
			if(in_array($tablename,$table_list)) $tablename=substr($tablename,0,-2).'-'.$i;
			else continue;
			($i==9)&&exit('You have choosen this tablename nine times, try a different name this time!!');
			}
		#tablename will transmitted in hidden post and replaced if dropdown selected....
		$imagetitle=substr($newtablename,0,39); #get new imagetitle
		$outertitle=substr($newtablename,0,20);
		}
		#addtbn works similar to addgall except that the master gallery style will not be used if no dropdown table
		#is refered to... instead it will use the Cfg::Setup table ie. setupmaster who's style is updated with latest global styling....if globals selected...
	#check submitted values...
	$max_upload = (ini_get('upload_max_filesize')<10000)?(int)(ini_get('upload_max_filesize')):(int)(ini_get('upload_max_filesize')/1000000);
		$max_post = (ini_get('post_max_size')<10000)?(int)(ini_get('post_max_size')):(int)(ini_get('post_max_size')/1000000); 
		$config=(int)Cfg::Pic_upload_max;
		$maxup=min($max_upload,$max_post,$config); 
	$instructions="Maximum filesize of  $maxup  Mb has been exceeded.";
	$instructions.= 'Only Upload filetypes '.Cfg::Valid_pic_ext.' are currently validated';
	list ($uploadverification,$fiupl)=upload::upload_file(Cfg::Valid_pic_mime,Cfg::Valid_pic_ext,$instructions,Cfg_loc::Root_dir.Cfg::Upload_dir);
	if ($uploadverification){  
		$watermarkposition='center'; 
		$watermark=NULL;
		if (isset($_POST['watermarkinfo'])){ 
			$watermark=($_POST['watermarkinfo'][0]==='none')?NULL:$_POST['watermarkinfo'][0];
			$watermarkposition=$_POST['watermarkinfo'][1];
			(!in_array($watermarkposition,array('center','bottom','top') ))&&mail::alert('Problem with watermark');
			}	 			
		if ($addimage){
			list($width,$height,$file)=image::image_resize($fiupl,Cfg::Small_gall_pic_width, '0', $smallpicplus,Cfg_loc::Root_dir.Cfg::Upload_dir, Sys::Gall_pic_path, 'file', NULL, $thumb_quality);
			image::image_resize($fiupl,Cfg::Large_gall_pic_width, '0',$largepicplus,Cfg_loc::Root_dir.Cfg::Upload_dir, Sys::Gall_pic_path2, 'file',$watermark,$large_quality,$watermarkposition);
			$mysqlinst->count_field(Cfg::Master_gall_table,'pic_order','',false," Where gall_ref='$gall_ref'");//get pic order placement 
			$pic_order=$mysqlinst->pic_ord;//for backup
			 
			###########3
			$gall_fields=Cfg::Gallery_fields;
			$gall_field_arr=explode(',',$gall_fields);
			$value='';
		
			foreach ($gall_field_arr as $field) {
				if($field==='pic_order')$value.="'$pic_order',";#will be renumbered
				elseif($field==='imagetitle')$value.="'',";
				elseif($field==='subtitle')$value.="'',";
				elseif($field==='description')$value.="'',";
				elseif($field==='gall_ref')$value.="'$gall_ref',";
				elseif($field==='gall_table')$value.="'$tablename',";
				elseif($field==='picname')$value.="'$file',";
				elseif($field==='width')$value.="'$width',";
				elseif($field==='height')$value.="'$height',";
				else $value.="'0',";
				}
			$mysqlinst->count_field(Cfg::Master_gall_table,'pic_id','',false,'');
			$inc_id=$mysqlinst->field_inc;
			
			$q='insert into '.Cfg::Master_gall_table."  (pic_id,$gall_fields,gall_update,gall_time,token) values ($inc_id,$value '".date("dMY-H-i-s")."','".time()."','".mt_rand(1,mt_getrandmax())."')";  
			$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
			$msg='<img class="floatleft" src="'.Sys::Gall_pic_path.$fiupl.'" alt="msg upload" height="50"><p class="editbackground pos small floatleft width500max">Gallery Image '.$fiupl.' has been successfully uploaded <BR> Please double check</p>';
			mail::success($msg);
			printer::alertx($msg,1.3);
			printer::pclear();
			$_SESSION[Cfg::Owner.'update_msg'][]=$msg;
			
			##############
			
			}
			
		}// end of upload verification
     }  // End of the submitted conditional.
 
public static function instance(){ //static allows it to create an instance without creating a new object
    if  (empty(self::$instance)) {
	   self::$instance = new addgallery(); 
	   } 
    return self::$instance; 
    }
}//end class
?>