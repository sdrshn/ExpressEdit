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
class expandgallery { 
	private static $instance=false; //store instance
	public $master_gall_table=Cfg::Master_gall_table; 
	public $page_source=false;
	public $maxexpand=1; 
	public $ext='.php';
	public $transition='fade';//set default
	public $clone='';
	public $preload=array();
	public $navigated=false;
	public $sfil='';
	public $returnto='';
function header_return($msg){
	if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	if (headers_sent()){
			mail::alert($msg.' in Expand Gallery Error'. __METHOD__,__LINE__,__FILE__);
			printer::alert_neu('Expanded Gallery Maintenance1');
			return;
			}
		if (!Sys::Edit||Sys::Loc){
			$url = $this->returnto;
			header("Location: $url");
			exit();
			}
		else {
			alert($msg.' in Expand Gallery Error'. __METHOD__,__LINE__,__FILE__);
			exit();
			}
		}
			
function check_json($file){
	if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
     if (!is_file($file))
		$this->header_return('Missing File '.$file); 
	$json=unserialize(file_get_contents($file)); 
     if (is_array($json)&&count($json)>0)
		return $json;
     $this->header_return('Error in array formation in '.$file.' in file '.__FILE__.' on line '.__LINE__);
     }
	   
function pre_render_data(){ 
	if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__); 
	$this->passclass_ext=(Sys::Pass_class)?Cfg::Temp_ext:'';	  
	$this->viewport_width=process_data::get_viewport();
	$file=Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Gall_info_dir.'gall_image_data_'. $this->gall_ref.$this->passclass_ext; 
	if (is_array($return=self::check_json($file))){
		$this->img_array=$return;
		} 
	else if (Sys::Edit) return;
	else {
		mail::alert('array formation in '.__FILE__.' on line '>__LINE__);
		return;
		}
	if (is_file(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Gall_info_dir.'data_master_gall_ref'.$this->passclass_ext)){
		$mastergalllookup=unserialize(file_get_contents(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Gall_info_dir.'data_master_gall_ref'.$this->passclass_ext));
		}
	else $mastergalllookup=array();
	$this->master_gall_ref=(array_key_exists($this->gall_ref,$mastergalllookup))?$mastergalllookup[$this->gall_ref]:''; 
	$this->picmax=count($this->img_array)-1; 
	if (isset($_GET['pic_order']))$this->pic_order=$_GET['pic_order']; 
	else $this->pic_order=1;
	if(!is_numeric($this->pic_order)||$this->pic_order>$this->picmax||empty($this->pic_order))$this->pic_order=1;
	$this->pic_order=intVal($this->pic_order);
	$blog_data2=explode(',',$this->blog_data2);
	for ($i=0; $i <10; $i++){  
		if (!array_key_exists($i,$blog_data2)){
			$blog_data2[$i]=0;
			}
		}  
	$this->render_body_main(); 
	}//function pre render data
  
