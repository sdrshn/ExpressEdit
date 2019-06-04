<?php 
class arrayhandler {// for switching and checking array key and var elements

static function get_assoc($keyfield,$valuefield,$table,$where='',$dbase=Sys::Dbname){
    $mysqlinst=mysql::instance();
    $mysqlinst->dbconnect($dbase);
    $q="select $keyfield,$valuefield  from $table $where ";
    $r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
    $table=array();
    While($rows=$mysqlinst->fetch_row($r,__LINE__)){
	   $table[$rows[0]]=$rows[1];
	   }
    return $table;
    }
    
static function key_to_var_check($tbn,$str=Cfg::Table_to_file){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);//backup_html variant
    $table_to_file = self::string2KeyedArray($str);//  table to file is array with k
    if (array_key_exists($tbn,$table_to_file)){
	   $var=$table_to_file[$tbn];}
    else $var=$tbn;
    return $var;
    }//end function table to file	

static function string2KeyedArray($string, $delimiter = ',', $kv = '=>') {if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
    $ka='';
    if ($a = explode($delimiter, $string)) { // create parts 
	   foreach ($a as $s) { // each part
		  if ($s) {
			 if ($pos = strpos($s, $kv)) { // key/value delimiter
				$ka[trim(substr($s, 0, $pos))] = trim(substr($s, $pos + strlen($kv)));
				}
			 else { // key delimiter not found
				$ka[] = trim($s);
				}
			 }
		  }  
	   return $ka;
	   }
    } // string2KeyedArray

static function select_option($array, $name,$msg){
    $tableArray=(is_array($array))?$array:explode(',',$array);
    echo '
    <fieldset>'.$msg.'<br>
    Select option from dropdown menu list:<br>
    <select name="'.$name.'">        
    <option value="none" selected="selected">Choose None</option>';
    foreach ($tableArray as $val){
          echo '  
          <option value="'.$val.'">Choose '.str_replace('_',' ',$val).'</option>'; 
          }
     echo'</select>
     </fieldset>';
     }
    
static function is_empty_array($mixed){ if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__); 
     if (is_array($mixed)) {
          foreach ($mixed as $value) {
               if (!self::is_empty_array($value)) {
                    return false;
                    }
               }
          }
     elseif (!empty($mixed)) {  
        return false;
          }
     return true;
     } 
   
static function keyreturnvar($master_array, $check_array ) {if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	$out_array=array(); 
     foreach ($check_array as $key=> $var){//  will check array key or  var and output master var
	     foreach($master_array as $key1=> $var1){
               if ($key1==$var){ 
                    $out_array[]=$var1;
                    }
               }//end first foreach
          }//end second foreach
    return ($out_array);
}//end function
           
static function vartokey($master_array, $check) {if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);	    
    $x=0;
    $outVal='';
    foreach($master_array as $key=> $var){ 
	   if ($var==$check){
		  $outVal=$key;
		  $x++;
		  }//end if
	   }//end   foreach
     if ($x>1){
          mail::error('More than one positive vartokeys found');
          }
     return $outVal;
     }//end function

static function arrayreturnkey($master_array, $check_array ) {if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	$out_array=array(); 
     foreach ($check_array as $key=> $var){//  will check array key or  var and output master var
	     foreach($master_array as $key1=> $var1){
               if ($var1==$var){ 
                $out_array[]=$key1;}
               }//end first foreach
          }//end second foreach
     return ($out_array);
     }//end function
  
static function returnvar($master_array, $check_val ){ if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__); //for checking single use check_array anyway  note: probably not in use
	$out_array=array();
     foreach($master as $key1=> $var1){
          if ($var1==$check_val){ 
              $out_array[]=$key1;
              }
          }//end first foreach
     return ($out_array);
     }//end function  
 
static function implode_with_key($assoc, $inglue = '=>', $outglue = ','){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
        $return = '';
        foreach ($assoc as $tk => $tv){
            $return .= $outglue . $tk . $inglue . $tv;
          }
     return substr($return,strlen($outglue));
     }
    
