function edit_styles_close($element,$style_field,$css_classname,$show_list='',$mod_msg="Edit styling",$show_option='',$msg='',$mainstyle=false,$clone_option=true){

$load=new fullloader(); 
 $load->fullpath('image_directory.class.php');



checked=
for ($i=1; $i<7; $i++){
			${'checked'.$i}='';	
			}
		$checked='checked="checked"'; 
		switch ($blog_data2[$preview_index]) {
			case 'highslide_multiple' :
			$gall_display='highslide';
			$preview_display='multiple';
			$checked1=$checked;
			$show_under_preview=false;
			break;



try
INSERT INTO tbl_temp2 (fld_id)
  SELECT tbl_temp1.fld_order_id
  FROM tbl_temp1 WHERE tbl_temp1.fld_order_id > 100;
  
  
doesn't workq
 
  CREATE TEMPORARY TABLE chan2 ENGINE=MEMORY;
  SELECT * FROM vwpkbpmy_bmtwebsite.master_post WHERE blog_id=4;
  UPDATE chan2 SET id=NULL;
  INSERT INTO vwpkbpmy_expresswebsite.master_post SELECT * FROM chan2;
  DROP TABLE chan2; 
CREATE TEMPORARY TABLE temp_table ENGINE=MEMORY

SELECT * FROM your_table WHERE id=1;
UPDATE temp_table SET id=NULL; /* Update other values at will. */

INSERT INTO your_table SELECT * FROM temp_table;
DROP TABLE temp_table;
&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
 $r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	if (!$this->mysqlinst->affected_rows())$themename='theme1';
	else {
		$themearr=array();
		while (list($page_ref2,$page_filename2) = $this->mysqlinst->fetch_row($r,__LINE__)){
		
		 
		$bp_arr=$this->page_break_arr;
		$this->imagecss.='
		@media screen and (min-width: '.($bp_arr[0]+1).'px){';
	 
		$this->imagecss.='
		 .'.$data.'_img {width:'.($this->grid_width_chosen_arr['max'.$bp_arr[0]]*$wpercent/100-$shadowcalc).'px;max-width:'.$maxwidth_adjust_shadow_calc.'%;
		 }
		';
		 
		$this->imagecss.='}
		';
		$max=count($bp_arr);
		for ($bc=0; $bc<$max; $bc++){
			$bp=$bp_arr[$bc];
			$mw=$minw='';
			if ($bc < $max-1){
				$minw=' and (min-width:'.($bp_arr[$bc+1]).'px)';
				$mw='-'.$bp_arr[$bc+1];
				}
			else $mw='-'.$bp;
			$this->imagecss.='
			@media screen and (max-width: '.($bp).'px)'.$minw.'{';
			$this->imagecss.='
			 .'.$data.'_img {width:'.($this->grid_width_chosen_arr[$bp]*$wpercent/100-$shadowcalc).'px;max-width:'.$maxwidth_adjust_shadow_calc.'%;
			 }
			';
			  
			$this->imagecss.='}';
			}
  
			
	 
&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
if($this->column_use_grid_array[$this->column_level]!=='use_grid'){
		$gridstyle='style="display:none;background:#fdf0ee;"';
		printer::printx('<p class="editbackground info floatleft" title="Enable Responsive Web Sizing/Positioning for Posts Within This Column"><input type="checkbox" name="'.$tablename.'_column_options['.$this->column_use_grid_index.']" onclick="edit_Proc.displaythis(\''.$tablename.'_grid_show\',this,\'#fdf0ee\')" value="use_grid">Enable RWD Positioning for Posts Within This Column</p>');
		printer::pclear();	
		}
	else{
		printer::printx('<p class="fsminfo editbackground info left">Posts within this column are set to RWD display on grid.</p>');
		 $gridstyle='style="display:block;background:#fdf0ee;"';
		printer::printx('<p class=" editbackground info left" '.$gridstyle.' title="Disable Responsive Web Sizing for Posts Within This Column"><input type="checkbox" name="'.$tablename.'_column_options['.$this->column_use_grid_index.']"  value="0">Disable RWD Positioning for Posts Within This Column</p>');
		printer::pclear();
		}
	printer::pclear();
	$msg='';
	$grid_units=(is_numeric($this->column_options[$this->column_grid_units_index])&&$this->column_options[$this->column_grid_units_index]>11&&$this->column_options[$this->column_grid_units_index]<101)?intval($this->column_options[$this->column_grid_units_index]):Cfg::Column_grid_units;
	if($this->column_use_grid_array[$this->column_level]==='use_grid'){//setup conditions for all posts within column  note that self ::rwd build called before enabling correct parent column vals
		$this->column_grid_css_arr[]=$grid_units.'@@'.$this->page_break_points;//for rendering css
		$this->current_grid_units=$grid_units;//for choosing post width class
		//$this->current_break_points=$this->column_break;//for choosing post width class
		}
	echo '<div id="'.$tablename.'_grid_show" '.$gridstyle.'><!--show Grid opts-->';
	$this->show_more('Grid info choice','noback','smaller editbackground italic editcolor');
	echo'<div class="fsminfo editbackground editcolor floatleft" > By Default the RWD system uses a "Grid System" with 100 grid units or 1 percent of the row width for each gu chosen for posts and .5gu increments for any spacing between posts. In the event even smaller spacing increments are necessary up to 200 grid units may be chosen. Note:(Higher Grid Unit Choices will not produce extra class styles as only the relevant choices are generated"';

&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
if ((isset($_POST['submit'])


	printer::alertx('<div class="'.$this->column_lev_color.' width400  floatleft left fsminfo editbackground editfont">Positioning your columns and posts are key to making your website content look interesting! ');
	
	printer::pclear();
	
&&&&&&&&&&&&&&&&&&&&&7	
     
     echo '<div class="'.$this->column_lev_color.'  floatleft left fsminfo editbackground editfont"><!--wrap break point-->';
	printer::alertx('<p class="fs1'.$this->column_lev_color.'  floatleft" title="Break Points Determine when Content Should Break to the Next Line Depending on the Device Screen Size">Choose Your Break Points');
	printer::pclear();
	}
&&&&&&&&&&&&&&&&&&&&&&&&&&&&

			$path_parts=pathinfo($vidname);
			$ext=(array_key_exists('extension',$path_parts))?$path_parts['extension']:'';
               #######################################################333
	
	 <input  style="color:red;background:#te;" type="text" name="comment_name['.$this->blog_id.']" id="comment_name_'.$this->blog_id.'" size="'.$size.'" maxlength="35" value=""> ');
	 
&&&&&&&&&&&&&&&&&&&&&&&&&
			
	    $count=$this->mysqlinst->count_field($this->master_post_table,'blog_id','',false,$where);
	    
&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
	   $q="update $this->post_params_table set  col_update='".date("dMY-H-i-s")."',col_time='".time()."',token='".mt_rand(1,mt_getrandmax()). "' where col_id=$child_id";
	    
	   $q="update $this->master_post_table set token='".mt_rand(1,mt_getrandmax()). "',blog_update='".date("dMY-H-i-s")."',blog_time='".time()."' where
	   
	   
   $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);  
###&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
	$q="insert into $this->master_post_css_table (css_id,blog_id,$post_fields,blog_update,blog_time,token) values ($css_id,'p$blog_id',$value '".date("dMY-H-i-s")."','".time()."','".mt_rand(1,mt_getrandmax())."')";   
&&&&&&&&&&&&&&&&&&&&&&&&&
$q="UPdate $this->master_page_table set page_update='".date("dMY-H-i-s")."', page_time=".time().",token='".mt_rand(1,mt_getrandmax()). "',page_filename='$filename' where page_ref='$dir_ref'";
	$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&7

 $q="update $this->master_post_table as c, $this->master_post_table as p set ";
   $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);  
   $this->success[]="Your post Id: P$parent_id has been copied!";
                                                            
&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&												
 printer::printx ('<p onclick="edit_Proc.displaythis(\''.$data.'_comments_show\',this,\'#fdf0ee\')"  class="info floatleft" title="Check to enable Viewers to Submit for Display Comments to this Post"><input type="checkbox" name="'.$data.'_blog_options['.$this->blog_comment_index.']" value="1">Allow Commenting</p>');
		printer::pclear();
		$genstyle=(!empty($this->blog_options[$this->blog_comment_index]))?'style="display:block;background:#fdf0ee;"':'style="display:none;"';
		$checked1=(empty($this->blog_options[$this->blog_comment_display_index]))?'checked="checked"':'';
		$checked2=(!empty($this->blog_options[$this->blog_comment_display_index]))?'checked="checked"':'';
printer::printx('<p id="'.$data.'_comments_show" '.$genstyle.'><input type="radio" '.$checked1.' name="'.$data.'_blog_options['.$this->blog_comment_display_index.']" value="0" >Hide-n-Click to Open Comments<br><input type="radio" '.$checked2.' name="'.$data.'_blog_options['.$this->blog_comment_display_index.']" value="1" >Display Comments Directly</p>');
		}// if text and float image text types
&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
		printer::printx('<div title="Change this default width+height value '.$maxplus.' for this image." id="'.$data.'_expandsize_show" '.$genstyle.' class="fsminfo info background:#fdf0ee;"><!--imageplus-->Change Expanded Image height + width setting:');
		
		self::mod_spacing($data.'_blog_options['.$this->blog_max_expand_image_index.']',$maxplus,25,2800,1,'px');
		printer::printx('</div><!--imageplus-->');
&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
Choose:    
		<select class="editcolor editbackground"  name="'.$data.'_socialdata['.$num.'][2]">        
		<option class="editcolor editbackground" value="'.$size.'" selected="selected">'.$size.'</option>';
		for ($i=$range1; $i<=$range2; $i+=$increment){
		   echo '<option class="editcolor editbackground" value="'.$i.'">'.$i.$unit.'</option>';
		   }
		echo'	
		</select> </p><!--Change Icon Size-->';
&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&77
//system(Sys::Mysqlserver."mysqldump   -h".Cfg::Dbhost." -u".Cfg::Dbuser." -p".Cfg::Dbpass." --ignore-table=$dbname.backups_db  --add-drop-table --no-data $dbname | grep ^DROP | ".Sys::Mysqlserver."mysql -h".Cfg::Dbhost." -u".Cfg::Dbuser."   $dbname");  Not necessary to predrop
			//$q="DROP TABLE IF EXISTS ". Cfg::Db_tables;
               
          ##################################################33

Snippets unused
#####################33333
/*if (!$this->is_page){
			$this->show_more('Display On/Off base on Media Screen Size');
			echo '<div class="editbackground fsminfo"><!--advanced media screen min max size-->';
			$display_on_off=($this->is_blog)?'blog_display_on_off_index':'column_display_on_off_index';
			$option=($this->is_blog)?'blog_options':'column_options';
			$minmax=($this->is_blog)?'blog_media_minmax_index':'column_media_minmax_index';
			$minmax_val=$this->{$option}[$this->$minmax];
			$minmax_val=(strlen($minmax_val<2))?'':$minmax_val;//remove false 0 for switch case
			$media_display=$this->{$option}[$this->$display_on_off];
			$mediasize=($this->is_blog)?'blog_media_px_index':'column_media_px_index';
			$mediasize_val=($this->{$option}[$this->$mediasize]>201&&$this->{$option}[$this->$mediasize]<2000)?$this->{$option}[$this->$mediasize]:'';
			
			$check1=$check2=$check3='';
			$checked='checked="checked"';
			switch ($minmax_val){
				case 'media_min':
				$check2=$checked;
				break;
				case 'media_max':
				$check3=$checked;
				break;
				default :
				$check1=$checked;
				break;
				}
			printer::printx('<div class="fs2orange editbackground">Choose display property based on User Screen view Size. Will Use Media Query to determine size and turn Display Off or Display On For this Column or Post based on the Choices Made Here<br>Choose @media Transition Rule');
			
			printer::printx('<p><input type="radio" name="'.$this->data.'_'.$option.'['.$this->$minmax.']" value="none" '.$check1.'>None</p>');
			printer::printx('<p><input type="radio" name="'.$this->data.'_'.$option.'['.$this->$minmax.']" value="media_min" '.$check2.'>@media min-width</p>');
			printer::printx('<p><input type="radio" name="'.$this->data.'_'.$option.'['.$this->$minmax.']" value="media_max" '.$check3.'>@media max-width</p>');
			########### 
			echo '</div>'; 
			$check4=$check5=$check6='';
			$checked='checked="checked"';
			switch ($media_display){
				case 'media_on':
					$check4=$checked;
					break;
				case 'media_off':
					$check5=$checked;
					break;
				default :
					$check6=$checked;   
					break;
				}
			echo '<div class="fs2orange editbackground" >Choose Corresponding Display on or off When @media Query Screen Size is met';
			
			printer::printx('<p><input type="radio" name="'.$this->data.'_'.$option.'['.$this->$display_on_off.']" value="none" '.$check4.'>Default: Always On');
			printer::printx('<p><input type="radio" name="'.$this->data.'_'.$option.'['.$this->$display_on_off.']" value="media_on" '.$check5.'>Meets Media Rule &amp; Display On</p>');
			printer::printx('<p><input type="radio" name="'.$this->data.'_'.$option.'['.$this->$display_on_off.']" value="media_off" '.$check6.'>Meets Media Rule &amp; Display Off</p>');
		echo '</div>';
		echo '<div class="fs2orange editbackground" >';
		printer::printx('<p class="'.$this->column_lev_color.' editbackground">Choose @media Query Screen px to respond </p>');
		
		 $msgjava='Choose @media px if Meets Media Rule selection is chosen.  Enables you to appear or disappear this Post or Column at the width and rule you choose here :';  
			echo '<div class="info smallest click" onclick="gen_Proc.precisionAdd(this,\''.$this->data.'_'.$option.'['.$this->$mediasize.']\',200,\'2000\',\''.(intval(ceil($this->column_total_width[$this->column_level]*10)/10)).'\',\'px\',\'1\',\''.$msgjava.'\');">Choose @media px</div>';
			
		echo '</div>';	
			echo '</div><!--advanced media screen min max size-->';
			$this->show_close('Display On/Off base on Media Screen Size');
			}//not is page*/
               ###########################################33
               
               worksheet for spaecial width
             if ($this->edit){
		
		if(isset($_POST[$style.'_percent'][$val])||isset($_POST[$style.'_maxwidth'][$val])){
			$pmaxwid=(isset($_POST[$style.'_maxwidth'][$val]))?str_replace('maxwidpx','',$_POST[ $style.'_maxwidth'][$val]):0;
			$perwid=(isset($_POST[$style.'_percent'][$val]))?str_replace('%','',$_POST[ $style.'_percent'][$val]):0;
			}
		if (empty($pmaxwid)&&!empty($perwid)){
			$this->{$style}[$val]=$_POST[$style.'_percent'][$val];
			$q="update
			
		}
     $numval=str_replace(array('maxwidpx'.'widpx','%'),'',$this->{$style}[$val]);
	$widtype=(strpos($this->{$style}[$val],'widmaxpx')===false)?'width:':'max-width:';
	$finalunit=(strpos($this->{$style}[$val],'%')===false)?'px;':'%;';
$wid=(!empty($numval)&&is_numeric($numval)&&$numval>0)?$numval:'none';
	$widunit=($wid==='none')?$wid:$this->{$style}[$val];
	$maxspace=1000;
	$minspace=0;
	$this->show_more('Custom Width', 'noback','editfont editbackground infoclick',' Choose Your Max-width Special',500);
	printer::print_wrap('widthspecialwrap','Os3salmon fsminfo float');
	printer::alertx('<p class="'.$this->column_lev_color.' editbackground editfont">Choose one of the 3 following width methods. For uniform spacing on smaller width. Max-width will compress when widths overrun screen size. Percent will compress uniformly on shared rows. <br>Current Width: '.$widunit.'<br> Use 0 to remove if needed</p>');
	$msgjava='Set Width in px:';
	echo '<div class="editcolor editfont editbackground click" onclick="gen_Proc.precisionAdd(this,\''.$style.'['.$val.']\',0,\''.$maxspace.'\',\''.$wid.'\',\'widpx\',\'1\',\''.$msgjava.'\',\'addunit\');">Set Width in px</div>';
	printer::pclear(8);
	$msgjava='Set Max-Width in px:';
	echo '<div class="editcolor editfont editbackground click" onclick="gen_Proc.precisionAdd(this,\''.$style.'_maxwidth['.$val.']\' ,0,\''.$maxspace.'\',\''.$wid.'\',\'maxwidpx\',\'1\',\''.$msgjava.'\',\'addunit\');">Set Max-width in px</div>';
	printer::pclear(8);
	$msgjava='Set Max-Width in %:';
	echo '<div class="editcolor editfont editbackground click" onclick="gen_Proc.precisionAdd(this,\''.$style.'_percent['.$val.']\',0,\'100\',\''.$wid.'\',\'%\',\'1\',\''.$msgjava.'\',\'addunit\' );">Set % Width </div>';
	printer::close_print_wrap('widthspecialwrap');
	$this->show_close('Custom Max Width');
	$fstyle='final_'.$style; 
     $this->{$fstyle}[$val]=(is_numeric($numval)&&$numval>0)?$widtype.$numbal.$finalunit:'';
     #############################################################################
     if(obje.style.display=="block"){
			obje.style.display ="none";
			if (idobj.innerHTML.indexOf("Close ")!=-1){ console.log(idobj.innerHTML);
				 
				//appO.removeChild(appO.childNodes[0]);
				}
			}
		else{
			if (idobj.innerHTML.indexOf("Close ")==-1){ 
				//html=document.getElementById(refid).innerHTML; 
				 
				var node = document.createElement("SPAN");
				var tn = document.createTextNode("Close ");
				node.appendChild(tn);
				node.style.color="red"
				node.style.cssFloat = "left";
				 idobj.insertBefore(node, idobj.childNodes[0]);  
				}
			obje.style.display ="block";
               ##################################################################################3
  }	
if ($this->blog_type==='image'&&isset($ratio)){
			$px=$this->current_net_width*$wpercent/100;
			$this->show_more('Uniform Image Height Option');
			printer::print_wrap('wrap height info','fsminfo editcolor editbackground');
			printer::print_tip('For non-RWD grid image posts You can set An Image Height instead of Width By Changing this Value Here. Value must be at least 10px<br><b>Current Value: '.$height_set.'px');
			
		echo '<div class="fs1color floatleft"><!--Edit image Width Adjust-->';  
		$maxspace=$this->column_net_width[$this->column_level];  
		$msgjava='Choose Height Px:'; 
		$factor=1;
		echo '<div class="editcolor editfont editbackground click" onclick="gen_Proc.precisionAdd(this,\''.$data.'_blog_tiny_data3\',0,\''.$maxspace.'\',\''.$height_set.'\',\'px\',\''.$factor.'\',\''.$msgjava.'\',\'\',\'simple\');">Image Max Height Px</div>'; 
		echo '</div><!--Edit image Width Adjust-->';
			printer::close_print_wrap('wrap height info');
			$this->show_close('Image Height Info');
			}
               ###################################################3333
               var offsetParent=this.getOffsetRect(elem.parentNode);
			var parentTop=offsetParent.top;
               var offsetElemTop=offset.top
			var currTop=offsetElemTop-parentTop;
               //elem.style.top=currTop+30+'px'; 
				elem.style.top=currTop; 
			

function temp(){
	
	if (!$this->edit&&Sys::Web&&strpos(Sys::Self,'express_video')!==false){
		mail('info@expressedit.org','Entered Express Video','Video Express Alert');mail::alert('Entered Express Video','Video Express Alert'); } 
	return;
	 
 $q="update $this->master_post_table as c, $this->master_col_table as p set c.blog_grid_width=p.col_grid_width,c.blog_gridspace_right=p.col_gridspace_right,c.blog_gridspace_left=p.col_gridspace_left where c.blog_data1=p.col_id and c.blog_type='nested_column'";
   //$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);  
   	 echo $q; exit();
	
	
	return;
 $q="update $this->master_post_table as p, $this->master_post_table as g set p.blog_grid_width=g.blog_grid_class where p.blog_id=g.blog_id";
   $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);  
   	

	
 return;
 $q="update $this->master_post_data_table as p, $this->master_gall_table as g set p.blog_tiny_data4=g.imagetitle,p.blog_tiny_data5=g.subtitle where p.blog_data1=g.master_gall_ref ";
   $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);  
   	
	echo $q;   exit();

return;
	 $q="update $this->master_post_data_table as p, $this->master_gall_table as g set p.blog_data1=g.gall_ref where p.blog_table_base=g.gall_table and g.pic_order=1";
   $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);  
   	
	echo $q;
	return;
	$q="select distinct gall_table from $this->master_gall_table where master_gall_status=''";
	$r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	$garr=array();
	while (list($page_ref) = $this->mysqlinst->fetch_row($r,__LINE__)){
		$newpage_ref=process_data::clean_filename($page_ref);
		$where=" where page_ref='$newpage_ref'";
		$count=$this->mysqlinst->count_field($this->master_page_table,'page_id','',false,$where);
		if ($count >0 ){
			printer::alert_neg("NL. page ref $page_ref already created");
			continue;
			}
		echo NL." trying $page_ref ";
		$_POST['create_page']=$page_ref;
		$_POST['use_newpage_ref']='events';
		$this->add_new_page(true);
		}
	exit('done'); 
	
	return;
	$q="select blog_id,blog_table,blog_col from $this->master_post_table where blog_type='nested_column' and blog_table_base='$this->tablename'";
	$temp=$this->mysqlinst->query($q);
	
	while(list($blog_id,$blog_table,$blog_col)=$this->mysqlinst->fetch_row($temp)){ 
		$arr=explode('post_id',$blog_table);
		if (count($arr)!==2){
			printer::alert_neg("blog id $blog_id has table $blog_table");
			}
		else {
			if ($blog_col !==$arr[1]){
				$q="update $this->master_post_table set blog_col='{$arr[1]}' where blog_id=$blog_id";
				$this->mysqlinst->query($q);
				printer::alert_pos("blog_col was $blog_col and now updating with $q");
				}
			else printer::alert_pos("No changes ncess with $blog_id");
			}
		}//end while
	}//end temp
#__con	
function __construct($edit=false,  $return=false){
	if($return)return;
	//echo Sys::Dbname." is sys dbname";
	// printer::vert_print($_POST);
	$this->viewport_current_width=process_data::get_viewport();
	$this->color_arr_long=explode(',',Cfg::Light_editor_color_order);//default value
	$this->deltatime=time::instance(); $this->deltatime->delta_log('global construct delta'); 
	$this->column_width_array[0]='body'; 
	$this->edit=($edit=='edit')?true:$edit;// this is set in editpages for each web page individually....
	$this->ext=request::check_request_ext();  
	$this->page_initiate();    
	#****** Require login for  editsites and restricted  access ie.   display_user_db.php   display/    file_gen.php 
	if ((Sys::Web||(Sys::Loc&&Cfg::Force_local_login))&&(($this->edit&&!Sys::Pass_class)||Sys::Check_restricted)){//this is always on for security for editpages and other restricted utilities such as file_gen.php and display user pages see (Sys.php)
#logged_in #login
		new secure_login('ownerAdmin',false); //for access to editpages  
		}  
	$this->css_suffix=$this->passclass_ext=(Sys::Pass_class)?Cfg::Temp_ext:'';		 
	if ($this->edit && (isset($_POST['page_restore_view'])&&!empty($_POST['page_restore_view']))||(isset($_SESSION[Cfg::Owner.'db_to_restore'])&&isset($_GET['page_restore_dbopt'])))$this->db_backup_restore();
		
	$this->ajax_check();   
	(Sys::Onsubmitoff)&&$this->onsubmit='';
	 
	#*************  End Restrict Access
	
	if ($this->edit)$_SESSION[Cfg::Owner.'editmode']=1;//prevents pages from cacheing if cacheing were on also this session created when logged in or by request
	  
	if($edit==='return'){#class object invoked for global_function access only  by add_gallery utility
		$this->edit='return';
		return;
		}
	if (isset($_GET['xpzawn2'])){//this is a ajax response request to get accumulate further browser information from user see browser info();
		$this->browser_info();
		exit();
		}
	$indexes=explode(',',Cfg::Page_options);
	foreach($indexes as $key =>$index){
		if (!empty($index)) {
			$this->{$index.'_index'}=$key;  
			}
		}
	$backindexes=explode(',',Cfg::Column_options);
	foreach($backindexes as $key =>$index){   
		$this->{$index.'_index'}=$key;
		}
	$indexes=explode(',',Cfg::Style_functions );
	foreach($indexes as $key =>$index){
		if (!empty($index)) {
			$this->{$index.'_index'}=$key;
			  //print NL.  $index." = $key"; 
			}
		}
	
	$indexes=explode(',',Cfg::Blog_options);
	foreach($indexes as $key =>$index){
		if (!empty($index)) {
			$this->{$index.'_index'}=$key;  
			}
		}  
	$indexes=explode(',',Cfg::Style_functions );
	foreach($indexes as $key =>$index){
		if (!empty($index)) {
			$this->{$index.'_index'}=$key;
			 // print NL.  $index." = $key"; 
			}
		}
	$indexes=explode(',',Cfg::Main_width_options);
	foreach($indexes as $key =>$index){
		if (!empty($index)) {
			$this->{$index.'_index'}=$key;
			 // print NL.  $index." = $key"; 
			}
		}
	$indexes=explode(',',Cfg::Box_shadow_options );
	foreach($indexes as $key =>$index){
		if (!empty($index)) {
			$this->{$index.'_index'}=$key;
			 // print NL.  $index." = $key"; 
			}
		}
	$this->col_field_arr_all=explode(',',Cfg::Col_fields_all);
	$this->col_field_arr=explode(',',Cfg::Col_fields); 
	if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);  
	store::setVar('backup_clone_refresh_cancel',false);
	#buffer    ||($this->edit&&Sys::Pass_class)
	((!Sys::Debug&&!Sys::Norefresh&&(isset($_POST['submit'])||Sys::Bufferoutput))||isset($_GET['advanced'])||isset($_GET['advancedoff']))&&ob_start(); 
	if (Sys::Debug||Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__); 
	$this->set_cookie(); 
	$this->deltatime->delta_log('page initiate');
	
	$this->temp();  
	if ($this->edit){  
	$this->edit_script();
	   }	
	else {
	    // $this->request_redirect_check();
		$this->page_script();   
		}
	}//end __construct
	

scrollAnimate :	function(){//credit: George Martsoukos  www.sitepoint.com 
		\$animation_elements = \$('.animated');
		var \$window = \$(window);
		\$window.on('scroll resize', gen_Proc.check_if_in_view); 
		\$window.trigger('scroll');
		},
	check_if_in_view  :	function () {//credit: George Martsoukos  www.sitepoint.com  
		var window_height = \$(window).height();
		var window_top_position = \$(window).scrollTop();
		var window_bottom_position = (window_top_position + window_height);
	   
		\$.each( \$animation_elements, function() {
		  var \$element = $(this);
		  var element_height = \$element.outerHeight();
		  var element_top_position = \$element.offset().top;
		  var element_bottom_position = (element_top_position + element_height);
	   
		  //check to see if this current container is within viewport
		  if ((element_bottom_position  >= window_top_position ) &&
		    (element_top_position  + 250 <= window_bottom_position)) {
		    \$element.addClass('in-view');
		  }  
		});
		 
	   },





var target = document.querySelector('body');

var observer = new MutationObserver(function(mutations) {
  mutations.forEach(function(mutation) {
    console.log(mutation.type);
  });    
});

var config = { attributes: true, childList: true, characterData: true };
observer.observe(target, config);


  var observerConfig = {
                    attributes: true,
                    childList: true,
                    characterData: true,
                    subtree : true
            };



observer.disconnect();


##########
https://stackoverflow.com/questions/37168158/javascript-jquery-how-to-trigger-an-event-when-display-none-is-removed
var blocker  = document.querySelector('#blocker');
var previousValue = blocker.style.display;

var observer = new MutationObserver( function(mutations){
    mutations.forEach( function(mutation) {
        if (mutation.attributeName !== 'style') return;
        var currentValue = mutation.target.style.display;
        if (currentValue !== previousValue) {
           if (previousValue === "none" && currentValue !== "none") {
             console.log("display none has just been removed!");
           }

           previousValue = mutation.target.style.display;
        }
    });
});


<!--<!--<!--<!--<!--<!--<!--<!--<!--<!--<!--<!---->-->-->-->-->-->-->-->-->-->-->-->
https://stackoverflow.com/questions/35097520/mutationobserver-for-class-not-for-id 
https://stackoverflow.com/questions/35290789/reconnect-and-disconnect-a-mutationobserver
http://ryanmorr.com/using-mutation-observers-to-watch-for-element-availability/
You had a few issues:

    iterator: target[i] is not what you expect once the code is executed (var foo = target[i].getAttribute("someAttribute")), since the iteration is finished when this line is ran, i has a value of target.length, so target[i] does not exist
    attributes don't have styles (foo.style.backgroundColor), you need to refer the target element
    you're passing the whole collection to the observer (observer.observe(target, config);) you need only one target element

Here's the working code after fixing the errors listed above and externalizing the loop code into a function for easier target referencing:

var target = document.querySelectorAll(".c");
for (var i = 0; i < target.length; i++) {
  create(target[i]);
}

function create(t) {
  // create an observer instance
  var observer = new MutationObserver(function(mutations) {
    mutations.forEach(function(mutation) {
      var foo = t.getAttribute("aaa")

      if (foo == "vvv")
        t.style.backgroundColor = "red";
    });
  });
  // configuration of the observer
  var config = {
    attributes: true
  };

  // pass in the target node, as well as the observer options
  observer.observe(t, config);
}

// let's change an attribute in a second
setTimeout(function(){
  target[2].setAttribute('aaa', 'vvv');
}, 1000);

.c {
  width: 50px;
  height: 50px;
  display: inline-block;
  border: 1px solid black
}

<div class="c"></div>
<div class="c"></div>
<div class="c"></div>
<div class="c"></div>



improvement

    var foo = target[i].getAttribute("someAttribute") changed to var foo = mutation.target.getAttribute("someAttribute") instead of a passed-in target element

var target = document.querySelectorAll(".someClass");
for (var i = 0; i < target.length; i++) {

    // create an observer instance
    var observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            var foo = mutation.target.getAttribute("someAttribute")

            if (foo == "someValue")
                mutation.target.style.backgroundColor = "red";
        });
    });

    // configuration of the observer
    var config = { attributes: true };

    // pass in the target node, as well as the observer options
    observer.observe(target[i], config);
}

