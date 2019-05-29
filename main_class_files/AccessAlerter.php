<?php
#ExpressEdit 2.0
if (isset($_SERVER['HTTP_USER_AGENT'])){
	   $OS=$_SERVER['HTTP_USER_AGENT'];
	   }
    else $OS='unknown';
    $OSB="OS and browser: $OS";
    if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $TheIp=$_SERVER['HTTP_X_FORWARDED_FOR'];
    else $TheIp=$_SERVER['REMOTE_ADDR'];
 $TheIp=($TheIp=='69.161.29.18')?'SudarshanIp':$TheIp;   
 $TheIp=($TheIp=='74.102.133.88')?'YoungIp':$TheIp;  
$msgxx='epromocamera'."\n\r".$TheIp."\n\r".$OSB;
$subjectx=$TheIp.' ePromo';
//echo $msgxx; exit($msgxx);
	 mail('sdrshn@hotmail.com',$subjectx, $msgxx, "From: Sudarshan");  
?>