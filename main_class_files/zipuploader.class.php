<?php
#ExpressEdit 2.0
class zipuploader  {
	protected $maxfilesize='250000000';
	private $exxt='zip,gz,bz2,bz';
	protected $mime='application/x-bzip,application/x-bzip2,application/octet-stream,application/zip,application/x-zip-compressed,application/x-zip-compressed,application/x-gzip,application/x-winzip,application/x-zip,multipart/x-zip,application/gzip,application/gzip-compressed,application/gzipped,application/x-gzip-compressed';
	protected $uploads_dir='../uploads/';
	 
function __construct(){ 
      $load=new fullloader(); 
     $load->fullpath('strictheader.nometa.php');
      $java=new javascript('Checkzipfiles','print');
      echo $java->javascript_return;
      echo'
      <link href="../program.css" rel="stylesheet" type="text/css" > 
      </head>
      <body >
      <div class="container"> 
      <div class="spacer"></div>';
      
	
      if  (isset($_POST['submitted'])) {
	       $instructions="Maximum filesize of  $this->maxfilesize/1000000 Mb has been exceeded.";
	       $instructions.= ' Only the zip gz bz bz2 filetype  will work';
	      list ($uploadverification,$fiupl)=upload::upload_file($this->mime,$this->exxt,$instructions,Cfg_loc::Root_dir.Cfg::Upload_dir);
	      if ($uploadverification){  //upload verification is true if file uploaded in include uploadthis then do image and database
		      $msg='Your file: '.$fiupl.' has been uploaded';
		      printer::alert_pos($msg);
		      mail::alert('uploaded alert: '.$fiupl, 'uploaded file alert');
		      }
		 else {
		       $msg='your file has not uploaded';
		       printer::alert_neg($msg);
		       mail::alert('upload failure: '.$fiupl, 'uploaded failure alert');
		       exit('Upload failure try again');
			}
	       }
      $vars=get_defined_vars();
      
      $instructions='Only a filetype '.$this->exxt.' will work.  You can easily convert any filetype to a zip file';
	  
       
       
	  $max_file_size=	$this->maxfilesize;
	  $max=$max_file_size/1000000; 
	 $instructions="<br>The maximimum Picture file size is limited to $max Mb.".$instructions;
       echo '<div style="width:600px; margin: 0 auto;">';
      printer::alert_conf($instructions,'483168',1.3); 
       
       
      echo '
      <form style="width: 600px; margin:0 auto; text-align:center" enctype="multipart/form-data" action="'.Sys::Self.'" method="post" onsubmit="return Checkzipfiles(this);">
      <p><input type="hidden" name="MAX_FILE_SIZE" value="'.$max_file_size.'"></p>
      <fieldset><legend> Upload file</legend> 
      <p><b>File:</b> <input id="fileinput" style="color: #483168;" type="file" name="upload" ></p>
      <p><input type="submit" name="submit" value="Submit" ></p> 
<p><input type="hidden" name="submitted" value="TRUE" ></p>
      </fieldset> 
	
      </form>
      </div></div>
      </body>
      </html>';
      }#end function construct	
}#end class
?>