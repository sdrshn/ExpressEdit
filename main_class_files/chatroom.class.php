<?php
#ExpressEdit 2.0
class chatroom extends site_master {
     private $inc=0;
     private $monitor_default_gong=90;
     private $chat_default_gong=10;
     private $chatcolor='f6c9f0,ccc9f0,cad7f0,c9e8f0,c9f0e3,d5f0c9,e6f0c5,f0e6c2,f0d5c1';
     
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
     $sessdir='chatroom_sessions/'; 
     $urlbase=(Sys::Web)?'https://www.ekarasa.com/chatroom.php?':'chatroom.php?';
     $filebase="mychat_"; 
     $ext=(isset($_SESSION['chatexten']))?$_SESSION['chatexten']:'';
     $file=$filebase.$ext.'.php';
     $flag=false;
     foreach(array('mymonitor','update_monitor','my_id','sess_override','ptimeC','update_fileC','chat_id','mychat') as $check){
          if(strpos($_SERVER['QUERY_STRING'],$check)!==false){
               $flag=true; 
               break;
               }
          }
     if (!$flag&&(!isset($_SESSION['chatexten'])||(!empty($_SERVER['QUERY_STRING'])&&!empty($_SESSION['chatexten'])&&strpos($_SERVER['QUERY_STRING'],$_SESSION['chatexten'])===false))){ 
          mail::mininfo('entry:'.$_SERVER['QUERY_STRING'],'Initial Entry Alert');
          } 
     if (!isset($_SESSION['color']))$_SESSION['color']='838B9E';
     if (isset($_GET['update_msgA'],$_GET['update_fileA'],$_GET['chat_idA'],$_GET['my_idA'])){
          if (empty($_GET['update_msgA']))return;
          $time=$_GET['ptimeA'];
          $ut=explode(' ',$_GET['utctimeA'])[4];
          $utctime=substr($ut,0,6).'GMT';
          $ext=$_GET['update_fileA'];
          $json_arr=array();
          $inc=$_GET['my_idA'];
          $value=$_GET['update_msgA'];
          $filebase="mychat_";
          $file=$filebase.$_GET['update_fileA'].'.php';
          // $statusfile='statusfile_'.$_GET['update_fileA'];
          $text=printer::printx('<div class="wrap"><p class="posted" style="color:#'.$_SESSION['color'].'; background:#'.$_SESSION['background'].'; ">'.$value.'</p><p class="posttime" style="background:#'.$_SESSION['background'].'; "><span class="timeC">'.$utctime.' </span><span class="timeA">'.$time.'</span></p></div>',1);  
          if (!is_file($file)){
               $array=array();
               mail::mininfo('channel:'.$_GET['update_fileA']."\n".' msg:'.$value,'New Chat Alert_min');
               file_put_contents($file,json_encode(array($text)));
               process_data::write_to_file('includes/mychats.php','channel:'.$_GET['update_fileA'].'  '.$text,false,true);
               }
          else {
               $datarray=json_decode(file_get_contents($file));
               $datarray[]=$text; 
               $count=count($datarray);
               file_put_contents($file,json_encode($datarray));
               process_data::write_to_file('includes/mychats.php','channel:'.$_GET['update_fileA'].'  '.$text,false,true);   
               }
          #now update the monitor
          if (is_file('monitor_array')){
               $ma=unserialize(file_get_contents('monitor_array'));
               $ma[$_GET['update_fileA']]=time();
               }
          else {
               $ma=array();
               $ma[$_GET['update_fileA']]=time();
               }
          file_put_contents('monitor_array',serialize($ma));
          exit('upmon'); 
          # we bypass and due in interval checking instead
          $json_arr[]='passfunct2';
          $json_arr[]='createSess';//rings bell
          $json_arr[]="my_id@xax@$inc";
          $json_arr[]='passfunct2';
          $json_arr[]='chatted';//rings bell
          $json_arr[]='';
          $json_arr[]='passfunct2';
          $json_arr[]='append';
          $json_arr[]=" $text@xax@mychat";
          echo json_encode($json_arr); 
          exit(); 
          }   
     elseif (isset($_GET['update_monitor'],$_GET['my_id'])){
          $count=0; 
          $icount=$_GET['my_id'];
          $json_arr=array();
          if (is_file('monitor_array')){
               $ma=unserialize(file_get_contents('monitor_array')); 
               arsort($ma);
               $bell=false;
               $count=count($ma); 
               $collect='';
               foreach ($ma as $channel => $val){
                    $display=(!empty($channel))?'<a target="_blank" href="'.$urlbase.$channel.'">'.$channel.'</a>':'<a target="_blank" href="'.$urlbase.'">base</a>';
                    $collect.='<p class="monitor">Channel: '.$display.' Status: '.self::gettotaldelay($val).'</p>';
                    }
               if ($icount < $count){
                    $json_arr[]='passfunct2';
                    $json_arr[]='chatted';//rings bell
                    $json_arr[]='';
                    }
               $json_arr[]="mychat";
               $json_arr[]=$collect;
               }
          $json_arr[]='passfunct2';
          $json_arr[]='createSess'; 
          $json_arr[]="my_id@xax@$count";
          echo json_encode($json_arr); 
          exit(); 
          }
     elseif (isset($_GET['update_fileC'],$_GET['chat_idC'],$_GET['my_idC'])){
          $filebase="mychat_";
          $inc=$_GET['my_idC'];
          $file=$filebase.$_GET['update_fileC'].'.php';
          if (!is_file($file)){
               exit('nofil:'.$file);
               }
          else {
               $datarray=json_decode(file_get_contents($file));
               $count=count($datarray);   $echo="count is $count and ".$inc." is self inc";
               if (empty($count)&&empty($inc))exit('empty2');
               else if ($inc > $count){//for example conversation deleted in diff browser  reprint conversation by deleted whats in browser and setting inc to 0
                    $json_arr=array();
                    $json_arr[]='passfunct2';
                    $json_arr[]='replaceMychat';
                    $json_arr[]='';
                    $json_arr[]='passfunct2';
                    $json_arr[]='createSess';
                    $json_arr[]="my_id@xax@0";
                    echo json_encode($json_arr); 
                    exit();
                    }
               else if ($count==$inc)exit('uptodate'); 
               array_splice($datarray,0,$inc);//take the remainder from inc to end...
               $data=implode("\n",$datarray); ;
               $inc=$count;
               $echo.=NL ."now inc is ".$inc;
               $json_arr=array();
               $json_arr[]='passfunct2';
               $json_arr[]='createSess';
               $json_arr[]="my_id@xax@$inc";
               $json_arr[]='passfunct2';
               $json_arr[]='chatted';//rings bell
               $json_arr[]='';
               $json_arr[]='passfunct2';
               $json_arr[]='append'; 
               $json_arr[]= $data ."@xax@mychat"; 
               echo json_encode($json_arr); 
               exit();
               }
          }
   
