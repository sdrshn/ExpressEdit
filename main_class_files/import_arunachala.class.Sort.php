<?php
#ExpressEdit 2.0
class import_arunachala {
     #  <([{\^-=$!|]})?*+.>
     #non greed (.*?)
     function __construct(){
            if (is_file('arunachala/noDivMatch.txt'))unlink('arunachala/noDivMatch.txt');
           if (is_file('arunachala/created.txt'))unlink('arunachala/created.txt');
           if (is_file('arunachala/copied.txt'))unlink('arunachala/copied.txt');
           if (is_file('arunachala/uncopied.txt'))unlink('arunachala/uncopied.txt');
            if (is_file('arunachala/unopened.txt'))unlink('arunachala/unopened.txt');
         $html_pmatch='/\<div id\="pgData"\>(.)\<div class\="clr bkg"/s';
          $key_pmatch='/\<meta name\="keywords"(.*)"\>/';
          $description_pmatch='/\<meta name="description"(.*)"\>/';
          $style_pmatch='/\<style\>(.*?)\<\/style\>/s';
          $script_pmatch='/\<script\>(.*?)\<\/script\>/s'; 
          $dir="arunachala/testFiles/";
          //$pregmatch1='/\<\!\-\- vars\((.*?)\) \-\-\>/s';
            $pregmatchhtml='/body/';
          if ($directory_handle = opendir($dir)) {
               while (($file_handle = readdir($directory_handle)) !== false) {
                    if (($file_handle == '.') || ($file_handle== '..'))continue;
                    $data=file_get_contents($dir.$file_handle);
                    if (!preg_match($pregmatchhtml,$data)){
                         if (!($fp = fopen('arunachala/unopened.txt', 'a'))) { 
                              fwrite($fp,  "$file_handle \n");
                              printer::alert_neg('cannot open error log file');
                              fclose($fp);
                              continue;
                              }
                         else {
                              fwrite($fp,  "$file_handle \n");
                              fclose($fp);
                              printer::alert_neg('file: '.$dir.$file_handle.' No Body');                 
                              continue;
                              }
                                            
                            
                         continue;
                         }
                     if (preg_match($html_pmatch,$data)){ 
                         preg_match($pregmatch1,$data,$matches);
                         if (!array_key_exists(1,$matches)){
                              echo NL."No match continue: $file_handle" ;
                              process_data::write_to_file('arunachala/noDivMatch.txt',"$file_handle no match1 \n",false,false);
                              continue;
                              }
                         $divMatch = $matches[1]; 
                         echo NL.NL.NL."divs are $divMatch and file is :$file_handle";
                           process_data::write_to_file('arunachala/noDivMatch.txt',"$file_handle no initial match \n",false,false);
                            printer::alert_pos('file: '.$file_handle.'   Found');
                         }
                    else {
                         process_data::write_to_file('arunachala/created.txt',"$file_handle \n",false,false);
                         printer::alert_pos('file: '.$file_handle.'   Found');
                        }
                           
                    }//end while
               }//if dir
          }//end construct
     }//end class  
     
?>