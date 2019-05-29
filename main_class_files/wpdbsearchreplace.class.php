<?php
#ExpressEdit 2.0
class wpdbsearchreplace {
 
static function replace_it($search,$replace,$id,$tablename,$field,$dbhost='localhost',$dbname=Sys::Dbname,$Dbuser=Cfg::Dbuser,$Dbpass=Cfg::Dbpass){
echo NL."$search,$replace,$id,$tablename,$field,$dbhost";  
	$link=mysqli_connect($dbhost,$Dbuser,$Dbpass, $dbname);
	foreach ($field as $f){
		$query="select $f, $id from $tablename";  
		if ($result = mysqli_query($link, $query)) {
			 while ($rows = mysqli_fetch_assoc($result)) {    
				$val=$rows[$f];
				$row_id=$rows[$id];  
				if (strpos($val,$search)!==false){
					$val= mysqli_real_escape_string($link,str_replace($search,$replace,$val));
					//$val= str_replace($search,$replace,$val);
					$q="update $tablename set $f='$val' where $id=$row_id";   echo $row_id ." $tablename is table $f is $field <br>";
					$r=mysqli_query($link,$q);
					}
				}
			}
		else exit('echo problem dude');
		}
	} //end function
}//end class
?>