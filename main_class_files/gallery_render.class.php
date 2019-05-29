<?php
#ExpressEdit 2.0
class gallery_render{
	public $pad_top=false;
	public $menu_place=90;
	public $container=720;
	public $highslide_background='fff';
	public $high_back_cap='fff';
	public $highslide_image='fff';
	public  $gall_topbot_pad=70;
	public $gall_container_width='590';
	public $gallery_row_width='590';
	public  $display='highslide_simple'; 
	public $imagetype='pic';

function __construct(){	 
	chdir ('/var/www/trish/');
	$this->valid_pic_ext='jpg,gif,png,jpeg';
	$this->valid_pic_ext=explode(',',$this->valid_pic_ext);
	$this->dir='thumbs250/';
	$this->meddir='medimages800/';
	$num=1;
	$this->pic_order=1;
	$this->height_array=array();
	 $this->dir = rtrim($this->dir, "/") ."/";  
	if (!$this->directory_handle = opendir($this->dir))exit ('$this->dir is not a directory');
	while (($this->file_handle = readdir($this->directory_handle)) !== false) {
		if (($this->file_handle == '.') || ($this->file_handle== '..') )continue;
		$this->path_parts = pathinfo($this->file_handle);
		if ( isset($this->path_parts['extension'])){ #check etc
			if (!in_array(strtolower($this->path_parts['extension']),$this->valid_pic_ext))continue;
			}
		else continue;
		if (is_dir($this->file_handle))continue;

		$this->size	= GetImageSize($this->dir.$this->file_handle);
		$this->width			= $this->size[0];
		$this->height			= $this->size[1];
		$this->height_array[$num]=array('height'=>$this->height,'width'=>$this->width);
		$num++;
		}//end first while
	closedir($this->directory_handle);   
	$this->style='';
	$this->padleft=0;
	$this->lastpad=false;
	$this->position=1;
	$this->flag=false;
    // Fetch each:
	if (!$this->directory_handle = opendir($this->dir))exit ('$this->dir is not a directory');
	while (($this->file_handle = readdir($this->directory_handle)) !== false) {
		 if (($this->file_handle == '.') || ($this->file_handle== '..') )continue;
		$this->path_parts = pathinfo($this->file_handle);
		if ( isset($this->path_parts['extension'])){ #check etc
			if (!in_array(strtolower($this->path_parts['extension']),$this->valid_pic_ext))continue;
			}
		else continue;
		if (is_dir($this->file_handle))continue;
		$this->size	= GetImageSize($this->dir.$this->file_handle);
		$this->width			= $this->size[0];
		$this->height			= $this->size[1]; 
		$this->heightmax=$this->height;
		$this->width=round($this->width);
		 $this->continue=true;
		$this->total_width=0;
		$this->padding_render();
		$this->half=($this->pad_top)?$this->heightmax-$this->height+$this->gall_topbot_pad:($this->heightmax-$this->height+$this->gall_topbot_pad)/2;
		$this->halfup= ceil($this->half);
		$this->halfdown=($this->pad_top)? 0: floor($this->half);  //echo "heightmax is $this->heightmax .NL. half is $this->half and halfup is $this->halfup .NL. height is " .$this->rows['height'] ;
		$this->padleft=$this->padleft=($this->lastpad)?$this->padleft:round(($this->gall_container_width-$this->total_width)/$this->xfactor); //echo "pl$this->padleft xf$this->xfactor tw$this->total_width";
		$this->style='style="padding-top: '.$this->halfup.'px; padding-bottom: '.$this->halfdown.'px; padding-left: '.$this->padleft.'px;"';
		$this->padleft=$this->padleft;//for function rows_caption 
		$this->style_top='style="padding-top: '.$this->halfup.'px; padding-left: '.$this->padleft.'px;"';
		$this->style_bot='style="padding-bottom: '.$this->halfdown.'px;padding-left: '.$this->padleft.'px;"';
		$this->gallerycontent_width=$this->width+$this->padleft;
		$this->gallerycontent_style='style="width:'.$this->gallerycontent_width.'px; padding-top: '.$this->halfup.'px; padding-bottom: '.$this->halfdown.'px; padding-left: '.$this->padleft.'px;"';
		$this->gallerycontent_style_text='style="width:'.$this->gallerycontent_width.'px; height: 150px;"';
		$this->single_row_style='style="width:'.$this->gallerycontent_width.'px; height:'.($this->height+$this->gall_topbot_pad).'px;"';
		$this->single_row_style_text='style="width:325px; height:'.($this->height+$this->gall_topbot_pad).'px;"';
		#new version removes height parameter so caption title is even with photo top
		#$this->single_row_style_text='style="width:325px;"  ';
		$this->style_vid='style="padding-top: '.$this->halfup.'px; padding-bottom: '.$this->halfdown.'px; padding-left: '.$this->padleft.'px; width="'.$this->width.'" height="'.$this->height.'"';
		if ($this->imagetype=='pic'||$this->imagetype=='text_image'){  
		  
			if ($this->display=='highslide_simple') $this->highslide_simple($this->style);
			else if ($this->display=='highslide_single') $this->highslide_single();
			else if ($this->display=='edit_display') $this->edit_display(); 
			else if ($this->display=='edit_rows_caption') $this->edit_rows_caption();
			else if ($this->display=='rows_caption') $this->rows_caption(); 
			else if ($this->display=='expandgallery') $this->expandgallery();
			else if ($this->display=='gallerycontent') $this->gallerycontent();
			else if ($this->display=='display_single_row') $this->display_single_row();
			else echo $this->message[]='wrong parameter'.Sys::error_info(__line__,__file__,__method__);
			}
		else if ($this->imagetype=='vid'){  
			if (!is_file(Cfg_loc::Root_dir.Cfg::Vid_dir.$this->littlename)){
				  $this->littlename =$this->bigname ;
				  }
			if ($this->display=='highslide') echo '<div class="containvideo" '.$this->style.'>';
			else if ($this->display=='highslide_single')echo '<div class="video_highslide_single">';
			 $this->video= video::instance();
			 $this->video->render_video($this->bigname,$this->littlename,$this->width,$this->height);
			if ($this->display=='edit_display') $this->edit_vid_display();
				echo'</div>';
				}//end else
		else {
		    $this->message[]='imagetype is null'. Sys::error_info(__line__,__file__,__method__);
		    }
		$this->pic_order++;
		
		}//end while
	}//end function

function highslide_simple(){  
	echo '<a href="'.$this->meddir. $this->file_handle.'" class="highslide" onclick="return hs.expand(this)"><img class="border" '.$this->style.' src="'.$this->dir. $this->file_handle  . '" width="'. $this->width  . '" height="' . $this->height  . '" alt="image photo '.$this->file_handle.'" /> </a>'; 
	}
    
function padding_render(){  
    if ($this->position==1){
	    echo '<div class="clear" ></div>'; 
	   }
    $this->total_width=0;
    $this->continue=true;
    $this->x=1;
    $this->countx=0;
    $this->county=0;
    for ($this->y=$this->position-1; $this->y >=0;$this->y--){  
	   $this->width2=$this->height_array[$this->pic_order-$this->y]['width']+$this->total_width;
	   if ($this->width2<$this->gallery_row_width){ 
		  $this->total_width=$this->width2;	
		  $this->height2=$this->height_array[$this->pic_order-$this->y]['height'];
		  $this->heightmax=($this->height2>$this->heightmax)?$this->height2:$this->heightmax;
		  $this->county++;
		  }
	   }//end for 
    
    if (array_key_exists($this->pic_order+1,$this->height_array)){ 
	   $this->width2=$this->height_array[$this->pic_order+1]['width']+$this->total_width;
	   if ($this->width2>$this->gallery_row_width){
		  $this->xfactor=$this->position+1;
		  $this->position=1;
		  $this->prev_total_width=$this->total_width; //to adjust final rowreturn;
		  $this->continue=false;
		  }
	   }
	$this->x=1;
	While ($this->continue) {
		if (array_key_exists($this->pic_order+$this->x,$this->height_array)){ 
			$this->width2=$this->height_array[$this->pic_order+$this->x]['width']+$this->total_width;
			if ($this->width2<$this->gallery_row_width){ 
				$this->total_width=$this->width2;	
				$this->height2=$this->height_array[$this->pic_order+$this->x]['height'];
				$this->heightmax=($this->height2>$this->heightmax)?$this->height2:$this->heightmax;
				$this->x++;
				$this->countx++;
				}
			else {
			    $this->continue=false;
			    $this->xfactor=$this->position+$this->x;
			    $this->position++;
			    }
			}//if array key
		else {
			($this->x==1)&&$this->lastpad=true;#this is to copy padding of previous to correct for last of last image paddings!!
			$this->x--;
			$this->new_total_width=$this->total_width;
			$this->z=1;
			$this->flag=true;
			while($this->flag){ 
				$this->new_total_width=$this->new_total_width + ($this->width);
				if ($this->new_total_width<$this->gallery_row_width){
					$this->total_width=$this->new_total_width;
					$this->z++;
					}
				else $this->flag=false;
				}
			$this->xfactor=$this->position+$this->x+$this->z;// here I added extra -1 to augment the padding_left!   means one less space to divide area by..   
			$this->position++;
			$this->continue=false;
			 
		}//end while continue
	   
    }//end function padding render




	    } // End of WHILE loop.
}//end class
 new gallery_render();