     elseif (isset($_GET['colorchange'])){
          $_SESSION['color']=$_GET['colorchange'];
          exit();
          }
     elseif (isset($_GET['backgroundchange'])){
          $_SESSION['background']=$_GET['backgroundchange'];
          exit();
          }
     elseif (isset($_GET['resetMonitor'])){
          if (is_file('monitor_array'))unlink('monitor_array');
          $json_arr=array(); 
               $json_arr[]='mychat'; 
               $json_arr[]= "";
          echo json_encode($json_arr); 
          exit();
          }        
    elseif (isset($_GET['update_file'],$_GET['mchat_id'])){
          
          process_data::write_to_file('testwritetofile',printer::return_array(array($_SESSION['sess_id'],$_GET['sess_id'])));
          exit('missedboat');
          }  
     #Note here we are done with AJAX and moving onto normal webpage editing
     #Note we have moved away from using SESSIONS except for monitor extensions
     
     $clear='';
     if (isset($_POST['submit'])&&$_POST['submit']=='Clear Channel'){  
          $ext=''; 
          $_SESSION['chatexten']='';
          }
     elseif (isset($_POST['submit'])&&$_POST['submit']=='Clear All All'){
          exec("rm mychat*.php*"); 
          if (is_file('monitor_array'))unlink('monitor_array');
          $clear='';//"sessionStorage.clear();";
          $current='';
          $count=0;
          $ext='mymonitor';
          }
     
     else if (isset($_POST['submit'])&&$_POST['submit']=='Delete chat'){
          if(!isset($_POST['myext']))exit('delete ext file missing');
          $ext=$_POST['myext'];
         
          $clear="sessionStorage.clear();";
          $filebase="mychat_";
          $file=$filebase.$ext.'.php';
          if (is_file($file)) 
               unlink($file);
               
          $current='';
          $count=0;
          }     
  
