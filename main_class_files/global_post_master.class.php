<?php
#ExpressEdit 2.0.4
#see top of global edit master class for system overview comment dir..
/*
ExpressEdit is an integrated Theme Creation CMS
	Copyright (c) 2018 Brian Hayes expressedit.org 

  This program is free software: you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation, either version 3 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program. If not, see <https://www.gnu.org/licenses/>.*/
  
class global_post_master extends global_process_master{
#buildpic
function build_pic($data,$picdir='',$style_ref='blog_style',$styles_open=true,$blog_options=true){ 
   $img_opt_arr=explode(',',$this->blog_data2); 
	$img_opt='blog_data2'; 
	$index_arr=explode(',',Cfg::Image_options);
	foreach ($index_arr as $key => $index){
		${$index.'_index'}=$key;
		}
	for ($i=0; $i<count($index_arr); $i++){
		$img_opt_arr[$i]=(array_key_exists($i,$img_opt_arr))?$img_opt_arr[$i]:0;
     }
	$width_percent=($this->column_level>0)?$this->column_total_net_width_percent[$this->column_level]:100; 
	$this->edit_styles_open();
	(empty($picdir))&&$picdir=Cfg_loc::Root_dir.Cfg::Page_images_dir;
	list($picname,$alt)=process_data::process_pic($this->blog_data1);
   //Sys::Viewdb & Sys::Pass_class refers to viewing dbases to restore or importing a primary column from external db respectively images may not be currently present and also viewing expanded images when clicked is not important...
   if (!is_file(Cfg_loc::Root_dir.Cfg::Upload_dir.$picname)&&Sys::Pass_class){
     printer::print_notice('Not found Original Image: '.$picname,1.2); 
     $picname=Cfg::Pass_image;
     $bypass=true;
     }
   else $bypass=false;//bypass file generation.
	($this->edit)&&$maxplus=(!empty($img_opt_arr[$image_max_expand_index])&&$img_opt_arr[$image_max_expand_index]>50)?$img_opt_arr[$image_max_expand_index]:((is_numeric($this->page_options[$this->page_max_expand_image_index])&&$this->page_options[$this->page_max_expand_image_index]>50)?$this->page_options[$this->page_max_expand_image_index]:Cfg::Page_pic_expand_plus);
	if ($img_opt_arr[$image_noresize_index]==='noresize'){
		$image_noresize=true;
		}
	else if (check_data::noexpand(Cfg_loc::Root_dir.Cfg::Upload_dir.$picname)){ //make sure image is safe to resize
		$image_noresize=true;
		echo '<input type="hidden" name="'.$data.'_'.$img_opt.'['.$image_noresize_index.']"  value="noresize">';//auto set value to noresize when submitted...
		}
	else $image_noresize=false;
	$image_expand=(!$bypass&&$img_opt_arr[$image_noexpand_index]==='display')?'display':0;
   $wpercent=($img_opt_arr[$image_width_limit_index]>=5&&$img_opt_arr[$image_width_limit_index]<100)?$img_opt_arr[$image_width_limit_index]:(($this->blog_type==='image')?100:50); 
   $image_height_set=($img_opt_arr[$image_height_set_index]==='overridesetheight')?false:true;
	$imagestyle=($image_height_set)?'width:auto;':'width:100%; height:auto;';
   $overridestyle=($image_height_set)?'':'style="width:'.$wpercent.'%; height:auto;"';
	list($border_width,$border_height)=$this->border_calc($this->blog_data4);//img
	list($post_pad_width,$post_mar_width)=$this->pad_mar_calc($this->blog_style,$this->column_total_width[$this->column_level]); //around post
	$shadowcalc=$this->calc_border_shadow($this->blog_data4); 
	$maxwidth_adjust_shadow_calc=100-$shadowcalc/3;//300 ~ min image width in px conv to %
	list($pad_width,$mar_width)=$this->pad_mar_calc($this->blog_data4,$this->column_total_width[$this->column_level]); 
	//space for image itself
   $image_internal_query=(!empty($this->blog_tiny_data4)&&strpos($this->blog_tiny_data4,'?')!==false)?$this->blog_tiny_data4:''; 
	$image_min=(!empty($img_opt_arr[$image_min_index])&&$img_opt_arr[$image_min_index]>9&&$img_opt_arr[$image_min_index]<601)?$img_opt_arr[$image_min_index]:'none'; 
	$min_width_val=($image_min!=='none')?'min-width:'.$image_min.'px;':'';
	$width_min_mode=($this->blog_tiny_data1==='maintain_width')?'max-width:'.($this->current_net_width*$wpercent/100).'px':'width:'.$wpercent.'%;'.$min_width_val;
   $image_height_media=(is_numeric($img_opt_arr[$image_height_media_index])&&$img_opt_arr[$image_height_media_index]>=300&&$img_opt_arr[$image_height_media_index]<=3000)?$img_opt_arr[$image_height_media_index]:0;
   /*(!empty($image_height_media))&&
     $this->imagecss.='
   @media screen and (max-width:'.$image_height_media.'px){ 
     div .'.$this->dataCss.'_img {width:100%;height:auto;}  
     div .'.$this->dataCss.' {max-height:auto; height:auto;} 
     }';*/
  ($this->edit)&&  
		$this->blog_options($data,$this->blog_table);
	printer::pclear();
   if ($this->edit){
     $this->imagecss.='
     .'.$this->dataCss.'_img {'.$imagestyle.'}';
		print('<p id="return_'.$this->blog_id.'">&nbsp;</p>');
     $bp_arr=$this->page_break_arr;
		$maxwidth=0;//intitialize width of maximumun maintain width in maintain_width mode
		if ($this->column_use_grid_array[$this->column_level]==='use_grid'){ 
			$max_pic_size=$this->grid_width_chosen_arr['max'.$bp_arr[0]]*$wpercent/100; 
			foreach($this->page_break_arr as $bp){
				$max_pic_size=max($max_pic_size,$this->grid_width_chosen_arr[$bp]*$wpercent/100);
				if($this->blog_tiny_data1==='maintain_width'){
					$maxwidth=$this->grid_width_chosen_arr['max'.$bp_arr[0]]*$wpercent/100;
					}
				}
			}//end if rwd enabled
		else{//rwd not enabled 
			$max_pic_size=$this->current_net_width*$wpercent/100; 
			$maxwidth=$max_pic_size;
			//$min_pic_size 
			}
		$best_guess=($max_pic_size>1000)?800:(($max_pic_size>500)?500:$max_pic_size);//javascript will size if larger 
		$fwidth=$max_pic_size; 
		$type=($this->column_use_grid_array[$this->column_level]==='use_grid')?'rwd':'no_rwd';
		//grid post percent arr  used to determine the percentage width available when grid system is used for each break break point
		//.. from this relevant pic width is calculated..
		$grid_post_percent_arr=($this->column_use_grid_array[$this->column_level]==='use_grid')?$this->grid_width_chosen_arr:'';//array becomes size of pic plugging in viewport 
		$maxfullwidth=check_data::key_up($this->page_cache_arr,$this->current_net_width*$wpercent/100*1.5,'val',$this->max_width_limit);//current net width should check out as the maximum width permissible under all circumstances not accounting for width_limiting... for this post.. now. if clones are locally resized larger there could be a problem with them finding their new width
     file_put_contents(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'build_pic_'.$this->passclass_ext.$data,$best_guess.'@@'. $type.'@@'.serialize($grid_post_percent_arr).'@@'.$maxfullwidth);
		$quality=(!empty($img_opt_arr[$image_quality_index])&&$img_opt_arr[$image_quality_index]>9&&$img_opt_arr[$image_quality_index]<101)?$img_opt_arr[$image_quality_index]:((!empty($this->page_options[$this->page_image_quality_index])&&$this->page_options[$this->page_image_quality_index]<101&&$this->page_options[$this->page_image_quality_index]>9)?$this->page_options[$this->page_image_quality_index]:Cfg::Pic_quality);
     //check if expand image exists for when image is clicked to view larger image..
		if (!$image_noresize&&$image_expand){
			if (is_file(Cfg_loc::Root_dir.Cfg::Page_images_expand_dir.$picname)){
				list($exp_width,$exp_height)=$this->get_size($picname,Cfg_loc::Root_dir.Cfg::Page_images_expand_dir);
				$expandplus=max($exp_width,$exp_height);
				}
			if(!$image_noresize&&!is_file(Cfg_loc::Root_dir.Cfg::Page_images_expand_dir.$picname)||$expandplus > $maxplus*1.03 || $expandplus < $maxplus * .97||isset($_POST[$data.'_'.$img_opt][$image_quality_index])){
				image::image_resize($picname,0,0,$maxplus,Cfg_loc::Root_dir.Cfg::Upload_dir,Cfg_loc::Root_dir.Cfg::Page_images_expand_dir,'file',NULL,$quality,'center', true,true);//expand =true
				}//resize 
			$this->page_images_expand_arr=array('id'=>$this->blog_id,'data'=>$this->data,'picname'=>$picname,'is_clone'=>$this->is_clone,'clone_local_style'=>$this->clone_local_style,'clone_local_data'=>$this->clone_local_data,'maxwidth'=>$maxplus,'quality'=>$quality,'quality_option'=>$img_opt_arr[$image_quality_index]); 
			}//display
		if (!$image_noresize&&!$bypass){
        $maxfullwidth=(!Cfg::Conserve_image_cachespace||(!$this->flex_grow_enabled&&!$this->flex_box_item))?$this->max_width_limit:$maxfullwidth;//ok here we either generate full cache or limit cache under three conditionals:  Cfg::Conserve_image_cachespace is not set to true or not flex_grow_enabled in the parent column tree opening up a column and not flex_box_item  (assumes flex grow enabled in one or more @media).. flex_grow_enabled makes for bigger than expected image spaces under certain conditions.
			$dir=Cfg_loc::Root_dir.Cfg::Page_images_dir.Cfg::Response_dir_prefix;
			$parr=array();
			$total=$x=0;
			$page_arr=check_data::return_pages(__METHOD__,__LINE__,__FILE__);
        if (is_file(Cfg_loc::Root_dir.Cfg::Upload_dir.$picname)){
          foreach($this->page_cache_arr as $ext){
             $flag=false;
             (!is_dir($dir.$ext))&&mkdir($dir.$ext,0755,1);
             if ($ext <=$maxfullwidth){
               if (!is_file($dir.$ext.'/'.$picname)||isset($_POST[$data.'_'.$img_opt][$image_quality_index])){
                  (Cfg::Development)&&printer::alertx('<p class="tiny white redAlertbackground">Creating: '.$dir.$ext.'/'.$picname.'</p>');
                  image::image_resize($picname,$ext,0,0,Cfg_loc::Root_dir.Cfg::Upload_dir, $dir.$ext,'file',NULL,$quality);
                  }
               else {
                  $x++;
                  $size=process_data::get_size($picname,$dir.$ext.'/');
                  $fsize=filesize($dir.$ext.'/'.$picname);
                  $area=$size[0]*$size[1];
                  $ratio=$size[0]/$size[1];
                  $density=round($fsize/$area,3);
                  $parr[]=array('dir'=>Cfg::Response_dir_prefix.$ext,'wid'=>$size[0],'height'=>$size[1],'area'=>$area,'Kb'=>round($fsize/1000,1),'density'=>$density);
                  $total+=$density;
                  }
               }//if less than maxfullwidth
             elseif (Cfg::Conserve_image_cachespace&&is_file($dir.$ext.'/'.$picname)&&!Sys::Pass_class){//size cache of this image is unnecessary as maxwidth is less
               //note here we are checking all cached images of this blog_id as clones could conceivably have a larger maxwidth
               $continue=false;
               foreach($page_arr as $page_ref){ 
                  $file='image_info_page_images_'.$page_ref;
                  if ($continue)continue;
                  if (is_file(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Image_info_dir.$file)){
                    $flag=true;
                    $array=unserialize(file_get_contents(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Image_info_dir.$file));//actually checking data in cloned versions as well..
                    foreach ($array as $index => $arr){
                       if (!array_key_exists('maxwidth',$arr))continue;
                       if (!array_key_exists('id',$arr))continue;
                       if ($arr['id']===$this->blog_id){
                         if ($arr['maxwidth']>=$ext){
                            $flag=false;
                            }
                         }
                       }//foreach
                    if ($flag){
                       if (is_file($dir.$ext.'/'.$picname)){//double check
                         unlink($dir.$ext.'/'.$picname); //save disk space
                         (Cfg::Development)&&mail::info($dir.$ext.'/'.$picname. ' was unlinked');
                         $continue=true;
                         }//double check
                       }
                    }// is_file 
                  }//end foreach
               }//is file
             }//foreach ext...
          if ($x>0){	
             $this->show_more('Image Quality Info');
             printer::print_wrap('Image Quality Info');
             printer::horiz_print($parr);
             $avgdensity=round($total/$x,3); 
             $filesize=filesize(Cfg_loc::Root_dir.Cfg::Upload_dir.$picname)/1000;
             $size=process_data::get_size($picname,Cfg_loc::Root_dir.Cfg::Upload_dir);
             $width=$size[0];
             $height=$size[1];
             $ratio=$size[0]/$size[1];
             $density=round($filesize*1000/($size[0]*$size[1]),3);
             $filesize=round($filesize,1);
             $msg="<span class=\"navy whitebackground\">$picname </span><br>avg. pixel/area density: $avgdensity<br>
             @ Quality: $quality <br>
             Uploaded Master Img in uploads/:<br>
             filesize: $filesize Kb<br>
             width: {$width}px<br>
             height: {$height}px <br>
             density: $density ";
             printer::print_info($msg);
             printer::close_print_wrap('Image Quality Info');
             $this->show_close('Image Quality Info');
             #Ok now we are going to include this file along with its current Quality into the Cfg::Page_images_dir array for use in updating caches and possibly deleting unused images!
             $this->page_images_arr[]=array('id'=>$this->blog_id,'data'=>$this->data,'picname'=>$picname,'is_clone'=>$this->is_clone,'clone_local_style'=>$this->clone_local_style,'clone_local_data'=>$this->clone_local_data,'maxwidth'=>$maxfullwidth,'quality'=>$quality,'quality_option'=>$img_opt_arr[$image_quality_index]); ;//This feature Is left in place to operate but not relevant when Cfg::Conserve_image_cachespace is set to false..this will be compiled in destructor as the current record for this page max size for this image. Page images arr was relevant when saving disk space by checking maximium image size for each particular image name allowed over all pages (accounting for cloned images may have larger or smaller upper size limit) and minimizing range of cached images. 
             }//x > 0
          }//uploads file exists
        else {
          $msg="Missing Image in Post: $picname";
          printer::alert_neg($msg);
          mail::alert($msg);
          }
        
			}//! $image_noresize
		}//if this edit
   
	$pic_info_arr=explode('@@',file_get_contents(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'build_pic_'.$this->passclass_ext.$data));
	list($best_guess,$type,$current_grid_chosen_arr,$maxwidth)=$pic_info_arr; 
	$current_grid_chosen_arr=(!empty($current_grid_chosen_arr))?unserialize($current_grid_chosen_arr):'';////array becomes size of pic plugging in viewport
	$best_guess=check_data::key_up($this->page_cache_arr,$best_guess,'val',$this->max_width_limit); //page width provided as ultimate limiter if misconfiged
	if (!empty($this->viewport_current_width)&&$this->viewport_current_width>200){
		 if ($type==='rwd'){ 
			list($key,$width_value)=check_data::key_up($current_grid_chosen_arr,$this->viewport_current_width,'keyval');
			#width#$current_grid_chosen_arr,'keyval',$this->page_width) directly gives the width available of the image a any given breakpoint just beyond the current viewport width...  .
		$image_width=min($this->viewport_current_width,$width_value,$maxwidth);
			}
		else {//non rwd
			$image_width=min($this->current_net_width,$this->viewport_current_width,$maxwidth);
			} 
		}//viewpoint 
	else {
		 $image_width=$best_guess; //do not repspond to no resize images
		}
   $image_caption_hover=($img_opt_arr[$image_caption_hover_index]==='nohover')?'nohover':(($img_opt_arr[$image_caption_hover_index]==='hover')?'hover':'below'); 
   $image_caption_text=(empty($this->blog_tiny_data3))?'':$this->blog_tiny_data3; 
	$imagecaption_height=300;//this value may not be necessary (is_numeric($img_opt_arr[$imagecaption_height_index])&&$img_opt_arr[$imagecaption_height_index]>=30&&$img_opt_arr[$imagecaption_height_index]<=125)?$img_opt_arr[$imagecaption_height_index]:75;
   $imagecaption_bottom=(is_numeric($img_opt_arr[$imagecaption_bottom_index])&&$img_opt_arr[$imagecaption_bottom_index]>=-100&&$img_opt_arr[$imagecaption_bottom_index]<=100)?$img_opt_arr[$imagecaption_bottom_index]:0; 
   $image_internal_link=(strlen($this->blog_tiny_data6)>6)?$this->blog_tiny_data6:'none'; 
    $image_external_link=(strlen($this->blog_tiny_data5)>8&&strpos($this->blog_tiny_data5,'http')!==false)?$this->blog_tiny_data5:'none'; 
	$image_width=check_data::key_up($this->page_cache_arr,$image_width,'val',$this->max_width_limit);
	$respond_data=' data-max-wid="'.$maxwidth.'" data-wid="'.$image_width.'" '; //here we are getting the responsive directory size of image cache... going up in size ...
	$image_width_dir=Cfg::Response_dir_prefix.$image_width.'/';
	$fullpicdir=($image_noresize)?Cfg_loc::Root_dir.Cfg::Image_noresize_dir:Cfg_loc::Root_dir.Cfg::Page_images_dir.$image_width_dir;
   if ($bypass || $picname==='default.jpg'){
		$fullpicdir=Cfg_loc::Root_dir; 
		} 
   elseif (!$image_noresize&&!is_file($fullpicdir.$picname)&&is_file(Cfg_loc::Root_dir.Cfg::Upload_dir.$picname)){#create image even if not in edit mode
		$quality=(!empty($img_opt_arr[$image_quality_index])&&$img_opt_arr[$image_quality_index]>9&&$img_opt_arr[$image_quality_index]<101)?$img_opt_arr[$image_quality_index]:((!empty($this->page_options[$this->page_image_quality_index])&&$this->page_options[$this->page_image_quality_index]<101&&$this->page_options[$this->page_image_quality_index]>9)?$this->page_options[$this->page_image_quality_index]:Cfg::Pic_quality);
		image::image_resize($picname,$image_width,0,0,Cfg_loc::Root_dir.Cfg::Upload_dir, $fullpicdir,'file',NULL,$quality);
		(Cfg::Development)&&mail::alert("creating image resize for $picname edit mode is $this->edit");
		}
	elseif (!is_file($fullpicdir.$picname)&&is_file(Cfg_loc::Root_dir.Cfg::Upload_dir.$picname)){
		copy(Cfg_loc::Root_dir.Cfg::Upload_dir.$picname,$fullpicdir.$picname);
		}
	else if(empty($picname)||!is_file(Cfg_loc::Root_dir.Cfg::Upload_dir.$picname)){
     if (is_file(Cfg_loc::Root_dir.Cfg::Large_image_dir.$picname)){
     copy(Cfg_loc::Root_dir.Cfg::Large_image_dir.$picname,Cfg_loc::Root_dir.Cfg::Upload_dir.$picname);
     }
     else {   
        $msg='Missing main master Image File uploads/'.$picname;
        mail::alert($msg.' on line'.__LINE__,__METHOD__);
        printer::alert_neg($msg);
        ($this->edit)&&printer::alert_neg('Your Previous Image Does not Exist. Upload a New Image &nbsp;<a href="add_page_pic.php?orig_id='.$this->orig_val['blog_id'].'&amp;clone_local_data='.$this->clone_local_data.'&amp;blog_image_noexpand='.$image_expand.'&amp;wwwexpand='.$maxplus.'&amp;image_noresize='.$image_noresize.'&amp;expandfield=blog_tiny_data2&amp;prevpic=0&amp;www='.$maxwidth.'&amp;ttt='.$this->blog_table.'&amp;fff=blog_data1&amp;quality='.$quality.'&amp;id='. $this->blog_id.'&amp;id_ref=blog_id&amp;pgtbn='.$this->pagename.'&amp;postreturn='.Sys::Self.'&amp;css='.$this->roots.Cfg::Style_dir.$this->pagename. '&amp;sess_override&amp;sess_token='.$this->sess->sess_token.'"><u>Here</u></a>');
        printer::pclear(5);
        return;
        }
		}//picname not exists
	switch ($this->blog_type){
		case 'image':
			$fstyle='margincenter';
			break;
		case 'float_image_left' :
			$fstyle='floatleft';
			break;
		case 'float_image_right' :
			$fstyle='floatright';
			break;
		default: $fstyle='margincenter';
			}
			
	if ($image_caption_hover==='hover'){
     echo <<<eol
   <script>
   \$(function(){
     if (window.TOUCHSTART){ 
        \$('.$this->dataCss a.image_caption p.caption-text').css({'bottom': 0});
        }
     });
   </script>
eol;
   }     
	##&&&& Css tweak
	if ($this->edit){ 
     /*if ($image_height_set){
       $this->imagecss.='
			 #'.$this->dataCss.' div.imagewrap img {min-width:0px;}
			';
        }
     else {//use width set*/
        #set minimum width for image in image text
         $this->imagecss.='
           .'.$this->dataCss.' div.imagewrap {'.$width_min_mode.'}
          '; 
        if ($this->blog_tiny_data1==='maintain_width'&&$this->column_use_grid_array[$this->column_level]==='use_grid'){
          $bp_arr=$this->page_break_arr;
          $this->imagecss.='
           .'.$this->dataCss.'_img {width:'.($this->grid_width_chosen_arr['max'.$bp_arr[0]]*$wpercent/100-$shadowcalc).'px;max-width:'.$maxwidth_adjust_shadow_calc.'%;
           }
          '; 
           #tweaking small text width next to image to disappear..set a width max under which the image takes full space before the text gets too narrow and odd looking!
           $post_pad_width=$post_pad_width/100*$this->grid_width_chosen_arr['max'.$bp_arr[0]];//convert to px from %
           $maxdisplay_maintain=$this->grid_width_chosen_arr['max'.$bp_arr[0]]*$wpercent/100+$post_pad_width+150;//ie the padding width diminishes the text width increases the width necessary to transition
           /* .'.$this->dataCss.' a.image_caption:hover, .'.$this->dataCss.' a.image_caption:active {
   -webkit-tap-highlight-color: rgba(0,0,0,0);
   -webkit-user-select: none !important;
   -webkit-touch-callout: none !important;
   }*/
          $this->imagecss.='
          @media screen and (max-width: '.$maxdisplay_maintain.'px){';
          
          $this->imagecss.='
           .'.$this->dataCss.' div.imagewrap { float:none; text-align:center; padding-left:0; padding-right:0;
           } 
           .'.$this->dataCss.'_img { text-align:center;
           }
          ';
          $this->imagecss.='}
          ';
           }
        else {
          $this->imagecss.='
          .'.$this->dataCss.'_img {width:'.$maxwidth_adjust_shadow_calc.'% 
             }
             ';
          }//grid array
        //}//if not image_height set..
     if (!empty($image_caption_text&&($image_caption_hover==='nohover'||$image_caption_hover==='hover'))){ 
        static $imagcss=0; $imagcss++;
        if ($imagcss < 2){
        $this->imagecss.='
   a.image_caption {
   display:block;
   position: relative;
   overflow: hidden;
   } 
   .image_caption p.caption-text {
   width: 100%;
   position: absolute;
   left: 0; 
   transition: 1s; 
     } ';
      
        }
        if ($image_caption_hover==='hover'){
          $this->imagecss.='
          
   .'.$this->dataCss.' a.image_caption:hover p.caption-text {
    bottom: 0;
     }
   .'.$this->dataCss.' a.image_caption:active p {
    bottom: 0;
     }
   .'.$this->dataCss.' a.image_caption p.caption-text {
     bottom: -'.$imagecaption_height.'px;
     }
     ';
          }
        else {
          $this->imagecss.='
   .'.$this->dataCss.' a.image_caption p.caption-text {
     bottom: '.$imagecaption_bottom.'px;;
     }';
          } 
			}
     else {
        $this->imagecss.='
     .'.$this->dataCss.' a.image_caption p.caption-text {
     display:inline-block;
     }
     ';
        }
		}//if edit css 
	##&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
	//width="100%" height="'.$hpercent.'%"
	$imagerespond=(!$image_noresize)?'imagerespond':'';
   $nolink=false;
   if (strlen($image_internal_link) > 6)
     $imagealink='href="'.$image_internal_link.'?gallreturnurl='.Sys::Self.'@@@'.$this->dataCss.str_replace('?','&',$image_internal_query).'"';
   elseif (strlen($image_external_link) > 6)
     $imagealink='href="'.$image_external_link.'"';
   elseif (is_file(Cfg_loc::Root_dir.Cfg::Page_images_expand_dir. $picname)&&$img_opt_arr[$image_noexpand_index]==='display'){
     $size=process_data::get_size(Cfg::Page_images_expand_dir. $picname);
     $imagealink='href="#" onclick="gen_Proc.imageexpand(\''.Cfg_loc::Root_dir.Cfg::Page_images_expand_dir. $picname .'\','.$size[0].','.$size[1].');return false;"';
     }
   else {#imagewebpage #image webpage mode
     $imagealink='href="#" style="cursor:default;text-decoration:none;"';
     $nolink=true;
     }
   if(!$this->edit||($this->is_clone&&!$this->clone_local_data)){ 
     printer::printx('<div class="'.$imagerespond.' imagewrap '.$fstyle. '"'.$respond_data.'><a class="image_caption" '.$imagealink.'> <img '.$overridestyle.' class="'.$this->dataCss.'_img '.$this->blog_type.'_img" src="'.$fullpicdir. $picname.'"  alt="'.$alt.'" ><p class="caption-text">'.$image_caption_text.'</p></a></div>');
     ($this->blog_type!=='image')&&
     $this->blog_text_float_box($data);//!edit			 
		}
	if (!$this->edit||($this->is_clone&&!$this->clone_local_data&&!$this->clone_local_style))return;
   if ($nolink) 
        $this->imagecss.='
        #'.$this->dataCss.'a.image_caption:hover,#'.$this->dataCss.' a:hover {color:inherit;}
        ';
	printer::pspace(5); 
	printer::pclear(5); 
   $prefix=($this->clone_local_data)?'p':'';
	$minwid= ($this->current_net_width >100)?$this->current_net_width:100;//
	$size=process_data::input_size($minwid,16,40);// Not that font size is css hard coded to 16px in edit_build_pic...
	if (!$this->is_clone||$this->clone_local_data){ 	
		printer::alert('Click the photo to upload a new one','',' left floatleft fsminfo editbackground editfont infoback rad5 info maroonshadow');
		printer::pclear();
		printer::alertx('<div class="'.$imagerespond.' imagewrap '.$fstyle. '"'.$respond_data.'><a class="image_caption" href="add_page_pic.php?orig_id='.$this->orig_val['blog_id'].'&amp;clone_local_data='.$this->clone_local_data.'&amp;blog_image_noexpand='.$image_expand.'&amp;wwwexpand='.$maxplus.'&amp;expandfield=blog_tiny_data2&amp;www='.$fwidth.'&amp;ttt='.$this->blog_table.'&amp;fff=blog_data1&amp;id='.$prefix.$this->blog_id.'&amp;id_ref=blog_id&amp;pgtbn='.$this->pagename.'&amp;postreturn='.Sys::Self.'&amp;css='.$this->roots.Cfg::Style_dir.$this->pagename.'&amp;quality='.$quality.'&amp;sess_override&amp;sess_token='.$this->sess->sess_token.'"><img class="'.$this->dataCss.'_img '.$this->blog_type.'_img" src="'.$fullpicdir. $picname.'"  alt="'.$alt.'" ><p class="caption-text">'.$image_caption_text.'</p></a></div>');
		}
	if($this->blog_type!=='image'){//&&!$this->is_clone
		$this->blog_text_float_box($data);
		printer::pclear(5); 
		printer::pclear(5);
		}
   
   
   if (!$this->is_clone||$this->clone_local_style)$this->show_more('Styling &amp; Image Configs');
   if (!$this->is_clone||$this->clone_local_style)printer::print_wrap('image configs');
   if (!$this->is_clone||$this->clone_local_style)$this->submit_button();
   if (!$this->is_clone||$this->clone_local_data){   
     $this->show_more('Change Image Filename/Alt image title');
     $this->print_redwrap('image name'); 
     printer::print_tip('Change Image to a Previously uploaded Image<input type="text" name="'.$data.'_blog_data1[0]" size="75" value="'.$picname.'">');  
     printer::printx('<div class=" maroonshadow floatleft left fsmcherry editbackground editfont fsmblack rad5 infoback editfont"> The alt title is an accessibility tool and has Search Engine (ie. duckduckgo, google) value to better search-rank your site so you can choose a title which reflects a couple search terms that describe this page and/or image<p class="editcolor editbackground editfont">Optional Alt title for Image:<br><textarea name="'.$data.'_blog_data1[1]" cols="50" rows="3" onkeyup="gen_Proc.autoGrowFieldScroll(this)">'.$alt.'</textarea></p></div>');
     printer::pclear();
     printer::close_print_wrap('Change Image Filename');
     $this->show_close('Change Image Filename');
     }
   $msg=(!$this->is_clone)?'Add/Style Image Caption/Link':(($this->clone_local_style)?'Style Image Caption/Link':'Add Image Caption/Link');
     $this->show_more($msg,'','','',500,'','float:left',true);
		$this->print_redwrap('Image Caption/Link');
     if (!$this->is_clone||$this->clone_local_style){
        $imagecaptiontitle='.'.$this->dataCss.' .image_caption p.caption-text';printer::print_info('Style captions in Image with choices below for background color with opacity change and top and bottom padding. You can also tweak the height setting for hover captions if needed!');
        printer::print_tip('Choose Hover to display caption only when image is hovered over (touchscreen devices will display fulltime however). Choose Display Caption In Image to display all the time inside the image for all devices. Choose Display Caption Under Image to display all the time under the image');
        $this->edit_styles_close($data,'blog_data5',$imagecaptiontitle,'width_special,width_max_special,width_min_special,float,background,padding_top,padding_bottom,padding_left,padding_right,margin_top,margin_bottom,margin_left,margin_right,borders,box_shadow,outlines,radius_corner,font_color,text_shadow,font_family,font_size,font_weight,text_align,text_shadow,line_height,letter_spacing,italics_font,small_caps,text_underline','Style the <b>Background/Spacing/Text</b> of Captions in Images',false,''); 
        $checked1=($image_caption_hover==='nohover')?' checked="checked"':'';
        $checked2=($image_caption_hover==='hover')?' checked="checked"':'';
        $checked3=($image_caption_hover!=='hover'&&$image_caption_hover!=='nohover')?' checked="checked"':'';
        printer::alert('<input type="radio" value="nohover" name="'.$data.'_'.$img_opt.'['.$image_caption_hover_index.']" '.$checked1.'>Display Caption in Image on all devices');
        printer::alert('<input type="radio" value="hover" name="'.$data.'_'.$img_opt.'['.$image_caption_hover_index.']" '.$checked2.'>Hover Caption in Image (Hovers on non touchscreen devices and displays In-Image by default on touchscreen devices)');
        printer::alert('<input type="radio" value="under_image" name="'.$data.'_'.$img_opt.'['.$image_caption_hover_index.']" '.$checked3.'>Display Caption Under Image');
        echo '<div class="fsminfo editbackground editfont '.$this->column_lev_color.' floatleft editfont maxwidth500"><!--finetunebottom--> 
        Fine Tune Your Caption Bottom if Necessary (on hover if set to hover)'; 
        printer::print_tip('By Default the bottom of the caption is set to the bottom of the Image 0px. Fine tune that value here as required. Negative #s lower Positive numbers raise it');
        $msgjava='Choose height adjust caption bottom:';
        $this->mod_spacing($data.'_'.$img_opt.'['.$imagecaption_bottom_index.']',$imagecaption_bottom,-100,100,1,'px','none',$msgjava); 
        echo '</div><!--Edit Final height Adjust Captons-->';
        }
     if (!$this->is_clone||$this->clone_local_data){
        printer::alert('Add your Caption Text Here');
        $this->textarea($image_caption_text ,$data.'_blog_tiny_data3','600','16');
        $this->show_more('Add link to image/caption','','','',500,'','float:left',true);
        $this->print_redwrap('image link');
        printer::print_tip('Choose a page in this website to go to when this image and/or caption is clicked, Or enter an external link to go to when this image is clicked. External links must start with http:// or https:// to be valid! ie https://www.imaginetheland.com');
        printer::print_wrap1('internalwrap');
        printer::print_notice('<b>Chosen Site link is: '.$image_internal_link.'</b>');
        printer::print_notice('<br>Note: internal links will override external links. Use None to remove internal link');
        $this->choose_nav($data,'blog_tiny_data6');
        printer::pclear();
        printer::alertx('<p class="floatleft editcolor editbackground editfont smaller">Add an internal link query ie. ?slipstart=2<br><input type="text" name="'.$data.'_blog_tiny_data4" value="'.$this->blog_tiny_data4.'"> <span class="info" title="query starts with ? &amp; slipstart=2 would start slippry gallery on slide #2 if the linked page contains a slippry gallery with configuration option set to auto play">More info </span></p>'); 
        printer::close_print_wrap1('internalwrap');
        printer::pclear(5);
        printer::alert('OR Enter an external link<br><input type="text" name="'.$data.'_blog_tiny_data5" value="'.$this->blog_tiny_data5.'">'); 
        $this->close_print_wrap('image link');
        $this->show_close('Add image link'); 
        }
		$this->close_print_wrap('Image Caption Link');
     $this->show_close('Add Image Caption/Link'); 
   
     
		#######################image link
   
   #######end image link 
   $current = $this->current_net_width*$wpercent/100;
   
   if (!$this->is_clone||$this->clone_local_style){ 
     $this->show_more('Image Specific Configs','','','',500,'','float:left',true);
     $this->print_redwrap('config image');
     #################################################33 
      printer::print_tip('For Image Float Text Images Customize the image to text relative styling. Setting up @media widths also possible');
      $this->show_more('Customize Relative Image Sizing');
     printer::print_wrap('Relative Image Sizing');
     printer::print_notice('Optionally tweak Customize the relative Image proportion <b>(generally for Image Float Right/Left Text posts)</b> with the following Options. ');
     printer::pclear();
     echo '<div class="fs1color floatleft"><!--Edit image Width Adjust-->';  
     $msgjava='Choose Relative Width percent of image in post:'; 
     $this->mod_spacing($data.'_'.$img_opt.'['.$image_width_limit_index.']',$wpercent,0,100,1,'%','none',$msgjava); 
     echo '</div><!--Edit image Width Adjust-->';
     printer::print_wrap('media 100 percent');
     printer::print_tip('Optionally tweak the image to custom % of the post ie when the text narrows to a point image goes to 100%. Choose one or more @media controlled custom percent width for the image (uses class .imagewrap which can also be tweaked using styles -> advanced styles with suffix .imagewrap )');
     printer::print_info('A Limiting Maintain Width will be overriden according to bps chosen here');
     printer::print_info('Exhibit custom % (5-100%) @ each media query used. Enter a max-width or min-width or both (250-3000px range leave out the units)');
      echo '<table class="rwdmedia">
   <tr><th></th><th>Media max-width bp</th><th>Media min-width</th><th>Change Percent</th></tr>';
   $sort_arr=array();
   for ($i=1; $i<6;$i++){
     $image_per=(is_numeric($img_opt_arr[${'image_per'.$i.'_index'}])&&$img_opt_arr[${'image_per'.$i.'_index'}]>=5&&$img_opt_arr[${'image_per'.$i.'_index'}]<=100)?$img_opt_arr[${'image_per'.$i.'_index'}]:'';
     $maxwidth=(is_numeric($img_opt_arr[${'image_max_media'.$i.'_index'}])&&$img_opt_arr[${'image_max_media'.$i.'_index'}]>=250&&$img_opt_arr[${'image_max_media'.$i.'_index'}]<=3000)?$img_opt_arr[${'image_max_media'.$i.'_index'}]:'';
     $minwidth=(is_numeric($img_opt_arr[${'image_min_media'.$i.'_index'}])&&$img_opt_arr[${'image_min_media'.$i.'_index'}]>=250&&$img_opt_arr[${'image_min_media'.$i.'_index'}]<=3000)?$img_opt_arr[${'image_min_media'.$i.'_index'}]:''; 
     $name1=$data.'_'.$img_opt.'['.${'image_max_media'.$i.'_index'}.']';
     $name2=$data.'_'.$img_opt.'['.${'image_min_media'.$i.'_index'}.']';
     $name3=$data.'_'.$img_opt.'['.${'image_per'.$i.'_index'}.']';
     echo '<tr><td> @media'.$i.'</td><td><input name="'.$name1.'" type="text" value="'.$maxwidth.'" ></td><td><input name="'.$name2.'" type="text" value="'.$minwidth.'" ></td><td><input name="'.$name3.'" type="text" value="'.$image_per.'" ></td></tr>';
     $sort_arr[$maxwidth]=array($minwidth,$image_per);
     }
   krsort($sort_arr);
   foreach ($sort_arr as $key=>$media_arr){
     $mediamax=$key;
     $mediamin=$media_arr[0];
     $image_per=$media_arr[1];
     if(!empty($mediamax)&&!empty($mediamin)&&!empty($image_per)) {
			 $this->mediacss.='
@media screen and (max-width:'.$mediamax.'px) and (min-width:'.$mediamin.'px){ 	
   div.'.$this->dataCss.' div.imagewrap{width:'.$image_per.'%;max-width:none;min-width:none;}
}';
			}
		elseif (!empty($mediamax)&&!empty($image_per)){
			 $this->mediacss.='
@media screen and (max-width: '.$mediamax.'px){ 
   div.'.$this->dataCss.' div.imagewrap{width:'.$image_per.'%;max-width:none;min-width:none;}
}';
        }
		elseif (!empty($mediamax)&&!empty($image_per)) {
			 $this->mediacss.='
@media screen and (min-width: '.$mediamin.'px){
 div.'.$this->dataCss.' div.imagewrap{width:'.$image_per.'%;max-width:none;min-width:none;}
}';
        }
     }       
   echo '</table>';
     printer::close_print_wrap('media 100 percent');
     $checked1=($this->blog_tiny_data1==='maintain_width')? 'checked="checked"':'';
     $checked2=($this->blog_tiny_data1==='maintain_width')?'':'checked="checked"';
     echo '<div class="fsminfo floatleft '.$this->column_lev_color.' editfont editbackground editfont editcolor"><!--Edit image Limiter Mode-->';
     printer::print_tip('If Width adjust is being used such as with text image floating posts you can Choose To Scale Image or Maintain Image Size when scaling down For smaller Screen Views <br>');
     printer::alertx('<p class="fs1'.$this->column_lev_color.'" title="In Maintain Image Size Mode, Images with width limiting or Images with float text size will not scale down proportionally but maintain size up to the post max width!"><input type="radio" name="'.$data.'_blog_tiny_data1" '.$checked1.' value="maintain_width">Maintain Image Size<span class="info"> more info</span><p>');
     $stylemin='';//($this->blog_tiny_data1==='maintain_width')?'style="display:none;':'';		 
     echo '<div class="fs1'.$this->column_lev_color.'" title="In image Scale mode Mode images will scale down proportionally with spaces or text on smaller view screens"><!--scale images--><input type="radio" onclick="gen_Proc.showIt(\''.$data.'_showmin\');" name="'.$data.'_blog_tiny_data1" '.$checked2.' value="0">Scale Images<span class="info"> more info</span>';
     echo '<div id="'.$this->dataCss.'_showmin" '.$stylemin.'><!--show min width-->';
     printer::alert('Optionally Choose a minimum width for scaled images as necessary',0,'fsmredAlert editbackground editfont editcolor editfont');
     $this->mod_spacing($data.'_'.$img_opt.'['.$image_min_index.']',$image_min,10,600,1,'px','none');
     echo '</div><!--show min width-->';
     echo '</div><!--scale images-->';
     echo '</div><!--Edit image Limiter Mode-->';
     printer::close_print_wrap('Relative Image Sizing');
     $this->show_close('Customize Relative Image Sizing');
     $this->print_wrap('image noexpand');
     printer::print_tip('By Default Images will not expand when clicked on. Enable/disable this setting here. Will expand to maximum size specified in page options or max uploaded size whichever smaller'); 
     $genstyle=($img_opt_arr[$image_noexpand_index]==='display')?'style="display:block;"':'style="display:none;"';
      
     if ($img_opt_arr[$image_noexpand_index]!=='display') 
        printer::printx ('<p class="highlight floatleft" title="Check to Allow Image Expansion when this Image is clicked"><input type="checkbox" name="'.$data.'_'.$img_opt.'['.$image_noexpand_index.']" onclick="edit_Proc.displaythis(\''.$data.'_expandsize_show\',this,\'#fdf0ee\')" value="display">Allow Expanded Image</p>');
             
     else printer::printx('<p class="highlight floatleft fsminfo" title="Check to prevent Image Expansion when this Image is clicked"><input type="checkbox" name="'.$data.'_'.$img_opt.'['.$image_noexpand_index.']" value="no_display">Prevent Image Click Expanded Image</p>');
     printer::pclear();
     $maxplus=(!empty($img_opt_arr[$image_max_expand_index])&&$img_opt_arr[$image_max_expand_index]>50)?$img_opt_arr[$image_max_expand_index]:((!empty($this->page_options[$this->page_max_expand_image_index])&&$this->page_options[$this->page_max_expand_image_index]>50)?$this->page_options[$this->page_max_expand_image_index]:Cfg::Page_pic_expand_plus);
     printer::printx('<div title="Change this default maximum width or height value '.$maxplus.' for this image." id="'.$this->dataCss.'_expandsize_show" '.$genstyle.' class="fsminfo highlight floatleft"><!--imageplus-->Change Expanded Image height or width setting whichever is larger:');
     $this->mod_spacing($data.'_'.$img_opt.'['.$image_max_expand_index.']',$maxplus,25,1500,10,'px');
     printer::printx('</div><!--imageplus-->');
     printer::pclear();
     printer::close_print_wrap('image expand');	
     ######################
     $checked1=($image_height_set)? 'checked="checked"':'';
     $checked2=($image_height_set)?'':'checked="checked"';
     printer::print_wrap('set image height');
     printer::print_tip('Setting an Height in the main post configurations will automatically set the post width to auto preserving the aspect ratio of the image by setting image width proportional to the post height. <span class="warn">Allow Proportional image when image height</span>');
     printer::alertx('<p class="fs1'.$this->column_lev_color.'" ><input type="radio" name="'.$data.'_'.$img_opt.'['.$image_height_set_index.']" '.$checked1.' value="setheight">Height: auto; Proportional to width<p>');
     printer::alertx('<p class="fs1'.$this->column_lev_color.'" ><input type="radio" name="'.$data.'_'.$img_opt.'['.$image_height_set_index.']" '.$checked2.' value="overridesetheight">Override proportional image when height is set.<p>');
     /* printer::print_wrap1('set @media image height',$this->column_lev_color);
     printer::print_tip('Optionally enable a cancelling @media max-width to reset height width to the default height:auto if you wish to re-enable width settings on smaller view screens.');
     $this->mod_spacing($data.'_'.$img_opt.'['.$image_height_media_index.']',$image_height_media,300,3000,1,'px');
     
     printer::close_print_wrap1('set @media image height');*/
     
     printer::close_print_wrap('set image height');
     ###############3
     printer::pclear();
     $this->print_wrap('image resize');
     printer::print_tip('Image Cache generation is suggested for larger images which enables Optimum download sizes for speed and bandwidth usage. Small images are better off not being resized to maintain maximum image quality. Animated Gif and Svg images will not be resized from original uploaded sizes.');
     if ($img_opt_arr[$image_noresize_index]!=='noresize') 
        printer::printx ('<p class="highlight floatleft" title="Check to Allow Image Resize when this Image is clicked"><input type="checkbox" name="'.$data.'_'.$img_opt.'['.$image_noresize_index.']"  value="noresize">Do not Allow Image Resize Cache Generation</p>');
             
     else printer::printx('<p class="highlight floatleft fsminfo" title="Check to prevent Image Expansion when this Image is clicked"><input type="checkbox" name="'.$data.'_'.$img_opt.'['.$image_noresize_index.']" value="resize">Allow Image Resize Cache Generation</p>');
     echo'<div class="floatleft editbackground editfont editcolor fsminfo highlight" title="By Default Uploaded Images will have a Quality factor of '.Cfg::Pic_quality.' with 100 being the highest and 10 the lowest. The higher the image quality the larger the filesize and the slower the download speed. Change the Default value here which will effect all uploaded images on the site that are not specifically configured for this value in the image, slideshow, or gallery configurations" ><!--quality image-->Change Default Image Quality setting:';
     $this->mod_spacing($data.'_'.$img_opt.'['.$image_quality_index.']',$quality,10,100,1,'%');
        printer::print_info('Images will auto reload @ new Quality setting');
     echo'</div><!--quality image-->'; 
     $this->submit_button();
     printer::close_print_wrap('image resize'); 
     printer::close_print_wrap('config image');
     $this->show_close('Configure Image');
     }
   
   printer::pclear();
	$this->background_img_px=$fwidth+$pad_width;
	$global_field=($this->blog_global_style==='global')?',.'.$this->col_dataCss.' > .'.$this->blog_type.'_img , .'.$this->col_dataCss.' >fieldset>.'.$this->blog_type.'_img':'';
	$globalmsg=($this->blog_global_style==='global')?' Global Style':'';
	$this->edit_styles_close($data,'blog_data4','.'.$this->dataCss.'_img'.$global_field,'background,padding_top,padding_bottom,padding_left,padding_right,margin_top,margin_bottom,borders,box_shadow,outlines,radius_corner','Style Image Border,Radius, &amp; Image Spacing '.$globalmsg,false,'Style an Image Border and background effect here. Remember that Margin spacing is outside the image border whereas Padding spacing will put space between a border and the image.',true,'',true); 
	printer::pclear();
	#ok here if marked as global the results of these styles choices will directly style this blog type but also the parent column.text.. as shown...
	#all fields done cause blog_global_style equalling global applies to all fields that are chosen to be included
	$type=($this->blog_type==='float_image_left'||$this->blog_type==='float_image_right')?'float_image':$this->blog_type;
	$global_field=($this->blog_global_style==='global')?',.'.$this->col_dataCss.' > .'.$type.',.'.$this->col_dataCss.' >fieldset>.'.$type:'';
	$globalmsg=($this->blog_global_style==='global')?' Global Style':'';
	$style_list=''; 
	$this->edit_styles_close($data,$style_ref,'.'.$this->dataCss.'.post.'.$type.$global_field, $style_list,'Style the Overall Post'.$globalmsg,'','',true); 
   if (!$this->is_clone||$this->clone_local_style)printer::close_print_wrap('image configs');
   if (!$this->is_clone||$this->clone_local_style)$this->show_close('Image Styling &amp; Configs');
	}//end build #end build

function choose_nav($data,$index){if (Sys::Quietmode) return; if (Sys::Pass_class)return;
	$this->show_more('Choose Link to Page within this site','',$this->column_lev_color.' smaller editbackground editfont button'.$this->column_lev_color,'',800);
	echo '<p class="info Os3darkslategray fsmyellow editbackground editfont click" onclick="gen_Proc.use_ajax(\''.Sys::Self.'?choose_pagenav='.$data.'&amp;choose_index='.$index.'\',\'handle_replace\',\'get\');" >Gen Page List to choose From</p>';
	printer::pclear();
	echo '<div id="choose_pagenav_'.$data.'" class="small width100 left floatleft fsminfo editbackground editfont editcolor"></div>'; 
	$this->show_close('restore backups');
   printer::pclear(7);
	}
   
function float_pic($data,$picdir){ 
	$this->build_pic($data,$picdir);
	($this->edit)&&printer::pclear();
	if ($this->edit)printer::alert($this->styler2_instruct);
	}
	 
function blog_text_float_box($data){ 
	static $myinc=0; $myinc++;
	if (!empty($this->blog_text&&!$this->edit)){
		echo process_data::clean_break($this->blog_text);
		return; 
		} 
	else if (!$this->edit)return;
	else if ($this->is_clone&&!$this->clone_local_data&&!empty($this->blog_text)){ 
		echo process_data::clean_break($this->blog_text);
		return;
		}
	elseif ($this->is_clone)return; 
	static $myinc=0; $myinc++;
	$cols=(!empty($this->current_net_width))?process_data::width_to_col($this->current_net_width,$this->current_font_px):$columns; 
	$display_editor=($this->blog_options[$this->blog_editor_use_index]==='use_editor')?'enableTiny ':'divTextArea';
	$rowlength=($cols<3)?3:process_data::row_length($this->blog_text,$cols); 
	$print=($this->blog_options[$this->blog_editor_use_index]==='use_editor')?'':
		'<div class="'.$this->column_lev_color.' floatleft cursor smallest editbackground editfont editcolor editfont shadowoff rad3 button'.$this->column_lev_color.'" onclick="edit_Proc.enableTiny(this,\''.$data.'_blog_text\',\'divTextArea\');">Use TinyMce</div>';
	echo $print;
	printer::pspace(3);
   $this->blog_text=(strlen($this->blog_text)<2)?'<br>Enter text here':$this->blog_text;
	echo '<div id="'.$data.'_blog_text" class="'.$display_editor.' '.$data.' min100 cursor">'; 
		echo process_data::clean_break($this->blog_text); 
	echo '</div>';
	$blog_text=($this->blog_options[$this->blog_editor_use_index]==='use_editor')?process_data::textarea_validate($this->blog_text):process_data::textarea_validate(process_data::remove_html_break($this->blog_text));
   echo ' 
   <textarea style="background:inherit; display: none; width:100%" id="'.$data.'_blog_text_textarea"  class="scrollit '.$data.'" name="'.$data.'_blog_text" rows="'.$rowlength.'" cols="'.$cols.'" onkeyup="gen_Proc.autoGrowFieldScroll(this);">' .$blog_text.'</textarea>';
}
	#end function
	

function create_master_gallery(){ 
    if (!$this->edit&&!isset($_POST['create_master_gallery']))return;
    foreach($_POST['create_master_gallery'] as $gall_ref => $newgall_ref){ 
        $table=(isset($_POST['clone_local_data_gall'])&&$_POST['clone_local_data_gall']=$gall_ref)?$this->master_post_data_table:$this->master_post_data_table;
        $q="select blog_id,blog_tiny_data2 from $table where blog_type='gallery' and blog_data1='$gall_ref'"; 
        $r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
        list($blog_id,$master_gall_status)=$this->mysqlinst->fetch_row($r);
        $blog_id=(int)$blog_id;
        if (!isset($_POST['master_title'][$gall_ref])||!isset($_POST['gallref_image_choice'][$gall_ref])){
             $this->message[]="Choose both a gallery image to display for your new master gallery image link and a title for Gallery Link Reference in post Id p$blog_id";
            }
        elseif (empty($_POST['create_master_gallery'][ $gall_ref ]||empty($_POST['gallref_image_choice'][ $gall_ref ]))||empty($_POST['master_title'][$gall_ref])){
            $this->message[]="Choose both a gallery image to display for your new master gallery image link and a title for Gallery Link Reference in post Id p$blog_id";
            }
        else{
            $image=$_POST['gallref_image_choice'][$gall_ref];
            $gall_title=$_POST['master_title'][$gall_ref];
            $gall_fields=Cfg::Gallery_fields;
            $gall_field_arr=explode(',',$gall_fields);
            $value='';
            $q="select gall_table from $this->master_gall_table where gall_ref='$newgall_ref' and master_gall_status !='master_gall' limit 1";
             
            $gt=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
            list($gall_table)=$this->mysqlinst->fetch_row($gt);
            foreach ($gall_field_arr as $field) {
                if ($field==='master_gall_ref')$value.="'$newgall_ref',";
                elseif ($field==='master_table_ref')$value.="'$gall_table',";
                elseif($field==='master_gall_status')$value.="'master_gall',";
                elseif($field==='pic_order')$value.="'30000',";#will be renumbered
                elseif($field==='imagetitle')$value.="'$gall_title',";
                elseif($field==='subtitle')$value.="'',";
                elseif($field==='description')$value.="'',";
                elseif($field==='gall_ref')$value.="'$gall_ref',";//gall ref is trigger for deleting so is used to hold this master gall id whereas master gall ref will hold particlar gall selection
                elseif($field==='gall_table')$value.="'$this->pagename',";
                elseif($field==='picname')$value.="'$image',";
                else $value.="'0',";
                }
            $this->mysqlinst->count_field($this->master_gall_table,'pic_id','',false,'');
            $inc_id=$this->mysqlinst->field_inc;
            
            $q="insert into $this->master_gall_table (pic_id,$gall_fields,gall_update,gall_time,token) values ($inc_id,$value '".date("dMY-H-i-s")."','".time()."','".mt_rand(1,mt_getrandmax())."')"; 
            $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
            if ($master_gall_status!=='master_gall'){
                $q="update $this->master_post_table set token='".mt_rand(1,mt_getrandmax()). "',blog_update='".date("dMY-H-i-s")."',blog_time='".time()."', blog_tiny_data2='master_gall' where blog_id='$blog_id'";
                $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
                }
            $this->success[]="A new master gallery has been created in post Id p$blog_id";
             $this->success[]="A new master gallery has been created in post Id p$blog_id";
            }
        }
    }


function gallery($data,$gall_ref=''){
	static $inc=0; $inc++;
	$this->master_gallery=($this->blog_tiny_data2==='master_gall')?true:false;
	$msg='Changes are immediate and your Gallery Order has been Updated. Continue sorting as needed then refresh edit page or submit other changes to View the new Slide Show order in webpage mode';
	$this->edit_styles_open();
	$count=false;
	if ($this->edit){
		$g_arr=array();
		$q="select distinct gall_ref,gall_table from $this->master_gall_table where master_gall_status!='master_gall' order by gall_table asc"; 
		$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
		if ($this->mysqlinst->affected_rows()){ 
			$gcount=$this->mysqlinst->num_rows($r);
			While ($gRows=$this->mysqlinst->fetch_assoc($r)){
				$g_arr[]=$gRows;
				}
			}
		else $gcount=0;
     if (!empty($gall_ref)){
			$where =" where gall_ref='$gall_ref'";
			 $count=$this->mysqlinst->count_field($this->master_gall_table,'pic_id','',false,$where);
			if ($count>1)$count=true;
			}
		if (!$count || empty($gall_ref)){
			#create distinct gall_ref now
			if(empty($gall_ref)){  
          $q="select distinct gall_ref from $this->master_gall_table where  master_gall_status!='master_gall' and gall_table='$this->pagename' order by gall_table";
				$rg=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
				if ($this->mysqlinst->affected_rows()){
					$tb_arr=array();
					while (list($gall_tbn)=$this->mysqlinst->fetch_row($rg,__LINE__)){
						$tbn_arr[]=$gall_tbn;
						}
					$n=1;
					While (in_array($this->pagename.'_'.$n,$tbn_arr)){
						$n++;
						}
					$gall_ref=$this->pagename.'_'.$n; 
					}//affected rows
				else $gall_ref=$this->pagename.'_1';
				$ptable=(!$this->clone_local_data)?$this->master_post_table :$this->master_post_data_table;
				$pext=(!$this->clone_local_data)?'':'p';
				$q="update $ptable set blog_data1='$gall_ref' where blog_id='$pext$this->blog_id' and blog_table_base='$this->pagename'"; 
				$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
				}
			if (!empty($gall_ref)){
				printer::printx('<p class="smallest editcolor fsminfo editbackground editfont editcolor floatleft">Gall Ref: '.$gall_ref.'</p>');
				}
			if ($gcount >1){
          printer::pclear();
				$this->show_more('Create Master Gallery Info','noback','fsm2info rad5 supertiny editbackground editfont '.$this->column_lev_color,'','full');
          $this->print_wrap('wrap master gall href');
				printer::alertx('<p class="tip rad3 maxwidth100 floatleft " title="Two or more galleries are required to make a master gallery">'.$gcount.' galleries exist in this site</p>');
				printer::pclear();
				printer::alertx('<p class="'.$this->column_lev_color.' floatleft editbackground editfont">When two or more galleries are created on this site a "master gallery" may be created to display a Gallery of Galleries or in other words a listing of your galleies with each having a Title, an Image, and link to each individual Gallery Collection.</p>');
				printer::alertx('<p class="floatleft editcolor editbackground editfont">Choose a previously Created Gallery to Begin Your first Master Gallery Collection Here:
				<select class="smaller editcolor editbackground editfont" onchange="edit_Proc.imageSelectMaster(this,\'gallref_image_choice_'.$inc.'\',\'gallref_title_'.$inc.'\',\''.$gall_ref.'\');" name="create_master_gallery['.$gall_ref.']">');
				printer::alertx('<option value="x" select="selected">Choose Gallery to Add</option>');
				foreach($g_arr as $arr){
					$choosegall_ref=$arr['gall_ref'];
					$ch_gall_table=$arr['gall_table'];
					$q="select page_title,page_ref, page_filename from $this->master_page_table where page_ref='$ch_gall_table' order by page_ref asc";  
					$rpag = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
					list($page_title,$page_ref,$page_filename)=$this->mysqlinst->fetch_row($rpag);
					 if (empty($page_ref)||$page_ref!==$ch_gall_table)continue;
					$menu_title=(!empty($page_title))?'Menu Title: '.substr($page_title,0,15):'';
					printer::printx('<option value="'.$choosegall_ref.'">'."GallRef: $choosegall_ref on PageRef: $ch_gall_table $menu_title".'</option>');
					}
				printer::printx('</select></p>');
				printer::pclear(20);
				echo '<div id="gallref_image_choice_'.$inc.'"><!--display image choice--></div><!--display image choice-->';
				printer::pclear(20);
				echo '<div id="gallref_title_'.$inc.'" class="editbackground editfont editcolor" style="display:none">Enter a title For Your Gallery<input type="text" name="master_title['.$gall_ref.']" maxlength="50" size="50"></div>'; 
				printer::pclear();
				echo '<div id="dis_gallref_title_'.$inc.'"><!--or Continue-->';
				printer::alert('<br>OR<br><br>');
				printer::pclear();
				printer::alertx('<p class="highlight floatleft editbackground editfont" title="two or more galleries required to make master gallery">Continue Below to Configure a Normal Gallery and Upload your first image</p>');
				printer::pspace(20);
				echo '</div><!--or Continue-->';
				printer::pspace(20);
				echo'<div id="show_gallref_title_'.$inc.'" class="warn1 center inline" style="display:none;">Following your selection of image and entering the title hit any submit button and Configurations applicable to a Master Gallery Will Appear along with your First Gallery choice in this Master Gallery Post<!--show submit button and info-->';
				$this->submit_button('Submit Create Master Gallery');
				echo'</div>';
				//echo '</div><!--wrap master gall href-->';
				printer::close_print_wrap('wrap master gall href');
				$this->show_close('Master Gallery Info');
				}//count <1 
			}//gallery empty
	 	else {
			$this->show_more('Master Gallery Info','noback','fs2info rad3 smallest editbackground editfont '.$this->column_lev_color,'',500);
			printer::print_wrap('Master Gallery Info');
        echo '<div class="fsminfo floatleft editbackground editfont"><!--wrap master gall href-->';
			if (!$this->master_gallery)
				printer::alertx('<p class="'.$this->column_lev_color.' floatleft editbackground editfont"> When two or more galleries are created on this site and A new gallery is created with no images uploaded an option to create a master gallery will be displayed here. A master gallery is a Gallery of Galleries having a Title, an Image, and link to each Gallery Collection.</p>');
			else printer::alertx('<p class="'.$this->column_lev_color.' floatleft editbackground editfont">New Gallery Collections may be added to the Master Gallery see the option below</p>');
			echo '</div><!--wrap master gall href-->';
        printer::close_print_wrap('Master Gallery Info');
			$this->show_close('Master Gallery Info');
			} //not empty
		}//edit
   if ($this->edit&&!$this->master_gallery&&(!$this->is_clone||$this->clone_local_data)){
     if ($gcount >0){
        $this->show_more('Import/Start New Gallery','noback','fsminfo rad3 small editbackground editfont '.$this->column_lev_color,'','full');
        printer::print_wrap('Import/Start New Gallery');
        echo '<div class="fs2black floatleft editbackground editfont maxwidth700"><!--wrap reg gall href-->';
        printer::alertx('<p class="tip rad3 maxwidth100 floatleft " title="Move Previously Created gallery Here">'.$gcount.' galleries exist in this site</p>');
        printer::pclear();
        printer::alertx('<p class="'.$this->column_lev_color.' floatleft editbackground editfont">When two or more galleries are created on this site a "master gallery" may be created to display a Gallery of Galleries or in other words a listing of your galleies with each having a Title, an Image, and link to each individual Gallery Collection.</p>');
        printer::alertx('<p class="floatleft editcolor editbackground editfont">Choose a previously Created Gallery to Move/Import Here or Select Start New Gall Option.<br> <span class="caution">Caution: All images from the original gallery will be moved to this page</span> 
        <select class="smaller editcolor editbackground editfont" onchange="edit_Proc.imageSelectGallery(this,\'gall_image_select_'.$inc.'\',\'gallref_title_'.$inc.'\',\''.$gall_ref.'\');" name="'.$this->clone_ext.'import_gallery['.$this->blog_id.']">');
        printer::alertx('<option value="x" select="selected">Choose Gallery to Add</option>');
        printer::printx('<option value="create_new_gallery">Start Fresh Over: Remove Current Gall Images</option>');
        foreach($g_arr as $arr){
          $choosegall_ref=$arr['gall_ref'];
          $ch_gall_table=$arr['gall_table'];
          printer::printx('<option value="'.$choosegall_ref.'">'."GallRef: $choosegall_ref with PageRef: $ch_gall_table".'</option>');
          }
        printer::printx('</select></p>');
        echo '<div class="editcolor editbackground editfont" id="gall_image_select_'.$inc.'"><!--display image choice--></div><!--display image choice-->';
        echo '<div class="editcolor editbackground editfont" id="gallref_title_'.$inc.'"><!--display hold--></div><!--display hold-->';//this is not used in regular gallery provides div id placeholder only because is needed in master gallery
        printer::pclear(20);
        printer::pclear(20);
        echo '</div><!--wrap reg gall href-->';
        printer::close_print_wrap('Import/Start New Gallery');
        $this->show_close('Import/Start New Gallery');
			} //count 
		}//end if edit ! master
	$this->blog_options($data,$this->blog_table);
		#gallindexes 
	$gall_indexes='preview,galltype,gall_glob_title,limit_width,mainmenu,controltheme,six,fixed_pad,padleft,smallpic,largepic,caption,preview_padtop,thumbnail_height,transition,thumbnail_pad_right,thumbnail_pad_bottom,thumb_width_type,caption_vertical_align,transition_time,caption_width,preview_pad_bottom,gall_icon_color,image_quality,pause,limitmax,slippry_top_control,slippry_mid_control,simulate_background,slippry_maintain,slippry_force_auto,photoswipe_topcontrol_background,photoswipe_caption_background,gall_masonry,preview_minimum,slipbar_color,position_menu_icon,slipbar_size,return_icon_size,gall_flex,thumbnail_height_em,thumbnail_height_rem,thumbnail_height_min,photoswipe_prevnext_background,';
	$caption_height=300;//sets the bottom movement overflow none to hide hover caption
	$gall_index_arr=explode(',',$gall_indexes);
	//$this->{$data.'_blog_data2_arrayed'}=$blog_data2=explode(',',$this->blog_data2);
	$blog_data2=explode(',',$this->blog_data2);//holds the various gall configs..
	for ($i=0; $i <count($gall_index_arr); $i++){ 
		if (!array_key_exists($i,$blog_data2)){
			$blog_data2[$i]='';
			$this->{$data.'_blog_data2_arrayed'}[$i]='';
			}
		} 
	foreach($gall_index_arr as $key => $index){
		${$index.'_index'}=$key;
		}
   $position_menu_icon=($blog_data2[$position_menu_icon_index]==='left')?'left:20px;':'right:20px;';
	$quality=(!empty($blog_data2[$image_quality_index])&&$blog_data2[$image_quality_index]>9&&$blog_data2[$image_quality_index]<101)?$blog_data2[$image_quality_index]:((!empty($this->page_options[$this->page_image_quality_index])&&$this->page_options[$this->page_image_quality_index]<101&&$this->page_options[$this->page_image_quality_index]>9)?$this->page_options[$this->page_image_quality_index]:Cfg::Pic_quality);
	$slippry_maintain=($blog_data2[$slippry_maintain_index]==='maintain'||$blog_data2[$slippry_maintain_index]==='simulate')?$blog_data2[$slippry_maintain_index]:'defaultgalpagecontext';
	$slippry_force_auto=($blog_data2[$slippry_force_auto_index]==='forceauto')?true:false; 
	$preview_minimum=$preview_minimum=($blog_data2[$preview_minimum_index]>=10&&$blog_data2[$preview_minimum_index]<=90)?$blog_data2[$preview_minimum_index]:(($blog_data2[$preview_minimum_index]==='none')?'none':70); 
	$gall_flex=($blog_data2[$gall_flex_index]==='gall_flex')?true:false; 
   $gall_masonry=($blog_data2[$gall_masonry_index]==='gall_masonry')?true:false; 
   $slipbar_size_arr=explode('@@',$blog_data2[$slipbar_size_index]);
   $slipbar_size=$slipbar_size_arr[0];
	$slipbar_size=($slipbar_size>=.3&&$slipbar_size<=10)?$slipbar_size:0;
   if (empty($slipbar_size)){
     $slipbar_size=1;
     $slipbar_size_arr[0]=1;
     $blog_data2[$slipbar_size_index]=implode('@@',$slipbar_size_arr);
     printer::printx('<input type="hidden" value="1" name="'.$data.'_blog_data2['.$slipbar_size_index.']">');
     }  
   $return_icon_size_arr=explode('@@',$blog_data2[$return_icon_size_index]);
   $return_icon_size=$return_icon_size_arr[0];
	$return_icon_size=($return_icon_size>=.3&&$return_icon_size<=10)?$return_icon_size:0;
   if (empty($return_icon_size)){
     $return_icon_size=2;
     $return_icon_size_arr[0]=2;
     $blog_data2[$return_icon_size_index]=implode('@@',$return_icon_size_arr);
     printer::printx('<input type="hidden" value="1" name="'.$data.'_blog_data2['.$return_icon_size_index.']">');
     } 
	$slipbar_color=(preg_match(Cfg::Preg_color,$blog_data2[$slipbar_color_index]))?$blog_data2[$slipbar_color_index]:(($blog_data2[$slipbar_color_index]==='none')?'none':'f0f0f0');
	$photoswipe_topcontrol_background=(preg_match(Cfg::Preg_color,$blog_data2[$photoswipe_topcontrol_background_index]))?$blog_data2[$photoswipe_topcontrol_background_index]:'none';	
	$photoswipe_prevnext_background=(preg_match(Cfg::Preg_color,$blog_data2[$photoswipe_prevnext_background_index]))?$blog_data2[$photoswipe_prevnext_background_index]:'none';			 
	$photoswipe_caption_background=(preg_match(Cfg::Preg_color,$blog_data2[$photoswipe_caption_background_index]))?$blog_data2[$photoswipe_caption_background_index]:'none';			 		 
	$simulate_background=(preg_match(Cfg::Preg_color,$blog_data2[$simulate_background_index]))?$blog_data2[$simulate_background_index]:'ffffff';
	$gall_expand_menu_icon=(preg_match(Cfg::Preg_color,$blog_data2[$gall_icon_color_index]))?$blog_data2[$gall_icon_color_index]:'595555';
	$transition_time=(!empty($blog_data2[$transition_time_index])&&$blog_data2[$transition_time_index]>=.2&&$blog_data2[$transition_time_index]<=3)?$blog_data2[$transition_time_index]:2;
	$pause=(!empty($blog_data2[$pause_index])&&$blog_data2[$pause_index]>=3&&$blog_data2[$pause_index]<=30)?$blog_data2[$pause_index]:7;	 	 
	$caption_width=(is_numeric($blog_data2[$caption_width_index])&&$blog_data2[$caption_width_index]>=50&&$blog_data2[$caption_width_index]<701)?$blog_data2[$caption_width_index]:0;
	$transition=($blog_data2[$transition_index]==='vertical'||$blog_data2[$transition_index]||$blog_data2[$transition_index]==='horizontal'||$blog_data2[$transition_index]==='kenburns')?$blog_data2[$transition_index]:'fade';
	$captions=($blog_data2[$caption_index]=='global'||$blog_data2[$caption_index]=='none')?$blog_data2[$caption_index]:'individual';
	$smallpicplus=(is_numeric($blog_data2[$smallpic_index])&&$blog_data2[$smallpic_index]>=50&&$blog_data2[$smallpic_index]<1001)?$blog_data2[$smallpic_index]:(($this->master_gallery)?Cfg::Master_gall_pic_width:Cfg::Small_gall_pic_plus);
	 //used for master gallery and normal gallery 
	$largepicplus=(is_numeric($blog_data2[$largepic_index])&&$blog_data2[$largepic_index]>=125&&$blog_data2[$largepic_index]<3001)?$blog_data2[$largepic_index]:800;
	$limit_width=(is_numeric($blog_data2[$limit_width_index])&&$blog_data2[$limit_width_index]>299)?$blog_data2[$limit_width_index]:'none';
	$slippry_top_control=($blog_data2[$slippry_top_control_index]==='notopcontrol')?false:true;
	$slippry_mid_control=($blog_data2[$slippry_mid_control_index]==='nomidcontrol')?false:true;
	$controltheme=($blog_data2[$controltheme_index]==='dark'||$blog_data2[$controltheme_index]==='med')?$blog_data2[$controltheme_index]:'light';
	$limitmax=(is_numeric($blog_data2[$limitmax_index])&&$blog_data2[$limitmax_index]>=90&&$blog_data2[$limitmax_index]<=100)?$blog_data2[$limitmax_index]:100;
	$main_menu=$blog_data2[$mainmenu_index]; 
	$mm_arr=explode('@@',$main_menu); 
	$main_menu_id_check=(array_key_exists(2,$mm_arr))?$mm_arr[2]:0; 
	$default_imagetitle=$this->blog_tiny_data4;
	$default_subtitle=$this->blog_tiny_data5;
	$default_description=$this->blog_data7;
	$shadowcalc=$this->calc_border_shadow($this->blog_tiny_data3); 
	$maxwidth_adjust_preview=100-$shadowcalc/3;//300 ~ min image width in px conv to %
	$shadowcalc=$this->calc_border_shadow($this->blog_tiny_data1);
	$adjust_previewspace=$shadowcalc/3;
	$maxwidth_adjust_expanded=(100-$shadowcalc/3)*.95;//300 ~ min image width in px conv to %
	$padleft=(is_numeric($blog_data2[$padleft_index])&&$blog_data2[$padleft_index]>=0&&$blog_data2[$padleft_index]<=60)?$blog_data2[$padleft_index]:5;
	$temp_arr=array();
	$thumb_width_type=($blog_data2[$thumb_width_type_index]==='width_height'||$blog_data2[$thumb_width_type_index]==='width'||$blog_data2[$thumb_width_type_index]==='height')?$blog_data2[$thumb_width_type_index]:(($this->master_gallery)?'width':'height'); 
	$thumbnail_height=($blog_data2[$thumbnail_height_index]>9.9)?$blog_data2[$thumbnail_height_index]:60;
   $thumbnail_height_rem=($blog_data2[$thumbnail_height_rem_index]>.09)?$blog_data2[$thumbnail_height_rem_index]:0; 
   $thumbnail_height_em=($blog_data2[$thumbnail_height_em_index]>.09)?$blog_data2[$thumbnail_height_em_index]:0;
   $final_thumbnail_height=(!empty($thumbnail_height_rem))?'height:'.$thumbnail_height_rem.'rem;':((!empty($thumbnail_height_em))?'height:'.$thumbnail_height_em.'em;':'height:'.$thumbnail_height.'px;');
   $thumbnail_height_min=($blog_data2[$thumbnail_height_min_index]>=5)?$blog_data2[$thumbnail_height_min_index]:0;
   $final_thumbnail_height_min=(!empty($thumbnail_height_min))?'min-height:'.$thumbnail_height_min.'px;':'';
	$thumbnail_pad_right=(is_numeric($blog_data2[$thumbnail_pad_right_index]))?$blog_data2[$thumbnail_pad_right_index]:5;
	$thumbnail_pad_bottom=(is_numeric($blog_data2[$thumbnail_pad_bottom_index]))?$blog_data2[$thumbnail_pad_bottom_index]:5;
	$preview_pad_bottom=(is_numeric($blog_data2[$preview_pad_bottom_index]))?$blog_data2[$preview_pad_bottom_index]:30;
	$preview_padtop=(is_numeric($blog_data2[$preview_padtop_index]))?$blog_data2[$preview_padtop_index]:30;
	$fixed_pad=(empty($blog_data2[$fixed_pad_index]))?false:true;
	$caption_vertical_align=($blog_data2[$caption_vertical_align_index]!=='middle'&&$blog_data2[$caption_vertical_align_index]!=='bottom')?'top':$blog_data2[$caption_vertical_align_index];
	 for ($i=1; $i<13; $i++){
		${'checked'.$i}='';	
		}
	$checked='checked="checked"';
	$slide=false;
	$slide_caption=false;
	$autorun=false;
	$caption_display=true;
	$slipcaption='custom';
	#gallswitch
	$imagecaptiontitle=false;
   switch ($blog_data2[$preview_index]) {
		case 'slide' :
		$gall_display='slippry';
		$preview_display='none';
		$show_under_preview=false;
		$checked7=$checked;
		$galltype='maintain';
		$slippry_mid_control=false;
		$slippry_top_control=false;
		$slide=true;
		$autorun=true;
		$caption_display=false;
		break;
		case 'slide_caption' :
		$gall_display='slippry';
		$preview_display='none';
		$show_under_preview=false;
		$checked6=$checked;
		$galltype='maintain';
		$slippry_top_control=false;
		$slippry_mid_control=false;
		$slipcaption='overlay';
		$slide=true;
		$slide_caption=true;
		$autorun=true;
		$caption_display=false;
		break;
		case 'expand_preview_multiple' :
		$gall_display='slippry';
		$preview_display='multiple';
		$show_under_preview=false;
		$checked1=$checked;
		$galltype='simulate';
		break;
		case 'expand_preview_single' :
		$gall_display='slippry';
		$preview_display='single';
		$show_under_preview=false;
		$checked2=$checked;
		$galltype='simulate';
		break; 
		case 'expand_preview_single_pic' : 
		$gall_display='slippry';
		$preview_display='singlepic';
		$show_under_preview=false;
		$checked3=$checked;
		$galltype='simulate';
		break; 
		case 'preview_under_expand': 
		$gall_display='slippry'; 
		$preview_display='none';
		$show_under_preview=true;
		$checked4=$checked;
		$galltype='maintain';
		break;
		case 'expand_preview_none':
		$gall_display='slippry';
		$preview_display='none';
		$show_under_preview=false;
		$checked5=$checked;
		$galltype='maintain';
		break;
		case 'photoswipe_multiple':
		$gall_display='photoswipe';
		$preview_display='multiple';
		$checked8=$checked;
		$show_under_preview=false;
		$galltype='simulate';// 
		break;
		case 'highslide_multiple':
		$gall_display='highslide';
		$preview_display='multiple';
		$checked10=$checked;
		$show_under_preview=false;
		$galltype='maintain';//not relevant
		break;
		case 'highslide_single' :
		$gall_display='highslide';
		$show_under_preview=false;
		$preview_display='single';
		$checked11=$checked;
		$galltype='maintain';//not relevant
		break; 
		case 'photoswipe_single_row' :
		$gall_display='photoswipe';
		$show_under_preview=false;
		$preview_display='single';
		$checked9=$checked;
		$galltype='simulate';// 
     $galltype='master';// 
		break;
		case 'multiple_image_caption' :
			#is master gall
		$imagecaptiontitle=true;
		$gall_display='multiple_image_caption';
		$preview_display='master';
		$show_under_preview=false; 
     $galltype='master';// 
		break;
		case 'multiple_hover_caption' :
			#is master gall
		$imagecaptiontitle=true;
		$gall_display='multiple_hover_caption';
		$preview_display='master';
		$show_under_preview=false; 
     $galltype='master';// 
		break;
		case 'rows_caption' :
			#is master gall
		$gall_display='rows_caption';
		$preview_display='master';
		$show_under_preview=false; 
          $galltype='master';// 
		break;
		case 'display_single_row' : 
			#is master gall
		$gall_display='display_single_row';
		$preview_display='single';
		$show_under_preview=false; 
		break; 
		case 'expand_preview_multiple' :
		$gall_display='slippry';
		$preview_display='multiple';
		$show_under_preview=false;
		$checked1=$checked;
		$galltype='simulate';
		break;
     default :
        if ($this->master_gallery){
          $gall_display='display_single_row';
          $preview_display='single';
          $show_under_preview=false;
          $galltype='master';// 
          }
        else { 
		$gall_display='photoswipe';
		$preview_display='multiple';
		$checked7=$checked;
		$show_under_preview=false;
		$galltype='simulate';// 
     }
		break; 
		} 
	$autorun=($slippry_force_auto)?true:$autorun;
	$galltype=($gall_display==='slippry'&&($slippry_maintain==='maintain'||$slippry_maintain==='simulate'))?$slippry_maintain:$galltype; 
	switch ($controltheme) {
		case 'light':
			$controlcolor="fff";
			$controlbar = ($gall_display==='photoswipe')?'default-skin.png':'controlbar-white.gif';
			break;
		case 'med':
			$controlcolor="cdced2";
			$controlbar = ($gall_display==='photoswipe')?'med-skin.png':'controlbar-white.gif';
			break;
		case 'dark':
			$controlcolor="000";
			$controlbar = ($gall_display==='photoswipe')?'dark-skin.png':'controlbar-black-border.gif';
			break;
		default : 
			$controlcolor="fff";
			$controlbar = 'controlbar-white.gif';
			break;
			}
	for ($i=1; $i<7; $i++){
		${'expandchecked'.$i}='';
		} 
	$display_float='inlineblock_'.$this->blog_id.'';//for master gall mode display single
	//galltype does some double duty having diff default values for master gallery and for normal gallery
	if ($this->master_gallery){
		$galltype=($blog_data2[$galltype_index]==='float')?'float':'center';
		
		}
   $new_page_effect=false;
	#galltype no longer a choice but now a condition.. 
	switch ($galltype) { 
		case 'simulate' :
		$new_page_effect=true;
		$expandchecked1=$checked;
		break;
		case 'maintain':
		$new_page_effect=false;
		$expandchecked2=$checked;
		break; 
		case 'new' :
		$transition='fade';
		$expandchecked3=$checked;
		$new_page_effect=false;
		break; 
		case 'float' : //for master gallery
		$transition='none';
		$new_page_effect=false;
		$expandchecked5=$checked;
		break;
		case 'center' : 
		$display_float='marginauto';
		$transition='none';
		$new_page_effect=false;
		$expandchecked6=$checked;
		break; 
		}  	
	if ($this->master_gallery&&$display_float!=='marginauto') 
		$expandchecked5=$checked; 
	 
	if ($this->edit&&($this->clone_local_style||!$this->is_clone)){
		printer::pclear(5); 
		printer::alertx('<p class="info fsminfo editbackground editfont infoback rad5 floatleft maroonshadow left">All Configurations Changes Will Be Updated Immediately Provided the Original Uploaded Photos are sufficiently Large to Adjust to any Image width changes</p>');
		printer::pclear(5);
		if (!$this->master_gallery){ 
			$this->show_more('Configure Your Gallery Display','','','',700,'','float:left;',true);#<!--Configure gallery-->
			printer::print_wrap('config Gallery');
        echo '<div class="'.$this->column_lev_color.' fs1color floatleft editbackground editfont left" ><!--config gall settings-->';
			 
			echo '<div class="fsmmaroon floatleft left maroon" style="background:#c6a5a5;" > <span class="bold whiteshadow">The open source Slippry, Photoswipe, and Highslide projects offer 3 different gallery presentation options for expanded closeup views of images and captions. For extensive captions Slippry is best option.</span><!--gall display setting-->';
			printer::pclear(7); 
			echo '<div class="maroon fs2maroon floatleft left" style="background:#dccbcb;"><!--Expand Gallery display setting-->';
			printer::print_tip('Slippry Gallery works well with special height effects');
			printer::alert('These first 7 Choices utilize the Slippry Gallery Project:',false,'whitebackground center bold fs1maroon'); 
			echo '<div class="maroon fs1maroon floatleft left" style="background:#dccbcb;" ><!--separate preview Expand Gallery display setting--> ';
			printer::print_custom_wrap('separate preview page','maroon','whitebackground maroon');
			printer::print_tip('Choice for separate preview images page display. When clicked the gallery slideshow expands to simulate new page');
			printer::printx('<p class="bold">1.<input type="radio" value="expand_preview_multiple" name="'.$data.'_blog_data2['.$preview_index.']" '.$checked1.'>Choose Slippry with Multiple Preview Images Per Row for Separate Preview Display.</p>');
			printer::printx('<p class="bold">2.<input type="radio" value="expand_preview_single_row" name="'.$data.'_blog_data2['.$preview_index.']" '.$checked2.'>Choose Slippry with a Single Preview Images Per Row for Separate Preview Display </p>');
			printer::printx('<p class="bold">3.<input type="radio" value="expand_preview_single_pic" name="'.$data.'_blog_data2['.$preview_index.']" '.$checked3.'>Choose Slippry with one Preview Image only to open into full gallery </p>');
			printer::close_print_wrap('separate preview page'); 
			printer::pclear(15); 
			printer::print_custom_wrap('preview under or none sub choices','maroon','whitebackground maroon');
			//$this->print_wrap('preview under or none sub choices','fsmmaroon');
			printer::print_tip('The following four choices display in normal page context');
			printer::printx('<p class="bold">4.<input type="radio" value="preview_under_expand" name="'.$data.'_blog_data2['.$preview_index.']" '.$checked4.'>Choose Slippry full set of small Preview Images Under the Expanded Image Gallery</p>'); 
			printer::printx('<p class="bold">5.<input type="radio" value="expand_preview_none" name="'.$data.'_blog_data2['.$preview_index.']" '.$checked5.'>Choose Slippry with No Preview Images </p>');
			printer::print_custom_wrap('slide_show','maroon','lightestmaroonbackground maroon');
			printer::print_tip('Use Slippry slide show Mode. Slide show mode differs from gallery mode by running automatically with no controls at top nor within the image, no preview images, no captions below the image with only a short title caption (if mini chosen and added) inset into images.'); 
			printer::printx('<p class="bold">6.<input type="radio" value="slide_caption" name="'.$data.'_blog_data2['.$preview_index.']" '.$checked6.'>Choose Slippry with Auto slide Show Mode with mini captions within photo</p>'); 
			printer::printx('<p class="bold">7.<input type="radio" value="slide" name="'.$data.'_blog_data2['.$preview_index.']" '.$checked7.'>Choose Slippry with Auto slide Show Mode No captions</p>');
			printer::pclear(5);
			
			printer::close_print_wrap('slide_show'); 
			printer::close_print_wrap('preview under or none sub choices');
			printer::pclear(10); 
			echo '<div class="fsmlightred marginauto center inline-table" style="width:70%; background: rgba(255,255,255,.5);" ><!--Choose Transition Type--><p class="center small bold">Choose Slippry Gallery Transition:<span class="smallest"> <br>(for all the above choices)</span></p>';
			$trans_arr=array('fade','kenburns','vertical','horizontal');
			for ($i=0; $i<4; $i++){
				$msg=($trans_arr[$i]==='kenburns')?'kenburns (Magnifies and moves image)':$trans_arr[$i];
				${'checked'.$i}=($trans_arr[$i]===$transition)?'checked="checked"':'';
				printer::printx('<p class="left"> <input type="radio" value="'.$trans_arr[$i].'" name="'.$data.'_blog_data2['.$transition_index.']" '.${'checked'.$i}.'>&nbsp;'.$msg.'&nbsp;</p>');
				}
			printer::pclear(10);
			echo '<div class="fsmmaroon whitebackground maroon"><!--wrap transtime-->';
			printer::printp('Set the transition time in which fading, vertical or horizontal change takes place. Ken Burns timing not affected use Pause time instead');
			$this->mod_spacing($data.'_blog_data2['.$transition_time_index.']',$transition_time,.2,5,.2,'secs');
			printer::pclear(5);
			printer::printp('Set the pause time between slide change when play is clicked. Will also determine the transition time of kenburns effect in manual mode');
               printer::pclear(5);
			
			$this->mod_spacing($data.'_blog_data2['.$pause_index.']',$pause,3,30,.5,'secs');
               printer::pclear(5);
			echo '</div><!--wrap transtime-->';
			echo '</div><!--Choose Transition Type-->';
        printer::pclear(4);
        printer::pclear(15);
			if ($limitmax < 100&&$gall_display==='slippry')printer::print_warn('Note: Slippry Option for Limit Max width of large expanded image set to '.$limitmax.'%',.7);
			$this->show_more('More Slippry Options: Max Width/Height Expand Image, Slippry Modes &amp; Styling/Use of control Icons','','buttonmaroon whitebackground maroon');
			printer::print_wrap('slippry wrap');
			printer::print_wrap('auto slippry','fsmmaroon whitebackground maroon');
			printer::print_tip('By default slippry gallery choices 1-3 will display expanded images by simulating a new page where as choices 4-7 will maintain the original page context including all other posts and navigation menu(s). You can change the default maintain/simulate here.');
				 
			$checked='checked="checked"';
			$checked1=($blog_data2[$slippry_maintain_index]==='maintain')?$checked:'';
			$checked2=($blog_data2[$slippry_maintain_index]==='simulate')?$checked:'';
			$checked3=($blog_data2[$slippry_maintain_index]!=='simulate'&&$blog_data2[$slippry_maintain_index]!=='maintain')?$checked:'';
			echo '<div class="'.$this->column_lev_color.' fsminfo editbackground editfont floatleft left"> <!--imagecontrol bar-->
			<p><input type="radio" name="'.$data.'_blog_data2['.$slippry_maintain_index.']" '.$checked1.' value="maintain">&nbsp;Maintain page context of gallery</p>
			<p><input type="radio" name="'.$data.'_blog_data2['.$slippry_maintain_index.']" '.$checked2.' value="simulate">Simulate New Page</p>
			<p><input type="radio" name="'.$data.'_blog_data2['.$slippry_maintain_index.']" '.$checked3.' value="defaultgalpagecontext">&nbsp;Use Default Mode for galltype</p>
			 </div><!--imagecontrol bar-->';
        #######################
        printer::pclear(5);
        $this->show_more('Style Slippry Top Gallery Control Bar','','fs2info rad5 editbackground editfont editcolor left5 right5');
        printer::print_wrap('wrap control bar');
			printer::print_tip('Choose Color for slippry Top Control Bar (forward,next,play,pause, etc) Icons or if used Highslide the in-image control bar.');
			printer::alertx('<p class="left editbackground editfont editcolor">Choose Control Bar Color: #<input onclick=" window.jscolor(this);" style="cursor:pointer;background:#'.$this->editor_background.';color:#'.$this->editor_color.';" type="text" name="'.$data.'_blog_data2['.$slipbar_color_index.']." id="'.$this->blog_table.'_'.$this->blog_order.'controlbarcolor" value="'.$slipbar_color.'" size="6" maxlength="6" class="jscolor {refine:false}"><span style="font-size: 1.1em; color:#'.Cfg::Info_color.';" id="'.$this->blog_table.'_'.$this->blog_order.'controlbarcolorinstruct"></span></p>');
			printer::pclear();
        printer::print_tip('Choose Relative Size of Top Control Bar Icons for this gallery (will keep icon width and height proportional).');
        $this->mod_spacing($data.'_blog_data2['.$slipbar_size_index.'][0]',$slipbar_size,.3,10,.1,'em','none');
        printer::print_tip('Icon Size Width and Height will scale proportionately to width and activated scaling (responsive to viewport width) if enabled here.');
       $this->rwd_scale($blog_data2[$slipbar_size_index],$data.'_blog_data2['.$slipbar_size_index.']',"#$this->dataCss .slipcontrol_$this->blog_id",'font-size','Gallery Control panel Icon Size','px',0,1,false,16,20); 
			$this->submit_button();
        printer::close_print_wrap('wrap control bar');
        $this->show_close('Style Gallery Control Bar Used by Slippry and Highslide');
        ##############
        printer::pclear(5);
        $this->show_more('Choose Return Menu Icon for Simulated New Page Mode','noback','fs2info rad5 editbackground editfont editcolor left5 right5','',500);
			printer::print_wrap('Choose Return Menu Icon');
        echo '<div class="fsminfo whitebackground " ><!--link color--><br>';
			printer::print_tip('Choose Color for slippry Return Icon when viewing expanded images in simulated new page mode.'); 
printer::pclear(5);
        echo '<div class="fsminfo whitebackground " ><!--link color--><br>'; 
        printer::alertx('<p class="left editbackground editfont editcolor">Change the Menu Icon Color: #<input onclick=" window.jscolor(this);" style="cursor:pointer;background:#'.$this->editor_background.';color:#'.$this->editor_color.';" type="text" name="'.$data.'_blog_data2['.$gall_icon_color_index.']." id="'.$this->blog_table.'_'.$this->blog_order.'expandiconcolor" value="'.$gall_expand_menu_icon.'" size="6" maxlength="6" class="jscolor {refine:false}"><span style="font-size: 1.1em; color:#'.Cfg::Info_color.';" id="'.$this->blog_table.'_'.$this->blog_order.'expandiconcolorinstruct"></span></p>');
			printer::pclear();
			echo '</div><!--link color-->';
        printer::print_wrap('choose position');
        $checked1=($blog_data2[$position_menu_icon_index]==='left')?'checked="checked"':'';
        $checked2=($blog_data2[$position_menu_icon_index]==='left')?'':'checked="checked"';
        printer::alert('<input type="radio" value="left" name="'.$data.'_blog_data2['.$position_menu_icon_index.']." '.$checked1.'>Position icon to Left');
        printer::alert('<input type="radio" value="right" name="'.$data.'_blog_data2['.$position_menu_icon_index.']." '.$checked2.'>Position icon to Right');
        printer::close_print_wrap('choose position');
        printer::print_tip('Change Relative Size of Top Return Menu Icon for this gallery (will keep width and height proportional).');
        $this->mod_spacing($data.'_blog_data2['.$return_icon_size_index.'][0]',$return_icon_size,.3,10,.1,'em','none');
        printer::print_tip('Return Icon Size Width and Height will scale proportionately to width changes and activated scaling (responsive to viewport width) if enabled here.');
        if(!empty($return_icon_size))$this->css.="
        #$this->dataCss .expand-menu-icon { font-size:{$return_icon_size}em; }";
       $this->rwd_scale($blog_data2[$return_icon_size_index],$data.'_blog_data2['.$return_icon_size_index.']',"#$this->dataCss .expand-menu-icon",'font-size','Expanded Image Menu Return Icon Size','px',0,1,false,16,20); 
        echo '</div><!--link color--><br>';
			$this->submit_button();
			printer::close_print_wrap('Choose Return Menu Icon');
        $this->show_close('Choose Color For Expanded Images Return Navigation Icon');
			printer::pclear(4);	 
			printer::close_print_wrap('auto slippry'); 
			echo '</div><!--separate preview Expand Gallery display setting--> ';
        ##############
       ############## slippry opts 
			echo '<div class="'.$this->column_lev_color.' fsminfo editbackground editfont floatleft left"> <!--limitmax-->';
			printer::print_tip('Using 95-97% will show off the shadowbox border effect in use');
			echo 'Adjust whether the maximum width of slippry gallery/slide images go to 100% of the post width or less. This option is to allow for box shadows to show to the left and right when the image is full screen or just to show some space. However, To limit the pixel size of the expanded gallery image to less than the available post space use the limit width options below. <p>';
			$this->mod_spacing($data.'_blog_data2['.$limitmax_index.']',$limitmax,90,100,1,'%','none');
			echo '</div><!--limitmax-->';
			printer::pclear();
			printer::pclear(5); 
			echo '<div class="'.$this->column_lev_color.' fsminfo editbackground editfont floatleft left">Configure your Expanded Gallery image size. Enter a maximum width or height (which ever is greater) for your image. For <b>simulated new pages</b> Image Width will be limited by this setting or the page width whereas for <b>maintain page context</b>options Image width will be limited by the current gallery post width or this value which ever is less.  <!--wpplus-->';
			$this->mod_spacing($data.'_blog_data2['.$largepic_index.']',$largepicplus,125,3000,5,'px');// 
			echo '</div><!---wfplus-->';
			
		######## slippry specific #############
		$checked='checked="checked"';
			$checked1=($blog_data2[$slippry_top_control_index]!=='notopcontrol')?$checked:'';
			$checked2=($blog_data2[$slippry_top_control_index]==='notopcontrol')?$checked:'';
			printer::print_wrap('controls','fsmmaroon');
			printer::print_tip('Using Slippry in Slide Show Mode disables the controls and sets the slide on show on automatic');
			
			echo '<div class="'.$this->column_lev_color.' fsminfo editbackground editfont floatleft left"> <!--imagecontrol bar-->
			
			Enable/Disable Top Gallery controls for Slippry<p><input type="radio" name="'.$data.'_blog_data2['.$slippry_top_control_index.']" '.$checked1.' value="topcontrol">&nbsp;Enable Top Gall Control Bar</p>
			<p><input type="radio" name="'.$data.'_blog_data2['.$slippry_top_control_index.']" '.$checked2.' value="notopcontrol">&nbsp;Disable Gall Top Control Bar</p>
			 
			 </div><!--imagecontrol bar-->';
			printer::pclear(4); 
			$checked='checked="checked"';
			$checked1=($blog_data2[$slippry_mid_control_index]!=='nomidcontrol')?$checked:'';
			$checked2=($blog_data2[$slippry_mid_control_index]==='nomidcontrol')?$checked:'';
			echo '<div class="'.$this->column_lev_color.' fsminfo editbackground editfont floatleft left"> <!--imagecontrol bar-->
			Enable/Disable Gall middle Navigation Icon for slippry<p><input type="radio" name="'.$data.'_blog_data2['.$slippry_mid_control_index.']" '.$checked1.' value="midcontrol">&nbsp;Enable Gall middle Nav Icon</p>
			<p><input type="radio" name="'.$data.'_blog_data2['.$slippry_mid_control_index.']" '.$checked2.' value="nomidcontrol">&nbsp;Disable middle Nav Icon</p>
			 
			 </div><!--imagecontrol bar-->';
			printer::close_print_wrap('controls');
			printer::pclear(4);
			printer::print_wrap('auto slippry','fsmmaroon whitebackground maroon');
			printer::print_tip('By default slippry in Gallery mode will show controls and not start off to Automatically Run through Gallery. You can choose to choose to automatically run through gallery images here.');
			
			$checked='checked="checked"';
			$checked1=($blog_data2[$slippry_force_auto_index]==='forceauto')?$checked:'';
			$checked2=($blog_data2[$slippry_force_auto_index]!=='forceauto')?$checked:'';
			echo '<div class="'.$this->column_lev_color.' fsminfo editbackground editfont floatleft left"> <!--imagecontrol bar-->
			<p><input type="radio" name="'.$data.'_blog_data2['.$slippry_force_auto_index.']" '.$checked1.' value="forceauto">&nbsp;Auto Run Slippry Gallery</p>
			<p><input type="radio" name="'.$data.'_blog_data2['.$slippry_force_auto_index.']" '.$checked2.' value="noforceauto">&nbsp;Disable Auto Run Slippry Gallery</p>
			 
			 </div><!--imagecontrol bar-->';
			printer::close_print_wrap('auto slippry');
			printer::pclear(4); 
			$this->submit_button();
			printer::close_print_wrap('slippry wrap');
			$this->show_close('More Options Affecting Slippry');
			printer::pclear(4);
			echo '</div><!--Expand Gallery display setting--> '; 
			###############################3
			printer::pclear(15);
			echo '<div class="maroon fs2maroon floatleft left" style="background:#dccbcb;"><!--photoswipe display setting-->';
			printer::alert('The next three Utilize the Photoswipe Gallery Project:',false,'whitebackground center bold fs1maroon');
			
			printer::printx('<p class="bold">8.<input type="radio" value="photoswipe_multiple" name="'.$data.'_blog_data2['.$preview_index.']" '.$checked8.'>Display  Multiple Preview Images Per Row</p>');
			printer::printx('<p class="bold">9.<input type="radio" value="photoswipe_single_row" name="'.$data.'_blog_data2['.$preview_index.']" '.$checked9.'>Display  Single Preview Image Per Row</p>');
			printer::pclear(5);
        
			printer::pclear(10); 
				############################
			$this->show_more('Photoswipe Options','','buttonmaroon whitebackground maroon');
        #photoswipe options
			printer::print_wrap('photoswipe info'); 
			printer::print_wrap1('photoswipe color','maroon');
			printer::print_tip('Change Photoswipe Bottom Color (ie captions) if used ');
        
			printer::alertx('<p class="left editbackground editfont editcolor">Optionally choose Photoswipe Top Control Background Color<input onclick=" window.jscolor(this);" style="cursor:pointer;background:#'.$this->editor_background.';color:#'.$this->editor_color.';" type="text" name="'.$data.'_blog_data2['.$photoswipe_topcontrol_background_index.']" value="'.$photoswipe_topcontrol_background.'" size="6" maxlength="6" class="jscolor {refine:false}"></p>');
			printer::alertx('<p class="left editbackground editfont editcolor">Optionally choose Photoswipe Prev Next Control Background Color<input onclick=" window.jscolor(this);" style="cursor:pointer;background:#'.$this->editor_background.';color:#'.$this->editor_color.';" type="text" name="'.$data.'_blog_data2['.$photoswipe_prevnext_background_index.']" value="'.$photoswipe_prevnext_background.'" size="6" maxlength="6" class="jscolor {refine:false}"></p>'); 
			printer::alertx('<p class="left editbackground editfont editcolor">Optionally choose Photoswipe Caption Background Color<input onclick=" window.jscolor(this);" style="cursor:pointer;background:#'.$this->editor_background.';color:#'.$this->editor_color.';" type="text" name="'.$data.'_blog_data2['.$photoswipe_caption_background_index.']" value="'.$photoswipe_caption_background.'" size="6" maxlength="6" class="jscolor {refine:false}"></p>'); 
			printer::close_print_wrap1('photoswipe color');
			###############
			printer::print_wrap('photoswipe control icons');
			 
			$checked='checked="checked"';
        $checked1=($blog_data2[$controltheme_index]!=='dark'&&$blog_data2[$controltheme_index]!=='med')?$checked:'';
        $checked2=($blog_data2[$controltheme_index]==='med')?$checked:'';
        $checked3=($blog_data2[$controltheme_index]==='dark')?$checked:'';
        echo '<div class="'.$this->column_lev_color.' fsminfo lightestmaroonbackground maroon floatleft left"> <!--highslide control bar-->
        Choose Light or Dark Gallery control Icons<p><input type="radio" name="'.$data.'_blog_data2['.$controltheme_index.']" '.$checked1.' value="light">&nbsp;Light Theme Control Bar</p>
        <p><input type="radio" name="'.$data.'_blog_data2['.$controltheme_index.']" '.$checked2.' value="med">&nbsp;Med Gray Theme Control Bar</p>
        <p><input type="radio" name="'.$data.'_blog_data2['.$controltheme_index.']" '.$checked3.' value="dark">&nbsp;Dark Gray Theme Control Bar</p>
        </div><!--photoswipe control bar-->';
        printer::close_print_wrap('photoswipe control icons');
        ################ 
			printer::close_print_wrap('photoswipe info');
        $this->submit_button();
			$this->show_close('Photoswipe Option Info');
			printer::pclear(5);
			echo '</div><!--photoswipe display setting-->';
			printer::pclear(15); 
			echo '<div class="maroon fs2maroon floatleft left" style="background:#dccbcb;"><!--highslide display setting-->';
			printer::alert('The next two Utilize the Highslide Gallery Project:',false,'whitebackground center bold fs1maroon'); 
			printer::printx('<p class="bold">10.<input type="radio" value="highslide_multiple" name="'.$data.'_blog_data2['.$preview_index.']" '.$checked10.'>Display with Multiple Representative Images Per Row</p>');
			printer::printx('<p class="bold">11.<input type="radio" value="highslide_single" name="'.$data.'_blog_data2['.$preview_index.']" '.$checked11.'>Display with a Single Image Per Row</p>');
			printer::pclear(5); 
			$this->show_more('Highslide Options','','buttonmaroon whitebackground maroon');
			printer::print_wrap('highlside info');
			printer::alert('Highslide gallery utilizes iframes that make it difficult to add further customization options. It make work as is for you as is otherwise we recommend slippry or photoswipe');
			$checked='checked="checked"';
            $checked1=($blog_data2[$controltheme_index]!='dark')?$checked:'';
            $checked2=($blog_data2[$controltheme_index]==='dark')?$checked:'';
            echo '<div class="'.$this->column_lev_color.' fsminfo lightestmaroonbackground maroon floatleft left"> <!--highslide control bar-->
            Choose Light or Dark Gallery controls<p><input type="radio" name="'.$data.'_blog_data2['.$controltheme_index.']" '.$checked1.' value="light">&nbsp;Light Theme Control Bar</p>
        <p><input type="radio" name="'.$data.'_blog_data2['.$controltheme_index.']" '.$checked2.' value="dark">&nbsp;Dark Theme Control Bar</p>
        </div><!--highslide control bar-->';
        printer::close_print_wrap('highlside info');
			$this->show_close('Highslide Option Info');
			echo '</div><!--highslide display setting-->'; 
			printer::pclear();
			echo '<div class="maroon fs2maroon floatleft left" style="background:#dccbcb;"><!--outer wrap more expand-preview display settings-->';
			printer::pspace(10); 
			printer::pclear(5);	
			$this->show_more('Adjusting Separate Page Multiple Images Per Row','','buttonmaroon lightestmaroonbackground maroon','Style/Config an initial Preview Images Page if Selected'); 
			$this->print_wrap('Adjust Separate','maroon');
			printer::print_wrap1('wrap flex-box','maroon');
        $checked='checked="checked"';
        $checked1=($gall_flex)?'':$checked;
        $checked2=($gall_flex)?$checked:'';
        ($gall_flex)&&printer::print_info('Active preview image Flex Mode will override Masonry');
        printer::print_tip('Optionally enable flex box for layout of multiple preview images.');
			printer::printx('<p><input type="radio" '.$checked1.' value="noflex" name="'.$data.'_blog_data2['.$gall_flex_index.']">No Flex Box</p>');
			printer::printx('<p><input type="radio" '.$checked2.' value="gall_flex" name="'.$data.'_blog_data2['.$gall_flex_index.']">Enable Flex Box Positioning</p>');
			
			printer::close_print_wrap1('wrap flex-box' );
			printer::print_wrap1('wrap flex-box','maroon');
        $checked='checked="checked"';
        $checked2=($gall_masonry)?$checked:'';
        $checked1=(($gall_masonry))?'':$checked;
        printer::print_tip('Optionally enable Masonry to Assist in grid Layout of multiple preview images.');
			printer::print_tip('Masonry if enabled can potentially change the order of your preview images to get the best fit');
			printer::printx('<p><input type="radio" '.$checked1.' value="nomasonry" name="'.$data.'_blog_data2['.$gall_masonry_index.']">No Masonry</p>');
			printer::printx('<p><input type="radio" '.$checked2.' value="gall_masonry" name="'.$data.'_blog_data2['.$gall_masonry_index.']">Use Masonry Assist</p>'); 
			printer::close_print_wrap1('wrap masonry' );
			echo '<div class="fs2info editbackground editfont"><!--border previews-->'; 
			
			echo '<div class="fsminfo editbackground editfont '.$this->column_lev_color.' floatleft editfont maxwidth500"><!--preview image spacing-->
			Change default spacing between images when choosing multiple display:'; 
			printer::alert('Choose your Preview Side Spacing Setting:');
			$this->mod_spacing($data.'_blog_data2['.$padleft_index.']',$padleft,0,60,1,'px');
			echo '</div><!--preview image spacing-->';
			printer::pclear();
			echo '<div class="fsminfo editbackground editfont editcolor floatleft">Choose the Spacing Between the rows of Preview Images:';
			$this->mod_spacing($data.'_blog_data2['.$preview_pad_bottom_index.']',$preview_pad_bottom,0,175,1,'px');
			echo '</div>';
			printer::pclear();
			echo '<div class="fsminfo editbackground editfont '.$this->column_lev_color.' floatleft editfont maxwidth500"><!--final width adjust gal--> 
			 Additionally set a maximum width of the available preview presentaion space to narrow the gallery on and create more unused space on the end of the each preview row. This also effects the number of preview images in a multiple images in a row option is chosen. The final width will be determined which ever is smallest: the overall post width, the width you set here or the viewers view screen! <br>'; 
			printer::alert('Final Width Adjust Gallery Preview:');
			$this->mod_spacing($data.'_blog_data2['.$limit_width_index.']',$limit_width,300,1000,1,'px','none');
			echo '</div><!--Edit Final Width Adjust Preview Gall-->'; 
			printer::pclear();
			echo '</div><!--border previews-->';
        $this->submit_button();
			$this->close_print_wrap('Adjust Separate','maroon');
			$this->show_close('Adjusting preview Page with Multiple Preview Image Rows');
			printer::pspace(10);
			$this->show_more('Further Adjust Separate Page Preview Images','','buttonmaroon lightestmaroonbackground maroon','Style/Config an initial Preview Images Page if Selected',500);
			$msg=($this->master_gallery)?'By Default Your Master Gallery Representative Images are equal width but you can choose Equal height/width Depending which is greater': 'By Default Gallery Preview Page Images (if used) are set to a maximum height/width depending which is greater but theres a choice for equal width instead';
			echo '<div class="'.$this->column_lev_color.' fsminfo editbackground editfont floatleft left"><!--wpplus-->';
			printer::printx('<p>'.$msg.'</p>');
			$checked1=($thumb_width_type==='width')?'checked="checked"':'';
			$checked2=($thumb_width_type==='width_height')?'checked="checked"':'';
			$checked3=($thumb_width_type!=='width'&&$thumb_width_type!=='width_height')?'checked="checked"':'';
			printer::printx('<p><input type="radio" '.$checked3.' value="height" name="'.$data.'_blog_data2['.$thumb_width_type_index.']">Choose Equal Height Setting</p>');
			printer::printx('<p><input type="radio" '.$checked1.' value="width" name="'.$data.'_blog_data2['.$thumb_width_type_index.']">Choose Equal Width Setting</p>');
			printer::printx('<p><input type="radio" '.$checked2.' value="width_height" name="'.$data.'_blog_data2['.$thumb_width_type_index.']">Choose Max Width/Height Setting</p>');
			echo '</div><!---prev image size-->';
			echo '<div class="'.$this->column_lev_color.' fsminfo editbackground editfont floatleft left">Configure your preview image size for separate preview image displays <b>For the preview under slide images go to the slippry option for that</b>. Enter the max value for width or height for your image (Scaled down Images will be used for Smaller devices)<!--prev image size-->';
			$this->mod_spacing($data.'_blog_data2['.$smallpic_index.']',$smallpicplus,50,1000,5,'px');// 
			echo '</div><!---wfplus-->';
			printer::pclear(5);
			################
			echo '<div class="'.$this->column_lev_color.' fsminfo editbackground editfont floatleft left"><!--wpplus-->';
			printer::print_tip('Enable Percent to allow smaller preview images on smaller screen sizes without breaking to a new row. Choose a percent compression. For example, if 4 preview images just fit on a large screen and the setting is changed to 50%, then 4 images would fit on a screen 50% as wide and be half the size. On still smaller screens images would break to three on a row. A default compression of 70% is used. Use none to display all preview images to the full width you choose above or the full screen width whichever is smaller');
			printer::printp('Enable Preview Percent & set Maximum Compression of Preview Images');
			$this->mod_spacing($data.'_blog_data2['.$preview_minimum_index.']',$preview_minimum,10,90,1,'%','none');// 
        $this->submit_button();
			echo '</div><!---wfplus-->';
			$this->show_close('Adjust Separate Preview Image Display');
			printer::pclear(7); 
			$this->show_more('Slippry Preview Under Slide Selection','noback','buttonmaroon lightestmaroonbackground maroon','Style/Config the Preview Images under a Gallery if Selected',500);
			echo '<div class="fs2info"><!--border previews-->';
			echo '<div class="fsminfo editbackground editfont '.$this->column_lev_color.' floatleft editfont maxwidth500"><!--preview image spacing-->
			If you have chosen the slippry option for previewing images under the slippry slide show change the default sizing and spacing of your preview images here'; 
			printer::alertx('<p class="fs1info">Choose the Spacing Above the first Row of Preview Images:</p>');
			$this->mod_spacing($data.'_blog_data2['.$preview_padtop_index.']',$preview_padtop,0,135,1,'px');
        printer::print_wrap('preview under height wrap');
        printer::print_tip('Choose one of the 3 following height units (em px andrem) and optionally choose a min-height (px) for you preview under slide image height. Rem height units will override em units which will override px units');
        printer::alertx('<p class="fs1info">Choose a Height unit and value for your Preview Images:</p>');
			printer::alertx('<p class="fs1info">Choose Height px:</p>');
			$this->mod_spacing($data.'_blog_data2['.$thumbnail_height_index.']',$thumbnail_height,10,200,1,'px','none');
			printer::alertx('<p class="fs1info">Choose Height em:</p>');
			$this->mod_spacing($data.'_blog_data2['.$thumbnail_height_em_index.']',$thumbnail_height_em,0,20,.1,'em','none'); 
			printer::alertx('<p class="fs1info">Choose Height rem:</p>');
			$this->mod_spacing($data.'_blog_data2['.$thumbnail_height_rem_index.']',$thumbnail_height_rem,0,20,.1,'rem','none'); 
			printer::alertx('<p class="fs1info">Choose Min Height px: Works with the above height choices to limit the final width on smaller screen sizes.</p>');
			$this->mod_spacing($data.'_blog_data2['.$thumbnail_height_min_index.']',$thumbnail_height_min,0,200,1,'px','none'); 
        printer::close_print_wrap('preview under height wrap');
			printer::alertx('<p class="fs1info">Choose the Side Spacing Between your Preview Images:</p>');
			$this->mod_spacing($data.'_blog_data2['.$thumbnail_pad_right_index.']',$thumbnail_pad_right,0,35,1,'px'); 
			printer::alertx('<p class="fs1info">Choose the Spacing Between rows of Preview Images:</p>');
			$this->mod_spacing($data.'_blog_data2['.$thumbnail_pad_bottom_index.']',$thumbnail_pad_bottom,0,35,1,'px'); 
			echo '</div><!--preview image spacing-->';
        $this->submit_button();
			echo '</div><!--border previews-->';
			$this->show_close('Slippry Preview Under Slide Selection'); 
			printer::pclear(4);	 
			printer::pclear(5);
			##################################
				$this->show_more('Adjust Expanded Image Quality','noback','buttonmaroon lightestmaroonbackground maroon','Expanded image quality may be adjusted for better quality versus smaller image size',450);
			printer::print_wrap('Adjust Expanded');
        echo'<div class="floatleft editbackground editfont fsminfo highlight" title="By Default Expanded Gallery Images will have a Default Quality factor with 100 being the highest and 10 the lowest. The higher the image quality the larger the filesize and the slower the download speed. Its possible to change the Default value in the Page Configuration options which will effect all cache images on the site that are not specifically configured for this value in the post type: image, slideshow, or gallery configurations" ><!--quality image-->Change Current Image Quality setting:';
			$this->mod_spacing($data.'_blog_data2['.$image_quality_index.']',$quality,10,100,1,'%');
			printer::print_info('Expanded Images will auto reload @ new Quality setting');
			echo'</div><!--quality image-->';
			printer::close_print_wrap('Adjust Expanded');
       printer::pclear();//Change Current Image Quality settin
			$this->show_close('Adjust Expanded Image Quality');
			
			echo '</div><!--outer wrap more expand-preview display settings-->';
			printer::pclear(7);
			$this->submit_button();
			printer::pclear(7);
			echo '</div><!--gall display setting-->';
			 $this->submit_button(); 
			echo '</div><!--config gall settings-->';
			printer::close_print_wrap('config Gallery');
        $this->show_close('Configure Your Gallery Display');#<!--Configure gallery-->
			 
			}//not master_gall
		else { // is Master Gallery 
			$checked='checked="checked"';
			$checked1=($blog_data2[$preview_index]==='rows_caption')?$checked:'';
			$checked2=($blog_data2[$preview_index]==='multiple_image_caption')?$checked:'';
			$checked3=($blog_data2[$preview_index]==='multiple_hover_caption')?$checked:'';
			$checked4=($blog_data2[$preview_index]!=='rows_caption'&&$blog_data2[$preview_index]==='multiple_image_caption'&&$blog_data2[$preview_index]==='multiple_hover_caption')?$checked:'';
			$this->show_more('Configure Your Master Gallery Display','','','',700,'','float:left;',true);#<!--Configure gallery--> 
			echo '<div class="fsmmaroon maroon floatleft lightmaroonbackground left "><!--config gall settings-->';
			################33
			echo '<div class="fsmmaroon floatleft left maroon" style="background:#c6a5a5;" > <span class="bold whiteshadow">Choose One of the following Choices of Display type for the Gallery Collection Preview Image Link and Caption</span><!--Master gall display setting-->';
			printer::pclear(7);
			echo '<div class="maroon fs2maroon floatleft left" style="background:#dccbcb;"><!--highslide display setting-->';
			echo '<div class="fs1maroon lightermaroonbackground " ><!--wrap float caption choice-->';
			printer::printx('<p class="">1.<input type="radio" value="rows_caption" name="'.$data.'_blog_data2['.$preview_index.']" '.$checked1.'>Preview with Multiple Images Per Row with optional title/subtitle/description Captions Under photo</p>');
			
			printer::printx('<p class="">2.<input type="radio" value="multiple_image_caption" name="'.$data.'_blog_data2['.$preview_index.']" '.$checked2.'>Multiple Images Per Row with title/SubTitle caption option inside the image</p>');
			
			printer::printx('<p class="">3.<input type="radio" value="multiple_hover_caption" name="'.$data.'_blog_data2['.$preview_index.']" '.$checked3.'>Multiple Images Per Row with Hover Title/SubTitle within image(Hovers on non touchscreen devices and displays by default on touchscreen devices)</p>');
			 
			echo '</div><!--wrap float caption choice-->';
			echo '<div class="fs1maroon lightermaroonbackground "><!--wrap float caption choice-->4.<input type="radio" value="display_single_row" name="'.$data.'_blog_data2['.$preview_index.']" '.$checked4.'>Preview with a Single Image Per Row and optional title/subtitle/description caption';
			printer::printx('<p class="left">Further Choice For Single Image Per Row: </p>');
			
			printer::printx('<p class="left pl25"> <input type="radio" value="float" name="'.$data.'_blog_data2['.$galltype_index.']" '.$expandchecked5.'>Float Captions to Left of Image</p>');
			$this->show_more('Adjust Position of Left Align Captions','','smallest fsmmaroon maroon whitebackground');
			printer::alertx('<div class="pl25 maroon fsmmaroon maxwidth500 floatleft lightermaroonbackground smallest">Vertical Align Left Captions Top Middle or Bottom to photo '); 
		 
			
			forms::form_dropdown(array('top','middle','bottom'),'','','',$data.'_blog_data2['.$caption_vertical_align_index.']',$caption_vertical_align,false,'maroon whitebackground left');
			printer::alertx('</div>');
				$this->show_close('Adjust Position of Left Align Captions');
			printer::pclear(5);
			printer::printx('<p class="left pl25"> <input type="radio" value="center" name="'.$data.'_blog_data2['.$galltype_index.']" '.$expandchecked6.'>Arrange Captions Under Photo</p>');
			echo '</div><!--wrap float caption choice-->';
			printer::pclear(5);
			
			echo '</div><!--single-mult display setting-->';
			echo '</div><!--Master gall display setting-->';
			echo '<div class="fsmmaroon floatleft left maroon" style="background:#c6a5a5;" > <span class="bold whiteshadow">Choose One of the following Two Choices of Display type for the Gallery Collection Preview Image Link and Title/Caption</span><!--Master gall image display-->';
			printer::pclear(15); 
			$checked='checked="checked"'; 
			$this->show_more('Adjust Master Preview Gallery Image','noback','fs2info rad5 editbackground editfont highlight left5 right5','Style/Config Image Preview Links in Master Gallery',500,'','float:left;',true);
			echo '<div class="'.$this->column_lev_color.' fsminfo editbackground editfont floatleft left"><!--prev image size-->';
			printer::printx('<p>Configure your thumb image size  Enter the max value for width or width/height for your Master Gallery preview image (Scaled down Images will be used for Smaller devices)');
			$this->mod_spacing($data.'_blog_data2['.$smallpic_index.']',$smallpicplus,50,1000,5,'px');// 
			printer::pclear();
			$msg=($this->master_gallery)?'By Default Your Master Gallery Representative Images are equal width but you can choose Equal height/width Depending which is greater': 'By Default you Regular Gallery Preview Page Images (if used) are set to a maximum height/width depending which is greater but there are choices for equal width or height instead.';
			printer::printx('<p>'.$msg.'</p>');
			
			$checked1=($thumb_width_type==='width')?'checked="checked"':'';
			$checked2=($thumb_width_type==='width_height')?'checked="checked"':'';
			printer::printx('<p><input type="radio" '.$checked1.' value="width" name="'.$data.'_blog_data2['.$thumb_width_type_index.']">Choose Equal Width Setting</p>');
			printer::printx('<p><input type="radio" '.$checked2.' value="width_height" name="'.$data.'_blog_data2['.$thumb_width_type_index.']">Choose Max Width/Height Setting</p>');
			 $this->show_more('Adjusting Gallery Image Rows in Master Gallery','noback');
			echo '<div class="fs2info"><!--border previews-->';
			echo '<div class="fsminfo editbackground editfont '.$this->column_lev_color.' floatleft editfont maxwidth500"><!--preview image spacing-->
			Change default side spacing between images when choosing multiple display:
			';
			
			printer::alert('Choose your Side Spacing Setting:');
			$this->mod_spacing($data.'_blog_data2['.$padleft_index.']',$padleft,0,60,1,'px');
			echo '</div><!--preview image spacing-->';
			printer::pclear();
			echo '<div class="fsminfo editbackground editfont editcolor floatleft">Choose the Spacing Between the rows of Preview Images:';
			$this->mod_spacing($data.'_blog_data2['.$preview_pad_bottom_index.']',$preview_pad_bottom,0,175,1,'px');
			echo '</div>';
			printer::pclear();
			
			echo '<div class="fsminfo editbackground editfont '.$this->column_lev_color.' floatleft editfont maxwidth500"><!--final width adjust gal-->
			
			 Further adjust the width of the available presentaion space and create more unused space on the end of the each image row.  This also effects the number of preview images when the multiple images in a row option is chosen. The final width will be determined which ever is smallest: the overall post width, the width you set here or the viewers view screen! <br>'; 
				printer::alert('Final Width Adjust Master Gallery Preview:');
			 $this->mod_spacing($data.'_blog_data2['.$limit_width_index.']',$limit_width,300,1000,1,'px','none');
			echo '</div><!--Edit Final Width Adjust Preview Gall-->'; 
			printer::pclear(); 
				echo '<div class="fsminfo editbackground editfont '.$this->column_lev_color.' floatleft editfont maxwidth500"><!--final width adjust captions--> 
			 Optionally Set width of caption area (for non-title within image captions)'; 
				printer::alert('Set Specific Width For Master Gallery Caption. A default width of 300px will be used if using display single row with left float captions. To enable fluid response layout for your page left float Captions will automatically be displayed below the image when the viewport device width is below the total width of the image plus caption width:');
			 $this->mod_spacing($data.'_blog_data2['.$caption_width_index.']',$caption_width,100,701,5,'px','none');
			echo '</div><!--Edit Final Width Adjust Captons-->'; 
			printer::pclear();
			 $this->submit_button(); 
			echo '</div><!--border previews-->';
			$this->show_close('Adjusting Master Gall with Multiple Preview Image Rows');
			 $this->submit_button(); 
			echo '</div><!---prev image size-->';
			$this->show_close('Adjust Separate Preview Image Display');
			echo '</div><!--Master gall image display-->';
			printer::pclear(7);
			 $this->submit_button(); 
			echo '</div><!--config gall settings-->';
			$this->show_close('Configure gallery');#<!--Configure gallery-->
			}// end else is  master_gall 
		 printer::pclear();
		} // not is_clone etc
	if ($this->edit&&!$this->master_gallery&&(!empty($this->clone_local_data)||!$this->is_clone)){
		printer::pclear();
     $this->show_more('Default Caption Option','noback','','',600,'','float:left;',true);
		echo '<div class="'.$this->column_lev_color.' fsminfo editbackground editfont floatleft left">Image specific captions are made under the "Edit Individual Image Captions or Delete an Image Here" Link Below. However, Here optionally Add Default Title, Subtitle and/or descriptions which will be applied to images that don&#34;t have them<!--global captions-->';
		printer::alertx('<p class="tip">Tip: If You are using a Default title,subtitle, or description but want to leave a certain image caption empty type the word empty and the particular caption for that will not appear!!</p>');	
		echo '<div class="fs2redAlert editbackground editfont"><!--wrap edit captions-->';
		printer::pclear();//$dataname,$name,$width,$fontsize,$turn_on='',$float='left',$percent=90,$inherit=false,$class=''
		echo '<div class="fsminfo width100 editbackground editfont floatleft left '.$this->column_lev_color.'"> Add Default Title:';
		$this->textarea($default_imagetitle,$data.'_blog_tiny_data4','600',16,'','left',100);
		printer::pclear();
		echo '</div>';
		printer::pclear();
		echo '<div class="fsminfo width100 editbackground editfont floatleft left '.$this->column_lev_color.'"> Add Default Subtitle:';
		$this->textarea($default_subtitle,$this->data.'_blog_tiny_data5','600','16','','left',100);
		printer::pclear();
		echo '</div>';
		printer::pclear();
		echo '<div class="fsminfo width100 editbackground editfont floatleft left '.$this->column_lev_color.'"> Add Default description:';
		$this->textarea($default_description,$this->data.'_blog_data7','600','16','','left',100);
		echo '</div>';
		printer::pclear();
		echo '</div><!--wrap edit captions-->';
		echo '</div><!--global captions-->';
		$this->show_close('Default Caption Option');
		printer::pclear();
		}//edit not master is clone || is clone data
	$fixheight='noheight'; //used in fixing slippry gallery height when post height is set.. Adjustment is made in expandgallery to image sizes and 100%
	#masonry
	$previewFlexContainer=($gall_flex&&!$this->edit)?' previewFlexContainer':''; 
	$masonry=(!$gall_flex&&$preview_display==='multiple'&&$gall_masonry&&!$this->edit)?true:false;
	if ($masonry){
		$this->load_masonry();
		$masonryClass='gridgall_'.$this->blog_id;
		$mclass=".$masonryClass";
		if (!$this->edit){
			echo <<<eol
   <script>
   var resizeTimer1_$this->blog_id='';
   var mopts={ 
     gutter: $padleft, 
     isFitWidth: true, 
     itemSelector: '.grid-item'
     } 
   \$(function(){
     $('$mclass').imagesLoaded().always( function( instance ) {
        \$gridgall_$this->blog_id=\$('$mclass').masonry(mopts); 
        \$gridgall_$this->blog_id=\$('$mclass').masonry(mopts); //initiating twice makes it re-initate on change..
        var windowWidth = \$(window).width();
        window.addEventListener('resize', function(){//overcomes 
        if (\$(window).width() != windowWidth) {
          windowWidth = \$(window).width();
          if (\$gridgall_$this->blog_id.masonry()!=='undefined')\$gridgall_$this->blog_id.masonry('destroy'); 
           clearTimeout(resizeTimer1_$this->blog_id); 
           resizeTimer1_$this->blog_id=setTimeout( function(){ 
           \$gridgall_$this->blog_id=\$('$mclass').masonry(mopts); 
           \$gridgall_$this->blog_id=\$('$mclass').masonry(mopts);//initiating twice 
          }, 300);
          }
        }, true);
     });
   });
   </script>
eol;
			}//masonry but not edit
			/**/
		else {//masonry edit
			$this->css.='
   .'.$this->dataCss.' grid-item{margin-bottom:'.$preview_pad_bottom.'px;}
   ';
			}
		}//end is masonry
	else $masonryClass='';//not masonry
   
	if ($gall_display==='highslide'){
		$this->render_highslide();
		$allowSizeReduction=($this->edit)?'hs.allowSizeReduction: false':'hs.allowSizeReduction:true';
echo <<<eol

<script >  
if (hs.addSlideshow) hs.addSlideshow({ 
	slideshowGroup: "$this->blog_data1",
	interval: $pause*1000, 
	dimmingDuration : $transition_time,
	fixedControls: "fit",
	repeat: true,  
   useControls: true, 
   overlayOptions: {
     opacity: .7,  //set the opacity of the controlbar
     position: "bottom center", //position of controlbar 
     hideOnMouseOut: true
     }

});
</script>
eol;
	(!$this->is_clone||$this->clone_local_style)&&
     $this->css.=' 
   .dimming_gall_img_'.$this->blog_id.'{background:#'.$simulate_background.'; }
   '; 
		}// if highslide

		#photoswipe
	elseif ($gall_display==='photoswipe'){// load code only if necessary
		if (!$this->edit){
			$this->load_photoswipe();
echo <<<eol
	 <script>
	\$(function(){		
	(function() { 
		var initPhotoSwipeFromDOM = function(gallerySelector) { 
			var parseThumbnailElements = function(el) {
				var thumbElements = el.childNodes,
				  numNodes = thumbElements.length,
				  items = [],
				  el,
				  childElements,
				  thumbnailEl,
				  size,
				  item;
				for(var i = 0; i < numNodes; i++) { 
             el = thumbElements[i];
             // include only element nodes 
             if(el.nodeType !== 1) {
               continue;
               }
             childElements = el.children;
             size = el.getAttribute('data-size').split('x');
					// create slide object
             item = {
						 src: el.getAttribute('href'),
						 w: parseInt(size[0], 10),
						 h: parseInt(size[1], 10),
						 author: el.getAttribute('data-author')
               };
             
             item.el = el; // save link to element for getThumbBoundsFn
 
             if(childElements.length > 0) {
               item.msrc = childElements[0].getAttribute('src'); // thumbnail url
               if(childElements.length > 1) {
                 item.title = childElements[1].innerHTML; // caption (contents of figure)
                  }
               }
             var mediumSrc = el.getAttribute('data-med');
					if(mediumSrc) {
               size = el.getAttribute('data-med-size').split('x');
               // "medium-sized" image
               item.m = {
                  src: mediumSrc,
                  w: parseInt(size[0], 10),
                  h: parseInt(size[1], 10)
                  };
               }
               // original image
					 item.o = {
						src: item.src,
						w: item.w,
						h: item.h
               }; 
             items.push(item);
             }//end for
          return items;
          };//parse
 
			// find nearest parent element
			var closest = function closest(el, fn) {
				return el && ( fn(el) ? el : closest(el.parentNode, fn) );
          };
			var onThumbnailsClick = function(e) {
				e = e || window.event;
				e.preventDefault ? e.preventDefault() : e.returnValue = false;
				var eTarget = e.target || e.srcElement;
 
				var clickedListItem = closest(eTarget, function(el) {
				  return el.tagName === 'A';
				}); 
				if(!clickedListItem) {
				  return;
				} 
				var clickedGallery = clickedListItem.parentNode;
 
				var childNodes = clickedListItem.parentNode.childNodes,
				  numChildNodes = childNodes.length,
				  nodeIndex = 0,
				  index; 
				for (var i = 0; i < numChildNodes; i++) {
				  if(childNodes[i].nodeType !== 1) { 
					  continue; 
             }
 
				  if(childNodes[i] === clickedListItem) {
               index = nodeIndex;
               break;
               }
				  nodeIndex++;
             }
 
				if(index >= 0) {
				  openPhotoSwipe( index, clickedGallery );
             }
				return false;
          };
 
			var photoswipeParseHash = function() {
				var hash = window.location.hash.substring(1),
				params = {};
 
				if(hash.length < 5) { // pid=1
             return params;
             } 
				var vars = hash.split('&');
				for (var i = 0; i < vars.length; i++) {
             if(!vars[i]) {
               continue;
               }
             var pair = vars[i].split('='); 
             if(pair.length < 2) {
               continue;
               }      
             params[pair[0]] = pair[1];
             }
 
				if(params.gid) {
             params.gid = parseInt(params.gid, 10);
             } 
				return params;
          };
 
			 var openPhotoSwipe = function(index, galleryElement, disableAnimation, fromURL) {
				var pswpElement = document.querySelectorAll('.pswp')[0],
				gallery,
				options,
				items; 
				items = parseThumbnailElements(galleryElement);
				// define options (if needed)
				options = {
				  galleryUID: galleryElement.getAttribute('data-pswp-uid'),
				  getThumbBoundsFn: function(index) {
               // See Options->getThumbBoundsFn section of docs for more info
               var thumbnail = items[index].el.children[0],
               pageYScroll = window.pageYOffset || document.documentElement.scrollTop,
               rect = thumbnail.getBoundingClientRect(); 
               return {x:rect.left, y:rect.top + pageYScroll, w:rect.width};
               }, 
				  addCaptionHTMLFn: function(item, captionEl, isFake) {
						ifauthor= item.author.length>0 ?'<br/><small>Photo: ' + item.author + '</small>':'';
						if(!item.title) {
							captionEl.children[0].innerText = '';
							return false;
                  }
						captionEl.children[0].innerHTML = item.title + ifauthor;
						return true;
               }, 
             };
          if(fromURL) {
             if(options.galleryPIDs) {
               // parse real index when custom PIDs are used 
               // http://photoswipe.com/documentation/faq.html#custom-pid-in-url
               for(var j = 0; j < items.length; j++) {
                  if(items[j].pid == index) {
                    options.index = j;
                    break;
                    }
                  }
               }
             else {
               options.index = parseInt(index, 10) - 1;
               }
             }
          else {
					options.index = parseInt(index, 10);
					} 
				options.mainClass = 'pswp--minimal--light'; 
				options.captionEl = 'true';
				options.fullscreenEl = true;
          options.counterEl=false; 
				options.shareEl = true;  
				if(disableAnimation) {
             options.showAnimationDuration = 0;
             } 
				// Pass data to PhotoSwipe and initialize it
				gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, items, options);
          // see: http://photoswipe.com/documentation/responsive-images.html
				var realViewportWidth,
          useLargeImages = false,
          firstResize = true,
          imageSrcWillChange;
          gallery.listen('beforeResize', function() { 
             var dpiRatio = window.devicePixelRatio ? window.devicePixelRatio : 1;
             dpiRatio = Math.min(dpiRatio, 2.5);
             realViewportWidth = gallery.viewportSize.x * dpiRatio; 


             if(realViewportWidth >= 1200 || (!gallery.likelyTouchDevice && realViewportWidth > 800) || screen.width > 1200 ) {//
               if(!useLargeImages) {
                  useLargeImages = true;
                  imageSrcWillChange = true;
                  } 
               }
             else {
               if(useLargeImages) {
                  useLargeImages = false;
                  imageSrcWillChange = true;
                  }
               } 
             if(imageSrcWillChange && !firstResize) {
               gallery.invalidateCurrItems();
               } 
             if(firstResize) {
               firstResize = false;
               } 
             imageSrcWillChange = false;

             }); 
				gallery.listen('gettingData', function(index, item) {
					if( useLargeImages ) {
					  item.src = item.o.src;
					  item.w = item.o.w;
					  item.h = item.o.h;
               }
             else {
					  item.src = item.m.src;
					  item.w = item.m.w;
					  item.h = item.m.h;
               }
             }); 
				gallery.init();
          }; 
        // select all gallery elements
			var galleryElements = document.querySelectorAll( gallerySelector ); 
			for(var i = 0, l = galleryElements.length; i < l; i++) {
				galleryElements[i].setAttribute('data-pswp-uid', i+1);
				galleryElements[i].onclick = onThumbnailsClick;
          } 
			 // Parse URL and open gallery if it contains #&pid=3&gid=1
			var hashData = photoswipeParseHash();
			if(hashData.pid && hashData.gid) {
				openPhotoSwipe( hashData.pid, galleryElements[ hashData.gid - 1 ], true, true );
          }
        }; 
		initPhotoSwipeFromDOM('.photoswipe_$this->blog_id'); 
		})();
	}); 
</script>
eol;
        }//photoswipe not edit
     else { //is photoswipe edit
        if (!$this->is_clone||$this->clone_local_style){
          if ($photoswipe_caption_background!=='none'){
             $back_color='#'.$photoswipe_caption_background;
             $backstyle=' background-color:'.$back_color.';';
             $captionstyle=' background-color:'.$back_color.' !important;';
             }
          else $captionstyle='';
          if ($photoswipe_prevnext_background!=='none'){
             $back_color='#'.$photoswipe_prevnext_background;
             $prevnextstyle=' background-color:'.$back_color.';';
             }
          else $prevnextstyle='';
          if ($photoswipe_topcontrol_background!=='none'){
             $back_color='#'.$photoswipe_topcontrol_background;
             $topcontrolstyle=' background-color:'.$back_color.';';
             }
          else $topcontrolstyle='';
          $this->css.='
             #gallery_'.$this->blog_id.'{background:#'.$simulate_background.';}
             .holder figure{display:none;}
             .pswp__top-bar,.pswp__ui--fit .pswp__top-bar {'.$topcontrolstyle.'}
             .pswp__caption, 
             .pswp__ui--fit .pswp__caption { 
             '.$captionstyle.'
             }
               
               .pswp__button,
     .pswp__button--arrow--left:before,
     .pswp__button--arrow--right:before {
      background: url('.$controlbar.') 0 0 no-repeat;}
               .pswp__button--arrow--left:before,
               .pswp__button--arrow--right:before {'.$prevnextstyle.'
               }
               .'.$this->dataCss.' figure{display:none;} 
               ';
               
               if ($controltheme==='light'){//we need to create dark svg also.
             $this->css.='        
     @media (-webkit-min-device-pixel-ratio: 1.1), (-webkit-min-device-pixel-ratio: 1.09375), (min-resolution: 105dpi), (min-resolution: 1.1dppx) {
      /* Serve SVG sprite if browser supports SVG and resolution is more than 105dpi */
      .pswp--svg .pswp__button,
      .pswp--svg .pswp__button--arrow--left:before,
      .pswp--svg .pswp__button--arrow--right:before {
       background-image: url(default-skin.svg); }
       }';
             }//if light
          }//!clone or local
        }//end photoswipe edit
     }//end if photoswipe 
	elseif ($gall_display==='slippry'){
		$this->load_slippry();
     $adaptiveHeight=true;
#slippry
$fixheight='noheight';
echo <<<eol

<script >
function slippry_$this->blog_id(pic,ele){  
	$(ele).fadeOut(300, function() { 
	$(this).html(gen_Proc.slippry_$this->blog_id).fadeIn(300);});
	setTimeout(function(){
	slippry_$this->blog_id = \$("#slippry_$this->blog_id").slippry({
	transition: '$transition',
	useCSS: true, 
	speed: $transition_time*1000,
	extId: $this->blog_id,
	pause: $pause*1000,
	auto: '$autorun',
	slide: '$slide',
   mainEle: '$this->dataCss',
	captions: '$slipcaption',
	controls: '$slippry_mid_control',
	//largepicplus : '$largepicplus',
	//limitmax: $limitmax, 
	start: pic,
	fixheight: 'noheight', 
	adaptiveHeight: '$adaptiveHeight',
	autoHover: false
	});
	
	$('.$this->dataCss .pause').click(function () {
			slippry_$this->blog_id.stopAuto();
	  });
	  $('.$this->dataCss .play').click(function () {
		  slippry_$this->blog_id.goToNextSlide();
		  slippry_$this->blog_id.startAuto();
	  });
	  $('.$this->dataCss .previous').click(function () { 
		  slippry_$this->blog_id.goToPrevSlide();
		  return false;
	  });
	  $('.$this->dataCss .next').click(function () {
		  slippry_$this->blog_id.goToNextSlide();
		  return false;
	  });
	  $('.$this->dataCss .close').click(function () { 
		   $(ele).fadeOut(300, function() {
$(this).html(gen_Proc.slipprybackup).fadeIn(300); }); 
		  //slippry_$this->blog_id.destroySlider();
	  });
	  $('.$this->dataCss .reload').click(function () {
		  slippry_$this->blog_id.reloadSlider();
		  return false;
	  });
	  $('.$this->dataCss .init').click(function () {
		  slippry_$this->blog_id = slippry_$this->blog_id.slippry({auto: true});
		  return false;
	  });
		},310);
	  
	} 
</script>
eol;
     }//is slippry
   //$heightclass=($fixheight!=='noheight')?' height100':'';
	$holderid=($new_page_effect)?'':' id="holder_'.$this->blog_id.'" ';
	echo '<div class="holder" '.$holderid.'><!--gall holder-->'; 
	if(empty($gall_ref)){ // printer::alert_neg('reinitiate creat new gall ref');
		 
		if (!$this->edit){ 
			printer::printx('<p class="fsminfo editbackground editfont '.$this->column_lev_color.'">New Gallery Coming Soon</p>');
			return;
			}
		} //if empty gall ref
     
   if ($this->edit&&(!$this->is_clone||$this->clone_local_style)&&$inc<2&&$gall_display==='slippry'){
     $this->css.='
.slippry_wrapper{width:'.$limitmax.'%; max-width:'.$largepicplus.'px;margin:0 auto;}';
     $this->css.='
.slipcontrol ul {
list-style: none;
position:relative; 
} 
.slipcontrol li {
position:relative;
float:left; 
padding:.5em .5em;
top:.15em;
}
.slipcontrol li:hover { opacity:1.0;
}
.slipcontrol li { opacity:0.65;
}
.slipcontrol li a span {display:none;}
.slipcontrol li a.pause{ 
  content: "";
  display: block;
  width: .9em;
  height: 1.0em; 
   }  
 

.slipcontrol li a.next { 
   content: "";
  display:block;
   width: .9em;
  height: .9em; 
  transform: rotate(45deg); 
   }
.slipcontrol li.next {padding-left:.25em;}
.slipcontrol li.previous {padding-right:.25em;}
.slipcontrol li a.previous{ 
   content: "";
  display:block;
   width: 0.9em;
  height: 0.9em; 
  transform: rotate(45deg); 
   }
 

.slipcontrol li.close{
display:block;
 width: 2em;
 height: 1.5em;
position:relative; padding-right:1em; padding-left:1em;
}

.slipcontrol li a.close:before,.slipcontrol li a.close:after { 
 position:absolute;
 display:block;
 content: ""; 
 height: 1.4em;
 width: .2em;
 top:.3em; left:.75em;
   }
.slipcontrol li a.close:before {
 transform: rotate(45deg);
   }
.slipcontrol li a.close:after {
 transform: rotate(-45deg);
   }
.slipcontrol li.play{top:0}
.slipcontrol li a.play{
 content: "";
 display: inline-block;
 position: relative; 
 border-style: solid;
 border-width: .625em 0 .625em 1.25em; 
   }
   ';
     } 
   if ($this->edit&&(!$this->is_clone||$this->clone_local_style)&&$gall_display==='slippry'){
     $color = $slipbar_color;
     $font_size=$slipbar_size*16;
     $position='float:right; margin-right:2em;';
     $this->css.='
.slipcontrol{'.$position.'}
.slipcontrol_'.$this->blog_id.'{font-size:'.$font_size.'px;}
.slipcontrol_'.$this->blog_id.' li a.pause{ 
border-left: 0.3em solid #'.$color.';
border-right: 0.3em solid #'.$color.'; 
   }  
.slipcontrol_'.$this->blog_id.' li a.next { 
   border-right: 0.2em solid #'.$color.';
   border-top: 0.2em solid #'.$color.';
   }
.slipcontrol_'.$this->blog_id.' li a.previous{ 
   border-left: 0.2em solid #'.$color.';
   border-bottom: 0.2em solid #'.$color.'; 
   } 
.slipcontrol_'.$this->blog_id.' li a.close:before,.slipcontrol li a.close:after { 
   background:#'.$color.'
   }
.slipcontrol_'.$this->blog_id.' li a.play{
   border-color: transparent transparent transparent #'.$color.';
   }
   ';
     }//gall = slippry 
   if ($gall_display==='multiple_hover_caption'){
     echo <<<eol
   
   <script>
   \$(function(){
     if (window.TOUCHSTART){
        \$('#$this->dataCss .hover_caption .caption_wrap').css({'bottom':'0'});
        }
     });
   </script>
eol;
     } //multiple_hover_caption 
   if ($this->edit&&(!$this->is_clone||$this->clone_local_style)){
     if ($gall_display==='multiple_hover_caption'||$gall_display==='multiple_image_caption'){
        $this->css.='
   .hover_caption a {
   display:block;
   position: relative;
   overflow: hidden;
   }

 .hover_caption .caption_wrap {
 width: 100%;
 position: absolute;
 left: 0; 
 transition: 1s; 
   } ';
      
        }
     if ($gall_display==='multiple_hover_caption'){
        $this->css.='
   .'.$this->dataCss.' .hover_caption a:hover .caption_wrap {
    bottom: 0;
     }
   .'.$this->dataCss.' .hover_caption .caption_wrap {
     bottom: -'.$caption_height.'px;
     }
     ';
        }
     else {
        $this->css.='
     .'.$this->dataCss.' .hover_caption .caption_wrap {
     bottom: 0;
     }';
        }
     }//if edit
        
   if ($this->master_gallery&&$gall_display==='display_single_row'&&$blog_data2[$galltype_index]!=='center'){ 
     $caption_width=(!empty($caption_width))?$caption_width:300;
     $total_width=$caption_width+$smallpicplus+10;
     $maxstyle='style="max-width:'.$total_width.'px;"';
     ($this->edit&&(!$this->is_clone||$this->clone_local_style))&&$this->css.='
     @media screen and (min-width: '.($total_width+1).'px){
        .inlineblock_'.$this->blog_id.'{display:inline-block;}
        .mainPicInfo_'.$this->blog_id.'{width:'.$caption_width.'px}
        }
     @media screen and (max-width: '.$total_width.'px) and (min-width:'.($smallpicplus+1).'px){
     .inlineblock_'.$this->blog_id.'{display:inline-block ; margin-left:0; margin-right:0;}
     .mainPicInfo_'.$this->blog_id.'{width:'.$caption_width.'px} 
        }
     @media screen and (max-width:'.$smallpicplus.'px){
     .inlineblock_'.$this->blog_id.'{display:block; margin-left:0; margin-right:0;}
     .mainPicInfo_'.$this->blog_id.'{width:auto;}
        }'; 
     }
   else {
     $maxstyle=(!empty($limit_width)&&$limit_width>299&&$limit_width<$this->current_net_width)?'style="max-width:'.$limit_width.'px;"':'style="max-width:100%"';
     ($this->edit&&(!$this->is_clone||$this->clone_local_style))&&$this->css.='
        .inlineblock_'.$this->blog_id.'{display:inline-block;}';
     }
     
	//echo $maxwidth_adjust_expanded.' is max width adjust';
	list($border_add_width,$border_add_height)=$this->border_calc($this->blog_tiny_data3);
	list($border_add_width2,$border_add_height)=$this->border_calc($this->blog_style);
	
   if (is_file(Cfg_loc::Root_dir.Cfg::Include_dir.'gallery_loc.class.php'))
     $gallery= new gallery_loc();//local gallery can be used for custom modification
   else $gallery= new gallery_master();// look for local gallery if exists
	$gallery->masonry=$masonry;
	$gallery->gall_flex=$gall_flex;
	$gallery->gall_expand_menu_icon=$gall_expand_menu_icon.'_menu_icon.gif';
	$gallery->gall_display=$gall_display;
	$gallery->topcontrol=$slippry_top_control;
	$gallery->fixheight=$fixheight;
	$gallery->slide_caption=$slide_caption;
	$gallery->slide=$slide;
	$gallery->caption_display=$caption_display;
	$gallery->page_width=$this->page_width;
	$gallery->next_gallery=true;// need to configure choice for this 
	$gallery->new_page_effect=$new_page_effect;
	$gallery->page_cache_arr=$this->page_cache_arr;
	$gallery->thumb_width_type=$thumb_width_type; 
	$gallery->preview_display=$preview_display;
	$gallery->padleft=$padleft;
	$gallery->gall_topbot_pad=$preview_pad_bottom;//actually padding for between rows..
	$gallery->show_under_preview=$show_under_preview;
	$gallery->fixed_pad=$fixed_pad;
	$gallery->caption_vertical_align=$caption_vertical_align;
	$gallery->transition=$transition; 
	//$gallery->thumbnail_height=$thumbnail_height;
	$gallery->transition_time=$transition_time;//obselete with new gallery
	$gallery->data=$data;
	$gallery->dataCss=$this->dataCss;
	$gallery->smallpicplus=$smallpicplus; 
	$gallery->caption_width=$caption_width;
	$gallery->largepicplus=$largepicplus; 
	$gallery->current_net_width=$this->current_net_width; 
	$gallery->border_add_width=$border_add_width;
	$gallery->master_gallery=$this->master_gallery;//whether for master gallery collection or normal gallery
	$gallery->master_gall_ref='';
	$gallery->inc=$inc;
	$gallery->quality_option=$blog_data2[$image_quality_index];
	$gallery->quality=$quality;
	$gallery->image_quality_index=$image_quality_index;
	$gallery->css=$this->roots.Cfg::Style_dir.$this->pagename;
	$gallery->column_lev_color=$this->column_lev_color;
	$gallery->edit=$this->edit;
	$gallery->master_gall_table=$this->master_gall_table; 
	$gallery->gall_ref=$gall_ref;
	$gallery->gall_table=$gallery->pagename=$this->pagename;
	$gallery->blog_id=$this->blog_id; 
	$gallery->limit_width=$limit_width;
	$gallery->preview_minimum=$preview_minimum;
	$gallery->is_clone=$this->is_clone;
	$gallery->clone_local_style=$this->clone_local_style;
	$gallery->clone_local_data=$this->clone_local_data;
	$gallery->gall_glob_title=$blog_data2[$gall_glob_title_index];
	$gallery->main_menu=$main_menu;
	$gallery->large_images_arr=$this->large_images_arr; 
	$gallery->blog_data2=$this->blog_data2;
	$gallery->blog_order=$this->blog_order;
	$gallery->blog_table=$this->blog_table;
	$gallery->display_float=$display_float;//used for master gallery display single
	$gallery->default_imagetitle=$default_imagetitle;
	$gallery->default_subtitle=$default_subtitle;
	$gallery->default_description=$default_description;
	$gallery->enable_edit= (!$this->is_clone||$this->clone_local_data)?true:false;
	$gallery->clone= ($this->is_clone&&!$this->clone_local_data)?'clone_'.$this->pagename:'';//pagename will give specific page reference of clone otherwise the parent page is used and clone will automatically follow parent page updates without itslef updating!
	$gallery->maxwidth_adjust_expanded=100; //adjust maxwidt to acount for box shadow 
	$gallery->maxwidth_adjust_preview=$maxwidth_adjust_preview;//adjust maxwidt 100 to acount for box shadow
	$gallery->ext=$this->ext;
	###
	echo '<div class="inlineblock_'.$this->blog_id.' '.$masonryClass.$previewFlexContainer.'" '.$maxstyle.'><!--limiter on width available for preview images-->';
	$gallery->pre_render_data($gall_ref);
	$gallery->gallery_display();
	$this->large_images_arr=$gallery->large_images_arr;//collecting image informations
	$this->preload=(!empty($this->preload))?$this->preload.','.$gallery->preload:$gallery->preload;//collect one or more gallery preloads
	$this->instruct=array_merge($this->instruct,$gallery->instruct);
	echo '</div><!--limiter on width available for preview images-->';
	print '</div><!--gall holder-->';
	if (!$this->edit){ 
		return;
		}
	$msg=($this->master_gallery)?'Edit general Master Gallery Styles':'Edit General Gallery Styles';
	 $this->edit_styles_close($data,'blog_style','.'.$this->dataCss,'background,padding_top,padding_bottom,padding_left,padding_right,margin_top,margin_bottom,margin_left,margin_right,font_family,font_size,font_weight,text_align,font_color,text_shadow,line_height,letter_spacing,italics_font,small_caps,text_underline,borders,box_shadow,outlines,radius_corner',$msg,true,'Background Styles will not affect the Expanded image Background in Simulated New Pages. Use the specific option for this. Set General Caption Styles Here. Individual Caption Styles for Title Subtitle and Description May be set below',true);
	if (!$this->master_gallery){
		$this->edit_styles_close($data,'blog_tiny_data3','.preview_border_'.$this->blog_id,'borders,box_shadow,outlines,radius_corner','Style Borders for Preview Images',false,'',true); 
		printer::pclear();
		}
	if ($this->clone_local_style||!$this->is_clone){
      $image_border='.pswp_'.$this->blog_id.' img,.sy-slides-crop_'.$this->blog_id.',.gall_img_'.$this->blog_id.' img'; 
        $msg=($this->master_gallery)?'Image Border Style for Master Gallery':'Style the <b>Image Border &amp; Radius</b> of Expanded Images for this Gallery';
        $this->edit_styles_close($data,'blog_tiny_data1',$image_border,'borders,box_shadow,outlines,radius_corner',$msg,false,'',true); 
        printer::pclear(); 
     ######################
     $msg=($this->master_gallery)?'':'Expanded';
		$imagetitle='.imagetitle_'.$this->blog_id;
		$this->edit_styles_close($data,'blog_data3',$imagetitle,'padding_top,font_family,font_size,font_weight,text_align,font_color,text_shadow,text_underline,italics_font,small_caps,line_height,letter_spacing','Style the <b>TITLE</b> of '.$msg.' Image Captions for this Gallery',false,''); 
		$subtitle='.subtitle_'.$this->blog_id;
		$this->edit_styles_close($data,'blog_data4',$subtitle,'padding_top,font_family,font_size,font_weight,text_align,font_color,text_shadow,italics_font,small_caps,line_height,letter_spacing,text_underline','Style the <b>SUBTITLE</b> of '.$msg.' Image Captions for this Gallery',false,'',false);
     $msg=($this->master_gallery)?'':'Expanded';
     $description='.description_'.$this->blog_id; 
     $this->edit_styles_close($data,'blog_data5',$description,'padding_top,font_family,font_size,font_weight,text_align,font_color,text_shadow,italics_font,small_caps,line_height,letter_spacing,text_underline','Style the <b>DESCRIPTION</b> of '.$msg.' Image Captions for this Gallery',false,'',false); 
     $this->edit_styles_close($data,'blog_data9','body.simulated.'.$this->pagename,'background','Style the background differently in new Page Simulate Mode',true,'If slippry gallery used in Simulate new Page Mode Style the Page background here',true);
     if ($this->master_gallery&&$imagecaptiontitle){
        $this->show_more('Additional Styles for Master Galleries with title in image' ,'','','','500','','float:left;',true);
        echo '<div class="editcolor editbackground editfont fs2black"><!--features of expand gall images-->';  
        $imagecaptiontitle='.'.$this->dataCss.' .hover_caption .caption_wrap';
        $this->edit_styles_close($data,'blog_data8',$imagecaptiontitle,'background,padding_top,padding_bottom,padding_left,padding_right,borders,box_shadow,outlines,radius_corner','Style the <b>Background &amp; Spacing</b> of Captions in Image Type Captions',false,''); 
        echo '</div><!--features of expand gall images-->'; 
        $this->show_close('Special Styles for Master Galleries with title in image'); 
        }
     ####################### 
		
		$msg=($this->master_gallery)?'Additional Styles for All Other Master Gallery':'Styles for Expanded Images and Captions';
		$this->show_more($msg,'','','','500','','float:left;',true);
		echo '<div class="editcolor editbackground editfont fs2black"><!--features of expand gall images-->'; 
		//$this->clone_local_style||!$this->is_clone
     $image_border='.pswp_'.$this->blog_id.' img,.sy-slides-crop_'.$this->blog_id.',.gall_img_'.$this->blog_id.' img'; 
     $msg=($this->master_gallery)?'Image Border Style for Master Gallery':'Style the <b>Image Border &amp; Radius</b> of Expanded Images for this Gallery';
     $this->edit_styles_close($data,'blog_tiny_data1',$image_border,'borders,box_shadow,outlines,radius_corner',$msg,false,'',true); 
     printer::pclear(); 
     $msg=($this->master_gallery)?'':'Expanded';
     $description='.description_'.$this->blog_id; 
     $this->edit_styles_close($data,'blog_data5',$description,'padding_top,font_family,font_size,font_weight,text_align,font_color,text_shadow,italics_font,small_caps,line_height,letter_spacing,text_underline','Style the <b>DESCRIPTION</b> of '.$msg.' Image Captions for this Gallery',false,'',false);
     
     $mainPicInfo='.mainPicInfo_'.$this->blog_id.',.highslide-caption_'.$this->blog_id; 
      $this->edit_styles_close($data,'blog_data6',$mainPicInfo,'background,padding_top,padding_bottom,padding_left,padding_right,margin_top,margin_bottom,borders,box_shadow,outlines,radius_corner','Style the <b>BACKGROUND AREA</b> of the '.$msg.' Image Captions for this Gallery',false,'',false); 
     if ($this->clone_local_style||!$this->is_clone){ 
        echo '</div><!--features of expand gall images-->';
        $this->show_close('features of expand gall images');
        printer::pclear(20);
        }//this clone enabled or pagename = this page table
      
     
   #gallcss	#gallstyle 
     if($this->is_clone&&!$this->clone_local_style)return;
        $this->css.='
   .'.$this->dataCss.' .sy-controls li a:after{background-color:#'.$controlcolor.';}
   .'.$this->dataCss.' .expand-menu-icon{'.$position_menu_icon.'}
   .'.$this->dataCss.'	.expand-menu-icon .xbar1,.'.$this->dataCss.' .expand-menu-icon .xbar2,.'.$this->dataCss.' .expand-menu-icon .xbar3 {
     background-color:#'.$gall_expand_menu_icon.';
     }
   .previewFlexContainer{display:flex;align-items:center;justify-content:center;flex-wrap:wrap;}
   .previewFlexItem{}
   #holder_'.$this->blog_id.'{ text-align:center;}
   .holder{text-align:center;}
   .thumbs {float:left;}
   .thumbs img{opacity: .5;}
   .thumbs img:hover{ opacity:1 !important;}
   .'.$this->dataCss.' .gall_preview_'.$this->blog_id.'{margin-left: auto; margin-right:auto;margin-top:'.$preview_padtop.'px;}
   .gall_img_'.$this->blog_id.' .highslide-controls,.gall_slipimg_'.$this->blog_id.' .highslide-controls{ background:url(graphics/'.$controlbar.') 0 -90px no-repeat;margin:20px 15px 10px 0;}
   .slipcontrols {float:right;margin-right:20px;margin-bottom:18px;}
   .slipcontrols ul { margin-bottom: 0;margin-top:0; }
     .gall_img_'.$this->blog_id.' .highslide-controls a,.gall_slipimg_'.$this->blog_id.' .highslide-controls a{background-image:url(graphics/'.$controlbar.');display:block;float:left;height:30px;width:30px;outline:none;}
     .'.$this->dataCss.' .thumbnail_'.$this->blog_id.'{float: left; margin-bottom:'.$thumbnail_pad_bottom.'px; margin-right:'.$thumbnail_pad_right.'px;'.$final_thumbnail_height.'width:auto;'.$final_thumbnail_height_min.'}
       ';
     }//}
   ($this->edit&&$this->overlapbutton)&&$this->overlapbutton();
	}//end gallery
#endgall
#slide #auto
function auto_slide($data,$type){ 
	static $inc=0; $inc++;
	$min_opac=10;
	$shadowcalc=0;//initialize  where $table_ref='$ttt' AND $id_ref='$id'";
	$options='time,transit,image_quality,use_page_slide';//use page slide used in page options
	$options_arr=explode(',',$options);
	foreach($options_arr as $key=>$index){
		${$index.'_index'}=$key;
		}
	switch ($type){
		case 'page':
			$background_slide=true; 
			$table=$this->pagename;
			$option_field='page_tiny_data2';
			$border_field='';//not used for page
			$style_field='';//not used for page
			$delete='delete_auto_page';
			$dbtable=$this->master_page_table;
			$field_id_val=$this->page_id;
			$pic_field='page_tiny_data1';
			$field_id='page_id';
			$sort_id='page'.$this->page_id;
        $this->max_width_limit=end($this->page_cache_arr); 
			$image_pos_data_arr=(strlen($this->page_tiny_data3)>10)?unserialize($this->page_tiny_data3):array();
			break;
		case 'blog' :
        #currently background slide type working only in pagetypes
			$background_slide=false;//($this->blog_tiny_data1==='background_slide')?true:false;
			$option_field='blog_data2';
			$border_field='blog_data2';//blog_data5
			$style_field='blog_style';//not used for col
			$table=$this->blog_table;
			$field_id_val=$this->blog_id;
			$delete='delete_auto_blog';
			$dbtable=$this->master_post_table;
			$pic_field='blog_data1';
			$field_id='blog_id';
			$sort_id=$this->blog_id; 
			break;
		case 'col' : //col level slides not available currently
			$background_slide=true;
			$option_field='col_data2';
			$table=$this->col_table;
			$border_field='';//not used for col 
			$style_field='';//not used for col
			$delete='delete_auto_col';
			$dbtable=$this->master_col_table; 
			$pic_field='col_data1';
			$field_id_val=$this->col_id; 
			$field_id='col_id';
			break;
		}//end switch
	$option_field_arr=explode(',',$this->$option_field);
	for ($i=0; $i<count($options_arr); $i++){
		if (!array_key_exists($i,$option_field_arr)){
			$option_field_arr[$i]=0;
			}
		}	
	if ($this->edit&&isset($_POST['submitted'])){
		if (isset($_POST[$delete][$field_id_val])){
			$new_arr=array();
			$delete_arr=array();
			$pic_arr=explode(',',$this->$pic_field); 
			foreach($_POST[$delete][$field_id_val] as $arrayed => $del_img){ 
          $this->message[]=printer::alert_neg('Removed '.$del_img. ' from slide show',.9,1);
          $delete_arr[]=$del_img; 
          }
			foreach ($pic_arr as $image){
				if (!in_array($image,$delete_arr)){
					$new_arr[]=$image;
					}
				}
			$newval=implode(',',$new_arr);
			$q="update $dbtable set $pic_field='$newval' where $field_id='$field_id_val'";
			$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
			}
		}
	$this->edit_styles_open();
	($this->edit&&$this->is_blog)&&  
	$this->blog_options($data,$this->blog_table); 
	if (empty($this->$pic_field)){ 
		if (!$this->edit)return;
		$msg=printer::alert_pos('Upload Your First Slide Show Image!!',1.1,true);
		#$maxwid=$this->column_net_width[$this->column_level];
		}
	$piccount=count(explode(',',$this->$pic_field));
	$quality=(!empty($option_field_arr[$image_quality_index])&&$option_field_arr[$image_quality_index]>9&&$option_field_arr[$image_quality_index]<101)?$option_field_arr[$image_quality_index]:((!empty($this->page_options[$this->page_image_quality_index])&&$this->page_options[$this->page_image_quality_index]<101&&$this->page_options[$this->page_image_quality_index]>9)?$this->page_options[$this->page_image_quality_index]:Cfg::Pic_quality); 
	$time=(!empty($option_field_arr[$time_index])&&$option_field_arr[$time_index]>=3&&$option_field_arr[$time_index]<15)?$option_field_arr[$time_index]:8;// time between images 
	$transit=(!empty($option_field_arr[$transit_index]))?$option_field_arr[$transit_index]:.9; 
	$wpercent=100;//not used at moment($this->blog_data3>4&&$this->blog_data3<=100)?$this->blog_data3:100;
	if (!empty($this->$pic_field)){
		$arr=explode(',',$this->$pic_field);
		$pic_init=$arr[0];
		$flag=false;
		$empty=false;//if auto file ! exist set to true 
		$pic_arr=explode(',',$this->$pic_field); 
		$maxh=$maxw=$maxAspect=0; $minAspect=1;
		foreach($pic_arr as $key=>$image){
			if (!is_file(Cfg_loc::Root_dir.Cfg::Upload_dir.$image)){ 
				$this->message[]='file not found in auto slide '.Cfg_loc::Root_dir.Cfg::Upload_dir.$image ;
				$flag=true;
				}
			list($width,$height)=$this->get_size($image,Cfg_loc::Root_dir.Cfg::Upload_dir);
			$ratio=$width/$height;
			$minAspect=min($ratio,$minAspect); 
			$maxAspect=max($ratio,$maxAspect);
			if ($pic_init===$image)$init_ratio=$ratio;
			} 
		}//end !empty($this->$pic_field)
	if (!empty($this->$pic_field)){// rechecking after unsetting... currently unsetting removed...
     $this->image_resize_msg='Auto Slideshow'; 
		if ($this->edit&&$type!=='page'){
        list($border_width,$border_height)=$this->border_calc($this->$border_field);//img
        list($post_pad_width,$post_mar_width)=$this->pad_mar_calc($this->$style_field,$this->column_total_width[$this->column_level]); //around post
        $shadowcalc=$this->calc_border_shadow($this->$border_field); 
        $maxwidth_adjust_shadow_calc=100-$shadowcalc/3;//300 ~ min image width in px conv to %
        list($pad_width,$mar_width)=$this->pad_mar_calc($this->$border_field,$this->column_total_width[$this->column_level]); 
        ($this->edit)&&print('<p id="return_'.$this->blog_id.'">&nbsp;</p>');
        $bp_arr=$this->page_break_arr;
        $maxwidth=0;//intitialize width of maximumun maintain width in maintain_width mode
        if ($type==='col'&&$this->column_primary)$max_pic_size=800;
        else {//columns slide show is not used presently..  page or blog/post only
          $column_level= ($type!=='col')?$this->column_level:$this->col_level-1; 
          if ($this->column_use_grid_array[$column_level]==='use_grid'){ 
             $max_pic_size=$this->grid_width_chosen_arr['max'.$bp_arr[0]]*$wpercent/100;//likely starter
             foreach($this->page_break_arr as $bp){
               $max_pic_size=max($max_pic_size,$this->grid_width_chosen_arr[$bp]*$wpercent/100);//relative percent and size can be bigger with smaller break pt calculation
               } 
             }//end if rwd enabled
				else{//rwd not enabled 
					$max_pic_size=$this->current_net_width*$wpercent/100; 
					$maxwidth=$max_pic_size;
					}
				}//not primary column
			$best_guess=($max_pic_size>1000)?700:(($max_pic_size>500)?500:$max_pic_size);//best guess used for when viewport not set like first intitial page
        $gtype=($this->column_use_grid_array[$this->column_level]==='use_grid')?'rwd':'no_rwd';
        //grid post percent arr  used to determine the percentage width available when grid system is used under the relevant break point given the current width... from this relevant pic width is calculated..
        //$maxwidth=//could be limited by page_width so we will add that here..
        $grid_post_percent_arr=($this->column_use_grid_array[$this->column_level]==='use_grid')?$this->grid_width_chosen_arr:'';//array becomes size of pic plugging in viewport
        (!is_dir(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir))&&mkdir(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir,0755,1);
        file_put_contents(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'auto_slide_'.$this->passclass_ext.$data,$best_guess.'@@'. $gtype.'@@'.serialize($grid_post_percent_arr).'@@'.$maxwidth);
        }//not page slide show... and edit mode...
		else if ($type==='page'){//edit && non-edit
			$shadowcalc=0;
			if (!empty($this->viewport_current_width)&&$this->viewport_current_width>200){
				$image_width=$this->viewport_current_width;
				}
			else $image_width=600;//best_guess will be javascript resized if smaller
			}
		if ($type!=='page'){//whether editmode or not.
			$pic_info_arr=explode('@@',file_get_contents(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'auto_slide_'.$this->passclass_ext.$data));
			list($best_guess,$gtype,$grid_width_chosen_arr,$maxwidth)=$pic_info_arr;
			$grid_width_chosen_arr=(!empty($grid_width_chosen_arr))?unserialize($grid_width_chosen_arr):'';////array becomes size of pic plugging in viewport
			if (!empty($this->viewport_current_width)&&$this->viewport_current_width>200){
				 //check viewport width not artificially high from zooming out...ie not greater than initial column net_width[0]...
				if ($gtype==='rwd'){ 
					list($key,$width_value)=check_data::key_up($grid_width_chosen_arr,$this->viewport_current_width,'keyval'); 
					$image_width=min($width_value,$this->viewport_current_width);  //not used *$wpercent/100; 
					}
				else {//non rwd 
					$total_width_available=$this->current_net_width; 
					$total_width_available=min($total_width_available,$this->viewport_current_width);
					$image_width=$total_width_available;
					} 
				}//viewpoint small
			else {
				$image_width=$best_guess; 
				}
			}//end if type not = page 
		$image_size=check_data::key_up($this->page_cache_arr,$image_width,'val',$this->max_width_limit);//image size used from image directory 
		$respond_data=' data-wid="'.$image_size.'" '; 
		$image_width_dir=Cfg::Response_dir_prefix.$image_size.'/';
		$this->image_resize_msg=''; 
		$width_available=$image_width-$shadowcalc; 
		list($image_max_width,$padtop)=process_data::max_width($width_available,$init_ratio,$minAspect,$maxAspect);//affects padding used in blog post slideshow with javascript fade in/out choice
		$picdir=Cfg_loc::Root_dir.Cfg::Auto_slide_dir;
     if ($type==='page')$maxfullwidth=max($this->page_cache_arr);
     else {
        $maxfullwidth=(!Cfg::Conserve_image_cachespace||(!$this->flex_grow_enabled&&!$this->flex_box_item))?$this->max_width_limit:$this->current_net_width*1.5; 
        $limiter=$this->max_width_limit;
        $maxfullwidth=check_data::key_up($this->page_cache_arr,$maxfullwidth,'val',$limiter);
        }
     $dir=Cfg_loc::Root_dir.Cfg::Auto_slide_dir.Cfg::Response_dir_prefix;
		if ($this->edit){//generate images for all sizes
        ################################ begin
			$this->show_more('Image Quality Info','noback','','',400,'','float:left;',true);
			$this->print_wrap('Quality info wrap');
			$page_arr=check_data::return_pages(__METHOD__,__LINE__,__FILE__);
			foreach (explode(',',$this->$pic_field) as $picname){
				$this->auto_slide_arr[]=array('id'=>$this->blog_id,'data'=>$data,'picname'=>$picname,'is_clone'=>$this->is_clone,'clone_local_style'=>$this->clone_local_style,'clone_local_data'=>$this->clone_local_data,'maxwidth'=>$maxfullwidth,'quality'=>$quality,'quality_option'=>$option_field_arr[$image_quality_index]); 
				$parr=array();
				$total=$x=0;
          if (is_file(Cfg_loc::Root_dir.Cfg::Upload_dir.$picname)){ 
             foreach($this->page_cache_arr as $ext){ 
               (!is_dir($dir.$ext))&&mkdir($dir.$ext,0755,1);
               if ($ext <=$maxfullwidth){ 
                  if (!is_file($dir.$ext.'/'.$picname)||isset($_POST[$data.'_'.$option_field][$image_quality_index])){
                    image::image_resize($picname,$ext,0,0,Cfg_loc::Root_dir.Cfg::Upload_dir, $dir.$ext,'file',NULL,$quality);
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
                  }//if less than maxfullwidth
               elseif (is_file(Cfg::Conserve_image_cachespace&&$dir.$ext.'/'.$picname)&&!Sys::Pass_class){//size cache of this image is unnecessary as maxwidth is less
                  foreach($page_arr as $page_ref){ 
                    $file='image_info_auto_slide_'.$page_ref;//figuring out max image size necessary for imagine caching ie. theere is purpose to this!!
                    if (is_file(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Image_info_dir.$file)){
                       $array=unserialize(file_get_contents(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Image_info_dir.$file)); 
                       foreach ($array as $index => $arr){
                         if (!array_key_exists('maxwidth',$arr))continue;
                         if ($arr['id']===$this->blog_id){
                            if ($arr['maxwidth']>=$ext){
                              $flag=false;
                              break;
                              }
                            } 
                         }//foreach
                       }//else is file
                    }//foreach page
                  if ($flag){	
                    unlink($dir.$ext.'/'.$picname); //save disk space
                    (Cfg::Development)&&mail::info($dir.$ext.'/'.$picname. ' was unlinked');
                    }
                  }// else if is_file
               }//end foreach ext
             if ($x >0){
               $this->print_wrap('image info quality','editbackground editfont floatleft left fsmnavy Od3green '.$this->column_lev_color);
               printer::horiz_print($parr); 
               $avgdensity=round($total/$x,3);
               $filesize=filesize(Cfg_loc::Root_dir.Cfg::Upload_dir.$picname)/1000;
               $size=process_data::get_size($picname,Cfg_loc::Root_dir.Cfg::Upload_dir);
               $width=$size[0];
               $height=$size[1];
               $density=round($filesize*1000/($size[0]*$size[1]),3);
               $filesize=round($filesize,1);
               $msg="<span class=\"navy whitebackground\">$picname </span><br>avg. pixel/area density: $avgdensity<br>
               @ Quality: $quality <br>
               Uploaded Master Img in uploads/:<br>
               filesize: $filesize Kb<br>
               width: {$width}px<br>
               height: {$height}px <br>
               density: $density ";
               echo $msg;
               printer::close_print_wrap('image info quality');
               }//x > 0
             }
          else {
             $msg="Missing Auto Slide Image: $picname";
             printer::alert_neg($msg);
             mail::alert($msg);
             }
				}//foreach picname
			 printer::close_print_wrap('Quality info wrap');	
			$this->show_close('Image Quality Info');
			############################### end
			}//if edit
		if (!$this->edit){
        $arr=array();
			foreach (explode(',',$this->$pic_field) as $picname){
				foreach($this->page_cache_arr as $ext){ 
					if ($ext <= $maxfullwidth){ //echo NL.$dir.$ext.'/'.$picname . ' is curr dir';
						if (!is_file($dir.$ext.'/'.$picname)){ 
							//image::image_resize($picname,$ext,0,0,Cfg_loc::Root_dir.Cfg::Upload_dir, $dir.$ext,'file',NULL,$quality);
							$arr[]="Image cache generation required for webpage mode rendering of $dir $ext / $picname";
							}
						}
					}//foreach
				}//foreach
        if (count($arr)>0){
          $msg='The following slide images were found missing in autoslide and can be regenerated in editmode automatically by going to this page '. Sys::Self.'. If problem persists set Cfg::Conserve_image_cachespace to false in Cfg_master.class.php or if set in Cfg.class.php set to false there
          ';
          $msg.=implode("/n",$arr);
          mail::alert($msg);
          }
			}//! edit
		if (!is_file($picdir.$image_width_dir.$pic_init)){// 
        if (Sys::Pass_class){
          $pic_init=Cfg::Pass_image;
          $alt='';
          $fullpicdir=Cfg_loc::Root_dir;
          }
		  else {
			  if(!is_file(Cfg_loc::Root_dir.Cfg::Upload_dir.$pic_init)){
					$msg='Missing main master Image File uploads/'.$pic_init;
					mail::alert($msg);
					return;
					}
          else {
					image::image_resize($pic_init,$image_size,0,0,Cfg_loc::Root_dir.Cfg::Upload_dir, $picdir.$image_width_dir,'file',NULL,$quality);//happens on non editpages...
					mail::alert('non edit auto_slide resize for '.$picdir.$image_width_dir);
					}
			  $fullpicdir=$picdir.$image_width_dir;
			  }
		  }
		else $fullpicdir=$picdir.$image_width_dir; 
        //speed of transition
			//Set currentPicLink to piccount -1 in order to replace init_pic immediately with javascript version
			#displayauto
		if ($this->edit)$this->show_more('View Slideshow','','','','full','','float:left;',true);
		if (!$background_slide){
        echo'<div id="auto_slide_'.$inc.'" style="text-align:center;margin-left: auto; margin-right:auto; width:100%"  class="auto_slide">
        <p id="autoImgContain'.$inc.'" class="center marginauto sliderespond" '.$respond_data.'> 
        <img id="thePhoto'.$this->blog_id.'" class="thePhoto'.$inc.' auto_img_'.$inc.' heightauto" style="text-align: center;margin-top:'.$padtop.'%;margin-bottom:'.$padtop.'%;" src="'.$fullpicdir.$pic_init.'" alt="Auto Slide Show"></p> </div>
        <script >
        var myslide_'.$inc.' = Object.create(slideAuto); 
        myslide_'.$inc.'.maxWidth='.$maxwidth.';
        //myslide_'.$inc.'.widMaxPercent='.$wpercent.';
        myslide_'.$inc.'.shadowcalc='.$shadowcalc.';
        myslide_'.$inc.'.currentPicLink='.($piccount-1).'; 
        myslide_'.$inc.'.pic_order = 0; 
        myslide_'.$inc.'.imgId=\'thePhoto'.$this->blog_id.'\';
        myslide_'.$inc.'.autoImgContain=\'autoImgContain'.$inc.'\';
        myslide_'.$inc.'.divId=\'auto_slide_'.$inc.'\';
        myslide_'.$inc.'.minAspect='.$minAspect.';
        myslide_'.$inc.'.maxAspect='.$maxAspect.';
        myslide_'.$inc.'.minOpac='.$min_opac.'; 
        myslide_'.$inc.'.picClass=\'auto_img_'.$inc.'\';
        myslide_'.$inc.'.duration='.($transit*1000).'
        myslide_'.$inc.'.time='.($time*1000).';
        myslide_'.$inc.'.dir=\''.Cfg_loc::Root_dir.Cfg::Auto_slide_dir.'\'; 
        myslide_'.$inc.'.slideAuto_init("'.$this->blog_data1.'");
        </script>';
			}// if blog and not background slide
		elseif ($type==='blog'){#autolist li element background slide
			$height=$image_width/$minAspect; 
			echo '
				 <ul style="height:'.$height.'px" data-asp="'.$minAspect.'" data-wid="'.$image_width.'" class="limit backauto '.$type.'-slideshow-'.$field_id_val.'">';
				
			for ($i=0; $i<$piccount; $i++){
				echo '			
				<li><span style="background-image: url('.$fullpicdir.$pic_arr[$i].');">Image '.$pic_arr[$i].'</span><div><h3> </h3></div></li>';
				}
			echo '</ul>';
			}
		elseif ($type==='page'){#autolist li element background slide
			#displaypage
			#get background position x and y adjustment from $image_pos_data_arr;
			
			$height=$image_width/$minAspect; 
			echo '
				 <ul class="backauto '.$type.'-slideshow-'.$field_id_val.'" data-asp="'.$minAspect.'" data-wid="'.$image_width.'">'; 
			for ($i=0; $i<$piccount; $i++){
				$image=$pic_arr[$i];
				$image_mod=(strlen($image)<16)?$image:substr($image,-15);
				$current_posx=(array_key_exists($image_mod,$image_pos_data_arr)&&array_key_exists(0,$image_pos_data_arr[$image_mod]))?$image_pos_data_arr[$image_mod][0]:50;
				$current_posy=(array_key_exists($image_mod,$image_pos_data_arr)&&array_key_exists(1,$image_pos_data_arr[$image_mod]))?$image_pos_data_arr[$image_mod][1]:50;
				
				echo '			
				<li><span style="background-position-x:'.$current_posx.'%;background-position-y:'.$current_posy.'%;background-image: url('.$fullpicdir.$pic_arr[$i].');">Image '.$pic_arr[$i].'</span><div><h3> </h3></div></li>';
				}
			echo '</ul>';
			}
		if ($this->edit)$this->show_close('View Slideshow');
		if (!$this->edit)return; 
		if (!$this->is_clone){
			$this->show_more('Rearrange or Remove Slide Images','','','',900,'','float:left;',true); 
			echo '
			<div style="background:#'.$this->editor_background.'; color:#555; text-align:left; width:1000px; float:left;  border:3px solid #'.$this->redAlert.'; padding: 10px 30px 60px 30px;" ><!--Sorting-->
			
			<p id="updateMsg_'.$inc.'" class="pos larger editbackground editfont left"></p> 
			<p class="fsminfo editbackground editfont editcolor floatleft left">Drag Image To ReOrder Slide Show. <br> <span class="neg">Check box to delete images.</span></p>';
			printer::pclear();
			echo'<ul id="sort_'.$inc.'" data-id="'.$sort_id.'" data-inc="'.$inc.'" class="nolist sortSlide" >';//#sort
			$x=0;
			foreach ($pic_arr as $image){
				printer::printx('<li class="floatleft fs1npinfo" id="autosort!@!'.$image.'!@!'.$x.'"><input type="checkbox" name="'.$delete.'['.$field_id_val.'][]" value="'.$image.'"><img src="'.Cfg_loc::Root_dir.Cfg::Auto_slide_dir.Cfg::Image100_dir.$image.'" height="75" alt="image rearrange"></li>');
				$x++;
				}
			echo '</ul>'; 
			echo '</div><!--Sorting-->';
			printer::pclear(10);	
			$this->show_close('Rearrange or Remove Slide Images');
			if ($type==='page') {// is page
				$this->show_more('Individually Optimize Image Positioning','','','',900,'','float:left;',true); 
				echo '<div class="fsminfo editbackground editfont editcolor floatleft"><!--wrap slide image pos adjust-->';
				$length=15;//long filenames are shortened to last 15 characters
				printer::printx('<p class="floatleft tip">Optimize you slideshow positioning to show most important part of image on all screen orientations.  The Viewers screens may be horizontally or Vertically (mobile) oriented and images may have longer widths or heights. This slideshow covers the screen entirely so for example on 16:9 width to height desktop display of a vertically oriented will crop the centered top and bottom evenly by default  whereas the full width will appear regardless of how your horizontally positioning is set! So if the better part of the image is near the top third you would choose a 33% vertical adjustment for that image. Similarly adjust for the prime horizontal portion if not centered for situations where horizontal cropping occurs</p>');
				printer::pclear();
				$update_slide=false;
				foreach ($pic_arr as $image){
					$image_mod=(strlen($image)<16)?$image:substr($image,-15);
					if ($this->edit&&isset($_POST['submit'])&&isset($_POST['pageslide'][$image_mod])){
						if (isset($_POST['pageslide'][$image_mod][0])){
							if (!isset($image_pos_data_arr[$image_mod])) 
							$image_pos_data_arr[$image_mod]=array(); 

							$image_pos_data_arr[$image_mod][0]=$_POST['pageslide'][$image_mod][0];
							}//! is array
						if (isset($_POST['pageslide'][$image_mod][1])){
							if (!isset($image_pos_data_arr[$image_mod])) 
							$image_pos_data_arr[$image_mod]=array(); 

							$image_pos_data_arr[$image_mod][1]=$_POST['pageslide'][$image_mod][1];
							}//! is array
							 
						$update_slide=true;
						}//if post submitted and image_mod submitted
					$current_posx=(array_key_exists($image_mod,$image_pos_data_arr)&&array_key_exists(0,$image_pos_data_arr[$image_mod]))?$image_pos_data_arr[$image_mod][0]:50;
					$current_posy=(array_key_exists($image_mod,$image_pos_data_arr)&&array_key_exists(1,$image_pos_data_arr[$image_mod]))?$image_pos_data_arr[$image_mod][1]:50;
					echo '<div class="fsminfo floatleft">';
					printer::printx('<p class="floatleft fs1npinfo"> <img src="'.Cfg_loc::Root_dir.Cfg::Auto_slide_dir.Cfg::Image100_dir.$image.'" height="75" alt="image rearrange"></p>');
					printer::pclear();
					printer::printx('<p class="floatleft editcolor editbackground editfont fs1npinfo">Adjust Image Horizontally</p>');
					$this->mod_spacing('pageslide['.$image_mod.'][0]',$current_posx,0,100,1,'%');
					printer::pclear();
					printer::printx('<p class="floatleft editcolor editbackground editfont fs1npinfo">Adjust Image Vertically</p>');
					$this->mod_spacing('pageslide['.$image_mod.'][1]',$current_posy,0,100,1,'%');
					echo '</div>';
					}//foreach
				if ($update_slide){
					$q="update $this->master_page_table set page_tiny_data3='".serialize($image_pos_data_arr)."',page_update='".date("dMY-H-i-s")."', page_time=".time().",token='".mt_rand(1,mt_getrandmax()). "' where page_id=$this->page_id";
             $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
					if ($this->mysqlinst->affected_rows())
						$this->success[]="Updated Auto Page Slide Show Positioning";
					else
						$this->message[]="No affected Rows result to update of Auto Page Slide Show";
					}//update slide
				echo '</div><!--wrap slide image pos adjust-->';
				$this->show_close('Individually Adjust Image Positioning');
				}	
			}//$this->blog_table_base==$this->pagename
		}//!empty blog_data1
	else {
		//$width_available=($this->current_net_width*$wpercent/100);
		$time=8;
		$transit=.8;
		$sizes='';//$this->get_size_string($pic_init, Cfg_loc::Root_dir.Cfg::Auto_slide_dir); 
		}
	printer::pclear();
	if (!$this->edit)return;
	if ($this->clone_local_style||!$this->is_clone){ 
		$this->show_more('Configure Your Slide Show','','','',600,'','float:left;',true);
		echo '<div class="fsminfo editbackground editfont '.$this->column_lev_color.' left floatleft"><!--Configure slide show-->';
		if ($type==='blogx'){
			$checked1=$checked2='';
			if($background_slide)$checked2='checked="checked"'; 
			else $checked1='checked="checked"';
			echo '<div class="fsminfo editbackground editfont '.$this->column_lev_color.' left floatleft">Choose Your SlideShow type. ';
			printer::alertx('<p class="info" title="Javascript fade in/out accomodates various image shapes"><input type="radio" value="1" name="'.$data.'_blog_tiny_data1" '.$checked1.'>Javascript Slide Show with Simple Fade In/Out-Shows full Images when using various images having different shapes</p>');
			printer::pclear();
			printer::alertx('<p class="info" title="Background Slider with CSS smooth Cross Fade Transition. Best if Images have same shape (aspect ration)"><input type="radio" value="background_slide" name="'.$data.'_blog_tiny_data1" '.$checked2.'>CSS slide with cross fade. Best if images have similar aspect ratio (shape).</p>'); 
			echo '</div><!--Choose Your SlideShow type-->';
			}
		elseif ($type==='page'){ 
			printer::pclear();
			echo '<div class="fsminfo editbackground editfont floatleft"><!--Edit autoslide Switch time-->'; 
			echo '<p class="'.$this->column_lev_color.' editfont ">Adjust Speed of Fade-In/Fade-out Effect:</p>';
			 $this->mod_spacing($data.'_'.$option_field.'['.$transit_index.']',$transit,.2,1.4,.1,'secs');
			echo '</div><!--Edit autoslide Switch time-->'; 
			}
		printer::pclear(); 
		$background_graphic=(false)?'background: transparent url(../graphics/slidepattern.png) repeat;':''; 
		echo '<div class="fsminfo editbackground editfont floatleft"><!--Edit autoslide Switch time-->'; 
			echo '<p class="'.$this->column_lev_color.' editfont ">Customize Time between Photo Changes:</p>';
			 $this->mod_spacing($data.'_'.$option_field.'['.$time_index.']',$time,3,14,1,'secs');
		echo '</div><!--Edit autoslide Switch time-->';
		printer::pclear();
		echo'<div class="floatleft editbackground editfont fsminfo highlight" title="By Default Uploaded Slide Show Images will have a Default Quality factor with 100 being the highest and 10 the lowest. The higher the image quality the larger the filesize and the slower the download speed. Its also possble change the Default value in the Page Configuration options which will effect all uploaded images on the site that are not specifically configured for this value in the post type: image, slideshow, or gallery configurations" ><!--quality image-->Change Current Image Quality setting:';
     $this->mod_spacing($data.'_'.$option_field.'['.$image_quality_index.']',$quality,10,100,1,'%');
     printer::print_info('Images will auto reload @ new Quality setting');
     echo'</div><!--quality image-->';
        printer::pclear();
     $this->submit_button();
		echo '</div><!--Configure slide show-->';
		$this->show_close('Configure Your Slide Show'); 
     }//if ($this->clone_local_style||$this->pagename==$this->blog_table_base){
	if (!$this->is_clone){
		$this->print_wrap('upload slide image','editbackground editfont Os3salmon fsminfo');
		printer::alert('Click here for the Image Uploader to add a new photo to the Automatic Slideshow.','',$this->column_lev_color.' left floatleft ');
     $width_available=(isset($width_available))?$width_available:600;//width available may not be set yet as with page type
		printer::printx('<p class="navy underline"><a href="add_page_pic.php?www='.$width_available.'&amp;ttt='.$table.'&amp;fff='.$pic_field.'&amp;id='.$field_id_val.'&amp;id_ref='.$field_id.'&amp;bbb=auto_slide&amp;pgtbn='.$this->pagename.'&amp;quality='.$quality.'&amp;postreturn='.Sys::Self.'&amp;append=append&amp;css='.$this->roots.Cfg::Style_dir.$this->pagename.'&amp;no_image_resize&amp;sess_override&amp;sess_token='.$this->sess->sess_token.'">Upload A New SlideShow Image</a></p>');
		printer::close_print_wrap('upload slide image');
		}
	if ($type!=='page'){
     $this->edit_styles_close($data,'blog_data4','#thePhoto'.$this->blog_id,'borders,box_shadow','Style Slide Image Border',false,'',true);
     
     $this->edit_styles_close($data,$style_field,'.'.$this->dataCss,'background,padding_top,padding_bottom,padding_left,padding_right,margin_top,margin_bottom,margin_left,margin_right,borders,box_shadow,outlines,radius_corner','Edit Auto Slide General Post Styles',true,'',true);
     }
   if ($background_slide){ 
     $total_duration=$time*$piccount; 
     switch($type){
        case 'blog' :
          $limit='position:relative;margin:0 auto;';
          $position='absolute';
          break;
        case 'page':
          $limit='width:100%';
          $position='fixed';
          break;
        default :
          mail::alert('auto slide show type not specified');
        }
     $background_graphic=(false)?'background: transparent url(../graphics/slidepattern.png) repeat;':''; 
     $this->css.= '
   .limit{'.$limit.'}	
	.'.$type.'-slideshow-'.$field_id_val.',
   .'.$type.'-slideshow-'.$field_id_val.':after { 
     position: '.$position.';
     width: 100%;
     height: 100%;
     top: 0px;
     left: 0px;
     z-index: -1; 
     } 
   .limit {'.$limit.'}
   .'.$type.'-slideshow-'.$field_id_val.':after { 
     content: \'\';
     '.$background_graphic.'
     }
   .'.$type.'-slideshow-'.$field_id_val.' li span { 
  width: 100%;
  height: 100%;
  position: absolute;
  top: 0px;
  left: 0px;
  color: transparent;
  background-size: cover;
  background-position: 50% 50%;
  background-repeat: no-repeat;
  opacity: 0;
  z-index: 0;
	-webkit-backface-visibility: hidden;
  -webkit-animation: imageAnimation '.$total_duration.'s linear infinite 0s;
  -moz-animation: imageAnimation '.$total_duration.'s linear infinite 0s;
  -o-animation: imageAnimation '.$total_duration.'s linear infinite 0s;
  -ms-animation: imageAnimation '.$total_duration.'s linear infinite 0s;
  animation: imageAnimation '.$total_duration.'s linear infinite 0s; 
   }
   .'.$type.'-slideshow-'.$field_id_val.' li:nth-child(1) span { 
  }';

     for ($i=1; $i<$piccount; $i++){ 
        $this->css.='
   .'.$type.'-slideshow-'.$field_id_val.' li:nth-child('.($i+1).') span { 
  -webkit-animation-delay: '.($i*$time).'s;
  -moz-animation-delay: '.($i*$time).'s;
  -o-animation-delay: '.($i*$time).'s;
  -ms-animation-delay: '.($i*$time).'s;
  animation-delay: '.($i*$time).'s; 
   }';
        }//end for
     $ease_in_out=2.75 /$total_duration*100;//2.75 refers to secs of transiton
     $beg_ease_out=$time /$total_duration *100 ;//basically the setting of time intervals - one ease_in_out because the easing in and easing out overlap
     $full_again=$beg_ease_out+$ease_in_out;//basically addding in time of another ease in out transition
     
     /* Animation for the slideshow images */
     $this->css.= '
@-webkit-keyframes imageAnimation { 
  0% { opacity: 0;
  -webkit-animation-timing-function: ease-in; }
  '.$ease_in_out.'% { opacity: 1;
     -webkit-animation-timing-function: ease-out; }
  '.$beg_ease_out.'% { opacity: 1 }
  '.$full_again.'% { opacity: 0 }
  100% { opacity: 0 }
   }
@-moz-keyframes imageAnimation { 
  0% { opacity: 0;
  -moz-animation-timing-function: ease-in; }
  '.$ease_in_out.'% { opacity: 1;
     -moz-animation-timing-function: ease-out; }
  '.$beg_ease_out.'% { opacity: 1 }
  '.$full_again.'% { opacity: 0 }
  100% { opacity: 0 }
   }
@-o-keyframes imageAnimation { 
     0% { opacity: 0;
  -o-animation-timing-function: ease-in; }
  '.$ease_in_out.'% { opacity: 1;
     -o-animation-timing-function: ease-out; }
  '.$beg_ease_out.'% { opacity: 1 }
  '.$full_again.'% { opacity: 0 }
  100% { opacity: 0 }
   }
@-ms-keyframes imageAnimation { 
  0% { opacity: 0;
  -ms-animation-timing-function: ease-in; }
  '.$ease_in_out.'% { opacity: 1;
     -ms-animation-timing-function: ease-out; }
  '.$beg_ease_out.'% { opacity: 1 }
  '.$full_again.'% { opacity: 0 }
  100% { opacity: 0 }
   }
@keyframes imageAnimation { 
  0% { opacity: 0;
  animation-timing-function: ease-in; }
  '.$ease_in_out.'% { opacity: 1;
     animation-timing-function: ease-out; }
  '.$beg_ease_out.'% { opacity: 1 }
  '.$full_again.'% { opacity: 0 }
  100% { opacity: 0 }
		}';
     }//if background_slide
   else {
      $this->css.='
      .'.$this->dataCss.' img{width:100%;height:auto;}
      ';
     }
   ($this->edit&&$this->overlapbutton)&&$this->overlapbutton();
	}// end auto slide 1
	
#social	
function social_icons($data,$style_list='',$global=false,$mod_msg="Edit styling",$blog=false,$pagename=''){ 
	$colorname='lightestblue,lavendor,lightlightblue,lightblue,ekaqua,electricblue,ekblue,blue2,trueblue,darkerblue,navyblue,lighterred,lightred,ekredorange,red,maroon,orange,brilliantpinkpurple,ekmagenta,purple,ekdarkpurple,electricgreen,lime,lightgreen,green,forest,olive,yellow,gold,lightbrown,brown,white,black';
	$colorname_arr=explode(',',$colorname);
	$corecolor=(preg_match(Cfg::Preg_color,$this->blog_data5))?' style="background:#'.$this->blog_data5.';"':'';
	$icon_arr=array('facebook','linkedin','pinterest','rss','email','twitter','youtube','myspace','google','instagram');
	$range1=10;
	$range2=150;
	$unit='px'; 
	$increment=1;
	$num=0;
	$wid_size=75;
	$default_icon_size=50;
   $old_arr=unserialize($this->blog_data1);
	if (isset($_POST[$data.'_socialdata'])){
     $social_arr=$_POST[$data.'_socialdata'];
     if (!empty(trim($this->blog_data1))&&$this->isSerialized($this->blog_data1)){  
        $old_arr=unserialize($this->blog_data1); 
			$max_key_social = max(array_keys($social_arr));
			$max_key_old = max(array_keys($old_arr));
			$max_key=max($max_key_social,$max_key_old);
			for ($i=0;$i<=$max_key;$i++){ // here we replace any values for for newly edited with old edited..  array still imcomplete
				if (array_key_exists($i,$social_arr)&&is_array($social_arr[$i])){
					for ($x=0; $x<4; $x++){
						if(!array_key_exists($x,$social_arr[$i])&&array_key_exists($i,$old_arr)&&array_key_exists($x,$old_arr[$i])){
							$social_arr[$i][$x]=$old_arr[$i][$x];
							} 
						}
					}
				else $social_arr[$i]=$old_arr[$i];
				}
			}
     
		$max_key = max(array_keys($social_arr));
		for ($i=0;$i<=$max_key;$i++){ // here we check for new array deletes
			if (array_key_exists($i,$social_arr)&&is_array($social_arr[$i])){
				if(!array_key_exists(0,$social_arr[$i])||strpos($social_arr[$i][0],'delete')!==false||trim($social_arr[$i][0])==='none'){
					(strpos($social_arr[$i][0],'delete')!==false)&&printer::alert_pos($social_arr[$i][0]); 
					array_splice($social_arr,$i, 1); 
					} 
				}
			} 
		$max_key = max(array_keys($social_arr));
		for ($i=0;$i<=$max_key;$i++){#make sure array implode has 0 put in
			if (!array_key_exists(0,$social_arr[$i])||!array_key_exists(1,$social_arr[$i])||!is_file(Cfg_loc::Root_dir.Cfg::Social_dir.$social_arr[$i][0].'/'.$social_arr[$i][1].'.gif')){
				$msg='For New Social Icons You must also select the icon color and this entry has been deleted';
				$this->message[]=$msg; 
				array_splice($social_arr,$i, 1);
				}
			}
     sort($social_arr);
      $q="update $this->master_post_table set blog_time=".time().",token='".mt_rand(1,mt_getrandmax()). "',blog_data1='".serialize($social_arr)."' where blog_table='$this->blog_table' and blog_order=$this->blog_order"; 
		$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
		$msg="Your Icons have been Edited";
		$this->success[]=$msg;
		$socialdata=$social_arr;
		}//is post social
	else if(!empty($this->blog_data1)&&$this->isSerialized($this->blog_data1)){
     $socialdata=unserialize($this->blog_data1);
     sort($socialdata);
     }
	else $socialdata=''; 
	$element=($this->blog_data2=='vertical')?'p':'span';
	$style=($this->blog_data2==='vertical')?' padding-top:':' padding-left:';
	$style=(is_numeric($this->blog_data3)&&$this->blog_data3>0)?' style="'.$style.$this->blog_data3.'px;"':' style="'.$style.'0px;"';
	$this->edit_styles_open();
	($this->edit)&&  
			$this->blog_options($data,$this->blog_table);
	if (is_array($socialdata)){
		foreach ($socialdata as $choices){
		if (!array_key_exists(2,$choices))$choices[2]=$default_icon_size;//default size value
		if (!array_key_exists(3,$choices))$choices[3]='http://www.put_your_site_here.com';// 
			$shape_dir=(!empty($this->blog_data4)&&is_dir(Cfg_loc::Root_dir.Cfg::Social_dir.$choices[0].'/'.$this->blog_data4))?$this->blog_data4.'/':'';
			echo '<'.$element.$style.'><a href="'.$choices[3].'"  style="text-decoration: none"> <img '.$corecolor.' src="'.Cfg_loc::Root_dir.Cfg::Social_dir.$choices[0].'/'.$shape_dir.$choices[1].'.gif" width="'.$choices[2].'" height="'.$choices[2].'" alt="'.$choices[0].' Social Icon Link"></a></'.$element.'>';
			}
		}//is array socialdata
	printer::pclear(3);
	if (!$this->edit)return;
	if(!$this->is_clone&&is_array($socialdata)&& !arrayhandler::is_empty_array($socialdata)){ 
		$this->show_more('Edit/Delete Previous Icon Choices','noback','','',400,'','float:left;',true); 
		 foreach ($socialdata as $choices){
			if (!array_key_exists(2,$choices))$choices[2]=$default_icon_size;//default size value
        if (!array_key_exists(3,$choices))$choices[3]='http://www.put_your_site_here.com';// 
        echo '<div class="fs2black editbackground editfont maxwidth400 "><!--edit prev icon choice-->';
        //echo'<p><input type="hidden" name="'.$data.'_socialdata['.$num.'][0]" value="'.$choices[0].'"></p>';
        
        echo'<p class="'.$this->column_lev_color.' floatleft editbackground editfont editcolor">Edit: <img '.$corecolor.' src="'.Cfg_loc::Root_dir.Cfg::Social_dir.$choices[0].'/'.$choices[1].'.gif" width="'.$choices[2].'" height="'.$choices[2].'" alt="mychoice icon" ></p>';
        printer::pclear(5); 
        echo '<p class="'.$this->column_lev_color.' floatleft editfont"><input type="checkbox" name="'.$data.'_socialdata['.$num.'][0]." value="'.$choices[0].' is deleted" >Check Here to Delete this icon</p>'; 
        printer::pclear(5); 
        $this->show_more('Change your icon color','noback','','',600,'','float:left;',true);
        for ($i=0;$i<count($colorname_arr);$i++){
          $select=($colorname_arr[$i]===$choices[1])?' checked="checked" ' :'';
           echo '<p class="editbackground editfont floatleft left"><input type="radio" name="'.$data.'_socialdata['.$num.'][1]." '.$select.' value="'.$colorname_arr[$i].'"><img '.$corecolor.' src="'.Cfg_loc::Root_dir.Cfg::Social_dir.'facebook/'.$colorname_arr[$i].'.gif" width="'.$wid_size.'" height="'.$wid_size.'" alt="dropdown choices menu '.$colorname_arr[$i].'" ></p>';
          }//end for loop colors
        printer::pclear();
        $this->show_close('color');//<!--show more color-->p class="'.$this->column_lev_color.' editfont">Change Your Image size</p> ';
        printer::pclear(8); 
        $size=(array_key_exists(2,$choices)&&!empty($choices[2]))?$choices[2]:$default_icon_size;
        echo '<div class="fsminfo fs1color"><!--icon size-->';
        printer::alertx('<p class="editbackground editfont '.$this->column_lev_color.' rad3 floatleft">Change the size of your Social Icon: </p>');
        echo '
        <p class="'.$this->column_lev_color.'  editfont left">Currently: '.$size.$unit.'<br>';
        $msgjava='Choose Social Icon Size:';
        $this->mod_spacing($data.'_socialdata['.$num.'][2]',$size,$range1,$range2,$increment,$unit,'',$msgjava); 
        echo '</div><!--Change Icon Size-->';
        printer::pclear(8);
        $value3=(array_key_exists(3,$choices))&&!empty($choices[3])?$choices[3]:'http://';
        echo '<div class="fsminfo"><!--edit social url choice-->';
        echo '
        <p class="'.$this->column_lev_color.' editbackground editfont editcolor">Change Your Icon Url&nbsp;<br><input style="cursor:pointer;background:#'.$this->editor_background.';color:#'.$this->editor_color.';" type="text" name="'.$data.'_socialdata['.$num.'][3]" value="'.$value3.'" maxlength="150"></p>';
        echo '</div><!--edit social url choice-->';
        printer::pclear(8);
        $this->submit_button();
        $num++;
        echo '</div><!--edit prev icon choice-->';
        printer::pclear(12); 
        }//end foreach edit previous
		$this->show_close('Previous Icon Choices');//<!--Show More Edit Previous Icon Choices--> 
     printer::pclear(8); 
		}//if not empty social data
	if (!$this->is_clone){
		$this->show_more('Add a new Social Icon','noback','','',600,'','float:left;',true);
		echo '<div class="fs2black editbackground editfont floatleft"><!--Add new-->';
		echo '
		<p class="left '.$this->column_lev_color.'  editbackground editfont editcolor">Choose Your Link Color Size and URl Here</p>';
		echo '<div class="fsminfo editbackground editfont '.$this->column_lev_color.' " ><!--link type-->Pick a link type:';
		printer::pclear(5);
		foreach ($icon_arr as $icon){
        echo '<p class="floatleft left"><input type="radio" name="'.$data.'_socialdata['.$num.'][0]" value="'.$icon.'"><img src="'.Cfg_loc::Root_dir.Cfg::Social_dir.$icon.'/trueblue.gif" width="'.$wid_size.'" height="'.$wid_size.'" alt="dropdown choices menu '.$icon.'" > </p>';
        }
     printer::pclear();
		echo '</div><!--link type-->';
		printer::pclear(5);
		echo '<div class="fsminfo editbackground editfont " ><!--link color--><br>';
		echo '<p class="'.$this->column_lev_color.' editbackground editfont editcolor">Choose Your Color: </p>';
		printer::pclear(5);
		for ($i=0;$i<count($colorname_arr);$i++){
			 echo '<p class="floatleft left" ><input type="radio" name="'.$data.'_socialdata['.$num.'][1]." value="'.$colorname_arr[$i].'"><img src="'.Cfg_loc::Root_dir.Cfg::Social_dir.'facebook/'.$colorname_arr[$i].'.gif" width="'.$wid_size.'" height="'.$wid_size.'"  alt="dropdown choices menu '.$colorname_arr[$i].'"></p>';
			}//end for loop colors
     printer::pclear();
		echo '</div><!--link color-->'; 
		printer::pclear(8);
		echo'<div class="fsminfo editbackground editfont floatleft"><!--choose size-->';
		echo '<p class="'.$this->column_lev_color.' left">Choose Your Icon Size:<br>
		Choose:  
	  <select class="editcolor editbackground editfont" name="'.$data.'_socialdata['.$num.'][2]">    
	  <option value="'.$default_icon_size.'" selected="selected">'.$default_icon_size.'px</option>';
	  for ($i=$range1; $i<=$range2; $i+=$increment){
		  echo '<option value="'.$i.'">'.$i.$unit.'</option>';
		  }
		echo'	
	  </select> </p>';
	  echo '</div><!--choose size-->'; 
		printer::pclear(8);
		echo '<div class="fsminfo editbackground editfont "><!--Add URl-->';
		echo '<p class="'.$this->column_lev_color.' editbackground editfont editcolor">Add New Icon Url&nbsp;<input style="cursor:pointer;background:#'.$this->editor_background.';color:#'.$this->editor_color.';" type="text" name="'.$data.'_socialdata['.$num.'][3]" value="http://" maxlength="100"></p>';
     $this->submit_button();
		echo '</div><!--Add URl-->';
		echo '</div><!--Add new-->';
		$this->show_close('Add New Icon Choices');//<!--Show More Edit Add New Icon Choices--> 
		} 
	if ($this->clone_local_style||!$this->is_clone){ 
		printer::pclear(8);
		$msg='Edit Your Icon Shape/Icon Core Color/Horiz-Vert/Spacing';
		$this->show_more($msg,'noback','','',400,'','float:left;',true);//<!--shape vert spacing-->
		echo '<div class="editbackground editfont maxwidth400 fs1color"><!--Edit Icon Shape spacing-->';
		echo '<div class=" width300 fsminfo editbackground editfont"><!--Edit Icon Shape-->';
		$checked1=($this->blog_data4!=='round')?'checked="checked"':'';
		$checked2=($this->blog_data4==='round')?'checked="checked"':'';
		echo '<p class="'.$this->column_lev_color.' editbackground editfont editcolor">Edit Which Icon Shape to Use:</br> 
		 <input type="radio" name="'.$data.'_blog_data4" value="square" '.$checked1.'>Square </br>
      <input type="radio" name="'.$data.'_blog_data4" value="round" '.$checked2.'>Round</p>'; 
		echo '</div><!--Edit Icon Shape-->';
		echo '<div class="fsminfo editbackground editfont"><!--Edit Icon Vert Horiz-->';
		$checked1=($this->blog_data2!=='vertical')?'checked="checked"':'';
		$checked2=($this->blog_data2==='vertical')?'checked="checked"':'';
		echo '<p class="'.$this->column_lev_color.' editbackground editfont editcolor">Select Horizontal or Vertical Display for Your Icon Grouping:</br> 
		<input type="radio" name="'.$data.'_blog_data2" value="horizontal" '.$checked1.'>Horizontal</br> 
		<input type="radio" name="'.$data.'_blog_data2" value="vertical" '.$checked2.'>Vertical</p>';
		echo '</div><!--Edit Icon Vert Horiz-->';
		echo '<div class="fsminfo editbackground editfont"><!--Edit Icon Center color-->';
		if (preg_match(Cfg::Preg_color,$this->blog_data5)){
			$msg="Change the Current Icon Core Color, Use 0 to remove: #";
			}
     else {
        $msg= (!empty($this->blog_data5))?$this->blog_data5 . ' is not a valid color code. Enter a Code/Click On to Open the Color finder tool to Add a Color to the Icon Center!':'Enter a Code/Click On to Open the Color finder tool to Add a Color to the Icon Center!: #';
        }
		printer::printx('<p class="highlight floatleft" title="The center core color of your social icon by default will be the color of your background. Add a custom color here">Customize the Center color of your icon choice</p>');
		$this->{$data.'_blog_data5_arrayed'}=array();
		$this->{$data.'_blog_data5_arrayed'}[0]=$this->blog_data5;
		$this->font_color($data.'_blog_data5_arrayed','0','blog_data5','Changing Icon Core Color');
		printer::pclear(); 
		echo '</div><!--Edit Icon Center Color-->';
		echo '<div class="fsminfo editbackground editfont"><!--Edit Icon Additional Spacing-->'; 
		echo '<p class="'.$this->column_lev_color.' editbackground editfont editcolor">Add Additional Space between Your Icons:</p>';
		 $this->mod_spacing($data.'_blog_data3_arrayed',$this->blog_data3,1,100,1,'px','none');
		echo '</div><!--Edit Icon Additional Spacing-->';
		echo '</div><!--Edit Icon Shape spacing-->';
		$this->show_close('shape vert spacing');//<!--shape vert spacing-->
		printer::pclear(8);
		$this->edit_styles_close($data,'blog_style','.'.$this->dataCss,'background,text_align,padding_top,padding_bottom,padding_left,padding_right',"Edit Social Icon styling",'','',true,true);
		}
   ($this->edit&&$this->overlapbutton)&&$this->overlapbutton();
	}//end function social icons..
   
#contact	
function contact_form($data,$style_list,$global=false,$mod_msg="Edit styling",$blog=false,$pagename=''){ 
	$this->noname='';
	$this->noemail='';
	$this->nomessage='';
	$mailsend=(isset($_GET['html'])||isset($_GET['htm']))?mail::Contact_loc_mailer:$_SERVER['PHP_SELF'];
	$default1_array=array('Your Name:','Subject:','Your Email:','Contact','Please enter your message:','none',1,'none',1);
	$default2_array=array(0,0,0,100);//veryold method
	$blog_data1=explode(',',$this->blog_data1);
	foreach ($default1_array as $key=> $val){
		if (!array_key_exists($key,$blog_data1)||empty($blog_data1[$key])){
			$blog_data1[$key]=$val;
			}
		}
	$blog_data6=explode(',',$this->blog_data6);
	foreach ($default2_array as $key=> $val){
		if (!array_key_exists($key,$blog_data6)||empty($blog_data6[$key])){
			$blog_data6[$key]=$val;
			}
		}
	$this->blog_data1=implode(',',$blog_data1);
	$image_array=array('0','10',0,'10');
	$blog_data4=(!empty($this->blog_data4))?explode(',',$this->blog_data4):$image_array;
	if (count($blog_data4)<4){
     $blog_data4=$image_array;
     $this->blog_data4=implode(',',$image_array);
     }
	$image_pad_left=$blog_data4[1];
	$image_pad_right=$blog_data4[3];
	$this->blog_data2=preg_replace('/\s/','',$this->blog_data2);
	$this->blog_data3=preg_replace('/\s/','',$this->blog_data3);
	$this->blog_data2=str_replace('<br>','',$this->blog_data2);//spacing control 
	$this->sent=false;//initialize : if true mail was sent
	$this->textarea_contact_default=$blog_data1[4];
	if (isset($_POST['mailsubmitted_'.$data])&&isset($_POST['email'])) $this->contact_mail_process($data,$blog_data1); 
	$color2=(preg_match(Cfg::Preg_color,$blog_data6[0]))?'#'.$blog_data6[0]:'inherit'; //input and textarea font color
	$back_color=(preg_match(Cfg::Preg_color,$blog_data6[1]))?$blog_data6[1]:'';
	$contact_border=(preg_match(Cfg::Preg_color,$blog_data6[2]))?$blog_data6[2]:'inherit';
	//input and textarea fields
	$color='inherit';//$this->current_color;
	$background='inherit';//$this->current_background_color;
	$upper_maxwidth=500*$this->current_font_px/16;//upper contact form max width
	$current_net_width=($this->current_net_width<$upper_maxwidth)?$this->current_net_width:$upper_maxwidth;
	$current_total_width_left=$current_net_width*.60;
	$size=process_data::input_size($current_total_width_left,$this->current_font_px,30);		$this->textarea_contact_default='';// no text in textarea on normal page!!
	$background_color_opacity=(!empty($blog_data6[3])&&$blog_data6[3]<100&&$blog_data6[3]>0)?$blog_data6[3]:100;
	$opacity=($background_color_opacity<100&&$background_color_opacity>0)?'@'.$background_color_opacity.'%&nbsp;Opacity ':'';
   if (!empty(trim($back_color))){
		if ($background_color_opacity <100) 
			$back_color=process_data::hex2rgba($back_color,$background_color_opacity);
		else $back_color='#'.$back_color;
		 
		$background_color='background-color: '.$back_color.';'; 
		
		}
	else $background_color='';	
	###display render for edit and non edit
	$show_image=false;
	$this->edit_styles_open();
	($this->edit)&&  
		$this->blog_options($data,$this->blog_table); 
	if($this->edit&&!$this->is_clone){		
		print '<fieldset class="border1 borderdouble" style="overflow:none;border-color:#'.$this->magenta.';"><!-- Wrap Normal Display Contact-->
		<legend style="background:white; color:#'.$this->magenta.';">Display Only: Use Editing Below</legend>'; 
		}
	else
		print'<form action="'. $mailsend.'?editmode" method="post"  onsubmit="return gen_Proc.validateReturn({funct:\'validateEntered\',pass:{idVal:\'name'.$data.'\',ref:\'name\'}},{funct:\'validateEmail\',pass:{idVal:\'email'.$data.'\'}},{funct:\'validateEntered\',pass:{idVal:\'message'.$data.'\',ref:\'message\'}});">';
	#### BEGIN NORMAL CONTACT POST  webpage FORM fields 
	$name=($this->edit)?'':'name="email[name_'.$data.']"';
	$subject=($this->edit)?'':'name="email[subject_'.$data.']"';
	$email=($this->edit)?'':'name="email[email_'.$data.']"';
	$messagename=($this->edit)?'email[\'nonameproxy\']':'email[message'.$data.']" id="message'.$data; 
	$vmsg=(!$this->sent&&isset($_POST['email']['message'.$data])&&isset($this->clean_message))?$this->clean_message:'textarea_contact_default';
	$vname=(!$this->sent&&isset($_POST['email']['name_'.$data])&&isset($this->clean_name))?$this->clean_name:'';
	$vemail=(!$this->sent&&isset($_POST['email']['name_'.$data])&&isset($this->clean_email))?$this->clean_email:''; 
	 #this is webform normal webpage
   #view webpage mode #contact webpage mode
	echo '<div class="contacttoptable">
    <p class="narrow">'.$blog_data1[0].'</p> 
	<input class="wide" type="text" '.$name.' id="name'.$data.'" maxlength="50" value="'.$vname.'"><span class="alertnotice">' . $this->noname . '</span> 
   <p class="clear">&nbsp;</p>
    <p class="narrow">'.$blog_data1[1].'</p>
    <input class="wide" type="text" '.$subject.' id="subject'.$data.'" maxlength="50" value="'.$blog_data1[3].'">
   <p class="clear">&nbsp;</p>
    <p class="narrow">'.$blog_data1[2].'</p>
  <input class="wide" type="text"  '.$email.' id="email'.$data.'" maxlength="50" size="50" value="'.$vemail.'" > <span class="alertnotice">' . $this->noemail . '</span>
	<p class="clear">&nbsp;</p>
    </div><!--contacttoptable-->';
   printer::pclear(1); 
   echo '<div class="contactbottomtable">'; 
   echo '
   <p class="form_message floatleft">'.$blog_data1[4].'<br></p>';
   $this->textarea($vmsg,$messagename,$this->current_net_width,$this->current_font_px,'','','',true); 	
   printer::pclear();
   echo '</div><!-- class="contactbottomtable"-->';	
   printer::pclear();
	echo '
	<p class="floatleft ht20"><input type="radio" value="nhuman" name="contact_status_check"><img class="pt5" src="'.Cfg_loc::Root_dir.Cfg::Graphics_dir.'nhuman.gif" width="94" alt="status"></p>';
	 
	echo '
	<p class="floatleft ht20"><input type="radio" value="yhuman" name="contact_status_check"><img class="pt5" src="'.Cfg_loc::Root_dir.Cfg::Graphics_dir.'yhuman.gif" width="94" alt="status"></p>';
	 #### END of webpage FORM Begin: edit default form fields and prompts
	 printer::pclear(10);
	if ($this->edit&&!$this->is_clone){
     $this->show_more('Change/Translate the Default Form Prompts Shown Above','noback','','',500); //form prompts
     echo'<div class="fsminfo editbackground editfont '.$this->column_lev_color.' editfont left"><!--Form defaults Modify-->
		 <div class="narrow fs1color" style="float:left; max-width:500px;"><!--narrow contact-->'; 
		$cols=process_data::width_to_col($current_net_width,$this->current_font_px);
		$mytext=(empty($this->blog_data5))?$this->default_blog_text:$this->blog_data5;
		echo'<p class="info" title="Change/translate the default contact form input Prompt Text for Name Subject Email and Message Here">Change/translate the default Form Prompts and Default Fill-in for the Subject Prompt Below</p> 
		  <p class="editfont narrow " style="background:#'.$this->editor_background.';color:#'.$this->editor_color.';">
		  '.$blog_data1[0].' </p> 
		 <input class="wide" style="background:#'.$this->editor_background.';color:#'.$this->editor_color.';" type="text"  name="'.$data.'_blog_data1[0]"   maxlength="50" value="'.$blog_data1[0].'"> 
		 <p class="clear">&nbsp;</p>
		 <p class="editfont narrow" style="background:#'.$this->editor_background.';color:#'.$this->editor_color.';">
		  '.$blog_data1[1].' </p>
		  <input class="wide" style="background:#'.$this->editor_background.';color:#'.$this->editor_color.';" type="text" name="'.$this->blog_table.'_'.$this->blog_order.'_blog_data1[1]"  size="'.$size.'" maxlength="50" value="'.$blog_data1[1].'">
		<p class="clear">&nbsp;</p>
		  <p class="editfont narrow" style="background:#'.$this->editor_background.';color:#'.$this->editor_color.';">
		 <span class="info" title="Change the default Subject fill-in"> '.$blog_data1[1].' </span></p>
		  <input class="wide" style="background:#'.$this->editor_background.';color:#'.$this->editor_color.';" type="text" name="'.$this->blog_table.'_'.$this->blog_order.'_blog_data1[3]" size="'.$size.'" maxlength="50" value="'.$blog_data1[3].'"> 
		 <p class="clear">&nbsp;</p>
		 <p class="editfont narrow" style="background:#'.$this->editor_background.';color:#'.$this->editor_color.';">  '.$blog_data1[2].'</p>
	  <input class="wide" style="background:#'.$this->editor_background.';color:#'.$this->editor_color.';" type="text" name="'.$this->blog_table.'_'.$this->blog_order.'_blog_data1[2]" value="'.$blog_data1[2].'" size="'.$size.'" maxlength="60" >
	  <p class="clear">&nbsp;';
		 echo '</div><!--narrow contact-->';  
		$msg='Change the Default Contact Message'; 
		
     printer::pclear(1); 
     echo '<div class="contactbottomtable">'; 
     echo '	 
		<p class="<p class="form_message floatleft">'.$blog_data1[4].'<br></p>
		<p ><textarea class="editfont" style="background:#'.$this->editor_background.';color:#'.$this->editor_color.';font-size:18px; width:90%" name="'.$this->blog_table.'_'.$this->blog_order.'_blog_data1[4]" cols="70" rows="1" >'.$blog_data1[4].'</textarea> </p>';
   printer::pclear();
   echo '</div><!-- class="contactbottomtable"-->';	
		echo'</div><!--Form defaults Modify-->';
		$this->show_close('Change/Translate the Default Form Prompts Shown Above');//form prompts
		echo '</fieldset><!--Wrap Normal Display Contact-->';
		} 
	else {
		print '<p class="alertnotice">' . $this->nomessage . '</p>';
		printer::pclear();
		echo'<p class="pt10"><input class="emailbutton" type="submit" name="submit" value="Send Email" ></p>
		 <p><input type="hidden" name="sess_token" value="'.$this->sess->sess_token.'" ></p>
		<p><input type="hidden" name="mailsubmitted_'.$data.'" value="TRUE" ></p>
		<p><input type="hidden" name="sentto" value="'.Cfg::Owner.'" ></p>
		</form> ';
		return;
		} 
	###end display for edit and non edit
   //style defaults will be overriden by editor choices
  $this->css.='
.'.$this->dataCss.' textarea {padding:5px 10px; width:98%;float:left;}
.'.$this->dataCss.' .contactbottomtable {width:98%;}
.'.$this->dataCss.' .contacttoptable,.'.$this->dataCss.' .narrow{float:left;text-align:left;}
	.'.$this->dataCss.' input.wide {
	padding: 3px 10px;	margin: 5px; border: 1px solid } 
   .'.$this->dataCss.' input.emailbutton {font-weight:600;font-family:inherit; padding:3px 5px; }
	.alertnotice {font-weight:800; color:#'.$this->redAlert.';}
	 .'.$this->dataCss.' input.wide {font-family:inherit; width:175px;}
	 .'.$this->dataCss.' .clear{clear:both; } 
   .'.$this->dataCss.' .form_message {padding:.7em 0 .15em 0; text-align: left; font-size: .9em; text-align: left; } 
	.'.$this->dataCss.' input.wide{text-align:left;float:left;max-width:300px;}
	 }
		}
	.'.$this->dataCss.' p.narrow,.'.$this->dataCss.' td.narrow label {text-align: left;float:left; width:100px; margin-top:10px }
	
	.'.$this->dataCss.' p.narrow label.information {color:#'.Cfg::Info_color.';}
	';
	if ($this->clone_local_style||!$this->is_clone){
     ######### contact config 
		if(empty($this->{'blog_data2'})):
			$msg=' Start Edit Here: Configure Email Addresses and other Contact Form Settings'; 
		else:
			$msg='Configure Contact Email Settings'; 
		endif; 
		echo '<div class="fs2moccasin floatleft editcolor editbackground editfont"><!--configure contact-->';
		$this->show_more($msg,'noback','',"Initial Configuration Requires Your Email Address: Add Below:",400,'','float:left;',true);//show more config
		echo'<div class="fsmblack editcolor editbackground editfont editcolor"><!--Contact Form Wrap-->';
		printer::alertx('<p class="editfont fsminfo editbackground editfont '.$this->column_lev_color.'"> Emails Will Be sent to the Address(es) You Add Here Whenever a User Submits this Contact Form. Use commas to separate multiple emails</p>');
		if (empty($this->blog_data2)) :
			$this->blog_data2=(preg_match(Cfg::Preg_email,Cfg::Contact_email))?Cfg::Contact_email:Cfg::Admin_email;
			$class='allowthis'; 
		else : $class='';
		endif;
		printer::alertx('<p class="editbackground editfont editcolor">Add/Change Contact Email Addresss(es)</p>');
     $this->textarea('blog_data2',$this->blog_table.'_'.$this->blog_order.'_blog_data2',$this->current_net_width,$this->current_font_px,'','left',90,false,$class);
		printer::pclear(); 
		if ($blog_data1[6]!=='admin_add')
        printer::alert('<input type="checkbox" name="'.$data.'_blog_data1[6]" value="admin_add" ><span class="information" title="Check this box to also send this contact form emails to the Administrator Email Address(s) set in the Cfg (configuration) Files. ">Check Here to Also Send Contact Emails to the Admin Email(s) '.str_replace(',',', ',Cfg::Admin_email).' </span>',false,'Os3black editfont left');
		else
			printer::alert('<input type="checkbox" name="'.$data.'_blog_data1[6]" value="noadminadd">Check Here to <span class="neg">DO NOT SEND </span> Contact Emails to the Admin Email(s) '.Cfg::Admin_email.' </span>',false,'editfont left'); 
		if ($blog_data1[8]==='none'){
			printer::alertx('<p class="editfont fsminfo editbackground editfont '.$this->column_lev_color.'" >Check Below to Deactivate All http:// Active Urls &#40;http:// website Links&#41; in the Messages you receive. Mistakenly hit Active URLs can potentially take you to a Malware Site. You can still copy the Url and manually paste into the address bar if the deactivation option is chosen.</p>');
			printer::alert('<input type="checkbox"  name="'.$data.'_blog_data1[8]" value="1" >Check Here to Deactivate All Active Urls in the email you receive as a Safety Precaution',false,'left editfont');
			}
		else {
			printer::alertx('<p class="editfont fsminfo editbackground editfont '.$this->column_lev_color.'" >Check Below to Prevent Deactivation of All Website Links &#40;URLs&#41; in The Email Message You receive. Mistakenly hit urls can potentially take you to a Malware Site. If NOT Chosen You can still copy the Url and manually paste into the address bar. 
			<br><input type="checkbox"  name="'.$data.'_blog_data1[8]" value="none" ><span class="neg">DO NOT DEACTIVATE </span>All Active Urls</p>',false,'left editfont');
			}
		printer::pclear();
		printer::alertx('<p class="left pt10 editbackground editfont editcolor"><span class="information" title="If your receiveing spam, Enter a list of comma separated keywords or Terms You would like to Designate as Spam. Emails will still be sent but SPAM will be added to the subject line">Add/Edit Spam Keywords and Terms</span></p>');
		$this->textarea('blog_data3',$data.'_blog_data3',$this->current_net_width,$this->current_font_px);
		printer::pclear();
		echo'</div><!--Contact Form Wrap-->';
		$this->show_close('show more config');
     printer::print_tip('All input/textarea styles may not work in all browsers ie. background image opacity');
		 printer::print_tip('Recommended browser compatible viewport responsive textarea and input lengths: <br>For input boxes use width set in px units with scaling feature turned on. <br> For textarea percentage works well.');
		$msg='<b>Input Boxes</b> Styling &amp; Width/Float Config';
     $this->edit_styles_close($data,'blog_data7','html .'.$this->dataCss .' input.wide','width_special,width_max_special,width_min_special,float,background,padding_top,padding_bottom,padding_left,padding_right,margin_top,margin_bottom,margin_left,margin_right,font_family,font_size,font_weight,text_align,font_color,text_shadow,line_height,letter_spacing,italics_font,small_caps,text_underline,borders,box_shadow,outlines,radius_corner,transform',$msg);
     $msg='<b>TextArea</b> Styling &amp; Width/Float Config';
     $this->edit_styles_close($data,'blog_data8','html #message'.$data,'width_special,width_max_special,width_min_special,float,background,padding_top,padding_bottom,padding_left,padding_right,margin_top,margin_bottom,margin_left,margin_right,font_family,font_size,font_weight,text_align,font_color,text_shadow,line_height,letter_spacing,italics_font,small_caps,text_underline,borders,box_shadow,outlines,radius_corner,transform',$msg);
     $msg='<b>Top Text Prompts</b> Style &amp; Width/Float Config';
     $this->edit_styles_close($data,'blog_data10','html .'.$this->dataCss .' .narrow','width_special,width_max_special,width_min_special,float,background,padding_top,padding_bottom,padding_left,padding_right,margin_top,margin_bottom,margin_left,margin_right,font_family,font_size,font_weight,text_align,font_color,text_shadow,line_height,letter_spacing,italics_font,small_caps,text_underline,borders,box_shadow,outlines,radius_corner,transform',$msg);
     $msg='<b>Bottom Message Prompt</b> Style &amp; Width/Float Config';
     $this->edit_styles_close($data,'blog_data11','html .'.$this->dataCss .' .form_message','width_special,width_max_special,width_min_special,float,background,padding_top,padding_bottom,padding_left,padding_right,margin_top,margin_bottom,margin_left,margin_right,font_family,font_size,font_weight,text_align,font_color,text_shadow,line_height,letter_spacing,italics_font,small_caps,text_underline,borders,box_shadow,outlines,radius_corner,transform',$msg);
     printer::print_tip('Style the general top portion of the contact form containing prompts &amp; imput fields but not the input boxes directly');
     $msg='<b>Form Top</b> Style &amp; Width/Float Config';
     $this->edit_styles_close($data,'blog_data9','html .'.$this->dataCss .' .contacttoptable','width_special,width_max_special,width_min_special,float,background,padding_top,padding_bottom,padding_left,padding_right,margin_top,margin_bottom,margin_left,margin_right,text_align,borders,box_shadow,outlines,radius_corner,transform',$msg);
     printer::print_tip('Style the general bottom portion of the contact form containing textarea prompt and textarea.');
     $msg='<b>Form Bottom</b> Style &amp; Width/Float Config';
     $this->edit_styles_close($data,'blog_data12','html .'.$this->dataCss .' .contactbottomtable','width_special,width_max_special,width_min_special,float,background,padding_top,padding_bottom,padding_left,padding_right,margin_top,margin_bottom,margin_left,margin_right,text_align,borders,box_shadow,outlines,radius_corner,transform',$msg);
		}
	echo '</div><!--configure contact-->';
	printer::pclear(10);
	 $this->edit_styles_close($data,'blog_style','.'.$this->dataCss,'',$mod_msg);
   ($this->edit&&$this->overlapbutton)&&$this->overlapbutton();
   }// end render_form
 
static function email_scrubber(&$value,$key,$deactivate) {
   if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
  // List of very bad values:
	$very_bad = array('to:', 'cc:', 'bcc:', 'content-type:', 'mime-version:', 'multipart-mixed:', 'content-transfer-encoding:');
	// If any of the very bad strings are in 
	// the submitted value, return an empty string:
	foreach ($very_bad as $v) {
		if (strpos($value, $v) !== false){ 
		$value= '';
		return;
		}
	}//if found will terminate script returning '' to calling script
	// Replace any newline characters with spaces:
	$value = str_replace(array('"', "\\r", "\\n", "%0a", "%0d"), ' ', $value);
	(!empty($deactivate))&&$value= str_replace('http' , '(Deativated link: if trusted put http here)' ,$value);
	$value=htmlentities(strip_tags($value));
   // Return the value: gets here only if verybad things not found!!
	 } // End of email_scrubber() function.


function contact_mail_process($data,$contact_arr){ 
	$deactivate=(empty($contact_arr[8])||$contact_arr[8]==='none')?0:1;
	
	$iplookup=mail::iplookup();
	if (isset($_POST['email']['message'.$data])){ 
		$this->post_message=htmlentities($_POST['email']['message'.$data]);
		}  
	if (isset($_POST['email']['name_'.$data])){ 
	  $this->post_name=htmlentities($_POST['email']['name_'.$data]); 
		} 
	if (isset($_POST['email_'.$data])){
		$this->post_email=htmlentities($_POST['email']['email_'.$data]); 
		}
	
	$this->scrubbed=$_POST['email'];
	array_walk($this->scrubbed,array('self','email_scrubber'),$deactivate); //scrubbed is array sent hrou scrubber                                   
	//echo $this->scrubbed['message'.$data].' is scrubbed message';
	if (!preg_match(Cfg::Preg_email,$this->scrubbed['email_'.$data])){
		$this->scrubbed['email_'.$data]='';
		}
	  // Minimal form validation:
	if (!empty($this->scrubbed['name_'.$data]) && !empty($this->scrubbed['subject_'.$data]) && !empty($this->scrubbed['message'.$data]) && !empty($this->scrubbed['email_'.$data]) ) {
		  // Create the body:
		$this->clean_email=$clean_email=$this->scrubbed['email_'.$data];
		$this->clean_name=$clean_name=$this->scrubbed['name_'.$data];
		$this->clean_subject=$this->subject=$clean_subject=$this->scrubbed['subject_'.$data];
		$this->clean_message=$clean_message=$this->scrubbed['message'.$data];
		$body = "Do Not Reply Directly with this email".NL."Reply to: $clean_email".NL." Subject: $clean_subject".NL." From: $clean_email".NL.$iplookup.NL."$clean_name has sent you a message!: ".NL.NL .$clean_message.NL;
		$this->body =NL. wordwrap($body, Cfg::Wordwrap);
	  // Send the email:
        $sendvar='sent to for each: ';
			if(empty($this->blog_data2)){
				$msg='CONFIGURE YOUR CONTACT INFO ON EDITPAGE ADD EMAIL ADDRESSES';
				mail::alert($msg);
				exit($msg);
				} 
			$newtomail=explode(',',$this->blog_data2);
			$admin_mail=explode(',',Cfg::Admin_email);
			(!empty($contact_arr[6])&&$contact_arr[6]==='admin_add')&&$newtomail=array_merge($newtomail,$admin_mail);// 
			$mailstring=implode(',',$newtomail);//for email reference
			if (!empty($this->blog_data3)){
				$checkarray=explode(',',$this->blog_data3);
				$check_list='';
				foreach($checkarray as $check){
					if (empty($check))continue; 
					$check=trim(strtolower($check));
					if (strpos(strtolower($body),$check)) {
						$check_list.=$check.',';
						}
					if (strpos($this->scrubbed['subject_'.$data],$check)!==false) {
						$check_list.=$check.',';
						}   
				  }
				if (strlen($check_list)){ 
				  $check_list=substr_replace($check_list ,"",-1);
				  $this->body.=NL.'Emails Spammmed due to keywords: '.$check_list;
				  $this->subject='SPAM Alert: '.$this->subject;
				  }
				}#end seo check 
			if (Sys::Web){
				$usr=new users();
				$this->body = NL. ' Browser info is '
				.$usr->get('OS').NL.
				$usr->get('ip'). " is address".NL.
				' emailed to owner/admin: '.Cfg::Owner.' using: '.$mailstring .NL
				. $this->body; 
				if(!isset($_POST['contact_status_check'])||(isset($_POST['contact_status_check'])&&$_POST['contact_status_check']!=='yhuman')){
					printer::alertx('<p style="background:red;color:white">Seriously, Choose Your Status!</p>');
					
					$this->sent=false;
					}
				elseif (isset($_POST['contact_message_check'])&&$_POST['contact_message_check']!='Enter message Here'){
					$this->sent=true; //giveem sent message without sending 
					}
				else { 
					foreach ($newtomail as $var){ 
						$this->contact_mail_send($var);
						}
					}
				if ($this->sent){
					//$name=str_replace(' ','%20',$_POST['name_'.$data]);
					$name=htmlentities($this->post_name);//don't use full scrubbed name as giveaway
					printer::alertx('<p style="background:#'.Cfg::Pos_color.';color:white;">Thankyou '.$name. ' your message has been sent</p>'); 
					}
				}//end if sys::web  
			else {// local 
          $this->body = NL.
          'local test email:'.NL.			
          'email subject: '.$this->subject.NL.
          ' emailed to owner/admin: '.Cfg::Owner.' using: '.$mailstring.NL
          . $this->body;
          echo $this->body;
          $name=htmlentities($this->post_name);//don't use full scrubbed name as giveaway
          if(!isset($_POST['contact_status_check'])||( isset($_POST['contact_status_check'])&&$_POST['contact_status_check']!=='yhuman')){
              printer::alert_neg('Choose Your Status!!');
              }
          else printer::alert_pos('Thankyou '.$name. ' your message has been sent');
          }
			}//close if !empty scrubbed
		else {
        echo $this->alert[]='Please fill out the form completely.</p>';
        if (empty($this->scrubbed['name_'.$data])){
          $this->noname='*Name Required';
          }
        if (empty($this->scrubbed['message'.$data])){
          $this->nomessage='*Message is Required';
          }
        if (empty($this->scrubbed['email_'.$data])){
          $this->noemail='*Valid email is Required';
        }
		}//end else scrubbed is not empty	  
  }//end function contact_mail 
 
function contact_mail_send($email){ mail($email, 'hello', 'body');
	$headers = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	//$headers.="From: ".Cfg::Mail_from . "\r\n";
	//$headers.='Reply-To: webmaster@example.com' . "\r\n"; #may affect span 
		//$headers.= "Reply-To: $this->scrubbed['email'] \r\n"; note did work with reply to...
		//options to send to cc+bcc 
		//$headers .= "Cc: [email]maa@p-i-s.cXom[/email]"; 
		//$headers .= "Bcc: [email]email@maaking.cXom[/email]"; 
	// now lets send the email. 
	$message = <<<EOF
	<html> 
	<body style="background: #d0d195"> 
	<table width="700" align="center" style="padding-top: 30px; padding-bottom:30px; background-color: #e7e9c0">
	<tr><td>
	<table width="90%" align="center" style="background-color: #fff">
	<tr><td>
	<table width="90%" align="center" style="background-color: #fff; padding-bottom: 30px;">
	<tr><td>
	$this->body
	 </td></tr></table>
	</td></tr></table>
	</td></tr></table>
	</body> 
	</html> 
EOF;
$message2 = <<<EOF
	<div style="background: #d0d195"> 
	<table width="700" align="center" style="padding-top: 30px; padding-bottom:30px; background-color: #e7e9c0">
	<tr><td>
	<table width="90%" align="center" style="background-color: #fff">
	<tr><td>
	<table width="90%" align="center" style="background-color: #fff; padding-bottom: 30px;">
	<tr><td>
	$this->body
	 </td></tr></table>
	</td></tr></table>
	</td></tr></table>
	</div> 
EOF;
	if (Sys::Loc){
		printer::alertx($message2);
		return;
		}
	if (mail($email, $this->subject, $message, $headers)) {
		$this->sent=true;}
	else mail::alert('Problem with mail_send in contact.php'." email is $email and message is ".NL."$message ".NL."and headers are ".NL."$headers and subject is ".$this->subject);	
	}#end contact_mail_send

#video	
function video_post($data){ 
   $blog_data4=trim($this->blog_data4);
	$full_replace=false;
	$this->edit_styles_open();
	($this->edit)&&  
		$this->blog_options($data,$this->blog_table);
   /*if(strpos($blog_data4,'http')!==false&&strpos($blog_data4,'http')<=1){//not used...
     $embed= '<iframe src="'.$blog_data4.'" width="100%" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
     if ($this->edit||!$this->clone_local_data)$this->videotype='URL';
     else
        echo $embed;     
     }*/
   if (strpos($this->blog_data4,'<iframe')!==false||strpos($this->blog_data4,'<object')!==false){
     $embed=$blog_data4;
     $this->videotype='iframe';
     if (!$this->edit)
        echo '<div class="videoWrapper">'.$embed.'</div>'; 
     }
   elseif(is_file(Cfg_loc::Root_dir.Cfg::Vid_dir.$blog_data4)){
     $picfield='blog_tiny_data1';
     $this->videotype='video_upload';
     $image=(is_file(Cfg_loc::Root_dir.Cfg::Vid_image_dir.$this->$picfield))?Cfg_loc::Root_dir.Cfg::Vid_image_dir.$this->$picfield:''; #pic in  vid in Cfg::Vid_fir
     $video=video_master::instance();
      echo '<div class="video_resize">';
      $video->render_video($blog_data4,$image,800,1.2,Cfg_loc::Root_dir.Cfg::Vid_dir,$this->blog_data5);//blog info currently used for flv autoplay
      echo '</div>';
       
     }
   
   else {
     $this->videotype='none';
     if (!$this->edit||!$this->clone_local_data) 
        printer::alert_neu('Video Coming Soon',1.3);
     }
	if (!$this->edit)return;
	$preg_match=''; 
	if (!$this->is_clone||$this->clone_local_data){
		echo '<div class="fsminfo editbackground editfont '.$this->column_lev_color.' floatleft"><!--Choose video Display--><p class="floatleft">Choose Video iframe/object embed (ie from youtube.com or Vimeo.com) or direct video upload. Other types of iframes may also be displayed by using the first method. Video should autoadjust to the full post width using either method </p> ';
		printer::pclear();
     printer::print_notice('Current Video Type is '.$this->videotype);
		echo '<div class="fsminfo editbackground editfont floatleft left '.$this->column_lev_color.'"><!--Iframe Embed Code-->Place <b>Video/Other Embed code Here,</b> ie from Vimeo or Youtube or other type of iframe or object code. This method has widest support for all video types on all devices, ie. preferred method<br>Enter Video Iframe, Object (Embed code)<br><br><b> Or Previously Uploaded video</b> filename here (without dir path)..';
		$this->textarea('blog_data4',$data.'_blog_data4');
		printer::pclear();
		echo '</div><!--Iframe Embed Code-->'; 
		printer::pclear(10);
		$vidfield='blog_data4';
     $prefix=($this->clone_local_data)?'p':'';
     $masterpost=($this->clone_local_data)?$this->master_post_data_table:$this->master_post_table;
		echo '<div class="fsminfo editbackground editfont floatleft left '.$this->column_lev_color.'"><!--Upload File-->Or Upload New Video File. Takes mp4, ogg, webm, m4v';
		echo'<p class="editcolor editbackground editfont underline"> <a href="add_page_vid.php?masterpost='.$masterpost.'&amp;www='.$this->current_net_width.'&amp;ttt='.$this->blog_table.'&amp;fff='.$vidfield.'&amp;id='.$prefix.$this->blog_id.'&amp;id_ref=blog_id&amp;pgtbn='.$this->pagename.'&amp;postreturn='.Sys::Self.'&amp;css='.Cfg_loc::Root_dir.Cfg::Style_dir.$this->pagename.'&amp;sess_override&amp;sess_token='.$this->sess->sess_token.'">Upload a Video File</a></p>';
		echo '</div><!--Upload File-->';
			printer::pclear(); 
		echo '</div><!--Choose video Display-->'; 
     
     //$video=video_master::instance(); 
     printer::pclear(); 
     echo '<div class="editbackground editfont fs1color floatleft"><!--border video edit-->';
     $this->edit_vid($data);
     printer::pclear();
     echo '</div><!--border video edit-->';
		printer::pclear(); 
		}//if ! clone || clone local
	$style_list='background,padding_top,padding_bottom,padding_left,padding_right,margin_top,margin_bottom,margin_left,margin_right,text_align,borders,box_shadow,outlines,radius_corner'; #do not display edit styling for padding top and bottom
	$global_field=($this->blog_global_style==='global')?',.'.$this->col_dataCss.' > .'.$this->blog_type:'';
	$globalmsg=($this->blog_global_style==='global')?' Global Style':'';
	$this->edit_styles_close($data,'blog_style','.'.$this->dataCss.'.post.'.$this->blog_type.$global_field, $style_list ,'Style Video'.$globalmsg,'','',true);
	}#end video

function edit_vid($data){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	if (!$this->is_clone||$this->clone_local_style){
     printer::print_notice('Additional options for Uploaded videos ie. not embedded iframes');
     $blog_data5=(!empty($this->blog_data5))?false:true;//for autoplay
     $picfield='blog_tiny_data1'; 
     $blog_show_change=(!empty($this->blog_data5))?"false":"true";
     $blog_show_info=(!empty($this->blog_data5))?"true":"false";
     printer::print_wrap('autoplay');
     printer::alert('Setting Autoplay to True will Cause the Video to Automaticaly Play Immediately!');
     printer::pclear(2);
     printer::printx('<p class="editfont '.$this->column_lev_color.'">Autoplay Curently: '.$blog_show_info.'</p>');
     printer::pclear(2);
     printer::printx('<p class="editfont editcolor editclass editbackground editfont"><input  type="checkbox" name="'.$data.'_blog_data5" value="'.$blog_data5.'" >&nbsp;Set Autoplay to '.$blog_show_change.'</p>');
     printer::close_print_wrap('autoplay');
     }
   $picfield='blog_tiny_data1';  
$datapic=$data.'_'.$picfield;
	$field=(empty($field))?$data:$field;#this accomodates the blog which is not the $data as with normal pages 
   $vidname=($this->videotype==='vid_upload')?trim($this->blog_data4):false;
	printer::pclear(); 
	echo'<div class="editbackground editfont floatleft"><!--Video Loader-->';
  printer::alertx('<p class="editcolor editbackground editfont">Change starter Still Image to Previously Uploaded image:<input style="cursor:pointer;background:#'.$this->editor_background.';color:#'.$this->editor_color.';" name="'.$datapic.'" value="'.$this->blog_tiny_data1.'" size="40"></p>');
   printer::pclear(10);
   $prefix=($this->clone_local_data)?'p':'';
	printer::alertx('<p class="left editbackground editfont editcolor" title="Click here to Upload a New Display Image for the video player as it will display before video is Started otherwise could be blank screen" ><a href="add_page_pic.php?vidname='.$vidname.'&amp;addvid=1&amp;wwwexpand=0&amp;www='.$this->current_net_width.'&amp;ttt='.$this->blog_table.'&amp;fff='.$picfield.'&amp;id='.$prefix.$this->blog_id.'&amp;id_ref=blog_id&amp;&amp;clone_local_data='.$this->clone_local_data.'&amp;pgtbn='.$this->pagename.'&amp;postreturn='.Sys::Self.'&amp;css='.$this->roots.Cfg::Style_dir.$this->pagename.'&amp;sess_override&amp;sess_token='.$this->sess->sess_token.'" class="highlightclick underline">OR upload a Starter Image for YOUR VIDEO PLAYER</a></p>');
   //$this->show_close('Add Video Still Image');
   printer::pclear(10);
   echo '</div><!--Video Loader-->';
   printer::pclear(10);
		 
	}
	
   
#background vide 
function background_video($element){//not in use as mobile compatibility is poor
	static $num=0; $num++;
	$ele_arr=explode(',',$this->$element); 
	$styleindexes=explode(',',Cfg::Style_functions);
	foreach($styleindexes as $key =>$index){
		if (!empty($index)) ${$index.'_index'}=$key;
		}
	$count=count($styleindexes);
	for ($i=0; $i<$count; $i++){
		(!array_key_exists($i,$ele_arr))&&$ele_arr[$i]=0;
		}
	$backindexes=explode(',',Cfg::Background_styles);
	foreach($backindexes as $key =>$index){
		if (!empty($index)) ${$index.'_index'}=$key;
		}
	if (array_key_exists($background_index,$ele_arr)&&strlen($ele_arr[$background_index])>30){ 
		$background_array=explode('@@',$ele_arr[$background_index]); 
		$count=count($backindexes);
		for ($i=0; $i<$count; $i++){
			(!array_key_exists($i,$background_array))&&$background_array[$i]=0;
			}
		if (array_key_exists($background_video_index,$background_array)&&strlen($background_array[$background_video_index])>5&&$background_array[$background_video_display_index]!=='no_display'){//display background image
			$vidname=$background_array[$background_video_index];
			$ext_arr=explode(',',Cfg::Valid_vid_ext);
			$path_parts=pathinfo($vidname);
			$ext=(array_key_exists('extension',$path_parts))?$path_parts['extension']:'';
			if (!in_array($ext,$ext_arr)){
				($this->edit)&&printer::alert_neg('Invalid background video: '.$vidname);
				return;
				}
			//$video=process_data::un_scrub($background_array[$background_video_index]);
			#we are not replacing now .. instead will override with css in absolute pos element
			$ratio=(array_key_exists($background_video_ratio_index,$background_array)&&!empty($background_array[$background_video_ratio_index])&&is_numeric($background_array[$background_video_ratio_index])&&$background_array[$background_video_ratio_index]>.1&&$background_array[$background_video_ratio_index]<10)?$background_array[$background_video_ratio_index]:1.333; 
			if ($this->edit&&$ratio===1.333){
				$msg='Default Video Aspect Ratio (1.333) may be changed in the background style options to balance your width/height ratio';
				printer::alert_neu($msg,.5);
				}
			//$vidname='ean02idlEm4'; 	//testing youtube api 
			$width=$this->current_net_width; //auto with background
			$height=$width/$ratio;
			$autoplay=1;
			$mute=1;
			$loop=1;
			$viddir=Cfg_loc::Root_dir.Cfg::Vid_background_dir; 
			$controls=0;
			$cc=0;  
			$image=''; 
			$id='';//'id="back_vid_'.$num."';
			$video=video_master::instance();
			echo '<div '.$id.' class="video-back-container" data-rwd="'.$this->rwd_post.'" data-type="'.$element.'" data-vid-ratio ="'.$ratio.'"><div>';
			$video->render_video($vidname,$image,$width,$ratio,$viddir,$autoplay,$loop,$mute,$cc,$controls);//blog info currently used for flv autoplay 
			################# 
			echo '</div></div>';
			} 
		}
	}//end background video
   
#nav #navmenu 
function nav_menu($data,$dir_menu_id,$text) {//blog_data6 available
   (Sys::Deltatime)&&$this->deltatime->delta_log(__LINE__.' @ '.__method__.' ');
	$datainc='_'.$this->blog_id;
	$this->navobj->current_color=$this->column_lev_color;
	static $inc=0;  $inc++;
	if (empty($dir_menu_id)){ 
		if ($this->edit){
			$dir_menu_id=$this->process_add_new_page();
			$this->edit_styles_open();
			$this->delete_option();
			$q="select distinct dir_menu_id from $this->directory_table";
			$r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
			if ($this->mysqlinst->affected_rows()){
				$opts=array();
				printer::pclear();
				$this->show_more('Create Menu', ' ','','',800);
				printer::print_wrap('create menu');
				printer::printx('<p class="fsminfo editbackground editfont rad5 maxwidth800 floatleft left maroonshadow infoback info "> Create and Use as Many Menus as you want on a Page whether independent or Common To Other Pages. The Table below assists in finding the best approach to your navigation menu needs:</p>');	
				printer::pclear();							
				$opts[]=array('Your Menu Needs'=>'<span class="pos">Sharing a Common Menu, It&#39;s Styling &amp; All Updates between Pages</span>',
					'Best Approach'=>'<span class="orange">Clone the Menu Post</span>',
					'How To proceed'=>'<span class="info">Delete this Post. Choose the Copy/Move/Clone Column From the Create Post/Column dropdown Option. Choose mirror and enter the Column Id of the the parent Post containing the Menu. Editing the Parent Menu will also change this menu</span>');
				$opts[]=array('Your Menu Needs'=>'<span class="pos">Same as Above but within a Common Column &#40;ie. Page Headers&#41;</span>',
					'Best Approach'=>'<span class="orange">Clone the Column Containing the Menu</span>',
					'How To proceed'=>'<span class="info">Delete this Post. Choose the Copy/Move/Clone Post From the Create Post/Column dropdown Option. Choose mirror and enter the Column Id of the the parent Column containing the Menu. All Editing Changes to the Parent Menu and any other post within the parent Column will also appear on this page</span>');
				$opts[]=array('Your Menu Needs'=>'<span class="pos">Copying a Menu But Customizing the Menu links </span>',
					'Best Approach'=>'<span class="orange">Copy the Menu Post</span>',
					'How To proceed'=>'<span class="info">Delete this Post. Choose the Copy/Move/Clone Post From the Create Post/Column dropdown Option. Choose copy and enter the Post Id of the the parent Menu. This will make a completely independent Copy of the Menu including Links that can be altered any way without affecting the original.</span>');
				$opts[]=array('Your Menu Needs'=>'<span class="pos">Moving a menu Here</span>',
					'Best Approach'=>'<span class="orange">Move the Menu Post</span>',
					'How To proceed'=>'<span class="info">Delete this Post. Choose the Copy/Move/Clone Post From the Create Post/Column dropdown Option. Choose move and enter the Post Id of the the parent Menu.</span>');
				$opts[]=array('Your Menu Needs'=>'<span class="pos">Sharing a Common Menu &amp; Menu Link Updates But With Independent Positioning &amp; Styling </span>',
					'Best Approach'=>'<span class="orange">Got to the &#34;Choose a the Menu Already Created&#34; Option Below</span>',
					'How To proceed'=>'<span class="info">Proceed to the Choose a Menu Already Created Option Below. Choose Your Menu. Style as needed. Changes to menu links from here or on any other column using the menu id will appear in all of them but styling changes are independent unless mirror options are chosen!</span>');
				$opts[]=array('Your Menu Needs'=>'<span class="pos">Starting a Brand New Menu</span>',
					'Best Approach'=>'<span class="orange">Go to the &#34;Start a New Menu from Scratch by Selecting a Previously Created Page&#34; Option Below</span>',
					'How To proceed'=>'<span class="info">Open the Option. Select a Page. If needed, create a new page at the &#34;Add a new page to the website&#34; link at the top of this page. </span>'); 
				printer::horiz_print($opts);
				$this->show_more('More Scenarios', ' ','','',800);
				printer::print_wrap('more menu');
				$opts=array();
				$opts[]=array('Your Menu Needs'=>'<span class="pos">Changing the Styling/Positioning of a Menu Within a Mirored Column</span>',
					'Best Approach'=>'<span class="orange">Enable the Local Mirror Style</span>',
					'How To proceed'=>'<span class="info">Simply Go to the Mirrored menu within the cloned column and Enable the Local Mirror Style! Changes to the positioning/styling of the mirrored menu will not affect the parent or other mirrors</span>');
				$opts[]=array('Your Menu Needs'=>'<span class="pos">Changing Menu links &#40;&amp; Styling&#41; of a Mirrored Menu Within a Mirrored&nbsp;Column</span>',
					'Best Approach'=>'<span class="orange">Choose the Mirror Release Option</span>',
					'How To proceed'=>'<span class="info">Go to the cloned menu within the cloned column and Choose the mirror release option. Then Check the &#34;Duplicate and Modify&#34; Option. This allows you to independently change and modify a copy of the original menu. Etc.</span>');
				printer::horiz_print($opts);
				printer::pclear();
				
				printer::close_print_wrap('more menu');
          $this->show_close('menu opts');
				printer::close_print_wrap('create menu');
				$this->show_close('create menu scenarious');
				printer::pclear();							
				printer::pclear();
				$this->show_more('Choose a Menu Already Created to Add Here', ' ','','',800); //menu created
				while (list($dir_menu_id)=$this->mysqlinst->fetch_row($r)){
					echo '<div class="fsminfo editcolor floatleft pb10 editbackground editfont"><!--choose menu-->';
					printer::alert('<input type="radio" value="'.$dir_menu_id.'" name="'.$data.'_blog_data1_arrayed">Choose Menu Id: '.$dir_menu_id);
					
					$this->navobj->render_menu($dir_menu_id,'utility_horiz',false);
					echo '</div><!--end choose menu-->';
					printer::pclear(2);
					}//end while
				$this->show_close('menu created');//menu created
				$Or='Or';
				}//if affected
			else $Or='No Menus Created Yet';
			printer::pclear();
			$this->show_more($Or.' Start a New Menu from Scratch by Selecting a Previously Created Page', ' ','','',500); //menu create
			$msg='New Pages Are Created On the Add a New Page to the Website Link at the top of Edit Pages.';
			printer::printx('<p class="fsminfo editbackground editfont floatleft left '.$this->column_lev_color.'">'.$msg.'</p>');
			$q="select distinct page_ref, page_title from $this->master_page_table order by page_ref ASC"; 
			$r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
			if (!$this->mysqlinst->affected_rows()){
				printer::alert_neg('Create the Pages First Before Adding then to Your menu '.$msg );
				$this->show_close('Start a New Menu');
				}
			else {
				while (list($page_ref,$page_title) = $this->mysqlinst->fetch_row($r,__LINE__)){
					if ($page_ref==='setupmaster')continue; 
					$page_arr[]=$page_ref;
					$print_arr[]=array('Page Table Reference'=>$page_ref,'Current Page Title'=>$page_title);
					}
				if(count($page_arr)>0){
             printer::pclear(5);
					printer::print_tip('This Table Lists the Created Pages and a Default Title Which is alterable Later as necessary. Note: Titles may Be Changed Without Affecting Different Titles to the same Page in a Different Menu');
					printer::horiz_print($print_arr,'','','','',false);
					echo '<div class="fsminfo editbackground editfont floatleft left '.$this->column_lev_color.'">Choose your Page Reference to begin your new menu<br>'; 
					echo'<p> <select class="editcolor editbackground editfont" name="menu_start_new['.$this->blog_id.']">';    
					echo '<option value="" selected="selected">none</option>';
					for ($i=0;$i<count($page_arr);$i++){
					  echo '<option value="'.$page_arr[$i].'">'.$page_arr[$i].'</option>';
					  }
					echo'	
					</select></p>';
					echo '</div><!--Page Arr Select-->';
					}
				$this->show_close('more nav menu');
				}//else afected 
			$this->show_more('Other Options', 'Close Other Options','highlight fsminfo editbackground editfont','Link to External Site, Link to Internal PDF or HTML Page, Upload Internal Page');
			printer::print_wrap('other');
			$this->show_more('Add Navigation Menu Link to an External Website', 'noback','information editbackground editfont fsminfo editbackground editfont','This Link Will Take Your Website Viewer Off Your Own Site');
			printer::print_wrap('add link external');
			printer::alert('Create a Formal Menu Link To a Separate ExternalSite');
			printer::alert('Enter the url address of the External Link. http:// will be appended automatically if you do not include it ie www.mysite.com<input  style="background:#'.$this->editor_background.';color:#'.$this->editor_color.';" type="text" name="create_external_link_url" value="" size="60" maxlength="100">');
			printer::alert('Enter the title of the External Link. <textarea class="utility" name="create_external_link_name['.$this->blog_id.']" style="width:90%;" rows="3" cols="50" ></textarea>');
			printer::close_print_wrap('add link external');
			$this->show_close('External Link');echo ' <!--close show_more External Link-->'; 
			printer::pclear(2); 
			$this->show_more('Add a Navigation Link to an Uploaded PDF file');
			printer::print_wrap('internal');
			printer::alert('Go To Upload a PDF file <a href="#uploadpdf" onclick="return gen_Proc.scroll_to_view(\'uploadpdf\');" >Here</a>');
			printer::alert('Enter the filename of the Uploaded PDF file: ie myfile.pdf<input style="background:#'.$this->editor_background.';color:#'.$this->editor_color.';" type="text" name="create_internal_link_filename['.$this->blog_id.']" value="" size="60" maxlength="60">');
			printer::alert('Enter the title for Your PDF link. <textarea class="utility" name="create_internal_link_title['.$this->blog_id.']" style="max-width:90%;" rows="3" cols="50" ></textarea>');
			printer::close_print_wrap('internal');
			$this->show_close('internal PDF Link');echo ' <!--close show_more internal PDF Link-->'; 
			printer::close_print_wrap('other');
			$this->show_close(' Other');echo ' <!--close show_more Other-->'; 
			}//if edit
		return;
		}//EMPTY menu id
	$count=$this->mysqlinst->count_field($this->directory_table,'dir_menu_id','',false,"where dir_menu_id='$dir_menu_id' AND dir_sub_menu_order=0 "); 
	($this->edit)&&$this->edit_styles_open();
	($this->edit)&&  
	$this->blog_options($data,$this->blog_table);
	#navparams
	#navopts #menuopts #menuparamas
   $nav_name_ref='blog_data5'; 
	$nav_params=explode(',',$this->$nav_name_ref);
	$nav_opts='nav_drop_shift,nav_link_width,nav_sub_link_width,nav_link_height,nav_icon_media_width,nav_icon_color,nav_icon_width,nav_icon_position,,nav_icon_vertical_response,nav_link_width_management,nav_repeat_submenu,nav_force_caps,nav_animate,nav_open_icon_left,nav_open_icon_right,nav_open_icon_top,nav_open_icon_bottom,nav_icon_horiz_pos,nav_open_icon_total_menu_width,nav_open_icon_only_right,nav_open_icon_only_left,nav_open_icon_only_top,nav_icon_total_menu_width,nav_menu_vertical_response,nav_sub_display,nav_openicon_sub_display,nav_sub_link_height';//nav_link_maxwidth,nav_sub_link_maxwidth';
	$nav_opts=explode(',',$nav_opts);
		
	for ($x=0;$x<=count($nav_opts);$x++){ 
	  (!array_key_exists($x,$nav_params))&&$nav_params[$x]=0;# 
	  }
  foreach($nav_opts as $key =>$index){
		if (!empty($index)) {
			${$index.'_index'}=$key; 
			}
		}
   $this->{$this->data.'_'.$nav_name_ref}=$nav_params; 
	$min_viewport=100;
   $max_viewport=(!empty($this->column_total_width[0])&&$this->column_total_width[0]>350)?$this->column_total_width[0]:((!empty($this->page_width)&&$this->page_width>350)?$this->page_width:1280);
   $nav_icon_color= (preg_match(Cfg::Preg_color,$nav_params[$nav_icon_color_index]))?$nav_params[$nav_icon_color_index]:'595555';
   $nav_link_vertical_choice=$nav_params[$nav_menu_vertical_response_index];
   $respond_menu_dimension=($nav_params[$nav_icon_media_width_index]==='icon full on')?'icon full on':(($nav_params[$nav_icon_media_width_index]>$min_viewport&&$nav_params[$nav_icon_media_width_index]<=$max_viewport)?$nav_params[$nav_icon_media_width_index]:0);
   $nav_animate=($nav_params[$nav_animate_index]==='fadeInRight'||$nav_params[$nav_animate_index]==='fadeInLeft')?$nav_params[$nav_animate_index]:'';
   $nav_icon_horiz_pos=($nav_params[$nav_icon_horiz_pos_index]==="left" ||$nav_params[$nav_icon_horiz_pos_index]==="right")?$nav_params[$nav_icon_horiz_pos_index]:'none';
	if ($count>0){
		($this->edit)&&printer::printx('<p class="editbackground editfont fsminfo editbackground editfont floatleft left '.$this->column_lev_color.'">Menu Id: '.$dir_menu_id.'</p>');
		printer::pclear();
          echo <<<eol
	
   <script>
   \$( function(){
     \$( '.$this->dataCss .nav_gen li:has(ul)' ).doubleTapToGo();//selects li elements with submenus
    
      \$('.$this->dataCss .nav_gen li.show_icon .aShow').click(function(){
          gen_Proc.toggleClass('#$this->dataCss .ulTop','menuRespond','menuRespond2','transitionEase',500);gen_Proc.toggleHasClass('#$this->dataCss .ulTop','#$this->dataCss','menuRespond','iconOpen');
          });
      });
   </script>
eol;
		#navobj choices
		$this->navobj->nav_animate=$nav_animate;
		$this->navobj->respond_menu_dimension=$respond_menu_dimension;
		$this->navobj->force_caps=($nav_params[$nav_force_caps_index]==='force')?true:false; 
		$this->navobj->nav_post_class=$this->dataCss; 
		$this->navobj->nav_repeat_submenu=($nav_params[$nav_repeat_submenu_index]!=='repeat')?false:true;
		$this->navobj->render_menu($dir_menu_id,'ID-'.$dir_menu_id.'-'.$datainc);
      
     }
	elseif(empty($count)&&$this->edit){
		printer::printx('<p class="fsminfo editbackground editfont '.$this->column_lev_color.' floatleft left">Add Your First Already Created Page To This Menu Under the Add,Edit &amp; Remove Links Option Below</p>');
		}
	if(!$this->edit)return;
	printer::pclear();
	 #navstyle
	printer::pclear(15);
	$nav_width_manage=($this->column_use_grid_array[$this->column_level]==='use_grid'&&$nav_params[$nav_link_width_management_index]!=='nomanage')?true:false;
	#navvals
	$icon_width_arr=explode('@@',$nav_params[$nav_icon_width_index]);
   $icon_width=$icon_width_arr[0];
	$icon_width=($icon_width>=.3&&$icon_width<=10)?$icon_width:0;
   if (empty($icon_width)){
     $icon_width=2;
     $icon_width_arr[0]=2;
     $nav_params[$nav_icon_width_index]=implode('@@',$icon_width_arr);
     }
     $icon_vertical_choice=$nav_params[$nav_icon_vertical_response_index];
	$icon_position_choice=(empty($nav_params[$nav_icon_position_index])||!is_numeric($nav_params[$nav_icon_position_index])||$nav_params[$nav_icon_position_index]>100)?0:$nav_params[$nav_icon_position_index];
   
	 $this->show_text_style=true; //temp turn on text-align display
	$this->edit_styles_close($data,'blog_style','.'.$this->dataCss,'background,padding_top,padding_bottom,padding_left,padding_right,margin_top,margin_bottom,margin_left,margin_right,text_align,borders,box_shadow,outlines,radius_corner,transform','Edit Overall Post Styling','','Edit Overall Post Styling generally for @ <h7>non menu icon</h7> widths. Use Detailed Link Styling for Link Text Styling',true,true ); 
	$this->show_text_style=false; //turn off text-align display
	 $this->{$nav_name_ref.'_arrayed'}=$this->{$data.'_'.$nav_name_ref.'_arrayed'} =$nav_params;
	$this->background_img_px=(is_numeric($nav_params[$nav_link_width_index])&&$nav_params[$nav_link_width_index]>30)?$nav_params[$nav_link_width_index]:200; 
#navwidth		 
	$nav_drop_shift=(is_numeric($nav_params[$nav_drop_shift_index])&&$nav_params[$nav_drop_shift_index]>0&&$nav_params[$nav_drop_shift_index]<201)?'LEFT:'.$nav_params[$nav_drop_shift_index].'px':'';
	$nav_link_height=(is_numeric($nav_params[$nav_link_height_index])&&$nav_params[$nav_link_height_index]>24&&$nav_params[$nav_link_height_index]<101)?'height:'.$nav_params[$nav_link_height_index].'px;':''; 
   $nav_sub_link_width=(is_numeric($nav_params[$nav_sub_link_width_index])&&$nav_params[$nav_sub_link_width_index]>44&&$nav_params[$nav_sub_link_width_index]<321)?'width:'.$nav_params[$nav_sub_link_width_index].'px;':'';
   if (Sys::Quietmode||(!$this->clone_local_style&&$this->is_clone))return;//#  PROCEEd FOr NORMAL  PROCEEd FOr NORMAL
		 ############### End Nav Options ###############
		$this->show_more('Detailed Link Styling &amp; Custom Menu Opts', '','','',500,'','float:left',true);
		$this->print_wrap('detail link');	
		printer::pspace(10);
     printer::print_tip('Style Menu Links, sub links, Sub Menu Hover Panel etc.');
   printer::pclear(); 
   $this->show_more('Style individual Links');
   printer::print_wrap('Style individual Links');
   printer::print_tip('Here you can style both the LI A and the parent LI element which affects individual links.');
   printer::print_info('Recomended to use LI A then for special needs use LI');
   $style_list='width_special,width_max_special,width_min_special,background,padding_top,padding_bottom,padding_left,padding_right,margin_top,margin_bottom,margin_left,margin_right,font_family,font_size,font_weight,text_align,font_color,text_shadow,line_height,letter_spacing,italics_font,small_caps,text_underline,borders,box_shadow,outlines,radius_corner,transform';
   $this->edit_styles_close($data,'blog_data4','.'.$this->dataCss.' .nav_gen ul li a',$style_list,'Style General Menu Link LI A','','Styles You Make Here will affect All Links. Default widths set to auto. This is best on horizontal menus to conserve space using minimuim widths. However for uniform button effect widths can be used. Use Nav General Post styling to set the collective nav link alignment center or left. For additional Hover and Active Link effects Style Options Below these<br>To Enlarge Background Area for Images and Background Color Use Padding Spacing<br>To Enlarge Spacing between Background styled links use margin spacing');
   $style_list='width_special,width_max_special,width_min_special,background,padding_top,padding_bottom,padding_left,padding_right,margin_top,margin_bottom,margin_left,margin_right,borders,box_shadow,outlines,radius_corner,transform';
   printer::pclear(5);
   $this->edit_styles_close($data,'blog_data3','.'.$this->dataCss.' .nav_gen ul li',$style_list,'Additionally Tweak the General Menu Link LI Element','','');
   printer::close_print_wrap('Style individual Links');
   $this->show_close('Style individual Links');
   printer::pclear(5);
   $this->show_more('Style individual Sub Links Differently');
   printer::print_wrap('Style individual Links');
   printer::print_tip('Here you can style both the Sub-Link LI A and the parent LI element which affects individual links.');
   printer::print_info('Recomended to use LI A then for special needs use LI');
   $style_list='width_special,width_max_special,width_min_special,background,padding_top,padding_bottom,padding_left,padding_right,margin_top,margin_bottom,margin_left,margin_right,font_family,font_size,font_weight,text_align,font_color,text_shadow,line_height,letter_spacing,italics_font,small_caps,text_underline,borders,box_shadow,outlines,radius_corner,transform';
   $this->edit_styles_close($data,'blog_data2','.'.$this->dataCss.' .nav_gen ul ul li a',$style_list,'Style General Menu Link LI A','','');
   printer::pclear(5);
   $this->edit_styles_close($data,'blog_tiny_data6','.'.$this->dataCss.' .nav_gen ul ul li',$style_list,'Additionally Tweak the Sub Menu Link LI Element','','');
   printer::close_print_wrap('Style individual Sub Links');
   $this->show_close('Style individual Sub Links');
   $style_list='background,padding_top,padding_bottom,padding_left,padding_right,margin_top,margin_bottom,margin_left,margin_right,font_family,font_size,font_weight,text_align,font_color,text_shadow,line_height,letter_spacing,italics_font,small_caps,text_underline,borders,box_shadow,outlines,radius_corner,transform';
   $this->show_more('Style Hover Links for Main and Sub Menus');
   printer::print_wrap('Style Hover Links');
   printer::print_tip('Here you can style both the LI A and the parent LI element which affects individual links.');
   printer::print_info('Recomended to use LI A then for special needs use LI');
   $this->edit_styles_close($data,'blog_tiny_data11','.'.$this->dataCss.' .nav_gen ul li a:hover',$style_list,'Style LI A: Hover Link','','When You Hover Over a Link with the cursor it will change according to Any Styles set Here' );
   $this->edit_styles_close($data,'blog_tiny_data4','.'.$this->dataCss.' .nav_gen ul li:hover', $style_list,'Style LI: Hover Link','','When You Hover Over a Link with the cursor it will change according to Any Styles set Here' );
     printer::print_wrap1('hover sub panel links');
     printer::print_tip('Style Hover Links on Sub Menu Panel (also affects @icon menu widths)');
   $this->edit_styles_close($data,'blog_tiny_data10','.'.$this->dataCss.' .nav_gen ul ul li a:hover',$style_list,'Style SUB PANEL LI: Hover Link','','When You Hover Over a Link with the cursor it will change according to Any Styles set Here' );
    printer::close_print_wrap1('hover sub panel links');
   printer::close_print_wrap('Style Hover Links');
   $this->show_close('Style Hover Links'); 
   printer::pclear(5);
   $this->edit_styles_close($data,'blog_tiny_data5','.'.$this->dataCss.' .nav_gen li.active a','background,font_family,font_size,font_weight,font_color,text_shadow,line_height,letter_spacing,italics_font,small_caps,text_underline,borders,box_shadow,outlines,radius_corner,transform','Style the Active Link','','An Active Link is the Particluar Link to the Current Page and its optionaly styled here');  
   printer::pclear(5);
     $this->edit_styles_close($data,'blog_data7','.'.$this->dataCss.':NOT(.iconOpen) .nav_gen ul:hover ul,.'.$this->dataCss.':NOT(.iconOpen) .nav_gen ul ul','width_special,width_max_special,width_min_special,background,padding_top,padding_bottom,padding_left,padding_right,margin_top,margin_bottom,margin_left,margin_right,borders,box_shadow,outlines,radius_corner,transform','Style background for the Sub Menu Hover Panel @ <h7> non menu icon</h7> widths','','If you have optionally made sub menus that can be styled the dropdown Panel which contains the dropdown menu links');  
          printer::print_wrap('str to upper');
		if($nav_params[$nav_force_caps_index]!=='force'){
			printer::alertx('<p class=" highlight floatleft" title="Captialize All Main Menu and Sub Menu Link Titles/Names"><input type="radio" value="force"  name="'.$data.'_'.$nav_name_ref.'_arrayed['.$nav_force_caps_index.']">Use Uppercase Text Only</p>');
			}
		else {
			printer::alertx('<p class=" highlight floatleft" title="Captialize All Main Menu and Sub Menu Link Titles/Names"><input type="radio" value="0"  name="'.$data.'_'.$nav_name_ref.'_arrayed['.$nav_force_caps_index.']">Disable Use Of Uppercase Text Only</p>');
			}
          $this->show_more('Style info','','info italic smaller');
          printer::print_wrap1('techinfo');
          $msg='Info: Uses Server Side php strtoupper()'; 
          printer::print_info($msg);
          printer::close_print_wrap1('techinfo');
          $this->show_close('Style info');
          printer::close_print_wrap('str to upper');
		printer::pclear(5); 
		$checked1=($nav_params[$nav_repeat_submenu_index]!=='repeat')?'checked="checked"':''; 
     $checked2=($nav_params[$nav_repeat_submenu_index]==='repeat')?'checked="checked"':'';#full 
     echo '<div class="fsminfo"><!--repeat menu wrap-->';
     printer::print_tip('A main link with a submenu can be repeated in the submenu by adding it manually by choosing the add/edit links menu or by choosing the Repeat Main Menu Links here');
     printer::alertx('<p class="information" title="When Submenu links are Being Used Do Not Repeat the main menu link at the top of list of submenu links "><input type="radio" value="1" '.$checked1.' name="'.$data.'_'.$nav_name_ref.'_arrayed['.$nav_repeat_submenu_index.']">Do Not Repeat Main Link to Submenu</p>');
		printer::pclear();
     printer::alertx('<p class="information" title="When Submenu links are Being Used Repeat the main menu link at the top of list of submenu links"><input type="radio" value="repeat" '.$checked2.' name="'.$data.'_'.$nav_name_ref.'_arrayed['.$nav_repeat_submenu_index.']">Repeat Main Menu Link in sub menu list if used </p>');
     printer::pspace(10); 
	echo '</div><!--repeat menu wrap-->';
		##############  horiz or vert
	echo '<div class="fsminfo editbackground editfont '.$this->column_lev_color.' floatleft"><!--Respond Vertical-->';
     echo '<p class="highlight left">Choose whether Horizontal Menus Will Appear without row sharing ie. Vertically <b>@ NON Menu Icon widths</b> or share Row Space as Space Permits centered or floated left</p>';
     $checked1=($nav_link_vertical_choice==='Vertical Only')?'checked="checked"':'';
     $checked2=($nav_link_vertical_choice==='Float Left')?'checked="checked"':'';
     $checked3=($nav_link_vertical_choice!=='Float Left'&&$nav_link_vertical_choice!=='Vertical Only')?'checked="checked"':'';
     echo '<p><input type="radio" value="Vertical Only" name="'.$data.'_'.$nav_name_ref.'['.$nav_menu_vertical_response_index.']." '.$checked1.'>Vertical Only (each link occupies full row) uses display: block;</p>';
     echo '<p><input type="radio" value="Float Left" name="'.$data.'_'.$nav_name_ref.'['.$nav_menu_vertical_response_index.']." '.$checked2.'>Float Left (Uses float:left;)</p>';
     echo '<p><input type="radio" value="Center Float" name="'.$data.'_'.$nav_name_ref.'['.$nav_menu_vertical_response_index.']." '.$checked3.'>Center Float (Default @NON menu-icon widths) Uses display:inline-block;)</p>';
     $nav_link_vertical_choice=($nav_link_vertical_choice==='Vertical Only')?'display:block;':(($nav_link_vertical_choice==='Float Left')?'display:block;float:left;':'display:inline-block;');
     $this->show_more('Style info','','info italic smaller');
     printer::print_wrap1('techinfo');
     printer::print_info('Current setting Css: .'.$this->dataCss.' .nav_gen ul.top-level:NOT(.menuRespond) li:NOT(.show_icon){
  '.$nav_link_vertical_choice.'
 }');
     $msg='Info: Sets the float of the li element to display:block or display:inline or float:left @ NON menu icon widths.'; 
     printer::print_info($msg);
     printer::close_print_wrap1('techinfo');
     $this->show_close('Style info');
     echo '</div><!-- Respond Vertical-->';
     printer::pclear(5);
     $this->submit_button();   
     ##############  horiz or vert    
     //$pass_nav_class=($this->blog_tiny_data3==='nav_display')?'+display':'+hover';
     printer::pspace(10);
     echo '<div class="fsminfo"><!--submenu hover-->';
     $checked1=($nav_params[$nav_sub_display_index]!=='nav_display')?'checked="checked"':''; 
     $checked2=($nav_params[$nav_sub_display_index]==='nav_display')?'checked="checked"':'';#full width option
     printer::alertx('<p class="information floatleft" title="Choose to display submenus when hovered Over "><input type="radio" value="1" '.$checked1.' name="'.$data.'_'.$nav_name_ref.'['.$nav_sub_display_index.']">Hover Submenus </p>');
     printer::pclear();
     printer::alertx('<p class="information floatleft" title=" Display Submenus always"><input type="radio" value="nav_display" '.$checked2.' name="'.$data.'_'.$nav_name_ref.'['.$nav_sub_display_index.']">Always Display Submenus</p>');
     #blog_tiny_data3 display or horiz handled in the # maindiv specific for nav
     printer::pclear();
     if ($nav_params[$nav_sub_display_index]!=='nav_display'){
          $nav_submenu_display='
     .'.$this->dataCss.' .nav_gen UL  LI  {position:relative;}
.'.$this->dataCss.' .nav_gen  UL UL {Z-INDEX: 100; LEFT:0; TOP:0; VISIBILITY: hidden;  overflow:hidden;   POSITION: absolute;  }
  .'.$this->dataCss.' .nav_gen  UL :hover UL :hover UL  { VISIBILITY: visible;} 
.'.$this->dataCss.' .nav_gen  UL LI:hover UL  { VISIBILITY: visible } 
.'.$this->dataCss.' .nav_gen ul.sub-level,.hover .nav_gen  ul ul  {  Z-INDEX: 100; }
.'.$this->dataCss.' .nav_gen  UL UL LI  {margin-right:auto; margin-left:auto;} 
';
          }
     else {
     $nav_submenu_display='
          .'.$this->dataCss.' .nav_gen  ul.sub-level,.nav_gen UL UL LI  {display:block;}';
          } 
     $this->show_more('Style info','','info italic smaller');
     printer::print_wrap1('techinfo');
     printer::print_info('Current setting Css: '.$nav_submenu_display);
      $msg='Info: For Hovering it changes the visibility of the ul.sub-menu panel from hidden to visible and centers it with marginleft-right auto; Whereas for constant Display sub-menu panel is visible and sets li element to display:block; by default';
     printer::print_info($msg);
     printer::close_print_wrap1('techinfo');
     $this->show_close('Style info');
     echo '</div><!--submenu hover-->';
     printer::pclear(10);
     /*
     $this->show_more('Optional Width/Max-width/Height settings for Nav Links');
     printer::print_wrap('Optional Width');
	echo '<div class="fsminfo editbackground editfont left floatleft" ><!--Link MAX width-->';
     $nav_link_maxwidth_val=$this->spacing($data.'_'.$nav_name_ref.'_arrayed',$nav_link_maxwidth_index,'max-width','Choose Main Link max-width','Optionally choose a specific max-width for Nav MAIN Links Here.','','','','','.'.$this->dataCss.' .nav_gen UL.top-level>LI>A');  
	 $this->show_more('Style info','','info tiny italic');
     printer::print_wrap1('more inifo');
     $nav_link_maxwidth_val=(!empty($nav_link_maxwidth_val))?$nav_link_maxwidth_val:'.'.$this->dataCss.' .nav_gen UL.top-level>LI>A {}';
     printer::print_tip('If chosen applies Css Style: '.$nav_link_maxwidth_val);    
     printer::print_info('Sets Specific max-width for top level Main Link Widths only');
     printer::close_print_wrap1('more inifo');
     $this->show_close('More info');
     echo '</div><!--Link MAX width-->';
	echo '<div class="fsminfo editbackground editfont left floatleft" ><!--Link MAX width-->';
     $nav_sub_link_maxwidth_val=$this->spacing($data.'_'.$nav_name_ref.'_arrayed',$nav_sub_link_maxwidth_index,'max-width','Choose SUB Link max-width','Optionally choose a specific max-width for Nav SUB Links Here.','','','','','.'.$this->dataCss.' .nav_gen UL UL>LI>A');  
	 $this->show_more('Style info','','info tiny italic');
     printer::print_wrap1('more inifo');
     $nav_sub_link_maxwidth_val=(!empty($nav_sub_link_maxwidth_val))?$nav_sub_link_maxwidth_val:'.'.$this->dataCss.' .nav_gen UL.top-level>LI>A {}';
     printer::print_tip('If chosen applies Css Style: '.$nav_sub_link_maxwidth_val);    
     printer::print_info('Sets Specific max-width for top level Main Link Widths only');
     printer::close_print_wrap1('more inifo');
     $this->show_close('More info');
     echo '</div><!--Link MAX width-->';
     echo '<div  class="fsminfo editbackground editfont left  floatleft" ><!--Link width-->';
     printer::alertx('<p class="info" title="select a set width for navigation links" >Optionally choose a specific width for Navigation Links Here.</p>');
     $nav_link_val=$this->spacing($data.'_'.$nav_name_ref.'_arrayed',$nav_link_width_index,'width','Choose Main Link width','Optionally choose a specific width for Nav Main Links Here.','','width:auto;','','','.'.$this->dataCss.' .nav_gen UL.top-level>LI>A');  
	 $this->show_more('Style info','','info tiny italic');
     printer::print_wrap1('more inifo');
     $nav_link_val=(!empty($nav_link_val))?$nav_link_val:'.'.$this->dataCss.' .nav_gen UL.top-level>LI>A {}';
     printer::print_tip('If chosen applies Css Style: '.$nav_link_val);    
     printer::print_info('Sets Specific width for top level Main Link Widths only');
     printer::close_print_wrap1('more inifo');
     $this->show_close('More info');
     echo '</div ><!--Link width Wrapper-->'; 
     printer::pclear(5);
     echo '<div class="fsminfo editbackground editfont left  floatleft"><!--SubLink width-->';
     printer::alertx('<p class=" '.$this->column_lev_color.'" title="Lengthen you Sub Menu Navigation Link Width independently of the Main Links Here!" >Set Width For Sub Menu Links Only Here </p>');
	$nav_sub_link_val=$this->spacing($data.'_'.$nav_name_ref.'_arrayed',$nav_sub_link_width_index,'width','Choose Sub Link width','Optionally choose a specific width for Nav Sub Links Here.','','width:auto;','','','.'.$this->dataCss.' .nav_gen UL UL>LI>A');  
	 $this->show_more('Style info','','info tiny italic');
     printer::print_wrap1('more inifo');
     $nav_sub_link_val=(!empty($nav_sub_link_val))?$nav_sub_link_val:'.'.$this->dataCss.' .nav_gen UL UL>LI>A {}';
     printer::print_tip('If chosen applies Css Style: '.$nav_sub_link_val);    
     printer::print_info('Sets Specific width for SUB Link Widths only');
     printer::close_print_wrap1('more inifo');
     $this->show_close('More info');
     echo '</div><!--SubLink width-->';
     $current_link_height=(is_numeric($nav_params[$nav_link_height_index])&&$nav_params[$nav_link_height_index]>24&&$nav_params[$nav_link_height_index]<101)?$nav_params[$nav_link_height_index]:'default';
     echo '<div class="fsminfo editbackground editfont '.$this->column_lev_color.' floatleft"><!--Link Height-->';
     printer::print_tip('Optionally set a Uniform Height for all the Menu Links. By Default Links have automatic Height Depending on The Number of Rows of Link TEXT. Set a specific Height here');
     echo '<p class="highlight left" >Optionally Set a Fixed Link Height</p>';
     $this->mod_spacing($data.'_'.$nav_name_ref.'_arrayed['.$nav_link_height_index.']',$current_link_height,24,101,1,'px','none'); 
     echo '</div><!--Link Height-->'; 
     printer::close_print_wrap('Optional Width');
     $this->show_close('Optional Width/Max-width/Height settings for Nav Links');*/
     echo '<div class="fsminfo editbackground editfont '.$this->column_lev_color.' floatleft"><!--Link Height-->';
     printer::print_tip('Optionally set a Uniform Height for all the Menu Links. Normally Links have automatic Height Depending on The Number of Rows of Link TEXT and padding. Set a specific Height here',.7);
     $nav_link_height=$this->spacing($data.'_'.$nav_name_ref.'_arrayed',$nav_link_height_index,'height','Choose Main Link height','Normally heights are set to auto; Optionally choose a specific height for Nav Main Links Here.','','','','','.'.$this->dataCss.' .nav_gen UL.top-level>LI>A');  
	 $this->show_more('Style info','','info tiny italic');
     printer::print_wrap1('more inifo');
     $nav_link_heightl=(!empty($nav_link_heightl))?$nav_link_heightl:'.'.$this->dataCss.' .nav_gen UL.top-level>LI>A {}';
     printer::print_tip('If chosen applies Css Style: '.$nav_link_heightl);    
     printer::print_info('Sets Specific width for top level Main Link Widths only');
     printer::close_print_wrap1('more inifo');
     $this->show_close('More info');
     echo '</div><!--Link Height-->'; 
     printer::pclear();	echo '<div class="fsminfo editbackground editfont '.$this->column_lev_color.' floatleft"><!--Link Height-->';
     printer::print_tip('Optionally set a Uniform Height for all the Menu Links. Normally Links have automatic Height Depending on The Number of Rows of Link TEXT and padding. Set a specific Height here',.7);
     $nav_sub_link_height=$this->spacing($data.'_'.$nav_name_ref.'_arrayed',$nav_sub_link_height_index,'height','Choose SUB Link height','Normally heights are set to auto; Optionally choose a specific height for Nav SUB Links Here.','','','','','.'.$this->dataCss.' .nav_gen UL UL>LI>A');  
	 $this->show_more('Style info','','info tiny italic');
     printer::print_wrap1('more inifo');
     $nav_sub_link_heightl=(!empty($nav_sub_link_heightl))?$nav_sub_link_heightl:'.'.$this->dataCss.' .nav_gen UL UL>LI>A {}';
     printer::print_tip('If chosen applies Css Style: '.$nav_sub_link_heightl);    
     printer::print_info('Sets Specific height for SUB Link Widths only');
     printer::close_print_wrap1('more inifo');
     $this->show_close('More info');
     echo '</div><!--Link Height-->'; 
     printer::pclear();	
     $this->submit_button(); 
     printer::close_print_wrap('detail link');
     $this->show_close('Detailed Link Area');//<!--End Show More Edit Nav-->'; 
     $this->show_more('Style/Enable/Customize @ <h7>Menu Icon</h7> Width','','','',600);
     printer::print_wrap('rwd menu icon');
     printer::print_wrap('outer absolute relative menu icon');
     printer::print_tip('Customize  positioning of menu icon/open menu icon &amp; menu');
     $this->show_more('Positioning of menu icon');
     printer::print_wrap('Rel and Abs Pos');
     printer::print_wrap('menuicon pos width');
     printer::print_tip('Follow Absolute Positioning of Menu icon Procedure to Place the closed Menu icon @menu icon widths wherever you want vertically or horizontally on the page. To keep the closed Menu icon @menu icon widths in its Relative place vertically use Relative Positioning procedure.');
     printer::print_notice('These Options below enable the ability to position the icon menu anywhere, absolute or relatively, and tweak the positions of the closed menu icon, open menu icon, and open menu links');
     $msg='1. For Abs. or Rel. Set the Position of Closed Menu icon left or right @menu icon widths within the bounds of the overall menu position. Use left for left orientation and right for right orientation.';
     printer::print_tip($msg);
     echo'<p class="floatleft"> <select class="editcolor editbackground editfont" name="'.$data.'_'.$nav_name_ref.'['.$nav_icon_horiz_pos_index.']">';    
     echo '<option value="'.$this->page_editborder.'" selected="selected">'.$nav_icon_horiz_pos.'</option> 
		 	<option value="none">None </option>
		 	<option value="left">left position </option>
		 	<option value="right">right position </option>
	  </select></p>';
     $this->show_more('Style info','','info italic smaller');
     printer::print_wrap1('techinfo');
     printer::print_info('Current setting Css: #'.$this->dataCss.':not(.iconOpen) .show_icon{'.$nav_icon_horiz_pos.':0;}');
      $msg='Info: Sets the Absolute Positioning of the show_icon li element to left:0; or right:0. The li.show_icon contains the nav-icon bars.'; 
     printer::print_info($msg);
     printer::close_print_wrap1('techinfo');
     $this->show_close('Style info');
     printer::pclear();
     printer::close_print_wrap('menuicon pos width');
     printer::print_wrap('menuicon pos width2');
     $msg='2. <b>For Relative Positioning</b> the horizontal positioning is limited by the post width ie. whether the post extended far enough left or right. Check here to set the overall post to 100% width @menu icon width when the menu icon is visible and closed'; 
     printer::print_tip($msg);
     $checked1=($nav_params[$nav_icon_total_menu_width_index]==='relative100')?'checked="checked"':'';
     $checked2=($nav_params[$nav_icon_total_menu_width_index]!=='relative100')?'checked="checked"':'';
     printer::alert('<input type="radio" value="relative100" name="'.$data.'_'.$nav_name_ref.'_arrayed['.$nav_icon_total_menu_width_index.']" '.$checked1.'>Set Menu (main div) to 100% of available width to enable full left or right positioning when the menu icon is visible ie using @media query for the maxwidth menu icon setting');
     printer::alert('<input type="radio" value="remove" name="'.$data.'_'.$nav_name_ref.'_arrayed['.$nav_icon_total_menu_width_index.']" '.$checked2.'>Do Not set 100% width');
     printer::close_print_wrap('menuicon pos width2');
     $final_nav_icon_total_menu_width=(!empty($checked))?'#'.$this->dataCss.'{width:100%;margin:0;padding:0;}':'.'.$this->dataCss.'{margin:0;padding:0px;}';
     
     printer::print_wrap('menuicon pos width3');
     $msg='3. Relative or Absolute Positioning of the menu icon is now done in the Navigation Main Post settings available for each post type under the positioning option. Set to Absolute or Relative. Then choose left or right/top or bottom and value. Negative values are also available. To enable positioning icon choice Choose @media screen max-width px in the positioning option <br><br>Note: when Absolute is used Positive values for top which space the icon lower (and menu iteself when open) will be relative from the top of the body if a parent column relative is previously not set'; 
     printer::print_tip($msg);
     $msg='Select Menu Icon display View Port Width </b>(also under the Style/Enable/Customize @ Menu Icon Width heading &amp; down below.)<br>
     Should match the Positioning option @media screen max-width choesen in step 3.'; 
     printer::print_tip($msg);
     printer::close_print_wrap('menuicon pos width3');
     printer::print_wrap('menu icon pos tweaks');
     $msg='You can also Tweak the positioning of the opened navigation menu when the menu icon is clicked and then independently tweak the position of opened icon iteself without affecting its closed positioning'; 
     printer::print_tip($msg);
     $this->show_more('Tweak left/right/top Positioning of full menu when icon opened'); 
     printer::print_wrap('horiz verts'); 
     printer::alert('Optionally tweak right or left position value of opened and absolute positioned navigation menus at widths the icon both appears and is clicked open. <h7>Left value will override right value if both chosen</h7>');
      $final_open_icon_position_left=$this->spacing($data.'_'.$nav_name_ref,$nav_open_icon_left_index,'return','Choose left positioning value','Use Left Horiz Position of absolute positioned opened sub menu','','','','','','','Check none or left:0 or enter left value as needed',array('zero'=>'left:0;','none'=>'none'));
     $clp=(!empty($final_open_icon_position_left))?$final_open_icon_position_left:'none';
     printer::alert('Current position left: '.$clp); 
     $final_open_icon_position_right=$this->spacing($data.'_'.$nav_name_ref,$nav_open_icon_right_index,'return','Choose right positioning value','Use Right Horiz Position of absolute positioned opened sub menu','','','','','','','Check none or right:0 or enter right value as needed',array('zero'=>'right:0;','none'=>'none'));
     $crp=(!empty($final_open_icon_position_right))?$final_open_icon_position_right:'none';
     printer::alert('Current position right: '.$crp);
     if ($nav_params[$nav_open_icon_left_index]==='zero')
        $final_open_icon_position_horiz="#$this->dataCss.iconOpen{left:0;}";
     elseif (!empty($final_open_icon_position_left)&&$final_open_icon_position_left!=='none')
        $final_open_icon_position_horiz="#$this->dataCss.iconOpen{left:$final_open_icon_position_left;}";
     elseif ($nav_params[$nav_open_icon_right_index]==='zero')
        $final_open_icon_position_horiz="#$this->dataCss.iconOpen{right:0;left:auto !important;}";
     elseif(!empty($final_open_icon_position_right)&&$final_open_icon_position_right!=='none') 
        $final_open_icon_position_horiz="#$this->dataCss.iconOpen{right: $final_open_icon_position_right; left:auto !important;}";
     else $final_open_icon_position_horiz='';
     $this->show_more('Style info','','info italic smaller');
     printer::print_wrap1('techinfo');
     printer::print_info('Current setting Css: '.$final_open_icon_position_horiz);
     $msg='When the navigation menu icon is clicked javascript adds the class name iconOpen to the main navigation div and then the iconOpen class name is appended to the div selector giving it more specificity to position right or left according to the particular setting made here. Media max width is also used according to the @media width selected for the icon to appear';
     printer::print_info($msg);
     printer::close_print_wrap1('techinfo');
     $this->show_close('Tech info');
     printer::close_print_wrap1('horiz adjust');
     printer::print_wrap1('vert adjust');
     printer::alert('Optionally tweak top position value of opened and absolute positioned navigation menus (if optionaly configured under post settings) at widths the icon both appears and is clicked open.');
     $final_open_icon_position_top=$this->spacing($data.'_'.$nav_name_ref,$nav_open_icon_top_index,'return','Choose top positioning value','Use top Vert Position of absolute positioned opened sub menu','','','','','','','Check none or top:0 or enter top value as needed',array('zero'=>'top:0;','none'=>'none'));
     $crp=(!empty($final_open_icon_position_top))?$final_open_icon_position_top:'none';
     printer::alert('Current position top: '.$crp);
     if ($nav_params[$nav_open_icon_top_index]==='zero')
        $final_open_icon_position_vert="#$this->dataCss.iconOpen{top:0;}";
     elseif (!empty($final_open_icon_position_top)&&$final_open_icon_position_top!=='none')
        $final_open_icon_position_vert="#$this->dataCss.iconOpen{top: $final_open_icon_position_top;}";
     else $final_open_icon_position_vert='';
     $this->show_more('Style info','','info italic smaller');
     printer::print_wrap1('techinfo');
     printer::print_info('Current setting Css: '.$final_open_icon_position_vert);
     $msg='When the navigation menu icon is clicked javascript adds the class name iconOpen to the main navigation div and then the iconOpen class name is appended to the div selector giving it more specificity to position top according to the particular setting made here. Media max width is also used according to the @media width selected for the icon to appear';
     printer::print_info($msg);
     printer::close_print_wrap1('techinfo'); 
     $this->show_close('Tech info'); 
     printer::close_print_wrap1('vert adjust');
     printer::close_print_wrap('horiz verts');
     $this->show_close('Tweak Opened Nav Icon &amp; Links');
     ################### open icon itself
     $this->show_more('Independently Tweak Positioning of Opened nav icon only'); 
     printer::print_wrap('Tweak Opened Nav Icon Only'); 
     printer::alert('Optionally tweak right or left  position value of the open icon independent of the open menu links or closed icon. Left value will override right value if both chosen');
     printer::print_wrap1('only horiz adjust');
     $final_open_icon_only_position_left=$this->spacing($data.'_'.$nav_name_ref,$nav_open_icon_only_left_index,'return','Choose left positioning value','Use Left Horiz Position of open icon','','','','','','','Check none or left:0 or enter left value as needed',array('zero'=>'left:0;','none'=>'none'));
     $clp=(!empty($final_open_icon_only_position_left))?$final_open_icon_only_position_left:'none';
     printer::alert('Current position left: '.$clp);
     $final_open_icon_only_position_right=$this->spacing($data.'_'.$nav_name_ref,$nav_open_icon_only_right_index,'return','Choose right positioning value','Use Right Horiz Position for open icon','','','','','','','Check none or right:0 or enter right value as needed',array('zero'=>'right:0;','none'=>'none'));
     $clp=(!empty($final_open_icon_only_position_right))?$final_open_icon_only_position_right:'none';
     printer::alert('Current position right: '.$clp); 
     if ($nav_params[$nav_open_icon_only_left_index]==='zero')
        $final_open_icon_only_position_horiz="#$this->dataCss.iconOpen ul.menuRespond li.show_icon{left:0;}";
     elseif (!empty($final_open_icon_only_position_left)&&$final_open_icon_only_position_left!=='none')
     $final_open_icon_only_position_horiz="#$this->dataCss.iconOpen ul.menuRespond li.show_icon{left:$final_open_icon_only_position_left;}";
     elseif ($nav_params[$nav_open_icon_only_right_index]==='zero')
        $final_open_icon_only_position_horiz="#$this->dataCss.iconOpen ul.menuRespond li.show_icon,.$this->dataCss.iconOpen ul.menuRespond li.show_icon{right:0;left:auto !important;}";
     elseif(!empty($final_open_icon_only_position_right)&&$final_open_icon_only_position_right !=='none') 
        $final_open_icon_only_position_horiz="#$this->dataCss.iconOpen ul.menuRespond li.show_icon,.$this->dataCss.iconOpen ul.menuRespond li.show_icon{right: $final_open_icon_only_position_right;left:auto !important;}";
     else $final_open_icon_only_position_horiz='';
     $this->show_more('Style info','','info italic smaller');
     printer::print_wrap1('techinfo');
     printer::print_info('Current setting Css: '.$final_open_icon_only_position_horiz);
     $msg='The selector is : '."#$this->dataCss.iconOpen ul.menuRespond li.show_icon,.$this->dataCss.iconOpen ul.menuRespond li.show_icon".'<br> When the navigation menu icon is clicked javascript adds the class name iconOpen to the main div and menuRespond is appended to the ul selector, both giving it more specificity and therefore the li.show_icon class of the now opened menu-icon element is targeted specificaly to position right or left according to the particular setting made here. Media max width is also used according to the @media width selected for the icon to appear';
     printer::print_info($msg);
     printer::close_print_wrap1('techinfo');
     $this->show_close('Tech info');
     printer::close_print_wrap1('only horiz adjust');
     printer::alert('Optionally tweak top position value of the icon independent of the open menu links or closed icon position');
     printer::print_wrap1('only vert adjust');
     $final_open_icon_only_position_top=$this->spacing($data.'_'.$nav_name_ref,$nav_open_icon_only_top_index,'return','Choose top positioning value','Use top Vert Position of absolute positioned opened sub menu','','','','','','','Check none or top:0 or enter top value as needed',array('zero'=>'top:0;','none'=>'none'));
     $clp=(!empty($final_open_icon_only_position_top))?$final_open_icon_only_position_top:'none';
     printer::alert('Current position top: '.$clp);
     if ($nav_params[$nav_open_icon_only_top_index]==='zero')
        $final_open_icon_only_position_vert="#$this->dataCss.iconOpen ul.menuRespond li.show_icon{top:0;}";
     elseif (!empty($final_open_icon_only_position_top)&&$final_open_icon_only_position_top!=='none')
        $final_open_icon_only_position_vert="#$this->dataCss.iconOpen ul.menuRespond li.show_icon{top: $final_open_icon_only_position_top;}";
     else $final_open_icon_only_position_vert='';
     $this->show_more('Style info','','info italic smaller');
     printer::print_wrap1('techinfo');
     printer::print_info('Current setting Css: '.$final_open_icon_only_position_vert);
     $msg='The selector is : '."#$this->dataCss.iconOpen ul.menuRespond li.show_icon,.$this->dataCss.iconOpen ul.menuRespond li.show_icon".'<br> When the navigation menu icon is clicked javascript adds the class name iconOpen to the main div and menuRespond is appended to the ul selector, both giving it more specificity and therefore the li.show_icon class of the now opened menu-icon element is targeted specificaly to position top according to the particular setting made here. Media max width is also used according to the @media width selected for the icon to appear';
     printer::print_info($msg);
     printer::close_print_wrap1('techinfo');
     printer::close_print_wrap1('only vert adjust');
     printer::close_print_wrap('Independently Tweak Positioning of Opened nav icon only');
     $this->show_close('Tweak Opened Nav Icon Only');
     printer::pclear(5);
     $final_nav_icon_horiz_pos=($nav_icon_horiz_pos!=='none')?'#'.$this->dataCss.':not(.iconOpen) .show_icon{'.$nav_icon_horiz_pos.':0;}':'';
      printer::close_print_wrap('menu icon pos tweaks');
     ############# close open icon itself
     printer::close_print_wrap('Rel and Abs Pos');
     $this->show_close('Absolute or Relative Positioning of menu icon');
     printer::close_print_wrap('outer absolute relative menu icon');
     printer::print_wrap('responsivmenustyle');
     printer::print_tip('Check out options to Tweak the position the entire open menu and/or opened icon down below');
     $style_list='width_special,width_max_special,width_min_special,background,padding_top,padding_bottom,padding_left,padding_right,margin_top,margin_bottom,margin_left,margin_right,font_family,font_weight,text_align,font_color,text_shadow,line_height,letter_spacing,italics_font,small_caps,text_underline,borders,box_shadow,outlines,radius_corner,transform';
     $this->show_more('Style individual Links @ icon width');
     printer::print_wrap('Style individual Links');
     printer::print_tip('@ menu icon widths you can style either/both the LI A and the parent LI element which affects individual links.');
     printer::print_info('Recomended to use LI A then for special needs use LI');
     $this->edit_styles_close($data,'blog_data9','.'.$this->dataCss.' .ulTop.menuRespond2 li a',$style_list,"Style Opened Nav Links (LI A:Link) when Responsive Menu Icon is clicked",'','',true,true ); 
     $this->edit_styles_close($data,'blog_tiny_data7','.'.$this->dataCss.' .ulTop.menuRespond2 li',$style_list,"Tweak Opened Nav Links (LI) Differently when Responsive Menu Icon is clicked",'','',true,true ); 
     printer::close_print_wrap('Style individual Links');
     $this->show_close('Style individual Sub Links @ icon width');
     $this->show_more('Style individual Sub Links @ icon width');
     printer::print_wrap('Style individual Sub Links');
     printer::print_tip('@ menu icon widths you can style both the LI A and the parent LI element which affects individual SUB links.');
     printer::print_info('Recomended to use LI A then for special needs use LI');
     $this->edit_styles_close($data,'blog_data10','.'.$this->dataCss.' .ulTop.menuRespond2 ul li a','width_special,width_max_special,width_min_special,background,padding_top,padding_bottom,padding_left,padding_right,margin_top,margin_bottom,margin_left,margin_right,text_align,borders,box_shadow,outlines,radius_corner,transform',"Style (LI A:LINK) Opened Nav Sub Menu Links Differently when Responsive Menu Icon is clicked",'','',true,true );
     $this->edit_styles_close($data,'blog_data11','.'.$this->dataCss.' .ulTop.menuRespond2 ul li','width_special,width_max_special,width_min_special,background,padding_top,padding_bottom,padding_left,padding_right,margin_top,margin_bottom,margin_left,margin_right,text_align,borders,box_shadow,outlines,radius_corner,transform',"Style (LI) Opened Nav Sub Menu Links Differently when Responsive Menu Icon is opened",'','',true,true ); 
     printer::close_print_wrap('Style individual Sub Links');
     $this->show_close('Style individual Sub Links @ icon width');
     $this->edit_styles_close($data,'blog_data8','.'.$this->dataCss.' .ulTop.menuRespond2','width_special,width_max_special,width_min_special,background,padding_top,padding_bottom,padding_left,padding_right,margin_top,margin_bottom,margin_left,margin_right,text_align,borders,box_shadow,outlines,radius_corner,transform',"Style opened Nav Link Background Area including Borders/etc. when Responsive Menu Icon is opened",'','',true,true );
     $style_list='background,font_family,font_weight,text_align,font_color,text_shadow,line_height,letter_spacing,italics_font,small_caps,text_underline,borders,box_shadow,outlines,radius_corner,transform';
     $this->show_more('Style Hover Links for @ <h7>Menu icon</h7> width');
     printer::print_wrap('Style Hover Links');
     printer::print_tip('Here you can style both the Hover effect for LI A and the parent LI element which affects individual links @media menu-icon widths.');
     printer::print_info('Recomended to use LI A then for special needs use LI');
     $this->edit_styles_close($data,'blog_tiny_data8','.'.$this->dataCss.' .nav_gen .ulTop.menuRespond2   a:hover','background,font_family,font_weight,font_color,text_shadow,line_height,letter_spacing,italics_font,small_caps,text_underline,borders,box_shadow,outlines,radius_corner,transform','Style LI A: Hover Link For Both Main &amp; Sub Menu Link if different than the main hover settings ','','When You Hover Over a Link with the cursor it wil change according to Any Styles set Here' );
     $this->edit_styles_close($data,'blog_tiny_data9','.'.$this->dataCss.' .nav_gen .ulTop.menuRespond2 li:NOT(.show_icon):hover','background,font_family,font_weight,font_color,text_shadow,line_height,letter_spacing,italics_font,small_caps,text_underline,borders,box_shadow,outlines,radius_corner,transform','Style LI: Hover Link','','When You Hover Over a Link with the cursor it wil change according to Any Styles set Here' );
     printer::close_print_wrap('Style Hover Links');
     $this->show_close('Style Hover Links for @ Menu icon width');
   $this->edit_styles_close($data,'blog_data12','.'.$this->dataCss.' .nav_gen .ulTop.menuRespond2:hover ul,.'.$this->dataCss.' .nav_gen .ulTop.menuRespond2 ul','width_special,width_max_special,width_min_special,background,padding_top,padding_bottom,padding_left,padding_right,margin_top,margin_bottom,margin_left,margin_right,borders,box_shadow,outlines,radius_corner,transform','Style the Sub Menu Hover Panel @ <h7>menu icon</h7> widths','','If you have optionally made sub menus that can be styled the background dropdown Panel which contains the dropdown menu links'); 
     printer::close_print_wrap('responsivmenustyle');
     printer::pclear(5);
     echo '<div class="fsminfo editbackground editfont '.$this->column_lev_color.' floatleft"><!--Menu Icon RWD Width-->';
     printer::alertx('<p class="highlight left" title="Select a Responsive viewport width size under which the menu will be represent by a menu icon. Full Menu will appear when icon is clicked"><b>Select Menu Icon display View Port Width</b>.<br></p>');
     printer::alertx('<p class="tip">By default Menu Icon appear at viewport widths under 769px. Use none to prevent menu icon appearing at any width!</p>');
     $this->mod_spacing($data.'_'.$nav_name_ref.'_arrayed['.$nav_icon_media_width_index.']',$respond_menu_dimension,$min_viewport,$max_viewport,1,'px','none');
     $checked1=($respond_menu_dimension==='icon full on')?'checked="checked"':'';
     $checked2=($respond_menu_dimension==='icon full on')?'':'checked="checked"';
     printer::printx('<p class="info" title="checking here will enables menu icon to be displayed at all widths."><input type="radio" value="icon full on" name="'.$data.'_'.$nav_name_ref.'_arrayed['.$nav_icon_media_width_index.']" '.$checked1.'>Make Menu Icon Permanant</p>');
     printer::printx('<p class="info" title="checking here will removes menu icon to be displayed at all widths."><input type="radio" value="No full on" name="'.$data.'_'.$nav_name_ref.'_arrayed['.$nav_icon_media_width_index.']" '.$checked2.'>Do Not Make Menu Icon Permanant</p>');
     $this->show_more('Style info','','info italic smaller');
     printer::print_wrap1('techinfo'); 
      $msg='Info: @media screen and (max-width:'.$respond_menu_dimension.'px) {}<br> @media max-width value used for various css styles is configured here'; 
     printer::print_info($msg);
     printer::close_print_wrap1('techinfo');
     $this->show_close('Style info');
     echo '</div><!--Menu Icon RWD Width-->';
     printer::pclear();
     echo '<div class="fsminfo"><!--openicon submenu hover-->';
     $checked1=($nav_params[$nav_openicon_sub_display_index]==='hoverit')?'checked="checked"':''; 
     $checked2=($nav_params[$nav_openicon_sub_display_index]!=='hoverit')?'checked="checked"':'';#full width option
     printer::print_tip('By default open icon menus will display submenus. You can change that here');
     printer::alertx('<p class="information floatleft" title="Choose to display openicon submenus when hovered Over "><input type="radio" value="hoverit" '.$checked1.' name="'.$data.'_'.$nav_name_ref.'['.$nav_openicon_sub_display_index.']">Hide till Hover Openicon submenus </p>');
     printer::pclear();
     printer::alertx('<p class="information floatleft" title=" Display Openicon submenus always"><input type="radio" value="nonav_display" '.$checked2.' name="'.$data.'_'.$nav_name_ref.'['.$nav_openicon_sub_display_index.']">Always Display Openicon submenus</p>');
     #blog_tiny_data3 display or horiz handled in the # maindiv specific for nav
     printer::pclear();
     if ($nav_params[$nav_openicon_sub_display_index]==='hoverit'){
          $nav_openicon_submenu_display='
     .'.$this->dataCss.'.iconOpen .nav_gen UL  LI  {position:relative;}
.'.$this->dataCss.'.iconOpen .nav_gen  UL UL {Z-INDEX: 100; LEFT:0; TOP:0; VISIBILITY: hidden;  overflow:hidden;   POSITION: absolute;  }
  .'.$this->dataCss.'.iconOpen .nav_gen  UL :hover UL :hover UL  { VISIBILITY: visible;} 
.'.$this->dataCss.'.iconOpen .nav_gen  UL LI:hover UL  { VISIBILITY: visible } 
.'.$this->dataCss.'.iconOpen .nav_gen ul.sub-level,.hover .nav_gen  ul ul  {  Z-INDEX: 100; }
.'.$this->dataCss.'.iconOpen .nav_gen  UL UL LI  {margin-right:auto; margin-left:auto;} 
';
          }
     else {
     $nav_openicon_submenu_display='
          .'.$this->dataCss.'.iconOpen .nav_gen  ul.sub-level,.'.$this->dataCss.'.iconOpen .nav_gen UL UL LI  {display:block;}
          .'.$this->dataCss.'.iconOpen .nav_gen UL  LI  {position:static;}
.'.$this->dataCss.'.iconOpen .nav_gen  UL UL { VISIBILITY: visible;  overflow:hidden;   POSITION: static;  }
          ';
          } 
     $this->show_more('Style info','','info italic smaller');
     printer::print_wrap1('techinfo');
     printer::print_info('Current setting Css: '.$nav_openicon_submenu_display);
      $msg='Info: For Hovering it changes the visibility of the ul.sub-menu panel from hidden to visible and centers it with marginleft-right auto; Whereas for constant Display sub-menu panel is visible and sets li element to display:block; by default';
     printer::print_info($msg);
     printer::close_print_wrap1('techinfo');
     $this->show_close('Style info');
     echo '</div><!--openicon_submenu hover-->';
     $msg='Optionally set a specific navigation Link Width @ menu icon Widths. Affects the overall width of the opened icon menu links area';
     printer::print_wrap('menu link width');
     printer::print_tip($msg);
     $nav_open_icon_total_menu_width=$this->spacing($data.'_'.$nav_name_ref,$nav_open_icon_total_menu_width_index,'return width','Optionally specify opened menu width @ icon widths','','','','','');
     $tval=intval($nav_open_icon_total_menu_width);
     $final_nav_open_icon_total_menu_width=(!empty($tval)&&is_numeric($tval))?'#'.$this->dataCss.'.iconOpen{width:'.$nav_open_icon_total_menu_width.';}':'';
     $this->show_more('Style info','','info italic smaller');
     printer::print_wrap1('techinfo');
     printer::print_info('Current setting Css: #'.$this->dataCss.'.iconOpen{width:'.$nav_open_icon_total_menu_width.';}');
      $msg='Info: Sets the Width of the opened menu navigation area &amp; uses the id with higher specificity over class'; 
     printer::print_info($msg);
     printer::close_print_wrap1('techinfo');
     $this->show_close('Style info');
     printer::pclear(); 
     printer::close_print_wrap('menu link width');
     echo '<div class="fsminfo editbackground editfont '.$this->column_lev_color.' floatleft"><!--Icon Width-->'; 
     echo '<p class="highlight left" title="Select a icon width for the Responsize menu icon">Change Default Width of the Icon (1unit=16px)</p>';
     $this->mod_spacing($data.'_'.$nav_name_ref.'_arrayed['.$nav_icon_width_index.'][0]',$icon_width,.3,10,.1,'unit');
     printer::print_tip('Nav Icon bar Width and Height will scale proportionately to width. Width may be activated with scaling (responsive to viewport width) if enabled here.');
     $this->rwd_scale($nav_params[$nav_icon_width_index],$data.'_'.$nav_name_ref.'['.$nav_icon_width_index.']',"#$this->dataCss .show_icon",'font-size','Navigation Menu Icon Size','px',0,1,false,16,20); 
     $this->show_more('Style info','','info italic smaller');
     printer::print_wrap1('techinfo');
     printer::print_info('Current setting Css: #$this->dataCss .show_icon');
      $msg='Info: Sets the Width of the icon-menu itself uses the id with higher specificity over class'; 
     printer::print_info($msg);
     printer::close_print_wrap1('techinfo');
     $this->show_close('Style info');
     printer::pclear();
     echo '</div><!-- Icon Width-->';
     printer::pclear(5);
     echo '<div class="fsminfo" ><!--link color--><br>'; 
      printer::alertx('<p class="left editbackground editfont editcolor">Change the Menu Icon Color: #<input onclick=" window.jscolor(this);" style="cursor:pointer;background:#'.$this->editor_background.';color:#'.$this->editor_color.';" type="text" name="'.$data.'_'.$nav_name_ref.'['.$nav_icon_color_index.']." id="'.$this->blog_table.'_'.$this->blog_order.'iconcolor" value="'.$nav_icon_color.'" size="6" maxlength="6" class="jscolor {refine:false}"><span style="font-size: 1.1em; color:#'.Cfg::Info_color.';" id="'.$this->blog_table.'_'.$this->blog_order.'iconcolorinstruct"></span></p>');
      $this->show_more('Style info','','info italic smaller');
     printer::print_wrap1('techinfo');
     $msg='Info: Styles the post bar elements color: .'.$this->dataCss.' .bar1,.'.$this->dataCss.' .bar2,.'.$this->dataCss.' .bar3{ 
  background-color: #'.$nav_icon_color.';
  }; ';
     printer::print_info($msg);
     printer::close_print_wrap1('techinfo');
     $this->show_close('Style info');
     printer::pclear();
     echo '</div><!--link color-->';
     printer::pclear(5);
     echo '<div class="fsminfo editbackground editfont '.$this->column_lev_color.' floatleft"><!--Icon Float-->';
     printer::print_tip('<span style="font-weight:700; color:orange;">Custom Positioning of Menu Icon Position Info </span><br> On viewer screen widths less than that set above for the -Responsive View Port Width Minimum for Menu Icon Respresentation- it will appear in its static position by default. However, by using the post options above for positioning you can position it using absolute relative or fixed positioning instead and set a left or right and top or bottom px or % placement for the menu icon wherever you want. <em> The RWD max-width value for positioning and for menu-icon appearance should be synced</em>');
     echo '</div><!-- Icon Float-->';
     printer::pclear(5);
     ###############
     echo '<div class="fsminfo editbackground editfont '.$this->column_lev_color.' floatleft"><!--nav animate-->';
     echo '<p class="info left">Click Menu Icon Nav Animate</p>';
     $checked1=($nav_animate==='fadeInRight')?'checked="checked"':'';
     $checked2=($nav_animate==='fadeInLeft')?'checked="checked"':'';
     $checked3=($nav_animate!=='fadeInRight'&&$nav_animate!=='fadeInLeft')?'checked="checked"':'';
     
     echo '<p><input type="radio" value="noanimate" name="'.$data.'_'.$nav_name_ref.'['.$nav_animate_index.']." '.$checked3.'>Animate Height Open Only (keeps icon stationary)</p>'; 
     echo '<p><input type="radio" value="fadeInRight" name="'.$data.'_'.$nav_name_ref.'['.$nav_animate_index.']." '.$checked1.'>Animate Right Slide-In Open (open icon position may shift)</p>';
     echo '<p><input type="radio" value="fadeInLeft" name="'.$data.'_'.$nav_name_ref.'['.$nav_animate_index.']." '.$checked2.'>Animate Left Slide-In Open (open icon position may shift)</p>';
     $this->show_more('Style info','','info italic smaller');
     printer::print_wrap1('techinfo');
     $msg= 'Css for all nav animation: <br>
     .nav_gen ul.top-level.menuRespond {
	-webkit-transition: max-height 2s ease;
	-moz-transition: max-height 2s ease;
	-o-transition: max-height 2s ease;
	transition: max-height 2s ease;
	max-height: 2000px;
}';
     if ($nav_animate==='fadeInLeft'||$nav_animate==='fadeInRight'){
          $msg.='Animation Css for left and right: 
   .'.$this->dataCss.' .nav_gen UL.top-level.menuRespond{
	animation-duration: 1s;
	-webkit-animation-duration: 1s;
	-moz-animation-duration: 1s;
	animation-iteration-count: 1;
	-webkit-animation-iteration-count: 1;
	-moz-animation-iteration-count: 1;
	-webkit-animation-delay: 0s;
	-moz-animation-delay: 0s;
	animation-delay: 0s;
	visibility: visible;
   }
   ';
     }
   if ($nav_animate==='fadeInLeft'){
     $msg.='
   .'.$this->dataCss.' .nav_gen UL.top-level.menuRespond{
   -webkit-animation-name: fadeInLeft;
	animation-name: fadeInLeft;
   }
   ';
     }
   if ($nav_animate==='fadeInRight'){
     $msg.='
   .'.$this->dataCss.' .nav_gen UL.top-level.menuRespond{
   -webkit-animation-name: fadeInRight;
	animation-name: fadeInRight;
   }
   ';
     }
     printer::print_info($msg);
     printer::close_print_wrap1('techinfo');
     $this->show_close('Style info');
     echo '</div><!-- nav animate-->';
     ######
     echo '<div class="fsminfo editbackground editfont '.$this->column_lev_color.' floatleft"><!--Respond Vertical-->';
     echo '<p class="highlight left">Choose whether Horizontal Menus Will Appear without row sharing ie. Vertically when <b>Menu Icon is clicked</b> or share Row Space as Space Permits centered or floated left</p>';
     $checked1=($icon_vertical_choice==='Center Float')?'checked="checked"':'';
     $checked2=($icon_vertical_choice==='Float Left')?'checked="checked"':'';
     $checked3=($icon_vertical_choice!=='Float Left'&&$icon_vertical_choice!=='Center Float')?'checked="checked"':'';
     echo '<p><input type="radio" value="vertical only" name="'.$data.'_'.$nav_name_ref.'['.$nav_icon_vertical_response_index.']." '.$checked3.'>Vertical Only (Default Value @menu-icon widths) uses display block;</p>';
     echo '<p><input type="radio" value="Center Float" name="'.$data.'_'.$nav_name_ref.'['.$nav_icon_vertical_response_index.']." '.$checked1.'>Center Float (Uses display:inline-block;)</p>';
     echo '<p><input type="radio" value="Float Left" name="'.$data.'_'.$nav_name_ref.'['.$nav_icon_vertical_response_index.']." '.$checked2.'>Float Left (Uses float:left;)</p>';
     $icon_vertical_choice=($icon_vertical_choice==='Center Float')?'display:inline-block;':(($icon_vertical_choice==='Float Left')?'display:block;float:left;':'display:block!important;float:none;');
     $this->show_more('Style info','','info italic smaller');
     printer::print_wrap1('techinfo');
     printer::print_info('Current setting Css: .'.$this->dataCss.' .nav_gen ul.top-level.menuRespond li{
  '.$icon_vertical_choice.'
 }');
     $msg='Info: Sets the float of the li element to display:block or display:inline or float:left when menu icon is clicked open.'; 
     printer::print_info($msg);
     printer::close_print_wrap1('techinfo');
     $this->show_close('Style info');
     echo '</div><!-- Respond Vertical-->'; 
     printer::pclear(5);
     $this->submit_button(); 
     printer::close_print_wrap('rwd menu icon');
     $this->show_close('Style/Enable/Customize @ Menu Icon Width'); 
     echo'<p class="button'.$this->column_lev_color.' '.$this->column_lev_color.' editbackground editfont editcolor floatleft underline shadowoff"> <a class="linkcolorinherit" href="navigation_edit_page.php?table_ref='.$this->pagename.'&amp;data='.$data.'&amp;style='.'ID-'.$dir_menu_id.'-'.$datainc.'&amp;menuid='.$dir_menu_id.'&amp;postreturn='.Sys::Self.'&amp;pgtbn='.$this->pagename.'&amp;css='.$this->roots.Cfg::Style_dir.$this->pagename.'">Add Remove &amp; Edit Links for this Menu</a></p>';
		printer::pclear();
   $pb=(!is_numeric($this->{$data.'_blog_data4_arrayed'}[$this->padding_bottom_index]))?0:$this->{$data.'_blog_data4_arrayed'}[$this->padding_bottom_index];
	$pt=(!is_numeric($this->{$data.'_blog_data4_arrayed'}[$this->padding_top_index]))?0:$this->{$data.'_blog_data4_arrayed'}[$this->padding_top_index];
	$ptot=$pb+$pt;
	$bp_arr=$this->page_break_arr;
	#blog_tiny_data3 display or horiz handled in the # maindiv specific for nav
	$this->navcss.='
     '.$nav_submenu_display.$nav_openicon_submenu_display.'
     ';
	$max=count($bp_arr);
   #navcss 
   $respond_menu_dimension=($respond_menu_dimension==='icon full on')?5000:$respond_menu_dimension;//always show
   if ($nav_animate==='fadeInLeft'||$nav_animate==='fadeInRight'){
     $this->navcss.='
   .'.$this->dataCss.' .nav_gen UL.top-level.menuRespond{
	animation-duration: 1s;
	-webkit-animation-duration: 1s;
	-moz-animation-duration: 1s;
	animation-iteration-count: 1;
	-webkit-animation-iteration-count: 1;
	-moz-animation-iteration-count: 1;
	-webkit-animation-delay: 0s;
	-moz-animation-delay: 0s;
	animation-delay: 0s;
	visibility: visible;
   }
   ';
     }
   if ($nav_animate==='fadeInLeft'){
     $this->navcss.='
   .'.$this->dataCss.' .nav_gen UL.top-level.menuRespond{
   -webkit-animation-name: fadeInLeft;
	animation-name: fadeInLeft;
   }
   ';
     }
   if ($nav_animate==='fadeInRight'){
     $this->navcss.='
   .'.$this->dataCss.' .nav_gen UL.top-level.menuRespond{
   -webkit-animation-name: fadeInRight;
	animation-name: fadeInRight;
   }
   ';
     }
   
   $this->navcss.= '
.bar1, .bar2, .bar3 {
  width: 1em;
  height: .1em;
  margin: .15em 0;
  -webkit-border-radius: .1em .1em .1em .1em;
	border-radius: .1em .1em .1em .1em; 
  transition: 0.4s;
   }
.'.$this->dataCss.' .show_icon{
   font-size: '.($icon_width*16).'px;
   }
.'.$this->dataCss.' .ulTop.menuRespond2 li.show_icon{
   border:none; padding:0; margin:0; box-shadow:none;background:none;
   }
.'.$this->dataCss.' .bar1,.'.$this->dataCss.' .bar2,.'.$this->dataCss.' .bar3{ 
  background-color: #'.$nav_icon_color.';
  }
.menuRespond .bar1 {
  -webkit-transform: rotate(-45deg) translate(-.075, .3em);
  transform: rotate(-45deg) translate(-.075em, .3em);
   }
.menuRespond .bar2 {opacity: 0;}
.menuRespond .bar3 {
  -webkit-transform: rotate(45deg) translate(-.043em, -.3em);
  transform: rotate(45deg) translate(-.043em, -.3em);
   } 

.'.$this->dataCss.' .nav_gen UL UL A { '.$nav_sub_link_width.'height:auto; }
.'.$this->dataCss.' .nav_gen ul.top-level:NOT(.menuRespond):NOT(.transitionEase) li:NOT(.show_icon){
  '.$nav_link_vertical_choice.'
     }
 @media screen and (max-width:'.$respond_menu_dimension.'px) {
 .'.$this->dataCss.' .nav_gen ul.top-level li,{display: none;}
  .'.$this->dataCss.' .nav_gen ul.top-level li.show_icon{
  position:absolute;
  top:0;
  display: inline-block;
  background:none;
   }
.'.$this->dataCss.' .show_arrow {display:none;}
.'.$this->dataCss.'.hover .nav_gen UL LI {display: block; vertical-align: top; position:static; VISIBILITY: visible } 
.'.$this->dataCss.'.hover .nav_gen UL UL {display: block; vertical-align: top; position:static; VISIBILITY: visible } 
.'.$this->dataCss.' .nav_gen ul.sub-level, .nav_gen UL UL LI {display:block;}
'.$final_nav_open_icon_total_menu_width.$final_nav_icon_horiz_pos.$final_nav_icon_total_menu_width.'
   }
@media screen and (max-width:'.$respond_menu_dimension.'px) {
 .'.$this->dataCss.' .nav_gen{display:block;}
 .'.$this->dataCss.' {padding:0px}
.nav_gen ul.top-level {
max-height:0; 
overflow:hidden;
-webkit-transition: max-height 1s ease-in;
-moz-transition: max-height 1s ease-in;
 -o-transition: max-height 1s ease-in;
 transition: max-height 1s ease-in;
	}
   
 
.nav_gen ul.top-level.transitionEase li:NOT("show_icon"){
     opacity:0;'.$icon_vertical_choice.'
}
.nav_gen ul.top-level.transitionEase {
 max-height:0;
 overflow:hidden;
 -webkit-transition: opacity .1s ease;
-moz-transition: opacity .1s ease;
 -o-transition: opacity .1s ease;
 transition: opacity .1s ease; 
-webkit-transition: max-height .5s ease;
-moz-transition: max-height .5s ease;
 -o-transition: max-height .5s ease;
 transition: max-height .5s ease; 
		}	
 .'.$this->dataCss.' .nav_gen ul.top-level.menuRespond li{
  '.$icon_vertical_choice.'
     }
 '.$final_open_icon_position_vert.$final_open_icon_position_horiz.$final_open_icon_only_position_vert.$final_open_icon_only_position_horiz.'
} 
'; //end mediaquery for @media max-width menu icon 
	(Sys::Deltatime)&&$this->deltatime->delta_log('End of '.__LINE__.' @ '.__method__.' ');
   ($this->edit&&$this->overlapbutton)&&$this->overlapbutton();
   }// end nav menu function
 	
#text
function text_render($data,$pagename='',$style_list='',$columns=20,$style_open=true){
	static $myinc=0; $myinc++;
	$cols=(!empty($this->current_net_width))?process_data::width_to_col($this->current_net_width,$this->current_font_px):$columns; 
	$display_editor=($this->blog_options[$this->blog_editor_use_index]==='use_editor')?'enableTiny ':'divTextArea';
	$rowlength=($cols<3)?3:process_data::row_length($this->blog_text,$cols); 
	$this->edit_styles_open();
   ($this->edit)&&  
			$this->blog_options($data,$this->blog_table);
	 if (!empty($this->blog_text)){
		if (!$this->edit){
			echo process_data::clean_break($this->blog_text);
			 return;
			}
		elseif($this->is_clone&&!$this->clone_local_data)echo process_data::clean_break($this->blog_text);
		} 
	if ($this->edit&&(!$this->is_clone||$this->clone_local_data)){ 
		$print=($this->blog_options[$this->blog_editor_use_index]==='use_editor')?'':
		'<div class="'.$this->column_lev_color.' floatleft cursor smallest editbackground editfont shadowoff rad3 button'.$this->column_lev_color.'" onclick="edit_Proc.enableTiny(this,\''.$data.'_blog_text\',\'divTextArea\');">Use TinyMce</div>';
		echo $print;
		printer::pclear(7); 
		$this->blog_text=(strlen($this->blog_text)<2)?'<br>Enter text here':$this->blog_text;
		echo'<div id="'.$data.'_blog_text" class="'.$display_editor.' 
   min100 cursor" >'.process_data::clean_break($this->blog_text).'</div>';// show initial non text area non editor text !
		$blog_text=($this->blog_options[$this->blog_editor_use_index]==='use_editor')?process_data::textarea_validate($this->blog_text):process_data::textarea_validate(process_data::remove_html_break($this->blog_text));
		echo ' 
		 <textarea style="background:inherit;text-shadow:inherit; display: none; width:100%" id="'.$data.'_blog_text_textarea"  class="scrollit '.$this->dataCss.'" name="'.$data.'_blog_text" rows="'.$rowlength.'" cols="'.$cols.'" onkeyup="gen_Proc.autoGrowFieldScroll(this);">' .$blog_text.'</textarea>';
		}//if edit
		#ok here if marked as global the results of these styles choices will directly style this blog type but also the parent column.text.. as shown...
	$type=$this->blog_type;
	$global_field=($this->blog_global_style==='global')?',.'.$this->col_dataCss.' > .'.$type.',.'.$this->col_dataCss.' >fieldset>.'.$type:'';
	$globalmsg=($this->blog_global_style==='global')?' Global Style':'';
	$this->edit_styles_close($data,'blog_style','.'.$this->dataCss.'.post.'.$type.$global_field, $style_list ,$this->styler_blog_instructions. 'Post#'.$this->blog_order_mod.' Col#'.$this->column_order_array[$this->column_level].$globalmsg,''); 
   ($this->edit&&$this->overlapbutton)&&$this->overlapbutton();
   }//end text_render function
   
}//end class
?>