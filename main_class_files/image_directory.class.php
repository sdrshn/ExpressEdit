<?php # Script 10.3 - upload_image.php 	
class image_directory {
  //onsubmit="return confirm(\'' .$msg. ' do you wish to proceed?\');"  $msg ='You have chosen to clone '.Cfg::Owner. ' database to testsite and foreign Arrays'; $msg=  'You have chosen to update css and jsArray info'; $msg= 'You are generating new files based on tablenames from Root directory..  Will also update testsite and foreign databases';
   private $gall_only=true; 
function build(){
    include_once ('includes/Sys.php');
       if(isset($dbname))$this->dbname=$dbname;
    $this->NL=NL;
    $this->photo_flag=true;
    $this->mailinst=mail::instance(); 
    $this->mysqlinst = mysql::instance();
     (Cfg_loc::Domain_extension!='')&& exit('This program is meant to run in root directory!');
    $this->tablearray=check_data::return_galleries(__METHOD__,__LINE__,__FILE__) ;#use all tables false=no skipping
    if(isset($_POST['image_dir']))
    $this->process_dir();
	   else {
	   echo '
	   <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
	   "http://www.w3.org/TR/html4/strict.dtd">
	   <html lang="en">
	   <head>
	   <title>Image Directory</title></head>
	   <body>
	   <form action="'. Sys::Self.'" method="post">    
	   <p class="ramana">Enter the Directory to view images: <input type="text" name="direct" 
	   size="60" maxlength="100" /></p> 
	    <p><input name="dir_only" type="radio" value="1" />Click to View Directory Images</p>
	   <p><input name="gall_only" type="radio" value="1" />Click to Include all files</p>
	   <p><input name="all_tables" type="radio" value="1" />Click to Use All tables</p>';
    echo ' Choose the tables to print out';
    foreach ($this->tablearray as $tablename){
	   echo'<p class="ramana" style="text-align: left;"><input type="checkbox" id="'. $tablename.'" name="'. $tablename.'"/>Select '. $tablename.'</p>';
	   }
    echo 
	   '<p><input type="submit" name="submit" value="Submit" /></p>
	   <p><input type="hidden" name="image_dir" value="TRUE" /></p>
	   </form>
	   </div>
	   </body>
	   </html>';
	   }
    }//end construct$tablename='gallery';//will use Cfg:Large_Pic_Plus which takes priority

 
function  process_dir(){   
     if (isset($_POST['direct'])) {
	  $this->direct= Cfg_loc::Root_dir. trim($_POST['direct'], "/") ."/";  #rtrim does right only whereas trim takes care of both
	  
	   echo 'am trying to acess ' . $this->direct;
	   if (!is_dir($this->direct))exit('failed to access this directory');
	   }
    else {
	  $this->direct= Sys::Home_pub;
	   }
    echo  NL."Directory is ". $this->direct.NL;
    $this->dir_list=printer::dir_list($this->direct,$this->gall_only);
    if (isset($_POST['dir_only'])){
	  if (isset($_POST['gall_only'])) $this->gall_only=false;
	   $dir_list=printer::dir_list($this->direct,$this->gall_only); 
	  printer::horiz_print($dir_list);
	   }
    if (isset($_POST['all_tables'])){
	    echo " this all tables is true";
	   foreach ($this->tablearray as $this->tablename){
		  $this->table_parse();
		  }
	   }
    else 
	    
	   foreach ($this->tablearray as $this->tablename){
		  if (isset($_POST[$this->tablename])){
			 $this->table_parse();
			 }
		  }
	
    }
    
 
function table_parse(){
    $table_array=array();
    echo NL. "Listing for $this->tablename".NL;
    $this->mysqlinst->dbconnect($this->dbname);
    $q = "SELECT  bigname,  pic_order FROM $this->tablename  ORDER BY pic_order ASC";
     $r=$this->mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
    if (!($this->mysqlinst->affected_rows())) {
	   echo 'Invalid data retreval for tablename is '.$this->tablename;
	   return;
	   } 
  	 
    while (list($this->file, $this->pic_order)=$this->mysqlinst->fetch_row($r,__LINE__)){
	    if (!is_file($this->direct.$this->file)){
		  echo NL. "the file $this->direct $this->file was not found for  $this->tablename";
		  continue;
		  }

	   foreach ($this->dir_list as $listing){ // echo "$this->file is file and ".$listing['name']." is listing name"; 
		  if ($listing['name']==$this->file){   
			 $table_array[]=$listing;
			 }
		  }
	   }
	
	 printer::horiz_print($table_array);     
    }		   
 
}  
?>