// let's change an attribute in a second
setTimeout(function(){
  target[2].setAttribute('someAttribute', 'someValue');
}, 1000);

.someClass {
  width: 50px;
  height: 50px;
  display: inline-block;
  border: 1px solid black
}

<div class="someClass"></div>
<div class="someClass"></div>
<div class="someClass"></div>
<div class="someClass"></div>


#########################
document.querySelector("#demo")
var target = document.querySelector("#"+id);  
    // create an observer instance
    var observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            var foo = mutation.target.getAttribute("style") 
        var currentValue = mutation.target.style.display;
        if (currentValue !== previousValue) {
           if ( currentValue !== "none") {
             console.log("display none has just been added!");
           }
        });
    });

    // configuration of the observer
    var config = { attributes: true };

    // pass in the target node, as well as the observer options
    observer.observe(target[i], config);
}

// let's change an attribute in a second
setTimeout(function(){
  target[2].setAttribute('someAttribute', 'someValue');
}, 1000);

.someClass {
  width: 50px;
  height: 50px;
  display: inline-block;
  border: 1px solid black
}

<div class="someClass"></div>
<div class="someClass"></div>
<div class="someClass"></div>
<div class="someClass"></div>

('.Scrollable').on('DOMMouseScroll mousewheel', function(ev) {
    var $this = $(this),
        scrollTop = this.scrollTop,
        scrollHeight = this.scrollHeight,
        height = $this.height(),
        delta = (ev.type == 'DOMMouseScroll' ?
            ev.originalEvent.detail * -40 :
            ev.originalEvent.wheelDelta),
        up = delta > 0;

    var prevent = function() {
        ev.stopPropagation();
        ev.preventDefault();
        ev.returnValue = false;
        return false;
    }

    if (!up && -delta > scrollHeight - height - scrollTop) {
        // Scrolling down, but this will take us past the bottom.
        $this.scrollTop(scrollHeight);

        return prevent();
    } else if (up && delta > scrollTop) {
        // Scrolling up, but this will take us past the top.
        $this.scrollTop(0);
        return prevent();
    }
});

