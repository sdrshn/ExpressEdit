<?php
#ExpressEdit 3.01
/*
ExpressEdit is an integrated Theme Creation CMS
	Copyright (c) 2018   expressedit.org
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

#note: display property and advanced styles use css #id to override normal styles which use distinct classnames    
#info
#width# find #width# for various width info
#style# find overview of style mechanism info
#flatfile# flatfile info for main system
#blogrender# function blog_render is the central method of the system
#for reasons of size and content grouping the main class was broken up to four classes...
#the extended main class is broken into 4 classes with each  limited to under ~7000 lines for quick editing in komodo edit 8.5 ::  global_master  extends global_edit_master  extends global_post_master extends global_process_master
class global_style_master extends global_post_master{
	static protected  $xyz=1;
	
function left($style, $val, $field){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	$this->spacing($style,$val,'left','left positioning','Adjust Position of absolute or relative positioned element/post/column','','','',$field);
     }
function right($style, $val, $field){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	$this->abs_spacing($style,$val,'right','Right Spacing','Position from Right Relative Absolute positioned elements');
	}
function top($style, $val, $field){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	$this->abs_spacing($style,$val,'top','Top Spacing','Position from Top Relative Absolute positioned elements. ');
	}
function bottom($style, $val, $field){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	$this->abs_spacing($style,$val,'bottom','Bottom Spacing','Position from Bottom Relative Absolute positioned elements');
	}
	
function abs_spacing($style,$val,$css_class,$msg,$title){
	$maxspace=500;
	$size=(is_numeric($this->{$style}[$val])&&$this->{$style}[$val]<=$maxspace&&$this->{$style}[$val]>=0)?$this->{$style}[$val]:'None'; 
		#all values will be store as px
	$sizepx=($size !=='None')?$this->{$style}[$val].'px':$size;
	echo '
	    <div class="floatleft editbackground editfont editcolor editfont fs1color  left"> <span class="highlight" title="'.$title.'" >'.$msg.'</span>: Currently '.$sizepx
	    .'<br>';
		$unit1='px';
		$msgjava='Choose px Spacing:'; 
		$factor=1;
		$unit2='';  
		$this->mod_spacing($style.'['.$val.']',$size,0,$maxspace,1,'%','none',$msgjava);   
	echo'  </div>';
	printer::pclear(1); 
	$final=$sizepx.';';
	$fstyle='final_'.$style; 
     $this->{$fstyle}[$val]=($sizepx==='None')?'':$css_class.':'.$final;
    }//end functio
    
function font_size($style,$val,$field,$directcss=false){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	//$font_arr=array('font1
     $font_arr=explode('@@',$this->{$style}[$val]);
     for ($i=0; $i <4; $i++){
          if (!array_key_exists($i,$font_arr)){
               $font_arr[$i]=0;
               }
          }
     $px='px';
     $fontsize1=(!empty($font_arr[0])&&is_numeric($font_arr[0])&&$font_arr[0]<=100&&$font_arr[0]>=1)?$font_arr[0]:0; 
     $msg= (empty($fontsize1))? 'none ': $fontsize1;  
     $fontsize2=(!empty($font_arr[2])&&is_numeric($font_arr[2])&&$font_arr[2]>0&&$font_arr[2]<=10)?$font_arr[2]:0;
     $msg2= (empty($fontsize2))? 'none ': $fontsize2;  
     $scaleunit=(!empty($font_arr[1])&&$font_arr[1]==='em'||$font_arr[1]==='rem')?$font_arr[1]:'none'; 
     if ($field==='return_val'){
          if (!empty($fontsize1)){
               $msgscale=$this->rwd_scale($this->{$style}[$val],'return_val',"",'font-size','font size px','px',0,7,true,1);
               if (!empty($msgscale)){
                    return "$fontsize1$px $msgscale";
                    }
               elseif (empty($fontsize2)||$scaleunit==='none')
                    return "$fontsize1$px";
               }
          elseif(!empty($fontsize2)&&$scaleunit!=='none'){
               return "$fontsize2$scaleunit";
               }
          return;
          }
     
     echo '
     <div class="fsminfo '.$style.'_hidefont" style="display:none;"><!-- font-->';
     $this->show_more('Font-Size','',' highlight editbackground editfontfamily','In columns and posts, body font-size may be used to setup em units with or without scaling effect');
     $this->print_wrap('Font-Size Choices','','highlight editbackground editfontfamily','Choose px or scalable font sizes');
	$this->show_more('Use font px units &amp; scaling px units');
     printer::print_wrap('font px');
     echo'<p class="'.$this->column_lev_color.' clear editbackground editfont">Font Size: Currently '.$msg.'px<br>';
     $msgjava='Choose font-size:'; 
     $this->mod_spacing($style.'['.$val.'][0] ',$fontsize1,0,100,1,'px','none',$msgjava); 
     printer::print_tip('Optionally choose to Scale px font-size or choose alt units below ie. rem, em');
     $msgscale=$this->rwd_scale($this->{$style}[$val],$style.'['.$val.']',"$this->pelement",'font-size','font size px','px',0,7,true,1);
     printer::close_print_wrap('font px');
     $this->show_close('Use font px units ');
     if (!empty($msgscale))printer::print_notice($msgscale);
     $final='';
     if (!empty($fontsize2)&&$scaleunit!=='none'){
          if ($scaleunit==='rem'){
               $value=$this->rem_root*$fontsize2;
               $scale=($this->rem_scale)?'on':'off';
               }
          else { 
               $scale=($this->terminal_em_scale)?'on':'off';
               $value=$this->terminal_font_em_px; 
               $final="<br>giving value of 1em unit = {$this->terminal_font_em_px}px for padding/margins/widths/etc. in this post/col";
               }
          (!empty($fontsize2)&&strpos($fontsize2,'0.00')===false)&&printer::print_notice("Current Alt font-size  $fontsize2$scaleunit = {$value}px with scaling $scale");
          }
	$style1=(!empty($fontsize1))?'font-size:'.$fontsize1.'px;':'';
	$style2=(is_numeric($fontsize2)&&$fontsize2<=10&&$scaleunit!=='none')?'font-size:'.$fontsize2.$scaleunit.';':''; 
	
     
     
		if ($this->is_page&&$directcss!==false){//use html body to give greater priority
			$this->pagecss.="
     $directcss".'{'.$style1.$style2.'}';

			}
		elseif ($directcss!==false){
               $this->css.="
	$directcss".'{'.$style1.$style2.'}
	';
			}
		
	printer::pclear();
	$this->show_more('Use other font-size units');
	$this->print_redwrap('other fontsize units');
     printer::print_notice("Equivalent of 1em for font-size: {$this->current_font_em_px}px $final"); 
     ($this->is_page)&&printer::print_warn('Using em for the default page level font-size (body) multiplies with the html level font-size of '.$this->rem_root.'px including scaling if initiated for rem units.');
      $more='';/*(!$this->is_page&&(!$this->col_primary||$this->is_blog))?'
4. Choose VW units.':'';*/
	printer::print_tip('AND/OR Choose a scalable font-size unit here.  <b>You can enable scaling for rem (appropriately between the upper and lower viewport size of your choice) in the page options under page options and spacing &amp; other values using rem will scale according to the settings you make there.
<br>
</b>There are different units available to enable font scaling ie font size relative to the viewport size:<br>
1. Choose px value then enable rwd scaling in the options below. Be sure not to choose a rem or em value for this option or px values including scaling will be overriden<br>
2. Use REM units with px scaling enabled in the page default settings option.<br>
3. Use Em units here with font-size px scaling enabled in a parent column or in the body. ie: Em units are directly proportional to the current active inherited font-size.<br>'.$more);
     printer::print_tip('Choose value and unit type.');
     $checked=' checked="checked" ';
     $checked1=($scaleunit==='none')?$checked:'';
     $checked2=($scaleunit==='em')?$checked:'';
     $checked3=($scaleunit==='rem')?$checked:'';  
     printer::alert('Choose scale unit:');
     printer::alert('<input type="radio" name="'.$style.'['.$val.'][1]" value="none" '.$checked1.'>None');
     printer::alert('<input type="radio" name="'.$style.'['.$val.'][1]" value="em" '.$checked2.'>em units');
     printer::alert('<input type="radio" name="'.$style.'['.$val.'][1]" value="rem" '.$checked3.'>rem units'); 
     printer::pclear(5);
     echo'<p class="'.$this->column_lev_color.' editbackground editfont">Alt. Unit Font Size: Currently '.$msg2.'<br>';
     $msgjava='Choose Alt. font-size:'; 
     $this->mod_spacing($style.'['.$val.'][2] ',$fontsize2,0,10,.01,'units','none',$msgjava); 
	$this->submit_button();  
	printer::close_print_wrap('other fontsize units');  
	$this->show_close('Use other font-size units');  
          printer::close_print_wrap('Font-Size Choices'); 
          $this->show_close('Font-Size Choices'); 
	echo'
	    </div><!-- font-->'; 
     if (!$directcss){   
          $fstyle='final_'.$style;
          if (!empty($style1)||!empty($style2))
               $this->{$fstyle}[$val]=$style1.$style2; 
               //if ($this->is_page&&empty($style1)&&empty($style2))
                  //  $this->{$fstyle}[$val]='font-size:16px';//insure value of default font size this will be for body not html..
              // if (!empty($style1)&&!empty($style2)){//give redundant specificity priority
              // $this->css.='
      //html '.$this->pelement.'{'.$style2.'}';
               //}
               /*
          if (!$this->is_blog&&!empty($style2)){
               $this->current_font_source=($this->is_page)?'body':'c'.$this->col_id;
               $this->current_font_size=$style2;
               }
          elseif(!$this->is_blog&&!empty($style1)){ 
               $this->current_font_source=($this->is_page)?'body':'c'.$this->col_id; 
               $this->current_font_size=$style1;
               }
               */
          
          } 
    
     }   
	
function width_special($style,$val,$field,$directcss=false,$norendercss=false){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__); 
     $width= ($norendercss)?'none':'width';//if true no css 
	$this->spacing($style,$val,$width,'Width','Straight forward Width option will not override a max-width or min-width property','','',false, $field,$directcss,0,'',array('auto'=>'width:auto;'));
     }
  
function width_max_special($style,$val,$field,$directcss=false,$norendercss=false){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__); 
     $width= ($norendercss)?'none':'max-width';//if true no css
	$this->spacing($style,$val,$width,'Max Width','Max-Width sets a maximum width that can override width','','',false, $field,$directcss,0,'',array('none'=>'max-width:none;')); 
     }
 
function width_min_special($style,$val,$field,$directcss=false,$norendercss=false){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
     $width= ($norendercss)?'none':'min-width';//if true no css
     $this->spacing($style,$val,$width,'Min-Width','Note: Media Query removing Minimum Width is automatically generated at viewports at or below the min-width value set! Minimum Width sets a minimum width that can override width','','',false, $field,$directcss,0,'',array('none'=>'min-width:none;'));
     }
     
function height_special($style,$val,$field,$directcss=false,$start=0){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	$return=$this->spacing($style,$val,'height','Height','Straight forward Height option will not override  a max-height or min-height property','','',false, $field,$directcss,$start,'',array('auto'=>'height:auto;'));
     return $return;
     }

  
function height_max_special($style,$val,$field,$directcss=false,$start=0){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	$return=$this->spacing($style,$val,'max-height','Max Height','Max-Height sets a maximum height and overrides height property','','',false, $field,$directcss,$start,'',array('none'=>'max-height:none;'));
     return $return;
     }

 
function height_min_special($style,$val,$field,$directcss=false,$start=0){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
     $return=$this->spacing($style,$val,'min-height','Min-Height','Minimum Height sets a minimum height and overrides height property','','',false, '',$directcss,$start,'',array('none'=>'min-height:none;'));
     return $return;
     }

function media_styler($style,$val,$mode='nodisplay'){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
//here we display the media_styler settings options and close the media query tag if $mode = display chosen!  otherwise media query opened above by using array_unshift($function_order , 'media_styler'); 
	$mediaindexes=array('max','min','orientation','operator');
	$display=($mode==='display')?true:false;
	foreach($mediaindexes as $key =>$index){
		 ${$index.'_index'}=$key;
		} 
	if (empty($this->{$style}[$val])){ 
		$media_array=array();
		 for ($i=0; $i<count($mediaindexes);$i++){ 
			$media_array[$i]=0;
			}
		}
	else	{   
		$media_array=explode('@@',$this->{$style}[$val]);
		for ($i=0; $i<count($mediaindexes);$i++){ 
			if (!array_key_exists($i,$media_array)){
				$media_array[$i]=0;
				}
			 }
		}
	if ($display){
		$max_name=$style.'['.$val.']['.$max_index.']';
		$min_name=$style.'['.$val.']['.$min_index.']';
		$orientation_name=$style.'['.$val.']['.$orientation_index.']';
		$operator_name=$style.'['.$val.']['.$operator_index.']';
		$mediaopen=$this->mediaAddCss($media_array,$max_index,$min_index,$orientation_index,$operator_index,$max_name,$min_name,$orientation_name,$operator_name);
		}
	else {//we open the @media tag if mediaopen not empty...
		$mediaopen=$this->mediaAddCss($media_array,$max_index,$min_index,$orientation_index,$operator_index,'','','','',false);
		}
	if ($display){
		$fstyle='final_'.$style;
		if (!empty($mediaopen)){
			$this->{$fstyle}[$val]=array('mediastyler',$mediaopen);//this will pass into css_generate
			$this->css.='
			}'; //close media query
			}
		}
	elseif (!empty($mediaopen)) {//open media query for styles that bypass css_generate
		$this->css.=$mediaopen.'{
	';
		}
	}  //end media_styler
	              
function mediaAddCss($media_array,$max_index,$min_index,$orientation_index,$operator_index,$max_name='',$min_name='',$orientation_name='',$operator_name='',$display=true,$show=false,$lineheight=false){
	$media_maxpx=($media_array[$max_index]>=200&&$media_array[$max_index]<=3000)?$media_array[$max_index]:'none';
     $media_minpx=($media_array[$min_index]>=200&&$media_array[$min_index]<=3000)?$media_array[$min_index]:'none'; 
     $media_orientation=($media_array[$orientation_index]==='portrait'||$media_array[$orientation_index]==='landscape')?$media_array[$orientation_index]:'none'; 
	$media_operator=($media_array[$operator_index]==='or_operator')?', ':'and '; 
     $maxpx=($media_maxpx==='none')?'':$media_maxpx;
	$minpx=($media_minpx==='none')?'':$media_minpx;
	 if (!empty($maxpx)&&!empty($minpx)) {
		$mediaopen='
@media screen and (max-width:'.$maxpx.'px) and (min-width:'.$minpx.'px) ';
		}
     elseif (!empty($maxpx)){
          $mediaopen='
@media screen and (max-width: '.$maxpx.'px) ';
          }
     elseif (!empty($minpx)) {
		$mediaopen='
@media screen and (min-width: '.$minpx.'px) ';
          }
     else  
          $mediaopen='';
		
	$media_orientation=($media_orientation!=='landscape'&&$media_orientation!=='portrait')?'':$media_orientation;
	if (!empty($media_orientation)&&!empty($mediaopen))$mediaopen.=$media_operator.'(orientation: '.$media_orientation.')';
	elseif (!empty($media_orientation))$mediaopen='@media screen and (orientation: '.$media_orientation.')';
	if (!$display)return $mediaopen;
	$line=($lineheight)?'line300':'';
	$this->show_more('Add @media max/min-width &amp; orientation','',$line.' highlight editbackground editfont highlight editstyle','Adding a @media Query will affect all values of this style grouping above except advanced styles');
	printer::print_wrap('wrap @media all');
	printer::print_info('The following media queries will not effect special effects such as animations and the advanced style options which have their own media query controls');
	printer::print_info('Optionally add @media max-width/min-width/device orientation to control the enabling of this style grouping.');
	if($show)$this->show_more('Optionally Add @media max-width','','highlight editbackground editfont highlight editstyle','Adding a @media max-width will affect all values of this style grouping above except advanced styles');
	printer::print_wrap('wrap @mediamax');
	$this->submit_button();
	printer::print_info('Optionally choose a max-width here or min-width below or both at which all the above grouping of custom styles will be expressed. (Except the advanced style option which has individual @media options for each css directive)');  
	echo '<div class="fsminfo"><!--wrap max width-->';
	printer::printx('<p class="smaller '.$this->column_lev_color.'">Chosen max-width: <span class="navybackground white">'.$media_maxpx.'</span><br></p>');   
	printer::alert('Choose @media screen max-width px');
	$this->mod_spacing($max_name,$media_maxpx,200,3000,1,'px','none');  
	printer::printx('<p ><input type="checkbox" name="'.$max_name.'" value="0">Remove max-width</p>');
	echo '</div><!--wrap max width-->';
	printer::close_print_wrap('wrap @mediamax');
	if($show)$this->show_close('Optionally Add @media max-width');
	if($show)$this->show_more('Optionally Add @media min-width','','highlight editbackground editfont highlight editstyle','Adding a @media min-width will affect all values of this style grouping above except advanced styles');
	printer::print_wrap('wrap @mediamin');
	printer::print_info('Optionally add in a min-width here at which all the above grouping of custom styles will be expressed.');  
	echo '<div class="fsminfo"><!--wrap min width-->';
	printer::printx('<p class="smaller '.$this->column_lev_color.'">Chosen min-width: <span class="navybackground white">'.$media_minpx.'</span></p>');
	 printer::alert('Choose @media screen min-width px'); 
	$this->mod_spacing($min_name,$media_minpx,200,3000,1,'px','none');
	printer::printx('<p ><input type="checkbox" name="'.$min_name.'" value="0">Remove min-width</p>');
	echo '</div><!--wrap media width-->';
	printer::close_print_wrap('wrap @mediamin');
	if($show)$this->show_close('Optionally Add @media min-width'); 
	
	if($show)$this->show_more('Optionally Add @media device orientation','','highlight editbackground editfont highlight editstyle','Adding a @media orientation will affect all values of this style grouping above except advanced styles');
	printer::print_wrap('wrap orientation');
	printer::print_info('Optionally choose a device orientation here at which all the above grouping of custom styles will be expressed. (Except the advanced style option which has individual @media options for each css directive)'); 
	echo '<div class="fsminfo"><!--wrap orientation-->';
	$checked1=$checked2=$checked3='';
	$checked1=($media_orientation==='portrait')?'checked="checked"':'';
	$checked2=($media_orientation==='landscape')?'checked="checked"':'';
	$checked3=($media_orientation!=='landscape'&&$media_orientation!=='portrait')?'checked="checked"':''; 
	printer::printx('<p ><input type="radio" name="'.$orientation_name.'" value="portrait" '.$checked1.'>Portrait</p>');
	printer::printx('<p ><input type="radio" name="'.$orientation_name.'" value="landscape" '.$checked2.'>Landscape</p>');
	printer::printx('<p ><input type="radio" name="'.$orientation_name.'" value="none" '.$checked3.'>Orientation Off</p>');
	echo '</div><!--wrap orientation-->';
	echo '<div class="fsminfo"><!--wrap operator-->';
	$checked1=$checked2=$checked3=''; 
	$checked1=($media_operator===', ')?'checked="checked"':'';
	$checked2=($media_operator!==', ')?'checked="checked"':'';
	printer::alert('If Choosing both @media orientation and @media width further choose to require both or either one. Choose here:'); 
	printer::printx('<p ><input type="radio" name="'.$operator_name.'" value="or_operator" '.$checked1.'>Either a width or orientation chosen</p>');
	printer::printx('<p ><input type="radio" name="'.$operator_name.'" value="and_operator" '.$checked2.'>Require both if both chosen. </p>');
	echo '</div><!--wrap operator-->';
	printer::close_print_wrap('wrap @ orientation');
	if($show)$this->show_close('Optionally Add @media orientation');
	$this->submit_button();
	printer::close_print_wrap('wrap @media all');
	$this->show_close('Add @media max/min/Orient');
	return $mediaopen;
	}
	
	
function media_max_width($style,$val){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	$this->show_more('Optionally Add @media max-width','','highlight editbackground editfont highlight editstyle','Adding a @media max-width will affect all values of this style grouping above except advanced styles');
     $media_maxpx=($this->{$style}[$val]>=200&&$this->{$style}[$val]<=3000)?$this->{$style}[$val]:'none';
     $max_name=$style.'['.$val.']';
     printer::print_wrap('wrap @mediamax');
     $this->submit_button();
     printer::print_info('This media query will not effect special style settings for width_media_unit or flex item, flex container, and  the advanced style options which have their own media query controls');
     printer::print_info('Optionally choose a max-width here or min-width below or both at which all the above grouping of custom styles will be expressed. (Except the advanced style option which has individual @media options for each css directive)');  
     echo '<div class="fsminfo"><!--wrap max width-->';
     printer::printx('<p class="smaller '.$this->column_lev_color.'">Chosen max-width: <span class="navybackground white">'.$media_maxpx.'</span><br></p>');   
     printer::alert('Choose @media screen max-width px');
     $this->mod_spacing($max_name,$media_maxpx,200,3000,1,'px','none');  
     printer::printx('<p ><input type="checkbox" name="'.$max_name.'" value="0">Remove max-width</p>');
     echo '</div><!--wrap max width-->';
     printer::close_print_wrap('wrap @mediamax');
	$this->show_close('Optionally Add @media max-width');
	$fstyle='final_'.$style; 
     $this->{$fstyle}[$val]=($media_maxpx==='none')?'':array('mediamax',$media_maxpx);
     }
     
function media_min_width($style,$val){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	$media_minpx=($this->{$style}[$val]>=200&&$this->{$style}[$val]<=3000)?$this->{$style}[$val]:'none'; 
     $min_name=$style.'['.$val.']';
	$this->show_more('Optionally Add @media min-width','','highlight editbackground editfont highlight editstyle','Adding a @media min-width will affect all values of this style grouping above except advanced styles');
     printer::print_wrap('wrap @mediamin');
     $this->submit_button();
     printer::print_info('This media query will not effect special style settings for width_rwd_percent or flex item, flex container, and  the advanced style options which have their own media query controls');
     printer::print_info('Optionally choose a min-width here or max-width below or both at which all the above grouping of custom styles will be expressed. (Except the advanced style option which has individual @media options for each css directive)');  
     echo '<div class="fsminfo"><!--wrap min width-->';
     printer::printx('<p class="smaller '.$this->column_lev_color.'">Chosen min-width: <span class="navybackground white">'.$media_minpx.'</span></p>');
      printer::alert('Choose @media screen min-width px'); 
     $this->mod_spacing($min_name,$media_minpx,200,3000,1,'px','none');
     printer::printx('<p ><input type="checkbox" name="'.$min_name.'" value="0">Remove min-width</p>');
     printer::close_print_wrap('wrap @mediamin');
	$this->show_close('Optionally Add @media min-width');
     echo '</div><!--wrap min width-->';
	$fstyle='final_'.$style; 
     $this->{$fstyle}[$val]=($media_minpx==='none')?'':array('mediamin',$media_minpx);
     }    
     
function width($style,$val){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	$this->show_more('Choose Values #1,#2 max-width Or percent');
	printer::print_wrap('main blog width');
     echo'  <div class="floatleft">'; 
	$maxspace=$this->column_net_width[$this->column_level];
	$wid=$this->{$style}[$val]=(!empty($this->{$style}[$val])&&is_numeric($this->{$style}[$val])&&$this->{$style}[$val]<=100)?$this->{$style}[$val]:'';
	$widval=(!empty($wid)&&$this->use_blog_main_width)?$wid:0;
	$percent =(empty($wid))?'':'&#40;'.(intval(ceil($wid*10)/10)).'%&#41;';
	$px=(empty($wid))?'None Chosen':(intval(ceil($wid*$this->column_net_width[$this->column_level]/10)/10)).'px';
 	(!$this->flex_enabled_twice)&&printer::alertx('<p class="highlight editbackground editfont" title="The Column Width less its margins and paddings sets the Upper Limit for Post Width. Optionally set a narrower Post Width if required (does not effect other posts in this Column). The total width Available for your actual content such as text or an images will be narrowed by values of padding and margin styles made in this post styles">Max Width Available: <span class="editcolor editbackground editfont">'.(intval(ceil($this->column_net_width[$this->column_level]*10)/10)).'px</span></p>');
	
     printer::print_notice('Choices for #1 and #2 main width choice.');
     if ($this->use_blog_main_width&&$this->flex_enabled_twice)
          printer::print_warn('Previous activation of Flex Box in column tree means that max-width chosen here is not longer accurate. Instead you can select mode 2 for percent or 2 for alt rwd grid percent choices below. Alternatively, you can  Use Alt width units to set a direct width or for flex-item use basis specific width is now recommended');
     elseif ($this->use_blog_main_width){
          printer::alertx('<p class="highlight editbackground editfont" title="The Post width + spacing, borders,etc. will take up  to 100% of the available parent column width if no limiting width value is chosen! Limit the width if required. Both the percentage available of the parent column width and the px value that your selection represents will be shown">This Post Amount Used: <span class="editcolor editbackground editfont">: '.$px.'   '.$percent.'</span></p>');
		}
     else
          printer::alertx('<p class="editcolor editbackground editfont" >Main Width Mode not used. px value of alt width units used  and percent of total available for this Post: <span class="editcolor editbackground editfont">: '.$px.'   '.$percent.'</span></p>'); 
	printer::alertx('<p class="editcolor editbackground editfont" ></p>');  
	printer::pclear();
	printer::print_tip('Choose width value percent/px and choose below that whether the width is expressed as max-width (default) or percent  <b>Or Alternatively, use the alt rwd percentages @mediawidths below which overwrites the main width setting if made.</b>');
		$msgjava='Set Custom Width:';
		$factor=($this->flex_enabled_twice)?1:$this->column_net_width[$this->column_level]/100;
          $unit2=($this->flex_enabled_twice)?'':'px';
          $this->mod_spacing($style.'['.$val.']',$widval,0,100,.05,'%','',$msgjava,$factor,$unit2);
     printer::print_info('Choosing a main width value overrides any choice made  from option under em, rem, %, vw, px & px scale opt for min-width, max-width, & width choices');
	$this->submit_button();		 
     echo '</div><!--width-->'; 
	printer::close_print_wrap('main blog width');
	$this->show_close('Values #1,#2 max-width, percent');
     }

function check_spacing($spacing_arr,$type){  
	if (empty($spacing_arr))return '';
	$spacing_arr=explode('@@',$spacing_arr);
	for ($i=0; $i<12; $i++){
		if (!array_key_exists($i,$spacing_arr)){
			$spacing_arr[$i]=0;
			}
		}
	$return='';
	$maxspace=($this->is_page)?4000:$this->column_total_width[0];//limit width
	$current_px=$spacing_arr[0];
	$current_px=(is_numeric($current_px)&&$current_px<=$maxspace&&$current_px>=1)?$current_px:0;
	if (!empty($current_px))   
		$return.='<br>The Alternative '.$type.' px unit choice <b>Is Chosen</b>'; 
	if (is_numeric($spacing_arr[2])&&$spacing_arr[2]<=100&&$spacing_arr[2]>=.05)$return.='<br>The Alternative Percent Units for '.$type.' <b>Is Chosen</b>.'; 
	if (is_numeric($spacing_arr[3])&&$spacing_arr[3]<=200&&$spacing_arr[3]>=.05)$return.='<br>The Alternative em Units for '.$type.' <b>Is Chosen</b>';   
	if (is_numeric($spacing_arr[4])&&$spacing_arr[4]<=200&&$spacing_arr[4]>=.05)$return.='<br>Alternative rem Units for '.$type.' <b>Is Chosen</b>';   
	if (is_numeric($spacing_arr[5])&&$spacing_arr[5]<=200&&$spacing_arr[5]>=.05)$return.='<br>Alternative vw Units for '.$type.' <b>Is Chosen</b>';
     if (!empty($return))$this->alt_width_enabled=true;//alt width unit alert
	return $return;
	}
	
function spacing($style,$val,$css_style,$msg,$title,$hide='',$ifempty='',$showpercent=false,$field='',$directcss=false,$start=0,$msg2='',$radio='',$pxmaxwidth='4000'){ if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__); 
#10-11 indexes  7 + 3
#field is not currently used here
	#show_percent true for mar/pad left/right
	#css style none means no css property chosen yet ie left vs. right top vs. bottom but number can be chosen!
	 
	$type=($this->is_page)?'page':(($this->is_column)?'column':'blog'); 
	$use_percent=false;
     $start=(is_numeric($start))?$start:0;  
	$spacing_arr=explode('@@',$this->{$style}[$val]);
	for ($i=0; $i<12+$start; $i++){
		if (!array_key_exists($i,$spacing_arr)||$spacing_arr[$i]==='00'||$spacing_arr[$i]==='0.0'||$spacing_arr[$i]==='0.00'){
			$spacing_arr[$i]=0;
			}
		}
	$maxspace=($this->is_page&&$showpercent)?$this->page_width:(($showpercent)?$this->column_total_width[$this->column_level]:4000);//limit width
     $maxspace=min($maxspace,$pxmaxwidth);
	$current_px=$spacing_arr[$start];//index key  of first value
	$current_px=(is_numeric($current_px)&&$current_px<=$maxspace&&$current_px>=0)?$current_px:0;  
	$current_percent=$spacing_arr[$start+2];
	$current_percent=(is_numeric($current_percent)&&$current_percent<=100&&$current_percent>=.05)?$current_percent:0;
	$current_em=$spacing_arr[$start+3];
	$current_em=(is_numeric($current_em)&&$current_em<=200&&$current_em>=.05)?$current_em:0; 
	$current_rem=$spacing_arr[$start+4];
	$current_rem=(is_numeric($current_rem)&&$current_rem<=200&&$current_rem>=.01)?$current_rem:0;  
	$current_vw=$spacing_arr[$start+5];
	$current_vw=(is_numeric($current_vw)&&$current_vw<=200&&$current_vw>=.02)?$current_vw:0; 
	$current_vh=$spacing_arr[$start+6];
	$current_vh=(is_numeric($current_vh)&&$current_vh<=200&&$current_vh>=.02)?$current_vh:0; 
		#all values will be store as px
		#percent will be calculated for overall post size using post width...
	$scaleunit=(!empty($spacing_arr[1])&&$spacing_arr[1]!=='%'&&$spacing_arr[1]!=='em'&&$spacing_arr[1]!=='rem'&&$spacing_arr[1]!=='vw'&&$spacing_arr[1]!=='vh')?'none':$spacing_arr[1];
	$pos_neg=($spacing_arr[$start+1]==='-')?'-':''; 
     //used for locally comparing this value to another then expressing the css ie not here.
     $returnval='';
  foreach (array('rem','em','percent','px','vw','vh') as $ext){ 
          if (!empty(${'current_'.$ext})){
               $empty=false;
               
               if ($ext==='rem'){
                     $returnval=$pos_neg.${'current_'.$ext}.'rem';
                     }
               elseif ($ext==='em'){
                    $returnval=$pos_neg.${'current_'.$ext}.'em';
                    }
               elseif ($ext==='percent'){
                    $returnval=$pos_neg.${'current_'.$ext}.'%';
                    }
               elseif ($ext==='vh'){
                    $returnval=$pos_neg.${'current_'.$ext}.'vh';
                    
                    }
               elseif ($ext==='vw'){
                    $returnval=$pos_neg.${'current_'.$ext}.'vw'; 
                    }
               elseif ($ext==='px'){
                    $returnval=$pos_neg.${'current_'.$ext}.'px';
                    $msgscale=$this->rwd_scale($this->{$style}[$val],'return_val',"",'font-size','font size px','px',0,7,true,1);
                    if (!empty($msgscale)){
                         $returnval.=$msgscale;
                         }
                    }
               break;
               }
          }
     if ($css_style==='display_style'){//used for parsing style values for displaying values...
          if (is_array($radio)){ 
               $overridevalue='';
               foreach ($radio as $value=>$rvar){ 
                    if($spacing_arr[$start]===$value){
                         $overridevalue=$rvar;
                         }
                    }
               if (!empty($overridevalue))return 'Override: '.$overridevalue;
               }
          return $returnval;
          }
	($this->is_page)&&$showpercent=false;	 
	$sizepx=$current_px.'px'; 
	$percent=($showpercent&&is_numeric($this->{$style}[$val]))?(ceil($this->{$style}[$val]*100/$this->column_total_width[$this->column_level]*10)/10):''; 
	$current=($showpercent)?$sizepx.'  ('.$percent.'%)':$sizepx;
	$size=$sizepx; 
	$class=(!empty($hide))?$hide:'';
	$negmsg=($pos_neg==='-')?' &amp; chosen value expressed as negative value':''; 
	$this->show_more($msg,'',$class.' editbackground editfont italic info',$title);
	$this->print_redwrap('spacing funct wrap');
	(!empty($msg2))&& printer::print_info($msg2);	 
	echo '<div class="floatleft editbackground editfont editcolor editfont fs1color '.$class.' left"><!--funct spacing choose other units-->';
     printer::alertx('<p class="tip center">Choose units/value for '.$msg.'.<br><b>Last chosen will override other units.</b></p>');
	(!empty($title))&&printer::print_tip($title);
	if (strpos($css_style,'width')===false&&strpos($css_style,'height')===false){
          $this->show_more('Negative Value Option','','highlight click editbackground editfont smaller');
		$checked1=($pos_neg!=='-')?'checked="checked"':'';
		$checked2=($pos_neg!=='-')?'':'checked="checked"';
          printer::print_wrap('wrap neg');
		printer::alert_size('<input name="'.$style.'['.$val.']['.($start+1).']" '.$checked1.' type="radio"  value="">Use Positive Value',1);
		printer::alert_size('<input name="'.$style.'['.$val.']['.($start+1).']" type="radio" '.$checked2.' value="-">Set to Negative Value',1);
          printer::close_print_wrap('wrap neg');
          $this->show_close('Negative Val Option');
		} 
	printer::pclear(7);
	printer::print_wrap('wrap px choice');
     $pxpercent=(!$this->is_page&&$showpercent)?'&nbsp;&nbsp;('.$current_px*100/$this->current_total_width.'% Avail Parent Wid)':'';
	echo '<span class="highlight" title="'.$title.'" >px '.$msg.'</span>: Currently '.$sizepx.$negmsg.$pxpercent.'<br>';
     $this->show_more('Choose Px Units'); 
     $this->print_redwrap('px units'); 
	$unit1='px';
	$msgjava='Choose px '.$msg.':';
	$factor=(!$this->is_page)?100/$this->current_total_width:1;
	$unit2=(!$this->is_page&&$showpercent)?'%':'';  
	$this->mod_spacing($style.'['.$val.']['.$start.']',$current_px,0,$maxspace,1,$unit1,'',$msgjava,$factor,$unit2);
      printer::print_tip('Optionally create px viewport proportional units (uses media queries) or choose scalable units ie em,rem,% below');
     $pass_element=($directcss!==false&&!empty($directcss))?$directcss:$this->pelement;
	 if (strpos($css_style,'return')===false)$msgscale=$this->rwd_scale($pos_neg.$this->{$style}[$val],$style.'['.$val.']'," $pass_element",$css_style,$msg.' px','px',$start,7,true,1);
      else $msgscale='';
	$this->submit_button();
     printer::close_print_wrap('px units'); 
     $this->show_close('Choose Px Units');
	printer::close_print_wrap('wrap px choice'); 
     if (!empty($msgscale))printer::print_notice($msgscale);
	printer::pclear();
     $overridecss=false;#override css is passed on as checkable value ie none or auto..
     if (is_array($radio)){ 
          $overridecss=false;
          foreach ($radio as $value=>$rvar){
               if($spacing_arr[$start]===$value){
                    $overridecss=true;
                    printer::alertx('<p class="clear floatleft smallest whitebackground black fs1salmon">Active Override Css Value checked for: <b>'.$rvar.'</b></p>');
                    }
               }
          }
    	printer::print_wrap('funct spacing choose other units');
     #the following is for a current unit val msg including scaling info
     if (!$overridecss){ //checked value options expressing the css ie not here.
          $remscale=$emscale=$pxequiv=$scaleunit='';
          foreach (array('rem','em','percent','vw','vh') as $ext){ 
               if (!empty(${'current_'.$ext})){
                    $empty=false;
                    if ($ext==='rem'){
                         $remscale=($this->rem_scale)?'px scaling on':'px scaling off';
                         $pxequiv='&nbsp;&nbsp; = '.round($this->rem_root*${'current_'.$ext},1).$remscale;
                        // $pxequiv='&nbsp;&nbsp; = '.$this->rem_root.$remscale;
                          }
                    elseif ($ext==='em'){
                         $pxequiv=($this->terminal_em_scale)?'px scaling on':'px scaling off';
                         $emscale=($this->terminal_em_scale)?'px scaling on':'px scaling off';
                         
                         $pxequiv='&nbsp;&nbsp; = '.round($this->terminal_font_em_px*${'current_'.$ext},1).$emscale;
                         }
                    elseif ($ext==='vw'||$ext==='vh'){
                         $scaleunit=' no scaling ';
                         $pxequival=' px units not tabulated ';
                         }
                    else $pxequiv=''; 
                        $scaleunit=($ext==='percent')?'%':$ext;
                         printer::alertx('<p class="clear floatleft smallest whitebackground black fs1salmon">Active '.$msg.': <b>'.$pos_neg.${'current_'.$ext}.$scaleunit.$pxequiv.'</b></p>'); 
                    }
               }
          } 
     
     printer::pclear();
	$this->show_more('Use Other '.$msg.' Units');
	$this->print_redwrap('funct spacing more other spacing units');
     $emscale=($this->terminal_em_scale)?'px scaling on':'px scaling off';
     $remscale=($this->rem_scale)?' px scaling on':' px scaling off';
     printer::print_info("each em unit (if used) has current equivalent = $this->terminal_font_em_px$emscale");
     printer::print_info("1 rem equivalent to $this->rem_root$remscale");
     $this->show_more('Setting up em rem info','','info editbackground tiny','Click for important info on em rem');
	printer::print_tip('Choose an alternative spacing unit here.  <b>You can enable rwd scaling for rem (appropriately related to content-size at different viewports) in the page options under configure setting defaults and spacing values using rem will scale according to the settings you make there and the rem value you set here.</b> Em rwd scaling is determined by font-size scaling on the nearest font-size selection. See font-size unit choices for more info. <br> Choose value and unit type.  You can choose more than one unit type but rem will overrides em which overrides % which ovrrides px.');
     $this->show_close('Setting up em rem info');
	printer::alert(' <b> The following value types will override px setting on browsers that support it.</b>');
     printer::print_wrap('percent');
	printer::alert('Currently: '.$current_percent.'%  Choose Percent Value:');
	$this->mod_spacing($style.'['.$val.']['.($start+2).']',$current_percent,0,100,.05,'%','none');
     printer::close_print_wrap('percent');
     printer::print_wrap('em');
     $pxpercent=(!$this->is_page&&$showpercent)?'&nbsp;&nbsp;('.$current_em*$this->terminal_font_em_px*100/$this->current_total_width.'% Avail Parent Wid)':''; 
	$factor=(!$this->is_page)?$this->terminal_font_em_px*100/$this->current_total_width:1;
	$unit2=(!$this->is_page&&$showpercent)?'%':''; 
	printer::alert('Currently: '.$current_em.'em'.$pxpercent.'<br> Choose em value: ');
	$this->mod_spacing($style.'['.$val.']['.($start+3).']',$current_em,0,200,.05,'em','none','',$factor,$unit2);
     printer::close_print_wrap('em');
     printer::print_wrap('rem');
     $pxpercent=(!$this->is_page&&$showpercent)?'&nbsp;&nbsp;('.$current_rem*$this->rem_root*100/$this->current_total_width.'% Avail Parent Wid)':''; 
	$factor=(!$this->is_page)?$this->rem_root*100/$this->current_total_width:1;
	$unit2=(!$this->is_page&&$showpercent)?'%':''; 
	printer::alert('Currently: '.$current_rem.'rem'.$pxpercent.'<br> Choose rem value: '); 
	$this->mod_spacing($style.'['.$val.']['.($start+4).']',$current_rem,0,200,.01,'rem','none','',$factor,$unit2);
     printer::close_print_wrap('rem');
     #vw currently not enabled
     printer::print_wrap('vw');
	printer::alert('Currently: '.$current_vw.'vw Choose vw Value:');
	$this->mod_spacing($style.'['.$val.']['.($start+5).']',$current_vw,0,100,.02,'vw','none');
     printer::close_print_wrap('vw');
	if (strpos($css_style,'top')
         !==false||strpos($css_style,'bottom')!==false||strpos($css_style,'height')!==false){ 
          printer::print_wrap('vh');
		printer::alert('Currently: '.$current_vh.'vh Choose vh Value:');
		$this->mod_spacing($style.'['.$val.']['.($start+6).']',$current_vh,0,300,.02,'vh','none');
          printer::close_print_wrap('vh'); 
		}
	
	$this->submit_button();
	printer::close_print_wrap('funct spacing  other spacing units'); 
	$this->show_close('funct spacing  Use other spacing units'); 
    	printer::close_print_wrap('funct spacing  wrap other units');
	if (is_array($radio)){ 
          printer::print_wrap1('radio spacing'); 
          printer::print_tip('Checking This Css Option overrides all other chosen values.'); 
          $overridecss=false;
          $overridevalue='';
          foreach ($radio as $value=>$rvar){
               if($spacing_arr[$start]===$value){ 
                    $checked='checked="checked"';
                    $overridecss=true; 
                    $returnval=$overridevalue=$rvar;
                    }
               else $checked='';
               printer::alert('<input name="'.$style.'['.$val.']['.($start).']" type="radio" value="'.$value.'" '.$checked.'>Use '.$rvar);
               }
          ($overridecss)&&printer::alert('<input name="'.$style.'['.$val.']['.$start.']" type="radio" value="0"><span class="orange">Remove</span> Override Option: '.$overridevalue);
          printer::close_print_wrap1('funct spacing  radio spacing');
          }
	echo'  </div><!--spacing hide-->';
     
     printer::pclear();
	$this->submit_button(); 
	printer::close_print_wrap('funct spacing  spacing wrap');
	$this->show_close($msg); 
     if (strpos($css_style,'return')!==false){
          return $returnval;
          } 
	printer::pclear(); 
     $empty=true;
     $directReturn='';
	if ($css_style!=='none'){//
          $csstype=($this->is_page)?'pagecss':'css';
           if ($directcss!==false&&!empty($directcss)){//direct css is css expressed directly with this->css.=   instead of collected and aggregrated with other css that is expressed under same classname through the main style editor
               
               $remscale=$pxequiv=$scaleunit='';
               if (!$overridecss){ 
                    foreach (array('rem','em','percent','px','vh','vw') as $ext){ 
                         if (!empty(${'current_'.$ext})){
                              $empty=false;
                              if ($ext==='rem'){
                                   $remscale=($this->rem_scale)?'px scaling on':'px scaling off';
                                   $pxequiv='&nbsp;&nbsp; = '.round($this->rem_root*${'current_'.$ext}).$remscale;
                                   }
                              elseif ($ext==='em'){
                                   $emscale=($this->current_em_scale)?'px scaling on':'px scaling off'; 
                                   $pxequiv='&nbsp;&nbsp; = '.round($this->terminal_font_em_px*${'current_'.$ext}).$emscale;
                                   }
                              else $pxequiv='';
                              $scaleunit=($ext==='percent')?'%':$ext;
                              $this->$csstype.=$directReturn="
          $directcss".'{'.$css_style.':'.$pos_neg.${'current_'.$ext}.$scaleunit.';}';
                              printer::print_notice('Active '.$msg.': '.$pos_neg.${'current_'.$ext}.$scaleunit.$pxequiv);
                              break;
                              } 
                         printer::pclear();
                         }//end foreach
                    if(!empty($ifempty)&&$empty) { //is empty 
                         $this->$csstype.=$directReturn=$directcss.'{'.$ifempty.'}';  
                         } 
                    }//if directcss not false or !empty
               else {//use cssoverride value
                    $this->$csstype.=$directReturn=$directcss.'{'.$overridevalue.'}';
                    } 
               } 
          else  {// direct css is false
               $fstyle='final_'.$style;
               $this->{$fstyle}[$val]='';
               $empty=true; 
               if (!$overridecss){ 
                    foreach (array('rem','em','percent','px','vh','vw') as $ext){
                         if (!empty(${'current_'.$ext})){ 
                              $empty=false; 
                              $scaleunit=($ext==='percent')?'%':$ext; 
                              $this->{$fstyle}[$val].=$css_style.':'.$pos_neg.${'current_'.$ext}.$scaleunit.';'; 
                             /*if (!empty($current_px)&&$ext!=='percent'){// when px is used it will be overriden by other units .
                                   $this->$csstype.='
html '.$this->pelement.'{'.$css_style.':'.$pos_neg.${'current_'.$ext}.$scaleunit.';}';//this is backup only
                                   }*/
                              if (strpos($css_style,'min-width')!==false){//if device width is less than min-width cancel min-width;
                                   $this->$csstype.='
          @media screen and (max-width: '.${'current_'.$ext}.$scaleunit.'){
               html '.$this->pelement.'{min-width:0px;}
               }';
                                   } 
                              break;
                              }//if !empty
                         }//foreach 
                   if ($empty&&!empty($ifempty)){
                         $this->{$fstyle}[$val]=$ifempty;
                         }  
                    }//!cssovverride
               else {
                    $this->{$fstyle}[$val]=$overridevalue;
                    }
               }//directcss is false 
           }//if css_style !none
     if(!empty($directReturn))return $directReturn;
     return (!empty($returnval))?true:false;
	} #end spacing  //end
   
 
function padding_bottom($style, $val, $field){ if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	$this->spacing($style,$val,'padding-bottom','Padding Bottom Spacing','Adding bottom padding-spacing creates space below this post, column, etc. Augments the background color and spacing within borders if either used!','hidepad','','','','','','Default Value 0 Check padding-bottom:0 to insure',array('zero'=>'padding-bottom:0;'));
	}

function padding_right($style, $val, $field){ if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	$this->spacing($style,$val,'padding-right','Padding Right Spacing','Adding right padding-spacing creates space on the right of this post, column, etc. Augments the background color and spacing within borders if either used!','hidepad','',true, '','','','Default Value 0 Check padding-right:0 to insure',array('zero'=>'padding-right:0;'));
	}


function padding_left($style, $val, $field){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
     $this->spacing($style,$val,'padding-left','Padding Left Spacing','Creates space on the left of this post, column, etc. Augments the background color and spacing within borders if either used!','hidepad','',true, $field,'','','Default Value 0. Check padding-left:0 to insure',array('zero'=>'padding-left:0;'));
	}
     
function padding_all($style, $val, $field){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	if ($this->is_page|| ($this->is_blog&&!$this->is_clone)||($this->is_column&&!$this->is_clone||$this->clone_local_style)){  
		static $topinc=0; $topinc++; 
          echo '<p class="highlight click  left floatleft" id="padding'.$topinc.'" title="Padding Spacing choices add spacing to your post, column, etc. If borders are used the space will be within the border. If backgrounds are used it will extend the background space."  onclick="edit_Proc.getTags(\'hidepad\',\'showhide\',id);return false;">Spacing by Padding</p>';
		printer::pclear();
		}
    $this->spacing($style,$val,'padding','Padding All Spacing' ,'Creates space on the top,bottom,left,right of this post, column, etc. Augments the background color and spacing within borders if either used.','hidepad',false,'','','','','Default Value typically 0 check padding:0 to insure',array('zero'=>'padding: 0 0 0 0;'));
	}

function padding_top($style, $val, $field){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	
    $this->spacing($style,$val,'padding-top','Padding Top Spacing' ,'Creates space on the top of this post, column, etc. Augments the background color and spacing within borders if either used.','hidepad',false,'','','','','Default Value typically 0 check padding:0 to insure',array('zero'=>'padding-top:0;'));
	}
	
function margin_all($style, $val, $field){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	if ($this->is_page|| ($this->is_blog&&!$this->is_clone)||($this->is_column&&!$this->is_clone||$this->clone_local_style)){ 
		static $marginc=0; $marginc++; 
		echo '<p class="highlight click left floatleft" id="margin'.$marginc.'" title=" Margin Spacing also adds spacing to your post, column, etc. However, if borders are used the space will be outside of it and if a  background color is used  the spacing will be outside the background color!"  onclick="edit_Proc.getTags(\'hidemar\',\'showhide\',id);return false;">Spacing by Margin</p>';
		printer::pclear();
		}
	$this->spacing($style,$val,'margin','Margin All Spacing','Creates space on the top, bottom, left, and right of this post, column, etc. The Space will be outside of borders or Background Colors if either is used!!','hidemar','','','','','','Default Value typically 0',array('auto'=>'margin-top:auto;','zero'=>'margin-top:0;'));  
	}  

function margin_top($style, $val, $field){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	
	$this->spacing($style,$val,'margin-top','Margin top Spacing','Creates space on the top of this post, column, etc. The Space will be outside of borders or Background Colors if either is used!!','hidemar','','','','','','Default Value typically 0',array('auto'=>'margin-top:auto;','zero'=>'margin-top:0;'));  
	}  
function margin_bottom($style, $val, $field){ if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
     $this->spacing($style,$val,'margin-bottom','Margin Bottom Spacing','Creates space on the bottom of this post, column, etc. The Space will be outside of borders or Background Colors if either is used!!','hidemar','','','','','','Default Value typically 0',array('auto'=>'margin-bottom:auto;','zero'=>'margin-bottom:0;')); 
     }

function margin_right($style, $val, $field){ if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	if ($this->rwd_post&&strpos($style,'style')!==false)return; 
     $this->spacing($style,$val,'margin-right','Margin Right Spacing','Creates space to the right of this post, column, etc. that will be outside of borders or Background Colors if either is used!!','hidemar','',true,$field,'','','Typical Default Value: margin-right:auto; (for centering).',array('zero'=>'margin-right:0;','auto;'=>'margin-right:auto;'));
	}
     
function margin_left($style, $val, $field){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	if ($this->is_page|| ($this->is_blog&&!$this->is_clone)||($this->is_column&&!$this->is_clone||$this->clone_local_style)){ 
		if ($this->rwd_post&&strpos($style,'style')!==false){
			$this->show_more('RWD Margin Left Right Info','noback','info underline italic');
			printer::printx('<p class="fsminfo '.$this->column_lev_color.' editbackground editfont">When in RWD mode set left and right Spaces as options when choosing pos Grid units. The spaces will also be added as information in the total grid unit tracker!</p>'); 
			$this->show_close('RWD Margin Left Right Info');
			
			return;
			}
		}
	$this->spacing($style,$val,'margin-left','Margin Left Spacing','Creates space on the left of this post, column, etc. that  will be outside of borders or Background Colors if either is used!!','hidemar','',true,$field,'','','Default Value: margin-left:auto; (for centering)',array('zero'=>'margin-left:0;','auto;'=>'margin-left:auto;'));  
	}
	
function font_family($style, $val, $field,$show_style=false){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__); 
	$showstyle=($show_style)?'':' hide';
	if ($this->is_page|| ($this->is_blog&&!$this->is_clone)||($this->is_column&&!$this->is_clone||$this->clone_local_style)){  
		$msg= (empty($this->{$style}[$val]))? 'Default Value': str_replace(';','',str_replace('=>',',',$this->{$style}[$val]));  
		echo'<div class="fsminfo editcolor editbackground editfont '.$style.'_hidefont '.$showstyle.'" ><!--font family-->';
		$this->show_more('Font Family ', 'noback','editbackground editfont editcolor italic info',' Choose the Font Family Style for this post here','500');
		$this->print_redwrap('font family');
          $this->submit_button();
          echo'<div class="fsminfo editbackground editfont"><!--font family-->';
		echo '<p class="fs1red"><span class="highlight" title="Select a new text style (font-family) for this post from the dropdown menu. View a image of how the text style looks, click the link below. Choose None to return to the inherited font-family value.  &#40;Inherited Parent Values are the most recent values that have been set in the parent Columns and if not set there then in the body or the default browser font if none has been chosen in any parent!!">Text Font Style: </span>Currently:<br><span class="'.$this->column_lev_color.'"> '.$msg.'</span></p>';
               $mod_val=str_replace(';','',$this->{$style}[$val]);
               $init= ($mod_val=='inherit')?'checked="checked"':'';
		   echo  "\n".'<p style="font-family:inherit" ><input type="radio" name="'.$style.'['.$val.']" '.$init.' value="inherit">inherit</p>';
             foreach ($this->fonts_all as $family){
			$mod_family=str_replace(',','=>',$family);
			$checked=(trim($mod_family)===trim($mod_val))?'checked="checked"':'';
			echo  "\n".'<p style="font-family:'.$family.';" ><input type="radio" name="'.$style.'['.$val.']" '.$checked.' value="'.$mod_family.';">'.$family.'</p>';
			}
		$this->submit_button();
		echo'</div><!--font family-->';
		printer::close_print_wrap('font family');
          $this->show_close('Font Family');
		echo'</div><!--font family-->';
		}
	$value=str_replace('=>',',',$this->{$style}[$val]);
	$v=str_replace(';','',$value);  
	if (in_array($v,$this->fonts_extended)){
		$this->at_fonts[]=$v;
		}
	$value=rtrim(trim($value),';');
	$fstyle='final_'.$style;
	$this->{$fstyle}[$val]=(!empty($value))?'font-family: '.$value.';':'0';
	} 
 
function font_weight($style, $val, $field){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	if ($this->is_page|| ($this->is_blog&&!$this->is_clone)||($this->is_column&&!$this->is_clone||$this->clone_local_style)){  
		$msg= (empty($this->{$style}[$val]))? 'None ': $this->{$style}[$val];
		$selected=(!empty($this->{$style}[$val]))?$this->{$style}[$val]:400;
		echo '
		<div class="fsminfo editbackground editfont '.$style.'_hidefont hide"><!--font_weight--><p class="highlight" title="Select new Font Weight &#40;the thickness or relative boldness of the font&#41; from dropdown menu list. The normal default font-weight is 400 whereas the traditional bold font-weight is 700.">Font Weight: Currently '.$msg.'<br>
		<select class="editcolor editbackground editfont"  name="'.$style.'['.$val.']" id="'.$style.'_'.$val.'">        
		<option  value="'.$this->{$style}[$val].'" selected="selected">'.$selected.'</option>
		<option  value="0">Choose None</option>
		<option  value="100">100-Super Light Font</option>
		<option  value="200">200</option> 
		<option  value="300">300-slightly fainter</option>  
		<option  value="400">400-normal</option>  
		<option  value="500">500-slightly bold</option>
		<option  value="600">600</option>
		<option  value="700">700-bold</option>
		<option  value="800">800</option>
		<option  value="900">900-Super Bold</option>   
		</select>';
		echo'
		</p></div><!--font_weight-->';
		}
     $fstyle='final_'.$style;
     $this->{$fstyle}[$val]=(empty($this->{$style}[$val]))?'0':'font-weight: '.$this->{$style}[$val].'; ';
    }

function float($style,$val){
 	if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
     $msg='';
     $arr=array("block","center","centerfloat","centerfloatAbs","right","left","center no previous","right no previous","left no previous","none");
     $this->show_more('Float Right/Left/Center', 'noback','editbackground editfont highlight',' Choose to Position Next to instead of full Space',500);
	printer::print_tip('Use  no previous options to prevent floating with previous post and and then center, go left, go right depending on your choice');
     $current=(!empty($this->{$style}[$val])&&in_array($this->{$style}[$val],$arr))?$this->{$style}[$val]:'none';
     
    switch ($this->{$style}[$val]){
          case 'block' :
			$floatstyle='display:block;';
               $fval='Full Row Block';
               break;
		case 'center' :
               $floatstyle='margin-right:auto;margin-left:auto;display:block;';
               $fval='Center Full Width (block)';
               break;
          case 'centerfloat' :
               $floatstyle='display:inline-block;';
               $fval='Center Float (inline-block)';
               break;
          case 'centerfloatAbs' :
               $floatstyle='left: 50%;transform: translateX(-50%); -ms-transform: translateX(-50%);-webkit-transform: translateX(-50%);display:inline-block;';
               $fval='Center Float Abs/Fixed Element (uses transform)';
               break;
          case 'right' :
               $floatstyle='float:right;';
               $fval='Float Right';
               break;
          case 'left' :
               $floatstyle='float:left;';
               $fval='Float Left';
               break;
          case 'center no previous' :
               $floatstyle='display:inline-block;clear:both;';
               $fval='Center floating No Previous';
               break;
          case 'right no previous' :
               $floatstyle='float:right;clear:both;';
               $fval='Float Right No Previous';
               break;
          case 'left no previous' :
               $floatstyle='float:left;clear:both;';
               $fval='Float Left No Previous';
               break; 
          case 'none' :
               $floatstyle='';
               $fval='None';
               break; 
          default :
               $floatstyle='';
               $fval='None';
               break;
          }
     echo '
        <fieldset class="sfield"><legend></legend><p class="'.$this->column_lev_color.' editbackground editfont  Os3salmon fsminfo float">Float: Currently '.$msg.'<br>
    Float (positions along side) setting:<br>
         <select class="editcolor editbackground editfont"  name="'.$style.'['.$val.']" id="'.$style.'_'.$val.'">
    <option  value="'.$current.'" selected="selected">'.$fval.'</option>
    <option  value="block">Full Width Block</option>
    <option  value="center">Center Full Width</option> 
    <option  value="centerfloat">Center Float (inline-block)</option> 
    <option  value="centerfloatAbs">Center Float for Abs/Fixed Element (transform)</option> 
    <option  value="right">Float Right</option>
    <option  value="left">Float Left</option>
    <option  value="center no previous">Center Float with No Previous</option> 
    <option  value="right no previous">Float Right No Previous</option>
    <option  value="left no previous">Float Left No Previous</option>
    <option value="none">None</option>
    </select>';
     echo'
    </p></fieldset>';
     $this->show_close('Float Right/Left');
     $fstyle='final_'.$style;
	$this->{$fstyle}[$val]=$floatstyle;
	}
	
function vertical($style,$val){
	$array=array('baseline','sub','super','top','text-top','middle','bottom','text-bottom','initial','inherit');
	$this->show_more('Vertical Align Posts','','editbackground editfont highlight');
     $this->print_redwrap('vertical align');
     printer::print_tip('Use center float for vertical align to have effect (uses inline-block). Flex settings override');
     printer::alertx('
<div class="'.$this->column_lev_color.' fsminfo maxwidth500 floatleft editbackground editfont">By Default Posts will Vertically Top Align with Other Posts within the Parent Column. Change that Default Here '); 
     printer::alert('Post Vertical Positioning Choice','','left editcolor editbackground editfont');
     $current_vert_val=(!empty($this->{$style}[$val])&&in_array($this->{$style}[$val],$array))?$this->{$style}[$val]:'';
     forms::form_dropdown($array,'','','',$style.'['.$val.']',$current_vert_val,false,'editcolor editbackground editfont left');
     $css='';
     $fstyle='final_'.$style;
	if (!empty($current_vert_val))
		$this->{$fstyle}[$val]='vertical-align:'.$current_vert_val.'; ';
     printer::alertx('</div>');
     printer::pclear();
     $this->show_more('Style info','','info italic smaller');
     printer::print_wrap1('techinfo');
     printer::print_info('Current setting Css: '.$css.' in '.$this->roots.Cfg::Style_dir.$this->pagename.'.css');
     $msg='Changes default vertical align css';
     printer::print_info($msg);
     printer::close_print_wrap1('techinfo');
     $this->show_close('Tech info');
     printer::close_print_wrap('vertical align');
     $this->show_close('Vertical Align Posts');
	}//end vertical funct

function radius_corner($style, $val,$field){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	if (arrayhandler::is_empty_array($this->{$style}[$val])){//default may be set to 1
		$radius_array=array();
		for ($i=0; $i<18;$i++){ 
			$radius_array[$i]=0;
			}
		}
	else	{ //note that input type text will give 0value for defaults...
		$radius_array=explode('@@',$this->{$style}[$val]);
		for ($i=0; $i<18;$i++){ 
			if (!array_key_exists($i,$radius_array)){
				$radius_array[$i]=0;
				}
			}
		} 
	if ($this->is_page|| ($this->is_blog&&!$this->is_clone)||($this->is_column&&!$this->is_clone||$this->clone_local_style)){  
          $this->show_more('Radius Background', 'noback','editbackground editfont highlight',' Radius a Colored Post Background if in use Here!',500);
          $this->print_redwrap('wrap radius',false);
          echo '<p class="fsminfo editbackground editfont rad10 '.$this->column_lev_color.' editfont">As an Example we have used a radius around this text with a border to show the radius effect. A value of 10px was selected for each corner<br> <span class="italic"> Note that your Radius will only show up when background colors, box shadows, and borders are used</span> <br> Radius the stylized corners of Column, Posts, and Menu-Link Button Area, and Images directly.</p>'; 
          $check='checked="checked"';
          $checked1=($radius_array[4]!=='individual')?$check:'';
          $checked2=($radius_array[4]==='individual')?$check:'';
          printer::print_wrap('radio choice radius');
          printer::alert('<input type="radio" '.$checked1.' value="all" name="'.$style.'['.$val.'][4]">1.Activate Using one value choice for all four corners. Select from range of unit types. Note percentage units will round entire sides');
          printer::alert('<input type="radio" '.$checked2.' value="individual" name="'.$style.'['.$val.'][4]">2.Choose size for individual corner values using px units');
          printer::close_print_wrap('radio choice radius');
          $css_type=($radius_array[4]!=='individual')?'border-radius':'none';
          $this->spacing($style,$val,$css_type,'Radius All Corners','Creates Radius on all four background corners using one value &amp; multiple unit choices','','','','','',8);//allowing three xtra for incorporation of px radius scale units..
          $size1= (empty($radius_array[0])||!is_numeric($radius_array[0]))? '0':$radius_array[0];
          $this->show_more('or choose value for each corner in px');
          printer::print_wrap('individual radius');
          echo '<fieldset class="sfield"><legend></legend>
             <p class="'.$this->column_lev_color.' editbackground editfont">Choose: Top Left Radius:
              <select class="editcolor editbackground editfont"  name="'.$style.'['.$val.'][0]" >        
              <option  value="'.$radius_array[0].'" selected="selected">'.$radius_array[0].'</option>';
               for ($i=0; $i<95; $i+=1){
                  echo '<option  value="'.$i.'">'.$i.'</option>';
                  }
             
          echo'	
              </select></p>';
              printer::pclear(1);
               $size2= (empty($radius_array[1])||!is_numeric($radius_array[1]))? '0':$radius_array[1];
             echo '
             <p class="'.$this->column_lev_color.' editbackground editfont">Choose: Top Right Radius:
              <select class="editcolor editbackground editfont"  name="'.$style.'['.$val.'][1]" >        
              <option  value="'.$radius_array[1].'" selected="selected">'.$radius_array[1].'</option>';
          for ($i=0; $i<95; $i+=1){
               echo '<option  value="'.$i.'">'.$i.'</option>';
               }
          echo'	
              </select></p>';
               $size3= (empty($radius_array[2])||!is_numeric($radius_array[2]))? '0':$radius_array[2];
             echo '
             <p class="'.$this->column_lev_color.' editbackground editfont"> Choose: Bottom Right Radius:
              <select class="editcolor editbackground editfont"  name="'.$style.'['.$val.'][2]" >        
              <option  value="'.$radius_array[2].'" selected="selected">'.$radius_array[2].'</option>';
          for ($i=0; $i<95; $i+=1){
               echo '<option  value="'.$i.'">'.$i.'</option>';
               }
          echo'	
              </select></p>';
          $size4= (empty($radius_array[3])||!is_numeric($radius_array[3]))? '0':$radius_array[3];
             echo '
               <p class="'.$this->column_lev_color.' editbackground editfont">Choose: Bottom Left Radius:
               <select class="editcolor editbackground editfont"  name="'.$style.'['.$val.'][3]" >        
               <option  value="'.$radius_array[3].'" selected="selected">'.$radius_array[3].'</option>';
               for ($i=0; $i<95; $i+=1){
                    echo '<option  value="'.$i.'">'.$i.'</option>';
                    }
          echo'	
              </select></p>';
          echo'</fieldset>';
          printer::close_print_wrap('individual radius'); 
          $this->show_close('or choose value for each corner in px');
          $this->submit_button();
          printer::close_print_wrap('wrap radius');
          $this->show_close('radius');
		}// if page or clone and not local style 
	if ($css_type==='none'&&(!empty($size1)||!empty($size2)||!empty($size3)||!empty($size4))){
          $radiuscss='
		-webkit-border-radius: '.$size1.'px '.$size2.'px '.$size3.'px '.$size4.'px;
	border-radius: '.$size1.'px '.$size2.'px '.$size3.'px '.$size4.'px;
		';
          $fstyle='final_'.$style;
          $this->{$fstyle}[$val]=$radiuscss;
          } 
	}//end fuc radius

function transform($style, $val,$field){ 
	if (arrayhandler::is_empty_array($this->{$style}[$val])){//default may be set to 1
		$transform_array=array();
		 for ($i=0; $i<3;$i++){ 
			$transform_array[$i]=0;
			}
		}
	else	{ //note that input type text will give 0value for defaults...
		$transform_array=explode('@@',$this->{$style}[$val]);
		for ($i=0; $i<3;$i++){ 
			if (!array_key_exists($i,$transform_array)||empty($transform_array[$i])){
				$transform_array[$i]=0;
				}
			}
		}   
	if ($this->is_page|| ($this->is_blog&&!$this->is_clone)||($this->is_column&&!$this->is_clone||$this->clone_local_style)){
		$this->show_more('Rotate/Skew', 'noback','highlight editbackground editfont',' Rotate or Skew the Content of this post!',500);
		//echo '<div class="fs2moccasin editbackground editfont editcolor"><!--tranform border-->';
		$this->print_redwrap('transform',false);
		echo '<p class="fsminfo editbackground editfont rad5 skewx3 '.$this->column_lev_color.' editfont">This demonstrates a skew Xdirection of 4 degrees around this text to show the transform option in practice.  Be sure to allow enough width for your final effect! For more info on using the css3 transform feature and examples see <a href="http://www.w3schools.com/cssref/css3_pr_transform.asp"> Column Examples</a></p>'; 
          $size= (empty($transform_array[0]))? '0':$transform_array[0];
		echo '
		<p class="'.$this->column_lev_color.' editbackground editfont">Degrees of Rotation: Currently '.$size.'<br>
		 <span class="editcolor editbackground editfont">Choose Rotation Degrees:</span>
		 <select class="editcolor editbackground editfont"  name="'.$style.'['.$val.'][0]" >        
		 <option  value="'.$transform_array[0].'" selected="selected">'.$transform_array[0].'</option>';
		for ($i=-90; $i<-15; $i+=5){
			echo '<option  value="'.$i.'">'.$i.'&#176;</option>';
			}
		for ($i=-15; $i<15; $i+=1){
			echo '<option  value="'.$i.'">'.$i.'&#176;</option>';
			}
		for ($i=15; $i<90; $i+=5){
			echo '<option  value="'.$i.'">'.$i.'&#176;</option>';
			}
		echo'	
		 </select></p>';
		$size= (empty($transform_array[1]))? '0':$transform_array[1];
		echo'<p class="'.$this->column_lev_color.' editbackground editfont">Skew Xdirection  Degrees: Currently '.$size.'<br>
		 <span class="editcolor editbackground editfont">Choose Skew Xdirection Degrees:</span>
		 <select class="editcolor editbackground editfont"  name="'.$style.'['.$val.'][1]" >        
		 <option  value="'.$transform_array[1].'" selected="selected">'.$transform_array[1].'</option>';
		for ($i=-45; $i<-15; $i+=5){
			echo '<option  value="'.$i.'">'.$i.'&#176;</option>';
			}
		for ($i=-15; $i<15; $i+=1){
			echo '<option  value="'.$i.'">'.$i.'&#176;</option>';
			}
		for ($i=15; $i<50; $i+=5){
			echo '<option  value="'.$i.'">'.$i.'&#176;</option>';
			}
		echo'	
		 </select></p>';
		$size= (empty($transform_array[2]))? '0':$transform_array[2];
		echo'<p class="'.$this->column_lev_color.' editbackground editfont">Skew Ydirection Degrees: Currently '.$size.'<br>
		 <span class="editcolor editbackground editfont">Choose Skew Ydirection Degrees:</span>
		 <select class="editcolor editbackground editfont"  name="'.$style.'['.$val.'][2]" >        
		 <option  value="'.$transform_array[2].'" selected="selected">'.$transform_array[2].'</option>';
		for ($i=-45; $i<-15; $i+=5){
			echo '<option  value="'.$i.'">'.$i.'&#176;</option>';
			}
		for ($i=-15; $i<15; $i+=1){
			echo '<option  value="'.$i.'">'.$i.'&#176;</option>';
			}
		for ($i=15; $i<50; $i+=5){
			echo '<option  value="'.$i.'">'.$i.'&#176;</option>';
			}  
		echo'	
		 </select></p>';
          $this->submit_button();
		printer::close_print_wrap('transform');
		$this->show_close('tranform border');
		}
	$transformcss='
	-moz-transform: rotate('.$transform_array[0].'deg) skewX('.$transform_array[1].'deg) skewY('.$transform_array[2].'deg);
	-webkit-transform: rotate('.$transform_array[0].'deg) skewX('.$transform_array[1].'deg) skewY('.$transform_array[2].'deg);
	-o-transform: rotate('.$transform_array[0].'deg) skewX('.$transform_array[1].'deg) skewY('.$transform_array[2].'deg);
	-ms-transform: rotate('.$transform_array[0].'deg) skewX('.$transform_array[1].'deg) skewY('.$transform_array[2].'deg);
	transform: rotate('.$transform_array[0].'deg) skewX('.$transform_array[1].'deg) skewY('.$transform_array[2].'deg);
	';
	 
	$transformcss= (empty($transform_array[0])&&empty($transform_array[1])&&empty($transform_array[2]))?'':$transformcss;
	$fstyle='final_'.$style;
	$this->{$fstyle}[$val]=$transformcss;
	}

function columns($style, $val,$field){ 
	if (arrayhandler::is_empty_array($this->{$style}[$val])){//default may be set to 1
		$column_array=array();
		for ($i=0; $i<3;$i++){ 
			$column_array[$i]=1;
               }
		}
	else	{ //note that input type text will give 0value for defaults...
		$column_array=explode('@@',$this->{$style}[$val]);
		for ($i=0; $i<3;$i++){ 
			if (!array_key_exists($i,$column_array)||$column_array[$i]==1){
				$column_array[$i]=1;
					}
			}
		}
	if ($this->is_page|| ($this->is_blog&&!$this->is_clone)||($this->is_column&&!$this->is_clone||$this->clone_local_style)){  
		$this->show_more('Multiple Columns', 'noback','highlight editbackground editfont',' turn this text into 2 or more columns',300);
		$this->print_redwrap('multiple cols');
		echo '<p class="column2 '.$this->column_lev_color.' fsminfo editbackground editfont rad3 editfont">This text you are reading was set up with 2 columns and a space of 16px between the columns with no divider line showing. The columns will be split between the available width.<br>For quick overview of using the css3 column feature and examples see <a href="http://css-tricks.com/snippets/css/css-box-column/"> Column Examples.</a><br> </p>';
		printer::pclear(8);
		   $size= (empty($column_array[0]))? 'One':$column_array[0];
		echo '
		<p class="'.$this->column_lev_color.' editbackground editfont">Choose the number of columns: Currently '.$size.'<br>
		<span class="editcolor editbackground editfont">Choose # of Columns:</span>
		<select class="editcolor editbackground editfont"  name="'.$style.'['.$val.'][0]" >        
		<option  value="'.$column_array[0].'" selected="selected">'.$column_array[0].'</option>';
		for ($i=1; $i<6; $i+=1){
			echo '<option  value="'.$i.'">'.$i.'</option>';
			}
		 echo'	
		 </select></p>';
		$size= (empty($column_array[1]))? 'None':$column_array[1];
		echo'<p class="'.$this->column_lev_color.' editbackground editfont">Choose the spacing between columns Currently '.$size.' px <br>
		<span class="editcolor editbackground editfont">Choose Spacing between columns:</span>
		<select class="editcolor editbackground editfont"  name="'.$style.'['.$val.'][1]" >        
		<option  value="'.$column_array[1].'" selected="selected">'.$column_array[1].'</option>';
		for ($i=0; $i<200; $i+=1){
			 echo '<option  value="'.$i.'">'.$i.'px</option>';
			}
		echo'	
		</select></p>'; 
		$column_array[2]=($column_array[2]==='Line Separator True')?$column_array[2]:'Line Separator False';
		echo'<p class="'.$this->column_lev_color.' editbackground editfont">Show  line Separator Between Columns: Currently '.$column_array[2].'<br>
		<span class="editcolor editbackground editfont">Choose Show Divider:</span>
		<select class="editcolor editbackground editfont"  name="'.$style.'['.$val.'][2]" >        
		<option  value="'.$column_array[2].'" selected="selected">'.$column_array[2].'</option>';
		echo '<option  value="Line Separator False">Line Separator False</option> 
			<option  value="Line Separator True">Line Separator True</option> 
               </select></p>';
          $this->submit_button(); 
		printer::close_print_wrap('multiple cols');
		$this->show_close('multiple columns');
		}   
	$col=(!empty($this->{$style}[$this->font_color_index]))?$this->{$style}[$this->font_color_index]:$this->editor_color;
	 //color was transformed by color funct so need to replace
	$col=trim(str_replace(array('color',':','#',';'),'',$col));
	$line=($column_array[2]==='Line Separator True')?'-moz-column-rule: 1px solid #'.$col.'; -webkit-column-rule: 1px solid #'.$col.';  column-rule: 1px solid #'.$col.';':'';
	$columncss='
	-moz-column-count: '.$column_array[0].';
	-moz-column-gap: '.$column_array[1].'px;
	-webkit-column-count: '.$column_array[0].';
	-webkit-column-gap: '.$column_array[1].'px;
	column-count: '.$column_array[0].';
	column-gap: '.$column_array[1].'px;
	'.$line;
	$columncss= (empty($column_array[0])||$column_array[0]<2)?'':$columncss;
	$fstyle='final_'.$style;
	$this->{$fstyle}[$val]=$columncss;
	}

function borders($style, $val,$field){ 
	static $inc=0; $inc++;
     self::$xyz++;
	$border_sides=$this->border_sides;
     $css_id=$this->pelement;
	$barray=array('border_width','border_color','border_type','border_sides','border_opacity','border_scaleunit','border_value','border_value2');
	foreach($barray as $key =>$index){
			${$index.'_index'}=$key; 
		}
	$count=count($barray);
	if (arrayhandler::is_empty_array($this->{$style}[$val])){//default may be set to 1
		$parr=$border_array=array();
		for ($i=0; $i<$count;$i++){ 
			$border_array[$i]=0;
			}
		}
	else	{ //note that input type text will give 0value for defaults...
		$parr=$border_array=explode('@@',$this->{$style}[$val]);
		for ($i=0; $i<$count;$i++){ 
			if (!array_key_exists($i,$border_array)){
				$border_array[$i]=0;
				}
			}
		}
	
     $border_opacity=(!empty($border_array[$border_opacity_index])&&$border_array[$border_opacity_index]<100&&$border_array[$border_opacity_index]>0)?$border_array[$border_opacity_index]:100;
	$blog_border_sides=$border_array[$border_sides_index]=(!empty($border_array[$border_sides_index])&&in_array($border_array[$border_sides_index],$border_sides))?$border_array[$border_sides_index]:'No Border';
	$border_line=$border_array[$border_width_index]= (is_numeric($border_array[$border_width_index])&&$border_array[$border_width_index]>0)? $border_array[$border_width_index]:0;
     $border_line=round($border_line,1);
	$px='px ';
     $scaleunit=(!empty($border_array[$border_scaleunit_index])&&$border_array[$border_scaleunit_index]==='em'||$border_array[$border_scaleunit_index]==='rem')?$border_array[$border_scaleunit_index]:'none'; 
	$border_value2=(!empty($border_array[$border_value2_index])&&is_numeric($border_array[$border_value2_index]))?$border_array[$border_value2_index]:0;
     if ($scaleunit!=='none'&&!empty($border_value2)){
          $msginfo=printer::print_notice('em/rem unit active: '.$border_value2.$scaleunit,.9,1);
          $border_line=$border_value2;
          $px=$scaleunit;
          }
     else $msginfo=printer::print_notice('No active em/rem unit',.9,1);
	switch ($border_array[$border_sides_index]) { 
          case $border_sides[1]:# all
               $border_width="$border_line$px $border_line$px $border_line$px $border_line$px";
               $barr=$border_line.'x@x@x'.$border_line.'x@x@x'.$border_line.'x@x@x'.$border_line;
               break;
          case $border_sides[2]:# top bottom
               $border_width=" $border_line$px 0 $border_line$px 0";
                $barr=$border_line.'x@x@x0x@x@x'.$border_line.'x@x@x0';
               break; 
          case $border_sides[3]:# top
               $border_width="$border_line$px 0 0 0";
                $barr=$border_line.'x@x@x0x@x@x0x@x@x0';
               break;
          case $border_sides[4]:# bottom
               $border_width="0 0 $border_line$px 0";
                $barr='0x@x@x0x@x@x'.$border_line.'x@x@x0';
               break;
          case $border_sides[5]:# left
               $border_width="0 0 0 $border_line$px";
                $barr='0x@x@x0x@x@x0x@x@x'.$border_line;
               break;
          case $border_sides[6]:# right
               $border_width="0 $border_line$px 0 0";
                $barr='0x@x@x'.$border_line.'x@x@x0x@x@x0';
               break;
          case $border_sides[7]:# top left
               $border_width="$border_line$px 0 0 $border_line$px";
                $barr=$border_line.'x@x@x0x@x@x0x@x@x'.$border_line;
               break;
          case $border_sides[8]:# top right
               $border_width="$border_line$px $border_line$px 0 0";
               $barr=$border_line.'x@x@x'.$border_line.'x@x@x0x@x@x0';
               break;
          case $border_sides[9]:# bottom left
               $border_width="0 0 $border_line$px $border_line$px";
               $barr='0x@x@x0x@x@x'.$border_line.'x@x@x'.$border_line;
               break;
          case $border_sides[10]:# bottom right
               $border_width="0 $border_line$px $border_line$px  0";
                $barr='0x@x@x'.$border_line.'x@x@x'.$border_line.'x@x@x0';
               break;
          case $border_sides[11]:# left right
               $border_width="0 $border_line$px 0 $border_line$px";
                $barr='';
               break;
          case $border_sides[12]:# force no border
               $border_width='0';
                $barr='';
               break;
          default:
          $border_width=0;
          $barr='';	 
          }//end switch 
     if ($scaleunit!=='none'&&!empty($border_value2))$barr=0;
	$blog_border_color=$border_array[$border_color_index]=(preg_match(Cfg::Preg_color,$border_array[$border_color_index]))?$border_array[$border_color_index]:'';
	if (!empty(trim($blog_border_color))){
		if ($border_opacity <100) 
			$br_color=process_data::hex2rgba($blog_border_color,$border_opacity);
		else $br_color='#'.$blog_border_color;
		$border_color='border-color: '.$br_color.';'; 
		}
	else $border_color='';
     $border_types=array('dotted','dashed','solid','double','groove','ridge','inset','outset');
	$border_value=(is_numeric($border_array[$border_width_index])&&$border_array[$border_width_index]<=100)?$border_array[$border_width_index]:0; 
     $blog_border_type=$border_array[$border_type_index]=(!empty($border_array[$border_type_index])&&in_array($border_array[$border_type_index],$border_types))?$border_array[$border_type_index]:'solid';
	if ($this->is_page|| ($this->is_blog&&!$this->is_clone)||($this->is_column&&!$this->is_clone||$this->clone_local_style)){  
		$this->show_more('Border styling','noback','editfont highlight editbackground editfont', 'For Information on Borders and to Choose Border Type, Colors, and Edges click Here',500);
		$this->print_redwrap('border styling wrap');
		echo '<div class="Os2maroon fs1color  editbackground editfont"><!--Border sides-->';
		echo '<p style="margin:13px; padding:13px;border-width: 3px 0 3px 0; border-style:double; border-color:#'.$this->aqua.';" class="'.$this->column_lev_color.' editbackground editfont"><!--End function border style-->We have used a light blue border selecting top and bottom around this text with a border type: double and a border thickness of 4'.$px.'. Borders are lines dashes dots,etc. stylize around columns, posts, groups of posts or menu link &#34;buttons&#34; depending on which of these you are currently styling! <br></p>'; 
		printer::spanclear(5);
          printer::print_wrap('choose sides');
		echo'<p class="'.$this->column_lev_color.' editbackground editfont">Choose Border Profile (Top Bottom Sides) Currently: '.$border_array[$border_sides_index].'<br></p>';
          printer::print_tip('Use the Force No Border Option for explicit border-width:0; if necessary in navigation menus (ie sub menu vs top menu');
		echo '<p class="editcolor editbackground editfont" title="For Example Choose top bottom left right for a normal box border around the entire column, or if wish to show a border only around one or two sides for expample, the top and right, choose the top right option instead">Border Sides Info';
		echo '<select class="editcolor editbackground editfont"  name="'.$style.'['.$val.'][3]" >        
		<option  value="'.$border_array[$border_sides_index].'" selected="selected">'.$border_array[$border_sides_index].'</option>'; 
		foreach ($border_sides as $type){
			echo'<option  value="'.$type.'">'.$type.'</option> ';
			}
		echo '</select></p>';
		printer::close_print_wrap('choose sides');
          printer::print_wrap('px border');
		echo'<p class="editfont editcolor left5 editbackground editfont"> Border Line Thickness:';
          $this->mod_spacing($style.'['.$val.'][0]',$border_value,0,100,1,'px');
		$css_style=(!empty($barr)&&$border_array[$border_sides_index]!=='No Border'&&!empty($blog_border_color))?'border-width':'none'; 
          $parr[0]=$barr;
          $parr=implode('@@',$parr);
          $this->rwd_scale($parr,$style.'['.$val.']',$css_id,$css_style,'border-width','px',0,5,true); 
          printer::close_print_wrap('px border'); 
		printer::spanclear(5);
          #############
          echo $msginfo;
          printer::pclear(5);
          $this->show_more('Use other border-size units');
          $this->print_redwrap('other bordersize units');
          $more='';/*(!$this->is_page&&(!$this->col_primary||$this->is_blog))?'
4. Choose VW units.':'';*/
          printer::print_tip('OR Choose alt border-size units here.  <b>You can optionally enable scaling (responive size according to viewport) for rem (appropriately between the upper and lower viewport size of your choice) and similarly for em under font-size choice.'); 
          printer::print_tip('Choose value and unit type.');
	     $checked=' checked="checked" ';
          $checked1=($scaleunit==='none')?$checked:'';
          $checked2=($scaleunit==='em')?$checked:'';
          $checked3=($scaleunit==='rem')?$checked:'';   
          printer::alert('Choose scale unit:');
          printer::alert('<input type="radio" name="'.$style.'['.$val.'][7]" value="none" '.$checked1.'>None');
          printer::alert('<input type="radio" name="'.$style.'['.$val.'][7]" value="em" '.$checked2.'>em units');
          printer::alert('<input type="radio" name="'.$style.'['.$val.'][7]" value="rem" '.$checked3.'>rem units'); 
          // (!$this->is_page&&(!$this->col_primary||$this->is_blog))&&printer::alert('<input type="radio" name="'.$style.'['.$val.'][1]" value="vw" '.$checked4.'>vw units'); 
          printer::pclear(5);
          echo'<p class="'.$this->column_lev_color.' editbackground editborder">Scalable border Size: Currently '.$border_value2.'<br>
          Choose:';
          $this->mod_spacing($style.'['.$val.'][8]',$border_value2,0,10,.1,'unit');
		echo'	
	    </select></p>';
          $this->submit_button();  
          printer::close_print_wrap('other bordersize units');  
          $this->show_close('Use other border-size units');
          printer::pclear(5);
          printer::print_wrap('border color');
          $span_color=(!empty($border_array[$border_color_index]))?'<span class="fs1npred" style="background-color:#'.$border_array[$border_color_index].';">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>':''; 
		printer::alert('Set border Color <input onclick="jscolor.installByClassName(\'border_id'.$inc.'_'.self::$xyz.'\');" style="cursor:pointer;background:#'.$this->editor_background.';color:#'.$this->editor_color.';" type="text" name="'.$style.'['.$val.'][1]" id="border_id'.$inc.'_'.self::$xyz.'" value="'.$border_array[$border_color_index].'" size="12" maxlength="6" class="border_id'.$inc.'_'.self::$xyz.' {refine:false}">'.$span_color.'<br>',false,'left editcolor editbackground editfont');
          printer::close_print_wrap('border color');
          printer::print_wrap1('border opacity');
          echo '<p class="editcolor editbackground editfont ">Change Border  Opacity: '.$border_opacity.'% </p>';
		$this->mod_spacing($style.'['.$val.'][4]',$border_opacity,0,100,1,'%');
          printer::close_print_wrap1('border opacity');
		echo'<p class="left '.$this->column_lev_color.'">Set Border Type Currently: '.$border_array[$border_type_index].'<br>
		<span class="editcolor editbackground editfont">Border Type:</span>
		<select class="editcolor editbackground editfont"  name="'.$style.'['.$val.'][2]" >        
		<option  value="'.$border_array[$border_type_index].'" selected="selected">'.$border_array[$border_type_index].'</option>'; 
		foreach ($border_types as $type){
			echo'<option  value="'.$type.'">'.$type.'</option> ';
			}
		echo '</select></p>';
		echo '</div><!--End function border style-->';
		printer::spanclear(5); 
          $this->submit_button();
		printer::close_print_wrap('border styling wrap');
		$this->show_close('Border styling');
		}//if !clone || local style
     $fstyle='final_'.$style;
     $this->{$fstyle}[$val]=($border_array[$border_sides_index]=='Force No Border'||($border_array[$border_sides_index]!='No Border'&&!empty($blog_border_color)))?$this->{$style}[$val]='border-width: '.$border_width.'; border-style:'. $blog_border_type.';'.$border_color:'';//this 
     }//end   borders

function outlines($style, $val,$field){ 
	static $inc=0; $inc++; 
	$px='px'; 
	if (arrayhandler::is_empty_array($this->{$style}[$val])){//default may be set to 1
		$outline_array=array();
		 for ($i=0; $i<3;$i++){ 
			$outline_array[$i]=0;
			}
		}
	else	{ //note that input type text will give 0value for defaults...
		$outline_array=explode('@@',$this->{$style}[$val]);
		for ($i=0; $i<3;$i++){ 
			if (!array_key_exists($i,$outline_array)){
				$outline_array[$i]=0;
				}
			}
		}
	$outline_width=(is_numeric($outline_array[0])&&$outline_array[0]<81)?$outline_array[0]:0;
	$blog_outline_color=$outline_array[1]=(preg_match(Cfg::Preg_color,$outline_array[1]))?$outline_array[1]:'';
	$outline_types=array('dotted','dashed','solid','double','groove','ridge','inset','outset');
	$blog_outline_type=$outline_array[2]=(!empty($outline_array[2])&&in_array($outline_array[2],$outline_types))?$outline_array[2]:'solid';
	if ($this->is_page|| ($this->is_blog&&!$this->is_clone)||($this->is_column&&!$this->is_clone||$this->clone_local_style)){  
          $this->show_more('Outline Styling','noback','editfont highlight editbackground editfont', 'For Information on outlines and to Choose outline Type, Colors, and Edges click Here',500);
          $this->print_redwrap('outline style');
		echo '<div class="fsminfo editcolor editbackground editfont"><!--  outline style-->';
		printer::alertx('<p class="Os4ekblue">We have used a blue outline around this text with a outline type: single and a outline thickness of 4px. Outlines are similar to borders except 4 sides always. They wrap around outside of borders (if used). Create and stylize these around columns, posts, groups of posts or menu links as needed<br></p>'); 
		printer::spanclear(5);
		echo'<p class="editfont left5 editbackground editfont"> outline Line Thickness:
		<select class="editcolor editbackground editfont"  name="'.$style.'['.$val.'][0]" >        
		<option  value="'.$outline_array[0].'" selected="selected">'.$outline_array[0].$px.'</option>';
		for ($i=0; $i< 81; $i+=1){
			echo '<option  value="'.$i.'">'.$i.$px.'</option>';
			}
		 echo'	
		</select></p>';
		printer::spanclear(5);
		$span_color=(!empty($outline_array[1]))?'<span class="fs1npred" style="background-color:#'.$outline_array[1].';">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>':''; 
		printer::alert('Set outline Color Here.  Use 0 or non color to remove outline<input onclick="jscolor.installByClassName(\'outline_id'.$inc.'_'.self::$xyz.'\');" style="cursor:pointer;background:#'.$this->editor_background.';color:#'.$this->editor_color.';" type="text" name="'.$style.'['.$val.'][1]" id="outline_id'.$inc.'_'.self::$xyz.'" value="'.$outline_array[1].'" size="12" maxlength="6" class="outline_id'.$inc.'_'.self::$xyz.' {refine:false}">'.$span_color.'<span style="font-size: 1.1em; color: yellow;" id="outline_id'.$inc.'_'.self::$xyz.'instruct"></span><br>',false,'left editcolor editbackground editfont'); 
		echo'<p class="left '.$this->column_lev_color.'">Set outline Type Currently: '.$outline_array[2].'<br>
		<span class="editcolor editbackground editfont">outline Type:</span>
		<select class="editcolor editbackground editfont"  name="'.$style.'['.$val.'][2]" >        
		<option  value="'.$outline_array[2].'" selected="selected">'.$outline_array[2].'</option>'; 
		foreach ($outline_types as $type){
			echo'<option  value="'.$type.'">'.$type.'</option> ';
			}
          $this->submit_button();
		echo '</select></p>';
		echo '</div><!--  outline style-->';
		printer::spanclear(5);
          printer::close_print_wrap('outline style');
		$this->show_close('Style Table params');//<!--Show More outline Style Table params-->'; 
		}//if editable
	$fstyle='final_'.$style; 
	$this->{$fstyle}[$val]=(preg_match(Cfg::Preg_color,$blog_outline_color))?$this->{$style}[$val]='outline-width: '.$outline_width.'px; outline-style:'. $blog_outline_type.'; outline-color:  #'.$blog_outline_color.';':'';//this
	}//end fun outlines

function box_shadow($style, $val,$field){
	static $inc=0;  $inc++;   
	if (arrayhandler::is_empty_array($this->{$style}[$val])){ 
		$shadow_array=array();
		for ($i=0; $i<10;$i++){ 
			$shadow_array[$i]=0;
			}
		}
	else	{ //note that input type text will give 0value for defaults...
		$shadow_array=explode('@@',$this->{$style}[$val]);
		for ($i=0; $i<10;$i++){ 
			if (!array_key_exists($i,$shadow_array)){
				$shadow_array[$i]=0;
				}
			}
		}
	$shadowbox_opacity=(!empty($shadow_array[$this->shadowbox_opacity_index])&&$shadow_array[$this->shadowbox_opacity_index]<100&&$shadow_array[$this->shadowbox_opacity_index]>0)?$shadow_array[$this->shadowbox_opacity_index]:100;
	$shadowbox_units=($shadow_array[$this->shadowbox_units_index]==='px'||$shadow_array[$this->shadowbox_units_index]==='rem'||$shadow_array[$this->shadowbox_units_index]==='em')?$shadow_array[$this->shadowbox_units_index]:'px';
	$shadowbox_blur_radius= (empty($shadow_array[$this->shadowbox_blur_radius_index]))? 0:$shadow_array[$this->shadowbox_blur_radius_index];
	$shadowbox_spread_radius= (empty($shadow_array[$this->shadowbox_spread_radius_index]))? 0:$shadow_array[$this->shadowbox_spread_radius_index];
	$shadowbox_horiz_offset= (empty($shadow_array[$this->shadowbox_horiz_offset_index]))? 0:$shadow_array[$this->shadowbox_horiz_offset_index];
	$shadowbox_insideout= ($shadow_array[$this->shadowbox_insideout_index]==='inset')? 'inset':(($shadow_array[$this->shadowbox_insideout_index]==='outset')? '':'forceoff');
	$shadowbox_color = (preg_match(Cfg::Preg_color,$shadow_array[$this->shadowbox_color_index]))?$shadow_array[$this->shadowbox_color_index]:'';
	$shadowbox_vert_offset= (empty($shadow_array[$this->shadowbox_vert_offset_index]))? 0:$shadow_array[$this->shadowbox_vert_offset_index];
	$units_name=$style.'['.$val.']['.$this->shadowbox_units_index.']';
	$horiz_name=$style.'['.$val.']['.$this->shadowbox_horiz_offset_index.']';
	$vert_name=$style.'['.$val.']['.$this->shadowbox_horiz_offset_index.']';
	$blur_radius_name=$style.'['.$val.']['.$this->shadowbox_blur_radius_index.']';
	$spread_radius_name=$style.'['.$val.']['.$this->shadowbox_spread_radius_index.']';
	if (!preg_match(Cfg::Preg_color,$shadow_array[$this->shadowbox_color_index]))$shadow_array[$this->shadowbox_color_index]="0";
	if ($this->is_page|| ($this->is_blog&&!$this->is_clone)||($this->is_column&&!$this->is_clone||$this->clone_local_style)){  
		$this->show_more('Box Shadow', 'noback','editfont highlight editbackground editfont',' add a Shadow around this text or image post',500);  
		$this->print_redwrap('Box shadow',false);
		printer::print_wrap1('shadowbox units');
		printer::print_tip('By Default shadow-box units are in px. Change units here if you wish to em or rem. ');
		forms::form_dropdown(array('px','em','rem'),'','','',$units_name,$shadowbox_units,false);
	 
	printer::close_print_wrap1('text shadow units');
		echo '<p class="fbs1info '.$this->column_lev_color.' editbackground editfont">We have used a maroon box shadow effect on the bottom right of this text. <span class="highlight" title="Blur Radius: 7px; Spread Radius -6px; Horizontal Offset: 4px; Vertical Offset: 4px; Color:#f7f2a8;">See Settings</span> for this box shadow!<br>Like Borders, Box Shadows provide styling around a Column Post or Menu Link Area, though providing a customizable shadow instead. For a quick overview  and examples see <a href="http://css-tricks.com/snippets/css/css-box-shadow/">Shadow Examples.</a>  </p>';
		printer::pclear(8);
		echo '<p class="fsminfo editbackground editfont rad3 floatleft '.$this->column_lev_color.' editfont">Shadow may be an outside box shadow (recommended for styling directly around images or an inside box shadow :<br> ';
          $checked2=($shadowbox_insideout==='inset')?'checked="checked"':''; 
          $checked1=($shadowbox_insideout!=='inset'&&$shadowbox_insideout!=='forceoff')?'checked="checked"':'';
          $checked3=($shadowbox_insideout==='forceoff')?'checked="checked"':''; 
          printer::alert('<input type="radio" value="outset" '.$checked1.' name="'.$style.'['.$val.']['.$this->shadowbox_insideout_index.']">Choose Outside Box Shadow');
          printer::alert('<input type="radio" value="inset" '.$checked2.' name="'.$style.'['.$val.']['.$this->shadowbox_insideout_index.']">Choose Inside Box Shadow');
          printer::alert('<input type="radio" value="forceoff" '.$checked3.' name="'.$style.'['.$val.']['.$this->shadowbox_insideout_index.']">Turn off Box Shadow </p>'); 
          printer::pspace(4); 
		echo ' <p class="fsminfo editbackground editfont rad3 '.$this->column_lev_color.' editfont">The blur radius: 
		If set to 0 the shadow will be sharp, the higher the number, the more blurred it will be: ';
		echo ' <span class="'.$this->column_lev_color.' left5 editbackground editfont">Currently '.$shadowbox_blur_radius.'units</span><br>
		<span class="editcolor editbackground editfont">Choose Blur Radius:</span>';
		 $this->mod_spacing($blur_radius_name,$shadowbox_blur_radius,0,30,.01,'units');
		echo '<p class="fsminfo editbackground editfont rad3 '.$this->column_lev_color.' editfont">The spread radius gives all sides even shadow width: A positive values increase the size of the shadow
		 whereas negative values decrease the size: ';
		echo ' <span class="'.$this->column_lev_color.' left5 editbackground editfont">Currently '.$shadowbox_spread_radius.'</span><br>
		<span class="editcolor editbackground editfont">Choose New Spread Radius:</span>';
		$this->mod_spacing($spread_radius_name,$shadowbox_spread_radius,-5,30,.01,'units');
		echo '<p class="fsminfo editbackground editfont rad3 '.$this->column_lev_color.' editfont">Box Shadow Horizonal offet, more negative value  means more on left side of the box, positive right: '; 
          echo '<span class="'.$this->column_lev_color.' left5 editbackground editfont">Currently '.$shadowbox_horiz_offset.'</span><br> 
	    <span class="editcolor editbackground editfont left">Choose: Horizontal offset:</span>';
	     $this->mod_spacing($horiz_name,$shadowbox_horiz_offset,-30,30,.01,'units');
		echo '<p class="fsminfo editbackground editfont rad3 '.$this->column_lev_color.' editfont">Box Shadow Vertical offet, more negative value means more above the box, more positive more below: ';
		echo '   <span class="'.$this->column_lev_color.' left5  editbackground editfont">Currently '.$shadowbox_vert_offset.'</span><br>
		<span class="editcolor editbackground editfont">Choose: Vertical offset:</span>';
		$this->mod_spacing($vert_name,$shadowbox_vert_offset,-30,30,.01,'units');
		
		echo '<p class="fsminfo editbackground editfont rad3 '.$this->column_lev_color.' editfont">Use 0 to remove box shadow<br>You Color Choice Can Also Produce a More or Less Subtle Shadow Effect!:</p> ';
		$span_color=(!empty($shadowbox_color))?'<span class="fs1npred" style="background-color:#'.$shadowbox_color.';">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>':''; 
		if (preg_match(Cfg::Preg_color,$shadowbox_color)){
			$msg="Change the Current Shadow-box Color: #";
			}
		else {
			$msg= (!empty($shadowbox_color))?$shadowbox_color . ' is not a valid color code. Enter a new shadow color code: #':'Enter a box-shadow color code: #';
			}
		printer::alert($msg.'<input onclick="jscolor.installByClassName(\''.$style.'-'.$val.$inc.'\');" style="cursor:pointer;background:#'.$this->editor_background.';color:#'.$this->editor_color.';" type="text" name="'.$style.'['.$val.']['.$this->shadowbox_color_index.']" id="'.$style.'-'.$val.$inc.'" value="'. $shadowbox_color.'" size="6" maxlength="6" class="'.$style.'-'.$val.$inc.' {refine:false}">'.$span_color); 
		printer::print_wrap1('shadowbox opacity');
          echo '<p class="editcolor editbackground editfont ">Change Shadow-box Opacity: '.$shadowbox_opacity.'% </p>';
		$this->mod_spacing($style.'['.$val.']['.$this->shadowbox_opacity_index.']',$shadowbox_opacity,0,100,1,'%');
          printer::close_print_wrap1('shadowbox opacity');
		$this->submit_button();
		printer::close_print_wrap('Box shadow');
		$this->show_close('edit shadow');//'edit shadow'
		}
	if (!empty($shadowbox_color)){
		if ($shadowbox_opacity <100) 
			$sb_color=process_data::hex2rgba($shadowbox_color,$shadowbox_opacity);
		else $sb_color='#'.$shadowbox_color; 
		$shadowcss='-moz-box-shadow:'.$shadowbox_insideout.' '.$shadowbox_horiz_offset.$shadowbox_units.' '.$shadowbox_vert_offset.$shadowbox_units.' '.$shadowbox_blur_radius.$shadowbox_units.' '.$shadowbox_spread_radius.$shadowbox_units.' '. ' '. $sb_color.';  
	-webkit-box-shadow:'.$shadowbox_insideout.'  '.$shadowbox_horiz_offset.$shadowbox_units.' '.$shadowbox_vert_offset.$shadowbox_units.' '.$shadowbox_blur_radius.$shadowbox_units.' '.$shadowbox_spread_radius.$shadowbox_units.' '. ' '. $sb_color.';   
	box-shadow:'.$shadowbox_insideout.'  '.$shadowbox_horiz_offset.$shadowbox_units.' '.$shadowbox_vert_offset.$shadowbox_units.' '.$shadowbox_blur_radius.$shadowbox_units.' '.$shadowbox_spread_radius.$shadowbox_units.' '. ' '. $sb_color.';';  
		}
	else  
		$sb_color='';
	
	$intial='-moz-box-shadow:initial; -webkit-box-shadow: initial; box-shadow:initial;';//initial for default none
	$shadowcss= (empty($sb_color))?'':(($shadowbox_insideout==='forceoff')?'box-shadow:none;':$shadowcss); 
	$fstyle='final_'.$style;
	$this->{$fstyle}[$val]=$shadowcss;
	}
	
function text_shadow($style, $val,$field){
	static $inc=0;  $inc++;
	$shadarr=array('shadow_horiz_offset','shadow_vert_offset','shadow_blur_radius','shadow_color','shadow_opacity','shadow_units','important');
	$count=count($shadarr);
	if (arrayhandler::is_empty_array($this->{$style}[$val])){//default may be set to 1
		$shadow_array=array();
		for ($i=0; $i<$count;$i++){ 
			$shadow_array[$i]=0;
			}
		}
	else	{ //note that input type text will give 0value for defaults...
		$shadow_array=explode('@@',$this->{$style}[$val]);
		for ($i=0; $i<$count;$i++){ 
			if (!array_key_exists($i,$shadow_array)){
				$shadow_array[$i]=0;
				}
			}
		}
	foreach($shadarr as $key =>$index){
		${$index.'_index'}=$key; 
		}
	$shadow_units=($shadow_array[$shadow_units_index]==='px'||$shadow_array[$shadow_units_index]==='rem'||$shadow_array[$shadow_units_index]==='em')?$shadow_array[$shadow_units_index]:'px';
	$important=($shadow_array[$important_index]==='important_shadow_on')?true:false;
	$shadow_horiz_offset= (empty($shadow_array[$shadow_horiz_offset_index]))? 0:$shadow_array[$shadow_horiz_offset_index];
	$shadow_vert_offset= (empty($shadow_array[$shadow_vert_offset_index]))? 0:$shadow_array[$shadow_vert_offset_index];
	$shadow_blur_radius= (empty($shadow_array[$shadow_blur_radius_index]))? 0:$shadow_array[$shadow_blur_radius_index];
	$shadow_opacity=(!empty($shadow_array[$shadow_opacity_index])&&$shadow_array[$shadow_opacity_index]<100&&$shadow_array[$shadow_opacity_index]>0)?$shadow_array[$shadow_opacity_index]:100;
	
     $shadow_color = (preg_match(Cfg::Preg_color,$shadow_array[$shadow_color_index]))?$shadow_array[$shadow_color_index]:'';
	$horiz_name=$style.'['.$val.']['.$shadow_horiz_offset_index.']';
	$vert_name=$style.'['.$val.']['.$shadow_vert_offset_index.']';
	$blur_radius_name=$style.'['.$val.']['.$shadow_blur_radius_index.']';
	$units_name=$style.'['.$val.']['.$shadow_units_index.']';
	if ($this->is_page|| ($this->is_blog&&!$this->is_clone)||($this->is_column&&!$this->is_clone||$this->clone_local_style)){  
		echo'<div class="fsminfo '.$style.'_hidefont hide floatleft" ><!--text shadow-->';
          $this->show_more('Text Shadow','noback','highlight editbackground editfont','Add a Shadow to the text fonts',500);
          $this->print_redwrap('shadow group wrapper');
		printer::print_wrap1('text shadow units');
	printer::print_tip('By Default shadow units are in px. Change units here if you wish to em or rem. ');
     forms::form_dropdown(array('px','em','rem'),'','','',$units_name,$shadow_units,false);
	 
	printer::close_print_wrap1('text shadow units');
		 echo '
		<p class="fsminfo aqua textshadow">We have used a blue shadow color with this lighter blue text. <span class="highlight" title="Horizontal Offset: -1.4px; Vertical Offset: -1.4px; Blur Radius .8px;">Hover for View Settings</span> for this Text Shadow! For quick overview of using the css3 shadow feature and examples see <a target="_blank" href="http://css-tricks.com/snippets/css/css-text-shadow/">Text-shadow Examples</a> </p>';
		printer::pclear(8);
		echo' <div class="fsminfo editbackground editfont rad3 '.$this->column_lev_color.' editfont"><!--leftrightoffset-->Text Shadow Left/Right offet, more negative value  means more left, positive right:';
          echo'<p class="'.$this->column_lev_color.' left5 editbackground editfont">Currently '.$shadow_horiz_offset.$shadow_units.'<br>
		<span class="editcolor editbackground editfont">Choose: Horizontal offset:</span>';
		 $this->mod_spacing($horiz_name,$shadow_horiz_offset,-3,3,.01,'units');
		echo '</div><!--leftrightoffset-->';
		echo'<div class="fsminfo editbackground editfont rad3 '.$this->column_lev_color.' editfont"><!--vert offset-->Text Shadow Above/Below offet 
		More negative value  means more above the text 
		More positive value  more below:<br>';
		echo'<p class="'.$this->column_lev_color.' rad3 editbackground editfont">Currently '.$shadow_vert_offset.$shadow_units.'<br>
		<span class="editcolor editbackground editfont">Choose Vertical offset:</span>';
	     $this->mod_spacing($vert_name,$shadow_vert_offset,-3,3,.01,'units');
		echo '</div><!--vert offset-->';	
		echo'<div class="'.$this->column_lev_color.' fsminfo editbackground editfont rad3 editfont"><!--Blur length-->Set Shadow Blur Length: Currently '.$shadow_blur_radius.$shadow_units.'<br>';
		$this->mod_spacing($blur_radius_name,$shadow_blur_radius,0,6,.01,'units');
		echo'
		  </div><!--Blur length-->';
          
		if (!empty($shadow_color)){ 
			$msg="Change the Current Shadow Color:<br> #";
			}
		else {
			$msg= (!empty($shadow_array[$shadow_color_index]))?$shadow_array[$shadow_color_index]. ' is not a valid color code. Enter a new text-shadow color code:<br> #':'Enter a tex-shadow color code:<br> #';
			}
          
          $msg=$msg.printer::print_info('Use 0 to remove text-shadow',.9,1);
		$span_color=(!empty($shadow_color))?'<span class="fs1npred" style="background-color:#'.$shadow_color.';">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>':'';   
		echo '<div class="'.$this->column_lev_color.' fsminfo editbackground editfont">Edit the Text Shadow color <br><span class="editcolor editbackground editfont"><!--shadow text color-->'.$msg.'</span><input onclick="jscolor.installByClassName(\''.$style.'-'.$val.$inc.'\');" style="cursor:pointer;background:#'.$this->editor_background.';color:#'.$this->editor_color.';"   type="text" name="'.$style.'['.$val.']['.$shadow_color_index.']" id="'.$style.'-'.$val.$inc.'" value="'. $shadow_color.'" size="6" maxlength="6" class="'.$style.'-'.$val.$inc.' {refine:false}">'.$span_color;
		echo'</div><!--shadow text color-->';
		printer::print_wrap1('shadow opacity');
          echo '<p class="editcolor editbackground editfont ">Change Shadow Opacity: '.$shadow_opacity.'% </p>';
		$this->mod_spacing($style.'['.$val.']['.$shadow_opacity_index.']',$shadow_opacity,0,100,1,'%');
          printer::close_print_wrap1('shadow opacity');
		printer::print_wrap1('shadow important');
		printer::print_tip('the !important emphasis can be added to the font-shadow css and will overrule other css selector for the font-shadow including styling applied directly to the element. In general the !important modifier should be used only if abs needed');
		if ($important)  
			printer::alert('<input type="checkbox" name="'.$style.'['.$val.']['.$important_index.']" value="important_shadow_off">Turn Off !important css override' );
		else
			printer::alert('<input type="checkbox" name="'.$style.'['.$val.']['.$important_index.']" value="important_shadow_on">Turn On !important css override' );
          printer::close_print_wrap1('shadow important');
		$this->submit_button();
          printer::close_print_wrap('shadow group wrapper');
		$this->show_close('text shadow');
		echo'</div><!--text shadow-->';
		}
	if (!empty($shadow_color)){
		if ($shadow_opacity <100) 
			$sb_color=process_data::hex2rgba($shadow_color,$shadow_opacity);
		else $sb_color='#'.$shadow_color; 
		}
	else  
		$sb_color='';
	$add_important=($important)?'!important':'';
	$shadowcss= (empty($shadow_color)||(empty($shadow_blur_radius)))?'':'text-shadow: '.$shadow_horiz_offset.$shadow_units.' '.$shadow_vert_offset.$shadow_units.' '.$shadow_blur_radius.$shadow_units.' '. $sb_color.$add_important.';'; 
	$fstyle='final_'.$style;
	$this->{$fstyle}[$val]=$shadowcss;
	}//end text shadow
     
function overflow($type,$data){
     $this->show_more('Set '.$type.' Overflow Property');
     printer::print_redwrap('overflow');
     printer::print_tip('Choose overflow property. By default height is will automatically adjust to content and most width options will automatically adjust to available width. Hoever, Setting a direct height or width property may overflow the parent element and byfault overflow will be visible. But you can set overflow of content to scroll or be hidden for the post.  Note: Images in responsive mode automatically resize image image so no scroll bars used there.<br>');
     printer::print_wrap1('overflowx');
     printer::alert('Choose overflow-x direction for width');
     $overflow_arr=array('hidden','visible','scroll','auto');
     $overflowx=(in_array($this->{$type.'_options'}[$this->{$type.'_overflowx_index'}],$overflow_arr))?$this->{$type.'_options'}[$this->{$type.'_overflowx_index'}]:'';
     $overflowy=(in_array($this->{$type.'_options'}[$this->{$type.'_overflowy_index'}],$overflow_arr))?$this->{$type.'_options'}[$this->{$type.'_overflowy_index'}]:'';
	$checked='checked="checked"';
	$check1=($overflowx==='hidden')?$checked:'';
	$check2=($overflowx==='scroll')?$checked:'';
	$check3=(empty($overflowx)||$overflowx==='visible')?$checked:'';	
	$check4=($overflowx==='auto')?$checked:'';	  
	printer::alert('<input type="radio"  name="'.$data.'_'.$type.'_options['.$this->{$type.'_overflowx_index'}.']" value="hidden" '.$check1.'>hidden');
	printer::alert('<input type="radio"  name="'.$data.'_'.$type.'_options['.$this->{$type.'_overflowx_index'}.']" value="scroll" '.$check2.'>scroll');
	printer::alert('<input type="radio"  name="'.$data.'_'.$type.'_options['.$this->{$type.'_overflowx_index'}.']" value="visible" '.$check3.'>visible');
	printer::alert('<input type="radio"  name="'.$data.'_'.$type.'_options['.$this->{$type.'_overflowx_index'}.']" value="auto" '.$check4.'>auto');
     printer::close_print_wrap1('overflowx');
     printer::print_wrap1('overflowy'); 
     printer::alert('Choose overflow-y direction for height');
     $check1=($overflowy==='hidden')?$checked:'';
	$check2=($overflowy==='scroll')?$checked:'';
	$check3=(empty($overflowy)||$overflowy==='visible')?$checked:'';	
	$check4=($overflowy==='auto')?$checked:'';	  
	printer::alert('<input type="radio"  name="'.$data.'_'.$type.'_options['.$this->{$type.'_overflowy_index'}.']" value="hidden" '.$check1.'>hidden');
	printer::alert('<input type="radio"  name="'.$data.'_'.$type.'_options['.$this->{$type.'_overflowy_index'}.']" value="scroll" '.$check2.'>scroll');
	printer::alert('<input type="radio"  name="'.$data.'_'.$type.'_options['.$this->{$type.'_overflowy_index'}.']" value="visible" '.$check3.'>visible');
	printer::alert('<input type="radio"  name="'.$data.'_'.$type.'_options['.$this->{$type.'_overflowy_index'}.']" value="auto" '.$check4.'>auto');
     $css_id=($type==='blog')?$this->dataCss:$this->col_dataCss;
     printer::close_print_wrap1('overflowy');  
     $css='';
     if(!empty($overflowx)||!empty($overflowy)){
          $overflowx=(!empty($overflowx))?'overflow-x:'.$overflowx.';':'';
          $overflowy=(!empty($overflowy))?'overflow-y:'.$overflowy.';':'';
		$this->css.=$css.= '.'.$css_id.'{'.$overflowx.$overflowy.'}';
		}
     $this->show_more('Style info','','info italic smaller');
     printer::print_wrap1('techinfo');
     printer::print_info('Current setting Css: '.$css);
     $msg='Changes default css overflow x direction and y direction properties.';
     printer::print_info($msg);
     printer::close_print_wrap1('techinfo');
     $this->show_close('Tech info');
     
     printer::close_print_wrap('overflow');
     $this->show_close('Set Post Overflow Property');
     }
     
function custom_style($style, $val,$field=''){
	$media_indexes=array('suffix','customcss','max','min','orientation','operator');
	foreach($media_indexes as $key  => $index){
		${$index.'_index'}=$key;
		}  
     if (strpos($field,'tiny')){
          $count=strlen(implode(',',$this->$style));
          if ($count > 255){
                $msg='This element being styled using db tinytext field: '.$field.' holds only 255 characters only and currently at  '.$count.' which means data especially custom_styling if any is truncated';
          $this->message[]=$msg;
               }
          elseif ($count>225){
               $msg='This element being styled using db tinytext field: '.$field.' holds only 255 characters only and currently at  '.$count;
               printer::alert_neg($msg);
               }
          else if ($count >200){
               $msg='This element being styled using db tinytext field: '.$field.' holds only 255 characters only and currently at  '.$count;
               printer::alert_neu($msg);
               }
          }
     #note: display property and advanced styles use css #id to override normal styles which use distinct classnames
	static $topinc=0; $topinc++; 
	$idref=($this->is_column)?$this->col_dataCss:(($this->is_blog)?$this->dataCss:$this->pagename);
	$localprefix='';  
	if($this->is_page) 
		$db_table=$this->master_page_table;
	elseif ($this->is_column&&!$this->clone_local_style)
		$db_table=$this->master_col_table;
	elseif ($this->is_column){
		$localprefix='c';
		$db_table=$this->master_col_css_table;
		}
	elseif ($this->is_blog&&!$this->clone_local_style)
		$db_table=$this->master_post_table;
	else {
		$db_table=$this->master_post_css_table;
		$localprefix='p';
		} 
	$ref_id=($this->is_page)?'page_id':(($this->is_column)?'col_id':'blog_id');
	
	################################### Maintenance Facility Only #########
     if (array_key_exists($this->temp_replace_index,$this->{$style})&&!empty($this->{$style}[$this->temp_replace_index])){
          //here we need to update custom_style to new Cfg::Style_function index using old index ie temp_replace and transfer to index at end of list.. for all style fields in all tables which otherwise is a big task..but this style is unlike any others in that it directly updates through mysql query so we tap into that with little effort.
          $this->{$style}[$val]=$this->{$style}[$this->temp_replace_index]; 
          $this->{$style}[$this->temp_replace_index]='';
          $implode_style_arr=implode(',',$this->{$style});
		$ref=($this->is_page)?'page_':(($this->is_column)?'col_':'blog_');
		$q="update $db_table set $field='$implode_style_arr',{$ref}time='".time()."',{$ref}update='".date("dMY-H-i-s")."', token='".mt_rand(1,mt_getrandmax()). "' where $ref_id='$localprefix{$this->$ref_id}'"; 
		$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
          }
		########################End temp_replace updater
	$serial_data=$this->{$style}[$val]; 
     if (!empty($serial_data)&&$this->isSerialized($serial_data)){ 
		$media_added_style_arr=unserialize($serial_data);//for correct storage in style field value..
		$count=count($media_added_style_arr);
		}
	else {
		if (strlen($this->{$style}[$val]>6))echo serial_data. ' is not recognized as serialized';
		$count=0;
		$media_added_style_arr=array();
		} 
	//update submitted posts to database
      
	if (isset($_POST['media_added_style_'.$this->clone_ext.$field.'_'.$this->$ref_id])){
		foreach($_POST['media_added_style_'.$this->clone_ext.$field.'_'.$this->$ref_id] as $index => $array){
			if (array_key_exists($suffix_index,$array)) 
				$media_added_style_arr[$index][$suffix_index]=str_replace('<br>','break',process_data::spam_scrubber($array[$suffix_index],false,false));
			if (array_key_exists($customcss_index,$array)) 
				$media_added_style_arr[$index][$customcss_index]=str_replace('<br>','break',process_data::spam_scrubber($array[$customcss_index]));
			for ($ii=0; $ii<count($media_indexes);$ii++){ 
				if (array_key_exists($ii,$array)){//$array has only updated values!
					$media_added_style_arr[$index][$ii]=$array[$ii];
					}
				}	
			}
			print_r($media_added_style_arr[$index]);
		$arrhold=array();
		foreach ($media_added_style_arr as $index => $array){
			if (array_key_exists($customcss_index,$array)&&strlen($array[$customcss_index]) > 5) //here we omit empties..
				$arrhold[]=$array;
			}
		$media_added_style_arr=$arrhold;
		$update_val=str_replace(',','=>',serialize($arrhold));//
		$style_arr=$this->$style;
		for ($i=0; $i<count(explode(',',Cfg::Style_functions)); $i++){ 
			if (!array_key_exists($i,$style_arr)){  
				$style_arr[$i]='';
				}
			} 
		$style_arr[$this->custom_style_index]=$update_val; 
		$implode_style_arr=implode(',',$style_arr);
		$ref=($this->is_page)?'page_':(($this->is_column)?'col_':'blog_');
		$q="update $db_table set $field='$implode_style_arr',{$ref}time='".time()."',{$ref}update='".date("dMY-H-i-s")."', token='".mt_rand(1,mt_getrandmax()). "' where $ref_id='$localprefix{$this->$ref_id}'"; 
		$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
		}//if submitted
	//end update
	
	if ($this->is_page|| ($this->is_blog&&!$this->is_clone)||($this->is_column&&!$this->is_clone||$this->clone_local_style)){
		 $this->show_more('Advanced Styling Options','','highlight editbackground editfont highlight editstyle','Manually enter Css &amp; Css @media Rules Here');
		$ptype=($this->is_page)?' body&#123;&#125;':(($this->is_column)?'this column':'this post');
     $this->print_redwrap('advanced style');
	echo '<div><!--custom style-->';
	echo '<div class="Od2olivedrab fsminfo editbackground editfont '.$this->column_lev_color.' "><!--custom style inner-->';
		printer::printx('<span class="warn1 redAlert ">Caution: Adding curly brackets {} can potentially Break all following CSS Styling</span>');
		printer::print_tip('Custom Css Rules Specific For this <b>'.$ptype.'</b> can be manually entered here. Append any further css specificity under suffix. Additionally Choose to add @media screen max-width and min-width media query-css entries for each grouping of custom css properties you add. New  Fields will appear as needed if additional entries are required. Removing Custom Css will delete the field. <br><span class="whitebackground green">Additionally you can change the behavior so the system generates a series of media queries spanning the max-width and min-width values you selected. See the option below!</span><br><br><span style="background: rgba(255,255,255,.33)"> <b>Media Query, Classname and {} will be entered automatically</b></span>');
		$count=$count+4;
		
		#mediafor
		$newref=(!$this->is_page)?str_replace('.'.$idref,'#'.$idref,$this->pelement):$this->pelement;//so here we switch class to ids. same name diff prefix is all!
		for ($i=0; $i < $count; $i++){
			if (!array_key_exists($i,$media_added_style_arr)){
				$media_added_style_arr[$i]=array();
				}
			$media_arr=$media_added_style_arr[$i];
			for ($ii=0; $ii<count($media_indexes);$ii++){ 
				if (!array_key_exists($ii,$media_arr)){
					$media_arr[$ii]='';
					}
				}
			$class_suffix=(!is_numeric($media_arr[$suffix_index]))?$media_arr[$suffix_index]:'';
               $css_class_id=$newref.$class_suffix;// 
			$customcss=str_replace('=>',',',str_replace('break',"\n",$media_arr[$customcss_index]));
			
			$max_name='media_added_style_'.$this->clone_ext.$field.'_'.$this->$ref_id.'['.$i.']['.$max_index.']';
			$min_name='media_added_style_'.$this->clone_ext.$field.'_'.$this->$ref_id.'['.$i.']['.$min_index.']';
			$orientation_name='media_added_style_'.$this->clone_ext.$field.'_'.$this->$ref_id.'['.$i.']['.$orientation_index.']';
			$operator_name='media_added_style_'.$this->clone_ext.$field.'_'.$this->$ref_id.'['.$i.']['.$operator_index.']';
			echo '<div class="editbackground editfont"><!--media array wrap-->';
			echo '<div class="fs2orange editbackground editfont"><!--array wrapper media inner-->';
			echo '<div class="fs1green editbackground editfont editcolor"><!--array wrapper media css-->';
			printer::printx('<p class="info floatleft">'.$css_class_id.'</p>'); 
			echo '<div class="floatleft"><!--floatwrap css suffix-->';
			if (empty($class_suffix))$this->show_more('Selector Suffix Option','','tiny info','Add a class suffix');
			$msg=(empty($class_suffix))?'Add optional additional class specifier Here: ':'';
			echo '<p class="editbackground editfont editcolor">'.$msg.'<input type="text" name="media_added_style_'.$this->clone_ext.$field.'_'.$this->$ref_id.'['.$i.'][0]" value="'.$class_suffix.'" size="30" maxlength="100"></p>';
			printer::pclear();
			if (empty($class_suffix))$this->show_close('suffix');
			printer::pclear();
			echo '</div><!--floatwrap css suffix-->';
			printer::pclear();
			printer::printx('<p>&#123;</p>');
			printer::pclear();
			$this->textarea($customcss,'media_added_style_'.$this->clone_ext.$field.'_'.$this->$ref_id.'['.$i.']['.$customcss_index.']','600','16');
			printer::spanclear();
			printer::printx('<p>&#125;</p>');
			echo '</div><!--array wrapper media css-->';
			$mediaopen=$this->mediaAddCss($media_arr,$max_index,$min_index,$orientation_index,$operator_index,$max_name,$min_name,$orientation_name,$operator_name,true,false,true); 
			echo '</div><!--array wrapper media inner-->';
			$this->submit_button();
			echo '</div><!--array wrapper media-->';
			printer::pclear();
			//render css
			$class_suffix=(!empty($class_suffix))?str_replace('=>',',',$class_suffix):'';
			$customcss=(!empty($media_arr[$customcss_index]))?str_replace(array('break','<br>'),"\n",str_replace('=>',',',$media_arr[$customcss_index])):'';//for correct storage in style field value. restore line break from scrub above..
			
			//so here we switch class to ids. for more css specificity same name diff prefix is all!//
			$css_class_id= $newref.$class_suffix; 
			if (empty($customcss))continue;
			if (empty($mediaopen)){ 
				$mediacss=
				$css_class_id.'{'.$customcss.'}';
				}
			else {
				$mediacss=$mediaopen.'{
		'.$css_class_id.'{'.$customcss.'}
			}';
				;
				}
			$this->css.=$mediacss;//this css outside of other style grouping media begin and finishing
			$this->advancedstyles[$this->pelement]=$mediacss; 
			}// end for loop
		printer::printx('<p class="fsminfo tip smaller">Note: Page Related Css &amp; Modified Custom functions affecting only this page may be made in: <b>includes/'.$this->pagename.'.class.php</b><br>Custom css and functions affecting pages site-wide may be made in: <b>includes/site_master.class.php</b></p>');
		echo '</div><!--custom style inner-->'; 
		printer::pclear();
		echo '</div><!--custom style-->';
          printer::close_print_wrap('advanced style');
		$this->show_close('Advanced Styling Options');
		}//if editable 
	printer::pclear();
	}//end custom style
     
#CLASS VERSION
function animate_class($style, $val,$field='',$msg='Class Animate Element'){
	$animationindexes=explode(',',Cfg::Animation_options);
	foreach($animationindexes as $key =>$index){
		${$index.'_index'}=$key;
		}  
	if (empty($this->{$style}[$val])){ 
		$options=array();
		 for ($i=0; $i<count($animationindexes);$i++){ 
			$options[$i]=0;
			}
		}
	else	{   
		$options=explode('@@',$this->{$style}[$val]);
		for ($i=0; $i<count($animationindexes);$i++){ 
			if (!array_key_exists($i,$options)){
				$options[$i]=0;
				}
			 }
		}
	$max_duration=10;
	$max_delay=20;
	$max_repeat=15;
	$max_height=100;
	$max_width=2000;
	$min_width=200;
	$max_prior_delay=30;
	$default_animate_height=80;
	$max_animate_lock=4;
	$msg='Configure Animation type and Optionally change default settings here!';
	$anim_data=($this->is_column)?$this->col_dataCss:$this->dataCss;
	$anim_name=$style.'['.$val.']';
	$type=($this->is_column)?'Column':'Post';
	$id_ref=$this->pelement;
	$animation_arr=explode(',',Cfg::Animation_types); 
	$this->show_more($type.' Animations','','highlight click editbackground editfont','',300);
	$this->print_redwrap('wrap animations',true);
     $this->submit_button();
	$animate_type=(in_array($options[$animate_type_index],$animation_arr,true))?$options[$animate_type_index]:'none';  
	$animate_visibility=($options[$animate_visibility_index]==='hidden')?'hidden':(($options[$animate_visibility_index]==='nodisplay')?'nodisplay':'visible'); 
	$animate_repeats=($options[$animate_repeats_index]==='infinite'||(is_numeric($options[$animate_repeats_index])&&($options[$animate_repeats_index]>0&&$options[$animate_repeats_index]<=$max_repeat)))?$options[$animate_repeats_index]:'1'; 
	$animate_duration=(is_numeric($options[$animate_duration_index])&&$options[$animate_duration_index]>=.05&&$options[$animate_duration_index]<=$max_duration)?$options[$animate_duration_index]:1; 
	$animate_prior_delay=(is_numeric($options[$animate_prior_delay_index])&&$options[$animate_prior_delay_index]>=0&&$options[$animate_prior_delay_index]<=$max_prior_delay)?$options[$animate_prior_delay_index]:0; 
	$animate_height=($options[$animate_height_index]==='none'||(is_numeric($options[$animate_height_index])&&$options[$animate_height_index]>0&&$options[$animate_height_index]<=$max_height))?$options[$animate_height_index]:$default_animate_height; 
	$animate_width=(is_numeric($options[$animate_width_index])&&$options[$animate_width_index]>=$min_width&&$options[$animate_width_index]<=$max_width)?$options[$animate_width_index]:'none';
	$animate_final_display=($options[$animate_final_display_index]==='displaynone')?'displaynone':(($options[$animate_final_display_index]==='visibleoff')?'visibleoff':'visible');
 	 $css='';
     if ($animate_type!=='none'){ 
           echo "
          <!--$this->pagename.js script @ animate_class $id_ref-->
          ";
          
          $script= <<<eol
          
          
     //Animate Text Class $animate_type special animate class $id_ref
     jQuery('$id_ref').attr('data-hchange','$animate_height');
     jQuery('$id_ref').addClass('animated');
     gen_Proc.check_if_in_view();
          
eol;
		$this->handle_script_edit($script,'animate_class','script');
          if (!empty($animate_width)&&is_numeric($animate_width)) {#all goes within min-width specification
			$this->css.=$css.='
			@media screen and (min-width:'.$animate_width.'px){   
				'; 
			}
		if ($animate_visibility ==='hidden'){
			$this->css.=$css.='
			 .webmode'.$id_ref.'{visibility:hidden;}
			 '.$id_ref.'.in-view{visibility:visible;}
			'; 
			$this->editoverridecss.='
			html div#'.$id_ref.'{visibility:visible;}
			html div.'.$id_ref.' textarea{visibility:visible;} 
			';
			} 
		if ($animate_visibility ==='nodisplay'){
			$this->css.=$css.='
			 '.$id_ref.'{display:none;}
			 '.$id_ref.'.in-view{display:'.$this->display_edit_data.';}
			';
			} 
			 
		
		$this->css.=$css.='
		  '.$id_ref.'.in-view{
		 -webkit-animation-name: '.$animate_type.';
		animation-name: '.$animate_type.'; 
		animation-duration: '.$animate_duration.'s;
		-webkit-animation-duration: '.$animate_duration.'s;
		-moz-animation-duration:'.$animate_duration.'s;
		animation-iteration-count: '.$animate_repeats.';
		-webkit-animation-iteration-count: '.$animate_repeats.';
		-moz-animation-iteration-count: '.$animate_repeats.';
		-webkit-animation-delay: '.$animate_prior_delay.'s;
		-moz-animation-delay: '.$animate_prior_delay.'s;
		animation-delay: '.$animate_prior_delay.'s;
		}
		';
          
              
		if (!empty($animate_width)&&is_numeric($animate_width)) {
			$this->css.=$css.='
			}';//close bracket for @media css
			}
		}//if animate_type !==none
     for ($i=1; $i <4; $i++){//animation_max3,animation_min3,animation_type3
          ${'animate_visibility'.$i}=($options[${'animate_visibility'.$i.'_index'}]==='hidden')?'hidden':(($options[${'animate_visibility'.$i.'_index'}]==='nodisplay')?'nodisplay':'visible'); 
          ${'animate_type'.$i}=(in_array($options[${'animate_type'.$i.'_index'}],$animation_arr,true))?$options[${'animate_type'.$i.'_index'}]:'none';
          ${'animate_max'.$i}=(is_numeric($options[${'animate_max'.$i.'_index'}])&&$options[${'animate_max'.$i.'_index'}]>=$min_width&&$options[${'animate_max'.$i.'_index'}]<=$max_width)?$options[${'animate_max'.$i.'_index'}]:'none';
          ${'animate_min'.$i}=(is_numeric($options[${'animate_min'.$i.'_index'}])&&$options[${'animate_min'.$i.'_index'}]>=$min_width&&$options[${'animate_min'.$i.'_index'}]<=$max_width)?$options[${'animate_min'.$i.'_index'}]:'none';
          if ($animate_type!=='none'&&${'animate_type'.$i}!=='none'){ 
               if (${'animate_max'.$i} !=='none'||${'animate_min'.$i} !=='none'){
                    $max=(${'animate_max'.$i} !=='none')?' and (max-width:'.${'animate_max'.$i}.'px)':'';
                    if (${'animate_max'.$i} !=='none'||${'animate_min'.$i} !=='none'){
                         $min=(${'animate_min'.$i} !=='none')?' and (min-width:'.${'animate_min'.$i}.'px)':'';
                    $addcss='';
                         if (${'animate_visibility'.$i} ==='hidden'){
                              $addcss.='
                              #'.$id_ref.'{visibility:hidden;}
                              #'.$id_ref.'.active-anim.in-view{visibility:visible;}
                              '; 
                              $this->editoverridecss.='
                              html div#'.$id_ref.'{visibility:visible!important;}
                              html div#'.$id_ref.' textarea{visibility:visible!important;} 
                              ';  
                              } 
                         if (${'animate_visibility'.$i} ==='nodisplay'){
                              $addcss.='
                              #'.$id_ref.'{display:none;}
                              .'.$id_ref.'.active-anim.in-view{display:'.$this->display_edit_data.';}
                              ';
                              } //if no display
                    $this->css.=$css.=' 
@media screen '.$max.$min.'{  
		#'.$id_ref.'.in-view.active-anim{
		 -webkit-animation-name: '.${'animate_type'.$i}.';
		animation-name: '.${'animate_type'.$i}.';}
          '.$addcss.'
               }';
                         }//if
                    }//if
               }//if
          }//end for
     $this->show_more('Style info','','info italic smaller');
     printer::print_wrap1('techinfo');
     printer::print_info('Current setting Css: '.$css);
     $msg='Curent Css shown here is specific for main div id '.$id_ref.'. The general animation css in the animate.css file is adapted from the daneden git hub open source project.';
     printer::print_info($msg);
     printer::close_print_wrap1('techinfo');
     $this->show_close('Style info');
     $this->submit_button();
	$this->show_more('Control Initial visibility');	
	$this->print_redwrap('anim visibility'); 
	$checked1=($animate_visibility==='hidden')? 'checked="checked"':'';
	$checked2=($animate_visibility==='nodisplay')?'checked="checked"':'';
	$checked3=($animate_visibility!=='hidden'&&$animate_visibility!=='nodisplay')?'checked="checked"':''; 
	printer::print_tip('Initial visibility is naturally set at visible prior to animation start. For fading in and other types it may be advantageous to insure an initial visibility to hidden which hides visibilty but the original space remains until animation opacity css fadeIn is activated. Alternatively choose to display none which hides the element and removes its space until activated for animation<br>');
	printer::alert('<p class="editbackground editfont highlight" title="Set initial visibility to hidden to insure that the '.$type.' is hidden prior to scroll activation of animation;uses css (visibily:hidden) property"><input type="radio" '.$checked1.' name="'.$anim_name.'['.$animate_visibility_index.']" value="hidden">Insure Non visibility of Initial State<p>');
     printer::print_warn('No Display will not effect flex-item use non visible instead');
	printer::alertx('<p class="editbackground editfont highlight" title="Set '.$type.' initial display to display:none;"><input type="radio"  name="'.$anim_name.'['.$animate_visibility_index.']" value="nodisplay" '.$checked2.'>Use No Display No space State. <p>');
	printer::alertx('<p class="editbackground editfont highlight" title="No display change"><input type="radio"  name="'.$anim_name.'['.$animate_visibility_index.']" value="visible" '.$checked3.'>Use Normal Visible Display State<p>');	 
	printer::pclear(5); 
	printer::close_print_wrap('anim visibility');
	$this->show_close('Control Initial visibility');
	##################################
	$this->show_more('Enable '.$type.' Initial Animation','','',' ','800');
	$this->print_redwrap('inital wrap animate ',true);
	$this->print_wrap('animate type','editbackground editfont Os3salmon fsmaqua');
	printer::print_tip('Choose an Initial Animation Type Here. See below to optionally choose a follow-up animation type');
	printer::alert('Select animation type here:');
	echo '
	<!--animate.css -http://daneden.me/animate-->
	<select class="editcolor editbackground editfont" name="'.$anim_name.'['.$animate_type_index.']">
		<option value="'.$animate_type.'" selected="selected">'.$animate_type.'</option>';
          $this->animation_option();
          
          echo'</select>';
	 printer::close_print_wrap('animate type');
	
	printer::pclear(5);
	$this->show_more('@media query tweak Animation Type');
      printer::print_wrap('additional animate type','editbackground editfont Os3salmon fsmaqua');
	printer::print_tip('Choose up to 3 media query controlled max/min  to change the Animation Types here.');
     
     for ($i=1; $i<4; $i++){
          printer::print_wrap('for loop animate type');
          printer::print_tip('Set #'.$i);
          printer::print_wrap1('for loop maxwidth');
          printer::alert('@media max-width');
          $this->mod_spacing($anim_name.'['.${'animate_max'.$i.'_index'}.']',${'animate_max'.$i},$min_width,$max_width,1,'px','none');
	     
          printer::close_print_wrap1('for loop maxwidth');
          printer::print_wrap1('for loop minwidth');
          printer::alert('@media min-width');
          $this->mod_spacing($anim_name.'['.${'animate_min'.$i.'_index'}.']',${'animate_min'.$i},$min_width,$min_width,1,'px','none');
	 
          printer::close_print_wrap1('for loop minwidth');
          printer::pclear(5);
          printer::print_wrap('anim visibility'); 
          $checked1=(${'animate_visibility'.$i}==='hidden')? 'checked="checked"':'';
          $checked2=(${'animate_visibility'.$i}==='nodisplay')?'checked="checked"':'';
          $checked3=(${'animate_visibility'.$i}!=='hidden'&&${'animate_visibility'.$i}!=='nodisplay')?'checked="checked"':''; 
          printer::print_tip('If media query is selected for additional animation types then also chose initial display state again.');  
	##############33
	printer::alert('<p class="editbackground editfont highlight" title="Set initial visibility to hidden to insure that the '.$type.' is hidden prior to scroll activation of animation;uses css (visibily:hidden) property"><input type="radio" '.$checked1.' name="'.$anim_name.'['.${'animate_visibility'.$i.'_index'}.']" value="hidden">Insure Non visibility of Initial State<p>');
     printer::print_warn('No Display will not effect flex-item use non visible instead');
	printer::alertx('<p class="editbackground editfont highlight" title="Set '.$type.' initial display to display:none;"><input type="radio"  name="'.$anim_name.'['.${'animate_visibility'.$i.'_index'}.']" value="nodisplay" '.$checked2.'>Use No Display No space State<p>');
	printer::alertx('<p class="editbackground editfont highlight" title="No display change"><input type="radio"  name="'.$anim_name.'['.${'animate_visibility'.$i.'_index'}.']" value="visible" '.$checked3.'>Use Normal Visible Display State<p>');
      
          printer::pclear(5); 
          printer::close_print_wrap('anim visibility'); 
          printer::print_wrap1('for loop type');
          printer::alert('Select animation type here:');
          echo '
          <!--animate.css -http://daneden.me/animate-->
          <select class="editcolor editbackground editfont" name="'.$anim_name.'['.${'animate_type'.$i.'_index'}.']">
               <option value="'.${'animate_type'.$i}.'" selected="selected">'.${'animate_type'.$i}.'</option>';
          $this->animation_option();	
           echo '</select>';
          printer::close_print_wrap1('for loop type');
           printer::close_print_wrap('for loop animate type');
          }//end for loop
	 printer::close_print_wrap('additional animate type');
      $this->show_close('@media query tweak Animation Type');
	
     printer::pclear(5);	
	####################################-
	$this->print_wrap('anim height','editbackground editfont Os3salmon fsmaqua'); 
	printer::print_tip('Scrolling to the animation will trigger the start of the animation. Use none to turn off this feature.  However you can exactly set how far into the animationpace the trigger will kick off (if a sibling,parent,or id triger is also chosen both triggers must be true).. Setting a value of 1% will enable the height trigger just as the top of the animation element is scrolled to. Setting a value of none will set the height trigger immediately. Choosing a value of 100% for example sets the height trigger only when the scroll reaches the bottom of the element. The value is currently set to '.$animate_height.'%.'); 
	printer::alert('Change In-View Requirement element px depth for animation trigger:');
     $this->mod_spacing($anim_name.'['.$animate_height_index.']',$animate_height,1,$max_height,1,'%','none');
	printer::close_print_wrap('anim height'); 
     printer::pclear(5);
     ####################################-animate_complete_id
     ####################################-animate_complete_id
	$this->print_wrap('anim repeats','editbackground editfont Os3salmon fsmaqua'); 
	printer::print_tip('By default animations repeat once. You can change the default behavior here from 1 to 10 or infinite repeat! <br>');
	printer::alert('Select animation repeats here:');
	echo '
	<select class="editcolor editbackground editfont" name="'.$anim_name.'['.$animate_repeats_index.']">
	<option value="'.$animate_repeats.'" selected="selected">'.$animate_repeats.'</option>';
		for ($i=1; $i<$max_repeat+1; $i++ ){
			echo '<option value="'.$i.'">'.$i.'</option>';
			}
          echo'
          <option value="infinite">infinite</option>
		</select>'; 		 	 
	printer::close_print_wrap('anim repeats'); 	
	printer::pclear(5);
	$this->print_wrap('anim prior_delay','editbackground editfont Os3salmon fsmaqua'); 
	printer::print_tip('By default animation prior_delay is 0 second. Meaning once activated by scrolling/etc it will begin immediately<br>');
	printer::alert('Add initial startoff animation delay:');
	$this->mod_spacing($anim_name.'['.$animate_prior_delay_index.']',$animate_prior_delay,0,$max_prior_delay,.01,'sec');
	printer::close_print_wrap('anim prior_delay'); 	
	printer::pclear(5); 
	##################################
	$this->print_wrap('anim duration','editbackground editfont Os3salmon fsmaqua'); 
	printer::print_tip('By default animation duration is 1 second. <br>');
	printer::alert('Change initial animation speed:');
	$this->mod_spacing($anim_name.'['.$animate_duration_index.']',$animate_duration,.05,$max_duration,.05,'sec');
	printer::close_print_wrap('anim duration'); 	
	printer::pclear(5);
	##################################
	$this->print_wrap('anim width','editbackground editfont Os3salmon fsmaqua'); 
	printer::print_tip('You can set a minimum width for animating this '.$type.'. Smaller widths will display it non-animated and larger widths will animate normally.  To disappear the animation at smaller/larger widths choose the RWD display Off option in the configs and choose the width there.');
	printer::alert('Optionally Set a minimum width requiremnt to enable the chosen animation for this '.$type.'. For example by setting a width of 500px, viewports of less than 500px will not animate this '.$type.'. Choose none to remove any width requirement for animation.');
	$this->mod_spacing($anim_name.'['.$animate_width_index.']',$animate_width,$min_width,$max_width,1,'px','none');
	printer::close_print_wrap('anim width');
	printer::pclear(5);
	
	printer::close_print_wrap('inital wrap animate');
	$this->show_close('Enable '.$type.' Initial Animation');
	printer::pclear(5);
     $this->submit_button();
	printer::close_print_wrap('wrap  _animations');
	$this->show_close('animations'); 
	}//end func animate_class

    
 function display_media($style, $val,$field='',$msg='Display @media Element'){ 
	#note: display property and advanced styles use css #id to override normal styles which use distinct classnames
	$display_arr=array('display_max','display_min');
	$options=explode('@@',$this->{$style}[$val]);
     $displayindexes=$display_arr;
	foreach($displayindexes as $key =>$index){
		${$index.'_index'}=$key;
		}
	$c_opts=count($display_arr);
     for ($i=0;$i<$c_opts; $i++){ 
		if (!array_key_exists($i,$options))$options[$i]=0;
		}
	$css_id=$this->pelement;   
	$max_name=$style.'['.$val.']['.$display_max_index.']';
	$min_name=$style.'['.$val.']['.$display_min_index.']';
	$type=($this->is_column)?'Column':'Post'; 
	$msg='Select a min-width or max-width or both at which to display:none this '.$type;
	$val_max=$options[$display_max_index];
	$val_min=$options[$display_min_index];
	$this->show_more('Display @media Off ',$msg,'highlight click editbackground editfont');
	$this->print_redwrap('Display state');
     printer::print_tip('Control display based on <b>@media queries</b>  or <b>scroll height methods</b>');
     printer::print_wrap('display media method');
	printer::print_tip('<b>Use @media queries</b> to optionally set a maximum and/or minimum width at which will initate a display:none for this post in webpage mode only. <br> Note: Display Property for RWD grid mode may also be responsively Turned off using 0 grid units (ie %) for particular break pts. <b>Flex elements will not respond</b>');
	$displayoff_maxpx=($val_max>199&&$val_max<2001)?$val_max:'none';
	$displayoff_minpx=($val_min>199&&$val_min<3001)?$val_min:'none';
	$mediacss=$css='';  
	if ($displayoff_minpx!=='none'&&$displayoff_maxpx!=='none') {
          $mediacss.=$css.='
          @media screen and (max-width:'.$displayoff_maxpx.'px) and (min-width:'.$displayoff_minpx.'px){
          '.$css_id.'{display:none !important;}
               }
               ';
          }
     elseif ($displayoff_maxpx!=='none'){
          $mediacss.=$css.='
          @media screen and (max-width: '.$displayoff_maxpx.'px){
          '.$css_id.'{display:none !important;}
          }';
          }
     elseif ($displayoff_minpx!=='none') {
          $mediacss.=$css.='
          @media screen and (min-width: '.$displayoff_minpx.'px){
          '.$css_id.'{display:none !important;}
          }';
          }
     
     $this->show_more('Style info','','info italic smaller');
     printer::print_wrap1('techinfo');
     printer::print_info('Current setting Css: '.$css);
     $msg='Uses @media control of display:none; css property';
     printer::print_info($msg);
     printer::close_print_wrap1('techinfo');
     $this->show_close('Tech info');
     
     $btype=($this->is_blog)?$this->blog_type:'nested';
     $this->css.=$mediacss;
     (!empty($this->display_edit_data))&&$this->editoverridecss.=" 
     html div{$css_id}.$btype {display: $this->display_edit_data;}";//display state on in editmode  
     printer::printx('<p class="info floatleft">#'.$css_id.'</p>'); 
     printer::print_info('Optionally choose a min-width or max-width or both at which this '.$type.' will not appear (will not effect editmode).');  
     echo '<div class="fsminfo"><!--wrap max width-->';
     printer::printx('<p class="smaller '.$this->column_lev_color.'">Chosen Display Off max-width: <span class="navybackground white">'.$displayoff_maxpx.'</span><br></p>'); 
     printer::alert('Choose @media screen max-width px');
     $this->mod_spacing($max_name,$displayoff_maxpx,200,2000,1,'px','none');  
     printer::printx('<p ><input type="checkbox" name="'.$max_name.'" value="0">Remove max-width</p>');
     echo '</div><!--wrap max width-->';
     echo '<div class="fsminfo"><!--wrap min width-->';
     printer::printx('<p class="smaller '.$this->column_lev_color.'">Chosen min-width: <span class="navybackground white">'.$displayoff_minpx.'</span></p>');
     printer::alert('Choose @media screen min-width px');
     $this->mod_spacing($min_name,$displayoff_minpx,200,2000,1,'px','none');  
     printer::printx('<p ><input type="checkbox" name="'.$min_name.'" value="0">Remove min-width</p>');
     echo '</div><!--wrap min width-->';
     printer::close_print_wrap('display media method');
     $this->submit_button(); 
          printer::pclear();
     $this->close_print_wrap('Display state');
     $this->show_close('display state Off'); 
     printer::pclear();
     }//end display
	
//imminent to do:  create function with combined internals of this function and with display state scroll    
function fade_this($style, $val,$field='',$msg='Class Display-Scroll Element'){  
      #this is for all posts including nested columns
     $display_arr=array('none','fadethis-slide-left','fadethis-slide-right','fadethis-slide-top','fadethis-slide-bottom','@media_force_off');
     $displayindexes=explode(',',Cfg::Display_options);
	foreach($displayindexes as $key =>$index){
		${$index.'_index'}=$key;
		}  
	$options=explode('@@',$this->{$style}[$val]);
	$c_opts=count(explode(',',Cfg::Display_options));
     $repeats=3*$c_opts;
     for ($i=0;$i<$repeats; $i++){ 
		if (!array_key_exists($i,$options))$options[$i]=0;
		}
     $this->show_more('Animated FadeThis','','highlight click editbackground editfont');
     printer::print_wrap('display scroll');
	printer::print_info('Reversible Scrolling Animation from FadeThis@lwiesel <a href="https://github.com/lwiesel/jquery-fadethis" class="ekblue underline cursor" target="blank">see on github</a>');
	printer::print_tip('For use on default position static elements');
     $script='';
	$listen=false;//set to true if additional media query && ie absolute 
     for ($i=0; $i<3; $i++){
          $k=$i * $c_opts ;//
     if ($i>0){
          $this->show_more('Additional @Media Controlled');
          printer::print_wrap('Additional display');
          }
     $this->submit_button();
     $cb_data=$this->pelement;
      printer::print_notice('Note: the first matching classname of '.$this->pelement.' will be affected');
     $element_arr=array('id','Closest Matching Previous Class','Closest Matching Next Class');
     printer::print_tip('Use both maxwidth and minwidth for  multiple selected @media widths. Uses Jquery window.width.');
     $display_max=(is_numeric($options[$display_max_index+$k])&&$options[$display_max_index+$k]>0&&$options[$display_max_index+$k]<=4000)?$options[$display_max_index+$k]:'none';
     $display_min=(is_numeric($options[$display_min_index+$k])&&$options[$display_min_index+$k]>0&&$options[$display_min_index+$k]<=4000)?$options[$display_min_index+$k]:'none';
     $display_speed=(is_numeric($options[$display_speed_index+$k])&&$options[$display_speed_index+$k]>=.1&&$options[$display_speed_index+$k]<=3)?$options[$display_speed_index+$k]:'1';
     $display_reverse=($options[$display_reverse_index+$k]==='untrue')?false:true;
     $display_distance=(is_numeric($options[$display_distance_index+$k])&&$options[$display_distance_index+$k]>=0&&$options[$display_distance_index+$k]<=200)?$options[$display_distance_index+$k]:'50';
     $display_offset=(is_numeric($options[$display_offset_index+$k])&&$options[$display_offset_index+$k]>=-100&&$options[$display_offset_index+$k]<=1000)?$options[$display_offset_index+$k]:'0';
     $fade_choice=(!empty($options[$display_fade_choice_index+$k])&&in_array($options[$display_fade_choice_index+$k],$display_arr))?$options[$display_fade_choice_index+$k]:'none';
     $display_name=($this->is_column)?$this->col_name.'_col_options['.$this->col_display_fadethis_animate_index.']':$this->data.'_blog_options['.$this->blog_display_fadethis_animate_index.']';
     $display_name=$style.'['.$val.']';
     $max_name=$display_name.'['.($display_max_index+$k).']';
     $min_name=$display_name.'['.($display_min_index+$k).']';
     $speed_name=$display_name.'['.($display_speed_index+$k).']';
     $distance_name=$display_name.'['.($display_distance_index+$k).']';
     $reverse_name=$display_name.'['.($display_reverse_index+$k).']';
     $offset_name=$display_name.'['.($display_offset_index+$k).']';
     $choice_name=$display_name.'['.($display_fade_choice_index+$k).']';
     $type=($this->is_column)?'column':'post';
     $id=($this->is_column)?$this->col_id:$this->blog_id;
     printer::print_wrap1('max @media');
     printer::alert('specify @media max-width option');
     $this->mod_spacing($max_name,$display_max,100,4000,1,'px','none');
     printer::close_print_wrap1('max @media');
     printer::print_wrap1('min @media',$this->column_lev_color);
     printer::alert('specify @media min-width option');
     $this->mod_spacing($min_name,$display_min,100,4000,1,'px','none');
     printer::close_print_wrap1('min @media');
     printer::print_wrap1('fade in or out display');
	printer::print_tip('For responsive resizing turning off active setting @media query use @media Force off instead of none');
     printer::alert('Choose Fade effect / None  / @media Force off');
     forms::form_dropdown($display_arr,'','','',$choice_name,$fade_choice,false,'maroon whitebackground left'); 
     printer::close_print_wrap1('fade in or out display'); 
     printer::print_wrap1('duration');
     printer::alert('Specify fade-in fade-out duration option in seconds');
     $this->mod_spacing($speed_name,$display_speed,.1,3,.1,'sec','none');
     printer::close_print_wrap1('duration');
     printer::print_wrap1('percent');
     printer::print_tip('Choose fade slide distance. Use 0 to fade in place.');
     $this->mod_spacing($distance_name,$display_distance,0,200,1,'px'); 
     printer::close_print_wrap1('percent');
     printer::print_wrap1('percent');
     printer::print_tip('Choose offset. Shorter height elements work will with negative values whereas larger values work with greater height elements. Uses 0 by default.');
     $this->mod_spacing($offset_name,$display_offset,-100,1000,1,'px'); 
     $final_offset=( $display_offset < 0 )? abs($display_offset) : -$display_offset;
	printer::close_print_wrap1('percent');
     printer::print_wrap('reverse');
     $checked1=($display_reverse)?'checked="checked"':'';
     $checked2=(!$display_reverse)?'checked="checked"':'';
     printer::alert('<input type="radio" name="'.$reverse_name.'" value="true" '.$checked1.'>Reverse Fading Effect on Scroll up');
     printer::alert('<input type="radio" name="'.$reverse_name.'" value="untrue" '.$checked2.'>Turn Reverse Off');
     printer::close_print_wrap('reverse');
     $display_speed=$display_speed*1000;
     $reverse=($display_reverse)?',"reverse":true':',"reverse":false';
     $display_max=($display_max==='none')?10000 : $display_max;
     $display_min=($display_min==='none')?100 : $display_min;
     if ($fade_choice!=='none'){
          if ($i>0)$listen=true;
          $this->handle_script_edit('fadethis/jquery.fadethis.js','fadethis_header_once','header_script_once');
$script.= <<<eol
//########################
	if (gen_Proc.vpw <= $display_max && gen_Proc.vpw >= $display_min){
		jQuery('$cb_data').addClass('$fade_choice');
		if ('$fade_choice'!=='@media_force_off')
			jQuery('$cb_data').each(function(index){
				$(this).data('fadethis-id','pId_$this->key'+'_'+index);
				$(this).fadeThis({"speed": $display_speed, "distance": $display_distance,"offset": $final_offset $reverse});
				});
		else{
			jQuery('$cb_data').each(function(index){
				$(this).fadeThis({"forceOff":true});
				});
			}
		}//if media
		
eol;
              }
          if ($i>0){ 
               $this->submit_button();
               printer::close_print_wrap('Additional display');
               $this->show_close('Additional Media Controlled Choices');
               }
               
          }//for loop
     if (!empty($script)){
		$this->handle_script_edit("
		
		//fadeThis class for $cb_data 
			$script",'class_anim_scroll','script');
		if ($listen){//we have multiple media query controled fadeThis and if window resizes we re-initate fadeThis according to current width
$resize_script= <<<eol
	
	//fadeThis  resize class $type for $cb_data";
	$script
eol;
			$this->handle_script_edit($resize_script,'class_anim_scroll','onresizescript');
			}
		}//!empty script

      $this->submit_button();
      printer::close_print_wrap('display scroll');
      $this->show_close('Choose Display Scroll Visibility');
      }//end display  
    
     
     
function flex_item_width($style, $val,$field='',$msg='Class Flex Items'){// handles col and blog flex-items
     $type='blog';
     
     if ($this->is_clone&&!$this->clone_local_style)return;
     $flexindexes=explode(',',Cfg::Blog_flex_options);
	foreach($flexindexes as $key =>$index){
		${$index.'_index'}=$key;
		}  
	if (empty($this->{$style}[$val])){ 
		$flex_array=array();
		 for ($i=0; $i<count($flexindexes);$i++){ 
			$flex_array[$i]=0;
			}
		}
	else	{   
		$flex_array=explode('@@',$this->{$style}[$val]);
		for ($i=0; $i<count($flexindexes);$i++){ 
			if (!array_key_exists($i,$flex_array)){
				$flex_array[$i]=0;
				}
			 }
		}
		
     $flexitems=$flex_array;
     $count=count($flexitems);
     $css_id=$this->pelement;
     $align_self_arr=array('def','sta','end','cen','bas','str');//flex-start default 
     $align_self_assoc=array('def'=>'parent column setting','sta'=>'flex-start','end'=>'flex-end','cen'=>'center','bas'=>'baseline','str'=>'stretch');
     $this->show_more('Flex_item_width','main2','highlight click editbackground editfont');
     $this->print_redwrap('flex items');
     printer::print_tip('Choose flex-item options here along with special text post flex-column option in the text post settings  to position this '.$type.' sub item');
     printer::print_tip(' For clear flex-box overview: <a  class="underline ekblue" href="https://css-tricks.com/snippets/css/a-guide-to-flexbox/" target="_blank"  >https://css-tricks.com/snippets/css/a-guide-to-flexbox/</a>');
          $i=$k=0;//we are not doing additional media controlled flex items here
          $blog_flex_on=($flexitems[$blog_flex_on_index]==='flexon')?true:false;
          $max_flex=(is_numeric($flexitems[$blog_max_flex_index+$k])&&$flexitems[$blog_max_flex_index+$k]>0&&$flexitems[$blog_max_flex_index+$k]<=3000)?$flexitems[$blog_max_flex_index+$k]:'none';
          $min_flex=(is_numeric($flexitems[$blog_min_flex_index+$k])&&$flexitems[$blog_min_flex_index+$k]>0&&$flexitems[$blog_min_flex_index+$k]<=3000)?$flexitems[$blog_min_flex_index+$k]:'none';
          $cn=explode(' ',$this->pelement);
          $classname=str_replace('.','',end($cn));
          printer::print_wrap1('flex on');
          $msg='The column flex option available in text post settings needs also to be activated for the flex effects';
          if ($blog_flex_on){
               echo printer::print_tip('Flex Item is activated for elements within this post with the class name: '.$classname.' added. '.$msg);
               printer::alert('<input type="checkbox" name="'.$style.'['.$val.']['.($blog_flex_on_index).']" value="flexoff">Turn off flex item css for classname: '.$classname);
               }
          else {
               echo printer::print_tip('Activate Flex Item Css elements within this post having the class name '.$classname.'. '.$msg);
               printer::alert('<input type="checkbox" name="'.$style.'['.$val.']['.($blog_flex_on_index).']" value="flexon">Turn ON flex item css for classname: '.$classname);
               }
          printer::close_print_wrap1('flex on');
               
          if ($i>0){
               if ($max_flex!=='none'||$min_flex!=='none'){
                    printer::print_notice('Activated Media Query Below');
                    }
               $this->show_more('Add additional @media query controlled option tweaks for flex-items');
               $this->print_redwrap('additional media wrap #'.$i);
               }
          $order=(is_numeric($flexitems[$flex_order_index+$k])&&$flexitems[$flex_order_index+$k]>=0&&$flexitems[$flex_order_index+$k]<=30)?$flexitems[$flex_order_index+$k]:0;
          $grow=(is_numeric($flexitems[$flex_grow_index+$k])&&$flexitems[$flex_grow_index+$k]>0&&$flexitems[$flex_grow_index+$k]<=100)?$flexitems[$flex_grow_index+$k]:0;
          ######## turn on  flex_grow_enabled
          if ($this->is_column&&!empty($grow)&&$flex_box_item)$flex_grow_enabled=true;
          $shrink=(is_numeric($flexitems[$flex_shrink_index+$k])&&$flexitems[$flex_shrink_index+$k]>0&&$flexitems[$flex_shrink_index+$k]<=100)?$flexitems[$flex_shrink_index+$k]:0;
          $align_self=(!empty($flexitems[$flex_align_self_index+$k])&&in_array($flexitems[$flex_align_self_index+$k],$align_self_arr))?$flexitems[$flex_align_self_index+$k]:'def';
          $align_self_css=($align_self==='def')?'':'align-self:'.$align_self_assoc[$align_self].';';
          $mediacss='';
          $floatstyle='';'margin-left:0 !important;margin-right:0 !important;';//margin auto blog item creates some problems with rendering
		printer::print_wrap1('flex order',$this->column_lev_color);
          printer::alert('Alter source order here:');
          $this->mod_spacing($style.'['.$val.']['.($flex_order_index+$k).']',$order,0,30,1,'','none');
          printer::close_print_wrap1('flex order');
          printer::print_wrap1('flex grow',$this->column_lev_color);
          printer::print_tip('Flex-Grow value determines distribution of extra space beyond initial value of width setting (whether main width or flex-basis width value set)');
          printer::alert('Choose flex-grow here:');
          $this->mod_spacing($style.'['.$val.']['.($flex_grow_index+$k).']',$grow,0,100,.1,'');
          printer::close_print_wrap1('flex grow');
          printer::print_wrap1('flex shrink',$this->column_lev_color);
          printer::print_tip('Flex-Shrink value is applied when the flex-column setting for flex-wrap is set for nowrap and space becomes limiting. It then determines the relative rate of shrinking of the flex items within the container.');
          printer::alert('Choose flex-shrink here.');
          $this->mod_spacing($style.'['.$val.']['.($flex_shrink_index+$k).']',$shrink,0,100,.1,'','none'); 
          printer::close_print_wrap1('flex shrink');
          printer::print_wrap1('flex basis',$this->column_lev_color);
          printer::print_tip('You can Set the flex basis width value directly. In this mode selecting a flex-basis width value will override the main setting  width but not max/min-width specifications.  Or Use Auto to use the main settings width value (&amp; in addition to main settings  max/min-width made) for initial width size before flex-grow and flex-shrink settings are applied.<br><br> Or use 0 for flex-grow distribution of extra space according to natural content width.');
          $basis=(empty($flexitems[$flex_basis_index+$k])||$flexitems[$flex_basis_index+$k]==='zero')?'zero':$flexitems[$flex_basis_index+$k];
          $checked1=($basis==='auto')?'checked="checked"':'';
          $checked2=($basis==='zero')?'checked="checked"':'';
          printer::alert('Choose flex-basis here:');
          printer::alert('<input name="'.$style.'['.$val.']['.($flex_basis_index+$k).']" value="auto" type="radio" '.$checked1.'>Use auto'); 
          printer::alertx('<input name="'.$style.'['.$val.']['.($flex_basis_index+$k).']" value="0" type="radio" '.$checked2.'>Use 0');
          printer::pclear();
          $this->{$style.'['.$val.']'}[$flex_basis_index+$k]=($basis==='auto'||$basis==='zero')?0:$basis;
          printer::print_tip(' Or Choose Flex Basis value (Overrides other choices)');
          $flex_width_value=$this->spacing($style.'['.$val.']',$flex_basis_index+$k,'return','Flex-basis value','Sets initial width value &amp; ','','','','');
          if($basis!=='auto'&&$basis!=='zero'){
               $basis=$flex_width_value;
               printer::alert('Current flex-basis: '.$flex_width_value);
               }
          $basis_css=($basis==='zero')?0:$basis;
          printer::close_print_wrap1('flex basis'); 
          printer::print_wrap1('align self',$this->column_lev_color);
          printer::alert('Change default align-self here if you need to override the parent column align-item setting for this post and all siblings.  Override individual setting for this post here');
          foreach ($align_self_arr as $asa){
               if ($align_self===$asa)
                    $checked='checked="checked"';
               else $checked=''; 
               echo '<p><input type="radio" name="'.$style.'['.$val.']['.($flex_align_self_index+$k).']" value="'.$asa.'" '.$checked.'> '.$align_self_assoc[$asa].'</p>';
          
               }//end foreach
          printer::close_print_wrap1('align self');
          printer::print_tip('You can @media control flex item css expression');
          printer::print_wrap1('max flex',$this->column_lev_color);
          printer::alert('Optionally Add a flex-item @media max-width');
          $this->mod_spacing($style.'['.$val.']['.($blog_max_flex_index+$k).']',$max_flex,100,3000,1,'px','none');
          printer::close_print_wrap1('max flex');
          printer::print_wrap1('min flex',$this->column_lev_color);
          printer::alert('Optionally Add a flex-item @media min-width');
          $this->mod_spacing($style.'['.$val.']['.($blog_min_flex_index+$k).']',$min_flex,100,3000,1,'px','none');
          printer::close_print_wrap1('min flex');
          $msg='Css applied to main '.$type.' div';
          $css='';
          if ($blog_flex_on){
               if ($max_flex==='none'&&$min_flex==='none'){
                    if ($i>0)echo 'Choose @media max or min width to initiate viewport responsive flex settings';
                     
                    else
                         $this->css.=$css='
     '.$css_id.'{flex:'.$grow.' '.$shrink.' '.$basis_css.';
     order:'.$order.';
     '.$align_self_css.$floatstyle.'}
     ';
                    } 
               elseif ($max_flex!=='none'&&$min_flex!=='none') {
                     $this->css.=$css='
     @media screen and (max-width:'.$max_flex.'px) and (min-width:'.$min_flex.'px){  	
     '.$css_id.'{flex:'.$grow.' '.$shrink.' '.$basis_css.';
     order:'.$order.';
     '.$align_self_css.$floatstyle.'}
          }';
                    }
               elseif ($max_flex!=='none'){
                     $this->css.=$css='
     @media screen and (max-width: '.$max_flex.'px){  	
     '.$css_id.'{flex:'.$grow.' '.$shrink.' '.$basis_css.';
     order:'.$order.';
     '.$align_self_css.$floatstyle.'}
          }';
                    }
               else {
                     $this->css.=$css='
     @media screen and (min-width: '.$min_flex.'px){  	
     '.$css_id.'{flex:'.$grow.' '.$shrink.' '.$basis_css.';
     order:'.$order.';
     '.$align_self_css.$floatstyle.'}
          }';
                    }
               }//if $blog_flex_on is on
          if ($i>0){
               
               $this->submit_button( );
               printer::close_print_wrap('additional media wrap #'.$i);
               $this->show_close('Add any additional @media query controlled option tweak(s) for flex-items'); 
               }
    
         // }//end for
     
     $this->submit_button();
     printer::close_print_wrap('flex items');
     $this->show_close('Choose flex-item options'); 
     }
     
function flex_container_width($style, $val,$field='',$msg='Enable flex container in this text post'){
     if ($this->is_clone&&!$this->clone_local_style)return; 
     $display1_arr=array('fle','inf','off'); 
     $display1_assoc=array('fle'=>'flex','inf'=>'inline-flex','off'=>'off');
     $display2_arr=array('inb','blo','off'); 
     $display2_assoc=array('inb'=>'inline-block','blo'=>'block','off'=>'off'); 
     $flex_direction_arr=array('row','rrv','col','crv');
     $flex_direction_assoc=array('row'=>'row','rrv'=>'row-reverse','col'=>'column','crv'=>'column-reverse');//row
     $flex_wrap_arr=array('now','wra','wrv');//nowrap
     $flex_wrap_assoc=array('now'=>'nowrap','wra'=>'wrap','wrv'=>'wrap-reverse');//nowrap 
     $justify_content_arr=array('sta','end','cen','spb','spa','spe');//flex-start
     $justify_content_assoc=array('sta'=>'flex-start','end'=>'flex-end','cen'=>'center','spb'=>'space-between','spa'=>'space-around','spe'=>'space-evenly');//flex-start 
     $align_content_arr=array('sta','end','cen','spb','spa','str');//flex-start
     $align_content_assoc=array('sta'=>'flex-start','end'=>'flex-end','cen'=>'center','spb'=>'space-between','spa'=>'space-around','str'=>'stretch');//flex-start
     $align_items_arr=array('sta','end','cen','bas','str');//flex-start default 
     $align_items_assoc=array('sta'=>'flex-start','end'=>'flex-end','cen'=>'center','bas'=>'baseline','str'=>'stretch');
      ################################
      printer::pclear(5);
     if ($this->is_clone&&!$this->clone_local_style)return;
     $flexindexes=explode(',',Cfg::Col_flex_options);
	foreach($flexindexes as $key =>$index){
		${$index.'_index'}=$key;
		}  
	if (empty($this->{$style}[$val])){ 
		$flex_array=array();
		 for ($i=0; $i<count($flexindexes);$i++){ 
			$flex_array[$i]=0;
			}
		}
	else	{   
		$flex_array=explode('@@',$this->{$style}[$val]);
		for ($i=0; $i<count($flexindexes);$i++){ 
			if (!array_key_exists($i,$flex_array)){
				$flex_array[$i]='';
				}
			 }
		}
		
     $flexcontainer=$flex_array;
     $count=count($flexindexes);
     $css_id=$this->pelement; 
     $this->show_more('Flex-box flex-container','','highlight click editbackground editfont');
     $this->print_redwrap('flex container');
     printer::print_tip('Choose flex-container options here together with flex-item options using appropriate classnames to position the child elements within this text post.');
     printer::print_tip(' For clear flex-box overview: <a  class="underline ekblue cursor" href="https://css-tricks.com/snippets/css/a-guide-to-flexbox/" target="_blank"  >https://css-tricks.com/snippets/css/a-guide-to-flexbox/</a>'); 
          $k=$i=0;
          $max_flex=(is_numeric($flexcontainer[$this->col_max_flex_index+$k])&&$flexcontainer[$this->col_max_flex_index+$k]>0&&$flexcontainer[$this->col_max_flex_index+$k]<=3000)?$flexcontainer[$this->col_max_flex_index+$k]:'none';
          $min_flex=(is_numeric($flexcontainer[$this->col_min_flex_index+$k])&&$flexcontainer[$this->col_min_flex_index+$k]>0&&$flexcontainer[$this->col_min_flex_index+$k]<=3000)?$flexcontainer[$this->col_min_flex_index+$k]:'none';
          if ($i>0){//not used here 
                if ($max_flex!=='none'||$min_flex!=='none'){
                    printer::print_notice('Activated Media Query Below');
                    }
               $this->show_more('Add additional @media query controlled option tweaks for flex-container');
               $this->print_redwrap('additional media wrap #'.$i);
               }
          $dis_suffix=($i<1)?'1':'2';//choose display array
          $display=(!empty($flexcontainer[$this->flex_display_index+$k])&&in_array($flexcontainer[$this->flex_display_index+$k],${'display'.$dis_suffix.'_arr'}))?$flexcontainer[$this->flex_display_index+$k]:'off';
          $display_css=($display==='off')?'':'display:'.${'display'.$dis_suffix.'_assoc'}[$display].';';
          $direction=(!empty($flexcontainer[$this->flex_direction_index+$k])&&in_array($flexcontainer[$this->flex_direction_index+$k],$flex_direction_arr))?$flexcontainer[$this->flex_direction_index+$k]:'row';
          $direction_css='flex-direction:'.$flex_direction_assoc[$direction].';';
          $wrap=(!empty($flexcontainer[$this->flex_wrap_index+$k])&&in_array($flexcontainer[$this->flex_wrap_index+$k],$flex_wrap_arr))?$flexcontainer[$this->flex_wrap_index+$k]:'now';
          $wrap_css='flex-wrap:'.$flex_wrap_assoc[$wrap].';';
          $justify_content=(!empty($flexcontainer[$this->flex_justify_content_index+$k])&&in_array($flexcontainer[$this->flex_justify_content_index+$k],$justify_content_arr))?$flexcontainer[$this->flex_justify_content_index+$k]:'sta';
          $justify_content_css='justify-content:'.$justify_content_assoc[$justify_content].';';
          $align_items=(!empty($flexcontainer[$this->flex_align_items_index+$k])&&in_array($flexcontainer[$this->flex_align_items_index+$k],$align_items_arr))?$flexcontainer[$this->flex_align_items_index+$k]:'sta';
          $align_items_css='align-items:'.$align_items_assoc[$align_items].';';
          $align_content=(!empty($flexcontainer[$this->flex_align_content_index+$k])&&in_array($flexcontainer[$this->flex_align_content_index+$k],$align_content_arr))?$flexcontainer[$this->flex_align_content_index+$k]:'sta';
          $align_content_css='align-content:'.$align_content_assoc[$align_content].';';
          $mediacss='';
          if ($i<1)
               printer::print_info('Optionally Control The flex-container settings with max-width and/or min-width @media query. Choose additional flex-container settings/tweaks @media queries below.'); 
          $css='';
          if ($display==='off'&&$i<1)
               printer::print_info('Turn main flex display option to flex or flex-inline to turn flex mode on for position child posts within this column.');
		else if ($max_flex==='none'&&$min_flex==='none'){
               if ($i>0)printer::alert('Choose @media max or min width to initiate additional viewport responsive flex settings'); 
               else
                    $this->css.=$css='
'.$css_id.'{'.$display_css.$direction_css.$wrap_css.$justify_content_css.$align_items_css.$align_content_css.'}
';
			} 
		elseif ($max_flex!=='none'&&$min_flex!=='none') {
			 $this->css.=$css='
@media screen and (max-width:'.$max_flex.'px) and (min-width:'.$min_flex.'px){  	
     '.$css_id.'{'.$display_css.$direction_css.$wrap_css.$justify_content_css.$align_items_css.$align_content_css.'}
}';
			}
		elseif ($max_flex!=='none'){
			 $this->css.=$css='
@media screen and (max-width: '.$max_flex.'px){  
     '.$css_id.'{'.$display_css.$direction_css.$wrap_css.$justify_content_css.$align_items_css.$align_content_css.'}
}';
               }
		else {
			 $this->css.=$css='
@media screen and (min-width: '.$min_flex.'px){
'.$css_id.'{'.$display_css.$direction_css.$wrap_css.$justify_content_css.$align_items_css.$align_content_css.'}
}';
			}
         ################
               printer::print_wrap1('display mode',$this->column_lev_color);
          $msg=($i<1)?'Choose to turn on Flex mode by choosing main value display: flex or flex-inline.  Both modes will render child posts in flex arrangement whereas column will have block or inline-block properties depending on which you choose. You can override flex enabled settings for child posts below for the  @media min max width range additional flex settings by choosing display:block or inline below.':'You can override flex settings for child posts by chosing display display:block or display:inline for the @media setting you choose here';
          printer::alert($msg);
          foreach (${'display'.$dis_suffix.'_arr'} as $asa){
               if ($display===$asa)
                    $checked='checked="checked"';
               else $checked=''; 
               echo '<p><input type="radio" name="'.$style.'['.$val.']['.($this->flex_display_index+$k).']" value="'.$asa.'" '.$checked.'> '.${'display'.$dis_suffix.'_assoc'}[$asa].'</p>';
               }//end foreach
          printer::close_print_wrap1('display mode');
          ###################
          printer::print_wrap1('flex wrap',$this->column_lev_color);
          printer::alert('Change default flex-wrap. Nowrap for one line, wrap and wrap-reverse will use multiple lines as needed with wrap-reverse wrapping onto multiple lines from bottom to top.');
          foreach ($flex_wrap_arr as $asa){
               if ($wrap===$asa)
                    $checked='checked="checked"';
               else $checked=''; 
               echo '<p><input type="radio" name="'.$style.'['.$val.']['.($this->flex_wrap_index+$k).']" value="'.$asa.'" '.$checked.'> '.$flex_wrap_assoc[$asa].'</p>';
          
               }//end foreach
               printer::close_print_wrap1('flex wrap');
               #############################
                printer::print_wrap1('flex direction',$this->column_lev_color);
          printer::alert('Change default flex-direction of child posts to arrange in row or column in natural or reverse order.');
          foreach ($flex_direction_arr as $asa){
               if ($direction===$asa)
                    $checked='checked="checked"';
               else $checked=''; 
               echo '<p><input type="radio" name="'.$style.'['.$val.']['.($this->flex_direction_index+$k).']" value="'.$asa.'" '.$checked.'> '.$flex_direction_assoc[$asa].'</p>';
          
               }//end foreach
          printer::close_print_wrap1('flex direction');
               #############################
          printer::print_wrap1('justify content',$this->column_lev_color);
          printer::alert('justify-content: Justifies content of child posts along main-axis when extra horizontal space is available. This default value may be overriden in each child post');
          foreach ($justify_content_arr as $asa){
               if ($justify_content===$asa)
                    $checked='checked="checked"';
               else $checked=''; 
               echo '<p><input type="radio" name="'.$style.'['.$val.']['.($this->flex_justify_content_index+$k).']" value="'.$asa.'" '.$checked.'> '.$justify_content_assoc[$asa].'</p>';
          
               }//end foreach
               printer::close_print_wrap1('justify content');
               ################################
          printer::print_wrap1('align items',$this->column_lev_color);
          printer::alert('align-items: Choose default vertical arrangement for aligning child posts within each row.  Will align the content of posts of a particular row vertically. This setting may be overriden for an individual child post(s) as needed using align-self option.');
          foreach ($align_items_arr as $asa){
               if ($align_items===$asa)
                    $checked='checked="checked"';
               else $checked=''; 
               echo '<p><input type="radio" name="'.$style.'['.$val.']['.($this->flex_align_items_index+$k).']" value="'.$asa.'" '.$checked.'> '.$align_items_assoc[$asa].'</p>';
          
               }//end foreach
               printer::close_print_wrap1('align items');
               ###########################
                printer::print_wrap1('align content',$this->column_lev_color);
          printer::alert('align-content:   Arranges entire spacing between rows along cross-axis when extra column height available.');
          foreach ($align_content_arr as $asa){
               if ($align_content===$asa)
                    $checked='checked="checked"';
               else $checked=''; 
               echo '<p><input type="radio" name="'.$style.'['.$val.']['.($this->flex_align_content_index+$k).']" value="'.$asa.'" '.$checked.'> '.$align_content_assoc[$asa].'</p>';
          
               }//end foreach
          printer::close_print_wrap1('align content');
          printer::print_wrap1('max flex',$this->column_lev_color);
          printer::alert('Add a flex-containers @media max-width');
          $this->mod_spacing($style.'['.$val.']['.($this->col_max_flex_index+$k).']',$max_flex,100,3000,1,'px','none');
          printer::close_print_wrap1('max flex');
          printer::print_wrap1('min flex',$this->column_lev_color);
          printer::alert('Add a flex-containers @media min-width');
          $this->mod_spacing($style.'['.$val.']['.($this->col_min_flex_index+$k).']',$min_flex,100,3000,1,'px','none');
          printer::close_print_wrap1('min flex');    
               ####################
          if ($i>0){
               $this->submit_button();
               printer::close_print_wrap('additional media wrap #'.$i);
               $this->show_close('Add any additional @media query controlled option tweak(s) for flex-container');
               }
     $this->show_more('Style info #'.$i,'','info italic smaller');
     printer::print_wrap1('techinfo');
     printer::print_info('Current setting Css: '.$css.' in '.$this->roots.Cfg::Style_dir.$this->pagename.'.css');
     $msg='Flex container css is applied directly to the parent column main div element: '.$css_id.' classname';
     printer::print_info($msg);
     printer::close_print_wrap1('techinfo');
     $this->show_close('Tech info');  
         // }//end for
     $this->submit_button();
     printer::close_print_wrap('flex container');
     $this->show_close('Choose flex-containers options');
     }#end flex-container

function background($style, $val, $field='',$msg='Background color'){  
	static $inc=0;  $inc++;
	$opacitybackground=false;//set default otherwise creates :after
	$imagepx=(isset($this->background_img_px)&&$this->background_img_px>4)? $this->background_img_px:(($this->is_page)?$this->page_width:$this->current_net_width);   
	$backindexes=explode(',',Cfg::Background_styles);
	foreach($backindexes as $key =>$index){
		${$index.'_index'}=$key;
		}  
	if (empty($this->{$style}[$val])){ 
		$background_array=array();
		 for ($i=0; $i<count($backindexes);$i++){ 
			$background_array[$i]=0;
			}
		}
	else	{   
		$background_array=explode('@@',$this->{$style}[$val]);
		for ($i=0; $i<count($backindexes);$i++){ 
			if (!array_key_exists($i,$background_array)){
				$background_array[$i]=0;
				}
			 }
		}
	if ($this->is_blog){// determine the name of the field for adding new background image!!
		if(!empty($field)){  
			$maxwid=$this->current_net_width;
			$background_image_field=$field.'-blog-'.$val.'-'.$this->blog_order;
			$table=$this->blog_table;
			}
		else{//fields currently always present.
               mail::alert('background image upload field missing');
			$maxwid=$this->current_net_width;
			$background_image_field='blog_style-blog-' .$val.'-'.$this->blog_order;
			$table=$this->blog_table;
			}
		}
	elseif ($this->is_column) {
		$maxwid=$this->current_net_width;
		$background_image_field=$field.'-column-'. $val;
		$table=$this->col_name;
		}
	elseif ($this->is_page) { 
		$background_image_field=$field.'-page-'.$val;
		$maxwid=Cfg::Default_background_image_width;
		$table=$this->pagename;
		}
	else {
	echo '</div><!--background issue-->';
		mail::alert('background function issue');
		return;
		}
	(empty($width))&&$width=$maxwid;
	#the above is for uploading background image below....
	$background_parallax_reverse=($background_array[$background_parallax_reverse_index]==='background_parallax_reverse')?true:false;
	if ($background_parallax_reverse){
		$parallax_url='url("'.Cfg_loc::Root_dir.Cfg::Graphics_dir.Cfg::Overlay_png.'"),';//adds to
		$parallax_repeat='repeat, ';//adds to
		$parallax_size='256px 256px, ';//adds to
		$parallax_position='background-position:top left, bottom center; ';//replaces outright
		$parallax_fixed='background-attachment:fixed, fixed;';//replaces outright
		}
	else $parallax_position=$parallax_attachment=$parallax_fixed=$parallax_url=$parallax_repeat=$parallax_size=''; 
		 
	$background_color_off=($background_array[$background_color_off_index]==='coloroff')?true:false;
	$background_image_off=($background_array[$background_image_off_index]==='imageoff')?true:false;
	$background_color_opacity=(!empty($background_array[$background_opacity_index])&&$background_array[$background_opacity_index]<100&&$background_array[			$background_opacity_index]>0)?$background_array[$background_opacity_index]:100;
	$back_color=(preg_match(Cfg::Preg_color,$background_array[$background_color_index]))?$background_array[$background_color_index]:'';
	if (!empty(trim($back_color))){
		if ($background_color_opacity <100) 
			$back_color=process_data::hex2rgba($back_color,$background_color_opacity);
		else $back_color='#'.$back_color;
		$background_color='background-color: '.$back_color.';'; 
		}
	else $background_color='';
	$background_image_used= ($background_array[$background_image_use_index]==1&&is_file(Cfg_loc::Root_dir.Cfg::Background_image_dir.$background_array[$background_image_index]))?true:false; 
	$background_gradient_type_array=array('none','vertical','repeating vertical','horizontal','repeating horizontal','diagonal top left','repeating diagonal top left','diagonal top right','repeating diagonal top right','radial ellipse','repeating radial ellipse','radial circle','repeating radial circle');
	$background_gradient_type= (!empty($background_array[$background_gradient_type_index])&&in_array($background_array[$background_gradient_type_index],$background_gradient_type_array))?$background_array[$background_gradient_type_index]:'';
	if (!empty($background_gradient_type)&&$background_gradient_type!=='none'){   
		$gradient_color_arr=array();
		$gradient_colors='';
		for ($i=1; $i<7; $i++){
			$mycolor= (preg_match(Cfg::Preg_color,$background_array[${'background_gradient_color'.$i.'_index'}]))?$background_array[${'background_gradient_color'.$i.'_index'}]:'';   
			$opacity=$background_array[${'background_gradient_transparency'.$i.'_index'}];  
			if(empty($mycolor)&&$opacity!=='transparent')continue;
			$color_stop=($background_array[${'background_gradient_color_stop'.$i.'_index'}]>2)?' '.$background_array[${'background_gradient_color_stop'.$i.'_index'}].'%':'';
			$gradient_color_arr[]=array($mycolor,$opacity,$color_stop);
			} 
		if (count($gradient_color_arr)>1){
			foreach($gradient_color_arr as $colors){
				if ($colors[1]==='transparent'){
					$gradient_colors.='rgba(255,255,255,0)'.$colors[2].',';
					}
				elseif ($colors[1]<100){
					$gradient_colors.=process_data::hex2rgba($colors[0],$colors[1]).$colors[2].',';
					}
				else $gradient_colors.='#'.$colors[0].$colors[2].',';
				}
				
			}
			$gradient_colors=substr_replace($gradient_colors, '',-1); 
		}
	$background_gradient_position_keyword=(!empty($background_array[$background_gradient_position_keyword_index]))?$background_array[$background_gradient_position_keyword_index]:'farthest-corner';
	$background_gradient_position1=(!is_numeric($background_array[$background_gradient_position1_index]))?'50':$background_array[$background_gradient_position1_index];
	$background_gradient_position2=(!is_numeric($background_array[$background_gradient_position2_index]))?'50':$background_array[$background_gradient_position2_index];
	$background_gradient_percent=$background_gradient_position1.'% '.$background_gradient_position2.'%,';
	$at=' at ';
	$comma=', ';
	//   https://developer.mozilla.org/en-US/docs/Web/CSS/radial-gradient
	if (empty($gradient_colors))$gradient_css='';
	else { 
		switch ($background_array[$background_gradient_type_index]){
			case('none'):
				$gradient_css='';
				break;
			case('vertical'):
				$gradient_css='
					background: -webkit-linear-gradient('.$gradient_colors.'); /* For Safari 5.1 to 6.0 */
					background: -o-linear-gradient('.$gradient_colors.'); /* For Opera 11.1 to 12.0 */
					background: -moz-linear-gradient('.$gradient_colors.'); /* For Firefox 3.6 to 15 */
					background: linear-gradient('.$gradient_colors.');
					';
				break;
			case('repeating vertical'):
				$gradient_css='
					background: -webkit-repeating-linear-gradient('.$gradient_colors.'); /* For Safari 5.1 to 6.0 */
					background: -o-repeating-linear-gradient('.$gradient_colors.'); /* For Opera 11.1 to 12.0 */
					background: -moz-repeating-linear-gradient('.$gradient_colors.'); /* For Firefox 3.6 to 15 */
					background: repeating-linear-gradient('.$gradient_colors.');
					';
				break;
			case('horizontal'):
				$gradient_css='
				background: -webkit-linear-gradient(left, '.$gradient_colors.'); /* For Safari 5.1 to 6.0 */
				background: -o-linear-gradient(right, '.$gradient_colors.'); /* For Opera 11.1 to 12.0 */
				background: -moz-linear-gradient(right, '.$gradient_colors.'); /* For Firefox 3.6 to 15 */
				background: linear-gradient(to right, '.$gradient_colors.'); /* Standard syntax */
				';
				break;
			
			case('repeating horizontal'):
				$gradient_css='
				background: -webkit-repeating-linear-gradient(left, '.$gradient_colors.'); /* For Safari 5.1 to 6.0 */
				background: -o-repeating-linear-gradient(right, '.$gradient_colors.'); /* For Opera 11.1 to 12.0 */
				background: -moz-repeating-linear-gradient(right, '.$gradient_colors.'); /* For Firefox 3.6 to 15 */
				background: repeating-linear-gradient(to right, '.$gradient_colors.'); /* Standard syntax */
				';
				break;
			case('diagonal top left'):
				$gradient_css='
				background: -webkit-linear-gradient(left top, '.$gradient_colors.'); /* For Safari 5.1 to 6.0 */
				background: -o-linear-gradient(bottom right, '.$gradient_colors.'); /* For Opera 11.1 to 12.0 */
				background: -moz-linear-gradient(bottom right, '.$gradient_colors.'); /* For Firefox 3.6 to 15 */
				background: linear-gradient(to bottom right,'.$gradient_colors.');
				';
				break;
			case('repeating diagonal top left'):
				$gradient_css='
				background: -webkit-repeating-linear-gradient(left top, '.$gradient_colors.'); /* For Safari 5.1 to 6.0 */
				background: -o-repeating-linear-gradient(bottom right, '.$gradient_colors.'); /* For Opera 11.1 to 12.0 */
				background: -moz-repeating-linear-gradient(bottom right, '.$gradient_colors.'); /* For Firefox 3.6 to 15 */
				background: repeating-linear-gradient(to bottom right,'.$gradient_colors.');
				';
				break;
			
			case('diagonal top right'):
				$gradient_css='
				background: -webkit-linear-gradient(right top, '.$gradient_colors.'); /* For Safari 5.1 to 6.0 */
				background: -o-linear-gradient(bottom left, '.$gradient_colors.'); /* For Opera 11.1 to 12.0 */
				background: -moz-linear-gradient(bottom left, '.$gradient_colors.'); /* For Firefox 3.6 to 15 */
				background: linear-gradient(to bottom left, '.$gradient_colors.');
				';
				break;
			case('repeating diagonal top right'):
				$gradient_css='
				background: -webkit-repeating-linear-gradient(right top, '.$gradient_colors.'); /* For Safari 5.1 to 6.0 */
				background: -o-repeating-linear-gradient(bottom left, '.$gradient_colors.'); /* For Opera 11.1 to 12.0 */
				background: -moz-repeating-linear-gradient(bottom left, '.$gradient_colors.'); /* For Firefox 3.6 to 15 */
				background: repeating-linear-gradient(to bottom left, '.$gradient_colors.');
				';
				break;
			case('radial ellipse'): 
				$gradient_css='
				background: -webkit-radial-gradient('.$background_gradient_percent.$background_gradient_position_keyword.$comma.$gradient_colors.'); /* Safari 5.1 to 6.0 */
				background: -o-radial-gradient('.$background_gradient_percent.$background_gradient_position_keyword.$comma.$gradient_colors.'); /* For Opera 11.6 to 12.0 */
				background: -moz-radial-gradient('.$background_gradient_percent.$background_gradient_position_keyword.$comma.$gradient_colors.'); /* For Firefox 3.6 to 15 */
				background: radial-gradient('.$background_gradient_position_keyword.$at.$background_gradient_percent.$gradient_colors.'); /* Standard syntax */
				';
				break;
			case('repeating radial ellipse'): 
				$gradient_css='
				background: -webkit-repeating-radial-gradient('.$background_gradient_percent.$background_gradient_position_keyword.$comma.$gradient_colors.'); /* Safari 5.1 to 6.0 */
				background: -o-repeating-radial-gradient('.$background_gradient_percent.$background_gradient_position_keyword.$comma.$gradient_colors.'); /* For Opera 11.6 to 12.0 */
				background: -moz-repeating-radial-gradient('.$background_gradient_percent.$background_gradient_position_keyword.$comma.$gradient_colors.'); /* For Firefox 3.6 to 15 */
				background: repeating-radial-gradient('.$background_gradient_position_keyword.$at.$background_gradient_percent.$gradient_colors.'); /* Standard syntax */
				';
				break;
			case('radial circle'): 
				$gradient_css='
				background: -webkit-radial-gradient(circle '.$background_gradient_percent.$background_gradient_position_keyword.$comma.$gradient_colors.'); /* Safari 5.1 to 6.0 */
				background: -o-radial-gradient(circle '.$background_gradient_percent.$background_gradient_position_keyword.$comma.$gradient_colors.'); /* For Opera 11.6 to 12.0 */
				background: -moz-radial-gradient(circle '.$background_gradient_percent.$background_gradient_position_keyword.$comma.$gradient_colors.'); /* For Firefox 3.6 to 15 */
				background: radial-gradient(circle '.$background_gradient_position_keyword.$at.$background_gradient_percent.$gradient_colors.'); /* Standard syntax */
				';
				break;
			case('repeating radial circle'): 
				$gradient_css='
				background: -webkit-repeating-radial-gradient(circle '.$background_gradient_percent.$background_gradient_position_keyword.$comma.$gradient_colors.'); /* Safari 5.1 to 6.0 */
				background: -o-repeating-radial-gradient(circle '.$background_gradient_percent.$background_gradient_position_keyword.$comma.$gradient_colors.'); /* For Opera 11.6 to 12.0 */
				background: -moz-repeating-radial-gradient(circle '.$background_gradient_percent.$background_gradient_position_keyword.$comma.$gradient_colors.'); /* For Firefox 3.6 to 15 */
				background: repeating-radial-gradient(circle '.$background_gradient_position_keyword.$at.$background_gradient_percent.$gradient_colors.'); /* Standard syntax */
				';
				break;
			default:
				$gradient_css='';
			}
		}
	
	$invalid='';//(!empty($gradient_css)||!empty($back_image_used))?'<img class="floatleft" src="'.Cfg_loc::Root_dir.'invalid.gif" height="25" width="25" alt="background color is overridden">':'';
	$opacity=($background_color_opacity<100&&$background_color_opacity>0)?'@'.$background_color_opacity.'%&nbsp;Opacity ':''; 
	$span_color=(!empty($background_color))?'<span class="fs1npred floatleft" style="height:25px;width:25px; '.$background_color.'">'.$invalid.'&nbsp;&nbsp;</span>'.$opacity:''; 
	if (!preg_match(Cfg::Preg_color,$background_array[$background_color_index]))$background_array[$background_color_index]="0";
     $gradcolor='navy';
	$colorprint=(!empty($back_image_used))?'red':$gradcolor;
	$background_gradient_type=(!empty($background_array[$background_gradient_type_index])&&in_array($background_array[$background_gradient_type_index],$background_gradient_type_array))?$background_array[$background_gradient_type_index]:'none';
	$background_video_ratio=(!empty($background_array[$background_video_ratio_index])&&is_numeric($background_array[$background_video_ratio_index])&&$background_array[$background_video_ratio_index]>.1&&$background_array[$background_video_ratio_index]<10)?$background_array[$background_video_ratio_index]:1.333;
	$background_image_opacity=(empty($background_array[$background_image_opacity_index]))?100:$background_array[$background_image_opacity_index];
	$bsizeunit_arr=array('%','rem','em','px');
	$bsizeunit=(in_array($background_array[$background_size_units_index],$bsizeunit_arr,true))?$background_array[$background_size_units_index]:'%';
	$backwidsize=(is_numeric($background_array[$background_pos_width_index])||$background_array[$background_pos_width_index]==='auto')?$background_array[$background_pos_width_index]:100;
	$backheightsize=(is_numeric($background_array[$background_pos_width_index])||$background_array[$background_pos_height_index]==='auto')?$background_array[$background_pos_height_index]:100;
	if (is_numeric($background_array[$background_horiz_index])&&$background_array[$background_horiz_index]<101&&$background_array[$background_horiz_index]>-1){
          $bhval=$background_array[$background_horiz_index];
          $poshclass='';
          }
     else {
          $bhval=0;
          $poshclass='allowthis';
          }
     if (is_numeric($background_array[$background_vert_index])&&$background_array[$background_vert_index]<101&&$background_array[$background_vert_index]>-1){
          $bvval=$background_array[$background_vert_index];
          $posvclass='';
          }
     else {
          $bvval=0;
          $posvclass='allowthis';
          }
	switch ($background_array[$background_size_index]){
		case 'auto' :
			$backsize='auto;';
			break;
		case 'cover' :
			$backsize='cover;';
			break;
		case 'contain' :
			$backsize='contain;';
			break; 
		case 'hundred' :
			$backsize='100% 100%;';
			break;
		case 'hundredauto' :
			$backsize='100% auto;';
			break;
		case 'custom' :
			$backsize=
$backwidsize.(($backwidsize==='auto')?'':$bsizeunit) .' '.$backheightsize.(($backheightsize==='auto')?'':$bsizeunit) .';';
			break;
		default:
			$backsize='auto;';
		}
	$background_size=(!empty($parallax_size))?'background-size:'.$parallax_size.$backsize:'background-size:'.$backsize; 
	if ($this->is_page|| ($this->is_blog&&!$this->is_clone)||($this->is_column&&!$this->is_clone||$this->clone_local_style)){ 
          $this->show_more('Background Styling','main2','highlight click editbackground editfont','Edit Colors, Gradient   Background Image','300');
		echo '<div class="0s2dodgerblue fsminfo floatleft editbackground editfont"  ><!--background style -->';
		printer::pclear(1);
		echo '<div class="editbackground editfont floatleft"><!--show background color floatwrap-->';
		$this->show_more('Background Color', 'noback','highlight  editbackground editfont','A background Color and Color Opacity May be Chosen Here',500); 
		$colorprint=(!empty($gradient_css)||!empty($back_image_used))?'red':$this->column_lev_color;
		$this->print_redwrap('wrap background color');
		printer::printx( '<div class="fs1black editbackground editfont rad3 '.$colorprint.' editfont"><!--background color-->Background colors will be overridden by valid Background Images or Background Gradients!<br>');
		if (preg_match(Cfg::Preg_color,$background_array[$background_color_index])){
			$msg="Change the Current Background Color, Use 0 to remove: #";
			}
		else {
			$msg= (!empty($background_array[$background_color_index]))?$background_array[$background_color_index] . ' is not a valid color code. Enter or choose a new background color code: #':'Enter or Click to choose a  background color code: #';
			}
		printer::alertx('<span class="highlight left5" title="Add a background color 3 or 6 digit color code or click in the entry box to open the Color finder tool! Enter any blank or 0 to go back to the parent default">'.$msg.'</span><br>');  
		printer::printx('<p class="floatleft"><input style="cursor:pointer;background:#'.$this->editor_background.';color:#'.$this->editor_color.';" onclick="jscolor.installByClassName(\''.$style.'-'.$val.'_'.$inc.'\');" type="text" name="'.$style.'['.$val.']['.$background_color_index.']" id="'.$style.'-'.$val.'_'.$inc.'" value="'. $background_array[$background_color_index].'" size="6" maxlength="6" class="'.$style.'-'.$val.'_'.$inc.' {refine:false}">' .$span_color.'</p>');
		printer::pclear();
		echo '</div><!--background color-->';
		printer::pclear();
		echo '<div class="editbackground editfont fs1color"><!--border opacity-->';
		//echo '<p class="fsminfo  rad3   editfont" style="color:rgba(0,0,255,1); background:rgba(0,0,255,.25);">Background color of this text is set at blue,   the same hexcode blue as the text except the blue background color has been set  with a 25% opacity. The parent background color is the editbackground editfont color which bleeds through. Change the opacity of your background color by choosing an opacity near 0% for very transparent allowing most of the parent background color or image to bleed through. At 50% opacity we see ~ half background color half parent background and at 100% opacity the parent background is colored over completely! </p>';
		echo '<p class="editcolor editbackground editfont ">Change Background Color Opacity:  </p>';
		$this->mod_spacing($style.'['.$val.']['.$background_opacity_index.']',$background_color_opacity,0,100,1,'%');
		echo '</div><!--border opacity-->'; 
          $this->submit_button();
		printer::close_print_wrap('wrap background color');
		$this->show_close('back colors');echo '<!--show back colors-->';
		echo '</div><!--show background color floatwrap-->';
		echo $span_color;
		printer::pclear();
		printer::pclear(1);
		echo '<div class="floatleft"><!--show background gradient floatwrap-->';
		$this->show_more('Background Gradients', 'noback','highlight editbackground editfont','A background Color Gradient of 2 or more colors may be  used instead of a single color',500);echo '<!--show gradients-->';
		$this->print_redwrap('gradient wrap' );
		echo '<div class="fsmblack whitebackground"><!--show gradients-->';
		echo '<div class=" rad3 utilitygrad '.$gradcolor.' editfont floatleft"><div style="margin: 30px auto; width:80%; padding:10px;  background:rgba(255,255,255,.65);">We have used a background gradient behind this info box using the diagonal top left  option and using six colors  to demonstate how a  page or column background effect can be used together along with a post having a white background set at 65% opacity which allows some of the background to bleed through.  When making a gradient Use from two to six colors when making a background gradient  effect. Set any degree on your gradient color choices which will allow the parent background color to bleed through to the degree of the percentage chosen.  Selecting the transparent option without a valid color is still a valid choice and will display 100% background. Otherwise a valid color option must be selected.';
		printer::pclear();	
		$this->show_more(' more gradient info', 'cnoback','click floatleft editbackground editfont');
		printer::printx('Gradient options include none, vertical (top to bottom),  horizontal (left to right gradient),  diagonal top left (a diagonal gradient from top left to bottom  right), repeating diagonal top left,  diagonal top right (a diagonal gradient from top right to bottom left),  radial ellipse (elliptical from inner to outer) and radial circle (circlular from inner to outer).  In additon each choice has a corresponding <b>repeating</b> option. Set how many times the gradient should repeat by setting a colorstop on the last valid color/transparent option of the gradient.  If its set to 50% the gradient can repeat twice, if it is set to 33.3% the gradient will repeat 3 times, 25% and the gradient can repeat 4 times, 40% and the gradient will repeat 2.5 times and so on!!.<span class="'.$colorprint.'">Note: Background Images Will Override Background Gradients</span>');
		$this->show_close('utilitygrad');
		echo '</div></div><!--end utilitygrad-->';
		printer::printx('<p class="'.$this->column_lev_color.' editbackground editfont">Choose Which Gradient Type: Currently: '.$background_gradient_type.'<br>');
		echo '<select class="editcolor editbackground editfont"  name="'.$style.'['.$val.']['.$background_gradient_type_index.']" >        
		<option  value="'.$background_gradient_type.'" selected="selected">'.$background_gradient_type.'</option>'; 
		foreach ($background_gradient_type_array as $type){
			echo'<option  value="'.$type.'">'.$type.'</option> ';
			}
		echo '</select></p>';
		printer::printx('<p class="highlight editbackground editfont" title="By default opacity is 100%.  If you choose the transparent option which is 0% opacity, Skip choosing a color if you wish!">Choose Your Background Gradient Colors and Opacity:<br></p>');
		for ($i=1; $i<7; $i++){
			echo '<div class="fs2black editbackground editfont floatleft"><!--choose grad color-->';
			$opacity=(empty($background_array[${'background_gradient_transparency'.$i.'_index'}]))?100:$background_array[${'background_gradient_transparency'.$i.'_index'}];
			$span_color=(preg_match(Cfg::Preg_color,$background_array[${'background_gradient_color'.$i.'_index'}]))?'<span class="fs1npred" style="background:#'. $background_array[${'background_gradient_color'.$i.'_index'}].'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>':'';
			printer::printx('<p class="editcolor editbackground editfont">Enter Color Hexcode or Choose Color# '.$i.'&nbsp;<input style="cursor:pointer;background:#'.$this->editor_background.';color:#'.$this->editor_color.';" type="text" name="'.$style.'['.$val.']['.${'background_gradient_color'.$i.'_index'}.']" id="'.$style.'-'.$val.'_'.$inc.$i.'"  value="'. $background_array[${'background_gradient_color'.$i.'_index'}].'" size="6" maxlength="6"  onclick="jscolor.installByClassName(\''.$style.'-'.$val.'_'.$inc.$i.'\');" class="'.$style.'-'.$val.'_'.$inc.$i.' {refine:false}">'.$span_color.'</p>');
               printer::printx('<p class="editcolor editbackground editfont">Set an opacity:</p>');
			$this->mod_spacing($style.'['.$val.']['.${'background_gradient_transparency'.$i.'_index'}.']',$opacity,0,100,1,'%',false,'transparent');
			$this->show_more('Optional Colorstop for Color#'.$i,'noback','click editbackground editfont smaller '.$this->column_lev_color);
			echo '<div class="fsminfo editbackground editfont '.$this->column_lev_color.'"><!--color stop-->Gradient Colors will normally blend evenly spaced, however specifying a Colorstop percentage  determines at which point along the gradient the color will stop blending';
			$colorstop=(empty($background_array[${'background_gradient_color_stop'.$i.'_index'}]))?'none':$background_array[${'background_gradient_color_stop'.$i.'_index'}];
               $this->mod_spacing($style.'['.$val.']['.${'background_gradient_color_stop'.$i.'_index'}.']',$colorstop,0,100,1,'%','none');
			echo '</div><!--color stop-->';
			$this->show_close('color stop');
			echo '</div><!--choose grad color-->';
			}
		echo '<div class="editcolor editbackground editfont"><!--wrap position radial-->';
		$this->show_more('Optionally Position Radial Gradient','noback','click editbackground editfont smaller '.$this->column_lev_color);
          $this->print_redwrap('pos radial grad');
		echo '<p class="fsminfo editbackground editfont '.$this->column_lev_color.'">Radial Gradients (ellipses and circles) will Normally Be Centered Positioned. Its also possible Choose To Custom Size and Position Your Gradient Here. See http://gradientcss.com/radial-gradient for a detailed explanation of the gradient options!</p>';
		printer::printx('<p class="'.$this->column_lev_color.' editbackground editfont">Change Radial Horizontal Position (default:50%) Currently: '.$background_gradient_position1.'%<br></p>');
		$this->mod_spacing($style.'['.$val.']['.${'background_gradient_position1_index'}.']', $background_gradient_position1,0,100,1,'%');
		printer::printx('<p class="'.$this->column_lev_color.' editbackground editfont">Change Radial Vertical Position (default:50%) Currently: '.$background_gradient_position2.'%<br></p>');
		$this->mod_spacing($style.'['.$val.']['.${'background_gradient_position2_index'}.']',$background_gradient_position2,0,100,1,'%');
		printer::printx('<p class="'.$this->column_lev_color.' editbackground editfont">Optionally Change Radial Sizing Keyword: Currently: '.$background_gradient_position_keyword.'<br></p>');
		$background_gradient_keyword_array=array('closest-side','closest-corner','farthest-side','farthest-corner');
		echo '<select class="editcolor editbackground editfont"  name="'.$style.'['.$val.']['.$background_gradient_position_keyword_index.']" >        
		<option  value="'.$background_gradient_position_keyword.'" selected="selected">'.$background_gradient_position_keyword.'</option>'; 
		foreach ($background_gradient_keyword_array as $type){
			echo'<option  value="'.$type.'">'.$type.'</option> ';
			}
		echo '</select>'; 
          printer::close_print_wrap('pos radial grad');
		$this->show_close('Position radial gradient');//Position radial gradient
		echo '</div><!--wrap position radial-->';
		$this->submit_button();
		echo '</div><!-- show gradients-->';	
		printer::close_print_wrap('gradient wrap');
		$this->show_close('show gradients');echo '<!--show gradients-->';
		echo '</div><!--show background gradient floatfloatwrap-->';
		$invalid='';//(!empty($back_image_used))?'<img src="'.Cfg_loc::Root_dir.'invalid.gif" height="25" width="25" alt="background color is overridden">':'';
		$span_color='<span class="fs1npred floatleft" style="width:25px; height:25px; '. $gradient_css.'">'.$invalid.'</span>';
		(!empty($gradient_css))&&printer::printx($span_color);
		printer::pclear(1);
		################Background Image Begin	
		echo '<div class="floatleft"><!--background floatwrap-->';
		 $this->show_more('Background Image', 'noback','highlight editbackground editfont',' Use a Background Image  instead of color or color gradients.  Use them in posts, columns and menu link buttons',500);
		if(!empty($background_array[$background_video_index]))
			printer::print_caution('Note: Background image may be overriden by working background video',.7); 
		$this->print_redwrap('wrap background image');
		echo '<div class="fsminfo editbackground editfont rad3 '.$this->column_lev_color.' editfont"><!--background image enter-->A background image behaves similar to background color.  It may also be positioned if necessary<br>'; 
		if (is_file(Cfg_loc::Root_dir.Cfg::Background_image_dir.$background_array[$background_image_index])){    
               $msg2='Change the current Background Image to another previously uploaded image or click the image below to upload a new one:';
               $size	= GetImageSize(Cfg_loc::Root_dir.Cfg::Background_image_dir.$background_array[$background_image_index]);
               $width 			= $size[0];
               $height 		= $size[1];
               }
	    else {
			$width=0;
			$msg2=(empty($background_array[$background_image_index]))?'No Background Image in Use:  Enter a previously uploaded Image or click the link below to upload a new one:':'The Current Background Image is Not a Valid file: Enter a previously Uploaded Image or click the link below to upload a new one:';
			$background_image="";
			}
		echo '</div><!--background image enter-->';
		echo '<div class="'.$this->column_lev_color.' fsminfo editbackground editfont"><!--Upload background image-->Upload a Larger than Needed Background Image Size and the Size Will Always Be Updated to Match the Current Width   + any Padding Left &amp; Right Space Added. Margin Spacings Are Always Outside of Background Effects. Repeating images horizontally, and Uploaded Images smaller than the spaces provided will remain their original sizes!!<br>';
		$clone_local_style=($this->clone_local_style)?'&amp;clone_local_style=1':'';
		printer::alert('<br><a href="add_page_pic.php?wwwexpand=0&amp;www='.$imagepx.'&amp;ttt='.$table.'&amp;fff='.$background_image_field.'&amp;postreturn='.Sys::Self.'&amp;pgtbn='.$this->pagename.'&amp;bbb=background_image_style'.$clone_local_style.'&amp;css='.$this->roots.Cfg::Style_dir.$this->pagename.'&amp;sess_override&amp;sess_token='.$this->sess->sess_token.'"><u> Upload a new background image ...</u></a>');
		echo '</div><!--Upload background image-->';
		echo '<div class="fsminfo editbackground editfont rad3 '.$this->column_lev_color.'"><!--background repeat -->Background Image On/Off/Repeat:<br>';
		$background_image_render=true;
		if  ($background_image_off)printer::alert('<b>Note that Background Image and Gradient have been  toggled off in last set of background settings below.</b>');
		if(!empty($background_array[$background_image_index])&&!empty($background_array[$background_image_use_index])){
			printer::print_info("Background Image is enabled: ".$background_array[$background_image_index]);
			$quality=(!empty($this->page_options[$this->page_image_quality_index])&&$this->page_options[$this->page_image_quality_index]<101&&$this->page_options[$this->page_image_quality_index]>9)?$this->page_options[$this->page_image_quality_index]:Cfg::Pic_quality;
			if (!is_file(Cfg_loc::Root_dir.Cfg::Background_image_dir.$background_array[$background_image_index])){
				if (is_file(Cfg_loc::Root_dir.Cfg::Upload_dir.$background_array[$background_image_index])){
					if ($background_array[$background_image_noresize_index]){
						if (copy(Cfg_loc::Root_dir.Cfg::Upload_dir.$background_array[$background_image_index],Cfg_loc::Root_dir.Cfg::Background_image_dir.$background_array[$background_image_index])){
							($this->edit)&&printer::alert_pos('Missing Background Image has been copied to background directory');
							}
						else mail::alert('Failure to copy background image');
						}
					else {//copy resize image to background image folder
						image::image_resize($background_array[$background_image_index],$imagepx,0,0,Cfg_loc::Root_dir.Cfg::Upload_dir,Cfg_loc::Root_dir.Cfg::Background_image_dir,'file','',$quality,NULL);
						}
					}
				else {
					$tid=($this->is_blog)?$this->blog_id:(($this->is_column)?$this->col_id:'pageback '.$this->pagename);
					$msg='Missing Background image: '.$background_array[$background_image_index]. ' in Ref:'.$tid ;
					printer::alert_neg($msg);
					(Sys::Web)&&mail::alert($msg);
					$background_image_render=false;
					}
				}
				
			if (is_file(Cfg_loc::Root_dir.Cfg::Background_image_dir.$background_array[$background_image_index])){ 
				echo '<p class="fsmredAlert rad3 '.$this->column_lev_color.' editbackground editfont">Note: A background image is set to on which overlays the background color.: '.Cfg_loc::Root_dir.Cfg::Background_image_dir.$background_array[$background_image_index].'<br>as: <br>
				background-image:url('.Cfg_loc::Root_dir.Cfg::Background_image_dir.$background_array[$background_image_index].');</p>';
				
			    echo '<p class="left5 editcolor editbackground editfont">Edit your background image here:</p>';
			    list($width,$height)=$this->get_size($background_array[$background_image_index], Cfg_loc::Root_dir.Cfg::Background_image_dir);
			    $size=($width/$height >1)?' width="150"':' height="150"'; 
			    printer::printx('<img  src="'.Cfg_loc::Root_dir.Cfg::Background_image_dir.$background_array[$background_image_index].'" '.$size.' alt="background-images">');
			    }
			}
		printer::pclear();
		if (!is_file(Cfg_loc::Root_dir.Cfg::Background_image_dir.$background_array[$background_image_index])&&$background_array[$background_image_use_index]==1){
			printer::alert('<input name="'.$style.'['.$val.']['.$background_image_use_index.']" type="checkbox" value="0" >Turn off Background Image<br>');
			}
		else if (is_file(Cfg_loc::Root_dir.Cfg::Background_image_dir.$background_array[$background_image_index])&&$background_array[$background_image_use_index]==1){
			if ($this->edit&&(empty($background_array[$background_repeat_index])||$background_array[$background_repeat_index]==='no-repeat'||$background_array[$background_repeat_index]==='repeat-y')&&!$background_array[$background_image_noresize_index]){  
				list($width,$height)=$this->get_size($background_array[$background_image_index],Cfg_loc::Root_dir.Cfg::Background_image_dir);
				if ($imagepx > $width*1.03 || $imagepx < $width * .97){
					$return=$this->resize($background_array[$background_image_index],$imagepx,0,0,Cfg_loc::Root_dir.Cfg::Upload_dir,Cfg_loc::Root_dir.Cfg::Background_image_dir,'backgroundimage field: '.$field.' style:'.$style,'file','Background Image',NULL,'95','center',false );
					($return)&&$this->success[]="image px is $imagepx and required width is $width ".'<div><img src="'.Cfg_loc::Root_dir.Cfg::Background_image_dir.$background_array[$background_image_index].'" class="floatleft" height="50" ><p class="pl10 maxwidth400 small floatleft">This Background Image photo '.$background_array[$background_image_index].' in Post Id'.$this->blog_id.' was resized to width '. $imagepx.'</p></div>';
					} 
				}
			printer::alert('<input name="'.$style.'['.$val.']['.$background_image_use_index.']" type="checkbox" value="0" >Turn off Background Image<br>');
			}
		else if (is_file(Cfg_loc::Root_dir.Cfg::Background_image_dir.$background_array[$background_image_index]))
			printer::alert('<input name="'.$style.'['.$val.']['.$background_image_use_index.']" type="checkbox" value="1" >Turn on Previously Loaded Background Image<br>');			 
		else {
			if ($background_array[$background_image_none_index]==1)
				printer::alert('<input name="'.$style.'['.$val.']['.$background_image_none_index.']" type="checkbox" value="0" >Allow Background Image<br>');
			else printer::alert('<input name="'.$style.'['.$val.']['.$background_image_none_index.']" type="checkbox" value="1" >Prevent Background Image<br>');
			}
		$repeatclass='';
		$a1='no-repeat'; $a2='repeat-x'; $a3='repeat-y'; $a4='repeat';
		$b1=$b2=$b3=$b4='';$flag=false;
		for ($i=1;$i<5;$i++){
			if(!empty($background_array[$background_repeat_index])&&$background_array[$background_repeat_index]===${'a'.$i}){ ${'b'.$i}=' checked="checked" ';$flag=true; }
			}
		if(!$flag){
			$b1=' checked="checked" ';
			$repeatclass='class="allowthis"';
			}
		printer::alert('
	    <input name="'.$style.'['.$val.']['.$background_repeat_index.']" '.$repeatclass.' type="radio" value="no-repeat" '.$b1.' >Do Not Repeat this image<br>
	    <input name="'.$style.'['.$val.']['.$background_repeat_index.']" type="radio" value="repeat-x" '.$b2.'>Repeat this image horizontally only<br>
	    <input name="'.$style.'['.$val.']['.$background_repeat_index.']" type="radio" value="repeat-y" '.$b3.'>Repeat this image vertically only<br>
	    <input name="'.$style.'['.$val.']['.$background_repeat_index.']" type="radio" value="repeat" '.$b4.'>Repeat this image vertically and horizontally<br>');
		
		echo '</div><!--background repeat -->';
          printer::pclear(7);
		 echo '<div class="fsminfo editbackground editfont rad3 '.$this->column_lev_color.' editfont"><!--Background Image Size-->Choose Background Image Size:<br>';
          $a1='auto'; $a2='cover'; $a3='contain'; $a4='hundred';$a5='custom';$a6='hundredauto';
		$b1=$b2=$b3=$b4=$b5=$b6='';$flag=false;
		for ($i=1;$i<7;$i++){
			if(!empty($background_array[$background_size_index])&&$background_array[$background_size_index]===${'a'.$i}){ ${'b'.$i}=' checked="checked" ';$flag=true; }
			}
		(!$flag)&&$b1=' checked="checked" ';
		printer::alertx('
	    <p class="highlight" title="Use Original Uploaded Image Size" ><input name="'.$style.'['.$val.']['.$background_size_index.']" type="radio" value="auto" '.$b1.' >Use As Is Image Size</p>
	    <p class="highlight" title="Image resized to 100% width and height scaled to maintain width/height ratio"><input  name="'.$style.'['.$val.']['.$background_size_index.']" type="radio" value="cover" '.$b2.'>Cover to Full Width</p>
	    <p class="highlight" title="Image is proportionally scaled to maximum size without exceeding full width or full height" ><input name="'.$style.'['.$val.']['.$background_size_index.']" type="radio" value="contain" '.$b3.'>Contain Width</p>
	    <p class="highlight" title="Image width and height each independenly stretched to occupy 100% of the available space."><input  name="'.$style.'['.$val.']['.$background_size_index.']" type="radio" value="hundred" '.$b4.'>Image to Fill 100% width and 100% height</p>
	    <p class="highlight" title="Image width independenly stretched to occupy 100% of the available space with height auto."><input  name="'.$style.'['.$val.']['.$background_size_index.']" type="radio" value="hundredauto" '.$b6.'>100% width with auto height</p>'); 
		//echo '<div class="fs1npinfo floatleft"><!--wrap background size-->';
		printer::alertx('<p onclick="edit_Proc.displaythis(\''.$style.'_displaypercent\',this,\'#fdf0ee\')"  class="highlight" title="Enter value of Width to Fill, value  of Height to Fill" ><input class="myinput" name="'.$style.'['.$val.']['.$background_size_index.']" type="radio" value="custom" '.$b5.' >Or Set custom value for width and height &amp; choose units&nbsp;</p>');
		 printer::print_wrap1('Instead choose a custom width / height value');  
		
		printer::print_tip('Choose units');
		$display='block';//($background_array[$background_size_index]===$a5)?'block':'none';
		forms::form_dropdown($bsizeunit_arr,'','','',$style.'['.$val.']['.$background_size_units_index.']',$bsizeunit,false,'editcolor editbackground editfont left');
		echo'<p style="display:'.$display.'" id="'.$style.'_displaypercent" class="editcolor editbackground editfont ">
		Image Size Fill  Available Width Value: ';
          $msgjava = 'Choose Width Value:'; 
		$this->mod_spacing($style.'['.$val.']['.$background_pos_width_index.']',$background_array[$background_pos_width_index],0,4000,1,'units','auto',$msgjava);
          $msgjava = 'Choose Height Value:';
		echo'<p style="display:'.$display.'" id="'.$style.'_displaypercent" class="editcolor editbackground editfont ">
		Image Size Fill Height Value: ';
          printer::pclear(7); 
		$this->mod_spacing($style.'['.$val.']['.$background_pos_height_index.']',$background_array[$background_pos_height_index],0,4000,1,'units','auto',$msgjava); 
          printer::pclear(7);
          echo '</div><!--Background Image Size-->';
		
          printer::pclear(2);
		printer::close_print_wrap1('custom width percent');
          printer::pclear(7);
          
         printer::print_wrap1('parallax background image');
		printer::print_tip('If the <b>parallax-background</b> effect is enabled under the parallax settings you can further Enable or Disable the Parallax Background Reversing Effect upon scrolling here. Uses opacity:100%;  background-attachment: fixed, fixed; and initially a background-position: top left, bottom center;');
	$checked1=($background_parallax_reverse)?'checked="checked" ':'';
	$checked2=(!$background_parallax_reverse)?'checked="checked" ':'';
	printer::alert('<input type="radio" name="'.$style.'['.$val.']['.$background_parallax_reverse_index.']" '.$checked1.' value="background_parallax_reverse">Enable Parallax Background Image Reverse');
	printer::alert('<input type="radio" name="'.$style.'['.$val.']['.$background_parallax_reverse_index.']" '.$checked2.' value="background_reverse_off">Disable Parallax Background Image Reverse');
		printer::close_print_wrap1('parallax background image');
          echo '<div class="fsminfo editbackground editfont"><!--Image opacity-->';
          echo '<p class="editcolor editbackground editfont ">Change Background Image Opacity:  </p>';
          $this->mod_spacing($style.'['.$val.']['.$background_image_opacity_index.']',$background_image_opacity,1,100,1,'%');
          
		printer::pclear();
		printer::print_wrap('Opac pos tweak');
          printer::print_tip('Optional Tweak Image Position If Using opacity < 98% ');
		printer::printx('<p class="'.$posvclass.' editcolor editbackground editfont">Image Position left (0) to right (100) Change:</p>');
          $msgjava = 'Choose horizontal Positioning:';
		$this->mod_spacing($style.'['.$val.']['.$background_horiz_index.']',$bhval,0,100,1,'%','',$msgjava);
          printer::pclear(7);
		printer::printx('<p class="'.$posvclass.' editcolor editbackground editfont">Image Position top (0) to bottom (100) Change:'); 
          $msgjava = 'Choose vertical Positioning:'; 
		$this->mod_spacing($style.'['.$val.']['.$background_vert_index.']',$bvval,0,100,1,'%','',$msgjava);
          
          printer::close_print_wrap('Opac pos tweak');
          printer::pclear(7); 
		echo '</div><!--image opacity-->';
          echo '<div class="fsminfo"><!--wrap resize fixed-->';
          if ($background_array[$background_fixed_index]!=='back_fixed'){
			printer::alertx('<p class="highlight editbackground editfont" title="When you Scroll Down the Page The Background Image Normally Scrolls Also But with a Checked Box Here the Background Image will Remain Stationary"><input type="checkbox"  name="'.$style.'['.$val.']['.$background_fixed_index.']"  value="back_fixed">Check to prevent normal Scrolling of the Background Image (ie. background-attachment:fixed)</p>');
			}
		else {
			printer::alertx('<p class="highlight editfont  editbackground editfont" ><input type="checkbox"  name="'.$style.'['.$val.']['.$background_fixed_index.']"  value="back_scroll">Check for Normal Scroll of the background Image</p>');
			}
		echo '</div><!--wrap resize fixed-->';
		
		if ($background_array[$background_image_noresize_index]==1)
			printer::alertx('<p class="highlight smallest" title="Allow Background Images to be resized when post is resized according to available width and image size"><input name="'.$style.'['.$val.']['.$background_image_noresize_index.']" type="checkbox" value="0" >Allow Background Image Resizing<br></p>');
		else printer::alertx('<p class="highlight smallest" title="Prevent Background Images from being resized (and image resize messages when updating) "><input name="'.$style.'['.$val.']['.$background_image_noresize_index.']" type="checkbox" value="1" >Prevent Background Images from resizing<br></p>');
		printer::pclear(2);
          $this->submit_button();
		printer::close_print_wrap('wrap background image');
		$this->show_close('Background Image');//background
		#########videoback
             
		echo '</div><!--  show more background floatwrap-->';
		if(!empty($background_array[$background_image_index])&&!empty($background_array[$background_image_use_index])&&is_file(Cfg_loc::Root_dir.Cfg::Background_image_dir.$background_array[$background_image_index])){
			$opacitybackground=true;
			 $size=($width/$height >1)?'width="25"':'height="25"'; 
			printer::printx('<img  class="fs1npred mt5" src="'.Cfg_loc::Root_dir.Cfg::Background_image_dir.$background_array[$background_image_index].'" '.$size.' alt="background image">');
			}
		$text=($background_image_off)?'Background Toggled Off':'Background Toggle Off';
          $this->show_more('Background Toggle Off','','highlight  editbackground editfont');
          printer::print_wrap('Background Toggle off');
          printer::print_info('Quickly Toggle on/off background color or  a background Gradients/Image without changing configs here. Can also be used in nav submenus to disable particlular styles made in main menu.<br> Specifies background-color:transparent;<br>or background-image:none; for images or gradient'); 
          $checked=' checked="checked" ';
          $checked1=($background_array[$background_color_off_index]==='coloroff')?$checked:''; 
          $checked2=($background_array[$background_color_off_index]!=='coloroff')?$checked:'';    
          printer::alert('<input type="radio" name="'.$style.'['.$val.']['.$background_color_off_index.']" '.$checked1.' value="coloroff" >Display background color OFF');
          printer::alert('<input type="radio" name="'.$style.'['.$val.']['.$background_color_off_index.']" '.$checked2.' value="1" >Display background color ON');
          $checked1=($background_array[$background_image_off_index]==='imageoff')?$checked:''; 
          $checked2=($background_array[$background_image_off_index]!=='imageoff')?$checked:'';    
          printer::alert('<input type="radio" name="'.$style.'['.$val.']['.$background_image_off_index.']" '.$checked1.' value="imageoff" >Display background image or gradient OFF');
          printer::alert('<input type="radio" name="'.$style.'['.$val.']['.$background_image_off_index.']" '.$checked2.' value="1" >Display background image or gradient ON');
          printer::close_print_wrap('Background Toggle off');
          $this->show_close('Background Toggle off');     
		echo '</div><!--background style border -->';
		$this->show_close('background');//<!--show close background-->';
		printer::pclear();
		}//if editable
	$background_fixed=(!empty($parallax_fixed))?$parallax_fixed:(($background_array[$background_fixed_index]==='back_fixed')?'
	background-attachment: fixed; ':''); 
     $background_repeat=($background_array[$background_repeat_index]==='repeat-x'||$background_array[$background_repeat_index]==='repeat-y'||$background_array[$background_repeat_index]==='repeat') ?' background-repeat: '.$parallax_repeat.$background_array[$background_repeat_index].';':' background-repeat:'.$parallax_repeat.'no-repeat;';
	$background_position=(!empty($parallax_position))?$parallax_position:'background-position: '.$bhval.'% '.$bvval.'%;';
	$background_url=' background-image:'.$parallax_url.'url('.Cfg_loc::Root_dir.Cfg::Background_image_dir.$background_array[$background_image_index].'); ';
	$video_css='';//currently not used (!empty($background_array[$background_video_index])&&strlen($background_array[$background_video_index])>30&&($field==='blog_style'||$field==='col_style'))?'position:relative;z-index:1;':''; 
	$fstyle='final_'.$style; 
	if (strpos($style,'page_style')!==false&&!empty($gradient_css)&&!empty($background_image_off)){
          //hack to use body:before for background gradient.
          $this->pagecss.='
body:before {
	content:"";
	position:fixed;
	left:0;
	top:0;
	right:0;
	bottom:0;
	z-index:-1;'  
	.$gradient_css.' 
     }'; 
          $gradient_css='';
          }
     $gradient_css=($background_image_off)?'':$gradient_css;
     $background_color=($background_color_off)?'':$background_color;  
	if ($background_image_opacity>96||!$opacitybackground||$background_parallax_reverse){  
		if ($background_image_opacity<97&&$background_parallax_reverse)
			printer::print_warnlight('Opacity on background image uses pseudo element :after effect which presently not enabled for Parallax reversing effect. Recommeded to photoshop image opacity and leave the background opacity at 100% to keep reversing effect.');
		$background_image=($background_image_off)?'background:none;':((is_file(Cfg_loc::Root_dir.Cfg::Background_image_dir.$background_array[$background_image_index])&&!empty($background_array[$background_image_use_index]))?$background_fixed.$background_url.$background_repeat . $background_position.$background_size :(($background_array[$background_image_none_index])?'background-image:none;':''));  
		$fstyle='final_'.$style;
		$this->{$fstyle}[$val]=$background_color.$gradient_css.$background_image.$video_css; 
		}
	else{ //opacity on..
		$fstyle='final_'.$style; 
		$this->{$fstyle}[$val]='position:relative;z-index:1;'.$background_color.$gradient_css;
		$background_image=$background_image=($background_image_off)?'background:none;':((is_file(Cfg_loc::Root_dir.Cfg::Background_image_dir.$background_array[$background_image_index])&&!empty($background_array[$background_image_use_index]))?$background_fixed.$background_url.$background_repeat .' left: '.$bhval.'%; top:'.$bvval.'%;'.$background_size :(($background_array[$background_image_none_index])?'background-image:none;':''));
		$background_opacity='opacity:'.($background_image_opacity/100).';';
		if (strpos($background_image.$background_opacity,'@@')!==false)return;
			$pelement=str_replace(',',':after,',trim($this->pelement,','));
			$this->css.="\n".trim($pelement).':after { 
    content : "";
    width: 100%;
    height: 100%;
    display: block;
    position: absolute;
    z-index: -1;
    '.
$background_image.'
   '.$background_opacity.'}'; 
          $css_id=($this->is_column)?$this->col_dataCss:$this->dataCss;
          $this->editoverridecss.='#'.$css_id.' {position:relative !important;}';
          $this->overlapbutton=true; 
		}//end opacity
	}//end background#end background 
	
function text_align($style, $val, $field){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	//show_text_style is a hack to enable display of only the text-align option when display menu general styles which actually affects menu link position justificcation. is false for other applications ie display none until main text style link is clicked in styling options
	$display=($this->show_text_style)?'':' style="display:none;"';
	$class=($this->show_text_style)?'':'fsminfo';
	$txtmsg=(false)?'Link Align: ':'Text Align: ';//($this->is_blog&&$this->blog_type==='navigation_menu')&&$field==='blog_style'
	$title=(false)?'This setting will change the positioning of Links within Navigation Menus':'Select Left right or Center Align the text widthin this post/Can also Effect Image. If none is selected it will inherit the value from the parent &#40;Which may be a Column or the Body Setting&#41;';
	if ($this->is_page|| ($this->is_blog&&!$this->is_clone)||($this->is_column&&!$this->is_clone||$this->clone_local_style)){  
		$textalign= ($this->{$style}[$val]!=='left'&&$this->{$style}[$val]!=='right'&&$this->{$style}[$val]!=='center')? 'Inherited': $this->{$style}[$val];
		echo '<div class="'.$class.' editbackground editfont floatleft '.$style.'_hidefont"'.$display.'><!--text align border-->';
		echo'<p class="highlight" title="'.$title.'">'.$txtmsg.' Currently '.$textalign.'</p>';
		echo '<p>
		<select class="editcolor editbackground editfont"  name="'.$style.'['.$val.']" id="'.$style.'_'.$val.'">        
		<option  value="'.$this->{$style}[$val].'" selected="selected">'.$textalign.'</option>
		<option  value="0">Choose None</option>
		<option  value="left">Left Align</option>
		<option  value="center">Center Align</option> 
		<option  value="right">Right align</option> 
		</select>';
		echo'
		</p></div><!--text align border-->';
		printer::pclear(2);
		}
	$fstyle='final_'.$style;
	$this->{$fstyle}[$val]=(!empty($this->{$style}[$val]))?' text-align: '.$this->{$style}[$val].';':'0';
    }
    
//italics-font,small-caps,line-height,letter-spacing';
function line_height($style,$val){   if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
		$arr=array('normal','1.6','30%','40%','50%','60%','70%','80%','90%','100%','150%','200%','250%','300%');
	$sval=(!empty($this->{$style}[$val])&&in_array($this->{$style}[$val],$arr))?$this->{$style}[$val]:'';
	if ($this->is_page|| ($this->is_blog&&!$this->is_clone)||($this->is_column&&!$this->is_clone||$this->clone_local_style)){  
		echo '<div class="fs1color floatleft '.$style.'_hidefont" style="display:none;"><!--Edit line height-->';  
		echo '<p class="'.$this->column_lev_color.' editfont ">Adjust line height between lines:</p>';
		forms::form_dropdown($arr,'','','',$style.'['.$val.']',$sval,false,'editcolor editbackground editfont left');
		echo '</div><!--Edit line height-->';
          }
	$fstyle='final_'.$style;
	$this->{$fstyle}[$val]=(!empty($sval))?'line-height:'.$sval.';':'';
	}//end function

function letter_spacing($style,$val){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
    $letter_arr=explode('@@',$this->{$style}[$val]);
    for ($i=0; $i<2;$i++){
          if(!array_key_exists($i,$letter_arr))$letter_arr[$i]=0;
          }
    $letter_unit=($letter_arr[1]==='rem'||$letter_arr[1]==='em')?$letter_arr[1]:'em';
    $sval=(!empty($letter_arr[0])&&$letter_arr[0]>=-.3&&$letter_arr[0]<=5)?$letter_arr[0]:0;
	if ($this->is_page|| ($this->is_blog&&!$this->is_clone)||($this->is_column&&!$this->is_clone||$this->clone_local_style)){  
          echo '<div class="fs1color floatleft pt10 pb10 '.$style.'_hidefont" style="display:none;"><!--Edit letter spacing-->';
          $this->show_more('Letter Spacing','',' highlight editbackground editfontfamily','Change default letter-spacing of 0 by adding or subtracting space between leters');
          printer::print_redwrap('letter spacing');
		echo '<p class="'.$this->column_lev_color.' editfont ">Add or Subtract space between letters</p>'; 
		 printer::alert('Choose unit:');
          $checked=' checked="checked" ';
          $checked1=($letter_unit!=='rem')?$checked:'';
          $checked2=($letter_unit==='rem')?$checked:'';     
          printer::alert('<input type="radio" name="'.$style.'['.$val.'][1]" value="em" '.$checked1.'>em units');
          printer::alert('<input type="radio" name="'.$style.'['.$val.'][1]" value="rem" '.$checked2.'>rem units'); 
          printer::pclear(5);
          $msg=(empty($sval))?'default':$sval;
          echo'<p class="'.$this->column_lev_color.' editbackground editfont">Letter-spacing: Currently '.$msg.'<br>';
          $msgjava='Choose letter spacing:'; 
          $this->mod_spacing($style.'['.$val.'][0] ',$sval,-.3,5,.01,'units','none',$msgjava); 
          printer::close_print_wrap('letter spacing');
		$this->show_close('Letter Spacing');
          echo '</div><!--Edit letter spacing-->';
          }
	$fstyle='final_'.$style;
	$this->{$fstyle}[$val]=(!empty($sval)&&is_numeric($val))?'letter-spacing:'.$sval.$letter_unit.';':'';
     }//end function
	 
function italics_font($style,$val){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
     $var='font-style:italic;';  
     $this->font_effects($style,$val,$var);
     }//end function
	 
function small_caps($style,$val){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
    $var='font-variant: small-caps;';
    $this->font_effects($style,$val,$var);
     }//end function 

function text_underline($style, $val, $field){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
     $var='text-decoration:underline;';
     $this->font_effects($style,$val,$var);
     }//end function
	 	 
function font_effects($style,$val,$var){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);  
     if ($this->is_page|| ($this->is_blog&&!$this->is_clone)||($this->is_column&&!$this->is_clone||$this->clone_local_style)){
		$functions=explode(',',Cfg::Style_functions);
		if (array_key_exists($val,$this->$style)&&$this->{$style}[$val]) :
			echo '<p class="'.$this->column_lev_color.' editfont '.$style.'_hidefont" style="display:none; text-align: left;"><input type="checkbox"  name="'.$style.'['. $val .']"   value="0">Turn Off '. $functions[$val].'</p>';
		else :
			echo '<p class="'.$this->column_lev_color.' editfont '.$style.'_hidefont" style="display:none;text-align: left;"><input type="checkbox"  name="'.$style.'['. $val .']"  value="1">Turn On '. $functions[$val].'</p>';
		endif;
		}
	$fstyle='final_'.$style; 
	$this->{$fstyle}[$val]=($this->{$style}[$val])?$var:'';
	}
  
function font_color($style, $val, $field ,$msg=''){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	if ($this->is_page|| ($this->is_blog&&!$this->is_clone)||($this->is_column&&!$this->is_clone||$this->clone_local_style)){  
		static $fontcinc=0; $fontcinc++;
		(empty($msg))&&print '<p class="highlight click   floatleft" title="edit various text styles" id="font'.$fontcinc.'"  onclick="edit_Proc.getTags(\''.$style.'_hidefont\',\'showhide\',id);return false;">Text Styles</p>';
		if (!empty($msg)) {
			$hidefont='';
			$bordercolor='';
			$styledisplay='';
			}
		else {
			$msg='Enter/Choose Font Color';
			$hidefont=$style.'_hidefont';
			$bordercolor='fsminfo editbackground editfont';
			$styledisplay='style="display:none"';
			} 
		printer::pclear();  
		$background=(preg_match(Cfg::Preg_color,$this->{$style}[$val]))?'background: #'.$this->{$style}[$val].';':'background: #'.$this->current_color.';';
          $currentcolor=(preg_match(Cfg::Preg_color,$this->{$style}[$val]))?$this->{$style}[$val]:'inherited';
		$span_color='<span class="fs1npred" style="'.$background.' color:#'.$this->current_background_color.';">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>';
		echo'
		<div class="'.$bordercolor.' floatleft '.$hidefont.'" '.$styledisplay.'> <p class="highlight" title="Change the text color (font) of this post by Entering a valid font color 3 or 6 digit color code or clicking in the entry box which opens the Color Selector tool! Enter any blank or 0 to go back to the inherited parent color &#40;Inherited Parent Values are the most recent values that have been set in the parent Columns and if not set there then in the body or the default black!!">'.$msg.' : #<input onclick="jscolor.installByClassName(\''.$style.'_'.$val.'\');"  style="cursor:pointer;background:#'.$this->editor_background.';color:#'.$this->editor_color.';"  class="'.$style.'_'.$val.' {refine:false}"   name="'.$style.'['.$val.']"  id="'.$style.'_'.$val.'" value="'.$currentcolor.'"
		size="6" maxlength="6"  >'.$span_color.'</p>  
		';
		printer::pclear(1); 
		echo'
		</div>';
		}
	$fstyle='final_'.$style;
	$this->{$fstyle}[$val]=(!empty($this->{$style}[$val])&&preg_match(Cfg::Preg_color,$this->{$style}[$val]))?'color: #'.$this->{$style}[$val].';':0;//'color: #'.$this->current_color.';';   
     }


#alt_resp
function width_options($type,$data){ 
	$this->show_more('em, rem, %, px &amp; px scale opt for  min-width, max-width, &amp; width choices');
	$this->print_redwrap('more width');
     printer::print_info('Note: Choosing a main width mode value (or using RWD Grid) overrides any choices made from options here. To deactivate main width use mode 1 with main value 0');
	if ($this->is_column)
		printer::print_tip('As rem em and px choices made here may be tied directly to viewport rwd scaling, the width tracking information for rwd grid and the main max-width choices will not be available for subsequent posts within this column. RWD grid w/o width calc however will still be usuable if needed.',.7);
     printer::print_tip('Alt scaling width units  ie. em, rem,  %, px may be used instead of the main width mode without width tracking and is compatible with active flex-items initial sizing');
     if ($this->{'use_'.$type.'_main_width'})printer::print_info('Main width choice is activated and will override these options.');
	$css_id=($this->is_column)?$this->col_dataCss:$this->dataCss;
     $this->show_more('Style info','','info italic smaller');
     printer::print_wrap1('techinfo');
     printer::print_info('Width choices made here are directly applied to '.$type.' main div class: .'.$css_id .' (unless overriden as outlined above)');
     printer::close_print_wrap1('techinfo');
     $this->show_close('Tech info');
	$this->width_max_special($data.'_'.$type.'_options',$this->{$type.'_max_width_alt_opt_index'},'','.'.$css_id,$this->{'use_'.$type.'_main_width'});
	$this->width_special($data.'_'.$type.'_options',$this->{$type.'_width_alt_opt_index'},'','.'.$css_id,$this->{'use_'.$type.'_main_width'});
	$this->width_min_special($data.'_'.$type.'_options',$this->{$type.'_min_width_alt_opt_index'},'','.'.$css_id,$this->{'use_'.$type.'_main_width'});
	printer::close_print_wrap('more width');	
	$this->show_close('em, rem, px with scale, min-width, max-width, &amp; width choices');
	}
     
function isSerialized($s){//from stackoverflow
     if(stristr($s, '{' ) != false &&
          stristr($s, '}' ) != false &&
          stristr($s, ';' ) != false &&
          stristr($s, ':' ) != false){
          return true;
          } 
     return false;
     }
	
function position_class($style, $val, $field){
	$options=$this->{$style}[$val];
     $type=($this->is_column)?'Column':'Post';
	$prefix=($this->is_column)?'col':'blog'; 
     $css_id=$this->pelement;   
	$options=explode('@@',$options);
	//see Cfg::Position_options for keys to $options array.
	$c_opts=count(explode(',',Cfg::Position_options));
     $count=3;//number of @media position options
	$mcount=$count*$c_opts;
     for ($i=0;$i<$mcount; $i++){
		if (!array_key_exists($i,$options))$options[$i]=0;
		}  
	$pos_horiz_vals_arr=array('none','left','right','center horizontally');
	$pos_vert_vals_arr=array('none','top','bottom','center vertically'); 
	$pos_arr=array('static','relative','absolute','fixed','none'); 
	#note: pos property, pos property, and advanced styles use css 	#id to override normal styles which use distinct classnames
	$msg='Responsive positioning option for this '.$type;
	$this->show_more('Position Options','','editbackground editfont hightlight italic',$msg,'800');
	$this->print_redwrap('wrap advanced position',true);
     printer::print_info('Choosing relative or absolute elements activates left right positioning choices and z-index stacking order. Choosing an opacity also changes z-index value of element.');
     for ($i=0; $i<3; $i++){
          $k=$i*$count;//
          if ($i>0){
               $this->show_more('Add additional @media query controlled option tweak for position options');
               $this->print_redwrap('additional media wrap #'.$i);
               printer::print_tip('Relative or Aboslute value again required for activation of top or left values');
               }
		$mediaopen='';
		$name=$style.'['.$val.']';
          $pos_horiz_val_name=$pos_vert_val_name=$style;
          $max_name=$name.'['.($this->position_max_index+$k).']';
          $min_name=$name.'['.($this->position_min_index+$k).']';
          $orientation_name=$name.'['.($this->position_orientation_index+$k).']';
          $operator_name=$name.'['.($this->position_operator_index+$k).']';
          $pos_name=$name.'['.($this->position_index+$k).']';
          $pos_vert_name=$name.'['.($this->position_vert_index+$k).']';
          $pos_horiz_name=$name.'['.($this->position_horiz_index+$k).']';
          $pos_zindex_name=$name.'['.($this->position_zindex_index+$k).']';
          $pos_horiz_val=$options[$this->position_horiz_val_index+$k];
          $pos_vert_val=$options[$this->position_vert_val_index+$k];
          $pos_horiz=(!empty($options[$this->position_horiz_index+$k])&&in_array($options[$this->position_horiz_index+$k],$pos_horiz_vals_arr))?$options[$this->position_horiz_index+$k]:'none'; 
          $pos_vert=(!empty($options[$this->position_vert_index+$k])&&in_array($options[$this->position_vert_index+$k],$pos_vert_vals_arr))?$options[$this->position_vert_index+$k]:'none';
          $pos_type=(in_array($options[$this->position_index+$k],$pos_arr,true))?$options[$this->position_index+$k]:'none';  
          $ifemptyvert=($pos_type!='static'&&$pos_type!='none'&&$pos_vert==='top'||$pos_vert==='bottom')?$pos_vert.':0;':'';
          $ifemptyhoriz=($pos_type!='static'&&$pos_type!='none'&&$pos_horiz==='right'||$pos_horiz==='left')?$pos_horiz.':0;':'';
          $pos_zindex=($pos_type!='static'&&$pos_type!='none'&&is_numeric($options[$this->position_zindex_index+$k]))?$options[$this->position_zindex_index+$k]:'none';
          $mediacss='';
          $pos_zindex_style=(is_numeric($pos_zindex))?'z-index:'.(int)$pos_zindex.';':'';
          if ($pos_type!='static'&&$pos_type!='none'&&$pos_horiz==='center horizontally')
               $pos_horiz_style='left: 0;  right: 0;  margin-left: auto; margin-right: auto;'; 
          else $pos_horiz_style='';
          if ($pos_type!='static'&&$pos_type!='none'&&$pos_vert==='center vertically') 
               $pos_vert_style='top: 50%;transform: translateY(-50%); -ms-transform: translateY(-50%);-webkit-transform: translateY(-50%);';
          else $pos_vert_style='';
          $pos_css=($pos_type!=='none')?'position:'.$pos_type.';':'';
          $this->editoverridecss.=$css_id.'{position:static !important; transform: none;-ms-transform: none;-webkit-transform: none;z-index:0 !important;}';
          $this->submit_button();
          printer::pclear(5);
          printer::alertx('<div class="'.$this->column_lev_color.' fsminfo  floatleft editbackground editfont">Choose Position Option');
          //printer::print_warnlight('Use Settings: Position jSticky option for sticky top positioning for consistent cross-browser effect');
          printer::print_tip(' Normal layout displays use static. Choose it to turn off advanced position option. Fixed position will lock the post or column from scrolling down the page and useful for anchor menus. Relative and Absolute may be use to overlap posts and or columns relative to a parent column "set to relative" or absolute to the body. Position Top Bottom Left and Right, or center only work with Fixed, Relative, or Absolute Positioning enabled.');
          forms::form_dropdown($pos_arr,'','','',$pos_name,$pos_type,false,'editcolor editbackground editfont left');
          printer::alertx('</div>');
          printer::print_wrap1('horiz value');  
          printer::print_tip('If Position is Set to Relative or Absolute Choose to Modify the left right alignment of this '.$type.' by selecting the option type and value<br>');
          printer::pclear();
          printer::alertx('<div class="'.$this->column_lev_color.' fsminfo maxwidth500 floatleft editbackground editfont">Choose Right or Left, None (As is), or use Center Horizonally.'); 
          forms::form_dropdown($pos_horiz_vals_arr,'','','',$pos_horiz_name,$pos_horiz,false,'editcolor editbackground editfont left');
          printer::alertx('</div>');
          printer::pclear();
          printer::print_wrap('Choose pos units');
          printer::print_tip('Choose px, em, rem, units. Otherwise a default value of 0 will be used');
          printer::pclear(); 
          $horizpass=($pos_horiz==='left'||$pos_horiz==='right')?$pos_horiz:'none';
          $horiz_val=$this->spacing($pos_horiz_val_name,$this->{$prefix.'_pos_horiz_val_index'}+$k,'return','Choose left or right positioning value','Adjust Horiz Position of absolute or relative positioned element/post/column','',$ifemptyhoriz,'','');
          
          $horiz_val=(empty($horiz_val))?'0':$horiz_val;
          $final_horiz_val=($horizpass!=='none')?$horizpass.':'.$horiz_val.';':'';
          printer::close_print_wrap('Choose pos units');
          printer::close_print_wrap1('horiz value');
          printer::pclear(5);
          printer::print_wrap1('vert value');  
          printer::print_tip('If Position is Set to Relative or Absolute Choose to Modify the Top Bottom alignment of this '.$type.' by selecting the option type and value<br>');
          printer::alertx('<div class="'.$this->column_lev_color.' fsminfo maxwidth500 floatleft editbackground editfont">Choose to position using Top or Bottom, None (As is), or use Center Vertically. <b>Note using both Center Vertically and an animation on this same post can change the animation path ie. on sliding animations</b>'); 
          forms::form_dropdown($pos_vert_vals_arr,'','','',$pos_vert_name,$pos_vert,false,'editcolor editbackground editfont left'); 
          printer::alertx('</div>');
          printer::pclear(); 
          printer::alertx('<div class="fs1black editcolor editbackground editfont">If Position is Set to Relative or Absolute and you also Choose a position Top or Bottom  choose a numeric value here in percent, px, em, rem, vw, or vh units. Otherwise a default value of 0 will be used');
          printer::pclear(10);
          $vertpass=($pos_vert==='top'||$pos_vert==='bottom')?$pos_vert:'none';
          $vert_val=$this->spacing($pos_vert_val_name,$this->{$prefix.'_pos_vert_val_index'}+$k,'return','top or bottom positioning value','Adjust Vert Position of absolute or relative positioned element/post/column','',$ifemptyvert,'','');
          $vert_val=(empty($vert_val))?'0':$vert_val;
		###############override top  position if stickyon..
		$stickyoptions=($this->is_column)?$this->col_options[$this->col_sticky_index]:$this->blog_options[$this->blog_sticky_index];
	$stickyoptions=explode('@@',$stickyoptions);
		$stickyarr=array('max','min','stickyon','offset','stopper','zIndex','stuck');
		foreach($stickyarr as $key =>$index){
			${$index.'_index'}=$key;
			}
		$stickyon=(array_key_exists($stickyon_index,$stickyoptions)&&$stickyoptions[$stickyon_index]==='stickyon')?true:false;
		$important=($stickyon && $vert_val > 0)?' !important':'';
		###########
          $final_vert_val=($vertpass!=='none')?$vertpass.':'.$vert_val.$important.';':'';
          printer::alertx('</div>');
          printer::close_print_wrap1('vert value'); 	
          printer::pclear(5);  
          printer::print_wrap1('zindex value');  
          printer::print_tip('Change Zindex to Modify the Stacking Order of this '.$type.'. Higher numbers overlap lower numbers');
          printer::alert('Choose z-index Value.');
          $this->mod_spacing($pos_zindex_name,$pos_zindex,-100,1000,.5,'','none');
          printer::close_print_wrap1('zindex value'); 	
          printer::pclear(5);
		#################
		
		$mediaopen=$this->mediaAddCss($options,$this->position_max_index,$this->position_min_index,$this->position_orientation_index,$this->position_operator_index,$max_name,$min_name,$orientation_name,$operator_name,true,false,true);
		 $this->submit_button();
          if ($i>0){
               $this->submit_button( );
               printer::close_print_wrap('additional positon media wrap #'.$i);
               $this->show_close('Add additional @media query controlled option tweak for position/option options'); 
               } 
          if (!empty($mediaopen)&&$pos_type!=='none'){
			$mediacss='
          '.$mediaopen.'{
		 '.$css_id.'{'
			.$pos_css.$pos_zindex_style.$pos_vert_style.$pos_horiz_style.$final_horiz_val.$final_vert_val.'transition-property: jsPosCheck-'.$pos_type.';}
               }
               ';
               }
          elseif ($pos_type==='static') {
               $mediacss=' 
               '.$css_id.'{position:static;}';
               }
          elseif (!empty($pos_zindex_style.$pos_vert_style.$pos_horiz_style.$final_horiz_val.$final_vert_val)) {
               $mediacss=' 
               '.$css_id.'{'.$pos_css.'
               '.$pos_zindex_style.$pos_vert_style.$pos_horiz_style.$final_horiz_val.$final_vert_val.'transition-property:jsPosCheck-'.$pos_type.';}';
               }echo $mediacss.' i s th css';//; if (!empty(($mediacss))?
          $this->css.=$mediacss;
          }//end for 
     printer::pclear();  
     printer::close_print_wrap('wrap advanced position');
     $this->show_close('wrap advanced position'); 
     printer::pclear();
	}//end position
	
function position(){
	$options=($this->is_column)?$this->col_options[$this->col_position_index]:$this->blog_options[$this->blog_position_index];
     $type=($this->is_column)?'Column':'Post';
	$prefix=($this->is_column)?'col':'blog'; 
	$options=explode('@@',$options);
	//see Cfg::Position_options for keys to $options array.
	$c_opts=count(explode(',',Cfg::Position_options));
     $count=3;//number of @media position options
	$mcount=$count*$c_opts;
     for ($i=0;$i<$mcount; $i++){
		if (!array_key_exists($i,$options))$options[$i]=0;
		}  
	$pos_horiz_vals_arr=array('none','left','right','center horizontally');
	$pos_vert_vals_arr=array('none','top','bottom','center vertically'); 
	$pos_arr=array('static','relative','absolute','fixed','none'); 
	#note: pos property, pos property, and advanced styles use css 	#id to override normal styles which use distinct classnames
	$msg='Responsive positioning option for this '.$type;
	$this->show_more('Position Options','','',$msg,'800');
	$this->print_redwrap('wrap advanced position',true);
     printer::print_info('Choosing relative or absolute elements activates left right positioning choices and z-index stacking order. Choosing an opacity also changes z-index value of element.');
     $css_id=($this->is_column)?$this->col_dataCss:$this->dataCss;
     for ($i=0; $i<3; $i++){
          $k=$i*$count;//
          if ($i>0){
               $this->show_more('Add additional @media query controlled option tweak for position options');
               $this->print_redwrap('additional media wrap #'.$i);
               printer::print_tip('Relative or Aboslute value again required for activation of top or left values');
               }
		$mediaopen='';
          $name=($this->is_column)?$this->col_name.'_col_options['.$this->col_position_index.']':$this->data.'_blog_options['.$this->blog_position_index.']';
          $pos_horiz_val_name=($this->is_column)?$this->col_name.'_col_options':$this->data.'_blog_options';
          $pos_vert_val_name=($this->is_column)?$this->col_name.'_col_options':$this->data.'_blog_options'; 
          $max_name=$name.'['.($this->position_max_index+$k).']';
          $min_name=$name.'['.($this->position_min_index+$k).']';
          $orientation_name=$name.'['.($this->position_orientation_index+$k).']';
          $operator_name=$name.'['.($this->position_operator_index+$k).']';
          $pos_name=$name.'['.($this->position_index+$k).']';
          $pos_vert_name=$name.'['.($this->position_vert_index+$k).']';
          $pos_horiz_name=$name.'['.($this->position_horiz_index+$k).']';
          $pos_zindex_name=$name.'['.($this->position_zindex_index+$k).']';
          $pos_horiz_val=$options[$this->position_horiz_val_index+$k];
          $pos_vert_val=$options[$this->position_vert_val_index+$k];
          $pos_horiz=(!empty($options[$this->position_horiz_index+$k])&&in_array($options[$this->position_horiz_index+$k],$pos_horiz_vals_arr))?$options[$this->position_horiz_index+$k]:'none'; 
          $pos_vert=(!empty($options[$this->position_vert_index+$k])&&in_array($options[$this->position_vert_index+$k],$pos_vert_vals_arr))?$options[$this->position_vert_index+$k]:'none';
          $pos_type=(in_array($options[$this->position_index+$k],$pos_arr,true))?$options[$this->position_index+$k]:'none';  
          $ifemptyvert=($pos_type!='static'&&$pos_type!='none'&&$pos_vert==='top'||$pos_vert==='bottom')?$pos_vert.':0;':'';
          $ifemptyhoriz=($pos_type!='static'&&$pos_type!='none'&&$pos_horiz==='right'||$pos_horiz==='left')?$pos_horiz.':0;':'';
          $pos_zindex=($pos_type!='static'&&$pos_type!='none'&&is_numeric($options[$this->position_zindex_index+$k]))?$options[$this->position_zindex_index+$k]:'none';
          $mediacss='';
          $pos_zindex_style=(is_numeric($pos_zindex))?'z-index:'.(int)$pos_zindex.';':'';
          if ($pos_type!='static'&&$pos_type!='none'&&$pos_horiz==='center horizontally')
               $pos_horiz_style='left: 0;  right: 0;  margin-left: auto; margin-right: auto;'; 
          else $pos_horiz_style='';
          if ($pos_type!='static'&&$pos_type!='none'&&$pos_vert==='center vertically') 
               $pos_vert_style='top: 50%;transform: translateY(-50%); -ms-transform: translateY(-50%);-webkit-transform: translateY(-50%);';
          else $pos_vert_style='';
          $pos_css=($pos_type!=='none')?'position:'.$pos_type.';':'';
          $this->editoverridecss.='#'.$css_id.',.'.$css_id.'{position:static !important; transform: none;-ms-transform: none;-webkit-transform: none;z-index:0 !important;}';
          $this->submit_button();
          printer::pclear(5);
          printer::alertx('<div class="'.$this->column_lev_color.' fsminfo  floatleft editbackground editfont">Choose Position Option');
          //printer::print_warnlight('Use Settings: Position jSticky option for sticky top positioning for consistent cross-browser effect');
          printer::print_tip(' Normal layout displays use static. Choose it to turn off advanced position option. Fixed position will lock the post or column from scrolling down the page and useful for anchor menus. Relative and Absolute may be use to overlap posts and or columns relative to a parent column "set to relative" or absolute to the body. Position Top Bottom Left and Right, or center only work with Fixed, Relative, or Absolute Positioning enabled.');
          forms::form_dropdown($pos_arr,'','','',$pos_name,$pos_type,false,'editcolor editbackground editfont left');
          printer::alertx('</div>');
          printer::print_wrap1('horiz value');  
          printer::print_tip('If Position is Set to Relative or Absolute Choose to Modify the left right alignment of this '.$type.' by selecting the option type and value<br>');
          printer::pclear();
          printer::alertx('<div class="'.$this->column_lev_color.' fsminfo maxwidth500 floatleft editbackground editfont">Choose Right or Left, None (As is), or use Center Horizonally.'); 
          forms::form_dropdown($pos_horiz_vals_arr,'','','',$pos_horiz_name,$pos_horiz,false,'editcolor editbackground editfont left');
          printer::alertx('</div>');
          printer::pclear();
          printer::print_wrap('Choose pos units');
          printer::print_tip('Choose px, em, rem, units. Otherwise a default value of 0 will be used');
          printer::pclear(); 
          $horizpass=($pos_horiz==='left'||$pos_horiz==='right')?$pos_horiz:'none';
          $horiz_val=$this->spacing($pos_horiz_val_name,$this->{$prefix.'_pos_horiz_val_index'}+$k,'return','Choose left or right positioning value','Adjust Horiz Position of absolute or relative positioned element/post/column','',$ifemptyhoriz,'','');
          $horiz_val=(empty($horiz_val))?'0':$horiz_val;
          $final_horiz_val=($horizpass!=='none')?$horizpass.':'.$horiz_val.';':'';
          printer::close_print_wrap('Choose pos units');
          printer::close_print_wrap1('horiz value');
          printer::pclear(5);
          printer::print_wrap1('vert value');  
          printer::print_tip('If Position is Set to Relative or Absolute Choose to Modify the Top Bottom alignment of this '.$type.' by selecting the option type and value<br>');
          printer::alertx('<div class="'.$this->column_lev_color.' fsminfo maxwidth500 floatleft editbackground editfont">Choose to position using Top or Bottom, None (As is), or use Center Vertically. <b>Note using both Center Vertically and an animation on this same post can change the animation path ie. on sliding animations</b>'); 
          forms::form_dropdown($pos_vert_vals_arr,'','','',$pos_vert_name,$pos_vert,false,'editcolor editbackground editfont left'); 
          printer::alertx('</div>');
          printer::pclear(); 
          printer::alertx('<div class="fs1black editcolor editbackground editfont">If Position is Set to Relative or Absolute and you also Choose a position Top or Bottom  choose a numeric value here in percent, px, em, rem, vw, or vh units. Otherwise a default value of 0 will be used');
          printer::pclear(10);
          $vertpass=($pos_vert==='top'||$pos_vert==='bottom')?$pos_vert:'none';
          $vert_val=$this->spacing($pos_vert_val_name,$this->{$prefix.'_pos_vert_val_index'}+$k,'return','top or bottom positioning value','Adjust Vert Position of absolute or relative positioned element/post/column','',$ifemptyvert,'','');
          $vert_val=(empty($vert_val))?'0':$vert_val;
		###############override top  position if stickyon..
		$stickyoptions=($this->is_column)?$this->col_options[$this->col_sticky_index]:$this->blog_options[$this->blog_sticky_index];
	$stickyoptions=explode('@@',$stickyoptions);
		$stickyarr=array('max','min','stickyon','offset','stopper','zIndex','stuck');
		foreach($stickyarr as $key =>$index){
			${$index.'_index'}=$key;
			}
		$stickyon=(array_key_exists($stickyon_index,$stickyoptions)&&$stickyoptions[$stickyon_index]==='stickyon')?true:false;
		$important=($stickyon && $vert_val > 0)?' !important':'';
		###########
          $final_vert_val=($vertpass!=='none')?$vertpass.':'.$vert_val.$important.';':'';
          printer::alertx('</div>');
          printer::close_print_wrap1('vert value'); 	
          printer::pclear(5);  
          printer::print_wrap1('zindex value');  
          printer::print_tip('Change Zindex to Modify the Stacking Order of this '.$type.'. Higher numbers overlap lower numbers');
          printer::alert('Choose z-index Value.');
          $this->mod_spacing($pos_zindex_name,$pos_zindex,-100,1000,.5,'','none');
          printer::close_print_wrap1('zindex value'); 	
          printer::pclear(5);
		#################
		
		$mediaopen=$this->mediaAddCss($options,$this->position_max_index,$this->position_min_index,$this->position_orientation_index,$this->position_operator_index,$max_name,$min_name,$orientation_name,$operator_name,true,false,true);
		 $this->submit_button();
          if ($i>0){
               $this->submit_button( );
               printer::close_print_wrap('additional positon media wrap #'.$i);
               $this->show_close('Add additional @media query controlled option tweak for position/option options'); 
               } 
          if (!empty($mediaopen)&&$pos_type!=='none'&&$pos_type!=='static'){
			$mediacss='
          '.$mediaopen.'{
		 .'.$css_id.'{'
			.$pos_css.$pos_zindex_style.$pos_vert_style.$pos_horiz_style.$final_horiz_val.$final_vert_val.'transition-property: jsPosCheck-'.$pos_type.';}
               }
               ';
               }
          elseif ($pos_type==='static') {
               $mediacss=' 
               .'.$css_id.'{position:static;}';
               }
          elseif ($pos_type!=='none' && $pos_type!=='static' && !empty($pos_zindex_style.$pos_vert_style.$pos_horiz_style.$final_horiz_val.$final_vert_val)) {
               $mediacss=' 
               .'.$css_id.'{'.$pos_css.'
               '.$pos_zindex_style.$pos_vert_style.$pos_horiz_style.$final_horiz_val.$final_vert_val.'transition-property:jsPosCheck-'.$pos_type.';}';
               }
			
          $this->css.=$mediacss;
          }//end for 
     printer::pclear();  
     printer::close_print_wrap('wrap advanced position');
     $this->show_close('wrap advanced position'); 
     printer::pclear();
	}//end position

function opacity(){
	$options=($this->is_column)?$this->col_options[$this->col_opacity_index]:$this->blog_options[$this->blog_opacity_index];
     $type=($this->is_column)?'Column':'Post';
	$prefix=($this->is_column)?'col':'blog'; 
	$options=explode('@@',$options);
	//see Cfg::Opacity_options for keys to $options array.
	$c_opts=count(explode(',',Cfg::Opacity_options));
     $count=3;//number of @media opacity options
	$mcount=$count*$c_opts;
     for ($i=0;$i<$mcount; $i++){
		if (!array_key_exists($i,$options))$options[$i]=0;
		}  
	$this->show_more('Opacity Option');
	$this->print_redwrap('wrap advanced opacity',true);
     $css_id=($this->is_column)?$this->col_dataCss:$this->dataCss;
     for ($i=0; $i<3; $i++){
          $k=$i*$count;//
          if ($i>0){
               $this->show_more('Add additional @media query controlled option tweak for opacity options');
               printer::print_wrap('additional media wrap #'.$i);
               }
		$mediaopen='';
		$name=($this->is_column)?$this->col_name.'_col_options['.$this->col_opacity_index.']':$this->data.'_blog_options['.$this->blog_opacity_index.']';
		$max_name=$name.'['.($this->opacity_max_index+$k).']';
		$min_name=$name.'['.($this->opacity_min_index+$k).']';
		$orientation_name=$name.'['.($this->opacity_orientation_index+$k).']';
		$operator_name=$name.'['.($this->opacity_operator_index+$k).']';
		$opacity_name=$name.'['.($this->opacity_index+$k).']';
		$opacity_val=(is_numeric($options[$this->opacity_index+$k])&&$options[$this->opacity_index+$k]>=4&&$options[$this->opacity_index+$k]<=100)?$options[$this->opacity_index+$k]:'none';
		$mediacss='';
		$opac_css=($opacity_val!=='none')?'opacity:'.($opacity_val/100).';':'';
		$this->show_more('Style info','','info italic smaller');
		printer::print_wrap1('techinfo');
		printer::print_info('Current setting Css: '.$opac_css);
		$msg='The following opacity/opacity css is applied to the main div class '.$css_id.' of this '.$prefix;
		printer::print_info($msg);
		printer::close_print_wrap1('techinfo');
		$this->show_close('Tech info');
		$this->editoverridecss.='#'.$css_id.',.'.$css_id.'{opacity:1;}';
		$this->submit_button();
		printer::print_tip('Set Opacity Here with optional max-width, min-width, orientation for responsive design. Changes to opacity will NOT EFFECT EDIT MODE display. View changes in webpage mode!');
		printer::print_wrap1('opacity value');  
		printer::print_tip('Change Opacity will affect entire '.$type.'. To affect the opacity of background color, gradients or images use the opacity options for those under the background styling options. Note: Opacity changes here may also Modify the Stacking Order of opacity posts <b>otherwise the opacity option functions independently of the postion options</b>');
		printer::alert('Choose opacity Value.');
		$this->mod_spacing($opacity_name,$opacity_val,4,100,1,'%','none');
		printer::close_print_wrap1('opacity value'); 	
		printer::pclear(5);
		      #################
		      
		      $mediaopen=$this->mediaAddCss($options,$this->opacity_max_index,$this->opacity_min_index,$this->opacity_orientation_index,$this->opacity_operator_index,$max_name,$min_name,$orientation_name,$operator_name,true,false,true);
		       $this->submit_button();
		if ($i>0){
		     $this->submit_button( );
		     printer::close_print_wrap('additional positon media wrap #'.$i);
		     $this->show_close('Add additional @media query controlled option tweak for opacity options'); 
		     } 
		if (!empty($mediaopen)&&$opacity_val!=='none'){
			      $mediacss='
		'.$mediaopen.'{
		       .'.$css_id.'{'
			      .$opac_css.';}
		     }
		     ';
		     }
		elseif ($opacity_val!=='none') {
		     $mediacss=' 
		     .'.$css_id.'{'.$opac_css.';}';
		     }
		$this->css.=$mediacss;
		}//end for 
     printer::pclear();  
     printer::close_print_wrap('wrap advanced opacity');
     $this->show_close('wrap advanced opacity'); 
     printer::pclear();
	}//end opacity
	
function height_style($type,$data){  
	static $topinc=0; $topinc++;
	$this->show_more($type.' Height Option');
	$this->print_redwrap('Uniform '.$type.' Height Option');
     if ($type==='blog')
          printer::print_tip('Normally Heights are automatically set and setting a height is unnecessary. However you can set heights here for effects such as having all posts in a column the same height for a tile effect.</em> <br>');
     else 
          printer::print_notice('Setting a Column Height specifies the overall Column Height not the height of individual posts within.');
     printer::print_wrap1('height style');
	printer::print_tip('Height is generally determined automatically from Content height but can be custom specified here. Choose from height, max-height, min-height and units');
     if ($type=='blog'&&$this->blog_type==='image')
          printer::print_warnlight('Images have an image specific config to set the image height identical to post height and an optional mediaq query to revert to width:auto;  You can also choose a sufficiently large max-width option to limit the download width and the correct image ratio w/h will still be maintained by the height you choose.'); 
	printer::pclear(4); 
	printer::close_print_wrap1('height style');
	$this->height_options($type,$data);
     printer::close_print_wrap('image height');
	$this->show_close('Height Option');
     $css_id=($type==='col')?$this->col_dataCss:$this->dataCss;
     if($type==='blog'&&($this->blog_type==='image'||$this->blog_type==='auto_slide')) 
          $this->editoverridecss.='#'.$css_id.' img{height:auto;}
          ';
     $this->editoverridecss.='#'.$css_id.'{min-height:0px;height:100%;overflow:visible;}';
	}//end height_style
	
     
function height_options($type,$data){ 
     $index_arr=array('mediamax0','mediamin0','mediamax1','mediamin1','mediamax2','mediamin2');
     $blog_media_arr=explode('@@',$this->{$type.'_options'}[$this->{$type.'_height_media_index'}]);
     for ($i=0;$i<18;$i++){# 3 iterations* 6 values
          if (!array_key_exists($i,$blog_media_arr))
               $blog_media_arr[$i]=0;
          }
     foreach ($index_arr as $key=>$value){
          ${$value.'_index'}=$key;
          }
     $name=$data.'_'.$type.'_options['.$this->{$type.'_height_media_index'}.']';
     $css_id=($this->is_column)?$this->col_dataCss.'.webmode':$this->dataCss.'.webmode';
     if ($this->is_blog&&$this->blog_type==='image'){
          $css_id.=',.'.$css_id.' img';//style image as well if image_height_set
          }
     if ($this->is_blog&&$this->blog_type==='auto_slide'){
          $css_id.=',html .'.$css_id.' img';
          }
     $count=12;//number of @media position options
	for ($i=0; $i<3; $i++){
          $k=$i*$count;//
          if ($i>0){
               $this->show_more('Add additional @media query controlled option tweak for height options');
               $this->print_redwrap('additional media wrap #'.$i);
               }
     $this->show_more('em, rem, px with scale opt for  min-height, max-height, &amp; height choices'); 
	printer::print_wrap('more height');
     $max_name=$name.'['.(${'mediamax'.$i.'_index'}).']';
	$min_name=$name.'['.(${'mediamin'.$i.'_index'}).']';
	$mediamax=(is_numeric($blog_media_arr[${'mediamax'.$i.'_index'}])&&$blog_media_arr[${'mediamax'.$i.'_index'}]>=200&&$blog_media_arr[${'mediamax'.$i.'_index'}]<=3000)?$blog_media_arr[${'mediamax'.$i.'_index'}]:0;
     $mediamin=(is_numeric($blog_media_arr[${'mediamin'.$i.'_index'}])&&$blog_media_arr[${'mediamin'.$i.'_index'}]>=200&&$blog_media_arr[${'mediamin'.$i.'_index'}]<=3000)?$blog_media_arr[${'mediamin'.$i.'_index'}]:0;
     #here we making compatible for spacing function name="" input options..
	 if (!empty($mediamin)||!empty($mediamax)) 
          $fieldmin=$field=$fieldmax='return';
     else {
          $fieldmin='min-height';
          $fieldmax='max-height';
          $field='height';
          }
     $this->{$data.'_'.$type.'_options'}[$this->{$type.'_max_height_opt_index'}]=$this->{$type.'_options'}[$this->{$type.'_max_height_opt_index'}];//here we are setting up the use of for double duty as obj value and name as in styling functions
      
     $hmax=$this->height_max_special($data.'_'.$type.'_options',$this->{$type.'_max_height_opt_index'},$fieldmax,'.'.$css_id,$k);
	$this->{$data.'_'.$type.'_options'}[$this->{$type.'_height_opt_index'}]=$this->{$type.'_options'}[$this->{$type.'_height_opt_index'}];
	$h=$this->height_special($data.'_'.$type.'_options',$this->{$type.'_height_opt_index'},$field,'.'.$css_id,$k);
	$this->{$data.'_'.$type.'_options'}[$this->{$type.'_min_height_opt_index'}]=$this->{$type.'_options'}[$this->{$type.'_min_height_opt_index'}];  
	$hmin=$this->height_min_special($data.'_'.$type.'_options',$this->{$type.'_min_height_opt_index'},$fieldmin,'.'.$css_id,$k);
     $mediacss=$css='';
      $appendcss=($type==='blog'&&($this->blog_type==='image'||$this->blog_type==='auto_slide'))?' width:auto;max-width:none;':''; 
     if ((!empty($mediamin)||!empty($mediamax))&&(!empty($hmax)||!empty($hmin)||!empty($h))){ 
          $hmax=(!empty($hmax))?' max-height:'.$hmax.';':'';
          $hmin=(!empty($hmin))?' min-height:'.$hmin.';':'';
          $h=(!empty($h))?' height:'.$h.';':'';
          if (!empty($mediamin)&&!empty($mediamax)) {
              $mediacss.='
     @media screen and (max-width:'.$mediamax.'px) and (min-width:'.$mediamin.'px){
     html .'.$css_id.'{'.$hmax.$hmin.$h.$appendcss.'}
          }
          ';
               }
          elseif (!empty($mediamax)){
               $mediacss.='
     @media screen and (max-width: '.$mediamax.'px){
     html .'.$css_id.'{'.$hmax.$hmin.$h.$appendcss.'}
          }
          ';
               }
          elseif (!empty($mediamin)) {
               $mediacss.='
     @media screen and (min-width: '.$mediamin.'px){
     
     html .'.$css_id.'{'.$hmax.$hmin.$h.$appendcss.'}
          }
          ';
               }
          $this->css.=$mediacss;
          }
     else if (!empty($hmax)||!empty($hmin)||!empty($h)){ //css expressed already expressed in ion style but lets append
         $this->css.=$mediacss='
     html .'.$css_id.'{'.$appendcss.'}
          ';
          $mediacss='
     html .'.$css_id.'{'.$hmax.$hmin.$h.$appendcss.'}
          ';
          }
	printer::close_print_wrap('more height');
     
     $this->show_more('Style info','','info italic smaller');
     printer::print_wrap1('techinfo');
     printer::print_info('Current setting Css: '.$mediacss);
     $msg='Direct height, max-height, or min-height applied to main div of '.$type.' with optional media queries';
     printer::print_info($msg);
     printer::close_print_wrap1('techinfo');
     $this->show_close('Tech info');
     
	 printer::print_info('Optionally choose a @media screen size min-width or max-width or both at which this '.$type.' will specify custom Height setting.');  
     echo '<div class="fsminfo"><!--wrap max width-->';
     printer::printx('<p class="smaller '.$this->column_lev_color.'">(0 = none) Chosen Height max-width: <span class="navybackground white">'.$mediamax.'</span><br></p>');   
     printer::alert('Choose @media screen max-width px');
     $this->mod_spacing($max_name,$mediamax,200,3000,1,'px','none');  
     printer::printx('<p ><input type="checkbox" name="'.$max_name.'" value="0">Remove max-width</p>');
     echo '</div><!--wrap max width-->';
     echo '<div class="fsminfo"><!--wrap min width-->';
     printer::printx('<p class="smaller '.$this->column_lev_color.'">Chosen min-width: <span class="navybackground white">'.$mediamin.'</span></p>');
      printer::alert('Choose @media screen min-width px'); 
     $this->mod_spacing($min_name,$mediamin,200,3000,1,'px','none');
     printer::printx('<p ><input type="checkbox" name="'.$min_name.'" value="0">Remove min-width</p>');
     echo '</div><!--wrap min width-->';	
     $this->show_close('em, rem, px with scale, min-height, max-height, &amp; height choices');
	
      if ($i>0){
               $this->submit_button( );
               printer::close_print_wrap('additional positon media wrap #'.$i);
               $this->show_close('Add additional @media query controlled option tweak for position options'); 
               } 
          }//end for
     }
     
#classpercent
#width_rwd
function width_media_unit($style, $val,$field='',$msg='Class Percent Width RWD'){ 
    $type='class';
     $cpwindexes=explode(',',Cfg::Class_width_options);
	foreach($cpwindexes as $key =>$index){
		${$index.'_index'}=$key;
		}  
	if (empty($this->{$style}[$val])){ 
		$cpw_array=array();
		 for ($i=0; $i<count($cpwindexes);$i++){ 
			$cpw_array[$i]=0;
			}
		}
	else	{   
		$cpw_array=explode('@@',$this->{$style}[$val]);
		for ($i=0; $i<count($cpwindexes);$i++){ 
			if (!array_key_exists($i,$cpw_array)){
				$cpw_array[$i]=0;
				}
			 }
		}
		 
	if ($this->is_blog){// determine the name of the field for adding new cpw image!!
		if(!empty($field)){  
			$table=$this->blog_table;
			}
		else{//fields currently always present.
               mail::alert('cpw field missing');
			$table=$this->blog_table;
			}
		}
	elseif ($this->is_column) {
		$table=$this->col_name;
		}
	elseif ($this->is_page) { 
		$table=$this->pagename;
		}
	else { 
		mail::alert('cpw function issue');
		return;
		}
     $width_arr=array('px','%','rem','em');
     $defaultunit=(!empty($cpw_array[$class_width_unit_index])&&in_array($cpw_array[$class_width_unit_index],$width_arr))?$cpw_array[$class_width_unit_index]:'%';
     $fitfactor=1;//($this->is_masonry&&$)?.995:.995;
     $class_width_toggle=($cpw_array[$class_width_toggle_index]==='turnon')?true:false;
     $mediapercent=(is_numeric($cpw_array[$class_width_init_index])&&$cpw_array[$class_width_init_index]>0&&$cpw_array[$class_width_init_index]<=100)?$cpw_array[$class_width_init_index]:'';
    $marginleft=(is_numeric($cpw_array[$class_marginleft_init_index])&&$cpw_array[$class_marginleft_init_index]>=0&&$cpw_array[$class_marginleft_init_index]<=100)?$cpw_array[$class_marginleft_init_index]:0; 
     $marginright=(is_numeric($cpw_array[$class_marginright_init_index])&&$cpw_array[$class_marginright_init_index]>=0&&$cpw_array[$class_marginright_init_index]<=100)?$cpw_array[$class_marginright_init_index]:0;
      if ($this->edit&&$class_width_toggle&&!empty($mediapercent)){
          $css='
		'.$this->pelement.'{width:'.($mediapercent*$fitfactor).$defaultunit.';margin-left:'.$marginleft.$defaultunit.';margin-right:'.$marginright.$defaultunit.';}
		';
          }
	else $css='';
     $name=$style.'['.$val.']['.$class_width_toggle_index.']';
     $name2=$style.'['.$val.']['.$class_width_init_index.']';
     $name3=$style.'['.$val.']['.$class_marginleft_init_index.']';
     $name4=$style.'['.$val.']['.$class_marginright_init_index.']';
     $this->show_more('Width RWD Unit','main2','highlight click editbackground editfont');
     printer::print_wrap('Width RWD Percent');
      echo ' <div class="fsmcolor editbackground editfont editcolor"><!--wrap percentage choices to option3-->';
      printer::print_tip('Here you can setup @media  width value  including margins as needed at  multiple @media max-widths in your choice of units');
     printer::pclear(5); 
    printer::print_info('Margins: Leaving Blank to specify no margin declaration however will be subject to any previous declaration of margin left right declaration. 0 will specify margin left or right 0');
	printer::print_wrap('toggle');
     if ($class_width_toggle) 
          echo '<br><input type="checkbox" name="'.$name.'" value="None">Turn OFF Width RWD Special Class style<br><br>
     ';
     else  
          echo '<br><input type="checkbox" name="'.$name.'" value="turnon">Turn ON Width RWD Special Class style<br><br>
     ';
	
	printer::close_print_wrap('toggle');
	
	printer::print_wrap('units');
     printer::print_tip('Choose initial default width units:'); 
     forms::form_dropdown($width_arr,'','','',$style.'['.$val.']',$defaultunit,false,'editcolor editbackground editfont left');
	
	printer::close_print_wrap('units');
	
	printer::print_wrap('settings');
     printer::print_tip('Enter Initial width (no units) and margin settings for large view screens.'); 
     echo '<table class="rwdmedia">
     <tr><th>Set Initial Width</th><th> left-margin</th><th> right-margin</th></tr>';
     echo '<tr><td><input name="'.$name2.'" type="text" value="'.$mediapercent.'" ></td><td><input name="'.$name3.'" type="text" value="'.$marginleft.'" ></td><td><input name="'.$name4.'" type="text" value="'.$marginright.'" ></td></tr>
     </table>';
     printer::print_tip('Enter up to eight break point max-widths as between 250-3000 px (without the units) in any order and specify percentages width/margin-left/margin-right required between 0 and 100 included');
     echo '<table class="rwdmedia">
     <tr><th>Media max-width bp</th><th> Width</th><th> left-margin</th><th> right-margin</th></tr>';
     $array_key=$array_collect=array();
     for ($i=1; $i<9;$i++){
		 $mediaunit=(in_array($cpw_array[${'class_unit'.$i.'_index'}],$width_arr,true))?$cpw_array[${'class_unit'.$i.'_index'}]:$defaultunit;
          $mediawidth=(is_numeric($cpw_array[${'class_media_'.$i.'_index'}])&&$cpw_array[${'class_media_'.$i.'_index'}]>=250&&$cpw_array[${'class_media_'.$i.'_index'}]<=3000)?$cpw_array[${'class_media_'.$i.'_index'}]:'';
          $mediapercent=(is_numeric($cpw_array[${'class_width_'.$i.'_index'}])&&$cpw_array[${'class_width_'.$i.'_index'}]>0&&$cpw_array[${'class_width_'.$i.'_index'}]<=100)?$cpw_array[${'class_width_'.$i.'_index'}]:'';
           $marginleft=(is_numeric($cpw_array[${'class_marginleft_'.$i.'_index'}])&&$cpw_array[${'class_marginleft_'.$i.'_index'}]>=0&&$cpw_array[${'class_marginleft_'.$i.'_index'}]<=100)?$cpw_array[${'class_marginleft_'.$i.'_index'}]:0;
           $marginright=(is_numeric($cpw_array[${'class_marginright_'.$i.'_index'}])&&$cpw_array[${'class_marginright_'.$i.'_index'}]>=0&&$cpw_array[${'class_marginright_'.$i.'_index'}]<=100)?$cpw_array[${'class_marginright_'.$i.'_index'}]:0;
          $name1=$style.'['.$val.']['.${'class_media_'.$i.'_index'}.']';
          $name2=$style.'['.$val.']['.${'class_width_'.$i.'_index'}.']';
          $name3=$style.'['.$val.']['.${'class_marginleft_'.$i.'_index'}.']';
          $name4=$style.'['.$val.']['.${'class_marginright_'.$i.'_index'}.']';
          echo '<tr><td><input name="'.$name1.'" type="text" value="'.$mediawidth.'" ></td><td><input name="'.$name2.'" type="text" value="'.$mediapercent.'" ></td><td><input name="'.$name3.'" type="text" value="'.$marginleft.'" ></td><td><input name="'.$name4.'" type="text" value="'.$marginright.'" ></td><td>';
		forms::form_dropdown($width_arr,'','','',$name3,$mediaunit,false,'editcolor editbackground editfont left');
		echo '</td></tr>';
          if (!empty($mediawidth)&&!empty($mediapercent))
			$array_collect[$mediawidth]=array($mediapercent,$marginleft,$marginright,$mediaunit);
          }//end for loop
     
      if ($this->edit&&$class_width_toggle){
          krsort($array_collect);
		$sortnext=array();
		$list=array_keys($array_collect);
		if (count($list) > 0 && is_numeric($list[0]) && $list[0] >100 ){ 
			$this->css.='
			@media screen and (max-width:10000px) and (min-width:'.($list[0]+1).'px){'.$css.'}';
			}
		else $this->css.=$css;
			
		$previous='';
		foreach ($list as $key){
			$sortnext[$previous]=$key;
			$previous=$key;
			}
		 foreach ($array_collect as $key=>$sorted){
			$media_min=(array_key_exists($key,$sortnext))?$sortnext[$key]:'';
               $mediawidth=$key;
               $mediapercent=$sorted[0];
               $marginleft=$sorted[1];
               $marginright=$sorted[2];
			$mediaunit=$sorted[3];  
               if(!empty($mediawidth)&&!empty($mediapercent)){
				 
				$min_media=(!empty($media_min))?' and (min-width:'.($media_min+1).'px)':'';
				$this->css.='
                    @media screen and (max-width:'.$mediawidth.'px)'.$min_media.'{
      '.$this->pelement.'{width:'.($mediapercent*$fitfactor).$mediaunit.';margin-left:'.$marginleft.$mediaunit.';margin-right:'.$marginright.$mediaunit.';}
          }';
				}
               }//end for loop     
          }
     echo '</table>';
	printer::close_print_wrap('settings');
     printer::print_tip('The total width, margin-left, margin-right  of all posts combined sharing row space at a given @media bp will need to be less than or equal to the available width in the parent column. ie when using percent: 100%');
	echo '</div><!--wrap percentage choices to option3-->'; 
     $this->submit_button();
     printer::close_print_wrap('Width RWD Unit');
     $this->show_close('Width RWD Unit');
	}// end width_media_unit
     

#classpercent\
#width_rwd
function font_media_unit($style, $val,$field='',$msg='Font RWD'){ 
    $type='class';
     $font_options='class_font_toggle,class_init_unit,class_font_init,class_media_1,class_unit1,class_font_1,class_media_2,class_unit2,class_font_2,class_media_3,class_unit3,class_font_3,class_media_4,class_unit4,class_font_4,class_media_5,class_unit5,class_font_5,class_media_6,class_unit6,class_font_6,class_media_7,class_unit7,class_font_7,class_media_8,class_unit8,class_font_8';
	$cpwindexes=explode(',',$font_options);
	foreach($cpwindexes as $key =>$index){
		${$index.'_index'}=$key;
		}  
	if (empty($this->{$style}[$val])){ 
		$cpw_array=array();
		 for ($i=0; $i<count($cpwindexes);$i++){ 
			$cpw_array[$i]=0;
			}
		}
	else	{   
		$cpw_array=explode('@@',$this->{$style}[$val]);
		for ($i=0; $i<count($cpwindexes);$i++){ 
			if (!array_key_exists($i,$cpw_array)){
				$cpw_array[$i]=0;
				}
			 }
		}
		 
	if ($this->is_blog){// determine the name of the field for adding new cpw image!!
		if(!empty($field)){  
			$table=$this->blog_table;
			}
		else{//fields currently always present.
               mail::alert('cpw field missing');
			$table=$this->blog_table;
			}
		}
	elseif ($this->is_column) {
		$table=$this->col_name;
		}
	elseif ($this->is_page) { 
		$table=$this->pagename;
		}
	else { 
		mail::alert('cpw function issue');
		return;
		}
     $font_arr=array('px','%','rem','em');
     $fontunit=(!empty($cpw_array[$class_init_unit_index])&&in_array($cpw_array[$class_init_unit_index],$font_arr))?$cpw_array[$class_init_unit_index]:'px';
     $fitfactor=1;
     $class_font_toggle=($cpw_array[$class_font_toggle_index]==='turnon')?true:false;
     $font_value=(is_numeric($cpw_array[$class_font_init_index])&&$cpw_array[$class_font_init_index]>0)?$cpw_array[$class_font_init_index]:'';
	if ($this->edit&&$class_font_toggle&&!empty($font_value)){ 
          $css='
          '.$this->pelement.'{font-size:'.($font_value).$fontunit.';}
     ';
          }
	else $css='';
     $nametoggle=$style.'['.$val.']['.$class_font_toggle_index.']';
     $namevalue=$style.'['.$val.']['.$class_font_init_index.']';
     $nameunit=$style.'['.$val.']['.$class_init_unit_index.']';
	echo'<div class="fsminfo editcolor editbackground editfont '.$style.'_hidefont hide" ><!--font media rwd-->';
     $this->show_more('Font RWD Unit','main2','highlight click editbackground editfont');
     printer::print_wrap('Font RWD Percent');
      echo ' <div class="fsmcolor editbackground editfont editcolor"><!--wrap percentage choices to option3-->';
	 printer::print_notice('You can set up your own @media font adjustments here!. Also works well with scaling units.');
      printer::print_tip('Here you can setup @media font values as needed at multiple @media max-widths in your choice of units');
     printer::pclear(5);
	printer::print_wrap('toggle');
     if ($class_font_toggle) 
          echo '<br><input type="checkbox" name="'.$nametoggle.'" value="None">Turn OFF Font RWD Special Class style<br><br>
     ';
     else  
          echo '<br><input type="checkbox" name="'.$nametoggle.'" value="turnon">Turn ON Font RWD Special Class style<br><br>
     ';
	
	printer::close_print_wrap('toggle');
	printer::print_wrap('units');
     printer::print_tip('Choose a default initial font unit:'); 
     forms::form_dropdown($font_arr,'','','',$nameunit,$fontunit,false,'editcolor editbackground editfont left');
	printer::close_print_wrap('units');
	printer::print_wrap('Settings');
     printer::print_tip('Enter Initial font settings for large view screens (do not use units).'); 
     echo '<table class="rwdmedia">
     <tr><th>Set Initial Font size</th></tr>';
     echo '<tr><td><input name="'.$namevalue.'" type="text" value="'.$font_value.'" ></td></tr>
     </table>';
     printer::print_tip('Enter up to eight break point max-widths as between 250-3000 as px (without the units) in any order and specify font-size required according to unit that will be used');
     echo '<table class="rwdmedia">
     <tr><th>Media max-width bp</th><th> Font Size</th><th>Font Unit</th></tr>';
     $array_key=$array_collect=array();
     for ($i=1; $i<9;$i++){ 
          $mediafont=(is_numeric($cpw_array[${'class_media_'.$i.'_index'}])&&$cpw_array[${'class_media_'.$i.'_index'}]>=250&&$cpw_array[${'class_media_'.$i.'_index'}]<=3000)?$cpw_array[${'class_media_'.$i.'_index'}]:'';
          $font_value=(is_numeric($cpw_array[${'class_font_'.$i.'_index'}])&&$cpw_array[${'class_font_'.$i.'_index'}]>0&&$cpw_array[${'class_font_'.$i.'_index'}]<=400)?$cpw_array[${'class_font_'.$i.'_index'}]:'';
          $mediaunit=(in_array($cpw_array[${'class_unit'.$i.'_index'}],$font_arr,true))?$cpw_array[${'class_unit'.$i.'_index'}]:$fontunit.'-default';
		$cleanunit=str_replace('-default','',$mediaunit);
          $namemedia=$style.'['.$val.']['.${'class_media_'.$i.'_index'}.']';
          $namevalue=$style.'['.$val.']['.${'class_font_'.$i.'_index'}.']';
          $nameunit=$style.'['.$val.']['.${'class_unit'.$i.'_index'}.']';
          echo '<tr><td><input name="'.$namemedia.'" type="text" value="'.$mediafont.'" ></td><td><input name="'.$namevalue.'" type="text" value="'.$font_value.'" ></td><td>';
		forms::form_dropdown($font_arr,'','','',$nameunit,$mediaunit,false,'editcolor editbackground editfont left');
		echo '</td></tr>';
          $array_collect[$mediafont]=array($font_value,$cleanunit);
          }
     
      if ($this->edit&&$class_font_toggle){
           krsort($array_collect);
		$sortnext=array();
		$list=array_keys($array_collect); 
		if (count($list) > 0 && is_numeric($list[0]) && $list[0] >100 ){ 
			$this->css.='
			@media screen and (max-width:10000px) and (min-width:'.($list[0]+1).'px){'.$css.'}';
			}
		else $this->css.=$css;
		$previous='';
		foreach ($list as $key){
			$sortnext[$previous]=$key;
			$previous=$key;
			}
		 foreach ($array_collect as $key=>$sorted){
			$media_min=(array_key_exists($key,$sortnext))?$sortnext[$key]:'';
			$mediawidth=$key;
               $font_value=$sorted[0];
			$mediaunit=$sorted[1];
			if(!empty($font_value)&&!empty($mediawidth)){
				$min_media=(!empty($media_min))?' and (min-width:'.($media_min+1).'px)':'';
				$this->css.='
			@media screen and (max-width:'.$mediawidth.'px)'.$min_media.'{
      '.$this->pelement.'{font-size:'.($font_value).$mediaunit.';}
          }';
				}
               }//end for loop     
          }
     echo '</table>';
	printer::close_print_wrap('Settings');
     echo'</div><!--wrap percentage choices to option3-->'; 
     $this->submit_button();
     printer::close_print_wrap('Font RWD Unit');
     $this->show_close('Font RWD Unit');
	echo'</div><!--font media rwd-->';
	}// end font_media_unit
     

     
function width_mode(){//uses blog altwidth value for nested columns also
     $type='blog';//
	if ($this->is_clone&&!$this->clone_local_style)return;
	$check0=$check1=$check2=$check3=$check4=$check5='';
	$checked=' checked="checked"';
	$data=$this->data;  
	$name='name="'.$data.'_blog_width_mode['.$this->blog_width_mode_index.']" ';
     switch ($this->blog_width_mode[$this->blog_width_mode_index]) {
          case  'off':
               $check0=$checked;
               break;
          case  'maxwidth':
               $check1=$checked;
               break;
          case 'compress_full_width':
               $check2=$checked;
               break; 
          case 'compress_to_percentage': 
               $check3=$checked;
               break;
          default:
          $this->blog_width_mode[$this->blog_width_mode_index]='maxwidth';
          $check1=$checked; 
          }//end switch
	$altype=($this->blog_type==='nested_column')?'nested column post':'post';
	$colmsg=($this->blog_type==='nested_column')?'<b>Note: Setting alternative width on a nested column directly affects the column sizing itself</b>':'';
	echo '<div class="fsminfo editbackground editfont '.$this->column_lev_color.'"><!--alt width wrapper1-->';
		
     $default_mode=Cfg::Default_width_mode; 
     $msg=($this->flex_enabled_twice)?'Max-Width option not available following flex box previous activation':'Choosing main mode different choices. More options under alternative units below.';
	printer::printx('<p class="tip">'.$msg);
	$this->show_more('more info on main units','','italic smallest '.$this->column_lev_color);
	printer::print_wrap('more info on main units');
	printer::print_tip('Note: Main modes keep track on how much space available in parent column.<br><br>
	An advantage of this version of max-width over alternative max-width direct setting of px units is that if the parent or primary column itself is resized  the main max-width sizes will also resize proportionally as they are stored as percent and recalculated to max-width before rendering as max-width css. Use alternative unit widths for combinations of max-width min-width and width with your choice of units.');
	printer::close_print_wrap('more info on main units');
	$this->show_close('more info on main units');
	$msg='Recommended for a single post which occupies a whole Column Row or shared posts in row that you wish to maximized individual posts by breaking to new row (ie smaller viewports) instead of compressing to some degree first<br>Chosen Floated Posts will not compress beyond thier initial sizing as viewports becoming limiting and origin size will be maintained by breaking to new a row as space permits.(default mode).';
	echo '<p class="fsmcolor editbackground editfont editcolor">';
     if($this->flex_enabled_twice) printer::print_warn('Previous Flex Box Activation renders this max-width option innaccurate due to width tracking off. Use another option ie. option mode 2 or 3 below or alt width units or flex basis for flex items'); 
     echo'<input type="radio" '.$name.$check0.' value="off">0.<span class="orange"> Turn Off </span> Main Width Options Below. Use Alt width Units Instead. </span> 
     <br></p>';
	
    echo '<div class="fsmcolor editbackground editfont editcolor">
     <input type="radio" '.$name.$check1.' value="maxwidth">1. Choose max-width option
     <br>';
	$this->show_more('more info on main max-width','','italic smallest '.$this->column_lev_color);
	printer::print_wrap('more info on main max-width');
	printer::print_tip($msg);
	printer::close_print_wrap('more info on main max-width');
	$this->show_close('more info on main max-width');
	echo '</div><!--wrap choices to option1-->';
	echo '<div class="fsmcolor editbackground editfont editcolor"><!--wrap choices to option2-->
	<input type="radio" '.$name.$check2.' value="compress_full_width">2. Choose percent option : All floated posts with this setting will continue compressing without minimum size<br>
	</div><!--wrap choices to option2-->
     <div class="fsmcolor editbackground editfont editcolor"><!--wrap percentage choices to option3-->
     <br><input type="radio" '.$name.$check3.' value="compress_to_percentage">3. Choose main width RWD based on @media width and choice of units option.
	<br>
     ';
	$this->show_more('more info on RWD Units choices','','italic smallest '.$this->column_lev_color);
	printer::print_wrap('more info on RWD Units choices');
	printer::print_tip('This alternative to the Original RWD grid system is simpler to implement and more versatile.  With this rwd system different width units may be chosen at each @media widths chosen and the same @media widths ie break points do not need to be used each time. ');
	printer::close_print_wrap('more info on main units');
	$this->show_close('more info on RWD Units choices');
     echo '</div><!--wrap choices to option3-->';
     echo ' </div><!--alt width wrapper1-->';
	printer::pclear(5);
     }//end width mode

function calc_alt_rwd_units($mediavalue,$widthunit){
	if ($widthunit==='rem'){
          $width=$mediavalue*$this->rem_root/$this->current_total_width*100;//rem
		return $width;
          $this->width_scale=($this->rem_scale)?'rem scaling on':'rem scaling off';
          $this->width_info.=$mediavalue."rem = {$width}px $this->width_scale<br>";
          
          }
     elseif ($widthunit==='em'){
          $width=$mediavalue*$this->terminal_font_em_px/$this->current_total_width*100;;
		return $width;
          $this->width_scale=($this->terminal_em_scale)?'em scaling on':'em scaling off';
          $this->width_info.=$mediavalue."em = {$width}px $this->width_scale<br>";
          }
     elseif ($widthunit==='%'){ 
          $width=$mediavalue;
		return $width;
          $this->width_scale='% scale';
          $this->width_info.=$mediavalue."% = {$width}px $this->width_scale<br>";
          $this->width_percent=true;
          }
     elseif ($widthunit==='px'){ 
          $width=$mediavalue/$this->current_total_width*100; 
		return $width;
          $this->width_scale=($this->terminal_px_scale)?'px scaling on':'px scaling off';
          $this->width_info.="{$width}px $this->width_scale<br>";
          }
     else {
          $width=0; 
		return $width;
           $this->width_info.="Not set<br>";
           }
	return $width;
	}
	
function compress_to_percent(){//and other units
	$cb_data=($this->is_column)?$this->col_dataCss:$this->dataCss;
	$type='blog';//
	$fitfactor=($this->is_masonry)?.985:.995;
	$widthunit_arr=array('px','%','rem','em');
	$mediavalue=(is_numeric($this->blog_width_mode[$this->{'blog_percent_init_index'}])&&$this->blog_width_mode[$this->blog_percent_init_index]>0)?$this->blog_width_mode[$this->blog_percent_init_index]:'';
     $defaultunit=(!empty($this->blog_width_mode[$this->blog_width_unit_init_index])&&in_array($this->blog_width_mode[$this->blog_width_unit_init_index],$widthunit_arr))?$this->blog_width_mode[$this->blog_width_unit_init_index]:'%';
    $marginleft=(is_numeric($this->blog_width_mode[$this->blog_marginleft_init_index])&&$this->blog_width_mode[$this->blog_marginleft_init_index]>=0)?'margin-left:'.($fitfactor*$this->blog_width_mode[$this->{'blog_marginleft_init_index'}]).$defaultunit.';':'';
	$marginright=(is_numeric($this->blog_width_mode[$this->blog_marginright_init_index])&&$this->blog_width_mode[$this->blog_marginright_init_index]>=0)?'margin-right:'.($fitfactor*$this->blog_width_mode[$this->blog_marginright_init_index]).$defaultunit.';':'';
	if(!empty($mediavalue))
		$css='
html div .'.$cb_data.'{width:'.($mediavalue*$fitfactor).$defaultunit.';'.$marginleft.$marginright.'}
	';
	else $css='';
	$array_key=$array_collect=array();
	for ($i=1; $i<9;$i++){
		$unit=(!empty($this->blog_width_mode[$this->{'blog_width_unit'.$i.'_index'}])&&in_array($this->blog_width_mode[$this->{'blog_width_unit'.$i.'_index'}],$widthunit_arr))?$this->blog_width_mode[$this->{'blog_width_unit'.$i.'_index'}]:$defaultunit;
		$mediawidth=(is_numeric($this->blog_width_mode[$this->{'blog_media_'.$i.'_index'}])&&$this->blog_width_mode[$this->{'blog_media_'.$i.'_index'}]>=250&&$this->blog_width_mode[$this->{'blog_media_'.$i.'_index'}]<=3000)?$this->blog_width_mode[$this->{'blog_media_'.$i.'_index'}]:'';
		$mediavalue=(is_numeric($this->blog_width_mode[$this->{'blog_percent_'.$i.'_index'}])&&$this->blog_width_mode[$this->{'blog_percent_'.$i.'_index'}]>0)?$this->blog_width_mode[$this->{'blog_percent_'.$i.'_index'}]:'';
		$marginleft=(is_numeric($this->blog_width_mode[$this->{'blog_marginleft_'.$i.'_index'}])&&$this->blog_width_mode[$this->{'blog_marginleft_'.$i.'_index'}]>=0)?'margin-left:'.($fitfactor*$this->blog_width_mode[$this->{'blog_marginleft_'.$i.'_index'}]).$unit.';':'';
		$marginright=(is_numeric($this->blog_width_mode[$this->{'blog_marginright_'.$i.'_index'}])&&$this->blog_width_mode[$this->{'blog_marginright_'.$i.'_index'}]>=0)?'margin-right:'.($fitfactor*$this->blog_width_mode[$this->{'blog_marginright_'.$i.'_index'}]).$unit.';':'';
		if (!empty($mediawidth)&&!empty($mediavalue))$array_collect[$mediawidth]=array($mediavalue,$marginleft,$marginright,$unit);  
		}//end for loop
	krsort($array_collect);
	$sortnext=array();
	$list=array_keys($array_collect); 
	if (count($list) > 0 && is_numeric($list[0]) && $list[0] >100 ){ 
		$this->css.='
		@media screen and (max-width:10000px) and (min-width:'.($list[0]+1).'px){'.$css.'}';
		}
	else $this->css.=$css;
	$previous='';
	foreach ($list as $key){
		$sortnext[$previous]=$key;
		$previous=$key;
		}
	 foreach ($array_collect as $key=>$sorted){
		$media_min=(array_key_exists($key,$sortnext))?$sortnext[$key]:'';
		$mediawidth=$key;
		$mediavalue=$sorted[0];
		$marginleft=$sorted[1];
		$marginright=$sorted[2];
		$unit=$sorted[3];
		if(!empty($mediawidth)&&!empty($mediavalue)){
			$min_media=(!empty($media_min))?' and (min-width:'.($media_min+1).'px)':'';
			$this->css.='
			@media screen and (max-width:'.$mediawidth.'px)'.$min_media.'{
	html div .'.$cb_data.'{width:'.($mediavalue*$fitfactor).$unit.';'.$marginleft.$marginright.'}
		}';
			}
		}//foreach array
	}

function width_rwd_alt_grid(){
	$data=$this->data;
     if ($this->is_clone&&!$this->clone_local_style)return;
	$cb_data=($this->is_column)?$this->col_dataCss:$this->dataCss;
	$type='blog';//
	$fitfactor=($this->is_masonry)?.985:.995;
	$widthunit_arr=array('px','%','rem','em');
	$this->show_more('Choose Values #3, RWD Width');
	printer::print_wrap('rwd alt grid');
	printer::print_notice('Choice #3 values chosen here');
     printer::print_info('Margins: Leave Blank to specify no margin declaration. 0 will specify margin left or right 0');
     $defaultunit=(!empty($this->blog_width_mode[$this->blog_width_unit_init_index])&&in_array($this->blog_width_mode[$this->blog_width_unit_init_index],$widthunit_arr))?$this->blog_width_mode[$this->blog_width_unit_init_index]:'%';
	$mediavalue=(is_numeric($this->blog_width_mode[$this->{'blog_percent_init_index'}])&&$this->blog_width_mode[$this->{'blog_percent_init_index'}]>0)?$this->{$type.'_width_mode'}[$this->{'blog_percent_init_index'}]:'';
     $marginleft=(is_numeric($this->blog_width_mode[$this->{'blog_marginleft_init_index'}])&&$this->{$type.'_width_mode'}[$this->{'blog_marginleft_init_index'}]>=0)?$this->{$type.'_width_mode'}[$this->{'blog_marginleft_init_index'}]:'';
     $marginright=(is_numeric($this->blog_width_mode[$this->{'blog_marginright_init_index'}])&&$this->{$type.'_width_mode'}[$this->{'blog_marginright_init_index'}]>=0)?$this->{$type.'_width_mode'}[$this->{'blog_marginright_init_index'}]:'';
     $width_unit=(is_numeric($this->blog_width_mode[$this->{'blog_width_unit_init_index'}])&&$this->{$type.'_width_mode'}[$this->{'blog_width_unit_init_index'}]>=0)?$this->{$type.'_width_mode'}[$this->{'blog_width_unit_init_index'}]:'%';
     $name2=$data.'_'.$type.'_width_mode['.$this->{'blog_percent_init_index'}.']';
     $name3=$data.'_'.$type.'_width_mode['.$this->{'blog_marginleft_init_index'}.']';
     $name4=$data.'_'.$type.'_width_mode['.$this->{'blog_marginright_init_index'}.']';
	$name5=$data.'_'.$type.'_width_mode['.$this->{'blog_width_unit_init_index'}.']';
	if($this->blog_width!==$mediavalue){
		if(!$this->is_clone||$this->clone_local_style){ 
			$value=$this->calc_alt_rwd_units($mediavalue,$defaultunit);
			$this->updater('typeenv',"{$type}_width='$value'",'idenv'); #here we update blog_width ie main width value because setting this will set this->use_blog_main_width to true and will also update width values in function total float with relative percent of parent column filled.
			}
		}
	printer::print_wrap('units');
     printer::print_tip('Choose a default initial Width unit:'); 
     forms::form_dropdown($widthunit_arr,'','','',$name5,$defaultunit,false,'editcolor editbackground editfont left');
	
	printer::close_print_wrap('units');
     printer::print_tip('Enter Initial width and margin values for large view screens.'); 
     echo '<table class="rwdmedia">
     <tr><th>Set Initial Width Unit Value</th><th>left-margin</th><th> right-margin</th></tr>';
     echo '<tr><td><input name="'.$name2.'" type="text" value="'.$mediavalue.'" ></td><td><input name="'.$name3.'" type="text" value="'.$marginleft.'" ></td><td><input name="'.$name4.'" type="text" value="'.$marginright.'" ></td></tr>
     </table>';
     printer::print_tip('Enter up to eight break point max-widths as between 250-3000 px (as px without the units) in any order and specify unit value for width/margin-left/margin-right required according to units being used');
     echo '<table class="rwdmedia">
     <tr><th>Media max-width bp</th><th>Width</th><th>left-margin</th><th>right-margin</th><th>units</th></tr>';
     for ($i=1; $i<9;$i++){
		$unit=(!empty($this->blog_width_mode[$this->{'blog_width_unit'.$i.'_index'}])&&in_array($this->blog_width_mode[$this->{'blog_width_unit'.$i.'_index'}],$widthunit_arr))?$this->blog_width_mode[$this->{'blog_width_unit'.$i.'_index'}]:$defaultunit;
          $mediawidth=(is_numeric($this->blog_width_mode[$this->{'blog_media_'.$i.'_index'}])&&$this->{$type.'_width_mode'}[$this->{'blog_media_'.$i.'_index'}]>=250&&$this->{$type.'_width_mode'}[$this->{'blog_media_'.$i.'_index'}]<=3000)?$this->{$type.'_width_mode'}[$this->{'blog_media_'.$i.'_index'}]:'';
          $mediavalue=(is_numeric($this->blog_width_mode[$this->{'blog_percent_'.$i.'_index'}])&&$this->{$type.'_width_mode'}[$this->{'blog_percent_'.$i.'_index'}]>0)?$this->{$type.'_width_mode'}[$this->{'blog_percent_'.$i.'_index'}]:'';
           $marginleft=(is_numeric($this->blog_width_mode[$this->{'blog_marginleft_'.$i.'_index'}])&&$this->{$type.'_width_mode'}[$this->{'blog_marginleft_'.$i.'_index'}]>=0)?$this->{$type.'_width_mode'}[$this->{'blog_marginleft_'.$i.'_index'}]:'';
           $marginright=(is_numeric($this->blog_width_mode[$this->{'blog_marginright_'.$i.'_index'}])&&$this->{$type.'_width_mode'}[$this->{'blog_marginright_'.$i.'_index'}]>=0)?$this->{$type.'_width_mode'}[$this->{'blog_marginright_'.$i.'_index'}]:'';
          $name1=$data.'_'.$type.'_width_mode['.$this->{'blog_media_'.$i.'_index'}.']';
          $name2=$data.'_'.$type.'_width_mode['.$this->{'blog_percent_'.$i.'_index'}.']';
          $name3=$data.'_'.$type.'_width_mode['.$this->{'blog_marginleft_'.$i.'_index'}.']';
          $name4=$data.'_'.$type.'_width_mode['.$this->{'blog_marginright_'.$i.'_index'}.']'; 
          $name5=$data.'_'.$type.'_width_mode['.$this->{'blog_width_unit'.$i.'_index'}.']'; 
          echo '<tr><td><input name="'.$name1.'" type="text" value="'.$mediawidth.'" ></td><td><input name="'.$name2.'" type="text" value="'.$mediavalue.'" ></td><td><input name="'.$name3.'" type="text" value="'.$marginleft.'" ></td><td><input name="'.$name4.'" type="text" value="'.$marginright.'" ></td><td>';
		forms::form_dropdown($widthunit_arr,'','','',$name5,$unit,false,'editcolor editbackground editfont left');
		echo '</td></tr>';
          }
     
     echo '</table>';
     printer::print_tip('The total width, margin-left, margin-right % of all posts combined sharing row space at a given @media bp will need to be less than or equal to 100%');
	
	printer::close_print_wrap('rwd alt grid');
	$this->show_close('Values #3, RWD Width');
     $this->submit_button();	
	}// end alt width response

function advanced_width_mode(){//uses blog altwidth value for nested columns also
     $type='blog';//
     exit;
	if ($this->is_clone&&!$this->clone_local_style)return;
	$check1=$check2=$check3=$check4=$check5='';
	$checked=' checked="checked"';
	$data=$this->data; 
          $altype=($this->blog_type==='nested_column')?'nested column post':'post';
		$colmsg=($this->blog_type==='nested_column')?'<b>Note: Setting alternative width on a nested column directly affects the column sizing itself</b>':'';
		echo '<div class="fsminfo editbackground editfont '.$this->column_lev_color.'"><!--alt width wrapper1-->';
	printer::print_notice('Choose values for #3 RWD @media responive width values');
     printer::print_info('Margins: Leave Blank to specify no margin declaration. 0 will specify margin left or right 0');
    
      echo '<div class="fsmnavy"><!--wrap percentage alt rwd-->';
     printer::print_tip('Enter up to eight @media tweaks setting a max-width between 250-3000 px (without the units) in any order and optionally specify one or more width/margin-left/margin-right/paddding-left/paddding-right values with units.');
     printer::print_info('All @media widths will automatically be in px. Included width value followed by one of px,rem,em or % for tweak value @media width supplied');
     echo '<table class="rwdmedia">
     <tr><th>Media max-width bp</th><th>Width</th><th>left-margin</th><th> right-margin</th><th>left-padding</th><th> right-padding</th></tr>';
     for ($i=1; $i<9;$i++){
          //blog_adv_media_1,blog_adv_width_1,blog_adv_marginleft_1
          $mediawidth=(is_numeric($this->blog_adv_media[$this->{'blog_media_'.$i.'_index'}])&&$this->blog_adv_media[$this->{'blog_media_'.$i.'_index'}]>=250&&$this->blog_adv_media[$this->{'blog_media_'.$i.'_index'}]<=3000)?$this->blog_adv_media[$this->{'blog_media_'.$i.'_index'}]:'';
          $mediapercent=(is_numeric($this->blog_adv_media[$this->{'blog_percent_'.$i.'_index'}])&&$this->blog_adv_media[$this->{'blog_percent_'.$i.'_index'}]>0&&$this->blog_adv_media[$this->{'blog_percent_'.$i.'_index'}]<=100)?$this->blog_adv_media[$this->{'blog_percent_'.$i.'_index'}]:'';
           $marginleft=(is_numeric($this->blog_adv_media[$this->{'blog_marginleft_'.$i.'_index'}])&&$this->blog_adv_media[$this->{'blog_marginleft_'.$i.'_index'}]>=0&&$this->blog_adv_media[$this->{'blog_marginleft_'.$i.'_index'}]<=100)?$this->blog_adv_media[$this->{'blog_marginleft_'.$i.'_index'}]:'';
           $marginright=(is_numeric($this->blog_adv_media[$this->{'blog_marginright_'.$i.'_index'}])&&$this->blog_adv_media[$this->{'blog_marginright_'.$i.'_index'}]>=0&&$this->blog_adv_media[$this->{'blog_marginright_'.$i.'_index'}]<=100)?$this->blog_adv_media[$this->{'blog_marginright_'.$i.'_index'}]:'';
          $name1=$data.'_'.$type.'_width_mode['.$this->{'blog_media_'.$i.'_index'}.']';
          $name2=$data.'_'.$type.'_width_mode['.$this->{'blog_percent_'.$i.'_index'}.']';
          $name3=$data.'_'.$type.'_width_mode['.$this->{'blog_marginleft_'.$i.'_index'}.']';
          $name4=$data.'_'.$type.'_width_mode['.$this->{'blog_marginright_'.$i.'_index'}.']';
          echo '<tr><td><input name="'.$name1.'" type="text" value="'.$mediawidth.'" ></td><td><input name="'.$name2.'" type="text" value="'.$mediapercent.'" ></td><td><input name="'.$name3.'" type="text" value="'.$marginleft.'" ></td><td><input name="'.$name4.'" type="text" value="'.$marginright.'" ></td></tr>';
          }
     
     echo '</table>';
     printer::print_tip('The total width, margin-left, margin-right % of all posts combined sharing row space at a given @media bp will need to be less than or equal to 100%');
    echo '</div><!--wrap percentage again-->
     </div><!--wrap percentage choices to option3-->';
     $this->submit_button();
     echo ' </div><!--alt width wrapper1-->';	
	}// end alt width response
     
#rwdbuild  #rwdop  #grid
function rwd_scale($numbers,$name,$css,$style,$type,$unit='px',$index,$after_index,$tiny=false,$convert=1,$incs='auto'){
     $notice='';//return notice
     if ($this->is_page){//add to css specificty
          if (!strpos($css,'html'))$css='html '.$css;
          }
     else if ($this->is_column){
          if (!strpos($css,'html'))$css='html '.$css;
          elseif (!strpos($css,'body'))$css=str_replace('html','html body',$css);
          elseif ($this->column_level>0)$css='div '.$css;
          }
     else{
          if (!strpos($css,'html'))$css='html '.$css;
          elseif (!strpos($css,'body'))$css=str_replace('html','html body',$css);
          else $css='div '.$css;
          }
	if (!$this->edit)return;  
	$beforeindexes='';
	$afterindexes='';   
	for ($i=0; $i<$index; $i++) $beforeindexes.=',';
	for ($i=$index+1; $i<$index+$after_index; $i++) $afterindexes.=',';
	$indexes=$beforeindexes.'scale_val,'.$afterindexes.'bp1,bp2,mod_percent,accuracy'; 
	$index_arr=explode(',',$indexes);
	$bp_arr=explode('@@',$numbers);
	for ($i=0; $i<count($index_arr);$i++){ 
		if (!array_key_exists($i,$bp_arr)){
			$bp_arr[$i]=0;
			}
		 }
	foreach($index_arr as $key =>$index){
		${$index.'_index'}=$key;
		}	
	$upper_width=4000;
	$accuracy=($bp_arr[$accuracy_index]==='accuracyOn')?true:false;
	$mod_percent=(is_numeric($bp_arr[$mod_percent_index])&&$bp_arr[$mod_percent_index]<=400&&$bp_arr[$mod_percent_index]>=24)? $bp_arr[$mod_percent_index]:100;  
	$value=(is_numeric($bp_arr[$scale_val_index])&&is_numeric($convert))?$bp_arr[$scale_val_index]*$convert:'';  
	$sort_arr=array();
	$bp1 = ($bp_arr[$bp1_index]>=300 && $bp_arr[$bp1_index] <=$upper_width)?$bp_arr[$bp1_index]:0;
	$bp2 = ($bp_arr[$bp2_index]>=250 && $bp_arr[$bp2_index] <=$upper_width)?$bp_arr[$bp2_index]:0;
     if ($name==='return_val'){ 
          if(!empty($value)&&is_numeric($bp1)&&is_numeric($bp2)&&($bp1-$bp2)>=50){
               return "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;scale enabled <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;upper-vp: $bp1 <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;lower-vp: $bp2 <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;linear mod percent: $mod_percent";
               }
          return;
          }
	$fsize=($tiny)?'tiny':'small';
	$this->show_more('RWD Scale Modify '.$type,'','highlight floatleft editfont '.$fsize.' editbackground buttoninfo','Choose bps to further RWD scale the size value you choose here'); 
	$this->print_wrap('break points');
	$this->show_more('Choices Info','','info underline italic');
	printer::print_wrap('info for rwd scaling');
	printer::print_tip('The above  size choice for this '.$type.' can change according to the user viewport width.  Choose the relevant upper and lower widths at which to scale down your chosing value.  Media queries will be generated to  linearly scale down the chosen px starting at the viewport width  you wish this '.$type.' to begin to smallerize  and finshing at a minimum vp width that you choose, ie 320px. Rwd scaling down will start for uppermax value through the  lower max setting  at which px is no longer resized. By default the scaling will be proportional to the difference in screen size, however you can <em>adjust the rate of change</em> using the third option below.'); 
	printer::print_tip('Note: A handy means of creating custom scaled em units is to scale the font-size px in the parent column or even a particlar post and em will scale accordingly!'); 
	printer::close_print_wrap('info for rwd scaling');
	$this->show_close('Choices Info');
	printer::print_wrap('Choose scale break point'); 
	$upper_msg=($this->is_page)?'Page width in default page settings':'Primary Column Width';
	printer::alert('Choose Upper viewport break point Width to begin Scaling '.$type.' the upper limit is set by the '.$upper_msg);
	$this->mod_spacing($name.'['.$bp1_index.']',$bp1,300,$upper_width,1,'px','none'); 
	printer::alert('Choose lower viewport Point to end Scaling '.$type);
	$this->mod_spacing($name.'['.$bp2_index.']',$bp2,250,$upper_width,1,'px','none');
	
	 if ($mod_percent!==100){
               printer::print_notice('Linear Scaling modified to: '.$mod_percent.'%');
              }
     $this->show_more('Modify default Linear Scaling','','smaller editcolor editfont editbackground');
	printer::print_wrap('linear modify');
	printer::alert('By default size change will scale one to one with changes in viewport size between the max and min viewport sizes you choose.  You can change this default behavior which occurs at a setting 100% to either speed up to 400% increase the rate of change (ie. 4x smaller) or decrease  down to 25% the rate of change to minimizing the final size change to get the exact rate change you need. <b>However Keep in mind much a smaller percentage of change makes bigger differences in the final unit value of the lower screen width setting for larger differences between upper and lower viewport sizes.</b> ');
     $msgjava='Choose percent adjust rate of change';
	$this->mod_spacing($name.'['.$mod_percent_index.']',$mod_percent,24,400,.1,'%','none',$msgjava);
     
	$this->submit_button();
	printer::close_print_wrap('linear modify');
	$this->show_close('Modify default One to One Scaling','','smaller editcolor editfont editbackground');
	$this->show_more('Enhanced Text Scaling','','smallest italic editcolor editfont editbackground');
	printer::print_wrap('enhanced break pts');
	printer::print_tip('Choose enhanced accuracy. Uses double the large number of @media width controlled font-sizes. Best use when styling large text posts that scales over large viewport widths to keep exact proportions with neighboring posts');
	if ($accuracy)
		printer::alert('<input type="checkbox" name="'.$name.'['.$accuracy_index.']" value="false">Turn Off Extra Accuracy');
	else
		printer::alert('<input type="checkbox" name="'.$name.'['.$accuracy_index.']" value="accuracyOn">Turn On Extra Accuracy');
	printer::close_print_wrap('enhanced break pts');
	$this->show_close('Enhanced Text Scaling');
	printer::close_print_wrap('Choose scale break point');   
	printer::pclear(); 
     $this->submit_button();
	$this->close_print_wrap('break points'); 
	$this->show_close('Set RWD Breakpoints');
	if ($style==='none')  return; //ie. proper top bottom left right position not chosen
     $arr='';
	if (strpos($bp_arr[$scale_val_index],'x@x@x')!==false){
          $arr=explode('x@x@x',$bp_arr[$scale_val_index]); 
          } 
	
     if (!is_numeric($bp1)||!is_numeric($bp2)||$bp1 < 200 || $bp2 < 100||($bp1-$bp2)<=50)return;
     printer::print_notice('Activated Scaling on Px');
     $notice=true;
     if (!empty($value)){
          $this->scale_render($arr,$value,$mod_percent,$incs,$css,$style,$bp1,$bp2,$unit,$accuracy);
          return 'Scaled Px units Activated! Typically overrides other unit settings';
          }
     
	}//end rwd_scale
              
function scale_render($arr,$value,$mod_percent,$incs,$css,$style,$bp1,$bp2,$unit,$accuracy=true){
     //the $arr is for border,radius with 4 values not 1
     if (!is_numeric($bp1)||!is_numeric($bp2)||$bp1 < 200 || $bp2 < 100||($bp1-$bp2)<=50)return;
     $diff=$bp1-$bp2;
     #right now incs used to adjust the factor and not used for the >100% mod_percent
     $incs=($accuracy)?150:75; 
     //incs directly proportional to the number of queries.
     $adjust=($mod_percent-100)/$incs;
	$typecss=($this->is_page)?'pagecss':'mediacss';
     $factor=$mod_percent;
     $increment = $bp1/$incs; //increments will gradulal decrease  proportional to current @media width.
     $this->$typecss.='
@media screen and (min-width:'.($bp1+1).'px){'
     .$css.' {'.$style.':'.$value.$unit.';}
     }';
     $keytrack=0;
     $flag=true;
     for ($i=$bp1; $i >= $bp2; $i-=$increment){
          $j=($i-$increment);
          if ($mod_percent>100){ 
               $factor-=$adjust; 
              $ratio=($j/$bp1)*($factor/$mod_percent);#factor starts out at mod_percent then gradually decreases..
              } 
          else $ratio=  1 - ((($bp1-$j)*($mod_percent/100))/$bp1);      //@100 ratio is linear to width change
          $increment=$i/$incs;          //as $mod_percent grows the $ratio decreases faster so the size decrease speeds up..
          
          if (!is_array($arr)){
               $finalcss=$css.' {'.$style.':'.($ratio*$value).$unit.'}'; 
               
               }
          else {
               $finalcss=$css.' {'.$style.':';
               foreach($arr as $val){
                    $finalcss.=($ratio*$val).$unit.' ';
                    }
               $finalcss.=';}';
               }
          #here we are going to store inarray the value for all scaling px size units @ the primary column width for width reference which takes into acount all pading and margins.  Also will tablulate font-size scaling which is directly related to em units which are valid units for paddings and widths... this mirrors the check_data key_down_check function ...
          $minbp=$i-$increment;
          $minw=($minbp>$bp2)?' and (min-width:'.ceil($minbp).'px)':''; 
          $this->$typecss.='
          @media screen and (max-width:'.ceil($i).'px)'.$minw.'{
               '.$finalcss.' 
          }'; //i/bp1 =
          }  
     if ($this->is_page)return; 
     $id=($this->is_column)?'c'.$this->col_id:'b'.$this->blog_id;
     if ($flag&&$i>=$this->max_width_limit) 
          $keytrack=$ratio*$value; 
     elseif ($flag&&!empty($keytrack)){
          $flag=false;
          }
     elseif ($flag) {
          $flag=false;
          }
     }
#rwdbuild  #build     
function rwd_build($type,$data){ 
     $width_enabled=true;
     if ($this->flex_enabled_twice){
          printer::print_notice('RWD grid width calc. off following parent tree activation of flexbox');
          $width_enabled=false;//turn off width calculator
          }
	if ($this->is_blog&&$this->blog_type==='gallery'&&$this->blog_tiny_data2==='master_gall')printer::printx('<p class="tip"> Master Galleries are fully responsive and perfom best at 100% of available width for each break point. directly set a maximum availble width in the configuration</p>');
	if ($type==='col'&&$this->column_level <1) return;  
	$cid=($this->blog_type==='nested_column')?$this->column_id_array[$this->column_level-1]:$this->col_id;
     $bc_id=($this->is_column)?'col_'.$this->col_id:'blog_'.$this->blog_id;
   
    if($this->edit&&!$this->is_clone){
         if ($type==='col'){
              $new_colgc="{$this->current_grid_units}@@$this->page_br_points";///col_grid_clone used as reference for use of configured page  grid units and bps and serve as a reference for cloned posts that if not matching throws error 
              if ($new_colgc !== $this->col_grid_clone){
                   $q="update $this->master_col_table set col_grid_clone='$new_colgc' where col_id=$this->col_id";
                   $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
                   }
              }
         else {
              $new_bloggc="{$this->current_grid_units}@@$this->page_br_points";
              if ($new_bloggc !== $this->blog_grid_clone){
                   $q="update $this->master_post_table set blog_grid_clone='$new_bloggc' where blog_id=$this->blog_id";
         
                   $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
                   }
              }
         }
   
    if($this->is_clone&&!$this->clone_local_style){ //blog/col_grid_clone used as reference for use of configured page  grid units and bps and serve as a reference for cloned posts that if not matching throws error
         $msg=''; 
         if (!empty($this->{$type.'_grid_clone'})){// page settings for cloned used must match with the original  page setting for bp values.
		//use alternative rwd instead for no restrictions..
               $c=explode('@@',$this->{$type.'_grid_clone'});
               if (count($c)>1){
                    $tarr=explode('@@',$this->{$type.'_grid_clone'});
                    if ($tarr[0]!=$this->current_grid_units){ 
                         $msg='Current Grid Units Mismatch & ';
                         }
                    if ($tarr[1]!=implode(',',$this->page_break_arr)){
                         $msg.='Page Break Point Mismatch';
                         }
                    if (!empty($msg)){
                         $msg.=NL.'RWD Mismatch of clone with this page setting for bps.  If   necessary you can choose the local style and cofig settings to reset! or match with the original parent settings: Grid Units: '.$tarr[0].' ; Page Grid Units: '.$tarr[1];
                         printer::alertx('<p class="neg supersmall floatleft">'.$msg.'</p>');
                        }
                   }
              }//count 2
         else{
              $msg="If Parent of Clone page setting for Break Points or Grid Units Differ From this page Current Break Points or Grid Settings enable clone local style and configure for proper width response";
              printer::alertx('<p class="neg whitebackground supersmall floatleft">'.$msg.'</p>');
              }
         }
     $bp_arr=$this->page_break_arr;
     rsort($bp_arr);//
     array_unshift($bp_arr,'max'.$bp_arr[0]); //insert @ beggining of array
     $gu=$this->current_grid_units;
     $countbp=count($bp_arr); 
     $current_calc=array();
      //new local version will be append class version
     $setup_arr=array('wid'=>$type.'_grid_width','left'=>$type.'_gridspace_left','right'=>$type.'_gridspace_right');
     if(!isset($this->grid_width_record[$cid]))
          $this->grid_width_record[$cid]=array();
     foreach($setup_arr as $prefix=>$field){
		$this->{'grid_class_selected_'.$prefix.'_array'}=array();
          if(!isset($this->{'column_total_gu_arr'}))$this->{'column_total_gu_arr'}=array();
          if(!array_key_exists($cid,$this->{'column_total_gu_arr'}))$this->{'column_total_gu_arr'}[$cid]=array();
          ${$field.'_arr'}=explode(',',$this->{$field});
          ${$prefix.'_grid_width'}=array();
          foreach ($bp_arr as $bp){
               ${$prefix.'_grid_width'}[$bp]=0;//set default
               }
          $x=0;
          foreach  (${$field.'_arr'} as $pgrid){//override default
               $pgrid_arr=explode('-',$pgrid);
               if (count($pgrid_arr)>4&&count($pgrid_arr)<7){
                    $bp=$pgrid_arr[2];
                    ${$prefix.'_grid_width'}[$bp]=$pgrid;//this is actual  previoulsy  chosen value and setting to wid left or right_grid_width value
                    }
               }//end foreach grid type array... 
          ${'select_'.$prefix.'_arr'}=array();
          ${$prefix.'_grid_unit'}=array();
          /*if ((!$this->is_clone||$this->clone_local_style)&&count(${$field.'_arr'})>$countbp){
              //class grid styles for columns and blogs are subbed out individually using the master updating mechanism..  Because of this if the number of break points decrease there will be too many classes and they are removed here!
              $newval=implode(',',array_slice(${$field.'_arr'},0,$countbp));
              $this->hidden_array[]='<input type="hidden" name="'.$data.'_'.$field.'" value="'.$newval.'">';//cut off xtra classes if bps for column less than previous
              } */
#rwd
         //here we pre-generating select choice array options for each bp and wid, left or right
         for ($i=0; $i<$countbp; $i++){
              $bp=$bp_arr[$i];
              $bp_class_specify=(substr($bp,0,3)==='max')?'':(($i<$countbp-1)?'-'.$bp_arr[$i+1]:'-'.$bp);  
              if(!array_key_exists($bp,$this->{'column_total_gu_arr'}[$cid]))$this->{'column_total_gu_arr'}[$cid][$bp]=0;
              if(!array_key_exists($bp,$current_calc))$current_calc[$bp]=0;
              ${'select_'.$prefix.'_arr'}[$bp]=array();
              $match=false;
              if($prefix==='wid'){
                   for ($ii=0; $ii<$gu+1; $ii++){
                         $ch=${'select_'.$prefix.'_arr'}[$bp][$ii]=$prefix.'-bp-'.$bp.$bp_class_specify.'-'.$ii.'-'.$gu;//creating full select arr for editor dropdown choice...
                         if ($ch===${$prefix.'_grid_width'}[$bp]){
                             // column_total_gu_arr is used as record for augmenting running tally on column_total_gu_array for this column wid units and breakpoint for displaying current row fill percentage 
                             $this->{'column_total_gu_arr'}[$cid][$bp]+=$ii;
                             // the selected grid unit is used to build the current class and populate in this case the wid_array  which is used to populate...$this->grid_width_record[$cid] for display
                             ${$prefix.'_grid_unit'}[$bp]=$ii;
                             //the prefix grid unit for breakpoints furthe go on to populated the grid class selected array used directly in css generation in global_master.class.php
                             //and of course in used for selected="selected"
                             $match=true;
                             $current_calc[$bp]+=$ii;
					    
                             }
                        } 
                   }
              else{
                    for ($ii=0; $ii<$gu; $ii+=.5){//$prefix here refers to non wid type
                         $ii2=(strpos($ii,'.5')===false)?$ii:str_replace('.5','',$ii).'x5';
                         $ch=${'select_'.$prefix.'_arr'}[$bp][$ii2]=$prefix.'-bp-'.$bp.$bp_class_specify.'-'.$ii2.'-'.$gu;
                         if ($ch===${$prefix.'_grid_width'}[$bp]){
                              $this->{'column_total_gu_arr'}[$cid][$bp]+=$ii;
                              ${$prefix.'_grid_unit'}[$bp]=$ii;
                              $match=true;
                              $current_calc[$bp]+=$ii; 
                              }
                         }
                    ${'select_'.$prefix.'_arr'}[$bp][0]='';//do not write 0 gu classname to element...
                    if(empty(${$prefix.'_grid_width'}[$bp])){//for non widths
                         ${$prefix.'_grid_unit'}[$bp]=0;
                         $match=true;
                         }
                    elseif (${$prefix.'_grid_width'}[$bp]===$prefix.'-bp-'.$bp.$bp_class_specify.'-0-'.$gu)
                         $match=false;//it will be set to empty class instead.
                    }
               if (!$match){//fill default class values for rendering classes... ie. not immed plugin values
                    $default_calc=($prefix==='wid')?$gu:0;
                    ${$prefix.'_grid_width'}[$bp]=($prefix==='wid')?$prefix.'-bp-'.$bp.$bp_class_specify.'-'.$default_calc.'-'.$gu:'';
                    ${$prefix.'_grid_unit'}[$bp]=$default_calc;
                    $this->{'column_total_gu_arr'}[$cid][$bp]+=$default_calc;
                    $current_calc[$bp]+=$default_calc; //gu tracker...
                    //$this->hidden_array[]='<input type="hidden" name="'.$data.'_'.$field.'" value="'.$finalarr.'">';//
                    //$this->instruct[]=('ReHit A SUBMIT Button For THIS TO UPDATE rwd break points of this m '.$type.' id:'.$bc_id.' so that it updates to  match with new bp settings on this current page. Check for  appropriate bps settings.');
                    }
               $id=($this->blog_type==='nested_column')?'c'.$cid:'p'.$this->blog_id;	
               $this->{'grid_class_selected_'.$prefix.'_array'}=array_merge($this->{'grid_class_selected_'.$prefix.'_array'},array(${$prefix.'_grid_width'}[$bp]));
               }//end for  bp
		
         }//foreach  field
	if (count($this->{'grid_class_selected_'.$prefix.'_array'})>0)
		$this->css_grid($this->page_break_arr,$gu);
#gridarray
    $bpcalc_arr=array(); 
    $bptotalcalc_arr=array();
    $msgcurr='';
    $msgtot='';
    for ($i=0; $i<count($bp_arr); $i++){
         $bp=$bp_arr[$i];
         if (!isset($bpcalc_arr))$bpcalc_arr=array();
         foreach($setup_arr as $prefix=>$field){  
              if (!isset(${$prefix.'_array'}))${$prefix.'_array'}=array(); 
              ${$prefix.'_array'}[substr($prefix,0,3).' @bp '.$bp]=${$prefix.'_grid_unit'}[$bp];
              }
         //prefix ie  wid left right 
         $bpcalc_arr['Cur Tot '.$bp]=$current_calc[$bp];
         $msgcurr.=$id.' @bp '.$bp.': '.$current_calc[$bp].'gu or '.(floor(($current_calc[$bp]/$gu)*10000)/100).'% of row<br>';
         $bptotalcalc_arr['Tot Tot '.$bp]=$this->{'column_total_gu_arr'}[$cid][$bp];
         $msgtot.='Tot Tot @bp '.$bp.': '.$this->{'column_total_gu_arr'}[$cid][$bp].'gu or '.(round($this->{'column_total_gu_arr'}[$cid][$bp]/$gu,4)).' full row(s)<br>';
         }
    $colpost=($type==='col')?'Column':'Posted Content';
    if((!$this->is_clone||$this->clone_local_style)){   
         printer::printx('<p class="fsm'.$this->column_lev_color.' '.$this->column_lev_color.' editbackground editfont">Posts and Columns within the Parent Column of this '.$colpost.' are enabled as a responsive Grid to share the total width of the column parent. Choose the relative width percentage display for this '.$colpost.'  for each break point which correspond to viewer device width values!.</p>');	
         $this->grid_width_record[$cid][]=array_merge(array('id:'=>$id),$wid_array,$right_array,$left_array,$bpcalc_arr,$bptotalcalc_arr);
         printer::printx('<p class="fsm'.$this->column_lev_color.' '.$this->column_lev_color.' editbackground editfont"><span class="bold center">'.$gu.'gu/row in use</span><br>'.$msgcurr.'</p>'); 
         $this->show_more('View Complete Grid Unit Use Table & Info','noback','italic editbackground editfont '.$this->column_lev_color.' underline','','600');
         printer::printx('<p class="fsm'.$this->column_lev_color.' '.$this->column_lev_color.' editbackground editfont"><span class="bold center">Tot# Rows Used For Posts Up to Current Post</span>in Col Id C'.$cid.'<br>'.$msgtot.'</p>');
         printer::printx('<p class="fsm'.$this->column_lev_color.' '.$this->column_lev_color.' editbackground editfont">Table below shows values in Grid Units. You are configured for '.$gu.'gu per row. Each row has values for a single Post up to the post your curently viewing for each break point class.<br><span class="info">"max"</span>  value refers to Device Screen Width greater than the largest break point.
<br>
<span class="info">"@bp"</span> or break point values target maximum screem width between its value and that greater than the next lowest value break point.<br> <span class="info">"wid"</span> refers to content width at the specified break point.<br><span class="info">"Rig"</span> or <span class="info">"Lef"</span> refer  to right or left (margin) spacing selected between posts; <br><span class="info">"Cur Tot"</span> refers to the total (wid+lef+rig) of each post at the particlar break point specified.<br> <span class="info">"Tot Tot"</span>  calculates the running total adding together all Cur Tot up to the current post.</p>');
         printer::horiz_print($this->grid_width_record[$cid],'','','','',false,false,'editcolor editbackground editfont smallest');
    $this->show_close('Show Grid Unit Use Table');
         }
    else {
         printer::print_tip('Note that RWD Grid Width Tracking is currently disabled following Activation of flex box, or other width units such em width, rem width, or  px scaled widths, also Alt Width with Min Width set in the parent column tree');
         }
    #rwdupdate  #gridupdate	#gridwid			  
     $grid_width='';//used for updating col_width and blog_width
     $column_level=($type==='col')?($this->column_level-1):$this->column_level;
     $this->grid_width_chosen_arr=array();
     $this->grid_post_percent_arr=array();
     $grid_width_arr=array();
     ### All the following pertains only to calculating physical px which does not in any way affect the normal column flow ....but provides information px and enables correct image rendering...
     // $this->column_bp_width_arr[$this->column_level]=array();
     foreach ($bp_arr as $bp){ 
          $grid_width.= (floor($wid_grid_unit[$bp]/$gu*10000)/100).',';//used for updating col_width and blog_width   
     if ($type==='col'){
          $maxlimit=(substr($bp,0,3)==='max')?$this->column_bp_width_arr[$this->column_level-1][$bp][1]:min($bp,$this->column_bp_width_arr[$this->column_level-1][$bp][1]);
          if($this->column_bp_width_arr[$this->column_level-1][$bp][1]>$bp) 
               $percentlimit=$wid_grid_unit[$bp]/$gu*$this->column_bp_width_arr[$this->column_level-1][$bp][0];
          else 
               $percentlimit=$wid_grid_unit[$bp]/$gu*$this->column_bp_width_arr[$this->column_level-1][$bp][0]*$wid_grid_unit[$bp]/$gu;
          $grid_temp=$this->column_bp_width_arr[$this->column_level][$bp][1]= $maxlimit* $wid_grid_unit[$bp]/$gu;//set new column_bp_width_arr for current by multipling parent value by current percent
          $this->column_bp_width_arr[$this->column_level][$bp][0]=$percentlimit;
          $this->grid_width_chosen_arr[$bp]=$grid_temp;//chosen width px
          $this->grid_width_available[$this->column_level][$bp]=$maxlimit;  
          }//end type = col
     else {  //post type
          $maxlimit=(substr($bp,0,3)==='max')?$this->column_bp_width_arr[$this->column_level][$bp][1]:min($bp,$this->column_bp_width_arr[$this->column_level][$bp][1]);
          $grid_temp= $this->grid_post_percent_arr[$bp]=$maxlimit*$wid_grid_unit[$bp]/$gu;//multiply parent value by current percent
          $this->grid_width_chosen_arr[$bp]=$grid_temp; //(substr($bp,0,3)==='max')?$this->max_width_limit*$grid_temp/100:$grid_temp*$maxlimit/100; 
          $this->grid_width_available[$this->column_level][$bp]=(substr($bp,0,3)==='max')?$this->column_net_width[0]*$this->column_total_net_width_percent[$this->column_level]/100:$this->column_total_net_width_percent[$this->column_level]*$maxlimit/100;
          $this->grid_width_available[$this->column_level][$bp]=$maxlimit;
          }//endelse post
     }//end foreach...
     # update the total bp array
     #Track and Update width according to max break point percentage value
     if ($this->edit&&!$this->is_clone&&isset($_POST['submitted'])){//this is more relaxed
          $grid_width=substr_replace($grid_width,'',-1);
          if($type==='col'){
               $new_col_width= floor($wid_grid_unit[$bp_arr[0]]/$gu*10000)/100;  
               if ($this->track_col_width!=$new_col_width){ 
                    $q="update $this->master_col_table set col_width='$new_col_width', col_update='".date("dMY-H-i-s")."',col_time='".time()."',token='".mt_rand(1,mt_getrandmax()). "' where col_id=$this->col_id";
                   $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
                    }
               }
          else{
               $new_blog_width=floor($wid_grid_unit[$bp_arr[0]]/$gu*10000)/100;
               if($this->blog_width!=$new_blog_width){
                    $q="update $this->master_post_table set blog_width='$new_blog_width', token='".mt_rand(1,mt_getrandmax()). "',blog_update='".date("dMY-H-i-s")."',blog_time='".time()."' where blog_id=$this->blog_id";//this is how we   keep current_net_width and current_net_width_percent current... with use of rwd...
                    $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
                    }
               }
          } 
     if($this->is_clone&&!$this->clone_local_style){
         return;
         }
    printer::printx('<p class="floatleft editbackground editfont left '.$this->column_lev_color.'">RWD Grid Set the % Width  of this '.$colpost.' Display For Device Width Conditions (break points)</p>');
    printer::pclear();
    $this->show_more('Style info','','info italic smaller');
     printer::print_wrap1('techinfo');
     printer::print_info('Current Grid Classes Applied to main div: '.$this->dataCss.':<br><br> Grid Width: '.$this->{$type.'_grid_width'}.'<br>
     Grid  margin left Spacing: '.$this->{$type.'_gridspace_left'}.'<br>Grid  margin right Spacing: '.$this->{$type.'_gridspace_right'});
      $msg='Class names are generated from  chosen grid percentage values and applied as supplemental class names to main div post type or  column. Corresponding css is generated only for each class name that is generated';
     printer::print_info($msg);
     printer::close_print_wrap1('techinfo');
     $this->show_close('Style info');
     printer::pclear();
    for ($i=0; $i<count($bp_arr); $i++){
          $bp=$bp_arr[$i];
          $curwid= ($width_enabled)?floor($this->grid_width_chosen_arr[$bp]):'';  
          $cur_wid_avail=($width_enabled)?floor($this->grid_width_available[$this->column_level][$bp]):'';
          $curleft=($width_enabled)?floor($left_grid_unit[$bp]/$gu*$cur_wid_avail):'';
          $curright=($width_enabled)?floor($right_grid_unit[$bp]/$gu*$cur_wid_avail):'';
          $px=($width_enabled)?'px':'';
          echo '<div class="fsminfo editcolor editbackground editfont" ><!--wrap bp line of choices-->';
           $msg=(substr($bp,0,3)==='max')?'View Screen Up to &amp; Over: '.$this->max_width_limit.'px':'Max Wid Screen:'.$bp.':';
          echo '<span class="bold">'.$msg."</span> total {$gu} gu/row<br>";
          echo '<p class="floatleft navybackground white .pl10"><!--Bp class choice-->     
          Width:
          <select class="editcolor editbackground editfont"  name="'.$data.'_'.$type.'_grid_width['.$i.']">        
          <option   value="'.$wid_grid_width[$bp].'" selected="selected">'.(floor($wid_grid_unit[$bp]/$gu*10000)/100).'% &nbsp;: &nbsp;'.$wid_grid_unit[$bp].' gu : '. $curwid.$px.'</option>';
          
          for ($num=0; $num<$gu+1; $num++){
               $swid=($width_enabled)?$cur_wid_avail*$num/$gu:'';
             echo '<option  value="'.$select_wid_arr[$bp][$num].'">'.(floor($num/$gu*10000)/100).'% &nbsp;: &nbsp;'.$num.' gu&nbsp;:&nbsp;'.$swid.$px.'</option>';
             }
          echo'	
          </select> </p><!--Bp class choice-->';
          printer::pclear(15);
                         #&&&&&&&&&&&&&&&&&&& Begin  Left  
         $msg2='Left Space:';
         echo '<p class=" smallest" title="Add Spacing To The Left of This Post For The Given Breakpoint . Useful for tweaking Post Width For Different Size Groupings. Space added is Outside of Borders and Background Features if used. Analogous to Margins"><!--Bp class choice-->     
         '.$msg2.'
         <select class="editcolor editbackground editfont"  name="'.$data.'_'.$type.'_gridspace_left['.$i.']">        
         <option   value="'.$left_grid_width[$bp].'" selected="selected">'.(floor($left_grid_unit[$bp]/$gu*10000)/100).'% :'.$left_grid_unit[$bp].'gu : '. $curleft.$px.'</option>';
         for ($num=0; $num<$gu; $num+=.5){
               $num2=(strpos($num,'.5')===false)?$num:str_replace('.5','',$num).'x5';
               $slef=($width_enabled)?$cur_wid_avail*$num/$gu:'';
               echo '<option  value="'.$select_left_arr[$bp][$num2].'">'.(floor($num/$gu*10000)/100).'% &nbsp;: &nbsp;'.$num.' gu/'.$gu.'gu :&nbsp;'.($slef).$px.'</option>';
               }
          echo'	
          </select> </p><!--Bp class choice-->';
          printer::pclear();
          #&&&&&&&&&&&&&&&&&&&		end left spacing
          #&&&&&&&&&&&&&&&&&&&  begin  Right 
         $msg2='Right Space:';
         echo '<p class=" smallest" title="Add Spacing To The Left or Right of This Post For The Given Breakpoint. Space added is Outside of Borders and Background Features if used. Will add to total gu use. See gu table for totals.  Analogous to Margins"><!--Bp class choice--><span class="info center">Add Left/Right Spacing (between posts)</span><br>      
         '.$msg2.'
         <select class="editcolor editbackground editfont"  name="'.$data.'_'.$type.'_gridspace_right['.$i.']">        
         <option   value="'.$right_grid_width[$bp].'" selected="selected">'.(floor($right_grid_unit[$bp]/$gu*10000)/100).'% &nbsp;: &nbsp;'.$right_grid_unit[$bp].' gu : '. $curright.$px.'</option>';
         for ($num=0; $num<$gu; $num+=.5){
               $num2=(strpos($num,'.5')===false)?$num:str_replace('.5','',$num).'x5';
               $srig=($width_enabled)?$cur_wid_avail*$num/$gu:'';
               echo '<option   value="'.$select_right_arr[$bp][$num2].'">'.(floor($num/$gu*10000)/100).'% &nbsp;: &nbsp;'.$num.' gu :&nbsp;'.($srig).$px.'</option>';
               }
          echo'	
          </select> </p><!--Bp class choice-->';
          #&&&&&&&&&&&&&&&&&&&&&&&  End Right
          printer::pclear();
          //echo '</div><!--Spacing Rwd Wrap-->';
          //$this->show_close('Add Spacing'); 
          echo '</div><!--wrap bp line of choices-->';
          $countbp--;
          }//for bp 
	#&&&&&&&&&&&&&&&&&&&&&&&&&&  END CLASS QUERY FOR  ACTIVE RWD POSTS  &&&&&&&&&&&&&&&&&&
	}//end ion rwd_build
     
     }