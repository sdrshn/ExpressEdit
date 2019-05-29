<?php
#ExpressEdit 2.0
 class  {
	#code
 }
 

function replace_it($search,$replace,$id,$tablename,$field){
$mysqlinst = mysql::instance(); 

foreach ($field as $f){
	$q="select $f, $id from $tablename";  
	$r=$mysqlinst->query($q,__line__,true); 
	while ($rows=$mysqlinst->fetch_assoc($r,__line__)){
		$val=$rows[$f];
		$row_id=$rows[$id];  
		if (strpos($val,$search)!==false){
			$val= mysqli_real_escape_string($mysqlinst->link,str_replace($search,$replace,$val));
			//$val= str_replace($search,$replace,$val);
			$q="update $tablename set $f='$val' where $id=$row_id";   echo $row_id ." $tablename is table $f is $field <br />";
			 $mysqlinst->query($q,__line__,true);
			}
		}
	}
} //end function
$id='option_ID';
$tablename='wp_options';
$field=array('option_value');
replace_it($search,$replace,$id,$tablename,$field);

$field=array('post_content','guid'); 
$id='ID';
$tablename='wp_posts'; 
replace_it($search,$replace,$id,$tablename,$field);
?>