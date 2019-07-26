<?php
class javascript {
     protected $javascript='';

function __construct($array_function, $pagename, $file_extension='',$append_script=''){ 
	$array_function=(!is_array($array_function))?explode(',',$array_function):$array_function;    
	foreach ($array_function as $var){  
		$this->$var(); $this->javascript.="\n";
		} 
	$this->javascript.=$append_script;
	if ($pagename==='print'){ 
		$this->javascript_return="\n\r".
		self::open_java()."\n\r".'//<![CDATA['."\n\r".
		$this->javascript."\n\r". '//]]>'."\n\r".'</script>'; 
		return;
		}   
	file_put_contents(Cfg_loc::Root_dir.Cfg::Script_dir.$file_extension.'scripts.js', $this->javascript); 
	}
 
static function open_java() {
	return ('<script type="text/javascript">');
	}
     
function onload(){
	//the following loads prior to onload
     $this->javascript.= <<<EOD
	var animationEnd = (function(el) {
          var animations = {
               animation: 'animationend',
               OAnimation: 'oAnimationEnd',
               MozAnimation: 'mozAnimationEnd',
               WebkitAnimation: 'webkitAnimationEnd',
               };
          for (var t in animations) {
               if (el.style[t] !== undefined) {
                    return animations[t];
                    }
               }
          })(document.createElement('div'));
     var animationStart = (function(el) {
          var animations = {
          animation: 'animationstart',
          OAnimation: 'oAnimationStart',
          MozAnimation: 'mozAnimationStart',
          WebkitAnimation: 'webkitAnimationStart',
          };
          for (var t in animations) {
               if (el.style[t] !== undefined) {
                    return animations[t];
                    }
               }
          })(document.createElement('div'));
     //begin  jscolor
     function add(obje) {
          var input = document.createElement('INPUT')
          var picker = new jscolor(input)
          picker.fromHSV()
          //picker.value='ff00ff'; 
          input.setAttribute('value','000000');   
          obje.appendChild(input)
          }
     /* 
     Double Tap to Go
     Author: Graffino (http://www.graffino.com)
     Version: 0.3
     Originally by Osvaldas Valutis, www.osvaldas.info	
     Available for use under the MIT License
     */ 
     ;(function(\$, window, document, undefined) {
          \$.fn.doubleTapToGo = function(action) {
               if (!('ontouchstart' in window) &&
                    !navigator.msMaxTouchPoints &&
                    !navigator.userAgent.toLowerCase().match( /windows phone os 7/i )) return false;
               if (action === 'unbind') {
                    this.each(function() {
                         \$(this).off();
                         \$(document).off('click touchstart MSPointerDown', handleTouch);	
                    });
               }
          else {
               this.each(function() {
                    var curItem = false;
                    \$(this).on('click', function(e) {
                         var item = $(this);
                         if (item[0] != curItem[0]) {
                              e.preventDefault();
                              curItem = item;
                              }
                         });
                    \$(document).on('click touchstart MSPointerDown', handleTouch); 
                    function handleTouch(e) {
                         var resetItem = true,
                              parents = \$(e.target).parents();
                         for (var i = 0; i < parents.length; i++)
                              if (parents[i] == curItem[0])
                                   resetItem = false;
                              if(resetItem)
                                   curItem = false;
                              }
                         });
                    }
               return this;	
               };
          })(jQuery, window, document);//end Double Tap to Go
     //the following loads after document is loaded
     \$(function(){
          function is_touch_device() {//ie modernizer excerp from stack overflow
               try {  
                    document.createEvent("TouchEvent");  
               return true;  
               } catch (e) {  
                 return false;  
               }  
             }
          var resizeTimer='';
          window.USER_IS_TOUCHING=false; 
          gen_Proc.scrollAnimate(); 
          window.addEventListener('touchstart', function onFirstTouch() {//detect touch devices..David Gilbertson  
               window.USER_IS_TOUCHING = true;   
               window.removeEventListener('touchstart', onFirstTouch, false);
               }, false);
          if ('ontouchstart' in document.documentElement || (window.DocumentTouch && document instanceof DocumentTouch) ||  navigator.msMaxTouchPoints ) {
               window.TOUCHSTART=true;
               }
          else if (is_touch_device()) 
               window.TOUCHSTART=true; 
          else 
               window.TOUCHSTART=false;//end is touch
          gen_Proc.dpiRatio=window.devicePixelRatio || 1;
          gen_Proc.dpiRatio= gen_Proc.dpiRatio > .1  ? Math.min(gen_Proc.dpiRatio, 2.5) : 1; 
          gen_Proc.classPass('prevD',gen_Proc.addEvent,'click',gen_Proc.prevDefault); 
          gen_Proc.classPass('backauto',gen_Proc.imageResponseBack); 
          //gen_Proc.classPass('respondHeight',gen_Proc.responseHeight);
          gen_Proc.classPass('grid',gen_Proc.gridWidth);
          gen_Proc.classPass('respondPS',gen_Proc.psImageResponse);   
          gen_Proc.classPass('video-back-container',gen_Proc.videoResponseBack);
          gen_Proc.classPass('fadein',gen_Proc.fadeIn);
          gen_Proc.classPass('imagerespond',gen_Proc.imageResponse);
          gen_Proc.classPass('sliderespond',gen_Proc.slideResponse); 
          gen_Proc.classPass('page_options_hidefont',gen_Proc.showIt); 
          var winMaxWidth = \$(window).width();
          var winWid=winMaxWidth;
          document.cookie='dpiRatio='+ gen_Proc.dpiRatio || 1+"; path=/";  
          document.cookie='clientW='+winMaxWidth+"; path=/";
          document.cookie='screenW='+screen.width+','+screen.height;
          window.addEventListener('resize', function(){ 
               gen_Proc.displayWindowSize('displayCurrentSize');
               clearTimeout(resizeTimer);
               resizeTimer = setTimeout(function(){ //this limits no of resize events responding
                    var nw=\$(window).width();
                    if ( winMaxWidth >150 && winMaxWidth < nw){
     gen_Proc.classPass('backauto',gen_Proc.imageResponseBack);//background slideshow
                         gen_Proc.classPass('respondPS',gen_Proc.psImageResponse); 
                         gen_Proc.classPass('imagerespond',gen_Proc.imageResponse);
                         gen_Proc.classPass('sliderespond',gen_Proc.slideResponse);  
                         gen_Proc.classPass('grid',gen_Proc.gridWidth); 
                         gen_Proc.classPass('video_resize',gen_Proc.videoRespond);
                         winMaxWidth=nw;
                         }//if larger resize
                     if (winWid !== nw){ 
                         winWid = nw;
                         gen_Proc.dpiRatio=window.devicePixelRatio || 1;
                         gen_Proc.dpiRatio= gen_Proc.dpiRatio > .1  ? Math.min(gen_Proc.dpiRatio, 2.5) : 1; 
                         document.cookie='dpiRatio='+ gen_Proc.dpiRatio; 
                         document.cookie='clientW='+nw;  
                         }
                    }, 500); 
               }, true); 
          gen_Proc.displayWindowSize('displayCurrentSize');  
          gen_Proc.passvar();
          });
	
EOD;
	}//end onload
   
function onload_edit(){//additional onload for editmode
$this->javascript.= <<<EOD
\$(function () { 
	gen_Proc.classPass('divTextArea',edit_Proc.divTextArea);
	gen_Proc.classPass('sortGall',edit_Proc.makelistSortable,edit_Proc.sendGallOrder);
	gen_Proc.classPass('sortSlide',edit_Proc.makelistSortable,edit_Proc.sendSlideOrder);
	gen_Proc.classPass('sortEdit',edit_Proc.makelistSortable,edit_Proc.sendEditOrder);
	});
EOD;
	}//end onload    

function  gen_Proc(){ 
$this->javascript.= <<<EOD
var gen_Proc = {
	Override	: 0,
     zInc      : 0,
	classPass  :  function(cname,fn){//use getalltags if mulitple classes used for element 
		var args = Array.prototype.splice.call(arguments, 2); 
		var classNames = document.getElementsByClassName(cname); 
		for (var i = 0;  i < classNames.length;  i++){ 
			var newargs=[classNames[i]].concat(args);
			 fn.apply(null,newargs); 
			} 
		},
	funcPass	: function (){  
		for(x = 0;x < arguments.length;x++) {
			gen_Proc[arguments[x].funct](arguments[x].pass);
			}	 
		},//end funcPass
	animateLockReady : function(id,delay){
		setTimeout(function(){
		\$('#'+id).attr('data-duration', 'finished');
		},delay*1000)
		},
	animateFollow :  function(id,rm,add,delay,inc,display){
		setTimeout(function(){  
		\$('#'+id).removeClass(rm); 
		\$('#'+id).addClass(add);
		\$("body").css("overflow", "auto");
		},delay)
		if (display === 'displaynone'){
			setTimeout(function(){
				\$('#'+id).hide('1000');
				setTimeout(function(){ 
					var \$window = \$(window);
					\$window.trigger('scroll');
					\$('#'+id).attr('data-status', 'finished'); 
					},'1000')
				},(delay+inc))
			}
		else if (display === 'visibleoff'){
			setTimeout(function(){
				\$('#'+id).addClass('fadeOut hidden');
				setTimeout(function(){ 
					var \$window = \$(window);
					\$window.trigger('scroll');
					\$('#'+id).attr('data-status', 'finished');
					},'1000')
				},(delay+inc))
			}
		else {
			setTimeout(function(){ 
				\$('#'+id).attr('data-status', 'finished');  
				},(delay+inc))
			}
		},//end function
	animateFinish :  function(id,delay,display){
		setTimeout(function(){   
		\$("body").css("overflow", "auto");
		},delay)
		if (display === 'displaynone'){
			setTimeout(function(){
				 \$('#'+id).hide('1000');
				setTimeout(function(){ 
					var \$window = \$(window);
					\$window.trigger('scroll');
					\$('#'+id).attr('data-status', 'finished');
					},'1000')
				},delay)
			}
		else if (display === 'visibleoff'){
			setTimeout(function(){
				 \$('#'+id).addClass('fadeOut hidden');
				setTimeout(function(){ 
					var \$window = \$(window);
					\$window.trigger('scroll');
					\$('#'+id).attr('data-status', 'finished');
					},'1000')
				},delay)
			}
		else {
			setTimeout(function(){ 
				\$('#'+id).attr('data-status', 'finished');
				},delay)
			}    
		},//end function
	scrollAnimate :  function(){//credit: George Martsoukos  www.sitepoint.com modified
		\$animation_elements = \$('.animated');
		var \$window = \$(window);
		\$window.on('scroll resize', gen_Proc.check_if_in_view); 
		\$window.trigger('scroll');
		},
	check_if_in_view  :	function () {// modified  from: George Martsoukos  www.sitepoint.com  
		var window_height = \$(window).height();
		var window_top_position = \$(window).scrollTop();
		var window_bottom_position = (window_top_position + window_height);
		
		\$.each(\$animation_elements, function(i) {
			var elem = \$(this)
			var hchange=elem.attr('data-hchange');
               if (hchange ==='none'){ 
                    //disregard hlock experimental
                    elem.addClass('in-view'); 
				elem.removeClass('animated');
                    }
               else {
                    
                    var hchange=parseInt(hchange);
                    var hlock = (parseFloat(elem.attr('data-hlock'))>0)?parseFloat(elem.attr('data-hlock')):0;
                    if (hlock===0&&!elem.hasClass("animated"))return true;
                    var element_height = elem.outerHeight(true); 
                    var element_top_position = elem.offset().top;
                    var element_bottom_position = (element_top_position + element_height);
                    var height_change = (hchange * element_height/100); 
                    //check to see if this current container is within viewport
                    if ((element_bottom_position  >= window_top_position ) &&
                         (element_top_position +height_change <= window_bottom_position)) {
                          elem.addClass('in-view'); 
                         elem.removeClass('animated');
                         if (hlock===0)
                              \$animation_elements=$(".animated");//update to remove this one
                         }
                    elem.on( 'DOMMouseScroll mousewheel', function ( event ) {
                    //stack overflow:questions/7154967/how-to-detect-scroll-direction/33334461#33334461
                    if( event.originalEvent.detail > 0 || event.originalEvent.wheelDelta < 0 ) { //alternative options for wheelData: wheelDeltaX & wheelDeltaY
                         //scroll down 
                         }
                    else {
                         if (hlock >0){
                              hlock=0;
                               elem.attr('data-hlock',0);
                              \$("body").css("overflow", "auto"); //release scroll lock
                              }
                         }
                    //prevent page fom scrolling 
                    });
                    if (hlock>0 && element_bottom_position +20 <= window_bottom_position && elem.attr("data-duration")==='finished') {
                         \$animation_elements=$(".animated");//update to remove obj
                         \$("body").css("overflow", "hidden");  
                         setTimeout(function(){ 
                          elem.attr('data-hlock',0);//set to 0 so as not to hlocking
                          \$("body").css("overflow", "auto");  
                          return false;
                         },hlock*1000); 
                         }
                    }//if ! hchange < 1
               }); 
          },
	getCookie : function(cname) { 
		var name = cname + "=";
		var decodedCookie = decodeURIComponent(document.cookie);
		var ca = decodedCookie.split(';');
		for(var i = 0; i <ca.length; i++) {
			var c = ca[i];
			while (c.charAt(0) == ' ') {
				c = c.substring(1);
				}
			if (c.indexOf(name) == 0) {
				return c.substring(name.length, c.length);
				}
			}
		return "";
		},
     toggleIt  : function(ele){  
          document.getElementById(ele).style.display="block";
          },
	toggleControls  : function (video) {
		console.log('var videoActualWidth = '+video.getBoundingClientRect().width);
 		gen_Proc.addEvent(video, 'click', function(){
			if (video.hasAttribute("controls")){ 
			video.removeAttribute("controls")
			}
		else  { 
			video.setAttribute("controls","")
			} 
			})
		},
	videoResponseBack   :  function(f){
		if (f.getElementsByTagName('video')[0]){
			var iframe = f.getElementsByTagName('video')[0];
			}
		else return;
		var type=f.getAttribute('data-type');  
		var ratio=f.getAttribute('data-vid-ratio'); 
		if (type=='page_style'){
			var displayRatio=screen.width/screen.height;
			var	pwidth = screen.width;
			}
		else {
			pwidth = Math.max(f.parentNode.offsetWidth,f.parentNode.clientWidth); 
			var pheight = Math.max(f.parentNode.offsetHeight,f.parentNode.clientHeight);
			 var displayRatio=pwidth/pheight;
			}
		
		if (type=='page_style')  f.style.position='fixed';
		else {
			f.parentNode.style.overflow="hidden";
			f.parentNode.style.position="relative";
			}
		if (ratio > displayRatio){//height is limiting partner
			var newHeight=pheight;
			var newWidth=newHeight*displayRatio;
			}
		else {
			var newWidth=pwidth;
			var newHeight=pwidth/displayRatio;
			}
		f.style.width=newWidth+'px';
		f.style.height=newHeight+'px';
		iframe.style.width=newWidth+'px';
		iframe.style.height=newHeight+'px';
		},
	clientWid  : function(){
		return Math.max(window.innerWidth,document.documentElement.clientWidth,document.body.clientWidth);
		},
	responseHeight	  :  function(f){ 
		var pwidth=Math.max(f.offsetWidth,f.clientWidth);
		var initWid=f.getAttribute('data-hwid'); 
		var dataH=f.getAttribute('data-height');
          if(initWid==='init'){
               initwid=Math.max(f.offsetWidth,f.clientWidth);
               f.setAttribute("data-hwid", initwid);
               }
          if(dataH==='init'){
               dataH=f.offsetHeight;
               f.setAttribute("data-height", dataH);
               }
		//var minHeight=f.getAttribute('data-minHeight');
		var type=f.getAttribute('data-type');
		var rwd=f.getAttribute('data-rwd');
		//scroll set with css in height function
		//if (f.scrollHeight>(pwidth/initWid*dataH+25)){
			//if (type=='image'&& !rwd)
				//f.style.overflowY = "hidden";
			//else f.style.overflowY = "scroll";
			//}
		//else f.style.overflowY = "scroll";
		 if (type=='video'){ 
			//video=f.getElementsByTagName("video");
			//gen_Proc.toggleClass(video[0]);
			} 
		else f.style.height=((pwidth/initWid*dataH)<=dataH)?Math.max((pwidth/initWid*dataH),minHeight)+'px':dataH+'px';//changes according to current wid...
		},
	psResponse  : function(img){
		var pwidth=img.width;
		var pheight=img.height;
		var ratio=pwidth/pheight;
		var pattern=new RegExp(gen_Proc.image_response_dir_prefix+"[0-9]+");
		var oldSrc=img.src;
		var oldDir = oldSrc.match(pattern); 
		var oldWidth=oldDir.toString().replace(/[^0-9]/g,'');// 
		if (oldWidth < pwidth){  
			var pattern=new RegExp(gen_Proc.image_response_dir_prefix+"[0-9]+\/");
			var newWidth=gen_Proc.keyUp(pwidth,gen_Proc.image_response,gen_Proc.maxPicLimit);
			var newSrc = oldSrc.replace(pattern,gen_Proc.image_response_dir_prefix+newWidth+'/');
			gen_Proc.picSrc=newSrc;  
			gen_Proc.imgSize=newWidth
			gen_Proc.imageExists2(newSrc,function(exists){
				if (exists) {
					img.src=newSrc;
					img.w=newWidth*1.25;
					img.h=img.w/ratio;
					}
				});
			}
		},
	psImageResponse   :  function(img){ 
		if (img.src)gen_Proc.psResponse(img);
		else {
			img.onload = function() {  
				gen_Proc.psRespnse(img);
				}//onload
			}
		},
     imageResponse   :  function(f){  
		var pwidth=Math.max(f.offsetWidth,f.clientWidth);
		var myimg = f.getElementsByTagName('img')[0]; 
		var oldWidth=f.getAttribute('data-wid');  // will get direct
          if (pwidth > oldWidth){ 
               var newWidth=gen_Proc.keyUp(pwidth,gen_Proc.image_response,gen_Proc.maxPicLimit); 
               var i=false;
               var pattern=new RegExp(gen_Proc.image_response_dir_prefix+"[0-9]+\/");
               while (i===false){ 
                    if (newWidth >= oldWidth){  
                         oldSrc=myimg.src;  
                         var newSrc = oldSrc.replace(pattern,gen_Proc.image_response_dir_prefix+newWidth+'/'); 
                         var exists=gen_Proc.imageExists2(newSrc);
                         if (exists) {  
                              myimg.src=newSrc;  
                              i=true;
                              //myimg.style.width='100%';
                              //myimg.style.height='auto'; 
                              }
                         i=true;//set to true to override the while statement. using imageExist2 instead gave false positives.  validating image change otherwise proved tricky..
                         if (i){ 
                              f.setAttribute("data-wid", newWidth); 
                              }
                         else {
                              oldWidth=newWidth;
                              newWidth=gen_Proc.keyDown(newWidth,gen_Proc.image_response);
                              //obtains next lower cache value to reload if first value not present. 
                             }
                         if (newWidth < 10)i=true;//failure to reload break
                         }
                    else i=true;
                    }//continue while
			}
		else { 
			//check if kenburns and fixed height.
			if (f.parentNode.className.indexOf("kenburns")>-1){ 
				myimg.style.width=oldWidth+'px'; 
				}
			}
		},
     slideResponse   :  function(f){  
		var pwidth=Math.max(f.offsetWidth,f.clientWidth);
		var myimgarr = f.getElementsByTagName('img'); 
          var oldWidth=f.getAttribute('data-wid');  // will get direct 
          if (pwidth > oldWidth){  
               var newWidth=gen_Proc.keyUp(pwidth,gen_Proc.image_response,gen_Proc.maxPicLimit); 
               var i=false; 
               var pattern=new RegExp(gen_Proc.image_response_dir_prefix+"[0-9]+\/");
               for (ii=0; ii < myimgarr.length; ii++){
                    myimg=myimgarr[ii];
                    while (i===false){ 
                         if (newWidth >= oldWidth){
                              oldSrc=myimg.src;  
                              var newSrc = oldSrc.replace(pattern,gen_Proc.image_response_dir_prefix+newWidth+'/'); 
                              var exists=gen_Proc.imageExists2(newSrc);
                              if (exists) {  
                                   myimg.src=newSrc;
                                   i=true;
                                   //myimg.style.width='100%';
                                   //myimg.style.height='auto'; 
                                   }
                              i=true;//bypass while as XMLHttpRequest giving false pos in imageExists2 and imageExists scope of return valideation problem
                              if (i){ 
                                   f.setAttribute("data-wid", newWidth); 
                                   }
                              else {
                                   oldWidth=newWidth;
                                   newWidth=gen_Proc.keyDown(newWidth,gen_Proc.image_response);
                                   //obtains next lower cache value to reload if first value not present. 
                                  }
                              if (newWidth < 10)i=true;//failure to reload break
                              }
                         else i=true;
                         }//continue while
                         }//for loop
                    }
          else { 
               //check if kenburns and fixed height.
               if (f.parentNode.className.indexOf("kenburns")>-1){ 
                    myimg.style.width=oldWidth+'px'; 
                    }
               }
		},
     imageExists2   :function (image_url){//https://stackoverflow.com/questions/18837735/check-if-image-exists-on-server-using-javascript#18837750
          var http = new XMLHttpRequest();
          http.open('HEAD', image_url, false);
          http.send();
          return http.status != 404;
          },
	gridWidth		:  function(f){
		var pwidth=Math.max(f.offsetWidth,f.clientWidth);
		f.style.width=pwidth+'px';
		},
	validateReturn	:  function(){
		var doReturn=true;
		 for(x = 0;x < arguments.length;x++) {
			var ret = gen_Proc[arguments[x].funct](arguments[x].pass);
			if (ret==false) doReturn=false
			} 
		return doReturn;
		}, 
	showIt    :  function(obje){
		if (typeof obje === "string"){ 
			var obje =  (obje == 'body') ? document.getElementsByTagName("body")[0] : document.getElementById(obje)
			}
		obje.style.display="block";
		},//end showit
	toggleVisibility  :  function(elem1,elem2){  
		if (window.TOUCHSTART){ 
               \$(elem1).mouseenter(function(event){  
                    if (\$(this).find('ul.sub-level').css("display")!=="block") 
                         \$(this).find('ul.sub-level').css({'visibility':'visible','display':'block'});
                    else{
                         \$(this).find('ul.sub-level').css({'visibility':'hidden','display':'none'});}
			if (event.preventDefault) { 
			 event.preventDefault();
			}
		else {
			event.returnValue = false; 
			} 
                    });
			}
     },
	toggle_class_reload	: function(id,postId,self){
		var obj   =  document.getElementById(id);	
		if (obj.className.indexOf("mytextarea")<0)
			op='1'
		else op='0'
		this.use_ajax(self+'?toggle_class_reload='+id+'@@'+postId+ '@@'+op,'handle_replace','get');
		}, //end toggle
	prevDefault  :  function(){  
		event=arguments[0];  
		if (event.preventDefault) { 
			 event.preventDefault();
			}
		else {
			event.returnValue = false; 
			} 
		},
	displayWindowSize	: function(id) { 
		 p=document.querySelector('#'+id + ' p#clientw');
		 p2=document.querySelector('#'+id+'2' + ' p#clientw2');
		if(p=== null)return;
		myWidth = window.innerWidth;
		//myHeight = window.innerHeight;
		var x = {
               w1: window.innerWidth || 1,
               w2: document.documentElement.clientWidth || 2,
               w3: document.documentElement.offsetWidth || 4,
               };  
		var wmax=Math.max(x.w1,x.w2,x.w3);
		var JQ=\$(window).width();  
		p2.innerHTML=p.innerHTML = 'Wid: <span class="red whitebackground">'+JQ +'</span>';
		 },
     show	:  function  (id,show,msgVar,width,mainconfig){//show  
		if(document.getElementById(id+ "t").style.display=="block"){
               if (msgVar === 'noclose')return;
			gen_Proc.fullWidthOff(id,msgVar,mainconfig);
			document.getElementById(id+"t").style.display ="none";
			document.getElementById(id).style.textDecoration = 'underline';
			document.getElementById(id).innerHTML=show;  
			document.getElementById(id).style.borderColor='initial'; 
			}
		else{
			gen_Proc.fullWidthOn(id,width,msgVar,mainconfig); 
			if (msgVar=='slow')fadeTo.fadeTo_init(id+"t",.5,0,100,1.5);
			document.getElementById(id+"t").style.display ="block";
			if (msgVar !== 'noclose')document.getElementById(id).innerHTML='<span class="redAlertbackground white">Close </span>'+show;
			document.getElementById(id).style.borderColor='red';
			document.getElementById(id).style.textDecoration = 'underline'; 
			}
		}, //end show function
	fullWidthOn	:  function(id,width,msgVar,mainconfig){  
		if (msgVar==='asis'||mainconfig==='asis')return;
		elem=document.getElementById(id+"t");
          //suspend dimming effect
		//if (gen_Proc.Edit&&(mainconfig===true || msgVar==='main')){ 
			// \$('.edit').addClass('staticdim'); 
			// \$('.edit').removeClass('fullopacity'); 
			//\$('#'+id).parents('.edit').addClass('fullopacity'); 
	//\$('#'+id).addClass('fullopacity');		 
			//} 
		var offset=\$('#'+id).offset();
		var leftpos=offset.left;//how far from left border
		\$('#'+id+'t').wrap('<div class="jqwrap"></div>');
		\$('#'+id+'t').parent().css({position:'relative'});//to enable zIndex in relative pos  
		wmax=\$(window).width();
		
		if (width=="full"){
			elem.style.maxWidth='100%'; 
			elem.style.position="absolute";
			elem.style.zIndex="100";
			elem.style.minWidth=300+'px';
			return;
			}
		else {
			if (width > wmax){
				currentWid=wmax; 
				}
			else {
				var offWid=elem.offsetWidth; 
				var currentWid=Math.max(width,offWid);
				} 
			var widthpx=currentWid*.9+"px";
			var html='m';
			var letters=currentWid/10;
			for (i=0; i<letters; i++){
				html += 'm';
				} 
			$(elem).children(":first").append('<p class="removeit" style="font-family:monospace;font-size:16px;visibility:hidden">'+html+'</p>');
			} 
		elem.style.position="absolute";  
		elem.style.zIndex=(100+gen_Proc.zInc); gen_Proc.zInc++; 
		elem.style.width=widthpx; 
		if ((leftpos + currentWid ) >   wmax ){
			tooFar=-(currentWid-(wmax-leftpos)); 
			elem.style.left=tooFar+"px";// move to left...
			}
		else { 
			elem.style.left=0;
			}
		},//end js function
	fullWidthOff	: function(id,msgVar,mainconfig){
		elem=document.getElementById(id+"t");
		//if (gen_Proc.Edit&&(msgVar==='main'||mainconfig)){
			//\$('.edit').removeClass('staticdim'); 
			//\$('.edit').removeClass('fullopacity'); 
			//\$('#'+id+'t').unwrap();
			//}
		$('.removeit').remove();
		elem.style.zIndex="initial";
		elem.style.position="initial";
		},//end function  
	getOffsetVal	:  function(element) {
		var top = 0, left = 0;
		do {
		   top += element.offsetTop  || 0;
		   left += element.offsetLeft || 0;
		   element = element.offsetParent;
		} while(element);//from Stack Overflow
		return {
			top: top,
			left: left
			 };
		},
	getOffsetRect	: function(elem)  { 
		var box = elem.getBoundingClientRect()
		var body = document.body
		var docElem = document.documentElement 
		var scrollTop = window.pageYOffset || docElem.scrollTop || body.scrollTop
		var scrollLeft = window.pageXOffset || docElem.scrollLeft || body.scrollLeft 
		var clientTop = docElem.clientTop || body.clientTop || 0
		var clientLeft = docElem.clientLeft || body.clientLeft || 0 
		var top  = box.top +  scrollTop - clientTop
		var left = box.left + scrollLeft - clientLeft
		return { top: Math.round(top), left: Math.round(left) }
		}, //end get offset
	bubbleUpId  : function (obje){  
		var pn=obje.parentNode;  
		if (typeof pn !== 'object') return '';
		var pnid=pn.id; 
		if (pnid.indexOf("post_id")>0) return pnid;
		//else this.bubbleUpId(pn);  not working
		var pn=pn.parentNode;
		if (typeof pn !== 'object') return '';
		var pnid=pn.id; 
		if (pnid.indexOf("post_id")>0) return pnid;
		else return '';
		},
	getStyle  : function (id,styles){
		if (typeof id === "string"){
			var elem =  (id == 'body') ? document.getElementsByTagName("body")[0] : document.getElementById(id)
			 }
		else if (id !== null &&typeof id === 'object'){
			var elem=id;
			}
		if (elem.currentStyle) {
			return elem.currentStyle[styles];
			}
		else if (window.getComputedStyle) {
			 return window.getComputedStyle(elem, null).getPropertyValue(styles);
			}
		else return '';
		},
	goTo     :  function (request){   
		var x = location.href.split("?")[0];   
		window.location.replace(x+'?gen'+Math.floor(Math.random()*10001)+'='+Math.floor(Math.random()*10001)+'&'+request);
		
		}, 
	navOver	:  function(ele,img) {
		ele.style.cursor="pointer" 
		ele.style.backgroundImage = "url("+img+")";
		},
	navOut	:  function (ele) {
		ele.style.cursor="none";
		ele.style.backgroundImage="none";
		},
	addClass   : function (ele, classN) {
		if (typeof ele === "string"){
			var a =  (ele == 'body') ? document.getElementsByTagName("body")[0] : document.getElementById(ele)
			 }
		else if (ele !== null &&typeof ele === 'object'){
			var a=ele;
			}
		else return;
		 
		a.classList ? a.classList.add(classN) : a.className += ' '+classN;
		},  
	toggleClass2   : function (ele, classN) { 
		if (\$(ele+'.'+classN).length){  
			\$(ele).removeClass(classN); 
			}
		else { 
			\$(ele).addClass(classN); 
			}
		}, 
	toggleClass   : function (ele, classN, classN2, replace, timeout) { 
		if (\$(ele+'.'+classN).length){ 
			\$(ele).addClass(replace).removeClass(classN);
			setTimeout(function(){
				//\$(ele).removeClass(replace)
				\$(ele).removeClass(classN2)
				},timeout);
			}
		else {
               \$(ele).removeClass(replace)
			\$(ele).addClass(classN).addClass(classN2);
			}
		},
	toggleHasClass   : function (ele, ele2, classN, classN2) { 
          if (\$(ele+'.'+classN).length){  
               \$(ele2).addClass(classN2) 
               }
          else {
               \$(ele2).removeClass(classN2) 
               }
		},
	toggleTweak   : function (ele, classN, ele2, tweak, tweak2, timeout) { 
          if (\$(ele+'.'+classN).length){      
               setTimeout(function(){
                    \$(ele2).css(tweak); 
                    },timeout);
               }
          else {
               if (tweak2 !==''){
                    \$(ele2).css(tweak2);
                    }
               }
		},
	toggleClassOut : function (ele, classN,  timeout){
		if (typeof ele === "string"){ 
			var act =  (ele == 'body') ? document.getElementsByTagName("body")[0] : document.getElementById(ele)
			 }
		else if (ele !== null &&typeof ele === 'object'){
			var act=ele;
			}
		else return;
		var pattern = new RegExp('(^|\\\s)'+classN+'(\\\s|$)');
		var rPattern='(^|\\\s)'+classN+'(\\\s|$)'
		
		if (act.className.match(pattern) ){
			act.className = act.className.replace(classN, '')
			
			}
		else {
			setTimeout(function(){
				act.classList ? act.classList.add(classN) : act.className += ' '+classN;//if someclass add class otherwise set as class
				},1000);
			}
		},
	cancelStyle   : function (ele, ele2, classN, inc) {
		if (typeof ele === "string"){ 
			var act =  (ele == 'body') ? document.getElementsByTagName("body")[0] : document.getElementById(ele)
			}
		else if (ele !== null &&typeof ele === 'object'){
			var act=ele;
			}
		else return;
		var pattern = new RegExp('(^|\\\s)'+classN+'(\\\s|$)');
		var rPattern='(^|\\\s)'+classN+'(\\\s|$)';
		act2=document.getElementById(ele2)
		if (act.className.match(pattern)){  
			act2.style.borderTopWidth=gen_Proc['navbordertop_'+inc]; 
			act2.style.borderBottomWidth=gen_Proc['navborderbot_'+inc];1 
			act2.style.borderLeftWidth=gen_Proc['navborderleft_'+inc]; 
			act2.style.borderRightWidth=gen_Proc['navborderright_'+inc]; 
			act2.style.boxShadow=gen_Proc['navboxshadow_'+inc];  
			}
		else { 
			act2.style.boxShadow='none';
			act2.style.borderWidth='0'; 
			}
		},	
	styleit   : function (ele, styles) {   
		if (typeof ele === "string"){
			var elem =  (ele == 'body') ? document.getElementsByTagName("body")[0] : document.getElementById(ele)
			//var elem=document.getElementById(ele)
			}
		else if (ele !== null &&typeof ele === 'object'){
			var elem=ele;
			}
		else return;
		for(var key in styles) {
			var val = styles[key];  
			elem.style[key]=val;
			}
		},
	 
	delayGoTo  :  function (a, b){  
		url = a.getAttribute('href')===null ? a.getAttribute('hrefData'):a.getAttribute('href');
		 window.setTimeout(function(){window.location.href=url;},b);
		},
	max_width	: function(width_available,current_ratio,minAspect,maxAspect){//determine best balance
		var maxH=(maxAspect > 1 && minAspect < 1)?width_available:width_available/minAspect;
		if ((maxAspect - minAspect)<=.2){//Pics are reasonable uniform size set to max_avail and calc topPad
			var wa=width_available;
			var h=wa/current_ratio;
			var pt=(maxH-h)/2;
			}
		else if (minAspect < .8 && maxAspect > 1.25){//variety of sizes
			switch (true){
			case current_ratio >= 1 && current_ratio < 1.11 : //image will have largest total area unless limited
				var wa=(width_available*.9)
				var h=wa/current_ratio;
				var pt=(maxH-h)/2;
				break;
			case current_ratio > 1  :   
				var wa=width_available
				var h=wa/current_ratio;
				var pt=(maxH-h)/2;
				break;
			case current_ratio < 1 && current_ratio >.9  : //this image will also have largest total area unless limited <1 >
				var wa=(width_available*current_ratio*.9);//ratio less than 1 > .9
				var h=wa/current_ratio;
				var pt=(maxH-h)/2;
				break;
			default :
				var wa=(width_available*current_ratio);
				var h=wa/current_ratio;
				var pt=(maxH-h)/2; 
				}
			}
		else {// set to maxwidth
			var wa=width_available;
			var h=wa/current_ratio;
			var pt=(maxH-h)/2; 
			}			 
		return [pt,wa];
		},
	isNumber :  function isNumber(n) {
		return !isNaN(parseFloat(n)) && isFinite(n);
		},
	precisionAdd  : function (obref,name,beg,end,size,unit,increment,factor,msg,unit2)  {// 
		obref.innerHTML='';
		obref.style.border='none'; 
		var mode=arguments[10];
		var resize=size.replace(/[^0-9]/g,'');
		var selectval=(gen_Proc.isNumber(size))?size/factor:resize;
		//var increment=(mode==='increment')?factor:1;
		var increment=(increment!==1)?arguments[11]:increment;
		var negativenums=(arguments[12]==='negativenums')?true:false;
		var msg2 = (negativenums)?'<p class="tip width100">Negative Value Spacing Follows Positive Values</p>':'';
		var optionNone=(arguments[11]==='none')?'<option value="none">none</option>':'';
		var shownum=(mode==='spacing')?size*factor:parseFloat((size/factor).toFixed(2))
		var show=(unit2!==''&&unit2!=='addunit'&&this.isNumber(size))?'&nbsp;&nbsp; '+shownum+unit2:''
		var uni=(unit2!==''&&this.isNumber(size))?unit:''
		var replace = msg2+msg+ '<select class="choose" name="'+name+'"><option value="'+selectval +'" selected="selected">'+ size+uni+show+'</option>'+optionNone; 
		end=parseFloat(end);
		end=end+.0000001;
		increment=parseFloat(increment);
		beg= parseFloat(beg);
		var optvalunit=(unit2==='addunit')?unit:''; 
		for (var i=beg;  i <   end; i = i +increment){ 
			if (mode==='simpleConvert'){
				var val2=i/factor;
				var dec=val2.toString().split('.');
				if (dec.length===2){
					if (dec[1].length>3){
						val2=val2.toFixed(1);
						}
					}
				replace+='<option value="'+i+'">'+i +unit+'  '+val2+unit2+'</option>'; 
				}
			else if (mode==='convertboth'){ 
					var optval=i/factor;
					var dec=optval.toString().split('.');
					if (dec.length===2){
						if (dec[1].length>2){
							optval=optval.toFixed(2);
							}
						}   
					var showopt='&nbsp;&nbsp; '+optval+unit2;
					replace+='<option value="'+i+'">'+i +unit+showopt+'</option>';
					}
			else if (mode==='simple'){ 
				replace+='<option value="'+i+'">'+i +unit+'</option>';
				}
			else if (mode==='reverse'){
				var optval=i/factor;
				var dec=optval.toString().split('.');
				if (dec.length===2){
					if (dec[1].length>5){
						optval=optval.toFixed(5);
						var viewval=optval.toFixed(2);
						}
					}  
				showopt='&nbsp;&nbsp; '+i+unit2;
				replace+='<option value="'+optval+optvalunit+'">'+viewval +unit+showopt+'</option>';
				}
			else if (mode==='increment') {
				var optval=Number(i) 
				var dec=increment.toString().split('.');
				if (dec.length===2){
					var optdec=parseInt(dec[1].length);
					optval=optval.toFixed(optdec);
					}    
				replace+='<option value="'+optval+'">'+optval +unit+'</option>';
				}
			else if (mode==='incrementConvert') {
				var optval=i/factor;
				var showval=optval
				var dec=optval.toString().split('.');
				if (dec.length===2){
					if (dec[1].length>3){
						showval=optval.toFixed(2);
						}
					}
				var optnum=Number(i) 
				var dec=increment.toString().split('.');
				if (dec.length===2){
					var optdec=parseInt(dec[1].length);
					optnum=optnum.toFixed(optdec);
					}
				var showopt='&nbsp;&nbsp; '+showval+unit2;
				replace+='<option value="'+optnum+'">'+optnum+unit+showopt+'</option>';
				}
			
			else {//width calc  stored as percent
				var optval=i/factor;   
				var showval=optval
				var dec=optval.toString().split('.');
				if (dec.length===2){
					if (dec[1].length>5){
						showval=optval.toFixed(2);
						optval=optval.toFixed(5);
						}
					}
				var showopt=(unit2!==''&&unit2!=='addunit')?'&nbsp;&nbsp; '+showval+unit2:'';
				replace+='<option value="'+optval+optvalunit+'">'+i+unit+showopt+'</option>';
				} 
			}//end for loop
		if (negativenums){
			for (var i=-beg;  i >   -end; i = i -increment){
				
				if (mode==='convertboth'){ 
						var optval=i/factor;
						var dec=optval.toString().split('.');
						if (dec.length===2){
							if (dec[1].length>2){
								optval=optval.toFixed(2);
								}
							}   
						var showopt='&nbsp;&nbsp; '+optval+unit2;
						replace+='<option value="'+i+'">'+i +unit+showopt+'</option>';
						}
				else if (mode==='simple'){ 
					replace+='<option value="'+i+'">'+i +unit+'</option>';
					}
				
				else if (mode==='reverse'){
					var optval=i/factor;
					var dec=optval.toString().split('.');
					if (dec.length===2){
						if (dec[1].length>5){
							optval=optval.toFixed(5);
							var viewval=optval.toFixed(2);
							}
						}  
					showopt='&nbsp;&nbsp; '+i+unit2;
					replace+='<option value="'+optval+optvalunit+'">'+viewval +unit+showopt+'</option>';
					}
				else if (mode==='increment') {
					var optval=Number(i) 
					var dec=increment.toString().split('.');
					if (dec.length===2){
						var optdec=parseInt(dec[1].length);
						optval=optval.toFixed(optdec);
						}    
					replace+='<option value="'+optval+'">'+optval +unit+'</option>';
					}
				else if (mode==='incrementConvert') {
					var optval=i/factor;
					var showval=optval
					var dec=optval.toString().split('.');
					if (dec.length===2){
						if (dec[1].length>3){
							showval=optval.toFixed(2);
							}
						}
					var optnum=Number(i) 
					var dec=increment.toString().split('.');
					if (dec.length===2){
						var optdec=parseInt(dec[1].length);
						optnum=optnum.toFixed(optdec);
						}
					var showopt='&nbsp;&nbsp; '+showval+unit2;
					replace+='<option value="'+optnum+'">'+optnum+unit+showopt+'</option>';
					} 
				else {//width calc  stored as percent
					var optval=i/factor;    
					var showval=optval
					var dec=optval.toString().split('.');
					if (dec.length===2){
						if (dec[1].length>5){
							showval=optval.toFixed(2);
							optval=optval.toFixed(5);
							}
						}
					var showopt=(unit2!==''&&unit2!=='addunit')?'&nbsp;&nbsp; '+showval+unit2:'';
					replace+='<option value="'+optval+optvalunit+'">'+i+unit+showopt+'</option>';
					} 
				}//end for loop
			}//neg numbs
		replace+='</select> ';  
		var newp = document.createElement('p');
		newp.setAttribute("class", "choose prevB");
		newp.innerHTML=replace; 
		obref.parentNode.insertBefore(newp, obref.nextSibling)
		},
		//from  http://stackoverflow.com/questions/10149963/adding-event-listener-cross-browser
	addEvent   :    function (elem, event, fn) {
		// avoid memory overhead of new anonymous functions for every event handler that's installed
		// by using local functions
		function listenHandler(e) {  
			var ret = fn.apply(this, arguments);
			if (ret === false) {
			 e.stopPropagation();
			e.preventDefault();
			}
		return(ret);
		} 
		function attachHandler() {
			// set the this pointer same as addEventListener when fn is called
			// and make sure the event is passed to the fn also so that works the same too
			var ret = fn.call(elem, window.event);   
			if (ret === false) {
				 window.event.returnValue = false;
				 window.event.cancelBubble = true;
				}
			return(ret);
			}

		if (elem.addEventListener) {
			elem.addEventListener(event, listenHandler, false);
			}
		else {
			elem.attachEvent("on" + event, attachHandler);
			}
		},  //end addEvent
	scroll_to_view   :   function(eleID) {  
		var e = document.getElementById(eleID);
		if (!!e && e.scrollIntoView) {
			e.scrollIntoView();
			}  
		},
	confirm_click  : function(msg){
		return confirm(msg);
		},
	on_check_event :  function(myclass,msg ){ 
		var ele = document.getElementsByName(myclass);
		var i = ele.length;    
		for (var j = 0; j < i; j++) {
			if (ele[j].checked) {  
				alert(msg);
				}
			 
			}//end for
		},// end on check   
	create_ajax : function (){ 
		if (window.XMLHttpRequest) {
		// IE 7, Mozilla, Safari, Firefox, Opera, most browsers:
			this.ajax = new XMLHttpRequest();
			} 
		else if (window.ActiveXObject) { // Older IE browsers
			// Create type Msxml2.XMLHTTP, if possible:
			try {
			    this.ajax = new ActiveXObject("Msxml2.XMLHTTP");
			    }
			catch (e1) { // Create the older type instead:
				try {
					this.ajax = new ActiveXObject("Microsoft.XMLHTTP");
					}
					catch (e2) { }
				}//catch
			}//end else old
		// Send an alert if the object wasn't created.
		if (!this.ajax) {
			alert ('Some page functionality is unavailable.');
			}
	    
		},//end create_ajax
	use_ajax   : 	function (url,func,method){
		console.log('url: '+url+' funct: '+func);
		if (this.passclass&&!this.Override){ 
			return;
			}
		this.create_ajax();
		if (this.ajax) {
			this.Override=0
			this.ajax.open(method, url+'&sess_override',true);
			this.ajax.onreadystatechange = function(){
			gen_Proc[func]();}
			// Send the request:
			this.ajax.send(null);
			return false;
			}
		else {
			return true;
			}
		}, //end use_ajax
	handle_replace	:   function () { 
		if ( (this.ajax.readyState == 4) && (this.ajax.status == 200) ) {
			if (this.ajax.responseText.length > 20) { 
				console.log(this.ajax.responseText)
				var jsonitems = JSON.parse(this.ajax.responseText); 
				//console.log( jsonitems[0]);
				 //console.log( jsonitems[1]);
				var key,size = 0;
				for (key in jsonitems){
					if (jsonitems.hasOwnProperty(key)) size++;
					}
				for (i=0; i<size; i++){  
					if (jsonitems[i]=='cssStyle'){
						var css = document.createElement("style");
						css.type = "text/css";
						if (css.styleSheet) css.styleSheet.cssText = jsonitems[i];
						else css.appendChild(document.createTextNode(jsonitems[i]));
						document.getElementsByTagName("head").appendChild(css);
						//console.log( jsonitems[2]);
						}
					else if (jsonitems[i]=='passfunct'){ 
						i++;
						if (jsonitems[i+1].indexOf('@x@')== -1){
							gen_Proc[jsonitems[i]](jsonitems[i+1]);
							i++;
							}
						else {
							var params=jsonitems[i+1].split('@x@'); 
							gen_Proc[jsonitems[i]].apply(this, params);
							i++;
							}
						}
					else if (jsonitems[i]=='passfunct2'){ 
						i++;
						window[jsonitems[i]](jsonitems[i+1]);  
						i++;   
						}
					else if (jsonitems[i]=='appendtop') {
						i++
						var mainobj=document.getElementById(jsonitems[i]);
						i++;  
						mainobj.innerHTML=jsonitems[i]+mainobj.innerHTML; 
						}
					else if (jsonitems[i]=='appendbottom') {
						i++;
						var mainobj=document.getElementById(jsonitems[i]);
						i++;  
						mainobj.innerHTML=mainobj.innerHTML+jsonitems[i]; 
						}
					else {  
						var mainobj=document.getElementById(jsonitems[i]);
						i++;  
						mainobj.innerHTML=jsonitems[i]; 
						}
					}//end for
				}//ajax repsonse.length
			else {
				if (this.ajax.responseText==='no return'){
					console.log( 'No Return Values Found in Database');
					}
				else if (this.ajax.responseText==='reBuffed'){
					console.log( 'reBuffed');
					}
				else if (this.ajax.responseText.length>0){
					console.log( this.ajax.responseText+' sent under 20');
					}
				else console.log( 'JasonReturn or mistake in handle replace');
				}
			 
			}//ready state
		},//end handle_replace
	handle_image	:  function () { 
		if ( (this.ajax.readyState == 4) && (this.ajax.status == 200) ) {
			if (this.ajax.responseText.length > 10) {
				console.log(this.ajax.responseText);  
 				var jsonitems = JSON.parse(this.ajax.responseText); 
				var ext=jsonitems[0];
				var tr=jsonitems[1];  
				if (jsonitems[2]=='body'){   
					var holderobj=document.getElementsByTagName("BODY")[0]
					}
				else {
					var holderobj=document.getElementById("holder_"+ext);
					}
				if (jsonitems[2]!='body'){  
					var h=holderobj.offsetHeight;
					var cmh=holderobj.style.minHeight;
					cmh=cmh.replace('px','');
					cmh=  cmh.strlen < 1 ? 0 :cmh;
					cmh = Math.max (cmh, h);
					holderobj.style.minHeight=cmh+'px';//stabilize the background height during transition
					}
				if (tr=='ajax_fade'){
					//allow time for fadein
					//setTimeout( function(){
					holderobj.innerHTML=jsonitems[3];
					fadeTo.fadeTo_init('holder_'+ext,500,0,100,2);
					//},75);					 
					}
				else {
					holderobj.innerHTML=jsonitems[3];
					fadeTo.setOpacity(holderobj,100);
					}
				//document.getElementById('goto_'+ext).focus();
				if (jsonitems[5] !=='undefined'){ 
					dataobj=document.getElementById(jsonitems[5]);
					document.body.style.backgroundImage=gen_Proc.getComputedStyle(dataobj,"background-image");
					document.body.style.backgroundColor=gen_Proc.getComputedStyle(dataobj,"background-color");
					dataobj.style.background='none';
					dataobj.style.border='none'; 
					}
				eval('fadeTo.preloading('+jsonitems[4]+')')
				}//response length
			else { 
				console.log( 'JasonMistake in handle');
				}
			}//ready state
		},//end handle_image
	locationAssign	:  function(url){  
		window.open(url)
		},
	alert : function(msg){
		alert(msg)
		},//testing aajax
	autoGrowFieldScroll	:  function(f) {  
		if (f.style.overflowY != 'scroll') f.style.overflowY = 'scroll';         
          var scrollH = f.scrollHeight;
		if(!f.style.height|| scrollH > f.style.height.replace(/[^0-9]/g,'') ){
			scrollit=scrollH+60;   
			f.style.height = scrollit+'px';  
			}
		 
		},//end autogrowfieldscroll function
	videoRespond	: function(f){ 
		var pwidth=Math.max(f.offsetWidth,f.clientWidth);
		var iObjs=f.getElementsByTagName('iframe');
		if (iObjs.length>0){
			var iObj=iObjs[0];
			var ratio=iObj.width/iObj.height
			iObj.width=pwidth;
			var h=pwidth/ratio
			iObj.height=h;
			}
		else {
			var iObjs2=f.getElementsByTagName('object');
			if (iObjs2.length>0){ 
				var iObj=iObjs2[0];  
				var ratio=iObj.width/iObj.height
				iObj.width=pwidth;
				var h=pwidth/ratio
				iObj.height=h; 
				var embedObjs=iObj.getElementsByTagName('embed');
				if (embedObjs.length>0){ 
					var embedObj=embedObjs[0];
					var ratio=embedObj.width/embedObj.height
					embedObj.width=pwidth;
					var h=pwidth/ratio
					embedObj.height=h;
					}
				}
			else{
				var iObjs3=f.getElementsByTagName('embed');
				if (iObjs3.length>0){ 
					var iObj=iObjs3[0];  
					var ratio=iObj.width/iObj.height
					iObj.width=pwidth;
					var h=pwidth/ratio
					iObj.height=h; 
					}
				}
			}
		},
	fadeIn	:  function(f){ 
		if (typeof f === "string"){
			var pid =  f 
			 }
		else if (f !== null &&typeof f === 'object'){
			var pid=f.id;
			}
		else return;
	 
		fadeTo.fadeTo_init(pid,500,0,100,2);
		},
	imageResponseBack 	:  function(f){  //background slideshow 
		var pwidth=Math.max(f.offsetWidth,f.clientWidth); 
		var oldWidth=f.getAttribute('data-wid');
		var maxcheck=Number(oldWidth) + pwidth/5;//for checking size range
		var mincheck=Number(oldWidth) - pwidth/15;
		//double check height to width of element regardless of resizing larger smaller  or changing image
		var aspect=f.getAttribute('data-asp');
		if (\$(f).hasClass('limit')) f.style.height=pwidth/aspect+'px';  
		if ( pwidth > maxcheck){ 
			 f.setAttribute('data-wid',pwidth);//update data-wid for future pwidth check
			var newWidth=gen_Proc.keyUp(pwidth,gen_Proc.image_response,gen_Proc.maxPicLimit);	
			var pattern=new RegExp(gen_Proc.image_response_dir_prefix+"[0-9]+\/");
			var imgarr = f.getElementsByTagName('span');//backauto within spans
			for (i=0; i < imgarr.length; i++){  
				oldUrl=imgarr[i].style.backgroundImage;   
				var newUrl = oldUrl.replace(pattern,gen_Proc.image_response_dir_prefix+newWidth+'/');
				//gen_Proc.picUrl=newUrl;  
				var pattern2=/url\((.*?)\)/;
				if (newUrl.match(pattern2)){ 
					var newSrc=newUrl.match(pattern2)[1];  
					re=/"/g
					newSrc=newSrc.replace(re,''); 
					if (gen_Proc.fileExists(newSrc)){   
					    url='url('+newSrc+')';
						imgarr[i].style.backgroundImage=url; //alert(url)
						}
					else { if (gen_Proc.Dev&&(gen_Proc.Edit||gen_Proc.Loc)) alert ('Ajax background image response creating '+gen_Proc.picSrc);
						var pattern=new RegExp(gen_Proc.auto_slide_dir);
						if (!newSrc.match(pattern)){
							var url = window.location.href.split('?')[0];
							gen_Proc.use_ajax(url+'?create_image2='+ gen_Proc.picSrc+'@@'+gen_Proc.imgSize+'&sess_token='+gen_Proc.token,'handle_replace','get'); 
							}
						if (gen_Proc.fileExists(newSrc)){  //after creating image try again...
							url='url('+newSrc+')';
							imgarr[i].style.backgroundImage=url;  
							f.setAttribute('data-wid')=pwidth;
							}
						}//else
					
					}//if regex match
				else alert ('nogex match')
				}//for loop
			} //max check  undersize
		},//end function 
	fileExists	:  function(file_url){ //http://stackoverflow.com/questions/18837735/check-if-image-exists-on-server-using-javascript
		var http = new XMLHttpRequest();
		http.open('HEAD', file_url, false);
		http.send();
		return http.status != 404;
		},
	imageExists : function(url, callback){//http://stackoverflow.com/questions/14651348/checking-if-image-does-exists-using-javascript
		var img = new Image();
		img.src = url;
		img.onload = function() { callback && callback(true); }; 
		img.onerror = function() { callback && callback(false); };
		},
	passvar	:  function(){ 
         var w =  document.URL ;
         if (location.search != "") {
               var x = location.search.substr(1).split("&");
               var z='Append Request is: '+x +   '     Full URL: '+w;
               while (z.indexOf('%20')!= -1){
                    z=z.replace('%20',' ');
                    }
               for  (i = 0; i < x.length; i++) {
                    var y = x[i].split("="); 
                    if (y[0] == 'passvar'||y[0] == '&passvar') { 
                         y[1] = y[1].substring(0, 15);
                         while ( y[1].indexOf('%20') != -1){
                              y[1] = y[1].replace('%20',' ');
                              }
                         alert("Message Alert " + y[1]);
                         }
				if (y[0] == 'msg'||y[0] == '&msg') {
					while ( y[1].indexOf('%20') != -1){
						y[1] = y[1].replace('%20',' ');
						}
					alert(y[1]);
					}
                    }
			}
         
          },
	keyDown  :	function(value,arr){  
		var prev=0;  
		for (i in arr){ 
			if (value > arr[i] ){
				 prev=arr[i]
				}
			else return prev;
			}
		return 0; 
		}, 
	keyUp  :	function(value,arr){
		max= 'nolimit';//= (arguments[2])?arguments[2]:'nolimit'; 
		
		var prev=0; 
		for (i in arr){
			if (arr[i] >=value){
				if (max  == 'nolimit' || arr[i] <= gen_Proc.maxPicLimit) 
					return arr[i];
				else return prev;
				}
			prev=arr[i]
			}
		return 0;//maxval
		}, 
	validateEmail	:  function(data){   
		var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;  
		if(emailPattern.test(document.getElementById(data.idVal).value)  === false)  {  
			document.getElementById(data.idVal).focus();
			alert('Email entered was:'+document.getElementById(data.idVal).value+' You Need A Valid Email Address');   
			return false;
			}
		else return true;
		},
	validateEntered	:  function(data){ 
		var myTextField = document.getElementById(data.idVal);
		if(myTextField.value == null || myTextField.value.length == 0 ) {
			myTextField.focus();
			 alert('Please fill in '+data.ref+ ' field');
			return false; 
			} 
		return true;
		},   
	refresh 	:  function (){  
		location.reload();
		},
	imageexpand	: function(mysrc,width,height){
		var img = new Image();
		img.src = mysrc;
		img.onload = function() { 
			\$('body').children().fadeTo(1000,0);
			setTimeout(function(){
			\$('body').children().fadeTo(0,0);
				\$('body').append('<div style="opacity:0;" id="coverall"><img src="'+mysrc+'" width="'+width+'" height="'+height+'"></div>'+ 
				'<script>'+
				'\$("#coverall").click(function(){'+
					'\$(this).fadeTo("1000",0);'+
					'setTimeout(function(){'+
						'\$("body").children().show(0);'+
						'\$("body").children().fadeTo(1000,1);'+
						'\$("#coverall").remove();}, 1000);})'+
				'<\/script>');//append
			\$("body").children().hide();
			\$("#coverall").fadeTo(750,1);
				
			\$("#coverall").hover(function() {
			\$(this).css('cursor','pointer');
			});
				},1000);//setTimeout
			}//end onload
		
		return false;
		},//end imageexpand
		imageexpand2	: function(mysrc,width,height){
		var img = new Image();
		img.src = mysrc;
		img.onload = function() { 
			\$('body').children().fadeTo(1000,0);
			setTimeout(function(){
			\$('body').children().fadeTo(0,0);
			var appenddiv='<div style="opacity:0;" id="coverall"><img src="'+mysrc+'" width="'+width+'" height="'+height+'"></div>';
			var appendscript='\$("#coverall").click(function(){'+
					'\$(this).fadeTo(1000,0);'+
					'setTimeout(function(){'+
						'\$("body").children().show(0);'+
						'\$("body").children().fadeTo(1000,1);'+
						'\$("#coverall").remove();}, 1000);}';
			\$('body').append(appenddiv);
			\$(function () {
			\$('<script>')
			.text(appendscript)
			.appendTo('body');
			})
			\$("body").children().hide();
			\$("#coverall").fadeTo(750,1);
				
			\$("#coverall").hover(function() {
			\$(this).css('cursor','pointer');
			});
				},1000);//setTimeout
			}//end onload
		return false;
		}//end imageexpand
	}//end gen_Proc
EOD;
     }//end  Gen Proc
    
    
function  edit_Proc(){
$this->javascript.= <<<EOD
var edit_Proc = {
	beforeSubmit	:  function () {  
		var getInputs = document.getElementsByTagName("input");
		var getSelects = document.getElementsByTagName("select");
		var getTexts = document.getElementsByTagName("textarea");
		var inputnum=0,selectnum=0,textnum=0,radionum=0,checknum=0;
		
		for(var i = 0; i < getTexts.length; i++) {
			var obj = getTexts[i];
			if (obj.className.indexOf("llowthis")>0) {
				//do nothing
				}
			else if(obj.value == obj.defaultValue){
				if (obj.className.indexOf("mytextarea")<0) getTexts[i].disabled = true;
				textnum++;
				} 
			}
		for(var i = 0; i < getSelects.length; i++) { 
			var obj = getSelects[i];
			if (obj.className.indexOf("llowthis")>0) {
				//do nothing
				}
			else if (obj.selectedIndex == 0){
				getSelects[i].disabled = true;
				selectnum++
				}
			}
		for(var i = 0; i < getInputs.length; i++) { 
               var obj = getInputs[i];
               if(obj.type ==='hidden' ){
				getInputs[i].disabled = false;
				inputnum++;
				}
			if (obj.className.indexOf("llowthis")>0) {
				getInputs[i].disabled = false;
				}
			else if(obj.type=="radio" && obj.checked != obj.defaultChecked){
				getInputs[i].disabled = false;
				radionum++;
				}
			else if(obj.type=="checkbox" && obj.checked != obj.defaultChecked){
				 getInputs[i].disabled = false;   
				checknum++;
				}
			else if(obj.type !='hidden' && obj.type !='submit' && obj.type !='SUBMIT' &&obj.value == obj.defaultValue){
				getInputs[i].disabled = true;
				inputnum++;
				}
			}
		return true;
		},//end beforeSubmit
	checkpdffiles  :  function (f,max,idn){ 
          if (!edit_Proc.checkUploadFile(idn,max))return false;
          f = f.elements;
          if(/.*\.(pdf)$/.test(f["upload"].value.toLowerCase())){ 
               return true;
              }
          alert("file chosen is " + f["upload"].value + " Please Upload .pdf Files Only.");
          f["upload"].focus();
          return false;
          },//end js function 
     checkVidFile : function(f,max,idn){ 
          if (!edit_Proc.checkUploadFile(idn,max))return false;
          f = f.elements; 
          if(/.*\.(mp4)|(ogg)|(m4v)|(webm)|(zip)$/.test(f["upload"].value.toLowerCase()))
                 return true; 
          alert("file chosen is " + f["upload"].value + " Please Upload mp4, ogg, m4v, webm  filetypes extension Only.");
          f["upload"].focus();
          return false;
          },//end js function
     checkPicFiles  :  function (f,max,idn){ 
          if (!edit_Proc.checkUploadFile(idn,max))return false; 
          f = f.elements;
          if (!arguments[3]){
               if(/.*\.(gif)|(jpeg)|(jpg)|(svg)|(jpg)|(png)$/.test(f["upload"].value.toLowerCase())){
                    return true;
                    }
               alert("file chosen is " + f["upload"].value + " Please Upload gif,jpg, png, svg, tif Image Files Only.");
               f["upload"].focus();
               return false;
               }
         else  {
               if(/.*\.(gif)|(png)$/.test(f["upload"].value.toLowerCase())){
                    return true;
                    }
               alert("file chosen is " + f["upload"].value + " Please Upload gif or png Image Files Only.");
               f["upload"].focus();
               return false;
               }
          },//end js function
     checkUploadFile  : function (idn,max){ 
          if(window.ActiveXObject){
               var fso = new ActiveXObject("Scripting.FileSystemObject");
               var filepath = document.getElementById(idn).value;
               var thefile = fso.getFile(filepath);
               var size  = thefile.size;
               if (size>max){
                    alert("File " + thefile.name + " is " + size + " bytes in size which is greater than the limit of "+max);
                    return false;
                    }
               return true;
               }
          else{
               var input, file;
               if (!window.FileReader) {
                    alert("The file API for checking upload filesizes isn't supported on this browser yet.");
                    return;
                    } 
               input = document.getElementById(idn);
               if (!input) {
                    alert("Um, couldn't find the fileinput element.");
                    }
               else if (!input.files) {
                    alert("This browser doesn't seem to support the files property of file inputs.");
                    }
               else if (!input.files[0]) {
                    alert("Please select a file before submitting");
                    }
               else {
                    file = input.files[0];
                    if (file.size > max){
                         alert("File " + file.name + " is " + file.size + " bytes in size which is greater than the limit of "+max);
                         return false;
                         }
                    return true; 
                    }
               }//no activex
         },//end js function
     imageSelectMaster	:  function(obje,cid,name,bg_ref){ 
		document.getElementById(name).style.display='block';
		document.getElementById('dis_'+name).style.display='none';
		document.getElementById('show_'+name).style.display='block';
		var selected = obje.options[obje.selectedIndex].value;
		 var url = window.location.href.split('?')[0];
		 var url = url.split('#')[0];
		gen_Proc.use_ajax(url+'?imageChoiceMaster='+selected+'@@'+bg_ref+'@@'+cid,'handle_replace','get'); 
		},
	imageSelectGallery	:  function(obje,cid,name,bg_ref){ 
		document.getElementById(name).style.display='block';
		var selected = obje.options[obje.selectedIndex].value; 
		var url = window.location.href.split('?')[0];
		gen_Proc.use_ajax(url+'?imageSelectGallery='+selected+'@@'+cid,'handle_replace','get'); 
		},	
	enableTiny	: function(mObj,mId,rClass){
		mObj.style.background='green';
		mObj.style.color='white';
		mObj.innerHTML="Click Text";
		rObj=document.getElementById(mId);
		rObj.className=rObj.className.replace(rClass,'enableTiny');
		if (rObj.style.display=='none'){
			alert('click this button before clicking on Text for TinyMce to work!!! Refresh Page or Submit Other Changes to try again.');
			return;
			}
		else {
			var editor = tinymce.EditorManager.createEditor(mId,tinymce.settings);
			editor.render();
			}
		},
	sendGallOrder	: function(item) {
		var msg='Changes are immediate and your Gallery Order has been Updated. Refresh in editmode or submit other changes then view Webpage to see' ;
		var junkdrawer = ToolMan.junkdrawer()
		var group = item.toolManDragGroup
		var list = group.element.parentNode ; 
		var id = list.getAttribute("id")
		var bid = edit_Proc.sortDataId
		var inc = edit_Proc.sortDataInc
		var url = window.location.href.split('?')[0];
		if (bid == null || inc == null){
			alert('get Data attribute Fail. For editing try different Modern Browser for best results')
			return
			}
		if (id == null ){
			alert('get Id Fail. For editing try different Modern Browser for best results')
			return
			}
		group.register('dragend', function() {  
			junkdrawer.ajaxSort("gall_sort",id,url,bid,"updateGallMsg_"+ inc, msg);
			})  
		},
	sendSlideOrder	: function(item) {
		var msg='Changes are immediate and your Slide Show Order has been Updated. Refresh to see' ;
		var junkdrawer = ToolMan.junkdrawer()
		var group = item.toolManDragGroup
		var list = group.element.parentNode ; 
		var id = list.getAttribute("id")
		var bid = edit_Proc.sortDataId
		var inc = edit_Proc.sortDataInc
		var url = window.location.href.split('?')[0];
		if (bid == null || inc == null){
			alert('get Data attribute Fail. For editing try different Modern Browser for best results')
			return
			}
		if (id == null ){
			alert('get Id Fail. For editing try different Modern Browser for best results')
			return
			}
		group.register('dragend', function() {  
			junkdrawer.ajaxSort("auto_sort",id,url,bid,"updateMsg_"+ inc, msg);
			})  
		},
	sendEditOrder	: function(item) {
	// Modified implementation of tool-man  dragsort related  js created by Tim Taylor Consulting <http://tool-man.org/>
		var msg='Changes are immediate and your Editor Color Order has been Updated. Refresh page or submit other changes to View the new order' ;
		var junkdrawer = ToolMan.junkdrawer()
		var group = item.toolManDragGroup
		var list = group.element.parentNode ; 
		var id = list.getAttribute("id")
		var bid = edit_Proc.sortDataId
		var url = window.location.href.split('?')[0];
		if (bid == null){
			alert('get Data attribute Fail. For editing try different Modern Browser for best results')
			return
			}
		if (id == null ){
			alert('get Id Fail. For editing try different Modern Browser for best results')
			return
			}
		group.register('dragend', function() {  
			junkdrawer.ajaxSort("pageEd_sort",id,url,bid,"updatePageEdMsg",msg);
			})  
		}, 
	makelistSortable	: function(o,func) {
		// Modified implementation of tool-man  dragsort related  js created by Tim Taylor Consulting <http://tool-man.org/>  
		edit_Proc.sortDataId=o.getAttribute('data-id');
		edit_Proc.sortDataInc=o.getAttribute('data-inc')
		dragsort.makeListSortable(o,func) 
		},
	divTextArea	: function(elem){
		gen_Proc.addEvent(elem, 'click', function(){
			var pattern = new RegExp('divTextArea'); 
			if (!elem.className.match(pattern))return; //editor initiated 
			var textArea=elem.parentNode.getElementsByTagName('textarea')[0];
                textArea.style.display = "block";
			gen_Proc.autoGrowFieldScroll(textArea);
			elem.style.display = "none";  
			})
		},   
	showhide	:  function(obje,ele){   
		if (typeof ele === "string"){
			var obid =  (ele == 'body') ? document.getElementsByTagName("body")[0] : document.getElementById(ele)
			//var elem=document.getElementById(ele)
			}
		else if (ele !== null &&typeof ele === 'object'){
			var obid=ele;
			}
		else return;
		var close='Close ';
		if(obje.style.display=="block"){
			obje.style.display ="none";
			if (obid.innerHTML.indexOf(close)!=-1){
				html=obid.innerHTML;
				html=  html.split(close);
				obid.innerHTML=html[1]
				}
			}
		else{
			if (obid.innerHTML.indexOf(close)==-1){  
                        html=obid.innerHTML;
                        obid.innerHTML=close+html
                        }
               obje.style.display ="block";
			}
		},//end showhide function
	getTags	:  function(searchClass,funct,refid){    
		var classact   = document.getElementsByTagName('*');
		var pattern = new RegExp('(^|\\\s)'+searchClass+'(\\\s|$)');  
		var collect=[]; 
		for (i = 0,j=0; i < classact.length; i++) {
			var act=classact[i] 
			if (!act.className.match(pattern) )continue;
			collect[j]=act; j++ 
			if (funct !==null){ //console.log(act)
				 edit_Proc[funct](act,refid);
				}
			}
		if    (funct==null) return collect;
			
		},//end getTags func
	oncheck	:  function(idname,msg){ 
		if (document.getElementsByName(idname).length===0){
			alert('named not present');
			}  
		for (i = document.getElementsByName(idname).length - 1; i >= 0; i--) { 
		    if (document.getElementsByName(idname)[i].checked) {  
				alert (msg);
				break;
				}
			}
		},//end oncheck
	displaythis  : function(id){  
		document.getElementById(id).style.display="block";
		if (arguments[1]){
			//color=(arguments[2])?arguments[2]:'#fdf0ee';
			//document.getElementById(id).style.backgroundColor=color;
			//arguments[1].style.backgroundColor=color;
			}
		}//end displaythis 
	}//end edit_Proc
EOD;
    }//end php function edit_Proc
    
function confirmAction() {   
    $this->javascript.= <<<EOD
    function confirmAction(msg) {
          return confirm(msg);  
          }//end js function
EOD;
    }//end php function

function focusme(){
    $this->javascript.= <<<EOD
function focusme(){
    document.getElementById("focuscursor").focus();
    }//end js function
EOD;
    }//end php function

function checkUploadFile(){
	//https://stackoverflow.com/questions/3717793/javascript-file-upload-size-validation
    $this->javascript.= <<<EOD
function checkUploadFile(max){ 
	if(window.ActiveXObject){
		var fso = new ActiveXObject("Scripting.FileSystemObject");
		var filepath = document.getElementById('fileinput').value;
		var thefile = fso.getFile(filepath);
		var size  = thefile.size;
		if (size>max){
			alert("File " + thefile.name + " is " + size + " bytes in size which is greater than the limit of "+max);
			return false;
			}
		return true;
		}
	else{
		var input, file;
		if (!window.FileReader) {
			alert("The file API for checking upload filesizes isn't supported on this browser yet.");
			return;
			} 
		input = document.getElementById('fileinput');
		if (!input) {
			alert("Um, couldn't find the fileinput element.");
			}
		else if (!input.files) {
			alert("This browser doesn't seem to support the files property of file inputs.");
			}
		else if (!input.files[0]) {
			alert("Please select a file before submitting");
			}
		else {
			file = input.files[0];
			if (file.size > max){
				alert("File " + file.name + " is " + file.size + " bytes in size which is greater than the limit of "+max);
				return false;
				}
			return true; 
			}
		}//no activex
    }//end js function
EOD;
    }//end php function


    
function checkVidFile(){ 
    $this->javascript.= <<<EOD
 
function checkVidFile(f,max){
	if (!checkUploadFile(max))return false;
	f = f.elements; 
	if(/.*\.(mp4)|(ogg)|(m4v)|(webm)|(zip)$/.test(f["upload"].value.toLowerCase()))
	 return true; 
	alert("file chosen is " + f["upload"].value + " Please Upload mp4, ogg, m4v, webm  filetypes extension Only.");
	f["upload"].focus();
	return false;
     }//end js function
EOD;
    }//end php function

function checkPicFiles(){
    $this->javascript.= <<<EOD
function checkPicFiles(f,watermark,max){
	if (!checkUploadFile(max))return false;
	f = f.elements;
	if (!watermark){
		if(/.*\.(gif)|(jpeg)|(jpg)|(svg)|(jpg)|(png)$/.test(f["upload"].value.toLowerCase())){
			return true;
			}
		alert("file chosen is " + f["upload"].value + " Please Upload gif,jpg, png, svg, tif Image Files Only.");
		f["upload"].focus();
		return false;
		}
    else  {
		if(/.*\.(gif)|(png)$/.test(f["upload"].value.toLowerCase())){
			return true;
			}
		alert("file chosen is " + f["upload"].value + " Please Upload gif or png Image Files Only.");
		f["upload"].focus();
		return false;
		}
    }//end js function
EOD;
    }//end php function
 
 
 function checkNum(){
    $this->javascript.= <<<EOD
function checkNum(id,range1,range2){ 
	 val=getElementById(id).value;
	 if (true) alert ('Your Value Must Be a Number Between '+ range1+' and '+range2);
	 else if (val < range1)
	 	alert('Your Number Must Be At Least '+ range1+ 'Or Greater');
      else if (val > range2)
	 	alert('Your Number Must Be Equal To OR Less Than '+ range2);
    }//end js function
EOD;
    }//end php function
    
    
 function Checkzipfiles(){
    $this->javascript.= <<<EOD
function Checkzipfiles(f){
    f = f.elements;
    if(/.*\.(zip)|(gz)|(bz)|(bz2)$/.test(f["upload"].value.toLowerCase())){
	   return true;
	   }
    alert("file chosen is " + f["upload"].value + " Please Upload zip Files Only.");
    f["upload"].focus();
    return false;
    }//end js function
EOD;
    }//end php function
    
function reloadit(){
    $this->javascript.= <<<EOD
function reloadit() { alert('reloading');
    checkit = self.location.href;
    if(!checkit.match('##'))  {
	   window.location.replace(checkit + '#');
	   document.location.reload();   
	   }
    }//end js function
EOD;
    }//end php function

function autoShow(){
$this->javascript.= <<<EOD
var slideAuto =  {
	endcount :  0, 
	count :  0,   
	preload : 1, 
	imageAdjust : 1,
	slideAuto_init: function(l){ 
	this.bigname_array=l.split(',');
	this.endcount=this.bigname_array.length;
	var self = this;
	self.nextPhoto();//optionally javascript replace initially pic!
	setInterval( function() { self.reinitImage(this.currentPicLink)} ,this.time);
	}, 
reinitImage : function(f ) {
	this.time=this.timeout //replace in case of xhr response
	this.flag = 0;
	this.pic_order = f;   
	this.delta=-2
	this.opacity = 99.99;
	//delta will be sent neg for slide show...  so will be same photo at 100% then will be taken down by fadeimage to below 30... next image will come
	// next image will be taken up positive to 100% 
	this.fadeImage();
	},
setOpacity : function setOpacity(a, b) {
	b = b > 99.99 ? 100 : b;
	a.style.filter = "alpha(opacity:" + b + ")";
	a.style.KHTMLOpacity = b / 100;
	a.style.MozOpacity = b / 100;
	a.style.opacity = b / 100
	},
fadeImage : function() {  
	if (this.opacity >= this.minOpac  && this.opacity < 100.1){ //keep going
		this.setOpacity(document.getElementById(this.imgId), this.opacity); 
		this.opacity += this.delta;
		var self = this;
		setTimeout(function(){self.fadeImage();},this.delay);
		} // 
	else { 
		if (this.flag == 0)  this.nextPhoto();
			else this.moveOn(); 
		}
	},
moveOn : function() {    
	if (this.opacity < this.minOpac && this.flag==1 ) alert('problem');
	},
nextPhoto : function() {
	this.flag = 1;
	this.delta = 2;   
	this.opacity = this.minOpac;   
	this.currentPicLink += 1
	this.currentPicLink > this.endcount - 1 && (this.currentPicLink = 0);
	this.currentPicLink == this.endcount - 1 && (this.preload = 0);
	//this.currentPicLink < 0 && (this.currentPicLink = this.endcount - 1); 
	var currWidth=Math.max(document.getElementById(this.divId).offsetWidth,document.getElementById(this.divId).clientWidth);
     var pN=document.getElementById(this.autoImgContain);
     var pObj=document.getElementById(this.imgId);  //buffer transition
     currHeight=Math.max(pObj.offsetHeight,pObj.clientHeight);
	pN.style.height=currHeight+'px';
     currWidth=Math.max(pObj.offsetWidth,pObj.clientWidth);
	pN.style.width=currWidth+'px';
     var calcDir=gen_Proc.keyUp(currWidth,gen_Proc.image_response,gen_Proc.maxPicLimit);	
	var a = new Image();
	a.src = this.dir + gen_Proc.image_response_dir_prefix+calcDir+'/'+ this.bigname_array[this.currentPicLink];
	slideAuto.calcDir=calcDir; 
	slideAuto.dir=this.dir + gen_Proc.image_response_dir_prefix+calcDir+'/'
	slideAuto.picname=this.bigname_array[this.currentPicLink];
	gen_Proc.imageExists2(a.src,function(exists){
		if (!exists){
			var url = window.location.href.split('?')[0];
			gen_Proc.use_ajax(url+'?create_image='+ slideAuto.picname+'@@'+slideAuto.calcDir+'@@'+slideAuto.dir+'&sess_token='+gen_Proc.token,'handle_replace','get'); 
			}
		}) 
	 this.preload==1 && (b.src= this.dir + gen_Proc.image_response_dir_prefix+calcDir+'/'+  this.bigname_array[this.currentPicLink]);
	var imgHeight = a.height;  
	var imgWidth = a.width;
	var imgRatio=a.width/a.height;
	//var b = (this.maxHeight-imgHeight) / (this.maxHeight*2)*this.percentHeight;
	//var c =  imgWidth/this.maxWidth*this.widMaxPercent;
	containImgObj=document.getElementById(this.autoImgContain)
	var info=gen_Proc.max_width(currWidth-this.shadowcalc,imgRatio,this.minAspect,this.maxAspect);
	var padTop=info.pt;
	var maxPicWidth=info.wa;
	containImgObj.style.maxWidth=maxPicWidth+'px';
	var inner = '<img class="'+this.picClass+'"  style="text-align:center;margin-top:'+padTop+'px;margin-bottom:'+padTop+'px; filter:alpha(this.opacity='+this.opacity+');this.opacity:.'+this.opacity+';" src="' + a.src + '"  id="' + this.imgId + '"  title="Navigation menu up on photo" alt="' + this.bigname_array[this.currentPicLink].substr(0, 20) + '">';
	document.getElementById(this.autoImgContain).innerHTML = inner;
	this.setOpacity(document.getElementById(this.imgId), this.opacity);
	this.fadeImage();
     pN.style.width='100%';//return in case of resize
     pN.style.height='auto';//return in case of resize
	},
preload : function() {
	var a = [];
	for(x = 1;x < arguments.length;x++) { 
		a[x] = new Image, a[x].src = this.dir + arguments[x] ; 
		}
	}
}
EOD;
 }//end function

function fadeTo(){
$this->javascript.= <<<EOD
	var fadeTo = {  
	fadeTo_init   :  function (eleId,duration,bo,eo,delta){
		if (typeof eleId === "string"){ 
			var elemObj =  (eleId === 'body') ? document.getElementsByTagName("BODY")[0] : document.getElementById(eleId)
			if (elemObj === null || typeof elemObj !== 'object'){
				alert('no obj from string')
				return
				}
			}
		else if (eleId === null){
			alert( 'isnot obj');
			return;
			}
		else if (typeof eleId ==='object') elemObj=eleId;
		else {
			alert('missed all');
			return;
			}
		
		this.imgId=eleId;//used as is
		this.delta=delta
		this.opac=bo
		this.endopac=eo
		this.setOpacity(elemObj,this.opac);//make sure initialized
		var diff = delta > 0 ? eo - bo : bo - eo;
		this.delay = duration/(diff/delta)
		this.changeOpac()
		},
	changeOpac : function () {
		if ((this.opac > this.endopac && this.delta < 0 ) || (this.opac <  this.endopac && this.delta > 0 )){ //keep going
		  	this.setOpacity(document.getElementById(this.imgId), this.opac);
			this.opac += this.delta;
			window.setTimeout(function(){fadeTo.changeOpac();},this.delay);
			} 
		},
	setOpacity :  function (a, b) {  //alert(b+' is b '+a.id);
		b = b == 100 ? 99.999 : b;
		a.style.filter = "alpha(opacity:" + b + ")";
		a.style.KHTMLOpacity = b / 100;
		a.style.MozOpacity = b / 100;
		a.style.opacity = b / 100
		},	
	preloading  : function () { 
		var a = [];
		for(x = 0;x < arguments.length;x++) {  
			a[x] = new Image, a[x].src = arguments[x]
			//console.log(a[x].src+ ' is preloading');
			}
		}
	}
EOD;
    }//end function fadeto setOpacity   

function plus(){//used on video adder
    $this->javascript.= <<<EOD
function plus(id,msg){  
     if(document.getElementById(id+ "t").style.display=="block"){
          document.getElementById(id+"t").style.display ="none";
          //document.getElementById(id).style.textDecoration = 'none';
          document.getElementById(id).innerHTML =msg;
          document.getElementById(id).style.borderColor='initial';
          window.scrollBy(0, 500);
          document.getElementById(id+"f").focus();
          }
      else{
          document.getElementById(id+"t").style.display ="block";
          document.getElementById(id).style.textDecoration = 'underline'; 
          document.getElementById(id).innerHTML ='<span class="redbackground white">Close </span>'+ msg;
          document.getElementById(id).style.borderColor='red';
          document.getElementById(id+"f").focus();
          }
    }//end js function   
EOD;
    }//end php function       
 
} //end class  
?>