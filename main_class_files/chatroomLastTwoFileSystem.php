<?php
#ExpressEdit 2.0
class chatroom extends site_master {
function check_date($file,$exit=true){//pass file_append
     
     if (!is_file($file)){
          file_put_contents($file,'');
          $_SESSION['filemtime']=filemtime($file);
          $_SESSION['lastpost']='';
          mail::mininfo('msgfr1:'.$_SESSION['chatexten'],'New Message Alert');
          ($exit)&&exit('no file');
          }
     process_data::write_to_file($_SESSION['chatexten'],'before '.$_SESSION['lastpost']);
     if (!isset($_SESSION['filemtime'],$_SESSION['lastpost'])){
          $_SESSION['filemtime']=filemtime($file);
          $_SESSION['lastpost']=file_get_contents($file);
          mail::mininfo('msgfr2:'.$_SESSION['chatexten'],'New Message Alert');
          return 'nosess';
          }
     if ($_SESSION['filemtime']!=filemtime($file)||$_SESSION['lastpost']!=file_get_contents($file)){
          $_SESSION['lastpost']=file_get_contents($file); 
          $_SESSION['filemtime']=filemtime($file);
          process_data::write_to_file($_SESSION['chatexten'],'after '.$_SESSION['lastpost']);
          return 'ftupdeat';
          }
     ($exit)&&exit('matching');
     }
function gettotaldelay($time)
{

    $time = time() - $time; // to get the time since that moment
    $time = ($time<1)? 1 : $time;
    $tokens = array (
        31536000 => 'year',
        2592000 => 'month',
        604800 => 'week',
        86400 => 'day',
        3600 => 'hour',
        60 => 'minute',
        1 => 'second'
    );

    foreach ($tokens as $unit => $text) {
        if ($time < $unit) continue;
        $numberOfUnits = round(($time / $unit),1);
        return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
    }

}
function __construct(){

     $urlbase=(Sys::Web)?'https://www.ekarasa.com/chatroom.php?':'chatroom.php?';
     $filebase="mychat_";
     $sessdir='chatroom_sessions/';
     if (isset($_POST['submit'])&&$_POST['submit']==='Clear Channel'){  
          $ext=''; 
          $_SESSION['chatexten']='';
          }
     if (isset($_POST['submit'])&&$_POST['submit']==='Clear All All'){
          $op=" rm -r $sessdir";
          exec($op);
          exec("rm mychat*.php*");
          exec("rm statusfile_*");
          unlink('monitor_array');
          
          }
         
          
     if (isset($_GET['update_msgA'],$_GET['update_fileA'],$_GET['chat_idA'],$_GET['sess_idA'],$_GET['partner_id'])){
          $ext=$_GET['update_fileA'];
          $storageSess=$_GET['sess_idA'];
          $storagePartner=$_GET['partner_id'];
          $json_arr=array();
          $value=$_GET['update_msgA'];
          $filebase="mychat_";
          $file=$filebase.$_GET['update_fileA'].'.php';
          // $statusfile='statusfile_'.$_GET['update_fileA'];
          $text=printer::printx('<p style="color:#'.$_SESSION['color'].'; background:#'.$_SESSION['background'].'; font-family: Helvitica,Arial; font-size: 23px; font-weight:800px;line-height:150%;padding:5px;">'.$value.'</p>',1);  
          if (!is_file($file)){
               mail::mininfo('msgfr4:'.$_GET['update_fileA'],'New Message Alert');
               file_put_contents($file,$text);
               process_data::write_to_file('includes/mychats.php','channel:'.$_GET['update_fileA'].'  '.$text,false,true);
               }
          else {
               process_data::write_to_file($file,$text,false,false); 
               process_data::write_to_file('includes/mychats.php','channel:'.$_GET['update_fileA'].'  '.$text,false,true);
               }
         /*
          if (!isset($_SESSON['partnersessid'])){
               $files = glob($sessdir . 'sess_*');
               foreach ($files as $file) {      
                    $data=file_get_contents($file);
                    $jval=decode_session::unserialize($data); 
                    if (array_key_exists('mysessid',$jval)){
                         if ($jval['mysessid']!=$_SESSION['mysessid']){
                              $_SESSION['partnersessid']=$jval['mysessid']; 
                              }
                         }
                    }
               }
          if(isset($_SESSON['partnersessid'])){
               $file_append=$filebase.$_GET['update_fileA'].'_'.$_SESSION['partnersessid'].'_append.php';
               if (is_file($file_append)){
                    process_data::write_to_file($file_append,$text,false,false);  
                    }
               else {
                    file_put_contents($file_append,$text); 
                    }
               }*/
         
          if (empty($storagePartner)||empty($storageSess)){
               $exfile='exchange_'.$ext;
               $mykey=$oneKey='';
               if (!is_file('exchange_'.$ext)){
                    $mykey=process_data::create_token(8);
                    file_put_contents($exfile,serialize(array($mykey)));
                    }
               else { 
                    $array=unserialize(file_get_contents($exfile));
                    $count=count($array);
                    if ($count<2){
                         if ($count<1){
                              $mykey=process_data::create_token(8);
                              file_put_contents($exfile,serialize(array($mykey)));
                              $json_arr[]=passfunct2;    
                              $json_arr[]='createSess';
                              $json_arr[]="mysessid@xax@$mykey";
                              }
                         else { //count=1
                              $oneKey=$array[0];
                              if ($oneKey!==$storageSess){//potential error...
                                   $json_arr[]='passfunct2';
                                   $json_arr[]='append';
                                   $json_arr[]="erroneous key count1  auto refreshed lets see";
                                   $mykey=process_data::create_token(8);
                                   file_put_contents($exfile,serialize(array($mykey)));
                                   } 
                               
                                   
                              }
                         
                         }
                    else {//partner key now available create sessionStorage and  create file..
                         $array=unserialize(file_get_contents($exfile));
                         if (count($array)>2){
                              $json_arr[]='passfunct2';
                              $json_arr[]='append';
                              $json_arr[]="erroneous extra keys auto refreshed lets see ".implode(',',$array);
                              $mykey=process_data::create_token(8);
                              file_put_contents($exfile,serialize(array($mykey)));
                              }
                         else {
                              //partner key available
                              if (!in_array($storageSess,$array)||$array(1)===$array(0)){
                                   $json_arr[]='passfunct2';
                                   $json_arr[]='append';
                                   $json_arr[]="erroneous key collection auto refreshed lets see ".implode(',',$array);
                                   $mykey=process_data::create_token(8);
                                   file_put_contents($exfile,serialize(array($mykey)));
                                   }
                              else {
                                   #need to get mykey then write to append file new data
                                   $storagePartner=($array[0]===$storageSess)?$array[1]:$array[0];
                                   $file_append=$filebase.$ext.'_'.$storagePartner.'_append.php';
                                   if (is_file($file_append)){
                                        process_data::write_to_file($file_append,$text,false,false);  
                                        }
                                   else {
                                        file_put_contents($file_append,$text); 
                                        }
                                   $json_arr[]=passfunct2;    
                                   $json_arr[]='createSess';
                                   $json_arr[]="partnerid@xax@$mykey";
                                   }
                              }
                         }
                    }
               }
          else if(!empty($storagePartner)){
               $file_append=$filebase.$_GET['update_fileA'].'_'.$storagePartner.'_append.php';
               if (is_file($file_append)){
                    process_data::write_to_file($file_append,$text,false,false);  
                    }
               else {
                    file_put_contents($file_append,$text); 
                    }
               }
          $json_arr[]='passfunct2';
          $json_arr[]='chatted';//rings bell
          $json_arr[]='';
          $json_arr[]='passfunct2';
          $json_arr[]='append';
          $json_arr[]=" $text@xax@mychat";
          //$json_arr[]=$_GET['chat_id']; 
          //$json_arr[]=file_get_contents($_GET['update_file']);
          //$date=self::check_date($file,false);//update session only
          echo json_encode($json_arr); 
          exit(); 
          }   
     elseif (isset($_GET['update_monitor'])){
          if (is_file('monitor_array')){
               $ma=unserialize(file_get_contents('monitor_array')); 
               }
          else exit('nomon'); 
          arsort($ma);
          $bell=false;
          $count=count($ma);
          if (!isset($_SESSION['monitor'])|| $_SESSION['monitor']!==$count){
               $_SESSION['monitor']=$count;
               $bell=true;
               }
           
          $collect='';
          foreach ($ma as $channel => $val){
                $display=(!empty($channel))?'<a target="_blank" href="'.$urlbase.$channel.'">'.$channel.'</a>':'<a target="_blank" href="'.$urlbase.'">base</a>';
               $collect.='<p class="monitor">Channel: '.$display.' Status: '.self::gettotaldelay($val).'</p>';
               }
          $json_arr=array();
          if ($bell){
               $json_arr[]='passfunct2';
               $json_arr[]='chatted';//rings bell
               $json_arr[]='';
               }
          $json_arr[]="mychat";
          $json_arr[]=$collect; 
          echo json_encode($json_arr); 
          exit();      
           
     $files = glob($sessdir . 'sess_*'); 
          $display='channels in use: ';
          $current='';
          foreach ($files as $file) {
               $data=file_get_contents($file);
               $jval=decode_session::unserialize($data);
               if (!array_key_exists('chatexten',$jval))$jval['chatexten']='unkown';
               $current.=$jval['chatexten'].',';
               $display.=(!empty($jval['chatexten']))?NL.'<a target="_blank" href="'.$urlbase.$jval['chatexten'].'">'.$jval['chatexten'].'</a>':NL.'<a target="_blank" href="'.$urlbase.'">base</a>';
               }
          
          
          $json_arr=array();    
          $json_arr[]='passfunct2';
          $json_arr[]='chatted';//rings bell
          $json_arr[]=''; 
          $json_arr[]=$_GET['chat_id'];
          $json_arr[]=$display;
          //$json_arr[]=$_GET['chat_id']; 
          //$json_arr[]=file_get_contents($_GET['update_file']);
         // self::check_date($file);//update session only
          echo json_encode($json_arr); 
          exit(); 
          }
     elseif (isset($_GET['update_fileC'],$_GET['chat_idC'],$_GET['sess_idC'],$_GET['partner_id'])){
          if (empty($_GET['partner_id']))exit('nopartner');
          $filebase="mychat_";
          $file_append=$filebase.$_GET['update_fileC'].'_'.$_GET['partner_id'].'_append.php'; 
          if (!is_file($file_append))exit('nofil');
          if (is_file($file_append)){
               $data=file_get_contents($file_append);
               }
          if (empty($data))exit('empty');
          file_put_contents($file_append,'');
          $json_arr=array();    
          $json_arr[]='passfunct2';
          $json_arr[]='chatted';//rings bell
          $json_arr[]='';
          $json_arr[]='passfunct2';
          $json_arr[]='append'; 
          $json_arr[]=''.$data."@xax@mychat"; 
          echo json_encode($json_arr); 
          exit(); 
          }
    elseif (isset($_GET['update_file'],$_GET['passtime'])){
          if (is_file('monitor_array')){
               $ma=unserialize(file_get_contents('monitor_array'));
               $ma[$_GET['update_file']]=time();
               }
          else {
               $ma=array();
               $ma[$_GET['update_file']]=time();
               }
          file_put_contents('monitor_array',serialize($ma));
          exit('upmon');     
          }
    elseif (isset($_GET['update_file'],$_GET['mchat_id'])){
          
          process_data::write_to_file('testwritetofile',printer::return_array(array($_SESSION['sess_id'],$_GET['sess_id'])));
          exit('missedboat');
          }  
            
     if (!empty($_SERVER["QUERY_STRING"])&&!isset($_GET['update_file'])&&!isset($_GET['chat_id'])&&!isset($_GET['submit'])&&!isset($_GET['Delete chat'])){
          $ext=$_SERVER['QUERY_STRING'];
          }
     else $ext='';
     $_SESSION['chatexten']=$ext;//for the monitor
     $filebase="mychat_";
     $file=$filebase.$ext.'.php';
     $sessFile='sessFile'.$ext;
    // if (!is_file($sessFile))file_put_contents($sessFile,$sessGen);
    // else {
       //   $array = explode("\n",trim(file_get_contents('file.txt')));
          
      if (is_file($file)){ 
          $current=file_get_contents($file); 
          }
      else
     $current='';
     $files = glob($sessdir . 'sess_*');
     if ($ext==='mymonitor'){
          $display='channels in use: '; 
          foreach ($files as $file) {      
               $data=file_get_contents($file);
               $jval=decode_session::unserialize($data);
               if (!array_key_exists('chatexten',$jval))$jval['chatexten']='unkown';
                $display.=(!empty($jval['chatexten']))?NL.'<a target="_blank" href="'.$urlbase.$jval['chatexten'].'">'.$jval['chatexten'].'</a>':NL.'<a target="_blank" href="'.$urlbase.'">base</a>';
               }
          $current=$display;
          }
     $exfile='exchange_'.$ext;
     $key1=$key2=$tempKey=$mykey=$oneKey='';
     if (!is_file($exfile)){
          $mykey=process_data::create_token(8);
          file_put_contents($exfile,serialize(array($mykey)));
          }
     else {
          $array=unserialize(file_get_contents($exfile));
          $count=count($array);
          if ($count<2){
               if ($count<1){
                    $mykey=process_data::create_token(8);
                    file_put_contents($exfile,serialize(array($mykey)));
                    }
               else {
                    $oneKey=$array[0];
                    $tempKey=process_data::create_token(8);//like mykey if not sessid exists
                    }
               }
          else {//two keys exists
               $key1=$array[0];
               $key2=$array[1];
               }
          }
      
     if (!empty($mykey)){
          $sessstore="sessionStorage.mysessid='$mykey';
          sessionStorage.partnertid='';";
          }
     elseif(!empty($oneKey)){
          $sessstore="
     if (sessionStorage.mysessid !== '$oneKey'){  
          sessionStorage.mysessid='$tempKey';
          sessionStorage.partnerid='$oneKey';
          }
     else sessionStorage.partnerid='';";
          }
     else {//two keys
          if (sessionStorage.mysessid !== '$key1'&&sessionStorage.mysessid !=='$key2'){
               alert ('My sess mismatch with keys Manually delete Chat exchange');
               }
          if (sessionStorage.partnerid !== '$key1'&&sessionStorage.partnerid !=='$key2'){
               alert ('My sess mismatch with keys Manually Delete Chat exchange');
               }
          if (sessionStorage.partnerid !== '$key1'&&sessionStorage.partnerid !=='$key2'){
               alert ('My sess mismatch with keys Manually Delete Chat exchange');
               }
          }
     
     
          
          echo ' <!DOCTYPE html>
<html lang="en"><head>
<script>
     if (sessionStorage.partnerid=="undefined"||sessionStorage.partnerid==null)
          sessionStorage.partnerid=""; alert(sessionStorage.partnerid+ " is id")
     sessionStorage.time="'.time().'";
     sessionStorage.fname="'.$ext.'";
     '.$sessstore.'
     alert(sessionStorage.mysessid);
     debug=false;
        
window.addEventListener("load",
     function(){
      obj="bell mysubmit slide showvol slider".split(" ");
    for (i=0;i<obj.length; i++){  
      window[obj[i]+"obj"] = document.getElementById(obj[i]);
      }
     slideobj.addEventListener( \'change\', function () {
          volumex(bell,\'chosen\',slideobj.value)
      });
     mysubmitobj.focus();';
     
     if ($ext==='mymonitor') 
          echo '
     setInterval( function() { 
gen_Proc.use_ajax(\''.Sys::Self.'?&update_monitor\',\'handle_replace\',\'get\');
} ,10000); ';
     else echo '
     setInterval( function() { 
gen_Proc.use_ajax(\''.Sys::Self.'?sess_id=\'+sessionStorage.mysessid+\'&update_file=\'+sessionStorage.fname+\'&passtime=mychat\',\'handle_replace\',\'get\');
} ,10000); 
     setInterval( function() { 
gen_Proc.use_ajax(\''.Sys::Self.'?partner_id=\'+sessionStorage.partnerid+\'&sess_idC=\'+sessionStorage.mysessid+\'&update_fileC=\'+sessionStorage.fname+\'&chat_idC=mychat\',\'handle_replace\',\'get\');
} ,2000); ';
echo '
var o=document.getElementById("mymessage");
o.addEventListener("keydown", function (e) {
    if (e.keyCode === 13) {
        validate(o);
    }
});          

 }); 
function validate(obj) {
     var currentTime = new Date();
     var hours = currentTime.getHours();
     var minutes = currentTime.getMinutes();
     if (minutes < 10) {
         minutes = "0" + minutes;
          }

     var time = hours + ":" + minutes;
     updatemsg=obj.value;
     sessionStorage.updatemsg=updatemsg;
     console.log(sessionStorage);
     gen_Proc.use_ajax(\''.Sys::Self.'?partner_id=\'+sessionStorage.partner_id+\'&sess_idA=\'+sessionStorage.mysessid+\'&update_fileA=\'+sessionStorage.fname+\'&update_msgA=\'+updatemsg+\'&chat_idA=mychat&time=\'+time,\'handle_replace\',\'get\');
     obj.value="";
     }    
function volumex(audioobj,slideId,slideAmount){
   (debug===true)&&console.log(\'volumex\');
   var display = document.getElementById(slideId);
   //show the amount
   
   bellobj.volume=slideAmount/100; 
   slideAmount=(slideAmount > 99 )  ?"":((slideAmount > 10) ?  slideAmount+"": slideAmount+".00"); 
   display.innerHTML=slideAmount;
}

function createSess(mydata){
     var data=mydata.split("@xax@");
     sessionStorage.setItem(data[0], data[1]); 
     }
 function chatted(){ 
   var bellobj = document.getElementById(\'bell\');
   bellobj.src="himalayashort.mp3" 
   bellobj.volume=1; 
   bellobj.play();
   }
function append(mydata){ 
     var data=mydata.split("@xax@"); 
     document.getElementById(data[1]).innerHTML +=data[0];
     }
</script>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="keywords" content="">
<meta name="description" content="">

<link rel="shortcut icon" href="http://htdocs/karma.ico">
   <title> chat</title>
	<link href="styling/contact.css" rel="stylesheet" type="text/css"><link href="styling/gen_page.css" rel="stylesheet" type="text/css">
	    
			<link href="styling/about.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="scripts/jscolor.js"></script>		     
<script type="text/javascript" src="scripts/docReady.js"></script>  
<script type="text/javascript" src="scripts/indexpagescripts.js"></script>	 
<style type="text/css">
a:link,a:visited{text-decoration:underline; color:blue;}
</style>
    </head><body class="contact">

<div class="about_post_id18" style="max-width:1005px; text-align:center;"><!--Begin Primary Column#2-->
';

 
printer::pclear(60);  
if (!isset($_SESSION['color']))$_SESSION['color']='ffffff';
if (!isset($_SESSION['background']))$_SESSION['background']='800000'; 
if (isset($_POST['background']))$_SESSION['background']=$_POST['background'];
if (isset($_POST['color']))$_SESSION['color']=$_POST['color'];            
if (isset($_POST['submit'])&&$_POST['submit']=='Delete chat'){
     $filebase="mychat_";
     $file=$filebase.$ext.'.php';
     if (is_file($file)) 
          unlink($file); 
     $file_append=$filebase.$ext.'*_append.php';
     $op=" rm $file_append";
     exec($op);
     //$op=" rm -r $sessdir";
    // exec($op);
     $exfile='exchange_'.$ext;
     if (is_file($exfile)) 
          unlink($exfile);
     $current=''; 
     }
     
     printer::vert_print($_SESSION);
     $submitvalue=($ext==='mymonitor')?'Clear All All':'Clear Channel';
     printer::printx('<p style="background:blue; color:white; float:left;">Channel: '.$ext.'</p>');
     printer::pclear();
     echo ' <form action="/chatroom.php" method="post">
	 <div id="mychat">'.$current.'</div>
   <audio id="bell">
      HTML5 audio not supported
    </audio>    
<p style="clear:both;display:block; height:1px;"></p><!-- class="ht0"-->
<p class="form_message floatleft"><br></p><textarea  style="background:inherit;color:inherit;width:98%; float:left;" class=" scrollit  fs1navy" id="mymessage" name="mymessage"  rows="3" onkeyup="gen_Proc.autoGrowFieldScroll(this)"></textarea><br>
 <br><br><br></form>

<div id="slider"> <input id="slide" style="width:256px;" type="range" min="0" max="100"  value="100" /> <p id="chosen">100</p>
</div>

 <form action="/chatroom.php" method="post">
     <div class="maxwidth400 marginauto left" >
	 #<input   class="jscolor {refine:false}"   name="color"  value="'.$_SESSION['color'].'"
		size="6" maxlength="6"  >Enter chat text color<br><br><br>
     #<input   class="jscolor {refine:false}"   name="background"  value="'.$_SESSION['background'].'"
		size="6" maxlength="6"  >Enter chat background  color<br>     
<p style="clear:both;display:block; height:30px;"></p>
</div>
		 <p><input name="sess_token" value="49421c728ec4d9796b876dc12df33524" type="hidden"></p>
           <p><input id="mysubmit" name="submit" value="Colors" type="submit"></p><br>
		<p><input name="xmailsubmitted" value="TRUE" type="hidden"></p> 
		</form>
         <form action="/chatroom.php" method="post"> 
 <input name="submit" type="submit" value="'.$submitvalue.'">
 </form>
         <form action="/chatroom.php" method="post"><br> 
          <p><input id="delete" name="submit" value="Delete chat" type="submit"></p>
          </form> 
           </div> 
           
 </body ></html>';
 printer::pspace(100);
     }
}

 
class decode_session {// Frits dot vanCampen at moxio dot com ¶
    public static function unserialize($session_data) {
        $method = ini_get("session.serialize_handler");
        switch ($method) {
            case "php":
                return self::unserialize_php($session_data);
                break;
            case "php_binary":
                return self::unserialize_phpbinary($session_data);
                break;
            default:
                throw new Exception("Unsupported session.serialize_handler: " . $method . ". Supported: php, php_binary");
        }
    }

    private static function unserialize_php($session_data) {
        $return_data = array();
        $offset = 0;
        while ($offset < strlen($session_data)) {
            if (!strstr(substr($session_data, $offset), "|")) {
                throw new Exception("invalid data, remaining: " . substr($session_data, $offset));
            }
            $pos = strpos($session_data, "|", $offset);
            $num = $pos - $offset;
            $varname = substr($session_data, $offset, $num);
            $offset += $num + 1;
            $data = unserialize(substr($session_data, $offset));
            $return_data[$varname] = $data;
            $offset += strlen(serialize($data));
        }
        return $return_data;
    }

    private static function unserialize_phpbinary($session_data) {
        $return_data = array();
        $offset = 0;
        while ($offset < strlen($session_data)) {
            $num = ord($session_data[$offset]);
            $offset += 1;
            $varname = substr($session_data, $offset, $num);
            $offset += $num;
            $data = unserialize(substr($session_data, $offset));
            $return_data[$varname] = $data;
            $offset += strlen(serialize($data));
        }
        return $return_data;
    }
}     
?>
