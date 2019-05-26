<?php
class site_master extends global_master{
	//const changes here will over global_master.class and global_edit_master.php const
	//site master has sitewide effect and will not be updated
	//any function can be overriden or appended to here 
        

function header_insert(){
     //custom header <scripts>
     //custom js css files can go here
     }


	
function analytics(){// ie google analystics for site.. will not be rendered on local system
echo <<<eol
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-20932630-1']);
  _gaq.push(['_setDomainName', 'ekarasa.com']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
eol;
}

function render_body_addtop(){
	#to put data at top of body within  body tag
	#otherwise empty
	}
     
function render_body_end(){  
//parent function not empty
//add content here 
parent::render_body_end();
}

function css_site_master(){
#css styles here will have site wide effect
$this->css.='
.mycss{ }


';
}
 
}//end class
?>