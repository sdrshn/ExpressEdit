<?php
#ExpressEdit 2.0.2
//source  unknown

class encrypt { 
function endecrypt ($pwd, $data, $case='') { 
     if ($case == 'de') { 
          $data = urldecode($data); 
          } 
     $key[] = ""; 
     $box[] = ""; 
     $temp_swap = ""; 
     $pwd_length = 0; 
     $pwd_length = strlen($pwd);
     for ($i = 0; $i <= 255; $i++) { 
         $key[$i] = ord(substr($pwd, ($i % $pwd_length), 1)); 
         $box[$i] = $i; 
          } 
     $x = 0;
     for ($i = 0; $i <= 255; $i++) { 
         $x = ($x + $box[$i] + $key[$i]) % 256; 
         $temp_swap = $box[$i]; 
         $box[$i] = $box[$x]; 
         $box[$x] = $temp_swap; 
          } 
     $temp = ""; 
     $k = ""; 
     $cipherby = ""; 
     $cipher = "";
     $a = 0; 
     $j = 0;
     for ($i = 0; $i < strlen($data); $i++) { 
         $a = ($a + 1) % 256; 
         $j = ($j + $box[$a]) % 256;
         $temp = $box[$a]; 
         $box[$a] = $box[$j]; 
         $box[$j] = $temp; 
         $k = $box[(($box[$a] + $box[$j]) % 256)]; 
         $cipherby = ord(substr($data, $i, 1)) ^ $k;
         $cipher .= chr($cipherby); 
          } 
     if ($case == 'de') { 
         $cipher = urldecode(urlencode($cipher));
          }
     else { 
         $cipher = urlencode($cipher); 
          } 
     return $cipher; 
     }
     
static function getRandomBytes($nbBytes = 32){
         $bytes = openssl_random_pseudo_bytes($nbBytes, $strong);
         if (false !== $bytes && true === $strong) {
                return $bytes;
                }
         else {
                throw new Exception("Unable to generate secure token from OpenSSL.");
                }
         }

static function generatePassword($length){
	  return substr(preg_replace("/[^a-zA-Z0-9]/", "", base64_encode(self::getRandomBytes($length+1))),0,$length);
	  } 

} //end class
 

?>