function render_body_main(){ 
	if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	$this->heightclass=($this->fixheight!=='noheight')?' height100':'';
	$class=''; 
	$this->fadeout_id='holder_'.$this->blog_id;
	$fade_opacity='';
	ob_start();
	if ($this->new_page_effect) {//simulate and not displaying page previews
 echo <<<eol
     <script>
         \$('body').addClass('simulated');
         \$('#$this->dataCss').css({'background' : 'none','border':'none','box-shadow':'none'}); 
     </script>
eol;
		echo ' <div class="'.$this->dataCss.$this->heightclass.'" id="'.$this->dataCss.'" style="display:block; margin:0 auto; max-width:'.$this->maxexpand.'px;"><!--holdback--><div id="holder_'.$this->blog_id.'" class="'.$this->heightclass.'"><!--used for fading display--><div id="displayCurrentSize"></div>';
		if (Sys::Pass_class){
			printer::alert_neg('Viewing Database: '.Sys::Dbname);
			printer::alert_neu('<a class="acolor click" href="'.Sys::Returnpass.'">Return Back to Edit Pages</a>'); 
			}
		$clear=($this->topcontrol)?40:70; 
		echo '
		 <div class="expand-menu-icon"><a '.$class.' href="'.$this->returnto.'"><div class="xbar1"></div><div class="xbar2"></div><div class="xbar3"></div></a></div>'; 
		printer::pclear($clear);
		}
     $close_display= ($this->new_page_effect)?'':' style="display:none;"';
     echo '<div class="slippry_wrapper'.$this->heightclass.'">
          <div class="gall_slipimg_'.$this->blog_id .$this->heightclass.'">';
     if ($this->topcontrol){
          echo'
          <div class="slipcontrol slipcontrol_'.$this->blog_id.' textshadow">
<ul>
<li class="previous">
<a class="previous" href="#glob" title="Previous"><span>Previous</span>
</a></li>
<li  class="next">
<a class="next" href="#glob" title="Next"><span>Next</span>
</a></li>
<li class="play">
<a class="play" href="#glob" title="Play slideshow "><span>Play</span>
</a></li>
<li>
<a class="pause" href="#glob" title="Pause slideshow "><span>Pause</span>
</a></li>
<li  class="close" '.$close_display.'>
<a class="close" href="'.$this->returnto.'" title="Close Backto Gallery"><span>Close</span>
</a></li>
</ul></div>';
          printer::pclear(10);     
          }
			  
     echo '
          <ul id="slippry_'.$this->blog_id.'" style="margin: 0 auto;text-align: center">'; 
     for ($i=1; $i<$this->picmax+1; $i++){
          $this->picname=$this->img_array[$i][0];
          $this->imagetitle=$this->img_array[$i][1];
          $this->subtitle=$this->img_array[$i][2];
          $this->description=$this->img_array[$i][3];
          $this->image_ratio=$this->img_array[$i][4]/$this->img_array[$i][5];
          $this->alt='img: '.$this->picname;
          $this->calc_width();
          $this->slippry();
          $this->pic_order=$i;  
          }
     echo '</ul> 
          </div><!--slippry-->  
     </div><!--gall_img-->';
	if (!$this->slide)$this->captions();	
	if ($this->show_under_preview)$this->show_under_preview(); 
	if ($this->new_page_effect)  print ('</div><!--holdback--></div><!--holder_-->
	</div><!--close main class div-->');
	$data = ob_get_contents(); 
	ob_end_clean(); 
	$data=json_encode(str_replace('  ',' ',$data));
	echo '<script>
	gen_Proc.slippry_'.$this->blog_id.'='.$data.'
	</script>';
	return; 
	}	
	
function slippry(){
	if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	$imagetitle=(!empty(trim($this->imagetitle)))?$this->imagetitle:((!empty($this->default_imagetitle))?$this->default_imagetitle:'');
	$subtitle=(!empty($this->subtitle))?$this->subtitle:((!empty($this->default_subtitle))?$this->default_subtitle:'');
	$description=(!empty($this->description))?$this->description:((!empty($this->default_description))?$this->default_description:'');
	if ($this->slide_caption)$this->alt=$imagetitle; 
	if ($this->slide_caption||!$this->caption_display) 
		$description=$imagetitle=$subtitle='';
	if ($this->picname===Cfg::Pass_image)$this->image_dir='';
	echo ' <li class="imagerespond"><a  data-wid="'.$this->image_width.'"><img style="display:block;margin: 0 auto;
  align-self: auto;" src="'.Cfg_loc::Root_dir.Cfg::Large_image_dir.$this->image_dir. $this->picname.'"  alt="'.$this->alt.'" data-width="'.$this->percent_width.'" data-description="'.$description.'" data-title="'.$imagetitle.'" data-subtitle="'.$subtitle.'" ></a></li>';
     }
     
function calc_width(){ 
	if ($this->image_ratio > 1){
		$width=$this->maxexpand;
		$height=$width/$this->image_ratio;
		$this->percent_width=$this->maxwidth_adjust_expanded;//for slippry
		}
	else {
		$height=$this->maxexpand;
		$width=$height*$this->image_ratio;
		$this->percent_width=100*$this->image_ratio;
		}
	$maxed_width=($this->viewport_width >200)?min($this->viewport_width,$width):$width;		if (is_numeric($this->fixheight)){  
		$fwidth=$this->fixheight*$this->image_ratio; 
		if ($fwidth > $maxed_width){
			$maxed_width=$fwidth;
			}
		}
	$maxed_width=($this->transition==='kenburns')?$maxed_width*1.4:$maxed_width;
	$this->image_width=$image_width=check_data::key_up($this->page_cache_arr,$maxed_width,'val',$this->page_width); 
	$this->image_dir=($this->picname===Cfg::Pass_image)?'':Cfg::Response_dir_prefix.$image_width.'/';
	if (!is_file(Cfg_loc::Root_dir.Cfg::Large_image_dir.$this->image_dir.$this->picname)){          echo Cfg_loc::Root_dir.Cfg::Large_image_dir.$this->image_dir.$this->picname;
		image::resize_check($this->picname,0,0,$image_width,Cfg_loc::Root_dir.Cfg::Upload_dir,Cfg_loc::Root_dir.Cfg::Large_image_dir.$this->image_dir,$this->blog_id);
		}	   
	} 
	
function captions(){
	if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);if ($this->slide_caption||!$this->caption_display) return;
	if ($this->gall_display==='slippry'){
		$imagetitle=process_data::clean_break((!empty($this->default_imagetitle))?$this->default_imagetitle:'');
		$subtitle=process_data::clean_break((!empty($this->default_subtitle))?$this->default_subtitle:'');
		$description=process_data::clean_break((!empty($this->default_description))?$this->default_description:''); 
		echo'<div style="max-width:'.($this->maxexpand).'px;" class="marginauto"><!--min width wrap--> 
			<div class="maxwidth95 displaytable marginauto mainPicInfo_'.$this->blog_id.' " id="mainPicInfo_'.$this->blog_id.'">';// 
		echo '<p id="imagetitle_'.$this->blog_id.'" class="imagetitle_'.$this->blog_id.'" > 
				'. $imagetitle . '</p>';  
			 
		echo' <p id="subtitle_'.$this->blog_id.'" class="subtitle_'.$this->blog_id.'">' . $subtitle . '</p>';
			  
		echo '<p id="description_'.$this->blog_id.'" class="description_'.$this->blog_id.'">'.$description. '</p>';
				 
		echo '</div><!--End mainPicInfo--></div><!--max width wrap--> '; 
		}
	else {//ie highslide  
		$imagetitle=(!empty(trim($this->imagetitle)))?$this->imagetitle:((!empty($this->default_imagetitle))?$this->default_imagetitle:'');
		$subtitle=(!empty($this->subtitle))?$this->subtitle:((!empty($this->default_subtitle))?$this->default_subtitle:'');
		$description=(!empty($this->description))?$this->description:((!empty($this->default_description))?$this->default_description:'');	
		$des_wid=max(strlen($imagetitle),strlen($subtitle),strlen($description));
		if ($des_wid > 5){ 
		echo'<div style="max-width:'.($this->maxexpand).'px;" class="marginauto"><!--min width wrap--> 
			<div class="maxwidth95 displaytable marginauto mainPicInfo_'.$this->blog_id.' " id="mainPicInfo_'.$this->blog_id.'">';// 
			
		if (!empty($imagetitle)){   
			echo '<p id="imagetitle_'.$this->blog_id.'" class="imagetitle_'.$this->blog_id.'" > 
				'. $imagetitle . '</p>';  
				}
				
			if (!empty(trim($subtitle))){ 
				echo' <p id="subtitle_'.$this->blog_id.'" class="subtitle_'.$this->blog_id.'">' . $subtitle . '</p>';
				}
			   
			if (!empty($description)){
				echo '<p id="description_'.$this->blog_id.'" class="description_'.$this->blog_id.'">'.$description. '</p>';
				}
			echo '</div><!--End mainPicInfo--></div><!--max width wrap--> ';
			}
		else echo ' <div   class="mainPicInfo_'.$this->blog_id.'" style="padding-top:20px;"></div>';
		}
	}//end captions
	