static function explode_with_key($str, $inglue = "=>", $outglue = ','){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
     $hash = array();
     foreach (explode($outglue, $str) as $pair){            
          $k2v = explode($inglue, $pair);            
          $hash[$k2v[0]] = $k2v[1];            
          }
     return $hash;
     } 
    
static  function arraytolower($array, $include_leys=false) {if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
     if($include_leys) { 
          foreach($array as $key => $value) { 
               if(is_array($value)) 
                    $array2[strtolower($key)] = arraytolower($value, $include_leys); 
               else 
                    $array2[strtolower($key)] = strtolower($value); 
               } 
          $array = $array2; 
          } 
     else { 
          foreach($array as $key => $value) { 
               if(is_array($value)) 
                    $array[$key] = arraytolower($value, $include_leys); 
               else 
                    $array[$key] = strtolower($value);   
               } 
          } 
    return $array; 
     }//end function
   
static function implodeMDA($array, $delimeter='=>', $keyssofar = '') {
     $output = '';
     foreach($array as $key => $value) {
         if (!is_array($value)) {
             $value = str_replace($delimeter, '/'.$delimeter, $value);
             $key = str_replace($delimeter, '/'.$delimeter, $key);
             if ($keyssofar != '') $key = $key.$delimeter.$delimeter;
             $pair = $key.$keyssofar.$delimeter.$delimeter.$delimeter.$value;
             if ($output != '') $output .= $delimeter.$delimeter.$delimeter.$delimeter;
             $output .= $pair;
               }
          else {
               if ($output != '') $output .= $delimeter.$delimeter.$delimeter.$delimeter;
               if ($keyssofar != '') $key = $key.$delimeter.$delimeter;
               $output .= self::implodeMDA($value, $delimeter, $key.$keyssofar);
               }
          }
     return $output;
	}
	
#note this made a mistake but worked close
//  Can explode a string created by corresponding implodeMDA function
//  Uses a few basic rules for explosion:
//        1. Instances of delimeters in strings have been replaced by '/' followed by delimeter 
//        2. 2 Delimeters in between keys
//        3. 3 Delimeters in between key and value
//        4. 4 Delimeters in between key-value pairs
#echo NL.'functions testing'; printer::vert_print(arrayhandler::explodeMDA(arrayhandler::implodeMDA($matches2)));
#note this made a mistake but worked close
static function explodeMDA($string, $delimeter='=>') {
     $output = array();
     $pair_delimeter = $delimeter.$delimeter.$delimeter.$delimeter;
     $pairs = explode($pair_delimeter, $string);
     foreach ($pairs as $pair) {
         $keyvalue_delimeter = $delimeter.$delimeter.$delimeter;
         $keyvalue = explode($keyvalue_delimeter, $pair);
         $key_delimeter = $delimeter.$delimeter;
         $keys = explode($key_delimeter, $keyvalue[0]);
         $value = str_replace('/'.$delimeter, $delimeter, $keyvalue[1]);
         $keys[0] = str_replace('/'.$delimeter, $delimeter, $keys[0]);
         $pairarray = array($keys[0] => $value);
         for ($counter = 1; $counter < count($keys); $counter++) {
               $pairarray = array($keys[$counter] => $pairarray);
               }
	   $output = array_merge_recursive($output, $pairarray);
          }
     return $output;
     }

static function implodeAssoc($array){
     $return = '';
     if (count($array) > 0){
          foreach ($array as $key=>$value){
               $return .= $key . '=>' . $value . '----';
               }
          $return = substr($return,0,strlen($return) - 4);
          }
    return $return;
     }

static function explodeAssoc($string){
     $return = array();
     $pieces = explode('----',$string);
     foreach($pieces as $piece){
          $keyval = explode('=>',$piece);
          if (count($keyval) > 1){
               $return[$keyval[0]] = $keyval[1];
               }
          else {
               $return[$keyval[0]] = '';
               }
          }
     return $return;
     } 
}//end class
?>