$.scrollTo( this.hash, 1500, {// for active auto scrolling to
    easing:'easeInOutCubic',
    'axis':'y'
});
scroll to bottom of window and bottom of element

var section = $(this.hash);
var scrollPos = section.offset().top + section.height() - $(window).height();

then $window.disablescroll();
Enable scrolling again: $window.disablescroll("undo"); 
http://jsfiddle.net/9XB8h/7/

this.disableScrollFn= function(e) { 
    e.preventDefault(); e.stopPropagation() 
};
document.body.style.overflow = 'hidden';
$('body').on('mousewheel', this.disableScrollFn);

Advantage of this is we stop the user from scrolling in any possible way, and without having to change css position and top properties. I'm not concerened about touch events, since touch outside would close the popup.

To disable this, upon closing the popup I do the following.

document.body.style.overflow = 'auto';
$('body').off('mousewheel', this.disableScrollFn);


final mutation:
var target = document.querySelector("#"+id);  
    var observer = new MutationObserver(function(mutations) {
		mutations.forEach(function(mutation) {  
          if (mutation.type !=  'characterData') return;
		var foo = mutation.target.data;
		if (foo==='finished'){
             console.log(foo+' id');
		   window.observer.disconnect();
		   }
            
        });
    });

    // configuration of the observer
    var config = { characterData: true };

    // pass in the target node, as well as the observer options
    observer.observe(target, config);
    
    
    
    
    
