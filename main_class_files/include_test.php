<?php 
$arr=explode(',','a,abbr,address,area,article,aside,audio,b,base,bdi,bdo,blockquote,body,br,br/,br /,button,canvas,caption,cite,code,col,colgroup,data,datalist,dd,del,details,dfn,dialog,div,dl,dt,em,embed,fieldset,figcaption,figure,footer,form,h1,h2,h3,h4,h5,h6,head,header,hgroup,hr,html,i,img,input,ins,kbd,keygen,label,legend,li,link,main,map,mark,menu,menuitem,meta,meter,nav,noscript,ol, optgroup,option,output,p,param,pre,progress,q,rb,rp,rt,rtc,ruby,s,samp,section,select,small,source,span,strong,style,sub,summary,sup,table,tbody,td,template,textarea,tfoot,th,thead,time,title,tr,track,u,ul,var,video,wbr');
$text='';
 foreach($array as $var){
     $text.='</br> some text <'.$var.'> more text';
     }
$data=mb_convert_encoding($text, 'HTML-ENTITIES');
printer::alert($data); 
?>

 