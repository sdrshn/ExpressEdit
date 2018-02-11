<?php
/*
ExpressEdit is an integrated Theme Creation CMS
	Copyright (c) 2018  Brian Hayes expressedit.org  

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <https://www.gnu.org/licenses/>.*/
class javascript {
protected $javascript='';

function __construct($array_function, $tablename, $file_extension='',$append_script=''){ 
	$array_function=(!is_array($array_function))?explode(',',$array_function):$array_function;    
	foreach ($array_function as $var){  
		$this->$var(); $this->javascript.="\n";
		}
		
	$this->javascript.=$append_script;
	if ($tablename==='print'){ 
		$this->javascript_return="\n\r".
		self::open_java()."\n\r".'//<![CDATA['."\n\r".
		$this->javascript."\n\r". '//]]>'."\n\r".'</script>'; 
		return;
		}  
	file_put_contents(Cfg_loc::Localroot_dir.Cfg::Script_dir.$tablename.$file_extension.'scripts.js', $this->javascript);
	#printer::vert_print($array_function);
	}
 
static function open_java() {
	return ('<script type="text/javascript">');
	}
function onload(){
$this->javascript.= <<<EOD
 	 
	 
docReady(function () {
	var resizeTimer=''; 
	gen_Proc.classPass('prevD',gen_Proc.addEvent,'click',gen_Proc.prevDefault); 
	  gen_Proc.classPass('backauto',gen_Proc.imageResponseBack); 
	 gen_Proc.classPass('respondHeight',gen_Proc.responseHeight); 
	 // gen_Proc.classPass('myvid',gen_Proc.toggleControls); 
	 gen_Proc.classPass('video-back-container',gen_Proc.videoResponseBack);
	 gen_Proc.classPass('fadein',gen_Proc.fadeIn);
	 gen_Proc.classPass('imagerespond',gen_Proc.imageResponse);
	//gen_Proc.classPass('calcFloat',gen_Proc.sizeFloat);
	gen_Proc.classPass('page_options_hidefont',gen_Proc.showIt);
	//gen_Proc.classPass('video_resize',gen_Proc.videoRespond);//currently using css absolute positioning method from Stack Overflow 
	if (document.getElementById && document.getElementsByTagName) {
          var aImgs = document.body.getElementsByTagName("img");
          imgSizer.collate(aImgs); 
		}
	window.addEventListener('resize', function(){
		clearTimeout(resizeTimer);
		resizeTimer = setTimeout(function(){ //this limits no of resize events responding
			document.cookie='screenW='+screen.width+','+screen.height; 
			document.cookie="clientW="+window.innerWidth|| document.documentElement.clientWidth|| document.body.clientWidth+"; path=/";
			gen_Proc.classPass('backauto',gen_Proc.imageResponseBack);//background slideshow 
			gen_Proc.classPass('respondHeight',gen_Proc.responseHeight);
			gen_Proc.classPass('imagerespond',gen_Proc.imageResponse); 
			gen_Proc.classPass('video_resize',gen_Proc.videoRespond);
			}, 500); 
		}, true);
	window.addEventListener('resize', function(){
		gen_Proc.displayWindowSize('displayCurrentSize');
		}, true);
	gen_Proc.displayWindowSize('displayCurrentSize');
	document.cookie='screenW='+screen.width+','+screen.height; 
	document.cookie="clientW="+window.innerWidth|| document.documentElement.clientWidth|| document.body.clientWidth+"; path=/";
	 gen_Proc.passvar();
	});
	 
EOD;
	}//end onload
   
function onload_edit(){
$this->javascript.= <<<EOD
docReady(function () { 
	gen_Proc.classPass('divTextArea',edit_Proc.divTextArea);
	gen_Proc.classPass('sortGall',edit_Proc.makelistSortable,edit_Proc.sendGallOrder);
	gen_Proc.classPass('sortSlide',edit_Proc.makelistSortable,edit_Proc.sendSlideOrder);
	gen_Proc.classPass('sortEdit',edit_Proc.makelistSortable,edit_Proc.sendEditOrder);
	});
	 
EOD;
	}//end onload    
 
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
  
 
function imgSizer(){
$this->javascript.= <<<EOD
	//from http://unstoppablerobotninja.com/entry/fluid-images/
 
	var imgSizer = {
	Config : {
		imgCache : []
		,spacer : "iespacer.gif"
	}

	,collate : function(aScope) {
		var isOldIE = (document.all && !window.opera && !window.XDomainRequest) ? 1 : 0;
		if (isOldIE && document.getElementsByTagName) {
			var c = imgSizer;
			var imgCache = c.Config.imgCache;

			var images = (aScope && aScope.length) ? aScope : document.getElementsByTagName("img");
			for (var i = 0; i < images.length; i++) {
				images[i].origWidth = images[i].offsetWidth;
				images[i].origHeight = images[i].offsetHeight;

				imgCache.push(images[i]);
				c.ieAlpha(images[i]);
				images[i].style.width = "100%";
			}

			if (imgCache.length) {
				c.resize(function() {
					for (var i = 0; i < imgCache.length; i++) {
						var ratio = (imgCache[i].offsetWidth / imgCache[i].origWidth);
						imgCache[i].style.height = (imgCache[i].origHeight * ratio) + "px";
					}
				});
			}
		}
	}

	,ieAlpha : function(img) {
		var c = imgSizer;
		if (img.oldSrc) {
			img.src = img.oldSrc;
		}
		var src = img.src;
		img.style.width = img.offsetWidth + "px";
		img.style.height = img.offsetHeight + "px";
		img.style.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" + src + "', sizingMethod='scale')"
		img.oldSrc = src;
		img.src = c.Config.spacer;
		    if(img.completed)alert ('found spacer src test');
		    else alert('src ie spacer test not found');
	}

	// Ghettomodified version of Simon Willison's addLoadEvent() -- http://simonwillison.net/2004/May/26/addLoadEvent/
	,resize : function(func) {
		var oldonresize = window.onresize;
		if (typeof window.onresize != 'function') {
			window.onresize = func;
		} else {
			window.onresize = function() {
				if (oldonresize) {
					oldonresize();
				}
				func();
			}
		}
	}
}
    
EOD;
    }//end php function  
   
 
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
		
