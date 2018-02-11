<?php
class video {
private static $instance='';
function __construct(){ 
     }
function render_video($vidname,$image='',$width=400,$aspect=1.2,$viddir='',$autostart=false){ 
	$this->autostart=$autostart;
	$this->viddir=(empty($viddir))?((Cfg_loc::Root_dir=='')?Sys::Javaroot.Cfg::Vid_dir:Cfg_loc::Root_dir.Cfg::Vid_dir):$viddir;
	$this->viddir=Sys::Home_site.Cfg::Vid_dir;
	$this->vidname=$this->viddir.$vidname;
     $this->width=$width;
	$this->height=round($width/$aspect);
	$this->image=$this->viddir.$image;
	$this->poster=(!empty($image))?' poster="'.$this->image.'"':'';
	
     if  (strpos($this->vidname, '.flv')){ 
		$this->flv();
		}
   
	else if  (strpos($this->vidname, '.wmv')){
		$this->wmv();
		}
	else if  (strpos($this->vidname, '.mov')){
		$this->mov4();
		}  
	else if  (strpos($this->vidname, '.mp4')){
		$this->mp4();
		}
	else if (strpos($this->vidname, '.ogg')){
		$this->mov4();
		}
	else if (strpos($this->vidname, '.m4v')){
		$this->m4v();
		}
	else if (strpos($this->vidname, '.webm')){
		$this->webm();
		}
	else{  
	    Mail::error('error in video class: fileytype not recognized');
	    }
    }

    
function webm(){
	$autostart=(!empty($this->autostart))?'autostart':''; 
	echo '<video controls '.$autostart.' width="'.$this->width.'" height="'.$this->height.'" '.$this->poster.' >
	<source src="'.$this->vidname.'" type="video/webm">
	</video>';
	}
	
function m4v(){ 
	$autostart=(!empty($this->autostart))?'autostart':'';
	echo '<video controls '.$autostart.' width="'.$this->width.'" height="'.$this->height.'" '.$this->poster.' >
	<source src="'.$this->vidname.'" type="video/mp4">
	</video>';
	}
function ogg(){ 
	$autostart=(!empty($this->autostart))?'autostart':'';
	echo '<video controls '.$autostart.' width="'.$this->width.'" height="'.$this->height.'" '.$this->poster.'" >
	<source src="'.$this->vidname.'" type="video/ogg">
	</video>';
	}
function mp4(){ 
	$autostart=(!empty($this->autostart))?'autostart':'';
	$backupVid=str_replace('mp4','ogg',$this->vidname);
	$backupVid2=str_replace('mp4','webm',$this->vidname);
	echo '  
<video controls '.$autostart.' width="'.$this->width.'" height="'.$this->height.'" '.$this->poster.'> 
	<source src="'.$this->vidname.'" type="video/mp4" /><!-- Safari / iOS video    -->
	<!--<source src="'.$backupVid.'" type="video/ogg" /> Firefox / Opera / Chrome10 
	<!--<source src="'.$backupVid2.'" type="video/webm"> -->';
	$this->flv();//add backup
echo '</video>';
}

 
 function flv(){  
    static $count=0;
    $count++;
    if ($count==1)echo '<script type="text/javascript" src="'.Cfg_loc::Root_dir.Cfg::Vid_dir.'swfobject.js"></script>'; 
   $pic_display=($this->autostart)?'':'so.addVariable("image","'.$this->image.'");';
   $autostart=(!empty($this->autostart))?'so.addVariable("autostart","true");' :'so.addVariable("autostart","false");';
    echo '<div id="mediaspace'.$count.'"><p class="ramana">to View this Video Update your Flash Plugin!
    Go to http://get.adobe.com/flashplayer/ or click </p> <a href="http://get.adobe.com/flashplayer/">  here</a></div>
<script type="text/javascript">
  var so = new SWFObject("'.$this->viddir.'player.swf","ply","'.$this->width.'","'.$this->height.'","9","#000000");
  so.addParam("allowfullscreen","true");
  so.addParam("allowscriptaccess","always");
  so.addParam("wmode","opaque");
  so.addVariable("file","'.$this->vidname.'"); 
  '.$autostart.
  $pic_display.'
  so.addVariable("controlbar","bottom"); 
  so.addVariable("fullscreen","true");
  so.addVariable("stretching","fill");
  so.write("mediaspace'.$count.'");
</script>';
	
}

 


 

 
function swf(){ 
	echo'
	<object type="application/x-shockwave-flash"
	data="'.$this->vidname.'"
	width="'.$this->width.'" height="'.$this->height.'">
	<param name="movie" value="'.$this->vidname.'" >
	<param name="quality" value="high">
	</object>'; 
	}
	
	
	
	 

 

 
 

public static function instance(){ if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);//static allows it to create an instance without creating a new object
    if  (empty(self::$instance)) {
	   self::$instance = new video(); 
        } 
    return self::$instance; 
    }  
 }
?>