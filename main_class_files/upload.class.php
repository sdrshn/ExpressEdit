<?php
#ExpressEdit 2.0.1
 class upload{
     
static function upload_file($val_type,$val_ext,$instructions,$upload_dir='../uploads'){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
      process_data::write_to_file(Cfg_loc::Root_dir.'testing','testing');
      $upload_dir=(!empty($upload_dir))?rtrim($upload_dir,'/').'/':'';
	$sess= session::instance(); 
	$formcount= (isset($_POST['multi_file_upload']))?$_POST['multi_file_upload']:'';
	if  (Sys::Debug) Sys::debug(__LINE__,__METHOD__,__FILE__);
	$uploadverification=false;
     
     if (isset($_FILES['upload'.$formcount])) { 
		if  (Sys::Debug) Sys::debug(__LINE__,__METHOD__,__FILE__);
          $allow_type=(!is_array($val_type)) ? explode(',',$val_type):$val_type;		    
          $allow_ext=(!is_array($val_ext)) ? explode(',',$val_ext):$val_ext;		 
          $msg='';
          if ($_FILES['upload'.$formcount]['error'] > 0) {if  (Sys::Debug) Sys::debug(__LINE__,__METHOD__,__FILE__);
               switch ($_FILES['upload'.$formcount]['error']) {
                    case 1:
                         $msg= 'The file exceeds the upload_max_filesize setting in php.ini. There is information concerning changing the filesize upload limits on upload page you used to browse the image. Check the  Upload Filesize Limit info link <br>';
                         break;
                    case 2:
                         $msg= "case2: ".$instructions." end instruction";
                         break;
                    case 3:
                         $msg= 'The file was only partially uploaded.';
                         break;
                    case 4:
                         $msg= 'No file was uploaded.';
                         break;
                    case 6:
                         $msg= 'No temporary folder was available.';
                         break;
                    case 7:
                         $msg= 'Unable to write to the disk.';
                         break;
                    case 8:
                         $msg= 'File upload stopped.';
                         break;
                    default:
                         $msg= 'A system error occurred.';
                         break;
                    }
               }
		try {
               if ((!empty( $msg))||empty($_FILES['upload'.$formcount]['name'])) {  
                    $msg.= "YOUR UPLOAD HAS FAILED: PLEASE TRY AGAIN";
                    throw new mail_exception($msg);
                    }
               }
		catch(mail_exception $me){
			$me->exception_message();
			if (is_file($_FILES['upload'.$formcount]['tmp_name'])) unlink ($_FILES['upload'.$formcount]['tmp_name']);
			exit($msg);
			}   
          $validated=false; 
          $filenm=strtolower($_FILES['upload'.$formcount]['name']);  
          $path_parts = pathinfo($filenm);
          if ( isset($path_parts['extension'])){
               $ext=$path_parts['extension'];    
               foreach ($allow_ext as $var){
                    if ($ext===$var){
                         $validated=true;
                         }  
                    }
               } //if isset extension  
          if (in_array($_FILES['upload'.$formcount]['type'], $allow_type) && $validated) {
			if  (Sys::Debug) Sys::debug(__LINE__,__METHOD__,__FILE__);
			$newname=str_replace(array(')','(','-'),'_',$_FILES['upload'.$formcount]['name']);
			$newname = preg_replace('/[^a-zA-Z0-9_\.]/', '',$newname);
			if (Sys::Debug) echo  "<p style=\"font-size: 1em;color:#00ff00;\">$newname is newname</p>";
			(substr($newname,0,1)==='-')&&$newname=substr_replace($newname,"",0,1);
			(substr($newname,0,1)==='_')&&$newname=substr_replace($newname,"a__",0,1);  
			$newfile=$upload_dir.$newname; //hasn't been moved yet
			if(is_file($newfile)){
			$tryname=$newname;
			$i=1;
				While (is_file($upload_dir.$tryname)){
					$i++;
					$tryname=pathinfo($newname)['filename'].'_'.$i.'.'.pathinfo($newname)['extension']; 
					}
				$newname=$tryname;  
				$newfile=$upload_dir.$newname; 
				} 
			if (move_uploaded_file($_FILES['upload'.$formcount]['tmp_name'], $newfile)) { //store the temp file to uploads directory
				$uploadverification=true; 
				$fiupl=$newname;// the name without the directory			   
				$array=array('file -b --mime-type ','xdg-mime query filetype ');
				$last_line='';
				foreach($array as $arr){  
					$last_line.=" using $arr found: ".exec("$arr ".	$newfile );
					}
				$msg="fn: $newname & phpType: ".$_FILES['upload'.$formcount]['type']." &  $last_line finaldirfile is $newfile";
				(Sys::Debug)&&printer::alert($msg); 
				mail::success("successful upload msg fn: $newname");
				} // End of move... IF.
			 // Delete the file if it still exists:
               if (file_exists ($_FILES['upload'.$formcount]['tmp_name']) && is_file($_FILES['upload'.$formcount]['tmp_name']) ) {
                    unlink ($_FILES['upload'.$formcount]['tmp_name']);
                    }
               } //if in array
          else { print_r($allow_type);
               $mailmsg=$_FILES['upload'.$formcount]['type']. ' is file mime which failed';
               mail::alert($mailmsg,'Error Alert with Uploads ');
               mail::alert2($mailmsg,'Error Alert with Uploads ');
               $msg='PLEASE DOUBLE CHECK THE FILETYPE YOU ARE UPLOADING, USE filetypes with extension ' .$val_ext.' only';
               exit ($msg . ' An Upload Error Occured Please Try Again');
               }	//else
          } // End of isset($_FILES['upload']) IF.
	else {
		mail::alert('$_FILES["upload'.$formcount.'"]  not found');
		return false;
		}
    return array($uploadverification,$newname);
    }//function construct
    
} //class uploads
?>