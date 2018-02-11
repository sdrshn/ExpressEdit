<?php
class navigation_loc extends  navigate {  
//replace or append any navigate function

function nav_single($dir_filename,$name,$option='',$nav_add_url=false,$submenu=false){ 
     //example custom code 
       parent::nav_single($dir_filename,$name,$option,$nav_add_url,$submenu); 
     }
}
?>