	imageSelectMaster	:  function(obje,cid,name,bg_ref){
		document.getElementById(name).style.display='block';
		document.getElementById('dis_'+name).style.display='none';
		document.getElementById('show_'+name).style.display='block';
		var selected = obje.options[obje.selectedIndex].value; 
		var url = window.location.href.split('?')[0];
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
			//rObj.style.display = "block";
			//var textArea=rObj.parentNode.getElementsByTagName('textarea')[0]
			//mtext=textArea.value; 
			//rObj.innerHTML=mtext;
			//textArea.style.display = "none";
			}
		else {
			var editor = tinymce.EditorManager.createEditor(mId,tinymce.settings);
			editor.render();
			}
		},
	
	sendGallOrder	: function(item) {
		var msg='Changes are immediate and your Gallery Order has been Updated. Refresh Webpage to see' ;
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
			var textArea=elem.parentNode.getElementsByTagName('textarea')[0]
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
			color=(arguments[2])?arguments[2]:'#fdf0ee';
			document.getElementById(id).style.backgroundColor=color;
			arguments[1].style.backgroundColor=color;
			}
		},//end displaythis
	lookdeep	:  function(obje, num){
		num++;
		var collection= [], index= 0, next, item;
		for(item in obje){
			if(obje.hasOwnProperty(item)){
				next= obje[item];
				if(next[key]===value &&num < 6){
					 
					collection[index++]= item + ' value: '+ item.value+' :{ '+ lookdeep(next).join(',<br><br> ')+'}';
					}
				//else collection[index++]= [item+':'+String(next)];
				}
			}
			return collection;
		}	
	}//end edit_Proc
EOD;
    }//end php function edit_Proc
    
 
  

    
