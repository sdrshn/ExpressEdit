<?php
#ExpressEdit 2.0.2
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

class addpagepic extends Singleton{
function plus($msg){ if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	static $pluscount=0; $pluscount++; 
	echo '
	<p class="button clear">
	<input type="button" value="'.$msg.'" id="plusdata2'.$pluscount.'" onclick="plus(id,\''.$msg.'\');">
	</p>
	<div  id="plusdata2'.$pluscount.'t" style="display: none; ">'; 
	}
 
function submitted(){
	(!isset($_SESSION[Cfg::Owner.'update_msg']))&& $_SESSION[Cfg::Owner.'update_msg']=array();
	$sess=session::instance();
	$storeinst=store::instance(); 
	$backupinst=backup::instance();	
	$succmsg='';
	$succmsg2='';
	$background_dir='';
	$watermarkposition='center';
	$watermark_large_image=false;
	$watermark=NULL;
	$mysqlinst=mysql::instance();
	$mysqlinst->dbconnect();
	$expandfield=request::check_request_data('expandfield');//data field for image no expand or image_noresize
	$no_image_resize=request::check_request_data('no_image_resize');
	$blog_image_noexpand=request::check_request_data('blog_image_noexpand');
	$table_list=check_data::return_all(__METHOD__,__LINE__,__FILE__,false); 
	$id_ref=request::check_request_data('id_ref');
	$clone_local_style=request::check_request_data('clone_local_style'); 
	$clone_local_data=request::check_request_data('clone_local_data');
	$orig_id=request::check_request_data('orig_id'); 
	(empty($id_ref))&&$id_ref='id';
	$id=request::check_request_data('id');
	$append=request::check_request_data('append'); 
	(empty($id))&&$id=1; 
	$ttt=request::check_request_data('ttt');
	$vidbutton=request::check_request_data('vidbutton'); 
	$contact=request::check_request_data('contact');  
	$addvid=request::check_request_data('addvid');
	if (!empty($ttt))$tablename=$ttt; 
	else {
		$msg='add picture problem in addpage'; 
		mail::alert($msg);
		printer::alert_neg($msg);
		$_SESSION[Cfg::Owner.'update_msg'][]=NL.printer::alert_neg($msg,1.3,true);
		return;
		}
	$pgtbn=request::check_request_data('pgtbn'); 
	if (!empty($pgtbn)){  
		if (in_array($pgtbn, $table_list)){$pgtablename=$pgtbn; }
		else {
			$msg="problem with adding page and pgtablename";
			mail::alert($msg);
			printer::alert_neg($msg);
		$_SESSION[Cfg::Owner.'update_msg'][]=NL.printer::alert_neg($msg,1.3,true);
			return;
			}
		}//end if !empty
	 else {
		$msg='problem with page tablename';
		mail::alert($msg);
		printer::alert_neg($msg);
		$_SESSION[Cfg::Owner.'update_msg'][]=NL.printer::alert_neg($msg,1.3,true);
		return;
		}
	$playbuttonadd=request::check_request_data('playbuttonadd');
	$watermarkadd=request::check_request_data('watermarkadd');
	$bbb=request::check_request_data('bbb');//back_ground image in styling
	$fff=request::check_request_data('fff');
	$www=request::check_request_num('www');
	$width=round($www);
	if (empty($www)&&!$watermarkadd&&!$playbuttonadd){//watermark doesn't need width info will be sent fullsize
		$msg='width info missing';
		mail::alert($msg);
		$_SESSION[Cfg::Owner.'update_msg'][]=NL.printer::alert_neg($msg,1.3,true);
		printer::alert_neg($msg);
		return;
		}
	$wwwexpand=request::check_request_num('wwwexpand');
	$plusexpand= (!empty($wwwexpand)&&$blog_image_noexpand=='display')?round($wwwexpand):0;  	 
	if (!empty($fff)){
		$g=$fff.'-';//to account for background image instances
		$g=substr($fff,0,strpos($g,'-'));//will take first '-' ie to give background only for blogs?
		if (check_data::check_array($g,Cfg::Page_fields)||check_data::check_array($g,Cfg::Post_fields)||check_data::check_array($g,Cfg::Col_fields)){$dbfield=$fff; }
		else { $msg="!!!MISSING FIELD INFORMATION: TRY AGAIN!!!";   
				mail::alert($msg);
		$_SESSION[Cfg::Owner.'update_msg'][]=NL.printer::alert_neg($msg,1.3,true);
				printer::alert_neg($msg);
				return;
			}
		}
	else {
		$msg="MISSING field INFORMATION: TRY AGAIN!!!!";
			mail::alert($msg);
		$_SESSION[Cfg::Owner.'update_msg'][]=NL.printer::alert_neg($msg,1.3,true);
			printer::alert_neg($msg);
			return;
		}
	$fff=$dbfield;//also repassed in form fields
	//$bbb=$background;//also repassed in formfields
	// Check if the form has been submitted: 
     if  (isset($_POST['quality'])&& $_POST['quality'] > 9 && $_POST['quality'] < 101){
          $quality  = $_POST['quality'];
          }//end correct full quality number out of range
     else  {
          $quality=95;
          }
     $max_upload = (ini_get('upload_max_filesize')<10000)?(int)(ini_get('upload_max_filesize')):(int)(ini_get('upload_max_filesize')/1000000);
     $max_post = (ini_get('post_max_size')<10000)?(int)(ini_get('post_max_size')):(int)(ini_get('post_max_size')/1000000); 
     $config=(int)Cfg::Pic_upload_max; 
     $maxup=min($max_upload,$max_post,$config); 
     $instructions="Maximum filesize of  $maxup  Mb has been exceeded.";
     $instructions.= ' Only the filetypes '.Cfg::Valid_pic_ext.' will work';
     list ($uploadverification,$fiupl)=upload::upload_file(Cfg::Valid_pic_mime,Cfg::Valid_pic_ext,$instructions,Cfg_loc::Root_dir.Cfg::Upload_dir);
     if ($uploadverification='true'){  //upload verification is true if file uploaded in include uploadthis then do image and database
          if (isset($_POST['watermarkinfo'])){
               $watermark=($_POST['watermarkinfo'][0]==='none')?NULL:$_POST['watermarkinfo'][0];
               $watermarkposition=$_POST['watermarkinfo'][1];
               $watermark_large_image=(isset($_POST['watermark_large_image']))?true:false;
               if(!empty($watermark)&&!in_array($watermarkposition,array('center','bottom','top') )){
                    mail::alert('Problem with watermark');
                    $_SESSION[Cfg::Owner.'update_msg'][]=NL.printer::alert_neg('Problem with watermark',1.3,true);
                    }
               }
          $no_image_resize=(check_data::noexpand(Cfg_loc::Root_dir.Cfg::Upload_dir.$fiupl))?true:$no_image_resize;  
          list($fullwidth,$height)=process_data::get_size($fiupl,Cfg_loc::Root_dir.Cfg::Upload_dir);  
          if ($no_image_resize||!empty($watermarkadd)||!empty($playbuttonadd)){ //isset($_POST['fullwidth'])|| 
               $proceed=check_data::check_num(5,2500,$fullwidth,'WIDTH');  
               if ($proceed===true){
                    $width=$fullwidth;  
                    }
               else echo "please  the file did not meet size requirements at  $fullwidth".'px';
               } 
          $error_msg=($no_image_resize)?false:true;
          $pagedir=($bbb==='background_image_style')?Cfg::Background_image_dir:(($bbb=='auto_slide')?Cfg::Auto_slide_dir:(($addvid)?Cfg::Vid_image_dir:(($watermarkadd)?Cfg::Watermark_dir:(($playbuttonadd)?Cfg::Playbutton_dir:(($no_image_resize)?Cfg::Image_noresize_dir:Cfg::Page_images_dir)))));
          $pageexpanddir=(strpos($dbfield,Cfg::Blog_prefix)!==false)?Cfg::Page_images_expand_dir:'';	
          if(!empty($plusexpand)){ 
               $return=image::image_resize($fiupl, 0, '0',$plusexpand, Cfg_loc::Root_dir.Cfg::Upload_dir, Cfg_loc::Root_dir.$pageexpanddir, 'file', $watermark, $quality,$watermarkposition,$error_msg,true); 
               if (!is_array($return) && strlen($return) >10){
                    printer::alert_neg($return); 
                    return;
                    }
               }
          $watermark=($watermark_large_image)?'NULL':$watermark;//$watermark_large_image if true then set $watermark to NULL for regular size images 
          if (!empty($watermark)||!$no_image_resize){ 
                $return=image::image_resize($fiupl, $width, '0','0', Cfg_loc::Root_dir.Cfg::Upload_dir, Cfg_loc::Root_dir.$pagedir, 'file', $watermark, $quality,$watermarkposition,$error_msg);
               
               if (!is_array($return) && strlen($return) >10){
                    printer::alert_neg($return);
                    return;
                    }
               else 
                    list($width,$height,$file)=$return;
                }
          else {  
               $width=$fullwidth;
               $file=$fiupl;
               if(!copy(Cfg_loc::Root_dir.Cfg::Upload_dir.$file,Cfg_loc::Root_dir.$pagedir.$file)){
                    $msg="Problem copying  $file  to $pagedir.$file";
                    $_SESSION[Cfg::Owner.'update_msg'][]=printer::alert_neg($msg);
                    }
               }
          if ($bbb==='background_image_style'){
               //     blog_style-20-1-10//0 => background_color1 => background_image2 => background_image_use3 => background_repeat4 => background_horiz5 => background_vert6 => background_opacity
               $field_array=explode('-',$dbfield);     
               $tabletype=$field_array[1];
               $field=$field_array[0];
               $style_index=$field_array[2];  
               if ($clone_local_style&&$tabletype=='blog'){//blog_data3-blog-8-20
                    $table=Cfg::Master_post_css_table;
                    $prefix=Cfg::Blog_prefix;
                    $where=" where blog_table='$ttt' AND blog_order=".$field_array[3];
                    }
               elseif ($tabletype=='blog'){//posts
                    $table=Cfg::Master_post_table;
                    $prefix=Cfg::Blog_prefix;
                    $where=" where blog_table='$ttt' and blog_order=".$field_array[3];
                    }// note:  chech for array key 3 now obsolete
               elseif ($clone_local_style&&$tabletype=='column'){
                    $table=Cfg::Master_col_css_table;
                    $prefix=Cfg::Blog_prefix;
                    $where=" where col_table='$ttt'";
                    }
               elseif($tabletype=='column'){//column
                    $table=Cfg::Columns_table;
                    $where=" where col_table='$ttt'";
                     $prefix=Cfg::Col_prefix;
                    }
               else {//pages
                    $table=Cfg::Master_page_table;
                    $prefix=Cfg::Page_prefix;
                    $where=" where page_ref='$ttt'";
                    }
               $indexes=explode(',',Cfg::Style_functions );
               foreach($indexes as $key =>$index){
                    if (!empty($index)) {
                         ${$index.'_index'}=$key; 
                         }
                    }
               $q="select $field from $table $where limit 1";  
               $r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);    
               $row=$mysqlinst->fetch_assoc($r,__LINE__);
               $styled=$row[$field];
               $style_array=explode(',',$styled);
               $count=count($style_array);
               if ($count < $style_index){
                    for ($i=0; $i<$style_index+1; $i++){
                         (!array_key_exists($i,$style_array))&&$style_array[$i]=0;
                         }
                    }
               $background=$style_array[$style_index];
                
               $dbbackground_array=explode('@@',$background);
               $backindexes=explode(',',Cfg::Background_styles);
               foreach($backindexes as $key =>$index){   
                   ${$index.'_index'}=$key;
                   }
               $count=count($backindexes);
               for ($i=0; $i<$count; $i++){
                    (!array_key_exists($i,$dbbackground_array))&&$dbbackground_array[$i]=0;
                    }
               ($no_image_resize)&&$dbbackground_array[$background_image_noresize_index]=1;
               $dbbackground_array[$background_pos_width_index]='50';
               $dbbackground_array[$background_size_index]='hundred';
               $dbbackground_array[$background_pos_height_index]='50'; 
               $dbbackground_array[$background_image_index]=$file;  
               $dbbackground_array[$background_image_use_index]=1;
               $dbbackground_array[$background_repeat_index]='no-repeat';
               $style_array[$style_index]=implode('@@',$dbbackground_array);
               $style_implode=implode(',',$style_array);  
               $q="UPDATE $table SET $field='$style_implode',{$prefix}time='".time()."',token='".mt_rand(1,mt_getrandmax())."',{$prefix}update='".date("dMY-H-i-s")."'  $where";       
                }// bbb  
          else{//actually not all blog_table because of page slide show images!!!
               $master_table=($clone_local_data)?Cfg::Master_post_data_table:((strpos($dbfield,Cfg::Blog_prefix)!==false)?Cfg::Master_post_table:Cfg::Master_page_table); //master page table not taking any pic orders anymore
               $tablebase=(strpos($dbfield,Cfg::Blog_prefix)!==false)?'blog_table_base':'page_ref';
               $AND=($clone_local_data)?" AND blog_orig_val_id='$orig_id'":'';
               $table_ref=(strpos($dbfield,Cfg::Blog_prefix)!==false)?'blog_table':'page_ref';
               $time=(strpos($dbfield,Cfg::Blog_prefix)!==false)?'blog_time':'page_time';
               if ($blog_image_noexpand||$no_image_resize){//set blog option to true.. 
                    $optindexes=explode(',',Cfg::Image_options);
                    foreach($optindexes as $key =>$index){   
                         ${$index.'_index'}=$key;
                         }
                    $q="select $expandfield from $master_table where $table_ref='$ttt' AND  $tablebase='$pgtbn' AND $id_ref='$id'";
                    $r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);    
                    list($image_options)=$mysqlinst->fetch_row($r,__LINE__);
                    $option_array=explode(',',$image_options);
                    $count=count($optindexes);
                    for ($i=0; $i<$count; $i++){
                         (!array_key_exists($i,$option_array))&&$option_array[$i]=0;
                         }
                    ($blog_image_noexpand)&&$option_array[$image_noexpand_index]='no_display';
                    ($no_image_resize)&&$option_array[$image_noresize_index]='noresize';
                    $option_implode=implode(',',$option_array);  
                    $image_options="$expandfield='$option_implode',";  
                    }// if $blog_image_noexpand
               else $image_options='';
               if ($append=='prepend'||$append=='append'){
                    $q="select $dbfield from $master_table where $table_ref='$ttt' AND  $tablebase='$pgtbn' AND  $id_ref='$id'"; 
                    $r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);#this will add the query to each database in the array.
                    list($data)=$mysqlinst->fetch_row($r,__line__);
                    $file=(empty($data))?$file:(($append=='prepend')?$file.','.$data:$data.','.$file);
                    }
               $q="UPDATE $master_table SET $dbfield='$file',$image_options $time='".time()."'  where $table_ref='$ttt' AND  $tablebase='$pgtbn' AND $id_ref='$id' $AND";   
               } 
          $mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);#this will add the query to each database in the array.
          $msg='<img class="floatleft" src="'.Cfg_loc::Root_dir.$pagedir.$fiupl.'" alt="msg upload" height="50"><p class="editbackground pos small floatleft width500max">Your Image '.$fiupl.' has been successfully uploaded <BR> Please double check</p>';
          mail::success($msg);
          printer::alertx($msg,1.3);
          printer::pclear();
          $_SESSION[Cfg::Owner.'update_msg'][]=$msg;
          (!$watermarkadd&&!$playbuttonadd)&&$backupinst->render_backup($pgtablename);
          } //end uploadverification true.
     else {
          $msg="UPLOAD VERIFICATION FAILED IN FILE $fiupl<BR> ";
          mail::alert($msg);
          printer::alert_neg($msg);
          $_SESSION[Cfg::Owner.'update_msg'][]=NL.printer::alert_neg($msg,1.3,true);
          return;
          }
	} // End function submitted conditional.

}//end class
?>