<?php
#ExpressEdit 2.0.2
class video_master {
private static $instance='';

function render_video($vidname,$image='',$width=400,$aspect=1.2,$viddir='',$autostart=0,$loop=0,$mute=0,$cc=0,$controls=1){
     if (Sys::Edit){
          printer::alert_neu($viddir.$vidname. ' uploaded video playing here',1.3);
          return;
         }
     //height and width no longer relevant to new video type...
	$this->autostart=$autostart; 
     $this->mute=$mute;
     $this->loop=$loop;
     $this->cc=$cc;//hide close captions
     $this->controls= $controls; 
	$this->viddir=(!empty($viddir))?$viddir:Cfg_loc::Root_dir.Cfg::Vid_dir; //((Cfg_loc::Root_dir=='')?Sys::Javaroot.Cfg::Vid_dir:
	$this->vidname=$this->viddir.$vidname;
     $this->width=$width;
	$this->height=round($width/$aspect);
	$this->image=$image;
	$this->poster=(!empty($image))?' poster="'.$this->image.'"':' poster="" '; 
	
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
	/*else if (strpos($this->vidname, 'youtube')){
          $this->vidname=$vidname;
		$this->yt_api();
		}*/
	else{
          if ($this->edit)mail::error('error in video class: fileytype not recognized: '.$this->vidname);
	    else printer::alert_neu('New Video Coming Soon');
         return;
         }
    }
function  yt_api(){
     $yt_id=str_replace('youtube','',$this->vidname);
     $ele_id=$this->viddir;//use viddir slot for this method
echo <<<EOL
 
<script async src="https://www.youtube.com/iframe_api"></script>
<script>
 function onYouTubeIframeAPIReady() {
  var player;
  player = new YT.Player('$ele_id', {
    videoId: '$yt_id', // YouTube Video ID
    width: $this->width,               // Player width (in px)
    height: $this->height,              // Player height (in px)
    playerVars: {
      autoplay: $this->autostart,        // Auto-play the video on load
      controls:1,// $this->controls,        // Show pause/play buttons in player
      showinfo: 0,        // Hide the video title
      modestbranding: 1,  // Hide the Youtube Logo
      loop: $this->loop,            // Run the video in a loop
      fs: 0,              // Hide the full screen button
      cc_load_policy: $this->cc, // Hide closed captions
      iv_load_policy: 3,  // Hide the Video Annotations
      autohide: 1,         // Hide video controls when playing
     playlist: '$yt_id' //for looping
    },
    events: {
      onReady: function(e) {
        e.target.mute();
      }, 
     onStateChange: function(e){
          var id = '$yt_id';
          if(e.data === YT.PlayerState.ENDED){
               player.loadVideoById(id);
               }
          }
    },
     
     });
 }

 // Written by @labnol 
</script> 
EOL;
     }//end function
    
function webm(){
	$controls=($this->controls)?' controls ': '';
     $loop=($this->loop)?' loop ': '';
     $mute=($this->mute)?' muted ' : '';
	$autostart=($this->autostart)?' autoplay ':'';
     echo '<video class="myvid" '.$controls.$mute.$autostart.$loop.' width="100%" '.$this->poster.' >
	<source src="'.$this->vidname.'" type="video/webm">
	</video>';
	}

function m4v(){ 
	$controls=($this->controls)?' controls ': '';
     $loop=($this->loop)?' loop ': '';
     $mute=($this->mute)?' muted ' : '';
	$autostart=($this->autostart)?' autoplay ':'';
     echo '<video class="myvid" '.$controls.$mute.$autostart.$loop.'width="100%" '.$this->poster.' >
	<source src="'.$this->vidname.'" type="video/mp4">
	</video>';
	}
function ogg(){ 
	$controls=($this->controls)?' controls ': '';
     $loop=($this->loop)?' loop ': '';
     $mute=($this->mute)?' muted ' : '';
	$autostart=($this->autostart)?' autoplay ':'';
     echo '<video class="myvid" '.$controls.$mute.$autostart.$loop.' width="100%" '.$this->poster.'" >
	<source src="'.$this->vidname.'" type="video/ogg">
	</video>';
	}
function mp4(){
     $controls=($this->controls)?' controls ': '';
     $loop=($this->loop)?' loop ': '';
     $mute=($this->mute)?' muted ' : '';
	$autostart=($this->autostart)?' autoplay ':'';
	$backupVid=str_replace('mp4','ogg',$this->vidname);
	$backupVid2=str_replace('mp4','webm',$this->vidname); 
	echo '  
<video class="myvid" '.$controls.$mute.$autostart.$loop.' width="100%" '.$this->poster.'> 
	<source src="'.$this->vidname.'" type="video/mp4" /><!-- Safari / iOS video    -->
	<!--<source src="'.$backupVid.'" type="video/ogg" /> Firefox / Opera / Chrome10  -->
	<!--<source src="'.$backupVid2.'" type="video/webm"> -->';
	$this->flv();//add backup
     echo '</video>';
     }
 
 function flv(){  
     static $count=0;
     $count++;
     if ($count==1)echo '<script src="'.Cfg_loc::Root_dir.Cfg::Vid_dir.'swfobject.js"></script>'; 
     $pic_display=($this->autostart)?'':'so.addVariable("image","'.$this->image.'");';
     $autostart=(!empty($this->autostart))?'so.addVariable("autostart","true");' :'so.addVariable("autostart","false");';
     echo '<div id="mediaspace'.$count.'"><p class="ramana">to View this Video Update your Flash Plugin!
    Go to http://get.adobe.com/flashplayer/ or click </p> <a href="http://get.adobe.com/flashplayer/">  here</a></div>
<script>
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

function mov4(){
     $autostart=(!empty($this->autostart))?'autoplay="true"':'autoplay="false"';
     $autostart2=(!empty($this->autostart))?"'autoplay', 'true',":"'autoplay', 'false',";
     echo <<<EOL
<script src="http://www.apple.com/library/quicktime/scripts/ac_quicktime.js" language="JavaScript"></script>
<script src="http://www.apple.com/library/quicktime/scripts/qtp_library.js" language="JavaScript"></script>
 <div id="quicktimevideo">
<script><!--
QT_WritePoster_XHTML('Play Video', '$this->image',
'$this->vidname',
'$this->width', '$this->height', '',
'controller', 'true',
$autostart2
'bgcolor', 'white',
'scale', 'aspect');
//-->
</script>
<noscript>
<object width="$this->width" height="$this->height" classid="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B" codebase="http://www.apple.com/qtactivex/qtplugin.cab">
<param name="src" value="$this->image" >
<param name="href" value="$this->vidname" >
<param name="target" value="myself" >
<param name="controller" value="true" >
<param name="autoplay" value="false" >
<param name="scale" value="aspect" >
<embed width="$this->width" height="$this->height" type="video/quicktime" pluginspage="http://www.apple.com/quicktime/download/"
src="'.$this->image.'"
href=""$this->vidname"
target="myself"
controller="true"
$autostart
scale="aspect">
</embed>
</object>
</noscript>
</div>
EOL;
     }

public static function instance(){ if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);//static allows it to create an instance without creating a new object
    if  (empty(self::$instance)) {
	   self::$instance = new video_master(); 
        } 
    return self::$instance; 
    }  
 }
?>