var myFunction = function() {
  var tmp = document.getElementById('text').innerHTML;
  var myobj=document.getElementById('text')
 myobj.setAttribute('aria-label', 'Test2')
  myobj.innerHTML = tmp + "herro<br>";
  myobj.setAttribute('data-status','finished')
};

if ("MutationObserver" in window) {
  document.getElementById('support').innerHTML = "MutationObserver supported";
  var observer = new MutationObserver(function (mutations) {
    mutations.forEach(function (mutation) {
      var tmp = document.getElementById('info').innerHTML;
      document.getElementById('info').innerHTML = tmp + mutation.type + ' '+ targetNode.getAttribute(mutation.attributeName);
    });
  });

  var observerConfig = {
    attributes: true,
    childList: true,
    characterData: true
  };
  var targetNode = document.getElementById('text');
  observer.observe(targetNode, observerConfig);
}

//  https://addyosmani.com/blog/mutation-observers/
var observer = new MutationObserver(function (mutations) {
    // Whether you iterate over mutations..
    mutations.forEach(function (mutation) {
      // or use all mutation records is entirely up to you
      var entry = {
        mutation: mutation,
        el: mutation.target,
        value: mutation.target.textContent,
        oldValue: mutation.oldValue
      };
      console.log('Recording mutation:', entry);
    });
  });

  include_path  server path
  function homeDir()
{
    if(isset($_SERVER['HOME'])) {
        $result = $_SERVER['HOME'];
    } else {
        $result = getenv("HOME");
    }

    if(empty($result) && function_exists('exec')) {
        if(strncasecmp(PHP_OS, 'WIN', 3) === 0) {
            $result = exec("echo %userprofile%");
        } else {
            $result = exec("echo ~");
        }
    }

    return $result;
    include_path
    $paths = explode(';', get_include_path());
foreach($paths as $p){
    if(file_exists($p . '/' . $calculatedPath)){
        include $p . '/' . $calculatedPath;
        break;
    }
}
}

