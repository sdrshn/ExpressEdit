<?php
#ExpressEdit 2.0
class include_copy_gen{
 
static function copypath($source,$destination) {
     if (is_file(Cfg_loc::Root_dir.'includes/'.$source)){ 
          copy (Cfg_loc::Root_dir.'includes/'.$source,$destination);
          return true;
          }
     else {
          $path= stream_resolve_include_path('includes/'.$source);
          if (!$path===false){ 
               copy ($path,$destination);
               return true;
               } 
          elseif (is_file(TWO_UP.'includes/'.$source)){ 
               copy (TWO_UP.'includes/'.$source,$destination);
               return true;
               } 
          elseif (is_file(ONE_UP.'includes/'.$source)){ 
               copy (ONE_UP.'includes/'.$source,$destination);
               return true;
               } 
          else {
               return false;
               }
          }
     }
     
public static function  instance(){ //static allows it to create an instance without creating a new object
    
    if  (empty(self::$instance)) {
	   self::$instance = new mysql(); 
        } 
    return self::$instance; 
    } 
}//end class

?>