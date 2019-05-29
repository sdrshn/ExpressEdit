<?php
#ExpressEdit 2.0
class passgen {
	
function generate($user,$password,$email){
	echo 'begin generate';
	$salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
	$password=hash('sha512',$password.$salt);
	//include ('includes/Sys.php');
	$rc4 = new encrypt;
	$password = $rc4->endecrypt(Cfg::Encrypt_pass,$password,'en');
	$mysqlinst=mysql::instance();
	$mysqlinst->dbconnect();
	$q="truncate members";
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	$q="insert into members (login_type,username,password,email,salt) values ('ownerAdmin','$user','$password','$email','$salt')"; 
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true); 
	echo $q;	
	echo NL.'End of script, check for success!';
	}
}
 
?>