<?php
#ExpressEdit 2.0
if ( ! defined( "PATH_SEPARATOR" ) ) {
  if ( strpos( $_ENV[ "OS" ], "Win" ) !== false )
    define( "PATH_SEPARATOR", ";" );
  else define( "PATH_SEPARATOR", ":" );
}

<?php
#ExpressEdit 2.0
# ~ ~ ~ ~ ~ ~ ~
class Content extends Singleton { # ErrorLog
    const Global_error_log = '/usr/local/apache/logs/error_log';
    const Exclude = '';

    private $ii = 'ErrorLog';
    private $content = '';
    private $find = '';
    private $exclude = '';
    private $options = array(
        'find' => 'f',
        'exclude' => 'x',
        );
    private $domains = array(
        'arthurmc' => '/home/arthurmc/public_html',
        'vwpkbpmy' => '/home/vwpkbpmy/public_html',
        'firmfrie' =>  '/home/firmfrie/public_html',
        'billi' =>  '/home/firmfrie/public_htmli/billiesblues',
        'hersh' =>  '/home/firmfrie/public_html/hershellnorwood',
        'weasel' =>  '/home/firmfrie/public_html/weasel',
        );


# ~ ~ ~ ~ ~ ~ ~
 protected function __construct() {
    Dbg::__construct($this->ii,$this->options);
    $this->find = $this->opt->get('find','firmfrie');
    array_key_exists($this->find,$this->domains) ||
        $this->find = 'firmfrie';
    $cmd = '/bin/grep '.$this->find.' '.self::Global_error_log;
    $exclude = $this->opt->get('exclude');
    if (strlen($exclude)) {
        $exclude = trim(str_replace(',','|',$exclude), '|');
        $this->exclude = trim(self::Exclude.'|'.$exclude, '|');
        $cmd .= ' | /bin/grep -v "'.$this->exclude.'"';
        }
    $this->content  = "<h1>find('$this->find')</h1>\n";
   $this->content .= "<h2>exclude('$this->exclude')</h2>\n";
    $log = `$cmd`;
    $wc = count(explode("\n",$log));
   $this->content .= "<h3 class=\"ctr\">error_log($wc)</h3>\n";
    $this->content .= $log;
    } # content.new()


# ~ ~ ~ ~ ~ ~ ~
 public function render() {
    $acct = $this->domains[$this->find];
    $find = array("\n",$acct,': /',', referer',' ');
    $repl = array("<br>\n",'',"<br>\n&emsp; &emsp; /","<br>\n&emsp; &emsp; referer",'&nbsp;');
    $html = str_replace($find,$repl,$this->content);
    return $html;
    } # content.render()`
 } # Content.class
 
 
 
 
 
 	
	/*CREATE TEMPORARY TABLE temp_table 
AS 
SELECT * FROM source_table WHERE id='7'; 
UPDATE temp_table SET id='100' WHERE id='7';
INSERT INTO source_table SELECT * FROM temp_table;
DROP TEMPORARY TABLE temp_table;

improvement
CREATE TEMPORARY TABLE tmptable SELECT * FROM table WHERE primarykey = 1;
UPDATE tmptable SET primarykey = 2 WHERE primarykey = 1;
INSERT INTO table SELECT * FROM tmptable WHERE primarykey = 2;





	
INSERT INTO table (primarykey, col2, col3, ...)
SELECT 567, col2, col3, ... FROM table
  WHERE primarykey = 1	*/
  
  new gesture('#dom',{
            click: function(event){},
            tap: function(event) {}, 
            swipeLeft: function(event){}, 
            swipeRight: function(event){}, 
            swipeDown: function(event){},  
            swipeUp: function(event){},  
            end: function(event){}
            });
            or
            var g = new gesture('#demo');
            g.click(function(event){
            });
            
  ########################
  https://css-tricks.com/theres-more-to-the-css-rem-unit-than-font-sizing/
  
  
  (function (doc, win) {
    var docEl = doc.documentElement,
        recalc = function () {
            var clientWidth = docEl.clientWidth;
            if (!clientWidth) return;

            docEl.style.fontSize = clientWidth + 'px';
            docEl.style.display = "none";
            docEl.clientWidth; // Force relayout - important to new Android devices
            docEl.style.display = "";
        };

    // Abort if browser does not support addEventListener
    if (!doc.addEventListener) return;

    // Test rem support
    var div = doc.createElement('div');
    div.setAttribute('style', 'font-size: 1rem');

    // Abort if browser does not recognize rem
    if (div.style.fontSize != "1rem") return;

    win.addEventListener('resize', recalc, false);
    doc.addEventListener('DOMContentLoaded', recalc, false);
})(document, window);



.laptop {
  margin: 10vh auto 0;
  width: 60vmax;
  position: relative;
  transition: all 500ms ease
}

.laptop__top-shell {
  background: #fff;
  border: 2px solid #A2A2A2;
  border-radius: 0.5vmax 0.5vmax 0 0
}

.laptop__webcam {
  background: #F7F7F7;
  border: 0.1vmax solid #A2A2A2;
  margin: 0.4vmax auto;
  height: 0.5vmax;
  width: 0.5vmax;
  border-radius: 1vmax
}

.laptop__screen {
  transition: all 500ms ease;
  border: 1px solid #A2A2A2;
  height: 30vmax;
  margin: 0 2% 2%;
  border-radius: 0.25vmax;
  background-color: #000
}

.laptop__bottom-shell {
  width: 112%;
  margin: -2px auto 0 -6%
}

.laptop__keyboard {
  border: 2px solid #A2A2A2;
  height: 1.25vmax;
  background-color: #fff;
  border-radius: 0.75vmax 0.75vmax 0 0;
  border-bottom-width: 0.1vmax
}

.laptop__handle {
  background: #F7F7F7;
  border: 1px solid #A2A2A2;
  margin: auto;
  height: 0.6vmax;
  width: 20%;
  margin-top: -1px;
  border-radius: 0 0 0.25vmax 0.25vmax
}

.laptop__base {
  border: 2px solid #A2A2A2;
  height: 1vmax;
  background-color: #fff;
  border-radius: 0 0 1.5vmax 1.5vmax;
  margin-top: -1px;
  border-top-width: 1px
}

body {
  background: #D3DEE0;
}

unction stopPropagation(id, event) {
    $(id).on(event, function(e) {
        e.stopPropagation();
        return false;
    });
stopPropagation('#myRange', 'touchmove'); 
          
  /*
	$checked=' checked="checked" ';
	    $checked1=($scaleunit==='none')?$checked:'';
	    $checked2=($scaleunit==='%')?$checked:'';
	    $checked3=($scaleunit==='em')?$checked:'';
	    $checked4=($scaleunit==='rem')?$checked:'';
	    $checked5=($scaleunit==='vm')?$checked:'';
	    $checked6=($scaleunit==='vh')?$checked:'';
	    printer::alert('Choose scale unit:');
	    printer::alert('<input type="radio" name="'.$style.'['.$val.'][1]" value="none" '.$checked1.'>None');
	     printer::alert('<input type="radio" name="'.$style.'['.$val.'][1]" value="%" '.$checked2.'>% units');
	  printer::alert('<input type="radio" name="'.$style.'['.$val.'][1]" value="em" '.$checked3.'>em units');
	    printer::alert('<input type="radio" name="'.$style.'['.$val.'][1]" value="rem" '.$checked4.'>rem units');
	    printer::alert('<input type="radio" name="'.$style.'['.$val.'][1]" value="vw" '.$checked5.'>vw units'); 
	    if (strpos($css_style,'top')||strpos($css_style,'bottom')||strpos($css_style,'height'))
			printer::alert('<input type="radio" name="'.$style.'['.$val.'][1]" value="vh" '.$checked6.'>vh units'); */          
            
  <div id="range_$inc" value="600"  onclick="RS(this,{
      create: function(value, target) {
          target.className +=\' red\';
      },
      drag: function(value, target) {
          x.innerHTML = \'<strong>\' + value + \'%</strong>\';
		}
	 },false);
      
      updateSlider_$inc.noUiSlider.on('start', function() {
var pos=\$('#$showEle').position(); 
updateSlider_$inc.style.width=(+\$('#$showEle').width()+ +pos.left)+'px';
});

