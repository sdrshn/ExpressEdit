<?php
#ExpressEdit 2.0
   
   $file='musicXML/debug_log_sound.html';
   if (isset($_GET['dblist'])){ 
     $load=new fullloader();
     $load->fullpath('XMLparse.class.php'); 
     // $attribute=array('Names','Artist','Album','Kind','Size','Total Time','Date Modified','Date Added','Bit Rate','Sample Rate','Normalization','Location');
      $attributeS=XMLparse::parseItunes($_GET['dblist']);//$_GET['dblist']);
      echo json_encode($attributeS) . "\n";  //send back complete list
      exit();
      }
   else if (isset($_GET['log'])){
      (!is_file($file))&&file_put_contents($file,'');
      if (!($fp = fopen($file, 'a'))) {
         $my_message.='Cannot open debug_log file';
         exit($my_message);
         }
      else {
         $my_message=$_GET['log'].'<br />';
         fwrite($fp, "$my_message");
         }
      echo 'Global Log Variables Completed';
      exit();
      }
   else if (isset($_GET['print_debug'])){
      exit('file contents of debug_log has been activated in new window');
      }
   
   else  file_put_contents($file,'<html><head> <title>debug print</title>
<style type="text/css">
.content{width: 3000px; overflow:visible;}
</style>
</head>
<body>
<div class="content">'); 
$play='';
$libarr=array();
$dir = '/media/VolH/htdocs/musicXML/';  
	if (!$directory_handle = opendir($dir))exit ('$dir is not a directory');
     $x=0; 
	while (($file_handle = readdir($directory_handle)) !== false) {
         
	    if (($file_handle == '.') || ($file_handle== '..') )continue;
	    $path_parts = pathinfo($file_handle);
         if (is_dir($file_handle))continue;
	    if ( !isset($path_parts['extension']))continue;
         if ('xml'!=$path_parts['extension'])continue;
         $x++; ($x === 6)&& $x=1;
		$library=$path_parts['filename'];
          $libarr[]=$library; 
         $play.='
<button type="button" class="button button'.$x.'" id="'.str_replace(' ','_',$library).'" onclick="get_playlist(\''.$library.'\');">
        '.$library.'
    </button>
    ';
         }
 $debug='true';
 if (isset($_POST['submitted'])&&isset($_POST['submitdata'])){
     file_put_contents('soundstore.dat',serialize($_POST['submitdata']));
     }
if (is_file('soundstore.dat')){
     $remind=file_get_contents('soundstore.dat');
     $remind=(!empty($remind))?unserialize($remind):'';
     }
else $remind='';
 if (isset($_POST['submitted'])&&isset($_POST['fsize'])){
     file_put_contents('fstore.dat',serialize($_POST['fsize']));
     }
if (is_file('fstore.dat')){
     $fsize=file_get_contents('fstore.dat');
     $stylealert=(!empty($fsize)&&unserialize($fsize)==='large')?'style="font-size:20px;color:red;"':'style="font-size:14px;color:black;"';
     }
else $stylealert='';
if (!empty($remind))
     $alert_msg='<p '.$stylealert.'>Active Msg</p>';
else $alert_msg='';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Sound Project</title>
<script type="text/javascript"  src="addEvent.js"></script>   
<script type="text/javascript">
 //<![CDATA[ 
   //playlist vars
   var debug=<?php echo $debug ?>,
   borderColorActive='#f2f4e9',
   backgroundActive='#7e9ff6',
   delaylist='Currents',
   logfile='<?php echo $file ?>',
   songmode='random',
   ajax = false,
   endTime,
   songStore=[],
   playlist='',
   liststatus='false',
   songnum=-1,
   songcount=0,
   repeatmode=false,
   dbcheck=[],
   oAudio,
   gongAudio,
   testVar,
   gongTimer=600000,
   storevol,
   gongminChosen,
   hitgongTime,
   cleargong,
   track=0,
   stopAll=false,
   loopit,
   loopit2,
   slideobj,
   clearit,
     dir,
     build,
   dblist=[],
   dir='http://hdrive.com/My Music2/',
   prevnum='';
 addEvent(window,'load',function(){ 
   bellobj = document.getElementById('bell');
   bellobj.src="http://htdocs/himalaya.mp3" //dir+"himalaya.mp3"
   bellobj.volume=.2; 
         
  
 });   
addEvent(window,'load',function(){



if (debug==true){
      var button = document.createElement('button');
      button.innerHTML = 'control panel/logs';
      button.id='print_debug';
      document.body.appendChild(button);
      button.className="debug button"
      }
(debug===true)&&console.log('addEvent.load');
   obj="gong gongClock gongslide gongminChosen gongInterval changeSlide displayclock play songTime songTimeLeft pause repeat stop changemode prev next slide songTimeLeftid slideTime playdelay showvol slider".split(" ");
   if(debug===true)obj=obj.concat('print_debug');
    for (i=0;i<obj.length; i++){  
      window[obj[i]+'obj'] = document.getElementById(obj[i]);
      }
   <?php    
   $obj2=array('gong','play','playdelay','pause','stop','changemode','prev','next','showvol');
    $obj_debug=array('print_debug');
    if($debug==true)$obj2=array_merge($obj2,$obj_debug);
     foreach ($obj2 as $obj){
      $o=$obj.'obj';
      $f=$obj.'It';
echo "
        addEvent($o,'click',$f);"; 
}
   foreach($libarr as $lib){
         $lib=str_replace(' ','_',$lib);
      echo  $lib."obj=document.getElementById('$lib');";
      }
?>
              
    oAudio = document.getElementById('oaudio');
   addEvent(slideobj, 'change', function () {
          volumex(oAudio,'chosen',slideobj.value)
      });
     gongAudio = document.getElementById('bell');
    addEvent(gongslideobj, 'change', function () {
          volumex(gongAudio,'gongchosen',gongslideobj.value)
      });
    
    addEvent(changeSlideobj, 'change', function () {
        track++
        console.log('repo'+ track);
         reposition(changeSlideobj.value);
         //changeSlideobj.value=slideTimeobj.value
          });
   
     addEvent(gongIntervalobj, 'change', function () { 
         gongTimer=gongIntervalobj.value*60*1000;   
         gongminChosenobj.innerHTML=gongIntervalobj.value ;
         gongIt();
          //gongCountdown();
          });
 
   });
function show(id,show,hide){ 
	   if(document.getElementById(id+ "t").style.display=="inline-block"){
		  document.getElementById(id+"t").style.display ="none";
		  document.getElementById(id).style.textDecoration = 'none';
		  document.getElementById(id).innerHTML=show; 
		   document.getElementById(id+"t").style.zindex=1; 
		  document.getElementById(id+"t").style.position="initial";
		  }
	   else{ 
		  document.getElementById(id+"t").style.display ="inline-block";
		   document.getElementById(id).innerHTML=hide;
		  document.getElementById(id).style.textDecoration = 'underline';
		  document.getElementById(id+"t").style.position="relative";
		  //document.getElementById(id+"t").style.zindex="100";
		  }
	   }//end js function

        
function print_debugIt(){
(debug===true)&&console.log('print_debug');
use_ajax('sound.php?print_debug','openIt','get'); 
} 
 
 
 
function setInter2(mod){
   (debug===true)&&console.log('setInter: '+mod);
   if (mod=='set') { 
      myfunct=(function looper(){ //this will run automatically 
         update(slideTimeobj.value) 
         loopit= setTimeout(looper,400)
         })() 
       } 
   if(mod=="clear"){ 
      clearTimeout(loopit) 
      }
   }
  
function update() { 
      if (isNumber(oAudio.duration)) {//audio.duration gathered only after oAudio.play      
         songTimeLeftobj.innerHTML = millisToMins(oAudio.duration-oAudio.currentTime);
         songTimeobj.innerHTML = millisToMins(oAudio.currentTime);
         if (oAudio.currentTime>1) { //prevent additonal end events
         slideTimeobj.value = (oAudio.currentTime/oAudio.duration)*100;
         }
       
      }
   }

function gongIt(){  
     clearTimeout(loopit2)
     
      myfunct=(function looper(){   //this will run automatically 
          gongobj.src="gong-hammer.gif"
          bellobj.play();
          var clearduration
          myfunctcheck=(function gonglooper(){
               var x
               if (isNumber(bell.duration)){ 
                    hitgongTime=new Date().getTime()+gongTimer//+bellobj.duration*1000;
                    gongCountdown();// this is the timer
                    var x='go';
                    }
       
               gongloopit2= setTimeout(gonglooper,100)//this func
               if (x=='go') 
                    clearTimeout(gongloopit2);//current loopit2
                })()    
                
           loopit2= setTimeout(looper,gongTime)
         })()
      }
	 
function gongCountdown(){  
   msLeft = hitgongTime - (+new Date().getTime());
   if ( msLeft < 1000 ) {
       gongClockobj.innerHTML = "Hari Om";
       clearTimeout(cleargong);
       }
    else {
      gongClockobj.innerHTML = rectime(msLeft/1000).replace('00:',''); 
      cleargong=setTimeout(gongCountdown,500);
      }
   }
   
   
function gongIt2(){  
   //  if (bellobj.paused) {  
          gongobj.src="gong-hammer.gif"
          myfunct=(function looper(){
			bellobj.play();
               var clearduration
               myfunctcheck=(function gonglooper(){  
                    if (!isNumber(bellobj.duration)){ 
                         clearduration= setTimeout(gonglooper,100)
                         }
                    else {
				    clearTimeout(clearduration)
                        hitgongTime=new Date().getTime()+gongTimer
                        gongCountdown(); 
                        }
                    })()     
               loopit2= setTimeout(looper,gongTimer)
              })()
        //  }
    // else { 
        //  gongobj.src="gong.gif"
        //  clearTimeout(loopit2)
        //  gongClockobj.innerHTML = "Hari Om";
        //  clearTimeout(cleargong)
         // }
    
     }
function repeatIt(){
      if(repeatmode===false){
         repeatmode=true;
         (debug===true)&&console.log('repeatIt mode: '+repeatmode);
         repeatobj.style.backgroundPosition="-217px 0";
         }
      else{
         repeatmode=false;
         (debug===true)&&console.log('repeatIt mode: '+repeatmode);
         repeatobj.style.backgroundPosition="-260px 0"; 
         
         }
   }
   
function reposition(value) {
      
      //(function looper3(){ //this will run automatically
            if(isNumber(oAudio.currentTime))oAudio.currentTime = value/100*oAudio.duration;
            else  console.log('audio current time error');
         // console.log('looper3');
        //if(!isNumber(oAudio.currentTime)||oAudio.currentTime>value+5||oAudio.currentTime<value-5)setTimeout(looper3,4);
        //  })();
      //  console.log('looper3end');
   }

  //if(!isNumber(oAudio.duration)||oAudio.currentTime>value+5||oAudio.currentTime<value-5)looper3();

   
function volumex(audioobj,slideId,slideAmount){
   (debug===true)&&console.log('volumex');
   var display = document.getElementById(slideId);
   //show the amount
   
   audioobj.volume=slideAmount/100; 
   slideAmount=(slideAmount > 99 )  ?'100':((slideAmount > 10) ?  slideAmount+'.0': slideAmount+'.00'); 
   display.innerHTML=slideAmount;
}

function changemodeIt(){  
   if (songmode==='random') {   
      changemodeobj.style.backgroundPosition="-300px 0";
      songmode='sequential';
      dbcheck=[];
      songnum=-1;    
      show_song()
      }
   else if (songmode=='sequential') { 
      changemodeobj.style.backgroundPosition="-341px 0"; 
      songmode='random';
      dbcheck=[];
      songnum=-1,
      songcount=0,
      show_song()
      return;
      }
   else alert('songmode problem');
   }
 
function playIt(){
   (debug===true)&&console.log('playIt');
   (debug===true)&&logIt();
   if (stopAll===true)return;  
   
   if (oAudio.paused) { //&& playlist==list
          oAudio.play();
          setInter2('set');
         // pauseplayobj.textContent = "Pause  ";
           
           
         }
      }
function pauseIt(){
       (debug===true)&&console.log('pauseIt');
      oAudio.pause();
      //pauseplayobj.textContent = "Resume"; 
     setInter2('clear');
   }
      

function prevIt(){
   (debug===true)&&console.log('prevIt');
   position=songStore.indexOf(songnum);
   if(position==0) oAudio.currentTime=0;
   else {
      songnum=songStore[position-1];
      play_it(songStore[position-1])
      }
   return; 
   }
      
function nextIt(){
   (debug===true)&&console.log('nextIt');
   count=songStore.length;
   position=songStore.indexOf(songnum);
   if(position+1==count)show_song()
   else if (position > count) alert('error: nextIt-count: '+count+ 'position: '+position);
   else {
      songnum=songStore[position+1];
      play_it(songStore[position+1])
      }
   return; 
   }
 
function stopIt (){
   (debug===true)&&console.log('stopIt');
   oAudio.pause();
  // pauseplayobj.textContent = "Ended";
   setInter2('clear');
   oAudio.src=''
   dblist=[];
   dbcheck=[];
   stopAll=true;
   songmode='random';
   songnum=-1;
   songcount=0;
   songStore=[];

   //document.body.button.style.background='';
      }
   
function showvolIt(){
(debug===true)&&console.log('show volume');
    if (sliderobj.style.display==='block'){
         sliderobj.style.display='none'
         }
   else {
      sliderobj.style.display='block';
      volumex(oAudio,'chosen',6);
      slideobj.value=6;
      }
   }
   
   function get_dblist_num(){
   (debug===true)&&console.log('get_dblist_num');
   if (songcount==dblist.length) {
      if (repeatmode===true) {
      (debug===true)&&console.log('get_dblist_num & repeatmode==true  & mode = '+songmode);
         dbcheck=[]; songcount=0;
         }
      else {
         (debug===true)&&console.log('get_dblist_num & repeatmode==false & mode = '+songmode);
         stopIt();
         }
      }
   else  (debug===true)&&console.log('songcount: ' +songcount+' &dblist.length: '+dblist.length);
   if (songmode=='sequential') { 
       if (songnum==dblist.length) {
         if (repeatmode===true) {
            (debug===true)&&console.log('get_dblist_num & seq & repeatmode==true');
            songnum=-1;
            }
         else {
            (debug===true)&&console.log('get_dblist_num & seq & repeatmode==false');
            stopIt();
            }
         }
      prevnum=songnum
      songnum++;
      prevnum=songnum-1;
      return songnum;
      }  
   var count=dblist.length;
   prevnum=songnum;
   songnum=randomIntFromInterval(0, count-1);   
   if (dbcheck[songnum]!='full')  {
      songcount++; 
      dbcheck[songnum]='full'; // console.log(dbcheck);
      }
   else {
      get_dblist_num();
      } 
   return songnum

   }

function randomIntFromInterval(min,max){
    return Math.floor(Math.random()*(max-min+1)+min);
   } 
      
function show_song() {
   (debug===true)&&console.log('show_song');
    // Check for audio element support.
   if (window.HTMLAudioElement) {
       num=get_dblist_num();
      play_it(num)
      //pauseplayobj.textContent = "Pause";
       oAudio.addEventListener('ended', show_song ,  false);
         n=1;
   // (function mfunc(){
   // var x 
     // if (isNumber(oAudio.duration)){ 
      //   slideTimeobj.max=oAudio.duration
      //   var x='go';  
       //  }
      //loopit2= setTimeout(mfunc,100)
      // if (x=='go')clearTimeout(loopit2);//current loopit2
       
     // })()    
   }
   else alert('audio element not supported in this browser');         
   }
 
function xmlReplace(inbuild) {
   (debug===true)&&console.log('xmlReplace'); 
   re= /xxslashxx/g
    build =   inbuild.replace(re,'/');
    re= /ampersandxx/g
   build =  build.replace(re,'&'); 
   re= /openbracket/g
   build =  build.replace(re,'['); 
   re= /closebracket/g
   build =  build.replace(re,']'); 
   /*roe= /opensquiggle/g
   build =  build.replace(re,'{');
   re= /closesquiggle/g
   build =  build.replace(re,'}');*/
   return build
   }
   
function play_it(num){  
   (debug===true)&&console.log('play_it');
   if(stopAll===true)return;
   console.log(num); 
      var build =   dblist[num]['Location']
      if (build=='Who Am I') {
         song=(dblist[num]['Names']!=='undefined')?'songname= '+dblist[num]['Names']:'songname: undefined';
         console.log('Who Am I@: '+song+'/'+num)
         show_song();
         }
      build=xmlReplace(build);
      storevol=oAudio.volume;
      var xx=dir.indexOf("Thomas Otten");  
      oAudio.vol= xx >= 0  ? slideobj.value/200 * .1 :  slideobj.value/100;
     console.log(dir+build);
   (debug===true)&&debug_logIt();
     if (songStore.indexOf(num) == -1) songStore.push(num);
      //alternatives creating audio object 
      //oAudio = document.createElement('audio');
      //var myAudio = new Audio(dir + build);
   //myAudio.play();Thomas Otten
   oAudio.src = dir + build; 
    oAudio.play();
     songinfo(num);
     setInter2('set');
       
//oAudio.addEventListener("canplaythrough", function(){alert('cat');oAudio.play();}, false);
  
         // window.open('http://localhost/soundNotFound.php?resource='+dir+build);
     
      }
      


function songinfo(num){//'Names','Artist','Album','Kind','Size','Total Time','Date Modified','Date Added','Bit Rate','Sample Rate','Total Time','Location')
   var songinformation=' ';
   var nameid=document.getElementById('namecolor')
   var artistid=document.getElementById('artistcolor')
   var albumid=document.getElementById('albumcolor')
   var bitrateid=document.getElementById('bitratecolor')
   var totaltimeid=document.getElementById('totaltimecolor') 
   nameid.textContent=(typeof(dblist[num].Names)!=='undefined')?'Name: '+xmlReplace(dblist[num].Names)+'   ':'Name: WhoAmI';
   artistid.textContent=(typeof(dblist[num].Artist)!=='undefined')?'Artist: '+xmlReplace(dblist[num].Artist)+'   ':'Artist: WhoAmI';
   albumid.textContent=(typeof(dblist[num].Album)!=='undefined')?'Album: '+xmlReplace(dblist[num].Album)+'   ':'Album: WhoAmI'; 
   bitrateid.textContent=(typeof(dblist[num]['Bit Rate'])!=='undefined')?'Bit Rate: '+dblist[num]['Bit Rate']+'   ':'WhatAmI'; 
   totaltimeid.textContent=(typeof(dblist[num]['Total Time'])!=='undefined')?'T.Time: '+secondstoTime(dblist[num]['Total Time']):'WhatAmI'; 
    //if (!selection.isCollapsed) .
   //if (typeof(selection) !=='undefined') 
   }

   
    
    
function get_playlist(list) {
   (debug===true)&&console.log('get_playlist');
   stopIt();
   stopAll=false;
   var  oldlist=playlist
   playlist=list;
   re= / /g;
   varobj=playlist.replace(re,'_')+'obj';  
   if(oldlist!='')oldvarobj=oldlist.replace(re,'_')+'obj';
   window[varobj].style.borderColor=borderColorActive;
   window[varobj].style.background=backgroundActive;
   if(oldlist!='')window[oldvarobj].style.background='';
   if(oldlist!='')window[oldvarobj].style.borderColor='';
   songcount=0;
   use_ajax('sound.php?dblist=' + playlist,'handle_song','get');
   
	
} // End of function.


function debug_logIt(){
   /*console.log('debug_logIt');
   console.log("songmode : "+ songmode );
   console.log(" playlist : "+ playlist );
   console.log(" songnum : "+ songnum );
   console.log(" songcount : "+ songcount );
   console.log(" repeatmode : "+ repeatmode );
   console.log(" dbcheck : "+ dbcheck );
   console.log(" stopAll : "+ stopAll );
   console.log(" loopit : "+ loopit );
   console.log(" prevnum : "+ prevnum );*/
   debug_log="\n\r";
   
   debug_log+= "songStore : "+ songStore + "\n\r" 
   debug_log+= "songmode : "+ songmode + "\n\r" 
   debug_log+= " playlist : "+ playlist + "\n\r" 
   debug_log+= " songnum : "+ songnum + "\n\r" 
   debug_log+= " songcount : "+ songcount + "\n\r" 
   debug_log+= " repeatmode : "+ repeatmode + "\n\r" 
   debug_log+= " stopAll : "+ stopAll + "\n\r" 
   debug_log+= " loopit : "+ loopit + "\n\r" 
   debug_log+= " prevnum : "+ prevnum + "\n\r"
   debug_log+= " dbcheck : "+ dbcheck + "\n\r"
   debug_log+= " filename : "+dir+build + "\n\r"
   use_ajax('sound.php?log='+ debug_log,'logIt','get');
   }

   
function openIt(){
   console.log('openit');
   if ( (ajax.readyState == 4) && (ajax.status == 200) ) {
      if (ajax.responseText.length > 10)  
		console.log('ajax response: '+ajax.responseText);
          window.open(logfile);
      }
   else { 
	    //console.log( 'JasonMistake openIt response: '+ajax.responseText);
         }   
   }
   
function logIt(){
   console.log('logit');
   if ( (ajax.readyState == 4) && (ajax.status == 200) ) {
      if (ajax.responseText.length > 10)  
		console.log('ajax response: '+ajax.responseText);
         }
   else { 
	    //console.log( 'JasonMistake logIt response: '+ajax.responseText);
         }   
   }
 
function create_ajax(){
   
   if (window.XMLHttpRequest) {
    // IE 7, Mozilla, Safari, Firefox, Opera, most browsers:
        ajax = new XMLHttpRequest();
       } 
   else if (window.ActiveXObject) { // Older IE browsers
   // Create type Msxml2.XMLHTTP, if possible:
      try {
         ajax = new ActiveXObject("Msxml2.XMLHTTP");
         }
      catch (e1) { // Create the older type instead:
         try {
            ajax = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e2) { }
         }
      }
   
   // Send an alert if the object wasn't created.
   if (!ajax) {
        alert ('Some page functionality is unavailable.');
      }
    
   }
    

function use_ajax(url,func,method){
   (debug===true)&&console.log('use_ajax url: '+url+' func: '+func);
   create_ajax();
   if (ajax) {  
      ajax.open(method, url);
      ajax.onreadystatechange = function(){
      window[func]();}
       // Send the request:
      ajax.send(null);
      return false;
      }
   
   else {
     return true;
     }
   }  
   
function handle_song() { 
   //(debug===true)&&console.log('handle song'); 
   if ( (ajax.readyState == 4) && (ajax.status == 200) ) {
      if (ajax.responseText.length > 10) { //console.log(ajax.responseText) 
         jsonitems = JSON.parse(ajax.responseText);
         dblist=jsonitems;
         console.log('Array.length: '+dblist.length)
         show_song();
         }
                     
      else { 
	    console.log( 'JasonMistake in handle');
         }
	
      }
   }

function playdelayIt(){
   (debug===true)&&console.log('playdelayIT');
   clearTimeout(clearit);
   var days=document.getElementById('days').value; 
   var hrs=document.getElementById('hours').value; 
   var min=document.getElementById('minutes').value;
   days=(isNumber(days))?days:0;
   hrs=(isNumber(hrs))?hrs:0;
   min=(isNumber(min))?min:0;
   min= +min+ +days*24*60 + +hrs*60; 
   playdelayobj.textContent = "Waiting";
   endTime=new Date().getTime()+min*60*1000;
   playdelayobj.style.borderColor='#f2f4e9';
   playdelayobj.style.background='#7e9ff6';  
   countdown();   
   }

function rectime(secs) {
   var day=Math.floor(+secs / 3600 / 24 );
   var hr = Math.floor((secs - day * 24 * 3600)  / 3600)
   var min = Math.floor((secs - day * 24 * 3600- hr * 3600)/60);
   var sec = Math.floor(secs - day * 24 * 3600- hr * 3600 - min * 60); 
   var  day=(day > 0 ) ? day + ':' : '';
   return day  + twoDigits(hr)+':'+ twoDigits(min) + ':' + twoDigits(sec);
   }

function twoDigits( n ){
      return (n <= 9 ? "0" + n : n);
      } 

function countdown(){ 
   msLeft = endTime - (+new Date().getTime());
   if ( msLeft < 1000 ) {
       displayclockobj.innerHTML = "countdown's over!";
       playdelayobj.style.borderColor='';
       playdelayobj.style.background='';
       playdelayobj.textContent = "Play Delay";
       get_playlist(delaylist);
       clearTimeout(clearit);
       }
    else {
      displayclockobj.innerHTML = rectime(msLeft/1000).replace(/00:/g,''); 
      clearit=setTimeout(countdown,500);
      }
   }

    

   
 

 

 
function millisToMins(seconds) { 
      var min= new Number();
     sec = Math.floor( seconds );    
     min = Math.floor( sec / 60 );
    min = min >= 10 ? min : '0' + min;    
    sec = Math.floor( sec % 60 );
    sec = sec >= 10 ? sec : '0' + sec;

    return min + ":"+ sec;
   }
   
function isRange(min,max,num){
   if (num>=min&&num<=max) {
      return true;
      }
   else return false;
   }
   
isNumber=function isNumber(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}

function secondstoTime(StrTime){
   StrTime=StrTime/1000;
   //var hrs = ~~(time / 3600);
   //var mins = ~~((time % 3600) / 60);
   //var secs = time % 60; 
   var minutes = Math.floor(StrTime / 60); 
   var seconds = Math.ceil(StrTime - minutes * 60); 
   
   var newtime=  (minutes>9?minutes:"0"+minutes) + ":" + (seconds>9?seconds:"0"+seconds);
   
   //var mins=Math.floor(StrTime/60);
   //var secs=StrTime-mins * 60;
   //var hrs=Math.floor(StrTime / 3600);
   //var newtime=(hrs>9?hrs:"0"+hrs) + ":" + (mins>9?mins:"0"+mins) + ":" + (secs>9?secs:"0"+secs);
   return newtime
   }
function show_id(id){  
    if(document.getElementById(id).style.display=="none"){
		  document.getElementById(id).style.display ="block";
		}   
     else  document.getElementById(id).style.display ="none";
     }
   
//]]> 
</script>
 <!--<script type="text/javascript" src="ajax.js"></script>-->
<style type="text/css">
   body{background:#dedbc3;color:#5a5107;}
</style> 
 <style type="text/css">

#namecolor,#artistcolor,#albumcolor,#bitratecolor,#totaltimecolor{
   margin-top: 20px;
    margin-bottom: 5px;
    padding: 2px 15px;
    font-size: 1.3em;
    font-weight:bold;
    display: inline;
    float: left;}
.space{padding-top: 70px;} 
#playstyle{margin: 30px 0; margin: 30px 0; padding:3px; color: #f0f;}
#namecolor{background:#96bfbb;background-image: url(musicXML/background5.jpg); background-repeat: repeat; color:#211 }
#artistcolor{background:#aa739b;background-image: url(musicXML/background4.jpg); background-repeat: repeat;color:#f22}
#albumcolor{background:#c82c1d;background-image: url(musicXML/background3.jpg); background-repeat: repeat;color:#fef}
#bitratecolor{background:#0075a0;background-image: url(musicXML/background2.jpg); background-repeat: repeat;color:#faf}
#totaltimecolor{background:#3a1622;background-image: url(musicXML/background1.jpg); background-repeat: repeat;color:#ffffff}
.button1{background:#96bfbb; color:#211}
.button2{background:#aa739b; color:#f22}
.button3{background:#c82c1d; color:#fef}
.button4{background:#0075a0; color:#faf}
.button5{background:#3a1622; color:#fff}
.clear {clear:both}
      
#chosen {float:left; margin-top:10px;
border-radius:5px;  
background-image: -webkit-linear-gradient(top, #cccccc, #88a3af);
background-image: -o-linear-gradient(top, #cccccc, #88a3af);
background-image: -moz-linear-gradient(top, #cccccc, #88a3af);
background-image: -ms-linear-gradient(top, #cccccc, #88a3af);
text-align:center;
color:#ffffff;
font-weight:bold;
font-size:1.2em;
margin-left:10px;
}
#slide{float:left;margin-top:10px;} 
.options,.playlists{
    color: #fff;
    background: #6e9fb6;
    margin-top: 20px;
    margin-bottom: 10px;
    padding: 2px 15px;
    font-size: 1.3em; 
    
    display: inline;
    float: left;
    border:1px solid #1b5a77;
   
}
 
input[type=range]{ -webkit-appearance:none; -moz-apperance:none;  
-webkit-border-radius: 5px;  
 background-image:-webkit-gradient(linear, left top, left bottom, color-stop(0, #000), color-stop(0.49, #000), color-stop(0.51, #000), color-stop(1, #f00) );
background-image: -webkit-linear-gradient(top, #b7cbd4, #fff, #b7cbd4);
background-image: -o-linear-gradient(top, #b7cbd4, #fff, #b7cbd4);
}
 

input[type=range]::-webkit-slider-thumb {
   -webkit-appearance: none;
   background-color: #ecf0f1;
   border: 3px solid #b7cbd4;
   width: 20px;
   height: 20px;
   border-radius: 10px;
   cursor: pointer;
   }

input[type=range]::-moz-range-track {  
   background-image: -moz-linear-gradient(top, #b7cbd4, #fff, #b7cbd4); 
   border-radius: 8px;  
   height: 20px; 
   }
   
input[type=range]::-moz-range-thumb { 
   background-color: #ecf0f1;
   border: 3px solid #b7cbd4;
   width: 15px;  
   height: 15px;  
   border-radius: 10px;  
   cursor: pointer;  
   }  

input[type=range]::-ms-fill-lower ,
input[type=range]::-ms-fill-upper {  
   background: -ms-linear-gradient(top, #b7cbd4, #fff, #b7cbd4);
   }  
input[type=range]::-ms-track {  
   border-radius: 8px;  
   height:20px;
   border-width: 0px;  color: transparent;  
   }
   
input[type=range]::-ms-thumb {
   background-color: #ecf0f1;
   border: 3px solid #b7cbd4;
   width: 15px;  
   height: 15px;  
   border-radius: 10px;  
   cursor: pointer;  
   }
input[type=text]{width:2em;}
p,div, input, select {padding: 0; margin: 0; color:#236787; font-size: 1.1em; font-weight: 700;}
input[type="text"]  , select  {background: #f3f9fb;  border-width: 1px;border-color:#6e9fb6}
html #playdelay{float:none}
html .button {
   float:left;
   font-size:14px;
   background: #6e9fb6;
   color: #fff;
   margin: 0 5px ;
   padding: 0  5px;
   border:4px;
   border-style: solid;
   border-color:#6399b2;  
   -moz-border-radius:10px;
   -webkit-border-radius:10px;
   border-radius:10px;
   -moz-box-shadow:inset 0 10px 0 rgba(255,255,255,0.5);
   -webkit-box-shadow:inset 0 10px 0 rgba(255,255,255,0.5);
   box-shadow:inset 0 10px 0 rgba(255,255,255,0.5);
   cursor:pointer;
   }
   
html .debug  {background: #f2f2f2; color:#0c0} 

#displayclock {padding: 10px 0;font-size: 2em;}
#slider {float: left;    display:none;  }
#controls {margin:50px 0 30px 0;  position: relative; height:44px;  }
#timedisplay {padding-bottom: 30px; }
#prev,#play,#pause,#stop,#next,#repeat,#changemode,#showvol{width:45px;height:44px; display:block;float:left;background-image:url(music-control-buttons.jpg);background-repeat:no-repeat }
#prev {background-position: -5px 0px;}
#play {background-position:  -49px 0px;}
#pause{background-position:  -90px 0px;}
#stop{background-position:  -132px 0px;}
#next{background-position:  -175px 0px;}
#repeat{background-position: -260px 0px;}
#changemode{background-position: -341px 0px;}
#gongvol {float:left;  padding-left:30px;padding-top:10px;}
#wrapgongslide{ margin-top:30px;  } 
.setgong {float:left; cursor:pointer;
padding:2px;
margin: 15px 0 0 30px;
font-size:12px; background: rgba(255,255,255,.2);
border: 2px solid  #6e6fad;
  webkit-border-radius: 4px 4px 4px 4px;
	border-radius: 4px 4px 4px 4px;
    }
.hide{display:none;}
.small {font-size:.8em}
div #showvol{background-position: -383px 0px; width:40px;}
.floatleft{float:left; text-align:left}
#gong {float:left;padding-left:10px}
#gongClock{float:left; padding-left:20px; padding-top: 10px;}
 </style>
</head>
<body>
     <form action="/sound.php" method="post">
     <?php echo $alert_msg; ?>
     <div class="options" onclick="show_id('hideout');" style="margin-top:0; margin-bottom:0px; font-size:4px;padding:1px;text-decoration:underline; cursor:pointer;"> To Do</div>
     <div id="hideout" style="display:none;">
     <textarea name="submitdata" rows="10" cols="100"><?php echo $remind; ?></textarea>
     <input class="emailbutton" type="submit" name="submit" value="update list" >
	<input type="hidden" name="submitted" value="1" >
     <p><input type="radio" name="fsize" value="normal">Normal Alert</p>
     <p><input type="radio" name="fsize" value="large">Large Alert</p>
     </div><p class="clear"></p>
     <div class="options" style="margin-top:5px;"> Timer Options</div><p class="clear"></p>
     <div id="displayclock"></div>
     <audio id="bell">
      HTML5 audio not supported
    </audio>  
    <audio id="oaudio">
      HTML5 audio not supported
    </audio>
    
     
      day:<input type="text" id="days" size="2" maxlength="2" value="" />
      hrs:<input type="text" id="hours" size="2" maxlength="2" value="" />
      min:<input type="text" id="minutes" size="1" maxlength="3" value="" />
    
  <!--  <select name="dropdownsecs" id="dropdownsecs" value="random" >
 <option value="0" selected="selected">0 mins</option>
  <option value="1">1 mins</option><option value="2">2 mins</option><option value="3">3 mins</option><option value="4">4 mins</option><option value="5">5 mins</option><option value="6">6 mins</option><option value="7">7 mins</option><option value="8">8 mins</option><option value="9">9 mins</option><option value="10">10 mins</option><option value="11">11 mins</option><option value="12">12 mins</option><option value="13">13 mins</option><option value="14">14 mins</option><option value="15">15 mins</option><option value="16">16 mins</option><option value="17">17 mins</option><option value="18">18 mins</option><option value="19">19 mins</option><option value="20">20 mins</option><option value="21">21 mins</option><option value="22">22 mins</option><option value="23">23 mins</option><option value="24">24 mins</option><option value="25">25 mins</option><option value="26">26 mins</option><option value="27">27 mins</option><option value="28">28 mins</option><option value="29">29 mins</option><option value="30">30 mins</option><option value="31">31 mins</option><option value="32">32 mins</option><option value="33">33 mins</option><option value="34">34 mins</option><option value="35">35 mins</option><option value="36">36 mins</option><option value="37">37 mins</option><option value="38">38 mins</option><option value="39">39 mins</option><option value="40">40 mins</option><option value="41">41 mins</option><option value="42">42 mins</option><option value="43">43 mins</option><option value="44">44 mins</option><option value="45">45 mins</option><option value="46">46 mins</option><option value="47">47 mins</option><option value="48">48 mins</option><option value="49">49 mins</option><option value="50">50 mins</option><option value="51">51 mins</option><option value="52">52 mins</option><option value="53">53 mins</option><option value="54">54 mins</option><option value="55">55 mins</option><option value="56">56 mins</option><option value="57">57 mins</option><option value="58">58 mins</option><option value="59">59 mins</option>	
  
    </select>  
   -->
  
    <button type="button" class="button" id="playdelay">
      Play Delay
    </button>
 
 


<p class="clear"></p>

<div class="playlists" >  Now Playing</div>



 
<div id="gongvol">
     <img id="gong" src="./gong.gif" width="50" height="50" alt="the gong">


     <p class="setgong" title=""  onclick="show('show1','Set Gong','close Set ');" id="show1">Set Gong</p>  <div id="gongClock"> </div>
     <p style="clear:both;display:block; height:0px;">&nbsp;</p>
     <div class="inline floatleft" id="show1t" style="display: none; "><!--Quick Editor Overview openshowtrack1-->

          <p class="floatleft">Vol</p><input id="gongslide" class="floatleft"  style="width:156px;" type="range" min="0" max="100"  value="100" /> <p class="floatleft" id="gongchosen">100</p>

          <p style="clear:both;display:block; height:0px;">&nbsp;</p>
          <p class="small floatleft">Interval</p><input  id="gongInterval" class="floatleft"  style="width:1000px;" type="range" min="1" max="600"  value="10" /> <p class="floatleft" id="gongminChosen">10</p><p class="floatleft">min</p>
          </div><!--end show it-->
    
     <p style="clear:both;display:block; height:0px;">&nbsp;</p>
     
     
     </div><!--gong vol-->
<div class="clear"></div> 
<div id="nowplaying">   <span id="namecolor"> &nbsp; </span><span id="artistcolor">&nbsp;  </span><span id="albumcolor">&nbsp;  </span><span id="bitratecolor">&nbsp;  </span><span id="totaltimecolor">&nbsp;  </span> </div>

<p class="clear"></p>

  
<div id="controls">
<span id="prev">   </span>
<span id="play">   </span>
<span id="pause">   </span>
<span id="stop">   </span>
<span id="next">   </span>
<span id="repeat" onclick="repeatIt();">   </span>
<span id="changemode">   </span>
<span id="showvol">   </span>
<div id="slider"> <input id="slide" style="width:256px;" type="range" min="0" max="100"  value="100" /> <p id="chosen">100</p>
</div>
</div>
<div class="clear"></div> 



<div id="timedisplay" style="position:relative;"> <span style=" position:relative;top:15px;" id="songTime">00.00</span>
<input id="slideTime"                                         style="width:250px;position:absolute;top:15px;"  type="range"  min="0" max="100" value="0" />
<input id="changeSlide" style="padding:15px 0 25px 0;opacity:.0;filter: alpha(opacity=00) ;width:250px;position:absolute;"  type="range"   min="0" max="100" value="0" />
<span id="songTimeLeft"  style="position:relative; left:255px;top:15px;">00.00</span>

 </div><!-- timedisplay-->
<div class="playlists" >  Playlists</div>
<div class="clear"></div> 
   <p>&nbsp;</p> 
 <?php echo $play;?>
 
 <p class="space"></p>      
   
</body>
</html>


 
 