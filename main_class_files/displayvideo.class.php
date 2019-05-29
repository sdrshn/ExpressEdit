<?php
#ExpressEdit 2.0
class displayvideo {
function  render($vidname,$image=''){echo 'pt 1';
    if  (strpos($vidname, '.flv')){echo 'pt 2';
	  $this->flv($vidname,$image);
	  }
   /*else if  (strpos($vidname, '.mov')){
	 $this->mov($vidname,$image);
	 }
    else if  (strpos($vidname, '.wmv')){
	  $this->wmv($vidname,$image);
	  }*/
	else{  
	    Sys::report_error('error in video class: fileytype not recognized');
	    }
    }   
function flv($vidname,$image){echo 'pt 3';
    echo '
	   <div class="containvideo">
	   <div id="container"> </div>
	   <script type="text/javascript" src="'.Cfg_loc::Root_dir.'swfobject.js"></script>
	   <script type="text/javascript">
	   var s1 = new SWFObject("'.Cfg_loc::Root_dir.'player.swf","ply","400","300","9","#FFFFFF");
	   s1.addParam("allowfullscreen","true");
	   s1.addParam("allowscriptaccess","always");
	   s1.addParam("flashvars","file='.$vidname.'&amp;autostart=false&amp;image='.Cfg_loc::Root_dir.$image.'");
	   s1.addParam("wmode","opaque");
	   s1.write("container");
	   </script> 
	   </div>
	   ';
	   }
}
?>