/*
	var slide = document.getElementById('slide'),
    sliderDiv = document.getElementById("sliderAmount");

slide.oninput  = function() {
    sliderDiv.innerHTML = this.value;
}
	
	
     
     
      
	echo '<div class="tip click" onclick="gen_Proc.precisionAdd(this,\''.$name.'\',\''.$range1.'\',\''.$range2.'\',\''.$size.'\',\''.$unit.'\',\''.$increment.'\',1,\''.$msgjava.'\',\'\',\'increment\',\''.$none.'\',\''.$negnum.'\');">Choose:</div>'; */

function color($name,$value){
     echo '#<input onclick=" window.jscolor(this);" style="cursor:pointer;background:#'.$this->editor_background.';color:#'.$this->editor_color.';"  class="jscolor {refine:false}"   name="'.$name.'"   value="'.$value.'"
		size="6" maxlength="6"  > 
		';
     
     $opacity=($background_color_opacity<100&&$background_color_opacity>0)?'@'.$background_color_opacity.'%&nbsp;Opacity ':''; 
	$span_color=(!empty($background_color))?'<span class="fs1npred floatleft" style="height:25px;width:25px; '.$background_color.'">'.$invalid.'&nbsp;&nbsp;</span>'.$opacity:''; 
	 if (!preg_match(Cfg::Preg_color,$background_array[$background_color_index]))$background_array[$background_color_index]="0";
   echo '<p class="editcolor editbackground editfont ">Change Background Color Opacity:  </p>';
		$this->mod_spacing($style.'['.$val.']['.$background_opacity_index.']',$background_color_opacity,0,100,1,'%');
		echo '</div><!--border opacity-->'; 
     $background_color_opacity=(!empty($background_array[$background_opacity_index])&&$background_array[$background_opacity_index]<100&&$background_array[			$background_opacity_index]>0)?$background_array[$background_opacity_index]:100;
	$back_color=(preg_match(Cfg::Preg_color,$background_array[$background_color_index]))?$background_array[$background_color_index]:'';
	if (!empty(trim($back_color))){
		if ($background_color_opacity <100) 
			$back_color=process_data::hex2rgba($back_color,$background_color_opacity);
		else $back_color='#'.$back_color;
		$background_color='background-color: '.$back_color.';'; 
		}
	else $background_color='';
     $fstyle='final_'.$style;
		$this->{$fstyle}[$val]=$background_color.$gradient_css.$background_image.$video_css; 
     } 
 /*if (!Sys::Debug){
		header( 'Expires: Sat, 26 Jul 1997 05:00:00 GMT' );
		header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
		header( 'Cache-Control: no-store, no-cache, must-revalidate' );
		header( 'Cache-Control: post-check=0, pre-check=0', false );
		header( 'Pragma: no-cache' );
		}*/

 
function imgSizer(){
$this->javascript.= <<<EOD
	//from http://unstoppablerobotninja.com/entry/fluid-images/  
	var imgSizer = {alert('dgo');
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
          
          
     function calc_image_height($preheight){  
	if ($this->rwd_post)return 1;
	$height_set=(is_numeric($this->blog_height_arr[$this->blog_height_index])&&$this->blog_height_arr[$this->blog_height_index]>9&&$this->blog_height_arr[$this->blog_height_index]<1001)?$this->blog_height_arr[$this->blog_height_index]-$preheight:0;
	if (empty($height_set))return 1;
	list($picname,$alt)=process_data::process_pic($this->blog_data1);
	list($w,$h)=process_data::get_size($picname,Cfg_loc::Root_dir.Cfg::Upload_dir);
	return  $height_set*($w)/$h;
	}
          
          \$(function(){
	var slip_$this->blog_id={};
	slip_$this->blog_id.resizeTimer='';
	slip_$this->blog_id.windowWidth = \$(window).width();
	slip_$this->blog_id.transition = '$transition';
	slip_$this->blog_id.fixheight= '$fixheight';
	if (slip_$this->blog_id.fixheight !== 'noheight' ){
		window.addEventListener('resize', function(){ 
			if (\$(window).width() !== slip_$this->blog_id.windowWidth) {
				slip_$this->blog_id.windowWidth = \$(window).width(); 
				clearTimeout(slip_$this->blog_id.resizeTimer); 
				slip_$this->blog_id.resizeTimer=setTimeout( function(){
					var slide=\$('.$this->dataCss .sy-active'); 
					var factorWidth=  slip_$this->blog_id.transition ==='kenburns' ? 1.4 : 1
					var pwidth = $('.$this->dataCss').width(); 
					var pheight = $('.$this->dataCss').height(); 
					var imgratio=$('img', slide).width()/$('img', slide).height();
					var pratio=pwidth/pheight; 
					var height =  pratio > imgratio ? pwidth * factorWidth / imgratio : pheight * factorWidth;
					var width=height * imgratio;
					$('img', slide).width(width);
					$('img', slide).height(height);
					}, 250); 
				}//window 
			}, true);//event
		} //noheight
	});
     //$fixheight=($this->blog_height_arr[$this->blog_height_index]>=10)?$this->blog_height_arr[$this->blog_height_index]:'noheight';
		//$this->blog_height_arr[$this->blog_height_mode_index]==='maintain'&&	
		//if post has a fixed width set fix this gallery to height
		//($this->blog_height_arr[$this->blog_height_mode_index]==='maintain'&&$this->blog_height_arr[$this->blog_height_index]>=10)?true:false;//if post has a fixed width set fix this gallery to height
 else {//populate blog_height used only on not nest columns  here to determine whether respondHeight is used in maindiv and in blog_options height_style function. 
			//$this->blog_height_arr=explode(',',$this->blog_height);
			//for ($i=0;$i <count(explode(',',Cfg::Blog_height_opts)); $i++){
				//if (!array_key_exists($i,$this->blog_height_arr))$this->blog_height_arr[$i]=0;	 
				//}
			}  //$this->blog_height_arr[$this->blog_height_index]=($this->blog_height_arr[$this->blog_height_index]>=10||$this->blog_height_arr[$this->blog_height_index]<=$maxheight)?$this->blog_height_arr[$this->blog_height_index]:'none';       
 $y=(!empty($this->nav_tweak1))?"gen_Proc.toggleTweak('#$this->nav_post_class .ulTop','menuRespond','#$this->nav_post_class',$this->nav_tweak1,$this->nav_tweak2,0);":'';
 
 
 
 
 
 return;
     $q="ALTER TABLE `master_post_css` DROP `blog_height`;";
 $r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
     $q="ALTER TABLE `master_post` DROP `blog_height`;";
 $r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
     $q="ALTER TABLE `master_post_data` DROP `blog_height`;";
 $r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
     $q="ALTER TABLE `columns` DROP `blog_height`;";
 $r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	  //db_generator::run_db_table();
     $q="UPDATE columns SET col_table = REPLACE(col_table, '_post_', '_col_') WHERE col_table LIKE '%_post_%'";
 $r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);

     $q="UPDATE `master_post` SET `blog_table` = REPLACE(`blog_table`, '_post_', '_col_') WHERE `blog_table` LIKE '%_post_%'";
 $r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
     $q="UPDATE master_col_css SET col_table = REPLACE(col_table, '_post_', '_col_') WHERE col_table LIKE '%_post_%'";
 $r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);

     $q="UPDATE `master_post_css` SET `blog_table` = REPLACE(`blog_table`, '_post_', '_col_') WHERE `blog_table` LIKE '%_post_%'";
 $r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
       
       /* if ($this->col_options[$this->col_use_grid_index]!=='use_grid'&&(substr($this->col_flex_box,0,3)==='fle'||substr($this->col_flex_box,0,3)==='inf'))#flex container is true and we cant have margin:auto
               $this->css.='
          .'.$this->col_dataCss.'{margin-left:0;margin-right:0;}';*/ 
  //here we control whether blogs share space within the row of a column width permitting...  this is for non-rwd posts..   show new blogs are controlled so as not to break floating or inline-block shares... by putting them within the post division instead of following...
			#mainfloat
			##current correction
          if (strpos($this->blog_float,' ')){
               $blogfloat=str_replace(' ','_',$this->blog_float);
               $this->hidden_array[]='<input type="hidden" name="'.$data.'_blog_float" value="'.$blogfloat.'">';
               }
      /*gen_Proc.imageExists(newSrc,function(exists){
                              if (exists) {
                                   myimg.src=newSrc;
                                  // gen_Proc.imgReplace=true;
                                   //myimg.style.width='100%';
                                   //myimg.style.height='auto'; 
                                   }
                              
                              else alert ('failure with '+newSrc);
                              }); */          #########end tempor
                              
                              
