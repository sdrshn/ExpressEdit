<?php
	#class time modified from orginal by Arthur Coucouvitis
	class time {
	const Digits = 7;     
	private static $instance=false; //store instance  
	private $delta_log=''; 
	  
#  ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~
function __construct($name='') {   
	//  ini_set('precision', 15);//default is 14
	$this->request_time=$_SERVER['REQUEST_TIME'];  
	$this->time_init=self::microtime_float();
	 $this->diff_request_ini=$this->time_init-$this->request_time;
	} # time.new()
 

function microtime_float()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}

 

 
 public function delta() {   
 $diff=self::microtime_float()-$this->time_init;
 $resolution=self::Digits;
  $fmt = '%'.$resolution.'.'.($resolution-3).'f';
   $delta = sprintf("$fmt",$diff);
   return substr(($delta),-(self::Digits-1));
 
   } # time.delta()
 

public static function instance(){ //static allows it to create an instance without creating a new object
    if  (empty(self::$instance)) {
	   self::$instance = new time(); 
	   } 
    return self::$instance; 
    }
 
function delta_log($funct){
	$this->delta_log.="<br>\n deltatime post ".$funct.':'. self::delta();
	}
	
 function  return_delta_log(){ 
	if  (isset($this->delta_log)){
	   $msg=date("dMY-H-i-s").' diff request ini: ' .$this->diff_request_ini.'  logged times: '.$this->delta_log;
          //process_data::write_to_file('deltalog',$msg);
		return $msg;   }
	$msg="the deltalog does not exist in ".__FILE__;  
	  mail::error($msg,'deltalog problem');
	   
	}    
 } # class Time
?>