#Modified from  Code Credit :
#http://stackoverflow.com/questions/16659647/using-prepopulated-form-submit-only-changed-fields
# waldol1   onchange="add('field2')" 
	   
 

    
function confirmAction() {   
    $this->javascript.= <<<EOD
    function confirmAction() {
	  
	return confirm("Deleted picture may be restored only from archive: do you wish to proceed?");  
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
//if(/.*\.(mp4)|(flv)|(ogg)|(m4v)|(webm)|(zip)$/.test(f["upload"].value.toLowerCase()))
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
function checkPicFiles(f,watermark){
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
    if(/.*\.(zip)$/.test(f["upload"].value.toLowerCase())){
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
	
	var calcDir=gen_Proc.keyUp(currWidth,gen_Proc.image_response,gen_Proc.maxPicLimit);	
	var a = new Image();
	a.src = this.dir + gen_Proc.image_response_dir_prefix+calcDir+'/'+ this.bigname_array[this.currentPicLink];
	slideAuto.calcDir=calcDir; 
	//slideAuto.timeout=this.timeout
	slideAuto.dir=this.dir + gen_Proc.image_response_dir_prefix+calcDir+'/'
	slideAuto.picname=this.bigname_array[this.currentPicLink];
	gen_Proc.imageExists(a.src,function(exists){
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
			
	var inner = '<img class="'+this.picClass+'"  style="width:100%;text-align:center;margin-top:'+padTop+'px;margin-bottom:'+padTop+'px; filter:alpha(this.opacity='+this.opacity+');this.opacity:.'+this.opacity+';" src="' + a.src + '"  id="' + this.imgId + '"  title="Navigation menu up on photo" alt="' + this.bigname_array[this.currentPicLink].substr(0, 20) + '">';
	 document.getElementById(this.autoImgContain).innerHTML = inner;
	 
	this.setOpacity(document.getElementById(this.imgId), this.opacity);
	this.fadeImage(); 
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
    
function  gen_Proc(){ 
$this->javascript.= <<<EOD

var gen_Proc = {
	Override	: 0,
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

	toggleControls  : function (video) {
		console.log('var videoActualWidth = '+video.getBoundingClientRect().width);
console.log('var videoActualHeight = '+video.getBoundingClientRect().height);
console.log('var videotag_width = '+video.offsetWidth);
console.log('var videotag_height = '+video.offsetHeight); 
console.log('var video_height = '+video.videoHeight);
console.log('var video_width = '+video.videoWidth);
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
		var initWid=f.getAttribute('data-hwid');//alert (initWid+' is begin init wid');
		var dataH=f.getAttribute('data-height');
		var type=f.getAttribute('data-type');
		var rwd=f.getAttribute('data-rwd');
		if (f.scrollHeight>(pwidth/initWid*dataH+25)){
			if (type=='image'&& !rwd)
				f.style.overflowY = "hidden";
			else f.style.overflowY = "scroll";
			}
		 if (type=='video'){ 
			//video=f.getElementsByTagName("video");
			//gen_Proc.toggleClass(video[0]);
			} 
		else f.style.height=((pwidth/initWid*dataH)<=dataH)?(pwidth/initWid*dataH)+'px':dataH+'px';//changes according to current wid...
		},
	imageResponse   :  function(f){ 
		var pwidth=Math.max(f.offsetWidth,f.clientWidth);
		var myimg = f.getElementsByTagName('img');  
		//var oldWidth=img.width;  
		var oldWidth=f.getAttribute('data-wid');  // will get direct
		if (pwidth > oldWidth){
			var newWidth=gen_Proc.keyUp(pwidth,gen_Proc.image_response,gen_Proc.maxPicLimit);
			f.setAttribute("data-wid", newWidth); 
			var pattern=new RegExp(gen_Proc.image_response_dir_prefix+"[0-9]+\/");
			for (i=0; i<myimg.length;i++){
				oldSrc=myimg[i].src
				var newSrc = oldSrc.replace(pattern,gen_Proc.image_response_dir_prefix+newWidth+'/');
				gen_Proc.picSrc=newSrc
				gen_Proc.imgSize=newWidth
				gen_Proc.imageExists(newSrc,function(exists){
				if (exists) {
						myimg[i].src=newSrc; 
						}
				 else {
					if (gen_Proc.Dev&&(gen_Proc.Edit||gen_Proc.Loc)) alert ('Ajax image response creating '+gen_Proc.picSrc);
						var pattern=new RegExp(gen_Proc.large_gall_dir);
						if (!newSrc.match(pattern)){//if not gall image
							   var url = window.location.href.split('?')[0];
							   gen_Proc.use_ajax(url+'?create_image2='+ gen_Proc.picSrc+'@@'+gen_Proc.imgSize+'&sess_token='+gen_Proc.token,'handle_replace','get'); 
							   }
						}
					})
		  
				}//!exists
			}//for loop
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
	sizeFloat	:  function(o){
		 
		 
		},
	displayWindowSize	: function(id) {
		o=document.getElementById(id);
		if(o=== null)return;
		myWidth = window.innerWidth;
		//myHeight = window.innerHeight;
		  var x = {
				  w1: window.innerWidth || 1,
				  w2: document.documentElement.clientWidth || 2,
				  w3: document.documentElement.offsetWidth || 4,
				  };  
		  var wmax=Math.max(x.w1,x.w2,x.w3);
		  
		o.innerHTML = 'w1: <span class="red largest">'+myWidth + '</span>wmax: <span class="red">' + wmax+'</span>scrW: <span class="red">'+screen.width+'</span>';
		},
     show	:  function  (id,show,hide){ //#show
		if(document.getElementById(id+ "t").style.display=="inline-block"){
			document.getElementById(id+"t").style.display ="none";
			document.getElementById(id).style.textDecoration = 'underline';
			document.getElementById(id).innerHTML=show; 
			//document.getElementById(id+"t").style.zIndex=1; 
			//document.getElementById(id+"t").style.position="initial";
			document.getElementById(id).style.borderColor='initial';
			//window.scrollBy(0, 500);
			//document.getElementById(id+"f").focus();
			}
		else{
			if (hide=='slow')fadeTo.fadeTo_init(id+"t",.5,0,100,1.5); 
			document.getElementById(id+"t").style.display ="inline-block";
			document.getElementById(id).innerHTML='<span class="redAlertbackground white">Close </span>'+show;
			document.getElementById(id).style.borderColor='red';
			document.getElementById(id).style.textDecoration = 'underline';
			//document.getElementById(id+"t").style.position="relative";
			//document.getElementById(id+"t").style.zIndex="100";
			//document.getElementById(id+"f").focus();
			}
		}, //end show function
	fullWidth	:  function(id,width,msgVar){  
		msgVar= msgVar=='noback' ? false:true;
		if (msgVar==='asis')return;
		elem=document.getElementById(id+"t");
		if(elem.style.display!="none"){ //opened by show or plus...  now move
			var offset=this.getOffsetRect(elem);
			var leftpos1=offset.left;//how far from left border 
			var  pos=this.getOffsetVal(elem)
			var leftpos2=pos.left;
			var leftpos=Math.max(leftpos1,leftpos2); 
			var x = {
				w1: window.innerWidth || 1,
				w2: document.documentElement.clientWidth || 2,
				w3: document.documentElement.offsetWidth || 4,
				};
			pId=''//this.bubbleUpId(document.getElementById(id));
			 if (pId.indexOf("post_id")>0){
				var padLeft=this.getStyle(document.getElementById(pId),'padding-left');
				//alert(this.getStyle(document.getElementById(pId),'width'));
				padLeft=padLeft.replace(/px/,'');
				}
			else padLeft=0;
			leftpos=leftpos-padLeft;
			var wmax=Math.max(x.w1,x.w2,x.w3);
			if (width >wmax){
				currentWid=wmax;
				widthpx=wmax+'px';
				}
			else if (width=="full"){
				elem.style.width='100%';
				elem.parentNode.style.position="relative";
				elem.style.position="absolute";
				elem.style.zIndex="100";
				return;
				}
			else {
				var offWid=elem.offsetWidth;
				//offWid=0;//
				currentWid=Math.max(width,offWid);
				widthpx=currentWid+"px";
				}
			elem.parentNode.style.position="relative";
			elem.style.position="absolute";  
			elem.style.zIndex="100"; 
			elem.style.width=widthpx; //set id to width provided
			 // alert ("document offsetWidth is "+offWid+ " wmax is "+wmax+" and leftpos is "+leftpos)
			if ((leftpos + currentWid) > ( wmax)){ 
				tooFar=-(leftpos + currentWid - wmax); 
				//alert ("leftpos + currentWid) > ( wmax): now leftpos is "+leftpos + "currentWid is "+ currentWid+" and  wmax is "+wmax+ "result is tooFar is leftpos + currentWid+50 - wmax final total: "+tooFar);
				elem.style.left=tooFar+"px";// move to left...
				}
			else elem.style.left=0;
			}
		else{        
			elem.style.zIndex="initial";  
			elem.parentNode.style.position="static";
			elem.style.position="static";
			//if (msgVar)elem.parentNode.style.background="initial"; 
			  }  
		},//end js function
	fullWidth222222	:  function(id,width,msgVar){ 
		msgVar= msgVar=='noback' ? false:true;
		if (msgVar==='asis')return;
		
		if(document.getElementById(id+"t").style.display!="none"){ //opened by show or plus...  now move
			
			var offset=this.getOffsetRect(document.getElementById(id+"t"));  
			var leftpos1=offset.left;//how far from left border 
			var  pos=this.getOffsetVal(document.getElementById(id+"t"))
			var leftpos2=pos.left;
			var leftpos=Math.max(leftpos1,leftpos2); 
			var x = {
				w1: window.innerWidth || 1,
				w2: document.documentElement.clientWidth || 2,
				w3: document.documentElement.offsetWidth || 4,
				};
			pId=''//this.bubbleUpId(document.getElementById(id));
			 if (pId.indexOf("post_id")>0){
				var padLeft=this.getStyle(document.getElementById(pId),'padding-left');
				//alert(this.getStyle(document.getElementById(pId),'width'));
				padLeft=padLeft.replace(/px/,'');
				}
			else padLeft=0;
			leftpos=leftpos-padLeft;
			var wmax=Math.max(x.w1,x.w2,x.w3);
			if (width >wmax){
				currentWid=wmax;
				widthpx=wmax+'px';
				}
			else if (width=="full"){
				elem.style.width='100%';
				elem.style.position="absolute"; 
				elem.parentNode.style.position="relative";
				elem.style.zIndex="100";
				return;
				}
			else {
				var offWid=document.getElementById(id).offsetWidth;
				//offWid=0;//
				currentWid=Math.max(width,offWid);
				widthpx=currentWid+"px";
				}
			elem=document.getElementById(id+"t");
			elem.parentNode.style.position="relative";
			elem.style.position="absolute"; 
			elem.style.zIndex="100"; 
			elem.style.width=widthpx; //set id to width provided
			  //alert ("document offsetWidth is "+offWid+ " wmax is "+wmax+" and leftpos is "+leftpos)
			 if ((leftpos + currentWid) > ( wmax)){ 
				tooFar=-(leftpos + currentWid - wmax); 
				 //alert ("leftpos + currentWid) > ( wmax): now leftpos is "+leftpos + "currentWid is "+ currentWid+" and  wmax is "+wmax+ "result is tooFar is leftpos + currentWid+50 - wmax final total: "+tooFar); 
				elem.style.left=tooFar+"px";// move to left...
				} 
			}
		else{    
			elem=document.getElementById(id+"t"); 
			elem.style.zIndex="initial";  
			elem.parentNode.style.position="static";
			elem.style.position="static";
			//if (msgVar)elem.parentNode.style.background="initial"; 
			  }  
		},//end js function
	getComputedStyle	: function(el, styleProp) {// from https://gist.github.com/cms/369133#file-getstyle-js-L1
		if (typeof el === "string"){
			var el =  (el == 'body') ? document.getElementsByTagName("body")[0] : document.getElementById(el)
			//var elem=document.getElementById(ele)
			}
		var value, defaultView = el.ownerDocument.defaultView;
		// W3C standard way:
		if (defaultView && defaultView.getComputedStyle) {
			// sanitize property name to css notation (hypen separated words eg. font-Size)
			styleProp = styleProp.replace(/([A-Z])/g, "-$1").toLowerCase();
			return defaultView.getComputedStyle(el, null).getPropertyValue(styleProp);
			}
		else if (el.currentStyle) { // IE
			 // sanitize property name to camelCase
			styleProp = styleProp.replace(/\-(\w)/g, function(str, letter) {
			return letter.toUpperCase();
			});
			value = el.currentStyle[styleProp];
			// convert other units to pixels on IE
		  if (/^\d+(em|pt|%|ex)?$/i.test(value)) { 
			return (function(value) {
			 var oldLeft = el.style.left, oldRsLeft = el.runtimeStyle.left;
			 el.runtimeStyle.left = el.currentStyle.left;
			 el.style.left = value || 0;
			 value = el.style.pixelLeft + "px";
			 el.style.left = oldLeft;
			 el.runtimeStyle.left = oldRsLeft;
			 return value;
			})(value);
			}
		  return value;
			}
		},
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
	 
	toggleClass   : function (ele, classN, timeout) { 
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
			act.className = act.className.replace(classN, 'transitionEase' )
			act.style.display='block';
			setTimeout(function(){
			act.className = act.className.replace('transitionEase','')
			},1000);
			}
		else { 
			act.classList ? act.classList.add(classN) : act.className += ' '+classN;
			
			}
			
		},
	toggleClassOut   : function (ele, classN, timeout) {
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
			act.className = act.className.replace(classN, '' )
			}
		else {
			setTimeout(function(){
				act.classList ? act.classList.add(classN) : act.className += ' '+classN;
				},1000);
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
		
	precisionAdd  : function (obref,name,beg, end,  size, unit, factor, msg, unit2)  { 
		obref.innerHTML='';
		var mode=arguments[9];
		var increment=(mode==='increment')?factor:1;
		var increment=(mode==='incrementConvert')?arguments[10]:increment;
		var shownum=(mode==='spacing')?size*factor:parseFloat((size/factor).toFixed(2))
		var show=(unit2!==''&&unit2!=='addunit'&&this.isNumber(size))?'&nbsp;&nbsp; '+shownum+unit2:''
		var uni=(unit2!==''&&this.isNumber(size))?unit:''
		var replace = msg+ '<select class="editfont editbackground" name="'+name+'"><option value="'+ size/factor +'" selected="selected">'+ size+uni+show+'</option>';
		 if(arguments[9]!=='increment'||arguments[9]!=='incrementConvert')end++;  
		 else end=parseInt(end)+parseFloat(increment);   
		var optvalunit=(unit2==='addunit')?unit:''; 
		for (var i=beg;  i <  end; i = parseFloat(i) + parseFloat(increment)){
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
			else if (arguments[9]==='increment') {
				var optval=Number(i) 
				var dec=increment.toString().split('.');
				if (dec.length===2){
					var optdec=parseInt(dec[1].length);
					optval=optval.toFixed(optdec);
					}    
				replace+='<option value="'+optval+'">'+optval +unit+'</option>';
				}
			else if (arguments[9]==='incrementConvert') {
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
		replace+='</select> ';  
		var newp = document.createElement('p');
		newp.setAttribute("class", "editcolor prevB");
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
			if (this.ajax.responseText.length > 12) { 
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
					else {  
						var mainobj=document.getElementById(jsonitems[i]);
						i++;  
						mainobj.innerHTML=jsonitems[i]; 
						}
					}//end for
				}//ajax repsonse.length
			else {
				if (this.ajax.responseText=='no return'){
					console.log( 'No Return Values Found in Database');
					}
				else if (this.ajax.responseText.length>0){
					console.log( this.ajax.responseText);
					}
				else console.log( 'JasonMistake in handle replace');
				}
			 
			}//ready state
		},//end handle_replace
		
	handle_image	:  function () { 
		if ( (this.ajax.readyState == 4) && (this.ajax.status == 200) ) {
			if (this.ajax.responseText.length > 10) {
				console.log(this.ajax.responseText);  
				jsonitems = JSON.parse(this.ajax.responseText); 
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
		//f.style.height=pwidth/aspect+'px';  
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
		img.onload = function() { callback(true); };
		img.onerror = function() { callback(false); };
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
	keyUp  :	function(value,arr){
		max= (arguments[2])?arguments[2]:gen_Proc.maxPicLimit; 
		var prev=0;
		for (i in arr){  
			if (arr[i] >=value){
				if (arr[i] <= gen_Proc.maxPicLimit) 
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
		}
		

	}//end Gen Proc
EOD;

    }//end  Gen Proc
    
} //end class  
?>