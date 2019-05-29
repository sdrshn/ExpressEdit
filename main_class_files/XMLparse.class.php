<?php
#ExpressEdit 2.0
class XMLparse {
    const dir='musicXML/';
    const  db='musicXML.db';
    
/*    $GLOBALS['normalizeChars'] = array(
'Á'=>'&Aacute;', 'É'=>'&Eacute;', 'Í'=>'&Iacute;', 'Ó'=>'&Oacute;', 'Ú'=>'&Uacute;', 'Ñ'=>'&Ntilde', 'á'=>'&aacute;', 'é'=>'&eacute;', 'í'=>'&iacute;', 'ó'=>'&oacute;', 'ú'=>'&uacute;', 'ñ'=>'&ntilde');

function makeit($toChange){
return strtr($toChange, $GLOBALS['normalizeChars']);
}*/
   
        
        
    
static function parseItunes($lib){ 
    if (!file_exists(XMLparse::dir.XMLparse::db))file_put_contents(XMLparse::dir.XMLparse::db,'');
    $filetimearray=json_decode(file_get_contents(XMLparse::dir.XMLparse::db),true);
    if   (file_exists(XMLparse::dir.$lib.'.json')&&!empty($filetimearray)&&array_key_exists($lib,$filetimearray)&& filemtime(XMLparse::dir.$lib.'.xml')==$filetimearray[$lib]){
        $attributes=json_decode(file_get_contents(XMLparse::dir.$lib.'.json'), true);
        }
    else {//return  filemtime(XMLparse::dir.$lib.'.xml') .' is filttime of the file  and arry of '.$lib. 'is '.$filetimearray[$lib]; 
        $data=file_get_contents(XMLparse::dir.$lib.'.xml');
        $data=str_replace('%5B','openbracket',$data);
        $data=str_replace('%5D','closebracket',$data);
        $data=str_replace('%20',' ',$data);
        $data=str_replace('&#38;','ampersandxx',$data);
        $data=str_replace('localhost/G:','localhost/E:',$data);
        $data=str_replace('localhost/E:/My Music2','localhost/E:',$data);
           preg_match_all("/localhost\/E:\/(.*)\/string/Us",$data,$matches);
	   //preg_match_all("/localhost\/E:\/My Music2\/(.*)\/string/Us",$data,$matches);
        foreach ($matches[1] as $match){ 
            $remove=str_replace('/','xxslashxx',$match);
            $data=str_replace($match,$remove,$data);
            }
        $data= preg_replace('/[^A-Za-z0-9\-\& \(\)\_\,\@\"\'\%\!\.]/', '', $data);//get rid of
	   //file_put_contents('tmp', $data);
        //$data=preg_replace('/\>\>/','',$data);
        $attributes=array();
        $att=array();
         // echo $data; exit();
       //$attr=array('Names','Artist','Album','Kind','Size','Total Time','Date Modified','Date Added','Bit Rate','Sample Rate','Normalization','Location');
        $attr=array('Names','Artist','Album','Total Time','Bit Rate','Location');
        $pattern='dictkeyTrack\ ID(.*)keyLibrary Folder Count';
	   preg_match_all("/$pattern/Us",$data,$matches); //U for ungreedy  s for newlines  //x for whitespace
         $i=0;
        ${'pattern'.$i}='keyNamekeystring(.*)string'; 
        $i++;   ${'pattern'.$i}='keyArtistkeystring(.*)string';
        $i++;   ${'pattern'.$i}='keyAlbumkeystring(.*)string';
        //$i++;   ${'pattern'.$i}='keyKindkeystring(.*)string';
       // $i++;   ${'pattern'.$i}='keySizekeyinteger(.*)integer';
         $i++;   ${'pattern'.$i}='keyTotal Timekeyinteger(.*)integer';
       // $i++;   ${'pattern'.$i}='keyDate Modifiedkeydate(.*)date';
        //$i++;   ${'pattern'.$i}='keyDate Addedkeydate(.*)date';
        $i++;   ${'pattern'.$i}='keyBit Ratekeyinteger(.*)integer';
       // $i++;   ${'pattern'.$i}='keySample Ratekeyinteger(.*)integer';
        //$i++;   ${'pattern'.$i}='keyNormalizationkeyinteger(.*)integer';
          $i++;   ${'pattern'.$i}='keyLocationkeystringfilelocalhostE(.*)string';
       // $i++;   ${'pattern'.$i}='keyLocationkeystringfilelocalhostEMy Music2(.*)string';
        
        foreach($matches[1] as $data){	    
            for ($i=0; $i<6; $i++){ 
                 preg_match_all("/${'pattern'.$i}/Us",$data,$match2);
                 $value= (key_exists(0,$match2[1]))?$match2[1][0]:'Who Am I';
                  $att[$attr[$i]]=$value;
                 }
            $attributes[]=$att;
            }  
        file_put_contents(XMLparse::dir.$lib.'.json',json_encode($attributes));
        $filetimearray=json_decode(file_get_contents(XMLparse::dir.XMLparse::db),true);
        (empty($filetimearray))&&$filetimearray=array();
        $filetimearray[$lib]=filemtime(XMLparse::dir.$lib.'.xml');
        file_put_contents(XMLparse::dir.XMLparse::db,json_encode($filetimearray));
            }//end else
    return $attributes;

        }//end consturct
    }#end class
            ?>
       
  
            