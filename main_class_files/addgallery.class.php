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
# Script 10.3 - upload_image.php
#adding an new pic only:
#http://www.imaginetheland.com/editpagesimagine/addgallerypic.php?tbn=what_lies_beneath
#http://karmabarnes.com/editpagesvalarupy/addgallerypic.php?tbn=imagine_the_land
#adding a new gallery
#http://www.ekarasa.com/editpagesekara/addgallerypic.php?tbn=indexpage_thumbs&addtbn=1
#http://karmabarnes.com/editpagesvalarupy/addgallerypic.php?tbn=imagine_the_land&addgall=1


#when we create a new gallery:
#$q="CREATE TABLE $tablename$ext SELECT * FROM $mastertablename$ext";  #creating data adn expand highslide tables..
#process_data::create_table($tablename);# this creates gallery table!
#update $tablename$ext set outertitle='$outertitle
#copy data from another gallery: INSERT INTO $tablename SELECT * FROM $mastertablename
#file_generate::reorder_generate($tablename);//to generate editpages table reorder.php for new table
#file_generate::gall_generate($tablename);// this will create root directory gallery file
#update navigation:  update indexpage set nav3 ='$nav3'";
#INSERT NEW GALLERY INSERT INTO $tablename (pic_order, bigname, littlename, imagetitle,imagetype, description, subtitle, width, height,  temp_pic_order, reset_id) VALUES
# ('$mysqlinst->pic_ord', '$file', '$file', '$imtit','pic', NULL, '$subtitle','$width', '$height',  0, '$mysqlinst->pic_ord')";		
# INSERT MASTER GALLERY
/*$q="INSERT INTO $backuptablename (pic_order, bigname, littlename, imagetitle,imagetype, description, subtitle, width, height,galleryname, text, temp_pic_order, reset_id) VALUES
				   ('$mysqlinst->pic_ord', '$file', '$file', '$imagetitle','pic', NULL, '$subtitle','$width2', '$height2', '$tablename', '$imagetitle', 0, '$mysqlinst->pic_ord')";*/