#temporary zone 
     if (!$this->is_clone&&false&&'new_home'!==$this->pagename&&$this->edit&&!isset($_POST['submit'])&&!isset($_POST['xxxsubmitted'])&&!isset($_SESSION[$this->pagename])){
     $_SESSION[$this->pagename]=1;
     process_data::write_to_file('tempf','submit filename '.$this->pagename,false,true);     if (empty($this->blog_tiny_data11))printer::alert('<input type="hidden" name="'.$this->data.'_blog_tiny_data11" value="'.$this->blog_data6.'">');
     if (empty($this->blog_tiny_data11))printer::alert('<input type="hidden" name="'.$this->data.'_blog_tiny_data11" value="'.$this->blog_data6.'">');
     printer::alert('<input type="hidden" name="'.$this->data.'_blog_data5" value="'.$this->blog_tiny_data1.'">');
     printer::alert('<input type="hidden" name="'.$this->data.'_blog_tiny_data1" value="'.$this->blog_data5.'">');
     printer::alert('<input type="hidden" name="xxxsubmitted" value="'.$this->blog_data5.'">');
          if (empty($this->blog_tiny_data5))printer::alert('<input type="hidden" name="'.$this->data.'_blog_tiny_data5" value="'.$this->blog_data5.'">');
          if (empty($this->blog_tiny_data7))printer::alert('<input type="hidden" name="'.$this->data.'_blog_tiny_data7" value="'.$this->blog_data12.'">');
          echo '<script>
               \$(function(){
                    document.getElementById("mainform").submit();
                    }
               </script>
               }';
               
          exit('goneby');
          }
     change log
     
.nav_gen UL UL  {  text-align: center; vertical-align: top;}  to 
.nav_gen UL UL  { vertical-align: top;}

removed     from file_generation   $php_ini='
	post_max_size='.Cfg::Upload_max_filesize.'  
	upload_max_filesize = '.Cfg::Upload_max_filesize; 

     $add_page_pic=<<<eol
