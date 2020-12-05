<?php
#ExpressEdit 3.01
class forms {

static function form_process($array,$default_arr=''){ //default_arr tells which values to keep at default value. Currently works on text, textarea fields...
	 $ref_array=array('tablename','database');
	$default_arr=(is_array($default_arr))?$default_arr:explode(',',$default_arr);
	$pass_arr=array();
	$i=0;
	foreach ($array as $arr){
		if (is_array($arr['name'])){
			if ($arr['type']!='checkbox'){#ref can be keywords for dropdown menu's...for example tablename and database
				$ref=$arr['ref'];#
				$pass_arr[$ref]=$_POST[$ref];// the rendered choice...
				$array[$i]['selected']=$_POST[$ref];//for presenting next round  this is a way to pass back important keywords from dropdown etc. menu...
				}
			else {
				foreach ($arr['name'] AS $key=>$var){
					$ref=$arr['ref'];
					$type=$arr['type'];
					if ($type=='checkbox'){//see display class for example
						#set value of col[#name] by checking whether passed with post col and selected with post field   if yes and no then false otherwise true
						$pass_arr[$ref][$key]=(isset($_POST['col'][$key])&&!(isset($_POST[$ref][$key])))?false:true; #setup multi array so values can be updated with post!!
		         			$array[$i]['name'][$key]=$pass_arr[$ref][$key];
						 
						}#end if checkbox
					else {#not checkbox and not sure what this is ready for!!
						if (isset($_POST[$ref][$key])){# not checkbox 
							$pass_arr[$ref][$key]=trim($_POST[$ref][$key]);
							$array[$i]['name'][$key]=trim($_POST[$ref][$key]);
							}
						else {#do nothing to $array!
							$pass_arr[$ref][$key]=$array[$i]['name'][$key];
							}
						}#end not checkbox
					}#end foreach
				}
			}#end is array
		else{#is not array	 
			if (isset($_POST[$arr['name']])){ 
				$pass_arr[$arr['name']]=trim($_POST[$arr['name']]);
					if (!in_array($arr['name'],$default_arr)){#these will keep these array values at default  ie so that mistakes don't happen
						$array[$i]['value']=trim($_POST[$arr['name']]);
						}	
					}
				else{
					$pass_arr[$arr['name']]=$arr['value'];
					#keep $array same
					}
				  
			}#end else not array
			
		$i++;
		}#end   foreach array 
	
	 return array($pass_arr,$array);
	}#end function form process
	
static function form_render($array,$form_top='',$form_bot='',$hidden_arry=''){
	self::form_open($form_top);
	foreach ($array as $arr){
		 switch ($arr['type']) {
			case 'textarea':
			   $var1='rowlength';
			   $var2='columns';
			   break;
			case 'checkbox':
			   $var1='ref';
			   $var2='check';
			    break;
			case 'dropdown':
			   $var1='ref';
			   $var2='selected';
			    break;
			case 'radio_array':
			   $var1='ref';
			   $var2='selected';
			    break;
			default:
			   $var1='show_size';
			   $var2='maxlength';
			}//end switch
		$function='form_'.$arr['type'];
		self::$function($arr['name'],$arr['value'],$arr['text1'],$arr['text2'],$arr[$var1],$arr[$var2]);
		}
	self::form_close($form_bot);
	}
	
static function form_open($form_top='',$onload=''){
	echo' <form action="'. Sys::Self.'" method="post" '.$onload.' >';
	echo $form_top;
	}

static function form_text($name,$value,$text1,$text2,$show_size='',$maxlength=''){ 
	echo '<p class="ramana">'.$text1.'<input type="text" name="'.$name.'" value="'.$value.'" size="'.$show_size.'" maxlength="'.$maxlength.'" >'.$text2.'</p>';
	}

static function form_radio($name,$value,$text1,$text2,$show_size='',$maxlength=''){ 
	$value2=($value==true)?false:true; 
	$value3=($value==true)?false:true;
	$value1=($value==true)?true:false; 
	echo'  <fieldset ><legend>'.$text1.'</legend>
	<p class="ramana"><input type="radio" name="'.$name.'" checked="checked" value="'.$value.'"><span style="color:#'.Cfg::RedAlert_color.';"> '.$text2.': '.$value1.' </span></p>
	<p class="ramana"><input type="radio" name="'.$name.'" value="'.$value2.'">'.$text2.': '.$value3.'</p> 
	</fieldset>';
	}
	
static function form_radio_array($names,$val,$text1,$text2,$ref,$selected='',$fieldset=true){ 
	$x=0;
	echo'  <fieldset ><legend>'.$text1.'</legend>';
	foreach ($names AS $name){
		echo'<p class="ramana"><input type="radio" name="'.$ref.'"   value="'.$name.'">'.$val[$x].'</p>';
		$x++;
		}
	echo'</fieldset>';
	}
	