     elseif ( !isset($_GET['update_file'])&&!isset($_GET['chat_id'])&&!isset($_POST['submit'])){
          $col_arr=explode(',',$this->chatcolor);
          $cnum=count($col_arr)-1;
          $num=mt_rand(0,$cnum); 
          $_SESSION['background']=$col_arr[$num];
          if (!empty($_SERVER["QUERY_STRING"])){
               $replacement='_';
               $ext=rtrim($_SERVER['QUERY_STRING']);
               $ext=preg_replace('/[^a-zA-Z0-9_.]/', $replacement,str_replace('%20',$replacement,strtolower($ext)));
               }
          else $ext='';
          }
     $_SESSION['chatexten']=$ext;//for the monitor
     $title=($ext=='mymonitor')?'Monitor':'Chat';
     if ($ext==='mymonitor'){
          $current=''; $count=0;
          if (is_file('monitor_array')){
               $ma=unserialize(file_get_contents('monitor_array')); 
               arsort($ma);  
               foreach ($ma as $channel => $val){
                    $display=(!empty($channel))?'<a target="_blank" href="'.$urlbase.$channel.'">'.$channel.'</a>':'<a target="_blank" href="'.$urlbase.'">base</a>';
                    $current.='<p class="monitor">Channel: '.$display.' Status: '.self::gettotaldelay($val).'</p>';
                    } 
               }
          
           
          }
     else { 
          $filebase="mychat_";
          $file=$filebase.$ext.'.php'; 
     
          if (is_file($file)){
               $array=json_decode(file_get_contents($file));
               $count=count($array);//count will set initial
               $current=implode("\n",$array); 
               }
           else {
               $current='';
               $count=0;
               }
          }
   
     
          echo ' <!DOCTYPE html>
<html lang="en"><head>
<script>
     '.$clear.'
     if (sessionStorage.my_id=="undefined"||sessionStorage.my_id==null)
          sessionStorage.my_id=0;  
     sessionStorage.time="'.time().'";
     sessionStorage.fname="'.$ext.'";
     debug=false;
     sessionStorage.setItem("my_id",'.$count.');//sets initial chat array count   
window.addEventListener("load",
     function(){
          obj="bell mysubmit slide showvol slider color background".split(" ");
          for (i=0;i<obj.length; i++){  
               window[obj[i]+"obj"] = document.getElementById(obj[i]);
               }
          
          slideobj.addEventListener( \'change\', function () { 
               volumex(bell,\'chosen\',slideobj.value)
               });
          mysubmitobj.focus();';
     
          if ($ext==='mymonitor') 
               echo '
          volumex(bell,\'chosen\',50)      
          setInterval( function() { 
               gen_Proc.use_ajax(\''.Sys::Self.'?&update_monitor&my_id=\'+sessionStorage.my_id,\'handle_replace\',\'get\');
               } ,10000);
          resetMonitor.addEventListener( \'click\', function () { 
               gen_Proc.use_ajax(\''.Sys::Self.'?resetMonitor\',\'handle_replace\',\'get\');
               });  ';
          else
               echo '
          volumex(bell,\'chosen\',10) 
          colorobj.addEventListener( \'change\', function () { 
               gen_Proc.use_ajax(\''.Sys::Self.'?colorchange=\'+colorobj.value,\'handle_replace\',\'get\');
               });
          backgroundobj.addEventListener( \'change\', function () { 
               gen_Proc.use_ajax(\''.Sys::Self.'?backgroundchange=\'+backgroundobj.value,\'handle_replace\',\'get\');
               });
          setInterval( function() {
               var time = new Date();
               showtime=time.getHours() + ":" + time.getMinutes();// + ":" + time.getSeconds();
               gen_Proc.use_ajax(\''.Sys::Self.'?ptimeC=\'+showtime+\'&my_idC=\'+sessionStorage.my_id+\'&update_fileC=\'+sessionStorage.fname+\'&chat_idC=mychat\',\'handle_replace\',\'get\');
               } ,2000); ';   
          echo '
          var o=document.getElementById("mymessage");
          o.addEventListener("keydown", function (e) {
              if (e.keyCode === 13) {
                  validate(o);
              }
          });          
          
     }); //load listener
function validate(obj) {    
     var time = new Date();
     var hours = time.getHours();
     var min=time.getMinutes();
     if (min<10)
          min="0"+min;
     showtime=hours + ":" + min;// + ":" + time.getSeconds();
     utcString = (new Date(time)).toUTCString();  
     updatemsg=obj.value;
     sessionStorage.updatemsg=updatemsg;
     console.log(sessionStorage);
     gen_Proc.use_ajax(\''.Sys::Self.'?utctimeA=\'+utcString+\'&ptimeA=\'+showtime+\'&my_idA=\'+sessionStorage.my_id+\'&update_fileA=\'+sessionStorage.fname+\'&update_msgA=\'+updatemsg+\'&chat_idA=mychat&time=\'+time,\'handle_replace\',\'get\');
     obj.value="";
     }    
function volumex(audioobj,slideId,slideAmount){ 
   var display = document.getElementById(slideId);
   //show the amount
   var slideobj=document.getElementById(\'slide\');
   slideobj.value=slideAmount; 
   var bellobj = document.getElementById(\'bell\');
   bellobj.volume=slideAmount/100; 
   slideAmount=(slideAmount > 99 )  ?"":((slideAmount > 10) ?  slideAmount+"": slideAmount+".00"); 
   display.innerHTML=slideAmount;
}

function createSess(mydata){ //alert(mydata);
     var data=mydata.split("@xax@");sessionStorage.my_id=1;
     sessionStorage.setItem(data[0], data[1]); //alert(sessionStorage.my_id);
     }
 function chatted(){ 
   var bellobj = document.getElementById(\'bell\');
   bellobj.src="himalayashort.mp3" 
   bellobj.play();
   }
function replaceMychat(data){
     document.getElementById(\'mychat\').innerHTML =data;
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
<script type="text/javascript" src="scripts/docReady.js"></script>  
<script type="text/javascript" src="/scripts/jquery.min.js"></script>
 <link href="lib/css/emoji.css" rel="stylesheet">

<link rel="shortcut icon" href="http://htdocs/karma.ico">
   <title>'.$title.'</title>
	<link href="styling/contact.css" rel="stylesheet" type="text/css"><link href="styling/gen_page.css" rel="stylesheet" type="text/css">
	
<link rel="stylesheet" href="dist/emojione.picker.css">    
			<link href="styling/about.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="scripts/jscolor.js"></script> 
<script type="text/javascript" src="scripts/indexpagescripts.js"></script>
<script type="text/javascript" src="dist/emojione.picker.js"></script>


<style type="text/css">
.wrap {   }
.posted { float:left; width:93%;padding:0px;margin:0px; font-family: Helvitica,Arial; font-size: 23px; font-weight:500;line-height:175%; }
.posttime {border-bottom: 1px #e5e5e5 solid;border-top: 1px #7f7f7f solid;float:right;width:7%;height:40px;}
.timeC{width:100%;color:black;background:rgba(255,255,255,.7);font-size:8px;margin:0;padding:0px;height:20px;overflow:none;}
.timeA{width:100%;color:white;background:rgba(0,0,0,.2); font-size:12px;margin:0;padding:0px;height:20;overflow:none;}
a:link,a:visited{text-decoration:underline; color:blue;}
</style>
    </head><body class="contact">

<div class="about_col_id18" style="max-width:1005px; text-align:center;"><!--Begin Primary Column#2-->
';
 
printer::pclear(60);   
     //printer::vert_print($_SESSION);
     $submitvalue=($ext==='mymonitor')?'Clear All All':'Clear Channel';
     printer::printx('<p style="background:blue; color:white; float:left;">Channel: '.$ext.'</p>');
     printer::pclear();
     if ($ext !=="mymonitor"){
     echo ' <form action="/chatroom.php" method="post">
	 <div id="mychat">'.$current.'</div>
   <audio id="bell">
      HTML5 audio not supported
    </audio>    
<p style="clear:both;display:block; height:1px;"></p><!-- class="ht0"-->
<p class="form_message floatleft"><br></p>

<textarea   style="background:inherit;color:inherit;width:98%; float:left;" class=" scrollit  fs1navy" id="mymessage" name="mymessage"  rows="3" onkeyup="gen_Proc.autoGrowFieldScroll(this)"></textarea>
<br>
 <br><br><br></form>
<script type="text/javascript">
	$( "#mymessage" ).emojionePicker({
	pickerTop : 5,
	pickerRight : 5,
	type : "unicode",
});
</script>
<div id="slider"> <input id="slide" style="width:256px;" type="range" min="0" max="100"  value="10" /> <p id="chosen">100</p>
</div>
 <form action="/chatroom.php" method="post">
     <div class="maxwidth400 marginauto left" >
	 #<input   class="jscolor {refine:false}"  id="color" name="color"  value="'.$_SESSION['color'].'"
		size="6" maxlength="6"  >Color<br><br><br>
     #<input   class="jscolor {refine:false}"  id="background"  name="background"  value="'.$_SESSION['background'].'"
		size="6" maxlength="6"  >Background<br>     
<p style="clear:both;display:block; height:30px;"></p>
</div>
           <p  id="mysubmit"></p><br>
		<p><input name="xmailsubmitted" value="TRUE" type="hidden"></p> 
		</form> 
     
         <form action="/chatroom.php" method="post">
         <input type="hidden" name="myext" value="'.$ext.'">
 <input name="submit" type="submit" value="Delete chat">
 </form>';
     }
     else echo '
         <p id="mysubmit"></p><p id="color"></p><p id="background"></p><!--dummys--><!--mymessage-->
         <div id="mychat">'.$current.'</div>
         <audio id="bell">
      HTML5 audio not supported
    </audio>
    <div id="slider"> <input id="slide" style="width:256px;" type="range" min="0" max="100"  value="10" /> <p id="chosen">100</p>
</div>
          <form action="/chatroom.php" method="post"><br>
          <p><input id="delete" name="submit" value="'.$submitvalue.'" type="submit"></p>
          </form> 
           
         <button id="resetMonitor">Reset Monitor</button>
          </form> ';
          echo '
           </div> 
  
 </body ></html>';
     }
}//end class
?>