class addgallery {

private static $instance=false; //store instance


function show_more($msg_open,$msg_close='close',$class='ramana left',$tag=''){ if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
 static  $show_more=1000; $show_more++; //echo 'show more is '.$this->show_more;
    echo '<p    class="'.$class.'" title="'.$tag.'" onclick="show(\'show'.$show_more.'\',\''.$msg_open.'\',\''.$msg_close.'\');" id="show'.$show_more.'" onmouseover="this.style.cursor=\'pointer\'" style="  text-decoration: underline;">'.$msg_open.'</p>	 
	<div  id="show'.$show_more.'t" style="display: none; ">  ';  
    }
	
	
function submitted(){  printer::print_request();
if (Sys::Web)set_time_limit(200);
ini_set('memory_limit','500M');
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


$table_list=check_data::return_galleries(__METHOD__,__LINE__,__FILE__) ;   
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
$addtbn=request::check_request_data('addtbn'); //for gallery_content master page
if (!$addtbn){
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
	}//!addtbn
//these have different purposes before and after submitting 
//$addgall=request::check_request_data('addgall');// for standalone new gallery page....
$backuptablename=$tablename;  
#three possiblilites:  the first is just add photo to gallery, then addtbn and addgall are false
 #addtbn is for a master slide show and will add both a record to the master gallery and create a new gallery slide show
#addtbn allows for using the images of a previous gallery accessed from dropdown menu and referred to as mastergallery
	#if (!$sess->session_check){mail::error('session check problem');}	
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
	if ($addtbn){ #if true will now have value from post either none or another tablename
		exit('add tbn being used!!!!!!!!!!!');
		 
		} //addtbn
	 
		
	#check submitted values...
	$max_upload = (int)(ini_get('upload_max_filesize'));
	$max_post = (int)(ini_get('post_max_size'));
	$memory_limit = (int)(ini_get('memory_limit'));
	$config=Cfg::Pic_max/1000000;//see Cfg.class.php 
	$upload_mb = min($max_upload, $max_post, $memory_limit,$config);
	$instructions="Maximum filesize of  $upload_mb  Mb has been exceeded.";
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

   // $this->tablename,$addtbn,$this->gall_expand,$mastergall  $pic_order_switch,$gallerycontentswitch

function render_form($tablename,$addtbn,$pic_order_switch=false,$gallerycontentswitch=false){   
	//print "$tablename,$addtbn,$pic_order_switch=false,$gallerycontentswitch=false"; return;
	$sess=session::instance(); 
	static $formcount=0; $formcount ++;  
	#if either has value of 1 then one is adding a table.. after submitting it merely would hold value of dropdown menu
	$msg=($addtbn)?'Create New Gallery':'You Are Adding A New Image to the Gallery: '.$tablename;
	printer::alert($msg,1.2); 
	$vars=(mail::Defined_vars)?get_defined_vars():'defined vars set off';
	$instructions=NL.'Only the filetypes '.Cfg::Valid_pic_ext.' will work'.NL.
	'Upload the largest file available, it will be rescaled automatically or choose width below';
		
	if  (Sys::Testsite){
		$max_file_size=Cfg::Pic_test_max;
		$max=$max_file_size/1000000;
		$instructions=NL."For this demonstration site the maximimum Picture file size is limited to $max Mb.".$instructions;
	    }
	else {
		$max_file_size=	Cfg::Pic_max;
		$max=$max_file_size/1000000;
		$instructions=NL."The maximimum Picture file size is limited to $max Mb.".$instructions;
		}
	
	echo ' 
	<div><fieldset class="fd2neg"><!--begin addgallery form--><form style="width: 600px; margin:0 auto; text-align:center" enctype="multipart/form-data" action="'. request::return_full_url().'" method="post" onsubmit="return Checkpicfiles(this,false);">';
	
	if ($addtbn)  {//old method not used currently
	    $msg='Give a new  Title to your new Gallery Collection which will appear as a new link under this gallery grouping, use capitals and spaces as needed:<br>';
	    $msg2='After naming the gallery/nav link, now also select your new gallery link image<br>this image will also be added to the slideshow as its first image:<br>';
	    #check if equals to one which means its original:  cause after submitting they will  have values from the dropedown table chose
		#this way the form is ready to add to the newly created gallery only
		echo'<p class="information" title="'.$msg.'">Input Your New Gallery Title:<input type="text" name="newtablename"  size="50" maxlength="50" ></p>';
		$msg=$msg2;
	    } 
	else $msg='';
	printer::alert($msg.$instructions,1.1);
	echo'<p><input type="hidden" name="MAX_FILE_SIZE" value="'.$max_file_size.'"></p>
	<fieldset><legend>File must be a .jpg .png  or .gif of '.($max_file_size/1000000).'MB or smaller to be uploaded:<br>Your upload will automaticlly be rescaled for the webpage or you can choose your setting</legend>
	<p><b>File:</b> <input style="background:#fff;color: #444;" type="file" name="upload" ></p>
	 </fieldset>';
	if ($addtbn==1){
		$table_list=check_data::return_galleries(__METHOD__,__LINE__,__FILE__) ;
		$count=count($table_list);
		if ($count>1){
			$msg3='Select a Gallery to Utilize it\'s Styles for you New Galleries initial Style, Change later as Needed:'; 
			arrayhandler::select_option($table_list,'inittbn', $msg3);
			}
		else if ($count==1)echo '<p><input type="hidden" name="inittbn" value="'.$table_list[0].'" >';
		else {//count==0
			$table_list=$return_pages("");
			 
			$count=count($table_list);
			if ($count>1){
				$msg3='Select a Page for its Best fit for initial styling of your New Gallery, Change Gallery Styling afterwards as Needed:';
				arrayhandler::select_option($table_list,'inittbn', $msg3);
				}
			else if ($count==1)echo '<p><input type="hidden" name="inittbn" value="'.$table_list[0].'" >';
			else mail::alert('no initial table for gallery setup in addgallerypiccore');
			}
		} 
	$this->show_more('Change Image Width or change Quality  Settings');
	echo' 
	<p class="ramana">Final width+height of large image: <input type="text" name="largepicplus" 
	value="'.Cfg::Large_gall_pic_plus.'" 
	size="3" maxlength="4" ></p><p class="ramana">Final width+height  of small Image: 
	<input type="text" name="smallpicplus" 
	value="'.Cfg::Small_gall_pic_plus.'" 
	size="3" maxlength="4" ></p><p class="ramana">Quality is on a scale from 0 to 100 with 100 being highest quality &amp; also slower loading<br> the default setting 90 should be fine</p>
	<p class="ramana">Change the final default thumbnail quality: <input type="text" name="thumb_quality" value = "'.Cfg::Pic_quality.'" size="3" maxlength="3" ></p>
	<p class="ramana">Change the final default full jpg quality: <input type="text" name="full_quality" value = "'.Cfg::Pic_quality.'" size="3" maxlength="3" ></p>
	 </div><!--end plusid-->
	 ';
	printer::pclear();
	echo'
	<fieldset>';
	$this->show_more('Add a Watermark');
	$dir=Cfg_loc::Root_dir.Cfg::Watermark_dir;
	
	printer::alertx('<p class="left information" title="
	Choose a Watermark Image to be programmatically blended to your Uploaded Image. Watermarks are a means to prevent images from being downloaded and used by others, by merging your image with a transparent  watermark  image.">
	Choose a watermark image from this dropdown menu</p>');
	echo '
	    <select name="watermarkinfo[0]">       
		<option value="none" selected="selected">Use No Watermark</option>';
		 if ($directory_handle = opendir($dir)) {
			while (($file = readdir($directory_handle)) !== false) {    
				if (($dir.$file  == '.') || ($dir.$file == '..'))continue; 
				if (strpos($dir.strtolower($file),'gif')===false && strpos($dir.strtolower($file),'.png')==false )continue; 
		  
			  echo '<option value="'.$dir.$file.'">'.$file.'</option>';
			  }
			}
			 	
	   echo ' </select>';
		printer::alertx('<p class="left information" title="
		After resizing to match widths your watermark image height may differ from your image to upload height so you may align the two according to their bottoms, centers, or tops">Choose Watermark Vertical Alignment with Image</p>');
	
	   echo '
	    <select name="watermarkinfo[1]">       
		<option value="center" selected="selected">Center to Center</option>
		<option value="top">Top to Top</option>
		<option value="bottom" >Bottom to Bottom</option> 
	    </select>';
	     
	$this->show_more('Requirements for Custom Watermark');		    
	echo '<p class="ramanaleft">Requirements: <br>
		The watermark image must be:<br>
		<span style="color:#'.Cfg::Pos_color.'">A transparency  gif or a png image<br><br>
		 png 8 bit and gif  watermark images will work with jpg, gif and png base images <br>
		Although png 24 watermarks will only  work with jpg  images it has the advantage<br><br>
		
		that the watermark itself (that part of it which is not background and completely transparent)  can be partially transparent<br>
		whereas those of png-8 and gif will be full opacity unless 100% transparent background><br>
		
		To work properly the watermark image must also be larger than your uploaded base image<br>
		Upload a 1000px or larger watermark image.<br><br>
		
		Note: the watermark will be scaled to width with your base image to keep the proper perspective.<br>
		 </span> <br></p></div>
		 
		<p class="information left" title="After Uploading Your Custom Watermark Image You Must Navigate back to Continue Your Normal Upload"> Upload Your Own Custom Watermark image
		<a href="add_page_pic.php?watermarkadd=1&amp;wwwexpand=0&amp;ttt='.$this->tablename.'&amp;fff=background&amp;postreturn='.Sys::Self.'&amp;pgtbn='.$this->tablename.'&amp;bbb=watermark&amp;css='.Cfg_loc::Root_dir.Cfg::Style_dir.$tablename.'"><b>HERE</b></a></p></div></fieldset>';
	 
	 
	echo '	 
	<p><input type="hidden" name="time" value="'. time() .'" ></p>
	<p><input type="hidden" name="token_store" value="'. $sess->sess_token .'" ></p>
	<p><input type="hidden" name="token" value="'. $sess->sess_token .'" ></p>
	<p><input type="hidden" name="addtbn" value="'. $addtbn .'" ></p>
	<p><input type="hidden" name="tbn" value="'.$tablename.'" ></p> 
	<p><input type="hidden" name="test" value="TRUE" ></p>
	<p><input type="submit" name="submit" value="Submit Upload Image" ></p>
	<p><input type="hidden" name="gallpicsubmitted" value="TRUE" ></p>
	<p><input type="hidden" name="gallerycontentswitch" value="'.$gallerycontentswitch.'" ></p>
	<p><input type="hidden" name="pic_order_switch" value="'.$pic_order_switch.'" ></p> 
	</form><!--end addgallform-->
	</fieldset><!--end addgallform-->
	</div><!--end addgallform--> 
	';
	 
	}//end render_form
	
public static function instance(){ //static allows it to create an instance without creating a new object
    if  (empty(self::$instance)) {
	   self::$instance = new addgallery(); 
	   } 
    return self::$instance; 
    }
}//end class
?>