 static function form_close($form_bot='',$submit="Find/replaceThis",$submitted='submitted'){
	echo $form_bot;
	$sess=session::instance(); 
echo'<p><input type="hidden" name="sess_token" value="'. $sess->sess_token .'" ></p>';
	echo'<p> <input type="hidden" name="'.$submitted.'" value="TRUE" ></p>
  <p><input style="font-size:8px;padding: 0 1px;" type="submit" name="submit" value="'.$submit.'" ></p>
</form> ';
}


static function form_dropdown($names,$vals,$text1,$text2,$ref,$selected='none',$fieldset=true,$class='ramana',$adjust_factor=''){
	$vals=(is_array($vals)&&count($names)==count($vals))?$vals:$names;
	if ($fieldset) echo '
    <fieldset><legend class="editcolor editbackground">'.$text1.'</legend> <p class="'.$class.'">';
    else echo '<p class="editcolor editbackground">'.$text1;
     $fontsize=(!empty($adjust_factor)&&($adjust_factor/strlen($selected))<16)?($adjust_factor/strlen($selected)):16;
     echo'
     <select class="editcolor editbackground" name="'.$ref.'"> ';       
     echo '<option class="editcolor editbackground" style="font-size:'.$fontsize.'px;" value="'.$selected.'" selected="selected">'.$selected.'</option>';
     for ($i=0;$i<count($names);$i++){
          $fontsize=(!empty($adjust_factor)&&($adjust_factor/strlen($names[$i]))<16)?($adjust_factor/strlen($names[$i])):16;
          echo '<option class="editcolor editbackground" style="font-size:'.$fontsize.'px;" value="'.$names[$i].'">'.$vals[$i].'</option>';
          }
     echo'	
    </select>'.$text2;
    
     if ($fieldset) echo '</p></fieldset>';
	else echo '</p>';
     }
 
static function form_checkbox ($name,$val,$text1,$text2,$ref,$check){
     $java= <<<EOD
	<script language="JavaScript" type="text/javascript">
<!--
var checkflag = "false";//  sets up intial variable...  as global
function check(frm,field) {
if (checkflag == "false") {
for (i = 0; i < frm.length; i++) {
if(frm[i].type=='checkbox'&&frm[i].name.indexOf(field)>-1){
frm[i].checked = true;
}
}
checkflag = "true";
return "Uncheck All"; }
else {
for (i = 0; i < frm.length; i++) {
if(frm[i].type=='checkbox'&&frm[i].name.indexOf(field)>-1){//means proceed if form name of field is strpos
frm[i].checked = false;
}
}
checkflag = "false";
return "Check All";
}
}
//-->
</script>
EOD;
     echo $java;
	foreach ($name AS $field=>$value){  
		if($value) $checked='checked="checked"';
		else $checked='';
		echo'<p class="ramana" style="font-size: 1.3em;">'.$text1.'&nbsp;&nbsp;'.$field.' '.
		'<input name="'.$ref.'['.$field.']" type="checkbox" '.$checked.' value="'.$value.'" >'.$text2.'</p>';
		echo'<p><input name="col['.$field.']" type="hidden" value="'.$value.'" ></p>';#do this for reference as unchecked will not get passed!!!
		}
	echo'<p><input type="button" value="Check All" onClick="this.value=check(this.form,\''.$ref.'\')"><br><br></p>';
	}
static function form_textarea($name,$value,$text1,$text2,$rowlength,$columns){
	if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	echo ' <p class="ramana">'.$text1.'<textarea name="'.$name.'" rows="'.$rowlength.'" cols="'.$columns.'"  
	onkeyup="gen_Proc.autoGrowField(this)">' .$value.'</textarea></p>';
	}

}#enc class searc
?>