function show_under_preview(){
	if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	if ($this->gall_display==='slippry'){
		$gall_foci='.gall_preview_'.$this->blog_id;
		echo <<<eol
		<script>
		function goToSlippry(index){ 
			var xnew= {start: index};
			var opts = $.extend({},slippry_$this->blog_id.getSlipprySettings(), xnew);
			slippry_$this->blog_id.destroySlider();
			slippry_$this->blog_id = slippry_$this->blog_id.slippry(opts);
			setTimeout(function(){ 
				$('$gall_foci').focus();
				},10); 
			}
		</script>
eol;
		}
	echo'<div style="max-width:'.($this->maxexpand).'px;" class="marginauto"> 
	<div class="gall_preview_'.$this->blog_id.' marginauto inlineblock" style="max-width:90%;"  ><!--gall preview-->';
	  
	for ($i=1;$i<$this->picmax+1;$i++){  //create array so order can be by preload nums not pic_order
		$picname=$this->img_array[$i][0]; 
		$imagetitle=$this->img_array[$i][1]; 
		$wid=$this->img_array[$i][4]; 
		$height=$this->img_array[$i][5]; 
		$this->alt=substr($imagetitle,0,25); 
		$opacity= ($this->pic_order==$i)?100:50;
		$opacity2= ($this->pic_order==$i)?1 :.50;
		$clone='&amp;clone_ref='.$this->clone;//acts as fallback in ajax
		if ($this->gall_display==='slippry'){  
			$onclick='onclick="goToSlippry('.$i.');return false;"';
			echo'
			<p class="thumbs"> 
			<a  class="prevD" href="#" '.$onclick.'>
			<img class=" thumbpad thumbnail_'.$this->blog_id.'"    
			   src="'.Cfg_loc::Root_dir.'small_images/'. $picname
			. '"  alt="" > </a> </p>';
		    }
		}//foreach
	if ($this->next_gallery&&is_file(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Gall_info_dir.'nextgall_data_'.$this->master_gall_ref.$this->passclass_ext)){
		$fgall_info=unserialize(file_get_contents(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Gall_info_dir.'nextgall_data_'. $this->master_gall_ref.$this->passclass_ext)); 
		$gall_ref=array();
		$gall_table=array(); 
		$fname_arr=array();
		foreach ($fgall_info as $key => $arr){
			$fname_arr[$key]=$arr[0];
			$gall_refarr[$key]=$arr[1];
			$gall_tablearr[$key]=$arr[2];  
			} 
		$maxkey=count($gall_refarr); 
		if ($maxkey > 1){
			$current_order=array_search($this->gall_table,$gall_tablearr); 
			$onclick='onclick="fadeTo.fadeTo_init(\''.$this->fadeout_id.'\','.$this->transition_time.',100,0,-2);gen_Proc.delayGoTo(this,'.$this->transition_time.');return false;"';
			$addtourl=(isset($_GET['gallreturnurl']))?'?gallreturnurl='.$_GET['gallreturnurl']:'';
			if ($current_order > 1&&array_key_exists($current_order+1,$fname_arr)){
				list($wid,$height)=process_data::get_size('prev_gallery.gif');  
				echo '<div class="floatleft thumbs" > <a  href="'.trim($fname_arr[$current_order-1]).$this->ext.$addtourl.'" '.$onclick.'><img class="thumbnail thumbnail_'.$this->blog_id.'"  src="prev_gallery.gif"  alt="View Previous Gallery"/></a></div>';
				}
			 if ($current_order < $maxkey&&array_key_exists($current_order+1,$fname_arr)){
				list($wid,$height)=process_data::get_size('next_gallery.gif');  
				echo '<div class="floatleft thumbs"> <a href="'.trim($fname_arr[$current_order+1]).$this->ext.$addtourl.'" '.$onclick.'><img class="thumbnail thumbnail_'.$this->blog_id.'" src="next_gallery.gif"  alt="View Next Gallery"/></a></div>';
				//lets preload nextgallery first image....
				$gallfirstimage=unserialize(file_get_contents(Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Gall_info_dir.'data_gall_firstimagelist'.$this->passclass_ext));
				$gallref=$gall_refarr[$current_order+1];  
				$picname=$gallfirstimage[$gallref][0];
				$ratio=$gallfirstimage[$gallref][1];
				if ($ratio > 1){
					$pwidth=$this->maxexpand;
					$pheight=$pwidth/$ratio;
					}
				else {
					$pheight=$this->maxexpand;
					$pwidth=$pheight*$ratio;
					}
				$maxed_width=($this->viewport_width >200)?min($this->viewport_width,$pwidth):$pwidth;//precaution if < 200 may be inaccurate
				$image_width=check_data::key_up($this->page_cache_arr,$maxed_width,'val',$this->page_width);
				$image_dir=Cfg::Response_dir_prefix.$image_width.'/';
				}
			printer::pclear();
			} //arra key exists
		}//if next gall 
	printer::pclear();
	if ($this->gall_display !=='slippry'){ 
		echo '
	    <script type="text/javascript">
	    fadeTo.preloading('.$this->preload.');
	    </script>';
          echo '
	    </div><!--end gall preview-->
	    </div>';
          printer::pclear();
          }
	}//end show preview
     
public static function instance(){ if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);//static allows it to create an instance without creating a new object
     if  (empty(self::$instance)) {
          self::$instance = new expandgallery(); 
          } 
     return self::$instance; 
     }    

}//end class contact_master
?>