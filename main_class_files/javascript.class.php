<?php
#ExpressEdit 3.01
#see top of global edit master class for system overview comment dir..
/*
ExpressEdit is an integrated Theme Creation CMS
	Copyright (c) 2018  expressedit.org 

  This program is free software: you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation, either version 3 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program. If not, see <https://www.gnu.org/licenses/>.*/
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
	//however the following animationfuncts & double top load  prior to onload
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
     ;(function(jQuery, window, document, undefined) {
          jQuery.fn.doubleTapToGo = function(action) {
               if (!('ontouchstart' in window) &&
                    !navigator.msMaxTouchPoints &&
                    !navigator.userAgent.toLowerCase().match( /windows phone os 7/i )) return false;
               if (action === 'unbind') {
                    this.each(function() {
                         jQuery(this).off();
                         jQuery(document).off('click touchstart MSPointerDown', handleTouch);	
                    });
               }
          else {
               this.each(function() {
                    var curItem = false;
                    jQuery(this).on('click', function(e) {
                         var item = jQuery(this);
                         if (item[0] != curItem[0]) {
                              e.preventDefault();
                              curItem = item;
                              }
                         });
                    jQuery(document).on('click touchstart MSPointerDown', handleTouch); 
                    function handleTouch(e) {
                         var resetItem = true,
                              parents = jQuery(e.target).parents();
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
     jQuery(function(){
          function is_touch_device() {//ie modernizer excerp from stack overflow
               try {  
                    document.createEvent("TouchEvent");  
               return true;  
               } catch (e) {  
                 return false;  
               }  
             }
          gen_Proc.xmlCount=0;
          var resizeTimerMain='';
          window.USER_IS_TOUCHING=false; 
          if (!gen_Proc.Edit) gen_Proc.scrollAnimate();
          if (!gen_Proc.Edit) gen_Proc.scrollFadeInOut();
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
          if (gen_Proc.Edit)gen_Proc.tinyEditResponse();
          else gen_Proc.tinyResponse();     
          gen_Proc.classPass('backauto',gen_Proc.imageResponseBack); 
          gen_Proc.classPass('grid',gen_Proc.gridWidth); 
          gen_Proc.classPass('video-back-container',gen_Proc.videoResponseBack);
          gen_Proc.classPass('fadein',gen_Proc.fadeIn);
          gen_Proc.classPass('imagerespond',gen_Proc.imageResponse); 
          gen_Proc.classPass('page_options_hidefont',gen_Proc.showIt); 
          var winMaxWidth = jQuery(window).width();
          var winWid=winMaxWidth;
          document.cookie='dpiRatio='+ gen_Proc.dpiRatio || 1+"; path=/";  
          document.cookie='clientW='+winMaxWidth+"; path=/";
          document.cookie='screenW='+screen.width+','+screen.height;
          window.addEventListener('resize', function(){
			gen_Proc.vpw = jQuery(window).width(),
               gen_Proc.displayWindowSize('displayCurrentSize',gen_Proc.vpw);
               clearTimeout(resizeTimerMain);
               resizeTimerMain = setTimeout(function(){ //
                    var nw=jQuery(window).width();
                    if ( winMaxWidth >150 && winMaxWidth < nw){
                         gen_Proc.classPass('backauto',gen_Proc.imageResponseBack);//background slideshow
                         gen_Proc.classPass('imagerespond',gen_Proc.imageResponse);
                         gen_Proc.classPass('carouselrespond',gen_Proc.carouselResponse);
                         gen_Proc.classPass('sliderespond',gen_Proc.imageResponse);  
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
          gen_Proc.displayWindowSize('displayCurrentSize',gen_Proc.vpw);  
          gen_Proc.passvar();
          gen_Proc.destructor();
          });
	
EOD;
	}//end onload
   
function onload_edit(){//additional onload for editmode
$this->javascript.= <<<EOD
jQuery(function () { 
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
     webmodeError : [],
     webmodeImageError : [],
     webmodeCarouselError : [],
     webmodeImageErrorBack :  [],
     webmodeColl  : [],
     vpw : jQuery(window).width(),
     url : window.location.href.split('?')[0].split('#')[0],
     zInc      : 0,
	classPass  :  function(cname,fn){//use getalltags if multiple classes used for element 
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
		jQuery('#'+id).attr('data-duration', 'finished');
		},delay*1000)
		},
	animateFollow :  function(id,rm,add,delay,inc,display){
		setTimeout(function(){  
		//jQuery('#'+id).removeClass(rm);//not necessary
		jQuery('#'+id).addClass(add);
		jQuery("body").css("overflow", "auto");
		},delay)
		if (display === 'displaynone'){
			setTimeout(function(){
				jQuery('#'+id).hide('1000');
				setTimeout(function(){ 
					var \$window = jQuery(window);
					\$window.trigger('scroll');
					jQuery('#'+id).attr('data-status', 'finished'); 
					},'1000')
				},(delay+inc))
			}
		else if (display === 'visibleoff'){
			setTimeout(function(){
				jQuery('#'+id).addClass('fadeOut hidden');
				setTimeout(function(){ 
					var \$window = jQuery(window);
					\$window.trigger('scroll');
					jQuery('#'+id).attr('data-status', 'finished');
					},'1000')
				},(delay+inc))
			}
		else {
			setTimeout(function(){ 
				jQuery('#'+id).attr('data-status', 'finished');  
				},(delay+inc))
			}
		},//end function
	animateFinish :  function(id,delay,display){
		setTimeout(function(){   
		jQuery("body").css("overflow", "auto");
		},delay)
		if (display === 'displaynone'){
			setTimeout(function(){
				jQuery('#'+id).hide('1000');
				setTimeout(function(){ 
					jQuery(window).trigger('scroll');
					jQuery('#'+id).attr('data-status', 'finished');
					},'1000')
				},delay)
			}
		else if (display === 'visibleoff'){
			setTimeout(function(){
				 jQuery('#'+id).addClass('fadeOut hidden');
				setTimeout(function(){ 
					jQuery(window).trigger('scroll');
					jQuery('#'+id).attr('data-status', 'finished');
					},'1000')
				},delay)
			}
		else {
			setTimeout(function(){ 
				jQuery('#'+id).attr('data-status', 'finished');
				},delay)
			}    
		},//end function
	scrollAnimate :  function(){//adapted from: George Martsoukos  www.sitepoint.com
          var sizeTimerScroll='';
          var lastScrollTop=0;
          jQuery(window).on('scroll resize', function(){   
               clearTimeout(sizeTimerScroll);
               sizeTimerScroll = setTimeout( () => { //
                    var st = jQuery(this).scrollTop();
                    if (st > lastScrollTop)
                         gen_Proc.check_if_in_view('down');
                    else gen_Proc.check_if_in_view('up');
                    lastScrollTop = st;
                    },40);
               });       
		jQuery(window).trigger('scroll');
		},
     scrollFadeInOut :  function(){// 
		\$scroll_elements = jQuery('.scrollFade');
		var \$window = jQuery(window);
		\$window.on('scroll resize', gen_Proc.check_fade_view); 
		\$window.trigger('scroll');
		},
     check_fade_view   : function () {
          var window_height = jQuery(window).height();
		\$scroll_elements = jQuery('.scrollFade');
		var window_top_position = jQuery(window).scrollTop();
		var window_bottom_position = (window_top_position + window_height);
		jQuery.each(\$scroll_elements, function(i) {
			var elem = jQuery(this)
			var hattr=elem.attr('data-scrollchange');
               var attrArr=hattr.split('@');
               var hchange=parseInt(attrArr[0]);
               var helem=document.getElementById(attrArr[1]);
               var element_height = elem.outerHeight(true); 
               var element_top_position = helem.offset().top;
               var element_bottom_position = (element_top_position + element_height);
               var height_change = (hchange * element_height/100); 
               if ((element_bottom_position  >= window_top_position ) &&
                    (element_top_position +height_change <= window_bottom_position)) {
                    elem.addClass('in-view'); 
                    elem.removeClass('animated');
                    }
               });
          },
	check_if_in_view  :	function (dir) {//adapted from: George Martsoukos  www.sitepoint.com
          var \$animation_elements = jQuery('.animated');
		var window_height = jQuery(window).height();
		var window_top_position = jQuery(window).scrollTop();
		var window_bottom_position = (window_top_position + window_height);
		jQuery.each(\$animation_elements, function(i) {
			var elem = jQuery(this);  
			if (typeof(elem.attr('data-hchange'))!== 'undefined'){
                    var hchange =elem.attr('data-hchange');}
               else var hchange=30;
               if (hchange ==='none'){ 
                    //disregard hlock experimental
                    elem.addClass('in-view'); 
				elem.removeClass('animated');
                    }
               else {
                   hchange=parseInt(hchange);
                    //#hlock experimental only..
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
                              \$animation_elements=jQuery(".animated");//update to remove this one
                         }
                    elem.on( 'DOMMouseScroll mousewheel', function ( event ) {
                    //stack overflow:questions/7154967/how-to-detect-scroll-direction/33334461#33334461
                    if( event.originalEvent.detail > 0 || event.originalEvent.wheelDelta < 0 ) { //alternative options for wheelData: wheelDeltaX & wheelDeltaY
                         //scroll down 
                         }
                    else {//scroll up
                         if (hlock >0){
                              hlock=0;
                               elem.attr('data-hlock',0);
                              jQuery("body").css("overflow", "auto"); //release scroll lock
                              }
                         }
                    //prevent page fom scrolling 
                    });
                    if (hlock>0 && element_bottom_position +20 <= window_bottom_position && elem.attr("data-duration")==='finished') {
                         \$animation_elements=jQuery(".animated");//update to remove obj
                         jQuery("body").css("overflow", "hidden");  
                         setTimeout(function(){ 
                          elem.attr('data-hlock',0);//set to 0 so as not to hlocking
                          jQuery("body").css("overflow", "auto");  
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
     openIt  : function(ele){  
          document.getElementById(ele).style.display="block";
          },
     toggleIt  : function(ele){ 
          obj=document.getElementById(ele);
          if (obj.style.display !=="block") 
               obj.style.display ="block";
          else { 
               obj.style.display="none";
               }
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
		var type=f.getAttribute('data-type');
		var rwd=f.getAttribute('data-rwd');
		//scroll set with css in height function
		 if (type!='video')
			 f.style.height=((pwidth/initWid*dataH)<=dataH)?Math.max((pwidth/initWid*dataH),minHeight)+'px':dataH+'px';//changes according to current wid...
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
			img.src=newSrc;
               img.onload = function() {
                     if ('naturalHeight' in this) {
                          if (this.naturalHeight + this.naturalWidth === 0) {
                               this.onerror();
                               return;
                               }
                          }
                     else if (this.width + this.height == 0) {
                          this.onerror(); 
                          };
                    
                    img.src=newSrc;
                    img.w=newWidth*1.25;
                    img.h=img.w/ratio;
                    };
               img.onerror = function() {
                    var id=jQuery(this).closest('.image.post').attr('id');
                    var pattern=new RegExp(gen_Proc.image_response_dir_prefix+"[0-9]+\/");
                    var newSrc = oldSrc.replace(pattern,gen_Proc.image_response_dir_prefix+newWidth+'/'); 
                    if (this.src != newSrc)
                         this.src=newSrc;
                    gen_Proc.webmodeImageError.push('Error Gallery Image missing fn; '+newSrc+'in psImageResponse Gallery id: '+id);
                    }
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
     tinyEditResponse   : function(){
          var classes=document.querySelectorAll('.text.post');
          var minW=parseInt(gen_Proc.tiny_cache[0]);
          var collect = [];
          var data_attr=[]; 
          for (i=0;i < classes.length; i++){
               var cls =classes[i];
               var imgs= cls.getElementsByTagName('img'); 
               for (ii=0;ii < imgs.length; ii++){
                    var myimg=imgs[ii];
                    var oldSrc=myimg.getAttribute('src');
                    var fn = oldSrc.split('/').slice(-1)[0];
                    var Pattern = new RegExp(gen_Proc.tiny_orig_sz_dir);
                    //data-upwidth_tiny gives us the maximum uploaded image width..
                    //the uploaded size is used when it is smaller than the first (smallest) of the stipulated cache sizes.  If tiny_cache sizes change so that tiny_orig_sz image is larger than a cache size that is over the Cfg::Tiny_cache_min than we need to change startup initial direcory size to tiny_cache_resize with Cfg::Tiny_cache_min subdir size setting..
                    if(Pattern.test(oldSrc)){
                         if (myimg.hasAttribute('data-upwidth-tiny')){
                              var w=parseInt(myimg.getAttribute('data-upwidth-tiny'));
                              if (w > minW){ //chng src...
                                   var newSrc = oldSrc.replace(Pattern,gen_Proc.tiny_resize_dir+gen_Proc.tiny_cache_min+'/');
                                   myimg.setAttribute('src',newSrc);// new src needs to be updated by submit  therefore push into data_attr list for submitting to update src..
                                   myimg.setAttribute('data-mce-src',newSrc);//set to adjust the tinymce added attribute
                                   var key = fn;
                                   var obj = {};
                                   obj[key] = myimg.getAttribute("src")  
                                   data_attr.push(obj); //here we make list of necessary data-upwidth-tiny attribute changes
                                   }
                              }
                         else {
                              var key = fn;
                              var obj = {};
                              obj[key] = myimg.getAttribute("src")  //here we make list of necessary data-upwidth-tiny attribute changes
                              data_attr.push(obj);
                              }
                         }
                    var Pattern2 = new RegExp(gen_Proc.tiny_resize_dir);  
                    if( Pattern.test(oldSrc) === false && Pattern2.test(oldSrc) === false)continue; 
                    if (!myimg.hasAttribute('data-upwidth-tiny')){
                         var key = fn;
                         var obj = {};
                         obj[key] = myimg.getAttribute("src")  
                         data_attr.push(obj);
                         }
                    collect.push(fn);//automatically runs file directory sizing in edit mode if image present in text post 
                    }  
               }
          //uploaded image size will be checked on server for correct date-upload_tiny value then passed back.
          var jsonArr = collect.length ? JSON.stringify(collect) : '';
          var jsonData= data_attr.length  ? JSON.stringify(data_attr) : '';
          if (collect.length || data_attr.length ) {
               jQuery.ajax({url: this.url+'?tiny_handle_edit='+jsonArr+'&widA='+jsonData,
                    success: function(result){
                         console.log(result);
                         result=result.split('@x@'); 
                         var arr= result[0].length > 5 ? JSON.parse(result[0]) : [];
                         if (arr.length){//Update necessary data-upwidth-tiny attribute changes
                              jQuery('.edit.post.text .use_tiny').each(function(){
                                   jQuery(this).trigger('click');//here by triggering we enable tiny-mce in text post which causes field to submit when submit all button is clicked.. instead of an autosubmit 
                                    jQuery(this).html('<p style="font-size:.9em;">Image data attribute added <br> Edit Page as Needed<br>and Submit Changes</p>').appendTo(jQuery(this));
                                   });
                              }
                         arr.forEach(function(data){ 
                              var data=data.split('@@');
                              if(jQuery('.edit.post.text img[src="'+data[0]+'"]').length){
                                   jQuery('.edit.post.text img[src="'+data[0]+'"]').attr('data-upwidth-tiny',data[1]);
                                   }
                              });
                         }// success
                    });
               }
          },
     tinyResponse   : function(){
          var classes=document.querySelectorAll('.text.post');
          var minW=parseInt(gen_Proc.tiny_cache[0]);
          var sendCollect=false;
          var collect=[];
          var message=[];
          var msg=[]; 
          for (i=0;i < classes.length; i++){
               var cls =classes[i];
               var imgs= cls.getElementsByTagName('img'); 
               for (ii=0;ii < imgs.length; ii++){
                    var myimg=imgs[ii]; 
                    var oldSrc=myimg.getAttribute('src');
                    var fn = oldSrc.split('/').slice(-1)[0];
                    collect.push(fn); 
                    var Pattern = new RegExp(gen_Proc.tiny_resize_dir);  
                    if(Pattern.test(oldSrc)  === false)continue;
                    var pwidth=Math.max(myimg.offsetWidth,myimg.clientWidth);
                    var oldWidth =parseInt(oldSrc.split('/').reverse()[1]);
                    if (!myimg.hasAttribute('data-upwidth-tiny')){
                         var upWidth = 5000  ;//ie try newWidth cache size first..
                         message.push('fn: '+fn+' in .text.post id:'+cls.id);//send mail list
                         }
                    else var upWidth=parseInt(myimg.getAttribute('data-upwidth-tiny'));//get upload with..
                    var newSrc='';
                    if ( pwidth > oldWidth && oldWidth < upWidth ){//uploads Width   upWidth is the limiting image size that will be loaded.. 
                         var newWidth=gen_Proc.keyUp(pwidth,gen_Proc.tiny_cache,'max');
                         //upWidth limiting width so if upWidth is smaller than newWidth than newWidth image should not exist..
                         var pattern=new RegExp(gen_Proc.tiny_resize_dir+"[0-9]+\/");
                         if (newWidth < upWidth && newWidth > oldWidth){ 
                              var newSrc = oldSrc.replace(pattern,gen_Proc.tiny_resize_dir+newWidth+'/');
                              }
                         else if (newWidth >= upWidth && upWidth > oldWidth){ 
                              var newSrc = oldSrc.replace(pattern,gen_Proc.tiny_orig_sz_dir);
                              }
                         if (newSrc.length){
                              myimg.onload = function() {
                                   if ('naturalHeight' in this) {
                                        if (this.naturalHeight + this.naturalWidth === 0) {
                                             this.onerror();
                                             return;
                                             }
                                        }
                                   else if (this.width + this.height == 0) {
                                        this.onerror(); 
                                        };
                                   
                                   }
                              myimg.onerror = function() {  
                                   var id=jQuery(this).closest('.text.post').attr('id');
                                   gen_Proc.webmodeError.push('fn: '+this.src+' missing in .text post id: '+id);//this will be handled in javascript_destructor
                                   var pattern=new RegExp(gen_Proc.tiny_resize_dir+"[0-9]+\/");
                                   var newSrc = this.src.replace(pattern,gen_Proc.tiny_resize_dir+gen_Proc.tiny_cache_min+'/');
                                   if (this.src != newSrc)
                                   this.src=newSrc;
                                   }
                              
                              myimg.src=newSrc; 
                              }//if newSrc
                         }//( pwidth > oldWidth)
                    }
               }
          gen_Proc.webmodeColl=collect;
          jsonLogAttr =  message.length ? JSON.stringify(message) : ''; 
          if (jsonLogAttr.length){//ie images not found or upWdith not found 
               jQuery.ajax({url: this.url+'?webmodelog_data='+jsonLogAttr+'&msg=The following webmode list of img src files missing data-upwidth-tiny attribute',
                    success: function(result){
                         console.log(result);
                         }, 
                    error: function(msg){
                         console.log('Error:'+msg);
                         }, 
                    });
               }
          },
     destructor : function(){//last to run not destructing  
          setTimeout( () => {
               if (!this.Edit){  
                    if (this.webmodeError.length){ 
                         var error= (this.webmodeError.length)?JSON.stringify(this.webmodeError):'';
                         var coll= (this.webmodeColl.length)?JSON.stringify(this.webmodeColl):'';
                         jQuery.ajax({url: this.url+'?tiny_handle_webmode='+coll+'&error='+error,
                              success: function(result){
                                   console.log(result);
                                   }, 
                              error: function(msg){
                                   console.log('Error:'+msg);
                                   }, 
                              });
                         }
                    if (this.webmodeImageError.length){ 
                         var error= (this.webmodeImageError.length)?JSON.stringify(this.webmodeImageError):'';
                        jQuery.ajax({url: this.url+'?webmodelog_data='+error+'&msg=The following list of .image posts webmode img src files missing from img dir',
                              success: function(result){
                                   console.log(result);
                                   }, 
                              error: function(msg){
                                   console.log('Error:'+msg);
                                   }, 
                              });
                         }
                    if (this.webmodeCarouselError.length){ 
                         var error= (this.webmodeCarouselError.length)?JSON.stringify(this.webmodeCarouselError):'';
                        jQuery.ajax({url: this.url+'?webmodelog_data='+error+'&msg=The following list of .carousel posts webmode img src files missing from img dir',
                              success: function(result){
                                   console.log(result);
                                   }, 
                              error: function(msg){
                                   console.log('Error:'+msg);
                                   }, 
                              });
                         }
                    if (this.webmodeImageErrorBack.length){ 
                         var error= (this.webmodeImageErrorBack.length)?JSON.stringify(this.webmodeImageErrorBack):'';
                        jQuery.ajax({url: this.url+'?webmodelog_data='+error+'&msg=The following list of full page background slideshow images in webmode are missing from img dir',
                              success: function(result){
                                   console.log(result);
                                   }, 
                              error: function(msg){
                                   console.log('Error:'+msg);
                                   }, 
                              });
                         }
                    } 
               },  4000 ); 
          },
     imageResponse   :  function(f){console.log('imageResponse');
		var pwidth=Math.max(f.offsetWidth,f.clientWidth);
		var myimg = f.getElementsByTagName('img')[0]; 
		var oldWidth=f.getAttribute('data-wid');  // will get direct
          var collect=[];
          var sendCollect=false;
          if (pwidth > oldWidth){
               var newWidth=gen_Proc.keyUp(pwidth,gen_Proc.image_response,gen_Proc.maxPicLimit);  
               var pattern=new RegExp(gen_Proc.image_response_dir_prefix+"[0-9]+\/");
               if (newWidth >= oldWidth){  
                    var oldSrc=myimg.src;  
                    var newSrc = oldSrc.replace(pattern,gen_Proc.image_response_dir_prefix+newWidth+'/'); 
                    myimg.src=newSrc;
                    myimg.onload = function() {
                          if ('naturalHeight' in this) {
                               if (this.naturalHeight + this.naturalWidth === 0) {
                                    this.onerror();
                                    return;
                                    }
                               }
                          else if (this.width + this.height == 0) {
                               this.onerror(); 
                               }; 
                         };
                    myimg.onerror = function() {
                         var id=jQuery(this).closest('.image.post').attr('id');
                         var pattern=new RegExp(gen_Proc.image_response_dir_prefix+"[0-9]+\/");
                         var newSrc = oldSrc.replace(pattern,gen_Proc.image_response_dir_prefix+newWidth+'/'); 
                         if (this.src != newSrc)
                              this.src=newSrc;
                         gen_Proc.webmodeImageError.push('Error missing fn; '+newSrc+'in image post id: '+id);
                         }     
                    }
               }
		else { 
			//check if kenburns and fixed height.
			if (f.parentNode.className.indexOf("kenburns")>-1){ 
				myimg.style.width=oldWidth+'px'; //set explicit
				}
			}
           
		},
     carouselResponse   :  function(f){
          setTimeout( () => {//
               var pwidth=Math.max(f.offsetWidth,f.clientWidth);
               var myimg = f; 
               var oldWidth=f.getAttribute('data-wid');   
               var collect=[];
               var sendCollect=false; 
               if (pwidth > oldWidth){ 
                    var newWidth=gen_Proc.keyUp(pwidth,gen_Proc.image_response);  
                    var pattern=new RegExp(gen_Proc.image_response_dir_prefix+"[0-9]+\/");
                    if (newWidth >= oldWidth){  
                         var oldSrc=myimg.src;  
                         var newSrc = oldSrc.replace(pattern,gen_Proc.image_response_dir_prefix+newWidth+'/');
                         myimg.src=newSrc;
                         myimg.onload = function() { ;
                               if ('naturalHeight' in this) {
                                    if (this.naturalHeight + this.naturalWidth === 0) {
                                         this.onerror();
                                         return;
                                         }
                                    }
                               else if (this.width + this.height == 0) {
                                    this.onerror(); 
                                    }; 
                              };
                         myimg.onerror = function() {
                              var id=jQuery(this).closest('.carousel.post').attr('id');
                              var pattern=new RegExp(gen_Proc.carousel_response_dir_prefix+"[0-9]+\/");
                              var newSrc = oldSrc.replace(pattern,gen_Proc.carousel_response_dir_prefix+newWidth+'/'); 
                              if (this.src != newSrc)
                                   this.src=newSrc;
                              gen_Proc.webmodeCarouselError.push('Error missing fn; '+newSrc+'in carousel post id: '+id);
                              }     
                         }
                    }
               },40);
           
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
     toggle_display    :  function(obje){
		if (typeof obje === "string"){ 
			var obje =  (obje == 'body') ? document.getElementsByTagName("body")[0] : document.getElementById(obje)
			}
		if(obje.style.display=="block") 
               obje.style.display='none';
          else obje.style.display='block';
		},//end showit
	toggleVisibility  :  function(elem1,elem2){  
		if (window.TOUCHSTART){ 
               jQuery(elem1).mouseenter(function(event){  
                    if (jQuery(this).find('ul.sub-level').css("display")!=="block") 
                         jQuery(this).find('ul.sub-level').css({'visibility':'visible','display':'block'});
                    else{
                         jQuery(this).find('ul.sub-level').css({'visibility':'hidden','display':'none'});}
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
	displayWindowSize	: function(id,vpw) { 
		 p=document.querySelector('#'+id + ' p#clientw');
		 p2=document.querySelector('#'+id+'2' + ' p#clientw2');
		if(p=== null)return;  
		p2.innerHTML=p.innerHTML = 'Wid: <span class="red whitebackground">'+vpw +'</span>';
		 },
      adjustLeftMargin(id,wid){
          var ele=document.getElementById(id);
          var offleft=this.getOffsetVal(ele).left;
          var room =  screen.width - ( offleft + wid );
          if ( room > 0 ) return;
          var xtra = ( room > 20 ) ? 15 : 3;
          var adjust= -offleft + xtra; 
               ele.style.marginLeft=adjust+'px'; 
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
          var offset=jQuery('#'+id).offset();
		var leftpos=offset.left;//how far from left border
		jQuery('#'+id+'t').wrap('<div class="jqwrap"></div>');
		jQuery('#'+id+'t').parent().css({position:'relative'});//to enable zIndex in relative pos  
		wmax=jQuery(window).width();
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
			jQuery(elem).children(":first").append('<p class="removeit" style="font-family:monospace;font-size:16px;visibility:hidden">'+html+'</p>');
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
		jQuery('.removeit').remove();
		elem.style.zIndex="initial";
		elem.style.position="initial";
		},//end function  
	getOffsetVal	:  function(element) {
		var top = 0, left = 0;
		do {
		   top += element.offsetTop  || 0;
		   left += element.offsetLeft || 0;
		   element = element.offsetParent;
		} while(element);
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
	toggleClass2   : function (ele, classN) {//include # or . & attr name
          if (jQuery(ele+'.'+classN).length){ 
			jQuery(ele).removeClass(classN); 
			}
		else {  
			jQuery(ele).addClass(classN); 
			}
		}, 
	toggleClass   : function (ele, classN, classN2, replace, timeout) { 
		if (jQuery(ele+'.'+classN).length){ 
			jQuery(ele).addClass(replace).removeClass(classN);
			setTimeout(function(){
				jQuery(ele).removeClass(classN2)
				},timeout);
			}
		else {
               jQuery(ele).removeClass(replace)
			jQuery(ele).addClass(classN).addClass(classN2);
			}
		},
	toggleHasClass   : function (ele, ele2, classN, classN2) { 
          if (jQuery(ele+'.'+classN).length){  
               jQuery(ele2).addClass(classN2) 
               }
          else {
               jQuery(ele2).removeClass(classN2) 
               }
		},
	toggleTweak   : function (ele, classN, ele2, tweak, tweak2, timeout) { 
          if (jQuery(ele+'.'+classN).length){      
               setTimeout(function(){
                    jQuery(ele2).css(tweak); 
                    },timeout);
               }
          else {
               if (tweak2 !==''){
                    jQuery(ele2).css(tweak2);
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
			gen_Proc['xml'+this.xmlCount] = new XMLHttpRequest();
			} 
		else if (window.ActiveXObject) { // Older IE browsers
			// Create type Msxml2.XMLHTTP, if possible:
			try {
			    gen_Proc['xml'+this.xmlCount] = new ActiveXObject("Msxml2.XMLHTTP");
			    }
			catch (e1) { // Create the older type instead:
				try {
					gen_Proc['xml'+this.xmlCount] = new ActiveXObject("Microsoft.XMLHTTP");
					}
					catch (e2) { }
				}//catch
			}//end else old
		// Send an alert if the object wasn't created.
		if (!gen_Proc['xml'+this.xmlCount]) {
			alert ('Some page functionality is unavailable.');
			}
	    
		},//end create_ajax
	use_ajax   : 	function (url,func,method){ 
		console.log('url: '+url+' funct: '+func);
		if (this.passclass&&!this.Override){ 
			return;
			}
          this.xmlCount++;
		this.create_ajax(); 
		if (gen_Proc['xml'+this.xmlCount]) {
			this.Override=0
			gen_Proc['xml'+this.xmlCount].open(method, url+'&sess_override',true);
			gen_Proc['xml'+this.xmlCount].onreadystatechange = function(){
			gen_Proc[func]();}
			// Send the request:
			gen_Proc['xml'+this.xmlCount].send(null);
			return false;
			}
		else {
			return true;
			}
		}, //end use_ajax
	handle_replace	:   function () { console.log('return handler');
		if ( (gen_Proc['xml'+this.xmlCount].readyState == 4) && (gen_Proc['xml'+this.xmlCount].status == 200) ) {
			if (gen_Proc['xml'+this.xmlCount].responseText.length > 20) {
                    console.log('OK>20');
				console.log(gen_Proc['xml'+this.xmlCount].responseText)
				var jsonitems = JSON.parse(gen_Proc['xml'+this.xmlCount].responseText); 
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
				if (gen_Proc['xml'+this.xmlCount].responseText==='no return'){
					console.log( 'No Return Values Found in Database');
					}
				else if (gen_Proc['xml'+this.xmlCount].responseText==='reBuffed'){
					console.log( 'reBuffed');
					}
				else if (gen_Proc['xml'+this.xmlCount].responseText==='updateImages'){
					console.log('Tiny Images directories and image resizing checked');
					}
				else if (gen_Proc['xml'+this.xmlCount].responseText.length>0){
					console.log(gen_Proc['xml'+this.xmlCount].responseText+' sent under 20');
					}
				else console.log( 'JasonReturn or mistake in handle replace');
                    
				}
			 
			}//ready state
		},//end handle_replace
     handle_respond	:   function () {  
		if ( (gen_Proc['xml'+this.xmlCount].readyState == 4) && (gen_Proc['xml'+this.xmlCount].status == 200) ) {
			if (gen_Proc['xml'+this.xmlCount].responseText.length < 5 && gen_Proc['xml'+this.xmlCount].responseText.length > 1 ) { 
				console.log(gen_Proc['xml'+this.xmlCount].responseText)
				var jsonitems = JSON.parse(gen_Proc['xml'+this.xmlCount].responseText); 
				var key,size = 0;
				for (key in jsonitems){
					if (jsonitems.hasOwnProperty(key)) size++;
					}
				for (i=0; i<size; i++){ 
                         if (jsonitems[i]=='genVal') { 
						i++
						gen_Proc[jsonitems[i]]=jsonitems[i+1];
						}
					}//end for
				}//ajax repsonse.length
			else {
				if (gen_Proc['xml'+this.xmlCount].responseText==='no return'){
					console.log( 'No Return Values Found in Database');
					}
				else if (gen_Proc['xml'+this.xmlCount].responseText==='reBuffed'){
					console.log( 'reBuffed');
					}
				else if (gen_Proc['xml'+this.xmlCount].responseText==='updateImages'){
					console.log('Tiny Images directories and image resizing checked');
					}
				else if (gen_Proc['xml'+this.xmlCount].responseText.length>0){
					console.log(gen_Proc['xml'+this.xmlCount].responseText+' sent under 20');
					}
				else console.log( 'JasonReturn or mistake in handle replace');
                    }
			}//ready state
		},//end handle_respond
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
				if (typeof(jsonitems[5]) !=='undefined'){ 
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
	imageResponseBack    :  function(f){  //background slideshow 
                var pwidth=Math.max(f.offsetWidth,f.clientWidth); 
                var oldWidth=f.getAttribute('data-wid');
                var maxcheck=Number(oldWidth) + pwidth/5;//for checking size range
                var mincheck=Number(oldWidth) - pwidth/15;
                //double check height to width of element regardless of resizing larger smaller  or changing image
                var aspect=f.getAttribute('data-asp');
                if (jQuery(f).hasClass('limit')) f.style.height=pwidth/aspect+'px';  
                if ( pwidth > maxcheck){ 
                        f.setAttribute('data-wid',pwidth);//update data-wid for future pwidth check
                         var newWidth=gen_Proc.keyUp(pwidth,gen_Proc.image_response,gen_Proc.maxPicLimit);       
                         var pattern=new RegExp(gen_Proc.image_response_dir_prefix+"[0-9]+\/");
                         var imgarr = f.getElementsByTagName('span');//backauto within spans
                         for (i=0; i < imgarr.length; i++){  
                              var oldUrl=imgarr[i].style.backgroundImage;
                              var myimg=imgarr[i];
                              var newUrl = oldUrl.replace(pattern,gen_Proc.image_response_dir_prefix+newWidth+'/');
                              var pattern2=/url\((.*?)\)/;
                              if (newUrl.match(pattern2)){ 
                                   var newSrc=newUrl.match(pattern2)[1];  
                                   re=/"/g
                                   newSrc=newSrc.replace(re,'');
                                   if (gen_Proc.fileExists(newSrc)){   
                                        url='url('+newSrc+')';
                                        imgarr[i].style.backgroundImage=url; 
                                        }
                                   else { 
                                        gen_Proc.webmodeImageErrorBack.push('Error Background Slide missing fn; '+newSrc+'in background image post id: ');
                                        console.log(newSrc + ' Does Not Exist');
                                        }//else
                                   }//if regex match
                              else if (gen_Proc.Dev&&(gen_Proc.Edit||gen_Proc.Loc)) alert('nogex match')
                              }//for loop
                        } //max check  undersize
                },//end functio 
	fileExists	:  function(file_url){ //for time delayed background slide shows..
		var http = new XMLHttpRequest();
		http.open('HEAD', file_url, false);
		http.send();
		return http.status != 404;
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
		var max= 'nolimit';
          value=parseInt(value)
          var returnMax=  arguments[2] && arguments[2] ==='max' ? arguments[2]:''; 
		var prev=0; 
		for (i in arr){
			if (arr[i] >=value){
				if (max  == 'nolimit' || arr[i] <= gen_Proc.maxPicLimit) 
					return parseInt(arr[i]);
				else return prev;
				}
			prev=arr[i]
			}
           
          return parseInt(arr[arr.length-1]);
		//return 0;  
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
			jQuery('body').children().fadeTo(1000,0);
			setTimeout(function(){
			jQuery('body').children().fadeTo(0,0);
				jQuery('body').append('<div style="opacity:0;" id="coverall"><img src="'+mysrc+'" width="'+width+'" height="'+height+'"></div>'+ 
				'<script>'+
				'jQuery("#coverall").click(function(){'+
					'jQuery(this).fadeTo("1000",0);'+
					'setTimeout(function(){'+
						'jQuery("body").children().show(0);'+
						'jQuery("body").children().fadeTo(1000,1);'+
						'jQuery("#coverall").remove();}, 1000);})'+
				'<\/script>');//append
			jQuery("body").children().hide();
			jQuery("#coverall").fadeTo(750,1);
				
			jQuery("#coverall").hover(function() {
			jQuery(this).css('cursor','pointer');
			});
				},1000);//setTimeout
			}//end onload
		
		return false;
		},//end imageexpand
		imageexpand2	: function(mysrc,width,height){
		var img = new Image();
		img.src = mysrc;
		img.onload = function() { 
			jQuery('body').children().fadeTo(1000,0);
			setTimeout(function(){
			jQuery('body').children().fadeTo(0,0);
			var appenddiv='<div style="opacity:0;" id="coverall"><img src="'+mysrc+'" width="'+width+'" height="'+height+'"></div>';
			var appendscript='jQuery("#coverall").click(function(){'+
					'jQuery(this).fadeTo(1000,0);'+
					'setTimeout(function(){'+
						'jQuery("body").children().show(0);'+
						'jQuery("body").children().fadeTo(1000,1);'+
						'jQuery("#coverall").remove();}, 1000);}';
			jQuery('body').append(appenddiv);
			jQuery(function () {
			jQuery('<script>')
			.text(appendscript)
			.appendTo('body');
			})
			jQuery("body").children().hide();
			jQuery("#coverall").fadeTo(750,1);
				
			jQuery("#coverall").hover(function() {
			jQuery(this).css('cursor','pointer');
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
     url : window.location.href.split('?')[0].split('#')[0],
	allowThis :  function(elem){
          elem.className += ' allowthis';
          },
     beforeSubmit	:  function () {
		var getInputs = document.getElementsByTagName("input");
		var getSelects = document.getElementsByTagName("select");
		var getTexts = document.getElementsByTagName("textarea");
		var inputnum=0,selectnum=0,textnum=0,radionum=0,checknum=0;
		jQuery('.enableTiny').each(function(){
               var inner=(this.innerHTML);
               if (gen_Proc.scriptSubmit){  
                         inner=inner.replace('/<script>/g','&lt;script&gt;');
                         inner=inner.replace('/<\/script>/g','&lt;/script&gt;');
                         }
                    if (gen_Proc.iframeSubmit){
                         inner=inner.replace('/<iframe/g','&lt;iframe');
                         inner=inner.replace('/><\/iframe>/g','&gt;&lt;/iframe&gt;');
                         this.html=inner;  
                         } 
               });
		for(var i = 0; i < getTexts.length; i++) {  
			var obj = getTexts[i];
			if (obj.className.indexOf("llowthis")>0) {
				//do nothing
				}
			else if(obj.value == obj.defaultValue){
				if (obj.className.indexOf("mytextarea")<0) getTexts[i].disabled = true;
				textnum++;
				} 
               else {
                    if (gen_Proc.scriptSubmit){  
                         obj.value=obj.value.replace('<script>','&lt;script&gt;');
                         obj.value=obj.value.replace('/<\/script>/g','&lt;/script&gt;');
                         }
                    if (gen_Proc.iframeSubmit){
                        obj.value=obj.value.replace('<iframe','&lt;iframe');
                        obj.value=obj.value.replace('></iframe>','&gt;&lt;/iframe&gt;');
                         } 
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
		gen_Proc.use_ajax(this.url+'?imageChoiceMaster='+selected+'@@'+bg_ref+'@@'+cid,'handle_replace','get'); 
		},
	imageSelectGallery	:  function(obje,cid,name,bg_ref){ 
		document.getElementById(name).style.display='block';
		var selected = obje.options[obje.selectedIndex].value; 
		gen_Proc.use_ajax(this.url+'?imageSelectGallery='+selected+'@@'+cid,'handle_replace','get'); 
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
               tinymce.activeEditor.on('drop', function(e) {
               setTimeout(function(){
                    jsExpressEdit.sortRespond(editor.id);//sorting or drag & drop iframe check and response
                    }, 300);
               });
              
          var selection =rObj.parentNode.querySelector('.altEdOptionShow');
          if (selection  !== null)
               rObj.parentNode.querySelector('.altEdOptionShow').style.display='block';
			}
		},
     useAjaxSort  :  function(id,self,changeId,style,sortid) {gen_Proc.use_ajax(self+'?update_sort_quiet='+style+'@@'+changeId+'@@'+ToolMan.junkdrawer().serializeList(document.getElementById(id))+'@@'+sortid,'handle_replace','get');
		},
	ajaxSort  :  function(getCheck,id,self,updateId,changeId,msg) { 
		 gen_Proc.use_ajax(self+'?'+getCheck+'='+ToolMan.junkdrawer().serializeList(document.getElementById(id))+'@@'+updateId+'@@'+changeId+'@@'+msg,'handle_replace','get');
		},
	sendListOrder  : function(id,self){ 
	gen_Proc.use_ajax(self+'?update_sort_submit='+ToolMan.junkdrawer().serializeList(document.getElementById(id)),'handle_replace','get');
	},
	sendGallOrder	: function(item) {
		var msg='Changes are immediate and your Gallery Order has been Updated. Refresh in editmode or submit other changes then view Webpage to see' ;
		var junkdrawer = ToolMan.junkdrawer()
		var group = item.toolManDragGroup
		var list = group.element.parentNode ; 
		var id = list.getAttribute("id")
		var bid = edit_Proc.sortDataId
		var inc = edit_Proc.sortDataInc
		if (bid == null || inc == null){
			alert('get Data attribute Fail. For editing try different Modern Browser for best results')
			return
			}
		if (id == null ){
			alert('get Id Fail. For editing try different Modern Browser for best results')
			return
			}
		group.register('dragend', function() {  
			edit_Proc.ajaxSort("gall_sort",id,edit_Proc.url,bid,"updateGallMsg_"+ inc, msg);
			})  
		},
	sendSlideOrder	: function(item) {
		var msg='Changes are immediate and your Slide Show Order has been Updated. Refresh to see' ;
		var group = item.toolManDragGroup
		var list = group.element.parentNode ; 
		var id = list.getAttribute("id")
		var bid = edit_Proc.sortDataId
		var inc = edit_Proc.sortDataInc
		if (bid == null || inc == null){
			alert('get Data attribute Fail. For editing try different Modern Browser for best results')
			return
			}
		if (id == null ){
			alert('get Id Fail. For editing try different Modern Browser for best results')
			return
			}
		group.register('dragend', function() {  
			edit_Proc.ajaxSort("auto_sort",id,edit_Proc.url,bid,"updateMsg_"+ inc, msg);
			})  
		},
	sendEditOrder	: function(item) {
	// tool-man  dragsort related  js created by Tim Taylor Consulting <http://tool-man.org/>
		var msg='Changes are immediate and your Editor Color Order has been Updated. Refresh page or submit other changes to View the new order' ;
		var group = item.toolManDragGroup
		var list = group.element.parentNode ; 
		var id = list.getAttribute("id")
		var bid = null; //
		if (id == null ){
			alert('get Id Fail. For editing try different Modern Browser for best results')
			return
			}
		group.register('dragend', function() {  
			edit_Proc.ajaxSort("pageEd_sort",id,edit_Proc.url,bid,"updatePageEdMsg",msg);
			})
         // alert ('ajaxSort getCheck&id'+ id+', self: '+    self +',bid; '+bid+ ',"altTAEditMsg" id for msg '+ msg)  ;
		}, 
	makelistSortable	: function(o,func) {
		//tool-man  dragsort related  js created by Tim Taylor Consulting <http://tool-man.org/>  
		edit_Proc.sortDataId=o.getAttribute('data-id');
		edit_Proc.sortDataInc=o.getAttribute('data-inc')
		dragsort.makeListSortable(o,func)//sorts out o and passes callback func with sorted list..
		},
	divTextArea	: function(elem){
		gen_Proc.addEvent(elem, 'click', function(){
			var pattern = new RegExp('divTextArea'); 
			if (!elem.className.match(pattern))return; //editor initiated 
			var textArea=elem.parentNode.getElementsByTagName('textarea')[0];
                textArea.style.display = "block";
			gen_Proc.autoGrowFieldScroll(textArea);
			elem.style.display = "none";
               //elem.parentNode.querySelector('.altEdOptionShow').style.display='block';
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
     jQuery.fn.justtext = function() {//from https://www.viralpatel.net/jquery-get-text-element-without-child-element/
          return jQuery(this)	.clone().children().remove().end().text();
          }
     
     function initnoUiSlider(inc,range1,range2,size,increment,unit,factor,unit2){ 
if (arguments.length>7&&arguments[8]){
     size=(window['updateinput_'+inc].value);
     window['updateSlider_'+inc].noUiSlider.destroy();
     }
else document.getElementById('button-create-slide_'+inc).className += " hide";
var diff=(range2-range1); 
var nextincrement=0;
var totaldiff=diff/increment; 
if  (totaldiff >=2000 ){
     nextincrement=increment;
     increment=20*increment;
     }
else if  (totaldiff >=1000 ){
     nextincrement=increment;
     increment=10*increment;
     }
else if  (totaldiff >=400 ){
     nextincrement=increment;
     increment=5*increment;
     } 
window['updateSlider_'+inc] = document.getElementById('slider-update_'+inc);
window['updateSliderValue_'+inc] = document.getElementById('slider-update-value_'+inc);
window['updateinput_'+inc]=document.getElementById('slider-input_'+inc); 
var datarange1=window['updateinput_'+inc].getAttribute('data-min');
var datarange2=window['updateinput_'+inc].getAttribute('data-max');
if (document.getElementById('slider-checkbox_'+inc))
     window['updateslidercheck_'+inc]=document.getElementById('slider-checkbox_'+inc);

noUiSlider.create(window['updateSlider_'+inc], {
	range: {
		'min': range1,
		'max': range2
	}, 
	start: size, 
	step: increment
});

var convert= unit2 !== '' && factor !=='1' ?'  &nbsp;'+(parseFloat(window['updateinput_'+inc].value*factor).toFixed(2))+unit2:'';
window['updateSliderValue_'+inc].innerHTML=window['updateinput_'+inc].value+unit+convert;//inititial

window['updateSlider_'+inc].noUiSlider.on('slide', function( values, handle ) { 
     var num= Number.isInteger(increment) ? Number(values[handle]) : values[handle];
      var convert= unit2 !== '' && factor !=='1' ?'  &nbsp;'+(parseFloat(num*factor).toFixed(2))+unit2:'';
	 window['updateSliderValue_'+inc].innerHTML = num+unit+convert;
});

window['updateSlider_'+inc].noUiSlider.on('change', function( values, handle ) { 
     var num= Number.isInteger(increment) ? Number(values[handle]) : values[handle];
      var convert= unit2 !== '' && factor !=='1' ?'  &nbsp;'+(parseFloat(num*factor).toFixed(2))+unit2:'';
	window['updateSliderValue_'+inc].innerHTML = num+unit+convert;
	window['updateinput_'+inc].style.visibility='visible';
	window['updateinput_'+inc].setAttribute('type','hidden');
	window['updateinput_'+inc].value=num;
     if (document.getElementById('slider-checkbox_'+inc)) 
          window['updateslidercheck_'+inc].checked=false;
});
window['updateSlider_'+inc].noUiSlider.on('change', function( values, handle ) { 
          if (nextincrement>0){ 
               document.getElementById('button-refine-slide_'+inc).classList.remove('hide');
               var current = values[handle];
               window['updatenoUiSlidermin_'+inc]=Math.max(datarange1,+current-75*nextincrement);
               window['updatenoUiSlidermax_'+inc]=Math.min(datarange2,+current+75*nextincrement);
               window['updatenoUiSliderincrement_'+inc]=nextincrement; 
               }
     });
}

function updateSliderRange(inc) { 
	window['updateSlider_'+inc].noUiSlider.updateOptions({
		range: {
			'min': window['updatenoUiSlidermin_'+inc],
			'max': window['updatenoUiSlidermax_'+inc]
		},
          
     step: window['updatenoUiSliderincrement_'+inc]
	});
} 
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
	slideAuto_init: function(l){ alert(this.imgId);
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
nextPhoto : function(){ 
	this.flag = 1;
	this.delta = 2;   
	this.opacity = this.minOpac;   
	this.currentPicLink += 1
	this.currentPicLink > this.endcount - 1 && (this.currentPicLink = 0);
	this.currentPicLink == this.endcount - 1 && (this.preload = 0);
	//this.currentPicLink < 0 && (this.currentPicLink = this.endcount - 1);
     var pN=document.getElementById(this.autoImgContain);
     var pObj=document.getElementById(this.imgId);  //buffer transition
    currHeight=Math.max(pObj.offsetHeight,pObj.clientHeight);
     pN.style.height=currHeight+'px';
     var currWidth=Math.max(pObj.clientWidth,pObj.offsetWidth);
     currWidth = currWidth > 10 ? currWidth : this.widInit; 
	pN.style.width=currWidth+'px';
     var calcDir=gen_Proc.keyUp(currWidth,gen_Proc.image_response,gen_Proc.maxPicLimit);
	var a = new Image();
	a.src = this.dir + gen_Proc.image_response_dir_prefix+calcDir+'/'+ this.bigname_array[this.currentPicLink];
	slideAuto.calcDir=calcDir; 
	slideAuto.dir=this.dir + gen_Proc.image_response_dir_prefix+calcDir+'/'
	slideAuto.picname=this.bigname_array[this.currentPicLink];
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