<?php
#ExpressEdit 2.0
include '../includes/path_include.class.php'; 
new Sys();
new add_page_pic_core(); 
?>
eol;
   $editDir=Cfg::PrimeEditDir;
     //file_put_contents(Cfg_loc::Root_dir.$editDir.'php.ini',$php_ini); 
     //file_put_contents(Cfg_loc::Root_dir.$editDir.'user.ini',$php_ini);
  
  
  
	$photoswipe_control_background_opacity=($blog_data2[$photoswipe_control_background_index]>=5&&$blog_data2[$photoswipe_control_background_index]<=100)?$blog_data2[$photoswipe_control_background_index]:50;		
     if($photoswipe_control_background_opacity <100 && $photoswipe_control_background!=='none'){ 
                    $back_color=process_data::hex2rgba($photoswipe_control_background,$photoswipe_control_background_opacity);
                    $backstyle=' background-color:'.$back_color.';';
                    $backstyle2=' background-color:'.$back_color.' !important;';
                    }
                    /*if (!$this->master_gallery){
          $this->show_more('<b>Simulate Page Background</b> Color for Expand Images');
          echo'<div class="fs1color"><!--choose colors-->';
          printer::alertx('<p class="left editbackground  editfont editcolor">Change the Background Color of Simulated Page when viewing Expanded Images <input onclick=" window.jscolor(this);" style="cursor:pointer;background:#'.$this->editor_background.';color:#'.$this->editor_color.';" type="text"  name="'.$data.'_blog_data2['.$simulate_background_index.']" value="'.$simulate_background.'"  size="6" maxlength="6" class="jscolor {refine:false}"></p>'); 
          echo '</div><!--choose colors-->';
          $this->show_close('<b>Simulate Page Background</b>Color for Expand Images');//<!--Show More Change Colors-->';
          
          
          $q="ALTER TABLE `master_post_data` ADD `blog_style2` TINYTEXT NOT NULL AFTER `blog_style`";
     $r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
     $q="ALTER TABLE `master_post_data` CHANGE `blog_alt_rwd` `blog_width_mode` TINYTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;";
 $r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
      $q="ALTER TABLE `master_post_css` CHANGE `blog_alt_rwd` `blog_width_mode` TINYTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;";
 $r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
     $q="ALTER TABLE `master_post` ADD `blog_flex_box` TINYTEXT NOT NULL AFTER `blog_width_mode`";
 $r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
     $q="ALTER TABLE `master_post_css` ADD `blog_flex_box` TINYTEXT NOT NULL AFTER `blog_width_mode`";
 $r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
     $q="ALTER TABLE `columns` ADD `col_flex_box` TINYTEXT NOT NULL AFTER `col_clone_target_base`";
 $r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
     $q="ALTER TABLE `master_col_css` ADD `col_flex_box` TINYTEXT NOT NULL AFTER `col_clone_target_base`";
 $r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
     $q="ALTER TABLE `master_post` CHANGE `blog_alt_rwd` `blog_width_mode` TINYTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL";
 $r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	 $q="ALTER TABLE `master_post_css` DROP `blog_height`;";
 $r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
     $q="ALTER TABLE `master_post` DROP `blog_height`;";
 $r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
     $q="ALTER TABLE `master_post_data` DROP `blog_height`;";
 $r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
     $q="ALTER TABLE `columns` DROP `blog_height`;";
 $r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	  //db_generator::run_db_table();
     $q="UPDATE columns SET col_table = REPLACE(col_table, '_post_', '_col_') WHERE col_table LIKE '%_post_%'";
 $r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);

     $q="UPDATE `master_post` SET `blog_table` = REPLACE(`blog_table`, '_post_', '_col_') WHERE `blog_table` LIKE '%_post_%'";
 $r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
     $q="UPDATE master_col_css SET col_table = REPLACE(col_table, '_post_', '_col_') WHERE col_table LIKE '%_post_%'";
     $r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
     $q="UPDATE `master_post_css` SET `blog_table` = REPLACE(`blog_table`, '_post_', '_col_') WHERE `blog_table` LIKE '%_post_%'";
     $r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); 
     $q="ALTER TABLE `master_post_data` ADD `blog_flex_box` TINYTEXT NOT NULL AFTER `blog_width_mode`";
     $r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
      $q="ALTER TABLE `master_post_css` CHANGE `blog_alt_rwd` `blog_width_mode` TINYTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL";
     $r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
      $q="ALTER TABLE `master_post_data` CHANGE `blog_alt_rwd` `blog_width_mode` TINYTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL";
     $r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
     if (in_array('blog_tiny_data11',$field_arr)){
          if (!empty($dbname)) 
               $this->mysqlinst->dbconnect(Sys::Dbname);
          return;
          } 
     foreach (array('','_css','_data')as $type){
          $q="ALTER TABLE `master_post$type` ADD `blog_data15` TEXT NOT NULL AFTER `blog_data10`";
          $r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); 
          $q="ALTER TABLE `master_post$type` ADD `blog_data14` TEXT NOT NULL AFTER `blog_data10`";
          $r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); 
          $q="ALTER TABLE `master_post$type` ADD `blog_data13` TEXT NOT NULL AFTER `blog_data10`";
          $r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
          
          $q="ALTER TABLE `master_post$type` ADD `blog_data12` TEXT NOT NULL AFTER `blog_data10`";
          $r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
          $q="ALTER TABLE `master_post$type` ADD `blog_data11` TEXT NOT NULL AFTER `blog_data10`";
          $r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
          }
     foreach (array('','_css','_data')as $type){
          $q="ALTER TABLE `master_post$type` ADD `blog_tiny_data15` TINYTEXT NOT NULL AFTER `blog_tiny_data10`";
          $r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); 
          $q="ALTER TABLE `master_post$type` ADD `blog_tiny_data14` TINYTEXT NOT NULL AFTER `blog_tiny_data10`";
          $r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); 
          $q="ALTER TABLE `master_post$type` ADD `blog_tiny_data13` TINYTEXT NOT NULL AFTER `blog_tiny_data10`";
          $r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
          
          $q="ALTER TABLE `master_post$type` ADD `blog_tiny_data12` TINYTEXT NOT NULL AFTER `blog_tiny_data10`";
          $r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
          $q="ALTER TABLE `master_post$type` ADD `blog_tiny_data11` TINYTEXT NOT NULL AFTER `blog_tiny_data10`";
          $r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
          }
      
     $q="ALTER TABLE `master_post` ADD `blog_style2` TINYTEXT NOT NULL AFTER `blog_style`";
 $r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
     $q="ALTER TABLE `columns` ADD `col_style2` TINYTEXT NOT NULL AFTER `col_style`";
 $r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
     
     $q="ALTER TABLE `master_post_css` ADD `blog_style2` TINYTEXT NOT NULL AFTER `blog_style`";
 $r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
     $q="ALTER TABLE `master_post_data` ADD `blog_style2` TINYTEXT NOT NULL AFTER `blog_style`";
 $r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
     $q="ALTER TABLE `columns` ADD `col_style2` TINYTEXT NOT NULL AFTER `col_style`";
 $r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
     $q="ALTER TABLE `columns` ADD `col_style2` TINYTEXT NOT NULL AFTER `col_style`";
 $r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
     $q="ALTER TABLE `master_col_css` ADD `col_style2` TINYTEXT NOT NULL AFTER `col_style`";
 $r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
     if (in_array('blog_width_mode',$field_arr)&&in_array('blog_style2',$field_arr)){
          if (!empty($dbname)) 
               $this->mysqlinst->dbconnect(Sys::Dbname);
          }  
    
      
          }*/
                    
   #temporary zone
     $tableup=($this->clone_local_data)?'master_post_data':'master_post';
     $AND=($this->clone_local_data)?" and blog_orig_val_id='".$this->orig_val['blog_id']."'":'';
     $prefix=($this->clone_local_data)?'p':'';
     if ($this->edit&&!empty($img_opt_arr[$image_external_link_index])){
          $q="update $tableup set blog_tiny_data5='".$img_opt_arr[$image_external_link_index]."' where blog_id='".$prefix."$this->blog_id' $AND";
          $r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
          $this->blog_tiny_data5=$img_opt_arr[$image_external_link_index];
          printer::alert('<input name="'.$data.'_'.$img_opt.'['.$image_external_link_index.']" value="0" type="hidden">');
          } 
     if ($this->edit&&!empty($img_opt_arr[$image_internal_link_index])){ 
          $q="update $tableup set blog_tiny_data6='".$img_opt_arr[$image_internal_link_index]."' where blog_id='".$prefix."$this->blog_id' $AND";
          $r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
          $this->blog_tiny_data6=$img_opt_arr[$image_internal_link_index];
          printer::alert('<input name="'.$data.'_'.$img_opt.'['.$image_internal_link_index.']" value="0" type="hidden">');
          }
     if ($this->edit&&!empty($img_opt_arr[$image_internal_query_index])){
          $q="update $tableup set blog_tiny_data4='".$img_opt_arr[$image_internal_query_index]."' where blog_id='".$prefix."$this->blog_id' $AND";
          $r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
          $this->blog_tiny_data4=$img_opt_arr[$image_internal_query_index];
          printer::alert('<input name="'.$data.'_'.$img_opt.'['.$image_internal_query_index.']" value="0" type="hidden">');
          }
     if ($this->edit&&!empty($img_opt_arr[$image_caption_text_index])){
          $q="update $tableup set blog_tiny_data3='".$img_opt_arr[$image_caption_text_index]."' where blog_id='".$prefix."$this->blog_id' $AND";
          $r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
          $this->blog_tiny_data3=$img_opt_arr[$image_caption_text_index];
          printer::alert('<input name="'.$data.'_'.$img_opt.'['.$image_caption_text_index.']" value="0" type="hidden">');
          }
     
     #end temp zone                 
     if (array_key_exists($bp,${$prefix.'_grid_width'})){
                         $final=str_replace(array(','.$pgrid,$pgrid),'',$this->$field);
                         $this->hidden_array[]='<input type="hidden" name="'.$data.'_'.$field.'" value="'.$final.'">';
                         }               
      ########################
      alt rwd major change  altrwd 
       if ($this->blog_width_mode[$this->blog_width_mode_index]==='compress_to_percentage'||$this->blog_width_mode[$this->blog_width_mode_index]==='compress_full_width'){//takes care of  width css for regular and nested column posts 
                    $bouncewidth_per=($this->blog_width_mode[$this->blog_bounce_width_index]>=10&&$this->blog_width_mode[$this->blog_bounce_width_index]<=100)?$this->blog_width_mode[$this->blog_bounce_width_index]:0;
                    $minwidth_per=($this->blog_width_mode[$this->blog_min_width_index]>0&&$this->blog_width_mode[$this->blog_min_width_index]<=100)?$this->blog_width_mode[$this->blog_min_width_index]:Cfg::Default_min_width;
                    $minwidth=$minwidth_per*$this->current_total_width/100;
                    $mode=($this->blog_width_mode[$this->blog_width_mode_index]==='maxwidth'||$this->blog_width_mode[$this->blog_width_mode_index]==='compress_full_width'||$this->blog_width_mode[$this->blog_width_mode_index]==='compress_to_percentage')?$this->blog_width_mode[$this->blog_width_mode_index]:'maxwidth'; 
                    $mediaminwidth=$this->column_total_width[$this->column_level]*$minwidth_per/100;//check screen width for compression and reset post to original width as max-width
                         //set up a min-width of percentage of parent column width chosen...
                    if ($mode==='compress_full_width'){
                         $this->css.='
               div .'.$cb_data.'{width:'.($this->current_total_width_percent).'%;}';
                         }
                    elseif ($mode==='compress_to_percentage'){   
                         if($bouncewidth_per>9)
                         $this->css.='
               div .'.$cb_data.'{
               width:'.($this->current_total_width_percent).'%;
               }
               @media screen and (max-width:'.$mediaminwidth.'px){
               div .'.$cb_data.'{width:'.$bouncewidth_per.'%;}
                         }';   
                         else
                              $this->css.='
               div .'.$cb_data.'{
               width:'.($this->current_total_width_percent).'%;
               min-width:'.$minwidth.'px;}
               @media screen and (max-width:'.$minwidth.'px){
               div .'.$cb_data.'{
               min-width:0;
               max-width:98%;}
                         }';   
                         }
                    }//edit && !rwd
      #initial post append for primary column
		$append_arr=array();
		$append_arr['var']=$append_arr['obj']=array();
         /*#Now we using orig_val{$blog_id] wich will be different. Perhaps mysql call directly when such an unusual situation occurs instead.. not implemented
          *#similarly we are setting up $append_arr data for flatfile mode in case of cloning of primary column to nested column. this flatfile not necessary 
		#here we flat file in editmode primary values for webpage mode misc variables and class properties that are important for webpage mode but generated in editpage mode...
		#these "append variables"  are made and attached to this primary col_id in case they are necessary for cloned nested columns otherwise not necessary as the webpage mode currently does a direct mysql call and populates primary only columns..
		/*$objvars=explode(',','rwd_post,blog_float,blog_table,column_lev_color,blog_border_stop,col_num,blog_order,blog_order_mod,fieldmax,is_clone,clone_local_style,clone_local_data');
		foreach ($objvars as $ov){ 
			$append_arr['obj'][$ov]=$this->$ov;
			}
		$vars=explode(',','subbed_row_id,show_new_blog,blog_order,tablename,blog_status,blog_unstatus,prime,floating');
		foreach ($vars as $v){
			$append_arr['var'][$v]=$$v;
			}
		$appfile=Cfg_loc::Root_dir.Cfg::Data_dir.Cfg::Page_info_dir.'post_append_data_'.$this->pagename.'_'.$this->col_id; 
		file_put_contents($appfile,serialize($append_arr));//this is done so initial clones can access original
          $table_array=array('master_post','master_post_css','master_post_data');
     foreach ($table_array as $table ){
          $q="ALTER TABLE $table CHANGE blog_data1 blog_data1 text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;";
          $r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
          $q="UPDATE $table SET `blog_table` = REPLACE(`blog_table`, '_post', '_col') WHERE `blog_table` LIKE '%_post%'";
          $r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
          $q="UPDATE $table SET `blog_table` = REPLACE(`blog_table`, '_blog', '_col_id') WHERE `blog_table` LIKE '%_blog%'";
          $r = $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
          }
          
           /* if ($image_height_set)
               printer::print_warn('Image Height Set is Enabled in option above and will Override the following width settings by using width:auto.');
          printer::alert('Your image size is determined by the Post Width Available and the option here to further limit the image width if you wish for overall styling effects to keep the post width large and the image smaller. For <b><em>float image-text posts</em></b> the default setting for image limiter is 50% image 50% text. Image limiter is <b>currently set at <span class="editcolor editbackground  editfont">'.$wpercent.'%</span></b> of the available post width.','','info left floatleft infoback maroonshadow fsminfo editbackground  editfont editcolor  maxwidth500');
          printer::pclear();*/
        function openPages2() {
     var pageArr= [ $pjArr ];
     for (var i = 0; i < pageArr.length; i++) { 
          (function loadLink(i) { 
               setTimeout(function () {
               var dt = new Date();
               while ((new Date()) - dt <= $time) { /* Do nothing pseudo synchronous */ }
               src=(pageArr[i]);
               var appendTo=document.getElementById('append_iframe');
               var iframe = document.createElement('iframe');
               iframe.src = pageArr[i];
               iframe.frameBorder = 1;
               iframe.width = "300px";
               iframe.height = "400px";
               appendTo.appendChild(iframe);
                    }, $time)
               })(i);
          }
     }    
?> 