<?php # Script 10.3 - upload_image.php 	
class photo_batch_resize { 
 
function build(){ 
     set_time_limit(600); 
     if(isset($dbname))$this->dbname=$dbname;
     $this->NL=NL;
     $this->photo_flag=true;
     $this->mailinst=mail::instance(); 
     $this->mysqlinst = mysql::instance();
     $this->pic_quality=100;
     $this->source_dir='uploads/';
     $this->output_dir='temp/';
     $this->tables_used='';
     $this->update_db=false;
     $this->watermark=null;
     $this->tablename='blank';
     $this->pic_plus=0;
     $this->set_width=0;
     $this->set_height=0;
     $this->basename_ext='';
     if (isset($_POST['submitted'])){
          if (isset($_POST['pic_quality']))$this->pic_quality=$_POST['pic_quality'];
          if (isset($_POST['source_dir']))$this->source_dir= $_POST['source_dir'];
          if (isset($_POST['output_dir'])) $this->output_dir=$_POST['output_dir'];
          if (isset($_POST['tables_used='])) $this->tables_used=$_POST['tables_used='];
          if (isset($_POST['update_db'])) $this->update_db=$_POST['update_db'];
          if (isset($_POST['watermark'])) $this->watermark=$_POST['watermark'];
          if (isset($_POST['tablename']))$this->tablename=$_POST['tablename'];
          if (isset($_POST['pic_plus'])) $this->pic_plus=$_POST['pic_plus'];
          if (isset($_POST['set_width'])) $this->set_width=$_POST['set_width'];
          if (isset($_POST['set_height'])) $this->set_height=$_POST['set_height'];
          if (isset($_POST['basename_ext'])) $this->basename_ext=$_POST['basename_ext'];
          }
     (Cfg_loc::Domain_extension!='')&& exit('This program is meant to run in root directory!');
     if(isset($_POST['photo_submit']))
     $this->process_resize();
     echo '
     <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
     "http://www.w3.org/TR/html4/strict.dtd">
     <html lang="en">
     <head>
     <title>Resize Your Photos</title></head>
     <body>
     <form action="'. Sys::Self.'" method="post">    
     <p class="ramana">Source Directory of the images: <input type="text" name="source_dir" 
     value="'.$this->source_dir.'"
     size="50" maxlength="50" ></p> 
     <p class="ramana">Enter a new directory for the resized images: <input type="text" name="output_dir" 
     value="'.$this->output_dir.'"   size="50" maxlength="50" ></p> 
      <p class="ramana">Enter a basefilename extension if needed: <input type="text" name="basename_ext" 
        value="'.$this->basename_ext.'"    size="50" maxlength="50" ></p> 
     <p><input name="purge" type="radio" value="1" >Click to Purge Previous Files in Output Directory</p>
     <p class="ramana">Final width+height of the images: <input type="text" name="pic_plus" 
     value="'.$this->pic_plus.'" 
     size="4" maxlength="4" ></p> 
     <p class="ramana">Final width  of the images: <input type="text" name="set_width" 
     value="'.$this->set_width.'" 
     size="4" maxlength="4" ></p> 
     <p class="ramana">Final height of the images: <input type="text" name="set_height" 
     value="'.$this->set_height.'" 
     size="4" maxlength="4" ></p> 
     <p><input name="print_source" type="radio" value="1" >Click to Print Source Dir</p>
     <p class="ramana">Print Additional Directory Name:<input type="text" name="print_other" size="30" maxlength="30" ></p>
     <p><input name="use_watermark" type="radio" value="1" >Click to Use the Watermark</p>
     <p class="ramana">Watermark file to use is: <input type="text" name="watermark" value = "'.Cfg::Watermark.'" size="20" maxlength="20" ></p>
     <p class="ramana">Use a tablename to derive files from:<input type="text" name="tablename"   size="30" maxlength="30" ></p>
     <p><input name="all_tables" type="radio" value="1" >Click to Use All tables</p>
     <p><input name="all_files" type="radio" value="1" >Click to Use All Image Files in source directory</p>
     <p style="color:red;"><input name="update_db" type="radio" value="1" >Caution!! Update All tables Selected and Entries for Width and Height Change?</p>
      <p class="ramana">Quality is on a scale from 0 to 100 with 100 being highest quality &amp; also slower loading<br> the default setting 90 should be fine</p>
     <p class="ramana">Change the final default picture quality: <input type="text" name="pic_quality" value = "'.$this->pic_quality.'" size="3" maxlength="3" ></p>
      <p><input type="submit" name="submit" value="Submit" ></p>
     <p><input type="hidden" name="photo_submit" value="TRUE" ></p>
     </form>
     </div>
     </body>
     </html>';
     }//end construct$tablename='gallery';//will use Cfg:Large_Pic_Plus which takes priority

function  process_resize(){ 
     printer::print_request();
     $this->table_array=check_data::return_galleries(__METHOD__,__LINE__,__FILE__) ;#use all tables false=no skipping
     $this->pic_quality=(isset($_POST['pic_quality'])&&$_POST['pic_quality']>4)?$_POST['pic_quality']:90;
     if (isset($_POST['update_db'])&& $_POST['update_db']==1)  $this->update_db=true;
     if (isset($_POST['output_dir'])&&  !is_dir($_POST['output_dir'])) mkdir($_POST['output_dir'],0777);
     $this->output_dir=  rtrim($_POST['output_dir'], "/") ."/"; 
     if (isset($_POST['purge'])&& $_POST['purge']==1){
          foreach(glob($_POST['output_dir'].'*.*') as $v){
               unlink($v);
               }
          }
     if (isset($_POST['source_dir'])&&  is_dir($_POST['source_dir']))$this->source_dir= rtrim( $_POST['source_dir'], "/") ."/"; 
     else {
          echo NL.'you must enter a valid Source Direcory';
          return;
          }
     if (isset($_POST['pic_plus'])&&  $_POST['pic_plus']>1)$this->pic_plus=$_POST['pic_plus'];
     if (isset($_POST['set_width'])&& $_POST['set_width']>1)$this->set_width=$_POST['set_width'];
     if (isset($_POST['set_height'])&& $_POST['set_height']>1)$this->set_height=$_POST['set_height'];
     if (isset($_POST['basename_ext'])&& $_POST['basename_ext']!='')$this->basename_ext=$_POST['basename_ext'];
     if ($this->pic_plus<5&&$this->set_width<5&&$this->set_height<5){
          echo NL.'You must enter a value to set image dimension';
          return;
          }  
     if (isset($_POST['use_watermark'])&& !empty($_POST['watermark']))$this->watermark=$_POST['watermark'];
     echo  "
	  $this->NL   water mark used is  $this->watermark  
       $this->NL source folder is $this->source_dir
	  $this->NL output folder is $this->output_dir
	  $this->NL dbname is   $this->dbname
	  $this->NL quality is $this->pic_quality
	  $this->NL pic width+height is $this->pic_plus
	  $this->NL width is $this->set_width
	  $this->NL height is $this->set_height
	  $this->NL basename ext  is $this->basename_ext
	  $this->NL update database with height and width is: $this->update_db $this->NL 
	 ";
     if (isset($_POST['all_files'])&& $_POST['all_files']==1) {  
	   $this->dir_parse_files();
	   }
     else if (isset($_POST['tablename'])&& $_POST['tablename']!==''){
         $this->tablename=$_POST['tablename'];
         $this->table_parse();
         }
     else if (isset($_POST['all_tables'])&& !empty($_POST['all_tables'])){
          foreach ($this->table_array as $this->tablename){
              $this->tables_used.=NL.$this->tablename;
              $this->table_parse();
              }
          }
     else echo 'you must enter a table or all tables or all files to make changes';  
     echo NL."tables used: $this->NL $this->tables_used";
     echo 'print directory: '. $this->output_dir;
     $dir_list=printer::dir_list($this->output_dir,true);
     printer::horiz_print($dir_list);
     if (isset($_POST['print_other'])&& is_dir($_POST['print_other'])){
          echo 'print directory: '. $_POST['print_other'];
          $dir_list=printer::dir_list($_POST['print_other'],true);
          printer::horiz_print($dir_list);
          }
     else if (isset($_POST['print_other'])) echo 'Invalid Directory ' .$_POST['print_other'];
     if (isset($_POST['print_source'])&& $_POST['print_source']==1){
         echo 'print directory: '. $this->source_dir;
         $dir_list=printer::dir_list($this->source_dir,true);
         printer::horiz_print($dir_list);
         }   
     }
    
 function dir_parse_files(){
    $dir = rtrim($this->source_dir, "/") ."/";   
	if ($directory_handle = opendir($dir)) {
	   while (($file_handle = readdir($directory_handle)) !== false) {  
		  if (check_data::validate_image_type($file_handle,$dir)){
			 if (strpos($file_handle,' ')){
				$newfile_handle=str_replace(' ','',$file_handle);
				rename($dir.$file_handle,$dir.$newfile_handle);   
				$file_handle=$newfile_handle;
				}
	  
			 $this->file=$file_handle;
			 $this->photo_resize();
			 }
		  }
	   }
    }
    
function table_parse(){
     $this->mysqlinst->dbconnect($this->dbname);
     $q = "SELECT  bigname,  pic_order FROM $this->tablename  ORDER BY pic_order ASC";
     $r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
     if (!($this->mysqlinst->affected_rows())) {
          echo 'Invalid data retreval for tablename is '.$this->tableanme;
          return;
          } 
     while (list($this->file, $this->pic_order)=$this->mysqlinst->fetch_row($r,__LINE__)){
         if (!is_file($this->source_dir.$this->file)){
             echo NL. "the file $this->source_dir$this->file was not found";
             continue;
             }
          $this->photo_resize(true); 
          }
     }
     
function set_photo_resize(){  // works directoly on photo_resize without panel
    //use_photo_resize.php
     $widths='800';
	$widths=explode(',',$widths);
     $fns='seashell10.jpg,seashell13.jpg,seashell16.jpg,seashell19.jpg,seashell21.jpg,seashell24.jpg,seashell26.jpg,seashell29.jpg,seashell31.jpg,seashell35.jpg,seashell5.jpg,seashell8.jpg,seashell11.jpg,seashell14.jpg,seashell17.jpg,seashell1.jpg,seashell22.jpg,seashell25.jpg,seashell27.jpg,seashell2.jpg,seashell32.jpg,seashell3.jpg,seashell6.jpg,seashell9.jpg,seashell12.jpg,seashell15.jpg,seashell18.jpg,seashell23.jpg,seashell26.jpg,seashell28.jpg,seashell30.jpg,seashell33.jpg,seashell4.jpg,seashell7.jpg,seashell.jpg';	
	$fns=explode(',',$fns);
	$this->output_dir='gailmailresized/';
	$this->source_dir='gail_large/';
	$this->pic_quality=95;
	$this->set_height=0;
	$this->pic_plus=0;
	$this->watermark='';
	foreach ($fns as $fn){
          if(!is_file($this->source_dir.$fn)){
               echo $this->source_dir.$fn.' not found' ;
               continue;
               }
          }
     foreach ($fns as $fn){ echo $fn .' is being resized';
          foreach ($widths as $width){
              $this->basename_ext=$this->set_width=$width;
              $this->file=$fn;
              $this->photo_resize();
              }
          }
     }
    		   
function photo_resize($flag=false){   
     (!is_dir($this->output_dir))&&mkdir($this->output_dir,0770);
     $this->output_dir=trim($this->output_dir,'/').'/';
     $this->source_dir=trim($this->source_dir,'/').'/';
     $resize= new image();
     list($this->width,$this->height,$this->file)=$resize->image_resize($this->file,$this->set_width, $this->set_height, $this->pic_plus,$this->source_dir, $this->output_dir, 'file', $this->watermark, $this->pic_quality); 
     if ($this->basename_ext!=''){
          $path_parts = pathinfo($this->file);
          $newfile = $path_parts['filename'].$this->basename_ext.'.'. $path_parts['extension'];
          rename($this->output_dir.$this->file,$this->output_dir. $newfile);
          //echo $path_parts['basename'], "\n"; // since PHP 5.2.0
          // $path_parts['dirname'], "\n";
          }
     if ($flag&&$this->update_db){ 
          $q="update $this->tablename SET width=$this->width, height=$this->height where bigname='$this->file' and pic_order=$this->pic_order";
          $this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
          }
     }
     
} //end class 
?>